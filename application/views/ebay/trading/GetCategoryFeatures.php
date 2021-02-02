<?php
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
//$config = require __DIR__.'/../configuration.php';
//$config = require __DIR__.'/../configuration_faisal.php';
$config = require __DIR__.'/../configuration_modified.php';

/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Trading\Services;
use \DTS\eBaySDK\Trading\Types;
use \DTS\eBaySDK\Trading\Enums;

/**
 * Create the service object.
 */
$service = new Services\TradingService([
    'credentials' => $config['production']['credentials'],
    'siteId'      => Constants\SiteIds::US
]);

/**
 * Create the request object.
 */
foreach ($data as $val){
    $request = new Types\GetCategoryFeaturesRequestType();

    /**
     * An user token is required when using the Trading service.
     */
    $request->RequesterCredentials = new Types\CustomSecurityHeaderType();
    $request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

    // var_dump($category_id);exit;
    //echo $category_id;

    $request->CategoryID = $val['CATEGORY_ID'];

    // , '293', '15032'
    //$request->LevelLimit =2;
    //$request->ViewAllNodes = TRUE;
    //$request->AllFeaturesForCategory = TRUE;
    $request->FeatureID =  ['ConditionValues'];

    /**
     * By specifying 'ReturnAll' we are telling the API return the full category hierarchy.
     */
    $request->DetailLevel = ['ReturnAll'];
    //$request->DetailLevel = ['ReturnSummary'];

    /**
     * OutputSelector can be used to reduce the amount of data returned by the API.
     * http://developer.ebay.com/DevZone/XML/docs/Reference/ebay/GetCategories.html#Request.OutputSelector
     */
    // $request->OutputSelector = [
    //     'CategoryArray.Category.CategoryID',
    //     'CategoryArray.Category.CategoryParentID',
    //     'CategoryArray.Category.CategoryLevel',
    //     'CategoryArray.Category.CategoryName'
    // ];

    /**
     * Send the request.
     */
    $response = $service->GetCategoryFeatures($request);
    // echo "<pre>";
    // print_r($response);
    // var_dump(isset($response->Category));
    // echo "</pre>";
    // exit;

    /**
     * Output the result of calling the service operation.
     */
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
        //$ConditionEnabled = $response->SiteDefaults->ConditionEnabled;
        if(isset($response->Category)){
                /*=============================================
                =  Section lz_bigData db connection block  =
                =============================================*/
                $CI = &get_instance();
                //setting the second parameter to TRUE (Boolean) the function will return the database object.
                $this->db2 = $CI->load->database('bigData', TRUE);
                /*=====  End of Section lz_bigData db connection block  ======*/
            //$ConditionEnabled = $response->SiteDefaults->ConditionEnabled;

            foreach ($response->Category as $category) {
                    $CategoryID = $category->CategoryID;
                    if($CategoryID == $val['CATEGORY_ID']){

                    
                    $all_conditon = $category->ConditionValues->Condition;

                    foreach($all_conditon as $condition){
                        $conditionId = $condition->ID;
                        $conditionName = $condition->DisplayName;
                        $comma = ',';
                        $inserted_date = date("Y-m-d H:i:s");
                        $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

        //var_dump($conditionId,$conditionName);exit;
                        // ====== Start Checking if record already exist =========
                        $query = $this->db2->query("SELECT * FROM LZ_BD_CAT_COND T WHERE T.CATEGORY_ID = $CategoryID AND CONDITION_ID = $conditionId");
                        // =========== End Checking if record already exist ========
                            if($query->num_rows() == 0){
                                $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CAT_COND','CAT_COND_ID') ID FROM DUAL")->result_array();
                                $cat_cond_id = $query[0]['ID'];
                                $insert_qry = "INSERT INTO LZ_BD_CAT_COND (CAT_COND_ID, CATEGORY_ID, CONDITION_ID,UPDATE_DATE,CONDITION_DISPLAY_NAME) VALUES($cat_cond_id $comma $CategoryID $comma $conditionId $comma $inserted_date $comma '$conditionName')";
                              
                             }else{
                                $insert_qry = "UPDATE LZ_BD_CAT_COND SET UPDATE_DATE = $inserted_date WHERE CATEGORY_ID = $CategoryID AND CONDITION_ID = $conditionId"; 
                            }
                            //var_dump($insert_qry);
                            $qry = $this->db2->query($insert_qry);

                    }//end all_conditon foreach
                }else{//end $CategoryID == $val['CATEGORY_ID'] if else
                    $CategoryID = $val['CATEGORY_ID'];
                    $query = $this->db2->query("UPDATE LZ_BD_CATEGORY SET CONDITION_AVAILABLE = 0 WHERE CATEGORY_ID = $CategoryID");
                }
               break;     
            }// $response->Category forech end
            if($qry){
                echo 'Success! Record is Insrted Successfully against CATEGORY ID:'.$val['CATEGORY_ID'].PHP_EOL;
            }else{
               echo 'Error! Record is Not Inserted against CATEGORY ID:'.$val['CATEGORY_ID'].PHP_EOL;
            }
        }else{
                $CategoryID = $val['CATEGORY_ID'];
                $query = $this->db2->query("UPDATE LZ_BD_CATEGORY SET CONDITION_AVAILABLE = 0 WHERE CATEGORY_ID = $CategoryID");
                echo 'Warning! Condition Not available in CATEGORY ID:'.$val['CATEGORY_ID'].PHP_EOL;
                        
        }//  isset($response->Category) if else end
    }//$response->Ack !== 'Failure' IF END

}//end data forech
