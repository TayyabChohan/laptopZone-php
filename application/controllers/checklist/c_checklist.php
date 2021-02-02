<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class C_Checklist extends CI_Controller {

    public function __construct(){
    parent::__construct();
    $this->load->database();
    if(!$this->loginmodel->is_logged_in())
     {
       redirect('login/login/');
     }
  }  
 
 public function index()
 {
  $data['pageTitle'] = 'Item Checklist';
  $status = $this->session->userdata('login_status');
  $login_id = $this->session->userdata('user_id');
  if(@$login_id && @$status == TRUE)
  {   
    $data['data_get'] = $this->m_temp->view();
    //$this->load->view('header');
    $this->load->view('checklist_view/v_checklist', $data);
    //$this->load->view('footer'); 
  }else{
    redirect('login/login/');
    }   
 }
 
 function add() {
  $result['pageTitle'] = 'Add Test Check';
  //$this->load->view('header');
  // $this->load->view('vcrudnew');
  //$this->load->view('checklist_view/checklist');
  $result['data'] = $this->m_checklist->testing_check_screen();
  //$result['popup'] = $this->m_checklist->checklist_view();
  //var_dump($result['popup']);exit;
  $this->load->view('checklist_view/checklist',$result);  
  //$this->load->view('footer');
 }
 function screen2() {
  $result['pageTitle'] = 'Add Checklist';
  $result['data'] = $this->m_checklist->checklist_view();
  $this->load->view('checklist_view/v_checklist2',$result);

 }
 function screen3() {
  $result['pageTitle'] = 'Category & Check List Binding';
  $result['data'] = $this->m_checklist->bind_view();
  $this->load->view('checklist_view/v_checklist3',$result);

 }
 function cat_bind_save() {
  if($this->input->post('checklist_bind')){
    $this->m_checklist->cat_bind_save();
    redirect('checklist/c_checklist/screen3');
  }
 }    
 function test_save() {
  
  //if ($this->input->post('checklist_name')) {
  $data = $this->m_checklist->test_save();
  echo json_encode($data);
  return json_encode($data);
 }
  function save_checklist() {
  
  //if ($this->input->post('checklist_name')) {
  $data = $this->m_checklist->save_checklist();
  // echo json_encode($data);
  // return json_encode($data);  
  redirect('checklist/c_checklist/screen2');
 }
  function checklist_name_check() {
  
  $checklist_name = $this->input->post('checklist_name');
  $checklist_name = trim(str_replace("  ", ' ', $checklist_name));
  $checklist_name = trim(str_replace(array("'"), "''", $checklist_name));   
  $data = $this->m_checklist->save_checklist($checklist_name);
  // var_dump($data);exit;
  echo json_encode($data);
  return json_encode($data);  
 }
 
   function category_dd_check() {
  
  $category_dd = $this->input->post('category_dd');  
  $data = $this->m_checklist->cat_bind_save($category_dd);
  // var_dump($data);exit;
  echo json_encode($data);
  return json_encode($data);  
 }
 function test_detail() {
  //$test_id = $this->uri->segment(4);
  $data = $this->m_checklist->test_detail();
  echo json_encode($data);
  return json_encode($data);
 }
 function testing_check_delete(){
  $this->m_checklist->testing_check_delete();
  redirect('checklist/c_checklist/add');
 }
 function search_item_barcode(){
  $search_barcode = $this->uri->segment(4);
  if($search_barcode){ 
    $result['data'] = $this->m_checklist->bind_view();
    $result['search'] = $this->m_checklist->search_item_barcode($search_barcode);
    //var_dump($result['data']);exit; 
    $result['pageTitle'] = 'Search Category & Check List';
    $this->load->view('checklist_view/v_checklist3',$result);
  }else{
    $search_barcode = $this->input->post('search_barcode'); 
    $result['data'] = $this->m_checklist->bind_view();
    $result['search'] = $this->m_checklist->search_item_barcode($search_barcode);
    //var_dump($result['data']);exit; 
    $result['pageTitle'] = 'Search Category & Check List';
    $this->load->view('checklist_view/v_checklist3',$result);
  }

 }

    function search_manifest(){
      
      if($this->input->post('search_manifest')){
        $result['binded_data'] = $this->m_checklist->category_binding_results();
        //var_dump(@$result['tested_data']);exit;
        $this->load->view('checklist_view/v_checklist3', $result);
      }else{
        $this->load->view('checklist_view/v_checklist3');
      }
    }
    function view_checklist(){
      $result['pageTitle'] = 'View Item Checklist';
      $result['data'] = $this->m_checklist->view_checklist();
      $this->load->view('checklist_view/v_checklist_view',$result);
    }
    function edit_checklist(){
      $result['data'] = $this->m_checklist->edit_checklist();
      $this->load->view('checklist_view/v_checklist_edit',$result);
    }
    
    function update_checklist(){
      $result['data'] = $this->m_checklist->update_checklist();
      $this->load->view('checklist_view/v_checklist_edit',$result);
      //echo "<script>Error: Checklist Name already Exist.</script>";
    }
    

}
 
/* End of file welcome.php */
/* Location: ./application/controllers/ccrud.php */