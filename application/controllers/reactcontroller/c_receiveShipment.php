<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_receiveShipment extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_receiveShipment');	    		
	}
	public function getTrackingNo(){
		$data = $this->m_receiveShipment->getTrackingNo();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteReceiveBox(){
		$data = $this->m_receiveShipment->deleteReceiveBox();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getShipmentBarcodes(){
		$data = $this->m_receiveShipment->getShipmentBarcodes();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteReceiveBarcode(){
		$data = $this->m_receiveShipment->deleteReceiveBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function allReceiveBoxes(){
		$data = $this->m_receiveShipment->allReceiveBoxes();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getReceiveBarcodes(){
		$data = $this->m_receiveShipment->getReceiveBarcodes();                
        echo json_encode($data);
   		return json_encode($data);
	}
}	