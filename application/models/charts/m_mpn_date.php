<?php
ini_set('memory_limit', '-1');
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class m_mpn_date extends CI_Model
{	

	public function getCategories(){
			if(empty ($this->input->post('bd_mpn_date_submit'))){
 			$from = date('m/d/y', strtotime('-3 months'));// date('m/01/Y');
 			// var_dump($from);
 			// EXIT;
			$to = date('m/d/y');
			$rslt =$from." - ".$to;
			$this->session->set_userdata('date3_r', $rslt);

 			}else{


 			}
 		
 			
		$sql = "SELECT D.CATEGORY_ID,K.CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D,LZ_BD_CATEGORY K ,LZ_BD_CAT_GROUP_MT G WHERE G.LZ_BD_GROUP_ID=D.LZ_BD_GROUP_ID AND D.CATEGORY_ID =K.CATEGORY_ID  ORDER BY K.CATEGORY_NAME";
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}
	public function get_date_last_month(){

		
			$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT REC.AVERAGE_PRICE AS AVERAGE_PRICE FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C";
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			//if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TRUNC(SYSDATE-31) and TRUNC(SYSDATE)";

            //}
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
			if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;



	}

	public function get_date_cards_data(){


		
			$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT nvl(REC.SALE_VALUE, 0) Total_sale_value,REC.SELLER AS SELLER,REC.SALE_UNIT AS SALE_UNIT, nvl(REC.min_SALE, 0) min_SALE_VALUE, nvl(REC.max_SALE, 0) max_SALE_VALUE FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID, ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST), 0) AS SALE_VALUE, ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(DISTINCT SELLER_ID) SELLER, COUNT(C.CATALOGUE_MT_ID) AS SALE_UNIT, MIN(C.Sale_Price + C.SHIPPING_COST) min_SALE, MAX(C.Sale_Price + C.SHIPPING_COST) max_SALE  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C";
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
			if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;



	}

	public function get_date_sale_value(){

		
			$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT  to_char(rec.wek, 'yyyy-MON-dd') as wek,REC.ORD,nvl(REC.AVERAGE_PRICE,0) sale_value FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE,ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(C.CATALOGUE_MT_ID ) AS SALE_UNIT,TO_CHAR(SALE_TIME, 'mm', 'NLS_DATE_LANGUAGE=''NUMERIC DATE LANGUAGE''') AS ORD,TRUNC(to_date(C.sale_time), 'MM') wek   FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C"; 

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,TRUNC(to_date(C.sale_time), 'MM'),TO_CHAR(SALE_TIME, 'mm', 'NLS_DATE_LANGUAGE=''NUMERIC DATE LANGUAGE''') ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
			if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
			$sql.=" order by ord desc"; 
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}
	public function get_date_sale_units(){


			$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT  to_char(rec.wek, 'yyyy') as wek,nvl(REC.AVERAGE_PRICE,0) sale_value FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE,ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(C.CATALOGUE_MT_ID ) AS SALE_UNIT,TRUNC(to_date(C.sale_time), 'yy') wek   FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C"; 

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,TRUNC(to_date(C.sale_time), 'yy') ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}

			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}
	public function get_date_avg_sale(){

			$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT  to_char(rec.wek, 'yyyy-mm-dd')  ||'('|| rec.ord ||')' as wek,REC.ORD,nvl(REC.AVERAGE_PRICE,0) sale_value  FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE,ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(C.CATALOGUE_MT_ID ) AS SALE_UNIT,TO_CHAR(SALE_TIME, 'ww', 'NLS_DATE_LANGUAGE=''NUMERIC DATE LANGUAGE''') AS ORD,TRUNC(to_date(C.sale_time), 'ww') wek   FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C"; 

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,TRUNC(to_date(C.sale_time), 'ww'),TO_CHAR(SALE_TIME, 'ww', 'NLS_DATE_LANGUAGE=''NUMERIC DATE LANGUAGE''')) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
				
			}
			$sql.=" order by ord desc"; 

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}

	public function get_data_mpn_seller(){

		$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT * FROM (SELECT REC.SELLER,NVL(REC.AVERAGE_PRICE, 0) AVG_SALE_VALUE FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID, C.SELLER_ID SELLER, sum(sale_price + SHIPPING_COST) sale, round(avg(sale_price + SHIPPING_COST),0) AVERAGE_PRICE  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C"; 
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
			

			$sql.=" AND C.SELLER_ID IS NOT NULL";

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,C.SELLER_ID ";
				$sql.="  ORDER BY SALE DESC) REC";

				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";

				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}	
				$sql.=" )";
				$sql.="   WHERE rownum <= 10";

			
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;


	}

	public function get_con_wise_salevalue(){

		$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT  REC.NAME, NVL(REC.SALE_VALUE, 0) TOTAL_SALE_VALUE  FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,CONDITION_NAME NAME,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C";
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,CONDITION_NAME ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
				$sql.=" order by Total_sale_value desc";
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;


	}

	public function get_con_wise_saleunit(){

		$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT  REC.NAME, REC.SALE_UNIT AS SALE_UNIT FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,CONDITION_NAME NAME,COUNT(C.CATALOGUE_MT_ID) AS SALE_UNIT  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C";
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,CONDITION_NAME ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
				$sql.=" order by SALE_UNIT desc";
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;


	}

	public function get_day_wise_saleval(){

		$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql  = "SELECT REC.DAY, REC.SALE_VALUE SALE_VALUE ,REC.ORD FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID,TO_CHAR(SALE_TIME, 'DAY') AS DAY,to_char(SALE_TIME,'DAY','NLS_DATE_LANGUAGE=''numeric date language''') AS ORD,ROUND(SUM(SALE_PRICE + SHIPPING_COST), 0) SALE_VALUE  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C"; 
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY to_char(SALE_TIME,'DAY','NLS_DATE_LANGUAGE=''numeric date language'''),C.CATALOGUE_MT_ID,TO_CHAR(SALE_TIME, 'DAY')) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
				$sql.=" ORDER BY REC.ORD ";
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;


	}
	public function get_day_wise_saleunit(){

		$bd_mpn_date_category = $this->session->userdata('bd_mpn_date_category');

			$seller_mpn_date_id = $this->session->userdata('seller_mpn_date_id');
			$seller_mpn_date_id = strtoupper($seller_mpn_date_id);
			$mpn_date_store = $this->session->userdata('mpn_date_store');
			$mpn_date_Auction = $this->session->userdata('mpn_date_Auction');
 			$mpb_date_Fixed = $this->session->userdata('mpb_date_Fixed');
 			$mpn_date_BIN = $this->session->userdata('mpn_date_BIN');
 			$mpn_date_start = $this->session->userdata('mpn_date_start');
 			$mpn_date_end = $this->session->userdata('mpn_date_end');
 			$mpn_date_item_con = $this->session->userdata('mpn_date_item_con');
 			$mpn_date_Skip = $this->session->userdata('mpn_date_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql  = "SELECT REC.DAY, REC.SALE_UNIT SALE_UNIT ,REC.ORD FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID,TO_CHAR(SALE_TIME, 'DAY') AS DAY,to_char(SALE_TIME,'DAY','NLS_DATE_LANGUAGE=''numeric date language''') AS ORD,COUNT(C.CATALOGUE_MT_ID) AS SALE_UNIT  FROM LZ_BD_CATAG_DATA_".$bd_mpn_date_category." C"; 
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_date_category)){
			$sql.=" and C.category_id =$bd_mpn_date_category";
			}
			
			if(!empty($mpn_date_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_date_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_date_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_date_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_date_start) && !empty($mpn_date_end)){
			$sql.=" and C.sale_price between $mpn_date_start and $mpn_date_end";
			}
			if(!empty($mpn_date_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_date_item_con%'";
			}

			if(empty($mpn_date_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY to_char(SALE_TIME,'DAY','NLS_DATE_LANGUAGE=''numeric date language'''),C.CATALOGUE_MT_ID, TO_CHAR(SALE_TIME, 'DAY') ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				if(!empty ($seller_mpn_date_id)){
				$sql.=" and UPPER(m.mpn) LIKE '%$seller_mpn_date_id%'";
			}
				$sql.=" ORDER BY REC.ORD ";
				
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;


	}
}