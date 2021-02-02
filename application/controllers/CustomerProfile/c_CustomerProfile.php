<?php 

	class C_CustomerProfile extends CI_Controller{

		public function __construct(){
		parent::__construct();
		$this->load->database();
    $this->load->model('CustomerProfile/m_CustomerProfile');
    if(!$this->loginmodel->is_logged_in())
      {
        redirect('login/login/');
      }    
	}

 		public function index(){
    
      $this->load->model('CustomerProfile/m_CustomerProfile');
      $data['data'] = $this->m_CustomerProfile->customerInfo();
      $data['pageTitle'] = 'Customer Profile';
      $this->load->view('CustomerProfile/v_CustomerProfile', $data);                
  }

    public function CustomerProfile()
    {
      if($this->input->post('submit')){
        //var_dump('1');
        $parameter = trim($this->input->post('search'));
        $parameter = trim(str_replace("  ", ' ', $parameter));
        $parameter = trim(str_replace(array("'"), "''", $parameter));
        $this->session->set_userdata('search', $parameter);

        $data['data'] = $this->m_CustomerProfile->CustomerProfile($parameter);
        $data['pageTitle'] = 'Customer Profile';
        $this->load->view('CustomerProfile/v_CustomerProfile', $data);      
      } else{
        //var_dump('2');
        $parameter = $this->uri->segment(4);
        $parameter =trim(str_replace("%20",' ', $parameter));
        $this->session->set_userdata('search', $parameter);

        $data['data'] = $this->m_CustomerProfile->CustomerProfile($parameter);
         $data['pageTitle'] = 'Customer Profile';
         $this->load->view('CustomerProfile/v_CustomerProfile', $data);      
      }  

    }
   //by Danish 
    public function to_customerresult(){
    $data = $this->m_CustomerProfile->to_customerresult();
    echo json_encode($data);
    return json_encode($data);
  } // by Danish  
 
  
}


?>