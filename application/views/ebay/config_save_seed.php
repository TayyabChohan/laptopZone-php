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

// if (php_sapi_name() == "cli") {
//     // In cli-mode
//     //$user_id = 2;
// } else {
//     // Not in cli-mode
//}
$get_token = $this->db->query("SELECT D.ACCOUNT_TYPE,D.DEV_ID,D.APP_ID,D.CERT_ID,D.RUNAME,D.AOUTH_TOKEN,D.APP_OAOUTH_TOKEN FROM LZ_EBAY_DEV_CREDENTIALS_DT D WHERE D.USER_ID = '$user_id' AND LZ_SELLER_ACCOUNT_ID = '$account_id'")->result_array();

$devID = $get_token[0]['DEV_ID'];
$appID = $get_token[0]['APP_ID'];
$certID = $get_token[0]['CERT_ID'];
if(!empty($get_token[0]['AOUTH_TOKEN'])){
   $userToken = $get_token[0]['AOUTH_TOKEN'];
}else{
   $userToken = ''; 
}

$ruName = $get_token[0]['RUNAME'];

if(!empty($get_token[0]['APP_OAOUTH_TOKEN'])){
   $oauthUserToken = $get_token[0]['APP_OAOUTH_TOKEN'];
}else{
   $oauthUserToken = ''; 
}


return [
    'sandbox' => [
        'credentials' => [
            'devId' => '702653d3-dd1f-4641-97c2-dc818984bfaa',
            'appId' => 'SajidKha-eRashanp-SBX-32f839347-808d8869',
            'certId' => 'SBX-2f8393475fdc-e2ab-44b1-867f-e199',
        ],
        'authToken' => 'AgAAAA**AQAAAA**aAAAAA**iEZ1Wg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GgDpCGpQqdj6x9nY+seQ**PM8DAA**AAMAAA**Fi+1Cl1ohpYjtarq3rBdJFcy6LK5tLWHV8FWSH9cHhl2R4AfuIhdKScDaQPg6gn0xJpX/m97JRKljBkJ1auLXDA5b2ifKJq51gIFzxVmQ0fXvYfT9QIjWHnfKCZRqMg8x264bw3NouspfZJoGivHEn2G/4689m1/PPZ6cPqt1jaZYHY4EU0s61Cr9y1cimTIrttbTh7JXi2fi5lflqSeLKWELDig63uRfPCs+K7I3dFdAph/kw/4S+C8HNbm1IxL7g0KaS6PC8dAaUG/mH0w//bsnLvlqQNYjUChQc+6tufLNGegPUQonGXMTkRi5lCHrTCcEz6m8UPo9yK+cr/ZHbMa5WNzMWrDhwLQaYtQwtCKZfF9R3p6kb4uXd/jB/Bdnh1ZRZ7B7KXEGXi2SbK37/9DikaBGQcWDRoSWfsAYGsNR5ppn0/zMbq+v1EzgjAthoRKQ0Q2Bfsmh/ATOTY/HiKX/qIVq21PkebgHFZTEhJZ8whS0XUWtXGsPcvioUmXLMaxcgxZJtUaTHzCfHvMeZ1iRhow/tWgKv0fbukugzpHXDlJaTO4UHJIvt2I6okAs+RDFUGWrRMYi95FqDpAbkytCHaFR2tHbBKnCW6l8viyoX8Vicko53XShZhw0YRF7OJ3siWtJwd1BYWwYUq0inYgQJCRhjCYqvAOqyYhGYERYbMH60BihDMf9RHxyQnbKSwB5ph6iZWuWoBLHXgwNqg6QGm0vrGLDEQL8O4ygNxNOPbC2uWzIUz6fu3Ofev5',

        'oauthUserToken' => $oauthUserToken,
        'ruName' => 'Sajid_Khan-SajidKha-eRasha-rzapayttt'
    ],

    'production' => [
        'credentials' => [
            'devId' => $devID,
            'appId' => $appID,
            'certId' => $certID,
        ],
        'authToken' => $userToken,
        'oauthUserToken' => $oauthUserToken,
        'ruName' => $ruName

    ]
];

?>