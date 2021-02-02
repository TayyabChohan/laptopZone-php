<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class c_recog_title_mpn_kits extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->model("bigData/m_recog_title_mpn_kits");
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
        $data['getCategories'] = $this->m_recog_title_mpn_kits->getCategories();
        $data['getObjects'] = $this->m_recog_title_mpn_kits->getObjects();
        $data['getAllObjects'] = $this->m_recog_title_mpn_kits->getAllObjects(); 
        $data['getMpns'] = $this->m_recog_title_mpn_kits->getMpns(); 
        $data['getAltMpns'] = $this->m_recog_title_mpn_kits->getAltMpns();
        $data['getMpnObjectsResult'] = $this->m_recog_title_mpn_kits->getMpnObjectsResult(); 
        $this->load->view('bigdata/v_recog_title_mpn_kits', $data);
    }

  
    public function saveMpn(){
        $data['saveMpn'] = $this->m_recog_title_mpn_kits->saveMpn();
        echo json_encode($data['saveMpn']);
                return json_encode($data['saveMpn']);
    }
    public function saveAlternateMpn(){
        $data['saveMpn'] = $this->m_recog_title_mpn_kits->saveAlternateMpn();
        echo json_encode($data['saveMpn']);
                return json_encode($data['saveMpn']);
    }
    public function checkExp()
    {
      $data = $this->m_recog_title_mpn_kits->checkExp();
      echo json_encode($data);
      return json_encode($data);
    }
    public function verifyExpData($exp_id='')
    {
      //$data['pageTitle'] = 'Recognize MPN Kit';
      $data = $this->m_recog_title_mpn_kits->verifyExpData($exp_id);
      redirect('bigdata/c_recog_title_mpn_kits');
      // echo json_encode($data);
      // return json_encode($data);
    }
    
    public function showCurExpDetail()
    {
      $data = $this->m_recog_title_mpn_kits->showCurExpDetail();
      echo json_encode($data);
      return json_encode($data);
    }    
    public function showExpDetail(){
        $data = $this->m_recog_title_mpn_kits->showExpDetail();
        echo json_encode($data);
        return json_encode($data);    
    }
    public function getSpecificMpn(){
      $data = $this->m_recog_title_mpn_kits->getSpecificMpn();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function displayRelatedExps(){
      $data = $this->m_recog_title_mpn_kits->displayRelatedExps();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function getSpecificObject(){
      $data = $this->m_recog_title_mpn_kits->getSpecificObject();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function getMpnObjects(){
      $data = $this->m_recog_title_mpn_kits->getMpnObjects();
      echo json_encode($data);
      return json_encode($data);        
    } 
    public function getAlternateMpn(){
      $data = $this->m_recog_title_mpn_kits->getAlternateMpn();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function editBdExpView($expId=''){
      $data['exps'] = $this->m_recog_title_mpn_kits->getExpById($expId);
      $this->load->view('bigdata/v_edit_expresion_view', $data);

    }
    public function bdUpdateExpresion(){
      $data = $this->m_recog_title_mpn_kits->bdUpdateExpresion(); 
       echo json_encode($data);
      return json_encode($data);  
    }
    public function deleteBdExpresion($expId=''){
      $data = $this->m_recog_title_mpn_kits->deleteBdExpresion($expId); 
        if($data)
            {
              $this->session->set_flashdata('success', "Expresion Deleted Successfully"); 
            }else {
              $this->session->set_flashdata('error',"Expresion Deletion Failed");
            }         
            redirect(base_url()."bigData/c_recog_title_mpn_kits/");   
    }

  public function deleteMpnObjectResults(){
    $data = $this->m_recog_title_mpn_kits->deleteMpnObjectResults();
    echo json_encode($data);
    return json_encode($data);
  }

  public function getMpnObjectsResult(){
    $data = $this->m_recog_title_mpn_kits->getMpnObjectsResult();
    echo json_encode($data);
    return json_encode($data);
  }

  public function saveMpnKit(){
        $data['saveMpn'] = $this->m_recog_title_mpn_kits->saveMpnKit();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
  }
  public function addKitComponent(){
        $data['saveMpn'] = $this->m_recog_title_mpn_kits->addKitComponent();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
  }

	public function get_altMpn(){
        $data['get_alt_mpn'] = $this->m_recog_title_mpn_kits->get_alt_mpn();

        // var_dump($data['get_alt_mpn']);
        // exit;
        $this->load->view('bigdata/v_del_altmpn', $data);
        
  }
  public function del_altMpn(){
    
        $data['get_alt_mpn'] = $this->m_recog_title_mpn_kits->del_alt_mpn();

        // var_dump($data['get_alt_mpn']);
        // exit;
        $this->load->view('bigdata/v_del_altmpn', $data);
        
  }

  public function deleteResultRow($id){
   $data = $this->m_recog_title_mpn_kits->deleteResultRow($id);
    echo json_encode($data);
    return json_encode($data);    
  }
	
  public function getMpnsEdit(){
    $data['getMpns'] = $this->m_recog_title_mpn_kits->getMpns();
    echo json_encode($data['getMpns']);
    return json_encode($data['getMpns']);
  }

  public function updateMPN(){
    $data['getMpns'] = $this->m_recog_title_mpn_kits->updateMPN();
    echo json_encode($data['getMpns']);
    return json_encode($data['getMpns']);
  }

  public function totalUnverified(){
    $data['cat_id'] = $this->uri->segment(4);
    $data['pageTitle'] = 'Total Unverified Data';
    $this->load->view('bigdata/v_totalUnverified',$data);
  }

  public function unVerifiedLoadData($cat_id=''){
    $result['data'] = $this->m_recog_title_mpn_kits->unVerifiedLoadData($cat_id);
    echo json_encode($result['data']);
    return json_encode($result['data']);
  }

  
  public function deleteUnVerifiedData(){
    $result['data'] = $this->m_recog_title_mpn_kits->deleteUnVerifiedData();
    echo json_encode($result['data']);
    return json_encode($result['data']);
  }

  public function loadBdMpn(){
    $data = $this->m_recog_title_mpn_kits->loadBdMpn();
    echo json_encode($data);
    return json_encode($data);
  }
  public function displayCatalogueMPN(){
    $data = $this->m_recog_title_mpn_kits->displayCatalogueMPN();
    echo json_encode($data);
    return json_encode($data);    
  }
}