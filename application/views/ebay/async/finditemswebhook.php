<?php
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
$config = require __DIR__.'/../configuration.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;
use GuzzleHttp\Promise;
//var_dump($data);exit;
// $key=explode(",",@$data[0]['KIT_KEYWORD']);
//    var_dump(count($key));exit;
$webhook_id = @$data[0]['WEBHOOK_ID'];
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
if(!empty(@$data[0]['WEBHOOK_KEYWORDS'])){
    $key=explode(",",@$data[0]['WEBHOOK_KEYWORDS']);
    if(count($key) > 1){
        $request->keywords = '('.@$data[0]['WEBHOOK_KEYWORDS'].')';
    }else{
        $request->keywords = @$data[0]['WEBHOOK_KEYWORDS'];
    }  
    $request->categoryId = [@$data[0]['WEBHOOK_CATEGORY_ID']];
}else{
    $key=explode(",",@$data[0]['KIT_KEYWORD']);
    if(count($key) > 1){
        $request->keywords = '('.@$data[0]['KIT_KEYWORD'].')';
    }else{
        $request->keywords = @$data[0]['KIT_KEYWORD'];
    } 
    $request->categoryId = [@$data[0]['KIT_CATEGORY_ID']];
}
if(!empty(@$data[0]['CONDITION_ID'])  && @$data[0]['CONDITION_ID'] !== 0){
    //var_dump(@$data[0]['CONDITION_ID']);
    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'Condition';
    $itemFilter->value[] =@$data[0]['CONDITION_ID'];
    $request->itemFilter[] = $itemFilter;
}
//$request->keywords = '('.$data[0]['WEBHOOK_KEYWORDS'].')';//'HP 27-p014';
//$request->categoryId = ['1244'];//175673 ['179'];
//$request->sortOrder = 'CurrentPriceHighest';
$request->paginationInput = new Types\PaginationInput();
$request->paginationInput->entriesPerPage = 200;
$request->paginationInput->pageNumber = 1;
$request->outputSelector = ['SellerInfo'];
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
    require('/../../API/get-common/db_connection.php');
    foreach ($response->searchResult->item as $item) {

            $itemId = $item->itemId;
            $title = $item->title;
            $price = $item->sellingStatus->currentPrice->value;
            $condition_Id = $item->condition->conditionId;
            $condition_name = $item->condition->conditionDisplayName;
            $viewitemurl = $item->viewItemURL;
            $sellerUserName = $item->sellerInfo->sellerUserName;
            //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
            $feedbackscore = $item->sellerInfo->feedbackScore;
            $listingType = $item->listingInfo->listingType;
            $bestoffer = $item->listingInfo->bestOfferEnabled;
            $startTime = $item->listingInfo->startTime->format('Y-m-d H:i:s');
            $startTime = "TO_DATE('".$startTime."', 'YYYY-MM-DD HH24:MI:SS')";
            $endTime = $item->listingInfo->endTime->format('Y-m-d H:i:s');
            $endTime = "TO_DATE('".$endTime."', 'YYYY-MM-DD HH24:MI:SS')";
            //var_dump($itemId , $title, $price, $condition_Id , $condition_name , $viewitemurl , $sellerUserName , $listingType, $bestoffer, $startTime , $endTime ); 
            date_default_timezone_set("America/Chicago");
            $inserted_date = date("Y-m-d H:i:s");
            $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
            //exit;
            //require_once('/../get-common/db_connection.php');
            $comma = ',';

    // ============== Start Checking if record already exist =====================
                $select_query = "SELECT * FROM LZ_WEBHOOK_DATA D WHERE D.EBAY_ID = $itemId"; 
                $select =oci_parse($conn, $select_query);
                oci_execute($select,OCI_DEFAULT);
                $num_row = oci_fetch_array($select, OCI_ASSOC);
                
                
    // =========== End Checking if record already exist =====================
            if($num_row == false){
                $insert_qry = "INSERT INTO LZ_WEBHOOK_DATA (WEBHOOK_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, PRICE, LISTING_TYPE, START_TIME, END_TIME, INSERTED_DATE, SELLER_ID,FEEDBACK_SCORE,STATUS ) VALUES($webhook_id $comma $itemId $comma '$title' $comma $condition_Id $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma $feedbackscore $comma 'Active')"; 
                $insert =oci_parse($conn, $insert_qry);
                oci_execute($insert,OCI_DEFAULT);
                oci_commit($conn);
                //var_dump($insert_qry,$num_row );exit;
            }
            

    }

}
// if($insert_qry){
//     echo "inserted";
// }else{
//     echo "false";
// }
// exit;
/**
 * Paginate through upto 20 more pages worth of results.
 * The requests for these pages will be made concurrently.
 */
$limit = min($response->paginationOutput->totalPages, 20);
$promises = [];
for ($pageNum = 2; $pageNum <= $limit; $pageNum++) {
    $request->paginationInput->pageNumber = $pageNum;
    $promises[$pageNum] = $service->findItemsAdvancedAsync($request);
}

/**
 * Wait on all promises to complete.
 */
$results = Promise\unwrap($promises);

foreach ($results as $pageNum => $response) {
    //echo "==================\nResults for page $pageNum\n==================\n";

    if ($response->ack !== 'Failure') {
        require('/../../API/get-common/db_connection.php');
        foreach ($response->searchResult->item as $item) {
            // printf(
            //     "(%s) %s: %s %.2f\n",
            //     $item->itemId,
            //     $item->title,
            //     $item->sellingStatus->currentPrice->currencyId,
            //     $item->sellingStatus->currentPrice->value
            // );
            $itemId = $item->itemId;
            $title = $item->title;
            $price = $item->sellingStatus->currentPrice->value;
            $condition_Id = $item->condition->conditionId;
            $condition_name = $item->condition->conditionDisplayName;
            $viewitemurl = $item->viewItemURL;
            $sellerUserName = $item->sellerInfo->sellerUserName;
            $feedbackscore = $item->sellerInfo->feedbackScore;
            //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
            $listingType = $item->listingInfo->listingType;
            $bestoffer = $item->listingInfo->bestOfferEnabled;
            $startTime = $item->listingInfo->startTime->format('Y-m-d H:i:s');
            $startTime = "TO_DATE('".$startTime."', 'YYYY-MM-DD HH24:MI:SS')";
            $endTime = $item->listingInfo->endTime->format('Y-m-d H:i:s');
            $endTime = "TO_DATE('".$endTime."', 'YYYY-MM-DD HH24:MI:SS')";
            //var_dump($itemId , $title, $price, $condition_Id , $condition_name , $viewitemurl , $sellerUserName , $listingType, $bestoffer, $startTime , $endTime ); 
            date_default_timezone_set("America/Chicago");
            $inserted_date = date("Y-m-d H:i:s");
            $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
            $comma = ',';

   // ============== Start Checking if record already exist =====================
                $select_query = "SELECT * FROM LZ_WEBHOOK_DATA D WHERE D.EBAY_ID = $itemId"; 
                $select =oci_parse($conn, $select_query);
                oci_execute($select,OCI_DEFAULT);
                $num_row = oci_fetch_array($select, OCI_ASSOC);
                
                //var_dump($num_row )
    // =========== End Checking if record already exist =====================

                if($num_row == false){
                    
                    $insert_qry = "INSERT INTO LZ_WEBHOOK_DATA (WEBHOOK_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, PRICE, LISTING_TYPE, START_TIME, END_TIME, INSERTED_DATE, SELLER_ID,FEEDBACK_SCORE,STATUS ) VALUES($webhook_id $comma $itemId $comma '$title' $comma $condition_Id $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma $feedbackscore $comma 'Active')"; 
                    $insert =oci_parse($conn, $insert_qry);
                    oci_execute($insert,OCI_DEFAULT);
                    oci_commit($conn);

                }
        }
    }
    
}
