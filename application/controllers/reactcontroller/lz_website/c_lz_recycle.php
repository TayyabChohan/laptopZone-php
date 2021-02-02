<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
  /**
  * Listing Controller
  */
class c_lz_recycle extends CI_Controller
{
    
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('adilModels/m_recycle');
          
  }
  public function lz_recyle_form()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('full_name','Name','required|trim');
    $this->form_validation->set_rules('email','Email','required|trim');
    $this->form_validation->set_rules('phone','Phone','required|trim');
    $this->form_validation->set_rules('remarks','Remakrs','required|trim');
    
        if ($this->form_validation->run() == FALSE){
            echo json_encode(array("insert" => false, "message" => validation_errors()));
            return json_encode(array("insert" => false, "message" => validation_errors()));
        }else{
            
            if($this->m_recycle->lz_recyle_form()){
                echo json_encode(array("insert" => true, "message" => "Thanks for contact us"));
                return json_encode(array("insert" => true, "message" => 'Thanks for contact us'));
            }else{
                echo json_encode(array("insert" => false, "message" => "SOmething went wrong"));
                return json_encode(array("insert" => false, "message" => "SOmething went wrong"));
            }
           
            
        }               
  }
  public function save_pull_request()
  {
    $data = $this->m_recycle->save_pull_request();                
    echo json_encode($data);
    return json_encode($data);
  }
}