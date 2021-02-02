<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');
class c_mpn_date extends CI_Controller
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
        $this->load->model('charts/m_mpn_date');
        /*=====  End of Section lz_bigData db connection block  ======*/
		if(!$this->loginmodel->is_logged_in())
		    {
		      redirect('login/login/');
		    }		
	}
	function index()
	{
		$result['pageTitle'] = 'MPN Summary Data';
		$result['getCategories'] = $this->m_mpn_date->getCategories();
		$this->load->view("charts/v_mpn_date", $result);
	}
 	public function mpn_date_data()
 	{	
 		

	$bd_mpn_date_category = $this->input->post('bd_mpn_date_category');

	$seller_mpn_date_id = $this->input->post('seller_mpn_date_id');


	// var_dump($seller_mpn_date_id);
	// exit;

	$mpn_date_start = $this->input->post('mpn_date_start');
	$mpn_date_end = $this->input->post('mpn_date_end');
	$mpn_date_item_con = $this->input->post('mpn_date_item_con');
	// var_dump($mpn_date_item_con);
	// exit;


if(isset($_POST['mpn_date_store'])) {
$mpn_date_store =$_POST['mpn_date_store'];

}else {
$mpn_date_store ='';

}
if(isset($_POST['mpn_date_Auction'])) {
$mpn_date_Auction =$_POST['mpn_date_Auction'];

}else {
$mpn_date_Auction ='';

}if(isset($_POST['mpb_date_Fixed'])) {
$mpb_date_Fixed =$_POST['mpb_date_Fixed'];

}else {
$mpb_date_Fixed ='';

}
if(isset($_POST['mpn_date_BIN'])) {
$mpn_date_BIN =$_POST['mpn_date_BIN'];

}else {
$mpn_date_BIN ='';

}
if(isset($_POST['mpn_date_Skip'])) {
$mpn_date_Skip =$_POST['mpn_date_Skip'];

}else {
$mpn_date_Skip ='';

}
$mpn_date_sum = $this->input->post('mpn_date_sum');

$newdata=array('seller_mpn_date_id' => $seller_mpn_date_id,
				'bd_mpn_date_category' => $bd_mpn_date_category,
				'mpn_date_store' => $mpn_date_store,
				
				'mpn_date_Auction' => $mpn_date_Auction, 	
				'mpb_date_Fixed' => $mpb_date_Fixed,
				'mpn_date_BIN' => $mpn_date_BIN,
				'mpn_date_start'  => $mpn_date_start,
				'mpn_date_end'  => $mpn_date_end,
				'mpn_date_item_con' => $mpn_date_item_con,
				'mpn_date_Skip' => $mpn_date_Skip,
				'mpn_date_sum' => $mpn_date_sum);

$this->session->set_userdata($newdata);
		// var_dump($newdata);
 	// 	exit;


$rs = explode('-',$mpn_date_sum);
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


	
 		if($this->input->post('bd_mpn_date_submit')){

 			$result['getCategories'] = $this->m_mpn_date->getCategories();
 			$result['get_date_cards_data'] = $this->m_mpn_date->get_date_cards_data();
 			$result['get_date_last_month'] = $this->m_mpn_date->get_date_last_month();
 			
 			// var_dump($result['get_date_cards_data']);
 			// exit;
 			$this->load->view("charts/v_mpn_date", $result);
 		}else{
 			redirect('charts/c_mpn_date');
 		}
		
 	}

 	public function mpn_date_sale_value(){

 		$result['sale_value'] = $this->m_mpn_date->get_date_sale_value();


		print json_encode($result['sale_value']);
 	}

 	public function mpn_date_sale_unit(){

 		$result['sale_value'] = $this->m_mpn_date->get_date_sale_units();


		print json_encode($result['sale_value']);
 	}

 	public function mpn_date_avg_sale(){

 		$result['sale_value'] = $this->m_mpn_date->get_date_avg_sale();


		print json_encode($result['sale_value']);
 	}

 	public function mpn_date_top_seller(){

 		$result['get_top_mpn_seller'] = $this->m_mpn_date->get_data_mpn_seller();

 		// var_dump($result['get_top_mpn_seller'] );
 		// exit;
 		print json_encode($result['get_top_mpn_seller']);

 	}

 	public function mpn_con_wise_salevalue(){

 		$result['con_wise_salevalue'] = $this->m_mpn_date->get_con_wise_salevalue();

 		// var_dump($result['get_top_mpn_seller'] );
 		// exit;
 		print json_encode($result['con_wise_salevalue']);

 	}
 	public function mpn_con_wise_saleunit(){

 		$result['con_wise_saleunit'] = $this->m_mpn_date->get_con_wise_saleunit();

 		// var_dump($result['get_top_mpn_seller'] );
 		// exit;
 		print json_encode($result['con_wise_saleunit']);

 	}
 	public function mpn_day_wise_salevalue(){

 		$result['day_wise_salevalue'] = $this->m_mpn_date->get_day_wise_saleval();

 		// var_dump($result['get_top_mpn_seller'] );
 		// exit;
 		print json_encode($result['day_wise_salevalue']);

 	}
 	public function mpn_day_wise_saleunit(){

 		$result['day_wise_saleunit'] = $this->m_mpn_date->get_day_wise_saleunit();

 		// var_dump($result['get_top_mpn_seller'] );
 		// exit;
 		print json_encode($result['day_wise_saleunit']);

 	}


}