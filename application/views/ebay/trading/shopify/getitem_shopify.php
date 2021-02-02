<?php
// require __DIR__.'/vendor/autoload.php';
// use \DTS\eBaySDK\Constants;
// use \DTS\eBaySDK\Trading\Services;
// use \DTS\eBaySDK\Trading\Types;
// use \DTS\eBaySDK\Trading\Enums;

require __DIR__.'../../../vendor/autoload.php';

$config = require __DIR__.'../../../configuration_for_shopify.php';

use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

$siteId = Constants\SiteIds::US;
// $service = new Services\TradingService([
//     'authToken'   => 'your-auth-token',
//     'credentials' => [
//        'appId'  => 'your-app-id',
//        'certId' => 'your-cert-id',
//        'devId'  => 'your-dev-id'        
//     ],
//     'siteId'      => Constants\SiteIds::GB
// ]);
$service = new Services\TradingService([    
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);
$request = new Types\GetItemRequestType() ;
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];
//$ebay_id = $this->session->userdata('ebay_item_id');

//var_dump($ebay_id);exit;
//$ebayIds = $ebay_id;

//foreach($ebayIds as $id):


//$id = "222195065258";
$request->ItemID = $ebay_id;
$request->DetailLevel = ['ReturnAll'];
$response = $service->getItem($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
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
if ($response->Ack !== 'Failure') {
    $item = $response->Item;
    // printf(
    //     "%s\n%s\n%s\n%s\n%s\n(%s)%.2f\n",
    //     $item->ListingDetails->ViewItemURL,
    //     $item->ItemID,
    //     $item->Title,
    //     $item->Description,
    //     $item->Quantity,
    //     $item->SellingStatus->CurrentPrice->currencyID,
    //     $item->SellingStatus->CurrentPrice->value
    // );QuantitySold
    //$ebay_item_url = $item->ListingDetails->ViewItemURL;
    //$this->session->set_userdata('ebay_item_url', $ebay_item_url);
    //echo "<br>Item ID: ".$item->ItemID." <br> Title: ".$item->Title." <br> Description: ".$item->Description."<br> Quantity :".$item->Quantity."<br> Item URL :".$item->ListingDetails->ViewItemURL."<br> ";

    // $item->ListingDetails->ViewItemURL;

    $ItemID = trim(str_replace("  ", ' ', $item->ItemID));
    $ItemID = trim(str_replace(array("'"), "''", $ItemID));

    $Title = trim(str_replace("  ", ' ', $item->Title));
   //echo $Title1."<br>";
    //$Title = trim(str_replace(array("'"), "''", $Title));
    $Title = str_replace('"',"\\\"", $Title);

    // echo $Title; //exit;
    // var_dump($Title);
    
    $Description = strip_tags($item->Description); //Remove HTML Tags

    //echo $Description."<br>";

    $a = $Description;

    if (strpos($a, 'Please read listing carefully') !== false) {
        $pos = strpos($a, 'Please read listing carefully');
        //var_dump($pos);
        //echo 'true';
        $Description = substr( $Description, 0, $pos);
        $Description = trim(str_replace("  ", ' ', $Description));
        $Description = str_replace('"',"\\\"", $Description);        
        //var_dump("afterstr <br>".$Description);
        //echo $Description."<br>";
    }elseif(strpos($a, 'Holidays') == false){
        $Description = strip_tags($item->Description);
        $Description = trim(str_replace("  ", ' ', $Description));
        $Description = str_replace('"',"\\\"", $Description);
        //var_dump($Description);        
        //echo $Description."<br>";
    }

    // https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
    // Remove First Occurance of string function
    function str_replace_first($from, $to, $content)
    {
        $from = '/'.preg_quote($from, '/').'/';

        return preg_replace($from, $to, $content, 1);
    }
    // Accutal Result: Genuine ASUS V230IC AIO DVD-RW Drive DA-8A6SH P/N 17604-00012700 (NO BEZEL) This listing is for a Genuine ASUS V230IC AIO DVD-RW Drive DA-8A6SH P/N 17604-00012700 (NO BEZEL). Item has been tested and is in good working condition. Pulled from a working unit. Please check your unit compatibility before buying this item. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. 
    // Function Output: Genuine ASUS V230IC AIO DVD-RW Drive DA-8A6SH P/N 17604-00012700 (NO BEZEL). Item has been tested and is in good working condition. Pulled from a working unit. Please check your unit compatibility before buying this item. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. 
    $Description = str_replace_first($Title, '', $Description);

    //echo $Description;
    // exit;

    $currencyID = trim(str_replace("  ", ' ', $item->SellingStatus->CurrentPrice->currencyID));
    $Quantity = trim(str_replace("  ", ' ', $item->Quantity));
    $priceValue = trim(str_replace("  ", ' ', $item->SellingStatus->CurrentPrice->value));
    $PictureURL = $item->PictureDetails->PictureURL;

    $ViewItemURL = $item->ListingDetails->ViewItemURL;

    // print_r($ViewItemURL);
    // exit;

    $GalleryURL = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryURL));
    $ConditionDescription = trim(str_replace("  ", ' ', $item->ConditionDescription)); //Condition Description like Item is used etc
    $ConditionDescription = trim(str_replace(array("'"), "''", $ConditionDescription));

    $ConditionDisplayName = trim(str_replace("  ", ' ', $item->ConditionDisplayName)); //Condition Name: Used, New etc
    $ConditionDisplayName = trim(str_replace(array("'"), "''", $ConditionDisplayName));

    $UPC = trim(str_replace("  ", ' ', @$item->ProductListingDetails->UPC));
    //$UPC = trim(str_replace(array("'"), "''", @$UPC));


    $Brand = trim(str_replace("  ", ' ', $item->ProductListingDetails->BrandMPN->Brand));
    $Brand = trim(str_replace(array("'"), "''", $Brand));

    $MPN = trim(str_replace("  ", ' ', $item->ProductListingDetails->BrandMPN->MPN));
    $MPN = trim(str_replace(array("'"), "''", $MPN));

    $GalleryType = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryType));
    $PhotoDisplay = trim(str_replace("  ", ' ', $item->PictureDetails->PhotoDisplay));
    $PictureSource = trim(str_replace("  ", ' ', $item->PictureDetails->PictureSource));
    $GalleryDuration = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryDuration));
    $GalleryStatus = trim(str_replace("  ", ' ', $item->PictureDetails->GalleryStatus));

    $majorWeight = $item->ShippingPackageDetails->WeightMajor->value;
    $minorWeight = $item->ShippingPackageDetails->WeightMinor->value;
    $weightUnit = $item->ShippingPackageDetails->WeightMajor->unit;
    $minorWeightUnit = $item->ShippingPackageDetails->WeightMinor->unit;
    
    if($majorWeight > 0){
        $weightOz = $majorWeight/16;
        $ozWeight = $weightOz + $minorWeight;
        $ozWeight = number_format((float)$ozWeight,2,'.',',');
    }else{
        $ozWeight = $minorWeight;
        $ozWeight = number_format((float)$ozWeight,2,'.',',');
    }

    $category_name = trim(str_replace("  ", ' ', $item->PrimaryCategory->CategoryName));
    $category_name = trim(str_replace(array("'"), "''", $category_name));

    $barcode_query = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.EBAY_ITEM_ID = $ItemID AND ITEM_ADJ_DET_ID_FOR_IN IS NULL AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND ROWNUM = 1 ")->result_array();
    $barcode_sku = @$barcode_query[0]['BARCODE_NO'];
    //$barcode_sku = 1234;
    if(empty($barcode_sku)){
        $barcode_sku = 'null';
    }
    if(!is_numeric($UPC)){
        $UPC = $barcode_sku;
    }

    $UPC = ltrim($UPC, '0');
    //var_dump($UPC); exit;
    //var_dump($UPC);  //exit;
    //echo "<br>Item ID: ".$ItemID." <br> Title: ".$Title." <br> Description: ".$Description."<br> Quantity :".$Quantity."<br> Currency Id: ".$currencyID."<br> Price: ".$priceValue."<br>PictureURL : ".$PictureURL."<br>GalleryURL: ".$GalleryURL."<br>GalleryType: ".$GalleryType."<br>PhotoDisplay: ".$PhotoDisplay."<br>PictureSource: ".$PictureSource."<br>GalleryDuration: ".$GalleryDuration."<br>GalleryStatus: ".$GalleryStatus."<br> Major Weight: ".$majorWeight.$weightUnit."<br> Minor Weight: ".$minorWeight.$minorWeightUnit."<br> ConditionDescription: ".$ConditionDescription."<br> UPC: ".$UPC."<br> MPN: ".$MPN."<br> Brand: ".$Brand;

    $i = 1;
    $img_src = "";

    foreach($PictureURL as $pic){
        $url = str_replace("/$","/\$", $pic);
        //echo $url."<br>";
        if($i == count($PictureURL)){
            $end_part = " }\r\n";
        }else{
            $end_part = " },\r\n";
        }
        $img_src .= "{\r\n        \"position\": $i,\r\n      \t\"src\": \"$url\"\r\n ".$end_part;
        $i++;
    }

    /*======================================================
    =            Get Item by Title from Shopify            =
    ======================================================*/
    function parse_title($data) {
      $data = trim($data);
      $data = preg_replace('/\s+/', '%20', $data);
      $data = preg_replace("/'/", '%27', $data);
      $data = preg_replace('/"/', '%22', $data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    $parsed_Title = parse_title($Title);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products.json?title=$parsed_Title",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Postman-Token: 58783fdd-c747-4066-84e8-b3dd1e769250",
        "cache-control: no-cache"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    }

    $someArray = json_decode($response, true);
    //print_r($someArray);        // Dump all data of the Array
    $check_title = @$someArray["products"][0]["title"]; // Access Array data
    //echo $json->profile->preferredUsername;
    //$check_title = $response['products'][0]['title'];
    // var_dump($check_title);
    // exit;
    /*=====  End of GetItem by Title from Shopify  ======*/
    //Empty MPN Check
    // ----------------------------------------------------
    $lz_mpn = "LZ-"
    $sys_mpn = strstr($MPN,$lz_mpn);
    if(!empty(@$sys_mpn)){
        @$check_mpn = "";
    }else if(@$sys_mpn == false){
        $check_mpn = "<strong>MPN:</strong>  $MPN";
    }
    if(empty($MPN) && $MPN == ""){
        @$check_mpn = "";
    }else{
        $check_mpn = "<strong>MPN:</strong>  $MPN";        
    }
    //Empty Brand Check
    // ----------------------------------------------------
    if(empty($Brand) && $Brand == ""){
        @$check_brand = "";
    }else{
        $check_brand = "<strong>Brand:</strong>  $Brand";    
    }
    //Empty Condition Display Name
    // -----------------------------------------------------
    if(empty($ConditionDisplayName) && $ConditionDisplayName == ""){
        @$check_condition = "";
    }else{
        $check_condition = "<strong>Condition:</strong>  $ConditionDisplayName";    
    }    


    if(empty(@$check_title) && @$check_title == ""){

        $item_source = "{\r\n  \"product\": {\r\n    \"title\": \"$Title\",\r\n    \"body_html\": \" $check_mpn   $check_brand   $check_condition  <br><br><div style=\\\"color:#002CFD;font-family: Arial;font-size: 22px;text-decoration: underline;text-align: center;\\\">$Title</div><br><div style=\\\"font-size:16px;font-family:Arial;text-align:center;\\\">$Description</div> \",\r\n    \"vendor\": \"K2Bay\",\r\n    \"product_type\": \"$category_name\",\r\n\t\"published_scope\": \"global\",\r\n    \"images\": [\r\n    \t\r\n    $img_src        ],\r\n  \"variant\": {\r\n    \"title\": \"$Title\",\r\n    \"price\": \"$priceValue\",\r\n    \"sku\": \"$barcode_sku\",\r\n    \"position\": 5,\r\n    \"inventory_policy\": \"deny\",\r\n    \"fulfillment_service\": \"manual\",\r\n    \"inventory_management\": \"shopify\",\r\n    \"barcode\": $UPC,\r\n    \"inventory_quantity\": $Quantity,\r\n    \"weight\": $ozWeight,\r\n    \"weight_unit\": \"oz\",\r\n    \"requires_shipping\": true\r\n  }\r\n  }\r\n}";

        //print_r($item_source);exit;

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://c084db0733b8db2aef9f2a3a37b7314e:d19b1f6eece15313ce289b80e206286f@k2bay.myshopify.com/admin/products.json",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $item_source,
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic YzA4NGRiMDczM2I4ZGIyYWVmOWYyYTNhMzdiNzMxNGU6ZDE5YjFmNmVlY2UxNTMxM2NlMjg5YjgwZTIwNjI4NmY=",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "Postman-Token: 9c475c3f-4b15-4e3c-be0b-af818d58bcf0"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo $err;
            $response = "Error";
            $this->session->set_userdata("response", $response);
        } else {
            $response = "Success";
            $this->session->set_userdata("response", $response);
        }
    }else{
        $response = "Duplicate";
        $this->session->set_userdata("response", $response);
    }

}

//endforeach;

?>