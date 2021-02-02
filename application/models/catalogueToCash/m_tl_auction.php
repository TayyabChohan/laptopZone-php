
<?php  
  class m_tl_auction extends CI_Model{
    public function __construct(){
    parent::__construct();
    $this->load->database();
  }


  public function del_audit_barcode(){

    $bar = $this->input->post('bar_no');
    $insert_by = $this->session->userdata('user_id');
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $audi_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET EBAY_STICKER = 1, AUDIT_DATETIME = $audi_date, AUDIT_BY = $insert_by WHERE BARCODE_NO = $bar");

    if($query){
      return true;
    }else{

      return false;
    }
  }

  public function move_data(){ 

    $get_auc_uri_id = $this->input->post('get_auc_uri_id');

      $insert_by = $this->session->userdata('user_id');

      $dupi_check = $this->db2->query(" SELECT * FROM LZ_AUCTION_MT MT WHERE MT.VENDOR_AUCTION_ID    IN (SELECT T.EBAY_ID  VENDOR_AUCTION_ID FROM LZ_BD_ACTIVE_DATA_111222333444 T, LZ_AUCTION_MT M,LZ_BD_ESTIMATE_MT MM WHERE T.EBAY_ID = M.VENDOR_AUCTION_ID AND MM.LZ_BD_CATAG_ID = T.LZ_BD_CATA_ID) AND MT.LZ_AUCTION_ID = $get_auc_uri_id   ")->result_array();

      if(count($dupi_check) == 0){
        $get_count =  $this->db2->query( "  SELECT COUNT(OBJ) O,COUNT(CAT) C FROM ( SELECT Q1.* FROM (SELECT DECODE(D.OBJECT_NAME, NULL, '0', D.OBJECT_NAME) OBJ, DECODE(D.CATEGORY_ID, NULL, '0', D.CATEGORY_ID) CAT FROM LZ_AUCTION_DET D WHERE D.LZ_AUCTION_ID = $get_auc_uri_id) Q1 WHERE (OBJ='0' OR  CAT ='0')) ")->result_array() ;
    $obj = $get_count[0]['O'];
    $cat = $get_count[0]['C'];

    if($obj == 0 && $cat == 0){ 
    $proc = $this->db2->query( "CALL pro_move_auction($get_auc_uri_id,$insert_by)" ); 
    if($proc){
 
    return true;
    }

    }else{
      return false;
    }


      }else{

        return false;
      }
    


  } 
 
  public function auction_master_det(){

    $mast_det = " SELECT AU.LZ_AUCTION_DET_ID,AU.LZ_AUCTION_ID, AU.VENDOR_AUCTION_ID, AU.AUCTION_DESCRIPTION,AU.CONDITION,AU.TIME_LEFT, AU.CURRENT_BID, AU.NO_OF_ITEM, AU.AUCTION_URL, AU.INSERTION_DATE FROM LZ_AUCTION_MT AU  ";
    return array('mast_det' => $mast_det);


  }

  public function load_auction_detail_data(){

    $lz_auction_id = $this->uri->segment(4);

    $auc_key = strtoupper(trim($this->input->post('auc_key')));
    
    $auc_key = trim(str_replace("  ", ' ', $auc_key));
    $auc_key = str_replace(array("`,′"), "", $auc_key);
    $auc_key = str_replace(array("'"), "''", $auc_key);

    $str = explode(' ', $auc_key);

    $this->session->set_userdata('auc_key', $auc_key);
    
    $prof_perc = $this->input->post('prof_perc');
    
    if(empty($prof_perc)){
      $prof_perc = 30;
    }
    $this->session->set_userdata('prof_perc', $prof_perc);
    $searchRadio = $this->input->post('searchRadio');
    $this->session->set_userdata('searchRadio', $searchRadio);

    $mast_det =  $this->db2->query("SELECT MAX(M.AUCTION_URL) AUCTION_URL,MAX(M.LZ_AUCTION_ID)  LZ_AUCTION_ID, MAX(M.VENDOR_AUCTION_ID) VENDOR_AUCTION_ID, MAX(M.AUCTION_DESCRIPTION) AUCTION_DESCRIPTION, MAX(M.CONDITION) CONDITION, TO_CHAR(TO_DATE(MAX(M.TIME_LEFT), 'DD-MM-YY HH:MI:SS\"000000\" AM'),'DD-MM-YYYY HH24:MI:SS') TIME_LEFT, nvl(MAX(M.CURRENT_BID),0) CURRENT_BID, nvl(MAX(M.NO_OF_ITEM),0) NO_OF_ITEM, nvl(SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY),0) EST_SALE, nvl(ROUND((8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100),2),0) EBAY, nvl(ROUND((2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100),2),0) PAYPAL,  nvl(round(sum(d.ship_fee * d.quantity),2),0) ship_fee, nvl(ROUND((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)),2),0) NET_AMOUNT, nvl(ROUND(((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)) - $prof_perc * (SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100)),2),0) OFFER_ON_NET_AMOUNT, nvl(SUM(D.QTY_SOLD),0) QTY_SOLD, nvl(ROUND((SUM(D.QTY_SOLD)/NVL(MAX(M.NO_OF_ITEM),1)),2),0) SELL_THROU, nvl(ROUND(SUM(D.WATCH_COUNT)/NVL(MAX(M.NO_OF_ITEM),1),2),0) WATCH_COUNT_AVG,SUM(D.WEIGHT * D.QUANTITY) TOTAL_WEIGHT FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID /*AND M.PROCESSED = 1 */  /*ORDER BY (SUM(D.QTY_SOLD)/MAX(M.NO_OF_ITEM))*100 DESC */and M.LZ_AUCTION_ID = $lz_auction_id GROUP BY M.LZ_AUCTION_ID ")->result_array();      

    $auc_detail_qry = " SELECT D.ITEM_DESCRIPTION, D.MPN, D.QUANTITY, decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) AVG_SOLD_PRICE, D.QTY_SOLD, D.UPC, D.SKU,  DECODE(D.BBY_UPC,NULL,D.UPC,D.BBY_UPC) BEST_BUY_UPC, DECODE(D.BBY_MPN,NULL,D.MPN,D.BBY_MPN) BEST_BUY_MPN, D.LZ_AUCTION_DET_ID, D.LZ_AUCTION_ID, D.EST_MSRP, D.INSERTION_DATE, D.CATEGORY_ID, D.PRICE_UPDATED, D.API_URL, D.ERROR_MSG, D.LINE_PROCESSED,D.OBJECT_NAME,D.WEIGHT,D.BRAND,decode((SELECT item_type FROM LZ_BD_ITEM_TYPE WHERE sku = d.sku), NULL, (SELECT brand_type FROM lz_bd_brand_type WHERE upper(brand) = upper(d.brand)), (SELECT item_type FROM LZ_BD_ITEM_TYPE WHERE sku = d.sku)) ITEM_TYPE FROM LZ_AUCTION_DET D WHERE D.LZ_AUCTION_ID = $lz_auction_id"; 
    // if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
    //     if (count($str)>1) {
    //       $i=1;
    //       foreach ($str as $key) {
    //         if($i === 1){
    //           $auc_detail_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
    //         }else{
    //           $auc_detail_qry.=" AND (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
    //         }
    //         $i++;
    //       }
    //     }else{
    //       $auc_detail_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
    //     }
    //       }
    if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
        if (count($str)>1) {

          foreach ($str as $key) {
            if($searchRadio == "Brand"){
              $auc_detail_qry.=" and UPPER(D.BRAND) LIKE '%$key%'";
            }elseif ($searchRadio == "Desc") {
              $auc_detail_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%'";
            }elseif ($searchRadio == "Both") {
              $auc_detail_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
            }
          }
        }else{
          if($searchRadio == "Brand"){
              $auc_detail_qry.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $auc_detail_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $auc_detail_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }

        }
    }else{
      if($searchRadio == "Brand"){
              $auc_detail_qry.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $auc_detail_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $auc_detail_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }
    }
    $auc_detail = $this->db2->query($auc_detail_qry)->result_array();

    $auc_sumr_qry = " SELECT NVL(ROUND(SUM(D.QUANTITY), 2), 0) QTY, NVL(ROUND(SUM(D.QUANTITY * decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE)), 2), 0) TOTAL_AMOUNT, ROUND((SUM(D.QTY_SOLD)/NVL(MAX(M.NO_OF_ITEM),1)),2) SELL_THROU FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID AND D.LZ_AUCTION_ID = $lz_auction_id ";
    // if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
    //     if (count($str)>1) {
    //       $i=1;
    //       foreach ($str as $key) {
    //         if($i === 1){
    //           $auc_sumr_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
    //         }else{
    //           $auc_sumr_qry.=" AND (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
    //         }
    //         $i++;
    //       }
    //     }else{
    //       $auc_sumr_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
    //     }
    //       }
    if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
        if (count($str)>1) {

          foreach ($str as $key) {
            if($searchRadio == "Brand"){
              $auc_sumr_qry.=" and UPPER(D.BRAND) LIKE '%$key%'";
            }elseif ($searchRadio == "Desc") {
              $auc_sumr_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%'";
            }elseif ($searchRadio == "Both") {
              $auc_sumr_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
            }
          }
        }else{
          if($searchRadio == "Brand"){
              $auc_sumr_qry.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $auc_sumr_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $auc_sumr_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }

        }
    }else{
      if($searchRadio == "Brand"){
              $auc_sumr_qry.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $auc_sumr_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $auc_sumr_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }
    }
    $auc_sumr = $this->db2->query($auc_sumr_qry)->result_array();

    $brand_qry = " SELECT DECODE(UPPER(D.BRAND),NULL,'UNKNOWN',UPPER(D.BRAND)) BRAND  ,SUM(D.QUANTITY) BRND_QTY, '$ '||ROUND((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE)*D.QUANTITY) / SUM(D.QUANTITY)),2) AVG_SOLG, '$ '||ROUND(SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE)*D.QUANTITY),2) TOTAL, DECODE(MAX(T.BRAND_TYPE),1,'CASH',2,'SALVAGE')BRAND_TYPE FROM LZ_AUCTION_DET D,LZ_BD_BRAND_TYPE T WHERE  D.LZ_AUCTION_ID = $lz_auction_id AND UPPER(D.BRAND) = T.BRAND (+)";
    // if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter if (count($str)>1) {
    //       $i=1;
    //       foreach ($str as $key) {
    //         if($i === 1){
    //           $brand_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
    //         }else{
    //           $brand_qry.=" AND (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
    //         }
    //         $i++;
    //       }
    //     }else{
    //       $brand_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
    //     }
        if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
        if (count($str)>1) {

          foreach ($str as $key) {
            if($searchRadio == "Brand"){
              $brand_qry.=" and UPPER(D.BRAND) LIKE '%$key%'";
            }elseif ($searchRadio == "Desc") {
              $brand_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%'";
            }elseif ($searchRadio == "Both") {
              $brand_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
            }
          }
        }else{
          if($searchRadio == "Brand"){
              $brand_qry.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $brand_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $brand_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }

        }
    }else{
      if($searchRadio == "Brand"){
              $brand_qry.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $brand_qry.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $brand_qry.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }
    }     
    $brand_qry.= " GROUP BY UPPER(D.BRAND)";

    $top_brand = $this->db2->query($brand_qry." ORDER BY SUM(D.QUANTITY) DESC")->result_array();

      // Cash query item calculation
      $master_serch_key_quer = " SELECT MAX(M.LZ_AUCTION_ID) LZ_AUCTION_ID, MAX(M.VENDOR_AUCTION_ID) VENDOR_AUCTION_ID, MAX(M.AUCTION_DESCRIPTION) AUCTION_DESCRIPTION, MAX(M.CONDITION) CONDITION, MAX(M.TIME_LEFT) TIME_LEFT, NVL(MAX(M.CURRENT_BID), 0) CURRENT_BID, NVL(SUM(D.QUANTITY), 0) NO_OF_ITEM,  NVL(SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY), 0) EST_SALE, NVL(ROUND((8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100), 2), 0) EBAY, NVL(ROUND((2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100), 2), 0) PAYPAL, NVL(ROUND(SUM(D.SHIP_FEE * D.QUANTITY), 2), 0) SHIP_FEE, NVL(ROUND((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)), 2), 0) NET_AMOUNT, NVL(ROUND(((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)) - $prof_perc * (SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100)), 2), 0) OFFER_ON_NET_AMOUNT, NVL(SUM(D.QTY_SOLD), 0) QTY_SOLD, NVL(ROUND((SUM(D.QTY_SOLD) / NVL(MAX(M.NO_OF_ITEM), 1)), 2), 0) SELL_THROU, NVL(ROUND(SUM(D.WATCH_COUNT) / NVL(MAX(M.NO_OF_ITEM), 1), 2), 0) WATCH_COUNT_AVG,SUM(D.WEIGHT * D.QUANTITY) TOTAL_WEIGHT FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID AND D.LZ_AUCTION_ID = $lz_auction_id  " ;
      // if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter if (count($str)>1) {
      //     $i=1;
      //     foreach ($str as $key) {
      //       if($i === 1){
      //         $master_serch_key_quer.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
      //       }else{
      //         $master_serch_key_quer.=" AND (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
      //       }
      //       $i++;
      //     }
      //   }else{
      //     $master_serch_key_quer.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
      //   }
      if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
        if (count($str)>1) {

          foreach ($str as $key) {
            if($searchRadio == "Brand"){
              $master_serch_key_quer.=" and UPPER(D.BRAND) LIKE '%$key%'";
            }elseif ($searchRadio == "Desc") {
              $master_serch_key_quer.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%'";
            }elseif ($searchRadio == "Both") {
              $master_serch_key_quer.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
            }
          }
        }else{
          if($searchRadio == "Brand"){
              $master_serch_key_quer.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $master_serch_key_quer.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $master_serch_key_quer.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }

        }
    }else{
      if($searchRadio == "Brand"){
          $master_serch_key_quer.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
        }elseif ($searchRadio == "Desc") {
          $master_serch_key_quer.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
        }elseif ($searchRadio == "Both") {
          $master_serch_key_quer.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
        }
    } 
        $master_serch_key_quer.= "  AND (D.SKU  IN (SELECT SKU FROM LZ_BD_ITEM_TYPE WHERE ITEM_TYPE = 1) OR UPPER(D.BRAND)  IN (SELECT UPPER(TT.BRAND) FROM LZ_BD_BRAND_TYPE TT WHERE TT.BRAND_TYPE = 1))  GROUP BY M.LZ_AUCTION_ID ";
        
      $master_serch_key = $this->db2->query($master_serch_key_quer)->result_array(); 

      // salvage query item calculation
      $master_serch_key_salvage = " SELECT MAX(M.LZ_AUCTION_ID) LZ_AUCTION_ID, MAX(M.VENDOR_AUCTION_ID) VENDOR_AUCTION_ID, MAX(M.AUCTION_DESCRIPTION) AUCTION_DESCRIPTION, MAX(M.CONDITION) CONDITION, MAX(M.TIME_LEFT) TIME_LEFT, NVL(MAX(M.CURRENT_BID), 0) CURRENT_BID, NVL(SUM(D.QUANTITY), 0) NO_OF_ITEM,  NVL(SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY), 0) EST_SALE, NVL(ROUND((8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100), 2), 0) EBAY, NVL(ROUND((2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100), 2), 0) PAYPAL, NVL(ROUND(SUM(D.SHIP_FEE * D.QUANTITY), 2), 0) SHIP_FEE, NVL(ROUND((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)), 2), 0) NET_AMOUNT, NVL(ROUND(((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)) - $prof_perc * (SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100)), 2), 0) OFFER_ON_NET_AMOUNT, NVL(SUM(D.QTY_SOLD), 0) QTY_SOLD, NVL(ROUND((SUM(D.QTY_SOLD) / NVL(MAX(M.NO_OF_ITEM), 1)), 2), 0) SELL_THROU, NVL(ROUND(SUM(D.WATCH_COUNT) / NVL(MAX(M.NO_OF_ITEM), 1), 2), 0) WATCH_COUNT_AVG ,SUM(D.WEIGHT * D.QUANTITY) TOTAL_WEIGHT FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID AND D.LZ_AUCTION_ID = $lz_auction_id  " ;
      // if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter if (count($str)>1) {
      //     $i=1;
      //     foreach ($str as $key) {
      //       if($i === 1){
      //         $master_serch_key_salvage.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
      //       }else{
      //         $master_serch_key_salvage.=" AND (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
      //       }
      //       $i++;
      //     }
      //   }else{
      //     $master_serch_key_salvage.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
      //   }
      if(!empty($auc_key) ) {   // if there is a search parameter, $keyword contains search parameter
        if (count($str)>1) {

          foreach ($str as $key) {
            if($searchRadio == "Brand"){
              $master_serch_key_salvage.=" and UPPER(D.BRAND) LIKE '%$key%'";
            }elseif ($searchRadio == "Desc") {
              $master_serch_key_salvage.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%'";
            }elseif ($searchRadio == "Both") {
              $master_serch_key_salvage.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%')";
            }
          }
        }else{
          if($searchRadio == "Brand"){
              $master_serch_key_salvage.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Desc") {
              $master_serch_key_salvage.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
            }elseif ($searchRadio == "Both") {
              $master_serch_key_salvage.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
            }

        }
    }else{
      if($searchRadio == "Brand"){
          $master_serch_key_salvage.=" and UPPER(D.BRAND) LIKE '%$auc_key%'";
        }elseif ($searchRadio == "Desc") {
          $master_serch_key_salvage.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%'";
        }elseif ($searchRadio == "Both") {
          $master_serch_key_salvage.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$auc_key%' OR UPPER(D.BRAND) LIKE '%$auc_key%')";
        }
    }
        $master_serch_key_salvage.= "  AND (D.SKU  IN (SELECT SKU FROM LZ_BD_ITEM_TYPE WHERE ITEM_TYPE = 2) OR UPPER(D.BRAND)  IN (SELECT UPPER(TT.BRAND) FROM LZ_BD_BRAND_TYPE TT WHERE TT.BRAND_TYPE = 2)) GROUP BY M.LZ_AUCTION_ID "; $master_serch_key_sal = $this->db2->query($master_serch_key_salvage)->result_array();

    return array('auc_detail' => $auc_detail,'mast_det' => $mast_det,'auc_sumr' => $auc_sumr,'top_brand' => $top_brand,'master_serch_key' => $master_serch_key,'master_serch_key_sal' => $master_serch_key_sal);

  }

public function load_auction_data() {
    $get_keywoerd = strtoupper(trim($this->input->post('get_keywoerd')));
    $get_keywoerd = trim(str_replace("  ", ' ', $get_keywoerd));
    $get_keywoerd = str_replace(array("`,′"), "", $get_keywoerd);
    $get_keywoerd = str_replace(array("'"), "''", $get_keywoerd);
    $str = explode(' ', $get_keywoerd);
    $endToday = $this->input->post('endToday');
    $endedAuction = $this->input->post('endedAuction');
    $seacrhRadio = $this->input->post('seacrhRadio');
    $this->session->set_userdata('serachFilter', $seacrhRadio);
   //var_dump($get_keywoerd,$str);
    if($endToday === 'true' AND $endedAuction === 'false'){
      $today_qry = " AND M.TIME_LEFT >= SYSDATE AND M.TIME_LEFT <= SYSDATE+1 ";
    }else{
      $today_qry = " ";
    }
    if($endedAuction === 'true'){
      $endedAuction_qry = " ";
    }else{
      $endedAuction_qry = " AND M.TIME_LEFT >= SYSDATE ";
      //$endedAuction_qry = " ";//2025735
    }
    //var_dump($today_qry,$endedAuction_qry);
    $this->session->set_userdata('get_keywoerd', $get_keywoerd);

    $requestData = $_REQUEST;

   $columns     = array(
      // datatable column index  => database column name
      0 =>'LZ_AUCTION_ID',
      1 =>'VENDOR_AUCTION_ID',
      2 =>'AUCTION_DESCRIPTION',
      3 => 'CONDITION',
      4 => 'TIME_LEFT',
      5 => 'CURRENT_BID',
      6 => 'NO_OF_ITEM',
      7 => 'EST_SALE',
      8 => 'EBAY',
      9 => 'PAYPAL',
      10 => 'SHIP_FEE',
      11 => 'NET_AMOUNT',
      12 => 'OFFER_ON_NET_AMOUNT',
      13 => 'QTY_SOLD',
      14 => 'SELL_THROU',
      15 => 'WATCH_COUNT_AVG',
      16 => 'SUM(D.QUANTITY)'      
    );    

    // OLD QUERY
    // $sql = " SELECT MAX(M.AUCTION_URL) AUCTION_URL, MAX(M.LZ_AUCTION_ID)  LZ_AUCTION_ID, MAX(M.VENDOR_AUCTION_ID) VENDOR_AUCTION_ID, MAX(M.AUCTION_DESCRIPTION) AUCTION_DESCRIPTION, MAX(M.CONDITION) CONDITION, TO_CHAR(TO_DATE(MAX(M.TIME_LEFT), 'DD-MM-YY HH:MI:SS\"000000\" AM'),'DD-MM-YYYY HH24:MI:SS') TIME_LEFT, nvl(MAX(M.CURRENT_BID),0) CURRENT_BID, nvl(MAX(M.NO_OF_ITEM),0) NO_OF_ITEM, nvl(SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY),0) EST_SALE, nvl(ROUND((8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100),2),0) EBAY, nvl(ROUND((2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100),2),0) PAYPAL,  nvl(round(sum(d.ship_fee * d.quantity),2),0) ship_fee, nvl(ROUND((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)),2),0) NET_AMOUNT, nvl(ROUND(((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)) - 30 * (SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100)),2),0) OFFER_ON_NET_AMOUNT, nvl(SUM(D.QTY_SOLD),0) QTY_SOLD, nvl(ROUND((SUM(D.QTY_SOLD)/NVL(MAX(M.NO_OF_ITEM),1)),2),0) SELL_THROU, nvl(ROUND(SUM(D.WATCH_COUNT)/NVL(MAX(M.NO_OF_ITEM),1),2),0) WATCH_COUNT_AVG,SUM(D.QUANTITY) NO_OF_ROWS, MAX(M.INSERTION_DATE) INSERTION_DATE FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID /*AND M.TIME_LEFT >= SYSDATE  AND M.PROCESSED = 1 */  /*ORDER BY (SUM(D.QTY_SOLD)/MAX(M.NO_OF_ITEM))*100 DESC */";//.$endedAuction_qry.$today_qry;

    $sql = " SELECT MAX(M.AUCTION_URL) AUCTION_URL, MAX(M.LZ_AUCTION_ID)  LZ_AUCTION_ID, MAX(M.VENDOR_AUCTION_ID) VENDOR_AUCTION_ID, MAX(M.AUCTION_DESCRIPTION) AUCTION_DESCRIPTION, MAX(M.CONDITION) CONDITION, TO_CHAR(TO_DATE(MAX(M.TIME_LEFT), 'DD-MM-YY HH:MI:SS\"000000\" AM'),'DD-MM-YYYY HH24:MI:SS') TIME_LEFT, nvl(MAX(M.CURRENT_BID),0) CURRENT_BID, nvl(MAX(M.NO_OF_ITEM),0) NO_OF_ITEM, nvl(SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY),0) EST_SALE, nvl(ROUND((8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100),2),0) EBAY, nvl(ROUND((2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100),2),0) PAYPAL,  nvl(round(sum(d.ship_fee * d.quantity),2),0) ship_fee, nvl(ROUND((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)),2),0) NET_AMOUNT, nvl(ROUND(((SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) - (8 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - (2.25 * SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100) - SUM(D.SHIP_FEE * D.QUANTITY)) - 30 * (SUM(decode(D.AVG_SOLD_PRICE, null, D.PRICE, D.AVG_SOLD_PRICE) * D.QUANTITY) / 100)),2),0) OFFER_ON_NET_AMOUNT, nvl(SUM(D.QTY_SOLD),0) QTY_SOLD, nvl(ROUND((SUM(D.QTY_SOLD)/NVL(MAX(M.NO_OF_ITEM),1)),2),0) SELL_THROU, nvl(ROUND(SUM(D.WATCH_COUNT)/NVL(MAX(M.NO_OF_ITEM),1),2),0) WATCH_COUNT_AVG,SUM(D.QUANTITY) NO_OF_ROWS, MAX(M.INSERTION_DATE) INSERTION_DATE FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID ".$endedAuction_qry.$today_qry;


    if(!empty($get_keywoerd) ) {   // if there is a search parameter, $keyword contains search parameter

        if (count($str)>1) {

          foreach ($str as $key) {
            if($seacrhRadio == "Brand"){
              $sql.=" and (UPPER(D.BRAND) LIKE '%$key%' OR M.VENDOR_AUCTION_ID LIKE '%$key%')";
            }elseif ($seacrhRadio == "Desc") {
              $sql.=" and UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR M.VENDOR_AUCTION_ID LIKE '%$key%'";
            }elseif ($seacrhRadio == "Both") {
              $sql.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$key%' OR UPPER(D.BRAND) LIKE '%$key%' OR M.VENDOR_AUCTION_ID LIKE '%$key%')";
            }
          }
        }else{

          if($seacrhRadio == "Brand"){
              $sql.=" and (UPPER(D.BRAND) LIKE '%$get_keywoerd%' OR M.VENDOR_AUCTION_ID LIKE '%$get_keywoerd%')";
            }elseif ($seacrhRadio == "Desc") {
              $sql.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$get_keywoerd%' OR M.VENDOR_AUCTION_ID LIKE '%$get_keywoerd%')";
            }elseif ($seacrhRadio == "Both") {
              $sql.=" and (UPPER(D.ITEM_DESCRIPTION) LIKE '%$get_keywoerd%' OR UPPER(D.BRAND) LIKE '%$get_keywoerd%' OR M.VENDOR_AUCTION_ID LIKE '%$get_keywoerd%')";
            }

        }
    }
//var_dump($get_keywoerd);
        $get_serch_qry  = strtoupper(trim($requestData['search']['value']));
      if(!empty($requestData['search']['value']) ) {   
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
          $sql.=" and (VENDOR_AUCTION_ID LIKE '%".$get_serch_qry."%' ";
          $sql.=" OR upper(AUCTION_DESCRIPTION) LIKE '%".$get_serch_qry."%' ";  
          $sql.=" OR upper(CONDITION) LIKE '%".$get_serch_qry."%' ";
          $sql.=" OR CURRENT_BID LIKE '%".$get_serch_qry."%' "; 
          $sql.=" OR TO_CHAR(TO_DATE(M.TIME_LEFT, 'DD-MM-YY HH:MI:SS\"000000\" AM'),'DD-MM-YYYY HH24:MI:SS') LIKE '%".$get_serch_qry."%' "; 
          $sql.=" OR NO_OF_ITEM LIKE '%".$get_serch_qry."%' )"; 
          $sql.=" GROUP BY M.LZ_AUCTION_ID "; 
      }else{
        $sql.=" GROUP BY M.LZ_AUCTION_ID ";
      }

    $query   = $this->db2->query($sql); 
    $totalData     = $query->num_rows();
    $totalFiltered = $totalData;
 
//     if(empty($title_sort)){ 
//     $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
// }
    $sql .= " ORDER BY " . $columns[$requestData['order']['0']['column']] . "   " . $requestData['order']['0']['dir'];
    $sql = "SELECT  * FROM    (SELECT  q.*, ROWNUM rn FROM ($sql) q ) WHERE   ROWNUM <= ".$requestData['length']." AND rn >= ".$requestData['start'] ;
    $query         = $this->db2->query($sql)->result_array();
    $data = '';
    foreach($query as $row ){ 
      $nestedData=array();
      $nestedData[] =  '<div class="form-group"><a class="btn btn-primary btn-sm" href="'.base_url()."catalogueToCash/c_tl_auction/load_auction_detail_data/".$row['LZ_AUCTION_ID'].'" target="_blank">VIEW</a> </div>';

      // $nestedData[] =  '<div> <input type="button" class="btn btn-info view_auc_det" name="view_auc_det'.$row['VENDOR_AUCTION_ID'].'" id="view_auc_det'.$row['VENDOR_AUCTION_ID'].'" value="View"> </div>';      
      $nestedData[] = '<a class="a_link" href="'.$row['AUCTION_URL'].'" target="_blank">'.$row['VENDOR_AUCTION_ID'].'</a>';
      $nestedData[] = $row['AUCTION_DESCRIPTION'];
      $nestedData[] = $row['CONDITION'];
      $nestedData[] = $row['TIME_LEFT'];           
        $nestedData[] = $row['CURRENT_BID'];    
      //$nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['CURRENT_BID'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">'. $row['NO_OF_ITEM'].'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['EST_SALE'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['EBAY'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['PAYPAL'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['SHIP_FEE'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['NET_AMOUNT'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">$'. number_format((float)@$row['OFFER_ON_NET_AMOUNT'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">'. number_format((float)@$row['QTY_SOLD'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">'. number_format((float)@$row['SELL_THROU'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">'. number_format((float)@$row['WATCH_COUNT_AVG'],2,'.',',').'</div>';
      $nestedData[] ='<div class="pull-right" style="width:90px;">'. @$row['NO_OF_ROWS'].'</div>';
      $nestedData[] = $row['INSERTION_DATE']; 

      $data[] = $nestedData;    
   
    } //// end main foreach
    $json_data = array(
      "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
      "recordsTotal" => intval($totalData), // total number of records
      "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "deferLoading" =>  intval( $totalFiltered ),
      "data" => $data // total data array
    );
    return $json_data;
  }
//////////////////////////////////////////////


public function save_auc_obj(){

  $auc_id = $this->input->post('auc_id');
  $obj_cat_id = $this->input->post('obj_cat_id');
  $obj_name = $this->input->post('obj_name');
  $get_avg_pric = $this->input->post('get_avg_pric');

  $query =$this->db2->query("UPDATE LZ_AUCTION_DET D SET D.OBJECT_NAME ='$obj_name',D.CATEGORY_ID = '$obj_cat_id', D.PRICE='$get_avg_pric' WHERE D.LZ_AUCTION_DET_ID =$auc_id ");

  if($query){
    return true;
  // }else{ 
  //   return false;
  // }
    }
  }
  public function getCategory(){

  $auction_id = $this->input->post('auction_id');
  $auc_det = $this->db2->query("SELECT D.LZ_AUCTION_DET_ID,D.UPC,D.MPN,D.BBY_UPC,D.BBY_MPN,D.SKU FROM LZ_AUCTION_MT M, LZ_AUCTION_DET D WHERE M.LZ_AUCTION_ID = D.LZ_AUCTION_ID  AND D.CATEGORY_ID IS NULL AND M.LZ_AUCTION_ID = '$auction_id' ORDER BY D.LZ_AUCTION_DET_ID ASC")->result_array();

    return $auc_det;

  }
  public function getCatObj(){

  $cat_id = $this->input->post('cat_id');
  $auc_det = $this->db2->query("SELECT O.OBJECT_ID,O.OBJECT_NAME FROM LZ_BD_OBJECTS_MT O WHERE O.CATEGORY_ID = $cat_id ORDER BY O.OBJECT_NAME ASC")->result_array();
    return $auc_det;

  }

  public function cash_item_brand(){
    $get_b_nam = strtoupper(trim($this->input->post('get_b_nam')));
    $get_uri =$this->input->post('get_uri');
    $type =$this->input->post('type');
    $insert_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    

    $check_query = $this->db2->query(" SELECT T.BRAND_TYPE_ID FROM LZ_BD_BRAND_TYPE T WHERE UPPER(T.BRAND) = '$get_b_nam' ")->result_array();
    if(count($check_query) > 0){
      $get_pk = $check_query[0]['BRAND_TYPE_ID'];

      $this->db2->query("UPDATE LZ_BD_BRAND_TYPE T SET T.BRAND_TYPE =$type WHERE T.BRAND_TYPE_ID = $get_pk");

      return false;
    }else{
      
      $brand_qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_BRAND_TYPE','BRAND_TYPE_ID') BRAND_PK FROM DUAL");          
      $brand_qry = $brand_qry->result_array();
      $brand_pk = $brand_qry[0]['BRAND_PK'];

      $ins_qry = $this->db2->query(" INSERT INTO LZ_BD_BRAND_TYPE T (T.BRAND_TYPE_ID, T.BRAND, T.BRAND_TYPE, T.INSERTED_DATE, T.INSERTED_BY)values($brand_pk,'$get_b_nam',$type,$insert_date,$insert_by)"); 
      if($ins_qry){
        return true;
      }
    }

    //var_dump($get_b_nam,$get_uri);

  }

  public function cash_item(){

    $det_brnd_cash_id = $this->input->post('det_brnd_cash_id');
    $type = $this->input->post('type');
    $insert_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $get_auc_det = $this->db2->query ("SELECT  DECODE(DE.BBY_UPC,NULL,DE.UPC,DE.BBY_UPC) UPC, DECODE(DE.BBY_MPN,NULL,DE.MPN,DE.BBY_MPN) MPN,DE.SKU,DE.BRAND FROM LZ_AUCTION_DET DE WHERE DE.LZ_AUCTION_DET_ID = $det_brnd_cash_id")->result_array();
    $auc_sku = $get_auc_det[0]['SKU'];
    $auc_upc = $get_auc_det[0]['UPC'];
    $auc_mpn = $get_auc_det[0]['MPN'];
    //$auc_brnd = $get_auc_det[0]['BRAND'];

    $typ_check_qry  = "SELECT * FROM LZ_BD_ITEM_TYPE T";

    if(!empty($auc_sku)){
      $typ_check_qry .= " WHERE T.SKU = $auc_sku";

    }else{
      if(!empty($auc_upc) && !empty($auc_mpn)){
        $typ_check_qry .= " WHERE T.UPC = $auc_upc";
        $typ_check_qry .= " AND T.MPN = '$auc_mpn'";
      }else if(empty($auc_upc) && !empty($auc_mpn)){
        $typ_check_qry .= " WHERE T.UPC is null";
        $typ_check_qry .= " AND T.MPN = '$auc_mpn'";

      }else if(!empty($auc_upc) && empty($auc_mpn)){
        $typ_check_qry .= " WHERE T.UPC = $auc_upc";
        $typ_check_qry .= " AND T.MPN  is null";

      }else{
        return error;
      }
      
    }

    $typ_check = $this->db2->query($typ_check_qry)->result_array();

    if(count($typ_check) > 0){
      
      $up_query = "UPDATE LZ_BD_ITEM_TYPE T SET T.ITEM_TYPE = $type ";      
       if(!empty($auc_sku)){
      $up_query .= " WHERE T.SKU = $auc_sku";

    }else{
      if(!empty($auc_upc) && !empty($auc_mpn)){
        $up_query .= " WHERE T.UPC = $auc_upc";
        $up_query .= " AND T.MPN = '$auc_mpn'";
      }else if(empty($auc_upc) && !empty($auc_mpn)){
        $up_query .= " WHERE T.UPC is null";
        $up_query .= " AND T.MPN = '$auc_mpn'";

      }else if(!empty($auc_upc) && empty($auc_mpn)){
        $up_query .= " WHERE T.UPC = $auc_upc";
        $up_query .= " AND T.MPN  is null";

      }else{
        return error;
      }
      
    }
    $this->db2->query($up_query);

      return false;
    }else{
        $brand_qry = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ITEM_TYPE','ITEM_TYPE_ID') ITEM_PK FROM DUAL");          
        $brand_qry = $brand_qry->result_array();
        $item_pk = $brand_qry[0]['ITEM_PK'];

      $ins_qry = $this->db2->query(" INSERT INTO LZ_BD_ITEM_TYPE T (T.ITEM_TYPE_ID, T.SKU, T.UPC, T.MPN, T.ITEM_TYPE, T.INSERTED_DATE, T.INSERTED_BY)values($item_pk,'$auc_sku','$auc_upc','$auc_mpn',$type,$insert_date,$insert_by)"); 

      if($ins_qry){
        return true;
      }
    }



  }

}

?>