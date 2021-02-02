\<?php

class c_cataloguePlusKitUpload extends CI_Controller{
	public function __construct(){
	      parent::__construct();
	      $this->load->database();
        $this->load->model('catalogue/m_cataloguePlusKitUpload');
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
      $this->load->view('catalogue/v_cataloguePlusKitUpload');
      
  	}

  	  public function uploadCSV_File()
  	  {   
     	// $this->m_catalogueUploading->import_xls_record();
      	redirect('catalogue/c_cataloguePlusKitUpload');
 	  }

 	 public function importExcelFile()
  	{   
     
        $this->m_cataloguePlusKitUpload->import_xls_record2();

 	 }
}