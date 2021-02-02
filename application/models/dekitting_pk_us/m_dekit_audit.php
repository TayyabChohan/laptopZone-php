<?php  

	class M_dekit_audit extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	  public function loadListedItems(){
  		$requestData= $_REQUEST;
		$columns = array( 
	      0 =>'BARCODE_NO',
	      1 =>null,
	      2 =>'EBAY_ITEM_ID',
	      3 =>'BARCODE_NO',
	      4 =>'CONDITION_ID',
	      5 =>'ITEM_TITLE',
	      6 =>null,
	      7 =>'EBAY_PRICE',
	      8 =>null,
	      9 =>'LIST_DATE',
	      10 =>'MFG_PART_NO',
	      11 =>'MANUFACTURER',
	      12 =>'BIN_NAME',
	      13 =>null,
	      14 =>null,
	      15 =>'SOLD_STAT'
	    );	

	    $searchedData =  $this->session->unset_userdata('dekit_searchdata');
	    $location    = $this->input->post('search_location');
        $rslt         = $this->input->post('search_date');
        $this->session->set_userdata('dekit_searchdata', ['dekit_location'=>$location, 'dekit_dateRange'=>$rslt]);
        $dekitSession = $this->session->userdata('dekit_searchdata');
        
        //var_dump($location, $rslt); 
	 if($dekitSession['dekit_location'] == "PK"){
	 	$listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID,DECODE((SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO), NULL, (SELECT LO.FOLDER_NAME FROM LZ_SPECIAL_LOTS LO WHERE LO.BARCODE_PRV_NO = BCD.BARCODE_NO),(SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO)) FOLDER_NAME, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, BM.BIN_TYPE BI_TYP,I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_BARCODE_MT BCD, BIN_MT BM, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE IN (3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = '$location')"; }elseif($dekitSession['dekit_location'] == "US"){
	     $listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID,DECODE((SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO), NULL, (SELECT LO.FOLDER_NAME FROM LZ_SPECIAL_LOTS LO WHERE LO.BARCODE_PRV_NO = BCD.BARCODE_NO),(SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO)) FOLDER_NAME, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,BM.BIN_TYPE BI_TYP, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_BARCODE_MT BCD, BIN_MT BM, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE IN (3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US')";
	 		}else{
	 	$listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID, DECODE((SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO), NULL, (SELECT LO.FOLDER_NAME FROM LZ_SPECIAL_LOTS LO WHERE LO.BARCODE_PRV_NO = BCD.BARCODE_NO),(SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO)) FOLDER_NAME,LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,BM.BIN_TYPE BI_TYP, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_BARCODE_MT BCD, BIN_MT BM, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE IN (3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID "; }

	  if($dekitSession['dekit_location'] == "PK"){
	    $this->session->set_userdata('date_range', $rslt);
	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];
	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);

	    // $from = date_format($fromdate,'d-m-y');
	    // $to = date_format($todate, 'd-m-y');

	    $from = date_format($fromdate,'Y-m-d');
	    $to = date_format($todate, 'Y-m-d');
	    //$date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

	    $listed_qry .= $date_qry;
	}elseif($dekitSession['dekit_location'] == "US"){
	    $this->session->set_userdata('date_range', $rslt);
	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];
	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);

	    // $from = date_format($fromdate,'d-m-y');
	    // $to = date_format($todate, 'd-m-y');

	    $from = date_format($fromdate,'Y-m-d');
	    $to = date_format($todate, 'Y-m-d');
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
		$listed_qry .= $date_qry;
	}else{
		$this->session->set_userdata('date_range', $rslt);
	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];
	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);

	    // $from = date_format($fromdate,'d-m-y');
	    // $to = date_format($todate, 'd-m-y');

	    $from = date_format($fromdate,'Y-m-d');
	    $to = date_format($todate, 'Y-m-d');
	    //$date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

	    $listed_qry .= $date_qry;
	}

      if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter  
      $listed_qry.=" AND (BCD.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";    
      $listed_qry.=" OR BCD.BARCODE_NO LIKE '%".$requestData['search']['value']."%' ";
      //$listed_qry.=" OR B_LIST.BARCODE_NO LIKE '%".$requestData['search']['value']."%' ";
      $listed_qry.=" OR BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";
      $listed_qry.=" OR LS.ITEM_TITLE LIKE '%".$requestData['search']['value']."%' ";
      $listed_qry.=" OR E.LIST_DATE LIKE '%".$requestData['search']['value']."%' ";
      //$listed_qry.=" OR I.ITEM_MT_UPC LIKE '%".$requestData['search']['value']."%' ";
      $listed_qry.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
      //$listed_qry.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
      $listed_qry.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
      //$listed_qry.=" OR LS.SHIPPING_SERVICE LIKE '%".$requestData['search']['value']."%' ";
      $listed_qry.=" OR BM.BIN_TYPE ||'-'|| BM.BIN_NO LIKE '%".$requestData['search']['value']."%') "; 
  }

	//$listed_qry.= " ORDER BY LIST_DATE DESC";
	if (!empty($columns[$requestData['order'][0]['column']])) {
		$listed_qry.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
	}else{
		$listed_qry.= " ORDER BY EBAY_ITEM_ID DESC";


	}
	     
	$qry = $this->db->query($listed_qry);

	$totalData = $qry->num_rows();
	$totalFiltered = $totalData;
	//var_dump($totalData, $totalFiltered); exit;
	    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
	    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($listed_qry) q )";
 
	    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
	

 	// $sql = "SELECT,  * FROM    (SELECT  q.*, rownum rn FROM    ($listed_qry) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;

    $query = $this->db->query($sql);
    $query = $query->result_array();
    //var_dump(count($query)); exit;
    $data = array();
    $i =0;
    foreach($query as $row ){ 
    	//http://localhost/laptopzone/dekitting_pk_us/c_to_list_pk/seed_view/32775/111098
      	$nestedData= array();
      	$nestedData[] = '<div style="width:140px;"><div style="float:left;margin-right:2px;"> <a  id = "brc_del" cid ="'.$row['BARCODE_NO'].'" title="Remove from audit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> </div><div style="float:left;margin-right:8px;"> <a href="'.base_url().'dekitting_pk_us/c_to_list_pk/seed_view/'.$row['SEED_ID'].'/'.$row['BARCODE_NO'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> <a style=" margin-right: 3px;" id="dekit_print_bttn" listId="'.@$row['LIST_ID'].'" barCode="'.@$row['BARCODE_NO'].'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a> </div>';
	  			
      		$it_condition  = @$row['ITEM_CONDITION'];

        	if(is_numeric(@$it_condition)){
	            if(@$it_condition == 3000){
	              @$it_condition = 'Used';
	            }elseif(@$it_condition == 1000){
	              @$it_condition = 'New'; 
	            }elseif(@$it_condition == 1500){
	              @$it_condition = 'New other'; 
	            }elseif(@$it_condition == 2000){
	                @$it_condition = 'Manufacturer refurbished';
	            }elseif(@$it_condition == 2500){
	              @$it_condition = 'Seller refurbished'; 
	            }elseif(@$it_condition == 7000){
	              @$it_condition = 'For parts or not working'; 
	            }
	        }          
          

          $path_2 = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2")->result_array();

		    $d_dir 	= @$path_2[0]['MASTER_PATH'];
		    $d_dir =@$d_dir.@$row['FOLDER_NAME'].'/thumb/';

		    if(is_dir(@$d_dir)){
		        $iterator = new \FilesystemIterator(@$d_dir);
		          if(@$iterator->valid()){    
		              $m_flag = true;
		          }else{
		            $m_flag = false;
		          }                             
		    }else{
		        $m_flag = false;
		    }
		    //////////////////////////////
		     if($m_flag){
			   if (is_dir($d_dir)){
			    $images = scandir($d_dir);
			    // Image selection and display:
			    //display first image
			    if (count($images) > 0){ // make sure at least one image exists
			        $url = @$images[2]; // first image
			        $img = file_get_contents(@$d_dir.@$url);
			        $img =base64_encode($img);
			        //$nestedData[] = '';
			        $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			    }
				}else{//IS_DIR if else
				  $nestedData[] = "NOT FOUND"; 
				}
			}else{//flag if else
			  $nestedData[] = "NOT FOUND"; 
			}

      		$nestedData[] 	= @$row['EBAY_ITEM_ID'];
			//////////////////////////////////////
			//$nestedData[] = '';
			$nestedData[] = '<div style="width:150px;"> <p  style="color:red;"> Master Barcode -- '.@$row['MASTER_BARCODE'].'</p>'.@$row['BARCODE_NO'].'</div>';

			/////////////////////////////////////
			if(@$row['ITEM_CONDITION'] == 3000 ){
					$item_condition =  "USED";
				}elseif(@$row['ITEM_CONDITION'] == 1000 ){
					$item_condition =  "NEW";
				}elseif(@$row['ITEM_CONDITION'] == 1500 ){
					$item_condition =  "NEW OTHER";
				}elseif(@$row['ITEM_CONDITION'] == 2000 ){
					$item_condition =  "MANUFACTURER REFURBISHED";
				}elseif(@$row['ITEM_CONDITION'] == 2500 ){
					$item_condition =  "SELLER REFURBISHED";
				}elseif(@$row['ITEM_CONDITION'] == 7000 ){
					$item_condition =  "FOR PARTS OR NOT WORKING";
				}elseif(@$row['ITEM_CONDITION'] == 4000 ){
					$item_condition =  "VERY GOOD";
				}elseif(@$row['ITEM_CONDITION'] == 5000 ){
					$item_condition =  "GOOD";
				}elseif(@$row['ITEM_CONDITION'] == 6000 ){
					$item_condition =  "ACCEPTABLE";
				}else{
					$item_condition =  @$row['ITEM_CONDITION'];
				}
				
   			$nestedData[] 	= $item_condition;
			////////////////////////////////////
   			$nestedData[] 	= '<div style ="width:300px;">'.$row['ITEM_MT_DESC'].'</div>';
   			$nestedData[] 	= $row['QUANTITY'];
   			$nestedData[] 	= "$".number_format((float)@$row['EBAY_PRICE'],2,'.',',');
			////////////////////////////////////
   			$query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID IN(4,5,13,14,16,2,18,21,22,23,24,25,26)");
	  		//var_dump($query->result_array());exit;
			$lister = $query->result_array();
			$user_name = "";
		     foreach(@$lister as $user):
		        if(@$row['LISTER_ID'] === $user['EMPLOYEE_ID']){
		          $u_name = ucfirst($user['USER_NAME']);
		          $user_name =  $u_name;
		        break;
		        }
		      endforeach;
    		$nestedData[] 	= $user_name;

    		if($row['BI_TYP'] =='WB'){
				$ver ='class ="verified"';
			}else{
				$ver ='class ="notverified"';
			}

			if($row['SOLD_STAT'] !='AVAILABLE'){
				$vert ='class ="verified"';
			}else{
				$vert ='class ="notverified"';
			}

			////////////////////////////////////
    		$nestedData[] = @$row['LIST_DATE'];
    		//$nestedData[] = @$row['UPC'];
    		$nestedData[] = @$row['MFG_PART_NO'];
    		$nestedData[] = @$row['MANUFACTURER'];
    		$nestedData[] = '<a '.$ver.' href="'.base_url().'dekitting_pk_us/c_dekit_audit/transfer_location/'.@$row['BIN_NAME'].'" target="_blank">'.@$row['BIN_NAME'].'</a>';
    		//$nestedData[] = @$row['SHIPPING_SERVICE'];
    		//$nestedData[] = @$row['PURCH_REF_NO'];
			///////////////////////////////////
		     if(@$row['LZ_SELLER_ACCT_ID'] == 1){
		        $seller_id = "Techbargains2015";
		      }elseif(@$row['LZ_SELLER_ACCT_ID'] == 2){
		        $seller_id = "Dfwonline";
		      }
		    $nestedData[]  = @$seller_id;
			/////////////////////////////////
    		$nestedData[]  = @$row['STATUS'];
    		$nestedData[]  = '<div '.$vert.'>'.@$row['SOLD_STAT'].'</div>';
      		$data[] 			= $nestedData;
      		$i++;
    	} 
    	/////////////END FOREACH //////////
	    $json_data = array(
	          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	          "recordsTotal"    =>  intval($totalData),  // total number of records
	          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
	          "deferLoading" 	=>  intval( $totalFiltered ),
	          "data"            => $data   // total data array
	          ); 
    	return $json_data;
    /////////////////////////////////// 
  }
  
	public function setBinIdtoSession(){
		$dekit_audit_bin_id = trim(strtoupper($this->input->post("audit_bin_id")));

		$bindId = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$dekit_audit_bin_id' ")->result_array();
   
   
	    if(count($bindId) > 0) {
			$this->session->set_userdata('dekit_audit_bin_id', $dekit_audit_bin_id);
			$sess_val = $this->session->userdata("dekit_audit_bin_id");
			return true;
		}else{
			return false;
		}
	}
	public function transfer_location(){
    $bin_name = strtoupper(trim($this->uri->segment(4)));
    //var_dump($bin_name); exit;
     $bind_ids = $this->db->query("SELECT CURRENT_RACK_ROW_ID RACK_ROW_ID, BIN_ID, 'W' || '' || WAREHOUSE_NO || '-' || RACK_NO || ' | ' || DECODE(ROW_NO, NULL, NULL, 0, 'N' || '' || ROW_NO, 'R' || '' || ROW_NO) || ' | ' || BIN_NAME RACK_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, B.CURRENT_RACK_ROW_ID, RA.RACK_NO, MT.WAREHOUSE_NO, R.ROW_NO FROM BIN_MT B, LZ_RACK_ROWS R, RACK_MT RA, WAREHOUSE_MT MT WHERE B.CURRENT_RACK_ROW_ID = R.RACK_ROW_ID AND RA.WAREHOUSE_ID = MT.WAREHOUSE_ID AND R.RACK_ID = RA.RACK_ID) WHERE BIN_NAME = '$bin_name'")->result_array();
     if (count($bind_ids) >0) {
      $bin_id    = $bind_ids[0]['BIN_ID'];
      if (!empty($bin_id)) {
        $transfers = $this->db->query("SELECT B.BARCODE_NO BARCOD, B.BIN_ID, I.ITEM_DESC DESCR, I.ITEM_MT_UPC  UPC, I.ITEM_MT_MFG_PART_NO MPN, MAX_BAR.TRANS_BY_ID TRANS_BY_ID,  TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE FROM LZ_BARCODE_MT B, BIN_MT M, ITEMS_MT I, (SELECT LL.BARCODE_NO, M.FIRST_NAME ||' '||M.LAST_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME FROM LZ_LOC_TRANS_LOG LL,EMPLOYEE_MT M WHERE LL.LOC_TRANS_ID IN (SELECT MAX(L.LOC_TRANS_ID) FROM LZ_LOC_TRANS_LOG L GROUP BY L.BARCODE_NO) AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR WHERE B.BIN_ID = M.BIN_ID AND B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+) AND B.BIN_ID = $bin_id")->result_array();
      }else{
        $transfers = [];
      }
      
     }else{
      $transfers = [];
     }
    return array('bind_ids'=>$bind_ids, 'transfers'=>$transfers);
     }
		
}


 ?>