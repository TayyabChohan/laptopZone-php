<?php  

	class M_priceVerify extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	 	
	public function default_view(){
		// $from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
		// $to = date('m/d/Y');
		// $rslt =$from." - ".$to;
		// $this->session->set_userdata('date_range', $rslt);
		// $fromdate = date_create($from);
		// $todate = date_create($to);
		// $from = date_format($fromdate,'d-m-y');
		// $to = date_format($todate, 'd-m-y');

		//$detail_qry = $this->db2->query("SELECT A.*, Q1.MPN, Q1.MPN_DESCRIPTION, Q1.CATEGORY_ID FROM MPN_AVG_PRICE A, LZ_BD_RSS_FEED_URL U, (SELECT C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, COUNT(1) FROM LZ_BD_RSS_FEED_URL M, LZ_CATALOGUE_MT C WHERE  C.CATALOGUE_MT_ID =M.CATLALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID) Q1 WHERE A.CATALOGUE_MT_ID =U.CATLALOGUE_MT_ID AND U.CONDITION_ID = A.CONDITION_ID AND Q1.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID");
		$detail_qry = $this->db2->query("SELECT A.*, Q1.MPN, Q1.MPN_DESCRIPTION, Q1.CATEGORY_ID,U.KEYWORD FROM MPN_AVG_PRICE_TMP A, LZ_BD_RSS_FEED_URL U, (SELECT C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, COUNT(1) FROM LZ_BD_RSS_FEED_URL M, LZ_CATALOGUE_MT C WHERE  C.CATALOGUE_MT_ID =M.CATLALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID) Q1 WHERE A.CATALOGUE_MT_ID =U.CATLALOGUE_MT_ID AND U.CONDITION_ID = A.CONDITION_ID AND Q1.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID");
	  	$detail_qry = $detail_qry->result_array();

	 // var_dump($detail_qry);exit;
        return $detail_qry;
	}
	public function qty_detail(){
      $category_id = $this->input->post("category_id");
      $catalogue_mt_id = $this->input->post("catalogue_mt_id");
      $condition_id = $this->input->post("condition_id");
      $qty_det = $this->db2->query("SELECT D.LZ_BD_CATA_ID, D.EBAY_ID, D.TITLE, D.CONDITION_NAME, D.SALE_PRICE, D.SHIPPING_COST, TO_CHAR(D.START_TIME, 'MM/DD/YYYY HH24:MI:SS') AS START_TIME, TO_CHAR(D.SALE_TIME, 'MM/DD/YYYY HH24:MI:SS') AS SALE_TIME, D.SELLER_ID, D.CATEGORY_ID, D.CATALOGUE_MT_ID,D.LISTING_TYPE ,D.CONDITION_ID ,C.MPN, C.MPN_DESCRIPTION,P.AVG_PRICE,P.QTY_SOLD FROM LZ_BD_CATAG_DATA_$category_id D, LZ_CATALOGUE_MT C , MPN_AVG_PRICE_TMP P WHERE D.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND D.SALE_TIME >= SYSDATE - 90 AND D.VERIFIED = 1 AND D.MANUAL_VERIFIED = 0 AND D.IS_DELETED = 0 AND D.CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE(UPPER(D.TITLE), 'LOT|PCS|PIECE|EACH') AND D.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID AND D.CONDITION_ID = P.CONDITION_ID AND D.CATALOGUE_MT_ID = $catalogue_mt_id AND D.CONDITION_ID = $condition_id")->result_array();
       
      return $qty_det;
    }
    public function remove_row(){
      $category_id = $this->input->post("category_id");
      $catalogue_mt_id = $this->input->post("mpn_id");
      $condition_id = $this->input->post("condition_id");
      $lz_bd_cata_id = $this->input->post("lz_bd_cata_id");
      $lz_bd_cata_id = join(', ', $lz_bd_cata_id);
//var_dump($lz_bd_cata_id);exit;


      $remove_qry = $this->db2->query("UPDATE LZ_BD_CATAG_DATA_$category_id SET IS_DELETED = 1 WHERE LZ_BD_CATA_ID IN ($lz_bd_cata_id)");

      $this->db2->query("UPDATE MPN_AVG_PRICE_TMP T SET (T.AVG_PRICE, T.MIN_PRICE, T.MAX_PRICE, T.QTY_SOLD, T.TRUNOVER_UNIT, T.TURNOVER_VALUE, T.SOLD_FROM, T.SOLD_TO, T.TURNOVER_DAYS, T.LAST_VERIFIED_DATE) = (SELECT ROUND(AVG(SALE_PRICE + SHIPPING_COST), 2) AVG_PRICE, MIN(SALE_PRICE) MIN_PRICE, MAX(SALE_PRICE) MAX_PRICE, COUNT(C.LZ_BD_CATA_ID) QTY_SOLD, ROUND(COUNT(C.LZ_BD_CATA_ID) / 90, 2) TRUNOVER_UNIT, ROUND(SUM(SALE_PRICE) / 90, 2) TURNOVER_VALUE, MIN(SALE_TIME) SOLD_FROM, MAX(SALE_TIME) SOLD_TO, ROUND(MAX(C.SALE_TIME) - MIN(C.SALE_TIME)) TURNOVER_DAYS, MAX(VERIFIED_DATE) LAST_VERIFIED_DATE FROM LZ_BD_CATAG_DATA_$category_id C WHERE SALE_TIME >= SYSDATE - 90 AND VERIFIED=1 AND CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE (UPPER(TITLE) , 'LOT|PCS|PIECE|EACH') AND LOTSONLY = 0 AND IS_DELETED = 0 AND C.CATALOGUE_MT_ID = $catalogue_mt_id AND C.CONDITION_ID = $condition_id GROUP BY CATALOGUE_MT_ID, CONDITION_ID) WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id AND T.CONDITION_ID = $condition_id");

      $select_qry = $this->db2->query("SELECT T.AVG_PRICE,T.QTY_SOLD,T.AVG_PRICE*T.QTY_SOLD TOTAL_VALUE FROM MPN_AVG_PRICE_TMP T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id AND T.CONDITION_ID = $condition_id")->result_array();
      	if($select_qry){
      		return $select_qry;
      	}else{
      		return 0;
      	}
        
	}    
	public function fav_supplier(){
      $supplier_name = $this->input->post("seller_id");
      $seller_type = $this->input->post("seller_type");
//var_dump($supplier_name,$seller_type);exit;
     
      $remove_qry = $this->db2->query("SELECT * FROM SUPPLIER_MT@ORASERVER WHERE UPPER(COMPANY_NAME) = UPPER('$supplier_name')");
       if($remove_qry->num_rows() > 0){
       	$this->db2->query("UPDATE SUPPLIER_MT@ORASERVER SET SUPPLIER_TYPE = '$seller_type' WHERE UPPER(COMPANY_NAME) = UPPER('$supplier_name')");
       	return 0;
       }else{

		  $sql = "SELECT GET_SINGLE_PRIMARY_KEY@ORASERVER('SUPPLIER_MT','SUPPLIER_ID') SUPPLIER_ID FROM DUAL";
	      $query = $this->db2->query($sql);
	      $query = $query->result_array();
	      $supplier_id = $query[0]['SUPPLIER_ID'];

	      // $sql = "SELECT GET_SINGLE_PRIMARY_KEY@ORASERVER('SUPPLIER_MT','SUPPLIER_CODE') SUPPLIER_CODE FROM DUAL";
	      // $query = $this->db2->query($sql);
	      // $query = $query->result_array();
	      //$supplier_code = $query[0]['SUPPLIER_CODE'];
	      $supplier_code = $supplier_id;

       	$this->db2->query("INSERT INTO SUPPLIER_MT@ORASERVER (SUPPLIER_ID, SUPPLIER_CODE, COMPANY_NAME, SHORT_DESC, STAX_REG_NO, NTN_NO, SUPP_GRADE_ID, SUPP_SECTOR_ID, SUPP_CATAG_ID, URL, TAX_EXEMPT_YN, REGULAR_SUPPLIER_YN, DEF_ACCT_SETTLEMENT, SUPP_TAX_CAT_ID, ENTERED_DATE_TIME, LAST_EDITED_DATE_TIME, GROUP_SUPPLIER_ID,SUPPLIER_TYPE)VALUES($supplier_id,$supplier_code,'$supplier_name','$supplier_name', NULL, NULL, NULL, NULL, 1, NULL, 1, 0, 1, 1, NULL, NULL,NULL,$seller_type)"); 
       	return 1;
       }

	}
	  public function verify_price(){
	      $category_id = $this->input->post("category_id");
	      $catalogue_mt_id = $this->input->post("mpn_id");
	      $condition_id = $this->input->post("condition_id");

	      //$qty_det = $this->db2->query("SELECT D.LZ_BD_CATA_ID FROM LZ_BD_CATAG_DATA_$category_id D, LZ_CATALOGUE_MT C WHERE D.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND D.SALE_TIME >= SYSDATE - 90 AND D.VERIFIED = 1 AND D.MANUAL_VERIFIED = 0 AND D.IS_DELETED = 0 AND D.CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE(UPPER(D.TITLE), 'LOT|PCS|PIECE|EACH') AND D.CATALOGUE_MT_ID = $catalogue_mt_id AND D.CONDITION_ID = $condition_id")->result_array();

	      $verified_by = $this->session->userdata('user_id');
		  date_default_timezone_set("America/Chicago");
		  $verified_date = date("Y-m-d H:i:s");
		  $verified_date= "TO_DATE('".$verified_date."', 'YYYY-MM-DD HH24:MI:SS')";
		  // foreach ($qty_det as $value){
		  // 	$remove_qry = $this->db2->query("UPDATE LZ_BD_CATAG_DATA_$category_id SET MANUAL_VERIFIED = 1, VERIFIED_BY = $verified_by, VERIFIED_DATE = $verified_date WHERE LZ_BD_CATA_ID = ".$value['LZ_BD_CATA_ID']);
		  // }


		  /*====================================
		  =            verify price            =
		  ====================================*/
		  $update_qry = $this->db2->query("UPDATE LZ_BD_CATAG_DATA_$category_id SET MANUAL_VERIFIED = 1, VERIFIED_BY = $verified_by, VERIFIED_DATE = $verified_date WHERE LZ_BD_CATA_ID IN (SELECT D.LZ_BD_CATA_ID FROM LZ_BD_CATAG_DATA_$category_id D WHERE D.SALE_TIME >= SYSDATE - 90 AND D.VERIFIED = 1 AND D.MANUAL_VERIFIED = 0 AND D.IS_DELETED = 0 AND D.CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE(UPPER(D.TITLE), 'LOT|PCS|PIECE|EACH') AND D.CATALOGUE_MT_ID = $catalogue_mt_id AND D.CONDITION_ID = $condition_id)");

		  /*=====  End of verify price  ======*/
		  
		  /*=========================================================
		  =            update price in mpn_avg_price_tmp            =
		  =========================================================*/
		  $this->db2->query("UPDATE MPN_AVG_PRICE_TMP T SET (T.AVG_PRICE, T.MIN_PRICE, T.MAX_PRICE, T.QTY_SOLD, T.TRUNOVER_UNIT, T.TURNOVER_VALUE, T.SOLD_FROM, T.SOLD_TO, T.TURNOVER_DAYS, T.LAST_VERIFIED_DATE) = (SELECT ROUND(AVG(SALE_PRICE + SHIPPING_COST), 2) AVG_PRICE, MIN(SALE_PRICE) MIN_PRICE, MAX(SALE_PRICE) MAX_PRICE, COUNT(C.LZ_BD_CATA_ID) QTY_SOLD, ROUND(COUNT(C.LZ_BD_CATA_ID) / 90, 2) TRUNOVER_UNIT, ROUND(SUM(SALE_PRICE) / 90, 2) TURNOVER_VALUE, MIN(SALE_TIME) SOLD_FROM, MAX(SALE_TIME) SOLD_TO, ROUND(MAX(C.SALE_TIME) - MIN(C.SALE_TIME)) TURNOVER_DAYS, MAX(VERIFIED_DATE) LAST_VERIFIED_DATE FROM LZ_BD_CATAG_DATA_$category_id C WHERE SALE_TIME >= SYSDATE - 90 AND  VERIFIED=1 AND CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE (UPPER(TITLE) , 'LOT|PCS|PIECE|EACH') AND LOTSONLY = 0 AND IS_DELETED = 0 AND C.CATALOGUE_MT_ID = $catalogue_mt_id AND C.CONDITION_ID = $condition_id GROUP BY CATALOGUE_MT_ID, CONDITION_ID) WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id AND T.CONDITION_ID = $condition_id");

		  /*=====  End of update price in mpn_avg_price_tmp  ======*/
		  
         return $update_qry;
	}


  public function loadData(){
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'',
			1 =>'CATEGORY_ID',
			2 =>'MPN',
			3 =>'CONDITION_ID', 
			4 => 'MPN_DESCRIPTION',
			5 => 'AVG_PRICE',
			6 => 'SELL_TROUGH',
			7 => 'QTY_SOLD',
			8 => '',
			9 => 'KEYWORD',
			10=> 'CREATED_BY',
			11=> 'CREATED_DATE'
		);
		
	    //$listing_qry = $this->db2->query("SELECT DISTINCT A.*, DECODE(A.TURNOVER_DAYS, 0, 0, ROUND(A.QTY_SOLD / A.TURNOVER_DAYS, 2)) SELL_TROUGH, Q1.MPN, Q1.UPC, Q1.MPN_DESCRIPTION, Q1.CATEGORY_ID, U.VERIFY_DATE, U.KEYWORD, U.FEED_URL_ID, E.USER_NAME CREATED_BY, NVL(U.UPDATE_DATE, U.CREATED_DATE) CREATED_DATE, u.verify_by FROM MPN_AVG_PRICE_TMP A, LZ_BD_RSS_FEED_URL U, EMPLOYEE_MT E, (SELECT C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC FROM LZ_BD_RSS_FEED_URL M, LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID = M.CATLALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC) Q1 WHERE A.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID AND U.CONDITION_ID = A.CONDITION_ID AND Q1.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID AND Q1.CATEGORY_ID = U.CATEGORY_ID AND NVL(NVL(U.VERIFY_BY, U.UPDATE_BY),U.CREATED_BY) = E.EMPLOYEE_ID(+) AND A.QTY_SOLD IS NOT NULL"); 
	    $listing_qry = $this->db2->query("SELECT DISTINCT A.*, '' SELL_TROUGH, Q1.MPN, Q1.UPC, Q1.MPN_DESCRIPTION, Q1.CATEGORY_ID, U.VERIFY_DATE, U.KEYWORD, E.USER_NAME CREATED_BY, NVL(U.UPDATE_DATE, U.CREATED_DATE) CREATED_DATE, U.VERIFY_BY FROM LZ_BD_API_AVG_PRICE A, (SELECT P.CATALOGUE_MT_ID , P.CONDITION_ID,MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY P.CATALOGUE_MT_ID , P.CONDITION_ID) PP, LZ_BD_RSS_FEED_URL U, EMPLOYEE_MT E, (SELECT C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC FROM LZ_BD_RSS_FEED_URL M, LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID = M.CATLALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC) Q1 WHERE A.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID AND U.CONDITION_ID = A.CONDITION_ID AND Q1.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID AND Q1.CATEGORY_ID = U.CATEGORY_ID AND NVL(NVL(U.VERIFY_BY, U.UPDATE_BY), U.CREATED_BY) = E.EMPLOYEE_ID(+) AND A.QTY_SOLD > 0 AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID ");
	    $totalData = $listing_qry->num_rows();
		// var_dump($totalData);exit;
		//$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		

		//$sql = "SELECT DISTINCT A.*, DECODE(A.TURNOVER_DAYS, 0, 0, ROUND(A.QTY_SOLD / A.TURNOVER_DAYS, 2)) SELL_TROUGH, Q1.MPN, Q1.UPC, Q1.MPN_DESCRIPTION, Q1.CATEGORY_ID, U.VERIFY_DATE, U.KEYWORD, U.FEED_URL_ID, E.USER_NAME CREATED_BY, NVL(U.UPDATE_DATE, U.CREATED_DATE) CREATED_DATE, u.verify_by FROM MPN_AVG_PRICE_TMP A, LZ_BD_RSS_FEED_URL U, EMPLOYEE_MT E, (SELECT C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC FROM LZ_BD_RSS_FEED_URL M, LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID = M.CATLALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC) Q1 WHERE A.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID AND U.CONDITION_ID = A.CONDITION_ID AND Q1.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID AND Q1.CATEGORY_ID = U.CATEGORY_ID AND NVL(NVL(U.VERIFY_BY, U.UPDATE_BY),U.CREATED_BY) = E.EMPLOYEE_ID(+) AND A.QTY_SOLD IS NOT NULL";
		$sql = "SELECT DISTINCT A.*, '' SELL_TROUGH, Q1.MPN, Q1.UPC, Q1.MPN_DESCRIPTION, Q1.CATEGORY_ID, U.VERIFY_DATE, U.KEYWORD, E.USER_NAME CREATED_BY, NVL(U.UPDATE_DATE, U.CREATED_DATE) CREATED_DATE, U.VERIFY_BY FROM LZ_BD_API_AVG_PRICE A, (SELECT P.CATALOGUE_MT_ID , P.CONDITION_ID,MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY P.CATALOGUE_MT_ID , P.CONDITION_ID) PP, LZ_BD_RSS_FEED_URL U, EMPLOYEE_MT E, (SELECT C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC FROM LZ_BD_RSS_FEED_URL M, LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID = M.CATLALOGUE_MT_ID GROUP BY C.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, C.UPC) Q1 WHERE A.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID AND U.CONDITION_ID = A.CONDITION_ID AND Q1.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID AND Q1.CATEGORY_ID = U.CATEGORY_ID AND NVL(NVL(U.VERIFY_BY, U.UPDATE_BY), U.CREATED_BY) = E.EMPLOYEE_ID(+) AND A.QTY_SOLD > 0 AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID ";
			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND (UPPER(Q1.MPN_DESCRIPTION) LIKE '%".strtoupper(trim($requestData['search']['value']))."%' ";  
				$sql.=" OR UPPER(Q1.MPN) LIKE '%".strtoupper(trim($requestData['search']['value']))."%' ";  
				$sql.=" OR  UPPER(E.USER_NAME) LIKE '".strtoupper(trim($requestData['search']['value']))."' ";
				$sql.=" OR  Q1.CATEGORY_ID LIKE '".trim($requestData['search']['value'])."' ";
				$sql.=" OR  Q1.UPC LIKE '".trim($requestData['search']['value'])."' ";
				$sql.=" OR  UPPER(U.KEYWORD) LIKE '".strtoupper(trim($requestData['search']['value']))."')";
			}


		$query = $this->db2->query($sql);
		
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		 $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		 /*================================================
		 =            for oracle 11g or bellow  it also words on 12c          =
		 ================================================*/
		 //$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];	 
		 
		 /*=====  End of for oracle 11g or bellow  ======*/
		 
		/*=======================================
		=            For Oracle 12-c            =
		=======================================*/
		$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
		/*=====  End of For Oracle 12-c  ======*/
		
		$query = $this->db2->query($sql);
		$query = $query->result_array();
		$data = array();
		$i = 1;
		foreach($query as $row ){ 
			$nestedData=array();
			$nestedData[] = "<button title='Delete Keyword' class='btn btn-danger btn-xs delFeedUrl'  id='".@$row['FEED_URL_ID']."'><i class='fa fa-trash-o text text-center' aria-hidden='true'> </i> </button>";
			$nestedData[] = $row["CATEGORY_ID"];
			if(!empty($row["LAST_VERIFIED_DATE"])){
				$verified_mpn = '<i class="fa fa-certificate"></i>';
				$bg_color = 'background-color:green;';
				$color = 'color:white;';
				$last_date = '<br><span>Last Verify Date: '.$row["LAST_VERIFIED_DATE"].'</span>';
			}else{
				$verified_mpn = '';
				$bg_color = '';
				$color = '';
				$last_date = '';
			}
			
		    $nestedData[] = '<div style="width:160px; '.$bg_color.$color.'">'.
							$row["MPN"].' '.$verified_mpn
							.$last_date.'</div>';
		    if(is_numeric($row["CONDITION_ID"])){
                if($row["CONDITION_ID"] == 3000){
                  $nestedData[] = 'Used';
                }elseif($row["CONDITION_ID"] == 1000){
                  $nestedData[] = 'New'; 
                }elseif($row["CONDITION_ID"] == 1500){
                  $nestedData[] = 'New other'; 
                }elseif($row["CONDITION_ID"]== 2000){
                    $nestedData[] = 'Manufacturer refurbished';
                }elseif($row["CONDITION_ID"] == 2500){
                  $nestedData[] = 'Seller refurbished'; 
                }elseif($row["CONDITION_ID"] == 7000){
                  $nestedData[] = 'For parts or not working'; 
                }
			}

			$nestedData[] = $row["MPN_DESCRIPTION"];
			$nestedData[] = '<b>$ '.number_format((float)@$row["AVG_PRICE_SOLD"],2,'.',',').'</b>';
			$nestedData[] =  @$row["SELL_TROUGH"] ;
			//$nestedData[] = '$ '.number_format((float)@$row["MAX_PRICE"],2,'.',',');
			//$nestedData[] = $row["QTY_SOLD"];
			$nestedData[] ="<td><button class='btn btn-xs btn-link qty_sold' id='qty_sold".$i."'>".@$row['QTY_SOLD']."</button>
        						<input type='hidden' id='category_id_".$i."' value='".$row['CATEGORY_ID']."'>
        						<input type='hidden' id='catalogue_mt_id_".$i."' value='".$row['CATALOGUE_MT_ID']."'>
        						<input type='hidden' id='condition_id_".$i."' value='".$row['CONDITION_ID']."'>
        						<input type='hidden' id='mpn_desc_".$i."' value='".$row['MPN_DESCRIPTION']."'>
        						<input type='hidden' id='avg_price_".$i."' value='".$row['AVG_PRICE_SOLD']."'>
        						<input type='hidden' id='sold_qty_".$i."' value='".$row['QTY_SOLD']."'>
        						<input type='hidden' id='keyword_".$i."' value='".$row['KEYWORD']."'>
        						<input type='hidden' id='mpn_".$i."' value='".$row['MPN']."'>
        						<input type='hidden' id='upc_".$i."' value='".$row['UPC']."'>
        					</td>";

			$nestedData[] = '$ '.number_format((float)@$row["QTY_SOLD"] * @$row["AVG_PRICE_SOLD"],2,'.',',');
			//$nestedData[] = $row["KEYWORD"];
			$verifyDate   = $row["VERIFY_DATE"];
			if (!empty($verifyDate)){
			$nestedData[] = "<button title='Edit Keyword' class='btn btn-link btn-xs editKeyword verified' id='".@$row['FEED_URL_ID']."'>".@$row['KEYWORD']."</button>";
			}else{
			$nestedData[] = "<button title='Edit Keyword' class='btn btn-link btn-xs editKeyword' id='".@$row['FEED_URL_ID']."'>".@$row['KEYWORD']."</button>";
			}
			
			$nestedData[] = $row["CREATED_BY"];
			$nestedData[] = $row["CREATED_DATE"];
			
			if (!empty($verifyDate)){
			$nestedData[] = $row["CREATED_BY"];
			}else{
			$nestedData[] = '';
			}
			$nestedData[] = $verifyDate;
			$data[] = $nestedData;
			$i++;
		}//end foreach

		$json_data = array(
					"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    =>  intval($totalData),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					//"deferLoading" =>  intval( $totalFiltered ),
					"data"            => $data   // total data array
					
					);
		return $json_data;


	}
 public function loadQtyData(){
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'',
			1 =>'EBAY_ID', 
			2 => 'TITLE',
			3 => 'CONDITION_NAME',
			4 => 'LISTING_TYPE',
			5 => 'ITEM_LOCATION',
			6 => 'SALE_PRICE',
			7 => 'SHIPPING_COST',
			8 => 'TOTAL_PRICE',
			9 => 'START_TIME',
			10 => 'SALE_TIME',
			11 => 'SELLER_ID'
		);
		
	  $category_id = $this->input->post("category_id");
      $catalogue_mt_id = $this->input->post("catalogue_mt_id");
      $condition_id = $this->input->post("condition_id");
      
      $qty_det = $this->db2->query("SELECT  D.LZ_BD_CATA_ID, D.EBAY_ID,D.ITEM_URL, D.TITLE, D.CONDITION_NAME, D.SALE_PRICE, D.SHIPPING_COST, TO_CHAR(D.START_TIME, 'MM/DD/YYYY HH24:MI:SS') AS START_TIME, TO_CHAR(D.SALE_TIME, 'MM/DD/YYYY HH24:MI:SS') AS SALE_TIME, D.SELLER_ID, D.CATEGORY_ID, D.CATALOGUE_MT_ID,D.LISTING_TYPE ,D.CONDITION_ID ,D.ITEM_LOCATION,C.MPN, C.MPN_DESCRIPTION,P.AVG_PRICE,P.QTY_SOLD, U.KEYWORD,(D.SALE_PRICE+ D.SHIPPING_COST) TOTAL_PRICE FROM LZ_BD_CATAG_DATA_$category_id D, LZ_CATALOGUE_MT C , MPN_AVG_PRICE_TMP P , LZ_BD_RSS_FEED_URL U WHERE D.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID/* AND D.SALE_TIME >= SYSDATE - 90 */AND D.VERIFIED = 1 AND D.MANUAL_VERIFIED = 0 AND D.IS_DELETED = 0 AND D.CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE(UPPER(D.TITLE), 'LOT|PCS|PIECE|EACH') AND D.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID AND D.CONDITION_ID = P.CONDITION_ID    AND D.FEED_URL_ID = U.FEED_URL_ID(+) AND C.CATALOGUE_MT_ID =  U.CATLALOGUE_MT_ID(+) AND D.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID(+) AND P.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID(+) AND D.CATALOGUE_MT_ID = $catalogue_mt_id AND D.CONDITION_ID = $condition_id");
		$totalData = $qty_det->num_rows();
		// var_dump($totalData);exit;
		//$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		

		$sql = "SELECT  D.LZ_BD_CATA_ID, D.EBAY_ID,D.ITEM_URL, D.TITLE, D.CONDITION_NAME, D.SALE_PRICE, D.SHIPPING_COST, TO_CHAR(D.START_TIME, 'MM/DD/YYYY HH24:MI:SS') AS START_TIME, TO_CHAR(D.SALE_TIME, 'MM/DD/YYYY HH24:MI:SS') AS SALE_TIME, D.SELLER_ID, D.CATEGORY_ID, D.CATALOGUE_MT_ID,D.LISTING_TYPE ,D.CONDITION_ID ,D.ITEM_LOCATION ,C.MPN, C.MPN_DESCRIPTION,P.AVG_PRICE,P.QTY_SOLD, U.KEYWORD ,(D.SALE_PRICE+ D.SHIPPING_COST) TOTAL_PRICE FROM LZ_BD_CATAG_DATA_$category_id D, LZ_CATALOGUE_MT C , MPN_AVG_PRICE_TMP P , LZ_BD_RSS_FEED_URL U WHERE D.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID  AND D.VERIFIED = 1 /* AND D.SALE_TIME >= SYSDATE - 90 */ AND D.MANUAL_VERIFIED = 0 AND D.IS_DELETED = 0 AND D.CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE(UPPER(D.TITLE), 'LOT|PCS|PIECE|EACH') AND D.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID AND D.CONDITION_ID = P.CONDITION_ID    AND D.FEED_URL_ID = U.FEED_URL_ID(+) AND C.CATALOGUE_MT_ID =  U.CATLALOGUE_MT_ID(+) AND D.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID(+) AND P.CATALOGUE_MT_ID = U.CATLALOGUE_MT_ID(+) AND D.CATALOGUE_MT_ID = $catalogue_mt_id AND D.CONDITION_ID = $condition_id";
		

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.=" AND ( D.TITLE LIKE '%".$requestData['search']['value']."%' ";  
				$sql.=" OR D.EBAY_ID LIKE '%".$requestData['search']['value']."%' ";  
				$sql.=" OR  D.LISTING_TYPE LIKE '".$requestData['search']['value']."' ";
				$sql.=" OR  D.SELLER_ID LIKE '".$requestData['search']['value']."')";
			}


		$query = $this->db2->query($sql);
		
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		 $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		 /*================================================
		 =            for oracle 11g or bellow  it also words on 12c          =
		 ================================================*/
		 //$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];	 
		 
		 /*=====  End of for oracle 11g or bellow  ======*/
		 
		/*=======================================
		=            For Oracle 12-c            =
		=======================================*/
		$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']." ROWS ONLY" ;
		/*=====  End of For Oracle 12-c  ======*/
		
		$query = $this->db2->query($sql);
		$query = $query->result_array();

		$data = array(); 
		$i = 1;
		foreach($query as $row ){ 
			$nestedData=array();

			$nestedData[] = '<div class="remove_row" style="float: left;padding-right: 5px;width: 100px;" id=""> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" fid="'.$row['CATEGORY_ID'].'" id="'.$row['LZ_BD_CATA_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button><button title="Mark As Lot" class="btn btn-primary btn-xs flag-lot" style="width: 25px; margin-left: 5px;" fid="'.$row['CATEGORY_ID'].'" id="'.$row['LZ_BD_CATA_ID'].'"><i class="fa fa-list-ul text text-center" aria-hidden="true"> </i> </button> <input type="checkbox" title="select to discard multiple line" class="del-checkbox" style="margin-left: 20px!important;" value="'.$row['LZ_BD_CATA_ID'].'" /></div><div id="'.$i.'" class="qty_wrap_'.$i.'" style="display:none;"> <div class="col-sm-12"></div><div class="col-sm-1 p-t-24 tag"> <div class="form-group"> <input name="lot_qty" type="number" id="lot_qty" placeholder="quantity" class="form-control"  value=""> </div> </div> <div class="col-sm-12 tag"> <div class="form-group"> <input type="button" class="btn btn-success " id="save_qty" name="save_qty" value="Save"> </div> </div></div>';

			$nestedData[] = '<a href="'.$row["ITEM_URL"].'" target="_blank">'.$row["EBAY_ID"].'</a>';
			$nestedData[] = $row["TITLE"];
			$nestedData[] = @$row["CONDITION_NAME"];
			$nestedData[] =  @$row["LISTING_TYPE"];
			$nestedData[] =  @$row["ITEM_LOCATION"];
			$nestedData[] = '$ '.number_format((float)@$row["SALE_PRICE"],2,'.',',');
			$nestedData[] = '$ '.number_format((float)@$row["SHIPPING_COST"],2,'.',',');
			//$nestedData[] = '$ '.number_format((float)@$row["SHIPPING_COST"]+@$row["SALE_PRICE"],2,'.',',');
			$nestedData[] = '<b>$ '.number_format((float)@$row["TOTAL_PRICE"],2,'.',',').'</b>';
			//$nestedData[] = $row["QTY_SOLD"];
			$nestedData[] = @$row["START_TIME"];
			$nestedData[] = @$row["SALE_TIME"];


			$nestedData[] = '<button class="btn btn-xs btn-link supplier_type" id="supplier_type" value="'.@$row["SELLER_ID"].'">'.@$row["SELLER_ID"].'</button><div class="seller_wrap_'.$i.'" style="display:none;"><div class="col-sm-12"> <div class="btn-group btn-group-horizontal" data-toggle="buttons"> <input type="radio" name="seller_type" id="seller_type" value="1" checked> <span>Lot</span> <input type="radio" name="seller_type" id="seller_type" value="2"><span>Bargain</span> </div> </div><div class="col-sm-12"> <div class="form-group"> <input type="button" class="btn btn-success " id="addSupplier" name="addSupplier" value="Save"> </div> </div></div>';
			$data[] = $nestedData;
			$i++;
		}//end foreach

		$json_data = array(
					"draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    =>  intval($totalData),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					//"deferLoading" =>  intval( $totalFiltered ),
					"data"            => $data   // total data array
					
					);
       
      return $json_data;


	}

	/*=====  End Listed Item DataTables  ======*/
public function lot_qty(){
      $category_id = $this->input->post("category_id");
      $lz_bd_cata_id = $this->input->post("lz_bd_cata_id");
      $lot_qty = $this->input->post("lot_qty");
      $total_price = $this->input->post("total_price");
      $per_unit_price = $total_price / $lot_qty;
      $per_unit_price = number_format((float)$per_unit_price,2,'.','');


      $catalogue_mt_id = $this->input->post("mpn_id");
      $condition_id = $this->input->post("condition_id");
      //var_dump($catalogue_mt_id,$condition_id);exit;

      $qty_det = $this->db2->query("UPDATE LZ_BD_CATAG_DATA_$category_id SET QUANTITY = '$lot_qty',SALE_PRICE = '$per_unit_price' , SHIPPING_COST = 0,LOTSONLY = 1 WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");

      $this->db2->query("UPDATE MPN_AVG_PRICE_TMP T SET (T.AVG_PRICE, T.MIN_PRICE, T.MAX_PRICE, T.QTY_SOLD, T.TRUNOVER_UNIT, T.TURNOVER_VALUE, T.SOLD_FROM, T.SOLD_TO, T.TURNOVER_DAYS, T.LAST_VERIFIED_DATE) = (SELECT ROUND(AVG(SALE_PRICE + SHIPPING_COST), 2) AVG_PRICE, MIN(SALE_PRICE) MIN_PRICE, MAX(SALE_PRICE) MAX_PRICE, COUNT(C.LZ_BD_CATA_ID) QTY_SOLD, ROUND(COUNT(C.LZ_BD_CATA_ID) / 90, 2) TRUNOVER_UNIT, ROUND(SUM(SALE_PRICE) / 90, 2) TURNOVER_VALUE, MIN(SALE_TIME) SOLD_FROM, MAX(SALE_TIME) SOLD_TO, ROUND(MAX(C.SALE_TIME) - MIN(C.SALE_TIME)) TURNOVER_DAYS, MAX(VERIFIED_DATE) LAST_VERIFIED_DATE FROM LZ_BD_CATAG_DATA_$category_id C WHERE SALE_TIME >= SYSDATE - 90 AND VERIFIED=1 AND CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE (UPPER(TITLE) , 'LOT|PCS|PIECE|EACH') AND LOTSONLY = 0 AND IS_DELETED = 0 AND C.CATALOGUE_MT_ID = $catalogue_mt_id AND C.CONDITION_ID = $condition_id GROUP BY CATALOGUE_MT_ID, CONDITION_ID) WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id AND T.CONDITION_ID = $condition_id");

      $select_qry = $this->db2->query("SELECT T.AVG_PRICE,T.QTY_SOLD,T.AVG_PRICE*T.QTY_SOLD TOTAL_VALUE FROM MPN_AVG_PRICE_TMP T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id AND T.CONDITION_ID = $condition_id")->result_array();
      	if($select_qry){
      		return $select_qry;
      	}else{
      		return 0;
      	}


       
      //return $qty_det;
    }
public function del_kw(){
      $feed_url_id = $this->input->post("feed_url_id");
      //exit;
      $del_qry = $this->db2->query("CALL PRO_DELETE_KEYWORD($feed_url_id)");
      //var_dump($feed_url_id,$del_qry);
      	if($del_qry){
      		return 1;
      	}else{
      		return 0;
      	}
      //return $qty_det;
    }
  public function updateUrl(){
    $feedurlid              = $this->input->post('feedUrlId');
    $feedName               = $this->input->post('feedName');
    $feedName               = trim(str_replace("  ", ' ', $feedName));
    $feedName               = str_replace(array("`,′"), "", $feedName);
    $feedName               = str_replace(array("'"), "''", $feedName);
    $keyWord                = $this->input->post('keyword');
    $keyWord                = trim(str_replace("  ", ' ', $keyWord));
    $keyWord                = str_replace(array("`,′"), "", $keyWord);
    $keyWord                = str_replace(array("'"), "''", $keyWord);
    $excludeWord            = $this->input->post('excludeWord');
    $excludeWord            = trim(str_replace("  ", ' ', $excludeWord));
    $excludeWord            = str_replace(array("`,′"), "", $excludeWord);
    $excludeWord            = str_replace(array("'"), "''", $excludeWord);

    $category_id            = $this->input->post('category_id');
    $catalogue_mt_id        = $this->input->post('catalogue_mt_id');
    $rss_feed_cond          = $this->input->post('rss_feed_cond');
    $rss_listing_type       = $this->input->post('rss_listing_type');
    /////////////////////////////////////
    $withInUpdate           = $this->input->post('withInUpdate');
    $zipCodeUpdate          = $this->input->post('zipCodeUpdate');
    $seller_filter_update   = $this->input->post('seller_filter_update');
    $seller_name_update     = $this->input->post('seller_name_update');
    $rss_feed_type          = $this->input->post('rss_feed_type');
    ////////////////////////////////////
    $exclude_words          = '';
    if(strpos($excludeWord, ',') !== false) {
      $excludeWord = explode(',', $excludeWord);
      //var_dump(count($excludeWord));
      if(count($excludeWord) >1){
        foreach ($excludeWord as $word) {
          if (strpos($word, '-') !== false) {
          $exclude_words .= trim($word);
        }else{
          $exclude_words .= ' -'.trim($word);
        }
          
        }
      }else{
        if (strpos($excludeWord[0], '-') !== false) {
          $exclude_words = trim($excludeWord[0]);
        }else{
          $exclude_words = ' -'.trim($excludeWord[0]);
        }
      }
    }else{
      if (!empty($excludeWord)) {
        if (strpos($excludeWord, '-') !== false) {
          $exclude_words = $excludeWord;
        }else{
          $exclude_words = ' -'.$excludeWord;
        }  
      }
     
    }



    $min_price = $this->input->post('minPrice');
    $max_price = $this->input->post('maxPrice');
    $update_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $update_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    /*===========================================
    =            create rss feed URL            =
    ===========================================*/
    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . chr(38) . '_nkw=' . $keyWord.$exclude_words . chr(38) . '_sop=10' . chr(38) . 'rt=nc' . chr(38) . 'LH_'.$rss_listing_type.'=1'; 
    $lvar_rss_url3 = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    $lvar_rss_url4 =chr(38) . 'LH_ItemCondition=' . $rss_feed_cond . chr(38) .'_rss=1' . chr(38) . '_mpn=' . $catalogue_mt_id;
    $lvar_final_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4; 

    /*=====  End of create rss feed URL  ======*/



    $qry = $this->db2->query("UPDATE LZ_BD_RSS_FEED_URL SET RSS_FEED_URL= '$lvar_final_url', FEED_NAME = '$feedName', KEYWORD = '$keyWord' , MIN_PRICE = '$min_price' , MAX_PRICE = '$max_price' ,EXCLUDE_WORDS = '$exclude_words', CONDITION_ID = $rss_feed_cond, LISTING_TYPE= '$rss_listing_type' , WITHIN = '$withInUpdate', ZIPCODE = '$zipCodeUpdate', SELLER_FILTER = '$seller_filter_update', FEED_TYPE = '$rss_feed_type', SELLER_NAME = '$seller_name_update', UPDATE_BY = '$update_by', UPDATE_DATE =  $update_date, VERIFY_DATE= $update_date, VERIFY_BY= $update_by  WHERE  FEED_URL_ID = '$feedurlid'"); 
   //$qry = $qry->result_array();

/*=================================================================
=            update verify data in main category table            =
=================================================================*/
	$update_qry = $this->db2->query("UPDATE LZ_BD_CATAG_DATA_$category_id SET CATALOGUE_MT_ID ='', VERIFIED = 0, FEED_URL_ID ='', VERIFIED_BY = '', VERIFIED_DATE = ''  WHERE FEED_URL_ID = $feedurlid");

/*=====  End of update verify data in main category table  ======*/

/*========================================================
=            verify data with updated keyword            =
========================================================*/
	$str = explode(" ",$keyWord);
	if(count($str) > 1 ){
		$KeyWord = '';
	      foreach ($str as $value) {
	        $KeyWord .=" AND UPPER(TITLE) LIKE UPPER('%".$value."%')";//adding quote for excat word search in any order
	      }
	    }else{
	      $KeyWord = " AND UPPER(TITLE) LIKE UPPER('%".$keyWord."%')";
	    }

		$this->db2->query("UPDATE LZ_BD_CATAG_DATA_$category_id SET CATALOGUE_MT_ID = $catalogue_mt_id , VERIFIED = 1, FEED_URL_ID = $feedurlid  WHERE FEED_URL_ID IS NULL AND VERIFIED = 0 $KeyWord");
/*=====  End of verify data with updated keyword  ======*/

	/*======================================================
	=            update avg price in temp table            =
	======================================================*/
		$this->db2->query("UPDATE MPN_AVG_PRICE_TMP T SET (T.AVG_PRICE, T.MIN_PRICE, T.MAX_PRICE, T.QTY_SOLD, T.TRUNOVER_UNIT, T.TURNOVER_VALUE, T.SOLD_FROM, T.SOLD_TO, T.TURNOVER_DAYS, T.LAST_VERIFIED_DATE) = (SELECT ROUND(AVG(SALE_PRICE + SHIPPING_COST), 2) AVG_PRICE, MIN(SALE_PRICE) MIN_PRICE, MAX(SALE_PRICE) MAX_PRICE, COUNT(C.LZ_BD_CATA_ID) QTY_SOLD, ROUND(COUNT(C.LZ_BD_CATA_ID) / 90, 2) TRUNOVER_UNIT, ROUND(SUM(SALE_PRICE) / 90, 2) TURNOVER_VALUE, MIN(SALE_TIME) SOLD_FROM, MAX(SALE_TIME) SOLD_TO, ROUND(MAX(C.SALE_TIME) - MIN(C.SALE_TIME)) TURNOVER_DAYS, MAX(VERIFIED_DATE) LAST_VERIFIED_DATE FROM LZ_BD_CATAG_DATA_$category_id C WHERE SALE_TIME >= SYSDATE - 90 AND VERIFIED=1 AND CATALOGUE_MT_ID IS NOT NULL AND NOT REGEXP_LIKE (UPPER(TITLE) , 'LOT|PCS|PIECE|EACH') AND LOTSONLY = 0 AND IS_DELETED = 0 AND C.CATALOGUE_MT_ID = $catalogue_mt_id AND C.CONDITION_ID = $rss_feed_cond GROUP BY CATALOGUE_MT_ID, CONDITION_ID) WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id AND T.CONDITION_ID = $rss_feed_cond");

	/*=====  End of update avg price in temp table  ======*/
    return $qry;
  }
public function verirfyKeyword(){
  	$feedUrlId 			= $this->input->post('feedUrlId');
  	$verified_by 		= $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date 				= date('Y-m-d H:i:s');
    $verified_date 		= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
  	//var_dump($feedUrlId, $verified_by, $verified_date); exit;
  	$update_keyword = $this->db2->query("UPDATE LZ_BD_RSS_FEED_URL L SET  L.VERIFY_DATE =$verified_date , L.VERIFY_BY= $verified_by WHERE L.FEED_URL_ID= $feedUrlId ");
  	if ($update_keyword ) {
  		return 1;
  	}else{
  		return 0;
  	}

  }
}
 ?>
