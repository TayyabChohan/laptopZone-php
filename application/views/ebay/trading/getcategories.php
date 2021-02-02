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
$config = require __DIR__.'/../configuration.php';

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
$request = new Types\GetCategoriesRequestType();

/**
 * An user token is required when using the Trading service.
 */
$request->RequesterCredentials = new Types\CustomSecurityHeaderType();
$request->RequesterCredentials->eBayAuthToken = $config['production']['authToken'];

// var_dump($category_id);exit;
//echo $category_id;

//$request->CategoryParent = [$category_id];

// , '293', '15032'
 //$request->LevelLimit = 3;
$request->ViewAllNodes = TRUE;

/**
 * By specifying 'ReturnAll' we are telling the API return the full category hierarchy.
 */
$request->DetailLevel = ['ReturnAll'];

/**
 * OutputSelector can be used to reduce the amount of data returned by the API.
 * http://developer.ebay.com/DevZone/XML/docs/Reference/ebay/GetCategories.html#Request.OutputSelector
 */
$request->OutputSelector = [
    'CategoryArray.Category.CategoryID',
    'CategoryArray.Category.CategoryParentID',
    'CategoryArray.Category.CategoryLevel',
    'CategoryArray.Category.CategoryName'
];

/**
 * Send the request.
 */
$response = $service->getCategories($request);
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
            $error->SeverityCode === Enums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
            $error->ShortMessage,
            $error->LongMessage
        );
    }
}

if ($response->Ack !== 'Failure') {
    /**
     * For the US site this will output approximately 18,000 categories.
     */
     //$i=1;

            /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        /*=====  End of Section lz_bigData db connection block  ======*/

    foreach ($response->CategoryArray->Category as $category) {
        // printf(
        //     "Level %s : %s (%s) : Parent ID %s\n %s <br>",
        //     $category->CategoryLevel . "<br>",
        //     $category->CategoryName . "<br>",
        //     $category->CategoryID . "<br>",
        //     $category->CategoryParentID[0],
        //     "<br>Sr No.".$i ."<br>"
        // );

            $category_name = $category->CategoryName;
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = trim(str_replace(array("'"), "''", $category_name));
            $categorylevel = $category->CategoryLevel;
            $category_id = $category->CategoryID;

            $parent_cat_id = $category->CategoryParentID[0];
            $comma = ',';

            $inserted_date = date("Y-m-d H:i:s");
            $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 
        // ============== Start Checking if record already exist =====================
        $query = $this->db2->query("SELECT * FROM lz_bd_category_tree T WHERE T.CATEGORY_ID = $category_id");
        // =========== End Checking if record already exist =====================
            if($query->num_rows() == 0){
                if($categorylevel == 1){
                    $insert_qry = "INSERT INTO lz_bd_category_tree (CATEGORY_ID, CATEGORY_NAME, PARENT_CAT_ID,UPDATED) VALUES($category_id $comma '$category_name' $comma null $comma $inserted_date)";
                }else{
                    $insert_qry = "INSERT INTO lz_bd_category_tree (CATEGORY_ID, CATEGORY_NAME, PARENT_CAT_ID,UPDATED) VALUES($category_id $comma '$category_name' $comma $parent_cat_id $comma $inserted_date)";
                }
                 
                
            }else{
                $insert_qry = "UPDATE lz_bd_category_tree SET  CATEGORY_NAME = '$category_name', PARENT_CAT_ID = parent_cat_id, UPDATED = $inserted_date WHERE CATEGORY_ID = $category_id"; 
            }
            //var_dump($insert_qry);
            $qry = $this->db2->query($insert_qry);

    /*echo "Level %s : %s (%s) : Parent ID %s\n";
    echo "<br>$category->CategoryLevel<br>";
    echo "$category->CategoryName<br>";
    echo "$category->CategoryID<br>";
    echo $category->CategoryParentID[0];
    echo "<br>";
    echo $i . "<br>";*/
    //$i++;
    }
    if($qry){
        $this->session->set_flashdata('success', 'Record is Insrted Successfully.');
    }else{
        $this->session->set_flashdata('error', 'Record is Not Inserted.');
    }  
}
