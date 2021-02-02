<?php //$this->load->view('template/header');?>
<?php
require('get-common/Productionkeys_modified.php') ;
require('get-common/eBaySession.php');
function test_input($param) {
    $param = trim($param);
    $param = preg_replace('/\s+/', '+', $param);//replace space with +
    $param = stripslashes($param);
    $param = preg_replace('/\&+/', '%26', $param);//replace & with %26 i.e asscii value
    //$param = htmlspecialchars($param);
    //$param = rawurlencode($param);
    return $param;
  }
?>

<?php  
//var_dump(preg_replace('/\&+/', '%26', '&'));exit;
$exclude_word = '+-LOT+-EMPTY';
$j = 0;

if($data[0]['CONDITION'] == 'Used - Working'){
  $cond = 3000;
}elseif($data[0]['CONDITION'] == 'Returns'){
  $cond = 3000;
}elseif($data[0]['CONDITION'] == 'New'){
  $cond = 1000;
}elseif($data[0]['CONDITION'] == 'Open Box'){
  $cond = 1500;
}elseif($data[0]['CONDITION'] == 'Salvage'){
  $cond = 7000;
}else{
  $cond = 3000;
}



foreach ($data as $val){
  /*============================================================================
  =            pre define all variable in insertion / update query             =
  ============================================================================*/
  //to avoid undefine variable error
  $bby_upc               = '';
  $bby_mpn               = '';
  $URL                   = '';
  $error_msg             = '';
  $ship_fee              = '';
  $shippingWeight        = '';
  $object_name           = '';
  $avg_price_sold        = 1;
  $qty_sold              = 0;
  $watchCountSum         = 0;
  $categoryID            ='';
  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $update_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
  /*=====  End of pre define all variable in insertion / update query   ======*/
  $all_history = false;
  $bby_history = false;
  $cat_flag = false;
  $bby_data = false;
  $pre_url ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findCompletedItems&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
  $cond_flag = false;
  $category_flag = false;
  $key_null = false;
  
  $sku = $val['SKU'];
    if(!empty($sku)){
      /*===========================================================
      =            check data from last 7 days history            =
      ===========================================================*/
      $check_history = $this->db2->query("SELECT * FROM (SELECT D.CATEGORY_ID, TO_CHAR(D.PRICE_UPDATED, 'YYYY-MM-DD HH24:MI:SS') AS PRICE_UPDATED, D.BBY_UPC, D.BBY_MPN, D.AVG_SOLD_PRICE, D.QTY_SOLD, D.WATCH_COUNT, D.API_URL, D.ERROR_MSG, D.SHIP_FEE, D.WEIGHT, D.OBJECT_NAME FROM LZ_AUCTION_DET D WHERE D.SKU = $sku AND D.LINE_PROCESSED = 1 AND D.AVG_SOLD_PRICE <> 1 AND D.PRICE_UPDATED >= SYSDATE - 15 ORDER BY D.LZ_AUCTION_DET_ID DESC) WHERE ROWNUM = 1")->result_array(); 
      if (count($check_history) > 0) {
          
          $update_date               = "TO_DATE('".$check_history[0]['PRICE_UPDATED']."', 'YYYY-MM-DD HH24:MI:SS')";
          $bby_upc               = $check_history[0]['BBY_UPC'];
          $bby_mpn               = $check_history[0]['BBY_MPN'];
          $avg_price_sold               = $check_history[0]['AVG_SOLD_PRICE'];
          $qty_sold               = $check_history[0]['QTY_SOLD'];
          $watchCountSum               = $check_history[0]['WATCH_COUNT'];
          $URL               = $check_history[0]['API_URL'];
          $error_msg               = $check_history[0]['ERROR_MSG'];
          $ship_fee               = $check_history[0]['SHIP_FEE'];
          $shippingWeight               = $check_history[0]['WEIGHT'];
          $object_name               = $check_history[0]['OBJECT_NAME'];
          $all_history                     = true;
          $bby_history                     = true;

          $categoryID               = $check_history[0]['CATEGORY_ID'];
          if(!empty($categoryID)){
            $cat_flag = true;
          }
      }//CHECK HISTORY IF END
      /*=====  End of check data from last 7 days history  ======*/
      if($all_history === false){
        /*===========================================================
        =            check data bby history            =
        ===========================================================*/
        $check_history = $this->db2->query("SELECT * FROM (SELECT D.CATEGORY_ID, TO_CHAR(D.PRICE_UPDATED, 'YYYY-MM-DD HH24:MI:SS') AS PRICE_UPDATED, D.BBY_UPC, D.BBY_MPN, D.AVG_SOLD_PRICE, D.QTY_SOLD, D.WATCH_COUNT, D.API_URL, D.ERROR_MSG, D.SHIP_FEE, D.WEIGHT, D.OBJECT_NAME FROM LZ_AUCTION_DET D WHERE D.SKU = $sku AND D.LINE_PROCESSED= 1 ORDER BY D.LZ_AUCTION_DET_ID DESC) WHERE ROWNUM = 1")->result_array(); 
        if (count($check_history) > 0) {

            // $update_date               = $check_history[0]['PRICE_UPDATED'];
            $bby_upc               = $check_history[0]['BBY_UPC'];
            $bby_mpn               = $check_history[0]['BBY_MPN'];
            //$avg_price_sold               = $check_history[0]['AVG_SOLD_PRICE'];
            //$qty_sold               = $check_history[0]['QTY_SOLD'];
            //$watchCountSum               = $check_history[0]['WATCH_COUNT'];
            //$URL               = $check_history[0]['API_URL'];
            //$error_msg               = $check_history[0]['ERROR_MSG'];
            $ship_fee               = $check_history[0]['SHIP_FEE'];
            $shippingWeight               = $check_history[0]['WEIGHT'];
            $object_name               = $check_history[0]['OBJECT_NAME'];
            $bby_history                     = true;
            $categoryID               = $check_history[0]['CATEGORY_ID'];
            if(!empty($categoryID)){
              $cat_flag = true;
            }

        }else{//CHECK bby HISTORY IF END
          
        $check_history = $this->db2->query("SELECT MT.UPC BBY_UPC,MT.MODELNUMBER BBY_MPN,MT.BBY_CLASS,MT.BBY_TYPE,MT.SHIPPINGWEIGHT WEIGHT,MT.SALEPRICE FROM LZ_BD_BBY_CATALOG_MT MT WHERE MT.SKU = $sku ")->result_array(); 
        if (count($check_history) > 0) {

            $bby_upc               = $check_history[0]['BBY_UPC'];
            $bby_mpn               = $check_history[0]['BBY_MPN'];
            $shippingWeight               = $check_history[0]['WEIGHT'];
            //$bby_salePrice         = $check_history[0]['SALEPRICE'];
            /*==================================================================
            =            calculate shipping fee according to wieght            =
            ==================================================================*/
            if($shippingWeight <= 1){
              $ship_fee = 3.50;
            }elseif($shippingWeight > 1 AND $shippingWeight <= 2){
              $ship_fee = 7.75;
            }elseif($shippingWeight > 2 AND $shippingWeight <= 4){
              $ship_fee = 11.50;
            }elseif($shippingWeight > 4 AND $shippingWeight <= 6){
              $ship_fee = 15.00;
            }elseif($shippingWeight > 6 AND $shippingWeight <= 20){
              $ship_fee = 20.00;
            }elseif($shippingWeight > 20){
              $ship_fee = 30.00;
            }else{
              $ship_fee = 3.25;
            }
            /*=====  End of calculate shipping fee according to wieght  ======*/
            
            if(!empty($check_history[0]['BBY_CLASS'])){
              $object_name = $check_history[0]['BBY_CLASS'];
            }else{
              $object_name = $check_history[0]['BBY_TYPE'];
            }
            $bby_history                     = true;
            
          }
        }
        /*=====  End of check data bby history  ======*/
      }//end if $all_history === false
      
    if($bby_history === false){

      /*====================================
      =            best buy api            =
      ====================================*/
      $api_key = "I3jYAFrGG5rdGhMKJBfH7dTA";//sajid key
      //$api_key = "emnOAiWzAur77qO5uHadnze8";//nadeem key old
      //$api_key = "lCghAabQYkpV3CJvIQCHqJ9B";//nadeem key new 17 aug 18

      $bby_url ="https://api.bestbuy.com/v1/products(sku=$sku)?format=xml&show=description,details.name,details.value,image,manufacturer,name,salePrice,upc,type,sku,shortDescription,modelNumber,longDescription,features.feature,height,width,depth,shippingWeight,weight,shippingCost,class&apiKey=$api_key";

      $XML = new SimpleXMLElement(file_get_contents($bby_url));
      //echo  $XML['attributes'];//->totalPages.'<br>';
      //$name = $XML->product->name;
      if(isset($XML->product)){
        $bby_data = true;
        $bby_salePrice = $XML->product->salePrice;
        $shippingCost = $XML->product->shippingCost;
        $shippingWeight = $XML->product->shippingWeight;
        /*==================================================================
        =            calculate shipping fee according to wieght            =
        ==================================================================*/
        if($shippingWeight <= 1){
          $ship_fee = 3.50;
        }elseif($shippingWeight > 1 AND $shippingWeight <= 2){
          $ship_fee = 7.75;
        }elseif($shippingWeight > 2 AND $shippingWeight <= 4){
          $ship_fee = 11.50;
        }elseif($shippingWeight > 4 AND $shippingWeight <= 6){
          $ship_fee = 15.00;
        }elseif($shippingWeight > 6 AND $shippingWeight <= 20){
          $ship_fee = 20.00;
        }elseif($shippingWeight > 20){
          $ship_fee = 30.00;
        }else{
          $ship_fee = 3.25;
        }
        /*=====  End of calculate shipping fee according to wieght  ======*/
        
        if(!empty($shippingCost)){
          $bby_salePrice = $bby_salePrice + $shippingCost;
        }
        $object_name = $XML->product->class; 
        if(empty($object_name)){
          $object_name = $XML->product->type;
        }
        $bby_upc = $XML->product->upc;
        $bby_mpn = $XML->product->modelNumber;
      }else{
        
        $bby_url ="https://api.bestbuy.com/v1/products(sku=$sku&active=false)?format=xml&show=description,details.name,details.value,image,manufacturer,name,salePrice,upc,type,sku,shortDescription,modelNumber,longDescription,features.feature,height,width,depth,shippingWeight,weight,shippingCost,class&apiKey=$api_key";
        $XML = new SimpleXMLElement(file_get_contents($bby_url));
          if(isset($XML->product)){
            $bby_data = true;
            $bby_salePrice = $XML->product->salePrice;
            $shippingCost = $XML->product->shippingCost;
            $shippingWeight = $XML->product->shippingWeight;
            /*==================================================================
            =            calculate shipping fee according to wieght            =
            ==================================================================*/
            if($shippingWeight <= 1){
              $ship_fee = 3.50;
            }elseif($shippingWeight > 1 AND $shippingWeight <= 2){
              $ship_fee = 7.75;
            }elseif($shippingWeight > 2 AND $shippingWeight <= 4){
              $ship_fee = 11.50;
            }elseif($shippingWeight > 4 AND $shippingWeight <= 6){
              $ship_fee = 15.00;
            }elseif($shippingWeight > 6 AND $shippingWeight <= 20){
              $ship_fee = 20.00;
            }elseif($shippingWeight > 20){
              $ship_fee = 30.00;
            }else{
              $ship_fee = 3.25;
            }
            /*=====  End of calculate shipping fee according to wieght  ======*/
            if(!empty($shippingCost)){
              $bby_salePrice = $bby_salePrice + $shippingCost;
            }
            $object_name = $XML->product->class; 
            if(empty($object_name)){
              $object_name = $XML->product->type;
            }
            $bby_upc = $XML->product->upc;
            $bby_mpn = $XML->product->modelNumber;
          }else{
            $bby_data = false;
            $bby_salePrice = '';
            $bby_upc = '';
            $bby_mpn = '';
            $ship_fee = 3.25;
            $shippingWeight = '';
            $object_name = '';
          }
      }

    }//end if $bby_history === false
    
    }else{// !empty($sku) if close
      $bby_data = false;
      $bby_salePrice = '';
      $bby_upc = '';
      $bby_mpn = '';
      $ship_fee = 3.25;
      $shippingWeight = '';
      $object_name = '';
    }
    /*=====  End of best buy api  ======*/
    $bby_key = false;//currently not using this

    if($bby_data === true){
      if(!empty($bby_upc)){
          $key = $bby_upc;
          $bby_key = true;
        }elseif(!empty($bby_mpn)){
          $key = $bby_mpn;
          $bby_key = true;
        }else{
          if(!empty(trim($val['UPC']))){
              $key = trim($val['UPC']);
            }elseif(!empty(trim($val['MPN']))){
              $key = trim($val['MPN']);
            }else{
              $key = '';
              $key_null = true;
            }
        }
      }else{
            if(!empty(trim($val['UPC']))){
              $key = trim($val['UPC']);
            }elseif(!empty(trim($val['MPN']))){
              $key = trim($val['MPN']);
            }else{
              $key = '';
              $key_null = true;
            }
      }
    
    $KeyWord = $key;//.'+-LOT+-EMPTY';
    //var_dump($KeyWord);
    
    $KeyWord = test_input(trim($KeyWord));
    $orignal_key = $KeyWord;
   // $flag = TRUE;
    if($cat_flag === false){
      /*=======================================================
      =            get category_id against keyword            =
      =======================================================*/
      
      if (!empty(trim($val['UPC'])) OR !empty($bby_upc)) {
        if(!empty($bby_upc)){
            $upc = $bby_upc;
        }else{
          $upc = trim($val['UPC']);
        }
        
        // $upcs = $this->db2->query("SELECT * FROM (SELECT D.E_BAY_CATA_ID_SEG6, D.MAIN_CATAGORY_SEG1, D.BRAND_SEG3, D.CATEGORY_NAME_SEG7 FROM LZ_MANIFEST_DET@ORASERVER D WHERE D.ITEM_MT_UPC = '$upc' ORDER BY D.LAPTOP_ZONE_ID DESC ) WHERE ROWNUM = 1")->result_array();
        //  if (count($upcs) > 0) {
        //   if(is_numeric($upcs[0]['E_BAY_CATA_ID_SEG6'])){
        //     $categoryID               = $upcs[0]['E_BAY_CATA_ID_SEG6'];
        //     $flag                     = FALSE;
        //   }
        // }

        $upcs = $this->db2->query("SELECT * FROM (SELECT D.CATEGORY_ID, D.PRICE_UPDATED, D.BBY_UPC, D.BBY_MPN, D.AVG_SOLD_PRICE, D.QTY_SOLD, D.WATCH_COUNT, D.API_URL, D.ERROR_MSG, D.SHIP_FEE, D.WEIGHT, D.OBJECT_NAME FROM LZ_AUCTION_DET D WHERE D.BBY_UPC = '$upc' OR D.UPC = '$upc'AND D.CATEGORY_ID IS NOT NULL ORDER BY D.LZ_AUCTION_DET_ID DESC) WHERE ROWNUM = 1")->result_array(); 
        if (count($upcs) > 0) {
          if(is_numeric($upcs[0]['CATEGORY_ID'])){
            $categoryID               = $upcs[0]['CATEGORY_ID'];
            $cat_flag                     = true;
          }
        }
      }
      if ((!empty(trim($val['MPN'])) OR !empty($bby_mpn)) AND $cat_flag == false) {
          if(!empty($bby_mpn)){
              $mpn = strtoupper($bby_mpn);
          }else{
            $mpn = strtoupper(trim($val['MPN']));
          }

        //   $mpns = $this->db2->query("SELECT * FROM (SELECT D.E_BAY_CATA_ID_SEG6, D.MAIN_CATAGORY_SEG1, D.BRAND_SEG3, D.CATEGORY_NAME_SEG7 FROM LZ_MANIFEST_DET@ORASERVER D WHERE UPPER(D.ITEM_MT_MFG_PART_NO) = '$mpn' ORDER BY D.LAPTOP_ZONE_ID DESC ) WHERE ROWNUM = 1")->result_array();
        // if (count($mpns) > 0) {
        //   if(is_numeric($mpns[0]['E_BAY_CATA_ID_SEG6'])){
        //     $categoryID               = $mpns[0]['E_BAY_CATA_ID_SEG6'];
        //     $cat_flag                     = FALSE;
        //   }
        // }

        $mpns = $this->db2->query("SELECT * FROM (SELECT D.CATEGORY_ID, D.PRICE_UPDATED, D.BBY_UPC, D.BBY_MPN, D.AVG_SOLD_PRICE, D.QTY_SOLD, D.WATCH_COUNT, D.API_URL, D.ERROR_MSG, D.SHIP_FEE, D.WEIGHT, D.OBJECT_NAME FROM LZ_AUCTION_DET D WHERE UPPER(D.BBY_MPN) = '$mpn' OR UPPER(D.MPN) = '$mpn'AND D.CATEGORY_ID IS NOT NULL ORDER BY D.LZ_AUCTION_DET_ID DESC) WHERE ROWNUM = 1")->result_array();
        if (count($mpns) > 0) {
          if(is_numeric($mpns[0]['CATEGORY_ID'])){
            $categoryID               = $mpns[0]['CATEGORY_ID'];
            $cat_flag                     = true;
          }
        }
      }
      /*=====  End of get category_id against keyword  ======*/
    }
    
    // if(!empty($object_name) AND strtoupper($object_name) == 'MOBILE COMPUTING'){
    //   $categoryID = 177;
    // }
    /*================================================
    =            get category id from api            =
    ================================================*/
    $cat_flag == true;//dont run cat api
    if($cat_flag === false AND $key_null != true){
      $siteID = 0;
      //the call being made:
      $verb = 'GetSuggestedCategories';
      ///Build the request Xml string
      $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
      $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
      $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
      $requestXmlBody .= "<Query>$KeyWord</Query>";
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
          // $categoryParentName1    = $cat->CategoryParentName[0];
          // $categoryParentName2    = $cat->CategoryParentName[1];
          // $categoryName           = $cat->CategoryName;
          $categoryID             = $cat->CategoryID;
      }elseif($KeyWord == trim($val['UPC']) OR $KeyWord == $bby_upc){
        if(!empty($bby_mpn)){
            $mpn = strtoupper($bby_mpn);
        }else{
          $mpn = strtoupper(trim($val['MPN']));
        }
        $MPN = str_replace("&", "and", trim($mpn));
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
            // $categoryParentName1 = $cat->CategoryParentName[0];
            // $categoryParentName2 = $cat->CategoryParentName[1];
            // $categoryName = $cat->CategoryName;
            $categoryID = $cat->CategoryID;
            }else{
            // $categoryParentName1 = NULL;
            // $categoryParentName2 = NULL;
            // $categoryName = NULL;
            $categoryID = NULL;
            }
      }else{
        // $categoryParentName1 = NULL;
        // $categoryParentName2 = NULL;
        // $categoryName = NULL;
        $categoryID = NULL;
      }
    
    }//end flag if
    $category = $categoryID;
    $det_id = $val['LZ_AUCTION_DET_ID'];
    /*=====  End of get category id from api  ======*/
    $NumPerPage = 50;
    $sortOrder = "EndTimeSoonest";
    $usonly = '&LH_PrefLoc=1';//US only filter
    // $buyingFormat = "&itemFilter(1).name=ListingType";
    // $buyingFormat.="&itemFilter(1).value(0)=FixedPrice";
    
    if(!empty($category)){
      $categoryId="&categoryId=".$category;//.$categoryId;
    }else{$categoryId="";}

    $HideDuplicateItems="&HideDuplicateItems=true";
    $MinQuantity="&MinQuantity=1";
    //$ValueBoxInventory="&ValueBoxInventory=1";
    $pageNumber = 1;
    $soldDataOnly = '&itemFilter(0).name=SoldItemsOnly&itemFilter(0).value=true';
    //$pageNumber = $return["pageNumber"];
    $condition = "&itemFilter(1).name=Condition";
    $condition.="&itemFilter(1).value(0)=".$cond;
    /*=============================================================
    =            call ebay API if all history == false            =
    =============================================================*/
    if($all_history === false AND $key_null != true){

      if(!empty($val['BRAND']) AND !empty($val['BBY_MPN'])){
          if (strpos($KeyWord, $val['BBY_MPN']) !== false) {//check if key contain mpn
            $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
          }
      }else if(!empty($val['BRAND']) AND !empty($val['MPN'])){
        if (strpos($KeyWord, $val['MPN']) !== false) {//check if key contain mpn
            $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
          }
      }
      $KeyWord = $KeyWord.$exclude_word;
      
        $URL = $pre_url.$KeyWord.$categoryId.$soldDataOnly.$condition.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
          // print_r($URL);exit;
          $XML = new SimpleXMLElement(file_get_contents($URL));
          // echo "<pre>";
          // print_r($XML);
          // echo "</pre>";
          // exit;

          $i = 0;
          $sumPrice = 0;
          if (isset($XML->errorMessage)) {
                foreach ($XML->errorMessage->error as $error) {
                  if(strtoupper($error->severity) == 'ERROR'){
                    if($key == trim($val['MPN'])){
                      $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL', Error_msg = '$error->message', BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
                      continue;
                    }
                    
                  }
                }
              }
      /*==========================================
      =            get sold avg price            =
      ==========================================*/
          $paginationOutput = $XML->paginationOutput;
          if ($XML->ack !== 'Failure' AND $paginationOutput->totalEntries > 0) {
             
            $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
            if(empty($qty_sold)){
              $qty_sold = 0;
            }
            foreach($XML->searchResult->item as $item)
            {
              $listingInfo = $item->listingInfo;
              $watchCount = $listingInfo->watchCount;
              $watchCountSum += (int)$watchCount;
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
              $avg_price_sold = 1;
            }

           }elseif($key == trim($val['UPC']) OR $key == $bby_upc){// if ($XML->ack !== 'Failure') close for sold data call
              if(!empty($bby_mpn)){
                $KeyWord = $bby_mpn;
              }else{
                $KeyWord = trim($val['MPN']);
              }
              if(!empty($val['BRAND'])){
                $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
              }
              
              $KeyWord = $KeyWord.$exclude_word;
              $KeyWord = test_input($KeyWord);
              $URL = $pre_url.$KeyWord.$categoryId.$soldDataOnly.$condition.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
              // print_r($URL);exit;
              $XML = new SimpleXMLElement(file_get_contents($URL));

              $i = 0;
              $sumPrice = 0;
              if (isset($XML->errorMessage)) {
                foreach ($XML->errorMessage->error as $error) {
                  if(strtoupper($error->severity) == 'ERROR'){
                    $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL', Error_msg = '$error->message', BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
                    continue;
                  }
                }
              }

              $paginationOutput = $XML->paginationOutput;
                if ($XML->ack !== 'Failure' AND $paginationOutput->totalEntries > 0) {
                   
                  $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
                  if(empty($qty_sold)){
                    $qty_sold = 0;
                  }
                  foreach($XML->searchResult->item as $item)
                  {
                    $listingInfo = $item->listingInfo;
                    $watchCount = $listingInfo->watchCount;
                    $watchCountSum += (int)$watchCount;
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
                    $avg_price_sold = 1;
                  }

                 }else{
                  //price not found on ebay
                  $cond_flag = true;
                  $avg_price_sold = 1;
                  $qty_sold = 0;
                 }
            }else{// main else if close
              $cond_flag = true;
            }
            /*======================================================================
            =            runcall with out condition filter if flag true            =
            ======================================================================*/
            if($cond_flag === true){

              $KeyWord = $orignal_key;
              if(!empty($val['BRAND']) AND !empty($val['BBY_MPN'])){
                  if (strpos($KeyWord, $val['BBY_MPN']) !== false) {//check if key contain mpn
                    $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
                  }
              }else if(!empty($val['BRAND']) AND !empty($val['MPN'])){
                if (strpos($KeyWord, $val['MPN']) !== false) {//check if key contain mpn
                    $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
                  }
              }
              $KeyWord = $KeyWord.$exclude_word;
              $URL = $pre_url.$KeyWord.$categoryId.$soldDataOnly.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
              // print_r($URL);exit;
              $XML = new SimpleXMLElement(file_get_contents($URL));

              $i = 0;
              $sumPrice = 0;
              if (isset($XML->errorMessage)) {
                    foreach ($XML->errorMessage->error as $error) {
                      if(strtoupper($error->severity) == 'ERROR'){
                        if($key == trim($val['MPN'])){
                          $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL', Error_msg = '$error->message', BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
                          continue;
                        }
                        
                      }
                    }
                  }
          /*==========================================
          =            get sold avg price            =
          ==========================================*/
              $paginationOutput = $XML->paginationOutput;
              if ($XML->ack !== 'Failure' AND $paginationOutput->totalEntries > 0) {
                 
                  $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
                  foreach($XML->searchResult->item as $item)
                  {
                    $listingInfo = $item->listingInfo;
                    $watchCount = $listingInfo->watchCount;
                    $watchCountSum += (int)$watchCount;

                    $sellingStatus = $item->sellingStatus;
                    $soldPrice = $sellingStatus->convertedCurrentPrice;
                    /*==================================================================
                    =            if condition 1000,1500 half the sold price            =
                    ==================================================================*/
                    $condition = $item->condition;
                    $conditionId = $condition->conditionId;
                    if((int)$conditionId == 1000 OR (int)$conditionId == 1500){
                      $soldPrice = $soldPrice / 2;//HALF THE PRICE
                    }
                    /*=====  End of if condition 1000,1500 half the sold price  ======*/
                    $shippingInfo = $item->shippingInfo;
                    $shipCost=$shippingInfo->shippingServiceCost;

                    $sumPrice += (float)$soldPrice + (float)$shipCost;
                    //var_dump($soldPrice,$shipCost,$avgPrice);exit;
                     $i++;
                  }
                  if($i>0){
                    $avg_price_sold = $sumPrice / $i ;
                  }else{
                    $avg_price_sold = 1;
                  }
                }elseif($key == trim($val['UPC']) OR $key == $bby_upc){// if ($XML->ack !== 'Failure') close for sold data call
                if(!empty($bby_mpn)){
                  $KeyWord = $bby_mpn;
                }else{
                  $KeyWord = trim($val['MPN']);
                }
                if(!empty($val['BRAND'])){
                  $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
                }
                
                $KeyWord = $KeyWord.$exclude_word;
                $KeyWord = test_input($KeyWord);
                $URL = $pre_url.$KeyWord.$categoryId.$soldDataOnly.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
                // print_r($URL);exit;
                $XML = new SimpleXMLElement(file_get_contents($URL));

                $i = 0;
                $sumPrice = 0;
                if (isset($XML->errorMessage)) {
                  foreach ($XML->errorMessage->error as $error) {
                    if(strtoupper($error->severity) == 'ERROR'){
                      $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL', Error_msg = '$error->message', BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
                      continue;
                    }
                  }
                }

                $paginationOutput = $XML->paginationOutput;
                if ($XML->ack !== 'Failure' AND $paginationOutput->totalEntries > 0) {
                   
                  $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
                  if(empty($qty_sold)){
                    $qty_sold = 0;
                  }
                  foreach($XML->searchResult->item as $item)
                  {
                    $listingInfo = $item->listingInfo;
                    $watchCount = $listingInfo->watchCount;
                    $watchCountSum += (int)$watchCount;
                    $sellingStatus = $item->sellingStatus;
                    $soldPrice=$sellingStatus->convertedCurrentPrice;
                    /*==================================================================
                    =            if condition 1000,1500 half the sold price            =
                    ==================================================================*/
                    $condition = $item->condition;
                    $conditionId = $condition->conditionId;
                    if((int)$conditionId == 1000 OR (int)$conditionId == 1500){
                      $soldPrice = $soldPrice / 2;//HALF THE PRICE
                    }
                    /*=====  End of if condition 1000,1500 half the sold price  ======*/
                    $shippingInfo = $item->shippingInfo;
                    $shipCost=$shippingInfo->shippingServiceCost;
                    $sumPrice += (float)$soldPrice + (float)$shipCost;
                    //var_dump($soldPrice,$shipCost,$avgPrice);exit;
                     $i++;
                  }
                  if($i>0){
                    $avg_price_sold = $sumPrice / $i ;
                  }else{
                    $avg_price_sold = 1;
                  }

                 }else{
                  //price not found on ebay
                  $category_flag = true;
                 }
            }else{
                $category_flag = true;
            }
            
            }//end $cond_flag === true if
            /*=====  End of runcall with out condition filter if flag true  ======*/
            
            /*======================================================================
            =            runcall with out condition & category filter if flag true            =
            ======================================================================*/
            if($category_flag === true){
              $KeyWord = $orignal_key;
              if(!empty($val['BRAND']) AND !empty($val['BBY_MPN'])){
                  if (strpos($KeyWord, $val['BBY_MPN']) !== false) {//check if key contain mpn
                    $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
                  }
              }else if(!empty($val['BRAND']) AND !empty($val['MPN'])){
                if (strpos($KeyWord, $val['MPN']) !== false) {//check if key contain mpn
                    $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
                  }
              }
              $KeyWord = $KeyWord.$exclude_word;
              $URL = $pre_url.$KeyWord.$soldDataOnly.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
              // print_r($URL);exit;
              $XML = new SimpleXMLElement(file_get_contents($URL));

              $i = 0;
              $sumPrice = 0;
              if (isset($XML->errorMessage)) {
                    foreach ($XML->errorMessage->error as $error) {
                      if(strtoupper($error->severity) == 'ERROR'){
                        if($key == trim($val['MPN'])){
                          $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL', Error_msg = '$error->message', BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
                          continue;
                        }
                        
                      }
                    }
                  }
          /*==========================================
          =            get sold avg price            =
          ==========================================*/
              $paginationOutput = $XML->paginationOutput;
              if ($XML->ack !== 'Failure' AND $paginationOutput->totalEntries > 0) {
                 
                $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
                foreach($XML->searchResult->item as $item)
                {
                  $listingInfo = $item->listingInfo;
                  $watchCount = $listingInfo->watchCount;
                  $watchCountSum += (int)$watchCount;

                  $sellingStatus = $item->sellingStatus;
                  $soldPrice = $sellingStatus->convertedCurrentPrice;
                  /*==================================================================
                  =            if condition 1000,1500 half the sold price            =
                  ==================================================================*/
                  $condition = $item->condition;
                  $conditionId = $condition->conditionId;
                  if((int)$conditionId == 1000 OR (int)$conditionId == 1500){
                    $soldPrice = $soldPrice / 2;//HALF THE PRICE
                  }
                  /*=====  End of if condition 1000,1500 half the sold price  ======*/
                  $shippingInfo = $item->shippingInfo;
                  $shipCost=$shippingInfo->shippingServiceCost;

                  $sumPrice += (float)$soldPrice + (float)$shipCost;
                  //var_dump($soldPrice,$shipCost,$avgPrice);exit;
                   $i++;
                }
                if($i>0){
                  $avg_price_sold = $sumPrice / $i ;
                }else{
                  $avg_price_sold = 1;
                }
              }elseif($key == trim($val['UPC']) OR $key == $bby_upc){// if ($XML->ack !== 'Failure') close for sold data call
                if(!empty($bby_mpn)){
                  $KeyWord = $bby_mpn;
                }else{
                  $KeyWord = trim($val['MPN']);
                }
                if(!empty($val['BRAND'])){
                  $KeyWord = test_input($val['BRAND'])."+".$KeyWord;
                }
                
                $KeyWord = $KeyWord.$exclude_word;
                $KeyWord = test_input($KeyWord);
                $URL = $pre_url.$KeyWord.$soldDataOnly.$MinQuantity.$HideDuplicateItems."&sortOrder=".$sortOrder."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber.$usonly;
                // print_r($URL);exit;
                $XML = new SimpleXMLElement(file_get_contents($URL));

                $i = 0;
                $sumPrice = 0;
                if (isset($XML->errorMessage)) {
                  foreach ($XML->errorMessage->error as $error) {
                    if(strtoupper($error->severity) == 'ERROR'){
                      $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL', Error_msg = '$error->message', BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
                      continue;
                    }
                  }
                }

                $paginationOutput = $XML->paginationOutput;
                if ($XML->ack !== 'Failure' AND $paginationOutput->totalEntries > 0) {
                   
                  $qty_sold = $paginationOutput->totalEntries;// variables inside "" cannot be longer than 2!!
                  if(empty($qty_sold)){
                    $qty_sold = 0;
                  }
                  foreach($XML->searchResult->item as $item)
                  {
                    $listingInfo = $item->listingInfo;
                    $watchCount = $listingInfo->watchCount;
                    $watchCountSum += (int)$watchCount;
                    $sellingStatus = $item->sellingStatus;
                    $soldPrice=$sellingStatus->convertedCurrentPrice;
                    /*==================================================================
                    =            if condition 1000,1500 half the sold price            =
                    ==================================================================*/
                    $condition = $item->condition;
                    $conditionId = $condition->conditionId;
                    if((int)$conditionId == 1000 OR (int)$conditionId == 1500){
                      $soldPrice = $soldPrice / 2;//HALF THE PRICE
                    }
                    /*=====  End of if condition 1000,1500 half the sold price  ======*/
                    $shippingInfo = $item->shippingInfo;
                    $shipCost=$shippingInfo->shippingServiceCost;
                    $sumPrice += (float)$soldPrice + (float)$shipCost;
                    //var_dump($soldPrice,$shipCost,$avgPrice);exit;
                     $i++;
                  }
                  if($i>0){
                    $avg_price_sold = $sumPrice / $i ;
                  }else{
                    $avg_price_sold = 1;
                  }

                 }else{
                  //price not found on ebay
                  $condition_flag = true;
                 }
            }else{
                $condition_flag = true;
              }
            
            }//end $category_flag === true if
            /*=====  End of runcall with out condition & category filter if flag true  ======*/

    }//end $all_history === false if
    
    /*=====  End of call ebay API if all history == false  ======*/

    $this->db2->query("UPDATE LZ_AUCTION_DET SET AVG_SOLD_PRICE = '$avg_price_sold',QTY_SOLD = '$qty_sold' , PRICE_UPDATED = $update_date,API_URL = '$URL' , BBY_UPC = '$bby_upc',BBY_MPN = '$bby_mpn',LINE_PROCESSED = 1,SHIP_FEE = '$ship_fee',WEIGHT = '$shippingWeight',CATEGORY_ID = '$category',OBJECT_NAME = '$object_name',WATCH_COUNT = '$watchCountSum'  WHERE LZ_AUCTION_DET_ID = $det_id");
    /*=====  End of loop on every posible condition in given category  ======*/
     if($val['LZ_AUCTION_ID'] != @$data[$j+1]['LZ_AUCTION_ID']){
      $mt_id = $val['LZ_AUCTION_ID'];
      $this->db2->query("UPDATE LZ_AUCTION_MT SET PROCESSED = 1 WHERE LZ_AUCTION_ID = $mt_id");
     }
     echo "Data Downnloaded Against Auction Det Id:".$det_id.PHP_EOL;
     $j++;
  //}// end if LINE_PROCESSED = 0 
}//end foreach
?>
