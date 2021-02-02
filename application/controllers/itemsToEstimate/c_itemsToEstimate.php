<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_itemsToEstimate extends CI_Controller
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
        $this->load->model('itemsToEstimate/m_itemsToEstimate');
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;
        
        $test = $this->uri->segment (7);
        if(!empty($test)){
            $this->session->set_userdata('user_id',$test);
        }

        /*=====  End of Section lz_bigData db connection block  ======*/    
    if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
        
    }
    public function index(){
        $ebay_id = $this->input->post('serch_ebay_id');

        $this->session->set_userdata('get_ebay_id',$ebay_id);

        //var_dump($tes);
       // / exit;
        // $result['data'] = $this->m_itemsToEstimate->displayAllData();
        $result['estimateReport']   = $this->m_itemsToEstimate->estimateReport();
        $result['markets']          = $this->m_itemsToEstimate->market_place();
        $result['users']            = $this->m_itemsToEstimate->UsersList();
        $result['pageTitle']        = 'Lot Items to Estimate';
        $this->load->view('itemsToEstimate/v_itemsToEstimate', $result);
    } 
    public function lotsReprt(){
        // $tes = $this->input->post('serch_ebay_id');
        // var_dump($tes);
        // exit;
        
        // $result['data'] = $this->m_itemsToEstimate->displayAllData();
        $result['estimateReport']   = $this->m_itemsToEstimate->estimateReport();
         $result['users']            = $this->m_itemsToEstimate->UsersList();
        $result['pageTitle']        = 'Lot Items Report';
        $this->load->view('itemsToEstimate/v_lotEstimateReport', $result);
    }
    public function lotsData(){
        $data = $this->m_itemsToEstimate->displayAllData();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function saveTrackingNo()
    {
        $data = $this->m_itemsToEstimate->saveTrackingNo();
        echo json_encode($data);
        return json_encode($data);
    }
    public function updateTrackingNo()
    {
        $data = $this->m_itemsToEstimate->updateTrackingNo();
        echo json_encode($data);
        return json_encode($data);
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
    public function trashResultRow(){
       $data = $this->m_itemsToEstimate->trashResultRow();
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
    public function fesibility_index(){

    //echo 'test';
    $result['data'] = $this->m_purchasing->fesibility_index();

    // echo "<pre>";
    // print_r ($result['data']);
    // echo "</pre>";
    // exit;
     $this->load->view('catalogueToCash/v_fesibility_index',$result);   
    }


    /*=================================================
    =            update seller description            =
    =================================================*/

    public function updateSellerDescription(){
        $data = $this->m_itemsToEstimate->updateSellerDescription();
        echo json_encode($data);
        return json_encode($data); 
    }

    public function getSellerDescription(){
        $data = $this->m_itemsToEstimate->getSellerDescription();
        echo json_encode($data);
        return json_encode($data); 
    }
    /*=====  End of update seller description  ======*/ 

    public function lotItemDownload(){
       $data = $this->m_itemsToEstimate->lotItemDownload();
       echo json_encode($data);
       return json_encode($data);      
    }
    public function AssignItems(){
        $data = $this->m_itemsToEstimate->AssignItems();
        echo json_encode($data);
        return json_encode($data);   
    }
    public function UnAssignItems(){
        $data = $this->m_itemsToEstimate->UnAssignItems();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function addtokit(){
    $data = $this->m_itemsToEstimate->addtokit();
    echo json_encode($data);
    return json_encode($data);    

    }
    public function addUpcTokit(){
    $data = $this->m_itemsToEstimate->addUpcTokit();
    echo json_encode($data);
    return json_encode($data);    

    }
    public function lotEstimate(){
        $result['pageTitle']            = 'Lot Estimate';
        $result['data']                 = $this->m_itemsToEstimate->lotMasterInfo();
        $result['conditions']           = $this->m_itemsToEstimate->lotEstimate();
        $result['getCategories']        = $this->m_purchasing->getCategories(); 
        $result['shows']             = $this->m_itemsToEstimate->showData(); 
        $result['getAllObjects']        = $this->m_recog_title_mpn_kits->getAllObjects();
        //var_dump($result['conditions']);exit;
        $this->load->view("itemsToEstimate/v_lotEstimate", $result);
    }
    public function saveLotComponents(){
        $data = $this->m_itemsToEstimate->saveLotComponents();
        echo json_encode($data);
        return json_encode($data);         
    }
    //for Saving LotRemarks
    public function saveLotRemarks(){
        $data = $this->m_itemsToEstimate->saveLotRemarks();
        echo json_encode($data);
        return json_encode($data);         
    }
    //end 
    public function addlotToEstimate(){
        $data['result'] = $this->m_itemsToEstimate->addlotToEstimate();
        $data['conditions'] = $this->m_itemsToEstimate->lotEstimate();
        echo json_encode($data);
        return json_encode($data);                 
    }
    public function deleteFromEstimate(){

        $data = $this->m_itemsToEstimate->deleteFromEstimate();
        echo json_encode($data);
        return json_encode($data);          
    }
    public function addCataMpn(){
      $data['result'] = $this->m_itemsToEstimate->addCataMpn();
      $data['conditions'] = $this->m_itemsToEstimate->lotEstimate();
      echo json_encode($data);
      return json_encode($data);
    }
    public function get_brands(){
        $data = $this->m_itemsToEstimate->get_brands();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function getBrandwiseMPN(){
        $data = $this->m_itemsToEstimate->getBrandwiseMPN();
        echo json_encode($data);
        return json_encode($data);        
    }    
    public function get_mpns(){
        $data = $this->m_itemsToEstimate->get_mpns();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function singleUserEstimate(){
        $result['pageTitle'] = 'Search | Lot Items To Estimate';
        $result['estimateReport'] = $this->m_itemsToEstimate->singleUserEstimate();
        $result['data'] = $this->m_itemsToEstimate->displayAllData();
        $result['users'] = $this->m_itemsToEstimate->UsersList();        
        $this->load->view("itemsToEstimate/v_itemsToEstimate", $result);
    }
    public function saveBiddingOffer(){
        $data = $this->m_itemsToEstimate->saveBiddingOffer();
        echo json_encode($data);
        return json_encode($data);
    }
    public function getBiddingOffer(){
        $data = $this->m_itemsToEstimate->getBiddingOffer();
        echo json_encode($data);
        return json_encode($data);         
    }
    public function getTrackingInfo(){
        $data = $this->m_itemsToEstimate->getTrackingInfo();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function getSoldAmount(){
        $data = $this->m_itemsToEstimate->getSoldAmount();
        echo json_encode($data);
        return json_encode($data);        
    }    
    public function reviseBiddingOffer(){
        $data = $this->m_itemsToEstimate->reviseBiddingOffer();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function saveBiddingStatus(){
        $data = $this->m_itemsToEstimate->saveBiddingStatus();
        echo json_encode($data);
        return json_encode($data);           
    }
    public function instantSaveBiddingStatus(){
        $data = $this->m_itemsToEstimate->instantSaveBiddingStatus();
        echo json_encode($data);
        return json_encode($data);           
    }    
    public function fetchMpnImages(){
        $data = $this->m_itemsToEstimate->fetchMpnImages();
        echo json_encode($data);
        return json_encode($data);  
    }
// fETCH Upc on Mpn Change
     public function fetchMpnUPC(){
        $data = $this->m_itemsToEstimate->fetchMpnUPC();
        echo json_encode($data);
        return json_encode($data);  
    } 

    public function uploadImages(){
        $data = $this->m_itemsToEstimate->uploadImages();
        echo json_encode($data);
        return json_encode($data);
    }
    public function fetchObjectOnblurCategory(){
        $data = $this->m_itemsToEstimate->fetchObjectOnblurCategory();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function fetchMPNonClickObject(){
        $data = $this->m_itemsToEstimate->fetchMPNonClickObject();
        echo json_encode($data);
        return json_encode($data);        
    }    
    public function addlotToEstimateCatWise(){
        $data['result'] = $this->m_itemsToEstimate->addlotToEstimateCatWise();
        $data['conditions'] = $this->m_itemsToEstimate->lotEstimate();
        echo json_encode($data);
        return json_encode($data);                 
    }

    public function search_upc()
    {  
        if(!$this->loginmodel->is_logged_in())
        {
          redirect('login/login/');
        }
        else
        {
            $perameter  =  strtoupper(trim($this->input->post('input_upc')));
            $perameter  = trim(str_replace("'","''", $perameter));

            $brnd       = strtoupper(trim($this->input->post('input_brand')));
            $brnd       = trim(str_replace("'","''", $brnd));

            $data       = $this->m_itemsToEstimate->queryData($perameter,$brnd);
            echo json_encode($data);
            return json_encode($data); 
        }    
    }
    public function saveItems(){
        $data = $this->m_itemsToEstimate->saveItems();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function saveMarket(){
        $data = $this->m_itemsToEstimate->saveMarket();
        echo json_encode($data);
        return json_encode($data);        
    }
    public function checkOfferAmount()
    {
        $lot_cata_id  = $this->input->post('lot_cata_id');
        //var_dump($lot_cata_id); exit;
        $data = $this->m_itemsToEstimate->checkOfferAmount();
        echo json_encode($data);
        return json_encode($data);        
    } 
    public function uploadCSV(){   
      $data = $this->m_itemsToEstimate->import_xls_records();
      echo json_encode($data);
      return json_encode($data);  
    }
    public function import_xlsx_file(){   
      $data = $this->m_itemsToEstimate->import_xlsx_file();
      echo json_encode($data);
      return json_encode($data);  
    }
    public function get_avg_sold_price(){
        $catalogue_mt_id = $this->input->post('catalogue_mt_id');
        $get_kw = $this->db2->query("SELECT * FROM (SELECT U.KEYWORD FROM LZ_BD_RSS_FEED_URL U WHERE U.CATLALOGUE_MT_ID =$catalogue_mt_id ORDER BY U.FEED_URL_ID DESC) WHERE ROWNUM=1")->result_array();
        $MPN = $this->input->post('mpn');
        $MPN = trim(str_replace("  ", ' ', $MPN));
        $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('category_id');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));  
        $CONDITION = $this->input->post('condition_id');
        
        if(count($get_kw)>0)
        {
            $data['key']=$get_kw[0]['KEYWORD'];  
        }elseif(!empty($MPN)){
            $data['key']=$MPN;
        }else{
            return 'EXCEPTION';
        }
        $data['condition']=$CONDITION;
        $data['category']=$CATEGORY;
        $data['multicond']=false;
        $data['result'] = $this->load->view('API/get_item_sold_price', $data);
        return $data['result'];
    }

     public function get_avg_sold(){
        $get_keyword = $this->input->post('get_keyword');
        // $get_kw = $this->db2->query("SELECT * FROM (SELECT U.KEYWORD FROM LZ_BD_RSS_FEED_URL U WHERE upper(U.Keyword) like upper('%$get_keyword%') ORDER BY U.FEED_URL_ID DESC) WHERE ROWNUM=1")->result_array();

        // $MPN = $this->input->post('mpn');
        // $MPN = trim(str_replace("  ", ' ', $MPN));
        // $MPN = trim(str_replace(array("'"), "''", $MPN));
        $CATEGORY = $this->input->post('category_id');
        $CATEGORY = trim(str_replace("  ", ' ', $CATEGORY));
        $CATEGORY = trim(str_replace(array("'"), "''", $CATEGORY));  
        $CONDITION = 3000; //$this->input->post('condition_id');
        
        // if(count($get_kw)>0)
        // {
        //     $data['key']=$get_kw[0]['KEYWORD'];  
        // }else{
        //     return 'EXCEPTION';
        // }
        $data['key'] = $get_keyword;
        $data['condition']=$CONDITION;
        $data['category']=$CATEGORY;
        $data['multicond']=false;
        $data['result'] = $this->load->view('API/get_item_sold_price', $data);
        return $data['result'];
    }
}
