<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class Mcrud extends CI_Model {
  
 function add() {
  $temp_name = $this->input->post('temp_name');
  $ship_country = $this->input->post('ship_country');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $cat_id = $this->input->post('cat_id');
  $handling_time = $this->input->post('handling_time');
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  // $ship_to = $this->input->post('ship_to');
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $payment_method = $this->input->post('payment_method');
  $paypal_email = $this->input->post('paypal_email');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $service_cost = $this->input->post('service_cost');
  $add_cost = $this->input->post('add_cost');
  $accepted_option = $this->input->post('accepted_option');
  $within_option = $this->input->post('within_option');
  $cost_paidby = $this->input->post('cost_paidby');

  $data = array(
   'TEMPLATE_NAME' => $temp_name,
   'EBAY_LOCAL' => $ship_country,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $cat_id,
   'HANDLING_TIME' => $handling_time,
   'SHIP_FROM_ZIP_CODE' => $zip_code,
   'SHIP_FROM_LOC' => $ship_from,
   'BID_LENGTH' => $bid_length,
   'DEFAULT_COND' => $default_condition,
   'DETAIL_COND' => $default_description,
   'PAYMENT_METHOD' => $payment_method,
   'PAYPAL_EMAIL' => $paypal_email,
   'DISPATCH_TIME_MAX' => $dispatch_time,
   'SHIPPING_SERVICE' => $shipping_service,
   'SHIPPING_COST' => $service_cost,
   'ADDITIONAL_COST' => $add_cost,
   'RETURN_OPTION' => $accepted_option,
   'RETURN_DAYS' => $within_option,
   'SHIPPING_PAID_BY' => $cost_paidby

  );
   $this->db->insert('LZ_ITEM_TEMPLATE', $data);
  // var_dump($query);exit;
 }
 function view() {
  $ambil = $this->db->get('LZ_ITEM_TEMPLATE');
  if ($ambil->num_rows() > 0) {
   foreach ($ambil->result() as $data) {
    $hasil[] = $data;
   }
   return $hasil;
  }
 }
 function edit($a) {
  $d = $this->db->get_where('LZ_ITEM_TEMPLATE', array('TEMPLATE_ID' => $a))->row();
  return $d;
 }
 function delete($a) {
  $this->db->delete('LZ_ITEM_TEMPLATE', array('TEMPLATE_ID' => $a));
  return;
 }
 function update($id) {
 $temp_name = $this->input->post('temp_name');
  $ship_country = $this->input->post('ship_country');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $cat_id = $this->input->post('cat_id');
  $handling_time = $this->input->post('handling_time');
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  // $ship_to = $this->input->post('ship_to');
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $payment_method = $this->input->post('payment_method');
  $paypal_email = $this->input->post('paypal_email');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $service_cost = $this->input->post('service_cost');
  $add_cost = $this->input->post('add_cost');
  $accepted_option = $this->input->post('accepted_option');
  $within_option = $this->input->post('within_option');
  $cost_paidby = $this->input->post('cost_paidby');

  $data = array(
   'TEMPLATE_NAME' => $temp_name,
   'EBAY_LOCAL' => $ship_country,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $cat_id,
   'HANDLING_TIME' => $handling_time,
   'SHIP_FROM_ZIP_CODE' => $zip_code,
   'SHIP_FROM_LOC' => $ship_from,
   'BID_LENGTH' => $bid_length,
   'DEFAULT_COND' => $default_condition,
   'DETAIL_COND' => $default_description,
   'PAYMENT_METHOD' => $payment_method,
   'PAYPAL_EMAIL' => $paypal_email,
   'DISPATCH_TIME_MAX' => $dispatch_time,
   'SHIPPING_SERVICE' => $shipping_service,
   'SHIPPING_COST' => $service_cost,
   'ADDITIONAL_COST' => $add_cost,
   'RETURN_OPTION' => $accepted_option,
   'RETURN_DAYS' => $within_option,
   'SHIPPING_PAID_BY' => $cost_paidby

  );
  $this->db->where('TEMPLATE_ID', $id);
  $this->db->update('LZ_ITEM_TEMPLATE', $data);
 }
}
