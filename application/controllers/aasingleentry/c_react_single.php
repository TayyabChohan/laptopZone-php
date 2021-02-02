<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
	/**
	* Listing Controller
	*/
class c_react_single extends CI_Controller
{
		
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('aasingleentry/m_react_single');
	    		
	}

	public function index(){

		$this->load->view('aasingleentry/v_react_single');


	}
	public function load_dumy_data(){	
		
		$data = $this->m_react_single->load_dumy_data();                
        echo json_encode($data);
   		return json_encode($data);
	}

	public function load_single_entry(){
		$id = NULL;
		//$se_radio = $this->input->post('se_radio');
		$se_radio =NULL;
		$data = $this->m_react_single->load_single_entry($id,$se_radio);	
		
		echo json_encode($data);
   		return json_encode($data);
	}


	public function save_single_entry(){
		$data = $this->m_react_single->save_single_entry();
		echo json_encode($data);
   		return json_encode($data);

	}

	public function load_condion(){
		$data = $this->m_react_single->load_condion();
		echo json_encode($data);
   		return json_encode($data);

	}
}