<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_create_lot extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function Condiotion(){
    
    $cond_id = $this->db->query(" SELECT C.ID,C.COND_NAME FROM LZ_ITEM_COND_MT C " )->result_array();

    return array('cond_id'=>$cond_id );

  } 

  
  public function my_lot_items(){
    
    // $lot_items = $this->db->query(" SELECT B.BARCODE_NO , DE.ITEM_MT_DESC ITEM_DESC,DE.PO_DETAIL_RETIAL_PRICE COST_PRICE,DE.CONDITIONS_SEG5 FROM LZ_MANIFEST_MT M, LZ_MANIFEST_DET DE, ITEMS_MT I, LZ_BARCODE_MT B WHERE M.MANIFEST_TYPE = 5  and b.barcode_no is not null AND DE.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = B.ITEM_ID(+) AND M.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID order by BARCODE_NO desc " )->result_array();

    $lot_items = $this->db->query(" SELECT B.BARCODE_NO , DE.ITEM_MT_DESC ITEM_DESC,DE.PO_DETAIL_RETIAL_PRICE COST_PRICE,DE.CONDITIONS_SEG5 FROM LZ_MANIFEST_MT M, LZ_MANIFEST_DET DE, ITEMS_MT I, LZ_BARCODE_MT B WHERE M.MANIFEST_TYPE = 5  AND B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.LZ_MANIFEST_ID = DE.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO IS NOT NULL order by BARCODE_NO desc " )->result_array();

    return array('lot_items'=>$lot_items );

  } 

  public function my_lot_items_dettail(){
    $barcode_no = $this->uri->segment(4);

    $lot_items_detail = $this->db->query(" SELECT B.BARCODE_NO, B.ITEM_ADJ_DET_ID_FOR_IN  IN_ID, D.ITEM_ADJUSTMENT_ID FROM LZ_BARCODE_MT B, ITEM_ADJUSTMENT_DET D WHERE B.BARCODE_NO = $barcode_no AND B.ITEM_ADJ_DET_ID_FOR_IN = D.ITEM_ADJUSTMENT_DET_ID  " );

    if($lot_items_detail->num_rows() > 0){
      $lot_items_detail = $lot_items_detail->result_array();
      $in_id = $lot_items_detail[0]['IN_ID'];
      $item_adjustment_id = $lot_items_detail[0]['ITEM_ADJUSTMENT_ID'];


      $get_detail = $this->db->query( " SELECT DISTINCT B.BARCODE_NO, I.ITEM_ID, I.ITEM_DESC TITLE, D.ITEM_MT_MANUFACTURE BRAND, D.ITEM_MT_MFG_PART_NO    MPN, D.ITEM_MT_UPC UPC, CON.COND_NAME CONDIOTION, D.PO_DETAIL_RETIAL_PRICE COST_PRICE, D.E_BAY_CATA_ID_SEG6     CATEGORY FROM LZ_BARCODE_MT B, ITEMS_MT I, LZ_MANIFEST_DET D, LZ_ITEM_COND_MT CON,ITEM_ADJUSTMENT_DET K WHERE B.ITEM_ID = I.ITEM_ID AND B.CONDITION_ID = CON.ID(+) AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND K.ITEM_ADJUSTMENT_ID = $item_adjustment_id AND K.ITEM_ADJUSTMENT_DET_ID = B.ITEM_ADJ_DET_ID_FOR_OUT AND K.ITEM_ADJUSTMENT_DET_ID  <>  $in_id ")->result_array();

      return array('get_detail' => $get_detail);



    } 
    



   

  } 
  public function get_barcode(){
    
    $ser_barcode = $this->input->post('ser_barcode');

    $bar_check = $this->db->query(" SELECT * FROM LZ_BARCODE_MT b WHERE b.BARCODE_NO = $ser_barcode AND B.EBAY_ITEM_ID IS NULL AND B.PULLING_ID IS NULL AND B.SALE_RECORD_NO IS NULL   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL");

    if($bar_check->num_rows() > 0){ 

      $bar_query  = $this->db->query(" SELECT DISTINCT B.BARCODE_NO,I.ITEM_ID, I.ITEM_DESC TITLE, D.ITEM_MT_MANUFACTURE BRAND, D.ITEM_MT_MFG_PART_NO MPN, D.ITEM_MT_UPC UPC, CON.COND_NAME CONDIOTION,D.PO_DETAIL_RETIAL_PRICE COST_PRICE,  D.E_BAY_CATA_ID_SEG6 CATEGORY FROM LZ_BARCODE_MT B, ITEMS_MT I, LZ_MANIFEST_DET D,LZ_ITEM_COND_MT CON WHERE B.BARCODE_NO = $ser_barcode AND B.ITEM_ID = I.ITEM_ID AND B.CONDITION_ID = CON.ID(+) AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE  AND B.EBAY_ITEM_ID IS NULL AND B.PULLING_ID IS NULL AND B.SALE_RECORD_NO IS NULL AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID ")->result_array();
      return array('bar_query' =>$bar_query,'getbar_query'=>true);

    }else{

      return 1;
    }

  } 

  public function get_bar_item_id(){
  	
  	$get_item_id = $this->input->post('get_item_id');
    // var_dump($get_item_id);
    // exit;

  	// $bar_check = $this->db->query(" SELECT * FROM LZ_BARCODE_MT b WHERE b.BARCODE_NO = $ser_barcode AND B.EBAY_ITEM_ID IS NULL AND B.PULLING_ID IS NULL AND B.SALE_RECORD_NO IS NULL");

  	// if($bar_check->num_rows() > 0){ 

  		$bar_query  = $this->db->query(" SELECT DISTINCT B.BARCODE_NO,I.ITEM_ID, I.ITEM_DESC TITLE, D.ITEM_MT_MANUFACTURE BRAND, D.ITEM_MT_MFG_PART_NO MPN, D.ITEM_MT_UPC UPC, CON.COND_NAME CONDIOTION,D.PO_DETAIL_RETIAL_PRICE COST_PRICE,  D.E_BAY_CATA_ID_SEG6 CATEGORY FROM LZ_BARCODE_MT B, ITEMS_MT I, LZ_MANIFEST_DET D,LZ_ITEM_COND_MT CON WHERE B.ITEM_ID = $get_item_id AND B.ITEM_ID = I.ITEM_ID AND B.CONDITION_ID = CON.ID(+) AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE  AND B.EBAY_ITEM_ID IS NULL AND B.PULLING_ID IS NULL AND B.SALE_RECORD_NO IS NULL AND B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID ")->result_array();

  		return array('bar_query' =>$bar_query,'getbar_query'=>true);

  	// }else{

  	// 	return 1;
  	// }

  }

  public function save_lot(){
  $bar_no = $this->input->post('bar_no');
  $item_id = $this->input->post('item_id');
  $cost_pric = $this->input->post('cost_pric');
  $enter_manu = $this->input->post('enter_manu');
  //$ent_brnd = $this->input->post('ent_brnd');
  //$ent_mpn = $this->input->post('ent_mpn');
  //$ent_upc = $this->input->post('ent_upc');
  $ent_title = $this->input->post('ent_title');
  
  $ent_title =str_replace("'", "''", $ent_title);
  $condi_id = $this->input->post('condi_id');
  $ent_cat_id = $this->input->post('ent_cat_id');

  $enter_mp = $this->input->post('enter_mp');
  $title = trim(str_replace("  ", ' ', $enter_mp));
  $title = str_replace(array("`,′"), "", $title);
  $title = str_replace(array("'"), "''", $title);

  

  if(empty($enter_mp)){
     $enter_mp_cust = 'LOTMPN';
  }else{
    $enter_mp_cust = $title;
  }

  // var_dump($bar_no);
  // exit;

  // **** variable declaration for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_det start*
  //******************************************************************************************
  $get_user = $this->session->userdata('user_id');

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

  $insert_adjus_mt = "INSERT INTO ITEM_ADJUSTMENT_MT(ITEM_ADJUSTMENT_ID, INV_BOOK_ID, ADJUSTMENT_NO, ADJUSTMENT_DATE, STOCK_TRANS_YN, REMARKS,          INV_TRANSACTION_NO, JOURNAL_ID, POST_TO_GL, ENTERED_BY, AUTH_ID, AUTHORIZED_YN, SEND_FOR_AUTH, AUTH_STATUS_ID,                ADJUSTMENT_REF_NO) 
            VALUES($adjs_mt_pk, 8, $last_no, to_date(sysdate), 0, NULL, NULL, NULL, 0, $get_user, null, 0, 0, 0, '$adjus')";
  $this->db->query($insert_adjus_mt);

  if($insert_adjus_mt) {
    $i=0;
    foreach ($bar_no as $comp) {

      $adjs_det = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL")->result_array();
      $adjs_det_pk = $adjs_det[0]['ID'];

      // var_dump($bar_no,$item_id,$cost_pric);
      // exit;
      $insert_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY, SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS ) 
            VALUES($adjs_det_pk, $adjs_mt_pk, $item_id[$i], 1, $def_loc_id, -1, NULL, $cost_pric[$i], NULL, NULL )"; /// $cost variable query        
      $this->db->query($insert_adjus_det);

      $this->db->query("UPDATE DOC_SEQUENCE_DETAIL  SET LAST_NO =$last_no where DOC_DET_SEQ_ID =$doc_det_seq_id");
      $this->db->query ("UPDATE LZ_BARCODE_MT SET ITEM_ADJ_DET_ID_FOR_OUT = $adjs_det_pk WHERE BARCODE_NO = $bar_no[$i]");
        
        $i++;
      } /// end foreach
  } 

  // **** code for insertion into ITEM_ADJUSTMENT_MT,ITEM_ADJUSTMENT_DET end
  //***********************************************************************

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
    
  $purch_ref_no = 'lot_'.$loading_no;
      /*--- Get Single Primary Key for LZ_MANIFEST_MT start---*/
  $get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LZ_MANIFEST_ID') LZ_MANIFEST_ID FROM DUAL");
  $get_mt_pk = $get_mt_pk->result_array();
  $lz_manifest_id = $get_mt_pk[0]['LZ_MANIFEST_ID'];
  /*--- Get Single Primary Key for LZ_MANIFEST_MT end---*/

  /*--- Insertion Query for LZ_MANIFEST_MT start---*/
  $mt_qry = "INSERT INTO LZ_MANIFEST_MT (LZ_MANIFEST_ID, LOADING_NO, LOADING_DATE, PURCH_REF_NO, SUPPLIER_ID, REMARKS, DOC_SEQ_ID, PURCHASE_DATE, POSTED, EXCEL_FILE_NAME, GRN_ID, PURCHASE_INVOICE_ID, SINGLE_ENTRY_ID, TOTAL_EXCEL_ROWS, MANIFEST_NAME, MANIFEST_STATUS, SOLD_PRICE, END_DATE, LZ_OFFER, MANIFEST_TYPE, EST_MT_ID) VALUES($lz_manifest_id , $loading_no , $load_date , '$purch_ref_no' , 7, NULL ,30 , null , 'POSTED' , null , null , null, null, null , null  , null, null ,null , null, 5, null)";
    $mt_qry = $this->db->query($mt_qry);
  if($mt_qry){

    $cat_name = $this->db->query(" SELECT C.CATEGORY_NAME, C.PARENT_CAT_ID FROM LZ_BD_CATEGORY_TREE C WHERE C.CATEGORY_ID = $ent_cat_id ");
    if(count($cat_name) >0) {
    $cat_name = $cat_name->result_array();
    $get_cat_name = @$cat_name[0]['CATEGORY_NAME'];

    $cost_p = $this->db->query(" SELECT SUM(DE.LINE_AMOUNT) COST_P FROM ITEM_ADJUSTMENT_DET DE WHERE DE.ITEM_ADJUSTMENT_ID = $adjs_mt_pk ");
    $cost_p = $cost_p->result_array();
    $get_cost_price = @$cost_p[0]['COST_P'];

    $get_det_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_DET','LAPTOP_ZONE_ID') LZ_ID FROM DUAL");
          $get_det_pk = $get_det_pk->result_array();
          $laptop_zone_id = $get_det_pk[0]['LZ_ID'];

    $det_qry = "  INSERT INTO LZ_MANIFEST_DET
    (PO_MT_AUCTION_NO,
     PO_DETAIL_LOT_REF,
     PO_MT_REF_NO,
     ITEM_MT_MANUFACTURE,
     ITEM_MT_MFG_PART_NO,
     ITEM_MT_DESC,
     ITEM_MT_BBY_SKU,
     ITEM_MT_UPC,
     PO_DETAIL_RETIAL_PRICE,
     MAIN_CATAGORY_SEG1,
     SUB_CATAGORY_SEG2,
     BRAND_SEG3,
     ORIGIN_SEG4,
     CONDITIONS_SEG5,
     E_BAY_CATA_ID_SEG6,
     LAPTOP_ZONE_ID,
     LAPTOP_ITEM_CODE,
     AVAILABLE_QTY,
     PRICE,
     LZ_MANIFEST_ID,
     CATEGORY_NAME_SEG7,
     S_PRICE,
     V_PRICE,
     SHIP_FEE,
     STICKER_PRINT,
     MANUAL_UPDATE,
     EST_DET_ID,
     WEIGHT)

   values
    (null,
     null,
     null,
     '$enter_manu',    
     '$enter_mp_cust',
     '$ent_title', 
     null, 
     null, 
     $get_cost_price, 
     '$get_cat_name', 
     '$get_cat_name', 
     '$get_cat_name', 
     'US', 
     '$condi_id',
     $ent_cat_id, 
     $laptop_zone_id, 
     null, 
     1, 
     null, 
     $lz_manifest_id, 
     null, 
     null, 
     null, 
     null, 
     null, 
     null, 
     null,
     null) " ;
     $det_qry = $this->db->query($det_qry);
     if($det_qry){
      $call_proc = $this->db->query("call Pro_Laptop_Zone($lz_manifest_id)");
      if( $call_proc){

      $bar_quer = $this->db->query( " SELECT BARCODE_NO ,ITEM_ID FROM LZ_BARCODE_MT WHERE LZ_MANIFEST_ID = $lz_manifest_id" );
      if(count($bar_quer)>0){
      $bar_quer = $bar_quer->result_array();
      $get_barcode_no = $bar_quer[0]['BARCODE_NO'];
      $get_barcode_item = $bar_quer[0]['ITEM_ID'];

      $get_adjs_det = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL")->result_array();
      $get_adjs_det_pk = $get_adjs_det[0]['ID'];

      $ins_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY, SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS ) 
            VALUES($get_adjs_det_pk, $adjs_mt_pk, $get_barcode_item, 1, $def_loc_id, 1, NULL, $get_cost_price, NULL, NULL )"; /// $cost variable query        
      $this->db->query($ins_adjus_det); 

        $this->db->query( " UPDATE LZ_BARCODE_MT BB  SET BB.ITEM_ADJ_DET_ID_FOR_IN = $get_adjs_det_pk WHERE bb.BARCODE_NO = $get_barcode_no" );

        return true;

      }
     }
   }
  }
  } /*--- Insertion Query for LZ_MANIFEST_MT end---*/ 

    // **** code for insertion into lz_manifest_mt end
    //************************************************************************


  

  }
}