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
use \DTS\eBaySDK\ReturnManagement\Services;
use \DTS\eBaySDK\ReturnManagement\Types;
use \DTS\eBaySDK\ReturnManagement\Enums;

/**
 * Create the service object.
 */
$service = new Services\ReturnManagementService([
    'credentials' => $config['production']['credentials'],
    'authToken'   => $config['production']['authToken']
]);

/**
 * Create the request object.
 */
$request = new Types\GetVersionRequest();

/**
 * Send the request.
 */
$response = $service->getVersion($request);

/**
 * Output the result of calling the service operation.
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
    printf("The current version is: %s\n", $response->version);
}
