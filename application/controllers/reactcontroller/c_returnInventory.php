<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");

class c_returnInventory extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('reactcontroller/m_returnInventory');	    		
	}
	public function getAllInventory(){
		$data = $this->m_returnInventory->getAllInventory();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function saveReturn(){
		$data = $this->m_returnInventory->saveReturn();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function changeStatus(){
		$data = $this->m_returnInventory->changeStatus();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function cancelReturn(){
		$data = $this->m_returnInventory->cancelReturn();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function cancelJunk(){
		$data = $this->m_returnInventory->cancelJunk();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function createReturn(){
		$data = $this->m_returnInventory->createReturn();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function saveState(){
		$data = $this->m_returnInventory->saveState();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function getState(){
		$data = $this->m_returnInventory->getState();                
        echo json_encode($data);
   		return json_encode($data);
	}
	public function deleteState(){
		$data = $this->m_returnInventory->deleteState();                
        echo json_encode($data);
   		return json_encode($data);
	}
	
}	