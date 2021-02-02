<?php  

	class M_dekit_sticker extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function listedTable(){

		$master_barcode = $this->session->userdata('ctc_kit_barcode');
		$listing_qry = $this->db->query("SELECT DT.LAPTOP_ITEM_CODE,DT.ITEM_MT_MANUFACTURE, DT.LZ_MANIFEST_ID LZ_MANIFEST_ID, BB.BARCODE_NO BARCODE_NO, DT.ITEM_MT_DESC ITEM_DESC, DT.ITEM_MT_UPC UPC, DT.ITEM_MT_MFG_PART_NO MFG_PART_NO, '1' QTY, DT.CONDITIONS_SEG5 ITEM_CONDITION FROM LZ_MANIFEST_DET DT, LZ_BARCODE_MT BB WHERE DT.EST_DET_ID IN (SELECT E.LZ_ESTIMATE_DET_ID FROM LZ_BD_ESTIMATE_DET E WHERE E.ITEM_ADJ_DET_ID IN (SELECT D.ITEM_ADJUSTMENT_DET_ID FROM ITEM_ADJUSTMENT_DET D WHERE D.ITEM_ADJUSTMENT_ID = (SELECT B.ITEM_ADJ_DET_ID_FOR_OUT FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $master_barcode) AND D.PRIMARY_QTY > 0)) AND DT.LZ_MANIFEST_ID = BB.LZ_MANIFEST_ID "); /*  LZ_LISTING_ALLOC A,*/
		/*  AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID */
		$listing_qry = $listing_qry->result_array();

	      $listed_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE = 1 ORDER BY LIST_DATE DESC"; 
	  	
	      $listed_qry = $this->db->query($listed_qry);
	      $listed_qry = $listed_qry->result_array();		

	    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
	    $path_query =  $path_query->result_array();

	  $master_barcode = $this->db->query ("SELECT B.BARCODE_NO,B.ITEM_ID, B.LZ_MANIFEST_ID, B.ITEM_ADJ_DET_ID_FOR_OUT, S.ID, S.PURCHASE_DATE, S.ITEM_MT_DESC, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_UPC, S.CONDITIONS_SEG5, S.PO_DETAIL_RETIAL_PRICE, S.AVAILABLE_QTY FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, LZ_SINGLE_ENTRY S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND B.BARCODE_NO = $master_barcode")->result_array();

		return array('listing_qry'=>$listing_qry, 'path_query'=>$path_query, 'listed_qry'=>$listed_qry ,'master_barcode'=>$master_barcode);

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
	public function dekitPrintSingle(){

		$item_code = $this->uri->segment(4);
		$manifest_id =	$this->uri->segment(5);
		$barcode = $this->uri->segment(6);


	    $print_qry = $this->db->query("SELECT B.BARCODE_NO BAR_CODE, LPAD(O.OBJECT_NAME, 16) OBJECT_NAME, SUBSTR(t.item_mt_desc, 1, 80) ITEM_DESC, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE = t.laptop_item_code AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM = 1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:' || t.item_mt_bby_sku SKU FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET  T, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND UPPER(T.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND C.OBJECT_ID = O.OBJECT_ID(+) AND T.E_BAY_CATA_ID_SEG6 = C.CATEGORY_ID(+) AND T.LAPTOP_ITEM_CODE = '$item_code'AND B.LZ_MANIFEST_ID = $manifest_id AND B.BARCODE_NO = $barcode AND ROWNUM =1");

	    //$query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");     
	    //var_dump($print_qry);exit;
	    return $print_qry->result_array();

	}


}