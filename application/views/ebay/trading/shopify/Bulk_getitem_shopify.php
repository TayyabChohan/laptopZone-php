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
$trans = array("′" => "''","’" => "''","'" => "''","＇" => "''", '"'=>"''");//use in strtr function

$ebayIds = array("264039062375"); //, "222646596113"

//$ebayIds = array("223171093759"); 

function str_replace_first($from, $to, $content)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $content, 1);
}

foreach($ebayIds as $id):


//$id = "222195065258";
$request->ItemID = $id;
$request->DetailLevel = ['ReturnAll'];
$response = $service->getItem($request);
echo "<pre>";
print_r($response);
echo "</pre>";
exit;
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
    //$Title = strtr($Title, $trans);
   //echo $Title1."<br>";
    //$Title = trim(str_replace(array("'"), "''", $Title));
    $Title = str_replace('"',"\\\"", $Title);
    //$Title = str_replace('/',"\/", $Title);

    // echo $Title; //exit;
    //var_dump($Title);

    
    $Description = strip_tags($item->Description); //Remove HTML Tags
    //$Description = "1992 Edition HESS 18 Wheeler and Racer NIB This listing is for a 1992 Edition HESS 18 Wheeler and Racer NIB. Item is new and unused. Look at pictures for details. Item comes in original packaging. Packaging may show signs of wear. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.";


    //echo $Description."<br>";

//$str1 = "123456789ABC";

    $a = $Description;

    if (strpos($a, 'Please read listing carefully') !== false) {
        $pos = strpos($a, 'Please read listing carefully');
        //var_dump($pos);
        //echo 'true';
        $Description = substr( $Description, 0, $pos);
        $Description = trim(str_replace("  ", ' ', $Description));
        $Description = str_replace('"',"\\\"", $Description);        
        //$Description = str_replace('/',"\/", $Description);
        //$Description = strtr($Description, $trans);
        $Description = str_replace('&nbsp;',"", $Description);
        //$Description = str_replace('’',"", $Description);
        //$Description = str_replace('/',"", $Description);        
        //var_dump("afterstr <br>".$Description);
        //echo $Description."<br>";
    }elseif(strpos($a, 'Holidays') == false){
        $Description = strip_tags($item->Description);
        $Description = trim(str_replace("  ", ' ', $Description));
        $Description = str_replace('"',"\\\"", $Description);
        //$Description = str_replace('/',"\/", $Description);
        $Description = str_replace('&nbsp;',"", $Description);
       // $Description = str_replace('’',"", $Description);
        //$Description = str_replace('/',"", $Description);

        //$Description = strtr($Description, $trans);       
        //var_dump($Description);        
        //echo $Description."<br>";
    }
    //echo $Description;
    // https://stackoverflow.com/questions/1252693/using-str-replace-so-that-it-only-acts-on-the-first-match
    // Remove First Occurance of string function
    // function str_replace_first($from, $to, $content)
    // {
    //     $from = '/'.preg_quote($from, '/').'/';

    //     return preg_replace($from, $to, $content, 1);
    // }
    // Accutal Result: Genuine ASUS V230IC AIO DVD-RW Drive DA-8A6SH P/N 17604-00012700 (NO BEZEL) This listing is for a Genuine ASUS V230IC AIO DVD-RW Drive DA-8A6SH P/N 17604-00012700 (NO BEZEL). Item has been tested and is in good working condition. Pulled from a working unit. Please check your unit compatibility before buying this item. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. 
    // Function Output: Genuine ASUS V230IC AIO DVD-RW Drive DA-8A6SH P/N 17604-00012700 (NO BEZEL). Item has been tested and is in good working condition. Pulled from a working unit. Please check your unit compatibility before buying this item. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. 
    $Description = str_replace_first($Title, '', $Description);

    //var_dump($Description); exit;

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

    $barcode_query = $this->db->query("SELECT * FROM (SELECT B.BARCODE_NO, B.ITEM_ID, B.LZ_MANIFEST_ID, B.CONDITION_ID FROM LZ_BARCODE_MT B WHERE B.EBAY_ITEM_ID = $ItemID ORDER BY B.LIST_ID DESC) WHERE ROWNUM = 1")->result_array();

    $barcode_sku = @$barcode_query[0]['BARCODE_NO'];
    $item_id = $barcode_query[0]["ITEM_ID"];
    $lz_manifest_id = $barcode_query[0]["LZ_MANIFEST_ID"];
    $condition_id = $barcode_query[0]["CONDITION_ID"];
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
        
        $img_src .= "{\r\n        \"position\": $i,\r\n      \t\"src\": \"$url\"\r\n ".$end_part ;


        $i++;

    }


    $item_source = "{\r\n  \"product\": {\r\n    \"title\": \"$Title\",\r\n    \"body_html\": \"<strong>MPN:</strong>  $MPN  <strong>Brand:</strong>  $Brand   <strong>Condition:</strong>  $ConditionDisplayName  <br><br><div style=\\\"color:#002CFD;font-family: Arial;font-size: 22px;text-decoration: underline;text-align: center;\\\">$Title</div><br><div style=\\\"font-size:16px;font-family:Arial;text-align:center;\\\">$Description</div> \",\r\n    \"vendor\": \"K2Bay\",\r\n    \"product_type\": \"$category_name\",\r\n\t\"published_scope\": \"global\",\r\n    \"images\": [\r\n    \t\r\n    $img_src        ],\r\n  \"variant\": {\r\n    \"title\": \"$Title\",\r\n    \"price\": \"$priceValue\",\r\n    \"sku\": \"$barcode_sku\",\r\n    \"position\": 5,\r\n    \"inventory_policy\": \"deny\",\r\n    \"fulfillment_service\": \"manual\",\r\n    \"inventory_management\": \"shopify\",\r\n    \"barcode\": $UPC,\r\n    \"inventory_quantity\": $Quantity,\r\n    \"weight\": $ozWeight,\r\n    \"weight_unit\": \"oz\",\r\n    \"requires_shipping\": true\r\n  }\r\n  }\r\n}";
    print_r($item_source);exit;

        //\"option1\": \"$Title\",\r\n    \"option2\": null,\r\n    \"option3\": null,\r\n 

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
      echo "eBay ID:". $ItemID."<br> URL:".$ViewItemURL."<br>".$Title."<br>".$Description."cURL Error #:<pre>" . $err."</pre><br><br><br>";
    } else {
        //echo "eBay ID:". $ItemID."<br> URL:".$ViewItemURL."<br>".$Title."<br>".$Description."<pre>".$response."</pre><br><br><br>";

        $product = json_decode($response, true);
        //var_dump($product); exit;

                foreach($product as $record):

                    $shopify_id = @$record["id"]; // Access Array data
                    //var_dump($shopify_id);exit;
                    $title = @$record["title"];
                    $handle = @$record["handle"];
                    //var_dump($handle);
                    $item_url = "https://k2bay.com/products/".$handle;
                    //var_dump($item_url); exit;
                    $title = strtr($title, $trans);
                    // $title = trim(str_replace("  ", ' ', $title));
                    // $title = trim(str_replace(array("'"), "''", $title));

                    $item_description = @$record["body_html"];
                    $item_description = strtr($item_description, $trans);
                    // $item_description = trim(str_replace("  ", ' ', $item_description));
                    // $item_description = trim(str_replace(array("'"), "''", $item_description));
                

                    $listed_date = @$record["created_at"];
                    $listed_date = str_replace("T", " ", $listed_date);
                    $listed_date = str_replace("-05:00", "", $listed_date);
                    $listed_date = str_replace("-06:00", "", $listed_date);
                    $listed_date = "TO_DATE('".@$listed_date."', 'YYYY-MM-DD HH24:MI:SS')";
                    if(empty($listed_date)){
                        $listed_date = "''";
                    }

                    $quantity = @$record["variants"][0]["inventory_quantity"];
                    $list_price = @$record["variants"][0]["price"];
                    $variants_sku = @$record["variants"][0]["sku"];
                    $listed_by = @$this->session->userdata('user_id');
                    $status = "Add";
                                        
                    //var_dump($default_address_id);exit;
                    
                    $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('SHOPIFY_LIST_MT','LIST_ID') LIST_ID FROM DUAL");
                    $rs = $qry->result_array();
                    $list_id = $rs[0]['LIST_ID'];
                    //var_dump($shopify_id);exit;
                    if(!empty($condition_id)){
                    $seed_qry = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = $item_id AND S.LZ_MANIFEST_ID = $lz_manifest_id AND S.DEFAULT_COND = $condition_id")->result_array();
                    
                    }else{
                    $seed_qry = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = $item_id AND S.LZ_MANIFEST_ID = $lz_manifest_id")->result_array();
                                           
                    }
                    $seed_id = $seed_qry[0]["SEED_ID"];
                    // $seed_qry = $this->db->query("SELECT S.SEED_ID FROM LZ_ITEM_SEED S WHERE S.ITEM_ID = $item_id AND S.LZ_MANIFEST_ID = $lz_manifest_id AND S.DEFAULT_COND = $condition_id")->result_array();
                    // $seed_id = $seed_qry[0]["SEED_ID"];

                    $itemInsertion = $this->db->query("INSERT INTO SHOPIFY_LIST_MT (LIST_ID, SHOPIFY_ID, SEED_ID, STATUS, QUANTITY, TITLE, ITEM_DESCRIPTION, LIST_PRICE, LISTED_BY, LISTED_DATE, SKU, ITEM_ID) VALUES($list_id, $shopify_id, '$seed_id', '$status', '$quantity', '$title', '$item_description', '$list_price', '$listed_by', $listed_date, '$variants_sku', '$item_id')");
                    if($itemInsertion){

                        if(!empty($condition_id)){
                            $update_qry = $this->db->query("UPDATE LZ_BARCODE_MT SET SHOPIFY_LIST_ID = $list_id WHERE ITEM_ID = '$item_id' AND LZ_MANIFEST_ID = '$lz_manifest_id' AND CONDITION_ID = '$condition_id' AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND SHOPIFY_LIST_ID IS NULL");
                            echo "Inserted";
                        }else{
                            $update_qry = $this->db->query("UPDATE LZ_BARCODE_MT SET SHOPIFY_LIST_ID = '$list_id' WHERE ITEM_ID = '$item_id' AND LZ_MANIFEST_ID = '$lz_manifest_id' AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND SHOPIFY_LIST_ID IS NULL");
                            echo "Inserted";                            
                        }
                        // $update_qry = $this->db->query("UPDATE LZ_BARCODE_MT SET SHOPIFY_LIST_ID = $list_id WHERE ITEM_ID = $item_id AND LZ_MANIFEST_ID = $lz_manifest_id AND CONDITION_ID = $condition_id AND SALE_RECORD_NO IS NULL AND ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND LZ_PART_ISSUE_MT_ID IS NULL AND LZ_POS_MT_ID IS NULL AND PULLING_ID IS NULL AND SHOPIFY_LIST_ID IS NULL");
                        // echo "Inserted";
                        //$this->session->set_userdata("item_url", $item_url);
                        //echo $this->session->userdata("item_url"); exit;
                        //return $item_url;
                        
                        
                    }else {
                        echo "Not Inserted";
                        //$insertionError = "Not Inserted";
                        //return $insertionError;
                        
                    }
                //}// order_id if closing                   
                endforeach;


    }//response else closing


}

endforeach;

?>