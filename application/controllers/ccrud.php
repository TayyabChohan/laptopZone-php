<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Ccrud extends CI_Controller {
 
 public function index()
 {
  
  $data['data_get'] = $this->mcrud->view();
  //$this->load->view('header');
  $this->load->view('vcrud', $data);
  //$this->load->view('footer');
 }
 function add() {
  //$this->load->view('header');
  // $this->load->view('vcrudnew');
  $this->load->view('forms/Template');
  //$this->load->view('footer');
 }
 function edit() {
  $kd = $this->uri->segment(3);
  if ($kd == NULL) {
   redirect('ccrud');
  }
  $dt = $this->mcrud->edit($kd);
  $data['temp_name'] = $dt->TEMPLATE_NAME;
  $data['ship_country'] = $dt->EBAY_LOCAL;
  $data['currency'] = $dt->CURRENCY;
  $data['listing_type'] = $dt->LIST_TYPE;
  $data['cat_id'] = $dt->CATEGORY_ID;
  $data['handling_time'] = $dt->HANDLING_TIME;
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
  $this->load->view('vcrudedit', $data);
  //$this->load->view('footer');
 }
 function delete() {
  $u = $this->uri->segment(3);
  $this->mcrud->delete($u);
  redirect('ccrud');
 }
 function save() {
  if ($this->input->post('mit')) {
   $this->mcrud->add();
   redirect('ccrud');
  } else{
   redirect('ccrud/tambah');
  }
 }
 function update() {
  if ($this->input->post('mit')) {
   $id = $this->input->post('id');
   $this->mcrud->update($id);
   redirect('ccrud');
  } else{
   redirect('ccrud/edit/'.$id);
  }
 }
}
 
/* End of file welcome.php */
/* Location: ./application/controllers/ccrud.php */