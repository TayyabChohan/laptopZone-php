<?php 

    class Lister_Screen extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        if(!$this->loginmodel->is_logged_in())
         {
           redirect('login/login/');
         }         
    }

    public function index(){ 
    $this->session->unset_userdata('u_id');

    $status = $this->session->userdata('login_status');
    $login_id = $this->session->userdata('user_id');
    if(@$login_id && @$status == TRUE)
    {  

    $data['lister'] = $this->lister_model->ListerUsers();
    $data['searching_data'] = ["submit"=>'', "lister_radio"=>'', "user_id"=>'', "from"=>'', "to"=>''];
    $data['total_listing'] = $this->lister_model->sum_total_listing();
    $data['pageTitle'] = 'Lister View';
    $this->load->view('lister_view/lister_view', $data);           
    //$this->load->view('lister_view/lister_view');

    }else{
      redirect('login/login/');
    }          

 }
function loadListerData(){
    $data = $this->lister_model->listing_data();
    echo json_encode($data);
    return json_encode($data);

}
    public function search_lister()
    {

        $submit = $this->input->post('Submit');
        $lister_radio = $this->input->post('lister');
        $user_id = $this->input->post('user_id');
        $rslt = $this->input->post('date_range');
        $this->session->set_userdata('date_range', $rslt);
        //var_dump($submit, $lister_radio, $user_id, $rslt); exit;
        $rs = explode('-',$rslt);
        $fromdate = $rs[0];
        $todate = $rs[1];

        /*===Convert Date in 24-Apr-2016===*/
        $fromdate = date_create($rs[0]);
        $todate = date_create($rs[1]);

        $from = date_format($fromdate,'d-m-y');
        $to = date_format($todate, 'd-m-y');
        
        $this->session->set_userdata('u_id', $user_id);

          if ($submit)
          {
            if ($lister_radio){
                $data['lister'] = $this->lister_model->ListerUsers();
                $data['searching_data'] = ["submit"=>$submit, "lister_radio"=>$lister_radio, "user_id"=>$user_id,"from"=>$from,"to"=>$to];
                $data['total_listing'] = $this->lister_model->radio_lister($lister_radio, $user_id,$from,$to);
                //var_dump($data['listing_data']);exit;
                //$data['total_sale_price'] = $this->lister_model->dataRadio($lister_radio);

                $data['pageTitle'] = 'Lister Search Results';
                $this->load->view('lister_view/lister_view', $data);
            }else{
                    echo "Please Select either radio button on input Search text";
            }
   
        }        
    }
    function loadSearchListerData(){
        $lister_radio   = $this->input->post('lister_radio_button');
        $user_id        = $this->input->post('lz_user_id');
        $from           = $this->input->post('from_val');
        $to             = $this->input->post('to_val');
         //var_dump($lister_radio, $user_id, $from, $to); exit;

        $data = $this->lister_model->search_lister($lister_radio,$user_id,$from,$to);
        echo json_encode($data);
        return json_encode($data);

}
  
}


?>