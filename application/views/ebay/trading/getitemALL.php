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
foreach($listed_ebay_id as $ebay_id):
    $request->ItemID = $ebay_id['EBAY_ITEM_ID'];
    //$request->DetailLevel = ['ReturnAll'];
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

        $ebay_item_url = $item->ListingDetails->ViewItemURL;
        $ebay_item_url = trim(str_replace("  ", ' ', $ebay_item_url));
        $ebay_item_url = trim(str_replace(array("'"), "''", $ebay_item_url));
        //$this->session->set_userdata('ebay_item_url', $ebay_item_url);
        
    $ebay_item_id = $item->ItemID;
     //$ebay_item_url = $this->session->userdata('ebay_item_url');
     date_default_timezone_set("America/Chicago");
     $list_date = date("Y-m-d H:i:s");
     $ins_date= "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
     $entered_by = 17; 
     $comma = ',';
         
        $conn =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL');
        $select_query = "SELECT * FROM LZ_LISTED_ITEM_URL WHERE EBAY_ID = $ebay_item_id";
        $select =oci_parse($conn, $select_query);
        oci_execute($select,OCI_DEFAULT);
        $num_row = oci_fetch_array($select, OCI_ASSOC);
        if($num_row == false){
        //$insert_query = $this->db->query("INSERT INTO LZ_LISTED_ITEM_URL VALUES ($ebay_item_id $comma '$ebay_item_url' $comma $ins_date $comma $entered_by)");
         $qry = "INSERT INTO LZ_LISTED_ITEM_URL VALUES ($ebay_item_id $comma '$ebay_item_url' $comma $ins_date $comma $entered_by)";

        $cmd =oci_parse($conn, $qry);
        oci_execute($cmd,OCI_DEFAULT);
        oci_commit($conn);
     }
       
}
endforeach;
?>