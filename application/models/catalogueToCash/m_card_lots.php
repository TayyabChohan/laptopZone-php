<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class M_card_lots extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }

/*======================================
=            ADIL METHODS            =
======================================*/



public function serch_desc_sys(){
	$get_desc = strtoupper(trim($this->input->post('get_desc')));

	$str = explode(' ', $get_desc);

	
 
 $desc_sys = "SELECT * FROM (SELECT S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+)";

	 if(!empty($get_desc) ) { 
	    if (count($str)>1) {
	      $i=1;
	      foreach ($str as $key) {
	        if($i === 1){
	          $desc_sys.=" and UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
	        }else{
	          $desc_sys.=" AND UPPER(S.ITEM_TITLE) LIKE '%$key%' ";
	        }
	        $i++;
	      }
	    }else{
	      $desc_sys.=" and UPPER(S.ITEM_TITLE) LIKE '%$get_desc%' ";
	    }
	   }
	   $desc_sys.="  order by s.seed_id desc ) WHERE ROWNUM <=20 ";

	   $desc_sys_quer = $this->db->query($desc_sys)->result_array();


	   if(count($desc_sys_quer) <1 ){ 

	   	$desc_sys = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+)  ) WHERE  MPN is not null  ";

		   	if(!empty($get_desc) ) { 
		    if (count($str)>1) {
		      $i=1;
		      foreach ($str as $key) {
		        if($i === 1){
		          $desc_sys.=" and UPPER(TITLE) LIKE '%$key%' ";
		        }else{
		          $desc_sys.=" AND UPPER(TITLE) LIKE '%$key%' ";
		        }
		        $i++;
		      }
		    }else{
		      $desc_sys.=" and UPPER(TITLE) LIKE '%$get_desc%' ";
		    }
		   }
	   $desc_sys.="  and ROWNUM <=20 ";
	   }
	   $desc_sys_quer = $this->db->query($desc_sys)->result_array();


	   return array('desc_sys_quer' =>$desc_sys_quer,'exist' => true);

}


public function serch_mpn_sys(){
	$card_mpn = strtoupper($this->input->post('card_mpn'));	
 
 $desc_mpn = "SELECT * FROM (SELECT S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) and UPPER(I.ITEM_MT_MFG_PART_NO) LIKE '%$card_mpn%' order by s.seed_id desc ) WHERE ROWNUM <=20";	 

	  $desc_mpn_quer = $this->db->query($desc_mpn)->result_array();

	  if(count($desc_mpn_quer) <1 ){

	   	$desc_mpn = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+) and UPPER(C.MPN) LIKE '%$card_mpn%'  ) WHERE  ROWNUM <=20 ";
	   }

	   $desc_mpn_quer = $this->db->query($desc_mpn)->result_array();

	   return array('desc_mpn_quer' =>$desc_mpn_quer,'exist' => true);

}


public function serch_upc_sys(){
	$card_upc = strtoupper($this->input->post('card_upc'));	
 
 $desc_upc = "SELECT * FROM (SELECT S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) and UPPER(ITEM_MT_UPC) LIKE '%$card_upc%' order by s.seed_id desc ) WHERE  ROWNUM <=20 ";	 
	 

	$desc_upc_quer = $this->db->query($desc_upc)->result_array();

	   if(count($desc_upc_quer) <1 ){

	   	$desc_upc = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+) and  UPPER(C.UPC) LIKE '%$card_upc%' ) WHERE  ROWNUM <=20 ";
	   }

	   $desc_upc_quer = $this->db->query($desc_upc)->result_array();

	   return array('desc_upc_quer' =>$desc_upc_quer,'exist' => true);
}

public function asign_dkit_list(){


    date_default_timezone_set("America/Chicago");
    $list_date = date("Y-m-d H:i:s");
    $alloc_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $allocated_by = $this->session->userdata('user_id');     
    
     $remarks ='';
    $seed_id = $this->input->post('assign_listing');   
    $assign_to = $this->input->post('get_emp');  //assign to person 

     $comma = ",";


    foreach($seed_id as $id){

    // $query = $this->db->query("SELECT get_single_primary_key('LZ_LISTING_ALLOC','ALLOC_ID') ALLOC_ID FROM DUAL");
    // $rs = $query->result_array();
    // $alloc_id = $rs[0]['ALLOC_ID'];
      
      $query = $this->db->query(" UPDATE LZ_SPECIAL_LOTS  L SET L.ALLOCATE_TO = '$assign_to' ,ALLOC_DATE =$alloc_date ,ALLOCATED_BY ='$allocated_by' WHERE L.BARCODE_PRV_NO = '$id' ");
    }

    if($query){
      return true;
    }else{
    return false;
    }
    

    //var_dump($user_name, $seed_id);exit;
  }

public function obj_dropdown(){

$category = $this->input->post('category');
$obj = $this->db->query("SELECT O.OBJECT_ID, O.OBJECT_NAME,O.CATEGORY_ID,O.SHIP_SERV,O.WEIGHT,O.ITEM_COST FROM LZ_BD_CAT_GROUP_MT M, LZ_BD_CAT_GROUP_DET D, LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_GROUP_ID = D.LZ_BD_GROUP_ID AND M.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.LZ_BD_GROUP_ID = O.LZ_BD_GROUP_ID AND D.CATEGORY_ID = O.CATEGORY_ID AND M.LZ_BD_GROUP_ID = 7")->result_array();

$bin = $this->db->query(" SELECT B.BIN_ID, B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO FROM BIN_MT B WHERE BIN_TYPE <> 'NA'AND BIN_TYPE IN( 'TC','NB', 'PB') ORDER BY BIN_NO ASC ")->result_array();

$conds = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
$merch_nam = $this->db->query("SELECT L.MERCHANT_ID,L.CONTACT_PERSON FROM LZ_MERCHANT_MT L ORDER BY L.MERCHANT_ID ASC")->result_array(); // $rack_bin_id = $this->session->userdata('rack_bin_id');
$merchant_id = $this->session->userdata('merchant_id');
$merch_lot = $this->db->query("SELECT D.LOT_ID,D.LOT_DESC FROM LOT_DEFINATION_MT  D WHERE D.MERCHANT_ID =$merchant_id ")->result_array(); 
$las_brand = $this->db->query(" SELECT * FROM (SELECT SP.BRAND FROM LZ_SPECIAL_LOTS SP, (SELECT BRAND, MAX(SPECIAL_LOT_ID) SPECIAL_LOT_ID , MAX(UPDATED_AT) UPDATED_AT FROM (SELECT L.BRAND, L.SPECIAL_LOT_ID , UPDATED_AT FROM LZ_SPECIAL_LOTS L WHERE L.BRAND IS NOT NULL ORDER BY L.UPDATED_AT DESC ) GROUP BY BRAND ORDER BY UPDATED_AT DESC) LL WHERE SP.SPECIAL_LOT_ID = LL.SPECIAL_LOT_ID ORDER BY SP.UPDATED_AT DESC ) WHERE ROWNUM <=10")->result_array();

$qyer =$this->db->query("SELECT M.EMPLOYEE_ID,M.USER_NAME FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK' AND M.STATUS =1 ")->result_array();

    

// $rack_bin_id = $this->session->userdata('rack_bin_id'); 
// if (empty($rack_bin_id)) {
// 	$rack_bin_id = ''; 
// }
return array('qyer' => $qyer,'obj' => $obj,'bin' => $bin,'conds' => $conds,'merch_nam' => $merch_nam,'merch_lot' => $merch_lot,'las_brand' => $las_brand); 
//}
}


public function add_lot_special_object(){ 
    $obj_cat = $this->input->post('category_id');
    $obj_name = $this->input->post('obj_name');
    $ship_serv = $this->input->post('ship_serv');
    $obj_cost = $this->input->post('obj_cost');
    $obj_weig = $this->input->post('obj_weig');

    $user_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $curr_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


    


    $check_qry = $this->db->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT where upper(object_name) = upper('$obj_name') and category_id = $obj_cat");
    if($check_qry->num_rows() > 0){
    	    $insert = $this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV = '$ship_serv' , WEIGHT = '$obj_weig' , LZ_BD_GROUP_ID = 7 , ITEM_COST = '$obj_cost' WHERE upper(OBJECT_NAME) = upper('$obj_name') and category_id = '$obj_cat'");
    if($insert){
		$check_qry = $this->db->query("SELECT LZ_BD_GROUP_DET_ID FROM LZ_BD_CAT_GROUP_DET where category_id = $obj_cat and LZ_BD_GROUP_ID = 7");
		if($check_qry->num_rows() == 0){
			$qry2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID') GROUP_ID FROM DUAL");
            $qry2 = $qry2->result_array();
            $get_group_id = $qry2[0]['GROUP_ID'];
            $this->db->query ("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) VALUES($get_group_id,7,$obj_cat) ");
            if($qry2){

            	return true;
            }
		}

        
        }

    }else{
    $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT', 'OBJECT_ID')ID FROM DUAL");
    $qry = $qry->result_array();
    $Object_id = $qry[0]['ID'];
    $insert = $this->db->query(" INSERT INTO LZ_BD_OBJECTS_MT D(D.OBJECT_ID, D.OBJECT_NAME, D.INSERT_DATE, D.INSERT_BY, D.CATEGORY_ID, D.ITEM_DESC, D.SHIP_SERV, D.WEIGHT, D.LZ_BD_GROUP_ID, D.ITEM_COST)values($Object_id,'$obj_name',$curr_date,$user_id,$obj_cat,'','$ship_serv',$obj_weig,7,$obj_cost) ");
    if($insert){
        $qry2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_GROUP_DET', 'LZ_BD_GROUP_DET_ID') GROUP_ID FROM DUAL");
            $qry2 = $qry2->result_array();
            $get_group_id = $qry2[0]['GROUP_ID'];
            $this->db->query ("INSERT INTO LZ_BD_CAT_GROUP_DET(LZ_BD_GROUP_DET_ID,LZ_BD_GROUP_ID,CATEGORY_ID) VALUES($get_group_id,7,$obj_cat) ");
            if($qry2){

            	return true;
            }


    }
    }




    //  $result['data'] = $this->m_card_lots->obj_dropdown();
    // $this->load->view('catalogueToCash/v_special_lot_object',$result);
    }

public function update_obj_dropdown(){
$category = $this->input->post('category');
if(!empty($category)){
// $qry = $this->db2->query("SELECT DISTINCT C.CATEGORY_ID,C.CATEGORY_NAME,get_active_count(C.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CATEGORY C");
$obj = $this->db->query("SELECT OBJECT_ID,OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE CATEGORY_ID = 177 order by OBJECT_ID asc ")->result_array(); 
$bin = $this->db->query("SELECT BIN_ID,BIN_NO FROM BIN_MT  order by BIN_ID asc ")->result_array(); 


return array('obj' => $obj,'bin' => $bin);
}
}


  public function master_barcode_det(){
  $master_barcode = $this->input->post('master_barcode');

  if(!empty($master_barcode)){

  
  $master_bar = $this->db->query("SELECT DE.ITEM_MT_DESC, DE.ITEM_MT_MFG_PART_NO, DE.CONDITIONS_SEG5 FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND ROWNUM <=1 ");

   // $master_bar = $this->db->query("SELECT B.BARCODE_NO,B.LZ_MANIFEST_ID,M.SINGLE_ENTRY_ID,S.PURCHASE_DATE, S.ITEM_MT_DESC, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_UPC, S.CONDITIONS_SEG5, S.PO_DETAIL_RETIAL_PRICE, S.AVAILABLE_QTY ,S.CATEGORY_ID FROM LZ_BARCODE_MT B ,LZ_MANIFEST_MT M,/*LZ_BD_TRACKING_NO T,*/LZ_SINGLE_ENTRY S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID  AND  B.BARCODE_NO =$master_barcode and b.barcode_no in (select ba.barcode_no from lz_barcode_mt ba) ");

  if($master_bar->num_rows() > 0){ 
  	$master_bar = $master_bar->result_array();
	 return array('master_bar' => $master_bar);
  }
  
}

}

public function save_mast_barcode(){
	//$this->db->trans_begin();
	// **** variable declaration for insertion into LZ_DEKIT_US_MT,LZ_DEKIT_US_DT start ****
	//**************************************************************************************
	$master_barcode= $this->input->post('master_barcode');
	//var_dump($master_barcode);
	$cond_item = $this->input->post('cond_item');
	$object_desc = $this->input->post('object_desc');
	$bin_rack = $this->input->post('bin_rack');
	$weight_in = $this->input->post('weight_in');
	$dek_remarks = $this->input->post('remarks');
	$user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    // **** variable declaration for insertion into LZ_DEKIT_US_MT,LZ_DEKIT_US_DT end ****
    //************************************************************************************
	// **** variable declaration for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det start*
    //******************************************************************************************
	$get_user = $this->session->userdata('user_id');

	
	// check for items is alredy dekited
	//**********************************
	$load_dekit_check = $this->db->query("SELECT B.BARCODE_NO,B.ITEM_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND ROWNUM <=1 "); 

	//  old check for single entry barcode dekit$load_dekit_check = $this->db->query(" SELECT B.BARCODE_NO,B.ITEM_ID FROM LZ_BARCODE_MT     B, LZ_MANIFEST_MT    M, /*LZ_BD_TRACKING_NO T,*/ LZ_SINGLE_ENTRY   S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID /*AND S.ID = T.LZ_SINGLE_ENTRY_ID*/ AND B.BARCODE_NO =$master_barcode /*and t.lz_estimate_id is null and b.BARCODE_NO not in (SELECT k.barcode_no FROM LZ_DEKIT_US_MT k)*/ "); 

	if ($load_dekit_check->num_rows() > 0) {
		$get_item = $load_dekit_check->result_array();
		$item_id = $get_item[0]['ITEM_ID'];

	$gl_gen = $this->db->query(" SELECT LZ_ITEM_ADJ_BOOK_ID  FROM GL_GEN_PREFERENCES GD ")->result_array(); 
	$gen_id = $gl_gen[0]['LZ_ITEM_ADJ_BOOK_ID'];

	$inv_book_id = $this->db->query(" SELECT S.DEF_LOCATOR_CODE_ID  FROM INV_BOOKS_MT B, SUB_INVENTORY_MT S WHERE INV_BOOK_ID = $gen_id AND B.SUB_INV_ID = S.SUB_INV_ID ")->result_array();
	$def_loc_id = $inv_book_id[0]['DEF_LOCATOR_CODE_ID'];

	$adjus_no =$this->db->query(" SELECT TO_CHAR(SYSDATE,'YY')||'-'|| LPAD('8',4,'0') ADJUST_REF_NO   FROM DUAL ")->result_array();
	$adjus =$adjus_no[0]['ADJUST_REF_NO'];

	$inv_book = $this->db->query(" SELECT DOC_SEQ_ID FROM   INV_SEQUENCE_ASSIGNMENT WHERE  inv_book_id = 8 ")->result_array();
	$seq_id =$inv_book[0]['DOC_SEQ_ID'];
	
	$last = $this->db->query("SELECT LAST_NO +1 LAST_NO, DOC_DET_SEQ_ID FROM   DOC_SEQUENCE_DETAIL WHERE  DOC_DET_SEQ_ID = (SELECT DOC_DET_SEQ_ID FROM   DOC_SEQUENCE_DETAIL WHERE  DOC_SEQ_ID = $seq_id AND TO_DATE('3/1/2017','DD-MM-YYYY') >= FROM_DATE AND TO_DATE('3/1/2017','DD-MM-YYYY') <= TO_DATE AND ROWNUM = 1)")->result_array();
	$last_no = $last[0]['LAST_NO'];
	$doc_det_seq_id = $last[0]['DOC_DET_SEQ_ID'];
	// **** variable declaration for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det end*
    //******************************************************************************************

	

	// **** code for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det start ****
    //**********************************************************************
    $adjs_mt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_MT', 'ITEM_ADJUSTMENT_ID')ID FROM DUAL")->result_array();
	$adjs_mt_pk = $adjs_mt[0]['ID'];

	$insert_adjus_mt = "INSERT INTO ITEM_ADJUSTMENT_MT(ITEM_ADJUSTMENT_ID, INV_BOOK_ID, ADJUSTMENT_NO, ADJUSTMENT_DATE, STOCK_TRANS_YN, REMARKS, 					INV_TRANSACTION_NO, JOURNAL_ID, POST_TO_GL, ENTERED_BY, AUTH_ID, AUTHORIZED_YN, SEND_FOR_AUTH, AUTH_STATUS_ID, 								ADJUSTMENT_REF_NO) 
						VALUES($adjs_mt_pk, 8, $last_no, to_date(sysdate), 0, NULL, NULL, NULL, 0, $get_user, null, 0, 0, 0, '$adjus')";
	$this->db->query($insert_adjus_mt);

	$adjs_det = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL")->result_array();
	$adjs_det_pk = $adjs_det[0]['ID'];

	$insert_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY, 				SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS ) 
						VALUES($adjs_det_pk, $adjs_mt_pk, $item_id, 1, $def_loc_id, -1, NULL, 99, NULL, NULL )"; /// $cost variable query        
	$this->db->query($insert_adjus_det);

	$this->db->query("UPDATE DOC_SEQUENCE_DETAIL  SET LAST_NO =$last_no where DOC_DET_SEQ_ID =$doc_det_seq_id");
	$this->db->query ("UPDATE LZ_BARCODE_MT SET ITEM_ADJ_DET_ID_FOR_OUT = $adjs_mt_pk WHERE BARCODE_NO = $master_barcode");

	// **** code for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_DET end
    //************************************************************************  


	// **** code for insertion into lz_manifest_mt start
    //************************************************************************
    $max_query = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LOADING_NO') ID FROM DUAL");
	        $rs = $max_query->result_array();
	        $loading_no = $rs[0]['ID'];

    // date_default_timezone_set("America/Chicago");
    // $loading_date = date("Y-m-d H:i:s");
    // $loading_date = "TO_DATE('".$loading_date."', 'YYYY-MM-DD HH24:MI:SS')";
    date_default_timezone_set("America/Chicago");
    $loading_date = date("Y-m-d H:i:s");
    $load_date = "TO_DATE('".$loading_date."', 'YYYY-MM-DD HH24:MI:SS')";
    
	$purch_ref_no = 'dk_'.$loading_no;
	$supplier_id = 'null';
	$remarks = $this->input->post('barcode_no');
	$remarks = trim(str_replace("  ", ' ', $remarks));
	$remarks = trim(str_replace(array("'"), "''", $remarks));
	$doc_seq_id = 30;
	$purchase_date = 'null';
	$posted = 'Posted';
	$excel_file_name = 'null';
	$grn_id = 'null';
	$purchase_invoice_id = 'null';
	$single_entry_id = 'null';
	$total_excel_rows = 'null';
	$manifest_name = 'null';
	$manifest_status = 'null';
	$sold_price = 'null';
	$end_date = 'null';
	$lz_offer = 'null';
	$manifest_type = 3; // for dekit-us-pk manifest generation
	$est_mt_id = 'null';

    /*--- Get Single Primary Key for LZ_MANIFEST_MT start---*/
	$get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LZ_MANIFEST_ID') LZ_MANIFEST_ID FROM DUAL");
	$get_mt_pk = $get_mt_pk->result_array();
	$lz_manifest_id = $get_mt_pk[0]['LZ_MANIFEST_ID'];
	/*--- Get Single Primary Key for LZ_MANIFEST_MT end---*/

	/*--- Insertion Query for LZ_MANIFEST_MT start---*/
	$mt_qry = "INSERT INTO LZ_MANIFEST_MT (LZ_MANIFEST_ID, LOADING_NO, LOADING_DATE, PURCH_REF_NO, SUPPLIER_ID, REMARKS, DOC_SEQ_ID, PURCHASE_DATE, POSTED, EXCEL_FILE_NAME, GRN_ID, PURCHASE_INVOICE_ID, SINGLE_ENTRY_ID, TOTAL_EXCEL_ROWS, MANIFEST_NAME, MANIFEST_STATUS, SOLD_PRICE, END_DATE, LZ_OFFER, MANIFEST_TYPE, EST_MT_ID) VALUES($lz_manifest_id , $loading_no , $load_date , '$purch_ref_no' , $supplier_id , '$remarks' , $doc_seq_id , $purchase_date , '$posted' , $excel_file_name , $grn_id , $purchase_invoice_id , $single_entry_id , $total_excel_rows , $manifest_name  , $manifest_status , $sold_price , $end_date , $lz_offer , $manifest_type, $est_mt_id)";
    $mt_qry = $this->db->query($mt_qry);
    /*--- Insertion Query for LZ_MANIFEST_MT end---*/ 

    // **** code for insertion into lz_manifest_mt end
    //************************************************************************
			 

    // **** code for insertion into LZ_DEKIT_US_MT,LZ_DEKIT_US_DT start ******
    //************************************************************************
    $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_MT', 'LZ_DEKIT_US_MT_ID')ID FROM DUAL")->result_array();
	
	$lz_dekit_us_mt_id = $query[0]['ID']; 	

	$save_lz_dekit_us_mt = ("INSERT INTO LZ_DEKIT_US_MT(LZ_DEKIT_US_MT_ID,BARCODE_NO,DEKIT_BY,DEKIT_DATE_TIME,ADJUST_MT_ID,LZ_MANIFEST_MT_ID)
							VALUES($lz_dekit_us_mt_id,$master_barcode,$user_id,$dekit_date,null,null)");
	$save_mt = $this->db->query($save_lz_dekit_us_mt);

	if($save_mt) {
		$i=0;
		foreach ($object_desc as $comp) {

				
    			$dek_remark = trim(str_replace("  ", ' ', $dek_remarks[$i]));
      			
       	 		$dek =str_replace("'", "''", $dek_remark);

				$sequn = $this->db->query("SELECT /*GET_SINGLE_PRIMARY_KEY('LZ_BARCODE_MT','BARCODE_NO')*/SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
				$bar_sq = $sequn[0]['ID'];
                  
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_DT', 'LZ_DEKIT_US_DT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $lz_dekit_us_dt_id = $qry[0]['ID'];
                $insert_est_det = $this->db->query("INSERT INTO LZ_DEKIT_US_DT (LZ_DEKIT_US_DT_ID,LZ_DEKIT_US_MT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,IDENT_DATE_TIME,IDENTIFIED_BY,DEKIT_REMARKS,WEIGHT,CONDITION_ID) 								VALUES($lz_dekit_us_dt_id,$lz_dekit_us_mt_id,$bar_sq,$object_desc[$i],$bin_rack[$i],null,null,null,null,null,'$dek',$weight_in[$i],$cond_item[$i])");
                  $i++;
                } /// end foreach
	}
	// **** code for insertion into LZ_DEKIT_US_MT,LZ_DEKIT_US_DT end ****
	//**********************************************************************

	// QUERY FOR UPDATE ADJUST_MT_ID AND LZ_MANIFEST_MT_ID IN LZ_DEKIT_US_MT
	$this->db->query("UPDATE LZ_DEKIT_US_MT  SET ADJUST_MT_ID ='$adjs_mt_pk' ,LZ_MANIFEST_MT_ID = $lz_manifest_id  where LZ_DEKIT_US_MT_ID = $lz_dekit_us_mt_id");

	//code section for saving master barcode mpn start
	$item_ids = $this->db->query("SELECT K.ITEM_ID FROM LZ_BARCODE_MT K WHERE K.BARCODE_NO = $master_barcode")->result_array();
 	$item_id  = $item_ids[0]['ITEM_ID'];

 	$mpns = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO FROM ITEMS_MT T WHERE T.ITEM_ID = $item_id")->result_array();
 	$mpn  = $mpns[0]['ITEM_MT_MFG_PART_NO'];

 	if (!empty($mpn)) {
 		$item_mpn = strtoupper($mpn);

 		$get_category = $this->db->query("SELECT de.e_bay_cata_id_seg6 CATEGORY_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND ROWNUM <=1 ")->result_array();

 		// old barcode chek$get_category = $this->db->query("SELECT S.CATEGORY_ID FROM LZ_BARCODE_MT B ,LZ_MANIFEST_MT M ,LZ_SINGLE_ENTRY S WHERE B.BARCODE_NO = $master_barcode AND B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID  = S.ID")->result_array();
 		//$get_category->result_array();
 		$category_id  = $get_category[0]['CATEGORY_ID'];
 		
 		if(!empty($category_id)){
 			
 		 $mpn_data = $this->db->query("SELECT MT.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN) = '$item_mpn' AND MT.CATEGORY_ID = $category_id");
 		 

 		//if(!empty($master_mpn_id)){
 		if($mpn_data->num_rows() > 0){
 			  $mpn_data = $mpn_data->result_array();	
 			  $master_mpn_id  = $mpn_data[0]['CATALOGUE_MT_ID'];		
 			$this->db->query("UPDATE LZ_DEKIT_US_MT SET MASTER_MPN_ID = $master_mpn_id WHERE LZ_DEKIT_US_MT_ID =$lz_dekit_us_mt_id ");
 		 }
 		}

 	}
	//code section for saving master barcode mpn end

return true;

}else{
	return 2 ;// 2 for barcode check if item is dekited
}
	
}

public function add_special_lot(){
	// $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
 //    $barcode = $sequn[0]['ID'];
	$card_upc = $this->input->post('card_upc');
	$merch_id = $this->input->post('merch_id');
	$ent_qty = $this->input->post('ent_qty');
	$card_mpn = strtoupper($this->input->post('card_mpn'));
	$mpn = trim(str_replace("  ", ' ', $card_mpn));
    $card_mpn =str_replace("'", "''", $mpn);
  
	$cond_item = $this->input->post('up_cond_item');

	$object_desc = strtoupper($this->input->post('up_object_desc'));
	$bin_rack = $this->input->post('up_bin_rack');


	$dek_remarks = $this->input->post('up_remarks');
	$dek_remark = trim(str_replace("  ", ' ', $dek_remarks));
    $dek =str_replace("'", "''", $dek_remark);

    $brand_name = strtoupper($this->input->post('brand_name'));
	$brand = trim(str_replace("  ", ' ', $brand_name));
    $brand_name =str_replace("'", "''", $brand);

    $mpn_description = $this->input->post('mpn_description');
	$mpn_desc = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description =str_replace("'", "''", $mpn_desc);

    $pic_notes = $this->input->post('pic_notes');
	$pic_note = trim(str_replace("  ", ' ', $pic_notes));
    $pic_not =str_replace("'", "''", $pic_note);

	$user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $item_cost = '';
	$item_weight = '';
    $weights = $this->db->query("SELECT O.WEIGHT, O.ITEM_COST FROM LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = $object_desc AND O.LZ_BD_GROUP_ID = 7")->result_array();
	    $item_cost = @$weights[0]['ITEM_COST'];
		$item_weight = @$weights[0]['WEIGHT'];

    //////////////////////////////////////////
    //										//
    //////////////////////////////////////////
	 /////////////////////////////////////
    $this->session->unset_userdata('specialLot');
    /////////////////////////////////////
    $specialLot = array(
    	'up_cond_item' => $cond_item,
    	'up_object_desc' => $object_desc,
    	'up_bin_rack' => $bin_rack,
    	'merch_id' => $merch_id 
    );
    $this->session->set_userdata('specialLot', $specialLot);
    //////////////////////////////////////////
    //										//
    //////////////////////////////////////////
    $flag  = 0;
    $catalogue_mt_id = '';
    if (!empty($object_desc)) {
    	 $cats = $this->db->query("SELECT M.CATEGORY_ID FROM LZ_BD_OBJECTS_MT M WHERE M.OBJECT_ID = '$object_desc'")->result_array();
    	 $category_id = $cats[0]['CATEGORY_ID'];
    	  if (!empty($card_mpn)) {
    	 	 $check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$card_mpn' AND M.CATEGORY_ID = $category_id")->result_array();
    	 if (count($check_mpn) == 0) {
    	 	$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
		    $qry = $qry->result_array();
		    $catalogue_mt_id = $qry[0]['ID'];


    	 	$insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
    	 	 }else{
    	 	 	$catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
    	 	 }
    	 }
    	 		

			    for ($j = 1; $j<=$ent_qty ; $j++){

			    $this->session->unset_userdata('special_lot_id');
    	 		$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SPECIAL_LOTS', 'SPECIAL_LOT_ID')ID FROM DUAL");
			    $qry = $qry->result_array();
			    $special_lot_id = $qry[0]['ID'];
			    $this->session->set_userdata('special_lot_id', $special_lot_id);

                $sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
                $barcode = $sequn[0]['ID'];
                if($j == 1){
                    $fold_name = $barcode;
                }

                $insert_est_det = $this->db->query("INSERT INTO LZ_SPECIAL_LOTS(SPECIAL_LOT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,LOT_REMARKS,WEIGHT,CONDITION_ID,CARD_UPC,CARD_MPN, INSERTED_AT, INSERTED_BY, PIC_NOTES,MPN_DESCRIPTION, BRAND, ITEM_COST,LOT_ID,FOLDER_NAME) VALUES($special_lot_id,$barcode,$object_desc,$bin_rack,$dekit_date,$user_id,'$catalogue_mt_id','$dek','$item_weight',$cond_item, '$card_upc','$card_mpn', $dekit_date, $user_id, '$pic_not','$mpn_description', '$brand_name', '$item_cost','$merch_id','$fold_name')");
                }// end loop

			    // $insert_est_det = $this->db->query("INSERT INTO LZ_SPECIAL_LOTS(SPECIAL_LOT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,LOT_REMARKS,WEIGHT,CONDITION_ID,CARD_UPC,CARD_MPN, INSERTED_AT, INSERTED_BY, MPN_DESCRIPTION, BRAND, ITEM_COST, PIC_NOTES,LOT_ID) VALUES($special_lot_id,$barcode,$object_desc,$bin_rack,$dekit_date,$user_id,'$catalogue_mt_id','$dek','$item_weight',$cond_item, '$card_upc','$card_mpn', $dekit_date, $user_id, '$mpn_description', '$brand_name', '$item_cost', '$pic_not','$merch_id')");
			    if ($insert_est_det) {
			    	$flag = 1;
			    }
    }
   //var_dump($_FILES["dekit_image"]); exit;
   if ($flag == 1) {
   	 //////////////////////////////////////
        // var_dump($barcode);exit;
        $azRange = range('A', 'Z');
        $this->load->library('image_lib');
        for( $i= 0; $i < count ($_FILES['dekit_image']['name']); $i++ ) {
            if(isset($_FILES["dekit_image"])) {
            @list(, , $imtype, ) = getimagesize($_FILES['dekit_image']['tmp_name'][$i]);
            if ($imtype == 3){ // cheking image type
              $ext="png";
            }elseif ($imtype == 2){
              $ext="jpeg";
            }elseif ($imtype == 1){
              $ext="gif";
            }else{
              $msg = 'Error: unknown file format';
               echo $msg;
              exit;
            }

            if(getimagesize($_FILES['dekit_image']['tmp_name'][$i]) == FALSE){
              echo "Please select an image.";
            }else{
              $image = addslashes($_FILES['dekit_image']['tmp_name'][$i]);
              $name = addslashes($_FILES['dekit_image']['name'][$i]);
               $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 5");
               $master_qry = $query->result_array();
               $master_path = $master_qry[0]['MASTER_PATH'];
                // var_dump($master_path);exit;
                $new_dir = $master_path.$fold_name; //.;

                if(!is_dir($new_dir)){
                    //var_dump($new_dir);
                    mkdir($new_dir);
                    // var_dump($new_dir);
                }
                if(!is_dir($new_dir)){
                        mkdir($new_dir);
                }
                if (file_exists($new_dir.'/'. $name)) {
                echo $name. " <b>already exists.</b> ";
                }else{
                    $str = explode('.', $name);
                        $extension = end($str);
                    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
                     $img_name = '';
                     $max = strlen($characters) - 1;
                     for ($k = 0; $k < 10; $k++) {
                          $img_name .= $characters[mt_rand(0, $max)];
                          
                     }
                     //$j=$azRange[$i];
                    move_uploaded_file($_FILES["dekit_image"]["tmp_name"][$i],$new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
 
                    /*====================================
                    =            image resize            =
                    ====================================*/
                    $config['image_library'] = 'GD2';
                    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['new_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['maintain_ratio']    = true;
                    $config['width']     = 1000;
                    $config['height']   = 800;

                    $in =$this->image_lib->initialize($config); 
                    $result = $this->image_lib->resize($in);
                    $this->image_lib->clear();
                    /*====================================
                    =    image thumbnail creation        =
                    ====================================*/
                    $config['image_library'] = 'GD2';
                    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    if(!is_dir($new_dir."/thumb")){
                        mkdir($new_dir."/thumb");
                    }

                    $config['new_image']  = $new_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;

                    $config['maintain_ratio']    = true;
                    $config['width']     = 100;
                    $config['height']   = 100;

                    //$config['quality']     = 50; this filter doesnt work
                    $in =$this->image_lib->initialize($config); 
                    $result = $this->image_lib->resize($in);
                    $this->image_lib->clear();
                    }
                
                }//else if getimage size
          }//if isset file image
        }//main for loop
        //////////////////////////////////////
		
   } // main if

        ////////////////////////////////////////
        $query = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5");
        $master_qry = $query->result_array();
        $master_path = $master_qry[0]['LIVE_PATH'];
        //$dir = $master_path.$barcode;
        $dir = $master_path;
        //var_dump($dir); exit;
        // Open a directory, and read its contents
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            //$i=1;
            while (($file = readdir($dh)) !== false){
                $parts = explode(".", $file);
                if (is_array($parts) && count($parts) > 1){
                    $extension = end($parts);
                    if(!empty($extension)){
                        //$img_name = explode('_', $master_reorder[$i-1]);
                        //rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
                        @$img_order = unlink($dir."/".$parts['0'].".".$extension);
                    }
                }

            }//end while

            closedir($dh);

          }// sub if
        }//main if 
        
return array('lot_id'=>$special_lot_id, 'res'=>true);
}	
	/*=============================================
	=            Section comment block            =
	=============================================*/
	public function update_special_lot(){
	$special_lot_id = $this->input->post('special_lot_id');
	$barcode 		= $this->input->post('barcode');

	$card_upc = $this->input->post('card_upc');
	$card_mpn = strtoupper($this->input->post('card_mpn'));
	$mpn = trim(str_replace("  ", ' ', $card_mpn));
    $card_mpn =str_replace("'", "''", $mpn);

    /*if (empty($card_mpn) || $card_mpn == '' || $card_mpn == null) {
    	 			$card_mpn = $card_upc;
    	 		}*/

	$cond_item = $this->input->post('up_cond_item');

	$object_desc = $this->input->post('up_object_desc');
	$bin_rack = $this->input->post('up_bin_rack');


	$dek_remarks = $this->input->post('up_remarks');
	$dek_remark = trim(str_replace("  ", ' ', $dek_remarks));
    $dek =str_replace("'", "''", $dek_remark);

    $brand_name = strtoupper($this->input->post('brand_name'));
	$brand = trim(str_replace("  ", ' ', $brand_name));
    $brand_name =str_replace("'", "''", $brand);

    $mpn_description = $this->input->post('mpn_description');
	$mpn_desc = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description =str_replace("'", "''", $mpn_desc);

    $pic_notes = $this->input->post('pic_notes');
	$pic_note = trim(str_replace("  ", ' ', $pic_notes));
    $pic_not =str_replace("'", "''", $pic_note);

	$user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
     if ($object_desc == 2970) {
			$item_cost = 2;
			$item_weight = 6;
		}elseif($object_desc == 10000000086){
			$item_cost = 0.05;
			$item_weight = 3;
		}else{
			$item_cost = '';
			$item_weight = '';
		}
		//////////////////////////////////////////
    //										//
    //////////////////////////////////////////
	 /////////////////////////////////////
    $this->session->unset_userdata('specialLot');
    /////////////////////////////////////
    $specialLot = array(
    	'up_cond_item' => $cond_item,
    	'up_object_desc' => $object_desc,
    	'up_bin_rack' => $bin_rack 
    );
    $this->session->set_userdata('specialLot', $specialLot);
    //////////////////////////////////////////
    //										//
    //////////////////////////////////////////
    //////////////////////////////////////////
    //										//
    //////////////////////////////////////////
     $flag  = 0;
    if (!empty($object_desc)) {
    	 $cats = $this->db->query("SELECT M.CATEGORY_ID FROM LZ_BD_OBJECTS_MT M  WHERE  M.OBJECT_ID = $object_desc")->result_array();
    	 $category_id = $cats[0]['CATEGORY_ID'];
    	 if (!empty($card_mpn)) {
    	 	$check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$card_mpn' AND M.CATEGORY_ID = $category_id")->result_array();
    	 	if (count($check_mpn) == 0) {
    	 	$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
		    $qry = $qry->result_array();
		    $catalogue_mt_id = $qry[0]['ID'];

    	 	$insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
    	 }else{
    	 	$catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
    	 }
    	}
    	
    	 $insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc, BIN_ID = $bin_rack, PIC_DATE_TIME = $dekit_date ,PIC_BY = $user_id, LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc',CARD_MPN = '$card_mpn', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost'  WHERE SPECIAL_LOT_ID = $special_lot_id");
    	 	$flag = 1;
    }
    
   if ($flag == 1) {
   	 //////////////////////////////////////
        // var_dump($barcode);exit;
        $azRange = range('A', 'Z');
        $this->load->library('image_lib');
        for( $i= 0; $i < count ($_FILES['dekit_image']['name']); $i++ ) {
            if(isset($_FILES["dekit_image"])) {
            @list(, , $imtype, ) = getimagesize($_FILES['dekit_image']['tmp_name'][$i]);
            if ($imtype == 3){ // cheking image type
              $ext="png";
            }elseif ($imtype == 2){
              $ext="jpeg";
            }elseif ($imtype == 1){
              $ext="gif";
            }else{
              $msg = 'Error: unknown file format';
               echo $msg;
              exit;
            }

            if(getimagesize($_FILES['dekit_image']['tmp_name'][$i]) == FALSE){
              echo "Please select an image.";
            }else{
              $image = addslashes($_FILES['dekit_image']['tmp_name'][$i]);
              $name = addslashes($_FILES['dekit_image']['name'][$i]);
               $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
               $master_qry = $query->result_array();
               $master_path = $master_qry[0]['MASTER_PATH'];
                // var_dump($master_path);exit;
                $new_dir = $master_path.$barcode;//.;

                if(!is_dir($new_dir)){
                    //var_dump($new_dir);
                    mkdir($new_dir);
                    // var_dump($new_dir);
                }
                if(!is_dir($new_dir)){
                        mkdir($new_dir);
                }
                if (file_exists($new_dir.'/'. $name)) {
                echo $name. " <b>already exists.</b> ";
                }else{
                    $str = explode('.', $name);
                        $extension = end($str);
                    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
                     $img_name = '';
                     $max = strlen($characters) - 1;
                     for ($k = 0; $k < 10; $k++) {
                          $img_name .= $characters[mt_rand(0, $max)];
                          
                     }
                     //$j=$azRange[$i];
                    move_uploaded_file($_FILES["dekit_image"]["tmp_name"][$i],$new_dir.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
 
                    /*====================================
                    =            image resize            =
                    ====================================*/
                    $config['image_library'] = 'GD2';
                    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['new_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    $config['maintain_ratio']    = true;
                    $config['width']     = 1000;
                    $config['height']   = 800;

                    $in =$this->image_lib->initialize($config); 
                    $result = $this->image_lib->resize($in);
                    $this->image_lib->clear();
                    /*====================================
                    =    image thumbnail creation        =
                    ====================================*/
                    $config['image_library'] = 'GD2';
                    $config['source_image']  = $new_dir."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                    if(!is_dir($new_dir."/thumb")){
                        mkdir($new_dir."/thumb");
                    }

                    $config['new_image']  = $new_dir."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;

                    $config['maintain_ratio']    = true;
                    $config['width']     = 100;
                    $config['height']   = 100;

                    //$config['quality']     = 50; this filter doesnt work
                    $in =$this->image_lib->initialize($config); 
                    $result = $this->image_lib->resize($in);
                    $this->image_lib->clear();
                    }
                
                }//else if getimage size
          }//if isset file image
        }//main for loop
        //////////////////////////////////////
		return true;
   } // main if        

}	
	/*=============================================
	=            Section comment block            =
	=============================================*/
	public function update_without_picture(){
		
	$special_lot_id = $this->input->post('special_lot_id');
	$barcode 		= $this->input->post('barcode');
	$get_cost 		= $this->input->post('get_cost');

	$card_upc = strtoupper($this->input->post('card_upc'));
	$upc = trim(str_replace("  ", ' ', $card_upc));
    $card_upc =str_replace("'", "''", $upc);

    $get_card_category = strtoupper($this->input->post('get_card_category'));
	$get_card_category = trim(str_replace("  ", ' ', $get_card_category));
    $get_card_category =str_replace("'", "''", $get_card_category);

	$card_mpn = strtoupper($this->input->post('card_mpn'));
	$mpn = trim(str_replace("  ", ' ', $card_mpn));
    $card_mpn =str_replace("'", "''", $mpn);

	$cond_item = $this->input->post('up_cond_item');

	$object_desc = $this->input->post('up_object_desc');
	$bin_rack = $this->input->post('up_bin_rack');


	$dek_remarks = $this->input->post('up_remarks');
	$dek_remark = trim(str_replace("  ", ' ', $dek_remarks));
    $dek =str_replace("'", "''", $dek_remark);

    $brand_name = strtoupper($this->input->post('brand_name'));
	$brand = trim(str_replace("  ", ' ', $brand_name));
    $brand_name =str_replace("'", "''", $brand);

    $mpn_description = $this->input->post('mpn_description');
	$mpn_desc = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description =str_replace("'", "''", $mpn_desc);

    $pic_notes = $this->input->post('pic_notes');
	$pic_note = trim(str_replace("  ", ' ', $pic_notes));
    $pic_not =str_replace("'", "''", $pic_note);

	$user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $item_cost = '';
	$item_weight = '';
    $weights = $this->db->query("SELECT O.WEIGHT, O.ITEM_COST,O.CATEGORY_ID FROM LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = $object_desc AND O.LZ_BD_GROUP_ID = 7")->result_array();
    $item_cost = @$weights[0]['ITEM_COST'];
	$item_weight = @$weights[0]['WEIGHT'];
	$category_id = @$weights[0]['CATEGORY_ID'];

	 /////////////////////////////////////
    $this->session->unset_userdata('specialLot');
    /////////////////////////////////////
    $specialLot = array(
    	'up_cond_item' => $cond_item,
    	'up_object_desc' => $object_desc,
    	'up_bin_rack' => $bin_rack 
    );
    $this->session->set_userdata('specialLot', $specialLot);
    //////////////////////////////////////////
    //										//
    //////////////////////////////////////////
    $catalogue_mt_id ='';
    
    	if (!empty($card_mpn)) {
    	 	$check_mpn = $this->db->query("SELECT M.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = '$card_mpn' AND M.CATEGORY_ID = $category_id")->result_array();
    	 	if (count($check_mpn) == 0) {
    	 		$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT', 'CATALOGUE_MT_ID')ID FROM DUAL");
		    	$qry = $qry->result_array();
		    	$catalogue_mt_id = $qry[0]['ID'];

    	 		$insert_mpn = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");
    	 	}else{
    	 		$catalogue_mt_id = $check_mpn[0]['CATALOGUE_MT_ID'];
    	 	}
    	 	
    	 }else{
	 		/*==================================================
			=            genrate mpn if mpn is null            =
			==================================================*/

		        $get_catalg_id = $this->db->query("SELECT * FROM (SELECT L.CATALOG_MT_ID FROM LZ_SPECIAL_LOTS L WHERE L.CARD_UPC = '$upc' AND L.CATALOG_MT_ID IS NOT NULL ORDER BY L.SPECIAL_LOT_ID DESC) WHERE ROWNUM = 1");

				if($get_catalg_id->num_rows() > 0) {

					$get_exist_mpn = $get_catalg_id->result_array();
					$catalogue_mt_id = $get_exist_mpn[0]['CATALOG_MT_ID'];

				}else{
					$get_mpn = $this->db->query("SELECT MPN_GENERATION($category_id) as MPN FROM DUAL");
					$get_mpn = $get_mpn->result_array();
					$get_mpn = $get_mpn[0]['MPN'];

					$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
					$get_pk = $get_mt_pk->result_array();
					$catalogue_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

					$mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, OBJECT_ID, MPN_DESCRIPTION, BRAND, UPC) VALUES($catalogue_mt_id, '$card_mpn', $category_id, $dekit_date, $user_id, $object_desc, '$mpn_description', '$brand_name', '$card_upc')");

					//$card_mpn = $get_mpn; // assign newly created part no

				} //get_catalg_id else closing
			/*=====  End of genrate mpn if mpn is null  ======*/
    	 }//end if else !empty($card_mpn)

    	$lots_data = $this->db->query("SELECT C.CARD_UPC, UPPER(C.CARD_MPN) CARD_MPN, C.CONDITION_ID, C.OBJECT_ID, C.BRAND,C.FOLDER_NAME,C.BIN_ID FROM LZ_SPECIAL_LOTS C WHERE C.SPECIAL_LOT_ID = $special_lot_id")->result_array();
    	$lot_upc 				= $lots_data[0]['CARD_UPC'];
    	$lot_mpn 				= $lots_data[0]['CARD_MPN'];
    	$lot_condition_id 		= $lots_data[0]['CONDITION_ID'];
    	$lot_object_id 			= $lots_data[0]['OBJECT_ID'];
    	$lot_brand				= $lots_data[0]['BRAND'];
    	$folder_name		    = $lots_data[0]['FOLDER_NAME'];
    	$current_bin		    = $lots_data[0]['BIN_ID'];

    	if(!empty($current_bin)){
    		$bin_qry = "";
    	}else{
    		$bin_qry =",BIN_ID =".$bin_rack;
    	}

    	 if ($lot_upc !='' && $lot_mpn =='') {

    	 	$with_upcs = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS LS WHERE LS.CARD_UPC = '$card_upc' AND LS.CARD_MPN IS NULL AND LS.LZ_MANIFEST_DET_ID IS NULL")->result_array();
    	 	if (count($with_upcs) > 1) {
    	 		$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry,CARD_CATEGORY_ID = '$get_card_category', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost'  WHERE CARD_UPC = '$lot_upc' AND CARD_MPN IS NULL AND LZ_MANIFEST_DET_ID IS NULL");
    	 		if ($insert_est_det) {
    	 			$flag = 1;
    	 				
    	 		}else{
    	 			$flag = 0;
    	 			
    	 		}
    	 	
    	 	}else{
    	 		$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry,CARD_CATEGORY_ID = '$get_card_category', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost' WHERE SPECIAL_LOT_ID = $special_lot_id");
 				if ($insert_est_det) {
 					$flag = 1;
 				}else{
 				$flag = 0;
 						
    	 		}
    	 	}
    	 }elseif ($lot_mpn !='' && $lot_upc =='') {
    	 	
    	 	$with_upcs = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS LS WHERE LS.CARD_UPC IS NULL AND UPPER(LS.CARD_MPN) = '$card_mpn' AND LS.LZ_MANIFEST_DET_ID IS NULL")->result_array();
    	 	if (count($with_upcs) > 1) {
    	 		$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry, CARD_CATEGORY_ID = '$get_card_category',LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost'  , PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost'  WHERE CARD_UPC IS NULL AND UPPER(CARD_MPN) = '$lot_mpn' AND LZ_MANIFEST_DET_ID IS NULL");
    	 		if ($insert_est_det) {
    	 			$flag = 1;
    	 				
    	 		}else{
    	 			$flag = 0;
    	 			
    	 		}
    	 	
    	 	}else{
    	 		$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry,CARD_CATEGORY_ID = '$get_card_category', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost' WHERE SPECIAL_LOT_ID = $special_lot_id");
 				if ($insert_est_det) {
 					$flag = 1;
 				}else{
 				$flag = 0;
 						
    	 		}
    	 	}
    	 }elseif ($lot_mpn !='' && $lot_upc !='') {
    	 	
    	 	$with_upcs = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS LS WHERE LS.CARD_UPC = '$card_upc' AND UPPER(LS.CARD_MPN) = '$card_mpn' AND LS.LZ_MANIFEST_DET_ID IS NULL")->result_array();
    	 	if (count($with_upcs) > 1) {
    	 		$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry,CARD_CATEGORY_ID = '$get_card_category', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item,CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost' , PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost' WHERE CARD_UPC = '$lot_upc' AND UPPER(CARD_MPN) = '$lot_mpn'AND LZ_MANIFEST_DET_ID IS NULL");
    	 		if ($insert_est_det) {
    	 			$flag = 1;
    	 				
    	 		}else{
    	 			$flag = 0;
    	 			
    	 		}
    	 	
    	 	}else{
    	 		$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry,CARD_CATEGORY_ID = '$get_card_category', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost', PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost'  WHERE SPECIAL_LOT_ID = $special_lot_id");
 				if ($insert_est_det) {
 					$flag = 1;
 				}else{
 				$flag = 0;		
    	 		}
    	 	}
    	 }else{
 			$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry, CARD_CATEGORY_ID = '$get_card_category',LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost', PIC_NOTES = '$pic_not' ,AVG_SOLD = '$get_cost' WHERE SPECIAL_LOT_ID = $special_lot_id");
 				if ($insert_est_det) {
 					$flag = 1;
 				}else{
 				$flag = 0;
 					
    	 		}	 	
 			}
    //}
	/*================================================================
	=            update all barcode with same folder name            =
	================================================================*/
	$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc $bin_qry, CARD_CATEGORY_ID = '$get_card_category',LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_item, CARD_UPC = '$card_upc' ,CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$item_cost', PIC_NOTES = '$pic_not' ,AVG_SOLD = '$get_cost' WHERE FOLDER_NAME = $folder_name AND LZ_MANIFEST_DET_ID IS NULL");
		if ($insert_est_det) {
			return $flag = 1;
		}else{
			return $flag = 0;
			
		}	
	/*=====  End of update all barcode with same folder name  ======*/		
   } 








































        	
	/*=============================================
	=            Section comment block            =
	=============================================*/
	public function showMasterDetails(){
		$master_barcode = $this->input->post('master_barcode');

		$barcode_avail = $this->db->query("SELECT B.BARCODE_NO,B.ITEM_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND B.BARCODE_NO in  (SELECT K.BARCODE_NO FROM LZ_DEKIT_US_MT K) AND ROWNUM <=1 ");

		// OLD BARCODE CHECK $barcode_avail = $this->db->query("SELECT B.BARCODE_NO,,B.ITEM_ID FROM LZ_BARCODE_MT     B, LZ_MANIFEST_MT    M, /*LZ_BD_TRACKING_NO T, */LZ_SINGLE_ENTRY   S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID /*AND S.ID = T.LZ_SINGLE_ENTRY_ID*/ AND B.BARCODE_NO = $master_barcode /*AND T.LZ_ESTIMATE_ID IS NULL*/ AND B.BARCODE_NO in  (SELECT K.BARCODE_NO FROM LZ_DEKIT_US_MT K)");

		// $add_barcode_comp = $this->db->query("SELECT B.BARCODE_NO,,B.ITEM_ID FROM LZ_BARCODE_MT     B, LZ_MANIFEST_MT    M, LZ_BD_TRACKING_NO T, LZ_SINGLE_ENTRY   S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND S.ID = T.LZ_SINGLE_ENTRY_ID AND B.BARCODE_NO = $master_barcode AND T.LZ_ESTIMATE_ID IS NULL AND B.BARCODE_NO not in  (SELECT K.BARCODE_NO FROM LZ_DEKIT_US_MT K)");

		$barcod_valid = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO  =$master_barcode ");

		if ($barcode_avail->num_rows() > 0) {			

		$det = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,D.BARCODE_PRV_NO,B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO,O.OBJECT_NAME,D.DEKIT_REMARKS,D.PIC_NOTES,D.WEIGHT,D.CONDITION_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID AND B.BIN_ID (+)= D.BIN_ID ORDER BY D.BARCODE_PRV_NO asc");
		$det = $det->result_array();
		// var_dump($det[0]['CONDITION_ID']);exit;
		$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
		$path = $path->result_array();

		// var_dump($path[0]["MASTER_PATH"]);exit;
		$flag = [];
		$i = 0;
		$master_path = $path[0]["MASTER_PATH"];
		$dir_path = [];
		foreach (@$det as $row){
	      $it_condition  = @$row['CONDITION_ID'];
		  if(is_numeric(@$it_condition)){
		        if(@$it_condition == 3000){
		          @$it_condition = 'Used';
		        }elseif(@$it_condition == 1000){
		          @$it_condition = 'New'; 
		        }elseif(@$it_condition == 1500){
		          @$it_condition = 'New other'; 
		        }elseif(@$it_condition == 2000){
		            @$it_condition = 'Manufacturer refurbished';
		        }elseif(@$it_condition == 2500){
		          @$it_condition = 'Seller refurbished'; 
		        }elseif(@$it_condition == 7000){
		          @$it_condition = 'For parts or not working'; 
		        }
		      }
		        // if($det[$i]['DEKIT_REMARKS'] == null){
		        // 	$det[$i]['DEKIT_REMARKS'] == '';
		        // }
		        $barcode_prv_no = $row["BARCODE_PRV_NO"];
		        $m_dir =  $master_path.$barcode_prv_no."/thumb/";
		        
		        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

		        if(is_dir(@$m_dir)){
                    $iterator = new \FilesystemIterator(@$m_dir);
                    if (@$iterator->valid()){    
                      $m_flag = true;
                      $flag[$i] = $m_flag;

                       $images = scandir($m_dir);
                    // Image selection and display:
                    //display first image
	                  if (count($images) > 0) { // make sure at least one image exists
	                      $url = $images[2]; // first image
	                      $img = file_get_contents($m_dir.$url);
	                      // var_dump($img);exit;
	                      $img =base64_encode($img);
	                      $dir_path[$i] = $img;
	                  }else{
	                  	$dir_path[$i] = $m_dir;
	                  }

                  }else{
                    $m_flag = false;
                    $flag[$i] = $m_flag;
                  }
              	}else{
	                $m_flag = false;
	                $flag[$i] = $m_flag;
	            }

	            $i++;
		}
		return array('det'=>$det ,'res'=>2,'flag'=>$flag,'dir_path'=>$dir_path);
		}
		else if($barcod_valid->num_rows() > 0) {
			return 1; // for adding new items
		}else{

			return 3; // barcode not valid
		}
	}

	public function print_all_us_pk(){
	  	//$master_barcode = $this->session->userdata('ctc_kit_barcode');
	  	$master_barcode = $this->uri->segment(4);

		$listing_qry = $this->db->query("SELECT CO.COND_NAME ITEM_DESC ,'MB' || '-' || M.BARCODE_NO BARCODE_NO,D.barcode_prv_no BAR_CODE, o.object_name, '1' LOT_NO, 'PO_DETAIL_LOT_REF' PO_DETAIL_LOT_REF, 'UNIT_NO' UNIT_NO, '1' LOT_QTY FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D, LZ_BD_OBJECTS_MT O, BIN_MT B,lz_item_cond_mt co WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID and d.condition_id = co.id(+) AND D.OBJECT_ID = O.OBJECT_ID AND B.BIN_ID = D.BIN_ID order by d.barcode_prv_no asc")->result_array();

		return $listing_qry;
}
	public function print_single_us_pk(){

		$lz_dekit_us_dt_id = $this->uri->segment(4);
		// $manifest_id =	$this->uri->segment(5);
		// $barcode = $this->uri->segment(6);
	    $print_qry = $this->db->query("SELECT CO.COND_NAME ITEM_DESC, D.LZ_DEKIT_US_DT_ID, D.BARCODE_PRV_NO BAR_CODE, O.OBJECT_NAME, '1' LOT_NO, 'PO_DETAIL_LOT_REF' PO_DETAIL_LOT_REF, 'UNIT_NO' UNIT_NO, '1' LOT_QTY, 'MB' || '-' || MT.BARCODE_NO BARCODE_NO FROM LZ_DEKIT_US_DT D,LZ_DEKIT_US_MT MT ,LZ_BD_OBJECTS_MT O, BIN_MT B, LZ_ITEM_COND_MT CO WHERE D.CONDITION_ID = CO.ID(+) AND D.OBJECT_ID = O.OBJECT_ID AND D.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND D.BIN_ID = B.BIN_ID AND D.LZ_DEKIT_US_DT_ID = $lz_dekit_us_dt_id "); //$query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");
	    //var_dump($print_qry);exit;
	    return $print_qry->result_array();

	}
	
	/*=====  End of Section comment block  ======*/

	/*==========================================================
	=            Show details on Add Picture Screen            =
	==========================================================*/
	
	public function getPrvDetails(){
		$barcode = $this->input->post('child_barcode');

		$details = $this->db->query("SELECT CONDITION_ID FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = $barcode");

		$details = $details->result_array();

		return $details;
	}
	
	/*=====  End of Show details on Add Picture Screen  ======*/
	
	/*===============================================
	=            Delete Det barcode item            =
	===============================================*/
	public function deleteDeKitDet(){
		$det_id = $this->input->post('det_id');

		$details = $this->db->query("DELETE FROM   LZ_DEKIT_US_DT WHERE LZ_DEKIT_US_DT_ID = $det_id");

		if($details){
			return 1;
		}else{
			return 0;
		}
	}	 
	
	
	/*=====  End of Delete Det barcode item  ======*/

	/*================================================================
	=            get details of single barcode for update            =
	================================================================*/
	public function getDetDetails(){
		$det_id = $this->input->post('det_id');

		$selectable = $this->db->query("SELECT * FROM  LZ_DEKIT_US_DT WHERE LZ_DEKIT_US_DT_ID = $det_id")->result_array();
		$conds = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
		return array('selectable'=>$selectable, 'conds'=>$conds);
	}
	
	
	/*=====  End of get details of single barcode for update  ======*/

	/*===========================================
	=            update single item             =
	===========================================*/

	public function updateDetKit(){

		 $det_id = $this->input->post('det_id') ; 
		 $object = $this->input->post('object') ;
		 $bin = $this->input->post('bin') ;
		 $condition = $this->input->post('condition') ;
		 $weight = $this->input->post('weight') ;
		 $dekit_remark = $this->input->post('dekit_remark') ;

		 $updateqry = $this->db->query("UPDATE LZ_DEKIT_US_DT  SET OBJECT_ID =$object ,BIN_ID = $bin , CONDITION_ID = $condition, WEIGHT = $weight, DEKIT_REMARKS = '$dekit_remark' where LZ_DEKIT_US_DT_ID = $det_id");	

		 if($updateqry)	{
		 	return 1;
		 }else{
		 	return 0 ;
		 }
	}
	
	
	
	/*=====  End of update single item   ======*/
	
	public function saveNotes(){
	  	$note = $this->input->post('notes');
	  	$barcode = $this->input->post('child_barcode');

	  	$update_note = $this->db->query("UPDATE LZ_DEKIT_US_DT SET PIC_NOTES = '$note' WHERE BARCODE_PRV_NO = $barcode");

	  	if($update_note){
	  		return 1;
	  	}else{
	  		return 0;
	  	}

	 }

	public function getPicNote(){
		$barcode = $this->input->post('child_barcode');

		$note = $this->db->query("SELECT PIC_NOTES FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = $barcode");

		$note = $note->result_array();

		return $note;
	}
	
	public function showChildDetails($barcode_prv){
		
		$child_bar = $this->db->query("SELECT D.BIN_ID, D.WEIGHT, D.DEKIT_REMARKS, C.COND_NAME, O.OBJECT_NAME, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM LZ_DEKIT_US_DT D, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND B.BIN_ID = D.BIN_ID AND D.BARCODE_PRV_NO = $barcode_prv"); 
		return $child_bar->result_array();
		
	}

public function checkNonPicturess(){
	$requestData= $_REQUEST;
	$columns = array( 
      0 =>'BARCODE_PRV_NO',
      1 =>'OBJECT_NAME',
      2 =>'COND_NAME',
      3=>'WEIGHT',
      4=>'BIN_NO',
      5=>'DEKIT_REMARKS'
    );

    $sql = "SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID = B.BIN_ID  AND  D.PIC_STATUS = 0  AND D.ADJUST_MT_ID IS NULL AND D.LZ_MANIFEST_DET_ID IS NULL  ";
    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	      $sql.=" AND (D.BARCODE_PRV_NO LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR O.OBJECT_NAME LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR C.COND_NAME LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR D.WEIGHT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR B.BIN_NO LIKE '%".$requestData['search']['value']."%' "; 
	      $sql.=" OR D.DEKIT_REMARKS LIKE '%".$requestData['search']['value']."%') "; 
          
	  }else{
	    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	      $sql.=" AND (D.BARCODE_PRV_NO LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR O.OBJECT_NAME LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR C.COND_NAME LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR D.WEIGHT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR B.BIN_NO LIKE '%".$requestData['search']['value']."%' "; 
	      $sql.=" OR D.DEKIT_REMARKS LIKE '%".$requestData['search']['value']."%') ";
	      
	    }
	  }

	$query = $this->db->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData;

    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
     // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;
    // echo $sql;
    
    
    /*=====  End of For Oracle 12-c  ======*/

    $query = $this->db->query($sql);

    $query = $query->result_array();
    $data = array();

    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] = $row['BARCODE_PRV_NO'] ;

      $nestedData[] = $row['OBJECT_NAME'] ;

      $nestedData[] = $row['COND_NAME'] ;

      $nestedData[] = $row['WEIGHT'] ;

      $nestedData[] = $row['BIN_NO'] ;

      $nestedData[] = $row['DEKIT_REMARKS'] ;

      $data[] = $nestedData;
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

public function checkPicturess(){
	$cloudUrl = '';
	$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
	$path = $path->result_array();
	$master_path = $path[0]["MASTER_PATH"];	

	$requestData= $_REQUEST;

	$columns = array( 
   
      0 =>'BARCODE_PRV_NO',
      1 =>'OBJECT_NAME',
      2 =>'COND_NAME',
      3=>'WEIGHT',
      4=>'BIN_NO',
      5=>'DEKIT_REMARKS',
      6=>'STATUS'
      
    );

    $sql = "SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID = B.BIN_ID  AND  D.PIC_STATUS = 1 AND D.ADJUST_MT_ID IS NULL AND D.LZ_MANIFEST_DET_ID IS NULL";

    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND (D.BARCODE_PRV_NO LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR O.OBJECT_NAME LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR C.COND_NAME LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR D.WEIGHT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR B.BIN_NO LIKE '%".$requestData['search']['value']."%' "; 
	      $sql.=" OR D.DEKIT_REMARKS LIKE '%".$requestData['search']['value']."%') ";
          
	  }else{
	    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	      $sql.=" AND (D.BARCODE_PRV_NO LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR O.OBJECT_NAME LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR C.COND_NAME LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR D.WEIGHT LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR B.BIN_NO LIKE '%".$requestData['search']['value']."%' "; 
	      $sql.=" OR D.DEKIT_REMARKS LIKE '%".$requestData['search']['value']."%') "; 
	    }
	  }

	$query = $this->db->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData;

    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
     // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    // echo $sql;
    
    
    /*=====  End of For Oracle 12-c  ======*/

    $query = $this->db->query($sql);

    $query = $query->result_array();
    $data = array();

    $i =0;
    $j=0;
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] = $row['BARCODE_PRV_NO'] ;

      $nestedData[] = $row['OBJECT_NAME'] ;

      $nestedData[] = $row['COND_NAME'] ;

      $nestedData[] = $row['WEIGHT'] ;

      $nestedData[] = $row['BIN_NO'] ;

      $nestedData[] = $row['DEKIT_REMARKS'] ;

	  $barcode_prv_no = $row['BARCODE_PRV_NO'];

	  $condition = $row['COND_NAME'];

	  $m_dir =  $master_path.$barcode_prv_no."/thumb/";       
	  $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
	  // $imag = '';
	  $img = '';
	  // $cloudUrl = '';
	  // $local_path = '';
	  if(is_dir(@$m_dir)){
        $iterator = new \FilesystemIterator(@$m_dir);
        if (@$iterator->valid()){    
           $images = scandir($m_dir);
        // Image selection and display:
        //display first image
          if (count($images) > 0) { // make sure at least one image exists
              $url = $images[2]; // first image
              $img = file_get_contents($m_dir.$url);

              $img =base64_encode($img);
           
          }
      }

	}


      $nestedData[] =  '<img class="sort_img up-img zoom_01" id="" name="save_thumbnail'.$i.'" src="data:image;base64,'.$img.'"/>';
      $j++;
              // $dir_path[$i] = $img;

      $data[] = $nestedData;
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

	public function checkPictures(){
		$qry = $this->db->query("SELECT D.BARCODE_PRV_NO,C.COND_NAME FROM LZ_DEKIT_US_DT D,LZ_ITEM_COND_MT C WHERE D.CONDITION_ID = C.ID ORDER BY D.BARCODE_PRV_NO asc");
		$qry = $qry->result_array();

		$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
		$path = $path->result_array();
		$pics = [];

		$nonPics=[];

		$flag = [];
		$i = 0;
		$j = 0;
		$master_path = $path[0]["MASTER_PATH"];
		$dir_path = [];

		foreach($qry as $row){
			$barcode_prv_no = $row['BARCODE_PRV_NO'];

			$condition = $row['COND_NAME'];

			$m_dir =  $master_path.$barcode_prv_no."/thumb/";
		        
		    $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

	        if(is_dir(@$m_dir)){
	        	// var_dump($m_dir);exit;
                $iterator = new \FilesystemIterator(@$m_dir);
                // var_dump($iterator);
                if (@$iterator->valid()){    
                  $m_flag = true;
                  $flag[$i] = $m_flag;

                   $images = scandir($m_dir);
						
                  if (count($images) > 0) { // make sure at least one image exists
                      $url = $images[2]; // first image
                      $img = file_get_contents($m_dir.$url);
                      // var_dump($img);exit;
                      $img =base64_encode($img);
                      $dir_path[$i] = $img;
                  	$record = $this->db->query("SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID=B.BIN_ID  AND D.BARCODE_PRV_NO = $barcode_prv_no");
                  	$record = $record->result_array();

                  	$pics[$i] = $record;
                  	$i++;

				}
            
        	}else{
				// var_dump('yes');exit;
				$record = $this->db->query("SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID = B.BIN_ID  AND D.BARCODE_PRV_NO = $barcode_prv_no");
	            $record = $record->result_array();
	            $nonPics[$j] = $record;
	            $j++;
			}
		
		}else{
			$record = $this->db->query("SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID = B.BIN_ID  AND D.BARCODE_PRV_NO = $barcode_prv_no");
            $record = $record->result_array();
            $nonPics[$j] = $record;
            $j++;
		}
		
	}
		return  array('res'=>2,'flag'=>$flag,'dir_path'=>$dir_path,'pics'=>$pics,'nonPics'=>$nonPics);
	}	

	public function getLivePictures(){
		// $barcode = $this->input->post('barcode');

		// $child_bar = $this->db->query("SELECT C.COND_NAME FROM LZ_DEKIT_US_DT D,LZ_ITEM_COND_MT C WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BARCODE_PRV_NO = $barcode");
		// $child_bar = $child_bar->result_array();		

		$path = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5");
		$path = $path->result_array();
		//var_dump($path[0]["LIVE_PATH"]);exit;
		$livePath = $path[0]["LIVE_PATH"];
		// var_dump($livePath);
		$dir = $livePath;
		$dir = preg_replace("/[\r\n]*/","",$dir);
		$dir_path = [];
		$parts = [];
		$image_url = [];
		if (is_dir($dir)){
			$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
			$i=0 ;

			foreach($images as $image){
				$parts = explode(".", $image);
                if (is_array($parts) && count($parts) > 1){
                    $extension = end($parts);
                    if(!empty($extension)){
		                // $live_path = $data['path_query'][0]['LIVE_PATH'];
	                    $url = $parts['0'].'.'.$extension;
	                    //var_dump($url);
	                    $url = preg_replace("/[\r\n]*/","",$url);
	                    $img_url = explode("\\", $url);
	                    $img_url = end($img_url);
	                    //var_dump($img_url);
	                    $image_url[$i] = $img_url;
	                    //var_dump($url);exit;
	                    $img = file_get_contents($url);
	                    $img =base64_encode($img);
	                    $dir_path[$i] = $img;
	                    $i++;
                    }
                }

			}
		}

		// var_dump(count($dir_path));exit;
		return array('dir_path'=>$dir_path,'parts'=>$parts, 'image_url'=>$image_url);
	}
	

  public function getBarcodePics(){
  	$barcode = $this->input->post('barcode');
  	$condition = $this->input->post('condition');
  	// var_dump($condition);exit;

	 //  $getMpn = $this->db->query("	SELECT I.ITEM_MT_MFG_PART_NO, DT.OBJECT_ID FROM LZ_DEKIT_US_DT DT, LZ_DEKIT_US_MT MT,LZ_BARCODE_MT B, ITEMS_MT I WHERE DT.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND B.BARCODE_NO = MT.BARCODE_NO AND B.ITEM_ID = I.ITEM_ID AND DT.BARCODE_PRV_NO = $barcode");

	 //  $getMpn = $getMpn->result_array();
	 //  $mpn = $getMpn[0]["ITEM_MT_MFG_PART_NO"];
	 //  $OBJECT_ID = $getMpn[0]["OBJECT_ID"];

	 //  $getMasterBarcodeId = $this->db->query("SELECT D.LZ_DEKIT_US_MT_ID FROM LZ_DEKIT_US_MT D, LZ_BARCODE_MT B , ITEMS_MT I WHERE I.ITEM_ID = B.ITEM_ID AND B.BARCODE_NO = D.BARCODE_NO AND I.ITEM_MT_MFG_PART_NO = '$mpn' ORDER BY D.LZ_DEKIT_US_MT_ID DESC");

 
	 //  $getMasterBarcodeId = $getMasterBarcodeId->result_array();
	 //  $master_id = $getMasterBarcodeId[0]["LZ_DEKIT_US_MT_ID"];


	 // $getBarcodePrv_no =  $this->db->query("SELECT DT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DT WHERE DT.LZ_DEKIT_US_MT_ID = $master_id AND DT.OBJECT_ID = '$OBJECT_ID' AND DT.PIC_DATE_TIME IS NOT NULL ORDER BY DT.LZ_DEKIT_US_DT_ID DESC");

	 // $getBarcodePrv_no = $getBarcodePrv_no->result_array();

	 // $getBarcodePrv_no = $getBarcodePrv_no[0]["BARCODE_PRV_NO"];
	 // var_dump($getBarcodePrv_no );exit;

	$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
	$path = $path->result_array();  	

	$master_path = $path[0]["MASTER_PATH"];
	// var_dump($master_path);exit;
	$dir = $master_path.$barcode."/";//getBarcodePrv_no
	// $dir = $master_path.$getBarcodePrv_no."/thumb/";
	// var_dump($dir);exit;
	$dir = preg_replace("/[\r\n]*/","",$dir);

	$mdir = $master_path.$barcode."/";
	// var_dump($dir);exit;
	$dekitted_pics = [];
	$parts = [];
	$uri = [];
	$cloudUrl = [];
	// var_dump(is_dir($dir));exit;
	if (is_dir($dir)){
		// var_dump($dir);exit;
		$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
		$i=0 ;

		foreach($images as $image){
			$uri[$i] = $image;
			$parts = explode(".", $image);
			$img_name = explode("/",$image);
			// var_dump($img_name);exit;
			$img_n = explode(".",$img_name[4]);
			$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $img_name[4]);
			$new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
			// var_dump($new_string);exit;
			$cloudUrl[$i] = "https://res.cloudinary.com/ecologix/image/upload/".$barcode.'/'.$new_string;
            // var_dump($cloudUrl);exit;
			// var_dump($new_string );exit;
            if (is_array($parts) && count($parts) > 1){
                $extension = end($parts);
                if(!empty($extension)){
                	
	                // $live_path = $data['path_query'][0]['LIVE_PATH'];
                    $url = $parts['0'].'.'.$extension;

                    $url = preg_replace("/[\r\n]*/","",$url);

                    // var_dump($url);exit;
                    $uri[$i] = $url;
                    $img = file_get_contents($url);
                    // var_dump($url);exit;
                    $img =base64_encode($img);
                    $dekitted_pics[$i] = $img;



                    $i++;
                }
            }

		}
	}

	
	return array('dekitted_pics'=>$dekitted_pics,'parts'=>$parts,'uri'=>$uri,'cloudUrl'=>$cloudUrl);	

  }

public function save_hist_pic(){


	$fol_name = $this->input->post('fol_name');
	 $sav_pic = $this->db->query( "UPDATE LZ_SPECIAL_LOTS L SET L.FOLDER_NAME =$fol_name  where ");


}

public function getHistoryPics(){

	$upc = $this->input->post('upc');
	$condition_id = $this->input->post('condition_id');

	$get_fold = $this->db->query(" SELECT * FROM (SELECT L.FOLDER_NAME,L.MPN_DESCRIPTION,L.CARD_MPN,L.BRAND FROM LZ_SPECIAL_LOTS L WHERE L.CARD_UPC = '$upc' AND L.CONDITION_ID = '$condition_id' ORDER BY L.SPECIAL_LOT_ID DESC) WHERE ROWNUM <= 1 ")->result_array();
	

	if(count($get_fold) >=1){
	$folder_name = $get_fold[0]['FOLDER_NAME'];
	$mpn_description = $get_fold[0]['MPN_DESCRIPTION'];
	$card_mpn = $get_fold[0]['CARD_MPN'];
	$brand = $get_fold[0]['BRAND'];
	}else{
	$folder_name = '';
	$mpn_description = '';
	$card_mpn = '';
	$brand = '';
	}

	 $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
		$path = $path->result_array();
		//var_dump($path[0]["LIVE_PATH"]);exit;
		$livePath = $path[0]["MASTER_PATH"];
		// var_dump($livePath);
		$dir = $livePath.$folder_name;
		 // var_dump($dir);
		 // exit;
		$dir = preg_replace("/[\r\n]*/","",$dir);
		$dir_path = [];
		$parts = [];
		$image_url = [];
		if (is_dir($dir)){
			$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
			$i=0 ;

			foreach($images as $image){
				$parts = explode(".", $image);
                if (is_array($parts) && count($parts) > 1){
                    $extension = end($parts);
                    if(!empty($extension)){
		                // $live_path = $data['path_query'][0]['LIVE_PATH'];
	                    $url = $parts['0'].'.'.$extension;
	                    //var_dump($url);
	                    $url = preg_replace("/[\r\n]*/","",$url);
	                    $img_url = explode("\\", $url);
	                    $img_url = end($img_url);
	                    //var_dump($img_url);
	                    $image_url[$i] = $img_url;
	                    //var_dump($url);exit;
	                    $img = file_get_contents($url);
	                    $img =base64_encode($img);
	                    $dir_path[$i] = $img;
	                    $i++;
                    }
                }

			}
		}

		 // var_dump(count($dir_path));exit;
		return array('dir_path'=>$dir_path,'parts'=>$parts, 'image_url'=>$image_url,'folder_name'=>$folder_name,'mpn_description'=>$mpn_description,'card_mpn'=>$card_mpn,'brand'=>$brand);


}
////////////////////////////////////////////////
//											  //
////////////////////////////////////////////////
public function combine_pics(){

	$combin_pics =  $this->input->post('combin_pics');
	$copy_this_pic =  $this->input->post('get_barcode');

	$check_val = @$combin_pics[0];

	if($check_val != 'all' && $check_val != null){
            $cond_exp = '';
            $i = 0;
            foreach ($combin_pics as $comb_barc) {
              if(!empty($combin_pics[$i+1])){
              $cond_exp= $cond_exp . $comb_barc.',';
          
            }else{
              $cond_exp= $cond_exp . $comb_barc;
              }
          $i++; 
              
            }
          }

	// var_dump($cond_exp);
	// exit;

	$query  = $this->db->query("UPDATE LZ_SPECIAL_LOTS J SET J.FOLDER_NAME = '$copy_this_pic' WHERE J.BARCODE_PRV_NO IN ($cond_exp)");

	if($query){

		return true;
	}else{
		return false;
	}
	


}





public function get_unique_count_lot(){


	$this->session->unset_userdata('searchLots');
	$posts    = $this->input->post('lot_posting');
	$rslt     = $this->input->post('lot_date');
	$merch_id = $this->input->post('merch_id');
	$this->session->set_userdata('searchLots', ['session_posting'=>$posts, 'lotDateRange'=>$rslt]);
	$lotData =  $this->session->userdata('searchLots');

	$sql = "SELECT COUNT(*) UNIQ_ITEM FROM (SELECT M.FOLDER_NAME  /*(SELECT EE.USER_NAME FROM EMPLOYEE_MT EE WHERE EE.EMPLOYEE_ID = M.INSERTED_BY)USER_NAME_INS,O.OBJECT_NAME,DE.LOT_DESC L_DESC, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, E.USER_NAME, C.COND_NAME */FROM LZ_SPECIAL_LOTS M, LOT_DEFINATION_MT  DE, LZ_BD_OBJECTS_MT O, BIN_MT B, EMPLOYEE_MT  E, LZ_CATALOGUE_MT  P, LZ_ITEM_COND_MT C WHERE M.OBJECT_ID = O.OBJECT_ID(+) AND M.BIN_ID = B.BIN_ID(+) AND M.UPDATED_BY = E.EMPLOYEE_ID(+) AND M.CATALOG_MT_ID = P.CATALOGUE_MT_ID(+) AND M.LOT_ID = DE.LOT_ID(+) AND M.CONDITION_ID = C.ID(+) ";
	
			if($lotData['session_posting'] == 1 || $posts == 1){ // for posting
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);

				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');
				$date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL AND M.LZ_MANIFEST_DET_ID IS NOT NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
				if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
				$date_qry .= " group by folder_name ) ";
				$sql .= $date_qry;
			}elseif($lotData['session_posting'] == 2 || $posts == 2){ /// for non posting
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);
				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');	    
			    $date_qry = " AND (M.CARD_MPN IS NULL OR M.MPN_DESCRIPTION IS NULL OR M.BRAND IS NULL)  AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
			    if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
				$date_qry .= " group by folder_name ) ";
				$sql .= $date_qry;
			}elseif($lotData['session_posting'] == 0 || $posts == 0){ //// for all
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);

				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');
				$date_qry = "  AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
				if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
				$date_qry .= " group by folder_name ) ";
			    $sql .= $date_qry;
				
			}elseif($lotData['session_posting'] == 3 || $posts == 3) {
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);
				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');	    
			    $date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL  AND M.LZ_MANIFEST_DET_ID IS NULL AND M.LZ_MANIFEST_DET_ID IS NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
			    if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
				$date_qry .= " group by folder_name ) ";
				$sql .= $date_qry;
		    }else{
				$date_qry = "AND M.INSERTED_AT >= SYSDATE-1";
				$date_qry .= " group by folder_name ) ";
			    $sql .= $date_qry;
			}

			$query_count = $this->db->query($sql)->result_array(); 

			return array('query_count' =>$query_count);
		}


////////////////////////////////////////////////
//											  //
////////////////////////////////////////////////
	public function load_special_lots(){
		/////////////////////////////
			$requestData= $_REQUEST;
			$columns = array( 
			  0 =>'',
			  1 =>'',
			  2 =>'',
			  3 =>'ASSIGN_TO',
			  4 =>'BARCODE_PRV_NO',
			  5 =>'LOT_REMARKS',
			  6 =>'BARCODE NOTES',
			  7 =>'CARD_UPC',
			  8 =>'CARD_MPN',
			  9 =>'MPN_DESCRIPTION',
			  10 =>'CONDITION_ID',
			  11 =>'BRAND',
			  12 =>'BIN_NAME',		      
		      13 =>'PIC_NOTES',
		      14 =>'INSERTED_AT',
		      15 =>'INSERTED_BY',
		      16 =>'UPDATED_AT',
		      17 =>'UPDATED_BY',
		      18 =>'L_DESC'
		      
		    );

		    $this->session->unset_userdata('searchLots');
		    $posts    = $this->input->post('lot_posting');
	        $rslt     = $this->input->post('lot_date');
	        $merch_id = $this->input->post('merch_id');
	        $get_emp = $this->input->post('get_emp');
	        $lot_posting_chek = $this->input->post('lot_posting_chek');
	        
	        
	        $this->session->set_userdata('searchLots', ['session_posting'=>$posts, 'lotDateRange'=>$rslt]);
	        $lotData =  $this->session->userdata('searchLots');	        

		    $sql = "SELECT M.*, (SELECT EE.USER_NAME FROM EMPLOYEE_MT EE WHERE EE.EMPLOYEE_ID = M.INSERTED_BY)USER_NAME_INS,O.OBJECT_NAME,DE.LOT_DESC L_DESC, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, E.USER_NAME,C.COND_NAME, E1.USER_NAME ASSIGN_TO FROM LZ_SPECIAL_LOTS M,EMPLOYEE_MT e1, LOT_DEFINATION_MT  DE, LZ_BD_OBJECTS_MT O, BIN_MT B, EMPLOYEE_MT  E, LZ_CATALOGUE_MT  P, LZ_ITEM_COND_MT C WHERE M.OBJECT_ID = O.OBJECT_ID(+)  AND M.ALLOCATE_TO = E1.EMPLOYEE_ID(+) AND M.BIN_ID = B.BIN_ID(+) AND M.UPDATED_BY = E.EMPLOYEE_ID(+) AND M.CATALOG_MT_ID = P.CATALOGUE_MT_ID(+) AND M.LOT_ID = DE.LOT_ID(+) AND M.CONDITION_ID = C.ID(+) AND M.DISCARD <> 1 "; 

		    if(!empty($get_emp)){
					$sql .="AND M.ALLOCATE_TO = '$get_emp '";
				}

		    if($lotData['session_posting'] == 1 || $posts == 1){ // for posting 

		    	$rs = explode('-',$rslt);
			    $fromdate = @$rs[0];
			    $todate = @$rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);

				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');
				$date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL AND M.LZ_MANIFEST_DET_ID IS NOT NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

				

				if(!empty($lot_posting_chek)){
					$date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
				}
				if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}

				$sql .= $date_qry;
			}elseif($lotData['session_posting'] == 2 || $posts == 2){ /// for non posting
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);
				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');	    
			    $date_qry = " AND (M.CARD_MPN IS NULL OR M.MPN_DESCRIPTION IS NULL OR M.BRAND IS NULL)  AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
			    if(!empty($lot_posting_chek)){
					$date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
				}
			    if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
				$sql .= $date_qry;
			}elseif($lotData['session_posting'] == 0 || $posts == 0){ //// for all
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);

				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');
				$date_qry = "  AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
				if(!empty($lot_posting_chek)){
					$date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
				}
				if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
			    $sql .= $date_qry;
				
			}
			elseif($lotData['session_posting'] == 3 || $posts == 3) {
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);
				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');	    
			    $date_qry = " AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL  AND M.LZ_MANIFEST_DET_ID IS NULL AND M.LZ_MANIFEST_DET_ID IS NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
			    if(!empty($lot_posting_chek)){
					$date_qry .= "AND M.SPECIAL_LOT_ID  IN (SELECT MAX(L.SPECIAL_LOT_ID) SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS L GROUP BY L.FOLDER_NAME)";
				}
				
			    if(!empty($merch_id)){
				$date_qry .= "  AND M.BARCODE_PRV_NO IN (SELECT DET.BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT MT,LZ_MERCHANT_BARCODE_DT DET WHERE MT.MT_ID = DET.MT_ID AND MT.MERCHANT_ID = $merch_id)";
				}
				$sql .= $date_qry;
		    }
		    else{
				$date_qry = "AND M.INSERTED_AT >= SYSDATE-1";
			    $sql .= $date_qry;
			}
		    if(!empty($requestData['search']['value'])) {
		     // if there is a search parameter, $requestData['search']['value'] contains search parameter
		    	 $perm = trim(strtoupper($requestData['search']['value']));
			      	$sql.=" AND (M.SPECIAL_LOT_ID LIKE '%".$perm."%'"; 
			      	$sql.=" OR M.BARCODE_PRV_NO LIKE '%".$perm."%'";
			      	$sql.=" OR UPPER(E1.USER_NAME) LIKE '%".$perm."%'"; 
			      	$sql.=" OR M.CARD_UPC LIKE '%".$perm."%'";   
			      	$sql.=" OR UPPER(M.CARD_MPN) LIKE '%".$perm."%'";   
			      	$sql.=" OR UPPER(M.MPN_DESCRIPTION) LIKE '%".$perm."%'";   
		        	$sql.=" OR M.CONDITION_ID LIKE '%".$perm."%'"; 
		        	$sql.=" OR UPPER(M.BRAND) LIKE '%".$perm."%'"; 
		        	$sql.=" OR UPPER(M.LOT_REMARKS) LIKE '%".$perm."%'"; 
		        	$sql.=" OR UPPER(M.PIC_NOTES) LIKE '%".$perm."%'"; 
		        	$sql.=" OR M.INSERTED_AT LIKE '%".$perm."%'"; 
		        	$sql.=" OR M.INSERTED_BY LIKE '%".$perm."%'"; 
		        	$sql.=" OR M.UPDATED_AT LIKE '%".$perm."%'"; 
		        	$sql.=" OR M.UPDATED_BY LIKE '%".$perm."%'"; 
		        	$sql.=" OR UPPER(DE.LOT_DESC) LIKE '%".$perm."%'"; 
		        	$sql.=" OR UPPER(B.BIN_TYPE || '-' || B.BIN_NO) LIKE '%".$perm."%')"; 
			  }
			if (!empty($columns[$requestData['order'][0]['column']])) {
		    	$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		    }else{
		    	$sql .= " ORDER BY E1.USER_NAME DESC";
		    	//$sql .= " ORDER BY M.SPECIAL_LOT_ID DESC";
		    }
			
			//$query = $this->db->query($sql); 
		    $query = $this->db->query($sql);
		    $totalData = $query->num_rows();
		    $totalFiltered = $totalData; 

		    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
		    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
		    
		    /*=====  End of For Oracle 12-c  ======*/
		    $query = $this->db->query($sql);
		    $query = $query->result_array();
		    //////////////////////////////
		    //							//
		    //////////////////////////////
		    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
      		$path_query 	=  $path_query->result_array();
      		$master_path 	= $path_query[0]['MASTER_PATH'];
		    ////////////////////////////		   
		    $data = array();
		    $i =0;
		    
		    foreach($query as $row ){ 
		    	////////////////////////////
		    	$nestedData=array();
		    	$it_condition = '';
		    	$it_condition  = @$row['CONDITION_ID'];
                $folder_name = str_replace('/', '_', @$row['FOLDER_NAME']);

                $m_dir =  $master_path.@$folder_name."/thumb/";
                //var_dump($folder_name, $m_dir); exit;
                $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

                if(is_dir(@$m_dir)){
                            $iterator = new \FilesystemIterator(@$m_dir);
                            if (@$iterator->valid()){    
                              $m_flag = 1;
                          }else{
                            $m_flag = 0;
                          }
                      }else{
                        $m_flag = 0;
                      }
                      $card_upc = '';
                      $card_upc = $row['CARD_UPC'];
                      if ($card_upc == '') {
                      	$card_upc = 0;
                      }
                   
                  		$confirm_msg 		= "return confirm('Are you sure?')";

                  		$nestedData[] = '<div style="width: 60px!important;"> <div style="float:left;margin-left:18px;"> <input title="Combine Iages" type="checkbox" name="combin_pics[]" id="combin_pics"  value="'.@$row['BARCODE_PRV_NO'].'" > </div> </div>';

						$nestedData[]  	= '<div style="float:left;margin-right:5px;"><button title="Discard" class="btn btn-danger btn-xs flag-discard" style="width: 25px;" id="discard_'.@$row['BARCODE_PRV_NO'].'" dbarcode="'.@$row['BARCODE_PRV_NO'].'"><i class="fa fa-ban text text-center" aria-hidden="true"></i> </button></div><div class="edit_btun" target="_blank" style=" width: 200px; height: auto;"><a title="Delete" href="'.base_url().'catalogueToCash/c_card_lots/delete_lot/'.$row['SPECIAL_LOT_ID'].'" onclick="'.$confirm_msg.'" class="btn btn-danger btn-xs" style="margin-right:5px;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a><a target="_blank" title="Update Info" href="'.base_url().'catalogueToCash/c_card_lots/edit_lot/'.$row['SPECIAL_LOT_ID'].'/'.$row['BARCODE_PRV_NO'].'/'.$it_condition.'/'.$card_upc.'" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span> </a><a style="margin-left: 5px;" href="'.base_url().'catalogueToCash/c_card_lots/print_single_lot/'.$row['SPECIAL_LOT_ID'].'" class="btn btn-primary btn-xs" target="_blank" title="Print Sticker"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a><a style="margin-left: 5px;" href="'.base_url().'catalogueToCash/c_card_lots/print_all_sticker/'.$row['SPECIAL_LOT_ID'].'" class="btn btn-success btn-xs" target="_blank" title="Print All Sticker"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a><a style="margin-left: 5px;" id = "'.$row['BARCODE_PRV_NO'].'" class="btn btn-default btn-xs get_bar"  title="Assign this image to selected barcodes"> <span class="glyphicon glyphicon-copy" aria-hidden="true"></span> </a></div>';
						////////////////////////////
						//auto print button code commented bellow
						
							if($m_flag == 1){
      						if (is_dir($m_dir)){
		                        $images = scandir($m_dir);
	                            if (count($images) > 0) { // make sure at least one image exists
	                                $url = $images[2]; // first image
	                                if(!is_file($m_dir.$url)){
	                                	$url = $images[0];
	                                }// IMG DOWNLOADED FROM FIREBASE ARE AT 0 INDEX
	                                $img = file_get_contents($m_dir.$url);
	                                $img =base64_encode($img);
	                                $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			                            }else{
			                            $nestedData[] = 'Not Found';	
			                            }
		                          }else{
		                          	$nestedData[] = 'Not Found';
		                          }
		                      }else{
		                      	$nestedData[] = 'Not Found';
		                      }
		                     $nestedData[] = $row['ASSIGN_TO'];
		                     $nestedData[] = $row['BARCODE_PRV_NO'];
		                     $nestedData[] = $row['LOT_REMARKS'];
		                     $nestedData[] = $row['BARCODE_NOTES'];
		                     $nestedData[] = $row['CARD_UPC'];
		                     $nestedData[] = $row['CARD_MPN'];
		                     $nestedData[] = $row['MPN_DESCRIPTION'];
                       			 ///////////////////////////

		                 
	                    $nestedData[] = $row['COND_NAME'];
	                    
	                    $nestedData[] = $row['BRAND'];
	                    $nestedData[] = $row['BIN_ID'];
	                    $nestedData[] = $row['BIN_NAME'];
	                    
	                    $nestedData[] = $row['PIC_NOTES'];
	                    $nestedData[] = $row['INSERTED_AT'];
	                    $nestedData[] = ucfirst($row['USER_NAME_INS']);
	                    $nestedData[] = $row['UPDATED_AT'];
	                    $nestedData[] = $row['USER_NAME'];
	                    $nestedData[] = $row['L_DESC'];
	                    
                      
                        //////////////////////////
      					$data[] 		= $nestedData;
      					$i++;
    }
	/////////////////////////////
	 $json_data = array(
	          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	          "recordsTotal"    =>  intval($totalData),  // total number of records
	          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
	          "deferLoading"    =>  intval( $totalFiltered ),
	          "data"            => $data   // total data array
	          );
    return $json_data;
	}






/*=====  End of YOUSAF METHODS  ======*/
////////////////////////////////////////////////
//											  //
////////////////////////////////////////////////
	public function load_mpns_lots(){
		/////////////////////////////
			$requestData= $_REQUEST;
			$columns = array( 
			  0 =>'',
			  1 =>'',
			  2 =>'BARCODE_PRV_NO',
			  3 =>'CARD_UPC',
			  4 =>'CARD_MPN',
			  5 =>'MPN_DESCRIPTION',
			  6 =>'CONDITION_ID',
			  7 =>'BRAND',
			  8 =>'BIN_NAME',
		      9 =>'LOT_REMARKS',
		      10 =>'PIC_NOTES',
		      11 =>'INSERTED_AT',
		      12 =>'INSERTED_BY',
		      13 =>'UPDATED_AT',
		      14 =>'UPDATED_BY'
		    );

		    $this->session->unset_userdata('searchLots');
		    $posts    = $this->input->post('lot_posting');
	        $rslt     = $this->input->post('lot_date');
	        //var_dump($posts, $rslt); exit;
	        $this->session->set_userdata('searchLots', ['session_posting'=>$posts, 'lotDateRange'=>$rslt]);
	        $lotData =  $this->session->userdata('searchLots');

		    $sql = "SELECT M.*, O.OBJECT_NAME, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, E.USER_NAME, C.COND_NAME FROM LZ_SPECIAL_LOTS                 M, LZ_BD_OBJECTS_MT O, BIN_MT                          B, EMPLOYEE_MT                     E, LZ_CATALOGUE_MT  P, LZ_ITEM_COND_MT C WHERE M.OBJECT_ID = O.OBJECT_ID AND M.BIN_ID = B.BIN_ID AND M.INSERTED_BY = E.EMPLOYEE_ID AND M.CATALOG_MT_ID = P.CATALOGUE_MT_ID(+) AND C.ID = M.CONDITION_ID AND M.CARD_MPN IS NOT NULL AND M.MPN_DESCRIPTION IS NOT NULL AND M.BRAND IS NOT NULL AND M.PIC_DATE_TIME IS NOT NULL ";
			if($lotData['session_posting'] == 1 || $posts == 1){ // for posting
			    $this->session->set_userdata('lotDateRange', $rslt);
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);

				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');
				$date_qry = "  AND M.LZ_MANIFEST_DET_ID IS NOT NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
			    $sql .= $date_qry;
			}elseif($lotData['session_posting'] == 2 || $posts == 2){ /// for non posting
			    $this->session->set_userdata('lotDateRange', $rslt);
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);
				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');	    
			    $date_qry = " AND M.LZ_MANIFEST_DET_ID IS NULL AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
				$sql .= $date_qry;
			}elseif($lotData['session_posting'] == 0 || $posts == 0){ //// for all
				
				$this->session->set_userdata('lotDateRange', $rslt);
			    $rs = explode('-',$rslt);
			    $fromdate = $rs[0];
			    $todate = $rs[1];
			    /*===Convert Date in 24-Apr-2016===*/
			    $fromdate = date_create($rs[0]);
			    $todate = date_create($rs[1]);
				$from = date_format($fromdate,'Y-m-d');
				$to = date_format($todate, 'Y-m-d');	    
			    $date_qry = " AND M.INSERTED_AT BETWEEN TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
				$sql .= $date_qry;
			}else{
				$date_qry = "AND M.INSERTED_AT >= SYSDATE-1";
			    $sql .= $date_qry;
			}
		    if(!empty($requestData['search']['value'])) {
		     // if there is a search parameter, $requestData['search']['value'] contains search parameter
			      	$sql.=" AND (M.SPECIAL_LOT_ID LIKE '%".$requestData['search']['value']."%'"; 
			      	$sql.=" OR M.BARCODE_PRV_NO LIKE '%".$requestData['search']['value']."%'"; 
			      	$sql.=" OR M.CARD_UPC LIKE '%".$requestData['search']['value']."%'";   
			      	$sql.=" OR M.CARD_MPN LIKE '%".$requestData['search']['value']."%'";   
			      	$sql.=" OR M.MPN_DESCRIPTION LIKE '%".$requestData['search']['value']."%'";   
		        	$sql.=" OR M.CONDITION_ID LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.BRAND LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.LOT_REMARKS LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.PIC_NOTES LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.INSERTED_AT LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.INSERTED_BY LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.UPDATED_AT LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR M.UPDATED_BY LIKE '%".$requestData['search']['value']."%'"; 
		        	$sql.=" OR B.BIN_TYPE || '-' || B.BIN_NO LIKE '%".$requestData['search']['value']."%')"; 
			  }
			if (!empty($columns[$requestData['order'][0]['column']])) {
		    	$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		    }else{
		    	$sql .= " ORDER BY M.SPECIAL_LOT_ID DESC";
		    }
			
			$query = $this->db->query($sql); 
		    $query = $this->db->query($sql);
		    $totalData = $query->num_rows();
		    $totalFiltered = $totalData; 

		    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
		    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];

		    
		    /*=====  End of For Oracle 12-c  ======*/
		    $query = $this->db->query($sql);
		    $query = $query->result_array();
		    //////////////////////////////
		    //							//
		    //////////////////////////////
		    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
      		$path_query 	=  $path_query->result_array();
      		$master_path 	= $path_query[0]['MASTER_PATH'];
		    ////////////////////////////
		   
		    $data = array();
		    $i =0;
		    
		    foreach($query as $row ){ 
		    	////////////////////////////
		    	$nestedData=array();
		    	$it_condition = '';
		    	$it_condition  = @$row['CONDITION_ID'];
                $folder_name = str_replace('/', '_', @$row['FOLDER_NAME']);

                $m_dir =  $master_path.@$folder_name."/thumb/";
                //var_dump($folder_name, $m_dir); exit;
                $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
                if(is_dir(@$m_dir)){
                            $iterator = new \FilesystemIterator(@$m_dir);
                            if (@$iterator->valid()){    
                              $m_flag = 1;
                          }else{
                            $m_flag = 0;
                          }
                      }else{
                        $m_flag = 0;
                      }

                      $card_upc 		= $row['CARD_UPC'];
                      $card_mpn 		= $row['CARD_MPN'];

                  		$confirm_msg 		= "return confirm('Are you sure?')";
						$nestedData[]  	= '<div class="edit_btun" target="_blank" style=" width: 200px; height: auto;"><a title="Delete Template" href="'.base_url().'catalogueToCash/c_card_lots/delete_lot/'.$row['SPECIAL_LOT_ID'].'" onclick="'.$confirm_msg.'" class="btn btn-danger btn-xs" style="margin-right:5px;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a><a target="_blank" title="Edit Special Lot" href="'.base_url().'catalogueToCash/c_card_lots/edit_lot/'.$row['SPECIAL_LOT_ID'].'/'.$row['BARCODE_PRV_NO'].'/'.$it_condition.'/'.$card_upc.'" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span> </a><a style="margin-left: 5px;" href="'.base_url().'catalogueToCash/c_card_lots/print_single_lot/'.$row['SPECIAL_LOT_ID'].'" class="btn btn-primary btn-xs" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a><a style="margin-left: 5px;" href="'.base_url().'catalogueToCash/c_card_lots/print_single_lot_withoutPDF/'.$row['SPECIAL_LOT_ID'].'" class="btn btn-primary btn-xs" target="_blank">Auto Print</a></div>';
						////////////////////////////
							if($m_flag == 1){
      						if (is_dir($m_dir)){
		                        $images = scandir($m_dir);
	                            if (count($images) > 0) { // make sure at least one image exists
	                                $url = $images[2]; // first image
	                                $img = file_get_contents($m_dir.$url);
	                                $img =base64_encode($img);
	                                $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			                            }else{
			                            $nestedData[] = 'Not Found';	
			                            }
		                          }else{
		                          	$nestedData[] = 'Not Found';
		                          }
		                      }else{
		                      	$nestedData[] = 'Not Found';
		                      }
		                     $nestedData[] = $row['BARCODE_PRV_NO'];
		                     $nestedData[] = $row['CARD_UPC'];
		                     $nestedData[] = $row['CARD_MPN'];
		                     $nestedData[] = $row['MPN_DESCRIPTION'];
                       			 ///////////////////////////
		                     
			                    
		                 
	                    $nestedData[] = $row['COND_NAME'];
	                    
	                    $nestedData[] = $row['BRAND'];
	                    $nestedData[] = $row['BIN_ID'];
	                    $nestedData[] = $row['BIN_NAME'];
	                    $nestedData[] = $row['LOT_REMARKS'];
	                    $nestedData[] = $row['PIC_NOTES'];
	                    $nestedData[] = $row['INSERTED_AT'];
	                    $nestedData[] = ucfirst($row['USER_NAME']);
	                    $nestedData[] = $row['UPDATED_AT'];
	                    $nestedData[] = $row['USER_NAME'];
                      
                        //////////////////////////
      					$data[] 		= $nestedData;
      					$i++;
    }
	/////////////////////////////
	 $json_data = array(
	          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	          "recordsTotal"    =>  intval($totalData),  // total number of records
	          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
	          "deferLoading"    =>  intval( $totalFiltered ),
	          "data"            => $data   // total data array
	          );
    return $json_data;
	}
/*=====  End of YOUSAF METHODS  ======*/
	public function edit_lot(){
	  	$special_lot_id 		= $this->uri->segment(4);
	  	$barcode 				= $this->uri->segment(5);
	  	//$card_mpn 			= strtoupper(trim($this->uri->segment(6)));
	  	$condition_id 			= $this->uri->segment(6);
	  	$card_upc 			    = $this->uri->segment(7);

	  	if(!empty($condition_id) AND strlen($card_upc) > 5){
	  		$item_history = $this->db->query("SELECT * FROM (SELECT L.*,M.CATEGORY_ID FROM LZ_SPECIAL_LOTS L,LZ_BD_OBJECTS_MT M WHERE L.CARD_UPC = '$card_upc' AND L.OBJECT_ID = M.OBJECT_ID(+) AND L.CONDITION_ID = $condition_id AND L.MPN_DESCRIPTION IS NOT NULL ORDER BY L.SPECIAL_LOT_ID DESC) WHERE ROWNUM = 1")->result_array(); 
	  		if(count($item_history) == 0){
	  			$item_history = $this->db->query("SELECT * FROM (SELECT L.*,M.CATEGORY_ID FROM LZ_SPECIAL_LOTS L,LZ_BD_OBJECTS_MT M WHERE L.CARD_UPC = '$card_upc' AND L.OBJECT_ID = M.OBJECT_ID(+) AND L.MPN_DESCRIPTION IS NOT NULL ORDER BY L.SPECIAL_LOT_ID DESC) WHERE ROWNUM = 1")->result_array();
	  		}
	  	}elseif(strlen($card_upc) > 5){
	  		$item_history = $this->db->query("SELECT * FROM (SELECT L.*,M.CATEGORY_ID FROM LZ_SPECIAL_LOTS L,LZ_BD_OBJECTS_MT M WHERE L.CARD_UPC = '$card_upc' AND L.OBJECT_ID = M.OBJECT_ID(+) AND L.MPN_DESCRIPTION IS NOT NULL ORDER BY L.SPECIAL_LOT_ID DESC) WHERE ROWNUM = 1")->result_array(); 
	  	}else{
	  		$item_history = $this->db->query("SELECT * FROM LZ_SPECIAL_LOTS L WHERE L.SPECIAL_LOT_ID = '$special_lot_id'")->result_array();	
	  	}

	  	$update_note = $this->db->query("SELECT M.*, O.OBJECT_NAME,O.CATEGORY_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, E.USER_NAME FROM LZ_SPECIAL_LOTS  M, LZ_BD_OBJECTS_MT O, BIN_MT B, EMPLOYEE_MT E, LZ_CATALOGUE_MT P WHERE M.OBJECT_ID = O.OBJECT_ID(+) AND M.BIN_ID = B.BIN_ID(+) AND M.INSERTED_BY = E.EMPLOYEE_ID AND M.CATALOG_MT_ID = P.CATALOGUE_MT_ID(+) AND M.SPECIAL_LOT_ID = $special_lot_id")->result_array(); 
	  	return array("item_history"=>$item_history, "update_note"=>$update_note);
	 }
	 public function delete_lot(){

	  	$special_lot_id = $this->uri->segment(4);

	  	$delete_lot = $this->db->query("DELETE FROM LZ_SPECIAL_LOTS  M WHERE  M.SPECIAL_LOT_ID = $special_lot_id"); 
	  	if ($delete_lot) {
	  		  ////////////////////////////////////////
       /* $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 5");
        $master_qry = $query->result_array();
        $master_path = $master_qry[0]['MASTER_PATH'];
        //$dir = $master_path.$barcode;
        $dir = $master_path;
        //var_dump($dir); exit;
        // Open a directory, and read its contents
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            //$i=1;
            while (($file = readdir($dh)) !== false){
                $parts = explode(".", $file);
                if (is_array($parts) && count($parts) > 1){
                    $extension = end($parts);
                    if(!empty($extension)){
                        //$img_name = explode('_', $master_reorder[$i-1]);
                        //rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
                        @$img_order = unlink($dir."/".$parts['0'].".".$extension);
                    }
                }

            }//end while

            closedir($dh);

          }// sub if
        }//main if*/
         ////////////////////////////////////////
	  		return 1;
	  	}else{
	  		return 0;
	  	}
	 }
	 public function print_single_lot(){
		$special_lot_id = $this->uri->segment(4);
		///var_dump($special_lot_id); exit;
	    $print_qry = $this->db->query("SELECT S.BARCODE_PRV_NO, S.CARD_UPC, S.CARD_MPN, C.COND_NAME, O.OBJECT_NAME FROM LZ_SPECIAL_LOTS S, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT C WHERE S.OBJECT_ID = O.OBJECT_ID AND S.CONDITION_ID = C.ID AND S.SPECIAL_LOT_ID = $special_lot_id");
	    return $print_qry->result_array();

	}

	 public function print_single_lot_withoutPDF(){
		$special_lot_id = $this->uri->segment(4);
		///var_dump($special_lot_id); exit;
	    $print_qry = $this->db->query("SELECT S.BARCODE_PRV_NO, S.CARD_UPC, S.CARD_MPN, C.COND_NAME, O.OBJECT_NAME FROM LZ_SPECIAL_LOTS S, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT C WHERE S.OBJECT_ID = O.OBJECT_ID AND S.CONDITION_ID = C.ID AND S.SPECIAL_LOT_ID = $special_lot_id"); 
	    return $print_qry->result_array();

	}
	public function print_all_sticker(){
		$special_lot_id = $this->uri->segment(4);
		
		$get_folder = $this->db->query("SELECT L.FOLDER_NAME FROM LZ_SPECIAL_LOTS L WHERE L.SPECIAL_LOT_ID = $special_lot_id")->result_array();
		$folder_name = $get_folder[0]['FOLDER_NAME'];
		
		///var_dump($special_lot_id); exit;
	    $print_qry = $this->db->query("SELECT S.BARCODE_PRV_NO, S.CARD_UPC, S.CARD_MPN, C.COND_NAME, O.OBJECT_NAME FROM LZ_SPECIAL_LOTS S, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT C WHERE S.OBJECT_ID = O.OBJECT_ID AND S.CONDITION_ID = C.ID AND S.FOLDER_NAME = $folder_name AND S.LZ_MANIFEST_DET_ID IS NULL ORDER BY S.SPECIAL_LOT_ID ASC"); 
	    return $print_qry->result_array();

	}

 //  public function post_special_lot(){
 //  	$special_lot_id = $this->input->post('special_lot_id');
 //  	$get_data = $this->db->query("SELECT L.CARD_UPC , L.CARD_MPN FROM LZ_SPECIAL_LOTS L WHERE L.SPECIAL_LOT_ID = $special_lot_id")->result_array();
	// $card_mpn = $get_data[0]['CARD_MPN'];
	// $card_upc = $get_data[0]['CARD_UPC'];
	// $insert_by = $this->session->userdata('user_id'); 
    
 //    $query = $this->db->query("call PRO_SINGLE_INSERT_LOTS('$card_upc' , '$card_mpn', $insert_by) ");
 //    if($query){
 //    	return 1;
 //    }else{
 //    	return 0;
 //    }
          	
	// }

	public function post_special_lot(){ 
  	$special_lot_id = $this->input->post('special_lot_id');
  	$get_data = $this->db->query("SELECT trim(L.CARD_UPC) CARD_UPC, UPPER(trim(L.CARD_MPN)) CARD_MPN FROM LZ_SPECIAL_LOTS L WHERE L.SPECIAL_LOT_ID = $special_lot_id")->result_array();
	$card_mpn = $get_data[0]['CARD_MPN'];
	$card_upc = $get_data[0]['CARD_UPC'];
	$insert_by = $this->session->userdata('user_id'); 

	if(!empty($card_upc) AND !empty($card_mpn)){

		$query = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' ,  '=''$card_mpn''', $insert_by) ");


	}elseif (!empty($card_upc) AND empty($card_mpn)) {
		$query = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' , ' IS NULL', $insert_by) ");


	}elseif (empty($card_upc) AND !empty($card_mpn)) {
		$query = $this->db->query("call PRO_SINGLE_INSERT_LOTS(' IS NULL' , '=''$card_mpn''', $insert_by) ");


	}elseif (empty($card_upc) AND empty($card_mpn)) {
		die('UPC and Mpn is required');
	}

    if($query){
    	return 1;
    }else{
    	return 0;
    }
          	
	}

	public function get_obj_id(){
   	 
   	 $get_obj_id = $this->input->post('get_obj_id');

   	 $quer = $this->db->query("SELECT M.CATEGORY_ID FROM LZ_BD_OBJECTS_MT M WHERE M.OBJECT_ID =$get_obj_id  AND M.CATEGORY_ID IS NOT NULL")->result_array();

   	 if(count($quer) >0){
   	 	$get_cat_id  = $quer[0]['CATEGORY_ID'];

   	 	$get_cond = $this->db->query( "SELECT C.CONDITION_ID,M.COND_NAME FROM LZ_BD_CAT_COND C,LZ_ITEM_COND_MT M WHERE C.CATEGORY_ID = $get_cat_id AND C.CONDITION_ID = M.ID" )->result_array();


   	 	if(count($get_cond) > 0){

   	 	return array('quer' => $quer,'get_cond'=> $get_cond ,'cond_exist'=>true);
   	 	}else{
   	 		$get_all_cond = $this->db->query('SELECT CC.ID CONDITION_ID,CC.COND_NAME FROM LZ_ITEM_COND_MT CC')->result_array();

   	 		 return array('quer' => $quer,'get_cond'=> $get_cond,'get_all_cond'=> $get_all_cond,'exist'=>true,'cond_exist'=>false);
   	 	}
   	 	

   	 }else{
   	 	return array('exist'=>false);
   	 	
   	 }

    }


    public function get_cat_avail_cond(){

    	$card_category = $this->input->post('card_category');

    	$get_cond = $this->db->query( "SELECT C.CONDITION_ID,M.COND_NAME FROM LZ_BD_CAT_COND C,LZ_ITEM_COND_MT M WHERE C.CATEGORY_ID = $card_category AND C.CONDITION_ID = M.ID" )->result_array();

    	


    	 if(count($get_cond) > 0){
    	 	// get object query
    	 	$get_obj = $this->db->query("SELECT * FROM (SELECT OB.OBJECT_ID, OB.OBJECT_NAME FROM LZ_BD_OBJECTS_MT OB WHERE OB.CATEGORY_ID = '$card_category' ORDER BY OBJECT_ID DESC) WHERE ROWNUM <= 1 ")->result_array();

    	 	if(count($get_obj) > 0){
    	 		$get_obj_name  = $get_obj[0]['OBJECT_NAME'];
    	 		return array('get_cond'=> $get_cond ,'get_obj_name'=>$get_obj_name,'cond_exist'=>true);

    	 	}else{
    	 		$get_obj_name  = '';
    	 		return array('get_cond'=> $get_cond ,'get_obj_name'=>$get_obj_name,'cond_exist'=>true);
    	 	}

   	 	

   	 	}else{   	 		

   	 		$get_all_cond = $this->db->query('SELECT CC.ID CONDITION_ID,CC.COND_NAME FROM LZ_ITEM_COND_MT CC')->result_array();

   	 		// get object query
    	 	$get_obj = $this->db->query("SELECT * FROM (SELECT OB.OBJECT_ID, OB.OBJECT_NAME FROM LZ_BD_OBJECTS_MT OB WHERE OB.CATEGORY_ID = '$card_category' ORDER BY OBJECT_ID DESC) WHERE ROWNUM <= 1 ")->result_array();
    	 	if(count($get_obj) > 0){
    	 		$get_obj_name  = $get_obj[0]['OBJECT_NAME'];
    	 		return array('get_all_cond'=> $get_all_cond,'get_obj_name'=>$get_obj_name,'cond_exist'=>false);

    	 	}else{
    	 		$get_obj_name  = '';
    	 		return array('get_all_cond'=> $get_all_cond,'get_obj_name'=>$get_obj_name,'cond_exist'=>false);
    	 	}

   	 		 
   	 	}


    }

    public function upda_remar_only(){

    	$special_lot_id = $this->input->post('special_lot_id');
    	$up_remarks = $this->input->post('up_remarks');

    	$remrk = trim(str_replace("  ", ' ', $up_remarks));
        $remrk = str_replace(array("`,′"), "", $remrk);
        $remrk = str_replace(array("'"), "''", $remrk);

    	$query = $this->db->query("UPDATE LZ_SPECIAL_LOTS LL SET LL.LOT_REMARKS = '$remrk' WHERE LL.SPECIAL_LOT_ID =$special_lot_id ");

    	if($query){
    		return true;
    	}else{
    		return false;
    	}
    }
    public function discardBarcode(){

    $barcode = $this->input->post('bar');
    $user_id = $this->session->userdata('user_id'); 
    date_default_timezone_set("America/Chicago");
    $dated = date("Y-m-d H:i:s");
    $dated= "TO_DATE('".$dated."', 'YYYY-MM-DD HH24:MI:SS')";

    $qry = $this->db->query("UPDATE LZ_SPECIAL_LOTS L SET L.DISCARD = 1 , L.DISCARD_DATE = $dated, L.DISCARD_BY = '$user_id' WHERE L.BARCODE_PRV_NO = '$barcode'");
      if($qry){
        return 1;
      }else{
        return 0;
      }
    
    }
}