
<?php  
  class M_Purchasing_copy extends CI_Model{

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
  public function showUnverifiedData($cat_id){
    $sess_data = array("unverify_List_type"=>"All", "unverify_condition"=>"All");
    $this->session->set_userdata($sess_data);

    /*$mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN");
    $mpn = $mpn->result_array();*/

    $unverified = $this->db2->query("SELECT *  FROM LZ_BD_ACTIVE_DATA_$cat_id BD WHERE BD.VERIFIED = 0");
    $detail = $unverified->result_array();
    
    $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();
    $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

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
      19 => 'PROF%'
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

    $listingType = $this->session->userdata('unverify_List_type');
      $condition   = $this->session->userdata('unverify_condition');
      $seller_id   = $this->session->userdata('seller');
      $mpn   = $this->session->userdata('mpn');
      $fed_one         = $this->session->userdata('fed_one');
      $fed_two         = $this->session->userdata('fed_two');
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
      19 => 'PROF%'
      
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

      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      // $seller =$this->db2->query("SELECT SELLER_ID, SELLER_ID || ' (' || COUNT(SELLER_ID) || ')' SELLER_NAME FROM all_active_data_view BD, LZ_CATALOGUE_MT M, mpn_avg_price av WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.SALE_TIME > SYSDATE - 1 and BD.VERIFIED = 1 and m.mpn is not null GROUP BY SELLER_ID") ->result_array();

    $flag_id = "SELECT FLAG_ID ,FLAG_NAME FROM LZ_BD_PURCHASING_FLAG ORDER BY FLAG_ID";
    $flag_id = $this->db->query($flag_id)->result_array();


    $cattegory = "SELECT distinct D.CATEGORY_ID, K.CATEGORY_NAME || '-' || D.CATEGORY_ID || ' (' || count_mpn.mpn ||')' CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY K,(select category_id cat_id ,count(mpn) mpn,category_id from lz_catalogue_mt group by category_id) count_mpn WHERE D.CATEGORY_ID = K.CATEGORY_ID and K.CATEGORY_ID = count_mpn.cat_id and d.lz_bd_group_id = 1";

    // $cate_name = $this->db2->query(" SELECT CATEGORY_NAME || '-' || CATEGORY_ID  CATEGORY_NAME from LZ_BD_CATEGORY where CATEGORY_ID = $cat_id group by category_name,category_id")->result_array();

    // ,'cate_name' => $cate_name

    $cattegory = $this->db2->query($cattegory);
    $cattegory = $cattegory->result_array();

      return array('list_types' => $list_types, 'conditions' => $conditions , 'cattegory' => $cattegory,'flag_id' => $flag_id);
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
 public function loadPurchDetail() {
    $requestData = $_REQUEST;
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
      9 => 'SALE_PRICE',
      10 => 'AVERAGE_PRICE',
      11 => 'LIST_SOLD',
      12 => 'QTY_SOLD',
      13 => 'KIT_SELLING',
      14 => 'P',
      15 => 'KIT_PERCENT',
      16 => 'SALE_PRICE',
      17 => 'EST_PRICE',
      18 => 'ASSSEMBLY_SELLING',
      19 =>'ASSEM_PROFIT_$',
      20 =>'ASSEMBLY_PROFIT_PERC',
      35 =>'LEN'

          
    );

    $sql = "SELECT FLAG_ID, LZ_BD_CATA_ID, VERIFIED, AVERAGE_PRICE, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SALE_PRICE + SHIPPING_COST SALE_PRICE, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST),0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, SALE_PRICE + + SHIPPING_COST KIT_LIST, EST_PRICE, EST_EBAY_FEE, EST_PAYPAL_FEE, EST_SHIP_FEE, EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE ASSSEMBLY_SELLING, NVL(ROUND(DECODE(EST_PRICE, 0, 0, EST_PRICE - (SALE_PRICE + SHIPPING_COST + EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)), 2), 0) ASSEM_PROFIT_$, NVL(ROUND(DECODE(EST_PRICE, 0, 0, (EST_PRICE - (SALE_PRICE + SHIPPING_COST +  EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)) / EST_PRICE * 100), 2), 0) ASSEMBLY_PROFIT_PERC, ROUND(NVL(EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE, 0), 2) TOTAL_1 FROM (SELECT BD.FLAG_ID, BD.VERIFIED, NVL(BD.SHIPPING_COST, 0) SHIPPING_COST, BD.LZ_BD_CATA_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, AV.QTY_SOLD, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE, /*ASSEMBLY ITEMS CALCULATIONS*/ NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) KIT, DECODE(NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0), 0, NVL((SELECT NVL(SUM(M.AVG_PRICE), 0) FROM LZ_BD_MPN_KIT_MT P, MPN_AVG_PRICE M WHERE P.PART_CATLG_MT_ID = M.CATALOGUE_MT_ID AND PART_CATLG_MT_ID = BD.CATALOGUE_MT_ID GROUP BY PART_CATLG_MT_ID), 0), NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0)) EST_PRICE, NVL((SELECT SUM(DE.EBAY_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_EBAY_FEE, NVL((SELECT SUM(DE.PAYPAL_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_PAYPAL_FEE, NVL((SELECT SUM(DE.SHIPPING_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_SHIP_FEE /* ROUND(NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + DET.EST_SHIP_FEE, 0), 2) TOTAL, ROUND(NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + 3.25, 0), 2) TOTAL_1*/ FROM ALL_ACTIVE_DATA_VIEW BD, MPN_AVG_PRICE        AV, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND (BD.FLAG_ID <> 20 AND BD.FLAG_ID <> 24 OR BD.FLAG_ID IS NULL) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATEGORY_ID = 111422 AND BD.START_TIME >= SYSDATE - 3 ORDER BY EST_PRICE DESC) INER_TAB "; 


    if( !empty($requestData['search']['value']) ) {// if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" where ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
          // $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR START_TIME LIKE '%".$requestData['search']['value']."%' ";
          // $sql.=" OR SALE_TIME LIKE '%".$requestData['search']['value']."%' )";
          // $sql.=" OR FEEDBACK_SCORE LIKE '%".$requestData['search']['value']."%') ";
      }else{
        if(!empty($requestData['search']['value'])){
           // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" where ( EBAY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR MPN LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR SELLER_ID LIKE '%".$requestData['search']['value']."%' "; 
          $sql.=" OR LISTING_TYPE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR CONDITION_NAME LIKE '%".$requestData['search']['value']."%' )"; 
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

    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $flags = $this->db2->query("SELECT * FROM LZ_BD_PURCHASING_FLAG order by flag_id")->result_array();
   /* echo "<pre>";
    print_r($flags);
    exit;*/

    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();

     
      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank'>".@$row['EBAY_ID']."</a>";
       $nestedData[] =  '<div class="pull-right" style="width:250px;">'.$row['TITLE'].'</div>';
      $flag_id = $row['FLAG_ID']; 
      $lz_cat_id = $row['CATEGORY_ID']; 
      //$kit_flag= $this->session->userdata("ctc_kit_flag"); 
      /*echo "<pre>";
      print_r($flags);
      exit;*/
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

      $fid_0 =$flags[0]['FLAG_ID'];
      $fid_1 =$flags[1]['FLAG_ID'];
      $fid_2 =$flags[2]['FLAG_ID'];
      $fid_3 =$flags[3]['FLAG_ID'];
      $fid_4 =$flags[4]['FLAG_ID'];
      $fid_5 =$flags[5]['FLAG_ID'];
      $fid_6 =$flags[6]['FLAG_ID'];

      $thumb_up_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_0; 
      $thumb_down_id              = $row['LZ_BD_CATA_ID'].'_'.$fid_2;
      $female_id                  = $row['LZ_BD_CATA_ID'].'_'.$fid_3;
      $trash_id                   = $row['LZ_BD_CATA_ID'].'_'.$fid_1;
      $flag_usd_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_4;
      $flag_discard_mpn_id        = $row['LZ_BD_CATA_ID'].'_'.$fid_5;
      $bidding_flag_id            = $row['LZ_BD_CATA_ID'].'_'.$fid_6;

        $discrad_msg= "return confirm('Are you sure to discard?')";

       $nestedData[] = '<div style="width: 200px;"> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="high_button m-3 '.$thumb_up.'" style="float: left;" id="'.$thumb_up_id.'"> <button title="Higly Interested" class="btn btn-success btn-xs high-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_0.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-up text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="less_button m-3 '.$thumb_down.'" style="float: left;" id="'.$thumb_down_id.'"> <button title="Less Interested" class="btn btn-primary btn-xs less-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_2.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-down text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="female_button m-3 '.$female.'" style="float: left;" id="'.$female_id.'"> <button title="Refer to Patica" class="btn btn-info btn-xs flag-female" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_3.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-female text text-center" aria-hidden="true"></i> </button> </div> <div class="trash_button m-3 '.$trash.'" style="float: left;" id="'.$trash_id.'"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;"  id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_1.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-trash-o text text-center" aria-hidden="true"></i> </button> </div> </div> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="usd_button m-3 '.$flag_usd.'" style="float: left;" id="'.$flag_usd_id .'"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_4.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-usd text text-center" aria-hidden="true" ></i> </button></div> <div class="usd_button m-3 '.$discard_mpn.'" style="float: left;" id="'.$flag_discard_mpn_id.'"> <button title="Discard MPN" onclick="'.$discrad_msg.'" class="btn btn-primary btn-xs fa-discard-mpn" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_5.'" ct_id="'.$lz_cat_id.'" mpn_id="'.$row['CATALOGUE_MT_ID'].'"><i class="fa fa-ban" aria-hidden="true" ></i> </button></div> <div class="usd_button m-3 '.$bidding_flag.'" style="float: left;" id="'.$bidding_flag_id.'"> <button title="Bidding" class="btn  btn-xs flag-bidding" style="width: 25px; background-color: #FFFFCC; border-color: black; color: black;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_6.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-gavel fa-bidding" aria-hidden="true" ></i> </button></div> </div> </div>';



       $nestedData[] = $row['SELLER_ID'];
      //var_dump($row['FLAG_ID']);
      
      $nestedData[] = '<div class="pull-right text text-center" style="width:130px;">'.$row['FEEDBACK_SCORE'].'     <i class="fa fa-star" aria-hidden="true" style="color: #008d4c;
    font-size:18px;"></i></div>';
      $nestedData[] = $row['LISTING_TYPE'];
      $nestedData[] = '<div class="pull-right text text-center" style="width:130px;">'.$row['TIME_DIFF'].'</div>';
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['CONDITION_NAME'];

      
      
        /////// COMPONENT ITEMS /////////
      //$SALE_PRICE =$row['SALE_PRICE'];
      $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px; font-weight:700; width:100px;">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>';        /// ACTIVE PRICE
      $nestedData[] ='<div class="pull-right text text-center" style="width:80px;">$ '. number_format((float)@$row['AVERAGE_PRICE'],2,'.',',').'</div>';       ///// SOLD AVG
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['LIST_SOLD'],2,'.',',').'</div>';    /// LIST SOLD

      $nestedData[] ='<div class="pull-right text text-center" style="color:blue; font-size:17px;  font-weight:700; width:120px;">'. number_format((float)@$row['QTY_SOLD'],0,'.',',').'</div>';  /// /QTY_SOLD

    
     
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['KIT_SELLING'],2,'.',',').'</div>';   /// AMOUNT

      $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px;  font-weight:700; width:100px;">$ '. number_format((float)@$row['P'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;">'. number_format((float)@$row['KIT_PERCENT'],2,'.',',').' %</div>';

      //////////////////////////////////

      /////// ASSEMBLY ITEMS /////////
          /// SELLING
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;" >$ '. number_format((float)@$row['KIT_LIST'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;" >$ '. number_format((float)@$row['EST_PRICE'],2,'.',',').'</div>';    /// KIT
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['ASSSEMBLY_SELLING'],2,'.',',').'</div>';   /// SELLING
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['ASSEM_PROFIT_$'],2,'.',',').'</div>';    /// %2
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;">'. number_format((float)@$row['ASSEMBLY_PROFIT_PERC'],2,'.',',').' %</div>';   /// AMOUNT CALULATION PENDING
          /// %1


     

      $nestedData[] = ''; ///status
      $nestedData[] = ''; //// bid status
      $nestedData[] = ''; ///// bid offer

      $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
      $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
      $category_id  =     $row['CATEGORY_ID'];
      $catalogue_mt_id  =     $row['CATALOGUE_MT_ID'];
      if(empty($lz_estimate_id)){
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> ';
      }
      $ct_tracking_no = $row['TRACKING_NO'];
      

      $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.@$ct_tracking_no.'" style="width:200px;"> </div>'; //// tracking no input field 

      $cost_price = $row['COST_PRICE'];
      if(empty($row['TRACKING_NO'])){
        $nestedData[] ='<div style="width: 160px;">  <input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Save MPN Data"  class="btn btn-primary btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">Save</button> </div></div>';
         }else {
       $nestedData[] = '<div style="width: 160px;"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Update MPN Data"  class="btn btn-success btn-xs update_mpn_data" id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">Update</button> </div> </div>';
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
      9 => 'SALE_PRICE',
      10 => 'AVERAGE_PRICE',
      11 => 'LIST_SOLD',
      12 => 'QTY_SOLD',
      13 => 'KIT_SELLING',
      14 => 'P',
      15 => 'KIT_PERCENT',
      16 => 'SALE_PRICE',
      17 => 'EST_PRICE',
      18 => 'ASSSEMBLY_SELLING',
      19 =>'ASSEM_PROFIT_$',
      20 =>'ASSEMBLY_PROFIT_PERC',
      35 =>'LEN'

          
    );
    

    $sql = "SELECT * FROM (SELECT FLAG_ID, LZ_BD_CATA_ID, VERIFIED, AVERAGE_PRICE, CATALOGUE_MT_ID, TIME_DIFF, LENGTH(TITLE) LEN, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, EBAY_ID, ITEM_URL, TITLE, SELLER_ID, NVL(FEEDBACK_SCORE, 0) FEEDBACK_SCORE, LISTING_TYPE, CONDITION_ID, CONDITION_NAME, MPN, TRACKING_NO, TRACKING_ID, LZ_ESTIMATE_ID, COST_PRICE, SALE_PRICE + SHIPPING_COST SALE_PRICE, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST),0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + SHIPPING_COST + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, SALE_PRICE + SHIPPING_COST KIT_LIST, EST_PRICE, EST_EBAY_FEE, EST_PAYPAL_FEE, EST_SHIP_FEE, EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE ASSSEMBLY_SELLING, NVL(ROUND(DECODE(EST_PRICE, 0, 0, EST_PRICE - (SALE_PRICE + SHIPPING_COST + EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)), 2), 0) ASSEM_PROFIT_$, NVL(ROUND(DECODE(EST_PRICE, 0, 0, (EST_PRICE - (SALE_PRICE + SHIPPING_COST +  EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE)) / EST_PRICE * 100), 2), 0) ASSEMBLY_PROFIT_PERC, ROUND(NVL(EST_EBAY_FEE + EST_PAYPAL_FEE + EST_SHIP_FEE, 0), 2) TOTAL_1 FROM (SELECT BD.FLAG_ID,nvl(bd.SHIPPING_COST, 0) SHIPPING_COST, BD.VERIFIED, BD.LZ_BD_CATA_ID, nvl(AV.AVG_PRICE,0) AVERAGE_PRICE,AV.QTY_SOLD, BD.CATALOGUE_MT_ID, TO_CHAR(TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (BD.SALE_TIME - SYSDATE)) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (BD.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (BD.SALE_TIME - SYSDATE)) / 60))) || ' S ' TIME_DIFF, BD.CATEGORY_ID, BD.EBAY_ID, BD.ITEM_URL, BD.TITLE, BD.SELLER_ID, NVL(BD.FEEDBACK_SCORE, 0) FEEDBACK_SCORE, BD.LISTING_TYPE, BD.CONDITION_ID, BD.CONDITION_NAME, M.MPN, T.TRACKING_NO, T.TRACKING_ID, T.LZ_ESTIMATE_ID, NVL(T.COST_PRICE, 0) COST_PRICE, BD.SALE_PRICE, /*ASSEMBLY ITEMS  CALCULATIONS*/ NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) KIT, DECODE(NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0), 0, NVL((SELECT NVL(SUM(M.AVG_PRICE), 0) FROM LZ_BD_MPN_KIT_MT P, MPN_AVG_PRICE M WHERE P.PART_CATLG_MT_ID = M.CATALOGUE_MT_ID AND PART_CATLG_MT_ID = BD.CATALOGUE_MT_ID GROUP BY PART_CATLG_MT_ID), 0), NVL((SELECT SUM(DE.EST_SELL_PRICE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0)) EST_PRICE, NVL((SELECT SUM(DE.EBAY_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_EBAY_FEE, NVL((SELECT SUM(DE.PAYPAL_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_PAYPAL_FEE, NVL((SELECT SUM(DE.SHIPPING_FEE) FROM LZ_BD_ESTIMATE_DET DE WHERE DE.LZ_BD_ESTIMATE_ID = T.LZ_ESTIMATE_ID), 0) EST_SHIP_FEE /* ROUND(NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + DET.EST_SHIP_FEE, 0), 2) TOTAL, ROUND(NVL(DET.EST_EBAY_FEE + DET.EST_PAYPAL_FEE + 3.25, 0), 2) TOTAL_1*/ FROM ALL_ACTIVE_DATA_VIEW BD, MPN_AVG_PRICE        AV, LZ_CATALOGUE_MT      M, LZ_BD_TRACKING_NO    T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID(+) AND BD.VERIFIED = 1 AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND (BD.FLAG_ID <> 20 AND BD.FLAG_ID <> 24 OR BD.FLAG_ID IS NULL) AND BD.CONDITION_ID = AV.CONDITION_ID(+)";


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
          $sql.="  AND (BD.FLAG_ID <> 20 or BD.FLAG_ID is null)";
        }

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
              $sql.=" AND BD.start_TIME >= SYSDATE - 3";
            }
           
            if(!empty($title_sort)){
              if($title_sort == 1){
            $sql.=" ORDER BY LENGTH(title)  asc";

            }
            if($title_sort == 2){
            $sql.=" ORDER BY LENGTH(title)  desc";

            }

            }
            $sql.=" ) iner_tab)";
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
    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();


      $nestedData[] ="<a href='".@$row['ITEM_URL']."' target='_blank'>".@$row['EBAY_ID']."</a>";
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

      $fid_0 =$flags[0]['FLAG_ID'];
      $fid_1 =$flags[1]['FLAG_ID'];
      $fid_2 =$flags[2]['FLAG_ID'];
      $fid_3 =$flags[3]['FLAG_ID'];
      $fid_4 =$flags[4]['FLAG_ID'];
      $fid_5 =$flags[5]['FLAG_ID'];
      $fid_6 =$flags[6]['FLAG_ID'];

      $thumb_up_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_0; 
      $thumb_down_id              = $row['LZ_BD_CATA_ID'].'_'.$fid_2;
      $female_id                  = $row['LZ_BD_CATA_ID'].'_'.$fid_3;
      $trash_id                   = $row['LZ_BD_CATA_ID'].'_'.$fid_1;
      $flag_usd_id                = $row['LZ_BD_CATA_ID'].'_'.$fid_4;
      $flag_discard_mpn_id        = $row['LZ_BD_CATA_ID'].'_'.$fid_5;
      $bidding_flag_id            = $row['LZ_BD_CATA_ID'].'_'.$fid_6;

       $discrad_msg= "return confirm('Are you sure to discard?')";

       $nestedData[] = '<div style="width: 200px;"> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="high_button m-3 '.$thumb_up.'" style="float: left;" id="'.$thumb_up_id.'"> <button title="Higly Interested" class="btn btn-success btn-xs high-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_0.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-up text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="less_button m-3 '.$thumb_down.'" style="float: left;" id="'.$thumb_down_id.'"> <button title="Less Interested" class="btn btn-primary btn-xs less-interest" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_2.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-thumbs-o-down text text-center" aria-hidden="true" style="width: 15px;"></i> </button> </div> <div class="female_button m-3 '.$female.'" style="float: left;" id="'.$female_id.'"> <button title="Refer to Patica" class="btn btn-info btn-xs flag-female" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_3.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-female text text-center" aria-hidden="true"></i> </button> </div> <div class="trash_button m-3 '.$trash.'" style="float: left;" id="'.$trash_id.'"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;"  id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_1.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-trash-o text text-center" aria-hidden="true"></i> </button> </div> </div> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="usd_button m-3 '.$flag_usd.'" style="float: left;" id="'.$flag_usd_id .'"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_4.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-usd text text-center" aria-hidden="true" ></i> </button></div> <div class="usd_button m-3 '.$discard_mpn.'" style="float: left;" id="'.$flag_discard_mpn_id.'"> <button title="Discard MPN" onclick="'.$discrad_msg.'" class="btn btn-primary btn-xs fa-discard-mpn" style="width: 25px;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_5.'" ct_id="'.$lz_cat_id.'" mpn_id="'.$row['CATALOGUE_MT_ID'].'"><i class="fa fa-ban" aria-hidden="true" ></i> </button></div> <div class="usd_button m-3 '.$bidding_flag.'" style="float: left;" id="'.$bidding_flag_id.'"> <button title="Bidding" class="btn  btn-xs flag-bidding" style="width: 25px; background-color: #FFFFCC; border-color: black; color: black;" id = "'.$row['LZ_BD_CATA_ID'].'" fid="'.$fid_6.'" ct_id="'.$lz_cat_id.'"><i class="fa fa-gavel fa-bidding" aria-hidden="true" ></i> </button></div> </div> </div>';

      $nestedData[] = $row['SELLER_ID'];
      //var_dump($row['FLAG_ID']);
      $nestedData[] = '<div class="pull-right text text-center" style="width:130px;">'.$row['FEEDBACK_SCORE'].'     <i class="fa fa-star" aria-hidden="true" style="color:#008d4c;
    font-size:18px;"></i></div>';
      $nestedData[] = $row['LISTING_TYPE'];
     $nestedData[] = '<div class="pull-right text text-center" style="width:130px;">'.$row['TIME_DIFF'].'</div>';
      $nestedData[] = $row['MPN'];
      $nestedData[] = $row['CONDITION_NAME'];

      
        /////// COMPONENT ITEMS /////////
      //$SALE_PRICE =$row['SALE_PRICE'];
      $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px; font-weight:700; width:100px;">$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',').'</div>';        /// ACTIVE PRICE
      $nestedData[] ='<div class="pull-right text text-center" style="width:80px;">$ '. number_format((float)@$row['AVERAGE_PRICE'],2,'.',',').'</div>';       ///// SOLD AVG
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['LIST_SOLD'],2,'.',',').'</div>';    /// LIST SOLD


      $nestedData[] ='<div class="pull-right text text-center" style="color:blue; font-size:17px;  font-weight:700; width:100px;">'. number_format((float)@$row['QTY_SOLD'],0,'.',',').'</div>';  /// /QTY_SOLD
     
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['KIT_SELLING'],2,'.',',').'</div>';   /// AMOUNT

      $nestedData[] = '<div class="pull-right text text-center" style="color:red; font-size:17px;  font-weight:700; width:100px;">$ '. number_format((float)@$row['P'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;">'. number_format((float)@$row['KIT_PERCENT'],2,'.',',').' %</div>';

      //////////////////////////////////

      /////// ASSEMBLY ITEMS /////////
          /// SELLING
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['KIT_LIST'],2,'.',',').'</div>';
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;">$ '. number_format((float)@$row['EST_PRICE'],2,'.',',').'</div>';    /// KIT
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;">$ '. number_format((float)@$row['ASSSEMBLY_SELLING'],2,'.',',').'</div>';   /// SELLING
      $nestedData[] = '<div class="pull-right" >$ '. number_format((float)@$row['ASSEM_PROFIT_$'],2,'.',',').'</div>';    /// %2
      $nestedData[] = '<div class="pull-right text text-center" style="width:80px;">'. number_format((float)@$row['ASSEMBLY_PROFIT_PERC'],2,'.',',').' %</div>';   /// AMOUNT CALULATION PENDING
          /// %1


     

      $nestedData[] = ''; ///status
      $nestedData[] = ''; //// bid status
      $nestedData[] = ''; ///// bid offer

      $lz_estimate_id =   $row['LZ_ESTIMATE_ID'];
      $lz_bd_cata_id  =   $row['LZ_BD_CATA_ID'];
      $category_id  =     $row['CATEGORY_ID'];
      
      $catalogue_mt_id  =     $row['CATALOGUE_MT_ID'];

      if(empty($lz_estimate_id)){
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> ';
      }
      $ct_tracking_no = $row['TRACKING_NO'];
      

      $nestedData[] = '<div class="form-group"> <input type="text" name="ct_tracking_no_'.$i.'" id="ct_tracking_no_'.$i.'" class="form-control input-sm ct_tracking_no" value="'.@$ct_tracking_no.'" style="width:200px;"> </div>'; //// tracking no input field 

      $cost_price = $row['COST_PRICE'];
      if(empty($row['TRACKING_NO'])){
        $nestedData[] ='<div style="width: 160px;">  <input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Save MPN Data"  class="btn btn-primary btn-xs save_tracking_no" id="'.$i.'" style="height: 28px; margin-bottom: auto;">Save</button> </div></div>';
         }else {
       $nestedData[] = '<div style="width: 160px;"><input type="text" name="ct_cost_price_'.$i.'" id="ct_cost_price_'.$i.'" class="form-control input-sm ct_cost_price" value="'.$cost_price.'" style="width:100px;"> <div class="pull-right"> <button type="button" title="Update MPN Data"  class="btn btn-success btn-xs update_mpn_data" id="'.$i.'" tId="'.@$row['TRACKING_ID'].'" style="height: 28px; margin-bottom: auto;">Update</button> </div> </div>';
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
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> ';
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
      $nestedData[] =  '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/kitComponents/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id="" class="" title="Show Mpn">KIT VIEW</a> </div>';
      }else {
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm" href="'.base_url()."catalogueToCash/c_purchasing_copy/updateEstimate/".$category_id."/".$catalogue_mt_id."/".$lz_bd_cata_id.'" id=""  title="Show Mpn">UPDATE KIT</a> </div> ';
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
 
   public function resetUnVerifyDropdown(){

     $cat_id = $this->input->post('cat_id');

     $this->session->unset_userdata('Search_category');
     // var_dump($this->session->userdata('Search_category')); exit;

     $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();

      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      // $seller =$this->db2->query("SELECT SELLER_ID, SELLER_ID || ' (' || COUNT(SELLER_ID) || ')' SELLER_NAME FROM all_active_data_view BD, LZ_CATALOGUE_MT M, mpn_avg_price av WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID and bd.CATALOGUE_MT_ID = av.catalogue_mt_id and bd.CONDITION_ID = av.condition_id AND BD.SALE_TIME > SYSDATE - 1 and BD.VERIFIED = 1 and m.mpn is not null GROUP BY SELLER_ID") ->result_array();

    $flag_id = "SELECT FLAG_ID ,FLAG_NAME FROM LZ_BD_PURCHASING_FLAG ORDER BY FLAG_ID";
    $flag_id = $this->db->query($flag_id)->result_array();


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

      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

      return array('detail'=>$detail, 'mpn' => $mpn,'list_types' => $list_types, 'conditions' => $conditions);
  }



  public function kitComponents(){
    $cat_id = $this->uri->segment(4); 
    $catalogue_mt_id = $this->uri->segment(5);
     $lz_bd_cata_id = $this->uri->segment(6) ;

    $sess_data = array("catalogue_List_type"=>"All", "catalogue_condition"=>"All");
    $this->session->set_userdata($sess_data);

    //$results = $this->db2->query("SELECT M.MPN_KIT_MT_ID, M.QTY, M.PART_CATLG_MT_ID, O.OBJECT_NAME, GET_AVG_PRICE(MT.CATEGORY_ID,M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT MT, LZ_BD_OBJECTS_MT O WHERE M.PART_CATLG_MT_ID = MT.CATALOGUE_MT_ID AND O.OBJECT_ID = MT.OBJECT_ID AND M.CATALOGUE_MT_ID =$catalogue_mt_id");
    $results = $this->db2->query("SELECT M.*,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME,GET_AVG_PRICE(C.CATEGORY_ID, M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME,GET_AVG_PRICE(C.CATEGORY_ID, MP.CATALOGUE_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");

    $distinct_object_count = $this->db2->query("SELECT distinct O.OBJECT_NAME, count(1)  object_count FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID group by O.OBJECT_NAME UNION ALL SELECT distinct O.OBJECT_NAME, count(1) object_count FROM LZ_BD_MPN_KIT_ALT_MPN MP, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN (SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID = C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID group by O.OBJECT_NAME");
    $object_list = $distinct_object_count->result_array();     
    //$det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, REC.AVERAGE_PRICE, BD.SALE_PRICE - REC.AVERAGE_PRICE AS PRICE_AFTERLIST, T.TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T, (SELECT C.CATALOGUE_MT_ID AS ID, ROUND(AVG(C.SALE_PRICE), 2) AS AVERAGE_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id C WHERE C.CATALOGUE_MT_ID IS NOT NULL GROUP BY C.CATALOGUE_MT_ID) REC WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND M.CATALOGUE_MT_ID = REC.ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id");
    
    $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND BD.LZ_BD_CATA_ID =$lz_bd_cata_id"); 
    $detail = $det_qry->result_array();

    /*$mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN");
    $mpn = $mpn->result_array();*/
   
    $mpn = $this->db2->query("SELECT DISTINCT BD.CATALOGUE_MT_ID,C.MPN ,COUNT(1) CAT_COUNT FROM LZ_BD_ACTIVE_DATA_$cat_id BD,LZ_CATALOGUE_MT C WHERE BD.CATALOGUE_MT_ID IS NOT NULL AND BD.CATALOGUE_MT_ID = C.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id GROUP BY BD.CATALOGUE_MT_ID,C.MPN"); 
    $mpn = $mpn->result_array();

    $list_types = $this->db2->query("SELECT LISTING_TYPE FROM LZ_BD_LISTING_TYPES")->result_array();
    $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
    /*echo "<pre>";
      print_r($results->result_array());
      exit;*/
      return array("results"=>$results, "detail"=>$detail, "mpn"=>$mpn, "list_types"=>$list_types, "conditions"=>$conditions, "object_list"=>$object_list);

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
    $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
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
    $dynamic_cata_id=$this->input->post('dynamic_cata_id');
    //var_dump($cat_id, $catalogue_mt_id, $dynamic_cata_id); exit;
    $partsCatalgid = $this->input->post('partsCatalgid');
    $compName=$this->input->post('compName');
    $compQty=$this->input->post('compQty');

    $compAvgPrice=$this->input->post('compAvgPrice');
    $compAvgPrice = str_replace("$", "", $compAvgPrice);
    
    $compAmount=$this->input->post('compAmount');
    $compAmount = str_replace("$ ", "", $compAmount);

    $ebayFee=$this->input->post('ebayFee');
    $ebayFee = str_replace("$ ", "", $ebayFee);

    $payPalFee=$this->input->post('payPalFee');
    $payPalFee = str_replace("$ ", "", $payPalFee);

    $shipFee=$this->input->post('shipFee');
    $shipFee = str_replace("$ ", "", $shipFee); 

    $tech_condition=$this->input->post('tech_condition');
    
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $estimate_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    //var_dump($compAvgPrice, $compAmount, $ebayFee, $payPalFee, $shipFee); exit;

    $user_id = $this->session->userdata('user_id');
    //var_dump($estimate_date, $dynamic_cata_id);exit;
    if (!empty($user_id)) {
      $check_catalogue = $this->db2->query("SELECT LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT WHERE LZ_BD_CATAG_ID = $dynamic_cata_id");
      if ($check_catalogue->num_rows() > 0) {
        return 0;
      }else {
        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
          $lz_estimate_id = $rs[0]['ID'];
        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id, $dynamic_cata_id, $estimate_date, $user_id)");
      if ($insert_est_mt) {
        $i=0;
        foreach ($compName as $comp) {
          $component = trim($comp);
          $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
          $rs = $qry->result_array();
            $lz_estimate_det_id = $rs[0]['ID'];
           $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, SOLD_PRICE, PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $lz_estimate_id, $component, $compQty[$i], $compAmount[$i], $ebayFee[$i], $payPalFee[$i], $shipFee[$i], $tech_condition[$i], NULL, NULL, NULL, NULL, $compAvgPrice[$i],$partsCatalgid[$i])");
            if ($insert_est_det) {
              $check_est_id = $this->db->query("SELECT LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO WHERE LZ_BD_CATA_ID = $dynamic_cata_id");
              if ($check_est_id->num_rows() == 0) {
                $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
                $rs = $qry->result_array();
                  $tracking_id = $rs[0]['ID'];
                $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, LZ_ESTIMATE_ID) VALUES($dynamic_cata_id, $cat_id, $tracking_id, $lz_estimate_id)");
                $update_tracking_no = false;
                
              }else {
                $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET  LZ_ESTIMATE_ID = $lz_estimate_id WHERE LZ_BD_CATA_ID = $dynamic_cata_id");
                $insert_tracking_no = false;
              } 
            }
          $i++;
        } /// end foreach
        if($update_tracking_no == true || $insert_tracking_no ==true){
              return 1;
            }else {
                return 2;
              }
      }
      }
      
    } // end main if    
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
      $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (TRACKING_NO, LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, COST_PRICE, DE_KIT_YN) VALUES('$ct_tracking_no', $lz_bd_catag_id, $lz_cat_id, $tracking_id, $ct_cost_price, NULL)");
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
      $conditions = $this->db->query($conditions_qry)->result_array();
    return array('cat_id'=>$cat_id, 'unverify_List_type'=>$unverify_List_type,'unverify_condition'=>$unverify_condition, 'list_types' => $list_types, 'conditions' => $conditions);
  }
  public function deleteResultRow($id){
      $ct_category = $this->input->post('ct_category');
      $table_name = 'LZ_BD_ACTIVE_DATA_'.$ct_category;
      $query = $this->db2->query("UPDATE $table_name SET IS_DELETED = 1 WHERE LZ_BD_CATA_ID = $id");
      if ($query){
        return true;
      }else {
        return false;
      }    
    }

    public function assignCatalogueToKit(){
      $from                = $this->input->post('from_cata_id');
      $to_id               = $this->input->post('to_cata_id');
      $cat_id               = $this->input->post('cat_id');
      $user_id             = $this->session->userdata('user_id');
      $mpn_id              = $this->input->post('mpn_id');
      $estimate_desc       = trim($this->input->post('estimate_desc'));

      $estimate_desc = trim(str_replace('  ',' ', $estimate_desc));
      $estimate_desc = trim(str_replace("'","''", $estimate_desc));
      //echo "<pre>";
      //print_r($to_ids); exit;
            $assign_catalogues = "call PRO_COPY_ESTIMATE_TO_ALL($from, $to_id, $user_id, $mpn_id, '$estimate_desc')";
            $assign = $this->db2->query($assign_catalogues);
            if ($assign) {
              $get_estimates = $this->db2->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.LZ_BD_CATAG_ID = $to_id")->result_array();
              if (count($get_estimates) > 0) {
                $estimate_id = $get_estimates[0]['LZ_BD_ESTIMATE_ID'];
                $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_BD_CATA_ID = $to_id")->result_array();
                if (count($check_tracking_no) > 0) {
                  $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET  LZ_ESTIMATE_ID = $estimate_id WHERE LZ_BD_CATA_ID = $to_id");
                    if($update_tracking_no) {
                        return 1;
                      }else {
                        return 0;
                      }
                }elseif (count($check_tracking_no) == 0) {
                   $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
                    $rs = $qry->result_array();
                      $tracking_id = $rs[0]['ID'];
                    $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, LZ_ESTIMATE_ID) VALUES($to_id, $cat_id, $tracking_id, $estimate_id)");
                    if($insert_tracking_no) {
                        return 1;
                      }else {
                        return 0;
                      }
                } /// end check tracking no
              }else{ ///end get estimate
                return 0;
              }
            }else{
              return 0;
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

     public function updateEstimate(){
      $cat_id = $this->uri->segment(4); 
      $catalogue_mt_id = $this->uri->segment(5);
      $lz_bd_cata_id = $this->uri->segment(6) ;

      $sess_data = array("catalogue_List_type"=>"All", "catalogue_condition"=>"All");
      $this->session->set_userdata($sess_data);

      $results = $this->db2->query("SELECT M.*,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME,GET_AVG_PRICE(C.CATEGORY_ID, M.PART_CATLG_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_MT M,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID UNION ALL SELECT MP.MPN_KIT_ALT_MPN,MP.MPN_KIT_MT_ID,NULL,MP.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, O.OBJECT_NAME,GET_AVG_PRICE(C.CATEGORY_ID, MP.CATALOGUE_MT_ID) AVG_PRICE FROM LZ_BD_MPN_KIT_ALT_MPN MP,LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE MP.MPN_KIT_MT_ID IN(SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $catalogue_mt_id) AND O.OBJECT_ID=C.OBJECT_ID AND C.CATALOGUE_MT_ID = MP.CATALOGUE_MT_ID");
      
      $det_qry = $this->db2->query("SELECT BD.LZ_BD_CATA_ID, BD.CATEGORY_ID, BD.EBAY_ID, BD.TITLE, BD.CONDITION_ID, BD.CONDITION_NAME, BD.SALE_PRICE, M.MPN, UPPER(T.TRACKING_NO) TRACKING_NO, T.TRACKING_ID, T.COST_PRICE FROM LZ_BD_ACTIVE_DATA_$cat_id BD, LZ_CATALOGUE_MT M, LZ_BD_TRACKING_NO T WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND T.LZ_BD_CATA_ID(+) = BD.LZ_BD_CATA_ID AND BD.CATALOGUE_MT_ID = $catalogue_mt_id AND BD.LZ_BD_CATA_ID =$lz_bd_cata_id"); 
      $detail = $det_qry->result_array();

      $components = $this->db2->query("SELECT DISTINCT M.LZ_BD_ESTIMATE_ID, D.TECH_COND_ID,M.LZ_BD_CATAG_ID, D.LZ_ESTIMATE_DET_ID, D.MPN_KIT_MT_ID, D.PART_CATLG_MT_ID,D.QTY, D.EST_SELL_PRICE, D.PAYPAL_FEE, D.EBAY_FEE, D.SHIPPING_FEE, D.SOLD_PRICE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ESTIMATE_DET D WHERE M.LZ_BD_ESTIMATE_ID = D. LZ_BD_ESTIMATE_ID AND M.LZ_BD_CATAG_ID = $lz_bd_cata_id");

      $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();
        // echo "<pre>";
        // print_r($components->result_array());
        // exit;
        return array("results"=>$results, "detail"=>$detail, "components"=>$components, "conditions"=>$conditions);
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
    $catag_id=$this->input->post('catag_id');
    $compName=$this->input->post('compName');
    $compQty=$this->input->post('compQty');
    $tech_condition=$this->input->post('tech_condition');

    $compAvgPrice=$this->input->post('compAvgPrice');
    $compAvgPrice = str_replace("$", "", $compAvgPrice);
    //var_dump( $compAvgPrice ); exit;
    $estimate_price=$this->input->post('estimate_price');
    $estimate_price = str_replace("$ ", "", $estimate_price);

    $ebayFee=$this->input->post('ebayFee');
    $ebayFee = str_replace("$ ", "", $ebayFee);

    $payPalFee=$this->input->post('payPalFee');
    $payPalFee = str_replace("$ ", "", $payPalFee);

    $shipFee=$this->input->post('shipFee');
    $shipFee = str_replace("$ ", "", $shipFee);
    $part_catlg_mt_id = $this->input->post('part_catalogue_mt_id');

    //var_dump($estimate_id, $compAvgPrice, $estimate_price, $ebayFee, $payPalFee, $shipFee); exit;
    //var_dump($estimate_price);exit;

        $check_post = $this->db2->query("SELECT T.LZ_SINGLE_ENTRY_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_BD_CATA_ID = $catag_id");
        $check_post = $check_post->result_array();
        

        if (empty($check_post[0]['LZ_SINGLE_ENTRY_ID'])) {
          //var_dump('in if');exit;
           $get_est_pk = $this->db2->query("DELETE FROM  LZ_BD_ESTIMATE_DET D WHERE D.LZ_BD_ESTIMATE_ID = $estimate_id");
            if ($get_est_pk) {
               $i=0;
                foreach ($compName as $comp) {
                  $component = trim($comp);
                  $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                  $rs = $qry->result_array();
                    $lz_estimate_det_id = $rs[0]['ID'];
                   $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, MPN_KIT_MT_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ACT_QTY_RCVD, SPECIFIC_PIC_YN, LOCATION_ID, TECH_COND_DESC, SOLD_PRICE,PART_CATLG_MT_ID) VALUES($lz_estimate_det_id, $estimate_id, $component, $compQty[$i], $estimate_price[$i], $ebayFee[$i], $payPalFee[$i], $shipFee[$i], $tech_condition[$i], NULL, NULL, NULL, NULL, $compAvgPrice[$i],$part_catlg_mt_id[$i])");
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
  public function get_brands(){
    $object_id = $this->input->post('object_id');
    return $this->db->query("SELECT  DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) ='BRAND' AND CD.DET_ID = D.SPECIFIC_DET_ID AND M.OBJECT_ID = $object_id")->result_array(); 
  }
   public function get_mpns(){
     $brand_name = strtoupper(trim($this->input->post('brand_name')));
     return $this->db->query("SELECT M.CATALOGUE_MT_ID , M.MPN FROM LZ_CATALOGUE_MT M, LZ_CATALOGUE_DET D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID  AND CD.DET_ID = D.SPECIFIC_DET_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND UPPER(CD.SPECIFIC_VALUE) = '$brand_name'")->result_array(); 
  }
  public function createAutoKit(){
    $ct_catlogue_mt_id = $this->input->post('ct_catlogue_mt_id');
    $kitmpnauto = strtoupper(trim($this->input->post('kitmpnauto')));
    $pro_auto_kit = "call PRO_AUTO_KIT_177($ct_catlogue_mt_id, '$kitmpnauto')";
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

}
