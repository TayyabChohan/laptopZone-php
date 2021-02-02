
<?php
function test_input($data) {
	  $data = trim($data);
	  $data = preg_replace('/\s+/', '', $data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>

<?php
		
		//$return = $_GET;
		//$KeyWord = test_input($return["keyword"]); //  need to validate the keyword first!!! test_input($_GET["KeyWord"]);
		$KeyWord = test_input($upc);
		// $sortOrder = $return["SortSelection"];
		// $NumPerPage = $return["ResultsNum"];
		// $condition = "";
		// $index = 0;
		// if(!empty($return["condition"])){
		// 	$count = 0;
		// 	$condition = "&itemFilter(0).name=Condition";
		// 	foreach($return["condition"] as $selected) {
		// 		$condition.="&itemFilter(0).value($count)=3000";
		// 		$count++;
		// 	}
		// 	$index++;
		// }		
		// $minPrice = "";
		// if(!empty($return["priceLow"])){
		// 	$minPrice = "&itemFilter($index).name=MinPrice&itemFilter($index).value(0)={$return["priceLow"]}";
		// 	$index++;
		// }
		// $maxPrice = "";
		// if(!empty($return["priceHigh"])){
		// 	$maxPrice = "&itemFilter($index).name=MaxPrice&itemFilter($index).value(0)={$return["priceHigh"]}";
		// 	$index++;
		// }
		// $buyingFormat = "";
		// if(!empty($return["BuyFormat"])){
		// 	$buyingFormat = "&itemFilter($index).name=ListingType";
		// 	$count = 0;
		// 	foreach($return["BuyFormat"] as $selected) {
		// 		$buyingFormat.="&itemFilter($index).value($count)=$selected";
		// 		$count++;
		// 	}
		// 	$index++;
		// }
		// $seller = "&itemFilter($index).name=ReturnsAcceptedOnly";
		// if(!empty($return["seller"])){
		// 	$seller.="&itemFilter($index).value(0)=true";
		// }
		// else{
		// 	$seller.="&itemFilter($index).value(0)=false";
		// }
		// $index++;
		// $FreeShippingOnly = "&itemFilter($index).name=FreeShippingOnly";
		// if(!empty($return["FreeShippingOnly"])){
		// 	$FreeShippingOnly.="&itemFilter($index).value(0)=true";
		// }
		// else{
		// 	$FreeShippingOnly.="&itemFilter($index).value(0)=false";
		// }
		// $index++;
		// $ExpeditedShippingType = "";
		// if(!empty($return["ExpeditedShippingType"])){
		// 	$ExpeditedShippingType="&itemFilter($index).name=ExpeditedShippingType&itemFilter($index).value(0)=Expedited";
		// 	$index++;
		// }
		// $MaxHandlingTime = "";
		// if(!empty($return["MaxHandlingTime"])){
		// 	$MaxHandlingTime = "&itemFilter($index).name=MaxHandlingTime&itemFilter($index).value(0)={$return["MaxHandlingTime"]}";
		// 	$index++;
		// }
		$NumPerPage = 15;

		$sortOrder = "&sortOrder=PricePlusShippingLowest";
		$condition = "&itemFilter(0).name=Condition";
		$condition.="&itemFilter(0).value(0)=3000";
		$buyingFormat = "&itemFilter(1).name=ListingType";
		$buyingFormat.="&itemFilter(1).value(0)=FixedPrice";
		$seller = "&itemFilter(2).name=ReturnsAcceptedOnly";
		$seller.="&itemFilter(2).value(0)=true";
		$FreeShippingOnly = "&itemFilter(3).name=FreeShippingOnly";
		$FreeShippingOnly.="&itemFilter(3).value(0)=true";
		//$Authorized = "&itemFilter(4).name=AuthorizedSellerOnly";
		//$Authorized .= "&itemFilter(4).value(0)=true";
		$SellerInfo = "&outputSelector(0)=SellerInfo";
		$PictureURLSuperSize = "&outputSelector(1)=PictureURLSuperSize";
		$StoreInfo = "&outputSelector(2)=StoreInfo";
		$HideDuplicateItems="&HideDuplicateItems=true";
		$MinQuantity="&MinQuantity=1";
		//$ValueBoxInventory="&ValueBoxInventory=1";
		$pageNumber = 2;
		//$pageNumber = $return["pageNumber"];
		$URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
		$URL = $URL.$KeyWord."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber."&sortOrder=".$sortOrder.$MinQuantity.$HideDuplicateItems.$condition.$buyingFormat.$seller.$FreeShippingOnly.$SellerInfo.$PictureURLSuperSize.$StoreInfo;
		//$condition = "&itemFilter(0).name=Condition&itemFilter(0).value(0)=3000";

		// $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=".$KeyWord."&paginationInput.entriesPerPage=10&paginationInput.pageNumber=2&sortOrder=PricePlusShippingLowest".$condition."&itemFilter(1).name=ListingType&itemFilter(1).value(0)=FixedPrice&itemFilter(2).name=ReturnsAcceptedOnly&itemFilter(2).value(0)=true";
		// $URL = $URL.$FreeShippingOnly.$MaxHandlingTime.$SellerInfo.$PictureURLSuperSize.$StoreInfo;

		//&siteid=0&GLOBAL-ID=EBAY-US
		//$URL="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=iphone 5s&paginationInput.entriesPerPage=10&paginationInput.pageNumber=2&sortOrder=PricePlusShippingHighest&itemFilter(0).name=Condition&itemFilter(0).value(0)=6000&itemFilter(3).name=ListingType&itemFilter(3).value(0)=FixedPrice&itemFilter(4).name=ReturnsAcceptedOnly&itemFilter(4).value(0)=true&itemFilter(5).name=FreeShippingOnly&itemFilter(5).value(0)=false&itemFilter(6).name=ExpeditedShippingType&itemFilter(6).value(0)=Expedited&outputSelector(0)=SellerInfo&outputSelector(1)=PictureURLSuperSize&outputSelector(2)=StoreInfo"
//var_dump($URL);exit;
// echo $URL;
// die();
		//.$SellerInfo.$PictureURLSuperSize.$StoreInfo
		//$URL_test = "http://svcs.eBay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=harry%20potter&paginationInput.entriesPerPage=5&sortOrder=PricePlusShippingLowest";
		$XML = new SimpleXMLElement(file_get_contents($URL));
/*		http://svcs.ebay.com/services/search/FindingService/v1?%20OPERATION-NAME=findItemsAdvanced&%20SERVICE-VERSION=1.7.0&%20SECURITY-APPNAME=YourAppID&%20RESPONSE-DATA-FORMAT=XML&%20REST-PAYLOAD&%20itemFilter(0).name=Seller&%20itemFilter(0).value=eforcity&%20paginationInput.entriesPerPage=3&%20outputSelector=SellerInfo
		$fileContents= file_get_contents($URL);//get contents of the XML file

		$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);//remove the newlines, returns and tabs.
		$fileContents = trim(str_replace('"', "'", $fileContents));// replace double quotes with single quotes and trim leading and trailing spaces

		$XML = simplexml_load_string($fileContents);
		$return["json"]  = json_encode($XML);//convert the XML to JSON, Encode $return to JSON, set it as $return["json"]
		
		
		//$return["json"]  = json_encode($XML);
		$return["ack"]  = json_encode($XML->ack);//!!!!!!!!!!!!!you must define "ack" inside PHP file !!!!!
		
		$return["resultCount"]  = json_encode($XML->paginationOutput->totalEntries);
		$return["pageNumber"]  = json_encode($XML->paginationOutput->pageNumber);
		$return["itemCount"]  = json_encode($XML->paginationOutput->entriesPerPage);
	*/	
		$json['ack']  = "$XML->ack";
		$paginationOutput = $XML->paginationOutput; 
		$json['resultCount']  = "$paginationOutput->totalEntries";// variables inside "" cannot be longer than 2!!
		$json['pageNumber']  = "$paginationOutput->pageNumber";
		$json['itemCount']  = "$paginationOutput->entriesPerPage";
		$json['totalPages']  = "$paginationOutput->totalPages";
		
		$i = 0;
		
		foreach($XML->searchResult->item as $item)
		{
			$json['item'][$i]['basicInfo']['title'] = "$item->title";
			$json['item'][$i]['basicInfo']['viewItemURL'] = "$item->viewItemURL";
			$json['item'][$i]['basicInfo']['galleryURL'] = "$item->galleryURL";
			$json['item'][$i]['basicInfo']['pictureURLSuperSize'] = "$item->pictureURLSuperSize";
			$sellingStatus = $item->sellingStatus;
			$json['item'][$i]['basicInfo']['convertedCurrentPrice'] = "$sellingStatus->convertedCurrentPrice";
			$shippingInfo = $item->shippingInfo;
			$json['item'][$i]['basicInfo']['shippingServiceCost'] = "$shippingInfo->shippingServiceCost";
			$condition = $item->condition;
			$json['item'][$i]['basicInfo']['conditionDisplayName'] = "$condition->conditionDisplayName";
			$primaryCategory = $item->primaryCategory;
			$json['item'][$i]['basicInfo']['categoryName'] = "$primaryCategory->categoryName";
			$listingInfo = $item->listingInfo;
			$json['item'][$i]['basicInfo']['listingType'] = "$listingInfo->listingType";
			$json['item'][$i]['basicInfo']['location'] = "$item->location";
			$sellerInfo = $item->sellerInfo;
			$json['item'][$i]['sellerInfo']['sellerUserName'] = "$sellerInfo->sellerUserName";
			$json['item'][$i]['basicInfo']['topRatedListing'] = "$item->topRatedListing";
			$json['item'][$i]['sellerInfo']['feedbackScore'] = "$sellerInfo->feedbackScore";
			$json['item'][$i]['sellerInfo']['positiveFeedbackPercent'] = "$sellerInfo->positiveFeedbackPercent";
			$json['item'][$i]['sellerInfo']['feedbackRatingStar'] = "$sellerInfo->feedbackRatingStar";
			$json['item'][$i]['sellerInfo']['topRatedSeller'] = "$sellerInfo->topRatedSeller";
			$storeInfo = $item->storeInfo;
			$json['item'][$i]['sellerInfo']['sellerStoreName'] = "$storeInfo->storeName";
			$json['item'][$i]['sellerInfo']['sellerStoreURL'] = "$storeInfo->storeURL";
			$shippingInfo = $item->shippingInfo;
			$json['item'][$i]['shippingInfo']['shippingType'] = "$shippingInfo->shippingType";
			$json['item'][$i]['shippingInfo']['shipToLocations'] = "$shippingInfo->shipToLocations";			
			$json['item'][$i]['shippingInfo']['expeditedShipping'] = "$shippingInfo->expeditedShipping";
			$json['item'][$i]['shippingInfo']['oneDayShippingAvailable'] = "$shippingInfo->oneDayShippingAvailable";
			$json['item'][$i]['shippingInfo']['returnsAccepted'] = "$item->returnsAccepted";
			$json['item'][$i]['shippingInfo']['handlingTime'] = "$shippingInfo->handlingTime";
			$i++;
		}
	
		 $obj=json_encode($json);//return the JSON
		 //echo json_encode($json);

		 $json=json_decode($obj,true);
		 $i = 1;
		 //for($i=0; $i<=9; $i++)
		 echo "<table border='1'>
		 	<th>Sr. No</th>
		 	<th>Seller ID</th>
		 	<th>Price</th>
		 	<th>Quantity</th>
		 	<th>Select</th>";
		 	foreach($XML->searchResult->item as $item)
		 {
		 	//<td>". $json['item'][$i-1]['sellerInfo']['sellerUserName']."</td>
		 	echo "
		 <tr>
		 
		 	<td>".$i."</td>
		 	<td> <a href='".$json['item'][$i-1]['basicInfo']['viewItemURL']."' target = '_blank'>". $json['item'][$i-1]['sellerInfo']['sellerUserName']."</a></td>
		 	<td>".$json['item'][$i-1]['basicInfo']['convertedCurrentPrice']."</td>
		 	<td>3.9</td>
		 	<td>Select</td>
		 	
		</tr>";
//echo $json['item'][$i-1]['basicInfo']['categoryName'].'<br>';
		$i++;

		}
		echo "</table>";



		 	

		 	

		 // echo $json['ack'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['title'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['viewItemURL'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['galleryURL'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['pictureURLSuperSize'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['convertedCurrentPrice'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['shippingServiceCost'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['conditionDisplayName'].'<br>';
		  //echo $json['item'][$i]['basicInfo']['categoryName'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['listingType'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['location'].'<br>';
		 // echo $json['item'][$i]['basicInfo']['topRatedListing'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['sellerUserName'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['feedbackScore'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['positiveFeedbackPercent'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['feedbackRatingStar'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['topRatedSeller'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['sellerStoreName'].'<br>';
		 // echo $json['item'][$i]['sellerInfo']['sellerStoreURL'].'<br>';
		 // echo $json['item'][$i]['shippingInfo']['shippingType'].'<br>';
		 // echo $json['item'][$i]['shippingInfo']['shipToLocations'].'<br>';
		 // echo $json['item'][$i]['shippingInfo']['expeditedShipping'].'<br>';
		 // echo $json['item'][$i]['shippingInfo']['oneDayShippingAvailable'].'<br>';
		 // echo $json['item'][$i]['shippingInfo']['returnsAccepted'].'<br>';
		 // echo $json['item'][$i]['shippingInfo']['handlingTime'].'<br>';
		// $i++;
		// }
		// echo "</table>";
		 // echo $json['resultCount'].'<br>';
		 // echo $json['pageNumber'].'<br>';
		 // echo $json['itemCount'].'<br>';
		 // echo $json['totalPages'].'<br>';


?>
