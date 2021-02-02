<?php

class c_kitExprUpload extends CI_Controller{
	public function __construct(){
	      parent::__construct();
	      $this->load->database();
        $this->load->model('catalogue/m_kitExprUpload');
        /*============================ =================
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
	     // $this->load->model('manifest_loading/csv_model');
  	}

  	 public function index(){
      $result['pageTitle'] = 'kit expr upload';
      $this->load->view('catalogue/v_kitExprUpload',$result);
      
  	}

  	  public function uploadCSV()
  	  {   
     	// $this->m_catalogueUploading->import_xls_record();
      	redirect('catalogue/v_kitExprUpload');
 	 }

 	 public function importFile()
  	  {   
     	$this->m_kitExprUpload->import_xls_record();
      	// redirect('catalogue/c_catalogueUploading');
 	 }
}

?>