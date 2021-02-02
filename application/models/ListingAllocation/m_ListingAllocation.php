<?php 

  class M_ListingAllocation extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  
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

    $barcode_qry = $this->db->query("SELECT ALLOC_ID FROM LZ_LISTING_ALLOC");
        //var_dump($barcode_qry);exit;
        
 if($barcode_qry->num_rows() > 0){

      $un_assign_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.APPROVED_DATE, LS.APPROVED_BY, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE  LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU  SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, (SELECT LIST_ID FROM LZ_LISTING_ALLOC WHERE SEED_ID=LS.SEED_ID) LIST_ID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.SEED_ID NOT IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC)";

      $cat_id_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.SEED_ID NOT IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC) ";        
    }else{
        $un_assign_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LS.APPROVED_DATE, LS.APPROVED_BY, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE  LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU  SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY, (SELECT LIST_ID FROM LZ_LISTING_ALLOC WHERE SEED_ID=LS.SEED_ID) LIST_ID FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.SEED_ID NOT IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC)";

        $cat_id_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";          
      }
      $cat_id_qry = $this->db->query( $cat_id_qry);
      $cat_id_qry = $cat_id_qry->result_array();
    // $listing_without_pic_qry = "SELECT LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID , I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";

    //$date_qry = "AND LM.LOADING_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
    $date_qry ="";
    $filter_qry = "";
    if($this->input->post('purchase_no')){
      $purchase_no = $this->input->post('purchase_no');
        if(is_numeric($purchase_no)){
          $filter_qry = "AND (LS.LZ_MANIFEST_ID = $purchase_no OR LM.PURCH_REF_NO = to_char('$purchase_no'))";
        }else{
          $filter_qry = "AND LM.PURCH_REF_NO = to_char('$purchase_no')";
        }
      }
      $un_assign_qry = $this->db->query( $un_assign_qry. " ".$date_qry ." ".$filter_qry);
      $un_assign_qry = $un_assign_qry->result_array();

      // $listing_without_pic_qry = $this->db->query( $listing_without_pic_qry. " ".$date_qry ." ".$filter_qry);
      // $listing_without_pic_qry = $listing_without_pic_qry->result_array();

      $assigned_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, AL.ALLOC_ID, AL.REMARKS, AL.LISTER_ID, AL.ALLOC_DATE, AL.ALLOCATED_BY, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY  QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC AL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.SEED_ID = AL.SEED_ID  AND LS.SEED_ID IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC)";
      $assigned_qry = $this->db->query( $assigned_qry. " ".$date_qry ." ".$filter_qry." ORDER BY AL.ALLOC_DATE DESC");
      $assigned_qry = $assigned_qry->result_array();
      //var_dump($un_assign_qry);exit;
      $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL"); 
      $not_listed_barcode =  $not_listed_barcode->result_array();

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $path_query =  $path_query->result_array();
      $barcode_arr = [];
      foreach($assigned_qry as $cond){
        if(!empty($cond['ITEM_CONDITION'])){
          $condition_id = @$cond['ITEM_CONDITION'];

            //         if(!is_numeric(@$cond['ITEM_CONDITION'])){
            // $condition_id = @$cond['ITEM_CONDITION'];
            //             if(@$condition_id == 'USED'){
            //               @$condition_id = 3000;
            //             }elseif(@$condition_id == 'NEW'){
            //               @$condition_id = 1000; 
            //             }elseif(@$condition_id == 'NEW OTHER'){
            //               @$condition_id = 1500; 
            //             }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
            //                 @$condition_id = 2000;
            //             }elseif(@$condition_id == 'SELLER REFURBISHED'){
            //               @$condition_id = 2500; 
            //             }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING'){
            //               @$condition_id = 7000; 
            //             }
            //         }else{
            //           $condition_id = @$cond['ITEM_CONDITION'];
            //         }
                        

        $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
        //var_dump($barcode_qry);exit;
        
        if($barcode_qry->num_rows() > 0){
          $barcode_qry = $barcode_qry->result_array();

        array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
      }
        
      }else{
        //$barcode_qry = null;
        array_push($barcode_arr, null);
        //return array('query'=>$query, 'barcode_qry'=>$barcode_arr);
      }       

    } //END FOREACH

     return array('un_assign_qry'=>$un_assign_qry,'assigned_qry'=>$assigned_qry, 'path_query'=>$path_query, 'barcode_qry'=>$barcode_arr, 'not_listed_barcode'=>$not_listed_barcode, 'cat_id_qry'=>$cat_id_qry);

  }
  public function UsersList()
  {
    $query = $this->db->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID NOT IN(1, 6, 7, 8, 9, 10, 11, 15, 16, 17, 18, 19, 20, 25, 27, 28, 30, 31, 32)");
    return $query->result_array();
  }

  public function AssignListing(){
    date_default_timezone_set("America/Chicago");
    $list_date = date("Y-m-d H:i:s");
    $alloc_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $allocated_by = $this->session->userdata('user_id');     
    $user_name = $this->input->post('user_name');
    $remarks = $this->input->post('remarks');
    $seed_id = $this->input->post('assign_listing');   
    // var_dump($seed_id);exit;
    // $seed_id = explode(',',$seed_id);
    $comma = ",";
    foreach($seed_id as $id){
    $query = $this->db->query("SELECT get_single_primary_key('LZ_LISTING_ALLOC','ALLOC_ID') ALLOC_ID FROM DUAL");
    $rs = $query->result_array();
    $alloc_id = $rs[0]['ALLOC_ID'];
      //echo $id;
      $query = $this->db->query("INSERT INTO LZ_LISTING_ALLOC (ALLOC_ID, SEED_ID, LISTER_ID, ALLOC_DATE, ALLOCATED_BY, REMARKS, LIST_ID) VALUES($alloc_id $comma $id $comma $user_name $comma $alloc_date $comma $allocated_by $comma '$remarks' $comma NULL)");          
    }
    if($query){
      return true;
    }else{
    return false;
    }
    

    //var_dump($user_name, $seed_id);exit;
  }
  public function asign_dkit_list(){


    date_default_timezone_set("America/Chicago");
    $list_date = date("Y-m-d H:i:s");
    $alloc_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $allocated_by = $this->session->userdata('user_id');     
    
     $remarks ='';
    $seed_id = $this->input->post('assign_listing');   
    $assign_to = $this->input->post('get_emp');  //assign to person  
     // var_dump($seed_id);exit;
    
     // $get_emp  = $this->db->query("SELECT M.EMPLOYEE_ID FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK'AND M.STATUS = 1 ORDER BY M.EMPLOYEE_ID ASC ")->result_array(); 

     $comma = ",";


    foreach($seed_id as $id){
          // $i=0;
          // foreach ($get_emp as $emp_id) {
          //   $empid =$emp_id['EMPLOYEE_ID'];
          //   // var_dump($emp_id['EMPLOYEE_ID']);
          //   // exit;

    $query = $this->db->query("SELECT get_single_primary_key('LZ_LISTING_ALLOC','ALLOC_ID') ALLOC_ID FROM DUAL");
    $rs = $query->result_array();
    $alloc_id = $rs[0]['ALLOC_ID'];
      
      $query = $this->db->query("INSERT INTO LZ_LISTING_ALLOC (ALLOC_ID, SEED_ID, LISTER_ID, ALLOC_DATE, ALLOCATED_BY, REMARKS, LIST_ID) VALUES($alloc_id $comma $id $comma $assign_to $comma $alloc_date $comma $allocated_by $comma '$remarks' $comma NULL)");  

      // $i++;
      //   }

    }

    if($query){
      return true;
    }else{
    return false;
    }
    

    //var_dump($user_name, $seed_id);exit;
  }


  public function AssignListing_pk(){


    date_default_timezone_set("America/Chicago");
    $list_date = date("Y-m-d H:i:s");
    $alloc_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $allocated_by = $this->session->userdata('user_id');     
    // $user_name = $this->input->post('user_name');
     $remarks ='';// $this->input->post('remarks');
    $seed_id = $this->input->post('assign_listing');   
     //var_dump($seed_id);exit;
    // $seed_id = explode(',',$seed_id);
     $get_emp  = $this->db->query("SELECT M.EMPLOYEE_ID FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK'AND M.STATUS = 1 ORDER BY M.EMPLOYEE_ID ASC ")->result_array(); 

     $comma = ",";


    foreach($seed_id as $id){
          $i=0;
          foreach ($get_emp as $emp_id) {
            $empid =$emp_id['EMPLOYEE_ID'];
            // var_dump($emp_id['EMPLOYEE_ID']);
            // exit;

    $query = $this->db->query("SELECT get_single_primary_key('LZ_LISTING_ALLOC','ALLOC_ID') ALLOC_ID FROM DUAL");
    $rs = $query->result_array();
    $alloc_id = $rs[0]['ALLOC_ID'];
      //echo $id;
      $query = $this->db->query("INSERT INTO LZ_LISTING_ALLOC (ALLOC_ID, SEED_ID, LISTER_ID, ALLOC_DATE, ALLOCATED_BY, REMARKS, LIST_ID) VALUES($alloc_id $comma $id $comma $empid $comma $alloc_date $comma $allocated_by $comma '$remarks' $comma NULL)");  

      $i++;
        }

    }

    if($query){
      return true;
    }else{
    return false;
    }
    

    //var_dump($user_name, $seed_id);exit;
  }
  public function unassignlisting_pk(){


    date_default_timezone_set("America/Chicago");
    $list_date = date("Y-m-d H:i:s");
    $alloc_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $allocated_by = $this->session->userdata('user_id');     
    // $user_name = $this->input->post('user_name');
     $remarks ='';// $this->input->post('remarks');
    $seed_id = $this->input->post('assign_listing');   
     //var_dump($seed_id);exit;
    // $seed_id = explode(',',$seed_id);
     $get_emp  = $this->db->query("SELECT M.EMPLOYEE_ID FROM EMPLOYEE_MT M WHERE M.LOCATION = 'PK'AND M.STATUS = 1 ORDER BY M.EMPLOYEE_ID ASC ")->result_array(); 

     $comma = ",";

    foreach($seed_id as $id){

    $query = $this->db->query("DELETE FROM LZ_LISTING_ALLOC K WHERE K.SEED_ID = '$id' ");
    

    }

    if($query){
      return true;
    }else{
    return false;
    }
    

    //var_dump($user_name, $seed_id);exit;
  }

  public function UnAssigningListing(){

    // date_default_timezone_set("America/Chicago");
    // $list_date = date("Y-m-d H:i:s");
    // $alloc_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
    // $allocated_by = $this->session->userdata('user_id');     
    //$user_name = $this->input->post('un_assign_user');
    $seed_id = $this->input->post('un_assigning_list');   
    // var_dump($seed_id);exit;
    // $seed_id = explode(',',$seed_id);
    $comma = ",";
    
    foreach($seed_id as $id){

    // $query = $this->db->query("SELECT get_single_primary_key('LZ_LISTING_ALLOC','ALLOC_ID') ALLOC_ID FROM DUAL");
    // $rs = $query->result_array();
    // $alloc_id = $rs[0]['ALLOC_ID'];

      //echo $id;
      $query = $this->db->query("DELETE FROM LZ_LISTING_ALLOC WHERE ALLOC_ID = $id");

            
    }
    if($query){
      return true;
    }else{
    return false;
    }
    

    //var_dump($user_name, $seed_id);exit;
  }
  public function CatFilter(){
    $cat_id = $this->input->post('assign_cat_id');
    //var_dump($cat_name);exit;

    $barcode_qry = $this->db->query("SELECT ALLOC_ID FROM LZ_LISTING_ALLOC");

      
        //var_dump($barcode_qry);exit;
        
    if($barcode_qry->num_rows() > 0){

      $un_assign_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE           LAPTOP_ITEM_CODE, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU     SKU_NO, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION, BCD.QTY               QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.CATEGORY_ID = $cat_id AND LS.SEED_ID NOT IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC) ";
      
      $cat_id_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE           LAPTOP_ITEM_CODE, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU     SKU_NO, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION, BCD.QTY               QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.SEED_ID NOT IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC) ";        
    }else{
        $un_assign_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID , I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.CATEGORY_ID = $cat_id";

        $cat_id_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE           LAPTOP_ITEM_CODE, I.ITEM_DESC           ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU     SKU_NO, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION, BCD.QTY               QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";          
      }
      $cat_id_qry = $this->db->query( $cat_id_qry);
      $cat_id_qry = $cat_id_qry->result_array();

    // $listing_without_pic_qry = "SELECT LS.SEED_ID,LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID , I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC , BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID";
    //$date_qry = "AND LM.LOADING_DATE between TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') and TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";

    $date_qry ="";
    $filter_qry = "";
    if($this->input->post('purchase_no')){
      $purchase_no = $this->input->post('purchase_no');
        if(is_numeric($purchase_no)){
          $filter_qry = "AND (LS.LZ_MANIFEST_ID = $purchase_no OR LM.PURCH_REF_NO = to_char('$purchase_no'))";
        }else{
          $filter_qry = "AND LM.PURCH_REF_NO = to_char('$purchase_no')";
        }
      }
      $un_assign_qry = $this->db->query( $un_assign_qry. " ".$date_qry ." ".$filter_qry);
      $un_assign_qry = $un_assign_qry->result_array();

      // $listing_without_pic_qry = $this->db->query( $listing_without_pic_qry. " ".$date_qry ." ".$filter_qry);
      // $listing_without_pic_qry = $listing_without_pic_qry->result_array();

      $assigned_qry = "SELECT LS.CATEGORY_NAME, LS.CATEGORY_ID, AL.ALLOC_ID, AL.LISTER_ID, AL.ALLOC_DATE, AL.ALLOCATED_BY, LS.SEED_ID, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_MT_UPC UPC, BCD.CONDITION_ID ITEM_CONDITION, BCD.QTY  QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, LZ_LISTING_ALLOC AL, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.CATEGORY_ID = $cat_id AND  LS.SEED_ID = AL.SEED_ID  AND LS.SEED_ID IN (SELECT SEED_ID FROM LZ_LISTING_ALLOC)";
      $assigned_qry = $this->db->query( $assigned_qry. " ".$date_qry ." ".$filter_qry." ORDER BY AL.ALLOC_DATE DESC");
      $assigned_qry = $assigned_qry->result_array();
      //var_dump($un_assign_qry);exit;
      $not_listed_barcode = $this->db->query("SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, BC.BARCODE_NO FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 AND BC.EBAY_ITEM_ID IS NULL"); 
      $not_listed_barcode =  $not_listed_barcode->result_array();

      $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $path_query =  $path_query->result_array();
      $barcode_arr = [];
      foreach($assigned_qry as $cond){
        if(!empty($cond['ITEM_CONDITION'])){
          $condition_id = @$cond['ITEM_CONDITION'];

            //         if(!is_numeric(@$cond['ITEM_CONDITION'])){
            // $condition_id = @$cond['ITEM_CONDITION'];
            //             if(@$condition_id == 'USED'){
            //               @$condition_id = 3000;
            //             }elseif(@$condition_id == 'NEW'){
            //               @$condition_id = 1000; 
            //             }elseif(@$condition_id == 'NEW OTHER'){
            //               @$condition_id = 1500; 
            //             }elseif(@$condition_id == 'MANUFACTURER REFURBISHED'){
            //                 @$condition_id = 2000;
            //             }elseif(@$condition_id == 'SELLER REFURBISHED'){
            //               @$condition_id = 2500; 
            //             }elseif(@$condition_id == 'FOR PARTS OR NOT WORKING'){
            //               @$condition_id = 7000; 
            //             }
            //         }else{
            //           $condition_id = @$cond['ITEM_CONDITION'];
            //         }
                        

        $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$cond['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$cond['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$condition_id." AND ROWNUM = 1");
        //var_dump($barcode_qry);exit;
        
        if($barcode_qry->num_rows() > 0){
          $barcode_qry = $barcode_qry->result_array();

        array_push($barcode_arr, @$barcode_qry[0]['BARCODE_NO']);
      }
        
      }else{
        //$barcode_qry = null;
        array_push($barcode_arr, null);
        //return array('query'=>$query, 'barcode_qry'=>$barcode_arr);
      }       

    } //END FOREACH

      return array('un_assign_qry'=>$un_assign_qry,'assigned_qry'=>$assigned_qry, 'path_query'=>$path_query, 'barcode_qry'=>$barcode_arr, 'not_listed_barcode'=>$not_listed_barcode, 'cat_id_qry'=>$cat_id_qry);
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
  $seed_id = $this->input->post('seed_id');
  $item_id = $this->input->post('pic_item_id');
  $manifest_id = $this->input->post('pic_manifest_id');
  //$condition_id = $this->input->post('pic_condition_id');
  $barcode=  $this->input->post('barcode');
  $title = $this->input->post('title');
  $title = trim(str_replace("  ", ' ', $title));
  //$title = trim(str_replace(array("'"), "''", $title));
  //var_dump($title);exit
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
  $default_condition = $this->input->post('pic_condition_id');
    // if(@$default_condition == 'Used'){
   //      @$default_condition = 3000;
   //    }elseif(@$default_condition == 'New'){
   //      @$default_condition = 1000; 
   //    }elseif(@$default_condition =='New other' ){
   //      @$default_condition = 1500; 
   //    }elseif(@$default_condition == 'Manufacturer refurbished'){
   //        @$default_condition = 2000;
   //    }elseif(@$default_condition == 'Seller refurbished'){
   //      @$default_condition = 2500; 
   //    }elseif(@$default_condition == 'For parts or not working'){
   //      @$default_condition = 7000; 
   //    }
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

  $update_qry = "UPDATE LZ_ITEM_SEED SET SEED_ID = $seed_id, ITEM_ID = $item_id, ITEM_TITLE = '$title', ITEM_DESC = '$item_desc', EBAY_PRICE = $price, TEMPLATE_ID = $template_name, EBAY_LOCAL = $site_id, CURRENCY = '$currency', LIST_TYPE = '$listing_type', CATEGORY_ID = $category_id, CATEGORY_NAME = '$category_name', SHIP_FROM_ZIP_CODE = $zip_code, SHIP_FROM_LOC = '$ship_from', BID_LENGTH = NULL, DEFAULT_COND = $default_condition, DETAIL_COND = '$default_description', PAYMENT_METHOD = '$payment_method', PAYPAL_EMAIL = '$paypal', DISPATCH_TIME_MAX = $dispatch_time, SHIPPING_COST = $shipping_cost, ADDITIONAL_COST = $additional_cost, RETURN_OPTION = '$return_accepted', RETURN_DAYS = $return_within, SHIPPING_PAID_BY = '$cost_paidby', SHIPPING_SERVICE = '$shipping_service', LZ_MANIFEST_ID = $manifest_id, ENTERED_BY = $entered_by, DATE_TIME = $created_date WHERE SEED_ID  = $seed_id";
   $this->db->query($update_qry);
   
  //   $data = array(
  //  'SEED_ID' => $seed_id,
  //  'ITEM_ID' => $item_id,
  //  'ITEM_TITLE' => $title,
  //  'ITEM_DESC' => $item_desc,
  //  'EBAY_PRICE' => $price,
  //  'TEMPLATE_ID' => $template_name,
  //  'EBAY_LOCAL' => $site_id,
  //  'CURRENCY' => $currency,
  //  'LIST_TYPE' => $listing_type,
  //  'CATEGORY_ID' => $category_id,
  //  'CATEGORY_NAME' => $category_name,
  //  'SHIP_FROM_ZIP_CODE' => $zip_code,
  //  'SHIP_FROM_LOC' => $ship_from,
  //  'BID_LENGTH' => $bid_length,
  //  'DEFAULT_COND' => $default_condition,
  //  'DETAIL_COND' => $default_description,
  //  'PAYMENT_METHOD' => $payment_method,
  //  'PAYPAL_EMAIL' => $paypal,
  //  'DISPATCH_TIME_MAX' => $dispatch_time,
  //  'SHIPPING_COST' => $shipping_cost,
  //  'ADDITIONAL_COST' => $additional_cost,
  //  'RETURN_OPTION' => $return_accepted,
  //  'RETURN_DAYS' => $return_within,
  //  'SHIPPING_PAID_BY' => $cost_paidby,
  //  'SHIPPING_SERVICE' => $shipping_service,
  //  'LZ_MANIFEST_ID' => $manifest_id,
  //  'ENTERED_BY' => $entered_by,
  //  'DATE_TIME' => $created_date
   
  // );
  // $where = array('SEED_ID ' => $seed_id);
  // $this->db->where($where);
  // $this->db->update('LZ_ITEM_SEED', $data);
  
// ==================== update items_mt description ======================
   $data_mt = array(
   'ITEM_LARGE_DESC' => $title,
    );
  $where = array('ITEM_ID ' => $item_id);
  $this->db->where($where);
  $this->db->update('ITEMS_MT', $data_mt);

 }
function view($item_id,$manifest_id,$condition_id) 
 {
    $path_query = $this->db->query("SELECT * FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
    $path_query =  $path_query->result_array();

   /*================================  display seed   =============================*/
   $S_Result = $this->db->query("SELECT B.UNIT_NO, B.BARCODE_NO IT_BARCODE, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, I.ITEM_MT_UPC UPC, I.ITEM_MT_BBY_SKU SKU_NO, I.ITEM_CODE LAPTOP_ITEM_CODE, I.ITEM_DESC ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, S.* FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_BARCODE_MT B WHERE B.ITEM_ID = S.ITEM_ID AND I.ITEM_ID = S.ITEM_ID AND B.LZ_MANIFEST_ID = S.LZ_MANIFEST_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.ITEM_ID = $item_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1"); 
   $S_Result = $S_Result->result();

    $all_barcode_qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ITEM_ID = $item_id AND B.LZ_MANIFEST_ID = $manifest_id AND B.CONDITION_ID = $condition_id");
    $all_barcode_qry =  $all_barcode_qry->result_array();
    $pic_note = [];
    foreach($all_barcode_qry as $barcode){
      $pic_note_query = $this->db->query("SELECT TD.LZ_BARCODE_ID,TD.SPECIAL_REMARKS, TD.PIC_NOTE FROM LZ_TESTING_DATA TD WHERE TD.LZ_BARCODE_ID = ".$barcode['BARCODE_NO']." AND ROWNUM = 1");
           
      if($pic_note_query->num_rows() > 0){
          $pic_note_query = $pic_note_query->result_array();
          $pic_note[]= @$pic_note_query;
          //array_push(@$barcode_arr, @$pic_note_query);
      }
    }
//var_dump($barcode_arr);exit;
   return array('result'=>$S_Result, 'path_query'=>$path_query, 'pic_note_query'=>$pic_note_query,'pic_note'=>$pic_note);
   
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
  $query = $this->db->query("SELECT TEMPLATE_ID,TEMPLATE_NAME FROM LZ_ITEM_TEMPLATE ORDER BY TEMPLATE_ID");
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
  public function check_item_id($item_id,$condition_id){
      $LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');
      //$q = $this->db->query("SELECT ITEM_ID,EBAY_ITEM_ID FROM EBAY_LIST_MT WHERE ITEM_ID = $item_id and LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID order by LIST_DATE DESC");
      $q = $this->db->query("SELECT MAX(L.EBAY_ITEM_ID) EBAY_ITEM_ID FROM EBAY_LIST_MT L, LZ_ITEM_SEED LS WHERE L.ITEM_ID = LS.ITEM_ID AND L.LZ_MANIFEST_ID = LS.LZ_MANIFEST_ID AND L.ITEM_ID = $item_id AND LS.DEFAULT_COND = $condition_id AND L.LZ_SELLER_ACCT_ID=$LZ_SELLER_ACCT_ID"); 
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
  
  public function uplaod_seed($item_id,$manifest_id,$condition_id){
      
      $query = $this->db->query("SELECT LS.ITEM_ID, LS.ITEM_TITLE, LS.ITEM_DESC, LS.EBAY_PRICE, LS.TEMPLATE_ID, LS.EBAY_LOCAL, LS.CURRENCY, LS.LIST_TYPE, LS.CATEGORY_ID, LS.SHIP_FROM_ZIP_CODE, LS.SHIP_FROM_LOC, LS.DEFAULT_COND, LS.DETAIL_COND, LS.PAYMENT_METHOD, LS.PAYPAL_EMAIL, LS.DISPATCH_TIME_MAX, LS.SHIPPING_COST, LS.ADDITIONAL_COST, LS.RETURN_OPTION, LS.RETURN_DAYS, LS.SHIPPING_PAID_BY, LS.SHIPPING_SERVICE, LS.CATEGORY_NAME, LS.LZ_MANIFEST_ID, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_MT_MANUFACTURE MANUFACTURE, I.ITEM_MT_MFG_PART_NO PART_NO, I.ITEM_MT_BBY_SKU     SKU, I.ITEM_MT_UPC         UPC, BCD.CONDITION_ID      ITEM_CONDITION, BCD.QTY               QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id"); 
      return $query->result_array(); }
  public function uplaod_seed_pic($item_id,$manifest_id,$condition_id){

      $query = $this->db->query("SELECT I.ITEM_MT_MFG_PART_NO,I.ITEM_MT_UPC FROM ITEMS_MT I WHERE I.ITEM_ID = $item_id"); 
      $result=$query->result_array();
      $mpn = $result[0]['ITEM_MT_MFG_PART_NO'];
      $upc = $result[0]['ITEM_MT_UPC'];
      $it_condition = $condition_id;

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
            }else{
                @$it_condition = 'Used'; 
            }
        }else{// end main if
          $it_condition  = ucfirst(@$it_condition);
        }
        $mpn = str_replace('/', '_', @$mpn);

/*==============================================
=            Master Picture Check            =
==============================================*/
        //$dir = "D:/item_pictures/master_pictures/".@$data_get[0]->['UPC']."~".@$mpn."/".@$it_condition;
      // Open a directory, and read its contents
        $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
        $master_qry = $query->result_array();
        $master_path = $master_qry[0]['MASTER_PATH'];

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
        //$dir = "D:/item_pictures/master_pictures/".@$data_get[0]->['UPC']."~".@$mpn."/".@$it_condition;
      $query = $this->db->query("SELECT SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
      $specific_qry = $query->result_array();
      $specific_path = $specific_qry[0]['SPECIFIC_PATH'];

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
    //die('Error! Item Picture Not Found.');
  }//elseif($m_flag === false && $s_flag === false){

  //        $query = $this->db->query("SELECT item_pict_desc,item_pic FROM item_pictures_mt where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
  //        $result=$query->result_array();
  //        if(!empty($result)){
  //          return $query->result_array();
  //        }else{
  //          $query = $this->db->query("SELECT ITEM_ID,LZ_MANIFEST_ID FROM item_pictures_mt where ITEM_ID = $item_id AND LZ_MANIFEST_ID = (SELECT MAX(LZ_MANIFEST_ID) FROM item_pictures_mt WHERE ITEM_ID = $item_id) AND ROWNUM =1");
  //          $result = $query->result_array();
  //          if(!empty($result)){
  //            $item_id = $result[0]['ITEM_ID'];
  //            $manifest_id = $result[0]['LZ_MANIFEST_ID'];
  //            $query = $this->db->query("SELECT item_pict_desc,item_pic FROM item_pictures_mt where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
  //            return $query->result_array();
  //          }else{
  //            echo "Please Select Images.Add at least 1 photo. More photos are better! Show off your item from every angle and zoom in on details.";
  //            exit;//You can't "break" from an if statement. You can only break from a loop.
  //          }
  //        }

  //    }
    }//end function
    public function item_specifics($item_id, $manifest_id,$condition_id){
    // $item_id = 18786;
    // $manifest_id = 13827;
      $query = $this->db->query("SELECT I.ITEM_MT_UPC, I.ITEM_MT_MFG_PART_NO, S.CATEGORY_ID FROM ITEMS_MT I, LZ_ITEM_SEED S WHERE I.ITEM_ID = $item_id AND I.ITEM_ID = S.ITEM_ID AND S.LZ_MANIFEST_ID = $manifest_id AND S.DEFAULT_COND = $condition_id AND ROWNUM = 1");
      $result = $query->result_array();
      if($query->num_rows() > 0){

        // $spec_query = $this->db->query("SfELECT * FROM LZ_ITEM_SPECIFICS_MT MT WHERE MT.ITEM_ID = $item_id AND MT.MPN = '".$result[0]['ITEM_MT_MFG_PART_NO'] ."' AND MT.UPC = '".$result[0]['ITEM_MT_UPC'] ."' AND MT.CATEGORY_ID = ".$result[0]['CATEGORY_ID'] ."");
        $spec_query = $this->db->query("SELECT MT.SPECIFICS_NAME, DT.SPECIFICS_VALUE FROM LZ_ITEM_SPECIFICS_MT MT, LZ_ITEM_SPECIFICS_DET DT WHERE DT.SPECIFICS_MT_ID = MT.SPECIFICS_MT_ID AND MT.ITEM_ID = $item_id AND MT.MPN = '".$result[0]['ITEM_MT_MFG_PART_NO']."' AND MT.UPC = '".$result[0]['ITEM_MT_UPC']."' AND MT.CATEGORY_ID = ".$result[0]['CATEGORY_ID']."");
        $spec_query = $spec_query->result_array();

      }else{
        $spec_query = "";
      }

      return $spec_query; 

      //var_dump($spec_query);exit ;

      

    }
      public function insert_ebay_id($item_id,$manifest_id,$seed_id,$condition_id,$status){

      //$query = $this->db->query("SELECT ITEM_TITLE,QUANTITY,EBAY_PRICE FROM LZ_ITEM_SEED where ITEM_ID = $item_id and LZ_MANIFEST_ID = $manifest_id");
      $query = $this->db->query("SELECT LS.ITEM_TITLE,LS.EBAY_PRICE, BCD.QTY QUANTITY FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, (SELECT BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID, COUNT(1) QTY FROM LZ_BARCODE_MT BC WHERE BC.CONDITION_ID IS NOT NULL AND BC.HOLD_STATUS = 0 GROUP BY BC.LZ_MANIFEST_ID, BC.ITEM_ID, BC.CONDITION_ID) BCD WHERE LS.ITEM_ID = I.ITEM_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND LS.ITEM_ID = $item_id and LS.LZ_MANIFEST_ID = $manifest_id and LS.DEFAULT_COND=$condition_id");
      

       $rslt_dta = $query->result_array();

      $list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('ebay_list_mt','LIST_ID') LIST_ID FROM DUAL");
      $rs = $list_rslt->result_array();
      $LIST_ID = $rs[0]['LIST_ID'];
      
      $this->session->set_userdata('list_id',$LIST_ID);
      $ebay_id = $this->session->userdata('ebay_item_id');
      //$list_date = date("d/M/Y");// return format Aug/13/2016
      date_default_timezone_set("America/Chicago");
      $list_date = date("Y-m-d H:i:s");
      $list_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
      $lister_id = $this->session->userdata('user_id');
      $ebay_item_desc = $rslt_dta[0]['ITEM_TITLE'];
        $ebay_item_desc = trim(str_replace("  ", '', $ebay_item_desc));
        $ebay_item_desc = trim(str_replace(array("'"), "''", $ebay_item_desc));
      $list_qty = $rslt_dta[0]['QUANTITY'];
      $ebay_item_id = $ebay_id;
      $list_price = $rslt_dta[0]['EBAY_PRICE'];
      $remarks = NULL;
      $single_entry_id = NULL;
      $salvage_qty = 0.00;
      $entry_type ="L";
      $LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');
      $insert_query = $this->db->query("INSERT INTO ebay_list_mt VALUES (".$LIST_ID.",".$manifest_id.", ".$LIST_ID.", ".$item_id.", ".$list_date.", ".$lister_id.", '".$ebay_item_desc."', ".$list_qty.",".$ebay_item_id.",".$list_price.",NULL,NULL, NULL, '".$entry_type."',".$LZ_SELLER_ACCT_ID.",".$seed_id.",'".$status."')");
      if($insert_query){
        $this->db->query("UPDATE LZ_BARCODE_MT SET EBAY_ITEM_ID=$ebay_id WHERE ITEM_ID= $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id");
      }
    }
  /*=====  End of copy from listing model  ======*/

  public function item_barcode($item_id,$manifest_id,$condition_id){
    $query = $this->db->query("SELECT BARCODE_NO FROM LZ_BARCODE_MT WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $manifest_id AND CONDITION_ID = $condition_id");
    return $query->result_array();
  }
  
    
}




 ?>