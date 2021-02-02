<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_biddingItems extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        // $this->load->model("bigData/m_recog_title_mpn_kits");
        /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/    
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
  }
  public function index()
    {
        $result['data'] = $this->m_biddingItems->categorySummary();
        // var_dump($result);exit;
        $result['pageTitle'] = 'Category Wise Summary';
        $this->load->view('biddingItems/v_biddingItems', $result);
    }
    public function kitComponents()
    {
        $result['pageTitle']          = 'Kit Components';
        $result['data']               = $this->m_biddingItems->kitComponents();
        $result['getAllObjects']      = $this->m_recog_title_mpn_kits->getAllObjects();  
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        $this->load->view('biddingItems/v_kit_components_view', $result);
    }
    public function get_brands()
    {
        $data                         = $this->m_biddingItems->get_brands(); 
        echo json_encode($data);
        return json_encode($data);
    } 
    public function get_mpns()
    {
        $data                         = $this->m_biddingItems->get_mpns(); 
        echo json_encode($data);
        return json_encode($data);
    }
    public function savekitComponents()
    {
         $data = $this->m_biddingItems->savekitComponents();
            echo json_encode($data);
            return json_encode($data); 
    }
    
    public function saveTrackingNo()
    {
        $data = $this->m_biddingItems->saveTrackingNo();
        echo json_encode($data);
        return json_encode($data);
    }
    public function updateTrackingNo()
    {
        $data = $this->m_biddingItems->updateTrackingNo();
        echo json_encode($data);
        return json_encode($data);
    }
    public function cp_delete_component()
    {
        $cat_id = $this->uri->segment(4);
        $mpn_id = $this->uri->segment(5);
        $cata_id = $this->uri->segment(6);
        $data = $this->m_biddingItems->cp_delete_component();
        if($data==1){
              $this->session->set_flashdata('success', "Component deleted Successfully!"); 
            }elseif($data==0) {
              $this->session->set_flashdata('error',"Component deletion failed!");
            }elseif($data== 2){
                $this->session->set_flashdata('warning', "Error: This Component is present in another estimate");
            }
            redirect(base_url()."biddingItems/c_biddingItems/kitComponents/".$cat_id."/".$mpn_id."/".$cata_id);  
    }




//********************************************************************************************************************

//********************************************************************************************************************
    public function mpnDetail()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $catalogue_id = $this->uri->segment(5);

        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown($result['cat_id']);
        $result['data'] = $this->m_biddingItems->mpnDetail($result['cat_id'] ,$catalogue_id);
        $result['pageTitle'] = 'Summary Detail';
        $this->load->view('biddingItems/v_biddingItems_detail_vew', $result);

       
    }
     public function resetUnVerifyDropdown(){
        $result['data'] = $this->m_biddingItems->resetUnVerifyDropdown();
        echo json_encode($result['data']);
        return json_encode($result['data']);
    }

    //////////////////////////////////////
    public function mpn_wise_purchasing()
    {
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $result['pageTitle'] = 'Purchase Detail';
        $this->load->view('biddingItems/v_biddingItems_detail_mpn_wise', $result); 
    }
    public function loadMpnWisePurchasing()
    {
        $result['data'] = $this->m_biddingItems->loadMpnWisePurchasing();
        echo json_encode($result['data']);
        return json_encode($result['data']);
    }
      public function search_mpn_wise_purchasing(){
         $multi_data = array(
            'Search_List_type' => '',
            'Search_condition'=>'',
            'Search_seller' => '',
            'serchkeyword' => '',
            'Search_category' => '',
            // "mpn" => $mpn,
             'fed_one' => '',
             'fed_two' => '',
             'perc_one' => '',
             'perc_two' => '',
           
             'title_sort' => '',
             'time_sort' => ''

      );
        $this->session->set_userdata($multi_data);


        $Search_List_type  = $this->input->post('serc_listing_Type');
        $Search_condition   = $this->input->post('condition'); 
        $Search_seller  = $this->input->post('seller');
        $Search_category = $this->input->post('category');
        $keyword = $this->input->post('search_title');
        $keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
        $keyword = trim(str_replace("'","''", $keyword));
        $str = explode(' ', $keyword);
        $mpn       = strtoupper($this->input->post('mpn'));
        $fed_one   = $this->input->post('fed_one');
        $fed_two   = $this->input->post('fed_two') ;
        $perc_one  = $this->input->post('perc_one');
        $perc_two  = $this->input->post('perc_two');
        

        

        $title_sort =  $this->input->post('title_sort');
        $time_sort =  $this->input->post('time_sort');

        //check vatiables
        if (!empty($Search_List_type)) {
           $check_List_type = $Search_List_type[0];  
        }else {
            $check_List_type = '';
        }
       if (!empty($Search_condition)) {
           $check_val = $Search_condition[0];  
        }else {
            $check_val = '';
        }
        if (!empty($Search_seller)) {
           $check_seller = $Search_seller[0];  
        }else {
            $check_seller = '';
        }
        if (!empty($Search_category)) {
           $check_categ = $Search_category[0];  
        }else {
            $check_categ = '';
        }      
        // array for storing select values in sessions
        $multi_data = array(
            'Search_List_type' => $Search_List_type,
            'Search_condition'=>$Search_condition,
            'Search_seller' => $Search_seller,
            'serchkeyword' => $keyword,
            //'Search_category' => $Search_category,
            // "mpn" => $mpn,
             'fed_one' => $fed_one,
             'fed_two' => $fed_two,
             'perc_one' => $perc_one,
             'perc_two' => $perc_two,
            
             'title_sort' => $title_sort,
             'time_sort' => $time_sort

      );
      $this->session->set_userdata($multi_data);
        $result['pageTitle'] = 'Purchase Detail';
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $this->load->view('biddingItems/v_search_biddingItems_detail_mpn_wise', $result);
            
    }
     public function load_search_mpn_wise_purchsing(){
        $result['data'] = $this->m_biddingItems->load_search_mpn_wise_purchsing();
        echo json_encode($result['data']);
        return json_encode($result['data']);
            
    }
    public function biddingData(){
        $data = $this->m_biddingItems->loadPurchDetail();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function purchasing_detail()
    {
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $result['bidding_counts'] = $this->m_biddingItems->biddingItemsCounts();        
        // $result['bid_data'] = $this->m_biddingItems->loadPurchDetail();
        $result['pageTitle'] = 'Bidding &amp; Select for Purchase Items';
        $this->load->view('biddingItems/v_biddingItems_detail_vew', $result); 
    }
    public function loadPurchDetail()
    {
        $result['data'] = $this->m_biddingItems->loadPurchDetail();
        echo json_encode($result['data']);
        return json_encode($result['data']);
    }
    public function searchPurchDetail(){

        $Search_List_type  = $this->input->post('serc_listing_Type');
        $Search_condition   = $this->input->post('condition'); 
        $Search_seller  = $this->input->post('seller');
        $Search_category = $this->input->post('category');
        $keyword = $this->input->post('search_title');
        $keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
        $keyword = trim(str_replace("'","''", $keyword));
        $str = explode(' ', $keyword);
        $purch_mpn       = strtoupper($this->input->post('purch_mpn'));
        $fed_one   = $this->input->post('fed_one');
        $fed_two   = $this->input->post('fed_two') ;
        $perc_one  = $this->input->post('perc_one');
        $perc_two  = $this->input->post('perc_two') ;
        $kit_one  = $this->input->post('kit_one') ;
        $kit_two  = $this->input->post('kit_two') ;

        $title_sort =  $this->input->post('title_sort');
        $time_sort =  $this->input->post('time_sort');
        $date_range = $this->input->post('date_range');


        $flag = $this->input->post('flag');

        //check vatiables
        if (!empty($Search_List_type)) {
           $check_List_type = $Search_List_type[0];  
        }else {
            $check_List_type = '';
        }
       if (!empty($Search_condition)) {
           $check_val = $Search_condition[0];  
        }else {
            $check_val = '';
        }
        if (!empty($Search_seller)) {
           $check_seller = $Search_seller[0];  
        }else {
            $check_seller = '';
        }
        if (!empty($Search_category)) {
           $check_categ = $Search_category[0];  
        }else {
            $check_categ = '';
        }      
        // array for storing select values in sessions
        $multi_data = array(
            'Search_List_type' => $Search_List_type,
            'Search_condition'=>$Search_condition,
            'Search_seller' => $Search_seller,
            'serchkeyword' => $keyword,
            'Search_category' => $Search_category,
            'purch_mpn' => $purch_mpn,
             'fed_one' => $fed_one,
             'fed_two' => $fed_two,
             'perc_one' => $perc_one,
             'perc_two' => $perc_two,
            'kit_one' => $kit_one,
            'kit_two' => $kit_two,
             'title_sort' => $title_sort,
             'time_sort' => $time_sort,
             'flag' => $flag,
             'date_range' => $date_range

      );

    $rs = explode('-',$date_range);
                $fromdate = @$rs[0];
                $todate = @$rs[1];

                /*===Convert Date in 24-Apr-2016===*/
                $fromdate = date_create(@$rs[0]);
                $todate = date_create(@$rs[1]);

                        
                $from = date_format($fromdate,'d-m-y');
                $to = date_format($todate, 'd-m-y');

                $dates = array('from'  => $from,
                        'to'  => $to,);
                $this->session->set_userdata($dates);

      $this->session->set_userdata($multi_data);
        $result['pageTitle'] = 'Search | Bidding &amp; Select for Purchase Items';
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $result['bidding_counts'] = $this->m_biddingItems->biddingCountsWithFilter($date_range);
        $result['bid_data'] = $this->m_biddingItems->loadSearchPurchDetail();
        $this->load->view('biddingItems/v_search_biddingItems_detail_vew', $result);
            
    }
      /////////////// FOR REDIRECTION AFTER SAVING ESTIMATE /////////////
     public function searchPurchaseDetail(){
        $result['pageTitle'] = 'Search | Bidding &amp; Select for Purchase Items';
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $this->load->view('biddingItems/v_search_biddingItems_detail_vew', $result);
            
    }
    /////////////// FOR REDIRECTION AFTER SAVING ESTIMATE /////////////

    public function loadSearchPurchDetail(){
        $result['data'] = $this->m_biddingItems->loadSearchPurchDetail();
        echo json_encode($result['data']);
        return json_encode($result['data']);
            
    }
  
    public function searchByListType()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $catalogue_id = $this->uri->segment(5);
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown($result['cat_id']);
        $result['data'] = $this->m_biddingItems->mpnDetail($result['cat_id'] ,$catalogue_id);
        $result['pageTitle'] = 'Summary Detail';
        $this->load->view('biddingItems/v_biddingItems_detail_vew', $result);

    
    }

    // ***************
    // ***************
     public function showUnverifiedData()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();        
        $result['brands'] = $this->m_unverified->get_brands($result['cat_id']);
        //$result['master_mpn'] = $this->m_unverified->get_mastermpn($result['cat_id']);
        // echo "<pre>";
        // print_r($result['dataa']);
        // exit;
        $result['cat_descr'] = $this->m_biddingItems->category_name($result['cat_id']);
        //category_name
        $result['pageTitle'] = 'Unverified MPNs';
        $this->load->view('biddingItems/v_unverified_data', $result);
    }
    public function loadData($cat_id=''){
        $data = $this->m_biddingItems->loadData($cat_id);
        echo json_encode($data);
        return json_encode($data);   
    }
     public function searchUnverifyData()
    {
        $Search_List_type  = $this->input->post('serc_listing_Type');
        $Search_condition   = $this->input->post('condition'); 
        $Search_seller  = $this->input->post('seller');

        $keyword = $this->input->post('search_title');
        $keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
        $keyword = trim(str_replace("'","''", $keyword));
        $str = explode(' ', $keyword);

        $fed_one   = $this->input->post('fed_one');
        $fed_two   = $this->input->post('fed_two') ;

        $title_sort =  $this->input->post('title_sort');
        $time_sort =  $this->input->post('time_sort');
        //var_dump($Search_List_type, $Search_condition, $Search_seller,  $title_sort,  $time_sort, $fed_one, $fed_two, $keyword); exit;
        //check vatiables
        if (!empty($Search_List_type)) {
           $check_List_type = $Search_List_type[0];  
        }else {
            $check_List_type = '';
        }
       if (!empty($Search_condition)) {
           $check_val = $Search_condition[0];  
        }else {
            $check_val = '';
        }
        if (!empty($Search_seller)) {
           $check_seller = $Search_seller[0];  
        }else {
            $check_seller = '';
        }      
        // array for storing select values in sessions
        $multi_data = array(
            'unverify_List_type' => $Search_List_type,
            'unverify_condition'=>$Search_condition,
            'unverify_seller' => $Search_seller,
            'unverify_serchkeyword' => $keyword,
             'unverify_fed_one' => $fed_one,
             'unverify_fed_two' => $fed_two,
             'unverify_title_sort' => $title_sort,
             'unverify_time_sort' => $time_sort
            );
        $this->session->set_userdata($multi_data);
        $result['cat_id'] = $this->uri->segment(4);
        //var_dump($result['cat_id']); exit; 
        $result['pageTitle'] = 'Unverify Detail';
        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $result['cat_descr'] = $this->m_biddingItems->category_name($result['cat_id']);
        $result['brands'] = $this->m_unverified->get_brands($result['cat_id']);
        // $result['master_mpn'] = $this->m_unverified->get_mastermpn($result['cat_id']);
        //$result['objects'] = $this->m_unverified->get_objects($result['cat_id']);        
        $this->load->view('biddingItems/v_search_unverify_data', $result);
    }
     function loadSearchData(){
        $result['cat_id'] = $this->uri->segment(4);
        
        $result['data'] = $this->m_biddingItems->loadSearchData($result['cat_id']);
        echo json_encode($result['data']);
        return json_encode($result['data']);
        
    }   
    public function showverifiedData()
    {
        $result['cat_id'] = $this->uri->segment(4);

        $result['dataa'] = $this->m_biddingItems->unVerifyDropdown();
        $result['pageTitle'] = 'Verified MPNs';
        $this->load->view('biddingItems/v_verified_data', $result);
    }
     public function loadverifyData($cat_id=''){
        $result['data'] = $this->m_biddingItems->loadverifyData($cat_id);
        echo json_encode($result['data']);
        return json_encode($result['data']);   
    }


    public function loadverifySearchData($cat_id=''){
        $result['data'] = $this->m_biddingItems->loadverifySearchData($cat_id);
       
        echo json_encode($result['data']);
        return json_encode($result['data']);
            
    }

    public function updateKitComponents()
    {
        $data = $this->m_biddingItems->updateKitComponents();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function updateEstimate(){
        $result['pageTitle']                = 'Kit Components';
        $result['data']                     = $this->m_biddingItems->updateEstimate();
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        $this->load->view('biddingItems/v_kit_components_update', $result);
                  
    }
    public function saveBiddingOffer(){
        $data = $this->m_biddingItems->saveBiddingOffer();
        echo json_encode($data);
        return json_encode($data);
    }
    public function reviseBiddingOffer(){
        $data = $this->m_biddingItems->reviseBiddingOffer();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function changeBiddingStatus(){
        $data = $this->m_biddingItems->changeBiddingStatus();
        echo json_encode($data);
        return json_encode($data);                
    }
    public function saveSoldAmount(){
        $data = $this->m_biddingItems->saveSoldAmount();
        echo json_encode($data);
        return json_encode($data);                        
    }
    public function updateSoldAmount(){
        $data = $this->m_biddingItems->updateSoldAmount();
        echo json_encode($data);
        return json_encode($data);                        
    }
    public function trashResultRow(){
       $data = $this->m_biddingItems->trashResultRow();
       echo json_encode($data);
       return json_encode($data);    
    }
    public function findItem(){

       $data = $this->m_biddingItems->findItem();
       echo json_encode($data);
       return json_encode($data);            
    } 
    public function get_mastermpn(){
       $data = $this->m_biddingItems->get_mastermpn();
       echo json_encode($data);
       return json_encode($data);            
    }
    //Get_mpnUpc
    public function get_MpnUPC(){
       $data = $this->m_biddingItems->get_MpnUPC();
       echo json_encode($data);
       return json_encode($data);            
    }
    //End of Get_MpnUpc
    public function verifyMPN(){
       $data = $this->m_biddingItems->verifyMPN();
       echo json_encode($data);
       return json_encode($data);            
    }

    public function getSellerDescription(){
        $data = $this->m_biddingItems->getSellerDescription();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function updateSellerDescription(){
        $data = $this->m_biddingItems->updateSellerDescription();
        echo json_encode($data);
        return json_encode($data); 
    }    
    public function saveMpn(){
      $data = $this->m_biddingItems->saveMpn();
      echo json_encode($data);
      return json_encode($data);      
    }
    public function get_Objects(){
      $data = $this->m_biddingItems->get_Objects();
      echo json_encode($data);
      return json_encode($data);         
    }    
    public function get_objectWiseMpn(){
      $data = $this->m_biddingItems->get_objectWiseMpn();
      echo json_encode($data);
      return json_encode($data);         
    }
    public function saveAndVerifyMpn(){
      $data = $this->m_biddingItems->saveAndVerifyMpn();
      echo json_encode($data);
      return json_encode($data);      
    }        
}
