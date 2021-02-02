<?php
require __DIR__.'/../vendor/autoload.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;
 $sites = array(
     array('id' => Constants\SiteIds::US, 'name' => 'United States'),
//     // array('id' => Constants\SiteIds::ENCA, 'name' => 'Canada (English)'),
//     // array('id' => Constants\SiteIds::GB, 'name' => 'UK'),
//     // array('id' => Constants\SiteIds::AU, 'name' => 'Australia'),
//     // array('id' => Constants\SiteIds::AT, 'name' => 'Austria'),
//     // array('id' => Constants\SiteIds::FRBE, 'name' => 'Belgium (French)'),
//     // array('id' => Constants\SiteIds::FR, 'name' => 'France'),
//     // array('id' => Constants\SiteIds::DE, 'name' => 'Germany'),
//     // array('id' => Constants\SiteIds::MOTORS, 'name' => 'Motors'),
//     // array('id' => Constants\SiteIds::IT, 'name' => 'Italy'),
//     // array('id' => Constants\SiteIds::NLBE, 'name' => 'Belgium (Dutch)'),
//     // array('id' => Constants\SiteIds::NL, 'name' => 'Netherlands'),
//     // array('id' => Constants\SiteIds::ES, 'name' => 'Spain'),
//     // array('id' => Constants\SiteIds::CH, 'name' => 'Switzerland'),
//     // array('id' => Constants\SiteIds::HK, 'name' => 'Hong Kong'),
//     // array('id' => Constants\SiteIds::IN, 'name' => 'India'),
//     // array('id' => Constants\SiteIds::IE, 'name' => 'Ireland'),
//     // array('id' => Constants\SiteIds::MY, 'name' => 'Malaysia'),
//     // array('id' => Constants\SiteIds::FRCA, 'name' => 'Canada (French)'),
//     // array('id' => Constants\SiteIds::PH, 'name' => 'Philippones'),
//     // array('id' => Constants\SiteIds::PL, 'name' => 'Poland'),
//     // array('id' => Constants\SiteIds::SG, 'name' => 'Singapore'),
 );
 // foreach($sites as $site) {
 //     getDetails($site);
 // }
$site = Constants\SiteIds::US;
getDetails($site);
function getDetails($site) 
{
    $config = require __DIR__.'/../configuration.php';
    $siteId = Constants\SiteIds::US;
     $service = new Services\TradingService([
            'credentials' => $config['production']['credentials'],
            'production'     => true,
            'siteId'      => $siteId
        ]);

        /**
         * Create the request object.
         */
        $request = new Types\GeteBayDetailsRequestType();

        /**
         * An user token is required when using the Trading service.
         */
        $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
        $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
   
    // $service = new Services\TradingService(array(
    //     'apiVersion' => '881',
    //     'siteId' => $site['id']
    // ));
    // $request = new Types\GeteBayDetailsRequestType();
    // $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    // $request->RequesterCredentials->eBayAuthToken = 'AgAAAA**AQAAAA**aAAAAA**YuWxVw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIKpDZeEpASdj6x9nY+seQ**u0gDAA**AAMAAA**fP/SN5SP+vPp+ayJj+0KyVPiHH2LjI+9xCdet/7TAsVeBOYg2rXW6GhJS6wywdcwWjdzOlfistwdMWXqw5CR585S1wAgTlBX2mFgfnZM6E5x09lJ1mc6Obzbe13YXDcqJAMFVd8R0guIQaH8Fg3oWx48EcVoBFTG1YbzVrlNpWPqw4fX1uMR0LneLdv6m+QXgbr+CQFLEUxE0csNQa16nUJe8LrlsJiGIYj/ppO98ZTLFjfiiZV0pITQhuuDlvfX/lcuCHfcC8bosiBfowHyzKqX7JfDb+9X4fKY+oheUgdXpWQE9hendhaEdvT2HZCGpQ8lSyrefDRRsya2DteX07AwJx0jv9QpW6orVP/YV0bYxRgUyMPVgbQjX/KbWXT7MUVohkdKKmTL17aTZ998lc0m99yRjQK2eMEC/ywn94WxQ8WeyQulFXy8T/s+tdCX1HNSDHESuT0xtkgfBZc7NRyvRRSfLAs0XZELmdyZBUafhmrqGZE+p64AwqYwaLEk298ykxjM5D4ksyCGLgL/2nPGvpMPA3HPaC72+FEMfmMUra6gnzR/ESLuSc3IcCltEOFgUhgRghMcnSEYKqUF6t8MmiQJvXYSgxF7TWVEIZMxfhxv9wf54crTK7pkyDErOd/1kc49QiCviC2WQNuCK4+1GtVhzahrTdkHV56QGCRp0MdDsHxzHCjuMIfWVIqBzafL0wybsFE/7TPWK+zztplOdd4/1wOhTtF/WN1zDLC0P4y2/xdHbnknpltBfiZL';
    $request->DetailName = array('ShippingServiceDetails');
    $response = $service->geteBayDetails($request);
     //   echo "<pre>";
     // print_r($response);
     //    //var_dump($response);
     //  echo "</pre>";
     //   exit;

    if ($response->Ack !== 'Success') {
        if (isset($response->Errors)) {
            foreach ($response->Errors as $error) {
                printf("Error: %s\n", $error->ShortMessage);
            }
        }
    } else {
     //   echo "<br>"."---------------------------".$site['name'].$site['id']."<br>";
     //    //echo $details->ShippingCarrier."<br>";
     // // printf("---------------------------\n%s [%s]\n\n", $site['name'], $site['id']);
     //   echo "--------------- ShippingCarrierDetails -------------------- <br>";
     //   $i=1;
     //  if (count($response->ShippingCarrierDetails)) {
     //      foreach($response->ShippingCarrierDetails as $details) {
     //          echo $i."-".$details->ShippingCarrier."<br>";
     //          $i++;
     //      }
     //  } else {
     //      print("No details found\n");
     //  }
    echo "--------------- ShippingServiceDetails -------------------- <br>";
    $i=1;
            if (count($response->ShippingServiceDetails)) {
          foreach($response->ShippingServiceDetails as $details) {
              echo $i."-".$details->ShippingService."<br>";
              $i++;
          }
      } else {
          print("No details found\n");
      }
      print("\n---------------------------\n");
    }
}