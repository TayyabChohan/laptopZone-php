<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
  /**
  * Listing Controller
  */
class c_lzw_shipment extends CI_Controller
{
    
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('adilModels/m_lzw_shipment');
          
  }
  public function get_shipping_charges()
  {
        $data = $this->m_lzw_shipment->callEasyPost();
        echo json_encode($data);
  }
}