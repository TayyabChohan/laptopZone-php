<?php
class m_logs_analysis extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function loadkits(){
	$requestData= $_REQUEST;
	$columns = array( 
     0 =>'FEED_NAME',
     1 =>'MIN_PRICE',
     2 =>'MAX_PRICE',
	   3 =>'KEYWORD',
     4 =>'CATLALOGUE_MT_ID',
	   5 =>'TOTAL_RECORDS'
    );
    $search_val = $this->input->post('search_val');
    	$sql = "SELECT U.FEED_NAME, U.MIN_PRICE, U.MAX_PRICE, U.KEYWORD, U.CONDITION_ID, U.CATLALOGUE_MT_ID, L.TOTAL_RECORDS FROM  LZ_BD_RSS_FEED_URL U , LZ_BD_RSS_FEED_LOG L WHERE U.FEED_URL_ID = L.FEED_URL_ID";
    if( !empty($requestData['search']['value']) ) {  
     // if there is a search parameter, $requestData['search']['value'] contains search parameter  
	      $sql.=" AND (U.FEED_NAME LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR U.MIN_PRICE LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR U.MAX_PRICE LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR U.KEYWORD LIKE '%".$requestData['search']['value']."%' ";  
	      $sql.=" OR U.CATLALOGUE_MT_ID LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR L.TOTAL_RECORDS LIKE '%".$requestData['search']['value']."%') "; 
	  }

	   $query = $this->db2->query($sql);
     $totalData = $query->num_rows();
     $totalFiltered = $totalData; 
     $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
    if( !empty($requestData['search']['value']) ) { 
    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
}
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    $data = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData     = array();
      $nestedData[] 	= $row['FEED_NAME'];
      $nestedData[]   = $row['MIN_PRICE'];
      $nestedData[]   = $row['MAX_PRICE'];
      $nestedData[]   = $row['KEYWORD'];
      $nestedData[]   = $row['CONDITION_ID'];
      $nestedData[]   = $row['CATLALOGUE_MT_ID'];
      $nestedData[] 	= $row['TOTAL_RECORDS'];

      $data[] 			= $nestedData;
      $i++;
    }
if( !empty($requestData['search']['value']) ) { 
    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   
          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" =>  intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            =>  $data   // total data array
          );
}else{
 $json_data = array(
 			    "draw"            =>  intval(''), 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" =>  intval( $totalFiltered ), 
          // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          );
}
    return $json_data; 
}
public function loadNonKits(){
	$requestData= $_REQUEST;
  $columns = array( 
     0 =>'FEED_NAME',
     1 =>'MIN_PRICE',
     2 =>'MAX_PRICE',
     3 =>'KEYWORD',
     4 =>'CATLALOGUE_MT_ID'
    );
    $search_val = $this->input->post('search_val');
      $sql = "SELECT U.FEED_NAME, U.MIN_PRICE, U.MAX_PRICE, U.KEYWORD, U.CONDITION_ID, U.CATLALOGUE_MT_ID FROM LZ_BD_RSS_FEED_URL U WHERE U.FEED_URL_ID NOT IN (SELECT F.FEED_URL_ID FROM LZ_BD_RSS_FEED_LOG F)"; 

      if( !empty($requestData['search']['value']) ) {
     // if there is a search parameter, $requestData['search']['value'] contains search parameter  
        $sql.=" AND (U.FEED_NAME LIKE '%".$requestData['search']['value']."%'";    
        $sql.=" OR U.MIN_PRICE LIKE '%".$requestData['search']['value']."%'";  
        $sql.=" OR U.MAX_PRICE LIKE '%".$requestData['search']['value']."%'";  
        $sql.=" OR U.KEYWORD LIKE '%".$requestData['search']['value']."%'";  
        $sql.=" OR U.CATLALOGUE_MT_ID LIKE '%".$requestData['search']['value']."%')";
    }
     $query = $this->db2->query($sql);
     $totalData = $query->num_rows();
     $totalFiltered = $totalData; 
     $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
    if( !empty($requestData['search']['value']) ) { 
    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
}
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    $data = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData     = array();
      $nestedData[]   = $row['FEED_NAME'];
      $nestedData[]   = $row['MIN_PRICE'];
      $nestedData[]   = $row['MAX_PRICE'];
      $nestedData[]   = $row['KEYWORD'];
      $nestedData[]   = $row['CONDITION_ID'];
      $nestedData[]   = $row['CATLALOGUE_MT_ID'];

      $data[]       = $nestedData;
      $i++;
    }
if( !empty($requestData['search']['value']) ) { 
    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   
          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" =>  intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            =>  $data   // total data array
          );
}else{
 $json_data = array(
          "draw"            =>  intval(''), 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" =>  intval( $totalFiltered ), 
          // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          );
}
    return $json_data; 
}
public function show_components(){
	$catalogue_mt_id = $this->input->post('catalogue_mt_id');
    return $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.CATALOGUE_MT_ID, M.QTY, M.PART_CATLG_MT_ID, C.MPN, A.AVG_PRICE, C.MPN_DESCRIPTION, C.CATEGORY_ID, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O, (SELECT M.PART_CATLG_MT_ID,A.AVG_PRICE FROM LZ_BD_MPN_KIT_MT M , MPN_AVG_PRICE A WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID =  M.PART_CATLG_MT_ID) A WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND  M.PART_CATLG_MT_ID = A.PART_CATLG_MT_ID(+) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID")->result_array(); 
}

}
