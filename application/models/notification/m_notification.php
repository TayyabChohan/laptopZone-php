<?php 

  class m_notification extends CI_Model
  {

  public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
public function pull_orders()
{
  
  $main_query = "SELECT decode(l.folder_name,null,decode(dd.folder_name,null,'master_pictures/'|| trim(i.item_mt_upc)||'~'||trim(i.item_mt_mfg_part_no)||'/'||trim(cc.cond_name),'dekitted_pictures/'||dd.folder_name),'dekitted_pictures/'||l.folder_name) IMAGE,
  'master_pictures/'|| trim(i.item_mt_upc)||'~'||trim(i.item_mt_mfg_part_no)||'/'||trim(cc.cond_name) FOL_NAME1,
  --decode(l.folder_name,null,decode(dd.folder_name,null,'master_pictures/'||i.item_mt_mfg_part_no||'~'||i.item_mt_upc,'dekitted_pictures/'||dd.folder_name),'dekitted_pictures/'||l.folder_name) fol_name,
   get.*
    FROM (SELECT ROWNUM RE,
                 SDD.BARCODE_NO BARCODEARRAY,
                 SDD.BARCODE_NO def_barcode,
                 SDD.WAREHOUSE_NO,
                 TO_CHAR(SDD.PAID_ON_DATE, 'MM/DD/YYYY HH24:MI:SS') SALE_DATE,
                 SDD.USER_ID USER_ID,
                (SDD.BUYER_FULLNAME) FULLNAME,
                (SDD.BUYER_ADDRESS1) ADDRESS1,
                (SDD.BUYER_ADDRESS2) ADDRESS2,
                 SDD.BUYER_CITY,
                 SDD.BUYER_STATE,
                 SDD.BUYER_ZIP,
                 SDD.BUYER_COUNTRY,
                 'AWAITING' ORDER_STATUS,
                 sdd.QUANTITY,
                 sdd.item_title,
                 sdd.itm_id,
                 sdd.order_num saleno,
                 sdd.ITEM_ID ebayid,              
                 sdd.BIN_LOCATION,
                  SDD.TOTAL_PRICE,
                  SDD.LZ_SELLER_ACCT_ID TBDFW,
                   SDD.PULLER_NAME,
                   SDD.PULLING_DATE,
                   SDD.MPN,
                   SDD.UPC,
                   SDD.COND_NAME,
                   SDD.TRANSACTION_ID,
                    decode(SDD.STAMPS_SHIPPING_RATE,NULL,0,SDD.STAMPS_SHIPPING_RATE) STAMPS_SHIPPING_RATE,
                 --    decode( DECODE(WS.PACK_WEIGHT,NULL,MD.WEIGHT,WS.PACK_WEIGHT)
 --,null,0,DECODE(WS.PACK_WEIGHT,NULL,MD.WEIGHT,WS.PACK_WEIGHT))PACK_WEIGHT,
 0 PACK_WEIGHT,
  DECODE(WS.MACHINE_INPUT_YN,NULL,0,WS.MACHINE_INPUT_YN) MACHINE_INPUT_YN,
SDD.SHIPPING_SERVICE,
sdd.pulling_id,
                  sdd.condition_id
            FROM (SELECT SD.ITEM_ID,
                         b.bin_id,
                         sd.sales_record_number order_num,
                         sd.item_title,
                         SD.USER_ID,
                         DECODE(SD.SHIP_TO_NAME,NULL,SD.BUYER_FULLNAME,SD.SHIP_TO_NAME) BUYER_FULLNAME,
                         SD.TRANSACTION_ID,
                         DECODE(SD.SHIP_TO_ADDRESS1,NULL,SD.BUYER_ADDRESS1,SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1,
                         DECODE(SD.SHIP_TO_ADDRESS2,NULL,SD.BUYER_ADDRESS2,SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2,
                         DECODE(SD.SHIP_TO_CITY,NULL,SD.BUYER_CITY,SD.SHIP_TO_CITY) BUYER_CITY,
                         DECODE(SD.SHIP_TO_STATE,NULL,SD.BUYER_STATE,SD.SHIP_TO_STATE) BUYER_STATE,
                         DECODE(SD.SHIP_TO_ZIP,NULL,SD.BUYER_ZIP,SD.SHIP_TO_ZIP) BUYER_ZIP,
                         DECODE(SD.SHIP_TO_COUNTRY,NULL,SD.BUYER_COUNTRY,SD.SHIP_TO_COUNTRY) BUYER_COUNTRY,
                         SD.PAID_ON_DATE,
                         B.LZ_MANIFEST_ID,
                         im.item_code,
                         SP.PULLER_NAME,
                         SP.PULLING_DATE,
                         im.item_mt_mfg_part_no mpn,
                         im.item_mt_upc upc,
                         c.cond_name,
                         SD.QUANTITY,
                         SD.TOTAL_PRICE,
                         SD.SHIPPING_SERVICE,
                         SD.STAMPS_SHIPPING_RATE,
                         SM.LZ_SELLER_ACCT_ID,
                         NVL(SP.PULLING_QTY, 0) PULLING_QTY,
                         NVL(SP.CANCEL_QTY, 0) CANCEL_QTY,
                         B.BARCODE_NO,
                         b.item_id itm_id,
                         WA.WAREHOUSE_NO,
                         b.condition_id,
                         B.Pulling_Id,
                         DECODE(Bi.BIN_ID,
                                0,
                                'NO BIN',
                                'W' || Wa.WAREHOUSE_NO || '-' || Rac.RACK_NO || '-R' ||
                                Ro.ROW_NO || '-' || Bi.BIN_TYPE || '-' ||
                                Bi.BIN_NO) BIN_LOCATION
                    FROM LZ_SALESLOAD_DET SD,
                         LZ_BARCODE_MT B,
                         LZ_AWAITING_SHIPMENT aw,
                         BIN_MT BI,
                         LZ_RACK_ROWS RO,
                         RACK_MT RAC,
                         lz_item_cond_mt c,
                         WAREHOUSE_MT WA,
                         items_mt im,
                         LZ_SALESLOAD_MT SM,
                         (SELECT SALES_RECORD_NO,
                                 MAX(PULLER_NAME) PULLER_NAME,
                                 TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE,
                                 SUM(NVL(PULLING_QTY, 0)) PULLING_QTY,
                                 SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY
                            FROM LZ_SALES_PULLING
                           GROUP BY SALES_RECORD_NO) SP
                   WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+)
                     AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+)
                     and sd.sales_record_number = to_Char(aw.salerecordid)
                     AND SD.LZ_SALELOAD_ID  = SM.LZ_SALELOAD_ID
                     AND B.BIN_ID = BI.BIN_ID(+)
                     AND BI.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+)
                     AND RO.RACK_ID = RAC.RACK_ID(+)
                     AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID(+)
                     and  b.condition_id = c.id(+)
                     and im.item_id = b.item_id
                     AND B.PULLING_ID IS NULL
                     and aw.lz_seller_account_id <> 3
                    -- and sd.uk_firebase_waiting is null
                     and b.item_adj_det_id_for_in is null
                     and b.item_adj_det_id_for_out is null
                     and b.lz_part_issue_mt_id is null
                     and b.lz_pos_mt_id is null
                     AND SD.GNRTD_DC_ID IS NULL
                     AND SD.TRACKING_NUMBER IS NULL
                    
                  ) SDD,
                 
                   (SELECT DISTINCT W.ITEM_ID,W.PACK_WEIGHT,W.SHIPPING_SERVICE, W.MACHINE_INPUT_YN 
          FROM LZ_ITEM_PACK_WEIGHT W) WS--,
          --(SELECT D.WEIGHT, D.LZ_MANIFEST_ID,D.LAPTOP_ITEM_CODE FROM LZ_MANIFEST_DET D) MD
           WHERE NVL(SDD.QUANTITY, 0) <>
                 (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0))
            -- AND SDD.ITEM_ID = EB.EBAY_ITEM_ID
             AND SDD.ITM_ID = WS.ITEM_ID(+)
            -- and sdd.item_code = md.laptop_item_code
            -- and SDD.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID
            -- AND EB.LZ_SELLER_ACCT_ID IS NOT NULL
             AND SDD.BARCODE_NO IS NOT NULL) get,lz_special_lots l,items_mt i,
             lz_dekit_us_dt dd,lz_item_cond_mt cc
             where def_barcode = l.barcode_prv_no(+)
             and def_barcode = dd.barcode_prv_no(+)
             and get.condition_id = cc.id(+)
             and itm_id = i.item_id
            -- and get.saleno  =  11484
           --  and rownum < 65
             order by get.saleno asc
  --WHERE RE = 1
  
  
  --select * from lz_barcode_mt";
 
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
}

public function awaitingOrders($order_id)
{
  
  $main_query = "SELECT decode(l.folder_name, null, decode(dd.folder_name, null, 'master_pictures/' || trim(i.item_mt_upc) || '~' || trim(i.item_mt_mfg_part_no) || '/' || trim(cc.cond_name), 'dekitted_pictures/' || dd.folder_name), 'dekitted_pictures/' || l.folder_name) IMAGE, 'master_pictures/' || trim(i.item_mt_upc) || '~' || trim(i.item_mt_mfg_part_no) || '/' || trim(cc.cond_name) FOL_NAME1, get.* FROM (SELECT ROWNUM RE, SDD.MERCHANT_ID, SDD.BARCODE_NO BARCODEARRAY, SDD.BARCODE_NO def_barcode, SDD.WAREHOUSE_NO, TO_CHAR(SDD.Sale_Date, 'MM/DD/YYYY HH24:MI:SS') SALE_DATE, SDD.USER_ID USER_ID, (SDD.BUYER_FULLNAME) FULLNAME, (SDD.BUYER_ADDRESS1) ADDRESS1, (SDD.BUYER_ADDRESS2) ADDRESS2, SDD.BUYER_CITY, SDD.BUYER_STATE, SDD.BUYER_ZIP, SDD.BUYER_COUNTRY, decode(SDD.ebay_status, 'Completed', 'AWAITING', SDD.ebay_status) ORDER_STATUS, sdd.QUANTITY, sdd.item_title, sdd.itm_id, sdd.order_num saleno, sdd.ITEM_ID ebayid, sdd.BIN_LOCATION, SDD.TOTAL_PRICE, SDD.LZ_SELLER_ACCT_ID SELLER_ACCT, SDD.PULLER_NAME, SDD.PULLING_DATE, SDD.MPN, SDD.UPC, SDD.COND_NAME, SDD.TRANSACTION_ID, decode(SDD.STAMPS_SHIPPING_RATE, NULL, 0, SDD.STAMPS_SHIPPING_RATE) STAMPS_SHIPPING_RATE, 0 PACK_WEIGHT, DECODE(WS.MACHINE_INPUT_YN, NULL, 0, WS.MACHINE_INPUT_YN) MACHINE_INPUT_YN, SDD.SHIPPING_SERVICE, sdd.pulling_id, sdd.condition_id, sdd.ebay_status, SDD.BUISNESS_NAME MERCHANT_NAME, SDD.ACCOUNT_NAME, sdd.order_id, sdd.SALES_RECORD_NO_GROUP GROUP_SALENO, sdd.extendedorderid, sdd.location_vrf FROM (SELECT SD.ITEM_ID, b.bin_id, sd.sales_record_number order_num, sd.item_title, SD.USER_ID, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF, DECODE(SD.SHIP_TO_NAME, NULL, SD.BUYER_FULLNAME, SD.SHIP_TO_NAME) BUYER_FULLNAME, SD.TRANSACTION_ID, LD.MERCHANT_ID, DECODE(SD.SHIP_TO_ADDRESS1, NULL, SD.BUYER_ADDRESS1, SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1, DECODE(SD.SHIP_TO_ADDRESS2, NULL, SD.BUYER_ADDRESS2, SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2, DECODE(SD.SHIP_TO_CITY, NULL, SD.BUYER_CITY, SD.SHIP_TO_CITY) BUYER_CITY, DECODE(SD.SHIP_TO_STATE, NULL, SD.BUYER_STATE, SD.SHIP_TO_STATE) BUYER_STATE, DECODE(SD.SHIP_TO_ZIP, NULL, SD.BUYER_ZIP, SD.SHIP_TO_ZIP) BUYER_ZIP, DECODE(SD.SHIP_TO_COUNTRY, NULL, SD.BUYER_COUNTRY, SD.SHIP_TO_COUNTRY) BUYER_COUNTRY, SD.Sale_Date, B.LZ_MANIFEST_ID, im.item_code, SP.PULLER_NAME, SP.PULLING_DATE, im.item_mt_mfg_part_no mpn, im.item_mt_upc upc, c.cond_name, SD.QUANTITY, SD.TOTAL_PRICE, SD.SHIPPING_SERVICE, SD.STAMPS_SHIPPING_RATE, SM.LZ_SELLER_ACCT_ID, NVL(SP.PULLING_QTY, 0) PULLING_QTY, NVL(SP.CANCEL_QTY, 0) CANCEL_QTY, B.BARCODE_NO, b.item_id itm_id, WA.WAREHOUSE_NO, b.condition_id, B.Pulling_Id, LM.BUISNESS_NAME, LD.ACCOUNT_NAME, SD.Orderstatus ebay_status, SD.Order_Id, sd.SALES_RECORD_NO_GROUP, sd.extendedorderid, DECODE(Bi.BIN_ID, 0, 'NO BIN', 'W' || Wa.WAREHOUSE_NO || '-' || Rac.RACK_NO || '-R' || Ro.ROW_NO || '-' || Bi.BIN_TYPE || '-' || Bi.BIN_NO) BIN_LOCATION FROM LZ_SALESLOAD_DET SD, LZ_BARCODE_MT B, LJ_BIN_VERIFY_DT VF, LZ_AWAITING_SHIPMENT aw, BIN_MT BI, LZ_RACK_ROWS RO, RACK_MT RAC, lz_item_cond_mt c, WAREHOUSE_MT WA, items_mt im, LZ_SALESLOAD_MT SM, LJ_MERHCANT_ACC_DT LD, LZ_MERCHANT_MT LM, (SELECT P.SALES_RECORD_NO, P.EBAY_ITEM_ID, MAX(PULLER_NAME) PULLER_NAME, TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE, SUM(NVL(PULLING_QTY, 0)) PULLING_QTY, SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY FROM LZ_SALES_PULLING P GROUP BY P.SALES_RECORD_NO, P.EBAY_ITEM_ID) SP WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+) AND SD.ITEM_ID = SP.EBAY_ITEM_ID(+) AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+) and SD.ITEM_ID = B.EBAY_ITEM_ID AND VF.BARCODE_NO(+) = B.BARCODE_NO and sd.sales_record_number = to_Char(aw.salerecordid) AND SD.LZ_SALELOAD_ID = SM.LZ_SALELOAD_ID AND SM.LZ_SELLER_ACCT_ID = LD.ACCT_ID AND LD.MERCHANT_ID = LM.MERCHANT_ID AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+) AND RO.RACK_ID = RAC.RACK_ID(+) AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID(+) and b.condition_id = c.id(+) and im.item_id = b.item_id and sd.item_id = b.ebay_item_id AND B.PULLING_ID IS NULL and sd.uk_firebase_waiting is null and b.item_adj_det_id_for_out is null and b.lz_part_issue_mt_id is null and b.lz_pos_mt_id is null AND SD.GNRTD_DC_ID IS NULL AND SD.TRACKING_NUMBER IS NULL) SDD, (SELECT DISTINCT W.ITEM_ID, W.PACK_WEIGHT, W.SHIPPING_SERVICE, W.MACHINE_INPUT_YN FROM LZ_ITEM_PACK_WEIGHT W) WS WHERE NVL(SDD.QUANTITY, 0) <> (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0)) AND SDD.ITM_ID = WS.ITEM_ID(+) AND SDD.BARCODE_NO IS NOT NULL) get, lz_special_lots l, items_mt i, lz_dekit_us_dt dd, lz_item_cond_mt cc where def_barcode = l.barcode_prv_no(+) and def_barcode = dd.barcode_prv_no(+) and get.condition_id = cc.id(+) and itm_id = i.item_id and get.order_id = '$order_id'order by get.saleno asc";
 
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
}

public function update_fbKey($record_no, $fbKey)
{
  # code...  
       $fbKey_qry = $this->db->query("UPDATE LZ_SALESLOAD_DET D SET D.UK_FIREBASE_WAITING = '$fbKey' 
       WHERE D.SALES_RECORD_NUMBER = '$record_no'");
  if($fbKey_qry)
  {
    return 0;
  }
}


public function restock($ebay_id,$record_no)
{
  $barcode_qry = $this->db->query("UPDATE LZ_BARCODE_MT B 
                          SET B.LIST_ID = '',
                          B.EBAY_ITEM_ID='',  
                          B.SALE_RECORD_NO = ''
                           WHERE B.EBAY_ITEM_ID = '$ebay_id'AND 
                           B.SALE_RECORD_NO = '$record_no' AND
                            B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND
                             B.LZ_PART_ISSUE_MT_ID IS NULL AND
                              B.LZ_POS_MT_ID IS NULL AND
                               B.PULLING_ID IS NULL");
  if($barcode_qry)
  {
    return 0;
  }
  

}

public function seller_itemNotFound_brokenItem($ebay_id,$record_no,$cancel_option,$cancel_reason,$specific_barcode)
{
  $barcode_qry = " ";
  if($cancel_option == "Specific Barcode")
        {
            $barcode_query = " and m.barcode_no = '".$specific_barcode."'" ;
        }
  $main_query = "update lz_barcode_mt m 
  set m.condition_id = '-1' 
  , m.salvage_reason = '".$cancel_reason."' 
  where m.ebay_item_id = '".$ebay_id."'
  and m.sale_record_no = '".$record_no."'".$barcode_qry;
  $main_query = $this->db->query($main_query);
  return $main_query;
}

public function update_new_price($ebay_id,$record_no,$new_price)
{
  $update_query = "";
  $item_cond_id = $this->db->query("select m.item_id, m.condition_id
  from lz_barcode_mt m
 where m.sale_record_no = '$record_no'
 and m.ebay_item_id = '$ebay_id'
 group by m.item_id, m.condition_id")->result_array();
  
  if(isset($item_cond_id))
  {
    $item_id = $item_cond_id[0]['ITEM_ID'];
    $cond_id = $item_cond_id[0]['CONDITION_ID'];
    if(!is_null($item_id))
    {
      $update_query = "update lz_item_seed d 
      set d.ebay_price = '$new_price'
      where d.seed_id = (select max(s.seed_id)
      from lz_item_seed s
     where s.item_id = '$item_id'
       and s.default_cond = $cond_id)";
      $update_query = $this->db->query($update_query);

    }
  }
  return $update_query;

}

public function get_multi_location($ebay_id)
{
  $main_query = "SELECT DISTINCT 'W' || W.WAREHOUSE_NO || '-' || R.RACK_NO || '-R' || RR.ROW_NO || '-' || B.BIN_TYPE || '-' || B.BIN_NO B_LOCATION, BB.BARCODE_NO LOCATION_BARCODE_NO, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF FROM BIN_MT        B, RACK_MT       R, WAREHOUSE_MT  W, LZ_RACK_ROWS  RR, LZ_BARCODE_MT BB, LJ_BIN_VERIFY_DT VF WHERE B.BIN_ID = BB.BIN_ID AND B.CURRENT_RACK_ROW_ID = RR.RACK_ROW_ID AND R.RACK_ID = RR.RACK_ID AND R.WAREHOUSE_ID = W.WAREHOUSE_ID AND VF.BARCODE_NO(+) = BB.BARCODE_NO AND BB.EBAY_ITEM_ID = '$ebay_id'AND BB.PULLING_ID IS NULL AND BB.SALE_RECORD_NO IS NULL AND BB.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BB.LZ_PART_ISSUE_MT_ID IS NULL";
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
  

}
public function get_shiping_services()
{
  # code...  

  // var_dump('adasd');
  //exit;
    $shippingService = $this->db->query("SELECT * FROM LZ_SHIPING_NAME S WHERE S.STAMPS_SHIPING_CODE IS NOT NULL")->result_array();
  
    return $shippingService;
  
}
public function check_lz_dekit_us_det($barcode_no)
{
  $main_query = "select count(*) lz_dek_dt_yn from lz_dekit_us_dt d where d.barcode_prv_no = '".$barcode_no."'";
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
}

public function get_upc_mpn_cond($barcode_no)
{
  $main_query = "select d.item_mt_upc upc, d.item_mt_mfg_part_no mpn, c.cond_name,b.item_id,b.lz_manifest_id,b.condition_id
  from items_mt i, lz_manifest_det d, lz_barcode_mt b, lz_item_cond_mt c
 where b.item_id = i.item_id
   and b.lz_manifest_id = d.lz_manifest_id
   and d.laptop_item_code = i.item_code
   and c.id = b.condition_id
   and b.barcode_no = '".$barcode_no."'
   and rownum = 1";
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
}

public function get_test()

{
  $main_query = $this->db->query("select d.item_mt_upc upc, d.item_mt_mfg_part_no mpn, c.cond_name
  from items_mt i, lz_manifest_det d, lz_barcode_mt b, lz_item_cond_mt c
 where b.item_id = i.item_id
   and b.lz_manifest_id = d.lz_manifest_id
   and d.laptop_item_code = i.item_code
   and c.id = b.condition_id
--   and b.barcode_no = '109382'     --152216
   and d.item_mt_upc is null
   and rownum = 1")->result_array();
  return $main_query;
}

public function get_bin($bin_no)
{
  $bin_id = $this->db->query(" SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$bin_no' ")->result_array();
  
  if(isset($bin_id))
  {
    $bin_id = $bin_id[0]['BIN_ID'];
    if(is_null($bin_id))
    {
      $bin_id = 0;
    }
  }
  else
  {
    $bin_id = 0;
  }
return $bin_id;
}

public function get_old_bin($barcode_no, $table_name)
{
  $bin_id = $this->db->query(" select l.bin_id from ".$table_name." l where l.barcode_prv_no = '$barcode_no' ")->result_array();
  if(isset($bin_id))
  {
    $bin_id = $bin_id[0]['BIN_ID'];
    if(is_null($bin_id))
    {
      $bin_id = 0;
    }
  }
  else
  {
    $bin_id = 0;
  }
return $bin_id;
}

public function update_bin($barcode_no, $bin_id, $table_name)
{
  $query = $this->db->query("update ".$table_name." l set l.bin_id = ".$bin_id." where l.barcode_prv_no = '$barcode_no' ");
  
  return $query;
}

public function get_lot_id($barcode_no)
{
  $main_query = "select m.lot_id from lz_merchant_barcode_mt m , lz_merchant_barcode_dt d
  where m.mt_id = d.mt_id
  and d.barcode_no = '$barcode_no' ";
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
}
public function pulled_orders()
{
  
  $main_query = "SELECT SDD.sales_record_number,
  decode(MAX(SDD.FOLDER_NAME),null,'master_pictures/'|| trim(MAX(SDD.UPC))||'~'||replace(trim(MAX(SDD.MPN)),'/','_')||'/'||trim(MAX(SDD.COND_NAME)),'dekitted_pictures/'||MAX(sdd.folder_name)) fol_name,
  'master_pictures/'|| trim(MAX(SDD.UPC))||'~'||replace(trim(MAX(SDD.MPN)),'/','_')||'/'||trim(MAX(SDD.COND_NAME)) FOL_NAME1,
 MAX(SDD.USER_ID) USER_ID,
 MAX(SDD.BUYER_FULLNAME) FULLNAME,
 MAX(SDD.BUYER_ADDRESS1) ADDRESS1,
 MAX(SDD.BUYER_ADDRESS2) ADDRESS2,
 MAX(SDD.BUYER_CITY) BUYER_CITY,
 MAX(SDD.BUYER_STATE) BUYER_STATE,
 MAX(SDD.BUYER_ZIP) BUYER_ZIP,
 MAX(SDD.BUYER_COUNTRY) BUYER_COUNTRY,
 MAX(SDD.ITEM_ID) ITEM_ID,
 MAX(SDD.ITM_ID) ITM_ID,
 MAX(SDD.ITEM_TITLE) ITEM_TITLE,
 MAX(SDD.QUANTITY) QUANTITY,
 MAX(SDD.PULLING_QTY) PULLING_QTY,
 MAX(SDD.CANCEL_QTY) CANCEL_QTY,
 MAX(SDD.BARCODE_NO) BARCODE_NO,
 MAX(SDD.PULLER_NAME) PULLER_NAME,
 MAX(SDD.PULLING_DATE) PULLING_DATE,
 MAX(SDD.MPN) MPN,
 MAX(SDD.UPC) UPC,
 MAX(SDD.COND_NAME) COND_NAME,
 MAX(SDD.FOLDER_NAME) FOLDER_NAME,
 MAX(EB.LZ_SELLER_ACCT_ID) LZ_SELLER_ACCT_ID,
 MAX(SDD.TOTAL_PRICE) TOTAL_PRICE,
 2 order_status,
  decode(MAX(SDD.STAMPS_SHIPPING_RATE),NULL,0,MAX(SDD.STAMPS_SHIPPING_RATE)) STAMPS_SHIPPING_RATE,
 decode( DECODE(MAX(WS.PACK_WEIGHT),NULL,MAX(MD.WEIGHT),MAX(WS.PACK_WEIGHT))
 ,null,0,DECODE(MAX(WS.PACK_WEIGHT),NULL,MAX(MD.WEIGHT),MAX(WS.PACK_WEIGHT)))PACK_WEIGHT,
  DECODE(MAX(WS.MACHINE_INPUT_YN),NULL,0,MAX(WS.MACHINE_INPUT_YN)) MACHINE_INPUT_YN,
 MAX(SDD.SHIPPING_SERVICE) SHIPPING_SERVICE
   FROM (SELECT SD.SALES_RECORD_NUMBER,
                SD.USER_ID,
                SD.BUYER_FULLNAME,
                DECODE(SD.SHIP_TO_ADDRESS1,NULL,SD.BUYER_ADDRESS1,SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1,
                DECODE(SD.SHIP_TO_ADDRESS2,NULL,SD.BUYER_ADDRESS2,SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2,
                DECODE(SD.SHIP_TO_CITY,NULL,SD.BUYER_CITY,SD.SHIP_TO_CITY) BUYER_CITY,
                DECODE(SD.SHIP_TO_STATE,NULL,SD.BUYER_STATE,SD.SHIP_TO_STATE) BUYER_STATE,
                DECODE(SD.SHIP_TO_ZIP,NULL,SD.BUYER_ZIP,SD.SHIP_TO_ZIP) BUYER_ZIP,
                DECODE(SD.SHIP_TO_COUNTRY,NULL,SD.BUYER_COUNTRY,SD.SHIP_TO_COUNTRY) BUYER_COUNTRY,
                SD.ITEM_ID,
                SD.TOTAL_PRICE,
                SD.SHIPPING_SERVICE,
                SD.STAMPS_SHIPPING_RATE,
                SD.ITEM_TITLE,
                SD.QUANTITY,
                NVL(SP.PULLING_QTY, 0) PULLING_QTY,
                NVL(SP.CANCEL_QTY, 0) CANCEL_QTY,
                B.BARCODE_NO,
                B.LZ_MANIFEST_ID,
                im.item_code,
                SP.PULLER_NAME,
                SP.PULLING_DATE,
                im.item_mt_mfg_part_no mpn,
                im.item_mt_upc upc,
                im.item_id itm_id,
                c.cond_name,
                decode(sl.folder_name, null, dk.folder_name, null) folder_name
           FROM LZ_SALESLOAD_DET SD,
                LZ_SALESLOAD_MT LM,
                LZ_BARCODE_MT B,
               
                items_mt im,
                lz_item_cond_mt c,
                lz_special_lots sl,
                lz_dekit_us_dt dk,
                lz_awaiting_shipment aw,
                (SELECT SALES_RECORD_NO,
                        MAX(PULLER_NAME) PULLER_NAME,
                        TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE,
                        SUM(NVL(PULLING_QTY, 0)) PULLING_QTY,
                        SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY
                   FROM LZ_SALES_PULLING
                  GROUP BY SALES_RECORD_NO) SP
          WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+)
            AND LM.LZ_SALELOAD_ID = SD.LZ_SALELOAD_ID
            AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+)
            and im.item_id = b.item_id
            and c.id = b.condition_id
            and b.barcode_no = sl.barcode_prv_no(+)
            and b.barcode_no = dk.barcode_prv_no(+)
            and sd.sales_record_number = to_char(aw.salerecordid)
         ORDER BY SD.SALE_DATE DESC NULLS LAST
          ) SDD,
          (SELECT DISTINCT E.EBAY_ITEM_ID, E.LZ_SELLER_ACCT_ID
           FROM EBAY_LIST_MT E) EB,
          (SELECT DISTINCT W.ITEM_ID,W.PACK_WEIGHT,W.SHIPPING_SERVICE, W.MACHINE_INPUT_YN 
          FROM LZ_ITEM_PACK_WEIGHT W) WS,
          (SELECT D.WEIGHT, D.LZ_MANIFEST_ID,D.LAPTOP_ITEM_CODE FROM LZ_MANIFEST_DET D) MD
  WHERE  NVL(SDD.QUANTITY, 0) <
        (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0))
    AND SDD.PULLING_QTY > 0
    AND SDD.ITEM_ID = EB.EBAY_ITEM_ID
     AND SDD.ITM_ID = WS.ITEM_ID(+)
       and sdd.item_code = md.laptop_item_code(+)
     and SDD.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID(+)
    --AND TO_DATE(SDD.SALE_DATE, 'MM/DD/YYYY HH24:MI:SS') >= (SYSDATE - 7)
  group by sdd.sales_record_number
  --ORDER BY SDD.SALE_DATE DESC NULLS LAST
  union
  SELECT SDD.sales_record_number,
  decode(MAX(SDD.FOLDER_NAME),null,'master_pictures/'|| trim(MAX(SDD.UPC))||'~'||replace(trim(MAX(SDD.MPN)),'/','_')||'/'||trim(MAX(SDD.COND_NAME)),'dekitted_pictures/'||MAX(sdd.folder_name)) fol_name,
  'master_pictures/'|| trim(MAX(SDD.UPC))||'~'||replace(trim(MAX(SDD.MPN)),'/','_')||'/'||trim(MAX(SDD.COND_NAME)) FOL_NAME1,
 MAX(SDD.USER_ID) USER_ID,
 MAX(SDD.BUYER_FULLNAME) FULLNAME,
 MAX(SDD.BUYER_ADDRESS1) ADDRESS1,
 MAX(SDD.BUYER_ADDRESS2) ADDRESS2,
 MAX(SDD.BUYER_CITY) BUYER_CITY,
 MAX(SDD.BUYER_STATE) BUYER_STATE,
 MAX(SDD.BUYER_ZIP) BUYER_ZIP,
 MAX(SDD.BUYER_COUNTRY) BUYER_COUNTRY,
 MAX(SDD.ITEM_ID) ITEM_ID,
 MAX(SDD.ITM_ID) ITM_ID,
 MAX(SDD.ITEM_TITLE) ITEM_TITLE,
 MAX(SDD.QUANTITY) QUANTITY,
 MAX(SDD.PULLING_QTY) PULLING_QTY,
 MAX(SDD.CANCEL_QTY) CANCEL_QTY,
 MAX(SDD.BARCODE_NO) BARCODE_NO,
 MAX(SDD.PULLER_NAME) PULLER_NAME,
 MAX(SDD.PULLING_DATE) PULLING_DATE,
 MAX(SDD.MPN) MPN,
 MAX(SDD.UPC) UPC,
 MAX(SDD.COND_NAME) COND_NAME,
 MAX(SDD.FOLDER_NAME) FOLDER_NAME,
 MAX(EB.LZ_SELLER_ACCT_ID) LZ_SELLER_ACCT_ID,
 MAX(SDD.TOTAL_PRICE) TOTAL_PRICE,
 MAX(SDD.PULLING_PRINT_YN) order_status,
  decode(MAX(SDD.STAMPS_SHIPPING_RATE),NULL,0,MAX(SDD.STAMPS_SHIPPING_RATE)) STAMPS_SHIPPING_RATE,
 decode( DECODE(MAX(WS.PACK_WEIGHT),NULL,MAX(MD.WEIGHT),MAX(WS.PACK_WEIGHT))
 ,null,0,DECODE(MAX(WS.PACK_WEIGHT),NULL,MAX(MD.WEIGHT),MAX(WS.PACK_WEIGHT)))PACK_WEIGHT,
  DECODE(MAX(WS.MACHINE_INPUT_YN),NULL,0,MAX(WS.MACHINE_INPUT_YN)) MACHINE_INPUT_YN,
MAX(SDD.SHIPPING_SERVICE) SHIPPING_SERVICE
   FROM (SELECT SD.SALES_RECORD_NUMBER,
                SD.USER_ID,
                SD.STAMPS_SHIPPING_RATE,
                SD.BUYER_FULLNAME,
                DECODE(SD.SHIP_TO_ADDRESS1,NULL,SD.BUYER_ADDRESS1,SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1,
                DECODE(SD.SHIP_TO_ADDRESS2,NULL,SD.BUYER_ADDRESS2,SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2,
                DECODE(SD.SHIP_TO_CITY,NULL,SD.BUYER_CITY,SD.SHIP_TO_CITY) BUYER_CITY,
                DECODE(SD.SHIP_TO_STATE,NULL,SD.BUYER_STATE,SD.SHIP_TO_STATE) BUYER_STATE,
                DECODE(SD.SHIP_TO_ZIP,NULL,SD.BUYER_ZIP,SD.SHIP_TO_ZIP) BUYER_ZIP,
                DECODE(SD.SHIP_TO_COUNTRY,NULL,SD.BUYER_COUNTRY,SD.SHIP_TO_COUNTRY) BUYER_COUNTRY,
                SD.ITEM_ID,
                SD.ITEM_TITLE,
                SD.QUANTITY,

                SD.SHIPPING_SERVICE,
                NVL(SP.PULLING_QTY, 0) PULLING_QTY,
                NVL(SP.CANCEL_QTY, 0) CANCEL_QTY,
                B.BARCODE_NO,
                B.LZ_MANIFEST_ID,
                im.item_code,
                B.PULLING_PRINT_YN,
                SP.PULLER_NAME,
                SP.PULLING_DATE,
                im.item_mt_mfg_part_no mpn,
                im.item_mt_upc upc,
                im.item_id itm_id,
                SD.TOTAL_PRICE,
                c.cond_name,
                decode(sl.folder_name, null, dk.folder_name, null) folder_name
           FROM LZ_SALESLOAD_DET SD,
                LZ_SALESLOAD_MT LM,
                LZ_BARCODE_MT B,
               
                items_mt im,
                lz_item_cond_mt c,
                lz_special_lots sl,
                lz_dekit_us_dt dk,
                lz_awaiting_shipment aw,
                (SELECT SALES_RECORD_NO,
                        MAX(PULLER_NAME) PULLER_NAME,
                        TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE,
                        SUM(NVL(PULLING_QTY, 0)) PULLING_QTY,
                        SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY
                   FROM LZ_SALES_PULLING
                  GROUP BY SALES_RECORD_NO) SP
          WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+)
            AND LM.LZ_SALELOAD_ID = SD.LZ_SALELOAD_ID
            AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+)
            and im.item_id = b.item_id
            and c.id = b.condition_id
            and b.barcode_no = sl.barcode_prv_no(+)
            and b.barcode_no = dk.barcode_prv_no(+)
            and sd.sales_record_number = to_char(aw.salerecordid)
         ORDER BY SD.SALE_DATE DESC NULLS LAST
          ) SDD,
           (SELECT DISTINCT E.EBAY_ITEM_ID, E.LZ_SELLER_ACCT_ID
           FROM EBAY_LIST_MT E) EB,
          (SELECT DISTINCT W.ITEM_ID,W.PACK_WEIGHT,W.SHIPPING_SERVICE, W.MACHINE_INPUT_YN 
          FROM LZ_ITEM_PACK_WEIGHT W) WS,
          (SELECT D.WEIGHT, D.LZ_MANIFEST_ID,D.LAPTOP_ITEM_CODE FROM LZ_MANIFEST_DET D) MD
  WHERE  NVL(SDD.QUANTITY, 0) =
        (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0))
    AND SDD.PULLING_QTY > 0
 AND SDD.ITEM_ID = EB.EBAY_ITEM_ID
  AND SDD.ITM_ID = WS.ITEM_ID(+)
    and sdd.item_code = md.laptop_item_code(+)
     and SDD.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID(+)
    --AND TO_DATE(SDD.SALE_DATE, 'MM/DD/YYYY HH24:MI:SS') >= (SYSDATE - 7)
  group by sdd.sales_record_number
  --ORDER BY SDD.SALE_DATE DESC NULLS LAST
 ";
 
  $main_query = $this->db->query($main_query)->result_array();
  return $main_query;
}
public function update_pulling_print($sale_record_no,$ebayid)
{
  $query = $this->db->query("update lz_barcode_mt m set m.pulling_print_yn = 1 where m.sale_record_no =  '$sale_record_no' and m.ebay_item_id =  '$ebayid' ");
  
  return $query;
}
public function item_pack_weight($item_id,$weight, $machine_input_yn)
{
  $query = $this->db->query("select * from lz_item_pack_weight m where m.item_id = '".$item_id."'");
  if($query->num_rows() > 0)
  {
    $query = $this->db->query("update lz_item_pack_weight m set m.machine_input_yn= '".$machine_input_yn."', m.pack_weight = '".$weight."' where m.item_id = '".$item_id."'");
  }
  else{
  $query = $this->db->query("insert into lz_item_pack_weight l(l.lz_item_pack_weight_id,l.item_id,
  l.pack_weight, l.machine_input_yn)
   values(get_single_primary_key('lz_item_pack_weight','lz_item_pack_weight_id'),
   $item_id,$weight,$machine_input_yn)");
  }
   return $query;
}
public function update_stamps_rate($sale_record_no,$ebayid,$rate)
{
  $query = $this->db->query("update lz_salesload_det d set d.stamps_shipping_rate =  $rate
                              where d.sales_record_number =   '$sale_record_no'  and d.item_id = '$ebayid'");
  
  return $query;
}

public function update_trackingNumber($sale_record_no,$ebayid,$TRACKING_NUMBER, $shippingLabelRate)
{
  $query = $this->db->query("update lz_salesload_det d set d.tracking_number =  '$TRACKING_NUMBER', d.shippingLabelRate = '$shippingLabelRate'
                              where d.sales_record_number =   '$sale_record_no' and d.item_id = '$ebayid'");
  
  return $query;
}
public function getUpdate_trackingNumber($order_array)
{
  $string_array = "";
  $i = 1;
  $length = sizeof($order_array);
  foreach ($order_array as $order_id){
    if($i >= 1 && $i < $length){
    $string_array .= "'".$order_id ."'". ",";
    }
    if( $i == $length ){
    $string_array .= "'".$order_id ."'";
    }
    $i++;
}
  $query = $this->db->query("select d.tracking_number, d.sales_record_number saleno,d.orderstatus
  from lz_salesload_det d
 where d.order_id in ($string_array )")->result_array();
  
  return $query;
}

}
?>