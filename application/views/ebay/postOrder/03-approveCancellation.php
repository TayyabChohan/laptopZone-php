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
// $config = require __DIR__.'/../configuration_modified.php';
$config = require __DIR__.'/../configuration.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\PostOrder\Services;
use \DTS\eBaySDK\PostOrder\Types;
use \DTS\eBaySDK\PostOrder\Enums;
use \DTS\eBaySDK\Constants;
/**
 * Create the service object.
 */
//  $service = new Services\PostOrderService([
// //     'authorization' => $config['production']['oauthUserToken']
//     'authorization' => $config['production']['authToken']
// //     //,'httpOptions' => ['debug' => true]
//  ]);
 $service = new Services\PostOrderService([
   'credentials' => $config['production']['credentials'],
   'authToken'   => $config['production']['authToken'],
   'production'     => false,
   'siteId'      =>  Constants\SiteIds::US
]);

// $service = new Services\PostOrderService([
//     'credentials' => $config['production']['credentials']
// ]);

// $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
// $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

$trans = array("′" => "''","’" => "''","'" => "''","＇" => "''");//use in strtr function 
//foreach ($data as $value) {
    //$categoryid = $value['CATEGORY_ID'];
    /**
     * Create the request object.
     */
    $request = new Types\ApproveCancellationRequestRestRequest();

    //$request->epid = '232669172'; // Apple iPhone 7
    //$request->epid = '1607673760';
    // $request->return_state = "RETURN_STARTED";
    $request->cancelId = "5143335158";



    /**
     * Send the request.
     */
    $response = $service->ApproveCancellationRequest($request);
// $test = json_decode($response->members[0]->sellerResponseDue->respondByDate,true);
// var_dump($test['value']);
    // echo "<pre>";
    // print_r($response->cancellations);
    // echo "</pre>";
    // exit;
    /**
     * Output the result of calling the service operation.
     */
    //printf("\nStatus Code: %s\n\n", $response->getStatusCode());
    if (isset($response->errors)) {
        foreach ($response->errors as $error) {
            printf(
                "%s: %s\n%s\n\n",
                $error->errorId,
                $error->message,
                $error->longMessage,
                $error->parameters->name
            );
            echo PHP_EOL;
        }
    }
    echo '<pre>'.$response.'</pre>';
exit;
    // if (count($response->cancellations) > 0) {

    //     foreach ($response->cancellations as $cancel) {
            


            
    //     }


     
    // }
//}//end data main foreach