<?php 
require_once('/../../ebay/config_getOrder.php');
require_once('/../get-common/eBaySession.php');

foreach($main_query as $acc_query)
{
    $LZ_SELLER_ACCT_ID = $acc_query['LZ_SELLER_ACCT_ID'];
    $userToken = $acc_query['TOKEN'];
    include 'GetOrders_new.php';
}
?>
