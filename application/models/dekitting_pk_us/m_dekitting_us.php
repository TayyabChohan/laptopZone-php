<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_dekitting_us extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }
 
/*======================================
=            ADIL METHODS            =
======================================*/

public function last_ten_barcode(){

	$last_ten =$this->db->query(" SELECT* FROM (SELECT D.BARCODE_NO,I.ITEM_DESC,C.COND_NAME,I.ITEM_MT_MANUFACTURE,I.ITEM_MT_MFG_PART_NO,I.ITEM_MT_UPC FROM LZ_DEKIT_US_MT D, LZ_BARCODE_MT B,ITEMS_MT I,LZ_ITEM_COND_MT C WHERE D.BARCODE_NO = B.BARCODE_NO AND B.ITEM_ID = I.ITEM_ID AND B.CONDITION_ID = C.ID ORDER BY D.BARCODE_NO DESC) WHERE ROWNUM <= 10 ")->result_array();

	return array('last_ten' => $last_ten);


	 }

	
public function obj_dropdown(){
$category = $this->input->post('category');
 
$obj = $this->db->query("SELECT DISTINCT O.OBJECT_NAME , O.OBJECT_ID FROM LZ_BD_CAT_GROUP_DET DT,LZ_BD_OBJECTS_MT O WHERE DT.LZ_BD_GROUP_ID = 3 AND DT.CATEGORY_ID = O.CATEGORY_ID 	ORDER BY O.OBJECT_ID DESC")->result_array();

$bin = $this->db->query(" SELECT B.BIN_ID, B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO FROM BIN_MT B WHERE BIN_TYPE <> 'NA'AND BIN_TYPE IN( 'TC','NB') ORDER BY BIN_NO ASC ")->result_array();
// $rack_bin_id = $this->session->userdata('rack_bin_id');
// if (empty($rack_bin_id)) {
// 	$rack_bin_id = '';
// }
return array('obj' => $obj,'bin' => $bin); 
//}
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
//if condiotion check for barcode if exist in lz_barcode_MT end
//******************************************************************************************
//******************************************************************************************
// if ($this->db->trans_status() === FALSE){
// 						     $this->db->trans_rollback();
// 						//     $flag = 0;
// 						} else {
							
// 							$this->db->trans_commit();
// 							//$flag = 1;
// 						}

	
}


public function save_mast_barcode_qty(){
	//$this->db->trans_begin();
	// **** variable declaration for insertion into LZ_DEKIT_US_MT,LZ_DEKIT_US_DT start ****
	//**************************************************************************************
	$master_barcode= $this->input->post('master_barcode');
	$bar_qty= $this->input->post('bar_qty');

	$user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
	$get_user = $this->session->userdata('user_id');

	$get_dek_bar = $this->db->query("SELECT D.LZ_DEKIT_US_MT_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND ROWNUM <=1 "); 

	if($get_dek_bar->num_rows() > 0) {
		$get_rec = $get_dek_bar->result_array();
		$get_det_id = $get_rec[0]['LZ_DEKIT_US_MT_ID'];

		for ($p=0; $p < $bar_qty; $p++ ):

				$sequn = $this->db->query("SELECT SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
				$bar_sq = $sequn[0]['ID'];
                  
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_DT', 'LZ_DEKIT_US_DT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $lz_dekit_us_dt_id = $qry[0]['ID'];
                $insert_est_det = $this->db->query("INSERT INTO LZ_DEKIT_US_DT (LZ_DEKIT_US_DT_ID,LZ_DEKIT_US_MT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,IDENT_DATE_TIME,IDENTIFIED_BY,DEKIT_REMARKS,WEIGHT,CONDITION_ID)VALUES($lz_dekit_us_dt_id,$get_det_id,$bar_sq,null,null,null,null,null,null,null,null,null,null)");
		endfor;
	if($insert_est_det){
	return true;	
	}
	
	}else{



	$load_dekit_check = $this->db->query("SELECT B.BARCODE_NO,B.ITEM_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET DE,ITEMS_MT I WHERE B.BARCODE_NO = $master_barcode AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DE.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND ROWNUM <=1 ");

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

		for ($p=0; $p < $bar_qty; $p++ ):

			// $dek_remark = trim(str_replace("  ", ' ', $dek_remarks[$i]));
      			
   //     	 		$dek =str_replace("'", "''", $dek_remark);

				$sequn = $this->db->query("SELECT /*GET_SINGLE_PRIMARY_KEY('LZ_BARCODE_MT','BARCODE_NO')*/SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
				$bar_sq = $sequn[0]['ID'];
                  
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_DT', 'LZ_DEKIT_US_DT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $lz_dekit_us_dt_id = $qry[0]['ID'];
                $insert_est_det = $this->db->query("INSERT INTO LZ_DEKIT_US_DT (LZ_DEKIT_US_DT_ID,LZ_DEKIT_US_MT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,IDENT_DATE_TIME,IDENTIFIED_BY,DEKIT_REMARKS,WEIGHT,CONDITION_ID)VALUES($lz_dekit_us_dt_id,$lz_dekit_us_mt_id,$bar_sq,null,null,null,null,null,null,null,null,null,null)");


		endfor;

		
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
 			
 		 $mpn_data = $this->db->query("SELECT MT.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN) = '$item_mpn' AND TO_CHAR(MT.CATEGORY_ID) = '$category_id'");
 		 

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

}/// main if end for further add quantity

	
}



public function add_onupdate(){

	$master_barcode = $this->input->post('master_barcode');
	$cond_item = $this->input->post('up_cond_item');
	// var_dump($cond_item );
	// exit;
	$object_desc = $this->input->post('up_object_desc');
	$bin_rack = $this->input->post('up_bin_rack');
	$weight_in = $this->input->post('up_weight_in');
	$dek_remarks = $this->input->post('up_remarks');
	$user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

	$i=0;
		foreach ($weight_in as $comp) {
				
				$dek_remark = trim(str_replace("  ", ' ', $dek_remarks[$i]));
       //if(isset($dek_remarks)){
       	  $dek =str_replace("'", "''", $dek_remark);
     //  }
      // var_dump($dek_remark);


				$lz_dekit_us_mt_id = $this->db->query("SELECT M.LZ_DEKIT_US_MT_ID  FROM LZ_DEKIT_US_MT M WHERE M.BARCODE_NO = $master_barcode")->result_array();
				$lz_dekit_us_mt_id = $lz_dekit_us_mt_id[0]['LZ_DEKIT_US_MT_ID'];

				$sequn = $this->db->query("SELECT /*GET_SINGLE_PRIMARY_KEY('LZ_BARCODE_MT','BARCODE_NO')*/SEQ_BARCODE_NO.NEXTVAL as ID FROM DUAL")->result_array();
				$bar_sq = $sequn[0]['ID'];
                  
                $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_DEKIT_US_DT', 'LZ_DEKIT_US_DT_ID')ID FROM DUAL");
                $qry = $qry->result_array();
                $lz_dekit_us_dt_id = $qry[0]['ID'];
                $insert_est_det = $this->db->query("INSERT INTO LZ_DEKIT_US_DT (LZ_DEKIT_US_DT_ID,LZ_DEKIT_US_MT_ID,BARCODE_PRV_NO,OBJECT_ID,BIN_ID,PIC_DATE_TIME,PIC_BY,CATALOG_MT_ID,IDENT_DATE_TIME,IDENTIFIED_BY,DEKIT_REMARKS,WEIGHT,CONDITION_ID) VALUES($lz_dekit_us_dt_id,$lz_dekit_us_mt_id,$bar_sq,'$object_desc[$i]','$bin_rack[$i]',null,null,null,null,null,'$dek',$weight_in[$i],'$cond_item[$i]')");

			

                  $i++;
                } /// end foreach

return true;

}	
/*=====  End of ADIL METHODS  ======*/
/*======================================*/



	
/*======================================
=            YOUSAF METHODS            =
======================================*/
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

		$det = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID,C.COND_NAME,DECODE(D.PRINT_STATUS,0,'False',1,'True',D.PRINT_STATUS) PRINT_STATUS,D.BARCODE_PRV_NO,B.BIN_TYPE ||'-'|| B.BIN_NO BIN_NO,O.OBJECT_NAME,D.DEKIT_REMARKS,D.PIC_NOTES,D.WEIGHT,D.CONDITION_ID FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B,LZ_ITEM_COND_MT C WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID(+) AND B.BIN_ID (+)= D.BIN_ID  AND D.CONDITION_ID = C.ID(+) ORDER BY D.BARCODE_PRV_NO desc"); $det = $det->result_array();
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

		$listing_qry = $this->db->query("SELECT CO.COND_NAME ITEM_DESC ,'MB' || '-' || M.BARCODE_NO BARCODE_NO,D.barcode_prv_no BAR_CODE, o.object_name, '1' LOT_NO, 'PO_DETAIL_LOT_REF' PO_DETAIL_LOT_REF, 'UNIT_NO' UNIT_NO, '1' LOT_QTY FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D, LZ_BD_OBJECTS_MT O, BIN_MT B,lz_item_cond_mt co WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.PRINT_STATUS = 0 and d.condition_id = co.id(+) AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.BIN_ID = B.BIN_ID (+) order by d.barcode_prv_no Desc")->result_array();
		

		$this->db->query("UPDATE LZ_DEKIT_US_DT L SET L.PRINT_STATUS = 1 WHERE L.BARCODE_PRV_NO IN ( SELECT D.BARCODE_PRV_NO BAR_CODE FROM LZ_DEKIT_US_MT   M, LZ_DEKIT_US_DT   D, LZ_BD_OBJECTS_MT O, BIN_MT B, LZ_ITEM_COND_MT  CO WHERE M.BARCODE_NO = $master_barcode AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.CONDITION_ID = CO.ID(+) AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.BIN_ID = B.BIN_ID(+) AND D.PRINT_STATUS = 0 ) ");
		return $listing_qry;


		 }
	public function print_single_us_pk(){

		$lz_dekit_us_dt_id = $this->uri->segment(4);
		// $manifest_id =	$this->uri->segment(5);
		// $barcode = $this->uri->segment(6);


	    $print_qry = $this->db->query("SELECT CO.COND_NAME ITEM_DESC, D.LZ_DEKIT_US_DT_ID, D.BARCODE_PRV_NO BAR_CODE, O.OBJECT_NAME, '1' LOT_NO, 'PO_DETAIL_LOT_REF' PO_DETAIL_LOT_REF, 'UNIT_NO' UNIT_NO, '1' LOT_QTY, 'MB' || '-' || MT.BARCODE_NO BARCODE_NO FROM LZ_DEKIT_US_DT D,LZ_DEKIT_US_MT MT ,LZ_BD_OBJECTS_MT O, BIN_MT B, LZ_ITEM_COND_MT CO WHERE D.CONDITION_ID = CO.ID(+) AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND D.BIN_ID = B.BIN_ID(+) AND D.LZ_DEKIT_US_DT_ID = $lz_dekit_us_dt_id "); //$query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");
	    //var_dump($print_qry);exit;
	    return $print_qry->result_array();

	}
	
	/*=====  End of Section comment block  ======*/

	/*==========================================================
	=            Show details on Add Picture Screen            =
	==========================================================*/
	
	public function getPrvDetails(){
		$barcode = $this->input->post('child_barcode');

		$details = $this->db->query("SELECT COND_NAME FROM LZ_DEKIT_US_DT D, LZ_ITEM_COND_MT C WHERE C.ID = D.CONDITION_ID AND D.BARCODE_PRV_NO = $barcode");

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

		 $updateqry = $this->db->query("UPDATE LZ_DEKIT_US_DT  SET OBJECT_ID ='$object' ,BIN_ID = '$bin' , CONDITION_ID = '$condition', WEIGHT = '$weight', DEKIT_REMARKS = '$dekit_remark' where LZ_DEKIT_US_DT_ID = $det_id");	

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
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    /*=======================================
    =            For Oracle 12-c            =
    =======================================*/
      // $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
    
    
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
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    /*=======================================
    =            For Oracle 12-c            =
    =======================================*/
      // $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
    
    
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

      // $images = glob($m_dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
	      // var_dump(count($images));exit;
	  //     if(count($images)>0){
			// $uri[$i] = $images[0];
			// $parts = explode(".", $images[0]);

			// $img_name = explode("/",$images[0]);
			// $img_n = explode(".",$img_name[5]);
			// $str = preg_replace('/[^A-Za-z0-9\. -]/', '', $img_name[5]);
			// $new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
			
			// // var_dump($new_string);exit;
			// // $local_path = $master_path.$row['BARCODE_PRV_NO']."/thumb/".$new_string;

			// $local_path = base64_encode($images[0]);
			// // $cloudUrl = "https://res.cloudinary.com/ecologix/image/upload/".$row['BARCODE_PRV_NO']."/thumb/".$new_string;	      	
	  //  }
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


	// public function checkNonPictures(){
	// 	$qry = $this->db->query("SELECT D.BARCODE_PRV_NO,C.COND_NAME FROM LZ_DEKIT_US_DT D,LZ_ITEM_COND_MT C WHERE D.CONDITION_ID = C.ID ORDER BY D.BARCODE_PRV_NO asc");
	// 	$qry = $qry->result_array();

	// 	$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
	// 	$path = $path->result_array();
	// 	$pics = [];

	// 	$nonPics=[];

	// 	$flag = [];
	// 	$i = 0;
	// 	$j = 0;
	// 	$master_path = $path[0]["MASTER_PATH"];
	// 	$dir_path = [];

	// 	foreach($qry as $row){
	// 		$barcode_prv_no = $row['BARCODE_PRV_NO'];

	// 		$condition = $row['COND_NAME'];

	// 		$m_dir =  $master_path.$barcode_prv_no."/thumb/";
		        
	// 	    $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

	//         if(is_dir(@$m_dir)){
	//         	// var_dump($m_dir);exit;
 //                $iterator = new \FilesystemIterator(@$m_dir);
 //                // var_dump($iterator);
 //                if (@$iterator->valid()){    
 //                  $m_flag = true;
 //                  $flag[$i] = $m_flag;

 //                   $images = scandir($m_dir);
						
 //                  if (count($images) > 0) { // make sure at least one image exists
 //                      // $url = $images[2]; // first image
 //                      // $img = file_get_contents($m_dir.$url);
 //                      // // var_dump($img);exit;
 //                      // $img =base64_encode($img);
 //                      // $dir_path[$i] = $img;
 //                  	// $record = $this->db->query("SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID=B.BIN_ID  AND D.BARCODE_PRV_NO = $barcode_prv_no");
 //                  	// $record = $record->result_array();

 //                  	$pics[$i] = '';
 //                  	$i++;

	// 			}
            
 //        	}else{
	// 			// var_dump('yes');exit;
	// 			$record = $this->db->query("SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID = B.BIN_ID  AND D.BARCODE_PRV_NO = $barcode_prv_no");
	//             $record = $record->result_array();
	//             $nonPics[$j] = $record;
	//             $j++;
	// 		}
		
	// 	}else{
	// 		$record = $this->db->query("SELECT D.BARCODE_PRV_NO,D.WEIGHT,D.DEKIT_REMARKS,C.COND_NAME,O.OBJECT_NAME,B.BIN_NO FROM LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,LZ_ITEM_COND_MT C, BIN_MT B WHERE D.CONDITION_ID = C.ID AND D.OBJECT_ID = O.OBJECT_ID AND D.BIN_ID = B.BIN_ID  AND D.BARCODE_PRV_NO = $barcode_prv_no");
 //            $record = $record->result_array();
 //            $nonPics[$j] = $record;
 //            $j++;
	// 	}
		
	// }
	// 	return  array('res'=>2,'flag'=>$flag,'dir_path'=>$dir_path,'pics'=>$pics,'nonPics'=>$nonPics);
	// }



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

		$path = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
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

	public function get_my_dekited_pic(){
	$barcode = $this->input->post('barcode');
  	//$condition = $this->input->post('condition');

	$path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
	$path = $path->result_array();  	

	$master_path = $path[0]["MASTER_PATH"];

	$qry = $this->db->query("SELECT FOLDER_NAME FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = $barcode");
	$qry = $qry->result_array();  	

	$barcode = $qry[0]["FOLDER_NAME"];
	
	$dir = $master_path.$barcode."/";//getBarcodePrv_no
	// $dir = $master_path.$getBarcodePrv_no."/thumb/";
	// var_dump($dir);exit;
	$dir = preg_replace("/[\r\n]*/","",$dir);

	$mdir = $master_path.$barcode."/";
	//var_dump($dir);exit;
	$dekitted_pics = [];
	$parts = [];
	$uri = [];
	
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
			//$cloudUrl[$i] = "https://res.cloudinary.com/ecologix/image/upload/".$barcode.'/'.$new_string;
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
                     //var_dump($url);exit;
                    $img =base64_encode($img);
                    $dekitted_pics[$i] = $img;



                    $i++;
                }
            }

		}
	}

	
	return array('dekitted_pics'=>$dekitted_pics,'parts'=>$parts,'uri'=>$uri);
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


public function getHistoryPics(){

	$barcode = $this->input->post('barcode');
  	$condition = $this->input->post('condition');

	$getMpn = $this->db->query("SELECT I.ITEM_MT_MFG_PART_NO, DT.OBJECT_ID FROM LZ_DEKIT_US_DT DT, LZ_DEKIT_US_MT MT,LZ_BARCODE_MT B, ITEMS_MT I WHERE DT.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND B.BARCODE_NO = MT.BARCODE_NO AND B.ITEM_ID = I.ITEM_ID AND DT.BARCODE_PRV_NO = $barcode");

	  $getMpn = $getMpn->result_array();
	  $mpn = $getMpn[0]["ITEM_MT_MFG_PART_NO"];
	  $OBJECT_ID = $getMpn[0]["OBJECT_ID"];

	  $getMasterBarcodeId = $this->db->query("SELECT D.LZ_DEKIT_US_MT_ID FROM LZ_DEKIT_US_MT D, LZ_BARCODE_MT B , ITEMS_MT I WHERE I.ITEM_ID = B.ITEM_ID AND B.BARCODE_NO = D.BARCODE_NO AND I.ITEM_MT_MFG_PART_NO = '$mpn' ORDER BY D.LZ_DEKIT_US_MT_ID DESC");

 
	  $getMasterBarcodeId = $getMasterBarcodeId->result_array();
	  $master_id = $getMasterBarcodeId[0]["LZ_DEKIT_US_MT_ID"];


	 $getBarcodePrv_no =  $this->db->query("SELECT DT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DT WHERE DT.LZ_DEKIT_US_MT_ID = $master_id AND DT.OBJECT_ID = '$OBJECT_ID' AND DT.PIC_DATE_TIME IS NOT NULL AND DT.PIC_STATUS = 1 AND DT.BARCODE_PRV_NO <> $barcode ORDER BY DT.LZ_DEKIT_US_DT_ID DESC");

	 $getBarcodePrv_no = $getBarcodePrv_no->result_array();
	 // var_dump($getBarcodePrv_no);exit;

	if(count($getBarcodePrv_no) > 0){



		 $getBarcodePrv_no = $getBarcodePrv_no[0]["BARCODE_PRV_NO"];

		 $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
		$path = $path->result_array();  	

		$master_path = $path[0]["MASTER_PATH"];
		// var_dump($master_path);exit;
		// $dir = $master_path.$barcode."/thumb/";//getBarcodePrv_no
		// $dir = $master_path.$getBarcodePrv_no."/thumb/";
		// var_dump($dir);exit;
		// $dir = preg_replace("/[\r\n]*/","",$dir);

		$mdir = $master_path.$getBarcodePrv_no.'/';
		// var_dump($dir);exit;
		$dekitted_pics = [];
		$parts = [];
		$uri = [];
		$cloudUrl = [];
		$image_url = [];

		if(is_dir($mdir)){
			// var_dump($dir);exit;
			$images = glob($mdir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
			$i=0 ;

			foreach($images as $image){
				$uri[$i] = $image;
				$parts = explode(".", $image);
				$img_name = explode("/",$image);
				$img_n = explode(".",$img_name[4]);
				$str = preg_replace('/[^A-Za-z0-9\. -]/', '', $img_name[4]);
				$new_string = substr($str,0,1) . "_" . substr($str,1,strlen($str)-1);
				$cloudUrl[$i] = "https://res.cloudinary.com/ecologix/image/upload/".$getBarcodePrv_no."/".$new_string;
	            // var_dump($cloudUrl);exit;
				// var_dump($new_string );exit;
	            if (is_array($parts) && count($parts) > 1){
	                $extension = end($parts);
	                if(!empty($extension)){
	                	
		                // $live_path = $data['path_query'][0]['LIVE_PATH'];
	                    $url = $parts['0'].'.'.$extension;
	                    $url = preg_replace("/[\r\n]*/","",$url);
	                    //var_dump($url);exit;
	                    $uri[$i] = $url;

						$img_url = explode("\\", $url);
						$img_url = end($img_url);
						//var_dump($img_url);
						$image_url[$i] = $img_url;	                    

	                    $img = file_get_contents($url);
	                    $img =base64_encode($img);
	                    $dekitted_pics[$i] = $img;



	                    $i++;
	                }
	            }

			}
		}	
		return array('dekitted_pics'=>$dekitted_pics,'parts'=>$parts,'uri'=>$uri,'cloudUrl'=>$cloudUrl, 'image_url'=>$image_url);
	}else{
		return 0;
	}

}
/*=====  End of YOUSAF METHODS  ======*/
	public function setBinIdtoSession(){
		$bin_id = trim(strtoupper($this->input->post("bin_id")));

		$bindId = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$bin_id' ")->result_array();
   
   
	    if(count($bindId) > 0) {
			$this->session->set_userdata('bin_id', $bin_id);
			$sess_val = $this->session->userdata("bin_id");
			return true;
		}else{
			return false;
		}
	}                        

	

	public function Save_deki_remarks(){

		$get_remarks = $this->input->post('get_remarks');
		$get_det_id = $this->input->post('get_det_id');

		$i=0;
		foreach ($get_det_id as $det_id) {

			$dek_remark = trim(str_replace("  ", ' ', $get_remarks[$i]));
      			
       	 		$dek =str_replace("'", "''", $dek_remark);

			$query = $this->db->query(" UPDATE LZ_DEKIT_US_DT D SET D.DEKIT_REMARKS ='$dek'  WHERE D.LZ_DEKIT_US_DT_ID = $det_id");
			$i++;
		}

		if($query){
			return true;
		}


	}
}