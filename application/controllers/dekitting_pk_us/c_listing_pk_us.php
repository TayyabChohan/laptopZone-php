<?php

class c_listing_pk_us extends CI_Controller{
	public function __construct(){
	    parent::__construct();
	    $this->load->database();
	    //$this->load->model('catalogueToCash/m_reciving');
        $this->load->helper('security');
        $this->load->model("dekitting_pk_us/m_uspk_listing");
	    /*=============================================
        =  Section lz_bigData db connection block     =
        ==============================================*/
        /*=====  End of Section lz_bigData db connection block  ======*/	
	      if(!$this->loginmodel->is_logged_in())
	       {
	         redirect('login/login/');
	       }      
 	}

	public function index(){
		$result['pageTitle'] = 'Non Listed Items';
		
		$result['data'] = $this->m_uspk_listing->get_emp(); 
		$this->load->view('dekitting_pk_us/v_non_listing_pk_us',$result);
	}


	public function loadNonListData(){
		$data = $this->m_uspk_listing->nonListedTable(); 
		echo json_encode($data);
        return json_encode($data);
	}
	public function listedData(){
		$result['pageTitle'] = 'Listed Items';
		$this->load->view('dekitting_pk_us/v_listing_pk_us',$result);
	}
	public function loadListedData(){ 
		$data = $this->m_uspk_listing->listedTable();
		echo json_encode($data);
        return json_encode($data);
	}
	public function updateShip(){
      $data = $this->m_uspk_listing->updateShip();
      echo json_encode($data);
      return json_encode($data); 
    }

    public function del_dekit_item(){
      $data = $this->m_uspk_listing->del_dekit_item();
      echo json_encode($data);
      return json_encode($data); 
    }
    public function discardBarcode(){
      $data = $this->m_uspk_listing->discardBarcode();
      echo json_encode($data);
      return json_encode($data); 
    } 
    
}