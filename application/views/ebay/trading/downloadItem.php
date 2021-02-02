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
use \DTS\eBaySDK\Shopping\Services;
use \DTS\eBaySDK\Shopping\Types;
use \DTS\eBaySDK\Shopping\Enums;

/**
 * Create the service object.
 */
$service = new Services\ShoppingService([
    'credentials' => $config['production']['credentials']
]);

/**
 * Create the request object.
 */
$request = new Types\GetSingleItemRequestType();

/**
 * Specify the item ID of the listing.
 */
$request->ItemID = $ebay_id;

/**
 * Specify that additional fields need to be returned in the response.
 */
$request->IncludeSelector = 'ItemSpecifics,Details,ShippingCosts';

/**
 * Send the request.
 */
$response = $service->getSingleItem($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        if($error->SeverityCode == 'Error'){
            printf(
                "%s: %s<br>%s<br><br>",
                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                $error->ShortMessage,
                $error->LongMessage
            );
            $result = 2;
        }
    }
}

if ($response->Ack !== 'Failure') {
        $item = $response->Item;
        $itemId = $item->ItemID;
        $globalId = $item->Site;
        $title = $item->Title;
        $title = trim(str_replace("  ", ' ', $title));
        $title = str_replace(array("`,′"), "", $title);
        $title = str_replace(array("'"), "''", $title);
        $categoryName = $item->PrimaryCategoryName;//Computer, Tablets & Netzwerk:Notebooks & Netbooks:PC Notebooks & Netbooks
        $parts = explode(":", $categoryName);
        $categoryName = end($parts);
        $categoryName = trim(str_replace("  ", ' ', $categoryName));
        $categoryName = str_replace(array("`,′"), "", $categoryName);
        $categoryName = str_replace(array("'"), "''", $categoryName);
        $condition_name = @$item->ConditionDisplayName;
        $condition_name = trim(str_replace("  ", ' ', $condition_name));
        $condition_name = str_replace(array("`,′"), "", $condition_name);
        $condition_name = str_replace(array("'"), "''", $condition_name);
        $viewitemurl = $item->ViewItemURLForNaturalSearch;
        $viewitemurl = trim(str_replace("  ", ' ', $viewitemurl));
        $viewitemurl = str_replace(array("`,′"), "", $viewitemurl);
        $viewitemurl = str_replace(array("'"), "''", $viewitemurl);
        $sellerUserName = $item->Seller->UserID;
        $sellerUserName = trim(str_replace("  ", ' ', $sellerUserName));
        $sellerUserName = str_replace(array("`,′"), "", $sellerUserName);
        $sellerUserName = str_replace(array("'"), "''", $sellerUserName);
        $listingType = $item->ListingType;
        $listingType = trim(str_replace("  ", ' ', $listingType));
        $listingType = str_replace(array("`,′"), "", $listingType);
        $listingType = str_replace(array("'"), "''", $listingType);
        $postal_code = @$item->PostalCode;
        if(empty($postal_code)){
            $postal_code = null;
        }
        $item_location = @$item->Location;
        $item_location = trim(str_replace("  ", ' ', $item_location));
        $item_location = str_replace(array("`,′"), "", $item_location);
        $item_location = str_replace(array("'"), "''", $item_location);
        if(empty($item_location)){
            $item_location = null;
        }
        $item_country = @$item->Country;
        if(empty($item_country)){
            $item_country = null;
        }
        $bid_count = @$item->BidCount;
        if(empty($bid_count)){
            $bid_count = null;
        }
        $categoryId = $item->PrimaryCategoryID;
        $currencyId =$item->ConvertedCurrentPrice->currencyID;
        $price = $item->ConvertedCurrentPrice->value;
        $condition_Id = @$item->ConditionID;
        
        if(empty($condition_Id)){
            $condition_Id = null;
        }
        $condition_name = @$item->ConditionDisplayName;
        if(empty($condition_name)){
            $condition_name = null;
        }
        
        $feedbackscore = $item->Seller->FeedbackScore;
        if(empty($feedbackscore)){
            $feedbackscore = null;
        }
        /*===============================================================
        =            get shipping detail            =
        ===============================================================*/
        // use this api to get shipping info "GetShippingCosts"
        $shippingServiceCost = @$item->ShippingCostSummary->ShippingServiceCost->value;
        if(empty($shippingServiceCost)){
            $shippingServiceCost = 0;
        }
        $shippingType = @$item->ShippingCostSummary->ShippingType;
        if(empty($shippingType)){
            $shippingType = null;
        }        
        /*=====  End of get shipping detail  ======*/
        
        //$sellerfeedback = $item->sellerInfo->positiveFeedbackPercent;
        //$bestoffer = $item->listingInfo->bestOfferEnabled;
        $startTime = $item->StartTime->format('Y-m-d H:i:s');
        $startTime = "TO_DATE('".$startTime."', 'YYYY-MM-DD HH24:MI:SS')";
        $endTime = $item->EndTime->format('Y-m-d H:i:s');
        $endTime = "TO_DATE('".$endTime."', 'YYYY-MM-DD HH24:MI:SS')";
        //var_dump($itemId , $title, $price, $condition_Id , $condition_name , $viewitemurl , $sellerUserName , $listingType, $bestoffer, $startTime , $endTime ); 
        date_default_timezone_set("America/Chicago");
        $inserted_date = date("Y-m-d H:i:s");
        $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
        $comma = ',';
        $is_deleted = 0;
        $main_table = "LZ_BD_ACTIVE_DATA_".$categoryId;
                // duplication check in LZ_BD_ITEMS_TO_EST
               $active_item = $this->db2->query("SELECT LZ_BD_CATA_ID, EBAY_ID, MAIN_CATEGORY_ID CATEGORY_ID,TITLE, ITEM_URL, CONDITION_NAME, SELLER_ID, LISTING_TYPE, SALE_PRICE, START_TIME, SALE_TIME, FEEDBACK_SCORE, VERIFIED FROM LZ_BD_ITEMS_TO_EST WHERE MAIN_CATEGORY_ID = $categoryId AND EBAY_ID = $itemId AND ROWNUM = 1");
               $active_result = $active_item->result_array();

               if(@$active_item->num_rows() == 0){ //active_item if

                    $sequence_id = $this->db2->query("SELECT lz_bd_active_id_seq.nextval ID FROM DUAL");
                    $sequence_id = $sequence_id->result_array();
                    $sequence_id = $sequence_id[0]['ID']; 

                    $insert_qry = "INSERT INTO LZ_BD_ITEMS_TO_EST (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, IS_DELETED, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID, GLOBAL_ID, MAIN_CATEGORY_ID, ITEM_LOCATION, POSTAL_CODE, BID_COUNT, ITEM_COUNTRY, SHIPPING_COST, SHIPPING_TYPE, FLAG_ID) VALUES($sequence_id $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'ACTIVE' $comma $is_deleted $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$categoryId' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType', 23)";

                    //echo $insert_qry;exit;  
                    $qry = $this->db2->query($insert_qry);
                    if($qry != true){
                        echo $insert_qry;
                    }else{
                        
                        //duplication check in main table
                       $active_item = $this->db2->query("SELECT EBAY_ID FROM $main_table WHERE  EBAY_ID = $itemId AND ROWNUM = 1");
                       $active_result = $active_item->result_array();

                       if(@$active_item->num_rows() == 0){ //active_item if                        
                            $active_tab_qry = "INSERT INTO $main_table (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, IS_DELETED, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID, GLOBAL_ID, MAIN_CATEGORY_ID, ITEM_LOCATION, POSTAL_CODE, BID_COUNT, ITEM_COUNTRY, SHIPPING_COST, SHIPPING_TYPE, FLAG_ID) VALUES($sequence_id $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'ACTIVE' $comma $is_deleted $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$categoryId' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType', 23)";
                            $qry = $this->db2->query($active_tab_qry);

                            $result = 1;
                        }
                    }

               }else{ //active_item else

                    $verified = @$active_result[0]['VERIFIED'];

                    if(@$verified == 1){

                        date_default_timezone_set("America/Chicago");
                        $inserted_date = date("Y-m-d H:i:s");
                        $insert_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";    
                        $start_time = date("Y-m-d H:i:s");
                        $start_time = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
                        $sale_time = date('Y-m-d H:i:s', strtotime('1 months'));// date('m/01/Y');
                        $sale_time = "TO_DATE('".$sale_time."', 'YYYY-MM-DD HH24:MI:SS')";
                        $flag_id = 23;

                        $update_query = $this->db2->query("UPDATE $main_table SET IS_DELETED = 0, START_TIME = $start_time, SALE_TIME = $sale_time, INSERTED_DATE = $insert_date, FLAG_ID = 23 WHERE EBAY_ID = $itemId");

                        if($update_query != true){
                            echo $update_query;
                        }else{

                            $result = 2;
                        }                        

                    }else{ //verified else
                        $result = 1;
                        // $get_brands = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT       M, LZ_CATALOGUE_DET      D, CATEGORY_SPECIFIC_MT  CM, CATEGORY_SPECIFIC_DET CD WHERE M.CATALOGUE_MT_ID = D.CATALOGUE_MT_ID AND CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND CD.DET_ID = D.SPECIFIC_DET_ID AND M.CATEGORY_ID = $categoryId");
                        // $get_brands = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT M, CATEGORY_SPECIFIC_MT CM, CATEGORY_SPECIFIC_DET CD WHERE CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND M.CATEGORY_ID = CM.EBAY_CATEGORY_ID AND M.CATEGORY_ID = $categoryId");
                        // $get_brands = $get_brands->result_array();


                        
                        // $result = array("active_result"=>$active_result, "get_brands"=>$get_brands);
                    } //verified else end
               } 
               if(@$result == 1){
                $active_item = $this->db2->query("SELECT LZ_BD_CATA_ID, EBAY_ID, MAIN_CATEGORY_ID CATEGORY_ID,TITLE, ITEM_URL, CONDITION_NAME, SELLER_ID, LISTING_TYPE, SALE_PRICE, START_TIME, SALE_TIME, FEEDBACK_SCORE, VERIFIED FROM LZ_BD_ITEMS_TO_EST WHERE MAIN_CATEGORY_ID = $categoryId AND EBAY_ID = $itemId AND ROWNUM = 1");
                $active_result = $active_item->result_array();

                //$get_brands = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM LZ_CATALOGUE_MT M, CATEGORY_SPECIFIC_MT CM, CATEGORY_SPECIFIC_DET CD WHERE CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND' AND M.CATEGORY_ID = CM.EBAY_CATEGORY_ID AND M.CATEGORY_ID = $categoryId");
                $get_brands = $this->db2->query("SELECT DISTINCT CD.DET_ID, CM. SPECIFIC_NAME, CD. SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_MT CM, CATEGORY_SPECIFIC_DET CD WHERE CM.MT_ID = CD.MT_ID AND UPPER(CM.SPECIFIC_NAME) = 'BRAND'AND CM.EBAY_CATEGORY_ID = $categoryId");
                $get_brands = $get_brands->result_array();


                
                $result = array("active_result"=>$active_result, "get_brands"=>$get_brands);  
               }
                            

}else{// main ack if end
    $result = 2;
}
