<?php 

	class c_autolist extends CI_Controller{
		public function __construct()
    {
  		parent::__construct();
  		$this->load->database();
      $this->load->model('autoList/m_autolist');
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

      }else{
        redirect('login/login/');
      }          

    }
    public function autolistedAudit(){
        $result['location']     = '';
        $result['rslt']         = '';
        $result['pageTitle']    = ' Auto Listed Audit';
        $this->load->view('autoList/v_autolistedAudit', $result);
    }
    public function loadautoListedAudit(){
        $data = $this->m_autolist->loadautoListedItems();
        echo json_encode($data);
        return json_encode($data);           
    }
    public function getPriceDetail(){
      $data = $this->m_autolist->getPriceDetail();
      echo json_encode($data);
      return json_encode($data);           
    }
    
}
?>