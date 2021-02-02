<?php 
// Test

	/**
	* Shipment Model
	*/
	class Awt_Shipment extends CI_Model
	{
		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	public function loadShipment()
	{
		$requestData= $_REQUEST;
		$columns = array( 
	      0 =>'BARCODE_NO',
	      1 =>'LZ_SALESLOAD_DET_ID',
	      2 =>'ITEM_TITLE',
	      3 =>'ITEM_ID',
	      4 =>'USER_ID',
	      5 =>'QUANTITY',
	      6 =>'SALE_PRICE',
	      7 =>'TOTAL_PRICE',
	      8 =>'',
	      9 =>'PAID_ON_DATE',
	      10 =>'BIN_NAME',
	      11 =>'BUYER_CHECKOUT_MSG',
	      12 =>'BIN_ID'
	    );
	    $shipment_radio = $this->input->post('shipment_radio');
	    if (empty($shipment_radio) || $shipment_radio == null) {
	    	$shipment_radio = $this->session->userdata('awt');
	    }
			    $sql = "SELECT * FROM (SELECT BB.BARCODE_NO, BB.BIN_ID, TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE, D.LZ_SALESLOAD_DET_ID, D.SALES_RECORD_NUMBER, D.ITEM_TITLE, D.ITEM_ID, D.BUYER_EMAIL, D.BUYER_CHECKOUT_MSG, D.USER_ID, DECODE(BB.BARCODE_NO, NULL, D.QUANTITY, '1') QUANTITY, D.SALE_PRICE, 'W'||WA.WAREHOUSE_NO||'-'||M.RACK_NO||'-R'||RO.ROW_NO||'-'||I.BIN_TYPE||'-'||I.BIN_NO BIN_NAME, D.TOTAL_PRICE FROM LZ_SALESLOAD_MT M, LZ_SALESLOAD_DET D, LZ_BARCODE_MT BB,BIN_MT I, LZ_RACK_ROWS RO, RACK_MT M, WAREHOUSE_MT WA WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND D.SALES_RECORD_NUMBER = BB.SALE_RECORD_NO(+) AND (UPPER(D.ORDERSTATUS) <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NULL AND D.GNRTD_DC_ID IS NULL AND I.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+) AND RO.RACK_ID = M.RACK_ID(+) AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID(+) AND bB.BIN_ID = I.BIN_ID(+)";
			    if (!empty($shipment_radio) || $shipment_radio != null) {
			    	if($shipment_radio == 2){
			 			$sql .= " AND M.LZ_SELLER_ACCT_ID =2";
			 			$this->session->set_userdata('awt', $shipment_radio);
			 		}elseif($shipment_radio == 1){
			 			$sql .= " AND M.LZ_SELLER_ACCT_ID =1";
			 			$this->session->set_userdata('awt', $shipment_radio);

			 		}elseif($shipment_radio == 'Both'){
			 			$sql .= "AND M.LZ_SELLER_ACCT_ID IN(1,2)";
			 			$this->session->set_userdata('awt', $shipment_radio);

			 		}
			    }else{
			    	$sql .= "AND M.LZ_SELLER_ACCT_ID IN(1,2)";
			    }

	     if(!empty($requestData['search']['value'])){
	     	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		    $sql.=" AND ( BB.BARCODE_NO LIKE '%".$requestData['search']['value']."%'";
		    $sql.=" OR D.SALES_RECORD_NUMBER LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.ITEM_TITLE LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.ITEM_ID LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.LZ_SALESLOAD_DET_ID LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.USER_ID LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.QUANTITY LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.TOTAL_PRICE LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR D.SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";   
		    $sql.=" OR 'W'||WA.WAREHOUSE_NO||'-'||M.RACK_NO||'-R'||RO.ROW_NO||'-'||I.BIN_TYPE||'-'||I.BIN_NO LIKE '%".$requestData['search']['value']."%') "; 
		  }
		  if (!empty($columns[$requestData['order'][0]['column']])) {
				$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
			}else{
				$sql.= " ORDER BY D.LZ_SALESLOAD_DET_ID DESC";
			}

		$sql .= "  )";

		$query = $this->db->query($sql);
	    $totalData = $query->num_rows();
	    $totalFiltered = $totalData; 
	 
	    $sql = "SELECT * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
	    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
	      
	    /*=====  End of For Oracle 12-c  ======*/
	    $query = $this->db->query($sql);
	    $query = $query->result_array();
	    $data = array();
	    $i =0;
	    foreach($query as $row ){ 
	    $nestedData 				= array();
	    $nestedData[]  				= $row['BARCODE_NO'];

	    if(!empty($row['BUYER_CHECKOUT_MSG'])){
	    	$buyer_class = 'class="buyer-txt"';
	    }else{
	    	$buyer_class 			= '';	
	    }

	    $nestedData[]  				= '<div '.$buyer_class.'>'.$row['SALES_RECORD_NUMBER'].'</div>';
	    $nestedData[]  				= $row['ITEM_TITLE'];
	    $nestedData[]  				= $row['ITEM_ID'];
		$nestedData[]  				= $row['USER_ID'].'/'.$row['BUYER_EMAIL'];
		$nestedData[]				= $row['QUANTITY'];
		$sale_price 				= $row['SALE_PRICE'];
		$nestedData[] 				= '$'.number_format((float)$sale_price,2,'.',',');
		$total_price 				= $row['TOTAL_PRICE'];
		$nestedData[] 				= '$'.number_format((float)$total_price,2,'.',',');
		$nestedData[] 				= $row['SALE_DATE'];
		$nestedData[] 				= $row['PAID_ON_DATE'];
		$nestedData[] 				= $row['BIN_NAME'] ;
		$nestedData[] 				= $row['BUYER_CHECKOUT_MSG'];
		$nestedData[] 				= $row['BIN_ID'];
	    $data[] 			    	= $nestedData;
	      $i++;
	    }

	    $json_data = array(
	          "draw"            => intval($requestData['draw']), 
	          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	          "recordsTotal"    =>  intval($totalData),  
	          // total number of records
	          "recordsFiltered" => intval($totalFiltered), 
	          // total number of records after searching, if there is no searching then totalFiltered = totalData
	          "deferLoading"    =>  intval($totalFiltered),
	          "data"            => $data   // total data array
	          );
	    //var_dump('expression'); exit;
	    return $json_data;  
	}
		public function date_filter($from, $to)
		{
			//var_dump($fromdate);exit;
			$q = $this->db->query("SELECT * FROM LZ_SALESLOAD_DET WHERE PAID_ON_DATE IN( TO_DATE('$from'),TO_DATE('$to'))");
			return $q->result_array();
		}
		public function sum_price_quantity(){
			$sum_quantity = $this->db->query("SELECT SUM(D.SALE_PRICE) AS TOTAL_SALE_PRICE,SUM(D.TOTAL_PRICE) AS TOTAL_PRICE,SUM(D.SHIPPING_CHARGES) AS TOTAL_SHIPPING_FEE,SUM(D.QUANTITY) AS TOTAL_QUANTITY FROM LZ_SALESLOAD_MT M, LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (UPPER(D.ORDERSTATUS) <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NULL AND M.LZ_SELLER_ACCT_ID IN (1, 2)");
			return $sum_quantity->result_array();
		}
	 	public function queryRadio($awt_radio){
			//$main_query = "select t.* from view_lz_listing_revised t";
			$main_query = "SELECT TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE, D.SALES_RECORD_NUMBER, D.ITEM_TITLE,D.ITEM_ID, D.BUYER_EMAIL, D.USER_ID,D.QUANTITY, D.SALE_PRICE, D.TOTAL_PRICE FROM LZ_SALESLOAD_MT M,LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (UPPER(ORDERSTATUS) <> 'CANCELLED' OR ORDERSTATUS IS NULL) AND TRACKING_NUMBER IS NULL";
			$qry_condition = "";
	 		if($awt_radio == 2){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID =2";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}elseif($awt_radio == 1){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID =1";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}elseif($awt_radio == 'Both'){
	 			$qry_condition = "AND M.LZ_SELLER_ACCT_ID IN(1,2)";
	 			$this->session->set_userdata('awt', $awt_radio);

	 		}
	 		$query = $this->db->query($main_query." ".$qry_condition." ORDER BY D.PAID_ON_DATE ASC");

			return $query->result_array();

			
	 	}		
	 	public function dataRadio($awt_radio){
			//$main_query = "select t.* from view_lz_listing_revised t";
			$main_query = "select sum(d.total_price) as Total_Sale_Price, sum(total_price) as TOTAL_PRICE,sum(d.shipping_charges) as TOTAL_SHIPPING_FEE, sum(d.quantity) as TOTAL_QUANTITY from LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (UPPER(d.orderstatus) <> 'CANCELLED' or d.orderstatus is null) and d.tracking_number is null";
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
	 	public function getAccount(){
	 		$query = $this->db->query("SELECT S.LZ_SELLER_ACCT_ID,S.SELL_ACCT_DESC FROM LZ_SELLER_ACCTS S WHERE S.ACTIVE_SELLER = 1 AND S.PORTAL_ID = 1 ORDER BY S.LZ_SELLER_ACCT_ID ASC");
			return $query->result_array();
	 	}		



		
	}

 ?>