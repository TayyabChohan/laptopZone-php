<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("display_errors",1);
	/**
	* Shipment Controller
	*/
	class Paid_Shiped extends CI_Controller
	{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
	  if(!$this->loginmodel->is_logged_in())
	   {
	     redirect('login/login/');
	   }		
	}

	public function index(){

		$status = $this->session->userdata('login_status');
		$login_id = $this->session->userdata('user_id');
		if(@$login_id && @$status == TRUE)
		{
		$data['sum_total_ebay'] = $this->paid_shipped->sum_total_ebay();
		$data['total_sale_price'] = $this->paid_shipped->sum_total_ebay();

		$from = date('m/d/Y', strtotime('-3 days'));// date('m/01/Y');
		$to = date('m/d/Y');
		$rslt =$from." - ".$to;
		//var_dump($rslt);
		$this->session->set_userdata('date_range', $rslt);
		$data['pageTitle'] = 'Paid & Shipped';
		$this->load->view('shipped_view/shipped_view', $data);

		}else{
			redirect('login/login/');
		}

	}
	public function loadPaidShipped(){
        $data         = $this->paid_shipped->loadPaidShipped();
        echo json_encode($data);
        return json_encode($data);     
    }
   
	public function paid_search(){
 		$submit = $this->input->post('Submit');
	    $paid_btn_radio = $this->input->post('paid');
	    $rslt = $this->input->post('date_range');
        $this->session->set_userdata('date_range', $rslt);
        $this->session->set_userdata('paid', $paid_btn_radio);

        $rs = explode('-',$rslt);
        $fromdate = $rs[0];
        $todate = $rs[1];

        /*===Convert Date in 24-Apr-2016===*/
        $fromdate = date_create($rs[0]);
        $todate = date_create($rs[1]);

        $from = date_format($fromdate,'d-m-y');
        $to = date_format($todate, 'd-m-y');

  		  if ($submit)
  		  {
		    if ($paid_btn_radio){
		        $data['sum_total_ebay'] =  $this->paid_shipped->paidRadio($paid_btn_radio,$from,$to);
	        	$data['pageTitle'] = 'Paid & Shipped';
	            $this->load->view('shipped_view/v_search_shipped_view', $data);
		    }else{
		          	echo "Please Select either radio button on input Search text";
		    }
        }
	}
	public function loadPaidSearch(){
		$data =  $this->paid_shipped->loadPaidSearch();
		echo json_encode($data);
        return json_encode($data);	
	}
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
		//var_dump($from,$to);exit;
		$this->awt_shipment->date_filter($from, $to);

	}	


}



 ?>