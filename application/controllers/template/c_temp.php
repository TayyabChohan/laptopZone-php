<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_Temp extends CI_Controller {
  public function __construct(){
  parent::__construct();
  $this->load->database();
    // $this->load->model("bigData/m_recog_title_mpn_kits");
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
} 
 public function index()
 {

  $status = $this->session->userdata('login_status');
  $login_id = $this->session->userdata('user_id');
  if(@$login_id && @$status == TRUE)
  {   

  $data['data_get'] = $this->m_temp->view();
  //$this->load->view('header');
  $data['pageTitle'] = 'Template Form';
  $this->load->view('template_forms/v_temp', $data);
  //$this->load->view('footer'); 
  }else{
      redirect('login/login/');
    }   
 }

 public function object_temp(){
  $result['data'] = $this->m_temp->object_temp();
  // var_dump($result['data']);
  // exit;
  $result['pageTitle'] = 'Object Template Form';
  $this->load->view('template_forms/v_temp_object', $result);

 }
 function object_add() {
  //$this->load->view('header');
  // $this->load->view('vcrudnew');
  $result['data'] = $this->m_temp->object_temp();
  $result['pageTitle'] = 'Object Template Form';
  $this->load->view('template_forms/object_temp_form', $result);
  //$this->load->view('footer');
 }
 function new_object_add() {
  if ($this->input->post('save')) {
   $this->m_temp->new_object_add();
   redirect('template/c_temp/object_temp');
  } else{
   redirect('template/c_temp/object_temp');
  }
 }

  function new_object_edit_view() {
 $result['data'] = $this->m_temp->new_object_edit_view();
 // var_dump($result['data']);
 // exit;
 $result['pageTitle'] = 'Object Template Form';
 $this->load->view('template_forms/v_temp_object_edit', $result);
  // if ($this->input->post('save')) {
  //  $this->m_temp->new_object_add();
  //  redirect('template/c_temp/object_temp');
  // } else{
  //  redirect('template/c_temp/object_temp');
  // }
 }
 function new_object_edit() {
  $this->m_temp->new_object_edit();
 
 redirect('template/c_temp/object_temp');
 
 }

public function get_objects()
{
        $data  = $this->m_temp->get_objects(); 
        echo json_encode($data);
        return json_encode($data);
} 



 function add() {
  //$this->load->view('header');
  // $this->load->view('vcrudnew');
  $data['pageTitle'] = 'Add Template Form';
  $this->load->view('template_forms/template', $data);
  //$this->load->view('footer');
 }
 function edit() {
  $kd = $this->uri->segment(4);
  if ($kd == NULL) {
   redirect('template/c_temp');
  }
  $dt = $this->m_temp->edit($kd);
  $data['temp_name'] = $dt->TEMPLATE_NAME;
  $data['site_id'] = $dt->EBAY_LOCAL;
  $data['currency'] = $dt->CURRENCY;
  $data['listing_type'] = $dt->LIST_TYPE;
  // $data['cat_id'] = $dt->CATEGORY_ID;
  // $data['handling_time'] = $dt->HANDLING_TIME;
  $data['zip_code'] = $dt->SHIP_FROM_ZIP_CODE;
  $data['ship_from'] = $dt->SHIP_FROM_LOC;
  $data['bid_length'] = $dt->BID_LENGTH;
  $data['default_condition'] = $dt->DEFAULT_COND;
  $data['default_description'] = $dt->DETAIL_COND;
  $data['payment_method'] = $dt->PAYMENT_METHOD;
  $data['paypal_email'] = $dt->PAYPAL_EMAIL;
  $data['dispatch_time'] = $dt->DISPATCH_TIME_MAX;
  $data['shipping_service'] = $dt->SHIPPING_SERVICE; 
  $data['service_cost'] = $dt->SHIPPING_COST; 
  $data['add_cost'] = $dt->ADDITIONAL_COST; 
  $data['accepted_option'] = $dt->RETURN_OPTION;
  $data['within_option'] = $dt->RETURN_DAYS;
  $data['cost_paidby'] = $dt->SHIPPING_PAID_BY;      
  $data['id'] = $kd;
  //$this->load->view('header');
  $data['pageTitle'] = 'Edit Template Form';
  $this->load->view('template_forms/v_temp_edit', $data);
  //$this->load->view('footer');
 }
 function delete() {
  $u = $this->uri->segment(4);
  $this->m_temp->delete($u);
  redirect('template/c_temp');
 }
 function save() {
  if ($this->input->post('mit')) {
   $this->m_temp->add();
   redirect('template/c_temp');
  } else{
   redirect('template/c_temp');
  }
 }
 function update() {
  if ($this->input->post('mit')) {
   $id = $this->input->post('id');
   $this->m_temp->update($id);
   redirect('template/c_temp');
  } else{
   redirect('template/c_temp/edit/'.$id);
  }
 }
}
 
/* End of file welcome.php */
/* Location: ./application/controllers/ccrud.php */