<?php
ini_set('memory_limit', '-1');
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
 
class m_mpn_charts extends CI_Model
{	

	public function getCategories(){
 			if(empty ($this->input->post('bd_mpn_submit'))){
 			$from = date('m/d/y', strtotime('-3 months'));// date('m/01/Y');
 			// var_dump($from);
 			// EXIT;
			$to = date('m/d/y');
			$rslt =$from." - ".$to;
			$this->session->set_userdata('date2_r', $rslt);

 			}else{


 			}
 			
		$sql = "SELECT D.CATEGORY_ID,K.CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D,LZ_BD_CATEGORY K ,LZ_BD_CAT_GROUP_MT G WHERE G.LZ_BD_GROUP_ID=D.LZ_BD_GROUP_ID AND D.CATEGORY_ID =K.CATEGORY_ID  ORDER BY K.CATEGORY_NAME";
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}


	public function get_cards_data(){

			// $rslt =$from." - ".$to;
			// $this->session->set_userdata('date_r', $rslt);

			$bd_mpn_category = $this->session->userdata('bd_mpn_category');

			$seller_mpn_id = $this->session->userdata('seller_mpn_id');
			$seller_mpn_id = strtoupper($seller_mpn_id);
			$mpn_store = $this->session->userdata('mpn_store');
			$mpn_Auction = $this->session->userdata('mpn_Auction');
 			$mpb_Fixed = $this->session->userdata('mpb_Fixed');
 			$mpn_BIN = $this->session->userdata('mpn_BIN');
 			$mpn_start = $this->session->userdata('mpn_start');
 			$mpn_end = $this->session->userdata('mpn_end');
 			$mpn_item_con = $this->session->userdata('mpn_item_con');
 			$mpn_Skip = $this->session->userdata('mpn_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');
//$sql.=" FROM LZ_BD_CATAG_DATA_".$category_id ;
			$sql = "SELECT ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST), 0) AS TOTAL_SALE_VALUE, ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE, COUNT(DISTINCT SELLER_ID) SELLER, COUNT(C.CATALOGUE_MT_ID) AS SALE_UNIT, MIN(C.Sale_Price + C.SHIPPING_COST) min_SALE, MAX(C.Sale_Price + C.SHIPPING_COST) max_SALE FROM LZ_BD_CATAG_DATA_".$bd_mpn_category." C";

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			$sql.=" AND C.CATALOGUE_MT_ID IN (SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT)";

			if(!empty ($bd_mpn_category)){
			$sql.=" and C.category_id =$bd_mpn_category";
			}
			if(!empty ($seller_mpn_id)){
				$sql.=" AND UPPER(C.seller_id) LIKE '%$seller_mpn_id%'";
			}
			if(!empty($mpn_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_start) && !empty($mpn_end)){
			$sql.=" and C.sale_price between $mpn_start and $mpn_end";
			}
			if(!empty($mpn_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_item_con%'";
			}

			if(empty($mpn_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY  UPPER(C.SELLER_ID) ";
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}

	public function get_sale_value(){

			// $rslt =$from." - ".$to;
			// $this->session->set_userdata('date_r', $rslt);

			$bd_mpn_category = $this->session->userdata('bd_mpn_category');

			$seller_mpn_id = $this->session->userdata('seller_mpn_id');
			$seller_mpn_id = strtoupper($seller_mpn_id);
			$mpn_store = $this->session->userdata('mpn_store');
			$mpn_Auction = $this->session->userdata('mpn_Auction');
 			$mpb_Fixed = $this->session->userdata('mpb_Fixed');
 			$mpn_BIN = $this->session->userdata('mpn_BIN');
 			$mpn_start = $this->session->userdata('mpn_start');
 			$mpn_end = $this->session->userdata('mpn_end');
 			$mpn_item_con = $this->session->userdata('mpn_item_con');
 			$mpn_Skip = $this->session->userdata('mpn_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT M.MPN,nvl(REC.SALE_VALUE,0) sale_value FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE,ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(C.CATALOGUE_MT_ID ) AS SALE_UNIT FROM LZ_BD_CATAG_DATA_".$bd_mpn_category." C";

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_category)){
			$sql.=" and C.category_id =$bd_mpn_category";
			}
			if(!empty ($seller_mpn_id)){
				$sql.=" AND UPPER(C.seller_id) LIKE '%$seller_mpn_id%'";
			}
			if(!empty($mpn_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_start) && !empty($mpn_end)){
			$sql.=" and C.sale_price between $mpn_start and $mpn_end";
			}
			if(!empty($mpn_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_item_con%'";
			}

			if(empty($mpn_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}
	public function get_sale_units(){

			$bd_mpn_category = $this->session->userdata('bd_mpn_category');

			$seller_mpn_id = $this->session->userdata('seller_mpn_id');
			$seller_mpn_id = strtoupper($seller_mpn_id);
			$mpn_store = $this->session->userdata('mpn_store');
			$mpn_Auction = $this->session->userdata('mpn_Auction');
 			$mpb_Fixed = $this->session->userdata('mpb_Fixed');
 			$mpn_BIN = $this->session->userdata('mpn_BIN');
 			$mpn_start = $this->session->userdata('mpn_start');
 			$mpn_end = $this->session->userdata('mpn_end');
 			$mpn_item_con = $this->session->userdata('mpn_item_con');
 			$mpn_Skip = $this->session->userdata('mpn_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT M.MPN,nvl(REC.SALE_UNIT,0) sale_unit FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE,ROUND(AVG(C.SALE_PRICE+ C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(C.CATALOGUE_MT_ID ) AS SALE_UNIT FROM LZ_BD_CATAG_DATA_".$bd_mpn_category." C";

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_category)){
			$sql.=" and C.category_id =$bd_mpn_category";
			}
			if(!empty ($seller_mpn_id)){
				$sql.=" AND UPPER(C.seller_id) LIKE '%$seller_mpn_id%'";
			}
			if(!empty($mpn_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_start) && !empty($mpn_end)){
			$sql.=" and C.sale_price between $mpn_start and $mpn_end";
			}
			if(!empty($mpn_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_item_con%'";
			}

			if(empty($mpn_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;
	}
	public function get_avg_sale(){

			$bd_mpn_category = $this->session->userdata('bd_mpn_category');

			$seller_mpn_id = $this->session->userdata('seller_mpn_id');
			$seller_mpn_id = strtoupper($seller_mpn_id);
			$mpn_store = $this->session->userdata('mpn_store');
			$mpn_Auction = $this->session->userdata('mpn_Auction');
 			$mpb_Fixed = $this->session->userdata('mpb_Fixed');
 			$mpn_BIN = $this->session->userdata('mpn_BIN');
 			$mpn_start = $this->session->userdata('mpn_start');
 			$mpn_end = $this->session->userdata('mpn_end');
 			$mpn_item_con = $this->session->userdata('mpn_item_con');
 			$mpn_Skip = $this->session->userdata('mpn_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT M.MPN,REC.AVERAGE_PRICE as avg_sale FROM LZ_CATALOGUE_MT M , (SELECT C.CATALOGUE_MT_ID AS ID,ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST),0) AS SALE_VALUE,ROUND(AVG(C.SALE_PRICE + C.SHIPPING_COST), 2) AS AVERAGE_PRICE,COUNT(C.CATALOGUE_MT_ID ) AS SALE_UNIT FROM LZ_BD_CATAG_DATA_".$bd_mpn_category." C";

			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_category)){
			$sql.=" and C.category_id =$bd_mpn_category";
			}
			if(!empty ($seller_mpn_id)){
				$sql.=" AND UPPER(C.seller_id) LIKE '%$seller_mpn_id%'";
			}
			if(!empty($mpn_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_start) && !empty($mpn_end)){
			$sql.=" and C.sale_price between $mpn_start and $mpn_end";
			}
			if(!empty($mpn_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_item_con%'";
			}

			if(empty($mpn_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID ) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
			

			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}

	public function get_cond_salevalue(){

			$bd_mpn_category = $this->session->userdata('bd_mpn_category');

			$seller_mpn_id = $this->session->userdata('seller_mpn_id');
			$seller_mpn_id = strtoupper($seller_mpn_id);
			$mpn_store = $this->session->userdata('mpn_store');
			$mpn_Auction = $this->session->userdata('mpn_Auction');
 			$mpb_Fixed = $this->session->userdata('mpb_Fixed');
 			$mpn_BIN = $this->session->userdata('mpn_BIN');
 			$mpn_start = $this->session->userdata('mpn_start');
 			$mpn_end = $this->session->userdata('mpn_end');
 			$mpn_item_con = $this->session->userdata('mpn_item_con');
 			$mpn_Skip = $this->session->userdata('mpn_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT M.MPN||' ('||rec.name ||')' as mpn, nvl(REC.SALE_VALUE, 0) sale_value FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID, ROUND(SUM(C.SALE_PRICE + C.SHIPPING_COST), 0) AS SALE_VALUE, c.condition_name name FROM LZ_BD_CATAG_DATA_".$bd_mpn_category." C";
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_category)){
			$sql.=" and C.category_id =$bd_mpn_category";
			}
			if(!empty ($seller_mpn_id)){
				$sql.=" AND UPPER(C.seller_id) LIKE '%$seller_mpn_id%'";
			}
			if(!empty($mpn_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_start) && !empty($mpn_end)){
			$sql.=" and C.sale_price between $mpn_start and $mpn_end";
			}
			if(!empty($mpn_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_item_con%'";
			}

			if(empty($mpn_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,C.CONDITION_NAME) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				$sql.="  ORDER BY SALE_VALUE DESC";
			
 
			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}

	public function get_cond_saleunit(){

			$bd_mpn_category = $this->session->userdata('bd_mpn_category');

			$seller_mpn_id = $this->session->userdata('seller_mpn_id');
			$seller_mpn_id = strtoupper($seller_mpn_id);


			$mpn_store = $this->session->userdata('mpn_store');
			$mpn_Auction = $this->session->userdata('mpn_Auction');
 			$mpb_Fixed = $this->session->userdata('mpb_Fixed');
 			$mpn_BIN = $this->session->userdata('mpn_BIN');
 			$mpn_start = $this->session->userdata('mpn_start');
 			$mpn_end = $this->session->userdata('mpn_end');
 			$mpn_item_con = $this->session->userdata('mpn_item_con');
 			$mpn_Skip = $this->session->userdata('mpn_Skip');

 			$from = $this->session->userdata('from');
 			$to = $this->session->userdata('to');

			$sql = "SELECT M.MPN||' ('||rec.name ||')' as mpn, nvl(REC.SALE_UNIT, 0) SALE_UNIT FROM LZ_CATALOGUE_MT M, (SELECT C.CATALOGUE_MT_ID AS ID, COUNT(C.CATALOGUE_MT_ID) AS SALE_UNIT, c.condition_name name FROM LZ_BD_CATAG_DATA_".$bd_mpn_category." C";
			$sql.=" WHERE C.CATALOGUE_MT_ID IS NOT NULL";

			if(!empty ($bd_mpn_category)){
			$sql.=" and C.category_id =$bd_mpn_category";
			}
			if(!empty ($seller_mpn_id)){
				$sql.=" AND UPPER(C.seller_id) LIKE '%$seller_mpn_id%'";
			}
			// var_dump($sql);
			// EXIT;
			if(!empty($mpn_store))
            {
            	$sql.=" AND UPPER(C.listing_type) LIKE '%STOREINVENTORY%'";
               
            }
            if(!empty($mpn_Auction))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTION%'";
               
            }
            if(!empty($mpb_Fixed))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%FIXEDPRICE%'";
               
            }
            if(!empty($mpn_BIN))
            {
            	$sql.=" AND UPPER(listing_type) LIKE '%AUCTIONWITHBIN%'";
               
            }
            if(!empty($mpn_start) && !empty($mpn_end)){
			$sql.=" and C.sale_price between $mpn_start and $mpn_end";
			}
			if(!empty($mpn_item_con)){
			$sql.=" and condition_name LIKE '%$mpn_item_con%'";
			}

			if(empty($mpn_Skip)){
            	$sql.=" AND start_time between TO_DATE('$from "."00:00:00','MM/DD/YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','MM/DD/YY  HH24:MI:SS')";

            }
				

				$sql.=" GROUP BY C.CATALOGUE_MT_ID,C.CONDITION_NAME) REC";
				$sql.="  WHERE M.CATALOGUE_MT_ID =REC.ID";
				$sql.="  ORDER BY SALE_UNIT DESC";
			
 
			// if(!empty ($category_id)){
			// 	$sql.=" and category_id =$category_id";
			// }
			// $sql.=" ORDER BY CATALOGUE_MT_ID";

			 $query = $this->db2->query($sql);
		$query = $query->result_array();
		return $query;

	}
}