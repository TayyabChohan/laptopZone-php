<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class M_Pos_Single_Entry extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		}

		public function loading_no(){
/*=============================================
			=            Create auto Purchase Ref No.            =
			=============================================*/
		  $query = $this->db->query("SELECT PURCHASE_REF_NO, ID as LOADING_NO FROM LZ_SINGLE_ENTRY WHERE ROWNUM = 1 ORDER BY ID DESC");
	      $rs = $query->result_array();
	      // $purch_ref = $rs[0]['PURCHASE_REF_NO'];
	      // $str = explode('-', $purch_ref);
	      // $last_num = end($str);
	      // $date = date('d-M-y');
       //    $current_date = strtoupper($date);
	      // $last_date = $str[0].'-'.$str[1].'-'.$str[2];
	      // if($last_date == $current_date){
	      // 	$count = $last_num + 1;
	      // 	$purch_ref = strtoupper($date.'-'. $count);
	      // }else{
	      // 	$purch_ref = strtoupper($date.'-'. 1);
	      // }
	      
			/*=====  End of Create auto Purchase Ref No.  ======*/

			// $list_rslt = $this->db->query("SELECT MAX(ID) as LOADING_NO FROM lz_single_entry");
			// $rs = $list_rslt->result_array();

			// $e = $rs[0]['LOADING_NO'];
			// //var_dump($e);exit;
			// if(@$e == 0){$ID = 1;}else{$ID = $e+1;}	
			return $rs;		
		}
		public function purchase_ref_no($purch_ref){

			$query = $this->db->query("SELECT * FROM PURCHASE_INVOICE_MT WHERE PURCH_INVOICE_REF_NO = '$purch_ref'");
			//var_dump($query->num_rows());exit;
			if($query->num_rows() == 0){
				return false;
			}else{
				return true;
			}
			//return $query->result_array();
		}
		
		public function add() {

		  //$loading_no = $this->input->post('loading_no');
		  $pos_only = $this->input->post('pos_only');
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
		  $purchase_date = $this->input->post('purchase_date');
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
          if(empty($origin)){
          	$origin = "";
          }
		  $condition = $this->input->post('default_condition');
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }
		  $ebay_item_id = '';
		  $user_name = $this->input->post('user_name');
		  $user_name = trim(str_replace("  ", ' ', $user_name));
          $user_name = trim(str_replace(array("'"), "''", $user_name));
		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));
		  $job_no = $this->input->post('job_no');
		  $category_id = $this->input->post('category_id');
		  $comma = ',';
		  $query = $this->db->query("SELECT get_single_primary_key('LZ_SINGLE_ENTRY','ID') ID FROM DUAL");
	      $rs = $query->result_array();
	      $loading_no = $rs[0]['ID'];
		//var_dump($loading_no."-".$purch_ref."-".$suplier_desc."-".$remarks."-".$purchase_date);exit;

			/*=============================================
			=            Create auto Purchase Ref No.            =
			=============================================*/
		  $query = $this->db->query("SELECT PURCHASE_REF_NO FROM LZ_SINGLE_ENTRY WHERE ROWNUM = 1 ORDER BY ID DESC");
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


    	// $qry_sef = "INSERT INTO LZ_SINGLE_ENTRY VALUES($loading_no $comma '$purch_ref' $comma $suplier_desc $comma '$remarks' $comma $purchase_date $comma '$serial_no' $comma '$manufacturer' $comma $list_date $comma '$lot_ref' $comma '$upc' $comma '$sku' $comma $price $comma $cost_price $comma '$part_no' $comma '$title' $comma '$main_category' $comma '$sub_cat' $comma '$category' $comma '$origin' $comma '$condition' $comma $avail_qty $comma $ounces $comma '$ebay_item_id' $comma '$user_name' $comma '$po_mt_ref_no' $comma '$job_no' $comma $category_id $comma NULL $comma NULL)";
    	// 
    	$qry_sef = "INSERT INTO LZ_SINGLE_ENTRY (ID, PURCHASE_REF_NO, SUPPLIER_ID, REMARKS, PURCHASE_DATE, SERIAL_NO, ITEM_MT_MANUFACTURE, LIST_DATE, PO_DETAIL_LOT_REF, ITEM_MT_UPC, ITEM_MT_BBY_SKU, PRICE, PO_DETAIL_RETIAL_PRICE, ITEM_MT_MFG_PART_NO, ITEM_MT_DESC, MAIN_CATAGORY_SEG1, SUB_CATAGORY_SEG2, BRAND_SEG3, ORIGIN_SEG4, CONDITIONS_SEG5, AVAILABLE_QTY, WEIGHT_KG, EBAY_ITEM_ID, LISTER, PO_MT_REF_NO, JOB_NO, CATEGORY_ID, OLD_BARCODE, POS_ONLY) VALUES($loading_no $comma '$purch_ref' $comma $suplier_desc $comma '$remarks' $comma $purchase_date $comma '$serial_no' $comma '$manufacturer' $comma $list_date $comma '$lot_ref' $comma '$upc' $comma '$sku' $comma $price $comma $cost_price $comma '$part_no' $comma '$title' $comma '$main_category' $comma '$sub_cat' $comma '$category' $comma '$origin' $comma '$condition' $comma $avail_qty $comma $ounces $comma '$ebay_item_id' $comma '$user_name' $comma '$po_mt_ref_no' $comma '$job_no' $comma $category_id $comma NULL $comma $pos_only)";
    	//print_r($qry_sef);exit;
        $this->db->query($qry_sef);
        

        $qry_id = "select m.lz_manifest_id,m.single_entry_id from lz_manifest_mt m where m.single_entry_id=(select max(t.id) from lz_single_entry t)";
    	//print_r($qry_sef);exit;
        $query=$this->db->query($qry_id);
        $rs = $query->result_array();
	    // $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];

	    return $rs;


		 }
		 public function skip_test($lz_manifest_id){
		 	$skip_test = $this->input->post('skip_test');
		 	$condition = $this->input->post('default_condition');

			if($skip_test == 'Yes'){
			//var_dump($skip_test);
	            if(@$condition == 'Used'){
	              @$condition = 3000;
	            }elseif(@$condition == 'New'){
	              @$condition = 1000; 
	            }elseif(@$condition == 'New other'){
	              @$condition = 1500; 
	            }elseif(@$condition == 'Manufacturer Refurbished'){
	                @$condition = 2000;
	            }elseif(@$condition == 'Seller Refurbished'){
	              @$condition = 2500; 
	            }elseif(@$condition == 'For Parts or Not Working'){
	              @$condition = 7000; 
	            }

	    		$cond_qry = "UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = $condition WHERE  B.LZ_MANIFEST_ID = $lz_manifest_id";
	    		//var_dump($cond_qry);exit;
				$this->db->query($cond_qry);        	
	        }
		 }
		 public function updateRecord() {
		  $pos_only = $this->input->post('pos_only');
		  $loading_no = $this->input->post('loading_no');
		  $purch_ref = $this->input->post('purch_ref');
		  $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
          $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 
		  $suplier_desc = $this->input->post('suplier_desc');
		  $suplier_desc = trim(str_replace("  ", ' ', $suplier_desc));
          $suplier_desc = trim(str_replace(array("'"), "''", $suplier_desc));
		  $remarks = $this->input->post('remarks');
		  $remarks = trim(str_replace("  ", ' ', $remarks));
          $remarks = trim(str_replace(array("'"), "''", $remarks));
          if(empty($remarks)){
          	$remarks = "";
          }
		  $purchase_date = $this->input->post('purchase_date');
		  $date=date_create($purchase_date);//change date format from 07-Dec-2016 to 12/07/2016
		  $date= date_format($date,"m/d/Y");
		  $purchase_date= "TO_DATE('".$date."', 'MM/DD/YYYY')";
		  $serial_no = $this->input->post('serial_no');
		  $serial_no = trim(str_replace("  ", ' ', $serial_no));
          $serial_no = trim(str_replace(array("'"), "''", $serial_no));
		//   $manufacturer = $this->input->post('manufacturer');
		//   $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
        //   $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));
          $list_date = "NULL";
		  $lot_ref = $this->input->post('lot_ref');
		  $lot_ref = trim(str_replace("  ", ' ', $lot_ref));
          $lot_ref = trim(str_replace(array("'"), "''", $lot_ref));
		//   $upc = $this->input->post('upc');
		//   $upc = trim(str_replace("  ", ' ', $upc));
        //   $upc = trim(str_replace(array("'"), "''", $upc));
		  $sku = $this->input->post('sku');
		  $sku = trim(str_replace("  ", ' ', $sku));
          $sku = trim(str_replace(array("'"), "''", $sku));
		  $price = $this->input->post('active_price');
          if(empty($price)){
          	$price = "NULL";
          }		  
		  $cost_price = $this->input->post('cost_price');
		//   $part_no = $this->input->post('part_no');
		//   $part_no = trim(str_replace("  ", ' ', $part_no));
        //   $part_no = trim(str_replace(array("'"), "''", $part_no));
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
          if(empty($origin)){
          	$origin = "";
          }
		//   $condition = $this->input->post('default_condition');
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }
		  $ebay_item_id = '';
		  $user_name = $this->input->post('user_name');
		  $user_name = trim(str_replace("  ", ' ', $user_name));
          $user_name = trim(str_replace(array("'"), "''", $user_name));
		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));
		  $job_no = $this->input->post('job_no');
		  $category_id = $this->input->post('category_id');
		  //$comma = ',';
		  $query = $this->db->query("UPDATE LZ_SINGLE_ENTRY SET ID = '$loading_no', PURCHASE_REF_NO = '$purch_ref', SUPPLIER_ID  = '$suplier_desc', REMARKS  = '$remarks', PURCHASE_DATE = $purchase_date, SERIAL_NO = '$serial_no', LIST_DATE = $list_date, PO_DETAIL_LOT_REF  = '$lot_ref', ITEM_MT_BBY_SKU  = '$sku', PRICE  = $price, PO_DETAIL_RETIAL_PRICE = '$cost_price',ITEM_MT_DESC = '$title', MAIN_CATAGORY_SEG1 = '$main_category', SUB_CATAGORY_SEG2  = '$sub_cat', BRAND_SEG3= '$category', ORIGIN_SEG4  = '$origin', AVAILABLE_QTY = '$avail_qty', WEIGHT_KG = $ounces, EBAY_ITEM_ID  = '$ebay_item_id', LISTER  = '$user_name', PO_MT_REF_NO  = '$po_mt_ref_no', JOB_NO  = '$job_no', CATEGORY_ID = '$category_id', POS_ONLY = $pos_only WHERE ID = '$loading_no'");
			
		 }
		 public function get_supplier_id(){
		 	$query = $this->db->query("select supplier_id, company_name from supplier_mt");
		 	return $query->result_array();

		 }
		 public function singlentry_view_all($id,$se_radio){
		 	$barcode_arr = [];
			$seed_id_arr = [];
			$date_qry = null;
			$order_by = null;
		 	if(empty($id) && empty($se_radio)){
		 		//$query = "SELECT S.OLD_BARCODE ,S.ID, S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, UPPER(S.CONDITIONS_SEG5) CONDITIONS_SEG5, S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M,VIEW_LZ_LISTING_REVISED V WHERE S.ID = M.SINGLE_ENTRY_ID AND V.SINGLE_ENTRY_ID = S.ID AND V.EBAY_ITEM_ID IS NULL AND upper(S.CONDITIONS_SEG5) not in ('N/A','OTHER','NEW WITHOUT TAGS')";

		 		//$group =" GROUP BY S.OLD_BARCODE,S.ID,  S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, UPPER(S.CONDITIONS_SEG5), S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE";
		 		
		 		$query = "SELECT S.*,MANF.EBAY_ITEM_ID,MANF.LZ_MANIFEST_ID,MANF.ITEM_ID,MANF.CONDITION_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, (SELECT DISTINCT B.LZ_MANIFEST_ID,B.EBAY_ITEM_ID,B.ITEM_ID,B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL ) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID";
		 		$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
				$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 		$se_radio = 'Not_Listed'; 
		 		$this->session->set_userdata('se_radio', $se_radio);
			 // $barcode_arr = [];
			 // $seed_id_arr = [];		 		
		 	}elseif(empty($id) && !empty($se_radio)){
		 		if($se_radio == 'Listed'){
		 			//$query = "SELECT S.OLD_BARCODE ,S.ID, S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, UPPER(S.CONDITIONS_SEG5) CONDITIONS_SEG5, S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M,VIEW_LZ_LISTING_REVISED V WHERE S.ID = M.SINGLE_ENTRY_ID AND V.SINGLE_ENTRY_ID = S.ID AND upper(S.CONDITIONS_SEG5) not in ('N/A','OTHER','NEW WITHOUT TAGS')";
		 			//$group =" GROUP BY S.OLD_BARCODE ,S.ID,  S.LISTER,S.REMARKS,S.PURCHASE_DATE,S.PURCHASE_REF_NO,S.ITEM_MT_MANUFACTURE, S.ITEM_MT_UPC, S.ITEM_MT_BBY_SKU, S.PRICE, S.PO_DETAIL_RETIAL_PRICE, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_DESC, S.MAIN_CATAGORY_SEG1, S.SUB_CATAGORY_SEG2, S.BRAND_SEG3, S.ORIGIN_SEG4, S.CONDITIONS_SEG5, S.AVAILABLE_QTY, S.CATEGORY_ID, S.WEIGHT_KG,V.ITEM_ID,V.EBAY_ITEM_ID, M.LZ_MANIFEST_ID, M.GRN_ID,V.LIST_QTY,V.IT_BARCODE";
		 			$query = "SELECT S.*,MANF.EBAY_ITEM_ID,MANF.LZ_MANIFEST_ID,MANF.ITEM_ID,MANF.CONDITION_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, (SELECT DISTINCT B.LZ_MANIFEST_ID,B.EBAY_ITEM_ID,B.ITEM_ID,B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NOT NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID";
		 			$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
					$to = date('m/d/Y');
					$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
					$order_by =" ORDER BY S.PURCHASE_DATE DESC"; 
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}elseif ($se_radio == 'Not_Listed') {
		 			$query = "SELECT S.*,MANF.EBAY_ITEM_ID,MANF.LZ_MANIFEST_ID,MANF.ITEM_ID,MANF.CONDITION_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, (SELECT DISTINCT B.LZ_MANIFEST_ID,B.EBAY_ITEM_ID,B.ITEM_ID,B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID";
		 			$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
					$to = date('m/d/Y');
					$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
					$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 			//$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE S.ID = M.SINGLE_ENTRY_ID AND  M.GRN_ID IS NULL";
		 			//$group =" ";
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}elseif($se_radio == 'All') {
		 			//$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE S.ID = M.SINGLE_ENTRY_ID";
		 			$query = "SELECT S.*,MANF.EBAY_ITEM_ID,MANF.LZ_MANIFEST_ID,MANF.ITEM_ID,MANF.CONDITION_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, (SELECT DISTINCT B.LZ_MANIFEST_ID,B.EBAY_ITEM_ID,B.ITEM_ID,B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) ) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID";
		 			$order_by =" ORDER BY S.PURCHASE_DATE DESC";
		 			//$group =" ";
		 			$this->session->set_userdata('se_radio', $se_radio);
		 		}	
		 	}elseif(!empty($id)){
		 		$query = "SELECT S.*, M.LZ_MANIFEST_ID, M.POSTED, M.GRN_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE S.ID = M.SINGLE_ENTRY_ID AND S.ID = $id"; 
		 		$group =" ";
				$query = $this->db->query($query) ;
		 		$query = $query->result_array();
		 		return array('query'=>$query, 'barcode_qry'=>$barcode_arr, 'seed_id_qry'=>$seed_id_arr);
		 		

		 	}else{
			 	$from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
				$to = date('m/d/Y');
				$date_qry = "AND S.PURCHASE_DATE BETWEEN TO_DATE('$from','MM/DD/YY') AND TO_DATE('$to ','MM/DD/YY')";
	
		} //last else close

			//$query = $this->db->query($query. " " . $date_qry . $group . $order_by);
			$query = $this->db->query($query. " " . $date_qry . $order_by);
		 	$query = $query->result_array();

		foreach($query as $cond){
			//var_dump($query);exit;
			if(!empty($cond['CONDITION_ID'])){

                    if(!is_numeric(@$cond['CONDITION_ID'])){
						$condition_id = @$cond['CONDITION_ID'];
                        if(@$condition_id == 'USED'){
                          @$condition_id = 3000;
                        }elseif(@$condition_id == 'NEW'){
                          @$condition_id = 1000; 
                        }elseif(@$condition_id == 'NEW OTHER' || @$condition_id == 'NEW OTHER (SEE DETAILS)'){
                          @$condition_id = 1500; 
                        }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
                            @$condition_id = 2000;
                        }elseif(@$condition_id == 'SELLER REFURBISHED'){
                          @$condition_id = 2500; 
                        }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING' || @$condition_id == 'FOR PARTS'){
                          @$condition_id = 7000; 
                        }
                    }else{
                    	$condition_id = @$cond['CONDITION_ID'];
                    }
                        

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
		 		
		 	}elseif(!empty($cond['CONDITIONS_SEG5'])){
		 		$condition_id = strtoupper($cond['CONDITIONS_SEG5']);
	 				if(@$condition_id == 'USED'){
                      @$condition_id = 3000;
                    }elseif(@$condition_id == 'NEW'){
                      @$condition_id = 1000; 
                    }elseif(@$condition_id == 'NEW OTHER' || @$condition_id == 'NEW OTHER (SEE DETAILS)'){
                      @$condition_id = 1500; 
                    }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
                        @$condition_id = 2000;
                    }elseif(@$condition_id == 'SELLER REFURBISHED'){
                      @$condition_id = 2500; 
                    }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING' || @$condition_id == 'FOR PARTS'){
                      @$condition_id = 7000; 
                    }else{
                    	@$condition_id = 3000;
                    }
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
		 	$seed_id_qry = $this->db->query("SELECT SEED_ID FROM LZ_ITEM_SEED  WHERE ITEM_ID = ".$cond['ITEM_ID']." AND LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND DEFAULT_COND = ".$condition_id);
			$seed_id_qry = $seed_id_qry->result_array();
			array_push($seed_id_arr, @$seed_id_qry[0]['SEED_ID']);			

		} //END FOREACH		
		//var_dump($cond['ITEM_ID'],$cond['LZ_MANIFEST_ID'],$condition_id);exit;
		//var_dump($seed_id_arr);exit;
		
		return array('query'=>$query, 'barcode_qry'=>$barcode_arr, 'seed_id_qry'=>$seed_id_arr);
		 					 

		 }		 
		 public function update() {

		  $loading_no = $this->input->post('loading_no');
		  $purch_ref = $this->input->post('purch_ref');
		  $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
          $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 
		  $suplier_desc = $this->input->post('suplier_desc');
		  $suplier_desc = trim(str_replace("  ", ' ', $suplier_desc));
          $suplier_desc = trim(str_replace(array("'"), "''", $suplier_desc));
		  $remarks = $this->input->post('remarks');
		  $remarks = trim(str_replace("  ", ' ', $remarks));
          $remarks = trim(str_replace(array("'"), "''", $remarks));
          if(empty($remarks)){
          	$remarks = "";
          }
		  $purchase_date = $this->input->post('purchase_date');
		  $date=date_create($purchase_date);//change date format from 07-Dec-2016 to 12/07/2016
		  $date= date_format($date,"m/d/Y");
		  $purchase_date= "TO_DATE('".$date."', 'MM/DD/YYYY')";
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
          if(empty($origin)){
          	$origin = "";
          }
		  $condition = $this->input->post('default_condition');
		  $avail_qty = $this->input->post('avail_qty');
		  $ounces = $this->input->post('ounces');
		  if(empty($ounces)){
          	$ounces = "NULL";
          }
		  $ebay_item_id = '';
		  $user_name = $this->input->post('user_name');
		  $user_name = trim(str_replace("  ", ' ', $user_name));
          $user_name = trim(str_replace(array("'"), "''", $user_name));
		  $po_mt_ref_no = '';
		  $po_mt_ref_no = trim(str_replace("  ", ' ', $po_mt_ref_no));
          $po_mt_ref_no = trim(str_replace(array("'"), "''", $po_mt_ref_no));
		  $job_no = $this->input->post('job_no');
		  $category_id = $this->input->post('category_id');
		  //$comma = ',';
		  $query = $this->db->query("UPDATE LZ_SINGLE_ENTRY SET ID = '$loading_no', PURCHASE_REF_NO = '$purch_ref', SUPPLIER_ID  = '$suplier_desc', REMARKS  = '$remarks', PURCHASE_DATE = $purchase_date, SERIAL_NO = '$serial_no', ITEM_MT_MANUFACTURE = '$manufacturer', LIST_DATE = $list_date, PO_DETAIL_LOT_REF  = '$lot_ref', ITEM_MT_UPC  = '$upc', ITEM_MT_BBY_SKU  = '$sku', PRICE  = $price, PO_DETAIL_RETIAL_PRICE = '$cost_price', ITEM_MT_MFG_PART_NO  = '$part_no',ITEM_MT_DESC = '$title', MAIN_CATAGORY_SEG1 = '$main_category', SUB_CATAGORY_SEG2  = '$sub_cat', BRAND_SEG3= '$category', ORIGIN_SEG4  = '$origin', CONDITIONS_SEG5  = '$condition', AVAILABLE_QTY = '$avail_qty', WEIGHT_KG = $ounces, EBAY_ITEM_ID  = '$ebay_item_id', LISTER  = '$user_name', PO_MT_REF_NO  = '$po_mt_ref_no', JOB_NO  = '$job_no',CATEGORY_ID = '$category_id' WHERE ID = '$loading_no'");
			$qry_id = "select m.lz_manifest_id,m.single_entry_id from lz_manifest_mt m where m.single_entry_id=$loading_no";
	    	$query=$this->db->query($qry_id);
	        $rs = $query->result_array();
		    
		    return $rs;
		 }

 		public function get_data($upc, $part_no){
	 		if(!empty($upc)){
		 		$query = $this->db->query("SELECT * FROM LZ_MANIFEST_DET DT WHERE DT.ITEM_MT_UPC ='$upc' ORDER BY DT.LZ_MANIFEST_ID DESC");
		 		//$data = $query->result();
				$manifest_id = $query->result_array();
		 		//var_dump($purch_ref);exit;
		 		$lz_manifest_id = $manifest_id[0]['LZ_MANIFEST_ID'];
		 		$weight_qry = $this->db->query("SELECT LS.WEIGHT_KG, LS.ITEM_MT_DESC FROM LZ_SINGLE_ENTRY LS WHERE LS.ID = (select m.single_entry_id from lz_manifest_mt m where m.lz_manifest_id = $lz_manifest_id)");
		 		$weight_qry = $weight_qry->result_array();	
		 	}elseif(!empty($part_no)){
		 		$query = $this->db->query("SELECT * FROM LZ_MANIFEST_DET DT WHERE DT.ITEM_MT_MFG_PART_NO ='$part_no' ORDER BY DT.LZ_MANIFEST_ID DESC");
		 		//$data = $query->result();
		 		$manifest_id = $query->result_array();
		 		//var_dump($purch_ref);exit;
		 		$lz_manifest_id = $manifest_id[0]['LZ_MANIFEST_ID'];
		 		$weight_qry = $this->db->query("SELECT LS.WEIGHT_KG, LS.ITEM_MT_DESC FROM LZ_SINGLE_ENTRY LS WHERE LS.ID = (select m.single_entry_id from lz_manifest_mt m where m.lz_manifest_id = $lz_manifest_id)");
		 		$weight_qry = $weight_qry->result_array();		 		
		 	} 
				
	            return array('data'=>$manifest_id, 'weight_qry'=>$weight_qry);


		 }	
    public function single_entry_print($single_entry_id){
        //======================== Print Sticker tab Start =============================//

        //$print_qry = "select t.* from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.STICKER_PRINT = 0";
        // $print_qry = "SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, V.ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.ITEM_ID, B.UNIT_NO"; 
        $print_qry = "SELECT D.PRICE, D.ITEM_MT_DESC, B.BARCODE_NO FROM LZ_MANIFEST_DET D, LZ_MANIFEST_MT M, LZ_BARCODE_MT B WHERE D.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = $single_entry_id"; //print_r($print_qry);exit;
        $print_qry =$this->db->query($print_qry);

        return $print_qry->result_array();

         
        //======================== Print Sticker tab End =============================//    	
    }
    public function get_old_barcode($lz_manifest_id,$single_entry_id){
	    
	    $old_barcode = $this->db->query("SELECT M.BARCODE_NO FROM LZ_BARCODE_MT M WHERE M.LZ_MANIFEST_ID = $lz_manifest_id");
	    $old_barcode = $old_barcode->result_array();
	    // $str = serialize($old_barcode);
    	// $strenc = urlencode($str);
    	$barcode = '';
	    	foreach ($old_barcode as $value) {
	    		$barcode .= $value['BARCODE_NO'].'-';
	    	}
	    $query = $this->db->query("UPDATE LZ_SINGLE_ENTRY E SET E.OLD_BARCODE = '$barcode' WHERE E.ID = $single_entry_id");     
	    //return $print_qry->result_array();
	  }
	public function manifest_sticker_print($item_code,$manifest_id,$barcode){
	    //$print_qry = $this->db->query("SELECT D.LAPTOP_ITEM_CODE || '+' || LPAD(T.LOADING_NO, 4, 0) ITEM_CODE, 'R#' || T.PURCH_REF_NO LOT_NO, '~'  || substr(D.ITEM_MT_DESC,1,80) ITEM_DESC, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.ITEM_MT_DESC = D.ITEM_MT_DESC AND S.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:'  || D.ITEM_MT_BBY_SKU SKU, '*+' || REPLACE(D.LAPTOP_ITEM_CODE, '-', '') || LPAD(T.LOADING_NO, 4, 0) || '*' BAR_CODE,D.PO_DETAIL_LOT_REF LOT_ID FROM LZ_MANIFEST_MT T, LZ_MANIFEST_DET D WHERE T.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID and D.LAPTOP_ZONE_ID = $laptop_zone_id");
	    $print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE , '~' || SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'R#' || T.PURCH_REF_NO LOT_NO, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE=I.ITEM_CODE AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM =1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:' || I.ITEM_MT_BBY_SKU SKU FROM LZ_MANIFEST_MT T, LZ_BARCODE_MT B, ITEMS_MT I WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE='$item_code' AND B.LZ_MANIFEST_ID = $manifest_id AND B.BARCODE_NO = $barcode");
	    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");     
	    //var_dump($print_qry);exit;
	    return $print_qry->result_array();
	  }
	  public function UnpostItem(){
          date_default_timezone_set("America/Chicago");
          $del_date = date("Y-m-d H:i:s");
          $del_date = "TO_DATE('".$del_date."', 'YYYY-MM-DD HH24:MI:SS')";
          $deleted_by = $this->session->userdata('user_id');     
          //$user_name = $this->input->post('user_name');
          //$remarks = $this->input->post('remarks');
          $remarks = '';
          $purch_ref = $this->input->post('purch_ref');
		  $manf_qry = $this->db->query("SELECT M.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT M WHERE M.PURCH_REF_NO = '$purch_ref'");
          $manf_qry = $manf_qry->result_array();
          $manifest_id = $manf_qry[0]['LZ_MANIFEST_ID'];
          $comma = ",";

          foreach($barcode as $barcode_no){

            $item_alloc = $this->db->query("select * from lz_listing_alloc a where a.seed_id = (select s.seed_id from lz_barcode_mt b, lz_item_seed s where b.item_id = s.item_id and b.lz_manifest_id = s.lz_manifest_id and b.condition_id = s.default_cond and b.barcode_no = $barcode_no)");

            if($item_alloc->num_rows() > 0){

             return array('item_alloc'=>$item_alloc);

            }else{

              $hold_barcode_qry = $this->db->query("SELECT * FROM LZ_BARCODE_HOLD_LOG WHERE BARCODE_NO = $barcode_no AND ACTION = 1");
                if($hold_barcode_qry->num_rows() == 0){                        

                $query = $this->db->query("SELECT get_single_primary_key('LZ_DELETION_LOG','LOG_ID') LOG_ID FROM DUAL");
                $rs = $query->result_array();
                $log_id = $rs[0]['LOG_ID'];
                $query = $this->db->query("SELECT B.ITEM_ID,B.LZ_MANIFEST_ID,B.CONDITION_ID, I.ITEM_DESC FROM LZ_BARCODE_MT B, ITEMS_MT I WHERE B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO = $barcode_no");
                $rs = $query->result_array();
                $item_id = $rs[0]['ITEM_ID'];
                $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
                $condition_id = $rs[0]['CONDITION_ID'];
                $item_title = $rs[0]['ITEM_DESC'];

                  //echo $id;
                  $query = $this->db->query("INSERT INTO lz_deletion_log VALUES($log_id $comma $barcode_no $comma $item_id $comma $lz_manifest_id $comma $condition_id $comma $deleted_by $comma $del_date $comma '$item_title' $comma '$remarks')");
                  
                  $unpost_barcode = "call Pro_Unpost_barcode($barcode_no)";
                  $unpost_barcode = $this->db->query($unpost_barcode);

              }else{ //holded barcode if else
                  //echo "Item is holded. Please un-hold item first.";
                  return array('item_holded'=>$barcode_no);
              } 

            }

                  
          }//foreach end
          if($unpost_barcode){
            //echo "Item Deletion process Succsessfully executed.";
            return "deleted";
          }
         
    }    


}

 ?>