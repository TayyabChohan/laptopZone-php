<?php 
$main_query = "SELECT  DISTINCT M.LZ_SELLER_ACCT_ID FROM LZ_SALESLOAD_DET D, LZ_SALESLOAD_MT M WHERE D.TRACKING_NUMBER IS NULL AND UPPER(D.ORDERSTATUS) <> 'CANCELLED' AND D.LZ_SALESLOAD_DET_ID > 1730945691 AND M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID";

$main_query = $this->db->query($main_query)->result_array(); // array of ebay accounts
$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa'; // dev account info
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
$compatabilityLevel = 949;    // eBay API version

require_once('/../get-common/eBaySession.php');

foreach($main_query as $acc_query)
{
    $LZ_SELLER_ACCT_ID = $acc_query['LZ_SELLER_ACCT_ID'];
    // if((int)$LZ_SELLER_ACCT_ID > 2){
     	$awaiting_cond = '';
    // }else{
    // 	$awaiting_cond = 'AND D.ORDER_ID NOT IN (SELECT A.ORDERLINEITEMID FROM LZ_AWAITING_SHIPMENT A WHERE A.LZ_SELLER_ACCOUNT_ID = $LZ_SELLER_ACCT_ID)';
    // 	//$awaiting_cond = '';

    // }
    $getParm = "SELECT AA.TOKEN, ORDER_ID
				  FROM LJ_MERHCANT_ACC_DT AA,
				       (SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, '<OrderID>' || D.ORDER_ID || '</OrderID>') ORDER BY d.LZ_SALESLOAD_DET_ID DESC NULLS LAST)
				                               .GETCLOBVAL(),
				                               '<A>',
				                               ''),
				                       '</A>',
				                       ' ') AS order_id
				          FROM LZ_SALESLOAD_DET D, LZ_SALESLOAD_MT M
				         WHERE D.TRACKING_NUMBER IS NULL
				           AND D.ORDER_ID IS NOT NULL
				           AND UPPER(D.ORDERSTATUS) <> 'CANCELLED'
				           AND D.LZ_SALESLOAD_DET_ID > 1730945691
				           AND M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID 
				           AND D.ORDER_ID <> '283487001639-1992618185018'
				           $awaiting_cond 
				           AND M.LZ_SELLER_ACCT_ID = $LZ_SELLER_ACCT_ID)
				 WHERE AA.ACCT_ID = $LZ_SELLER_ACCT_ID"; 
 	$getParm = $this->db->query($getParm)->result_array(); // array of ebay orders
 	if(count($getParm) > 0){
 		$userToken = $getParm[0]['TOKEN'];
	    $order_ids = $getParm[0]['ORDER_ID']->load();
	    $order_ids = str_replace('&lt;', '<', $order_ids);
	    $order_ids = str_replace('&gt;', '>', $order_ids);
	    $print_r = false;
	    //var_dump($order_ids);
	    //exit;
		include 'GetOrders_ById.php';
 	}else{
 		echo "no orders found against seller id: $LZ_SELLER_ACCT_ID";
 	}
    
}
?>
