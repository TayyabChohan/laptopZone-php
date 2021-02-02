<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_Seed_Proces extends CI_Model {
  
function add($item_id,$manifest_id) {

  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  //$title = trim(str_replace(array("'"), "''", $title));
  $item_desc = $this->input->post('item_desc');
  $item_desc = trim(str_replace("  ", ' ', $item_desc));
  //$item_desc = trim(str_replace(array("'"), "''", $item_desc));
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $template_name = trim(str_replace("  ", ' ', $template_name));
  //$template_name = trim(str_replace(array("'"), "''", $template_name));
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category_id = $this->input->post('category_id');
  $category_name = $this->input->post('category_name');
  $category_name = trim(str_replace("  ", ' ', $category_name));
  //$category_name = trim(str_replace(array("'"), "''", $category_name));
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $ship_from = trim(str_replace("  ", ' ', $ship_from));
  //$ship_from = trim(str_replace(array("'"), "''", $ship_from));
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $default_description = trim(str_replace("  ", ' ', $default_description));
  //$default_description = trim(str_replace(array("'"), "''", $default_description));
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  $return_accepted = $this->input->post('return_accepted');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $entered_by = $this->session->userdata('user_id');
  
  $data = array(
   'ITEM_ID' => $item_id,
   'ITEM_TITLE' => $title,
   'ITEM_DESC' => $item_desc,
   'EBAY_PRICE' => $price,
   'TEMPLATE_ID' => $template_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $category_id,
   'CATEGORY_NAME' => $category_name,
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
   'LZ_MANIFEST_ID' => $manifest_id,
   'ENTERED_BY' => $entered_by
   
  );
   $this->db->insert('LZ_ITEM_SEED', $data);
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);

  
 }
 function update($item_id,$manifest_id) {

  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  //$title = trim(str_replace(array("'"), "''", $title));
  //var_dump($title);exit
  $item_desc = $this->input->post('item_desc');
  $item_desc = trim(str_replace("  ", ' ', $item_desc));
  //$item_desc = trim(str_replace(array("'"), "''", $item_desc));
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $template_name = trim(str_replace("  ", ' ', $template_name));
  //$template_name = trim(str_replace(array("'"), "''", $template_name));  
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category_id = $this->input->post('category_id');
  $category_name = $this->input->post('category_name');
  $category_name = trim(str_replace("  ", ' ', $category_name));
  //$category_name = trim(str_replace(array("'"), "''", $category_name));  
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $ship_from = trim(str_replace("  ", ' ', $ship_from));
  //$ship_from = trim(str_replace(array("'"), "''", $ship_from));  
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $default_description = trim(str_replace("  ", ' ', $default_description));
  //$default_description = trim(str_replace(array("'"), "''", $default_description));  
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  $return_accepted = $this->input->post('return_accepted');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $entered_by = $this->session->userdata('user_id');
  
  $data = array(
   'ITEM_ID' => $item_id,
   'ITEM_TITLE' => $title,
   'ITEM_DESC' => $item_desc,
   'EBAY_PRICE' => $price,
   'TEMPLATE_ID' => $template_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $category_id,
   'CATEGORY_NAME' => $category_name,
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
   'LZ_MANIFEST_ID' => $manifest_id,
   'ENTERED_BY' => $entered_by
   
  );
  $where = array('ITEM_ID ' => $item_id , 'LZ_MANIFEST_ID ' => $manifest_id);
  $this->db->where($where);
  $this->db->update('LZ_ITEM_SEED', $data);
  
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);

 }
function view($ID,$manifest_id) 
 {
  
    $condition_qry = $this->db->query("select m.condition_id item_condition from lz_barcode_mt m where m.item_id=$ID and m.lz_manifest_id=$manifest_id"); 
    $condition_qry = $condition_qry->result();

    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $path_query =  $path_query->result_array();
   
    $this->db->select('*');
    $this->db->from('LZ_ITEM_SEED');
    $this->db->where('LZ_ITEM_SEED.ITEM_ID', $ID);
    $this->db->where('LZ_ITEM_SEED.LZ_MANIFEST_ID', $manifest_id);
    $this->db->join('VIEW_LZ_LISTING_REVISED', 'VIEW_LZ_LISTING_REVISED.ITEM_ID = LZ_ITEM_SEED.ITEM_ID and VIEW_LZ_LISTING_REVISED.LZ_MANIFEST_ID = LZ_ITEM_SEED.LZ_MANIFEST_ID');
    $this->db->order_by('LZ_ITEM_SEED.LZ_MANIFEST_ID', 'DESC');

    //$this->db->limit(1);
    $S_Result = $this->db->get();

 //  $query = $this->db->query("SELECT * FROM LZ_ITEM_SEED S, VIEW_LZ_LISTING_REVISED V WHERE S.ITEM_ID=V.ITEM_ID AND S.LZ_MANIFEST_ID = V.LZ_MANIFEST_ID AND S.ITEM_ID=$ID AND S.LZ_MANIFEST_ID = $manifest_id AND ROWNUM <2");
 // $S_Result= $query->result();

      if ($S_Result->num_rows() !== 0) 
      {
         $this->session->unset_userdata('seed_history');
       }
if ($S_Result->num_rows() == 0) 
      {
          $this->db->select('LZ_ITEM_SEED.*');
          $this->db->select('VIEW_LZ_LISTING_REVISED.ITEM_MT_DESC,VIEW_LZ_LISTING_REVISED.MANUFACTURER,VIEW_LZ_LISTING_REVISED.MFG_PART_NO,VIEW_LZ_LISTING_REVISED.SKU_NO,VIEW_LZ_LISTING_REVISED.UPC,VIEW_LZ_LISTING_REVISED.ITEM_CONDITION,VIEW_LZ_LISTING_REVISED.LAPTOP_ITEM_CODE,VIEW_LZ_LISTING_REVISED.IT_BARCODE');
          $this->db->from('LZ_ITEM_SEED');
          $this->db->join('VIEW_LZ_LISTING_REVISED', 'VIEW_LZ_LISTING_REVISED.ITEM_ID = LZ_ITEM_SEED.ITEM_ID and VIEW_LZ_LISTING_REVISED.LZ_MANIFEST_ID = LZ_ITEM_SEED.LZ_MANIFEST_ID ', FALSE);
          $this->db->where('LZ_ITEM_SEED.ITEM_ID', $ID);
          $this->db->order_by('LZ_ITEM_SEED.LZ_MANIFEST_ID', 'DESC');
          $this->db->limit(1);
          $S_Result = $this->db->get();
          $this->session->set_userdata('seed_history',True);
          $this->session->set_userdata('manifest_id',$manifest_id);
      }
    $L_Result =$this->db->select('LAPTOP_ITEM_CODE, ITEM_MT_DESC, UPC,SKU_NO,MANUFACTURER,MFG_PART_NO,ITEM_ID,LZ_MANIFEST_ID,ITEM_CONDITION');
   $L_Result =$this->db->get_where('VIEW_LZ_LISTING_REVISED', array('ITEM_ID' => $ID,'LZ_MANIFEST_ID' => $manifest_id));


      if ($S_Result->num_rows() > 0) 
      {
         foreach ($S_Result->result() as $data) 
         {
          $result[] = $data;

         }
       //var_dump($result);exit;
           //return $result;
           return array('result'=>$result, 'path_query'=>$path_query);

       }else{
            foreach ($L_Result->result() as $data) 
            {
              $result[] = $data;
            }
              return array('result'=>$result, 'path_query'=>$path_query, 'condition_qry'=>$condition_qry);
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

 function template_fields()
 {

// for this query in VIEW use this $row['VALUE']; instead of $row->VALUE;
  $query = $this->db->query("SELECT TEMPLATE_ID,TEMPLATE_NAME FROM LZ_ITEM_TEMPLATE ORDER BY TEMPLATE_ID");
      return $query->result_array();
//    $query = $this->db->select('TEMPLATE_ID,TEMPLATE_NAME');
//    $query = $this->db->from('LZ_ITEM_TEMPLATE');

// return $query->result_array();
    // $temp_result = $this->db->get();
    // return $temp_result;
    
 }

}
