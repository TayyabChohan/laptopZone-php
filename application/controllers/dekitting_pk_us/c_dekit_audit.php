<?php 

  class C_dekit_audit extends CI_Controller{
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
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

    public function dekitAudit(){
        $result['location']     = '';
        $result['rslt']         = '';
        $result['pageTitle']    = 'Dekit Items Audit';
        $this->load->view('dekitting_pk_us/v_dekit_audit', $result);
    }
    public function loadListedItemsAudit(){
        $data = $this->m_dekit_audit->loadListedItems();
        echo json_encode($data);
        return json_encode($data);           
    }
    public function setBinIdtoSession(){
      $data  = $this->m_dekit_audit->setBinIdtoSession(); 
      echo json_encode($data);
      return json_encode($data);    
    } 
     public function transfer_location(){
        $result['pageTitle']    = 'Transfer Location';
        $result['bin_name']     = $this->uri->segment(4);
        //var_dump($result['bin_name']); exit;
        if($result['bin_name'] ==='No%20Bin-0'){
              $this->session->set_flashdata('error',"Please select correct bin name"); 
              redirect(base_url()."dekitting_pk_us/c_dekit_audit/dekitAudit");
            }else {
              $result['data']  = $this->m_dekit_audit->transfer_location();
              $this->load->view('locations/v_relocate_transfer_bin', $result);
            }       
          }   
}


?>