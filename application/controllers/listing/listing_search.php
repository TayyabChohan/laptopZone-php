<?php 

	class Listing_Search extends CI_Controller{

		public function __construct(){
		parent::__construct();
		$this->load->database();
    if(!$this->loginmodel->is_logged_in())
     {
       redirect('login/login/');
     }    
	}
 	public function index(){
    //var_dump('ad');
    //$this->load->view('listing_views/search_view');
    $status = $this->session->userdata('login_status');
    $login_id = $this->session->userdata('user_id');
    if(@$login_id && @$status == TRUE)
    {      


      $submit=$this->input->post('Submit');
      $perameter=  strtoupper(trim($this->input->post('search')));
      
      $perameter = trim(str_replace("'","''", $perameter));
      //var_dump($perameter); exit;
      $seed_radio = $this->input->post('seed');
      $list_radio = $this->input->post('List');
      //echo $submit."-".$perameter."-".$radio;
      //die();
  			if ($submit) 
        {

          if(!empty($perameter) ){
          //   var_dump('1');
          // exit;
            $this->load->model('listing/search_model');
            $data['data'] = $this->search_model->queryData($perameter);
            $data['barcode']=$perameter;
            $data['pageTitle'] = 'Search Item';
            if(isset($data['data']['query'][0]['DEL_DATE'])){
              $this->load->view('listing_views/del_item_search_result', $data);
            }else{
              $this->load->view('listing_views/item_search_result', $data);
            }                   
          }elseif ($seed_radio || $list_radio){
            
            $this->load->model('listing/search_model');
            $data['data'] = $this->search_model->queryRadio($seed_radio,$list_radio);
            $data['pageTitle'] = 'Listing Form';
            $this->load->view('listing_views/search_view', $data);
          }else{
          
            //echo "dfsfsfsfsfff"; exit;
            //echo "Please Select either radio button on input Search text";
            $this->session->set_flashdata('warning',"Please enter valid barcode");
            $this->session->set_flashdata('placeholder',"Please enter barcode");
            $data['pageTitle'] = 'Search Item';
            $this->load->view('listing_views/item_search_view', $data);
          }
          
        }else{
                $this->load->model('listing/listing');
              }
   

    }else{
      redirect('login/login/');
    }          

 }
public function seed_view(){

      $flag =$this->session->userdata('flag');
      if($flag == true){
          $this->session->unset_userdata('flag');
          $seed_radio = "Available";
          $list_radio = "Not Listed";
            
      if ($seed_radio && $list_radio) 
              {
                $barcode = $this->uri->segment(4);
                $this->load->model('listing/search_model');
                $data = $this->search_model->getthisitem($barcode);
                $this->load->view('listing_views/search_view', ['data'=> $data]);
              }else{
                echo "Please Select either radio button on input Search text";
              }

      }else{
              $this->load->model('listing/listing');
              $this->session->unset_userdata('flag');
           }
 }
    public function search_item()
    {

      //$this->load->model('listing/search_model');
       //$data = $this->search_model->queryData($perameter);
      $data['pageTitle'] = 'Search Item';
      $this->load->view('listing_views/item_search_view', $data);
      // $this->load->view('listing_views/search_item');


    }
    public function holdBarcode(){
    $this->load->model('listing/search_model');
    $data = $this->search_model->holdBarcode();
    echo json_encode($data);
    return json_encode($data);    

  }
  public function unHoldBarcode(){
    $this->load->model('listing/search_model');
    $data = $this->search_model->unHoldBarcode();
    echo json_encode($data);
    return json_encode($data);    

  }
  
}


?>