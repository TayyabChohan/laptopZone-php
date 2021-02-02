<?php  

	class M_Technician extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function lists(){
		// $qry = $this->db->query("SELECT DISTINCT C.CATEGORY_ID,C.CATEGORY_NAME,get_active_count(C.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CATEGORY C");
		$categories = $this->db->query("SELECT DISTINCT D.CATEGORY_ID, BD.CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD WHERE  D.CATEGORY_ID = BD.CATEGORY_ID")->result_array();

		$mpns = $this->db->query("SELECT MT.CATALOGUE_MT_ID,MT.MPN FROM LZ_CATALOGUE_MT MT,LZ_BD_CAT_GROUP_DET D  WHERE MT.CATEGORY_ID = D.CATEGORY_ID AND D.LZ_BD_GROUP_ID = 2")->result_array();
		$conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
		return array("categories"=>$categories, "mpns"=>$mpns, "conditions"=>$conditions);
	}
	public function tech_data(){

		$barcode_no = $this->input->post('lz_bar_code');
		$this->session->set_userdata(['ctc_kit_barcode'=>$barcode_no]);
		//var_dump($barcode_no); exit;
		$load_dekit_check = $this->db->query("SELECT  B.ITEM_ADJ_DET_ID_FOR_OUT  FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode_no AND B.ITEM_ADJ_DET_ID_FOR_OUT IS  NULL");
		if ($load_dekit_check->num_rows() > 0) { // BARCODE IS ALREADY DEKIT
			//echo "dsfsff"; exit;
		$qry = $this->db->query("SELECT B.ITEM_ID, B.LZ_MANIFEST_ID, B.ITEM_ADJ_DET_ID_FOR_OUT, S.ID, S.PURCHASE_DATE, S.ITEM_MT_DESC, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_UPC, S.CONDITIONS_SEG5, S.PO_DETAIL_RETIAL_PRICE, S.AVAILABLE_QTY, C.CATALOGUE_MT_ID, C.CATEGORY_ID, (SELECT T.LZ_BD_CATA_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_SINGLE_ENTRY_ID = S.ID) LZ_BD_CATA_ID , (SELECT T.TRACKING_NO FROM LZ_BD_TRACKING_NO T WHERE T.LZ_SINGLE_ENTRY_ID = S.ID) TRACKING_NO FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, LZ_SINGLE_ENTRY S,LZ_MANIFEST_DET  DD,LZ_CATALOGUE_MT C WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND M.LZ_MANIFEST_ID = DD.LZ_MANIFEST_ID AND UPPER(DD.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND DD.E_BAY_CATA_ID_SEG6 = C.CATEGORY_ID(+) AND B.BARCODE_NO = $barcode_no");
			if ($qry->num_rows() > 0) {
			 	$tec_qry = $qry->result_array();
				$ctc_kit_barcode 			= $barcode_no;
				$ctc_kit_desc 				= $tec_qry[0]['ITEM_MT_DESC'];
				$ctc_kit_mpn 				= $tec_qry[0]['ITEM_MT_MFG_PART_NO'];
				$ctc_kit_upc 				= $tec_qry[0]['ITEM_MT_UPC'];
				$ctc_kit_cost_price		 	= $tec_qry[0]['PO_DETAIL_RETIAL_PRICE'];
				$ctc_kit_qty 				= $tec_qry[0]['AVAILABLE_QTY'];
				$ctc_kit_cond 				= $tec_qry[0]['CONDITIONS_SEG5'];
				$ctc_kit_purchase_date 		= $tec_qry[0]['PURCHASE_DATE'];
				$lz_single_entry_id 		= $tec_qry[0]['ID'];
				$lz_manifest_id 			= $tec_qry[0]['LZ_MANIFEST_ID'];
				$item_id 					= $tec_qry[0]['ITEM_ID'];
				$catalog_id 				= $tec_qry[0]['CATALOGUE_MT_ID'];
				$category_id 				= $tec_qry[0]['CATEGORY_ID'];
				$lz_bd_cata_id 				= $tec_qry[0]['LZ_BD_CATA_ID'];
				$lz_track_no				= $tec_qry[0]['TRACKING_NO'];
				$flag = 11;
			 } 
			
		if ($qry->num_rows() == 0) {
			$get_item = $this->db->query("SELECT B.ITEM_ID, B.LZ_MANIFEST_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode_no")->result_array();
			$item_id 		= $get_item[0]['ITEM_ID'];
			$manifest_id 	= $get_item[0]['LZ_MANIFEST_ID'];

			$get_item_code 	= $this->db->query("SELECT MT.ITEM_CODE FROM ITEMS_MT MT WHERE MT.ITEM_ID = $item_id")->result_array();
			
			$item_code 		= $get_item_code[0]['ITEM_CODE'];

			$qry = $this->db->query("SELECT C.CATALOGUE_MT_ID, C.MPN, C.CATEGORY_ID, M.PURCHASE_DATE, D.ITEM_MT_MANUFACTURE, D.ITEM_MT_MFG_PART_NO, D.ITEM_MT_DESC, D.ITEM_MT_UPC, D.CONDITIONS_SEG5, D.AVAILABLE_QTY, D.PO_DETAIL_RETIAL_PRICE, d.LZ_MANIFEST_ID  FROM LZ_CATALOGUE_MT C, LZ_MANIFEST_MT M, LZ_MANIFEST_DET D WHERE M.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND UPPER(C.MPN) = UPPER(D.ITEM_MT_MFG_PART_NO) AND D.LZ_MANIFEST_ID = $manifest_id AND D.LAPTOP_ITEM_CODE = '$item_code'");
				$tec_qry = $qry->result_array();

				$ctc_kit_barcode 			= $barcode_no;
				$ctc_kit_desc 				= $tec_qry[0]['ITEM_MT_DESC'];
				$ctc_kit_mpn 				= $tec_qry[0]['ITEM_MT_MFG_PART_NO'];
				$ctc_kit_upc 				= $tec_qry[0]['ITEM_MT_UPC'];
				$ctc_kit_cost_price		 	= $tec_qry[0]['PO_DETAIL_RETIAL_PRICE'];
				$ctc_kit_qty 				= $tec_qry[0]['AVAILABLE_QTY'];
				$ctc_kit_cond 				= $tec_qry[0]['CONDITIONS_SEG5'];
				$ctc_kit_purchase_date 		= $tec_qry[0]['PURCHASE_DATE'];
				$lz_single_entry_id 		= '';
				$lz_manifest_id 			= $tec_qry[0]['LZ_MANIFEST_ID'];
				$item_id 					= $item_id;
				$catalog_id 				= $tec_qry[0]['CATALOGUE_MT_ID'];
				$category_id 				= $tec_qry[0]['CATEGORY_ID'];
				$lz_bd_cata_id 				= '';
				$lz_track_no				= '';

				$flag = 12;
			 }
		
		// var_dump($tec_qry);exit;
		//var_dump($ctc_kit_desc, $ctc_kit_mpn, $ctc_kit_upc, $ctc_kit_cost_price, $ctc_kit_qty, $ctc_kit_cond, $ctc_kit_purchase_date); exit;

		$kit_data = array(
			"ctc_kit_barcode"=>$barcode_no,
			"ctc_kit_desc"=>$ctc_kit_desc,
			"ctc_kit_mpn"=>$ctc_kit_mpn,
			"ctc_kit_upc"=>$ctc_kit_upc,
			"ctc_kit_cost_price"=>$ctc_kit_cost_price,
			"ctc_kit_qty"=>$ctc_kit_qty,
			"ctc_kit_cond"=>$ctc_kit_cond, 
			"ctc_kit_purchase_date"=>$ctc_kit_purchase_date,
			"lz_single_entry_id"=>$lz_single_entry_id,
			"item_id"=>$item_id,
			"lz_manifest_id"=>$lz_manifest_id,
			"catalog_id"=>$catalog_id,
			"category_id"=>$category_id,
			"lz_bd_cata_id"=>$lz_bd_cata_id,
			"lz_track_no" => $lz_track_no
		);

		$this->session->set_userdata($kit_data);
		// echo "<pre>";
		// print_r($kit_data);
		// exit;
		return array("barcode_detail" =>$tec_qry, "res"=>true, "flag"=>$flag);
		}else {
			//echo "no"; exit;
			$qry = $this->db->query("SELECT S.ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M , LZ_SINGLE_ENTRY S WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND B.BARCODE_NO = $barcode_no"); 
			if ($qry->num_rows() > 0) {
				$tec_qry = $qry->result_array();
				$lz_single_entry_id 		= $tec_qry[0]['ID'];

				$estimate_data ="SELECT   D.ITEM_MANUFACTURER, C.MPN, D.QTY, D.EST_SELL_PRICE, D.EBAY_FEE, D.PAYPAL_FEE, D.SHIPPING_FEE, D.LOCATION_ID, D.TECH_COND_DESC, O.OBJECT_NAME, C.MPN_DESCRIPTION FROM LZ_BD_ESTIMATE_MT  M, LZ_BD_ESTIMATE_DET D, LZ_BD_TRACKING_NO T, LZ_CATALOGUE_MT  C, LZ_BD_MPN_KIT_MT  MPN, LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID AND D.LZ_BD_ESTIMATE_ID = M.LZ_BD_ESTIMATE_ID AND D.MPN_KIT_MT_ID = MPN.MPN_KIT_MT_ID AND C.CATALOGUE_MT_ID = MPN.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND T.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id";

			 	$estimate_detail = $this->db->query($estimate_data)->result_array();
			}else {
				$estimate_detail = [];
			}
			 $qry =$this->db->query("SELECT B.ITEM_ID, B.LZ_MANIFEST_ID, B.ITEM_ADJ_DET_ID_FOR_OUT, S.ID, S.PURCHASE_DATE, S.ITEM_MT_DESC, S.ITEM_MT_MFG_PART_NO, S.ITEM_MT_UPC, S.CONDITIONS_SEG5, S.PO_DETAIL_RETIAL_PRICE, S.AVAILABLE_QTY, C.CATALOGUE_MT_ID, C.CATEGORY_ID, (select t.lz_bd_cata_id from lz_bd_tracking_no t where t.lz_single_entry_id = s.id) LZ_BD_CATA_ID,   (select t.tracking_no from lz_bd_tracking_no t where t.lz_single_entry_id = s.id) TRACKING_NO FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, LZ_SINGLE_ENTRY S,LZ_MANIFEST_DET  DD,LZ_CATALOGUE_MT C WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND M.SINGLE_ENTRY_ID = S.ID AND M.LZ_MANIFEST_ID = DD.LZ_MANIFEST_ID AND UPPER(DD.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND DD.E_BAY_CATA_ID_SEG6 = C.CATEGORY_ID(+) AND B.BARCODE_NO = $barcode_no");

			 if ($qry->num_rows() > 0) {
			 	$tec_qry =$qry->result_array();

					$ctc_kit_barcode 			= $barcode_no;
					$ctc_kit_desc 				= $tec_qry[0]['ITEM_MT_DESC'];
					$ctc_kit_mpn 				= $tec_qry[0]['ITEM_MT_MFG_PART_NO'];
					$ctc_kit_upc 				= $tec_qry[0]['ITEM_MT_UPC'];
					$ctc_kit_cost_price		 	= $tec_qry[0]['PO_DETAIL_RETIAL_PRICE'];
					$ctc_kit_qty 				= $tec_qry[0]['AVAILABLE_QTY'];
					$ctc_kit_cond 				= $tec_qry[0]['CONDITIONS_SEG5'];
					$ctc_kit_purchase_date 		= $tec_qry[0]['PURCHASE_DATE'];
					$lz_single_entry_id 		= $tec_qry[0]['ID'];
					$lz_manifest_id 			= $tec_qry[0]['LZ_MANIFEST_ID'];
					$item_id 					= $tec_qry[0]['ITEM_ID'];
					$catalog_id 				= $tec_qry[0]['CATALOGUE_MT_ID'];
					$category_id 				= $tec_qry[0]['CATEGORY_ID'];
					$lz_bd_cata_id 				= $tec_qry[0]['LZ_BD_CATA_ID'];
					$lz_track_no				= $tec_qry[0]['TRACKING_NO'];
			 }elseif ($qry->num_rows() == 0) {
						$get_item = $this->db->query("SELECT B.ITEM_ID, B.LZ_MANIFEST_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode_no")->result_array();
						$item_id 		= $get_item[0]['ITEM_ID'];
						$manifest_id 	= $get_item[0]['LZ_MANIFEST_ID'];

						$get_item_code 	= $this->db->query("SELECT MT.ITEM_CODE FROM ITEMS_MT MT WHERE MT.ITEM_ID = $item_id")->result_array();
						
						$item_code 		= $get_item_code[0]['ITEM_CODE'];

						$qry = $this->db->query("SELECT C.CATALOGUE_MT_ID, C.MPN, C.CATEGORY_ID, M.PURCHASE_DATE, D.ITEM_MT_MANUFACTURE, D.ITEM_MT_MFG_PART_NO, D.ITEM_MT_DESC, D.ITEM_MT_UPC, D.CONDITIONS_SEG5, D.AVAILABLE_QTY, D.PO_DETAIL_RETIAL_PRICE, d.LZ_MANIFEST_ID  FROM LZ_CATALOGUE_MT C, LZ_MANIFEST_MT M, LZ_MANIFEST_DET D WHERE M.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND UPPER(C.MPN) = UPPER(D.ITEM_MT_MFG_PART_NO) AND D.LZ_MANIFEST_ID = $manifest_id AND D.LAPTOP_ITEM_CODE = '$item_code'");
							$tec_qry = $qry->result_array();

							$ctc_kit_barcode 			= $barcode_no;
							$ctc_kit_desc 				= $tec_qry[0]['ITEM_MT_DESC'];
							$ctc_kit_mpn 				= $tec_qry[0]['ITEM_MT_MFG_PART_NO'];
							$ctc_kit_upc 				= $tec_qry[0]['ITEM_MT_UPC'];
							$ctc_kit_cost_price		 	= $tec_qry[0]['PO_DETAIL_RETIAL_PRICE'];
							$ctc_kit_qty 				= $tec_qry[0]['AVAILABLE_QTY'];
							$ctc_kit_cond 				= $tec_qry[0]['CONDITIONS_SEG5'];
							$ctc_kit_purchase_date 		= $tec_qry[0]['PURCHASE_DATE'];
							$lz_single_entry_id 		= '';
							$lz_manifest_id 			= $tec_qry[0]['LZ_MANIFEST_ID'];
							$item_id 					= $item_id;
							$catalog_id 				= $tec_qry[0]['CATALOGUE_MT_ID'];
							$category_id 				= $tec_qry[0]['CATEGORY_ID'];
							$lz_bd_cata_id 				= '';
							$lz_track_no				= '';
							$flag = 12;
			 }					
	
		$kit_data = array(
			"ctc_kit_barcode"=>$barcode_no,
			"ctc_kit_desc"=>$ctc_kit_desc,
			"ctc_kit_mpn"=>$ctc_kit_mpn,
			"ctc_kit_upc"=>$ctc_kit_upc,
			"ctc_kit_cost_price"=>$ctc_kit_cost_price,
			"ctc_kit_qty"=>$ctc_kit_qty,
			"ctc_kit_cond"=>$ctc_kit_cond, 
			"ctc_kit_purchase_date"=>$ctc_kit_purchase_date,
			"lz_single_entry_id"=>$lz_single_entry_id,
			"item_id"=>$item_id,
			"lz_manifest_id"=>$lz_manifest_id,
			"catalog_id"=>$catalog_id,
			"category_id"=>$category_id,
			"lz_bd_cata_id"=>$lz_bd_cata_id ,
			"lz_track_no" => $lz_track_no			

			);
					$this->session->set_userdata($kit_data);
		
			return array("estimate_detail" =>$estimate_detail, "barcode_detail" =>$tec_qry, "res"=>false);
		}


	}

	public function estim_data(){
		$barcode_no = $this->input->post('lz_bar_code');
		$lz_single_entry_id = $this->input->post('lz_single_entry_id');
		///var_dump($barcode_no, $lz_single_entry_id); exit;
		$get_manifest_id = $this->db->query("SELECT C.LZ_MANIFEST_ID  FROM LZ_BARCODE_MT C WHERE C.BARCODE_NO = $barcode_no");
		$get_lot_flag = $this->db->query("SELECT  M.KIT_LOT  FROM LZ_BD_ESTIMATE_MT M WHERE M.BARCODE_NO = $barcode_no");
		if ($get_lot_flag->num_rows() > 0) {
			$kit_flag_id = 'yes';
		}else {
			$kit_flag_id = '';
		}
		if ($get_manifest_id->num_rows() > 0) {
			$manifest_id = $get_manifest_id->result_array()[0]['LZ_MANIFEST_ID'];

				$get_manufacture = $this->db->query("SELECT K.ITEM_MT_MANUFACTURE FROM LZ_MANIFEST_DET K WHERE K.LZ_MANIFEST_ID = $manifest_id");

					if ($get_manufacture->num_rows() > 0) {
						$manufacture_name = $get_manufacture->result_array()[0]['ITEM_MT_MANUFACTURE'];	
					}else {
						$manufacture_name = '';
					}
					if (!empty($lz_single_entry_id)) {
						$qry ="SELECT D.LZ_ESTIMATE_DET_ID, M.LZ_BD_CATAG_ID, D.MPN_KIT_MT_ID, D.ITEM_MANUFACTURER, C.MPN, D.QTY, D.EST_SELL_PRICE, D.SPECIFIC_PIC_YN, D.LOCATION_ID, D.TECH_COND_DESC, O.OBJECT_NAME, C.MPN_DESCRIPTION, D.PART_CATLG_MT_ID,D.TECH_COND_ID, DECODE(D.TECH_COND_ID, 1000, 'NEW', 1500, 'NEW OTHER (SEE DETAILS)', 2000, 'MANUFACTURER REFURBISHED', 2500, 'SELLER REFURBISHED', 3000, 'USED', 7000, 'FOR PARTS OR NOT WORKING') COND FROM LZ_BD_ESTIMATE_MT  M, LZ_BD_ESTIMATE_DET D, LZ_BD_TRACKING_NO  T, LZ_CATALOGUE_MT    C, LZ_BD_OBJECTS_MT   O WHERE M.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID AND D.LZ_BD_ESTIMATE_ID = M.LZ_BD_ESTIMATE_ID AND C.CATALOGUE_MT_ID = D.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND T.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id  ORDER BY D.MPN_KIT_MT_ID ASC"; 

						$dekits = $this->db->query($qry)->result_array();
						
						if ($this->db->query($qry)->num_rows() > 0) {
							$lot_flag  = 'dekit';
						}else {
							$qry ="SELECT D.LZ_ESTIMATE_DET_ID, M.LZ_BD_CATAG_ID, D.MPN_KIT_MT_ID, D.ITEM_MANUFACTURER, C.MPN, D.QTY, D.EST_SELL_PRICE, D.SPECIFIC_PIC_YN, D.LOCATION_ID, D.TECH_COND_DESC, O.OBJECT_NAME, C.MPN_DESCRIPTION, D.PART_CATLG_MT_ID , D.TECH_COND_DESC, O.OBJECT_NAME, C.MPN_DESCRIPTION, D.PART_CATLG_MT_ID,D.TECH_COND_ID, DECODE(D.TECH_COND_ID, 1000, 'NEW', 1500, 'NEW OTHER (SEE DETAILS)', 2000, 'MANUFACTURER REFURBISHED', 2500, 'SELLER REFURBISHED', 3000, 'USED', 7000, 'FOR PARTS OR NOT WORKING') COND FROM LZ_BD_ESTIMATE_MT  M, LZ_BD_ESTIMATE_DET D, LZ_CATALOGUE_MT    C, LZ_BD_OBJECTS_MT   O WHERE D.LZ_BD_ESTIMATE_ID = M.LZ_BD_ESTIMATE_ID AND C.CATALOGUE_MT_ID = D.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND M.BARCODE_NO = $barcode_no";
							$dekits = $this->db->query($qry)->result_array();
							$lot_flag  = 'third';
						}
					}else {
						$qry ="SELECT D.LZ_ESTIMATE_DET_ID, M.LZ_BD_CATAG_ID, D.MPN_KIT_MT_ID, D.ITEM_MANUFACTURER, C.MPN, D.QTY, D.EST_SELL_PRICE, D.SPECIFIC_PIC_YN, D.LOCATION_ID, D.TECH_COND_DESC, O.OBJECT_NAME, C.MPN_DESCRIPTION, D.PART_CATLG_MT_ID , D.TECH_COND_DESC, O.OBJECT_NAME, C.MPN_DESCRIPTION, D.PART_CATLG_MT_ID,D.TECH_COND_ID, DECODE(D.TECH_COND_ID, 1000, 'NEW', 1500, 'NEW OTHER (SEE DETAILS)', 2000, 'MANUFACTURER REFURBISHED', 2500, 'SELLER REFURBISHED', 3000, 'USED', 7000, 'FOR PARTS OR NOT WORKING') COND FROM LZ_BD_ESTIMATE_MT  M, LZ_BD_ESTIMATE_DET D, LZ_CATALOGUE_MT    C, LZ_BD_OBJECTS_MT   O WHERE D.LZ_BD_ESTIMATE_ID = M.LZ_BD_ESTIMATE_ID AND C.CATALOGUE_MT_ID = D.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND M.BARCODE_NO = $barcode_no";
						$dekits = $this->db->query($qry)->result_array(); 
						$lot_flag  = 'lot';
						
					}
					//$lz_single_entry_id = $this->session->userdata('lz_single_entry_id');
					
					return array('dekits'=>$dekits, 'manufacture_name'=>$manufacture_name, 'kit_flag_id'=>$kit_flag_id, 'lot_flag'=>$lot_flag);
				}	
	}

	
	public function dekitManifestPosting(){
		$est_det_id = $this->input->post('est_det_id');


	    $kitcondition = $this->input->post('kitCondition');

	    $kitqty = $this->input->post('kitQty');
	    $part_mt_id = $this->input->post('part_mt_id');
	    $conddesc = $this->input->post('condDesc');
	    $specificpic = $this->input->post('specificPic');
	    $locationbin = $this->input->post('locationBin');
		$item_mt_mfg_part_no = $this->input->post('kitMpn');
		//var_dump($item_mt_mfg_part_no); exit;
		$mpn_desc = $this->input->post('mpn_desc');
		$kitBrand = $this->input->post('kitBrand');
		
		/*==================================================
		=            master item adjustemt code            =
		==================================================*/
		//$lz_single_entry_id = $this->session->userdata('lz_single_entry_id');// need to change
		$lz_single_entry_id = $this->input->post('lz_single_entry_id');
		//$barcode_no = $this->session->userdata('ctc_kit_barcode');
		$barcode_no = $this->input->post('barcode_no');
		//$item_id = $this->session->userdata('item_id');
		$item_id = $this->input->post('item_id');
		// var_dump($item_id);
		// exit;
		//$cost2 = $this->session->userdata('ctc_kit_cost_price');
		$cost2 = $this->input->post('cost2');
		//$lz_manifest_id = $this->session->userdata('lz_manifest_id');
		$lz_manifest_id = $this->input->post('manifist_id');
		$weight = $this->input->post('weight');
		// var_dump($weight);exit;
		// var_dump($lz_single_entry_id); exit;
		//$Quantity = $this->session->userdata('ctc_kit_qty');
		$Quantity = $this->input->post('qty');
		//$this->db->trans_begin();
			
			$get_user = $this->session->userdata('user_id');
			$gl_gen =" SELECT LZ_ITEM_ADJ_BOOK_ID  FROM GL_GEN_PREFERENCES GD "; 
			$gen_id = $this->db->query($gl_gen)->result_array();
			$gen_id = $gen_id[0]['LZ_ITEM_ADJ_BOOK_ID'];


			$inv_book_id = "SELECT S.DEF_LOCATOR_CODE_ID  FROM INV_BOOKS_MT B, SUB_INVENTORY_MT S WHERE INV_BOOK_ID = $gen_id AND B.SUB_INV_ID = S.SUB_INV_ID";
			$book_id = $this->db->query($inv_book_id)->result_array();
			$def_loc_id = $book_id[0]['DEF_LOCATOR_CODE_ID'];

			

			
			$adjus_no =$this->db->query("SELECT TO_CHAR(SYSDATE,'YY')||'-'|| LPAD('8',4,'0') ADJUST_REF_NO   FROM DUAL");
			$rn = $adjus_no->result_array();
			$adjus =$rn[0]['ADJUST_REF_NO'];

			$inv_book = $this->db->query(" SELECT DOC_SEQ_ID FROM   INV_SEQUENCE_ASSIGNMENT WHERE  inv_book_id = 8 ");
			$seq_id = $inv_book->result_array();
			$seq_id =$seq_id[0]['DOC_SEQ_ID'];
			
			$last = $this->db->query("SELECT LAST_NO +1 LAST_NO, DOC_DET_SEQ_ID FROM   DOC_SEQUENCE_DETAIL WHERE  DOC_DET_SEQ_ID = (SELECT DOC_DET_SEQ_ID FROM   DOC_SEQUENCE_DETAIL WHERE  DOC_SEQ_ID = $seq_id AND TO_DATE('3/1/2017','DD-MM-YYYY') >= FROM_DATE AND TO_DATE('3/1/2017','DD-MM-YYYY') <= TO_DATE AND ROWNUM = 1)");
			$seq_id = $last->result_array();
			$last_no =$seq_id[0]['LAST_NO'];
			
			$doc_det_seq_id =$seq_id[0]['DOC_DET_SEQ_ID'];



			$query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_MT', 'ITEM_ADJUSTMENT_ID')ID FROM DUAL");
			$rs = $query->result_array();
			$pk = $rs[0]['ID']; //44

			$item_adjus_mt = "INSERT INTO ITEM_ADJUSTMENT_MT(ITEM_ADJUSTMENT_ID, INV_BOOK_ID, ADJUSTMENT_NO, ADJUSTMENT_DATE, STOCK_TRANS_YN, REMARKS, INV_TRANSACTION_NO, JOURNAL_ID, POST_TO_GL, ENTERED_BY, AUTH_ID, AUTHORIZED_YN, SEND_FOR_AUTH, AUTH_STATUS_ID, ADJUSTMENT_REF_NO ) VALUES($pk, 8, $last_no, to_date(sysdate), 0, NULL, NULL, NULL, 0, $get_user, null, 0, 0, 0, '$adjus')";
			$this->db->query($item_adjus_mt); 			
	        
	        $query2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL");
			$rs = $query2->result_array();
			$det_pk = $rs[0]['ID'];

	        $item_adjus_det = "INSERT INTO ITEM_ADJUSTMENT_DET(ITEM_ADJUSTMENT_DET_ID, ITEM_ADJUSTMENT_ID, ITEM_ID, SR_NO, LOC_CODE_COMB_ID, PRIMARY_QTY, SECONDARY_QTY, LINE_AMOUNT, CONTRA_ACC_CODE_COMB_ID, REMARKS ) VALUES($det_pk, $pk, $item_id, 1, $def_loc_id, -$Quantity, NULL, $cost2, NULL, NULL )"; 
	        //print_r($item_adjus_mt);exit;
	        $this->db->query($item_adjus_det);
	       
			// $test = 5;
			// var_dump($test);
			// exit;

	        $this->db->query("UPDATE DOC_SEQUENCE_DETAIL  SET LAST_NO =$last_no where DOC_DET_SEQ_ID =$doc_det_seq_id");
	       
	        // -- query for barcode_mt column update 
	        $this->db->query ("UPDATE LZ_BARCODE_MT SET ITEM_ADJ_DET_ID_FOR_OUT = $pk WHERE BARCODE_NO = $barcode_no");

	        if (!empty($lz_single_entry_id)) {
	        	$this->db->query ("UPDATE  LZ_BD_ESTIMATE_MT SET ITEM_ADJ_MT_ID = $pk WHERE LZ_BD_CATAG_ID IN (SELECT LZ_BD_CATA_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id)");
	        	$this->db->query ("UPDATE  LZ_BD_ESTIMATE_MT SET ITEM_ADJ_MT_ID = $pk WHERE BARCODE_NO = $barcode_no");
	        }else {
	        	$this->db->query ("UPDATE  LZ_BD_ESTIMATE_MT SET ITEM_ADJ_MT_ID = $pk WHERE BARCODE_NO = $barcode_no");
	        }
	        

	        


	       /* $query2 = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ITEM_ADJUSTMENT_DET ', 'ITEM_ADJUSTMENT_DET_ID')ID FROM DUAL");
			$rs = $query2->result_array();
			$det_pk = $rs[0]['ID'];*/

			if (!empty($lz_single_entry_id)) {
				 $singl_id = $this->db->query("SELECT T.LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id");
				 if ($singl_id->num_rows() > 0) {
				 	$singl_id = $singl_id->result_array();
	        	  	$esti_id = $singl_id[0]['LZ_ESTIMATE_ID'];
				 }elseif ($singl_id->num_rows() == 0) {
				 	$singl_id = $this->db->query("SELECT MT.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT MT WHERE MT.BARCODE_NO = $barcode_no");
	        	 	$singl_id = $singl_id->result_array();
	        	 	$esti_id = $singl_id[0]['LZ_BD_ESTIMATE_ID'];
				 }
				  
			}else {
	        	$singl_id = $this->db->query("SELECT MT.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT MT WHERE MT.BARCODE_NO = $barcode_no");
	        	 $singl_id = $singl_id->result_array();
	        	 $esti_id = $singl_id[0]['LZ_BD_ESTIMATE_ID'];
			}
	       
	        // echo "<pre>";
	        // print_r($singl_id->result_array()); exit;
	       

	        $this->db->query ("UPDATE LZ_MANIFEST_MT T SET T.EST_MT_ID = $esti_id WHERE LZ_MANIFEST_ID = $lz_manifest_id ");

		/*=====  get master category id  ======*/
			// if (!empty($lz_single_entry_id)) {
			// 	$singl_id = $this->db->query ("SELECT CATEGORY_ID FROM LZ_SINGLE_ENTRY WHERE ID = $lz_single_entry_id");
			        
			//         if ($singl_id->num_rows() > 0) {
			//         	$singl_id = $singl_id->result_array();
			//         	$master_cat_id = $singl_id[0]['CATEGORY_ID'];
			//         }elseif ($singl_id->num_rows() == 0) {
			//         	$singl_id = $this->db->query ("SELECT M.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET M WHERE M.LZ_MANIFEST_ID= $lz_manifest_id");
			//         	$singl_id = $singl_id->result_array();
			//         	$master_cat_id = $singl_id[0]['E_BAY_CATA_ID_SEG6'];
			//         }
			// }else {
				$singl_id = $this->db->query ("SELECT M.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET M WHERE M.LZ_MANIFEST_ID= $lz_manifest_id");
			        $singl_id = $singl_id->result_array();
			        $master_cat_id = $singl_id[0]['E_BAY_CATA_ID_SEG6'];
			//}	
     /*=====  get master category id  ======*/  
        $i = 0;
        foreach($item_mt_mfg_part_no as $mpn){
			/*==========================================================
			=            update value in lz_bd_estimate_det            =
			==========================================================*/
			//var_dump($mpn); exit;
			$det_id = $est_det_id[$i];
			$mpn_description = ($mpn_desc[$i]);
			$part_id = ($part_mt_id[$i]);

			$kitMpn = strtoupper(trim(str_replace("  ", ' ', $mpn)));
	        $kitMpn = trim(str_replace(array("'"), "''", $kitMpn));

			if($specificpic[$i] == 'true'){
		    	$specificpicture = 1;
		    }elseif($specificpic[$i] == 'false'){
		    	$specificpicture = 0;
		    }	

			$this->db->query("UPDATE LZ_BD_ESTIMATE_DET K SET K.TECH_COND_ID = $kitcondition[$i], K.ACT_QTY_RCVD = $kitqty[$i], K.SPECIFIC_PIC_YN = $specificpicture, K.LOCATION_ID = '$locationbin[$i]', K.TECH_COND_DESC = '$conddesc[$i]', K.ITEM_MANUFACTURER = '$kitBrand[$i]' WHERE K.LZ_ESTIMATE_DET_ID = $det_id");

			$this->db->query("UPDATE LZ_CATALOGUE_MT M SET M.MPN_DESCRIPTION = '$mpn_description' WHERE M.CATALOGUE_MT_ID = '$part_id'");



			/*=====  End of update value in lz_bd_estimate_det  ======*/

	                	

	        
	        $max_query = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LOADING_NO') ID FROM DUAL");
	        $rs = $max_query->result_array();
	        $loading_no = $rs[0]['ID'];

	        date_default_timezone_set("America/Chicago");
	        $loading_date = date("Y-m-d H:i:s");
	        $loading_date = "TO_DATE('".$loading_date."', 'YYYY-MM-DD HH24:MI:SS')";
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
			$manifest_type = 1;
			$est_mt_id = $esti_id;
			$comma = ',';

			/*--- Get Single Primary Key for LZ_MANIFEST_MT start---*/
			$get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LZ_MANIFEST_ID') LZ_MANIFEST_ID FROM DUAL");
			$get_mt_pk = $get_mt_pk->result_array();
			$lz_manifest_id = $get_mt_pk[0]['LZ_MANIFEST_ID'];
			/*--- Get Single Primary Key for LZ_MANIFEST_MT end---*/

			/*--- Insertion Query for LZ_MANIFEST_MT start---*/
			$mt_qry = "INSERT INTO LZ_MANIFEST_MT (LZ_MANIFEST_ID, LOADING_NO, LOADING_DATE, PURCH_REF_NO, SUPPLIER_ID, REMARKS, DOC_SEQ_ID, PURCHASE_DATE, POSTED, EXCEL_FILE_NAME, GRN_ID, PURCHASE_INVOICE_ID, SINGLE_ENTRY_ID, TOTAL_EXCEL_ROWS, MANIFEST_NAME, MANIFEST_STATUS, SOLD_PRICE, END_DATE, LZ_OFFER, MANIFEST_TYPE, EST_MT_ID) VALUES($lz_manifest_id $comma $loading_no $comma $loading_date $comma '$purch_ref_no' $comma $supplier_id $comma '$remarks' $comma $doc_seq_id $comma $purchase_date $comma '$posted' $comma $excel_file_name $comma $grn_id $comma $purchase_invoice_id $comma $single_entry_id $comma $total_excel_rows $comma $manifest_name  $comma $manifest_status $comma $sold_price $comma $end_date $comma $lz_offer $comma $manifest_type, $est_mt_id)";
	        $mt_qry = $this->db->query($mt_qry);
	        /*--- Insertion Query for LZ_MANIFEST_MT end---*/

			$po_mt_auction_no = 'null';
			$po_detail_lot_ref = 'null';
			$po_mt_ref_no = 'null';

			$item_mt_manufacture = $kitBrand[$i];
	        $item_mt_manufacture = trim(str_replace("  ", ' ', $item_mt_manufacture));
	        $item_mt_manufacture = trim(str_replace(array("'"), "''", $item_mt_manufacture));		

	        $mpn_desc_qry = $this->db->query("SELECT MT.MPN_DESCRIPTION, MT.CATEGORY_ID FROM LZ_CATALOGUE_MT MT WHERE MT.CATALOGUE_MT_ID = '$part_id'");
	        $mpn_desc_query = $mpn_desc_qry->result_array();
	        // echo "<pre>";
	        // print_r($mpn_desc_query); 
	        // echo "</pre>";
	        $item_mt_desc = $mpn_desc_query[0]['MPN_DESCRIPTION'];		
	        $category_id = $mpn_desc_query[0]['CATEGORY_ID'];
	        // var_dump($item_mt_desc, $category_id);

	        $item_mt_desc = trim(str_replace("  ", ' ', $item_mt_desc));
	        $item_mt_desc = trim(str_replace(array("'"), "''", $item_mt_desc));		

			$item_mt_bby_sku = 'null';
			
			$item_mt_upc = 'null';
	        // $item_mt_upc = trim(str_replace(" ", '', $item_mt_upc));
	        // $item_mt_upc = trim(str_replace(array("'"), "", $item_mt_upc));

		
		////  po_detail_retial_price formual 
		$sum_esti = $this->db->query("SELECT SUM (EST_SELL_PRICE) TOTAL_ESTIMATE_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.LZ_BD_ESTIMATE_ID = $est_mt_id GROUP BY LZ_BD_ESTIMATE_ID");
		$sum_esti = $sum_esti->result_array();
		$total_estimate_price = $sum_esti[0]['TOTAL_ESTIMATE_PRICE'];

		$single_esti = $this->db->query("SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.LZ_ESTIMATE_DET_ID = $det_id ");
		
			$single_esti = $single_esti->result_array();
			$single_estimate_price = $single_esti[0]['EST_SELL_PRICE'];
		//var_dump($single_estimate_price); exit;
		
	    
	    //$po_detail_price = @$this->session->userdata('ctc_kit_cost_price');
	    $po_detail_price = $this->input->post($cost2);
	   
       	
       	$po_detail_retial_price = $single_estimate_price / $total_estimate_price * $po_detail_price;
       	////  po_detail_retial_price formual  end 
	        
			/*-- Category name and Category Id from Category Tree table start --*/
	        $cat_name_qry = $this->db->query("select c.category_name, c.parent_cat_id from lz_bd_category_tree c where c.category_id = $category_id");
	        $cat_name_qry = $cat_name_qry->result_array();
	        $category_name = $cat_name_qry[0]['CATEGORY_NAME'];			
	        $sub_parent_id = $cat_name_qry[0]['PARENT_CAT_ID'];

	        $sub_cat_qry = $this->db->query("select c.category_name, c.parent_cat_id from lz_bd_category_tree c where c.category_id = $sub_parent_id");
	        $sub_cat_qry = $sub_cat_qry->result_array();
	        $sub_cat_name = $sub_cat_qry[0]['CATEGORY_NAME'];			
	        $main_parent_id = $sub_cat_qry[0]['PARENT_CAT_ID'];
	        if (!empty($main_parent_id)) {
	        	$main_cat_qry = $this->db->query("select c.category_name from lz_bd_category_tree c where c.category_id = $main_parent_id");
		        //exit;
		        $main_cat_qry = $main_cat_qry->result_array();
		        $main_cat_name = $main_cat_qry[0]['CATEGORY_NAME'];
	        }else
	        {
	        	$main_cat_name = $sub_cat_name;
	        }
	       // var_dump($sub_parent_id, $main_parent_id,  $category_id);
	        
	        /*-- Category name and Category Id from Category Tree table end --*/		
	                   

			$main_catagory_seg1 = $main_cat_name;
			$sub_catagory_seg2 = $sub_cat_name;

			$brand_seg3 = $category_name;
		
	        	
			$origin_seg4 = 'US';

			 	if(@$kitcondition[$i] == 3000){
		          @$conditions_seg5 = 'Used';
		        }elseif(@$kitcondition[$i] == 1000){
		          @$conditions_seg5 = 'New'; 
		        }elseif(@$kitcondition[$i] == 1500){
		          @$conditions_seg5 = 'New other'; 
		        }elseif(@$kitcondition[$i] == 2000){
		            @$conditions_seg5 = 'Manufacturer refurbished';
		        }elseif(@$kitcondition[$i] == 2500){
		          @$conditions_seg5 = 'Seller refurbished'; 
		        }elseif(@$kitcondition[$i] == 7000){
		          @$conditions_seg5 = 'For parts or not working'; 
		        }elseif(@$kitcondition[$i] == 4000){
		          @$conditions_seg5 = 'Very Good'; 
		        }elseif(@$kitcondition[$i] == 5000){
		          @$conditions_seg5 = 'Good'; 
		        }elseif(@$kitcondition[$i] == 6000){
		          @$conditions_seg5 = 'Acceptable'; 
		        }elseif(@$kitcondition[$i] == 7000){
		          @$conditions_seg5 = 'For parts or not working'; 
		        }elseif(@$kitcondition[$i] == 1750){
		          @$conditions_seg5 = 'New with defects'; 
		        }

		    //var_dump($conditions_seg5); 
			//$conditions_seg5 = $this->input->post('condDesc');

			$e_bay_cata_id_seg6 = $category_id;
			$laptop_item_code = 'null';
			$avail_qty = $this->input->post('kitQty');
			$available_qty = $avail_qty[$i];

			$price = 'null';
			$category_name_seg7 = $item_mt_manufacture;
			$s_price = 'null';
			$v_price = 'null';
			$ship_fee = 'null';
			$sticker_print = 'null';
			$manual_update = 'null';
			$estimate_det_id = $det_id;

			/*--- Get Single Primary Key for LZ_MANIFEST_DET start---*/
	        $get_det_pk = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_DET','LAPTOP_ZONE_ID') LZ_ID FROM DUAL");
	        $get_det_pk = $get_det_pk->result_array();
	        $laptop_zone_id = $get_det_pk[0]['LZ_ID'];
	        /*--- Get Single Primary Key for LZ_MANIFEST_DET end---*/		
	        
	        /*--- Insertion Query for LZ_MANIFEST_DET start---*/
			$det_qry = "INSERT INTO LZ_MANIFEST_DET (PO_MT_AUCTION_NO, PO_DETAIL_LOT_REF, PO_MT_REF_NO, ITEM_MT_MANUFACTURE, ITEM_MT_MFG_PART_NO, ITEM_MT_DESC, ITEM_MT_BBY_SKU, ITEM_MT_UPC, PO_DETAIL_RETIAL_PRICE, MAIN_CATAGORY_SEG1, SUB_CATAGORY_SEG2, BRAND_SEG3, ORIGIN_SEG4, CONDITIONS_SEG5, E_BAY_CATA_ID_SEG6, LAPTOP_ZONE_ID, LAPTOP_ITEM_CODE, AVAILABLE_QTY, PRICE, LZ_MANIFEST_ID, CATEGORY_NAME_SEG7, S_PRICE, V_PRICE, SHIP_FEE, STICKER_PRINT, MANUAL_UPDATE, EST_DET_ID,WEIGHT) VALUES($po_mt_auction_no $comma $po_detail_lot_ref $comma $po_mt_ref_no $comma '$item_mt_manufacture' $comma '$kitMpn' $comma '$item_mt_desc' $comma $item_mt_bby_sku $comma $item_mt_upc $comma $po_detail_retial_price $comma '$main_cat_name' $comma '$sub_cat_name' $comma '$brand_seg3' $comma '$origin_seg4' $comma '$conditions_seg5' $comma '$e_bay_cata_id_seg6' $comma $laptop_zone_id $comma $laptop_item_code $comma $available_qty $comma $price $comma $lz_manifest_id $comma '$brand_seg3' $comma $s_price $comma $v_price $comma $ship_fee $comma $sticker_print $comma $manual_update, $estimate_det_id,'$weight[$i]')";
	        $det_qry = $this->db->query($det_qry);
	        ///var_dump($lz_manifest_id, $pk, $master_cat_id); exit;
	        $this->db->query("call Pro_dekit_item($lz_manifest_id,$pk, $master_cat_id)");
	        
	     //    if ($this->db->trans_status() === FALSE){
						//     $this->db->trans_rollback();
						//     $flag = 0;
						// }else
						// {
							
							/*$this->db->trans_commit();
							$flag = 1;*/
						//}
			        /*--- Insertion Query for LZ_MANIFEST_DET end---*/
			        /*==============================================================
			        =            call post procedure to adjust the item            =
			        ==============================================================*/
			       // $pk pasing parameter  Pro_dekit_item
			        
			        /*=====  End of call post procedure to adjust the item  ======*/
	        
	        $i++;
        } //end main foreach
		return true;
	}	
public function delete_kit_comp(){
	$est_det_id = $this->input->post('est_det_id');

	$del_from_man = $this->db->query("DELETE  FROM LZ_MANIFEST_DET WHERE EST_DET_ID = $est_det_id");
	if ($del_from_man) {
		$del_from_est = $this->db->query("DELETE FROM LZ_BD_ESTIMATE_DET WHERE LZ_ESTIMATE_DET_ID = $est_det_id");

		if ($del_from_est) {
			return true;
		}else {
			return false;
		}
	}else {
		return false;
	}
	
}
//////////////////////// new queries in from m_purchasing//////////////////////////////////
public function getMpnObjects(){
    $bd_mpn = $this->input->post('bd_mpn');

    $query = $this->db->query("SELECT DISTINCT M.OBJECT_ID, O.OBJECT_NAME FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O WHERE M.OBJECT_ID = O.OBJECT_ID AND M.CATALOGUE_MT_ID = $bd_mpn");
    return $query->result_array();
     
  }
  public function loadBdMpn(){
    $object_id = $this->input->post('object_id');
    $sql = "SELECT C.MPN, C.CATALOGUE_MT_ID, O.OBJECT_ID FROM LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = C.OBJECT_ID AND O.OBJECT_ID = $object_id";
    $sql = $this->db2->query($sql);
    $sql = $sql->result_array();
    return $sql;
  }
  public function addKitComponent(){
    // print_r($this->session->userdata); exit;
    $catalogue_mt_id = $this->input->post('catalogue_mpn_id');
    $part_cata_id = $this->input->post('bd_mpn');
    $kit_qty = $this->input->post('kit_qty');

    $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
      $rs = $query->result_array();
      $MPN_KIT_MPN = $rs[0]['ID'];
    //var_dump($catalogue_mt_id, $part_cata_id, $kit_qty); exit;
    $det_query = $this->db->query("INSERT INTO LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID, CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID) VALUES($MPN_KIT_MPN, $catalogue_mt_id,$kit_qty,$part_cata_id )");

    if ($det_query){
      return 1;
    }else {
      return 0;
    }
  }
   public function updateKitComponentt(){
    $ct_cata_id 				= $this->input->post('ct_cata_id');
    $master_mpn_id 				= $this->input->post('master_mpn_id');
    $lz_single_entry_id 		= $this->input->post('lz_single_entry_id');
    $object_id 					= $this->input->post('object_id');
    $selected_mpn 				= $this->input->post('selected_mpn');
    $brand_name 				= $this->input->post('brand_name');
    $kit_est_price 				= $this->input->post('kit_est_price');
    $kit_qty 					= $this->input->post('kit_qty');

    $ebay_fee 					= 0;
    $paypal_fee 				= 0;
    $ship_fee 					= 3.25;

    $ebay_fee 					= ($kit_qty * (8 / 100));
    $paypal_fee 				= ($kit_qty  * (2.5 / 100));

    $kit_mpn = $this->db->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn_id AND M.PART_CATLG_MT_ID = $selected_mpn");
    if ($kit_mpn->num_rows() == 0) {
     	$kit_alt_mpn = $this->db->query("SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID IN (SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn_id) AND A.CATALOGUE_MT_ID = $selected_mpn");
     		if ($kit_alt_mpn->num_rows() == 0) {
     			$get_object = $this->db->query("SELECT M.OBJECT_ID FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = $selected_mpn ")->result_array();
     			$check_object_id = $get_object[0]['OBJECT_ID'];

     			$check_object = $this->db->query("SELECT OBJECT_ID,CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID IN (SELECT M.PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn_id) AND M.OBJECT_ID = $check_object_id ");
     			if ($check_object->num_rows() == 0) {

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $mpn_kit_mt_id = $rs[0]['ID'];
     				$insert_kit_mt = $this->db->query("INSERT INTO  LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID, CATALOGUE_MT_ID, QTY, PART_CATLG_MT_ID) VALUES($mpn_kit_mt_id, $master_mpn_id, $kit_qty, $selected_mpn)");
     				if ($insert_kit_mt) {
     					$insert = 1;
     				}else {
     					$insert = 0;
     				}
     			}else {

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $mpn_kit_alt_mpn = $rs[0]['ID'];
     				$insert_kit_alt_mt = $this->db->query("INSERT INTO  LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID, PART_CATLG_MT_ID) VALUES($mpn_kit_alt_mpn, $mpn_kit_mt_id, $master_mpn_id)");
     				if ($insert_kit_alt_mt) {
     					$insert = 1;
     				}else {
     					$insert = 0;
     				}
     			}
     			if ($insert == 1) {
     				if (empty($lz_single_entry_id)) {
     					$qry = $this->db->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.BARCODE_NO = $ct_cata_id");
     					if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_BD_ESTIMATE_ID'];
     					}
     				}else{ 
     					 $qry = $this->db->query("SELECT N.LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO N WHERE N.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id");
     					 if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_ESTIMATE_ID'];
     					}
     					 
     				}

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_estimate_det_id = $rs[0]['ID'];

     				$insert_estimate_det = $this->db->query("INSERT INTO  LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, ITEM_ID, ITEM_ADJ_DET_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, $mpn_kit_mt_id, $kit_qty, $kit_est_price, $ebay_fee, $paypal_fee, $ship_fee, 3000, null, null, null, null, null, null, null, null, $selected_mpn)");

     					if ($insert_estimate_det){
					      return 1;
					    }else {
					      return 0;
					    }
     			}
     		}else {
     			return 2;
     		} // check mpn in LZ_BD_MPN_KIT_ALT_MPN
     	 } // check mpn in LZ_BD_MPN_KIT_MT
  }

  public function updateKitComponent(){
    $ct_cata_id 				= $this->input->post('ct_cata_id');
    $master_mpn_id 				= $this->input->post('master_mpn_id');
    $lz_single_entry_id 		= $this->input->post('lz_single_entry_id');
    $object_id 					= $this->input->post('object_id');
    $selected_mpn 				= $this->input->post('selected_mpn');
    $brand_name 				= $this->input->post('brand_name');
    $kit_est_price 				= $this->input->post('kit_est_price');
    $kit_qty 					= $this->input->post('kit_qty');

    $ebay_fee 					= 0;
    $paypal_fee 				= 0;
    $ship_fee 					= 3.25;

    $ebay_fee 					= ($kit_est_price * (8 / 100));
    $paypal_fee 				= ($kit_est_price  * (2.5 / 100));
    //var_dump($ct_cata_id, $master_mpn_id , $object_id , $selected_mpn , $brand_name, $kit_est_price, $kit_qty); exit;
    $kit_mpn = $this->db->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn_id AND M.PART_CATLG_MT_ID = $selected_mpn");
    if ($kit_mpn->num_rows() == 0) {

     	$kit_alt_mpn = $this->db->query("SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID IN (SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn_id) AND A.CATALOGUE_MT_ID = $selected_mpn");
     		if ($kit_alt_mpn->num_rows() == 0) {

     			$get_object = $this->db->query("SELECT M.OBJECT_ID FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = $selected_mpn ")->result_array();
     			$check_object_id = $get_object[0]['OBJECT_ID'];

     			$check_object = $this->db->query("SELECT OBJECT_ID,CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID IN (SELECT M.PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn_id) AND M.OBJECT_ID = $check_object_id ");
     			if ($check_object->num_rows() == 0) {
     				
     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $mpn_kit_mt_id = $rs[0]['ID'];
			        

     				$insert_kit_mt = $this->db->query("INSERT INTO  LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID, CATALOGUE_MT_ID, QTY, PART_CATLG_MT_ID) VALUES($mpn_kit_mt_id, $master_mpn_id, $kit_qty, $selected_mpn)");
     				if ($insert_kit_mt) {
     					$insert = 1;
     				}else {
     					$insert = 0;
     				}
     			}else {
     				//echo "no ".$check_object_id; exit;

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $mpn_kit_alt_mpn = $rs[0]['ID'];
     				$insert_kit_alt_mt = $this->db->query("INSERT INTO  LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID, PART_CATLG_MT_ID) VALUES($mpn_kit_alt_mpn, $mpn_kit_mt_id, $master_mpn_id)");
     				if ($insert_kit_alt_mt) {
     					$insert = 1;
     				}else {
     					$insert = 0;
     				}
     			}
     			if ($insert == 1) {
     				
     				if (empty($lz_single_entry_id)) {
     					$qry = $this->db->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.BARCODE_NO = $ct_cata_id");
     					if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_BD_ESTIMATE_ID'];
     						
     					}
     				}else{ 
     					 $qry = $this->db->query("SELECT N.LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO N WHERE N.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id");
     					 if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_ESTIMATE_ID'];
     						
     					}
     					 
     				}

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_estimate_det_id = $rs[0]['ID'];
			        
     				$insert_estimate_det = $this->db->query("INSERT INTO  LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, ITEM_ID, ITEM_ADJ_DET_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, $mpn_kit_mt_id, $kit_qty, $kit_est_price, $ebay_fee, $paypal_fee, $ship_fee, 3000, null, null, null, null, null, null, null, null, $selected_mpn)");

     					if ($insert_estimate_det){
					      return 1;
					    }else {
					      return 0;
					    }
     			}else{
     				return 0;
     			}
     		}else { // end of check if component is present in alt table
     			$mpn_kit_mt_id = $kit_mpn->result_array()[0]['MPN_KIT_MT_ID'];
	     	 	$check_qry = $this->db->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_ESTIMATE_DET M WHERE M.MPN_KIT_MT_ID = $mpn_kit_mt_id");
	     	 	if ($check_qry->num_rows() == 0) {
	     	 		if (empty($lz_single_entry_id)) {
     					$qry = $this->db->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.BARCODE_NO = $ct_cata_id");
     					if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_BD_ESTIMATE_ID'];
     						
     					}
     				}else{ 
     					 $qry = $this->db->query("SELECT N.LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO N WHERE N.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id");
     					 if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_ESTIMATE_ID'];
     						
     					}
     					 
     				}

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_estimate_det_id = $rs[0]['ID'];
			        
     				$insert_estimate_det = $this->db->query("INSERT INTO  LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, ITEM_ID, ITEM_ADJ_DET_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, $mpn_kit_mt_id, $kit_qty, $kit_est_price, $ebay_fee, $paypal_fee, $ship_fee, 3000, null, null, null, null, null, null, null, null, $selected_mpn)");

     					if ($insert_estimate_det){
					      return 1;
					    }else {
					      return 0;
					    }
	     	 	}else{
	     	 		return 2;
	     	 	}
     		} // check mpn in LZ_BD_MPN_KIT_ALT_MPN
     	 }else{ // end of check if component is present in  LZ_BD_MPN_KIT_MT table
     	 	$mpn_kit_mt_id = $kit_mpn->result_array()[0]['MPN_KIT_MT_ID'];
     	 	$check_qry = $this->db->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_ESTIMATE_DET M WHERE M.MPN_KIT_MT_ID = $mpn_kit_mt_id");
     	 	if ($check_qry->num_rows() == 0) {
     	 			if (empty($lz_single_entry_id)) {
     					$qry = $this->db->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.BARCODE_NO = $ct_cata_id");
     					if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_BD_ESTIMATE_ID'];
     						
     					}
     				}else{ 
     					 $qry = $this->db->query("SELECT N.LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO N WHERE N.LZ_SINGLE_ENTRY_ID = $lz_single_entry_id");
     					 if ($qry->num_rows() > 0) {
     						$lz_bd_estimate_id = $qry->result_array()[0]['LZ_ESTIMATE_ID'];
     						
     					}
     					 
     				}

     				$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
			        $rs = $qry->result_array();
			        $lz_estimate_det_id = $rs[0]['ID'];
			        
     				$insert_estimate_det = $this->db->query("INSERT INTO  LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, ITEM_ID, ITEM_ADJ_DET_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, $mpn_kit_mt_id, $kit_qty, $kit_est_price, $ebay_fee, $paypal_fee, $ship_fee, 3000, null, null, null, null, null, null, null, null, $selected_mpn)");

     					if ($insert_estimate_det){
					      return 1;
					    }else {
					      return 0;
					    }
     	 	}else{
     	 		return 2;
     	 	}
     	 	
     	 } //end of main else 
  }
  public function createAutoKit(){
    $ct_catlogue_mt_id = $this->input->post('ct_catlogue_mt_id');
    $kitmpnauto = strtoupper(trim($this->input->post('kitmpnauto')));
    $pro_auto_kit = "call PRO_AUTO_KIT_177($ct_catlogue_mt_id, '$kitmpnauto')";
    $query = $this->db->query($pro_auto_kit);
    if($query){
        return 1;
    }else{
        return 0;
    }    
  }
  public function fetch_object(){
  $category_id = $this->input->post('categoryId');
  $query = $this->db->query("SELECT OBJECT_ID , OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE CATEGORY_ID = $category_id");
  $result = $query->result_array();
  return $result;
	}

  public function get_mpns(){
     $brand_name = strtoupper(trim($this->input->post('brand_name')));
     $object_id = $this->input->post('object_id');
     $object_cat_id = $this->db->query("SELECT O.CATEGORY_ID FROM LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = 1133");
     if ($object_cat_id->num_rows() > 0) {
     	$cat_id = $object_cat_id->result_array()[0]['CATEGORY_ID'];
     	 return $this->db->query("SELECT M.CATALOGUE_MT_ID , M.MPN FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID  AND CD.DET_ID = D.SPECIFIC_DET_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND UPPER(CD.SPECIFIC_VALUE) = '$brand_name' AND M.CATEGORY_ID = $cat_id")->result_array();
     }
     
  }
  public function get_brands(){
    $object_id = $this->input->post('object_id');
    return $this->db->query("SELECT  DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) ='BRAND' AND CD.DET_ID = D.SPECIFIC_DET_ID AND M.OBJECT_ID = $object_id")->result_array(); 
  }
  public function cp_del_component(){
    $component_id = $this->input->post('lz_bd_mpn_ki_id'); 
    //var_dump($component_id); exit;
    $check_tracking_no = $this->db->query("SELECT T.MPN_KIT_MT_ID FROM LZ_BD_ESTIMATE_DET T WHERE T.MPN_KIT_MT_ID = $component_id");
    if ($check_tracking_no->num_rows() == 0) { 
      $del_comp_from_alt_mpn = $this->db->query("DELETE FROM LZ_BD_MPN_KIT_ALT_MPN T WHERE T.MPN_KIT_MT_ID = $component_id");
      if($del_comp_from_alt_mpn){
        $del_component_from_kit = $this->db->query("DELETE FROM LZ_BD_MPN_KIT_MT T WHERE T.MPN_KIT_MT_ID = $component_id");  
      }
       if ($del_component_from_kit) {
          return 1;
        }else {
          return 0; 
        }
      
    }else {
    	$del_estimate_det = $this->db->query("DELETE FROM LZ_BD_ESTIMATE_DET T WHERE T.MPN_KIT_MT_ID = $component_id");
    	if ($del_estimate_det) {
    		 $del_comp_from_alt_mpn = $this->db->query("DELETE FROM LZ_BD_MPN_KIT_ALT_MPN T WHERE T.MPN_KIT_MT_ID = $component_id");
		      if($del_comp_from_alt_mpn){
		        $del_component_from_kit = $this->db->query("DELETE FROM LZ_BD_MPN_KIT_MT T WHERE T.MPN_KIT_MT_ID = $component_id");  
		      }
		       if ($del_component_from_kit) {
		          return 1;
		        }else {
		          return 0; 
		        }
    	}
      
    }
   

  }
   public function kitComponents(){
    $cat_id = $this->uri->segment(4); 
    $catalogue_mt_id = $this->uri->segment(5);
     $lz_bd_cata_id = $this->uri->segment(6) ;

    $sess_data = array("catalogue_List_type"=>"All", "catalogue_condition"=>"All");
    $this->session->set_userdata($sess_data);

    //$results = $this->db->query("SELECT M.MPN_KIT_MT_ID, M.QTY, M.PART_CATLG_MT_ID, O.OBJECT_NAME, GET_AVG_PRICE(MT.CATEGORY_ID,M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID AND O.OBJECT_ID = MT.OBJECT_ID AND M.CATALOGUE_MT_ID =$catalogue_mt_id");
    $results = $this->db->query("SELECT M.*, C.MPN, C.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND O.CATEGORY_ID = C.CATEGORY_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, 1, MP.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND O.CATEGORY_ID = C.CATEGORY_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");

    $distinct_object_count = $this->db->query("SELECT * FROM (SELECT distinct regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME, count(1)  object_count FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID group by O.OBJECT_NAME UNION ALL SELECT distinct regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME, count(1) object_count FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID group by O.OBJECT_NAME) ORDER BY OBJECT_NAME ASC");
    $object_list = $distinct_object_count->result_array();     
    //$det_qry = $this->db->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, REC.AVERAGE_PRICE, BD.SALE_PRICE - REC.AVERAGE_PRICE AS PRICE_AFTERLIST, T.TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (SELECT C.CATALOGUE_MT_ID AS ID, ROUND(AVG(C.SALE_PRICE), 2) AS AVERAGE_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id C WHERE C.CATALOGUE_MT_ID IS NOT NULL GROUP BY C.CATALOGUE_MT_ID) REC WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND M.CATALOGUE_MT_ID = REC.ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id");
    
    /*$det_qry = $this->db->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND BD.LZ_BD_CATA_ID =$lz_bd_cata_id"); 
    $detail = $det_qry->result_array();*/

    /*$mpn = $this->db->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN");
    $mpn = $mpn->result_array();*/
   
    /*$mpn = $this->db->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN"); 
    $mpn = $mpn->result_array();*/

    $list_types = $this->db->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();
    $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
    /*echo "<pre>";
      print_r($results->result_array());
      exit;
     */
      return array("results"=>$results, "list_types"=>$list_types, "conditions"=>$conditions, "object_list"=>$object_list);
  }
  public function lotViewLoad(){
    $cat_id 				= $this->input->post('category_id');
    $catalogue_mt_id 		= $this->input->post('catalog_id');
    $lz_bd_cata_id 			= $this->input->post('lz_bar_code');

    //var_dump($cat_id, $catalogue_mt_id, $lz_bd_cata_id); exit;

    //$results = $this->db->query("SELECT M.MPN_KIT_MT_ID, M.QTY, M.PART_CATLG_MT_ID, O.OBJECT_NAME, GET_AVG_PRICE(MT.CATEGORY_ID,M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID AND O.OBJECT_ID = MT.OBJECT_ID AND M.CATALOGUE_MT_ID =$catalogue_mt_id");
    $results = $this->db->query("SELECT M.*, C.MPN, C.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND O.CATEGORY_ID = C.CATEGORY_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, 1, MP.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND O.CATEGORY_ID = C.CATEGORY_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID")->result_array();
    /*echo "<pre>";
    print_r($results );
    exit;*/

    $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
  
      return array("results"=>$results,  "conditions"=>$conditions);
  }
  public function savekitComponents(){
    $cat_id=$this->input->post('cat_id');
    $catalogue_mt_id=$this->input->post('mpn_id');
    $dynamic_cata_id=$this->input->post('dynamic_cata_id');
    //var_dump($cat_id, $catalogue_mt_id, $dynamic_cata_id); exit;
    $partsCatalgid = $this->input->post('partsCatalgid');
    $compName=$this->input->post('compName');
    $compQty=$this->input->post('compQty');

    $compAvgPrice=$this->input->post('compAvgPrice');
    $compAvgPrice = str_replace("$", "", $compAvgPrice);
    $compAvgPrice = str_replace("$ ", "", $compAvgPrice);
    
    $compAmount=$this->input->post('compAmount');
    $compAmount = str_replace("$ ", "", $compAmount);
    $compAmount = str_replace("$", "", $compAmount);

    $ebayFee=$this->input->post('ebayFee');
    $ebayFee = str_replace("$ ", "", $ebayFee);
    $ebayFee = str_replace("$", "", $ebayFee);

    $payPalFee=$this->input->post('payPalFee');
    $payPalFee = str_replace("$ ", "", $payPalFee);
    $payPalFee = str_replace("$", "", $payPalFee);

    $shipFee=$this->input->post('shipFee');
    $shipFee = str_replace("$ ", "", $shipFee); 
    $shipFee = str_replace("$", "", $shipFee); 

    $tech_condition=$this->input->post('tech_condition');
    
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $estimate_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    //var_dump($compAvgPrice, $compAmount, $ebayFee, $payPalFee, $shipFee); exit;

    $user_id = $this->session->userdata('user_id');
    //var_dump($estimate_date, $dynamic_cata_id);exit;
    if (!empty($user_id)) {
      $check_catalogue = $this->db->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M. BARCODE_NO = $dynamic_cata_id");
      if ($check_catalogue->num_rows() > 0) {
      	$estimate_id = $check_catalogue->result_array()[0]['LZ_BD_ESTIMATE_ID'];
      	$qry = $this->db->query("DELETE FROM LZ_BD_ESTIMATE_DET D WHERE D.LZ_BD_ESTIMATE_ID = $estimate_id ");
      	/////$this->db->query("UPDATE  LZ_BD_ESTIMATE_MT SET  KIT_LOT = 'L' WHERE BARCODE_NO = $dynamic_cata_id");
      	 $i=0;
        foreach ($compName as $comp) {
          $component = trim($comp);
          $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
          $rs = $qry->result_array();
            $lz_estimate_det_id = $rs[0]['ID'];
           $insert_est_det = $this->db->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $estimate_id, $component, $compQty[$i], $compAmount[$i], $ebayFee[$i], $payPalFee[$i], $shipFee[$i], $tech_condition[$i], NULL, NULL, NULL, NULL, $compAvgPrice[$i],$partsCatalgid[$i])");
          $i++;
        }
        if($insert_est_det == true || $insert_est_det ==true){
              return 1;
            }else {
                return 2;
              }
      }else {
        $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
        $rs = $qry->result_array();
          $lz_estimate_id = $rs[0]['ID'];
        $insert_est_mt = $this->db->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, BARCODE_NO, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id,  $dynamic_cata_id, $estimate_date, $user_id)");
      if ($insert_est_mt) {
        $i=0;
        foreach ($compName as $comp) {
          $component = trim($comp);
          $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
          $rs = $qry->result_array();
            $lz_estimate_det_id = $rs[0]['ID'];
           $insert_est_det = $this->db->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $lz_estimate_id, $component, $compQty[$i], $compAmount[$i], $ebayFee[$i], $payPalFee[$i], $shipFee[$i], $tech_condition[$i], NULL, NULL, NULL, NULL, $compAvgPrice[$i],$partsCatalgid[$i])");
            
          $i++;
        } /// end foreach
        if($insert_est_det == true || $insert_est_det ==true){
              return 1;
            }else {
                return 2;
              }
     	 }
      }
      
    } // end main if    
  }
  public function getAllObjects(){
     $sql = "SELECT DISTINCT O.OBJECT_ID, O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O";
     $query = $this->db->query($sql);
     $query = $query->result_array();
     return $query;
  }
 public function addtokit() {
  $parts_catalogue_id = $this->input->post('partCatalogueId');
  $catalogue_mt_id = $this->input->post('catalogueId');
  $category_id = $this->input->post('categoryId');
  $object_name = strtoupper($this->input->post('objectName'));
  $object_input  = trim(strtoupper($this->input->post("objectInput")));
  $object_input  = str_replace("'","''", $object_input);
  $dd_Object_Id = $this->input->post("ddObjectId");
  $mpn_desc  = trim($this->input->post("mpnDesc"));
  $mpn_desc  = str_replace("'","''", $mpn_desc);
  //$mpn  = trim($this->input->post("component_mpn"));
  $mpn  = trim($this->input->post("inputText"));
  $mpn  = str_replace("'","''", $mpn);
  $flag = '';
  //var_dump($mpn);exit;
  if(empty($object_name)){
      /*=========================================
      =            check object name            =
      =========================================*/
      
      if($dd_Object_Id == 0){ // check object id
        $check_object = $this->db->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$object_input' AND CATEGORY_ID = $category_id");
        if($check_object->num_rows() == 0){

          $get_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
          $get_pk = $get_pk->result_array();
          $object_id_pk = $get_pk[0]['OBJECT_ID'];
          if(empty($object_id_pk)){
            $object_id_pk = 1;
          }
          $insert_obj_qry = $this->db->query("INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID)VALUES($object_id_pk,'$object_input',sysdate,2,$category_id)");
        }else{
          $check_object = $check_object->result_array();
          $object_id_pk = $check_object[0]['OBJECT_ID'];
        }
      }else{
        $object_id_pk = $dd_Object_Id;
      }
      
      /*=====  End of check object name  ======*/
      
      /*==================================================
      =            insert mpn in catalogue_mt            =
      ==================================================*/
      
    $check_mpn = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn' AND CATEGORY_ID = $category_id");
    if($check_mpn->num_rows() == 0){
      
      $get_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
      $get_pk = $get_pk->result_array();
      $parts_catalogue_id = $get_pk[0]['CATALOGUE_MT_ID'];
      if(empty($parts_catalogue_id)){
          $parts_catalogue_id = 1;
        }
      $insert_mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED, LAST_RUN_TIME)VALUES($parts_catalogue_id,'$mpn',$category_id,sysdate,2,0,$object_id_pk,'$mpn_desc',0,null)");
    }else{
      $check_mpn = $check_mpn->result_array();
      $parts_catalogue_id = $check_mpn[0]['CATALOGUE_MT_ID'];
      $this->db->query("UPDATE LZ_CATALOGUE_MT SET OBJECT_ID = $object_id_pk WHERE CATALOGUE_MT_ID = $parts_catalogue_id");

    }


    /*=====  End of insert mpn in catalogue_mt  ======*/
  }
  if(!empty($object_name)){

  }elseif($dd_Object_Id != 0){
    $check_object = $this->db->query("SELECT UPPER(OBJECT_NAME) OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE OBJECT_ID = $dd_Object_Id");
    $check_object = $check_object->result_array();
    $object_name = $check_object[0]['OBJECT_NAME'];
  }elseif(!empty($object_input)){
    $object_name = $object_input;
  }
  $check_qry = $this->db->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND M.PART_CATLG_MT_ID = $parts_catalogue_id AND UPPER(O.OBJECT_NAME) = '$object_name' AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID");
  if($check_qry->num_rows() == 0){
  	
    $get_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') MPN_KIT_MT_ID FROM DUAL");
    $get_pk = $get_pk->result_array();
    $mpn_kit_mt_id = $get_pk[0]['MPN_KIT_MT_ID'];
    if(empty($mpn_kit_mt_id)){
          $mpn_kit_mt_id = 1;
        }
    $insert_mt_qry = $this->db->query("INSERT INTO LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID, CATALOGUE_MT_ID, QTY, PART_CATLG_MT_ID)VALUES($mpn_kit_mt_id,$catalogue_mt_id,1,$parts_catalogue_id)");
    if($insert_mt_qry){
      $flag = 1;
    }else{
      $flag = 0;
    }
  }else{
    $check_qry = $check_qry->result_array();
    $mpn_kit_mt_id = $check_qry[0]['MPN_KIT_MT_ID'];
    /*=====================================================
    =            check if alt mpn exist or not            =
    =====================================================*/
    $check_alt_qry = $this->db->query("SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id");

    if($check_alt_qry->num_rows() > 0){
      $check_alt_qry = $this->db->query("SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id AND CATALOGUE_MT_ID = $parts_catalogue_id");
      if($check_alt_qry->num_rows() == 0){
        $get_alt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') MPN_KIT_ALT_MPN FROM DUAL");
        $get_alt_pk = $get_alt_pk->result_array();
        $mpn_kit_alt_mpn = $get_alt_pk[0]['MPN_KIT_ALT_MPN'];
        if(empty($mpn_kit_alt_mpn)){
          $mpn_kit_alt_mpn = 1;
        }
        $insert_alt_qry = $this->db->query("INSERT INTO LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID)VALUES($mpn_kit_alt_mpn,$mpn_kit_mt_id,$parts_catalogue_id)");
        if($insert_alt_qry){
          $flag = 1;
        }else{
          $flag = 0;
        }
      }else{
        $flag = 2;
      } 

    }else{
      $flag = 2;
    }    
    
    
    /*=====  End of check if alt mpn exist or not  ======*/
  }//if else close

  ///////////////APPEND ROW SECTION START/////////////////////////
  if ($flag == 1) {
       $results = $this->db->query("SELECT M.*, C.MPN, C.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID =  $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND m.PART_CATLG_MT_ID = $parts_catalogue_id UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT O, LZ_BD_MPN_KIT_MT M WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $parts_catalogue_id"); 

      $result = $results->result_array();

      $total = $this->db->query("SELECT M.*,C.MPN,  C.MPN_DESCRIPTION, O.OBJECT_NAME  FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID=C.OBJECT_ID  AND O.CATEGORY_ID = C.CATEGORY_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID  UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID=C.OBJECT_ID AND O.CATEGORY_ID = C.CATEGORY_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");
    $total_components = $total->result_array();
    $totals = count($total_components);

  $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals, 'flag' => $flag);
  }else {
    return array('flag' => $flag);
  }
}
public function search_component(){
    $input_text  = trim(strtoupper($this->input->post("input_text")));
    $input_text  = str_replace("'","''", $input_text);
    $data_source  = $this->input->post("data_source");
    $data_status  = $this->input->post("data_status");
    $parm_text = '';

    
    $str  = explode(' ', $input_text);
    if (is_array($str) && count($str) > 1){
      foreach ($str as $value) {
          $parm_text .= " AND UPPER(TITLE) LIKE '%". $value . "%'";
      }
    }else{
      $parm_text .= " AND UPPER(TITLE) LIKE '%". $input_text . "%'";
    }
    //$cat_id      = $this->input->post("cat_id");
    //var_dump($cat_id ,$input_text); exit;
    // if($data_source == 'CATAG'){
    //   $table_name = 'ALL_SOLD_DATA_VIEW';
    // }elseif($data_source == 'ACTIVE'){
    //   $table_name = 'ALL_KIT_ACTIVE_DATA';
    // }

    
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
    $columns     = array(
      // datatable column index  => database column name
      0 => 'ACTION',
      1 => 'OBJECT_NAME',
      2 => 'CATEGORY_ID',
      3 => 'TITLE',
      4 => 'MPN',
      5 => 'SALE_PRICE'
    );
    $sql = "SELECT 'NULL' ACTION, BD.LZ_BD_CATA_ID, BD.TITLE, BD.CATEGORY_ID, BD.CONDITION_ID, BD.SALE_PRICE, M.MPN, M.CATALOGUE_MT_ID, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME, AV.AVG_PRICE AVG_PRICE FROM ALL_KIT_".$data_source."_DATA BD, LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE AV WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID(+) AND M.OBJECT_ID = O.OBJECT_ID(+) AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.VERIFIED = $data_status $parm_text";

    $query         = $this->db->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    $sql = "SELECT 'NULL' ACTION, BD.LZ_BD_CATA_ID, BD.TITLE, BD.CATEGORY_ID, BD.CONDITION_ID, BD.SALE_PRICE, M.MPN, M.CATALOGUE_MT_ID, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME, av.avg_price avg_price FROM ALL_KIT_".$data_source."_DATA BD, LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE AV WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID(+) AND M.OBJECT_ID = O.OBJECT_ID(+) AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.VERIFIED = $data_status $parm_text"; 
    if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( O.OBJECT_NAME LIKE '%".trim($requestData['search']['value'])."%' ";
          $sql.=" OR BD.TITLE LIKE '%".trim($requestData['search']['value'])."%' ";  
          $sql.=" OR BD.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR M.MPN LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR BD.SALE_PRICE LIKE '%".trim($requestData['search']['value'])."%' )";
      }
      //$sql.=" ORDER BY TIME_DIFF DESC";
    // when there is no search parameter then total number rows = total number filtered rows. 
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //$sql           = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM  ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
    $query         = $this->db->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData; ////
   $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
   //print_r($sql);
   //exit;


    //echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query         = $this->db->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/

    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $catalogue_mt_id = $row['CATALOGUE_MT_ID'];
      $object_name = $row['OBJECT_NAME'];
      $avg_price = $row['AVG_PRICE'];
      if(!$data_status){
        $fetch_object = '<input style="margin-left: 5px;" type = "button" id = "fetch_object" avg="'.$avg_price.'" name = "'.$i.'" class = "btn btn-info btn-sm fetchobject pull-left" value = "Fetch Object" style="margin-left:12px;">';
      }else{
        $fetch_object = "";
      }
      $nestedData[] ='<div style="width:168px;"><input type = "button" id = "'.$catalogue_mt_id.'" avg="'.$avg_price.'" name = "'.$i.'" class = "btn btn-success btn-sm addtokit pull-left" value = "Add to Kit">'.$fetch_object.'<input type = "hidden" name = "'.$object_name.'" id = "object_name_'.$i.'" value = "'.$object_name.'"></div>';
      $nestedData[] = '<div style="width:239px;">'.$row['OBJECT_NAME'].'</div>';
      $nestedData[] = $row['CATEGORY_ID'];
      $nestedData[] = '<div style="width:600px;"> <input style="width:100%;" type = "text" class="form-control" id = "input_title" name = "input_title" value = "'.htmlentities($row['TITLE']).'"></div>';
      //$nestedData[] = $row['TITLE'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['SALE_PRICE']; 
      $data[] = $nestedData;
      $i++ ;
    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
   public function get_cond_base_price(){
     $kitmpn_id        = $this->input->post('kitmpn_id');
     $condition_id     = $this->input->post('condition_id');
     //var_dump($kitmpn_id, $condition_id); exit;

     return $this->db->query("SELECT * FROM MPN_AVG_PRICE M WHERE M.CATALOGUE_MT_ID = $kitmpn_id   AND M.CONDITION_ID =  $condition_id")->result_array(); 
     /*if (count($data) > 0) {
       return $data;
     }else {
       return $data=['AVG_PRICE'=>''];
     }*/
  }
}
