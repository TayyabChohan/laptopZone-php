<?php
class c_bkComponents extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		 	if(!$this->loginmodel->is_logged_in())
		    	{
		      		redirect('login/login/');
		    	}		
	}
	/*********************************
	* FOR SHOWING COMPONENTS LISTING
	**********************************/
	function index()
	{
		$data['pageTitle'] = 'Components';
		$data['components']=$this->m_bkComponents->getAllComponents();
		$this->load->view("BundleKit/component/v_bkComponents", $data);		
	}
	/*********************************
	* FOR ADDING NEW COMPONENT
	**********************************/
	function addComponent()
	{
		$this->m_bkComponents->bk_addCompnent();
	}
	/*********************************
	* FOR DELETE COMPONENT
	**********************************/
	function componentDelete($component_id='')
	{
		$this->m_bkComponents->bk_deleteComponent($component_id);
	}
	/*********************************
	* SHOW COMPONENT UPDATION FORM
	**********************************/
	function showComponent($component_id='')
	{
		if(!empty($component_id) && $component_id!=='')
		{
			$data['component']=$this->m_bkComponents->getComponentById($component_id);
			$data['pageTitle'] = 'Add Components';
			$this->load->view("BundleKit/component/v_bkComponentUpdate", $data);			
		}
	}
	/*********************************
	* FOR UPDATE COMPONENT
	**********************************/
	function bkUpdateComponent($component_id='')
	{
		$this->m_bkComponents->bk_UpdateComponent($component_id);
	}

}