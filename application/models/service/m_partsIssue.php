<?php 

	class M_PartsIssue extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function returnFilledData(){
			$barcode = $this->input->post('barcode');

			$checkQry = $this->db->query(" SELECT M.LZ_SERV_MT_ID FROM LZ_SERV_RECEIPT_MT M WHERE M.DOC_NO = $barcode AND M.ACT_RET_DATE IS NULL AND M.LZ_SERV_MT_ID NOT IN(SELECT LZ_SERV_MT_ID FROM LZ_PART_ISSUE_MT)"); 
			// var_dump($checkQry);exit;
			if($checkQry->num_rows() > 0){
				$fetchData = $this->db->query("SELECT DISTINCT M.LZ_SERV_MT_ID as MT_ID, TO_CHAR(M.DOC_DATE, 'MM/DD/YYYY ') as SERV_DATE, TO_CHAR(M.EXPECTED_RETURN,'MM/DD/YYYY') as EXPECTED_RETURN, M.BUYER_PHONE_ID, M.BUYER_EMAIL,M.EQUIP_ID, M.BUYER_ADDRESS, M.BUYER_CITY_ID, M.BUYER_STATE_ID, M.BUYER_ZIP, M.ADVANCE_AMT,M.BUYER_NAME, M.EQUIP_TYPE_DESC, M.SR_NO,M.DISC_AMOUNT,M.STAX_PERC, M.JOB_DETAIL,M.SERVICE_CHARGES,M.PAY_MODE,D.LZ_SERV_MT_ID as DET_MT_ID, D.COMPONENT_ID, D.QTY, D.PRICE, C.LZ_COMPONENT_DESC,C.LZ_COMPONENT_ID FROM LZ_SERV_RECEIPT_MT M, LZ_SERV_RECEIPT_DET D , LZ_COMPONENT_MT C WHERE M.LZ_SERV_MT_ID = D.LZ_SERV_MT_ID AND C.LZ_COMPONENT_ID = D.COMPONENT_ID AND M.DOC_NO = $barcode");
				return $fetchData->result_array();
			}
			else{
				return 'error';
			}
			
		}

		public function issuanceNo(){
			$query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_PART_ISSUE_MT','DOC_NO') DOC_NO FROM DUAL");
			return $query->result_array();
		}

		public function partDetails(){

			$barcode = $this->input->post('part_barcode');

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


		public function partsIssuance(){

			$login_id = $this->session->userdata('user_id');
			$receiptBarcode = $this->input->post('receipt_barcode');
			$doc_no = $this->input->post('issuance_no');
			$lz_serv_mt_id = $this->input->post('lz_mt_id');

			date_default_timezone_set("America/Chicago");
			$doc_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	$doc_date= "TO_DATE('".$doc_date."', 'YYYY-MM-DD HH24:MI:SS')";

		  	$remarks = $this->input->post('remarks');

		  	$qry_data = $this->db->query("SELECT get_single_primary_key('LZ_PART_ISSUE_MT','LZ_PART_ISSUE_MT_ID') LZ_PART_ISSUE_MT_ID FROM DUAL");

			$rs = $qry_data->result_array();           
			$lz_part_issue_mt_id= $rs[0]['LZ_PART_ISSUE_MT_ID'];

			
			$qry = $this->db->query("INSERT INTO LZ_PART_ISSUE_MT (LZ_PART_ISSUE_MT_ID,LZ_SERV_MT_ID,DOC_DATE,DOC_NO,REMARKS,ENTERED_BY) VALUES($lz_part_issue_mt_id,$lz_serv_mt_id,$doc_date,$doc_no,'$remarks','$login_id')");

			$part_barcode = $this->input->post('barcode');

			$line_remark = $this->input->post('line_remark');

			$barNumber = count($this->input->post('barcode'));

			for($i=0;$i<$barNumber;$i++){
				$qry2 = $this->db->query("SELECT get_single_primary_key('LZ_PART_ISSUE_DET','LZ_PART_ISSUE_DET_ID') LZ_PART_ISSUE_DET_ID FROM DUAL");

				$rss = $qry2->result_array();           
				$lz_part_issue_det_id= $rss[0]['LZ_PART_ISSUE_DET_ID'];

				$detQry = $this->db->query("INSERT INTO LZ_PART_ISSUE_DET (LZ_PART_ISSUE_DET_ID,LZ_PART_ISSUE_MT_ID,BARCODE_NO,LINE_REMARKS) VALUES($lz_part_issue_det_id,$lz_part_issue_mt_id,$part_barcode[$i],'$line_remark[$i]')");
			}


			if($barNumber>0){
					
				
				for($i=0;$i<$barNumber;$i++){
					if($part_barcode[$i] !=''){
						$checkQry = $this->db->query("SELECT LZ_PART_ISSUE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO=$part_barcode[$i]");
					// var_dump($checkQry);exit;
						if($checkQry->num_rows == 0){
							$this->db->query("UPDATE LZ_BARCODE_MT SET LZ_PART_ISSUE_MT_ID=$lz_part_issue_mt_id where BARCODE_NO='$part_barcode[$i]'");
						}
					}
					
					
				}
			}

			$this->db->query("UPDATE  LZ_PART_ISSUE_MT  P SET P.POSTED_YN = 1 WHERE P.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");

			if($qry){

		        $this->session->set_flashdata('success', 'Record Inserted Successfully.');

		        return $lz_part_issue_mt_id;
		    }else{
		        $this->session->set_flashdata('error', 'Record Not Inserted.');
		    }
		}

		public function partsIssuanceDetail(){

			$qry = $this->db->query("SELECT P.LZ_PART_ISSUE_MT_ID,P.LZ_SERV_MT_ID, P.DOC_DATE,P.DOC_NO ISSUE_NO,P.REMARKS,P.ENTERED_BY,S.DOC_NO,S.LZ_SERV_MT_ID FROM LZ_PART_ISSUE_MT P,LZ_SERV_RECEIPT_MT S WHERE P.LZ_SERV_MT_ID = S.LZ_SERV_MT_ID ");
			return $qry->result_array();
		}

		public function deletePartIssue($lz_part_issue_mt_id){

			$this->db->query("UPDATE  LZ_PART_ISSUE_MT  P SET P.POSTED_YN = -1 WHERE P.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");
			$genNumber = $this->db->query("SELECT GEN_ISSUE_MT_ID FROM LZ_PART_ISSUE_MT WHERE LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id AND GEN_ISSUE_MT_ID IS NULL ");
			// var_dump($genNumber->num_rows());exit;
			if($genNumber->num_rows()>0){
				$query_det = $this->db->query("DELETE FROM LZ_PART_ISSUE_DET D WHERE D.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");
				$barcodeUpdateQry = $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_PART_ISSUE_MT_ID= NULL WHERE LZ_PART_ISSUE_MT_ID= $lz_part_issue_mt_id");
				$query_mt = $this->db->query("DELETE FROM LZ_PART_ISSUE_MT M WHERE M.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");

			      if($query_mt){

			        $this->session->set_flashdata('deleted', 'Record Deleted Successfully.');

			      }else{
			        $this->session->set_flashdata('del_error', 'Record Not Deleted.');
			      }
			}else{
				$this->session->set_flashdata('del_error', 'Record Not Deleted.');
			}

			
		}

		public function editPartsIssueOne($lz_part_issue_mt_id){
			$qry = $this->db->query("SELECT S.DOC_NO NUM, S.JOB_DETAIL, S.EQUIP_TYPE_DESC, D.COMPONENT_ID, D.QTY, D.PRICE,P.LZ_PART_ISSUE_MT_ID,C.LZ_COMPONENT_DESC FROM LZ_SERV_RECEIPT_MT  S, LZ_PART_ISSUE_MT P,LZ_SERV_RECEIPT_DET D,LZ_COMPONENT_MT C WHERE S.LZ_SERV_MT_ID = P.LZ_SERV_MT_ID AND D.LZ_SERV_MT_ID = P.LZ_SERV_MT_ID AND P.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id AND D.COMPONENT_ID = C.LZ_COMPONENT_ID");
			return $qry->result_array();
		}
		public function editPartsIssue($lz_part_issue_mt_id){

			$qry = $this->db->query("SELECT R.LZ_SERV_MT_ID,R.DOC_NO NUM, R.JOB_DETAIL, R.EQUIP_TYPE_DESC,TO_CHAR(R.DOC_DATE, 'MM/DD/YYYY ') AS SERV_DATE, I.REMARKS, I.DOC_NO ISSUE_NO, TO_CHAR(I.DOC_DATE, 'MM/DD/YYYY ') AS ISSUE_DATE, I.LZ_PART_ISSUE_MT_ID, D.BARCODE_NO,D.LINE_REMARKS FROM LZ_SERV_RECEIPT_MT R, LZ_PART_ISSUE_MT I, LZ_PART_ISSUE_DET D WHERE R.LZ_SERV_MT_ID = I.LZ_SERV_MT_ID AND I.LZ_PART_ISSUE_MT_ID = D.LZ_PART_ISSUE_MT_ID AND D.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id ");
			$barcode_no = $qry->result_array();
			$barcode_id = $barcode_no[0]['BARCODE_NO'];
			// var_dump($barcode_id);exit;
			$desc_qry = $this->db->query("SELECT I.ITEM_DESC FROM ITEMS_MT I WHERE I.ITEM_ID = (SELECT ITEM_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = $barcode_id)");
			$desc = $desc_qry->result_array();
			// return $qry->result_array();
			return array('detail'=>$barcode_no, 'desc'=>$desc);
			
		}

		public function selectComponent(){
			$selectQry = $this->db->query("SELECT * FROM LZ_COMPONENT_MT");
			return $selectQry->result_array();
			// return array('selectQry'=>$selectQry);
		}

		public function updatePartsIssue(){
			
			$lz_serv_mt_id = $this->input->post('lz_mt_id');

			// var_dump($lz_serv_mt_id);exit;

			$lz_part_issue_mt_id = $this->input->post('lz_part_issue_mt_id');
			$this->db->query("UPDATE  LZ_PART_ISSUE_MT  P SET P.POSTED_YN = -1 WHERE P.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");
			// var_dump($lz_part_issue_mt_id);exit;
			$query_det = $this->db->query("DELETE FROM LZ_PART_ISSUE_DET D WHERE D.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");
			$barcodeUpdateQry = $this->db->query("UPDATE LZ_BARCODE_MT SET LZ_PART_ISSUE_MT_ID= NULL WHERE LZ_PART_ISSUE_MT_ID= $lz_part_issue_mt_id");
			// $query_mt = $this->db->query("DELETE FROM LZ_PART_ISSUE_MT M WHERE M.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");

			
			$receiptBarcode = $this->input->post('receipt_barcode');
			$doc_no = $this->input->post('issuance_no');
			

			// date_default_timezone_set("America/Chicago");
			// $doc_date=date("Y-m-d H:i:s");//change date format from 07-Dec-2016 to 12/07/2016
		  	$doc_date= $this->input->post('doc_date');
		  	$doc_date= "TO_DATE('".$doc_date."', 'MM/DD/YYYY ')";

		  	$remarks = $this->input->post('remarks');

		 //  	$qry_data = $this->db->query("SELECT get_single_primary_key('LZ_PART_ISSUE_MT','LZ_PART_ISSUE_MT_ID') LZ_PART_ISSUE_MT_ID FROM DUAL");

			// $rs = $qry_data->result_array();           
			// $lz_part_issue_mt_id= $rs[0]['LZ_PART_ISSUE_MT_ID'];

			
			$qry = $this->db->query("UPDATE  LZ_PART_ISSUE_MT SET  DOC_DATE = $doc_date ,DOC_NO = $doc_no, REMARKS= '$remarks' WHERE LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");

			$part_barcode = $this->input->post('barcode');

			$line_remark = $this->input->post('line_remark');

			$barNumber = count($this->input->post('barcode'));

			for($i=0;$i<$barNumber;$i++){
				$qry2 = $this->db->query("SELECT get_single_primary_key('LZ_PART_ISSUE_DET','LZ_PART_ISSUE_DET_ID') LZ_PART_ISSUE_DET_ID FROM DUAL");

				$rss = $qry2->result_array();           
				$lz_part_issue_det_id= $rss[0]['LZ_PART_ISSUE_DET_ID'];

				$detQry = $this->db->query("INSERT INTO LZ_PART_ISSUE_DET (LZ_PART_ISSUE_DET_ID,LZ_PART_ISSUE_MT_ID,BARCODE_NO,LINE_REMARKS) VALUES($lz_part_issue_det_id,$lz_part_issue_mt_id,$part_barcode[$i],'$line_remark[$i]')");
			}


			if($barNumber>0){
					
				
				for($i=0;$i<$barNumber;$i++){
					if($part_barcode[$i] !=''){
						$checkQry = $this->db->query("SELECT LZ_PART_ISSUE_MT_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO=$part_barcode[$i]");
					// var_dump($checkQry);exit;
						if($checkQry->num_rows == 0){
							$this->db->query("UPDATE LZ_BARCODE_MT SET LZ_PART_ISSUE_MT_ID=$lz_part_issue_mt_id where BARCODE_NO='$part_barcode[$i]'");
						}
					}
					
					
				}
			}

			$this->db->query("UPDATE  LZ_PART_ISSUE_MT  P SET P.POSTED_YN = 1 WHERE P.LZ_PART_ISSUE_MT_ID = $lz_part_issue_mt_id");

			if($qry){

		        $this->session->set_flashdata('success', 'Record updated Successfully.');

		        return $lz_part_issue_mt_id;
		    }else{
		        $this->session->set_flashdata('error', 'Record Not Inserted.');
		    }
		}

	}
?>