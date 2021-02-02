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
//$config = require __DIR__.'/../configuration.php';
$config = require __DIR__.'/../configuration_modified.php';

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
//$itemID = '110179445537';
//$ebay_id = $this->session->userdata('ebay_item_id');
//$this->session->unset_userdata('ebay_item_id');




foreach ($seed_data as $row)
{
    $itemID = $row['EBAY_ID']; 
    $epid = $row['EPID']; 
    $check_if = true;
    if($check_if)
    {
                   /**
         * Create the service object.
         */
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
        /*======================================================
        =            copy from add fixed price item            =
        ======================================================*/
        // $CONDITION= (int)$row['DEFAULT_COND'];
        // $UPC = $row['UPC'];
        // $PART_NO = $row['PART_NO'];
        // $TITLE= $row['ITEM_TITLE'];
        // $DESC=$row['ITEM_DESC'];
        // $PRICE= (double)$row['EBAY_PRICE'];
        // $CURRENCY= $row['CURRENCY'];
        // $CATEGORYID = $row['CATEGORY_ID'];
        // $ZIP_CODE= $row['SHIP_FROM_ZIP_CODE'];
        // $LOCATION= $row['SHIP_FROM_LOC'];
        // $DETAIL_CONDITION= $row['DETAIL_COND'];
        // $PAYMENTMETHOD = $row['PAYMENT_METHOD'];
        // $EMAIL = $row['PAYPAL_EMAIL'];
        // $DISPATCH_TIME= (int)$row['DISPATCH_TIME_MAX'];
        // $SHIP_COST = (int)$row['SHIPPING_COST'];
        // $ADD_COST = (int)$row['ADDITIONAL_COST'];
        // $RETURN_OPT = $row['RETURN_OPTION'];
        // $RETURN_DAYS = (int)$row['RETURN_DAYS'];
        // $SHIP_PAID_BY = $row['SHIPPING_PAID_BY'];
        // $SHIP_SERVICE = $row ['SHIPPING_SERVICE'];
        // $SKU = $row['SKU'];
        // $MANUFACTURE = $row['MANUFACTURE'];
        // $WEIGHT = (double)$row['WEIGHT'];
        // $GENERAL_RULE = $row['GENERAL_RULE'];
        // $SPECIFIC_RULE = $row['SPECIFIC_RULE'];

        /*====================================================
        =            disabe catalogue information            = 
        ====================================================*/
        $item->ProductListingDetails = new Types\ProductListingDetailsType();
        $item->ProductListingDetails->ProductReferenceID = $epid;//this is epid use when ebay doesnt allow us to list an item withput ebay catalog detail
        // You must select a product from the eBay catalog when listing Apple items in the Tablets & eBook Readers category.
        $item->ProductListingDetails->IncludeeBayProductDetails = true;// must be ture if epid is given
        $item->ProductListingDetails->IncludeStockPhotoURL = false;// to avoid sbay catalog photo set this to false

/*=====  End of disabe catalogue information  ======*/


/*=====================================
=          Start of Weight section     =
=======================================*/
// if(!empty($WEIGHT) && $WEIGHT > 0){
//         if($WEIGHT >= 16){
//             $WEIGHT = $WEIGHT / 16;
//             $WEIGHT = number_format((float)@$WEIGHT,2,'.',',');
//             $WEIGHT = explode('.', $WEIGHT);
//             $WeightMajor = (int)$WEIGHT[0];  
//             $WeightMinor = (int)$WEIGHT[1] / 100; 

//             $packageDetails = new Types\ShipPackageDetailsType();
//             $packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
//             $packageDetails->WeightMajor = new Types\MeasureType();
//             $packageDetails->WeightMajor->unit = 'lbs';
//             $packageDetails->WeightMajor->value = $WeightMajor;
//             $packageDetails->WeightMinor = new Types\MeasureType([
//                 'unit' => 'oz',
//                 'value' => (int)$WeightMinor
//             ]);  
//         }else{
           
//             $packageDetails = new Types\ShipPackageDetailsType();
//             $packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
//             $packageDetails->WeightMajor = new Types\MeasureType();
//             $packageDetails->WeightMajor->unit = 'lbs';
//             $packageDetails->WeightMajor->value = 0;
//             $packageDetails->WeightMinor = new Types\MeasureType([
//                 'unit' => 'oz',
//                 'value' => (int)$WEIGHT
//             ]);  
//         }
       
//         $item->ShippingPackageDetails = $packageDetails;
// }
/*=====  End of Weight section  ======*/


/*=====  End of copy from add fixed price item  ======*/

        $request->Item = $item;

        $response = $service->ReviseFixedPriceItem($request);

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
                    //exit;
                    $error_msg = $error->ShortMessage;
                    echo "Error! - Item ID:".$itemID." not Revised".PHP_EOL;
                    $this->db->query("UPDATE LZ_ACTIVE_LISTING_TEMP T SET T.REVISE_CALL = 1 , T.ERROR_MSG = '$error_msg'  WHERE T.EBAY_ID = '$itemID' "); 
                }else{
                    //$this->session->set_userdata('ebay_error', false);
                }
                
            }

        }

        if ($response->Ack !== 'Failure') {

            $ebay_item_id = $response->ItemID;
            $this->db->query("UPDATE LZ_ACTIVE_LISTING_TEMP T SET T.REVISE_CALL = 1 , T.ERROR_MSG = '' WHERE T.EBAY_ID = '$itemID' "); 

            echo "Item ID:".$ebay_item_id." Revised Successfully".PHP_EOL;

        }else{

        }//end success if
     
    
    }//condition check if close
  // break; 
}// end main foreach

?>