<?php
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class M_Temp extends CI_Model {

  public function object_temp(){

    $query = $this->db2->query("SELECT * FROM LZ_BD_OBJECTS_MT T order by object_id desc/*WHERE T.CATEGORY_ID = 177*/");  
    $query = $query->result_array();

    $category = $this->db2->query("SELECT distinct D.CATEGORY_ID CATEGORY_ID, K.CATEGORY_NAME || '-' || D.CATEGORY_ID  CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY K WHERE D.CATEGORY_ID = K.CATEGORY_ID and d.lz_bd_group_id = 1")->result_array();

     return array('query' => $query ,'category' => $category);
  }

   public function get_objects(){
    $ob_category = $this->input->post('ob_category');
    return $this->db->query("SELECT T.OBJECT_ID ,T.OBJECT_NAME FROM LZ_BD_OBJECTS_MT T WHERE T.CATEGORY_ID = $ob_category")->result_array();
     }

    public function new_object_add(){
    $ob_category = $this->input->post('ob_category');
    $bd_objects = $this->input->post('object_name');
    $bd_objects = trim(str_replace("  ", ' ', $bd_objects));
    $bd_objects = strtoupper(trim(str_replace(array("'"), "''", $bd_objects)));
    $obj_desc = $this->input->post('obj_desc');
    $obj_desc = trim(str_replace("  ", ' ', $obj_desc));
    $obj_desc = strtoupper(trim(str_replace(array("'"), "''", $obj_desc)));
    $shipping_service = $this->input->post('shipping_service');
    $weight = $this->input->post('weight');
    $entered_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $created_date = date("Y-m-d H:i:s");
    $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $object_qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL")->result_array();
    $object_id = $object_qry[0]['OBJECT_ID'];

    $this->db2->query("INSERT INTO  LZ_BD_OBJECTS_MT (OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID, ITEM_DESC, SHIP_SERV, WEIGHT )VALUES($object_id, '$bd_objects', $created_date, $entered_by, $ob_category, '$obj_desc', '$shipping_service', '$weight') ");
    // var_dump($bd_objects);
    // exit;

    }
    
     public function new_object_edit_view(){
    $object_id = $this->uri->segment(4);
    $query = $this->db2->query("SELECT * FROM LZ_BD_OBJECTS_MT T  WHERE T.object_id = $object_id ");  
    $query = $query->result_array();

     return $query;

    }

     public function new_object_edit(){
    $object_name = $this->input->post('object_name');
    $object_id = $this->uri->segment(4);
    // var_dump($bd_objects);
    // exit;
    //$bd_objects = $this->input->post('bd_objects');
    $item_desc = $this->input->post('item_des');
    $item_desc = trim(str_replace("  ", ' ', $item_desc));
    $item_desc = strtoupper(trim(str_replace(array("'"), "''", $item_desc)));
    $shipping_service = $this->input->post('shipping_service');
    $weight = $this->input->post('weight');
    //$this->db2->query("UPDATE LZ_BD_OBJECTS_MT S SET  S.ITEM_DESC = '$item_desc', S.SHIP_SERV = '$shipping_service', S.WEIGHT = '$weight', S.OBJECT_NAME = '$object_name' WHERE S.OBJECT_ID = $object_id ");
    $this->db2->query("UPDATE LZ_BD_OBJECTS_MT S SET  S.ITEM_DESC = '$item_desc', S.SHIP_SERV = '$shipping_service', S.WEIGHT = '$weight' WHERE upper(S.OBJECT_NAME) = upper('$object_name')");
    // var_dump($bd_objects); 
    // exit;

    }
  
 function add() {
  $temp_name = $this->input->post('temp_name');
  $temp_name = trim(str_replace("  ", ' ', $temp_name));
  $site_id = $this->input->post('site_id');
  // $ship_country = $this->input->post('ship_country');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  // $cat_id = $this->input->post('cat_id');
  // $handling_time = $this->input->post('handling_time');
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
  $return_accepted = $this->input->post('return_accepted');
  $within_option = $this->input->post('within_option');
  $cost_paidby = $this->input->post('cost_paidby');
  $entered_by = $this->session->userdata('user_id');

  $data = array(
   'TEMPLATE_NAME' => $temp_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   // 'CATEGORY_ID' => $cat_id,
   // 'HANDLING_TIME' => $handling_time,
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
   'RETURN_OPTION' => $return_accepted,
   'RETURN_DAYS' => $within_option,
   'SHIPPING_PAID_BY' => $cost_paidby,
   'ENTERED_BY' => $entered_by

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
 $temp_name = trim(str_replace("  ", ' ', $temp_name));
 $site_id = $this->input->post('site_id');
  // $ship_country = $this->input->post('ship_country');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  // $cat_id = $this->input->post('cat_id');
  // $handling_time = $this->input->post('handling_time');
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
  $return_accepted = $this->input->post('return_accepted');
  $within_option = $this->input->post('within_option');
  $cost_paidby = $this->input->post('cost_paidby');
  $entered_by = $this->session->userdata('user_id');

  $data = array(
   'TEMPLATE_NAME' => $temp_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   // 'CATEGORY_ID' => $cat_id,
   // 'HANDLING_TIME' => $handling_time,
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
   'RETURN_OPTION' => $return_accepted,
   'RETURN_DAYS' => $within_option,
   'SHIPPING_PAID_BY' => $cost_paidby,
   'ENTERED_BY' => $entered_by
  );

  $this->db->where('TEMPLATE_ID', $id);
  $this->db->update('LZ_ITEM_TEMPLATE', $data);
  
 }

}
