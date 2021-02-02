
<?php  
  class M_itemsToEstimate extends CI_Model{

    public function __construct(){
    parent::__construct();
    $this->load->database();

    // var_dump('test');
    // exit;
  }

  /// add component through brands

  public function displayAllData(){

    $get_ebay_id = $this->session->userdata('get_ebay_id');
    $get_ebay_id = trim(str_replace("  ", ' ', $get_ebay_id));
    $get_ebay_id = trim(str_replace(array("'"), "''", $get_ebay_id));

    //if(!empty($get_ebay_id))
    
   

    //$check_ebay = $eb_quer[0]['PURCH_EBAY_ID'];

  // var_dump($check_ebay);
  // exit;
    $requestData = $_REQUEST;

    
    $columns = array( 
    // datatable column index  => database column name
      0 => 'ACTION',
      1 => 'EBAY_ID',
      2 => 'TITLE', 
      3 => 'CATEGORY_ID',
      4 => 'ASSIGN ITEMS',
      5 =>'LOT/KIT', 
      6 => 'CONDITION_NAME',
      7 => 'SALE_PRICE',
      8 => 'TIME_DIFF',
      9 => 'STATUS',
      10 => 'LOT_OFFER_AMOUNT',
      11 => 'INSERTED_DATE',
      12 => 'PLACE BID/OFFER',
      13 => 'SELLER_ID',
      14 => 'ESTIMATE_TIME',
      15 => 'FLAG_NAME'
    );

    $lotsItems_qry = '';
    
    $userList = $this->db2->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE (T.LOCATION = 'PK' OR T.EMPLOYEE_ID IN(2,17,5)) AND T.STATUS = 1");
    $userData = $userList->result_array();


    if(!empty($get_ebay_id)){

      //$str = strlen($get_ebay_id);

//and (LIS_EBAY_ITEM_ID = '322884964340' or barcode_no  =322884964340 )
     $ebay_quer = "SELECT Q1.LIS_EBAY_ITEM_ID,Q1.BARCODE_NO, AC.EBAY_ID PURCH_EBAY_ID FROM (SELECT B.BARCODE_NO, B.EBAY_ITEM_ID LIS_EBAY_ITEM_ID, I.ITEM_DESC, M.LZ_MANIFEST_ID, M.SINGLE_ENTRY_ID, M.EST_MT_ID,/* DECODE(T.LZ_BD_CATA_ID, NULL, T3.LZ_BD_CATA_ID, T.LZ_BD_CATA_ID) LZ_BD_CAT*/T3.LZ_BD_CATA_ID LZ_BD_CAT FROM LZ_BARCODE_MT@ORASERVER B, ITEMS_MT@ORASERVER I, LZ_MANIFEST_MT@ORASERVER M, /*LZ_BD_TRACKING_NO@ORASERVER T,*/ LZ_BD_TRACKING_NO@ORASERVER T3 WHERE B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID /*AND M.SINGLE_ENTRY_ID = T.LZ_SINGLE_ENTRY_ID(+) AND M.LZ_MANIFEST_ID = T3.LZ_MANIFEST_ID(+) */AND M.EST_MT_ID = T3.LZ_ESTIMATE_ID (+) AND M.MANIFEST_TYPE IN (1, 2)) Q1, LZ_BD_ACTIVE_DATA@ORASERVER AC WHERE Q1.LZ_BD_CAT = AC.LZ_BD_CATA_ID " ;

     $ebay_quer .= " AND (LIS_EBAY_ITEM_ID = '$get_ebay_id' OR BARCODE_NO  ='$get_ebay_id' )";
     $ebay_quer .= " AND ROWNUM <=1 ";

     $eb_quer = $this->db->query($ebay_quer)->result_array();
     
     if(count($eb_quer) > 0){ 

    
    $check_ebay = $eb_quer[0]['PURCH_EBAY_ID'];
     }else{

    $check_ebay = '' ;//$eb_quer[0]['PURCH_EBAY_ID'];
     }


   }else{ 
    $check_ebay = '';

   }
    // $check_ebay = $eb_quer[0]['PURCH_EBAY_ID'];
    // var_dump($check_ebay);exit;

    $user_id = @$this->session->userdata('user_id');
    if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){

      
      $lotsItems_qry = $this->db2->query("SELECT E.LZ_BD_CATA_ID, E.CATEGORY_ID, E.EBAY_ID, E.TITLE, E.CONDITION_NAME, E.ITEM_URL, E.SALE_PRICE SALE_PRICE, E.LISTING_TYPE, TO_CHAR(E.INSERTED_DATE, 'DD-MM-YYYY HH24:MI:SS') INSERTED_DATE, TO_CHAR(TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || 'h ' || TO_CHAR(TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60))) || 'm ' || TO_CHAR(TRUNC(86400 * (E.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60))) || 's ' TIME_DIFF, E.SELLER_ID, E.FEEDBACK_SCORE, E.CATEGORY_NAME, E.SHIPPING_TYPE, E.CATALOGUE_MT_ID, E.COST_PRICE, E.TRACKING_NO, E.ASSIGN_TO, T.TRACKING_ID, T.TRACKING_NO TRACKING_NUMBER, T.COST_PRICE TRACKING_COST, T.SELLER_DESCRIPTION, MT.LZ_BD_ESTIMATE_ID, O.OFFER_ID, O.OFFER_AMOUNT, O.REMARKS, MT.LOT_OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON', 2, 'REJECTED') WIN_STATUS FROM LZ_BD_ITEMS_TO_EST   E, LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    MT, LZ_BD_PURCHASE_OFFER O WHERE E.IS_DELETED <> 1 AND E.FLAG_ID = 29  /*AND  E.INSERTED_DATE >= SYSDATE -30*/ AND E.TRACKING_NO = T.TRACKING_ID(+) AND E.LZ_BD_CATA_ID = MT.LZ_BD_CATAG_ID(+) AND E.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+)"); //ORDER BY BD.INSERTED_DATE DESC 
    }else{
      $lotsItems_qry = $this->db2->query("SELECT E.LZ_BD_CATA_ID, E.CATEGORY_ID, E.EBAY_ID, E.TITLE, E.CONDITION_NAME, E.ITEM_URL, E.SALE_PRICE SALE_PRICE, E.LISTING_TYPE, TO_CHAR(E.INSERTED_DATE, 'DD-MM-YYYY HH24:MI:SS') INSERTED_DATE, TO_CHAR(TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || 'h ' || TO_CHAR(TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60))) || 'm ' || TO_CHAR(TRUNC(86400 * (E.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60))) || 's ' TIME_DIFF, E.SELLER_ID, E.FEEDBACK_SCORE, E.CATEGORY_NAME, E.SHIPPING_TYPE, E.CATALOGUE_MT_ID, E.COST_PRICE, E.TRACKING_NO, E.ASSIGN_TO, T.TRACKING_ID, T.TRACKING_NO TRACKING_NUMBER, T.COST_PRICE TRACKING_COST, T.SELLER_DESCRIPTION, MT.LZ_BD_ESTIMATE_ID, O.OFFER_ID, O.OFFER_AMOUNT, O.REMARKS, MT.LOT_OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON', 2, 'REJECTED') WIN_STATUS FROM LZ_BD_ITEMS_TO_EST   E, LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    MT, LZ_BD_PURCHASE_OFFER O WHERE E.IS_DELETED <> 1 AND E.FLAG_ID = 29 /*AND  E.INSERTED_DATE >= SYSDATE -30*/ AND E.TRACKING_NO = T.TRACKING_ID(+)  AND E.LZ_BD_CATA_ID = MT.LZ_BD_CATAG_ID(+) AND E.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND E.ASSIGN_TO = $user_id ");  
    }

    $totalData = $lotsItems_qry->num_rows(); 
    // var_dump($totalData);exit;
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
       

    if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){

     $sql = "SELECT E.LZ_BD_CATA_ID, E.CATEGORY_ID, E.EBAY_ID, E.TITLE, E.CONDITION_NAME, E.ITEM_URL, E.SALE_PRICE SALE_PRICE, E.LISTING_TYPE, TO_CHAR(E.INSERTED_DATE, 'DD-MM-YYYY HH24:MI:SS') INSERTED_DATE, TO_CHAR(TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || 'h ' || TO_CHAR(TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60))) || 'm ' || TO_CHAR(TRUNC(86400 * (E.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60))) || 's ' TIME_DIFF, E.SELLER_ID, E.FEEDBACK_SCORE, E.CATEGORY_NAME, E.SHIPPING_TYPE, E.CATALOGUE_MT_ID, E.COST_PRICE, E.TRACKING_NO, E.ASSIGN_TO, T.TRACKING_ID, T.TRACKING_NO TRACKING_NUMBER, T.COST_PRICE TRACKING_COST, T.SELLER_DESCRIPTION, MT.LZ_BD_ESTIMATE_ID, O.OFFER_ID, O.OFFER_AMOUNT, O.REMARKS, MT.LOT_OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON', 2, 'REJECTED') WIN_STATUS, DECODE( MT.EST_END_TIME,NULL,NULL, TO_CHAR(TRUNC((((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) / 60) - 24 * (TRUNC((((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) / 60) / 24))) || 'H ' || TO_CHAR(TRUNC((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) - 60 * (TRUNC(((86400 * (MT.EST_END_TIME -MT.EST_DATE_TIME)) / 60) / 60))) || 'M ' || TO_CHAR(TRUNC(86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) - 60 * (TRUNC((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60))) || 'S ' ) ESTIMATE_TIME,  FLAG.FLAG_NAME  FLAG_NAME FROM LZ_BD_ITEMS_TO_EST   E, LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    MT, LZ_BD_PURCHASE_OFFER O, LZ_BD_PURCHASING_FLAG FLAG WHERE E.IS_DELETED <> 1  /*AND  E.INSERTED_DATE >= SYSDATE -30*/ AND MT.EST_STATUS = FLAG.FLAG_ID(+) AND E.FLAG_ID = 29 AND E.TRACKING_NO = T.TRACKING_ID(+) AND E.LZ_BD_CATA_ID = MT.LZ_BD_CATAG_ID(+) AND E.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) "; 

      if(!empty( $check_ebay)){

        $sql.= " AND EBAY_ID =$check_ebay";
      }

      }else{

        $sql = "SELECT E.LZ_BD_CATA_ID, E.CATEGORY_ID, E.EBAY_ID, E.TITLE, E.CONDITION_NAME, E.ITEM_URL, E.SALE_PRICE SALE_PRICE, E.LISTING_TYPE, TO_CHAR(E.INSERTED_DATE, 'DD-MM-YYYY HH24:MI:SS') INSERTED_DATE, TO_CHAR(TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || 'h ' || TO_CHAR(TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60))) || 'm ' || TO_CHAR(TRUNC(86400 * (E.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60))) || 's ' TIME_DIFF, E.SELLER_ID, E.FEEDBACK_SCORE, E.CATEGORY_NAME, E.SHIPPING_TYPE, E.CATALOGUE_MT_ID, E.COST_PRICE, E.TRACKING_NO, E.ASSIGN_TO, T.TRACKING_ID, T.TRACKING_NO TRACKING_NUMBER, T.COST_PRICE TRACKING_COST, T.SELLER_DESCRIPTION, MT.LZ_BD_ESTIMATE_ID, O.OFFER_ID, O.OFFER_AMOUNT, O.REMARKS, MT.LOT_OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON', 2, 'REJECTED') WIN_STATUS ,DECODE( MT.EST_END_TIME,NULL,NULL, TO_CHAR(TRUNC((((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) / 60) - 24 * (TRUNC((((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) / 60) / 24))) || 'H ' || TO_CHAR(TRUNC((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60) - 60 * (TRUNC(((86400 * (MT.EST_END_TIME -MT.EST_DATE_TIME)) / 60) / 60))) || 'M ' || TO_CHAR(TRUNC(86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) - 60 * (TRUNC((86400 * (MT.EST_END_TIME - MT.EST_DATE_TIME)) / 60))) || 'S ' ) ESTIMATE_TIME FROM LZ_BD_ITEMS_TO_EST   E, LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    MT, LZ_BD_PURCHASE_OFFER O WHERE E.IS_DELETED <> 1 AND E.FLAG_ID = 29 AND E.TRACKING_NO = T.TRACKING_ID(+) /*AND  E.INSERTED_DATE >= SYSDATE -30*/  AND E.LZ_BD_CATA_ID = MT.LZ_BD_CATAG_ID(+)  AND E.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND E.ASSIGN_TO = $user_id ";
         if(!empty( $check_ebay)){

        $sql.= " and EBAY_ID =$check_ebay";
      }
    }    

      if(!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( E.EBAY_ID LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR E.TITLE LIKE '%".$requestData['search']['value']."%' ";  
          $sql.=" OR E.CONDITION_NAME LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR E.SALE_PRICE LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR E.CATEGORY_ID LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR FLAG.FLAG_NAME  LIKE '%".$requestData['search']['value']."%' ";
          $sql.=" OR LOT_OFFER_AMOUNT LIKE '%".$requestData['search']['value']."%' )";
          
      }


    $query = $this->db2->query($sql);
    
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $totalFiltered = $query->num_rows(); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
     //$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT * FROM (SELECT  q.*, rownum rn FROM ($sql ORDER BY LZ_BD_CATA_ID DESC) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start']." ";
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

      if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){
      $nestedData[] ='<div style="width:80px;"> <button title="Discard or Rejection of Item" class="btn btn-danger btn-xs discard_item" style="width: 30px; font-size: 14px;" 
                         id="'.@$row["LZ_BD_CATA_ID"].'"> <i class="fa fa-trash-o" aria-hidden="true"></i> </button> </div>';
      }else{
        $nestedData[] = '';
      }
      $nestedData[] = '<a href='.@$row["ITEM_URL"].' target="_blank" id="link'.$i.'">'.@$row["EBAY_ID"].'</a>';
      $nestedData[] = '<div class="pull-right" style="width:250px;">'.@$row["TITLE"].'</div>';
      $nestedData[] = '<div class="text-center" style="width:80px;">'.@$row['CATEGORY_ID'].'</div>';

      // $userlist  = '';
      // foreach($userData as $user){
      //   $u_name = ucfirst($user['USER_NAME']);
      //   $employee_id = $user['EMPLOYEE_ID'];
      //   $userlist .= '<option value="'.$employee_id.'"'. if($employee_id == $row['ASSIGN_TO']){ .'"selected"' .}. ' >' .$u_name.'</option>';        
        
      // }
      // 
      $users = "";
      foreach($userData as $user){
        $u_name = ucfirst($user['USER_NAME']);
        $employee_id = $user['EMPLOYEE_ID'];
        if($employee_id == $row['ASSIGN_TO']){ $selected = "selected"; }else{ $selected = "";}     
        $users .= '<option value="'.  $employee_id .'"'. $selected.'  >'.$u_name.' </option>';
      } 
      if(empty($row['ASSIGN_TO'])){ 
        $btn_class = "assignToUser";
        $btn_clr = "btn-primary";
        $btn_name = "Assign";
      }else{
        $btn_class = "UnassignToUser";
        $btn_clr = "btn-success";
        $btn_name = "Un-Assign";
      }

      //Check of Assign and Un-Assign button for Authorized Users
      $assign_unassign = "";
      if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){
        $assign_unassign .= '<button type="button" class="btn btn-sm '.$btn_clr.' '.$btn_class.' " name="assign_'.$i.'" id="assign_'.$i.'" value="'.$i.'">'.$btn_name.'</button>';
      }

        $nestedData[] = '<div style="width: 220px;">
          <div style="width: 140px;" class="pull-left">
              <select class="form-control" name="user_name_'.$i.'" id="user_name_'.$i.'">
              <option value="0">---SELECT---</option>'.$users.'</select></div><div style="width: 50px;" class="pull-left"><input type="hidden" name="lz_bd_cata_id" id="lz_bd_cata_id_'.$i.'" value="'.@$row['LZ_BD_CATA_ID'].'">'.$assign_unassign.'</div></div>'; 
      

      //$nestedData[] = $userlist;
      //$nestedData[] = '<div style="width: 220px;"> <div style="width: 140px;" class="pull-left"> <select class="form-control" name="user_name_'.$i.'" id="user_name_'.$i.'"> <option value="0">---SELECT---</option> </select> </div></div>';
      $lz_bd_cata_id  =   @$row['LZ_BD_CATA_ID'];
      $category_id  =     @$row['CATEGORY_ID'];
      $catalogue_mt_id  = @$row['CATALOGUE_MT_ID'];
      $lz_bd_estimate_id = @$row['LZ_BD_ESTIMATE_ID'];      

      if(empty($lz_bd_estimate_id)){
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-primary btn-sm" href="'.base_url().'itemsToEstimate/c_itemsToEstimate/lotEstimate/'.$lz_bd_cata_id.'/1/'.$category_id.'" id="" title="LOT ESTIMATE">LOT ESTIMATE</a> </div>'; 
      }else{
        $nestedData[] = '<div class="form-group"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <a target="_blank" class="btn btn-success btn-sm" href="'.base_url().'itemsToEstimate/c_itemsToEstimate/lotEstimate/'.$lz_bd_cata_id.'/1/'.$category_id.'" id="" title="VIEW LOT">VIEW LOT</a>'; 
      }

       $nestedData[] = @$row['CONDITION_NAME'];
      $nestedData[] =  '$ '.number_format((float)@$row["SALE_PRICE"],2,'.','');
      
     
      $time_diff = @$row['TIME_DIFF'];
      if($time_diff < 0){
        $nestedData[] = 'Ended';
      }else{
        $nestedData[] = $time_diff;
      }
      $nestedData[] = @$row['FLAG_NAME'];
     
      $lot_offer_amount = '$ '.number_format((float)@$row['LOT_OFFER_AMOUNT'],2,'.','');
      $nestedData[] = '<div style="width: 100px !important;" id="lot_offer_amount_'.$i.'">'.$lot_offer_amount.'</div>';
      $nestedData[] = @$row["INSERTED_DATE"];
      
      $win_status = @$row['WIN_STATUS'];
      if(empty($row['OFFER_ID'])){
        $nestedData[] = '<div> <input type="hidden" name="lz_cat_id_'.$i.'" id="lz_cat_id_'.$i.'" value="'.$category_id.'"> <input type="hidden" name="lz_bd_catag_id_'.$i.'" id="lz_bd_catag_id_'.$i.'" value="'.$lz_bd_cata_id.'"> <button type="button" title="Place Bid/Offer" class="btn btn-primary btn-block btn-sm makeOffer" id="bid_offer_'.$i.'" value="'.$i.'">Place Bid/Offer</button> </div>'; 
      }else{
        $nestedData[] = '<div> <input type="hidden" name="status_'.$i.'" id="status_'.$i.'" value="'.$win_status.'"> <input type="hidden" name="tracking_id_'.$i.'" id="tracking_id_'.$i.'" value="'.@$row["TRACKING_ID"].'"> <input type="hidden" name="tracking_number_'.$i.'" id="tracking_number_'.$i.'" value="'.@$row['TRACKING_COST'].'"> <input type="hidden" name="tracking_cost_'.$i.'" id="tracking_cost_'.$i.'" value="'.@$row["TRACKING_NUMBER"].'"> <input type="hidden" name="offer_id_'.$i.'" id="offer_id_'.$i.'" value="'.@$row['OFFER_ID'].'"> <button type="button" title="Update Bid/Offer" class="btn btn-success btn-block btn-sm updateOffer" id="bid_offer_'.$i.'" value="'.$i.'">Update Bid/Offer</button> </div>'; 
      }

     $nestedData[] = $win_status;
     if($user_id == 2 || $user_id == 17 || $user_id == 5 || $user_id == 21){
     $nestedData[] = @$row['ESTIMATE_TIME'];
     $nestedData[] = @$row['SELLER_ID'];
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
      $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (TRACKING_NO, LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, COST_PRICE, DE_KIT_YN) VALUES('$ct_tracking_no', $lz_bd_catag_id, $lz_cat_id, $tracking_id, $ct_cost_price, NULL)");
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

  public function trashResultRow(){
      $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
      $discard_remarks = $this->input->post('discard_remarks');
      $remarks = $this->input->post('remarks');
      $remarks = trim(str_replace("  ", ' ', $remarks));
      $remarks = trim(str_replace(array("'"), "''", $remarks));

      date_default_timezone_set("America/Chicago");
      $date = date('Y-m-d H:i:s');
      $estimate_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    //var_dump($compAvgPrice, $compAmount, $ebayFee, $payPalFee, $shipFee); exit;

      $user_id = $this->session->userdata('user_id');

      $query = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET IS_DELETED = 1, REJECTION_REMARKS =  '$remarks' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");      

      if ($query){
        $mov_stat_into_est = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT ES SET ES.EST_POST_STATUS = 2,ES.ADMIN_USER_ID =$user_id ,ES.ADMIN_USER_TIME =$estimate_date,ES.ADMIN_REMARKS =$discard_remarks WHERE ES.LZ_BD_CATAG_ID = '$lz_bd_cata_id' ");
        return true;
      }else {
        return false;
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
    // $sql = $sql->re
  }
/*=====  End of update seller description  ======*/

  public function lotItemDownload(){

    $ebay_id = $this->input->post("ebay_id");
    //$lotItemCheck = $this->input->post("lotItemCheck");
    //var_dump($lotItemCheck);exit;
    // require __DIR__.'/../vendor/autoload.php';
    //$path = 'D:\wamp\www\laptopzone\application\views\ebay\trading\downloadItem.php';
    $path = '/../../../application/views/ebay/trading/lotItemDownload.php';
    include $path;

    //var_dump($result);
    return $result;

  
  }

  public function UsersList()
  {
    $query = $this->db2->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.LOCATION = 'PK' OR T.EMPLOYEE_ID IN(2,17,5)");
    return $query->result_array();
  }  
  public function AssignItems(){

    date_default_timezone_set("America/Chicago");
    $date = date("Y-m-d H:i:s");
    $assign_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $created_by = $this->session->userdata('user_id');     
    $assign_to = $this->input->post('user_id');
    $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
     
    $query = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CREATED_BY = $created_by, ASSIGN_DATE = $assign_date, ASSIGN_TO = $assign_to WHERE LZ_BD_CATA_ID =  $lz_bd_cata_id ");          

    if($query){
      return 1;
    }else{
      return 2;
    }
    
  }
  public function UnAssignItems(){

    date_default_timezone_set("America/Chicago");
    $date = date("Y-m-d H:i:s");
    $assign_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $created_by = $this->session->userdata('user_id');     
    $assign_to = $this->input->post('user_id');
    $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');

    $check_estimate = $this->db2->query("SELECT ESTIMATE_DATE FROM LZ_BD_ITEMS_TO_EST WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
    $rs = $check_estimate->result_array();
    $estimate_date = $rs[0]['ESTIMATE_DATE'];

    if($estimate_date != null){
      return 3;
    }else{
    $query = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CREATED_BY = $created_by, ASSIGN_DATE = null, ASSIGN_TO = null WHERE LZ_BD_CATA_ID =  $lz_bd_cata_id ");          

      if($query){
        return 1;
      }else{
        return 2;
      }
    }
    
  }  
  
  public function lotMasterInfo(){
    $lz_bd_cata_id = $this->uri->segment(4);
    $category_id = $this->uri->segment(6);
    $query = $this->db2->query("SELECT T.EBAY_ID , T.TITLE, T.CATEGORY_ID, T.CATEGORY_NAME, T.CONDITION_ID, T.CONDITION_NAME, T.ITEM_URL, TO_CHAR(T.START_TIME, 'DD-MM-YYYY HH24:MI:SS') as START_TIME, TO_CHAR(T.SALE_TIME, 'DD-MM-YYYY HH24:MI:SS') as SALE_TIME ,OFFE.OFFER_AMOUNT FROM LZ_BD_ITEMS_TO_EST T ,LZ_BD_PURCHASE_OFFER OFFE WHERE T.LZ_BD_CATA_ID = $lz_bd_cata_id AND T.CATEGORY_ID = $category_id AND T.LZ_BD_CATA_ID = OFFE.LZ_BD_CATA_ID(+) ");
    $masterInfo = $query->result_array();
 
    $detail_query = $this->db2->query("SELECT DISTINCT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.QTY, DT.TECH_COND_ID, DT.EST_SELL_PRICE, DT.EBAY_FEE, DT.PAYPAL_FEE, DT.SHIPPING_FEE, DT.SOLD_PRICE, DT.PART_CATLG_MT_ID, MT.LOT_OFFER_AMOUNT, U.KEYWORD, MT.LOT_REMARKS FROM LZ_CATALOGUE_MT    M, LZ_BD_OBJECTS_MT   O, MPN_AVG_PRICE      A, LZ_BD_ESTIMATE_MT  MT, LZ_BD_ESTIMATE_DET DT, LZ_BD_RSS_FEED_URL U WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.TECH_COND_ID = A.CONDITION_ID(+) AND DT.PART_CATLG_MT_ID = U.CATLALOGUE_MT_ID(+) AND DT.TECH_COND_ID = U.CONDITION_ID(+) AND MT.LZ_BD_CATAG_ID = $lz_bd_cata_id ORDER BY DT.LZ_ESTIMATE_DET_ID ASC"); 
    
    // $detail_query = $this->db2->query(" SELECT  M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, INER_QRY.QTY QTY, DT.TECH_COND_ID, INER_QRY.EST_SELL_PRICE EST_SELL_PRICE,/*DT.EST_SELL_PRICE EST_SELL_PRICE,*/ DT.EBAY_FEE, DT.PAYPAL_FEE, DT.SHIPPING_FEE, DT.SOLD_PRICE, DT.PART_CATLG_MT_ID, MT.LOT_OFFER_AMOUNT, U.KEYWORD, MT.LOT_REMARKS FROM LZ_CATALOGUE_MT    M, LZ_BD_OBJECTS_MT   O, MPN_AVG_PRICE      A, LZ_BD_ESTIMATE_MT  MT, LZ_BD_ESTIMATE_DET DT, LZ_BD_RSS_FEED_URL U, (SELECT MIN(DT.LZ_ESTIMATE_DET_ID) LZ_ESTIMATE_DET_ID,DT.PART_CATLG_MT_ID,SUM(DT.QTY) QTY,SUM(DT.EST_SELL_PRICE)EST_SELL_PRICE FROM  LZ_BD_ESTIMATE_MT  MT, LZ_BD_ESTIMATE_DET DT WHERE   MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_CATAG_ID = $lz_bd_cata_id  GROUP BY DT.PART_CATLG_MT_ID) INER_QRY WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.TECH_COND_ID = A.CONDITION_ID(+) AND DT.LZ_ESTIMATE_DET_ID = INER_QRY.LZ_ESTIMATE_DET_ID AND DT.PART_CATLG_MT_ID = U.CATLALOGUE_MT_ID(+) AND DT.TECH_COND_ID = U.CONDITION_ID(+) AND MT.LZ_BD_CATAG_ID = $lz_bd_cata_id  ORDER BY DT.LZ_ESTIMATE_DET_ID ASC ");

    $estimate_info = $detail_query->result_array();

    $objects = $this->db2->query("SELECT DISTINCT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = O.CATEGORY_ID AND C.CATEGORY_ID = $category_id ");
    $getObjects = $objects->result_array();

    if(!empty($lz_bd_cata_id )){
      $lot_remarks=$this->db2->query("SELECT B.LOT_REMARKS FROM LZ_BD_ESTIMATE_MT B WHERE LZ_BD_CATAG_ID =$lz_bd_cata_id");
      $lot_remarks=$lot_remarks->result_array(); 
    }else{
      $lot_remarks=""; 
    }
    
    $path_query = $this->db2->query("SELECT * FROM LZ_PICT_PATH_CONFIG@oraserver WHERE PATH_ID = 1");
    $path_query =  $path_query->result_array();

    $path_2 = $this->db2->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG@oraserver WHERE PATH_ID = 2");
    $path_2 =  $path_2->result_array();


    $estimate_status = $this->db2->query(" SELECT F.FLAG_ID ,F.FLAG_NAME FROM LZ_BD_PURCHASING_FLAG F WHERE F.FLAG_ID IN (34,35,20) ")->result_array();
     $get_status = $this->db2->query(" SELECT K.EST_STATUS EST_STATUS, (SELECT F.FLAG_NAME FROM LZ_BD_PURCHASING_FLAG F WHERE F.FLAG_ID = K.EST_POST_REMARKS_ID) EST_POST_REMARKS_ID FROM LZ_BD_ESTIMATE_MT K  WHERE K.LZ_BD_CATAG_ID = $lz_bd_cata_id  ")->result_array();
    // var_dump($estimate_info);exit;
      return array("masterInfo"=>$masterInfo, "estimate_info"=>$estimate_info, "getObjects"=>$getObjects, 'path_query'=>$path_query, 'path_2'=>$path_2, 'lot_remarks'=>$lot_remarks, 'estimate_status'=>$estimate_status, 'get_status'=>$get_status);
  }

 public function get_brands(){
   $object_id = $this->input->post('object_id');
   $category_id = $this->input->post('category_id');
   $get_brands = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM.SPECIFIC_NAME, CD.SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_MT CM, CATEGORY_SPECIFIC_DET CD WHERE CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CM.EBAY_CATEGORY_ID = $category_id");
   return $get_brands->result_array();

 }
 public function getBrandwiseMPN(){
   $object_id = $this->input->post('object_id');
   $get_brand = strtoupper($this->input->post('get_brand'));
   $category_id = $this->input->post('category_id');
   $get_mpns = $this->db2->query("SELECT C.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $category_id AND C.OBJECT_ID = $object_id AND UPPER(C.BRAND) = '$get_brand'");
   return $get_mpns->result_array();
 }
 public function get_mpns(){
   $object_id = $this->input->post('object_id');
   $category_id = $this->input->post('category_id');
   $get_mpns = $this->db2->query("SELECT C.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, C.UPC FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $category_id AND C.OBJECT_ID = $object_id");
   return $get_mpns->result_array();

  }

  public function lotEstimate(){

    $conditions = $this->db->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT");
    return $conditions->result_array();

  }  
  public function addlotToEstimate(){

    $comp_mpn = $this->input->post('comp_mpn');
    $comp_text = $this->input->post('comp_text');
    $comp_object = $this->input->post('comp_object');
    $comp_object = trim(str_replace("  ", ' ', $comp_object));
    $comp_object = trim(str_replace(array("'"), "''", $comp_object));     
    $comp_text = explode("~", $comp_text);
    //$mpn_text =  trim(@$comp_text[0]); // piece1
    $mpn_description =  trim(@$comp_text[1]); // piece2
    //var_dump($mpn_text, $mpn_description);exit;
    $mpn_description = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description = trim(str_replace(array("'"), "''", $mpn_description));
    if(empty($mpn_description)){
      $mpn_description = $comp_object;
    }     

    //$comp_object = $this->input->post('comp_object');
    $ct_cata_id = $this->input->post('ct_cata_id');
    $condition_id = $this->input->post('condition_id');

    $comp_upc = $this->input->post('comp_upc');
    $comp_upc = str_replace("  ", ' ', $comp_upc);
    $comp_upc = trim(str_replace(array("'"), "''", $comp_upc));



    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $estimate_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');

      $check_catalogue = $this->db2->query("SELECT LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT WHERE LZ_BD_CATAG_ID = $ct_cata_id");
      $rs = $check_catalogue->result_array();
      $lz_estimate_id = @$rs[0]['LZ_BD_ESTIMATE_ID'];

      if($check_catalogue->num_rows() > 0) {

        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
        $rs = $qry->result_array();
        $lz_estimate_det_id = @$rs[0]['ID'];
        
        $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $comp_mpn, '$mpn_description', $estimate_date)");
    // UPDATE UPC for Mpn on Estimated Lot
        $update_catalgoue_mt=$this->db2->query("UPDATE LZ_CATALOGUE_MT SET UPC='$comp_upc' WHERE CATALOGUE_MT_ID = $comp_mpn");

        if($insert_est_det) {

            $detail_query = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID,U.KEYWORD FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT,LZ_BD_RSS_FEED_URL U WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = U.CATLALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $comp_mpn");
            $detail = $detail_query->result_array();
            $res_mpn = @$detail[0]['MPN'];
            $condition = @$detail[0]['TECH_COND_ID'];

            /*========= Picture script start =========*/ 

              $getUpc = $this->db2->query("SELECT I.ITEM_MT_UPC FROM ITEMS_MT@Oraserver I WHERE I.ITEM_MT_MFG_PART_NO = '$res_mpn'");
              $getUpc = $getUpc->result_array();
              $upc = @$getUpc[0]["ITEM_MT_UPC"];
              //var_dump($upc);exit;  

              $old_path =   $this->db2->query("SELECT * FROM LZ_PICT_PATH_CONFIG@Oraserver WHERE PATH_ID = 1");
              $old_path = $old_path->result_array();
              $master_old_path = @$old_path[0]['MASTER_PATH'];
              // $live_old_path = $old_path[0]['LIVE_PATH'];
              //$condition = "New";
              //$res_mpn = "CTRPBMME";
              if(is_numeric(@$condition)){
                  if(@$condition == 3000){
                    @$condition = 'Used';
                  }elseif(@$condition == 1000){
                    @$condition = 'New'; 
                  }elseif(@$condition == 1500){
                    @$condition = 'New other'; 
                  }elseif(@$condition == 2000){
                      @$condition = 'Manufacturer refurbished';
                  }elseif(@$condition == 2500){
                    @$condition = 'Seller refurbished'; 
                  }elseif(@$condition == 7000){
                    @$condition = 'For parts or not working'; 
                  }
                }               
              $mdir = $master_old_path.$upc.'~'.$res_mpn.'/'.@$condition.'/thumb/';
              $dir = preg_replace("/[\r\n]*/","",$mdir);
              //var_dump($dir);

              $master_pics = [];
              $parts = [];
              $uri = [];

              // var_dump(is_dir($dir));exit;
              if (is_dir($dir)){
                  //var_dump($dir);
                  $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
                  $i=0 ;

                  foreach($images as $image){
                    $uri[$i] = $image;
                    $parts = explode(".", $image);
                    $img_name = explode("/",$image);
                    //var_dump($img_name);//exit;

                    if (is_array($parts) && count($parts) > 1){
                      $extension = end($parts);
                      if(!empty($extension)){
                          
                        // $live_path = $data['path_query'][0]['LIVE_PATH'];
                        $url = $parts['0'].'.'.$extension;

                        $url = preg_replace("/[\r\n]*/","",$url);

                        // var_dump($url);exit;
                        $uri[$i] = $url;
                        $img = file_get_contents($url);
                        // var_dump($url);exit;
                        $img =base64_encode($img);
                        $master_pics[$i] = $img;

                        $i++;
                      }
                    }

                  }
              }
              if(empty($master_pics)){
                $master_pics = 0;
              }
              if(empty($parts)){
                $parts = 0;
              }
              if(empty($uri)){
                $uri = 0;
              }               


            /*========= Picture script end =========*/            
            $condition_id = @$detail[0]['TECH_COND_ID'];
            $estimate_price = $this->db2->query("SELECT NVL(EST_SELL_PRICE, 0) EST_SELL_PRICE FROM (SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.PART_CATLG_MT_ID = $comp_mpn AND D.EST_SELL_PRICE IS NOT NULL AND D.TECH_COND_ID = $condition_id ORDER BY D.LZ_ESTIMATE_DET_ID DESC) WHERE ROWNUM = 1"); 
            if($estimate_price->num_rows() > 0){
              $rs = $estimate_price->result_array();
              $estimate = @$rs[0]['EST_SELL_PRICE']; 
            }else{
              $estimate = 0.00;
            }
            //print_r($estimate);
            return array("detail"=>$detail, "estimate"=>$estimate, "master_pics"=>$master_pics, "parts"=>$parts, "uri"=>$uri);

        }else {
          return 2;
        } 
        
      }else {
        //echo "yesss"; exit;
        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
        $lz_estimate_id = @$rs[0]['ID'];

        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id, $ct_cata_id, $estimate_date, $user_id)");

        /*===== If Item is not Assigned to a user start ======*/
          date_default_timezone_set("America/Chicago");
          $date = date("Y-m-d H:i:s");
          $assign_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
          $created_by = $this->session->userdata('user_id');     
          $assign_to = $this->session->userdata('user_id');
          //$lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
       
          $query = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CREATED_BY = $created_by, ASSIGN_DATE = $assign_date, ASSIGN_TO = $assign_to WHERE LZ_BD_CATA_ID = $ct_cata_id ");

        /*===== If Item is not Assigned to a user end ======*/

        if($insert_est_mt) {

            $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
            $rs = $qry->result_array();
            $lz_estimate_det_id = @$rs[0]['ID'];
            
            $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $comp_mpn, '$mpn_description', $assign_date)");

            $update_catalgou_mt=$this->db2->query("UPDATE LZ_CATALOGUE_MT SET UPC='$comp_upc' WHERE CATALOGUE_MT_ID = $comp_mpn");

          if ($insert_est_det) {

            $detail_query = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $comp_mpn");
            $detail = $detail_query->result_array();
            $res_mpn = @$detail[0]['MPN'];
            $condition = @$detail[0]['TECH_COND_ID'];

            /*========= Picture script start =========*/ 

              $getUpc = $this->db2->query("SELECT I.ITEM_MT_UPC FROM ITEMS_MT@Oraserver I WHERE I.ITEM_MT_MFG_PART_NO = '$res_mpn'");
              $getUpc = $getUpc->result_array();
              $upc = @$getUpc[0]["ITEM_MT_UPC"];
              //var_dump($upc);exit;  

              $old_path =   $this->db2->query("SELECT * FROM LZ_PICT_PATH_CONFIG@Oraserver WHERE PATH_ID = 1");
              $old_path = $old_path->result_array();
              $master_old_path = @$old_path[0]['MASTER_PATH'];
              // $live_old_path = $old_path[0]['LIVE_PATH'];
              //$condition = "New";
              //$res_mpn = "CTRPBMME";
              if(is_numeric(@$condition)){
                  if(@$condition == 3000){
                    @$condition = 'Used';
                  }elseif(@$condition == 1000){
                    @$condition = 'New'; 
                  }elseif(@$condition == 1500){
                    @$condition = 'New other'; 
                  }elseif(@$condition == 2000){
                      @$condition = 'Manufacturer refurbished';
                  }elseif(@$condition == 2500){
                    @$condition = 'Seller refurbished'; 
                  }elseif(@$condition == 7000){
                    @$condition = 'For parts or not working'; 
                  }
                }              
              $mdir = $master_old_path.$upc.'~'.$res_mpn.'/'.@$condition;
              $dir = preg_replace("/[\r\n]*/","",$mdir);

              $master_pics = [];
              $parts = [];
              $uri = [];

              // var_dump(is_dir($dir));exit;
              if (is_dir($dir)){
                // var_dump($dir);exit;
                $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
                $i=0 ;

                foreach($images as $image){
                  $uri[$i] = $image;
                  $parts = explode(".", $image);
                  $img_name = explode("/",$image);
                  //var_dump($img_name);exit;

                  if (is_array($parts) && count($parts) > 1){
                    $extension = end($parts);
                    if(!empty($extension)){
                        
                      // $live_path = $data['path_query'][0]['LIVE_PATH'];
                      $url = $parts['0'].'.'.$extension;

                      $url = preg_replace("/[\r\n]*/","",$url);

                      // var_dump($url);exit;
                      $uri[$i] = $url;
                      $img = file_get_contents($url);
                      // var_dump($url);exit;
                      $img =base64_encode($img);
                      $master_pics[$i] = $img;

                      $i++;
                    }
                  }

                }
              }
              if(empty($master_pics)){
                $master_pics = 0;
              }
              if(empty($parts)){
                $parts = 0;
              }
              if(empty($uri)){
                $uri = 0;
              }               

            /*========= Picture script end =========*/

            $estimate_price = $this->db2->query("SELECT NVL(EST_SELL_PRICE, 0) EST_SELL_PRICE FROM (SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.PART_CATLG_MT_ID = $comp_mpn AND D.EST_SELL_PRICE IS NOT NULL ORDER BY D.LZ_ESTIMATE_DET_ID DESC) WHERE ROWNUM = 1"); 

            if($estimate_price->num_rows() > 0){
              $rs = $estimate_price->result_array();
              $estimate = @$rs[0]['EST_SELL_PRICE'];
              
            }else{
              $estimate = 0.00;
            }
            return array("detail"=>$detail, "estimate"=>$estimate, "master_pics"=>$master_pics, "parts"=>$parts, "uri"=>$uri);

          }else {
            return 2;
          } 

        } //$insert_est_mt if closing 
      }//main else closing  
  }

  public function saveLotComponents(){

    $cat_id = $this->input->post('cat_id'); // using it for tracking and active table
    $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
    $es_status = $this->input->post('es_status');
    $discard_remarks = $this->input->post('discard_remarks');
    $lz_bd_estimate_det = $this->input->post('lz_bd_estimate_det');
    $lot_offer_amount = trim($this->input->post('offer_amount'));
    $mpn_description = $this->input->post('mpn_description');   
    //$part_catlg_mt_id = $this->input->post('part_catlg_mt_id');   
    // var_dump($part_catlg_mt_id);
    // exit;
    //$lot_remarks = trim($this->input->post('lot_remarks'));
    //$lot_remarks = trim(str_replace("  ", ' ', $lot_remarks));
    //$lot_remarks = trim(str_replace(array("'"), "''", $lot_remarks));    
    //var_dump($offer_amount);exit;

    $compQty=$this->input->post('compQty');

    $compAvgPrice=$this->input->post('compAvgPrice');
    $compAvgPrice = str_replace("$", "", $compAvgPrice);
    $compAvgPrice = str_replace("$ ", "", $compAvgPrice);
    
    $compAmount=$this->input->post('compAmount');
    $compAmount = str_replace("$ ", "", $compAmount);
    $compAmount = str_replace("$", "", $compAmount);
    if (empty($compAmount)) {
      $compAmount = 1;
    }

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

    //var_dump($compAvgPrice, $compAmount, $ebayFee, $payPalFee, $shipFee); exit;

    $user_id = $this->session->userdata('user_id');
    //var_dump($estimate_date, $dynamic_cata_id);exit;
    if (!empty($user_id)) {
      $check_catalogue = $this->db2->query("SELECT LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT WHERE LZ_BD_CATAG_ID = $lz_bd_cata_id");
      $rs = $check_catalogue->result_array();
      $lz_estimate_id = @$rs[0]['LZ_BD_ESTIMATE_ID'];

      if ($check_catalogue->num_rows() > 0) {

        $update_est_mt = $this->db2->query("UPDATE LZ_BD_ESTIMATE_MT SET  KIT_LOT = 'L', LOT_OFFER_AMOUNT = $lot_offer_amount WHERE LZ_BD_ESTIMATE_ID = $lz_estimate_id ");
      if ($update_est_mt) {
        $est_statu_update = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT F SET F.EST_STATUS ='$es_status',F.EST_POST_REMARKS_ID ='$discard_remarks',F.EST_END_TIME = $estimate_date where F.LZ_BD_ESTIMATE_ID = $lz_estimate_id ");
        $i=0;
        foreach ($lz_bd_estimate_det as $comp) {
        $mpn_desc = trim(str_replace("  ", ' ', $mpn_description[$i]));
        $mpn_desc = trim(str_replace(array("'"), "''", $mpn_desc)); 

          // $update_est_det = $this->db2->query("UPDATE LZ_BD_ESTIMATE_DET SET QTY = $compQty[$i], EST_SELL_PRICE = $compAmount[$i], EBAY_FEE = $ebayFee[$i], PAYPAL_FEE = $payPalFee[$i], SHIPPING_FEE = $shipFee[$i], TECH_COND_ID = $tech_condition[$i], SOLD_PRICE = $compAvgPrice[$i], MPN_DESCRIPTION = '$mpn_desc' WHERE PART_CATLG_MT_ID = $part_catlg_mt_id[$i] and LZ_BD_ESTIMATE_ID = $lz_estimate_id");

          $update_est_det = $this->db2->query("UPDATE LZ_BD_ESTIMATE_DET SET QTY = $compQty[$i], EST_SELL_PRICE = $compAmount[$i], EBAY_FEE = $ebayFee[$i], PAYPAL_FEE = $payPalFee[$i], SHIPPING_FEE = $shipFee[$i], TECH_COND_ID = $tech_condition[$i], SOLD_PRICE = $compAvgPrice[$i], MPN_DESCRIPTION = '$mpn_desc' WHERE LZ_ESTIMATE_DET_ID = $comp");

          $updat_mpn_des =$this->db2->query( " UPDATE LZ_CATALOGUE_MT L SET L.MPN_DESCRIPTION = '$mpn_desc' WHERE L.CATALOGUE_MT_ID = (SELECT D.PART_CATLG_MT_ID FROM LZ_BD_ESTIMATE_DET D WHERE D.LZ_ESTIMATE_DET_ID = $comp)" );

        $i++;
        } /// end foreach
        
          if ($update_est_det) {
            $update_est_date = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET ESTIMATE_DATE = $estimate_date WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");

            $check_est_id = $this->db2->query("SELECT LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
            if ($check_est_id->num_rows() == 0) {
              $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
              $rs = $qry->result_array();
              $tracking_id = @$rs[0]['ID'];

              $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, LZ_ESTIMATE_ID) VALUES($lz_bd_cata_id, $cat_id, $tracking_id, $lz_estimate_id)");
              $update_tracking_no = false;
              
            }else {
              $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET  LZ_ESTIMATE_ID = $lz_estimate_id WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
              $insert_tracking_no = false;
            } 
            
          }

          if($update_tracking_no == true || $insert_tracking_no ==true){
            return 1;
          }else {
            return 2;
          }
      }

      }
      
    } // end main if    
  }

   //For Saving LotRemarks
public function saveLotRemarks(){

    $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
    $lot_remarks = trim($this->input->post('lot_remarks'));
    $lot_remarks = trim(str_replace("  ", ' ', $lot_remarks));
    $lot_remarks = trim(str_replace(array("'"), "''", $lot_remarks));    
  
    //var_dump($lz_bd_cata_id,$lot_remarks); exit;

        $update_remarks_mt = $this->db2->query("UPDATE LZ_BD_ESTIMATE_MT SET LOT_REMARKS = '$lot_remarks' WHERE LZ_BD_CATAG_ID = $lz_bd_cata_id ");
      if ($update_remarks_mt) {
            return 1;
          }else {
            return 2;
          }
      }   
//End LotRemarks
  public function deleteFromEstimate(){
    $lz_estimate_det_id = $this->input->post('lz_estimate_det_id');
    $query = $this->db2->query("DELETE FROM LZ_BD_ESTIMATE_DET WHERE LZ_ESTIMATE_DET_ID = $lz_estimate_det_id");
    if($query == true){
      return 1;
    }else{
      return 2;
    }
  }
  public function addCataMpn(){

    $cat_id = $this->input->post('cat_id');
    ///var_dump($cat_id); exit;
    $master_mpn = $this->input->post('master_mpn');
    $mpn_object = strtoupper($this->input->post('mpn_object'));
    $mpn_object = trim(str_replace("  ", ' ', $mpn_object));
    $mpn_object = trim(str_replace(array("'"), "''", $mpn_object));

    $new_mpn = trim(strtoupper($this->input->post('new_mpn')));
    $lot_upc = trim($this->input->post('lot_upc'));

       
    $mpn_brand = strtoupper($this->input->post('mpn_brand'));
    $mpn_brand = trim(str_replace("  ", ' ', $mpn_brand));
    $mpn_brand = trim(str_replace(array("'"), "''", $mpn_brand));    

    $insert_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $mpn_desc = $this->input->post('mpn_desc');
    $mpn_desc = trim(str_replace("  ", ' ', $mpn_desc));
    $mpn_desc = trim(str_replace(array("'"), "''", $mpn_desc));

    // var_dump($lot_upc );
    // exit;

    $checkQry = $this->db2->query("SELECT DISTINCT OBJECT_ID,OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$mpn_object' AND CATEGORY_ID = $cat_id");
    
    if($checkQry->num_rows() == 0){

      $obj_id = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
      $get_mt_pk = $obj_id->result_array();
      $object_id = @$get_mt_pk[0]['OBJECT_ID'];
      $qry = "INSERT INTO LZ_BD_OBJECTS_MT O (OBJECT_ID, OBJECT_NAME,INSERT_DATE,INSERT_BY, CATEGORY_ID) VALUES($object_id, '$mpn_object',$insert_date,$insert_by, $cat_id)";
      $this->db2->query($qry);
     
    }else{
       $object_id = $checkQry->result_array()[0]['OBJECT_ID'];
    }
    
    $mpn_check = $this->db2->query("SELECT CATALOGUE_MT_ID, OBJECT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$new_mpn' AND CATEGORY_ID = $cat_id");

      if($mpn_check->num_rows() == 0){
        $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
        $get_pk = $get_mt_pk->result_array();
        $cat_mt_id = @$get_pk[0]['CATALOGUE_MT_ID'];

        // var_dump($lot_upc);
        //  exit; 

        $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION, BRAND, UPC) VALUES($cat_mt_id, '$new_mpn', $cat_id, $insert_date, $insert_by,$object_id, '$mpn_desc', '$mpn_brand', '$lot_upc')"); 

      /*========= Insertion of Brands in category_specific_det start ==========*/

        $mt_id_qry = $this->db2->query("SELECT CM.MT_ID FROM CATEGORY_SPECIFIC_MT CM WHERE UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CM.EBAY_CATEGORY_ID = $cat_id");
        $mt_id_qry = $mt_id_qry->result_array();
        $mt_id = @$mt_id_qry[0]['MT_ID'];

        if(!empty($mt_id)){

          $check_qry = "SELECT DT.DET_ID FROM CATEGORY_SPECIFIC_DET DT WHERE DT.MT_ID = $mt_id AND UPPER(DT.SPECIFIC_VALUE) = '$mpn_brand'";
          $check_qry = $this->db2->query($check_qry);
            if($check_qry->num_rows() == 0){
              $det_id_qry = "SELECT GET_SINGLE_PRIMARY_KEY@oraserver('CATEGORY_SPECIFIC_DET','DET_ID') DET_ID FROM DUAL";
              $query = $this->db2->query($det_id_qry);
              $det_id_qry = $query->result_array();
              $det_id = @$det_id_qry[0]['DET_ID'];        

              $specific_det = "INSERT INTO CATEGORY_SPECIFIC_DET@oraserver (DET_ID, MT_ID, SPECIFIC_VALUE)VALUES($det_id, $mt_id, '$mpn_brand')"; 
              $this->db2->query($specific_det);

            }

        }

      /*========= Insertion of Brands in category_specific_det end ==========*/             
      }else{
        $get_pk = $mpn_check->result_array();
        $cat_mt_id = @$get_pk[0]['CATALOGUE_MT_ID'];

        $update_upc = $this->db2->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$lot_upc' WHERE CATALOGUE_MT_ID = $cat_mt_id ");
      }
/*==========================================
=            lz_Bd_estimate_mt             =
==========================================*/

    $comp_mpn = $cat_mt_id;
    $lz_bd_cata_id = $this->input->post('lz_bd_cata_id');

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $estimate_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');

      $check_catalogue = $this->db2->query("SELECT LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT WHERE LZ_BD_CATAG_ID = $lz_bd_cata_id");
      $rs = $check_catalogue->result_array();
      $lz_estimate_id = @$rs[0]['LZ_BD_ESTIMATE_ID'];

      if($check_catalogue->num_rows() > 0) {

        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
        $rs = $qry->result_array();
        $lz_estimate_det_id = @$rs[0]['ID'];
        
        $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $comp_mpn, '$mpn_desc', $estimate_date)");

        if($insert_est_det) {
          
            $detail_query = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $comp_mpn");
            $detail = $detail_query->result_array();

            // $estimate_price = $this->db2->query("SELECT NVL(EST_SELL_PRICE, 1) EST_SELL_PRICE FROM (SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.PART_CATLG_MT_ID = $comp_mpn AND D.EST_SELL_PRICE IS NOT NULL ORDER BY D.LZ_ESTIMATE_DET_ID DESC) WHERE ROWNUM = 1"); 

            // $estimate = $estimate_price->result_array();
            //  print_r($estimate);  
            return array("detail"=>$detail);
        }else {
          return 2;
        } 
      }else { 
        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
        $lz_estimate_id = @$rs[0]['ID'];

        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id, $lz_bd_cata_id, $estimate_date, $user_id)");

        if($insert_est_mt) {
            $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
            $rs = $qry->result_array();
            $lz_estimate_det_id = @$rs[0]['ID'];
            
            $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $comp_mpn, '$mpn_desc', $estimate_date)");

          /*===== If Item is not Assigned to a user start ======*/
            date_default_timezone_set("America/Chicago");
            $date = date("Y-m-d H:i:s");
            $assign_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            $created_by = $this->session->userdata('user_id');     
            $assign_to = $this->session->userdata('user_id');
            //$lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
         
            $query = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CREATED_BY = $created_by, ASSIGN_DATE = $assign_date, ASSIGN_TO = $assign_to WHERE LZ_BD_CATA_ID = $lz_bd_cata_id ");
          /*===== If Item is not Assigned to a user end ======*/
          if ($insert_est_det) {
            $detail_query = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $comp_mpn");
            $detail = $detail_query->result_array();
            $estimate_price = $this->db2->query("SELECT NVL(EST_SELL_PRICE, 1) EST_SELL_PRICE FROM (SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.PART_CATLG_MT_ID = $comp_mpn AND D.EST_SELL_PRICE IS NOT NULL ORDER BY D.LZ_ESTIMATE_DET_ID DESC) WHERE ROWNUM = 1"); 
            $estimate = $estimate_price->result_array();
            return array("detail"=>$detail, "estimate"=>$estimate);
            //return 1;
          }else {
            return 2;
          } 
        } //$insert_est_mt if closing 
      }//main else closing  
    /*=====  End of lz_Bd_estimate_mt   ======*/
  }
  public function estimateReport(){
    //$query = $this->db2->query("SELECT E.CREATED_BY, TO_CHAR(E.ASSIGN_DATE, 'YYYY-MM-DD HH24:MI:SS') ASSIGN_DATE, E.ASSIGN_TO, TO_CHAR(E.ESTIMATE_DATE, 'YYYY-MM-DD HH24:MI:SS') ESTIMATE_DATE FROM LZ_BD_ITEMS_TO_EST E WHERE E.ESTIMATE_DATE IS NOT NULL");
    $query = $this->db2->query("SELECT CREATED_BY, ASSIGN_DATE, ASSIGN_TO, EBAY_ID, TITLE, START_TIME, TO_CHAR(TRUNC((((86400 * (START_TIME - SYSDATE)) / 60) / 60) / 24)) || 'D ' || TO_CHAR(TRUNC(((86400 * ( END_TIME - START_TIME )) / 60) / 60) - 24 * (TRUNC((((86400 * (END_TIME - START_TIME )) / 60) / 60) / 24))) || ' H :' || TO_CHAR(TRUNC((86400 * (END_TIME - START_TIME )) / 60) - 60 * (TRUNC(((86400 * (END_TIME - START_TIME )) / 60) / 60))) || ' M :' || TO_CHAR(TRUNC(86400 * (END_TIME - START_TIME )) - 60 * (TRUNC((86400 * (END_TIME - START_TIME )) / 60))) || ' S ' TIME_ELAPSED from (SELECT DISTINCT E.CREATED_BY, TO_CHAR(E.ASSIGN_DATE, 'YYYY-MM-DD HH24:MI:SS') ASSIGN_DATE, E.ASSIGN_TO, E.EBAY_ID, E.TITLE, (SELECT max(D.INSERTED_DATE) FROM LZ_BD_ESTIMATE_DET DD WHERE DD.LZ_BD_ESTIMATE_ID = M.LZ_BD_ESTIMATE_ID) START_TIME, (SELECT MAX(D.INSERTED_DATE) FROM LZ_BD_ESTIMATE_DET DD WHERE DD.LZ_BD_ESTIMATE_ID = M.LZ_BD_ESTIMATE_ID) END_TIME FROM LZ_BD_ITEMS_TO_EST E, LZ_BD_ESTIMATE_MT M, LZ_BD_ESTIMATE_DET D WHERE E.ASSIGN_TO IS NOT NULL AND E.LZ_BD_CATA_ID = M.LZ_BD_CATAG_ID AND M.LZ_BD_ESTIMATE_ID = D.LZ_BD_ESTIMATE_ID )");
     return $query->result_array();
  }
  public function singleUserEstimate(){
    $user_id = $this->input->post("user_id");
    $query = $this->db2->query("SELECT E.CREATED_BY, TO_CHAR(E.ASSIGN_DATE, 'YYYY-MM-DD HH24:MI:SS') ASSIGN_DATE, E.ASSIGN_TO, TO_CHAR(E.ESTIMATE_DATE, 'YYYY-MM-DD HH24:MI:SS') ESTIMATE_DATE FROM LZ_BD_ITEMS_TO_EST E WHERE E.ESTIMATE_DATE IS NOT NULL AND E.ASSIGN_TO = $user_id"); 
    return $query->result_array();
  }
  public function saveBiddingOffer(){
    $bidding_offer = $this->input->post("bidding_offer");
    $lz_bd_catag_id = $this->input->post("lz_bd_catag_id");
    $cat_id = $this->input->post("cat_id");
    $remarks = $this->input->post("remarks");
    $remarks = trim(str_replace("  ", ' ', $remarks));
    $remarks = trim(str_replace(array("'"), "''", $remarks));    
    date_default_timezone_set("America/Chicago");
    $offer_date = date("Y-m-d H:i:s");
    $offer_date = "TO_DATE('".$offer_date."', 'YYYY-MM-DD HH24:MI:SS')";    
    $win_status = "NULL";
    $expire_date = "NULL";
    $revise_date = "NULL";
    $offered_by = $this->session->userdata('user_id'); 
    $revised_by = "NULL";
    $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_PURCHASE_OFFER','OFFER_ID') OFFER_ID FROM DUAL")->result_array();
    $offer_id = $get_pk[0]['OFFER_ID'];
    $insert_query = $this->db2->query("INSERT INTO LZ_BD_PURCHASE_OFFER (OFFER_ID, CATEGORY_ID, OFFER_DATE, LZ_BD_CATA_ID, OFFER_AMOUNT, WIN_STATUS, EXPIRE_DATETIME, REVISE_DATETIME, OFFERED_BY, REVISED_BY, REMARKS) VALUES($offer_id, $cat_id, $offer_date, $lz_bd_catag_id, $bidding_offer, $win_status, $expire_date, $revise_date, $offered_by, $revised_by, '$remarks')");

    if($insert_query){
      return $offer_id;
    }else{
      return 2;
    }

  }
  public function getBiddingOffer(){
    $offer_id = $this->input->post("offer_id");
    $tracking_id = $this->input->post("tracking_id");
    if(!empty($offer_id)){
      $offer_query = $this->db2->query("SELECT O.OFFER_ID, O.OFFER_AMOUNT, O.REMARKS, O.WIN_STATUS, O.SOLD_AMOUNT FROM LZ_BD_PURCHASE_OFFER O WHERE O.OFFER_ID = $offer_id");
      $offer_data =  $offer_query->result_array();
    }else{
      $offer_data = 0;
    }
    if(!empty($tracking_id)){
      $tracking_query = $this->db2->query("SELECT N.TRACKING_NO, N.TRACKING_ID, N.COST_PRICE FROM LZ_BD_TRACKING_NO N WHERE N.TRACKING_ID = $tracking_id");
      $tracking_data =  $tracking_query->result_array();      
    }else{
      $tracking_data = 0;
    }
    return array("offer_data"=>$offer_data, "tracking_data"=>$tracking_data);
  }
  public function getTrackingInfo(){
    $lz_bd_catag_id = $this->input->post("lz_bd_catag_id");
    if(!empty($lz_bd_catag_id)){
      $tracking_query = $this->db2->query("SELECT N.TRACKING_NO, N.TRACKING_ID, N.COST_PRICE FROM LZ_BD_TRACKING_NO N WHERE N.LZ_BD_CATA_ID = $lz_bd_catag_id");
      $tracking_data =  $tracking_query->result_array();      
    }else{
      $tracking_data = 0;
    }

    return array("tracking_data"=>$tracking_data);    
  } 
  public function getSoldAmount(){

    $offer_id = $this->input->post("offer_id");

    if(!empty($offer_id)){
      $sold_amount_query = $this->db2->query("SELECT O.OFFER_ID, O.SOLD_AMOUNT FROM LZ_BD_PURCHASE_OFFER O WHERE O.OFFER_ID = $offer_id");
      $sold_data =  $sold_amount_query->result_array();      
    }else{
      $sold_data = 0;
    }

    return array("sold_data"=>$sold_data);    
  }    
  public function reviseBiddingOffer(){

    $bid_status = $this->input->post("bid_status");
    $update_offer_id = $this->input->post("update_offer_id");
    $update_offer_amount = $this->input->post("update_offer_amount");
    $update_remarks = $this->input->post("update_remarks");
    $update_remarks = trim(str_replace("  ", ' ', $update_remarks));
    $update_remarks = trim(str_replace(array("'"), "''", $update_remarks));     
    date_default_timezone_set("America/Chicago");
    $revise_date = date("Y-m-d H:i:s");
    $revise_date = "TO_DATE('".$revise_date."', 'YYYY-MM-DD HH24:MI:SS')";    
    $revised_by = $this->session->userdata('user_id');

    $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER SET OFFER_AMOUNT = $update_offer_amount, REVISE_DATETIME = $revise_date, REVISED_BY = $revised_by, WIN_STATUS = $bid_status,  REMARKS = '$update_remarks' WHERE OFFER_ID = $update_offer_id");

    if($update_query){
      return 1;
    }else{
      return 2;
    }

  }
  public function saveBiddingStatus(){
    $bid_status = $this->input->post("bid_status");
    $tracking_number = strtoupper(trim($this->input->post("tracking_number")));
    $sale_amount = trim($this->input->post("sale_amount"));
    $update_offer_id = $this->input->post("update_offer_id");
    $lz_cat_id = $this->input->post("lz_cat_id");
    $lz_bd_cata_id = $this->input->post("lz_bd_cata_id");

    $inserted_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $inserted_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";    
  // var_dump('testasds1');
  //           exit;
    if($bid_status == 0){
      $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET WIN_STATUS = $bid_status, SOLD_AMOUNT =  $sale_amount WHERE OFFER_ID = $update_offer_id");
       $mov_stat_into_est = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT ES SET ES.EST_POST_STATUS ='$bid_status' WHERE ES.LZ_BD_CATAG_ID = '$lz_bd_cata_id' ");
      if($update_query){
        return 1;
      }else{
        return 2;
      }
    }elseif($bid_status == 1){ //bid status elseif start

      $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET WIN_STATUS = $bid_status WHERE OFFER_ID = $update_offer_id");
       $mov_stat_into_est = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT ES SET ES.EST_POST_STATUS ='$bid_status' WHERE ES.LZ_BD_CATAG_ID = '$lz_bd_cata_id' ");
      /*======================Tracking Number and Cost start ========================*/
        $table_name= "LZ_BD_ACTIVE_DATA_".$lz_cat_id;
        $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID,T.LZ_ESTIMATE_ID  FROM LZ_BD_TRACKING_NO T WHERE T.LZ_BD_CATA_ID = $lz_bd_cata_id");


        if ($check_tracking_no->num_rows() > 0) {
          
          $tracking_id = $check_tracking_no->result_array()[0]['TRACKING_ID'];
          $get_est_id = $check_tracking_no->result_array()[0]['LZ_ESTIMATE_ID'];

          $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET TRACKING_NO = '$tracking_number',  COST_PRICE = '$sale_amount', INSERTED_DATE = $inserted_date, INSERTED_BY = $inserted_by WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");


            if(!empty($get_est_id)){
              $get_est_id = $check_tracking_no->result_array()[0]['LZ_ESTIMATE_ID'];

            //   var_dump('testasds1');
            // exit;// cost distribution for partial reciving start
               $get_all_estimate = $this->db2->query(" SELECT D.QTY,(D.EST_SELL_PRICE * NVL(D.QTY, 1)) EST_TOTAL_PRICE, (SELECT SUM(DK.EST_SELL_PRICE * NVL(DK.QTY, 1)) FROM LZ_BD_ESTIMATE_DET DK WHERE DK.LZ_BD_ESTIMATE_ID = D.LZ_BD_ESTIMATE_ID GROUP BY DK.LZ_BD_ESTIMATE_ID) SUM_EST, D.LZ_ESTIMATE_DET_ID, D.EST_SELL_PRICE, D.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_DET D WHERE D.LZ_BD_ESTIMATE_ID = $get_est_id ")->result_array() ; 

               //$j=0;
               foreach ($get_all_estimate as  $get_records) {

                 $get_lz_estimate_det_id = $get_records['LZ_ESTIMATE_DET_ID'];
            //      var_dump($get_lz_estimate_det_id);
            // exit;
                 $get_est_sell_price = $get_records['EST_SELL_PRICE'];
                 $get_est_total_price = $get_records['EST_TOTAL_PRICE'];
                 $get_sum_est = $get_records['SUM_EST'];
                 $get_qty = $get_records['QTY'];

                $lnum_item_cost = ($get_est_total_price / $get_sum_est) * 100; 
                $lnum_cost_perc = ($sale_amount * $lnum_item_cost / 100) / $get_qty;

                 $this->db2->query("UPDATE LZ_BD_ESTIMATE_DET L SET L.DIST_COST = $lnum_cost_perc WHERE L.LZ_ESTIMATE_DET_ID =$get_lz_estimate_det_id ");
               //$j++
               }
            }// cost distribution for partial reciving end
            // var_dump('asd');
            // exit;
          if($update_tracking_no){
           
            $tracking_estimate = $this->db2->query("UPDATE  LZ_BD_ITEMS_TO_EST SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");

            $tracking = $this->db2->query("UPDATE  $table_name SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
            if ($tracking) {
               $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_cata_id)");
              return 3;
            }else {
              return 4;
            }
          } //update tracking no if end
        }else { //check_tracking_no if end else start
          $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID FROM LZ_BD_TRACKING_NO T WHERE UPPER(T.TRACKING_NO) = '$tracking_number'");
          if ($check_tracking_no->num_rows() == 0){
            var_dump('test2');
            exit;
            $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
            $rs = $qry->result_array();
            $tracking_id = $rs[0]['ID'];
            $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (TRACKING_NO, LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, COST_PRICE, DE_KIT_YN, INSERTED_DATE, INSERTED_BY) VALUES('$tracking_number', $lz_bd_cata_id, $lz_cat_id, $tracking_id, $sale_amount, NULL, $inserted_date, $inserted_by)");
            if($insert_tracking_no){ //insert tracking no check

              $tracking_estimate = $this->db2->query("UPDATE  LZ_BD_ITEMS_TO_EST SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
              $tracking = $this->db2->query("UPDATE  $table_name SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
              if ($tracking) {
                $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_cata_id)");
                  return 3;  
                }else {
                  return 4;
                }
            } //insert tracking no check if closing
          }else{
            return "exist";
          }
        }//check_tracking_no else closing
    /*======================Tracking Number and Cost end ========================*/

      if($update_query){
        return 1;
      }else{
        return 2;
      }

    } //bid status elseif end

  }
  public function instantSaveBiddingStatus(){
    $bid_status = $this->input->post("bid_status");
    $tracking_number = strtoupper(trim($this->input->post("tracking_number")));
    $sale_amount = trim($this->input->post("sale_amount"));
    $offer_id_save = $this->input->post("offer_id_save");
    $lz_cat_id = $this->input->post("lz_cat_id");
    $lz_bd_cata_id = $this->input->post("lz_bd_cata_id");

    $inserted_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $inserted_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";    

    if($bid_status == 0){
      $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET WIN_STATUS = $bid_status, SOLD_AMOUNT =  $sale_amount WHERE OFFER_ID = $offer_id_save");
      $mov_stat_into_est = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT ES SET ES.EST_POST_STATUS ='$bid_status' WHERE ES.LZ_BD_CATAG_ID = '$lz_bd_cata_id' ");
      if($update_query){
        return 1;
      }else{
        return 2;
      }
    }elseif($bid_status == 1){ //bid status elseif start

      $update_query = $this->db2->query("UPDATE LZ_BD_PURCHASE_OFFER O SET WIN_STATUS = $bid_status WHERE OFFER_ID = $offer_id_save");
      $mov_stat_into_est = $this->db2->query(" UPDATE LZ_BD_ESTIMATE_MT ES SET ES.EST_POST_STATUS ='$bid_status' WHERE ES.LZ_BD_CATAG_ID = '$lz_bd_cata_id' ");

      /*======================Tracking Number and Cost start ========================*/
        $table_name= "LZ_BD_ACTIVE_DATA_".$lz_cat_id;
        $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID,T.LZ_ESTIMATE_ID FROM LZ_BD_TRACKING_NO T WHERE T.LZ_BD_CATA_ID = $lz_bd_cata_id");

        

        if ($check_tracking_no->num_rows() > 0) {
          $tracking_id = $check_tracking_no->result_array()[0]['TRACKING_ID'];
          $get_est_id = $check_tracking_no->result_array()[0]['LZ_ESTIMATE_ID'];

          $update_tracking_no = $this->db2->query("UPDATE  LZ_BD_TRACKING_NO SET TRACKING_NO = '$tracking_number',  COST_PRICE = $sale_amount, INSERTED_DATE = $inserted_date, INSERTED_BY = $inserted_by WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");

          if(!empty($get_est_id)){
             //   var_dump('testasds1');
            // exit;// cost distribution for partial reciving start
               $get_all_estimate = $this->db2->query(" SELECT D.QTY,(D.EST_SELL_PRICE * NVL(D.QTY, 1)) EST_TOTAL_PRICE, (SELECT SUM(DK.EST_SELL_PRICE * NVL(DK.QTY, 1)) FROM LZ_BD_ESTIMATE_DET DK WHERE DK.LZ_BD_ESTIMATE_ID = D.LZ_BD_ESTIMATE_ID GROUP BY DK.LZ_BD_ESTIMATE_ID) SUM_EST, D.LZ_ESTIMATE_DET_ID, D.EST_SELL_PRICE, D.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_DET D WHERE D.LZ_BD_ESTIMATE_ID = $get_est_id ")->result_array() ; 

               //$j=0;
               foreach ($get_all_estimate as  $get_records) {

                 $get_lz_estimate_det_id = $get_records['LZ_ESTIMATE_DET_ID'];
            //      var_dump($get_lz_estimate_det_id);
            // exit;
                 $get_est_sell_price = $get_records['EST_SELL_PRICE'];
                 $get_est_total_price = $get_records['EST_TOTAL_PRICE'];
                 $get_sum_est = $get_records['SUM_EST'];
                 $get_qty = $get_records['QTY'];

                $lnum_item_cost = ($get_est_total_price / $get_sum_est) * 100; 
                $lnum_cost_perc = ($sale_amount * $lnum_item_cost / 100) / $get_qty;

                 $this->db2->query("UPDATE LZ_BD_ESTIMATE_DET L SET L.DIST_COST = $lnum_cost_perc WHERE L.LZ_ESTIMATE_DET_ID =$get_lz_estimate_det_id ");
               //$j++
               }
            }

          if($update_tracking_no){

            $tracking_estimate = $this->db2->query("UPDATE  LZ_BD_ITEMS_TO_EST SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
            $tracking = $this->db2->query("UPDATE  $table_name SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
            if ($tracking) {
               $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_cata_id)");
              return 3;
            }else {
              return 4;
            }
          } //update tracking no if end
        }else { //check_tracking_no if end else start
          $check_tracking_no = $this->db2->query("SELECT T.TRACKING_ID FROM LZ_BD_TRACKING_NO T WHERE UPPER(T.TRACKING_NO) = '$tracking_number'");
          if ($check_tracking_no->num_rows() == 0){
            $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
            $rs = $qry->result_array();
            $tracking_id = $rs[0]['ID'];
            $insert_tracking_no = $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (TRACKING_NO, LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, COST_PRICE, DE_KIT_YN, INSERTED_DATE, INSERTED_BY) VALUES('$tracking_number', $lz_bd_cata_id, $lz_cat_id, $tracking_id, $sale_amount, NULL, $inserted_date, $inserted_by)");
            if($insert_tracking_no){ //insert tracking no check
              $tracking_estimate = $this->db2->query("UPDATE  LZ_BD_ITEMS_TO_EST SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
              $tracking = $this->db2->query("UPDATE  $table_name SET TRACKING_NO = '$tracking_id' WHERE LZ_BD_CATA_ID = $lz_bd_cata_id");
              if ($tracking) {
                $this->db2->query(" call pro_copy_to_remote_server($lz_cat_id,$lz_bd_cata_id)");
                  return 3;  
                }else {
                  return 4;
                }
            } //insert tracking no check if closing
          }else{
            return "exist";
          }
        }//check_tracking_no else closing
    /*======================Tracking Number and Cost end ========================*/

      if($update_query){
        return 1;
      }else{
        return 2;
      }

    } //bid status elseif end

  }  
  public function fetchMpnImages(){
    $res_mpn = $this->input->post('res_mpn');
    $mpn_value = $this->input->post('mpn_value');
    //$mpn_catmt = explode('`',$mpn_value);
    $catalague_mt_id = $mpn_value;
    $mpn_val = $res_mpn;
     ///var_dump($mpn_val); return false;
    // exit;
    $condition = trim($this->input->post('condition'));
   if(!empty($catalague_mt_id)){
    $getMpn = $this->db2->query("SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID =$catalague_mt_id");
    $getMpn = $getMpn->result_array(); 
  }
    $getUpc = $this->db2->query("SELECT I.ITEM_MT_UPC FROM ITEMS_MT@Oraserver I WHERE I.ITEM_MT_MFG_PART_NO = '$mpn_val'");
    $getUpc = $getUpc->result_array();
    $upc = @$getUpc[0]["ITEM_MT_UPC"];
    //var_dump($upc);exit;  

    $old_path =   $this->db2->query("SELECT * FROM LZ_PICT_PATH_CONFIG@Oraserver WHERE PATH_ID = 1");
    $old_path = $old_path->result_array();
    $master_old_path = @$old_path[0]['MASTER_PATH'];
    // $live_old_path = $old_path[0]['LIVE_PATH'];
    //$condition = "New";
    //$res_mpn = "CTRPBMME";
    $mdir = $master_old_path.$upc.'~'.$res_mpn.'/'.@$condition;
    $dir = preg_replace("/[\r\n]*/","",$mdir);
    //var_dump($dir);

    $master_pics = [];
    $parts = [];
    $uri = [];

    // var_dump(is_dir($dir));exit;
    if (is_dir($dir)){
        // var_dump($dir);exit;
        $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
        $i=0 ;

        foreach($images as $image){
            $uri[$i] = $image;
            $parts = explode(".", $image);
            $img_name = explode("/",$image);
            //var_dump($img_name);exit;

            if (is_array($parts) && count($parts) > 1){
                $extension = end($parts);
                if(!empty($extension)){
                    
                    // $live_path = $data['path_query'][0]['LIVE_PATH'];
                    $url = $parts['0'].'.'.$extension;

                    $url = preg_replace("/[\r\n]*/","",$url);

                    // var_dump($url);exit;
                    $uri[$i] = $url;
                    $img = file_get_contents($url);
                    // var_dump($url);exit;
                    $img =base64_encode($img);
                    $master_pics[$i] = $img;

                    $i++;
                }
            }

        }
    }
    if(empty($master_pics)){
      $master_pics = 0;
    }
    if(empty($parts)){
      $parts = 0;
    }
    if(empty($uri)){
      $uri = 0;
    }              
    return array('master_pics'=>@$master_pics,'parts'=>@$parts,'uri'=>@$uri,'getMpn'=>@$getMpn);        
  }
  public function uploadImages(){
    $pic_mpn = trim($this->input->post('pic_mpn'));
    $pic_upc = trim($this->input->post('pic_upc'));
    $pic_condition = trim($this->input->post('pic_condition'));    
    //var_dump($pic_mpn);exit;
    $azRange = range('A', 'Z');
    $this->load->library('image_lib');

    for( $i= 0; $i < count ($_FILES['upload_image']['name']); $i++ ) {

        if(isset($_FILES["upload_image"])) {

        @list(, , $imtype, ) = getimagesize($_FILES['upload_image']['tmp_name'][$i]);
        // Get image type.
        // We use @ to omit errors
        if ($imtype == 3){ // cheking image type
          $ext="png";
        }
        elseif ($imtype == 2){
          $ext="jpeg";
        }
        elseif ($imtype == 1){
          $ext="gif";
        }
        else{
          $msg = 'Error: unknown file format';
           echo $msg;
          exit;
        }
        if(getimagesize($_FILES['upload_image']['tmp_name'][$i]) == FALSE){
          echo "Please select an image.";
        }else{
          $image = addslashes($_FILES['upload_image']['tmp_name'][$i]);
          $name = addslashes($_FILES['upload_image']['name'][$i]);
          $query = $this->db2->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG@Oraserver WHERE PATH_ID = 1");
          $master_qry = $query->result_array();
          $master_path = @$master_qry[0]['MASTER_PATH'];
          $new_dir = $master_path.$pic_upc."~".@$pic_mpn;//."/".@$it_condition;
          //var_dump($new_dir); //exit;

          if(!is_dir($new_dir)){
            mkdir($new_dir);
            //var_dump($new_dir);
          }
          if(!is_dir($new_dir.'/'.$pic_condition)){
            mkdir($new_dir.'/'.$pic_condition);
            //var_dump($new_dir); //exit;
          }
          if (file_exists($new_dir.'/'.$pic_condition.'/'. $name)) {
          echo $name. " <b>already exists.</b> ";
          }else{
            $str = explode('.', $name);
            $extension = end($str);
            $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
            $img_name = '';
            $max = strlen($characters) - 1;
            for ($k = 0; $k < 10; $k++) {
              $img_name .= $characters[mt_rand(0, $max)];
                  
             }
             //$j=$azRange[$i];
            move_uploaded_file($_FILES["upload_image"]["tmp_name"][$i],$new_dir.'/'.$pic_condition.'/'.$azRange[$i].'_'.$img_name.'.'.$extension);
            /*====================================
            =            image resize            =
            ====================================*/
            $config['image_library'] = 'GD2';
              $config['source_image']  = $new_dir."/".$pic_condition."/".$azRange[$i].'_'.$img_name.'.'.$extension;
              $config['new_image']  = $new_dir."/".$pic_condition."/".$azRange[$i].'_'.$img_name.'.'.$extension;
              $config['maintain_ratio']  = true;
              $config['width']   = 1000;
              $config['height'] = 800;
              //$config['create_thumb']  = true;
              //$config['quality']   = 50; this filter doesnt work
            $in =$this->image_lib->initialize($config); 
              $result = $this->image_lib->resize($in);
            $this->image_lib->clear();
            
            /*=====  End of image resize  ======*/
            /*====================================
            =            image thumbnail creation            =
            ====================================*/
            $config['image_library'] = 'GD2';
              $config['source_image']  = $new_dir."/".$pic_condition."/".$azRange[$i].'_'.$img_name.'.'.$extension;
              if(!is_dir($new_dir."/".$pic_condition."/thumb")){
              mkdir($new_dir."/".$pic_condition."/thumb");
            }
              $config['new_image']  = $new_dir."/".$pic_condition."/thumb/".$azRange[$i].'_'.$img_name.'.'.$extension;
              $config['maintain_ratio']  = true;
              $config['width']   = 100;
              $config['height'] = 100;
              
              //$config['quality']   = 50; this filter doesnt work
            $in =$this->image_lib->initialize($config); 
            $result = $this->image_lib->resize($in);
            $this->image_lib->clear();
            
            /*=====  End of image thumbnail creation  ======*/
          }
        }//else if getimage size
      }//if isset file image
    }//main for loop
    return 1;
  }

  public function fetchObjectOnblurCategory(){
    $category_id = $this->input->post('cat_id_obj');
    $query = $this->db2->query("SELECT OBJECT_ID , OBJECT_NAME FROM LZ_BD_OBJECTS_MT WHERE CATEGORY_ID = $category_id");
    $result = $query->result_array();
    return $result;
  }
  public function fetchMPNonClickObject(){
   $cat_comp_obj = $this->input->post('cat_comp_obj');
   $category_id = $this->input->post('cat_id_obj');
   $get_mpns = $this->db2->query("SELECT C.CATALOGUE_MT_ID,C.MPN, C.MPN_DESCRIPTION, C.UPC FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT C WHERE C.OBJECT_ID = O.OBJECT_ID AND C.CATEGORY_ID = $category_id AND C.OBJECT_ID = $cat_comp_obj");
   return $get_mpns->result_array();    
  }


  public function fetchMpnUPC(){
   $cat_comp_mpn = $this->input->post('cat_comp_mpn');
   // var_dump($cat_comp_mpn);
   // exit;
   $get_Mpn = $this->db2->query("SELECT M.UPC FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID=$cat_comp_mpn")->result_array();
   return array('get_Mpn'=>$get_Mpn);    
  } 
  public function addlotToEstimateCatWise(){

    $comp_mpn = $this->input->post('comp_mpn');
    
    $comp_text = $this->input->post('comp_text');
    $comp_object = $this->input->post('comp_object');
    $comp_object = trim(str_replace("  ", ' ', $comp_object));
    $comp_object = trim(str_replace(array("'"), "''", $comp_object));     
    $comp_text = explode("~", $comp_text);
    //$mpn_text =  trim(@$comp_text[0]); // piece1
    $mpn_description =  trim(@$comp_text[1]); // piece2
    //var_dump($mpn_text, $mpn_description);exit;
    $mpn_description = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description = trim(str_replace(array("'"), "''", $mpn_description));
    if(empty($mpn_description)){
      $mpn_description = $comp_object;
    }  

    $get_catupc = $this->input->post('get_catupc');
    $ct_cata_id = $this->input->post('ct_cata_id');
    $condition_id = $this->input->post('condition_id');
    if(empty($condition_id)){
      $condition_id = 3000;
    }

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $estimate_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');

      $check_catalogue = $this->db2->query("SELECT LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT WHERE LZ_BD_CATAG_ID = $ct_cata_id");
      $rs = $check_catalogue->result_array();
      $lz_estimate_id = @$rs[0]['LZ_BD_ESTIMATE_ID'];

      if($check_catalogue->num_rows() > 0) {

        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
        $rs = $qry->result_array();
        $lz_estimate_det_id = @$rs[0]['ID'];
        
        $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $comp_mpn, '$mpn_description', $estimate_date)");
 
        // UPDATE UPC for Mpn on Estimated Lot
        $update_catalgoue_mt=$this->db2->query("UPDATE LZ_CATALOGUE_MT SET UPC=' $get_catupc' WHERE CATALOGUE_MT_ID = $comp_mpn"); 

        if($insert_est_det) {

            $detail_query = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID,U.KEYWORD FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT,LZ_BD_RSS_FEED_URL U WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = U.CATLALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $comp_mpn ORDER BY DT.TECH_COND_ID ASC");
            $detail = $detail_query->result_array();
            $res_mpn = @$detail[0]['MPN'];
            $condition = @$detail[0]['TECH_COND_ID'];

            /*========= Picture script start =========*/ 

              $getUpc = $this->db2->query("SELECT I.ITEM_MT_UPC FROM ITEMS_MT@Oraserver I WHERE I.ITEM_MT_MFG_PART_NO = '$res_mpn'");
              $getUpc = $getUpc->result_array();
              $upc = @$getUpc[0]["ITEM_MT_UPC"];
              //var_dump($upc);exit;  

              $old_path =   $this->db2->query("SELECT * FROM LZ_PICT_PATH_CONFIG@Oraserver WHERE PATH_ID = 1");
              $old_path = $old_path->result_array();
              $master_old_path = @$old_path[0]['MASTER_PATH'];
              // $live_old_path = $old_path[0]['LIVE_PATH'];
              //$condition = "New";
              //$res_mpn = "CTRPBMME";
              if(is_numeric(@$condition)){
                  if(@$condition == 3000){
                    @$condition = 'Used';
                  }elseif(@$condition == 1000){
                    @$condition = 'New'; 
                  }elseif(@$condition == 1500){
                    @$condition = 'New other'; 
                  }elseif(@$condition == 2000){
                      @$condition = 'Manufacturer refurbished';
                  }elseif(@$condition == 2500){
                    @$condition = 'Seller refurbished'; 
                  }elseif(@$condition == 7000){
                    @$condition = 'For parts or not working'; 
                  }
                }               
              $mdir = $master_old_path.$upc.'~'.$res_mpn.'/'.@$condition.'/thumb/';
              $dir = preg_replace("/[\r\n]*/","",$mdir);
              //var_dump($dir);

              $master_pics = [];
              $parts = [];
              $uri = [];

              // var_dump(is_dir($dir));exit;
              if (is_dir($dir)){
                  //var_dump($dir);
                  $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
                  $i=0 ;

                  foreach($images as $image){
                    $uri[$i] = $image;
                    $parts = explode(".", $image);
                    $img_name = explode("/",$image);
                    //var_dump($img_name);//exit;

                    if (is_array($parts) && count($parts) > 1){
                      $extension = end($parts);
                      if(!empty($extension)){
                          
                        // $live_path = $data['path_query'][0]['LIVE_PATH'];
                        $url = $parts['0'].'.'.$extension;

                        $url = preg_replace("/[\r\n]*/","",$url);

                        // var_dump($url);exit;
                        $uri[$i] = $url;
                        $img = file_get_contents($url);
                        // var_dump($url);exit;
                        $img =base64_encode($img);
                        $master_pics[$i] = $img;

                        $i++;
                      }
                    }

                  }
              }
              if(empty($master_pics)){
                $master_pics = 0;
              }
              if(empty($parts)){
                $parts = 0;
              }
              if(empty($uri)){
                $uri = 0;
              }               
            /*========= Picture script end =========*/            
            $condition_id = @$detail[0]['TECH_COND_ID'];
            $estimate_price = $this->db2->query("SELECT NVL(EST_SELL_PRICE, 0) EST_SELL_PRICE FROM (SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.PART_CATLG_MT_ID = $comp_mpn AND D.EST_SELL_PRICE IS NOT NULL AND D.TECH_COND_ID = $condition_id ORDER BY D.LZ_ESTIMATE_DET_ID DESC) WHERE ROWNUM = 1"); 
            if($estimate_price->num_rows() > 0){
              $rs = $estimate_price->result_array();
              $estimate = @$rs[0]['EST_SELL_PRICE'];
              
            }else{
              $estimate = 0.00;
            }
            //print_r($estimate);
            return array("detail"=>$detail, "estimate"=>$estimate, "master_pics"=>$master_pics, "parts"=>$parts, "uri"=>$uri);

        }else {
          return 2;
        } 
        
      }else {
        //echo "yesss"; exit;
        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
        $lz_estimate_id = @$rs[0]['ID'];

        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id, $ct_cata_id, $estimate_date, $user_id)");

        /*===== If Item is not Assigned to a user start ======*/
          date_default_timezone_set("America/Chicago");
          $date = date("Y-m-d H:i:s");
          $assign_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
          $created_by = $this->session->userdata('user_id');     
          $assign_to = $this->session->userdata('user_id');
          //$lz_bd_cata_id = $this->input->post('lz_bd_cata_id');
       
          $query = $this->db2->query("UPDATE LZ_BD_ITEMS_TO_EST SET CREATED_BY = $created_by, ASSIGN_DATE = $assign_date, ASSIGN_TO = $assign_to WHERE LZ_BD_CATA_ID = $ct_cata_id ");

        /*===== If Item is not Assigned to a user end ======*/

        if($insert_est_mt) {
            $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
            $rs = $qry->result_array();
            $lz_estimate_det_id = @$rs[0]['ID'];
            
            $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $comp_mpn, '$mpn_description', $assign_date)");

          if ($insert_est_det) {
            $detail_query = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $comp_mpn");
            $detail = $detail_query->result_array();
            $res_mpn = @$detail[0]['MPN'];
            $condition = @$detail[0]['TECH_COND_ID'];

            /*========= Picture script start =========*/ 

              $getUpc = $this->db2->query("SELECT I.ITEM_MT_UPC FROM ITEMS_MT@Oraserver I WHERE I.ITEM_MT_MFG_PART_NO = '$res_mpn'");
              $getUpc = $getUpc->result_array();
              $upc = @$getUpc[0]["ITEM_MT_UPC"];
              //var_dump($upc);exit;  

              $old_path =   $this->db2->query("SELECT * FROM LZ_PICT_PATH_CONFIG@Oraserver WHERE PATH_ID = 1");
              $old_path = $old_path->result_array();
              $master_old_path = @$old_path[0]['MASTER_PATH'];
              // $live_old_path = $old_path[0]['LIVE_PATH'];
              //$condition = "New";
              //$res_mpn = "CTRPBMME";
              if(is_numeric(@$condition)){
                  if(@$condition == 3000){
                    @$condition = 'Used';
                  }elseif(@$condition == 1000){
                    @$condition = 'New'; 
                  }elseif(@$condition == 1500){
                    @$condition = 'New other'; 
                  }elseif(@$condition == 2000){
                      @$condition = 'Manufacturer refurbished';
                  }elseif(@$condition == 2500){
                    @$condition = 'Seller refurbished'; 
                  }elseif(@$condition == 7000){
                    @$condition = 'For parts or not working'; 
                  }
                }              
              $mdir = $master_old_path.$upc.'~'.$res_mpn.'/'.@$condition;
              $dir = preg_replace("/[\r\n]*/","",$mdir);

              $master_pics = [];
              $parts = [];
              $uri = [];

              // var_dump(is_dir($dir));exit;
              if (is_dir($dir)){
                // var_dump($dir);exit;
                $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
                $i=0 ;

                foreach($images as $image){
                  $uri[$i] = $image;
                  $parts = explode(".", $image);
                  $img_name = explode("/",$image);
                  //var_dump($img_name);exit;

                  if (is_array($parts) && count($parts) > 1){
                    $extension = end($parts);
                    if(!empty($extension)){
                        
                      // $live_path = $data['path_query'][0]['LIVE_PATH'];
                      $url = $parts['0'].'.'.$extension;

                      $url = preg_replace("/[\r\n]*/","",$url);

                      // var_dump($url);exit;
                      $uri[$i] = $url;
                      $img = file_get_contents($url);
                      // var_dump($url);exit;
                      $img =base64_encode($img);
                      $master_pics[$i] = $img;

                      $i++;
                    }
                  }

                }
              }
              if(empty($master_pics)){
                $master_pics = 0;
              }
              if(empty($parts)){
                $parts = 0;
              }
              if(empty($uri)){
                $uri = 0;
              }               

            /*========= Picture script end =========*/

            $estimate_price = $this->db2->query("SELECT NVL(EST_SELL_PRICE, 0) EST_SELL_PRICE FROM (SELECT D.EST_SELL_PRICE FROM LZ_BD_ESTIMATE_DET D WHERE D.PART_CATLG_MT_ID = $comp_mpn AND D.EST_SELL_PRICE IS NOT NULL ORDER BY D.LZ_ESTIMATE_DET_ID DESC) WHERE ROWNUM = 1"); 

            if($estimate_price->num_rows() > 0){
              $rs = $estimate_price->result_array();
              $estimate = @$rs[0]['EST_SELL_PRICE'];
              
            }else{
              $estimate = 0.00;
            }
            return array("detail"=>$detail, "estimate"=>$estimate, "master_pics"=>$master_pics, "parts"=>$parts, "uri"=>$uri);

          }else {
            return 2;
          } 

        } //$insert_est_mt if closing 
      }//main else closing  
  }
  ///////////////////////////
  public function addtokit() {
  $parts_catalogue_id   = $this->input->post('partCatalogueId');
  $catalogue_mt_id      = $this->input->post('catalogueId');
  $category_id          = $this->input->post('categoryId');
  $cata_id              = $this->input->post('cata_id');
  $condition_id         = $this->input->post('condition_id');
  $comp_mpn_id          = $this->input->post('comp_mpn_id');
  $object_name          = strtoupper($this->input->post('objectName'));
  $object_input         = trim(strtoupper($this->input->post("objectInput")));
  $object_input         = str_replace("'","''", $object_input);
  $dd_Object_Id         = $this->input->post("ddObjectId");
  $mpn_desc             = trim($this->input->post("mpnDesc"));
  $mpn_desc             = str_replace("'","''", $mpn_desc);
  $input_upc            = trim($this->input->post("input_upc"));
  $comp_upc             = trim(strtoupper($input_upc));
  $input_upc            = str_replace("  "," ", $comp_upc);
  $input_upc            = str_replace("'","''", $input_upc);
  $mpn                  = trim($this->input->post("inputText"));
  $mpn                  = str_replace("'","''", $mpn);

  //var_dump($object_name, $dd_Object_Id, $cata_id, $condition_id, $comp_mpn_id); exit;
////////////////////////////////////
  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $created_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $user_id = $this->session->userdata('user_id');
  ////////////////////////////////// 
  $flag = '';
  //var_dump($input_upc, $object_input, $dd_Object_Id); exit;
      if(empty($object_name)){
       // check object id
        if($dd_Object_Id == 0){
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
      //////////////////////////
      //////////////////////////
        /*=====  End of check object name  ======*/

    $check_mpn = $this->db2->query("SELECT CATALOGUE_MT_ID, MPN_DESCRIPTION FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn' AND CATEGORY_ID = $category_id");

    if($check_mpn->num_rows() == 0){
      $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
      $get_pk = $get_pk->result_array();
      $parts_catalogue_id = $get_pk[0]['CATALOGUE_MT_ID'];
  
      $insert_mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED, LAST_RUN_TIME, UPC)VALUES($parts_catalogue_id,'$mpn',$category_id,sysdate,2,0,$object_id_pk,'$mpn_desc',0,null, '$input_upc')");
    }else{
      $check_mpn = $check_mpn->result_array();
      $parts_catalogue_id = $check_mpn[0]['CATALOGUE_MT_ID'];
      $this->db2->query("UPDATE LZ_CATALOGUE_MT SET OBJECT_ID = $object_id_pk, UPC = '$input_upc'  WHERE CATALOGUE_MT_ID = $parts_catalogue_id");
    }
    /*=====  End of insert mpn in catalogue_mt  ======*/
    ///////////////////////////////
    //////////////////////////////
    }
      
    
   

   $check_estimate = $this->db2->query("SELECT  M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.LZ_BD_CATAG_ID = $cata_id");
  
    if ($check_estimate->num_rows() === 0) {
      $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
        $lz_estimate_id = @$rs[0]['ID'];
        //var_dump($lz_estimate_id, 'first'); exit;

        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id, $cata_id, $created_date, $user_id)");

        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
        $rs = $qry->result_array();
        $lz_estimate_det_id = @$rs[0]['ID'];
            
        $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $parts_catalogue_id, '$mpn_desc', $created_date)");
    }else{
      $estimate_id = $check_estimate->result_array();
      $lz_estimate_id = $estimate_id[0]['LZ_BD_ESTIMATE_ID'];
      //var_dump($lz_estimate_id, 'second'); exit;
      //var_dump($lz_estimate_id); exit;
      $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
      $rs = $qry->result_array();
      $lz_estimate_det_id = @$rs[0]['ID'];


      $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $parts_catalogue_id, '$mpn_desc', $created_date)");
     
    }
     //var_dump($parts_catalogue_id, $check_mpn->num_rows(), $check_estimate->num_rows(), $lz_estimate_det_id); exit;
    /*=====  End of check if alt mpn exist or not  ======*/
 if ($insert_est_det) {
        $flag = 1;
      }else{
        $flag = 0;
      }
  ///////////////APPEND ROW SECTION START/////////////////////////
    if ($flag == 1) {
    $results = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION,DT.EST_SELL_PRICE, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $parts_catalogue_id");

      $result = $results->result_array();

      $total = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND MT.LZ_BD_CATAG_ID = $cata_id"); 
      $total_components = $total->result_array();
      $totals = count($total_components);

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals, 'flag' => $flag);

    }else{
      return array('flag' => $flag);
    }
  }

  public function queryData($perameter,$brnd){ 
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
    
    $columns     = array(
      // datatable column index  => database column name
      0 => 'ACTION',
      1 => 'OBJECT_NAME',
      2 => 'CATEGORY_ID',
      3 => 'MPN_DESCRIPTION',
      4 => 'MPN',
      5 => 'UPC'
    );

  $sql = "SELECT NULL, I.ITEM_MT_DESC ,MPN_DESCRIPTION, C.CATALOGUE_MT_ID, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_UPC UPC, O.OBJECT_ID, O.OBJECT_NAME, C.CATEGORY_ID, M.ID CONDITION_ID FROM LZ_MANIFEST_MT@Oraserver  LM, LZ_MANIFEST_det@Oraserver I, LZ_BD_OBJECTS_MT          O, LZ_CATALOGUE_MT           C, LZ_ITEM_COND_MT@Oraserver M WHERE UPPER(C.MPN) = UPPER(I.ITEM_MT_MFG_PART_NO) AND C.OBJECT_ID = O.OBJECT_ID AND LM.LZ_MANIFEST_ID = I.LZ_MANIFEST_ID AND UPPER(M.COND_NAME) = UPPER(I.CONDITIONS_SEG5) "; 
      /*==============================================
      =            to search word by word            =
      ==============================================*/
      $str = explode(' ', $perameter);
          if(count($str)>1){
            
            foreach ($str as $value) {

              $sql .= " AND ( upper(I.ITEM_MT_DESC) like '%".$value."%' or upper(I.ITEM_MT_MFG_PART_NO) like '%".$value."%'or I.ITEM_MT_UPC like '%".$value."%' or upper(O.OBJECT_NAME) like '%".$value."%' or C.CATEGORY_ID like '%".$value."%')";
            }

          }else{
            $sql .= " AND ( upper(I.ITEM_MT_DESC) like '%".$perameter."%' or upper(I.ITEM_MT_MFG_PART_NO) like '%".$perameter."%'or I.ITEM_MT_UPC like '%".$perameter."%' or upper(O.OBJECT_NAME) like '%".$perameter."%' or C.CATEGORY_ID like '%".$perameter."%')";
          }

        if(!empty($brnd)){
          $sql .= " AND OBJECT_NAME ='$brnd' ";

        }


      /*=====  End of to search word by word  ======*/

      
       if( !empty($requestData['search']['value']) ) {
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" AND ( upper(O.OBJECT_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') ";
          $sql.=" OR upper(I.ITEM_MT_DESC) LIKE upper('%".trim($requestData['search']['value'])."%') ";  
          $sql.=" OR C.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR I.ITEM_MT_UPC LIKE '%".trim($requestData['search']['value'])."%'";
          $sql.=" OR upper(I.ITEM_MT_MFG_PART_NO) LIKE upper('%".trim($requestData['search']['value'])."%') )"; 
      }
  if( !empty($requestData['search']['value']) ) {
      $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
     }else{
      $sql .= " ORDER BY LM.LZ_MANIFEST_ID DESC";
     }   
  
    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;

    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;

    $query         = $this->db2->query($sql)->result_array();
    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $catalogue_mt_id = $row['CATALOGUE_MT_ID'];
      $object_name = $row['OBJECT_NAME'];
      $object_id = $row['OBJECT_ID'];
      $condition_id = $row['CONDITION_ID'];
      $upc = $row['UPC'];
      
      $nestedData[] ='<div style="width:168px;"><input type = "button"  upc="'.$upc.'" cid="'.$condition_id.'" mid = "'.$catalogue_mt_id.$i.'c" id = "'.$catalogue_mt_id.'"  name = "'.$i.'" class = "btn btn-success btn-sm addUpcTokit pull-left" value = "Add to Kit"><input type = "hidden" name = "'.$object_name.'" id = "object_name_'.$i.'" value = "'.$object_name.'"></div>';
      $nestedData[] = '<div style="width:239px;" ><input type = "hidden" name = "'.$object_name.'"  value = "'.$object_id.'" class="objectIs">'.$row['OBJECT_NAME'].'</div>';
      $nestedData[] = $row['CATEGORY_ID'];
      $nestedData[] = '<div style="width:600px;"> <input style="width:100%;" type = "text" class="form-control" id = "input_title" name = "input_title" value = "'.htmlentities($row['MPN_DESCRIPTION']).'"></div>';
      //$nestedData[] = $row['MPN_DESCRIPTION'];
      $nestedData[] = $row['MPN'];
      $nestedData[] = '<input type = "text" name = "search_comp_upc"  value = "'.$row['UPC'].'" class="form-control search_comp_upc">';
      $nestedData[] = ''; 
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

 public function addUpcTokit() {
  $parts_catalogue_id   = $this->input->post('partCatalogueId');
  $catalogue_mt_id      = $this->input->post('catalogueId');
  $category_id          = $this->input->post('categoryId');
  $cata_id              = $this->input->post('cata_id');
  $condition_id         = $this->input->post('condition_id');

  $object_name          = strtoupper($this->input->post('objectName'));
  $object_input         = trim(strtoupper($this->input->post("objectInput")));
  $object_input         = str_replace("'","''", $object_input);
  $dd_Object_Id         = $this->input->post("ddObjectId");
  $mpn_desc             = trim($this->input->post("mpnDesc"));
  $mpn_desc             = str_replace("'","''", $mpn_desc);
  $input_upc            = trim($this->input->post("input_upc"));
  $comp_upc             = trim(strtoupper($input_upc));
  $input_upc            = str_replace("  "," ", $comp_upc);
  $input_upc            = str_replace("'","''", $input_upc);
  $mpn                  = trim($this->input->post("inputText"));
  $mpn                  = str_replace("'","''", $mpn);

  //var_dump($object_name, $dd_Object_Id, $cata_id, $condition_id, $comp_mpn_id); exit;
////////////////////////////////////
  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $created_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $user_id = $this->session->userdata('user_id');
  ////////////////////////////////// 
  $flag = '';
  //var_dump($input_upc, $object_input, $dd_Object_Id); exit;
      if(empty($object_name)){
       // check object id
        if($dd_Object_Id == 0){
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
      //////////////////////////
      //////////////////////////
        /*=====  End of check object name  ======*/

    $check_mpn = $this->db2->query("SELECT CATALOGUE_MT_ID, MPN_DESCRIPTION FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$catalogue_mt_id' AND CATEGORY_ID = $category_id");

    if($check_mpn->num_rows() == 0){
      $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
      $get_pk = $get_pk->result_array();
      $parts_catalogue_id = $get_pk[0]['CATALOGUE_MT_ID'];
  
      $insert_mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED, LAST_RUN_TIME, UPC)VALUES($parts_catalogue_id,'$catalogue_mt_id',$category_id,sysdate,2,0,$object_id_pk,'$mpn_desc',0,null, '$input_upc')");
    }else{
      $check_mpn = $check_mpn->result_array();
      $parts_catalogue_id = $check_mpn[0]['CATALOGUE_MT_ID'];
      $this->db2->query("UPDATE LZ_CATALOGUE_MT SET OBJECT_ID = $object_id_pk, UPC = '$input_upc'  WHERE CATALOGUE_MT_ID = $parts_catalogue_id");
    }
    /*=====  End of insert mpn in catalogue_mt  ======*/
    ///////////////////////////////
    //////////////////////////////
    }
      
    
   

   $check_estimate = $this->db2->query("SELECT  M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE M.LZ_BD_CATAG_ID = $cata_id");
  
    if ($check_estimate->num_rows() === 0) {
      $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
        $rs = $qry->result_array();
        $lz_estimate_id = @$rs[0]['ID'];
        //var_dump($lz_estimate_id, 'first'); exit;

        $insert_est_mt = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY) VALUES($lz_estimate_id, $cata_id, $created_date, $user_id)");

        $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
        $rs = $qry->result_array();
        $lz_estimate_det_id = @$rs[0]['ID'];
            
        $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $parts_catalogue_id, '$mpn_desc', $created_date)");
    }else{
      $estimate_id = $check_estimate->result_array();
      $lz_estimate_id = $estimate_id[0]['LZ_BD_ESTIMATE_ID'];
      //var_dump($lz_estimate_id, 'second'); exit;
      //var_dump($lz_estimate_id); exit;
      $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL"); 
      $rs = $qry->result_array();
      $lz_estimate_det_id = @$rs[0]['ID'];


      $insert_est_det = $this->db2->query("INSERT INTO LZ_BD_ESTIMATE_DET (LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, TECH_COND_ID, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_estimate_id, $condition_id, $parts_catalogue_id, '$mpn_desc', $created_date)");
     
    }
     //var_dump($parts_catalogue_id, $check_mpn->num_rows(), $check_estimate->num_rows(), $lz_estimate_det_id); exit;
    /*=====  End of check if alt mpn exist or not  ======*/
 if ($insert_est_det) {
        $flag = 1;
      }else{
        $flag = 0;
      }
  ///////////////APPEND ROW SECTION START/////////////////////////
    if ($flag == 1) {
    $results = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION,DT.EST_SELL_PRICE, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND DT.PART_CATLG_MT_ID = $parts_catalogue_id");

      $result = $results->result_array();

      $total = $this->db2->query("SELECT M.MPN, M.UPC, DT.MPN_DESCRIPTION, M.CATEGORY_ID, O.OBJECT_ID, O.OBJECT_NAME, MT.LZ_BD_ESTIMATE_ID, DT.LZ_ESTIMATE_DET_ID, DT.TECH_COND_ID, DT.PART_CATLG_MT_ID FROM LZ_CATALOGUE_MT M, LZ_BD_OBJECTS_MT O, MPN_AVG_PRICE A, LZ_BD_ESTIMATE_MT MT, LZ_BD_ESTIMATE_DET DT WHERE M.OBJECT_ID = O.OBJECT_ID AND MT.LZ_BD_ESTIMATE_ID = DT.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = DT.PART_CATLG_MT_ID AND M.CATALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND MT.LZ_BD_ESTIMATE_ID = $lz_estimate_id AND MT.LZ_BD_CATAG_ID = $cata_id"); 
      $total_components = $total->result_array();
      $totals = count($total_components);

      $conditions = $this->db2->query("SELECT ID, COND_NAME FROM LZ_ITEM_COND_MT")->result_array();

    return array('result'=>$result, 'conditions' => $conditions, 'totals' => $totals, 'flag' => $flag);

    }else{
      return array('flag' => $flag);
    }
  }
public function market_place(){

    $query = $this->db2->query("SELECT * FROM LZ_PORTAL_MT@ORASERVER  order by PORTAL_ID asc "); 
    return $query->result_array();
  }

  public function saveItems(){
  $ref_no                 = $this->input->post('ref_no');
  $ref_nnumber            = str_replace("'","''", $ref_no);
  $ref_no                 = str_replace("'","''", $ref_nnumber); 

  $item_description       = trim($this->input->post("item_description"));
  $item_desc              = str_replace("'","''", $item_description);
  $item_desc              = str_replace("'","''", $item_desc);

  $start_date             = trim($this->input->post("start_date"));
  $todate = date_create($start_date);
  $start_date = date_format($todate,'Y-m-d');
  $start_date             = "TO_DATE('".$start_date."', 'YYYY-MM-DD HH24:MI:SS')";

  $end_date               = trim($this->input->post("end_date"));
  $end_date = date_create($end_date);
  $end_date = date_format($end_date,'Y-m-d');
  $end_date               = "TO_DATE('".$end_date."', 'YYYY-MM-DD HH24:MI:SS')";

  $list_price             = trim($this->input->post("list_price"));

  $item_url               = trim($this->input->post("item_url"));
  $item_url               = str_replace("'","''", $item_url);
  $item_url               = str_replace("'","''", $item_url);

 //var_dump($object_name, $dd_Object_Id, $cata_id, $condition_id, $comp_mpn_id); exit;
 ////////////////////////////////////
  
  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $created_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $user_id = $this->session->userdata('user_id');
  $items = $this->db2->query("SELECT M.EBAY_ID FROM LZ_BD_ITEMS_TO_EST M WHERE M.EBAY_ID = '$ref_no'")->result_array();
  if (count($items) == 0) {
    $sequence_id = $this->db2->query("SELECT lz_bd_active_id_seq.nextval ID FROM DUAL");
    $sequence_id = $sequence_id->result_array();
    $lz_bd_cata_id = $sequence_id[0]['ID'];

    $insert_item = $this->db2->query("INSERT INTO LZ_BD_ITEMS_TO_EST(LZ_BD_CATA_ID, EBAY_ID, TITLE, ITEM_URL, SALE_PRICE, START_TIME, SALE_TIME, INSERTED_DATE, STATUS, FLAG_ID, LOTSONLY, IS_DELETED, CATEGORY_ID,CONDITION_ID,CONDITION_NAME) VALUES($lz_bd_cata_id, '$ref_no', '$item_desc', '$item_url', '$list_price',  $start_date, $end_date, $created_date, 'ACTIVE', 29, 1, 0, 111222333444,3000,'Used')");



    if ($insert_item) {
      $comma = ',';
      $active_tab_qry = "INSERT INTO LZ_BD_ACTIVE_DATA_111222333444 (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE,  ITEM_URL, SALE_PRICE, START_TIME, SALE_TIME, INSERTED_DATE, STATUS,MAIN_CATEGORY_ID, FLAG_ID, LOTSONLY,CONDITION_ID,CONDITION_NAME) VALUES($lz_bd_cata_id $comma 111222333444 $comma '$ref_no' $comma '$item_desc' $comma '$item_url' $comma $list_price  $comma $start_date $comma $end_date $comma $created_date  $comma 'ACTIVE' $comma '111222333444' $comma 29 $comma 1 $comma 3000 $comma 'Used')"; 

      //echo $insert_qry;exit;  
      $qry = $this->db2->query($active_tab_qry);


      return 1;
    }else{
      return 2;
    }

  }else{
    return 3;
  }

}
public function saveMarket(){
  $market_name                 = trim($this->input->post('market_name'));
  $market_name                 = str_replace("'","''", $market_name);
  $market_name                 = strtoupper(str_replace("'","''", $market_name)); 
  
  $markets = $this->db2->query("SELECT * FROM LZ_PORTAL_MT@oraserver M WHERE UPPER(M.PORTAL_DESC) = '$market_name'")->result_array();
  if (count($markets) == 0) {
      $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY@oraserver('LZ_PORTAL_MT','PORTAL_ID') ID FROM DUAL"); 
      $rs = $qry->result_array();
      $portal_id = @$rs[0]['ID'];
     $insert_market = $this->db2->query("INSERT INTO LZ_PORTAL_MT@oraserver(PORTAL_ID, PORTAL_DESC) VALUES($portal_id, '$market_name')");
    if ($insert_market) {
      return 1;
    }else{
      return 2;
    }
  }else{
    return 3;
  }
}
public function checkOfferAmount(){
  
  $lot_cata_id  = $this->input->post('lot_cata_id');
 //var_dump($lot_cata_id); exit;
  return $markets = $this->db2->query("SELECT M.OFFER_ID, M.LZ_BD_CATA_ID, M.OFFER_AMOUNT, T.TRACKING_ID FROM LZ_BD_PURCHASE_OFFER M, LZ_BD_TRACKING_NO T WHERE M.LZ_BD_CATA_ID = T.LZ_BD_CATA_ID
AND M.LZ_BD_CATA_ID = $lot_cata_id")->result_array();
}

public  function import_xls_record(){ 
        $this->load->library('PHPExcel');
        $ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION);
        $columns    = $this->input->post("columns");
        $alphabets  = $this->input->post("alphabets");
        $file_columns = explode(',', $columns);
        $file_alphabets = explode(',', $alphabets);
        //var_dump($file_columns, $file_alphabets); exit;
        //$filename = $_FILES["file_name"]["name"];
        //echo "<pre>";
        //print_r($file_columns);
        //exit;
        //var_dump($filename, $columns, $alphabets);exit;
          if ($ext !='xlsx'){
            echo "Only Excel files with .xlsx ext are allowed.";
            // $this->session->set_userdata('ERROR' , 'Only Excel files are allowed.');
            // redirect(base_url() . 'index.php/manifest_loading/csv');
        }else{
                    // $ip = $_SERVER['REMOTE_ADDR'];
                    $filename = $this->input->post('file_name').'.'.$ext;
                    //var_dump($_FILES["file_name"]["tmp_name"]);exit;
                    move_uploaded_file($_FILES["file_name"]["tmp_name"],$filename);

                    // move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
                    if(strtolower($ext) == 'xlsx'){
                      $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                      $objReader->setReadDataOnly(true);
                    }

                    $objPHPExcel = $objReader->load($filename);
                    $objWorksheet = $objPHPExcel->getActiveSheet();
                    $i=1;
                    $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;

                    $item_condition = 3000;
                    $ct_cata_id = $this->input->post('ct_cata_id');
          
                    require('/../manifest_loading/get-common/Productionkeys.php'); 
                    require('/../manifest_loading/get-common/eBaySession.php');

                    //var_dump($ct_cata_id); exit;
                    //  ============== Mt table insert Start ====================
                    date_default_timezone_set("America/Chicago");
                    $date = date('Y-m-d H:i:s');
                    $estimate_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
                    $user_id = $this->session->userdata('user_id');

                    $items = $this->db2->query("SELECT T.TITLE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ITEMS_TO_EST T WHERE M.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID AND M.LZ_BD_CATAG_ID = $ct_cata_id")->result_array();

                  if (count($items) > 0) {
                    $title = $items[0]['TITLE'];
                  }else{
                    $title = '';
                  }
                  ///////////////////////////

                     $items_cata = $this->db2->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE  M.LZ_BD_CATAG_ID = $ct_cata_id")->result_array();

                  if (count($items_cata) == 0) {
                     $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $lz_bd_estimate_id = $rs[0]['ID'];
                    $qry_mt = "INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY, KIT_LOT , ESTIMATE_DESC) VALUES($lz_bd_estimate_id, $ct_cata_id, $estimate_date, $user_id, 'L', '$title')";
                    $result =$this->db2->query($qry_mt);
                    

                  }else{
                    $lz_bd_estimate_id = $items_cata[0]['LZ_BD_ESTIMATE_ID'];
                  }
  
                    //  ==============Mt Table insert End =====================
                    //var_dump(count($objWorksheet)); exit;
                  $k = 0;
                      foreach ($file_columns as $column) 
                      {
                        if ($column ==="MPN") {
                         $alphabet_mpn = strtoupper($file_alphabets[$k]);
                        }
                        if ($column ==="MPN_DESCRIPTION") {
                          $alphabet_mpn_desc = strtoupper($file_alphabets[$k]);
                        }
                        if ($column ==="UPC") {
                          $alphabet_upc = strtoupper($file_alphabets[$k]);
                        }
                        if ($column ==="OBJECT NAME") {
                          $alphabet_obj_name = strtoupper($file_alphabets[$k]);
                        }
                        if ($column ==="ITEM_MANUFACTURER") {
                          $alphabet_manuf = strtoupper($file_alphabets[$k]);
                        }
                        if ($column ==="QTY") {
                          $alphabet_qty = strtoupper($file_alphabets[$k]);
                        }else{
                          $alphabet_qty = '';
                        }
                        $k++;
                      }
                    //var_dump($alphabet_mpn, $alphabet_mpn_desc, $alphabet_upc, $alphabet_obj_name,  $alphabet_manuf, $alphabet_qty);

                    foreach ($objWorksheet->getRowIterator() as $row){
                        if($i !=1){
          
                        $ITEM_MT_MANUFACTURE  = $objPHPExcel->getActiveSheet()->getCell($alphabet_manuf.$i)->getCalculatedValue();
                        $ITEM_MT_MANUFACTURE  = trim(str_replace("  ", ' ', $ITEM_MT_MANUFACTURE));
                        $ITEM_MT_MANUFACTURE  = trim(str_replace(array("'"), "''", $ITEM_MT_MANUFACTURE));
                        $BRAND_SEG3           = $ITEM_MT_MANUFACTURE;

                        $ITEM_MT_MFG_PART_NO  = $objPHPExcel->getActiveSheet()->getCell($alphabet_mpn.$i)->getCalculatedValue(); 
                        $ITEM_MT_MFG_PART_NO  = trim(str_replace(" ", '', $ITEM_MT_MFG_PART_NO));
                        $ITEM_MT_MFG_PART_NO  = strtoupper(trim(str_replace(array("'"), "''", $ITEM_MT_MFG_PART_NO)));

                        $ITEM_MT_DESC         = $objPHPExcel->getActiveSheet()->getCell($alphabet_mpn_desc.$i)->getCalculatedValue();
                        $ITEM_MT_DESC         = trim(str_replace("  ", ' ', $ITEM_MT_DESC));
                        $ITEM_MT_DESC         = trim(str_replace(array("'"), "''", $ITEM_MT_DESC));

                        $ITEM_MT_UPC          = $objPHPExcel->getActiveSheet()->getCell($alphabet_upc.$i)->getCalculatedValue();
                        $ITEM_MT_UPC          = trim(str_replace(" ", '', $ITEM_MT_UPC));
                        $ITEM_MT_UPC          = trim(str_replace(array("'"), "", $ITEM_MT_UPC));
                 
                        $object_name          = $objPHPExcel->getActiveSheet()->getCell($alphabet_obj_name.$i)->getCalculatedValue();
                        $object_name          = trim(str_replace("  ", ' ', $object_name));
                        $object_name          = trim(str_replace(array("'"), "''", $object_name)); 
                        if (!empty($alphabet_qty)) {
                           $qty          = $objPHPExcel->getActiveSheet()->getCell($alphabet_qty.$i)->getCalculatedValue();
                        }
                       
                        $a_price = 1;
                        $s_price = 1;
                        $insert_by = $this->session->userdata('user_id');
                        date_default_timezone_set("America/Chicago");
                        $date = date('Y-m-d H:i:s');
                        $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')"; 

                        //var_dump($object_name); exit;
                        /* if(empty($SHIP_FEE)){
                            $query = $this->db2->query("SELECT SHIP_FEE from LZ_MANIFEST_DET@oraserver WHERE ITEM_MT_UPC = '$ITEM_MT_UPC' ORDER BY LZ_MANIFEST_ID DESC");
                            $rs = $query->result_array();
                            if(!empty($rs)){
                                    $SHIP_FEE = $rs[0]['SHIP_FEE'];
                                }else{
                                    $query = $this->db2->query("SELECT SHIP_FEE from LZ_MANIFEST_DET@oraserver WHERE UPPER(ITEM_MT_MFG_PART_NO) = '$ITEM_MT_MFG_PART_NO' ORDER BY LZ_MANIFEST_ID DESC");
                                    $rs = $query->result_array();
                                    if(!empty($rs)){
                                        $SHIP_FEE = $rs[0]['SHIP_FEE'];
                                      }else{
                                        $SHIP_FEE = 3.25;
                                    } 
                                } /// end else of not empty($rs) 
                              } /// end of ship fee */
                        $A_PRICE = "''";
                        $S_PRICE = "''";
                        $CATAGORY_NAME_SEG7= '';
                        $comma = ',';     
                        //======================= Get Categories Starts ==========================
                        $UPC = $ITEM_MT_UPC;
                        $MPN = $ITEM_MT_MFG_PART_NO;

                        if(!empty($ITEM_MT_UPC)){
                          $query = $ITEM_MT_UPC;
                        }elseif (!empty($ITEM_MT_MFG_PART_NO)) {
                          $query = $ITEM_MT_MFG_PART_NO;
                        }else{
                           $query = null;
                        }
                        $flag = TRUE;
                        if (!empty($ITEM_MT_UPC)) {
                          $upcs = $this->db2->query("SELECT * FROM (SELECT D.E_BAY_CATA_ID_SEG6, D.MAIN_CATAGORY_SEG1, D.BRAND_SEG3, D.CATEGORY_NAME_SEG7 FROM LZ_MANIFEST_DET@ORASERVER D WHERE D.ITEM_MT_UPC = '$ITEM_MT_UPC' ORDER BY D.LAPTOP_ZONE_ID DESC ) WHERE ROWNUM = 1")->result_array();
                           if (count($upcs) > 0) {
                            $categoryID               = $upcs[0]['E_BAY_CATA_ID_SEG6'];
                            $categoryParentName1      = $upcs[0]['MAIN_CATAGORY_SEG1'];  
                            $categoryParentName2      = $upcs[0]['BRAND_SEG3'];
                            $categoryName             = $upcs[0]['CATEGORY_NAME_SEG7'];
                            $flag                     = FALSE;
                          }
                        }
                        if (!empty($ITEM_MT_MFG_PART_NO) AND $flag == TRUE) {
                            $mpns = $this->db2->query("SELECT * FROM (SELECT D.E_BAY_CATA_ID_SEG6, D.MAIN_CATAGORY_SEG1, D.BRAND_SEG3, D.CATEGORY_NAME_SEG7 FROM LZ_MANIFEST_DET@ORASERVER D WHERE UPPER(D.ITEM_MT_MFG_PART_NO) = '$ITEM_MT_MFG_PART_NO' ORDER BY D.LAPTOP_ZONE_ID DESC ) WHERE ROWNUM = 1")->result_array();
                          if (count($mpns) > 0) {
                            $categoryID               = $mpns[0]['E_BAY_CATA_ID_SEG6'];
                            $categoryParentName1      = $mpns[0]['MAIN_CATAGORY_SEG1'];  
                            $categoryParentName2      = $mpns[0]['BRAND_SEG3'];
                            $categoryName             = $mpns[0]['CATEGORY_NAME_SEG7'];
                            $flag                     = FALSE;
                          }
                        }

                        if($query != NULL AND $flag == TRUE){            
                            // ======================= Get Categories End ==========================
                            $siteID = 0;
                            //the call being made:
                            $verb = 'GetSuggestedCategories';
                            ///Build the request Xml string
                            $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                            $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                            $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                            $requestXmlBody .= "<Query>$query</Query>";
                            $requestXmlBody .= '</GetSuggestedCategoriesRequest>';
                            //Create a new eBay session with all details pulled in from included keys.php
                            $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                            //send the request and get response
                            $responseXml = $session->sendHttpRequest($requestXmlBody);
                            $responseDoc = new DomDocument();
                            $responseDoc->loadXML($responseXml);
                            $response = simplexml_import_dom($responseDoc);
                            //   echo "<pre>";
                            //   print_r($response);
                            //   exit;

                            if ($response->Ack != 'Failure' && $response->CategoryCount > 0) {
                                $cat                    = $response->SuggestedCategoryArray->SuggestedCategory->Category;
                                $categoryParentName1    = $cat->CategoryParentName[0];
                                $categoryParentName2    = $cat->CategoryParentName[1];
                                $categoryName           = $cat->CategoryName;
                                $categoryID             = $cat->CategoryID;

                            }elseif($query == $UPC){
                                $MPN = str_replace("&", "and", $ITEM_MT_MFG_PART_NO);
                                $query1 = $MPN;
                                //$query1 = $UPC;
                                $siteID = 0;
                                //the call being made:
                                $verb = 'GetSuggestedCategories';
                                ///Build the request Xml string
                                $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                                $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                                $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                                $requestXmlBody .= "<Query>$query1</Query>";
                                $requestXmlBody .= '</GetSuggestedCategoriesRequest>';
                                //Create a new eBay session with all details pulled in from included keys.php
                                $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                                //send the request and get response
                                $responseXml = $session->sendHttpRequest($requestXmlBody);
                                $responseDoc = new DomDocument();
                                $responseDoc->loadXML($responseXml);
                                $response = simplexml_import_dom($responseDoc);
                                if ($response->Ack != 'Failure' && $response->CategoryCount > 0) {
                                    $cat = $response->SuggestedCategoryArray->SuggestedCategory->Category;
                                    $categoryParentName1 = $cat->CategoryParentName[0];
                                    $categoryParentName2 = $cat->CategoryParentName[1];
                                    $categoryName = $cat->CategoryName;
                                    $categoryID = $cat->CategoryID;
                                    }else{
                                    $categoryParentName1 = NULL;
                                    $categoryParentName2 = NULL;
                                    $categoryName = NULL;
                                    $categoryID = NULL;
                                    }
                                  }
                              }elseif($flag == TRUE)
                              // end if of query != null
                              {
                                $categoryParentName1 = NULL; 
                                $categoryParentName2 = NULL;
                                $categoryName = NULL;
                                $categoryID = NULL;
                              }
                             if($query != NULL){
                               
                /*=============================================
                =    Add MPN in Catalogue_mt block            =
                =============================================*/  

             }else{  
              //$query != NULL if close
                // main ifelse
                    $a_price=1;
                    $s_price=1;
                    
                }
             // ============= Insertion of Categories and Price Start ================
     
                    
                    $E_BAY_CATA_ID_SEG6= $categoryID;
                    $BRAND_SEG3= $categoryName;
                    $BRAND_SEG3 = trim(str_replace("  ", ' ', $BRAND_SEG3));
                    $BRAND_SEG3 = trim(str_replace(array("'"), "''", $BRAND_SEG3));

                    /*=============================================
                     =     Insertion in OBJECT_MT Table            =
                    =============================================*/

                    if (!empty($E_BAY_CATA_ID_SEG6) && !empty($object_name)) {
                        
                            $check_object_query = $this->db2->query("SELECT O.OBJECT_ID FROM LZ_BD_OBJECTS_MT O WHERE UPPER(O.OBJECT_NAME) = UPPER('$object_name') AND O.CATEGORY_ID =  $E_BAY_CATA_ID_SEG6");
                            if($check_object_query->num_rows() > 0){
                                $get_pk = $check_object_query->result_array();
                                $object_id = $get_pk[0]['OBJECT_ID'];
                            }else{
                                $get_object_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
                                $get_pk = $get_object_pk->result_array();
                                $object_id = $get_pk[0]['OBJECT_ID'];

                                $mt_qry = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID, ITEM_DESC) VALUES($object_id, '$object_name', $insert_date, $insert_by, $E_BAY_CATA_ID_SEG6, '$ITEM_MT_DESC')");  
                            }

                            
                    }else{
                      if (empty($E_BAY_CATA_ID_SEG6)) {
                        
                      }
                       
                    }
                    /*=====  End of Insertion in OBJECT_MT Table  ======*/
                      /*=============================================
                      =    Add MPN in Catalogue_mt block            =
                      =============================================*/
                         
                    if(!empty($MPN)){
                        $catalogue_check_query = $this->db2->query("SELECT M.CATALOGUE_MT_ID, M.OBJECT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = UPPER('$MPN') AND M.CATEGORY_ID = $E_BAY_CATA_ID_SEG6");

                        if($catalogue_check_query->num_rows() > 0){
                          $catalogue_mpn = $catalogue_check_query->result_array();
                          $cat_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
                          //$object_id = $catalogue_mpn[0]['OBJECT_ID'];
                          if (!empty($UPC)) {
                              $this->db2->query("UPDATE LZ_CATALOGUE_MT C SET C.UPC = '$UPC' WHERE C.CATALOGUE_MT_ID = $cat_mt_id");
                          }
                          $this->db2->query("UPDATE LZ_CATALOGUE_MT C SET C.OBJECT_ID = $object_id WHERE C.CATALOGUE_MT_ID = $cat_mt_id");

                        }else{
                          
                            /*=============================================
                            =     Insertion in CATALOGUE_MT Table            =
                            =============================================*/
                            $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                            $get_pk = $get_mt_pk->result_array();
                            $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                            $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, BRAND, PRICE, UPC) VALUES($cat_mt_id, '$MPN', $E_BAY_CATA_ID_SEG6, $insert_date, $insert_by, 0, $object_id,'$ITEM_MT_DESC', '$BRAND_SEG3', $a_price, '$UPC')");
                            /*=====  End of Insertion in CATALOGUE_MT Table  ======*/

                        } //check_catalogue_mt else closing

                    }else{
                      //MPN and category id if closing
                        if (!empty($UPC)) {
                           $get_catalg_id = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO  MPN FROM ITEMS_MT@oraserver T WHERE T.Item_Mt_Upc = '$UPC'");

                      if($get_catalg_id->num_rows() > 0) {

                        $get_exist_mpn = $get_catalg_id->result_array();
                      $get_exist_mpn = $get_exist_mpn[0]['MPN'];
                      $MPN = $get_exist_mpn; // ASSIGN TO PART NUMBER IF AVAILABLE IN LZ_CATALOGUE_MT

                      $check_catalogue_mt = $this->db->query("SELECT CATALOGUE_MT_ID, OBJECT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$MPN') and CATEGORY_ID = $E_BAY_CATA_ID_SEG6");

                        if($check_catalogue_mt->num_rows() > 0){
                            $catalogue_mpn = $check_catalogue_mt->result_array();
                          $cat_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
                          //$MPN = $catalogue_mpn;
                          if(!empty($UPC)){
                              $this->db->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$UPC'  WHERE CATALOGUE_MT_ID = $cat_mt_id");
                          }

                        }else{

                                $get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                                $get_pk = $get_mt_pk->result_array();
                                $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];



                                $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$MPN', $E_BAY_CATA_ID_SEG6, $insert_date, $insert_by,$object_id,'$ITEM_MT_DESC','$ITEM_MT_MANUFACTURE','$UPC')");

                        } //check_catalogue_mt else closing



                      }else{
                            $get_mpn = $this->db2->query("SELECT MPN_GENERATION@oraserver($E_BAY_CATA_ID_SEG6) as MPN FROM DUAL");
                            $get_mpn = $get_mpn->result_array();
                            $get_mpn = $get_mpn[0]['MPN'];      
                            $get_mpn = trim(str_replace("  ", ' ', $get_mpn));
                            $MPN = trim(str_replace(array("'"), "''", $get_mpn));
  
                            $get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                            $get_pk = $get_mt_pk->result_array();
                            $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];



                           $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$MPN', $E_BAY_CATA_ID_SEG6, $insert_date, $insert_by,$object_id,'$ITEM_MT_DESC','$ITEM_MT_MANUFACTURE','$UPC')");


                          } //get_catalg_id else closing
                        }      
                     } /// END ELSE OF !EMPTY MPN
                    //var_dump($a_price); exit
                     $a_price = 1;
                     $s_price = 1;
                    if (!empty($a_price)) {
                            $ebay_fee= ($a_price  * (8 / 100));
                          }else{
                            $ebay_fee = '';
                          }

                     if (!empty($a_price)) {
                          $paypal_fee= ($a_price  * (2.5 / 100));
                        }else{
                          $paypal_fee = '';
                        }

                    $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $lz_estimate_det_id = $rs[0]['ID'];
                          
                    $qry_det = "INSERT INTO LZ_BD_ESTIMATE_DET_TMP(LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, 1, $a_price, $ebay_fee, $paypal_fee, 3.25, 3000, '$ITEM_MT_MANUFACTURE', $s_price, $cat_mt_id, '$ITEM_MT_DESC', $insert_date)";

                    $result = $this->db2->query($qry_det);
            } // end of if($i !=1) condition
                //======================== Get Price Script End ==========================
          $i++;
        } /// end of main foreach  
        if ($qry_det) {

         $data_items = $this->db2->query("SELECT T.LZ_BD_ESTIMATE_ID, T.MPN_KIT_MT_ID, T.QTY, T.EST_SELL_PRICE, T.EBAY_FEE, T.PAYPAL_FEE, T.SHIPPING_FEE, T.TECH_COND_ID, T.ACT_QTY_RCVD, T.SPECIFIC_PIC_YN, T.LOCATION_ID, T.TECH_COND_DESC, T.ITEM_ID, T.ITEM_ADJ_DET_ID, T.ITEM_MANUFACTURER, T.SOLD_PRICE, T.PART_CATLG_MT_ID, T.MPN_DESCRIPTION, T_QTY.QTY FROM LZ_BD_ESTIMATE_DET_TMP T,(SELECT TT.PART_CATLG_MT_ID,COUNT(1) QTY FROM LZ_BD_ESTIMATE_DET_TMP TT GROUP  BY TT.PART_CATLG_MT_ID) T_QTY WHERE T.PART_CATLG_MT_ID = T_QTY.PART_CATLG_MT_ID AND T.PART_CATLG_MT_ID IS NOT NULL AND T.LZ_BD_ESTIMATE_ID = $lz_bd_estimate_id")->result_array();
         if (count($data_items) > 0) {
           foreach ($data_items as $item) {
            $data_part_catlg_mt_id = $item['PART_CATLG_MT_ID'];

            $data = $this->db2->query("SELECT T.PART_CATLG_MT_ID FROM LZ_BD_ESTIMATE_DET T WHERE T.PART_CATLG_MT_ID =$data_part_catlg_mt_id AND T.LZ_BD_ESTIMATE_ID = $lz_bd_estimate_id")->result_array();

            if (count($data) > 0) {
              
            }else{
               $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $lz_estimate_det_id = $rs[0]['ID'];
                    $item_mt_manufacture = $item['ITEM_MANUFACTURER'];    
                    $mpn_description = $item['MPN_DESCRIPTION'];   
                    $est_sell_price = $item['EST_SELL_PRICE'];
                    $ebay_fee = $item['EBAY_FEE'];   
                    $paypal_fee = $item['PAYPAL_FEE'];
                    $new_qty = $item['QTY'];
                    if (empty($est_sell_price)) {
                         $est_sell_price = 1;
                         $ebay_fee= ($est_sell_price  * (8 / 100));
                         $paypal_fee= ($est_sell_price  * (2.5 / 100));
                       }   
                       
                    $sold_price = $item['SOLD_PRICE'];  
                    if (empty($sold_price)) {
                       $sold_price = 1;
                     } 
                    $part_catlg_mt_id = $item['PART_CATLG_MT_ID'];   

                    $qry_det = "INSERT INTO LZ_BD_ESTIMATE_DET(LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, $new_qty, $est_sell_price, $ebay_fee, $paypal_fee, 3.25, 3000, '$item_mt_manufacture', $sold_price, $part_catlg_mt_id, '$mpn_description', $insert_date)";

                    $result = $this->db2->query($qry_det);

            }
           }
         }
         if ($result) {
          $this->db2->query("TRUNCATE TABLE LZ_BD_ESTIMATE_DET_TMP");
           return 1;
         }else{
          return 0;
         }
        }  
      } //end else of main if 
    } /// end of main function


    public  function import_xlsx_file(){ 
        $this->load->library('PHPExcel');
        $ext                = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION);
          if ($ext !='xlsx'){
            echo "Only Excel files with .xlsx ext are allowed.";
        }else{
              $this->db2->query("TRUNCATE TABLE LZ_COLUMN_MAPPING");
              $filename = $this->input->post('file_name').'.'.$ext;
              move_uploaded_file($_FILES["file_name"]["tmp_name"],$filename);
              if(strtolower($ext) == 'xlsx')
              {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setReadDataOnly(true);
              }
              $objPHPExcel = $objReader->load($filename);
              $objWorksheet = $objPHPExcel->getActiveSheet();
              $i=1;
              $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;
              //  ==============Mt Table insert End =====================
              foreach ($objWorksheet->getRowIterator() as $row)
              {
                if($i !=1)
                {
                  $A   = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                  $B   = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue(); 
                  $C   = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                  $D   = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                  $E   = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                  $F   = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                  $G   = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                  $H   = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                  $I   = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                  $J   = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                  $K   = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                  $L   = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
                  $M   = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
                  $N   = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
                  $O   = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
                  $P   = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
                  $Q   = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
                  $R   = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
                  $S   = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
                  $T   = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
                  $U   = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
                  $V   = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
                  $W   = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
                  $X   = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
                  $Y   = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
                  $Z   = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
                  
                  /*=============================================
                  =    Add MPN in Catalogue_mt block            =
                  =============================================*/
                  $A = substr($A, 0, 80);
                  $A = trim(str_replace("  ", ' ', $A));
                  $A = trim(str_replace(array("'"), "''", $A));

                  $B = substr($B, 0, 80);
                  $B = trim(str_replace("  ", ' ', $B));
                  $B = trim(str_replace(array("'"), "''", $B));

                  $C = substr($C, 0, 80);
                  $C = trim(str_replace("  ", ' ', $C));
                  $C = trim(str_replace(array("'"), "''", $C));

                  $D = substr($D, 0, 80);
                  $D = trim(str_replace("  ", ' ', $D));
                  $D = trim(str_replace(array("'"), "''", $D));

                  $E = substr($E, 0, 80);
                  $E = trim(str_replace("  ", ' ', $E));
                  $E = trim(str_replace(array("'"), "''", $E));

                  $F = substr($F, 0, 80);
                  $F = trim(str_replace("  ", ' ', $F));
                  $F = trim(str_replace(array("'"), "''", $F));

                  $G = substr($G, 0, 80);
                  $G = trim(str_replace("  ", ' ', $G));
                  $G = trim(str_replace(array("'"), "''", $G));

                  $H = substr($H, 0, 80);
                  $H = trim(str_replace("  ", ' ', $H));
                  $H = trim(str_replace(array("'"), "''", $H));

                  $I = substr($I, 0, 80);
                  $I = trim(str_replace("  ", ' ', $I));
                  $I = trim(str_replace(array("'"), "''", $I));

                  $J = substr($J, 0, 80);
                  $J = trim(str_replace("  ", ' ', $J));
                  $J = trim(str_replace(array("'"), "''", $J));

                  $K = substr($K, 0, 80);
                  $K = trim(str_replace("  ", ' ', $K));
                  $K = trim(str_replace(array("'"), "''", $K));

                  $L = substr($L, 0, 80);
                  $L = trim(str_replace("  ", ' ', $L));
                  $L = trim(str_replace(array("'"), "''", $L));

                  $M = substr($M, 0, 80);
                  $M = trim(str_replace("  ", ' ', $M));
                  $M = trim(str_replace(array("'"), "''", $M));

                  $N = substr($N, 0, 80);
                  $N = trim(str_replace("  ", ' ', $N));
                  $N = trim(str_replace(array("'"), "''", $N));

                  $O = substr($O, 0, 80);
                  $O = trim(str_replace("  ", ' ', $O));
                  $O = trim(str_replace(array("'"), "''", $O));

                  $P = substr($P, 0, 80);
                  $P = trim(str_replace("  ", ' ', $P));
                  $P = trim(str_replace(array("'"), "''", $P));

                  $Q = substr($Q, 0, 80);
                  $Q = trim(str_replace("  ", ' ', $Q));
                  $Q = trim(str_replace(array("'"), "''", $Q));

                  $R = substr($R, 0, 80);
                  $R = trim(str_replace("  ", ' ', $R));
                  $R = trim(str_replace(array("'"), "''", $R));

                  $S = substr($S, 0, 80);
                  $S = trim(str_replace("  ", ' ', $S));
                  $S = trim(str_replace(array("'"), "''", $S));

                  $T = substr($T, 0, 80);
                  $T = trim(str_replace("  ", ' ', $T));
                  $T = trim(str_replace(array("'"), "''", $T));

                  $U = substr($U, 0, 80);
                  $U = trim(str_replace("  ", ' ', $U));
                  $U = trim(str_replace(array("'"), "''", $U));

                  $V = substr($V, 0, 80);
                  $V = trim(str_replace("  ", ' ', $V));
                  $V = trim(str_replace(array("'"), "''", $V));

                  $W = substr($W, 0, 80);
                  $W = trim(str_replace("  ", ' ', $W));
                  $W = trim(str_replace(array("'"), "''", $W));

                  $X = substr($X, 0, 80);
                  $X = trim(str_replace("  ", ' ', $X));
                  $X = trim(str_replace(array("'"), "''", $X));

                  $Y = substr($Y, 0, 80);
                  $Y = trim(str_replace("  ", ' ', $Y));
                  $Y = trim(str_replace(array("'"), "''", $Y));

                  $Z = substr($Z, 0, 80);
                  $Z = trim(str_replace("  ", ' ', $Z));
                  $Z = trim(str_replace(array("'"), "''", $Z));

                  $qry_det = "INSERT INTO LZ_COLUMN_MAPPING(A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z, LZ_COL_MAP_PK) VALUES('$A', '$B', '$C', '$D', '$E', '$F', '$G', '$H', '$I', '$J', '$K', '$L', '$M', '$N', '$O', '$P', '$Q', '$R', '$S', '$T', '$U', '$V', '$W', '$X', '$Y', '$Z', $i)";

                  $result = $this->db2->query($qry_det);
            } // end of if($i !=1) condition
          $i++;
        } /// end of main foreach  
          if ($result) {
             return 1;
           }else{
            return 0;
           } 
      } //end else of main if 
    } /// end of main function
    
    public  function import_xls_records(){ 
        $map_cols = $this->db2->query("SELECT * FROM LZ_COLUMN_MAPPING")->result_array();
          if (count($map_cols) == 0){
            return 0;
        }else{
                $columns    = $this->input->post("columns");
                $alphabets  = $this->input->post("alphabets");
                $user_cats  = $this->input->post("cats");
                $cpks       = $this->input->post("cpks");
                $i=1;
                $total_rows = count($map_cols);

                $item_condition = 3000;
                $ct_cata_id = $this->input->post('ct_cata_id');
      
                require('/../manifest_loading/get-common/Productionkeys.php'); 
                require('/../manifest_loading/get-common/eBaySession.php');
                // echo "<pre>";
                // print_r($columns);
                // exit;
                // var_dump($ct_cata_id); exit;
                //  ============== Mt table insert Start ====================
                date_default_timezone_set("America/Chicago");
                $date = date('Y-m-d H:i:s');
                $estimate_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
                $user_id = $this->session->userdata('user_id');

                $items = $this->db2->query("SELECT T.TITLE FROM LZ_BD_ESTIMATE_MT M, LZ_BD_ITEMS_TO_EST T WHERE M.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID AND M.LZ_BD_CATAG_ID = $ct_cata_id")->result_array();

                  if (count($items) > 0) {
                    $title = $items[0]['TITLE'];
                  }else{
                    $title = '';
                  }
                  ///////////////////////////

                     $items_cata = $this->db2->query("SELECT M.LZ_BD_ESTIMATE_ID FROM LZ_BD_ESTIMATE_MT M WHERE  M.LZ_BD_CATAG_ID = $ct_cata_id")->result_array();

                  if (count($items_cata) == 0) {
                     $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_MT','LZ_BD_ESTIMATE_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $lz_bd_estimate_id = $rs[0]['ID'];
                    $qry_mt = "INSERT INTO LZ_BD_ESTIMATE_MT (LZ_BD_ESTIMATE_ID, LZ_BD_CATAG_ID, EST_DATE_TIME, ENTERED_BY, KIT_LOT , ESTIMATE_DESC) VALUES($lz_bd_estimate_id, $ct_cata_id, $estimate_date, $user_id, 'L', '$title')";
                    $result =$this->db2->query($qry_mt);

                    $qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_TRACKING_NO','TRACKING_ID') ID FROM DUAL");
                    $rs = $qry->result_array();
                    $tracking_id = $rs[0]['ID'];
                    $this->db2->query("INSERT INTO LZ_BD_TRACKING_NO (LZ_BD_CATA_ID, CATEGORY_ID, TRACKING_ID, LZ_ESTIMATE_ID) VALUES($ct_cata_id, 111222333444, $tracking_id, $lz_bd_estimate_id)");
                  }else{
                    $lz_bd_estimate_id = $items_cata[0]['LZ_BD_ESTIMATE_ID'];
                  }
                    
                    //  ==============Mt Table insert End =====================
                    //var_dump(count($objWorksheet)); exit;
                  $k = 0;
                      foreach ($columns as $column) 
                      {
                        if ($column ==="MPN") {
                         $alphabet_mpn = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="MPN DESCRIPTION") {
                          $alphabet_mpn_desc = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="UPC") {
                          $alphabet_upc = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="OBJECT NAME") {
                          $alphabet_obj_name = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="MANUFACTURER") {
                          $alphabet_manuf = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="QTY") {
                          $alphabet_qty = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="SKU") {
                          $alphabet_sku = strtoupper($alphabets[$k]);
                        }
                        if ($column ==="LOT ID") {
                          $alphabet_lot_id = strtoupper($alphabets[$k]);
                        }else{
                          $alphabet_qty = '';
                        }
                        $k++;
                      }
                    //var_dump($alphabet_mpn, $alphabet_mpn_desc, $alphabet_upc, $alphabet_obj_name,  $alphabet_manuf, $alphabet_qty);
                    $i= 1;
                    foreach ($map_cols as $row){
                        //if($i !=0){
                        $lz_col_map_pk        = $row['LZ_COL_MAP_PK'];
                        $ITEM_MT_MANUFACTURE  = $row[$alphabet_manuf];
                        $ITEM_MT_MANUFACTURE  = trim(str_replace("  ", ' ', $ITEM_MT_MANUFACTURE));
                        $ITEM_MT_MANUFACTURE  = trim(str_replace(array("'"), "''", $ITEM_MT_MANUFACTURE));
                        $BRAND_SEG3           = $ITEM_MT_MANUFACTURE;

                        $ITEM_MT_MFG_PART_NO  = $row[$alphabet_mpn]; 
                        $ITEM_MT_MFG_PART_NO  = trim(str_replace(" ", '', $ITEM_MT_MFG_PART_NO));
                        $ITEM_MT_MFG_PART_NO  = strtoupper(trim(str_replace(array("'"), "''", $ITEM_MT_MFG_PART_NO)));

                        $ITEM_MT_DESC         = $row[$alphabet_mpn_desc];
                        $ITEM_MT_DESC         = trim(str_replace("  ", ' ', $ITEM_MT_DESC));
                        $ITEM_MT_DESC         = trim(str_replace(array("'"), "''", $ITEM_MT_DESC));

                        $ITEM_MT_UPC          = $row[$alphabet_upc];
                        $ITEM_MT_UPC          = trim(str_replace(" ", '', $ITEM_MT_UPC));
                        $ITEM_MT_UPC          = trim(str_replace(array("'"), "", $ITEM_MT_UPC));
                 
                        $object_name          = $row[$alphabet_obj_name];
                        $object_name          = trim(str_replace("  ", ' ', $object_name));
                        $object_name          = trim(str_replace(array("'"), "''", $object_name));

                        $lot_id          = $row[$alphabet_lot_id];
                        $lot_id          = trim(str_replace("  ", ' ', $lot_id));
                        $lot_id          = trim(str_replace(array("'"), "''", $lot_id)); 

                        $sku          = $row[$alphabet_sku];
                        $sku          = trim(str_replace("  ", ' ', $sku));
                        $sku          = trim(str_replace(array("'"), "''", $sku)); 

                        $status = $this->db2->query("SELECT M.STATUS FROM LZ_COLUMN_MAPPING M WHERE M.LZ_COL_MAP_PK = $lz_col_map_pk ")->result_array();
                        $MPN_FLAG = $status[0]['STATUS'];

                        if (count($cpks) > 0)
                        {
                          $l=0;
                          foreach ($cpks as $pk)
                          {
                          if ($lz_col_map_pk == $pk)
                            {
                              $category_id = $user_cats[$l]; 
                            }
                            $l++;
                          }  
                        }

                        if ($MPN_FLAG == 2 AND !empty($category_id)) 
                        {
                          $get_mpn = $this->db2->query("SELECT MPN_GENERATION@oraserver($category_id) as MPN FROM DUAL");
                          $get_mpn = $get_mpn->result_array();
                          $get_mpn = $get_mpn[0]['MPN'];      
                          $get_mpn = trim(str_replace("  ", ' ', $get_mpn));
                          $ITEM_MT_MFG_PART_NO = trim(str_replace(array("'"), "''", $get_mpn)); 
                        }
                        //var_dump($ITEM_MT_MFG_PART_NO, $category_id); exit;
                        if (!empty($alphabet_qty))
                        {
                           $qty  = $row[$alphabet_qty];
                        }

                        if (!empty($ITEM_MT_MFG_PART_NO AND $MPN_FLAG != 2)) {
                        $a_price = 1;
                        $s_price = 1;
                        $insert_by = $this->session->userdata('user_id');
                        date_default_timezone_set("America/Chicago");
                        $date = date('Y-m-d H:i:s');
                        $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')"; 

                        $A_PRICE = "''";
                        $S_PRICE = "''";
                        $CATAGORY_NAME_SEG7= '';
                        $comma = ','; 
                        
                        if(!empty($sku)){
                        /*====================================
                        =            best buy api            =
                        ====================================*/
                        $api_key = "I3jYAFrGG5rdGhMKJBfH7dTA";//sajid key
                        //$api_key = "emnOAiWzAur77qO5uHadnze8";//nadeem key old
                        //$api_key = "lCghAabQYkpV3CJvIQCHqJ9B";//nadeem key new 17 aug 18

                        $URL ="https://api.bestbuy.com/v1/products(sku=$sku)?format=xml&show=description,details.name,details.value,image,manufacturer,name,salePrice,upc,type,sku,shortDescription,modelNumber,longDescription,features.feature,height,width,depth,shippingWeight,weight,shippingCost,class&apiKey=$api_key";

                        $XML = new SimpleXMLElement(file_get_contents($URL));
                        //echo  $XML['attributes'];//->totalPages.'<br>';
                        //$name = $XML->product->name;
                        if(isset($XML->product)){
                          $bby_data = true;
                          $bby_salePrice = $XML->product->salePrice;
                          $shippingCost = $XML->product->shippingCost;
                          if(!empty($shippingCost)){
                            $bby_salePrice = $bby_salePrice + $shippingCost;
                          }
                          $ITEM_MT_UPC = $XML->product->upc;
                          //$type = $XML->product->type;
                          $ITEM_MT_MFG_PART_NO = $XML->product->modelNumber;
                        }else{
                          
                          $URL ="https://api.bestbuy.com/v1/products(sku=$sku&active=false)?format=xml&show=description,details.name,details.value,image,manufacturer,name,salePrice,upc,type,sku,shortDescription,modelNumber,longDescription,features.feature,height,width,depth,shippingWeight,weight,shippingCost,class&apiKey=$api_key";
                          $XML = new SimpleXMLElement(file_get_contents($URL));
                            if(isset($XML->product)){
                              $bby_data = true;
                              $bby_salePrice = $XML->product->salePrice;
                              $shippingCost = $XML->product->shippingCost;
                              if(!empty($shippingCost)){
                                $bby_salePrice = $bby_salePrice + $shippingCost;
                              }
                              $ITEM_MT_UPC = $XML->product->upc;
                              //$type = $XML->product->type;
                              $ITEM_MT_MFG_PART_NO = $XML->product->modelNumber;
                            }else{
                              $bby_data = false;
                              $bby_salePrice = '';
                            }
                        }
                        
                        
                        /*=====  End of best buy api  ======*/

                        }else{// !empty($sku) if close
                          $bby_data = false;
                          $bby_salePrice = '';
                        }
                        

                        //======================= Get Categories Starts ==========================
                        $UPC = $ITEM_MT_UPC;
                        $MPN = $ITEM_MT_MFG_PART_NO;

                        if(!empty($ITEM_MT_UPC)){
                          $query = $ITEM_MT_UPC;
                        }elseif (!empty($ITEM_MT_MFG_PART_NO)) {
                          $query = $ITEM_MT_MFG_PART_NO;
                        }else{
                           $query = null;
                        }
                       
                        $flag = TRUE;
                        if (!empty($ITEM_MT_UPC)) {
                          $upcs = $this->db2->query("SELECT * FROM (SELECT D.E_BAY_CATA_ID_SEG6, D.MAIN_CATAGORY_SEG1, D.BRAND_SEG3, D.CATEGORY_NAME_SEG7 FROM LZ_MANIFEST_DET@ORASERVER D WHERE D.ITEM_MT_UPC = '$ITEM_MT_UPC' AND D.E_BAY_CATA_ID_SEG6 IS NOT NULL AND D.E_BAY_CATA_ID_SEG6 <> 'N/A'AND UPPER(D.E_BAY_CATA_ID_SEG6) <> 'OTHER' ORDER BY D.LAPTOP_ZONE_ID DESC ) WHERE ROWNUM = 1")->result_array(); 
                          if (count($upcs) > 0) {
                            $categoryID               = $upcs[0]['E_BAY_CATA_ID_SEG6'];
                            $categoryParentName1      = $upcs[0]['MAIN_CATAGORY_SEG1'];  
                            $categoryParentName2      = $upcs[0]['BRAND_SEG3'];
                             $BRAND_SEG3                 = $upcs[0]['CATEGORY_NAME_SEG7'];
                            $categoryName             = $upcs[0]['CATEGORY_NAME_SEG7'];
                            $flag                     = FALSE;
                          }
                        }
                        if (!empty($ITEM_MT_MFG_PART_NO) AND $flag == TRUE) {
                            $mpns = $this->db2->query("SELECT * FROM (SELECT D.E_BAY_CATA_ID_SEG6, D.MAIN_CATAGORY_SEG1, D.BRAND_SEG3, D.CATEGORY_NAME_SEG7 FROM LZ_MANIFEST_DET@ORASERVER D WHERE UPPER(D.ITEM_MT_MFG_PART_NO) = '$ITEM_MT_MFG_PART_NO' AND D.E_BAY_CATA_ID_SEG6 IS NOT NULL AND D.E_BAY_CATA_ID_SEG6 <> 'N/A'AND UPPER(D.E_BAY_CATA_ID_SEG6) <> 'OTHER' ORDER BY D.LAPTOP_ZONE_ID DESC ) WHERE ROWNUM = 1")->result_array();
                          if (count($mpns) > 0) {
                            $categoryID               = $mpns[0]['E_BAY_CATA_ID_SEG6'];
                            $categoryParentName1      = $mpns[0]['MAIN_CATAGORY_SEG1'];  
                            $categoryParentName2      = $mpns[0]['BRAND_SEG3'];
                             $BRAND_SEG3                 = $upcs[0]['CATEGORY_NAME_SEG7'];
                            $categoryName             = $mpns[0]['CATEGORY_NAME_SEG7'];
                            $flag                     = FALSE;
                          }
                        }

                        if($query != NULL AND $flag == TRUE)
                        {            
                          // ======================= Get Categories End ==========================
                          $siteID = 0;
                          //the call being made.
                          $verb = 'GetSuggestedCategories';
                          ///Build the request Xml string
                          $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                          $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                          $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                          $requestXmlBody .= "<Query>$query</Query>";
                          $requestXmlBody .= '</GetSuggestedCategoriesRequest>';
                          //Create a new eBay session with all details pulled in from included keys.php
                          $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                          //send the request and get response
                          $responseXml = $session->sendHttpRequest($requestXmlBody);
                          $responseDoc = new DomDocument();
                          $responseDoc->loadXML($responseXml);
                          $response = simplexml_import_dom($responseDoc);
                          //   echo "<pre>";
                          //   print_r($response);
                          //   exit;

                          if ($response->Ack != 'Failure' && $response->CategoryCount > 0)
                          {
                            $cat                    = $response->SuggestedCategoryArray->SuggestedCategory->Category;
                            $categoryParentName1    = $cat->CategoryParentName[0];
                            $categoryParentName2    = $cat->CategoryParentName[1];
                            $categoryName           = $cat->CategoryName;
                            $categoryID             = $cat->CategoryID;
                          }
                          elseif($query == $UPC)
                          {
                              $MPN = str_replace("&", "and", $ITEM_MT_MFG_PART_NO);
                              $query1 = $MPN;
                              //$query1 = $UPC;
                              $siteID = 0;
                              //the call being made:
                              $verb = 'GetSuggestedCategories';
                              ///Build the request Xml string
                              $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                              $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                              $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                              $requestXmlBody .= "<Query>$query1</Query>";
                              $requestXmlBody .= '</GetSuggestedCategoriesRequest>';
                              //Create a new eBay session with all details pulled in from included keys.php
                              $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                              //send the request and get response
                              $responseXml = $session->sendHttpRequest($requestXmlBody);
                              $responseDoc = new DomDocument();
                              $responseDoc->loadXML($responseXml);
                              $response = simplexml_import_dom($responseDoc);
                              if ($response->Ack != 'Failure' && $response->CategoryCount > 0) {
                                  $cat = $response->SuggestedCategoryArray->SuggestedCategory->Category;
                                  $categoryParentName1 = $cat->CategoryParentName[0];
                                  $categoryParentName2 = $cat->CategoryParentName[1];
                                  $categoryName = $cat->CategoryName;
                                  $categoryID = $cat->CategoryID;
                                  }else{
                                  $categoryParentName1 = NULL;
                                  $categoryParentName2 = NULL;
                                  $categoryName = NULL;
                                  $categoryID = NULL;
                                  }
                              }
                            }
                            elseif($flag == TRUE)// end if of query != null
                            {
                              $categoryParentName1 = NULL; 
                              $categoryParentName2 = NULL;
                              $categoryName = NULL;
                              $categoryID = NULL;
                            }
                           if($query != NULL)
                           {
                            
                          }
                          else
                          {  
                            //$query != NULL if close
                            // main ifelse
                            $a_price=1;
                            $s_price=1;
                        }
                         // ============= Insertion of Categories and Price Start ================
                     if (empty($categoryID))
                     {
                       if (count($cpks) > 0)
                        {
                          $j=0;
                          foreach ($cpks as $pk)
                          {
                          if ($lz_col_map_pk == $pk)
                            {
                              $categoryID = $user_cats[$j]; 
                            }
                            $j++;
                          }
                           if (!empty($categoryID))
                           {
                              $mt_qry = $this->db2->query("UPDATE LZ_COLUMN_MAPPING CL SET CL.STATUS = 1 WHERE CL.LZ_COL_MAP_PK = $lz_col_map_pk"); 
                            }
                        }
                     }

                    $E_BAY_CATA_ID_SEG6= $categoryID;
                   // $BRAND_SEG3= $categoryName;
                    $BRAND_SEG3 = trim(str_replace("  ", ' ', $BRAND_SEG3));
                    $BRAND_SEG3 = trim(str_replace(array("'"), "''", $BRAND_SEG3));
                    /*=============================================
                     =     Insertion in OBJECT_MT Table           =
                    =============================================*/

                    if (!empty($E_BAY_CATA_ID_SEG6) && !empty($object_name))
                    {
                      $check_object_query = $this->db2->query("SELECT O.OBJECT_ID FROM LZ_BD_OBJECTS_MT O WHERE UPPER(O.OBJECT_NAME) = UPPER('$object_name') AND O.CATEGORY_ID =  $E_BAY_CATA_ID_SEG6");
                      if($check_object_query->num_rows() > 0){
                          $get_pk     = $check_object_query->result_array();
                          $object_id  = $get_pk[0]['OBJECT_ID'];
                      }
                      else
                      {
                          $get_object_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
                          $get_pk = $get_object_pk->result_array();
                          $object_id = $get_pk[0]['OBJECT_ID'];

                          $mt_qry = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID, ITEM_DESC) VALUES($object_id, '$object_name', $insert_date, $insert_by, $E_BAY_CATA_ID_SEG6, '$ITEM_MT_DESC')");  
                      }
                    }
                    else
                    {
                      if (empty($E_BAY_CATA_ID_SEG6)) 
                      {
                        $mt_qry = $this->db2->query("UPDATE LZ_COLUMN_MAPPING CL SET CL.STATUS = 0 WHERE CL.LZ_COL_MAP_PK = $lz_col_map_pk"); 
                      }
                    }

                    /*=====  End of Insertion in OBJECT_MT Table ===*/
                    /*=============================================
                    =    Add MPN in Catalogue_mt block            =
                    =============================================*/ 
                    if(!empty($MPN) AND !empty($E_BAY_CATA_ID_SEG6))
                    {
                      $catalogue_check_query = $this->db2->query("SELECT M.CATALOGUE_MT_ID, M.OBJECT_ID FROM LZ_CATALOGUE_MT M WHERE UPPER(M.MPN) = UPPER('$MPN') AND M.CATEGORY_ID = $E_BAY_CATA_ID_SEG6");
                      if($catalogue_check_query->num_rows() > 0)
                      {
                        $catalogue_mpn = $catalogue_check_query->result_array();
                        $cat_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
                        //$object_id = $catalogue_mpn[0]['OBJECT_ID'];
                        if (!empty($UPC))
                        {
                          $this->db2->query("UPDATE LZ_CATALOGUE_MT C SET C.UPC = '$UPC' WHERE C.CATALOGUE_MT_ID = $cat_mt_id");
                        }
                        $this->db2->query("UPDATE LZ_CATALOGUE_MT C SET C.OBJECT_ID = $object_id WHERE C.CATALOGUE_MT_ID = $cat_mt_id");
                      }
                      else
                      {
                        /*=============================================
                        =     Insertion in CATALOGUE_MT Table         =
                        ==============================================*/
                        $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                        $get_pk = $get_mt_pk->result_array();
                        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                        $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, BRAND, PRICE, UPC) VALUES($cat_mt_id, '$MPN', $E_BAY_CATA_ID_SEG6, $insert_date, $insert_by, 0, $object_id,'$ITEM_MT_DESC', '$BRAND_SEG3', $a_price, '$UPC')");
                        /*=====  End of Insertion in CATALOGUE_MT Table  ======*/
                    } //check_catalogue_mt else closing
                  }
                  else
                  {
                    //MPN and category id if closing
                    if (!empty($UPC) AND !empty($E_BAY_CATA_ID_SEG6))
                     {
                       $get_catalg_id = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO  MPN FROM ITEMS_MT@oraserver T WHERE T.Item_Mt_Upc = '$UPC'");

                    if($get_catalg_id->num_rows() > 0)
                     {
                      $get_exist_mpn = $get_catalg_id->result_array();
                      $get_exist_mpn = $get_exist_mpn[0]['MPN'];
                      $MPN = $get_exist_mpn; // ASSIGN TO PART NUMBER IF AVAILABLE IN LZ_CATALOGUE_MT

                      $check_catalogue_mt = $this->db->query("SELECT CATALOGUE_MT_ID, OBJECT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$MPN') and CATEGORY_ID = $E_BAY_CATA_ID_SEG6");

                    if($check_catalogue_mt->num_rows() > 0)
                    {
                        $catalogue_mpn = $check_catalogue_mt->result_array();
                        $cat_mt_id = $catalogue_mpn[0]['CATALOGUE_MT_ID'];
                        //$MPN = $catalogue_mpn;
                        if(!empty($UPC))
                        {
                          $this->db->query("UPDATE LZ_CATALOGUE_MT SET UPC = '$UPC'  WHERE CATALOGUE_MT_ID = $cat_mt_id");
                        }
                    }else{
                        $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                        $get_pk = $get_mt_pk->result_array();
                        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                        $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$MPN', $E_BAY_CATA_ID_SEG6, $insert_date, $insert_by,$object_id,'$ITEM_MT_DESC','$ITEM_MT_MANUFACTURE','$UPC')");
                    } //check_catalogue_mt else closing

                  }
                  else
                  {
                        $get_mpn = $this->db2->query("SELECT MPN_GENERATION@oraserver($E_BAY_CATA_ID_SEG6) as MPN FROM DUAL");
                        $get_mpn = $get_mpn->result_array();
                        $get_mpn = $get_mpn[0]['MPN'];      
                        $get_mpn = trim(str_replace("  ", ' ', $get_mpn));
                        $MPN = trim(str_replace(array("'"), "''", $get_mpn));

                        $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                        $get_pk = $get_mt_pk->result_array();
                        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                       $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$MPN', $E_BAY_CATA_ID_SEG6, $insert_date, $insert_by,$object_id,'$ITEM_MT_DESC','$ITEM_MT_MANUFACTURE','$UPC')");
                   } //get_catalg_id else closing
                  }      
                  } /// END ELSE OF !EMPTY MPN
                    //var_dump($a_price); exit
                     $a_price = 1;
                     $s_price = 1;
                    if (!empty($a_price)) {
                            $ebay_fee= ($a_price  * (8 / 100));
                          }else{
                            $ebay_fee = '';
                          }

                     if (!empty($a_price)) {
                          $paypal_fee= ($a_price  * (2.5 / 100));
                        }else{
                          $paypal_fee = '';
                        }

                    $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $lz_estimate_det_id = $rs[0]['ID'];
                          
                    $qry_det = "INSERT INTO LZ_BD_ESTIMATE_DET_TMP(LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE,LOT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, 1, $a_price, $ebay_fee, $paypal_fee, 3.25, 3000, '$ITEM_MT_MANUFACTURE', $s_price, $cat_mt_id, '$ITEM_MT_DESC', $insert_date,$lot_id)";

                $qry_det = $this->db2->query($qry_det);
            //} // end of if($i !=1) condition
                //======================== Get Price Script End ==========================
          $i++;
          }
          else
          { /// end  main if upc amd mpn or empty
            if (!empty($ITEM_MT_MFG_PART_NO) AND $MPN_FLAG == 2 AND !empty($category_id)) 
              {

                if (!empty($category_id) && !empty($object_name))
                    {
                      ///var_dump($category_id, $object_name); exit;
                      
                      $check_object_query = $this->db2->query("SELECT O.OBJECT_ID FROM LZ_BD_OBJECTS_MT O WHERE UPPER(O.OBJECT_NAME) = UPPER('$object_name') AND O.CATEGORY_ID =  $category_id");
                      if($check_object_query->num_rows() > 0){
                          $get_pk     = $check_object_query->result_array();
                          $object_id  = $get_pk[0]['OBJECT_ID'];
                      }
                      else
                      {
                        $get_object_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
                        $get_pk = $get_object_pk->result_array();
                        $object_id = $get_pk[0]['OBJECT_ID'];

                        $mt_qry = $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID, ITEM_DESC) VALUES($object_id, '$object_name', $estimate_date, $user_id, $category_id, '$ITEM_MT_DESC')");  
                      }
                        //////////////////////////
                        $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
                        $get_pk = $get_mt_pk->result_array();
                        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

                        $mt_qry = $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND,UPC) VALUES($cat_mt_id, '$ITEM_MT_MFG_PART_NO', $category_id, $estimate_date, $user_id, $object_id,'$ITEM_MT_DESC','$ITEM_MT_MANUFACTURE','$ITEM_MT_UPC')");

                      $a_price = 1;
                      $s_price = 1;
                      if (!empty($a_price)) 
                      {
                        $ebay_fee= ($a_price  * (8 / 100));
                      }
                      else
                      {
                        $ebay_fee = '';
                      }

                     if (!empty($a_price))
                      {
                        $paypal_fee= ($a_price  * (2.5 / 100));
                      }
                      else
                      {
                        $paypal_fee = '';
                      }

                      $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                      $rs = $query->result_array();
                      $lz_estimate_det_id = $rs[0]['ID'];
                            
                      $qry_det = "INSERT INTO LZ_BD_ESTIMATE_DET_TMP(LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE,LOT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, 1, $a_price, $ebay_fee, $paypal_fee, 3.25, 3000, '$ITEM_MT_MANUFACTURE', $s_price, $cat_mt_id, '$ITEM_MT_DESC', $estimate_date,$lot_id)";

                      $qry_det = $this->db2->query($qry_det);
                      if ($qry_det)
                       {
                        $this->db2->query("UPDATE LZ_COLUMN_MAPPING CL SET CL.STATUS = 1 WHERE CL.LZ_COL_MAP_PK = $lz_col_map_pk");
                      }
                      //////////////////////////
                  }
                }
                else
                {
                  $mt_qry = $this->db2->query("UPDATE LZ_COLUMN_MAPPING CL SET CL.STATUS = 2 WHERE CL.LZ_COL_MAP_PK = $lz_col_map_pk");
                  $qry_det = 0;
                }
              }
            } /// end of main foreach 
          
           if (!empty($ITEM_MT_MFG_PART_NO)) {
            if ($qry_det) {
             $data_items = $this->db2->query("SELECT T.LZ_BD_ESTIMATE_ID, T.MPN_KIT_MT_ID, T.QTY, T.EST_SELL_PRICE, T.EBAY_FEE, T.PAYPAL_FEE, T.SHIPPING_FEE, T.TECH_COND_ID, T.ACT_QTY_RCVD, T.SPECIFIC_PIC_YN, T.LOCATION_ID, T.TECH_COND_DESC, T.ITEM_ID, T.ITEM_ADJ_DET_ID, T.ITEM_MANUFACTURER, T.SOLD_PRICE, T.PART_CATLG_MT_ID, T.MPN_DESCRIPTION, 1 QTY, T.LOT_ID FROM LZ_BD_ESTIMATE_DET_TMP T/*,(SELECT TT.PART_CATLG_MT_ID,COUNT(1) QTY FROM LZ_BD_ESTIMATE_DET_TMP TT GROUP  BY TT.PART_CATLG_MT_ID) T_QTY*/ WHERE /*T.PART_CATLG_MT_ID = T_QTY.PART_CATLG_MT_ID AND */T.PART_CATLG_MT_ID IS NOT NULL AND T.LZ_BD_ESTIMATE_ID = $lz_bd_estimate_id")->result_array(); if (count($data_items) > 0) {
               foreach ($data_items as $item) {
                $data_part_catlg_mt_id = $item['PART_CATLG_MT_ID'];

                // $data = $this->db2->query("SELECT T.PART_CATLG_MT_ID FROM LZ_BD_ESTIMATE_DET T WHERE T.PART_CATLG_MT_ID =$data_part_catlg_mt_id AND T.LZ_BD_ESTIMATE_ID = $lz_bd_estimate_id")->result_array();

                // if (count($data) > 0)
                // {
                  
                // }
                // else
                // {
                  $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ESTIMATE_DET','LZ_ESTIMATE_DET_ID') ID FROM DUAL");
                  $rs = $query->result_array();
                  $lz_estimate_det_id = $rs[0]['ID'];
                  $item_mt_manufacture = $item['ITEM_MANUFACTURER'];    
                  $mpn_description = $item['MPN_DESCRIPTION'];   
                  $est_sell_price = $item['EST_SELL_PRICE'];
                  $ebay_fee = $item['EBAY_FEE'];   
                  $paypal_fee = $item['PAYPAL_FEE'];
                  $new_qty = $item['QTY'];
                  $get_lot_id = $item['LOT_ID'];
                  if(!empty($bby_salePrice)){
                    $est_sell_price = $bby_salePrice;
                    $ebay_fee= ($est_sell_price  * (8 / 100));
                    $paypal_fee= ($est_sell_price  * (2.5 / 100));
                  }
                  if (empty($est_sell_price))
                  {
                   $est_sell_price = 1;
                   $ebay_fee= ($est_sell_price  * (8 / 100));
                   $paypal_fee= ($est_sell_price  * (2.5 / 100));
                  }   
                     
                  $sold_price = $item['SOLD_PRICE'];  
                  if (empty($sold_price))
                  {
                    $sold_price = 1;
                  } 
                  $part_catlg_mt_id = $item['PART_CATLG_MT_ID'];   

                  $qry_det = "INSERT INTO LZ_BD_ESTIMATE_DET(LZ_ESTIMATE_DET_ID, LZ_BD_ESTIMATE_ID, QTY, EST_SELL_PRICE, EBAY_FEE, PAYPAL_FEE, SHIPPING_FEE, TECH_COND_ID, ITEM_MANUFACTURER, SOLD_PRICE, PART_CATLG_MT_ID, MPN_DESCRIPTION, INSERTED_DATE,LOT_ID) VALUES($lz_estimate_det_id, $lz_bd_estimate_id, $new_qty, '$est_sell_price', '$ebay_fee', '$paypal_fee', 3.25, 3000, '$item_mt_manufacture', $sold_price, $part_catlg_mt_id, '$mpn_description', $estimate_date,$get_lot_id)";
                  $qry_det = $this->db2->query($qry_det);
                //}
              }
            }
            if ($qry_det)
            {
              $this->db2->query("TRUNCATE TABLE LZ_BD_ESTIMATE_DET_TMP");
              $this->db2->query("DELETE FROM LZ_COLUMN_MAPPING M WHERE M.STATUS = 1");
              $results = $this->db2->query("SELECT * FROM LZ_COLUMN_MAPPING M WHERE M.STATUS IN(0, 2)")->result_array();
              if (count($results) == 0)
              {
                $this->db2->query("TRUNCATE TABLE LZ_COLUMN_MAPPING");
              }
               return 1;
             }
             else
             {
              return 0;
             }
            }  
          }  /// end if upc and mpn is not empty
      } //end else of main if 
    } /// end of main function
      
    public function showData()
    {
      return $this->db2->query("SELECT * FROM LZ_COLUMN_MAPPING WHERE ROWNUM <= 5")->result_array();
    }

}
