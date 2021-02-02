<?php 

	class C_Tolist extends CI_Controller{
		public function __construct()
    {
  		parent::__construct();
  		$this->load->database();
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
      $this->load->model('tolist/m_tolist');
      $result['data'] = $this->m_tolist->default_view();
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
      
      $this->load->model('tolist/m_tolist');
      $result['data'] = $this->m_tolist->search_filter_view($search_record,$from,$to,$purchase_no);
      $result['pageTitle'] = 'To-List View';
      $this->load->view('tolist_view/v_tolist_view', $result);      

    }
    public function lister_view(){
      if($this->input->post('Submit')){
        $result['data'] = $this->m_tolist->item_listing();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Item Listing';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_lister_view', $result); 
      }else{
        $result['data'] = $this->m_tolist->item_listing();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Item Listing';
        $result['activeTab'] = 'Not Listed';
        $result['location'] = 'ALL';
        $this->load->view('tolist_view/v_lister_view', $result);        
      }
// elseif($this->input->post('search_lister')){
//         $location = $this->input->post('location');
//         $result['data'] = $this->m_tolist->item_listing();
//         $result['lister'] = $this->lister_model->ListerUsers();
//         $result['pageTitle'] = 'Item Listing';
//         $result['activeTab'] = 'Listed';
//         $result['location'] = $location;
//         $this->load->view('tolist_view/v_lister_view', $result);      
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

    if($this->input->post('search_lister')){
        $location = $this->input->post('location');
        $result['data'] = $this->m_tolist->listedItemsAudit();
        $result['lister'] = $this->lister_model->ListerUsers();
        $result['pageTitle'] = 'Listed Items Audit';
        $result['location'] = $location;
        $this->load->view('tolist_view/v_listedItemsAudit', $result);        
      }else{
        $result['data'] = $this->m_tolist->listedItemsAudit();
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
    $seed_id = $this->input->post('seed_id');
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
   $this->m_tolist->update();
   $this->session->set_userdata('flag',true);
   redirect('tolist/c_tolist/seed_view/'.$seed_id);
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

function get_conditions(){

   $cond_name = $this->input->post('CondID');
   $this->db->from("LZ_ITEM_COND_MT");
   $this->db->where('ID', $cond_name);
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

  if($this->input->post('item_list'))
  {

            $seed_id = $this->input->post('seed_id');
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
              
            }else{
                $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id);
                $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id);
                $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
                $this->session->unset_userdata('ebay_item_id');
                $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
                if($this->session->userdata('ebay_item_id'))
                {
                  $status = "ADD";
                  $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
                  $this->load->view('ebay/trading/getitem');
                  $this->m_tolist->insert_ebay_url();
                  $this->session->unset_userdata('ebay_item_id');
                  $this->session->unset_userdata('check_item_id');
                }
            }// end if else
  }else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }
}
    
    
    /*=====  End of copy from c_seed  ======*/
 function list_item_confirm(){

  if($this->input->post('revise_item'))
  {
            $seed_id = $this->input->post('seed_id');
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

            if($check == true)
            {
              $ebay_id = $this->session->userdata('ebay_item_id');
              $query = $this->db->query("SELECT E.ITEM_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = $ebay_id AND ROWNUM = 1"); 
              $old_item = $query->result_array();
              if($query->num_rows() > 0){
                if($old_item[0]['ITEM_ID'] != $item_id){
                 $old_item_id = $old_item[0]['ITEM_ID'];
                 $new_item_id = $item_id;
                 $replace_itm = "call lz_repl_item($old_item_id,$new_item_id)";
                 $replace_itm = $this->db->query($replace_itm);
                }
              }
              $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id);
              //$this->session->unset_userdata('active_listing');
              $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
              if(!empty($this->session->userdata('ebay_item_id')))
              {
                if($this->session->userdata('ebay_error'))
                {
                  $ebay_error = $this->session->userdata('ebay_error');
                  $this->session->unset_userdata('ebay_error');
                  $this->session->unset_userdata('ebay_item_id');
                  $this->session->unset_userdata('check_item_id');
                  die($ebay_error);
                }
                $status = "REVISED";
                $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
                $this->load->view('ebay/trading/getitem');
                $this->m_tolist->insert_ebay_url();
                $this->session->unset_userdata('ebay_item_id');
                $this->session->unset_userdata('check_item_id');
                $this->session->unset_userdata('ebay_item_url');
                //break;
              }else{
                die('Unable to Revise an item');
              }
/*==============================================
=            add item call commented            =
==============================================*/
             // else{
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
/*=====  End of add item call commented  ======*/              
            }else{
              die('Unable to Revise an item');
            }

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
            $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id);
            $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id);
            $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
            $this->session->unset_userdata('ebay_item_id');
            $this->session->unset_userdata('check_item_id');            
            $this->load->view('ebay/trading/04-add-fixed-price-item',$data);
            if($this->session->userdata('ebay_item_id'))
            {
              $status = "ADD";
              $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status);
              $this->load->view('ebay/trading/getitem');
              $this->m_tolist->insert_ebay_url();
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
}


?>