<?php

class c_categories extends CI_Controller{
  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->model('categories/m_categories');
        $this->load->helper('security');
        //$this->load->model("dekitting_pk_us/m_uspk_listing");
        /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        // //setting the second parameter to TRUE (Boolean) the function will return the database object.
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
    // $this->session->unset_userdata('Search_category');
      $result['categories']   = $this->m_categories->get_categories();
      $result['pageTitle'] = 'Categories Group';
      $this->load->view('categories/v_categories',$result);
  }
 
  // public function GetCategory(){

  //   $cat = $this->input->post('SaveCategory');
  //  $this->session->set_userdata('Search_category',$cat);
  //  $result['pageTitle'] = 'Categories Group';
  //  $result['categories']= $this->m_categories->get_categories();
  //  $this->load->view('categories/v_categories',$result);
  // }

  public function SaveCategory(){
   if($this->input->post('SaveCategory')){
  $result= $this->m_categories->add_categories();
  $this->load->view('categories/v_categories',$result);
     }
   }

   function deleteGroup(){
    $data = $this->m_categories->deleteGroup();
    echo json_encode($data);
    return json_encode($data);
   }
   public function edit_cat_group(){
      $data = $this->m_categories->edit_cat_group();
      echo json_encode($data);
      return json_encode($data);
    } 

public function update_cat_group(){
        $data = $this->m_categories->update_cat_group();
        echo json_encode($data);
        return json_encode($data); 
    }


}