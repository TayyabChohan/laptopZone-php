<?php
// require __DIR__.'/vendor/autoload.php';
// use \DTS\eBaySDK\Constants;
// use \DTS\eBaySDK\Trading\Services;
// use \DTS\eBaySDK\Trading\Types;
// use \DTS\eBaySDK\Trading\Enums;
$lz_seller_id = $account_id;
// $data = $this->db->query("SELECT * FROM LJ_EBAY_ACTIVE_LISTING L WHERE TO_DATE(L.START_DATE,'MON-DD-YY')  <= SYSDATE - 365 AND LOCAL_DOWNLOADED = 0 AND ROWNUM <=5000 AND L.SELLER_ACCOUNT = $lz_seller_id ORDER BY TO_NUMBER(L.QUANTITY_AVAILABLE) DESC")->result_array(); // first query
//$data = $this->db->query("SELECT * FROM LJ_EBAY_ACTIVE_LISTING L WHERE TO_DATE(L.START_DATE, 'MON-DD-YY') >= SYSDATE - 365 and TO_DATE(L.START_DATE, 'MON-DD-YY') <= SYSDATE - 210 AND LOCAL_DOWNLOADED = 0 AND ROWNUM <= 5000 AND L.SELLER_ACCOUNT = 2 and l.item_id = 263876958150 ORDER BY TO_NUMBER(L.QUANTITY_AVAILABLE) DESC")->result_array(); // second query
$data = $this->db->query("SELECT * FROM LJ_EBAY_ACTIVE_LISTING L WHERE TO_DATE(L.START_DATE, 'MON-DD-YY') >= SYSDATE - 210 and TO_DATE(L.START_DATE, 'MON-DD-YY') <= SYSDATE - 60 AND LOCAL_DOWNLOADED = 0   AND L.SELLER_ACCOUNT = 1 ORDER BY TO_NUMBER(L.QUANTITY_AVAILABLE) DESC")->result_array(); // 3rd query


require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__.'/../config_save_seed.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

$siteId = Constants\SiteIds::US;
// $service = new Services\TradingService([
//     'authToken'   => 'your-auth-token',
//     'credentials' => [
//        'appId'  => 'your-app-id',
//        'certId' => 'your-cert-id',
//        'devId'  => 'your-dev-id'        
//     ],
//     'siteId'      => Constants\SiteIds::GB
// ]);
$service = new Services\TradingService([    
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);



foreach ($data as $ebayItem ) {
    $ebay_id = $ebayItem['ITEM_ID'];
    $active_list_id = $ebayItem['ACTIVE_LIST_ID'];
/*=================================
=            loop code            =
=================================*/
$request = new Types\GetItemRequestType() ;
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
//$ebay_id = '282717139787';
$request->ItemID = $ebay_id;
$request->DetailLevel = ['ReturnAll'];
$response = $service->getItem($request);
        // echo "<pre>";
        // print_r($response);
        // echo "</pre>";
        // exit;
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
// foreach ($item->PictureDetails->PictureURL as $pictureurl) {
//     $segments = explode('/', trim(parse_url($pictureurl, PHP_URL_PATH), '/'));
//     $numSegments = count($segments); 
//     $picKey = $segments[$numSegments - 2];
//     echo 'URL:'.$pictureurl . '<br> Current Segment: ' , $picKey.'<br>';
// }
// exit;
    // printf(
    //     "%s\n%s\n%s\n%s\n%s\n(%s)%.2f\n",
    //     $item->ListingDetails->ViewItemURL,
    //     $item->ItemID,
    //     $item->Title,
    //     $item->Description,
    //     $item->Quantity,
    //     $item->SellingStatus->CurrentPrice->currencyID,
    //     $item->SellingStatus->CurrentPrice->value
    // );QuantitySold

$ebay_id = @$item->ItemID;
$title = @$item->Title;
$title = trim(str_replace(array("'", '"','`'), "''", $title));
$listingtype = @$item->ListingType;
$paypalemailaddress = @$item->PayPalEmailAddress;
$primarycategoryid = @$item->PrimaryCategory->CategoryID;
$primarycategoryname = @$item->PrimaryCategory->CategoryName;
$primarycategoryname = trim(str_replace(array("'", '"','`'), "''", $primarycategoryname));
$secondarycategoryid = @$item->SecondaryCategory->CategoryID;
$secondarycategoryname = @$item->SecondaryCategory->CategoryName;
$secondarycategoryname = trim(str_replace(array("'", '"','`'), "''", $secondarycategoryname));
// $startprice = @$item->StartPrice->value;
$quantity = @$item->Quantity;
// $currency = @$item->StartPrice->currencyID;
$piccount = count(@$item->PictureDetails->PictureURL);
$returnsacceptedoption = @$item->ReturnPolicy->ReturnsAcceptedOption;
$returnswithinoption = @$item->ReturnPolicy->ReturnsWithinOption;
$shippingcostpaidbyoption = @$item->ReturnPolicy->ShippingCostPaidByOption;
$conditionid = @$item->ConditionID;
$conditiondescription = @$item->ConditionDescription;
$conditiondescription = trim(str_replace(array("'", '"','`'), "''", $conditiondescription));
$conditiondisplayname = @$item->ConditionDisplayName;
$description = @$item->Description;
$description = trim(str_replace(array("'", '"','`'), "''", $description));
$upc = @$item->ProductListingDetails->UPC;
$brand = @$item->ProductListingDetails->BrandMPN->Brand;
$brand = trim(str_replace(array("'", '"','`'), "''", $brand));
$mpn = @$item->ProductListingDetails->BrandMPN->MPN;
$mpn = trim(str_replace(array("'", '"','`'), "''", $mpn));
$seller_id = @$item->Seller->UserID;
$quantitysold = @$item->SellingStatus->QuantitySold;
$startprice = @$item->SellingStatus->CurrentPrice->value;
$currency = @$item->SellingStatus->CurrentPrice->currencyID;
$quantitysoldbypickup = @$item->SellingStatus->QuantitySoldByPickupInStore;
$shippingserviceArray = @$item->ShippingDetails->ShippingServiceOptions;
$shippingservice = $shippingserviceArray[0]->ShippingService;
//$inserted_date = 'sysdate';
$seed_id = '';
//$lz_seller_id = 2;


// var_dump($ebay_id ,
// $title ,
// $listingtype ,
// $paypalemailaddress ,
// $primarycategoryid ,
// $primarycategoryname ,
// $secondarycategoryid ,
// $secondarycategoryname ,
// $quantity ,
// $piccount ,
// $returnsacceptedoption ,
// $returnswithinoption ,
// $shippingcostpaidbyoption ,
// $conditionid ,
// $conditiondescription ,
// $conditiondisplayname ,
// $description ,
// $upc ,
// $brand ,
// $mpn ,
// $seller_id ,
// $quantitysold ,
// $startprice ,
// $currency ,
// $shippingservice,
// $quantitysoldbypickup
//  );exit;
$data = $this->db->query("SELECT ACTIVE_SEED_ID FROM LZ_ITEM_SEED_TMP A WHERE A.EBAY_ID = '$ebay_id'")->result_array();
if(count($data) === 0){

    $active_seed = $this->db->query("SELECT get_single_primary_key('lz_item_seed_tmp','active_seed_id') ACTIVE_SEED_ID FROM DUAL")->result_array();
    $active_seed_id = $active_seed[0]['ACTIVE_SEED_ID']; 

    $get_seed = $this->db->query("SELECT * FROM (SELECT S.SEED_ID FROM LZ_BARCODE_MT B, LZ_ITEM_SEED S WHERE S.ITEM_ID = B.ITEM_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.DEFAULT_COND = B.CONDITION_ID AND B.EBAY_ITEM_ID = '$ebay_id' ORDER BY S.SEED_ID DESC ) WHERE ROWNUM=1")->result_array(); 
    if(count($get_seed) > 0){
        $seed_id = $get_seed[0]['SEED_ID'];
    }
    $qry = "DECLARE temp_desc long; BEGIN temp_desc := '$description'; INSERT INTO LZ_ITEM_SEED_TMP (ACTIVE_SEED_ID,
    EBAY_ID,
    TITLE,
    LISTINGTYPE,
    PAYPALEMAILADDRESS,
    PRIMARYCATEGORYID,
    PRIMARYCATEGORYNAME,
    SECONDARYCATEGORYID,
    SECONDARYCATEGORYNAME,
    STARTPRICE,
    QUANTITY,
    CURRENCY,
    PICCOUNT,
    RETURNSACCEPTEDOPTION,
    RETURNSWITHINOPTION,
    SHIPPINGCOSTPAIDBYOPTION,
    CONDITIONID,
    CONDITIONDESCRIPTION,
    CONDITIONDISPLAYNAME,
    UPC,
    BRAND,
    MPN,
    SELLER_ID,
    INSERTED_DATE,
    SEED_ID,
    SHIPPINGSERVICE,
    QUANTITYSOLD,
    QUANTITYSOLDBYPICKUP,
    LZ_SELLER_ID,
    ITEM_DESC)VALUES( 
    $active_seed_id,
    '$ebay_id',
    '$title',
    '$listingtype',
    '$paypalemailaddress',
    '$primarycategoryid',
    '$primarycategoryname',
    '$secondarycategoryid',
    '$secondarycategoryname',
    '$startprice',
    '$quantity',
    '$currency',
    '$piccount',
    '$returnsacceptedoption',
    '$returnswithinoption',
    '$shippingcostpaidbyoption',
    '$conditionid',
    '$conditiondescription',
    '$conditiondisplayname',
    '$upc',
    '$brand',
    '$mpn',
    '$seller_id',
    sysdate,
    '$seed_id',
    '$shippingservice',
    '$quantitysold',
    '$quantitysoldbypickup',
    '$lz_seller_id',
    temp_desc);END;";

$this->db->query($qry);
    // $this->db->query("INSERT INTO LZ_ITEM_SEED_TMP (ACTIVE_SEED_ID,
    // EBAY_ID,
    // TITLE,
    // LISTINGTYPE,
    // PAYPALEMAILADDRESS,
    // PRIMARYCATEGORYID,
    // PRIMARYCATEGORYNAME,
    // SECONDARYCATEGORYID,
    // SECONDARYCATEGORYNAME,
    // STARTPRICE,
    // QUANTITY,
    // CURRENCY,
    // PICCOUNT,
    // RETURNSACCEPTEDOPTION,
    // RETURNSWITHINOPTION,
    // SHIPPINGCOSTPAIDBYOPTION,
    // CONDITIONID,
    // CONDITIONDESCRIPTION,
    // CONDITIONDISPLAYNAME,
    // UPC,
    // BRAND,
    // MPN,
    // SELLER_ID,
    // INSERTED_DATE,
    // SEED_ID,
    // SHIPPINGSERVICE,
    // QUANTITYSOLD,
    // QUANTITYSOLDBYPICKUP,
    // LZ_SELLER_ID,
    // ITEM_DESC)VALUES( 
    // $active_seed_id,
    // '$ebay_id',
    // '$title',
    // '$listingtype',
    // '$paypalemailaddress',
    // '$primarycategoryid',
    // '$primarycategoryname',
    // '$secondarycategoryid',
    // '$secondarycategoryname',
    // '$startprice',
    // '$quantity',
    // '$currency',
    // '$piccount',
    // '$returnsacceptedoption',
    // '$returnswithinoption',
    // '$shippingcostpaidbyoption',
    // '$conditionid',
    // '$conditiondescription',
    // '$conditiondisplayname',
    // '$upc',
    // '$brand',
    // '$mpn',
    // '$seller_id',
    // sysdate,
    // '$seed_id',
    // '$shippingservice',
    // '$quantitysold',
    // '$quantitysoldbypickup',
    // '$lz_seller_id',
    // '$description')");

}else{
   $active_seed_id = $data[0]['ACTIVE_SEED_ID']; 
}
$seller_dir = 'D:/wamp/www/item_pictures/ebay_img/'.$lz_seller_id;
if (is_dir($seller_dir) === false){
    mkdir($seller_dir);
}
$dir = $seller_dir.'/'.$ebay_id;

if (is_dir($dir) === false){
    mkdir($dir);
}
$i = 1;
    foreach ($item->PictureDetails->PictureURL as $pictureurl) {

        $segments = explode('/', trim(parse_url($pictureurl, PHP_URL_PATH), '/'));
        $numSegments = count($segments); 
        $picKey = $segments[$numSegments - 2];
        $picUrl = "https://i.ebayimg.com/images/g/".$picKey."/s-l1600.jpg";// this url gives full size image
        $system_url = $dir.'/'.$ebay_id.'_'.$i.'.jpg';
        copy($picUrl, $system_url);
        $data = $this->db->query("SELECT PIC_URL_ID FROM LZ_EBAY_PICS A WHERE A.PICTUREURL = '$pictureurl' AND ACTIVE_SEED_ID = '$active_seed_id'")->result_array();
        if(count($data) === 0){
            
            $this->db->query("INSERT INTO LZ_EBAY_PICS
            (PIC_URL_ID,
            ACTIVE_SEED_ID,
            PICTUREURL,
            SYSTEM_URL,
            INSERTED_DATE,
            FULL_PIC_URL)
            VALUES(
            get_single_primary_key('LZ_EBAY_PICS','PIC_URL_ID'),
            '$active_seed_id',
            '$pictureurl',
            '$system_url',
             sysdate,
             '$picUrl'
            )");
            
        }
        $i++;

    }// end ofreach  picurl
}// end if ($response->Ack !== 'Failure')


/*=====  End of loop code  ======*/

    $this->db->query("UPDATE LJ_EBAY_ACTIVE_LISTING SET LOCAL_DOWNLOADED = 1 WHERE ACTIVE_LIST_ID = $active_list_id");
}// end main forecah $data as $ebayItem 

?>


