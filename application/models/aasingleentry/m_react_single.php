<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_react_single extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		}

		public function load_dumy_data(){

			$upc = $this->input->post('upc');

			//$items = $this->db->query("SELECT BARCODE_NO  ,EBAY_ITEM_ID  FROM LZ_BARCODE_MT WHERE ROWNUM<=6")->result_array(); 
			// $items = $this->db->query("SELECT 'null' ACTIONS,S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID, C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) AND ROWNUM <=5
			// 	/*AND S.PURCHASE_DATE BETWEEN TO_DATE('11/01/2018', 'MM/DD/YY') AND TO_DATE('12/01/2018 ', 'MM/DD/YY')*/ ORDER BY S.PURCHASE_DATE DESC ")->result_array();
			$upc_query = $this->db->query("SELECT ITEM_MT_DESC DESCR, LZ_MANIFEST_ID, CONDITIONS_SEG5, ITEM_MT_MFG_PART_NO, TRIM(ITEM_MT_UPC) ITEM_MT_UPC, ITEM_MT_MANUFACTURE, ITEM_MT_BBY_SKU, E_BAY_CATA_ID_SEG6 FROM (SELECT * FROM LZ_MANIFEST_DET DT WHERE UPPER(DT.ITEM_MT_UPC) = '$upc' AND DT.E_BAY_CATA_ID_SEG6 NOT IN ('N/A', 'OTHER', 'OTHER', 'OTHER') AND DT.E_BAY_CATA_ID_SEG6 IS NOT NULL AND DT.LAPTOP_ITEM_CODE IS NOT NULL ORDER BY DT.LZ_MANIFEST_ID DESC) WHERE ROWNUM = 1 ")->result_array(); 

			if(count($upc_query) >0){
			
			return array('upc_query'=>$upc_query,'exist'=>true);

		}else{
			
			return array('upc_query'=>$upc_query ,'exist'=>false);
		}


			
		}

		public function load_single_entry($single_entry_id,$se_radio){

			// var_dump('loaded');
			// return array('query'=>$query)
			// exit;
		 	$barcode_arr = [];
			$seed_id_arr = [];
			$date_qry = null;
			$order_by = null;
		 	if(empty($single_entry_id) && empty($se_radio)){
		 		
		 		$query = "SELECT (SELECT BARCODE_NO FROM (SELECT B.BARCODE_NO FROM LZ_SINGLE_ENTRY SD, LZ_MANIFEST_MT M,LZ_BARCODE_MT B WHERE SD.ID = S.ID AND SD.ID = M.SINGLE_ENTRY_ID AND M.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID ORDER BY B.BARCODE_NO ASC) WHERE ROWNUM <=1)BARCODE_NO,S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) "; $from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
				$order_by =" ORDER BY S.ID DESC";
		 		$se_radio = 'Not_Listed'; 
		 		$this->session->set_userdata('se_radio', $se_radio);

		 	}elseif(empty($single_entry_id) && !empty($se_radio)){
		 		if($se_radio == 'Listed'){
		 			$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NOT NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) ";
		 			$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
					$to = date('m/d/Y');
					$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
					$order_by =" ORDER BY S.PURCHASE_DATE DESC"; 
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}elseif ($se_radio == 'Not_Listed') {
		 			$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+)";
		 			$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
					$to = date('m/d/Y');
					$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
					$order_by =" ORDER BY S.PURCHASE_DATE DESC";

		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}elseif($se_radio == 'All') {
		 			//$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE S.ID = M.SINGLE_ENTRY_ID";
		 			$query = "SELECT S.*, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, C.ID CONDITION_ID,C.COND_NAME, I.SEED_ID, I.APPROVED_DATE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_ITEM_COND_MT C, LZ_ITEM_SEED I, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID)) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND MANF.ITEM_ID = I.ITEM_ID(+) AND  MANF.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID(+) AND C.ID = I.DEFAULT_COND(+) ";
		 			$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 			//$group =" ";
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}	
		 	}elseif(!empty($single_entry_id)){
		 		$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID, OB.OBJECT_NAME,C.ID CONDITION_ID,C.COND_NAME FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_BD_OBJECTS_MT OB, LZ_ITEM_COND_MT C WHERE S.ID = M.SINGLE_ENTRY_ID AND S.OBJECT_ID = OB.OBJECT_ID(+) AND UPPER(S.CONDITIONS_SEG5) = UPPER(C.COND_NAME) AND S.ID = $single_entry_id"; $group =" ";
				$query = $this->db->query($query);
		 		$query = $query->result_array();
		 		return array('query'=>$query, 'barcode_qry'=>$barcode_arr, 'seed_id_qry'=>$seed_id_arr);
		 		

		 	}else{
			 	$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
	
		} //last else close
			
			$query = $this->db->query($query. " " . $date_qry . $order_by);

		 	$query = $query->result_array();

		foreach($query as $cond){
			//var_dump($query);exit;
			if(!empty($cond['CONDITION_ID'])){

                $condition_id = @$cond['CONDITION_ID'];   

		 		$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
		 		
		 		if($barcode_qry->num_rows() > 0){
		 			$barcode_qry = $barcode_qry->result_array();

		 		array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
		 		}else{
			 		$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND ROWNUM = 1");
			 			$barcode_qry = $barcode_qry->result_array();
			 			//var_dump($barcode_qry);exit;

			 		array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);		 		
		 		}
		 	}else{
		 		//$barcode_qry = null;
		 		array_push($barcode_arr, null);
		 		//return array('query'=>$query, 'barcode_qry'=>$barcode_arr);
		 	}	
		 		

		} //END FOREACH		
		//var_dump($cond['ITEM_ID'],$cond['LZ_MANIFEST_ID'],$condition_id);exit;
		//var_dump($seed_id_arr);exit;
		
		return array('query'=>$query, 'barcode_qry'=>$barcode_arr);				 

		}		


		public function save_single_entry(){

			 //$loading_no = $this->input->post('loading_no');
		  $item_bin = trim($this->input->post('item_bin'));//Assign bin location	
		    $this->session->set_userdata('item_bin',$item_bin);
		 
		  $purch_ref = $this->input->post('purch_ref');
		  $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
          $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 

		  $suplier_desc = $this->input->post('suplier_desc');
		  $suplier_desc = trim(str_replace("  ", ' ', $suplier_desc));
          $suplier_desc = trim(str_replace(array("'"), "''", $suplier_desc));

		  $remarks = $this->input->post('remarks');
		  $remarks = trim(str_replace("  ", ' ', $remarks));
          $remarks = trim(str_replace(array("'"), "''", $remarks));
          //var_dump($skip_test);exit;
          if(empty($remarks)){
          	$remarks = "";
          }
		  $purchase_date ='12/14/2018';// $this->input->post('purchase_date');
		  $purchase_date= "TO_DATE('".$purchase_date."', 'MM/DD/YYYY')";

		  $serial_no = $this->input->post('serial_no');
		  $serial_no = trim(str_replace("  ", ' ', $serial_no));
          $serial_no = trim(str_replace(array("'"), "''", $serial_no));

		  $manufacturer = $this->input->post('manufacturer');
		  $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
          $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));

          $list_date = "NULL";
		  $lot_ref = $this->input->post('lot_ref');
		  $lot_ref = trim(str_replace("  ", ' ', $lot_ref));
          $lot_ref = trim(str_replace(array("'"), "''", $lot_ref));

		  $upc = $this->input->post('upc');
		  $upc = trim(str_replace("  ", ' ', $upc));
          $upc = trim(str_replace(array("'"), "''", $upc));
          if(!is_numeric($upc)){
		  	$upc = '';
		  }

		  $sku = $this->input->post('sku');
		  $sku = trim(str_replace("  ", ' ', $sku));
          $sku = trim(str_replace(array("'"), "''", $sku));

		  $price = $this->input->post('active_price');
          if(empty($price)){
          	$price = "NULL";
          }		  
		  $cost_price = $this->input->post('cost_price');

		  $part_no = $this->input->post('part_no');
		  $part_no = trim(str_replace("  ", ' ', $part_no));
          $part_no = trim(str_replace(array("'"), "''", $part_no));

		  $title = $this->input->post('title');
		  $title = trim(str_replace("  ", ' ', $title));
          $title = trim(str_replace(array("'"), "''", $title));

          $main_category = $this->input->post('main_category');
		  $main_category = trim(str_replace("  ", ' ', $main_category));
          $main_category = trim(str_replace(array("'"), "''", $main_category));
		  $sub_cat = $this->input->post('sub_cat');
		  $sub_cat = trim(str_replace("  ", ' ', $sub_cat));
          $sub_cat = trim(str_replace(array("'"), "''", $sub_cat));
		  $category = $this->input->post('category_name');
		  $category = trim(str_replace("  ", ' ', $category));
          $category = trim(str_replace(array("'"), "''", $category));

		  $origin = $this->input->post('origin');
		  $origin = trim(str_replace("  ", ' ', $origin));
          $origin = trim(str_replace(array("'"), "''", $origin));

          $skip_test = $this->input->post('skip_test');
          if(empty($origin)){
          	$origin = "";
          }
		  $condition = $this->input->post('default_condition');
		  // var_dump($condition);
		  // exit;
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }

		  $ebay_item_id = '';
		  $user_name =2;
		  // $user_name = $this->input->post('user_name');
		  // $user_name = trim(str_replace("  ", ' ', $user_name));
    //       $user_name = trim(str_replace(array("'"), "''", $user_name));

		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));

		  $job_no = $this->input->post('job_no');

		  $category_id = $this->input->post('category_id');
		  $shipping_service = $this->input->post('shipping_service');

		  //********************************************************************************
		  // code section added by adil asad jan-8-2018 in case of par no not assigned start
		  //********************************************************************************
		  $insert_by ='2';// $this->session->userdata('user_id');
		  //$insert_by = $this->session->userdata('user_id');
		  date_default_timezone_set("America/Chicago");
		  $date = date('Y-m-d H:i:s');
		  $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

		  $object_des = $this->input->post('Object');
		  $object_des = trim(str_replace("  ", ' ', $object_des));
          $object_des = trim(str_replace(array("'"), "''", $object_des));

          	
          $get_obj = $this->db->query("SELECT OB.OBJECT_ID FROM LZ_BD_OBJECTS_MT OB WHERE UPPER(OB.OBJECT_NAME) =upper('$object_des') and ob.category_id =$category_id ");
          	if($get_obj->num_rows() > 0 ){

	          	$get_obj = $get_obj->result_array();
				$get_obj = $get_obj[0]['OBJECT_ID'];
				$object_des = $get_obj;
				
				$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV= '$shipping_service' ,WEIGHT = $ounces WHERE OBJECT_ID = $object_des");

			}else{			


				$obj_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
	  			$get_mt_pk = $obj_id->result_array();
	  			$object_id = $get_mt_pk[0]['OBJECT_ID'];

	  			$this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID,SHIP_SERV,WEIGHT) VALUES($object_id, '$object_des',$insert_date,$insert_by, $category_id, '$shipping_service', $ounces)");

	  			// $this->db->query("SELECT OB.OBJECT_ID  FROM LZ_BD_OBJECTS_MT OB WHERE OBJECT_ID =$object_id ");
	  			// $get_mt_pk = $obj_id->result_array();
	  			// $obj_id = $get_mt_pk[0]['OBJECT_ID'];

	  			$object_des = $object_id; //storing object id
	  		// 	var_dump($object_des);
				 // exit;
		}			


		if(empty($part_no)){
		  		$get_mpn = $this->db->query("SELECT MPN_GENERATION($category_id) as MPN FROM DUAL");
					$get_mpn = $get_mpn->result_array();
					$get_mpn = $get_mpn[0]['MPN'];		  
				 	$get_mpn = trim(str_replace("  ", ' ', $get_mpn));
		      $get_mpn = trim(str_replace(array("'"), "''", $get_mpn));

          $get_catalg_id = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO  MPN FROM ITEMS_MT T WHERE T.Item_Mt_Upc = '$upc'");

			  if($get_catalg_id->num_rows() > 0) {

			  	$get_exist_mpn = $get_catalg_id->result_array();
				$get_exist_mpn = $get_exist_mpn[0]['MPN'];
				$part_no = $get_exist_mpn; // ASSIGN TO PART NUMBER IF AVAILABLE IN LZ_CATALOGUE_MT

				$check_catalogue_mt = $this->db->query("SELECT CATALOGUE_MT_ID, MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$part_no') and CATEGORY_ID = $category_id");

					if($check_catalogue_mt->num_rows() > 0){
					  	$catalogue_mpn = $check_catalogue_mt->result_array();
						$catalogue_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
						//$part_no = $catalogue_mpn;
						if(!empty($upc)){
								$this->db->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$upc',object_id = $object_des  WHERE CATALOGUE_MT_ID = $catalogue_mt_id");
						}

					}else{

			          	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
			          	$get_pk = $get_mt_pk->result_array();
			          	$cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];



			          	$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $category_id, $insert_date, $insert_by,$object_des,'$title','$manufacturer','$upc')");

			          	$part_no = $get_mpn; // assign newly created part no

					} //check_catalogue_mt else closing



			  }else{
			  	
	          	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
	          	$get_pk = $get_mt_pk->result_array();
	          	$cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];



	          	$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $category_id, $insert_date, $insert_by,$object_des,'$title','$manufacturer','$upc')");

							$part_no = $get_mpn; // assign newly created part no

			 } //get_catalg_id else closing
        }else{
        	$get_mpn = $part_no;
        	$check_catalogue_mt = $this->db->query("SELECT CATALOGUE_MT_ID, MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$part_no') and CATEGORY_ID = $category_id");

					if($check_catalogue_mt->num_rows() > 0){
					  $catalogue_mpn = $check_catalogue_mt->result_array();
						$catalogue_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
						//$part_no = $catalogue_mpn;
						if(!empty($upc)){
								$this->db->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$upc',object_id = $object_des WHERE CATALOGUE_MT_ID = $catalogue_mt_id");
						}

					}else{

			          	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
			          	$get_pk = $get_mt_pk->result_array();
			          	$cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

			          	$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$get_mpn', $category_id, $insert_date, $insert_by,$object_des,'$title','$manufacturer','$upc')");


									//$part_no = $get_mpn; // assign newly created part no

							} //check_catalogue_mt else closing
        }// empty part no ifelse closing
		  //******************************************************************************
		  // code section added by adil asad jan-8-2018 in case of par no not assigned end
		  //******************************************************************************

		  $comma = ',';
		  $query = $this->db->query("SELECT get_single_primary_key('LZ_SINGLE_ENTRY','ID') ID FROM DUAL");
	      $rs = $query->result_array();
	      $loading_no = $rs[0]['ID'];
		//var_dump($loading_no."-".$purch_ref."-".$suplier_desc."-".$remarks."-".$purchase_date);exit;

			/*=============================================
			=            Create auto Purchase Ref No.            =
			=============================================*/
		  $query = $this->db->query("SELECT PURCHASE_REF_NO FROM LZ_SINGLE_ENTRY WHERE id = (SELECT max(id) FROM LZ_SINGLE_ENTRY)");
	      $rs = $query->result_array();
	      $purch_ref = $rs[0]['PURCHASE_REF_NO'];
	      $str = explode('-', $purch_ref);
	      if(count($str) > 1){
		      $last_num = end($str);
		      $date = date('d-M-y');
	          $current_date = strtoupper($date);
		      $last_date = $str[0].'-'.$str[1].'-'.$str[2];
		      if($last_date == $current_date){
		      	$count = $last_num + 1;
		      	$purch_ref = strtoupper($date.'-'. $count);
		      }else{
		      	$purch_ref = strtoupper($date.'-'. 1);
		      }
	      }else{
          $date = date('d-M-y');
          //$current_date = strtoupper($date);
          $purch_ref = strtoupper($date.'-'. 1);
        }
			/*=====  End of Create auto Purchase Ref No.  ======*/

		/*=====  Bin Assignment section start  ======*/    	 
		$bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, DECODE(B.BIN_TYPE, 'TC', 'TC', 'PB', 'PB', 'WB', 'WB', 'AB', 'AB', 'DK', 'DK', 'NA', 'NA') || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$item_bin'");
		$result = $bin_id_qry->result_array();
		$bin_id = @$result[0]['BIN_ID'];		

		/*=====  Bin Assignment section end  ======*/

    	$qry_sef = "INSERT INTO LZ_SINGLE_ENTRY (ID, PURCHASE_REF_NO, SUPPLIER_ID, REMARKS, PURCHASE_DATE, SERIAL_NO, ITEM_MT_MANUFACTURE, LIST_DATE, PO_DETAIL_LOT_REF, ITEM_MT_UPC, ITEM_MT_BBY_SKU, PRICE, PO_DETAIL_RETIAL_PRICE, ITEM_MT_MFG_PART_NO, ITEM_MT_DESC, MAIN_CATAGORY_SEG1, SUB_CATAGORY_SEG2, BRAND_SEG3, ORIGIN_SEG4, CONDITIONS_SEG5, AVAILABLE_QTY, WEIGHT_KG, EBAY_ITEM_ID, LISTER, PO_MT_REF_NO, JOB_NO, CATEGORY_ID, OLD_BARCODE, POS_ONLY ,OBJECT_ID, BIN_ID) VALUES($loading_no $comma '$purch_ref' $comma $suplier_desc $comma '$remarks' $comma $purchase_date $comma '$serial_no' $comma '$manufacturer' $comma $list_date $comma '$lot_ref' $comma '$upc' $comma '$sku' $comma $price $comma $cost_price $comma '$part_no' $comma '$title' $comma '$main_category' $comma '$sub_cat' $comma '$category' $comma '$origin' $comma '$condition' $comma $avail_qty $comma $ounces $comma '$ebay_item_id' $comma '$user_name' $comma '$po_mt_ref_no' $comma '$job_no' $comma $category_id $comma NULL $comma 0 $comma $object_des $comma '$bin_id' )";
    	//print_r($qry_sef);exit;
        $this->db->query($qry_sef);

         $pic_aprov = $this->input->post('pic_aprov');

		
        

        $qry_id = "SELECT M.LZ_MANIFEST_ID,M.SINGLE_ENTRY_ID FROM LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID=(SELECT MAX(T.ID) FROM LZ_SINGLE_ENTRY T)";
    	//print_r($qry_sef);exit;
        $query=$this->db->query($qry_id);
        $rs = $query->result_array();

        $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
		$single_entry_id = $rs[0]['SINGLE_ENTRY_ID'];

	    $action = "post";
	    $this->manf_post($lz_manifest_id,$action);
	    $this->skip_test($lz_manifest_id,$skip_test,$condition);

	     if($pic_aprov == 1){

		$get_seed = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S, (SELECT * FROM (SELECT B.ITEM_ID, B.CONDITION_ID, MM.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT MM, LZ_BARCODE_MT B WHERE MM.SINGLE_ENTRY_ID = '$single_entry_id' AND MM.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID) WHERE ROWNUM <= 1) B WHERE S.ITEM_ID = B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.DEFAULT_COND = B.CONDITION_ID")->result_array();

		  	$seed_id = @$get_seed[0]['SEED_ID'];
			//$seed_id = trim($this->input->post('seed_id'));
		    date_default_timezone_set("America/Chicago");
		    $date = date('Y-m-d H:i:s');
		    $ins_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
		    $entered_by =2;// $this->session->userdata('user_id');

		 	$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = '$seed_id'");

		  	}
	    
	    return true;

		}
		function skip_test($lz_manifest_id,$skip_test,$condition){
		 	$skip_test =$skip_test;// $this->input->post('skip_test');
		 	$condition = $condition;//strtoupper($this->input->post('default_condition'));
		 // 	var_dump($condition);
		 // 	exit;
		 	$cond_qry = $this->db->query("SELECT ID FROM LZ_ITEM_COND_MT WHERE UPPER(COND_NAME) = '$condition'");
			$result = $cond_qry->result_array();
			$condition_id = @$result[0]['ID'];
			if($skip_test == 'Yes'){
			//var_dump($skip_test);
	            // if(@$condition == 'Used'){
	            //   @$condition = 3000;
	            // }elseif(@$condition == 'New'){
	            //   @$condition = 1000; 
	            // }elseif(@$condition == 'New other'){
	            //   @$condition = 1500; 
	            // }elseif(@$condition == 'Manufacturer Refurbished'){
	            //     @$condition = 2000;
	            // }elseif(@$condition == 'Seller Refurbished'){
	            //   @$condition = 2500; 
	            // }elseif(@$condition == 'For Parts or Not Working'){
	            //   @$condition = 7000; 
	            // }

	    		$cond_qry = "UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = '$condition_id' WHERE  B.LZ_MANIFEST_ID = $lz_manifest_id";
	    		//var_dump($cond_qry);exit;
				$this->db->query($cond_qry);        	
	        }
		 }

		function manf_post($lz_manifest_id,$action){
        if($action=='unpost'){
            $unpost = "call Pro_Unpost_Manifest($lz_manifest_id)";
            $unpost = $this->db->query($unpost);
            echo "Manifest Unpost Succsessfully";
            $del_seed = "delete from lz_item_seed s where s.lz_manifest_id = $lz_manifest_id ";
            $this->db->query($del_seed);

        }elseif($action=='post'){
                $post = "call Pro_Laptop_Zone($lz_manifest_id)";
                $qry_mt = $this->db->query($post);

                if(!empty($qry_mt)){
                    $qry_mt = "UPDATE LZ_MANIFEST_MT SET POSTED = 'Posted' WHERE LZ_MANIFEST_ID =  $lz_manifest_id ";
                    $qry_mt = $this->db->query($qry_mt);
                }
            }
        }




		public function load_condion(){
			$condition_quer = $this->db->query("SELECT C.ID,C.COND_NAME FROM LZ_ITEM_COND_MT C ORDER BY C.ID ASC")->result_array();

			$ship_quer = $this->db->query("SELECT S.SHIPING_NAME FROM LZ_SHIPING_NAME S ORDER BY S.ID ASC")->result_array();

			$rs = $this->db->query("SELECT * FROM (SELECT PURCHASE_REF_NO, ID LOADING_NO FROM LZ_SINGLE_ENTRY ORDER BY ID DESC) WHERE   ROWNUM = 1")->result_array();
		  	$get_purch_ref = $rs[0]['PURCHASE_REF_NO'];
		  	$load_num = $rs[0]['LOADING_NO']+1;


		   $purch_ref = $get_purch_ref;
                      $str = explode('-', $purch_ref);
                      if(count($str) > 1){
                        $last_num = end($str);
                        $date = date('d-M-y');
                        $current_date = strtoupper($date);
                        $last_date = $str[0].'-'.$str[1].'-'.@$str[2];
                        if($last_date == $current_date){
                         $count = $last_num + 1;
                         $purch_ref = strtoupper($date.'-'. $count);
                        }else{
                         $purch_ref = strtoupper($date.'-'. 1);
                        }
                      }else{
                        $date = date('d-M-y');
                        //$current_date = strtoupper($date);
                        $purch_ref = strtoupper($date.'-'. 1);
                      } 

			return array('condition_quer'=>$condition_quer,'ship_quer'=>$ship_quer,'load_num' => $load_num, 'purch_ref' => $purch_ref);
		}
	}
?>