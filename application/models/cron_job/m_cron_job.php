<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_cron_job extends CI_Model {
  
  public function cat_rss_feed($cat_id) {
    $flag = 0;
    $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE CATEGORY_ID = $cat_id")->result_array();
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    $feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE CATEGORY_ID = $cat_id";
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      $i = 0;
      foreach ($rss_feed_url as $feed_data) {
        //$category_id = $feed_data['CATEGORY_ID'];
        //$condition_id = $feed_data['CONDITION_ID'];
        $rss_feed_url = $feed_data['RSS_FEED_URL'];
        $feed_url_id = $feed_data['FEED_URL_ID'];
        //var_dump($rss_feed_url);//exit;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        $comma = ',';
        $i = 0;
        foreach ($rss as $item)
        {
          $title = $item['title'];
          $title = trim(str_replace("  ", ' ', $title));
          $title = str_replace(array("`,′"), "", $title);
          $title = str_replace(array("'"), "''", $title);
          $item_desc = $item['description'];
          $item_desc = trim(str_replace("  ", ' ', $item_desc));
          $item_desc = str_replace(array("`,′"), "", $item_desc);
          $item_desc = str_replace(array("'"), "''", $item_desc);
          $start_time = $item['pubDate'];
          $start_time = date('Y-m-d H:i:s', strtotime($start_time));
          $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
         // var_dump($start_time);exit;

          $parts = explode('/', $item['guid']);
          $ebay_id = explode('?', $parts[5]);
          $ebay_id = $ebay_id[0];
          $item_url = $item['link'];
          $item_url = trim(str_replace("  ", ' ', $item_url));
          $item_url = str_replace(array("`,′"), "", $item_url);
          $item_url = str_replace(array("'"), "''", $item_url);
          $sale_price = $item['CurrentPrice'][@$i]/100;
          $category_name = $item['Category'][@$i];
          $category_name = trim(str_replace("  ", ' ', $category_name));
          $category_name = str_replace(array("`,′"), "", $category_name);
          $category_name = str_replace(array("'"), "''", $category_name);
          $cat_id = $item['ch_link'][0];
          /*==================================================
          =            to get the mpn_id from url            =
          ==================================================*/
          $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($catalogue_mt_id)){
            $catalogue_mt_id = null;
          }
          /*=====  End of to get the mpn_id from url  ======*/
          
          //$condition_id = substr($cat_id, -4);
          $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($condition_id)){
            $condition_id = null;
          }
          $parts = explode('/', $cat_id);
          $category_id = $parts[5];
          $flag_id = '33';
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma '$flag_id' $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATEGORY_ID = '$category_id'");
              
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/

              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATEGORY_ID = '$category_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND FLAG_ID = $flag_id AND CATEGORY_ID = $category_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }

  public function lookup_feed($feed_id) {
    $flag = 0;
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED")->result_array();
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    $feed_qry = "SELECT RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID = $feed_id";
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
        //$category_id = $feed_data['CATEGORY_ID'];
        //$condition_id = $feed_data['CONDITION_ID'];
        $rss_feed_url = $feed_data['RSS_FEED_URL'];
        //var_dump($rss_feed_url);//exit;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        $comma = ',';
        $i = 0;
        foreach ($rss as $item)
        {
          $title = $item['title'];
          $title = trim(str_replace("  ", ' ', $title));
          $title = str_replace(array("`,′"), "", $title);
          $title = str_replace(array("'"), "''", $title);
          $item_desc = $item['description'];
          $item_desc = trim(str_replace("  ", ' ', $item_desc));
          $item_desc = str_replace(array("`,′"), "", $item_desc);
          $item_desc = str_replace(array("'"), "''", $item_desc);
          $start_time = $item['pubDate'];
          $start_time = date('Y-m-d H:i:s', strtotime($start_time));
          $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
         // var_dump($start_time);exit;

          $parts = explode('/', $item['guid']);
          $ebay_id = explode('?', $parts[5]);
          $ebay_id = $ebay_id[0];
          $item_url = $item['link'];
          $item_url = trim(str_replace("  ", ' ', $item_url));
          $item_url = str_replace(array("`,′"), "", $item_url);
          $item_url = str_replace(array("'"), "''", $item_url);
          $sale_price = $item['CurrentPrice'][@$i]/100;
          $category_name = $item['Category'][@$i];
          $category_name = trim(str_replace("  ", ' ', $category_name));
          $category_name = str_replace(array("`,′"), "", $category_name);
          $category_name = str_replace(array("'"), "''", $category_name);
          $cat_id = $item['ch_link'][0];
          /*==================================================
          =            to get the mpn_id from url            =
          ==================================================*/
          $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($catalogue_mt_id)){
            $catalogue_mt_id = null;
          }
          /*=====  End of to get the mpn_id from url  ======*/
          
          //$condition_id = substr($cat_id, -4);
          $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($condition_id)){
            $condition_id = null;
          }
          $parts = explode('/', $cat_id);
          $category_id = $parts[5];
          $flag_id = '';
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma 30 $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = 30 AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/

              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = 30 AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = 30 AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
  public function lookup_sold_feed($feed_id) {
    $feed_qry = "SELECT KEYWORD,CATEGORY_ID,CATLALOGUE_MT_ID,FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE KEYWORD IS NOT NULL AND CATLALOGUE_MT_ID IS NOT NULL AND FEED_URL_ID = $feed_id";
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    return $rss_feed_url;

  }
  public function runAllSoldFeed() {
    $feed_qry = "SELECT KEYWORD,CATEGORY_ID,CATLALOGUE_MT_ID,FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE KEYWORD IS NOT NULL AND CATLALOGUE_MT_ID IS NOT NULL ORDER BY FEED_URL_ID ASC";//AND FEED_URL_ID > 3889 
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    return $rss_feed_url;

  }
  public function runPurchasedSoldFeed() {
    $feed_qry = "SELECT KEYWORD,CATEGORY_ID,CATLALOGUE_MT_ID,FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE KEYWORD IS NOT NULL AND CATLALOGUE_MT_ID IS NOT NULL AND FEED_TYPE = 30 AND FEED_URL_ID  IN (SELECT DISTINCT U.FEED_URL_ID FROM LZ_MANIFEST_DET@ORASERVER MD, ITEMS_MT@ORASERVER I, LZ_BARCODE_MT@ORASERVER B, LZ_BD_RSS_FEED_URL U, (SELECT D.LZ_ESTIMATE_DET_ID, D.TECH_COND_ID,D.PART_CATLG_MT_ID FROM LZ_BD_PURCHASE_OFFER T, LZ_BD_ESTIMATE_MT    E, LZ_BD_ESTIMATE_DET   D WHERE T.LZ_BD_CATA_ID = E.LZ_BD_CATAG_ID AND T.WIN_STATUS = 1 AND D.LZ_BD_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID) T WHERE MD.EST_DET_ID = T.LZ_ESTIMATE_DET_ID AND MD.LAPTOP_ITEM_CODE = I.ITEM_CODE AND B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND B.CONDITION_ID = T.TECH_COND_ID AND B.EBAY_ITEM_ID IS NULL AND U.CATLALOGUE_MT_ID = T.PART_CATLG_MT_ID AND U.CONDITION_ID = T.TECH_COND_ID) ORDER BY FEED_URL_ID ASC";//AND FEED_URL_ID > 3889 
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    return $rss_feed_url;

  }
  public function createLookupStream_chunk(){
    /*==========================================================
    =            creating chunk of 100 rss feed url            =
    ==========================================================*/

    $get_feed_id = $this->db2->query("SELECT FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE FEED_TYPE = 30 ORDER BY FEED_URL_ID ASC")->result_array();
    $total_feed = count($get_feed_id);
    $total_loop = floor($total_feed/100);
    // var_dump($total_feed,$total_loop);exit;
    $min_value = min($get_feed_id);
    $max_value = max($get_feed_id);
    //var_dump($min_value,$max_value);exit;
    $k = 0;
    for ($i=0; $i<= $total_loop; $i++){
          $min_index = $k;

      $k=$min_index + 100;
      
      $url_min_id = $get_feed_id[$min_index]['FEED_URL_ID'];
      if(array_key_exists($k,$get_feed_id)){
        $max_index = $k;
        $url_max_id = $get_feed_id[$max_index]['FEED_URL_ID'];
      }else{
        $max_index = $max_value['FEED_URL_ID'];
        $url_max_id = $url_min_id + 100;
      }
      
      //var_dump($url_min_id,$url_max_id);exit;
      $dir = explode('\\', __DIR__);
      $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
        $path = $base_url."/LiveStream/lookupStream/".$url_min_id.'-'.$url_max_id.".bat";
        //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";
        if(!is_dir(@$path)){
          $fileData = "@ECHO\n".$dir[0]."\ncd ".$base_url."\n :STEP1 \n php index.php cron_job c_cron_job runLookupStreamChunk ".$url_min_id.' '. $url_max_id."\n IF ERRORLEVEL 1 GOTO :RETRY \n \n :RETRY \n php index.php cron_job c_cron_job runLookupStreamChunk ".$url_min_id.' '. $url_max_id." \n IF ERRORLEVEL 1 GOTO :STEP1 \n PAUSE";
         // var_dump($fileData,$dir[0]);exit;
          $myfile = fopen($path, "w") ;
          fwrite($myfile, $fileData);
          fclose($myfile);
        }else{
          echo "path not found";
        }
      
      
      //return true;
    
    }//end for loop
    echo "all feed created";
    //$max_feed_id = $max_feed_id[0]['FEED_ID'];
    
    /*=====  End of creating chunk of 100 rss feed url  ======*/
  }

  public function runLookupStreamChunk($min_url_id,$max_url_id) {
    $flag = 0;
    $flag_id = '30';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id ")->result_array();
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     $feed_qry = "SELECT FEED_URL_ID, CATEGORY_ID, CONDITION_ID, MIN_PRICE, MAX_PRICE, CATLALOGUE_MT_ID, '\"'||REPLACE(KEYWORD, ' ', '\"+\"') ||'\"' || REPLACE(EXCLUDE_WORDS, ' ', '+')  KEYWORD, LISTING_TYPE, EXCLUDE_WORDS,WITHIN,ZIPCODE,SELLER_FILTER,SELLER_NAME FROM LZ_BD_RSS_FEED_URL WHERE VERIFY_DATE IS NOT NULL AND FEED_TYPE = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    
    /*=====  End of query to create feed url at run time  ======*/
    
    /*=====================================================
    =            query to get feed url from db            =
    =====================================================*/
    
    //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    /*=====  End of query to get feed url from db  ======*/
    
    /*===================================================
    =            get script location from db            =
    ===================================================*/
    $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
    $site_id = $this->db2->query($site_qry)->result_array();
    $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
    if($this_site_id == 2){
      $location = chr(38).'LH_PrefLoc=3';
    }elseif($this_site_id == 1){
      $location = chr(38).'LH_PrefLoc=1';
    }
    
    /*=====  End of get script location from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
/*====================================================
=            code to get feed url from db            =
====================================================*/
        // $feed_url_id = $feed_data['FEED_URL_ID'];
        // $rss_feed_url = $feed_data['RSS_FEED_URL'];


/*=====  End of code to get feed url from db  ======*/

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];//exact word search so quote added
    // var_dump('"'.$keyWord.'"');exit;
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $sort_order = chr(38) .'_sop=10';//10 - newly listed

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }
    $rss_listing_type = $feed_data['LISTING_TYPE'];
    if($rss_listing_type == 'All'){
      $rss_listing_type = '';
    }else{
      $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
    }
    /*=================================================================================
    =            item filter commented on demand of Kazmi 30-May-18            =
    =================================================================================*/
    // $min_price = $feed_data['MIN_PRICE'];
    // $max_price = $feed_data['MAX_PRICE'];
    // if(!empty($min_price) && !empty($max_price)  ){
    //   /*==============================================
    //   =            30% addon in max price            =
    //   ==============================================*/
    //   $max_addon = ($max_price  / 100)*30;
    //   $max_price = $max_price + $max_addon ;
    //   $max_price = number_format((float)@$max_price,2,'.','');
      
    //   /*=====  End of 30% addon in max price  ======*/
    //   $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    // }else{
    //   $price_range = '';
    // }

    // $within = $feed_data['WITHIN'];
    // $zipcode = $feed_data['ZIPCODE'];
    // if(!empty($within) && !empty($zipcode)){
    //   $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    // }else{
    //   $radious = '';
    // }
    // $seller_filter = $feed_data['SELLER_FILTER'];
    // $seller_name = $feed_data['SELLER_NAME'];

    // $sell_name = ''; 
    // if (strpos($seller_name, ',') !== false) {
    //   $seller_name = explode(',', $seller_name);
    //   //var_dump(count($seller_name));
    //   if(count($seller_name) >2){
    //     $k = 1;
    //     foreach ($seller_name as $word) {
    //       if($k==1){
    //         $sell_name .= trim($word);
    //       }else{
    //         $sell_name .= '%2C'.trim($word);
    //       }
          
    //       $k++;
    //     }
    //   }else{
    //        $sell_name = trim($seller_name[0]);
    //   }
    // }else{
    //   $sell_name = $seller_name;
    // }

    // if(!empty($seller_filter) && !empty($sell_name)){
    //   $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
    // }else{
    //   $seller_range = '';
    // }

    $price_range = '';
    $radious = '';
    $seller_range = '';
    /*=====  End of item filter commented on demand of Kazmi 30-May-18  ======*/
    
    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $price_range;
    $lvar_rss_url4 = $radious;
    $lvar_rss_url5 = $seller_range;

  /*=========================================================================
    =            loop on every posible condition in given category            =
    =========================================================================*/
    $qry = $this->db2->query("SELECT C.CONDITION_ID FROM LZ_BD_CAT_COND C WHERE C.CATEGORY_ID = $category_id ORDER BY C.CONDITION_ID ASC");  
    $avail_cond = $qry->result_array();
    if($qry->num_rows() > 0){
      foreach ($avail_cond as $val) {
        $item_condition = chr(38) . 'LH_ItemCondition=' . $val['CONDITION_ID'];
        $lvar_rss_url6 = $item_condition . chr(38) .'_rss=1'.$mpn;
        $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/

        $rss_feed_url = $rss_feed_url . $location ;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

          $comma = ',';
          $i = 0;
          foreach ($rss as $item)
          {
            $title = $item['title'];
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $item_desc = $item['description'];
            $item_desc = trim(str_replace("  ", ' ', $item_desc));
            $item_desc = str_replace(array("`,′"), "", $item_desc);
            $item_desc = str_replace(array("'"), "''", $item_desc);
            $start_time = $item['pubDate'];
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
           // var_dump($start_time);exit;

            $parts = explode('/', $item['guid']);
            $ebay_id = explode('?', $parts[5]);
            $ebay_id = $ebay_id[0];
            $item_url = $item['link'];
            $item_url = trim(str_replace("  ", ' ', $item_url));
            $item_url = str_replace(array("`,′"), "", $item_url);
            $item_url = str_replace(array("'"), "''", $item_url);
            $sale_price = $item['CurrentPrice'][@$i]/100;
            $category_name = $item['Category'][@$i];
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = str_replace(array("`,′"), "", $category_name);
            $category_name = str_replace(array("'"), "''", $category_name);
            $cat_id = $item['ch_link'][0];
            /*==================================================
            =            to get the mpn_id from url            =
            ==================================================*/
            $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($catalogue_mt_id)){
              $catalogue_mt_id = null;
            }
            /*=====  End of to get the mpn_id from url  ======*/
            
            //$condition_id = substr($cat_id, -4);
            $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($condition_id)){
              $condition_id = null;
            }
            $parts = explode('/', $cat_id);
            $category_id = $parts[5];
            // if(!empty($catalogue_mt_id)){
            //   $flag_id = '30';
            // }else{
            //   $flag_id = '32';
            // }
            
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              //Call log insertion query

              $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

              $max_time = $min_max_query[0]['MAX_TIME'];
              $min_time = $min_max_query[0]['MIN_TIME'];
              $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
              $min_time = new DateTime($min_time);
               
              $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
              $max_time = new DateTime($max_time);
              
              //var_dump($min_time,$max_time);exit;         

              // $dteStart = new DateTime($min_time); 
              // $dteEnd   = new DateTime($max_time); 
              $dteDiff  = $min_time->diff($max_time); 
              $min_time = $min_time->format('Y-m-d\TH:i:s');
              $max_time = $max_time->format('Y-m-d\TH:i:s');
              $execution_time = $dteDiff->format("%d days %H:%I:%S");
              $min_time = str_replace(array("T"), "", $min_time); 
              $max_time = str_replace(array("T"), "", $max_time);
              $time_in_min = $dteDiff->format("%I");
              $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
              $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
              //var_dump($min_time,$max_time);exit;
              $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
              // $total_records = oci_parse($conn, $total_query);
              // oci_execute($total_records,OCI_DEFAULT);
              // $total = oci_fetch_array($total_records, OCI_ASSOC);
              if($time_in_min != 0){
                  $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
              }else{
                  $per_mint_records = 0;
              }
              $total_records = $total_query[0]['TOTAL_RECORDS'];
              
              // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
              // $avg_records = oci_parse($conn, $per_day_avg_qry);
              // oci_execute($avg_records,OCI_DEFAULT);
              // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
              // //var_dump($avg_records_data['AVERAGE']);exit;
              // $avg_records_data = @$avg_records_data['AVERAGE'];
              // if(empty($avg_records_data)){
              //     $avg_records_data = 'null';
              // }else{
              //     $avg_records_data = @$avg_records_data['AVERAGE'];
              // } 
              
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

              $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
              // $select = oci_parse($conn, $select_query);
              // oci_execute($select,OCI_DEFAULT);
              // $rs = oci_fetch_array($select, OCI_ASSOC);

              $call_log_id = $select_query[0]['CALL_LOG_ID']; 

              $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

              /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else

              /*=====  End of check if already exist  ======*/

            $i++;
          }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
      }//end avail_cond foreach
    }else{
      $lvar_rss_url6 = $item_condition . chr(38) .'_rss=1'.$mpn;
      $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/

        $rss_feed_url = $rss_feed_url . $location ;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

          $comma = ',';
          $i = 0;
          foreach ($rss as $item)
          {
            $title = $item['title'];
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $item_desc = $item['description'];
            $item_desc = trim(str_replace("  ", ' ', $item_desc));
            $item_desc = str_replace(array("`,′"), "", $item_desc);
            $item_desc = str_replace(array("'"), "''", $item_desc);
            $start_time = $item['pubDate'];
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
           // var_dump($start_time);exit;

            $parts = explode('/', $item['guid']);
            $ebay_id = explode('?', $parts[5]);
            $ebay_id = $ebay_id[0];
            $item_url = $item['link'];
            $item_url = trim(str_replace("  ", ' ', $item_url));
            $item_url = str_replace(array("`,′"), "", $item_url);
            $item_url = str_replace(array("'"), "''", $item_url);
            $sale_price = $item['CurrentPrice'][@$i]/100;
            $category_name = $item['Category'][@$i];
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = str_replace(array("`,′"), "", $category_name);
            $category_name = str_replace(array("'"), "''", $category_name);
            $cat_id = $item['ch_link'][0];
            /*==================================================
            =            to get the mpn_id from url            =
            ==================================================*/
            $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($catalogue_mt_id)){
              $catalogue_mt_id = null;
            }
            /*=====  End of to get the mpn_id from url  ======*/
            
            //$condition_id = substr($cat_id, -4);
            $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($condition_id)){
              $condition_id = null;
            }
            $parts = explode('/', $cat_id);
            $category_id = $parts[5];
            // if(!empty($catalogue_mt_id)){
            //   $flag_id = '30';
            // }else{
            //   $flag_id = '32';
            // }
            
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              //Call log insertion query

              $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

              $max_time = $min_max_query[0]['MAX_TIME'];
              $min_time = $min_max_query[0]['MIN_TIME'];
              $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
              $min_time = new DateTime($min_time);
               
              $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
              $max_time = new DateTime($max_time);
              
              //var_dump($min_time,$max_time);exit;         

              // $dteStart = new DateTime($min_time); 
              // $dteEnd   = new DateTime($max_time); 
              $dteDiff  = $min_time->diff($max_time); 
              $min_time = $min_time->format('Y-m-d\TH:i:s');
              $max_time = $max_time->format('Y-m-d\TH:i:s');
              $execution_time = $dteDiff->format("%d days %H:%I:%S");
              $min_time = str_replace(array("T"), "", $min_time); 
              $max_time = str_replace(array("T"), "", $max_time);
              $time_in_min = $dteDiff->format("%I");
              $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
              $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
              //var_dump($min_time,$max_time);exit;
              $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
              // $total_records = oci_parse($conn, $total_query);
              // oci_execute($total_records,OCI_DEFAULT);
              // $total = oci_fetch_array($total_records, OCI_ASSOC);
              if($time_in_min != 0){
                  $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
              }else{
                  $per_mint_records = 0;
              }
              $total_records = $total_query[0]['TOTAL_RECORDS'];
              
              // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
              // $avg_records = oci_parse($conn, $per_day_avg_qry);
              // oci_execute($avg_records,OCI_DEFAULT);
              // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
              // //var_dump($avg_records_data['AVERAGE']);exit;
              // $avg_records_data = @$avg_records_data['AVERAGE'];
              // if(empty($avg_records_data)){
              //     $avg_records_data = 'null';
              // }else{
              //     $avg_records_data = @$avg_records_data['AVERAGE'];
              // } 
              
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

              $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
              // $select = oci_parse($conn, $select_query);
              // oci_execute($select,OCI_DEFAULT);
              // $rs = oci_fetch_array($select, OCI_ASSOC);

              $call_log_id = $select_query[0]['CALL_LOG_ID']; 

              $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

              /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else

              /*=====  End of check if already exist  ======*/

            $i++;
          }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
    }//end $qry->num_rows() > 0 if else
    

    /*=====  End of loop on every posible condition in given category  ======*/
    
      }//end rss_feed_url foreach
    }//main num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
//   public function runLocalStreamChunk($min_url_id,$max_url_id) {
//     $flag = 0;
//     $flag_id = '32';
//     // $cat_id = $this->input->post("")
//     // $category_id = $cat_id;
//     $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id AND FLAG_ID = $flag_id")->result_array();
//     $max_feed_id = $max_feed_id[0]['FEED_ID'];
//     /*============================================================
//     =            query to create feed url at run time            =
//     ============================================================*/
//      $feed_qry = "SELECT FEED_URL_ID, CATEGORY_ID, CONDITION_ID, MIN_PRICE, MAX_PRICE, CATLALOGUE_MT_ID, REPLACE(KEYWORD||EXCLUDE_WORDS, ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS,WITHIN,ZIPCODE,SELLER_FILTER,SELLER_NAME FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id AND FEED_TYPE = $flag_id";
    
    
//     /*=====  End of query to create feed url at run time  ======*/
    
//     /*=====================================================
//     =            query to get feed url from db            =
//     =====================================================*/
    
//     //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
//     /*=====  End of query to get feed url from db  ======*/
    
    
//     $get_rss_url = $this->db2->query($feed_qry);
//     $rss_feed_url = $get_rss_url->result_array();
//     if($get_rss_url->num_rows() > 0){
//       foreach ($rss_feed_url as $feed_data) {
// /*====================================================
// =            code to get feed url from db            =
// ====================================================*/
//         // $feed_url_id = $feed_data['FEED_URL_ID'];
//         // $rss_feed_url = $feed_data['RSS_FEED_URL'];


// /*=====  End of code to get feed url from db  ======*/

// /*===========================================================
// =            code to create feed URL at run time            =
// ===========================================================*/
//     $feed_url_id = $feed_data['FEED_URL_ID'];
//     $keyWord = $feed_data['KEYWORD'];
//     //$exclude_words = $feed_data['EXCLUDE_WORDS'];
//     $keyWord = chr(38) . '_nkw=' . $keyWord;
//     $sort_order = chr(38) .'_sop=10';//10 - newly listed

//     $category_id = $feed_data['CATEGORY_ID'];
//     $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
//     if(!empty($catalogue_mt_id)){
//       $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
//     }else{
//       $mpn = '';
//     }
//     $rss_feed_cond = $feed_data['CONDITION_ID'];
//     if($rss_feed_cond != 0){
//       $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
//     }else{
//       $item_condition = '';
//     }
//     $rss_listing_type = $feed_data['LISTING_TYPE'];
//     if($rss_listing_type == 'All'){
//       $rss_listing_type = '';
//     }else{
//       $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
//     }
    
//     $min_price = $feed_data['MIN_PRICE'];
//     $max_price = $feed_data['MAX_PRICE'];
//     if(!empty($min_price) && !empty($max_price)  ){
//       /*==============================================
//       =            30% addon in max price            =
//       ==============================================*/
//       $max_addon = ($max_price  / 100)*30;
//       $max_price = $max_price + $max_addon ;
//       $max_price = number_format((float)@$max_price,2,'.','');
      
//       /*=====  End of 30% addon in max price  ======*/
//       $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
//     }else{
//       $price_range = '';
//     }
//     $within = $feed_data['WITHIN'];
//     $zipcode = $feed_data['ZIPCODE'];
//     if(!empty($within) && !empty($zipcode)){
//       $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
//     }else{
//       $radious = '';
//     }
//     $seller_filter = $feed_data['SELLER_FILTER'];
//     $seller_name = $feed_data['SELLER_NAME'];

//     $sell_name = ''; 
//     if (strpos($seller_name, ',') !== false) {
//       $seller_name = explode(',', $seller_name);
//       //var_dump(count($seller_name));
//       if(count($seller_name) >2){
//         $k = 1;
//         foreach ($seller_name as $word) {
//           if($k==1){
//             $sell_name .= trim($word);
//           }else{
//             $sell_name .= '%2C'.trim($word);
//           }
          
//           $k++;
//         }
//       }else{
//            $sell_name = trim($seller_name[0]);
//       }
//     }else{
//       $sell_name = $seller_name;
//     }

//     if(!empty($seller_filter) && !empty($sell_name)){
//       $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
//     }else{
//       $seller_range = '';
//     }
    

//     $lvar_rss_url1 = 'https://www.ebay.com/sch/';
//     $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
//     $lvar_rss_url3 = $price_range;
//     $lvar_rss_url4 = $radious;

//     $lvar_rss_url5 = $seller_range;
//     $lvar_rss_url6 =$item_condition . chr(38) .'_rss=1'.$mpn;
//     $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

// //var_dump( $rss_feed_url);exit;
// /*=====  End of code to create feed URL at run time  ======*/



//         $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
//         $site_id = $this->db2->query($site_qry)->result_array();
//         $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
//         if($this_site_id == 2){
//           $location = chr(38).'LH_PrefLoc=3';
//         }elseif($this_site_id == 1){
//           $location = chr(38).'LH_PrefLoc=1';
//         }
//         $rss_feed_url = $rss_feed_url . $location ;
//         $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
//         if(count($rss)>0){

        
//         $comma = ',';
//         $i = 0;
//         foreach ($rss as $item)
//         {
//           $title = $item['title'];
//           $title = trim(str_replace("  ", ' ', $title));
//           $title = str_replace(array("`,′"), "", $title);
//           $title = str_replace(array("'"), "''", $title);
//           $item_desc = $item['description'];
//           $item_desc = trim(str_replace("  ", ' ', $item_desc));
//           $item_desc = str_replace(array("`,′"), "", $item_desc);
//           $item_desc = str_replace(array("'"), "''", $item_desc);
//           $start_time = $item['pubDate'];
//           $start_time = date('Y-m-d H:i:s', strtotime($start_time));
//           $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
//          // var_dump($start_time);exit;

//           $parts = explode('/', $item['guid']);
//           $ebay_id = explode('?', $parts[5]);
//           $ebay_id = $ebay_id[0];
//           $item_url = $item['link'];
//           $item_url = trim(str_replace("  ", ' ', $item_url));
//           $item_url = str_replace(array("`,′"), "", $item_url);
//           $item_url = str_replace(array("'"), "''", $item_url);
//           $sale_price = $item['CurrentPrice'][@$i]/100;
//           $category_name = $item['Category'][@$i];
//           $category_name = trim(str_replace("  ", ' ', $category_name));
//           $category_name = str_replace(array("`,′"), "", $category_name);
//           $category_name = str_replace(array("'"), "''", $category_name);
//           $cat_id = $item['ch_link'][0];
//           /*==================================================
//           =            to get the mpn_id from url            =
//           ==================================================*/
//           $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
//           if(!is_numeric($catalogue_mt_id)){
//             $catalogue_mt_id = null;
//           }
//           /*=====  End of to get the mpn_id from url  ======*/
          
//           //$condition_id = substr($cat_id, -4);
//           $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
//           if(!is_numeric($condition_id)){
//             $condition_id = null;
//           }
//           $parts = explode('/', $cat_id);
//           $category_id = $parts[5];
//           // if(!empty($catalogue_mt_id)){
//           //   $flag_id = '30';
//           // }else{
//           //   $flag_id = '32';
//           // }
          
//             /*==============================================
//             =            check if already exist            =
//             ==============================================*/
//             $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
//             if($check_qry->num_rows() >0){
//               //$i = 0;
//               echo $i ." - alredy insert".PHP_EOL;
//               $flag = 0;
//               break;

//             }else{
//               /*============================================
//               =            Insert feed in table            =
//               ============================================*/
//               date_default_timezone_set("America/Chicago");
//               $inserted_date = date("Y-m-d H:i:s");
//               $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
//               // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
//               // $feed_pk_id = $get_pk[0]['FEED_ID'];
//               $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
//               echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
//               /*=====  End of Insert feed in table  ======*/
              
//               /*============================================
//               =            MOVE DATA TO MAIN TABLE            =
//               ============================================*/
//               $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id");
              
//     //Call log insertion query

//     $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id")->result_array();

//     $max_time = $min_max_query[0]['MAX_TIME'];
//     $min_time = $min_max_query[0]['MIN_TIME'];
//     $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
//     $min_time = new DateTime($min_time);
     
//     $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
//     $max_time = new DateTime($max_time);
    
//     //var_dump($min_time,$max_time);exit;         

//     // $dteStart = new DateTime($min_time); 
//     // $dteEnd   = new DateTime($max_time); 
//     $dteDiff  = $min_time->diff($max_time); 
//     $min_time = $min_time->format('Y-m-d\TH:i:s');
//     $max_time = $max_time->format('Y-m-d\TH:i:s');
//     $execution_time = $dteDiff->format("%d days %H:%I:%S");
//     $min_time = str_replace(array("T"), "", $min_time); 
//     $max_time = str_replace(array("T"), "", $max_time);
//     $time_in_min = $dteDiff->format("%I");
//     $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
//     $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
//     //var_dump($min_time,$max_time);exit;
//     $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id")->result_array();
//     // $total_records = oci_parse($conn, $total_query);
//     // oci_execute($total_records,OCI_DEFAULT);
//     // $total = oci_fetch_array($total_records, OCI_ASSOC);
//     if($time_in_min != 0){
//         $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
//     }else{
//         $per_mint_records = 0;
//     }
//     $total_records = $total_query[0]['TOTAL_RECORDS'];
    
//     // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
//     // $avg_records = oci_parse($conn, $per_day_avg_qry);
//     // oci_execute($avg_records,OCI_DEFAULT);
//     // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
//     // //var_dump($avg_records_data['AVERAGE']);exit;
//     // $avg_records_data = @$avg_records_data['AVERAGE'];
//     // if(empty($avg_records_data)){
//     //     $avg_records_data = 'null';
//     // }else{
//     //     $avg_records_data = @$avg_records_data['AVERAGE'];
//     // } 
    
//     $inserted_date = date("Y-m-d H:i:s");
//     $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

//     $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
//     // $select = oci_parse($conn, $select_query);
//     // oci_execute($select,OCI_DEFAULT);
//     // $rs = oci_fetch_array($select, OCI_ASSOC);

//     $call_log_id = $select_query[0]['CALL_LOG_ID']; 

//     $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

//     /* --Call log insertion end-- */
//               /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
//               /*============================================
//               =            TRUNCATE TEMP TABLE            =
//               ============================================*/

//               $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id");
              
//               /*=====  End of TRUNCATE TEMP TABLE  ======*/
//               $flag = 1;
//             }//end check if else


//             /*=====  End of check if already exist  ======*/

//           $i++;
//         }//end item feed foreach
//         }//count if close
//           /*=====  End of select rss feed  ======*/
//       }//end rss_feed_url foreach
//     }//num rows if close

//     /*================================================
//       =            update newly listed flag            =
//       ================================================*/
//       if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
//         $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id AND FEED_ID <= $max_feed_id");
//       }
//     /*=====  End of update newly listed flag  ======*/
              
//     return $flag;

//   }
    public function runFeedChunktest($min_url_id,$max_url_id) {
    $flag = 0;
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED")->result_array();
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    $feed_qry = "SELECT FEED_URL_ID, CATEGORY_ID, CONDITION_ID, MIN_PRICE, MAX_PRICE, CATLALOGUE_MT_ID, REPLACE(KEYWORD,' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
        $feedurlid = $feed_data['FEED_URL_ID'];
        $keyWord = $feed_data['KEYWORD'];
        $exclude_words = $feed_data['EXCLUDE_WORDS'];
        $category_id = $feed_data['CATEGORY_ID'];
        $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
        $rss_feed_cond = $feed_data['CONDITION_ID'];
        $rss_listing_type = $feed_data['LISTING_TYPE'];
        $min_price = $feed_data['MIN_PRICE'];
        $max_price = $feed_data['MAX_PRICE'];


    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . chr(38) . '_nkw=' . $keyWord.$exclude_words . chr(38) . '_sop=10' . chr(38) . 'rt=nc' . chr(38) . 'LH_'.$rss_listing_type.'=1'; 
    $lvar_rss_url3 = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    $lvar_rss_url4 =chr(38) . 'LH_ItemCondition=' . $rss_feed_cond . chr(38) .'_rss=1' . chr(38) . '_mpn=' . $catalogue_mt_id;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4;
        //var_dump($lvar_final_url);exit;
        //&LH_PrefLoc=3
        $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
        $site_id = $this->db2->query($site_qry)->result_array();
        $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
        if($this_site_id == 2){
          $location = chr(38).'LH_PrefLoc=3';
        }elseif($this_site_id == 1){
          $location = chr(38).'LH_PrefLoc=1';
        }
        $rss_feed_url = $rss_feed_url . $location ;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        $comma = ',';
        $i = 0;
        foreach ($rss as $item)
        {
          $title = $item['title'];
          $title = trim(str_replace("  ", ' ', $title));
          $title = str_replace(array("`,′"), "", $title);
          $title = str_replace(array("'"), "''", $title);
          $item_desc = $item['description'];
          $item_desc = trim(str_replace("  ", ' ', $item_desc));
          $item_desc = str_replace(array("`,′"), "", $item_desc);
          $item_desc = str_replace(array("'"), "''", $item_desc);
          $start_time = $item['pubDate'];
          $start_time = date('Y-m-d H:i:s', strtotime($start_time));
          $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
         // var_dump($start_time);exit;

          $parts = explode('/', $item['guid']);
          $ebay_id = explode('?', $parts[5]);
          $ebay_id = $ebay_id[0];
          $item_url = $item['link'];
          $item_url = trim(str_replace("  ", ' ', $item_url));
          $item_url = str_replace(array("`,′"), "", $item_url);
          $item_url = str_replace(array("'"), "''", $item_url);
          $sale_price = $item['CurrentPrice'][@$i]/100;
          $category_name = $item['Category'][@$i];
          $category_name = trim(str_replace("  ", ' ', $category_name));
          $category_name = str_replace(array("`,′"), "", $category_name);
          $category_name = str_replace(array("'"), "''", $category_name);
          $cat_id = $item['ch_link'][0];
          /*==================================================
          =            to get the mpn_id from url            =
          ==================================================*/
          $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($catalogue_mt_id)){
            $catalogue_mt_id = null;
          }
          /*=====  End of to get the mpn_id from url  ======*/
          
          //$condition_id = substr($cat_id, -4);
          $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($condition_id)){
            $condition_id = null;
          }
          $parts = explode('/', $cat_id);
          $category_id = $parts[5];
          $flag_id = '';
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma 30 $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = 30 AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/

              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = 30 AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = 30 AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
  public function createLocalStream_chunk(){
    /*==========================================================
    =            creating chunk of 100 rss feed url            =
    ==========================================================*/
    $flag_id = '32';
    $get_feed_id = $this->db2->query("SELECT FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE FEED_TYPE = $flag_id ORDER BY FEED_URL_ID ASC")->result_array();
    $total_feed = count($get_feed_id);
    $total_loop = floor($total_feed/100);
    // var_dump($total_feed,$total_loop);exit;
    $min_value = min($get_feed_id);
    $max_value = max($get_feed_id);
    //var_dump($min_value,$max_value);exit;
    $k = 0;
    for ($i=0; $i<= $total_loop; $i++){
          $min_index = $k;

      $k=$min_index + 100;
      
      $url_min_id = $get_feed_id[$min_index]['FEED_URL_ID'];
      if(array_key_exists($k,$get_feed_id)){
        $max_index = $k;
        $url_max_id = $get_feed_id[$max_index]['FEED_URL_ID'];
      }else{
        $max_index = $max_value['FEED_URL_ID'];
        $url_max_id = $url_min_id + 100;
      }
      
      //var_dump($url_min_id,$url_max_id);exit;
      $dir = explode('\\', __DIR__);
      $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
        $path = $base_url."/LiveStream/localStream/".$url_min_id.'-'.$url_max_id.".bat";
        //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";
        if(!is_dir(@$path)){
          $fileData = "@ECHO\n".$dir[0]."\ncd ".$base_url."\n :STEP1 \n php index.php cron_job c_cron_job runLocalStreamChunk ".$url_min_id.' '. $url_max_id."\n IF ERRORLEVEL 1 GOTO :RETRY \n \n :RETRY \n php index.php cron_job c_cron_job runLocalStreamChunk ".$url_min_id.' '. $url_max_id." \n IF ERRORLEVEL 1 GOTO :STEP1 \n PAUSE";
         // var_dump($fileData,$dir[0]);exit;
          $myfile = fopen($path, "w") ;
          fwrite($myfile, $fileData);
          fclose($myfile);
        }else{
          echo "path not found";
        }
      
      
      //return true;
    
    }//end for loop
    echo "all feed created";
    //$max_feed_id = $max_feed_id[0]['FEED_ID'];
    
    /*=====  End of creating chunk of 100 rss feed url  ======*/
  }

  public function runCategoryStream($cat_id) {
    $flag = 0;
    $flag_id = '33';
    // $cat_id = $this->input->post("")
    $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE CATEGORY_ID = $category_id AND FLAG_ID = $flag_id")->result_array();
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     $feed_qry = "SELECT FEED_URL_ID, CATEGORY_ID, CONDITION_ID, MIN_PRICE, MAX_PRICE, CATLALOGUE_MT_ID, REPLACE(KEYWORD||EXCLUDE_WORDS, ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS,WITHIN,ZIPCODE,SELLER_FILTER,SELLER_NAME FROM LZ_BD_RSS_FEED_URL WHERE CATEGORY_ID = $category_id and FEED_TYPE = $flag_id";
    
    
    /*=====  End of query to create feed url at run time  ======*/
    
    /*=====================================================
    =            query to get feed url from db            =
    =====================================================*/
    
    //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    /*=====  End of query to get feed url from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
/*====================================================
=            code to get feed url from db            =
====================================================*/
        // $feed_url_id = $feed_data['FEED_URL_ID'];
        // $rss_feed_url = $feed_data['RSS_FEED_URL'];


/*=====  End of code to get feed url from db  ======*/

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $sort_order = chr(38) .'_sop=10';//10 - newly listed

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }
    $rss_listing_type = $feed_data['LISTING_TYPE'];
    if($rss_listing_type == 'All'){
      $rss_listing_type = '';
    }else{
      $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
    }
    
    $min_price = $feed_data['MIN_PRICE'];
    $max_price = $feed_data['MAX_PRICE'];
    if(!empty($min_price) && !empty($max_price)  ){
      /*==============================================
      =            30% addon in max price            =
      ==============================================*/
      $max_addon = ($max_price  / 100)*30;
      $max_price = $max_price + $max_addon ;
      $max_price = number_format((float)@$max_price,2,'.','');
      
      /*=====  End of 30% addon in max price  ======*/
      $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    }else{
      $price_range = '';
    }
    $within = $feed_data['WITHIN'];
    $zipcode = $feed_data['ZIPCODE'];
    if(!empty($within) && !empty($zipcode)){
      $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    }else{
      $radious = '';
    }
    $seller_filter = $feed_data['SELLER_FILTER'];
    $seller_name = $feed_data['SELLER_NAME'];

    $sell_name = ''; 
    if (strpos($seller_name, ',') !== false) {
      $seller_name = explode(',', $seller_name);
      //var_dump(count($seller_name));
      if(count($seller_name) >2){
        $k = 1;
        foreach ($seller_name as $word) {
          if($k==1){
            $sell_name .= trim($word);
          }else{
            $sell_name .= '%2C'.trim($word);
          }
          
          $k++;
        }
      }else{
           $sell_name = trim($seller_name[0]);
      }
    }else{
      $sell_name = $seller_name;
    }

    if(!empty($seller_filter) && !empty($sell_name)){
      $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
    }else{
      $seller_range = '';
    }
    

    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $price_range;
    $lvar_rss_url4 = $radious;

    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 =$item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/



        $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
        $site_id = $this->db2->query($site_qry)->result_array();
        $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
        if($this_site_id == 2){
          $location = chr(38).'LH_PrefLoc=3';
        }elseif($this_site_id == 1){
          $location = chr(38).'LH_PrefLoc=1';
        }
        $rss_feed_url = $rss_feed_url . $location ;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

        
        $comma = ',';
        $i = 0;
        foreach ($rss as $item)
        {
          $title = $item['title'];
          $title = trim(str_replace("  ", ' ', $title));
          $title = str_replace(array("`,′"), "", $title);
          $title = str_replace(array("'"), "''", $title);
          $item_desc = $item['description'];
          $item_desc = trim(str_replace("  ", ' ', $item_desc));
          $item_desc = str_replace(array("`,′"), "", $item_desc);
          $item_desc = str_replace(array("'"), "''", $item_desc);
          $start_time = $item['pubDate'];
          $start_time = date('Y-m-d H:i:s', strtotime($start_time));
          $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
         // var_dump($start_time);exit;

          $parts = explode('/', $item['guid']);
          $ebay_id = explode('?', $parts[5]);
          $ebay_id = $ebay_id[0];
          $item_url = $item['link'];
          $item_url = trim(str_replace("  ", ' ', $item_url));
          $item_url = str_replace(array("`,′"), "", $item_url);
          $item_url = str_replace(array("'"), "''", $item_url);
          $sale_price = $item['CurrentPrice'][@$i]/100;
          $category_name = $item['Category'][@$i];
          $category_name = trim(str_replace("  ", ' ', $category_name));
          $category_name = str_replace(array("`,′"), "", $category_name);
          $category_name = str_replace(array("'"), "''", $category_name);
          $cat_id = $item['ch_link'][0];
          /*==================================================
          =            to get the mpn_id from url            =
          ==================================================*/
          $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($catalogue_mt_id)){
            $catalogue_mt_id = null;
          }
          /*=====  End of to get the mpn_id from url  ======*/
          
          //$condition_id = substr($cat_id, -4);
          $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($condition_id)){
            $condition_id = null;
          }
          $parts = explode('/', $cat_id);
          $category_id = $parts[5];
          // if(!empty($catalogue_mt_id)){
          //   $flag_id = '30';
          // }else{
          //   $flag_id = '32';
          // }
          
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE CATEGORY_ID = $category_id AND FLAG_ID = $flag_id");
              
    //Call log insertion query

    $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.CATEGORY_ID = $category_id AND D.FLAG_ID = $flag_id")->result_array();

    $max_time = $min_max_query[0]['MAX_TIME'];
    $min_time = $min_max_query[0]['MIN_TIME'];
    $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
    $min_time = new DateTime($min_time);
     
    $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
    $max_time = new DateTime($max_time);
    
    //var_dump($min_time,$max_time);exit;         

    // $dteStart = new DateTime($min_time); 
    // $dteEnd   = new DateTime($max_time); 
    $dteDiff  = $min_time->diff($max_time); 
    $min_time = $min_time->format('Y-m-d\TH:i:s');
    $max_time = $max_time->format('Y-m-d\TH:i:s');
    $execution_time = $dteDiff->format("%d days %H:%I:%S");
    $min_time = str_replace(array("T"), "", $min_time); 
    $max_time = str_replace(array("T"), "", $max_time);
    $time_in_min = $dteDiff->format("%I");
    $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
    //var_dump($min_time,$max_time);exit;
    $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.CATEGORY_ID = $category_id AND D.FLAG_ID = $flag_id")->result_array();
    // $total_records = oci_parse($conn, $total_query);
    // oci_execute($total_records,OCI_DEFAULT);
    // $total = oci_fetch_array($total_records, OCI_ASSOC);
    if($time_in_min != 0){
        $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
    }else{
        $per_mint_records = 0;
    }
    $total_records = $total_query[0]['TOTAL_RECORDS'];
    
    // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
    // $avg_records = oci_parse($conn, $per_day_avg_qry);
    // oci_execute($avg_records,OCI_DEFAULT);
    // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
    // //var_dump($avg_records_data['AVERAGE']);exit;
    // $avg_records_data = @$avg_records_data['AVERAGE'];
    // if(empty($avg_records_data)){
    //     $avg_records_data = 'null';
    // }else{
    //     $avg_records_data = @$avg_records_data['AVERAGE'];
    // } 
    
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

    $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
    // $select = oci_parse($conn, $select_query);
    // oci_execute($select,OCI_DEFAULT);
    // $rs = oci_fetch_array($select, OCI_ASSOC);

    $call_log_id = $select_query[0]['CALL_LOG_ID']; 

    $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

    /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE CATEGORY_ID = $category_id AND FLAG_ID = $flag_id");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATEGORY_ID = $category_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }

  public function runLocalStreamChunk($min_url_id,$max_url_id) {
    $flag = 0;
    $flag_id = '32';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id AND FLAG_ID = $flag_id")->result_array();
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     $feed_qry = "SELECT FEED_URL_ID, CATEGORY_ID, CONDITION_ID, MIN_PRICE, MAX_PRICE, CATLALOGUE_MT_ID, REPLACE(KEYWORD||EXCLUDE_WORDS, ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS,WITHIN,ZIPCODE,SELLER_FILTER,SELLER_NAME FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id AND FEED_TYPE = $flag_id";
    
    
    /*=====  End of query to create feed url at run time  ======*/
    
    /*=====================================================
    =            query to get feed url from db            =
    =====================================================*/
    
    //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    /*=====  End of query to get feed url from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
/*====================================================
=            code to get feed url from db            =
====================================================*/
        // $feed_url_id = $feed_data['FEED_URL_ID'];
        // $rss_feed_url = $feed_data['RSS_FEED_URL'];


/*=====  End of code to get feed url from db  ======*/

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $sort_order = chr(38) .'_sop=10';//10 - newly listed

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }
    $rss_listing_type = $feed_data['LISTING_TYPE'];
    if($rss_listing_type == 'All'){
      $rss_listing_type = '';
    }else{
      $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
    }
    
    $min_price = $feed_data['MIN_PRICE'];
    $max_price = $feed_data['MAX_PRICE'];
    if(!empty($min_price) && !empty($max_price)  ){
      /*==============================================
      =            30% addon in max price            =
      ==============================================*/
      $max_addon = ($max_price  / 100)*30;
      $max_price = $max_price + $max_addon ;
      $max_price = number_format((float)@$max_price,2,'.','');
      
      /*=====  End of 30% addon in max price  ======*/
      $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    }else{
      $price_range = '';
    }
    $within = $feed_data['WITHIN'];
    $zipcode = $feed_data['ZIPCODE'];
    if(!empty($within) && !empty($zipcode)){
      $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    }else{
      $radious = '';
    }
    $seller_filter = $feed_data['SELLER_FILTER'];
    $seller_name = $feed_data['SELLER_NAME'];

    $sell_name = ''; 
    if (strpos($seller_name, ',') !== false) {
      $seller_name = explode(',', $seller_name);
      //var_dump(count($seller_name));
      if(count($seller_name) >2){
        $k = 1;
        foreach ($seller_name as $word) {
          if($k==1){
            $sell_name .= trim($word);
          }else{
            $sell_name .= '%2C'.trim($word);
          }
          
          $k++;
        }
      }else{
           $sell_name = trim($seller_name[0]);
      }
    }else{
      $sell_name = $seller_name;
    }

    if(!empty($seller_filter) && !empty($sell_name)){
      $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
    }else{
      $seller_range = '';
    }
    

    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $price_range;
    $lvar_rss_url4 = $radious;

    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 =$item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/



        $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
        $site_id = $this->db2->query($site_qry)->result_array();
        $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
        if($this_site_id == 2){
          $location = chr(38).'LH_PrefLoc=3';
        }elseif($this_site_id == 1){
          $location = chr(38).'LH_PrefLoc=1';
        }
        $rss_feed_url = $rss_feed_url . $location ;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

        
        $comma = ',';
        $i = 0;
        foreach ($rss as $item)
        {
          $title = $item['title'];
          $title = trim(str_replace("  ", ' ', $title));
          $title = str_replace(array("`,′"), "", $title);
          $title = str_replace(array("'"), "''", $title);
          $item_desc = $item['description'];
          $item_desc = trim(str_replace("  ", ' ', $item_desc));
          $item_desc = str_replace(array("`,′"), "", $item_desc);
          $item_desc = str_replace(array("'"), "''", $item_desc);
          $start_time = $item['pubDate'];
          $start_time = date('Y-m-d H:i:s', strtotime($start_time));
          $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
         // var_dump($start_time);exit;

          $parts = explode('/', $item['guid']);
          $ebay_id = explode('?', $parts[5]);
          $ebay_id = $ebay_id[0];
          $item_url = $item['link'];
          $item_url = trim(str_replace("  ", ' ', $item_url));
          $item_url = str_replace(array("`,′"), "", $item_url);
          $item_url = str_replace(array("'"), "''", $item_url);
          $sale_price = $item['CurrentPrice'][@$i]/100;
          $category_name = $item['Category'][@$i];
          $category_name = trim(str_replace("  ", ' ', $category_name));
          $category_name = str_replace(array("`,′"), "", $category_name);
          $category_name = str_replace(array("'"), "''", $category_name);
          $cat_id = $item['ch_link'][0];
          /*==================================================
          =            to get the mpn_id from url            =
          ==================================================*/
          $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($catalogue_mt_id)){
            $catalogue_mt_id = null;
          }
          /*=====  End of to get the mpn_id from url  ======*/
          
          //$condition_id = substr($cat_id, -4);
          $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($condition_id)){
            $condition_id = null;
          }
          $parts = explode('/', $cat_id);
          $category_id = $parts[5];
          // if(!empty($catalogue_mt_id)){
          //   $flag_id = '30';
          // }else{
          //   $flag_id = '32';
          // }
          
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id");
              
    //Call log insertion query

    $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id")->result_array();

    $max_time = $min_max_query[0]['MAX_TIME'];
    $min_time = $min_max_query[0]['MIN_TIME'];
    $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
    $min_time = new DateTime($min_time);
     
    $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
    $max_time = new DateTime($max_time);
    
    //var_dump($min_time,$max_time);exit;         

    // $dteStart = new DateTime($min_time); 
    // $dteEnd   = new DateTime($max_time); 
    $dteDiff  = $min_time->diff($max_time); 
    $min_time = $min_time->format('Y-m-d\TH:i:s');
    $max_time = $max_time->format('Y-m-d\TH:i:s');
    $execution_time = $dteDiff->format("%d days %H:%I:%S");
    $min_time = str_replace(array("T"), "", $min_time); 
    $max_time = str_replace(array("T"), "", $max_time);
    $time_in_min = $dteDiff->format("%I");
    $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
    //var_dump($min_time,$max_time);exit;
    $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id")->result_array();
    // $total_records = oci_parse($conn, $total_query);
    // oci_execute($total_records,OCI_DEFAULT);
    // $total = oci_fetch_array($total_records, OCI_ASSOC);
    if($time_in_min != 0){
        $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
    }else{
        $per_mint_records = 0;
    }
    $total_records = $total_query[0]['TOTAL_RECORDS'];
    
    // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
    // $avg_records = oci_parse($conn, $per_day_avg_qry);
    // oci_execute($avg_records,OCI_DEFAULT);
    // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
    // //var_dump($avg_records_data['AVERAGE']);exit;
    // $avg_records_data = @$avg_records_data['AVERAGE'];
    // if(empty($avg_records_data)){
    //     $avg_records_data = 'null';
    // }else{
    //     $avg_records_data = @$avg_records_data['AVERAGE'];
    // } 
    
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

    $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
    // $select = oci_parse($conn, $select_query);
    // oci_execute($select,OCI_DEFAULT);
    // $rs = oci_fetch_array($select, OCI_ASSOC);

    $call_log_id = $select_query[0]['CALL_LOG_ID']; 

    $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

    /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND FLAG_ID = $flag_id AND FEED_URL_ID  BETWEEN $min_url_id and $max_url_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
    public function createCategoryStream_chunk(){
    /*==========================================================
    =            creating chunk of 100 rss feed url            =
    ==========================================================*/

    $get_cat_id = $this->db2->query("SELECT DISTINCT CATEGORY_ID FROM LZ_BD_RSS_FEED_URL WHERE FEED_TYPE = 33 AND CATEGORY_ID IS NOT NULL ORDER BY CATEGORY_ID ASC")->result_array();

      foreach ($get_cat_id as $cat_id) {
        $cat_id = $cat_id['CATEGORY_ID'];
        $dir = explode('\\', __DIR__);
        $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
              
          $path = $base_url."/LiveStream/categoryStream/".$cat_id."-Stream.bat";
          //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";
          if(!is_dir(@$path)){
            $fileData = "@ECHO\n".$dir[0]."\ncd ".$base_url."\n :STEP1 \n php index.php cron_job c_cron_job runCategoryStream ".$cat_id.' '." \n IF ERRORLEVEL 1 GOTO :RETRY \n \n :RETRY \n php index.php cron_job c_cron_job runCategoryStream ".$cat_id.' '." \n IF ERRORLEVEL 1 GOTO :STEP1 \n PAUSE";
           // var_dump($fileData,$dir[0]);exit;
            $myfile = fopen($path, "w") ;
            fwrite($myfile, $fileData);
            fclose($myfile);
          }else{
            echo "path not found";
          }
      }
      //var_dump($url_min_id,$url_max_id);exit;

      
      
      //return true;
    

    echo "all feed created";
    //$max_feed_id = $max_feed_id[0]['FEED_ID'];
    
    /*=====  End of creating chunk of 100 rss feed url  ======*/
  }

/*=================================================================================
=            function to run rssfeed of won/purchase item using system            =
=================================================================================*/
  public function runPurchasedItemChunk() {
    $flag = 0;
    $flag_id = '30';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FLAG_ID = $flag_id AND FEED_URL_ID  IN (SELECT DISTINCT U.FEED_URL_ID FROM LZ_MANIFEST_DET@ORASERVER MD, ITEMS_MT@ORASERVER I, LZ_BARCODE_MT@ORASERVER B, LZ_BD_RSS_FEED_URL U, (SELECT D.LZ_ESTIMATE_DET_ID, D.TECH_COND_ID,D.PART_CATLG_MT_ID FROM LZ_BD_PURCHASE_OFFER T, LZ_BD_ESTIMATE_MT    E, LZ_BD_ESTIMATE_DET   D WHERE T.LZ_BD_CATA_ID = E.LZ_BD_CATAG_ID AND T.WIN_STATUS = 1 AND D.LZ_BD_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID) T WHERE MD.EST_DET_ID = T.LZ_ESTIMATE_DET_ID AND MD.LAPTOP_ITEM_CODE = I.ITEM_CODE AND B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND B.CONDITION_ID = T.TECH_COND_ID AND B.EBAY_ITEM_ID IS NULL AND U.CATLALOGUE_MT_ID = T.PART_CATLG_MT_ID AND U.CONDITION_ID = T.TECH_COND_ID)")->result_array(); 
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     $feed_qry = "SELECT FEED_URL_ID, CATEGORY_ID, CONDITION_ID, MIN_PRICE, MAX_PRICE, CATLALOGUE_MT_ID, REPLACE(KEYWORD||EXCLUDE_WORDS, ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS,WITHIN,ZIPCODE,SELLER_FILTER,SELLER_NAME FROM LZ_BD_RSS_FEED_URL WHERE FEED_TYPE = $flag_id AND FEED_URL_ID  IN (SELECT DISTINCT U.FEED_URL_ID FROM LZ_MANIFEST_DET@ORASERVER MD, ITEMS_MT@ORASERVER I, LZ_BARCODE_MT@ORASERVER B, LZ_BD_RSS_FEED_URL U, (SELECT D.LZ_ESTIMATE_DET_ID, D.TECH_COND_ID,D.PART_CATLG_MT_ID FROM LZ_BD_PURCHASE_OFFER T, LZ_BD_ESTIMATE_MT    E, LZ_BD_ESTIMATE_DET   D WHERE T.LZ_BD_CATA_ID = E.LZ_BD_CATAG_ID AND T.WIN_STATUS = 1 AND D.LZ_BD_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID) T WHERE MD.EST_DET_ID = T.LZ_ESTIMATE_DET_ID AND MD.LAPTOP_ITEM_CODE = I.ITEM_CODE AND B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND B.CONDITION_ID = T.TECH_COND_ID AND B.EBAY_ITEM_ID IS NULL AND U.CATLALOGUE_MT_ID = T.PART_CATLG_MT_ID AND U.CONDITION_ID = T.TECH_COND_ID)";
    
    
    /*=====  End of query to create feed url at run time  ======*/
    
    /*=====================================================
    =            query to get feed url from db            =
    =====================================================*/
    
    //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    /*=====  End of query to get feed url from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
/*====================================================
=            code to get feed url from db            =
====================================================*/
        // $feed_url_id = $feed_data['FEED_URL_ID'];
        // $rss_feed_url = $feed_data['RSS_FEED_URL'];


/*=====  End of code to get feed url from db  ======*/

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $sort_order = chr(38) .'_sop=10';//10 - newly listed

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }
    $rss_listing_type = $feed_data['LISTING_TYPE'];
    if($rss_listing_type == 'All'){
      $rss_listing_type = '';
    }else{
      $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
    }
    
    $min_price = $feed_data['MIN_PRICE'];
    $max_price = $feed_data['MAX_PRICE'];
    if(!empty($min_price) && !empty($max_price)  ){
      /*==============================================
      =            30% addon in max price            =
      ==============================================*/
      $max_addon = ($max_price  / 100)*30;
      $max_price = $max_price + $max_addon ;
      $max_price = number_format((float)@$max_price,2,'.','');
      
      /*=====  End of 30% addon in max price  ======*/
      $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    }else{
      $price_range = '';
    }
    $within = $feed_data['WITHIN'];
    $zipcode = $feed_data['ZIPCODE'];
    if(!empty($within) && !empty($zipcode)){
      $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    }else{
      $radious = '';
    }
    $seller_filter = $feed_data['SELLER_FILTER'];
    $seller_name = $feed_data['SELLER_NAME'];

    $sell_name = ''; 
    if (strpos($seller_name, ',') !== false) {
      $seller_name = explode(',', $seller_name);
      //var_dump(count($seller_name));
      if(count($seller_name) >2){
        $k = 1;
        foreach ($seller_name as $word) {
          if($k==1){
            $sell_name .= trim($word);
          }else{
            $sell_name .= '%2C'.trim($word);
          }
          
          $k++;
        }
      }else{
           $sell_name = trim($seller_name[0]);
      }
    }else{
      $sell_name = $seller_name;
    }

    if(!empty($seller_filter) && !empty($sell_name)){
      $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
    }else{
      $seller_range = '';
    }
    

    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $price_range;
    $lvar_rss_url4 = $radious;

    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 =$item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/



        $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
        $site_id = $this->db2->query($site_qry)->result_array();
        $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
        if($this_site_id == 2){
          $location = chr(38).'LH_PrefLoc=3';
        }elseif($this_site_id == 1){
          $location = chr(38).'LH_PrefLoc=1';
        }
        $rss_feed_url = $rss_feed_url . $location ;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(100);
        if(count($rss)>0){

        
        $comma = ',';
        $i = 0;
        foreach ($rss as $item)
        {
          $title = $item['title'];
          $title = trim(str_replace("  ", ' ', $title));
          $title = str_replace(array("`,′"), "", $title);
          $title = str_replace(array("'"), "''", $title);
          $item_desc = $item['description'];
          $item_desc = trim(str_replace("  ", ' ', $item_desc));
          $item_desc = str_replace(array("`,′"), "", $item_desc);
          $item_desc = str_replace(array("'"), "''", $item_desc);
          $start_time = $item['pubDate'];
          $start_time = date('Y-m-d H:i:s', strtotime($start_time));
          $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
         // var_dump($start_time);exit;

          $parts = explode('/', $item['guid']);
          $ebay_id = explode('?', $parts[5]);
          $ebay_id = $ebay_id[0];
          $item_url = $item['link'];
          $item_url = trim(str_replace("  ", ' ', $item_url));
          $item_url = str_replace(array("`,′"), "", $item_url);
          $item_url = str_replace(array("'"), "''", $item_url);
          $sale_price = $item['CurrentPrice'][@$i]/100;
          $category_name = $item['Category'][@$i];
          $category_name = trim(str_replace("  ", ' ', $category_name));
          $category_name = str_replace(array("`,′"), "", $category_name);
          $category_name = str_replace(array("'"), "''", $category_name);
          $cat_id = $item['ch_link'][0];
          /*==================================================
          =            to get the mpn_id from url            =
          ==================================================*/
          $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($catalogue_mt_id)){
            $catalogue_mt_id = null;
          }
          /*=====  End of to get the mpn_id from url  ======*/
          
          //$condition_id = substr($cat_id, -4);
          $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
          if(!is_numeric($condition_id)){
            $condition_id = null;
          }
          $parts = explode('/', $cat_id);
          $category_id = $parts[5];
          // if(!empty($catalogue_mt_id)){
          //   $flag_id = '30';
          // }else{
          //   $flag_id = '32';
          // }
          
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
    //Call log insertion query

    $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

    $max_time = $min_max_query[0]['MAX_TIME'];
    $min_time = $min_max_query[0]['MIN_TIME'];
    $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
    $min_time = new DateTime($min_time);
     
    $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
    $max_time = new DateTime($max_time);
    
    //var_dump($min_time,$max_time);exit;         

    // $dteStart = new DateTime($min_time); 
    // $dteEnd   = new DateTime($max_time); 
    $dteDiff  = $min_time->diff($max_time); 
    $min_time = $min_time->format('Y-m-d\TH:i:s');
    $max_time = $max_time->format('Y-m-d\TH:i:s');
    $execution_time = $dteDiff->format("%d days %H:%I:%S");
    $min_time = str_replace(array("T"), "", $min_time); 
    $max_time = str_replace(array("T"), "", $max_time);
    $time_in_min = $dteDiff->format("%I");
    $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
    $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
    //var_dump($min_time,$max_time);exit;
    $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
    // $total_records = oci_parse($conn, $total_query);
    // oci_execute($total_records,OCI_DEFAULT);
    // $total = oci_fetch_array($total_records, OCI_ASSOC);
    if($time_in_min != 0){
        $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
    }else{
        $per_mint_records = 0;
    }
    $total_records = $total_query[0]['TOTAL_RECORDS'];
    
    // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
    // $avg_records = oci_parse($conn, $per_day_avg_qry);
    // oci_execute($avg_records,OCI_DEFAULT);
    // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
    // //var_dump($avg_records_data['AVERAGE']);exit;
    // $avg_records_data = @$avg_records_data['AVERAGE'];
    // if(empty($avg_records_data)){
    //     $avg_records_data = 'null';
    // }else{
    //     $avg_records_data = @$avg_records_data['AVERAGE'];
    // } 
    
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

    $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
    // $select = oci_parse($conn, $select_query);
    // oci_execute($select,OCI_DEFAULT);
    // $rs = oci_fetch_array($select, OCI_ASSOC);

    $call_log_id = $select_query[0]['CALL_LOG_ID']; 

    $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

    /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }


/*=====  End of function to run rssfeed of won/purchase item using system  ======*/
public function getSoldActiveSummary()
  {
    /*=======================================================
    =            get last downloaded price index            =
    =======================================================*/
    $get_last_index = $this->db2->query("SELECT API_AVG_PRICE_ID,FEED_URL_ID, AVG_PRICE_ACTIVE  FROM (SELECT * FROM LZ_BD_API_AVG_PRICE P ORDER BY P.API_AVG_PRICE_ID DESC) WHERE ROWNUM = 1")->result_array();
    if(count($get_last_index) > 0){
        $avg_price = $get_last_index[0]['AVG_PRICE_ACTIVE'];
        $feed_url_id = $get_last_index[0]['FEED_URL_ID'];

        $max_feed_url_id = $this->db2->query("SELECT MAX(U.FEED_URL_ID) FEED_URL_ID FROM LZ_BD_RSS_FEED_URL U WHERE (U.CONDITION_ID <> 0 OR U.CONDITION_ID <> NULL) AND TRIM(U.KEYWORD) IS NOT NULL AND U.CATLALOGUE_MT_ID IS NOT NULL AND U.VERIFY_DATE IS NOT NULL")->result_array(); //echo $cat_qry; exit;
        $max_id = $max_feed_url_id[0]['FEED_URL_ID'];

/*=============================================================================
=     if current feed_url_id = max feed_url_id restart loop condition            =
=============================================================================*/
        if($feed_url_id == $max_id){
            $restart_loop = true;
        }else{
            $restart_loop = false;
        }
/*==  End of if current feed_url_id = max feed_url_id restart loop condition  ==*/

        if($restart_loop == false){
          if(!empty($avg_price)){
            $WHERE = ' AND U.FEED_URL_ID > '.$feed_url_id;
          }else{
            $api_avg_price_id = $get_last_index[0]['API_AVG_PRICE_ID'];

            $this->db2->query("DELETE FROM LZ_BD_API_AVG_PRICE P WHERE P.API_AVG_PRICE_ID = $api_avg_price_id");//UNCOMPLETE DATA SO DELETE IT
            $WHERE = ' AND U.FEED_URL_ID >= '.$feed_url_id;
          }
          
        }else{
          $WHERE = ' ';
        }
        
    }else{//count($get_last_index) if else
       $WHERE = ' ';
    }
    
    /*=====  End of get last downloaded price index  ======*/

    $get_kw = $this->db2->query("SELECT U.FEED_URL_ID, REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)),'#|&','') KEYWORD, U.CATLALOGUE_MT_ID, U.CONDITION_ID, U.CATEGORY_ID, REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)),'#|&','') EXCLUDE_WORDS FROM LZ_BD_RSS_FEED_URL U WHERE (U.CONDITION_ID <> 0 OR U.CONDITION_ID <> NULL) AND TRIM(U.KEYWORD) IS NOT NULL AND U.CATLALOGUE_MT_ID IS NOT NULL AND U.VERIFY_DATE IS NOT NULL $WHERE ORDER BY U.FEED_URL_ID ASC"); 
    $data =  $get_kw->result_array();
    return $data;
  }
  public function getSoldActiveSummaryAll()
  {
    /*=======================================================
    =            get last downloaded price index            =
    =======================================================*/
    $get_last_index = $this->db2->query("SELECT API_AVG_PRICE_ID,FEED_URL_ID, AVG_PRICE_ACTIVE  FROM (SELECT * FROM LZ_BD_API_AVG_PRICE P ORDER BY P.API_AVG_PRICE_ID DESC) WHERE ROWNUM = 1")->result_array();
    if(count($get_last_index) > 0){
        $avg_price = $get_last_index[0]['AVG_PRICE_ACTIVE'];
        $feed_url_id = $get_last_index[0]['FEED_URL_ID'];

        $max_feed_url_id = $this->db2->query("SELECT MAX(U.FEED_URL_ID) FEED_URL_ID FROM LZ_BD_RSS_FEED_URL U WHERE (U.CONDITION_ID <> 0 OR U.CONDITION_ID <> NULL) AND TRIM(U.KEYWORD) IS NOT NULL AND U.CATLALOGUE_MT_ID IS NOT NULL")->result_array(); //echo $cat_qry; exit;
        $max_id = $max_feed_url_id[0]['FEED_URL_ID'];

/*=============================================================================
=     if current feed_url_id = max feed_url_id restart loop condition            =
=============================================================================*/
        if($feed_url_id == $max_id){
            $restart_loop = true;
        }else{
            $restart_loop = false;
        }
/*==  End of if current feed_url_id = max feed_url_id restart loop condition  ==*/

        if($restart_loop == false){
          if(!empty($avg_price)){
            $WHERE = ' AND U.FEED_URL_ID > '.$feed_url_id;
          }else{
            $api_avg_price_id = $get_last_index[0]['API_AVG_PRICE_ID'];

            $this->db2->query("DELETE FROM LZ_BD_API_AVG_PRICE P WHERE P.API_AVG_PRICE_ID = $api_avg_price_id");//UNCOMPLETE DATA SO DELETE IT
            $WHERE = ' AND U.FEED_URL_ID >= '.$feed_url_id;
          }
          
        }else{
          $WHERE = ' ';
        }
        
    }else{//count($get_last_index) if else
       $WHERE = ' ';
    }
    
    /*=====  End of get last downloaded price index  ======*/

    $get_kw = $this->db2->query("SELECT U.FEED_URL_ID, REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)),'#|&','') KEYWORD, U.CATLALOGUE_MT_ID, U.CONDITION_ID, U.CATEGORY_ID, REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)),'#|&','') EXCLUDE_WORDS FROM LZ_BD_RSS_FEED_URL U WHERE (U.CONDITION_ID <> 0 OR U.CONDITION_ID <> NULL) AND TRIM(U.KEYWORD) IS NOT NULL AND U.CATLALOGUE_MT_ID IS NOT NULL $WHERE ORDER BY U.FEED_URL_ID ASC"); 
    $data =  $get_kw->result_array();
    return $data;
  }
    public function runAutoBuyStream() {
    $flag = 0;
    $flag_id = '41';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FLAG_ID = $flag_id")->result_array(); 
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     // $feed_qry = "SELECT U.FEED_URL_ID,CATEGORY_ID,U.CONDITION_ID, MIN_PRICE, A.AVG_PRICE_SOLD MAX_PRICE, CATLALOGUE_MT_ID, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS, WITHIN, ZIPCODE, SELLER_FILTER, SELLER_NAME FROM LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE A, LZ_BD_RSS_FEED_VERIFIED V, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP WHERE VERIFY_DATE IS NOT NULL AND U.CATLALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND U.CONDITION_ID = A.CONDITION_ID(+) AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.FEED_URL_ID = V.FEED_URL_ID ORDER BY U.FEED_URL_ID ASC"; 
     $feed_qry = "SELECT U.FEED_URL_ID, CATEGORY_ID, U.CONDITION_ID, MIN_PRICE, A.AVG_PRICE_SOLD MAX_PRICE, CATLALOGUE_MT_ID, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS, WITHIN, ZIPCODE, SELLER_FILTER, SELLER_NAME FROM LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE A, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP WHERE VERIFY_DATE IS NOT NULL AND U.CATLALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND U.CONDITION_ID = A.CONDITION_ID(+) AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND A.AVG_PRICE_SOLD > 0 ORDER BY U.FEED_URL_ID ASC ";

    /*=====  End of query to create feed url at run time  ======*/
    
    /*=====================================================
    =            query to get feed url from db            =
    =====================================================*/
    
    //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    /*=====  End of query to get feed url from db  ======*/
    
    /*===================================================
    =            get script location from db            =
    ===================================================*/
    $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
    $site_id = $this->db2->query($site_qry)->result_array();
    $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
    if($this_site_id == 2){
      $location = chr(38).'LH_PrefLoc=3';
    }elseif($this_site_id == 1){
      $location = chr(38).'LH_PrefLoc=1';
    }
    
    /*=====  End of get script location from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
/*====================================================
=            code to get feed url from db            =
====================================================*/
        // $feed_url_id = $feed_data['FEED_URL_ID'];
        // $rss_feed_url = $feed_data['RSS_FEED_URL'];


/*=====  End of code to get feed url from db  ======*/

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];//exact word search so quote added
    // var_dump('"'.$keyWord.'"');exit;
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $sort_order = chr(38) .'_sop=10';//10 - newly listed

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }
    $rss_listing_type = $feed_data['LISTING_TYPE'];
    if($rss_listing_type == 'All'){
      $rss_listing_type = '';
    }else{
      $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
    }
    /*=================================================================================
    =            item filter commented on demand of Kazmi 30-May-18            =
    =================================================================================*/
    $min_price = $feed_data['MIN_PRICE'];
    $max_price = $feed_data['MAX_PRICE'];
    if(!empty($min_price) && !empty($max_price)  ){
      /*==============================================
      =            30% less in max price            =
      ==============================================*/
      if($rss_feed_cond == 1000){
        $margin = ($max_price  / 100)*20;
        $max_price = $max_price - $margin ;
        $max_price = number_format((float)@$max_price,2,'.','');
        $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
      }else{
        $margin = ($max_price  / 100)*40;
        $max_price = $max_price - $margin ;
        $max_price = number_format((float)@$max_price,2,'.','');
        $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
      }
      
      /*=====  End of 30% less in max price  ======*/
      
    }else{
      $price_range = '';
    }

    // $within = $feed_data['WITHIN'];
    // $zipcode = $feed_data['ZIPCODE'];
    // if(!empty($within) && !empty($zipcode)){
    //   $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    // }else{
    //   $radious = '';
    // }
    // $seller_filter = $feed_data['SELLER_FILTER'];
    // $seller_name = $feed_data['SELLER_NAME'];

    // $sell_name = ''; 
    // if (strpos($seller_name, ',') !== false) {
    //   $seller_name = explode(',', $seller_name);
    //   //var_dump(count($seller_name));
    //   if(count($seller_name) >2){
    //     $k = 1;
    //     foreach ($seller_name as $word) {
    //       if($k==1){
    //         $sell_name .= trim($word);
    //       }else{
    //         $sell_name .= '%2C'.trim($word);
    //       }
          
    //       $k++;
    //     }
    //   }else{
    //        $sell_name = trim($seller_name[0]);
    //   }
    // }else{
    //   $sell_name = $seller_name;
    // }

    // if(!empty($seller_filter) && !empty($sell_name)){
    //   $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
    // }else{
    //   $seller_range = '';
    // }

    //$price_range = '';
    $radious = '';
    $seller_range = '';
    /*=====  End of item filter commented on demand of Kazmi 30-May-18  ======*/
    
    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $price_range;
    $lvar_rss_url4 = $radious;
    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 = $item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/

        $rss_feed_url = $rss_feed_url . $location ;
        $dir = explode('\\', __DIR__);
        $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
        $path = $base_url."/assets/webscrap/simple_html_dom.php";

       //include_once "D:\wamp64\www\laptopzone\assets\webscrap\simple_html_dom.php"; 
       include_once $path; 
        //echo $feed_url_id .PHP_EOL;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

          $comma = ',';
          $i = 0;
          foreach ($rss as $item)
          {
            $title = $item['title'];
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $item_desc = $item['description'];
            $item_desc = trim(str_replace("  ", ' ', $item_desc));
            $item_desc = str_replace(array("`,′"), "", $item_desc);
            $item_desc = str_replace(array("'"), "''", $item_desc);
            $start_time = $item['pubDate'];
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
           // var_dump($start_time);exit;

            $parts = explode('/', $item['guid']);
            $ebay_id = explode('?', $parts[5]);
            $ebay_id = $ebay_id[0];
            $item_url = $item['link'];
            $item_url = trim(str_replace("  ", ' ', $item_url));
            $item_url = str_replace(array("`,′"), "", $item_url);
            $item_url = str_replace(array("'"), "''", $item_url);

            // create HTML DOM
            $html = file_get_html($item_url);

            // get title
            $ship_cost_span = @$html->getElementById('fshippingCost')->innertext;
            $ship_cost = (float) filter_var( $ship_cost_span, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );// float(55.35) 

            $sale_price = $item['CurrentPrice'][@$i]/100;
            $category_name = $item['Category'][@$i];
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = str_replace(array("`,′"), "", $category_name);
            $category_name = str_replace(array("'"), "''", $category_name);
            $cat_id = $item['ch_link'][0];
            /*==================================================
            =            to get the mpn_id from url            =
            ==================================================*/
            $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($catalogue_mt_id)){
              $catalogue_mt_id = null;
            }
            /*=====  End of to get the mpn_id from url  ======*/
            
            //$condition_id = substr($cat_id, -4);
            $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($condition_id)){
              $condition_id = null;
            }
            $parts = explode('/', $cat_id);
            $category_id = $parts[5];
            // if(!empty($catalogue_mt_id)){
            //   $flag_id = '30';
            // }else{
            //   $flag_id = '32';
            // }
            
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID,SHIP_COST) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id $comma $ship_cost)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              //Call log insertion query

              $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

              $max_time = $min_max_query[0]['MAX_TIME'];
              $min_time = $min_max_query[0]['MIN_TIME'];
              $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
              $min_time = new DateTime($min_time);
               
              $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
              $max_time = new DateTime($max_time);
              
              //var_dump($min_time,$max_time);exit;         

              // $dteStart = new DateTime($min_time); 
              // $dteEnd   = new DateTime($max_time); 
              $dteDiff  = $min_time->diff($max_time); 
              $min_time = $min_time->format('Y-m-d\TH:i:s');
              $max_time = $max_time->format('Y-m-d\TH:i:s');
              $execution_time = $dteDiff->format("%d days %H:%I:%S");
              $min_time = str_replace(array("T"), "", $min_time); 
              $max_time = str_replace(array("T"), "", $max_time);
              $time_in_min = $dteDiff->format("%I");
              $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
              $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
              //var_dump($min_time,$max_time);exit;
              $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
              // $total_records = oci_parse($conn, $total_query);
              // oci_execute($total_records,OCI_DEFAULT);
              // $total = oci_fetch_array($total_records, OCI_ASSOC);
              if($time_in_min != 0){
                  $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
              }else{
                  $per_mint_records = 0;
              }
              $total_records = $total_query[0]['TOTAL_RECORDS'];
              
              // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
              // $avg_records = oci_parse($conn, $per_day_avg_qry);
              // oci_execute($avg_records,OCI_DEFAULT);
              // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
              // //var_dump($avg_records_data['AVERAGE']);exit;
              // $avg_records_data = @$avg_records_data['AVERAGE'];
              // if(empty($avg_records_data)){
              //     $avg_records_data = 'null';
              // }else{
              //     $avg_records_data = @$avg_records_data['AVERAGE'];
              // } 
              
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

              $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
              // $select = oci_parse($conn, $select_query);
              // oci_execute($select,OCI_DEFAULT);
              // $rs = oci_fetch_array($select, OCI_ASSOC);

              $call_log_id = $select_query[0]['CALL_LOG_ID']; 

              $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

              /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else

              /*=====  End of check if already exist  ======*/

            $i++;
          }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
    
      }//end rss_feed_url foreach
    }//main num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
  public function runAutoBINStream() {
    $flag = 0;
    $flag_id = '43';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;


    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FLAG_ID = $flag_id AND FEED_URL_ID IN (3540, 3562, 3660, 4211, 4405, 6824,4888, 3595, 3744, 3606, 3700,6059, 4609, 9986, 3614)")->result_array(); 
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     $feed_qry = "SELECT U.FEED_URL_ID, CATEGORY_ID, U.CONDITION_ID, MIN_PRICE, A.AVG_PRICE_SOLD MAX_PRICE, CATLALOGUE_MT_ID, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS, WITHIN, ZIPCODE, SELLER_FILTER, SELLER_NAME FROM LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE A, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP WHERE VERIFY_DATE IS NOT NULL AND U.CATLALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND U.CONDITION_ID = A.CONDITION_ID(+) AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.FEED_URL_ID in (3540, 3562, 3660, 4211, 4405, 6824,4888, 3595, 3744, 3606, 3700,6059, 4609, 9986, 3614) ORDER BY U.FEED_URL_ID ASC ";
    
    
    /*=====  End of query to create feed url at run time  ======*/
    
    /*=====================================================
    =            query to get feed url from db            =
    =====================================================*/
    
    //$feed_qry = "SELECT FEED_URL_ID,RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID  BETWEEN $min_url_id and $max_url_id";
    
    /*=====  End of query to get feed url from db  ======*/
    
    /*===================================================
    =            get script location from db            =
    ===================================================*/
    $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
    $site_id = $this->db2->query($site_qry)->result_array();
    $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
    if($this_site_id == 2){
      $location = chr(38).'LH_PrefLoc=3';
    }elseif($this_site_id == 1){
      $location = chr(38).'LH_PrefLoc=1';
    }
    
    /*=====  End of get script location from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
/*====================================================
=            code to get feed url from db            =
====================================================*/
        // $feed_url_id = $feed_data['FEED_URL_ID'];
        // $rss_feed_url = $feed_data['RSS_FEED_URL'];


/*=====  End of code to get feed url from db  ======*/

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];//exact word search so quote added
    // var_dump('"'.$keyWord.'"');exit;
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $sort_order = chr(38) .'_sop=10';//10 - newly listed

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }
    $rss_listing_type = $feed_data['LISTING_TYPE'];
    if($rss_listing_type == 'All'){
      $rss_listing_type = '';
    }else{
      $rss_listing_type = chr(38) . 'LH_'.$rss_listing_type.'=1';
    }
    /*=================================================================================
    =            item filter commented on demand of Kazmi 30-May-18            =
    =================================================================================*/
    $min_price = $feed_data['MIN_PRICE'];
    $max_price = $feed_data['MAX_PRICE'];
    if(!empty($min_price) && !empty($max_price)  ){
      /*==============================================
      =            30% less in max price            =
      ==============================================*/
      if($rss_feed_cond == 1000){
        $margin = ($max_price  / 100)*20;
        $max_price = $max_price - $margin ;
        $max_price = number_format((float)@$max_price,2,'.','');
        $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
      }else{
        $margin = ($max_price  / 100)*40;
        $max_price = $max_price - $margin ;
        $max_price = number_format((float)@$max_price,2,'.','');
        $price_range = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
      }
      
      /*=====  End of 30% less in max price  ======*/
      
    }else{
      $price_range = '';
    }

    // $within = $feed_data['WITHIN'];
    // $zipcode = $feed_data['ZIPCODE'];
    // if(!empty($within) && !empty($zipcode)){
    //   $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    // }else{
    //   $radious = '';
    // }
    // $seller_filter = $feed_data['SELLER_FILTER'];
    // $seller_name = $feed_data['SELLER_NAME'];

    // $sell_name = ''; 
    // if (strpos($seller_name, ',') !== false) {
    //   $seller_name = explode(',', $seller_name);
    //   //var_dump(count($seller_name));
    //   if(count($seller_name) >2){
    //     $k = 1;
    //     foreach ($seller_name as $word) {
    //       if($k==1){
    //         $sell_name .= trim($word);
    //       }else{
    //         $sell_name .= '%2C'.trim($word);
    //       }
          
    //       $k++;
    //     }
    //   }else{
    //        $sell_name = trim($seller_name[0]);
    //   }
    // }else{
    //   $sell_name = $seller_name;
    // }

    // if(!empty($seller_filter) && !empty($sell_name)){
    //   $seller_range = chr(38) . '_fss=1' . chr(38) .'LH_SpecificSeller=1' . chr(38) . '_sofindtype=0' . chr(38) .'_saslop='.$seller_filter. chr(38) .'_sasl='.$sell_name;
    // }else{
    //   $seller_range = '';
    // }

    //$price_range = '';
    $radious = '';
    $seller_range = '';
    /*=====  End of item filter commented on demand of Kazmi 30-May-18  ======*/
    
    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $price_range;
    $lvar_rss_url4 = $radious;
    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 = $item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/

        $rss_feed_url = $rss_feed_url . $location ;
       $dir = explode('\\', __DIR__);
        $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
        $path = $base_url."/assets/webscrap/simple_html_dom.php";

       //include_once "D:\wamp64\www\laptopzone\assets\webscrap\simple_html_dom.php"; 
       include_once $path;  
        //echo $feed_url_id .PHP_EOL;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

          $comma = ',';
          $i = 0;
          foreach ($rss as $item)
          {
            $title = $item['title'];
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $item_desc = $item['description'];
            $item_desc = trim(str_replace("  ", ' ', $item_desc));
            $item_desc = str_replace(array("`,′"), "", $item_desc);
            $item_desc = str_replace(array("'"), "''", $item_desc);
            $start_time = $item['pubDate'];
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
           // var_dump($start_time);exit;

            $parts = explode('/', $item['guid']);
            $ebay_id = explode('?', $parts[5]);
            $ebay_id = $ebay_id[0];
            $item_url = $item['link'];
            $item_url = trim(str_replace("  ", ' ', $item_url));
            $item_url = str_replace(array("`,′"), "", $item_url);
            $item_url = str_replace(array("'"), "''", $item_url);

            // create HTML DOM
            $html = file_get_html($item_url);

            // get title
            $ship_cost_span = @$html->getElementById('fshippingCost')->innertext;
            $ship_cost = (float) filter_var( $ship_cost_span, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );// float(55.35) 

            $sale_price = $item['CurrentPrice'][@$i]/100;
            $category_name = $item['Category'][@$i];
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = str_replace(array("`,′"), "", $category_name);
            $category_name = str_replace(array("'"), "''", $category_name);
            $cat_id = $item['ch_link'][0];
            /*==================================================
            =            to get the mpn_id from url            =
            ==================================================*/
            $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($catalogue_mt_id)){
              $catalogue_mt_id = null;
            }
            /*=====  End of to get the mpn_id from url  ======*/
            
            //$condition_id = substr($cat_id, -4);
            $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($condition_id)){
              $condition_id = null;
            }
            $parts = explode('/', $cat_id);
            $category_id = $parts[5];
            // if(!empty($catalogue_mt_id)){
            //   $flag_id = '30';
            // }else{
            //   $flag_id = '32';
            // }
            
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID,SHIP_COST) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id $comma $ship_cost)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              //Call log insertion query

              $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

              $max_time = $min_max_query[0]['MAX_TIME'];
              $min_time = $min_max_query[0]['MIN_TIME'];
              $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
              $min_time = new DateTime($min_time);
               
              $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
              $max_time = new DateTime($max_time);
              
              //var_dump($min_time,$max_time);exit;         

              // $dteStart = new DateTime($min_time); 
              // $dteEnd   = new DateTime($max_time); 
              $dteDiff  = $min_time->diff($max_time); 
              $min_time = $min_time->format('Y-m-d\TH:i:s');
              $max_time = $max_time->format('Y-m-d\TH:i:s');
              $execution_time = $dteDiff->format("%d days %H:%I:%S");
              $min_time = str_replace(array("T"), "", $min_time); 
              $max_time = str_replace(array("T"), "", $max_time);
              $time_in_min = $dteDiff->format("%I");
              $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
              $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
              //var_dump($min_time,$max_time);exit;
              $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
              // $total_records = oci_parse($conn, $total_query);
              // oci_execute($total_records,OCI_DEFAULT);
              // $total = oci_fetch_array($total_records, OCI_ASSOC);
              if($time_in_min != 0){
                  $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
              }else{
                  $per_mint_records = 0;
              }
              $total_records = $total_query[0]['TOTAL_RECORDS'];
              
              // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
              // $avg_records = oci_parse($conn, $per_day_avg_qry);
              // oci_execute($avg_records,OCI_DEFAULT);
              // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
              // //var_dump($avg_records_data['AVERAGE']);exit;
              // $avg_records_data = @$avg_records_data['AVERAGE'];
              // if(empty($avg_records_data)){
              //     $avg_records_data = 'null';
              // }else{
              //     $avg_records_data = @$avg_records_data['AVERAGE'];
              // } 
              
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

              $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
              // $select = oci_parse($conn, $select_query);
              // oci_execute($select,OCI_DEFAULT);
              // $rs = oci_fetch_array($select, OCI_ASSOC);

              $call_log_id = $select_query[0]['CALL_LOG_ID']; 

              $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

              /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else

              /*=====  End of check if already exist  ======*/

            $i++;
          }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
    
      }//end rss_feed_url foreach
    }//main num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
  public function runAutoBuyAuctionStream() {
    $flag = 0;
    $flag_id = '42';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FLAG_ID = $flag_id ")->result_array(); 
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to create feed url at run time            =
    ============================================================*/
     //$feed_qry = "SELECT U.FEED_URL_ID,CATEGORY_ID,U.CONDITION_ID, MIN_PRICE, A.AVG_PRICE_SOLD MAX_PRICE, CATLALOGUE_MT_ID, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS, WITHIN, ZIPCODE, SELLER_FILTER, SELLER_NAME FROM LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE A, LZ_BD_RSS_FEED_VERIFIED V, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP WHERE VERIFY_DATE IS NOT NULL AND U.CATLALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND U.CONDITION_ID = A.CONDITION_ID(+) AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.FEED_URL_ID = V.FEED_URL_ID ORDER BY U.FEED_URL_ID ASC";
     $feed_qry = "SELECT U.FEED_URL_ID, CATEGORY_ID, U.CONDITION_ID, MIN_PRICE, A.AVG_PRICE_SOLD MAX_PRICE, CATLALOGUE_MT_ID, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') KEYWORD, LISTING_TYPE, EXCLUDE_WORDS, WITHIN, ZIPCODE, SELLER_FILTER, SELLER_NAME FROM LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE A, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP WHERE VERIFY_DATE IS NOT NULL AND U.CATLALOGUE_MT_ID = A.CATALOGUE_MT_ID(+) AND U.CONDITION_ID = A.CONDITION_ID(+) AND A.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND A.AVG_PRICE_SOLD > 0 ORDER BY U.FEED_URL_ID ASC";
    
    
    /*=====  End of query to create feed url at run time  ======*/
    
    
    /*===================================================
    =            get script location from db            =
    ===================================================*/
    $site_qry = "SELECT WIZ_ALL_SITES_ID FROM WIZ_THIS_SITE_MT";
    $site_id = $this->db2->query($site_qry)->result_array();
    $this_site_id = $site_id[0]['WIZ_ALL_SITES_ID'];
    if($this_site_id == 2){
      $location = chr(38).'LH_PrefLoc=3';
    }elseif($this_site_id == 1){
      $location = chr(38).'LH_PrefLoc=1';
    }
    
    /*=====  End of get script location from db  ======*/
    
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = $feed_data['FEED_URL_ID'];
    $keyWord = $feed_data['KEYWORD'];//exact word search so quote added
    // var_dump('"'.$keyWord.'"');exit;
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    $keyWord = $keyWord . chr(38) . '_in_kw=4';// 4 - Exact words, any order
    $sort_order = chr(38) .'_sop=16';//16 - Price + Shipping: highest first

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = $feed_data['CATLALOGUE_MT_ID'];
    if(!empty($catalogue_mt_id)){
      $mpn = chr(38) . '_mpn=' . $catalogue_mt_id;
    }else{
      $mpn = '';
    }
    $rss_feed_cond = $feed_data['CONDITION_ID'];
    if($rss_feed_cond != 0){
      $item_condition = chr(38) . 'LH_ItemCondition=' . $rss_feed_cond;
    }else{
      $item_condition = '';
    }

    $rss_listing_type = chr(38) .'LH_Auction=1';
    $price_range = '';
    $radious = '';
    $seller_range = '';

    /*=====  End of item filter commented on demand of Kazmi 30-May-18  ======*/
    /*====================================================
    =            item filter for auction item            =
    ====================================================*/
    
    $time_range = chr(38) .'LH_Time=1'.chr(38) .'_ftrt=902'.chr(38) .'_ftrv=24';//Listings ending in more than 24 hours
    $bid_count = chr(38) .'LH_NOB=1'.chr(38) .'_sabdlo=1';// Number of Bids is greater than 1
    $include_description = chr(38) .'LH_TitleDesc=1';//Include description filter
    
    /*=====  End of item filter for auction item  ======*/
    


    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $time_range.$bid_count.$include_description;
    $lvar_rss_url4 = $radious;
    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 = $item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/

        $rss_feed_url = $rss_feed_url . $location ;
       $dir = explode('\\', __DIR__);
        $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
        $path = $base_url."/assets/webscrap/simple_html_dom.php";

       //include_once "D:\wamp64\www\laptopzone\assets\webscrap\simple_html_dom.php"; 
       include_once $path; 
        //echo $feed_url_id .PHP_EOL;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

          $comma = ',';
          $i = 0;
          foreach ($rss as $item)
          {
            $title = $item['title'];
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $item_desc = $item['description'];
            $item_desc = trim(str_replace("  ", ' ', $item_desc));
            $item_desc = str_replace(array("`,′"), "", $item_desc);
            $item_desc = str_replace(array("'"), "''", $item_desc);

            preg_match('#\((.*?)\)#', $item_desc, $match);
            preg_match('/\d+/', $match[1], $match);
            $nob = $match[0];
            $start_time = $item['pubDate'];
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
           // var_dump($start_time);exit;

            $parts = explode('/', $item['guid']);
            $ebay_id = explode('?', $parts[5]);
            $ebay_id = $ebay_id[0];
            $item_url = $item['link'];
            $item_url = trim(str_replace("  ", ' ', $item_url));
            $item_url = str_replace(array("`,′"), "", $item_url);
            $item_url = str_replace(array("'"), "''", $item_url);

            // create HTML DOM
            $html = file_get_html($item_url);

            // get title
            $ship_cost_span = @$html->getElementById('fshippingCost')->innertext;
            $ship_cost = (float) filter_var( $ship_cost_span, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );// float(55.35) 

            $sale_price = $item['CurrentPrice'][@$i]/100;
            $category_name = $item['Category'][@$i];
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = str_replace(array("`,′"), "", $category_name);
            $category_name = str_replace(array("'"), "''", $category_name);
            $cat_id = $item['ch_link'][0];
            /*==================================================
            =            to get the mpn_id from url            =
            ==================================================*/
            $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($catalogue_mt_id)){
              $catalogue_mt_id = null;
            }
            /*=====  End of to get the mpn_id from url  ======*/
            
            //$condition_id = substr($cat_id, -4);
            $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($condition_id)){
              $condition_id = null;
            }
            $parts = explode('/', $cat_id);
            $category_id = $parts[5];
            // if(!empty($catalogue_mt_id)){
            //   $flag_id = '30';
            // }else{
            //   $flag_id = '32';
            // }
            
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID,SHIP_COST,NOB) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma $feed_url_id $comma $ship_cost $comma '$nob')");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              //Call log insertion query

              $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

              $max_time = $min_max_query[0]['MAX_TIME'];
              $min_time = $min_max_query[0]['MIN_TIME'];
              $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
              $min_time = new DateTime($min_time);
               
              $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
              $max_time = new DateTime($max_time);
              
              //var_dump($min_time,$max_time);exit;         

              // $dteStart = new DateTime($min_time); 
              // $dteEnd   = new DateTime($max_time); 
              $dteDiff  = $min_time->diff($max_time); 
              $min_time = $min_time->format('Y-m-d\TH:i:s');
              $max_time = $max_time->format('Y-m-d\TH:i:s');
              $execution_time = $dteDiff->format("%d days %H:%I:%S");
              $min_time = str_replace(array("T"), "", $min_time); 
              $max_time = str_replace(array("T"), "", $max_time);
              $time_in_min = $dteDiff->format("%I");
              $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
              $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
              //var_dump($min_time,$max_time);exit;
              $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
              // $total_records = oci_parse($conn, $total_query);
              // oci_execute($total_records,OCI_DEFAULT);
              // $total = oci_fetch_array($total_records, OCI_ASSOC);
              if($time_in_min != 0){
                  $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
              }else{
                  $per_mint_records = 0;
              }
              $total_records = $total_query[0]['TOTAL_RECORDS'];
              
              // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
              // $avg_records = oci_parse($conn, $per_day_avg_qry);
              // oci_execute($avg_records,OCI_DEFAULT);
              // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
              // //var_dump($avg_records_data['AVERAGE']);exit;
              // $avg_records_data = @$avg_records_data['AVERAGE'];
              // if(empty($avg_records_data)){
              //     $avg_records_data = 'null';
              // }else{
              //     $avg_records_data = @$avg_records_data['AVERAGE'];
              // } 
              
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

              $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
              // $select = oci_parse($conn, $select_query);
              // oci_execute($select,OCI_DEFAULT);
              // $rs = oci_fetch_array($select, OCI_ASSOC);

              $call_log_id = $select_query[0]['CALL_LOG_ID']; 

              $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

              /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else

              /*=====  End of check if already exist  ======*/

            $i++;
          }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
    
      }//end rss_feed_url foreach
    }//main num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }  
  public function runCatAuctionStream() {
    $flag = 0;
    $flag_id = '44';
    // $cat_id = $this->input->post("")
    // $category_id = $cat_id;
    $max_feed_id = $this->db2->query("SELECT MAX(FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED WHERE FLAG_ID = $flag_id")->result_array(); 
    $max_feed_id = $max_feed_id[0]['FEED_ID'];
    /*============================================================
    =            query to get parent cat            =
    ============================================================*/
     $feed_qry = "SELECT T.CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID IS NULL ORDER BY T.CATEGORY_ID ASC";
    
    /*=====  End of query to get parent cat  ======*/

    $location = chr(38).'LH_PrefLoc=99';//within location id
    
    $get_rss_url = $this->db2->query($feed_qry);
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {

/*===========================================================
=            code to create feed URL at run time            =
===========================================================*/
    $feed_url_id = '';
    $keyWord = '';//exact word search so quote added
    // var_dump('"'.$keyWord.'"');exit;
    //$exclude_words = $feed_data['EXCLUDE_WORDS'];
    $keyWord = chr(38) . '_nkw=' . $keyWord;
    //$keyWord = $keyWord . chr(38) . '_in_kw=4';// 4 - Exact words, any order
    $sort_order = chr(38) .'_sop=16';//16 - Price + Shipping: highest first

    $category_id = $feed_data['CATEGORY_ID'];
    $catalogue_mt_id = '';
    $mpn = '';
    $item_condition = '';
    $rss_listing_type = chr(38) .'LH_Auction=1';
    $price_range = '';
    $within = 150;
    $zipcode = 75229;
    $radious = chr(38) . '_sadis=' . $within . chr(38) . '_fspt=1' . chr(38) . '_stpos=' . $zipcode;
    $seller_range = '';

    /*=====  End of item filter commented on demand of Kazmi 30-May-18  ======*/
    /*====================================================
    =            item filter for auction item            =
    ====================================================*/
    
    $time_range = chr(38) .'LH_Time=1'.chr(38) .'_ftrt=902'.chr(38) .'_ftrv=24';//Listings ending in more than 24 hours
    $bid_count = chr(38) .'LH_NOB=1'.chr(38) .'_sabdlo=1';// Number of Bids is greater than 1
    $include_description = chr(38) .'LH_TitleDesc=1';//Include description filter
    
    /*=====  End of item filter for auction item  ======*/
    $time_range = '';
    $bid_count = '';
    $include_description = '';

    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . $keyWord . $sort_order . chr(38) . 'rt=nc' . $rss_listing_type; 
    $lvar_rss_url3 = $time_range.$bid_count.$include_description;
    $lvar_rss_url4 = $radious;
    $lvar_rss_url5 = $seller_range;
    $lvar_rss_url6 = $item_condition . chr(38) .'_rss=1'.$mpn;
    $rss_feed_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4.$lvar_rss_url5.$lvar_rss_url6;

//var_dump( $rss_feed_url);exit;
/*=====  End of code to create feed URL at run time  ======*/

        $rss_feed_url = $rss_feed_url . $location ;
       $dir = explode('\\', __DIR__);
        $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
        $path = $base_url."/assets/webscrap/simple_html_dom.php";

       //include_once "D:\wamp64\www\laptopzone\assets\webscrap\simple_html_dom.php"; 
       include_once $path; 
        //echo $feed_url_id .PHP_EOL;
        $rss = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
        if(count($rss)>0){

          $comma = ',';
          $i = 0;
          foreach ($rss as $item)
          {
            $title = $item['title'];
            $title = trim(str_replace("  ", ' ', $title));
            $title = str_replace(array("`,′"), "", $title);
            $title = str_replace(array("'"), "''", $title);
            $item_desc = $item['description'];
            $item_desc = trim(str_replace("  ", ' ', $item_desc));
            $item_desc = str_replace(array("`,′"), "", $item_desc);
            $item_desc = str_replace(array("'"), "''", $item_desc);
            preg_match('#\((.*?)\)#', $item_desc, $match);
            preg_match('/\d+/', $match[1], $match);
            $nob = $match[0];
            $start_time = $item['pubDate'];
            $start_time = date('Y-m-d H:i:s', strtotime($start_time));
            $start_time = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
           // var_dump($start_time);exit;

            $parts = explode('/', $item['guid']);
            $ebay_id = explode('?', $parts[5]);
            $ebay_id = $ebay_id[0];
            $item_url = $item['link'];
            $item_url = trim(str_replace("  ", ' ', $item_url));
            $item_url = str_replace(array("`,′"), "", $item_url);
            $item_url = str_replace(array("'"), "''", $item_url);

            // create HTML DOM
            $html = file_get_html($item_url);

            // get title
            $ship_cost_span = @$html->getElementById('fshippingCost')->innertext;
            $ship_cost = (float) filter_var( $ship_cost_span, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );// float(55.35) 

            $sale_price = $item['CurrentPrice'][@$i]/100;
            $category_name = $item['Category'][@$i];
            $category_name = trim(str_replace("  ", ' ', $category_name));
            $category_name = str_replace(array("`,′"), "", $category_name);
            $category_name = str_replace(array("'"), "''", $category_name);
            $cat_id = $item['ch_link'][0];
            /*==================================================
            =            to get the mpn_id from url            =
            ==================================================*/
            $catalogue_mt_id = preg_replace("/.+?&_mpn=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($catalogue_mt_id)){
              $catalogue_mt_id = null;
            }
            /*=====  End of to get the mpn_id from url  ======*/
            
            //$condition_id = substr($cat_id, -4);
            $condition_id = preg_replace("/.+?&LH_ItemCondition=(\d+).*/", "$1", $cat_id);//get this regex from https://regex101.com/r/rC6mU3/3
            if(!is_numeric($condition_id)){
              $condition_id = null;
            }
            $parts = explode('/', $cat_id);
            $category_id = $parts[5];
            // if(!empty($catalogue_mt_id)){
            //   $flag_id = '30';
            // }else{
            //   $flag_id = '32';
            // }
            
            /*==============================================
            =            check if already exist            =
            ==============================================*/
            $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
            if($check_qry->num_rows() >0){
              //$i = 0;
              echo $i ." - alredy insert".PHP_EOL;
              $flag = 0;
              break;

            }else{
              /*============================================
              =            Insert feed in table            =
              ============================================*/
              date_default_timezone_set("America/Chicago");
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_TMP','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_pk_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED,FEED_URL_ID,SHIP_COST,NOB) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma $flag_id $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1 $comma '$feed_url_id' $comma $ship_cost $comma '$nob')");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM  LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id AND CATALOGUE_MT_ID IS NULL AND CATEGORY_ID = '$category_id'");
              
              //Call log insertion query

              $min_max_query = $this->db2->query("SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();

              $max_time = $min_max_query[0]['MAX_TIME'];
              $min_time = $min_max_query[0]['MIN_TIME'];
              $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
              $min_time = new DateTime($min_time);
               
              $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
              $max_time = new DateTime($max_time);
              
              //var_dump($min_time,$max_time);exit;         

              // $dteStart = new DateTime($min_time); 
              // $dteEnd   = new DateTime($max_time); 
              $dteDiff  = $min_time->diff($max_time); 
              $min_time = $min_time->format('Y-m-d\TH:i:s');
              $max_time = $max_time->format('Y-m-d\TH:i:s');
              $execution_time = $dteDiff->format("%d days %H:%I:%S");
              $min_time = str_replace(array("T"), "", $min_time); 
              $max_time = str_replace(array("T"), "", $max_time);
              $time_in_min = $dteDiff->format("%I");
              $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
              $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
              //var_dump($min_time,$max_time);exit;
              $total_query = $this->db2->query("SELECT COUNT(1) TOTAL_RECORDS FROM LZ_BD_RSS_FEED_TMP D WHERE D.FLAG_ID = $flag_id AND CATALOGUE_MT_ID = '$catalogue_mt_id'")->result_array();
              // $total_records = oci_parse($conn, $total_query);
              // oci_execute($total_records,OCI_DEFAULT);
              // $total = oci_fetch_array($total_records, OCI_ASSOC);
              if($time_in_min != 0){
                  $per_mint_records = $total_query[0]['TOTAL_RECORDS']/$time_in_min;
              }else{
                  $per_mint_records = 0;
              }
              $total_records = $total_query[0]['TOTAL_RECORDS'];
              
              // $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $LZ_BD_RSS_FEED_TMP CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
              // $avg_records = oci_parse($conn, $per_day_avg_qry);
              // oci_execute($avg_records,OCI_DEFAULT);
              // $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
              // //var_dump($avg_records_data['AVERAGE']);exit;
              // $avg_records_data = @$avg_records_data['AVERAGE'];
              // if(empty($avg_records_data)){
              //     $avg_records_data = 'null';
              // }else{
              //     $avg_records_data = @$avg_records_data['AVERAGE'];
              // } 
              
              $inserted_date = date("Y-m-d H:i:s");
              $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

              $select_query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED_LOG','LOG_ID') CALL_LOG_ID FROM DUAL")->result_array();
              // $select = oci_parse($conn, $select_query);
              // oci_execute($select,OCI_DEFAULT);
              // $rs = oci_fetch_array($select, OCI_ASSOC);

              $call_log_id = $select_query[0]['CALL_LOG_ID']; 

              $insert_qry = $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_LOG (LOG_ID, FEED_URL_ID, TOTAL_RECORDS, EXECUTION_TIME, START_TIME, END_TIME, INSERTED_TIME) VALUES($call_log_id $comma '$feed_url_id' $comma '$total_records' $comma '$execution_time' $comma $min_time $comma $max_time $comma $inserted_date)"); 

              /* --Call log insertion end-- */
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/
              
              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE FLAG_ID = $flag_id  AND CATALOGUE_MT_ID IS NULL AND CATEGORY_ID = '$category_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else

              /*=====  End of check if already exist  ======*/

            $i++;
          }//end item feed foreach
        }//count if close
          /*=====  End of select rss feed  ======*/
    
      }//end rss_feed_url foreach
    }//main num rows if close

    /*================================================
      =            update newly listed flag            =
      ================================================*/
      if(!empty($max_feed_id) && !empty($catalogue_mt_id)){
        $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1 AND CATALOGUE_MT_ID = $catalogue_mt_id AND FLAG_ID = $flag_id AND FEED_ID <= $max_feed_id");
      }
    /*=====  End of update newly listed flag  ======*/
              
    return $flag;

  }
 public function GetMostWatchedItems() {
      /*=======================================================
    =            get last downloaded price index            =
    =======================================================*/
    $get_last_index = $this->db2->query("SELECT M.CATEGORY_ID FROM LZ_BD_MOST_WATCHED_ITEMS M WHERE M.WATCH_ID = (SELECT MAX(WATCH_ID) FROM LZ_BD_MOST_WATCHED_ITEMS)")->result_array(); 
    if(count($get_last_index) > 0){

        $last_cat_id = $get_last_index[0]['CATEGORY_ID'];

        $WHERE = " AND T.CATEGORY_ID >= $last_cat_id";

    }else{//count($get_last_index) if else
       $WHERE = " ";
    }
    
    /*=====  End of get last downloaded price index  ======*/


  $get_cat = $this->db2->query("SELECT T.CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID IS NOT NULL $WHERE ORDER BY T.CATEGORY_ID ASC")->result_array();
  return $get_cat;

 }
 public function GetEpid($user_id) {

  /*====================================
  =            get user log            =
  ====================================*/
  $get_last_log = $this->db2->query("SELECT * FROM LZ_EBAY_USER_LOG WHERE USER_ID = $user_id AND LOG_TYPE = 'GETEPID'")->result_array();
    if(count($get_last_log) > 0){

        $min_watch_id= $get_last_log[0]['MIN_ID'];
        $max_watch_id= $get_last_log[0]['MAX_ID'];

        $BETWEEN = " AND S.WATCH_ID BETWEEN  $min_watch_id AND $max_watch_id";

    }else{//count($get_last_index) if else
       $BETWEEN = " ";
    }
  
  /*=====  End of get user log  ======*/
  
      /*=======================================================
    =            get last downloaded epid index            =
    =======================================================*/
    $get_last_index = $this->db2->query("SELECT M.WATCH_ID FROM LZ_BD_MOST_WATCHED_ITEMS M WHERE M.WATCH_ID = (SELECT MAX(WATCH_ID) FROM LZ_BD_MOST_WATCHED_ITEMS S WHERE S.GETEPID = 1 AND S.CATEGORY_ID NOT IN (SELECT DISTINCT CATEGORY_ID FROM LZ_CATALOGUE_MT) $BETWEEN)")->result_array(); 
    // $get_last_index = $this->db2->query("SELECT M.WATCH_ID FROM LZ_BD_MOST_WATCHED_ITEMS M WHERE M.WATCH_ID = (SELECT MAX(WATCH_ID) FROM LZ_BD_MOST_WATCHED_ITEMS S WHERE S.GETEPID = 1 AND S.CATEGORY_ID IN (SELECT DISTINCT CATEGORY_ID FROM LZ_CATALOGUE_MT))")->result_array(); 
    if(count($get_last_index) > 0){

        $last_watch_id= $get_last_index[0]['WATCH_ID'];

        $WHERE = " WHERE S.WATCH_ID > $last_watch_id ";

    }else{//count($get_last_index) if else
       $WHERE = " WHERE S.WATCH_ID > 0 $BETWEEN";
    }
    
    /*=====  End of get last downloaded epid index  ======*/


  //$get_watch_id = $this->db2->query("SELECT S.WATCH_ID, S.EBAYID FROM LZ_BD_MOST_WATCHED_ITEMS M $WHERE AND S.EPID IS NULL ORDER BY S.WATCH_ID ASC")->result_array();
  $get_watch_id = $this->db2->query("SELECT * FROM (SELECT S.WATCH_ID, S.EBAYID FROM LZ_BD_MOST_WATCHED_ITEMS S $WHERE AND S.EPID IS NULL AND S.GETEPID = 0 AND S.CATEGORY_ID NOT IN (SELECT DISTINCT CATEGORY_ID FROM LZ_CATALOGUE_MT) ORDER BY S.WATCH_ID ASC) WHERE ROWNUM <=5000")->result_array(); 
  return $get_watch_id;

 } 
 public function GetEbayCatalogue() {
      /*=======================================================
    =            get last downloaded epid index            =
    =======================================================*/
    $get_last_index = $this->db2->query("SELECT MAX(EPID) EPID FROM LZ_EBAY_CATALOGUE_MT ")->result_array(); 
    if($get_last_index[0]['EPID'] > 0){

        $last_epid = $get_last_index[0]['EPID'];

        $WHERE = " WHERE M.EPID >= $last_epid ";

    }else{//count($get_last_index) if else
       $WHERE = " WHERE M.EPID > 0 ";
    }
    
    /*=====  End of get last downloaded epid index  ======*/


  $get_epid = $this->db2->query("SELECT DISTINCT M.EPID,M.CATEGORY_ID FROM LZ_BD_MOST_WATCHED_ITEMS M $WHERE AND M.EPID IS NOT NULL ORDER BY M.EPID ASC")->result_array(); 
  return $get_epid;

 } 
 public function updateUserLog(){
  $this->db2->query("CALL PRO_UPDATE_USER_LOG()"); 
 }
 public function getAuctionItemPrice()
  {
    /*=======================================================
    =            get last downloaded price index            =
    =======================================================*/
    // $get_last_index = $this->db2->query("SELECT API_AVG_PRICE_ID,FEED_URL_ID, AVG_PRICE_ACTIVE  FROM (SELECT * FROM LZ_BD_API_AVG_PRICE P ORDER BY P.API_AVG_PRICE_ID DESC) WHERE ROWNUM = 1")->result_array();
    // if(count($get_last_index) > 0){
    //     $avg_price = $get_last_index[0]['AVG_PRICE_ACTIVE'];
    //     $feed_url_id = $get_last_index[0]['FEED_URL_ID'];

    //     $max_feed_url_id = $this->db2->query("SELECT MAX(U.FEED_URL_ID) FEED_URL_ID FROM LZ_BD_RSS_FEED_URL U WHERE (U.CONDITION_ID <> 0 OR U.CONDITION_ID <> NULL) AND TRIM(U.KEYWORD) IS NOT NULL AND U.CATLALOGUE_MT_ID IS NOT NULL")->result_array(); //echo $cat_qry; exit;
    //     $max_id = $max_feed_url_id[0]['FEED_URL_ID'];

/*=============================================================================
=     if current feed_url_id = max feed_url_id restart loop condition            =
=============================================================================*/
        // if($feed_url_id == $max_id){
        //     $restart_loop = true;
        // }else{
        //     $restart_loop = false;
        // }
/*==  End of if current feed_url_id = max feed_url_id restart loop condition  ==*/

    //     if($restart_loop == false){
    //       if(!empty($avg_price)){
    //         $WHERE = ' AND U.FEED_URL_ID > '.$feed_url_id;
    //       }else{
    //         $api_avg_price_id = $get_last_index[0]['API_AVG_PRICE_ID'];

    //         $this->db2->query("DELETE FROM LZ_BD_API_AVG_PRICE P WHERE P.API_AVG_PRICE_ID = $api_avg_price_id");//UNCOMPLETE DATA SO DELETE IT
    //         $WHERE = ' AND U.FEED_URL_ID >= '.$feed_url_id;
    //       }
          
    //     }else{
    //       $WHERE = ' ';
    //     }
        
    // }else{//count($get_last_index) if else
    //    $WHERE = ' ';
    // }
    
    /*=====  End of get last downloaded price index  ======*/

    $get_kw = $this->db2->query("SELECT D.*,M.CONDITION FROM LZ_AUCTION_MT M , LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID AND M.PROCESSED = 0 AND D.LINE_PROCESSED = 0 ORDER BY D.LZ_AUCTION_ID ASC "); 
    $data =  $get_kw->result_array();
    return $data;
  }
  public function uploadBbyfile()
    {
      //echo __DIR__ ;exit;
      $str = file_get_contents(__DIR__ .'\products.json');
      //$str = file_get_contents('test.json');
      //$shipments = json_encode(json_decode(file_get_contents("test.json"), true));
      //echo $shipments;
      //print_r($str);
      $json = json_decode($str,true); // decode the JSON into an associative array

      foreach ($json as $field => $value) {
          // Use $field and $value here

        $description = $value['description'];
        $description = trim(str_replace("  ", ' ', $description));
        $description = str_replace(array("`,′"), "", $description);
        $description = str_replace(array("'"), "''", $description);
        if(strlen($description) > 100) {
          $description = substr($description,0,100);
        }
        $image = $value['image'];
        $manufacturer = $value['manufacturer'];
        $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
        $manufacturer = str_replace(array("`,′"), "", $manufacturer);
        $manufacturer = str_replace(array("'"), "''", $manufacturer);
        if(strlen($manufacturer) > 100) {
          $manufacturer = substr($manufacturer,0,100);
        }
        $name = $value['name'];
        $name = trim(str_replace("  ", ' ', $name));
        $name = str_replace(array("`,′"), "", $name);
        $name = str_replace(array("'"), "''", $name);
        if(strlen($name) > 150) {
          $name = substr($name,0,150);
        }
        $salePrice = $value['salePrice'];
        $upc = $value['upc'];
        $type = $value['type'];
        $type = trim(str_replace("  ", ' ', $type));
        $type = str_replace(array("`,′"), "", $type);
        $type = str_replace(array("'"), "''", $type);
        $sku = $value['sku'];
        $shortDescription = $value['shortDescription'];
        $shortDescription = trim(str_replace("  ", ' ', $shortDescription));
        $shortDescription = str_replace(array("`,′"), "", $shortDescription);
        $shortDescription = str_replace(array("'"), "''", $shortDescription);
        if(strlen($shortDescription) > 400) {
          $shortDescription = substr($shortDescription,0,400);
        }
        $modelNumber = $value['modelNumber'];
        $modelNumber = trim(str_replace("  ", ' ', $modelNumber));
        $modelNumber = str_replace(array("`,′"), "", $modelNumber);
        $modelNumber = str_replace(array("'"), "''", $modelNumber);
        $height = $value['height'];
        $height = trim(str_replace("  ", ' ', $height));
        $height = str_replace(array("`,′"), "", $height);
        $height = str_replace(array("'"), "''", $height);
        $width = $value['width'];
        $width = trim(str_replace("  ", ' ', $width));
        $width = str_replace(array("`,′"), "", $width);
        $width = str_replace(array("'"), "''", $width);
        $shippingWeight = $value['shippingWeight'];
        $shippingWeight = trim(str_replace("  ", ' ', $shippingWeight));
        $shippingWeight = str_replace(array("`,′"), "", $shippingWeight);
        $shippingWeight = str_replace(array("'"), "''", $shippingWeight);
        $weight = $value['weight'];
        $weight = trim(str_replace("  ", ' ', $weight));
        $weight = str_replace(array("`,′"), "", $weight);
        $weight = str_replace(array("'"), "''", $weight);
        $condition = $value['condition'];
        $condition = trim(str_replace("  ", ' ', $condition));
        $condition = str_replace(array("`,′"), "", $condition);
        $condition = str_replace(array("'"), "''", $condition);
        $class = $value['class'];// treated as object
        $class = trim(str_replace("  ", ' ', $class));
        $class = str_replace(array("`,′"), "", $class);
        $class = str_replace(array("'"), "''", $class);
        $feature_data='';
        if(isset($value['features'])){
          foreach ($value['features'] as $feature) {
          //echo $feature['feature']."<br>";
            $featur = trim(str_replace("  ", ' ', $feature['feature']));
            $featur = str_replace(array("`,′"), "", $featur);
            $featur = str_replace(array("'"), "''", $featur);
            $feature_data .= $featur."<br>";
            if(strlen($feature_data) > 4000) {
              $feature_data = substr($feature_data,0,4000);
              break;
            }
         }
        }
        

        $check_qry = $this->db2->query("SELECT * FROM LZ_BD_BBY_CATALOG_MT WHERE SKU = '$sku'");
        if($check_qry->num_rows() == 0){
          $get_mt_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_BBY_CATALOG_MT','BBY_ID') BBY_ID FROM DUAL ")->result_array();
          $bby_id = $get_mt_pk[0]['BBY_ID'];

          $this->db2->query("INSERT INTO LZ_BD_BBY_CATALOG_MT (BBY_ID, SKU, NAME, MANUFACTURER, UPC, MODELNUMBER, CONDITION, BBY_CLASS, IMAGE, SALEPRICE, HEIGHT, WIDTH, WEIGHT, SHIPPINGWEIGHT, DESCRIPTION, SHORTDESCRIPTION, FEATURES, BBY_TYPE, INSERTED_DATE )VALUES($bby_id, '$sku', '$name', '$manufacturer', '$upc', '$modelNumber', '$condition', '$class', '$image', '$salePrice', '$height', '$width', '$weight', '$shippingWeight', '$description', '$shortDescription', '$feature_data', '$type', SYSDATE )");
          if(isset($value['features'])){
            foreach ($value['details'] as $detail) {
              $detail_name = $detail['name'];
              $detail_name = trim(str_replace("  ", ' ', $detail_name));
              $detail_name = str_replace(array("`,′"), "", $detail_name);
              $detail_name = str_replace(array("'"), "''", $detail_name);
              $detail_value = $detail['value'];
              $detail_value = trim(str_replace("  ", ' ', $detail_value));
              $detail_value = str_replace(array("`,′"), "", $detail_value);
              $detail_value = str_replace(array("'"), "''", $detail_value);
              $check_qry = $this->db2->query("SELECT * FROM LZ_BD_BBY_CATALOG_DT WHERE UPPER(NAME) = UPPER('$detail_name')");
              if($check_qry->num_rows() == 0){
              $this->db2->query("INSERT INTO LZ_BD_BBY_CATALOG_DT (BBY_DT_ID, BBY_MT_ID, NAME, VALUE )VALUES(GET_SINGLE_PRIMARY_KEY('LZ_BD_BBY_CATALOG_DT','BBY_DT_ID'), '$bby_id', '$detail_name', '$detail_value')");
              }
            }
          }
          
        }
      }// end json main foreach
    }
  public function GetCategoryFeatures(){
 
  return $this->db2->query("SELECT * FROM (SELECT T.CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T, LZ_BD_CATEGORY C WHERE T.PARENT_CAT_ID IS NOT NULL AND T.UPDATED IS NOT NULL AND C.CATEGORY_ID = T.CATEGORY_ID AND T.CATEGORY_ID > (SELECT NVL(MAX(CATEGORY_ID),0) FROM LZ_BD_CAT_COND) AND C.CONDITION_AVAILABLE = 1 ORDER BY T.CATEGORY_ID ASC) where ROWNUM <= 5000")->result_array(); 
  }
  public function GetActiveItemEpid($user_id) {
    /*====================================
    =            get user log            =
    ====================================*/
    // $get_last_log = $this->db2->query("SELECT * FROM LZ_EBAY_USER_LOG WHERE USER_ID = $user_id AND LOG_TYPE = 'GETEPID'")->result_array();
    //   if(count($get_last_log) > 0){

    //       $min_watch_id= $get_last_log[0]['MIN_ID'];
    //       $max_watch_id= $get_last_log[0]['MAX_ID'];

    //       $BETWEEN = " AND S.WATCH_ID BETWEEN  $min_watch_id AND $max_watch_id";

    //   }else{//count($get_last_index) if else
    //      $BETWEEN = " ";
    //   }
    
    /*=====  End of get user log  ======*/
    
        /*=======================================================
      =            get last downloaded epid index            =
      =======================================================*/
      //$get_last_index = $this->db2->query("SELECT M.WATCH_ID FROM LZ_BD_MOST_WATCHED_ITEMS M WHERE M.WATCH_ID = (SELECT MAX(WATCH_ID) FROM LZ_BD_MOST_WATCHED_ITEMS S WHERE S.GETEPID = 1 AND S.CATEGORY_ID NOT IN (SELECT DISTINCT CATEGORY_ID FROM LZ_CATALOGUE_MT) $BETWEEN)")->result_array(); 
      // $get_last_index = $this->db2->query("SELECT M.WATCH_ID FROM LZ_BD_MOST_WATCHED_ITEMS M WHERE M.WATCH_ID = (SELECT MAX(WATCH_ID) FROM LZ_BD_MOST_WATCHED_ITEMS S WHERE S.GETEPID = 1 AND S.CATEGORY_ID IN (SELECT DISTINCT CATEGORY_ID FROM LZ_CATALOGUE_MT))")->result_array(); 
      // if(count($get_last_index) > 0){

      //     $last_watch_id= $get_last_index[0]['WATCH_ID'];

      //     $WHERE = " WHERE S.WATCH_ID > $last_watch_id ";

      // }else{//count($get_last_index) if else
      //    $WHERE = " WHERE S.WATCH_ID > 0 $BETWEEN";
      // }
      
      /*=====  End of get last downloaded epid index  ======*/


    //$get_watch_id = $this->db2->query("SELECT S.WATCH_ID, S.EBAYID FROM LZ_BD_MOST_WATCHED_ITEMS M $WHERE AND S.EPID IS NULL ORDER BY S.WATCH_ID ASC")->result_array();
    // $get_watch_id = $this->db->query("SELECT * FROM (SELECT DISTINCT I.ITEM_ID, E.EBAY_ITEM_ID EBAY_ID, I.ITEM_MT_MANUFACTURE BRAND ,I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_UPC UPC,T.CATEGORY_ID FROM EBAY_LIST_MT E , ITEMS_MT I , LZ_ACTIVE_LISTING_TEMP T WHERE E.EBAY_ITEM_ID  = T.EBAY_ID AND I.ITEM_ID = E.ITEM_ID AND I.ITEM_MT_MANUFACTURE IS NOT NULL AND T.ITEM_ID IS NULL ) WHERE ROWNUM <=5000")->result_array(); 
    $get_watch_id = $this->db->query("SELECT * FROM (SELECT DISTINCT I.ITEM_ID, E.EBAY_ITEM_ID        EBAY_ID, T.ITEM_TITLE, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_UPC         UPC, T.CATEGORY_ID FROM EBAY_LIST_MT E, ITEMS_MT I, LZ_ACTIVE_LISTING_TEMP T WHERE E.EBAY_ITEM_ID = T.EBAY_ID AND I.ITEM_ID = E.ITEM_ID AND I.ITEM_MT_MANUFACTURE IS NOT NULL AND T.ITEM_ID IS NULL ) WHERE ROWNUM <= 5000")->result_array(); 
    return $get_watch_id;

  }
  public function assignEpid(){
    //$get_item = $this->db->query("SELECT DISTINCT A.EBAY_ID,J.EPID FROM LZ_ACTIVE_LISTING_TEMP A , (SELECT C.ITEM_ID, C.EPID, T.CNT FROM (SELECT T.ITEM_ID, T.EPID, COUNT(1) CNT FROM LZ_BIND_EPID_DT_TMP T GROUP BY T.ITEM_ID, T.EPID) C, (SELECT ITEM_ID, MAX(CNT) CNT FROM (SELECT T.ITEM_ID, T.EPID, COUNT(1) CNT FROM LZ_BIND_EPID_DT_TMP T GROUP BY T.ITEM_ID, T.EPID) GROUP BY ITEM_ID) T WHERE C.ITEM_ID = T.ITEM_ID AND C.CNT = T.CNT AND T.CNT = 1 AND C.ITEM_ID IN (SELECT C.ITEM_ID FROM (SELECT T.ITEM_ID, T.EPID, COUNT(1) CNT FROM LZ_BIND_EPID_DT_TMP T GROUP BY T.ITEM_ID, T.EPID) C, (SELECT ITEM_ID, MAX(CNT) CNT FROM (SELECT T.ITEM_ID, T.EPID, COUNT(1) CNT FROM LZ_BIND_EPID_DT_TMP T GROUP BY T.ITEM_ID, T.EPID) GROUP BY ITEM_ID) T WHERE C.ITEM_ID = T.ITEM_ID AND C.CNT = T.CNT AND T.CNT = 1 GROUP BY C.ITEM_ID HAVING COUNT(1) = 1 ) )J WHERE A.ITEM_ID = J.ITEM_ID AND A.REVISE_CALL = 0")->result_array();// qry for 1 unique epid
    $get_item = $this->db->query("SELECT A.EBAY_ID, IT.EPID FROM LZ_ACTIVE_LISTING_TEMP A, (SELECT C.ITEM_ID, EPID, C.CNT FROM (SELECT T.ITEM_ID, T.EPID, COUNT(1) CNT FROM LZ_BIND_EPID_DT_TMP T GROUP BY T.ITEM_ID, T.EPID) B, (SELECT ITEM_ID, MAX(CNT) CNT FROM (SELECT T.ITEM_ID, T.EPID, COUNT(1) CNT FROM LZ_BIND_EPID_DT_TMP T GROUP BY T.ITEM_ID, T.EPID) GROUP BY ITEM_ID HAVING MAX(CNT) > 1) C WHERE B.ITEM_ID = C.ITEM_ID AND B.CNT = C.CNT AND B.ITEM_ID IN (SELECT DISTINCT T.ITEM_ID FROM LZ_ACTIVE_LISTING_TEMP T WHERE T.ITEM_ID IS NOT NULL AND T.REVISE_CALL = 0)) IT WHERE A.ITEM_ID = IT.ITEM_ID AND A.REVISE_CALL = 0 AND ROWNUM <= 5000")->result_array();// qry for multi epid with max count
    return $get_item;
  }
      public function createActiveListingUrlFile(){
    /*==========================================================
    =            creating chunk of 100 rss feed url            =
    ==========================================================*/

    $get_ebay_id = $this->db->query("SELECT T.EBAY_ID FROM LZ_ACTIVE_LISTING_TEMP T where rownum <=500")->result_array();
        $dir = explode('\\', __DIR__);
        $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
              
        $path = $base_url."/watchCountScript/activeListing.bat";
        if (is_file($path)) {
        //Attempt to delete it.
         unlink($path);
        }
        $fileData = "@ECHO\n".$dir[0]."\ncd ".$base_url."\n";
      foreach ($get_ebay_id as $ebay_id) {
        //$ebay_url = "https://www.ebay.com/itm/252902429150";//.$ebay_id['EBAY_ID'];
        //$ebay_url = "https://www.ebay.com/itm/173424513958";//.$ebay_id['EBAY_ID'];
        $ebay_url = "https://www.ebay.com/itm/223182819399";//.$ebay_id['EBAY_ID'];
        
          //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";
          if(!is_dir(@$path)){
            $fileData .= "curl ".$ebay_url." \n ";
           // var_dump($fileData,$dir[0]);exit;
            
          }else{
            echo "path not found";
          }
      }
      $fileData .="PAUSE";
      $myfile = fopen($path, "w") ;
      fwrite($myfile, $fileData);
      fclose($myfile);
      //var_dump($url_min_id,$url_max_id);exit;

      
      
      //return true;
    

    echo "all feed created";
    //$max_feed_id = $max_feed_id[0]['FEED_ID'];
    
    /*=====  End of creating chunk of 100 rss feed url  ======*/
  }
  public function getSoldItems(){
    $get_item = $this->db->query("SELECT DISTINCT E.ITEM_ID, E.EBAY_ITEM_ID, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_UPC         UPC, S.CATEGORY_ID, E.ITEM_CONDITION      CONDITION_ID FROM EBAY_LIST_MT E, ITEMS_MT I, LZ_ITEM_SEED S WHERE E.ITEM_ID NOT IN (SELECT D.ITEM_ID FROM LZ_SALESLOAD_DET D WHERE D.SALE_DATE >= SYSDATE - 7) AND I.ITEM_ID = E.ITEM_ID AND I.ITEM_ID = S.ITEM_ID AND E.SEED_ID = S.SEED_ID AND E.LIST_DATE >= SYSDATE - 7 AND E.LIST_PRICE >= 50 AND I.ITEM_MT_MANUFACTURE NOT IN ('NA', 'N/A', 'UNKNOWN')")->result_array(); 
    return $get_item;
  }
    public function createGetordersBatchFile(){
    
    $get_seller = $this->db->query("SELECT S.LZ_SELLER_ACCT_ID,S.LZ_SELLER_ACCT_ID||'-'||S.SELL_ACCT_DESC FILE_NAME FROM LZ_SELLER_ACCTS S  WHERE S.ACTIVE_SELLER = 1 ORDER BY S.LZ_SELLER_ACCT_ID ASC")->result_array();
    foreach ($get_seller as $seller){
      $fileName = $seller['FILE_NAME'];
      $seller_id = $seller['LZ_SELLER_ACCT_ID'];
     
      $dir = explode('\\', __DIR__);
      $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
            
      $path = $base_url."/getAwaitingShipments/getOrders_files/".$fileName.".bat";
        //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";

        if(!is_dir(@$path)){
          $fileData = '@ECHO OFF 
                      set map=%~dp0
                      call:get_parent_path "%map%" 
                      call:get_parent_path %_full_path% 
                      call:get_parent_path %_full_path% 
                      call:get_last_path %_full_path% 
                      goto :eof 
                      :get_parent_path 
                      set "_full_path=%~dp1" 
                      :_strip 
                      if not "%_full_path:~-1%"=="\" if not "%_full_path:~-1%"=="/" goto:_strip_end 
                      set "_full_path=%_full_path:~0,-1%" 
                      goto:_strip 
                      :_strip_end 
                      exit /b 
                      :get_last_path 
                      set "_last_path=%~nx1" 
                      echo full_path is %_full_path% 
                      title '.$fileName.'  
                      %~d0 REM GIVE DIRECTORY ALPHABET I.E D: 
                      cd %_full_path% 
                      php index.php cron_job c_cron_job GetSellerOrders '.$seller_id.' 

                      EXIT';

          //$fileData = "@ECHO\n".$dir[0]."\ncd ".$base_url."\n :STEP1 \n php index.php cron_job c_cron_job runLocalStreamChunk ".$url_min_id.' '. $url_max_id."\n IF ERRORLEVEL 1 GOTO :RETRY \n \n :RETRY \n php index.php cron_job c_cron_job runLocalStreamChunk ".$url_min_id.' '. $url_max_id." \n IF ERRORLEVEL 1 GOTO :STEP1 \n PAUSE";
         // var_dump($fileData,$dir[0]);exit;
          $myfile = fopen($path, "w") ;
          fwrite($myfile, $fileData);
          fclose($myfile);
        }else{
          echo "path not found";
        }
      
      
      //return true;
    
    }//end for loop
    echo "all feed created";
    //$max_feed_id = $max_feed_id[0]['FEED_ID'];
    
    /*=====  End of creating chunk of 100 rss feed url  ======*/
  }
}

