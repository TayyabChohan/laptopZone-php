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

/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config['sandbox']['credentials'],
    'sandbox'     => true,
    'siteId'      => $siteId
]);

/**
 * Create the request object.
 */
$request = new Types\AddItemRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['sandbox']['authToken'];

/**
 * Begin creating the auction item.
 */
$item = new Types\ItemType();

/**
 * We want a single quantity auction.
 * Otherwise known as a Chinese auction.
 */
$item->ListingType = Enums\ListingTypeCodeType::C_CHINESE;
$item->Quantity = 1;

/**
 * Let the auction run for 7 days.
 */
$item->ListingDuration = Enums\ListingDurationCodeType::C_DAYS_7;

/**
 * Start the auction at $8.99.
 * Note that we don't have to specify a currency as eBay will use the site id
 * that we provided earlier to determine that it will be United States Dollars (USD).
 */
$item->StartPrice = new Types\AmountType(['value' => 8.99]);
/**
 * State that the item will not sell if none of the bids meet the reserve price of $10.99
 */
$item->ReservePrice = new Types\AmountType(['value' => 10.99]);
/**
 * Let buyers end the auction immediately by purchasing the item at the Buy It Now price of $15.99
 * This also shows how we can specify the currency if we wanted to.
 */
$item->BuyItNowPrice = new Types\AmountType(['value' => 15.99, 'currencyID' => 'USD']);

/**
 * Provide a title and description and other information such as the item's location.
 */
$item->Title = 'Bits & Bobs';
$item->Description = '<h1>Bits & Bobs</h1><p>Just some &lt;stuff&gt; I found.</p>';
$item->Country = 'US';
$item->Location = 'Beverly Hills';
$item->PostalCode = '90210';
/**
 * This is a required field.
 */
$item->Currency = 'USD';

/**
 * Display a picture with the item.
 */
$item->PictureDetails = new Types\PictureDetailsType();
$item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
$item->PictureDetails->PictureURL = ['http://lorempixel.com/1500/1024/abstract'];

/**
 * List item in the Books > Audiobooks (29792) category.
 */
$item->PrimaryCategory = new Types\CategoryType();
$item->PrimaryCategory->CategoryID = '29792';

/**
 * Tell buyers what condition the item is in.
 * For the category that we are listing in the value of 1000 is for Brand New.
 */
$item->ConditionID = 1000;

/**
 * Buyers can use one of two payment methods when purchasing the item.
 * Visa / Master Card
 * PayPal
 * The item will be dispatched within 3 business days once payment has cleared.
 * Note that you have to provide the PayPal account that the seller will use.
 * This is because a seller may have more than one PayPal account.
 */
$item->PaymentMethods = [
    'VisaMC',
    'PayPal'
];
$item->PayPalEmailAddress = 'example@example.com';
$item->DispatchTimeMax = 3;

/**
 * Setting up the shipping details.
 * We will use a Flat shipping rate for both domestic and international.
 */
$item->ShippingDetails = new Types\ShippingDetailsType();
$item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;

/**
 * Create our first domestic shipping option.
 * Offer the Economy Shipping (1-10 business days) service for $2.00.
 */
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 1;
$shippingService->ShippingService = 'Other';
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 2.00]);
$item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

/**
 * Create our second domestic shipping option.
 * Offer the USPS Parcel Select (2-9 business days) for $3.00.
 */
$shippingService = new Types\ShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 2;
$shippingService->ShippingService = 'USPSParcel';
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 3.00]);
$item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

/**
 * Create our first international shipping option.
 * Offer the USPS First Class Mail International service for $4.00.
 * The item can be shipped Worldwide with this service.
 */
$shippingService = new Types\InternationalShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 1;
$shippingService->ShippingService = 'USPSFirstClassMailInternational';
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 4.00]);
$shippingService->ShipToLocation = ['WorldWide'];
$item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;

/**
 * Create our second international shipping option.
 * Offer the USPS Priority Mail International (6-10 business days) service for $5.00.
 * The item will only be shipped to the following locations with this service.
 * N. and S. America
 * Canada
 * Australia
 * Europe
 * Japan
 */
$shippingService = new Types\InternationalShippingServiceOptionsType();
$shippingService->ShippingServicePriority = 2;
$shippingService->ShippingService = 'USPSPriorityMailInternational';
$shippingService->ShippingServiceCost = new Types\AmountType(['value' => 5.00]);
$shippingService->ShipToLocation = [
    'Americas',
    'CA',
    'AU',
    'Europe',
    'JP'
];
$item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;

/**
 * The return policy.
 * Returns are accepted.
 * A refund will be given as money back.
 * The buyer will have 14 days in which to contact the seller after receiving the item.
 * The buyer will pay the return shipping cost.
 */
$item->ReturnPolicy = new Types\ReturnPolicyType();
$item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';
$item->ReturnPolicy->RefundOption = 'MoneyBack';
$item->ReturnPolicy->ReturnsWithinOption = 'Days_14';
$item->ReturnPolicy->ShippingCostPaidByOption = 'Buyer';

/**
 * Finish the request object.
 */
$request->Item = $item;

/**
 * Send the request.
 */
$response = $service->addItem($request);

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
        "The item was listed to the eBay Sandbox with the Item number %s\n",
        $response->ItemID
    );
}
