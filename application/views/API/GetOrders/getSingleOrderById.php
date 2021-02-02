<?php 

$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa'; // dev account info
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
$compatabilityLevel = 949;    // eBay API version

require_once('/../get-common/eBaySession.php');
//require_once('get-common/eBaySession.php');// local ebay session path

    //$LZ_SELLER_ACCT_ID = 2;

 	$getParm = $this->db->query("SELECT S.SITE_TOKEN TOKEN FROM LZ_SELLER_ACCTS S WHERE S.LZ_SELLER_ACCT_ID = $LZ_SELLER_ACCT_ID")->result_array(); // array of ebay orders
 	if(count($getParm) > 0){
 		$userToken = $getParm[0]['TOKEN'];
	    $order_ids = "<OrderID>$ORDER_ID</OrderID>";// extended order id also works
	   // echo $order_ids .'--' .$LZ_SELLER_ACCT_ID;
	    
	    include 'GetOrders_ById.php';
 	}else{
 		echo "Token not found against seller id: $LZ_SELLER_ACCT_ID";
 	}
    

?>
