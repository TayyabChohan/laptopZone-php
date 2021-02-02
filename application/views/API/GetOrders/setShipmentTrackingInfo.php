
<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<?php //require_once('/get-common/keys.php');  //include keys file for auth token and other credentials Test

// require_once('/../get-common/Productionkeys.php');
?>
<?php //require_once('/get-common/eBaySession.php');  //include session file for curl operations 
require_once('/../get-common/eBaySession.php');
// require_once('/../get-common/db_connection.php');

?>
<?php
//SiteID must also be set in the Request's XML
//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
//SiteID Indicates the eBay site to associate the call with
$siteID = 0;
//the call being made:
//$verb = 'GetSellerTransactions';
$verb = 'SetShipmentTrackingInfo';

//date_default_timezone_set("America/New_York");
//date_default_timezone_set('CST'); 
//echo date('n/t/Y g:i:s a');  exit;
//echo date('Y-m-d g:i:s')."<br>";  //exit;
$CreateTimeFrom =mktime(00, 00, 00, date("m"), date("d")-1, date("y"));
$CreateTimeFrom = date("Y-m-d H:i:s", $CreateTimeFrom);
//$CreateTimeFromtest = date('Y-m-d')-90;
$CreateTimeTo =mktime(24, 59,59, date("m"), date("d"), date("y"));
$CreateTimeTo = date("Y-m-d H:i:s", $CreateTimeTo);
//$CreateTimeTo = date('Y-m-d H:i:s');
 //var_dump($CreateTimeFromtest);
   //  var_dump($CreateTimeFrom);
   // var_dump($CreateTimeTo);
   // exit;
//Time with respect to GMT
//by default retreive orders in last 30 minutes
//$CreateTimeFrom = gmdate("Y-m-d\TH:i:s",time()-1800); //current time minus 30 minutes
//$CreateTimeTo = gmdate("Y-m-d\TH:i:s");
//$CreateTimeFrom = '2016-08-31T12:01:59';
//$CreateTimeTo = '2016-08-31T07:04:59';
// var_dump($CreateTimeFrom);
 //var_dump($CreateTimeTo);
 //exit;

//If you want to hard code From and To timings, Follow the below format in "GMT".
//$CreateTimeFrom = YYYY-MM-DDTHH:MM:SS; //GMT
//$CreateTimeTo = YYYY-MM-DDTHH:MM:SS; //GMT


///Build the request Xml string

$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';


// $requestXmlBody .="<GetSellerTransactionsRequest xmlns='urn:ebay:apis:eBLBaseComponents'><IncludeCodiceFiscale>TRUE</IncludeCodiceFiscale><IncludeContainingOrder>TRUE</IncludeContainingOrder><IncludeFinalValueFee>TRUE</IncludeFinalValueFee><NumberOfDays>3</NumberOfDays><Pagination><EntriesPerPage>200</EntriesPerPage><PageNumber>1</PageNumber></Pagination>'
//   <DetailLevel>ReturnAll</DetailLevel>";
//   $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";

//    $requestXmlBody .="</GetSellerTransactionsRequest>";

    $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
    $requestXmlBody .= '<SetShipmentTrackingInfoRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
    $requestXmlBody .= '<OrderID>110035505229-23336925001</OrderID>';
    //$requestXmlBody .= '<CreateTimeFrom>2016-09-22T01:00:00.000Z</CreateTimeFrom><CreateTimeTo>2016-09-24T01:00:15.000Z</CreateTimeTo>';
    $requestXmlBody .= "<OrderLineItemID>110035505229-23336925001</OrderLineItemID>";
    //$requestXmlBody .= "<NumberOfDays>1</NumberOfDays>";
    $requestXmlBody .= "<Shipment> 
            <ShippedTime>2008-11-25T12:00:00.000Z</ShippedTime>";
    $requestXmlBody .= '<ShipmentTrackingDetails>
                <ShippingCarrierUsed>UPS</ShippingCarrierUsed>
                <ShipmentTrackingNumber>1Z 999 999 99 9999 999 9</ShipmentTrackingNumber>
            </ShipmentTrackingDetails>';

    $requestXmlBody .= '</Shipment>';
    //$requestXmlBody .= '<OrderIDArray><OrderID>222180494116-1789633947012</OrderID></OrderIDArray>';
    $requestXmlBody .= "</SetShipmentTrackingInfoRequest>";
    // $requestXmlBody .= '</GetOrdersRequest>';

    $userToken = 'AgAAAA**AQAAAA**aAAAAA**W5TIWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**TovLVkaNq2ICV7DWJ/AJInFnLVvQ1zmPriJtUSO2fLeG4rAYFrA+1W4GIjCubxvpo0WFxkpX7IDv62iEN61gs12nr7LKSahCFj3X2IS8jnibLC+IOLBf8XNfIwX04X09kWgz3rq0vXqXwqpCGhXsABbpnM+bCsLQpn6F1L9hHUNirVfap9q9id+FiUEReUZwlhTQf7GiqNNYkrOFLoW1Au+h+j9NslWhADDkICkc85Lz8Hb34ZqLTzqEDoNPbPvLI0aL1XvBcb3QQmE55Lf3gpJrEBqm2cMBnZp23YhDo8kqZC3H22us68xZ+23opdP++KBrOe3/lYqfGoFyT9Xi+zK5m8oV+dSc4PSw7qLULRC5pPDmLDh0LMqyDchmeiVjTY6WrGfLNKh+97BT7NUw3XUJieCXfoydHLMjs2eUh7wPOdqmBtaDjRMseBLja3QSVHm9AEmQroX3sE/B8ZMdC1n+u1YgCY+bA22Vg0DgMD4L5stnLnVdmQGqvOQ+Fwb+E6/xDc8CXpRcINWxE2kDYBtYifHL+9HgnbHt47uFx7p3V9SZMMJYYATqcJUIjFFG7NI6OovhA3MYmwgNqTd9p847JH2ZCIAULnztUJHs8QkLqItnphqw4MnumH35R6n5Zbo8N7ayhoyucD4asLoM9F6+zyHSJkIGWxstZrZU5nndbS9JtcUq4Acwsv9T9C4isfMDO19cioSdAbf5eFj7RxXYRKa4EI+Nuq0Ffl/rTSwbCQ0ZI3rXNabGQHglvRhr';



$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa';
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll'; 
$compatabilityLevel = 949; 

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
    // $response = simplexml_import_dom($responseDoc);

    var_dump($responseDoc);
?>