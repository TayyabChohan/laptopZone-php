<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class c_autoCatalog extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        $this->load->model("bigData/m_autoCatalog");
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
        $data['pageTitle'] = 'Recognize MPN Kit';
        $data['getCategories'] = $this->m_autoCatalog->getCategories();
        $data['getObjects'] = $this->m_autoCatalog->getObjects();
        $data['getAllObjects'] = $this->m_autoCatalog->getAllObjects(); 
        $data['getMpns'] = $this->m_autoCatalog->getMpns(); 
        $data['getAltMpns'] = $this->m_autoCatalog->getAltMpns();
        $data['getMpnObjectsResult'] = $this->m_autoCatalog->getMpnObjectsResult(); 
        $data['results'] = $this->m_autoCatalog->getResults();
        $data['objects'] = $this->m_autoCatalog->getResultObjects();
        $data['words'] = $this->m_autoCatalog->getWords();
        // echo "<pre>";
        // print_r($data['objects']);
        // exit; 
        $this->load->view('bigdata/v_autoCatalog', $data);
    }

  
    public function saveMpn(){
        $data['saveMpn'] = $this->m_autoCatalog->saveMpn();
        echo json_encode($data['saveMpn']);
                return json_encode($data['saveMpn']);
    }
    public function saveAlternateMpn(){
        $data['saveMpn'] = $this->m_autoCatalog->saveAlternateMpn();
        echo json_encode($data['saveMpn']);
                return json_encode($data['saveMpn']);
    }
    public function checkExp()
    {
      $data = $this->m_autoCatalog->checkExp();
      echo json_encode($data);
      return json_encode($data);
    }
    public function verifyExpData($exp_id='')
    {
      //$data['pageTitle'] = 'Recognize MPN Kit';
      $data = $this->m_autoCatalog->verifyExpData($exp_id);
      redirect('bigdata/c_autoCatalog');
      // echo json_encode($data);
      // return json_encode($data);
    }
    
    public function showCurExpDetail()
    {
      $data = $this->m_autoCatalog->showCurExpDetail();
      echo json_encode($data);
      return json_encode($data);
    }    
    public function showExpDetail(){
        $data = $this->m_autoCatalog->showExpDetail();
        echo json_encode($data);
        return json_encode($data);    
    }
    public function getSpecificMpn(){
      $data = $this->m_autoCatalog->getSpecificMpn();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function displayRelatedExps(){
      $data = $this->m_autoCatalog->displayRelatedExps();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function getSpecificObject(){
      $data = $this->m_autoCatalog->getSpecificObject();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function getMpnObjects(){
      $data = $this->m_autoCatalog->getMpnObjects();
      echo json_encode($data);
      return json_encode($data);        
    } 
    public function getAlternateMpn(){
      $data = $this->m_autoCatalog->getAlternateMpn();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function editBdExpView($expId=''){
      $data['exps'] = $this->m_autoCatalog->getExpById($expId);
      $this->load->view('bigdata/v_edit_expresion_view', $data);

    }
    public function bdUpdateExpresion(){
      $data = $this->m_autoCatalog->bdUpdateExpresion(); 
       echo json_encode($data);
      return json_encode($data);  
    }
    public function deleteBdExpresion($expId=''){
      $data = $this->m_autoCatalog->deleteBdExpresion($expId); 
        if($data)
            {
              $this->session->set_flashdata('success', "Expresion Deleted Successfully"); 
            }else {
              $this->session->set_flashdata('error',"Expresion Deletion Failed");
            }         
            redirect(base_url()."bigData/c_autoCatalog/");   
    }

  public function deleteMpnObjectResults(){
    $data = $this->m_autoCatalog->deleteMpnObjectResults();
    echo json_encode($data);
    return json_encode($data);
  }

  public function getMpnObjectsResult(){
    $data = $this->m_autoCatalog->getMpnObjectsResult();
    echo json_encode($data);
    return json_encode($data);
  }

  public function saveMpnKit(){
        $data['saveMpn'] = $this->m_autoCatalog->saveMpnKit();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
  }
  public function addKitComponent(){
        $data['saveMpn'] = $this->m_autoCatalog->addKitComponent();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
  }

  public function get_altMpn(){
        $data['get_alt_mpn'] = $this->m_autoCatalog->get_alt_mpn();

        // var_dump($data['get_alt_mpn']);
        // exit;
        $this->load->view('bigdata/v_del_altmpn', $data);
        
  }
  public function del_altMpn(){
    
        $data['get_alt_mpn'] = $this->m_autoCatalog->del_alt_mpn();

        // var_dump($data['get_alt_mpn']);
        // exit;
        $this->load->view('bigdata/v_del_altmpn', $data);
        
  }

  public function deleteResultRow($id){
   $data = $this->m_autoCatalog->deleteResultRow($id);
    echo json_encode($data);
    return json_encode($data);    
  }
  
  public function getMpnsEdit(){
    $data['getMpns'] = $this->m_autoCatalog->getMpns();
    echo json_encode($data['getMpns']);
    return json_encode($data['getMpns']);
  }

  public function updateMPN(){
    $data['getMpns'] = $this->m_autoCatalog->updateMPN();
    echo json_encode($data['getMpns']);
    return json_encode($data['getMpns']);
  }

  public function totalUnverified(){
    $data['cat_id'] = $this->uri->segment(4);
    $data['pageTitle'] = 'Total Unverified Data';
    $this->load->view('bigdata/v_totalUnverified',$data);
  }

  public function unVerifiedLoadData($cat_id=''){
    $result['data'] = $this->m_autoCatalog->unVerifiedLoadData($cat_id);
    echo json_encode($result['data']);
    return json_encode($result['data']);
  }

  
  public function deleteUnVerifiedData(){
    $result['data'] = $this->m_autoCatalog->deleteUnVerifiedData();
    echo json_encode($result['data']);
    return json_encode($result['data']);
  }

  public function loadBdMpn(){
    $data = $this->m_autoCatalog->loadBdMpn();
    echo json_encode($data);
    return json_encode($data);
  }
  public function displayCatalogueMPN(){
    $data = $this->m_autoCatalog->displayCatalogueMPN();
    echo json_encode($data);
    return json_encode($data);    
  }
  public function saveFilterExp(){
    $data = $this->m_autoCatalog->saveFilterExp();
    echo json_encode($data);
    return json_encode($data);        
  }
  public function saveWordExp(){
    $data = $this->m_autoCatalog->saveWordExp();
    echo json_encode($data);
    return json_encode($data);        
  }
  public function getTitles(){
    $data = $this->m_autoCatalog->getTitles();
    echo json_encode($data);
    return json_encode($data);        
  }
  public function addAutoMpn(){
    $data = $this->m_autoCatalog->addAutoMpn();
    echo json_encode($data);
    return json_encode($data);        
  }
  public function delete_auto_mpn(){
    $data = $this->m_autoCatalog->delete_auto_mpn();
    echo json_encode($data);
    return json_encode($data);        
  }
  public function addAutoJunk(){
    $data = $this->m_autoCatalog->addAutoJunk();
    echo json_encode($data);
    return json_encode($data);        
  }
  public function saveCatInSession(){
    $data = $this->m_autoCatalog->saveCatInSession();        
  }
  ///////////////-YOUSAF METHODS /////////////////////////
   public function addCatalogueDetail(){ 

    // $result['detail'] = $this->m_autoCatalog->addCatalogueDetail();
    // $result['pageTitle'] = 'CATALOGUE DETAIL';
    // $this->load->view('bigdata/v_autoCatalogueDetail',$result);

    $data = $this->m_autoCatalog->addCatalogueDetail();
    // var_dump($data);exit;
    echo json_encode($data);

    return json_encode($data);
  }

  public function makeCatalogueDetail(){
    // $cat_id = $this->uri->segment(4);
    // var_dump($cat_id);exit;
    $data = $this->m_autoCatalog->makeCatalogueDetail();
    echo json_encode($data);
    return json_encode($data); 
  }
  public function getSpecificExprs(){
    $data = $this->m_autoCatalog->getSpecificExprs();
    echo "<pre>";
    print_r($data); exit;
    echo json_encode($data);
    return json_encode($data); 

  }
  public function getExprName(){
    $data = $this->m_autoCatalog->getExprName();
    echo json_encode($data);
    return json_encode($data); 
  }
  

  public function specsByCategory(){
    $result['data'] = $this->m_autoCatalog->specsByCategory();
    $result['pageTitle'] = 'Choose Specifics';
    $this->load->view('bigData/v_specificsByCategory',$result);
  }

  public function loadSpecifics(){
    $data = $this->m_autoCatalog->loadSpecifics();
    echo json_encode($data);
    return json_encode($data); 
  }

  public function saveSpecifics(){
    $data = $this->m_autoCatalog->saveSpecifics();
    echo json_encode($data);
    return json_encode($data);
  }

  public function specificsDetailView(){
    $result['data'] = $this->m_autoCatalog->specsByCategory();
    $result['pageTitle'] = 'Alter Specifics';
    $this->load->view('bigdata/v_specificsByCategoryDetail',$result);
  }

  public function loadSpecificsDetail(){
    $data = $this->m_autoCatalog->loadSpecificsDetail();
    echo json_encode($data);
    return json_encode($data);

  }

  public function deleteSpecForCatalogue(){
    $data = $this->m_autoCatalog->deleteSpecForCatalogue();
    echo json_encode($data);
    return json_encode($data);    
  }

  public function updateOneSpec(){
    $data = $this->m_autoCatalog->updateOneSpec();
    echo json_encode($data);
    return json_encode($data);    
  }

 public function deleteAllSpec(){
    $data = $this->m_autoCatalog->deleteAllSpec();
    echo json_encode($data);
    return json_encode($data); 
 }  

}