<?php

require __DIR__.'/../vendor/autoload.php';

$config = require __DIR__.'/../configuration.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

$siteId = Constants\SiteIds::US;

$service = new Services\TradingService([    
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);

$request = new Types\GetSellerListRequestType();

$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

$request->StartTimeFrom = new DateTime("Jul 01, 2016 15:53:03 PDT");

$request->StartTimeTo = new DateTime("Aug 01, 2016 15:53:03 PDT");

// $request->EndTimeFrom = new DateTime("Aug 18, 2016 15:53:03 PDT");

// $request->EndTimeTo = new DateTime("Aug 18, 2016 15:53:03 PDT");

$request->UserID = "techbargains2015";
//$request->UserID = "sajid029";
$request->GranularityLevel  = "Fine";

$request->Pagination = new Types\PaginationType();
$request->Pagination->EntriesPerPage = 10;
//$request->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$pageNum = 1;

do {
    $request->Pagination->PageNumber = $pageNum;

    /**
     * Send the request.
     */
   $response = $service->getSellerList($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";exit;
    /**
     * Output the result of calling the service operation.
     */
    echo "==================\nResults for page $pageNum\n==================\n";

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

    if ($response->Ack !== 'Failure' && isset($response->ItemArray)) {
        echo "<pre>";
        print_r($response);
        echo "</pre>";
        exit;
        foreach ($response->ItemArray->Item as $item) {
            // printf(
            //     "(%s) %s: %s %.2f\n",
            //     $item->ItemID,
            //     $item->Title,
            //     $item->SellingStatus->CurrentPrice->currencyID,
            //     $item->SellingStatus->CurrentPrice->value
            // );
            echo "<br>Item ID: ".$item->ItemID." <br> Title: ".$item->Title." <br> Description: ".$item->Description."<br> Currency Id: ".$item->SellingStatus->CurrentPrice->currencyID."<br> Price: ".$item->SellingStatus->CurrentPrice->value."<br>PictureURL : ".$item->PictureDetails->PictureURL[0]."<br>ExternalPictureURL: ".$item->PictureDetails->ExternalPictureURL."<br>ExtendedPictureDetails: ".$item->PictureDetails->ExtendedPictureDetails."<br>GalleryURL: ".$item->PictureDetails->GalleryURL."<br>GalleryType: ".$item->PictureDetails->GalleryType."<br>PhotoDisplay: ".$item->PictureDetails->PhotoDisplay."<br>PictureSource: ".$item->PictureDetails->PictureSource."<br>GalleryDuration: ".$item->PictureDetails->GalleryDuration."<br>GalleryStatus: ".$item->PictureDetails->GalleryStatus."";
        }
    }

    $pageNum += 1;

} while (isset($response->ItemArray) && $pageNum <= $response->PaginationResult->TotalNumberOfPages);



