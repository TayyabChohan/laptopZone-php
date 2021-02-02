<?php
/*  � 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<?php //require_once('/get-common/keys.php');  //include keys file for auth token and other credentials Test

// require_once('/../get-common/Productionkeys.php');
?>
<?php //require_once('/get-common/eBaySession.php');  //include session file for curl operations 
require_once('/../get-common/eBaySession.php');

?>
<?php
//SiteID must also be set in the Request's XML
//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
//SiteID Indicates the eBay site to associate the call with
$siteID = 0;
//the call being made:
//$verb = 'GetSellerTransactions';
$verb = 'CompleteSale';
$main_query = "select d.token,s.LZ_SELLER_ACCT_ID from 
lz_seller_accts s, lj_merhcant_acc_dt d
where d.acct_id = s.lz_seller_acct_id 
and d.token is not null
and s.lz_seller_acct_id = '$acc_id'
";
$main_query = $this->db->query($main_query)->result_array(); // array of ebay accounts
    $userToken = $main_query[0]['TOKEN'];

$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa';   // these prod keys are different from sandbox keys
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll';
$compatabilityLevel = 911; 


///Build the request Xml string

    $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
    $requestXmlBody .= '<CompleteSaleRequest  xmlns="urn:ebay:apis:eBLBaseComponents">';
    $requestXmlBody .= ' <ItemID>'.$item_id.'</ItemID>';
    $requestXmlBody .= " <Shipment><ShipmentTrackingDetails>";
    $requestXmlBody .= "<ShipmentTrackingNumber>".$tracking_number."</ShipmentTrackingNumber>";
    $requestXmlBody .= '<ShippingCarrierUsed>USPS</ShippingCarrierUsed></ShipmentTrackingDetails>';

    $requestXmlBody .= '<Notes>Shipped USPS Media</Notes></Shipment>
    <Shipped>true</Shipped>
    <TransactionID>'.$transaction_id.'</TransactionID>';
    //$requestXmlBody .= '<OrderIDArray><OrderID>222180494116-1789633947012</OrderID></OrderIDArray>';
    $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
    $requestXmlBody .= '</CompleteSaleRequest>';



    //Create a new eBay session with all details pulled in from included keys.php
    $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

    //send the request and get response
    $responseXml = $session->sendHttpRequest($requestXmlBody);
    if (stristr($responseXml, 'HTTP 404') || $responseXml == '')
        die('<P>Error sending request');

    //Xml string is parsed and creates a DOM Document object
    var_dump($responseXml)
?>