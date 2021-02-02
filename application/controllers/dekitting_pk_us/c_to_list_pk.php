<?php 

  class c_to_list_pk extends CI_Controller{
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
      if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        } 
        $this->load->model('dekitting_pk_us/m_to_list_pk');   
     }
    public function index(){
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
      
      $result['data'] = $this->m_to_list_pk->default_view();
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view', $result);      

      }else{
        redirect('login/login/');
      }          

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
      
      $this->load->model('dekitting_us_pk/m_to_list_pk');
      $result['data'] = $this->m_to_list_pk->search_filter_view($search_record,$from,$to,$purchase_no);
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view', $result);      

    }
    public function lister_view(){
      if($this->input->post('Submit')){
        $result['data'] = $this->m_to_list_pk->item_listing();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Item Listing';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_lister_view', $result); 
      }elseif($this->input->post('search_lister')){
        $location = $this->input->post('location');
        $result['data'] = $this->m_to_list_pk->item_listing();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Item Listing';
        $result['activeTab'] = 'Listed';
        $result['location'] = $location;
        $this->load->view('tolist_view/v_lister_view', $result);        
      }else{
        $result['data'] = $this->m_to_list_pk->item_listing();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Item Listing';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_lister_view', $result);        
      }
    }
    public function pic_view(){
      if($this->input->post('Submit')){
        $result['data'] = $this->m_to_list_pk->pic_view();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Pic Approval';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_pic_view', $result); 
      }elseif($this->input->post('search_lister')){
        $location = $this->input->post('location');
        $result['data'] = $this->m_to_list_pk->pic_view();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Pic Approval';
        $result['activeTab'] = 'Listed';
        $result['location'] = $location;
        $this->load->view('tolist_view/v_pic_view', $result);        
      }else{
        $result['data'] = $this->m_to_list_pk->pic_view();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Pic Approval';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_pic_view', $result);        
      }
    }
    public function listedItemsAudit(){

    if($this->input->post('search_lister')){
        $location = $this->input->post('location');
        $result['data'] = $this->m_to_list_pk->listedItemsAudit();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Listed Items Audit';
        $result['location'] = $location;
        $this->load->view('tolist_view/v_listedItemsAudit', $result);        
      }else{
        $result['data'] = $this->m_to_list_pk->listedItemsAudit();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Listed Items Audit';
        $result['location'] = 'PK';
        $this->load->view('tolist_view/v_listedItemsAudit', $result);        
      }     

    }
    /*========================================
    =            copy from c_seed            =
    ========================================*/
    function seed_view() {
  // $item_id = $this->uri->segment(4);
  // $manifest_id = $this->uri->segment(5);
  // $condition_id = $this->uri->segment(6);
  $seed_id = $this->uri->segment(4);
  $barcode = $this->uri->segment(5);
  $query = $this->db->query("SELECT S.ITEM_ID,S.LZ_MANIFEST_ID,S.DEFAULT_COND,S.CATEGORY_ID FROM LZ_ITEM_SEED S WHERE S.SEED_ID = $seed_id");
  $result = $query->result_array();

  $item_id = $result[0]['ITEM_ID'];
  $manifest_id = $result[0]['LZ_MANIFEST_ID'];
  $condition_id = $result[0]['DEFAULT_COND'];
  $category_id = $result[0]['CATEGORY_ID'];
  $data['data_get'] = $this->m_to_list_pk->view($item_id,$manifest_id,$condition_id);
  $data['temp_data'] = $this->m_to_list_pk->template_fields();
  $data['spec_data'] = $this->m_tolist->get_specifics($category_id,$item_id);
  // $data['getRemarks']
  //$data['barcode'] = $this->m_to_list_pk->item_barcode($item_id,$manifest_id,$condition_id);
  //$data['img_data'] = $this->m_image->displayimage($ID);
  //$data['remarks'] = $this->m_to_list_pk->get_remarks($barcode);
  // $data['remarks'] = '';
  $data['pageTitle'] = 'Seed Form';
  $this->load->view('dekitting_pk_us/v_seed_edit_new_pk',$data);
 }
  // barcode wise seed view 
  function bar_seed_view() {
    
  // // $item_id = $this->uri->segment(4);
  // // $manifest_id = $this->uri->segment(5);
  // // $condition_id = $this->uri->segment(6);
  // $seed_id = $this->uri->segment(4);
  // $query = $this->db->query("SELECT S.ITEM_ID,S.LZ_MANIFEST_ID,S.DEFAULT_COND FROM LZ_ITEM_SEED S WHERE S.SEED_ID = $seed_id");
  // $result = $query->result_array();
  // $item_id = $result[0]['ITEM_ID'];
  // $manifest_id = $result[0]['LZ_MANIFEST_ID'];
  // $condition_id = $result[0]['DEFAULT_COND'];
  // //$category_id = $result[0]['CATEGORY_ID'];
  // $data['data_get'] = $this->m_to_list_pk->view($item_id,$manifest_id,$condition_id);
  // $data['temp_data'] = $this->m_to_list_pk->template_fields();
  // //$data['barcode'] = $this->m_to_list_pk->item_barcode($item_id,$manifest_id,$condition_id);
  // //$data['img_data'] = $this->m_image->displayimage($ID);
    $this->session->unset_userdata('seedbarcode'); 
  $data['pageTitle'] = 'Seed Form';
  $this->load->view('tolist_view/v_barseedview',$data);
 }

 function barcode_seed_view() {
   // $item_id = $this->uri->segment(4);
  // $manifest_id = $this->uri->segment(5);
  // $condition_id = $this->uri->segment(6);
  //$seed_id = $this->uri->segment(4);
  $barcode = $this->input->post('bar_search');
  $this->session->set_userdata('seedbarcode',$barcode);


  if (!empty($barcode)){
  $query = $this->db->query("SELECT B.BARCODE_NO ,B.ITEM_ID, B.LZ_MANIFEST_ID,B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO =$barcode");
  $result = $query->result_array();
  $item_id = $result[0]['ITEM_ID'];
  $manifest_id = $result[0]['LZ_MANIFEST_ID'];
  $condition_id = $result[0]['CONDITION_ID'];
}
  //$category_id = $result[0]['CATEGORY_ID'];
  $data['data_get'] = $this->m_to_list_pk->view($item_id,$manifest_id,$condition_id);
  $data['temp_data'] = $this->m_to_list_pk->template_fields();
  //$data['barcode'] = $this->m_to_list_pk->item_barcode($item_id,$manifest_id,$condition_id);
  //$data['img_data'] = $this->m_image->displayimage($ID);
  $data['pageTitle'] = 'Seed Form';
  $this->load->view('tolist_view/v_barseedview',$data);
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
  $barcode = $this->uri->segment(4);
  // var_dump($barcode);exit;
  if ($this->input->post('submit')) {
    //$seed_id = $this->input->post('seed_id');
    $ebay_id = $this->input->post('ebay_id');
    // $manifest_id = $this->input->post('pic_manifest_id');
    // $condition_id = $this->input->post('default_condition');
    // if(@$condition_id == 'Used'){
    //     @$condition_id = 3000;
    //   }elseif(@$condition_id == 'New'){
    //     @$condition_id = 1000; 
    //   }elseif(@$condition_id =='New other' ){
    //     @$condition_id = 1500; 
    //   }elseif(@$condition_id == 'Manufacturer refurbished'){
    //       @$condition_id = 2000;
    //   }elseif(@$condition_id == 'Seller refurbished'){
    //     @$condition_id = 2500; 
    //   }elseif(@$condition_id == 'For parts or not working'){
    //     @$condition_id = 7000; 
    //   }
   $seed_id = $this->m_to_list_pk->update();
   $this->session->set_userdata('flag',true);

   if (!empty($ebay_id)){
      redirect('dekitting_pk_us/c_to_list_pk/seed_view/'.$seed_id.'/'.$barcode.'/'.$ebay_id);
   } else{
      redirect('dekitting_pk_us/c_to_list_pk/seed_view/'.$seed_id.'/'.$barcode);
   }

   
   //redirect('listing/listing_search/seed_view/'.$barcode);
  } else{
   redirect('dekitting_pk_us/c_to_list_pk/lister_view');
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
   echo json_encode($data['result']);
   return json_encode($data['result']);

}

function approvalForListing(){
  $data['result'] = $this->m_to_list_pk->approvalForListing();
   echo json_encode($data['result']);
   return json_encode($data['result']);  
}

function list_item(){

  if($this->uri->segment(4))
  {

    //$seed_id = $this->input->post('seed_id');
    $seed_id = $this->uri->segment(4);
    
     //$list_barcode = $this->input->post('list_barcode');
     $list_barcode = $this->uri->segment(5);
     $check_btn = $this->uri->segment(6);
     $revise_ebay_id = @$this->uri->segment(7);
     // var_dump($list_barcode);exit;
    // var_dump($seed_id);
    // exit;
    $query = $this->db->query("SELECT S.ITEM_ID, S.LZ_MANIFEST_ID, S.DEFAULT_COND, S.CATEGORY_ID,I.ITEM_MT_UPC UPC,I.ITEM_MT_MFG_PART_NO MPN,I.ITEM_MT_MANUFACTURE FROM LZ_ITEM_SEED S, ITEMS_MT I WHERE S.SEED_ID = $seed_id AND I.ITEM_ID = S.ITEM_ID"); 
    $result['data'] = $query->result_array();
    $item_id = $result['data'][0]['ITEM_ID'];
    $manifest_id = $result['data'][0]['LZ_MANIFEST_ID'];
    $condition_id = $result['data'][0]['DEFAULT_COND'];
    $category_id = $result['data'][0]['CATEGORY_ID'];
    $upc = $result['data'][0]['UPC'];
    $mpn = $result['data'][0]['MPN'];
    $result['seed_id']=$seed_id;
    $result['check_btn']=$check_btn;
    $result['revise_ebay_id']=$revise_ebay_id;
    $result['list_barcode'] = $list_barcode;

    //var_dump($mpn);exit;
    //$this->load->view('ebay/finding/finditembykeyword',$result);
    $this->load->view('ebay/finding/finditemadvance_pk',$result);
    //$this->m_to_list_pk->is_active_listing($item_id,$condition_id,$upc,$mpn);
    //$this->m_to_list_pk->uplaod_listQty($item_id,$manifest_id,$list_qty);
    //3rd permetr condition
    $check = $this->session->userdata('check_item_id');

    if($check == true)
    {
      exit;
      // $ebay_id = $this->session->userdata('ebay_item_id');
      // $query = $this->db->query("SELECT E.ITEM_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id AND ROWNUM = 1"); 
      // $old_item = $query->result_array();
      // if($query->num_rows() > 0){
      //   if($old_item[0]['ITEM_ID'] != $item_id){
      //    $old_item_id = $old_item[0]['ITEM_ID'];
      //    $new_item_id = $item_id;
      //    $replace_itm = "call lz_repl_item($old_item_id,$new_item_id)";
      //    $replace_itm = $this->db->query($replace_itm);
      //   }
      // }
      // $data['seed_data'] = $this->m_to_list_pk->uplaod_seed($item_id,$manifest_id,$condition_id);
      // //$this->session->unset_userdata('active_listing');
      // $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      // if(!empty($this->session->userdata('ebay_item_id')))
      // {
      //   if($this->session->userdata('ebay_error'))
      //   {
      //     $ebay_error = $this->session->userdata('ebay_error');
      //     $this->session->unset_userdata('ebay_error');
      //     $this->session->unset_userdata('ebay_item_id');
      //     $this->session->unset_userdata('check_item_id');
      //     die($ebay_error);
      //   }
      //   $status = "REVISED";
      //   $this->m_to_list_pk->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
      //   $this->load->view('ebay/trading/getitem');
      //   $this->m_to_list_pk->insert_ebay_url();
      //   $this->session->unset_userdata('ebay_item_id');
      //   $this->session->unset_userdata('check_item_id');
      //   //break;
      // }else{
      //   $data['pic_data'] = $this->m_to_list_pk->uplaod_seed_pic($item_id,$manifest_id,$condition_id);
      //   $data['specific_data'] = $this->m_to_list_pk->item_specifics($item_id,$manifest_id,$condition_id);
      //   $this->session->unset_userdata('ebay_item_id');
      //   $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
      //   if($this->session->userdata('ebay_item_id'))
      //   {
      //     $status = "ADD";
      //     $this->m_to_list_pk->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
      //     $this->load->view('ebay/trading/getitem');
      //     $this->m_to_list_pk->insert_ebay_url();
      //     $this->session->unset_userdata('ebay_item_id');
      //     $this->session->unset_userdata('check_item_id');
      //   }
      // }
      
    }elseif($check_btn == "list"){
      // $data['list_barcode']= $this->input->post('list_barcode');
        $data['list_barcode'] = $list_barcode;
      // var_dump($data['list_barcode']);exit;
        $forceRevise = 0;
        $data['seed_data'] = $this->m_to_list_pk->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
        $data['pic_data'] = $this->m_to_list_pk->uplaod_seed_pic($item_id,$manifest_id,$condition_id);
        $data['specific_data'] = $this->m_to_list_pk->item_specifics($item_id,$manifest_id,$condition_id);
        
        // $data['barcode_no'] = $this->m_to_list_pk->item_barcode($item_id,$manifest_id,$condition_id);
       

        $this->session->unset_userdata('ebay_item_id');
        $this->load->view('ebay/trading/04-add-new-fixed-price-item',$data);
        if($this->session->userdata('ebay_item_id'))
        {
          $status = "ADD";
          $result['list_id'] = $this->m_to_list_pk->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise);
          //$this->load->view('ebay/trading/getitem');
          $this->m_to_list_pk->insert_ebay_url();
          $this->load->view('tolist_view/v_post_list',$result);
          $this->session->unset_userdata('ebay_item_id');
          $this->session->unset_userdata('check_item_id');
        }
    }else{// end if else
      die("Item not found on eBay.");
    }
  }else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }

}
    
    
    /*=====  End of copy from c_seed  ======*/
 function list_item_confirm(){
  $check_btn = $this->input->post('check_btn');
  if($this->input->post('revise_item'))
  {   
    $list_barcode = $this->input->post('list_barcode');
    $seed_id = $this->input->post('seed_id');
    $account_name = $this->input->post('account_name');
    $query = $this->db->query("SELECT S.ITEM_ID, S.LZ_MANIFEST_ID, S.DEFAULT_COND, S.CATEGORY_ID,I.ITEM_MT_UPC UPC,I.ITEM_MT_MFG_PART_NO MPN,I.ITEM_MT_MANUFACTURE FROM LZ_ITEM_SEED S, ITEMS_MT I WHERE S.SEED_ID = $seed_id AND I.ITEM_ID = S.ITEM_ID"); 
    $result['data'] = $query->result_array();
    $item_id = $result['data'][0]['ITEM_ID'];
    $manifest_id = $result['data'][0]['LZ_MANIFEST_ID'];
    $condition_id = $result['data'][0]['DEFAULT_COND'];
    $category_id = $result['data'][0]['CATEGORY_ID'];
    $upc = $result['data'][0]['UPC'];
    $mpn = $result['data'][0]['MPN'];
    //var_dump($mpn);exit;
    //$this->load->view('ebay/finding/finditembykeyword',$result);
    //$this->m_to_list_pk->is_active_listing($item_id,$condition_id,$upc,$mpn);
    //$this->m_to_list_pk->uplaod_listQty($item_id,$manifest_id,$list_qty);
    //3rd permetr condition
    $check = $this->session->userdata('check_item_id');

    // if($check == true)
    // {
      //$ebay_id = $this->session->userdata('ebay_item_id');
      $ebay_id = trim($this->input->post('selected_ebay_id'));
      $query = $this->db->query("SELECT E.ITEM_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id AND ROWNUM = 1"); 
      $old_item = $query->result_array();
      if($query->num_rows() > 0){
        if($old_item[0]['ITEM_ID'] != $item_id){
         $old_item_id = $old_item[0]['ITEM_ID'];
         $new_item_id = $item_id;
         $replace_itm = "call lz_repl_item($old_item_id,$new_item_id,$manifest_id,$condition_id)";
         $replace_itm = $this->db->query($replace_itm);
        }
      }
      $forceRevise = 0;
      $data['seed_data'] = $this->m_to_list_pk->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $data['specific_data'] = $this->m_to_list_pk->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['account_name'] = $account_name;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_to_list_pk->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise);
        $result['check_btn'] = $check_btn;
        //$this->load->view('ebay/trading/getitem');
        //$this->m_to_list_pk->insert_ebay_url();
        $this->load->view('tolist_view/v_post_list',$result);
        $this->session->unset_userdata('ebay_item_id');
        $this->session->unset_userdata('check_item_id');
        $this->session->unset_userdata('ebay_item_url');
        //break;
      }else{
        die('Unable to Revise an item');
      }
    // }else{
    //   die('Unable to Revise an item');
    // }

  }elseif($this->input->post('add_item')){
    $list_barcode = $this->input->post('list_barcode');
    $seed_id = $this->input->post('seed_id');
    $query = $this->db->query("SELECT S.ITEM_ID, S.LZ_MANIFEST_ID, S.DEFAULT_COND, S.CATEGORY_ID,I.ITEM_MT_UPC UPC,I.ITEM_MT_MFG_PART_NO MPN,I.ITEM_MT_MANUFACTURE FROM LZ_ITEM_SEED S, ITEMS_MT I WHERE S.SEED_ID = $seed_id AND I.ITEM_ID = S.ITEM_ID"); 
    $result['data'] = $query->result_array();
    $item_id = $result['data'][0]['ITEM_ID'];
    $manifest_id = $result['data'][0]['LZ_MANIFEST_ID'];
    $condition_id = $result['data'][0]['DEFAULT_COND'];
    $category_id = $result['data'][0]['CATEGORY_ID'];
    $upc = $result['data'][0]['UPC'];
    $mpn = $result['data'][0]['MPN'];
    $forceRevise = 0;
    $data['seed_data'] = $this->m_to_list_pk->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
    $data['pic_data'] = $this->m_to_list_pk->uplaod_seed_pic($item_id,$manifest_id,$condition_id);
    $data['specific_data'] = $this->m_to_list_pk->item_specifics($item_id,$manifest_id,$condition_id);
    $data['list_barcode'] = $list_barcode;
    // $data['barcode_no'] = $this->m_to_list_pk->item_barcode($item_id,$manifest_id,$condition_id);
    $this->session->unset_userdata('ebay_item_id');
    $this->session->unset_userdata('check_item_id');            
    $this->load->view('ebay/trading/04-add-new-fixed-price-item',$data);
    if($this->session->userdata('ebay_item_id'))
    {
      $status = "ADD";
      $result['list_id'] = $this->m_to_list_pk->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise);
      //$this->load->view('ebay/trading/getitem');
      $this->m_to_list_pk->insert_ebay_url();
      $this->load->view('tolist_view/v_post_list',$result);
      $this->session->unset_userdata('ebay_item_id');
      $this->session->unset_userdata('ebay_item_url');
    }
  }else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }
}   
function forceRevise(){
    $seed_id = @$this->uri->segment(4);
    $list_barcode = @$this->uri->segment(5);
    $check_btn = @$this->uri->segment(6);
    $revise_ebay_id = @$this->uri->segment(7);
    
    $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID,A.SELL_ACCT_DESC FROM EBAY_LIST_MT E , LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$revise_ebay_id' AND ROWNUM=1")->result_array();
    $account_name = @$get_seller[0]['SELL_ACCT_DESC'];
    //$account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
    //$account_name = $this->input->post('account_name');
    $query = $this->db->query("SELECT S.ITEM_ID, S.LZ_MANIFEST_ID, S.DEFAULT_COND, S.CATEGORY_ID,I.ITEM_MT_UPC UPC,I.ITEM_MT_MFG_PART_NO MPN,I.ITEM_MT_MANUFACTURE FROM LZ_ITEM_SEED S, ITEMS_MT I WHERE S.SEED_ID = $seed_id AND I.ITEM_ID = S.ITEM_ID"); 
    $result['data'] = $query->result_array();
    $item_id = $result['data'][0]['ITEM_ID'];
    $manifest_id = $result['data'][0]['LZ_MANIFEST_ID'];
    $condition_id = $result['data'][0]['DEFAULT_COND'];
    $category_id = $result['data'][0]['CATEGORY_ID'];
    $upc = $result['data'][0]['UPC'];
    $mpn = $result['data'][0]['MPN'];
    //var_dump($mpn);exit;
    //$this->load->view('ebay/finding/finditembykeyword',$result);
    //$this->m_tolist->is_active_listing($item_id,$condition_id,$upc,$mpn);
    //$this->m_tolist->uplaod_listQty($item_id,$manifest_id,$list_qty);
    //3rd permetr condition
    $check = $this->session->userdata('check_item_id');

    // if($check == true)
    // {
      //$ebay_id = $this->session->userdata('ebay_item_id');
      $ebay_id = $revise_ebay_id;
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
      $old_item = $query->result_array();
      if($query->num_rows() > 0){
        if($old_item[0]['ITEM_ID'] != $item_id){
         $old_item_id = $old_item[0]['ITEM_ID'];
         $new_item_id = $item_id;
         $replace_itm = "call lz_repl_item($old_item_id,$new_item_id,$manifest_id,$condition_id)";
         $replace_itm = $this->db->query($replace_itm);
        }
      }
      $forceRevise = 1;
      $data['seed_data'] = $this->m_to_list_pk->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $data['specific_data'] = $this->m_to_list_pk->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['account_name'] = $account_name;// used in configuration.php
      //$this->session->unset_userdata('active_listing');
      $data['forceRevise'] = $forceRevise;
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_to_list_pk->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise);
        $result['check_btn'] = $check_btn;
        //$this->load->view('ebay/trading/getitem');
        //$this->m_tolist->insert_ebay_url();
        $this->load->view('tolist_view/v_post_list',$result);
        $this->session->unset_userdata('ebay_error');
        $this->session->unset_userdata('ebay_item_id');
        $this->session->unset_userdata('check_item_id');
        //$this->session->unset_userdata('ebay_item_url');
        //break;
      }else{
        die('Unable to Revise an item');
      }
} 
  public function authPasswordCheck(){

    $data = $this->m_to_list_pk->authPasswordCheck();
    echo json_encode($data);
    return json_encode($data);    

  }

  
}


?>