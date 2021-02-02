<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_unverified extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/    
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
  }
  public function index()
    {
      // $data = $this->m_unverified->get_mastermpn();
      // echo json_encode($data);
      // return json_encode($data);
    }
  public function get_mastermpn(){
    $data = $this->m_unverified->get_mastermpn();
      echo json_encode($data);
      return json_encode($data);        
  }
  public function verifyMPN()
  {
    $data = $this->m_unverified->verifyMPN();
    echo json_encode($data);
    return json_encode($data);
  }

   
}
