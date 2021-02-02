<?php 

  class M_kitsCount extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  }


    public function getCategories(){
	    $sql = "SELECT DISTINCT D.CATEGORY_ID, BD.CATEGORY_NAME, GET_ACTIVE_COUNT(D.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD WHERE  D.CATEGORY_ID = BD.CATEGORY_ID" ;
	    $query = $this->db2->query($sql);
	    $query = $query->result_array();
	    return $query;
	}

	public function getObjects(){
	    $sql = "SELECT DISTINCT O.OBJECT_ID, O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID";
	    $query = $this->db->query($sql);
	    $query = $query->result_array();
	    return $query;
	 }

	public function getAlternateMpn(){
	    $bd_category = $this->input->post('bd_category');
	    $alternated_mpn  = $this->input->post('alternated_mpn');
	    $query = $this->db2->query("SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_CATALOGUE_MT M WHERE M.CATEGORY_ID = $bd_category  AND M.CATALOGUE_MT_ID <> $alternated_mpn "); 
	    return $query->result_array();
	}


	public function getAllObjects(){
     $sql = "SELECT DISTINCT O.OBJECT_ID, O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O";
     $query = $this->db->query($sql);
     $query = $query->result_array();
     return $query;
  	}


  	public function getSpecificMpn(){
      $bd_category = $this->input->post('bd_category');
      // var_dump($bd_category);exit;
      // $sesion_arr=["bd_recog_category"=>$bd_category];
      // $this->session->set_userdata($sesion_arr);
  	  // $bd_category = $this->uri->segment(5);
  	  // var_dump($bd_category);exit;
      $query = $this->db->query("SELECT DISTINCT M.CATALOGUE_MT_ID, M.MPN FROM LZ_CATALOGUE_MT M WHERE M.CATEGORY_ID=$bd_category");
      return $query->result_array();
     
    }


    public function loadBdMpn(){
	    $object_id = $this->input->post('object_id');
	    $sql = "SELECT C.MPN, C.CATALOGUE_MT_ID, O.OBJECT_ID FROM LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = C.OBJECT_ID AND O.OBJECT_ID = $object_id";
	    $sql = $this->db->query($sql);
	    $sql = $sql->result_array();
	    return $sql;
	  }

    public function saveMpnKit(){
    

	    $bd_kit_mpn = $this->input->post('bd_kit_mpn');
	    $part_cata_id = $this->input->post('bd_mpn');
	    $kit_qty = $this->input->post('kit_qty');
	    // $this->session->set_userdata('bd_kit_mpn', $bd_kit_mpn);
	    // print_r($this->session->userdata); exit;
	    //var_dump($catalogue_mt_id, $part_cata_id, $kit_qty); exit;
	    $part_check = $this->db2->query("SELECT M.CATALOGUE_MT_ID,  M.PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $bd_kit_mpn AND M.PART_CATLG_MT_ID = $part_cata_id");
	    if ($part_check->num_rows() == 0) {
	      $query = $this->db2->query("SELECT laptop_zone.get_single_primary_key('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
	      $rs = $query->result_array();
	      $MPN_KIT_MPN = $rs[0]['ID'];
	    //var_dump($bd_alt_main_mpn, $bd_alt_mpn); exit;
	      $det_query = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT(MPN_KIT_MT_ID, CATALOGUE_MT_ID, QTY, PART_CATLG_MT_ID) VALUES($MPN_KIT_MPN, $bd_kit_mpn, $kit_qty, $part_cata_id)");
	      if($det_query){
	          return 1;
	        }else {
	          return 0;
	        }
	    }else{
	          return "exist";
	    }
    
  	}

  	public function getMpnObjectsResult(){
    
	    // $bd_kit_mpn = $this->input->post('bd_kit_mpn');
	    // $this->session->set_userdata('bd_kit_mpn', $bd_kit_mpn);
	    // print_r($this->session->userdata);

	    $bd_kit_mpn = $this->uri->segment(5);
	    if($bd_kit_mpn != ''){
	    $query = $this->db2->query("SELECT O.OBJECT_NAME, C.MPN, M.QTY, M.MPN_KIT_MT_ID,M.PART_CATLG_MT_ID  FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND C.OBJECT_ID = O.OBJECT_ID AND  M.CATALOGUE_MT_ID = $bd_kit_mpn  ");
	      return $query->result_array();
	    }
	  }


	public function deleteMpnObjectResults(){
	    $mpn_kit_mt_id = $this->input->post('mpn_kit_id');
	    $query = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id "); 
	    $del_qry = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_MT WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id ");

	    if($del_qry){
	      return 1;
	    }else{
	      return 0;
	    }

	}

    public function getMpns(){
	    $sql = "SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID AND M.CATEGORY_ID IN ('31569', '175676', '168061', '1244', '16145', '31519', '175669', '31510', '31568', '14295', '20318', '131486', '175668', '56083', '51064', '131511', '171814', '162', '175745', '176982', '33963', '175677', '20357', '180235', '3709', '176973', '168068', '182097')";
	    // $sql = "SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID AND M.CATEGORY_ID = 111422";
	    $query = $this->db->query($sql);
	    $query = $query->result_array();
	    return $query;

	  }

	public function getAltMpns(){
	    $sql = "SELECT K.MPN_KIT_MT_ID,M.MPN FROM LZ_BD_MPN_KIT_MT K,LZ_CATALOGUE_MT M
		WHERE M.CATALOGUE_MT_ID=K.CATALOGUE_MT_ID";
	    $query = $this->db->query($sql);
	    $query = $query->result_array();
	    return $query;
	}

	public function loadData(){

		$category = $this->input->post('category');
		// var_dump($category);exit;
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'MPN',
			1 =>'KIT_COUNT',
			2 => 'OBJECT_COUNT'
		);

		$query = '';
		$totalData = '';
		$totalFiltered = '';


		$qry = "SELECT DISTINCT CM1.CATALOGUE_MT_ID,CM1.MPN MPN, COUNT(*) AS KIT_COUNT, COUNT(DISTINCT MK2.OBJECT_ID) AS OBJECT_COUNT FROM LZ_CATALOGUE_MT CM1 JOIN LZ_BD_MPN_KIT_MT MK1 ON CM1.CATALOGUE_MT_ID = MK1.CATALOGUE_MT_ID JOIN LZ_CATALOGUE_MT MK2 ON MK1.PART_CATLG_MT_ID = MK2.CATALOGUE_MT_ID WHERE CM1.CATALOGUE_MT_ID = CM1.CATALOGUE_MT_ID AND CM1.CATEGORY_ID = $category";

		$sql = "SELECT DISTINCT CM1.CATALOGUE_MT_ID,CM1.MPN MPN, COUNT(*) AS KIT_COUNT, COUNT(DISTINCT MK2.OBJECT_ID) AS OBJECT_COUNT FROM LZ_CATALOGUE_MT CM1 JOIN LZ_BD_MPN_KIT_MT MK1 ON CM1.CATALOGUE_MT_ID = MK1.CATALOGUE_MT_ID JOIN LZ_CATALOGUE_MT MK2 ON MK1.PART_CATLG_MT_ID = MK2.CATALOGUE_MT_ID WHERE CM1.CATALOGUE_MT_ID = CM1.CATALOGUE_MT_ID AND CM1.CATEGORY_ID = $category GROUP BY CM1.CATALOGUE_MT_ID,CM1.MPN"; 


		if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	        $qry.=" AND ( CM1.MPN LIKE '%".$requestData['search']['value']."%' ) GROUP BY CM1.CATALOGUE_MT_ID,CM1.MPN";
	        // $sql.=" OR KIT_COUNT LIKE '%".$requestData['search']['value']."%'";
	        // $sql.=" OR  OBJECT_COUNT LIKE '".$requestData['search']['value']."')";


	        $query = $this->db2->query($qry);
		    $totalData = $query->num_rows();
		    $totalFiltered = $totalData;

		    $qry.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
	    	//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
	    	$qry = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($qry) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;
          
       	}
       	else{
       		$query = $this->db2->query($sql);
		    $totalData = $query->num_rows();
		    $totalFiltered = $totalData;

		      $qry.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    		//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    		$qry = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;
       	}

      	

	  

    	$query = $this->db2->query($qry);

	    $query = $query->result_array();
	    $data = array();

		foreach($query as $row ){ 
	      $nestedData=array();

	     // $nestedData[] ='  <div style="float:left;margin-right:8px;">
	                                
	                        //       <a title="Edit Record" href="'.base_url().'catalogue/c_itemCatalogue/editCatalogue/'.$row['CATALOGUE_MT_ID'].'" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
	                        //       </a>
	                        //       <button title="Delete Record" id="del'.$row['CATALOGUE_MT_ID'].'" class=" del_mpn_data btn btn-danger btn-xs "><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	                        //       </button>
	                            
	                        //       <a class="catalogues_detail" id="'.$row['CATALOGUE_MT_ID'].'" title="Show_Detail"><i style="font-size:21px;margin-top:px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i></a>
	                        // </div>';
	      //.@$row['ITEM_URL']//.

	    $nestedData[] ="<a href='detailView/".$category."/".@$row['CATALOGUE_MT_ID']."/' target='_blank'>".@$row['MPN']."</a>";
	      // $nestedData[] = $row["MPN"];
	     
	      $nestedData[] = $row["KIT_COUNT"];

	      $nestedData[] = $row["OBJECT_COUNT"];

	     
	      
	      // $name = '';
	      // foreach ($result as $listerName) {
	      //   $name.=$listerName['USER_NAME'];
	      // }
	      
	      
	      // $nestedData[]= $row["INSERTED_BY"];
	      // var_dump($result);exit;
	      $data[] = $nestedData;

	    }

	    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading" =>  intval( $totalFiltered ),
          "data"  => $data   // total data array
          
        );
    	return $json_data;

	}

	public function summary(){

		$cat_id = $this->input->post('category');
		$query = $this->db->query("SELECT COUNT(1) kits FROM (SELECT C.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT C, LZ_BD_MPN_KIT_MT K WHERE C.CATEGORY_ID = $cat_id AND C.CATALOGUE_MT_ID = K.CATALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID,K.CATALOGUE_MT_ID)"); 

		$kitsCreated = $query->result_array();

		$qry = $this->db->query("SELECT (REMAIN.MPN - CREATED.KITS) NOT_CREATED FROM (SELECT COUNT(1) KITS FROM (SELECT C.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT C, LZ_BD_MPN_KIT_MT K WHERE C.CATEGORY_ID = $cat_id AND C.CATALOGUE_MT_ID = K.CATALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, K.CATALOGUE_MT_ID))  CREATED, (SELECT COUNT(1) MPN FROM LZ_CATALOGUE_MT WHERE CATEGORY_ID = $cat_id) REMAIN");
		$notCreated = $qry->result_array();

		return array('kitsCreated' => $kitsCreated , 'notCreated' => $notCreated );
	}
}

?>