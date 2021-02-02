<?php //$this->load->view('template/header');?>
<?php
function test_input($data) {
    $data = trim($data);
    $data = preg_replace('/\s+/', '+', $data);//replace space with +
    $data = stripslashes($data);
    $data = preg_replace('/\&+/', '%26', $data);//replace & with %26 i.e asscii value
    //$data = htmlspecialchars($data);
    //$data = rawurlencode($data);
    return $data;
  }
?>

<?php 
//var_dump(preg_replace('/\&+/', '%26', '&'));exit;
foreach ($data as $val){
  $KeyWord = '';
  $key = $val['KEYWORD'];
  $exclude_key = $val['EXCLUDE_WORDS'];
  $catalogue_mt_id = $val['CATLALOGUE_MT_ID'];
  $feed_url_id = $val['FEED_URL_ID'];
    $str = explode(' ',$key);
    if(count($str) > 1 ){
      foreach ($str as $value) {
        $KeyWord .='"'.$value.'" ';//adding quote for excat word search in any order

      }
      $KeyWord = str_replace(' ', '+', trim($KeyWord));
    }else{
      $KeyWord = test_input(trim($key));
    }

    if(!empty($exclude_key)){
      $exclude_key = str_replace(' ', '+', trim($exclude_key));
      $KeyWord .='+'.$exclude_key;
    }

    $KeyWord = $KeyWord.'+-LOT+-EMPTY';
    //var_dump($KeyWord);
    
    $KeyWord = test_input(trim($KeyWord));
    //var_dump($KeyWord);exit;
    //$cond = test_input($condition);
    $cond = $val['CONDITION_ID'];;
    //$category = test_input($category);
    $category = $val['CATEGORY_ID'];
    //var_dump($KeyWord);exit;
    // echo "<pre>";
    // print_r($KeyWord);
    // echo "</pre>";
    // exit;
    $NumPerPage = 50;
   
    $sortOrder = "EndTimeSoonest";

    $usonly = '&LH_PrefLoc=1';//US only filter
    $buyingFormat = "&itemFilter(1).name=ListingType";
    $buyingFormat.="&itemFilter(1).value(0)=FixedPrice";


    if(!empty($category)){
    $categoryId="&categoryId=".$category;//.$categoryId;
  }else{$categoryId="";}

    $HideDuplicateItems="&HideDuplicateItems=true";
    $MinQuantity="&MinQuantity=1";
    //$ValueBoxInventory="&ValueBoxInventory=1";
    $pageNumber = 1;
    $soldDataOnly = '&itemFilter(2).name=SoldItemsOnly&itemFilter(2).value=true';
    //$pageNumber = $return["pageNumber"];
    
    /*=========================================================================
    =            loop on every posible condition in given category            =
    =========================================================================*/
    $qry = $this->db2->query("SELECT C.CONDITION_ID FROM LZ_BD_CAT_COND C WHERE C.CATEGORY_ID = $category ORDER BY C.CONDITION_ID ASC");  
    $avail_cond = $qry->result_array();
    if($qry->num_rows() > 0){
      foreach ($avail_cond as $val) {
        $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findCompletedItems&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
        $condition = "&itemFilter(0).name=Condition";
        $condition.="&itemFilter(0).value(0)=".$val['CONDITION_ID'];

        $URL = $URL.$KeyWord.$categoryId.$condition.$buyingFormat.$soldDataOnly.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
        // print_r($URL);exit;
        $XML = new SimpleXMLElement(file_get_contents($URL));

        $i = 0;
        $sumPrice = 0;
        if (isset($XML->errorMessage)) {
          foreach ($XML->errorMessage->error as $error) {
              printf(
                  "%s: %s\n\n",
                  $error->severity,
                  $error->message
              );
          }
        }
    /*==========================================
    =            get sold avg price            =
    ==========================================*/
        if ($XML->ack !== 'Failure') {
          $paginationOutput = $XML->paginationOutput; 
          $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
          if(empty($qty_sold)){
            $qty_sold = 0;
          }
          foreach($XML->searchResult->item as $item)
          {
            $sellingStatus = $item->sellingStatus;
            $soldPrice=$sellingStatus->convertedCurrentPrice;
            $shippingInfo = $item->shippingInfo;
            $shipCost=$shippingInfo->shippingServiceCost;
            $sumPrice += (float)$soldPrice + (float)$shipCost;
            //var_dump($soldPrice,$shipCost,$avgPrice);exit;
             $i++;
          }
          if($i>0){
            $avg_price_sold = $sumPrice / $i ;
          }else{
            $avg_price_sold = 0;
          }

          
           $condition_id = $val['CONDITION_ID'];
            $qry = $this->db2->query("SELECT SEQ_LZ_BD_API_AVG_PRICE.NEXTVAL FROM DUAL");  
            $rs = $qry->result_array();
            $api_avg_price_id = $rs[0]['NEXTVAL'];

            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $update_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

           $this->db2->query("INSERT INTO LZ_BD_API_AVG_PRICE(API_AVG_PRICE_ID, CATALOGUE_MT_ID, CONDITION_ID, AVG_PRICE_SOLD, AVG_PRICE_ACTIVE, QTY_SOLD, QTY_ACTIVE, UPDATE_DATE,ITEM_PER_PAGE,FEED_URL_ID)VALUES($api_avg_price_id,$catalogue_mt_id,$condition_id,$avg_price_sold,null,$qty_sold,null,$update_date,$NumPerPage,$feed_url_id)"); 
         }// if ($XML->ack !== 'Failure') close for sold data call


    /*=====  End of get sold avg price  ======*/


          /*============================================
           =            get active avg price            =
           ============================================*/
          $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
          $URL = $URL.$KeyWord.$categoryId.$condition.$buyingFormat.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
           //print_r($URL);//exit;
           $XML = new SimpleXMLElement(file_get_contents($URL));

          
          $i = 0;
          $sumPrice = 0;
          if (isset($XML->errorMessage)) {
            foreach ($XML->errorMessage->error as $error) {
                printf(
                    "%s: %s\n\n",
                    $error->severity,
                    $error->message
                );
            }
          }

          if ($XML->ack !== 'Failure') {
            $paginationOutput = $XML->paginationOutput; 
            $qty_active = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
            if(empty($qty_active)){
              $qty_active = 0;
            }
            foreach($XML->searchResult->item as $item)
            {
              $sellingStatus = $item->sellingStatus;
              $activePrice=$sellingStatus->convertedCurrentPrice;
              $shippingInfo = $item->shippingInfo;
              $shipCost=$shippingInfo->shippingServiceCost;
              $sumPrice += (float)$activePrice + (float)$shipCost;
              //var_dump($soldPrice,$shipCost,$avgPrice);exit;
               $i++;
            }

            if($i>0){
              $avg_price_active = $sumPrice / $i ;
            }else{
              $avg_price_active = 0;
            }
             
              date_default_timezone_set("America/Chicago");
              $date = date('Y-m-d H:i:s');
              $update_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

             $this->db2->query("UPDATE LZ_BD_API_AVG_PRICE SET AVG_PRICE_ACTIVE = $avg_price_active , QTY_ACTIVE = $qty_active, UPDATE_DATE = $update_date  WHERE API_AVG_PRICE_ID = $api_avg_price_id"); 

          }// if ($XML->ack !== 'Failure') close for active data call
         /*=====  End of get active avg price  ======*/
      }//end $avail_cond as $val foreach
    }else{
      $condition = "&itemFilter(0).name=Condition";
      $condition.="&itemFilter(0).value(0)=".$cond;

      $URL = $URL.$KeyWord.$categoryId.$condition.$buyingFormat.$soldDataOnly.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
        // print_r($URL);exit;
        $XML = new SimpleXMLElement(file_get_contents($URL));

        $i = 0;
        $sumPrice = 0;
        if (isset($XML->errorMessage)) {
          foreach ($XML->errorMessage->error as $error) {
              printf(
                  "%s: %s\n\n",
                  $error->severity,
                  $error->message
              );
          }
        }
    /*==========================================
    =            get sold avg price            =
    ==========================================*/
        if ($XML->ack !== 'Failure') {
          $paginationOutput = $XML->paginationOutput; 
          $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
          if(empty($qty_sold)){
            $qty_sold = 0;
          }
          foreach($XML->searchResult->item as $item)
          {
            $sellingStatus = $item->sellingStatus;
            $soldPrice=$sellingStatus->convertedCurrentPrice;
            $shippingInfo = $item->shippingInfo;
            $shipCost=$shippingInfo->shippingServiceCost;
            $sumPrice += (float)$soldPrice + (float)$shipCost;
            //var_dump($soldPrice,$shipCost,$avgPrice);exit;
             $i++;
          }
          if($i>0){
            $avg_price_sold = $sumPrice / $i ;
          }else{
            $avg_price_sold = 0;
          }

          
           $condition_id = $cond;
            $qry = $this->db2->query("SELECT SEQ_LZ_BD_API_AVG_PRICE.NEXTVAL FROM DUAL");  
            $rs = $qry->result_array();
            $api_avg_price_id = $rs[0]['NEXTVAL'];

            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $update_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

           $this->db2->query("INSERT INTO LZ_BD_API_AVG_PRICE(API_AVG_PRICE_ID, CATALOGUE_MT_ID, CONDITION_ID, AVG_PRICE_SOLD, AVG_PRICE_ACTIVE, QTY_SOLD, QTY_ACTIVE, UPDATE_DATE,ITEM_PER_PAGE,FEED_URL_ID)VALUES($api_avg_price_id,$catalogue_mt_id,$condition_id,$avg_price_sold,null,$qty_sold,null,$update_date,$NumPerPage,$feed_url_id)"); 
         }// if ($XML->ack !== 'Failure') close for sold data call


    /*=====  End of get sold avg price  ======*/


          /*============================================
           =            get active avg price            =
           ============================================*/
          $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
          $URL = $URL.$KeyWord.$categoryId.$condition.$buyingFormat.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
           //print_r($URL);//exit;
           $XML = new SimpleXMLElement(file_get_contents($URL));

          
          $i = 0;
          $sumPrice = 0;
          if (isset($XML->errorMessage)) {
            foreach ($XML->errorMessage->error as $error) {
                printf(
                    "%s: %s\n\n",
                    $error->severity,
                    $error->message
                );
            }
          }

          if ($XML->ack !== 'Failure') {
            $paginationOutput = $XML->paginationOutput; 
            $qty_active = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
            if(empty($qty_active)){
              $qty_active = 0;
            }
            foreach($XML->searchResult->item as $item)
            {
              $sellingStatus = $item->sellingStatus;
              $activePrice=$sellingStatus->convertedCurrentPrice;
              $shippingInfo = $item->shippingInfo;
              $shipCost=$shippingInfo->shippingServiceCost;
              $sumPrice += (float)$activePrice + (float)$shipCost;
              //var_dump($soldPrice,$shipCost,$avgPrice);exit;
               $i++;
            }

            if($i>0){
              $avg_price_active = $sumPrice / $i ;
            }else{
              $avg_price_active = 0;
            }
             
              date_default_timezone_set("America/Chicago");
              $date = date('Y-m-d H:i:s');
              $update_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

             $this->db2->query("UPDATE LZ_BD_API_AVG_PRICE SET AVG_PRICE_ACTIVE = $avg_price_active , QTY_ACTIVE = $qty_active, UPDATE_DATE = $update_date  WHERE API_AVG_PRICE_ID = $api_avg_price_id"); 

          }// if ($XML->ack !== 'Failure') close for active data call
         /*=====  End of get active avg price  ======*/
    }//end $qry->num_rows() > 0 if else
    

    /*=====  End of loop on every posible condition in given category  ======*/
    
     echo "Data Downnloaded Against feed_url_id:".$feed_url_id.PHP_EOL;
     
         
    

}//end foreach
?>
