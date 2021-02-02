<?php 

	class C_Tester_Screen extends CI_Controller
  {
	public function __construct(){
		parent::__construct();
		$this->load->database();
    if(!$this->loginmodel->is_logged_in())
     {
       redirect('login/login/');
     }
	}
 	public function index()
  {
      $result['pageTitle'] = 'Tester Screen';
      $this->load->view('tester_screen/v_tester_result', $result);
  }
  public function search_item()
    {
      if($this->input->post('Submit')){
      $perameter = $this->input->post('bar_code');
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $this->session->set_userdata('scanned_barcode',$perameter);
      $handle = false;
      $result['data'] = $this->m_tester_model->queryData($perameter,$handle);
      $result['pageTitle'] = 'Tester Screen';
      $this->load->view('tester_screen/v_tester_result', $result);
      // $test_view = $this->uri->segment(5);
      // var_dump($test_view);exit;
      }elseif(is_numeric($this->uri->segment(4)))
      {
        $perameter = $this->uri->segment(4);
        $this->session->set_userdata('scanned_barcode',$perameter);
        $handle = true;
        $result['data'] = $this->m_tester_model->queryData($perameter,$handle);
        $result['pageTitle'] = 'Tester Screen';
        $this->load->view('tester_screen/v_tester_result', $result);
      }else{
        redirect('tester/c_tester_screen');
      }
    }
      public function hold_barcode()
    {

      if(is_numeric($this->uri->segment(4)))
      {
        $perameter = $this->uri->segment(4);
        $this->session->set_userdata('scanned_barcode',$perameter);

         $query = $this->db->query("SELECT B.BARCODE_NO FROM LZ_ITEM_SEED S,LZ_BARCODE_MT B WHERE S.ITEM_ID  =B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND  S.DEFAULT_COND = B.CONDITION_ID AND S.SEED_ID = $perameter AND ROWNUM <=1 ")->result_array(); 
         $perameter = $query[0]['BARCODE_NO'];
        $handle = true;
        $result['data'] = $this->m_tester_model->queryData($perameter,$handle);
        $result['pageTitle'] = 'Tester Screen';
        $this->load->view('tester_screen/v_tester_result', $result);
      }else{
        redirect('tester/c_tester_screen');
      }
    
    }
    public function view_test()
    {
      if(is_numeric($this->uri->segment(4))){
        $perameter = $this->uri->segment(4);
        $this->session->set_userdata('scanned_barcode',$perameter);
        $handle = true;
        $result['data'] = $this->m_tester_model->queryData($perameter,$handle);
        $result['pageTitle'] = 'Tester Screen';
        $this->load->view('tester_screen/v_tester_result_view', $result);
      }else{
        redirect('tester/c_tester_screen');
      }
    }
    public function showChecklistDetail(){
      $data = $this->m_tester_model->showChecklistDetail();
      echo json_encode($data);
      return json_encode($data);      
    }
    public function update_cat_id()
    {
      if($this->input->post('submit')){
        $result['data'] = $this->m_tester_model->update_cat_id();
        if($result['data']){
          echo "<script>alert('Item Category updated.');</script>";
          $it_barcode = $this->input->post('it_barcode');
          $result['data'] = $this->m_tester_model->queryData($it_barcode);
          $this->load->view('tester_screen/v_tester_result', $result);
        }
        //$this->load->view('tester_screen/v_tester_result', $result);
      }else{
        echo "from else";
      }
    }
    public function get_single_checklist_test(){
    $data = $this->m_tester_model->get_single_checklist_test();
     echo json_encode($data);
     return json_encode($data);       
    }
  function add_specifics()
  {
    $this->m_tester_model->add_specifics();
  }  
  public function values(){
      $val = $this->input->post('spec_h');
      $val2 = $this->input->post('custom_h');
       $length = count($val);
       $length2 = count($val2);
      //var_dump($length);
        for ($i = 0; $i < $length && $i < $length2; $i++)
        {
          print $val[$i];
          print $val2[$i];
        }
    }
    public function save_item_test(){
     $data = $this->m_tester_model->save_item_test();
     echo json_encode($data);
     return json_encode($data);      
    }
    public function update_item_test(){
     $data = $this->m_tester_model->update_item_test();
     echo json_encode($data);
     return json_encode($data);      
    }
    public function delete_item_test(){
     $result['tested_data'] = $this->m_tester_model->delete_item_test();
     $this->load->view('tester_screen/v_tests_filter_result', $result);
    }
    function search_manifest(){
      if($this->input->post('search_manifest')){
        $result['tested_data'] = $this->m_tester_model->tested_data_results();
        //var_dump(@$result['tested_data']);exit;
        $result['pageTitle'] = 'Tests View';
        $this->load->view('tester_screen/v_tests_list', $result);
      }
      elseif($this->uri->segment(4)){
        $result['tested_data'] = $this->m_tester_model->tested_data_results();        
        $result['pageTitle'] = 'Tests View';
        $this->load->view('tester_screen/v_single_test', $result);
      }
      else{
        //$result['tested_data'] = $this->m_tester_model->tested_data_results();
        $result['pageTitle'] = 'Tests View';
        $this->load->view('tester_screen/v_tests_list', $result);
      }
    }
    public function manifestFilters(){
      if($this->input->post('tested_untested')){
        $result['tested_data'] = $this->m_tester_model->manifestFilters();        
        $result['pageTitle'] = 'Tests View';
        $this->load->view('tester_screen/v_tests_filter_result', $result);
      }else{
        $result['tested_data'] = $this->m_tester_model->manifestFilters();
        $result['pageTitle'] = 'Tests View';
        $this->load->view('tester_screen/v_tests_filter_result', $result);
      }
    }
    function test_edit(){
      $bar_code = $this->uri->segment(4);
      $handle = true;
      $result['data'] = $this->m_tester_model->queryData($perameter,$handle);
      $this->load->view('tester_screen/v_tester_result', $result);
      // }else{
      //   $this->load->view('tester_screen/v_tests_list');
      // }
    }
    function search_barcode(){
      $perameter = $this->input->post('bar_code');
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $data = $this->m_tester_model->search_barcode($perameter);
      echo json_encode($data);
      return json_encode($data);  
    }    
    function load_tested_data()
    {
      $item_id = $this->input->post('item_id');
      $manifest_id = $this->input->post('manifest_id');
      $perameter = $this->input->post('bar_code');
      $perameter = trim(str_replace(" ", '', $perameter));
      $perameter = trim(str_replace(array("'"), "''", $perameter));
      $data = $this->m_tester_model->load_tested_data($item_id, $manifest_id, $perameter);
      echo json_encode($data);
      return json_encode($data);  
     
    }
    function hold_item()
    {
     $data = $this->m_tester_model->hold_item();
     echo json_encode($data);
     return json_encode($data);
    }
    function hold_item_detail()
    {
      $manifest_id = $this->uri->segment(4);
      //var_dump($manifest_id); exit;
      if($manifest_id){
        $result['data'] = $this->m_tester_model->hold_item_detail($manifest_id);
        $result['pageTitle'] = 'Hold Item List ';
        $this->load->view('tester_screen/v_hold_item_detail', $result);        
      }elseif($this->input->post('search_manifest'))
      {
        $manifest_id = null;
        $result['data'] = $this->m_tester_model->hold_item_detail($manifest_id);
        $result['pageTitle'] = 'Hold Item List ';
        $this->load->view('tester_screen/v_hold_item_detail', $result);
      }else
      {
        $result['pageTitle'] = 'Hold Item List ';
        $this->load->view('tester_screen/v_hold_item_detail', $result);
      }
    }
    function un_hold_item()
    {
     $data = $this->m_tester_model->un_hold_item();
     echo json_encode($data);
     return json_encode($data);
    }
    function un_hold_all()
    {
     $data = $this->m_tester_model->un_hold_all();
     echo json_encode($data);
     return json_encode($data); 
    }
    public function holdedUnholdedLog()
    {
      $result['data'] =$this->m_tester_model->holdedUnholdedLog();
      $result['users'] = $this->m_tester_model->UsersList();
      $result['pageTitle'] = 'Hold &amp; Un-hold Item Logs';
      $this->load->view('tester_screen/v_hold_unhold_log', $result);
    }          
}

?>