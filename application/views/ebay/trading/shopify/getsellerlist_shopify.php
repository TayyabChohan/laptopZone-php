<?php

require __DIR__.'../../../vendor/autoload.php';

$config = require __DIR__.'../../../configuration_for_shopify.php';

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
$request->DetailLevel->ItemReturnDescription = ['ReturnAll'];
$request->UserID = "techbargains2015";
//$request->UserID = "sajid029";
$request->GranularityLevel  = "Fine";

$request->Pagination = new Types\PaginationType();
$request->Pagination->EntriesPerPage = 1;
//$request->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;

$pageNum = 1;

do {
    $request->Pagination->PageNumber = $pageNum;

    /**
     * Send the request.
     */
   $response = $service->getSellerList($request);
echo "<pre>";
print_r($response);
echo "</pre>";exit;
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
        // exit;
        foreach ($response->ItemArray->Item as $item) {

            //$ItemID = trim(str_replace("  ", ' ', $item->ItemID));
            $Title = trim(str_replace("  ", ' ', $item->Title));
            $Description = trim(str_replace("  ", ' ', $item->Description));
            $currencyID = trim(str_replace("  ", ' ', $item->SellingStatus->CurrentPrice->currencyID));
            $priceValue = trim(str_replace("  ", ' ', $item->SellingStatus->CurrentPrice->value));
            $PictureURL = trim(str_replace("  ", ' ', $item->PictureDetails->PictureURL[0]));
            //$ExternalPictureURL = trim(str_replace("  ", ' ', $item->PictureDetails->ExternalPictureURL));
            //$ExtendedPictureDetails = trim(str_replace("  ", ' ', $item->PictureDetails->ExtendedPictureDetails));
            $GalleryURL = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryURL));

            $GalleryType = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryType));
            $PhotoDisplay = trim(str_replace("  ", ' ', $item->PictureDetails->PhotoDisplay));
            $PictureSource = trim(str_replace("  ", ' ', $item->PictureDetails->PictureSource));
            $GalleryDuration = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryDuration));
            $GalleryStatus = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryStatus));

            $majorWeight = $item->ShippingPackageDetails->WeightMajor->value;
            $weightUnit = $item->ShippingPackageDetails->WeightMajor->unit;

            $minorWeight = $item->ShippingPackageDetails->WeightMinor->value;
            $minorWeightUnit = $item->ShippingPackageDetails->WeightMinor->unit;
            // printf(
            //     "(%s) %s: %s %.2f\n",
            //     $item->ItemID,
            //     $item->Title,
            //     $item->SellingStatus->CurrentPrice->currencyID,
            //     $item->SellingStatus->CurrentPrice->value
            // );
            echo "<br>Item ID: ".$item->ItemID." <br> Title: ".$Title." <br> Description: ".$Description."<br> Currency Id: ".$currencyID."<br> Price: ".$priceValue."<br>PictureURL : ".$PictureURL."<br>GalleryURL: ".$GalleryURL."<br>GalleryType: ".$GalleryType."<br>PhotoDisplay: ".$PhotoDisplay."<br>PictureSource: ".$PictureSource."<br>GalleryDuration: ".$GalleryDuration."<br>GalleryStatus: ".$GalleryStatus."<br> Weight: ".$majorWeight." ".$weightUnit."<br> Minor Weight: ".$minorWeight.$minorWeightUnit;
        }
    }

    $pageNum += 1;

} while (isset($response->ItemArray) && $pageNum <= $response->PaginationResult->TotalNumberOfPages);


$item_source = "{\r\n  \"product\": {\r\n    \"title\": \"$Title\",\r\n    \"body_html\": \"<strong>Good snowboard!</strong>\",\r\n    \"vendor\": \"Burton\",\r\n    \"product_type\": \"Snowboard\",\r\n    \"images\": [\r\n    \t\r\n      {\r\n        \"position\": 1,\r\n      \t\"src\": \"http://i.ebayimg.com/00/s/MTA2NlgxNjAw/z/--sAAOSwbsBXjSuZ/\$_57.JPG?set_id=8800005007\"\r\n      },\r\n      {\r\n        \"position\": 2,\r\n        \"src\": \"http://i.ebayimg.com/00/s/MTA2NlgxNjAw/z/hH8AAOSwaB5XjSt8/\$_57.JPG?set_id=8800005007\"\r\n      },\r\n\t\t{\r\n        \"position\": 3,\r\n        \"src\": \"http://i.ebayimg.com/00/s/MTA2NlgxNjAw/z/kP0AAOSwIgNXjSuK/\$_57.JPG?set_id=8800005007\"\r\n      }      \r\n      ],\r\n    \"variants\": [\r\n      {\r\n    \t\"price\": \"2000.00\",\r\n    \t\"sku\":\"123456\",\r\n    \t\"inventory_quantity\": 10,      \t\r\n        \"option1\": \"Blue\",\r\n        \"option2\": \"155\"\r\n      },\r\n      {\r\n    \t\"price\": \"2000.00\",\r\n    \t\"sku\":\"123456\",\r\n    \t\"inventory_quantity\": 10,       \t\r\n        \"option1\": \"Black\",\r\n        \"option2\": \"159\"\r\n      }\r\n    ],\r\n    \"options\": [\r\n      {\r\n        \"name\": \"Color\",\r\n        \"values\": [\r\n          \"Blue\",\r\n          \"Black\"\r\n        ]\r\n      },\r\n      {\r\n        \"name\": \"Size\",\r\n        \"values\": [\r\n          \"155\",\r\n          \"159\"\r\n        ]\r\n      }\r\n    ]\r\n  }\r\n}";
 var_dump($item_source); exit;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products.json",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $item_source,
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic YzA4NGRiMDczM2I4ZGIyYWVmOWYyYTNhMzdiNzMxNGU6ZDE5YjFmNmVlY2UxNTMxM2NlMjg5YjgwZTIwNjI4NmY=",
    "Cache-Control: no-cache",
    "Content-Type: application/json",
    "Postman-Token: 727dc912-43d9-40de-839c-650fbbc68dbd"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

