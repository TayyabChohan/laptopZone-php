
<?php  
  class M_Purchasing extends CI_Model{
    public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function get_status_remarks(){

    $get_flag = $this->db->query("SELECT FF.FLAG_ID,FF.FLAG_NAME FROM LZ_BD_PURCHASING_FLAG FF WHERE FF.POST_STAT_CHECK = 1 ")->result_array();

    return  array('get_flag' => $get_flag );
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
    return array('mpn' => $mpn,'verified'=>$verified, 'category_name'=>$category_name);
  }

  public function showUnverifiedData($cat_id){
    $sess_data = array("unverify_List_type"=>"All", "unverify_condition"=>"All");
    $this->session->set_userdata($sess_data);

    /*$mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN");
    $mpn = $mpn->result_array();*/

    $unverified = $this->db2->query("SELECT *  FROM LZ_BD_ACTIVE_DATA_$cat_id BD WHERE BD.VERIFIED = 0");
    $detail = $unverified->result_array();
    
    $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();
    $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    return array('detail'=>$detail, 'list_types' => $list_types, 'conditions' => $conditions);
  }
  public function loadData($cat_id) {
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
     $columns     = array(
      // datatable column index  => database column name
      1 =>'EBAY_ID',
      4 =>'FEEDBACK_SCORE',
      7 =>'SALE_PRICE'
    );
    $sql = "SELECT LZ_BD_CATA_ID,ITEM_URL,EBAY_ID,ITEM_URL,TITLE,CONDITION_NAME,SELLER_ID,LISTING_TYPE,SALE_PRICE,START_TIME,SALE_TIME,FEEDBACK_SCORE FROM LZ_BD_ACTIVE_DATA_$cat_id  WHERE  VERIFIED=0 AND IS_DELETED = 0 AND SALE_TIME > SYSDATE AND START_TIME >= SYSDATE - 7";
    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    $sql = "SELECT LZ_BD_CATA_ID,EBAY_ID,ITEM_URL,TITLE,CONDITION_NAME,SELLER_ID,LISTING_TYPE,SALE_PRICE,START_TIME,SALE_TIME,FEEDBACK_SCORE FROM LZ_BD_ACTIVE_DATA_$cat_id  WHERE VERIFIED=0 AND IS_DELETED = 0 AND SALE_TIME > SYSDATE AND START_TIME >= SYSDATE - 7";

     
       if( !empty($requestData['search']['value'])) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
         
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )";  
        }
      }
    $totalData     = $this->db2->query($sql)->num_rows();
    $totalFiltered = $totalData;
    $query = $this->db2->query($sql)->result_array(); 
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
    $data          = array();
    foreach($query as $row ){ 
      $nestedData=array();


      $nestedData[] ="<div style='float:left;margin-right:8px;'><a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a></div> <div style='float:left; margin-left: 14px; border: 1px solid #ccc; padding: 2px 4px;'><input type='checkbox' name='selectforVerify' id='".$row['LZ_BD_CATA_ID']."' title='".$row['LZ_BD_CATA_ID']."'> </div>";
      //$item_url = $row['ITEM_URL'];
      
    
      /*$nestedData[] = "<a href='<?php //echo $item_url; ?>' target='_blank'><?php echo $ebay_id; ?></a>";*/
      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank'>".@$row['EBAY_ID']."</a>";
      //$nestedData[] = $row['EBAY_ID'];
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE']; 

      /*$StoreInventory   = 'StoreInventory';
      $FixedPrice     = 'FixedPrice';
      $Auction      = 'Auction';
      $AuctionWithBIN   = 'AuctionWithBIN';

      $StoreInventorycolor = 'StoreInventorycolor';
      $FixedPricecolor = 'FixedPricecolor';
      $auctioncolor = 'auctioncolor';
      $AuctionwithBINcolor = 'AuctionwithBINcolor';*/

      $nestedData[] = $row['LISTING_TYPE'];;

      
      $nestedData[] = $row['CONDITION_NAME'];
  $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px;  font-weight:700; width:100px;">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>'; 
      

      

      $data[] = $nestedData;

    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }


  /////////////////////////// load verifi data ////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////

    


  public function loadverifyData($cat_id) {
  $requestData = $_REQUEST;
    $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'MPN',
      2 => 'TIME_DIFF',
      3 =>'TITLE',
      4 =>'SELLER_ID',
      5 =>'FEEDBACK_SCORE',
      6 =>'LISTING_TYPE',
      7 =>'CONDITION_NAME',
      8 =>'TRACKING_ID',
      9 =>'AVERAGE_PRICE',
      10 =>'PRICE_AFTERLIST',
      11 =>'SALE_PRICE',
      12 =>'COST_PRICE',
      13 => '%',
      14 =>'EST_PRICE',
      15 => 'EST_EBAY_FEE',
      16 => 'EST_PAYPAL_FEE',
      17 => 'EST_SHIP_FEE',
      18 => 'TOTAL',
      19 => 'AMOUNT',
      20 => 'PROF%'
    );
    $sql = "SELECT BD.EBAY_ID ,BD.LZ_BD_CATA_ID,M.MPN,TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF,BD.TITLE,BD.SELLER_ID, BD.FEEDBACK_SCORE,BD.LISTING_TYPE,BD.CONDITION_NAME,BD.SALE_PRICE, GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID)  PRICE_AFTERLIST ,UPPER(T.TRACKING_NO) TRACKING_NO,T.TRACKING_ID,nvl(T.COST_PRICE,0) COST_PRICE,nvl(DET.EST_PRICE,0) EST_PRICE, nvl(DET.EST_EBAY_FEE,0) EST_EBAY_FEE, nvl(DET.EST_PAYPAL_FEE,0) EST_PAYPAL_FEE, nvl(DET.EST_SHIP_FEE,0) EST_SHIP_FEE ,NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE +  DET.EST_SHIP_FEE,0) TOTAL 
    FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id, de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee) est_ebay_fee, sum(de.paypal_fee) est_paypal_fee, sum(de.shipping_fee) est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) and t.lz_estimate_id = det.id(+) AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) AND BD.VERIFIED =1 and BD.SALE_TIME >sysdate";

        if( !empty($requestData['search']['value']) ) {   
          // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
        }
      }

    $query   = $this->db2->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    // when there is no search parameter then total number rows = total number filtered rows. 
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[] ="<div style='float:left;margin-right:8px;'><a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a> </div>";
    
        
        $estimate_price = $row['EST_PRICE'];
        $ebay_fee = $row['EST_EBAY_FEE'];
        $paypal_fee = $row['EST_PAYPAL_FEE'];
        $ship_fee = $row['EST_SHIP_FEE'];

        $active_sale_price = number_format((float)@$row['SALE_PRICE'],2,'.',',');
        $g = $ebay_fee+$paypal_fee+$ship_fee ;
        $h = $estimate_price-($active_sale_price + $g );
        // var_dump($active_sale_price);exit;

        $sold_avg = number_format((float)@$row['AVERAGE_PRICE'],2,'.',',');

        $percentage_price = (($sold_avg * 30) /100);
        $valid_price = ($sold_avg - $percentage_price);



    //     $out ="<div style='width:110px; background-color: yellow;'>". echo . "$ . number_format((float)@$valid_price,2,'.',',')" . "</div>";
    // var_dump($out);
    // exit;

      $nestedData[] = $row['EBAY_ID'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['TIME_DIFF'];
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE']; 
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = $row['CONDITION_NAME']; 
      $nestedData[] = $row['TRACKING_ID']; 
      
      $nestedData[] = $row['AVERAGE_PRICE']; 

      $nestedData[] = $row['PRICE_AFTERLIST']; 
      $nestedData[] = $row['SALE_PRICE'];
      $nestedData[] = $row['COST_PRICE']; 

      if ($active_sale_price  <= $valid_price ) {

    $valid_price = '$ '.number_format((float)@$valid_price,2,'.',',');

    $nestedData[] ="<div style='width:110px; background-color: yellow;'>".$valid_price." </div>";
    
    }else{
    
    $valid_price = '$ '.number_format((float)@$valid_price,2,'.',',');
    $nestedData[] ="<div style='width:110px;'>".$valid_price." </div>";

    }
      $nestedData[] = $row['EST_PRICE']; 
      $nestedData[] = $row['EST_EBAY_FEE']; 
      $nestedData[] = $row['EST_PAYPAL_FEE']; 
      $nestedData[] = $row['EST_SHIP_FEE'];
      $nestedData[] = $row['TOTAL']; 
      $nestedData[] = $h;


      if($estimate_price!= 0){
      $profit =$h/$estimate_price * 100;
      $nestedData[] = $profit.'%';

      }else{
      $profit ='0.%';
      $nestedData[] = $profit;
      }
        
    
    $data[] = $nestedData;        


    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }
////////// load unverified search data 
public function searchverifyData(){
      $cat_id             = $this->uri->segment(4);
    
      $listingType = $this->session->userdata('unverify_List_type');
      $condition   = $this->session->userdata('unverify_condition');
      $seller_id   = $this->session->userdata('seller');
      $mpn         = $this->session->userdata('mpn');

      $fed_one         = $this->session->userdata('fed_one');
      $fed_two         = $this->session->userdata('fed_two');
    
    $detail_qry = "SELECT BD.EBAY_ID ,BD.LZ_BD_CATA_ID,M.MPN,TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF,BD.TITLE,BD.SELLER_ID, BD.FEEDBACK_SCORE,BD.LISTING_TYPE,BD.CONDITION_NAME,BD.SALE_PRICE, GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID)  PRICE_AFTERLIST , UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, nvl(T.COST_PRICE,0) COST_PRICE,nvl(DET.EST_PRICE,0) EST_PRICE,  nvl(DET.EST_EBAY_FEE,0) EST_EBAY_FEE, nvl(DET.EST_PAYPAL_FEE,0) EST_PAYPAL_FEE, nvl(DET.EST_SHIP_FEE,0) EST_SHIP_FEE , NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE +  DET.EST_SHIP_FEE,0) TOTAL,GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) - ((GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) * 30) /100) VALID_PRICE ,NVL(DECODE( DET.EST_PRICE,0,0,EST_PRICE - BD.SALE_PRICE  + EST_SHIP_FEE + EST_EBAY_FEE + EST_PAYPAL_FEE/ DET.EST_PRICE *100 ),0) PROFIT_PERCENT FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id, de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee) est_ebay_fee, sum(de.paypal_fee) est_paypal_fee, sum(de.shipping_fee) est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) and t.lz_estimate_id = det.id(+) AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) AND BD.VERIFIED =1 and BD.SALE_TIME >sysdate";
      if(!empty($listingType))
            {
              $detail_qry.=" AND UPPER(listing_type) LIKE '%$listingType%'";
            }

            if(!empty($condition))
            {
              $detail_qry.=" AND  CONDITION_ID = $condition";
            }
            if(!empty($seller_id))
            {
              $detail_qry.=" AND UPPER(seller_id) LIKE '%$seller_id%'";
            }

           if(!empty($mpn))
            {
              $detail_qry.=" AND UPPER(mpn) LIKE '%$mpn%'";
            }
            if(!empty($fed_one) && !empty($fed_two)){
            $detail_qry.=" and FEEDBACK_SCORE between $fed_one and $fed_two";
            }
           


      $detail = $this->db2->query($detail_qry)->result_array(); 

      
    return array('cat_id'=>$cat_id);
  }
////// LOAD VERIFY SEARCH DATA SERVER SIDE PROCESSING
  public function loadverifySearchData($cat_id) {

      $listingType      = $this->session->userdata('unverify_List_type');
      $condition        = $this->session->userdata('unverify_condition');
      $seller_id        = $this->session->userdata('seller');
      $mpn              = $this->session->userdata('mpn');
      $fed_one          = $this->session->userdata('fed_one');
      $fed_two          = $this->session->userdata('fed_two');
      $perc_one         = $this->session->userdata('perc_one');
      $perc_two         = $this->session->userdata('perc_two');

    $requestData = $_REQUEST;
    $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'MPN',
      2 => 'TIME_DIFF',
      3 =>'TITLE',
      4 =>'SELLER_ID',
      5 =>'FEEDBACK_SCORE',
      6 =>'LISTING_TYPE',
      7 =>'CONDITION_NAME',
      8 =>'TRACKING_ID',
      9 =>'AVERAGE_PRICE',
      10 =>'PRICE_AFTERLIST',
      11 =>'SALE_PRICE',
      12 =>'COST_PRICE',
      13 => '%',
      14 =>'EST_PRICE',
      15 => 'EST_EBAY_FEE',
      16 => 'EST_PAYPAL_FEE',
      17 => 'EST_SHIP_FEE',
      18 => 'TOTAL',
      19 => 'AMOUNT',
      20 => 'PROF%'
    );
    $sql = "SELECT * FROM( SELECT BD.EBAY_ID ,BD.LZ_BD_CATA_ID,M.MPN,TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF,BD.TITLE,BD.SELLER_ID, BD.FEEDBACK_SCORE,BD.LISTING_TYPE,BD.CONDITION_NAME,BD.SALE_PRICE, GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID)  PRICE_AFTERLIST , UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, nvl(T.COST_PRICE,0) COST_PRICE, nvl(DET.EST_PRICE,0) EST_PRICE, nvl(DET.EST_EBAY_FEE,0) EST_EBAY_FEE, nvl(DET.EST_PAYPAL_FEE,0) EST_PAYPAL_FEE, nvl(DET.EST_SHIP_FEE,0) EST_SHIP_FEE , NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE +  DET.EST_SHIP_FEE,0) TOTAL,GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) - ((GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) * 30) /100) VALID_PRICE , NVL(DECODE( DET.EST_PRICE,0,0, EST_PRICE - BD.SALE_PRICE  + EST_SHIP_FEE + EST_EBAY_FEE + EST_PAYPAL_FEE/ DET.EST_PRICE *100 ),0) PROFIT_PERCENT FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id, de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee) est_ebay_fee, sum(de.paypal_fee) est_paypal_fee, sum(de.shipping_fee) est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) and t.lz_estimate_id = det.id(+) AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) AND BD.VERIFIED =1 and BD.SALE_TIME >sysdate "; 

      if(!empty($listingType))
            {
              $sql.=" AND UPPER(listing_type) LIKE '%$listingType%'";
            }

            if(!empty($condition))
            {
              $sql.=" AND  CONDITION_ID = $condition";
            } 
          if(!empty($seller_id))
            {
              $sql.=" AND UPPER(seller_id) LIKE '%$seller_id%'";
            }
            if(!empty($mpn))
            {
              $sql.=" AND UPPER(mpn) LIKE '%$mpn%'";
            }
            if(!empty($fed_one) && !empty($fed_two)){
            $sql.=" and FEEDBACK_SCORE between $fed_one and $fed_two";
            }
            $sql.=" ) inner_table";
            if(!empty($perc_one) && !empty($perc_two)){
            $sql.=" WHERE VALID_PRICE between $perc_one and $perc_two";
            }
  
  
        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
           $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
        }
      }

    $query   = $this->db2->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    // when there is no search parameter then total number rows = total number filtered rows. 
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ="<div style='float:left;margin-right:8px;'><a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a> </div>";
       
       

        $listing_type = $row['LISTING_TYPE'];
        $estimate_price = $row['EST_PRICE'];
        $ebay_fee = $row['EST_EBAY_FEE'];
        $paypal_fee = $row['EST_PAYPAL_FEE'];
        $ship_fee = $row['EST_SHIP_FEE'];

        $active_sale_price = number_format((float)@$row['SALE_PRICE'],2,'.',',');
        $g = $ebay_fee+$paypal_fee+$ship_fee ;
        $h = $estimate_price-($active_sale_price + $g );
        // var_dump($active_sale_price);exit;

        $sold_avg = number_format((float)@$row['AVERAGE_PRICE'],2,'.',',');

        $percentage_price = (($sold_avg * 30) /100);
        $valid_price = ($sold_avg - $percentage_price);


    //     $out ="<div style='width:110px; background-color: yellow;'>". echo . "$ . number_format((float)@$valid_price,2,'.',',')" . "</div>";
    // var_dump($out);
    // exit;

      $nestedData[] = $row['EBAY_ID'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['TIME_DIFF'];
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE']; 
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = $row['CONDITION_NAME']; 
      $nestedData[] = $row['TRACKING_ID']; 
      
      $nestedData[] = $row['AVERAGE_PRICE']; 

      $nestedData[] = $row['PRICE_AFTERLIST']; 
      $nestedData[] = $row['SALE_PRICE'];
      $nestedData[] = $row['COST_PRICE']; 

      if ($active_sale_price  <= $valid_price ) {

    $valid_price = '$ '.number_format((float)@$valid_price,2,'.',',');

    $nestedData[] ="<div style='width:110px; background-color: yellow;'>".$valid_price." </div>";
    
    }else{
    
    $valid_price = '$ '.number_format((float)@$valid_price,2,'.',',');
    $nestedData[] ="<div style='width:110px;'>".$valid_price." </div>";

    }
      $nestedData[] = $row['EST_PRICE']; 
      $nestedData[] = $row['EST_EBAY_FEE']; 
      $nestedData[] = $row['EST_PAYPAL_FEE']; 
      $nestedData[] = $row['EST_SHIP_FEE'];
      $nestedData[] = $row['TOTAL']; 
      $nestedData[] = $h;

 if($estimate_price!= 0){
      $profit =$h/$estimate_price * 100;
      $nestedData[] = $profit.'%';

      }else{
      $profit ='0.%';
      $nestedData[] = $profit;
      }
         
    
    $data[] = $nestedData;        

     

    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }
  //////////////// END VERIFY DATA FUNCTIONS ///////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////

public function loadSearchData($cat_id) {
        $Search_List_type           = $this->session->userdata('unverify_List_type');
        $Search_condition           = $this->session->userdata('unverify_condition');
        $Search_seller              = $this->session->userdata('unverify_seller');
        $seller_id                  = trim(str_replace("'","''", $Search_seller));
        $seller_id                  = strtoupper($Search_seller);
        
        $keyword                    = $this->session->userdata('unverify_serchkeyword');
        $str                        = explode(' ', $keyword);
    
        $fed_one                    = $this->session->userdata('unverify_fed_one');
        $fed_two                    = $this->session->userdata('unverify_fed_two');
 
        $title_sort                 = $this->session->userdata('unverify_title_sort');
        $time_sort                  = $this->session->userdata('unverify_time_sort');

        $check_List_type            = @$Search_List_type[0];
        $check_val                  = @$Search_condition[0];
       // $check_mpn = $purch_mpn[0];
        //$check_categ = @$Search_category[0];
        //$check_flag = $flag[0];
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
            $requestData = $_REQUEST;
            
                // datatable column index  => database column name
                 $columns     = array(
      // datatable column index  => database column name
      1 =>'EBAY_ID',
      4 =>'FEEDBACK_SCORE',
      7 =>'SALE_PRICE'
    );
            $cat_id             = $this->uri->segment(4);

          $sql= "SELECT BD.LZ_BD_CATA_ID, BD.EBAY_ID, BD.TITLE,ITEM_URL, BD.CONDITION_NAME, BD.SELLER_ID, BD.LISTING_TYPE, BD.SALE_PRICE,START_TIME, BD.SALE_TIME, BD.FEEDBACK_SCORE FROM LZ_BD_ACTIVE_DATA_$cat_id BD WHERE CATEGORY_ID = $cat_id AND IS_DELETED = 0 AND VERIFIED = 0 AND SALE_TIME > SYSDATE AND START_TIME >= SYSDATE - 7";

          if(!empty($seller_id)){
          $sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

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

          
            if($check_val != 'all'  && $check_val != null)
            {
              $sql.=" AND  BD.CONDITION_ID in($cond_exp)";
            }

            // if($check_seller != 'all' && $check_seller != null){
            //   $sql.=" AND UPPER(seller_id) in($seller_exp)";
            // }

            if($check_List_type != 'all' && $check_List_type != null){
               $sql.=" AND UPPER(BD.listing_type) in ($list_exp) ";
            }            

            if(!empty($fed_one) && !empty($fed_two)){
            $sql.=" and FEEDBACK_SCORE between $fed_one and $fed_two";
            }
            if(!empty($time_sort)){
              
              $sql.=" AND BD.start_TIME > SYSDATE - $time_sort";
               
            }
           
            if(!empty($title_sort)){
              if($title_sort == 1){
            $sql.=" ORDER BY LENGTH(title)  asc";

            }
            if($title_sort == 2){
            $sql.=" ORDER BY LENGTH(title)  desc )";

            }

            }

     


       if( !empty($requestData['search']['value'])) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
         
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )";  
        }
      }
    $totalData     = $this->db2->query($sql)->num_rows();
    $totalFiltered = $totalData;
    $query = $this->db2->query($sql)->result_array(); 
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
    $data          = array();
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[] ="<div style='float:left;margin-right:8px;'><a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a> </div> <div style='float:left; margin-left: 14px; border: 1px solid #ccc; padding: 2px 4px;'><input type='checkbox' name='selectforVerify' id='".$row['LZ_BD_CATA_ID']."' title='".$row['LZ_BD_CATA_ID']."'> </div>";
      
      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank'>".@$row['EBAY_ID']."</a>";
      
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE']; 
      $nestedData[] = $row['LISTING_TYPE'];;
      $nestedData[] = $row['CONDITION_NAME']; 
      
      $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px;  font-weight:700; width:100px;">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>';
      $data[] = $nestedData;
    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }


 public function unVerifyDropdown(){ 
      $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      // $seller =$this->db2->query("SELECT SELLER_ID, SELLER_ID || ' (' || COUNT(SELLER_ID) || ')' SELLER_NAME FROM all_active_data_view BD, LZ_CATALOGUE_MT M, mpn_avg_price av WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.SALE_TIME > SYSDATE - 1 and BD.VERIFIED = 1 and m.mpn is not null GROUP BY SELLER_ID") ->result_array();

    $flag_id = "SELECT FLAG_ID ,FLAG_NAME FROM LZ_BD_PURCHASING_FLAG ORDER BY FLAG_ID";
    $flag_id = $this->db2->query($flag_id)->result_array();

    $emp_id = "SELECT EM.EMPLOYEE_ID  EMP_ID, EM.FIRST_NAME||''||EM.LAST_NAME NAME  FROM EMPLOYEE_MT EM";
    $emp_id = $this->db->query($emp_id)->result_array();


    $cattegory = "SELECT distinct D.CATEGORY_ID, K.CATEGORY_NAME || '-' || D.CATEGORY_ID || ' (' || count_mpn.mpn ||')' CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY K,(select category_id cat_id ,count(mpn) mpn,category_id from lz_catalogue_mt group by category_id) count_mpn WHERE D.CATEGORY_ID = K.CATEGORY_ID and K.CATEGORY_ID = count_mpn.cat_id and d.lz_bd_group_id = 1";

    // $cate_name = $this->db2->query(" SELECT CATEGORY_NAME || '-' || CATEGORY_ID  CATEGORY_NAME from LZ_BD_CATEGORY where CATEGORY_ID = $cat_id group by category_name,category_id")->result_array();

    // ,'cate_name' => $cate_name

    $cattegory = $this->db2->query($cattegory);
    $cattegory = $cattegory->result_array();

      return array('list_types' => $list_types, 'conditions' => $conditions , 'cattegory' => $cattegory,'flag_id' => $flag_id,'emp_id' =>$emp_id);
  }
  public function category_name(){
    $cat_id = $this->uri->segment(4);
      $cate_name = $this->db2->query(" SELECT CATEGORY_NAME || '-' || CATEGORY_ID  CATEGORY_NAME from LZ_BD_CATEGORY where CATEGORY_ID = $cat_id group by category_name,category_id")->result_array();

      return array('cate_name' => $cate_name);

  }


public function mpnDetail($cat_id,$catalogue_id){
        //form input post values   
        $Search_List_type  = $this->input->post('serc_listing_Type');
        $Search_condition   = $this->input->post('condition'); 
        $Search_seller  = $this->input->post('seller');
       
        $keyword = $this->input->post('search_title');
        $keyword = strtoupper(trim(str_replace('  ',' ', $keyword)));
        $keyword = trim(str_replace("'","''", $keyword));
        $str = explode(' ', $keyword);
        $mpn       = strtoupper($this->input->post('mpn'));
        $fed_one   = $this->input->post('fed_one');
        $fed_two   = $this->input->post('fed_two') ;
        $perc_one  = $this->input->post('perc_one');
        $perc_two  = $this->input->post('perc_two') ;
        

        $title_sort =  $this->input->post('title_sort');
        $time_sort =  $this->input->post('time_sort');

        //check vatiables
        $check_List_type = $Search_List_type[0];
        $check_val = $Search_condition[0];
        $check_seller = $Search_seller[0];  
            
        // array for storing select values in sessions
        $multi_data = array(
            'Search_List_type' => $Search_List_type,
            'Search_condition'=>$Search_condition,
            'Search_seller' => $Search_seller,
            'serchkeyword' => $keyword,
          
            // "mpn" => $mpn,
             'fed_one' => $fed_one,
             'fed_two' => $fed_two,
             'perc_one' => $perc_one,
             'perc_two' => $perc_two,
           
             'title_sort' => $title_sort,
             'time_sort' => $time_sort

      );
      $this->session->set_userdata($multi_data);
     //var_dump($this->session->userdata('multi_data'));exit;
      
   

    if($check_val != 'all' && $check_val != null){
      $cond_exp = '';
      $i = 0;
      foreach ($Search_condition as $value) {
        if(!empty($Search_condition[$i+1])){
        $cond_exp= $cond_exp . $value.',';
    
      }else{
        $cond_exp= $cond_exp . $value;
        }
    $i++; 
        
      }
    }

    
    if($check_seller != 'all' && $check_seller != null){
      $seller_exp = '';
      $i = 0;
      foreach ($Search_seller as $seller_value) {
        if(!empty($Search_seller[$i+1])){
        $seller_exp= $seller_exp ."'". $seller_value."'".',';
        }
        else{
         $seller_exp= $seller_exp."'".$seller_value."'";
        }
    $i++; 
        
      }
      $seller_exp=strtoupper($seller_exp);
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

  
    $seller ="SELECT * FROM (SELECT BD.SELLER_ID, BD.SELLER_ID || ' (' || COUNT(BD.SELLER_ID) || ')' SELLER_NAME, sum(BD.sale_price + BD.SHIPPING_COST) sale FROM all_active_data_view BD,mpn_avg_price av where bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) AND BD.VERIFIED = 1 AND BD.SALE_TIME > SYSDATE - 1 and bd.category_id in (177,111422) and bd.seller_id is not  null  GROUP BY SELLER_ID order by sale desc ) WHERE rownum <= 20 ORDER BY rownum ";

    $mpn_qry= "SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_id and rownum < 15 ";

    $detail_qry= "SELECT BD.FLAG_ID, BD.LZ_BD_CATA_ID,AV.AVG_PRICE AVERAGE_PRICE, bd.catalogue_mt_id, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, nvl(BD.FEEDBACK_SCORE,0), BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, T.COST_PRICE, det.est_price, det.est_ebay_fee, det.est_paypal_fee, det.est_ship_fee FROM all_active_data_view BD,mpn_avg_price av, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id, de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee) est_ebay_fee, sum(de.paypal_fee) est_paypal_fee, sum(de.shipping_fee) est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID  AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) and t.lz_estimate_id = det.id(+) and BD.VERIFIED=1  and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id and bd.catalogue_mt_id =$catalogue_id and BD.category_id = $cat_id";
      


        if(!empty($keyword) ) {   // if there is a search parameter, $keyword contains search parameter
        if (count($str)>1) {
          $i=1;
          foreach ($str as $key) {
            if($i === 1){
              $detail_qry.=" and UPPER(TITLE) LIKE '%$key%' ";
            }else{
              $detail_qry.=" AND UPPER(TITLE) LIKE '%$key%' ";
            }
            $i++;
          }
        }else{
          $detail_qry.=" and UPPER(TITLE) LIKE '%$keyword%' ";
        }
          }

          
            if($check_val != 'all'  && $check_val != null)
            {
              $mpn_qry.=" AND  BD.CONDITION_ID in($cond_exp)";
              $detail_qry.=" AND  BD.CONDITION_ID in($cond_exp)";
            }
            if($check_seller != 'all' && $check_seller != null){
              $detail_qry.=" AND UPPER(seller_id) in($seller_exp)";
            }
            if($check_List_type != 'all' && $check_List_type != null){

           
             
            $mpn_qry.=" AND UPPER(BD.listing_type) in ($list_exp) ";
               $detail_qry.=" AND UPPER(BD.listing_type) in ($list_exp) ";
            }            

            if(!empty($mpn))
            {
              $detail_qry.=" AND UPPER(mpn) LIKE '%$mpn%'";
            }
            if(!empty($fed_one) && !empty($fed_two)){
            $detail_qry.=" and FEEDBACK_SCORE between $fed_one and $fed_two";
            }

                 
            $mpn_qry.=" GROUP BY BD.CATALOGUE_MT_ID,C.MPN";

            if(!empty($time_sort)){
              
              $detail_qry.=" AND BD.start_TIME > SYSDATE - $time_sort";
               
              }
            
            
            if(!empty($title_sort)){
              if($title_sort == 1){
            $detail_qry.=" ORDER BY LENGTH(title)  asc";

            }
            if($title_sort == 2){
            $detail_qry.=" ORDER BY LENGTH(title)  desc";

            }

            }
            
          $flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG")->result_array();
          $detail = $this->db2->query($detail_qry)->result_array(); 
          $seller = $this->db2->query($seller)->result_array(); 
          $mpn = $this->db2->query($mpn_qry)->result_array();

         return array('detail'=>$detail, 'mpn' => $mpn, 'flags'=>$flags,'seller' => $seller );
  }

 ////////////////PURCHAISING SERVER SIDE ///////////////////
//  public function loadPurchDetail() {
//     $requestData = $_REQUEST;
//          $requestData = $_REQUEST;

    
//    $columns     = array(
//       // datatable column index  => database column name
//       0 =>'EBAY_ID',
//       1 =>'TITLE',
//       2 => 'FLAG_ID',
//       3 => 'SELLER_ID',
//       4 => 'FEEDBACK_SCORE',
//       5 => 'LISTING_TYPE',
//       6 => 'TIME_DIFF',
//       7 => 'MPN',
//       8 => 'CONDITION_NAME',
//       9 => 'FESIBILITY_INDEX',
//       10 => 'SALE_PRICE',
//       11 => 'AVERAGE_PRICE',
//       12 => 'LIST_SOLD',
//       13 => 'QTY_SOLD',
//       14 => 'KIT_SELLING',
//       15 => 'P',
//       16 => 'KIT_PERCENT',
//       17 => 'SALE_PRICE',
//       18 => 'EST_PRICE',
//       19 => 'ASSSEMBLY_SELLING',
//       20 =>'ASSEM_PROFIT_$',
//       21 =>'ASSEMBLY_PROFIT_PERC',
//       36 =>'LEN'

          
//     );

//     $sql = "SELECT FLAG_ID, LZ_BD_CATA_ID, VERIFIED, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SHIPPING_COST, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, P, KIT_PERCENT, SALE_PRICE + SHIPPING_COST KIT_LIST, EST_PRICE, EST_EBAY_FEE, EST_PAYPAL_FEE, EST_SHIP_FEE, EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE ASSSEMBLY_SELLING, ASSEM_PROFIT_$, ASSEMBLY_PROFIT_PERC, TOTAL_1, SALE_PRICE + SHIPPING_COST SALE_PRICE, AVERAGE_PRICE, nvl(SELL_THROUGH_RANK /100 *  SELL_THROUGH + PROFIT_PERC_RANK /100 * KIT_PERCENT + TURNOVER_d_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE,0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FLAG_ID, LZ_BD_CATA_ID, VERIFIED, AVERAGE_PRICE, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SHIPPING_COST, SALE_PRICE + SHIPPING_COST SALE_PRICE, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, SALE_PRICE + +SHIPPING_COST KIT_LIST, EST_PRICE, EST_EBAY_FEE, EST_PAYPAL_FEE, EST_SHIP_FEE, EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE ASSSEMBLY_SELLING, NVL(ROUND(DECODE(EST_PRICE, 0, 0, EST_PRICE - (SALE_PRICE + SHIPPING_COST + EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)), 2), 0) ASSEM_PROFIT_$, NVL(ROUND(DECODE(EST_PRICE, 0, 0, (EST_PRICE - (SALE_PRICE + SHIPPING_COST + EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)) / EST_PRICE * 100), 2), 0) ASSEMBLY_PROFIT_PERC, ROUND(NVL(EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE, 0), 2) TOTAL_1, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_d_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(decode(GOOD_AVG_SALE_QTY,0,0, AVG_SOLD_QTY_PER_DAY /GOOD_AVG_SALE_QTY  * 100), 2) TURN_U_FACT_PERC, ROUND(decode(GOOD_AVG_SALE_VAL ,0,0, AVG_SOLD_VALU_PER_DAY /GOOD_AVG_SALE_VAL  * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_d_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(decode(ACTI.TRUNOVER_UNIT,0,0,AV.TRUNOVER_UNIT/ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE, /*ASSEMBLY ITEMS CALCULATIONS*/ NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) KIT, DECODE(NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0), 0, NVL((SELECT NVL(SUM(M.AVG_PRICE), 0) FROM LZ_BD_MPN_KIT_MT P, MPN_AVG_PRICE M WHERE P.PART_CATLG_MT_ID = M.CATALOGUE_MT_ID AND PART_CATLG_MT_ID = BD.CATALOGUE_MT_ID GROUP BY PART_CATLG_MT_ID), 0), NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0)) EST_PRICE, NVL((SELECT SUM(DE.EBAY_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_EBAY_FEE, NVL((SELECT SUM(DE.PAYPAL_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_PAYPAL_FEE, NVL((SELECT SUM(DE.SHIPPING_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_SHIP_FEE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+)  AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.START_TIME >= SYSDATE - 3 AND (BD.FLAG_ID <> 20 AND BD.FLAG_ID <> 24 OR BD.FLAG_ID IS NULL) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+)  AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.CATEGORY_ID = 111422  ORDER BY EST_PRICE DESC) INER_TAB) OUTER_TAB "; 
// //
// // 

//     if( !empty($requestData['search']['value']) ) {// if there is a search parameter, $requestData['search']['value'] contains search parameter
//           $sql.=" where ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
//           $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
//           $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
//           $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
//           $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
//           // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
//           // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
//       }else{
//         if(!empty($requestData['search']['value'])){
//            // if there is a search parameter, $requestData['search']['value'] contains search parameter
//           $sql.=" where ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
//           $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
//           $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
//           $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
//           $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
//            $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
//             $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
//           // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
//           // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
//           // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
//           // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
//         }
//       }

//     $query   = $this->db2->query($sql); 
//     $totalData     = $query->num_rows();
//     $totalFiltered = $totalData;

//     $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
//     $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
//     $query         = $this->db2->query($sql)->result_array();
//    /* $totalData     = $query->num_rows();
//     $totalFiltered = $totalData;*/
//     $flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG order by flag_id")->result_array();
//    /* echo "<pre>";
//     print_r($flags);
//     exit;*/

//     $data          = array();
//     $i = 1;
//     foreach($query as $row ){ 
//       $nestedData=array();

     
//       $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank' id='link".$i."'>".@$row['EBAY_ID']."</a>";
//        $nestedData[] =  '<div class="pull-right" style="width:250px;">'.$row['TITLE'].'</div>';
//       $flag_id = $row['FLAG_ID']; 
//       $lz_cat_id = $row['CATEGORY_ID']; 
//       //$kit_flag= $this->session->userdata("ctc_kit_flag"); 
//       /*echo "<pre>";
//       print_r($flags);
//       exit;*/
//       if(!empty($data['flags'])){ 
//         foreach ($data['flags'] as $flag){
//             $flag_data = $flag['FLAG_ID'];
//           }
//       }

//       if($flag_id == $flags[0]['FLAG_ID']){ $thumb_up = "show-flag"; }else { $thumb_up = '';}
//       if($flag_id == $flags[1]['FLAG_ID']){ $thumb_down = "show-flag"; }else { $thumb_down = '';}
//       if($flag_id == $flags[2]['FLAG_ID']){ $female = "show-flag"; }else { $female = '';}
//       if($flag_id == $flags[3]['FLAG_ID']){ $trash = "show-flag"; }else { $trash = '';}
//       if($flag_id == $flags[4]['FLAG_ID']){ $flag_usd = "show-flag"; }else { $flag_usd = '';}
//       if($flag_id == $flags[5]['FLAG_ID']){ $discard_mpn = "show-flag"; }else { $discard_mpn = '';}
//       if($flag_id == $flags[6]['FLAG_ID']){ $bidding_flag = "show-flag"; }else { $bidding_flag = '';}

//       $fid_0 =$flags[0]['FLAG_ID'];
//       $fid_1 =$flags[1]['FLAG_ID'];
//       $fid_2 =$flags[2]['FLAG_ID'];
//       $fid_3 =$flags[3]['FLAG_ID'];
//       $fid_4 =$flags[4]['FLAG_ID'];
//       $fid_5 =$flags[5]['FLAG_ID'];
//       $fid_6 =$flags[6]['FLAG_ID'];

//       $thumb_up_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_0; 
//       $thumb_down_id              = $row['LZ_BD_CATA_ID'].'_'.$fid_2;
//       $female_id                  = $row['LZ_BD_CATA_ID'].'_'.$fid_3;
//       $trash_id                   = $row['LZ_BD_CATA_ID'].'_'.$fid_1;
//       $flag_usd_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_4;
//       $flag_discard_mpn_id        = $row['LZ_BD_CATA_ID'].'_'.$fid_5;
//       $bidding_flag_id            = $row['LZ_BD_CATA_ID'].'_'.$fid_6;

//         $discrad_msg= "return confirm('Are you sure to discard?')";

//        $nestedData[] = '<div style="width: 200px;"> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="high_button m-3 '.$thumb_up.'" style="float: left;" id="'.$thumb_up_id.'"> <button title="Higly Interested" class="btn btn-success btn-xs high-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_0.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-up text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="less_button m-3 '.$thumb_down.'" style="float: left;" id="'.$thumb_down_id.'"> <button title="Less Interested" class="btn btn-primary btn-xs less-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_2.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-down text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="female_button m-3 '.$female.'" style="float: left;" id="'.$female_id.'"> <button title="Refer to Patica" class="btn btn-info btn-xs flag-female" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_3.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-female text text-center" aria-hidden="true"></i> </button> </div> </div> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button m-3 '.$trash.'" style="float: left;" id="'.$trash_id.'"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;"  id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_1.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-trash-o text text-center" aria-hidden="true"></i> </button> </div> <div class="usd_button m-3 '.$flag_usd.'" style="float: left;" id="'.$flag_usd_id .'"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_4.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-usd text text-center" aria-hidden="true" ></i> </button> </div> <div class="usd_button m-3 '.$discard_mpn.'" style="float: left;" id="'.$flag_discard_mpn_id.'"> <button title="Discard MPN" onclick="'.$discrad_msg.'" class="btn btn-primary btn-xs fa-discard-mpn" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_5.'" ct_id="'.$lz_cat_id.'" mpn_id="'.$row['CATALOGUE_MT_ID'].'"><i class="fa fa-ban" aria-hidden="true" ></i> </button> </div> </div> </div>';



//        $nestedData[] = $row['SELLER_ID'];
//       //var_dump($row['FLAG_ID']);
      
//       $nestedData[] = '<div class="text-center" style="width:130px;">'.$row['FEEDBACK_SCORE'].'     <i class="fa fa-star" aria-hidden="true" style="color: #008d4c;
//     font-size:18px;"></i></div>';
//       $nestedData[] = $row['LISTING_TYPE'];
//       $nestedData[] = '<div class="text-center" style="width:130px;">'.$row['TIME_DIFF'].'</div>';
//       $nestedData[] = '<div class="text-center" style="width:100px;">'.$row['MPN'].'</div>';
//       $nestedData[] = $row['CONDITION_NAME'];

      

// $nestedData[] ="<a href='".base_url()."catalogueToCash/c_purchasing/fesibility_index/".$row['LZ_BD_CATA_ID']."' target='_blank'>". number_format((float)@$row['FESIBILITY_INDEX'],2,'.',',').' %'."</a>";

      


      
      
//         /////// COMPONENT ITEMS /////////
//       //$SALE_PRICE =$row['SALE_PRICE'];
//       $nestedData[] = '<div class="pull-right" style="color:red; font-size:17px; font-weight:700; width:90px;">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>';        /// ACTIVE PRICE
//       $nestedData[] ='<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['AVERAGE_PRICE'],2,'.',',').'</div>';       ///// SOLD AVG
//       $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['LIST_SOLD'],2,'.',',').'</div>';    /// LIST SOLD

//       $nestedData[] ='<div class="pull-right" style="color:blue; font-size:17px; font-weight:700; width:60px;">'. number_format((float)@$row['QTY_SOLD'],0,'.',',').'</div>';  /// /QTY_SOLD

    
     
//       $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['KIT_SELLING'],2,'.',',').'</div>';   /// AMOUNT

//       $nestedData[] = '<div class="pull-right" style="color:red; font-size:17px;  font-weight:700; width:90px;">$ '. number_format((float)@$row['P'],2,'.',',').'</div>';
//       $nestedData[] = '<div class="pull-right" style="width:80px;">'. number_format((float)@$row['KIT_PERCENT'],2,'.',',').' %</div>';

//       //////////////////////////////////

//       /////// ASSEMBLY ITEMS /////////
//           /// SELLING
//       $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['KIT_LIST'],2,'.',',').'</div>';
//       $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['EST_PRICE'],2,'.',',').'</div>';    /// KIT
//       $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['ASSSEMBLY_SELLING'],2,'.',',').'</div>';   /// SELLING
//       $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['ASSEM_PROFIT_$'],2,'.',',').'</div>';    /// %2
//       $nestedData[] = '<div class="pull-right" style="width:80px;">'. number_format((float)@$row['ASSEMBLY_PROFIT_PERC'],2,'.',',').' %</div>';   /// AMOUNT CALULATION PENDING
//           /// %1


     

//       $nestedData[] = ''; ///status
//       $nestedData[] = ''; //// bid status
//       $nestedData[] = ''; ///// bid offer

//       $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
//       $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
//       $category_id  =     $row['CATEGORY_ID'];
//       $catalogue_mt_id  =     $row['CATALOGUE_MT_ID'];
      

//       if(empty($lz_estimate_id)){
//       $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
//       }else {
//        ///// copy estimate

//         $nestedData[] = '<div style="width: 150px;"><div class="form-group pull-left"><a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/copy_estimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Copy Estimate">Copy</a> </div><div class="form-group pull-left" style="margin-left:12px;"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm updateEst" href="'.base_url()."catalogueToCash/c_purchasing/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> </div>';
//       }
//       $ct_tracking_no = $row['TRACKING_NO'];
      

//       $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.@$ct_tracking_no.'" style="width:200px;"> </div>'; //// tracking no input field 

//       $cost_price = $row['COST_PRICE'];
//       if(empty($row['TRACKING_NO'])){
//         $nestedData[] ='<div style="width: 240px;"><div class="form-group pull-left"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price col-sm-3 " value="'.$cost_price.'" style="width:100px;"></div> <div class="form-group pull-left" style="margin-left:12px;"><button type="button" title="Save MPN Data"  class="btn btn-primary btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">save</button> </div> </div>';
//          }else {
//        $nestedData[] = '<div style="width: 260px;" ><div class="form-group pull-left"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price " value="'.$cost_price.'" style="width:100px;"></div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="Update MPN Data"  class="btn btn-success btn-xs update_mpn_data " id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">update</button></div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;" >Seller Desc</button></div> </div>';
//       }
//         //// cost price input field 26
//       $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
//       $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
//       $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
//       $nestedData[] = $row['TOTAL_1']; //// TOTAL

//       $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
//       $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
//       $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
//       $nestedData[] = $row['TOTAL_1']; //// TOTAL
//       $nestedData[] = $row['LEN'];

              
//     $data[] = $nestedData;        

     
//     $i++;
//     } //// end main foreach
//     $json_data = array(
//       "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
//       "recordsTotal" => intval($totalData), // total number of records
//       "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
//       "deferLoading" =>  intval( $totalFiltered ),
//       "data" => $data // total data array
//     );
//     return $json_data;
//   }
public function loadSearchPurchDetail() {
       
        $Search_List_type = $this->session->userdata('Search_List_type');
        $Search_condition = $this->session->userdata('Search_condition');
        $Search_seller = $this->session->userdata('Search_seller');
        $seller_id = trim(str_replace("'","''", $Search_seller));
        $seller_id = strtoupper($Search_seller);
        
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
        //var_dump($Search_List_type); exit;
     //var_dump($this->session->userdata('multi_data'));exit;
      
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

    $requestData = $_REQUEST;

   $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 => 'FLAG_ID',
      3 => 'SELLER_ID',
      4 => 'FEEDBACK_SCORE',
      5 => 'LISTING_TYPE',
      6 => 'TIME_DIFF',
      7 => 'MPN',
      8 => 'CONDITION_NAME',
      9 => 'FESIBILITY_INDEX',
      10 => 'SALE_PRICE',
      11 => 'AVERAGE_PRICE',
      12 => 'LIST_SOLD',
      13 => 'QTY_SOLD',
      14 => 'KIT_SELLING',
      15 => 'P',
      16 => 'KIT_PERCENT',
      17 => 'SALE_PRICE',
      18 => 'EST_PRICE',
      19 => 'ASSSEMBLY_SELLING',
      20 =>'ASSEM_PROFIT_$',
      21 =>'ASSEMBLY_PROFIT_PERC',
      36 =>'LEN'

          
    );
    

    $sql = "SELECT FLAG_ID,SELLER_DESCRIPTION, LZ_BD_CATA_ID, VERIFIED, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SHIPPING_COST, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, P, KIT_PERCENT, SALE_PRICE + SHIPPING_COST KIT_LIST, EST_PRICE, EST_EBAY_FEE, EST_PAYPAL_FEE, EST_SHIP_FEE, EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE ASSSEMBLY_SELLING, ASSEM_PROFIT_$, ASSEMBLY_PROFIT_PERC, TOTAL_1, SALE_PRICE + SHIPPING_COST SALE_PRICE, AVERAGE_PRICE, nvl(SELL_THROUGH_RANK /100 *  SELL_THROUGH + PROFIT_PERC_RANK /100 * KIT_PERCENT + TURNOVER_d_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE,0) FESIBILITY_INDEX  FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT SELLER_DESCRIPTION,FLAG_ID, LZ_BD_CATA_ID, VERIFIED, AVERAGE_PRICE, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SHIPPING_COST, SALE_PRICE + SHIPPING_COST SALE_PRICE, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, SALE_PRICE + +SHIPPING_COST KIT_LIST, EST_PRICE, EST_EBAY_FEE, EST_PAYPAL_FEE, EST_SHIP_FEE, EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE ASSSEMBLY_SELLING, NVL(ROUND(DECODE(EST_PRICE, 0, 0, EST_PRICE - (SALE_PRICE + SHIPPING_COST + EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)), 2), 0) ASSEM_PROFIT_$, NVL(ROUND(DECODE(EST_PRICE, 0, 0, (EST_PRICE - (SALE_PRICE + SHIPPING_COST + EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)) / EST_PRICE * 100), 2), 0) ASSEMBLY_PROFIT_PERC, ROUND(NVL(EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE, 0), 2) TOTAL_1, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_d_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(decode(GOOD_AVG_SALE_QTY,0,0, AVG_SOLD_QTY_PER_DAY /GOOD_AVG_SALE_QTY  * 100), 2) TURN_U_FACT_PERC, ROUND(decode(GOOD_AVG_SALE_VAL ,0,0, AVG_SOLD_VALU_PER_DAY /GOOD_AVG_SALE_VAL  * 100), 2) TURN_U_FACT_VALUE FROM (SELECT   T.SELLER_DESCRIPTION,(SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_d_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(decode(ACTI.TRUNOVER_UNIT,0,0,AV.TRUNOVER_UNIT/ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE, /*ASSEMBLY ITEMS CALCULATIONS*/ NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) KIT, DECODE(NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0), 0, NVL((SELECT NVL(SUM(M.AVG_PRICE), 0) FROM LZ_BD_MPN_KIT_MT P, MPN_AVG_PRICE M WHERE P.PART_CATLG_MT_ID = M.CATALOGUE_MT_ID AND PART_CATLG_MT_ID = BD.CATALOGUE_MT_ID GROUP BY PART_CATLG_MT_ID), 0), NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0)) EST_PRICE, NVL((SELECT SUM(DE.EBAY_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_EBAY_FEE, NVL((SELECT SUM(DE.PAYPAL_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_PAYPAL_FEE, NVL((SELECT SUM(DE.SHIPPING_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_SHIP_FEE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) /*AND (BD.FLAG_ID <> 20 AND BD.FLAG_ID <> 24 OR BD.FLAG_ID IS NULL)*/ AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)"; 

    if($check_categ != 'all' && $check_categ != null)

        {
          $sql.=" AND  BD.MAIN_CATEGORY_ID in($categ_exp)";
        }else{
          $sql.=" AND  BD.MAIN_CATEGORY_ID =111422";
        }

    if($check_flag != 'all' && $check_flag != null)
        {
          $sql.=" AND  bd.flag_id in($flag_exp)";
        }
        else {
          $sql.=" AND (BD.FLAG_ID <> 20 AND BD.FLAG_ID <> 24 OR BD.FLAG_ID IS NULL)";
          //Removed lot flag /*AND BD.FLAG_ID <> 29*/
        }

      if(!empty($seller_id)){
      $sql.=" and UPPER(BD.seller_id) LIKE '%$seller_id%' ";

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

          
            if($check_val != 'all'  && $check_val != null)
            {
              $sql.=" AND  BD.CONDITION_ID in($cond_exp)";
            }
            // if($check_seller != 'all' && $check_seller != null){
            //   $sql.=" AND UPPER(seller_id) in($seller_exp)";
            // }
            if($check_List_type != 'all' && $check_List_type != null){
               $sql.=" AND UPPER(BD.listing_type) in ($list_exp) ";
            }            

            if(!empty($fed_one) && !empty($fed_two)){
            $sql.=" and FEEDBACK_SCORE between $fed_one and $fed_two";
            }
            if(!empty($time_sort)){
              
              $sql.=" AND BD.start_TIME >= SYSDATE - $time_sort";
               
            }else{
              //$sql.=" AND BD.start_TIME >= SYSDATE - 3";
            }
           
            if(!empty($title_sort)){
              if($title_sort == 1){
            $sql.=" ORDER BY LENGTH(title)  asc";

            }
            if($title_sort == 2){
            $sql.=" ORDER BY LENGTH(title)  desc";

            }

            }
            $sql.=" ) iner_tab) OUTER_TAB";
            $sql.="  WHERE VERIFIED = 1";

            if(!empty($perc_one) && !empty($perc_two)){
              
            $sql.=" AND ASSEMBLY_PROFIT_PERC between $perc_one and $perc_two";
            }
            if(!empty($kit_one) && !empty($kit_two)){
            $sql.="  and kit_percent between $kit_one and $kit_two";
            }
  
  
        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
           $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
        }
      }

     $query   = $this->db2->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    if(empty($title_sort)){
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
}
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/


    $flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG order by flag_id")->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    // echo "<pre>";
    // print_r ($flags);
    // echo "</pre>";
    // exit;
    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();


      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank' id='link".$i."'>".@$row['EBAY_ID']."</a>";
      $nestedData[] =  '<div class="pull-right" style="width:250px;">'.$row['TITLE'].'</div>';
      $flag_id = $row['FLAG_ID']; 
      $lz_cat_id = $row['CATEGORY_ID']; 
        if(!empty($data['flags'])){ 
        foreach ($data['flags'] as $flag){
            $flag_data = $flag['FLAG_ID'];
          }
      }

      if($flag_id == $flags[0]['FLAG_ID']){ $thumb_up = "show-flag"; }else { $thumb_up = '';}
      if($flag_id == $flags[1]['FLAG_ID']){ $thumb_down = "show-flag"; }else { $thumb_down = '';}
      if($flag_id == $flags[2]['FLAG_ID']){ $female = "show-flag"; }else { $female = '';}
      if($flag_id == $flags[3]['FLAG_ID']){ $trash = "show-flag"; }else { $trash = '';}
      if($flag_id == $flags[4]['FLAG_ID']){ $flag_usd = "show-flag"; }else { $flag_usd = '';}
      if($flag_id == $flags[5]['FLAG_ID']){ $discard_mpn = "show-flag"; }else { $discard_mpn = '';}
      if($flag_id == $flags[6]['FLAG_ID']){ $bidding_flag = "show-flag"; }else { $bidding_flag = '';}
      if($flag_id == $flags[10]['FLAG_ID']){ $lot_flag = "show-flag"; }else { $lot_flag = '';}

      $fid_0 =$flags[0]['FLAG_ID'];
      $fid_1 =$flags[1]['FLAG_ID'];
      $fid_2 =$flags[2]['FLAG_ID'];
      $fid_3 =$flags[3]['FLAG_ID'];
      $fid_4 =$flags[4]['FLAG_ID'];
      $fid_5 =$flags[5]['FLAG_ID'];
      $fid_6 =$flags[6]['FLAG_ID'];
      $fid_10 =$flags[10]['FLAG_ID'];

      $thumb_up_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_0; 
      $thumb_down_id              = $row['LZ_BD_CATA_ID'].'_'.$fid_2;
      $female_id                  = $row['LZ_BD_CATA_ID'].'_'.$fid_3;
      $trash_id                   = $row['LZ_BD_CATA_ID'].'_'.$fid_1;
      $flag_usd_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_4;
      $flag_discard_mpn_id        = $row['LZ_BD_CATA_ID'].'_'.$fid_5;
      $bidding_flag_id            = $row['LZ_BD_CATA_ID'].'_'.$fid_6;
      $lot_flag_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_10;

       $discrad_msg= "return confirm('Are you sure to discard?')";

       $nestedData[] = '<div style="width: 200px;"> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="high_button m-3 '.$thumb_up.'" style="float: left;" id="'.$thumb_up_id.'"> <button title="Higly Interested" class="btn btn-success btn-xs high-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_0.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-up text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="less_button m-3 '.$thumb_down.'" style="float: left;" id="'.$thumb_down_id.'"> <button title="Less Interested" class="btn btn-primary btn-xs less-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_2.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-down text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="female_button m-3 '.$female.'" style="float: left;" id="'.$female_id.'"> <button title="Refer to Patica" class="btn btn-info btn-xs flag-female" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_3.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-female text text-center" aria-hidden="true"></i> </button> </div> </div> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button m-3 '.$trash.'" style="float: left;" id="'.$trash_id.'"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;"  id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_1.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-trash-o text text-center" aria-hidden="true"></i> </button> </div> <div class="usd_button m-3 '.$flag_usd.'" style="float: left;" id="'.$flag_usd_id .'"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_4.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-usd text text-center" aria-hidden="true" ></i> </button> </div> <div class="usd_button m-3 '.$discard_mpn.'" style="float: left;" id="'.$flag_discard_mpn_id.'"> <button title="Discard MPN" onclick="'.$discrad_msg.'" class="btn btn-primary btn-xs fa-discard-mpn" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_5.'" ct_id="'.$lz_cat_id.'" mpn_id="'.$row['CATALOGUE_MT_ID'].'"><i class="fa fa-ban" aria-hidden="true" ></i> </button> </div> <div class="lot_button m-3 '.$lot_flag.'" style="float: left;" id="'.$lot_flag_id.'"> <button title="Lot Select" onclick="'.$lot_flag.'" class="btn btn-success btn-xs fa-lot-select" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_10.'" ct_id="'.$lz_cat_id.'" mpn_id="'.$row['CATALOGUE_MT_ID'].'"><i class="fa fa-cart-plus" aria-hidden="true" ></i> </button> </div> </div> </div>';

        /*<div class="usd_button m-3 '.$bidding_flag.'" style="float: left;" id="'.$bidding_flag_id.'"> <button title="Bidding" class="btn  btn-xs flag-bidding" style="width: 25px; background-color: #FFFFCC; border-color: black; color: black;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_6.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-gavel fa-bidding" aria-hidden="true" ></i> </button>
   </div>*/ 

      $nestedData[] = $row['SELLER_ID'];
      //var_dump($row['FLAG_ID']);
      $nestedData[] = '<div class="text-center" style="width:130px;">'.$row['FEEDBACK_SCORE'].'     <i class="fa fa-star" aria-hidden="true" style="color:#008d4c;
    font-size:18px;"></i></div>';
      $nestedData[] = $row['LISTING_TYPE'];
     $nestedData[] = '<div class="text-center" style="width:130px;">'.$row['TIME_DIFF'].'</div>';
      $nestedData[] = '<div style="width:100px;">'.$row['MPN'].'</div>';
      $nestedData[] = $row['CONDITION_NAME'];


$nestedData[] ="<a href='".base_url()."catalogueToCash/c_purchasing/fesibility_index/".$row['LZ_BD_CATA_ID']."' target='_blank'>". number_format((float)@$row['FESIBILITY_INDEX'],2,'.',',').' %'."</a>";
      
        /////// COMPONENT ITEMS /////////
      //$SALE_PRICE =$row['SALE_PRICE'];
      $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px; font-weight:700; width:100px;">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>';        /// ACTIVE PRICE
      $nestedData[] ='<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['AVERAGE_PRICE'],2,'.',',').'</div>';       ///// SOLD AVG
      $nestedData[] = '<div class="pull-right fetch-data" style="width:90px;">$ '. number_format((float)@$row['LIST_SOLD'],2,'.',',').'</div>';    /// LIST SOLD


      $nestedData[] ='<div class="pull-right" style="color:blue; font-size:17px; font-weight:700; width:60px;">'. number_format((float)@$row['QTY_SOLD'],0,'.',',').'</div>';  /// /QTY_SOLD
     
      $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['KIT_SELLING'],2,'.',',').'</div>';   /// AMOUNT

      $nestedData[] = '<div class="pull-right" style="color:red; font-size:17px;  font-weight:700; width:90px;">$ '. number_format((float)@$row['P'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right" style="width:90px;">'. number_format((float)@$row['KIT_PERCENT'],2,'.',',').' %</div>';

      //////////////////////////////////

      /////// ASSEMBLY ITEMS /////////
          /// SELLING
      $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['KIT_LIST'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['EST_PRICE'],2,'.',',').'</div>';    /// KIT
      $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['ASSSEMBLY_SELLING'],2,'.',',').'</div>';   /// SELLING
      $nestedData[] = '<div class="pull-right" style="width:90px;">$ '. number_format((float)@$row['ASSEM_PROFIT_$'],2,'.',',').'</div>';    /// %2
      $nestedData[] = '<div class="pull-right" style="width:90px;">'. number_format((float)@$row['ASSEMBLY_PROFIT_PERC'],2,'.',',').' %</div>';   /// AMOUNT CALULATION PENDING
          /// %1


     

      $nestedData[] = ''; ///status
      $nestedData[] = ''; //// bid status
      $nestedData[] = ''; ///// bid offer

      $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
      $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
      $category_id  =     $row['CATEGORY_ID'];
      
      $catalogue_mt_id  =     $row['CATALOGUE_MT_ID'];

      if(empty($lz_estimate_id)){
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div style="width: 150px;"><div class="form-group pull-left"><a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/copy_estimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Copy Estimate">Copy</a> </div><div class="form-group pull-left" style="margin-left:12px;"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a class="btn btn-success btn-sm updateEst" href="'.base_url()."catalogueToCash/c_purchasing/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> </div>';
      }
      $ct_tracking_no = $row['TRACKING_NO'];
      

      $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.@$ct_tracking_no.'" style="width:200px;"> </div>'; //// tracking no input field 

      $cost_price = $row['COST_PRICE'];
      if(empty($row['TRACKING_NO'])){
        $nestedData[] ='<div style="width: 240px;"><div class="form-group pull-left"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price col-sm-3 " value="'.$cost_price.'" style="width:100px;"></div> <div class="form-group pull-left" style="margin-left:12px;"><button type="button" title="Save MPN Data"  class="btn btn-primary btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">save</button> </div> </div>';
         }else if(!empty($row['TRACKING_NO']) && empty($row['SELLER_DESCRIPTION'])){
       $nestedData[] = '<div style="width: 260px;" ><div class="form-group pull-left"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price " value="'.$cost_price.'" style="width:100px;"></div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="Update MPN Data"  class="btn btn-success btn-xs update_mpn_data " id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">update</button></div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;" >Seller Desc</button></div> </div>';
      }else if(!empty($row['TRACKING_NO']) && !empty($row['SELLER_DESCRIPTION'])){

        $nestedData[] = '<div style="width: 260px;" ><div class="form-group pull-left"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price " value="'.$cost_price.'" style="width:100px;"></div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="Update MPN Data"  class="btn btn-success btn-xs update_mpn_data " id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">update</button></div> <div class="form-group pull-left" style="margin-left:12px;"> <button type="button" title="eBay Seller Description" class="btn btn-link btn-xs seller " id="seller_desc'.$i.'" style="font-weight: 700; font-size: 14px;color:green !important;" >Seller Desc</button></div> </div>';
      }
        //// cost price input field 26
      $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
      $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
      $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
      $nestedData[] = $row['TOTAL_1']; //// TOTAL

      $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
      $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
      $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
      $nestedData[] = $row['TOTAL_1']; //// TOTAL
      $nestedData[] = $row['LEN'];

              
    $data[] = $nestedData;        

     
    $i++;
    } //// end main foreach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }
//////////////////////////////////////////////
   public function loadMpnWisePurchasing() {
    $requestData = $_REQUEST;
      $category_id = $this->uri->segment(4);
      $catalogue_mt_id = $this->uri->segment(5);
    $columns = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'MPN',
      2 =>'TIME_DIFF',
      3 =>'TITLE',
      4 =>'SELLER_ID',
      5 =>'FEEDBACK_SCORE',
      6 =>'LISTING_TYPE',
      7 =>'CONDITION_NAME',
      8 =>'AVERAGE_PRICE',
      9 =>'SALE_PRICE',
      10 =>'COST_PRICE',
      11 =>'EST_PRICE',
      12 => 'EST_EBAY_FEE',
      13 => 'EST_PAYPAL_FEE',
      14 => 'EST_SHIP_FEE',
      15 => 'TOTAL',
      16 => 'AMOUNT'
    );
    $sql = "SELECT BD.FLAG_ID,BD.LZ_BD_CATA_ID, AV.AVG_PRICE AVERAGE_PRICE, bd.catalogue_mt_id, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, nvl(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, nvl(T.COST_PRICE, 0) COST_PRICE,nvl(AV.AVG_PRICE  - bd.sale_price ,0) LIST_SOLD , nvl(DET.EST_PRICE, 0) EST_PRICE, nvl(DET.EST_EBAY_FEE, 0) EST_EBAY_FEE, nvl(DET.EST_PAYPAL_FEE, 0) EST_PAYPAL_FEE, nvl(DET.EST_SHIP_FEE, 0) EST_SHIP_FEE, ROUND( NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + DET.EST_SHIP_FEE, 0),2) TOTAL, ROUND( NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + 3.25, 0),2) TOTAL_1, ROUND( nvl(DET.EST_PRICE, 0)-(BD.SALE_PRICE +  NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + DET.EST_SHIP_FEE, 0) ),2)AMOUNT, AVG_PRICE - ((AVG_PRICE * 30) / 100) VALID_PRICE, ROUND( NVL(DECODE(DET.EST_PRICE, 0, 0, EST_PRICE - BD.SALE_PRICE + EST_SHIP_FEE + EST_EBAY_FEE + EST_PAYPAL_FEE / DET.EST_PRICE * 100), 0), 2) PERCENT_1 FROM all_active_data_view BD, mpn_avg_price av, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id, de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee) est_ebay_fee, sum(de.paypal_fee) est_paypal_fee, sum(de.shipping_fee) est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) and t.lz_estimate_id = det.id(+) and BD.VERIFIED = 1 and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.FLAG_ID <> 20 AND BD.CATEGORY_ID = $category_id  and BD.CATALOGUE_MT_ID = $catalogue_mt_id";
     
        //var_dump($requestData['search']['value']); exit;
  
        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
      
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
    
        }
      }

    $query   = $this->db2->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    // when there is no search parameter then total number rows = total number filtered rows. 
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG")->result_array();
   /* echo "<pre>";
    print_r($flags);
    exit;*/

    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank'>".@$row['EBAY_ID']."</a>";
      $nestedData[] = $row['TITLE'];
      $flag_id = $row['FLAG_ID']; 
      $kit_flag= $this->session->userdata("ctc_kit_flag"); 
      /*echo "<pre>";
      print_r($flags);
      exit;*/
      $options=[];
      $k = 0;
      foreach ($flags as $flag) {
        if ($flag_id == $flag['FLAG_ID']) {
          $selected = "selected";
        }else {
          $selected = "";
        }
       $options[] .='<option data-thumbnail="'.base_url().$flag['FLAG_ICON'].'" value="'.@$flag['FLAG_ID'].'"'.' '.@$selected.'>'.@$flag['FLAG_NAME'].'</option>';
       $k++;
      }
      
      $comma_separated = implode(" ", $options);
      //var_dump($options); exit;
      $nestedData[] ='<select class="form-control kit_flag " name="kit_flag" cid="kit_flag_'.$i.'" catid = "'.$row['CATEGORY_ID'].'" id = "'.$row['LZ_BD_CATA_ID'].'" style="width: 150px;" > <option value="0">--------select--------- </option>'.$comma_separated.'</select>';
      
      $nestedData[] = $row['SELLER_ID'];
      //var_dump($row['FLAG_ID']);
      $nestedData[] = $row['FEEDBACK_SCORE'];
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = $row['TIME_DIFF'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['CONDITION_NAME'];
      $nestedData[] = $row['SALE_PRICE'];       /// ACTIVE PRICE
      $nestedData[] = $row['AVERAGE_PRICE'];      ///// SOLD AVG
      $nestedData[] = $row['LIST_SOLD'];    /// LIST SOLD

      /////// ASSEMBLY ITEMS /////////

      $nestedData[] = $row['EST_PRICE'];    /// KIT
      $nestedData[] = $row['EST_PRICE'];    /// SELLING
      $nestedData[] = $row['AMOUNT'];    /// AMOUNT
      $nestedData[] = $row['PERCENT_1'];    /// %1

      /////// COMPONENT ITEMS /////////
      $nestedData[] = $row['EST_PRICE'];    /// SELLING
      $nestedData[] = $row['AMOUNT'];    /// AMOUNT
      $nestedData[] = $row['PERCENT_1'];    /// %2

      //////////////////////////////////

      $nestedData[] = ''; ///status
      $nestedData[] = ''; //// bid status
      $nestedData[] = ''; ///// bid offer

      $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
      $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
      $category_id  =     $row['CATEGORY_ID'];
      $catalogue_mt_id  =     $row['CATALOGUE_MT_ID'];
      if(empty($lz_estimate_id)){
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a class="btn btn-success btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> ';
      }
      $ct_tracking_no = $row['TRACKING_NO'];
      

      $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.@$ct_tracking_no.'" style="width:200px;"> </div>'; //// tracking no input field 

      $cost_price = $row['COST_PRICE'];
      if(empty($row['TRACKING_NO'])){
        $nestedData[] ='<div style="width: 160px;">  <input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Save MPN Data"  class="btn btn-success btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">Save</button> </div></div>';
         }else {
       $nestedData[] = '<div style="width: 160px;"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Update MPN Data"  class="btn btn-primary btn-xs update_mpn_data" id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">Update</button> </div> </div>';
      }
        //// cost price input field 26
      $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
      $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
      $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
      $nestedData[] = $row['TOTAL_1']; //// TOTAL

      $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
      $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
      $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
      $nestedData[] = $row['TOTAL_1']; //// TOTAL

              
    $data[] = $nestedData;        

     
    $i++;
    } //// end main foreach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }
/////////////////////////////////////////////

    public function load_search_mpn_wise_purchsing() {
       $category_id = $this->uri->segment(4);
       $catalogue_mt_id = $this->uri->segment(5);
       $requestData = $_REQUEST;
      //var_dump($requestData); exit; 

        $Search_List_type = $this->session->userdata('Search_List_type');
        $Search_condition = $this->session->userdata('Search_condition');
        $Search_seller = $this->session->userdata('Search_seller');
        $seller_id = trim(str_replace("'","''", $Search_seller));
        $seller_id = strtoupper($Search_seller);
        
        $keyword = $this->session->userdata('serchkeyword');
        $str = explode(' ', $keyword);
        $purch_mpn = $this->session->userdata('purch_mpn');
        $purch_mpn = trim(str_replace("'","''", $purch_mpn));
        $purch_mpn = strtoupper($purch_mpn);

         //$Search_category = $this->session->userdata('Search_category');
         $fed_one = $this->session->userdata('fed_one');
         $fed_two = $this->session->userdata('fed_two');
         $perc_one = $this->session->userdata('perc_one');
         $perc_two = $this->session->userdata('perc_two');
         $title_sort = $this->session->userdata('title_sort');
         $time_sort = $this->session->userdata('time_sort');

        $check_List_type = $Search_List_type[0];
        $check_val = $Search_condition[0];
       // $check_mpn = $purch_mpn[0];
        //$check_categ = $Search_category[0];
        //var_dump($Search_List_type); exit;
     //var_dump($this->session->userdata('multi_data'));exit;
      
    /*  if($check_categ != 'all' && $check_categ != null){
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
    }*/
  

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
    $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'MPN',
      2 =>'TIME_DIFF',
      3 =>'TITLE',
      4 =>'SELLER_ID',
      5 =>'FEEDBACK_SCORE',
      6 =>'LISTING_TYPE',
      7 =>'CONDITION_NAME',
      8 =>'AVERAGE_PRICE',
      9 =>'SALE_PRICE',
      10 =>'COST_PRICE',
      11 =>'EST_PRICE',
      12 => 'EST_EBAY_FEE',
      13 => 'EST_PAYPAL_FEE',
      14 => 'EST_SHIP_FEE',
      15 => 'TOTAL',
      16 => 'AMOUNT'
      
    );
    $sql = "SELECT * FROM( SELECT BD.FLAG_ID, BD.LZ_BD_CATA_ID, AV.AVG_PRICE AVERAGE_PRICE, bd.catalogue_mt_id, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, nvl(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, nvl(AV.AVG_PRICE  - bd.sale_price ,0) LIST_SOLD , nvl(T.COST_PRICE, 0) COST_PRICE, nvl(DET.EST_PRICE, 0) EST_PRICE, nvl(DET.EST_EBAY_FEE, 0) EST_EBAY_FEE, nvl(DET.EST_PAYPAL_FEE, 0) EST_PAYPAL_FEE, nvl(DET.EST_SHIP_FEE, 0) EST_SHIP_FEE, ROUND( NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + DET.EST_SHIP_FEE, 0),2) TOTAL, ROUND( NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + 3.25, 0),2) TOTAL_1, ROUND( nvl(DET.EST_PRICE, 0)-(BD.SALE_PRICE +  NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + DET.EST_SHIP_FEE, 0) ),2) AMOUNT, AVG_PRICE - ((AVG_PRICE * 30) / 100) VALID_PRICE, ROUND( NVL(DECODE(DET.EST_PRICE, 0, 0, EST_PRICE - BD.SALE_PRICE + EST_SHIP_FEE + EST_EBAY_FEE + EST_PAYPAL_FEE / DET.EST_PRICE * 100), 0), 2) PERCENT_1 FROM all_active_data_view BD, mpn_avg_price av, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id, de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee) est_ebay_fee, sum(de.paypal_fee) est_paypal_fee, sum(de.shipping_fee) est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) and t.lz_estimate_id = det.id(+) and BD.VERIFIED = 1 and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.FLAG_ID <> 20 and bd.CATALOGUE_MT_ID = $catalogue_mt_id AND  BD.CATEGORY_ID = $category_id";
     /* if($check_categ != 'all' && $check_categ != null)
        {
          $sql.=" AND  BD.category_id in($categ_exp)";
        }else{
          $sql.=" AND  BD.category_id = $category_id";
        }
*/
      if(!empty($seller_id)){
      $sql.=" and UPPER(seller_id) LIKE '%$seller_id%' ";

      }

      if(!empty($purch_mpn)){
      $sql.=" and UPPER(m.mpn) LIKE '%$purch_mpn%' ";

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

          
            if($check_val != 'all'  && $check_val != null)
            {
              $sql.=" AND  BD.CONDITION_ID in($cond_exp)";
            }
            // if($check_seller != 'all' && $check_seller != null){
            //   $sql.=" AND UPPER(seller_id) in($seller_exp)";
            // }
            if($check_List_type != 'all' && $check_List_type != null){
               $sql.=" AND UPPER(BD.listing_type) in ($list_exp) ";
            }            

            if(!empty($fed_one) && !empty($fed_two)){
            $sql.=" and FEEDBACK_SCORE between $fed_one and $fed_two";
            }
            if(!empty($time_sort)){
              
              $sql.=" AND BD.start_TIME > SYSDATE - $time_sort";
               
            }
           
            if(!empty($title_sort)){
              if($title_sort == 1){
            $sql.=" ORDER BY LENGTH(title)  asc";

            }
            if($title_sort == 2){
            $sql.=" ORDER BY LENGTH(title)  desc";

            }

            }
            $sql.=" ) inner_table";
            if(!empty($perc_one) && !empty($perc_two)){
            $sql.=" WHERE VALID_PRICE between $perc_one and $perc_two";
            }

  
        if( !empty($requestData['search']['value']) ) {   
            // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
           $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
            $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
        }
      }

    $query   = $this->db2->query($sql); 
    //var_dump($query); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    // when there is no search parameter then total number rows = total number filtered rows. 
    if(empty($title_sort)){
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
  }
    $sql = "SELECT  * FROM (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
    $flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG")->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank'>".@$row['EBAY_ID']."</a>";
      $nestedData[] = $row['TITLE'];
      $flag_id = $row['FLAG_ID']; 
      $kit_flag= $this->session->userdata("ctc_kit_flag"); 
      /*echo "<pre>";
      print_r($flags);
      exit;*/
      $options=[];
      $k = 0;
      foreach ($flags as $flag) {
        if ($flag_id == $flag['FLAG_ID']) {
          $selected = "selected";
        }else {
          $selected = "";
        }
       $options[] .='<option data-thumbnail="'.base_url().$flag['FLAG_ICON'].'" value="'.@$flag['FLAG_ID'].'"'.' '.@$selected.'>'.@$flag['FLAG_NAME'].'</option>';
       $k++;
      }
      
      $comma_separated = implode(" ", $options);
      //var_dump($options); exit;
      $nestedData[] ='<select class="form-control kit_flag " name="kit_flag" cid="kit_flag_'.$i.'" catid = "'.$row['CATEGORY_ID'].'" id = "'.$row['LZ_BD_CATA_ID'].'" style="width: 150px;" > <option value="0">--------select--------- </option>'.$comma_separated.'</select>';

      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE'];
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = $row['TIME_DIFF'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['CONDITION_NAME'];
      $nestedData[] = $row['SALE_PRICE'];       /// ACTIVE PRICE
      $nestedData[] = $row['AVERAGE_PRICE'];      ///// SOLD AVG
      $nestedData[] = $row['LIST_SOLD'];    /// LIST SOLD

      /////// ASSEMBLY ITEMS /////////

      $nestedData[] = $row['EST_PRICE'];    /// KIT
      $nestedData[] = $row['EST_PRICE'];    /// SELLING
      $nestedData[] = $row['AMOUNT'];    /// AMOUNT
      $nestedData[] = $row['PERCENT_1'];    /// %1

      /////// COMPONENT ITEMS /////////
      $nestedData[] = $row['EST_PRICE'];    /// SELLING
      $nestedData[] = $row['AMOUNT'];    /// AMOUNT
      $nestedData[] = $row['PERCENT_1'];    /// %2

      //////////////////////////////////

      $nestedData[] = ''; ///status
      $nestedData[] = ''; //// bid status
      $nestedData[] = ''; ///// bid offer

      $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
      $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
      $category_id  =     $row['CATEGORY_ID'];
      $catalogue_mt_id  =     $row['CATALOGUE_MT_ID'];
      if(empty($lz_estimate_id)){
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm" href="'.base_url()."catalogueToCash/c_purchasing/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> ';
      }
      $ct_tracking_no = $row['TRACKING_NO'];
      

      $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.@$ct_tracking_no.'" style="width:200px;"> </div>'; //// tracking no input field 

      $cost_price = $row['COST_PRICE'];
      if(empty($row['TRACKING_NO'])){
        $nestedData[] ='<div style="width: 160px;">  <input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Save MPN Data"  class="btn btn-success btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">Save</button> </div></div>';
         }else {
       $nestedData[] = '<div style="width: 160px;"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Update MPN Data"  class="btn btn-primary btn-xs update_mpn_data" id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">Update</button> </div> </div>';
      }
        //// cost price input field 26
      $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
      $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
      $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
      $nestedData[] = $row['TOTAL_1']; //// TOTAL

      $nestedData[] = $row['EST_EBAY_FEE']; //// EST_EBAY_FEE
      $nestedData[] = $row['EST_PAYPAL_FEE']; //// EST_PAYPAL_FEE
      $nestedData[] = $row['EST_SHIP_FEE']; //// EST_SHIP_FEE
      $nestedData[] = $row['TOTAL_1']; //// TOTAL

              
    $data[] = $nestedData;        

     
    $i++;
    } //// end main foreach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }
  /*=====================================
 =            Reset Filters            =
  =====================================*/
 public function getCategories(){
    $sql = "SELECT DISTINCT D.CATEGORY_ID, BD.CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD WHERE  D.CATEGORY_ID = BD.CATEGORY_ID" ;
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    return $query;
  }
   public function resetUnVerifyDropdown(){

     $cat_id = $this->input->post('cat_id');

     $this->session->unset_userdata('Search_category');
     // var_dump($this->session->userdata('Search_category')); exit;

     $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      // $seller =$this->db2->query("SELECT SELLER_ID, SELLER_ID || ' (' || COUNT(SELLER_ID) || ')' SELLER_NAME FROM all_active_data_view BD, LZ_CATALOGUE_MT M, mpn_avg_price av WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.SALE_TIME > SYSDATE - 1 and BD.VERIFIED = 1 and m.mpn is not null GROUP BY SELLER_ID") ->result_array();

    $flag_id = "SELECT FLAG_ID ,FLAG_NAME FROM LZ_BD_PURCHASING_FLAG ORDER BY FLAG_ID";
    $flag_id = $this->db2->query($flag_id)->result_array();


    $cattegory = "SELECT distinct D.CATEGORY_ID, K.CATEGORY_NAME || '-' || D.CATEGORY_ID || ' (' || count_mpn.mpn ||')' CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY K,(select category_id cat_id ,count(mpn) mpn,category_id from lz_catalogue_mt group by category_id) count_mpn WHERE D.CATEGORY_ID = K.CATEGORY_ID and K.CATEGORY_ID = count_mpn.cat_id and d.lz_bd_group_id = 1";

    // $cate_name = $this->db2->query(" SELECT CATEGORY_NAME || '-' || CATEGORY_ID  CATEGORY_NAME from LZ_BD_CATEGORY where CATEGORY_ID = $cat_id group by category_name,category_id")->result_array();

    // ,'cate_name' => $cate_name

    $cattegory = $this->db2->query($cattegory);
    $cattegory = $cattegory->result_array();

      return array('list_types' => $list_types, 'conditions' => $conditions , 'cattegory' => $cattegory,'flag_id' => $flag_id);
  }
 
 /*=====  End of Reset Filters  ======*/

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






  public function verifympnDetail($cat_id,$catalogue_id){
    //$cat_id = $this->uri->segment(4);

    // var_dump($catalogue_id);
    // exit;
    $sess_data = array("ctListingType"=>"All", "ctListing_condition"=>"All");
    $this->session->set_userdata($sess_data);

    $mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_111422 BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = 24 AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) GROUP BY BD.CATALOGUE_MT_ID,C.MPN");

    $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AVERAGE_PRICE, BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID, M.CATALOGUE_MT_ID, BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE, det.est_price, det.est_ebay_fee, det.est_paypal_fee, det.est_ship_fee FROM LZ_BD_ACTIVE_DATA_111422 BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (select de.lz_bd_estimate_id id , de.lz_bd_estimate_id, sum(de.est_sell_price) est_price, sum(de.ebay_fee)       est_ebay_fee, sum(de.paypal_fee)         est_paypal_fee, sum(de.shipping_fee)        est_ship_fee from lz_bd_estimate_det de group by de.lz_bd_estimate_id ) det WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND  BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID (+) and t.lz_estimate_id = det.id(+) AND BD.CATALOGUE_MT_ID = 24  AND BD.VERIFIED =1 AND BD.SALE_TIME > SYSDATE AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) ORDER BY TIME_DIFF DESC"); 
    $detail = $det_qry->result_array();
    $mpn = $mpn->result_array();
    // var_dump($detail);exit;

      $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      return array('detail'=>$detail, 'mpn' => $mpn,'list_types' => $list_types, 'conditions' => $conditions);
  }



  public function kitComponents(){
    $cat_id           = $this->uri->segment(4);
    $catalogue_mt_id  = $this->uri->segment(5);
    $lz_bd_cata_id    = $this->uri->segment(6) ;

    $sess_data = array("catalogue_List_type"=>"All", "catalogue_condition"=>"All");
    $this->session->set_userdata($sess_data);

    //$results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.QTY, M.PART_CATLG_MT_ID, O.OBJECT_NAME, GET_AVG_PRICE(MT.CATEGORY_ID,M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID AND O.OBJECT_ID = MT.OBJECT_ID AND M.CATALOGUE_MT_ID =$catalogue_mt_id");
    $results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, C.MPN_DESCRIPTION,  C.CATEGORY_ID, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID  AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION all SELECT MP.MPN_KIT_MT_ID, MP.MPN_KIT_MT_ID, 1, MP.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, C.CATEGORY_ID, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID and mp.catalogue_mt_id NOT IN (SELECT T.PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id) "); 


    /// catalogue_mt_id = 105260
     /*$distinct_object_count = $this->db2->query("SELECT DISTINCT * FROM (SELECT distinct trim(upper(regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')))  OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = 105356 AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID group by O.OBJECT_NAME UNION ALL SELECT distinct trim(upper(regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')))  OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = 105356) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID group by O.OBJECT_NAME) ORDER BY OBJECT_NAME ASC");*/

     $distinct_object_count = $this->db2->query("SELECT DISTINCT OBJECT_NAME, COLOR  FROM (SELECT DISTINCT * FROM (SELECT * FROM (SELECT OBJECT_NAME, COLOR FROM (SELECT * FROM (SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'GREY-COLOR' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY OBJECT_NAME UNION SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'GREY-COLOR' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID GROUP BY O.OBJECT_NAME) ORDER BY COLOR DESC) INTERSECT SELECT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(COMPONENT_DESC, '&', 'AND'), '/', ' OR '))) COMPONENT_DESC, 'GREY-COLOR' COLOR FROM LZ_BD_STD_COMP_KIT GROUP BY COMPONENT_DESC) UNION (SELECT OBJECT_NAME, COLOR FROM (SELECT * FROM (SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'LIGHT-GREY' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY OBJECT_NAME UNION SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'LIGHT-GREY' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID GROUP BY O.OBJECT_NAME) ORDER BY COLOR DESC) MINUS SELECT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(COMPONENT_DESC, '&', 'AND'), '/', ' OR '))) COMPONENT_DESC, 'LIGHT-GREY' COLOR FROM LZ_BD_STD_COMP_KIT GROUP BY COMPONENT_DESC) UNION (SELECT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(COMPONENT_DESC, '&', 'AND'), '/', ' OR '))) COMPONENT_DESC, 'COLOR-RED' COLOR FROM LZ_BD_STD_COMP_KIT GROUP BY COMPONENT_DESC MINUS SELECT * FROM (SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'COLOR-RED' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY OBJECT_NAME UNION SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'COLOR-RED' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID GROUP BY O.OBJECT_NAME) )) ORDER BY COLOR DESC) ORDER BY COLOR, OBJECT_NAME ASC");
    $object_list = $distinct_object_count->result_array(); 

    $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL,BD.TITLE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND BD.LZ_BD_CATA_ID =$lz_bd_cata_id"); 
    $detail = $det_qry->result_array();

    $mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN"); 
    $mpn = $mpn->result_array();

    $copies = $this->db2->query("SELECT DISTINCT EE.EBAY_ID, MT.CATALOGUE_MT_ID, MT.ESTIMATE_DESC, MT.LZ_BD_CATAG_ID, (SELECT COUNT(DE.LZ_BD_ESTIMATE_ID) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = MT.LZ_BD_ESTIMATE_ID GROUP BY DE.LZ_BD_ESTIMATE_ID) COM_COUNT, MT.EST_DATE_TIME, MT.LZ_BD_ESTIMATE_ID, MT.CATALOGUE_MT_ID, EE.CATEGORY_ID, E.USER_NAME FROM LZ_BD_ESTIMATE_MT MT, LZ_BD_ACTIVE_DATA_$cat_id EE, EMPLOYEE_MT E WHERE MT.LZ_BD_CATAG_ID = EE.LZ_BD_CATA_ID AND MT.CATALOGUE_MT_ID = EE.CATALOGUE_MT_ID AND MT.ENTERED_BY = E.EMPLOYEE_ID AND MT.CATALOGUE_MT_ID = $catalogue_mt_id ORDER BY MT.LZ_BD_ESTIMATE_ID DESC ");
    $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();
    $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    $cat_groups = $this->db2->query("SELECT M.LZ_BD_GROUP_ID, M.GROUP_NAME FROM LZ_BD_CAT_GROUP_MT M")->result_array();
    $estimate_status = $this->db2->query(" SELECT F.FLAG_ID ,F.FLAG_NAME FROM LZ_BD_PURCHASING_FLAG F WHERE F.FLAG_ID IN (34,35,20) ")->result_array();



  return array("results"=>$results, "detail"=>$detail, "mpn"=>$mpn, "list_types"=>$list_types, "conditions"=>$conditions, "object_list"=>$object_list, "copies"=>$copies, "cat_groups"=>$cat_groups, "estimate_status"=>$estimate_status);

  }
  public function updateEstimate(){
      $cat_id = $this->uri->segment(4); 
      $catalogue_mt_id = $this->uri->segment(5);
      $lz_bd_cata_id = $this->uri->segment(6) ;

      $sess_data = array("catalogue_List_type"=>"All", "catalogue_condition"=>"All");
      $this->session->set_userdata($sess_data);

      // old query
       $results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, M.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID 
        AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION all SELECT MP.MPN_KIT_MT_ID, MP.MPN_KIT_MT_ID, 1, MP.CATALOGUE_MT_ID, C.MPN, MP.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID 
         AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID and mp.catalogue_mt_id NOT IN (SELECT T.PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id)");

     $distinct_object_count = $this->db2->query("SELECT DISTINCT OBJECT_NAME, COLOR  FROM (SELECT DISTINCT * FROM (SELECT * FROM (SELECT OBJECT_NAME, COLOR FROM (SELECT * FROM (SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'GREY-COLOR' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY OBJECT_NAME UNION SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'GREY-COLOR' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID GROUP BY O.OBJECT_NAME) ORDER BY COLOR DESC) INTERSECT SELECT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(COMPONENT_DESC, '&', 'AND'), '/', ' OR '))) COMPONENT_DESC, 'GREY-COLOR' COLOR FROM LZ_BD_STD_COMP_KIT GROUP BY COMPONENT_DESC) UNION (SELECT OBJECT_NAME, COLOR FROM (SELECT * FROM (SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'LIGHT-GREY' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY OBJECT_NAME UNION SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'LIGHT-GREY' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID GROUP BY O.OBJECT_NAME) ORDER BY COLOR DESC) MINUS SELECT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(COMPONENT_DESC, '&', 'AND'), '/', ' OR '))) COMPONENT_DESC, 'LIGHT-GREY' COLOR FROM LZ_BD_STD_COMP_KIT GROUP BY COMPONENT_DESC) UNION (SELECT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(COMPONENT_DESC, '&', 'AND'), '/', ' OR '))) COMPONENT_DESC, 'COLOR-RED' COLOR FROM LZ_BD_STD_COMP_KIT GROUP BY COMPONENT_DESC MINUS SELECT * FROM (SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'COLOR-RED' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY OBJECT_NAME UNION SELECT DISTINCT TRIM(UPPER(REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR '))) OBJECT_NAME, 'COLOR-RED' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID GROUP BY O.OBJECT_NAME) )) ORDER BY COLOR DESC) ORDER BY COLOR ASC, OBJECT_NAME ");
    $object_list = $distinct_object_count->result_array(); 

  /*  $standard_kit = $this->db2->query("SELECT DISTINCT * FROM (select * from (select OBJECT_NAME,   COLOR from (SELECT * FROM (SELECT distinct trim(upper(regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')))  OBJECT_NAME, 'grey-color' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID group by OBJECT_NAME UNION ALL SELECT distinct trim(upper(regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')))  OBJECT_NAME, 'grey-color' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID group by O.OBJECT_NAME) ORDER BY  OBJECT_NAME ASC) intersect select trim(upper(regexp_replace  (regexp_replace  (component_desc,'&','AND'),'/',' OR ')))  component_desc, 'grey-color' COLOR  from lz_bd_std_comp_kit group by component_desc) UNION ALL (select OBJECT_NAME, COLOR from (SELECT * FROM (SELECT distinct trim(upper(regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')))  OBJECT_NAME ,'light-grey' COLOR FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID group by OBJECT_NAME UNION ALL SELECT distinct trim(upper(regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')))  OBJECT_NAME, 'light-grey' COLOR FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID group by O.OBJECT_NAME) ORDER BY  OBJECT_NAME ASC) MINUS select trim(upper(regexp_replace  (regexp_replace  (component_desc,'&','AND'),'/',' OR ')))  component_desc, 'light-grey' COLOR  from lz_bd_std_comp_kit group by component_desc) ) ORDER BY OBJECT_NAME ASC ")->result_array(); */      

      $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL,BD.TITLE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND BD.LZ_BD_CATA_ID =$lz_bd_cata_id"); 
      $detail = $det_qry->result_array();
      

      $components = $this->db2->query("SELECT M.LZ_BD_ESTIMATE_ID, D.TECH_COND_ID, D.MPN_DESCRIPTION,DECODE(D.TECH_COND_ID, 1000, 'NEW', 1500, 'NEW OTHER (SEE DETAILS)', 2000, 'MANUFACTURER REFURBISHED', 2500, 'SELLER REFURBISHED', 3000, 'USED', 7000, 'FOR PARTS OR NOT WORKING') COND_NAME ,M.LZ_BD_CATAG_ID, D.LZ_ESTIMATE_DET_ID, D.MPN_KIT_MT_ID, D.PART_CATLG_MT_ID,D.QTY, D.EST_SELL_PRICE, D.PAYPAL_FEE, D.EBAY_FEE, D.SHIPPING_FEE, D.SOLD_PRICE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ESTIMATE_DET D WHERE M.LZ_BD_ESTIMATE_ID = D. LZ_BD_ESTIMATE_ID AND M.LZ_BD_CATAG_ID = $lz_bd_cata_id ORDER BY MPN_KIT_MT_ID ASC ");

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT ORDER BY ID ASC")->result_array();
        // echo "<pre>";
        // print_r($components->result_array());
        // exit;
      $estimate_status = $this->db2->query(" SELECT F.FLAG_ID ,F.FLAG_NAME FROM LZ_BD_PURCHASING_FLAG F WHERE F.FLAG_ID IN (34,35,20) ")->result_array();

      $get_status = $this->db2->query("SELECT K.EST_STATUS EST_STATUS FROM LZ_BD_ESTIMATE_MT  K WHERE K.LZ_BD_CATAG_ID = $lz_bd_cata_id  ")->result_array();

        
        return array("results"=>$results, "detail"=>$detail, "components"=>$components, "conditions"=>$conditions, "object_list"=>$object_list, "estimate_status"=>$estimate_status, "get_status"=>$get_status);
   }
  public function getCatalogueSearch($cat_id, $catalogue_mt_id){

    $catalogue_List_type          = strtoupper($this->input->post('catalogue_List_type'));
    $catalogue_condition            = trim($this->input->post('catalogue_condition'));
    //var_dump($catalogue_List_type, $catalogue_condition); exit;
    
    $sess_data            = array("catalogue_List_type"=>$catalogue_List_type, "catalogue_condition"=>$catalogue_condition);
    $this->session->set_userdata($sess_data);
    if (!empty($this->session->userdata('catalogue_List_type')) && !empty($this->session->userdata('catalogue_condition'))) {
      $listingType = $this->session->userdata('catalogue_List_type');
      $condition   = $this->session->userdata('catalogue_condition');
    }

    //$results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.QTY, M.PART_CATLG_MT_ID, O.OBJECT_NAME, GET_AVG_PRICE(MT.CATEGORY_ID,M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID AND O.OBJECT_ID = MT.OBJECT_ID AND M.CATALOGUE_MT_ID =$catalogue_mt_id");
    $results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.QTY, M.PART_CATLG_MT_ID, O.OBJECT_NAME, GET_AVG_PRICE(MT.CATEGORY_ID, M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT, LZ_BD_OBJECTS_MT O,(SELECT MT.CATEGORY_ID, M.PART_CATLG_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id and M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID ) part_id WHERE M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID and part_id.part_catlg_mt_id=  M.PART_CATLG_MT_ID AND O.OBJECT_ID = MT.OBJECT_ID AND M.CATALOGUE_MT_ID = $catalogue_mt_id");
    //$results = array();
    //$det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, REC.AVERAGE_PRICE, BD.SALE_PRICE - REC.AVERAGE_PRICE AS PRICE_AFTERLIST, T.TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (SELECT C.CATALOGUE_MT_ID AS ID, ROUND(AVG(C.SALE_PRICE), 2) AS AVERAGE_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id C WHERE C.CATALOGUE_MT_ID IS NOT NULL GROUP BY C.CATALOGUE_MT_ID) REC WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND M.CATALOGUE_MT_ID = REC.ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id");
    
    $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL)"); 
    $detail = $det_qry->result_array();

    /*$mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN");
    $mpn = $mpn->result_array();*/

    $mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) GROUP BY BD.CATALOGUE_MT_ID,C.MPN"); 
    $mpn = $mpn->result_array();

    $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();
    $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
    /*echo "<pre>";
      print_r($results->result_array());
      exit;*/
      return array("results"=>$results, "detail"=>$detail, "mpn"=>$mpn, "list_types"=>$list_types, "conditions"=>$conditions, "catalogue_List_type"=>$catalogue_List_type, "catalogue_condition"=>$catalogue_condition);

  }
  public function loadCatalogues($cat_id, $catalogue_id) {
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
    $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 =>'CONDITION_NAME',
      3 =>'SELLER_ID',
      4 =>'LISTING_TYPE',
      5 =>'SALE_PRICE',
      6 =>'START_TIME',
      7 =>'SALE_TIME',
      8 =>'FEEDBACK_SCORE'
    );
    $sql = "SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.SALE_TIME > SYSDATE AND BD.CATALOGUE_MT_ID = $catalogue_id AND BD.LZ_BD_CATA_ID NOT IN (SELECT LZ_BD_CATAG_ID FROM LZ_BD_ESTIMATE_MT ) AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) ORDER BY TIME_DIFF DESC"; 
    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    $sql = "SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_id AND BD.LZ_BD_CATA_ID NOT IN (SELECT LZ_BD_CATAG_ID FROM LZ_BD_ESTIMATE_MT ) AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) AND BD.SALE_TIME > SYSDATE ";
        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
        }
      }
      $sql.=" ORDER BY TIME_DIFF DESC";
    // when there is no search parameter then total number rows = total number filtered rows. 
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //$sql           = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM  ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
   $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
   //print_r($sql);
   //exit;
    //echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ="<div style='float:left;margin-right:8px;'><a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a> </div>";
      //$item_url = $row['ITEM_URL'];
      $ebay_id  = $row['EBAY_ID'];
    
      /*$nestedData[] = "<a href='<?php //echo $item_url; ?>' target='_blank'><?php echo $ebay_id; ?></a>";*/
     
      $nestedData[] = $row['EBAY_ID'];
      $lz_bd_cata_id = $row['LZ_BD_CATA_ID'];
      $nestedData[] ='<input type = "checkbox" name = "ctc_catalogue" class = "ctc_catalogue" value = "'.$lz_bd_cata_id.'">';
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE']; 

      /*$StoreInventory   = 'StoreInventory';
      $FixedPrice     = 'FixedPrice';
      $Auction      = 'Auction';
      $AuctionWithBIN   = 'AuctionWithBIN';

      $StoreInventorycolor = 'StoreInventorycolor';
      $FixedPricecolor = 'FixedPricecolor';
      $auctioncolor = 'auctioncolor';
      $AuctionwithBINcolor = 'AuctionwithBINcolor';*/

      $nestedData[] = $row['LISTING_TYPE'];;

      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = $row['CONDITION_NAME']; 
      $nestedData[] = $row['SALE_PRICE'];
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";

      $data[] = $nestedData;

    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
  public function searchCatalogue($cat_id, $catalogue_id) {
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
    $catalogue_List_type = $this->uri->segment(6);
    $catalogue_condition = $this->uri->segment(7);
    //var_dump($cat_id, $catalogue_id, $catalogue_List_type, $catalogue_condition); exit;
    $columns     = array(
      // datatable column index  => database column name
      0 =>'EBAY_ID',
      1 =>'TITLE',
      2 =>'CONDITION_NAME',
      3 =>'SELLER_ID',
      4 =>'LISTING_TYPE',
      5 =>'SALE_PRICE',
      6 =>'START_TIME',
      7 =>'SALE_TIME',
      8 =>'FEEDBACK_SCORE'
    );
    $sql = "SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.SALE_TIME > SYSDATE  AND BD.CATALOGUE_MT_ID = $catalogue_id AND BD.LZ_BD_CATA_ID NOT IN (SELECT LZ_BD_CATAG_ID FROM LZ_BD_ESTIMATE_MT )"; if(!empty($catalogue_List_type))
            {
              $sql.=" AND UPPER(BD.listing_type) LIKE '%$catalogue_List_type%'";
            }

            if(!empty($catalogue_condition))
            {
              $sql.=" AND  BD.CONDITION_ID =$catalogue_condition";
            } 

            $sql.=" AND SALE_TIME > SYSDATE ORDER BY TIME_DIFF DESC";

    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    $sql = "SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.SALE_TIME > SYSDATE AND BD.CATALOGUE_MT_ID = $catalogue_id AND BD.LZ_BD_CATA_ID NOT IN (SELECT LZ_BD_CATAG_ID FROM LZ_BD_ESTIMATE_MT )"; if(!empty($catalogue_List_type))
            {
              $sql.=" AND UPPER(BD.listing_type) LIKE '%$catalogue_List_type%'";
            }

            if(!empty($catalogue_condition))
            {
              $sql.=" AND  BD.CONDITION_ID =$catalogue_condition";
            } 
            
            $sql.=" AND SALE_TIME > SYSDATE ";

        if( !empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
           $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
           $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
           $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
           $sql.=" OR TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
           $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
           $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%' )";
        }
      }
      $sql.=" ORDER BY TIME_DIFF DESC";
    // when there is no search parameter then total number rows = total number filtered rows. 
    //$sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //$sql           = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM  ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
   $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
   //print_r($sql);
   //exit;
    //echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    foreach($query as $row ){ 
      $nestedData=array();

      $nestedData[] ="<div style='float:left;margin-right:8px;'><a title='Delete' id='".$row['LZ_BD_CATA_ID']."'  class='btn btn-danger btn-xs delResultRow'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> </a> </div>";
      //$item_url = $row['ITEM_URL'];
      $ebay_id  = $row['EBAY_ID'];
    
      /*$nestedData[] = "<a href='<?php //echo $item_url; ?>' target='_blank'><?php echo $ebay_id; ?></a>";*/
     
      $nestedData[] = $row['EBAY_ID'];
      $lz_bd_cata_id = $row['LZ_BD_CATA_ID'];
      $nestedData[] ='<input type = "checkbox" name = "ctc_catalogue" class = "ctc_catalogue"><input type = "hidden" name="catalogue_name" value = "<?php echo $lz_bd_cata_id; ?>" class= "catalogues" >';
      $nestedData[] = $row['TITLE'];
      $nestedData[] = $row['SELLER_ID'];
      $nestedData[] = $row['FEEDBACK_SCORE']; 

      /*$StoreInventory   = 'StoreInventory';
      $FixedPrice     = 'FixedPrice';
      $Auction      = 'Auction';
      $AuctionWithBIN   = 'AuctionWithBIN';

      $StoreInventorycolor = 'StoreInventorycolor';
      $FixedPricecolor = 'FixedPricecolor';
      $auctioncolor = 'auctioncolor';
      $AuctionwithBINcolor = 'AuctionwithBINcolor';*/

      $nestedData[] = $row['LISTING_TYPE'];;

      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = $row['CONDITION_NAME']; 
      $nestedData[] = $row['SALE_PRICE'];

      $nestedData[] = "";
      $nestedData[] = "";

      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";
      $nestedData[] = "";

      $nestedData[] = '';
      $nestedData[] = '';
      $nestedData[] = '';

      $data[] = $nestedData;

    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
   public function savekitComponents(){
    $cat_id=$this->input->post('cat_id');
    $catalogue_mt_id=$this->input->post('mpn_id');
     $es_status=$this->input->post('es_status');
     $discard_remarks=$this->input->post('discard_remarks');
    $dynamic_cata_id=$this->input->post('dynamic_cata_id');
    //var_dump($cat_id, $catalogue_mt_id, $dynamic_cata_id); exit;
    $partsCatalgid = $this->input->post('partsCatalgid');
    $kit_mt_ids = $this->input->post('kit_mt_ids');
    $compName=$this->input->post('compName');

    $compQty=$this->input->post('compQty');

    $estimate_desc= trim($this->input->post('estimate_desc'));
    $estimate_desc = trim(str_replace("  ", " ", $estimate_desc));
    $estimate_desc = trim(str_replace("'", "''", $estimate_desc));

    $mpn_description= $this->input->post('mpn_description');

    $compAvgPrice=$this->input->post('compAvgPrice');
    $compAvgPrice = str_replace("$", "", $compAvgPrice);
    $compAvgPrice = str_replace("$ ", "", $compAvgPrice);
    
    $compAmount=$this->input->post('compAmount');
    $compAmount = str_replace("$ ", "", $compAmount);
    $compAmount = str_replace("$", "", $compAmount);

    $ebayFee=$this->input->post('ebayFee');
    $ebayFee = str_replace("$ ", "", $ebayFee);
    $ebayFee = str_replace("$", "", $ebayFee);

    $payPalFee=$this->input->post('payPalFee');
    $payPalFee = str_replace("$ ", "", $payPalFee);
    $payPalFee = str_replace("$", "", $payPalFee);

    $shipFee=$this->input->post('shipFee');
    $shipFee = str_replace("$ ", "", $shipFee); 
    $shipFee = str_replace("$", "", $shipFee); 

    $tech_condition=$this->input->post('tech_condition');
    
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $estimate_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

   

    $user_id = $this->session->userdata('user_id');
    //var_dump($estimate_date, $dynamic_cata_id);exit;
      $check_catalogue = $this->db2->query("SELECT LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT WHERE LZ_BD_CATAG_ID = $dynamic_cata_id");
      if ($check_catalogue->num_rows() > 0) {
         $check_catalogue = $check_catalogue->result_array(); 
        $lz_es_id = $check_catalogue[0]['LZ_BD_ESTIMATE_ID'];
        $est_statu_update = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT F SET F.EST_STATUS ='$es_status', F.EST_POST_REMARKS_ID ='$discard_remarks'  where  F.LZ_BD_ESTIMATE_ID =$lz_es_id ");
         //var_dump($compName, $compQty, $compAvgPrice, $compAmount, $ebayFee, $payPalFee, $shipFee); exit;
        return 0;
      }else {
        //echo "yesss"; exit;
       $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
          $lz_estimate_id = $rs[0]['ID'];
        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY, CATALOGUE_MT_ID, ESTIMATE_DESC) VALUES($lz_estimate_id, $dynamic_cata_id, $estimate_date, $user_id, $catalogue_mt_id, '$estimate_desc')");
      if ($insert_est_mt) {
         $est_statu_update = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT F SET F.EST_STATUS ='$es_status' ,F.EST_POST_REMARKS_ID ='$discard_remarks' where F.LZ_BD_ESTIMATE_ID = $lz_estimate_id ");
        $i=0;
        foreach ($compName as $comp) {
          $component = trim($comp);
          $kit_mpn_desc = str_replace("  ", " ", $mpn_description[$i]);
          $mpn_descript = str_replace("'", "''", $kit_mpn_desc);
          $mpn_desc = trim($mpn_descript);
          $kit_mpn_desc = substr($mpn_desc, 0, 80);

          $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");  
          $rs = $qry->result_array();
            $lz_estimate_det_id = $rs[0]['ID'];
           $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, SOLD_PRICE, PART_CATLG_MT_ID, MPN_DESCRIPTION) VALUES($lz_estimate_det_id, $lz_estimate_id, $component, $compQty[$i], $compAmount[$i], $ebayFee[$i], $payPalFee[$i], $shipFee[$i], $tech_condition[$i], NULL, NULL, NULL, NULL, $compAvgPrice[$i],$partsCatalgid[$i], '$kit_mpn_desc')");
           if (!empty($kit_mpn_desc)) {
             $check_in_kit = $this->db2->query(" SELECT * FROM LZ_BD_MPN_KIT_MT A WHERE A.MPN_KIT_MT_ID = $component AND A.CATALOGUE_MT_ID = $catalogue_mt_id");
              if ($check_in_kit->num_rows() > 0) {
                $update_kit = $this->db2->query("UPDATE  LZ_BD_MPN_KIT_MT SET  MPN_DESCRIPTION = '$kit_mpn_desc' WHERE MPN_KIT_MT_ID = $component AND CATALOGUE_MT_ID = $catalogue_mt_id");
              }else{
                  $kit_alt_mpn = $this->db2->query(" SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID = $component AND A.CATALOGUE_MT_ID = $partsCatalgid[$i]");
                  if ($kit_alt_mpn->num_rows() > 0) {
                      $update_alt = $this->db2->query("UPDATE  LZ_BD_MPN_KIT_ALT_MPN SET  MPN_DESCRIPTION = '$kit_mpn_desc' WHERE MPN_KIT_MT_ID = $component AND CATALOGUE_MT_ID = $partsCatalgid[$i]");
                  }
              }
           }
                        
          $i++;
        } /// end foreach
        if ($insert_est_det) {
              $check_est_id = $this->db2->query("SELECT LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO WHERE LZ_BD_CATA_ID = $dynamic_cata_id");
              if ($check_est_id->num_rows() == 0) {
                 $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
                $rs = $qry->result_array();
                $tracking_id = $rs[0]['ID'];
                $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, LZ_ESTIMATE_ID, INSERTED_DATE, INSERTED_BY) VALUES($dynamic_cata_id, $cat_id, $tracking_id, $lz_estimate_id, $estimate_date, $user_id)");
                $update_tracking_no = 1;
                
              }else {
                $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET  LZ_ESTIMATE_ID = $lz_estimate_id  WHERE LZ_BD_CATA_ID = $dynamic_cata_id");
                $update_tracking_no = 1;
              } 

              $this->session->unset_userdata('comp_name');

              $this->session->unset_userdata('part_ids');
              $this->session->unset_userdata('comp_name');
              $this->session->unset_userdata('comp_qty');
              $this->session->unset_userdata('comp_avg_price');
              $this->session->unset_userdata('comp_amount');
              $this->session->unset_userdata('estAmount');

              $this->session->unset_userdata('ebay_fees');
              $this->session->unset_userdata('paypal_fees');
              $this->session->unset_userdata('ship_fees');
              $this->session->unset_userdata('sub_totals');
            }

        if($update_tracking_no == 1){
              return 1;
            }else {
                return 2;
              }
      }
      }   
  }
  public function trashResultRow(){
       $flag_id                = $this->input->post("flag_id");
       $cat_id                 = $this->input->post("cat_id");
        $lz_bd_cata_id          = $this->input->post("lz_bd_cata_id");
       $this->session->set_userdata(["ctc_kit_flag"=>$flag_id, "lz_bd_cata_id"=>$lz_bd_cata_id]);
        //var_dump($flag_id, $cat_id ,$lz_bd_cata_id ); exit;
       $update_flag = $this->db2->query("UPDATE  lz_bd_active_data_$cat_id SET FLAG_ID = $flag_id WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
        if($update_flag){
          return true;
          }else {
          return false;
        }   
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

  public function cp_delete_component(){
    $kit_id = $this->uri->segment(7);
    $part_id = $this->uri->segment(8);
    //var_dump($component_id); exit;
    $check_tracking_no = $this->db2->query("SELECT T.MPN_KIT_MT_ID FROM LZ_BD_ESTIMATE_DET T WHERE T.MPN_KIT_MT_ID = $kit_id AND T.PART_CATLG_MT_ID = $part_id");
    if ($check_tracking_no->num_rows() == 0) { 
      $del_comp_from_alt_mpn = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_ALT_MPN T WHERE T.MPN_KIT_MT_ID = $kit_id AND T.CATALOGUE_MT_ID = $part_id");
      $deleted_row = $this->db2->affected_rows();
       if($deleted_row == 0){
        $del_component_from_kit = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_MT T WHERE T.MPN_KIT_MT_ID = $kit_id AND T.PART_CATLG_MT_ID = $part_id");
        $deleted_kit_row = $this->db2->affected_rows();
          if ($deleted_kit_row == 1) {
            return 1;
          }else {
            return 3; 
          }  
      }elseif($deleted_row == 1){
        return 1;
      }else{
        return 0;
      } 
    }else {
      return 2;
    }
  }
  public function up_delete_component(){
    $component_id = $this->uri->segment(7);
    //var_dump($component_id); exit;
    $check_tracking_no = $this->db2->query("SELECT T.MPN_KIT_MT_ID FROM LZ_BD_ESTIMATE_DET T WHERE T.MPN_KIT_MT_ID = $component_id");
    if ($check_tracking_no->num_rows() == 0) { 
      $del_comp_from_alt_mpn = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_ALT_MPN T WHERE T.MPN_KIT_MT_ID = $component_id");
      if($del_comp_from_alt_mpn){
        $del_component_from_kit = $this->db2->query("DELETE FROM LZ_BD_MPN_KIT_MT T WHERE T.MPN_KIT_MT_ID = $component_id");  
      }
       if ($del_component_from_kit) {
          return 1;
        }else {
          return 0; 
        }
      
    }else {
      return 2;
    }
   

  }


  public function searchUnverifyData(){
    $cat_id             = $this->uri->segment(4);
    $unverify_List_type           = strtoupper($this->input->post('listingType'));
    $unverify_condition             = trim($this->input->post('condition'));
    //var_dump($cat_id, $unverify_List_type, $unverify_condition); exit;
    $sess_data            = array("unverify_List_type"=>$unverify_List_type, "unverify_condition"=>$unverify_condition);

    $this->session->set_userdata($sess_data);
    if (!empty($this->session->userdata('unverify_List_type')) && !empty($this->session->userdata('unverify_condition'))) {
      $listingType = $this->session->userdata('unverify_List_type');
      $condition   = $this->session->userdata('unverify_condition');
    }

    $detail_qry= "SELECT LZ_BD_CATA_ID,EBAY_ID,TITLE,CONDITION_NAME,SELLER_ID,LISTING_TYPE,SALE_PRICE,START_TIME,SALE_TIME,FEEDBACK_SCORE FROM LZ_BD_CATAG_DATA_$cat_id  WHERE CATEGORY_ID = $cat_id AND VERIFIED=0 AND IS_DELETED = 0";

      if(!empty($listingType))
            {
              $detail_qry.=" AND UPPER(listing_type) LIKE '%$unverify_List_type%'";
            }

            if(!empty($condition))
            {
              $detail_qry.=" AND  CONDITION_ID = $unverify_condition";
            }

      $detail = $this->db2->query($detail_qry)->result_array(); 

      $list_qry= "SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES ORDER BY LISTING_TYPE ASC";  
      $list_types = $this->db2->query($list_qry)->result_array();

      $conditions_qry= "SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT"; 
      $conditions = $this->db2->query($conditions_qry)->result_array();
    return array('cat_id'=>$cat_id, 'unverify_List_type'=>$unverify_List_type,'unverify_condition'=>$unverify_condition, 'list_types' => $list_types, 'conditions' => $conditions);
  }
  public function deleteResultRow($id){
      $ct_category = $this->input->post('ct_category');
      $table_name = 'LZ_BD_ACTIVE_DATA_'.$ct_category;
      $query = $this->db2->query("UPDATE $table_name SET IS_DELETED = 1 WHERE LZ_BD_CATA_ID = $id ");
      if ($query){
        return true;
      }else {
        return false;
      }    
    }

    public function assignCataloguesToKit(){
      $from                = $this->input->post('from_cata_id');
      $to_ids              = $this->input->post('to_cata_id');
      //echo "<pre>";
      //print_r($to_ids); exit;
      foreach ($to_ids as $to) {
            $assign_catalogues = "call PRO_COPY_ESTIMATE_TO_ALL($from, $to)";
            $assign = $this->db2->query($assign_catalogues);  
        }
        if($assign) {
              return true;
            }else {
              return false;
            }
    } 
    public function assignAllCataloguesToKit(){
      $list_type            = $this->input->post('list_type');
      $cata_condition       = $this->input->post('cata_condition');

      $cat_id               = $this->input->post('cat_id');
      $mpn_id               = $this->input->post('mpn_id');
      $from                 = $this->input->post('from_cata_id');
     
     $sql = "SELECT BD.LZ_BD_CATA_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, BD.FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AVERAGE_PRICE , BD.SALE_PRICE - GET_AVERAGE_PRICE(M.CATEGORY_ID,M.CATALOGUE_MT_ID,BD.CONDITION_ID) AS PRICE_AFTERLIST, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.SALE_TIME > SYSDATE AND BD.CATALOGUE_MT_ID = $mpn_id AND BD.LZ_BD_CATA_ID NOT IN (SELECT LZ_BD_CATAG_ID FROM LZ_BD_ESTIMATE_MT ) AND (BD.IS_DELETED = 0 OR BD.IS_DELETED IS NULL) "; 

          if(!empty($list_type))
            {
              $sql.=" AND UPPER(BD.listing_type) LIKE '%$list_type%'";
            }

            if(!empty($cata_condition)){
              $sql.=" AND  BD.CONDITION_ID =$cata_condition";
            } 

            $sql.=" AND SALE_TIME > SYSDATE ORDER BY TIME_DIFF DESC";

      $catalogues   = $this->db2->query($sql)->result_array();
      foreach ($catalogues as $cata) {
        $to = $cata['LZ_BD_CATA_ID'];
        //var_dump($from, $to); exit;
            $assign_catalogues = "call PRO_COPY_ESTIMATE_TO_ALL($from, $to)";
            $assign = $this->db2->query($assign_catalogues);
        }
        if ($assign) {
              return true;
            }else {
              return false;
            }
    }

  
   public function copy_estimate(){
      $cat_id = $this->uri->segment(4); 
      $catalogue_mt_id = $this->uri->segment(5);
      $lz_bd_cata_id = $this->uri->segment(6) ;

      $sess_data = array("catalogue_List_type"=>"All", "catalogue_condition"=>"All");
      $this->session->set_userdata($sess_data);

      $results = $this->db2->query("SELECT M.*,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME,GET_AVG_PRICE(C.CATEGORY_ID, M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME,GET_AVG_PRICE(C.CATEGORY_ID, MP.CATALOGUE_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID ORDER BY AVG_PRICE ASC");
      
      $distinct_object_count = $this->db2->query("SELECT * FROM (SELECT distinct LPAD(O.OBJECT_NAME, 16) OBJECT_NAME, count(1)  object_count FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID group by O.OBJECT_NAME UNION ALL SELECT distinct O.OBJECT_NAME, count(1) object_count FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID group by O.OBJECT_NAME) ORDER BY OBJECT_NAME ASC");
      $object_list = $distinct_object_count->result_array();        

      $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND BD.LZ_BD_CATA_ID =$lz_bd_cata_id"); 
      $detail = $det_qry->result_array();
      

      $components = $this->db2->query("SELECT MP.MPN, D.MPN_DESCRIPTION, O.OBJECT_NAME , M.LZ_BD_ESTIMATE_ID, D.TECH_COND_ID, M.LZ_BD_CATAG_ID, D.LZ_ESTIMATE_DET_ID, D.MPN_KIT_MT_ID, D.PART_CATLG_MT_ID, D.QTY, D.EST_SELL_PRICE, D.PAYPAL_FEE, D.EBAY_FEE, D.SHIPPING_FEE, D.SOLD_PRICE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ESTIMATE_DET D,LZ_CATALOGUE_MT MP ,LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_ESTIMATE_ID = D. LZ_BD_ESTIMATE_ID AND D.PART_CATLG_MT_ID = MP.CATALOGUE_MT_ID AND O.OBJECT_ID = MP.OBJECT_ID AND M.LZ_BD_CATAG_ID = $lz_bd_cata_id");

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
        // echo "<pre>";
        // print_r($components->result_array());
        // exit;
        return array("results"=>$results, "detail"=>$detail, "components"=>$components, "conditions"=>$conditions, "object_list"=>$object_list);
   }
    
public function getEstimateData(){
   $lz_bd_cata_id                = $this->input->post('lz_bd_cata_id');
   $rowReocord = $this->db2->query("SELECT distinct M.LZ_BD_ESTIMATE_ID, M.LZ_BD_CATAG_ID, D.LZ_ESTIMATE_DET_ID, D.MPN_KIT_MT_ID, D.QTY, D.EST_SELL_PRICE, D.PAYPAL_FEE, D.EBAY_FEE, D.SHIPPING_FEE, D.SOLD_PRICE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ESTIMATE_DET D WHERE M.LZ_BD_ESTIMATE_ID = D. LZ_BD_ESTIMATE_ID AND M.LZ_BD_CATAG_ID = $lz_bd_cata_id");
      /*echo "<pre>";
      print_r($rowReocord);
      exit;*/
   $total_check     = 0;
   $estimate_amount     = 0;
   $total_check     = count($rowReocord->result_array());
   $total_qty       = 0;
   $est_price       = 0;
   $paypal_fee      = 0;
   $shiping_fee     = 0;
   $ebay_fee        = 0;
   $sold_price      = 0;
     foreach ($rowReocord->result_array() as $row) {
       $total_qty         = $total_qty        + $row['QTY'];
       $est_price         = $est_price        + $row['EST_SELL_PRICE'];
       $estimate_amount   = ($estimate_amount + ($row['QTY'] * $row['EST_SELL_PRICE']));
       $paypal_fee        = $paypal_fee       + $row['PAYPAL_FEE'];
       $shiping_fee       = $shiping_fee      + $row['SHIPPING_FEE'];
       $ebay_fee          = $ebay_fee         + $row['EBAY_FEE'];
       $sold_price        = $sold_price       + $row['SOLD_PRICE'];
     }
      return array(
        'TOTAL_CHECK'               =>$total_check,
        'TOTAL_QTY'                 =>$total_qty, 
        'EST_PRICE'                 =>$est_price, 
        'ESTIMATE_AMOUNT'           =>$estimate_amount, 
        'PAYPAL_FEE'                =>$paypal_fee, 
        'SHIPING_FEE'               =>$shiping_fee, 
        'EBAY_FEE'                  =>$ebay_fee, 
        'SOLD_PRICE'                =>$sold_price
      ); 
   }
  public function updateKitComponents(){
    $estimate_id=$this->input->post('estimate_id');
    $catalogue_mt_id=$this->input->post('catalogue_mt_id');
    $es_status=$this->input->post('es_status');
    $discard_remarks=$this->input->post('discard_remarks');
    $catag_id=$this->input->post('catag_id');
    $compName=$this->input->post('compName');
    $compQty=$this->input->post('compQty');
    $tech_condition=$this->input->post('tech_condition');

    $compAvgPrice=$this->input->post('compAvgPrice');
    $compAvgPrice = str_replace("$", "", $compAvgPrice);
    $compAvgPrice = str_replace("$ ", "", $compAvgPrice);
    //var_dump( $compAvgPrice ); exit;
    $estimate_price=$this->input->post('estimate_price');
    $estimate_price = str_replace("$ ", "", $estimate_price);
    $estimate_price = str_replace("$", "", $estimate_price);

    $mpn_description= $this->input->post('kit_mpn_desc');

    $ebayFee=$this->input->post('ebayFee');
    $ebayFee = str_replace("$ ", "", $ebayFee);
    $ebayFee = str_replace("$", "", $ebayFee);

    $payPalFee=$this->input->post('payPalFee');
    $payPalFee = str_replace("$ ", "", $payPalFee);
    $payPalFee = str_replace("$", "", $payPalFee);

    $shipFee=$this->input->post('shipFee');
    $shipFee = str_replace("$ ", "", $shipFee);
    $shipFee = str_replace("$", "", $shipFee);
    $part_catlg_mt_id = $this->input->post('part_catalogue_mt_id');

    //var_dump($estimate_id, $compAvgPrice, $estimate_price, $ebayFee, $payPalFee, $shipFee); exit;
    //var_dump($compName, $mpn_description); exit;

        $check_post = $this->db2->query("SELECT T.LZ_SINGLE_ENTRY_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_BD_CATA_ID = $catag_id");
        $check_post = $check_post->result_array();
        

        if (empty($check_post[0]['LZ_SINGLE_ENTRY_ID'])) {
          //var_dump('in if');exit;
           $get_est_pk = $this->db2->query("DELETE FROM  LZ_BD_ESTIMATE_DET D WHERE D.LZ_BD_ESTIMATE_ID = $estimate_id");
            if ($get_est_pk) {
               $est_statu_update = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT F SET F.EST_STATUS ='$es_status',F.EST_POST_REMARKS_ID ='$discard_remarks'   WHERE F.LZ_BD_ESTIMATE_ID = $estimate_id"); 
               $i=0;
                foreach ($compName as $comp) {
                    $component = trim($comp);
                    $kit_mpn_desc = str_replace("  ", " ", $mpn_description[$i]);
                    $mpn_descript = str_replace("'", "''", $kit_mpn_desc);
                    $mpn_desc = trim($mpn_descript);
                    $kit_mpn_desc = substr($mpn_desc, 0, 80);
                  //var_dump($component, $kit_mpn_desc); exit;
                  $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                  $rs = $qry->result_array();
                    $lz_estimate_det_id = $rs[0]['ID'];
                   $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, SOLD_PRICE,PART_CATLG_MT_ID, MPN_DESCRIPTION) VALUES($lz_estimate_det_id, $estimate_id, $component, $compQty[$i], $estimate_price[$i], $ebayFee[$i], $payPalFee[$i], $shipFee[$i], $tech_condition[$i], NULL, NULL, NULL, NULL, $compAvgPrice[$i],$part_catlg_mt_id[$i], '$kit_mpn_desc')");
                      if (!empty($kit_mpn_desc)) {
                        $check_in_kit = $this->db2->query(" SELECT * FROM LZ_BD_MPN_KIT_MT A WHERE A.MPN_KIT_MT_ID = $component AND A.CATALOGUE_MT_ID = $catalogue_mt_id");
                      if ($check_in_kit->num_rows() > 0) {
                        $update_kit = $this->db2->query("UPDATE  LZ_BD_MPN_KIT_MT SET  MPN_DESCRIPTION = '$kit_mpn_desc' WHERE MPN_KIT_MT_ID = $component AND CATALOGUE_MT_ID = $catalogue_mt_id");
                      }else{
                          $kit_alt_mpn = $this->db2->query(" SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID = $component AND A.CATALOGUE_MT_ID = $part_catlg_mt_id[$i]");
                          if ($kit_alt_mpn->num_rows() > 0) {
                              $update_alt = $this->db2->query("UPDATE  LZ_BD_MPN_KIT_ALT_MPN SET  MPN_DESCRIPTION = '$kit_mpn_desc' WHERE MPN_KIT_MT_ID = $component AND CATALOGUE_MT_ID = $part_catlg_mt_id[$i]");
                          }
                        }
                      }
                       

                  $i++;
                } /// end foreach
              if($insert_est_det){
                  return 1;
                }else {
                    return 0;
                  }
              }
        }else {
          return 2;
        }
         
  }

   public function updateFlag(){
    $flag_id                = $this->input->post("flag_id");
    $cat_id                 = $this->input->post("cat_id");
    $lz_bd_cata_id          = $this->input->post("lz_bd_cata_id");

    $this->session->set_userdata(["ctc_kit_flag"=>$flag_id, "lz_bd_cata_id"=>$lz_bd_cata_id]);
    //var_dump($flag_id, $cat_id ,$lz_bd_cata_id ); exit;
    $update_flag = $this->db2->query("UPDATE  lz_bd_active_data_$cat_id SET FLAG_ID = $flag_id WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
      if($update_flag){
        return true;
      }else {
        return false;
      }

  } 
  public function get_objects(){
     $comp_category = $this->input->post('comp_category');
     return $this->db2->query("SELECT DISTINCT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = O.CATEGORY_ID AND C.CATEGORY_ID = $comp_category")->result_array();
      }
  /*public function get_brands(){
    $object_id = $this->input->post('object_id');
    return $this->db->query("SELECT  DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) ='BRAND' AND CD.DET_ID = D.SPECIFIC_DET_ID AND M.OBJECT_ID = $object_id")->result_array(); 
  }*/
   public function get_mpns(){
     $object_id = $this->input->post('object_id');
     $category_id = $this->input->post('category_id');
     $object_name         = strtoupper($this->input->post('object_name'));
      $object_name         = trim(str_replace("  ", ' ', $object_name));
      $object_name         = trim(str_replace(array("'"), "''", $object_name));
      //var_dump($object_name); exit;
      $check_memory = $this->db2->query("SELECT S.DEFAULT_CAT_ID FROM LZ_BD_STD_COMP_KIT S WHERE
      S.LZ_BD_MAIN_OBJ_ID = $object_id AND  S.DEFAULT_CAT_ID IS NOT NULL");
        if($check_memory->num_rows() > 0){
          $memory = $check_memory->result_array();
          $default_cat_id = $memory[0]['DEFAULT_CAT_ID'];
          $check_memory = $this->db2->query("UPDATE LZ_BD_STD_COMP_KIT SET ALLOW_SEARCH_PANEL=1 WHERE DEFAULT_CAT_ID = $default_cat_id");
          $mpn = $this->db2->query("SELECT C.CATALOGUE_MT_ID,C.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $default_cat_id AND C.OBJECT_ID = $object_id AND  C.CUSTOM_MPN = 1")->result_array();
          $allow = 1;
          return array("mpn"=>$mpn, "allow"=>$allow);
        }else {
          $allow = 0;
          $mpn = $this->db2->query("SELECT C.CATALOGUE_MT_ID,C.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $category_id AND C.OBJECT_ID = $object_id")->result_array();
          return array("mpn"=>$mpn, "allow"=>$allow);
        }
      

      }
      public function get_upc(){
     $mpn_id = $this->input->post('mpn_id');
      //var_dump($object_name); exit;
      return $this->db2->query("SELECT C.UPC FROM LZ_CATALOGUE_MT C WHERE
      C.CATALOGUE_MT_ID = $mpn_id")->result_array();
      }
  public function addKitComponent(){
    $master_mpn = $this->input->post('catalogue_mpn_id');
    $object_id = $this->input->post('comp_object');

    $object_name         = strtoupper($this->input->post('object_name'));
    $object_name         = trim(str_replace("  ", ' ', $object_name));
    $object_name         = trim(str_replace(array("'"), "''", $object_name));

    $new_upc         = strtoupper($this->input->post('new_upc'));
    $comp_upc         = trim(str_replace("  ", ' ', $new_upc));
    $comp_upc         = trim(str_replace(array("'"), "''", $comp_upc));

    $cat_mt_id = $this->input->post('comp_mpn');

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $created_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');
    //var_dump($master_mpn, $object_id, $cat_mt_id, $object_name); exit;
      $kitsmpn_check = $this->db2->query("SELECT M.MPN_KIT_MT_ID, C.MPN_DESCRIPTION FROM LZ_BD_MPN_KIT_MT M,  LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND UPPER(O.OBJECT_NAME) = '$object_name'");
      
      $this->db2->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$comp_upc' WHERE CATALOGUE_MT_ID = $cat_mt_id");

      if ($kitsmpn_check->num_rows() == 0){
          $mpn_kit_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') MPN_KIT_MT_ID FROM DUAL");
          $mpn_kit_pk = $mpn_kit_pk->result_array();
          $mpn_kit_mt_id = $mpn_kit_pk[0]['MPN_KIT_MT_ID'];

          $mpn_desc = $this->db2->query("SELECT C.MPN_DESCRIPTION FROM LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID = $cat_mt_id")->result_array();
          $mpn_description = $mpn_desc[0]['MPN_DESCRIPTION'];

          $insert_mpn_kit = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID,CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID, MPN_DESCRIPTION, CREATED_DATE, CREATED_BY) VALUES($mpn_kit_mt_id,$master_mpn,1,$cat_mt_id,  '$mpn_description', $created_date, $user_id)");
            if ($insert_mpn_kit) {
              $check = 1; 
            }else {
              $check = 0;
            }
      }else {

        $mpn_kit_mt_id = $kitsmpn_check->result_array()[0]['MPN_KIT_MT_ID'];
        $mpn_description = $kitsmpn_check->result_array()[0]['MPN_DESCRIPTION'];
        /// INSERT IF NOT AVAILABLE IN ALT TABLE
        $kit_alt_mpn = $this->db2->query(" SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID = $mpn_kit_mt_id AND A.CATALOGUE_MT_ID = $cat_mt_id"); ////////////////check if components is already exist///////////////////////////
            if ($kit_alt_mpn->num_rows() == 0) {
               $mpn_kit_alt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') MPN_KIT_ALT_MPN FROM DUAL ")->result_array();
              $mpn_kit_alt_mpn = $mpn_kit_alt_pk[0]['MPN_KIT_ALT_MPN'];

              $kitmpn_insert = $this->db2->query("INSERT INTO  LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID, MPN_DESCRIPTION, CREATED_DATE, CREATED_BY) VALUES($mpn_kit_alt_mpn, $mpn_kit_mt_id, $cat_mt_id, '$mpn_description', $created_date, $user_id)");
                if ($kitmpn_insert) {
                  $check = 1; 
                }else {
                  $check = 0;
                }
            }else {  ////end if component is already exist
              //already exist;
              $check = 2; 
            }
      }

      /////////////////////////////////
      if ($check == 1) {
                $results = $this->db2->query("SELECT * FROM (SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, C.PRICE, m.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE c.CATALOGUE_MT_ID = $cat_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND O.OBJECT_ID = $object_id UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN,C.PRICE,  mp.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND c.CATALOGUE_MT_ID = $cat_mt_id AND O.OBJECT_ID = $object_id) WHERE ROWNUM = 1 ORDER BY CATALOGUE_MT_ID DESC");

                  // $results = $this->db2->query("SELECT * FROM (SELECT M.MPN_KIT_MT_ID, M.CATALOGUE_MT_ID, M.QTY, M.PART_CATLG_MT_ID, C.MPN, C.PRICE, M.MPN_DESCRIPTION, REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND O.OBJECT_ID = $object_id UNION SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, C.PRICE, MP.MPN_DESCRIPTION, REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE MP.MPN_KIT_MT_ID IN (SELECT T.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $master_mpn) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $cat_mt_id AND O.OBJECT_ID = $object_id) WHERE ROWNUM = 1 ORDER BY CATALOGUE_MT_ID DESC");

          $result = $results->result_array();
            $total = $this->db2->query("SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, M.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME  FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND O.OBJECT_ID=C.OBJECT_ID  
               AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID  UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, MP.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");
          $total_components = $total->result_array();
          $totals = count($total_components);

          $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

                return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals, "check"=>$check);
          }else {
            return array("check"=>$check);
          }
  }
  public function addCataMpn(){
    $cat_id             = $this->input->post('cat_id');
    ///var_dump($cat_id); exit;
    $master_mpn         = $this->input->post('master_mpn');
    $mpn_object         = strtoupper($this->input->post('mpn_object'));
    $mpn_object         = trim(str_replace("  ", ' ', $mpn_object));
    $mpn_object         = trim(str_replace(array("'"), "''", $mpn_object));

    $new_mpn            = strtoupper($this->input->post('new_mpn'));
    $mpn_brand          = strtoupper($this->input->post('mpn_brand'));
    $mpn_brand          = trim(str_replace("  ", ' ', $mpn_brand));
    $mpn_brand          = trim(str_replace(array("'"), "''", $mpn_brand)); 

    $comp_upc           = strtoupper($this->input->post('comp_upc'));
    $component_upc      = trim(str_replace("  ", ' ', $comp_upc));
    $comp_upc      = trim(str_replace(array("'"), "''", $component_upc));    

    $insert_by          = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date               = date('Y-m-d H:i:s');
    $insert_date        = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $mpn_desc           = $this->input->post('mpn_desc');
    $mpn_desc           = trim(str_replace("  ", ' ', $mpn_desc));
    $mpn_desc           = trim(str_replace(array("'"), "''", $mpn_desc));

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $created_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');
    //var_dump($cat_id, $master_mpn, $mpn_object, $new_mpn, $mpn_brand, $mpn_desc); 
      /*========================================
      =            Catalogue Detail            =
      ========================================*/
      /*=====  End of Catalogue Detail  ======*/
      $checkQry = $this->db2->query("SELECT DISTINCT OBJECT_ID,OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$mpn_object' AND CATEGORY_ID = $cat_id");
    if($checkQry->num_rows() == 0){
      $obj_id = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
      $get_mt_pk = $obj_id->result_array();
      $object_id = $get_mt_pk[0]['OBJECT_ID'];
      $qry = "INSERT INTO LZ_BD_OBJECTS_MT O (OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID) VALUES($object_id, '$mpn_object',$insert_date,$insert_by, $cat_id)";
      $this->db2->query($qry);
     
    }else{
       $object_id = $checkQry->result_array()[0]['OBJECT_ID'];
       $object_name = $checkQry->result_array()[0]['OBJECT_NAME'];
    }
    //var_dump($object_id); exit;
    $mpn_check = $this->db2->query("SELECT CATALOGUE_MT_ID, OBJECT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$new_mpn' AND CATEGORY_ID = $cat_id");

      if($mpn_check->num_rows() == 0){
        $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
        $get_pk = $get_mt_pk->result_array();
        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

        $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION, BRAND, UPC) VALUES($cat_mt_id, '$new_mpn', $cat_id, $insert_date, $insert_by,$object_id,'$mpn_desc', '$mpn_brand', '$comp_upc')");      
      }else{
        $get_pk = $mpn_check->result_array();
        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];
      }

          $kitsmpn_check = $this->db2->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND O.CATEGORY_ID = C.CATEGORY_ID AND UPPER(O.OBJECT_NAME) = '$mpn_object'");
         
          if ($kitsmpn_check->num_rows() == 0){
          //$mpn_kit_pk = $this->db->query("SELECT get_single_primary_key('lz_bd_mpn_kit_mt','mpn_kit_mt_id') ID FROM DUAL");
          $mpn_kit_pk = $this->db2->query("SELECT get_single_primary_key('lz_bd_mpn_kit_mt','mpn_kit_mt_id') MPN_KIT_MT_ID FROM DUAL")->result_array();
          $mpn_kit_mt_id = $mpn_kit_pk[0]['MPN_KIT_MT_ID'];
          ///var_dump($mpn_kit_mt_id); exit;

          $insert_mpn_kit = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID,CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID, MPN_DESCRIPTION, CREATED_DATE, CREATED_BY) VALUES($mpn_kit_mt_id,$master_mpn,1,$cat_mt_id, '$mpn_desc', $created_date, $user_id )");
            if ($insert_mpn_kit) {
                $check = 1; 
          }else {
            $check = 0; 
          }

          }else {
            $mpn_kit_mt_id = $kitsmpn_check->result_array()[0]['MPN_KIT_MT_ID'];
            /// var_dump($mpn_kit_mt_id); exit;
            /// INSERT IF NOT AVAILABLE IN ALT TABLE
            $kit_alt_mpn = $this->db2->query(" SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID = $mpn_kit_mt_id AND A.CATALOGUE_MT_ID = $cat_mt_id");
        if ($kit_alt_mpn->num_rows() == 0) {
            $mpn_kit_alt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') MPN_KIT_ALT_MPN FROM DUAL");
              $mpn_kit_pk = $mpn_kit_alt_pk->result_array();
              $mpn_kit_alt_mpn = $mpn_kit_pk[0]['MPN_KIT_ALT_MPN'];

            $kitmpn_insert = $this->db2->query("INSERT INTO  LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID, MPN_DESCRIPTION, CREATED_DATE, CREATED_BY) VALUES($mpn_kit_alt_mpn, $mpn_kit_mt_id, $cat_mt_id, '$mpn_desc', $created_date, $user_id)");
          if ($kitmpn_insert) {
                $check = 1; 
          }else {
            $check = 0; 
          }
        }else {
          //echo "already";
           $check = 2;  
        }
      }//endif master mpn


       if ($check == 1) {
                // $results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, m.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID =  $master_mpn AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND m.PART_CATLG_MT_ID = $cat_mt_id UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, mp.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE MP.MPN_KIT_MT_ID IN (SELECT T.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $master_mpn) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $cat_mt_id");
                 $results = $this->db2->query("SELECT * FROM (SELECT M.MPN_KIT_MT_ID, M.CATALOGUE_MT_ID, M.QTY, M.PART_CATLG_MT_ID, C.MPN, C.PRICE, M.MPN_DESCRIPTION, REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND M.PART_CATLG_MT_ID = $cat_mt_id AND O.OBJECT_ID = $object_id UNION SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, C.PRICE, MP.MPN_DESCRIPTION, REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE MP.MPN_KIT_MT_ID IN (SELECT T.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $master_mpn) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $cat_mt_id AND O.OBJECT_ID = $object_id) WHERE ROWNUM = 1 ORDER BY CATALOGUE_MT_ID DESC");

                    $result = $results->result_array();
                      $total = $this->db2->query("SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, m.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID  UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, mp.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $master_mpn) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");
                    $total_components = $total->result_array();
                    $totals = count($total_components);

                    $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

                return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals, "check"=>$check);
          }else {
            return array("check"=>$check);
          }
  }
  public function createAutoKit(){
    $ct_catlogue_mt_id = $this->input->post('ct_catlogue_mt_id');
    $group_id = $this->input->post('group_id');
    $kitmpnauto = strtoupper(trim($this->input->post('kitmpnauto')));
    $pro_auto_kit = "call PRO_AUTO_KIT_DYNAMIC($ct_catlogue_mt_id, '$kitmpnauto', $group_id)";
    //var_dump($pro_auto_kit); exit;
    //PRO_AUTO_KIT_DYNAMIC(PARAM_MASTER_MPN VARCHAR2 , PARAM_MPN_EXPR VARCHAR2, PARAM_CAT_GROUP_ID NUMBER)
    $query = $this->db2->query($pro_auto_kit);
    if($query){
        return 1;
    }else{
        return 0;
    }    
  }
 public function get_cond_base_price(){
     $kitmpn_id        = $this->input->post('kitmpn_id');
     $condition_id     = $this->input->post('condition_id');
     //var_dump($kitmpn_id, $condition_id); exit;

     return $this->db2->query("SELECT * FROM MPN_AVG_PRICE M WHERE M.CATALOGUE_MT_ID = $kitmpn_id   AND M.CONDITION_ID =  $condition_id")->result_array(); 
     /*if (count($data) > 0) {
       return $data;
     }else {
       return $data=['AVG_PRICE'=>''];
     }*/
  }
  public function discard_mpn(){
    $flag_id                = $this->input->post("flag_id");
    $cat_id                 = $this->input->post("cat_id");
    $lz_bd_cata_id          = $this->input->post("lz_bd_cata_id");
    $mpn_id                 = $this->input->post("mpn_id");
    $this->session->set_userdata(["ctc_kit_flag"=>$flag_id, "lz_bd_cata_id"=>$lz_bd_cata_id]);
    //var_dump($flag_id, $cat_id ,$lz_bd_cata_id, $mpn_id); exit;
    $update_flag = $this->db2->query("UPDATE  LZ_BD_ACTIVE_DATA_$cat_id SET FLAG_ID =  $flag_id WHERE CATALOGUE_MT_ID = $mpn_id");
      if($update_flag){
        return true;
      }else {
        return false;
      }
  } 
  public function lot_select(){
       $flag_id                = $this->input->post("flag_id");
       $cat_id                 = $this->input->post("cat_id");
        $lz_bd_cata_id          = $this->input->post("lz_bd_cata_id");
       $this->session->set_userdata(["ctc_kit_flag"=>$flag_id, "lz_bd_cata_id"=>$lz_bd_cata_id]);
        //var_dump($flag_id, $cat_id ,$lz_bd_cata_id ); exit;
       $update_flag = $this->db2->query("UPDATE  lz_bd_active_data_$cat_id SET FLAG_ID = $flag_id,LOTSONLY = 1 WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
        if($update_flag){
          return true;
          }else {
          return false;
        }   
    }
  
public function search_component(){
    $input_text   = trim(strtoupper($this->input->post("input_text")));
    $input_text   = str_replace("'","''", $input_text);
    $data_source  = $this->input->post("data_source");
    $data_status  = $this->input->post("data_status");
    $parm_text    = '';

    $str  = explode(' ', $input_text);
    if (is_array($str) && count($str) > 1){
      foreach ($str as $value) {
          $parm_text .= " AND UPPER(TITLE) LIKE '%". $value . "%'";
      }
    }else{
      $parm_text .= " AND UPPER(TITLE) LIKE '%". $input_text . "%'";
    }

    
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
    $columns     = array(
      // datatable column index  => database column name
      0 => 'ACTION',
      1 => 'OBJECT_NAME',
      2 => 'CATEGORY_ID',
      3 => 'TITLE',
      4 => 'MPN',
      5 => 'UPC',
      6 => 'SALE_PRICE'
    );
    $sql = "SELECT 'NULL' ACTION, BD.LZ_BD_CATA_ID, O.OBJECT_ID, BD.TITLE, BD.CATEGORY_ID, BD.CONDITION_ID, BD.SALE_PRICE, M.MPN, M.UPC, M.CATALOGUE_MT_ID, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME, AV.AVG_PRICE AVG_PRICE FROM ALL_KIT_".$data_source."_DATA BD, LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE AV WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID(+) AND M.OBJECT_ID = O.OBJECT_ID(+) AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.VERIFIED = $data_status $parm_text";

    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    $sql = "SELECT 'NULL' ACTION, BD.LZ_BD_CATA_ID, O.OBJECT_ID, BD.TITLE, BD.CATEGORY_ID, BD.CONDITION_ID, BD.SALE_PRICE, M.MPN, M.UPC, M.CATALOGUE_MT_ID, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME, av.avg_price avg_price FROM ALL_KIT_".$data_source."_DATA BD, LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE AV WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID(+) AND M.OBJECT_ID = O.OBJECT_ID(+) AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.VERIFIED = $data_status $parm_text"; 
    if( !empty($requestData['search']['value']) ) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( O.OBJECT_NAME LIKE '%".trim($requestData['search']['value'])."%' ";
          $sql.=" OR BD.TITLE LIKE '%".trim($requestData['search']['value'])."%' ";  
          $sql.=" OR BD.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR M.UPC LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR M.MPN LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR BD.SALE_PRICE LIKE '%".trim($requestData['search']['value'])."%' )";
      }
      //$sql.=" ORDER BY TIME_DIFF DESC";
    // when there is no search parameter then total number rows = total number filtered rows. 
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //$sql           = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM  ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
   $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
   //print_r($sql);
   //exit;
    //echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $catalogue_mt_id = $row['CATALOGUE_MT_ID'];
      $object_name = $row['OBJECT_NAME'];
      $object_id = $row['OBJECT_ID'];
      $condition_id = $row['CONDITION_ID'];
      $lz_bd_cata_id = $row['LZ_BD_CATA_ID'];
      $avg_price = $row['AVG_PRICE'];
      if(!$data_status){
        $fetch_object = '<input style="margin-left: 5px;" type = "button" id = "fetch_object" avg="'.$avg_price.'" name = "'.$i.'" class = "btn btn-info btn-sm fetchobject pull-left" value = "Fetch Object" style="margin-left:12px;">';
      }else{
        $fetch_object = "";
      }
      $nestedData[] ='<div style="width:168px;"><input type = "button" cid="'.$condition_id.'" mpn_id="'.$catalogue_mt_id.'" mid = "'.$catalogue_mt_id.$i.'c" id = "'.$catalogue_mt_id.'" cata_id="'.$lz_bd_cata_id.'" avg="'.$avg_price.'" name = "'.$i.'" class = "btn btn-success btn-sm addtokit pull-left" value = "Add to Kit">'.$fetch_object.'<input type = "hidden" name = "'.$object_name.'" id = "object_name_'.$i.'" value = "'.$object_name.'"></div>';
      $nestedData[] = '<div style="width:239px;" ><input type = "hidden" name = "'.$object_name.'"  value = "'.$object_id.'" class="objectIs">'.$row['OBJECT_NAME'].'</div>';
      $nestedData[] = $row['CATEGORY_ID'];
      $nestedData[] = '<div style="width:600px;"> <input style="width:100%;" type = "text" class="form-control" id = "input_title" name = "input_title" value = "'.htmlentities($row['TITLE']).'"></div>';
      //$nestedData[] = $row['TITLE'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = '<input type = "text" name = "search_comp_upc"  value = "'.$row['UPC'].'" class="form-control search_comp_upc">';
      $nestedData[] = $row['SALE_PRICE']; 
      $data[] = $nestedData;
      $i++ ;
    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
 public function addtokit() {
  $parts_catalogue_id = $this->input->post('partCatalogueId');
  $catalogue_mt_id = $this->input->post('catalogueId');
  $category_id = $this->input->post('categoryId');
  $object_name = strtoupper($this->input->post('objectName'));
  $object_input  = trim(strtoupper($this->input->post("objectInput")));
  $object_input  = str_replace("'","''", $object_input);
  $dd_Object_Id = $this->input->post("ddObjectId");
  $mpn_desc  = trim($this->input->post("mpnDesc"));
  $mpn_desc  = str_replace("'","''", $mpn_desc);
  $input_upc  = trim($this->input->post("input_upc"));
  $comp_upc  = trim(strtoupper($input_upc));
  $input_upc  = str_replace("  "," ", $comp_upc);
  $input_upc  = str_replace("'","''", $input_upc);
  $mpn  = trim($this->input->post("inputText"));
  $mpn  = str_replace("'","''", $mpn);
////////////////////////////////////
  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $created_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $user_id = $this->session->userdata('user_id');
  ////////////////////////////////// 
  $flag = '';
  //var_dump($input_upc, $object_input, $dd_Object_Id); exit;
  if(empty($object_name)){
      /*=========================================
      =            check object name            =
      =========================================*/
      
      if($dd_Object_Id == 0){ // check object id
        $check_object = $this->db2->query("SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$object_input' AND CATEGORY_ID = $category_id");
        if($check_object->num_rows() == 0){
          $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
          $get_pk = $get_pk->result_array();
          $object_id_pk = $get_pk[0]['OBJECT_ID'];
          if(empty($object_id_pk)){
            $object_id_pk = 1;
          }
          $insert_obj_qry = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID)VALUES($object_id_pk,'$object_input',sysdate,2,$category_id)");
        }else{
          $check_object = $check_object->result_array();
          $object_id_pk = $check_object[0]['OBJECT_ID'];
        }
      }else{
        $object_id_pk = $dd_Object_Id;
      }
      
      /*=====  End of check object name  ======*/
      
      /*==================================================
      =            insert mpn in catalogue_mt            =
      ==================================================*/
      
    $check_mpn = $this->db2->query("SELECT CATALOGUE_MT_ID, MPN_DESCRIPTION FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn' AND CATEGORY_ID = $category_id");
    if($check_mpn->num_rows() == 0){
      
      $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
      $get_pk = $get_pk->result_array();
      $parts_catalogue_id = $get_pk[0]['CATALOGUE_MT_ID'];
      if(empty($parts_catalogue_id)){
          $parts_catalogue_id = 1;
        }
      $insert_mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED, LAST_RUN_TIME, UPC)VALUES($parts_catalogue_id,'$mpn',$category_id,sysdate,2,0,$object_id_pk,'$mpn_desc',0,null, '$input_upc')");
    }else{
      $check_mpn = $check_mpn->result_array();
      $parts_catalogue_id = $check_mpn[0]['CATALOGUE_MT_ID'];
      $this->db2->query("UPDATE LZ_CATALOGUE_MT SET OBJECT_ID = $object_id_pk, UPC = '$input_upc'  WHERE CATALOGUE_MT_ID = $parts_catalogue_id");
    }


    /*=====  End of insert mpn in catalogue_mt  ======*/
  }
  if(!empty($object_name)){

  }elseif($dd_Object_Id != 0){
    $check_object = $this->db2->query("SELECT UPPER(OBJECT_NAME) OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE OBJECT_ID = $dd_Object_Id");
    $check_object = $check_object->result_array();
    $object_name = $check_object[0]['OBJECT_NAME'];
  }elseif(!empty($object_input)){
    $object_name = $object_input;
  }
  $check_qry = $this->db2->query("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND M.PART_CATLG_MT_ID = $parts_catalogue_id AND UPPER(O.OBJECT_NAME) = '$object_name' AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID");
  if($check_qry->num_rows() == 0){
    $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') MPN_KIT_MT_ID FROM DUAL");
    $get_pk = $get_pk->result_array();
    $mpn_kit_mt_id = $get_pk[0]['MPN_KIT_MT_ID'];
    if(empty($mpn_kit_mt_id)){
          $mpn_kit_mt_id = 1;
        }
  
    $insert_mt_qry = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID, CATALOGUE_MT_ID, QTY, PART_CATLG_MT_ID,CREATED_DATE, CREATED_BY, MPN_DESCRIPTION)VALUES($mpn_kit_mt_id,$catalogue_mt_id,1,$parts_catalogue_id, $created_date,$user_id, '$mpn_desc')");
    if($insert_mt_qry){
      $flag = 1;
    }else{
      $flag = 0;
    }
  }else{
    $check_qry = $check_qry->result_array();
    $mpn_kit_mt_id = $check_qry[0]['MPN_KIT_MT_ID'];
    /*=====================================================
    =            check if alt mpn exist or not            =
    =====================================================*/
    $check_alt_qry = $this->db2->query("SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id");

    if($check_alt_qry->num_rows() > 0){
      $check_alt_qry = $this->db2->query("SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_ALT_MPN WHERE MPN_KIT_MT_ID = $mpn_kit_mt_id AND CATALOGUE_MT_ID = $parts_catalogue_id");
      if($check_alt_qry->num_rows() == 0){
        $get_alt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') MPN_KIT_ALT_MPN FROM DUAL ");
        $get_alt_pk = $get_alt_pk->result_array();
        $mpn_kit_alt_mpn = $get_alt_pk[0]['MPN_KIT_ALT_MPN'];
        if(empty($mpn_kit_alt_mpn)){
          $mpn_kit_alt_mpn = 1;
        }
        $insert_alt_qry = $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID,CREATED_DATE, CREATED_BY, MPN_DESCRIPTION)VALUES($mpn_kit_alt_mpn,$mpn_kit_mt_id,$parts_catalogue_id, $created_date,$user_id, '$mpn_desc')");
        if($insert_alt_qry){
          $flag = 1;
        }else{
          $flag = 0;
        }
      }else{
        $flag = 2;
      } 

    }else{
      $flag = 2;
    }    
    
    
    /*=====  End of check if alt mpn exist or not  ======*/
  }//if else close

  ///////////////APPEND ROW SECTION START/////////////////////////
  if ($flag == 1) {
       // $results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.catalogue_mt_id, M.QTY, M.PART_CATLG_MT_ID, C.MPN, M.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID =  $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND m.PART_CATLG_MT_ID = $parts_catalogue_id UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, mp.MPN_DESCRIPTION, regexp_replace  (regexp_replace  (O.OBJECT_NAME,'&','AND'),'/',' OR ')  OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $parts_catalogue_id");
     // $results = $this->db2->query("SELECT * FROM (SELECT M.MPN_KIT_MT_ID, M.CATALOGUE_MT_ID, M.QTY, M.PART_CATLG_MT_ID, C.MPN, C.PRICE, M.MPN_DESCRIPTION, REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND M.PART_CATLG_MT_ID = $parts_catalogue_id AND O.OBJECT_ID = $dd_Object_Id UNION SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, C.PRICE, MP.MPN_DESCRIPTION, REGEXP_REPLACE(REGEXP_REPLACE(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE MP.MPN_KIT_MT_ID IN (SELECT T.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $parts_catalogue_id AND O.OBJECT_ID = $dd_Object_Id) WHERE ROWNUM = 1 ORDER BY CATALOGUE_MT_ID DESC");

    $results = $this->db2->query("SELECT * FROM (SELECT M.MPN_KIT_MT_ID, m.catalogue_mt_id, m.qty, m.part_catlg_mt_id, C.MPN, C.PRICE, m.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE c.CATALOGUE_MT_ID = $parts_catalogue_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND O.OBJECT_ID = $dd_Object_Id UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN,C.PRICE,  mp.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT       C, LZ_BD_OBJECTS_MT      O, LZ_BD_MPN_KIT_MT      M WHERE O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND c.CATALOGUE_MT_ID = $parts_catalogue_id AND O.OBJECT_ID = $dd_Object_Id) WHERE ROWNUM = 1 ORDER BY CATALOGUE_MT_ID DESC");


      $result = $results->result_array();

      $total = $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.CATALOGUE_MT_ID, M.QTY, M.PART_CATLG_MT_ID, C.MPN, M.MPN_DESCRIPTION, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME  FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID  UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, MP.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID"); 
      $total_components = $total->result_array();
      $totals = count($total_components);

  $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals, 'flag' => $flag);
  }else {
    return array('flag' => $flag);
  }
}
public function fetch_object(){
  $category_id = $this->input->post('categoryId');
  $query = $this->db2->query("SELECT OBJECT_ID , OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE CATEGORY_ID = $category_id");
  $result = $query->result_array();
  return $result;
}
public function fesibility_index(){

  $lz_bd_cata_id  =$this->uri->segment(4);

$query = "SELECT LZ_BD_CATA_ID,'SELL THROUGH' FACTOR_NAME, SELL_THROUGH VALUE, SELL_THROUGH FACTOR_PERCENT, SELL_THROUGH_RANK RANK_WEIGHTAGE, SELL_THROUGH_RANK / 100 * SELL_THROUGH RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT EBAY_ID, LZ_BD_CATA_ID, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE LZ_BD_CATA_ID = $lz_bd_cata_id UNION ALL SELECT LZ_BD_CATA_ID, 'PROFIT %' FACTOR_NAME, P VALUE, KIT_PERCENT FACTOR_PERCENT, PROFIT_PERC_RANK RANK_WEIGHTAGE, PROFIT_PERC_RANK / 100 * KIT_PERCENT RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT EBAY_ID, LZ_BD_CATA_ID, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, FACTOR_PERCENT SELL_THROUGH, PROFIT_PERC_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE LZ_BD_CATA_ID = $lz_bd_cata_id UNION ALL SELECT LZ_BD_CATA_ID, 'TURNOVER UNITS / Day' FACTOR_NAME, AVG_SOLD_QTY_PER_DAY VALUE, TURN_U_FACT_PERC FACTOR_PERCENT, TURNOVER_D_RANK RANK_WEIGHTAGE, TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT EBAY_ID, LZ_BD_CATA_ID, FACTOR_PERCENT SELL_THROUGH, TURNOVER_D_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE LZ_BD_CATA_ID = $lz_bd_cata_id UNION ALL SELECT LZ_BD_CATA_ID, 'TURNOVER $ / Day' FACTOR_NAME, AVG_SOLD_VALU_PER_DAY VALUE, TURN_U_FACT_VALUE FACTOR_PERCENT, TURNOVER_UNITS_RANK RANK_WEIGHTAGE, TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT LZ_BD_CATA_ID, EBAY_ID, FACTOR_PERCENT SELL_THROUGH, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE LZ_BD_CATA_ID = $lz_bd_cata_id ";


  $fesi_sumary ="SELECT EBAY_ID, MPN, CONDITION_NAME, SALE_PRICE, AVERAGE_PRICE, AVG_SOLD_QTY_PER_DAY  PER_DAY_SOLD_QTY, AVG_ACTIV_QTY_PER_DAY PER_DAY_ACTIV_QTY, ITEM_URL, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT AVG_SOLD_QTY_PER_DAY, AVG_ACTIV_QTY_PER_DAY, LZ_BD_CATA_ID, AVERAGE_PRICE, EBAY_ID, ITEM_URL, CONDITION_NAME, MPN, SALE_PRICE + SHIPPING_COST SALE_PRICE, FACTOR_PERCENT SELL_THROUGH, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT AVG_ACTIV_QTY_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.EBAY_ID, BD.ITEM_URL, BD.CONDITION_NAME, M.MPN, BD.SALE_PRICE FROM ALL_ACTIVE_DATA_VIEW BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE        AV, MPN_AVG_PRICE_ACTIVE ACTI, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) ) INER_TAB) OUTER_TAB WHERE LZ_BD_CATA_ID = $lz_bd_cata_id ";


$query = $this->db2->query($query)->result_array();

$fesi_sumary = $this->db2->query($fesi_sumary)->result_array();


      return array('query' => $query,'fesi_sumary' => $fesi_sumary);
}

public function appendKitComponent(){
  $partCatalogueId      = $this->input->post('partCatalogueId');
  $catalogueId          = $this->input->post('catalogueId');
  $categoryId           = $this->input->post('categoryId');
  $inputText            = $this->input->post('component_mpn');

  $results = $this->db2->query("SELECT M.*, C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O,  LZ_BD_MPN_KIT_MT H WHERE M.CATALOGUE_MT_ID = $catalogueId AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND H.PART_CATLG_MT_ID = $partCatalogueId AND C.MPN = '$inputText'UNION ALL SELECT MP.MPN_KIT_ALT_MPN, MP.MPN_KIT_MT_ID, NULL, MP.CATALOGUE_MT_ID, C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O, LZ_BD_MPN_KIT_MT M WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT T WHERE T.CATALOGUE_MT_ID = $catalogueId ) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID AND M.PART_CATLG_MT_ID = $partCatalogueId AND C.MPN = '$inputText'"); 
  $result = $results->result_array();

   $total = $this->db2->query("SELECT M.*,C.MPN,  C.MPN_DESCRIPTION, O.OBJECT_NAME  FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID  UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");
   $total_components = $total->result_array();
   $totals = count($total_components);

  $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals);
}
public function components_session(){
        $cat_id=$this->input->post('cat_id');
        $catalogue_mt_id=$this->input->post('mpn_id');
        $dynamic_cata_id=$this->input->post('dynamic_cata_id');
        $tech_condition=$this->input->post('tech_condition');
        //var_dump($cat_id, $catalogue_mt_id, $dynamic_cata_id); exit;
        $partsCatalgid = $this->input->post('partsCatalgid');
        $kit_mt_ids = $this->input->post('kit_mt_ids');

        $compName=$this->input->post('compName');
        $compQty=$this->input->post('compQty');

        $compAvgPrice=$this->input->post('compAvgPrice');
        $compAvgPrice = str_replace("$", "", $compAvgPrice);
        $compAvgPrice = str_replace("$ ", "", $compAvgPrice);
        
        $estAmount=$this->input->post('estAmount');
        $estAmount = str_replace("$ ", "", $estAmount);
        $estAmount = str_replace("$", "", $estAmount);

        $compAmount=$this->input->post('compAmount');
        $compAmount = str_replace("$ ", "", $compAmount);
        $compAmount = str_replace("$", "", $compAmount);

        $ebay_fee=$this->input->post('ebayFee');
        $ebay_fee = str_replace("$ ", "", $ebay_fee);
        $ebay_fee = str_replace("$", "", $ebay_fee);

        $paypal_fee=$this->input->post('payPalFee');
        $paypal_fee = str_replace("$ ", "", $paypal_fee);
        $paypal_fee = str_replace("$", "", $paypal_fee);

        $ship_fee=$this->input->post('shipFee');
        $ship_fee = str_replace("$ ", "", $ship_fee); 
        $ship_fee = str_replace("$", "", $ship_fee); 

        $sub_total=$this->input->post('sub_total');
        $sub_total = str_replace("$ ", "", $sub_total); 
        $sub_total = str_replace("$", "", $sub_total); 

        $mpn_description= $this->input->post('mpn_description');
        $mpn_desc = str_replace("  ", " ", $mpn_description);
        $mpn_desc = str_replace("'", "''", $mpn_desc);

        //var_dump($cat_id, $catalogue_mt_id, $dynamic_cata_id, $tech_condition, $partsCatalgid); exit;
        ///var_dump($mpn_desc); exit;

       /* $total_checks             =$this->input->post('total_checks');
        $total_qtys               =$this->input->post('total_qtys');
        $total_sold               =$this->input->post('total_sold');
        $total_estimate           =$this->input->post('total_estimate');
        $total_amounts            =$this->input->post('total_amounts');
        $total_ebays              =$this->input->post('total_ebays');
        $total_paypals            =$this->input->post('total_paypals');
        $total_shippings          =$this->input->post('total_shippings');
        $total_count              =$this->input->post('total_count');*/


///////////////////////////////////////////////
/*  $new_array = [$checked_id => $checked_id];
  $components_array = array_merge($components, $new_array);
  $this->session->set_userdata($components_array);*/
  ///////////////////////////////////////////////////////////
  $kit_component = [];
  $kit_component = [
                "categri_id"=>$cat_id,
                "catalog_mt_id"=>$catalogue_mt_id,
                "catag_id"=>$dynamic_cata_id,
                "part_ids"=>$partsCatalgid,
                "kit_mt_ids"=>$kit_mt_ids,
                "comp_name"=>$compName,
                "comp_qty"=>$compQty,
                "mpn_desc"=>$mpn_desc,
                "comp_avg_price"=>$compAvgPrice,
                "comp_amount"=>$compAmount,
                "estAmount"=>$estAmount,
                "ebay_fees"=>$ebay_fee,
                "paypal_fees"=>$paypal_fee,
                "ship_fees"=>$ship_fee,
                "sub_totals"=>$sub_total,
                "condition_id"=>$tech_condition
              ];
   $selected_comp = $this->session->set_userdata($kit_component);
   //return 1;
  $all_selected = $this->session->userdata($selected_comp);
  echo "<pre>";
  print_r($all_selected);
  exit;

}

/*=================================================
=            update seller description            =
=================================================*/
public function update_components_session(){
        $cat_id=$this->input->post('cat_id');
        $catalogue_mt_id=$this->input->post('mpn_id');
        $dynamic_cata_id=$this->input->post('dynamic_cata_id');
        $tech_condition=$this->input->post('tech_condition');
        //var_dump($cat_id, $catalogue_mt_id, $dynamic_cata_id); exit;
        $partsCatalgid = $this->input->post('partsCatalgid');
        $compName=$this->input->post('compName');
        $compQty=$this->input->post('compQty');

        $compAvgPrice=$this->input->post('compAvgPrice');
        $compAvgPrice = str_replace("$", "", $compAvgPrice);
        $compAvgPrice = str_replace("$ ", "", $compAvgPrice);
        
        $estAmount=$this->input->post('estAmount');
        $estAmount = str_replace("$ ", "", $estAmount);
        $estAmount = str_replace("$", "", $estAmount);

        $compAmount=$this->input->post('compAmount');
        $compAmount = str_replace("$ ", "", $compAmount);
        $compAmount = str_replace("$", "", $compAmount);

        $ebay_fee=$this->input->post('ebayFee');
        $ebay_fee = str_replace("$ ", "", $ebay_fee);
        $ebay_fee = str_replace("$", "", $ebay_fee);

        $paypal_fee=$this->input->post('payPalFee');
        $paypal_fee = str_replace("$ ", "", $paypal_fee);
        $paypal_fee = str_replace("$", "", $paypal_fee);

        $ship_fee=$this->input->post('shipFee');
        $ship_fee = str_replace("$ ", "", $ship_fee); 
        $ship_fee = str_replace("$", "", $ship_fee); 

        $sub_total=$this->input->post('sub_total');
        $sub_total = str_replace("$ ", "", $sub_total); 
        $sub_total = str_replace("$", "", $sub_total); 

       /* $total_checks             =$this->input->post('total_checks');
        $total_qtys               =$this->input->post('total_qtys');
        $total_sold               =$this->input->post('total_sold');
        $total_estimate           =$this->input->post('total_estimate');
        $total_amounts            =$this->input->post('total_amounts');
        $total_ebays              =$this->input->post('total_ebays');
        $total_paypals            =$this->input->post('total_paypals');
        $total_shippings          =$this->input->post('total_shippings');
        $total_count              =$this->input->post('total_count');*/


///////////////////////////////////////////////
/*  $new_array = [$checked_id => $checked_id];
  $components_array = array_merge($components, $new_array);
  $this->session->set_userdata($components_array);*/
  ///////////////////////////////////////////////////////////
  $kit_component = [];
  $kit_component = [
                "update_categri_id"=>$cat_id,
                "update_catalog_mt_id"=>$catalogue_mt_id,
                "update_catag_id"=>$dynamic_cata_id,
                "update_part_ids"=>$partsCatalgid,
                "update_comp_name"=>$compName,
                "update_comp_qty"=>$compQty,
                "update_comp_avg_price"=>$compAvgPrice,
                "update_comp_amount"=>$compAmount,
                "update_estAmount"=>$estAmount,
                "update_ebay_fees"=>$ebay_fee,
                "update_paypal_fees"=>$paypal_fee,
                "update_ship_fees"=>$ship_fee,
                "update_sub_totals"=>$sub_total,
                "update_condition_id"=>$tech_condition
              ];
   $selected_comp = $this->session->set_userdata($kit_component);
   //return 1;
  $all_selected = $this->session->userdata($selected_comp);
  echo "<pre>";
  print_r($all_selected);
  exit;

}

/*=================================================
=            update seller description            =
=================================================*/

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
  // $sql = $sql->re
}
public function estimate_detail(){
  $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
     $components = $this->db2->query("SELECT M.LZ_BD_ESTIMATE_ID, D.TECH_COND_ID, D.MPN_DESCRIPTION, DECODE(D.TECH_COND_ID, 1000, 'NEW', 1500, 'NEW OTHER (SEE DETAILS)', 2000, 'MANUFACTURER REFURBISHED', 2500, 'SELLER REFURBISHED', 3000, 'USED', 7000, 'FOR PARTS OR NOT WORKING') COND_NAME, regexp_replace(regexp_replace(O.OBJECT_NAME, '&', 'AND'), '/', ' OR ') OBJECT_NAME, C.MPN, D.MPN_DESCRIPTION, M.LZ_BD_CATAG_ID, D.LZ_ESTIMATE_DET_ID, D.MPN_KIT_MT_ID, D.PART_CATLG_MT_ID, D.QTY, D.EST_SELL_PRICE, D.PAYPAL_FEE, D.EBAY_FEE, D.SHIPPING_FEE, D.SOLD_PRICE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ESTIMATE_DET D, LZ_CATALOGUE_MT C , LZ_BD_OBJECTS_MT O WHERE M.LZ_BD_ESTIMATE_ID = D. LZ_BD_ESTIMATE_ID AND D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND C.OBJECT_ID = O.OBJECT_ID AND M.LZ_BD_CATAG_ID = $lz_bd_cata_id ORDER BY MPN_KIT_MT_ID ASC ")->result_array();
     $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
     return array('result' =>$components, 'conditions' =>$conditions );
  // $sql = $sql->re
}
 public function createObject(){
    $obj_val = $this->input->post('new_object');
    $bd_category = $this->input->post('bd_category');
    $obj_val = strtoupper($obj_val);
    $obj_val = trim(str_replace("  ", ' ', $obj_val));
    $obj_val = trim(str_replace(array("'"), "''", $obj_val));

    $insert_by = $this->session->userdata('user_id');

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    // $get_mt_pk = $this->db2->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
    //     $get_pk = $get_mt_pk->result_array();
    //     $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

    $checkQry = $this->db2->query("SELECT OBJECT_ID,OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE OBJECT_NAME = '$obj_val' AND CATEGORY_ID = $bd_category");
    if($checkQry->num_rows()>0){
      return 0;
    }else{
      //$obj_id = $this->db2->query("SELECT get_single_primary_key('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
      $obj_id = $this->db2->query("SELECT get_single_primary_key('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
      $get_mt_pk = $obj_id->result_array();
      $object_id = $get_mt_pk[0]['OBJECT_ID'];

      $qry = "INSERT INTO LZ_BD_OBJECTS_MT O (OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID) VALUES($object_id, '$obj_val',$insert_date,$insert_by, $bd_category)";
      $this->db2->query($qry);
      return 1;
    }

    
  }

    public function addRssUrls(){

    $feedName                 = $this->input->post('feedName');
    $feedName                 = trim(str_replace("  ", ' ', $feedName));
    $feedName                 = str_replace(array("`,′"), "", $feedName);
    $feedName                 = str_replace(array("'"), "''", $feedName);
    $keyword                  = $this->input->post('keyword');
    $keyword                  = trim(str_replace("  ", ' ', $keyword));
    $keyword                  = str_replace(array("`,′"), "", $keyword);
    $keyword                  = str_replace(array("'"), "''", $keyword);
    $excludedWords            = $this->input->post('excludedWords');
    $excludeWord              = trim(str_replace("  ", ' ', $excludedWords));
    $excludedWords            = str_replace(array("`,′"), "", $excludeWord);
    $excludeWord              = str_replace(array("'"), "''", $excludedWords);
    $category_id              = $this->input->post('category_id');
    $catalogue_mt_id          = $this->input->post('catalogue_mt_id');
    $rss_feed_cond            = $this->input->post('rss_feed_cond');
    $rss_listing_type         = $this->input->post('rss_listing_type');
    $min_price                = 1;
    $max_price                = 1;
    //var_dump($feedName, $keyword, $excludedWords, $category_id, $catalogue_mt_id, $rss_feed_cond, $rss_listing_type); exit;
    $created_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $created_date = date("Y-m-d H:i:s");
    $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $exclude_words = '';

     if (strpos($excludeWord, ',') !== false) {
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

    $auto_created = 0;
     //var_dump($keyword, $exclude_words, $category_id, $catalogue_mt_id, $rss_feed_cond, $rss_listing_type, $min_price, $max_price);
     //exit;

    $pro_call = $this->db2->query(" call pro_verified_mpn_feed_url('$keyword','$catalogue_mt_id','$category_id','$feedName','$rss_feed_cond','$min_price','$max_price','$rss_listing_type','$created_by',$created_date,'$exclude_words',$auto_created, '', '', '', '', 30)");
    if($pro_call){

      $get_feed_id = $this->db2->query("SELECT FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE CATEGORY_ID = $category_id AND CONDITION_ID = $rss_feed_cond AND CATLALOGUE_MT_ID = $catalogue_mt_id AND LISTING_TYPE = '$rss_listing_type'")->result_array();

      $url_feed_id = $get_feed_id[0]['FEED_URL_ID'];
      $dir = explode('\\', __DIR__);
      $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
      if(!empty($url_feed_id)){
        
        $path = $base_url."/liveRssFeed/lookupFeed/".$url_feed_id.".bat";
        //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";
        if(!is_dir(@$path)){
          $fileData = "@ECHO\nD:\ncd ".$base_url."\nphp index.php cron_job c_cron_job lookup_feed ".$url_feed_id."\nPAUSE";
          $myfile = fopen($path, "w") ;
          fwrite($myfile, $fileData);
          fclose($myfile);
        }
      }else{
            $cat_id = $this->input->post('category_id');
            $path = $base_url."/liveRssFeed/".$cat_id."LiveFeed.bat";
            if(!is_dir(@$path)){
              $fileData = "@ECHO\nD:\ncd ".$base_url."\nphp index.php cron_job c_cron_job cat_rss_feed ".$cat_id."\nPAUSE";
              $myfile = fopen($path, "w") ;
              fwrite($myfile, $fileData);
              fclose($myfile);
            }
      }
      
      return true;
    }else{
      return false;
    }
  }
  public function getRssUrlData(){
    $condition_id = $this->input->post('condition_id');
    $rss_mpn_id   = $this->input->post('rss_mpn_id');
    $rss_cat_id   = $this->input->post('rss_cat_id');
    $created_by = $this->session->userdata('user_id');
    //var_dump($condition_id, $rss_mpn_id, $rss_cat_id); exit;
    $urls = $this->db2->query("SELECT G.FEED_URL_ID, G.FEED_NAME, G.KEYWORD, G.LISTING_TYPE, G.EXCLUDE_WORDS FROM LZ_BD_RSS_FEED_URL G WHERE G.CATEGORY_ID = $rss_cat_id AND G.CONDITION_ID = $condition_id AND G.CATLALOGUE_MT_ID = $rss_mpn_id AND G.CREATED_BY = $created_by")->result_array();
    if (count($urls) > 0) {
      $res = 1;
      return array('res'=>$res, 'urls'=>$urls);
    }else{
      $res = 0;
       return array('res'=>$res, 'urls'=>$urls);
    }
   
     }

  public function updateRssUrl(){
    $feedurlid = $this->input->post('feed_url_id');
    $feedName = $this->input->post('feedName');
    $feedName = trim(str_replace("  ", ' ', $feedName));
    $feedName = str_replace(array("`,′"), "", $feedName);
    $feedName = str_replace(array("'"), "''", $feedName);
    $keyWord = $this->input->post('keyword');
    $keyWord = trim(str_replace("  ", ' ', $keyWord));
    $keyWord = str_replace(array("`,′"), "", $keyWord);
    $keyWord = str_replace(array("'"), "''", $keyWord);
    $excludeWord = $this->input->post('excludedWords');
    $excludeWord = trim(str_replace("  ", ' ', $excludeWord));
    $excludeWord = str_replace(array("`,′"), "", $excludeWord);
    $excludeWord = str_replace(array("'"), "''", $excludeWord);
    
    $category_id = $this->input->post('category_id');
    $catalogue_mt_id = $this->input->post('catalogue_mt_id');
    $rss_feed_cond = $this->input->post('rss_feed_cond');
    $rss_listing_type = $this->input->post('rss_listing_type');
    //var_dump($feedName, $keyWord, $excludeWord, $category_id, $catalogue_mt_id, $rss_feed_cond, $rss_listing_type); exit;
    $exclude_words = '';
    
    if (strpos($excludeWord, ',') !== false) {
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



    $min_price = 1;
    $max_price = 1;
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



    $qry = $this->db2->query("UPDATE LZ_BD_RSS_FEED_URL SET RSS_FEED_URL= '$lvar_final_url', FEED_NAME = '$feedName', KEYWORD = '$keyWord' , MIN_PRICE = $min_price , MAX_PRICE = $max_price ,EXCLUDE_WORDS = '$exclude_words', UPDATE_BY = $update_by, UPDATE_DATE =  $update_date  WHERE  FEED_URL_ID = $feedurlid"); 
   //$qry = $qry->result_array();
    return $qry;
  }
/*=====  End of update seller description  ======*/

}
