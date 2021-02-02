<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_shipment extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_shipment');	    		
	}
	public function getAllShipment(){
		$data = $this->m_shipment->getAllShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getAllBoxes(){
		$data = $this->m_shipment->getAllBoxes();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteShipment(){
		$data = $this->m_shipment->deleteShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function handleBoxDelete(){
		$data = $this->m_shipment->handleBoxDelete();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteBox(){
		$data = $this->m_shipment->deleteBox();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getBoxDetails(){
		$data = $this->m_shipment->getBoxDetails();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getAllBoxesBarcodes(){
		$data = $this->m_shipment->getAllBoxesBarcodes();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function addShipment(){
		$data = $this->m_shipment->addShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateShipment(){
		$data = $this->m_shipment->updateShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function addShipmentDtTmp(){
		$data = $this->m_shipment->addShipmentDtTmp();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function editCreateShipmentDtTmp(){
		$data = $this->m_shipment->editCreateShipmentDtTmp();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function editShipmentDtTmp(){
		$data = $this->m_shipment->editShipmentDtTmp();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteShipmentDtTmp(){
		$data = $this->m_shipment->deleteShipmentDtTmp();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteTempBarcode(){
		$data = $this->m_shipment->deleteTempBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function createBox(){
		$data = $this->m_shipment->createBox();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function saveEditBarcodes(){
		$data = $this->m_shipment->saveEditBarcodes();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function createNewBoxOldShipment(){
		$data = $this->m_shipment->createNewBoxOldShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateCarrierOldShipment(){
		$data = $this->m_shipment->updateCarrierOldShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function ActionDeleteBarcode(){
		$data = $this->m_shipment->ActionDeleteBarcode();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function handleEditSearchOldBox(){
		$data = $this->m_shipment->handleEditSearchOldBox();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateTrackingNoOldShipment(){
		$data = $this->m_shipment->updateTrackingNoOldShipment();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteBoxBarcodeEdit(){
		$data = $this->m_shipment->deleteBoxBarcodeEdit();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateTrackingNo(){
		$data = $this->m_shipment->updateTrackingNo();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function updateCarrier(){
		$data = $this->m_shipment->updateCarrier();                
        echo json_encode($data);
   		return json_encode($data);
	}
}	