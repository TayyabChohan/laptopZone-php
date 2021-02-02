<?php
/*  © 2007-2013 eBay Inc., All Rights Reserved */
/* Licensed under CDDL 1.0 -  http://opensource.org/licenses/cddl1.php */

    //show all errors - useful whilst developing
    error_reporting(E_ALL);
$get_acc = $this->session->userdata('account_type');
if(!empty($get_acc))
{
    //if($get_acc == 'dfwonline')
        if($get_acc == 2)
    {

        $token = 'AgAAAA**AQAAAA**aAAAAA**Mfr9WA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIGpD5aGqQidj6x9nY+seQ**u0gDAA**AAMAAA**4QITUIgSLf2WCM34ebAwFO33B0o3woFE29IysRK9Mri4hYw56tr5HGkgIyOPBjX6bp7x7wLb93HGiFeeYqPSB1163UbcCB94xGJ6tg5MapK2DWS8Dlz/EIQExi9tsoOvsMiwTyQOA+93pWHJx615ZsNMHWR9FB9mLfdV5OtCpjoaj/7Grv+d89aUyRssdZz+8mA7ir4w2HSA1nmNXzkNgtKhDIQ2bESPjsNoezK1PaTd5wcbAS8B5s0a5s2TSy0tEYng/u/M4zlX6NgR9zFtCitXGeimMGhqdeRuDTtTb015LFSNVZp75R2lH9Kwt3he37ptCrJcfsAPb5H6vb2Na3dV2Lmeb4nmBGgrJvxPBah+CA+VtA5KxEsSsdzp9GATyUkW7aneuZ6jHXqNAvx+WDTiMWS0wOE2p72dno/bH+Q1ntjNTIbez3SxKNNjkPvzD/Kg9sOvDfzSVwVBH5MHBo4JhQLR3yP9gkfpXUCV+VG9wqrUz9QrzdKmtGFKkgIgRjmEg+UzBlkf8FXvgsuDxNXDTS+LIWnxuzIeTMxACENm37PYJYSF6zjR/RXy8YpvWwgobNiswN9FbKXseGfPW/VrdGd1ktnwADnzvdCheuYDMhA9voa5VlnOtqQfRAUsci0TmMvX+k13h4sS42+wGtXXEeaoCZcIa6vxXeq9FrY7dBpNACUHXaiKC1QVA7wFXeAeTaSE1oe+Zrw/Mv3TmDf8+/b4ZaeWY8K1eaVZixMSEL9tRvbNhQsi68A/+itW'; 
    }elseif($get_acc == 1){
    //if($get_acc == 'dfwonline'){

        $token = 'AgAAAA**AQAAAA**aAAAAA**/fr9WA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**fP/SN5SP+vPp+ayJj+0KyVPiHH2LjI+9xCdet/7TAsVeBOYg2rXW6GhJS6wywdcwWjdzOlfistwdMWXqw5CR585S1wAgTlBX2mFgfnZM6E5x09lJ1mc6Obzbe13YXDcqJAMFVd8R0guIQaH8Fg3oWx48EcVoBFTG1YbzVrlNpWPqw4fX1uMR0LneLdv6m+QXgbr+CQFLEUxE0csNQa16nUJe8LrlsJiGIYj/ppO98ZTLFjfiiZV0pITQhuuDlvfX/lcuCHfcC8bosiBfowHyzKqX7JfDb+9X4fKY+oheUgdXpWQE9hendhaEdvT2HZCGpQ8lSyrefDRRsya2DteX07AwJx0jv9QpW6orVP/YV0bYxRgUyMPVgbQjX/KbWXT7MUVohkdKKmTL17aTZ998lc0m99yRjQK2eMEC/ywn94WxQ8WeyQulFXy8T/s+tdCX1HNSDHESuT0xtkgfBZc7NRyvRRSfLAs0XZELmdyZBUafhmrqGZE+p64AwqYwaLEk298ykxjM5D4ksyCGLgL/2nPGvpMPA3HPaC72+FEMfmMUra6gnzR/ESLuSc3IcCltEOFgUhgRghMcnSEYKqUF6t8MmiQJvXYSgxF7TWVEIZMxfhxv9wf54crTK7pkyDErOd/1kc49QiCviC2WQNuCK4+1GtVhzahrTdkHV56QGCRp0MdDsHxzHCjuMIfWVIqBzafL0wybsFE/7TPWK+zztplOdd4/1wOhTtF/WN1zDLC0P4y2/xdHbnknpltBfiZL';
    }
}
    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    //$compatabilityLevel = 825;    // eBay API version
    $compatabilityLevel = 949;    // eBay API version
    if ($production) {
        //$devID = '702653d3-dd1f-4641-97c2-dc818984bfaa';   // these prod keys are different from sandbox keys
        $devID = '5f940391-f231-422f-8dc9-e125a616249c';   // these prod keys are different from sandbox keys
        //$appID = 'SajidKha-eRashanp-PRD-42f839365-d3726265';
        $appID = 'Muhammad-bundlean-PRD-208fa563f-4079df85';
        //$certID = 'PRD-2f839365e792-a58f-4449-b744-ecb4';
        $certID = 'PRD-08fa563fee6d-1205-402d-9f28-2e57';
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        //the token representing the eBay user to assign the call with
        //$userToken = $token; 
        $userToken = 'AgAAAA**AQAAAA**aAAAAA**lwveWA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ACkIWjDJGKoQ6dj6x9nY+seQ**eq0DAA**AAMAAA**A83CXqypqLBmxghCRV5HsJZtipBL/3pm3gyLPc5m8RaSm4TxJj/b+p7JMTLHIkdjetlixnIUeOPpY8CAzvGCsxz/iH87OxFJQD38QkMvWz85JedahUqpkE4GK4jlVRfHnvn9HTsrVf7YYwZQSOhR942FBqHizJKwzF0ydHYl/QGXjzht8m8kannpJqYpV5EAN6dt0+tHR5Z0weDleIbSwM4TiUFk3+uS4lGAA3rvrM4Cn8y5cZK6K6j+J2LOjHM5XaTAFMHfKG65TlE1kK5XsMyVIIxuCQnlii0AZczClCKYtxGwrf3NUe6tLph5QXfywlriPURRrty6N1Brf+ZsrZPUh9QqUYzj0vQWBUpmBesIjl7tAuIxpT1gBYCKXHzrCsRpkfs47AxWQGoPPVl0u+vACrwYtaEGReJJqmdj10JffL4tE63VJqG43rWX/bkAyJFzYgUQbhEbpQMhPPMwxs6J32i+2kee1J15zj0Cwas1KBjjkJiUdocxG7DvhVxyUOvXN8qeuesrpVQd3Lym0drWxj/XKPBXdes1wKA6JAQvWW70SrOw+MLKXZOP033CQDjVaYVoPxzk6C0xS43wQcIVskhQgweF7ErC62MXNnNe88RqHUP7MFvM6X0C6x9oiPGh2qDC9X8K7SdI5IiAVyq72EBquy3BLe1zbzgmcR5Oa6OGAz+t8rz3M77OVMk8cDYP/2J1zpB7zKzjbXEnmDTHwKr8Z+oIvr66kii720gesMcrDxy40i46Bhsz3B8C'; 
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