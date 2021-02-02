<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

header("Access-Control-Allow-Origin: *");
//header("Content-Type: application/json; charset=UTF-8");
  /**
  * Listing Controller
  */
class c_react extends CI_Controller
{
    
  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->model('reactcontroller/m_react');
          
  }


  public function login(){
    

    $data = $this->m_react->login();                
        echo json_encode($data);
      return json_encode($data);

  }
  public function getMacro(){

    $data = $this->m_tolist->getMacro();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function verify_item(){

    $data = $this->m_react->verify_item();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function get_obj_drop_sugestion(){

    $data = $this->m_react->get_obj_drop_sugestion();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function get_unposted_item(){

    $data = $this->m_react->get_unposted_item();                
        echo json_encode($data);
      return json_encode($data);
  }

  public function get_verify_item(){    

    $data = $this->m_react->get_verify_item();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function get_dropdowns(){  

    $data = $this->m_react->get_dropdowns();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function serch_mpn_sys(){  

    $data = $this->m_react->serch_mpn_sys();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function get_upc_title(){  

    $data = $this->m_react->get_upc_title();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function serch_desc_sys(){ 

    $data = $this->m_react->serch_desc_sys();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function get_avail_cond(){ 

    $data = $this->m_react->get_avail_cond();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function get_obj_drop(){ 

    $data = $this->m_react->get_obj_drop();                
        echo json_encode($data);
      return json_encode($data);
  }

  public function update_seed(){  

    $data = $this->m_react->update_seed();                
        echo json_encode($data);
      return json_encode($data);
  }

  public function get_pictures(){ 

    $data = $this->m_react->get_pictures();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function queryData(){  

    $data = $this->m_react->queryData();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function add_specifics() {
    $data = $this->m_react->add_specifics();
    echo json_encode($data);
    return json_encode($data);
    }
    public function add_custom_specifics() {
    $data = $this->m_react->add_custom_specifics();
    echo json_encode($data);
    return json_encode($data);
    } 
    public function get_cond_desc(){

      $data = $this->m_react->get_cond_desc();
    echo json_encode($data);
    return json_encode($data);
    }
    public function mer_active_listed(){

      $data = $this->m_react->mer_active_listed();
    echo json_encode($data);
    return json_encode($data);
    }
  public function mer_active_not_listed(){

      $data = $this->m_react->mer_active_not_listed();
    echo json_encode($data);
    return json_encode($data);
    }

    public function merchant_dashboard(){

      $data = $this->m_react->merchant_dashboard();
    echo json_encode($data);
    return json_encode($data);
    }

    public function attribute_value(){
      // if($this->input->post('save_attr')){
        $cat_id = $this->input->post('cat_id');
        $barcode = $this->input->post('bar_code');
        $item_mpn = $this->input->post('item_mpn');
        $item_upc = $this->input->post('item_upc');
        $spec_name = $this->input->post('spec_name');
        //$spec_name = trim(str_replace("  ", ' ', $spec_name));
        $spec_name = trim(str_replace(array("'"), "''", $spec_name));
        //var_dump($spec_name);exit;
        $custom_attribute = ucfirst($this->input->post('custom_attribute'));
        $custom_attribute = trim(str_replace("  ", ' ', $custom_attribute));
        $custom_attribute = trim(str_replace(array("'"), "''", $custom_attribute));

        $data = $this->m_react->attribute_value($cat_id, $barcode, $item_mpn, $item_upc, $spec_name, $custom_attribute);
      echo json_encode($data);
      return json_encode($data);               

      // }
    }

      function list_item_merg_copy(){
   // $this->load->model('tolist/m_tolist');


    //$bestOfferCheckbox = @$this->uri->segment(8); 
    $seed_id = $this->input->post('seed_id');

    
    $bestOfferCheckbox = $this->input->post('bestOfferCheckbox');
    //$this->session->set_userdata('shopifyCheckbox', $shopifyCheckbox); // this session is for shopify checkbox value
    if( !empty($seed_id))
    {
      


      $check_btn = $this->input->post('clicked_btn');     
      $list_barcode = $this->input->post('list_barcode');
      $shopifyCheckbox = $this->input->post('shopifyCheckbox') ; 
      $revise_ebay_id = $this->input->post('ebay_id');
      $force_ebay_id = $this->input->post('revise_ebay_id');
      $accountId = $this->input->post('accountId');
      $forceRevise = $this->input->post('forceRevise');

      $userId = $this->input->post('userId');
      $userName = $this->input->post('userName');


       if(!is_numeric($list_barcode)){
        $list_barcode = '';
        //$account_id = $this->session->userdata('account_type');
      }else{
        /*======================================================
        =            get account_id against barcode            =
        ======================================================*/
        //$account_id = $this->session->userdata('account_type');
              

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
                        $account_id = $accountId;//$this->session->userdata('account_type');
                        //$account_id = $this->session->userdata('account_type');
                        //var_dump("form else of account name: ". $get_acc);
                    }

                    /*=====  End of check if our laptopzone merchant  ======*/
                    
                 }
                 $account_id = $accountId; /// tempray variable assign
            }
        /*=====  End of get account_id against barcode  ======*/
        
            
          }// else is_numeric barcode closing
      if(!is_numeric($revise_ebay_id)){
        $revise_ebay_id = '';
      }
      // var_dump($accountId);
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
      $result['account_name'] = $account_id;// used in configuration.php
     
      $result['shopifyCheckbox'] = $shopifyCheckbox;
      $result['bestOfferCheckbox'] = $bestOfferCheckbox;
      $result['uer_id'] = $userId;
      $result['userName'] = $userName;

      if($forceRevise == 1){
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
        // var_dump($check);
        // exit;

    // if($check == true)
    // {
      //$ebay_id = $this->session->userdata('ebay_item_id');
      //$ebay_id = trim($this->input->post('selected_ebay_id'));
      $ebay_id = $force_ebay_id;//trim($this->input->post('selected_ebay_id'));

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
       
      $forceRevise = 1;
      $data['seed_data'] = $this->m_react->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $qty = $data['seed_data'][0]['QUANTITY'];
      $data['specific_data'] = $this->m_react->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['account_name'] = $account_id;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      $data['bestOfferCheckbox'] = $bestOfferCheckbox;
      
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_react->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id,$userId);
        $result['check_btn'] = $check_btn;
        // var_dump($result['list_id']);
        // exit;
         $list_id =$result['list_id'];
        //$this->load->view('ebay/trading/getitem');
        //$this->m_tolist->insert_ebay_url();
        //List on Shopify Code
        // if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
        //   $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty);  
        // }        

        $list_qry = $this->db->query("SELECT E.EBAY_ITEM_ID, TO_CHAR(E.LIST_DATE, 'YYYY-MM-DD HH24:MI:SS') LIST_DATE, E.LZ_SELLER_ACCT_ID, U.EBAY_URL, E.LIST_QTY, E.LIST_PRICE, TRIM(E.STATUS) STATUS, D.ACCOUNT_NAME FROM EBAY_LIST_MT E, LZ_LISTED_ITEM_URL U , LJ_MERHCANT_ACC_DT D WHERE E.EBAY_ITEM_ID = U.EBAY_ID(+) AND E.LZ_SELLER_ACCT_ID = D.ACCT_ID(+) AND E.LIST_ID = $list_id")->result_array(); 
    $ebay_id = $list_qry[0]['EBAY_ITEM_ID'];
    $list_date = $list_qry[0]['LIST_DATE'];
    //$lz_seller_acct_id = $list_qry[0]['LZ_SELLER_ACCT_ID'];
    $account_type = $list_qry[0]['ACCOUNT_NAME'];
    $ebay_url = $list_qry[0]['EBAY_URL'];
    $list_qty = $list_qry[0]['LIST_QTY'];
    if(@$check_btn == 'revise'){
        $list_qty = 0;
    }
    $list_price = $list_qry[0]['LIST_PRICE'];
    $emp_name = $userName;//$this->session->userdata('employee_name');
    // var_dump($emp_name);
    // exit;
    $status = $list_qry[0]['STATUS'];
    $current_qty = $this->session->userdata('current_qty');
             echo "<div class='col-sm-12'>
                    <div id='errorMsgs' >
                        The item is <strong>Revised</strong> on eBay With the Following Details:<br>
                        <ul>
                            <li>Ebay Id: <a href='https://www.ebay.com/itm/".$ebay_id."' target='_blank' >".$ebay_id."</a></li>
                            <li>Ebay Account: ".$account_type."</li>
                            <li>Listed By: " .$emp_name." </li>
                            <li>Timestamp: " .$list_date." </li>
                            <li>List Price: $ ".$list_price." </li>
                            <li><strong style='color:red;'>eBay Qty: ".$current_qty."</strong></li>
                            <li><strong style='color:red;'>Pushed Qty: ".$list_qty."</strong></li>
                        </ul>
                    </div>
                  </div>";


        // $this->load->view('tolist_view/v_post_list',$result);
        $this->session->unset_userdata('ebay_error');
        $this->session->unset_userdata('ebay_item_id');
        $this->session->unset_userdata('check_item_id');
        $this->session->unset_userdata('ebay_item_url');
        //break;
      }else{
        die('Unable to Revise an item');
      }

      }elseif ($forceRevise == 0){
       

      $this->load->view('ebay/finding/finditemadvance_merg_copy',$result);
// var_dump('2');
//         exit;
      //3rd permetr condition
      $check = $this->session->userdata('check_item_id');

      if($check == true)
      {
        // var_dump('2');
        // exit;
        
        exit;
      }else if($check_btn == "list"){
        // var_dump('2');
        // exit;
        //  $data['account_name'] = $account_id;// used in configuration.php
        // exit;
          // var_dump($account_id);
          // exit;
          $forceRevise = 0;
          $data['seed_data'] = $this->m_react->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
          if(empty($list_barcode)){
            $data['pic_data'] = $this->m_react->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
          }
          $data['specific_data'] = $this->m_react->item_specifics($item_id,$manifest_id,$condition_id);
          $qty = @$data['seed_data'][0]['QUANTITY'];

          $data['list_barcode'] = $list_barcode;
          $data['bestOfferCheckbox'] = $bestOfferCheckbox;
          $this->session->unset_userdata('ebay_item_id');
          /// api call for listing item
          $this->load->view('ebay/trading/04-add-fixed-price-item-merg',$data);
          if($this->session->userdata('ebay_item_id'))
          {
            $status = "ADD";
            $result['list_id'] = $this->m_react->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id,$userId);
            $list_id =$result['list_id'];
            //$this->load->view('ebay/trading/getitem');
            $this->m_react->insert_ebay_url($userId);
            //List on Shopify Code
            // if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
            //   $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty); 
            // }

            $list_qry = $this->db->query("SELECT E.EBAY_ITEM_ID, TO_CHAR(E.LIST_DATE, 'YYYY-MM-DD HH24:MI:SS') LIST_DATE, E.LZ_SELLER_ACCT_ID, U.EBAY_URL, E.LIST_QTY, E.LIST_PRICE, TRIM(E.STATUS) STATUS, D.ACCOUNT_NAME FROM EBAY_LIST_MT E, LZ_LISTED_ITEM_URL U , LJ_MERHCANT_ACC_DT D WHERE E.EBAY_ITEM_ID = U.EBAY_ID(+) AND E.LZ_SELLER_ACCT_ID = D.ACCT_ID(+) AND E.LIST_ID = $list_id")->result_array(); 
            $ebay_id = $list_qry[0]['EBAY_ITEM_ID'];
            $list_date = $list_qry[0]['LIST_DATE'];
            //$lz_seller_acct_id = $list_qry[0]['LZ_SELLER_ACCT_ID'];
            $account_type = $list_qry[0]['ACCOUNT_NAME'];
            $ebay_url = $list_qry[0]['EBAY_URL'];
            $list_qty = $list_qry[0]['LIST_QTY'];
            if(@$check_btn == 'revise'){
                $list_qty = 0;
            }
            $list_price = $list_qry[0]['LIST_PRICE'];
            $emp_name = $userName;//$this->session->userdata('employee_name');
            // var_dump($emp_name);
            // exit;
            $status = $list_qry[0]['STATUS'];
            $current_qty = $this->session->userdata('current_qty');
                    echo "<div class='col-sm-12'>
                
                <div id='errorMsgs' >
                    The item is listed on eBay With the Following Details:<br>
                    <ul>
                        
                        <li>Ebay Id: <a href='https://www.ebay.com/itm/".$ebay_id."' target='_blank' >".$ebay_id."</a></li>
                        <li>Ebay Account: ".$account_type."</li>
                        <li>Listed By: " .$emp_name." </li>
                        <li>Timestamp: " .$list_date." </li>
                        <li>List Qty: " .$list_qty." </li>
                        <li>List Price: $ ".$list_price." </li>
                    </ul>
                </div>
               
            </div>";


            // $this->load->view('tolist_view/v_post_list',$result);
            $this->session->unset_userdata('ebay_item_id');
            $this->session->unset_userdata('check_item_id');
          }
      }elseif($check_btn == 'revise'){
        
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
        // var_dump($check);
        // exit;

    // if($check == true)
    // {
      //$ebay_id = $this->session->userdata('ebay_item_id');
      //$ebay_id = trim($this->input->post('selected_ebay_id'));
      $ebay_id = $revise_ebay_id;//trim($this->input->post('selected_ebay_id'));

      // var_dump($ebay_id);
      // exit;
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
      $data['seed_data'] = $this->m_react->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $qty = $data['seed_data'][0]['QUANTITY'];
      $data['specific_data'] = $this->m_react->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['account_name'] = $account_id;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      $data['bestOfferCheckbox'] = $bestOfferCheckbox;
      
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_react->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id,$userId);
        $result['check_btn'] = $check_btn;
        // var_dump($result['list_id']);
        // exit;
         $list_id =$result['list_id'];
        //$this->load->view('ebay/trading/getitem');
        //$this->m_tolist->insert_ebay_url();
        //List on Shopify Code
        // if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
        //   $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty);  
        // }        

        $list_qry = $this->db->query("SELECT E.EBAY_ITEM_ID, TO_CHAR(E.LIST_DATE, 'YYYY-MM-DD HH24:MI:SS') LIST_DATE, E.LZ_SELLER_ACCT_ID, U.EBAY_URL, E.LIST_QTY, E.LIST_PRICE, TRIM(E.STATUS) STATUS, D.ACCOUNT_NAME FROM EBAY_LIST_MT E, LZ_LISTED_ITEM_URL U , LJ_MERHCANT_ACC_DT D WHERE E.EBAY_ITEM_ID = U.EBAY_ID(+) AND E.LZ_SELLER_ACCT_ID = D.ACCT_ID(+) AND E.LIST_ID = $list_id")->result_array(); 
    $ebay_id = $list_qry[0]['EBAY_ITEM_ID'];
    $list_date = $list_qry[0]['LIST_DATE'];
    //$lz_seller_acct_id = $list_qry[0]['LZ_SELLER_ACCT_ID'];
    $account_type = $list_qry[0]['ACCOUNT_NAME'];
    $ebay_url = $list_qry[0]['EBAY_URL'];
    $list_qty = $list_qry[0]['LIST_QTY'];
    if(@$check_btn == 'revise'){
        $list_qty = 0;
    }
    $list_price = $list_qry[0]['LIST_PRICE'];
    $emp_name = $userName;//$this->session->userdata('employee_name');
    // var_dump($emp_name);
    // exit;
    $status = $list_qry[0]['STATUS'];
    $current_qty = $this->session->userdata('current_qty');
             echo "<div class='col-sm-12'>
                    <div id='errorMsgs' >
                        The item is <strong>Revised</strong> on eBay With the Following Details:<br>
                        <ul>
                            <li>Ebay Id: <a href='https://www.ebay.com/itm/".$ebay_id."' target='_blank' >".$ebay_id."</a></li>
                            <li>Ebay Account: ".$account_type."</li>
                            <li>Listed By: " .$emp_name." </li>
                            <li>Timestamp: " .$list_date." </li>
                            <li>List Price: $ ".$list_price." </li>
                            <li><strong style='color:red;'>eBay Qty: ".$current_qty."</strong></li>
                            <li><strong style='color:red;'>Pushed Qty: ".$list_qty."</strong></li>
                        </ul>
                    </div>
                  </div>";


        // $this->load->view('tolist_view/v_post_list',$result);
        $this->session->unset_userdata('ebay_error');
        $this->session->unset_userdata('ebay_item_id');
        $this->session->unset_userdata('check_item_id');
        $this->session->unset_userdata('ebay_item_url');
        //break;
      }else{
        die('Unable to Revise an item');
      }

      /// revise call end



        }else{
          die("Item not found on eBay.");
        }// end if else

      }
    }else{
      echo"<script>alert('Error! Item not listed');return false;</script>";
    }
  }


   function list_item_confirm_merg(){
  $check_btn = $this->input->post('check_btn');
  $shopifyCheckbox = $this->input->post('shopifyCheckbox');
  $bestOfferCheckbox = $this->input->post('bestOfferCheckbox');
  //$account_id = $this->session->userdata('account_type');
  $user_id = $this->input->post('user_id');
  $userName = $this->input->post('userName');
  
  // var_dump($this->input->post('revise_item'));
  // exit;
  if($this->input->post('revise_item'))
  {
    // var_dump('asd');
    // exit;
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
      $data['seed_data'] = $this->m_react->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
      $qty = $data['seed_data'][0]['QUANTITY'];
      $data['specific_data'] = $this->m_react->item_specifics($item_id,$manifest_id,$condition_id);
      $data['ebay_id'] = $ebay_id;
      $data['check_btn'] = $check_btn;
      $data['list_barcode'] = $list_barcode;
      $data['account_name'] = $account_id;
      $data['bestOfferCheckbox'] = $bestOfferCheckbox;
      //$data['account_name'] = $account_name;// used in configuration.php
      $data['forceRevise'] = $forceRevise;
      //$this->session->unset_userdata('active_listing');
      $this->load->view('ebay/trading/Revisefixedpriceitem',$data);
      if(!empty($this->session->userdata('ebay_item_id')))
      {
        $status = "REVISED";
        $result['list_id'] = $this->m_react->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id,$user_id);
        $result['check_btn'] = $check_btn;
        $list_id =$result['list_id'];
        //$this->load->view('ebay/trading/getitem');
        //$this->m_tolist->insert_ebay_url();
        //List on Shopify Code
        // if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
        //   $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty);  
        // }        
        //$this->load->view('tolist_view/v_post_list',$result);
        $list_qry = $this->db->query("SELECT E.EBAY_ITEM_ID, TO_CHAR(E.LIST_DATE, 'YYYY-MM-DD HH24:MI:SS') LIST_DATE, E.LZ_SELLER_ACCT_ID, U.EBAY_URL, E.LIST_QTY, E.LIST_PRICE, TRIM(E.STATUS) STATUS, D.ACCOUNT_NAME FROM EBAY_LIST_MT E, LZ_LISTED_ITEM_URL U , LJ_MERHCANT_ACC_DT D WHERE E.EBAY_ITEM_ID = U.EBAY_ID(+) AND E.LZ_SELLER_ACCT_ID = D.ACCT_ID(+) AND E.LIST_ID = $list_id")->result_array(); 
    $ebay_id = $list_qry[0]['EBAY_ITEM_ID'];
    $list_date = $list_qry[0]['LIST_DATE'];
    //$lz_seller_acct_id = $list_qry[0]['LZ_SELLER_ACCT_ID'];
    $account_type = $list_qry[0]['ACCOUNT_NAME'];
    $ebay_url = $list_qry[0]['EBAY_URL'];
    $list_qty = $list_qry[0]['LIST_QTY'];
    if(@$check_btn == 'revise'){
        $list_qty = 0;
    }
    $list_price = $list_qry[0]['LIST_PRICE'];
    $emp_name = $userName;//$this->session->userdata('employee_name');
    // var_dump($emp_name);
    // exit;
    $status = $list_qry[0]['STATUS'];
    $current_qty = $this->session->userdata('current_qty');
             echo "<div class='col-sm-12'>
                    <div id='errorMsgs' >
                        The item is <strong>Revised</strong> on eBay With the Following Details:<br>
                        <ul>
                            <li>Ebay Id: <a href='https://www.ebay.com/itm/".$ebay_id."' target='_blank' >".$ebay_id."</a></li>
                            <li>Ebay Account: ".$account_type."</li>
                            <li>Listed By: " .$emp_name." </li>
                            <li>Timestamp: " .$list_date." </li>
                            <li>List Price: $ ".$list_price." </li>
                            <li><strong style='color:red;'>eBay Qty: ".$current_qty."</strong></li>
                            <li><strong style='color:red;'>Pushed Qty: ".$list_qty."</strong></li>
                        </ul>
                    </div>
                  </div>";

        
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

   }
     // elseif($this->input->post('add_item')){
  //   //$list_barcode = $this->session->userdata("list_barcode");//set in v_item_seed will use in add item call to get picture folder
  //   $list_barcode = $this->input->post("list_barcode");//set in v_item_seed will use in add item call to get picture folder
  //   $seed_id = $this->input->post('seed_id');
  //   $query = $this->db->query("SELECT S.ITEM_ID, S.LZ_MANIFEST_ID, S.DEFAULT_COND, S.CATEGORY_ID,I.ITEM_MT_UPC UPC,I.ITEM_MT_MFG_PART_NO MPN,I.ITEM_MT_MANUFACTURE FROM LZ_ITEM_SEED S, ITEMS_MT I WHERE S.SEED_ID = $seed_id AND I.ITEM_ID = S.ITEM_ID"); 
  //   $result['data'] = $query->result_array();
  //   $item_id = $result['data'][0]['ITEM_ID'];
  //   $manifest_id = $result['data'][0]['LZ_MANIFEST_ID'];
  //   $condition_id = $result['data'][0]['DEFAULT_COND'];
  //   $category_id = $result['data'][0]['CATEGORY_ID'];
  //   $upc = $result['data'][0]['UPC'];
  //   $mpn = $result['data'][0]['MPN'];
  //   $forceRevise = 0;
  //   $data['seed_data'] = $this->m_tolist->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
  //   if(empty($list_barcode)){// if barcode available than pic will be uploaded from 04-add-fixed-price-item
  //     $data['pic_data'] = $this->m_tolist->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
  //     $account_id = $this->session->userdata('account_type');
  //   }else{
  //     /*======================================================
  //       =            get account_id against barcode            =
  //       ======================================================*/
        
              

  //           if(!empty($list_barcode)){
  //                $query = $this->db->query("SELECT AC.TOKEN, P.PAYPAL_EMAIL, AC.MERCHANT_ID,AC.ACCT_ID FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D, LJ_MERHCANT_ACC_DT     AC, LJ_PAYPAL_MT           P WHERE M.MT_ID = D.MT_ID AND D.ACCOUNT_ID = AC.ACCT_ID AND P.ACCOUNT_ID = D.ACCOUNT_ID AND D.BARCODE_NO = '$list_barcode'")->result_array(); 
  //                if(count($query) > 0){
  //                   $merchant_id = $query[0]['MERCHANT_ID'];
  //                   $account_id = $query[0]['ACCT_ID'];
  //                   /*========================================================
  //                   =            check if our laptopzone merchant            =
  //                   ========================================================*/
  //                   if((int)$merchant_id === 1){
  //                       //var_dump("form else of account name");
  //                       $account_id = $this->session->userdata('account_type');
  //                       //var_dump("form else of account name: ". $get_acc);
  //                       // if((int)$get_acc == 2){
  //                       //     $account_id = 3;

  //                       // }else{
  //                       //     $account_id = 2;

  //                       // }
  //                   }

  //                   /*=====  End of check if our laptopzone merchant  ======*/
                    
  //                }
  //           }
  //       /*=====  End of get account_id against barcode  ======*/
  //   }
  //   $data['specific_data'] = $this->m_tolist->item_specifics($item_id,$manifest_id,$condition_id);
  //   $data['list_barcode'] = $list_barcode;
  //   $data['bestOfferCheckbox'] = $bestOfferCheckbox;
  //   $this->session->unset_userdata('ebay_item_id');
  //   $this->session->unset_userdata('check_item_id');            
  //   $this->load->view('ebay/trading/04-add-fixed-price-item-merg',$data);
  //   if($this->session->userdata('ebay_item_id'))
  //   {
  //     $status = "ADD";
  //     $result['list_id'] = $this->m_tolist->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id);
  //     //$this->load->view('ebay/trading/getitem');
  //     $this->m_tolist->insert_ebay_url();
  //     $this->load->view('tolist_view/v_post_list',$result);
  //     $this->session->unset_userdata('ebay_item_id');
  //     $this->session->unset_userdata('ebay_item_url');
  //   }
  // }
  else{
    echo"<script>alert('Error! Item not listed');return false;</script>";
  }
}

function list_item_confirm_merg_add_item(){

      // $this->load->model('tolist/m_tolist');


    //$bestOfferCheckbox = @$this->uri->segment(8); 
    $seed_id = $this->input->post('seed_id');
    
    $bestOfferCheckbox = 0;
    //$this->session->set_userdata('shopifyCheckbox', $shopifyCheckbox); // this session is for shopify checkbox value
    if( !empty($seed_id))
    {
      $check_btn = $this->input->post('check_btn');     
      $list_barcode = $this->input->post('list_barcode');
      $shopifyCheckbox = $this->input->post('shopifyCheckbox') ; 
      $revise_ebay_id = $this->input->post('ebay_id');
      $accountId = $this->input->post('accountId');

      $user_id = $this->input->post('user_id');
      $userName = $this->input->post('userName');

      // $userId = $this->input->post('userId');
      // $userName = $this->input->post('userName');


       if(!is_numeric($list_barcode)){
        $list_barcode = '';
        //$account_id = $this->session->userdata('account_type');
      }else{
        /*======================================================
        =            get account_id against barcode            =
        ======================================================*/
        //$account_id = $this->session->userdata('account_type');
              

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
                        $account_id = $accountId;//$this->session->userdata('account_type');
                        //$account_id = $this->session->userdata('account_type');
                        //var_dump("form else of account name: ". $get_acc);
                    }

                    /*=====  End of check if our laptopzone merchant  ======*/
                    
                 }
                 $account_id = $accountId; /// tempray variable assign
            }
        /*=====  End of get account_id against barcode  ======*/
        
            
          }// else is_numeric barcode closing
      if(!is_numeric($revise_ebay_id)){
        $revise_ebay_id = '';
      }
      // var_dump($accountId);
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
      $result['account_name'] = $account_id;// used in configuration.php
     
      $result['shopifyCheckbox'] = $shopifyCheckbox;
      $result['bestOfferCheckbox'] = $bestOfferCheckbox;
      $result['uer_id'] = $user_id;
      $result['userName'] = $userName;


    // var_dump($mpn);exit;
     //$this->load->view('ebay/finding/finditembykeyword',$result);
   //     $this->load->view('ebay/finding/finditemadvance_merg_copy',$result);
   // //     var_dump('asasd');
   // // exit;
   //    //3rd permetr condition
   //    $check = $this->session->userdata('check_item_id');

   //    if($check == true)
   //    {
        
   //      exit;
   //    }else 
      if($check_btn == "add_item"){
        //  $data['account_name'] = $account_id;// used in configuration.php
        // exit;
          // var_dump($account_id);
          // exit;
          $forceRevise = 0;
          $data['seed_data'] = $this->m_react->uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise);
          if(empty($list_barcode)){
            $data['pic_data'] = $this->m_react->uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id);
          }
          $data['specific_data'] = $this->m_react->item_specifics($item_id,$manifest_id,$condition_id);
          $qty = @$data['seed_data'][0]['QUANTITY'];


          $data['list_barcode'] = $list_barcode;
          $data['bestOfferCheckbox'] = $bestOfferCheckbox;
          $data['account_name'] = $account_id;
          $this->session->unset_userdata('ebay_item_id');
          /// api call for listing item
          $this->load->view('ebay/trading/04-add-fixed-price-item-merg',$data);
          if($this->session->userdata('ebay_item_id'))
          { 
            if(@$account_id == 'dfwonline'){
                $account_id = 2;
                //$seller_name = 'dfwonline';
            }elseif(@$account_id == 'techbargains2015'){
                 $account_id = 1;
                 //$account_id = 'techbargains2015';
            }

            $status = "ADD";
            $result['list_id'] = $this->m_react->insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id,$user_id);
            $list_id =$result['list_id'];
            //$this->load->view('ebay/trading/getitem');
            $this->m_react->insert_ebay_url($user_id);
            //List on Shopify Code
            // if($shopifyCheckbox == 1 AND (int)$account_id < 3 AND !empty($account_id)){
            //   $result['shopify_data'] = $this->m_listItemtoShopify->listOnShopify($seed_id, $item_id, $qty); 
            // }

            $list_qry = $this->db->query("SELECT E.EBAY_ITEM_ID, TO_CHAR(E.LIST_DATE, 'YYYY-MM-DD HH24:MI:SS') LIST_DATE, E.LZ_SELLER_ACCT_ID, U.EBAY_URL, E.LIST_QTY, E.LIST_PRICE, TRIM(E.STATUS) STATUS, D.ACCOUNT_NAME FROM EBAY_LIST_MT E, LZ_LISTED_ITEM_URL U , LJ_MERHCANT_ACC_DT D WHERE E.EBAY_ITEM_ID = U.EBAY_ID(+) AND E.LZ_SELLER_ACCT_ID = D.ACCT_ID(+) AND E.LIST_ID = $list_id")->result_array(); 
            $ebay_id = $list_qry[0]['EBAY_ITEM_ID'];
            $list_date = $list_qry[0]['LIST_DATE'];
            //$lz_seller_acct_id = $list_qry[0]['LZ_SELLER_ACCT_ID'];
            $account_type = $list_qry[0]['ACCOUNT_NAME'];
            $ebay_url = $list_qry[0]['EBAY_URL'];
            $list_qty = $list_qry[0]['LIST_QTY'];
            if(@$check_btn == 'revise'){
                $list_qty = 0;
            }
            $list_price = $list_qry[0]['LIST_PRICE'];
            $emp_name = $userName;//$this->session->userdata('employee_name');
            // var_dump($emp_name);
            // exit;
            $status = $list_qry[0]['STATUS'];
            $current_qty = $this->session->userdata('current_qty');
                    echo "<div class='col-sm-12'>
                
                <div id='errorMsgs' >
                    The item is listed on eBay With the Following Details:<br>
                    <ul>
                        
                        <li>Ebay Id: <a href='https://www.ebay.com/itm/".$ebay_id."' target='_blank' >".$ebay_id."</a></li>
                        <li>Ebay Account: ".$account_type."</li>
                        <li>Listed By: " .$emp_name." </li>
                        <li>Timestamp: " .$list_date." </li>
                        <li>List Qty: " .$list_qty." </li>
                        <li>List Price: $ ".$list_price." </li>
                    </ul>
                </div>
               
            </div>";


            // $this->load->view('tolist_view/v_post_list',$result);
            $this->session->unset_userdata('ebay_item_id');
            $this->session->unset_userdata('check_item_id');
          }
      
    }else{
      echo"<script>alert('Error! Item not listed');return false;</script>";
    }
    

    }


}


public function reviseItemPrice(){
  $ebay_id = trim($this->input->post('ebay_id'));
  $price = trim($this->input->post('revise_price'));
  $user_id = trim($this->input->post('user_id'));

  // var_dump($ebay_id,$price,$user_id);
  // exit;
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
  //$data['forceRevise'] = $forceRevise;
  //$this->session->unset_userdata('active_listing');
  $this->load->view('ebay/trading/reviseItemPrice',$data);
  if(!empty($this->session->userdata('ebay_item_id')))
  {
    $status = "REVISED";
    $result['list_id'] = $this->m_tolist->updateReviseStatus($ebay_id,$price,$user_id);
    //$result['check_btn'] = $check_btn;
    //$this->load->view('ebay/trading/getitem');
    //$this->m_tolist->insert_ebay_url();
    //$this->load->view('tolist_view/v_post_list',$result);
    $this->session->unset_userdata('ebay_error');
    $this->session->unset_userdata('ebay_item_id');
    $this->session->unset_userdata('check_item_id');
    //$this->session->unset_userdata('ebay_item_url');
    //break;
    $data = true;
    echo json_encode($data);
    return json_encode($data);
   
  }else{
    die('Unable to Revise an item');
    $data = false;
    echo json_encode($data);
    return json_encode($data);
   // return false;
  }
}

public function pic_log(){

    $data = $this->m_react->pic_log();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function merch_servic_invoice(){

    $data = $this->m_react->merch_servic_invoice();                
        echo json_encode($data);
      return json_encode($data);
  }


  
  public function load_merchant(){

    $data = $this->m_react->load_merchant();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function merch_servic_invoice_barcode(){

    $data = $this->m_react->merch_servic_invoice_barcode();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function generate_invoic(){

    $data = $this->m_react->generate_invoic();                
        echo json_encode($data);
      return json_encode($data);
  } 
  public function merch_generate_invoice(){

    $data = $this->m_react->merch_generate_invoice();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function merch_lot_dash(){

    $data = $this->m_react->merch_lot_dash();                
        echo json_encode($data);
      return json_encode($data);
  } 

  public function merch_lot_detail_view(){

    $data = $this->m_react->merch_lot_detail_view();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function merch_lot_load_detail(){

    $data = $this->m_react->merch_lot_load_detail();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function merchant_sold_items(){

    $data = $this->m_react->merchant_sold_items();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function merch_inproces_items(){

    $data = $this->m_react->merch_inproces_items();                
        echo json_encode($data);
      return json_encode($data);
  }

  public function load_identification_data(){

    $data = $this->m_react->load_identification_data();                
        echo json_encode($data);
      return json_encode($data);
  }
  public function itemDiscard(){

    $data = $this->m_react->itemDiscard();                
        echo json_encode($data);
      return json_encode($data);
  }
  /// get lz webiste functions

  public function ljw_Brands(){

    $data = $this->m_react->ljw_Brands();                
        echo json_encode($data);
        return json_encode($data);
  }
  public function ljw_Series(){

    $data = $this->m_react->ljw_Series();                
        echo json_encode($data);
        return json_encode($data);
  }

  public function ljw_Model(){

    $data = $this->m_react->ljw_Model();                
        echo json_encode($data);
        return json_encode($data);
  }
  public function ljw_Issues(){

    $data = $this->m_react->ljw_Issues();                
        echo json_encode($data);
        return json_encode($data);
  }

  public function get_repairs(){

    $data = $this->m_react->get_repairs();                
        echo json_encode($data);
        return json_encode($data);
  }
  public function ljw_SaveRequest(){

     // $this->load->library('encrypt');
    

  $this->load->library('email');
    // $this->load->library('email');
    // $this->load->library('form_validation');

    $emailNumb = $this->input->post('emailNumb');
    $phoneNumb = $this->input->post('phoneNumb');
    $LastName = $this->input->post('LastName');
    $yourName = $this->input->post('yourName');


    if ($this->input->post('emailNumb')) {

      $data = $this->m_react->ljw_SaveRequest();

      if($data['exist'] == true){
        
        $config['mailtype'] = 'html';
        $config['charset']  = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from('info@laptopzone.us');
        $this->email->to($emailNumb);
        $this->email->subject('Team LaptopZone |  Repair #  '.$data['get_req_id'] . '');
        $this->email->message('<h1>Welcome to our website and Thank You for connecting with LaptopZone. </h1><br>
          <h3>Dear '.$yourName . ',</h3></n><p>LaptopZone is most reliable and authentic electronic sellers, stay connected for easy and quick business. <strong style="color :red"> Your REPAIR # is  ' .$data['get_req_id'] . '</strong>. Thank you for placing an order with us. For more queries and questions please contact us.<br> Click on the link <a href="http://laptopzone.us/pullRequests/'.$data['get_req_id'].'" >http://laptopzone.us/pullRequests/'.$data['get_req_id'].'</a> to follow your request </p></n><h3>Phone # (214) 427-4496</h3></n><h3>Email : info@laptopzone.us</h3></b><h3>Address:</h3></n><p>2720 Royal Ln #180</p></n><p>Dallas, TX 75229</p></n><p>United States</p></n><h3>Best Regard</h3><p>LaptopZone</p>'

);
        //Your repaire id is</h1>' .$data['get_req_id'] . 'we will contact you as soon as posible');


          if ($this->email->send()) {
            echo json_encode(array(
              "create" => true,
              "message" => " Mail successfully send",
              "data" =>$data['get_req_id']
            ));
            // return json_encode(array(
            //   "create" => true,
            //   "message" => " Mail successfully send"
            // ));
          } else {
            print_r($this->email->print_debugger());
            echo json_encode(array(
              "create" => false,
              "message" => "Failed to send email",
              "data" =>$data['get_req_id']
            ));
            // return json_encode(array(
            //   "create" => false,
            //   "message" => "Failed to send email"
            // ));
          }


      }else {
        echo json_encode(array(
          "create" => false,
          "message" => "Request Not Generated"
        ));
        // return array('status' => false, 'message' => 'User Name Not Exist');
      }


    }      

  }


  //   public function resetpassord()
  // {
  //   $this->load->library('encrypt');
  //   $this->load->library('email');
  //   $this->load->library('form_validation');

  //   if ($this->input->post('username')) {

  //     $totaken = date("d/m/Y h:i:s");
  //     $username = $this->input->post('username');
  //     $tempuser = $this->encrypt->encode($username);
  //     $tempToken = $this->encrypt->encode($totaken);
  //     // print_r($tempuser);
  //     // echo "<br>";
  //     // print_r($this->encrypt->decode($tempuser));
  //     // exit();
  //     $data = $this->m_sigInUp->Resetpassord();
  //     // var_dump($data); exit;
  //     if ($data == true) {

  //       $config['mailtype'] = 'html';
  //       $config['charset']  = 'iso-8859-1';
  //       $config['wordwrap'] = TRUE;
  //       $this->email->initialize($config);
  //       $this->email->from('tayyabchohan7@gmail.com');
  //       $this->email->to($username);
  //       $this->email->subject('Reset Password');
  //       $this->email->message("<a href='http://localhost:3000/resetPassword/~" . $tempuser . "~/~" . $tempToken . "~' target='_blank' >Click here to Reset Password</a>");

  //       if ($this->email->send()) {
  //         echo json_encode(array(
  //           "create" => true,
  //           "message" => " Mail successfully send"
  //         ));
  //         return json_encode(array(
  //           "create" => true,
  //           "message" => " Mail successfully send"
  //         ));
  //       } else {
  //         print_r($this->email->print_debugger());
  //         echo json_encode(array(
  //           "create" => false,
  //           "message" => "Failed to send email"
  //         ));
  //         return json_encode(array(
  //           "create" => false,
  //           "message" => "Failed to send email"
  //         ));
  //       }
  //     } else {
  //       echo json_encode(array(
  //         "create" => false,
  //         "message" => "User Name Not Exist"
  //       ));
  //       // return array('status' => false, 'message' => 'User Name Not Exist');
  //     }
  //   }
  // }
  public function saveOptionData(){

     $data = $this->m_react->saveOptionData();                
        echo json_encode($data);
        return json_encode($data);

  }
  
} 