<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_Seed extends CI_Model {
  
 function add() {
  // $erp_code = $this->input->post('erp_code');
  // $inven_desc = $this->input->post('inven_desc');
  // $upc = $this->input->post('upc');
  // $sku = $this->input->post('sku');
  // $manufacturer = $this->input->post('manufacturer');
  // $part_no = $this->input->post('part_no');
  $ITEM_ID = $this->input->post('id');
  $title = $this->input->post('title');
  $item_desc = $this->input->post('item_desc');
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category = $this->input->post('category');
  $handling_time = $this->input->post('handling_time');
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  //$shipping_source = $this->input->post('shipping_source');
  //$shipping_destination = $this->input->post('shipping_destination');
  $return_accepted = $this->input->post('return_accepted');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $quantity = $this->input->post('quantity');

  $data = array(
   'ITEM_ID' => $ITEM_ID,
   'ITEM_TITLE' => $title,
   'ITEM_DESC' => $item_desc,
   'EBAY_PRICE' => $price,
   'TEMPLATE_ID' => $template_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $category,
   'HANDLING_TIME' => $handling_time,
   'SHIP_FROM_ZIP_CODE' => $zip_code,
   'SHIP_FROM_LOC' => $ship_from,
   'BID_LENGTH' => $bid_length,
   'DEFAULT_COND' => $default_condition,
   'DETAIL_COND' => $default_description,
   'PAYMENT_METHOD' => $payment_method,
   'PAYPAL_EMAIL' => $paypal,
   'DISPATCH_TIME_MAX' => $dispatch_time,
   'SHIPPING_COST' => $shipping_cost,
   'ADDITIONAL_COST' => $additional_cost,
   'RETURN_OPTION' => $return_accepted,
   'RETURN_DAYS' => $return_within,
   'SHIPPING_PAID_BY' => $cost_paidby,
   'SHIPPING_SERVICE' => $shipping_service,
   'QUANTITY' => $quantity
  

  );
   $this->db->insert('LZ_ITEM_SEED', $data);
  // var_dump($query);exit;
 }
 function view($ID) {
  $L_Result =$this->db->select('LAPTOP_ITEM_CODE, ITEM_MT_DESC, UPC,SKU_NO,MANUFACTURER,MFG_PART_NO,ITEM_ID');
   $L_Result =$this->db->get_where(' VIEW_LZ_LISTING_REVISED', array('ITEM_ID' => $ID));

  $this->db->select('*');
  $this->db->from('LZ_ITEM_SEED');
  $this->db->where('LAPTOP_ITEM_CODE', $ID);
  $this->db->join('VIEW_LZ_LISTING_REVISED', 'VIEW_LZ_LISTING_REVISED.ITEM_ID = LZ_ITEM_SEED.ITEM_ID');
  $S_Result = $this->db->get();

if ($S_Result->num_rows() > 0) 
  {
     foreach ($S_Result->result() as $data) 
     {
      $hasil[] = $data;
     }
     // foreach ($L_Result->result() as $Listdata) 
     //    {
     //      $hasil[] = $Listdata;
     //    }
      //  $data=array_merge($seed,$hasil);
       return $hasil;
  }else{
        foreach ($L_Result->result() as $data) 
        {
          $hasil[] = $data;
        }
          return $hasil;
      }
 }
 function edit($a) {
  $d = $this->db->get_where('LZ_ITEM_SEED', array('ITEM_ID' => $a))->row();
  return $d;
 }
 function delete($a) {
  $this->db->delete('LZ_ITEM_SEED', array('ITEM_ID' => $a));
  return;
 }
 function update($id) {
  $ITEM_ID = $this->input->post('id');
  $title = $this->input->post('title');
  $item_desc = $this->input->post('item_desc');
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category = $this->input->post('category');
  $handling_time = $this->input->post('handling_time');
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  //$shipping_source = $this->input->post('shipping_source');
  //$shipping_destination = $this->input->post('shipping_destination');
  $return_accepted = $this->input->post('return_accepted');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $quantity = $this->input->post('quantity');  

  $data = array(
   'ITEM_ID' => $ITEM_ID,
   'ITEM_TITLE' => $title,
   'ITEM_DESC' => $item_desc,
   'EBAY_PRICE' => $price,
   'TEMPLATE_ID' => $template_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $category,
   'HANDLING_TIME' => $handling_time,
   'SHIP_FROM_ZIP_CODE' => $zip_code,
   'SHIP_FROM_LOC' => $ship_from,
   'BID_LENGTH' => $bid_length,
   'DEFAULT_COND' => $default_condition,
   'DETAIL_COND' => $default_description,
   'PAYMENT_METHOD' => $payment_method,
   'PAYPAL_EMAIL' => $paypal,
   'DISPATCH_TIME_MAX' => $dispatch_time,
   'SHIPPING_COST' => $shipping_cost,
   'ADDITIONAL_COST' => $additional_cost,
   'RETURN_OPTION' => $return_accepted,
   'RETURN_DAYS' => $return_within,
   'SHIPPING_PAID_BY' => $cost_paidby,
   'SHIPPING_SERVICE' => $shipping_service,
   'QUANTITY' => $quantity
  

  );
  $this->db->where('ITEM_ID', $id);
  $this->db->update('LZ_ITEM_SEED', $data);
 }
}
