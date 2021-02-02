<?php
//var_dump($category_id);exit;
/**
 * Copyright 2016 David T. Sadler
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Include the SDK by using the autoloader from Composer.
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Include the configuration values.
 *
 * Ensure that you have edited the configuration.php file
 * to include your application keys.
 */
$config = require __DIR__.'/../configuration_modified.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Sdk;
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading;
use \DTS\eBaySDK\FileTransfer;

/**
 * Downloading the category specifics is a two step process.
 *
 * The first step is to use the Trading service to request the FileReferenceID and TaskReferenceID from eBay.
 * This is done with the GetCategorySpecifics operation.
 *
 * The second step is to use the File Transfer service to download the file that contains the specifics.
 * This is done with the downloadFile operation using the FileReferenceID and TaskReferenceID values.
 *
 * For more information, see:
 * http://developer.ebay.com/DevZone/XML/docs/Reference/eBay/GetCategorySpecifics.html#downloadFile
 */

/**
 * Specify the numerical site id that we to download the category specifics for.
 * Note that each site will have its own category structure and specifics.
 */
$siteId = Constants\SiteIds::US;

$sdk = new Sdk([
    'credentials' => $config['production']['credentials'],
    'authToken'   => $config['production']['authToken'],
    'siteId'      => $siteId
]);

/**
 * Create the service object.
 */
$service = $sdk->createTrading();

/**
 * Create the request object.
 */
$request = new Trading\Types\GetCategorySpecificsRequestType();

/**
 * Request the FileReferenceID and TaskReferenceID from eBay.
 */

//$date = date_create('2016-12-25 23:18:03');
//echo date_format($date, 'Y-m-d H:i:s');exit;
//$date =date_format($date, 'Y-m-d H:i:s');
// $date = new DateTime('2016-12-25');

//$dateString = '2016-12-25 23:18:03';
//$dateTime = datetime::createfromformat('Y-m-d H:i:s',$dateString);
//var_dump($dateTime->format('Y-m-d H:i:s')) ;
//exit;

// $date->setTime(23, 18, 03);
//echo $date->format('Y-m-d H:i:s');// . "\n"; strtotime('2016-12-25 23:18:03');
//exit;
//$request->LastUpdateTime = $dateTime;//->format('Y-m-d H:i:s');
//$request->CategorySpecificsFileInfo = true;
//$request->CategoryID =['111422'];
//['175672', '111422', '171485', '176970', '162497', '171961', '180235', '183062', '164', '27386', '182089', '182088', '1244', '131511', '16145', '11848', '29585', '112661', '29946', '94879', '117042', '139971', '3323', '75708', '25299', '31388', '43304', '183447', '2536', '2228', '71465', '14969', '175745', '178893', '31569']
$request->CategoryID =[(string)$cat_id]; 
/**
 * Send the request.
 */
$response = $service->getCategorySpecifics($request);
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;

/**
 * Output the result of calling the service operation.
 */
if (isset($response->Errors)) {
    foreach ($response->Errors as $error) {
        printf(
            "%s: %s\n%s\n\n",
            $error->SeverityCode === Trading\Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            $error->ShortMessage,
            $error->LongMessage
        );
    }
}

if ($response->Ack !== 'Failure') {
    $time_stamp = $response->Timestamp->format('Y-m-d H:i:s');
    // $taskreferenceid = 6051781807;
    // $filereferenceid = 6170316117;
    foreach ($response->Recommendations as $Recommendations) {
    $ebay_category_id= $Recommendations->CategoryID;
    //$updated = $Recommendations->Updated;// if true means item specific for that category is updated
    $namerecommendation = $Recommendations->NameRecommendation;
    //var_dump($ebay_category_id,$namerecommendation);exit;
    foreach($namerecommendation as $NameRecommendation){

        /*=================================================
        =            catgoery_specific_mt data            =
        =================================================*/
        // $categoryid
        // $time_stamp
        $specific_name= $NameRecommendation->Name; 
        $specific_name = trim(str_replace("  ", ' ', $specific_name));
        $specific_name = trim(str_replace(array("'"), "''", $specific_name)); 
        $max_value= $NameRecommendation->ValidationRules->MaxValues; 
        if(empty($max_value)){
            $max_value= 1;
        }
        $min_value= $NameRecommendation->ValidationRules->MinValues;
        if(empty($min_value)){
            $min_value= 0;
        }
        $selection_mode= $NameRecommendation->ValidationRules->SelectionMode;
        $comma = ',';
        /*=====  End of catgoery_specific_mt data  ======*/

        /*==============================================================
        =            Data insert/update catgoery_specific_mt table            =
        ==============================================================*/
        //$con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
        //$con =  oci_connect('laptop_zone', 's', 'localhost/LZBIGDATA') or die ('Error connecting to oracle');
        /*=======================================================
        =            check if already nserted or not            =
        =======================================================*/
        $select_query = "SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = '$ebay_category_id' AND upper(SPECIFIC_NAME) = upper('$specific_name')";
        $select =oci_parse($conn, $select_query);
        oci_execute($select,OCI_DEFAULT);
        $num_row = oci_fetch_array($select, OCI_ASSOC);
        $mt_id = $num_row['MT_ID'];

        /*=====  End of check if already nserted or not  ======*/

        if($num_row == false){
            $query = "SELECT get_single_primary_key$DBlink('CATEGORY_SPECIFIC_MT','MT_ID') MT_ID FROM DUAL";
            $result = oci_parse($conn,$query);
            oci_execute($result, OCI_DEFAULT);
            $row = oci_fetch_array($result,OCI_ASSOC);
            $mt_id = $row['MT_ID'];
            $marketplace_id = 1;
            $custom = 0;
            $catalogue_only = 0;

            $qry = "INSERT INTO CATEGORY_SPECIFIC_MT (MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY) VALUES($mt_id $comma $ebay_category_id $comma '$specific_name' $comma $marketplace_id $comma $max_value $comma $min_value $comma '$selection_mode' $comma '$time_stamp' $comma $custom $comma $catalogue_only)";
            //var_dump($qry);//exit;
            $cmd =oci_parse($conn, $qry);
            oci_execute($cmd,OCI_DEFAULT);
            oci_commit($conn);
        }

        /*=====  End of Data insert/update catgoery_specific_mt table  ======*/

        $variation_specifics= $NameRecommendation->ValidationRules->VariationSpecifics;
        $value_recommendation= $NameRecommendation->ValueRecommendation;
            foreach($value_recommendation as $valuerecommendation){

                /*==================================================
                =            category_specific_det data            =
                ==================================================*/
                $specific_value= $valuerecommendation->Value;
                $specific_value = trim(str_replace("  ", ' ', $specific_value));
                $specific_value = trim(str_replace(array("'"), "''", $specific_value)); 
                /*=====  End of category_specific_det data  ======*/

                /*========================================================
                =            check if already inserted or not            =
                ========================================================*/
                $select_query = "SELECT MT_ID FROM CATEGORY_SPECIFIC_DET WHERE MT_ID = '$mt_id' AND upper(SPECIFIC_VALUE) = upper('$specific_value')";
                $select =oci_parse($conn, $select_query);
                oci_execute($select,OCI_DEFAULT);
                $num_row = oci_fetch_array($select, OCI_ASSOC);
                //$mt_id = $num_row['MT_ID'];
                /*=====  End of check if already inserted or not  ======*/
    
                if($num_row == false){
                    $query = "SELECT get_single_primary_key$DBlink('CATEGORY_SPECIFIC_DET','DET_ID') DET_ID FROM DUAL";
                    $result = oci_parse($conn,$query);
                    oci_execute($result, OCI_DEFAULT);
                    $row = oci_fetch_array($result,OCI_ASSOC);
                    $det_id = $row['DET_ID'];
                    /*==============================================================
                    =            Data insert/update catgoery_specific_det table            =
                    ==============================================================*/

                    $qry = "INSERT INTO CATEGORY_SPECIFIC_DET (DET_ID, MT_ID, SPECIFIC_VALUE) VALUES($det_id $comma $mt_id $comma '$specific_value')";
                    //var_dump($qry);
                    $cmd =oci_parse($conn, $qry);
                    oci_execute($cmd,OCI_DEFAULT);
                    oci_commit($conn);
                       // exit;
                    /*=====  End of Data insert/update catgoery_specific_det table  ======*/
                }
                
            } //end level 2 foreach
            //var_dump($name,$max_value,$selectionmode); 
            //exit;
        

    }//end level 1 foreach

}//main foreach or level 0 foreach

    
}//main success if

// $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL') or die ('Error connecting to oracle');
    // $query = "SELECT TASK_REFERENCE_ID,FILE_REFERENCE_ID FROM CATEGORY_SPECIFIC_MT WHERE FILE_REFERENCE_ID=$fileReferenceId AND TASK_REFERENCE_ID = $taskReferenceId";
    // $result = oci_parse($conn,$query);
    // oci_execute($result, OCI_DEFAULT);
    // $row = oci_fetch_array($result,OCI_ASSOC);
    // $task_id = $row['TASK_REFERENCE_ID'];
    // $file_id = $row['FILE_REFERENCE_ID'];
    // if(!empty($task_id)){}
