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
    $request = new Types\SearchCancellationsRestRequest();

    //$request->epid = '232669172'; // Apple iPhone 7
    //$request->epid = '1607673760';
    // $request->return_state = "RETURN_STARTED";
    //$request->return_state = "ALL_OPEN";



    /**
     * Send the request.
     */
    $response = $service->SearchCancellations($request);
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
                $error->longMessage
            );
            echo PHP_EOL;
        }
    }

    if (count($response->cancellations) > 0) {

        foreach ($response->cancellations as $cancel) {
            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

            $ebay_cancel_id = $cancel->cancelId;
            $marketplace_id = $cancel->marketplaceId;
            $legacy_order_id = $cancel->legacyOrderId;
            $requestor_type = $cancel->requestorType;
            $cancel_reason = $cancel->cancelReason;
            $cancel_state = $cancel->cancelState;
            $cancel_status = $cancel->cancelStatus;
            $cancel_close_reason = $cancel->cancelCloseReason;
            $payment_status = $cancel->paymentStatus;
            
            
            $alreadyExit = $this->db->query("SELECT * FROM LJ_CANCELLATION_MT C WHERE C.EBAY_CANCEL_ID = $ebay_cancel_id")->result_array();

            if(!$alreadyExit){

                $cancel_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_MT','CANCELLATION_ID') CANCELLATION_ID FROM DUAL")->result_array();
                $cancel_id = $cancel_id[0]['CANCELLATION_ID'];

                $this->db->query("INSERT INTO LJ_CANCELLATION_MT C (C.CANCELLATION_ID,
                C.EBAY_CANCEL_ID,
                C.MARKETPLACE_ID,
                C.REQUESTOR_TYPE,
                C.CANCEL_STATE,
                C.CANCEL_STATUS,
                C.CANCEL_CLOSE_REASON,
                C.PAYMENT_STATUS,
                C.CANCEL_REASON,
                C.LEGACY_ORDER_ID,
                C.CREATED_AT,
                C.CREATED_BY,
                C.ACCOUNT_ID,
                C.STATUS)
                values ($cancel_id,
                $ebay_cancel_id,
                '$marketplace_id',
                '$requestor_type',
                '$cancel_state',
                '$cancel_status',
                '$cancel_close_reason',
                '$payment_status',
                '$cancel_reason',
                '$legacy_order_id',
                 $insert_date,
                 $userId,
                 $merchant_id,
                 '0'
                )");
                 $barcodes = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.ORDER_ID = (SELECT DT.ORDER_ID FROM LZ_SALESLOAD_DET DT WHERE DT.EXTENDEDORDERID =  '$legacy_order_id') ")->result_array();
                 foreach($barcodes as $bar){
                     $barcode = $bar['BARCODE_NO'];
                 $this->db->query("INSERT INTO LJ_CANCELLATION_DT CD (CD.CANCELLATION_DT_ID,
                                                                 CD.CANCELLATION_ID,
                                                                 CD.BARCODE_NO)
                                                                 values (
                                                                     GET_SINGLE_PRIMARY_KEY('LJ_CANCELLATION_DT','CANCELLATION_DT_ID'),
                                                                     $cancel_id,
                                                                     $barcode) ");
                 
                 }
            }else{
                $cancellation_id = $alreadyExit[0]['CANCELLATION_ID'];
                $this->db->query("UPDATE LJ_CANCELLATION_MT C 
                SET
                C.EBAY_CANCEL_ID = $ebay_cancel_id,
                C.MARKETPLACE_ID = '$marketplace_id',
                C.REQUESTOR_TYPE = '$requestor_type',
                C.CANCEL_STATE   = '$cancel_state',
                C.CANCEL_STATUS  = '$cancel_status',
                C.CANCEL_CLOSE_REASON = '$cancel_close_reason',
                C.PAYMENT_STATUS = '$payment_status',
                C.CANCEL_REASON = '$cancel_reason',
                C.LEGACY_ORDER_ID = '$legacy_order_id',
                C.ACCOUNT_ID = $merchant_id,
                C.STATUS = '0'
                WHERE C.CANCELLATION_ID = $cancellation_id");
            }

               
            


            
        }


     
    }//if (count($response->members) > 0) 
//}//end data main foreach