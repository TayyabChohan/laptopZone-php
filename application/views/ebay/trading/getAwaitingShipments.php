<?php
/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
use GuzzleHttp\Promise;
//$this->db->query("TRUNCATE TABLE LZ_AWAITING_SHIPMENT");
$get_token = $this->db->query("SELECT E.USER_ID,E.DEV_ID,E.APP_ID,E.CERT_ID,E.AOUTH_TOKEN,E.LZ_SELLER_ACCOUNT_ID  FROM LZ_EBAY_DEV_CREDENTIALS_DT E WHERE E.USER_ID = '$user_id' ORDER BY E.LZ_SELLER_ACCOUNT_ID ASC")->result_array();
foreach ($get_token as $key) {
    $dev_ID = $key['DEV_ID'];
    $app_ID = $key['APP_ID'];
    $cert_ID = $key['CERT_ID'];
    $user_Token = $key['AOUTH_TOKEN'];
    $lz_seller_account_id = $key['LZ_SELLER_ACCOUNT_ID'];

    require __DIR__.'/../vendor/autoload.php';
    /**
     * Include the configuration values.
     */
    $config = require __DIR__.'/../configuration_modified.php';
    /**
     * Create the service object.
     */
    $service = new Services\TradingService([
        'credentials' => $config['production2']['credentials'],
        'siteId'      => Constants\SiteIds::US
    ]);

    /**
     * Create the request object.
     */
    //$date = new DateTime('now');
    $request = new Types\GetSellingManagerSoldListingsRequestType();
    // Notice that we use [] because Filter is array like and we are pushing values into it.

    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    $request->RequesterCredentials->eBayAuthToken = $config['production2']['authToken'];

    //$request->Filter[] = 'PaidShipped';
    //$request->Filter[] = 'PaymentOverDue';
    // Notice that we no longer need [] because we are assigning an array to the property.
    $request->Filter = ['PaidNotShipped'];
    //$request = new Types\GeteBayOfficialTimeRequestType();

    /**
     * An user token is required when using the Trading service.
     */
    // $request->SaleDateRange = new Types\TimeRangeType();
    // $request->SaleDateRange->TimeTo = $date;
    // $request->SaleDateRange->TimeFrom = $date->modify('-120 days');
    $request->Pagination = new Types\PaginationType();
    $request->Pagination->EntriesPerPage = 200;
    $request->Pagination->PageNumber = 1;
    $request->Sort = Enums\SellingManagerSoldListingsSortTypeCodeType::C_PAID_DATE;
    //$request->Filter[] = 'NotShipped';
    //$request->Filter[] = 'Unshipped';


    /**
     * Send the request.
     */
    $response = $service->GetSellingManagerSoldListings($request);

    // echo "<pre>";
    //         print_r($response);
    //         echo "</pre>";
    //         exit;

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
        
        foreach ($response->SaleRecord as $record) {
            $SellingManagerSoldTransaction = $record->SellingManagerSoldTransaction;

            foreach ($SellingManagerSoldTransaction as $transaction) {
                $TransactionID = $transaction->TransactionID;
                $SaleRecordID = $transaction->SaleRecordID;
                $OrderLineItemID = $transaction->OrderLineItemID;

                //$this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID,LZ_SELLER_ACCOUNT_ID) VALUES('$TransactionID','$SaleRecordID','$OrderLineItemID','$lz_seller_account_id')");
                $this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID, LZ_SELLER_ACCOUNT_ID) SELECT '$TransactionID', '$SaleRecordID', '$OrderLineItemID', '$lz_seller_account_id' FROM DUAL WHERE NOT EXISTS (SELECT * FROM LZ_AWAITING_SHIPMENT A WHERE A.ORDERLINEITEMID = '$OrderLineItemID') ");

            }
        }
    }


/**
 * Paginate through upto 20 more pages worth of results.
 * The requests for these pages will be made concurrently.
 */
$limit = min($response->PaginationResult->TotalNumberOfPages, 100);
$promises = [];
for ($pageNum = 2; $pageNum <= $limit; $pageNum++) {
    $request->Pagination->PageNumber = $pageNum;
    //$request->paginationInput->pageNumber = $pageNum;
    $promises[$pageNum] = $service->getSellingManagerSoldListingsAsync($request);
}

/**
 * Wait on all promises to complete.
 */
$results = Promise\unwrap($promises);

foreach ($results as $pageNum => $response) {

        if ($response->Ack !== 'Failure') {
        // printf("The official eBay time is: %s\n", $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y'));
        
        foreach ($response->SaleRecord as $record) {
            $SellingManagerSoldTransaction = $record->SellingManagerSoldTransaction;

            foreach ($SellingManagerSoldTransaction as $transaction) {
                $TransactionID = $transaction->TransactionID;
                $SaleRecordID = $transaction->SaleRecordID;
                $OrderLineItemID = $transaction->OrderLineItemID;

                //$this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID,LZ_SELLER_ACCOUNT_ID) VALUES('$TransactionID','$SaleRecordID','$OrderLineItemID','$lz_seller_account_id')");
                $this->db->query("INSERT INTO LZ_AWAITING_SHIPMENT (TRANSACTIONID, SALERECORDID, ORDERLINEITEMID, LZ_SELLER_ACCOUNT_ID) SELECT '$TransactionID', '$SaleRecordID', '$OrderLineItemID', '$lz_seller_account_id' FROM DUAL WHERE NOT EXISTS (SELECT * FROM LZ_AWAITING_SHIPMENT A WHERE A.ORDERLINEITEMID = '$OrderLineItemID') ");

            }
        }
    }
}

}//end get_token foreach


?>