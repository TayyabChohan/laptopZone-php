<?php
/**
 * Copyright 2017 David T. Sadler
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
use \DTS\eBaySDK\Catalog\Services;
use \DTS\eBaySDK\Catalog\Types;
use \DTS\eBaySDK\Catalog\Enums;

/**
 * Create the service object.
 */
$service = new Services\CatalogService([
    'authorization' => $config['production']['oauthUserToken']
    //,'httpOptions' => ['debug' => true]
]);
$trans = array("′" => "''","’" => "''","'" => "''","＇" => "''");//use in strtr function 
foreach ($data as $value) {
    $categoryid = $value['CATEGORY_ID'];
    /**
     * Create the request object.
     */
    $request = new Types\GetProductRestRequest();

    //$request->epid = '232669172'; // Apple iPhone 7
    //$request->epid = '1607673760';
    $request->epid = $value['EPID'];



    /**
     * Send the request.
     */
    $response = $service->GetProduct($request);

    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    // exit;
    /**
     * Output the result of calling the service operation.
     */
    //printf("\nStatus Code: %s\n\n", $response->getStatusCode());
    if (isset($response->errors)) {
        foreach ($response->errors as $error) {
            printf(
                "%s: %s\n%s\n\n",
                $error->errorId,
                $error->message,
                $error->longMessage
            );
            echo PHP_EOL;
        }
    }

    if ($response->getStatusCode() === 200) {

        
         
        $epid = @$response->epid;
        $primarycategoryid = @$response->primaryCategoryId;
        $title = @$response->title;
        $title = strtr($title, $trans);
        $brand = @$response->brand;
        $brand = strtr($brand, $trans);
        $description = @$response->description;
        $description = strtr($description, $trans);
        $productweburl = @$response->productWebUrl;
        $productweburl = strtr($productweburl, $trans);
        $imageurl = @$response->image->imageUrl;
        $imageurl = strtr($imageurl, $trans);
        $version = @$response->version;
    //var_dump($epid,$primarycategoryid,$title,$brand,$description,$productweburl,$imageurl,$version);exit;

        $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_MT WHERE EPID = $epid");
        if($qry->num_rows() == 0 ){
            $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_MT','EBAY_CATALOGUE_MT_ID') EBAY_CATALOGUE_MT_ID FROM DUAL");
            $get_pk = $get_pk->result_array();
            $ebay_catalogue_mt_id = $get_pk[0]['EBAY_CATALOGUE_MT_ID'];
            /*============================================
            =            insert data in table            =
            ============================================*/

            $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_MT (EBAY_CATALOGUE_MT_ID, EPID, PRIMARYCATEGORYID, CATEGORYID, TITLE, BRAND, DESCRIPTION, PRODUCTWEBURL, IMAGEURL, VERSION,INSERTEDDATE) VALUES ($ebay_catalogue_mt_id,$epid,$primarycategoryid,$categoryid,'$title','$brand','$description','$productweburl','$imageurl','$version',sysdate)");
        }else{
            $qry = $qry->result_array();
            $ebay_catalogue_mt_id =  $qry[0]['EBAY_CATALOGUE_MT_ID'];
        }
        /*=====  End of insert data in table  ======*/
        foreach ($response->aspects as $aspect) {
            $localizedName = $aspect->localizedName;
            $localizedName = strtr($localizedName, $trans);
            foreach ($aspect->localizedValues as $value) {
                $localizedValues = $value;
                $localizedValues = strtr($localizedValues, $trans);
                //echo 'localizedValues : '. $localizedValues . '<br>';
                $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_DT WHERE UPPER(LOCALIZEDNAME) = UPPER('$localizedName') AND UPPER(LOCALIZEDVALUES) = UPPER('$localizedValues') AND EBAY_CATALOGUE_MT_ID = $ebay_catalogue_mt_id");
                if($qry->num_rows() == 0 ){
                    $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_DT','EBAY_CATALOGUE_DT_ID') EBAY_CATALOGUE_DT_ID FROM DUAL");
                    $get_pk = $get_pk->result_array();
                    $ebay_catalogue_dt_id = $get_pk[0]['EBAY_CATALOGUE_DT_ID'];
                    /*============================================
                    =            insert data in table            =
                    ============================================*/

                    $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_DT (EBAY_CATALOGUE_DT_ID, EBAY_CATALOGUE_MT_ID, LOCALIZEDNAME, LOCALIZEDVALUES) VALUES ($ebay_catalogue_dt_id,$ebay_catalogue_mt_id,'$localizedName','$localizedValues')");
                }

                
            }//end foreach $aspect->localizedValues
            
        }//end foreach $response->aspects
        foreach (@$response->gtin as $gtin_val ){
            $localizedName = 'gtin';
            $localizedValues = $gtin_val;
            //echo 'localizedValues : '. $localizedValues . '<br>';
            $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_DT WHERE UPPER(LOCALIZEDNAME) = UPPER('$localizedName') AND UPPER(LOCALIZEDVALUES) = UPPER('$localizedValues') AND EBAY_CATALOGUE_MT_ID = $ebay_catalogue_mt_id");
            if($qry->num_rows() == 0 ){
                $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_DT','EBAY_CATALOGUE_DT_ID') EBAY_CATALOGUE_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $ebay_catalogue_dt_id = $get_pk[0]['EBAY_CATALOGUE_DT_ID'];
                /*============================================
                =            insert data in table            =
                ============================================*/

                $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_DT (EBAY_CATALOGUE_DT_ID, EBAY_CATALOGUE_MT_ID, LOCALIZEDNAME, LOCALIZEDVALUES) VALUES ($ebay_catalogue_dt_id,$ebay_catalogue_mt_id,'$localizedName','$localizedValues')");
            }

        }//end foreach $response->gtin

        foreach (@$response->mpn as $mpn_val ){
            $localizedName = 'mpn';
            $localizedValues = $mpn_val;
            $localizedValues = strtr($localizedValues, $trans);
            //echo 'localizedValues : '. $localizedValues . '<br>';
            $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_DT WHERE UPPER(LOCALIZEDNAME) = UPPER('$localizedName') AND UPPER(LOCALIZEDVALUES) = UPPER('$localizedValues') AND EBAY_CATALOGUE_MT_ID = $ebay_catalogue_mt_id");
            if($qry->num_rows() == 0 ){
                $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_DT','EBAY_CATALOGUE_DT_ID') EBAY_CATALOGUE_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $ebay_catalogue_dt_id = $get_pk[0]['EBAY_CATALOGUE_DT_ID'];
                /*============================================
                =            insert data in table            =
                ============================================*/

                $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_DT (EBAY_CATALOGUE_DT_ID, EBAY_CATALOGUE_MT_ID, LOCALIZEDNAME, LOCALIZEDVALUES) VALUES ($ebay_catalogue_dt_id,$ebay_catalogue_mt_id,'$localizedName','$localizedValues')");
            }

        }//end foreach $response->mpn
        foreach (@$response->ean as $ean_val ){
            $localizedName = 'ean';
            $localizedValues = $ean_val;
            //echo 'localizedValues : '. $localizedValues . '<br>';
            $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_DT WHERE UPPER(LOCALIZEDNAME) = UPPER('$localizedName') AND UPPER(LOCALIZEDVALUES) = UPPER('$localizedValues') AND EBAY_CATALOGUE_MT_ID = $ebay_catalogue_mt_id");
            if($qry->num_rows() == 0 ){
                $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_DT','EBAY_CATALOGUE_DT_ID') EBAY_CATALOGUE_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $ebay_catalogue_dt_id = $get_pk[0]['EBAY_CATALOGUE_DT_ID'];
                /*============================================
                =            insert data in table            =
                ============================================*/

                $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_DT (EBAY_CATALOGUE_DT_ID, EBAY_CATALOGUE_MT_ID, LOCALIZEDNAME, LOCALIZEDVALUES) VALUES ($ebay_catalogue_dt_id,$ebay_catalogue_mt_id,'$localizedName','$localizedValues')");
            }

        }//end foreach $response->ean

        foreach (@$response->upc as $upc_val ){
            $localizedName = 'upc';
            $localizedValues = $upc_val;
            //echo 'localizedValues : '. $localizedValues . '<br>';
            $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_DT WHERE UPPER(LOCALIZEDNAME) = UPPER('$localizedName') AND UPPER(LOCALIZEDVALUES) = UPPER('$localizedValues') AND EBAY_CATALOGUE_MT_ID = $ebay_catalogue_mt_id");
            if($qry->num_rows() == 0 ){
                $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_DT','EBAY_CATALOGUE_DT_ID') EBAY_CATALOGUE_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $ebay_catalogue_dt_id = $get_pk[0]['EBAY_CATALOGUE_DT_ID'];
                /*============================================
                =            insert data in table            =
                ============================================*/

                $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_DT (EBAY_CATALOGUE_DT_ID, EBAY_CATALOGUE_MT_ID, LOCALIZEDNAME, LOCALIZEDVALUES) VALUES ($ebay_catalogue_dt_id,$ebay_catalogue_mt_id,'$localizedName','$localizedValues')");
            }

        }//end foreach $response->upc

        foreach (@$response->otherApplicableCategoryIds as $otherApplicableCategoryIds_val ){
            $localizedName = 'otherApplicableCategoryIds';
            $localizedValues = $otherApplicableCategoryIds_val;
            //echo 'localizedValues : '. $localizedValues . '<br>';
            $qry = $this->db2->query("SELECT EBAY_CATALOGUE_MT_ID FROM LZ_EBAY_CATALOGUE_DT WHERE UPPER(LOCALIZEDNAME) = UPPER('$localizedName') AND UPPER(LOCALIZEDVALUES) = UPPER('$localizedValues') AND EBAY_CATALOGUE_MT_ID = $ebay_catalogue_mt_id");
            if($qry->num_rows() == 0 ){
                $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_EBAY_CATALOGUE_DT','EBAY_CATALOGUE_DT_ID') EBAY_CATALOGUE_DT_ID FROM DUAL");
                $get_pk = $get_pk->result_array();
                $ebay_catalogue_dt_id = $get_pk[0]['EBAY_CATALOGUE_DT_ID'];
                /*============================================
                =            insert data in table            =
                ============================================*/

                $this->db2->query("INSERT INTO LZ_EBAY_CATALOGUE_DT (EBAY_CATALOGUE_DT_ID, EBAY_CATALOGUE_MT_ID, LOCALIZEDNAME, LOCALIZEDVALUES) VALUES ($ebay_catalogue_dt_id,$ebay_catalogue_mt_id,'$localizedName','$localizedValues')");
            }

        }//end foreach $response->otherApplicableCategoryIds
     
    }//end if $response->getStatusCode() === 200
}//end data main foreach