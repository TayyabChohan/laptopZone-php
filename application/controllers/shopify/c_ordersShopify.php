<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_ordersShopify extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->model("shopify/m_ordersShopify");  
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
    }
    public function index(){
        $result['pageTitle'] = 'Shopify Orders Details';
        $result['orders'] = $this->m_ordersShopify->ordersDetails();
        $this->load->view('shopify/v_ordersShopify', $result);
    }
    public function getAllShopifyOrders(){

        $this->m_ordersShopify->getAllShopifyOrders();
        $data["result"] = $this->session->userdata("status");
        //var_dump($data['result']);exit;
        echo json_encode($data);
        return json_encode($data); 

    }
    public function checItemoneBay(){
        $data = $this->m_ordersShopify->checItemoneBay();
        echo json_encode($data);
        return json_encode($data); 

    }
    public function reviseQuantityonShopify(){
        $data = $this->m_ordersShopify->reviseQuantityonShopify();
    }
    public function deleteItemfromShopify(){
        $data = $this->m_ordersShopify->deleteItemfromShopify();        
    }
    public function testCall(){
        $ebay_id = "302929200533";
        $result['ebay_id'] = $ebay_id;
        $this->load->view("ebay/trading/shopify/getitem_additonShopify", $result);

    }



}
