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
$get_acc = $this->session->userdata('account_type');
if(!empty($get_acc))
{
    //if($get_acc == 'dfwonline')
        if($get_acc == 2)
    {

        $token = 'AgAAAA**AQAAAA**aAAAAA**IQsFWw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIGpD5aGqQidj6x9nY+seQ**IVQEAA**AAMAAA**/0B3T7tdH+jZP7CosNBKaV3bBdZXQlZVnxnSCFkd31T15vYpvdZRfipwGmZMYhPLccy3WUo2T66qxRgfGNTCp66fXkejirquGZRjQR/Ux443xR2STT7f0BvbS6diqFnY/2qG/xfwBjxLafFDJwmhFzPj2Q/QpeMQ3dosprAEG44acTLK8E0OoRdT0kthRFPq08U73azFE1y2gVib3DfnXsoSUbO4U34m9Wlb+egI2h0gdfnFac6grE2gfhRuqcPMgM6qezkseXAIhxAeoBibPgb8ipK4OHbkql6G1wBiCueL7XMZdsMAbfplDqVptN09/NQbqA0M2FTyWjzws9laFHRj6/zDXrRSgUjtl5Nej+z1umVucZTQ3n7X5Ql0WKro0ZiXdGoy9p1CHl5AzwXRInSpQcuS4hi2BQ+0Md7ouVL45d6L/SSKz4ypsKEg3jgB54q94HfB/9swaGkbL66IkR1LcpN6nGJiEDa1StdkZZ6IkjaMWI7HJhGH8q9jRJI5wuHLKCSwFucC7uv6qo+Sw3vIjPvkOhdpthP65/K90Sn2wK93CL6CY6svbRF1Q02hTRsZL2LqnQM/RdqXQaI7FGxTNXOfjZb4shBwORSgGU6Q169vARe9Vkf5jVg62ysQSfIlELai/8VxBkwWic844bf5EHL0j7qQpB5FhlIbLxsok/V6sI3jJ5P02S0groR6ztO1/9NTrGgyqIoWq1Ldw5HmLUVSQCwFXRXN61Uqqk4U2iOshy4P7F367L6nZN7i'; 
    }elseif($get_acc == 1){
    //if($get_acc == 'dfwonline'){

        $token = '';
    }
}
/*=============================================================================
=            this part use in uploade UploadSiteHostedPictures.php            =
=============================================================================*/
$devID = 'ce9df43d-4d8b-45c1-b1a9-0225afc451b4';
$appID = 'FaisalRi-ecologix-PRD-b668815a4-f3c62444';
$certID = 'PRD-668815a468bb-7cb9-4bed-947e-8435';
$userToken = $token;
/*=====  End of this part use in uploade UploadSiteHostedPictures.php  ======*/
return [
    'sandbox' => [
        'credentials' => [
            'devId' => '702653d3-dd1f-4641-97c2-dc818984bfaa',
            'appId' => 'SajidKha-eRashanp-SBX-32f839347-808d8869',
            'certId' => 'SBX-2f8393475fdc-e2ab-44b1-867f-e199',
        ],
        'authToken' => 'AgAAAA**AQAAAA**aAAAAA**iEZ1Wg**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4GgDpCGpQqdj6x9nY+seQ**PM8DAA**AAMAAA**Fi+1Cl1ohpYjtarq3rBdJFcy6LK5tLWHV8FWSH9cHhl2R4AfuIhdKScDaQPg6gn0xJpX/m97JRKljBkJ1auLXDA5b2ifKJq51gIFzxVmQ0fXvYfT9QIjWHnfKCZRqMg8x264bw3NouspfZJoGivHEn2G/4689m1/PPZ6cPqt1jaZYHY4EU0s61Cr9y1cimTIrttbTh7JXi2fi5lflqSeLKWELDig63uRfPCs+K7I3dFdAph/kw/4S+C8HNbm1IxL7g0KaS6PC8dAaUG/mH0w//bsnLvlqQNYjUChQc+6tufLNGegPUQonGXMTkRi5lCHrTCcEz6m8UPo9yK+cr/ZHbMa5WNzMWrDhwLQaYtQwtCKZfF9R3p6kb4uXd/jB/Bdnh1ZRZ7B7KXEGXi2SbK37/9DikaBGQcWDRoSWfsAYGsNR5ppn0/zMbq+v1EzgjAthoRKQ0Q2Bfsmh/ATOTY/HiKX/qIVq21PkebgHFZTEhJZ8whS0XUWtXGsPcvioUmXLMaxcgxZJtUaTHzCfHvMeZ1iRhow/tWgKv0fbukugzpHXDlJaTO4UHJIvt2I6okAs+RDFUGWrRMYi95FqDpAbkytCHaFR2tHbBKnCW6l8viyoX8Vicko53XShZhw0YRF7OJ3siWtJwd1BYWwYUq0inYgQJCRhjCYqvAOqyYhGYERYbMH60BihDMf9RHxyQnbKSwB5ph6iZWuWoBLHXgwNqg6QGm0vrGLDEQL8O4ygNxNOPbC2uWzIUz6fu3Ofev5'
    ],
    'production' => [
        'credentials' => [
            'devId' => $devID,
            'appId' => $appID,
            'certId' => $certID,
        ],
        'authToken' => $token,
        'ruName' => 'Sajid_Khan-SajidKha-eRasha-rzapayttt'
        //'authToken' => 'AgAAAA**AQAAAA**aAAAAA**YuWxVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**fP/SN5SP+vPp+ayJj+0KyVPiHH2LjI+9xCdet/7TAsVeBOYg2rXW6GhJS6wywdcwWjdzOlfistwdMWXqw5CR585S1wAgTlBX2mFgfnZM6E5x09lJ1mc6Obzbe13YXDcqJAMFVd8R0guIQaH8Fg3oWx48EcVoBFTG1YbzVrlNpWPqw4fX1uMR0LneLdv6m+QXgbr+CQFLEUxE0csNQa16nUJe8LrlsJiGIYj/ppO98ZTLFjfiiZV0pITQhuuDlvfX/lcuCHfcC8bosiBfowHyzKqX7JfDb+9X4fKY+oheUgdXpWQE9hendhaEdvT2HZCGpQ8lSyrefDRRsya2DteX07AwJx0jv9QpW6orVP/YV0bYxRgUyMPVgbQjX/KbWXT7MUVohkdKKmTL17aTZ998lc0m99yRjQK2eMEC/ywn94WxQ8WeyQulFXy8T/s+tdCX1HNSDHESuT0xtkgfBZc7NRyvRRSfLAs0XZELmdyZBUafhmrqGZE+p64AwqYwaLEk298ykxjM5D4ksyCGLgL/2nPGvpMPA3HPaC72+FEMfmMUra6gnzR/ESLuSc3IcCltEOFgUhgRghMcnSEYKqUF6t8MmiQJvXYSgxF7TWVEIZMxfhxv9wf54crTK7pkyDErOd/1kc49QiCviC2WQNuCK4+1GtVhzahrTdkHV56QGCRp0MdDsHxzHCjuMIfWVIqBzafL0wybsFE/7TPWK+zztplOdd4/1wOhTtF/WN1zDLC0P4y2/xdHbnknpltBfiZL'
    ]
];




// ======================= Production Sandbox Token ==================================
//AgAAAA**AQAAAA**aAAAAA**8VdiVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AAmIWhAZaCpA2dj6x9nY+seQ**u0gDAA**AAMAAA**yfgx1ZnDeTsYDFPEb3TMkrDZWgrmPONMPxTKVa8jLjCCmbR+WFS8Ymocz46GXNcRH8+NZgd6Hc9+yqQV+38cUZKAqDANPuaOmgEVUKrrfI51OHN6YgjOQMD5UjNZ5tWQOSZElLDW4wuVgnW0lApnR8Q3sGx0npb00O5hlg4fRZW/SKe3cP+Rz/NOb0J2yv/+RW/D8pXZI9+yVTbBgA7UD8che+XJFUE7oS3mogDrrRrtZU6fu2alxAy48nHt4kG/qbCpY9AHpDP+l7gL3RzGdWSg5uVb7GgcuWd6zzE8fOqb4W3GrZyWHMGqw4c03Hkia4m/fyGYgdqDBGMxaOGg3rneiXBOQ+gs/LKiUzqYK/AGbj/aUc5nZNy6Tq2HeNMcC2+q+whpUu18WECXs/1aDSspteSmAp3cPNgUJY11g4a6/6aqSzpRTp34EXqBXUQ9afDGi1MJmj0qnPUh0+qtVZyepUGIlsUVTqy5uU2hnF13w/ZkFaakNaikllV6qlcVXja+unwK6Fpi0U/HLh4z0Bada/MWepXMRvzZs8g7A2011onXWkqZpxCQew+Rxc0fse3y5WTx6IiJkGleIU1YbRf/VgZ0S6W5Lj6LlQmv0Mede4b4aIRdg39mKPgt2ROLu+brKKphF9pLfiG8ItmfF/KAwEtXhIjjoxhrXifT6uYiaOULADmzhGmaBFUphNPJzk6KMYIF+Xts4BKuZm3wMMbqKXbBcXIR2ExPKSfGEqKfsNikhneyaNuZ7/gG1uy9



// ========================== dfwonline token start ====================================

//AgAAAA**AQAAAA**aAAAAA**7zvAVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIGpD5aGqQidj6x9nY+seQ**u0gDAA**AAMAAA**4QITUIgSLf2WCM34ebAwFO33B0o3woFE29IysRK9Mri4hYw56tr5HGkgIyOPBjX6bp7x7wLb93HGiFeeYqPSB1163UbcCB94xGJ6tg5MapK2DWS8Dlz/EIQExi9tsoOvsMiwTyQOA+93pWHJx615ZsNMHWR9FB9mLfdV5OtCpjoaj/7Grv+d89aUyRssdZz+8mA7ir4w2HSA1nmNXzkNgtKhDIQ2bESPjsNoezK1PaTd5wcbAS8B5s0a5s2TSy0tEYng/u/M4zlX6NgR9zFtCitXGeimMGhqdeRuDTtTb015LFSNVZp75R2lH9Kwt3he37ptCrJcfsAPb5H6vb2Na3dV2Lmeb4nmBGgrJvxPBah+CA+VtA5KxEsSsdzp9GATyUkW7aneuZ6jHXqNAvx+WDTiMWS0wOE2p72dno/bH+Q1ntjNTIbez3SxKNNjkPvzD/Kg9sOvDfzSVwVBH5MHBo4JhQLR3yP9gkfpXUCV+VG9wqrUz9QrzdKmtGFKkgIgRjmEg+UzBlkf8FXvgsuDxNXDTS+LIWnxuzIeTMxACENm37PYJYSF6zjR/RXy8YpvWwgobNiswN9FbKXseGfPW/VrdGd1ktnwADnzvdCheuYDMhA9voa5VlnOtqQfRAUsci0TmMvX+k13h4sS42+wGtXXEeaoCZcIa6vxXeq9FrY7dBpNACUHXaiKC1QVA7wFXeAeTaSE1oe+Zrw/Mv3TmDf8+/b4ZaeWY8K1eaVZixMSEL9tRvbNhQsi68A/+itW
// 24-04-2017 -----
//AgAAAA**AQAAAA**aAAAAA**Mfr9WA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIGpD5aGqQidj6x9nY+seQ**u0gDAA**AAMAAA**4QITUIgSLf2WCM34ebAwFO33B0o3woFE29IysRK9Mri4hYw56tr5HGkgIyOPBjX6bp7x7wLb93HGiFeeYqPSB1163UbcCB94xGJ6tg5MapK2DWS8Dlz/EIQExi9tsoOvsMiwTyQOA+93pWHJx615ZsNMHWR9FB9mLfdV5OtCpjoaj/7Grv+d89aUyRssdZz+8mA7ir4w2HSA1nmNXzkNgtKhDIQ2bESPjsNoezK1PaTd5wcbAS8B5s0a5s2TSy0tEYng/u/M4zlX6NgR9zFtCitXGeimMGhqdeRuDTtTb015LFSNVZp75R2lH9Kwt3he37ptCrJcfsAPb5H6vb2Na3dV2Lmeb4nmBGgrJvxPBah+CA+VtA5KxEsSsdzp9GATyUkW7aneuZ6jHXqNAvx+WDTiMWS0wOE2p72dno/bH+Q1ntjNTIbez3SxKNNjkPvzD/Kg9sOvDfzSVwVBH5MHBo4JhQLR3yP9gkfpXUCV+VG9wqrUz9QrzdKmtGFKkgIgRjmEg+UzBlkf8FXvgsuDxNXDTS+LIWnxuzIeTMxACENm37PYJYSF6zjR/RXy8YpvWwgobNiswN9FbKXseGfPW/VrdGd1ktnwADnzvdCheuYDMhA9voa5VlnOtqQfRAUsci0TmMvX+k13h4sS42+wGtXXEeaoCZcIa6vxXeq9FrY7dBpNACUHXaiKC1QVA7wFXeAeTaSE1oe+Zrw/Mv3TmDf8+/b4ZaeWY8K1eaVZixMSEL9tRvbNhQsi68A/+itW

// ========================== techbargains2015 Token Start ================================

//AgAAAA**AQAAAA**aAAAAA**YuWxVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**fP/SN5SP+vPp+ayJj+0KyVPiHH2LjI+9xCdet/7TAsVeBOYg2rXW6GhJS6wywdcwWjdzOlfistwdMWXqw5CR585S1wAgTlBX2mFgfnZM6E5x09lJ1mc6Obzbe13YXDcqJAMFVd8R0guIQaH8Fg3oWx48EcVoBFTG1YbzVrlNpWPqw4fX1uMR0LneLdv6m+QXgbr+CQFLEUxE0csNQa16nUJe8LrlsJiGIYj/ppO98ZTLFjfiiZV0pITQhuuDlvfX/lcuCHfcC8bosiBfowHyzKqX7JfDb+9X4fKY+oheUgdXpWQE9hendhaEdvT2HZCGpQ8lSyrefDRRsya2DteX07AwJx0jv9QpW6orVP/YV0bYxRgUyMPVgbQjX/KbWXT7MUVohkdKKmTL17aTZ998lc0m99yRjQK2eMEC/ywn94WxQ8WeyQulFXy8T/s+tdCX1HNSDHESuT0xtkgfBZc7NRyvRRSfLAs0XZELmdyZBUafhmrqGZE+p64AwqYwaLEk298ykxjM5D4ksyCGLgL/2nPGvpMPA3HPaC72+FEMfmMUra6gnzR/ESLuSc3IcCltEOFgUhgRghMcnSEYKqUF6t8MmiQJvXYSgxF7TWVEIZMxfhxv9wf54crTK7pkyDErOd/1kc49QiCviC2WQNuCK4+1GtVhzahrTdkHV56QGCRp0MdDsHxzHCjuMIfWVIqBzafL0wybsFE/7TPWK+zztplOdd4/1wOhTtF/WN1zDLC0P4y2/xdHbnknpltBfiZL
//24-04-2017 -------------
//AgAAAA**AQAAAA**aAAAAA**/fr9WA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**fP/SN5SP+vPp+ayJj+0KyVPiHH2LjI+9xCdet/7TAsVeBOYg2rXW6GhJS6wywdcwWjdzOlfistwdMWXqw5CR585S1wAgTlBX2mFgfnZM6E5x09lJ1mc6Obzbe13YXDcqJAMFVd8R0guIQaH8Fg3oWx48EcVoBFTG1YbzVrlNpWPqw4fX1uMR0LneLdv6m+QXgbr+CQFLEUxE0csNQa16nUJe8LrlsJiGIYj/ppO98ZTLFjfiiZV0pITQhuuDlvfX/lcuCHfcC8bosiBfowHyzKqX7JfDb+9X4fKY+oheUgdXpWQE9hendhaEdvT2HZCGpQ8lSyrefDRRsya2DteX07AwJx0jv9QpW6orVP/YV0bYxRgUyMPVgbQjX/KbWXT7MUVohkdKKmTL17aTZ998lc0m99yRjQK2eMEC/ywn94WxQ8WeyQulFXy8T/s+tdCX1HNSDHESuT0xtkgfBZc7NRyvRRSfLAs0XZELmdyZBUafhmrqGZE+p64AwqYwaLEk298ykxjM5D4ksyCGLgL/2nPGvpMPA3HPaC72+FEMfmMUra6gnzR/ESLuSc3IcCltEOFgUhgRghMcnSEYKqUF6t8MmiQJvXYSgxF7TWVEIZMxfhxv9wf54crTK7pkyDErOd/1kc49QiCviC2WQNuCK4+1GtVhzahrTdkHV56QGCRp0MdDsHxzHCjuMIfWVIqBzafL0wybsFE/7TPWK+zztplOdd4/1wOhTtF/WN1zDLC0P4y2/xdHbnknpltBfiZL
?>