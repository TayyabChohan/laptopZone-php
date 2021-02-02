<?php
// require __DIR__.'/vendor/autoload.php';
// use \DTS\eBaySDK\Constants;
// use \DTS\eBaySDK\Trading\Services;
// use \DTS\eBaySDK\Trading\Types;
// use \DTS\eBaySDK\Trading\Enums;

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__.'/../configuration.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;


if(empty(@$site_id)){
    $siteId = Constants\SiteIds::US; 
}
//$siteId = Constants\SiteIds::US;
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
    'siteId'      => $siteId
]);
$request = new Types\GetItemRequestType() ;
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
//$ebay_id = $this->session->userdata('ebay_item_id');
$request->ItemID = $ebay_id;

//0$request->DetailLevel = ['ReturnAll'];
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
    return $response->Errors;
}
if ($response->Ack !== 'Failure') {
    $item = $response->Item;
    $sold_qty = $item->SellingStatus->QuantitySold;
    $total_qty = $item->Quantity;
    $current_qty = $total_qty - $sold_qty;
    $this->session->set_userdata('current_qty_adj', $current_qty);
// echo json_encode($current_qty);
//        return json_encode($current_qty);
    // return $current_qty;
    // return 1;
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
    //$ebay_item_url = $item->ListingDetails->ViewItemURL;
    //$this->session->set_userdata('ebay_item_url', $ebay_item_url);
    //echo "<br>Item ID: ".$item->ItemID." <br> Title: ".$item->Title." <br> Description: ".$item->Description."<br> Quantity :".$item->Quantity."<br> Item URL :".$item->ListingDetails->ViewItemURL."<br> ";

    // $item->ListingDetails->ViewItemURL;
    //  echo "<br>Item ID: ".$item->ItemID." <br> Title: ".$item->Title." <br> Description: ".$item->Description."<br> Quantity :".$item->Quantity."<br> Currency Id: ".$item->SellingStatus->CurrentPrice->currencyID."<br> Price: ".$item->SellingStatus->CurrentPrice->value."<br>PictureURL : ".$item->PictureDetails->PictureURL[0]."<br>ExternalPictureURL: ".$item->PictureDetails->ExternalPictureURL."<br>ExtendedPictureDetails: ".$item->PictureDetails->ExtendedPictureDetails."<br>GalleryURL: ".$item->PictureDetails->GalleryURL."<br>GalleryType: ".$item->PictureDetails->GalleryType."<br>PhotoDisplay: ".$item->PictureDetails->PhotoDisplay."<br>PictureSource: ".$item->PictureDetails->PictureSource."<br>GalleryDuration: ".$item->PictureDetails->GalleryDuration."<br>GalleryStatus: ".$item->PictureDetails->GalleryStatus."<br><br><br>";
    // print("Domestic Shipping Information\n");
    // foreach ($item->ShippingDetails->ShippingServiceOptions as $shipping) {
    //     printf(
    //         "[%s] (%s)%.2f\n",
    //         $shipping->ShippingService,
    //         $shipping->ShippingServiceCost->currencyID,
    //         $shipping->ShippingServiceCost->value
    //     );
    //}
}