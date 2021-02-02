<?php
/**
 * Copyright 2017 David T. Sadler
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
use \DTS\eBaySDK\Product\Services;
use \DTS\eBaySDK\Product\Types;
use \DTS\eBaySDK\Product\Enums;

/**
 * Create the service object.
 */
$service = new Services\ProductService([
    'credentials' => $config['production']['credentials'],
    'globalId'    => Constants\GlobalIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\FindProductsRequest();

//$request->productSearch[] = new Types\ProductRequest();
//$request->productIdentifier->ePID = '193042315';

$ProductRequest = new Types\ProductRequest();
//$ProductRequest->keywords = '263745964184';
$ProductRequest->keywords = 'iphone 7 plus';
$ProductRequest->invocationId = '264156844';//random number
$ProductRequest->dataset = ['DisplayableProductDetails'];

$request->productSearch[] = $ProductRequest;

// $propertyFilter =  new Types\PropertyValue();
// $propertyFilter->propertyName = 'UPC';
// $propertyValue =  new Types\Value();
// $propertyValue->value =  ;
// $propertyFilter->value->text->value = '045496891985';

// $request->productSearch->propertyFilter = $propertyFilter;


//$request->dataset = ['DisplayableProductDetails'];
//$request->productSearch->keywords = '263745964184';
//$request->productSearch->categoryId = '182180';

/**
 * Assign the ePID.
 */
// $request->productIdentifier = new Types\ProductIdentifier();
// $request->productIdentifier->ePID = '193042315';

/**
 * Limit the results to 10 items per page.
 */
$request->productSearch->paginationInput = new Types\PaginationInput();
$request->productSearch->paginationInput->entriesPerPage = 10;

$pageNum = 1;

do {
    $request->productSearch->paginationInput->pageNumber = $pageNum;

    /**
     * Send the request.
     */
    $response = $service->FindProducts($request);
echo "<pre>";
print_r($response);
echo "</pre>";exit;
    /**
     * Output the result of calling the service operation.
     */
    echo "\n\n==================\nResults for page $pageNum\n==================\n";

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
        foreach ($response->compatibilityDetails as $details) {
            echo "\n\n==================\nCompatibility\n==================";
            foreach ($details->productDetails as $detail) {
                printf("\n%s :", $detail->propertyName);
                foreach ($detail->value as $value) {
                    printf(
                        "%s %s %s ",
                        isset($value->number) ? $value->number->value : '',
                        isset($value->text) ? $value->text->value : '',
                        isset($value->URL) ? $value->URL->value : ''
                    );
                }
            }
        }
    }

    $pageNum += 1;

} while (isset($response->compatibilityDetails) && $pageNum <= $response->paginationOutput->totalPages);
