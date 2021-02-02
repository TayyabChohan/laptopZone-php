<?php
/**
 * Configuration settings used by all of the examples.
 *
 * Specify your eBay application keys in the appropriate places.
 *
 * Be careful not to commit this file into an SCM repository.
 * You risk exposing your eBay application keys to more people than intended.
 *
 * For more information about the configuration, see:
 * http://devbay.net/sdk/guides/sample-project/
 */
//  $main_query = "select d.Token_Priority, d.token,D.ACCOUNT_NAME
//  from lj_merhcant_acc_dt d, LZ_MERCHANT_MT M
//  where M.MERCHANT_ID = D.MERCHANT_ID
//  AND M.ACTIVE_DEACTIVE = 1
//  AND d.token is not null 
//  AND D.TOKEN_PRIORITY IS NOT NULL
//  group by d.Token_Priority,d.token ,D.ACCOUNT_NAME
//  ORDER BY D.TOKEN_PRIORITY 
//  ";

 $main_query = "select d.token,s.LZ_SELLER_ACCT_ID from 
 lz_seller_accts s, lj_merhcant_acc_dt d
 where d.acct_id = s.lz_seller_acct_id 
 and d.token is not null
 ";

// $main_query = "select t.lz_seller_acct_id, t.user_aouth_token token
// from LZ_SELLER_ACCTS t
// where t.lz_seller_acct_id not in (1, 2)
//  ";
$main_query = $this->db->query($main_query)->result_array(); // array of ebay accounts
$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa'; // dev account info
$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
$serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
$compatabilityLevel = 949;    // eBay API version

?>