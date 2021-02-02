<?php

class c_android_order_pulling extends CI_Controller{
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model('order_pulling/m_android_order_pulling');
        $this->load->helper('security');     
  }
  public function getAllDataCombined(){
    $data = $this->m_android_order_pulling->getAllDataCombined();                
    echo json_encode($data);
       return json_encode($data);
}
  public function getAwaitingOrders(){
    $data = $this->m_android_order_pulling->getAwaitingOrders();                
    echo json_encode($data);
       return json_encode($data);
}
  public function getMerchants(){
		$data = $this->m_android_order_pulling->getMerchants();                
        echo json_encode($data);
   		return json_encode($data);
  }
  public function getSignInResult(){
    $data = $this->m_android_order_pulling->getSignInResult();                
    echo json_encode($data);
       return json_encode($data);
    }
    public function pull(){
      $data = $this->m_android_order_pulling->pull();                
      echo json_encode($data);
         return json_encode($data);
      }
 
      public function getPulledRecord(){
        $data = $this->m_android_order_pulling->getPulledRecord();                
        echo json_encode($data);
           return json_encode($data);
    }
}