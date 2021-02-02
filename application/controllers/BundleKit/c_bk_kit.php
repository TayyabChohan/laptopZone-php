<?php
class c_bk_kit extends CI_Controller
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
		$data['kits']=$this->db->query("SELECT * FROM LZ_BK_KIT_MT, LZ_BK_ITEM_MT WHERE LZ_BK_KIT_MT.LZ_BK_ITEM_ID=LZ_BK_ITEM_MT.LZ_BK_ITEM_ID ORDER BY LZ_BK_KIT_ID DESC");
		$data['pageTitle'] = 'Kit List';
		$this->load->view("BundleKit/kit/v_kitsList", $data);
	}
	function addKitForm()
	{
		$data['items']=$this->m_bk_kit->bk_kitData();
		$data['components'] = false;
		$data['pageTitle'] = 'Create Kit';
		$this->load->view("BundleKit/kit/v_bk_kit", $data);
	}
	function showDataForKit()
	{
		$item_id=$this->input->post('bk_kit_item');
		$kit_keyword=$this->input->post('kit_keyword');
		$data['items']=$this->m_bundlekit->bk_kitData();
		$data['components']=$this->m_bk_kit->dataForKitDetail($item_id);
		$data['pageTitle'] = 'Create Kit';
		$this->load->view("BundleKit/kit/v_bk_kit", $data);
	}
	function savekitData()
	{
		$ressult=$this->m_bk_kit->kitData();
	}
	function deleteKit($kit_id='')
	{			
		$this->m_bk_kit->deleteKitData($kit_id);	
	}
	function showKitDetail($kit_id='', $template_id='')
	{
		$data['kits']=$this->m_bk_kit->kitDetail($kit_id, $template_id);
		$data['pageTitle'] = 'Kit Detail';
		$this->load->view("BundleKit/kit/v_kitDetail", $data);
	}
	function deleteKitComponent($detail_id='', $kit_id='')
	{			
		$this->m_bk_kit->deleteKitComponent($detail_id, $kit_id);		
	}
	function updateKitPrice()
	{
		$data['pageTitle'] = 'Update Manuale Price';
		$data['items']=$this->m_bk_kit->updateManualPrice();				
	}
	function addMoreForKit()
	{
		if ($this->input->post('edit_rofile')) {
			$this->form_validation->set_rules('kit_name', 'kit name', 'trim');
			$this->form_validation->set_rules('bk_kit_item', 'item name', 'trim');
				if($this->form_validation->run()==FALSE)
					{
						$this->session->set_flashdata('compo',"Empty required data");
	        			//redirect(site_url()."BundleKit/c_bk_kit/showKitDetail");
					}else{
						$data['kit_name']=$this->input->post('kit_name');
						$data['kitId']=$this->input->post('kitId');
						$data['itemId']=$this->input->post('itemId');
						$data['bk_kit_item']=$this->input->post('bk_kit_item');
						$data['items']=$this->m_bk_kit->bk_kitData();
						$data['components']=$this->m_bk_kit->dataForKitDetail($data['itemId']);
						$data['pageTitle'] = 'Update kit';
						$this->load->view("BundleKit/kit/v_bk_kit_edit", $data);		
					}	
		}
						
	}
	function updateKitData()
	{
		//$activePrice=$this->input->post('activePrice');
		//var_dump($activePrice); exit; 
		$ressult=$this->m_bk_kit->addkitData();				
	}
	function updateKitComponents()
	{
		$ressult=$this->m_bk_kit->updateKitComponents();	
	}
	function addNewComponents()
	{
		$ressult=$this->m_bk_kit->addComponents();	
	}
	
}