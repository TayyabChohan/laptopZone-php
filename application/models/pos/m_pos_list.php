<?php 

	class M_Pos_List extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

  Public function postedUnpostedData(){

      $listing_qry = "SELECT LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID , I.ITEM_CODE LAPTOP_ITEM_CODE, NVL(LS.ITEM_TITLE ,I.ITEM_DESC)  ITEM_MT_DESC ,I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";

    $listing_without_pic_qry = "SELECT LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID , I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";

    //$date_qry = "AND LM.LOADING_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
    $date_qry ="";
    $filter_qry = "";
    if($this->input->post('purchase_no')){
      $purchase_no = $this->input->post('purchase_no');
        if(is_numeric($purchase_no)){
          $filter_qry = "AND (LS.LZ_MANIFEST_ID = $purchase_no OR LM.PURCH_REF_NO = to_char('$purchase_no'))";
        }else{
          $filter_qry = "AND LM.PURCH_REF_NO = to_char('$purchase_no')";
        }
      }
      $listing_qry = $this->db->query( $listing_qry. " ".$date_qry ." ".$filter_qry);
      $listing_qry = $listing_qry->result_array();

      $listing_without_pic_qry = $this->db->query( $listing_without_pic_qry. " ".$date_qry ." ".$filter_qry);
      $listing_without_pic_qry = $listing_without_pic_qry->result_array();      

      // $listed_qry = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE  LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID  ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY   QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID "; 
      
      $listed_qry = "SELECT CP.LZ_CRAIG_POST_ID, CP.CRAIG_AD_ID, S.DEFAULT_COND,S.ITEM_TITLE,CP.POST_QTY,CP.OFFER_RATE, I.ITEM_MT_UPC UPC, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE MANUFACTURE, CP.LZ_SEED_ID, CP.POSTED_BY, S.ITEM_ID, S.LZ_MANIFEST_ID, TO_CHAR(CP.POST_DATE_TIME, 'DD/MM/YYYY HH24:MI:SS') as POST_DATE_TIME, TO_CHAR(CP.VALID_TILL, 'DD/MM/YYYY') as VALID_TILL FROM LZ_CRAIG_POST CP, LZ_ITEM_SEED S,  ITEMS_MT I WHERE S.SEED_ID = CP.LZ_SEED_ID AND I.ITEM_ID = S.ITEM_ID";

      $listed_qry = $this->db->query( $listed_qry);
      $listed_qry = $listed_qry->result_array();
      //var_dump($listing_qry);exit;
      $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL"); 
      $not_listed_barcode =  $not_listed_barcode->result_array();

      $listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0"); 
      $listed_barcode =  $listed_barcode->result_array();      

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $path_query =  $path_query->result_array();
      $barcode_arr = [];
      foreach($listed_qry as $cond){
        if(!empty($cond['DEFAULT_COND'])){
          $condition_id = @$cond['DEFAULT_COND'];

            //         if(!is_numeric(@$cond['ITEM_CONDITION'])){
            // $condition_id = @$cond['ITEM_CONDITION'];
            //             if(@$condition_id == 'USED'){
            //               @$condition_id = 3000;
            //             }elseif(@$condition_id == 'NEW'){
            //               @$condition_id = 1000; 
            //             }elseif(@$condition_id == 'NEW OTHER'){
            //               @$condition_id = 1500; 
            //             }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
            //                 @$condition_id = 2000;
            //             }elseif(@$condition_id == 'SELLER REFURBISHED'){
            //               @$condition_id = 2500; 
            //             }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING'){
            //               @$condition_id = 7000; 
            //             }
            //         }else{
            //           $condition_id = @$cond['ITEM_CONDITION'];
            //         }
                        

        $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
        //var_dump($barcode_qry);exit;
        
        if($barcode_qry->num_rows() > 0){
          $barcode_qry = $barcode_qry->result_array();

        array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
      }
        
      }else{
        //$barcode_qry = null;
        array_push($barcode_arr, null);
        //return array('query'=>$query, 'barcode_qry'=>$barcode_arr);
      }       

    } //END FOREACH
    return array('listing_qry'=>$listing_qry,'listed_qry'=>$listed_qry, 'path_query'=>$path_query, 'barcode_qry'=>$barcode_arr, 'listing_without_pic_qry'=>$listing_without_pic_qry, 'not_listed_barcode'=>$not_listed_barcode, 'listed_barcode'=>$listed_barcode);
  }

  public function posPostDetail(){
    $seed_id = $this->uri->segment(4);

    $query = $this->db->query("SELECT S.SEED_ID,S.ITEM_TITLE, I.ITEM_MT_UPC, I.ITEM_MT_MANUFACTURE, I.ITEM_MT_MFG_PART_NO, BCD.CONDITION_ID, BCD.QTY FROM ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE I.ITEM_ID = S.ITEM_ID AND BCD.ITEM_ID = S.ITEM_ID AND BCD.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND BCD.CONDITION_ID = S.DEFAULT_COND AND S.SEED_ID = $seed_id");

    $item_detail = $query->result_array();

    $craig_id = $this->db->query("SELECT get_single_primary_key('LZ_CRAIG_POST','CRAIG_AD_ID') CRAIG_AD_ID FROM DUAL");

      $craig_id = $craig_id->result_array();   

      return array('item_detail'=>$item_detail, 'craig_id'=>$craig_id);        



  }
  public function posReceiptView(){

    // $receipt_view = $this->db->query("SELECT M.LZ_POS_MT_ID,M.DOC_NO, TO_CHAR(M.DOC_DATE, 'DD/MM/YYYY HH24:MI:SS') as DOC_DATE, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.ENTERED_BY, G.PRICE ,G.SALES_TAX_PERC, G.DISC_PERC, G.DISC_AMT FROM LZ_POS_MT M, (SELECT LZ_POS_MT_ID,SUM(PRICE) PRICE, SUM(DISC_PERC) DISC_PERC, SUM(DISC_AMT) DISC_AMT, SUM(SALES_TAX_PERC) SALES_TAX_PERC FROM LZ_POS_DET GROUP BY LZ_POS_MT_ID)G WHERE M.LZ_POS_MT_ID = G.LZ_POS_MT_ID(+) ORDER BY M.DOC_NO DESC"); 
    $receipt_view = $this->db->query("SELECT M.LZ_POS_MT_ID, M.DOC_NO, TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY HH24:MI:SS') as DOC_DATE, M.BUYER_NAME, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.ENTERED_BY, M.STAX_PERC SALES_TAX_PERC, G.PRICE, G.DISC_PERC, G.DISC_AMT FROM LZ_POS_MT M, (SELECT LZ_POS_MT_ID, SUM(PRICE) PRICE, SUM(DISC_PERC) DISC_PERC, SUM(DISC_AMT) DISC_AMT FROM LZ_POS_DET GROUP BY LZ_POS_MT_ID) G WHERE M.LZ_POS_MT_ID = G.LZ_POS_MT_ID(+) ORDER BY M.DOC_NO DESC");
    return $receipt_view->result_array();

  }
  public function UsersList(){
    $query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID in(4,5,13,14,16,2,18,21,22,23,24,25,26)");
    return $query->result_array();
  }
	 

	public function posAddPost(){
    $seed_id = $this->input->post('seed_id');
    // var_dump($seed_id);exit;
    $craig_ad_id = $this->input->post('craig_ad_id');
    $post_qty = $this->input->post('ad_qty');
    $offer_rate = $this->input->post('ad_rate');
    $valid_till = $this->input->post('valid_till');
    $valid_till = "TO_DATE('".$valid_till."', 'MM/DD/YYYY ')";
    $login_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $post_date=date("Y-m-d H:i:s");
    $post_date= "TO_DATE('".$post_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $coma = ',';

    $qry_data = $this->db->query("SELECT get_single_primary_key('LZ_CRAIG_POST','LZ_CRAIG_POST_ID') LZ_CRAIG_POST_ID FROM DUAL");

      $rs = $qry_data->result_array();           
      $lz_craig_post_id= $rs[0]['LZ_CRAIG_POST_ID'];


    $qryData = $this->db->query("INSERT INTO LZ_CRAIG_POST (LZ_CRAIG_POST_ID, CRAIG_AD_ID, LZ_SEED_ID, POST_QTY, OFFER_RATE, VALID_TILL, POST_DATE_TIME, POSTED_BY) VALUES($lz_craig_post_id $coma '$craig_ad_id' $coma $seed_id  $coma '$post_qty' $coma $offer_rate $coma $valid_till $coma $post_date $coma $login_id)");

      if($qryData){
        $this->session->set_flashdata('success', 'Record Inserted Successfully.');
      }else{
        $this->session->set_flashdata('error', 'Record Not Inserted.');
      }
    
    
  }
  public function receiptSearch(){

    $perameter = $this->input->post('receipt_search');

      $qry_data = $this->db->query("SELECT M.LZ_POS_MT_ID,M.DOC_NO, TO_CHAR(M.DOC_DATE, 'DD/MM/YYYY HH24:MI:SS') as DOC_DATE, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.ENTERED_BY, G.DET_PRICE ,G.DET_SALES_TAX, G.DISC_PERC, G.DISC_AMT FROM LZ_POS_MT M, (SELECT LZ_POS_MT_ID,SUM(PRICE) DET_PRICE,SUM(DISC_PERC) DISC_PERC, SUM(DISC_AMT) DISC_AMT, SUM(SALES_TAX_PERC) DET_SALES_TAX FROM LZ_POS_DET GROUP BY LZ_POS_MT_ID)G WHERE M.LZ_POS_MT_ID=G.LZ_POS_MT_ID(+) AND ( M.DOC_NO LIKE '%$perameter%' OR M.BUYER_PHONE_ID LIKE '%$perameter%' OR M.BUYER_EMAIL LIKE '%$perameter%' OR M.BUYER_ADDRESS LIKE '%$perameter%') ORDER BY M.DOC_NO DESC");
      return $qry_data->result_array();
  }

  public function printInvoice($lz_pos_mt_id){


   // $print_qry = $this->db->query("SELECT DT.LZ_POS_MT_ID, DT.ITEM_DESC, MT.DOC_NO, MT.PAY_MODE, NVL(SUM(DT.QTY), 0) QTY, NVL(SUM(DT.PRICE), 0) DET_PRICE, NVL(SUM(DT.SALES_TAX_PERC), 0) DET_SALES_TAX, NVL(SUM(DT.DISC_AMT), 0) DISC_AMT FROM LZ_POS_DET DT, LZ_POS_MT MT WHERE DT.LZ_POS_MT_ID = $lz_pos_mt_id AND DT.LZ_POS_MT_ID = MT.LZ_POS_MT_ID GROUP BY DT.ITEM_DESC, DT.LZ_POS_MT_ID, MT.DOC_NO, MT.PAY_MODE"); 
   $print_qry = $this->db->query("SELECT DT.LZ_POS_MT_ID, DT.ITEM_DESC, MT.DOC_NO, MT.PAY_MODE, MT.STAX_PERC DET_SALES_TAX, NVL(SUM(DT.QTY), 0) QTY, NVL(SUM(DT.PRICE), 0) DET_PRICE, NVL(SUM(DT.DISC_AMT), 0) DISC_AMT FROM LZ_POS_DET DT, LZ_POS_MT MT WHERE DT.LZ_POS_MT_ID = $lz_pos_mt_id AND DT.LZ_POS_MT_ID = MT.LZ_POS_MT_ID GROUP BY DT.ITEM_DESC, DT.LZ_POS_MT_ID, MT.DOC_NO, MT.PAY_MODE, MT.STAX_PERC");
   
   return $print_qry->result_array();
  }
  public function deleteRecord($lz_craig_post_id){

    $del_qry = $this->db->query("DELETE FROM LZ_CRAIG_POST C WHERE C.LZ_CRAIG_POST_ID = $lz_craig_post_id");

      if($del_qry){

        $this->session->set_flashdata('deleted', 'Record Deleted Successfully.');

      }else{
        $this->session->set_flashdata('del_error', 'Record Not Deleted.');
      }    

  }  

}




 ?>