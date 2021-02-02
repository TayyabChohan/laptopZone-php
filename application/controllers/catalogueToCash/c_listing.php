<?php

class c_listing extends CI_Controller{
	public function __construct(){
	      parent::__construct();
	      $this->load->database();
	      $this->load->model('catalogueToCash/m_listing');
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
	     // $this->load->model('manifest_loading/csv_model');
  	}

  	public function index(){
  		
      
  	}

    public function lister_view(){
      $result['pageTitle'] = 'De-Kited Item Listing';
      $result['data'] = $this->m_listing->listedTable();
      $result['lister'] = $this->lister_model->ListerUsers();
      $result['activeTab'] = 'Not Listed';
      $this->load->view('catalogueToCash/v_listing',$result);
    } 
    public function updateShip(){
      $data = $this->m_listing->updateShip();
      echo json_encode($data);
      return json_encode($data); 
    }


  	// public function list_get_data(){
  		
  		
  	// 	$data= $this->m_listing->list_get_data();
  	// 	echo json_encode($data);
   //    return json_encode($data);

  	// }


 }