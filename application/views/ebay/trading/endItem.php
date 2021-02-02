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
require __DIR__ . '/../vendor/autoload.php';

/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
$config = require __DIR__ . '/../configuration.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Trading\Enums;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;

/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config['production']['credentials'],
    'siteId' => $site_id,
    //'siteId'      => Constants\SiteIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\EndItemRequestType();
$request->ItemID = $ebay_id;
$request->EndingReason = 'OtherListingError';
// more endreson code on given link
//http://developer.ebay.com/devzone/xml/docs/reference/ebay/types/EndReasonCodeType.html

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

/**
 * Send the request.
 */
$response = $service->EndItem($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
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
    return 0;
}

if ($response->Ack !== 'Failure') {
    //printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));//The official eBay time is: 13:01 (GMT) on Monday 1st October 2018
    $endDate = $response->Timestamp->format('Y-m-d H:i:s');
    $endDate = "TO_DATE('" . $endDate . "', 'YYYY-MM-DD HH24:MI:SS')";
    if (empty(@$user_id)) {
        $user_id = $this->session->userdata('user_id');
    }
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date = "TO_DATE('" . $current_date . "', 'YYYY-MM-DD HH24:MI:SS')";

    $pk_query = $this->db->query("SELECT  GET_SINGLE_PRIMARY_KEY('LZ_ENDITEM_LOG','LOG_ID') ID FROM DUAL")->result_array();

    $log_id = $pk_query[0]['ID'];

    $ins = $this->db->query("INSERT INTO LZ_ENDITEM_LOG (LOG_ID, EBAY_ID, ENDED_BY, ENDED_DATE, INSERT_DATE,REMARKS) VALUES ($log_id,'$ebay_id',$user_id,$endDate,$current_date,'$remarks')");

    if ($ins) {

        $end_proc = $this->db->query("call  pro_insert_ebay_log($ebay_id,$log_id)");

        if ($end_proc) {
            return 1;
        } else {
            return 2;
        }

    }

}
