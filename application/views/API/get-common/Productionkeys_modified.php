<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);
$get_acc = 2;//$this->session->userdata('account_type');
$user_id = 2;//faisal user id is 2
//$oauthUserToken='';
//if(@$browse_api === 1){
    $conn =  oci_connect('lz_bigData', 's', '192.168.0.78/LZBIGDATA');
    //$conn =  oci_connect('lz_bigData', 's', 'dbserver/LZBIGDATA');
    $q ="SELECT D.ACCOUNT_TYPE,D.DEV_ID,D.APP_ID,D.CERT_ID,D.RUNAME,D.AOUTH_TOKEN,D.APP_OAOUTH_TOKEN FROM LZ_EBAY_DEV_CREDENTIALS_DT D WHERE D.USER_ID = $user_id AND LZ_SELLER_ACCOUNT_ID = $get_acc";
    $dataa = oci_parse($conn, $q);
    oci_execute($dataa,OCI_DEFAULT);
    $row = oci_fetch_array($dataa, OCI_ASSOC);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    //$compatabilityLevel = 825;    // eBay API version
    $compatabilityLevel = 949;    // eBay API version
    if ($production) {

        $devID = $row['DEV_ID'];
        $appID = $row['APP_ID'];
        $certID = $row['CERT_ID'];
        if(!empty($row['AOUTH_TOKEN'])){
           $userToken = $row['AOUTH_TOKEN'];
        }else{
           $userToken = ''; 
        }

        $ruName = $row['RUNAME'];

        if(!empty($row['APP_OAOUTH_TOKEN'])){
           $oauthUserToken = $row['APP_OAOUTH_TOKEN'];
        }else{
           $oauthUserToken = ''; 
        }

        // $devID = '702653d3-dd1f-4641-97c2-dc818984bfaa';   // these prod keys are different from sandbox keys
        // $appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
        // $certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
        // //set the Server to use (Sandbox or Production)
         $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        // //the token representing the eBay user to assign the call with
        // $userToken = $token; 
        //$paypalEmailAddress= 'cute.sajid29@gmail.com';		
    } else {  
        $devID = '702653d3-dd1f-4641-97c2-dc818984bfaa';         // insert your devID for sandbox
        $appID = 'SajidKha-eRashanp-SBX-32f839347-808d8869';   // different from prod keys
        $certID = 'SBX-2f8393475fdc-e2ab-44b1-867f-e199';  // need three 'keys' and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        // the token representing the eBay user to assign the call with
        // this token is a long string - don't insert new lines - different from prod token
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**gFtJVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GgDpCGpQqdj6x9nY+seQ**PM8DAA**AAMAAA**Fi+1Cl1ohpYjtarq3rBdJFcy6LK5tLWHV8FWSH9cHhl2R4AfuIhdKScDaQPg6gn0xJpX/m97JRKljBkJ1auLXDA5b2ifKJq51gIFzxVmQ0fXvYfT9QIjWHnfKCZRqMg8x264bw3NouspfZJoGivHEn2G/4689m1/PPZ6cPqt1jaZYHY4EU0s61Cr9y1cimTIrttbTh7JXi2fi5lflqSeLKWELDig63uRfPCs+K7I3dFdAph/kw/4S+C8HNbm1IxL7g0KaS6PC8dAaUG/mH0w//bsnLvlqQNYjUChQc+6tufLNGegPUQonGXMTkRi5lCHrTCcEz6m8UPo9yK+cr/ZHbMa5WNzMWrDhwLQaYtQwtCKZfF9R3p6kb4uXd/jB/Bdnh1ZRZ7B7KXEGXi2SbK37/9DikaBGQcWDRoSWfsAYGsNR5ppn0/zMbq+v1EzgjAthoRKQ0Q2Bfsmh/ATOTY/HiKX/qIVq21PkebgHFZTEhJZ8whS0XUWtXGsPcvioUmXLMaxcgxZJtUaTHzCfHvMeZ1iRhow/tWgKv0fbukugzpHXDlJaTO4UHJIvt2I6okAs+RDFUGWrRMYi95FqDpAbkytCHaFR2tHbBKnCW6l8viyoX8Vicko53XShZhw0YRF7OJ3siWtJwd1BYWwYUq0inYgQJCRhjCYqvAOqyYhGYERYbMH60BihDMf9RHxyQnbKSwB5ph6iZWuWoBLHXgwNqg6QGm0vrGLDEQL8O4ygNxNOPbC2uWzIUz6fu3Ofev5'; 
		//$paypalEmailAddress = 'cute.sajid29@gmail.com';		
    }
  
?>