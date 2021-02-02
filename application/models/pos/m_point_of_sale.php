<?php

	class M_Point_Of_Sale extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
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
		public function docNo(){
			$query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_POS_MT','DOC_NO') DOC_NO FROM DUAL");
			return $query->result_array();           
			//$lz_pos_mt_id= $rs[0]['LZ_POS_MT_ID'];
		}
		public function cityStateList(){
			$city_query = $this->db->query("SELECT * FROM WIZ_CITY_MT C WHERE C.STATE_ID > 1004");
			$city_query = $city_query->result_array();


			$state_query = $this->db->query("SELECT * FROM WIZ_STATE_MT C WHERE  C.COUNTRY_ID = 2");
			$state_query = $state_query->result_array();

			return array('city_query'=>$city_query, 'state_query'=>$state_query);
		}
		public function itemDetails(){

			$barcode = $this->input->post('pos_barcode');

			// S.EBAY_PRICE COST_PRICE from Seed Table
			$pulledDetail_query = $this->db->query("SELECT PULLING_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO =  $barcode AND PULLING_ID IS NULL AND LZ_POS_MT_ID IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL");
			if($pulledDetail_query->num_rows() > 0 ){
				$detail_query = $this->db->query("SELECT S.SEED_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, NVL(S.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, S.EBAY_PRICE COST_PRICE FROM LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_ITEM_SEED S, (SELECT BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.BARCODE_NO = $barcode and bc.pulling_id is null GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID) BCD, (SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID) QRY_PRICE WHERE BCD.ITEM_ID = I.ITEM_ID AND BCD.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND BCD.ITEM_ID = QRY_PRICE.ITEM_ID AND BCD.LZ_MANIFEST_ID = QRY_PRICE.LZ_MANIFEST_ID AND S.ITEM_ID(+) = BCD.ITEM_ID AND S.LZ_MANIFEST_ID(+) = BCD.LZ_MANIFEST_ID AND S.DEFAULT_COND(+) = BCD.CONDITION_ID");
				return $detail_query->result_array();
			}else{
				$this->session->set_flashdata('error', 'Barcode has already used!.');
				return 'error';
			}

			

		}		

		public function addRecord(){
			// ------- Buyer Record------------
			$craig_post = $this->input->post('ad_id');
			$doc_no = $this->input->post('doc_no');
			// $doc_no = docNo();

			// $doc_date = $this->input->post('doc_date');
			date_default_timezone_set("America/Chicago");
			$doc_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$doc_date= "TO_DATE('".$doc_date."', 'YYYY-MM-DD HH24:MI:SS')";
			$phone_id = $this->input->post('phone_no');
			$buyer_email = $this->input->post('buyer_email');
			$buyer_email =trim(str_replace("  ", ' ', $buyer_email));
			$buyer_name = $this->input->post('buyer_name');
			$buyer_name = trim(str_replace("  ", ' ', $buyer_name));
			$buyer_address = $this->input->post('buyer_address');
			$buyer_address = trim(str_replace("  ", ' ', $buyer_address));
			$buyer_city = $this->input->post('buyer_city');
			$buyer_state = $this->input->post('buyer_state');
			$buyer_zip = $this->input->post('buyer_zip');
			$buyer_zip = trim(str_replace("  ", ' ', $buyer_zip));

			$coma = ',';
			//----End Buyer Record-------


			//---- Payment Block ----
			$pay_mode = "";
			$pay_mode1 = $this->input->post('opt1');
			$pay_mode2 = $this->input->post('opt2');
			if($pay_mode1 =="C"){
				$pay_mode = $pay_mode1;
			}
			if($pay_mode2 == "R"){
				$pay_mode = $pay_mode2;
				// var_dump($pay_mode);exit();
			}
			$pay_mode = trim(str_replace("  ", ' ', $pay_mode));
			$tax_exempt  = $this->input->post('exempt');
			$card_number = $this->input->post('card_number');
			$dis_percent = "";
			$disc_amount = $this->input->post('disc_total_amount');
			$net_amount = $this->input->post('net_amount');
			$td_amount = $this->input->post('td_amount');
			$refund = $this->input->post('refund');
			$login_id = $this->session->userdata('user_id'); 

			$sales_tax =0;
			$tx_exmp = 0;
			if($tax_exempt == 1){
				$tx_exmp = 1;
				$sales_tax = 0;
			}elseif($tax_exempt == 0){
				$tx_exmp = 0;
				$sales_tax = 8.25;
			}


			//---- End Payment block ----
			$qry_data = $this->db->query("SELECT get_single_primary_key('LZ_POS_MT','LZ_POS_MT_ID') LZ_POS_MT_ID FROM DUAL");

			$rs = $qry_data->result_array();           
			$lz_pos_mt_id= $rs[0]['LZ_POS_MT_ID'];

			// var_dump($lz_pos_mt_id);exit;
			$qry = $this->db->query("INSERT INTO LZ_POS_MT (LZ_POS_MT_ID,LZ_CRAIG_POST_ID,DOC_NO,DOC_DATE,BUYER_PHONE_ID,BUYER_EMAIL,BUYER_ADDRESS,BUYER_CITY_ID,BUYER_STATE_ID,BUYER_ZIP,PAY_MODE,DISC_PERC,DISC_AMOUNT,TENDER_AMOUNT,ENTERED_BY,ENTERED_DATE_TIME,CREDIT_CARD,TAX_EXEMPT,STAX_PERC,BUYER_NAME) VALUES($lz_pos_mt_id $coma '$craig_post' $coma $doc_no $coma $doc_date $coma '$phone_id' $coma '$buyer_email' $coma '$buyer_address' $coma '$buyer_city' $coma '$buyer_state' $coma '$buyer_zip' $coma '$pay_mode' $coma '$dis_percent' $coma '$disc_amount' $coma '$td_amount' $coma $login_id $coma $doc_date $coma '$card_number' $coma '$tx_exmp' $coma $sales_tax,'$buyer_name')");

			$barNumber = count($_POST["bar_code"]);
			$bar_code = $this->input->post('bar_code');
			// var_dump($bar_code);exit;
			$qty = $this->input->post('quantity');
			$price = $this->input->post('price');
			$disc_perc = $this->input->post('dis_percent');
			$dis_amount = $this->input->post('disc_amount');
			$dis_desc = $this->input->post('desc_item');
			$lineNumber = count($this->input->post('line_type'));
			$line_type = $this->input->post('line_type');


			

			for($i=0;$i<$lineNumber;$i++){
				$qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_DET','LZ_POS_DET_ID') LZ_POS_DET_ID FROM DUAL");

				$rss = $qry2->result_array();           
				$lz_pos_det_id= $rss[0]['LZ_POS_DET_ID'];
				
				$qryDt = $this->db->query("INSERT INTO LZ_POS_DET (LZ_POS_DET_ID,LZ_POS_MT_ID,BARCODE_ID,QTY,PRICE,SALES_TAX_PERC,DISC_PERC,DISC_AMT,ITEM_DESC,LINE_TYPE) VALUES($lz_pos_det_id $coma $lz_pos_mt_id $coma '$bar_code[$i]' $coma $qty[$i] $coma $price[$i] $coma '$sales_tax' $coma $disc_perc[$i] $coma $dis_amount[$i] $coma '$dis_desc[$i]' $coma '$line_type[$i]')");
				 				
			}
			if($barNumber>0){
					
				
				for($i=0;$i<$barNumber;$i++){
					if($bar_code[$i] !=''){
						$checkQry = $this->db->query("SELECT LZ_POS_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO=$bar_code[$i]");
					// var_dump($checkQry);exit;
						if($checkQry->num_rows == 0){
							$this->db->query("UPDATE LZ_BARCODE_MT SET LZ_POS_MT_ID=$lz_pos_mt_id where BARCODE_NO='$bar_code[$i]'");
						}
					}
					
					
				}
			}

			$this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = 1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");

			if($qry){

		        $this->session->set_flashdata('success', 'Record Inserted Successfully.');

		        return $lz_pos_mt_id;
		    }else{
		        $this->session->set_flashdata('error', 'Record Not Inserted.');
		    }

		}
		public function deleteInvoice($lz_pos_mt_id){

			$del_qry_det = $this->db->query("DELETE FROM LZ_POS_DET D WHERE D.LZ_POS_MT_ID = $lz_pos_mt_id");

			$del_qry_mt = $this->db->query("DELETE FROM LZ_POS_MT M WHERE M.LZ_POS_MT_ID = $lz_pos_mt_id");

	      if($del_qry_mt){

	        $this->session->set_flashdata('deleted', 'Record Deleted Successfully.');

	      }else{
	        $this->session->set_flashdata('del_error', 'Record Not Deleted.');
	      } 			

		}
		public function editInvoice($lz_pos_mt_id){

			$query = $this->db->query("SELECT M.LZ_POS_MT_ID, M.DOC_NO,TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY ') as DOC_DATE, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.BUYER_CITY_ID, M.BUYER_STATE_ID, M.BUYER_ZIP, M.PAY_MODE, M.DISC_PERC, M.DISC_AMOUNT, M.TENDER_AMOUNT, M.ENTERED_BY, M.ENTERED_DATE_TIME, M.CREDIT_CARD, M.TAX_EXEMPT, M.STAX_PERC, M.BUYER_NAME, D.LZ_POS_DET_ID, D.LZ_POS_MT_ID, D.BARCODE_ID, D.QTY, D.PRICE, D.SALES_TAX_PERC, D.DISC_PERC, D.DISC_AMT, D.ITEM_DESC, D.LINE_TYPE FROM LZ_POS_MT M, LZ_POS_DET D WHERE M.LZ_POS_MT_ID = D.LZ_POS_MT_ID AND M.LZ_POS_MT_ID = $lz_pos_mt_id"); return $query->result_array();
		}

		public function updateInvoice(){
			$lz_pos_mt_id = $this->input->post('lz_pos_mt_id');
			// var_dump($lz_pos_mt_id);exit;
			$this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = -1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
			$del_qry_det = $this->db->query("DELETE FROM LZ_POS_DET D WHERE D.LZ_POS_MT_ID = $lz_pos_mt_id");

			$barcode = $this->input->post('bar_code');
			$qty = $this->input->post('quantity');
			$price = $this->input->post('price');
			$discPerc = $this->input->post('disc_perc');
			$discAmt = $this->input->post('disc_amount');
			$itemDesc = $this->input->post('desc_item');
			$lineType = $this->input->post('line_type'); 
			// var_dump($lineType);exit;
			$lineNumber = count($this->input->post('line_type'));
			$sales_tax = $this->input->post('s_tax');
			$coma = ',';
			for($i=0;$i<$lineNumber;$i++){
				$qry2 = $this->db->query("SELECT get_single_primary_key('LZ_POS_DET','LZ_POS_DET_ID') LZ_POS_DET_ID FROM DUAL");

				$rss = $qry2->result_array();           
				$lz_pos_det_id= $rss[0]['LZ_POS_DET_ID'];
				if($lineType[$i] == "Service"){
					$lineType[$i] = "SR";
				}
				if($lineType[$i] == "Other"){
					$lineType[$i] = "OT";
				}
				if($lineType[$i] == "Parts"){
					$lineType[$i] = "PT";
				}
				if($lineType[$i] == "Shipping"){
					$lineType[$i] = "SH";
				}
				
				$qryDt = $this->db->query("INSERT INTO LZ_POS_DET (LZ_POS_DET_ID,LZ_POS_MT_ID,BARCODE_ID,QTY,PRICE,SALES_TAX_PERC,DISC_PERC,DISC_AMT,ITEM_DESC,LINE_TYPE) VALUES($lz_pos_det_id $coma $lz_pos_mt_id $coma '$barcode[$i]' $coma $qty[$i] $coma $price[$i] $coma '$sales_tax' $coma '$discPerc[$i]' $coma '$discAmt[$i]' $coma '$itemDesc[$i]' $coma '$lineType[$i]')");
				 				
			}

			$craig_post = $this->input->post('ad_id');
			$doc_no = $this->input->post('doc_no');
			
		  	// $doc_date = $this->input->post('doc_date');

		  	// $doc_date = "TO_DATE('".$doc_date."', 'MM/DD/YYYY')";
		  	date_default_timezone_set("America/Chicago");
			$doc_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$doc_date= "TO_DATE('".$doc_date."', 'YYYY-MM-DD HH24:MI:SS')";

		  	//$doc_date= "TO_DATE('".$doc_date."', 'MM/DD/YYYY ')";
		  	// var_dump($doc_date);exit;
			$phone_id = $this->input->post('phone_no');
			$buyer_email = $this->input->post('buyer_email');
			$buyer_email =trim(str_replace("  ", ' ', $buyer_email));
			$buyer_name = $this->input->post('buyer_name');
			$buyer_name = trim(str_replace("  ", ' ', $buyer_name));
			$buyer_address = $this->input->post('buyer_address');
			$buyer_address = trim(str_replace("  ", ' ', $buyer_address));
			$buyer_city = $this->input->post('buyer_city');
			$buyer_state = $this->input->post('buyer_state');
			$buyer_zip = $this->input->post('buyer_zip');
			$buyer_zip = trim(str_replace("  ", ' ', $buyer_zip));

			$pay_mode = "";
			$pay_mode1 = $this->input->post('opt1');
			$pay_mode2 = $this->input->post('opt2');
			if($pay_mode1 =="C"){
				$pay_mode = $pay_mode1;
			}
			if($pay_mode2 == "R"){
				$pay_mode = $pay_mode2;
				// var_dump($pay_mode);exit();
			}
			$pay_mode = trim(str_replace("  ", ' ', $pay_mode));
			$tax_exempt  = $this->input->post('exempt');
			$card_number = $this->input->post('card_number');
			$dis_percent = "";
			$disc_amount = $this->input->post('disc_total_amount');
			$net_amount = $this->input->post('net_amount');
			$td_amount = $this->input->post('td_amount');
			$refund = $this->input->post('refund');
			$login_id = $this->session->userdata('user_id'); 

			$sales_tax =0;
			$tx_exmp = 0;
			if($tax_exempt == 1){
				$tx_exmp = 1;
				$sales_tax = 0;
			}elseif($tax_exempt == 0){
				$tx_exmp = 0;
				$sales_tax = 8.25;
			}

			$updateQry = $this->db->query("UPDATE LZ_POS_MT SET LZ_CRAIG_POST_ID ='$craig_post', DOC_NO='$doc_no', DOC_DATE=$doc_date,BUYER_PHONE_ID ='$phone_id' ,BUYER_EMAIL ='$buyer_email' ,BUYER_ADDRESS = '$buyer_address',BUYER_CITY_ID='$buyer_city', BUYER_STATE_ID='$buyer_state',
				BUYER_ZIP='$buyer_zip',PAY_MODE= '$pay_mode', DISC_AMOUNT='$disc_amount',TENDER_AMOUNT='$td_amount',ENTERED_BY='$login_id',ENTERED_DATE_TIME=$doc_date,CREDIT_CARD='$card_number',TAX_EXEMPT='$tax_exempt',STAX_PERC='$sales_tax',BUYER_NAME = '$buyer_name' WHERE LZ_POS_MT_ID=$lz_pos_mt_id");

			$this->db->query("UPDATE  LZ_POS_MT P SET P.POST_YN = 1 WHERE P.LZ_POS_MT_ID = $lz_pos_mt_id");
			if($updateQry){

		        $this->session->set_flashdata('success', 'Record Updated Successfully.');

		      }else{
		        $this->session->set_flashdata('update_error', 'Record Not Updated.');
		      }
		}
				
	}


?>