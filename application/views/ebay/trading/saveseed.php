<?php

require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../configuration.php';
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

$service = new Services\TradingService([
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);

$request = new Types\GetMyeBaySellingRequestType();

$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

$request->ActiveList = new Types\ItemListCustomizationType();
$request->ActiveList->Include = true;
$request->ActiveList->Pagination = new Types\PaginationType();
$request->ActiveList->Pagination->EntriesPerPage = 200;
$request->ActiveList->Sort = Enums\ItemSortTypeCodeType::C_CURRENT_PRICE_DESCENDING;
$pageNum = 1;

do {
    $request->ActiveList->Pagination->PageNumber = $pageNum;

    $response = $service->getMyeBaySelling($request);

    if (isset($response->Errors)) {
        foreach ($response->Errors as $error) {
            printf(
                "%s: %s\n%s\n\n",
                $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                $error->ShortMessage,
                $error->LongMessage
            );
        }
    }

    if ($response->Ack !== 'Failure' && isset($response->ActiveList)) {
        $i=1;
        foreach ($response->ActiveList->ItemArray->Item as $item) 
        {
           //echo "Sr No.: ".$i."Item ID: ".$item->ItemID."<br>";
           //$i++;
          //$ItemId = 222171928024,222214138891;
           // $ItemId = 222171928024;
          $ItemId = $item->ItemID;
            require_once('includes/configSeed.php');
            require_once ('includes/db_connection.php');
            $site_id = 0;
            $call_name = 'GetItem';

            $headers = array 
            (
                'X-EBAY-API-COMPATIBILITY-LEVEL: ' . $compat_level,
                'X-EBAY-API-DEV-NAME: ' . $dev_id,
                'X-EBAY-API-APP-NAME: ' . $app_id,
                'X-EBAY-API-CERT-NAME: ' . $cert_id,
                'X-EBAY-API-CALL-NAME: ' . $call_name,          
                'X-EBAY-API-SITEID: ' . $site_id,
            );
           
//$array=array("222015323102","222015919252");

//$stid = oci_parse($conn, "SELECT ITEM_ID as EBAY_ID from EBAY_ITEM_ID");
//oci_execute($stid);

//while($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){


//$ItemId = $row['EBAY_ID'];
//$ItemId =222110826235;
                $xml_request = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
                               <".$call_name."Request xmlns=\"urn:ebay:apis:eBLBaseComponents\">
                                   <RequesterCredentials>
                                       <eBayAuthToken>" . $auth_token . "</eBayAuthToken>
                                   </RequesterCredentials>
                                   <DetailLevel>ReturnAll</DetailLevel>
                                   <IncludeItemSpecifics>true</IncludeItemSpecifics>
                                   <IncludeWatchCount>true</IncludeWatchCount>
                                   <ItemID>".$ItemId."</ItemID>
                               </".$call_name."Request>";


                // Send request to eBay and load response in $response
                $connection = curl_init();
                curl_setopt($connection, CURLOPT_URL, $api_endpoint);
                curl_setopt($connection, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($connection, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($connection, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($connection, CURLOPT_POST, 1);
                curl_setopt($connection, CURLOPT_POSTFIELDS, $xml_request);
                curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
                $response = curl_exec($connection);
                curl_close($connection);
       //echo "<pre>";
     // print_r($response);
        //var_dump($response);
      // echo "</pre>";
      //  exit;
// Create DOM object and load eBay response
$dom = new DOMDocument();
 $dom->loadXML($response);

// Parse data accordingly.
$ack = $dom->getElementsByTagName('Ack')->length > 0 ? $dom->getElementsByTagName('Ack')->item(0)->nodeValue : '';
$eBay_official_time = $dom->getElementsByTagName('Timestamp')->length > 0 ? $dom->getElementsByTagName('Timestamp')->item(0)->nodeValue : '';
$item_id = $dom->getElementsByTagName('ItemID')->length > 0 ? $dom->getElementsByTagName('ItemID')->item(0)->nodeValue : '';
$title = $dom->getElementsByTagName('Title')->length > 0 ? $dom->getElementsByTagName('Title')->item(0)->nodeValue : '';
//$title = addslashes($title);
$title = trim(str_replace("  ", '', $title));
$title = trim(str_replace(array("'", '"'), "''", $title));
$current_price = $dom->getElementsByTagName('ConvertedCurrentPrice')->length > 0 ? $dom->getElementsByTagName('ConvertedCurrentPrice')->item(0)->nodeValue : '';
$description = $dom->getElementsByTagName('Description')->length > 0 ? $dom->getElementsByTagName('Description')->item(0)->nodeValue : '';
//echo $description ."<br><br>";
//$description = addslashes($description);
// $description = strip_tags($description);
// $description = trim(str_replace(array("\r", "\n","  "), '', $description));
$description = trim(str_replace("  ", '', $description));
$description = trim(str_replace(array("'", '"'), "''", $description));
$description = str_replace("<", '&lt;', $description);
$description = str_replace(">", '&gt;', $description);
//$description = trim(str_replace(array("\r", "\n","\"","'",","), '', $description));
//echo $description ."<br><br>";
// $description = preg_replace('~[\r\n]+~', '', $description);
// echo $description. "<br><br>" ;

//exit;
$site = $dom->getElementsByTagName('Site')->length > 0 ? $dom->getElementsByTagName('Site')->item(0)->nodeValue : '';
$currency = $dom->getElementsByTagName('Currency')->length > 0 ? $dom->getElementsByTagName('Currency')->item(0)->nodeValue : '';
$quantity = $dom->getElementsByTagName('Quantity')->length > 0 ? $dom->getElementsByTagName('Quantity')->item(0)->nodeValue : '';
$CategoryID= $dom->getElementsByTagName('CategoryID')->length > 0 ? $dom->getElementsByTagName('CategoryID')->item(0)->nodeValue : '';
$CategoryName = $dom->getElementsByTagName('CategoryName')->length > 0 ? $dom->getElementsByTagName('CategoryName')->item(0)->nodeValue : '';
//$CategoryName = addslashes($CategoryName);
$CategoryName = trim(str_replace("  ", '', $CategoryName));
$CategoryName = trim(str_replace(array("'", '"'), "''", $CategoryName));
$Location = $dom->getElementsByTagName('Location')->length > 0 ? $dom->getElementsByTagName('Location')->item(0)->nodeValue : '';
//$Location = addslashes($Location);
$Location = trim(str_replace("  ", '', $Location));
$Location = trim(str_replace(array("'", '"'), "''", $Location));
$ConditionID = $dom->getElementsByTagName('ConditionID')->length > 0 ? $dom->getElementsByTagName('ConditionID')->item(0)->nodeValue : '';
$ConditionDescription = $dom->getElementsByTagName('ConditionDescription')->length > 0 ? $dom->getElementsByTagName('ConditionDescription')->item(0)->nodeValue : '';
//$ConditionDescription = addslashes($ConditionDescription);
$ConditionDescription = trim(str_replace("  ", '', $ConditionDescription));
$ConditionDescription = trim(str_replace(array("'", '"'), "''", $ConditionDescription));
$PaymentMethods = $dom->getElementsByTagName('PaymentMethods')->length > 0 ? $dom->getElementsByTagName('PaymentMethods')->item(0)->nodeValue : '';
//$PaymentMethods = addslashes($PaymentMethods);
$PaymentMethods = trim(str_replace("  ", '', $PaymentMethods));
$PaymentMethods = trim(str_replace(array("'", '"'), "''", $PaymentMethods));
$PayPalEmailAddress = $dom->getElementsByTagName('PayPalEmailAddress')->length > 0 ? $dom->getElementsByTagName('PayPalEmailAddress')->item(0)->nodeValue : '';
$DispatchTimeMax = $dom->getElementsByTagName('DispatchTimeMax')->length > 0 ? $dom->getElementsByTagName('DispatchTimeMax')->item(0)->nodeValue : '';
$ShippingService = $dom->getElementsByTagName('ShippingService')->length > 0 ? $dom->getElementsByTagName('ShippingService')->item(0)->nodeValue : '';
//$ShippingService = addslashes($ShippingService);
$ShippingService = trim(str_replace("  ", '', $ShippingService));
$ShippingService = trim(str_replace(array("'", '"'), "''", $ShippingService));
$ShippingServiceCost = $dom->getElementsByTagName('ShippingServiceCost')->length > 0 ? $dom->getElementsByTagName('ShippingServiceCost')->item(0)->nodeValue : '';
$ShippingServicePriority = $dom->getElementsByTagName('ShippingServicePriority')->length > 0 ? $dom->getElementsByTagName('ShippingServicePriority')->item(0)->nodeValue : '';
$ExpeditedService = $dom->getElementsByTagName('ExpeditedService')->length > 0 ? $dom->getElementsByTagName('ExpeditedService')->item(0)->nodeValue : '';
$ShippingTimeMin = $dom->getElementsByTagName('ShippingTimeMin')->length > 0 ? $dom->getElementsByTagName('ShippingTimeMin')->item(0)->nodeValue : '';
$ShippingTimeMax = $dom->getElementsByTagName('ShippingTimeMax')->length > 0 ? $dom->getElementsByTagName('ShippingTimeMax')->item(0)->nodeValue : '';
$FreeShipping = $dom->getElementsByTagName('FreeShipping')->length > 0 ? $dom->getElementsByTagName('FreeShipping')->item(0)->nodeValue : '';
$ShippingServiceAdditionalCost = $dom->getElementsByTagName('ShippingServiceAdditionalCost')->length > 0 ? $dom->getElementsByTagName('ShippingServiceAdditionalCost')->item(0)->nodeValue : '';
if(empty($ShippingServiceAdditionalCost)){
    $ShippingServiceAdditionalCost = 0.0;
}
$ShippingCostPaidBy = $dom->getElementsByTagName('ShippingCostPaidBy')->length > 0 ? $dom->getElementsByTagName('ShippingCostPaidBy')->item(0)->nodeValue : '';
$ReturnsAcceptedOption = $dom->getElementsByTagName('ReturnsAcceptedOption')->length > 0 ? $dom->getElementsByTagName('ReturnsAcceptedOption')->item(0)->nodeValue : '';
$ReturnsWithinOption = $dom->getElementsByTagName('ReturnsWithinOption')->length > 0 ? $dom->getElementsByTagName('ReturnsWithinOption')->item(0)->nodeValue : '';
$ReturnsWithinOption = explode ("_",$ReturnsWithinOption);
//var_dump($ReturnsWithinOption[1]);
//$ReturnsWithinOption = array_slice ($ReturnsWithinOption,1);
if(!empty($ReturnsWithinOption[1])){
    $ReturnsWithinOption = (int)$ReturnsWithinOption[1];
}else{
    $ReturnsWithinOption = "NULL";
}
//echo "<br>";
//var_dump($ReturnsWithinOption);
$listingtype = $dom->getElementsByTagName('ListingType')->length > 0 ? $dom->getElementsByTagName('ListingType')->item(0)->nodeValue : '';
$pictureurl = $dom->getElementsByTagName('PictureURL')->length > 0 ? $dom->getElementsByTagName('PictureURL')->item(0)->nodeValue : '';
$PictureDetails = $dom->getElementsByTagName('PictureDetails')->length > 0 ? $dom->getElementsByTagName('PictureDetails')->item(0)->nodeValue : '';
$PictureDetailspictureurl = $dom->getElementsByTagName('PictureDetails.PictureURL')->length > 0 ? $dom->getElementsByTagName('PictureDetails.PictureURL')->item(0)->nodeValue : '';
$select_qry="SELECT ITEM_ID,LZ_MANIFEST_ID FROM EBAY_LIST_MT WHERE EBAY_ITEM_ID=".$item_id;
$rslt = oci_parse($conn, $select_qry);

//var_dump(oci_execute($rslt));exit;
oci_execute($rslt);
//$r = oci_fetch_array($rslt, OCI_ASSOC+OCI_RETURN_NULLS);
//var_dump($r);exit;
$r = oci_fetch_array($rslt, OCI_ASSOC+OCI_RETURN_NULLS);
//if(!oci_fetch_array($rslt, OCI_ASSOC+OCI_RETURN_NULLS) == 0){

$comma = ',';
if(!empty($r['ITEM_ID'])){
    $erp_id = $r['ITEM_ID'];
    $manifest_id = $r['LZ_MANIFEST_ID'];
    //$insert_qry = "INSERT INTO TEMP_SEED_TEST VALUES($erp_id $comma '$title' $comma '$description' $comma $current_price $comma NULL $comma 0 $comma '$currency' $comma '$listingtype' $comma $CategoryID $comma 75229 $comma '$Location' $comma 0 $comma $ConditionID $comma '$ConditionDescription' $comma '$PaymentMethods' $comma '$PayPalEmailAddress' $comma $DispatchTimeMax $comma $ShippingServiceCost $comma $ShippingServiceAdditionalCost $comma '$ReturnsAcceptedOption' $comma $ReturnsWithinOption $comma '$ShippingCostPaidBy' $comma '$ShippingService' $comma '$CategoryName' $comma $quantity $comma $manifest_id $comma $item_id)";


$insert_qry = "DECLARE temp_desc long; BEGIN temp_desc := '$description'; INSERT INTO temp_seed_dfwonline VALUES($erp_id $comma '$title' $comma temp_desc $comma $current_price $comma NULL $comma 0 $comma '$currency' $comma '$listingtype' $comma $CategoryID $comma 75229 $comma '$Location' $comma 0 $comma $ConditionID $comma '$ConditionDescription' $comma '$PaymentMethods' $comma '$PayPalEmailAddress' $comma $DispatchTimeMax $comma $ShippingServiceCost $comma $ShippingServiceAdditionalCost $comma '$ReturnsAcceptedOption' $comma $ReturnsWithinOption $comma '$ShippingCostPaidBy' $comma '$ShippingService' $comma '$CategoryName' $comma $quantity $comma $manifest_id $comma $item_id);END;";


}else{
        //$insert_qry = "INSERT INTO TEMP_SEED_TEST VALUES(NULL $comma '$title' $comma '$description' $comma $current_price $comma NULL $comma 0 $comma '$currency' $comma '$listingtype' $comma $CategoryID $comma 75229 $comma '$Location' $comma 0 $comma $ConditionID $comma '$ConditionDescription' $comma '$PaymentMethods' $comma '$PayPalEmailAddress' $comma $DispatchTimeMax $comma $ShippingServiceCost $comma $ShippingServiceAdditionalCost $comma '$ReturnsAcceptedOption' $comma $ReturnsWithinOption $comma '$ShippingCostPaidBy' $comma '$ShippingService' $comma '$CategoryName' $comma $quantity $comma NULL $comma $item_id)";
$insert_qry = "DECLARE temp_desc long; BEGIN temp_desc := '$description'; INSERT INTO temp_seed_dfwonline VALUES(NULL $comma '$title' $comma temp_desc $comma $current_price $comma NULL $comma 0 $comma '$currency' $comma '$listingtype' $comma $CategoryID $comma 75229 $comma '$Location' $comma 0 $comma $ConditionID $comma '$ConditionDescription' $comma '$PaymentMethods' $comma '$PayPalEmailAddress' $comma $DispatchTimeMax $comma $ShippingServiceCost $comma $ShippingServiceAdditionalCost $comma '$ReturnsAcceptedOption' $comma $ReturnsWithinOption $comma '$ShippingCostPaidBy' $comma '$ShippingService' $comma '$CategoryName' $comma $quantity $comma NULL $comma $item_id);END;";
}
                    
   
    //echo $insert_qry."<br>";
    //print_r($insert_qry);
    $data = oci_parse($conn, $insert_qry);
    $check =oci_execute($data,OCI_DEFAULT);
    if($check){
        echo $i."-"."item inserted: ".$ItemId."<br>";
        //echo $insert_qry;
        oci_commit($conn);
    }else{
            echo $i."-"."item Not inserted: ".$ItemId."<br>";
            //echo "<pre><![CDATA[".$insert_qry."]]></pre><br>";
            //echo $insert_qry;
            oci_commit($conn);
    }
 //   exit;
    $i++;
    //oci_commit($conn);
    //var_dump($chk); exit;
//}

// var_dump(oci_execute($data));exit;
// exit;

//echo "Item Id: ".$item_id."<br>Price: ".$current_price."<br>Description:".$description."<br>Site : ".$site."<br>Currency : ".$currency."<br>ListingType:".$listingtype."<br> Quantity: ".$quantity."<br>CategoryID:".$CategoryID."<br>CategoryName:".$CategoryName."<br>Location:".$Location."<br>ConditionID:".$ConditionID."<br>ConditionDescription:".$ConditionDescription."<br>PaymentMethods:".$PaymentMethods."<br>PayPalEmailAddress:".$PayPalEmailAddress."<br>DispatchTimeMax:".$DispatchTimeMax."<br>ShippingService:".$ShippingService."<br>ShippingServiceCost:".$ShippingServiceCost."<br>ShippingServicePriority:".$ShippingServicePriority."<br>ExpeditedService:".$ExpeditedService."<br>ShippingTimeMin:".$ShippingTimeMin."<br>ShippingTimeMax:".$ShippingTimeMax."<br>FreeShipping:".$FreeShipping."<br>ShippingServiceAdditionalCost:".$ShippingServiceAdditionalCost."<br>ShippingCostPaidBy:".$ShippingCostPaidBy."<br>ReturnsAcceptedOption:".$ReturnsAcceptedOption."<br>ReturnsWithinOption:".$ReturnsWithinOption;
//exit;
//================================ image save script start=============================

//        //================Image save================
// $img= explode ("http",$PictureDetails);
// foreach(array_slice ($img,2) as $value)
// {
//  $path = 'http'.$value;
//  $name= $ItemId.'_' . $i. '.jpg';
//  $image = file_get_contents($path);
//  //var_dump($path."and".$name."<br>and".$image);exit;
//  //file_put_contents('D:\wamp\www\GetItem_last\images/'.$ItemId.'_' . $i. '.jpg' , $ImgURL);
//        //==================image save=====================

//      $query = "SELECT MAX(ITEM_PICTURE_ID) AS PIC_ID FROM ITEM_PICTURES_MT";
//                  $rsl = oci_parse($conn, $query);

//                  $reslt=oci_execute($rsl, OCI_DEFAULT);  
//                  //var_dump($reslt);exit;
//                  $row = oci_fetch_array($rsl,OCI_NUM);

//                  if(@$row[0]== 0){$pic_id = 1;}else{$pic_id = $row[0]+1;}
// //var_dump($pic_id);exit;
//      //---------- END CREATING ITEM PICTURE ID -------------//

//      //---------- STRAT CHECKING IF ITEM ALREADY EXSIST -------------//          
//        $check = "SELECT * FROM ITEM_PICTURES_MT WHERE ITEM_ID = $erp_id AND LZ_MANIFEST_ID = $manifest_id";
//        //$check = "SELECT * FROM ITEM_PICTURES_MT WHERE ITEM_PICT_DESC = '$name'";
//        $rs = oci_parse($conn, $check);
//        @oci_execute($rs, OCI_DEFAULT);
//        $data = @oci_fetch_array($rs, OCI_NUM);
//       // print_r($data);exit;
//        if(@!empty($data)) {
//          //die("IF Upload called");
//          //echo ($name . " " . "Image already exists.\n");
//              $query = "SELECT MAX(SRNO) AS PIC_SRNO FROM ITEM_PICTURES_MT WHERE ITEM_ID = $erp_id AND LZ_MANIFEST_ID = $manifest_id";
//              $rsl = oci_parse($conn, $query);
//              $reslt=oci_execute($rsl, OCI_DEFAULT);  
//              $row = oci_fetch_array($rsl,OCI_NUM);

//              if(@$row[0]== 0){$PIC_SRNO = 1;}else{$PIC_SRNO = $row[0]+1;}

//               $lob = oci_new_descriptor($conn, OCI_D_LOB);
//          $qry = "INSERT INTO ITEM_PICTURES_MT (ITEM_PICTURE_ID,ITEM_PICT_DESC,ITEM_ID,SRNO,ITEM_PIC,LZ_MANIFEST_ID) VALUES(:ID,:DESCRIPTION,:ITEMID,:SRNO, empty_blob(),:LZ_MANIFEST_ID) RETURNING ITEM_PIC INTO :blobbind";
//          $result = oci_parse($conn, $qry);
//            // var_dump($result);exit;
//          oci_bind_by_name($result,':ID', $pic_id);
//          oci_bind_by_name($result,':DESCRIPTION', $name);
//          oci_bind_by_name($result,':ITEMID', $erp_id);
//          oci_bind_by_name($result,':SRNO', $PIC_SRNO);
//          oci_bind_by_name($result,':blobbind', $lob, -1, OCI_B_BLOB);
//          oci_bind_by_name($result,':LZ_MANIFEST_ID', $manifest_id);
//          oci_execute($result, OCI_DEFAULT);

           
//          if(!$lob->save($image)) {
//              oci_rollback($conn);
//          }
//          else {
//              oci_commit($conn);
//          }

//          oci_free_statement($result);
//          $lob->free();
//        } //---------- END CHECKING IF ITEM ALREADY EXSIST  -------------//
//        else{

            
//          $lob = oci_new_descriptor($conn, OCI_D_LOB);
//          $qry = "INSERT INTO ITEM_PICTURES_MT (ITEM_PICTURE_ID,ITEM_PICT_DESC,ITEM_ID,SRNO,ITEM_PIC,LZ_MANIFEST_ID) VALUES(:ID,:DESCRIPTION,:ITEMID,:SRNO, empty_blob(),:LZ_MANIFEST_ID) RETURNING ITEM_PIC INTO :blobbind";
//          $result = oci_parse($conn, $qry);
//            // var_dump($result);exit;
//          oci_bind_by_name($result,':ID', $pic_id);
//          oci_bind_by_name($result,':DESCRIPTION', $name);
//          oci_bind_by_name($result,':ITEMID', $erp_id);
//          oci_bind_by_name($result,':SRNO', $i);
//          oci_bind_by_name($result,':blobbind', $lob, -1, OCI_B_BLOB);
//          oci_bind_by_name($result,':LZ_MANIFEST_ID', $manifest_id);
//          oci_execute($result, OCI_DEFAULT);

           
//          if(!$lob->save($image)) {
//              oci_rollback($conn);
//          }
//          else {
//              oci_commit($conn);
//          }

//          oci_free_statement($result);
//          $lob->free();


//          //$qry="insert into images (img_name,image) values ('$name','$image')";

//          // $result=oci_parse($conn,$qry);
//          // if($result){
//          //   echo ($name . " " . "Image uploaded.\n");
//          // }
//          // else{
//          //   echo ($name . " " . "Image not uploaded.\n");
//          // }
//        }
//        oci_close($conn);

//  $i++;
// }
//  $i = 1;
// die("done");
// exit;
//============================= image save script end================================

//}// end while

        }
    }

    $pageNum += 1;

} while (isset($response->ActiveList) && $pageNum <= $response->ActiveList->PaginationResult->TotalNumberOfPages);
