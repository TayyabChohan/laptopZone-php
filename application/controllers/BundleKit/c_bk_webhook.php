<?php
class c_bk_webhook extends CI_Controller
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
		$data['pageTitle'] = 'Webhook';
		$data['webhooks']=$this->m_bk_webhook->bk_getAll();
		$this->load->view("BundleKit/webhook/v_webhook_listing", $data);
	}
	/**********************************
	*  FOR CREATING NEW WEBHOOK
	***********************************/
	function showWebhookForm()
	{
		$data['pageTitle'] = 'Add Webhook';
		$this->load->view("BundleKit/webhook/v_bk_webhook", $data);
	}
	/**********************************
	*  FOR INSERTING NEW WEBHOOK DATA
	***********************************/
	function addWebhook()
	{
		$this->m_bk_webhook->bk_addWebhook();
	}
	/**********************************
	*  FOR GETTING ALL WEBHOOKS
	***********************************/
	function getAllWebhooks()
	{
		$data['pageTitle'] = 'All Webhooks';
		$data['webhooks']=$this->m_bk_webhook->bkWebhooks();
		$this->load->view("BundleKit/webhook/v_bkShowAllData", $data);
	}
	/**********************************
	*  FOR SHOW WEBHOOK DETAIL
	***********************************/
	function webhookDetail($webhook_id='')
	{
		$data['pageTitle'] = 'Webhook Detail';
		$data['webhooks']=$this->m_bk_webhook->bk_getWebhookDetail($webhook_id);
		$this->load->view("BundleKit/webhook/v_bkWebHookDetail", $data);
	}
	/**********************************
	*  FOR DELETING WEBHOOK
	***********************************/
	function deleteWebhook($webhook_id='')
	{
		$this->m_bk_webhook->bk_deleteWebhook($webhook_id);			
	}
	/**********************************
	*  FOR DOWNLOAD WEBHOOKS 
	***********************************/
	function pullWebhookData($webhook_id='')
	{
		$result['data'] = $this->m_bk_webhook->pullWebhookData($webhook_id);
		$this->load->view('ebay/async/finditemswebhook',$result);
		$this->load->view('ebay/async/solditemswebhook',$result);
		redirect('BundleKit/c_bk_webhook/webhookDetail/'.$webhook_id);
	}
	/**********************************
	*  FOR DELETING WEBHOOK DETAIL 
	***********************************/
	function deleteWebhookDetail($ebay_id='', $webhook_id='', $webhook_condition='', $webhook_status='')
	{
		$this->m_bk_webhook->wh_delete($ebay_id, $webhook_id, $webhook_condition, $webhook_status);
	}
	/**********************************
	*  FOR FILTERING WEBHOOK DATA 
	***********************************/
	function webhookFilters()
	{
	  	$webhook_id=$this->input->post('webhook_list');
	  	$webhook_condition=$this->input->post('webhook_condition');
	  	$webhook_status=$this->input->post('webhook_status');
        $data['webhooks'] = $this->m_bk_webhook->wh_filters($webhook_id, $webhook_condition, $webhook_status);      
        $this->load->view("BundleKit/webhook/v_bkShowAllData", $data);
    }
    function filtersStatus($webhook_id='', $webhook_condition='', $webhook_status='')
	{
        $data['webhooks'] = $this->m_bk_webhook->wh_saveStatus($webhook_id, $webhook_condition, $webhook_status);
        $this->load->view("BundleKit/webhook/v_bkShowAllData", $data);
    }
    /**********************************************
	*  FOR FOR INSERTING UPC, MPN AND MANUFACTURER 
	***********************************************/
    function save_upc_mpn()
	{
        $data['webhooks'] = $this->m_bk_webhook->wh_save_mpn_upc();
    }

}