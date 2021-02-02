<?php 

	class M_ServiceReceipt extends CI_Model{

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function serviceReceiptView(){

		    $receipt_view = $this->db->query("SELECT M.LZ_SERV_MT_ID, M.DOC_NO, TO_CHAR(M.EXPECTED_RETURN, 'MM/DD/YYYY') as EXPECTED_RETURN, TO_CHAR(M.DOC_DATE, 'DD/MM/YYYY HH24:MI:SS') as DOC_DATE, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.ENTERED_BY, M.STAX_PERC SALES_TAX_PERC,M.LZ_SERV_STAT_MT_ID, M.DISC_AMOUNT,M.SERVICE_CHARGES, G.PRICE, G.QTY FROM LZ_SERV_RECEIPT_MT M, (SELECT LZ_SERV_MT_ID, SUM((PRICE/QTY) * QTY) PRICE, SUM(QTY) QTY FROM LZ_SERV_RECEIPT_DET GROUP BY LZ_SERV_MT_ID) G WHERE M.LZ_SERV_MT_ID = G.LZ_SERV_MT_ID(+) ORDER BY M.DOC_NO DESC"); 
		    return $receipt_view->result_array();

		}
		public function receiptSearch(){
			$perameter = $this->input->post('receipt_search');	
			$query = $this->db->query("SELECT M.LZ_SERV_MT_ID, M.DOC_NO, TO_CHAR(M.EXPECTED_RETURN, 'MM/DD/YYYY') as EXPECTED_RETURN, TO_CHAR(M.DOC_DATE, 'DD/MM/YYYY HH24:MI:SS') as DOC_DATE, M.BUYER_PHONE_ID, M.BUYER_EMAIL, M.BUYER_ADDRESS, M.ENTERED_BY, M.STAX_PERC SALES_TAX_PERC, M.DISC_AMOUNT, G.PRICE, G.QTY FROM LZ_SERV_RECEIPT_MT M, (SELECT LZ_SERV_MT_ID, SUM(PRICE * qty) PRICE, SUM(QTY) QTY FROM LZ_SERV_RECEIPT_DET GROUP BY LZ_SERV_MT_ID) G WHERE M.LZ_SERV_MT_ID = G.LZ_SERV_MT_ID(+) AND (M.DOC_NO LIKE '%$perameter%' OR M.BUYER_PHONE_ID LIKE '%$perameter%' OR M.BUYER_EMAIL LIKE '%$perameter%' OR M.BUYER_ADDRESS LIKE '%$perameter%') ORDER BY M.DOC_NO DESC"); 
			return $query->result_array();
		}

		

		public function printInvoice($lz_serv_mt_id){

		   $print_qry = $this->db->query("SELECT DT.LZ_SERV_MT_ID,DT.LZ_SERV_DET_ID, DT.COMPONENT_ID, MT.DOC_NO,MT.ADVANCE_AMT, MT.PAY_MODE,MT.RET_PAY_MODE,MT.SERVICE_CHARGES, MT.STAX_PERC DET_SALES_TAX, NVL(SUM(DT.QTY), 0) QTY, NVL(SUM(DT.PRICE), 0) DET_PRICE, NVL(SUM(MT.DISC_AMOUNT), 0) DISC_AMT FROM LZ_SERV_RECEIPT_DET DT, LZ_SERV_RECEIPT_MT MT WHERE DT.LZ_SERV_MT_ID = $lz_serv_mt_id AND DT.LZ_SERV_MT_ID = MT.LZ_SERV_MT_ID GROUP BY  DT.COMPONENT_ID,DT.LZ_SERV_DET_ID,DT.LZ_SERV_MT_ID, MT.DOC_NO, MT.PAY_MODE,MT.SERVICE_CHARGES, MT.STAX_PERC,MT.ADVANCE_AMT,MT.RET_PAY_MODE");
		   
		   return $print_qry->result_array();
		}

		
		public function receiptComponent($lz_serv_mt_id){
			$component = $this->db->query("SELECT CP.LZ_COMPONENT_ID, CP.LZ_COMPONENT_DESC,DET.LZ_SERV_DET_ID, DET.COMPONENT_ID,DET.LZ_SERV_MT_ID FROM LZ_COMPONENT_MT CP, LZ_SERV_RECEIPT_DET DET WHERE DET.LZ_SERV_MT_ID = $lz_serv_mt_id AND DET.COMPONENT_ID = CP.LZ_COMPONENT_ID"); return $component->result_array();
		}

		public function changeStatus(){
			$data = $this->input->post('status');
			// var_dump($data);exit;
			$status = explode("/",$data);
			// var_dump($status[2]);
			$statusQry = $this->db->query("UPDATE LZ_SERV_RECEIPT_MT SET  STATUS = '$status[2]',LZ_SERV_STAT_MT_ID=$status[0] WHERE LZ_SERV_MT_ID =$status[1] ");
			if($statusQry){
				return true;
			}else{
				return false;
			}

		}

		public function selectStatus(){
			$query = $this->db->query("SELECT * FROM LZ_SERV_STAT_MT");
			return  $query->result_array();

		}

	
		

}