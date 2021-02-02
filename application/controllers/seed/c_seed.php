<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_Seed extends CI_Controller {

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
  
  // $ID = $this->uri->segment(3);
 
  //  // $ID = $_GET['mit'];
  // $data['data_get'] = $this->m_seed_proces->view($ID);
  // //$this->load->view('header');
  // $this->load->view('seed/seed_edit', $data);
  //$this->load->view('footer');
 }
 function view($ID) {
  $item_id = $this->uri->segment(4);
  $manifest_id = $this->uri->segment(5);
  $data['data_get'] = $this->m_seed_proces->view($item_id,$manifest_id);
  $data['temp_data'] = $this->m_seed_proces->template_fields();
  $data['img_data'] = $this->m_image->displayimage($ID);
  $data['pageTitle'] = 'Seed Form';
  $this->load->view('seed/seed_edit',$data);
 }
 function add($ID) {
  //$this->load->view('header');
  // $this->load->view('vcrudnew');
  $data['data_get'] = $this->m_seed_proces->view($ID);
  $this->load->view('seed/seed_edit',$data);
  //$this->load->view('footer');
 }
 function edit() {

  $kd = $this->uri->segment(4);
  if ($kd == NULL) {
   redirect('seed/c_seed');
  }
  $dt = $this->m_seed_proces->edit($kd);
  $data['temp_name'] = $dt->TEMPLATE_NAME;
  $data['ship_country'] = $dt->EBAY_LOCAL;
  $data['currency'] = $dt->CURRENCY;
  $data['listing_type'] = $dt->LIST_TYPE;
  // $data['cat_id'] = $dt->CATEGORY_ID;
  // $data['handling_time'] = $dt->HANDLING_TIME;
  $data['zip_code'] = $dt->SHIP_FROM_ZIP_CODE;
  $data['ship_from_loc'] = $dt->SHIP_FROM_LOC;
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
  $this->load->view('seed/seed_edit', $data);
  //$this->load->view('footer');
 }
 function delete() {
  $u = $this->uri->segment(4);
  $this->m_seed_proces->delete($u);
  redirect('listing/listing');
 }
 function save() {
  if ($this->input->post('submit')) {
  $item_id = $this->input->post('pic_item_id');
  $manifest_id = $this->input->post('pic_manifest_id');
  $barcode=  $this->input->post('barcode');
  $str =explode("+",$barcode);
  $barcode = $str[1];

  $this->m_seed_proces->add($item_id,$manifest_id);
  $this->session->set_userdata('flag',true);
   redirect('listing/listing_search/seed_view/'.$barcode);
  } else{
   redirect('listing/listing');
  }
 }
 function update() {
  //$id = $this->uri->segment(4);
  if ($this->input->post('submit')) {
   $item_id = $this->input->post('pic_item_id');
  $manifest_id = $this->input->post('pic_manifest_id');
  $barcode=  $this->input->post('barcode');
  $str =explode("+",$barcode);
  //$lz_id = $str[0];
  $barcode = $str[1];
                //var_dump($barcode);exit;
   $this->m_seed_proces->update($item_id,$manifest_id);
   $this->session->set_userdata('flag',true);
   redirect('listing/listing_search/seed_view/'.$barcode);
  } else{
   redirect('seed/c_seed/view/'.$item_id.'/'.$manifest_id);
  }
 }

function get_template(){

   $template_name = $this->input->post('TempID');
   $this->db->from("LZ_ITEM_TEMPLATE");
   $this->db->where('TEMPLATE_ID', $template_name);

   $data['result'] = $this->db->get()->row();
   echo json_encode($data['result']);
   return json_encode($data['result']);
   

}

function get_conditions(){

   $cond_name = $this->input->post('CondID');

   $this->db->from("LZ_ITEM_COND_MT");
   $this->db->where('ID', $cond_name);
   $data['result'] = $this->db->get()->row();

   //$seed_id = $this->input->post('seed_id');
  // $barcode_qry = $this->db->query("SELECT M.*,S.DETAIL_COND FROM LZ_ITEM_COND_MT M , LZ_ITEM_SEED S WHERE M.ID = S.DEFAULT_COND AND S.SEED_ID = $seed_id"); 
  // $data['result'] = $barcode_qry->result_array();
   echo json_encode($data['result']);
   return json_encode($data['result']);

}




}
 
    
/* End of file welcome.php */
/* Location: ./application/controllers/ccrud.php */