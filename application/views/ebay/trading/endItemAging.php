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
// $account_id = 1;
// $lz_seller_id = $account_id;
$data = $this->db->query("SELECT ACTIVE_LIST_ID,
       MAX(ITEM_ID) EBAY_ID,
       MAX(SELLER_ACCOUNT) SELLER_ACCOUNT,
       MAX(SITE_LISTED) SITE_LISTED
  FROM (SELECT D.BARCODE_NO, L.ACTIVE_LIST_ID, L.ITEM_ID, L.SELLER_ACCOUNT , L.SITE_LISTED
          FROM LJ_BIN_VERIFY_DT D, LZ_BARCODE_MT B, LJ_EBAY_ACTIVE_LISTING L
         WHERE D.BARCODE_NO = B.BARCODE_NO
           AND B.EBAY_ITEM_ID = L.ITEM_ID
           AND L.ITEM_ENDED = 0
           AND L.ITEM_ID = 223349587398
           )
 GROUP BY ACTIVE_LIST_ID
 ORDER BY ACTIVE_LIST_ID ASC")->result_array(); // 3rd query
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
foreach ($data as $ebayItem ) {

$active_list_id = $ebayItem['ACTIVE_LIST_ID'];
$ebay_id = $ebayItem['EBAY_ID'];
$account_id = $ebayItem['SELLER_ACCOUNT'];
$site_id = $ebayItem['SITE_LISTED'];

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
    'siteId'      => $site_id
    //'siteId'      => Constants\SiteIds::US
]);

/**
 * Create the request object.
 */
$request = new Types\EndItemRequestType();
$request->ItemID =$ebay_id;
$request->EndingReason ='OtherListingError';
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
    $endDate= "TO_DATE('".$endDate."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $current_date = date("Y-m-d H:i:s");
    $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

    $this->db->query("INSERT INTO LZ_ENDITEM_LOG (LOG_ID, EBAY_ID, ENDED_BY, ENDED_DATE, INSERT_DATE,REMARKS) VALUES (GET_SINGLE_PRIMARY_KEY('LZ_ENDITEM_LOG','LOG_ID'),'$ebay_id',$user_id,$endDate,$current_date,'$remarks')");
    //$data = $this->db->query("DECLARE RESPONSE VARCHAR2(200); BEGIN pro_processAgingItemSingle('1',RESPONSE); DBMS_OUTPUT.put_line(RESPONSE); END;")->result_array();
    $this->db->query("call pro_processAgingItemSingle('$active_list_id')");

    $this->db->query("UPDATE LZ_BARCODE_MT B SET B.ENDED_BARCODE = 1 , B.LIST_ID = '',B.EBAY_ITEM_ID='' WHERE B.EBAY_ITEM_ID = '$ebay_id'AND B.SALE_RECORD_NO IS NULL AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND B.LZ_PART_ISSUE_MT_ID IS NULL AND B.LZ_POS_MT_ID IS NULL AND B.PULLING_ID IS NULL"); 


    return 1;
}

} // end foreach ($data as $ebayItem ) 
?>