<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_receiveReturn extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_receiveReturn');	    		
	}
	public function getReceiveRequests(){
		$data = $this->m_receiveReturn->getReceiveRequests();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getNotListedItems(){
		$data = $this->m_receiveReturn->getNotListedItems();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getListedItems(){
		$data = $this->m_receiveReturn->getListedItems();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getBarcodesByEbayId(){
		$data = $this->m_receiveReturn->getBarcodesByEbayId(); 

		$ebay_id  = $this->input->post("ebay_id");
		$quantity = count($data["ebayBarcodes"]);
        $this->list_item_confirm_merg($ebay_id,$quantity);

		if($this->session->userdata("currentQty")){
			$currentQty = $this->session->userdata("currentQty");
			$data['message'] = "Successfull";
			$data['currentQty'] = $currentQty;
			$data["found"] = true;
			$this->session->unset_userdata("currentQty");
		 }else{
			 $message = $this->session->userdata("message");
			$data['message'] = $message;
			$data["found"] = false;
			$this->session->unset_userdata("message");
		 }

        echo json_encode($data);
   		return json_encode($data);
	}
	function list_item_confirm_merg($ebayItemId, $quantity){

    //3rd permetr condition

      $ebay_id = $ebayItemId;
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID,E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
      $old_item = $query->result_array();
    $account_id = $old_item[0]['LZ_SELLER_ACCT_ID'];


      $qty = $quantity;
      $data['ebay_id'] = $ebay_id;     
      $data['account_name'] = $account_id;
      $data['process'] = "getQuantity";
	  $this->load->view('ebay/trading/RevisefixedpriceitemReturn',$data,true);
		 
	}
	public function proceedProcess(){
		$data = $this->m_receiveReturn->getBarcodesByEbayId(); 

		$ebay_id  = $this->input->post("ebay_id");
		$merch_id  = $this->input->post("merch_id");
		$returnQty  = $this->input->post("returnQty");
		$currentQty  = $this->input->post("currentQty");

        $this->list_item_confirm_process($ebay_id,$returnQty,$currentQty);

		if($this->session->userdata("message") == true){
			$currentQty = $this->session->userdata("message");
			$data['message'] = "Successfull";
			$data["found"] = true;
		 }else{
			 $message = $this->session->userdata("message");
			$data['message'] = $message;
			$data["found"] = false;
		 }

        echo json_encode($data);
   		return json_encode($data);
	}
	function list_item_confirm_process($ebayItemId, $returnQty, $currentQty){

      $ebay_id = $ebayItemId;
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID,E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
      $old_item = $query->result_array();
	$account_id = $old_item[0]['LZ_SELLER_ACCT_ID'];
	
      $data['returnQty'] = $returnQty;     
      $data['currentQty'] = $currentQty;     
      $data['ebay_id'] = $ebay_id;     
      $data['account_name'] = $account_id;
	  
	  
	  if((int)$returnQty == (int)$currentQty){
		$data = $this->endItem($ebay_id,"");
	  }else{
		  $data['process'] = "revise";
		$this->load->view('ebay/trading/RevisefixedpriceitemReturn',$data,true);
	  }
	  
		 
	}
public function endItem($ebay_id,$remarks){

    $result['ebay_id'] = $ebay_id;
    $result['remarks'] = $remarks;
    //$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID,A.SELL_ACCT_DESC FROM EBAY_LIST_MT E , LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array();

    //$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM = 1")->result_array(); 
    $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC , S.EBAY_LOCAL FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A , LZ_ITEM_SEED S WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND S.SEED_ID = E.SEED_ID AND E.EBAY_ITEM_ID =  '$ebay_id' AND ROWNUM = 1")->result_array(); 
    $account_name = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
    
    if(!empty(@$get_seller[0]['EBAY_LOCAL'])){
      $site_id = @$get_seller[0]['EBAY_LOCAL'];
    }else{
      $site_id = 0;
    }
    $result['site_id'] = $site_id;
    if(!empty(@$account_name)){
      $result['account_name'] = $account_name;
    }
    

    $data = $this->load->view('ebay/trading/endItemReturn',$result);
    if($data){
      $data = $this->endItemSystem($ebay_id);

    }
    echo json_encode($data);
    return json_encode($data);    
  }
  public function endItemSystem($ebay_id){
	
	// check if item sold or not
	$check_sold = $this->db->query("SELECT * FROM LZ_SALESLOAD_DET D WHERE D.ITEM_ID = '$ebay_id'"); 
	if($check_sold->num_rows() > 0){
		$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL");
	}else{
		$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL"); 

		$delete_qry = $this->db->query("DELETE FROM LZ_LISTING_ALLOC WHERE LIST_ID IN (SELECT LIST_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id')");

		$delete_qry = $this->db->query("DELETE FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id'");

		$delete_url = $this->db->query("DELETE FROM LZ_LISTED_ITEM_URL U WHERE U.EBAY_ID =  '$ebay_id'"); 

		
	}
}
	public function approveAdmin(){
		$data = $this->m_receiveReturn->approveAdmin();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function processRequest(){
		$data = $this->m_receiveReturn->processRequest();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function cancelRequest(){
		$data = $this->m_receiveReturn->cancelRequest();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getReturns(){
		$data = $this->m_receiveReturn->getReturns();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getJunks(){
		$data = $this->m_receiveReturn->getJunks();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getMerchants(){
		$data = $this->m_receiveReturn->getMerchants();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getReturnRequests(){
		$data = $this->m_receiveReturn->getReturnRequests();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function scanBin(){
		$data = $this->m_receiveReturn->scanBin();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function scanBarcode(){
		$data = $this->m_receiveReturn->scanBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function processComplete(){
		$data = $this->m_receiveReturn->processComplete();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function scanBarcodeShipment(){
		$data = $this->m_receiveReturn->scanBarcodeShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function createBoxBtn(){
		$data = $this->m_receiveReturn->createBoxBtn();                
        echo json_encode($data);
   		return json_encode($data);
	}
	

}	