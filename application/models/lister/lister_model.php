<?php 

	class Lister_Model extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	 	public function ListerUsers(){
	  	$query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.STATUS =1 ");

	  	//var_dump($query->result_array());exit;
	  	return $query->result_array();
	 	}

	public function listing_data(){
	 $requestData= $_REQUEST;
	 $columns = array( 
      0 =>'EBAY_ITEM_DESC',
      1 =>'USER_NAME',
      2 =>'',
      3 =>'EBAY_ITEM_ID',
      4 =>'LIST_PRICE',
      5 =>'LIST_QTY',
      6 =>'',
      7 =>'LZ_SELLER_ACCT_ID'
    );
	
  
    $sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID, T.LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID IS NOT NULL ";

     if(!empty($requestData['search']['value'])) {
     // if there is a search parameter, $requestData['search']['value'] contains search parameter
	      $sql.=" AND (T.EBAY_ITEM_DESC LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR E.USER_NAME LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR T.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR T.LIST_PRICE LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR T.LIST_QTY LIKE '%".$requestData['search']['value']."%' ";   
          $sql.=" OR T.LZ_SELLER_ACCT_ID LIKE '%".$requestData['search']['value']."%') "; 
	  }
	  $sql.= " ORDER BY T.LIST_DATE DESC";
		$query = $this->db->query($sql);
	    $totalData = $query->num_rows();
	    $totalFiltered = $totalData; 
	    
	    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
	    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
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
	      
	      $nestedData[] 	= $row['EBAY_ITEM_DESC'];
	      $nestedData[] 	= ucfirst($row['USER_NAME']);
	      $td 				= $row['LIST_DATE'];
	      $nestedData[] 	= $td;
	      $nestedData[] 	= '<a target="_blank" href="'.$row['EBAY_URL'].'">'.$row['EBAY_ITEM_ID'].'</a>';
	      $list_price 		= @$row['LIST_PRICE'];
	      $nestedData[] 	= '$ '.number_format((float)@$list_price,2,'.',',');
	      $nestedData[] 	= ucfirst($row['LIST_QTY']);
	      		date_default_timezone_set('America/Chicago');
	            $current_timestamp = date('Y-m-d h:i:s', time());
	            //var_dump($td);exit;
	            $td_rs = date('Y-m-d h:i:s', strtotime($td));
	            // $td = create_date('Y-m-d h:i:s', time());
	            $date1=date_create($current_timestamp);
	            $date2=date_create($td_rs);
	            $diff=date_diff($date1,$date2);
	            $date_rslt = $diff->format("%R%a days");
	 
	      $nestedData[] 	= abs($date_rslt)." Days";
	      $account_name 	= $row['LZ_SELLER_ACCT_ID'];
	            if($account_name == 2){
	              $nestedData[] = "Dfwonline";
	            }else{
	              $nestedData[] = "Techbargain";
	            } 
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

	 	public function sum_total_listing(){
			//$sum_listing = $this->db->query("select count(t.item_id) as TOTAL_LISTING,sum(t.list_price) as TOTAL_PRICE from ebay_list_mt t where  t.lz_seller_acct_id is not null");
			$sum_listing = $this->db->query("SELECT COUNT(1) AS TOTAL_LISTING, SUM(LIST_AMT) AS TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL GROUP BY E.EBAY_ITEM_ID) IN_QRY");

			//var_dump($sum_listing->result_array());exit;
			
			return $sum_listing->result_array();	 		
	 	}

	 	public function search_lister($lister_radio,$user_id,$from,$to){
			 $requestData= $_REQUEST;
			 $columns = array( 
		      0 =>'EBAY_ITEM_DESC',
		      1 =>'USER_NAME',
		      2 =>'',
		      3 =>'EBAY_ITEM_ID',
		      4 =>'LIST_PRICE',
		      5 =>'LIST_QTY',
		      6 =>'',
		      7 =>'LZ_SELLER_ACCT_ID'
		    );
			if($user_id !== "All" && $user_id !== "PK" && $user_id !== "US"){
			$sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID, T.LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID IS NOT NULL AND T.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS') AND T.LISTER_ID = '$user_id'";
			
		}elseif($user_id == "US"){

			$sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID, T.LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID IS NOT NULL AND T.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS') AND T.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US')";
		}
		elseif($user_id == "PK"){
			$sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID, T.LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID IS NOT NULL AND T.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS') AND T.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK')";
		}else{
			$sql = "SELECT T.ITEM_ID, T.LZ_MANIFEST_ID, TO_CHAR(T.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') AS LIST_DATE, T.LISTER_ID, E.USER_NAME, T.EBAY_ITEM_DESC, T.LIST_QTY, T.EBAY_ITEM_ID, T.LIST_PRICE, T.LZ_SELLER_ACCT_ID, L.EBAY_URL FROM EBAY_LIST_MT T, EMPLOYEE_MT E,LZ_LISTED_ITEM_URL L WHERE T.LISTER_ID = E.EMPLOYEE_ID AND T.EBAY_ITEM_ID=L.EBAY_ID AND T.LZ_SELLER_ACCT_ID IS NOT NULL AND T.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS') AND T.LISTER_ID IN (4,5,13,14,16,2,18,21,22,23,24,25,26)";
			
		}
			$lister_radio == 'Both';
			$qry_condition = "";
	 		if($lister_radio == 2){
	 			$sql .= " AND T.LZ_SELLER_ACCT_ID =2";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 1){
	 			$sql .= " AND T.LZ_SELLER_ACCT_ID =1";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 'Both'){
	 			$sql .= "AND T.LZ_SELLER_ACCT_ID IN(1,2)";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}
	 		if(!empty($requestData['search']['value'])) {
	      $sql.=" AND (T.EBAY_ITEM_DESC LIKE '%".$requestData['search']['value']."%'";
	      $sql.=" OR E.USER_NAME LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR T.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR T.LIST_PRICE LIKE '%".$requestData['search']['value']."%' ";   
	      $sql.=" OR T.LIST_QTY LIKE '%".$requestData['search']['value']."%' ";   
          $sql.=" OR T.LZ_SELLER_ACCT_ID LIKE '%".$requestData['search']['value']."%') "; 
	  }
	  $sql.= "  ORDER BY T.LIST_DATE DESC";
		$query = $this->db->query($sql);
	    $totalData = $query->num_rows();
	    $totalFiltered = $totalData; 
	    
	    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
	    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
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
	      
	      $nestedData[] 	= $row['EBAY_ITEM_DESC'];
	      $nestedData[] 	= ucfirst($row['USER_NAME']);
	      $td 				= $row['LIST_DATE'];
	      $nestedData[] 	= $td;
	      $nestedData[] 	= '<a target="_blank" href="'.$row['EBAY_URL'].'">'.$row['EBAY_ITEM_ID'].'</a>';
	      $list_price 		= @$row['LIST_PRICE'];
	      $nestedData[] 	= '$ '.number_format((float)@$list_price,2,'.',',');
	      $nestedData[] 	= ucfirst($row['LIST_QTY']);
      		date_default_timezone_set('America/Chicago');
            $current_timestamp = date('Y-m-d h:i:s', time());
            //var_dump($td);exit;
            $td_rs = date('Y-m-d h:i:s', strtotime($td));
            // $td = create_date('Y-m-d h:i:s', time());
            $date1=date_create($current_timestamp);
            $date2=date_create($td_rs);
            $diff=date_diff($date1,$date2);
            $date_rslt = $diff->format("%R%a days");
 
	      $nestedData[] 	= abs($date_rslt)." Days";
	      $account_name 	= $row['LZ_SELLER_ACCT_ID'];
	            if($account_name == 2){
	              $nestedData[] = "Dfwonline";
	            }else{
	              $nestedData[] = "Techbargain";
	            } 
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

		public function radio_lister($lister_radio,$user_id,$from,$to){

			if($user_id !== "All" && $user_id !== "PK" && $user_id !== "US"){

				$main_query = "SELECT COUNT(1) AS TOTAL_LISTING, SUM(LIST_AMT) AS TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID = '$user_id' AND E.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";

			}elseif($user_id == "PK"){
				$main_query = "SELECT COUNT(1) AS TOTAL_LISTING, SUM(LIST_AMT) AS TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK') AND E.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			}elseif($user_id == "US"){
				$main_query = "SELECT COUNT(1) AS TOTAL_LISTING, SUM(LIST_AMT) AS TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US') AND E.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			}elseif($user_id == "All"){
				$main_query = "SELECT COUNT(1) AS TOTAL_LISTING, SUM(LIST_AMT) AS TOTAL_PRICE FROM ( SELECT E.EBAY_ITEM_ID, SUM(E.LIST_QTY * E.LIST_PRICE) LIST_AMT FROM EBAY_LIST_MT E WHERE E.LZ_SELLER_ACCT_ID IS NOT NULL AND E.LISTER_ID IN (4,5,13,14,16,2,18,21,22,23,24,25,26) AND E.LIST_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			}
			$qry_condition = "";
	 		if($lister_radio == 2){
	 			$qry_condition = " AND E.LZ_SELLER_ACCT_ID =2";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 1){
	 			$qry_condition = " AND E.LZ_SELLER_ACCT_ID =1";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}elseif($lister_radio == 'Both'){
	 			$qry_condition = "AND E.LZ_SELLER_ACCT_ID IN(1,2)";
	 			$this->session->set_userdata('lister', $lister_radio);

	 		}
	 		$query = $this->db->query( $main_query." ".$qry_condition."GROUP BY E.EBAY_ITEM_ID ORDER BY E.LIST_DATE DESC)");

			return $query->result_array();	 		

	 	}	 	

}




 ?>