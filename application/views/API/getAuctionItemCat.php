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
//var_dump($data);exit;
foreach ($data as $val ) {
  $bby_upc = $val['BBY_UPC'];
  $bby_mpn = $val['BBY_MPN'];
  $upc = $val['UPC'];
  $mpn = $val['MPN'];
  $sku = $val['SKU'];
  $det_id = $val['LZ_AUCTION_DET_ID'];

      if(!empty($bby_upc)){
          $key = $bby_upc;
          $bby_key = true;
        }elseif(!empty($bby_mpn)){
          $key = $bby_mpn;
          $bby_key = true;
        }else{
          if(!empty(trim($val['UPC']))){
              $key = trim($val['UPC']);
            }else{
              $key = trim($val['MPN']);
            }
        }
    $KeyWord = $key;//.'+-LOT+-EMPTY';
    //var_dump($KeyWord);
    
    $KeyWord = test_input(trim($KeyWord));
    /*================================================
    =            get category id from api            =
    ================================================*/
    $cat_flag = false;//dont run cat api
    if($cat_flag === false){
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
    //$category = $categoryID;
    
    /*=====  End of get category id from api  ======*/
    
    $this->db2->query("UPDATE LZ_AUCTION_DET SET CATEGORY_ID = '$categoryID' WHERE LZ_AUCTION_DET_ID = $det_id");
    /*=====  End of loop on every posible condition in given category  ======*/
     echo "Category Updated against Auction Det Id:".$det_id.PHP_EOL;
     //$j++;
  //}// end if LINE_PROCESSED = 0 
}//end foreach
?>
