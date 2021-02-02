<style>
a.prnt_btn {
    background-color: #3c8dbc;
    border-color: #367fa9;
    border-radius: 3px;
    -webkit-box-shadow: none;
    box-shadow: none;
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    border: 1px solid transparent;
    text-decoration: none;
    color: #fff;
}
</style>
<?php
//include "08-upload-picture-test.php";
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
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

/**
 * Specify the numerical site id that we want the listing to appear on.
 *
 * This determines the validation rules that eBay will apply to the request.
 * For example, it will determine what categories can be specified, the values
 * allowed as shipping services, the visibility of the item in some searches and other
 * information.
 *
 * Note that due to the risk of listing fees been raised this example will list the item
 * to the production site.
 */
if(!empty(@$seed_data[0]['EBAY_LOCAL'])){
    $siteId = $seed_data[0]['EBAY_LOCAL'];
}else{
    $siteId = Constants\SiteIds::US;    
}

//$itemID = '110179445537';
//$ebay_id = $this->session->userdata('ebay_item_id');
//$this->session->unset_userdata('ebay_item_id');
$itemID = $ebay_id;
$sold_qty = '';
if($process == "getQuantity"){

if(!empty($itemID)){
 // ========================= Start Get item call to get current listing quantity================
    $service = new Services\TradingService([    
        'credentials' => $config['production']['credentials'],
        'siteId'      => $siteId 
    ]);
    $request = new Types\GetItemRequestType() ;
    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
    $request->ItemID = $itemID;
    $request->DetailLevel = ['ItemReturnAttributes'];
    $response = $service->getItem($request);

    if (isset($response->Errors)) {
        foreach ($response->Errors as $error) {
            printf(
                "%s: %s\n%s\n\n",
                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                $error->ShortMessage,
                $error->LongMessage
            );
        }
    }
    if ($response->Ack !== 'Failure') {
        $item = $response->Item;
        $sold_qty = $item->SellingStatus->QuantitySold;
        $total_qty = $item->Quantity;
        $current_qty = $total_qty - $sold_qty;
        $api_title = $item->Title;
        $api_title = trim(strtolower($api_title));
        $api_title = preg_replace('!\s+!', ' ', $api_title);//remove extra spaces
        $api_title = str_replace(array("'",'"'), "", $api_title);//remove single & double quote
        $api_cond = (int)$item->ConditionID;

        $this->session->set_userdata("currentQty",$current_qty);
    }else{
        $this->session->set_userdata("message","API Failure");
    }
}else{
        $this->session->set_userdata("message","Unable to Revise item.Ebay ID not found");
}
}
// ======================== End Get Item Call ==============================

if($process == "revise"){
  
    if(!empty(@$currentQty))
    {
        $QUANTITY = (int)$returnQty-(int)$currentQty;
    }
      
        // ================== Revised APi Call Start =======================//
        $service = new Services\TradingService([
            'credentials' => $config['production']['credentials'],
            'production'     => true,
            'siteId'      => $siteId
        ]);

        $request = new Types\ReviseFixedPriceItemRequestType();

        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

        $item = new Types\ItemType();
        $item->ItemID = $itemID;
        $item->Quantity = $QUANTITY; 
        
        /*===========================================
        =            execute revise call            =
        ===========================================*/
        
            $request->Item = $item;

            $response = $service->ReviseFixedPriceItem($request);

            if (isset($response->Errors)) {
                foreach ($response->Errors as $error) {
                    
                    //echo $error->SeverityCode;
                    if($error->SeverityCode == "Error"){

                        $this->session->set_userdata('ebay_error', true);
                        printf("%s: %s\n%s\n\n",
                        $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                        $error->ShortMessage,
                        $error->LongMessage
                    );
                        //exit;
                    }else{
                        $this->session->set_userdata('ebay_error', false);
                    }
                    
                }
            }

            if ($response->Ack !== 'Failure') {
 
                $ebay_item_id = $response->ItemID;
                $this->session->set_userdata('message', true);

            }else{
                
                $this->session->set_userdata('message',$response);
            }//end success if
}
        /*=====  End of execute revise call  ======*/

?>