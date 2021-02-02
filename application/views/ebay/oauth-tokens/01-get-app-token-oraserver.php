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

$config = require __DIR__.'/../configuration_modified.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\OAuth\Services;
use \DTS\eBaySDK\OAuth\Types;

/**
 * Create the service object.
 */
$service = new Services\OAuthService([
    'credentials' => $config['production1']['credentials'],
    'ruName'      => $config['production1']['ruName'],
    'production'     => true
]);

/**
 * Send the request.
 */
$response = $service->getAppToken();
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    // exit;
/**
 * Output the result of calling the service operation.
 */
//printf("\nStatus Code: %s\n\n", $response->getStatusCode());
if ($response->getStatusCode() !== 200) {
    printf(
        "%s: %s\n\n",
        $response->error,
        $response->error_description
    );
} else {
    // printf(
    //     "%s\n%s\n%s\n%s\n\n",
    //     $response->access_token,
    //     $response->token_type,
    //     $response->expires_in,
    //     $response->refresh_token
    // );

    $access_token = $response->access_token;
    $token_type = $response->token_type;
   $expires_in = $response->expires_in;
    $refresh_token = $response->refresh_token;
    //$get_acc = $this->session->userdata('account_type');
       
    $this->db->query("UPDATE LZ_SELLER_ACCTS SET APP_AOUTH_TOKEN = '$access_token',TOKEN_TYPE = '$token_type' , EXPIRES_IN = '$expires_in', REFRESH_TOKEN = '$refresh_token', UPDATED = SYSDATE WHERE LZ_SELLER_ACCT_ID = 2");
     $this->db->query("UPDATE LZ_EBAY_DEV_CREDENTIALS_DT SET APP_OAOUTH_TOKEN = '$access_token',TOKEN_TYPE = '$token_type' , REFRESH_TOKEN = '$refresh_token', LAST_UPDATED_OAOUTH = SYSDATE WHERE USER_ID = $user_id");
}
