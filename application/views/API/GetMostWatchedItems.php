<?php
  // Turn on all errors, warnings and notices for easier PHP debugging
  error_reporting(E_ALL);
  // Define global variables
  $trans = array("′" => "''","’" => "''","'" => "''","＇" => "''");//use in strtr function 
  $m_endpoint = 'http://svcs.ebay.com/MerchandisingService?';  // Merchandising URL to call
  //$appid = 'SajidKha-eRashanp-PRD-42f839365-d3726265';  // You will need to supply your own AppID
  $appid = 'FaisalRi-ecologix-PRD-b668815a4-f3c62444';  // You will need to supply your own AppID
  $responseEncoding = 'XML';  // Type of response we want back
    // Construct getMostWatchedItems call with maxResults and categoryId as input
  //var_dump($data)  ;exit;
foreach ($data as $value) {
  # code...

    $categoryId = $value['CATEGORY_ID'];

    $apicalla  = "$m_endpoint";
    $apicalla .= "OPERATION-NAME=getMostWatchedItems";
    $apicalla .= "&SERVICE-VERSION=1.4.0";
    $apicalla .= "&CONSUMER-ID=$appid";
    $apicalla .= "&RESPONSE-DATA-FORMAT=$responseEncoding";
    $apicalla .= "&REST-PAYLOAD";
    $apicalla .= "&maxResults=50";
    $apicalla .= "&categoryId=$categoryId"; 

    
    // Load the call and capture the document returned by eBay API
    $resp = simplexml_load_file($apicalla);
    // echo "<pre>";
    // print_r($resp);
    // echo "</pre>";
    // exit;
    // Check to see if the response was loaded, else print an error
    if ($resp) {
        // Set return value for the function to null
        $retna = '';

      // Verify whether call was successful
      if ($resp->ack == "Success") {
        foreach($resp->itemRecommendations->item as $item) {
          if ($item->currentPrice) {
            $buyItNowPrice = $item->currentPrice;
          } else {
            $buyItNowPrice = $item->buyItNowPrice;
          }
          //$total_cost = (float)$price + (float)$ship_cost;
          $country = $item->country;
          $globalId = $item->globalId;
          $imageURL = $item->imageURL;
          $itemId = $item->itemId;
          $primaryCategoryId = $item->primaryCategoryId;
          $primaryCategoryName = $item->primaryCategoryName;
          $primaryCategoryName = strtr($primaryCategoryName, $trans);
          $shippingCost = $item->shippingCost;
          $shippingType = $item->shippingType;
          $subtitle = $item->subtitle;
          $subtitle = strtr($subtitle, $trans);
          $timeLeft = $item->timeLeft;
          $title = $item->title;
          $title = strtr($title, $trans);
          $viewItemURL = $item->viewItemURL;
          $watchCount = $item->watchCount;
          $watch_qry = $this->db2->query("SELECT * FROM LZ_BD_MOST_WATCHED_ITEMS WHERE EBAYID = $itemId");
          if($watch_qry->num_rows() == 0 ){
          //   $watch_qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MOST_WATCHED_ITEMS','WATCH_ID') WATCH_ID FROM DUAL");
          // $get_pk = $watch_qry->result_array();
          // $watch_id = $get_pk[0]['WATCH_ID'];
          /*============================================
          =            insert data in table            =
          ============================================*/
          $this->db2->query("INSERT INTO LZ_BD_MOST_WATCHED_ITEMS (WATCH_ID, BUYITNOWPRICE, COUNTRY, GLOBALID, IMAGEURL, EBAYID, PRIMARYCATEGORYID, PRIMARYCATEGORYNAME, SHIPPINGCOST, SHIPPINGTYPE, SUBTITLE, TIMELEFT, TITLE, VIEWITEMURL, WATCHCOUNT, INSERTEDDATE, EPID,CATEGORY_ID) VALUES (SEQ_WATCH_ID.NEXTVAL,'$buyItNowPrice','$country','$globalId','$imageURL',$itemId,$primaryCategoryId,'$primaryCategoryName',$shippingCost,'$shippingType','$subtitle','$timeLeft','$title','$viewItemURL',$watchCount,sysdate,NULL,$categoryId)");
          /*=====  End of insert data in table  ======*/
          }else{
            echo $itemId.PHP_EOL;
          }

          
          

        }// end foreach
      }// end if $resp->ack
    }// end if resp

}//end data foreach

  // Make returned eBay times pretty
  function getPrettyTimeFromEbayTime($eBayTimeString){
    // Input is of form 'PT12M25S'
    $matchAry = array(); // null out array which will be filled
    $pattern = "#P([0-9]{0,3}D)?T([0-9]?[0-9]H)?([0-9]?[0-9]M)?([0-9]?[0-9]S)#msiU";
    preg_match($pattern, $eBayTimeString, $matchAry);
    
    $days  = (int) $matchAry[1];
    $hours = (int) $matchAry[2];
    $min   = (int) $matchAry[3];  // $matchAry[3] is of form 55M - cast to int 
    $sec   = (int) $matchAry[4];
    
    $retnStr = '';
    if ($days)  { $retnStr .= " $days day"   . pluralS($days);  }
    if ($hours) { $retnStr .= " $hours hour" . pluralS($hours); }
    if ($min)   { $retnStr .= " $min minute" . pluralS($min);   }
    if ($sec)   { $retnStr .= " $sec second" . pluralS($sec);   }
    
    return $retnStr;
  } // function

  function pluralS($intIn) {
    // if $intIn > 1 return an 's', else return null string
    if ($intIn > 1) {
      return 's';
    } else {
      return '';
    }
  } // function

?>