
<?php require_once('get-common/Productionkeys.php') ?>
<?php require_once('get-common/eBaySession.php') ?>

<?php
		//Get the query inputted
		//$query = $key;
		//SiteID must also be set in the Request's XML
		//SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
		//SiteID Indicates the eBay site to associate the call with
		$siteID = 0;
		//the call being made:
		$verb = 'getcategories';
		
		///Build the request Xml string
		$requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
		$requestXmlBody .= '<GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		//$requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
		$requestXmlBody .= "<CategoryParent>'20081' </CategoryParent>";
		$requestXmlBody .= "<ViewAllNodes> true </ViewAllNodes>";
		$requestXmlBody .= '<DetailLevel> "ReturnAll" </DetailLevel>';
		$requestXmlBody .= '</GetCategoriesRequest>';
		
        
        //Create a new eBay session with all details pulled in from included keys.php
        $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
		
		//send the request and get response
		$responseXml = $session->sendHttpRequest($requestXmlBody);

		$xml = simplexml_load_string($responseXml);
		echo json_encode($xml);
		return json_encode($xml);
 ?>
