<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_Menu extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		 // if(!$this->loginmodel->is_logged_in())
		 //     {
		 //       redirect('login/login/');
		 //     }		
		$this->load->model('accounting/m_menu');
	}

	public function menu_tree(){


		$data['dropdown'] = $this->m_menu->st_data();
		
		$data['sub_menu'] = $this->m_menu->type_data();
		$data['seg_menu'] = $this->m_menu->segm_data();
		
 		   
		
		$this->load->view('accounting/v_menue',$data); 
		 

	}
	
}