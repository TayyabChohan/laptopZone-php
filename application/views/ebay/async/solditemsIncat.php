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
$config = require __DIR__.'/../configuration.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;
use GuzzleHttp\Promise;
//var_dump($data[0]['GLOBAL_ID']);exit;
// $key=explode(",",@$data[0]['KIT_KEYWORD']);
//    var_dump(count($key));exit;
$global_id = @$data[0]['GLOBAL_ID'];
if(empty($global_id)){
    $global_id = 'US';
}
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
$request = new Types\FindCompletedItemsRequest();
$request->keywords = '';
$request->sortOrder = 'EndTimeSoonest';
if(!empty(@$data[0]['CATEGORY_ID'])){
    $request->categoryId = [@$data[0]['CATEGORY_ID']];
}else{
    die("Category ID Not Found");
}
//$request->keywords = '';//'HP 27-p014';
//$request->categoryId = ['38071'];//175673 ['179'];
if(!empty(@$data[0]['CONDITION']) && @$data[0]['CONDITION'] !== 0){
    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'Condition';
    $itemFilter->value[] =@$data[0]['CONDITION'];
    $request->itemFilter[] = $itemFilter;
}
    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'SoldItemsOnly';
    $itemFilter->value[] ='true';
    $request->itemFilter[] = $itemFilter;

if(!empty(@$data[0]['SELLER_ID'])){
    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'Seller';
    $itemFilter->value[] =$data[0]['SELLER_ID'];
    $request->itemFilter[] = $itemFilter;
}

// listing type if i.e auction,BIN
if(!empty(@$data[0]['LISTING_TYPE'])){
    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'ListingType';
    $itemFilter->value[] =$data[0]['LISTING_TYPE'];
    $request->itemFilter[] = $itemFilter;
}
    
    $request->paginationInput = new Types\PaginationInput();
    $request->paginationInput->entriesPerPage = 100;
    $request->paginationInput->pageNumber = 1;
    $request->outputSelector = ['SellerInfo'];
    /**
     * Send the request.
     * This is a synchronus request to obtain the total number of pages.
     */
    $response = $service->findCompletedItems($request);
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
require('/../../API/get-common/db_connection.php');
if ($response->ack !== 'Failure') {
    
    foreach ($response->searchResult->item as $item) {

            $itemId = $item->itemId;
            $globalId = $item->globalId;
            $title = $item->title;
            $title = trim(str_replace("  ", ' ', $title));
            $title = trim(str_replace(array("'"), "''", $title));
            $categoryId = $item->primaryCategory->categoryId;
            $categoryName = $item->primaryCategory->categoryName;
            $currencyId =$item->sellingStatus->currentPrice->currencyId;
            $price = $item->sellingStatus->currentPrice->value;
            $condition_Id = $item->condition->conditionId;
            $condition_name = $item->condition->conditionDisplayName;
            $condition_name = trim(str_replace("  ", ' ', $condition_name));
            $condition_name = trim(str_replace(array("'"), "''", $condition_name));
            if(empty($condition_Id)){
                $condition_Id = null;
            }
            
            $condition_name = @$item->condition->conditionDisplayName;
            if(empty($condition_name)){
                $condition_name = null;
            }
            $viewitemurl = $item->viewItemURL;
            $viewitemurl = trim(str_replace("  ", ' ', $viewitemurl));
            $viewitemurl = trim(str_replace(array("'"), "''", $viewitemurl));
            $sellerUserName = $item->sellerInfo->sellerUserName;
            $sellerUserName = trim(str_replace("  ", ' ', $sellerUserName));
            $sellerUserName = trim(str_replace(array("'"), "''", $sellerUserName));
            $feedbackscore = $item->sellerInfo->feedbackScore;
            //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
            $listingType = $item->listingInfo->listingType;
            $listingType = trim(str_replace("  ", ' ', $listingType));
            $listingType = trim(str_replace(array("'"), "''", $listingType));
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
                $select_query = "SELECT * FROM LZ_BD_CATAG_DATA D WHERE D.EBAY_ID = $itemId"; 
                $select =oci_parse($conn, $select_query);
                oci_execute($select,OCI_DEFAULT);
                $num_row = oci_fetch_array($select, OCI_ASSOC);
                
                //var_dump($num_row ); //exit;
    // =========== End Checking if record already exist =====================
            if($num_row == false){

                $query = $this->db->query(" SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CATAG_DATA','LZ_BD_CATA_ID') LZ_BD_CATA_ID FROM DUAL");
                $rs = $query->result_array();
                $lz_bd_cata_id = $rs[0]['LZ_BD_CATA_ID'];

                $insert_qry = "INSERT INTO LZ_BD_CATAG_DATA (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID,GLOBAL_ID) VALUES($lz_bd_cata_id $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'Sold' $comma $feedbackscore $comma '$categoryName' $comma '$currencyId' $comma '$globalId')"; 
                
            }else{
                $insert_qry = "UPDATE LZ_BD_CATAG_DATA SET TITLE = '$title', CONDITION_ID = $condition_Id, CONDITION_NAME = '$condition_name', SALE_PRICE = $price, LISTING_TYPE = '$listingType', START_TIME = $startTime, SALE_TIME = $endTime, INSERTED_DATE = $inserted_date, FEEDBACK_SCORE = $feedbackscore, STATUS = 'Sold' where EBAY_ID = $itemId"; 
            }
            //var_dump($insert_qry);
            $insert =oci_parse($conn, $insert_qry);
            oci_execute($insert,OCI_DEFAULT);
            oci_commit($conn);

    }// end foreach
// exit;
}//end if

/**
 * Paginate through upto 20 more pages worth of results.
 * The requests for these pages will be made concurrently.
 */
$limit = min($response->paginationOutput->totalPages, 100);
$promises = [];
for ($pageNum = 2; $pageNum <= $limit; $pageNum++) {
    $request->paginationInput->pageNumber = $pageNum;//findItemsAdvancedAsync
    $promises[$pageNum] = $service->FindCompletedItemsAsync($request);
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
        
        foreach ($response->searchResult->item as $item) {
            // printf(
            //     "(%s) %s: %s %.2f\n",
            //     $item->itemId,
            //     $item->title,
            //     $item->sellingStatus->currentPrice->currencyId,
            //     $item->sellingStatus->currentPrice->value
            // );
            $itemId = $item->itemId;
            $globalId = $item->globalId;
            $categoryId = $item->primaryCategory->categoryId;
            $categoryName = $item->primaryCategory->categoryName;
            $title = $item->title;
            $title = trim(str_replace("  ", ' ', $title));
            $title = trim(str_replace(array("'"), "''", $title));
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
            $condition_name = trim(str_replace("  ", ' ', $condition_name));
            $condition_name = trim(str_replace(array("'"), "''", $condition_name));
            $viewitemurl = $item->viewItemURL;
            $viewitemurl = trim(str_replace("  ", ' ', $viewitemurl));
            $viewitemurl = trim(str_replace(array("'"), "''", $viewitemurl));
            $sellerUserName = $item->sellerInfo->sellerUserName;
            $sellerUserName = trim(str_replace("  ", ' ', $sellerUserName));
            $sellerUserName = trim(str_replace(array("'"), "''", $sellerUserName));
            $feedbackscore = $item->sellerInfo->feedbackScore;
            //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
            $listingType = $item->listingInfo->listingType;
            $listingType = trim(str_replace("  ", ' ', $listingType));
            $listingType = trim(str_replace(array("'"), "''", $listingType));
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
                $select_query = "SELECT * FROM LZ_BD_CATAG_DATA D WHERE D.EBAY_ID = $itemId"; 
                $select =oci_parse($conn, $select_query);
                oci_execute($select,OCI_DEFAULT);
                $num_row = oci_fetch_array($select, OCI_ASSOC);
                
                //var_dump($num_row )
    // =========== End Checking if record already exist =====================
                    
            if($num_row == false){

                $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CATAG_DATA','LZ_BD_CATA_ID') LZ_BD_CATA_ID FROM DUAL");
                $rs = $query->result_array();
                $lz_bd_cata_id = $rs[0]['LZ_BD_CATA_ID'];

                $insert_qry = "INSERT INTO LZ_BD_CATAG_DATA (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID,GLOBAL_ID) VALUES($lz_bd_cata_id $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'Sold' $comma $feedbackscore $comma '$categoryName' $comma '$currency_id' $comma '$globalId')"; 
                
            }else{
                $insert_qry = "UPDATE LZ_BD_CATAG_DATA SET TITLE = '$title', CONDITION_ID = $condition_Id, CONDITION_NAME = '$condition_name', SALE_PRICE = $price, LISTING_TYPE = '$listingType', START_TIME = $startTime, SALE_TIME = $endTime, INSERTED_DATE = $inserted_date, FEEDBACK_SCORE = $feedbackscore, STATUS = 'Sold' where EBAY_ID = $itemId"; 
            }
            // echo $insert_qry;
            $insert =oci_parse($conn, $insert_qry);
            oci_execute($insert,OCI_DEFAULT);
            oci_commit($conn);
        }
    }
    
}
