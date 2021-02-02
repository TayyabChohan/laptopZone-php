<?php
	
	$keywords='Apple+MC914LL/B'; // 885909611348
	$categoryId='80053';

	$URL ="http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findCompletedItems&SERVICE-NAME=FindingService&SERVICE-VERSION=1.13.0&GLOBAL-ID=EBAY-US&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&RESPONSE-DATA-FORMAT=XML&keywords=$keywords&categoryId=$categoryId&itemFilter(0).name=SoldItemsOnly&itemFilter(0).value=true&itemFilter(1).name=Condition&itemFilter(1).value=3000&itemFilter(2).name=ListingType&itemFilter(2).value(0)=FixedPrice&sortOrder=PricePlusShippingLowest&paginationInput.entriesPerPage=1";

    $XML = new SimpleXMLElement(file_get_contents($URL));
    $count = $XML->paginationOutput->totalEntries;
    //echo $count;
   

	if ($XML->Ack !== 'Failure' && $count > 0) {
		$price= $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
		echo $price;
	}else{
	    $price='';
	    echo 'not found';
	}
	 echo "<pre>";
  		print_r($XML);
    echo "</pre>";exit;
?>