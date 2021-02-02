<?php  

	class m_autolist extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	  public function loadautoListedItems(){
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
	      10 =>'ITEM_MT_MFG_PART_NO',
	      11 =>'ITEM_MT_MANUFACTURE',
	      12 =>'BIN_NAME',
	      13 =>null,
	      14 =>null
	    );
	    $this->session->unset_userdata('searchdata');
	    $location    = $this->input->post('search_location');
        $rslt         = $this->input->post('search_date');
        $this->session->set_userdata('searchdata', ['location'=>$location, 'dateRange'=>$rslt]);
        $searchedData =  $this->session->userdata('searchdata');
	   $listed_qry = "SELECT  DISTINCT LS.SEED_ID, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, LS.SHIPPING_SERVICE, D.WEIGHT FROM LZ_ITEM_SEED   LS, LZ_MANIFEST_MT LM, ITEMS_MT       I, LZ_AUTO_LIST   E, BIN_MT         BM, LZ_BARCODE_MT  BCD, LZ_MANIFEST_DET D WHERE LM.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND LS.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND BCD.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND I.ITEM_CODE = D.LAPTOP_ITEM_CODE AND E.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID /*AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID*/ AND LM.MANIFEST_TYPE IN (0,1, 3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID ";
	  if($searchedData['location'] == "PK" || $location == "PK"){
	    $this->session->set_userdata('date_range', $rslt);
	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];
	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);

	    // $from = date_format($fromdate,'d-m-y');
	    // $to = date_format($todate, 'd-m-y');
	    // $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
		$from = date_format($fromdate,'Y-m-d');
		$to = date_format($todate, 'Y-m-d');
		$date_qry = " AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK') AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
	    $listed_qry .= $date_qry;
	}elseif($searchedData['location'] == "US" || $location == "US"){
	    $this->session->set_userdata('date_range', $rslt);
	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];
	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);
		$from = date_format($fromdate,'Y-m-d');
		$to = date_format($todate, 'Y-m-d');	    
	    $date_qry = " AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US') AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
		$listed_qry .= $date_qry;
	}else{
		$this->session->set_userdata('date_range', $rslt);
	    $rs = explode('-',$rslt);
	    $fromdate = $rs[0];
	    $todate = $rs[1];
	    /*===Convert Date in 24-Apr-2016===*/
	    $fromdate = date_create($rs[0]);
	    $todate = date_create($rs[1]);

		$from = date_format($fromdate,'Y-m-d');
		$to = date_format($todate, 'Y-m-d');
		$date_qry = " AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
	    $listed_qry .= $date_qry;
	}

      if(!empty($requestData['search']['value'])){ 
        // if there is a search parameter, $requestData['search']['value'] contains search parameter  
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
  	if (!empty($columns[$requestData['order'][0]['column']])) {
		$listed_qry.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
	}else{
		$listed_qry.= " ORDER BY LIST_DATE DESC";
	}
	   
	$qry = $this->db->query($listed_qry);
	$totalData = $qry->num_rows();
	$totalFiltered = $totalData;
	//var_dump($totalData, $totalFiltered); exit;
	//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
	$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($listed_qry) q )";
	$sql.= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
	
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //var_dump(count($query)); exit;
    $data = array();
    $i =0;
    $sure_button = "return confirm('Are you sure?')";
    foreach($query as $row ){ 
      	$nestedData= array();
      	
      	$nestedData[] = '<div style="width:180px;"><div style="float:left;margin-right:8px;"> <form action="'.base_url().'tolist/c_tolist/list_item" method="post" accept-charset="utf-8"> <input type="hidden" name="seed_id" class="seed_id" id="seed_id" value="'.@$row['SEED_ID'].'"> <input type="submit" name="item_list" title="List to eBay" onclick="'.$sure_button.'" class="btn btn-success btn-sm" value="List"> </form> </div><div style="float:left;margin-right:8px;"> <a href="'.base_url().'tolist/c_tolist/seed_view/'.@$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> <a style=" margin-right: 3px;" id="print_bttn" listId="'.@$row['LIST_ID'].'" barCode="'.@$row['BARCODE_NO'].'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a><div style="float:left;margin-right:8px;" class="getPriceDetail" id= '.@$row['ITEM_ID'].' manifestid = '.@$row['LZ_MANIFEST_ID'].'><span class=" btn btn-primary btn-sm glyphicon glyphicon-usd"></span></div></div>';
      		
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
           
          $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1")->result_array();

          $path_2 = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2")->result_array();

          	$mpn 					= str_replace('/', '_', @$row['MFG_PART_NO']);
		    $master_path 			= $path_query[0]['MASTER_PATH'];
		    $m_dir 					= $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/thumb/";
		    $specific_path 			= $path_query[0]['SPECIFIC_PATH'];

		    $s_dir 					= $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/thumb/";

		    // $d_dir 				= @$path_2[0]['MASTER_PATH'];

		    // $d_dir = @$d_dir.@$barcode.'/thumb/';

		    // if(is_dir(@$d_dir)){
		    //     $iterator = new \FilesystemIterator(@$d_dir);
		    //       if(@$iterator->valid()){    
		    //           $m_flag = true;
		    //       }else{
		    //         $m_flag = false;
		    //       }
		    // }else
		    if(is_dir(@$s_dir)){
		        $iterator = new \FilesystemIterator(@$s_dir);
		            if (@$iterator->valid()){    
		              $m_flag = true;
		          }else{
		            $m_flag = false;
		          }
		    }elseif(is_dir(@$m_dir)){
		        $iterator = new \FilesystemIterator(@$m_dir);
		            if (@$iterator->valid()){    
		              $m_flag = true;
		          }else{
		            $m_flag = false;
		          }                              
		    }else{
		        $m_flag = false;
		    }
		    //////////////////////////////
		     if($m_flag){
			  //  if (is_dir($d_dir)){
			  //   $images = scandir($d_dir);
			  //   // Image selection and display:
			  //   //display first image
			  //   if (count($images) > 0){ // make sure at least one image exists
			  //       $url = @$images[2]; // first image
			  //       $img = file_get_contents(@$d_dir.@$url);
			  //       $img =base64_encode($img);
			  //       //$nestedData[] = '';
			  //       $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			  //   }
			  // }else
			  if (is_dir($m_dir)){
			    $images = scandir($m_dir);
			    // Image selection and display:
			    //display first image
			    if (count($images) > 0){ // make sure at least one image exists
			        $url = @$images[2]; // first image
			        $img = file_get_contents(@$m_dir.@$url);
			        $img =base64_encode($img);
			        //$nestedData[] = '';
			        $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			    }
			  }else{
			     //$images = glob("$s_dir*.jpg");
			    //sort($images);
			    $images = scandir($s_dir);
			    // Image selection and display:
			    //display first image
			    if (count($images) > 0) { // make sure at least one image exists
			        $url = @$images[2]; // first image
			        $img = file_get_contents(@$s_dir.@$url);
			        $img =base64_encode($img);
			        //$nestedData[] = '';
			        $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			    }
			  } 
			}else{//flag if else
			  $nestedData[] = "NOT FOUND"; 
			}

      		$nestedData[] 	= @$row['EBAY_ITEM_ID'];
			//////////////////////////////////////
			$nestedData[] = '<div style="width:150px;"> '.@$row['BARCODE_NO'].'</div>';

			//$nestedData[] = @$row['MASTER_BARCODE'].@$row['PRINT_BARCODE'];
			//$nestedData[] = '';
			//$nestedData[] = '<div style="width:150px;">'.@$row['BARCODE_NO']->load().'</div>';
			//$nestedData[] ='<div style="width:150px;"><p style="color:red;"> Master Barcode -- '.@$mas_barcode.'</p>'.$barcodes.'</div>';
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
   			$nestedData[] 	= @$row['SHIPPING_SERVICE'];
   			$nestedData[] 	= @$row['WEIGHT'];
			////////////////////////////////////
   			$query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID IN(4,5,13,14,16,2,18,21,22,23,24,25,26)");
	  		//var_dump($query->result_array());exit;
			$lister = $query->result_array();
		     foreach(@$lister as $user):
		        if(@$row['LISTER_ID'] === $user['EMPLOYEE_ID']){
		          $u_name = ucfirst($user['USER_NAME']);
		          $user_name =  $u_name;
		        break;
		        }
		      endforeach;
    		$nestedData[] 	= $user_name;
			////////////////////////////////////
    		$nestedData[] = @$row['LIST_DATE'];
    		//$nestedData[] = @$row['UPC'];
    		$nestedData[] = @$row['MFG_PART_NO'];
    		$nestedData[] = @$row['MANUFACTURER'];
    		$nestedData[] = '<a style ="" href="'.base_url().'tolist/c_tolist/transfer_location/'.@$row['BIN_NAME'].'" target="_blank">'.@$row['BIN_NAME'].'</a>';
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
      		$data[] 			= $nestedData;
      		$i++;
    	} 
    	/////////////END FOREACH //////////
    	//$this->session->unset_userdata('searchdata');
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

  public function getPriceDetail(){
  	$item_id    = $this->input->post('itemId');
  	$manifest_id    = $this->input->post('manifestId');
  	$ship_service    = $this->input->post('shipService');
  	$weight    = $this->input->post('weight');
  	$sale_price    = $this->input->post('salePrice');
  	//$ship_service    = 'USPSFirstClass';
  	$profit    = 30;
  	
  	$query = $this->db->query("SELECT MAX(D.PO_DETAIL_RETIAL_PRICE) ITEM_COST FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = $item_id AND D.LZ_MANIFEST_ID = $manifest_id GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID")->result_array();
  	$itemCost =  $query[0]['ITEM_COST'];

  	$query = $this->db->query("SELECT PAYPAL_FEE, EBAY_FEE FROM (SELECT SD.SALES_RECORD_NUMBER, ROUND((SD.PAYPAL_PER_TRANS_FEE / SD.SALE_PRICE) * 100, 2) PAYPAL_FEE, ROUND((SD.EBAY_FEE_PERC / SD.SALE_PRICE) * 100, 2) EBAY_FEE FROM LZ_SALESLOAD_DET SD, EBAY_LIST_MT E WHERE SD.ITEM_ID = E.EBAY_ITEM_ID AND SD.SALE_PRICE > 0 AND SD.PAYPAL_PER_TRANS_FEE > 0 AND SD.EBAY_FEE_PERC > 0 AND SD.QUANTITY = 1 AND E.ITEM_ID = $item_id ORDER BY SD.LZ_SALESLOAD_DET_ID DESC) WHERE ROWNUM = 1")->result_array(); 
  	if(count($query) > 0){
  		$paypalFee =  $query[0]['PAYPAL_FEE'];
  		$ebayFee =  $query[0]['EBAY_FEE'];
  	}else{
  		$paypalFee =  2.25;
  		$ebayFee =  8.00;
  	} 
  	
  	$query = $this->db->query("SELECT SHIP_FEE FROM (SELECT D.SHIP_FEE FROM LZ_MANIFEST_DET D WHERE D.LAPTOP_ITEM_CODE = (SELECT ITEM_CODE FROM ITEMS_MT WHERE ITEM_ID = $item_id) AND D.SHIP_FEE IS NOT NULL ORDER BY D.SHIP_FEE DESC) WHERE ROWNUM = 1")->result_array();
  	if(count($query) > 0){
  		$ship_Fee = $query[0]['SHIP_FEE'];
  	}else{
  		if ($ship_service == 'FedExHomeDelivery'){
  			$ship_Fee = 15.00;
  		}elseif($ship_service == 'USPSPriority'){
  			$ship_Fee = 6.50;
  		}elseif ($ship_service == 'USPSFirstClass') {
  			$ship_Fee = 3.25;
  		}else{
  			$ship_Fee = 3.25;
  		}
  	}

  	if($sale_price >=100 && $weight<= 16){
  		$ship_Fee = 6.50;
  	}
   return array('itemCost'=>$itemCost,'ebayFee'=>$ebayFee,'paypalFee'=>$paypalFee,'shipFee'=>$ship_Fee,'profit'=>$profit);
    

  }
	
}

?>