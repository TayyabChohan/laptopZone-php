<?php 
// Test

	/**
	* Shipment Model
	*/
	class Dashboard_Model extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
		
	}
		
		public function a_shipment()
		{
			# code...
			$query = $this->db->query("select TO_CHAR(d.sale_date, 'DD-MM-YYYY HH24:MI:SS') as sale_date, TO_CHAR(d.paid_on_date, 'DD-MM-YYYY HH24:MI:SS') as paid_on_date, d.sales_record_number, d.item_title,d.item_id, d.buyer_email, d.user_id,d.quantity, d.sale_price, d.total_price from LZ_SALESLOAD_MT m,LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (d.orderstatus <> 'Cancelled' or d.orderstatus is null) and d.tracking_number is null and m.lz_seller_acct_id in(1,2) order by d.sales_record_number desc");
			//$query = $this->db->query("select * from LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (orderstatus <> 'Cancelled' or orderstatus is null) and tracking_number is null and m.lz_seller_acct_id in(1,2)");

			return $query->result_array(); // This will return data in Array 

		}
		public function date_filter($from, $to)
		{
			//var_dump($fromdate);exit;

			$q = $this->db->query("select * from lz_salesload_det where paid_on_date in( TO_DATE('$from'),TO_DATE('$to'))");

			return $q->result_array();

		}
		public function sum_price_quantity(){
			$sum_quantity = $this->db->query("select sum(d.total_price) as Total_Sale_Price, sum(total_price) as TOTAL_PRICE, sum(quantity) as TOTAL_QUANTITY from LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (d.orderstatus <> 'Cancelled' or d.orderstatus is null) and d.tracking_number is null and m.lz_seller_acct_id in (1, 2)");
			return $sum_quantity->result_array();
		}
	 	public function queryRadio($awt_radio){
			//$main_query = "select t.* from view_lz_listing_revised t";
			$main_query = "select * from LZ_SALESLOAD_MT m,LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (orderstatus <> 'Cancelled' or orderstatus is null) and tracking_number is null";
			$qry_condition = "";
	 		if($awt_radio == 2){
	 			$qry_condition = " and m.lz_seller_acct_id =2";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}elseif($awt_radio == 1){
	 			$qry_condition = " and m.lz_seller_acct_id =1";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}elseif($awt_radio == 'Both'){
	 			$qry_condition = "and m.lz_seller_acct_id in(1,2)";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}
	 		$query = $this->db->query( $main_query." ".$qry_condition." order by d.paid_on_date asc");

			return $query->result_array();

			
	 	}		
	 	public function dataRadio($awt_radio){
			//$main_query = "select t.* from view_lz_listing_revised t";
			$main_query = "select sum(d.total_price) as Total_Sale_Price, sum(total_price) as TOTAL_PRICE, sum(quantity) as TOTAL_QUANTITY from LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (d.orderstatus <> 'Cancelled' or d.orderstatus is null) and d.tracking_number is null";
			$qry_condition = "";
	 		if($awt_radio == 2){
	 			$qry_condition = " and m.lz_seller_acct_id =2";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}elseif($awt_radio == 1){
	 			$qry_condition = " and m.lz_seller_acct_id =1";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}elseif($awt_radio == 'Both'){
	 			$qry_condition = "and m.lz_seller_acct_id in(1,2)";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}
	 		$query = $this->db->query( $main_query." ".$qry_condition." order by d.paid_on_date asc");

			return $query->result_array();

			
	 	}			



		
	}

 ?>