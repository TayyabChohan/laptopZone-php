<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class c_Template extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		 if(!$this->loginmodel->is_logged_in())
		     {
		       redirect('login/login/');
		     }		
	}
	function index()
	{
		$this->load->view('BundleKit/v_TemplateForm');
	}
	function addTemplate()
	{
		//echo "dsfdsf";
		//exit;
		$this->form_validation->set_rules('component[]', 'component', 'required');
		$this->form_validation->set_rules('item_type', 'item_type', 'required');
		$this->form_validation->set_rules('sr_name', 'sr_name', 'required');
		if($this->form_validation->run()==FALSE)
		{
			echo validation_errors();
			exit;
		}else {
			$data['item_type']=$this->input->post('item_type');
			$data['sr_name']=$this->input->post('sr_name');
			$data['components']=$this->input->post('component');
				if(empty($data['components']) || !is_array($data['components'])){
        			echo "Invalid data was supplied";
        			//return false;
    			}else{
    					$data['components']=implode(',', $data['components']);
    				}

			echo "<pre>";
			print_r($data);
			exit;
			}
		
	}
}