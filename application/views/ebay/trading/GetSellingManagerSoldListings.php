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
//$date = new DateTime('now');
$request = new Types\GetSellingManagerSoldListingsRequestType();
// Notice that we use [] because Filter is array like and we are pushing values into it.

$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

//$request->Filter[] = 'PaidShipped';
//$request->Filter[] = 'PaymentOverDue';
// Notice that we no longer need [] because we are assigning an array to the property.
$request->Filter = ['PaidNotShipped'];
//$request = new Types\GeteBayOfficialTimeRequestType();

/**
 * An user token is required when using the Trading service.
 */
// $request->SaleDateRange = new Types\TimeRangeType();
// $request->SaleDateRange->TimeTo = $date;
// $request->SaleDateRange->TimeFrom = $date->modify('-120 days');
$request->Pagination = new Types\PaginationType();
$request->Pagination->EntriesPerPage = 200;
$request->Sort = Enums\SellingManagerSoldListingsSortTypeCodeType::C_PAID_DATE;
//$request->Filter[] = 'NotShipped';
//$request->Filter[] = 'Unshipped';

$requestPageNum = 1;


/**
 * Send the request.
 */
$response = $service->GetSellingManagerSoldListings($request);

echo "<pre>";
        print_r($response);
        echo "</pre>";
        exit;

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
    printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
}
