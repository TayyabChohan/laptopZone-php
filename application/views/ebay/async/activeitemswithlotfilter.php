<?php
ini_set('memory_limit', '-1');
/**
 * Copyright 2016 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Include the SDK by using the autoloader from Composer.
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
$config = require __DIR__.'/../configuration_modified.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;
use GuzzleHttp\Promise;
//var_dump($value['GLOBAL_ID']);exit;
// $key=explode(",",@$value['KIT_KEYWORD']);
//    var_dump(count($key));exit;
// $from = '2017-03-24T01:25:48.000Z';
// $global_id = @$value['GLOBAL_ID'];
 $main_category_id = @$value['CATEGORY_ID'];
// if(empty($global_id)){
//     $global_id = 'US';
// }
/**
 * Create the service object.
 */
$service = new Services\FindingService([
    'credentials' => $config['production']['credentials'],
    'globalId'    => Constants\GlobalIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\FindItemsAdvancedRequest();
$keywords = '';//$keyword_brand;
// var_dump($keywords);exit;
$request->keywords = '';// $keyword_brand;
$request->sortOrder = 'StartTimeNewest';
if(!empty(@$value['CATEGORY_ID'])){
    $request->categoryId = [@$value['CATEGORY_ID']];
}else{
    die("Category ID Not Found");
}
$itemFilter = new Types\ItemFilter();
$itemFilter->name = 'LotsOnly';
$itemFilter->value[] ='true';
$request->itemFilter[] = $itemFilter;

//$request->keywords = '';//'HP 27-p014';
//$request->categoryId = ['38071'];//175673 ['179'];
// if(!empty(@$condition_id)){
//     $itemFilter = new Types\ItemFilter();
//     $itemFilter->name = 'Condition';
//     $itemFilter->value[] =@$condition_id;
//     $request->itemFilter[] = $itemFilter;
// }

// 2010-09-03T14:19:38.000Z
    // $itemFilter = new Types\ItemFilter();
    // $itemFilter->name = 'ListedIn';
    // $itemFilter->value[] ='EBAY-GB';
    // $request->itemFilter[] = $itemFilter;

    // $itemFilter = new Types\ItemFilter();
    // $itemFilter->name = 'ListedIn';
    // $itemFilter->value[] ='EBAY-US';
    // $request->itemFilter[] = $itemFilter;    

    // $itemFilter = new Types\ItemFilter();
    // $itemFilter->name = 'TopRatedSellerOnly';
    // $itemFilter->value[] ='true';
    // $request->itemFilter[] = $itemFilter;

    // $itemFilter = new Types\ItemFilter();
    // $itemFilter->name = 'FeedbackScoreMax';
    // $itemFilter->value[] ='100';
    // $request->itemFilter[] = $itemFilter;
//     $time = strtotime('-90 days');
//     $ModTimeFrom = gmdate('Y-m-d', $time);
//     $ModTimeFrom = $ModTimeFrom . 'T00:00:00.000Z';
//   //var_dump($ModTimeFrom);exit;
// //$ModTimeFrom='2010-09-03T14:19:38.000Z';
// if(!empty($ModTimeFrom)){
//     $itemFilter = new Types\ItemFilter();
//     //$itemFilter->name = 'EndTimeFrom';
//     $itemFilter->name = 'ModTimeFrom';
//     $itemFilter->value[] =$ModTimeFrom;
//     $request->itemFilter[] = $itemFilter;
// }    
// if(!empty($EndTimeTo)){
//     $itemFilter = new Types\ItemFilter();
//     $itemFilter->name = 'EndTimeTo';
//     $itemFilter->value[] =$EndTimeTo;
//     $request->itemFilter[] = $itemFilter;
// }
// if(!empty(@$seller_id)){
//     $itemFilter = new Types\ItemFilter();
//     $itemFilter->name = 'Seller';
//     $itemFilter->value[] =@$seller_id;
//     $request->itemFilter[] = $itemFilter;
// }

// listing type if i.e auction,BIN
// if(!empty(@$value['LISTINGTYPE'])){
//     $itemFilter = new Types\ItemFilter();
//     $itemFilter->name = 'ListingType';
//     $itemFilter->value[] =$value['LISTINGTYPE'];
//     $request->itemFilter[] = $itemFilter;
// }
    $request->paginationInput = new Types\PaginationInput();
    $request->paginationInput->entriesPerPage = 100;
    $request->paginationInput->pageNumber = 1;
    $request->outputSelector = ['SellerInfo'];
    //$request->outputSelector = ['SellerInfo','AspectHistogram','CategoryHistogram','UnitPriceInfo','ConditionHistogram'];
    /**
     * Send the request.
     * This is a synchronus request to obtain the total number of pages.
     */
    $response = $service->findItemsAdvanced($request);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre";
    // exit;

if (isset($response->errorMessage)) {
    foreach ($response->errorMessage->error as $error) {
        //var_dump($seller_id);
        printf(
            "%s: %s\n\n",
            $error->severity=== Enums\ErrorSeverity::C_ERROR ? 'Error' : 'Warning',
            $error->message
        );
    }
}

/**
 * Output the result of the search.
 */
// printf(
//     "%s items found over %s pages.\n\n",
//     $response->paginationOutput->totalEntries,
//     $response->paginationOutput->totalPages
// );

// echo "==================\nResults for page 1\n==================\n";
if ($response->ack !== 'Failure') {
    if($response->searchResult->count > 0){
        foreach ($response->searchResult->item as $item) {
            $itemId = $item->itemId;
            $globalId = $item->globalId;
            $title = $item->title;
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $categoryName = $item->primaryCategory->categoryName;
            $categoryName = trim(str_replace("  ", ' ', $categoryName));
            $categoryName = str_replace(array("`,′"), "", $categoryName);
            $categoryName = str_replace(array("'"), "''", $categoryName);
            $condition_name = @$item->condition->conditionDisplayName;
            $condition_name = trim(str_replace("  ", ' ', $condition_name));
            $condition_name = str_replace(array("`,′"), "", $condition_name);
            $condition_name = str_replace(array("'"), "''", $condition_name);
            $viewitemurl = $item->viewItemURL;
            $viewitemurl = trim(str_replace("  ", ' ', $viewitemurl));
            $viewitemurl = str_replace(array("`,′"), "", $viewitemurl);
            $viewitemurl = str_replace(array("'"), "''", $viewitemurl);
            $sellerUserName = $item->sellerInfo->sellerUserName;
            $sellerUserName = trim(str_replace("  ", ' ', $sellerUserName));
            $sellerUserName = str_replace(array("`,′"), "", $sellerUserName);
            $sellerUserName = str_replace(array("'"), "''", $sellerUserName);
            $listingType = $item->listingInfo->listingType;
            $listingType = trim(str_replace("  ", ' ', $listingType));
            $listingType = str_replace(array("`,′"), "", $listingType);
            $listingType = str_replace(array("'"), "''", $listingType);
            $postal_code = @$item->postalCode;
            if(empty($postal_code)){
                $postal_code = null;
            }
            $item_location = @$item->location;
            $item_location = trim(str_replace("  ", ' ', $item_location));
            $item_location = str_replace(array("`,′"), "", $item_location);
            $item_location = str_replace(array("'"), "''", $item_location);
            if(empty($item_location)){
                $item_location = null;
            }
            $item_country = @$item->country;
            if(empty($item_country)){
                $item_country = null;
            }
            $bid_count = @$item->sellingStatus->bidCount;
            if(empty($bid_count)){
                $bid_count = null;
            }
            $categoryId = $item->primaryCategory->categoryId;
            $currencyId =$item->sellingStatus->currentPrice->currencyId;
            $price = $item->sellingStatus->currentPrice->value;
            $condition_Id = @$item->condition->conditionId;
            
            if(empty($condition_Id)){
                $condition_Id = null;
            }
            $condition_name = @$item->condition->conditionDisplayName;
            if(empty($condition_name)){
                $condition_name = null;
            }
            
            $feedbackscore = $item->sellerInfo->feedbackScore;
            if(empty($feedbackscore)){
                $feedbackscore = null;
            }
            $shippingServiceCost = @$item->shippingInfo->shippingServiceCost->value;
            if(empty($shippingServiceCost)){
                $shippingServiceCost = 0;
            }
            $shippingType = @$item->shippingInfo->shippingType;
            if(empty($shippingType)){
                $shippingType = null;
            }
            //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
            
            //$bestoffer = $item->listingInfo->bestOfferEnabled;
            $startTime = $item->listingInfo->startTime->format('Y-m-d H:i:s');
            if($last_time_stamp >= $startTime){
                $break=1;
              break;  
            }else{
                $break=0;
            }
            $startTime = "TO_DATE('".$startTime."', 'YYYY-MM-DD HH24:MI:SS')";
            $endTime = $item->listingInfo->endTime->format('Y-m-d H:i:s');
            $endTime = "TO_DATE('".$endTime."', 'YYYY-MM-DD HH24:MI:SS')";
            //var_dump($itemId , $title, $price, $condition_Id , $condition_name , $viewitemurl , $sellerUserName , $listingType, $bestoffer, $startTime , $endTime ); 
            date_default_timezone_set("America/Chicago");
            $inserted_date = date("Y-m-d H:i:s");
            $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
            $comma = ',';

    // ===================== Start Checking if record already exist ==============================
        $select_query = "SELECT * FROM $table_name D WHERE D.EBAY_ID = $itemId";
        $select =oci_parse($conn, $select_query);
        oci_execute($select,OCI_DEFAULT);
        $data = oci_fetch_array($select, OCI_ASSOC);
              

    // ===================== End Checking if record already exist ===============================                

             if($data == false){
                // $get_pk = "SELECT GET_SINGLE_PRIMARY_KEY('$table_name','LZ_BD_CATA_ID') LZ_BD_CATA_ID FROM DUAL";
                // $select =oci_parse($conn, $get_pk);
                // oci_execute($select,OCI_DEFAULT);
                // $num_row = oci_fetch_array($select, OCI_ASSOC);
                // $lz_bd_cata_id = $num_row['LZ_BD_CATA_ID'];

                $insert_qry = "INSERT INTO $table_name (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID,GLOBAL_ID,MAIN_CATEGORY_ID,ITEM_LOCATION,POSTAL_CODE,BID_COUNT,ITEM_COUNTRY,SHIPPING_COST,SHIPPING_TYPE,LOTSONLY) VALUES(lz_bd_active_id_seq.nextval $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'ACTIVE' $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$main_category_id' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType' $comma 1)"; 
                
             }else{
                $insert_qry = "UPDATE $table_name SET TITLE = '$title', CONDITION_ID = '$condition_Id', CONDITION_NAME = '$condition_name', SALE_PRICE = $price, LISTING_TYPE = '$listingType', START_TIME = $startTime, SALE_TIME = $endTime, INSERTED_DATE = $inserted_date, FEEDBACK_SCORE = '$feedbackscore', STATUS = 'ACTIVE',MAIN_CATEGORY_ID = '$main_category_id', BID_COUNT = '$bid_count', LOTSONLY = 1 WHERE EBAY_ID = $itemId"; 
             }
            $select =oci_parse($conn, $insert_qry);
            $qry = oci_execute($select,OCI_DEFAULT);
            oci_commit($conn);
            //$rs = oci_fetch_array($select, OCI_ASSOC);            
            //$qry = $this->db->query($insert_qry);
            if($qry != true){
                echo $insert_qry;
            }
        }// end foreach

    }//end count if
}//end if
// var_dump($insert_qry);
// exit;

if(@$response->searchResult->count > 0 && $break ==0 ){
    /**
     * Paginate through upto 20 more pages worth of results.
     * The requests for these pages will be made concurrently.
     */
    $limit = min($response->paginationOutput->totalPages, 100);
    $promises = [];
    for ($pageNum = 2; $pageNum <= $limit; $pageNum++) {
        $request->paginationInput->pageNumber = $pageNum;//findItemsAdvancedAsync
        $promises[$pageNum] = $service->findItemsAdvancedAsync($request);
    }

    /**
     * Wait on all promises to complete.
     */
    $results = Promise\unwrap($promises);
       // echo "<pre>";
       //  print_r($results);
       //  echo "</pre";
       //  exit;
    foreach ($results as $pageNum => $response) {
        //echo "==================\nResults for page $pageNum\n==================\n";

        if ($response->ack !== 'Failure') {
            if($response->searchResult->count > 0){
                foreach ($response->searchResult->item as $item) {
                $itemId = $item->itemId;
                $globalId = $item->globalId;
                $title = $item->title;
                $title = trim(str_replace("  ", ' ', $title));
                $title = str_replace(array("`,′"), "", $title);
                $title = str_replace(array("'"), "''", $title);
                $categoryName = $item->primaryCategory->categoryName;
                $categoryName = trim(str_replace("  ", ' ', $categoryName));
                $categoryName = str_replace(array("`,′"), "", $categoryName);
                $categoryName = str_replace(array("'"), "''", $categoryName);
                $condition_name = @$item->condition->conditionDisplayName;
                $condition_name = trim(str_replace("  ", ' ', $condition_name));
                $condition_name = str_replace(array("`,′"), "", $condition_name);
                $condition_name = str_replace(array("'"), "''", $condition_name);
                $viewitemurl = $item->viewItemURL;
                $viewitemurl = trim(str_replace("  ", ' ', $viewitemurl));
                $viewitemurl = str_replace(array("`,′"), "", $viewitemurl);
                $viewitemurl = str_replace(array("'"), "''", $viewitemurl);
                $sellerUserName = $item->sellerInfo->sellerUserName;
                $sellerUserName = trim(str_replace("  ", ' ', $sellerUserName));
                $sellerUserName = str_replace(array("`,′"), "", $sellerUserName);
                $sellerUserName = str_replace(array("'"), "''", $sellerUserName);
                $listingType = $item->listingInfo->listingType;
                $listingType = trim(str_replace("  ", ' ', $listingType));
                $listingType = str_replace(array("`,′"), "", $listingType);
                $listingType = str_replace(array("'"), "''", $listingType);
                $postal_code = @$item->postalCode;
                if(empty($postal_code)){
                    $postal_code = null;
                }
                $item_location = @$item->location;
                $item_location = trim(str_replace("  ", ' ', $item_location));
                $item_location = str_replace(array("`,′"), "", $item_location);
                $item_location = str_replace(array("'"), "''", $item_location);
                if(empty($item_location)){
                    $item_location = null;
                }
                $item_country = @$item->country;
                if(empty($item_country)){
                    $item_country = null;
                }
                $bid_count = @$item->sellingStatus->bidCount;
                if(empty($bid_count)){
                    $bid_count = null;
                }
                $categoryId = $item->primaryCategory->categoryId;
                $currencyId =$item->sellingStatus->currentPrice->currencyId;
                $price = $item->sellingStatus->currentPrice->value;
                $condition_Id = @$item->condition->conditionId;
                if(empty(@$condition_Id)){
                    $condition_Id = null;
                }
                if(empty($condition_name)){
                    $condition_name = null;
                }
                $feedbackscore = $item->sellerInfo->feedbackScore;
                $shippingServiceCost = @$item->shippingInfo->shippingServiceCost->value;
                if(empty(@$shippingServiceCost)){
                    $shippingServiceCost = 0;
                }
                $shippingType = $item->shippingInfo->shippingType;
                if(empty($shippingType)){
                    $shippingType = null;
                }
                //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
                //$bestoffer = $item->listingInfo->bestOfferEnabled;
                $startTime = $item->listingInfo->startTime->format('Y-m-d H:i:s');
                if($last_time_stamp >= $startTime){
                    $break=1;
                    break;  
                }else{
                    $break=0;
                }
                $startTime = "TO_DATE('".$startTime."', 'YYYY-MM-DD HH24:MI:SS')";
                $endTime = $item->listingInfo->endTime->format('Y-m-d H:i:s');
                $endTime = "TO_DATE('".$endTime."', 'YYYY-MM-DD HH24:MI:SS')";
                //var_dump($itemId , $title, $price, $condition_Id , $condition_name , $viewitemurl , $sellerUserName , $listingType, $bestoffer, $startTime , $endTime ); 
                date_default_timezone_set("America/Chicago");
                $inserted_date = date("Y-m-d H:i:s");
                $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
                $comma = ',';

    // ===================== Start Checking if record already exist ==============================
        $select_query = "SELECT * FROM $table_name D WHERE D.EBAY_ID = $itemId";
        $select =oci_parse($conn, $select_query);
        oci_execute($select,OCI_DEFAULT);
        $data = oci_fetch_array($select, OCI_ASSOC);
              

    // ===================== End Checking if record already exist ===============================                

             if($data == false){
                // $get_pk = "SELECT GET_SINGLE_PRIMARY_KEY('$table_name','LZ_BD_CATA_ID') LZ_BD_CATA_ID FROM DUAL";
                // $select =oci_parse($conn, $get_pk);
                // oci_execute($select,OCI_DEFAULT);
                // $num_row = oci_fetch_array($select, OCI_ASSOC);
                // $lz_bd_cata_id = $num_row['LZ_BD_CATA_ID'];
                $insert_qry = "INSERT INTO $table_name (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID,GLOBAL_ID,MAIN_CATEGORY_ID,ITEM_LOCATION,POSTAL_CODE,BID_COUNT,ITEM_COUNTRY,SHIPPING_COST,SHIPPING_TYPE,LOTSONLY) VALUES(lz_bd_active_id_seq.nextval $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'ACTIVE' $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$main_category_id' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType' $comma 1)"; 
                
             }else{
                $insert_qry = "UPDATE $table_name SET TITLE = '$title', CONDITION_ID = '$condition_Id', CONDITION_NAME = '$condition_name', SALE_PRICE = $price, LISTING_TYPE = '$listingType', START_TIME = $startTime, SALE_TIME = $endTime, INSERTED_DATE = $inserted_date, FEEDBACK_SCORE = '$feedbackscore', STATUS = 'ACTIVE',MAIN_CATEGORY_ID = '$main_category_id', BID_COUNT = '$bid_count', LOTSONLY = 1 WHERE EBAY_ID = $itemId"; 
             }
                $select =oci_parse($conn, $insert_qry);
                $qry = oci_execute($select,OCI_DEFAULT);
                oci_commit($conn);
                //$rs = oci_fetch_array($select, OCI_ASSOC);            
                //$qry = $this->db->query($insert_qry);
                if($qry != true){
                    echo $insert_qry;
                }
                               
                }//end foreach
            }// end count if
        }//end Failure check if
    }// end page number foreach
}//end count if
 //var_dump($insert_qry);exit;