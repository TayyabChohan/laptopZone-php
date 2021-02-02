<?php  

	class M_Tolist extends CI_Model{

		public function __construct(){
		parent::__construct();
		$this->load->database();
	}
//by Danish
 public function loadtolistresult(){

    $requestData= $_REQUEST;
    $columns = array( 
     0 =>'IT_BARCODE',
     1 =>'ITEM_PIC',
     2 =>'PURCH_REF_NO',
     3 =>'ITEM_MT_DESC',
     4 =>'MANUFACTURER',
     5 =>'NOT_LIST_QTY',
     6 =>'COST_US',
     7 =>'COST_US',
     8 =>'ITEM_CONDITION',
     9 => 'UPC',
     10 =>'MFG_PART_NO',
     11 =>'SKU_NO',
     12 =>'PURCHASE_DATE',
     13 =>'IT_BARCODE'
    );
    	$search_record = $this->input->post('search_val');
      	$purchase_no = $this->input->post('purchase_no');
      	$rslt = $this->input->post('date_range');
      	//var_dump($search_record,  $purchase_no, $rslt);
      	//exit;
      	$this->session->set_userdata('date_range', $rslt);

      $rs = explode('-',$rslt);
      $fromdate = $rs[0];
      $todate = $rs[1];
      /*===Convert Date in 24-Apr-2016===*/
      $fromdate = date_create($rs[0]);
      $todate = date_create($rs[1]);

      $from = date_format($fromdate,'d-m-y');
      $to = date_format($todate, 'd-m-y');

		$sql = "SELECT * FROM VIEW_LZ_LISTING_REVISED T WHERE T.NOT_LIST_QTY>0 AND (T.LIST_QTY IS NULL OR T.LIST_QTY<>T.AVAIL_QTY) AND PURCHASE_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";

	 		if($search_record == "Manifest"){
	 			$sql .= " AND T.SINGLE_ENTRY_ID IS NULL";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == "Single_Entry"){
	 			$sql .= " AND T.SINGLE_ENTRY_ID IS NOT NULL";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == 'All'){
	 			$sql .= " ";
	 			$this->session->set_userdata('search_record', $search_record);
	 		}
	 		if(!empty($purchase_no)){
	 			$sql .= " AND PURCH_REF_NO = '$purchase_no'";
	 			$this->session->set_userdata('purchase_no', $purchase_no);
	 		}

    if(!empty($requestData['search']['value'])){   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter  
        $sql.=" AND ( PURCH_REF_NO LIKE '%".$requestData['search']['value']."%' ";    
        $sql.=" OR upper(ITEM_MT_DESC) LIKE upper('%".$requestData['search']['value']."%')";  
        $sql.=" OR upper(MANUFACTURER) LIKE upper('%".$requestData['search']['value']."%') ";  
        $sql.=" OR upper(ITEM_CONDITION) LIKE upper('%".$requestData['search']['value']."%') ";  
        $sql.=" OR UPC LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR SKU_NO LIKE '%".$requestData['search']['value']."%' ";  
        $sql.=" OR IT_BARCODE LIKE '%".$requestData['search']['value']."%') "; 
    }
     $sql.=" ORDER BY PURCHASE_DATE DESC";
     $query           = $this->db->query($sql);
     $totalData       = $query->num_rows();
     $totalFiltered   = $totalData; 
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100";

    $sql = "SELECT * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
    $sql.= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir'];
    $query = $this->db->query($sql);
    $query = $query->result_array();
    $data = array();
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[]   = '<div style="width:80px;">
                         <div style="float:left;margin-right:8px;">
                         <a href="'.base_url().'seed/c_seed/view/'.$row['ITEM_ID'].'/'.$row['LZ_MANIFEST_ID'].'" title="Create/Edit Seed" class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                         </div>
                         </div>';
                $img =@$row['ITEM_PIC'];
                 if(!empty($img)){                                   
                    $img = @$row['ITEM_PIC']->load();
                    $pic=base64_encode(@$img);
      $nestedData[]   = '';
                 }else{
                $nestedData[] = "Not found.";
          }
      $nestedData[]   = @$row['PURCH_REF_NO'];
      $nestedData[]   = @$row['ITEM_MT_DESC'];
      $nestedData[]   = @$row['MANUFACTURER'];
      $nestedData[]   = @$row['NOT_LIST_QTY'];
      $cost_us = @$row['COST_US'];
      $nestedData[] ='$ '.number_format((float)@$cost_us,2,'.',',');
      $line_total = @$cost_us * @$row['NOT_LIST_QTY'];
      $nestedData[]  ='$ '.number_format((float)@$line_total,2,'.',',');
                
      if(@$row['ITEM_CONDITION'] == 3000 )
      	 $nestedData[] = "USED";
                    else if(@$row['ITEM_CONDITION'] == 1000 )
      $nestedData[] = "NEW";
                    else if(@$row['ITEM_CONDITION'] == 1500 )
      $nestedData[] = "NEW OTHER";
                    else if(@$row['ITEM_CONDITION'] == 2000 )
      $nestedData[] = "MANUFACTURER REFURBISHED";
                    else if(@$row['ITEM_CONDITION'] == 2500 )
      $nestedData[] ="SELLER REFURBISHED";
                    else if(@$row['ITEM_CONDITION'] == 7000 )
      $nestedData[] = "FOR PARTS OR NOT WORKING";
                    else if(@$row['ITEM_CONDITION'] == 4000 )
      $nestedData[] = "VERY GOOD";
                    else if(@$row['ITEM_CONDITION'] == 5000 )
      $nestedData[] ="GOOD";
                    else if(@$row['ITEM_CONDITION'] == 6000 )
                    	 $nestedData[] ="ACCEPTABLE";
                    else
      $nestedData[] =@$row['ITEM_CONDITION'];

      $nestedData[]   = @$row['UPC'];
      $nestedData[]   = @$row['MFG_PART_NO'];
      $nestedData[]   = @$row['SKU_NO'];;
      $nestedData[]   = @$row['PURCHASE_DATE'];

$current_timestamp = date('m/d/Y');
$purchase_date = @$row['PURCHASE_DATE'];              
$date1=date_create($current_timestamp);
$date2=date_create($purchase_date);
$diff=date_diff($date1,$date2);
$date_rslt = $diff->format("%R%a days");
       $nestedData[]= abs($date_rslt)."Days"; 

      $nestedData[]   = @$row['IT_BARCODE'];
      $data[]         = $nestedData;
      //$i++;
    }
    $this->session->unset_userdata('search_record');
    $this->session->unset_userdata('date_range');
    $this->session->unset_userdata('purchase_no');
    $json_data = array(
          "draw"                => intval( $requestData['draw'] ),  
          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"        =>  intval($totalData),  // total number of records
          "recordsFiltered"     => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"        =>  intval( $totalFiltered ),
          "data"                => $data   // total data array
          );
    return $json_data;
  }
 //end Danish  
	public function default_view(){
		$from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
		$to = date('m/d/Y');
		$rslt =$from." - ".$to;
		$this->session->set_userdata('date_range', $rslt);
		$fromdate = date_create($from);
		$todate = date_create($to);
		$from = date_format($fromdate,'d-m-y');
		$to = date_format($todate, 'd-m-y');

		$detail_qry = $this->db->query("select * from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY) AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')");
		$search_record = "Manifest";
		$this->session->set_userdata('search_record', $search_record);
	  	$detail_qry = $detail_qry->result_array();

	  	//======================== Manifest Auction fields Start =============================//
			$summary_qry = "select sum(t.Not_List_Qty) sum_qty, sum(t.COST_US*t.Not_List_Qty) total_cost from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY) AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')"; 
			 		
	 		$summary_qry = $this->db->query( $summary_qry);
	 		//$total_query = $this->db->query( $main_total_query." ".$qry_condition);
	 		$summary_qry = $summary_qry->result_array();

        //======================== Manifest Auction fields End =============================//
        return array('detail_qry'=>$detail_qry,'summary_qry'=>$summary_qry);
	}
	public function search_filter_view($search_record,$from,$to,$purchase_no){

			$main_query = "select * from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY)";
			$date_qry = "AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			$sub_qry="";
	 		if($search_record == "Manifest"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == "Single_Entry"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is not null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == 'All'){
	 			$qry_condition = "";
	 			$this->session->set_userdata('search_record', $search_record);
	 		}
	 		if(!empty($purchase_no)){
	 			$sub_qry = "and purch_ref_no = '$purchase_no'";
	 			$this->session->set_userdata('purchase_no', $purchase_no);
	 		}
	 		$detail_qry = $this->db->query( $main_query. " ".$date_qry." ".$qry_condition." ".$sub_qry);
	 		//$total_query = $this->db->query( $main_total_query." ".$qry_condition);
	 		$detail_qry = $detail_qry->result_array();

	 		//======================== Manifest Auction fields Start =============================//


			$main_sum_qry = "select sum(t.Not_List_Qty) sum_qty, sum(t.COST_US*t.Not_List_Qty) total_cost from view_lz_listing_revised t where t.Not_List_Qty>0 and (t.list_qty is null or t.list_qty<>t.AVAIL_QTY)"; 
			$date_sum_qry = "AND purchase_date between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
			$sub_qry="";
	 		if($search_record == "Manifest"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == "Single_Entry"){
	 			$qry_condition = "and t.SINGLE_ENTRY_ID is not null";
	 			$this->session->set_userdata('search_record', $search_record);

	 		}elseif($search_record == 'All'){
	 			$qry_condition = "";
	 			$this->session->set_userdata('search_record', $search_record);
	 		}
	 		if(!empty($purchase_no)){
	 			$sub_qry = "and purch_ref_no = '$purchase_no'";
	 			$this->session->set_userdata('purchase_no', $purchase_no);
	 		}
	 		$summary_qry = $this->db->query( $main_sum_qry. " ".$date_sum_qry ." ".$qry_condition." ".$sub_qry);
	 		//$total_query = $this->db->query( $main_total_query." ".$qry_condition);
	 		$summary_qry = $summary_qry->result_array();


        //======================== Manifest Auction fields End =============================//
        return array('detail_qry'=>$detail_qry,'summary_qry'=>$summary_qry);
	}
	public function item_listing(){
		/////////////////////////////
			$requestData= $_REQUEST;
			$columns = array( 
			  0 =>'',
			  1 =>'OTHER_NOTES',
			  2 =>'ASSIGN_TO',
			  3 =>'',
			  4 =>'TO_CHAR(BARCODE_NO)',
			  5 =>'ITEM_CONDITION',
			  6 =>'ITEM_MT_DESC',
		      7 =>'QUANTITY',
		      8 =>'PURCH_REF_NO',
		      9 =>'UPC',
		      10 =>'MFG_PART_NO',
		      11 =>'MANUFACTURER',
		      12 =>'BIN_NAME',
		      13 =>'BIN_ID',
		      14 =>''
		    );

		    $lister_id = $this->session->userdata('user_id');
    		$users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
 
    		$employees = array(2,4,5,7,13,19,27,28,29,30,31,32,21,22);  

		    if(in_array($lister_id, $employees)){

		      $sql = "SELECT LS.SEED_ID, LS.ENTERED_BY,DECODE((SELECT C.SEED_ID FROM LZ_LISTING_ALLOC C WHERE C.SEED_ID = LS.SEED_ID AND ROWNUM <= 1), NULL, 'Us Listers','Pk Listers') ASSIGN_TO, EM.USER_NAME, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, C.COND_NAME, BCD.QTY QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, BIN_MT BM, EMPLOYEE_MT EM, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, MAX(BC.BIN_ID) BIN_ID, COUNT(1) QTY, REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, BC.BARCODE_NO) ORDER BY BC.BARCODE_NO DESC NULLS LAST) .GETCLOBVAL(), '<A>', ''), '</A>', ', ') AS BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD, LZ_ITEM_COND_MT C WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND BM.BIN_ID = BCD.BIN_ID AND LS.ENTERED_BY = EM.EMPLOYEE_ID(+) AND C.ID = BCD.CONDITION_ID ";
		  }else{

		      	$sql = "SELECT LS.SEED_ID, LS.ENTERED_BY, DECODE((SELECT C.SEED_ID FROM LZ_LISTING_ALLOC C WHERE C.SEED_ID = LS.SEED_ID AND ROWNUM <= 1), NULL, 'US_LISTERS','PK_LISTERS') ASSIGN_TO,EM.USER_NAME, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE, I.ITEM_DESC) ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, C.COND_NAME, BCD.QTY QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME FROM LZ_ITEM_SEED LS, LZ_LISTING_ALLOC A, LZ_MANIFEST_MT LM, ITEMS_MT I, BIN_MT BM, EMPLOYEE_MT EM, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, MAX(BC.BIN_ID) BIN_ID, COUNT(1) QTY, REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, BC.BARCODE_NO) ORDER BY BC.BARCODE_NO DESC NULLS LAST) .GETCLOBVAL(), '<A>', ''), '</A>', ', ') AS BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD, LZ_ITEM_COND_MT C WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND BM.BIN_ID = BCD.BIN_ID AND LS.ENTERED_BY = EM.EMPLOYEE_ID(+) AND C.ID = BCD.CONDITION_ID AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID"; }
			 
				
		     if(!empty($requestData['search']['value']))
		      {
		      	$search_val = strtoupper($requestData['search']['value']);
		     	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		      	$sql.=" AND (BCD.BARCODE_NO LIKE '%".$search_val."%'"; 
		      	$sql.=" OR UPPER(LS.OTHER_NOTES) LIKE '%".$search_val."%'"; 
		      	$sql.=" OR UPPER(I.ITEM_DESC) LIKE '%".$search_val."%'";   
		      	$sql.=" OR BCD.QTY LIKE '%".$search_val."%'";   
	        	$sql.=" OR I.ITEM_MT_UPC LIKE '%".$search_val."%'"; 
	        	$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$search_val."%'"; 
	        	$sql.=" OR UPPER(I.ITEM_MT_MANUFACTURE) LIKE '%".$search_val."%'"; 
	        	$sql.=" OR BM.BIN_TYPE || '-' || BM.BIN_NO LIKE '%".$search_val."%'"; 
				// BIN ID column search
	        	$sql.=" OR BCD.BIN_ID LIKE '%".$search_val."%'"; //BIN ID column search
	        	$sql.=" OR LM.PURCH_REF_NO LIKE '%".$search_val."%')"; 
			 }

			//$query = $this->db->query($sql);
		    //$totalData = $query->num_rows();
		    $totalFiltered = 0; 
		    $totalData = 0;
		    $totalFiltered = $totalFiltered;
		    
		    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
		    $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q )";
		    $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
		    if (!empty($columns[$requestData['order'][0]['column']])) {
		    	$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		    }else{
		    	$sql.=" ORDER BY LOADING_DATE desc";

		    }
		    
		    // echo $sql;  
		    /*=====  End of For Oracle 12-c  ======*/
		    $query = $this->db->query($sql);
		    $query = $query->result_array();
		    // echo "<pre>";
		    // print_r($query);
		    // exit;
		    /////////////////////////////
		    // $listers = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID IN(4,5,13,14,16,2,18,21,22,23,24,25,26)");
      		// $lister = $listers->result_array();
		    ////////////////////////////
		    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      		$path_query 	=  $path_query->result_array();
      		$master_path 	= $path_query[0]['MASTER_PATH'];
      		$specific_path 	= $path_query[0]['SPECIFIC_PATH'];
		    ////////////////////////////
		   
		    $data = array();
		    $i =0;
		    
		    foreach($query as $row ){ 
		    ////////////////////////////
		    $nestedData=array();
		    ///////////////////////////
      		$m_flag = 0;
      		////////////////////////////////////

      		// check box 

      		$nestedData[] = '<div style="width: 60px!important;"> <div style="float:left;margin-left:18px;"> <input title="Check to Assign Listing to users" type="checkbox" name="assign_listing_pk[]" id="assign_listing_pk"  value="'.@$row['SEED_ID'].'"" > </div> </div>';

    	 	$it_condition  = @$row['COND_NAME'];
            
                        $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/thumb/";
                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
                        
                        $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/thumb/";
                        $s_dir = preg_replace("/[\r\n]*/","",$s_dir);
                        if(is_dir(@$m_dir))
                        {
                            $iterator = new \FilesystemIterator(@$m_dir);
                            if (@$iterator->valid()){    
                              $m_flag = 1;
                          }
                        }
                        elseif(is_dir(@$s_dir))
                        {
                            $iterator = new \FilesystemIterator(@$s_dir);
                                if (@$iterator->valid()){    
                                  $m_flag = 1;
                              }
                      	}else{
                                $m_flag = 0;
                              }

                          //if($m_flag):
                          	$confirm_msg 	= "return confirm('Are you sure?')";
      						$nestedData[]  	= '<div style="width:100px;"> <div style="float:left;margin-right:8px;"> <form action="'.base_url().'tolist/c_tolist/list_item'.'" method="post" accept-charset="utf-8"> <input type="hidden" name="seed_id" value="'.@$row['SEED_ID'].'"/> <input type="submit" name="item_list" title="List to eBay" onclick='.$confirm_msg.' class="btn btn-success btn-sm" value="List"> </form> </div> <div style="float:left;margin-right:8px;"> <a href="'.base_url().'tolist/c_tolist/seed_view_merg/'.$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> </div>';
      						$lister_name = '';
      						$user_name=@$row['USER_NAME'];
                               
                                    if ($row['ENTERED_BY']==5) {
                                       $lister_name = "<b style='color:red;'>".@$user_name.": </b>";
                                    }else {
                                    	if (!empty($user_name)) {
                                    		$lister_name = "<b>".@$user_name.": </b>";
                                    	}
                                      
                                    }
                                   
                             
                                $lister_notes = @$row['OTHER_NOTES'];

                                if($row['ASSIGN_TO'] =='Pk Listers'){
				                  $verified_tr = 'class = "verifi"';
				                }else{
				                  $verified_tr = 'class = "verifinot"';
				                } 
                                // $nestedData[] = $row['ASSIGN_TO'];
      							$nestedData[]  	= '<div '.$verified_tr.' style="width:130px;">'.$row['ASSIGN_TO'].'</div>';
      							$nestedData[]  	= '<div style="width:130px;">'.ucfirst($lister_name).$lister_notes.'</div>';

      						////////////////////////////
      							//$nestedData[] = '';
      							if($m_flag == 1){
      								$totalData += 1;
		    						$totalFiltered += 1;
		      						if (is_dir($m_dir)){
				                        $images = scandir($m_dir);
			                            if (count($images) > 0) { // make sure at least one image exists
			                                $url = $images[2]; // first image
			                                $img = file_get_contents($m_dir.$url);
			                                $img =base64_encode($img);

			                                $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
			                            }
		                          }else{
		                            $images = scandir($s_dir);
		                            // Image selection and display:
		                            //display first image
		                            if (count($images) > 0) { // make sure at least one image exists
		                                $url = $images[2]; // first image
		                               // var_dump($s_dir.$url); exit;
		                                $img = file_get_contents($s_dir.$url);
		                                $img =base64_encode($img);
		                                $nestedData[] = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';  
		                            }
		                          }
                      }else{
                      	$nestedData[] = 'Not Found';
                      }
      					///////////////////////////
                          
                          $nestedData[] = '<div style="width:150px;">'.$row['BARCODE_NO']->load().'</div>';
                        ///////////////////////////
                          $item_condition = '';
                          if(@$row['ITEM_CONDITION'] == 3000 ){
                          	$item_condition =  "USED";
                          	}elseif(@$row['ITEM_CONDITION'] == 1000 ){
                        	$item_condition = "NEW";
	                        }elseif(@$row['ITEM_CONDITION'] == 1500 ){
	                        	$item_condition = "NEW OTHER";
	                        }elseif(@$row['ITEM_CONDITION'] == 2000 ){
	                        	$item_condition = "MANUFACTURER REFURBISHED";
	                        }elseif(@$row['ITEM_CONDITION'] == 2500 ){
	                        	$item_condition = "SELLER REFURBISHED";
	                        }elseif(@$row['ITEM_CONDITION'] == 7000 ){
	                        	$item_condition = "FOR PARTS OR NOT WORKING";
	                        }elseif(@$row['ITEM_CONDITION'] == 4000 ){
	                        	$item_condition = "VERY GOOD";
	                        }elseif(@$row['ITEM_CONDITION'] == 5000 ){
	                        	$item_condition = "GOOD";
	                        }elseif(@$row['ITEM_CONDITION'] == 6000 ){
	                        	$item_condition = "ACCEPTABLE";
	                        }else{
	                        	$item_condition = @$row['ITEM_CONDITION'];
	                        }
	                    $nestedData[] = $item_condition;
	                    $nestedData[] = $row['ITEM_MT_DESC'];
	                    $nestedData[] = $row['QUANTITY'];
	                    $nestedData[] = $row['PURCH_REF_NO'];
	                    $nestedData[] = $row['UPC'];
	                    $nestedData[] = $row['MFG_PART_NO'];
	                    $nestedData[] = $row['MANUFACTURER'];
	                    $nestedData[] = $row['BIN_NAME'];
	                    $nestedData[] = $row['BIN_ID'];
	                    //////////////////////////
	                    $current_timestamp 	= date('m/d/Y');
                        $purchase_date 		= @$row['LOADING_DATE'];
                        
                        $date1 				=date_create($current_timestamp);
                        $date2 				=date_create($purchase_date);
                        $diff 				=date_diff($date1,$date2);
                        $date_rslt 			= $diff->format("%R%a days");
                        $date_diff 			= abs($date_rslt);
                        $nestedData[] 		= $date_diff." Days";
                        //////////////////////////
      					$data[] 		= $nestedData;
                        //endif; /// end flag
      					$i++;
    }
	/////////////////////////////
    //if(count($data)>0){
	 $json_data = array(
	          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	          "recordsTotal"    =>  intval($totalData),  // total number of records
	          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
	          "deferLoading"    =>  intval( $totalFiltered ),
	          "data"            => $data   // total data array
	          );
    return $json_data;	
	
	}



	public function pic_view(){
	// $from = date('m/d/Y', strtotime('-3 months'));// date('m/01/Y');
	// $to = date('m/d/Y');
	// $fromdate = date_create($from);
	// $todate = date_create($to);
	// $from = date_format($fromdate,'d-m-y');
	// $to = date_format($todate, 'd-m-y');	
    $lister_id = $this->session->userdata('user_id');

    $listing_without_pic_qry = "SELECT LS.APPROVED_BY,LS.APPROVED_DATE,LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";

		//$date_qry = "AND LM.LOADING_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
    $date_qry ="";
		$filter_qry = "";
		if($this->input->post('purchase_no'))
		{
			$purchase_no = $this->input->post('purchase_no');
	        if(is_numeric($purchase_no)){
	  			$filter_qry = "AND (LS.LZ_MANIFEST_ID = $purchase_no OR LM.PURCH_REF_NO = to_char('$purchase_no'))";
	        }else{
	          $filter_qry = "AND LM.PURCH_REF_NO = to_char('$purchase_no')";
	        }
		}

      $listing_without_pic_qry = $this->db->query( $listing_without_pic_qry. " ".$date_qry ." ".$filter_qry);
      $listing_without_pic_qry = $listing_without_pic_qry->result_array();      

      $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL"); 
      $not_listed_barcode =  $not_listed_barcode->result_array();

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $path_query =  $path_query->result_array();

		  return array('path_query'=>$path_query, 'listing_without_pic_qry'=>$listing_without_pic_qry, 'not_listed_barcode'=>$not_listed_barcode);

	}
  public function listedItemsAudit(){


    if($this->input->post('search_lister')){

     $location = $this->input->post('location');

     //$listed_qry = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE  LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID  ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY   QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_STICKER = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND E.LISTER_ID IN(SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = '$location')";
     $listed_qry = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, B_LIST.BARCODE_NO, B.BARCODE_NO PRINT_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC, lz_manifest_mt mn WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_STICKER = 0 AND BC.EBAY_ITEM_ID IS NOT NULL and mn.lz_manifest_id = bc.lz_manifest_id and mn.manifest_type not in (2,3) GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD, (SELECT EBAY_ITEM_ID, REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, BARCODE_NO) ORDER BY EBAY_ITEM_ID DESC NULLS LAST) .GETCLOBVAL(), '<A>', ''), '</A>', ', ') AS BARCODE_NO FROM LZ_BARCODE_MT b, lz_manifest_mt mn where mn.lz_manifest_id = b.lz_manifest_id and mn.manifest_type not in (2,3) GROUP BY EBAY_ITEM_ID) B_LIST, LZ_BARCODE_MT B WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND BCD.EBAY_ITEM_ID = B_LIST.EBAY_ITEM_ID AND B.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND B.ITEM_ID = BCD.ITEM_ID AND B.CONDITION_ID = BCD.CONDITION_ID AND B.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID and lm.manifest_type not in (2,3) AND B.EBAY_STICKER = 0 AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = '$location')"; 
 }else{
        
       //$listed_qry = "SELECT LS.SEED_ID,BCD.BARCODE_NO, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.BARCODE_NO, BCD.CONDITION_ID  ITEM_CONDITION, BCD.EBAY_ITEM_ID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.BARCODE_NO,BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_STICKER = 0 AND BC.EBAY_ITEM_ID IS NOT NULL) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND E.LISTER_ID IN(SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK')";
       $listed_qry = "SELECT LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, B_LIST.BARCODE_NO, B.BARCODE_NO PRINT_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC, lz_manifest_mt mn WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_STICKER = 0 AND BC.EBAY_ITEM_ID IS NOT NULL and mn.lz_manifest_id = bc.lz_manifest_id and mn.manifest_type not in (2,3) GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD, (SELECT EBAY_ITEM_ID, REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, BARCODE_NO) ORDER BY EBAY_ITEM_ID DESC NULLS LAST) .GETCLOBVAL(), '<A>', ''), '</A>', ', ') AS BARCODE_NO FROM LZ_BARCODE_MT b, lz_manifest_mt mn where mn.lz_manifest_id = b.lz_manifest_id and mn.manifest_type not in (2,3) GROUP BY EBAY_ITEM_ID) B_LIST, LZ_BARCODE_MT B WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND BCD.EBAY_ITEM_ID = B_LIST.EBAY_ITEM_ID AND B.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND B.ITEM_ID = BCD.ITEM_ID AND B.CONDITION_ID = BCD.CONDITION_ID AND B.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID and lm.manifest_type not in (2,3) AND B.EBAY_STICKER = 0 AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK')";
        }
   if($this->input->post('search_lister')){
	  	$rslt = $this->input->post('date_range');
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
		$date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
	    $listed_qry = $this->db->query( $listed_qry." ".$date_qry." ORDER BY LIST_DATE DESC");
        $listed_qry = $listed_qry->result_array();
	}else{

	    //$from = date('d-m-y');
	    $from = date('Y-m-d', strtotime('-1 days'));
	    //var_dump(date('Y-m-d', strtotime('-1 days')));exit;
	    $to = date('Y-m-d');
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
		$listed_qry = $this->db->query( $listed_qry." ".$date_qry." ORDER BY LIST_DATE DESC");
        $listed_qry = $listed_qry->result_array();
	}
        
        //var_dump($listing_qry);exit;


        $listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO, BC.EBAY_ITEM_ID FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND  BC.EBAY_STICKER <> 1 AND BC.EBAY_ITEM_ID IS NOT NULL "); 
        $listed_barcode =  $listed_barcode->result_array();      

		$path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
		$path_query =  $path_query->result_array();

		$path_2 = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
		$path_2 =  $path_2->result_array();

    return array('listed_qry'=>$listed_qry, 'listed_barcode'=>$listed_barcode, 'path_query'=>$path_query,'path_2'=>$path_2);    
  }
	/*================================================
	=            copy from m_seed_process            =
	================================================*/
	
	function add($item_id,$manifest_id) {

  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  //$title = trim(str_replace(array("'"), "''", $title));
  $item_desc = $this->input->post('item_desc');
  $item_desc = trim(str_replace("  ", ' ', $item_desc));
  //$item_desc = trim(str_replace(array("'"), "''", $item_desc));
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $template_name = trim(str_replace("  ", ' ', $template_name));
  //$template_name = trim(str_replace(array("'"), "''", $template_name));
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category_id = $this->input->post('category_id');
  $category_name = $this->input->post('category_name');
  $category_name = trim(str_replace("  ", ' ', $category_name));
  //$category_name = trim(str_replace(array("'"), "''", $category_name));
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $ship_from = trim(str_replace("  ", ' ', $ship_from));
  //$ship_from = trim(str_replace(array("'"), "''", $ship_from));
  $bid_length = $this->input->post('bid_length');
  $default_condition = $this->input->post('default_condition');
  $default_description = $this->input->post('default_description');
  $default_description = trim(str_replace("  ", ' ', $default_description));
  //$default_description = trim(str_replace(array("'"), "''", $default_description));
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  $return_accepted = $this->input->post('return_accepted');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $entered_by = $this->session->userdata('user_id');
  date_default_timezone_set("America/Chicago");
  $created_date = date("Y-m-d H:i:s");
  $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";
  
  $data = array(
   'ITEM_ID' => $item_id,
   'ITEM_TITLE' => $title,
   'ITEM_DESC' => $item_desc,
   'EBAY_PRICE' => $price,
   'TEMPLATE_ID' => $template_name,
   'EBAY_LOCAL' => $site_id,
   'CURRENCY' => $currency,
   'LIST_TYPE' => $listing_type,
   'CATEGORY_ID' => $category_id,
   'CATEGORY_NAME' => $category_name,
   'SHIP_FROM_ZIP_CODE' => $zip_code,
   'SHIP_FROM_LOC' => $ship_from,
   'BID_LENGTH' => $bid_length,
   'DEFAULT_COND' => $default_condition,
   'DETAIL_COND' => $default_description,
   'PAYMENT_METHOD' => $payment_method,
   'PAYPAL_EMAIL' => $paypal,
   'DISPATCH_TIME_MAX' => $dispatch_time,
   'SHIPPING_COST' => $shipping_cost,
   'ADDITIONAL_COST' => $additional_cost,
   'RETURN_OPTION' => $return_accepted,
   'RETURN_DAYS' => $return_within,
   'SHIPPING_PAID_BY' => $cost_paidby,
   'SHIPPING_SERVICE' => $shipping_service,
   'LZ_MANIFEST_ID' => $manifest_id,
   'ENTERED_BY' => $entered_by,
   'DATE_TIME' => $created_date
   
  );
   $this->db->insert('LZ_ITEM_SEED', $data);
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);

  
 }
 function update() {
 	// upc_seed
 	// manufacturer
 	// part_no_seed

 	$fupc_seed = $this->input->post('upc_seed');
  	$fupc_seed = trim(str_replace("  ", ' ', $fupc_seed));
  	$fupc_seed = trim(str_replace(array("'"), "''", $fupc_seed));

  	$fmanufacturer = $this->input->post('manufacturer');
  	$fmanufacturer = trim(str_replace("  ", ' ', $fmanufacturer));
  	$fmanufacturer = trim(str_replace(array("'"), "''", $fmanufacturer));


  	$fpart_no_seed = $this->input->post('part_no_seed');
  	$fpart_no_seed = trim(str_replace("  ", ' ', $fpart_no_seed));
  	$fpart_no_seed = trim(str_replace(array("'"), "''", $fpart_no_seed));

  	$old_upc =$this->input->post('old_upc');
  	$old_mpn = $this->input->post('old_mpn');

  	// var_dump($fupc_seed,$fmanufacturer,$fpart_no_seed);
  	// exit;


  $ship_change =$this->input->post('ship_change');
  $ship_fee =$this->input->post('ship_fee');
  $seed_id = $this->input->post('seed_id');
  $item_id = $this->input->post('pic_item_id');
  $manifest_id = $this->input->post('pic_manifest_id');


  // var_dump($item_id,$manifest_id);
  // exit;
  $item_code = $this->input->post('erp_code');
  $object_id = $this->input->post('object_id');
  $weight = $this->input->post('weight');
  $barcode=  $this->input->post('list_barcode');
  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  $title = trim(str_replace(array("'"), "''", $title));
  //var_dump($title);exit
  $item_desc = $this->input->post('item_desc');
  $item_desc = trim(str_replace("  ", ' ', $item_desc));
  $item_desc = trim(str_replace(array("'"), "''", $item_desc));
  $price = $this->input->post('price');
  $template_name = $this->input->post('template_name');
  $template_name = trim(str_replace("  ", ' ', $template_name));
  $template_name = trim(str_replace(array("'"), "''", $template_name));  
  $site_id = $this->input->post('site_id');
  $currency = $this->input->post('currency');
  $listing_type = $this->input->post('listing_type');
  $category_id = $this->input->post('category_id');
  $category_name = $this->input->post('category_name');
  $category_name = trim(str_replace("  ", ' ', $category_name));
  $category_name = trim(str_replace(array("'"), "''", $category_name));  
  $zip_code = $this->input->post('zip_code');
  $ship_from = $this->input->post('ship_from');
  $ship_from = trim(str_replace("  ", ' ', $ship_from));
  $ship_from = trim(str_replace(array("'"), "''", $ship_from));  
  $bid_length = $this->input->post('bid_length');
  $barcode_condition = $this->input->post('pic_condition_id');
  $default_condition = $this->input->post('it_condition');
  $other_notes =$this->input->post('other_notes');
  $other_notes = trim(str_replace("  ", ' ', $other_notes));
  $other_notes = trim(str_replace(array("'"), "''", $other_notes));
  $bin_name =$this->input->post('bin_name');
  $bin_name = trim(str_replace("  ", ' ', $bin_name));
  $bin_name = strtoupper(trim(str_replace(array("'"), "''", $bin_name)));
  $default_description = $this->input->post('default_description');
  $default_description = trim(str_replace("  ", ' ', $default_description));
  $default_description = trim(str_replace(array("'"), "''", $default_description));  
  $payment_method = $this->input->post('payment_method');
  $paypal = $this->input->post('paypal');
  $dispatch_time = $this->input->post('dispatch_time');
  $shipping_service = $this->input->post('shipping_service');
  $shipping_cost = $this->input->post('shipping_cost');
  $additional_cost = $this->input->post('additional_cost');
  //$return_accepted = $this->input->post('return_accepted');
  $return_accepted = $this->input->post('return_option');
  $return_within = $this->input->post('return_within');
  $cost_paidby = $this->input->post('cost_paidby');
  $epid = $this->input->post('item_epid');
  $expiryDate = $this->input->post('expiryDate');
  $expiryDate= "TO_DATE('".$expiryDate."', 'DD/MM/YYYY')";
  //var_dump($expiryDate);exit;
  $entered_by = $this->session->userdata('user_id');
  date_default_timezone_set("America/Chicago");
  $created_date = date("Y-m-d H:i:s");
  $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";


  // query 
  $qry = $this->db->query("SELECT COND_NAME FROM LZ_ITEM_COND_MT WHERE ID = $default_condition")->result_array();
	$condition_disc = $qry[0]['COND_NAME'];
	$pic_dir = $this->input->post('pic_dir');// old dir
	$condition_name = $this->input->post('condition_name');

if(!empty($barcode_condition) AND $barcode_condition !== $default_condition){
	$this->db->query("UPDATE LZ_BARCODE_MT SET CONDITION_ID = $default_condition  WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $barcode_condition AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL"); 

	$this->db->query(" UPDATE LZ_ITEM_SEED SET ITEM_ID = $item_id, ITEM_TITLE = '$title', ITEM_DESC = '$item_desc', EBAY_PRICE = $price, TEMPLATE_ID = $template_name, EBAY_LOCAL = $site_id, CURRENCY = '$currency', LIST_TYPE = '$listing_type', CATEGORY_ID = $category_id, CATEGORY_NAME = '$category_name', SHIP_FROM_ZIP_CODE = $zip_code, SHIP_FROM_LOC = '$ship_from', BID_LENGTH = NULL, DEFAULT_COND = $default_condition, DETAIL_COND = '$default_description', PAYMENT_METHOD = '$payment_method', PAYPAL_EMAIL = '$paypal', DISPATCH_TIME_MAX = $dispatch_time, SHIPPING_COST = $shipping_cost, ADDITIONAL_COST = $additional_cost, RETURN_OPTION = '$return_accepted', RETURN_DAYS = $return_within, SHIPPING_PAID_BY = '$cost_paidby', SHIPPING_SERVICE = '$shipping_service', LZ_MANIFEST_ID = $manifest_id, ENTERED_BY = $entered_by, DATE_TIME = $created_date, OTHER_NOTES='$other_notes', EPID = '$epid',F_UPC ='$fupc_seed',F_MPN='$fpart_no_seed',F_MANUFACTURE='$fmanufacturer',expiry_date = $expiryDate  WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND DEFAULT_COND = $default_condition");
/*==============================================================
=            update condition in dir to attach pix             =
==============================================================*/
		 

$cond_update =false;
if($old_upc !== $fupc_seed || $old_mpn !==$fpart_no_seed){//upc change
			$old_mpn = str_replace("/","_",$old_mpn);
			$old_mpn = str_replace("\\","_",$old_mpn);
			$fpart_no_seed = str_replace("/","_",$fpart_no_seed);
			$fpart_no_seed = str_replace("\\","_",$fpart_no_seed);
			$old_dir = $pic_dir.$old_upc.'~'.$old_mpn;//.'/'.$condition_disc;
			$new_dir = $pic_dir.$fupc_seed.'~'.$fpart_no_seed;//.'/'.$condition_name;

			if(!is_dir(@$new_dir)){
			//var_dump($old_dir,$new_dir);
			//exit;
			rename(@$old_dir, @$new_dir);
			}

			if(empty($barcode)){

				$old_dir = $new_dir.'/'.$condition_name;
				$new_dir = $new_dir.'/'.$condition_disc;

				if(!is_dir(@$new_dir)){
				// var_dump($old_dir);
				// exit;
				rename(@$old_dir, @$new_dir);
				$cond_update = true;
			}
			}

		}

		if(empty($barcode) && $cond_update == false){	

				$old_mpn = str_replace("/","_",$old_mpn);
				$old_mpn = str_replace("\\","_",$old_mpn);
				$fpart_no_seed = str_replace("/","_",$fpart_no_seed);
				$fpart_no_seed = str_replace("\\","_",$fpart_no_seed);
				$old_dir = $pic_dir.$fupc_seed.'~'.$fpart_no_seed.'/'.$condition_name;
				$new_dir = $pic_dir.$old_upc.'~'.$old_mpn.'/'.$condition_disc;

				if(!is_dir(@$new_dir)){
				// var_dump($old_dir);
				// exit;
				rename(@$old_dir, @$new_dir);
			}
			}





/*=====  End of update condition in dir to attach pix   ======*/
}else{
	$this->db->query(" UPDATE LZ_ITEM_SEED SET SEED_ID = $seed_id, ITEM_ID = $item_id, ITEM_TITLE = '$title', ITEM_DESC = '$item_desc', EBAY_PRICE = $price, TEMPLATE_ID = $template_name, EBAY_LOCAL = $site_id, CURRENCY = '$currency', LIST_TYPE = '$listing_type', CATEGORY_ID = $category_id, CATEGORY_NAME = '$category_name', SHIP_FROM_ZIP_CODE = $zip_code, SHIP_FROM_LOC = '$ship_from', BID_LENGTH = NULL, DEFAULT_COND = $default_condition, DETAIL_COND = '$default_description', PAYMENT_METHOD = '$payment_method', PAYPAL_EMAIL = '$paypal', DISPATCH_TIME_MAX = $dispatch_time, SHIPPING_COST = $shipping_cost, ADDITIONAL_COST = $additional_cost, RETURN_OPTION = '$return_accepted', RETURN_DAYS = $return_within, SHIPPING_PAID_BY = '$cost_paidby', SHIPPING_SERVICE = '$shipping_service', LZ_MANIFEST_ID = $manifest_id, ENTERED_BY = $entered_by, DATE_TIME = $created_date, OTHER_NOTES='$other_notes', EPID = '$epid' ,F_UPC ='$fupc_seed',F_MPN='$fpart_no_seed',F_MANUFACTURE='$fmanufacturer',expiry_date = $expiryDate WHERE SEED_ID  = $seed_id ");

		if($old_upc !== $fupc_seed || $old_mpn !==$fpart_no_seed){//upc change
			$old_mpn = str_replace("/","_",$old_mpn);
			$old_mpn = str_replace("\\","_",$old_mpn);
			$fpart_no_seed = str_replace("/","_",$fpart_no_seed);
			$fpart_no_seed = str_replace("\\","_",$fpart_no_seed);
			$old_dir = $pic_dir.$old_upc.'~'.$old_mpn;//.'/'.$condition_disc;
			$new_dir = $pic_dir.$fupc_seed.'~'.$fpart_no_seed;//.'/'.$condition_name;
			

		if(!is_dir(@$new_dir)){
			
			var_dump($old_dir,$new_dir);
			//exit;
		rename(@$old_dir, @$new_dir);
			}

		} 

}   
  

  
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);
  // ======================================================================

/*================================================
=            update bin in barcode mt            =
================================================*/
	$bin_qry = $this->db->query("SELECT BIN_ID FROM BIN_MT WHERE UPPER(BIN_TYPE) || '-' || BIN_NO = '$bin_name'")->result_array();
	if(count($bin_qry) > 0){
		$bin_id = $bin_qry[0]['BIN_ID'];// new bin location
		$get_barcode = $this->db->query(" SELECT BARCODE_NO,BIN_ID FROM LZ_BARCODE_MT WHERE ITEM_ADJ_DET_ID_FOR_IN IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL AND ITEM_ID = '$item_id' AND LZ_MANIFEST_ID = '$manifest_id' AND CONDITION_ID = '$default_condition'")->result_array();

		date_default_timezone_set("America/Chicago");
	    $date = date('Y-m-d H:i:s');
	    $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
	    $transfer_by_id = $this->session->userdata('user_id');

	    foreach ($get_barcode as $bar_code_no) {
	      
	      $bar = $bar_code_no['BARCODE_NO'];
	      $old_bin_id = $bar_code_no['BIN_ID'];

		if($old_bin_id != $bin_id){
			  $this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = '$bin_id' WHERE BARCODE_NO = $bar");

		      $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL");
		      $rs = $qry->result_array();
		      $loc_trans_id = $rs[0]['ID'];

		      $updateBin = $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS) VALUES($loc_trans_id, $transfer_date, $bar, $transfer_by_id, $bin_id, $old_bin_id, 'null')");
	      }
		}     
	      
	}

/*=====  End of update bin in barcode mt  ======*/
	if(!empty($ship_change)){
  		$ship_fee = $ship_change;
  	}
  /*======================================================
  =            update weight in lz_manifest_det            =
  ======================================================*/
  if(!empty($weight)){
  	
  	$this->db->query("UPDATE LZ_MANIFEST_DET  SET WEIGHT = '$weight', SHIP_FEE = '$ship_fee' WHERE LAPTOP_ITEM_CODE = '$item_code'");
	/*==================================================================
	=            update weight & ship service in objects_mt            =
	==================================================================*/
		$get_mpn = $this->db->query("SELECT UPPER(I.ITEM_MT_MFG_PART_NO) MPN FROM ITEMS_MT I WHERE I.ITEM_ID =  '$item_id'")->result_array();
		$mpn = $get_mpn[0]['MPN'];
		if(!empty($object_id)){
			$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET WEIGHT = '$weight' , SHIP_SERV = '$shipping_service' WHERE OBJECT_ID = '$object_id'");
		}else{
			$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET WEIGHT = '$weight' , SHIP_SERV = '$shipping_service' WHERE OBJECT_ID = (SELECT C.OBJECT_ID FROM LZ_CATALOGUE_MT C WHERE UPPER(C.MPN) = '$mpn' AND C.CATEGORY_ID = '$category_id')");
		}
		

	/*=====  End of update weight & ship service in objects_mt  ======*/
  }else{
  	$this->db->query("UPDATE LZ_MANIFEST_DET  SET SHIP_FEE = '$ship_fee' WHERE LAPTOP_ITEM_CODE = '$item_code'");
	/*==================================================================
	=            update weight & ship service in objects_mt            =
	==================================================================*/
		$get_mpn = $this->db->query("SELECT UPPER(I.ITEM_MT_MFG_PART_NO) MPN FROM ITEMS_MT I WHERE I.ITEM_ID =  '$item_id'")->result_array();
		$mpn = $get_mpn[0]['MPN'];
		$this->db->query("UPDATE LZ_BD_OBJECTS_MT SET SHIP_SERV = '$shipping_service' WHERE OBJECT_ID = (SELECT C.OBJECT_ID FROM LZ_CATALOGUE_MT C WHERE UPPER(C.MPN) = '$mpn' AND C.CATEGORY_ID = '$category_id')");

	/*=====  End of update weight & ship service in objects_mt  ======*/
  }
  /*=====  End of update weight in lz_manifest_det  ======*/
  
  /*================================================================
  =            get updated seed id for redirect purpose            =
  ================================================================*/
  $seed_qry = $this->db->query("SELECT SEED_ID FROM LZ_ITEM_SEED WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND DEFAULT_COND = $default_condition")->result_array();
  $seed_id = $seed_qry[0]['SEED_ID'];
  return $seed_id;
  /*=====  End of get updated seed id for redirect purpose  ======*/  

 }
 /*================================================
	=            copy from m_seed_process            =
	================================================*/
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
	      10 =>'ITEM_MT_MFG_PART_NO',
	      11 =>'ITEM_MT_MANUFACTURE',
	      12 =>'BIN_NAME',
	      13 =>null,
	      14 =>null,
	      15 =>'SOLD_STAT'
	    );
	    $this->session->unset_userdata('searchdata');
	    $location    = $this->input->post('search_location');
        $rslt         = $this->input->post('search_date');
        $this->session->set_userdata('searchdata', ['location'=>$location, 'dateRange'=>$rslt]);
        $searchedData =  $this->session->userdata('searchdata');

	   $listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC,BM.BIN_TYPE BI_TYP, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_MT_UPC UPC, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, BIN_MT BM, LZ_BARCODE_MT BCD, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID  AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID and lm.manifest_type not in ( 3,4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID ";
 
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
		$date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
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

	$listed_qry.= " ORDER BY LIST_DATE DESC";   
	$qry = $this->db->query($listed_qry);
	$totalData = $qry->num_rows();
	$totalFiltered = $totalData;
	//var_dump($totalData, $totalFiltered); exit;
	//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
	$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($listed_qry) q )";
	$sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
	if (!empty($columns[$requestData['order'][0]['column']])) {
		$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
	}
    $query = $this->db->query($sql);
    $query = $query->result_array();
    //var_dump(count($query)); exit;
    $data = array();
    $i =0;
    foreach($query as $row ){ 
      	$nestedData= array();
      	$nestedData[] = '<div style="width:180px;"><div style="float:left;margin-right:2px;"> <a  id = "brc_del" cid ="'.$row['BARCODE_NO'].'" title="Remove from audit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> </div><div style="float:left;margin-right:2px;"> <a href="'.base_url().'tolist/c_tolist/seed_view/'.@$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> <a style=" margin-right: 2px;" id="print_bttn" listId="'.@$row['LIST_ID'].'" barCode="'.@$row['BARCODE_NO'].'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a> <a style=" margin-right: 2px;" id="print_bttn_auto" listIdAuto="'.@$row['LIST_ID'].'" barCodeAuto="'.@$row['BARCODE_NO'].'" title="Print Sticker Auto on Firefox" class="btn btn-primary btn-sm" target="_blank">Auto Print</a></div>';
      		
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

          //$path_2 = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2")->result_array();

          	$mpn 					= str_replace('/', '_', @$row['MFG_PART_NO']);
		    $master_path 			= $path_query[0]['MASTER_PATH'];
		    $m_dir 					= $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/thumb/";
		    $specific_path 			= $path_query[0]['SPECIFIC_PATH'];

		    $s_dir 					= $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/thumb/";

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
	  		$user_name = "";
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

    		if($row['BI_TYP'] =='WB'){
				$ver ='class ="verified"';
			}else{
				$ver ='class ="notverified"';
			}

			if($row['SOLD_STAT'] !='AVAILABLE'){
				$vert ='class ="verifiedt"';
			}else{
				$vert ='class ="notverified"';
			} 
  
    		//$row['BIN_NAME']  CHANGE CODE
    		$nestedData[] = '<a '.$ver.'  href="'.base_url().'tolist/c_tolist/transfer_location/'.@$row['BIN_NAME'].'" target="_blank">'.@$row['BIN_NAME'].'</a>';
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
	/*================================================
	=            copy from m_seed_process            =
	================================================*/
function view($item_id,$manifest_id,$condition_id) 
 {
    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $path_query =  $path_query->result_array();
/*==============================================================================
=            query to fetch weghit and ship service from objects_mt            =
==============================================================================*/
	// SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_MT_MANUFACTURE MANUFACTURE, I.ITEM_MT_MFG_PART_NO PART_NO, I.ITEM_MT_BBY_SKU     SKU, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION, BCD.QTY               QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE, O.SHIP_SERV, O.WEIGHT FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND O.OBJECT_ID = C.OBJECT_ID(+) AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND LS.CATEGORY_ID = C.CATEGORY_ID(+) AND S.LZ_MANIFEST_ID = $manifest_id AND S.ITEM_ID = $item_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1

/*=====  End of query to fetch weghit and ship service from objects_mt  ======*/

   /*================================  display seed   =============================*/
   //$S_Result = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, S.* FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_BARCODE_MT B WHERE B.ITEM_ID = S.ITEM_ID AND I.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.ITEM_ID = $item_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1"); 
   $S_Result = $this->db->query("SELECT B.BARCODE_NO IT_BARCODE, DECODE(S.F_MPN,NULL,I.ITEM_MT_MFG_PART_NO,S.F_MPN) MFG_PART_NO ,
   	I.ITEM_MT_MFG_PART_NO OLD_MFG_PART_NO, /*DECODE(S.F_UPC,NULL,I.ITEM_MT_UPC,S.F_UPC)*/ S.F_UPC UPC,I.ITEM_MT_UPC OLD_UPC, DECODE(S.F_MANUFACTURE,NULL,I.ITEM_MT_MANUFACTURE,S.F_MANUFACTURE) MANUFACTURER, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC,  D.WEIGHT, S.*,TO_CHAR(S.EXPIRY_DATE, 'DD/MM/YYYY') as EXPIRE_DATE  ,R.GENERAL_RULE, R.SPECIFIC_RULE, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NAME, C.COND_NAME FROM LZ_ITEM_SEED     S, LZ_BARCODE_MT    B, LZ_MANIFEST_DET  D, ITEMS_MT         I, LZ_LISTING_RULES R, BIN_MT           BM, LZ_ITEM_COND_MT C WHERE B.ITEM_ID = S.ITEM_ID AND I.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND R.ITEM_CONDITION = S.DEFAULT_COND AND D.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND BM.BIN_ID = B.BIN_ID AND S.DEFAULT_COND = C.ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.ITEM_ID = $item_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1"); $S_Result = $S_Result->result();
   

    $all_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id AND B.LZ_MANIFEST_ID = $manifest_id AND B.CONDITION_ID = $condition_id");
    $all_barcode_qry =  $all_barcode_qry->result_array();
    $pic_note =  [];
    foreach($all_barcode_qry as $barcode){

      $pic_note_query = $this->db->query("SELECT B.BARCODE_NO LZ_BARCODE_ID, TD.SPECIAL_REMARKS, B.BARCODE_NOTES,TD.PIC_NOTE FROM LZ_TESTING_DATA TD , LZ_BARCODE_MT B WHERE B.LZ_BARCODE_MT_ID =  TD.LZ_BARCODE_ID (+) AND B.BARCODE_NO = ".$barcode['BARCODE_NO']." AND ROWNUM = 1");
      if($pic_note_query->num_rows() > 0){
          $pic_note_ = $pic_note_query->result_array();
          //$note = @$pic_note_[0]['BARCODE_NOTES'];
          $pic_note[]=$pic_note_;
          // var_dump(@$pic_note_query[0]['BARCODE_NOTES']);
          // exit;
          //array_push(@$pic_note, @$note);
      }
    }
 
/*=================================================
=            get available qty to list            =
=================================================*/

	$list_qty = $this->db->query("SELECT COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL AND BC.LZ_MANIFEST_ID = $manifest_id AND BC.ITEM_ID = $item_id  AND BC.CONDITION_ID = $condition_id GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID"); 
	if($list_qty->num_rows() > 0){
		$list_qty = $list_qty->result_array();	    
	}else{
		$list_qty = null;
	}

/*=====  End of get available qty to list  ======*/



	// $weight_qry = $this->db->query("SELECT LS.WEIGHT_KG FROM LZ_SINGLE_ENTRY LS WHERE LS.ID = (select m.single_entry_id from lz_manifest_mt m where m.lz_manifest_id = $manifest_id)");
	// if($weight_qry->num_rows() > 0){  	
	// 	$weight_qry = $weight_qry->result_array();	    
	// }else{
	// 	$weight_qry = null;
	// }
//var_dump($barcode_arr);exit;
	$ebay_paypal_qry = $this->db->query("SELECT ITEM_ID,PAYPAL_FEE,EBAY_FEE FROM (SELECT SD.SALES_RECORD_NUMBER, E.ITEM_ID, ROUND((SD.PAYPAL_PER_TRANS_FEE / SD.SALE_PRICE) * 100, 2) PAYPAL_FEE, ROUND((SD.EBAY_FEE_PERC / SD.SALE_PRICE) * 100, 2) EBAY_FEE FROM LZ_SALESLOAD_DET SD, EBAY_LIST_MT E WHERE SD.ITEM_ID = E.EBAY_ITEM_ID AND SD.SALE_PRICE > 0 AND SD.PAYPAL_PER_TRANS_FEE > 0 AND SD.EBAY_FEE_PERC > 0 AND SD.QUANTITY = 1 AND E.ITEM_ID = $item_id ORDER BY SD.SALES_RECORD_NUMBER DESC) WHERE ROWNUM =1"); 
	if($ebay_paypal_qry->num_rows() > 0){
			$ebay_paypal_qry = $ebay_paypal_qry->result_array();	    
		}else{
			$ebay_paypal_qry = null;
		}
		$ship_fee_qry = $this->db->query(" SELECT * FROM ( SELECT DISTINCT D.SHIP_FEE FROM LZ_MANIFEST_DET D WHERE D.LAPTOP_ITEM_CODE = (SELECT ITEM_CODE FROM ITEMS_MT WHERE ITEM_ID = $item_id) AND D.SHIP_FEE IS NOT NULL ORDER BY D.SHIP_FEE DESC) WHERE ROWNUM =1"); 
		if($ship_fee_qry->num_rows() > 0){
			$ship_fee_qry = $ship_fee_qry->result_array();	    
		}else{
			$category_id = $S_Result[0]->CATEGORY_ID;
   			$mpn = $S_Result[0]->MFG_PART_NO;
   			$ship_fee_qry = $this->db->query("SELECT O.SHIP_SERV SHIP_FEE,O.WEIGHT FROM LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE O.OBJECT_ID = C.OBJECT_ID AND C.CATEGORY_ID = '$category_id' AND UPPER(TRIM(C.MPN)) = UPPER(TRIM('$mpn'))");
   			if($ship_fee_qry->num_rows() > 0){
			$ship_fee_qry = $ship_fee_qry->result_array();	    
			}else{ 
	   			$ship_fee_qry = null;
	   		}
		}
		$cost_qry = $this->db->query("SELECT D.LZ_MANIFEST_ID, I.ITEM_ID, MAX(D.PO_DETAIL_RETIAL_PRICE) COST_PRICE FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = $item_id AND D.LZ_MANIFEST_ID = $manifest_id GROUP BY D.LZ_MANIFEST_ID, I.ITEM_ID"); 
		if($cost_qry->num_rows() > 0){
			$cost_qry = $cost_qry->result_array();	    
		}else{
			$cost_qry = null;
		}
		/*=====================================
		=            get object id            =
		=====================================*/
		$category_id = $S_Result[0]->CATEGORY_ID;
		$mpn = $S_Result[0]->MFG_PART_NO;
		$obj_qry = $this->db->query("SELECT C.OBJECT_ID FROM LZ_CATALOGUE_MT C WHERE C.CATEGORY_ID = $category_id AND UPPER(C.MPN) = UPPER('$mpn')");
		$obj_qry = $obj_qry->result_array(); 
		/*=====  End of get object id  ======*/

	/*=========================================================
	=            select item specific if available            =
	=========================================================*/
		$spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id");
		$spec_query = $spec_query->result_array();

		if(count($spec_query) == 0){
			$spec_query = "";
		}
	/*=====  End of select item specific if available  ======*/
	/*==============================================
	=            get condition dropdown            =
	==============================================*/

	$get_cond = $this->db->query("SELECT ID,COND_NAME FROM LZ_ITEM_COND_MT ORDER BY ID ASC")->result_array();

	/*=====  End of get condition dropdown  ======*/
	/*============================================
	=            get last three title            =
	============================================*/
	$current_title = strtoupper(trim($S_Result[0]->ITEM_TITLE));
	$current_title = str_replace("  ", ' ', $current_title);
    $current_title = str_replace(array("'"), "''", $current_title);
	//$history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE FROM (SELECT S.ITEM_TITLE FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.DEFAULT_COND = '$condition_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE ROWNUM < 4 ");
	// $history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE,EBAY_PRICE,DATE_TIME FROM (SELECT S.ITEM_TITLE,S.EBAY_PRICE,S.DATE_TIME FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.DEFAULT_COND = '$condition_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE ROWNUM < 4 ");
	
	$history_title = $this->db->query("SELECT * FROM (SELECT ITEM_TITLE, EBAY_PRICE, DATE_TIME FROM (SELECT L.EBAY_ITEM_DESC ITEM_TITLE,L.LIST_PRICE EBAY_PRICE,L.LIST_DATE DATE_TIME FROM EBAY_LIST_MT L WHERE L.ITEM_ID  = '$item_id' AND L.ITEM_CONDITION = '$condition_id'  ORDER BY L.LIST_ID  DESC)) WHERE ROWNUM < 4 ");

	 if($history_title->num_rows() > 0){
		$history_title =  $history_title->result_array();	
	}else{
		//$history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE,ROWNUM RN FROM (SELECT S.ITEM_TITLE FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE  RN <> 1 AND RN < 5");
		// $history_title = $this->db->query("SELECT * FROM (SELECT DISTINCT ITEM_TITLE,EBAY_PRICE,DATE_TIME FROM (SELECT S.ITEM_TITLE,S.EBAY_PRICE,S.DATE_TIME FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = '$item_id' AND S.ITEM_TITLE IS NOT NULL AND UPPER(TRIM(S.ITEM_TITLE)) <> '$current_title' ORDER BY S.SEED_ID DESC)) WHERE ROWNUM < 4 ");

		$history_title = $this->db->query("SELECT * FROM (SELECT ITEM_TITLE, EBAY_PRICE, DATE_TIME FROM (SELECT L.EBAY_ITEM_DESC ITEM_TITLE,L.LIST_PRICE EBAY_PRICE,L.LIST_DATE DATE_TIME FROM EBAY_LIST_MT L WHERE L.ITEM_ID  ='$item_id' AND L.EBAY_ITEM_DESC IS NOT NULL  ORDER BY L.LIST_ID  DESC)) WHERE ROWNUM < 4 ");
		$history_title =  $history_title->result_array(); 
	}
    

    /*=====  End of get last three title  ======*/
    /*==================================
    =            macro type            =
    ==================================*/
    $object_id = @$obj_qry[0]['OBJECT_ID'];
    if(!empty($object_id)){
    	$macro_type = $this->db->query("SELECT DISTINCT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T, LZ_MACRO_MT M WHERE T.TYPE_ID = M.TYPE_ID ORDER BY TYPE_ORDER ASC"); 
    	$macro_type =  $macro_type->result_array();
    	if(count($macro_type) == 0){
    		$macro_type = $this->db->query("SELECT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T ORDER BY T.TYPE_ORDER ASC"); 
    		$macro_type =  $macro_type->result_array();
    	}
    }else{
    	$macro_type = $this->db->query("SELECT T.TYPE_ID,T.TYPE_DESCRIPTION,T.TYPE_ORDER FROM LZ_MACRO_TYPE T ORDER BY T.TYPE_ORDER ASC"); 
    	$macro_type =  $macro_type->result_array();
    }
    
    /*=====  End of macro type  ======*/
    
	/*==========================================
    =            get avialable EPID            =
    ==========================================*/
    
    $get_epid = $this->db->query("SELECT T.EPID, C.TITLE,C.IMAGEURL,C.BRAND FROM LZ_BIND_EPID_DT_TMP T, LZ_EBAY_CATALOGUE_MT C WHERE T.ITEM_ID = '$item_id'AND T.EPID = C.EPID(+)");
    $get_epid =  $get_epid->result_array();
    
    /*=====  End of get avialable EPID  ======*/
    	// code added by adil asad 2-6-2018
	$get_barcode = $this->uri->segment(5);
	//var_dump($get_barcode);
	if(!empty($get_barcode) ){

		$get_remark = $this->db->query("SELECT KK.DEKIT_REMARKS, KK.IDENT_REMARKS,KK.BARCODE_NOTES FROM LZ_DEKIT_US_DT KK WHERE KK.BARCODE_PRV_NO = $get_barcode")->result_array();
		if(count($get_remark) == 0){
			$get_remark = $this->db->query("SELECT L.PIC_NOTES IDENT_REMARKS, L.LOT_REMARKS DEKIT_REMARKS,L.BARCODE_NOTES FROM LZ_SPECIAL_LOTS L  WHERE L.BARCODE_PRV_NO = $get_barcode")->result_array();
		}

	}else{
		$get_remark = '';

	}
	// code added by adil asad 2-6-2018
	/*========================================
	=            get ship service            =
	========================================*/
	$ship_serv = $this->db->query("SELECT * FROM LZ_SHIPING_NAME");
    $ship_serv =  $ship_serv->result_array();
	/*=====  End of get ship service  ======*/
	
   return array('result'=>$S_Result, 'path_query'=>$path_query,'pic_note'=>$pic_note, 'list_qty'=>$list_qty,'ebay_paypal_qry'=>$ebay_paypal_qry, 'ship_fee_qry'=>$ship_fee_qry, 'cost_qry'=>$cost_qry, 'spec_query'=>$spec_query,'get_cond'=>$get_cond,'history_title'=>$history_title,'macro_type'=>$macro_type,'get_epid'=>$get_epid,'obj_qry'=>$obj_qry,'get_remark'=>$get_remark,'ship_serv'=>$ship_serv);
   
   /*=====  End of display seed   ======*/
   

}

 function edit($a) {
  $d = $this->db->get_where('LZ_ITEM_SEED', array('ITEM_ID' => $a))->row();
  return $d;
 }
  function delete($a) {
  $this->db->delete('LZ_ITEM_SEED', array('ITEM_ID' => $a));
  return;
 }

 function template_fields()
 {

// for this query in VIEW use this $row['VALUE']; instead of $row->VALUE;
  $query = $this->db->query("SELECT TEMPLATE_ID,TEMPLATE_NAME FROM LZ_ITEM_TEMPLATE ORDER BY TEMPLATE_NAME DESC");
      return $query->result_array();
//    $query = $this->db->select('TEMPLATE_ID,TEMPLATE_NAME');
//    $query = $this->db->from('LZ_ITEM_TEMPLATE');

// return $query->result_array();
    // $temp_result = $this->db->get();
    // return $temp_result;
    
 }
	
	/*=====  End of copy from m_seed_process  ======*/


	/*===============================================
	=            copy from listing model            =
	===============================================*/
	public function is_active_listing($item_id,$condition_id,$upc,$mpn){
			$lz_seller_acct_id= $this->session->userdata('account_type');
			//$q = $this->db->query("SELECT MAX(EBAY_ITEM_ID) EBAY_ITEM_ID FROM EBAY_LIST_MT WHERE ITEM_ID = $item_id AND ITEM_CONDITION = $condition_id AND LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID");
      //$q = $this->db->query("SELECT MAX(L.EBAY_ITEM_ID) EBAY_ITEM_ID FROM EBAY_LIST_MT L, LZ_ITEM_SEED LS WHERE L.ITEM_ID = LS.ITEM_ID AND L.LZ_MANIFEST_ID = LS.LZ_MANIFEST_ID AND L.SEED_ID = LS.SEED_ID AND L.ITEM_ID = $item_id AND LS.DEFAULT_COND = $condition_id AND L.LZ_SELLER_ACCT_ID=$lz_seller_acct_id"); 
      $q = $this->db->query("SELECT is_active_listing('$upc','$mpn',$condition_id,$lz_seller_acct_id) EBAY_ITEM_ID FROM DUAL");
      // $rs = $query->result_array();
      // $loading_no = $rs[0]['ID'];
      $rslt = $q->result_array();
			 if(!empty($rslt)){
			 	$ebay_id=$rslt[0]['EBAY_ITEM_ID'];
			 	$this->session->set_userdata('check_item_id', true);
			 	$this->session->set_userdata('ebay_item_id', $ebay_id);
			 	return true;
			}else{
			 	$this->session->set_userdata('check_item_id', false);
			 	return false;
			  }
		}
	
	public function uplaod_seed($item_id,$manifest_id,$condition_id,$check_btn,$forceRevise){



		if($check_btn == 'revise' AND $forceRevise == 0){
			$query = $this->db->query("SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.F_MANUFACTURE MANUFACTURE,LS.F_MPN PART_NO, I.ITEM_MT_BBY_SKU SKU, LS.F_UPC UPC, LS.DEFAULT_COND ITEM_CONDITION, NULL QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE, C.COND_NAME, LS.EPID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, LZ_ITEM_COND_MT C, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND LS.DEFAULT_COND = C.ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND = $condition_id AND ROWNUM=1");
		}else{
			$query = $this->db->query("SELECT DET.WEIGHT, LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, LS.F_MANUFACTURE MANUFACTURE,LS.F_MPN PART_NO,  I.ITEM_MT_BBY_SKU  SKU, LS.F_UPC UPC, LS.DEFAULT_COND  ITEM_CONDITION, BCD.QTY  QUANTITY, R.GENERAL_RULE, R.SPECIFIC_RULE, C.COND_NAME,LS.EPID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, LZ_MANIFEST_DET DET, ITEMS_MT I, LZ_LISTING_RULES R, LZ_ITEM_COND_MT C, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LM.LZ_MANIFEST_ID = DET.LZ_MANIFEST_ID AND LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND R.ITEM_CONDITION = LS.DEFAULT_COND AND LS.DEFAULT_COND = C.ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND = $condition_id AND ROWNUM=1"); }
			
			
			return $query->result_array(); 
		}
	public function uplaod_seed_pic($item_id,$manifest_id,$condition_id,$seed_id){

		// $query = $this->db->query("SELECT trim(I.ITEM_MT_MFG_PART_NO) ITEM_MT_MFG_PART_NO,trim(I.ITEM_MT_UPC) ITEM_MT_UPC FROM ITEMS_MT I WHERE I.ITEM_ID = $item_id"); 

		$query = $this->db->query("SELECT I.F_UPC ITEM_MT_UPC,I.F_MPN ITEM_MT_MFG_PART_NO FROM LZ_ITEM_SEED I WHERE I.SEED_ID =$seed_id ");
		$result=$query->result_array();
		$mpn = $result[0]['ITEM_MT_MFG_PART_NO'];
		$upc = $result[0]['ITEM_MT_UPC'];
		$it_condition = $condition_id;
	    $query = $this->db->query("SELECT COND_NAME FROM LZ_ITEM_COND_MT WHERE ID = $condition_id"); 
		$result=$query->result_array();
		$it_condition = $result[0]['COND_NAME'];
	    $mpn = str_replace('/', '_', @$mpn);

		/*==============================================
		=            Master Picture Check            =
		==============================================*/
	    $query = $this->db->query("SELECT MASTER_PATH,SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
	    $master_qry = $query->result_array();
	    $master_path = $master_qry[0]['MASTER_PATH'];
	    $specific_path = $master_qry[0]['SPECIFIC_PATH'];

	   	$m_dir = $master_path.@$upc."~".@$mpn."/".@$it_condition;
	    if(is_dir(@$m_dir)){
				  $iterator = new \FilesystemIterator(@$m_dir);
			    if (@$iterator->valid()){    
			    	$m_flag = true;
				}else{
					$m_flag = false;
				}
		}else{
			$m_flag = false;
		}
		/*=====  End of Master Picture Check  ======*/

	/*==============================================
	=            Specific Picture Check            =
	==============================================*/
        $s_dir = $specific_path.@$upc."~".$mpn."/".@$it_condition."/".$manifest_id;
	    // Open a directory, and read its contents
	    if(is_dir(@$s_dir)){
				  $iterator = new \FilesystemIterator(@$s_dir);
			    if (@$iterator->valid()){    
			    	$s_flag = true;
				}else{
					$s_flag = false;
				}
		}else{
			$s_flag = false;
		}
	/*=====  End of Specific Picture Check  ======*/
		if($m_flag && $s_flag){
			return "B";

		}elseif($m_flag === true && $s_flag === false){
			return "M";
		}elseif($m_flag === false && $s_flag === true){
			return "S";
		}else{
			die('Error! Item Picture Not Found.');
		}
	}//end function
		public function item_specifics($item_id, $manifest_id,$condition_id){
		// $item_id = 18786;
		// $manifest_id = 13827;
			//$query = $this->db->query("SELECT I.ITEM_MT_UPC, I.ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");
			$query = $this->db->query("SELECT s.f_upc  ITEM_MT_UPC, s.f_mpn ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");
			$result = $query->result_array();
			if($query->num_rows() > 0){

				if(!empty($result[0]['ITEM_MT_UPC'])){
					$where_upc = " AND MT.UPC = '".$result[0]['ITEM_MT_UPC']."'";
				}else{
					$where_upc = ' ';
				}
				if(!empty($result[0]['ITEM_MT_MFG_PART_NO'])){
					$where_mpn = " AND MT.MPN = '".$result[0]['ITEM_MT_MFG_PART_NO']."'";
				}else{
					$where_mpn = '';
				}

				$spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id AND MT.CATEGORY_ID = ".$result[0]['CATEGORY_ID'].$where_upc.$where_mpn);
				$spec_query = $spec_query->result_array();

			}else{
				$spec_query = "";
			}

			return $spec_query; 

			//var_dump($spec_query);exit ;

			

		}
public function insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$account_id){
	$list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
	$rs = $list_rslt->result_array();
	$LIST_ID = $rs[0]['LIST_ID'];
	$this->session->set_userdata('list_id',$LIST_ID);
	$ebay_id = $this->session->userdata('ebay_item_id');
	$get_acc = $this->db->query("SELECT E.LZ_SELLER_ACCT_ID FROM EBAY_LIST_MT E WHERE E.LIST_ID = (SELECT MIN(LIST_ID) FROM EBAY_LIST_MT EE WHERE EE.EBAY_ITEM_ID = '$ebay_id' AND EE.LZ_SELLER_ACCT_ID IS NOT NULL )"); 
	$rs = $get_acc->result_array();
	if(count($rs) > 0){
		$account_id = $rs[0]['LZ_SELLER_ACCT_ID'];
	}
	if($check_btn == "revise"){
		$status = "UPDATE";
		
		
		// if(@$forceRevise === 1){
		// 	$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		// 	if($query->num_rows() === 0){
		// 		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		// 	}
		// 	$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
		// }else{

		// 	$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		// 	if($query->num_rows() === 0){
		// 		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		// 	}

		// 	$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
		// } 
		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		if($query->num_rows() === 0){
			$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		}

		$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
		
	}else{
		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL  AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
	}//check_btn if else close
		 $rslt_dta = $query->result_array();
	
		//$list_date = date("d/M/Y");// return format Aug/13/2016
		date_default_timezone_set("America/Chicago");
		$list_date = date("Y-m-d H:i:s");
  		$list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$lister_id = $this->session->userdata('user_id');
		$ebay_item_desc = @$rslt_dta[0]['ITEM_TITLE'];
	    $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
	    $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));
	    if($check_btn == "revise"){
	    	//$current_qty = $this->session->userdata('current_qty');
	    	$list_qty = 0;
	    }else{
	    	$list_qty = @$rslt_dta[0]['QUANTITY'];
	    }
		
		$ebay_item_id = $ebay_id;
		$list_price = @$rslt_dta[0]['EBAY_PRICE'];
		$remarks = NULL;
		$single_entry_id = NULL;
		$salvage_qty = 0.00;
		$entry_type ="L";
		$LZ_SELLER_ACCT_ID= $account_id;
		$auth_by_id = $this->session->userdata('auth_by_id');
		$list_qty = "'".$list_qty."'";

		$insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, AUTH_BY_ID,FORCEREVISE)VALUES (".$LIST_ID.",".$manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",".$ebay_item_id.",'".$list_price."',NULL,NULL, NULL, '".$entry_type."',".$LZ_SELLER_ACCT_ID.",".$seed_id.",'".trim($status)."',".$condition_id.", '".$auth_by_id."',".@$forceRevise.")"); 
		if($insert_query){
	    $this->db->query($update_barcode_qry);
	  	$this->db->query("UPDATE LZ_LISTING_ALLOC SET LIST_ID = $LIST_ID WHERE SEED_ID = $seed_id");
	  	return $LIST_ID;
	  }
	
  		
}

public function insert_ebay_id_copy($item_id,$manifest_id,$seed_id,$condition_id,$status,$check_btn,$forceRevise,$accountId,$userId){
	
	$list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
	$rs = $list_rslt->result_array();
	$LIST_ID = $rs[0]['LIST_ID'];
	$this->session->set_userdata('list_id',$LIST_ID);
	$ebay_id = $this->session->userdata('ebay_item_id');

	if($check_btn == "revise"){
		$status = "UPDATE";
		

		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL  AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		if($query->num_rows() === 0){
			$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		}

		$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
		
	}else{
		$query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL  AND BC.LIST_ID IS NULL AND BC.SALE_RECORD_NO IS NULL AND BC.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BC.LZ_PART_ISSUE_MT_ID IS NULL AND BC.LZ_POS_MT_ID IS NULL AND BC.PULLING_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
		$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id, LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NULL AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
	}//check_btn if else close
		 $rslt_dta = $query->result_array();
	
		//$list_date = date("d/M/Y");// return format Aug/13/2016
		date_default_timezone_set("America/Chicago");
		$list_date = date("Y-m-d H:i:s");
  		$list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
		//$lister_id = $this->session->userdata('user_id');
		$lister_id =$userId ;// $this->session->userdata('user_id');
		$ebay_item_desc = @$rslt_dta[0]['ITEM_TITLE'];
	    $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
	    $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));
	    if($check_btn == "revise"){
	    	//$current_qty = $this->session->userdata('current_qty');
	    	$list_qty = 0;
	    }else{
	    	$list_qty = @$rslt_dta[0]['QUANTITY'];
	    }
		
		$ebay_item_id = $ebay_id;
		$list_price = @$rslt_dta[0]['EBAY_PRICE'];
		$remarks = NULL;
		$single_entry_id = NULL;
		$salvage_qty = 0.00;
		$entry_type ="L";

		// $LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');
		// $auth_by_id = $this->session->userdata('auth_by_id');
		//$accountId,$userId
		$LZ_SELLER_ACCT_ID=$accountId;// $this->session->userdata('account_type');
		$auth_by_id = $userId ;//$this->session->userdata('auth_by_id');
	// 	var_dump($LZ_SELLER_ACCT_ID,$auth_by_id);
	// exit;

		$list_qty = "'".$list_qty."'";

		$insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, AUTH_BY_ID,FORCEREVISE)VALUES (".$LIST_ID.",".$manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",".$ebay_item_id.",'".$list_price."',NULL,NULL, NULL, '".$entry_type."',".$LZ_SELLER_ACCT_ID.",".$seed_id.",'".trim($status)."',".$condition_id.", '".$auth_by_id."',".@$forceRevise.")"); 
		if($insert_query){
	    $this->db->query($update_barcode_qry);
	  	$this->db->query("UPDATE LZ_LISTING_ALLOC SET LIST_ID = $LIST_ID WHERE SEED_ID = $seed_id");
	  	return $LIST_ID;
	  }
	
  		
}

	/*=====  End of copy from listing model  ======*/

  public function item_barcode($item_id,$manifest_id,$condition_id){
    $query = $this->db->query("SELECT BARCODE_NO FROM LZ_BARCODE_MT WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id");
    return $query->result_array();
  }
	 public function insert_ebay_url(){
	 $ebay_item_id = $this->session->userdata('ebay_item_id');
	 //$ebay_item_url = $this->session->userdata('ebay_item_url');
	 $ebay_item_url = "https://www.ebay.com/itm/".$ebay_item_id;
	 date_default_timezone_set("America/Chicago");
	 $list_date = date("Y-m-d H:i:s");
     $ins_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
	 $entered_by = $this->session->userdata('user_id');	
	 $comma = ',';
	 $query = $this->db->query("SELECT * FROM LZ_LISTED_ITEM_URL WHERE EBAY_ID = $ebay_item_id");
	 $result = $query->result_array();
	 if($query->num_rows() == 0){
	 	$insert_query = $this->db->query("INSERT INTO LZ_LISTED_ITEM_URL VALUES ($ebay_item_id $comma '$ebay_item_url' $comma $ins_date $comma $entered_by)");
	 }
  }

  public function approvalForListing(){
	 date_default_timezone_set("America/Chicago");
	 $list_date = date("Y-m-d H:i:s");
     $ins_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
	 $entered_by = $this->session->userdata('user_id');
	 $approved_items = $this->input->post('approval');

	 $scan_bin = trim($this->input->post('scan_bin'));
     $scan_bin = str_replace("  ", " ", $scan_bin);
     $scan_bin = str_replace("'", "''", $scan_bin);
     $scan_bin = strtoupper($scan_bin);

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $transfer_by_id = $this->session->userdata('user_id');
	//$bar_codes = $this->input->post('get_bar');
    $flag = 0;
	if(!empty($scan_bin)){
	$bindId = $this->db->query(" SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$scan_bin' ")->result_array(); 
	if(count($bindId) > 0)
	{
       	$bin_id = $bindId[0]['BIN_ID'];
		foreach($approved_items as $seed_id)
		{	
			$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $seed_id");

			$str = trim($seed_id); 	
			$bar_array = $this->db->query("SELECT M.BARCODE_NO FROM LZ_BARCODE_MT M, LZ_ITEM_SEED S WHERE M.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND M.ITEM_ID = S.ITEM_ID AND M.CONDITION_ID = S.DEFAULT_COND AND S.SEED_ID = $seed_id")->result_array();
	 			foreach ($bar_array as $bar)
	  			{
	  				$barcode = $bar['BARCODE_NO'];
	 				$get_curnt_row = $this->db->query(" SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE BARCODE_NO =$barcode");
			      	$get_curnt_row = $get_curnt_row->result_array();
			      	$current_bin_id = $get_curnt_row[0]['BIN_ID'];

			      	$this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = '$bin_id' WHERE BARCODE_NO = $barcode");

			      	$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL");
			      	$rs = $qry->result_array();
			      	$loc_trans_id = $rs[0]['ID'];

			      	$updateBin = $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS) VALUES($loc_trans_id, $transfer_date, $barcode, $transfer_by_id, $bin_id, $current_bin_id, 'null')");
	  			}
	  			if ($updateBin)
	  			{
  					$flag = 1;
  				}
  				else
  				{
  					$flag = 0;
  				}	
			}
		
		}  /// if seed ids count is 0
		else
		{
			$flag = 2;
		}	
 	}
 	else
 	{
 		foreach($approved_items as $seed_id)
		{	
			$query = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.APPROVED_DATE = $ins_date, S.APPROVED_BY = $entered_by WHERE S.SEED_ID = $seed_id");
 		}
 		if ($query)
 		{
 			$flag = 1;
 		}
 		else
 		{
 			$flag = 0;
 		}
 	}
     
    return $flag;	 

	//119979  122950 
 }


/*=============================================
=            For Listed Item Datatable           =
=============================================*/





  public function loadData(){
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'LIST_ID',
			1 =>'EBAY_ITEM_ID',
			2 =>'', 
			3 => 'ITEM_CONDITION',
			4 => 'ITEM_TITLE',
			5 => 'QTY',
			6 => '',
			7 => 'PURCH_REF_NO',
			8 => 'ITEM_MT_UPC',
			9 => 'ITEM_MT_MFG_PART_NO ',
			10 => 'ITEM_MT_MANUFACTURE',
			11 => 'SHIPPING_SERVICE',
			12=>'',
			13=>'LIST_DATE',
			14=>'',
			15=>'STATUS',
		);
		$lister_id = $this->session->userdata('user_id');
    	$users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
	    /*echo "<pre>";
	    print_r($users->result_array());
	    exit;*/

    	$employees = array(2,4,5,7,13,19,27,28,29,30,31,32);
    	$listing_qry = '';
		
    	// if(in_array($lister_id, $employees)){
	      $listing_qry = $this->db->query("SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID");
	    
	    


		

		// $sql = $this->db->query("SELECT LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID FROM LZ_BD_CATAG_DATA WHERE MAIN_CATEGORY_ID = $category_id");
		$totalData = $listing_qry->num_rows();
		// var_dump($totalData);exit;
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
		

		$sql = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID, LS.SHIPPING_SERVICE, E.STATUS, E.LISTER_ID,E.LIST_ID, TO_CHAR(E.LIST_DATE, 'DD-MM-YYYY HH24:MI:SS') as list_date, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.PURCH_REF_NO, I.ITEM_ID, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, BCD.QTY QUANTITY, E_URL.EBAY_URL FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_LISTED_ITEM_URL E_URL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.EBAY_ITEM_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NOT NULL GROUP BY BC.EBAY_ITEM_ID, BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID =LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E_URL.EBAY_ID = BCD.EBAY_ITEM_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID";
		
			// if(is_numeric($sql->BCD.CONDITION_ID)){
			// 	if($sql->BCD.CONDITION_ID == 3000){
   //                $sql->BCD.CONDITION_ID = 'Used';
   //              }elseif($sql->BCD.CONDITION_ID == 1000){
   //                $sql->BCD.CONDITION_ID = 'New'; 
   //              }elseif($sql->BCD.CONDITION_ID == 1500){
   //                $sql->BCD.CONDITION_ID = 'New other'; 
   //              }elseif($sql->BCD.CONDITION_ID== 2000){
   //                $sql->BCD.CONDITION_ID = 'Manufacturer refurbished';
   //              }elseif($sql->BCD.CONDITION_ID == 2500){
   //                $sql->BCD.CONDITION_ID = 'Seller refurbished'; 
   //              }elseif($sql->BCD.CONDITION_ID == 7000){
   //                $sql->BCD.CONDITION_ID = 'For parts or not working'; 
   //              }

			// }

			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( BCD.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LS.SHIPPING_SERVICE LIKE '%".$requestData['search']['value']."%' )";
					
			}else{
				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND (BCD.EBAY_ITEM_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR LS.SHIPPING_SERVICE LIKE '%".$requestData['search']['value']."%' )";
					
				}
			}
			// else{
			
			// 	if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
			// 		$sql.=" AND ( BC.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";    
			// 			$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
			// 			$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
			// 			$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
			// 			$sql.=" OR I.ITEM_MT_MFG_PART_NO '%".$requestData['search']['value']."%' ";
			// 			$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' )";
						
			// 	}
			// }


		$query = $this->db->query($sql);
		
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		 $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
		//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
		$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;
		// echo $sql;
		/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
		//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
		/*=======================================
		=            For Oracle 12-c            =
		=======================================*/
			// $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
		
		
		/*=====  End of For Oracle 12-c  ======*/
		

		
		$query = $this->db->query($sql);
		$query = $query->result_array();
		$data = array();
		// $qry = array_combine(keys, values)

		// print_r($listed_barcode);exit;
		// $qry = array('query'=>$query,'listed_barcode'=>$listed_barcode);
		// print_r($qry);exit;
		// 
		
		foreach($query as $row ){ 
			$nestedData=array();

			$nestedData[] ='<div style="width:100px;"><div style="float:left;margin-right:8px;">
                             <a href="'.base_url().'tolist/c_tolist/seed_view/'.$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         
                             <a style=" margin-right: 3px;" href="'.base_url().'listing/listing/print_label/'.$row['LIST_ID'].'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                          </div>';

			// $nestedData[] =	"<input title='checkbox' type='checkbox' name='select_recognize[]' id='select_recognize' value='".$row['LZ_BD_CATA_ID']."'>";
			
			// $nestedData[] = "";
		    $nestedData[] = $row["EBAY_ITEM_ID"];
		    $listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID = ".$row["ITEM_CONDITION"]."  
				AND BC.LZ_MANIFEST_ID =".$row["LZ_MANIFEST_ID"]." AND BC.ITEM_ID=".$row["ITEM_ID"]." " );
			$listed_barcode =  $listed_barcode->result_array();

			// $nestedData[] = rtrim(implode(',', $listed_barcode), ',');
			$barData  = '';
			foreach($listed_barcode as $barcode){
				$barData.= $barcode['BARCODE_NO'].'-';
			}
			$nestedData[] = $barData;
		    // $nestedData[] ="";
		    // $nestedData[] = $qry['listed_barcode']['BARCODE_NO'];
		    if(is_numeric($row["ITEM_CONDITION"])){
                if($row["ITEM_CONDITION"] == 3000){
                  $nestedData[] = 'Used';
                }elseif($row["ITEM_CONDITION"] == 1000){
                  $nestedData[] = 'New'; 
                }elseif($row["ITEM_CONDITION"] == 1500){
                  $nestedData[] = 'New other'; 
                }elseif($row["ITEM_CONDITION"]== 2000){
                    $nestedData[] = 'Manufacturer refurbished';
                }elseif($row["ITEM_CONDITION"] == 2500){
                  $nestedData[] = 'Seller refurbished'; 
                }elseif($row["ITEM_CONDITION"] == 7000){
                  $nestedData[] = 'For parts or not working'; 
                }
			}
		    // $nestedData[] = $row["ITEM_CONDITION"];
			$nestedData[] = $row["ITEM_MT_DESC"];
			$nestedData[] = $row["QUANTITY"];
			$nestedData[] = "";
			// $nestedData[] = $row["ITEM_TITLE"];
			// $nestedData[] = "<a target='_blank' href='".$row['ITEM_URL']. "'>".$row['EBAY_ID']. "</a>";
			//$nestedData[] = $row["EBAY_ID"];
			$nestedData[] =  $row["PURCH_REF_NO"];
			$nestedData[] = $row["UPC"];
			// $nestedData[] = $row["SELLER_ID"];
			// $nestedData[] = $listing_type;
			// $nestedData[] = '$ '.number_format((float)@$row['SALE_PRICE'],2,'.',',');
			//$nestedData[] = $row["SALE_PRICE"];
			$nestedData[] = $row["MFG_PART_NO"];
			$nestedData[] = $row["MANUFACTURER"];
			$nestedData[] = $row["SHIPPING_SERVICE"];
			$nestedData[] = "";
			$nestedData[] = $row["LIST_DATE"];
			$nestedData[] = "";
			$nestedData[] = $row["STATUS"];
			$data[] = $nestedData;

		}

		$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    =>  intval($totalData),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"deferLoading" =>  intval( $totalFiltered ),
					"data"            => $data   // total data array
					
					);
		return $json_data;


	}

	/*=====  End Listed Item DataTables  ======*/
	 	

/*=============================================
=          For Not Listed Item Datatable            =
=============================================*/


	function secondLoadData(){
		$requestData= $_REQUEST;
		
		$columns = array( 
		// datatable column index  => database column name
			0 =>'SEED_ID',
			1 =>'OTHER_NOTES',
			2 =>'', 
			3 => '',
			4 => 'CONDITION_ID',
			5 => 'ITEM_TITLE',
			6 => 'QTY',
			7 => 'PURCH_REF_NO',
			8 => 'ITEM_MT_UPC',
			9 => 'ITEM_MT_MFG_PART_NO ',
			10 => 'ITEM_MT_MANUFACTURE',
			11 => ''
			
		);
		$lister_id = $this->session->userdata('user_id');
	    $users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
	    /*echo "<pre>";
	    print_r($users->result_array());
	    exit;*/

	    $employees = array(2,4,5,7,13,19,27,28,29,30,31,32);

	  	
	  	$listing_qry ='';
	    if(in_array($lister_id, $employees)){
	      $listing_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE ,I.ITEM_DESC)  ITEM_MT_DESC ,I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL";
	    }else{
	      	$listing_qry = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC A, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID";
	    }

	      
	   	  $listing_qry = $this->db->query($listing_qry);
	      $totalData = $listing_qry->num_rows();
	      $totalFiltered = $totalData;

	      $sql ="";
		if(in_array($lister_id, $employees)){
	      $sql = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, NVL(LS.ITEM_TITLE ,I.ITEM_DESC)  ITEM_MT_DESC ,I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL";
	    }else{
	      	$sql = "SELECT LS.SEED_ID, LS.OTHER_NOTES, LS.LZ_MANIFEST_ID,LM.LOADING_DATE,LM.PURCH_REF_NO, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_ID, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC A, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.APPROVED_DATE IS NOT NULL AND LS.APPROVED_BY IS NOT NULL AND A.LISTER_ID = $lister_id AND A.SEED_ID = LS.SEED_ID";
	    }

	    if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";  
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' )";
					
					
			}else{
				if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
					$sql.=" AND ( BCD.CONDITION_ID LIKE '%".$requestData['search']['value']."%' ";   
					$sql.=" OR  LS.ITEM_TITLE LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  LM.PURCH_REF_NO LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR  I.ITEM_MT_UPC LIKE '".$requestData['search']['value']."' ";
					$sql.=" OR I.ITEM_MT_MFG_PART_NO LIKE '%".$requestData['search']['value']."%' ";
					$sql.=" OR I.ITEM_MT_MANUFACTURE LIKE '%".$requestData['search']['value']."%' ";
					
				}
			}

			$query = $this->db->query($sql);

			$totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
		 	$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
			//$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
			$sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'] ;

			$query = $this->db->query($sql);
			$query = $query->result_array();
			$data = array();


			$path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      		$path_query =  $path_query->result_array();
			foreach($query as $row ){ // preparing an array
			
				$nestedData=array();

	 

				$nestedData[] =' <div style="width:100px;"> <div style="float:left;margin-right:8px;"> <form action="<?php echo base_url(); ?>tolist/c_tolist/list_item" method="post" accept-charset="utf-8"> <input type="hidden" name="seed_id" value="'.$row["SEED_ID"].'"/><input type="submit" name="item_list" title="List to eBay" onclick="return confirm("Are you sure?");" class="btn btn-success btn-sm" value="List"> </form> </div> 
				<div style="float:left;margin-right:8px;"> <a href="'.base_url().'tolist/c_tolist/seed_view/'.$row['SEED_ID'].'" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a> </div> 
				</div>';
				
			    $nestedData[] = $row['OTHER_NOTES'];

			    	      $it_condition = $row["ITEM_CONDITION"];
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
			      $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        $master_path = $path_query[0]['MASTER_PATH'];
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/thumb/";
                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);
                        // var_dump($m_dir);

                        $specific_path =$path_query[0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/thumb/";
                        $s_dir = preg_replace("/[\r\n]*/","",$s_dir);
                        // var_dump($s_dir);
                            //var_dump($m_dir);exit;
                        if(is_dir(@$m_dir)){
                                    $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                              }elseif(is_dir(@$s_dir)){
                                $iterator = new \FilesystemIterator(@$s_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                              }else{
                                $m_flag = false;
                              }
                         
			    if (is_dir($m_dir)){
                    // $images = glob("$m_dir*.jpg");
                    // sort($images);
                    $images = scandir($m_dir);
                    // Image selection and display:
                    //display first image
                    if (count($images) > 0) { // make sure at least one image exists
                        $url = $images[2]; // first image
                        $img = file_get_contents($m_dir.$url);
                        $img =base64_encode($img); 
                       $nestedData[] ='<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"> <img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/> </div>';

                    }
                  }else{
                     // var_dump($s_dir);
                    $images = scandir($s_dir);
                    
                    if (count($images) > 0) { // make sure at least one image exists
                        $url = $images[2]; // first image
                        $img = file_get_contents($s_dir.$url);
                        $img =base64_encode($img); 
                       $nestedData[] ='<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/></div>';
                    }
                  }



			    // $nestedData[] ='';
			    $notListed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID = ".$row["ITEM_CONDITION"]."AND BC.LZ_MANIFEST_ID =".$row["LZ_MANIFEST_ID"]." AND BC.ITEM_ID=".$row["ITEM_ID"]." " ); 
			    $notListed_barcode =  $notListed_barcode->result_array();
			    $barData  = '';
				foreach($notListed_barcode as $barcode){
					$barData.=$barcode['BARCODE_NO'].'-';
				}

				$nestedData[] =$barData;
			    $nestedData[] = $it_condition;
				$nestedData[] = $row["ITEM_MT_DESC"];
				$nestedData[] = $row["QUANTITY"];
				
				$nestedData[] =  $row["PURCH_REF_NO"];
				$nestedData[] = $row["UPC"];
				
				$nestedData[] = $row["MFG_PART_NO"];
				$nestedData[] = $row["MANUFACTURER"];
				
				$current_timestamp = date('m/d/Y');
                    $purchase_date = @$row['LOADING_DATE'];
                    
                    $date1=date_create($current_timestamp);
                    $date2=date_create($purchase_date);
                    $diff=date_diff($date1,$date2);
                    $date_rslt = $diff->format("%R%a days");
                $nestedData[] = abs($date_rslt)." Days";
				
				$data[] = $nestedData;

			}

			$json_data = array(
					"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    =>  intval($totalData),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"deferLoading" =>  intval( $totalFiltered ),
					"data"            => $data   // total data array
					
					);
			return $json_data;

	}

	/*=====  End Not Listed Items Datatable  ======*/
public function price_analysis_sold(){
	$mpn = $this->input->post('mpn');
	$condition_id = $this->input->post('condition_id');
	$category_id = $this->input->post('category_id');

	$get_mpn_id = "SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE MPN = '$mpn' AND CATEGORY_ID = $category_id "; 
		 		
 	$get_mpn_id = $this->db->query($get_mpn_id)->result_array();
 	$catalogue_mt_id = $get_mpn_id[0]['CATALOGUE_MT_ID'];

	$price_qry = $this->db->query("SELECT * FROM MPN_AVG_PRICE WHERE CONDITION_ID = $condition_id AND CATALOGUE_MT_ID = $catalogue_mt_id");
  	$sold_price = $price_qry->result_array();

    return $sold_price;
	}
	public function price_analysis_active(){
	$mpn = $this->input->post('mpn');
	$condition_id = $this->input->post('condition_id');
	$category_id = $this->input->post('category_id');

	$get_mpn_id = "SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE MPN = '$mpn' AND CATEGORY_ID = $category_id "; 
		 		
 	$get_mpn_id = $this->db->query($get_mpn_id)->result_array();
 	$catalogue_mt_id = $get_mpn_id[0]['CATALOGUE_MT_ID'];

	$price_qry = $this->db->query("SELECT * FROM MPN_AVG_PRICE_ACTIVE WHERE CONDITION_ID = $condition_id AND CATALOGUE_MT_ID = $catalogue_mt_id");
  	$active_price = $price_qry->result_array();

    return $active_price;
	}
	public function get_specifics($category_id,$item_id){
	// $mpn = $this->input->post('mpn');
	// $condition_id = $this->input->post('condition_id');
	// $category_id = $this->input->post('category_id');

	$mt_id = $this->db->query("SELECT * FROM CATEGORY_SPECIFIC_MT T WHERE T.EBAY_CATEGORY_ID = $category_id ORDER BY T.SPECIFIC_NAME");
			$mt_id = $mt_id->result_array();

	// $specs_qry = $this->db->query("SELECT MT.EBAY_CATEGORY_ID, MT.SPECIFIC_NAME, DET.SPECIFIC_VALUE, MT.MAX_VALUE, MT.MIN_VALUE, MT.SELECTION_MODE, MT.MT_ID FROM CATEGORY_SPECIFIC_MT MT, CATEGORY_SPECIFIC_DET DET WHERE MT.MT_ID = DET.MT_ID AND MT.EBAY_CATEGORY_ID = $category_id ORDER BY MT.SPECIFIC_NAME"); 
	// $specs_qry=  $specs_qry->result_array();
	
	
	$specs_qry = $this->db->query("SELECT MT.EBAY_CATEGORY_ID, MT.SPECIFIC_NAME, DET.SPECIFIC_VALUE, MT.MAX_VALUE, MT.MIN_VALUE, MT.SELECTION_MODE, MT.MT_ID, Q1.SPECIFICS_VALUE SELECTED_VAL FROM CATEGORY_SPECIFIC_MT MT, CATEGORY_SPECIFIC_DET DET, (SELECT M.SPECIFICS_NAME, D.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT M, LZ_ITEM_SPECIFICS_DET D WHERE D.SPECIFICS_MT_ID = M.SPECIFICS_MT_ID AND M.ITEM_ID = $item_id AND M.CATEGORY_ID = $category_id ORDER BY M.SPECIFICS_NAME) Q1 WHERE MT.MT_ID = DET.MT_ID AND MT.EBAY_CATEGORY_ID = $category_id AND MT.SPECIFIC_NAME = Q1.SPECIFICS_NAME(+) AND DET.SPECIFIC_VALUE = Q1.SPECIFICS_VALUE(+) ORDER BY MT.SPECIFIC_NAME"); 
	$specs_qry=  $specs_qry->result_array();


    return array('specs_qry'=>$specs_qry,'mt_id'=>$mt_id);
	}
	public function setBinIdtoSession(){
		$audit_bin_id = trim(strtoupper($this->input->post("audit_bin_id")));

		$bindId = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$audit_bin_id' ")->result_array();
   
   
	    if(count($bindId) > 0) {

			$this->session->set_userdata('audit_bin_id', $audit_bin_id);
			$sess_val = $this->session->userdata("audit_bin_id");
			return true;
		}else{
			return false;
		}
	}
	public function update_seed_price(){
	$price = $this->input->post('price');
	$seed_id = $this->input->post('seed_id');

	$price_qry = $this->db->query("UPDATE LZ_ITEM_SEED SET EBAY_PRICE = '$price' WHERE SEED_ID = $seed_id");


    return $price_qry;
	}
	public function authPasswordCheck(){
		$auth_password = $this->input->post('auth_password');		
		$query = $this->db->query("SELECT E.AUTH_PASSWORD, E.EMPLOYEE_ID FROM EMPLOYEE_MT E WHERE E.AUTH_PASSWORD = '$auth_password'");
		if($query->num_rows() > 0){
		 	$query = $query->result_array();
		 	$auth_by_id = @$query[0]['EMPLOYEE_ID'];

			$this->session->set_userdata('auth_by_id', $auth_by_id);
			//$auth_by_id = $this->session->userdata('auth_by_id');
			//var_dump($auth_by_id);exit;				
						
			return 1;
		}else{
			return 0;
		}
	}
    public function showAllBarcode(){
	$seed_id = $this->input->post('seedId');

	$unholded_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_ITEM_SEED S,LZ_BARCODE_MT B WHERE S.ITEM_ID  =B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND  S.DEFAULT_COND = B.CONDITION_ID AND S.SEED_ID = $seed_id AND HOLD_STATUS = 0 AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL")->result_array();

	$holded_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_ITEM_SEED S,LZ_BARCODE_MT B WHERE S.ITEM_ID  =B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND  S.DEFAULT_COND = B.CONDITION_ID AND S.SEED_ID = $seed_id AND HOLD_STATUS = 1 AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL")->result_array();

    return array('hold' => $holded_barcode_qry,'unhold' => $unholded_barcode_qry);
	}
    public function showHoldedBarcode(){
	$seed_id = $this->input->post('seedId');

	$barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_ITEM_SEED S,LZ_BARCODE_MT B WHERE S.ITEM_ID  =B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND  S.DEFAULT_COND = B.CONDITION_ID AND S.SEED_ID = $seed_id AND HOLD_STATUS = 1 AND LIST_ID IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND EBAY_ITEM_ID IS NULL")->result_array();
    return $barcode_qry;
	}
	public function holdSelectedBarcode(){
		$hold_barcode = $this->input->post('checkboxValues');
		$barcodeStatus = $this->input->post('barcodeStatus');
		$user_id = $this->session->userdata('user_id');
		date_default_timezone_set("America/Chicago");
		$current_date = date("Y-m-d H:i:s");
		$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
		$comma = ',';
		
			foreach($hold_barcode as $barcode){
				// $check_status = $this->db->query("SELECT * FROM LZ_BARCODE_MT WHERE BARCODE_NO =$barcode AND HOLD_STATUS = 0");
				
				// if($check_status->num_rows()>0){
					$get_pk = $this->db->query("SELECT get_single_primary_key('LZ_BARCODE_HOLD_LOG','LZ_HOLD_ID') LZ_HOLD_ID FROM DUAL");
					$get_pk = $get_pk->result_array();
					$lz_hold_id = $get_pk[0]['LZ_HOLD_ID'];
						
					$qry = "INSERT INTO LZ_BARCODE_HOLD_LOG VALUES ($lz_hold_id $comma $barcode $comma $current_date $comma $barcodeStatus $comma $user_id)";
					$this->db->query($qry);


		    		$hold_qry = "UPDATE LZ_BARCODE_MT SET HOLD_STATUS = $barcodeStatus WHERE BARCODE_NO = $barcode ";
					$hold_status = $this->db->query($hold_qry);

				// }else{
				// 	$hold_status = true;
				// }
			}//barcode foreach
		if($hold_status){
			return $barcodeStatus;
		}else {
			return false;
		}

	}
    public function getMacro(){
	$type_id = $this->input->post('type_id');

	$get_macro = $this->db->query("SELECT * FROM LZ_MACRO_MT WHERE TYPE_ID = $type_id ORDER BY MACRO_ORDER ASC")->result_array();
    return $get_macro;
	}
	public function bindItemMacro(){
    $selectedMacro = $this->input->post('selectedMacro');
    $itemId = $this->input->post('itemId');
    $conditionId = $this->input->post('conditionId');
    $order = 1;
    $user_id = $this->session->userdata('user_id');
	date_default_timezone_set("America/Chicago");
	$current_date = date("Y-m-d H:i:s");
	$current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $this->db->query("DELETE FROM LZ_MACRO_BIND_ITEM B WHERE B.ITEM_ID = $itemId AND B.CONDITION_ID = $conditionId");
    foreach ($selectedMacro as $macro_id) {
      /*================================================
	  =            insert/update item macro            =
	  ================================================*/
	  
	  // $bind_check = $this->db->query("SELECT B.BIND_ID FROM LZ_MACRO_BIND_ITEM B WHERE B.ITEM_ID = $itemId AND B.CONDITION_ID = $conditionId AND MACRO_ID = $macro_id");

	  // if($bind_check->num_rows() > 0){
	  // 	$bind_check = $bind_check->result_array();
	  // 	$bind_id = $bind_check[0]['BIND_ID'];
	  // 	$this->db->query("UPDATE LZ_MACRO_BIND_ITEM SET MACRO_ORDER = $order , UPDATED_BY = $entered_by , UPDATED_DATE = $created_date WHERE BIND_ID = $bind_id"); // ORDER CAN BE DUPLICATE BY THIS
	  // }else{

	  	$this->db->query("INSERT INTO LZ_MACRO_BIND_ITEM (BIND_ID, MACRO_ID, ITEM_ID, CONDITION_ID, MACRO_ORDER, CREATED_BY, CREATED_DATE, UPDATED_BY, UPDATED_DATE) VALUES (GET_SINGLE_PRIMARY_KEY('LZ_MACRO_BIND_ITEM','BIND_ID'),$macro_id,$itemId,$conditionId,$order,$user_id,$current_date,null,null)"); 
	  //}
	  
	  /*=====  End of insert/update item macro  ======*/
      $order++;
    }//end foreach
    //exit;
    return 1;
	}
	public function endItem(){
	$ebay_id = $this->input->post('ebay_id');
	// check if item sold or not
	$check_sold = $this->db->query("SELECT * FROM LZ_SALESLOAD_DET D WHERE D.ITEM_ID = '$ebay_id'"); 
	if($check_sold->num_rows() > 0){
		$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL");
	}else{
		$barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL"); 

		$delete_qry = $this->db->query("DELETE FROM LZ_LISTING_ALLOC WHERE LIST_ID IN (SELECT LIST_ID FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id')");

		$delete_qry = $this->db->query("DELETE FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id'");

		$delete_url = $this->db->query("DELETE FROM LZ_LISTED_ITEM_URL U WHERE U.EBAY_ID =  '$ebay_id'"); 

		
	}
	
	return 1;
	}

	public function copySeed(){
	$seed_id = $this->input->post('seed_id');
	$itemId = $this->input->post('itemId');
	$conditionId = $this->input->post('conditionId');

	$get_macro = $this->db->query("CALL PRO_COPY_SEED($itemId,$conditionId,$seed_id)");
    return 1;
	}
	public function getEbaySite(){

	$qry = $this->db->query("SELECT * FROM EBAY_SITE_MT")->result_array();
    return $qry;
	}
		public function updateReviseStatus($ebay_id,$price,$user_id){
		$list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('EBAY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
		$rs = $list_rslt->result_array();
		$LIST_ID = $rs[0]['LIST_ID'];
		//$this->session->set_userdata('list_id',$LIST_ID);
		/*========================================================
		=            get require column for insertion            =
		========================================================*/
		
		$list_rslt = $this->db->query("SELECT * FROM (SELECT E.* FROM EBAY_LIST_MT E WHERE E.EBAY_ITEM_ID = '$ebay_id' ORDER BY E.LIST_ID DESC) WHERE ROWNUM = 1"); 
		$rslt_dta = $list_rslt->result_array();
		$LIST_ID = $rs[0]['LIST_ID'];
		
		/*=====  End of get require column for insertion  ======*/
		

			$status = "UPDATE";
			$forceRevise = 0;
			 //$rslt_dta = $query->result_array();
		
			//$list_date = date("d/M/Y");// return format Aug/13/2016
			date_default_timezone_set("America/Chicago");
			$list_date = date("Y-m-d H:i:s");
	  		$list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
			$lister_id = $user_id;//$this->session->userdata('user_id');
			$ebay_item_desc = @$rslt_dta[0]['EBAY_ITEM_DESC'];
			$manifest_id = @$rslt_dta[0]['LZ_MANIFEST_ID'];
			$item_id = @$rslt_dta[0]['ITEM_ID'];
			$list_qty = 0;
			$ebay_item_id = $ebay_id;
			$list_price = @$price;
			$remarks = NULL;
			$single_entry_id = NULL;
			$salvage_qty = 0.00;
			$entry_type ="L";
			$LZ_SELLER_ACCT_ID= @$rslt_dta[0]['LZ_SELLER_ACCT_ID'];
			$condition_id= @$rslt_dta[0]['ITEM_CONDITION'];
			$seed_id= @$rslt_dta[0]['SEED_ID'];
			//$auth_by_id = $this->session->userdata('auth_by_id');
			$list_qty = "0";

			$insert_query = $this->db->query("INSERT INTO ebay_list_mt (LIST_ID, LZ_MANIFEST_ID, LISTING_NO, ITEM_ID, LIST_DATE, LISTER_ID, EBAY_ITEM_DESC, LIST_QTY, EBAY_ITEM_ID, LIST_PRICE, REMARKS, SINGLE_ENTRY_ID, SALVAGE_QTY, ENTRY_TYPE, LZ_SELLER_ACCT_ID, SEED_ID, STATUS, ITEM_CONDITION, FORCEREVISE)VALUES (".$LIST_ID.",".$manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",".$ebay_item_id.",'".$list_price."',NULL,NULL, NULL, '".$entry_type."',".$LZ_SELLER_ACCT_ID.",".$seed_id.",'".trim($status)."',".$condition_id.",".@$forceRevise.")"); 
			if($insert_query){
				$update_barcode_qry = "UPDATE LZ_BARCODE_MT SET LIST_ID = $LIST_ID WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id AND EBAY_ITEM_ID IS NOT NULL AND LIST_ID IS NOT NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND HOLD_STATUS = 0";
			    $this->db->query($update_barcode_qry);
			  	$this->db->query("UPDATE LZ_LISTING_ALLOC SET LIST_ID = $LIST_ID WHERE SEED_ID = $seed_id");
			  	$this->db->query("UPDATE lz_item_seed SET EBAY_PRICE = '$price' WHERE SEED_ID = '$seed_id'");
			  	return $LIST_ID;
		 	}
	
  		
	}

	public function getEndremrks($item_id,$manifest_id,$condition_id){

		$bar_qyery = $this->db->query("SELECT BB.BARCODE_NO FROM LZ_BARCODE_MT BB WHERE BB.LZ_MANIFEST_ID =$manifest_id   and bb.item_id =  $item_id  and bb.condition_id =$condition_id and rownum<=1")->result_array();

		$get_bar  = $bar_qyery[0]['BARCODE_NO'];


		$end  =$this->db->query("SELECT LG.REMARKS FROM LJ_AGINIG_ITEM_LOG AL ,LZ_ENDITEM_LOG LG WHERE AL.LOG_ID = LG.LOG_ID AND AL.BARCODE_NO ='$get_bar'")->result_array();


		return array('end' =>$end);

	}
}


 ?>