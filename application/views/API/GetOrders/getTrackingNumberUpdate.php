<?php
//require_once('/../get-common/Productionkeys_dfw.php');
require('/../get-common/eBaySession.php');//include session file for curl operations 
// require('/../get-common/db_connection.php');
//SiteID must also be set in the Request's XML
//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
//SiteID Indicates the eBay site to associate the call with
$siteID = 0;
//the call being made:
$verb = 'GetOrders';
if($acc_id == 1)
{
    $userToken = 'AgAAAA**AQAAAA**aAAAAA**W5TIWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**TovLVkaNq2ICV7DWJ/AJInFnLVvQ1zmPriJtUSO2fLeG4rAYFrA+1W4GIjCubxvpo0WFxkpX7IDv62iEN61gs12nr7LKSahCFj3X2IS8jnibLC+IOLBf8XNfIwX04X09kWgz3rq0vXqXwqpCGhXsABbpnM+bCsLQpn6F1L9hHUNirVfap9q9id+FiUEReUZwlhTQf7GiqNNYkrOFLoW1Au+h+j9NslWhADDkICkc85Lz8Hb34ZqLTzqEDoNPbPvLI0aL1XvBcb3QQmE55Lf3gpJrEBqm2cMBnZp23YhDo8kqZC3H22us68xZ+23opdP++KBrOe3/lYqfGoFyT9Xi+zK5m8oV+dSc4PSw7qLULRC5pPDmLDh0LMqyDchmeiVjTY6WrGfLNKh+97BT7NUw3XUJieCXfoydHLMjs2eUh7wPOdqmBtaDjRMseBLja3QSVHm9AEmQroX3sE/B8ZMdC1n+u1YgCY+bA22Vg0DgMD4L5stnLnVdmQGqvOQ+Fwb+E6/xDc8CXpRcINWxE2kDYBtYifHL+9HgnbHt47uFx7p3V9SZMMJYYATqcJUIjFFG7NI6OovhA3MYmwgNqTd9p847JH2ZCIAULnztUJHs8QkLqItnphqw4MnumH35R6n5Zbo8N7ayhoyucD4asLoM9F6+zyHSJkIGWxstZrZU5nndbS9JtcUq4Acwsv9T9C4isfMDO19cioSdAbf5eFj7RxXYRKa4EI+Nuq0Ffl/rTSwbCQ0ZI3rXNabGQHglvRhr';
}
else if($acc_id == 2)
{
    $userToken = 'AgAAAA**AQAAAA**aAAAAA**Mfr9WA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIGpD5aGqQidj6x9nY+seQ**u0gDAA**AAMAAA**4QITUIgSLf2WCM34ebAwFO33B0o3woFE29IysRK9Mri4hYw56tr5HGkgIyOPBjX6bp7x7wLb93HGiFeeYqPSB1163UbcCB94xGJ6tg5MapK2DWS8Dlz/EIQExi9tsoOvsMiwTyQOA+93pWHJx615ZsNMHWR9FB9mLfdV5OtCpjoaj/7Grv+d89aUyRssdZz+8mA7ir4w2HSA1nmNXzkNgtKhDIQ2bESPjsNoezK1PaTd5wcbAS8B5s0a5s2TSy0tEYng/u/M4zlX6NgR9zFtCitXGeimMGhqdeRuDTtTb015LFSNVZp75R2lH9Kwt3he37ptCrJcfsAPb5H6vb2Na3dV2Lmeb4nmBGgrJvxPBah+CA+VtA5KxEsSsdzp9GATyUkW7aneuZ6jHXqNAvx+WDTiMWS0wOE2p72dno/bH+Q1ntjNTIbez3SxKNNjkPvzD/Kg9sOvDfzSVwVBH5MHBo4JhQLR3yP9gkfpXUCV+VG9wqrUz9QrzdKmtGFKkgIgRjmEg+UzBlkf8FXvgsuDxNXDTS+LIWnxuzIeTMxACENm37PYJYSF6zjR/RXy8YpvWwgobNiswN9FbKXseGfPW/VrdGd1ktnwADnzvdCheuYDMhA9voa5VlnOtqQfRAUsci0TmMvX+k13h4sS42+wGtXXEeaoCZcIa6vxXeq9FrY7dBpNACUHXaiKC1QVA7wFXeAeTaSE1oe+Zrw/Mv3TmDf8+/b4ZaeWY8K1eaVZixMSEL9tRvbNhQsi68A/+itW';
}
$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa';   // these prod keys are different from sandbox keys
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$compatabilityLevel = 949; 
//set the Server to use (Sandbox or Production)
$serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
///Build the request Xml string



$pageNum = 1;
if(!empty($order_array ))
{
    do{
      $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
      $requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
      $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
      $requestXmlBody .= "<IncludeFinalValueFee>true</IncludeFinalValueFee>";
      $requestXmlBody .= '<Pagination><EntriesPerPage>100</EntriesPerPage><PageNumber>'.$pageNum.'</PageNumber></Pagination>';

      

      
      $requestXmlBody .= '<OrderIDArray>';
      foreach ($order_array as $order) {
        $id = "<OrderID>".$order."</OrderID>";
          $requestXmlBody .=$id;
      }

      $requestXmlBody .= '</OrderIDArray>';
      $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
      $requestXmlBody .= '</GetOrdersRequest>';

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
        //  print_r($responseXml);
         $orders = $response->OrderArray->Order;
         $array_orderUpdate_return = array();
         $i =0;
         foreach ($orders as $order) {
          $trackingNumber = $order->TransactionArray->Transaction->ShippingDetails->ShipmentTrackingDetails->ShipmentTrackingNumber;
          $orderStatus = $order->OrderStatus;
         
          $array_orderUpdate_return[$i]["TRACKINGNUMBER"] = $trackingNumber;
          $array_orderUpdate_return[$i]["ORDER_STATUS"] = $orderStatus;
          $array_orderUpdate_return[$i]["SALENO"] = $order->ShippingDetails->SellingManagerSalesRecordNumber;
          $i = $i+1;
         }
         echo json_encode(array("TRACKINGNUMBER_UPDATE" => $array_orderUpdate_return));     
    }
    $pageNum += 1;
  }while($response->HasMoreOrders==true && $pageNum <= $response->PaginationResult->TotalNumberOfPages); 

}








