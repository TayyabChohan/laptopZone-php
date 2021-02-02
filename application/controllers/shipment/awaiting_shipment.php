<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* Shipment Controller
	*/
	class Awaiting_Shipment extends CI_Controller
	{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function index(){
		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE){
			$data['total_price_quantity'] = $this->awt_shipment->sum_price_quantity();
			$data['pageTitle'] = 'Awaiting Shipment';
			$this->load->view('awaiting_shipment/shipment_view', $data);
		}else{
			redirect('login/login/');
		}
	}

	public function downloadOrders(){
		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE){
			$data['sellers'] = $this->awt_shipment->getAccount();
			$data['pageTitle'] = 'Download Orders';
			$this->load->view('awaiting_shipment/v_downloadOrders', $data);
		}else{
			redirect('login/login/');
		}
	}

	public function loadShipment(){
	$data = $this->awt_shipment->loadShipment();
    echo json_encode($data);
    return json_encode($data);
	}
	public function awt_search(){
			$data['search_shipment'] = $this->input->post('shipment_radio');
			//var_dump($data['search_shipment']); exit;
			$data['total_price_quantity'] = $this->awt_shipment->sum_price_quantity();
			$data['pageTitle'] = 'Awaiting Shipment';
			$this->load->view('awaiting_shipment/v_search_shipment_view', $data);
		
	}
	public function loadSearchShipment(){
		echo "jjxs"; exit;
	$data = $this->awt_shipment->loadSearchShipment();
    echo json_encode($data);
    return json_encode($data);
	}

	/*public function awt_searchh(){
 		$submit = $this->input->post('Submit');
	    $awt_radio = $this->input->post('awt');
	    //var_dump($awt_radio); exit;
  		  if ($submit)
  		  {
		    if ($awt_radio){
		        //$data = $this->awt_shipment->queryRadio($awt_radio);
		        $data['shipment'] = $this->awt_shipment->queryRadio($awt_radio);
				$data['total_price_quantity'] = $this->awt_shipment->dataRadio($awt_radio);
				$data['pageTitle'] = 'Search Awaiting Shipment';
				$this->load->view('awaiting_shipment/v_search_shipment_view', $data);
		    }else{
		        echo "Please Select either radio button on input Search text";
		    }
        }
	}*/
	public function date_range()
	{
		$rslt = $this->input->post('daterange-btn');
		$rs = explode('-',$rslt);
		$fromdate = $rs[0];
		$todate = $rs[1];
		/*===Convert Date in 24-Apr-2016===*/
		$fromdate = date_create($rs[0]);
		$todate = date_create($rs[1]);
		$from = date_format($fromdate,'d-M-y');
		$to = date_format($todate, 'd-M-y');

		$this->awt_shipment->date_filter($from, $to);
	}
}



 ?>