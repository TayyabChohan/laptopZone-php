<?php 

	class C_UnpostItem extends CI_Controller{

		public function __construct(){
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

      $submit=$this->input->post('Submit');
      $perameter=  trim($this->input->post('search'));
      $perameter = trim(str_replace("  ", ' ', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      // $seed_radio = $this->input->post('seed');
      // $list_radio = $this->input->post('List');
      //echo $submit."-".$perameter."-".$radio;
      //die();
        if ($submit) 
        {
          if($perameter)
          {
            $this->load->model('UnpostItem/m_UnpostItem');
            $data['data'] = $this->m_UnpostItem->queryData($perameter);
            $data['pageTitle'] = 'Unpost Item';
            $this->load->view('UnpostItem/v_UnpostItem', $data);
          }else{$this->load->view('UnpostItem/v_UnpostItem');
          }
   
        }else{
                $this->load->view('UnpostItem/v_UnpostItem');
              }
    }else{
      redirect('login/login/');
    }           

  }
 //  SELECT B.ITEM_ID, B.LZ_MANIFEST_ID, B.CONDITION_ID, I.ITEM_DESC
 //  FROM LZ_BARCODE_MT B, ITEMS_MT I
 // WHERE B.ITEM_ID = I.ITEM_ID
 //   AND B.BARCODE_NO = PARM_BARCODE_NO;

  public function getBarcode()
    {
      $this->load->model('UnpostItem/m_UnpostItem');
      $data['data'] = $this->m_UnpostItem->getBarcode($perameter);
      $result['pageTitle'] = 'Delete Item';
      $this->load->view('UnpostItem/v_deleteBarcode', $result);      
    }
  public function unpostBarcode()
    {
      $submit=$this->input->post('Submit');
      $perameter=  trim($this->input->post('search'));
      $perameter = trim(str_replace("  ", ' ', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
        if ($submit) 
        {
          if($perameter)
          {
            $this->load->model('UnpostItem/m_UnpostItem');
            $data['barcode'] = $perameter;
            $data['data'] = $this->m_UnpostItem->getData($perameter);
            $data['pageTitle'] = 'Delete Item';
            $this->load->view('UnpostItem/v_deleteBarcode', $data);
          }else{
            $result['pageTitle'] = 'Delete Item';
            $this->load->view('UnpostItem/v_deleteBarcode', $result);
          }
        }else{
          $result['pageTitle'] = 'Delete Item';
          $this->load->view('UnpostItem/v_deleteBarcode', $result);
        }
    }
    public function UnpostItem()
    {
      $status = $this->session->userdata('login_status');
      $login_id = $this->session->userdata('user_id');
      if(@$login_id && @$status == TRUE)
      {
      $result['data'] = $this->m_UnpostItem->UnpostItem();
      $result['pageTitle'] = 'Unpost Item';
      $this->load->view('UnpostItem/v_UnpostItem', $result);      

      }else{
        redirect('login/login/');
      }          

    }
 
  
}


?>