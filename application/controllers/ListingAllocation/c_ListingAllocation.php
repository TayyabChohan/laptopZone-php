<?php 

	class C_ListingAllocation extends CI_Controller{

		public function __construct(){
		parent::__construct();
		$this->load->database();
    if(!$this->loginmodel->is_logged_in())
      {
        redirect('login/login/');
      }    
	}

 		public function index(){
//$this->load->view('listing_views/search_view');

    $status = $this->session->userdata('login_status');
    $login_id = $this->session->userdata('user_id');
    if(@$login_id && @$status == TRUE)
    {      

    }else{
      redirect('login/login/');
    }          

  }

    public function tolist_view()
    {
      $status = $this->session->userdata('login_status');
      $login_id = $this->session->userdata('user_id');
      if(@$login_id && @$status == TRUE)
      {
      $this->load->model('tolist/m_tolist');
      $result['data'] = $this->m_tolist->default_view();
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view', $result);      

      }else{
        redirect('login/login/');
      }          

    }
    public function AssignListing(){
      
      $data['result'] = $this->m_ListingAllocation->AssignListing();
      echo json_encode($data['result']);
      return json_encode($data['result']);  

      
    } 

    public function AssignListing_pk(){
      
      $data['result'] = $this->m_ListingAllocation->AssignListing_pk();
      echo json_encode($data['result']);
      return json_encode($data['result']);  

      
    }
    public function unassignlisting_pk(){
      
      $data['result'] = $this->m_ListingAllocation->unassignlisting_pk();
      echo json_encode($data['result']);
      return json_encode($data['result']);  

      
    }

    public function asign_dkit_list(){
      
      $data['result'] = $this->m_ListingAllocation->asign_dkit_list();
      echo json_encode($data['result']);
      return json_encode($data['result']);  

      
    }
    public function UnAssigningListing(){
      
      $data['result'] = $this->m_ListingAllocation->UnAssigningListing();
      echo json_encode($data['result']);
      return json_encode($data['result']);  

      
    }    
    public function search_record()
    {
      $search_record = $this->input->post('search_record');
      $purchase_no = $this->input->post('purchase_no');
      $rslt = $this->input->post('date_range');
      $this->session->set_userdata('date_range', $rslt);

      $rs = explode('-',$rslt);
      $fromdate = $rs[0];
      $todate = $rs[1];
      /*===Convert Date in 24-Apr-2016===*/
      $fromdate = date_create($rs[0]);
      $todate = date_create($rs[1]);

      $from = date_format($fromdate,'d-m-y');
      $to = date_format($todate, 'd-m-y');
      
      $this->load->model('tolist/m_tolist');
      $result['data'] = $this->m_tolist->search_filter_view($search_record,$from,$to,$purchase_no);
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view', $result);      

    }
    public function lister_view(){
      $result['data'] = $this->m_ListingAllocation->item_listing();
      $result['users'] = $this->m_ListingAllocation->UsersList();
      $result['pageTitle'] = 'Listing Allocation View';
      $this->load->view('ListingAllocation/v_ListingAllocation', $result);        
        
  }
  public function CatFilter(){
    if($this->input->post('Submit')){

      $result['data'] = $this->m_ListingAllocation->CatFilter();
      $result['users'] = $this->m_ListingAllocation->UsersList();
      $result['pageTitle'] = 'Listing Allocation View';
      $this->load->view('ListingAllocation/v_ListingAllocation', $result); 
    }
  }    
  
}


?>