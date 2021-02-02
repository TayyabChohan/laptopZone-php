
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
        //$api_title = str_replace("'", "", $api_title);//remove single quote
        //$api_title = str_replace('"', "", $api_title);//remove double quote
        $api_cond = (int)$item->ConditionID;
    }
}else{
    die("Unable to Revise item.Ebay ID not found");
}
// ======================== End Get Item Call ==============================

foreach ($seed_data as $row)
{

   
    if(!empty(@$current_qty))
    {
        $QUANTITY = (int)$row['QUANTITY']+(int)$current_qty;
    }else{
        $QUANTITY = (int)$row['QUANTITY'];
    }
        $PRICE= (double)$row['EBAY_PRICE'];
        $sys_title = @$row['ITEM_TITLE'];
        $sys_title = trim(strtolower($sys_title));
        $sys_title = preg_replace('!\s+!', ' ', $sys_title);//remove extra spaces
        $sys_title = str_replace(array("'",'"'), "", $sys_title);//remove single & double quote
        // $sys_title = str_replace("'", "", $sys_title);//remove single quote
        // $sys_title = str_replace('"', "", $sys_title);//remove double quote
    if($check_btn == 'list' AND @$forceRevise === 0){
        
        if(@$api_cond == (int)@$row['DEFAULT_COND'])
        {
            $add_qty = true;
            $check_if = true;
        }else{
            $check_if = false;
            //$add_qty = false;
        }
    }else{
        if(@$forceRevise === 1){
            $add_qty = true;
            $check_if = true;
        }else{
            $check_if = true;
            $add_qty = false;
        }
        
    }
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
        if((int)$addQtyOnly === 0){
            $request = new Types\ReviseFixedPriceItemRequestType();
            $item = new Types\ItemType();
        }else{
            $request = new Types\ReviseInventoryStatusRequestType();
            $item = new Types\InventoryStatusType();
        }
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

        
        $item->ItemID = $itemID;
        $item->StartPrice = new Types\AmountType(['value' => $PRICE]);
        $user_id = (int)$this->session->userdata('user_id');
        if($user_id === 49){ // ali raza id he can only update price 

        }else{//user id 49 else part
            if($add_qty){
                $item->Quantity = $QUANTITY; 
            }
            if((int)$addQtyOnly === 0){

                    /*======================================================
                    =            copy from add fixed price item            =
                    ======================================================*/
                    $CONDITION= (int)$row['DEFAULT_COND'];
                    $UPC = $row['UPC'];
                    $PART_NO = $row['PART_NO'];
                    $TITLE= $row['ITEM_TITLE'];
                    $DESC=$row['ITEM_DESC'];
                    $PRICE= (double)$row['EBAY_PRICE'];
                    $CURRENCY= $row['CURRENCY'];
                    $CATEGORYID = $row['CATEGORY_ID'];
                    $ZIP_CODE= $row['SHIP_FROM_ZIP_CODE'];
                    $LOCATION= $row['SHIP_FROM_LOC'];
                    $DETAIL_CONDITION= $row['DETAIL_COND'];
                    $PAYMENTMETHOD = $row['PAYMENT_METHOD'];
                    $EMAIL = $row['PAYPAL_EMAIL'];
                    $DISPATCH_TIME= (int)$row['DISPATCH_TIME_MAX'];
                    $SHIP_COST = (int)$row['SHIPPING_COST'];
                    $ADD_COST = (int)$row['ADDITIONAL_COST'];
                    $RETURN_OPT = $row['RETURN_OPTION'];
                    $RETURN_DAYS = (int)$row['RETURN_DAYS'];
                    $SHIP_PAID_BY = $row['SHIPPING_PAID_BY'];
                    $SHIP_SERVICE = $row ['SHIPPING_SERVICE'];
                    $SKU = $row['SKU'];
                    $MANUFACTURE = $row['MANUFACTURE'];
                    $WEIGHT = (double)$row['WEIGHT'];
                    $GENERAL_RULE = $row['GENERAL_RULE'];
                    $SPECIFIC_RULE = $row['SPECIFIC_RULE'];
                    $EPID = $row['EPID'];
                    /*========================================================
                    =            get listing rule against barcode            =
                    ========================================================*/
                    $account_id = $config['production']['account_id'];
                    if(!empty($account_id)){
                        $query = $this->db->query("SELECT D.GENERAL_RULE,D.SPECIFIC_RULE FROM LZ_LISTING_RULES_MT M , LZ_LISTING_RULES_DT D WHERE M.RULE_MT_ID = D.RULE_MT_ID AND D.ITEM_CONDITION = '$CONDITION' AND M.ACCOUNT_ID = '$account_id'")->result_array(); 
                        if(count($query) > 0){
                            $GENERAL_RULE = $query[0]['GENERAL_RULE'];
                            $SPECIFIC_RULE = $query[0]['SPECIFIC_RULE'];
                        }
                    }
                    /*=====  End of get listing rule against barcode  ======*/
                    /*=============================================================
                    =            concatinating listing rules with desc            =
                    =============================================================*/
                    $DESC=  $DESC .' '. $GENERAL_RULE .' '. $SPECIFIC_RULE;
                    /*=====  End of concatinating listing rules with desc  ======*/

                    if(!empty($DETAIL_CONDITION)){$item->ConditionDescription = $DETAIL_CONDITION;}
                   // if(empty($sold_qty)){
                        if(!empty($TITLE)){$item->Title = $TITLE;}
                    //} dated: 20-06-2019 on demand of fahad
                    
                    if(!empty($DESC)){$item->Description = $DESC;}
                    if(!empty($SKU)){$item->SKU = $SKU;}
                    $item->Country = 'US';
                    //$item->Location = $LOCATION;
                    //$item->AutoPay = true;// for immediate payment required
                    //if(!empty($ZIP_CODE)){$item->PostalCode = $ZIP_CODE;}
                    //if(!empty($CURRENCY)){$item->Currency = $CURRENCY;}
                    

                    /*=========================================
                    =            best Offer Option            =
                    =========================================*/
                    $item->BestOfferDetails = new Types\BestOfferDetailsType();
                    if($bestOfferCheckbox){//$bestOfferCheckbox = 1
                        $item->BestOfferDetails->BestOfferEnabled = true;
                        $item->ListingDetails = new Types\ListingDetailsType();
                        // $item->ListingDetails->BestOfferAutoAcceptPrice = new Types\AmountType(['value' => round($PRICE * 98 / 100 ,2)]); 
                        $item->ListingDetails->MinimumBestOfferPrice =  new Types\AmountType(['value' => round($PRICE * 75 / 100 ,2)]); 
                        //$item->ListingDetails->LocalListingDistance = "20";

                    }else{
                        $item->BestOfferDetails->BestOfferEnabled = false;
                    }
                    /*=====  End of best Offer Option  ======*/
                
            // ================ Start UPC for searhing Item from ebay search ==================
                    $item->ProductListingDetails = new Types\ProductListingDetailsType();
                     if(!empty($UPC))
                    {
                            $item->ProductListingDetails->UPC = $UPC;

                    }else{
                            $item->ProductListingDetails->UPC = "Does Not Apply";
                         }
            // ================= End UPC for searhing Item from ebay search ===================
                    if(!empty($EPID)){
                        /*====================================================
                        =            disabe catalogue information            = 
                        ====================================================*/
                                $item->ProductListingDetails->ProductReferenceID = $EPID;//this is epid use when ebay doesnt allow us to list an item withput ebay catalog detail
                                // You must select a product from the eBay catalog when listing Apple items in the Tablets & eBook Readers category.
                                $item->ProductListingDetails->IncludeeBayProductDetails = true;// must be ture if epid is given
                                $item->ProductListingDetails->IncludeStockPhotoURL = false;// to avoid sbay catalog photo set this to false

                        /*=====  End of disabe catalogue information  ======*/
                    }else{
                        $item->ProductListingDetails->IncludeeBayProductDetails = true;
                        $item->ProductListingDetails->IncludeStockPhotoURL = false;// to avoid sbay catalog photo set this to false
                    }   

            // ====================== ItemSpecifics Start ============================        
                    $item->ItemSpecifics = new Types\NameValueListArrayType();
                    $flag = true;
                    if(!empty($specific_data)){
                        foreach(@$specific_data as $specs){
                            if(strtoupper($specs['SPECIFICS_NAME']) == 'BRAND'){
                                $flag = false;
                                $specific = new Types\NameValueListType();
                                $specific->Name = ucfirst($specs['SPECIFICS_NAME']);
                                $specific->Value[] = $specs['SPECIFICS_VALUE'];
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }else{
                                if(strtoupper(($specs['SPECIFICS_NAME'])) == 'ISBN'){
                                    $item->ProductListingDetails->ISBN = $specs['SPECIFICS_VALUE'];
                                }else{
                                    $specific = new Types\NameValueListType();
                                    $specific->Name = $specs['SPECIFICS_NAME'];
                                    $specific->Value[] = $specs['SPECIFICS_VALUE'];
                                    $item->ItemSpecifics->NameValueList[] = $specific;
                                }
                            }
                                            
                        }
            // flag added if user didnt provide Brand in item specific than flag will insert Brand
                        if($flag)
                            {
                                $specific = new Types\NameValueListType();
                                $specific->Name = 'Brand';
                                $specific->Value[] = $MANUFACTURE;
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }
            // above code added to remove brand missing error from listing

                        //if(!empty($PART_NO) && strpos($PART_NO, 'LZ-'.$CATEGORYID) !== false)//DONT PUSH LZ_MPN TO EBAY
                        if(!empty($PART_NO) && strpos($PART_NO, 'LZ-') !== false)//DONT PUSH LZ_MPN TO EBAY
                        {
                            $specific = new Types\NameValueListType();
                            $specific->Name = 'MPN';
                            $specific->Value[] = $PART_NO;
                            $item->ItemSpecifics->NameValueList[] = $specific;
                        }
                    }else{
                        if(!empty($SKU))
                            {
                                $specific = new Types\NameValueListType();
                                $specific->Name = 'SKU';
                                $specific->Value[] = $SKU;
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }
                         if(!empty($UPC))
                            {
                                $specific = new Types\NameValueListType();
                                $specific->Name = 'UPC';
                                $specific->Value[] = $UPC;
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }
                                
                         if(!empty($PART_NO))
                            {
                                $specific = new Types\NameValueListType();
                                $specific->Name = 'MPN';
                                $specific->Value[] = $PART_NO;
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }
                         if(!empty($MANUFACTURE))
                            {
                                $specific = new Types\NameValueListType();
                                $specific->Name = 'Manufacture';
                                $specific->Value[] = $MANUFACTURE;
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }
                         if(!empty($MANUFACTURE))
                            {
                                $specific = new Types\NameValueListType();
                                $specific->Name = 'Brand';
                                $specific->Value[] = $MANUFACTURE;
                                $item->ItemSpecifics->NameValueList[] = $specific;
                            }
                    } //end main if-else


            // =========================== ItemSpecifics End ===============================   
                    $item->PrimaryCategory = new Types\CategoryType();
                    $item->PrimaryCategory->CategoryID = $CATEGORYID;
                    $item->ConditionID = $CONDITION;
                    $item->ShippingDetails = new Types\ShippingDetailsType();
                    $item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;
                    $shippingService = new Types\ShippingServiceOptionsType();
                    $shippingService->FreeShipping = true;
                    $shippingService->LocalPickup = true;
                    $shippingService->ShippingServicePriority = 1;
                    if(!empty($SHIP_SERVICE)){
                        // If shipping service is FedEx then exclude 'Alaska/Hawaii','US Protectorates','APO/FPO'
                        if (strpos($SHIP_SERVICE, 'FedEx') !== false) {
                            $item->ShippingDetails->ExcludeShipToLocation = ['Alaska/Hawaii','US Protectorates','APO/FPO','Africa', 'Asia', 'Southeast Asia', 'Middle East', 'Central America and Caribbean', 'South America', 'North America', 'Oceania', 'Europe'];

                        }else{
                            $item->ShippingDetails->ExcludeShipToLocation = ['Africa', 'Asia', 'Southeast Asia', 'Middle East', 'Central America and Caribbean', 'South America', 'North America', 'Oceania', 'Europe'];
                            $item->ShippingDetails->GlobalShipping = true;
                        } 
                        $shippingService->ShippingService = $SHIP_SERVICE;
                    }
                    
                    $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;
            // ================= LARGE ENVALOP OPTION ================================
                    $item->ShippingPackageDetails = new Types\ShipPackageDetailsType();
                    $item->ShippingPackageDetails->ShippingPackage=Enums\ShippingPackageCodeType::C_USPS_LARGE_PACK;
             
            // ================= LARGE ENVALOP OPTION =============
            // 
            /*=====================================
            =          Start of Weight section     =
            =======================================*/
                    if(!empty($WEIGHT) && $WEIGHT > 0){
                            if($WEIGHT >= 16){
                                $WEIGHT = $WEIGHT / 16;
                                $WEIGHT = number_format((float)@$WEIGHT,2,'.',',');
                                $WEIGHT = explode('.', $WEIGHT);
                                $WeightMajor = (int)$WEIGHT[0];  
                                $WeightMinor = (int)$WEIGHT[1] / 100; 

                                $packageDetails = new Types\ShipPackageDetailsType();
                                $packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
                                $packageDetails->WeightMajor = new Types\MeasureType();
                                $packageDetails->WeightMajor->unit = 'lbs';
                                $packageDetails->WeightMajor->value = $WeightMajor;
                                $packageDetails->WeightMinor = new Types\MeasureType([
                                    'unit' => 'oz',
                                    'value' => (int)$WeightMinor
                                ]);  
                            }else{
                               
                                $packageDetails = new Types\ShipPackageDetailsType();
                                $packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
                                $packageDetails->WeightMajor = new Types\MeasureType();
                                $packageDetails->WeightMajor->unit = 'lbs';
                                $packageDetails->WeightMajor->value = 0;
                                $packageDetails->WeightMinor = new Types\MeasureType([
                                    'unit' => 'oz',
                                    'value' => (int)$WEIGHT
                                ]);  
                            }
                           
                            $item->ShippingPackageDetails = $packageDetails;
                    }
            /*=====  End of Weight section  ======*/

                    $item->ReturnPolicy = new Types\ReturnPolicyType();
                    if($RETURN_OPT=='ReturnsAccepted'){
                        $item->ReturnPolicy->ReturnsAcceptedOption = $RETURN_OPT;
                        $item->ReturnPolicy->RefundOption = 'MoneyBack';
                        $item->ReturnPolicy->ReturnsWithinOption = 'Days_'.$RETURN_DAYS;
                        $item->ReturnPolicy->ShippingCostPaidByOption = $SHIP_PAID_BY;
                    }else{
                        $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsNotAccepted';
                    }

            /*=====  End of copy from add fixed price item  ======*/

            }

        }//user id 49 if else close

        /*===========================================
        =            execute revise call            =
        ===========================================*/
            if((int)$addQtyOnly === 1){
                $request->InventoryStatus[] = $item;
                $response = $service->reviseInventoryStatus($request);
            }else{
                $request->Item = $item;
                $response = $service->ReviseFixedPriceItem($request);
            }
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

                
                if((int)$addQtyOnly === 1){
                    foreach ($response->InventoryStatus as $inventoryStatus) {
                    // printf("Quantity for [%s] is %s\n\n with Price %3\$.2f",
                    //     $inventoryStatus->ItemID,
                    //     $inventoryStatus->Quantity,
                    //     $inventoryStatus->StartPrice->value
                    // );
                    $ebay_item_id = $inventoryStatus->ItemID;
                    $this->session->set_userdata('ebay_item_id', $ebay_item_id);
                    $this->session->set_userdata('current_qty', $current_qty);
                        
                    }
                }else{
                    $ebay_item_id = $response->ItemID;
                    $this->session->set_userdata('ebay_item_id', $ebay_item_id);
                    $this->session->set_userdata('current_qty', $current_qty);
                }

                

            }else{
                echo "<pre>";
                print_r($response);
                echo "</pre>";
                exit;
            }//end success if
        
        /*=====  End of execute revise call  ======*/
    
    }else{//condition check if close
        die("Condition Mismatch! eBay item Condition:".@$api_cond." Seed Condition:".(int)@$row['DEFAULT_COND']);
    }
   break; 
}// end main foreach

?>