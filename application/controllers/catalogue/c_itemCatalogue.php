<?php 

	class C_itemCatalogue extends CI_Controller{

		public function __construct(){
		parent::__construct();
		$this->load->database();
    /*=============================================
    =  Section lz_bigData db connection block  =
    =============================================*/
    $CI = &get_instance();
    //setting the second parameter to TRUE (Boolean) the function will return the database object.
    $this->db2 = $CI->load->database('bigData', TRUE);
    /*=====  End of Section lz_bigData db connection block  ======*/
    if(!$this->loginmodel->is_logged_in())
     {
       redirect('login/login/');
     }    
	}

 		public function index(){

     $data['pageTitle']       = 'Item Catalogue';
     $data['getCategories']   = $this->m_bd_recognize_data->getCategories(); 
     // $data['record'] = $this->m_itemCatalogue->getSpecificObjects();    
     $this->load->view('catalogue/v_itemCatalogue', $data);     

 }
public function add_mpn($catId = '', $bd_mpn = ''){

     $data['pageTitle']       = 'Add MPN';
     $data['catId']           =  trim($catId);
     $data['bd_mpn']          =  trim($bd_mpn);
     //var_dump($data['catId'], $data['bd_mpn']); exit;
      //$set_mpn = array('bd_category'=>$data['catId'], 'master_mpn'  => $data['bd_mpn']);

   // $this->session->set_userdata($set_mpn);
     $data['getCategories']   = $this->m_bd_recognize_data->getCategories();    
     $this->load->view('catalogue/v_itemCatalogue', $data);     

 }
    public function getCategorySpecifics($catId = '', $bd_mpn_id = '')
    {
      if($this->input->post('bd_submit')){

      $mastermpn                  = $this->input->post('master_mpn');
      $bd_category                  = $this->input->post('bd_category');

      $set_mpn                    = array('master_mpn'  => $mastermpn);

      $this->session->set_userdata($set_mpn);

      $data['data']               = $this->m_itemCatalogue->getCategorySpecifics();
      $data['getCategories']      = $this->m_bd_recognize_data->getCategories();
      $data['master_mpn']         = $this->m_itemCatalogue->get_mastermpn($bd_category);
      
      $perameter                  = $this->input->post('bd_category');
      $data['record']             = $this->m_itemCatalogue->getSpecificObjects($bd_category);
      $data['spec_name']          = $this->m_item_specifics->itemCategorySpecifics($perameter); 
      
      //var_dump($datas['data']['specs_qry']);exit;
      $data['pageTitle']          = 'Item Catalogue'; 
      $this->load->view('catalogue/v_itemCatalogue', $data);      
      }else{
         $data['catId']           =  trim($catId);
         $data['bd_mpn_id']       =  trim($bd_mpn_id);
         $get_mpn                 = $this->m_itemCatalogue->specific_mpn($bd_mpn_id);
         if (!empty($get_mpn)) {
           $data['bd_mpn']        = $get_mpn[0]['MPN'];
         }else {
           $data['bd_mpn']        = '';
         }
         //var_dump(  $data['catId'], $mastermpn); exit;
          $set_mpn                = array('bd_category'=>$data['catId'], 'master_mpn'  => $data['bd_mpn']);

          $this->session->set_userdata($set_mpn);

          $data['data']           = $this->m_itemCatalogue->getCategorySpecifics($data['catId']);
          $data['getCategories']  = $this->m_bd_recognize_data->getCategories();
          $data['master_mpn']     = $this->m_itemCatalogue->get_mastermpn();
          $data['record']         = $this->m_itemCatalogue->getSpecificObjects($data['catId']);

          $data['spec_name']      = $this->m_item_specifics->itemCategorySpecifics($data['catId']); 
          
          //var_dump($datas['data']['specs_qry']);exit;
          $data['pageTitle']      = 'Item Catalogue'; 
          $this->load->view('catalogue/v_itemCatalogue', $data);
            //return redirect('catalogue/c_itemCatalogue');
      }
    }
    public function getItemSpecificsValues(){

      $data = $this->m_itemCatalogue->getItemSpecificsValues();
      echo json_encode($data);
      return json_encode($data); 

    }

    public function createObject(){
      $data = $this->m_itemCatalogue->createObject();
      echo json_encode($data);
      return json_encode($data);
    }
    public function updateObjectID(){
      $data = $this->m_itemCatalogue->updateObjectID();
      echo json_encode($data);
      return json_encode($data);
    }

    public function getSpecificObjects(){
      $bd_category = $this->input->post('bd_category');
      $data = $this->m_itemCatalogue->getSpecificObjects($bd_category);
      echo json_encode($data);
      return json_encode($data);
    }

    public function getObjectsForEdit(){
      $data = $this->m_itemCatalogue->getSpecificObjects();
      echo json_encode($data);
      return json_encode($data);
    }

    public function updateObjectEdit(){
      
      $data = $this->m_itemCatalogue->updateObjectEdit();
      echo json_encode($data);
      return json_encode($data);
    }

    public function itemCategorySpecifics(){
      
      $perameter = $this->uri->segment(4);
    
      $perameter = trim(str_replace(" ", ' ', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $result['data'] = $this->m_itemCatalogue->itemCategorySpecifics($perameter);
      
      //var_dump($results['data']['specs_qry']);exit;
      $result['pageTitle'] = 'Item Category Specifics'; 
      $this->load->view('catalogue/v_itemCatalogue', $result);      
    }
    public function addCatalogueGroupName(){
      $catalogueGroupName = $this->input->post('catalogueGroupName');
      $catalogueGroupName = trim(str_replace("  ", ' ', $catalogueGroupName));
      $catalogueGroupName = trim(str_replace(array("'"), "''", $catalogueGroupName));
      $data = $this->m_itemCatalogue->addCatalogueGroupName($catalogueGroupName);
      echo json_encode($data);
      return json_encode($data);            
    }
    public function addCatalogue(){

      $data = $this->m_itemCatalogue->addCatalogue();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function addCustomSpecsforCatalog(){ 
    
      $data = $this->m_itemCatalogue->addCustomSpecsforCatalog();
      echo json_encode($data);
      return json_encode($data); 
    }    

    public function catalogueDetail(){
      $data = $this->m_itemCatalogue->catalogueDetail();
      echo json_encode($data);
      return json_encode($data);
     
    }

    public function getGroupName(){
      $data = $this->m_itemCatalogue->getGroupName();
      echo json_encode($data);
      return json_encode($data);
    }

    public function alternateValue(){
      // $result['pageTitle'] = 'Alternate Value';
      $result = $this->m_itemCatalogue->alternateValue();
      echo json_encode($result);
      return json_encode($result);
    }

    public function re_getCategorySpecifics(){
      $data = $this->m_itemCatalogue->getCategorySpecifics();
      echo json_encode($data);
      return json_encode($data);
    }

    public function catalogueListView(){
        
      $data['pageTitle'] = 'Catalogue Detail List';
      $data['getCategories'] = $this->m_bd_recognize_data->getCategories();
      $this->load->view('catalogue/v_catalogueList',$data);
    }

    public function loadData(){
        $result['data'] = $this->m_itemCatalogue->loadData();
        echo json_encode($result['data']);
        return json_encode($result['data']);
    }

    // public function deleteCatalogue(){
    //   $cat_mt_id = $this->uri->segment(4);
    //   $this->m_itemCatalogue->deleteCatalogue($cat_mt_id);
    //   redirect('catalogue/c_itemCatalogue/catalogueListView','refresh');
    // }

    public function deleteCatalogue(){
      
      $result['data'] = $this->m_itemCatalogue->deleteCatalogue();
      echo json_encode($result['data']);
      return json_encode($result['data']);

    }

    public function editCatalogue(){
      //$cat_mt_id = $this->uri->segment(4);
      // $result['data'] = $this->m_itemCatalogue->editCatalogue($cat_mt_id);
      $result['data'] = $this->m_itemCatalogue->getCategorySpecificsEdit();
      // $result['getCategories'] = $this->m_bd_recognize_data->getCategories();
      // $result['detail'] = $this->m_itemCatalogue->showCatalogueDetail();
      $result['pageTitle'] = 'Catalogue Edit Form';
      $this->load->view('catalogue/v_editCatalogue',$result);
      // 
      // echo json_encode($result['data']);
      // return json_encode($result['data']);
      
    }
    public function showCatalogueDetail(){
      // $id = $this->input->post('$id');
      $result['data'] = $this->m_itemCatalogue->showCatalogueDetail();
      echo json_encode($result['data']);
      return json_encode($result['data']);
    }

    public function editData(){
      $result['data'] = $this->m_itemCatalogue->editData();
      echo json_encode($result['data']);
      return json_encode($result['data']);
    }

    public function updateCatalogueDetail(){
      $result['data'] = $this->m_itemCatalogue->updateCatalogueDetail();
      echo json_encode($result['data']);
      return json_encode($result['data']);
    }

    public function deleteCatalogueDetail(){
        $result['data'] = $this->m_itemCatalogue->deleteCatalogueDetail();
        echo json_encode($result['data']);
        return json_encode($result['data']);
     }
    public function saveCustomAttribute(){

      $data = $this->m_itemCatalogue->saveCustomAttribute();
      echo json_encode($data);
      return json_encode($data);       
    }
    public function getCatGroups(){

      $data = $this->m_itemCatalogue->getCatGroups();
      echo json_encode($data);
      return json_encode($data);       
    }     
}

?>