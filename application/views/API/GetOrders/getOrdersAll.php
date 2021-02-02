<?php 
$main_query = "SELECT  DISTINCT M.LZ_SELLER_ACCT_ID FROM LZ_SALESLOAD_DET D, LZ_SALESLOAD_MT M WHERE D.TRACKING_NUMBER IS NULL  AND UPPER(D.ORDERSTATUS) <> 'CANCELLED' AND D.LZ_SALESLOAD_DET_ID > 1730945691 AND M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID";

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
    //$main_query = "SELECT D.SALES_RECORD_NUMBER, D.ORDER_ID,D.ORDERSTATUS , D.SALE_DATE ,A.ACCT_ID ,A.TOKEN FROM LZ_SALESLOAD_DET D, LZ_SALESLOAD_MT M , LJ_MERHCANT_ACC_DT A WHERE D.TRACKING_NUMBER IS NULL AND D.LZ_SALESLOAD_DET_ID > 1730945691 AND M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND M.LZ_SELLER_ACCT_ID = A.ACCT_ID AND M.LZ_SELLER_ACCT_ID = 2 ORDER BY TO_NUMBER(D.LZ_SALESLOAD_DET_ID) DESC";
    $getParm = "SELECT TO_CHAR(MIN(MIN_SALE),'YYYY-MM-DD HH24:MM:SS') MIN_SALE , TO_CHAR(MAX(MAX_SALE),'YYYY-MM-DD HH24:MM:SS') MAX_SALE , MAX(TOKEN) TOKEN FROM (SELECT A.TOKEN , D.SALE_DATE MIN_SALE ,D.SALE_DATE MAX_SALE FROM LZ_SALESLOAD_DET D, LZ_SALESLOAD_MT M , LJ_MERHCANT_ACC_DT A WHERE D.TRACKING_NUMBER IS NULL AND UPPER(D.ORDERSTATUS) <> 'CANCELLED' AND D.LZ_SALESLOAD_DET_ID > 1730945691 AND M.LZ_SALELOAD_ID = D.LZ_SALELOAD_ID AND M.LZ_SELLER_ACCT_ID = A.ACCT_ID AND M.LZ_SELLER_ACCT_ID = $LZ_SELLER_ACCT_ID )"; 
 	$getParm = $this->db->query($getParm)->result_array(); // array of ebay accounts

    $userToken = $getParm[0]['TOKEN'];
    $ModTimeFrom = $getParm[0]['MIN_SALE'];
	$ModTimeTo = $getParm[0]['MAX_SALE'];
    include 'GetOrders_mod.php';
}
?>
