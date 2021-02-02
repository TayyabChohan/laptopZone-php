<?php
// defined('BASEPATH') OR exit('No direct script access allowed');
// ini_set('memory_limit', '-1');
class c_kitsCount extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
        $this->load->model("bigData/m_recog_title_mpn_kits");
        $this->load->model("catalogueToCash/m_kitsCount");
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

  public function index(){
    

    // $data['getCategories'] = $this->m_kitsCount->getCategories();
    // $data['getObjects'] = $this->m_kitsCount->getObjects();
    // $data['getAllObjects'] = $this->m_kitsCount->getAllObjects(); 
    // $data['getMpns'] = $this->m_kitsCount->getMpns(); 
    // $data['getAltMpns'] = $this->m_kitsCount->getAltMpns();
    // $data['getMpnObjectsResult'] = $this->m_kitsCount->getMpnObjectsResult();
    // $this->load->view('catalogueToCash/v_kitsCount',$data);
  }

  public function detailView(){


    // $data['getCategories'] = $this->m_kitsCount->getCategories();
    $data['getObjects'] = $this->m_kitsCount->getObjects();
    $data['getAllObjects'] = $this->m_kitsCount->getAllObjects(); 
    // $data['getMpns'] = $this->m_kitsCount->getMpns(); 
    $data['getAltMpns'] = $this->m_kitsCount->getAltMpns();
    $data['getMpnObjectsResult'] = $this->m_kitsCount->getMpnObjectsResult();
    $data['getMpnObjectsResult'] = $this->m_kitsCount->getMpnObjectsResult();
    $data['pageTitle'] = 'Kit Detail';
    $this->load->view('catalogueToCash/v_kitsCount',$data);

  }


 public function getSpecificMpn(){
    $data = $this->m_kitsCount->getSpecificMpn();
    echo json_encode($data);
    return json_encode($data);        
  }

  public function getMpnsEdit(){
    $data['getMpns'] = $this->m_kitsCount->getMpns();
    echo json_encode($data['getMpns']);
    return json_encode($data['getMpns']);
  }

  public function saveMpnKit(){
    $data['saveMpn'] = $this->m_kitsCount->saveMpnKit();
    echo json_encode($data['saveMpn']);
    return json_encode($data['saveMpn']);
  }

  // public function checkExp()
  // {
  //   $data = $this->m_kitsCount->checkExp();
  //   echo json_encode($data);
  //   return json_encode($data);
  // }

  public function deleteMpnObjectResults(){
    $data = $this->m_kitsCount->deleteMpnObjectResults();
    echo json_encode($data);
    return json_encode($data);
  }

  public function loadBdMpn(){
    $data = $this->m_kitsCount->loadBdMpn();
    echo json_encode($data);
    return json_encode($data);
  }

  public function getAlternateMpn(){
    $data = $this->m_kitsCount->getAlternateMpn();
    echo json_encode($data);
    return json_encode($data);        
  }

   public function getMpnObjectsResult(){
    $data = $this->m_kitsCount->getMpnObjectsResult();
    echo json_encode($data);
    return json_encode($data);
  }

  

  public function updateMPN(){
    $data['getMpns'] = $this->m_kitsCount->updateMPN();
    echo json_encode($data['getMpns']);
    return json_encode($data['getMpns']);
  }

  public function getMpnObjects(){
    $data = $this->m_kitsCount->getMpnObjects();
    echo json_encode($data);
    return json_encode($data);        
  }


  public function loadData(){
    $result['data'] = $this->m_kitsCount->loadData();
    echo json_encode($result['data']);
    return json_encode($result['data']);
  }

  public function loadCounts(){
    $data['pageTitle']       = 'Kits Count';
    $data['getCategories']   = $this->m_bd_recognize_data->getCategories();
    $this->load->view('catalogueToCash/v_kit_object_counts',$data);
  }

  public function summary(){
    $data = $this->m_kitsCount->summary();
    echo json_encode($data);
    return json_encode($data);        
  }

}
?>