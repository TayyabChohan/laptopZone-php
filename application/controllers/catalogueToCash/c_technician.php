<?php

class c_technician extends CI_Controller{
	public function __construct(){
	      parent::__construct();
	      $this->load->database();
        $this->load->model('catalogueToCash/m_technician');
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
	     // $this->load->model('manifest_loading/csv_model');
  	}

  	public function index(){
  		$result['pageTitle'] = 'Technician';
      $this->load->view('catalogueToCash/v_dekit_data', $result);
  	}

    public function estim_data(){
      $result ['data']= $this->m_technician->estim_data(); 
      
      $result ['lists']= $this->m_technician->lists();
      $result['getAllObjects'] = $this->m_technician->getAllObjects(); 

       
     $result['pageTitle'] = 'Technician Kit Estimate';
     $this->load->view('catalogueToCash/v_technician',$result);
      // echo json_encode($data);
      // return json_encode($data);

    }
//add insto item_estimate_mt or detail
      public function add_estim_data(){
        if($this->input->post('post')){
        $result ['data']= $this->m_technician->tech_estim_add_data();
      // $data= $this->m_technician->tech_estim_add_data();
      // $lz_manifest_id = $data[0]['LZ_MANIFEST_ID'];
      
      // $action = "post";
      // $this->m_manf_load->manf_post($lz_manifest_id,$action);
      $result['pageTitle'] = 'Save Kit Estimate Technician';
      $this->load->view('catalogueToCash/v_technician',$result);
      }
      // echo json_encode($data);
      // return json_encode($data);
    }


  	public function tech_data(){
  		$data= $this->m_technician->tech_data();
  		echo json_encode($data);
      return json_encode($data);
  	}
    public function dekitManifestPosting(){
      $data = $this->m_technician->dekitManifestPosting();
      //var_dump($data); exit;
      echo json_encode($data);
      return json_encode($data);
    }
    public function delete_kit_comp(){
      $data = $this->m_technician->delete_kit_comp();
      echo json_encode($data);
      return json_encode($data);
    }
    ///////////////////new part of lot management//////////////
    public function savekitComponents()
    {
       $data = $this->m_technician->savekitComponents();
        echo json_encode($data);
        return json_encode($data); 
    }
    public function get_brands()
    {
        $data   = $this->m_technician->get_brands(); 
        echo json_encode($data);
        return json_encode($data);
    }
    public function get_mpns()
    {
        $data   = $this->m_technician->get_mpns(); 
        echo json_encode($data);
        return json_encode($data);
    }
    public function getMpnObjects(){
      $data = $this->m_technician->getMpnObjects();
      echo json_encode($data);
      return json_encode($data);        
    }
    public function addKitComponent(){
        $data['saveMpn'] = $this->m_technician->addKitComponent();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
  }
  public function updateKitComponent(){
        $data['saveMpn'] = $this->m_technician->updateKitComponent();
        echo json_encode($data['saveMpn']);
        return json_encode($data['saveMpn']);
  }
  public function createAutoKit(){
    $data = $this->m_technician->createAutoKit();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function get_cond_base_price(){
    $data = $this->m_technician->get_cond_base_price();
    echo json_encode($data);
    return json_encode($data);    
  }
  public function search_component(){
    $data = $this->m_technician->search_component();
    echo json_encode($data);
    return json_encode($data);
  } 
  public function addtokit(){
    $data = $this->m_technician->addtokit();
    echo json_encode($data);
    return json_encode($data);
  }
   public function lotViewLoad(){
    $data = $this->m_technician->lotViewLoad();
    echo json_encode($data);
    return json_encode($data);
  }
  public function fetch_object(){
    $result['data'] = $this->m_technician->fetch_object();
    echo json_encode($result['data']);
    return json_encode($result['data']);  
    }
  public function cp_del_component(){
       $data = $this->m_technician->cp_del_component();
       echo json_encode($data);
       return json_encode($data);    
  }
  public function kitComponents()
    {
        $result['pageTitle']          = 'Kit Components';
        $result['data']               = $this->m_technician->kitComponents();
        $result['getAllObjects']      = $this->m_technician->getAllObjects();  
        // echo "<pre>";
        // print_r($result['data']);
        // exit;
        $this->load->view('catalogueToCash/v_technician_1', $result);
    }
 }