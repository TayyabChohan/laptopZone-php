<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class C_search_estimate extends CI_Controller
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
        $this->load->model('itemsToEstimate/m_search_estimate');
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
        $result['pageTitle']        = 'Search Estimate';
        $this->load->view('catalogueToCash/v_search_estimate', $result);
    }
    public function searchEstimate(){
        $result['pageTitle']        = 'Search Estimate';
        $result['search_title']     = strtoupper(trim($this->input->post('search_estimate')));
        ///var_dump($result['search_title']); exit;

        if (empty($result['search_title']))
        {
            $this->session->set_flashdata('error', "Search field can't be empty!");
            redirect('itemsToEstimate/c_search_estimate');
        }
        else
        {
            $this->load->view('catalogueToCash/v_load_search_estimate', $result);
        }
    }
    public function lotsData(){
        $data = $this->m_search_estimate->displayAllData();
        echo json_encode($data);
        return json_encode($data);        
    }
}
