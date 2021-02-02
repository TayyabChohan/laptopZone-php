<?php
// require __DIR__.'/vendor/autoload.php';
// use \DTS\eBaySDK\Constants;
// use \DTS\eBaySDK\Trading\Services;
// use \DTS\eBaySDK\Trading\Types;
// use \DTS\eBaySDK\Trading\Enums;

require __DIR__.'../../../vendor/autoload.php';

$config = require __DIR__.'../../../configuration_for_shopify.php';

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
$request = new Types\GetItemRequestType() ;
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
//$ebay_id = $this->session->userdata('ebay_item_id');

//var_dump($ebay_id);exit;
//$ebayIds = $ebay_id;

//foreach($ebayIds as $id):


//$id = "222195065258";
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

    $ItemID = trim(str_replace("  ", ' ', $item->ItemID));
    $ItemID = trim(str_replace(array("'"), "''", $ItemID));

    $ListingStatus = trim(str_replace("  ", ' ', $item->SellingStatus->ListingStatus));
    $QuantitySold = trim(str_replace("  ", ' ', $item->SellingStatus->QuantitySold));
    $Quantity = trim(str_replace("  ", ' ', $item->Quantity));
    $Quantity = $Quantity - $QuantitySold;

    //var_dump($ListingStatus, $QuantitySold, $Quantity); exit;
    $result = array(
        'ListingStatus' => $ListingStatus,
        'Quantity' => $Quantity
    );
    $this->session->set_userdata($result);
    //var_dump($UPC);  //exit;
    //echo "<br>Item ID: ".$ItemID." <br> Title: ".$Title." <br> Description: ".$Description."<br> Quantity :".$Quantity."<br> Currency Id: ".$currencyID."<br> Price: ".$priceValue."<br>PictureURL : ".$PictureURL."<br>GalleryURL: ".$GalleryURL."<br>GalleryType: ".$GalleryType."<br>PhotoDisplay: ".$PhotoDisplay."<br>PictureSource: ".$PictureSource."<br>GalleryDuration: ".$GalleryDuration."<br>GalleryStatus: ".$GalleryStatus."<br> Major Weight: ".$majorWeight.$weightUnit."<br> Minor Weight: ".$minorWeight.$minorWeightUnit."<br> ConditionDescription: ".$ConditionDescription."<br> UPC: ".$UPC."<br> MPN: ".$MPN."<br> Brand: ".$Brand;


}

//endforeach;

?>