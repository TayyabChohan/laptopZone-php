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
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\GetMyeBaySellingRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

/**
 * Request that eBay returns the list of actively selling items.
 * We want 10 items per page and they should be sorted in descending order by the current price.
 */
$request->ActiveList = new Types\ItemListCustomizationType();
//$request->SoldList = new Types\ItemListCustomizationType();
// $request->UnsoldList = new Types\ItemListCustomizationType();
//$request->DeletedFromUnsoldList = new Types\ItemListCustomizationType();

$request->ActiveList->Include = true;
$request->ActiveList->Pagination = new Types\PaginationType();
$request->ActiveList->Pagination->EntriesPerPage = 200;
$request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
$pageNum = 1;

// $request->SoldList->Include = true;
// $request->SoldList->Pagination = new Types\PaginationType();
// $request->SoldList->Pagination->EntriesPerPage = 200;
// $request->SoldList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
// $pageNum = 1;

// $request->UnsoldList->Include = true;
// $request->UnsoldList->Pagination = new Types\PaginationType();
// $request->UnsoldList->Pagination->EntriesPerPage = 200;
// $pageNum = 1;

// $request->DeletedFromUnsoldList->Include = true;
// $request->DeletedFromUnsoldList->Pagination = new Types\PaginationType();
// $request->DeletedFromUnsoldList->Pagination->EntriesPerPage = 200;
//$request->DeletedFromUnsoldList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
//$pageNum = 1;




do {
    $request->ActiveList->Pagination->PageNumber = $pageNum;
    //$request->SoldList->Pagination->PageNumber = $pageNum;
     //$request->UnsoldList->Pagination->PageNumber = $pageNum;
    // $request->DeletedFromUnsoldList->Pagination->PageNumber = $pageNum;

    /**
     * Send the request.
     */
    $response = $service->getMyeBaySelling($request);
 // echo "<pre>";
 //        print_r($response);
 //        echo "</pre>";
 //        exit;
    /**
     * Output the result of calling the service operation.
     */
    //echo "==================\nResults for page $pageNum\n==================\n";

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

    if ($response->Ack !== 'Failure' && isset($response->ActiveList)) {
    //if ($response->Ack !== 'Failure' && isset($response->SoldList)) {
    //if ($response->Ack !== 'Failure' && isset($response->DeletedFromUnsoldList)) {
        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";
        // exit;
       //$i=1;
        foreach ($response->ActiveList->ItemArray->Item as $item) {
        //  foreach ($response->SoldList->OrderTransactionArray->OrderTransaction as $transaction) {
          //foreach ($response->UnsoldList->ItemArray->Item as $item) {
            
            //echo $transaction->Transaction->Item->ItemID."<br>";

              // echo "Sr No.: ".$i."Item ID: ".$item->ItemID."<br>";
               echo $item->ItemID."<br>";
              //$i++;
               //exit;
        }
    }

    $pageNum += 1;

} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
