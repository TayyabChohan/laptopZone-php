<?php 

$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa'; // dev account info
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
$compatabilityLevel = 949;    // eBay API version

require_once('/../get-common/eBaySession.php');

    $LZ_SELLER_ACCT_ID = $sellerId;
    $getParm = "SELECT S.SITE_TOKEN FROM LZ_SELLER_ACCTS S WHERE S.LZ_SELLER_ACCT_ID = $LZ_SELLER_ACCT_ID"; 
 	$getParm = $this->db->query($getParm)->result_array(); // array of ebay accounts

    $userToken = $getParm[0]['SITE_TOKEN'];
    include 'GetSellerOrdersAPI.php';
?>
