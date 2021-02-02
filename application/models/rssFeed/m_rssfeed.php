<?php 
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_rssfeed extends CI_Model {
  public function loadData() {

      //$query = $this->db2->query("SELECT F.*,P.AVG_PRICE,P.QTY_SOLD FROM LZ_BD_RSS_FEED F, MPN_AVG_PRICE_TMP P WHERE  F.CATALOGUE_MT_ID=P.CATALOGUE_MT_ID(+) AND  F.CONDITION_ID = P.CONDITION_ID(+) AND FLAG_ID IS NULL ORDER BY START_TIME DESC");
      $query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE,NEWLY_LISTED, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB ORDER BY FEED_ID DESC");
      $feed_data = $query->result_array();

      /*====================================
      =            get feed url            =
      ====================================*/
      $get_url = $this->db2->query("SELECT U.FEED_URL_ID, U.CATEGORY_ID, U.CONDITION_ID, C.MPN, DECODE(REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$'), 1, NULL, REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$')) CATALOGUE_MT_ID FROM LZ_BD_RSS_FEED_URL U,LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID(+) = DECODE(REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$'), 1, NULL, REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$'))");
      $get_rss_url = $get_url->result_array();
      
      /*=====  End of get feed url  ======*/

      $categories = $this->db2->query("SELECT DISTINCT F.CATEGORY_ID, C.CATEGORY_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID");
      $cat_id_qry = $categories->result_array();


      return array('feed_data'=>$feed_data,'feed_url'=>$get_rss_url, 'cat_id_qry'=>$cat_id_qry);
  }
  public function verified_rssfeed() {

      //$query = $this->db2->query("SELECT F.*,P.AVG_PRICE,P.QTY_SOLD FROM LZ_BD_RSS_FEED F, MPN_AVG_PRICE_TMP P WHERE  F.CATALOGUE_MT_ID=P.CATALOGUE_MT_ID(+) AND  F.CONDITION_ID = P.CONDITION_ID(+) AND FLAG_ID IS NULL ORDER BY START_TIME DESC");
      $query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE,NEWLY_LISTED, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB where CATALOGUE_MT_ID = 104996 ORDER BY FEED_ID DESC");
      $feed_data = $query->result_array();

      /*====================================
      =            get feed url            =
      ====================================*/
      $get_url = $this->db2->query("SELECT U.FEED_URL_ID, U.CATEGORY_ID, U.CONDITION_ID, C.MPN, DECODE(REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$'), 1, NULL, REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$')) CATALOGUE_MT_ID FROM LZ_BD_RSS_FEED_URL U,LZ_CATALOGUE_MT C WHERE C.CATALOGUE_MT_ID(+) = DECODE(REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$'), 1, NULL, REGEXP_SUBSTR(U.RSS_FEED_URL, '[^_mpn=]+$'))");
      $get_rss_url = $get_url->result_array();
      
      /*=====  End of get feed url  ======*/
      
      return array('feed_data'=>$feed_data,'feed_url'=>$get_rss_url);
  }  
    public function loadMultipleData() {

    $url_111422 = 'https://www.ebay.com/sch/Apple-Laptops/111422/i.html?_from=R40&_nkw&_sop=10&rt=nc&LH_BIN=1&_rss=1';
    $url_177 = 'https://www.ebay.com/sch/PC-Laptops-Netbooks/177/i.html?_from=R40&_nkw&_sop=10&rt=nc&LH_BIN=1&_rss=1';
    $url_179 = 'https://www.ebay.com/sch/PC-Laptops-Netbooks/179/i.html?_from=R40&_nkw&_sop=10&rt=nc&LH_BIN=1&_rss=1';
    //$parts = explode('/', $feed_url);
    //$category_id = $parts[5];
    //$this->rssparser->set_feed_url($feed_url);   // get feed
    //$this->rssparser->set_cache_life(1);             // Set cache life time in minutes
    //$rss = $this->rssparser->getFeed(6);            // Get six items from the feed  
    $rss[] = $this->rssparser->set_feed_url($url_111422)->set_cache_life(1)->getFeed(100);
    $rss[] = $this->rssparser->set_feed_url($url_177)->set_cache_life(1)->getFeed(100);
    $rss[] = $this->rssparser->set_feed_url($url_179)->set_cache_life(1)->getFeed(100);
    $i = 0;
    $comma = ',';
    foreach ($rss as $feed)
    {
      foreach ($feed as $item) {
        if($i == 100){
          $i = 0;
        }
      
        //print_r($item['CurrentPrice']);exit;
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
        $sale_price = $item['CurrentPrice'][$i]/100;
        $category_name = $item['Category'][$i];
        $category_name = trim(str_replace("  ", ' ', $category_name));
        $category_name = str_replace(array("`,′"), "", $category_name);
        $category_name = str_replace(array("'"), "''", $category_name);
        $cat_id = $item['ch_link'][0];
        $parts = explode('/', $cat_id);
        $category_id = $parts[5];
        $flag_id = '';
          /*==============================================
          =            check if already exist            =
          ==============================================*/
          $check_qry = $this->db2->query("SELECT FEED_ID FROM LZ_BD_RSS_FEED WHERE EBAY_ID = $ebay_id");
          if($check_qry->num_rows() >0){
            break;

          }else{
        /*============================================
        =            Insert feed in table            =
        ============================================*/
        // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED','FEED_ID') FEED_ID FROM DUAL")->result_array();
        // $feed_id = $get_pk[0]['FEED_ID'];
        $this->db2->query("INSERT INTO LZ_BD_RSS_FEED (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma '$flag_id')");
        
        /*=====  End of Insert feed in table  ======*/

          }//end check if else


          /*=====  End of check if already exist  ======*/

        $i++;
      }//end item forech
    }//end feed foreach
      /*=======================================
      =            select rss feed            =
      =======================================*/
      $query = $this->db2->query("SELECT * FROM LZ_BD_RSS_FEED ORDER BY START_TIME DESC");

      $feed_data = $query->result_array();
      return $feed_data;
      
      /*=====  End of select rss feed  ======*/
  }
      public function loadDynamicData() {

    $get_rss_url = $this->db2->query("SELECT RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL");
    $rss_feed_url = $get_rss_url->result_array();
    if($get_rss_url->num_rows() > 0){
      foreach ($rss_feed_url as $feed_data) {
        //$category_id = $feed_data['CATEGORY_ID'];
        //$condition_id = $feed_data['CONDITION_ID'];
        $rss_feed_url = $feed_data['RSS_FEED_URL'];
        $rss[] = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
      }
      
    }else{

    } 
    // $rss[] = $this->rssparser->set_feed_url($url_111422)->set_cache_life(1)->getFeed(100);
    // $rss[] = $this->rssparser->set_feed_url($url_177)->set_cache_life(1)->getFeed(100);
    // $rss[] = $this->rssparser->set_feed_url($url_179)->set_cache_life(1)->getFeed(100);
    //print_r($rss);exit;
    
    $comma = ',';
    foreach ($rss as $feed)
    {
      $i = 0;
      foreach ($feed as $item) {
        if($i == 20){
          $i = 0;
        }
      
        //print_r($item['CurrentPrice']);exit;
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
            $i = 0;
            break;

          }else{
        /*============================================
        =            Insert feed in table            =
        ============================================*/
        // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED','FEED_ID') FEED_ID FROM DUAL")->result_array();
        // $feed_id = $get_pk[0]['FEED_ID'];
        $this->db2->query("INSERT INTO LZ_BD_RSS_FEED (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma '$flag_id' $comma '$condition_id' $comma '$catalogue_mt_id')");
        
        /*=====  End of Insert feed in table  ======*/

          }//end check if else


          /*=====  End of check if already exist  ======*/

        $i++;
      }//end item forech
    }//end feed foreach
      /*=======================================
      =            select rss feed            =
      =======================================*/
      //$query = $this->db2->query("SELECT * FROM LZ_BD_RSS_FEED WHERE FLAG_ID IS NULL ORDER BY START_TIME DESC");
      $query = $this->db2->query("SELECT F.*,P.AVG_PRICE,P.QTY_SOLD FROM LZ_BD_RSS_FEED F, MPN_AVG_PRICE_TMP P WHERE  F.CATALOGUE_MT_ID=P.CATALOGUE_MT_ID(+) AND  F.CONDITION_ID = P.CONDITION_ID(+) AND FLAG_ID IS NULL ORDER BY START_TIME DESC");
      $feed_data = $query->result_array();
      return $feed_data;
      
      /*=====  End of select rss feed  ======*/
  }
  public function fetch_rss_feed() {
    $feed_url_id = $this->input->post('feed_url_id');
    //$feed_url = '';
    if(!empty($feed_url_id)){
      foreach($feed_url_id as $feed){
        $feed_qry = "SELECT RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL WHERE FEED_URL_ID = $feed";
        $get_rss_url = $this->db2->query($feed_qry);
        $rss_feed_url = $get_rss_url->result_array();
          //foreach ($rss_feed_url as $feed_data) {
        $rss_feed_url = $rss_feed_url[0]['RSS_FEED_URL'];
        $rss[] = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
         // }
      }
      
    }else{
        $feed_qry = "SELECT RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL";
        $get_rss_url = $this->db2->query($feed_qry);
        $rss_feed_url = $get_rss_url->result_array();
        if($get_rss_url->num_rows() > 0){
          foreach ($rss_feed_url as $feed_data) {
            //$category_id = $feed_data['CATEGORY_ID'];
            //$condition_id = $feed_data['CONDITION_ID'];
            $rss_feed_url = $feed_data['RSS_FEED_URL'];
            //var_dump($rss_feed_url);//exit;
            $rss[] = $this->rssparser->set_feed_url($rss_feed_url)->set_cache_life(1)->getFeed(20);
          }
        
      }else{
        return 0;
      }
    }

    $last_feed_time = "SELECT TO_CHAR(MAX(START_TIME),'YYYY-MM-DD HH24:MI:SS') START_TIME FROM LZ_BD_RSS_FEED";
    $last_max_time = $this->db2->query($last_feed_time);
    $feed_time = $last_max_time->result_array();
      //foreach ($feed_time as $feed_data) {
    $start_time = $feed_time[0]['START_TIME'];
    if(!empty($start_time)){
      $last_timestamp = "TO_DATE('".$start_time."', 'YYYY-MM-DD HH24:MI:SS')";
      $where = 'WHERE START_TIME > '.$last_timestamp;
    }else{
      $where = ' ';
    }
    
    $comma = ',';
    foreach ($rss as $feed)
    {
      $i = 0;
      foreach ($feed as $item) {
        if($i == 20){
          $i = 0;
        }
      
        //print_r($item['CurrentPrice']);exit;
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
            $i = 0;
            break;

          }else{
          date_default_timezone_set("America/Chicago");
          $inserted_date = date("Y-m-d H:i:s");
          $inserted_date= "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
          /*================================================
          =            update newly listed flag            =
          ================================================*/
          $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1");
          /*=====  End of update newly listed flag  ======*/
        /*============================================
        =            Insert feed in table            =
        ============================================*/
        // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED','FEED_ID') FEED_ID FROM DUAL")->result_array();
        // $feed_id = $get_pk[0]['FEED_ID'];
        $this->db2->query("INSERT INTO LZ_BD_RSS_FEED (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma '$flag_id' $comma '$condition_id' $comma '$catalogue_mt_id') $comma $inserted_date $comma 1)");
        
        /*=====  End of Insert feed in table  ======*/

          }//end check if else


          /*=====  End of check if already exist  ======*/

        $i++;
      }//end item forech
    }//end feed foreach

      /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB $where ORDER BY START_TIME DESC");
      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  }  
  public function auto_rss_feed() {

    $feed_qry = "SELECT RSS_FEED_URL FROM LZ_BD_RSS_FEED_URL";
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
              // $get_pk = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_RSS_FEED','FEED_ID') FEED_ID FROM DUAL")->result_array();
              // $feed_id = $get_pk[0]['FEED_ID'];
              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED_TMP (FEED_ID,EBAY_ID ,TITLE, ITEM_DESC, START_TIME, ITEM_URL, SALE_PRICE, CATEGORY_ID, CATEGORY_NAME, FLAG_ID,CONDITION_ID,CATALOGUE_MT_ID,INSERTED_DATE,NEWLY_LISTED) VALUES (SEQ_FEED_ID.NEXTVAL $comma '$ebay_id' $comma '$title' $comma '$item_desc' $comma $start_time $comma '$item_url' $comma '$sale_price' $comma '$category_id' $comma '$category_name' $comma '$flag_id' $comma '$condition_id' $comma '$catalogue_mt_id' $comma $inserted_date $comma 1)");
              echo  $i ." - Data inserted in LZ_BD_RSS_FEED_TMP".PHP_EOL;
              /*=====  End of Insert feed in table  ======*/
              /*================================================
              =            update newly listed flag            =
              ================================================*/
              $this->db2->query("UPDATE LZ_BD_RSS_FEED SET NEWLY_LISTED = 0 WHERE NEWLY_LISTED = 1");
              /*=====  End of update newly listed flag  ======*/
              
              /*============================================
              =            MOVE DATA TO MAIN TABLE            =
              ============================================*/

              $this->db2->query("INSERT INTO LZ_BD_RSS_FEED SELECT * FROM LZ_BD_RSS_FEED_TMP");
              
              /*=====  End of MOVE DATA TO MAIN TABLE  ======*/

              /*============================================
              =            TRUNCATE TEMP TABLE            =
              ============================================*/

              $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_TMP WHERE CATEGORY_ID = '$category_id'");
              
              /*=====  End of TRUNCATE TEMP TABLE  ======*/
              $flag = 1;
            }//end check if else


            /*=====  End of check if already exist  ======*/

          $i++;
        }//end item feed foreach
          /*=====  End of select rss feed  ======*/
      }//end rss_feed_url foreach
    }//num rows if close
    return $flag;

  }
  public function update_rss_feed() {
    $last_feed_id = $this->input->post('last_feed_id');
    // $last_feed_time = "SELECT TO_CHAR(MAX(START_TIME),'YYYY-MM-DD HH24:MI:SS') START_TIME FROM LZ_BD_RSS_FEED";
    // $last_feed_id = $this->db2->query($last_feed_time);
    // $feed_time = $last_feed_id->result_array();
    //   //foreach ($feed_time as $feed_data) {
    // $start_time = $feed_time[0]['START_TIME'];
    if(!empty($last_feed_id)){

      $where = 'WHERE FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' ';
    }
    $check_qry = $this->db2->query("SELECT NVL(MAX(FEED_ID),0) FEED_ID FROM LZ_BD_RSS_FEED");
    $check_qry = $check_qry->result_array();
    $currentmodif = $check_qry[0]['FEED_ID'];
    while ($currentmodif <= $last_feed_id) // check if the data file has been modified
    {
      time_nanosleep(1,2000000);//Delay for a number of seconds and nanoseconds
      // 500000000 nanosecond = 0.5 sec
      
      //usleep(2000000); // sleep 20ms to unload the CPU
      //100000000 ms = 1 sec
      //sleep (2); // Delays the program execution for the given number of seconds.
      clearstatcache();
      $check_qry = $this->db2->query("SELECT NVL(MAX(FEED_ID),0) FEED_ID FROM LZ_BD_RSS_FEED");
      $check_qry = $check_qry->result_array();
      $currentmodif = $check_qry[0]['FEED_ID'];
      //var_dump($currentmodif);
            

    }
         /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE,NEWLY_LISTED, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB $where ORDER BY FEED_ID DESC");
      //echo $where;
      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  } 
  public function get_item(){
      $feed_id = $this->input->post("feed_id");
      $flag_id = $this->input->post("flag_id");
      $category_id = $this->input->post("cat_id");
      $get_ebay_id = $this->db2->query("SELECT EBAY_ID FROM LZ_BD_RSS_FEED WHERE FEED_ID = $feed_id");
      if($get_ebay_id->num_rows() > 0 ){
        $ebay = $get_ebay_id->result_array();
        $ebay_id = $ebay[0]['EBAY_ID'];
        //var_dump($ebay_id);
        $path = '/../../../application/views/ebay/shopping/getSingleItem.php';
        include $path;
        return $result;
        //include "getMultipleItem.php";
      }else{
        return 2;
      }

  }  
  public function discard_item(){
      $feed_id = $this->input->post("feed_id");
      $flag_id = $this->input->post("flag_id");
      //$category_id = $this->input->post("cat_id");
      $discrad_feed = $this->db2->query("UPDATE LZ_BD_RSS_FEED SET FLAG_ID = $flag_id WHERE FEED_ID = $feed_id");
      //if($this->db2->_error_message()){
      //  return false;
     // }else{
        return $this->db2->affected_rows();
     // }

  }
  public function fesibility_index(){

  $feed_id  =$this->uri->segment(4);

$query = "SELECT FEED_ID,'SELL THROUGH' FACTOR_NAME, SELL_THROUGH VALUE, SELL_THROUGH FACTOR_PERCENT, SELL_THROUGH_RANK RANK_WEIGHTAGE, SELL_THROUGH_RANK / 100 * SELL_THROUGH RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT EBAY_ID, FEED_ID, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID,  BD.FEED_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM LZ_BD_RSS_FEED BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE FEED_ID = $feed_id UNION ALL SELECT FEED_ID, 'PROFIT %' FACTOR_NAME, P VALUE, KIT_PERCENT FACTOR_PERCENT, PROFIT_PERC_RANK RANK_WEIGHTAGE, PROFIT_PERC_RANK / 100 * KIT_PERCENT RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT EBAY_ID, FEED_ID, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, FACTOR_PERCENT SELL_THROUGH, PROFIT_PERC_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID,  BD.FEED_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM LZ_BD_RSS_FEED BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE FEED_ID = $feed_id UNION ALL SELECT FEED_ID, 'TURNOVER UNITS / Day' FACTOR_NAME, AVG_SOLD_QTY_PER_DAY VALUE, TURN_U_FACT_PERC FACTOR_PERCENT, TURNOVER_D_RANK RANK_WEIGHTAGE, TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT EBAY_ID, FEED_ID, FACTOR_PERCENT SELL_THROUGH, TURNOVER_D_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID,  BD.FEED_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM LZ_BD_RSS_FEED BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE FEED_ID = $feed_id UNION ALL SELECT FEED_ID, 'TURNOVER $ / Day' FACTOR_NAME, AVG_SOLD_VALU_PER_DAY VALUE, TURN_U_FACT_VALUE FACTOR_PERCENT, TURNOVER_UNITS_RANK RANK_WEIGHTAGE, TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE RANK_PERCENTAGE FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, EBAY_ID, FACTOR_PERCENT SELL_THROUGH, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT ACTIV, AV.TRUNOVER_UNIT SOL, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID,  BD.FEED_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, AV.QTY_SOLD QTY_SOLD, BD.CATEGORY_ID, BD.EBAY_ID, SALE_PRICE FROM LZ_BD_RSS_FEED BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE FEED_ID = $feed_id ";


  $fesi_sumary ="SELECT EBAY_ID, MPN, SALE_PRICE, AVERAGE_PRICE, AVG_SOLD_QTY_PER_DAY  PER_DAY_SOLD_QTY, AVG_ACTIV_QTY_PER_DAY PER_DAY_ACTIV_QTY, ITEM_URL, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT AVG_SOLD_QTY_PER_DAY, AVG_ACTIV_QTY_PER_DAY, FEED_ID, AVERAGE_PRICE, EBAY_ID, ITEM_URL, MPN, SALE_PRICE SALE_PRICE, FACTOR_PERCENT SELL_THROUGH, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ACTI.TRUNOVER_UNIT AVG_ACTIV_QTY_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FEED_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.EBAY_ID, BD.ITEM_URL, M.MPN, BD.SALE_PRICE FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI, LZ_CATALOGUE_MT      M WHERE BD.CATALOGUE_MT_ID = M.CATALOGUE_MT_ID AND BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+)) INER_TAB) OUTER_TAB WHERE FEED_ID = $feed_id ";

$query = $this->db2->query($query)->result_array();

$fesi_sumary = $this->db2->query($fesi_sumary)->result_array();


      return array('query' => $query,'fesi_sumary' => $fesi_sumary);
}
  public function qty_detail(){
      $category_id = $this->input->post("category_id");
      
      $catalogue_mt_id = $this->input->post("catalogue_mt_id");
      // $catalogue_mt_id = 106685;
      // var_dump($catalogue_mt_id[0]);exit;
      $condition_id = $this->input->post("condition_id");
      // $category_id = $this->input->post("cat_id");
      $qty_det = $this->db2->query("SELECT EBAY_ID, TITLE, CONDITION_NAME,SALE_PRICE,SHIPPING_COST,TO_CHAR(START_TIME, 'MM/DD/YYYY HH24:MI:SS') AS START_TIME, TO_CHAR(SALE_TIME, 'MM/DD/YYYY HH24:MI:SS') AS SALE_TIME,SELLER_ID FROM LZ_BD_CATAG_DATA_$category_id WHERE SALE_TIME >= SYSDATE - 90 AND VERIFIED = 1 AND CATALOGUE_MT_ID IS NOT NULL AND CATALOGUE_MT_ID = $catalogue_mt_id AND CONDITION_ID = $condition_id")->result_array(); //if($this->db2->_error_message()){
      //  return false;
     // }else{
        return $qty_det;
     // }

  }

  /*==============================
  =            Yousaf methods      =
  ==============================*/
  
  public function getCategories(){
    $sql = "SELECT DISTINCT D.CATEGORY_ID, BD.CATEGORY_NAME FROM LZ_BD_CAT_GROUP_DET D, LZ_BD_CATEGORY BD WHERE  D.CATEGORY_ID = BD.CATEGORY_ID" ;
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    return $query;
  }

  public function getMpns(){

    $category_id = $this->input->post('category_id');
    if($category_id == 182180){
      $sql = "SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID AND M.CATEGORY_ID = $category_id AND O.OBJECT_ID = 100000001";
    }else{
      $sql = "SELECT M.CATALOGUE_MT_ID, M.MPN FROM LZ_BD_OBJECTS_MT O, LZ_CATALOGUE_MT M WHERE O.OBJECT_ID=M.OBJECT_ID AND M.CATEGORY_ID = $category_id";
    }
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    return $query;
  }
  public function saveMpn(){

    $category_id = $this->input->post('category_id');
    $mpn_object = strtoupper($this->input->post('mpn_object'));
    $mpn_object = trim(str_replace("  ", ' ', $mpn_object));
    $mpn_object = str_replace(array("`,′"), "", $mpn_object);
    $mpn_object = str_replace(array("'"), "''", $mpn_object);
    $mpn_brand = strtoupper($this->input->post('mpn_brand'));
    $mpn_brand = trim(str_replace("  ", ' ', $mpn_brand));
    $mpn_brand = str_replace(array("`,′"), "", $mpn_brand);
    $mpn_brand = str_replace(array("'"), "''", $mpn_brand);
    $mpn_input = strtoupper($this->input->post('mpn_input'));
    $mpn_input = trim(str_replace("  ", ' ', $mpn_input));
    $mpn_input = str_replace(array("`,′"), "", $mpn_input);
    $mpn_input = str_replace(array("'"), "''", $mpn_input);
    $mpn_description = $this->input->post('mpn_description');
    $mpn_description = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description = str_replace(array("`,′"), "", $mpn_description);
    $mpn_description = str_replace(array("'"), "''", $mpn_description);
    $lot_upc = trim($this->input->post('lot_upc'));
    $user_id = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


    $sql = "SELECT OBJECT_ID FROM LZ_BD_OBJECTS_MT WHERE UPPER(OBJECT_NAME) = '$mpn_object' AND CATEGORY_ID = $category_id";
    $query = $this->db2->query($sql);
    if($query->num_rows() > 0){
      $query = $query->result_array();
      $object_id = $query[0]['OBJECT_ID'];
    }else{
      $sql = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL";
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $object_id = $query[0]['OBJECT_ID'];

      $sql = "INSERT INTO LZ_BD_OBJECTS_MT (OBJECT_ID,OBJECT_NAME,INSERT_DATE,INSERT_BY,CATEGORY_ID,ITEM_DESC,SHIP_SERV,WEIGHT)VALUES($object_id , '$mpn_object',$insert_date,$user_id,$category_id,NULL,NULL,NULL)";
      $query = $this->db2->query($sql);
    }
    $sql = "SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn_input' AND CATEGORY_ID = $category_id";
    $query = $this->db2->query($sql);
    if($query->num_rows() > 0){
      return 2;//ALREADY EXIST
    }else{
      $sql = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL";
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $catalogue_mt_id = $query[0]['CATALOGUE_MT_ID'];

      $sql = "INSERT INTO LZ_CATALOGUE_MT (CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY, CUSTOM_MPN, OBJECT_ID, MPN_DESCRIPTION, AUTO_CREATED, LAST_RUN_TIME, BRAND, UPC)VALUES($catalogue_mt_id , '$mpn_input',$category_id,$insert_date,$user_id,0,$object_id,'$mpn_description',0,NULL,'$mpn_brand','$lot_upc')";
      $query = $this->db2->query($sql);
      if($query){
        return 1;
      }else{
        return 0;
      }
    }
    //return $query;
  }
  public function loadRssUrls(){
    $requestData= $_REQUEST;
    $columns = array( 
     0 =>'FEED_NAME',
     1 =>'KEYWORD',
     2 =>'CATEGORY_ID',
     3 =>'CATEGORY_NAME',
     4 =>'COND_NAME',
     5 =>'MIN_PRICE',
     6 =>'MAX_PRICE',
     7 =>'LISTING_TYPE'
    );
    $sql ="SELECT F.FEED_URL_ID, F.CATEGORY_ID, BD.CATEGORY_NAME, CD.COND_NAME, F.FEED_NAME,F.KEYWORD, F.MIN_PRICE, F.MAX_PRICE, F.LISTING_TYPE, C.MPN , C.CATALOGUE_MT_ID FROM LZ_BD_RSS_FEED_URL F, LZ_BD_CATEGORY BD, LZ_ITEM_COND_MT CD, LZ_CATALOGUE_MT C WHERE F.CATEGORY_ID = BD.CATEGORY_ID AND F.CONDITION_ID = CD.ID(+) AND F.CATLALOGUE_MT_ID = C.CATALOGUE_MT_ID(+)"; 
    if(!empty(trim($requestData['search']['value']))){   
        // if there is a search parameter, trim($requestData['search']['value']) contains search parameter  
        $sql.=" AND (F.FEED_NAME LIKE '%".trim($requestData['search']['value'])."%' ";    
        $sql.=" OR F.KEYWORD LIKE '%".trim($requestData['search']['value'])."%' ";  
        $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";  
        $sql.=" OR BD.CATEGORY_NAME LIKE '%".trim($requestData['search']['value'])."%' ";  
        $sql.=" OR CD.COND_NAME LIKE '%".trim($requestData['search']['value'])."%' ";  
        $sql.=" OR F.MIN_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";  
        $sql.=" OR F.MAX_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";  
        $sql.=" OR F.LISTING_TYPE LIKE '%".trim($requestData['search']['value'])."%') "; 
    }
     $query           = $this->db2->query($sql);
     $totalData       = $query->num_rows();
     $totalFiltered   = $totalData; 
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100";

    $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
    $sql.= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
    $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir'];
    // echo $sql;  
    /*=====  End of For Oracle 12-c  ======*/
    $query = $this->db2->query($sql);
    $query = $query->result_array();
    $data = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[]   = '<div style="width:80px;"> <button title="Delete" class="btn btn-danger btn-xs delFeedUrl" style="" id="'.@$row['FEED_URL_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> <button title="Run Feed" class="btn btn-primary btn-xs runFeed" style="" id="'.@$row['FEED_URL_ID'].'"><i class="fa fa-download" aria-hidden="true"></i></button> <button title="Edit Feed" class="btn btn-warning btn-xs editFeed" style="" id="'.@$row['FEED_URL_ID'].'"><i class="fa fa-edit" aria-hidden="true"></i></button></div>';

      $nestedData[]   = $row['FEED_NAME'];
      $nestedData[]   = $row['KEYWORD'];
      $nestedData[]   = $row['CATEGORY_ID'];
      $nestedData[]   = $row['CATEGORY_NAME'];
      $nestedData[]   = $row['COND_NAME'];
      $nestedData[]   = '$'.number_format((float)@$row['MIN_PRICE'], 2, '.', '');
      $nestedData[]   = '$'.number_format((float)@$row['MAX_PRICE'], 2, '.', '');
      $nestedData[]   = $row['LISTING_TYPE'];
      $data[]         = $nestedData;
      $i++;
    }
    $json_data = array(
          "draw"                => intval( $requestData['draw'] ),  
          // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
          "recordsTotal"        =>  intval($totalData),  // total number of records
          "recordsFiltered"     => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
          "deferLoading"        =>  intval( $totalFiltered ),
          "data"                => $data   // total data array
          );
    return $json_data;
  }
  public function updateRssUrls(){
    $qry = $this->db2->query("SELECT F.FEED_URL_ID, F.CATEGORY_ID, BD.CATEGORY_NAME, CD.COND_NAME, F.FEED_NAME,F.KEYWORD, F.MIN_PRICE, F.MAX_PRICE, F.LISTING_TYPE, C.MPN, C.CATALOGUE_MT_ID FROM LZ_BD_RSS_FEED_URL F, LZ_BD_CATEGORY     BD, LZ_ITEM_COND_MT    CD, LZ_CATALOGUE_MT    C WHERE F.CATEGORY_ID = BD.CATEGORY_ID AND F.CONDITION_ID = CD.ID AND F.CATLALOGUE_MT_ID = C.CATALOGUE_MT_ID(+) AND F.FEED_URL_ID = (SELECT MAX(FEED_URL_ID ) FROM LZ_BD_RSS_FEED_URL)"); 
    $qry = $qry->result_array();
    return $qry;
  }

  public function addRssUrls(){
    $feedName                 = $this->input->post('feedName');
    $feedName                 = trim(str_replace("  ", ' ', $feedName));
    $feedName                 = str_replace(array("`,′"), "", $feedName);
    $feedName                 = str_replace(array("'"), "''", $feedName);
    $keyword                  = $this->input->post('keyword');
    $keyword                  = trim(str_replace("  ", ' ', $keyword));
    $keyword                  = str_replace(array("`,′"), "", $keyword);
    $keyword                  = str_replace(array("'"), "''", $keyword);
    $excludedWords            = $this->input->post('excludedWords');
    $excludedWords            = trim(str_replace("  ", ' ', $excludedWords));
    $excludedWords            = str_replace(array("`,′"), "", $excludedWords);
    $excludedWords            = str_replace(array("'"), "''", $excludedWords);
    $category_id              = $this->input->post('category_id');
    $catalogue_mt_id          = $this->input->post('catalogue_mt_id');
    $rss_feed_cond            = $this->input->post('rss_feed_cond');
    $rss_listing_type         = $this->input->post('rss_listing_type');
    $min_price                = $this->input->post('min_price');
    $max_price                = $this->input->post('max_price');
    $zipCode                  = $this->input->post('zipCode');
    $withIn                   = $this->input->post('withIn');
    $feed_type                = $this->input->post('feed_type');

    if($withIn == 0){
      $withIn = '';
    }
    $seller_filter            = $this->input->post('seller_filter');
    if($seller_filter == 0){
      $seller_filter = '';
    }
    $seller_name              = $this->input->post('seller_name');

    $created_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $created_date = date("Y-m-d H:i:s");
    $created_date= "TO_DATE('".$created_date."', 'YYYY-MM-DD HH24:MI:SS')";
    $exclude_words = '';
    if (strpos($excludedWords, ',') !== false) {
          $excludedWords = explode(',', $excludedWords);
          //var_dump(count($excludedWords));
          if(count($excludedWords) >2){
            foreach ($excludedWords as $word) {
              $exclude_words .= ' -'.trim($word);
            }
          }else{
               $exclude_words = ' -'.trim($excludedWords[0]);
          }
        }elseif(!empty($excludedWords)){
          $exclude_words = ' -'.$excludedWords;
        }

    $auto_created = 0;
     //var_dump($rss_feed_cond); exit;
    // exit;
    //$dire = __DIR__;
    //$dir = explode('\\', __DIR__);
    //var_dump($dire,$dir[0], $dir[1], $dir[2], $dir[3], $dir[4]); exit;

    foreach ($rss_feed_cond as $feed_cond) {
      $pro_call = $this->db2->query("call pro_verified_mpn_feed_url('$keyword','$catalogue_mt_id','$category_id','$feedName','$feed_cond','$min_price','$max_price','$rss_listing_type','$created_by',$created_date,'$exclude_words',$auto_created,'$withIn','$zipCode','$seller_filter','$seller_name','$feed_type')");
       if($pro_call){

      //$get_feed_id = $this->db2->query("SELECT FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE CATEGORY_ID = $category_id AND CONDITION_ID = $rss_feed_cond AND CATLALOGUE_MT_ID = $catalogue_mt_id AND LISTING_TYPE = '$rss_listing_type' AND MIN_PRICE = '$min_price' AND MAX_PRICE = '$max_price'")->result_array();
      $get_feed_id = $this->db2->query("SELECT FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE CATEGORY_ID = $category_id AND CONDITION_ID = $feed_cond  AND LISTING_TYPE = '$rss_listing_type' AND UPPER(FEED_NAME) = UPPER('$feedName')")->result_array();

      $url_feed_id = $get_feed_id[0]['FEED_URL_ID'];
      ///var_dump($url_feed_id); exit;
      $dir = explode('\\', __DIR__);
      $base_url = $dir[0].'/'.$dir[1].'/'.$dir[2].'/'.$dir[3]; // D:/wamp/www/laptopzone
      if(!empty($url_feed_id)){

        $path = $base_url."/liveRssFeed/lookupFeed/".$url_feed_id.".bat";
        //$path = "D:/wamp/www/laptopzone/liveRssFeed/lookupFeed/".$url_feed_id.'-'.$feedName.".bat";
        if(!is_dir(@$path)){
          $fileData = "@ECHO\nD:\ncd ".$base_url."\nphp index.php cron_job c_cron_job lookup_feed ".$url_feed_id."\nPAUSE";
          $myfile = fopen($path, "w") ;
          fwrite($myfile, $fileData);
          fclose($myfile);
        }
      }else{
            $cat_id = $this->input->post('category_id');

            $path = $base_url."/liveRssFeed/".$cat_id."LiveFeed.bat";
            if(!is_dir(@$path)){
              $fileData = "@ECHO\nD:\ncd ".$base_url."\nphp index.php cron_job c_cron_job cat_rss_feed ".$cat_id."\nPAUSE";
              $myfile = fopen($path, "w") ;
              fwrite($myfile, $fileData);
              fclose($myfile);
            }
      }
      
      $returnVal = true;
    }else{
      $returnVal = false;
    }
    }  ///end main foreach
    return $returnVal;
  }
  
  /*=====  End of Yousaf methods ======*/
  
  /*======================================
  =            Faisal methods            =
  ======================================*/
  
  public function filterDataCategories(){
      $cat_id = $this->input->post("assign_cat_id");

      $query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE,NEWLY_LISTED, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.CATEGORY_ID = $cat_id AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB ORDER BY FEED_ID DESC");
      $feed_data = $query->result_array();

      $categories = $this->db2->query("SELECT DISTINCT F.CATEGORY_ID, C.CATEGORY_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID");
      $cat_id_qry = $categories->result_array();


      return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
  public function CatFilterLookupFeed(){
      $cat_id = $this->input->post("assign_cat_id");

      $query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE,NEWLY_LISTED, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = AV.CONDITION_ID(+) AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID(+) AND BD.CONDITION_ID = ACTI.CONDITION_ID(+) AND BD.CATEGORY_ID = CAT.CATEGORY_ID(+) AND BD.CATEGORY_ID = $cat_id AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB ORDER BY FEED_ID DESC");
      $feed_data = $query->result_array();

      $categories = $this->db2->query("SELECT DISTINCT F.CATEGORY_ID, C.CATEGORY_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID");
      $cat_id_qry = $categories->result_array();


      return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  } 
  public function CatFiltercatAuction(){
    $cat_id = $this->input->post("assign_cat_id");
    $flag_id = 44;

    // $query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST, 0)) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.LINK_CLICKED, F.CATALOGUE_MT_ID, '' SOLD_AVG, '' ACTIVE_AVG, '' QTY_SOLD, '' QTY_ACTIVE, '' SELL_TROUGH, '' EBAY_KEYWORD, '' KEYWORD, '' MIN_PRICE, '' MAX_PRICE, '' KIT_PRICE, '' COND_NAME FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = $flag_id AND F.CATEGORY_ID = $cat_id ORDER BY F.FEED_ID DESC");
    // $feed_data = $query->result_array();

    $query = $this->db2->query("SELECT MAX(F.FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = 44"); 
    $feed_data = $query->result_array();
    
    $categories = $this->db2->query("SELECT F.CATEGORY_ID, C.CATEGORY_NAME, COUNT(1) TOTAL_QTY FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY_TREE C WHERE F.CATEGORY_ID = C.CATEGORY_ID AND F.FLAG_ID = 44 GROUP BY F.CATEGORY_ID, C.CATEGORY_NAME "); 
    $cat_id_qry = $categories->result_array();
    return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry,'selected_cat'=>$cat_id);

  }  

  public function hotRssFeed() {

      //$query = $this->db2->query("SELECT F.*,P.AVG_PRICE,P.QTY_SOLD FROM LZ_BD_RSS_FEED F, MPN_AVG_PRICE_TMP P WHERE  F.CATALOGUE_MT_ID=P.CATALOGUE_MT_ID(+) AND  F.CONDITION_ID = P.CONDITION_ID(+) AND FLAG_ID IS NULL ORDER BY START_TIME DESC");
      $query = $this->db2->query("SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, CATALOGUE_MT_ID, CATEGORY_ID, QTY_SOLD, TO_CHAR(START_TIME,'YYYY-MM-DD HH24:MI:SS') START_TIME, SALE_PRICE SALE_PRICE,NEWLY_LISTED, AVERAGE_PRICE AVG_PRICE, NVL(SELL_THROUGH_RANK / 100 * SELL_THROUGH + PROFIT_PERC_RANK / 100 * KIT_PERCENT + TURNOVER_D_RANK / 100 * TURN_U_FACT_PERC + TURNOVER_UNITS_RANK / 100 * TURN_U_FACT_VALUE, 0) FESIBILITY_INDEX FROM ( /*------- OUTER_TAB START -------- -------------------------------*/ SELECT FEED_ID, CONDITION_ID, ITEM_DESC, ITEM_URL, EBAY_ID, TITLE, CATEGORY_NAME, START_TIME, AVERAGE_PRICE, CATALOGUE_MT_ID, CATEGORY_ID, NVL(QTY_SOLD, 0) QTY_SOLD, SALE_PRICE SALE_PRICE,NEWLY_LISTED, NVL(AVERAGE_PRICE - (SALE_PRICE), 0) LIST_SOLD, NVL(AVERAGE_PRICE * 0.135, 0) KIT_SELLING, NVL(AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0)), 0) P, NVL(ROUND(DECODE(AVERAGE_PRICE, 0, 0, (AVERAGE_PRICE - (SALE_PRICE + NVL(AVERAGE_PRICE * 0.135, 0))) / AVERAGE_PRICE * 100), 2), 0) KIT_PERCENT, ACTIVE_QTY, FACTOR_PERCENT SELL_THROUGH, SELL_THROUGH_RANK, PROFIT_PERC_RANK, TURNOVER_D_RANK, TURNOVER_UNITS_RANK, AVG_SOLD_QTY_PER_DAY, AVG_SOLD_VALU_PER_DAY, GOOD_AVG_SALE_QTY, GOOD_AVG_SALE_VAL, ROUND(DECODE(GOOD_AVG_SALE_QTY, 0, 0, AVG_SOLD_QTY_PER_DAY / GOOD_AVG_SALE_QTY * 100), 2) TURN_U_FACT_PERC, ROUND(DECODE(GOOD_AVG_SALE_VAL, 0, 0, AVG_SOLD_VALU_PER_DAY / GOOD_AVG_SALE_VAL * 100), 2) TURN_U_FACT_VALUE FROM (SELECT (SELECT SUM(DECODE(T.FACTOR_ID, 1, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) SELL_THROUGH_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 2, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) PROFIT_PERC_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 3, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_D_RANK, (SELECT SUM(DECODE(T.FACTOR_ID, 4, T.DEF_WEIGHT_VAL)) FROM LZ_BD_CATAG_FACTOR_DET T WHERE T.CATEGORY_ID = BD.CATEGORY_ID GROUP BY T.CATEGORY_ID) TURNOVER_UNITS_RANK, NVL(ACTI.ACTIVE_QTY, 0) ACTIVE_QTY, AV.TRUNOVER_UNIT AVG_SOLD_QTY_PER_DAY, AV.TURNOVER_VALUE AVG_SOLD_VALU_PER_DAY, ROUND(DECODE(ACTI.TRUNOVER_UNIT, 0, 0, AV.TRUNOVER_UNIT / ACTI.TRUNOVER_UNIT * 100), 2) FACTOR_PERCENT, NVL(CAT.GOOD_AVG_SALE_QTY, 0) GOOD_AVG_SALE_QTY, NVL(CAT.GOOD_AVG_SALE_VAL, 0) GOOD_AVG_SALE_VAL, BD.FLAG_ID, NVL(AV.AVG_PRICE, 0) AVERAGE_PRICE, NVL(AV.QTY_SOLD, 0) QTY_SOLD, NVL(ACTI.AVG_PRICE, 0) ACTIV_AVG, BD.* FROM LZ_BD_RSS_FEED       BD, LZ_BD_CATEGORY       CAT, MPN_AVG_PRICE_TMP        AV, MPN_AVG_PRICE_TMP_ACTIVE ACTI WHERE BD.CATALOGUE_MT_ID = AV.CATALOGUE_MT_ID AND BD.CONDITION_ID = AV.CONDITION_ID AND BD.CATALOGUE_MT_ID = ACTI.CATALOGUE_MT_ID AND BD.CONDITION_ID = ACTI.CONDITION_ID AND BD.CATEGORY_ID = CAT.CATEGORY_ID AND BD.FLAG_ID IS NULL) INER_TAB) OUTER_TAB ORDER BY FEED_ID DESC");
      $feed_data = $query->result_array();
      
      $categories = $this->db2->query("SELECT DISTINCT F.CATEGORY_ID, C.CATEGORY_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID");
      $cat_id_qry = $categories->result_array();
      return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }  
public function lookupFeed() {
  
    $query = $this->db2->query("SELECT MAX(F.FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = 30"); 
    $feed_data = $query->result_array();
    
    $categories = $this->db2->query("SELECT F.CATEGORY_ID, C.CATEGORY_NAME,COUNT(1) TOTAL_QTY FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID AND F.FLAG_ID = 30 GROUP BY F.CATEGORY_ID, C.CATEGORY_NAME "); 
    $cat_id_qry = $categories->result_array();
    return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
  public function autoBuy() {
  
    $query = $this->db2->query("SELECT MAX(F.FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = 41"); 
    $feed_data = $query->result_array();
    
    $categories = $this->db2->query("SELECT F.CATEGORY_ID, C.CATEGORY_NAME,COUNT(1) TOTAL_QTY FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID AND F.FLAG_ID = 41 GROUP BY F.CATEGORY_ID, C.CATEGORY_NAME "); 
    $cat_id_qry = $categories->result_array();
    return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
  public function autoBIN() {
  
    $query = $this->db2->query("SELECT MAX(F.FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = 43"); 
    $feed_data = $query->result_array();
    
    $categories = $this->db2->query("SELECT F.CATEGORY_ID, C.CATEGORY_NAME,COUNT(1) TOTAL_QTY FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID AND F.FLAG_ID = 43 GROUP BY F.CATEGORY_ID, C.CATEGORY_NAME "); 
    $cat_id_qry = $categories->result_array();
    return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
  public function autoBuyAuction() {
  
    $query = $this->db2->query("SELECT MAX(F.FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = 42"); 
    $feed_data = $query->result_array();
    
    $categories = $this->db2->query("SELECT F.CATEGORY_ID, C.CATEGORY_NAME,COUNT(1) TOTAL_QTY FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID AND F.FLAG_ID = 42 GROUP BY F.CATEGORY_ID, C.CATEGORY_NAME "); 
    $cat_id_qry = $categories->result_array();
    return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
    public function catAuction() {
  
    $query = $this->db2->query("SELECT MAX(F.FEED_ID) FEED_ID FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = 44"); 
    $feed_data = $query->result_array();
    
    $categories = $this->db2->query("SELECT F.CATEGORY_ID, C.CATEGORY_NAME,COUNT(1) TOTAL_QTY FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID AND F.FLAG_ID = 44 GROUP BY F.CATEGORY_ID, C.CATEGORY_NAME "); 
    $cat_id_qry = $categories->result_array();
    return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
  public function rss_conditions(){
    return $this->db2->query("SELECT * FROM lz_item_cond_mt")->result_array();
  }

  public function rss_listings(){
    return $this->db2->query("SELECT * FROM LZ_BD_LISTING_TYPES")->result_array();  
  }
  public function getMpnPrice(){
    $mpn                  = $this->input->post('mpn');
    $rss_feed_cond        = $this->input->post('rss_feed_cond');
    if (empty($rss_feed_cond)) {
       $rss_feed_cond[0]=3000;
    }

    return $this->db2->query("SELECT AVG_PRICE,QTY_SOLD FROM MPN_AVG_PRICE_TMP WHERE CATALOGUE_MT_ID = $mpn AND CONDITION_ID = ".$rss_feed_cond[0])->result_array();  
  }
  /*=====  End of Faisal methods  ======*/
   public function update_lookup_feed() {
    $last_feed_id = $this->input->post('last_feed_id');

    if(!empty($last_feed_id)){

      $where = ' AND F.FLAG_ID = 30 and F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' AND F.FLAG_ID = 30 ';
    }

         /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.CATALOGUE_MT_ID, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) AND F.SALE_PRICE < P.AVG_PRICE_SOLD - ((P.AVG_PRICE_SOLD * 0.1025) + 3.25 ) ".$where."ORDER BY FEED_ID DESC"); 

      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  } 
   public function updateAutoBuy() {
    $last_feed_id = $this->input->post('last_feed_id');

    if(!empty($last_feed_id)){

      $where = ' AND F.FLAG_ID = 41 and F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' AND F.FLAG_ID = 41 ';
    }

         /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST,0) ) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID,F.LINK_CLICKED, F.CATALOGUE_MT_ID, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH,'\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') EBAY_KEYWORD, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) ".$where."ORDER BY FEED_ID DESC"); 

      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  } 
   public function updateAutoBIN() {
    $last_feed_id = $this->input->post('last_feed_id');

    if(!empty($last_feed_id)){

      $where = ' AND F.FLAG_ID = 43 and F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' AND F.FLAG_ID = 43 ';
    }

         /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST,0) ) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID,F.LINK_CLICKED, F.CATALOGUE_MT_ID, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH,'\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') EBAY_KEYWORD, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) ".$where."ORDER BY FEED_ID DESC"); 

      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  } 
   public function updateAutoBuyAuction() {
    $last_feed_id = $this->input->post('last_feed_id');

    if(!empty($last_feed_id)){

      $where = ' AND F.FLAG_ID = 42 and F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' AND F.FLAG_ID = 42 ';
    }

         /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST,0) ) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID,F.LINK_CLICKED, F.CATALOGUE_MT_ID, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH,'\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') EBAY_KEYWORD, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) ".$where."ORDER BY FEED_ID DESC"); 

      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  } 
     public function updateCatAuction() {
    $last_feed_id = $this->input->post('last_feed_id');

    if(!empty($last_feed_id)){

      $where = ' WHERE F.FLAG_ID = 44 AND F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' WHERE F.FLAG_ID = 44 ';
    }

         /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST, 0)) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.LINK_CLICKED, F.CATALOGUE_MT_ID, '' SOLD_AVG, '' ACTIVE_AVG, '' QTY_SOLD, '' QTY_ACTIVE, '' SELL_TROUGH, '' EBAY_KEYWORD, '' KEYWORD, '' MIN_PRICE, '' MAX_PRICE, '' KIT_PRICE, '' COND_NAME,F.NOB FROM LZ_BD_RSS_FEED F".$where."ORDER BY F.FEED_ID DESC");
      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
    
      
      /*=====  End of select rss feed  ======*/
  }
public function hotSellingItem(){

    $categoryId  = $this->input->post("categoryId");
    if(!empty($categoryId)){
      $pram_cat = $categoryId;
      $parm_sql = 'AND ';
      $sql = "SELECT * FROM MV_HOT_SELLING_ITEM H ,(SELECT H.CATALOGUE_MT_ID MPN_ID,H.CONDITION_ID COND_ID FROM  MV_HOT_SELLING_ITEM H WHERE H.CATEGORY_ID=$pram_cat MINUS SELECT U.CATLALOGUE_MT_ID,U.CONDITION_ID FROM LZ_BD_RSS_FEED_URL U WHERE U.CATEGORY_ID = $pram_cat AND U.CATLALOGUE_MT_ID IS NOT NULL) UK WHERE H.CATALOGUE_MT_ID = UK.MPN_ID AND H.CONDITION_ID = UK.COND_ID";
    }else{
      $pram_cat = '';
      $parm_sql = 'WHERE ';
      $sql = "SELECT 'NULL' ACTION,H.* FROM  MV_HOT_SELLING_ITEM H ";
    }
    
    $requestData = $_REQUEST;
    //var_dump($cat_id); exit;
    $columns     = array(
      // datatable column index  => database column name
      0 => 'ACTION',
      1 => 'CATEGORY_ID',
      2 => 'MPN',
      3 => 'MPN_DESCRIPTION',
      4 => 'CONDITION_ID',
      5 => 'ACTIVE_AVG',
      6 => 'ACTIVE_QTY',
      7 => 'SOLD_AVG',
      8 => 'SOLD_QTY'
    );
    //$sql = "SELECT 'NULL' ACTION,H.* FROM  MV_HOT_SELLING_ITEM H ".$pram_cat;

    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
    //$sql = "SELECT 'NULL' ACTION,H.* FROM  MV_HOT_SELLING_ITEM H ".$pram_cat; 
    //$sql = "SELECT * FROM MV_HOT_SELLING_ITEM H ,(SELECT H.CATALOGUE_MT_ID,H.CONDITION_ID FROM  MV_HOT_SELLING_ITEM H WHERE H.CATEGORY_ID=$pram_cat MINUS SELECT U.CATLALOGUE_MT_ID,U.CONDITION_ID FROM LZ_BD_RSS_FEED_URL U WHERE U.CATEGORY_ID = $pram_cat AND U.CATLALOGUE_MT_ID IS NOT NULL) UK WHERE H.CATALOGUE_MT_ID = UK.CATALOGUE_MT_ID AND H.CONDITION_ID = UK.CONDITION_ID"; 
    if( !empty(trim($requestData['search']['value'])) ) {
    // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
          $sql.= $parm_sql." ( H.CATEGORY_ID LIKE '%".trim(trim($requestData['search']['value']))."%' ";
          $sql.=" OR H.MPN LIKE '%".trim(trim($requestData['search']['value']))."%' ";  
          $sql.=" OR H.MPN_DESCRIPTION LIKE '%".trim(trim($requestData['search']['value']))."%'";
          $sql.=" OR H.CONDITION_ID LIKE '%".trim(trim($requestData['search']['value']))."%')";
      }
      //$sql.=" ORDER BY TIME_DIFF DESC";
    // when there is no search parameter then total number rows = total number filtered rows. 
    $sql .= " ORDER BY H." . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    //$sql="SELECT * FROM ($sql) WHERE ROWNUM <= 100"; 
    //$sql           = "SELECT  * FROM    (SELECT  q.*, rownum rn FROM  ($sql) q ) WHERE   rn BETWEEN " . $requestData['start'] . " AND " . $requestData['length'];
    $query         = $this->db2->query($sql);
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
   $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
   //print_r($sql);
   //exit;
    //echo $sql;
    /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
    //$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
    $query         = $this->db2->query($sql)->result_array();
   /* $totalData     = $query->num_rows();
    $totalFiltered = $totalData;*/
    $data          = array();
    $i = 1;
    foreach($query as $row ){ 
      $nestedData=array();
      $catalogue_mt_id = $row['CATALOGUE_MT_ID'];
      //$object_name = $row['OBJECT_NAME'];
      //$object_id = $row['OBJECT_ID'];
      //$avg_price = $row['AVG_PRICE'];
      // if(!$data_status){
      //   $fetch_object = '<input style="margin-left: 5px;" type = "button" id = "fetch_object" avg="'.$avg_price.'" name = "'.$i.'" class = "btn btn-info btn-sm fetchobject pull-left" value = "Fetch Object" style="margin-left:12px;">';
      // }else{
      //   $fetch_object = "";
      // }
      $nestedData[] = '<input style="margin-left: 5px;" type = "button" id = "'.$catalogue_mt_id.'"  name = "'.$i.'" class = "btn btn-info btn-sm create_rss pull-left" value = "CREATE URL" style="margin-left:12px;">';
      $nestedData[] = $row['CATEGORY_ID'];
      //$nestedData[] = $row['MPN'];
      $nestedData[] =$row['MPN'];
      $nestedData[] = $row['MPN_DESCRIPTION'];
      $nestedData[] = $row['CONDITION_ID'];
      $nestedData[] =  '$ '.number_format((float)@$row['ACTIVE_AVG'],2,'.',','); 
      $nestedData[] = $row['ACTIVE_QTY'];
      $nestedData[] = '$ '.number_format((float)@$row['SOLD_AVG'],2,'.',','); 
      $nestedData[] = $row['SOLD_QTY']; 
      $data[] = $nestedData;
      $i++ ;
    }
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data" => $data // total data array
    );
    return $json_data;
  }
  public function checkFeed(){
    $catalogue_mt_id = $this->input->post('catalogue_mt_id');
    $qry = $this->db2->query("SELECT F.FEED_NAME,F.KEYWORD FROM LZ_BD_RSS_FEED_URL F WHERE F.CATLALOGUE_MT_ID = $catalogue_mt_id ORDER BY FEED_URL_ID DESC"); 
    $qry = $qry->result_array();
    return $qry;
  }
  public function delRssURL(){
    $feedurlid = $this->input->post('feedUrlId');
    $qry = $this->db2->query("DELETE FROM LZ_BD_RSS_FEED_URL F WHERE F.FEED_URL_ID = $feedurlid"); 
   // $qry = $qry->result_array();
    return $qry;
  }
  public function checkout($ebay_id){
    //$feedurlid = $this->input->post('feedUrlId');
    
    $qry = $this->db2->query("UPDATE LZ_BD_RSS_FEED SET FLAG_ID = 31 WHERE EBAY_ID = $ebay_id");
    
    $path = '/../../../application/views/ebay/trading/lotItemDownload.php';
    include $path;

    //var_dump($result);
    return $result; 
   // $qry = $qry->result_array();
    //return $qry;
  }
  public function update_feed_url(){
    $feedurlid = $this->input->post('feedUrlId');
    $qry = $this->db2->query("SELECT U.*, C.MPN FROM LZ_BD_RSS_FEED_URL U,LZ_CATALOGUE_MT C WHERE U.CATLALOGUE_MT_ID = C.CATALOGUE_MT_ID(+) AND FEED_URL_ID = $feedurlid"); 
   $results = $qry->result_array();
   $conds = $this->db2->query("SELECT * FROM LZ_ITEM_COND_MT")->result_array();
   $ltypes = $this->db2->query("SELECT * FROM LZ_BD_LISTING_TYPES")->result_array();
    return array("results"=>$results,"conds"=>$conds,"ltypes"=>$ltypes);
  }

  public function updateUrl(){
    $feedurlid              = $this->input->post('feedUrlId');
    $feedName               = $this->input->post('feedName');
    $feedName               = trim(str_replace("  ", ' ', $feedName));
    $feedName               = str_replace(array("`,′"), "", $feedName);
    $feedName               = str_replace(array("'"), "''", $feedName);
    $keyWord                = $this->input->post('keyword');
    $keyWord                = trim(str_replace("  ", ' ', $keyWord));
    $keyWord                = str_replace(array("`,′"), "", $keyWord);
    $keyWord                = str_replace(array("'"), "''", $keyWord);
    $excludeWord            = $this->input->post('excludeWord');
    $excludeWord            = trim(str_replace("  ", ' ', $excludeWord));
    $excludeWord            = str_replace(array("`,′"), "", $excludeWord);
    $excludeWord            = str_replace(array("'"), "''", $excludeWord);

    $category_id            = $this->input->post('category_id');
    $catalogue_mt_id        = $this->input->post('catalogue_mt_id');
    $rss_feed_cond          = $this->input->post('rss_feed_cond');
    $rss_listing_type       = $this->input->post('rss_listing_type');
    /////////////////////////////////////
    $withInUpdate           = $this->input->post('withInUpdate');
    $zipCodeUpdate          = $this->input->post('zipCodeUpdate');
    $seller_filter_update   = $this->input->post('seller_filter_update');
    $seller_name_update     = $this->input->post('seller_name_update');
    $rss_feed_type          = $this->input->post('rss_feed_type');
    ////////////////////////////////////
    $exclude_words          = '';
    if(strpos($excludeWord, ',') !== false) {
      $excludeWord = explode(',', $excludeWord);
      //var_dump(count($excludeWord));
      if(count($excludeWord) >1){
        foreach ($excludeWord as $word) {
          if (strpos($word, '-') !== false) {
          $exclude_words .= trim($word);
        }else{
          $exclude_words .= ' -'.trim($word);
        }
          
        }
      }else{
        if (strpos($excludeWord[0], '-') !== false) {
          $exclude_words = trim($excludeWord[0]);
        }else{
          $exclude_words = ' -'.trim($excludeWord[0]);
        }
      }
    }else{
      if (!empty($excludeWord)) {
        if (strpos($excludeWord, '-') !== false) {
          $exclude_words = $excludeWord;
        }else{
          $exclude_words = ' -'.$excludeWord;
        }  
      }
     
    }



    $min_price = $this->input->post('minPrice');
    $max_price = $this->input->post('maxPrice');
    $update_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $update_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    /*===========================================
    =            create rss feed URL            =
    ===========================================*/
    $lvar_rss_url1 = 'https://www.ebay.com/sch/';
    $lvar_rss_url2 = '/i.html?_from=R40' . chr(38) . '_nkw=' . $keyWord.$exclude_words . chr(38) . '_sop=10' . chr(38) . 'rt=nc' . chr(38) . 'LH_'.$rss_listing_type.'=1'; 
    $lvar_rss_url3 = chr(38) . '_udlo=' . $min_price . chr(38) . '_udhi=' . $max_price;
    $lvar_rss_url4 =chr(38) . 'LH_ItemCondition=' . $rss_feed_cond . chr(38) .'_rss=1' . chr(38) . '_mpn=' . $catalogue_mt_id;
    $lvar_final_url = $lvar_rss_url1 . $category_id . $lvar_rss_url2 . $lvar_rss_url3 . $lvar_rss_url4; 

    /*=====  End of create rss feed URL  ======*/



    $qry = $this->db2->query("UPDATE LZ_BD_RSS_FEED_URL SET RSS_FEED_URL= '$lvar_final_url', FEED_NAME = '$feedName', KEYWORD = '$keyWord' , MIN_PRICE = '$min_price' , MAX_PRICE = '$max_price' ,EXCLUDE_WORDS = '$exclude_words', CONDITION_ID = $rss_feed_cond, LISTING_TYPE= '$rss_listing_type' , WITHIN = '$withInUpdate', ZIPCODE = '$zipCodeUpdate', SELLER_FILTER = '$seller_filter_update', FEED_TYPE = '$rss_feed_type', SELLER_NAME = '$seller_name_update', UPDATE_BY = '$update_by', UPDATE_DATE =  $update_date  WHERE  FEED_URL_ID = '$feedurlid'"); 
   //$qry = $qry->result_array();
    return $qry;
  }
  public function localFeed() {
      $query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME , F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, U.FEED_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U WHERE F.FEED_URL_ID= U.FEED_URL_ID(+) AND F.FLAG_ID = 32 ORDER BY FEED_ID DESC"); 
      $feed_data = $query->result_array();
      
      $categories = $this->db2->query("SELECT DISTINCT F.CATEGORY_ID, C.CATEGORY_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID and c.category_id = 177");
      $cat_id_qry = $categories->result_array();
      return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
   public function update_local_feed() {
    $last_feed_id = $this->input->post('last_feed_id');
// flag id is 32 for local feed
    if(!empty($last_feed_id)){

      $where = ' AND F.FLAG_ID = 32 and F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' AND F.FLAG_ID = 32 ';
    }

      /*=======================================
      =            select rss feed            =
      =======================================*/
      //$select_query = $this->db2->query("SELECT F.*, P.AVG_PRICE, P.QTY_SOLD, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE,B.KIT_PRICE FROM LZ_BD_RSS_FEED F, MPN_AVG_PRICE_TMP P, LZ_BD_RSS_FEED_URL U, (SELECT SUM(A.AVG_PRICE) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, MPN_AVG_PRICE_TMP A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) ".$where."ORDER BY FEED_ID DESC"); 
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME , F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, U.FEED_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U WHERE U.FEED_URL_ID = F.FEED_URL_ID ".$where." ORDER BY FEED_ID DESC"); 

      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
      
      /*=====  End of select rss feed  ======*/
  }
  public function categoryFeed() {
      $query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME , F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, U.FEED_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U WHERE F.FEED_URL_ID= U.FEED_URL_ID(+) AND F.FLAG_ID = 33 ORDER BY FEED_ID DESC"); 
      $feed_data = $query->result_array();
      
      $categories = $this->db2->query("SELECT DISTINCT F.CATEGORY_ID, C.CATEGORY_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_CATEGORY C WHERE F.CATEGORY_ID = C.CATEGORY_ID and c.category_id = 177");
      $cat_id_qry = $categories->result_array();
      return array('feed_data'=>$feed_data,'cat_id_qry'=>$cat_id_qry);
  }
   public function update_category_feed() {
    $last_feed_id = $this->input->post('last_feed_id');
// flag id is 32 for local feed
    if(!empty($last_feed_id)){

      $where = ' AND F.FLAG_ID = 33 and F.FEED_ID > '.$last_feed_id;
    }else{
      $last_feed_id = 0;
      $where = ' AND F.FLAG_ID = 33 ';
    }

      /*=======================================
      =            select rss feed            =
      =======================================*/
      $select_query = $this->db2->query("SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME , F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, U.FEED_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U WHERE U.FEED_URL_ID = F.FEED_URL_ID ".$where." ORDER BY FEED_ID DESC"); 

      $feed_data = $select_query->result_array();
      if($select_query->num_rows() > 0){
        return $feed_data;
      }else{
        return 3;
      }
      
      /*=====  End of select rss feed  ======*/
  }
  /*================================================
  =            dell all stream function            =
  ================================================*/
  public function delAllStream() {
    $flag_id = $this->input->post('rss_feed_type');
    $ack = $this->db2->query("DELETE FROM LZ_BD_RSS_FEED F WHERE F.FLAG_ID = $flag_id"); 
      return $ack;
  }
  
  
  /*=====  End of dell all stream function  ======*/
  
//by Danish 

public function loadcategoryfeed()
  {
    $requestData= $_REQUEST;
    $columns = array( 
         0 =>'FEED_ID',
         1 =>'ITEM_DESC',
         2 =>'EBAY_ID',
         3 =>'TITLE',
         4 =>'CATEGORY_ID',
         5 =>'SALE_PRICE',
         6 =>'START_TIME',
         7 =>'FEED_NAME',
         8 =>'NEWLY_LISTED',
         9 =>'FEED_ID'
      );

      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME , F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, U.FEED_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U WHERE F.FEED_URL_ID= U.FEED_URL_ID(+) AND F.FLAG_ID = 33";


        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim($requestData['search']['value'])."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(FEED_NAME) LIKE '%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();
         $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['KEYWORD'];
                     $url5 = '&LH_Complete=1&LH_Sold=1';
                     $final_url = $url1.$url2.$url3.$url4.$url5;
      $nestedData[]         = '
  <div style="display: inline-block; position: relative; width: 200; padding: 4px;"> 

      <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>

<div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
 

 <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.$final_url.'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                    </div>
                     '; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'];
      $nestedData[]         = '<a href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a>';
      $nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['CATEGORY_ID'].' '.'|'.' '.$row['CATEGORY_NAME'];
      $sale_price           = $row['SALE_PRICE'];
      $nestedData[]         = '$'.number_format((float)$sale_price,2,'.',',');
      
      $nestedData[]         =$row['START_TIME'];
      $nestedData[]         = '<button class="btn btn-xs feedName" id="'.$row['FEED_URL_ID'].'">'.$row['FEED_NAME'].'</button>';
      $nestedData[]         = $row['NEWLY_LISTED']; 
      $nestedData[]         = $row['FEED_ID']; 

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }

//end Danish

  // Lookup Feed start 

public function loadlookupfeed()
  {
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'CONDITION_ID',
            4 =>'SOLD_AVG',
            5 =>'ACTIVE_AVG',
            6 =>'KIT_PRICE',
            7 =>'QTY_SOLD',
            8 =>'QTY_ACTIVE',
            9 =>'SELL_TROUGH',
            10 =>'CATEGORY_ID',
            11 =>'CATEGORY_NAME',
            12 =>'SALE_PRICE',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID'
      );

      $where = ' AND F.FLAG_ID = 30 ';
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.CATALOGUE_MT_ID, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) ".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim(trim($requestData['search']['value']))."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         //$sql.=" OR upper(FEED_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         $sql.=" OR AVG_PRICE_SOLD LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['KEYWORD'];
                     $url5 = '&LH_Complete=1&LH_Sold=1';
                     $final_url = $url1.$url2.$url3.$url4.$url5; 

      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 160px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.$final_url.'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                     <div class="similar_link btn btn-info btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Show Similar Item"> 

                      <a style="color:white!important;" class="" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/similarFeed/'.$row['CATALOGUE_MT_ID'].'" target= "_blank" ><i class="fa fa-copy" aria-hidden="true"></i></a> 
                     </div>
                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<a href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
  //end Lookup Feed
  // Lookup autoBuy start 

public function loadAutoBuy()
  {
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'COND_NAME',
            4 =>'SALE_PRICE',
            5 =>'SOLD_AVG',
            6 =>'ACTIVE_AVG',
            7 =>'KIT_PRICE',
            8 =>'QTY_SOLD',
            9 =>'QTY_ACTIVE',
            10 =>'SELL_TROUGH',
            11 =>'CATEGORY_ID',
            12 =>'CATEGORY_NAME',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID'
      );

      $where = ' AND F.FLAG_ID IN (31,41) ';
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST,0)) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.CATALOGUE_MT_ID,F.LINK_CLICKED, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') EBAY_KEYWORD,U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) AND F.SALE_PRICE < P.AVG_PRICE_SOLD - ((P.AVG_PRICE_SOLD * 0.1025) + 3.25 ) ".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim(trim($requestData['search']['value']))."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         //$sql.=" OR upper(FEED_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         $sql.=" OR AVG_PRICE_SOLD LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR UPPER(COND_NAME) LIKE UPPER('%".trim($requestData['search']['value'])."%') ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
            if($row['LINK_CLICKED'] > 0){
              $viewed_tr = 'class = "viewed"';
            }else{
               $viewed_tr = '';
            }
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['EBAY_KEYWORD'].'+-LOT+-EMPTY';
                     $url5 = '&LH_Complete=1&LH_Sold=1&LH_PrefLoc=1';
                     $sold_history_url = $url1.$url2.$url3.$url4.$url5;
                     $url5 = '&LH_PrefLoc=1';
                     $active_item_url = $url1.$url2.$url3.$url4.$url5;


      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 160px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.htmlentities($sold_history_url).'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                     <div class="similar_link btn btn-info btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Show Similar Item"> 

                      <a style="color:white!important;" class="" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/similarFeed/'.$row['CATALOGUE_MT_ID'].'" target= "_blank" ><i class="fa fa-copy" aria-hidden="true"></i></a> 
                     </div>
                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<div '.$viewed_tr.'><a id = "'.$row['FEED_ID'].'" class="ebay_link" href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a></div>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($sold_history_url).'" target= "_blank" >'.number_format((float)@$row['SOLD_AVG'],2,'.',',').'</a>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($active_item_url).'" target= "_blank" >'.number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</a>';
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
  //end autoBuy
   // Lookup Local start 
public function loadAutoBuyAuction()
  {
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'COND_NAME',
            4 =>'SALE_PRICE',
            5 =>'SOLD_AVG',
            6 =>'ACTIVE_AVG',
            7 =>'KIT_PRICE',
            8 =>'QTY_SOLD',
            9 =>'QTY_ACTIVE',
            10 =>'SELL_TROUGH',
            11 =>'CATEGORY_ID',
            12 =>'CATEGORY_NAME',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID'
      );

      $where = ' AND F.FLAG_ID IN (31,42) ';
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST,0)) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.CATALOGUE_MT_ID,F.LINK_CLICKED, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') EBAY_KEYWORD,U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) ".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim(trim($requestData['search']['value']))."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         //$sql.=" OR upper(FEED_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         $sql.=" OR AVG_PRICE_SOLD LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR UPPER(COND_NAME) LIKE UPPER('%".trim($requestData['search']['value'])."%') ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
            if($row['LINK_CLICKED'] > 0){
              $viewed_tr = 'class = "viewed"';
            }else{
               $viewed_tr = '';
            }
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['EBAY_KEYWORD'].'+-LOT+-EMPTY';
                     $url5 = '&LH_Complete=1&LH_Sold=1&LH_PrefLoc=1';
                     $sold_history_url = $url1.$url2.$url3.$url4.$url5;
                     $url5 = '&LH_PrefLoc=1';
                     $active_item_url = $url1.$url2.$url3.$url4.$url5;



      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 180px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.htmlentities($sold_history_url).'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                     <div class="similar_link btn btn-info btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Show Similar Item"> 

                      <a style="color:white!important;" class="" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/similarFeed/'.$row['CATALOGUE_MT_ID'].'" target= "_blank" ><i class="fa fa-copy" aria-hidden="true"></i></a> 
                      <button title="Items to Estimate" class="btn btn-primary btn-xs find_item m-l-5 m-r-5" style="" id="'.$row['EBAY_ID'].'"><i class="fa fa-download" aria-hidden="true"></i></button>
                     </div>

                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<div '.$viewed_tr.'><a id = "'.$row['FEED_ID'].'" class="ebay_link" href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a></div>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($sold_history_url).'" target= "_blank" >'.number_format((float)@$row['SOLD_AVG'],2,'.',',').'</a>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($active_item_url).'" target= "_blank" >'.number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</a>';
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
  public function loadCatAuction()
  {
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'COND_NAME',
            4 =>'SALE_PRICE',
            5 =>'SOLD_AVG',
            6 =>'ACTIVE_AVG',
            7 =>'KIT_PRICE',
            8 =>'QTY_SOLD',
            9 =>'QTY_ACTIVE',
            10 =>'SELL_TROUGH',
            11 =>'CATEGORY_ID',
            12 =>'CATEGORY_NAME',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID',
            18 => 'NOB'
      );

      $where = ' WHERE F.FLAG_ID IN (31,44) ';
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + F.SHIP_COST) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.LINK_CLICKED, F.CATALOGUE_MT_ID, '' SOLD_AVG, '' ACTIVE_AVG, '' QTY_SOLD, '' QTY_ACTIVE, '' SELL_TROUGH, '' EBAY_KEYWORD, '' KEYWORD, '' MIN_PRICE, '' MAX_PRICE, '' KIT_PRICE, '' COND_NAME , F.NOB FROM LZ_BD_RSS_FEED F".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim(trim($requestData['search']['value']))."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR F.NOB LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         // $sql.=" OR AVG_PRICE_SOLD LIKE '%".trim($requestData['search']['value'])."%' "; 
         // $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         // $sql.=" OR UPPER(COND_NAME) LIKE UPPER('%".trim($requestData['search']['value'])."%') ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
            if($row['LINK_CLICKED'] > 0){
              $viewed_tr = 'class = "viewed"';
            }else{
               $viewed_tr = '';
            }
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['EBAY_KEYWORD'].'+-LOT+-EMPTY';
                     $url5 = '&LH_Complete=1&LH_Sold=1&LH_PrefLoc=1';
                     $sold_history_url = $url1.$url2.$url3.$url4.$url5;
                     $url5 = '&LH_PrefLoc=1';
                     $active_item_url = $url1.$url2.$url3.$url4.$url5;



      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 180px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.htmlentities($sold_history_url).'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                     <div class="similar_link btn btn-info btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Show Similar Item"> 

                      <a style="color:white!important;" class="" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/similarFeed/'.$row['CATALOGUE_MT_ID'].'" target= "_blank" ><i class="fa fa-copy" aria-hidden="true"></i></a> 
                      <button title="Items to Estimate" class="btn btn-primary btn-xs find_item m-l-5 m-r-5" style="" id="'.$row['EBAY_ID'].'"><i class="fa fa-download" aria-hidden="true"></i></button>
                     </div>

                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<div '.$viewed_tr.'><a id = "'.$row['FEED_ID'].'" class="ebay_link" href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a></div>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($sold_history_url).'" target= "_blank" >'.number_format((float)@$row['SOLD_AVG'],2,'.',',').'</a>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($active_item_url).'" target= "_blank" >'.number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</a>';
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];
    $nestedData[]    = $row['NOB'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
  public function loadCatAuctionFilter()
  {
    $cat_id = $this->input->post("cat_id");
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'COND_NAME',
            4 =>'SALE_PRICE',
            5 =>'SOLD_AVG',
            6 =>'ACTIVE_AVG',
            7 =>'KIT_PRICE',
            8 =>'QTY_SOLD',
            9 =>'QTY_ACTIVE',
            10 =>'SELL_TROUGH',
            11 =>'CATEGORY_ID',
            12 =>'CATEGORY_NAME',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID',
            18 => 'NOB'
      );

      $where = " WHERE F.FLAG_ID IN (31,44) AND F.CATEGORY_ID = $cat_id ";
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE+F.SHIP_COST) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.LINK_CLICKED, F.CATALOGUE_MT_ID, '' SOLD_AVG, '' ACTIVE_AVG, '' QTY_SOLD, '' QTY_ACTIVE, '' SELL_TROUGH, '' EBAY_KEYWORD, '' KEYWORD, '' MIN_PRICE, '' MAX_PRICE, '' KIT_PRICE, '' COND_NAME,F.NOB FROM LZ_BD_RSS_FEED F".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim(trim($requestData['search']['value']))."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR NOB LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         // $sql.=" OR AVG_PRICE_SOLD LIKE '%".trim($requestData['search']['value'])."%' "; 
         // $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         // $sql.=" OR UPPER(COND_NAME) LIKE UPPER('%".trim($requestData['search']['value'])."%') ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
            if($row['LINK_CLICKED'] > 0){
              $viewed_tr = 'class = "viewed"';
            }else{
               $viewed_tr = '';
            }
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['EBAY_KEYWORD'].'+-LOT+-EMPTY';
                     $url5 = '&LH_Complete=1&LH_Sold=1&LH_PrefLoc=1';
                     $sold_history_url = $url1.$url2.$url3.$url4.$url5;
                     $url5 = '&LH_PrefLoc=1';
                     $active_item_url = $url1.$url2.$url3.$url4.$url5;



      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 180px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.htmlentities($sold_history_url).'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                     <div class="similar_link btn btn-info btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Show Similar Item"> 

                      <a style="color:white!important;" class="" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/similarFeed/'.$row['CATALOGUE_MT_ID'].'" target= "_blank" ><i class="fa fa-copy" aria-hidden="true"></i></a> 
                      <button title="Items to Estimate" class="btn btn-primary btn-xs find_item m-l-5 m-r-5" style="" id="'.$row['EBAY_ID'].'"><i class="fa fa-download" aria-hidden="true"></i></button>
                     </div>

                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<div '.$viewed_tr.'><a id = "'.$row['FEED_ID'].'" class="ebay_link" href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a></div>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($sold_history_url).'" target= "_blank" >'.number_format((float)@$row['SOLD_AVG'],2,'.',',').'</a>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($active_item_url).'" target= "_blank" >'.number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</a>';
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];
    $nestedData[]    = $row['NOB'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
public function loadAutoBIN()
  {
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'COND_NAME',
            4 =>'SALE_PRICE',
            5 =>'SOLD_AVG',
            6 =>'ACTIVE_AVG',
            7 =>'KIT_PRICE',
            8 =>'QTY_SOLD',
            9 =>'QTY_ACTIVE',
            10 =>'SELL_TROUGH',
            11 =>'CATEGORY_ID',
            12 =>'CATEGORY_NAME',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID'
      );

      $where = ' AND F.FLAG_ID IN (31,43) ';
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, (F.SALE_PRICE + NVL(F.SHIP_COST,0)) SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.CATALOGUE_MT_ID,F.LINK_CLICKED, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH, '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.KEYWORD)), '#|&', ''), ' ', '\"+\"') || '\"' || REPLACE(REGEXP_REPLACE(TRIM(UPPER(U.EXCLUDE_WORDS)), '#|&', ''), ' ', '+') EBAY_KEYWORD,U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) ".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim(trim($requestData['search']['value']))."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         //$sql.=" OR upper(FEED_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         $sql.=" OR AVG_PRICE_SOLD LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR UPPER(COND_NAME) LIKE UPPER('%".trim($requestData['search']['value'])."%') ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
            if($row['LINK_CLICKED'] > 0){
              $viewed_tr = 'class = "viewed"';
            }else{
               $viewed_tr = '';
            }
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['EBAY_KEYWORD'].'+-LOT+-EMPTY';
                     $url5 = '&LH_Complete=1&LH_Sold=1&LH_PrefLoc=1';
                     $sold_history_url = $url1.$url2.$url3.$url4.$url5;
                     $url5 = '&LH_PrefLoc=1';
                     $active_item_url = $url1.$url2.$url3.$url4.$url5;


      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 160px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.htmlentities($sold_history_url).'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                     <div class="similar_link btn btn-info btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Show Similar Item"> 

                      <a style="color:white!important;" class="" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/similarFeed/'.$row['CATALOGUE_MT_ID'].'" target= "_blank" ><i class="fa fa-copy" aria-hidden="true"></i></a> 
                     </div>
                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<div '.$viewed_tr.'><a id = "'.$row['FEED_ID'].'" class="ebay_link" href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a></div>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($sold_history_url).'" target= "_blank" >'.number_format((float)@$row['SOLD_AVG'],2,'.',',').'</a>';
      $nestedData[]         =  '<a style="color:red!important; font-weight: bold;" href="'.htmlentities($active_item_url).'" target= "_blank" >'.number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</a>';
      //$nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
public function loadlocalfeed()
  {
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            3 =>'TITLE',
            4 =>'CATEGORY_ID',
            5 =>'SALE_PRICE',
            6 =>'START_TIME',
            7 =>'FEED_NAME',
            8 =>'NEWLY_LISTED',
            9 =>'FEED_ID'
      );

      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME , F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, U.FEED_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U WHERE F.FEED_URL_ID= U.FEED_URL_ID(+) AND F.FLAG_ID = 32";


        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim($requestData['search']['value'])."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(FEED_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       

            $i = 1; 
            if(!empty(@$row['AVG_PRICE'])){
              $verified_tr = 'class = "verifiedTr"';
            }else{
              $verified_tr = 'class = ""';
            }
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['KEYWORD'];
                     $url5 = '&LH_Complete=1&LH_Sold=1';
                     $final_url = $url1.$url2.$url3.$url4.$url5; 

      $nestedData[]         = '<div style="display: inline-block; position: relative; width: 200; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.@$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.@$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'. @$final_url.'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.@$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.@$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].'</div>';
      $nestedData[]         = '<a href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a>';
      $nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['CATEGORY_ID'].' '.'|'.' '.$row['CATEGORY_NAME'];
      $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
      $nestedData[]    = $row['START_TIME'];
      $nestedData[]    = '<button class="btn btn-xs feedName" id="'. @$row['FEED_URL_ID'].'">'.@$row['FEED_NAME'].'</button>
                         ';
      $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
  //end Local Feed
public function loadSimilarFeed()
  {
    $catalogue_mt_id = $this->input->post('catalogue_mt_id');
    $requestData= $_REQUEST;
     $columns = array( 
            0 =>'FEED_ID',
            1 =>'ITEM_DESC',
            2 =>'EBAY_ID',
            //3 =>'TITLE',
            3 =>'CONDITION_ID',
            4 =>'SOLD_AVG',
            5 =>'ACTIVE_AVG',
            6 =>'KIT_PRICE',
            7 =>'QTY_SOLD',
            8 =>'QTY_ACTIVE',
            9 =>'SELL_TROUGH',
            10 =>'CATEGORY_ID',
            11 =>'CATEGORY_NAME',
            12 =>'SALE_PRICE',
            13 =>'START_TIME',
            14 =>'KEYWORD',
            15 =>'MAX_PRICE',
            16 =>'NEWLY_LISTED',
            17 =>'FEED_ID'
      );

      $where = ' AND F.FLAG_ID = 30 ';
      $sql = "SELECT F.FEED_ID, F.EBAY_ID, F.TITLE, F.ITEM_DESC, TO_CHAR(F.START_TIME, 'DD-MM-YYYY HH24:MI:SS') AS START_TIME, F.ITEM_URL, F.SALE_PRICE, F.CATEGORY_ID, F.CATEGORY_NAME, F.CONDITION_ID, F.NEWLY_LISTED, F.FEED_URL_ID, F.CATALOGUE_MT_ID, P.AVG_PRICE_SOLD SOLD_AVG, P.AVG_PRICE_ACTIVE ACTIVE_AVG, P.QTY_SOLD, P.QTY_ACTIVE, ROUND((P.QTY_SOLD / DECODE(P.QTY_ACTIVE, 0, 1, P.QTY_ACTIVE)) * 100) SELL_TROUGH, U.KEYWORD, U.MIN_PRICE, U.MAX_PRICE, B.KIT_PRICE, NVL(C.COND_NAME,U.CONDITION_ID) COND_NAME FROM LZ_BD_RSS_FEED F, LZ_BD_RSS_FEED_URL U, LZ_BD_API_AVG_PRICE P, (SELECT MAX(P.API_AVG_PRICE_ID) API_AVG_PRICE_ID, P.CATALOGUE_MT_ID, P.CONDITION_ID FROM LZ_BD_API_AVG_PRICE P GROUP BY CATALOGUE_MT_ID, CONDITION_ID) PP, LZ_ITEM_COND_MT C, (SELECT SUM(A.AVG_PRICE_SOLD) KIT_PRICE, M.CATALOGUE_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_BD_API_AVG_PRICE A WHERE A.CONDITION_ID = 3000 AND A.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID GROUP BY M.CATALOGUE_MT_ID) B WHERE F.CATALOGUE_MT_ID = P.CATALOGUE_MT_ID(+) AND U.FEED_URL_ID = F.FEED_URL_ID AND F.CONDITION_ID = P.CONDITION_ID(+) AND F.CATALOGUE_MT_ID = B.CATALOGUE_MT_ID(+) AND P.API_AVG_PRICE_ID = PP.API_AVG_PRICE_ID AND U.CONDITION_ID = C.ID(+) AND U.CATLALOGUE_MT_ID = $catalogue_mt_id".$where."";
        if(!empty(trim($requestData['search']['value']))){
      // if there is a search parameter, trim($requestData['search']['value']) contains search parameter
         $sql.=" AND(EBAY_ID LIKE '%".trim($requestData['search']['value'])."%'";
         $sql.=" OR upper(TITLE) LIKE upper('%".trim($requestData['search']['value'])."%' )";  
         $sql.=" OR F.CATEGORY_ID LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(F.CATEGORY_NAME) LIKE upper('%".trim($requestData['search']['value'])."%')";   
         $sql.=" OR SALE_PRICE LIKE'%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR upper(FEED_NAME) LIKE upper('%".trim($requestData['search']['value'])."%') "; 
         $sql.=" OR upper(ITEM_DESC) LIKE upper('%".trim($requestData['search']['value'])."%' )"; 
         $sql.=" OR AVG_PRICE LIKE '%".trim($requestData['search']['value'])."%' "; 
         $sql.=" OR KIT_PRICE LIKE '%".trim($requestData['search']['value'])."%' ";   
         $sql.=" OR FEED_ID LIKE '%".trim($requestData['search']['value'])."%' )";
       }
      $sql .= "ORDER BY F.FEED_ID DESC";
    $query = $this->db2->query($sql);
      $totalData = $query->num_rows();
      $totalFiltered = $totalData; 
   
      $sql = "SELECT  * FROM (SELECT  q.*, rownum rn FROM  ($sql) q )";
      $sql .= " WHERE   ROWNUM <= ".$requestData['length']." AND rn>= ".$requestData['start'];
      $sql.=" ORDER BY  ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'];  
      /*=====  End of For Oracle 12-c  ======*/
      $query = $this->db2->query($sql);
      $query = $query->result_array();
      $data = array();
      $i =0;
      foreach($query as $row ){ 
      $nestedData           = array();       
                $i = 1; 
            // $it_condition = $row['CONDITION_ID'];
                    
            //   if($it_condition == 3000){
            //     $it_condition = 'Used';
            //   }elseif($it_condition == 1000){
            //     $it_condition = 'New'; 
            //   }elseif($it_condition == 1500){
            //     $it_condition = 'New other'; 
            //   }elseif($it_condition == 2000){
            //       $it_condition = 'Manufacturer refurbished';
            //   }elseif($it_condition == 2500){
            //     $it_condition = 'Seller refurbished'; 
            //   }elseif($it_condition == 7000){
            //     $it_condition = 'For parts or not working'; 
            //   }else{
            //     $it_condition = '';
            //   }

           

            if($row['SOLD_AVG'] > 0){
                $margin = $row['SOLD_AVG']*10/100;//sale amount<10% of sold ammount than change bg color of that tr
                $offer_yn = $row['SOLD_AVG'] - $margin;
                if($row['SALE_PRICE'] <= $offer_yn){
                  $verified_tr = 'class = "verified"';
                }else{
                  $verified_tr = 'class = ""';
                }
            }else{
              $verified_tr = 'class = ""';
            } 
                     $url1 = 'https://www.ebay.com/sch/';
                     $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
                     $cat_id = @$row['CATEGORY_ID'];
                     $url2 = $cat_name.'/'.$cat_id.'/';
                     $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
                     $url4 = '&_nkw='.@$row['KEYWORD'];
                     $url5 = '&LH_Complete=1&LH_Sold=1';
                     $final_url = $url1.$url2.$url3.$url4.$url5; 

      $nestedData[]         = '<div '.$verified_tr.' style="display: inline-block; position: relative; width: 130px; padding: 4px;">
                     <div class="trash_button" style="float: left;padding-right: 5px;" id="'.$row['FEED_ID'].'_20"> 
                      <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'.$row['FEED_ID'].'" fid="20" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-trash-o text text-center" aria-hidden="true">
                        </i> 
                      </button> 
                     </div>
                     <div class="usd_button" style="float: left; padding-right: 5px;" id="'.$row['FEED_ID'].'_23"> 
                      <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'.$row['FEED_ID'].'" fid="23" ct_id="'.$row['CATEGORY_ID'].'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
                      </button> 
                     </div>
                     <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px!important;width: 25px!important;color:white!important;" id="" title = "Sold History"> 

                      <a style="color:white!important; " href="'.$final_url.'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
                     </div>

                   
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " class="eBayCheckout" id="'.$row['EBAY_ID'].'" href="'.base_url().'rssfeed/c_rssfeed/checkout/'.$row['EBAY_ID'].'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
                    </div>'; 
      $nestedData[]         = '<div class = "item_desc" id="link_other" style="width: 300px;">'.$row['ITEM_DESC'].$row['TITLE'].'</div>';
      
      $nestedData[]         = '<a href="'.@$row['ITEM_URL'].'" target= "_blank" >'. @$row['EBAY_ID'].'</a>';
      //$nestedData[]         = $row['TITLE'];
      $nestedData[]         = $row['COND_NAME'];
      $nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['SOLD_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '<p style="color:red; font-weight: bold;">$ '. number_format((float)@$row['ACTIVE_AVG'],2,'.',',').'</p>';
      $nestedData[]         =  '$ '. number_format((float)@$row['KIT_PRICE'],2,'.',',');
      $qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
                  
      $nestedData[]  =  '<button class="btn btn-xs btn-link qty_sold" id="qty_sold '.$i.'">'.@$row['QTY_SOLD'].'</button>
                    <input type="hidden" id="category_id_'. $i.'" value="'.$row["CATEGORY_ID"].'">
                    <input type="hidden" id="catalogue_mt_id_'. $i.'" value="'.$row["CATALOGUE_MT_ID"].'">
                    <input type="hidden" id="condition_id_'. $i.'" value="'.$row["CONDITION_ID"].'">';
      //$nestedData[]         = $row['QTY_SOLD'];
      $nestedData[]         = $row['QTY_ACTIVE'];
      $nestedData[]         = $row['SELL_TROUGH'];


      

    $nestedData[]    = $row['CATEGORY_ID'];
    $nestedData[]    = $row['CATEGORY_NAME'];
    $nestedData[]    = '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',');
    $nestedData[]    = $row['START_TIME'];
    $nestedData[]    = '<button class="btn-link feedKeyword" id="'.@$row['FEED_URL_ID'].'"> '.@$row['KEYWORD'].'</button>';
    $nestedData[]    = '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',');
    $nestedData[]    = $row['NEWLY_LISTED'];
    $nestedData[]    = $row['FEED_ID'];

      $data[]               = $nestedData;
        $i++;
      }

      $json_data = array(
            "draw"            => intval($requestData['draw']), 
            // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    =>  intval($totalData),  
            // total number of records
            "recordsFiltered" => intval($totalFiltered), 
            // total number of records after searching, if there is no searching then totalFiltered = totalData
            "deferLoading"    =>  intval($totalFiltered),
            "data"            => $data   // total data array
            );
      //var_dump('expression'); exit;
      return $json_data;  
  }
public function markedAsView()
  {
    $feed_id = $this->input->post("feedId");
     $qry = $this->db2->query("UPDATE LZ_BD_RSS_FEED SET LINK_CLICKED = 1 WHERE FEED_ID = $feed_id");
     return $qry;
  }
 }