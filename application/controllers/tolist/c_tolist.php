<?php 

  class c_tolist extends CI_Controller{
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
      $this->load->model('tolist/m_tolist');
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
      //$this->load->model('tolist/m_tolist');
      $result['data'] = $this->m_tolist->default_view();
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view',$result);      

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
      
      $this->load->model('tolist/m_tolist');
      $result['data'] = $this->m_tolist->search_filter_view($search_record,$from,$to,$purchase_no);
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view', $result);      

    }
     public function lister_view(){
        $result['pageTitle']    = 'Item Listing';
        $result['location']     = 'ALL';
        $this->load->view('tolist_view/v_lister_view', $result);       
    }
    public function load_lister_view(){
        $data         = $this->m_tolist->item_listing();
        echo json_encode($data);
        return json_encode($data);     
    }
    public function pic_view(){
      if($this->input->post('Submit')){
        $result['data'] = $this->m_tolist->pic_view();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Pic Approval';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_pic_view', $result); 
      }elseif($this->input->post('search_lister')){
        $location = $this->input->post('location');
        $result['data'] = $this->m_tolist->pic_view();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Pic Approval';
        $result['activeTab'] = 'Listed';
        $result['location'] = $location;
        $this->load->view('tolist_view/v_pic_view', $result);        
      }else{
        $result['data'] = $this->m_tolist->pic_view();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Pic Approval';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_pic_view', $result);        
      }
    }
    public function listedItemsAudit(){
        $result['location']     = '';
        $result['rslt']         = '';
        $result['pageTitle']    = 'Listed Items Audit';
        /*$result['location']   = $this->input->post('location');
        $result['rslt']         = $this->input->post('date_range');
        */
        
        $this->load->view('tolist_view/v_listedItemsAudit', $result);
    }
    public function loadListedItemsAudit(){
        $data = $this->m_tolist->loadListedItems();
        echo json_encode($data);
        return json_encode($data);           
    }
    /*========================================
    =            copy from c_seed            =
    ========================================*/
    function seed_view() {
  // $item_id = $this->uri->segment(4);
  // $manifest_id = $this->uri->segment(5);
  // $condition_id = $this->uri->segment(6);
  $seed_id = $this->uri->segment(4);
  $query = $this->db->query("SELECT S.ITEM_ID,S.LZ_MANIFEST_ID,S.DEFAULT_COND,S.CATEGORY_ID FROM LZ_ITEM_SEED S WHERE S.SEED_ID = $seed_id");
  $result = $query->result_array();
  $item_id = $result[0]['ITEM_ID'];
  $manifest_id = $result[0]['LZ_MANIFEST_ID'];
  $condition_id = $result[0]['DEFAULT_COND'];
  $category_id = $result[0]['CATEGORY_ID'];
  $data['data_get'] = $this->m_tolist->view($item_id,$manifest_id,$condition_id);
  $data['temp_data'] = $this->m_tolist->template_fields();
  $data['spec_data'] = $this->m_tolist->get_specifics($category_id,$item_id);
  //$data['barcode'] = $this->m_tolist->item_barcode($item_id,$manifest_id,$condition_id);
  //$data['img_data'] = $this->m_image->displayimage($ID);
  $data['pageTitle'] = 'Seed Form';
  $this->load->view('tolist_view/seed_edit_new',$data);
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
  // $data['data_get'] = $this->m_tolist->view($item_id,$manifest_id,$condition_id);
  // $data['temp_data'] = $this->m_tolist->template_fields();
  // //$data['barcode'] = $this->m_tolist->item_barcode($item_id,$manifest_id,$condition_id);
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
  $data['data_get'] = $this->m_tolist->view($item_id,$manifest_id,$condition_id);
  $data['temp_data'] = $this->m_tolist->template_fields();
  //$data['barcode'] = $this->m_tolist->item_barcode($item_id,$manifest_id,$condition_id);
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
  //$id = $this->uri->segment(4);
  if ($this->input->post('submit')) {
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
   $seed_id = $this->m_tolist->update();
   $this->session->set_userdata('flag',true);

   if (!empty($ebay_id)){
     redirect('tolist/c_tolist/seed_view/'.$seed_id.'/'.$ebay_id);
   } else{
     redirect('tolist/c_tolist/seed_view/'.$seed_id);
   }
  
   //redirect('listing/listing_search/seed_view/'.$barcode);
  } else{
   redirect('tolist/c_tolist/lister_view');
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


function approvalForListing(){
  $data['result'] = $this->m_tolist->approvalForListing();
   echo json_encode($data['result']);
   return json_encode($data['result']);  
}

function list_item(){

  $shopifyCheckbox = @$this->uri->segment(6); // shopify checkbox value
  $this->session->set_userdata('shopifyCheckbox', $shopifyCheckbox); // this session is for shopify checkbox value
  if($this->uri->segment(4))
  {

    //$seed_id = $this->input->post('seed_id');
    $seed_id = @$this->uri->segment(4);
    $check_btn = @$this->uri->segment(5);
    $revise_ebay_id = @$this->uri->segment(6);
     //var_dump($seed_id);
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
    //var_dump($mpn);exit;
    //$this->load->view('ebay/finding/finditembykeyword',$result);
    $this->load->view('ebay/finding/finditemadvance',$result);
    //$this->m_tolist->is_active_listing($item_id,$condition_id,$upc,$mpn);
    //$this->m_tolist->uplaod_listQty($item_id,$manifest_id,$list_qty);
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
      // $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id);
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
      //   $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
      //   $this->load->view('ebay/trading/getitem');
      //   $this->m_tolist->insert_ebay_url();
      //   $this->session->unset_userdata('ebay_item_id');
      //   $this->session->unset_userdata('check_item_id');
      //   //break;
      // }else{
      //   $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id);
      //   $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
      //   $this->session->unset_userdata('ebay_item_id');
      //   $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
      //   if($this->session->userdata('ebay_item_id'))
      //   {
      //     $status = "ADD";
      //     $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
      //     $this->load->view('ebay/trading/getitem');
      //     $this->m_tolist->insert_ebay_url();
      //     $this->session->unset_userdata('ebay_item_id');
      //     $this->session->unset_userdata('check_item_id');
      //   }
      // }
      
    }elseif($check_btn == "list"){
        $forceRevise = 0;
        $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
        $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
        $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
        
        $this->session->unset_userdata('ebay_item_id');
        $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
        if($this->session->userdata('ebay_item_id'))
        {
          $status = "ADD";
          $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise);
          //$this->load->view('ebay/trading/getitem');
          $this->m_tolist->insert_ebay_url();
          $this->load->view('tolist_view/v_post_list',$result);
          $this->session->unset_userdata('ebay_item_id');
          $this->session->unset_userdata('check_item_id');
        }
    }else{
      die("Item not found on eBay.");
    }// end if else
  }else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }
}

function forceRevise(){
    $seed_id = @$this->uri->segment(4);
    $check_btn = @$this->uri->segment(5);
    $addQtyOnly = @$this->uri->segment(7);
    //$revise_ebay_id = @$this->uri->segment(8);
    $last = $this->uri->total_segments();
    $revise_ebay_id = $this->uri->segment($last);//ebay_id

    $bestOfferCheckbox = @$this->uri->segment(6);

    $get_seller_acct = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$revise_ebay_id' AND UPPER(E.STATUS) = 'ADD' AND ROWNUM=1 ")->result_array();

    //$get_seller_acct = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$revise_ebay_id' AND UPPER(E.STATUS) = 'ADD' AND ROWNUM=1 ")->result_array();
    if(count($get_seller_acct) > 0){
      $account_name = @$get_seller_acct[0]['LZ_SELLER_ACCT_ID'];
    }else{
      $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$revise_ebay_id'  AND ROWNUM=1 ")->result_array(); 
      $account_name = @$get_seller[0]['LZ_SELLER_ACCT_ID'];      
    }

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
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID,E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
      $old_item = $query->result_array();
      if($query->num_rows() > 0){
        if($old_item[0]['ITEM_ID'] != $item_id){
         $old_item_id = $old_item[0]['ITEM_ID'];
         $new_item_id = $item_id;
         $replace_itm = "call lz_repl_item($old_item_id,$new_item_id,$manifest_id,$condition_id)";
         $replace_itm = $this->db->query($replace_itm);
        }
        $account_id = @$old_item[0]['LZ_SELLER_ACCT_ID'];
      }else{
        die("ebay id not found in system");
      }
      $forceRevise = 1;
      $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['bestOfferCheckbox'] = $bestOfferCheckbox;
      $data['account_name'] = $account_name;// used in configuration.php
      $data['forceRevise'] = $forceRevise;// used in Revisefixedpriceitem.php to add qty in revise call
      $data['addQtyOnly'] = $addQtyOnly;
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
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

 function list_item_confirm(){
  $check_btn = $this->input->post('check_btn');
  if($this->input->post('revise_item'))
  {
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
    //$this->m_tolist->is_active_listing($item_id,$condition_id,$upc,$mpn);
    //$this->m_tolist->uplaod_listQty($item_id,$manifest_id,$list_qty);
    //3rd permetr condition
    $check = $this->session->userdata('check_item_id');

    // if($check == true)
    // {
      //$ebay_id = $this->session->userdata('ebay_item_id');
      $ebay_id = trim($this->input->post('selected_ebay_id'));
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID,E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
      $old_item = $query->result_array();
      if($query->num_rows() > 0){
        if($old_item[0]['ITEM_ID'] != $item_id){
         $old_item_id = $old_item[0]['ITEM_ID'];
         $new_item_id = $item_id;
         $replace_itm = "call lz_repl_item($old_item_id,$new_item_id,$manifest_id,$condition_id)";
         $replace_itm = $this->db->query($replace_itm);
        }
        $account_id = $old_item[0]['LZ_SELLER_ACCT_ID'];
      }
            
      $forceRevise = 0;
      $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['account_name'] = $account_name;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
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
   
    // }else{
    //   die('Unable to Revise an item');
    // }

  }elseif($this->input->post('add_item')){
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
    $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
    $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
    $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
    
    $this->session->unset_userdata('ebay_item_id');
    $this->session->unset_userdata('check_item_id');            
    $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
    if($this->session->userdata('ebay_item_id'))
    {
      $status = "ADD";
      $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise);
      //$this->load->view('ebay/trading/getitem');
      $this->m_tolist->insert_ebay_url();
      $this->load->view('tolist_view/v_post_list',$result);
      $this->session->unset_userdata('ebay_item_id');
      $this->session->unset_userdata('ebay_item_url');
    }
  }else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }
}   

 public function price_analysis_sold() {
    $data  = $this->m_tolist->price_analysis_sold(); 
    echo json_encode($data);
    return json_encode($data);
    
 }  
  public function price_analysis_active() {
      $data  = $this->m_tolist->price_analysis_active(); 
      echo json_encode($data);
      return json_encode($data);
  }  
  public function setBinIdtoSession(){
    $data  = $this->m_tolist->setBinIdtoSession(); 
    echo json_encode($data);
    return json_encode($data);    
  } 
  public function transfer_location(){
        $result['pageTitle']    = 'Transfer Location';
        $result['bin_name']     = $this->uri->segment(4);
        //var_dump($result['bin_name']); exit;
        if($result['bin_name'] ==='No%20Bin-0'){
              $this->session->set_flashdata('error',"Please select correct bin name"); 
              redirect(base_url()."tolist/c_tolist/listedItemsAudit");
            }else {
              $result['data']  = $this->m_dekit_audit->transfer_location();
              $this->load->view('locations/v_relocate_transfer_bin', $result);
            }       
          }
 // BY Danish 
  public function loadtolistresult(){


  $data = $this->m_tolist->loadtolistresult();
    echo json_encode($data);
    return json_encode($data);
  } // by Danish 

  public function update_seed_price(){


  $data = $this->m_tolist->update_seed_price();
    echo json_encode($data);
    return json_encode($data);
  }
  public function authPasswordCheck(){

    $data = $this->m_tolist->authPasswordCheck();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function showAllBarcode(){

    $data = $this->m_tolist->showAllBarcode();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function showHoldedBarcode(){

    $data = $this->m_tolist->showHoldedBarcode();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function holdSelectedBarcode(){

    $data = $this->m_tolist->holdSelectedBarcode();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function getMacro(){

    $data = $this->m_tolist->getMacro();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function bindItemMacro(){
    $data = $this->m_tolist->bindItemMacro();
    echo json_encode($data);
    return json_encode($data);    
  }
  public function get_conditions(){

   $cond_name = $this->input->post('CondID');

   $this->db->from("LZ_ITEM_COND_MT");
   $this->db->where('ID', $cond_name);
   $data = $this->db->get()->row();

   //$seed_id = $this->input->post('seed_id');
  // $barcode_qry = $this->db->query("SELECT M.*,S.DETAIL_COND FROM LZ_ITEM_COND_MT M , LZ_ITEM_SEED S WHERE M.ID = S.DEFAULT_COND AND S.SEED_ID = $seed_id"); 
  // $data['result'] = $barcode_qry->result_array();
   echo json_encode($data);
   return json_encode($data);

  }
  public function endItem(){
    $ebay_id = $this->input->post('ebay_id');
    $remarks = $this->input->post('remarks');
    $result['ebay_id'] = $ebay_id;
    $result['remarks'] = $remarks;
    //$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID,A.SELL_ACCT_DESC FROM EBAY_LIST_MT E , LZ_SELLER_ACCTS A WHERE A.LZ_SELLER_ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array();

    //$get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM = 1")->result_array(); 
    $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID, A.ACCOUNT_NAME SELL_ACCT_DESC , S.EBAY_LOCAL FROM EBAY_LIST_MT E, LJ_MERHCANT_ACC_DT A , LZ_ITEM_SEED S WHERE A.ACCT_ID = E.LZ_SELLER_ACCT_ID AND S.SEED_ID = E.SEED_ID AND E.EBAY_ITEM_ID =  '$ebay_id' AND ROWNUM = 1")->result_array(); 
    $account_name = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
    
    if(!empty(@$get_seller[0]['EBAY_LOCAL'])){
      $site_id = @$get_seller[0]['EBAY_LOCAL'];
    }else{
      $site_id = 0;
    }
    $result['site_id'] = $site_id;
    if(!empty(@$account_name)){
      $result['account_name'] = $account_name;
    }
    

    $data = $this->load->view('ebay/trading/endItem',$result);
    if($data){
      $data = $this->m_tolist->endItem();
      $result['response'] = $this->m_ordersShopify->deleteItemfromShopify($ebay_id);
      //End item from Shopify
      
    }
    echo json_encode($data);
    return json_encode($data);    
  }
  public function suggestEpid(){
    $user_id = 2;//faisal developer account id
    $keyword = @$this->input->post('keyword_epid');
    $category_id = @$this->input->post('category_id');
    $result['user_id'] = $user_id;
    $this->load->view('ebay\oauth-tokens\01-get-app-token-oraserver',$result);
    $result['keyword'] = $keyword;
    $result['category_id'] = $category_id;
    //$result['res']=$this->m_cron_job->GetActiveItemEpid($user_id);
    $this->load->view('ebay/browse/suggestEpid',$result);
    $data = $this->session->userdata('epid_data');
    //var_dump($data);exit;
    echo json_encode($data);
    return json_encode($data);
    //exit;
  }
  public function copySeed(){
    $data = $this->m_tolist->copySeed();
    echo json_encode($data);
    return json_encode($data);    
  }
  public function seed_view_merg() {
  // $item_id = $this->uri->segment(4);
  // $manifest_id = $this->uri->segment(5);
  // $condition_id = $this->uri->segment(6);
  $seed_id = $this->uri->segment(4);
  $query = $this->db->query("SELECT S.ITEM_ID,S.LZ_MANIFEST_ID,S.DEFAULT_COND,S.CATEGORY_ID FROM LZ_ITEM_SEED S WHERE S.SEED_ID = $seed_id");
  $result = $query->result_array();

  $item_id = $result[0]['ITEM_ID'];
  $manifest_id = $result[0]['LZ_MANIFEST_ID'];
  $condition_id = $result[0]['DEFAULT_COND'];
  $category_id = $result[0]['CATEGORY_ID'];

  $bar = $this->db->query("SELECT BB.BARCODE_NO FROM LZ_BARCODE_MT BB WHERE BB.LZ_MANIFEST_ID =$manifest_id   and bb.item_id =  $item_id  and bb.condition_id =$condition_id and rownum<=1")->result_array();



   
  $data['data_get'] = $this->m_tolist->view($item_id,$manifest_id,$condition_id);
  $data['temp_data'] = $this->m_tolist->template_fields();
  $data['spec_data'] = $this->m_tolist->get_specifics($category_id,$item_id);
  $data['site_ids'] = $this->m_tolist->getEbaySite();
  $data['end_rem'] = $this->m_tolist->getEndremrks($item_id,$manifest_id,$condition_id);

  
  //$data['barcode'] = $this->m_tolist->item_barcode($item_id,$manifest_id,$condition_id);
  //$data['img_data'] = $this->m_image->displayimage($ID);
  $data['pageTitle'] = 'Seed Form';
  $this->load->view('tolist_view/v_item_seed',$data);
 }
 function update_merg() {
  if ($this->input->post('submit')) {
     $ebay_id = $this->input->post('ebay_id');
     $barcode = $this->input->post('list_barcode');
     $seed_id = $this->m_tolist->update();
     $this->session->set_userdata('flag',true);
     if (!empty($ebay_id) AND !empty($barcode)){
       redirect('tolist/c_tolist/seed_view_merg/'.$seed_id.'/'.$barcode.'/'.$ebay_id);
     }elseif(!empty($ebay_id) AND empty($barcode)){
       redirect('tolist/c_tolist/seed_view_merg/'.$seed_id.'/'.$ebay_id);
     }elseif(empty($ebay_id) AND !empty($barcode)){
      redirect('tolist/c_tolist/seed_view_merg/'.$seed_id.'/'.$barcode);
     }else{
      redirect('tolist/c_tolist/seed_view_merg/'.$seed_id);
     }
  }else{
    redirect('tolist/c_tolist/lister_view');
  }
 }


   function list_item_merg(){

    $shopifyCheckbox = @$this->uri->segment(7); // shopify checkbox value
    $bestOfferCheckbox = @$this->uri->segment(8); // bestOfferCheckbox checkbox value
    //$this->session->set_userdata('shopifyCheckbox', $shopifyCheckbox); // this session is for shopify checkbox value
    if($this->uri->segment(4))
    {

      //$list_barcode = $this->session->userdata("list_barcode");//set in v_item_seed will use in add item call to get picture folder
      $seed_id = @$this->uri->segment(4);
      $check_btn = @$this->uri->segment(5);
      $list_barcode = @$this->uri->segment(6);
      $last = $this->uri->total_segments();
      $revise_ebay_id = $this->uri->segment($last);//ebay_id
      $account_type = @$this->uri->segment(9);
      $addQtyOnly = @$this->uri->segment(10);

      if(!is_numeric($list_barcode)){
        $list_barcode = '';
        //$account_id = $this->session->userdata('account_type');
        $account_id = $account_type;
      }else{
        /*======================================================
        =            get account_id against barcode            =
        ======================================================*/
        //$account_id = $this->session->userdata('account_type');
        $account_id = $account_type;
              

            if(!empty($list_barcode)){
                 $query = $this->db->query("SELECT AC.TOKEN, P.PAYPAL_EMAIL, AC.MERCHANT_ID,AC.ACCT_ID FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LJ_MERHCANT_ACC_DT     AC, LJ_PAYPAL_MT           P WHERE M.MT_ID = D.MT_ID AND D.ACCOUNT_ID = AC.ACCT_ID AND P.ACCOUNT_ID = D.ACCOUNT_ID AND D.BARCODE_NO = '$list_barcode'")->result_array(); 
                 if(count($query) > 0){
                    $merchant_id = $query[0]['MERCHANT_ID'];
                    $account_id = $query[0]['ACCT_ID'];
                    /*========================================================
                    =            check if our laptopzone merchant            =
                    ========================================================*/
                    if((int)$merchant_id === 1){
                        //var_dump("form else of account name");
                        //$account_id = $this->session->userdata('account_type');
                        $account_id = $account_type;
                        //var_dump("form else of account name: ". $get_acc);
                    }

                    /*=====  End of check if our laptopzone merchant  ======*/
                    
                 }
            }
        /*=====  End of get account_id against barcode  ======*/
        
            
          }// else is_numeric barcode closing
      if(!is_numeric($revise_ebay_id)){
        $revise_ebay_id = '';
      }
      // $list_barcode = $this->input->post("list_barcode");//set in v_item_seed will use in add item call to get picture folder
      // $seed_id = $this->input->post('seed_id');
      // $check_btn = $this->input->post('check_btn');
      // $revise_ebay_id = $this->input->post('revise_ebay_id');
       //var_dump($seed_id);
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
      $result['shopifyCheckbox'] = $shopifyCheckbox;
      $result['bestOfferCheckbox'] = $bestOfferCheckbox;
      $result['account_name'] = $account_id;
      $result['acct_id'] = $account_id;
      $result['addQtyOnly'] = $addQtyOnly;
      //var_dump($mpn);exit;
      //$this->load->view('ebay/finding/finditembykeyword',$result);
      $this->load->view('ebay/finding/finditemadvance_merg',$result);
      //$this->m_tolist->is_active_listing($item_id,$condition_id,$upc,$mpn);
      //$this->m_tolist->uplaod_listQty($item_id,$manifest_id,$list_qty);
      //3rd permetr condition
      $check = $this->session->userdata('check_item_id');

      if($check == true)
      {
        exit;
      }elseif($check_btn == "list"){
          $forceRevise = 0;
          $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
          if(empty($list_barcode)){
            $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
          }
          $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
          $qty = @$data['seed_data'][0]['QUANTITY'];

          $data['list_barcode'] = $list_barcode;
          $data['bestOfferCheckbox'] = $bestOfferCheckbox;
          $data['account_name'] = $account_id;
          $this->session->unset_userdata('ebay_item_id');
          $this->load->view('ebay/trading/04-add-fixed-price-item-merg',$data);
          if($this->session->userdata('ebay_item_id'))
          {
            $status = "ADD";
            $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
            //$this->load->view('ebay/trading/getitem');
            $this->m_tolist->insert_ebay_url();
            //List on Shopify Code
            if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
              $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty); 
            }

            $this->load->view('tolist_view/v_post_list',$result);
            $this->session->unset_userdata('ebay_item_id');
            $this->session->unset_userdata('check_item_id');
          }
      }else{
        die("Item not found on eBay.");
      }// end if else
    }else{
      echo"<script>alert('Error! Item not listed');return false;</script>";
    }
  }



  function list_item_merg_copy(){


    $shopifyCheckbox = @$this->uri->segment(7); // shopify checkbox value
    $bestOfferCheckbox = @$this->uri->segment(8); // bestOfferCheckbox checkbox value
    //$this->session->set_userdata('shopifyCheckbox', $shopifyCheckbox); // this session is for shopify checkbox value
    if($this->uri->segment(4))
    {

      //$list_barcode = $this->session->userdata("list_barcode");//set in v_item_seed will use in add item call to get picture folder
      $seed_id = @$this->uri->segment(4);
      $check_btn = @$this->uri->segment(5);
      $list_barcode = @$this->uri->segment(6);
      $revise_ebay_id = @$this->uri->segment(9);

    
      if(!is_numeric($list_barcode)){
        $list_barcode = '';
        $account_id = $this->session->userdata('account_type');
      }else{
        /*======================================================
        =            get account_id against barcode            =
        ======================================================*/
        $account_id = $this->session->userdata('account_type');
              

            if(!empty($list_barcode)){
                 $query = $this->db->query("SELECT AC.TOKEN, P.PAYPAL_EMAIL, AC.MERCHANT_ID,AC.ACCT_ID FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LJ_MERHCANT_ACC_DT     AC, LJ_PAYPAL_MT           P WHERE M.MT_ID = D.MT_ID AND D.ACCOUNT_ID = AC.ACCT_ID AND P.ACCOUNT_ID = D.ACCOUNT_ID AND D.BARCODE_NO = '$list_barcode'")->result_array(); 
                 if(count($query) > 0){
                    $merchant_id = $query[0]['MERCHANT_ID'];
                    $account_id = $query[0]['ACCT_ID'];
                    /*========================================================
                    =            check if our laptopzone merchant            =
                    ========================================================*/
                    if((int)$merchant_id === 1){
                        //var_dump("form else of account name");
                        $account_id = $this->session->userdata('account_type');
                        //var_dump("form else of account name: ". $get_acc);
                        
                    }

                    /*=====  End of check if our laptopzone merchant  ======*/
                    
                 }
            }
        /*=====  End of get account_id against barcode  ======*/
      }
      if(!is_numeric($revise_ebay_id)){
        $revise_ebay_id = '';
      }
      
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
      $result['shopifyCheckbox'] = $shopifyCheckbox;      
      $result['bestOfferCheckbox'] = $bestOfferCheckbox;      

      if($check_btn == 'list'){
        //var_dump($check_btn);
        
        //$this->load->view('ebay/finding/finditemadvance_merg',$result);
         //$check = $this->session->userdata('check_item_id');

        // if($check == true)
        // {
        //   exit;
        // }
          $forceRevise = 0;
          $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
          if(empty($list_barcode)){
            $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
          }
          $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
          $qty = @$data['seed_data'][0]['QUANTITY'];

          $data['list_barcode'] = $list_barcode;
          $this->session->unset_userdata('ebay_item_id');
          $this->load->view('ebay/trading/04-add-fixed-price-item-merg',$data);
          if($this->session->userdata('ebay_item_id'))
          {
            $status = "ADD";
            $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
            //$this->load->view('ebay/trading/getitem');
            $this->m_tolist->insert_ebay_url();
            //List on Shopify Code
            if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
              $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty); 
            }

            $this->load->view('tolist_view/v_post_list',$result);
            $this->session->unset_userdata('ebay_item_id');
            $this->session->unset_userdata('check_item_id');
          }
      }elseif($check_btn == 'revise'){
         //var_dump($check_btn);
        

        //revise call start
          $query = $this->db->query("SELECT S.ITEM_ID, S.LZ_MANIFEST_ID, S.DEFAULT_COND, S.CATEGORY_ID,I.ITEM_MT_UPC UPC,I.ITEM_MT_MFG_PART_NO MPN,I.ITEM_MT_MANUFACTURE FROM LZ_ITEM_SEED S, ITEMS_MT I WHERE S.SEED_ID = $seed_id AND I.ITEM_ID = S.ITEM_ID"); 
        $result['data'] = $query->result_array();
        $item_id = $result['data'][0]['ITEM_ID'];
        $manifest_id = $result['data'][0]['LZ_MANIFEST_ID'];
        $condition_id = $result['data'][0]['DEFAULT_COND'];
        $category_id = $result['data'][0]['CATEGORY_ID'];
        $upc = $result['data'][0]['UPC'];
        $mpn = $result['data'][0]['MPN'];
        $check = $this->session->userdata('check_item_id');

    // if($check == true)
    // {
      //$ebay_id = $this->session->userdata('ebay_item_id');
      //$ebay_id = trim($this->input->post('selected_ebay_id'));
      $ebay_id = $revise_ebay_id;//trim($this->input->post('selected_ebay_id'));
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID,E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
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
      $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $qty = $data['seed_data'][0]['QUANTITY'];
      $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      //$data['account_name'] = $account_name;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
        $result['check_btn'] = $check_btn;
        //$this->load->view('ebay/trading/getitem');
        //$this->m_tolist->insert_ebay_url();
        //List on Shopify Code
        if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
          $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty);  
        }        
        $this->load->view('tolist_view/v_post_list',$result);
        $this->session->unset_userdata('ebay_error');
        $this->session->unset_userdata('ebay_item_id');
        $this->session->unset_userdata('check_item_id');
        //$this->session->unset_userdata('ebay_item_url');
        //break;
      }else{
        die('Unable to Revise an item');
      }

      /// revise call end



      }else{
        die("Item not found on eBay.");
      }// end if else
    }else{
      echo"<script>alert('Error! Item not listed');return false;</script>";
    }
  }


  function list_item_confirm_merg(){
  $check_btn = $this->input->post('check_btn');
  $shopifyCheckbox = $this->input->post('shopifyCheckbox');
  $bestOfferCheckbox = $this->input->post('bestOfferCheckbox');
  $addQtyOnly = $this->input->post('addQtyOnly');
  //$account_id = $this->session->userdata('account_type');
  $account_id = $this->input->post('acct_id');
  if(empty($account_id)){
    $account_id = $this->session->userdata('account_type');
  }
  if($this->input->post('revise_item'))
  {
    $seed_id = $this->input->post('seed_id');
    //$account_name = $this->input->post('account_name');
    $list_barcode = $this->input->post('list_barcode');
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
      $ebay_id = trim($this->input->post('selected_ebay_id'));
      $query = $this->db->query("SELECT * FROM (SELECT E.ITEM_ID,E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
      $old_item = $query->result_array();
      if($query->num_rows() > 0){
        if($old_item[0]['ITEM_ID'] != $item_id){
         $old_item_id = $old_item[0]['ITEM_ID'];
         $new_item_id = $item_id;
         $replace_itm = "call lz_repl_item($old_item_id,$new_item_id,$manifest_id,$condition_id)";
         $replace_itm = $this->db->query($replace_itm);
        }
        //$account_id = $old_item[0]['LZ_SELLER_ACCT_ID'];
      }
      $get_seller_acct = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND UPPER(E.STATUS) = 'ADD' AND ROWNUM=1 ")->result_array();
      if(count($get_seller_acct) > 0){
        $account_id = @$get_seller_acct[0]['LZ_SELLER_ACCT_ID'];
      }else{
        $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array(); 
        $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];      
      }
      $forceRevise = 0;
      $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $qty = @$data['seed_data'][0]['QUANTITY'];
      $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['list_barcode'] = $list_barcode;
      $data['account_name'] = $account_id;
      $data['bestOfferCheckbox'] = $bestOfferCheckbox;
      $data['addQtyOnly'] = $addQtyOnly;
      //$data['account_name'] = $account_name;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
        $result['check_btn'] = $check_btn;
        //$this->load->view('ebay/trading/getitem');
        //$this->m_tolist->insert_ebay_url();
        //List on Shopify Code
        if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id) AND !empty(@$qty)){
          $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty);  
        }        
        $this->load->view('tolist_view/v_post_list',$result);
        $this->session->unset_userdata('ebay_error');
        $this->session->unset_userdata('ebay_item_id');
        $this->session->unset_userdata('check_item_id');
        //$this->session->unset_userdata('ebay_item_url');
        //break;
      }else{
        die('Unable to Revise an item');
      }
   
    // }else{
    //   die('Unable to Revise an item');
    // }

  }elseif($this->input->post('add_item')){
    //$list_barcode = $this->session->userdata("list_barcode");//set in v_item_seed will use in add item call to get picture folder
    $list_barcode = $this->input->post("list_barcode");//set in v_item_seed will use in add item call to get picture folder
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
    $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
    if(empty($list_barcode)){// if barcode available than pic will be uploaded from 04-add-fixed-price-item
      $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
      //$account_id = $this->session->userdata('account_type');
    }else{
      /*======================================================
        =            get account_id against barcode            =
        ======================================================*/
        
              

            if(!empty($list_barcode)){
                 $query = $this->db->query("SELECT AC.TOKEN, P.PAYPAL_EMAIL, AC.MERCHANT_ID,AC.ACCT_ID FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LJ_MERHCANT_ACC_DT     AC, LJ_PAYPAL_MT           P WHERE M.MT_ID = D.MT_ID AND D.ACCOUNT_ID = AC.ACCT_ID AND P.ACCOUNT_ID = D.ACCOUNT_ID AND D.BARCODE_NO = '$list_barcode'")->result_array(); 
                 if(count($query) > 0){
                    $merchant_id = $query[0]['MERCHANT_ID'];
                    $account_id = $query[0]['ACCT_ID'];
                    /*========================================================
                    =            check if our laptopzone merchant            =
                    ========================================================*/
                    if((int)$merchant_id === 1){
                        //var_dump("form else of account name");
                        //$account_id = $this->session->userdata('account_type');
                        $account_id = $this->input->post('acct_id');
                        if(empty($account_id)){
                          $account_id = $this->session->userdata('account_type');
                        }
                        //var_dump("form else of account name: ". $get_acc);
                        // if((int)$get_acc == 2){
                        //     $account_id = 3;

                        // }else{
                        //     $account_id = 2;

                        // }
                    }

                    /*=====  End of check if our laptopzone merchant  ======*/
                    
                 }
            }
        /*=====  End of get account_id against barcode  ======*/
    }
    $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
    $data['list_barcode'] = $list_barcode;
    $data['bestOfferCheckbox'] = $bestOfferCheckbox;
    $data['account_name'] = $account_id;
    $this->session->unset_userdata('ebay_item_id');
    $this->session->unset_userdata('check_item_id');            
    $this->load->view('ebay/trading/04-add-fixed-price-item-merg',$data);
    if($this->session->userdata('ebay_item_id'))
    {
      $status = "ADD";
      $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
      //$this->load->view('ebay/trading/getitem');
      $this->m_tolist->insert_ebay_url();
      $this->load->view('tolist_view/v_post_list',$result);
      $this->session->unset_userdata('ebay_item_id');
      $this->session->unset_userdata('ebay_item_url');
    }
  }else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }
} 
public function reviseItemPrice(){
  $ebay_id = trim($this->input->post('ebay_id'));
  $price = trim($this->input->post('revise_price'));
  //$seed_id = trim($this->input->post('seed_id'));
  $query = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id'AND S.SEED_ID = E.SEED_ID ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1"); 
  $old_item = $query->result_array();
  if($query->num_rows() > 0){
    $account_id = $old_item[0]['LZ_SELLER_ACCT_ID'];
    $site_id = $old_item[0]['EBAY_LOCAL'];
  }else{
    echo "alert('Some error Occur please Contact Your Administartor')";
    exit;
  }
  // $forceRevise = 0;
  // $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
  // $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
  $data['ebay_id'] = $ebay_id;
  $data['site_id'] = $site_id;
  $data['price'] = $price;
  $data['account_name'] = $account_id;// used in configuration.php
  $data['addQty'] = 0;// used in less qty call
  //$data['forceRevise'] = $forceRevise;
  //$this->session->unset_userdata('active_listing');
  $this->load->view('ebay/trading/reviseItemPrice',$data);
  if(!empty($this->session->userdata('ebay_item_id')))
  {
    $status = "REVISED";
    $result['list_id'] = $this->m_tolist->updateReviseStatus($ebay_id,$price);
    //$result['check_btn'] = $check_btn;
    //$this->load->view('ebay/trading/getitem');
    //$this->m_tolist->insert_ebay_url();
    //$this->load->view('tolist_view/v_post_list',$result);
    $this->session->unset_userdata('ebay_error');
    $this->session->unset_userdata('ebay_item_id');
    $this->session->unset_userdata('check_item_id');
    //$this->session->unset_userdata('ebay_item_url');
    //break;
  }else{
    die('Unable to Revise an item');
    return false;
  }
}

public function getItemQty(){

    $ebay_id = trim($this->input->post('ebay_id'));
    // $remarks = trim($this->input->post('remarks'));
    // $adj_barcode = trim($this->input->post('adj_barcode'));
    // $adj_qty = trim($this->input->post('adj_qty'));
    // $user_id = $this->session->userdata('user_id');
    
    $get_seller_acct = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id'AND S.SEED_ID = E.SEED_ID AND UPPER(E.STATUS) = 'ADD' ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array();
    if(count($get_seller_acct) > 0){
      $account_id = @$get_seller_acct[0]['LZ_SELLER_ACCT_ID'];
      $site_id = @$get_seller_acct[0]['EBAY_LOCAL'];
    }else{
      $get_seller = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id' AND S.SEED_ID = E.SEED_ID ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array(); 
      $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
      $site_id = @$get_seller[0]['EBAY_LOCAL'];      
    }


    if(empty($account_id)){
      $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array(); 
      $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
      $site_id = 0;      
    }
    if(empty($account_id)){
       $data = "Account id against this ebay Id:".$ebay_id. " is Not Found in system.";
       //$data = 1;
       echo json_encode($data);
       return json_encode($data);
      exit;
    }
    $data['ebay_id'] = $ebay_id;
    $data['site_id'] = $site_id;
    $data['account_name'] = $account_id;// used in configuration.php
    //$data['forceRevise'] = $forceRevise;
    //$this->session->unset_userdata('active_listing');
   $this->load->view('ebay/trading/getItemQty',$data);
   $current_qty_adj = $this->session->userdata('current_qty_adj');
   $this->session->unset_userdata('current_qty_adj');
   // if(is_numeric($current_qty_adj)){
   //   $this->db->query("call pro_adjEbayQty($ebay_id, $adj_barcode, $adj_qty, $user_id, $remarks)"); 
   // }
    echo json_encode($current_qty_adj);
    return json_encode($current_qty_adj);
  }
  public function updateItemQty(){

    $ebay_id = trim($this->input->post('ebay_id'));
    $remarks = trim($this->input->post('remarks'));
    $adj_barcode = trim($this->input->post('adj_barcode'));
    $adj_qty = trim($this->input->post('adj_qty'));
    $user_id = $this->session->userdata('user_id');
    //$get_seller_acct = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND UPPER(E.STATUS) = 'ADD' AND ROWNUM=1 ")->result_array();
    $get_seller_acct = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id'AND S.SEED_ID = E.SEED_ID AND UPPER(E.STATUS) = 'ADD' ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array();
    if(count($get_seller_acct) > 0){
      $account_id = @$get_seller_acct[0]['LZ_SELLER_ACCT_ID'];
      $site_id = @$get_seller_acct[0]['EBAY_LOCAL'];
    }else{
      $get_seller = $this->db->query("SELECT * FROM (SELECT E.LZ_SELLER_ACCT_ID,S.EBAY_LOCAL FROM EBAY_LIST_MT E, LZ_ITEM_SEED S WHERE E.EBAY_ITEM_ID = '$ebay_id' AND S.SEED_ID = E.SEED_ID ORDER BY E.LIST_ID DESC) WHERE  ROWNUM = 1")->result_array(); 
      $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
      $site_id = @$get_seller[0]['EBAY_LOCAL'];      
    }


    if(empty($account_id)){
      $get_seller = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' AND ROWNUM=1")->result_array(); 
      $account_id = @$get_seller[0]['LZ_SELLER_ACCT_ID'];
      $site_id = 0;      
    }
    if(empty($account_id)){
       $data = "Account id against this ebay Id:".$ebay_id. " is Not Found in system.";
       //$data = 1;
       echo json_encode($data);
       return json_encode($data);
       exit;
    }
    $data['ebay_id'] = $ebay_id;
    $data['site_id'] = $site_id;
    $data['quantity'] = $adj_qty;
    $data['account_name'] = $account_id;// used in configuration.php
    $data['addQty'] = 1;// used in less qty call
    //$data['forceRevise'] = $forceRevise;
    //$this->session->unset_userdata('active_listing');
   $this->load->view('ebay/trading/reviseItemPrice',$data);
   $current_qty_adj = $this->session->userdata('current_qty_adj');
   $this->session->unset_userdata('current_qty_adj');
   if($current_qty_adj === -1){
     $this->db->query("CALL PRO_ADJEBAYQTY($ebay_id, '$adj_barcode', $adj_qty, $user_id, '$remarks')"); 
   }
    echo json_encode($current_qty_adj);
    return json_encode($current_qty_adj);
  }
}


?>