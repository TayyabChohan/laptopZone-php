<?php 

	/**
	* Shipment Model
	*/
	class Paid_Shipped extends CI_Model
	{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
		public function pd_shipped()
		{
			return $this->db->query("SELECT TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE,D.SALES_RECORD_NUMBER,D.ITEM_TITLE,D.ITEM_ID,D.BUYER_EMAIL,D.USER_ID,D.QUANTITY,D.SALE_PRICE,D.TOTAL_PRICE,D.PAYPAL_PER_TRANS_FEE,D.EBAY_FEE_PERC, D.BUYER_CHECKOUT_MSG FROM LZ_SALESLOAD_MT M,LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (D.ORDERSTATUS <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NOT NULL AND M.LZ_SELLER_ACCT_ID IN(1,2) ORDER BY D.SALES_RECORD_NUMBER DESC");
		}

		public function loadPaidShipped()
		{
			$requestData= $_REQUEST;
			$columns = array( 
		      0 =>'SALES_RECORD_NUMBER',
		      1 =>'ITEM_TITLE',
		      2 =>'ITEM_ID',
		      3 =>'USER_ID',
		      4 =>'QUANTITY',
		      5 =>'SALE_PRICE',
		      6 =>'TOTAL_PRICE',
		      7 =>'EBAY_FEE_PERC',
		      8 =>'PAYPAL_PER_TRANS_FEE',
		      9 =>'SALE_DATE',
		      10 =>'PAID_ON_DATE',
		      11 =>'BUYER_CHECKOUT_MSG'
		    );
		    $sql = "SELECT TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE,D.SALES_RECORD_NUMBER,D.ITEM_TITLE,D.ITEM_ID,D.BUYER_EMAIL,D.USER_ID,D.QUANTITY,D.SALE_PRICE,D.TOTAL_PRICE,D.PAYPAL_PER_TRANS_FEE,D.EBAY_FEE_PERC, D.BUYER_CHECKOUT_MSG FROM LZ_SALESLOAD_MT M,LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (D.ORDERSTATUS <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NOT NULL AND M.LZ_SELLER_ACCT_ID IN(1,2) AND D.SALE_DATE >= sysdate -3";

     if(!empty($requestData['search']['value'])) {
     	$search_value = $requestData['search']['value'];
     // if there is a search parameter, $requestData['search']['value'] contains search parameter
	      $sql.=" AND (D.SALES_RECORD_NUMBER LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR D.ITEM_TITLE LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.ITEM_ID LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.USER_ID LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.QUANTITY LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.TOTAL_PRICE LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.EBAY_FEE_PERC LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.PAYPAL_PER_TRANS_FEE LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR D.SALE_DATE BETWEEN TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS') AND
       					TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS')";
       		   $sql.=" OR D.PAID_ON_DATE BETWEEN TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS') AND
       					TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS') ";    
	   
        $sql.=" OR D.BUYER_CHECKOUT_MSG LIKE '%".$requestData['search']['value']."%') "; 
	  }
	$sql." ORDER BY D.SALES_RECORD_NUMBER DESC";
	$query = $this->db->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData; 
 
    $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data = array();
    $i =0;
    foreach($query as $row ){ 
      $nestedData=array();
       if(!empty(@$row['BUYER_CHECKOUT_MSG'])){
       	$textClass =  "class='buyer-txt'";
       }else{
       	$textClass =  "";
       }
      $nestedData[] = $textClass.$row['SALES_RECORD_NUMBER'];

      $nestedData[] 	= $row['ITEM_TITLE'];
      $nestedData[] 	= $row['ITEM_ID'] ;
      $nestedData[] 	= $row['USER_ID'].'/'.$row['BUYER_EMAIL'];
      $nestedData[] 	= $row['QUANTITY'];

      $sale_price 		= $row['SALE_PRICE'];
      $nestedData[] 	= '$ '.number_format((float)@$sale_price,2,'.',',');

      $total_price 		= $row['TOTAL_PRICE'];
      $nestedData[] 	= '$ '.number_format((float)@$total_price,2,'.',',');

      $ebay_fee 		= $row['EBAY_FEE_PERC'];
      $nestedData[] 	= '$ '.number_format((float)@$ebay_fee,2,'.',',');

      $paypal_fee 		= $row['PAYPAL_PER_TRANS_FEE'];
      $nestedData[] 	= '$ '.number_format((float)@$paypal_fee,2,'.',',');

      $nestedData[] 	= $row['SALE_DATE'];
      $nestedData[] 	= $row['PAID_ON_DATE'];
      $nestedData[] 	= $row['BUYER_CHECKOUT_MSG'];
      $data[] 			  = $nestedData;
      $i++;
    }

    $json_data = array(
          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"    =>  intval($totalData),  // total number of records
          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"    =>  intval( $totalFiltered ),
          "data"            => $data   // total data array
          );
    return $json_data; 

		}
		public function paidRadio($paid_btn_radio,$from,$to){

			$main_query = "SELECT SUM(D.TOTAL_PRICE) AS TOTAL_SALE_PRICE, SUM(D.EBAY_FEE_PERC) AS TOTAL,SUM(D.SHIPPING_CHARGES) AS TOTAL_SHIPPING_FEE,SUM(PAYPAL_PER_TRANS_FEE) AS PAYPAL_FEE FROM (SELECT TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE,D.SALES_RECORD_NUMBER,D.ITEM_TITLE,D.ITEM_ID,D.BUYER_EMAIL,D.USER_ID,D.QUANTITY,D.SALE_PRICE,D.TOTAL_PRICE,D.PAYPAL_PER_TRANS_FEE,D.EBAY_FEE_PERC,D.SHIPPING_CHARGES FROM LZ_SALESLOAD_MT M,LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (D.ORDERSTATUS <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NOT NULl";
			$date_qry = " AND D.SALE_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			
			$qry_condition = "";

	 		if($paid_btn_radio == 2){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID =2";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}elseif($paid_btn_radio == 1){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID =1";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}elseif($paid_btn_radio == 'Both'){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID IN(1,2)";
	 			$this->session->set_userdata('paid', $paid_btn_radio);
	 		}
	 		$query = $this->db->query( $main_query." ".$date_qry." ".$qry_condition .") D");

	 		return $query->result_array();
	 	}		
		public function loadPaidSearch(){
		$requestData= $_REQUEST;
			$columns = array( 
		      0 =>'SALES_RECORD_NUMBER',
		      1 =>'ITEM_TITLE',
		      2 =>'ITEM_ID',
		      3 =>'USER_ID',
		      4 =>'QUANTITY',
		      5 =>'SALE_PRICE',
		      6 =>'TOTAL_PRICE',
		      7 =>'EBAY_FEE_PERC',
		      8 =>'PAYPAL_PER_TRANS_FEE',
		      9 =>'SALE_DATE',
		      10 =>'PAID_ON_DATE',
		      11 =>'BUYER_CHECKOUT_MSG'
		    );
        $rslt 				= $this->session->userdata('date_range');
        $paid_btn_radio 	= $this->session->userdata('paid');

        $rs 				= explode('-',$rslt);
        $fromdate 			= $rs[0];
        $todate 			= $rs[1];
        /*===Convert Date in 24-Apr-2016===*/
        $fromdate 			= date_create($rs[0]);
        $todate 			= date_create($rs[1]);

        $from 				= date_format($fromdate,'d-m-y');
        $to 				= date_format($todate, 'd-m-y');
		//var_dump($paid_btn_radio, $from, $to); exit;
        $sql = "SELECT TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE,D.SALES_RECORD_NUMBER,D.ITEM_TITLE,D.ITEM_ID,D.BUYER_EMAIL,D.USER_ID,D.QUANTITY,D.SALE_PRICE,D.TOTAL_PRICE,D.PAYPAL_PER_TRANS_FEE,D.EBAY_FEE_PERC, D.BUYER_CHECKOUT_MSG FROM LZ_SALESLOAD_MT M,LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (D.ORDERSTATUS <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NOT NULL";
        	if (!empty($from) || !empty($to)) {
        		$sql .= " AND D.SALE_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
        	}
			
	 		if($paid_btn_radio == 2){
	 			$sql .= " AND M.LZ_SELLER_ACCT_ID =2";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}elseif($paid_btn_radio == 1){
	 			$sql .= " AND M.LZ_SELLER_ACCT_ID =1";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}elseif($paid_btn_radio == 'Both'){
	 			$sql .= " AND M.LZ_SELLER_ACCT_ID IN(1,2)";
	 			$this->session->set_userdata('paid', $paid_btn_radio);
	 		}

	 		if(!empty($requestData['search']['value'])) {
	 			$search_value = $requestData['search']['value'];
     		  // if there is a search parameter, $requestData['search']['value'] contains search parameter
		      $sql.=" AND (D.SALES_RECORD_NUMBER LIKE '%".$requestData['search']['value']."%'";
		      $sql.=" OR D.ITEM_TITLE LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.ITEM_ID LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.USER_ID LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.QUANTITY LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.TOTAL_PRICE LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.EBAY_FEE_PERC LIKE '%".$requestData['search']['value']."%' ";   
		      $sql.=" OR D.PAYPAL_PER_TRANS_FEE LIKE '%".$requestData['search']['value']."%' ";   
		     $sql.=" OR D.SALE_DATE BETWEEN TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS') AND
       					TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS')";
       		   $sql.=" OR D.PAID_ON_DATE BETWEEN TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS') AND
       					TO_DATE('$search_value ', 'DD-MM-YY HH24:MI:SS') "; 
	          $sql.=" OR D.BUYER_CHECKOUT_MSG LIKE '%".$requestData['search']['value']."%' )"; 
	  	}
	$sql." ORDER BY D.PAID_ON_DATE ASC";
	$query = $this->db->query($sql);
    $totalData = $query->num_rows();
    $totalFiltered = $totalData; 
 
    $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data = array();
    $i =0;
    foreach($query as $row ){ 
      $nestedData=array();
       if(!empty(@$row['BUYER_CHECKOUT_MSG'])){
       	$textClass =  "class='buyer-txt'";
       }else{
       	$textClass =  "";
       }
      $nestedData[] = $textClass.$row['SALES_RECORD_NUMBER'];

      $nestedData[] 	= $row['ITEM_TITLE'];
      $nestedData[] 	= $row['ITEM_ID'] ;
      $nestedData[] 	= $row['USER_ID'].'/'.$row['BUYER_EMAIL'];
      $nestedData[] 	= $row['QUANTITY'];

      $sale_price 		= $row['SALE_PRICE'];
      $nestedData[] 	= '$ '.number_format((float)@$sale_price,2,'.',',');

      $total_price 		= $row['TOTAL_PRICE'];
      $nestedData[] 	= '$ '.number_format((float)@$total_price,2,'.',',');

      $ebay_fee 		= $row['EBAY_FEE_PERC'];
      $nestedData[] 	= '$ '.number_format((float)@$ebay_fee,2,'.',',');

      $paypal_fee 		= $row['PAYPAL_PER_TRANS_FEE'];
      $nestedData[] 	= '$ '.number_format((float)@$paypal_fee,2,'.',',');

      $nestedData[] 	= $row['SALE_DATE'];
      $nestedData[] 	= $row['PAID_ON_DATE'];
      $nestedData[] 	= $row['BUYER_CHECKOUT_MSG'];
      $data[] 			  = $nestedData;
      $i++;
    }
 		////$this->session->unset_userdata('date_range');
 		////$this->session->unset_userdata('paid');
    	$json_data = array(
	          "draw"            => intval($requestData['draw']),   
	          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	          "recordsTotal"    =>  intval($totalData),  
	          // total number of records
	          "recordsFiltered" => intval($totalFiltered ), 
	          // total number of records after searching, if there is no searching then totalFiltered = totalData
	          "deferLoading"    =>  intval($totalFiltered ),
	          "data"            => $data   // total data array
          );
    	return $json_data;
    
		}
	 	public function dataRadio($paid_btn_radio,$from,$to){

			$main_query = "SELECT TO_CHAR(D.SALE_DATE, 'DD-MM-YYYY HH24:MI:SS') AS SALE_DATE, TO_CHAR(D.PAID_ON_DATE, 'DD-MM-YYYY HH24:MI:SS') AS PAID_ON_DATE,D.SALES_RECORD_NUMBER,D.ITEM_TITLE,D.ITEM_ID,D.BUYER_EMAIL,D.USER_ID,D.QUANTITY,D.SALE_PRICE,D.TOTAL_PRICE,D.PAYPAL_PER_TRANS_FEE,D.EBAY_FEE_PERC FROM LZ_SALESLOAD_MT M,LZ_SALESLOAD_DET D WHERE M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND (D.ORDERSTATUS <> 'CANCELLED' OR D.ORDERSTATUS IS NULL) AND D.TRACKING_NUMBER IS NOT NULL";

			$date_qry = "AND D.SALE_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			$qry_condition = "";
	 		if($paid_btn_radio == 2){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID =2";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}elseif($paid_btn_radio == 1){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID =1";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}elseif($paid_btn_radio == 'Both'){
	 			$qry_condition = " AND M.LZ_SELLER_ACCT_ID IN(1,2)";
	 			$this->session->set_userdata('paid', $paid_btn_radio);

	 		}
	 		$query = $this->db->query( $main_query." ".$date_qry. " ".$qry_condition." ORDER BY D.PAID_ON_DATE ASC");

	 		return $query->result_array();
	 	}

		public function sum_total_ebay(){

			$sum_ebay = $this->db->query("select sum(d.total_price) as Total_Sale_Price, sum(d.ebay_fee_perc) as Total,sum(d.shipping_charges) as TOTAL_SHIPPING_FEE,sum(paypal_per_trans_fee) as paypal_fee FROM  LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (d.orderstatus <> 'Cancelled' or d.orderstatus is null) and d.tracking_number is not null and m.lz_seller_acct_id in (1, 2)");

			return $sum_ebay->result_array();			
		}
		
	}
 ?>