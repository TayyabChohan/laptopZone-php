<?php 

	class Search_Model extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	 	public function getSearchResults($search){
	  	$this->db->select("TILE,ITEM_DESC,ITEM_CODE");
	  	//$whereCondition = array('ITEM_CONDITION' =>$search);
	  	//$this->db->where($whereCondition);
	  	$this->db->from('VIEW_LZ_LISTING'); 
	  	$query = $this->db->get();
	  	return $query->result_array();
	 	}
	 	 

public function queryData($perameter){

if(is_numeric($perameter)){
	
	$str = strlen($perameter);//if length = 12 its ebay id
	if($str== 12){
//$query = $this->db->query("SELECT BB.BARCODE_NO, TO_CHAR(M.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, M.LIST_ID, M.STATUS, M.LIST_PRICE, M.LISTER_ID, S.SEED_ID, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE, C.COND_NAME FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, EBAY_LIST_MT M, LZ_BARCODE_MT BB, LZ_ITEM_COND_MT C, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.EBAY_ITEM_ID LIKE '$perameter' /* added by adil */ AND BC.BARCODE_NO NOT IN (65337, 65359, 65435, 65426, 65422, 65420, 65457, 65484, 65517, 76592) /**/ GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID AND S.ITEM_ID = M.ITEM_ID(+) AND S.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID(+) AND BB.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND S.DEFAULT_COND = M.ITEM_CONDITION(+) AND S.DEFAULT_COND = C.ID AND M.EBAY_ITEM_ID = '$perameter'");
$query = $this->db->query("SELECT BB.BARCODE_NO, TO_CHAR(M.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, M.LIST_ID, M.STATUS, M.LIST_PRICE, M.LISTER_ID, S.SEED_ID, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, S.F_MPN MFG_PART_NO, /*.ITEM_MT_MFG_PART_NO MFG_PART_NO,*/ I.ITEM_MT_BBY_SKU SKU_NO, S.F_UPC UPC, /*I.ITEM_MT_UPC UPC,*/ BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE, C.COND_NAME, R.BUISNESS_NAME FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, EBAY_LIST_MT M, LZ_BARCODE_MT BB, LZ_ITEM_COND_MT C, lj_merhcant_acc_dt a, lz_merchant_mt r, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.EBAY_ITEM_ID LIKE '$perameter' /* added by adil */ AND BC.BARCODE_NO NOT IN (65337, 65359, 65435, 65426, 65422, 65420, 65457, 65484, 65517, 76592) /**/ GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID AND S.ITEM_ID = M.ITEM_ID(+) AND S.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID(+) AND BB.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND S.DEFAULT_COND = M.ITEM_CONDITION(+) AND S.DEFAULT_COND = C.ID AND R.MERCHANT_ID(+) = A.MERCHANT_ID AND M.LZ_SELLER_ACCT_ID = A.ACCT_ID(+) AND M.EBAY_ITEM_ID = '$perameter'"); 
}else{
		$check_seed = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B , LZ_ITEM_SEED S WHERE S.ITEM_ID = B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.DEFAULT_COND = B.CONDITION_ID AND B.BARCODE_NO = '$perameter'");
		if($check_seed->num_rows() > 0){
			//seed available do do nothing
		}else{
			$get_cond = $this->db->query("SELECT B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = '$perameter'")->result_array();
			$condition_id = @$get_cond[0]['CONDITION_ID'];
			/*=========================================================
			=            create seed by updating condition            =
			=========================================================*/
			$this->db->query("UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = -1 WHERE B.BARCODE_NO = '$perameter'");
			$this->db->query("UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = '$condition_id' WHERE B.BARCODE_NO = '$perameter'");
			/*=====  End of create seed by updating condition  ======*/
		}

		//$query = $this->db->query("SELECT BB.BARCODE_NO, TO_CHAR(M.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, M.LIST_ID, M.STATUS, M.LIST_PRICE, M.LISTER_ID, S.SEED_ID, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE, C.COND_NAME FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, EBAY_LIST_MT M, LZ_BARCODE_MT BB, LZ_ITEM_COND_MT C, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.BARCODE_NO LIKE '$perameter'/* added by adil */ AND BC.BARCODE_NO NOT IN (65337, 65359, 65435, 65426, 65422, 65420, 65457, 65484, 65517, 76592) /**/ GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID AND S.ITEM_ID = M.ITEM_ID(+) AND S.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID(+) AND BB.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND BB.BARCODE_NO LIKE '$perameter'AND S.DEFAULT_COND = M.ITEM_CONDITION(+) AND S.DEFAULT_COND = C.ID ");
		$query = $this->db->query("SELECT BB.BARCODE_NO, TO_CHAR(M.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, M.LIST_ID, M.STATUS, M.LIST_PRICE, M.LISTER_ID, S.SEED_ID, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, S.F_MPN MFG_PART_NO, /*.ITEM_MT_MFG_PART_NO MFG_PART_NO,*/ I.ITEM_MT_BBY_SKU SKU_NO, S.F_UPC UPC, /*I.ITEM_MT_UPC UPC,*/ BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE, C.COND_NAME, R.BUISNESS_NAME FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, EBAY_LIST_MT M, LZ_BARCODE_MT BB, LZ_ITEM_COND_MT C, LZ_MERCHANT_MT R, LJ_MERHCANT_ACC_DT A, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.BARCODE_NO LIKE '$perameter' /* added by adil */ AND BC.BARCODE_NO NOT IN (65337, 65359, 65435, 65426, 65422, 65420, 65457, 65484, 65517, 76592) /**/ GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID AND S.ITEM_ID = M.ITEM_ID(+) AND S.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID(+) AND BB.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BB.ITEM_ID = I.ITEM_ID AND R.MERCHANT_ID(+) = A.MERCHANT_ID  AND M.LZ_SELLER_ACCT_ID = A.ACCT_ID(+) AND BB.BARCODE_NO LIKE '$perameter'AND S.DEFAULT_COND = M.ITEM_CONDITION(+) AND S.DEFAULT_COND = C.ID "); }
 	


	if($query->num_rows() > 0){
		$query = $query->result_array();
		$hold_qry = $this->db->query("SELECT B.HOLD_STATUS,B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $perameter");
		$hold_qry = $hold_qry->result_array();


	}else{
		$query = $this->db->query("SELECT L.BARCODE, L.ITEM_CONDITION, L.ITEM_TITLE ITEM_MT_DESC, L.REMARKS,TO_CHAR(L.DEL_DATE, 'DD/MM/YYYY HH24:MI:SS') as DEL_DATE , E.USER_NAME,L.ITEM_ID,
       L.LZ_MANIFEST_ID FROM LZ_DELETION_LOG L, EMPLOYEE_MT E WHERE L.BARCODE = '$perameter' AND E.EMPLOYEE_ID = L.DELETED_BY"); 
		if($query->num_rows() > 0){
		$query = $query->result_array();

		}else{$query = "SELECT '' BARCODE_NO, S.SEED_ID, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE, C.COND_NAME FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, LZ_ITEM_COND_MT C, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID AND S.DEFAULT_COND = C.ID"; 
			$perameter = "AND (I.ITEM_ID like '%$perameter%' or I.ITEM_CODE like '%$perameter%' or upper(I.ITEM_DESC) like '%$perameter%' or upper(I.ITEM_MT_MANUFACTURE) like '%$perameter%' or upper(I.ITEM_MT_MFG_PART_NO) like '%$perameter%' or I.ITEM_MT_BBY_SKU like '%$perameter%' or I.ITEM_MT_UPC like '%$perameter%' or upper(LM.PURCH_REF_NO) like '%$perameter%' or BCD.LZ_MANIFEST_ID like '%$perameter%')";
			$query = $this->db->query($query." ".$perameter. " ORDER BY BCD.LZ_MANIFEST_ID DESC");
			$query = $query->result_array();
		}
	
	}
}else{
 
		$query = "SELECT '' BARCODE_NO, S.SEED_ID, LM.SINGLE_ENTRY_ID, LM.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, TRIM(I.ITEM_MT_MFG_PART_NO) MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, TRIM(I.ITEM_MT_UPC) UPC, BCD.EBAY_ITEM_ID, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, QRY_PRICE.COST_PRICE, C.COND_NAME FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, LZ_ITEM_COND_MT C, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID AND S.DEFAULT_COND = C.ID"; 
		$perameter = "AND (I.ITEM_ID like '%$perameter%' or I.ITEM_CODE like '%$perameter%' or upper(I.ITEM_DESC) like '%$perameter%' or upper(I.ITEM_MT_MANUFACTURE) like '%$perameter%' or upper(I.ITEM_MT_MFG_PART_NO) like '%$perameter%' or I.ITEM_MT_BBY_SKU like '%$perameter%' or I.ITEM_MT_UPC like '%$perameter%' or upper(LM.PURCH_REF_NO) like '%$perameter%' or BCD.LZ_MANIFEST_ID like '%$perameter%')";
		$query = $this->db->query($query." ".$perameter. " ORDER BY BCD.LZ_MANIFEST_ID DESC");
		$query = $query->result_array();

	}

	$path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $path_query =  $path_query->result_array();

	$barcode_arr = [];
	 //var_dump($query);exit;
      foreach($query as $cond){
      	//var_dump($cond['CONDITION_ID']);exit;
        if(!empty($cond['ITEM_CONDITION'])){
          	$condition_id = @$cond['ITEM_CONDITION'];

        	//$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID,MT.CONDITION_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id);
       		$barcode_qry = $this->db->query("SELECT DISTINCT MT.*, TD.LZ_BARCODE_ID FROM LZ_BARCODE_MT MT, LZ_TESTING_DATA TD WHERE TD.LZ_BARCODE_ID(+) = MT.BARCODE_NO AND MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id);
        	if($barcode_qry->num_rows() > 0){
          		$barcode_qry = $barcode_qry->result_array();
          		foreach ($barcode_qry as $barcode) {
          			array_push($barcode_arr, @$barcode);
          		}
				// var_dump($barcode_arr);
				// exit;
        		
      		}
        
      	}elseif(empty($cond['ITEM_CONDITION'])){
	      	//$barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID,MT.CONDITION_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']);
	        $barcode_qry = $this->db->query("SELECT DISTINCT MT.*, TD.LZ_BARCODE_ID FROM LZ_BARCODE_MT MT, LZ_TESTING_DATA TD WHERE TD.LZ_BARCODE_ID(+) = MT.BARCODE_NO AND MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID IS NULL ");
	        if($barcode_qry->num_rows() > 0){
	          $barcode_qry = $barcode_qry->result_array();
	          foreach ($barcode_qry as $barcode) {
          			array_push($barcode_arr, @$barcode);
          		}

//	        array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
    		}
        }else{
	        //$barcode_qry = null;
	        array_push($barcode_arr, null);
        
        }       
		//break;
    } //END FOREACH    
   // exit;

     if(empty($hold_qry)){
     	$hold_qry = null;
     }

      $path_2 = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
      $path_2 =  $path_2->result_array();

	  $user_list = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID NOT IN(1, 6, 7, 8, 9, 10, 11, 15, 16, 18, 19, 20, 25, 27, 28, 30, 31, 32) ORDER BY EMPLOYEE_ID ASC");
	  $user_list = $user_list->result_array();          

    return array('query'=>$query,'path_query' => $path_query, 'barcode_qry'=>$barcode_arr,'hold_qry'=>$hold_qry, 'path_2'=>$path_2, 'user_list'=>$user_list);
   }
	 	public function queryRadio($seed_radio,$list_radio){
			//$main_query = "select t.* from view_lz_listing_revised t";
			$main_query = "select t.item_pic,decode(s.item_title, null, t.item_mt_desc, s.item_title) item_title,t.Manufacturer,t.MFG_Part_No,t.SKU_No,t.UPC,decode(s.default_cond, null, t.item_condition, s.default_cond) item_condition,t.Not_List_Qty,t.SALV_QTY,t.COST_US,t.list_price,t.SalValue,t.laptop_item_code,t.PURCH_REF_NO,t.purchase_date,t.AVAIL_QTY,t.LIST_QTY,t.LZ_MANIFEST_ID,t.it_barcode,t.item_id from view_lz_listing_revised t, lz_item_seed s";
			$qry_condition = "";
	 		if($list_radio == 'Completely Listed' && $seed_radio == 'Available' ){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is not null and s.lz_manifest_id is not null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = 0";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 			//$check = $this->session->userdata('Completely Listed', $list_radio);
	 			//$check = $this->session->userdata('Available', $seed_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Completely Listed' && $seed_radio == 'Not Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = 0";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Completely Listed' && $seed_radio == 'Both'){
	 			$qry_condition = " where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = 0 and t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Partially Listed' && $seed_radio == 'Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is not null and s.lz_manifest_id is not null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) between 1 and (AVAIL_QTY-1)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Partially Listed' && $seed_radio == 'Not Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) between 1 and (AVAIL_QTY-1)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Partially Listed' && $seed_radio == 'Both'){
	 			$qry_condition = " where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) between 1 and (AVAIL_QTY-1) and t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Not Listed' && $seed_radio == 'Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is not null and s.lz_manifest_id is not null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = AVAIL_QTY";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Not Listed' && $seed_radio == 'Not Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null and AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = AVAIL_QTY";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'Not Listed' && $seed_radio == 'Both'){
	 			$qry_condition = " where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = AVAIL_QTY and t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+) and t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'All' && $seed_radio == 'Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+) and t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is not null and s.lz_manifest_id is not null ";
		 		$this->session->set_userdata('seed', $seed_radio);
		 		$this->session->set_userdata('list', $list_radio);
		 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();

	 		}elseif($list_radio == 'All' && $seed_radio == 'Not Available'){
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+) and t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($list_radio == 'All' && $seed_radio == 'Both'){
	 			$qry_condition = "where t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif ($list_radio == 'Completely Listed') {
	 			$qry_condition = " where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = 0";
	 			$this->session->set_userdata('list', $list_radio);
	 			// $query =$this->db->query( "select * from VIEW_LZ_LISTING_REVISED where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = 0");
	 			//return $query->result_array();
	 		}elseif($list_radio == 'Partially Listed'){
	 			$qry_condition = " where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) between 1 and (AVAIL_QTY-1)";
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->query( "select * from VIEW_LZ_LISTING_REVISED where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) between 1 and (AVAIL_QTY-1)");
				// return $query->result_array();
	 		}elseif($list_radio == 'Not Listed'){
	 			$qry_condition = " where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = AVAIL_QTY";
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->query( "select * from VIEW_LZ_LISTING_REVISED where AVAIL_QTY -(NVL(LIST_QTY, 0) + NVL(SALV_QTY, 0)) = AVAIL_QTY");
				// return $query->result_array();
	 		}elseif($list_radio == 'All'){
	 			$qry_condition = "where t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+)";
	 			$this->session->set_userdata('list', $list_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}elseif($seed_radio == 'Available')
	 		{
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is not null and s.lz_manifest_id is not null";
	 			$this->session->set_userdata('radio', $seed_radio);
		 			//$query =$this->db->query( "$main_query "." $qry_condition ");
	 			//return $query->result_array();

	 		}elseif ($seed_radio == 'Not Available') {
	 			$qry_condition = " where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null";
	 			$this->session->set_userdata('seed', $seed_radio);
	 			// $query =$this->db->query( "  select * from VIEW_LZ_LISTING_REVISED lz_item_seed s where t.item_id = s.item_id(+) and t.lz_manifest_id = s.lz_manifest_id(+) and s.item_id is null and s.lz_manifest_id is null");
	 			// return $query->result_array();
	 		}elseif($seed_radio == 'Both'){
	 			$qry_condition = "where t.item_id = s.item_id(+) and t.LZ_MANIFEST_ID =s.LZ_MANIFEST_ID(+)";
	 			$this->session->set_userdata('seed', $seed_radio);
	 		// 	$query = $this->db->get('VIEW_LZ_LISTING_REVISED');
				// return $query->result_array();
	 		}
	 		$from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
			$to = date('m/d/Y');
			$date_qry = "AND t.purchase_date between TO_DATE('$from','MM/DD/YY') and TO_DATE('$to ','MM/DD/YY')";
	 		$query = $this->db->query( $main_query." ".$qry_condition." ".$date_qry);
			//var_dump($query->result_array());exit;
			return $query->result_array();

			
	 	}
 	public function getthisitem($barcode){

		//$query = $this->db->query("select V.*, ebay.list_id,ebay.list_date, EBAY.ebay_item_id,ebay.list_price,ebay.LZ_SELLER_ACCT_ID from VIEW_LZ_LISTING_REVISED V, (SELECT EBL.* FROM EBAY_LIST_MT EBL,(SELECT MAX(T.LIST_ID) LIST_ID FROM EBAY_LIST_MT T GROUP BY T.ITEM_ID, T.LZ_MANIFEST_ID ) MAX_EBAY WHERE EBL.LIST_ID = MAX_EBAY.LIST_ID) EBAY WHERE V.item_id = EBAY.ITEM_ID(+) AND V.LZ_MANIFEST_ID = EBAY.LZ_MANIFEST_ID(+) AND V.IT_BARCODE ='+$barcode' order by v.purchase_date desc ");
		$query = $this->db->query("select t.*,q.listed_qty from VIEW_LZ_LISTING_REVISED t,(select sum(t.list_qty) listed_qty from VIEW_LZ_LISTING_REVISED t where t.it_barcode = '+$barcode') q where t.it_barcode = '+$barcode' and ROWNUM = 1 order by t.list_date desc");


  	return $query->result_array();
 	}
 	public function holdBarcode(){
		$barcode = $this->input->post('barcode_no');
		$barcodeStatus = 1;
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		
			//foreach($hold_barcode as $barcode){
				$check_status = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO =$barcode AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL");
				
				 if($check_status->num_rows()>0){
					$get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
					$get_pk = $get_pk->result_array();
					$lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
						
					$qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma $barcodeStatus $comma $user_id)";
					$this->db->query($qry);


		    		$hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = $barcodeStatus WHERE BARCODE_NO = $barcode ";
					$hold_status = $this->db->query($hold_qry);

				}else{
					$hold_status = true;
					$barcodeStatus = 2;
				}
			//}//barcode foreach
		if($hold_status){
			return $barcodeStatus;
		}else {
			return false;
		}

	}
	public function unHoldBarcode(){
		$barcode = $this->input->post('barcode_no');
		$barcodeStatus = 0;
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		
			//foreach($hold_barcode as $barcode){
				// $check_status = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO =$barcode AND HOLD_STATUS = 0");
				
				// if($check_status->num_rows()>0){
					$get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
					$get_pk = $get_pk->result_array();
					$lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
						
					$qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma $barcodeStatus $comma $user_id)";
					$this->db->query($qry);


		    		$hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = $barcodeStatus WHERE BARCODE_NO = $barcode ";
					$hold_status = $this->db->query($hold_qry);

				// }else{
				// 	$hold_status = true;
				// }
			//}//barcode foreach
		if($hold_status){
			return $barcodeStatus;
		}else {
			return false;
		}

	}

}



 ?>