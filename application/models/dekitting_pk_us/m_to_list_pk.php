<?php  

	class M_to_list_pk extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	 	
	public function default_view(){
		$from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
		$to = date('m/d/Y');
		$rslt =$from." - ".$to;
		$this->session->set_userdata('date_range', $rslt);
		$fromdate = date_create($from);
		$todate = date_create($to);
		$from = date_format($fromdate,'d-m-y');
		$to = date_format($todate, 'd-m-y');

		$detail_qry = $this->db->query("select * from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY) AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')");
		$search_record = "Manifest";
		$this->session->set_userdata('search_record', $search_record);
	  	$detail_qry = $detail_qry->result_array();

	  	//======================== Manifest Auction fields Start =============================//
			$summary_qry = "select sum(t.Not_List_Qty) sum_qty, sum(t.COST_US*t.Not_List_Qty) total_cost from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY) AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')"; 
			 		
	 		$summary_qry = $this->db->query( $summary_qry);
	 		//$total_query = $this->db->query( $main_total_query." ".$qry_condition);
	 		$summary_qry = $summary_qry->result_array();

        //======================== Manifest Auction fields End =============================//
        return array('detail_qry'=>$detail_qry,'summary_qry'=>$summary_qry);
	}
	public function search_filter_view($search_record,$from,$to,$purchase_no){

			$main_query = "select * from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY)";
			$date_qry = "AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			$sub_qry="";
	 		if($search_record == "Manifest"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == "Single_Entry"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is not null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == 'All'){
	 			$qry_condition = "";
	 			$this->session->set_userdata('search_record', $search_record);
	 		}
	 		if(!empty($purchase_no)){
	 			$sub_qry = "and purch_ref_no = '$purchase_no'";
	 			$this->session->set_userdata('purchase_no', $purchase_no);
	 		}
	 		$detail_qry = $this->db->query( $main_query. " ".$date_qry." ".$qry_condition." ".$sub_qry);
	 		//$total_query = $this->db->query( $main_total_query." ".$qry_condition);
	 		$detail_qry = $detail_qry->result_array();

	 		//======================== Manifest Auction fields Start =============================//


			$main_sum_qry = "select sum(t.Not_List_Qty) sum_qty, sum(t.COST_US*t.Not_List_Qty) total_cost from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY)"; 
			$date_sum_qry = "AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			$sub_qry="";
	 		if($search_record == "Manifest"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == "Single_Entry"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is not null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == 'All'){
	 			$qry_condition = "";
	 			$this->session->set_userdata('search_record', $search_record);
	 		}
	 		if(!empty($purchase_no)){
	 			$sub_qry = "and purch_ref_no = '$purchase_no'";
	 			$this->session->set_userdata('purchase_no', $purchase_no);
	 		}
	 		$summary_qry = $this->db->query( $main_sum_qry. " ".$date_sum_qry ." ".$qry_condition." ".$sub_qry);
	 		//$total_query = $this->db->query( $main_total_query." ".$qry_condition);
	 		$summary_qry = $summary_qry->result_array();


        //======================== Manifest Auction fields End =============================//
        return array('detail_qry'=>$detail_qry,'summary_qry'=>$summary_qry);
	}
	public function item_listing(){

		// $from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
		// $to = date('m/d/Y');
		// $fromdate = date_create($from);
		// $todate = date_create($to);
		// $from = date_format($fromdate,'d-m-y');
		// $to = date_format($todate, 'd-m-y');	
    $lister_id = $this->session->userdata('user_id');
    $users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
    /*echo "<pre>";
    print_r($users->result_array());
    exit;*/

    $employees = array(2,4,5,7,13,19,27,28,29,30,31,32);

    if(in_array($lister_id, $employees)){
      $listing_qry = "SELECT LS.SEED_ID, LS.ENTERED_BY, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE ,I.ITEM_DESC)  ITEM_MT_DESC ,I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL";
    }else{
      	$listing_qry = "SELECT LS.SEED_ID, LS.ENTERED_BY, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC A, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID";
    }
     
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
     
if($this->input->post('search_lister') && $this->input->post('location') != 'ALL'){
  $location = $this->input->post('location');

  $listed_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES,LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND E.LISTER_ID IN(SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = '$location')";
}else{
      $listed_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID"; 
  	}
      $listed_qry = $this->db->query( $listed_qry. " ".$date_qry ." ".$filter_qry." ORDER BY list_date DESC");
      $listed_qry = $listed_qry->result_array();
      //var_dump($listing_qry);exit;
      $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL"); 
      $not_listed_barcode =  $not_listed_barcode->result_array();

      $listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL"); 
      $listed_barcode =  $listed_barcode->result_array();

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $path_query =  $path_query->result_array();
		  return array('users'=>$users, 'listing_qry'=>$listing_qry,'listed_qry'=>$listed_qry, 'path_query'=>$path_query,'not_listed_barcode'=>$not_listed_barcode,'listed_barcode'=>$listed_barcode);
	}
	public function pic_view(){

		// $from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
		// $to = date('m/d/Y');
		// $fromdate = date_create($from);
		// $todate = date_create($to);
		// $from = date_format($fromdate,'d-m-y');
		// $to = date_format($todate, 'd-m-y');	
    $lister_id = $this->session->userdata('user_id');

    $listing_without_pic_qry = "SELECT LS.APPROVED_BY,LS.APPROVED_DATE,LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";

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

      $listing_without_pic_qry = $this->db->query( $listing_without_pic_qry. " ".$date_qry ." ".$filter_qry);
      $listing_without_pic_qry = $listing_without_pic_qry->result_array();      

      $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL"); 
      $not_listed_barcode =  $not_listed_barcode->result_array();

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $path_query =  $path_query->result_array();

		  return array('path_query'=>$path_query, 'listing_without_pic_qry'=>$listing_without_pic_qry, 'not_listed_barcode'=>$not_listed_barcode);

	}
  public function listedItemsAudit(){


    if($this->input->post('search_lister')){
     $location = $this->input->post('location');

     $listed_qry = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE  LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID  ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY   QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_STICKER = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND E.LISTER_ID IN(SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = '$location')";
      }else{
        
       $listed_qry = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.BARCODE_NO, BCD.CONDITION_ID  ITEM_CONDITION, BCD.EBAY_ITEM_ID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.BARCODE_NO,BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_STICKER = 0 AND BC.EBAY_ITEM_ID IS NOT NULL) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND E.LISTER_ID IN(SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK')"; 
   }
   if($this->input->post('search_lister')){
	  	$rslt = $this->input->post('date_range');
	    $this->session->set_userdata('date_range', $rslt);

	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];

	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);

	    $from = date_format($fromdate,'d-m-y');
	    $to = date_format($todate, 'd-m-y');
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
	    $listed_qry = $this->db->query( $listed_qry." ".$date_qry." ORDER BY LIST_DATE DESC");
        $listed_qry = $listed_qry->result_array();
	}else{

	    $from = date('d-m-y');
	    $to = date('d-m-y');
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
		$listed_qry = $this->db->query( $listed_qry." ".$date_qry." ORDER BY LIST_DATE DESC");
        $listed_qry = $listed_qry->result_array();
	}
        
        //var_dump($listing_qry);exit;


        $listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO, BC.EBAY_ITEM_ID FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL"); 
        $listed_barcode =  $listed_barcode->result_array();      

        $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
        $path_query =  $path_query->result_array();

        $path_2 = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
        $path_2 =  $path_2->result_array(); 
    return array('listed_qry'=>$listed_qry,  'listed_barcode'=>$listed_barcode, 'path_query'=>$path_query,'path_2'=>$path_2);    
  }
	/*================================================
	=            copy from m_seed_process            =
	================================================*/
	
	function add($item_id,$manifest_id) {

  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  //$title = trim(str_replace(array("'"), "''", $title));
  $item_desc = $this->input->post('item_desc');
  $item_desc = trim(str_replace("  ", ' ', $item_desc));
  //$item_desc = trim(str_replace(array("'"), "''", $item_desc));
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $template_name = trim(str_replace("  ", ' ', $template_name));
  //$template_name = trim(str_replace(array("'"), "''", $template_name));
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category_id = $this->input->post('category_id');
  $category_name = $this->input->post('category_name');
  $category_name = trim(str_replace("  ", ' ', $category_name));
  //$category_name = trim(str_replace(array("'"), "''", $category_name));
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $ship_from = trim(str_replace("  ", ' ', $ship_from));
  //$ship_from = trim(str_replace(array("'"), "''", $ship_from));
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $default_description = trim(str_replace("  ", ' ', $default_description));
  //$default_description = trim(str_replace(array("'"), "''", $default_description));
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  $return_accepted = $this->input->post('return_accepted');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $entered_by = $this->session->userdata('user_id');
  date_default_timezone_set("America/Chicago");
  $created_date = date("Y-m-d H:i:s");
  $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";
  
  $data = array(
   'ITEM_ID' => $item_id,
   'ITEM_TITLE' => $title,
   'ITEM_DESC' => $item_desc,
   'EBAY_PRICE' => $price,
   'TEMPLATE_ID' => $template_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $category_id,
   'CATEGORY_NAME' => $category_name,
   'SHIP_FROM_ZIP_CODE' => $zip_code,
   'SHIP_FROM_LOC' => $ship_from,
   'BID_LENGTH' => $bid_length,
   'DEFAULT_COND' => $default_condition,
   'DETAIL_COND' => $default_description,
   'PAYMENT_METHOD' => $payment_method,
   'PAYPAL_EMAIL' => $paypal,
   'DISPATCH_TIME_MAX' => $dispatch_time,
   'SHIPPING_COST' => $shipping_cost,
   'ADDITIONAL_COST' => $additional_cost,
   'RETURN_OPTION' => $return_accepted,
   'RETURN_DAYS' => $return_within,
   'SHIPPING_PAID_BY' => $cost_paidby,
   'SHIPPING_SERVICE' => $shipping_service,
   'LZ_MANIFEST_ID' => $manifest_id,
   'ENTERED_BY' => $entered_by,
   'DATE_TIME' => $created_date
   
  );
   $this->db->insert('LZ_ITEM_SEED', $data);
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);

  
 }
 function update() {
  $ship_change =$this->input->post('ship_change');
  $ship_fee =$this->input->post('ship_fee');
  $seed_id = $this->input->post('seed_id');
  $item_id = $this->input->post('pic_item_id');
  $manifest_id = $this->input->post('pic_manifest_id');
  $item_code = $this->input->post('erp_code');
  $object_id = $this->input->post('object_id');
  $weight = $this->input->post('weight');
  $barcode=  $this->input->post('list_barcode');
  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  $title = trim(str_replace(array("'"), "''", $title));
  //var_dump($title);exit
  $item_desc = $this->input->post('item_desc');
  $item_desc = trim(str_replace("  ", ' ', $item_desc));
  $item_desc = trim(str_replace(array("'"), "''", $item_desc));
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $template_name = trim(str_replace("  ", ' ', $template_name));
  $template_name = trim(str_replace(array("'"), "''", $template_name));  
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category_id = $this->input->post('category_id');
  $category_name = $this->input->post('category_name');
  $category_name = trim(str_replace("  ", ' ', $category_name));
  $category_name = trim(str_replace(array("'"), "''", $category_name));  
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $ship_from = trim(str_replace("  ", ' ', $ship_from));
  $ship_from = trim(str_replace(array("'"), "''", $ship_from));  
  $bid_length = $this->input->post('bid_length');
  $barcode_condition = $this->input->post('pic_condition_id');
  $default_condition = $this->input->post('it_condition');
  //var_dump($default_condition);exit;
  $other_notes =$this->input->post('other_notes');
  $other_notes = trim(str_replace("  ", ' ', $other_notes));
  $other_notes = trim(str_replace(array("'"), "''", $other_notes));
  $bin_name =$this->input->post('bin_name');
  $bin_name = trim(str_replace("  ", ' ', $bin_name));
  $bin_name = strtoupper(trim(str_replace(array("'"), "''", $bin_name)));
  	// if(@$default_condition == 'Used'){
   //      @$default_condition = 3000;
   //    }elseif(@$default_condition == 'New'){
   //      @$default_condition = 1000; 
   //    }elseif(@$default_condition =='New other' ){
   //      @$default_condition = 1500; 
   //    }elseif(@$default_condition == 'Manufacturer refurbished'){
   //        @$default_condition = 2000;
   //    }elseif(@$default_condition == 'Seller refurbished'){
   //      @$default_condition = 2500; 
   //    }elseif(@$default_condition == 'For parts or not working'){
   //      @$default_condition = 7000; 
   //    }
  $default_description = $this->input->post('default_description');
  $default_description = trim(str_replace("  ", ' ', $default_description));
  $default_description = trim(str_replace(array("'"), "''", $default_description));  
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  //$return_accepted = $this->input->post('return_accepted');
  $return_accepted = $this->input->post('return_option');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $epid = $this->input->post('item_epid');
  $entered_by = $this->session->userdata('user_id');
  date_default_timezone_set("America/Chicago");
  $created_date = date("Y-m-d H:i:s");
  $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";

   $this->db->query(" UPDATE LZ_ITEM_SEED SET SEED_ID = $seed_id, ITEM_ID = $item_id, ITEM_TITLE = '$title', ITEM_DESC = '$item_desc', EBAY_PRICE = $price, TEMPLATE_ID = $template_name, EBAY_LOCAL = $site_id, CURRENCY = '$currency', LIST_TYPE = '$listing_type', CATEGORY_ID = $category_id, CATEGORY_NAME = '$category_name', SHIP_FROM_ZIP_CODE = $zip_code, SHIP_FROM_LOC = '$ship_from', BID_LENGTH = NULL, DEFAULT_COND = $default_condition, DETAIL_COND = '$default_description', PAYMENT_METHOD = '$payment_method', PAYPAL_EMAIL = '$paypal', DISPATCH_TIME_MAX = $dispatch_time, SHIPPING_COST = $shipping_cost, ADDITIONAL_COST = $additional_cost, RETURN_OPTION = '$return_accepted', RETURN_DAYS = $return_within, SHIPPING_PAID_BY = '$cost_paidby', SHIPPING_SERVICE = '$shipping_service', LZ_MANIFEST_ID = $manifest_id, ENTERED_BY = $entered_by, DATE_TIME = $created_date, OTHER_NOTES='$other_notes',EPID = '$epid'  WHERE SEED_ID  = $seed_id ");

if(!empty($barcode_condition) AND $barcode_condition !== $default_condition){
	$this->db->query("UPDATE LZ_BARCODE_MT SET CONDITION_ID = $default_condition  WHERE BARCODE_NO = $barcode");
}    
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);
  // ======================================================================
/*================================================
=            update bin in barcode mt            =
================================================*/
	$bin_qry = $this->db->query("SELECT BIN_ID FROM BIN_MT WHERE UPPER(BIN_TYPE) || '-' || BIN_NO = '$bin_name'")->result_array();
	if(count($bin_qry) > 0){
		$bin_id = $bin_qry[0]['BIN_ID'];
		$this->db->query("UPDATE LZ_BARCODE_MT  SET BIN_ID = $bin_id WHERE ITEM_ID = '$item_id' AND LZ_MANIFEST_ID = '$manifest_id' AND CONDITION_ID = '$default_condition' AND CONDITION_ID = '$default_condition' AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL");
	}
/*=====  End of update bin in barcode mt  ======*/
	if(!empty($ship_change)){
  		$ship_fee = $ship_change;
  	}
  /*======================================================
  =            update weight in lz_manifest_det            =
  ======================================================*/
  if(!empty($weight)){
  	
  	$this->db->query("UPDATE LZ_MANIFEST_DET  SET WEIGHT = '$weight', SHIP_FEE = '$ship_fee' WHERE LAPTOP_ITEM_CODE = '$item_code'");
	/*==================================================================
	=            update weight & ship service in objects_mt            =
	==================================================================*/
		$get_mpn = $this->db->query("SELECT UPPER(I.ITEM_MT_MFG_PART_NO) MPN FROM ITEMS_MT I WHERE I.ITEM_ID =  '$item_id'")->result_array();
		$mpn = $get_mpn[0]['MPN'];
		if(!empty($object_id)){
			$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET WEIGHT = '$weight' , SHIP_SERV = '$shipping_service' WHERE OBJECT_ID = '$object_id'");
		}else{
			$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET WEIGHT = '$weight' , SHIP_SERV = '$shipping_service' WHERE OBJECT_ID = (SELECT C.OBJECT_ID FROM LZ_CATALOGUE_MT C WHERE UPPER(C.MPN) = '$mpn' AND C.CATEGORY_ID = '$category_id')");
		}

	/*=====  End of update weight & ship service in objects_mt  ======*/
  }else{
  	$this->db->query("UPDATE LZ_MANIFEST_DET  SET SHIP_FEE = '$ship_fee' WHERE LAPTOP_ITEM_CODE = '$item_code'");
	/*==================================================================
	=            update weight & ship service in objects_mt            =
	==================================================================*/
		$get_mpn = $this->db->query("SELECT UPPER(I.ITEM_MT_MFG_PART_NO) MPN FROM ITEMS_MT I WHERE I.ITEM_ID =  '$item_id'")->result_array();
		$mpn = $get_mpn[0]['MPN'];
		$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV = '$shipping_service' WHERE OBJECT_ID = (SELECT C.OBJECT_ID FROM LZ_CATALOGUE_MT C WHERE UPPER(C.MPN) = '$mpn' AND C.CATEGORY_ID = '$category_id')");

	/*=====  End of update weight & ship service in objects_mt  ======*/
  }
  /*=====  End of update weight in lz_manifest_det  ======*/
  /*================================================================
  =            get updated seed id for redirect purpose            =
  ================================================================*/
  $seed_qry = $this->db->query("SELECT SEED_ID FROM LZ_ITEM_SEED WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND DEFAULT_COND = $default_condition")->result_array();
  $seed_id = $seed_qry[0]['SEED_ID'];
  return $seed_id;
  /*=====  End of get updated seed id for redirect purpose  ======*/  

 }
function view($item_id,$manifest_id,$condition_id) 
 {
    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $path_query =  $path_query->result_array();

   /*================================  display seed   =============================*/

   $S_Result = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, trim(I.ITEM_MT_MFG_PART_NO) MFG_PART_NO, trim(I.ITEM_MT_UPC) UPC, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, D.WEIGHT, S.*, R.GENERAL_RULE, R.SPECIFIC_RULE, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, C.COND_NAME FROM LZ_ITEM_SEED     S, LZ_BARCODE_MT    B, LZ_MANIFEST_DET  D, ITEMS_MT         I, LZ_LISTING_RULES R, BIN_MT           BM, LZ_ITEM_COND_MT C WHERE B.ITEM_ID = S.ITEM_ID AND I.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND R.ITEM_CONDITION = S.DEFAULT_COND AND D.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND BM.BIN_ID = B.BIN_ID AND S.DEFAULT_COND = C.ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.ITEM_ID = $item_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");

   $S_Result = $S_Result->result();

    $all_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id AND B.LZ_MANIFEST_ID = $manifest_id AND B.CONDITION_ID = $condition_id");
    $all_barcode_qry =  $all_barcode_qry->result_array();
    $pic_note = [];
    foreach($all_barcode_qry as $barcode){
      $pic_note_query = $this->db->query("SELECT TD.LZ_BARCODE_ID,TD.SPECIAL_REMARKS, TD.PIC_NOTE FROM LZ_TESTING_DATA TD WHERE TD.LZ_BARCODE_ID = ".$barcode['BARCODE_NO']." AND ROWNUM = 1");
           
      if($pic_note_query->num_rows() > 0){
          $pic_note_query = $pic_note_query->result_array();
          $pic_note[]= @$pic_note_query;
          //array_push(@$barcode_arr, @$pic_note_query);
      }
    }
/*=================================================
=            get available qty to list            =
=================================================*/

	$list_qty = $this->db->query("SELECT COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL AND BC.LZ_MANIFEST_ID = $manifest_id AND BC.ITEM_ID = $item_id  AND BC.CONDITION_ID = $condition_id GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID"); 
	if($list_qty->num_rows() > 0){
		$list_qty = $list_qty->result_array();	    
	}else{
		$list_qty = null;
	}

/*=====  End of get available qty to list  ======*/
	$ebay_paypal_qry = $this->db->query("SELECT ITEM_ID,PAYPAL_FEE,EBAY_FEE FROM (SELECT SD.SALES_RECORD_NUMBER, E.ITEM_ID, ROUND((SD.PAYPAL_PER_TRANS_FEE / SD.SALE_PRICE) * 100, 2) PAYPAL_FEE, ROUND((SD.EBAY_FEE_PERC / SD.SALE_PRICE) * 100, 2) EBAY_FEE FROM LZ_SALESLOAD_DET SD, EBAY_LIST_MT E WHERE SD.ITEM_ID = E.EBAY_ITEM_ID AND SD.SALE_PRICE > 0 AND SD.PAYPAL_PER_TRANS_FEE > 0 AND SD.EBAY_FEE_PERC > 0 AND SD.QUANTITY = 1 AND E.ITEM_ID = $item_id ORDER BY SD.SALES_RECORD_NUMBER DESC) WHERE ROWNUM =1"); 
	if($ebay_paypal_qry->num_rows() > 0){
			$ebay_paypal_qry = $ebay_paypal_qry->result_array();	    
		}else{
			$ebay_paypal_qry = null;
		}
		$ship_fee_qry = $this->db->query("SELECT * FROM ( SELECT DISTINCT D.SHIP_FEE FROM LZ_MANIFEST_DET D WHERE D.LAPTOP_ITEM_CODE = (SELECT ITEM_CODE FROM ITEMS_MT WHERE ITEM_ID = $item_id) AND D.SHIP_FEE IS NOT NULL ORDER BY D.SHIP_FEE DESC) WHERE ROWNUM =1"); 
		if($ship_fee_qry->num_rows() > 0){
			$ship_fee_qry = $ship_fee_qry->result_array();	    
		}else{
			$category_id = $S_Result[0]->CATEGORY_ID;
   			$mpn = $S_Result[0]->MFG_PART_NO;
   			$ship_fee_qry = $this->db->query("SELECT O.SHIP_SERV SHIP_FEE,O.WEIGHT FROM LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = C.OBJECT_ID AND C.CATEGORY_ID = '$category_id' AND UPPER(TRIM(C.MPN)) = UPPER(TRIM('$mpn'))");
   			if($ship_fee_qry->num_rows() > 0){
			$ship_fee_qry = $ship_fee_qry->result_array();	    
			}else{ 
	   			$ship_fee_qry = null;
	   		}
		}
		$cost_qry = $this->db->query("SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = $item_id AND D.LZ_MANIFEST_ID = $manifest_id GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID"); 
		if($cost_qry->num_rows() > 0){
			$cost_qry = $cost_qry->result_array();	    
		}else{
			$cost_qry = null;
		}
	/*=====================================
	=            get object id            =
	=====================================*/
	$category_id = $S_Result[0]->CATEGORY_ID;
	$mpn = $S_Result[0]->MFG_PART_NO;
	$obj_qry = $this->db->query("SELECT C.OBJECT_ID FROM LZ_CATALOGUE_MT C WHERE C.CATEGORY_ID = $category_id AND UPPER(C.MPN) = UPPER('$mpn')");
	$obj_qry = $obj_qry->result_array(); 
	/*=====  End of get object id  ======*/

	/*=========================================================
	=            select item specific if available            =
	=========================================================*/
		$spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id");
		$spec_query = $spec_query->result_array();

		if(count($spec_query) == 0){
			$spec_query = "";
		}
	/*=====  End of select item specific if available  ======*/

	// code added by adil asad 2-6-2018
	$get_barcode = $this->uri->segment(5);
	//var_dump($get_barcode);
	if(!empty($get_barcode) ){

		$get_remark = $this->db->query("SELECT KK.DEKIT_REMARKS, KK.IDENT_REMARKS FROM LZ_DEKIT_US_DT KK WHERE KK.BARCODE_PRV_NO = $get_barcode")->result_array();
		if(count($get_remark) == 0){
			$get_remark = $this->db->query("SELECT L.PIC_NOTES IDENT_REMARKS, L.LOT_REMARKS DEKIT_REMARKS FROM LZ_SPECIAL_LOTS L  WHERE L.BARCODE_PRV_NO = $get_barcode")->result_array();
		}

	}
	// code added by adil asad 2-6-2018
	/*==============================================
	=            get condition dropdown            =
	==============================================*/

	$get_cond = $this->db->query("SELECT ID,COND_NAME FROM LZ_ITEM_COND_MT ORDER BY ID ASC")->result_array();

	/*=====  End of get condition dropdown  ======*/

	/*============================================
	=            get last three title            =
	============================================*/
	$current_title = strtoupper(trim($S_Result[0]->ITEM_TITLE));
	$current_title = str_replace("  ", ' ', $current_title);
    $current_title = str_replace(array("'"), "''", $current_title);
	//$history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE FROM (SELECT S.ITEM_TITLE FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.DEFAULT_COND = '$condition_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE ROWNUM < 4 ");
	// $history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE,EBAY_PRICE,DATE_TIME FROM (SELECT S.ITEM_TITLE,S.EBAY_PRICE,S.DATE_TIME FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.DEFAULT_COND = '$condition_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE ROWNUM < 4 ");

	$history_title = $this->db->query("SELECT * FROM (SELECT  ITEM_TITLE,EBAY_PRICE,DATE_TIME FROM (SELECT S.ITEM_TITLE,S.EBAY_PRICE,S.DATE_TIME FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.DEFAULT_COND = '$condition_id' AND S.ITEM_TITLE IS NOT NULL  ORDER BY S.DATE_TIME DESC)) WHERE ROWNUM < 4 ");

	if($history_title->num_rows() > 0){
		$history_title =  $history_title->result_array();	
	}else{
		//$history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE,ROWNUM RN FROM (SELECT S.ITEM_TITLE FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE  RN <> 1 AND RN < 5");
		// $history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE,EBAY_PRICE,DATE_TIME FROM (SELECT S.ITEM_TITLE,S.EBAY_PRICE,S.DATE_TIME FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE ROWNUM < 4 ");

		$history_title = $this->db->query("SELECT * FROM (SELECT  ITEM_TITLE,EBAY_PRICE,DATE_TIME FROM (SELECT S.ITEM_TITLE,S.EBAY_PRICE,S.DATE_TIME FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.ITEM_TITLE IS NOT NULL  ORDER BY S.DATE_TIME DESC)) WHERE ROWNUM < 4 ");

		$history_title =  $history_title->result_array();
	}
    /*=====  End of get last three title  ======*/
    /*==================================
    =            macro type            =
    ==================================*/
    $object_id = @$obj_qry[0]['OBJECT_ID'];
    if(!empty($object_id)){
    	$macro_type = $this->db->query("SELECT DISTINCT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T, LZ_MACRO_MT M WHERE T.TYPE_ID = M.TYPE_ID ORDER BY TYPE_ORDER ASC"); 
    	$macro_type =  $macro_type->result_array();
    	if(count($macro_type) == 0){
    		$macro_type = $this->db->query("SELECT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T ORDER BY T.TYPE_ORDER ASC"); 
    		$macro_type =  $macro_type->result_array();
    	}
    }else{
    	$macro_type = $this->db->query("SELECT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T ORDER BY T.TYPE_ORDER ASC"); 
    	$macro_type =  $macro_type->result_array();
    }
    
    /*=====  End of macro type  ======*/
    /*==========================================
    =            get avialable EPID            =
    ==========================================*/
    
    $get_epid = $this->db->query("SELECT T.EPID, C.TITLE,C.IMAGEURL,C.BRAND FROM LZ_BIND_EPID_DT_TMP T, LZ_EBAY_CATALOGUE_MT C WHERE T.ITEM_ID = '$item_id'AND T.EPID = C.EPID(+)");
    $get_epid =  $get_epid->result_array();
    
    /*=====  End of get avialable EPID  ======*/
    
   return array('result'=>$S_Result, 'path_query'=>$path_query,'pic_note'=>$pic_note, 'list_qty'=>$list_qty,'ebay_paypal_qry'=>$ebay_paypal_qry, 'ship_fee_qry'=>$ship_fee_qry, 'cost_qry'=>$cost_qry, 'spec_query'=>$spec_query ,'get_remark'=>$get_remark,'get_cond'=>$get_cond,'history_title'=>$history_title,'get_epid'=>$get_epid,'macro_type'=>$macro_type,'obj_qry'=>$obj_qry);
   
   /*=====  End of display seed   ======*/
   

}


 function edit($a) {
  $d = $this->db->get_where('LZ_ITEM_SEED', array('ITEM_ID' => $a))->row();
  return $d;
 }
  function delete($a) {
  $this->db->delete('LZ_ITEM_SEED', array('ITEM_ID' => $a));
  return;
 }

 function template_fields()
 {

// for this query in VIEW use this $row['VALUE']; instead of $row->VALUE;
  $query = $this->db->query("SELECT TEMPLATE_ID,TEMPLATE_NAME FROM LZ_ITEM_TEMPLATE ORDER BY TEMPLATE_NAME DESC");
      return $query->result_array();
//    $query = $this->db->select('TEMPLATE_ID,TEMPLATE_NAME');
//    $query = $this->db->from('LZ_ITEM_TEMPLATE');

// return $query->result_array();
    // $temp_result = $this->db->get();
    // return $temp_result;
    
 }
	
	/*=====  End of copy from m_seed_process  ======*/


	/*===============================================
	=            copy from listing model            =
	===============================================*/
	public function is_active_listing($item_id,$condition_id,$upc,$mpn){
			$lz_seller_acct_id= $this->session->userdata('account_type');
			//$q = $this->db->query("SELECT MAX(EBAY_ITEM_ID) EBAY_ITEM_ID FROM EBAY_LIST_MT WHERE ITEM_ID = $item_id AND ITEM_CONDITION = $condition_id AND LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID");
      //$q = $this->db->query("SELECT MAX(L.EBAY_ITEM_ID) EBAY_ITEM_ID FROM EBAY_LIST_MT L, LZ_ITEM_SEED LS WHERE L.ITEM_ID = LS.ITEM_ID AND L.LZ_MANIFEST_ID = LS.LZ_MANIFEST_ID AND L.SEED_ID = LS.SEED_ID AND L.ITEM_ID = $item_id AND LS.DEFAULT_COND = $condition_id AND L.LZ_SELLER_ACCT_ID=$lz_seller_acct_id"); 
      $q = $this->db->query("SELECT is_active_listing('$upc','$mpn',$condition_id,$lz_seller_acct_id) EBAY_ITEM_ID FROM DUAL");
      // $rs = $query->result_array();
      // $loading_no = $rs[0]['ID'];
      $rslt = $q->result_array();
			 if(!empty($rslt)){
			 	$ebay_id=$rslt[0]['EBAY_ITEM_ID'];
			 	$this->session->set_userdata('check_item_id', true);
			 	$this->session->set_userdata('ebay_item_id', $ebay_id);
			 	return true;
			}else{
			 	$this->session->set_userdata('check_item_id', false);
			 	return false;
			  }
		}
	
	public function uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise){

		if($check_btn == 'revise' AND $forceRevise == 0){
			$query = $this->db->query("SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_MT_MANUFACTURE MANUFACTURE, trim(I.ITEM_MT_MFG_PART_NO) PART_NO, I.ITEM_MT_BBY_SKU     SKU, trim(I.ITEM_MT_UPC)         UPC, LS.DEFAULT_COND      ITEM_CONDITION, BCD.QTY               QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE,LS.EPID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND = $condition_id AND ROWNUM=1");
		}else{
			$query = $this->db->query("SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_MT_MANUFACTURE MANUFACTURE, trim(I.ITEM_MT_MFG_PART_NO) PART_NO, I.ITEM_MT_BBY_SKU     SKU, trim(I.ITEM_MT_UPC)         UPC, LS.DEFAULT_COND      ITEM_CONDITION, BCD.QTY               QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE,LS.EPID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND = $condition_id AND ROWNUM=1");
		}
			return $query->result_array(); 
	}
	public function uplaod_seed_pic($item_id,$manifest_id,$condition_id){

			// $query = $this->db->query("SELECT I.ITEM_MT_MFG_PART_NO,I.ITEM_MT_UPC FROM ITEMS_MT I WHERE I.ITEM_ID = $item_id"); 
			// $result=$query->result_array();
			// $mpn = $result[0]['ITEM_MT_MFG_PART_NO'];
			// $upc = $result[0]['ITEM_MT_UPC'];
			// $it_condition = $condition_id;
		 //    $mpn = str_replace('/', '_', @$mpn);

/*==============================================
=            Dekitted Picture Check            =
==============================================*/
			// Open a directory, and read its contents
		$list_barcode = $this->uri->segment(5);
		// var_dump($list_barcode);exit;
		if(empty($list_barcode)){
			$list_barcode = $this->input->post('list_barcode');
		}
	    $sql = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
	    $dekit_qry = $sql->result_array();
	    $dekit_qry = $dekit_qry[0]['MASTER_PATH'];

		$get_folder = $this->db->query("SELECT L.FOLDER_NAME FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $list_barcode");
	    if($get_folder->num_rows() > 0){
	       $get_folder = $get_folder->result_array();
	       $list_barcode = $get_folder[0]['FOLDER_NAME'];
	    }

	   	$d_dir = $dekit_qry.$list_barcode;
	    if(is_dir(@$d_dir)){
				  $iterator = new \FilesystemIterator(@$d_dir);
			    if (@$iterator->valid()){    
			    	$d_flag = true;
				}else{
					$d_flag = false;
				}
		}else{
			$d_flag = false;
		}


/*=====  End of dekitted Picture Check  ======*/
		if($d_flag === true){
			return "D";
		}else{
			die('Error! Item Picture Not Found.');
		}
		
	}//end function
		public function item_specifics($item_id, $manifest_id,$condition_id){
		// $item_id = 18786;
		// $manifest_id = 13827;
			$query = $this->db->query("SELECT I.ITEM_MT_UPC, I.ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");
			$result = $query->result_array();
			if($query->num_rows() > 0){

				if(!empty($result[0]['ITEM_MT_UPC'])){
					$where_upc = " AND MT.UPC = '".$result[0]['ITEM_MT_UPC']."'";
				}else{
					$where_upc = ' ';
				}
				if(!empty($result[0]['ITEM_MT_MFG_PART_NO'])){
					$where_mpn = " AND MT.MPN = '".$result[0]['ITEM_MT_MFG_PART_NO']."'";
				}else{
					$where_mpn = '';
				}

				$spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id AND MT.CATEGORY_ID = ".$result[0]['CATEGORY_ID'].$where_upc.$where_mpn);
				$spec_query = $spec_query->result_array();

			}else{
				$spec_query = "";
			}

			return $spec_query; 

			//var_dump($spec_query);exit ;

			

		}
		public function insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise){
			$list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
			$rs = $list_rslt->result_array();
			$LIST_ID = $rs[0]['LIST_ID'];
			$this->session->set_userdata('list_id',$LIST_ID);
			$ebay_id = $this->session->userdata('ebay_item_id');
			if($check_btn == "revise"){
				$status = "UPDATE";

				// if(@$forceRevise === 1){

				// 	$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
				// 	if($query->num_rows() === 0){
				// 		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
				// 	}

				// 	$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
				// }else{

				// 	$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL AND BC.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
				// 	if($query->num_rows() === 0){
				// 		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
				// 	}

				// 	$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
				// }

				$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL AND BC.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
					if($query->num_rows() === 0){
						$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
					}

					$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
			}else{
				$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_IN IS NULL AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
				$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
			}//check_btn if else close
			 $rslt_dta = $query->result_array();
			//$list_date = date("d/M/Y");// return format Aug/13/2016
			date_default_timezone_set("America/Chicago");
			$list_date = date("Y-m-d H:i:s");
      		$list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
			$lister_id = $this->session->userdata('user_id');
			$ebay_item_desc = @$rslt_dta[0]['ITEM_TITLE'];
		    $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
		    $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));
			if($check_btn == "revise"){
		    	//$current_qty = $this->session->userdata('current_qty');
		    	$list_qty = 0;
		    }else{
		    	$list_qty = @$rslt_dta[0]['QUANTITY'];
		    }
			$ebay_item_id = $ebay_id;
			$list_price = @$rslt_dta[0]['EBAY_PRICE'];
			$remarks = NULL;
			$single_entry_id = NULL;
			$salvage_qty = 0.00;
			$entry_type ="L";
			$LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');
			$auth_by_id = $this->session->userdata('dekit_auth_by_id');
			$list_qty = "'".$list_qty."'";
			$insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, AUTH_BY_ID,FORCEREVISE)VALUES (".$LIST_ID.",".$manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",'".$ebay_item_id."','".$list_price."',NULL,NULL, NULL, '".$entry_type."','".$LZ_SELLER_ACCT_ID."','".$seed_id."','".trim($status)."','".$condition_id."', '".$auth_by_id."',".@$forceRevise.")");
      if($insert_query){
        $this->db->query($update_barcode_qry);        
      	$this->db->query("UPDATE LZ_LISTING_ALLOC SET LIST_ID = $LIST_ID WHERE SEED_ID = $seed_id");
      	return $LIST_ID;
      }
		}
	/*=====  End of copy from listing model  ======*/

  // public function item_barcode($item_id,$manifest_id,$condition_id){
  //   $query = $this->db->query("SELECT BARCODE_NO FROM LZ_BARCODE_MT WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id");
  //   return $query->result_array();
    
  // }
	 public function insert_ebay_url(){
	 $ebay_item_id = $this->session->userdata('ebay_item_id');
	 //$ebay_item_url = $this->session->userdata('ebay_item_url');
	 $ebay_item_url = "https://www.ebay.com/itm/".$ebay_item_id;
	 date_default_timezone_set("America/Chicago");
	 $list_date = date("Y-m-d H:i:s");
     $ins_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
	 $entered_by = $this->session->userdata('user_id');	
	 $comma = ',';
	 $query = $this->db->query("SELECT * FROM LZ_LISTED_ITEM_URL WHERE EBAY_ID = $ebay_item_id");
	 $result = $query->result_array();
	 if($query->num_rows() == 0){
	 	$insert_query = $this->db->query("INSERT INTO LZ_LISTED_ITEM_URL VALUES ($ebay_item_id $comma '$ebay_item_url' $comma $ins_date $comma $entered_by)");
	 }
  }

  public function approvalForListing(){
	 date_default_timezone_set("America/Chicago");
	 $list_date = date("Y-m-d H:i:s");
     $ins_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
	 $entered_by = $this->session->userdata('user_id');
	 $approved_items = $this->input->post('approval');

	 foreach($approved_items as $approval){
	 	 $query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $approval");

	 }
	 
 	if($query){
      return true;
   	}else{
    	return false;
    }	 

	
  }


/*=============================================
=            For Listed Item Datatable           =
=============================================*/





  public function loadData(){
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LIST_ID',
			1 =>'EBAY_ITEM_ID',
			2 =>'', 
			3 => 'ITEM_CONDITION',
			4 => 'ITEM_TITLE',
			5 => 'QTY',
			6 => '',
			7 => 'PURCH_REF_NO',
			8 => 'ITEM_MT_UPC',
			9 => 'ITEM_MT_MFG_PART_NO ',
			10 => 'ITEM_MT_MANUFACTURE',
			11 => 'SHIPPING_SERVICE',
			12=>'',
			13=>'LIST_DATE',
			14=>'',
			15=>'STATUS',
		);
		$lister_id = $this->session->userdata('user_id');
    	$users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
	    /*echo "<pre>";
	    print_r($users->result_array());
	    exit;*/

    	$employees = array(2,4,5,7,13,19,27,28,29,30,31,32);
    	$listing_qry = '';
		
    	// if(in_array($lister_id, $employees)){
	      $listing_qry = $this->db->query("SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID");
	    
	    


		

		// $sql = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id");
		$totalData = $listing_qry->num_rows();
		// var_dump($totalData);exit;
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		

		$sql = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID";
		
			// if(is_numeric($sql->BCD.CONDITION_ID)){
			// 	if($sql->BCD.CONDITION_ID == 3000){
   //                $sql->BCD.CONDITION_ID = 'Used';
   //              }elseif($sql->BCD.CONDITION_ID == 1000){
   //                $sql->BCD.CONDITION_ID = 'New'; 
   //              }elseif($sql->BCD.CONDITION_ID == 1500){
   //                $sql->BCD.CONDITION_ID = 'New other'; 
   //              }elseif($sql->BCD.CONDITION_ID== 2000){
   //                $sql->BCD.CONDITION_ID = 'Manufacturer refurbished';
   //              }elseif($sql->BCD.CONDITION_ID == 2500){
   //                $sql->BCD.CONDITION_ID = 'Seller refurbished'; 
   //              }elseif($sql->BCD.CONDITION_ID == 7000){
   //                $sql->BCD.CONDITION_ID = 'For parts or not working'; 
   //              }

			// }

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( BCD.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LS.SHIPPING_SERVICE LIKE '%".$requestData['search']['value']."%' )";
					
			}else{
				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND (BCD.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LS.SHIPPING_SERVICE LIKE '%".$requestData['search']['value']."%' )";
					
				}
			}
			// else{
			
			// 	if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
			// 		$sql.=" AND ( BC.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";    
			// 			$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
			// 			$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
			// 			$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
			// 			$sql.=" OR I.ITEM_MT_MFG_PART_NO '%".$requestData['search']['value']."%' ";
			// 			$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' )";
						
			// 	}
			// }


		$query = $this->db->query($sql);
		
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
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
		// $qry = array_combine(keys, values)

		// print_r($listed_barcode);exit;
		// $qry = array('query'=>$query,'listed_barcode'=>$listed_barcode);
		// print_r($qry);exit;
		// 
		
		foreach($query as $row ){ 
			$nestedData=array();

			$nestedData[] ='<div style="width:100px;"><div style="float:left;margin-right:8px;">
                             <a href="'.base_url().'tolist/c_tolist/seed_view/'.$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         
                             <a style=" margin-right: 3px;" href="'.base_url().'listing/listing/print_label/'.$row['LIST_ID'].'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                          </div>';

			// $nestedData[] =	"<input title='checkbox' type='checkbox' name='select_recognize[]' id='select_recognize' value='".$row['LZ_BD_CATA_ID']."'>";
			
			// $nestedData[] = "";
		    $nestedData[] = $row["EBAY_ITEM_ID"];
		    $listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID = ".$row["ITEM_CONDITION"]."  
				AND BC.LZ_MANIFEST_ID =".$row["LZ_MANIFEST_ID"]." AND BC.ITEM_ID=".$row["ITEM_ID"]." " );
			$listed_barcode =  $listed_barcode->result_array();

			// $nestedData[] = rtrim(implode(',', $listed_barcode), ',');
			$barData  = '';
			foreach($listed_barcode as $barcode){
				$barData.= $barcode['BARCODE_NO'].'-';
			}
			$nestedData[] = $barData;
		    // $nestedData[] ="";
		    // $nestedData[] = $qry['listed_barcode']['BARCODE_NO'];
		    if(is_numeric($row["ITEM_CONDITION"])){
                if($row["ITEM_CONDITION"] == 3000){
                  $nestedData[] = 'Used';
                }elseif($row["ITEM_CONDITION"] == 1000){
                  $nestedData[] = 'New'; 
                }elseif($row["ITEM_CONDITION"] == 1500){
                  $nestedData[] = 'New other'; 
                }elseif($row["ITEM_CONDITION"]== 2000){
                    $nestedData[] = 'Manufacturer refurbished';
                }elseif($row["ITEM_CONDITION"] == 2500){
                  $nestedData[] = 'Seller refurbished'; 
                }elseif($row["ITEM_CONDITION"] == 7000){
                  $nestedData[] = 'For parts or not working'; 
                }
			}
		    // $nestedData[] = $row["ITEM_CONDITION"];
			$nestedData[] = $row["ITEM_MT_DESC"];
			$nestedData[] = $row["QUANTITY"];
			$nestedData[] = "";
			// $nestedData[] = $row["ITEM_TITLE"];
			// $nestedData[] = "<a target='_blank' href='".$row['ITEM_URL']. "'>".$row['EBAY_ID']. "</a>";
			//$nestedData[] = $row["EBAY_ID"];
			$nestedData[] =  $row["PURCH_REF_NO"];
			$nestedData[] = $row["UPC"];
			// $nestedData[] = $row["SELLER_ID"];
			// $nestedData[] = $listing_type;
			// $nestedData[] = '$ '.number_format((float)@$row['SALE_PRICE'],2,'.',',');
			//$nestedData[] = $row["SALE_PRICE"];
			$nestedData[] = $row["MFG_PART_NO"];
			$nestedData[] = $row["MANUFACTURER"];
			$nestedData[] = $row["SHIPPING_SERVICE"];
			$nestedData[] = "";
			$nestedData[] = $row["LIST_DATE"];
			$nestedData[] = "";
			$nestedData[] = $row["STATUS"];
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

	/*=====  End Listed Item DataTables  ======*/
	 	

/*=============================================
=          For Not Listed Item Datatable            =
=============================================*/


	function secondLoadData(){
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'SEED_ID',
			1 =>'OTHER_NOTES',
			2 =>'', 
			3 => '',
			4 => 'CONDITION_ID',
			5 => 'ITEM_TITLE',
			6 => 'QTY',
			7 => 'PURCH_REF_NO',
			8 => 'ITEM_MT_UPC',
			9 => 'ITEM_MT_MFG_PART_NO ',
			10 => 'ITEM_MT_MANUFACTURE',
			11 => ''
			
		);
		$lister_id = $this->session->userdata('user_id');
	    $users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
	    /*echo "<pre>";
	    print_r($users->result_array());
	    exit;*/

	    $employees = array(2,4,5,7,13,19,27,28,29,30,31,32);

	  	
	  	$listing_qry ='';
	    if(in_array($lister_id, $employees)){
	      $listing_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE ,I.ITEM_DESC)  ITEM_MT_DESC ,I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL";
	    }else{
	      	$listing_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC A, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID";
	    }

	      
	   	  $listing_qry = $this->db->query($listing_qry);
	      $totalData = $listing_qry->num_rows();
	      $totalFiltered = $totalData;

	      $sql ="";
		if(in_array($lister_id, $employees)){
	      $sql = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE ,I.ITEM_DESC)  ITEM_MT_DESC ,I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL";
	    }else{
	      	$sql = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC A, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID";
	    }

	    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' )";
					
					
			}else{
				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";   
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
					
				}
			}

			$query = $this->db->query($sql);

			$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		 	$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
			//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
			$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;

			$query = $this->db->query($sql);
			$query = $query->result_array();
			$data = array();


			$path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      		$path_query =  $path_query->result_array();
			foreach($query as $row ){ // preparing an array
			
				$nestedData=array();

	 

				$nestedData[] =' <div style="width:100px;"> <div style="float:left;margin-right:8px;"> <form action="<?php echo base_url(); ?>tolist/c_tolist/list_item" method="post" accept-charset="utf-8"> <input type="hidden" name="seed_id" value="'.$row["SEED_ID"].'"/><input type="submit" name="item_list" title="List to eBay" onclick="return confirm("Are you sure?");" class="btn btn-success btn-sm" value="List"> </form> </div> 
				<div style="float:left;margin-right:8px;"> <a href="'.base_url().'tolist/c_tolist/seed_view/'.$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> 
				</div>';
				
			    $nestedData[] = $row['OTHER_NOTES'];

			    	      $it_condition = $row["ITEM_CONDITION"];
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
			      $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        $master_path = $path_query[0]['MASTER_PATH'];
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/thumb/";
                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
                        // var_dump($m_dir);

                        $specific_path =$path_query[0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/thumb/";
                        $s_dir = preg_replace("/[\r\n]*/","",$s_dir);
                        // var_dump($s_dir);
                            //var_dump($m_dir);exit;
                        if(is_dir(@$m_dir)){
                                    $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                              }elseif(is_dir(@$s_dir)){
                                $iterator = new \FilesystemIterator(@$s_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                              }else{
                                $m_flag = false;
                              }
                         
			    if (is_dir($m_dir)){
                    // $images = glob("$m_dir*.jpg");
                    // sort($images);
                    $images = scandir($m_dir);
                    // Image selection and display:
                    //display first image
                    if (count($images) > 0) { // make sure at least one image exists
                        $url = $images[2]; // first image
                        $img = file_get_contents($m_dir.$url);
                        $img =base64_encode($img); 
                       $nestedData[] ='<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"> <img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/> </div>';

                    }
                  }else{
                     // var_dump($s_dir);
                    $images = scandir($s_dir);
                    
                    if (count($images) > 0) { // make sure at least one image exists
                        $url = $images[2]; // first image
                        $img = file_get_contents($s_dir.$url);
                        $img =base64_encode($img); 
                       $nestedData[] ='<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
                    }
                  }



			    // $nestedData[] ='';
			    $notListed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID = ".$row["ITEM_CONDITION"]."AND BC.LZ_MANIFEST_ID =".$row["LZ_MANIFEST_ID"]." AND BC.ITEM_ID=".$row["ITEM_ID"]." " ); 
			    $notListed_barcode =  $notListed_barcode->result_array();
			    $barData  = '';
				foreach($notListed_barcode as $barcode){
					$barData.=$barcode['BARCODE_NO'].'-';
				}

				$nestedData[] =$barData;
			    $nestedData[] = $it_condition;
				$nestedData[] = $row["ITEM_MT_DESC"];
				$nestedData[] = $row["QUANTITY"];
				
				$nestedData[] =  $row["PURCH_REF_NO"];
				$nestedData[] = $row["UPC"];
				
				$nestedData[] = $row["MFG_PART_NO"];
				$nestedData[] = $row["MANUFACTURER"];
				
				$current_timestamp = date('m/d/Y');
                    $purchase_date = @$row['LOADING_DATE'];
                    
                    $date1=date_create($current_timestamp);
                    $date2=date_create($purchase_date);
                    $diff=date_diff($date1,$date2);
                    $date_rslt = $diff->format("%R%a days");
                $nestedData[] = abs($date_rslt)." Days";
				
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

	/*=====  End Not Listed Items Datatable  ======*/

	/*===============================================================================
	=            for getting special remarks new listing view --YOUSAF--            =
	===============================================================================*/
	
	public function get_remarks($barcode){
		$qry = $this->db->query("SELECT D.DEKIT_REMARKS , D.IDENT_REMARKS, D.PIC_NOTES FROM LZ_DEKIT_US_DT D WHERE D.BARCODE_PRV_NO = $barcode");
		$qry = $qry ->result_array();
		return $qry;
	}
	
	
	/*=====  End of for getting special remarks new listing view --YOUSAF--  ======*/

	public function authPasswordCheck(){
		$auth_password = $this->input->post('auth_password');		
		$query = $this->db->query("SELECT E.AUTH_PASSWORD, E.EMPLOYEE_ID FROM EMPLOYEE_MT E WHERE E.AUTH_PASSWORD = '$auth_password'");
		if($query->num_rows() > 0){
		 	$query = $query->result_array();
		 	$dekit_auth_by_id = @$query[0]['EMPLOYEE_ID'];

			$this->session->set_userdata('dekit_auth_by_id', $dekit_auth_by_id);
			//$auth_by_id = $this->session->userdata('dekit_auth_by_id');
			//var_dump($auth_by_id);exit;						
			return 1;
		}else{
			return 0;
		}
	}	

}


 ?>