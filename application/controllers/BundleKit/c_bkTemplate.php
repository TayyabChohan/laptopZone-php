<?php
class c_bkTemplate extends CI_Controller
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
	function index()
	{
		$data['components']=$this->m_bkTemplate->getAllComponents();
		$data['templates']=$this->m_bkTemplate->getAllTemplates();
		$data['pageTitle'] = 'Templates';
		$this->load->view("BundleKit/template/v_bkTemplate", $data);
	}
	/**********************************
	*  FOR CREATING NEW TEMPLATE
	***********************************/
	function addTemplate()
	{		
		$this->m_bkTemplate->bk_addTemplate();
	}
	/**********************************
	*  FOR TEMPLATE DETAIL PAGE
	***********************************/
	function showTemplateDetail($template_id='')
	{
		$this->m_bkTemplate->bk_templateDetail($template_id);
	}
	/**********************************
	*  FOR EDITING TEMPLATE
	***********************************/
	function editTemplateDetail($template_id='')
	{
		$this->m_bkTemplate->bk_editTemplate($template_id);
	}
	/**********************************
	*  FOR DELETING TEMPLATE
	***********************************/
	function templateDelete($template_id='')
	{
		$this->m_bkTemplate->bk_deleteTemplate($template_id);	
	}
	/**************************************
	*  FOR SHOWING COMPONENTS ADDING PAGE
	***************************************/
	function addMoreComponents($template_id='')
	{
		if(!empty($template_id) && $template_id!=='')
		{
			$data['components']=$this->m_bkTemplate->getAllComponents();
			$data['details']=$this->m_bkTemplate->getDetailById($template_id);
			$data['pageTitle'] = 'Update Template';
			$this->load->view("BundleKit/template/v_bk_updateTemplate", $data);	
		}
	}
	/***********************************************
	*  FOR ADDING MORE COMPONENTS
	*************************************************/
	function addMoreComponentsToTemplate($template_id='')
	{
		//var_dump($template_id); exit;
		$this->m_bkTemplate->bk_UpdateTemplate($template_id);	
	}
	/***********************************************
	*  FOR DELETING TEMPLATE'S COMPONENTS
	*************************************************/
	function bk_deleteTempComponent($detail_id='', $template_id="")
	{
		$this->m_bkTemplate->bk_deleteComponentOfTemplate($detail_id, $template_id);		
	}
	/***********************************************
	*  FOR UPDATING TEMPLATE COMPONENT'S QUANTITIES
	*************************************************/
	function bk_edit_quantity()
	{
		$this->m_bkTemplate->bk_editTemplateComponentsQuantity();		
	}

}