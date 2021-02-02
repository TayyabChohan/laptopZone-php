<?php

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../configuration.php';
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;




// $pageNum = 4; //16

//do {
   //  $service = new Services\TradingService([
   //  'credentials' => $config['production']['credentials'],
   //  'siteId'      => Constants\SiteIds::US
   //  ]);
   //  $request = new Types\GetMyeBaySellingRequestType();
   //  $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
   //  $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
   // // $request->DetailLevel = 'ReturnAll';
   //  $request->ActiveList = new Types\ItemListCustomizationType();
   //  $request->ActiveList->Include = true;
   //  $request->ActiveList->Pagination = new Types\PaginationType();
   //  $request->ActiveList->Pagination->EntriesPerPage = 200;
   //  $request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
   //  $request->ActiveList->Pagination->PageNumber = $pageNum;
   //  $response = $service->getMyeBaySelling($request);
   //   //       echo "<pre>";
   //   // print_r($response);
        
   //   //  echo "</pre>";
   //   //   exit;
   //  if (isset($response->Errors)) {
   //      foreach ($response->Errors as $error) {
   //          printf(
   //              "%s: %s\n%s\n\n",
   //              $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
   //              $error->ShortMessage,
   //              $error->LongMessage
   //          );
   //      }
   //  }
    // if ($response->Ack !== 'Failure' && isset($response->ActiveList)) {
    //     $i=1;
    //     foreach ($response->ActiveList->ItemArray->Item as $item) 
    //     {
            
            require('includes/configSeed.php');
            require('includes/db_connection.php');
            $select_qry="SELECT TE.EBAY_ID FROM TEMP_EBAY_ID TE WHERE TE.EBAY_ID NOT IN (select E.EBAY_ID from TEMP_EBAY_ID E , LZ_ACTIVE_LISTING_TEMP  A WHERE A.EBAY_ID = E.EBAY_ID)"; 
            $rslt = oci_parse($conn, $select_qry);

            oci_execute($rslt);

            //$ebay_id = oci_fetch_all($rslt, OCI_ASSOC);
            //var_dump($rslt);exit;
//foreach($ebay_id['EBAY_ID'] as $ItemId):
while (($ebay_id = oci_fetch_array($rslt, OCI_ASSOC)) != false) {
            $ItemId = $ebay_id['EBAY_ID'];
            $site_id = 0;
            $call_name = 'GetItem';
            $headers = array 
            (
                'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
                'X-EBAY-API-DEV-NAME: ' . $dev_id,
                'X-EBAY-API-APP-NAME: ' . $app_id,
                'X-EBAY-API-CERT-NAME: ' . $cert_id,
                'X-EBAY-API-CALL-NAME: ' . $call_name,          
                'X-EBAY-API-SITEID: ' . $site_id,
            );
            $xml_request = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
                               <".$call_name."Request xmlns=\"urn:ebay:apis:eBLBaseComponents\">
                                   <RequesterCredentials>
                                       <eBayAuthToken>" . $auth_token . "</eBayAuthToken>
                                   </RequesterCredentials>
                                   <DetailLevel>ReturnAll</DetailLevel>
                                   <IncludeItemSpecifics>true</IncludeItemSpecifics>
                                   <IncludeWatchCount>true</IncludeWatchCount>
                                   <ItemID>".$ItemId."</ItemID>
                               </".$call_name."Request>";
                // Send request to eBay and load response in $response
                $connection = curl_init();
                curl_setopt($connection, CURLOPT_URL, $api_endpoint);
                curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($connection, CURLOPT_POST, 1);
                curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
                curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($connection);
                curl_close($connection);
                // Create DOM object and load eBay response
                $dom = new DOMDocument();
                 $dom->loadXML($response);

                // Parse data accordingly.
                $ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';
                // $eBay_official_time = $dom->getElementsByTagName('Timestamp')->length > 0 ? $dom->getElementsByTagName('Timestamp')->item(0)->nodeValue : '';
                $item_id = $dom->getElementsByTagName('ItemID')->length > 0 ? $dom->getElementsByTagName('ItemID')->item(0)->nodeValue : '';
                $title = $dom->getElementsByTagName('Title')->length > 0 ? $dom->getElementsByTagName('Title')->item(0)->nodeValue : '';
                //$title = addslashes($title);
                $title = trim(str_replace("  ", '', $title));
                $title = trim(str_replace(array("'", '"'), "''", $title));

                $ConditionID = $dom->getElementsByTagName('ConditionID')->length > 0 ? $dom->getElementsByTagName('ConditionID')->item(0)->nodeValue : '';

              // $select_qry="SELECT EBAY_ID FROM LZ_ACTIVE_LISTING_TEMP WHERE EBAY_ID=".$item_id;
              // $rslt = oci_parse($conn, $select_qry);

              // oci_execute($rslt);

              // $r = oci_fetch_array($rslt, OCI_ASSOC+OCI_RETURN_NULLS);


              $comma = ',';
              //if(empty($r['EBAY_ID'])){
              $insert_qry = "INSERT INTO LZ_ACTIVE_LISTING_TEMP VALUES ($item_id $comma $ConditionID $comma '$title' $comma 'DFW')";

                  $data = oci_parse($conn, $insert_qry);
                  $check =oci_execute($data,OCI_DEFAULT);
                  if($check){
                      echo $i."-"."item inserted: ".$ItemId."<br>";
                      oci_commit($conn);
                  }else{
                          echo $i."-"."item Not inserted: ".$ItemId."<br>";

                          oci_commit($conn);
                  }
                // }else{
                //   echo "already inserted";
                // }
//endforeach;
  }//end while
               //   exit;
    //               $i++;
    //     } //end nested foreach
    // }//end if
// exit;
//     $pageNum += 1;

// }while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
?>