<?php
ini_set('memory_limit', '-1');
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class m_charts extends CI_Model
{	

	public function queryData($from,$to){
		// $from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
		// 	$to = date('m/d/Y');
			$rslt =$from." - ".$to;
			$this->session->set_userdata('date_r', $rslt);

	
		
		$keyword = $this->input->post('bd_search');
		$seller_id = $this->input->post('seller_search');
		
		$seller_id = trim(str_replace("'","''", $seller_id));
		$seller_id = strtoupper($seller_id);

		$keyword = trim(str_replace("'","''", $keyword));
		$keyword = strtoupper($keyword);
		
		
 		$end_one = $this->input->post('end_one');
 		$end_two = $this->input->post('end_two');
 		$item_con = $this->input->post('item_con');
 		$store = $this->session->userdata('store');
 		$Auction = $this->session->userdata('Auction');
 		$Fixed = $this->session->userdata('Fixed');
 		$BIN = $this->session->userdata('BIN');
 		$Skip = $this->session->userdata('Skip');
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = "SELECT NVL(count(lz_bd_cata_id), 0) as Toal_records, NVL(count(distinct seller_id), 0) as Total_Merchants, 
		round(sum(sale_price + shipping_cost),0) as Total_sale_value, ROUND(avg(sale_price + shipping_cost), 2) as Average_price, sum(verified) as VERIFIED ,  COUNT(distinct mpn_mt_id) no_items"; 
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." ";

			// $sql.=" FROM LZ_BD_CATAG_DATA_".$CATEGORY_ID." ";

			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";
				}
					}
			
			
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}

			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }

            if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
			
			
		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." ";
			$sql.=" WHERE MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}

			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
           	if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" AND UPPER(seller_id) LIKE '%$seller_id%' ";

            }
			if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }


		}

		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		//var_dump($query);exit;
		return $query;
	}
 		public function getCategories(){
 			if(empty ($this->input->post('bd_submit'))){
 			$from = date('m/d/y', strtotime('-3 months'));// date('m/01/Y');
 			// var_dump($from);
 			// EXIT;
			$to = date('m/d/y');
			$rslt =$from." - ".$to;
			$this->session->set_userdata('date_r', $rslt);

 			}else{


 			}
 			
		$sql = "SELECT D.CATEGORY_ID,K.CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D,LZ_BD_CATEGORY K ,LZ_BD_CAT_GROUP_MT G WHERE G.LZ_BD_GROUP_ID=D.LZ_BD_GROUP_ID AND D.CATEGORY_ID =K.CATEGORY_ID  ORDER BY K.CATEGORY_NAME";
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}
	public function getlist($from,$to){
		
		$keyword = $this->input->post('bd_search');
		$seller_id = $this->input->post('seller_search');
		$seller_id = strtoupper($seller_id);
		$seller_id = trim(str_replace("'","''", $seller_id));

 		$end_one = $this->input->post('end_one');
 		$end_two = $this->input->post('end_two');
 		$item_con = $this->input->post('item_con');
 		$store = $this->session->userdata('store');
 		$Auction = $this->session->userdata('Auction');
 		$Fixed = $this->session->userdata('Fixed');
 		$BIN = $this->session->userdata('BIN');
 		$Skip = $this->session->userdata('Skip');
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		$keyword = trim(str_replace("'","''", $keyword));
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = " SELECT LISTING_TYPE, SUM(SALE_PRICE + SHIPPING_COST) AS TOTAL_SALE_VALUE "; 
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id ;
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";

				}
					}

			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
			if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
			$sql.=" GROUP BY LISTING_TYPE";


		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." ";
			$sql.=" WHERE MAIN_CATEGORY_ID = $category_id";

			if(!empty($keyword) ) 
			{   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) 
				{
					foreach ($str as $key) 
					{$sql.=" AND UPPER(TITLE) LIKE '%$key%'";}
				}
				else
				{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			// elseif(!empty($strt_one)){

			// $sql.=" and sale_price =$SALE_PRICE";

			// }
			
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
			if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
			$sql.=" GROUP BY LISTING_TYPE";


		}

		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		//var_dump($query);exit;
		return $query;
	}
public function get_week_days($from,$to){

		$keyword = $this->input->post('bd_search');
		$seller_id = $this->input->post('seller_search');
		$seller_id = strtoupper($seller_id);
		$seller_id = trim(str_replace("'","''", $seller_id));
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		$keyword = trim(str_replace("'","''", $keyword));
		
 		$end_one = $this->input->post('end_one');
 		$end_two = $this->input->post('end_two');
 		$item_con = $this->input->post('item_con');
 		$store = $this->session->userdata('store');
 		$Auction = $this->session->userdata('Auction');
 		$Fixed = $this->session->userdata('Fixed');
 		$BIN = $this->session->userdata('BIN');
 		$Skip = $this->session->userdata('Skip');
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = " SELECT TO_CHAR(SALE_TIME, 'DAY') AS DAY_OF_WEEK,
to_char(SALE_TIME,'DAY', 'NLS_DATE_LANGUAGE=''numeric date language'''), round(SUM(SALE_PRICE + SHIPPING_COST),0) TOT_SALE, ROUND(AVG(SALE_PRICE + SHIPPING_COST), 2) AVERAGE_SALES"; 
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." A ";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";

				}
					}
		if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
		if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
		$sql.=" GROUP BY TO_CHAR(SALE_TIME, 'DAY'),to_char(SALE_TIME,'DAY', 'NLS_DATE_LANGUAGE=''numeric date language''') ";
		$sql.=" order by 2";


		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." ";
			$sql.=" WHERE MAIN_CATEGORY_ID = $category_id";

			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
		if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
		$sql.=" GROUP BY TO_CHAR(SALE_TIME, 'DAY'),to_char(SALE_TIME,'DAY', 'NLS_DATE_LANGUAGE=''numeric date language''') ";
		$sql.=" order by 2";
		}

		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		//var_dump($query);exit;
		return $query;



		}
		public function top_ten($from,$to){

		$keyword = $this->input->post('bd_search');
		$seller_id = $this->input->post('seller_search');
		$seller_id = strtoupper($seller_id);
		$seller_id = trim(str_replace("'","''", $seller_id));
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		$keyword = trim(str_replace("'","''", $keyword));
		
 		$end_one = $this->input->post('end_one');
 		$end_two = $this->input->post('end_two');
 		$item_con = $this->input->post('item_con');
 		$store = $this->session->userdata('store');
 		$Auction = $this->session->userdata('Auction');
 		$Fixed = $this->session->userdata('Fixed');
 		$BIN = $this->session->userdata('BIN');
 		$Skip = $this->session->userdata('Skip');
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = "SELECT * FROM (select  seller_id, sum(sale_price + SHIPPING_COST) sale,count(distinct ebay_id) Items_sold from LZ_BD_CATAG_DATA_".$category_id." where seller_id is not null ";
		 if($category_id == 0){
			//$sql.=" FROM LZ_BD_CATAG_DATA_".$CATEGORY_ID." A ";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" and UPPER(TITLE) LIKE '%$keyword%' ";

				}
					}
					
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
            if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }

			$sql.=" GROUP BY  seller_id  ";
					$sql.=" Order by sale desc )";
					$sql.=" WHERE rownum <= 10 ";
					$sql.=" ORDER BY rownum ";
					

		}else{
			$sql.=" AND MAIN_CATEGORY_ID = $category_id";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
            if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
			$sql.=" GROUP BY  seller_id  ";
					$sql.=" Order by sale desc )";
					$sql.=" WHERE rownum <= 10 ";
					$sql.=" ORDER BY rownum ";
					

		}

		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		//var_dump($query);exit;
		return $query;

		}

		public function get_chart_data(){

			


		$keyword = $this->session->userdata('keyword');
		$seller_id = $this->session->userdata('seller_id');
		$seller_id = strtoupper($seller_id);
		$seller_id = trim(str_replace("'","''", $seller_id));
		$from = $this->session->userdata('from');
		$to = $this->session->userdata('to');
		$item_con = $this->session->userdata('item_con');
		$store = $this->session->userdata('store');
		$Auction = $this->session->userdata('Auction');
		$Fixed = $this->session->userdata('Fixed');
		$BIN = $this->session->userdata('BIN');
		$Skip = $this->session->userdata('Skip');
		$keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
		$keyword = trim(str_replace("'","''", $keyword));
			
 		$end_one = $this->input->post('end_one');
 		$end_two = $this->input->post('end_two');
		//$keyword = str_replace(' ','|', $keyword);
		$str = explode(' ', $keyword);
		$category_id = $this->session->userdata('category_id');
		//$category_id = $this->input->post('bd_category');
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LZ_BD_CATA_ID',
			1 =>'CATEGORY_NAME',
			2 =>'CATEGORY_ID', 
			3 => 'EBAY_ID',
			4 => 'TITLE',
			5 => 'CONDITION_NAME',
			6 => 'SELLER_ID',
			7 => 'LISTING_TYPE',
			8 => 'SALE_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'FEEDBACK_SCORE'
		);
		$sql = " SELECT TO_CHAR(SALE_TIME, 'DAY') AS Lables, round(SUM(SALE_PRICE + SHIPPING_COST),0) as sales, to_char(SALE_TIME,
               'DAY',
               'NLS_DATE_LANGUAGE=''numeric date language''') days"; 
		if($category_id == 0){
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." A ";
			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					$i=1;
					foreach ($str as $key) {
						if($i === 1){
							$sql.=" WHERE UPPER(TITLE) LIKE '%$key%' ";
						}else{
							$sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
						}
						$i++;
					}
				}else{
					$sql.=" WHERE UPPER(TITLE) LIKE '%$keyword%' ";

				}
					}
		if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
        if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }

		$sql.=" GROUP BY TO_CHAR(SALE_TIME, 'DAY'),to_char(SALE_TIME,'DAY', 'NLS_DATE_LANGUAGE=''numeric date language''') ";
		$sql.=" order by days asc";


		}else{
			$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id." ";
			$sql.=" WHERE MAIN_CATEGORY_ID = $category_id";

			if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
				if (count($str)>1) {
					foreach ($str as $key) {
						$sql.=" AND UPPER(TITLE) LIKE '%$key%'";
					}
				}else{
					$sql.=" AND UPPER(TITLE) LIKE '%$keyword%'";
				}
			}
			
			if(!empty($end_one) && !empty($end_two)){
			$sql.=" and sale_price between $end_one and $end_two";
			}
			if(!empty($item_con)){
			$sql.=" and condition_name LIKE '%$item_con%'";
			}
			if(!empty($store))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($seller_id)){
            	$sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

            }
        if(empty($Skip)){
            	$sql.= "AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }

		$sql.=" GROUP BY TO_CHAR(SALE_TIME, 'DAY'),to_char(SALE_TIME,'DAY', 'NLS_DATE_LANGUAGE=''numeric date language''') ";
		$sql.=" order by days asc";
		}

		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		//var_dump($query);exit;
		return $query;

		}
}