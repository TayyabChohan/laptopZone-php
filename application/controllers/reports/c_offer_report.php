<?php

class c_offer_report extends CI_Controller{
	public function __construct(){
	    parent::__construct();
	    $this->load->database();
	    $this->load->model('reports/m_offer_report');
        $this->load->helper('security');
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
 	public function off_report_load(){
 		$this->session->unset_userdata('offer_category');
    // code for default date selected start
    $from = date('m/d/y', strtotime('-3 months'));// date('m/01/Y');
      // var_dump($from);
      // EXIT;
      $to = date('m/d/y');
      $rslt =$from." - ".$to;
      // var_dump($rslt);
      // exit;
      $this->session->set_userdata('def_end_date', $rslt);
    // code for default date selected end
    $result['pageTitle'] = 'Offer Report';
 		$result['dataa'] = $this->m_offer_report->unVerifyDropdown();
 		$this->load->view('reports/v_offer_report',$result);

 	}
 	public function off_report_query(){ 	
        $offer_category = $this->input->post('offer_category');
        $end_date = $this->input->post('end_date');
        $off_date = $this->input->post('off_date');
        $resdropdown = $this->input->post('resdropdown');
        $emp_id = $this->input->post('emp_id');


      	$await_ship = $this->input->post('await_ship');

        //$radiobuttonvalue = $_POST['radiobuttoname'];
        // var_dump($await_ship);
        // exit;
        // end date conversion
        $rs = explode('-',$end_date);
        $fromdate = @$rs[0];
        $todate = @$rs[1];
        /*===Convert Date in 24-Apr-2016===*/
        $fromdate = date_create(@$rs[0]);
        $todate = date_create(@$rs[1]);
        $from = date_format(@$fromdate,'m/d/y');
        $to = date_format(@$todate, 'm/d/y');
        // offer date conversion
        $off_date = explode('-',$off_date);
        $offdate = @$off_date[0];
        $offtodate = @$off_date[1];
        /*===Convert Date in 24-Apr-2016===*/
        $offdate = date_create(@$off_date[0]);
        $offtodate = date_create(@$off_date[1]);
        $off_from = date_format(@$offdate,'m/d/y');
        $off_to = date_format(@$offtodate, 'm/d/y');

        if(isset($_POST['Skip_offer'])) {
        $Skip_offer =$_POST['Skip_offer'];
        }else {
        $Skip_offer ='';

        }
        if(isset($_POST['Skip_end'])) {
        $Skip_end =$_POST['Skip_end'];
        }else {
        $Skip_end ='';

        }

      	$multi_data = array(
            'offer_category' => $offer_category,
            'end_from'  => $from,
            'end_to'  => $to,
            'off_from' => $off_from,
            'off_to'  => $off_to,     
            'resdropdown'  => $resdropdown,     
            'emp_id'  => $emp_id,     
            'Skip_offer'  => $Skip_offer,     
            'Skip_end'  => $Skip_end,     
            'radiobutton'  => $await_ship,     
      );

      	$this->session->set_userdata($multi_data);
        $result['pageTitle'] = 'Offer Report';
      	$result['dataa'] = $this->m_offer_report->unVerifyDropdown();
 		    $this->load->view('reports/v_offer_report',$result);
 		// var_dump($offer_category);
 		// exit;

 	}
 	public function load_offer_query(){
 		$result['data'] = $this->m_offer_report->load_offer_query();
        echo json_encode($result['data']);
        return json_encode($result['data']);


 	}

  public function load_offer_detail(){
    $result['detail'] = $this->m_offer_report->load_offer_detail();
    // echo '<pre>';
    // print_r($result['detail']);
    // echo '</pre>';
    // exit;

    $this->load->view('reports/v_offer_report_detail',$result);

  }

  public function load_reacvice_repo(){
    $result['pageTitle'] = 'Reacive Report';

    $result['dataa'] = $this->m_offer_report->unVerifyDropdown();
    $this->load->view('reports/v_load_reacive_repo',$result);

  }

  public function load_reacvice(){
    $result['data'] = $this->m_offer_report->load_reacvice_repo();
        echo json_encode($result['data']);
        return json_encode($result['data']);


  }
// post recipt function start
  public function post_receipt(){
    $result['pageTitle'] = 'Post Receipt Report';

    $result['dataa'] = $this->m_offer_report->unVerifyDropdown();
    $this->load->view('reports/v_post_receipt',$result);

  }


   public function crit_post_receipt(){

    $pos_cata = $this->input->post('pos_cata');
    $pos_barc = $this->input->post('pos_barc');
    $item_drop = $this->input->post('item_drop');
    $lot_drop = $this->input->post('lot_drop');
    // dekit date conversion start
    $dek_date = $this->input->post('dek_date');   
      
    if(isset($_POST['Skip_dek_dat'])) {
        $skip_dek_dat =$_POST['Skip_dek_dat'];
        }else {
        $skip_dek_dat ='';
      }
    
    $rs = explode('-',$dek_date);
        $fromdate = @$rs[0];
        $todate = @$rs[1];
        /*===Convert Date in 24-Apr-2016===*/
        $fromdate = date_create(@$rs[0]);
        $todate = date_create(@$rs[1]);
        $dk_from = date_format(@$fromdate,'m/d/y');
        $dk_to = date_format(@$todate, 'm/d/y');
    // dekit date conversion end

    //list date conversion start
    $list_date = $this->input->post('list_date');

    if(isset($_POST['Skip_list_d'])) {
        $Skip_list_d =$_POST['Skip_list_d'];
        }else {
        $Skip_list_d ='';
      }

    $rs_li = explode('-',$list_date);
        $lis_from = @$rs_li[0];
        $lis_to = @$rs_li[1];
        /*===Convert Date in 24-Apr-2016===*/
        $lis_from = date_create(@$rs_li[0]);
        $lis_to = date_create(@$rs_li[1]);
        $lis_from = date_format(@$lis_from,'m/d/y');
        $lis_to = date_format(@$lis_to, 'm/d/y');
    
    //list date conversion end  

    //sold date conversion start
    $sold_date = $this->input->post('sold_date');

    if(isset($_POST['Skip_sold_d'])) {
        $Skip_sold_d =$_POST['Skip_sold_d'];
        }else {
        $Skip_sold_d ='';
      }

    $rs_sol = explode('-',$sold_date);
        $sol_from = @$rs_sol[0];
        $sol_to = @$rs_sol[1];
        /*===Convert Date in 24-Apr-2016===*/
        $sol_from = date_create(@$rs_sol[0]);
        $sol_to = date_create(@$rs_sol[1]);
        $sol_from = date_format(@$sol_from,'m/d/y');
        $sol_to = date_format(@$sol_to, 'm/d/y');
    //sold date conversion end  

    $multi_data = array(
            'pos_cata' => $pos_cata,    
            'pos_barc' => $pos_barc,    
            'item_drop' => $item_drop,    
            'lot_drop' => $lot_drop,    
            'dk_from' => $dk_from,    
            'dk_to' => $dk_to,    
            'skip_dek_date' => $skip_dek_dat,    
            'lis_from' => $lis_from,    
            'lis_to' => $lis_to,
            'Skip_list_d' => $Skip_list_d,  
            'sol_from' => $sol_from,    
            'sol_to' => $sol_to,    
            'Skip_sold_d' => $Skip_sold_d,    
      );

    $this->session->set_userdata($multi_data);

    $result['pageTitle'] = 'Post Receipt Report';
    $result['dataa'] = $this->m_offer_report->unVerifyDropdown();
    $this->load->view('reports/v_post_receipt',$result);

  }

  public function load_post_receipt(){
    $result['data'] = $this->m_offer_report->load_post_receipt();
        echo json_encode($result['data']);
        return json_encode($result['data']);
  }


  // post recipt function end

  public function dekt_barcode_details(){
    $data =  $this->m_offer_report->dekt_barcode_details();
        echo json_encode($data);
      return json_encode($data);

  }


  // method for v_mpn_price view start
  public function mpn_price(){
    $this->session->unset_userdata('search_key');
    $this->session->unset_userdata('mpn_cata');

    $result['dataa'] = $this->m_offer_report->unVerifyDropdown();
    $result['pageTitle'] = 'Search Mpn Price';

    $this->load->view('catalogueToCash/v_mpn_price',$result);

  }

  public function mpn_price_criteria(){

    $search_key = $this->input->post('search_key');
    $exclude_key = $this->input->post('exclude_key');
    $mpn_cata = $this->input->post('mpn_cata');
    $get_obj = $this->input->post('get_obj');
    $get_cond = $this->input->post('get_cond');
    

    $multi_data = array(
            'search_key' => $search_key,
            'exclude_key' => $exclude_key, 
            'mpn_cata' => $mpn_cata, 
            'get_cond' => $get_cond, 
          );
    $this->session->set_userdata($multi_data);

    $result['dataa'] = $this->m_offer_report->unVerifyDropdown();
    $result['data'] = $this->m_offer_report->get_mpn_avg();

    $result['pageTitle'] = 'Search Mpn Price';
    $this->load->view('catalogueToCash/v_mpn_price',$result);

  }
  
  public function load_mpn_price(){
    $data =  $this->m_offer_report->load_mpn_price();
        echo json_encode($data);
      return json_encode($data);

  }

public function mpn_price_update (){
  $get_mpn = $this->input->post('get_mpn');
  $get_desc = $this->input->post('get_desc');
  
  if($this->input->post('varify_mpn')){
  $data_pass = $this->m_offer_report->mpn_price_update();
  $result['dataa'] = $this->m_offer_report->unVerifyDropdown();
  $result['data'] = $this->m_offer_report->get_mpn_avg();
  $this->load->view('catalogueToCash/v_mpn_price',$result);    
  }



  }
  public function save_object (){
  $data =  $this->m_offer_report->save_object();
        echo json_encode($data);
      return json_encode($data);

  }
public function avg_price(){
    $this->session->unset_userdata('search_key');
    $this->session->unset_userdata('mpn_cata');

    $result['dataa'] = $this->m_offer_report->condition_dd();
    $result['pageTitle'] = 'Search Mpn Avg Price';

    $this->load->view('catalogueToCash/v_avg_price',$result);

  }
  public function get_avg_price(){

    $search_key = $this->input->post('search_key');
    $exclude_key = $this->input->post('exclude_key');
    $mpn_cata = $this->input->post('mpn_cata');
    //$get_obj = $this->input->post('get_obj');
    $get_cond = $this->input->post('get_cond');
    $multi_data = array(
            'search_key' => $search_key,
            'exclude_key' => $exclude_key, 
            'mpn_cata' => $mpn_cata, 
            'get_cond' => $get_cond, 
          );
    $this->session->set_userdata($multi_data);

    $result['dataa'] = $this->m_offer_report->condition_dd();
    $result['data'] = $this->m_offer_report->get_avg_price();

    $result['pageTitle'] = 'Search Mpn Avg Price';
    $this->load->view('catalogueToCash/v_avg_price',$result);

  }
  // method for v_mpn_price view end

  public function pic_report(){
    $result['data'] = $this->m_offer_report->pic_report();
    $this->load->view('reports/v_pic_report',$result);
  }
  public function pic_report_detail(){
    $result['data'] = $this->m_offer_report->pic_report_detail();
    $this->load->view('reports/v_pic_report_detail',$result);
  }


 }