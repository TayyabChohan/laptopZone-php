<?php  

	class M_Listing extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function listedTable(){
		$listing_qry = $this->db->query("SELECT LS.SEED_ID, LS.ENTERED_BY, LS.SHIPPING_SERVICE, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_CODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION, BCD.LZ_MANIFEST_ID, BCD.QTY               QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC, lz_manifest_mt m where m.lz_manifest_id = bc.lz_manifest_id and m.manifest_type = 1 and BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID ORDER BY LOADING_DATE DESC ");
		 /*  LZ_LISTING_ALLOC A,*/
		/*  AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID */
		$listing_qry = $listing_qry->result_array();

	      $listed_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE = 1 ORDER BY LIST_DATE DESC"; 
	  	
	      $listed_qry = $this->db->query($listed_qry);
	      $listed_qry = $listed_qry->result_array();		

	    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
	    $path_query =  $path_query->result_array();

		return array('listing_qry'=>$listing_qry, 'path_query'=>$path_query, 'listed_qry'=>$listed_qry);

	}

	public function updateShip(){
		$seed_id 				= 	$this->input->post('seed_id');
		$ship_service 			= 	$this->input->post('ship_service');
		//var_dump($seed_id, $ship_service); exit;
		$update_ship = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.SHIPPING_SERVICE = '$ship_service' WHERE S.SEED_ID =  $seed_id");
		if ($update_ship) {
			return true;
		}else {
			return false;
		}
	}
	// public function list_get_data(){

	// 	$Barcode_no = $this->input->post('lz_bar_code');

	// 	$qry ="SELECT B.BARCODE_NO BARCODE_NO, S.ITEM_MT_MFG_PART_NO ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC ITEM_MT_DESC, S.ITEM_MT_UPC ITEM_MT_UPC, S.CONDITIONS_SEG5 CONDITIONS_SEG5, S.PURCHASE_DATE PURCHASE_DATE FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, LZ_SINGLE_ENTRY S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND M.SINGLE_ENTRY_ID IS NOT NULL AND B.BARCODE_NO =$Barcode_no";
	// 	$list_qry = $this->db->query($qry)->result_array();
			 
			
	// 	return $list_qry;


	// }


}