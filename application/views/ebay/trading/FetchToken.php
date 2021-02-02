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
// $Data = json_decode(file_get_contents('php://input'),true);
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

/*===============================================
=            get merchant session id            =
===============================================*/
// $merchant_id = $_GET['mid'];
$ACCT_ID = $_GET['acct_id'];
// $merchant_id = 10000000056;
// $merchat_id = $this->session->userdata('merchat_id');

$session_qry = $this->db->query("SELECT SESSION_ID FROM LJ_EBAY_SESSIONS_MT WHERE ACCT_ID = $ACCT_ID")->result_array();
if(count($session_qry) > 0){
    $session_id = $session_qry[0]['SESSION_ID'];
}else{
    $data['errorToken'] = "Generate Token Please";
    // die("Session ID not found");
    echo json_encode($data);
    return json_encode($data);
}


/*=====  End of get merchant session id  ======*/

/**
 * Create the request object.
 */
$request = new Types\FetchTokenRequestType();
$request->SessionID = $session_id;
//$request->SecretID ="Sajid_Khan-SajidKha-eRasha-rzapayttt";

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
$response = $service->FetchToken($request);
// $data['data'] = "$response";
// echo json_encode($data['data']);
// return json_encode($data['data']);

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
        // // printf(
        //     "%s: %s\n%s\n\n",
        //     $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
        //     $error->ShortMessage,
        //     $error->LongMessage
        // );
        
    }
    echo json_encode($data);
    return json_encode($data);
}

if ($response->Ack !== 'Failure') {
         //printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));//The official eBay time is: 13:01 (GMT) on Monday 1st October 2018 
    $eBayAuthToken = $response->eBayAuthToken;
    $tokenExpiry = $response->HardExpirationTime->format('Y-m-d H:i:s');
    $tokenExpiry = "TO_DATE('".$tokenExpiry."', 'YYYY-MM-DD HH24:MI:SS')";
        // $createdDate1 = $response->Timestamp->format('Y-m-d H:i:s');
        // $createdDate= "TO_DATE('".$createdDate1."', 'YYYY-MM-DD HH24:MI:SS')";
            $ACCT_ID = $_GET['acct_id'];
        // $user_id = $Data['user_id'];
        // $account_name = $Data['account_name'];
        // $portal_id = $Data['portal_id'];
    // $user_id = $this->session->userdata('user_id');
    // $account_name = $this->session->userdata('account_name');
    // $portal_id = $this->session->userdata('portal_id');
    date_default_timezone_set("America/Chicago");
    $current_date = date("d-M-y");

    // $eBayAuthToken = "sadasd3wqdsx3as";
    // $tokenExpiry =  "$createdDate"; 
   
    // $this->db->query("INSERT INTO LZ_MERHCANT_ACC_DT (ACCT_ID, MERCHANT_ID, ACCOUNT_NAME, PORTAL_ID, TOKEN, TOKEN_EXPIRY, INSERTED_DATE, INSERTED_BY) VALUES (GET_SINGLE_PRIMARY_KEY('LZ_MERHCANT_ACC_DT','ACCT_ID'),'$merchat_id','$account_name','$portal_id','$eBayAuthToken',$tokenExpiry,$current_date,'$user_id')");
    $this->db->query("UPDATE LJ_MERHCANT_ACC_DT SET TOKEN = '$eBayAuthToken', TOKEN_EXPIRY = $tokenExpiry where ACCT_ID = '$ACCT_ID'");
    $expir_date= $this->db->query("SELECT TOKEN_EXPIRY from LJ_MERHCANT_ACC_DT WHERE ACCT_ID = '$ACCT_ID' ")->row();
    // $date = date("d-M-y");
    $token = "$response->eBayAuthToken";
    // $date_expir =  $response->HardExpirationTime->format('Y-m-d H:i:s');
    // $date = "$response->HardExpirationTime->format('Y-m-d H:i:s')";
    $data['tokenSuccess'] = "Your Token is Generated";
    $data['token'] = $token;
    $data['expirydata'] = $expir_date->TOKEN_EXPIRY;
    echo  json_encode($data);
    return json_encode($data);
}
?>