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
$request->ItemID = ['192371130222'];
// , '232329688634', '162664304076', '162664117778', '232476257847', '332347542579', '272834576394', '282479812744', '292244542088', '292231722617', '282641363892', '272838593995', '372069554271'

/**
 * Specify that additional fields need to be returned in the response.
 */
$request->IncludeSelector = 'ItemSpecifics,Variations,Compatibility,Details';

/**
 * Send the request.
 */
$response = $service->GetMultipleItems($request);
echo "<pre>";
print_r($response);
echo "</pre>";
/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        printf(
            "%s: %s<br>%s<br><br>",
            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            $error->ShortMessage,
            $error->LongMessage
        );
    }
}

if ($response->Ack !== 'Failure') {
    foreach ($response->Item as $item) {
        $title = $item->Title;

        print("$title<br>");

        printf(
            "Quantity sold %s, quantiy available %s<br>",
            $item->QuantitySold,
            $item->Quantity - $item->QuantitySold
        );
    }
    // $item = $response->Item;
    // $title = $item->Title;

    // print("$title<br>");

    // printf(
    //     "Quantity sold %s, quantiy available %s<br>",
    //     $item->QuantitySold,
    //     $item->Quantity - $item->QuantitySold
    // );

    if (isset($item->ItemSpecifics)) {
        print("<br>This item has the following item specifics:<br><br>");

        foreach ($item->ItemSpecifics->NameValueList as $nameValues) {
            printf(
                "%s: %s<br>",
                $nameValues->Name,
                implode(', ', iterator_to_array($nameValues->Value))
            );
        }
    }

    if (isset($item->Variations)) {
        print("<br>This item has the following variations:<br>");

        foreach ($item->Variations->Variation as $variation) {
            printf(
                "<br>SKU: %s<br>Start Price: %s<br>",
                $variation->SKU,
                $variation->StartPrice->value
            );

            printf(
                "Quantity sold %s, quantiy available %s<br>",
                $variation->SellingStatus->QuantitySold,
                $variation->Quantity - $variation->SellingStatus->QuantitySold
            );

            foreach ($variation->VariationSpecifics as $specific) {
                foreach ($specific->NameValueList as $nameValues) {
                    printf(
                        "%s: %s<br>",
                        $nameValues->Name,
                        implode(', ', iterator_to_array($nameValues->Value))
                    );
                }
            }
        }
    }

    if (isset($item->ItemCompatibilityCount)) {
        printf("<br>This item is compatible with %s vehicles:<br><br>", $item->ItemCompatibilityCount);

        // Only show the first 3.
        $limit = min($item->ItemCompatibilityCount, 3);
        for ($x = 0; $x < $limit; $x++) {
            $compatibility = $item->ItemCompatibilityList->Compatibility[$x];
            foreach ($compatibility->NameValueList as $nameValues) {
                printf(
                    "%s: %s<br>",
                    $nameValues->Name,
                    implode(', ', iterator_to_array($nameValues->Value))
                );
            }
            printf("Notes: %s <br>", $compatibility->CompatibilityNotes);
        }
    }
}//main ack if end
