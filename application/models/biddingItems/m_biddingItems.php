<?php  
  class M_biddingItems extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function categorySummary(){
    // $qry = $this->db2->query("SELECT DISTINCT C.CATEGORY_ID,C.CATEGORY_NAME,get_active_count(C.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CATEGORY C");
    $qry = $this->db2->query("SELECT CATEGORY_NAME, CATEGORY_ID, LISTED, VERIFIED, UN_VERIFIED, LAST_DATE FROM CATEGORY_WISE_SUMMARY_VIEW ");
    $qry = $qry->result_array();

    $count = $this->db2->query("SELECT SUM(LISTED) TOTAL_LISTED, SUM(VERIFIED) TOTALVERIFIED, SUM(UN_VERIFIED) TOTAL_UN_VERIFIED FROM CATEGORY_WISE_SUMMARY_VIEW")->result_array();

    return array('qry' => $qry,'count' => $count);
  }
  public function mpnSummary($cat_id){
    $mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID and BD.IS_DELETED =0 AND BD.VERIFIED = 1 GROUP BY BD.CATALOGUE_MT_ID,C.MPN");
    $verified = $this->db2->query("SELECT COUNT(1) VERIFY_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD WHERE BD.VERIFIED = 1 and bd.IS_DELETED =0 ");
    $category_name = $this->db2->query("SELECT C.CATEGORY_ID,C.CATEGORY_NAME,GET_ACTIVE_COUNT(C.CATEGORY_ID) CAT_COUNT FROM LZ_BD_CATEGORY C WHERE C.CATEGORY_ID=$cat_id"); 
    $mpn = $mpn->result_array();
    $verified = $verified->result_array();
    $category_name = $category_name->result_array();
    // var_dump($verified);exit;
    return array('mpn' => $mpn,'verified'=>$verified ,'category_name'=>$category_name);
  }

  public function unVerifyDropdown(){
      $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();

      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      // $seller =$this->db2->query("SELECT SELLER_ID, SELLER_ID || ' (' || COUNT(SELLER_ID) || ')' SELLER_NAME FROM all_active_data_view BD, LZ_CATALOGUE_MT M, mpn_avg_price av WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.SALE_TIME > SYSDATE - 1 and BD.VERIFIED = 1 and m.mpn is not null GROUP BY SELLER_ID") ->result_array();

    $flag_id = "SELECT FLAG_ID ,FLAG_NAME FROM LZ_BD_PURCHASING_FLAG ORDER BY FLAG_ID";
    $flag_id = $this->db->query($flag_id)->result_array();


    // $cattegory = "SELECT distinct D.CATEGORY_ID, K.CATEGORY_NAME || '-' || D.CATEGORY_ID || ' (' || count_mpn.mpn ||')' CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY K,(select category_id cat_id ,count(mpn) mpn,category_id from lz_catalogue_mt group by category_id) count_mpn WHERE D.CATEGORY_ID = K.CATEGORY_ID and K.CATEGORY_ID = count_mpn.cat_id and d.lz_bd_group_id = 1";
    $cattegory = "SELECT distinct D.CATEGORY_ID, K.CATEGORY_NAME || ' - ' || D.CATEGORY_ID CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY K WHERE D.CATEGORY_ID = K.CATEGORY_ID AND D.LZ_BD_GROUP_ID = 1"; 
    // $cate_name = $this->db2->query(" SELECT CATEGORY_NAME || '-' || CATEGORY_ID  CATEGORY_NAME from LZ_BD_CATEGORY where CATEGORY_ID = $cat_id group by category_name,category_id")->result_array();

    // ,'cate_name' => $cate_name

    $cattegory = $this->db2->query($cattegory);
    $cattegory = $cattegory->result_array();

      return array('list_types' => $list_types, 'conditions' => $conditions , 'cattegory' => $cattegory,'flag_id' => $flag_id);
  }
  public function biddingItemsCounts(){
    // $from = date('m/d/Y', strtotime('-1 months'));// date('m/01/Y');
    // $to = date('m/d/Y');
    // if(!empty(@$from) && !empty(@$to) ){
    // $date_qry = "AND O.OFFER_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
    // }else{
    //   $date_qry = "";
    // }

    $query = $this->db2->query("SELECT COUNT(O.OFFER_ID) TOTAL_BIDS, NVL(SUM(DECODE(O.WIN_STATUS, 1, 1)), 0) WON, COUNT(DECODE(O.WIN_STATUS, 0, 0)) LOST, NVL(SUM(DECODE(O.WIN_STATUS, 1, O.SOLD_AMOUNT)), 0) TOTAL_PURCHASE, SUM(O.OFFER_AMOUNT) TOTAL_OFFER, COUNT(O.OFFER_ID) - NVL(SUM(DECODE(O.WIN_STATUS, 1, 1)), 0) BID_SOLD, NVL(SUM(DECODE(O.WIN_STATUS, NULL, O.OFFER_AMOUNT)), 0) TOTAL_PEND_OFFER, NVL(COUNT(DECODE(O.WIN_STATUS, NULL, O.OFFER_AMOUNT)), 0) TOTAL_OFFER_COUNT FROM LZ_BD_PURCHASE_OFFER O, ALL_ACTIVE_DATA_VIEW D WHERE O.LZ_BD_CATA_ID = D.LZ_BD_CATA_ID AND O.CATEGORY_ID = D.CATEGORY_ID ");
      //AND O.OFFER_DATE = SYSDATE 
    return $query->result_array();

  }

  public function biddingCountsWithFilter($date_range){
    $date_range = $this->session->userdata('date_range');

    $rs = explode('-',$date_range);
    // $fromdate = @$rs[0];
    // $todate = @$rs[1];
    /*===Convert Date in 24-Apr-2016===*/
    $fromdate = date_create(@$rs[0]);
    $todate = date_create(@$rs[1]);

    $from = date_format($fromdate,'d-m-y');
    $to = date_format($todate, 'd-m-y');
    if(!empty(@$from) && !empty(@$to) ){
    $date_qry = "AND O.OFFER_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
    }else{
      $date_qry = "";
    }

    $query = $this->db2->query("SELECT COUNT(O.OFFER_ID) TOTAL_BIDS, NVL(SUM(DECODE(O.WIN_STATUS, 1, 1)), 0) WON, COUNT(DECODE(O.WIN_STATUS, 0, 0)) LOST, NVL(SUM(DECODE(O.WIN_STATUS, 1, O.SOLD_AMOUNT)), 0) TOTAL_PURCHASE, SUM(O.OFFER_AMOUNT) TOTAL_OFFER, COUNT(O.OFFER_ID) - NVL(SUM(DECODE(O.WIN_STATUS, 1, 1)), 0) BID_SOLD, NVL(SUM(DECODE(O.WIN_STATUS, NULL, O.OFFER_AMOUNT)), 0) TOTAL_PEND_OFFER, NVL(COUNT(DECODE(O.WIN_STATUS, NULL, O.OFFER_AMOUNT)), 0) TOTAL_OFFER_COUNT FROM LZ_BD_PURCHASE_OFFER O, ALL_ACTIVE_DATA_VIEW D WHERE O.LZ_BD_CATA_ID = D.LZ_BD_CATA_ID AND O.CATEGORY_ID = D.CATEGORY_ID $date_qry");
    return $query->result_array();

  }

  public function category_name(){
    $cat_id = $this->uri->segment(4);
      $cate_name = $this->db2->query(" SELECT CATEGORY_NAME || '-' || CATEGORY_ID  CATEGORY_NAME from LZ_BD_CATEGORY where CATEGORY_ID = $cat_id group by category_name,category_id")->result_array();

      return array('cate_name' => $cate_name);

  }


  //// biding load without server side
  public function loadPurchDetail() { // for biding screen without server side

    $requestData= $_REQUEST;
    
    $columns = array( 
    // datatable column index  => database column name
      0 => '',
      1 => 'EBAY_ID',
      2 => 'TITLE', 
      3 => 'MPN',
      4 => 'SELLER_ID',
      5 => 'CATEGORY_ID',
      6 => 'LISTING_TYPE',
      7 => 'TIME_DIFF',
      8 => 'CONDITION_NAME',
      9 => 'STATUS',
      10 => 'BID STATUS',
      11 => 'BID/OFFER',
      12 => 'SOLD AMOUNT',
      13 => 'LIST_DATE',
      14 => 'KIT VIEW',
      15 => 'TRACKING',
      16 => 'COST PRICE'
    );

    // $lister_id = $this->session->userdata('user_id');
    // $users = $this->db->query("SELECT T.USER_NAME FROM EMPLOYEE_MT T WHERE T.EMPLOYEE_ID=$lister_id");
    // $employees = array(2,4,5,7,13,19,27,28,29,30,31,32);

    $bidding_qry = '';
    
      // if(in_array($lister_id, $employees)){
    $bidding_qry = $this->db2->query("SELECT BD.FLAG_ID, BD.VERIFIED, O.OFFER_ID, O.OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON') WIN_STATUS, SOLD_AMOUNT, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' h :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' m :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' s ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.SELLER_DESCRIPTION, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE, BD.INSERTED_DATE FROM LZ_BD_ITEMS_TO_EST BD, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T, LZ_BD_PURCHASE_OFFER O WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND (BD.FLAG_ID = 23 OR BD.FLAG_ID = 25) AND BD.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND BD.IS_DELETED <> 1 "); //ORDER BY BD.INSERTED_DATE DESC
      
      
    $totalData = $bidding_qry->num_rows();
    // var_dump($totalData);exit;
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
    

    $sql = "SELECT BD.FLAG_ID, BD.VERIFIED, O.OFFER_ID, O.OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON') WIN_STATUS, SOLD_AMOUNT, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' h :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' m :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' s ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.SELLER_DESCRIPTION, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE, BD.INSERTED_DATE FROM LZ_BD_ITEMS_TO_EST BD, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T, LZ_BD_PURCHASE_OFFER O WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND (BD.FLAG_ID = 23 OR BD.FLAG_ID = 25) AND BD.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND BD.IS_DELETED <> 1 ";
    

      if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( BD.EBAY_ID LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR BD.TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR M.MPN LIKE '".$requestData['search']['value']."' ";
          $sql.=" OR BD.SELLER_ID LIKE '".$requestData['search']['value']."' ";
          $sql.=" OR BD.CATEGORY_ID LIKE '".$requestData['search']['value']."' ";
          $sql.=" OR BD.LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR BD.CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR T.TRACKING_NO LIKE '%".$requestData['search']['value']."%' )";
          
      }


    $query = $this->db2->query($sql);
    
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     //$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT * FROM (SELECT  q.*, rownum rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start']." ORDER BY INSERTED_DATE DESC" ;
    // echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    /*=======================================
    =            For Oracle 12-c            =
    =======================================*/
      // $sql = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM    ($sql) q ) OFFSET ".$requestData['start']." ROWS FETCH NEXT ".$requestData['length']."ROWS ONLY" ;
    
    
    /*=====  End of For Oracle 12-c  ======*/
    

    
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    $data = array();
    // $qry = array_combine(keys, values)

    // print_r($listed_barcode);exit;
    // $qry = array('query'=>$query,'listed_barcode'=>$listed_barcode);
    // print_r($qry);exit;
    // 
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ='<div style="width:80px;"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" 
                       id='.@$row["LZ_BD_CATA_ID"].'><i class="fa fa-trash-o" aria-hidden="true"></i> </button> </div>';

      $nestedData[] = '<a href='.@$row["ITEM_URL"].' target="_blank" id="link'.$i.'">'.@$row["EBAY_ID"].'</a>';
      $nestedData[] = '<div class="pull-right" style="width:250px;">'.@$row["TITLE"].'</div>';
      $nestedData[] = '<div class="text-center" style="width:100px;">'.@$row['MPN'].'</div>';
      $nestedData[] = @$row["SELLER_ID"];
      $lz_cat_id = @$row['CATEGORY_ID'];
      $nestedData[] = $lz_cat_id;
      $nestedData[] =  @$row["LISTING_TYPE"];
      $nestedData[] = '<div class="text-center" style="width:130px;">'.$row["TIME_DIFF"].'</div>';
      $nestedData[] = @$row["CONDITION_NAME"];
      $offer_amount = @$row['OFFER_AMOUNT'];
      if(empty($offer_amount)){
        $nestedData[] = '<div class="pull-right" style="width:120px;"><input type="hidden" name="cat_id" id="cat_id" value="'.$lz_cat_id.'"></div>';
      }else{
        $nestedData[] = '<div class="pull-right" style="width:120px;"><input type="hidden" name="cat_id" id="cat_id" value="'.$lz_cat_id.'"> <select style="width:100px;" name="winLoss" id="status_'.$row["LZ_BD_CATA_ID"].'" class="form-control winLoss"><option value="none">Select...</option><option value="1">WON</option><option value="0">LOST</option> </select> </div>';
      }
      $status = @$row['WIN_STATUS'];

      $nestedData[] = '<div class="pull-right" style="width:70px;">'.$status.'</div>';
      $offer_id = @$row['OFFER_ID'];
      if(empty($offer_amount)){
        $nestedData[] = '<div class="pull-right" style="width:170px;"> <input style="width:100px;margin-right:10px;" class="form-control" type="number" name="bidding_offer_'.$i.'" id="bidding_offer_'.$i.'" value="'.$offer_amount.'" placeholder="Offer"> <input type="button" class="btn btn-sm btn-primary save_offer" name="save_offer" id="'.$i.'" value="Save"> </div>';
      }else{
        $nestedData[] = '<div class="pull-right" style="width:170px;"> <input style="width:100px;margin-right:10px;" class="form-control" type="number" name="bid_offer_'.$i.'" id="bid_offer_'.$i.'" value="'.$offer_amount.'" placeholder="Offer"> <input type="button" class="btn btn-sm btn-success revise_offer" name="revise_offer" id="'.$offer_id.'" value="Revise"> </div>';        
      }
      $sold_amount = @$row['SOLD_AMOUNT'];      
      if(empty($sold_amount)){
        $nestedData[] = '<div class="pull-right" style="width:190px;"> <input style="width:115px;margin-right:10px;" class="form-control" type="number" name="sold_amount_'.$i.'" id="sold_amount_'.$i.'" value="'.$sold_amount.'" placeholder="Sold Amount"> <input type="button" class="btn btn-sm btn-primary sold_amount" name="sold_amount" id="'.$i.'" value="Save"> </div>';
      }else{
        $nestedData[] = '<div class="pull-right" style="width:190px;"> <input style="width:115px;margin-right:10px;" class="form-control" type="number" name="amount_sold_'.$i.'" id="amount_sold_'.$i.'" value="'.$sold_amount.'" placeholder="Sold Amount"> <input type="button" class="btn btn-sm btn-success update_sold_amount" name="update_sold_amount" id="'.$offer_id.'" value="Update"> </div>';
      }

      $lz_estimate_id = @$row['LZ_ESTIMATE_ID'];
      $lz_bd_cata_id = @$row['LZ_BD_CATA_ID'];
      $category_id = @$row['CATEGORY_ID'];
      $catalogue_mt_id = @$row['CATALOGUE_MT_ID'];      
      if(empty($lz_estimate_id)){
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a class="btn btn-primary btn-sm" href="'.base_url().'catalogueToCash/c_purchasing/kitComponents/'.$category_id.'/'.$catalogue_mt_id.'/'.$lz_bd_cata_id.'/1111" id="" class="" title="Kit View">KIT VIEW</a> </div>';
      }else{
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a class="btn btn-success btn-sm updateEst" href="'.base_url().'catalogueToCash/c_purchasing/updateEstimate/'.$category_id.'/'.$catalogue_mt_id.'/'.$lz_bd_cata_id.'/1111" id=""  title="Update Kit">UPDATE KIT</a> </div>';  
      }
      $ct_tracking_no = @$row['TRACKING_NO'];
       $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.$ct_tracking_no.'" style="width:200px;"> </div>'; 

      $cost_price = @$row['COST_PRICE'];
      if(empty($row['TRACKING_NO'])){
        $nestedData[] = '<div style="width: 160px;">  <input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Save Tracking No"  class="btn btn-primary btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">Save</button> </div></div>';
      }else if(!empty($row['TRACKING_NO']) && empty($row['SELLER_DESCRIPTION'])){
        $nestedData[] = '<div style="width: 265px;"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price pull-left" value="'.$cost_price.'" style="width:100px;"> <div class="pull-left" style="margin-left: 10px;"> <button type="button" title="Update Tracking No"  class="btn btn-success btn-xs update_mpn_data" id="'.$i.'" tId="'.$row["TRACKING_ID"].'" style="height: 28px; margin-bottom: auto;">Update</button> </div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;" >Seller Desc</button></div> </div>';
      }else if(!empty($row['TRACKING_NO']) && !empty($row['SELLER_DESCRIPTION'])){
        $nestedData[] = '<div style="width: 265px;"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price pull-left" value="'.$cost_price.'"  style="width:100px;"> <div class="pull-left" style="margin-left: 10px;"> <button type="button" title="Update Tracking No"  class="btn btn-success btn-xs update_mpn_data" id="'.$i.'" tId="'.$row["TRACKING_ID"].'" style="height: 28px; margin-bottom: auto;">Update</button> </div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;color: green;" >Seller Desc</button></div> </div>';
      }

      // $nestedData[] = $row["LIST_DATE"];
      // $nestedData[] = "";
      // $nestedData[] = $row["STATUS"];
      $data[] = $nestedData;
    $i++;
    }

    $json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    =>  intval($totalData),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data"            => $data   // total data array
          
    );

    return $json_data;
                                      
    // $sql = $this->db2->query("SELECT FLAG_ID, OFFER_ID, OFFER_AMOUNT, WIN_STATUS, SOLD_AMOUNT, LZ_BD_CATA_ID, VERIFIED, AVERAGE_PRICE, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO,SELLER_DESCRIPTION, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SALE_PRICE + SHIPPING_COST SALE_PRICE FROM (SELECT BD.FLAG_ID, BD.VERIFIED, O.OFFER_ID, O.OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON') WIN_STATUS, SOLD_AMOUNT, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, AV.QTY_SOLD, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID,T.SELLER_DESCRIPTION, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, MPN_AVG_PRICE        AV, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T, LZ_BD_PURCHASE_OFFER O WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND (BD.FLAG_ID = 23 OR BD.FLAG_ID = 25) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND bd.LZ_BD_CATA_ID = o.lz_bd_cata_id(+) AND BD.IS_DELETED <> 1 ORDER BY BD.INSERTED_DATE DESC) INER_TAB ")->result_array();
    // $sql = $this->db2->query("SELECT BD.FLAG_ID, BD.VERIFIED, O.OFFER_ID, O.OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON') WIN_STATUS, SOLD_AMOUNT, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' h :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' m :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' s ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.SELLER_DESCRIPTION, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE FROM LZ_BD_ITEMS_TO_EST BD, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T, LZ_BD_PURCHASE_OFFER O WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND (BD.FLAG_ID = 23 OR BD.FLAG_ID = 25) AND BD.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND BD.IS_DELETED <> 1 ORDER BY BD.INSERTED_DATE DESC")->result_array();
    // //$flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG order by flag_id")->result_array();

    // return array('sql'=> $sql);
   
      
  }
  ///
  public function loadSearchPurchDetail() {
       
    $Search_List_type = $this->session->userdata('Search_List_type');
    $Search_condition = $this->session->userdata('Search_condition');
    $Search_seller = $this->session->userdata('Search_seller');
    $seller_id = trim(str_replace("'","''", $Search_seller));
    $seller_id = strtoupper($Search_seller);
    $date_range = $this->session->userdata('date_range');

    $from = $this->session->userdata('from');
    $to = $this->session->userdata('to');
    if(!empty(@$from) && !empty(@$to) ){
    $date_qry = "AND O.OFFER_DATE BETWEEN TO_DATE('$from "."00:00:00','DD-MM-YY HH24:MI:SS') AND TO_DATE('$to ". "23:59:59','DD-MM-YY HH24:MI:SS')";
    }else{
      $date_qry = "";
    }
    $keyword = $this->session->userdata('serchkeyword');
    $str = explode(' ', $keyword);
    $purch_mpn = $this->session->userdata('purch_mpn');
    $purch_mpn = trim(str_replace("'","''", $purch_mpn));
    $purch_mpn = strtoupper($purch_mpn);

    $Search_category = $this->session->userdata('Search_category');
    $fed_one = $this->session->userdata('fed_one');
    $fed_two = $this->session->userdata('fed_two');
    $perc_one = $this->session->userdata('perc_one');
    $perc_two = $this->session->userdata('perc_two');

    $kit_one = $this->session->userdata('kit_one');
    $kit_two = $this->session->userdata('kit_two');
    $title_sort = $this->session->userdata('title_sort');
    $time_sort = $this->session->userdata('time_sort');
    $flag = $this->session->userdata('flag');

    $check_List_type = $Search_List_type[0];
    $check_val = $Search_condition[0];
   // $check_mpn = $purch_mpn[0];
    $check_categ = $Search_category[0];
    $check_flag = $flag[0];
      
    if($check_categ != 'all' && $check_categ != null){
      $categ_exp = '';
      $i = 0;
      foreach ($Search_category as $catag_value) {
        if(!empty($Search_category[$i+1])){
        $categ_exp= $categ_exp . $catag_value.',';
    
        }else{
          $categ_exp= $categ_exp . $catag_value;
        }
      $i++; 
        
      }
    }

    if($check_flag != 'all' && $check_flag != null){
      $flag_exp = '';
      $i = 0;
      foreach ($flag as $flag_value) {
        if(!empty($flag[$i+1])){
        $flag_exp= $flag_exp . $flag_value.',';
    
        }else{
          $flag_exp= $flag_exp . $flag_value;
        }
      $i++; 
        
      }
    }
  

    if($check_val != 'all' && $check_val != null){
      $cond_exp = '';
      $i = 0;
      foreach ($Search_condition as $mpn_value) {
        if(!empty($Search_condition[$i+1])){
        $cond_exp= $cond_exp . $mpn_value.',';
    
        }else{
          $cond_exp= $cond_exp . $mpn_value;
        }
      $i++; 
        
      }
    }

    if($check_List_type != 'all' && $check_List_type != null){
      $list_exp = '';
      $i = 0;
      foreach ($Search_List_type as $list_value) {
        if(!empty($Search_List_type[$i+1])){
        $list_exp= $list_exp ."'". $list_value."'".',';
     
        }else{
           $list_exp= $list_exp."'".$list_value."'";
           
        }
      $i++;  
      }
      $list_exp=strtoupper($list_exp);
    }

   
    
    $sql = "SELECT * FROM (SELECT OFFER_ID, OFFER_AMOUNT, WIN_STATUS, SOLD_AMOUNT, FLAG_ID, LZ_BD_CATA_ID, VERIFIED, AVERAGE_PRICE, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID,SELLER_DESCRIPTION, LZ_ESTIMATE_ID, COST_PRICE FROM (SELECT O.OFFER_ID, O.OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON') WIN_STATUS, SOLD_AMOUNT, BD.FLAG_ID, nvl(bd.SHIPPING_COST, 0) SHIPPING_COST, BD.VERIFIED, BD.LZ_BD_CATA_ID, nvl(AV.AVG_PRICE, 0) AVERAGE_PRICE, AV.QTY_SOLD, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID,T.SELLER_DESCRIPTION, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, MPN_AVG_PRICE        AV, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T, LZ_BD_PURCHASE_OFFER O WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND (BD.FLAG_ID = 23 OR BD.FLAG_ID = 25) and BD.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND BD.IS_DELETED <> 1 AND BD.CONDITION_ID = AV.CONDITION_ID(+) $date_qry"; //$date_qry


    if($check_categ != 'all' && $check_categ != null){
      $sql.=" AND  BD.MAIN_CATEGORY_ID in($categ_exp)";
    }else{
      //$sql.=" AND  BD.MAIN_CATEGORY_ID =177";
    }

    // if($check_flag != 'all' && $check_flag != null){
    //   $sql.=" AND  bd.flag_id in($flag_exp)";
    // }
    // else{
    //   $sql.="  AND (BD.FLAG_ID <> 20 or BD.FLAG_ID is null)";
    // }

    if(!empty($seller_id)){
      $sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";
    }

    if(!empty($purch_mpn)){
      $sql.=" and UPPER(m.mpn) = '$purch_mpn' ";

    }     

    if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
      if (count($str)>1) {
        $i=1;
        foreach ($str as $key) {
          if($i === 1){
            $sql.=" and UPPER(TITLE) LIKE '%$key%' ";
          }else{
            $sql.=" AND UPPER(TITLE) LIKE '%$key%' ";
          }
          $i++;
        }
      }else{
        $sql.=" and UPPER(TITLE) LIKE '%$keyword%' ";
      }
    }

          
    if($check_val != 'all'  && $check_val != null){
      $sql.=" AND  BD.CONDITION_ID in($cond_exp)";
    }
   
    if($check_List_type != 'all' && $check_List_type != null){
      $sql.=" AND UPPER(BD.listing_type) in ($list_exp) ";
    }            
       
    // if(!empty($title_sort)){
    //   if($title_sort == 1){
    //     $sql.=" ORDER BY LENGTH(title)  asc";
    //   }
    //   if($title_sort == 2){
    //     $sql.=" ORDER BY LENGTH(title)  desc";
    //   }

    // }
    $sql.=" ORDER BY BD.INSERTED_DATE DESC) iner_tab)";
    $sql.="  WHERE VERIFIED = 1";

    $query = $this->db2->query($sql);
    $sql = $query->result_array();

    return array('sql'=> $sql);

      }



  public function searchByListType(){
    $cat_id             = $this->uri->segment(4); 
    $catalogue_mt_id        = $this->uri->segment(5);

    $listingType          = strtoupper($this->input->post('listingType'));
    $condition            = trim($this->input->post('condition'));
    //var_dump($listingType, $condition); exit;
    $sess_data            = array("ctListingType"=>$listingType, "ctListing_condition"=>$condition);
    $this->session->set_userdata($sess_data);
    if (!empty($this->session->userdata('ctListingType')) && !empty($this->session->userdata('ctListing_condition'))) {
      $listingType = $this->session->userdata('ctListingType');
      $condition   = $this->session->userdata('ctListing_condition');
    }

    $mpn_qry= "SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID and rownum < 15 AND BD.CATALOGUE_MT_ID = $catalogue_mt_id ";

    $detail_qry= "SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AVERAGE_PRICE, BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE, det.est_price, det.est_ebay_fee, det.est_paypal_fee, det.est_ship_fee FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id , de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee)       est_ebay_fee, sum(de.paypal_fee)         est_paypal_fee, sum(de.shipping_fee)        est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id ) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID and rownum < 15 AND BD.SALE_TIME > SYSDATE AND  BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID (+) and t.lz_estimate_id = det.id(+) AND BD.CATALOGUE_MT_ID = $catalogue_mt_id   ";
      if(!empty($listingType))
            {
              $mpn_qry.=" AND UPPER(BD.listing_type) LIKE '%$listingType%'";
              $detail_qry.=" AND UPPER(BD.listing_type) LIKE '%$listingType%'";
            }

            if(!empty($condition))
            {
              $mpn_qry.=" AND  BD.CONDITION_ID =$condition";
              $detail_qry.=" AND  BD.CONDITION_ID =$condition";
            } 
            $mpn_qry.=" GROUP BY BD.CATALOGUE_MT_ID,C.MPN";
            $detail_qry.=" ORDER BY TIME_DIFF DESC";

      $detail = $this->db2->query($detail_qry)->result_array(); 
      $mpn = $this->db2->query($mpn_qry)->result_array();

    return array('detail'=>$detail, 'mpn' => $mpn);
  }
  public function saveBiddingOffer(){

    $bidding_offer = $this->input->post("bidding_offer");
    $lz_bd_catag_id = $this->input->post("lz_bd_catag_id");
    $cat_id = $this->input->post("cat_id");
    date_default_timezone_set("America/Chicago");
    $offer_date = date("Y-m-d H:i:s");
    $offer_date = "TO_DATE('".$offer_date."', 'YYYY-MM-DD HH24:MI:SS')";    
    $win_status = "NULL";
    $expire_date = "NULL";
    $revise_date = "NULL";
    $offered_by = $this->session->userdata('user_id'); 
    $revised_by = "NULL";
    // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_PURCHASE_OFFER','OFFER_ID') OFFER_ID FROM DUAL")->result_array();
    // $offer_id = $get_pk[0]['OFFER_ID'];
    $insert_query = $this->db2->query("INSERT INTO LZ_BD_PURCHASE_OFFER (OFFER_ID, CATEGORY_ID, OFFER_DATE, LZ_BD_CATA_ID, OFFER_AMOUNT, WIN_STATUS, EXPIRE_DATETIME, REVISE_DATETIME, OFFERED_BY, REVISED_BY) VALUES(bidding_offer_seq.nextval, $cat_id, $offer_date, $lz_bd_catag_id, $bidding_offer, $win_status, $expire_date, $revise_date, $offered_by, $revised_by)");

    if($insert_query){
      return 1;
    }else{
      return 2;
    }

  }

  public function reviseBiddingOffer(){

    $offer_id = $this->input->post("offer_id");
    $bidding_offer = $this->input->post("bidding_offer");
    date_default_timezone_set("America/Chicago");
    $revise_date = date("Y-m-d H:i:s");
    $revise_date = "TO_DATE('".$revise_date."', 'YYYY-MM-DD HH24:MI:SS')";    
    $revised_by = $this->session->userdata('user_id');

    $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET O.OFFER_AMOUNT = $bidding_offer, O.REVISE_DATETIME = $revise_date, O.REVISED_BY = $revised_by WHERE O.OFFER_ID = $offer_id");

    if($update_query){
      return 1;
    }else{
      return 2;
    }

  }
  public function changeBiddingStatus(){
    $lz_bd_cata_id = $this->input->post("lz_bd_cata_id");
    $cat_id = $this->input->post("cat_id");
    $status = $this->input->post("status");

    $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET O.WIN_STATUS = $status WHERE O.LZ_BD_CATA_ID = $lz_bd_cata_id AND O.CATEGORY_ID = $cat_id");

    if($update_query){
      return 1;
    }else{
      return 2;
    }    


  }
  public function saveSoldAmount(){
    $lz_bd_catag_id = $this->input->post("lz_bd_catag_id");
    $cat_id = $this->input->post("cat_id");
    $sold_amount = $this->input->post("sold_amount");

    $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET O.SOLD_AMOUNT = $sold_amount WHERE O.LZ_BD_CATA_ID = $lz_bd_catag_id AND O.CATEGORY_ID = $cat_id");

    if($update_query){
      return 1;
    }else{
      return 2;
    }   

  }
  public function updateSoldAmount(){

    $offer_id = $this->input->post("offer_id");
    $sold_amount = $this->input->post("sold_amount");

    $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET O.SOLD_AMOUNT = $sold_amount WHERE O.OFFER_ID = $offer_id");

    if($update_query){
      return 1;
    }else{
      return 2;
    }

  }
  public function trashResultRow(){
   $cat_id = $this->input->post("cat_id");
   $lz_bd_cata_id = $this->input->post("lz_bd_cata_id");
   $estimate_tab = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET IS_DELETED = 1 WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
   $update_flag = $this->db2->query("UPDATE lz_bd_active_data_$cat_id SET IS_DELETED = 1 WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
    if($update_flag){
      return 1;
    }else {
      return 2;
    }   
  }
  public function findItem(){

   $ebay_id = $this->input->post("ebay_id");

    // require __DIR__.'/../vendor/autoload.php';
    //$path = 'D:\wamp\www\laptopzone\application\views\ebay\trading\downloadItem.php';
    $path = '/../../../application/views/ebay/trading/downloadItem.php';
    include $path;                                                                            
    return $result;

  }
  public function get_brands($cat_id){
      
    // $objectList = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT       M, LZ_CATALOGUE_DET      D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CD.DET_ID = D.SPECIFIC_DET_ID AND M.CATEGORY_ID = $cat_id");
    $objectList = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT M, CATEGORY_SPECIFIC_MT CM, CATEGORY_SPECIFIC_DET CD WHERE CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND M.CATEGORY_ID = CM.EBAY_CATEGORY_ID AND M.CATEGORY_ID = $cat_id"); 
    return $objectList->result_array();

  }
  public function get_Objects(){
    $category_id = $this->input->post("category_id");
      
    $objects = $this->db2->query("SELECT DISTINCT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = O.CATEGORY_ID AND C.CATEGORY_ID = $category_id"); 
    return $objects->result_array();

  }  
  public function get_mastermpn(){
    $category_id = $this->input->post('category_id');
    $brand_name = strtoupper($this->input->post('brand_name'));
          
    //$mpnList = $this->db2->query("SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND CD.DET_ID = D.SPECIFIC_DET_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CD.DET_ID = $det_id AND M.CATEGORY_ID = $ct_category");
    $mpnList = $this->db2->query("SELECT MT.CATALOGUE_MT_ID,MT.MPN FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN_DESCRIPTION) LIKE '%$brand_name%' AND MT.CATEGORY_ID = $category_id AND MT.MPN NOT LIKE '%DELETED%'");
     
    return $mpnList->result_array();

  }
 // Get_mpnUpc
 public function get_MpnUPC(){
    $mpn_val = $this->input->post('mpn_val');
    //var_dump($mpn_val);
    //exit;
  $get_Mpn = $this->db2->query("SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID=$mpn_val")->result_array();
   return array('get_Mpn'=>$get_Mpn);
  } 
  //end of get_mpnUpc
  public function get_objectWiseMpn(){
          
   $object_id = $this->input->post('object_id');
   $category_id = $this->input->post('category_id');
   $type_brand = trim(strtoupper($this->input->post('type_brand')));
   $type_keyword = trim(strtoupper($this->input->post('type_keyword')));
   // $get_mpns = $this->db2->query("SELECT C.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $category_id AND C.OBJECT_ID = $object_id");
   $get_mpns = $this->db->query("SELECT * FROM (SELECT C.CATALOGUE_MT_ID, C.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $category_id AND C.OBJECT_ID = $object_id AND UPPER(C.BRAND) LIKE '%$type_brand%' AND (UPPER(C.MPN_DESCRIPTION) LIKE '%$type_keyword%' OR UPPER(C.MPN) LIKE '%$type_keyword%')) WHERE ROWNUM < 30"); 
   return $get_mpns->result_array();/*(UPPER(C.MPN) LIKE '%$type_keyword%' OR*/

  }          
  public function verifyMPN(){
    $category_id = $this->input->post('category_id');
    $verifiedmpn = $this->input->post('verifiedmpn');
    $verifiedMpnUpc = $this->input->post('verifiedMpnUpc');
    $verify_ebay_id = $this->input->post('verify_ebay_id');

    date_default_timezone_set("America/Chicago");
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";    
    $start_time = date("Y-m-d H:i:s");
    $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $sale_time = date('Y-m-d H:i:s', strtotime('1 months'));// date('m/01/Y');
    $sale_time = "TO_DATE('".$sale_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $flag_id = 23;


      $query = $this->db2->query("UPDATE LZ_BD_ACTIVE_DATA_$category_id SET CATALOGUE_MT_ID = $verifiedmpn, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $inserted_date, FLAG_ID = 23, VERIFIED = 1 WHERE EBAY_ID = $verify_ebay_id ");
    
    if($query){

      $est_tab = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CATALOGUE_MT_ID = $verifiedmpn, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $inserted_date, FLAG_ID = 23, VERIFIED = 1 WHERE EBAY_ID = $verify_ebay_id ");   
      $update_upc=$this->db2->query("UPDATE LZ_CATALOGUE_MT SET UPC='$verifiedMpnUpc' WHERE CATALOGUE_MT_ID = $verifiedmpn");  
      return 1;
    }else{
      return 0;
    }

  }
  public function saveAndVerifyMpn(){
    $category_id = $this->input->post('category_id');
    $mpn = $this->input->post('mpn');
    $ebay_id = $this->input->post('ebay_id');

    date_default_timezone_set("America/Chicago");
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";    
    $start_time = date("Y-m-d H:i:s");
    $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $sale_time = date('Y-m-d H:i:s', strtotime('1 months'));// date('m/01/Y');
    $sale_time = "TO_DATE('".$sale_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $flag_id = 23;

      $query = $this->db2->query("UPDATE LZ_BD_ACTIVE_DATA_$category_id SET CATALOGUE_MT_ID = $mpn, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $inserted_date, FLAG_ID = $flag_id, VERIFIED = 1 WHERE EBAY_ID = $ebay_id ");

    if($query){

      $est_tab = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CATALOGUE_MT_ID = $mpn, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $
        inserted_date, FLAG_ID = $flag_id, VERIFIED = 1 WHERE EBAY_ID = $ebay_id ");      

      return 1;
    }else{
      return 0;
    }

  }
  
  public function updateSellerDescription(){
    $desc = $this->input->post('seller_notes');

    $desc = trim(str_replace("  ", ' ', $desc));
    $desc = trim(str_replace(array("'"), "''", $desc));
    // var_dump($desc);exit;
    $tracking_no = $this->input->post('track_no');
    // var_dump($tracking_no);exit;
    $sql = $this->db2->query("UPDATE LZ_BD_TRACKING_NO SET SELLER_DESCRIPTION = '$desc' WHERE TRACKING_NO = '$tracking_no'");
    // $sql = $sql->result_array();
    return 1;
  }

  public function getSellerDescription(){
    $track_no = $this->input->post('track_no');

    $sql = $this->db2->query("SELECT SELLER_DESCRIPTION FROM LZ_BD_TRACKING_NO WHERE TRACKING_NO = '$track_no'");
    $sql = $sql->result_array();
    return $sql;
  }

  public function saveMpn(){

    $category_id = $this->input->post('category_id');
    $mpn_object = strtoupper($this->input->post('mpn_object'));
    $mpn_object = trim(str_replace("  ", ' ', $mpn_object));
    $mpn_object = str_replace(array("`,′"), "", $mpn_object);
    $mpn_object = str_replace(array("'"), "''", $mpn_object);
    $mpn_brand = strtoupper($this->input->post('mpn_brand'));
    $mpn_brand = trim(str_replace("  ", ' ', $mpn_brand));
    $mpn_brand = str_replace(array("`,′"), "", $mpn_brand);
    $mpn_brand = str_replace(array("'"), "''", $mpn_brand);
    $mpn_input = strtoupper($this->input->post('mpn_input'));
    $mpn_input = trim(str_replace("  ", ' ', $mpn_input));
    $mpn_input = str_replace(array("`,′"), "", $mpn_input);
    $mpn_input = str_replace(array("'"), "''", $mpn_input);
    $mpn_description = $this->input->post('mpn_description');
    $lot_upc = trim($this->input->post('lot_upc'));
    $mpn_description = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description = str_replace(array("`,′"), "", $mpn_description);
    $mpn_description = str_replace(array("'"), "''", $mpn_description);
    $user_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $verify_ebay_id = $this->input->post('verify_ebay_id');
  
    $start_time = date("Y-m-d H:i:s");
    $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $sale_time = date('Y-m-d H:i:s', strtotime('1 months'));// date('m/01/Y');
    $sale_time = "TO_DATE('".$sale_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $flag_id = 23;

    $sql = "SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$mpn_object' AND CATEGORY_ID = $category_id";
    $query = $this->db2->query($sql);
    if($query->num_rows() > 0){
      $query = $query->result_array();
      $object_id = $query[0]['OBJECT_ID'];
    }else{
      $sql = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL";
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $object_id = $query[0]['OBJECT_ID'];

      $sql = "INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID,OBJECT_NAME,INSERT_DATE,INSERT_BY,CATEGORY_ID,ITEM_DESC,SHIP_SERV,WEIGHT)VALUES($object_id , '$mpn_object',$insert_date,$user_id,$category_id,NULL,NULL,NULL)";
      $query = $this->db2->query($sql);
    }
    $sql = "SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn_input' AND CATEGORY_ID = $category_id";
    $res_query = $this->db2->query($sql);
   
    if($res_query->num_rows() > 0){
      $query = $res_query->result_array();
      $catalogue_mt_id = $query[0]['CATALOGUE_MT_ID'];      

        $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CATALOGUE_MT_ID = $catalogue_mt_id, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $insert_date, FLAG_ID = $flag_id, VERIFIED = 1 WHERE EBAY_ID = $verify_ebay_id");
        $this->db2->query("UPDATE LZ_BD_ACTIVE_DATA_$category_id SET CATALOGUE_MT_ID = $catalogue_mt_id, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $insert_date, FLAG_ID = $flag_id, VERIFIED = 1 WHERE EBAY_ID = $verify_ebay_id");

      return 2;//ALREADY EXIST
    }else{
      $sql ="SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL";
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $catalogue_mt_id = $query[0]['CATALOGUE_MT_ID'];

      $sql = "INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED, LAST_RUN_TIME, BRAND, UPC)VALUES($catalogue_mt_id , '$mpn_input',$category_id,$insert_date,$user_id,0,$object_id,'$mpn_description',0,NULL,'$mpn_brand', '$lot_upc')";
      $query = $this->db2->query($sql);

      /*========= Insertion of Brands in category_specific_det start ==========*/

      $mt_id_qry = $this->db2->query("SELECT CM.MT_ID FROM CATEGORY_SPECIFIC_MT CM WHERE UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CM.EBAY_CATEGORY_ID = $category_id");
      $mt_id_qry = $mt_id_qry->result_array();
      $mt_id = @$mt_id_qry[0]['MT_ID'];

      if(!empty($mt_id)){

        $check_qry = "SELECT DT.DET_ID FROM CATEGORY_SPECIFIC_DET DT WHERE DT.MT_ID = $mt_id AND UPPER(DT.SPECIFIC_VALUE) = '$mpn_brand'";
        $check_qry = $this->db2->query($check_qry);
          if($check_qry->num_rows() == 0){
            $det_id = "SELECT GET_SINGLE_PRIMARY_KEY('CATEGORY_SPECIFIC_DET','DET_ID') DET_ID FROM DUAL";
            $query = $this->db2->query($det_id);
            $det_id = $query->result_array();
            $det_id = @$det_id[0]['DET_ID'];        

            $specific_det = "INSERT INTO CATEGORY_SPECIFIC_DET (DET_ID, MT_ID, SPECIFIC_VALUE)VALUES($det_id, $mt_id, '$mpn_brand')"; 
            $this->db2->query($specific_det);

          }

      }

      /*========= Insertion of Brands in category_specific_det end ==========*/

      if($query){
        $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CATALOGUE_MT_ID = $catalogue_mt_id, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $insert_date, FLAG_ID = $flag_id, VERIFIED = 1 WHERE EBAY_ID = $verify_ebay_id");
        $this->db2->query("UPDATE LZ_BD_ACTIVE_DATA_$category_id SET CATALOGUE_MT_ID = $catalogue_mt_id, IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $insert_date, FLAG_ID = $flag_id, VERIFIED = 1 WHERE EBAY_ID = $verify_ebay_id");

        return 1;
      }else{
        return 0;
      }
    }
    //return $query;
  }  

  public function saveTrackingNo(){
    $ct_tracking_no         = strtoupper(trim($this->input->post('ct_tracking_no')));
    //var_dump($ct_tracking_no); exit;
    $ct_cost_price          = trim($this->input->post('ct_cost_price'));
    $lz_bd_catag_id         = trim($this->input->post('lz_bd_catag_id'));
    $lz_cat_id              = trim($this->input->post('lz_cat_id'));

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $inserted_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');
    //var_dump($ct_tracking_no, $ct_cost_price, $lz_bd_catag_id, $lz_cat_id); exit;
    $table_name= "LZ_BD_ACTIVE_DATA_".$lz_cat_id;
    $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_BD_CATA_ID = $lz_bd_catag_id");
    if ($check_tracking_no->num_rows() > 0) {
      $tracking_id = $check_tracking_no->result_array()[0]['TRACKING_ID'];
      $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET TRACKING_NO = '$ct_tracking_no',  COST_PRICE = $ct_cost_price WHERE LZ_BD_CATA_ID = $lz_bd_catag_id");
      if($update_tracking_no){

        $tracking_estimate = $this->db2->query("UPDATE  LZ_BD_ITEMS_TO_EST SET TRACKING_NO = '$tracking_id', COST_PRICE = $ct_cost_price WHERE LZ_BD_CATA_ID = $lz_bd_catag_id");
        $tracking = $this->db2->query("UPDATE  $table_name SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_catag_id");
        if ($tracking) {
           $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_catag_id)");
          return true;
          
        }else {
        return false;
      }
      }
    }else {
      $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID FROM LZ_BD_TRACKING_NO T WHERE UPPER(T.TRACKING_NO) = '$ct_tracking_no'");
      if ($check_tracking_no->num_rows() == 0){
        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
        $rs = $qry->result_array();
          $tracking_id = $rs[0]['ID'];
      $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (TRACKING_NO, LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, COST_PRICE, DE_KIT_YN, INSERTED_DATE, INSERTED_BY) VALUES('$ct_tracking_no', $lz_bd_catag_id, $lz_cat_id, $tracking_id, $ct_cost_price, NULL, $inserted_date, $user_id)");
      if($insert_tracking_no){
        $tracking_estimate = $this->db2->query("UPDATE  LZ_BD_ITEMS_TO_EST SET TRACKING_NO = '$tracking_id', COST_PRICE = $ct_cost_price WHERE LZ_BD_CATA_ID = $lz_bd_catag_id");
        $tracking = $this->db2->query("UPDATE  $table_name SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_catag_id");
        if ($tracking) {
          $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_catag_id)");
            return true;  
          }else {
            return false;
          }
        }
       }else{
        return "exist";
       }
    }
  }

  //pro_copy_to_remote_server
  public function updateTrackingNo(){
    $trackingId             = trim($this->input->post('trackingId'));
    $ct_tracking_no         = strtoupper(trim($this->input->post('ct_tracking_no')));
    $ct_cost_price          = trim($this->input->post('ct_cost_price'));
    $lz_bd_catag_id         = trim($this->input->post('lz_bd_catag_id'));
    $lz_cat_id              = trim($this->input->post('lz_cat_id'));
    //var_dump($ct_tracking_no, $ct_cost_price, $lz_bd_catag_id, $lz_cat_id); exit;
    if (empty($trackingId)) {
      return false;
    }else {
      $check_tracking_no = $this->db2->query("SELECT T.TRACKING_NO FROM LZ_BD_TRACKING_NO T WHERE T.TRACKING_ID = $trackingId AND T.LZ_SINGLE_ENTRY_ID IS NOT NULL");
      if ($check_tracking_no->num_rows() == 0) {
         $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET TRACKING_NO = '$ct_tracking_no',  COST_PRICE = $ct_cost_price WHERE TRACKING_ID = $trackingId");
            if($update_tracking_no){
               $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_catag_id)");
              return 1;
            }else {
              return 0;
            }
      }else {  /// END IF STMT TO CHECK TRACKING NUMBER
        return 2;
      }
    }
  }


}
