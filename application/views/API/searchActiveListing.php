<?php //$this->load->view('template/header');?>
<?php
function test_input($data) {
    $data = trim($data);
    $data = preg_replace('/\s+/', '', $data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

<?php 

    $KeyWord = test_input($key);
    $cond = test_input($condition);
    $category = test_input($category);
    //var_dump($cond);
    $NumPerPage = 15;
   
    $sortOrder = "&sortOrder=PricePlusShippingLowest";
    //============= Multiple Coition Method ===================
      /*   &itemFilter(0).value(0)=New
           &itemFilter(0).value(1)=2000
           &itemFilter(0).value(2)=2500 */
 // ================= Multiple Condition ======================
if($cond == 3000){
    $condition = "&itemFilter(0).name=Condition";
    $condition.= "&itemFilter(0).value(0)=1000";//New
    $condition.= "&itemFilter(0).value(1)=1500";//New other
    $condition.= "&itemFilter(0).value(2)=3000";//Used
    $condition.= "&itemFilter(0).value(3)=2000";//Manufacturer Refurbished
    $condition.= "&itemFilter(0).value(4)=2500";//Seller Refurbished
    //$condition.="&itemFilter(0).value(5)=".$cond;// Custom
  }elseif($cond == 1000 || $cond == 1500){
    $condition = "&itemFilter(0).name=Condition";
    $condition.= "&itemFilter(0).value(0)=1000";//New
    $condition.= "&itemFilter(0).value(1)=1500";//New other
    //$condition.= "&itemFilter(0).value(2)=3000";//Used
    //$condition.= "&itemFilter(0).value(3)=2000";//Manufacturer Refurbished
    //$condition.= "&itemFilter(0).value(4)=2500";//Seller Refurbished
  }else{
    $condition = "&itemFilter(0).name=Condition";
    $condition.="&itemFilter(0).value(0)=".$cond;
  }
    $buyingFormat = "&itemFilter(1).name=ListingType";
    $buyingFormat.="&itemFilter(1).value(0)=FixedPrice";

    $sellerName = "&itemFilter(2).name=Seller";
    $k = 0;
    foreach ($sellers as $seller) {
      $sellerName.="&itemFilter(2).value($k)=".$seller['ACCOUNT_NAME'];
      $k++;
      if($k === 99){// maximum 100 value is allowed by api so this is added to avoid any error
        break;
      }
    }
    //$sellerName.="&itemFilter(2).value(0)=dfwonline";
    //$sellerName.="&itemFilter(2).value(1)=techbargains2015";
    //$seller = "&itemFilter(2).name=ReturnsAcceptedOnly";
    //$seller.="&itemFilter(2).value(0)=true";
    // $FreeShippingOnly = "&itemFilter(2).name=FreeShippingOnly";
    // $FreeShippingOnly.="&itemFilter(2).value(0)=true";

    if(!empty($category)){
    $categoryId="&categoryId=".$category;//.$categoryId;
  }else{$categoryId="";}
    //$Authorized = "&itemFilter(4).name=AuthorizedSellerOnly";
    //$Authorized .= "&itemFilter(4).value(0)=true";
    $SellerInfo = "&outputSelector(0)=SellerInfo";
    $PictureURLSuperSize = "&outputSelector(1)=PictureURLSuperSize";
    $StoreInfo = "&outputSelector(2)=StoreInfo";
    $HideDuplicateItems="&HideDuplicateItems=true";
    $MinQuantity="&MinQuantity=1";
    //$ValueBoxInventory="&ValueBoxInventory=1";
    $pageNumber = 1;
    //$pageNumber = $return["pageNumber"];
    $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
    $URL = $URL.$KeyWord."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber."&sortOrder=".$sortOrder.$MinQuantity.$HideDuplicateItems.$condition.$buyingFormat.$sellerName.$categoryId.$SellerInfo.$PictureURLSuperSize.$StoreInfo;

    $XML = new SimpleXMLElement(file_get_contents($URL));
// echo "<pre>";
// echo print_r($XML);
// echo "</pre>";exit;
    $json['ack']  = "$XML->ack";
    $paginationOutput = $XML->paginationOutput; 
    $json['resultCount']  = "$paginationOutput->totalEntries";// variables inside "" cannot be longer than 2!!
    $json['pageNumber']  = "$paginationOutput->pageNumber";
    $json['itemCount']  = "$paginationOutput->entriesPerPage";
    $json['totalPages']  = "$paginationOutput->totalPages";
    
    $i = 0;
    
    foreach($XML->searchResult->item as $item)
    {
      //$json['item'][$i]['basicInfo']['title'] = "$item->title";
      $json['item'][$i]['basicInfo']['viewItemURL'] = "$item->viewItemURL";
      //$json['item'][$i]['basicInfo']['galleryURL'] = "$item->galleryURL";
      //$json['item'][$i]['basicInfo']['pictureURLSuperSize'] = "$item->pictureURLSuperSize";
      $sellingStatus = $item->sellingStatus;
      $json['item'][$i]['basicInfo']['convertedCurrentPrice'] = "$sellingStatus->convertedCurrentPrice";
      //$shippingInfo = $item->shippingInfo;
      //$json['item'][$i]['basicInfo']['shippingServiceCost'] = "$shippingInfo->shippingServiceCost";
      $condition = $item->condition;
      $json['item'][$i]['basicInfo']['conditionDisplayName'] = "$condition->conditionDisplayName";
      //$primaryCategory = $item->primaryCategory;
      //$json['item'][$i]['basicInfo']['categoryName'] = "$primaryCategory->categoryName";
      //$listingInfo = $item->listingInfo;
      //$json['item'][$i]['basicInfo']['listingType'] = "$listingInfo->listingType";
      //$json['item'][$i]['basicInfo']['location'] = "$item->location";
      $sellerInfo = $item->sellerInfo;
      $json['item'][$i]['sellerInfo']['sellerUserName'] = "$sellerInfo->sellerUserName";
      //$json['item'][$i]['basicInfo']['topRatedListing'] = "$item->topRatedListing";
      //$json['item'][$i]['sellerInfo']['feedbackScore'] = "$sellerInfo->feedbackScore";
      //$json['item'][$i]['sellerInfo']['positiveFeedbackPercent'] = "$sellerInfo->positiveFeedbackPercent";
      //$json['item'][$i]['sellerInfo']['feedbackRatingStar'] = "$sellerInfo->feedbackRatingStar";
      // $json['item'][$i]['sellerInfo']['topRatedSeller'] = "$sellerInfo->topRatedSeller";
      // $storeInfo = $item->storeInfo;
      // $json['item'][$i]['sellerInfo']['sellerStoreName'] = "$storeInfo->storeName";
      // $json['item'][$i]['sellerInfo']['sellerStoreURL'] = "$storeInfo->storeURL";
      $shippingInfo = $item->shippingInfo;
      $json['item'][$i]['shippingInfo']['shippingType'] = "$shippingInfo->shippingType";
      // $json['item'][$i]['shippingInfo']['shipToLocations'] = "$shippingInfo->shipToLocations";      
      // $json['item'][$i]['shippingInfo']['expeditedShipping'] = "$shippingInfo->expeditedShipping";
      // $json['item'][$i]['shippingInfo']['oneDayShippingAvailable'] = "$shippingInfo->oneDayShippingAvailable";
      // $json['item'][$i]['shippingInfo']['returnsAccepted'] = "$item->returnsAccepted";
      // $json['item'][$i]['shippingInfo']['handlingTime'] = "$shippingInfo->handlingTime";
       $i++;
    }
  
     //return the JSON
     echo json_encode($json);
     return json_encode($json);
     
    
?>
