<?php
//require_once('/../get-common/Productionkeys_dfw.php');
require('/../get-common/eBaySession.php');//include session file for curl operations 

//SiteID must also be set in the Request's XML
//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
//SiteID Indicates the eBay site to associate the call with
$siteID = 0;
//the call being made:
$verb = 'GetOrders';
///Build the request Xml string

$query = "SELECT E.USER_ID,E.DEV_ID,E.APP_ID,E.CERT_ID,E.AOUTH_TOKEN,E.LZ_SELLER_ACCOUNT_ID  FROM LZ_EBAY_DEV_CREDENTIALS_DT E WHERE E.USER_ID = '$user_id' ORDER BY E.LZ_SELLER_ACCOUNT_ID ASC"; 
//$result = oci_parse($conn,$query);
// $stid = oci_parse($conn, $query);
// $rsl = oci_execute($stid, OCI_DEFAULT);

$query = $this->db->query($query)->result_array(); 

//while (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false) {
  foreach ($query as $row) {
    /*================================
    =            api keys            =
    ================================*/
      $production         = true;   // toggle to true if going against production
      //$compatabilityLevel = 825;    // eBay API version
      $compatabilityLevel = 949;    // eBay API version
      $devID = $row['DEV_ID'];  
      $appID = $row['APP_ID'];
      $certID = $row['CERT_ID'];
      $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
      //the token representing the eBay user to assign the call with
      $userToken = $row['AOUTH_TOKEN']; 
    /*=====  End of api keys  ======*/
    $LZ_SELLER_ACCT_ID= $row['LZ_SELLER_ACCOUNT_ID'];
    /*=========================================
    =            ge order api call            =
    =========================================*/
    $pageNum = 1;
    do{
      $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
      $requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
      $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
      $requestXmlBody .= "<IncludeFinalValueFee>true</IncludeFinalValueFee>";
      $requestXmlBody .= '<Pagination><EntriesPerPage>100</EntriesPerPage><PageNumber>'.$pageNum.'</PageNumber></Pagination>';

      

      $query = $this->db->query("SELECT ORDERLINEITEMID ORDER_ID FROM LZ_AWAITING_SHIPMENT WHERE LZ_SELLER_ACCOUNT_ID = $LZ_SELLER_ACCT_ID  ORDER BY SALERECORDID ASC")->result_array(); 
      $requestXmlBody .= '<OrderIDArray>';
      foreach ($query as $row) {
        $id = "<OrderID>".$row['ORDER_ID']."</OrderID>";
          $requestXmlBody .=$id;
      }

      $requestXmlBody .= '</OrderIDArray>';
      $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
      $requestXmlBody .= '</GetOrdersRequest>';

      //Create a new eBay session with all details pulled in from included keys.php
      $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

      //send the request and get response
      $responseXml = $session->sendHttpRequest($requestXmlBody);
      if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
          die('<P>Error sending request');
      //Xml string is parsed and creates a DOM Document object
      $responseDoc = new DomDocument();
      $responseDoc->loadXML($responseXml);
      //get any error nodes
      $errors = $responseDoc->getElementsByTagName('Errors');
      $response = simplexml_import_dom($responseDoc);
      $entries = $response->PaginationResult->TotalNumberOfEntries;
        // echo "<pre>";
        //  print_r($response);
        // echo "</pre>";
        // exit;
      //if there are error nodes
      if ($errors->length > 0) {
          echo '<P><B>eBay returned the following error(s):</B>';
          //display each error
          //Get error code, ShortMesaage and LongMessage
          $code = $errors->item(0)->getElementsByTagName('ErrorCode');
          $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
          $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
          
          //Display code and shortmessage
          echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
          
          //if there is a long message (ie ErrorLevel=1), display it
          if (count($longMsg) > 0)
              echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));
      }else{ //If there are no errors, continue
          if(isset($_GET['debug'])){  
             header("Content-type: text/xml");
             print_r($responseXml);
          }else{  //$responseXml is parsed in view.php
              //include 'insertAwaitingShipment.php';
              include 'updateOrderStatus.php';
              // $sales_post = "call pro_lz_auto_sales_data_post()";
              // $post_sale_data =oci_parse($conn, $sales_post);
              // oci_execute($post_sale_data,OCI_DEFAULT);            
          }
      }
      $pageNum += 1;
    }while($response->HasMoreOrders==true && $pageNum <= $response->PaginationResult->TotalNumberOfPages); 
    /*=====  End of ge order api call  ======*/
    
  }//forech close foreach ($row as $item) line no 20
//}//while close (($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) != false)
//oci_close($conn);










?>