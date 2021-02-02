<?php
/*  © 2013 eBay Inc., All Rights Reserved */ 
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */
?>
<?php //require_once('/get-common/keys.php');  //include keys file for auth token and other credentials Test

//require_once('Productionkeys.php');
?>
<?php 
/*=============================================
=            getordder call            =
=============================================*/
require('eBaySessionn.php');
//require_once('db_connection.php');
//var_dump($Timestamp);//exit;
$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'from getorder',sysdate)");
//exit;
?>
<?php
$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa'; // dev account info
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
$compatabilityLevel = 949;    // eBay API version
$MANNUAL_YN = 1000;
/*=================================
=            Get token            =
=================================*/

//$q ="select d.token from lj_merhcant_acc_dt d where upper(d.account_name) = UPPER('$merchant_name') and rownum= 1 ";
$row =$this->db->query("SELECT S.LZ_SELLER_ACCT_ID , D.TOKEN FROM LZ_SELLER_ACCTS S , LJ_MERHCANT_ACC_DT D WHERE UPPER(TRIM(S.SELL_ACCT_DESC))  = UPPER(TRIM(D.ACCOUNT_NAME)) AND UPPER(TRIM(S.SELL_ACCT_DESC))  = UPPER('$merchant_name') AND ROWNUM =1")->result_array(); 


// $userToken = $row[0]['TOKEN'];    
// $LZ_SELLER_ACCT_ID = $row[0]['LZ_SELLER_ACCT_ID'];

if(count($row) > 0){
    $userToken = $row[0]['TOKEN'];    
    $LZ_SELLER_ACCT_ID = $row[0]['LZ_SELLER_ACCT_ID']; 
}else{
    $qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'Token Not Found',sysdate)");
    // $cmd =oci_parse($conn, $qry);
    // oci_execute($cmd,OCI_DEFAULT);
    // oci_commit($conn);
    die('Token Not Found');
}

/*=====  End of Get token  ======*/


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

$CreateTimeTo = $Timestamp;// this variable comming from listener.php
$currentDate = strtotime($CreateTimeTo);
$futureDate = $currentDate-(60*1000);
$CreateTimeFrom = date("Y-m-d H:i:s", $futureDate);

$qry = $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'$CreateTimeFrom | $CreateTimeTo',sysdate)");
// var_dump($CreateTimeFrom);
//    var_dump($CreateTimeTo);
//    exit;

// $CreateTimeFrom =mktime(00, 00, 00, date("m"), date("d")-1, date("y"));
// $CreateTimeFrom = date("Y-m-d H:i:s", $CreateTimeFrom);//2019-04-16 00:00:00
//$CreateTimeFromtest = date('Y-m-d')-90;
// $CreateTimeTo =mktime(24, 59,59, date("m"), date("d"), date("y"));
// $CreateTimeTo = date("Y-m-d H:i:s", $CreateTimeTo);
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

//$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ;


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
    $requestXmlBody .= "<CreateTimeFrom>$CreateTimeFrom</CreateTimeFrom><CreateTimeTo>$CreateTimeTo</CreateTimeTo>";
    //$requestXmlBody .= "<NumberOfDays>1</NumberOfDays>";
    $requestXmlBody .= "<IncludeFinalValueFee>true</IncludeFinalValueFee>";
    $requestXmlBody .= '<OrderRole>Seller</OrderRole><OrderStatus>All</OrderStatus>';

    $requestXmlBody .= '<Pagination>
    <EntriesPerPage>100</EntriesPerPage>
    <PageNumber>'.$pageNum.'</PageNumber>
    </Pagination>';
    //$requestXmlBody .= '<OrderIDArray><OrderID>222180494116-1789633947012</OrderID></OrderIDArray>';
    $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
    $requestXmlBody .= '</GetOrdersRequest>';



    //Create a new eBay session with all details pulled in from included keys.php
    $session = new eBaySessionn($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);

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
    $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'TotalNumberOfEntries: $entries',sysdate)");
     
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
             $this->db->query("insert into EBAY_NOTEIFICATION (test_pk,E_data,insert_date) values (get_single_primary_key('EBAY_NOTEIFICATION','test_pk'),'file include',sysdate)");
            include 'view_test_NEW.php';
            
        }
    }
          $pageNum += 1;
}while($response->HasMoreOrders==true && $pageNum <= $response->PaginationResult->TotalNumberOfPages);  


/*=====  End of getordder call  ======*/
?>