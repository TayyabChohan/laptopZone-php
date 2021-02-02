<?php
//include "08-upload-picture-test.php";
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
 * Specify the numerical site id that we want the listing to appear on.
 *
 * This determines the validation rules that eBay will apply to the request.
 * For example, it will determine what categories can be specified, the values
 * allowed as shipping services, the visibility of the item in some searches and other
 * information.
 *
 * Note that due to the risk of listing fees been raised this example will list the item
 * to the sandbox site.
 */
$siteId = Constants\SiteIds::US;
//$itemID = '110179445537';
$ebay_id = $this->session->userdata('ebay_item_id');
$itemID = $ebay_id;
foreach ($seed_data as $row)
{
    $QUANTITY = (int)$row['QUANTITY'];
    $PRICE= (double)$row['EBAY_PRICE'];
    $quantity = $QUANTITY;
    /**
     * Create the service object.
     */
    $service = new Services\TradingService([
        'credentials' => $config['sandbox']['credentials'],
        'sandbox'     => true,
        'siteId'      => $siteId
    ]);

    $request = new Types\ReviseInventoryStatusRequestType();

    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    $request->RequesterCredentials->eBayAuthToken = $config['sandbox']['authToken'];

    $inventoryStatus = new Types\InventoryStatusType();

    $inventoryStatus->ItemID = $itemID;
    $inventoryStatus->Quantity = $quantity;
    $inventoryStatus->StartPrice = new Types\AmountType(['value' => $PRICE]);
    //$inventoryStatus->Description = '<h1>Bits & Bobs Again</h1><p>Just some &lt;stuff&gt; I found.</p><p>Edited description</p>';

    $request->InventoryStatus[] = $inventoryStatus;


    $response = $service->reviseInventoryStatus($request);

    if (isset($response->Errors)) {
        foreach ($response->Errors as $error) {
            printf("%s: %s\n%s\n\n",
                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                $error->ShortMessage,
                $error->LongMessage
            );
        }
    }

    if ($response->Ack !== 'Failure') {
        foreach ($response->InventoryStatus as $inventoryStatus) {
            printf("Quantity for [%s] is %s\n\n with Price %3\$.2f",
                $inventoryStatus->ItemID,
                $inventoryStatus->Quantity,
    			$inventoryStatus->StartPrice->value
            );
        $ebay_item_id = $inventoryStatus->ItemID;
        $this->session->set_userdata('ebay_item_id', $ebay_item_id);
    		
        }
    }
}// end foreach