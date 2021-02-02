
<?php  
  class M_search_estimate extends CI_Model{
    public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function displayAllData(){
   
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
      9 => 'SELLER_ID',
      10 => 'LOT_OFFER_AMOUNT',
      11 => 'INSERTED_DATE',
      12 => 'PLACE BID/OFFER',
      13 => 'STATUS',
      14 => 'ESTIMATE_TIME',
      15 => 'FLAG_NAME'
    );
    $estimate_title = strtoupper($this->input->post('estimate_title'));
    
    /*    $estimate_title = trim(str_replace("  ", ' ', $estimate_title));
    $estimate_title = trim(str_replace(array("'"), "''", $estimate_title));*/
    $lotsItems_qry = '';
    
    $userList = $this->db2->query("SELECT T.EMPLOYEE_ID, T.USER_NAME FROM EMPLOYEE_MT T WHERE T.LOCATION = 'PK' OR T.EMPLOYEE_ID IN(2,17,5)");
    $userData = $userList->result_array();
    //var_dump($userData);exit;

   $user_id = @$this->session->userdata('user_id');
   $sql = "SELECT DISTINCT E.LZ_BD_CATA_ID, E.CATEGORY_ID, E.EBAY_ID, E.TITLE, E.CONDITION_NAME, E.ITEM_URL, E.SALE_PRICE SALE_PRICE, E.LISTING_TYPE, TO_CHAR(E.INSERTED_DATE, 'DD-MM-YYYY HH24:MI:SS') INSERTED_DATE, TO_CHAR(TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24)) || 'd ' || TO_CHAR(TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) - 24 * (TRUNC((((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60) / 24))) || 'h ' || TO_CHAR(TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60) - 60 * (TRUNC(((86400 * (E.SALE_TIME - SYSDATE)) / 60) / 60))) || 'm ' || TO_CHAR(TRUNC(86400 * (E.SALE_TIME - SYSDATE)) - 60 * (TRUNC((86400 * (E.SALE_TIME - SYSDATE)) / 60))) || 's ' TIME_DIFF, E.SELLER_ID, E.FEEDBACK_SCORE, E.CATEGORY_NAME, E.SHIPPING_TYPE, E.CATALOGUE_MT_ID, E.COST_PRICE, E.TRACKING_NO, E.ASSIGN_TO, T.TRACKING_ID, T.TRACKING_NO TRACKING_NUMBER, T.COST_PRICE TRACKING_COST, T.SELLER_DESCRIPTION, MT.LZ_BD_ESTIMATE_ID, O.OFFER_ID, O.OFFER_AMOUNT, O.REMARKS, MT.LOT_OFFER_AMOUNT, DECODE(O.WIN_STATUS, 0, 'LOST', 1, 'WON', 2, 'REJECTED') WIN_STATUS FROM LZ_BD_ITEMS_TO_EST   E, LZ_BD_TRACKING_NO    T, LZ_BD_ESTIMATE_MT    MT, LZ_BD_PURCHASE_OFFER O, LZ_BD_ESTIMATE_DET D, LZ_CATALOGUE_MT M WHERE E.IS_DELETED <> 1 AND E.FLAG_ID = 29 AND E.TRACKING_NO = T.TRACKING_ID(+) AND E.LZ_BD_CATA_ID = MT.LZ_BD_CATAG_ID(+) AND E.LZ_BD_CATA_ID = O.LZ_BD_CATA_ID(+) AND MT.LZ_BD_ESTIMATE_ID = D.LZ_BD_ESTIMATE_ID AND M.CATALOGUE_MT_ID = D.PART_CATLG_MT_ID ";

   if (!empty($estimate_title))
   {
    $search_query = '';
    $titles = explode(" ", $estimate_title);
    $j = 0;
    foreach ($titles as $row)
     {
      $row = trim(str_replace("  ", ' ', $row));
      $row = trim(str_replace(array("'"), "''", $row));
      if ($j == 0) {
        $search_query .= " UPPER(D.MPN_DESCRIPTION) LIKE '%".$row."%'";
      }else{
        $search_query .= " AND UPPER(D.MPN_DESCRIPTION) LIKE '%".$row."%'";
      }
      
      $j++;
      }

     $sql .= " AND ( UPPER(M.MPN) LIKE '%".$estimate_title."%' OR  UPPER(M.UPC) LIKE '%".$estimate_title."%' OR (".$search_query.")) ";
   }
   //var_dump($query); exit;
    $lotsItems_qry = $this->db2->query($sql);
    $totalData = $lotsItems_qry->num_rows();
    // var_dump($totalData);exit;
    $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
          
    if(!empty($requestData['search']['value']))
    {   
      // if there is a search parameter, $requestData['search']['value'] contains search parameter
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
    $totalFiltered = $query->num_rows(); 
    // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    //$sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    $sql = "SELECT * FROM (SELECT  q.*, rownum rn FROM ($sql ORDER BY LZ_BD_CATA_ID DESC) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start']." ";
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
      $nestedData[] = @$row['SELLER_ID'];
     
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
     $nestedData[] = @$row['FLAG_NAME'];
   }
      // $nestedData[] = $row["LIST_DATE"];
      // $nestedData[] = "";
      // $nestedData[] = $row["STATUS"];
      $data[] = $nestedData;
    $i++;
    }

    $json_data = array(
      "draw"            => intval($requestData['draw']),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal"    =>  intval($totalData),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data"            => $data   // total data array      
    );

    return $json_data;


     
  }
}
