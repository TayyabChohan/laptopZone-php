<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_listItemtoShopify extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->model("shopify/m_listItemtoShopify");
    // $this->load->model("bigData/m_recog_title_mpn_kits");
    /*=============================================
    =  Section lz_bigData db connection block  =
    =============================================*/
    // $CI = &get_instance();
    // //setting the second parameter to TRUE (Boolean) the function will return the database object.
    // $this->db2 = $CI->load->database('bigData', TRUE);

    /*=====  End of Section lz_bigData db connection block  ======*/    
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
    }
    public function index(){
        $result['pageTitle'] = 'Import Item to Shopify';
        $this->load->view('shopify/v_listItemtoShopify', $result);
    }
    public function ImportItemShopify(){
        $data['ebay_id'] = $this->input->post('ebay_id');
        //var_dump($ebay_id);exit;
        $this->load->view('ebay/trading/shopify/getitem_shopify',$data);
        $data = $this->session->userdata("response");
        echo json_encode($data);
        return json_encode($data); 

    }
    public function Bulk_getitem_shopify(){
        $this->load->view('ebay/trading/shopify/Bulk_getitem_shopify');        
        
    }
    public function getsellerlist_shopify(){
        $this->load->view('ebay/trading/shopify/getsellerlist_shopify');

    }
    public function Bulk_deleteItem_Shopify(){
        $this->load->view('ebay/trading/shopify/Bulk_deleteItem_Shopify');  
    }
    public function insertShopifyItems(){
        $data = $this->m_listItemtoShopify->insertShopifyItems();
    }
    public function listOnShopify(){
        $data = $this->m_listItemtoShopify->listOnShopify();
        echo json_encode($data);
        return json_encode($data); 
    } 
    public function insertBarcodeSku(){
        $this->m_listItemtoShopify->insertBarcodeSku();
    }
    public function deleteItemfromShopifyandSystem()
    {
        $this->m_listItemtoShopify->deleteItemfromShopifyandSystem();
        
    }



}
