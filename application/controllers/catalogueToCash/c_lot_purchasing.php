<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_lot_purchasing extends CI_Controller
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
        $this->load->model('catalogueToCash/m_lot_Purch');
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/    
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
  }

    public function savekitComponents()
    {
         $data = $this->m_lot_Purch->savekitComponents();
            echo json_encode($data);
            return json_encode($data); 
    }
    public function get_brands()
    {
        $data  = $this->m_lot_Purch->get_brands(); 
        echo json_encode($data);
        return json_encode($data);
    } 

    public function get_all_mpns()
    {
        $data  = $this->m_lot_Purch->get_all_mpns(); 
        echo json_encode($data);
        return json_encode($data);
    } 

    public function addKitComponent(){
        $data['saveMpn'] = $this->m_lot_Purch->addKitComponent();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
    }

    public function kitComponents()
    {
        $result['pageTitle']          = 'Lot Components';
        $result['data']               = $this->m_lot_Purch->kitComponents();
        $result['getAllObjects']      = $this->m_recog_title_mpn_kits->getAllObjects();  
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        $result['brand'] = $this->m_lot_Purch->get_brands();
        // var_dump($result['brand']);
        // exit;
        $this->load->view('catalogueToCash/v_lot_components', $result);
    }

  public function lot_purchasing()
    {
        $this->session->unset_userdata('Search_List_type');
        $this->session->unset_userdata('Search_condition');
        $this->session->unset_userdata('Search_seller');
        $this->session->unset_userdata('serchkeyword');
        $this->session->unset_userdata('purch_mpn');
        $this->session->unset_userdata('Search_category');
        $this->session->unset_userdata('fed_one');
        $this->session->unset_userdata('fed_two');
        $this->session->unset_userdata('perc_one');
        $this->session->unset_userdata('perc_two');
        $this->session->unset_userdata('kit_one');
        $this->session->unset_userdata('kit_two');
        $this->session->unset_userdata('title_sort');
        $this->session->unset_userdata('time_sort');
        $this->session->unset_userdata('flag');

        $result['dataa'] = $this->m_lot_Purch->unVerifyDropdown();
        
    
        $result['pageTitle'] = 'Lot Purchasing';
        $this->load->view('catalogueToCash/v_lot_purchasing', $result);
    }
    public function lot_loadPurch()
    {
        $result['data'] = $this->m_lot_Purch->lot_loadPurch();
        echo json_encode($result['data']);
        return json_encode($result['data']);
    }

    public function lot_search_Purch(){

        $Search_List_type  = $this->input->post('serc_listing_Type');
        // var_dump($Search_List_type);
        // exit;
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
             'flag' => $flag

      );
      $this->session->set_userdata($multi_data);
        $result['pageTitle'] = 'Lot Purchase ';
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $this->load->view('catalogueToCash/v_lot_purchasing', $result);
            
    }
    public function mpnSummary()
    {
        $cat_id = $this->uri->segment(4);
        $result['data'] = $this->m_purchasing->mpnSummary($cat_id);
        // var_dump($result);exit;
        $result['pageTitle'] = 'Mpn Wise Summary';
        $this->load->view('catalogueToCash/v_mpn_wise_summary', $result);
    }
   
     public function getCatalogueSearch()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $result['catalogue_id'] = $this->uri->segment(5);
        $result['data'] = $this->m_purchasing->getCatalogueSearch($result['cat_id'], $result['catalogue_id']);
        $result['pageTitle'] = 'Catalogue';
        $this->load->view('catalogueToCash/v_search_catalogue', $result);
    }
     
     public function loadCatalogues($cat_id='', $catalogue_id = '')
    {
        $result['data'] = $this->m_purchasing->loadCatalogues($cat_id, $catalogue_id);
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        echo json_encode($result['data']);
        return json_encode($result['data']);  
    }
     public function searchCatalogue($cat_id='', $catalogue_id = '')
    {
        $result['data'] = $this->m_purchasing->searchCatalogue($cat_id, $catalogue_id);
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        echo json_encode($result['data']);
        return json_encode($result['data']);
        //var_dump($data);    exit;
        //$this->load->view("bigData/v_bd_createObject", $result);    
    }
  
  

   
    
    public function get_mpns()
    {
        $data  = $this->m_lot_Purch->get_mpns(); 
        echo json_encode($data);
        return json_encode($data);
    }
   
    
    public function saveTrackingNo()
    {
        $data = $this->m_purchasing->saveTrackingNo();
        echo json_encode($data);
        return json_encode($data);
    }
    public function updateTrackingNo()
    {
        $data = $this->m_purchasing->updateTrackingNo();
        echo json_encode($data);
        return json_encode($data);
    }
    public function cp_delete_component()
    {
        $cat_id = $this->uri->segment(4);
        $mpn_id = $this->uri->segment(5);
        $cata_id = $this->uri->segment(6);
        $data = $this->m_purchasing->cp_delete_component();
        if($data==1){
              $this->session->set_flashdata('success', "Component deleted Successfully!"); 
            }elseif($data==0) {
              $this->session->set_flashdata('error',"Component deletion failed!");
            }elseif($data== 2){
                $this->session->set_flashdata('warning', "Error: This Component is present in another estimate");
            }
            redirect(base_url()."catalogueToCash/c_purchasing/kitComponents/".$cat_id."/".$mpn_id."/".$cata_id);  
    }




//********************************************************************************************************************

//********************************************************************************************************************
    public function mpnDetail()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $catalogue_id = $this->uri->segment(5);

        $result['dataa'] = $this->m_purchasing->unVerifyDropdown($result['cat_id']);
        $result['data'] = $this->m_purchasing->mpnDetail($result['cat_id'] ,$catalogue_id);
        $result['pageTitle'] = 'Summary Detail';
        $this->load->view('catalogueToCash/v_purchasing_detail_vew', $result);

       
    }
     public function resetUnVerifyDropdown(){
        $result['data'] = $this->m_purchasing->resetUnVerifyDropdown();
        echo json_encode($result['data']);
        return json_encode($result['data']);
    }

    //////////////////////////////////////
    public function mpn_wise_purchasing()
    {
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $result['pageTitle'] = 'Purchase Detail';
        $this->load->view('catalogueToCash/v_purchasing_detail_mpn_wise', $result); 
    }
    public function loadMpnWisePurchasing()
    {
        $result['data'] = $this->m_purchasing->loadMpnWisePurchasing();
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
        $perc_two  = $this->input->post('perc_two') ;
        

        

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
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $this->load->view('catalogueToCash/v_search_purchasing_detail_mpn_wise', $result);
            
    }
     public function load_search_mpn_wise_purchsing(){
        $result['data'] = $this->m_purchasing->load_search_mpn_wise_purchsing();
        echo json_encode($result['data']);
        return json_encode($result['data']);
            
    }
public function copy_estimate(){
   $result['pageTitle'] = 'Copy Estimate';
   $result['cat_id'] = $this->uri->segment(4);
   $result['mpn_id'] = $this->uri->segment(5);
   $result['cata_id'] = $this->uri->segment(6);
   $result['data'] = $this->m_purchasing->copy_estimate();
   //var_dump($result['cat_id'], $result['mpn_id'], $result['cata_id']); exit; updateEstimate
   $this->load->view('catalogueToCash/v_copy_estimate_view', $result);    

}
    /////////////////////////////////////
     public function purchasing_detail()
    {
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $result['pageTitle'] = 'Purchase Detail';
        $this->load->view('catalogueToCash/v_purchasing_detail_vew', $result); 
    }
    public function loadPurchDetail()
    {
        $result['data'] = $this->m_purchasing->loadPurchDetail();
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
             'flag' => $flag

      );
      $this->session->set_userdata($multi_data);
        $result['pageTitle'] = 'Purchase Detail';
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $this->load->view('catalogueToCash/v_search_purchasing_detail_vew', $result);
            
    }
      /////////////// FOR REDIRECTION AFTER SAVING ESTIMATE /////////////
     public function searchPurchaseDetail(){
        $result['pageTitle'] = 'Purchase Detail';
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $this->load->view('catalogueToCash/v_search_purchasing_detail_vew', $result);
            
    }
    /////////////// FOR REDIRECTION AFTER SAVING ESTIMATE /////////////

    public function loadSearchPurchDetail(){
        $result['data'] = $this->m_purchasing->loadSearchPurchDetail();
        echo json_encode($result['data']);
        return json_encode($result['data']);
            
    }
  
    public function searchByListType()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $catalogue_id = $this->uri->segment(5);
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown($result['cat_id']);
        $result['data'] = $this->m_purchasing->mpnDetail($result['cat_id'] ,$catalogue_id);
        $result['pageTitle'] = 'Summary Detail';
        $this->load->view('catalogueToCash/v_purchasing_detail_vew', $result);

    
    }

    // ***************
    // ***************
     public function showUnverifiedData()
    {
        $result['cat_id'] = $this->uri->segment(4);
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();        
        $result['brands'] = $this->m_unverified->get_brands($result['cat_id']);
        //$result['master_mpn'] = $this->m_unverified->get_mastermpn($result['cat_id']);
        // echo "<pre>";
        // print_r($result['dataa']);
        // exit;
        $result['cat_descr'] = $this->m_purchasing->category_name($result['cat_id']);
        //category_name
        $result['pageTitle'] = 'Unverified MPNs';
        $this->load->view('catalogueToCash/v_unverified_data', $result);
    }
    public function loadData($cat_id=''){
        $data = $this->m_purchasing->loadData($cat_id);
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
        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $result['cat_descr'] = $this->m_purchasing->category_name($result['cat_id']);
        $result['brands'] = $this->m_unverified->get_brands($result['cat_id']);
        // $result['master_mpn'] = $this->m_unverified->get_mastermpn($result['cat_id']);
        //$result['objects'] = $this->m_unverified->get_objects($result['cat_id']);        
        $this->load->view('catalogueToCash/v_search_unverify_data', $result);
    }
     function loadSearchData(){
        $result['cat_id'] = $this->uri->segment(4);
        
        $result['data'] = $this->m_purchasing->loadSearchData($result['cat_id']);
        echo json_encode($result['data']);
        return json_encode($result['data']);
        
    } 

    
     public function showverifiedData()
    {
        $result['cat_id'] = $this->uri->segment(4);

        $result['dataa'] = $this->m_purchasing->unVerifyDropdown();
        $result['pageTitle'] = 'Verified MPNs';
        $this->load->view('catalogueToCash/v_verified_data', $result);
    }
     public function loadverifyData($cat_id=''){
        $result['data'] = $this->m_purchasing->loadverifyData($cat_id);
        echo json_encode($result['data']);
        return json_encode($result['data']);   
    }


public function loadverifySearchData($cat_id=''){
        $result['data'] = $this->m_purchasing->loadverifySearchData($cat_id);
       
        echo json_encode($result['data']);
        return json_encode($result['data']);
            
    }


public function deleteResultRow($id=''){
       $data = $this->m_purchasing->deleteResultRow($id);
       echo json_encode($data);
       return json_encode($data);    
  }
public function trashResultRow(){
       $data = $this->m_purchasing->trashResultRow();
       echo json_encode($data);
       return json_encode($data);    
  }

public function assignCataloguesToKit(){
        $data = $this->m_purchasing->assignCataloguesToKit();
        echo json_encode($data);
        return json_encode($data);    
  }
  public function assignAllCataloguesToKit(){
        $data = $this->m_purchasing->assignAllCataloguesToKit();
        echo json_encode($data);
        return json_encode($data);    
  }
public function updateKitComponents()
{
     $data = $this->m_purchasing->updateKitComponents();
        echo json_encode($data);
        return json_encode($data); 
}
public function updateEstimate(){
        $result['pageTitle']                = 'Kit Components';
        $result['data']                     = $this->m_purchasing->updateEstimate();
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        $this->load->view('catalogueToCash/v_kit_components_update', $result);
              
  }
  public function getEstimateData(){
        $result                 = $this->m_purchasing->getEstimateData();
    
        echo json_encode($result);
        return json_encode($result);
              
  }
public function updateFlag()
{
     $data = $this->m_purchasing->updateFlag();
        echo json_encode($data);
        return json_encode($data); 
}
public function createAutoKit(){
    $data = $this->m_purchasing->createAutoKit();
    echo json_encode($data);
    return json_encode($data);    

}
public function get_cond_base_price(){
    $data = $this->m_purchasing->get_cond_base_price();
    echo json_encode($data);
    return json_encode($data);    

}
public function discard_mpn(){
    $data = $this->m_purchasing->discard_mpn();
    echo json_encode($data);
    return json_encode($data);    

}
public function lot_select(){
    $data = $this->m_purchasing->lot_select();
    echo json_encode($data);
    return json_encode($data);    

}
public function search_component(){
    $data = $this->m_purchasing->search_component();
    echo json_encode($data);
    return json_encode($data);    

} 
public function addtokit(){
    $data = $this->m_purchasing->addtokit();
    echo json_encode($data);
    return json_encode($data);    

}

public function fesibility_index(){

//echo 'test';
$result['data'] = $this->m_purchasing->fesibility_index();

// echo "<pre>";
// print_r ($result['data']);
// echo "</pre>";
// exit;
 $this->load->view('catalogueToCash/v_fesibility_index',$result);   
}


 public function fetch_object()
    {
        $result['data'] = $this->m_purchasing->fetch_object();
        echo json_encode($result['data']);
        return json_encode($result['data']);  
    }
public function appendKitComponent()
    {
        $data = $this->m_purchasing->appendKitComponent();
        echo json_encode($data);
        return json_encode($data);  
    }
public function components_session(){
        $this->m_purchasing->components_session();  
    }

/*=================================================
=            update seller description            =
=================================================*/

public function updateSellerDescription(){
    $data = $this->m_purchasing->updateSellerDescription();
    echo json_encode($data);
    return json_encode($data); 
}


/*=====  End of update seller description  ======*/ 
 
}
