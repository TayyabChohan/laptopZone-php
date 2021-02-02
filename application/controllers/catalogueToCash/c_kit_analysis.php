<?php
defined('BASEPATH') OR exit('No direct script access is allowed');
ini_set('memory_limit', '-1');
/**
* 
*/
class c_kit_analysis extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$CI = &get_instance();
		$this->db2 = $CI->load->database('bigData', TRUE);
		if (!$this->loginmodel->is_logged_in()) {
			redirect('login/login/');
		}
	}
	function index(){
		$data['pageTitle'] = 'kit analysis';
		//$data['kits'] 		= $this->m_kit_analysis->kits();
		$this->load->view('catalogueToCash/v_kit_analysis', $data); 
	}
	public function loadkits(){
        $data = $this->m_kit_analysis->loadkits();
        echo json_encode($data);
        return json_encode($data);		
	}
	public function loadNonKits(){
        $data = $this->m_kit_analysis->loadNonKits();
        echo json_encode($data);
        return json_encode($data);		
	}
	public function show_components(){
        $data = $this->m_kit_analysis->show_components();
        echo json_encode($data);
        return json_encode($data);		
	}
}