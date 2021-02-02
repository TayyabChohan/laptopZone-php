<?php
	require('get-common/Productionkeys.php'); 
    require('get-common/eBaySession.php');
	$siteID = 0;
	//the call being made:
	$query='085392246724';
	$verb = 'findCompletedItems';

$requestXmlBody .= '<?xml version="1.0" encoding="UTF-8"?>
<findCompletedItemsRequest xmlns="http://www.ebay.com/marketplace/search/v1/services">
   <keywords>Garmin nuvi 1300 Automotive GPS Receiver</keywords>
   <categoryId>156955</categoryId>
   <itemFilter>
      <name>Condition</name>
      <value>3000</value>
   </itemFilter>
   <itemFilter>
      <name>FreeShippingOnly</name>
      <value>true</value>
   </itemFilter>
   <itemFilter>
      <name>SoldItemsOnly</name>
      <value>true</value>
   </itemFilter>
   <sortOrder>PricePlusShippingLowest</sortOrder>
   <paginationInput>
      <entriesPerPage>2</entriesPerPage>
      <pageNumber>1</pageNumber>
   </paginationInput>
</findCompletedItemsRequest>';

	///Build the request Xml string
	// $requestXmlBody = '<?xml version="1.0" encoding="UTF-8"';
	// $requestXmlBody .= '<findCompletedItemsRequest xmlns="http://www.ebay.com/marketplace/search/v1/services">';
	// $requestXmlBody .= "<keywords>$query</keywords>";
	// $requestXmlBody .= '<categoryId>617</categoryId>';
	// $requestXmlBody .='<itemFilter><name>ListingType</name><value>FixedPrice</value></itemFilter><itemFilter><name>Condition</name><value>6000</value></itemFilter><itemFilter>
 //      <name>SoldItemsOnly</name>
 //      <value>true</value>
 //   </itemFilter>';
	// $requestXmlBody .='<sortOrder>PricePlusShippingLowest</sortOrder>';
	// $requestXmlBody .='<paginationInput>
 //      <entriesPerPage>2</entriesPerPage>
 //      <pageNumber>1</pageNumber>
 //   </paginationInput>';
	// $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
	
 $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=Garmin+nuvi+1300+Automotive+GPS+Receiver&categoryId=156955&itemFilter(0).name=Condition&itemFilter(0).value=3000&itemFilter(1).name=FreeShippingOnly&itemFilter(1).value=true&itemFilter(2).name=SoldItemsOnly&itemFilter(2).value=true&sortOrder=PricePlusShippingLowest&paginationInput.entriesPerPage=2";
 // $URL = $URL.$query."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber."&sortOrder=".$sortOrder.$MinQuantity.$HideDuplicateItems.$condition.$buyingFormat.$FreeShippingOnly.$categoryId.$SellerInfo.$PictureURLSuperSize.$StoreInfo;

                    $XML = new SimpleXMLElement(file_get_contents($URL));
                    $count = $XML->paginationOutput->totalEntries;
                     echo $count;
                       echo "<pre>";
              print_r($XML);
             //    //var_dump($response);
               echo "</pre>";exit;



	// $requestXmlBody .= '</findCompletedItemsRequest>';
	//Create a new eBay session with all details pulled in from included keys.php
	$session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
	//send the request and get response
	$responseXml = $session->sendHttpRequest($requestXmlBody);
	$responseDoc = new DomDocument();
	$responseDoc->loadXML($responseXml);
	$response = simplexml_import_dom($responseDoc);
	// var_dump($response);exit;
	if ($response->Ack !== 'Failure' && $response->CategoryCount > 0) {
	    $cat = $response->SuggestedCategoryArray->SuggestedCategory->Category;
	    $categoryParentName1 = $cat->CategoryParentName[0];
	    $categoryParentName2 = $cat->CategoryParentName[1];
	    $categoryName = $cat->CategoryName;
	    $categoryID = $cat->CategoryID;
	}else{
	    $categoryParentName1 = NULL;
	    $categoryParentName2 = NULL;
	    $categoryName = NULL;
	    $categoryID = NULL;
	}
?>