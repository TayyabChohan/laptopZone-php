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
//$config = require __DIR__.'/../configuration_modified.php';

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
$siteId = Constants\SiteIds::US;
if(!empty(@$site_id)){
    $siteId = $site_id;
}else{
    $siteId = Constants\SiteIds::US;    
}
//$itemID = '110179445537';
//$ebay_id = $this->session->userdata('ebay_item_id');
//$this->session->unset_userdata('ebay_item_id');



    // $itemID = $ebay_id; 
    // $itemID = $Quantity; 

        /**
         * Create the service object.
         */
        // ================== Revised APi Call Start =======================//
        $service = new Services\TradingService([
            'credentials' => $config['production']['credentials'],
            'production'     => true,
            'siteId'      => $siteId
        ]);

        $req = new Types\ReviseFixedPriceItemRequestType();

        $req->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $req->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

        $item = new Types\ItemType();
        $item->ItemID = $ebay_id;
        if($addQty){
            $item->Quantity = (int)$quantity;
        }else{
            $item->StartPrice = new Types\AmountType(['value' => (double)$price]);
        }

/*=====  End of copy from add fixed price item  ======*/

        $req->Item = $item;

        $response = $service->ReviseFixedPriceItem($req);
        // echo "<pre>";
        // print_r ($response);
        // echo "</pre>"; exit;
        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                
                //echo $error->SeverityCode;
                if($error->SeverityCode == "Error"){

                    //$this->session->set_userdata('ebay_error', true);
                    printf("%s: %s\n%s\n\n",
                    $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                    $error->ShortMessage,
                    $error->LongMessage
                );

                }else{
                    $this->session->set_userdata('ebay_error', false);
                }
                
            } // endforeach

        } //response error if closing

        if ($response->Ack !== 'Failure') {

            $ebay_item_id = $response->ItemID;
            if($addQty){
                $this->session->set_userdata('current_qty_adj', -1);
            }else{
                $this->session->set_userdata('ebay_item_id', $ebay_item_id);
            }
        }

?>