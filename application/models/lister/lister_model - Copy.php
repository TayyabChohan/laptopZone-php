<?php 

	class Lister_Model extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	 	public function ListerUsers(){
	  	$query = $this->db->query("select t.employee_id, t.user_name FROM EMPLOYEE_MT t where t.employee_id in(4,5,13,14,16,17,18)");

	  	//var_dump($query->result_array());exit;
	  	return $query->result_array();
	 	}

	 	public function listing_data(){

	 		$q = $this->db->query("select t.item_id, t.lz_manifest_id, TO_CHAR(t.list_date, 'DD-MM-YYYY HH24:MI:SS') as list_date, t.lister_id,e.user_name, t.ebay_item_desc, t.list_qty, t.ebay_item_id, t.list_price, t.lz_seller_acct_id from ebay_list_mt t,employee_mt e where t.lister_id=e.employee_id and t.lz_seller_acct_id is not null order by t.list_date desc");

	 		//var_dump($q->result_array());exit;
	 		return $q->result_array();
	 	}

	 	public function sum_total_listing(){
			//$sum_listing = $this->db->query("select count(t.item_id) as TOTAL_LISTING,sum(t.list_price) as TOTAL_PRICE from ebay_list_mt t where  t.lz_seller_acct_id is not null");
			$sum_listing = $this->db->query("select count(1) as TOTAL_LISTING, sum(list_amt) as TOTAL_PRICE from ( select e.ebay_item_id, sum(e.list_qty * e.list_price) list_amt from ebay_list_mt e where e.lz_seller_acct_id is not null group by e.ebay_item_id) in_qry");

			//var_dump($sum_listing->result_array());exit;
			
			return $sum_listing->result_array();	 		
	 	}

	 	public function search_lister($lister_radio,$user_id,$from,$to){

			//$main_query = "select t.* from view_lz_listing_revised t";
			if($user_id !== "All"){
			$main_query = "select t.item_id, t.lz_manifest_id, TO_CHAR(t.list_date, 'DD-MM-YYYY HH24:MI:SS') as list_date, t.lister_id,e.user_name, t.ebay_item_desc, t.list_qty, t.ebay_item_id, t.list_price, t.lz_seller_acct_id from ebay_list_mt t,employee_mt e where t.lister_id=e.employee_id and t.list_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS') and t.lister_id = $user_id";
			
		}else{
			$main_query = "select t.item_id, t.lz_manifest_id,TO_CHAR(t.list_date, 'DD-MM-YYYY HH24:MI:SS') as list_date, t.lister_id,e.user_name, t.ebay_item_desc, t.list_qty, t.ebay_item_id, t.list_price, t.lz_seller_acct_id from ebay_list_mt t,employee_mt e where t.lister_id=e.employee_id and t.list_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS') and t.lister_id in (4,5,13,14,16,17,18)";
			$lister_radio == 'Both';
		}
			$qry_condition = "";
	 		if($lister_radio == 2){
	 			$qry_condition = " and t.lz_seller_acct_id =2";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 1){
	 			$qry_condition = " and t.lz_seller_acct_id =1";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 'Both'){
	 			$qry_condition = "and t.lz_seller_acct_id in(1,2)";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}
	 		$query = $this->db->query( $main_query." ".$qry_condition." order by t.list_date desc");

			return $query->result_array();	 		

	 	}

		public function radio_lister($lister_radio,$user_id,$from,$to){

			if($user_id !== "All"){

			$main_query = "select count(1) as TOTAL_LISTING, sum(list_amt) as TOTAL_PRICE from ( select e.ebay_item_id, sum(e.list_qty * e.list_price) list_amt from ebay_list_mt e where e.lz_seller_acct_id is not null and e.lister_id = $user_id and e.list_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";

			}else{
			$main_query = "select count(1) as TOTAL_LISTING, sum(list_amt) as TOTAL_PRICE from ( select e.ebay_item_id, sum(e.list_qty * e.list_price) list_amt from ebay_list_mt e where e.lz_seller_acct_id is not null and e.lister_id in (4,5,13,14,16,17,18) and e.list_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			}

			$qry_condition = "";
	 		if($lister_radio == 2){
	 			$qry_condition = " and e.lz_seller_acct_id =2";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 1){
	 			$qry_condition = " and e.lz_seller_acct_id =1";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 'Both'){
	 			$qry_condition = "and e.lz_seller_acct_id in(1,2)";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}
	 		$query = $this->db->query( $main_query." ".$qry_condition."group by e.ebay_item_id order by e.list_date desc ) in_qry");

			return $query->result_array();	 		

	 	}	 	

}




 ?>