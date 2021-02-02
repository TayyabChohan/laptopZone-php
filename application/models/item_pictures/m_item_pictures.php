<?php 
/**
* Item Pictures Model
*/
	class M_Item_Pictures extends CI_Model
	{

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
		
	public function item_search($barcode){

		$search_qry = $this->db->query("SELECT B.HOLD_STATUS, B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.BIN_ID, B.EBAY_ITEM_ID, B.PRINT_STATUS, B.CONDITION_ID ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, TRIM(V.MFG_PART_NO) MFG_PART_NO, TRIM(V.UPC) UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE, TD.SPECIAL_REMARKS, TD.PIC_NOTE, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, C.COND_NAME FROM LZ_BARCODE_MT B, BIN_MT BI, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE) V, LZ_TESTING_DATA TD, LZ_ITEM_COND_MT C WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND TD.LZ_BARCODE_ID = B.LZ_BARCODE_MT_ID AND BI.BIN_ID = B.BIN_ID AND C.ID = B.CONDITION_ID AND B.BARCODE_NO = $barcode AND B.CONDITION_ID IS NOT NULL ORDER BY B.ITEM_ID, B.UNIT_NO ");
		
		if($search_qry->num_rows() == 0){
			$search_qry = $this->db->query("SELECT B.HOLD_STATUS, B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.BIN_ID, B.EBAY_ITEM_ID, B.PRINT_STATUS, B.CONDITION_ID ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, TRIM(V.MFG_PART_NO) MFG_PART_NO, TRIM(V.UPC) UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, C.COND_NAME FROM LZ_BARCODE_MT B, BIN_MT BI, LZ_ITEM_COND_MT C, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND BI.BIN_ID = B.BIN_ID AND C.ID = B.CONDITION_ID AND B.BARCODE_NO = $barcode ORDER BY B.ITEM_ID, B.UNIT_NO "); $search_query =  $search_qry->result_array();

		}else{
			$search_query =  $search_qry->result_array();
		}

		$path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
		$path_query =  $path_query->result_array();

		if($search_qry->num_rows() > 0){
			$cond_query = $this->db->query("SELECT DISTINCT B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.ITEM_ID =  ".$search_query[0]['ITEM_ID']." AND B.LZ_MANIFEST_ID = ".$search_query[0]['LZ_MANIFEST_ID']."");
			$cond_query =  $cond_query->result_array();			
		}else{
			
			$this->session->set_userdata('barcode_error', TRUE);
			return TRUE;
		}


		$barcode_query = $this->db->query("SELECT B.BARCODE_NO, B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.ITEM_ID =  ".$search_query[0]['ITEM_ID']." AND B.LZ_MANIFEST_ID = ".$search_query[0]['LZ_MANIFEST_ID']." AND B.CONDITION_ID IN(SELECT DISTINCT B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.ITEM_ID =  ".$search_query[0]['ITEM_ID']." AND B.LZ_MANIFEST_ID = ".$search_query[0]['LZ_MANIFEST_ID'].") order by b.condition_id");	

		$barcode_query =  $barcode_query->result_array();	
		//var_dump(@$barcode_query);exit;

		$uniq_cond_query = $this->db->query("SELECT B.CONDITION_ID,MAX(C.COND_NAME) COND_NAME, COUNT(B.CONDITION_ID) QTY FROM LZ_BARCODE_MT B,LZ_ITEM_COND_MT C WHERE B.ITEM_ID = ".$search_query[0]['ITEM_ID']." AND B.LZ_MANIFEST_ID = ".$search_query[0]['LZ_MANIFEST_ID']." AND CONDITION_ID IS NOT NULL AND C.ID = B.CONDITION_ID GROUP BY B.CONDITION_ID "); 

		$uniq_cond =  $uniq_cond_query->result_array();	

		if($search_query){
			//return $query->result_array();
			return array('search_query'=>$search_query, 'path_query'=>$path_query, 'cond_query'=>$cond_query, 'barcode_query'=>$barcode_query, 'uniq_cond'=>$uniq_cond);			
			
			//echo "<script> alert('Item test not found. Please test item first.'); </script>";
		}else{
			return "not_found";
		} 
		
	}
	public function setBinIdtoSession(){
		$master_bin_id = trim(strtoupper($this->input->post("bin_id")));

		$bindId = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$master_bin_id' ")->result_array();
   
	    if(count($bindId) > 0) {
			$this->session->set_userdata('master_bin_id', $master_bin_id);
			$sess_val = $this->session->userdata("master_bin_id");
			return true;
		}else{
			return false;
		}
	}                        

		
}


?>