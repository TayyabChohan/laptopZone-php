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
/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
require "require/eBaySession.php";//to upload pix

$query = $this->db->query("SELECT MASTER_PATH,SPECIFIC_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
$master_qry = $query->result_array();
$master_path = $master_qry[0]['MASTER_PATH'];
$specific_path = $master_qry[0]['SPECIFIC_PATH'];

foreach ($seed_data as $row)
{
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
        $QUANTITY = (int)$row['QUANTITY'];
        $SKU = $row['SKU'];
        $MANUFACTURE = $row['MANUFACTURE'];
        $WEIGHT = (double)$row['WEIGHT'];
        $GENERAL_RULE = $row['GENERAL_RULE'];
        $SPECIFIC_RULE = $row['SPECIFIC_RULE'];
        $EPID = $row['EPID'];
        $ITEM_ID = $row['ITEM_ID'];

        /*=============================================================
        =            concatinating listing rules with desc            =
        =============================================================*/
        $DESC=  $DESC .' '. $GENERAL_RULE .' '. $SPECIFIC_RULE;
        /*=====  End of concatinating listing rules with desc  ======*/
        
        // var_dump($pic_data);exit;
       //    if(is_array($pic_data)){
       //      foreach ($pic_data as $pic){
       //      $image = $pic['ITEM_PIC']->load();
       //      $pic_name = $pic['ITEM_PICT_DESC'];
       //      require "08-upload-picture-test.php";
       //     }//end  picture upload foreach
       // }
                $it_condition = $CONDITION;
                $upc = $UPC;
                $mpn = $PART_NO;
                $manifest_id = $row['LZ_MANIFEST_ID'];
                $it_condition = $row['COND_NAME'];
                    // if(is_numeric(@$it_condition)){
                    //     if(@$it_condition == 3000){
                    //       @$it_condition = 'Used';
                    //     }elseif(@$it_condition == 1000){
                    //       @$it_condition = 'New'; 
                    //     }elseif(@$it_condition == 1500){
                    //       @$it_condition = 'New other'; 
                    //     }elseif(@$it_condition == 2000){
                    //         @$it_condition = 'Manufacturer refurbished';
                    //     }elseif(@$it_condition == 2500){
                    //       @$it_condition = 'Seller refurbished'; 
                    //     }elseif(@$it_condition == 7000){
                    //       @$it_condition = 'For parts or not working'; 
                    //     }else{
                    //         @$it_condition = 'Used'; 
                    //     }
                    // }else{// end main if
                    //   $it_condition  = ucfirst(@$it_condition);
                    // }
                $mpn = str_replace('/', '_', @$mpn);


                if($pic_data === "B"){

                    $m_dir = $master_path.@$upc."~".@$mpn."/".@$it_condition;

                    // Open a directory, and read its contents
                    if (is_dir($m_dir)){

                            if ($dh = opendir($m_dir)){
                              
                              $all_url=[];
                              $pic_names=[];
                              while (($file = readdir($dh)) !== false){
                                $parts = explode(".", $file);
                                if (is_array($parts) && count($parts) > 1){
                                    $extension = end($parts);
                                    if(!empty($extension)){
                                      $url = $m_dir.'/'.$parts['0'].'.'.$extension;
                                      array_push($all_url,$url);
                                      $pic_name = $parts['0'];
                                      array_push($pic_names,$pic_name);
                                  }
                                }

                              }//end while
                              closedir($dh);

                            }
                        // Open a directory, and read its contents  
                        $s_dir = $specific_path.@$upc."~".$mpn."/".@$it_condition."/".$manifest_id;

                        /*=========================================
                        =            Upload all image             =
                        =========================================*/
                        $j=0;
                        foreach ($all_url as $url) {
                          $image = file_get_contents($url);
                          $pic_name = $pic_names[$j];
                          
                          // require "08-upload-picture-test.php";
                          require "UploadSiteHostedPictures.php";
                          $j++;
                        }
                        /*=====  End of Upload all image   ======*/
                        
                    }else{// sub main if wlse
                        die('Error. No image Found in Directory:'.$m_dir);exit;
                    }
                }elseif($pic_data === "M"){

                    $m_dir = $master_path.@$upc."~".@$mpn."/".@$it_condition;
                    // Open a directory, and read its contents
                    if (is_dir($m_dir)){
                            if ($dh = opendir($m_dir)){
                              
                              while (($file = readdir($dh)) !== false){
                                $parts = explode(".", $file);
                                if (is_array($parts) && count($parts) > 1){
                                    $extension = end($parts);
                                    if(!empty($extension)){
                                      $url = $m_dir.'/'.$parts['0'].'.'.$extension;
                                      $image = file_get_contents($url);
                                      $pic_name = $parts['0'];
                                       //print_r($pic_name);exit;
                                     // require "08-upload-picture-test.php";
                                      require "UploadSiteHostedPictures.php";
                                  }
                                }

                              }//end while
                              closedir($dh);

                            }
                    }else{// sub main if wlse
                        die('Error. Directory not Found:'.$m_dir);exit;
                    }

                }elseif($pic_data === "S"){
                    $s_dir = $specific_path.@$upc."~".$mpn."/".@$it_condition."/".$manifest_id;
                        // Open a directory, and read its contents
                            if (is_dir($s_dir)){
                                if ($dh = opendir($s_dir)){
                                  
                                  while (($file = readdir($dh)) !== false){
                                    $parts = explode(".", $file);
                                    if (is_array($parts) && count($parts) > 1){
                                        $extension = end($parts);
                                        if(!empty($extension)){
                                          $url = $s_dir.'/'.$parts['0'].'.'.$extension;
                                          $image = file_get_contents($url);
                                          $pic_name = $parts['0'];
                                          // require "08-upload-picture-test.php";
                                          require "UploadSiteHostedPictures.php";
                                      }
                                    }

                                  }//end while
                                  closedir($dh);

                                }
                            }
    //   }//main if else
   }
                
        require __DIR__.'/../vendor/autoload.php';

        $config = require __DIR__.'/../configuration.php';

        $siteId = Constants\SiteIds::US;
        $service = new Services\TradingService([
            'credentials' => $config['production']['credentials'],
            'production'     => true,
            'siteId'      => $siteId
        ]);
        $request = new Types\AddFixedPriceItemRequestType();
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
        $item = new Types\ItemType();
        $item->ListingType = Enums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
        $item->Quantity = $QUANTITY;
        $item->ListingDuration = Enums\ListingDurationCodeType::C_GTC;
        $item->StartPrice = new Types\AmountType(['value' => $PRICE]);
        if(!empty($DETAIL_CONDITION)){$item->ConditionDescription = $DETAIL_CONDITION;}
        if(!empty($TITLE)){$item->Title = $TITLE;}
        if(!empty($DESC)){$item->Description = $DESC;}
        if(!empty($SKU)){$item->SKU = $SKU;}
        $item->Country = 'US';
        $item->Location = $LOCATION;
        $item->AutoPay = true;// for immediate payment required
        if(!empty($ZIP_CODE)){$item->PostalCode = $ZIP_CODE;}
        if(!empty($CURRENCY)){$item->Currency = $CURRENCY;}
        
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


// ================= Seller Profile Start ===============================        
        // $item->SellerProfiles = new Types\SellerProfilesType();

        // $SellerShippingProfile = new Types\SellerShippingProfileType();
        // $SellerShippingProfile->ShippingProfileID = 2147483647;
        // $SellerShippingProfile->ShippingProfileName = "Flat:USPS Parcel Se(Free),1 business day";
        // $item->SellerProfiles->SellerShippingProfilep[]=$SellerShippingProfile;

        // $SellerReturnProfile = new Types\SellerShippingProfileType();
        // $SellerReturnProfile->ReturnProfileID = 2147483647;
        // $SellerReturnProfile->ReturnProfileName = "Returns Accepted";
        // $item->SellerProfiles->SellerReturnProfile[]=$SellerShippingProfile;

        // $SellerPaymentProfile = new Types\SellerShippingProfileType();
        // $SellerPaymentProfile->PaymentProfileID = 2147483647;
        // $SellerPaymentProfile->PaymentProfileName = "PayPal#0";
        // $item->SellerProfiles->SellerPaymentProfile[]=$SellerShippingProfile;
// =========================== Seller Profile End ===============================

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

            if(!empty($PART_NO) && strpos($PART_NO, 'LZ-'.$CATEGORYID) !== false)//DONT PUSH LZ_MPN TO EBAY
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

        $item->PictureDetails = new Types\PictureDetailsType();
        $item->PictureDetails->GalleryType = Enums\GalleryTypeCodeType::C_GALLERY;
        $total_img = count($picURL);
        /*============================================
        =            insert pic url in db            =
        ============================================*/
            $check_qry = $this->db->query("SELECT * FROM SITE_HOSTED_PIC_MT WHERE ITEM_ID = '$ITEM_ID' AND CONDITION_ID  = '$CONDITION'");
            if($check_qry->num_rows() === 0){
                $list_rslt = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('SITE_HOSTED_PIC_MT','PIC_MT_ID') PIC_MT_ID FROM DUAL");
                $rs = $list_rslt->result_array();
                $pic_mt_id = $rs[0]['PIC_MT_ID'];
                $this->db->query("INSERT INTO SITE_HOSTED_PIC_MT (PIC_MT_ID,ITEM_ID,CONDITION_ID,INSERT_DATE)VALUES('$pic_mt_id','$ITEM_ID','$CONDITION',SYSDATE)");
            }else{
                $check_qry = $check_qry->result_array();
                $pic_mt_id = $check_qry[0]['PIC_MT_ID'];
                $this->db->query("DELETE FROM SITE_HOSTED_PIC_DT WHERE PIC_MT_ID = '$pic_mt_id'");
            }

            foreach ($picURL as $imageUrl) {
                $this->db->query("INSERT INTO SITE_HOSTED_PIC_DT (PIC_DT_ID,PIC_MT_ID,PIC_URL)VALUES(GET_SINGLE_PRIMARY_KEY('SITE_HOSTED_PIC_DT','PIC_DT_ID'),'$pic_mt_id','$imageUrl')");
            }
        /*=====  End of insert pic url in db  ======*/
        switch ($total_img) {
            case '0':
                # code...
            echo "Please select images.";
                break;
            case '1':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0]];
                break;
            case '2':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1]];
                break;
            case '3':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2]];
                break;
            case '4':
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3]];
                break;
            case '5':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4]];
                break;                                                
            case '6':
                # code...
             $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5]];
                break;
            case '7':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6]];
                break;
            case '8':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6],$picURL[7]];
                break;
            case '9':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6],$picURL[7],$picURL[8]];
                break;
            case '10':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6],$picURL[7],$picURL[8],$picURL[9]];
                break;
            case '11':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6],$picURL[7],$picURL[8],$picURL[9],$picURL[10]];
                break;
            case '12':
                # code...
            $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6],$picURL[7],$picURL[8],$picURL[9],$picURL[10],$picURL[11]];
                break;                            
            default:
                $item->PictureDetails->PictureURL = [$picURL[0],$picURL[1],$picURL[2],$picURL[3],$picURL[4],$picURL[5],$picURL[6],$picURL[7],$picURL[8],$picURL[9],$picURL[10],$picURL[11]];
                break;
        }
        $item->PrimaryCategory = new Types\CategoryType();
        $item->PrimaryCategory->CategoryID = $CATEGORYID;
        $item->ConditionID = $CONDITION;
        $item->PaymentMethods = [
            'PayPalCredit',
            'PayPal'
        ];
        $item->PayPalEmailAddress = 'laptopzone.us@gmail.com';
        //$item->PayPalEmailAddress = 'example@example.com';
        $item->DispatchTimeMax = $DISPATCH_TIME;
        $item->ShippingDetails = new Types\ShippingDetailsType();
        $item->ShippingDetails->ShippingType = Enums\ShippingTypeCodeType::C_FLAT;
        $shippingService = new Types\ShippingServiceOptionsType();
        $shippingService->FreeShipping = true;
        $shippingService->LocalPickup = true;
        $shippingService->ShippingServicePriority = 1;
        //$shippingService->ShippingService = 'USPSParcel';$SHIP_SERVICE
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

/*================================================
=            shipping package details            =
================================================*/

/**
 * Using Calculated shipping requires specifying the dimensions and weight of the package.
 * Note that we are listing to the US site and so dimensions are specified in inches
 * and the weight in pounds and ounces. Other sites will use different units.
 */
//$packageDetails = new Types\ShipPackageDetailsType();
//$packageDetails->ShippingPackage = 'PackageThickEnvelope';
//$packageDetails->MeasurementUnit = Enums\MeasurementSystemCodeType::C_ENGLISH;
// $packageDetails->ShippingIrregular = true;
// $packageDetails->PackageWidth = new Types\MeasureType();
// $packageDetails->PackageWidth->unit = 'in';
// $packageDetails->PackageWidth->value = 1;
// $packageDetails->PackageLength = new Types\MeasureType();
// $packageDetails->PackageLength->unit = 'in';
// $packageDetails->PackageLength->value = 2;
// $packageDetails->PackageDepth = new Types\MeasureType();
// $packageDetails->PackageDepth->unit = 'in';
// $packageDetails->PackageDepth->value = 3;
// $packageDetails->WeightMajor = new Types\MeasureType();
// $packageDetails->WeightMajor->unit = 'lbs';
// $packageDetails->WeightMajor->value = 2;
/**
 * The SDK allows properties to be specified when constructing new objects.
 * By taking advantage of this feature we add details as follows.
 */
// $packageDetails->WeightMinor = new Types\MeasureType([
//     'unit' => 'oz',
//     'value' => 3
// ]);
//$item->ShippingPackageDetails = $packageDetails;

/*=====  End of shipping package details  ======*/



        $item->ReturnPolicy = new Types\ReturnPolicyType();
        if($RETURN_OPT=='ReturnsAccepted'){
            $item->ReturnPolicy->ReturnsAcceptedOption = $RETURN_OPT;
            $item->ReturnPolicy->RefundOption = 'MoneyBack';
            $item->ReturnPolicy->ReturnsWithinOption = 'Days_'.$RETURN_DAYS;
            $item->ReturnPolicy->ShippingCostPaidByOption = $SHIP_PAID_BY;
        }else{
            $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsNotAccepted';
        }
        //$item->ReturnPolicy->ReturnsAcceptedOption = $RETURN_OPT;
        // $item->ReturnPolicy->RefundOption = 'MoneyBack';
        // $item->ReturnPolicy->ReturnsWithinOption = 'Days_'.$RETURN_DAYS;
        // $item->ReturnPolicy->ShippingCostPaidByOption = $SHIP_PAID_BY;
        $request->Item = $item;
        $response = $service->addFixedPriceItem($request);
    if (isset($response->Errors)) {
        foreach ($response->Errors as $error) {

            echo "<div class='col-sm-12'><div id='errorMsg' class='text-danger'>". $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning'."<br>".$error->ShortMessage."<br>".$error->LongMessage."</div></div>";
        }
    }

    if ($response->Ack !== 'Failure') {
       // echo "<div class='col-sm-12'><div id='errorMsg' class='text-danger'>The item was listed to the eBay production with the Item number".$response->ItemID."</div></div>";
        /*====================================================
        =            code commented on 07-05-2018            =
        ====================================================*/
         // $account_type = $this->session->userdata('account_type');
        // if($account_type == 1)
        // {
        //     $account_type = 'Techbargains2015';
        // }elseif($account_type == 2)
        // {
        //     $account_type = 'Dfwonline';
        // }
        // $emp_name = $this->session->userdata('employee_name');
        // echo "<div class='col-sm-12'>
        //         <div id='errorMsg' class='text-danger'>
        //             The item was listed on eBay With the Following Details:<br>
        //             <ul>
        //                 <li>Ebay Id: ".$response->ItemID."</li>
        //                 <li>Ebay Account: ".$account_type."</li>
        //                 <li>Listed By: " .$emp_name." </li>
        //                 <li>Timestamp: " .$response->Timestamp->format('Y-m-d H:i:s')." </li>
        //             </ul>
        //         </div>
               
                
        //     </div>";
            ?>
             <!-- <a class="prnt_btn" href='<?php //echo base_url(); ?>/listing/listing/print_label' target="_blank">Print Sticker</a>
             <a style="margin-left: 5px;" class="prnt_btn" title="Back to Item Listing" href='<?php// echo base_url(); ?>/tolist/c_tolist/lister_view'>Back to Item Listing</a> -->
        <?php
        
        /*=====  End of code commented on 07-05-2018  ======*/
        
             //require_once "print_script/barcode.php";
            //require_once "print_script/test.php";
            
        $ebay_item_id = $response->ItemID;
        $this->session->set_userdata('ebay_item_id', $ebay_item_id);
    }
break;// if multiple rows retirn from qry
}//end main foreach for add

?>