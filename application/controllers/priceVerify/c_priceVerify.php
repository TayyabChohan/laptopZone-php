<?php 

	class C_priceVerify extends CI_Controller{
		public function __construct()
    {
  		parent::__construct();
  		$this->load->database();
      $this->load->model('priceVerify/m_priceVerify');
      /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        /*=====  End of Section lz_bigData db connection block  ======*/  
      if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }    
	   }
 		public function index(){
      $status = $this->session->userdata('login_status');
      $login_id = $this->session->userdata('user_id');
      if(@$login_id && @$status == TRUE)
      {      
        
        //$result['data'] = $this->m_priceVerify->default_view();
        $result['pageTitle'] = 'Price Verification';
        $this->load->view('priceVerify/v_priceVerify', $result);
      }else{
        redirect('login/login/');
      }          

    }
    public function qty_detail(){
      $data = $this->m_priceVerify->qty_detail();
      echo json_encode($data);
      return json_encode($data);
    }
    public function remove_row(){
      $data = $this->m_priceVerify->remove_row();
      echo json_encode($data);
      return json_encode($data);
    }
    public function verify_price(){
      $data = $this->m_priceVerify->verify_price();
      echo json_encode($data);
      return json_encode($data);
    }
    public function loadData(){
      $data = $this->m_priceVerify->loadData();
      echo json_encode($data);
      return json_encode($data);
    }
    public function loadQtyData(){
      $data = $this->m_priceVerify->loadQtyData();
      echo json_encode($data);
      return json_encode($data);
    }  
    public function fav_supplier(){
      $data = $this->m_priceVerify->fav_supplier();
      echo json_encode($data);
      return json_encode($data);
    }
    public function lot_qty(){
      $data = $this->m_priceVerify->lot_qty();
      echo json_encode($data);
      return json_encode($data);
    }
    public function del_kw(){
      $data = $this->m_priceVerify->del_kw();
      echo json_encode($data);
      return json_encode($data);
    }
    public function updateUrl(){
        $data = $this->m_priceVerify->updateUrl();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function verirfyKeyword(){
        $data = $this->m_priceVerify->verirfyKeyword();
        echo json_encode($data);
        return json_encode($data); 
    }
}


?>