<?php
class m_kit_analysis extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function loadkits(){
	$requestData= $_REQUEST;
	$columns = array( 
     0 =>'KIT_PRICE',
     1 =>'TOTAL_COMPONENTS',
     2 =>'CATALOGUE_MT_ID',
	   3 =>'MPN_DESCRIPTION',
	   4 =>'CREATED_DATE'
    );
    $search_val = $this->input->post('search_val');
    if ($search_val == 10) {
    	$sql = "SELECT C.CATALOGUE_MT_ID, MAX(C.MPN) MPN, MAX(C.MPN_DESCRIPTION) MPN_DESCRIPTION, MAX(C.INSERTED_DATE) CREATED_DATE, COUNT(DISTINCT M.PART_CATLG_MT_ID) TOTAL_COMPONENTS, B.KIT_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_BD_RSS_FEED_URL T, (SELECT SUM(A.AVG_PRICE) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, MPN_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B, LZ_CATALOGUE_MT C WHERE T.CATLALOGUE_MT_ID = M.CATALOGUE_MT_ID AND C.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND M.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND C.CATEGORY_ID IN(177, 179, 111422, 111418, 179697)";
       }elseif ($search_val == 20) {
    	$sql = "SELECT C.CATALOGUE_MT_ID, MAX(C.MPN) MPN, MAX(C.MPN_DESCRIPTION) MPN_DESCRIPTION, MAX(C.INSERTED_DATE) CREATED_DATE, COUNT(DISTINCT M.PART_CATLG_MT_ID) TOTAL_COMPONENTS, B.KIT_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_BD_RSS_FEED_URL T, (SELECT SUM(A.AVG_PRICE) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, MPN_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B, LZ_CATALOGUE_MT C WHERE T.CATLALOGUE_MT_ID = M.CATALOGUE_MT_ID AND C.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND M.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND M.AUTO_KIT = 2 AND C.CATEGORY_ID IN(177, 179, 111422, 111418, 179697)"; 
    }elseif($search_val == 30){
    	$sql ="SELECT C.CATALOGUE_MT_ID, MAX(C.MPN) MPN, MAX(C.MPN_DESCRIPTION) MPN_DESCRIPTION, MAX(C.INSERTED_DATE) CREATED_DATE, COUNT(DISTINCT M.PART_CATLG_MT_ID) TOTAL_COMPONENTS, B.KIT_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_BD_RSS_FEED_URL T, (SELECT SUM(A.AVG_PRICE) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, MPN_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B, LZ_CATALOGUE_MT C WHERE T.CATLALOGUE_MT_ID = M.CATALOGUE_MT_ID AND C.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND M.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND T.CATLALOGUE_MT_ID NOT IN (SELECT M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_RSS_FEED_URL T, MPN_AVG_PRICE A WHERE T.CATLALOGUE_MT_ID = M.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = A.CATALOGUE_MT_ID(+) AND M.AUTO_KIT = 2) AND C.CATEGORY_ID IN(177, 179, 111422, 111418, 179697)";
       }
       
    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter  
	      $sql.=" AND (C.MPN LIKE '%".$requestData['search']['value']."%' ";    
	      $sql.=" OR M.MPN_DESCRIPTION LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR M.CREATED_DATE LIKE '%".$requestData['search']['value']."%') "; 
	  }

	   $sql.= " GROUP BY C.CATALOGUE_MT_ID, B.KIT_PRICE";

	   $query = $this->db2->query($sql);
     $totalData = $query->num_rows();
     $totalFiltered = $totalData; 
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )"; 
    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    $data = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[] 	= $row['MPN'];
      $nestedData[] 	= $row['MPN_DESCRIPTION'] ;
      $nestedData[] 	= '<a class="show_comps show_detail" rd ="'.$i.'" id="total_comps_'.$i.'" mpn="'.$row['CATALOGUE_MT_ID'].'" style="padding:12px;">'.$row['TOTAL_COMPONENTS'].'</a>';
      $kit_price 		= number_format((float)$row['KIT_PRICE'], 2, '.', '');
      $nestedData[] 	= "$".$kit_price;
      $nestedData[] 	= $row['CREATED_DATE'] ;
      $data[] 			= $nestedData;
      $i++;
    }
 
    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading" =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          
          );
    return $json_data; 
}
public function loadNonKits(){
	$requestData= $_REQUEST;
	$columns = array( 
      0 =>'CATALOGUE_MT_ID',
      1 =>'MPN_DESCRIPTION',
      2 =>'CATEGORY_ID'
    );
    $sql = "SELECT DISTINCT M.CATALOGUE_MT_ID, M.CATEGORY_ID, M.MPN, M.MPN_DESCRIPTION FROM LZ_BD_RSS_FEED_URL U, LZ_CATALOGUE_MT M WHERE U.CATLALOGUE_MT_ID IS NOT NULL AND U.CATLALOGUE_MT_ID = M.CATALOGUE_MT_ID(+) AND U.CATLALOGUE_MT_ID NOT IN(SELECT  DISTINCT K.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT K, LZ_BD_RSS_FEED_URL T WHERE T.CATLALOGUE_MT_ID =  K.CATALOGUE_MT_ID) AND M.CATEGORY_ID IN(177, 179, 111422, 111418, 179697)";

     if(!empty($requestData['search']['value'])) {
     // if there is a search parameter, $requestData['search']['value'] contains search parameter
	      $sql.=" AND (M.MPN LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR M.MPN_DESCRIPTION LIKE '%".$requestData['search']['value']."%' ";   
        $sql.=" OR M.CATEGORY_ID LIKE '%".$requestData['search']['value']."%') "; 
	  }

	  $query = $this->db2->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData; 
 
    $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    $data = array();
    $i =0;
    foreach($query as $row ){ 
      $nestedData=array();
      $category_id          = $row['CATEGORY_ID'];
      $catalogue_mt_id      = $row['CATALOGUE_MT_ID'];
      //$condition_id         = $row['CONDITION_ID'];
      $lz_bd_cata_ids = $this->db2->query("SELECT M.LZ_BD_CATA_ID FROM LZ_BD_ACTIVE_DATA_$category_id M WHERE  M.CATALOGUE_MT_ID = $catalogue_mt_id AND ROWNUM = 1 AND M.LZ_BD_CATA_ID IS NOT NULL")->result_array();
      if (count($lz_bd_cata_ids) > 0) {
        $lz_bd_cata_id = $lz_bd_cata_ids[0]['LZ_BD_CATA_ID'];
        $estimate_url = base_url().'catalogueToCash/c_purchasing/kitComponents/'.$category_id.'/'.$catalogue_mt_id.'/'.$lz_bd_cata_id;
        $nestedData[]   = '<a target="_blank" title="Create Estimate" href="'.$estimate_url.'" class="btn btn-info btn-xs">Add Kit</a>';
      }else{
        $nestedData[]   = 'N/A';
      }
      
      $nestedData[] 	= $row['MPN'];
      $nestedData[] 	= $row['MPN_DESCRIPTION'] ;
      $nestedData[] 	= $row['CATEGORY_ID'] ;
      $data[] 			  = $nestedData;
      $i++;
    }

    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          );
    return $json_data; 
}
public function show_components(){
	$catalogue_mt_id = $this->input->post('catalogue_mt_id');
  //var_dump($catalogue_mt_id); exit;
  return $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.CATALOGUE_MT_ID, M.QTY, M.PART_CATLG_MT_ID, C.MPN, A.AVG_PRICE, C.MPN_DESCRIPTION, C.CATEGORY_ID, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O, (SELECT M.PART_CATLG_MT_ID,A.AVG_PRICE FROM LZ_BD_MPN_KIT_MT M , MPN_AVG_PRICE A WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID =  M.PART_CATLG_MT_ID) A WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND  M.PART_CATLG_MT_ID = A.PART_CATLG_MT_ID(+) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID")->result_array(); 
}

}
