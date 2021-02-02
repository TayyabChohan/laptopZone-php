<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<?php //require_once('/get-common/keys.php');  //include keys file for auth token and other credentials 

require_once('/../get-common/Productionkeys.php');
?>
<?php //require_once('/get-common/eBaySession.php');  //include session file for curl operations 
require_once('/../get-common/eBaySession.php');
require_once('/../get-common/db_connection.php');

?>
<?php
//SiteID must also be set in the Request's XML
//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
//SiteID Indicates the eBay site to associate the call with
$siteID = 0;
//the call being made:
//$verb = 'GetSellerTransactions';
$verb = 'GetOrders';

//date_default_timezone_set("America/New_York");
//date_default_timezone_set('CST'); 
//echo date('n/t/Y g:i:s a');  exit;
//echo date('Y-m-d g:i:s')."<br>";  //exit;
// $CreateTimeFrom =mktime(00, 01, 0, date("m"), date("d")-1, date("y"));
// $CreateTimeFrom = date("Y-m-d H:i:s", $CreateTimeFrom);
//$CreateTimeFromtest = date('Y-m-d')-90;
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
$pageNum = 1;
do{
    $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
    $requestXmlBody .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
    $requestXmlBody .= '<DetailLevel>ReturnAll</DetailLevel>';
    //$requestXmlBody .= '<CreateTimeFrom>2016-09-22T01:00:00.000Z</CreateTimeFrom><CreateTimeTo>2016-09-24T01:00:15.000Z</CreateTimeTo>';
    //$requestXmlBody .= "<CreateTimeFrom>$CreateTimeFrom</CreateTimeFrom><CreateTimeTo>$CreateTimeTo</CreateTimeTo>";
   // $requestXmlBody .= "<NumberOfDays>0</NumberOfDays>";
    $requestXmlBody .= "<IncludeFinalValueFee>true</IncludeFinalValueFee>";
    $requestXmlBody .= '<OrderRole>Seller</OrderRole><OrderStatus>All</OrderStatus>';

    $requestXmlBody .= '<Pagination>
    <EntriesPerPage>100</EntriesPerPage>
    <PageNumber>'.$pageNum.'</PageNumber>
    </Pagination>';

	$con =  oci_connect('laptop_zone', 's', 'wizmen-pc/WIZDB') or die ('Error connecting to oracle');
$LZ_SELLER_ACCT_ID= $this->session->userdata('account_type');

           $query = $this->db->query("select d.sales_record_number, d.order_id from LZ_SALESLOAD_MT m, LZ_SALESLOAD_det d where m.lz_saleload_id = d.lz_saleload_id and (d.orderstatus <> 'Cancelled' or d.orderstatus is null)   and d.tracking_number is null and m.lz_seller_acct_id = $LZ_SELLER_ACCT_ID order by d.sales_record_number desc");
           $i=1;
    $requestXmlBody .= '<OrderIDArray>';
    do{
    	$ORDER_ID = $query->row($i)->ORDER_ID;
    	$i++;
    	$id = "<OrderID>".$ORDER_ID."</OrderID>";
    $requestXmlBody .=$id;	
    }while($query->num_rows() >= $i);
    $requestXmlBody .= '</OrderIDArray>';
    //        if($query->num_rows() > 0){
    // $ORDER_ID = $query->row()->ORDER_ID;
    // var_dump($query->num_rows());

    //print_r($requestXmlBody);
//}
//exit;

    //$requestXmlBody .= '<OrderIDArray>$id</OrderIDArray>';
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
     
         //   echo "<pre>";
         // print_r($response);
         //    //var_dump($response);
         //  echo "</pre>";
         //  exit;

           

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
    }else { //If there are no errors, continue
        if(isset($_GET['debug']))
        {  
           header("Content-type: text/xml");
           print_r($responseXml);
        }else
         {  //$responseXml is parsed in view.php
            include_once 'view_test.php';
        }
    }
          $pageNum += 1;
}while($response->HasMoreOrders==true && $pageNum <= $response->PaginationResult->TotalNumberOfPages);  
?>