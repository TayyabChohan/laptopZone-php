<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_shipQueue extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_shipQueue');	    		
	}
	public function getAllQueues(){
		$data = $this->m_shipQueue->getAllQueues();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function holdBarcode(){
		$data = $this->m_shipQueue->holdBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function unholdBarcode(){
		$data = $this->m_shipQueue->unholdBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function editPrice(){
		$data = $this->m_shipQueue->editPrice();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function editCost(){
		$data = $this->m_shipQueue->editCost();                
        echo json_encode($data);
   		return json_encode($data);
	}
}	