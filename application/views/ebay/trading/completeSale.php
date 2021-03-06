<?php
/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
use GuzzleHttp\Promise;

// $get_token = $this->db->query("SELECT E.USER_ID,E.DEV_ID,E.APP_ID,E.CERT_ID,E.AOUTH_TOKEN,E.LZ_SELLER_ACCOUNT_ID  FROM LZ_EBAY_DEV_CREDENTIALS_DT E WHERE E.USER_ID = '$user_id' ORDER BY E.LZ_SELLER_ACCOUNT_ID ASC")->result_array();
// foreach ($get_token as $key) {
//     $dev_ID = $key['DEV_ID'];
//     $app_ID = $key['APP_ID'];
//     $cert_ID = $key['CERT_ID'];
//     $user_Token = $key['AOUTH_TOKEN'];
//     $lz_seller_account_id = $key['LZ_SELLER_ACCOUNT_ID'];

    require __DIR__.'/../vendor/autoload.php';
    /**
     * Include the configuration values.
     */
    $config = require __DIR__.'/../configuration.php';
    /**
     * Create the service object.
     */
    $service = new Services\TradingService([
        'credentials' => $config['production']['credentials'],
        'siteId'      => Constants\SiteIds::US
    ]);

    /**
     * Create the request object.
     */
    //$date = new DateTime('now');
    $request = new Types\CompleteSaleRequestType();
    // Notice that we use [] because Filter is array like and we are pushing values into it.

    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

    //$request->Filter[] = 'PaidShipped';
    //$request->Filter[] = 'PaymentOverDue';
    // Notice that we no longer need [] because we are assigning an array to the property.
    $request->ItemID = "00000000000000000";
    $request->TransactionID = "00000000000000000";
    $request->Shipped = true;
    $request->OrderID = "000000000000000";
    $request->Shipment = new Types\ShipmentType();
    $request->Shipment->ShipmentTrackingDetails = new Types\ShipmentTrackingDetailsType();
    $request->Shipment->ShipmentTrackingDetails->ShipmentTrackingNumber = '000000000000000000';
    $request->Shipment->ShipmentTrackingDetails->ShippingCarrierUsed = 'USPS';



    /**
     * Send the request.
     */
    $response = $service->CompleteSale($request);

    echo "<pre>";
            print_r($response);
            echo "</pre>";
            exit;

    /**
     * Output the result of calling the service operation.
     */
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
        // printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
        

    }



//}//end get_token foreach


?>