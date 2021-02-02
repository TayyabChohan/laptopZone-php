<?php 

	class C_Item_Specifics extends CI_Controller{

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

    // $status = $this->session->userdata('login_status');
    // $login_id = $this->session->userdata('user_id');
    // if(@$login_id && @$status == TRUE)
    // {
       $data['pageTitle'] = 'Item Specifics';      
       $this->load->view('specifics/v_item_specifics', $data);

    // }else{
    //   redirect('login/login/');
    // }          

 }

    public function search_item()
    {
      if($this->input->post('submit')){
      $perameter = $this->input->post('specific_barcode');
      $this->session->set_userdata('search_barcode', $perameter);
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $result['data'] = $this->m_item_specifics->queryData($perameter);
      
      //var_dump($results['data']['specs_qry']);exit;
      $result['pageTitle'] = 'Item Specifics'; 
      $this->load->view('specifics/v_item_specifics', $result);      

    }else{
      $perameter = $this->uri->segment(4);
    
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $result['data'] = $this->m_item_specifics->queryData($perameter);
      
      //var_dump($results['data']['specs_qry']);exit;
      $result['pageTitle'] = 'Item Specifics'; 
      $this->load->view('specifics/v_item_specifics', $result);
      // $this->load->view('listing_views/search_item');    
      }
    }
/*======================================================================
=            this method call from seed_edit_new to add/update item specific            =
=========================================================================*/
    public function update_seed_spec($item_id)
    {
      $perameter = $item_id;
      $this->session->set_userdata('search_barcode', $perameter);
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $result['data'] = $this->m_item_specifics->queryData($perameter);
      $result['pageTitle'] = 'Item Specifics'; 
      $this->load->view('specifics/v_item_specifics', $result);      
    
    }


/*==  End of this method call from seed_edit_new to add/update item specific  ==*/
    

    public function specific_barcode()
    {
      if($this->input->post('submit')){
        $perameter = $this->input->post('specific_barcode');
        $this->session->set_userdata('spec_barcode', $perameter);
    }else{
      $perameter = $this->uri->segment(4);
    }
      //var_dump($perameter);exit;
      //$perameter = $this->input->post('specific_barcode');
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $result['data'] = $this->m_item_specifics->queryData($perameter);
      
      //var_dump($results['data']['specs_qry']);exit;
      $result['pageTitle'] = 'Add Category Name';
      $this->load->view('specifics/v_custom_category', $result);
      // $this->load->view('listing_views/search_item');


    }    
    public function custom_search_item()
    {

      if($this->uri->segment(4)){
        $perameter = $this->uri->segment(4);
        //var_dump($perameter);exit;
        //$perameter = $this->input->post('bar_code');
        $perameter = trim(str_replace(" ", '', $perameter));
        $perameter = trim(str_replace(array("'"), "''", $perameter));
        $result['data'] = $this->m_item_specifics->queryData($perameter);
        
        //var_dump($results['data']['specs_qry']);exit;
        $result['pageTitle'] = 'Add Custom Attribute & Specifics';
        $this->load->view('specifics/v_custom_attribute', $result);
        // $this->load->view('listing_views/search_item');
      }else{
        $perameter = $this->input->post('bar_code');
        $perameter = trim(str_replace(" ", '', $perameter));
        $perameter = trim(str_replace(array("'"), "''", $perameter));
        $result['data'] = $this->m_item_specifics->queryData($perameter);
        
        //var_dump($results['data']['specs_qry']);exit;
        $result['pageTitle'] = 'Add Custom Attribute & Specifics';
        $this->load->view('specifics/v_custom_attribute', $result);        
      }

    }        
    public function update_cat_id()
    {
      if($this->input->post('submit')){
        
        $result['data'] = $this->m_item_specifics->update_cat_id();
        if($result['data']){
          echo "<script>alert('Item Category updated.');</script>";
          $it_barcode = $this->input->post('it_barcode');
          $it_barcode = trim(str_replace(" ", '', $it_barcode));
          $it_barcode = trim(str_replace(array("'"), "''", $it_barcode));
          $result['data'] = $this->m_item_specifics->queryData($it_barcode);
          $this->load->view('specifics/v_item_specifics', $result);
        }
        //$this->load->view('tester_screen/v_tester_result', $result);
      }else{
        $this->load->view('specifics/v_item_specifics');
      }

    }
  function add_specifics() {
     $data = $this->m_item_specifics->add_specifics();
     echo json_encode($data);
     return json_encode($data);
  }  

    public function values(){


      $val = $this->input->post('spec_h');
      $val2 = $this->input->post('custom_h');

       $length = count($val);
       $length2 = count($val2);
      // //var_dump($length);
        for ($i = 0; $i < $length && $i < $length2; $i++) {
          print $val[$i];
          print $val2[$i];
        }

    }
    public function custom_attribute(){
      $result['pageTitle'] = 'Add Custom Attribute & Specifics';
      $this->load->view('specifics/v_custom_attribute', $result);
    }
    public function attribute_value(){
      // if($this->input->post('save_attr')){
        $cat_id = $this->input->post('cat_id');
        $barcode = $this->input->post('bar_code');
        $item_mpn = $this->input->post('item_mpn');
        $item_upc = $this->input->post('item_upc');
        $spec_name = $this->input->post('spec_name');
        //$spec_name = trim(str_replace("  ", ' ', $spec_name));
        $spec_name = trim(str_replace(array("'"), "''", $spec_name));
        //var_dump($spec_name);exit;
        $custom_attribute = ucfirst($this->input->post('custom_attribute'));
        $custom_attribute = trim(str_replace("  ", ' ', $custom_attribute));
        $custom_attribute = trim(str_replace(array("'"), "''", $custom_attribute));

        $data = $this->m_item_specifics->attribute_value($cat_id, $barcode, $item_mpn, $item_upc, $spec_name, $custom_attribute);
      echo json_encode($data);
      return json_encode($data);               

      // }
    }
    public function custom_specific_name(){ 
   
      $data = $this->m_item_specifics->custom_specifics();
      echo json_encode($data);
      return json_encode($data); 
    }
    public function item_specifics_details(){
     $data = $this->m_item_specifics->item_specifics_details();
     $this->load->view('specifics/v_item_specifics', $data);

    }
    function view_item_specifics(){
      if($this->input->post('search_manifest')){
     $result['data'] = $this->m_item_specifics->view_item_specifics();
     $result['pageTitle'] = 'Item Specifics List View'; 
     // $result['data'];exit;
     $this->load->view('specifics/v_specifics_lists', $result);
     }else{
      $result['pageTitle'] = 'Item Specifics List View'; 
      $this->load->view('specifics/v_specifics_lists', $result);
     }      
    }
    function specific_edit(){
      $perameter = $this->uri->segment(4);
      $this->m_item_specifics->specific_edit($perameter);
    }
    public function itemCategorySpecifics(){
      
      $perameter = $this->uri->segment(4);
    
      $perameter = trim(str_replace(" ", ' ', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $result['data'] = $this->m_item_specifics->itemCategorySpecifics($perameter);
      
      //var_dump($results['data']['specs_qry']);exit;
      $result['pageTitle'] = 'Item Category Specifics'; 
      $this->load->view('specifics/v_itemCategorySpecifics', $result);      
    }
    public function saveCustomAttribute(){

      $data = $this->m_item_specifics->saveCustomAttribute();
      echo json_encode($data);
      return json_encode($data);       
    }
    public function selectedValues(){
    $data = $this->m_item_specifics->selectedValues();
    echo json_encode($data);
    return json_encode($data);
  }

}

?>