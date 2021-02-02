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
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Finding\Services;
use \DTS\eBaySDK\Finding\Types;
use \DTS\eBaySDK\Finding\Enums;

/**
 * Create the service object.
 */
$service = new Services\FindingService([
    'credentials' => $config['production']['credentials'],
    'globalId'    => Constants\GlobalIds::US
]);

/**
 * Create the request object.
 */

$request = new Types\FindItemsAdvancedRequest();
//var_dump($data);exit;
/**
 * Assign the keywords.
 */
$upc = TRIM($data[0]['UPC']);
$mpn = TRIM($data[0]['MPN']);
$brand = TRIM($data[0]['ITEM_MT_MANUFACTURE']);

if(empty($revise_ebay_id)){ // if ebay id is not null than its a revise item call
    if(!empty($upc)){
        $request->keywords = $upc;// quote added for exact word search
    }elseif(!empty($mpn) && !empty($brand)){
        $brand = strtoupper($brand);
        if( $brand == 'NA' OR $brand == 'N/A' OR $brand == 'UNKNOWN'){
            $request->keywords = '"'.$mpn.'"';//quote removed 14-02-2018 // quote added again 28-05-2018
        }else{
            $request->keywords = $brand.' '.$mpn;//quote removed 14-02-2018 // quote added again 28-05-2018 //quote removed 24-10-2018
        }
    }elseif(!empty($mpn)){
        $request->keywords = '"'. $mpn.'"';
    }else{
        die("Can't List an item without MPN");
    }
    $request->categoryId =[$data[0]['CATEGORY_ID']];
    $request->outputSelector = ['UnitPriceInfo','SellerInfo'];
    $account_type = $this->session->userdata('account_type');
    if($account_type == 1)
    {
        $account_type = 'techbargains2015';
    }elseif($account_type == 2)
    {
        $account_type = 'dfwonline';
    }

    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'Seller';
    if(!empty($account_type)){
     $itemFilter->value[] = $account_type;   
    }else{
        redirect('login/login');
        //die('Your session has been expire. Please login Again.');
    }
    $request->itemFilter[] = $itemFilter;

    $itemFilter = new Types\ItemFilter();
    $itemFilter->name = 'Condition';
    $itemFilter->value[] =$data[0]['DEFAULT_COND'];
    $request->itemFilter[] = $itemFilter;
}else{
    $request->keywords = $revise_ebay_id;
    $request->outputSelector = ['UnitPriceInfo','SellerInfo'];
}
/**
 * Send the request.
 */

$response = $service->FindItemsAdvanced($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
/**
 * Output the result of the search.
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
    if($response->searchResult->count > 0){
        $ebay_id[]='';
        $title[]='';
        $item_url[]='';
        $condition_id[]='';
        $condition_Name[]='';
        $k = 0;
        foreach ($response->searchResult->item as $item) {
            /*=============================================
            =            Section comment block            =
            =============================================*/
            $ebay_id[$k]=$item->itemId;
            $title[$k]=$item->title;
            $item_url[$k]=$item->viewItemURL;
            $condition_id[$k]=$item->condition->conditionId;
            $condition_Name[$k]=$item->condition->conditionDisplayName;
            $account_name[$k]=$item->sellerInfo->sellerUserName;
            /*=====  End of Section comment block  ======*/
            $k++;

            
        }
        $this->session->set_userdata('check_item_id', true);
        //$this->session->set_userdata('ebay_item_id', $ebay_id);//unset in revisedfixedpriceitem
        $result['item'] = $item;
        $result['seed_id'] = $seed_id;
        $result['list_barcode'] = $list_barcode;
        $result['ebay_id'] = $ebay_id;
        $result['title'] = $title;
        $result['item_url'] = $item_url;
        $result['condition_id'] = $condition_id;
        $result['condition_Name'] = $condition_Name;
        $result['check_btn'] = $check_btn;
        $result['account_name'] = $account_name;
        $this->load->view('dekitting_pk_us/v_listing_confirm_pk_us',$result);
            exit;
            // var_dump($ebay_id,$title,$item_url,$condition_id,$condition_Name);
            // exit;
            //break;
    }else{//end if else $response->searchResult->count > 0 of finditemadvance
        $this->session->set_userdata('check_item_id', false);
    }
    

}//if end $response->ack !== 'Failure' of finditemadvance
