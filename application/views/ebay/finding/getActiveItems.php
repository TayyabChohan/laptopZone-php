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
$config = require __DIR__.'/../configuration_modified.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;
use GuzzleHttp\Promise;
/**
 * Create the service object.
 */
$service = new Services\FindingService([
    'credentials' => $config['production1']['credentials'],
    'globalId'    => Constants\GlobalIds::US
]);

/**
 * Create the request object.
 */
foreach ($data as $val){
    $request = new Types\FindItemsAdvancedRequest();
    $brand = $val['BRAND'];
    $mpn = $val['MPN'];
    $upc = $val['UPC'];
    $category_id = $val['CATEGORY_ID'];
    $condition_id = $val['CONDITION_ID'];
    //$list_price = $val['LIST_PRICE'];
    $item_id = $val['ITEM_ID'];

    if(!empty($upc)){
        $key = $upc;
    }else{
        $key = $brand." ".$mpn;
    }
    $request->keywords = $key;
    $request->categoryId = [$category_id];
    if(!empty($condition_id)){
        $itemFilter = new Types\ItemFilter();
        $itemFilter->name = 'Condition';
        $itemFilter->value[] =$condition_id;
        $request->itemFilter[] = $itemFilter;
    }
    /**
     * Filter results to only include auction items or auctions with buy it now.
     */
    // $itemFilter = new Types\ItemFilter();
    // $itemFilter->name = 'ListingType';
    // $itemFilter->value[] = 'FixedPrice';
    // $itemFilter->value[] = 'AuctionWithBIN';
    // $itemFilter->value[] = 'StoreInventory';
    // $request->itemFilter[] = $itemFilter;

    /**
     * Add additional filters to only include items that fall in the price range of $1 to $10.
     *
     * Notice that we can take advantage of the fact that the SDK allows object properties to be assigned via the class constructor.
     
    $request->itemFilter[] = new Types\ItemFilter([
        'name' => 'MinPrice',
        'value' => ['1.00']
    ]);

    $request->itemFilter[] = new Types\ItemFilter([
        'name' => 'MaxPrice',
        'value' => ['10.00']
    ]);
    */
    /**
     * Sort the results by current price.
     */
    /*===================================
    =            date filter            =
    ===================================*/
    // date_default_timezone_set("America/Chicago");
    // $time = strtotime('-7 days');
    // $EndTimeFrom = gmdate('Y-m-d', $time);
    // $EndTimeFrom = $EndTimeFrom . 'T00:00:00.000Z';

    // $EndTimeTo = date('Y-m-d\TH:i:s');
    // $EndTimeTo = $EndTimeTo.'.000Z';

    // if(!empty($EndTimeFrom)){
    //     $itemFilter = new Types\ItemFilter();
    //     $itemFilter->name = 'EndTimeFrom';
    //     $itemFilter->value[] =$EndTimeFrom;
    //     $request->itemFilter[] = $itemFilter;
    // }    
    // if(!empty($EndTimeTo)){
    //     $itemFilter = new Types\ItemFilter();
    //     $itemFilter->name = 'EndTimeTo';
    //     $itemFilter->value[] =$EndTimeTo;
    //     $request->itemFilter[] = $itemFilter;
    // }
    /*=====  End of date filter  ======*/

    $request->sortOrder = 'BestMatch';//https://developer.ebay.com/devzone/finding/callref/types/SortOrderType.html
    $request->outputSelector = ['SellerInfo'];

    /**
     * Limit the results to 10 items per page and start at page 1.
     */
    $request->paginationInput = new Types\PaginationInput();
    $request->paginationInput->entriesPerPage = 100;
    $request->paginationInput->pageNumber = 1;

    /**
     * Send the request.
     */
    $response = $service->findItemsAdvanced($request);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
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

    if ($response->ack !== 'Failure') {
        if($response->searchResult->count > 0){
        $k = 1;
        $totalEntries = $response->paginationOutput->totalEntries;
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
            $main_category_id = $category_id;
            $currencyId =$item->sellingStatus->currentPrice->currencyId;
            $price = $item->sellingStatus->currentPrice->value;
            $condition_Id = @$item->condition->conditionId;
            if(empty($condition_Id)){
                $condition_Id = null;
            }
            if(empty($condition_name)){
                $condition_name = null;
            }
            $feedbackscore = $item->sellerInfo->feedbackScore;
            $shippingServiceCost = @$item->shippingInfo->shippingServiceCost->value;
            if(empty($shippingServiceCost)){
                $shippingServiceCost = 0;
            }
            $shippingType = $item->shippingInfo->shippingType;
            if(empty($shippingType)){
                $shippingType = null;
            }
            //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
            //$bestoffer = $item->listingInfo->bestOfferEnabled;
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
            $query = $this->db->query("SELECT * FROM LZ_EBAY_ACTIVE_DATA D WHERE D.EBAY_ID = $itemId");
    // =========== End Checking if record already exist =====================
            if($query->num_rows() == 0){
                //$this->db->query("TRUNCATE TABLE WIZ_ALL_TABLES_PK");
                $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_ACTIVE_DATA','LZ_ACTIVE_ID') LZ_ACTIVE_ID FROM DUAL");
                $rs = $query->result_array();
                $lz_active_id = $rs[0]['LZ_ACTIVE_ID'];
                $insert_qry = "INSERT INTO LZ_EBAY_ACTIVE_DATA (LZ_ACTIVE_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, END_TIME, INSERTED_DATE, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID,GLOBAL_ID,MAIN_CATEGORY_ID,ITEM_LOCATION,POSTAL_CODE,BID_COUNT,ITEM_COUNTRY,SHIPPING_COST,SHIPPING_TYPE,ITEM_ID,STATUS,ITEM_RANK,TOTAL_ENTRIES,KEYWORD) VALUES($lz_active_id $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName'  $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$main_category_id' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType' $comma '$item_id' $comma '0' $comma '$k' $comma '$totalEntries' $comma '$key')";
                $k++;
                if (!$this->db->query($insert_qry))
                {
                    $error = $this->db->error(); // Has keys 'code' and 'message'
                    echo "Error: ".$error.'<br>';
                    echo "Query: ".$insert_qry.'<br>';
                }
            }//else{
            //     $insert_qry = "UPDATE LZ_EBAY_ACTIVE_DATA SET TITLE = '$title', CONDITION_ID = '$condition_Id', CONDITION_NAME = '$condition_name', SALE_PRICE = $price, LISTING_TYPE = '$listingType', START_TIME = $startTime, END_TIME = $endTime, INSERTED_DATE = $inserted_date, FEEDBACK_SCORE = '$feedbackscore' ,MAIN_CATEGORY_ID = '$main_category_id', BID_COUNT = '$bid_count',ITEM_ID = '$item_id' WHERE EBAY_ID = $itemId AND END_TIME = $endTime"; 
            // }
            //$qry = $this->db->query($insert_qry);
            
            
        }//end foreach ($response->searchResult->item as $item)
        }else{// END IF COUNT
            $comma = ',';
            $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_ACTIVE_DATA','LZ_ACTIVE_ID') LZ_ACTIVE_ID FROM DUAL");
                $rs = $query->result_array();
                $lz_active_id = $rs[0]['LZ_ACTIVE_ID'];
                $insert_qry = "INSERT INTO LZ_EBAY_ACTIVE_DATA (LZ_ACTIVE_ID,ITEM_ID,STATUS,KEYWORD) VALUES($lz_active_id $comma '$item_id' $comma '1' $comma '$key')"; 
            $this->db->query($insert_qry);
        }
    }// end if ($response->ack !== 'Failure')





//     /**
//      * Paginate through  more pages worth of results. */
//     $limit = min($response->paginationOutput->totalPages, 100);
//     $promises = [];
//     for ($pageNum = 2; $pageNum <= $limit; $pageNum++) {
//         $request->paginationInput->pageNumber = $pageNum;//findItemsAdvancedAsync
//         $promises[$pageNum] = $service->findItemsAdvancedAsync($request);
//     }
//     /**
//      * Wait on all promises to complete.
//      */
//     $results = Promise\unwrap($promises);
//     foreach ($results as $pageNum => $response) {

//         if ($response->ack !== 'Failure') {
//             if($response->searchResult->count > 0){
//                 foreach ($response->searchResult->item as $item) {
//                                 $itemId = $item->itemId;
//                 $globalId = $item->globalId;
//                 $title = $item->title;
//                 $title = trim(str_replace("  ", ' ', $title));
//                 $title = str_replace(array("`,′"), "", $title);
//                 $title = str_replace(array("'"), "''", $title);
//                 $categoryName = $item->primaryCategory->categoryName;
//                 $categoryName = trim(str_replace("  ", ' ', $categoryName));
//                 $categoryName = str_replace(array("`,′"), "", $categoryName);
//                 $categoryName = str_replace(array("'"), "''", $categoryName);
//                 $condition_name = @$item->condition->conditionDisplayName;
//                 $condition_name = trim(str_replace("  ", ' ', $condition_name));
//                 $condition_name = str_replace(array("`,′"), "", $condition_name);
//                 $condition_name = str_replace(array("'"), "''", $condition_name);
//                 $viewitemurl = $item->viewItemURL;
//                 $viewitemurl = trim(str_replace("  ", ' ', $viewitemurl));
//                 $viewitemurl = str_replace(array("`,′"), "", $viewitemurl);
//                 $viewitemurl = str_replace(array("'"), "''", $viewitemurl);
//                 $sellerUserName = $item->sellerInfo->sellerUserName;
//                 $sellerUserName = trim(str_replace("  ", ' ', $sellerUserName));
//                 $sellerUserName = str_replace(array("`,′"), "", $sellerUserName);
//                 $sellerUserName = str_replace(array("'"), "''", $sellerUserName);
//                 $listingType = $item->listingInfo->listingType;
//                 $listingType = trim(str_replace("  ", ' ', $listingType));
//                 $listingType = str_replace(array("`,′"), "", $listingType);
//                 $listingType = str_replace(array("'"), "''", $listingType);
//                 $postal_code = @$item->postalCode;
//                 if(empty($postal_code)){
//                     $postal_code = null;
//                 }
//                 $item_location = @$item->location;
//                 $item_location = trim(str_replace("  ", ' ', $item_location));
//                 $item_location = str_replace(array("`,′"), "", $item_location);
//                 $item_location = str_replace(array("'"), "''", $item_location);
//                 if(empty($item_location)){
//                     $item_location = null;
//                 }
//                 $item_country = @$item->country;
//                 if(empty($item_country)){
//                     $item_country = null;
//                 }
//                 $bid_count = @$item->sellingStatus->bidCount;
//                 if(empty($bid_count)){
//                     $bid_count = null;
//                 }
//                 $categoryId = $item->primaryCategory->categoryId;
//                 $main_category_id = $category_id;
//                 $currencyId =$item->sellingStatus->currentPrice->currencyId;
//                 $price = $item->sellingStatus->currentPrice->value;
//                 $condition_Id = @$item->condition->conditionId;
//                 if(empty($condition_Id)){
//                     $condition_Id = null;
//                 }
//                 if(empty($condition_name)){
//                     $condition_name = null;
//                 }
//                 $feedbackscore = $item->sellerInfo->feedbackScore;
//                 $shippingServiceCost = @$item->shippingInfo->shippingServiceCost->value;
//                 if(empty($shippingServiceCost)){
//                     $shippingServiceCost = 0;
//                 }
//                 $shippingType = $item->shippingInfo->shippingType;
//                 if(empty($shippingType)){
//                     $shippingType = null;
//                 }
//                 //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
//                 //$bestoffer = $item->listingInfo->bestOfferEnabled;
//                 $startTime = $item->listingInfo->startTime->format('Y-m-d H:i:s');
//                 $startTime = "TO_DATE('".$startTime."', 'YYYY-MM-DD HH24:MI:SS')";
//                 $endTime = $item->listingInfo->endTime->format('Y-m-d H:i:s');
//                 $endTime = "TO_DATE('".$endTime."', 'YYYY-MM-DD HH24:MI:SS')";
//                 //var_dump($itemId , $title, $price, $condition_Id , $condition_name , $viewitemurl , $sellerUserName , $listingType, $bestoffer, $startTime , $endTime ); 
//                 date_default_timezone_set("America/Chicago");
//                 $inserted_date = date("Y-m-d H:i:s");
//                 $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
//                 $comma = ',';

//            // ============== Start Checking if record already exist =====================
//                 $query = $this->db->query("SELECT * FROM LZ_WEEKLY_SOLD_DATA D WHERE D.EBAY_ID = $itemId AND D.END_TIME = $endTime");
//         // =========== End Checking if record already exist =====================
//                 if($query->num_rows() == 0){
//                     //$this->db->query("TRUNCATE TABLE WIZ_ALL_TABLES_PK");
//                     $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_WEEKLY_SOLD_DATA','LZ_ACTIVE_ID') LZ_ACTIVE_ID FROM DUAL");
//                     $rs = $query->result_array();
//                     $LZ_ACTIVE_ID = $rs[0]['LZ_ACTIVE_ID'];
//                     $insert_qry = "INSERT INTO LZ_WEEKLY_SOLD_DATA (LZ_ACTIVE_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, END_TIME, INSERTED_DATE, SELLER_ID, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID,GLOBAL_ID,MAIN_CATEGORY_ID,ITEM_LOCATION,POSTAL_CODE,BID_COUNT,ITEM_COUNTRY,SHIPPING_COST,SHIPPING_TYPE,ITEM_ID,STATUS) VALUES($LZ_ACTIVE_ID $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName'  $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$main_category_id' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType' $comma '$item_id' $comma '0')";
                
//                 }else{
//                     $insert_qry = "UPDATE LZ_WEEKLY_SOLD_DATA SET TITLE = '$title', CONDITION_ID = '$condition_Id', CONDITION_NAME = '$condition_name', SALE_PRICE = $price, LISTING_TYPE = '$listingType', START_TIME = $startTime, END_TIME = $endTime, INSERTED_DATE = $inserted_date, FEEDBACK_SCORE = '$feedbackscore' ,MAIN_CATEGORY_ID = '$main_category_id', BID_COUNT = '$bid_count',ITEM_ID = '$item_id' WHERE EBAY_ID = $itemId AND END_TIME = $endTime"; 
//                 }
//                 //$qry = $this->db->query($insert_qry);
//                 if (!$this->db->query($insert_qry))
//                 {
//                     $error = $this->db->error(); // Has keys 'code' and 'message'
//                     echo "Error: ".$error.'<br>';
//                     echo "Query: ".$insert_qry.'<br>';
//                 }
//                 }// end foreach ($response->searchResult->item as $item)
//             }else{// END IF COUNT
//                 $comma = ',';
//                 $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_WEEKLY_SOLD_DATA','LZ_ACTIVE_ID') LZ_ACTIVE_ID FROM DUAL");
//                 $rs = $query->result_array();
//                 $LZ_ACTIVE_ID = $rs[0]['LZ_ACTIVE_ID'];
//                 $insert_qry = "INSERT INTO LZ_WEEKLY_SOLD_DATA (LZ_ACTIVE_ID,ITEM_ID,STATUS) VALUES($LZ_ACTIVE_ID $comma '$item_id' $comma '1')"; 
//                 $this->db->query($insert_qry);
//         }// end if ($response->searchResult->count > 0)
//         }// end if ($response->ack !== 'Failure')
//     }//end foreach $results as $pageNum => $response
}// END DATA FOREACH
