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
//$config = require __DIR__.'/../configuration.php';
$config = require __DIR__.'/../configuration_modified.php';
/**
 * The namespaces provided by the SDK.
 */
use \DTS\eBaySDK\Constants;
use \DTS\eBaySDK\Browse\Services;
use \DTS\eBaySDK\Browse\Types;
use \DTS\eBaySDK\Browse\Enums;

/**
 * Create the service object.
 */
$service = new Services\BrowseService([
    'authorization' => $config['production1']['oauthUserToken'],
    'marketplaceId' => Constants\GlobalIds::US
]);

/**
 * Create the request object.
 */
//var_dump($config['production1']['oauthUserToken']);exit;
//$request = new Types\SearchForItemsRestRequest();

/**
 * Note how URI parameters are just properties on the request object.
 */
//foreach ($res as $value) {
   $request = new Types\SearchForItemsRestRequest();
    $request->q = $keyword;
    //$request->gtin = '0190198354754';
    //$request->epid = '182527490';
    //$request->q = 'iphone x';
    // $request->sort = '-price';
    $request->limit = '10';
    $request->category_ids = $category_id;
    $request->offset = '0';

    /**
     * Send the request.
     */
    $response = $service->searchForItems($request);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    // exit;
    /**
     * Output the result of calling the service operation.
     */
   // printf("\nStatus Code: %s\n\n<br>", $response->getStatusCode());
    if (isset($response->errors)) {
        foreach ($response->errors as $error) {
            if($error->errorId === 2001){//too many requet error
                echo "5000 Call limit Exceed";
                exit;
            }elseif($error->errorId === 1001){//Invalid access token code is 1001
                // $this->db2->query("UPDATE LZ_BD_MOST_WATCHED_ITEMS SET GETEPID = 1 WHERE WATCH_ID = $watch_id");
                $this->load->view('ebay/oauth-tokens/01-get-app-token-oraserver');//update token
                $this->load->view('ebay/browse/suggestEpid');//call again
            }else{
                // $this->db2->query("UPDATE LZ_BD_MOST_WATCHED_ITEMS SET GETEPID = 1 WHERE WATCH_ID = $watch_id");
                printf(
                "%s: %s\n%s\n\n",
                $error->errorId,
                $error->message,
                $error->longMessage
            );
            }
            
        }
        $epid_data =array('epid'=>'');
        //$this->session->set_userdata('epid_data', $epid_data);
        //return $response->errors;
    }

    if ($response->getStatusCode() === 200) {
        // echo "<pre>";
        //     print_r($response);
        //     echo "</pre>";
        //     exit;
    //if ($response->total > 0) {
        $epid=array();
        $title =array();
        $imageUrl =array();
        foreach ($response->itemSummaries as $item) {
            // printf(
            //     "(%s) %s: %s %.2f\n",
            //     $item->itemId,
            //     $item->title,
            //     $item->price->currency,
            //     $item->price->value
            // );
            // echo "<br>".$item->epid;
            
            if(property_exists(@$item , 'epid')){
                array_push($epid,@$item->epid);
                array_push($title,@$item->title); 
                array_push($imageUrl,@$item->image->imageUrl);
            }
        }
            //echo "<pre>";
            //var_dump($epid,$title,$imageUrl);
            //echo "</pre>";
            //exit;
        //return array('epid'=>$epid,'title'=>$title,'imageUrl'=>$imageUrl);
        //return 'sajid';
        $epid_data = array('epid'=>$epid,'title'=>$title,'imageUrl'=>$imageUrl);
    }
    //var_dump($epid,$title,$imageUrl);exit;
 

 $this->session->set_userdata('epid_data', $epid_data);
//return 1;

    //sleep(10);
    // echo "<pre>";
    // print_r($response);
    // echo "</pre>";
    // exit;
//}//end main foreach
// return $epid;
 ?>