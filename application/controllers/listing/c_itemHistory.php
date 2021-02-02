<?php
class C_itemHistory extends CI_Controller
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
		//echo "c_itemHistory index"; exit;
		$data['pageTitle'] = 'Item Search';
		$this->load->view("listing_views/item_search_view", $data);
	}
	function search_history($barcode='')
	{
		$data['pageTitle'] = 'Item History';
		if ($this->input->post("bd_submit")) {
			$data['item_barcode']=$this->input->post("bd_item_search");
		}else {
			$data['item_barcode']=$barcode;
		}
		$data['items']=$this->m_itemHistory->item_manifest($data['item_barcode']);
		
		if ($data['items']=="no_barcode"){
				$this->session->set_flashdata('warning',"Please enter valid barcode");
				$this->session->set_flashdata('placeholder',"Please enter barcode");
				redirect(site_url()."listing/c_itemHistory");
			}elseif($data['items']['return']=="true"){
					$data['pageTitle'] = 'Item History';
					$this->load->view("listing_views/v_itemHistory", $data);
				}
	}

}
