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
$request = new Types\FindItemsIneBayStoresRequest();
// $account_type = $this->session->userdata('account_type');
// if($account_type == 1)
// {
//     $account_type = 'techbargains2015';
// }elseif($account_type == 2)
// {
//     $account_type = 'dfwonline';
// }
// if(!empty($account_type)){
//  $request->storeName = 'techbargains2015';// $account_type;   
// }else{
//     redirect('login/login');
// }
$request->storeName = 'techbargains2015';
 $request->outputSelector = ['UnitPriceInfo'];//,'StoreInfo'];
/**
 * Assign the keywords.
 */
$request->keywords = 'hp laptop';
//$request->categoryId = ['177'];
/**
 * Filter results to specific condition.
 */

// $itemFilter = new Types\ItemFilter();
// $itemFilter->name = 'Condition';
// $itemFilter->value[] = '1500';
// $request->itemFilter[] = $itemFilter;

/**
 * Send the request.
 */
$response = $service->FindItemsIneBayStores($request);
echo "<pre>";
print_r($response);
echo "</pre>";
exit;
/**
 * Output the result of the search.
 */
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
    foreach ($response->searchResult->item as $item) {
        printf(
            "(%s) %s: %s %.2f\n",
            $item->itemId,
            $item->title,
            $item->sellingStatus->currentPrice->currencyId,
            $item->sellingStatus->currentPrice->value
        );
        // $ebay_item_id = $response->ItemID;
        // if(!empty($ebay_item_id)){

        // }else{

        // }
            
            //$this->session->set_userdata('ebay_item_id', $ebay_item_id);
    }
}
