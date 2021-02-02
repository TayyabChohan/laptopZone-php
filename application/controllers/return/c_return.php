<?php

class c_return extends CI_Controller{
	public function __construct(){
	    parent::__construct();
	    $this->load->database();
	    $this->load->model('reports/m_offer_report');
        $this->load->helper('security');
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
  public function processReturn(){
    $result = $this->m_return->processReturn();

  }


 }