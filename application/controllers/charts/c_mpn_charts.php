<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');
class c_mpn_charts extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		 /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        $this->load->model('charts/m_mpn_charts');
        /*=====  End of Section lz_bigData db connection block  ======*/
		if(!$this->loginmodel->is_logged_in())
		    {
		      redirect('login/login/');
		    }		
	}
	function index()
	{
		$result['pageTitle'] = 'MPN Summary Data';
		$result['getCategories'] = $this->m_mpn_charts->getCategories();
		$this->load->view("charts/v_mpn_charts", $result);
	}
 	public function mpnData()
 	{	
// 		$keyword = $this->input->post('bd_search');
	//$seller_id = $this->input->post('seller_mpn_search');
// 		// var_dump($seller_id);
// 		// exit;
	$bd_mpn_category = $this->input->post('bd_mpn_category');

	$seller_mpn_id = $this->input->post('seller_mpn_id');

	$mpn_start = $this->input->post('mpn_start');
	$mpn_end = $this->input->post('mpn_end');
	$mpn_item_con = $this->input->post('mpn_item_con');


if(isset($_POST['mpn_store'])) {
$mpn_store =$_POST['mpn_store'];

}else {
$mpn_store ='';

}
if(isset($_POST['mpn_Auction'])) {
$mpn_Auction =$_POST['mpn_Auction'];

}else {
$mpn_Auction ='';

}if(isset($_POST['mpb_Fixed'])) {
$mpb_Fixed =$_POST['mpb_Fixed'];

}else {
$mpb_Fixed ='';

}
if(isset($_POST['mpn_BIN'])) {
$mpn_BIN =$_POST['mpn_BIN'];

}else {
$mpn_BIN ='';

}
if(isset($_POST['mpn_Skip'])) {
$mpn_Skip =$_POST['mpn_Skip'];

}else {
$mpn_Skip ='';

}
$mpn_date_range = $this->input->post('mpn_date_range');

$newdata=array('seller_mpn_id' => $seller_mpn_id,
				'bd_mpn_category' => $bd_mpn_category,
				'mpn_store' => $mpn_store,
				
				'mpn_Auction' => $mpn_Auction, 	
				'mpb_Fixed' => $mpb_Fixed,
				'mpn_BIN' => $mpn_BIN,
				'mpn_start'  => $mpn_start,
				'mpn_end'  => $mpn_end,
				'mpn_item_con' => $mpn_item_con,
				'mpn_Skip' => $mpn_Skip,
				'mpn_date_range' => $mpn_date_range);

$this->session->set_userdata($newdata);
		// var_dump($newdata);
 	// 	exit;


$rs = explode('-',$mpn_date_range);
		        $fromdate = @$rs[0];
		        $todate = @$rs[1];

		        /*===Convert Date in 24-Apr-2016===*/
		        $fromdate = date_create(@$rs[0]);
		        $todate = date_create(@$rs[1]);

		        $from = date_format(@$fromdate,'m/d/y');
		        $to = date_format(@$todate, 'm/d/y');

		        $dates = array('from'  => $from,
						'to'  => $to,);
		        $this->session->set_userdata($dates);

 		// var_dump($dates);
		 //          exit;
//  		//$rslt = $this->input->post('date_ranges');
// 		 //        $this->session->set_userdata('date_ranges', $rslt);

// 		        $rs = explode('-',$date_ranges);
// 		        $fromdate = @$rs[0];
// 		        $todate = @$rs[1];

// 		        /*===Convert Date in 24-Apr-2016===*/
// 		        $fromdate = date_create(@$rs[0]);
// 		        $todate = date_create(@$rs[1]);

// 		        $from = date_format(@$fromdate,'m/d/y');
// 		        $to = date_format(@$todate, 'm/d/y');

// 		        $dates = array('from'  => $from,
// 						'to'  => $to,);
// 		        $this->session->set_userdata($dates);

// 		         // var_dump($dates);
// 		         // exit;



	

 		if($this->input->post('bd_mpn_submit')){
// 			$result['pageTitle'] = 'Search &amp; Recognize Data';
 			$result['getCategories'] = $this->m_mpn_charts->getCategories();

 			// $result['sale_unit'] = $this->m_mpn_charts->get_sale_units();
 			// var_dump($result['sale_unit']);
 			// exit;
// 			$result['data'] = $this->m_charts->queryData($from,$to);
// 			// var_dump($result['data'] );
// 			// EXIT;
// 			$result['top'] = $this->m_charts->top_ten($from,$to);
			

			
			
// 			$result['total_sales'] = $this->m_charts->get_week_days($from,$to);
// 			// var_dump($result['total_sales']);
// 			// exit;
// 			$result['List_type'] = $this->m_charts->getlist($from,$to);



// 			//var_dump($result['List_type'] );exit;
 			$this->load->view("charts/v_mpn_charts", $result);
 		}else{
 			redirect('charts/c_mpn_charts');
 		}
		
 	}

 	public function mpn_sale_value(){

 		$result['sale_value'] = $this->m_mpn_charts->get_sale_value();


		print json_encode($result['sale_value']);
 	}

 	public function mpn_sale_unit(){

 		$result['sale_value'] = $this->m_mpn_charts->get_sale_units();


		print json_encode($result['sale_value']);
 	}

 	public function mpn_avg_sale(){

 		$result['sale_value'] = $this->m_mpn_charts->get_avg_sale();


		print json_encode($result['sale_value']);
 	}

}