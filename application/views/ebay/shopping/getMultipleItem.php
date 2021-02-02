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
$request = new Types\GetMultipleItemsRequestType();

/**
 * Specify the item ID of the listing.
 */
$request->ItemID = [$ebay_id];
//$request->ItemID = ['192371130222', '282742618900', '202121006140', '372143384614', '222727930734'];

/**
 * Specify that additional fields need to be returned in the response.
 */
$request->IncludeSelector = 'ItemSpecifics,Compatibility,Details,ShippingCosts';

/**
 * Send the request.
 */
$response = $service->GetMultipleItems($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        printf(
            "%s: %s\n%s\n\n",
            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            $error->ShortMessage,
            $error->LongMessage
        );
    }
}

if ($response->Ack !== 'Failure') {
    foreach ($response->Item as $item) {
        $itemId = $item->ItemID;
        $globalId = $item->Site;
        $title = $item->Title;
        $title = trim(str_replace("  ", ' ', $title));
        $title = str_replace(array("`,′"), "", $title);
        $title = str_replace(array("'"), "''", $title);
        $categoryName = $item->PrimaryCategoryName;//Computer, Tablets & Netzwerk:Notebooks & Netbooks:PC Notebooks & Netbooks
        $categoryName = trim(str_replace("  ", ' ', $categoryName));
        $categoryName = str_replace(array("`,′"), "", $categoryName);
        $categoryName = str_replace(array("'"), "''", $categoryName);
        $condition_name = @$item->ConditionDisplayName;
        $condition_name = trim(str_replace("  ", ' ', $condition_name));
        $condition_name = str_replace(array("`,′"), "", $condition_name);
        $condition_name = str_replace(array("'"), "''", $condition_name);
        $viewitemurl = $item->ListingDetails->ViewItemURLForNaturalSearch;
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
        =            this API doesnt procide shipping detail            =
        ===============================================================*/
        // use this api to get shipping info "GetShippingCosts"
        // $shippingServiceCost = @$item->ShippingDetails->ShippingServiceOptions->ShippingServiceCost->value;
        // if(empty($shippingServiceCost)){
        //     $shippingServiceCost = 0;
        // }
        // $shippingType = @$item->ShippingDetails->ShippingServiceOptions->ShippingType;
        // if(empty($shippingType)){
        //     $shippingType = null;
        // }        
        $shippingServiceCost = 0;
        $shippingType = null;
        /*=====  End of this API doesnt procide shipping detail  ======*/
        
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
        // $sql = "SELECT GET_SINGLE_PRIMARY_KEY('$main_table','LZ_BD_CATA_ID') LZ_BD_CATA_ID FROM DUAL";
        // $get_pk = $this->db2->query($sql)->result_array();
        // $lz_bd_cata_id = $get_pk[0]['LZ_BD_CATA_ID'];
        $insert_qry = "INSERT INTO $main_table (LZ_BD_CATA_ID, CATEGORY_ID, EBAY_ID, TITLE, CONDITION_ID, CONDITION_NAME, ITEM_URL, SALE_PRICE, LISTING_TYPE, START_TIME, SALE_TIME, INSERTED_DATE, SELLER_ID, STATUS, IS_DELETED, FEEDBACK_SCORE, CATEGORY_NAME, CURRENCY_ID, GLOBAL_ID, MAIN_CATEGORY_ID, ITEM_LOCATION, POSTAL_CODE, BID_COUNT, ITEM_COUNTRY, SHIPPING_COST, SHIPPING_TYPE) VALUES(lz_bd_active_id_seq.nextval $comma $categoryId $comma $itemId $comma '$title' $comma '$condition_Id' $comma '$condition_name' $comma '$viewitemurl' $comma $price $comma '$listingType' $comma $startTime $comma $endTime $comma $inserted_date $comma '$sellerUserName' $comma 'ACTIVE' $comma $is_deleted $comma '$feedbackscore' $comma '$categoryName' $comma '$currencyId' $comma '$globalId'  $comma '$category_id' $comma '$item_location' $comma '$postal_code' $comma '$bid_count' $comma '$item_country' $comma $shippingServiceCost $comma '$shippingType')";

        $select =oci_parse($conn, $insert_qry);
        $qry = oci_execute($select,OCI_DEFAULT);
        oci_commit($conn);
        //$rs = oci_fetch_array($select, OCI_ASSOC);            
        //$qry = $this->db->query($insert_qry);
        if($qry != true){
            echo $insert_qry;
        }else{
            echo "Downloaded Successfully";
        }

        // print("$title<br>");

        // printf(
        //     "Quantity sold %s, quantiy available %s<br>",
        //     $item->QuantitySold,
        //     $item->Quantity - $item->QuantitySold
        // );
    }

    if (isset($item->ItemSpecifics)) {
        print("\nThis item has the following item specifics:\n\n");

        foreach ($item->ItemSpecifics->NameValueList as $nameValues) {
            printf(
                "%s: %s\n",
                $nameValues->Name,
                implode(', ', iterator_to_array($nameValues->Value))
            );
        }
    }

    if (isset($item->Variations)) {
        print("\nThis item has the following variations:\n");

        foreach ($item->Variations->Variation as $variation) {
            printf(
                "\nSKU: %s\nStart Price: %s\n",
                $variation->SKU,
                $variation->StartPrice->value
            );

            printf(
                "Quantity sold %s, quantiy available %s\n",
                $variation->SellingStatus->QuantitySold,
                $variation->Quantity - $variation->SellingStatus->QuantitySold
            );

            foreach ($variation->VariationSpecifics as $specific) {
                foreach ($specific->NameValueList as $nameValues) {
                    printf(
                        "%s: %s\n",
                        $nameValues->Name,
                        implode(', ', iterator_to_array($nameValues->Value))
                    );
                }
            }
        }
    }

    if (isset($item->ItemCompatibilityCount)) {
        printf("\nThis item is compatible with %s vehicles:\n\n", $item->ItemCompatibilityCount);

        // Only show the first 3.
        $limit = min($item->ItemCompatibilityCount, 3);
        for ($x = 0; $x < $limit; $x++) {
            $compatibility = $item->ItemCompatibilityList->Compatibility[$x];
            foreach ($compatibility->NameValueList as $nameValues) {
                printf(
                    "%s: %s\n",
                    $nameValues->Name,
                    implode(', ', iterator_to_array($nameValues->Value))
                );
            }
            printf("Notes: %s \n", $compatibility->CompatibilityNotes);
        }
    }
}
