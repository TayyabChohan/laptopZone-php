<?php  

	class M_Reciving extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function reciv_get_data(){
		$qr =$this->db->query("SELECT TO_CHAR(SYSDATE, 'MM/DD/YYYY') SYSTEMDATE FROM DUAL"); 
		$sys=$qr->result_array();
		$sysdate = $sys[0]['SYSTEMDATE'];

		$this->session->set_userdata('system_date', $sysdate);

		$tracking_no= strtoupper(trim($this->input->post('tracking_no')));
			 
			$sql2 = "SELECT D.LZ_BD_CATA_ID, D.CATEGORY_ID, D.COST_PRICE, D.LZ_ESTIMATE_ID  FROM LZ_BD_TRACKING_NO D , LZ_BD_ESTIMATE_MT MT WHERE UPPER(TRACKING_NO) = '$tracking_no' and (lz_single_entry_id is not null or LZ_MANIFEST_ID is not null)  AND (LZ_SINGLE_ENTRY_ID IS NOT NULL OR LZ_MANIFEST_ID IS NOT NULL) AND D.LZ_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID AND MT.PARTIAL_STATUS <> 1   ";

 

			 $trck_no2 = $this->db->query($sql2)->result_array();

			$sql = "SELECT LZ_BD_CATA_ID,CATEGORY_ID,COST_PRICE, LZ_SINGLE_ENTRY_ID,LZ_MANIFEST_ID FROM LZ_BD_TRACKING_NO  WHERE UPPER(TRACKING_NO) = '$tracking_no' ";
			 $trck_no = $this->db->query($sql)->result_array();
			//var_dump(count($trck_no2)); exit;
			 if(count($trck_no2) > 0){
			 	$lz_single_entry_id = $trck_no[0]['LZ_SINGLE_ENTRY_ID'];
			 	$lz_manifest_id = $trck_no[0]['LZ_MANIFEST_ID'];

			 	//var_dump($lz_single_entry_id,$lz_manifest_id);
			 	
			 	if(!empty($lz_single_entry_id)){
			 				 	
			 	$manifest = $this->db->query("SELECT MF.LZ_MANIFEST_ID FROM LZ_MANIFEST_MT MF WHERE MF.SINGLE_ENTRY_ID = $lz_single_entry_id")->result_array();
			 	 $manifest_id = $manifest[0]['LZ_MANIFEST_ID'];
			 	 $single_entry = $this->db->query("SELECT S.*, B.BARCODE_NO, MANF.EBAY_ITEM_ID, MANF.LZ_MANIFEST_ID, MANF.ITEM_ID, MANF.CONDITION_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M, LZ_BARCODE_MT B, (SELECT DISTINCT B.LZ_MANIFEST_ID, B.EBAY_ITEM_ID, B.ITEM_ID, B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.LZ_MANIFEST_ID IN (SELECT M.LZ_MANIFEST_ID FROM LZ_SINGLE_ENTRY S, LZ_MANIFEST_MT M WHERE M.SINGLE_ENTRY_ID = S.ID) AND B.EBAY_ITEM_ID IS NULL) MANF WHERE M.SINGLE_ENTRY_ID = S.ID AND MANF.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.POS_ONLY = 0 AND M.LZ_MANIFEST_ID = $manifest_id ORDER BY S.PURCHASE_DATE DESC ")->result_array();
			 	 

			 	 // added by adil asad on 1-feb-2018
				$old_sql = "SELECT LZ_BD_CATA_ID,CATEGORY_ID,COST_PRICE, LZ_SINGLE_ENTRY_ID FROM LZ_BD_TRACKING_NO  WHERE UPPER(TRACKING_NO) = '$tracking_no' ";
			 $old_trck_no = $this->db->query($old_sql)->result_array();
			 $LZ_BD_CATA_ID = $old_trck_no[0]['LZ_BD_CATA_ID'];
			 $COST_PRICE = $old_trck_no[0]['COST_PRICE'];

			 $sql = "SELECT UPPER(A.TRACKING_NO) TRACKING_NO, TO_CHAR(SYSDATE, 'MM/DD/YYYY') RECEIVED_ON,A.ITEM_URL, A.EBAY_ID,A.TITLE,A.CONDITION_NAME,A.CONDITION_ID,A.COST_PRICE ,C.MPN,A.LZ_BD_CATA_ID,ES.KIT_LOT ";
			 $sql.=" FROM LZ_BD_ACTIVE_DATA A,";
			 $sql.=" LZ_CATALOGUE_MT C ,LZ_BD_ESTIMATE_MT ES WHERE LZ_BD_CATA_ID = $LZ_BD_CATA_ID AND A.LZ_BD_CATA_ID = ES.LZ_BD_CATAG_ID(+) AND A.CATALOGUE_MT_ID=C.CATALOGUE_MT_ID(+)";
			 $old_ebay_id = $this->db->query($sql)->result_array();
			 return array('single_entry'=>$single_entry, 'exist'=>true,'old_ebay_id'=>$old_ebay_id,'COST_PRICE'=>$COST_PRICE);
			 
			}else{
				$manifest_id = $trck_no[0]['LZ_MANIFEST_ID'];
				
				//coment by adil 2-28-2018
			 	$lot_barcodes = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, V.ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.ITEM_ID, B.UNIT_NO")->result_array(); 

				$old_sql = "SELECT LZ_BD_CATA_ID,CATEGORY_ID,COST_PRICE, LZ_SINGLE_ENTRY_ID FROM LZ_BD_TRACKING_NO  WHERE UPPER(TRACKING_NO) = '$tracking_no' ";
			 $old_trck_no = $this->db->query($old_sql)->result_array();
			 $LZ_BD_CATA_ID = $old_trck_no[0]['LZ_BD_CATA_ID'];
			 $COST_PRICE = $old_trck_no[0]['COST_PRICE'];

			 $old_ebay_id = $this->db->query("SELECT UPPER(A.TRACKING_NO) TRACKING_NO,'1' AVAILABLE_QTY, TO_CHAR(SYSDATE, 'MM/DD/YYYY') RECEIVED_ON,A.ITEM_URL, A.EBAY_ID,A.TITLE,A.CONDITION_NAME,A.CONDITION_ID,A.COST_PRICE ,C.MPN,A.LZ_BD_CATA_ID,ES.KIT_LOT FROM LZ_BD_ACTIVE_DATA A, LZ_CATALOGUE_MT C ,LZ_BD_ESTIMATE_MT ES WHERE LZ_BD_CATA_ID = $LZ_BD_CATA_ID AND A.LZ_BD_CATA_ID = ES.LZ_BD_CATAG_ID(+) AND A.CATALOGUE_MT_ID=C.CATALOGUE_MT_ID(+)")->result_array();

			 return array( 'lot_barcodes' =>$lot_barcodes, 'exist'=>false,'old_ebay_id'=>$old_ebay_id,'COST_PRICE'=>$COST_PRICE);
			 //added by adil asad on 1-feb-2018


			} 
			 	
			 
			 }
			 else if (count($trck_no) > 0){
			  $LZ_BD_CATA_ID = $trck_no[0]['LZ_BD_CATA_ID'];
			 $CATEGORY_ID = $trck_no[0]['CATEGORY_ID'];
			 $COST_PRICE = $trck_no[0]['COST_PRICE'];
			 //var_dump($COST_PRICE); exit;
			 $lz_single_entry_id = $trck_no[0]['LZ_SINGLE_ENTRY_ID'];
			 $catalogue_mt_ids = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_BD_ACTIVE_DATA WHERE LZ_BD_CATA_ID = $LZ_BD_CATA_ID")->result_array();
			 $catalogue_mt_id = $catalogue_mt_ids[0]['CATALOGUE_MT_ID'];
			/* $mpns = $this->db->query("SELECT MPN FROM LZ_CATALOGUE_MT WHERE CATALOGUE_MT_ID = $catalogue_mt_id")->result_array();
			 $mpn = $mpns[0]['MPN'];*/
			 if(!empty($catalogue_mt_id)){
			 $brands = $this->db->query("SELECT D.CATALOGUE_MT_ID, UPPER(DT.SPECIFIC_VALUE) SPECIFIC_VALUE FROM LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  MT, CATEGORY_SPECIFIC_DET DT WHERE MT.MT_ID = DT.MT_ID AND DT.DET_ID = D.SPECIFIC_DET_ID AND UPPER(MT.SPECIFIC_NAME) = 'BRAND' AND D.CATALOGUE_MT_ID = $catalogue_mt_id")->result_array();

			 if (count($brands) > 0) {
			  	@$specific_value = @$brands[0]['SPECIFIC_VALUE'];
			  }else {
			  	@$specific_value = '';
			  }
			}else{
				@$specific_value = '';
			}
			 $bd_cata_id = $this->db->query("SELECT UPPER(A.TRACKING_NO) TRACKING_NO,A.CATEGORY_ID CATEGORY_ID,LZ_BD_CATA_ID BD_CATA_ID, TO_CHAR(SYSDATE, 'MM/DD/YYYY') RECEIVED_ON,A.ITEM_URL, A.EBAY_ID,A.TITLE,A.CONDITION_NAME,A.CONDITION_ID,A.COST_PRICE ,C.MPN,A.LZ_BD_CATA_ID,ES.KIT_LOT FROM LZ_BD_ACTIVE_DATA A,LZ_CATALOGUE_MT C ,LZ_BD_ESTIMATE_MT ES WHERE LZ_BD_CATA_ID = $LZ_BD_CATA_ID AND A.LZ_BD_CATA_ID = ES.LZ_BD_CATAG_ID(+) AND A.CATALOGUE_MT_ID=C.CATALOGUE_MT_ID(+)")->result_array();
			 $get_bd_cata_id = $bd_cata_id[0]['BD_CATA_ID'];

			 $get_lot_estimate = $this->db->query("SELECT MT.KIT_LOT,M.UPC, M.BRAND MANUFAC, DT.LOT_ID, DT.LZ_ESTIMATE_DET_ID, upper(M.MPN) MPN, M.MPN_DESCRIPTION,O.OBJECT_ID, O.OBJECT_NAME, DT.QTY, DT.TECH_COND_ID, DT.EST_SELL_PRICE, DT.EBAY_FEE, DT.PAYPAL_FEE, DT.SHIPPING_FEE,  nvl(DT.SOLD_PRICE,0) SOLD_PRICE, DT.PART_CATLG_MT_ID, MT.LOT_OFFER_AMOUNT,CON.COND_NAME FROM LZ_CATALOGUE_MT    M, LZ_BD_OBJECTS_MT   O, MPN_AVG_PRICE      A, LZ_BD_ESTIMATE_MT  MT, LZ_BD_ESTIMATE_DET DT,LZ_ITEM_COND_MT  CON WHERE M.OBJECT_ID = O.OBJECT_ID AND (DT.POST_STATUS  IS NULL OR DT.POST_STATUS = 1)  AND DT.MANIFEST_DET_ID IS NULL AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.TECH_COND_ID = A.CONDITION_ID(+) AND MT.LZ_BD_CATAG_ID = $get_bd_cata_id AND DT.TECH_COND_ID = CON.ID(+) /*AND MT.KIT_LOT = 'L'*/   ORDER BY DT.LZ_ESTIMATE_DET_ID ASC ")->result_array();
			  $get_conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();


			 	return array('bd_cata_id'=>$bd_cata_id,'COST_PRICE'=>$COST_PRICE, 'SPECIFIC_VALUE'=>$specific_value, 'get_lot_estimate'=>$get_lot_estimate, 'get_conditions'=>$get_conditions);
			 }else{
			 	return false;
			 }		
	}

	public function reciv_post(){
		$comma = ',';
		//$tracking_no 			= strtoupper(trim($this->input->post('tracking_no')));
		$tracking_id 			= strtoupper(trim($this->input->post('tracking_id')));
		$shipping 				= trim($this->input->post('shipping'));
		$COST_PRICE 			= trim($this->input->post('cost_price'));
		$mpn 					= trim($this->input->post('waiting_mpn'));
		$Quantity 				= trim($this->input->post('Quantity'));
		$received_on 			= trim($this->input->post('received_on'));
		$skip_test 				= trim($this->input->post('skip_test'));
		$manufacturer 			= strtoupper(trim($this->input->post('manufacturer')));
		
	    $received_on 			= "TO_DATE('".$received_on."', 'MM/DD/YYYY')";

	    $insert_by = $this->session->userdata('user_id');  
    	date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
    	$insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

		$sql = "SELECT LZ_BD_CATA_ID,CATEGORY_ID FROM LZ_BD_TRACKING_NO  WHERE tracking_id = $tracking_id AND LZ_SINGLE_ENTRY_ID IS NULL ";
			$trck_no = $this->db->query($sql)->result_array();
			$LZ_BD_CATA_ID = $trck_no[0]['LZ_BD_CATA_ID'];
			$CATEGORY_ID = $trck_no[0]['CATEGORY_ID'];
			 
			$sql = "SELECT * "; 
			$sql.=" from lz_bd_active_data";
			$sql .=" where LZ_BD_CATA_ID = $LZ_BD_CATA_ID ";
			$active_data = $this->db->query($sql);
			if ($active_data->num_rows() > 0) {
			$bd_cata_id = $active_data->result_array();	
				
			$LZ_BD_CATA_ID =$bd_cata_id[0]['LZ_BD_CATA_ID'];
			$CATEGORY_ID =$bd_cata_id[0]['CATEGORY_ID'];

			//added by adil asad on 1-feb-2018
			
			$mpn_check = $this->db->query("SELECT CATALOGUE_MT_ID, OBJECT_ID,MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn' AND CATEGORY_ID = $CATEGORY_ID");

	      if($mpn_check->num_rows() == 0){

	        $get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
	        //$get_mt_pk = $this->db->query("SELECT MAX(CATALOGUE_MT_ID + 1) CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT");
	        $get_pk = $get_mt_pk->result_array();
	        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

	        $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND) VALUES($cat_mt_id, '$mpn', $CATEGORY_ID, $insert_date, $insert_by,null,'$mpn','$manufacturer')");
	        //echo "yes";        
	      }else{
	        $get_pk = $mpn_check->result_array();
	        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];
	        $mpn = $get_pk[0]['MPN'];
	        //$object_id = $get_pk[0]['OBJECT_ID'];
	        //$get_brand = $get_pk[0]['BRAND'];
	        $this->db->query("UPDATE LZ_CATALOGUE_MT SET BRAND = '$manufacturer' WHERE CATALOGUE_MT_ID =$cat_mt_id ");
		      }
			//added by adil asad on 1-feb-2018

			$EBAY_ID = $bd_cata_id[0]['EBAY_ID'];
			$DESC = $bd_cata_id[0]['TITLE'];
			$TITLE = trim(str_replace("  ", ' ', $DESC));
          	$TITLE = str_replace(array("`,′"), "", $TITLE);
          	$TITLE = str_replace(array("'"), "''", $TITLE);
			
			$SALE_PRICE = $bd_cata_id[0]['SALE_PRICE'];
			//$COST_PRICE = $bd_cata_id[0]['COST_PRICE'];
			$SELLER_ID = $bd_cata_id[0]['SELLER_ID'];
			
			$CATEGORY_NAME= $bd_cata_id[0]['CATEGORY_NAME'];
			$CATEGORY_NAME = trim(str_replace("  ", ' ', $CATEGORY_NAME));
          	$CATEGORY_NAME = str_replace(array("`,′"), "", $CATEGORY_NAME);
          	$CATEGORY_NAME = str_replace(array("'"), "''", $CATEGORY_NAME);			
			$CONDITION_ID= $bd_cata_id[0]['CONDITION_ID'];
			//var_dump($CONDITION_ID, $skip_test);exit;
			$CONDITION_NAME= $bd_cata_id[0]['CONDITION_NAME'];
			$CATEGORY_ID= $bd_cata_id[0]['CATEGORY_ID'];
			 // var_dump($CONDITION_NAME);
			 // exit;
			$supp = $this->db->query("SELECT SUPPLIER_ID FROM SUPPLIER_MT WHERE COMPANY_NAME LIKE '%$SELLER_ID%' ");
			//$supp = $supp->result_array();
			//print_r($supp);exit;
			// var_dump($supp);
			// exit;
			if($supp->num_rows() == 0){
				$query = $this->db->query("SELECT get_single_primary_key('SUPPLIER_MT','SUPPLIER_ID') SUPPLIER_ID FROM DUAL");
			$SUP_ID = $query->result_array();
			$SUPPLIER_ID = $SUP_ID[0]['SUPPLIER_ID'];
			$sup_quer  = "INSERT INTO SUPPLIER_MT (SUPPLIER_ID,SUPPLIER_CODE,COMPANY_NAME,SHORT_DESC,SUPP_CATAG_ID,TAX_EXEMPT_YN,REGULAR_SUPPLIER_YN,DEF_ACCT_SETTLEMENT,SUPP_TAX_CAT_ID) VALUES($SUPPLIER_ID,$SUPPLIER_ID,'$SELLER_ID','$SELLER_ID',1,0,0,1,1)"; 
			$this->db->query($sup_quer);
			 
			}else{
				$supp_id = $supp->result_array();
				$SUPPLIER_ID = $supp_id[0]['SUPPLIER_ID'];
			}
		  	//      $purchase_date= "TO_DATE('".$purchase_date."', 'MM/DD/YYYY')";
		  	// 		var_dump($received_on);
			//      exit;
		   
		  $query = $this->db->query("SELECT get_single_primary_key('LZ_SINGLE_ENTRY','ID') ID FROM DUAL");
	      $rs = $query->result_array();

	      $loading_no = $rs[0]['ID'];
	      // var_dump($loading_no."-".$CONDITION_NAME);
	      // EXIT;
		  //var_dump($loading_no."-".$purch_ref."-".$suplier_desc."-".$remarks."-".$purchase_date);exit;

			/*=============================================
			=            Create auto Purchase Ref No.     =
			=============================================*/
		  $query = $this->db->query("SELECT PURCHASE_REF_NO FROM LZ_SINGLE_ENTRY WHERE id = (SELECT max(id) FROM LZ_SINGLE_ENTRY)");
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
     	$cat_name_qry = $this->db->query("select c.category_name, c.parent_cat_id from lz_bd_category_tree c where c.category_id = $CATEGORY_ID");
	        $cat_name_qry = $cat_name_qry->result_array();
	        $category_name = $cat_name_qry[0]['CATEGORY_NAME'];
			$category_name = trim(str_replace("  ", ' ', $category_name));
          	$category_name = str_replace(array("`,′"), "", $category_name);
          	$category_name = str_replace(array("'"), "''", $category_name);		        			
	        $sub_parent_id = $cat_name_qry[0]['PARENT_CAT_ID'];
	        $sub_cat_qry = $this->db->query("select c.category_name, c.parent_cat_id from lz_bd_category_tree c where c.category_id = $sub_parent_id");
	        $sub_cat_qry = $sub_cat_qry->result_array();
	        $sub_cat_name = $sub_cat_qry[0]['CATEGORY_NAME'];
			$sub_cat_name = trim(str_replace("  ", ' ', $sub_cat_name));
          	$sub_cat_name = str_replace(array("`,′"), "", $sub_cat_name);
          	$sub_cat_name = str_replace(array("'"), "''", $sub_cat_name);			        			
	        $main_parent_id = $sub_cat_qry[0]['PARENT_CAT_ID'];
			// var_dump($main_parent_id);
			// exit;
	        $main_cat_qry = $this->db->query("select c.category_name from lz_bd_category_tree c where c.category_id = $main_parent_id");
	        $main_cat_qry = $main_cat_qry->result_array();
	        $main_cat_name = $main_cat_qry[0]['CATEGORY_NAME'];
			$main_cat_name = trim(str_replace("  ", ' ', $main_cat_name));
          	$main_cat_name = str_replace(array("`,′"), "", $main_cat_name);
          	$main_cat_name = str_replace(array("'"), "''", $main_cat_name);
               /*============================================
               =            get upc if available            =
               ============================================*/
               $get_upc = "SELECT ITEM_MT_UPC UPC FROM (SELECT D.ITEM_MT_UPC, COUNT(1) CNT FROM LZ_MANIFEST_DET D WHERE UPPER(D.ITEM_MT_MFG_PART_NO) = UPPER('$mpn') AND D.ITEM_MT_UPC IS NOT NULL GROUP BY D.ITEM_MT_UPC) ORDER BY CNT DESC"; 
               $upc = $this->db->query($get_upc)->result_array();
               if(count($upc)>0){
                    $item_upc = $upc[0]['UPC'];
               }else{
                    $item_upc ='';
               }

               /*=====  End of get upc if available  ======*/
               
               
               $qry_sef = "INSERT INTO LZ_SINGLE_ENTRY (ID, PURCHASE_REF_NO, SUPPLIER_ID, REMARKS, PURCHASE_DATE, SERIAL_NO, ITEM_MT_MANUFACTURE, LIST_DATE, PO_DETAIL_LOT_REF, ITEM_MT_UPC, ITEM_MT_BBY_SKU, PRICE, PO_DETAIL_RETIAL_PRICE, ITEM_MT_MFG_PART_NO, ITEM_MT_DESC, MAIN_CATAGORY_SEG1, SUB_CATAGORY_SEG2, BRAND_SEG3, ORIGIN_SEG4, CONDITIONS_SEG5, AVAILABLE_QTY, WEIGHT_KG, EBAY_ITEM_ID, LISTER, PO_MT_REF_NO, JOB_NO, CATEGORY_ID, OLD_BARCODE, POS_ONLY ) VALUES($loading_no $comma '$purch_ref'$comma $SUPPLIER_ID $comma null $comma $received_on $comma null $comma '$manufacturer' $comma null $comma null $comma '$item_upc' $comma null $comma $SALE_PRICE $comma $COST_PRICE $comma '$mpn'$comma '$TITLE'$comma '$main_cat_name'$comma '$sub_cat_name'$comma '$CATEGORY_NAME'$comma 'U.S'$comma '$CONDITION_NAME'$comma $Quantity $comma null $comma null $comma null $comma null $comma null $comma $CATEGORY_ID $comma null $comma 0 )";
	    	//print_r($qry_sef);exit;
	        if($this->db->query($qry_sef)){
	        
	        $qry_id = "select m.lz_manifest_id,m.single_entry_id from lz_manifest_mt m where m.single_entry_id=$loading_no";
	    	//print_r($qry_sef);exit;
	        $query=$this->db->query($qry_id);
	        $rs = $query->result_array();
		    $lz_manifest_id = $rs[0]['LZ_MANIFEST_ID'];
		    
		    //* added by adil asad feb-1-2018
		    $this->db->query("UPDATE LZ_MANIFEST_MT SET MANIFEST_TYPE = 1 where LZ_MANIFEST_ID =$lz_manifest_id ");
		    //* added by adil asad feb-1-2018

			$trc_up = " UPDATE LZ_BD_TRACKING_NO SET LZ_SINGLE_ENTRY_ID = $loading_no,SHIPPING_CARRIER = '$shipping' WHERE TRACKING_ID ='$tracking_id'";
			$this->db->query($trc_up);


		    return array('manifest_id'=>$lz_manifest_id,'condition_id'=>$CONDITION_ID);

		    } //end if
		}else { /// end main if of check num rows of active_data
			return false;
		} 
			
	}	
	
	public function reciev_lot(){

		$comma = ',';
		$tracking_id = strtoupper(trim($this->input->post('tracking_id')));
		
		$check_quer = "SELECT T.CATEGORY_ID ,T.LZ_ESTIMATE_ID ,T.LZ_BD_CATA_ID FROM LZ_BD_TRACKING_NO T ,LZ_BD_ESTIMATE_MT E WHERE T.LZ_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID AND T.LZ_SINGLE_ENTRY_ID IS NULL AND T.TRACKING_ID = $tracking_id  AND UPPER(E.KIT_LOT) = 'L'";
		$check_quer = $this->db->query($check_quer)->result_array();
		
		$track_estimate_id = $check_quer[0]['LZ_ESTIMATE_ID'];
		$track_catagry_id = $check_quer[0]['CATEGORY_ID'];

		return array('track_estimate_id'=>$track_estimate_id,'track_catagry_id'=>$track_catagry_id);

		
	}

 	function lot_recive($track_estimate_id,$track_catagry_id)
    {
    	$insert_by = $this->session->userdata('user_id');
    	$query  = "call pro_lot_reciving($track_estimate_id,$insert_by)";
    	$query = $this->db->query($query);
    }
    public function lot_items(){

    	$query = $this->db->query("SELECT M.LZ_MANIFEST_ID, T.TRACKING_NO, T.COST_PRICE, T.CATEGORY_ID, E.LZ_BD_ESTIMATE_ID, E.KIT_LOT, M.MANIFEST_TYPE, AC.TITLE FROM LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    E, LZ_MANIFEST_MT       M, LZ_BD_ACTIVE_DATA AC WHERE T.LZ_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID AND T.LZ_BD_CATA_ID = AC.LZ_BD_CATA_ID AND E.LZ_BD_ESTIMATE_ID = M.EST_MT_ID  AND E.KIT_LOT = 'L' order by M.LZ_MANIFEST_ID DESC ")->result_array();

    	return array('query'=>$query);



    }

    public function lot_items_detail(){

    	$manifest_id = $this->uri->segment(4);

    	$master_query = $this->db->query("SELECT M.LZ_MANIFEST_ID,AC.EBAY_ID, AC.ITEM_URL, T.TRACKING_NO, T.COST_PRICE, T.CATEGORY_ID, E.LZ_BD_ESTIMATE_ID, E.KIT_LOT, M.MANIFEST_TYPE, AC.TITLE FROM LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    E, LZ_MANIFEST_MT       M, LZ_BD_ACTIVE_DATA AC WHERE T.LZ_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID AND T.LZ_BD_CATA_ID = AC.LZ_BD_CATA_ID AND E.LZ_BD_ESTIMATE_ID = M.EST_MT_ID and M.LZ_MANIFEST_ID= $manifest_id AND E.KIT_LOT = 'L' ")->result_array();

    	$query = $this->db->query("SELECT BA.BARCODE_NO, DE.LAPTOP_ITEM_CODE, I.ITEM_ID, DE.ITEM_MT_MFG_PART_NO MPN,
       MP.MPN_DESCRIPTION,'1' AVAILABLE_QTY,DE.PO_DETAIL_RETIAL_PRICE /*ED.EST_SELL_PRICE */ FROM LZ_MANIFEST_DET    DE, LZ_BD_ESTIMATE_DET ED, ITEMS_MT           I, LZ_BARCODE_MT      BA, LZ_CATALOGUE_MT MP WHERE DE.EST_DET_ID = ED.LZ_ESTIMATE_DET_ID AND DE.LAPTOP_ITEM_CODE = I.ITEM_CODE(+) AND I.ITEM_ID = BA.ITEM_ID(+) AND ED.PART_CATLG_MT_ID = MP.CATALOGUE_MT_ID AND DE.LZ_MANIFEST_ID =$manifest_id")->result_array();
 
    	return array('query'=>$query,'master_query'=>$master_query);

    }
	
			

	public function skip_test($lz_manifest_id, $condition_id){
      $skip_test = $this->input->post('skip_test');

      if($skip_test == 'Yes'){
 
		$skip_test = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = $condition_id WHERE  B.LZ_MANIFEST_ID = $lz_manifest_id");
                 
       }elseif($skip_test =='No'){
			//var_dump($CONDITION_ID, $lz_manifest_id, 'No'); 
		$skip_test = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = '' WHERE  B.LZ_MANIFEST_ID = $lz_manifest_id");
		}

     }
     /////////////////////
     public function get_autocomplete(){

			$search_data = $this->input->post('search_data');
			return $get_tracking_no = $this->db->query("SELECT T.TRACKING_ID, UPPER(T.TRACKING_NO) TRACKING_NO FROM LZ_BD_TRACKING_NO T WHERE UPPER(T.TRACKING_NO) TRACKING_NO LIKE '%$search_data%'")->result_array();
		}
	public function get_tracking_nos(){

		return $this->db->query("SELECT * FROM (SELECT T.TRACKING_NO, T.COST_PRICE, T.CATEGORY_ID, AC.EBAY_ID, AC.TITLE, AC.ITEM_URL, T.LZ_SINGLE_ENTRY_ID FROM LZ_BD_TRACKING_NO T, LZ_BD_ACTIVE_DATA AC WHERE T.LZ_SINGLE_ENTRY_ID IS NULL AND T.LZ_BD_CATA_ID = AC.LZ_BD_CATA_ID(+) AND T.TRACKING_NO IS NOT NULL ORDER BY T.TRACKING_ID DESC ) WHERE ROWNUM <= 15")->result_array(); }


        public function lotItems_print($lz_manifest_id){
		//======================== Print Sticker tab Start =============================//

		//$print_qry = "select t. from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.STICKER_PRINT = 0";
		//$print_qry = "SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, V.ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, V.AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(LD.PO_DETAIL_RETIAL_PRICE NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE ) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.ITEM_ID, B.UNIT_NO";
		//

		//$print_qry = "SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, DET.CONDITIONS_SEG5 ITEM_CONDITION, IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, DET.ITEM_MT_UPC UPC, '1' AVAIL_QTY, IM.ITEM_ID, B.LZ_MANIFEST_ID, DET.LAPTOP_ITEM_CODE LAPTOP_ITEM_CODE, NVL(DET.PO_DETAIL_RETIAL_PRICE / DET.AVAILABLE_QTY, 0) PO_DETAIL_RETIAL_PRICE FROM LZ_BARCODE_MT B, ITEMS_MT IM, LZ_MANIFEST_DET DET WHERE B.LZ_MANIFEST_ID = $lz_manifest_id AND B.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = DET.LAPTOP_ITEM_CODE ORDER BY B.BARCODE_NO";
		// $print_qry = "SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, DET.CONDITIONS_SEG5 ITEM_CONDITION, IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, (SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = ES.PART_CATLG_MT_ID) UPC, /*DET.ITEM_MT_UPC UPC,*/ '1' AVAIL_QTY, IM.ITEM_ID, B.LZ_MANIFEST_ID, DET.LAPTOP_ITEM_CODE LAPTOP_ITEM_CODE, NVL(DET.PO_DETAIL_RETIAL_PRICE / DET.AVAILABLE_QTY, 0) PO_DETAIL_RETIAL_PRICE FROM LZ_BARCODE_MT B, ITEMS_MT IM, LZ_MANIFEST_DET DET, LZ_BD_ESTIMATE_DET ES WHERE B.LZ_MANIFEST_ID = $lz_manifest_id AND B.ITEM_ID = IM.ITEM_ID AND DET.EST_DET_ID = ES.LZ_ESTIMATE_DET_ID AND IM.ITEM_CODE = DET.LAPTOP_ITEM_CODE ORDER BY B.BARCODE_NO";
		$print_qry = "SELECT V.PO_DETAIL_RETIAL_PRICE, B.UNIT_NO, B.BARCODE_NO IT_BARCODE, B.PRINT_STATUS, V.ITEM_CONDITION, V.ITEM_MT_DESC, V.MANUFACTURER, V.MFG_PART_NO, V.UPC, '1' AVAIL_QTY, V.ITEM_ID, V.LZ_MANIFEST_ID, V.PURCH_REF_NO, V.LAPTOP_ITEM_CODE FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, MAX((SELECT MM.UPC FROM LZ_BD_ESTIMATE_DET D,LZ_CATALOGUE_MT MM WHERE D.LZ_ESTIMATE_DET_ID = LD.EST_DET_ID AND D.PART_CATLG_MT_ID = MM.CATALOGUE_MT_ID)) UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(NVL(LD.PO_DETAIL_RETIAL_PRICE / LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.BARCODE_NO ";

		//print_r($print_qry);exit;
		$print_qry =$this->db->query($print_qry);

		return $print_qry->result_array();


		//======================== Print Sticker tab End =============================// 
 }
 		public function lotitemsPrintForAll(){
 	//======================== Print Sticker tab Start =============================//
 		$lz_manifest_id = $this->uri->segment(4);
	//$print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE, SUBSTR(V.ITEM_MT_DESC, 1, 80) ITEM_DESC, 'LOT' LOT_NO, B.UNIT_NO, '1' LOT_QTY, V.MFG_PART_NO MPN, V.UPC FROM LZ_BARCODE_MT B, (SELECT IM.ITEM_DESC ITEM_MT_DESC, IM.ITEM_MT_MANUFACTURE MANUFACTURER, IM.ITEM_MT_BBY_SKU, MAX((SELECT MM.UPC FROM LZ_BD_ESTIMATE_DET D, LZ_CATALOGUE_MT MM WHERE D.LZ_ESTIMATE_DET_ID = LD.EST_DET_ID AND D.PART_CATLG_MT_ID = MM.CATALOGUE_MT_ID)) UPC, IM.ITEM_MT_MFG_PART_NO MFG_PART_NO, IM.ITEM_CONDITION, LD.LAPTOP_ITEM_CODE, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, SUM(NVL(LD.PO_DETAIL_RETIAL_PRICE / LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, IM.ITEM_CODE FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY IM.ITEM_DESC, IM.ITEM_MT_MANUFACTURE, LD.LAPTOP_ITEM_CODE, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, LM.PURCHASE_DATE, LM.LOADING_NO, LM.LOADING_DATE, IM.ITEM_MT_BBY_SKU, IM.ITEM_MT_UPC, IM.ITEM_MT_MFG_PART_NO, IM.ITEM_CONDITION, IM.ITEM_CODE) V WHERE B.ITEM_ID = V.ITEM_ID AND B.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.BARCODE_NO ");
	$print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE,  SUBSTR(DET.ITEM_MT_DESC, 1, 80) ITEM_DESC, et.ebay_id LOT_NO, B.UNIT_NO, '1' LOT_QTY, I.ITEM_MT_MFG_PART_NO MPN, (SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = ES.PART_CATLG_MT_ID) UPC FROM LZ_BARCODE_MT      B, ITEMS_MT           I, LZ_MANIFEST_DET    DET, LZ_BD_ESTIMATE_DET ES, lz_bd_estimate_mt em, lz_bd_active_data et WHERE B.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DET.LAPTOP_ITEM_CODE AND ES.LZ_ESTIMATE_DET_ID = DET.EST_DET_ID and em.lz_bd_estimate_id = es.lz_bd_estimate_id and em.lz_bd_catag_id = et.LZ_BD_CATA_ID AND B.LZ_MANIFEST_ID = $lz_manifest_id ORDER BY B.BARCODE_NO "); //var_dump($print_qry);exit; 
	return $print_qry->result_array();

 
 //======================== Print Sticker tab End =============================// 
 }  	
	public function manifest_sticker_print($item_code,$manifest_id,$barcode){
	    //$print_qry = $this->db->query("SELeECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE, SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'LOT' LOT_NO, B.UNIT_NO, '1' LOT_QTY, I.ITEM_MT_MFG_PART_NO MPN, (SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = ES.PART_CATLG_MT_ID)  UPC FROM  LZ_BARCODE_MT B, ITEMS_MT I,LZ_MANIFEST_DET DET,LZ_BD_ESTIMATE_DET ES WHERE B.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DET.LAPTOP_ITEM_CODE AND ES.LZ_ESTIMATE_DET_ID = DET.EST_DET_ID AND I.ITEM_CODE='$item_code' AND B.LZ_MANIFEST_ID = $manifest_id AND B.BARCODE_NO = $barcode");
		$print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE, SUBSTR(DET.ITEM_MT_DESC, 1, 80) ITEM_DESC, ET.EBAY_ID LOT_NO, B.UNIT_NO, '1' LOT_QTY, I.ITEM_MT_MFG_PART_NO MPN, (SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = ES.PART_CATLG_MT_ID) UPC FROM LZ_BARCODE_MT      B, ITEMS_MT           I, LZ_MANIFEST_DET    DET, LZ_BD_ESTIMATE_DET ES, LZ_BD_ESTIMATE_MT EM, LZ_BD_ACTIVE_DATA ET WHERE B.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE = DET.LAPTOP_ITEM_CODE AND ES.LZ_ESTIMATE_DET_ID = DET.EST_DET_ID AND EM.LZ_BD_ESTIMATE_ID = ES.LZ_BD_ESTIMATE_ID AND EM.LZ_BD_CATAG_ID = ET.LZ_BD_CATA_ID AND B.BARCODE_NO = $barcode"); 
		$query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");
	    //var_dump($print_qry);exit;
	    return $print_qry->result_array();
	  }


	  public function update_lot_mpn(){
	  	$insert_by = $this->session->userdata('user_id');  
	  date_default_timezone_set("America/Chicago");
	  $date = date('Y-m-d H:i:s');
	  $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

	  	$est_det_id = $this->input->post('est_det_id');	  	
	  	$part_mpn = $this->input->post('part_mpn');
	  	$part_mpn_desc = $this->input->post('part_mpn_desc');
	  	$item_upc = $this->input->post('item_upc');
	  	$item_manu = $this->input->post('item_manu');
	  	// var_dump($item_upc);
	  	// EXIT;
	  	$part_mpn_id = $this->input->post('part_mpn_id');
	  	$est_cond_id = $this->input->post('est_cond_id');
	  	$i=0;
	  	foreach ($est_det_id as $comp) {
	  		$part_mpn_de = strtoupper($part_mpn[$i]);
	  		$part_mpn_de = trim(str_replace("'","''", $part_mpn_de));

	  		@$get_item_upc =  $item_upc[$i];
	  		$get_mpn_desc = trim(str_replace("'","''", $part_mpn_desc[$i]));

	  		//$item_manufac = strtoupper($item_manu[$i]);
	  		$item_manufac = trim(str_replace("'","''", $item_manu[$i]));

	  		$mpn_part_id = $part_mpn_id[$i];
	  		//$est_det_id = $est_det_id[$i];	  			
	  	$get_mpn = $this->db->query("SELECT MT.CATALOGUE_MT_ID, upper(MT.MPN) MPN, MT.BRAND,MT.CATEGORY_ID, MT.MPN_DESCRIPTION,MT.OBJECT_ID FROM LZ_CATALOGUE_MT MT WHERE CATALOGUE_MT_ID =$mpn_part_id  ")->result_array();
	  	
	  	$get_mpn_nam = $get_mpn[0]['MPN'];
	  	
	  	$get_cataloge_id  = $get_mpn[0]['CATALOGUE_MT_ID'];
	  	$get_category  = $get_mpn[0]['CATEGORY_ID'];
	  	$get_obj_id  = $get_mpn[0]['OBJECT_ID'];

	  	if($get_mpn_nam  !==  $part_mpn_de ){

	  		// var_dump('tesst1');
	  		// exit;

	  	$check_mpn = $this->db->query("SELECT MT.CATALOGUE_MT_ID,MT.MPN GET_MPN FROM LZ_CATALOGUE_MT MT WHERE  upper(MT.MPN) = '$part_mpn_de' AND  MT.CATEGORY_ID = $get_category  ");

	if ($check_mpn->num_rows() > 0) {
		$check_mpn = $check_mpn->result_array();
		$check_mpn_id = $check_mpn[0]['CATALOGUE_MT_ID'];
		$get_est_new_mpn = $check_mpn[0]['GET_MPN'];
		$update_mpn = $this->db->query(" UPDATE LZ_BD_ESTIMATE_DET DE SET DE.MPN_DESCRIPTION ='$get_mpn_desc',	DE.PART_CATLG_MT_ID = '$check_mpn_id',DE.TECH_COND_ID = '$est_cond_id[$i]'  where DE.LZ_ESTIMATE_DET_ID = $est_det_id[$i] ");
	}
	else{
	$get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
    $get_pk = $get_mt_pk->result_array();
    $cat_mt_id = $get_pk[0]['ID'];

    $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$part_mpn_de', $get_category, $insert_date, $insert_by,$get_obj_id,'$get_mpn_desc','$item_manufac','$get_item_upc')");

    $get_new_mpn = $this->db->query("SELECT MT.CATALOGUE_MT_ID,upper(MT.MPN) GET_MPN  FROM LZ_CATALOGUE_MT MT WHERE CATALOGUE_MT_ID =$cat_mt_id ")->result_array();
    $get_cat_new_mpn = $get_new_mpn[0]['CATALOGUE_MT_ID'];
    $get_est_new_mpn = $get_new_mpn[0]['GET_MPN'];

    $update_mpn = $this->db->query(" UPDATE LZ_BD_ESTIMATE_DET DE SET DE.MPN_DESCRIPTION ='$get_mpn_desc' , DE.PART_CATLG_MT_ID = '$get_cat_new_mpn',DE.TECH_COND_ID = '$est_cond_id[$i]'  where DE.LZ_ESTIMATE_DET_ID = $est_det_id[$i] ");     
    } 
	  	}

	  	else{
 
	  		// var_dump('test');
	  		// exit;
	  		// if(!empty($get_item_upc)){
	  		// 	echo '1';
	  		$this->db->query(" UPDATE LZ_CATALOGUE_MT DE SET DE.MPN_DESCRIPTION = '$get_mpn_desc',DE.BRAND = '$item_manufac' ,DE.UPC = '$get_item_upc' where DE.CATALOGUE_MT_ID  =$mpn_part_id ");
	  		$this->db->query(" UPDATE LZ_BD_ESTIMATE_DET DE SET DE.TECH_COND_ID = '$est_cond_id[$i]' , DE.MPN_DESCRIPTION = '$get_mpn_desc', DE.ITEM_MANUFACTURER = '$item_manufac'  where DE.LZ_ESTIMATE_DET_ID = $est_det_id[$i] "); 

	  		//}else{ 

	  			// echo '2';
	  			// $this->db->query(" UPDATE ,LZ_CATALOGUE_MT DE SET DE.MPN_DESCRIPTION = '$get_mpn_desc',DE.UPC = '' where DE.CATALOGUE_MT_ID  =$mpn_part_id ");
	  		//}
	  	
	  	}	  	

      $i++;
    } 

	  }


	public function get_append_data(){

	$est_Det_id  =  $this->input->post('det_id');

	$get_lot_estimate = $this->db->query(" SELECT MT.KIT_LOT, M.UPC, DT.LZ_ESTIMATE_DET_ID, UPPER(M.MPN) MPN, M.MPN_DESCRIPTION, O.OBJECT_ID, O.OBJECT_NAME, DT.QTY, DT.TECH_COND_ID, DT.EST_SELL_PRICE, DT.EBAY_FEE, DT.PAYPAL_FEE, DT.SHIPPING_FEE, NVL(DT.SOLD_PRICE, 0) SOLD_PRICE, DT.PART_CATLG_MT_ID, MT.LOT_OFFER_AMOUNT, CON.COND_NAME FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT, LZ_ITEM_COND_MT CON WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.TECH_COND_ID = A.CONDITION_ID(+) /*AND MT.LZ_BD_CATAG_ID = 9879343*/ AND DT.LZ_ESTIMATE_DET_ID = $est_Det_id AND DT.TECH_COND_ID = CON.ID(+) ORDER BY DT.LZ_ESTIMATE_DET_ID ASC ")->result_array();

	if(count($get_lot_estimate) >=1) {	
 
		$this->db->query(" UPDATE LZ_BD_ESTIMATE_DET K SET K.POST_STATUS = 1 WHERE K.LZ_ESTIMATE_DET_ID =$est_Det_id  ");

		return array('get_lot_estimate' => $get_lot_estimate);

	}else{

		return false;
	}



}
		
}