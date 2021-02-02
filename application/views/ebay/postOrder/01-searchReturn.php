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
    $request = new Types\SearchReturnsRestRequest();

    //$request->epid = '232669172'; // Apple iPhone 7
    //$request->epid = '1607673760';
    // $request->return_state = "RETURN_STARTED";
    //$request->return_state = "ALL_OPEN";
    $request->return_state = $return_value;



    /**
     * Send the request.
     */
    $response = $service->SearchReturns($request);
// $test = json_decode($response->members[0]->sellerResponseDue->respondByDate,true);
// // var_dump($test['value']);
//     echo "<pre>";
//     print_r($response);
//     echo "</pre>";
//     exit;
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

    if (count($response->members) > 0) {

        foreach ($response->members as $member) {
            $returnid = $member->returnId;
            $buyerloginname = $member->buyerLoginName;
            $sellerloginname = $member->sellerLoginName;
            $currenttype = $member->currentType;
            $state = $member->state;
            $status = $member->status;
            $itemid = $member->creationInfo->item->itemId;
            $transactionid = $member->creationInfo->item->transactionId;
            $returnquantity = $member->creationInfo->item->returnQuantity;
            $type = $member->creationInfo->type;
            $reason = $member->creationInfo->reason;
            $comments = $member->creationInfo->comments->content;
            $comments = strtr($comments, $trans);

            //$creationDate = $member->creationInfo->creationDate->date;
            $creationdate = json_decode($member->creationInfo->creationDate,true);
            $creationdate = str_split($creationdate['value'],19);
            $creationdate = str_replace('T'," ",$creationdate[0]);
            $creationdate= "TO_DATE('".$creationdate."', 'YYYY-MM-DD HH24:MI:SS')";

            $sellertotalrefund = $member->sellerTotalRefund->estimatedRefundAmount->value;
            $sellercurrency = $member->sellerTotalRefund->estimatedRefundAmount->currency;
            $buyertotalrefund = $member->buyerTotalRefund->estimatedRefundAmount->value;
            $buyercurrency = $member->buyerTotalRefund->estimatedRefundAmount->currency;
            $sellerresponsedue = $member->sellerResponseDue->activityDue;
            //$respondByDate = $member->sellerResponseDue->respondByDate->date;

            $sellerrespondbydate = json_decode($member->sellerResponseDue->respondByDate,true);
            $sellerrespondbydate = str_split($sellerrespondbydate['value'],19);
            $sellerrespondbydate = str_replace('T'," ",trim($sellerrespondbydate[0]));
            $sellerrespondbydate= "TO_DATE('".$sellerrespondbydate."', 'YYYY-MM-DD HH24:MI:SS')";
            $buyerresponsedue = $member->buyerResponseDue->activityDue;
            //$respondByDate = $member->buyerResponseDue->respondByDate->date;
            $buyerrespondbydate = json_decode($member->sellerResponseDue->respondByDate,true);
            $buyerrespondbydate = str_split($buyerrespondbydate['value'],19);
            $buyerrespondbydate = str_replace('T'," ",$buyerrespondbydate[0]);
            $buyerrespondbydate= "TO_DATE('".$buyerrespondbydate."', 'YYYY-MM-DD HH24:MI:SS')";
            $buyerescalationeligibilityinfo = $member->escalationInfo->buyerEscalationEligibilityInfo->eligible;
            $sellerescalationeligibilityinfo = $member->escalationInfo->sellerEscalationEligibilityInfo->eligible;
            $sellerAvailableOptions = $member->sellerAvailableOptions;
            // foreach ($sellerAvailableOptions as $sellerOptions) {
            //     $actionType = $sellerOptions->actionType;
            //     $actionURL = $sellerOptions->actionURL;
            // }
            $actionurl = $sellerAvailableOptions[0]->actionURL;

            $check = $this->db->query("SELECT * FROM LJ_ITEM_RETURNS A WHERE A.RETURNID = '$returnid'")->result_array();

            if(count($check) === 0){
                $this->db->query("INSERT INTO LJ_ITEM_RETURNS (ITEM_RET_ID, RETURNID, BUYERLOGINNAME, SELLERLOGINNAME, RETURN_TYPE, RETURN_STATE, STATUS, ITEMID, TRANSACTIONID, RETURNQUANTITY, TYPE, REASON, COMMENTS, CREATIONDATE, SELLERTOTALREFUND, SELLERCURRENCY, BUYERTOTALREFUND, BUYERCURRENCY, SELLERRESPONSEDUE, RESPONDBYDATE, BUYERESCALATIONINFO, SELLERESCALATIONINFO, ACTIONURL,BUYERRESPONSEDUE,BUYERRESPONDBYDATE,lz_seller_acct_id,INSERTED_DATE ) SELECT get_single_primary_key('LJ_ITEM_RETURNS','item_ret_id'), '$returnid', '$buyerloginname', '$sellerloginname', '$currenttype', '$state', '$status', '$itemid', '$transactionid', '$returnquantity', '$type', '$reason', '$comments', $creationdate, '$sellertotalrefund', '$sellercurrency', '$buyertotalrefund', '$buyercurrency', '$sellerresponsedue', $sellerrespondbydate, '$buyerescalationeligibilityinfo', '$sellerescalationeligibilityinfo', '$actionurl','$buyerresponsedue',$buyerrespondbydate,'$merchant_id',sysdate FROM DUAL WHERE NOT EXISTS (SELECT * FROM LJ_ITEM_RETURNS A WHERE A.RETURNID = '$returnid')");

            }else{
                $item_ret_id = $check[0]['ITEM_RET_ID'];
                $this->db->query("UPDATE LJ_ITEM_RETURNS SET BUYERLOGINNAME = '$buyerloginname', SELLERLOGINNAME = '$sellerloginname', RETURN_TYPE = '$currenttype', RETURN_STATE = '$state', STATUS = '$status', ITEMID = '$itemid', TRANSACTIONID = '$transactionid', RETURNQUANTITY = '$returnquantity', TYPE = '$type', REASON = '$reason', COMMENTS = '$comments', CREATIONDATE = $creationdate , SELLERTOTALREFUND = '$sellertotalrefund', BUYERTOTALREFUND = '$buyertotalrefund', SELLERRESPONSEDUE = '$sellerresponsedue', RESPONDBYDATE = $sellerrespondbydate, BUYERESCALATIONINFO = '$buyerescalationeligibilityinfo', SELLERESCALATIONINFO = '$sellerescalationeligibilityinfo', ACTIONURL = '$actionurl',BUYERRESPONSEDUE = '$buyerresponsedue',BUYERRESPONDBYDATE = $buyerrespondbydate WHERE ITEM_RET_ID = '$item_ret_id'");
                
            }
            
        }

        // $title = @$response->title;
        // $title = strtr($title, $trans);

        // $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_MT WHERE EPID = $epid");
        // if($qry->num_rows() == 0 ){
        //     $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_MT','EBAY_CATALOGUE_MT_ID') EBAY_CATALOGUE_MT_ID FROM DUAL");
        //     $get_pk = $get_pk->result_array();
        //     $ebay_catalogue_mt_id = $get_pk[0]['EBAY_CATALOGUE_MT_ID'];
            /*============================================
            =            insert data in table            =
            ============================================*/

        //     $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_MT (EBAY_CATALOGUE_MT_ID, EPID, PRIMARYCATEGORYID, CATEGORYID, TITLE, BRAND, DESCRIPTION, PRODUCTWEBURL, IMAGEURL, VERSION,INSERTEDDATE) VALUES ($ebay_catalogue_mt_id,$epid,$primarycategoryid,$categoryid,'$title','$brand','$description','$productweburl','$imageurl','$version',sysdate)");
        // }else{
        //     $qry = $qry->result_array();
        //     $ebay_catalogue_mt_id =  $qry[0]['EBAY_CATALOGUE_MT_ID'];
        // }
        /*=====  End of insert data in table  ======*/

     
    }//if (count($response->members) > 0) 
//}//end data main foreach