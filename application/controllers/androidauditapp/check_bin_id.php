<?php 

  class check_bin_id extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
 
   public function index()
  {

    if ( isset($_POST['binid']) )
    {
      $this->load->model('androidauditapp/general_mod','handler');
      $data = $this->handler->getbinsearchdata($_POST['binid']);
      if (count($data) > 0)
      {
        echo(json_encode(array(
          "error"=>false,
          "api_message"=>"record found!"
         )));
      }
      else
      {
        echo(json_encode(array(
          "error"=>true,
          "api_message"=>"record not found!"
         )));
      }
    			
      }
      else 
     {
         echo(json_encode(array(
           "error"=>true,
           "api_message"=>"Empty Paraeters!"
           )));
      }
    
  }

}