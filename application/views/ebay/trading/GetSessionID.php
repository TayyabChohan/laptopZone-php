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
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
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
$request = new Types\GetSessionIDRequestType();
$request->RuName ="Sajid_Khan-SajidKha-eRasha-rzapayttt";

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
$response = $service->GetSessionID($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        $data['SeverityCode'] = "$error->SeverityCode";
        $data['ShortMessage'] = "$error->ShortMessage";
        $data['LongMessage'] = "$error->LongMessage";
        $data['ErrorCode'] = "$error->ErrorCode";
        // printf(
        //     "%s: %s\n%s\n\n",
        //     $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
        //     $error->ShortMessage,
        //     $error->LongMessage
        // );
        
    }
    $data["status"] = false;
    echo json_encode($data);
    return json_encode($data);
    // return 0;
}

if ($response->Ack !== 'Failure') {
    //printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));//The official eBay time is: 13:01 (GMT) on Monday 1st October 2018 
    $sessionid = $response->SessionID;
    //$endDate = $response->Timestamp->format('Y-m-d H:i:s');
    //$endDate= "TO_DATE('".$endDate."', 'YYYY-MM-DD HH24:MI:SS')";

    // $user_id = $this->session->userdata('user_id');
    // $merchant_id = $this->session->userdata('merchant_id');
            $acct_id = $_GET["acct_id"];
            $user_id = $_GET['id'];
            $merchant_id = $_GET['mid'];
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

    $this->db->query("DELETE FROM LJ_EBAY_SESSIONS_MT WHERE ACCT_ID = '$acct_id'");


      $this->db->query("INSERT INTO LJ_EBAY_SESSIONS_MT (SESSION_MT_ID, SESSION_ID, ACCT_ID, CREATED_DATE,CREATED_BY) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_EBAY_SESSIONS_MT','SESSION_MT_ID'),'$sessionid',$acct_id ,$current_date,'$user_id')");
      $data["status"] = true;  
      $data["session_success"] = "Please Login eBay Account";
        echo json_encode($data);
        return json_encode($data);
    //   return 1;
}
?>