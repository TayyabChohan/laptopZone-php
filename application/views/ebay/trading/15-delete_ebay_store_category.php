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
    'credentials' => $config['sandbox']['credentials'],
    'siteId'      => Constants\SiteIds::US,
    'sandbox'     => true
]);

/**
 * Create the request object.
 */
$request = new Types\SetStoreCategoriesRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['sandbox']['authToken'];

// You must replace the example category IDs with values that are valid for your store.
$request->Action = 'Delete';
$request->ItemDestinationCategoryID = 442404;
$request->StoreCategories = new Types\StoreCustomCategoryArrayType();
$category = new Types\StoreCustomCategoryType();
$category->CategoryID = 19227;
$request->StoreCategories->CustomCategory[] = $category;
$category = new Types\StoreCustomCategoryType();
$category->CategoryID = 19228;
$request->StoreCategories->CustomCategory[] = $category;

/**
 * Send the request.
 */
$response = $service->SetStoreCategories($request);

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
    printf(
        "Status: %s\nTask ID: %s\n",
        $response->Status,
        $response->TaskID
    );
}
