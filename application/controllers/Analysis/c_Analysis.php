<?php

class c_Analysis extends CI_Controller{
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model('Analysis/m_Analysis');
      $this->load->helper('security');
          
      if(!$this->loginmodel->is_logged_in())
       {
         redirect('login/login/');
       }      
  }

  public function index(){
    $result['pageTitle'] = 'Active Listing'; 
    $result['data'] = $this->m_Analysis->activeListing();
    $this->load->view('Analysis/v_activeListing',$result);
  } 

 public function activeListing(){
    $result['pageTitle'] = 'Active Listing'; 
    $result['data'] = $this->m_Analysis->activeListing();
    $this->load->view('Analysis/v_activeListing',$result);
  }
  public function filterData(){
    $rslt = $this->input->post('date_range');
    $price_filter = $this->input->post('price_filter');
    //var_dump($rslt,$price_filter); exit;
    $this->session->set_userdata('date_range', $rslt);
    $this->session->set_userdata('price_filter', $price_filter);
    
    echo json_encode($rslt);
    return json_encode($rslt);
  } 

  public function getData()
  {
    if ($this->input->post('Submit'))
    {
      $this->load->model('Analysis/m_Analysis');
      $result['user_id'] = 2;
      $result['data'] = $this->m_Analysis->getData();
      $this->load->view('ebay/finding/getSoldItems',$result);
      $this->load->view('ebay/finding/getActiveItems',$result);
      $this->activeListing();
    }        
  }

} 