<?php 

	class M_ServiceForm extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function serviceDocNo(){
			$query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SERV_RECEIPT_MT','DOC_NO') DOC_NO FROM DUAL");
			return $query->result_array();           
			//$lz_pos_mt_id= $rs[0]['LZ_POS_MT_ID'];
		}
		public function addEquipment(){
			$equip_name = ucfirst($this->input->post('equip_name'));
			$equip_name =trim(str_replace("  ", ' ', $equip_name));
			// if($equip_name->num_rows() >0){}
			
			$qry = $this->db->query("SELECT EQUIP_TYPE_DESC FROM LZ_SERV_EQUIP_TYPE_MT WHERE EQUIP_TYPE_DESC='$equip_name'");
			if($qry->num_rows() > 0){
				$this->session->set_flashdata('warning',"Component has already exist");
			}
			else{
				$qry_data = $this->db->query("SELECT get_single_primary_key('LZ_SERV_EQUIP_TYPE_MT','EQUIP_ID') EQUIP_ID FROM DUAL");

				$rs = $qry_data->result_array();           
				$equip_id= $rs[0]['EQUIP_ID'];
				$dataQry = $this->db->query("INSERT INTO LZ_SERV_EQUIP_TYPE_MT (EQUIP_ID,EQUIP_TYPE_DESC) VALUES($equip_id,'$equip_name')");
				if($dataQry){

		        	$this->session->set_flashdata('success', 'Record Inserted Successfully.');

		        	return $equip_id;
			    }else{
			        $this->session->set_flashdata('error', 'Record Not Inserted.');
			    }
			}
			
		}

		public function selectEquipment(){
			$equipQry = $this->db->query("SELECT * FROM LZ_SERV_EQUIP_TYPE_MT");
			$equipQry = $equipQry->result_array();
			return array('equipQry'=>$equipQry);
		}

		public function cityStateList(){
			$city_query = $this->db->query("SELECT * FROM WIZ_CITY_MT C WHERE C.STATE_ID > 1004");
			$city_query = $city_query->result_array();


			$state_query = $this->db->query("SELECT * FROM WIZ_STATE_MT C WHERE  C.COUNTRY_ID = 2");
			$state_query = $state_query->result_array();

			return array('city_query'=>$city_query, 'state_query'=>$state_query);
		}

		public function selectComponent(){
			$selectQry = $this->db->query("SELECT * FROM LZ_COMPONENT_MT");
			$selectQry = $selectQry->result_array();
			return array('selectQry'=>$selectQry);
		}


		public function addServiceRecord(){
			$doc_no = $this->input->post('doc_no');
			// $doc_no = docNo();

			// $lineNumber = count($this->input->post('quantity'));
			// var_dump($lineNumber);exit;
			/*===== Customer Info =====*/
			// date_default_timezone_set("America/Chicago");
			// $doc_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		 //  	// $date= date_format($date,"m/d/Y");
		 //  	$doc_date= "TO_DATE('".$doc_date."', 'YYYY-MM-DD HH24:MI:SS')";

			date_default_timezone_set("America/Chicago");
			$entered=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$entered= "TO_DATE('".$entered."', 'YYYY-MM-DD HH24:MI:SS')";
		  	
		  	$doc_date = $this->input->post('doc_date');
		  	$doc_date= "TO_DATE('".$doc_date."', 'MM/DD/YYYY ')";
		  	// date_default_timezone_set("America/Chicago");
		  	// $return_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$return_date = $this->input->post('return_date');
			// var_dump($return_date);exit;

		  	$return_date= "TO_DATE('".$return_date."', 'MM/DD/YYYY ')";
		  	

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
			/*==== End Customer Info ====*/

			/*==== Pay Mode optional in Service Form ====*/
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
			
			$tax_exempt  = $this->input->post('exempt');
			$card_number = $this->input->post('card_number');
			$disc_percent = $this->input->post('discPerc');
			$disc_amount = $this->input->post('discAmt');
			// $net_amount = $this->input->post('net_amount');
			$td_amount = $this->input->post('td_amount');
			$refund = $this->input->post('refund');
			$login_id = $this->session->userdata('user_id'); 
			$advance = $this->input->post('advAmount');

			$sales_tax =0;
			$tx_exmp = 0;
			if($tax_exempt == 1){
				$tx_exmp = 1;
				$sales_tax = 0;
			}elseif($tax_exempt == 0){
				$tx_exmp = 0;
				$sales_tax = 8.25;
			}
			/*==== END/ Pay Mode optional in Service Form ====*/


			/*==== Equipment Info Detail ====*/
			$equip_type = $this->input->post('equip_type');
			$equip_desc = $this->input->post('equip_desc');
			$equip_desc =trim(str_replace("  ", ' ', $equip_desc));
			$equip_imei = $this->input->post('equip_imei');
			$equip_jobDet = $this->input->post('job_det');

			/*==== Equipment Info Detail====*/
			$login_id = $this->session->userdata('user_id'); 

			/*==== Query For Master Part====*/

			$service = $this->input->post('serveCharges');
			/*==== END/  Query For Master Part====*/
			$coma = ',';

			$pkMT = $this->db->query("SELECT get_single_primary_key('LZ_SERV_RECEIPT_MT','LZ_SERV_MT_ID') LZ_SERV_MT_ID FROM DUAL");

			$rs = $pkMT->result_array();           
			$lz_serv_mt_id= $rs[0]['LZ_SERV_MT_ID'];

			$qryDataMt = $this->db->query("INSERT INTO LZ_SERV_RECEIPT_MT (LZ_SERV_MT_ID,EQUIP_ID,EQUIP_TYPE_DESC,SR_NO,JOB_DETAIL,DOC_NO,DOC_DATE,BUYER_PHONE_ID,BUYER_EMAIL,BUYER_ADDRESS,BUYER_CITY_ID,BUYER_STATE_ID,BUYER_ZIP,PAY_MODE,DISC_PERC,DISC_AMOUNT,TENDER_AMOUNT,ENTERED_BY,ENTERED_DATE_TIME,CREDIT_CARD,TAX_EXEMPT,STAX_PERC,EXPECTED_RETURN,ADVANCE_AMT,BUYER_NAME,SERVICE_CHARGES,STATUS, LZ_SERV_STAT_MT_ID) VALUES($lz_serv_mt_id,$equip_type,'$equip_desc','$equip_imei','$equip_jobDet',$doc_no,$doc_date,'$phone_id','$buyer_email','$buyer_address','$buyer_city','$buyer_state','$buyer_zip','$pay_mode','$disc_percent','$disc_amount','$td_amount',$login_id,$entered,'$card_number','$tx_exmp','$sales_tax',$return_date,'$advance','$buyer_name',$service,'Not Started',1)");

			/*===== Component Part =====*/
			$component = $this->input->post('component');
			// var_dump($component);exit;
			$qty = $this->input->post('quantity');
			$price = $this->input->post('net_price');
			// $dis_perc = $this->input->post('dis_percent');
			// $dis_amount = $this->input->post('disc_amount');
			// $serve_charges = $this->input->post('serve_charges');
			// $tax_perc = $this->input->post('tax_perc');
			/*===== End Component Part =====*/
			$compCount = count($this->input->post('quantity'));
			// var_dump($compCount);exit;
			/*==== Query For Detail Part====*/
			if($compCount>0){
				for($i=0;$i<$compCount;$i++){
					$qry2 = $this->db->query("SELECT get_single_primary_key('LZ_SERV_RECEIPT_DET','LZ_SERV_DET_ID') LZ_SERV_DET_ID FROM DUAL");

					$rss = $qry2->result_array();           
					$lz_serv_det_id= $rss[0]['LZ_SERV_DET_ID'];

					$detQry = $this->db->query("INSERT INTO LZ_SERV_RECEIPT_DET (LZ_SERV_DET_ID,LZ_SERV_MT_ID,COMPONENT_ID,QTY,PRICE) VALUES($lz_serv_det_id,$lz_serv_mt_id,$component[$i],$qty[$i],$price[$i])");

				}
			}
			if($qryDataMt){

		        $this->session->set_flashdata('success', 'Record Inserted Successfully.');

		        return $lz_serv_mt_id;
		    }else{
		        $this->session->set_flashdata('error', 'Record Not Inserted.');
		    }
			/*==== END/  Query  For Detail Part====*/
		}

		
		public function returnFilledData(){
			$doc_no = $this->input->post('docNo');

			$checkQry = $this->db->query("SELECT M.LZ_SERV_MT_ID FROM LZ_SERV_RECEIPT_MT M WHERE M.DOC_NO = $doc_no AND M.ACT_RET_DATE IS NULL");
			// var_dump($checkQry);exit;
			if($checkQry->num_rows() > 0){
				$fetchData = $this->db->query("SELECT DISTINCT M.LZ_SERV_MT_ID as MT_ID, TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY ') as DOC_DATE, TO_CHAR(M.EXPECTED_RETURN,'MM/DD/YYYY') as EXPECTED_RETURN, M.BUYER_PHONE_ID, M.BUYER_EMAIL,M.EQUIP_ID, M.BUYER_ADDRESS, M.BUYER_CITY_ID, M.BUYER_STATE_ID, M.BUYER_ZIP, M.ADVANCE_AMT,M.BUYER_NAME, M.EQUIP_TYPE_DESC, M.SR_NO,M.DISC_AMOUNT,M.STAX_PERC, M.JOB_DETAIL,M.SERVICE_CHARGES,M.PAY_MODE,D.LZ_SERV_MT_ID as DET_MT_ID, D.COMPONENT_ID, D.QTY, D.PRICE, C.LZ_COMPONENT_DESC,C.LZ_COMPONENT_ID FROM LZ_SERV_RECEIPT_MT M, LZ_SERV_RECEIPT_DET D , LZ_COMPONENT_MT C WHERE M.LZ_SERV_MT_ID = D.LZ_SERV_MT_ID AND C.LZ_COMPONENT_ID = D.COMPONENT_ID AND M.DOC_NO = $doc_no");
				return $fetchData->result_array();
			}
			else{
				return 'error';
			}
			
		}

		public function returnAddService(){
			date_default_timezone_set("America/Chicago");
			$doc_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$doc_date= "TO_DATE('".$doc_date."', 'YYYY-MM-DD HH24:MI:SS')";
		  	$login_id = $this->session->userdata('user_id'); 

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
			// var_dump($pay_mode);exit;
			$payableAmt = $this->input->post('t_amount');
			//var_dump($payableAmt);exit;
			$td_amount = $this->input->post('td_amount');
			$cardNum = $this->input->post('card_number');
			$doc_no = $this->input->post('doc_no');
			$lz_serv_mt_id = $this->input->post('lz_serv_mt_id');


			$qry = $this->db->query("UPDATE LZ_SERV_RECEIPT_MT SET RETURN_BY = $login_id, ACT_RET_DATE = $doc_date, RET_PAYABLE_AMT = $payableAmt ,RET_TENDER_AMT = '$td_amount' ,RET_CREDIT_CARD = '$cardNum',RET_PAY_MODE = '$pay_mode' WHERE LZ_SERV_MT_ID = $lz_serv_mt_id");

			if($qry){    
			 	$this->session->set_flashdata('success', 'Record Updated Successfully.');

		        return $lz_serv_mt_id;
		    }else{
		        $this->session->set_flashdata('error', 'Record Not Inserted.');
		    }
			
		}

		public function editServiceInvoice($lz_serv_mt_id){
			$query = $this->db->query("SELECT M.LZ_SERV_MT_ID,M.DOC_NO,TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY ') as DOC_DATE,TO_CHAR(M.EXPECTED_RETURN, 'MM/DD/YYYY') as EXPECTED_RETURN,M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.BUYER_CITY_ID, M.BUYER_STATE_ID, M.BUYER_ZIP, M.PAY_MODE, M.DISC_PERC, M.DISC_AMOUNT, M.TENDER_AMOUNT, M.ENTERED_BY, M.ENTERED_DATE_TIME, M.CREDIT_CARD, M.TAX_EXEMPT,M.ADVANCE_AMT, M.STAX_PERC, M.BUYER_NAME,M.EQUIP_ID,M.EQUIP_TYPE_DESC,M.SR_NO,M.JOB_DETAIL,M.SERVICE_CHARGES,D.LZ_SERV_DET_ID,D.LZ_SERV_MT_ID,D.COMPONENT_ID,D.QTY,D.PRICE FROM LZ_SERV_RECEIPT_MT M, LZ_SERV_RECEIPT_DET D WHERE M.LZ_SERV_MT_ID = D.LZ_SERV_MT_ID AND M.LZ_SERV_MT_ID = $lz_serv_mt_id ");

			return $query->result_array();

		}
		public function deleteServiceInvoice($lz_serv_mt_id){

			$partIssueQry = $this->db->query("SELECT M.LZ_PART_ISSUE_MT_ID From LZ_PART_ISSUE_MT M WHERE M.LZ_SERV_MT_ID = $lz_serv_mt_id"); 
			// var_dump($partIssueQry->num_rows());exit;
			if($partIssueQry->num_rows() <1){

				$query_det = $this->db->query("DELETE FROM LZ_SERV_RECEIPT_DET D WHERE D.LZ_SERV_MT_ID = $lz_serv_mt_id");

				$query_mt = $this->db->query("DELETE FROM LZ_SERV_RECEIPT_MT M WHERE M.LZ_SERV_MT_ID = $lz_serv_mt_id");

		      	if($query_mt){

		        	$this->session->set_flashdata('deleted', 'Record Deleted Successfully.');

		      	}else{
		        	$this->session->set_flashdata('del_error', 'Record Not Deleted.');
		      	} 

			}else{
				$this->session->set_flashdata('del_error', ' Record Cannot be deleted Parts are already Assigned to this Receipt No.');
			}
			


			
		}		


		// public function returnFilledServiceData(){
			
		// }
		public function updateServiceInvoice(){
			$lz_serv_mt_id = $this->input->post('lz_serv_mt_id');
			$del_qry_det = $this->db->query("DELETE FROM LZ_SERV_RECEIPT_DET D WHERE D.LZ_SERV_MT_ID = $lz_serv_mt_id");

			/*===== Component Part =====*/
			$component = $this->input->post('component');
			$qty = $this->input->post('quantity');
			$price = $this->input->post('net_price');
			$compCount = count($this->input->post('quantity'));
			// var_dump($compCount);exit;
			/*==== Query For Detail Part====*/
			if($compCount>0){
				for($i=0;$i<$compCount;$i++){
					$qry2 = $this->db->query("SELECT get_single_primary_key('LZ_SERV_RECEIPT_DET','LZ_SERV_DET_ID') LZ_SERV_DET_ID FROM DUAL");

					$rss = $qry2->result_array();           
					$lz_serv_det_id= $rss[0]['LZ_SERV_DET_ID'];

					$detQry = $this->db->query("INSERT INTO LZ_SERV_RECEIPT_DET (LZ_SERV_DET_ID,LZ_SERV_MT_ID,COMPONENT_ID,QTY,PRICE) VALUES($lz_serv_det_id,$lz_serv_mt_id,'$component[$i]','$qty[$i]','$price[$i]')");

				}
			}

			$doc_no = $this->input->post('doc_no');
			

		  	
		  	$doc_date = $this->input->post('doc_date');
		  	$doc_date= "TO_DATE('".$doc_date."', 'MM/DD/YYYY ')";
		  	// date_default_timezone_set("America/Chicago");
		  	// $return_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$return_date = $this->input->post('return_date');
			// var_dump($return_date);exit;

		  	$return_date= "TO_DATE('".$return_date."', 'MM/DD/YYYY ')";
		  	
		  	date_default_timezone_set("America/Chicago");
			$entered=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	// $date= date_format($date,"m/d/Y");
		  	$entered= "TO_DATE('".$entered."', 'YYYY-MM-DD HH24:MI:SS')";

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
			/*==== End Customer Info ====*/

			/*==== Pay Mode optional in Service Form ====*/
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
			
			$tax_exempt  = $this->input->post('exempt');
			$card_number = $this->input->post('card_number');
			$disc_percent = $this->input->post('discPerc');
			$disc_amount = $this->input->post('discAmt');
			// $net_amount = $this->input->post('net_amount');
			$td_amount = $this->input->post('td_amount');
			$refund = $this->input->post('refund');
			$login_id = $this->session->userdata('user_id'); 
			$advance = $this->input->post('advAmount');

			$sales_tax =0;
			$tx_exmp = 0;
			if($tax_exempt == 1){
				$tx_exmp = 1;
				$sales_tax = 0;
			}elseif($tax_exempt == 0){
				$tx_exmp = 0;
				$sales_tax = 8.25;
			}
			/*==== END/ Pay Mode optional in Service Form ====*/


			/*==== Equipment Info Detail ====*/
			$equip_id = $this->input->post('equip_id');
			$equip_type = $this->input->post('equip_type');
			$equip_desc = $this->input->post('equip_desc');
			$equip_desc =trim(str_replace("  ", ' ', $equip_desc));
			$equip_imei = $this->input->post('equip_imei');
			$equip_jobDet = $this->input->post('job_det');

			/*==== Equipment Info Detail====*/
			$login_id = $this->session->userdata('user_id'); 

			/*==== Query For Master Part====*/

			$service = $this->input->post('serveCharges');
			/*==== END/  Query For Master Part====*/
			$coma = ',';

			$updateQry = $this->db->query("UPDATE LZ_SERV_RECEIPT_MT SET DOC_NO=$doc_no,DOC_DATE=$doc_date,EXPECTED_RETURN=$return_date,BUYER_PHONE_ID='$phone_id',BUYER_EMAIL='$buyer_email',BUYER_ADDRESS='$buyer_address',BUYER_NAME='$buyer_name',BUYER_CITY_ID='$buyer_city',BUYER_STATE_ID='$buyer_state',BUYER_ZIP='$buyer_zip',PAY_MODE='$pay_mode',DISC_PERC='$disc_percent',DISC_AMOUNT='$disc_amount',ADVANCE_AMT='$advance',EQUIP_ID='$equip_id',EQUIP_TYPE_DESC='$equip_desc',SR_NO='$equip_imei',JOB_DETAIL='$equip_jobDet',TENDER_AMOUNT='$td_amount',ENTERED_BY=$login_id,TAX_EXEMPT=$tx_exmp,CREDIT_CARD='$card_number',ENTERED_DATE_TIME = $entered WHERE LZ_SERV_MT_ID = $lz_serv_mt_id");
		}		

		
}