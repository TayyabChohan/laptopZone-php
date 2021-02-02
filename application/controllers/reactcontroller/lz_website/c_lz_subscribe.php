<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
  /**
  * Listing Controller
  */
class c_lz_subscribe extends CI_Controller
{
    
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('reactcontroller/m_react');
          
  }
  public function lz_customer_subscriber()
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('userName','Name','required|trim');
    $this->form_validation->set_rules('userEmail','Email','required|trim');
    $this->form_validation->set_rules('userMessage','Message','required|trim');
        if ($this->form_validation->run() == FALSE){
            echo json_encode(array("send" => false, "message" => validation_errors()));
            return json_encode(array("send" => false, "message" => validation_errors()));
        }else{
            $userName = $this->input->post('userName');
            $userEmail = $this->input->post('userEmail');
            $userMessage = $this->input->post('userMessage');
            
            $this->load->library('email');
            $config['mailtype'] = 'html';
            $config['charset']  = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
            $this->email->initialize($config);
            $this->email->from('info@laptopzone.us');
                $this->email->to('info@laptopzone.us');
                $this->email->subject('Laptop Zone | Subscribe');
                $this->email->message('Your Message : <br>' . $userMessage . '<br> Subscriber Name : ' . $userName . '<br> Subscriber Email : ' . $userEmail);
                if ($this->email->send()) {
                            echo json_encode(array(
                                "send" => true,
                                "message" => " Mail successfully send"
                            ));
                            return json_encode(array(
                                "send" => true,
                                "message" => " Mail successfully send"
                            ));
                        } else {
                            print_r($this->email->print_debugger());
                            echo json_encode(array(
                                "send" => false,
                                "message" => "Failed to send email"
                            ));
                            return json_encode(array(
                                "send" => false,
                                "message" => "Failed to send email"
                            ));
                        }
        }               
  }
}