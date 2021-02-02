<?php
ini_set('memory_limit', '-1');
defined('BASEPATH') OR exit('No direct script access allowed');
class c_charts extends CI_Controller
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
        $this->load->model('charts/m_charts');
        /*=====  End of Section lz_bigData db connection block  ======*/
		if(!$this->loginmodel->is_logged_in())
		    {
		      redirect('login/login/');
		    }		
	}
	function index()
	{
		$result['pageTitle'] = 'Search &amp; Recognize Data';
		$result['getCategories'] = $this->m_charts->getCategories();
		$this->load->view("charts/v_charts", $result);
	}
	public function queryData()
	{	
		$keyword = $this->input->post('bd_search');
		$seller_id = $this->input->post('seller_search');
		// var_dump($seller_id);
		// exit;
		$category_id = $this->input->post('bd_category');


if(isset($_POST['store'])) {
$store =$_POST['store'];

}else {
$store ='';

}if(isset($_POST['Auction'])) {
$Auction =$_POST['Auction'];

}else {
$Auction ='';

}if(isset($_POST['Fixed'])) {
$Fixed =$_POST['Fixed'];

}else {
$Fixed ='';

}
if(isset($_POST['BIN'])) {
$BIN =$_POST['BIN'];

}else {
$BIN ='';

}
if(isset($_POST['Skip'])) {
$Skip =$_POST['Skip'];

}else {
$Skip ='';

}
		
	
		$end_one = $this->input->post('end_one');
		$end_two = $this->input->post('end_two');
		$date_ranges = $this->input->post('date_ranges');

	

		$item_con = $this->input->post('item_con');






		
		$newdata = array('keyword'  => $keyword,
						'category_id'  => $category_id,
						'end_one'  => $end_one,
						'end_two'  => $end_two,
						'seller_id' => $seller_id,
						'item_con'  => $item_con,
						'store' => $store,
						'Auction' => $Auction,
						'Fixed' => $Fixed,
						'BIN' => $BIN,
						'Skip'=> $Skip);
 		$this->session->set_userdata($newdata);
 		

 		// var_dump($newdata);
 		// exit;



 		
 		//$rslt = $this->input->post('date_ranges');
		 //        $this->session->set_userdata('date_ranges', $rslt);

		        $rs = explode('-',$date_ranges);
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
		         // exit;



	

		if($this->input->post('bd_submit')){
			$result['pageTitle'] = 'Search &amp; Recognize Data';
			$result['getCategories'] = $this->m_charts->getCategories();
			$result['data'] = $this->m_charts->queryData($from,$to);
			// var_dump($result['data'] );
			// EXIT;
			$result['top'] = $this->m_charts->top_ten($from,$to);
			

			
			
			$result['total_sales'] = $this->m_charts->get_week_days($from,$to);
			// var_dump($result['total_sales']);
			// exit;
			$result['List_type'] = $this->m_charts->getlist($from,$to);



			//var_dump($result['List_type'] );exit;
			$this->load->view("charts/v_charts", $result);
		}else{
			redirect('charts/c_charts');
		}
		
	}
	public function graph_week_days(){
// 		$da=$this->session->set_userdata('keyword');
// 		var_dump($da);
// exit;
		// $dat = $this->session->userdata('keyword');
		// var_dump($dat);
		// exit;

		$result['getCategories'] = $this->m_charts->get_chart_data();


		print json_encode($result['getCategories']);
	}


}