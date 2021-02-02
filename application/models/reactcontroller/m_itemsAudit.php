<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_itemsAudit extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function getItemsHistory(){
        $startDate = $this->input->post("startDate");
        $endDate   = $this->input->post("endDate");

        $listed = $this->db->query("SELECT NVL(COUNT(BM.EBAY_ITEM_ID),0) TOTAL_ITEMS, NVL(SUM((COUNT(BM.EBAY_ITEM_ID))),0) TOTAL_BARCODES 
                                    FROM LZ_BARCODE_MT BM,
                                        EBAY_LIST_MT EM
                                    WHERE BM.LIST_ID = EM.LIST_ID
                                    AND EM.LIST_DATE BETWEEN
                                          TO_DATE('$startDate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND
                                          TO_DATE('$endDate 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                                    AND BM.EBAY_ITEM_ID IS NOT NULL
                                    GROUP BY BM.EBAY_ITEM_ID")->result_array();

        $discarded = $this->db->query("SELECT NVL(COUNT(BM.ITEM_ID),0) TOTAL_ITEMS, NVL(SUM(COUNT(BM.BARCODE_NO)),0) TOTAL_BARCODES FROM LZ_BARCODE_MT BM
                                        WHERE BM.DISCARD = 1
                                        AND BM.DISCARD_DATE BETWEEN
                                              TO_DATE('$startDate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND
                                              TO_DATE('$endDate 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                                        GROUP BY BM.ITEM_ID")->result_array();

        $awaitingShipment = $this->db->query("SELECT NVL(COUNT(BM.EBAY_ITEM_ID),0) TOTAL_ITEMS,
                                                    NVL(SUM(COUNT(BM.BARCODE_NO)),0) TOTAL_BARCODES
                                                FROM LZ_BARCODE_MT BM, LZ_AWAITING_SHIPMENT LA, LZ_SALESLOAD_DET DET
                                              WHERE LA.ORDERLINEITEMID = BM.ORDER_ID
                                                AND BM.ORDER_ID = DET.ORDER_ID
                                                AND DET.SALE_DATE BETWEEN
                                                    TO_DATE('$startDate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND
                                                    TO_DATE('$endDate 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                                                AND BM.BIN_ID NOT IN
                                                    (SELECT BIN.BIN_ID FROM BIN_MT BIN WHERE BIN.BIN_TYPE = 'WB')
                                              GROUP BY BM.EBAY_ITEM_ID")->result_array();
        if($listed || $discarded || $awaitingShipment){
          return array("found" => true, "listed" => $listed, "discarded" => $discarded, "awaitingShipment" => $awaitingShipment);
        }else{
          return array("found" => false, "message" => "No Data Found!");
        }
    }
    public function getItemsHistoryContent(){
        $method = $this->input->post("method");
        $startDate = $this->input->post("startDate");
        $endDate   = $this->input->post("endDate");
        $selectedUser   = $this->input->post("selectedUser");
        $callFrom   = $this->input->post("callFrom");
        $itemHistoryContent = "";
            $userQuery = "";
        if($callFrom == 'ItemHistory'){
            $userQuery = "";
        }else if($callFrom == 'ItemHistoryContent'){
          if($selectedUser == 'All'){
              $userQuery = "";
            }else if($selectedUser == 'PK'){
              $userQuery = "AND EMP.LOCATION = '$selectedUser' ";
            }else if($selectedUser == 'US'){
              $userQuery = "AND EMP.LOCATION = '$selectedUser' ";
            }else if($selectedUser != '' ){
              $userQuery = "AND EMP.EMPLOYEE_ID = '$selectedUser' ";
            }
        }

        if($method == "listed"){
          $itemHistoryContent = $this->db->query("SELECT BM.BARCODE_NO,
                                                          BM.BIN_ID,
                                                          BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
                                                          SD.ITEM_TITLE DESCR,
                                                          SD.F_UPC UPC,
                                                          SD.F_MPN MPN,
                                                          SD.F_MANUFACTURE BRAND,
                                                          EM.STATUS,
                                                          CON.COND_NAME,
                                                          EM.LIST_PRICE,
                                                          EMP.USER_NAME LISTER_NAME,
                                                          TO_CHAR(EM.LIST_DATE, 'DD-MM-YY HH24:MI:SS') LIST_DATE,
                                                          (CASE
                                                            WHEN BM.PULLING_ID IS NOT NULL THEN
                                                              'PULLED'
                                                            ELSE
                                                              'NOTPULLED'
                                                          END) PULLED_STATUS,
                                                          BM.EBAY_ITEM_ID,
                                                          (CASE
                                                            WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
                                                              'LISTED'
                                                            ELSE
                                                              'NOT'
                                                          END) LISTED_YN_CONTENT,
                                                          (SELECT DT.BARCODE_NO
                                                              FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                                                            WHERE DT.BARCODE_NO = BM.BARCODE_NO
                                                              AND ROWNUM = 1) VERIFIED_YN,
                                                          (SELECT TO_CHAR(MT.VERIFY_DATE, 'DD-MM-YY HH24:MI:SS')
                                                              FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                                                            WHERE DT.BARCODE_NO = BM.BARCODE_NO
                                                              AND ROWNUM = 1) OUT_BOUND
                                                      FROM LZ_BARCODE_MT   BM,
                                                          LZ_ITEM_SEED    SD,
                                                          LZ_ITEM_COND_MT CON,
                                                          EBAY_LIST_MT    EM,
                                                          BIN_MT          BIN,
                                                          EMPLOYEE_MT     EMP
                                                    WHERE BM.LIST_ID = EM.LIST_ID
                                                      AND BM.ITEM_ID = SD.ITEM_ID
                                                      AND SD.DEFAULT_COND = CON.ID
                                                      AND BM.CONDITION_ID = SD.DEFAULT_COND
                                                      AND EMP.EMPLOYEE_ID = EM.LISTER_ID
                                                      AND BM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID
                                                      AND BM.BIN_ID = BIN.BIN_ID
                                                      AND BM.DISCARD = 0
                                                      AND EM.LIST_DATE BETWEEN
                                                          TO_DATE('$startDate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND
                                                          TO_DATE('$endDate 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                                                          $userQuery
                                                      AND BM.EBAY_ITEM_ID IS NOT NULL
                                                    ORDER BY EM.LIST_DATE DESC")->result_array();
        }else if($method == "shipment"){
          $itemHistoryContent = $this->db->query("SELECT BM.BARCODE_NO,
                                                          BM.BIN_ID,
                                                          BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
                                                          SD.ITEM_TITLE DESCR,
                                                          SD.F_UPC UPC,
                                                          SD.F_MPN MPN,
                                                          SD.F_MANUFACTURE BRAND,
                                                          EM.STATUS,
                                                          CON.COND_NAME,
                                                          EM.LIST_PRICE,
                                                          EMP.USER_NAME LISTER_NAME,
                                                          TO_CHAR(EM.LIST_DATE, 'DD-MM-YY HH24:MI:SS') LIST_DATE,
                                                          (CASE
                                                            WHEN BM.PULLING_ID IS NOT NULL THEN
                                                              'PULLED'
                                                            ELSE
                                                              'NOTPULLED'
                                                          END) PULLED_STATUS,
                                                          BM.EBAY_ITEM_ID,
                                                          (CASE
                                                            WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
                                                              'LISTED'
                                                            ELSE
                                                              'NOT'
                                                          END) LISTED_YN_CONTENT,
                                                          (SELECT DT.BARCODE_NO
                                                              FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                                                            WHERE DT.BARCODE_NO = BM.BARCODE_NO
                                                              AND ROWNUM = 1) VERIFIED_YN,
                                                          (SELECT TO_CHAR(MT.VERIFY_DATE, 'DD-MM-YY HH24:MI:SS')
                                                              FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                                                            WHERE DT.BARCODE_NO = BM.BARCODE_NO
                                                              AND ROWNUM = 1) OUT_BOUND
                                                      FROM LZ_BARCODE_MT        BM,
                                                          LZ_ITEM_SEED         SD,
                                                          LZ_ITEM_COND_MT      CON,
                                                          EBAY_LIST_MT         EM,
                                                          BIN_MT               BIN,
                                                          EMPLOYEE_MT          EMP,
                                                          LZ_AWAITING_SHIPMENT LA,
                                                          LZ_SALESLOAD_DET     DET
                                                    WHERE BM.LIST_ID = EM.LIST_ID
                                                      AND BM.ITEM_ID = SD.ITEM_ID
                                                      AND SD.DEFAULT_COND = CON.ID
                                                      AND BM.CONDITION_ID = SD.DEFAULT_COND
                                                      AND EMP.EMPLOYEE_ID = EM.LISTER_ID
                                                      AND BM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID
                                                      AND BM.BIN_ID = BIN.BIN_ID
                                                      AND LA.ORDERLINEITEMID = BM.ORDER_ID
                                                      AND BM.ORDER_ID = DET.ORDER_ID
                                                      AND BM.EBAY_ITEM_ID IS NOT NULL
                                                      AND BM.BIN_ID NOT IN
                                                          (SELECT BIN.BIN_ID FROM BIN_MT BIN WHERE BIN.BIN_TYPE = 'WB')
                                                      AND DET.SALE_DATE BETWEEN
                                                          TO_DATE('$startDate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND
                                                          TO_DATE('$endDate 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
                                                          $userQuery
                                                    ORDER BY EM.LIST_DATE DESC")->result_array();

        }else if($method == "discarded"){
          $itemHistoryContent = $this->db->query("SELECT BM.BARCODE_NO,
                                                          BM.BIN_ID,
                                                          BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
                                                          SD.ITEM_TITLE DESCR,
                                                          SD.F_UPC UPC,
                                                          SD.F_MPN MPN,
                                                          SD.F_MANUFACTURE BRAND,
                                                          EM.STATUS,
                                                          CON.COND_NAME,
                                                          EM.LIST_PRICE,
                                                          EMP.USER_NAME LISTER_NAME,
                                                          (CASE
                                                            WHEN BM.PULLING_ID IS NOT NULL THEN
                                                              'PULLED'
                                                            ELSE
                                                              'NOTPULLED'
                                                          END) PULLED_STATUS,
                                                          BM.EBAY_ITEM_ID,
                                                          (CASE
                                                            WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
                                                               'LISTED'
                                                            ELSE
                                                              'NOT'
                                                          END) LISTED_YN_CONTENT,
                                                          (SELECT DT.BARCODE_NO
                                                              FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                                                            WHERE DT.BARCODE_NO = BM.BARCODE_NO
                                                              AND ROWNUM = 1) VERIFIED_YN,
                                                          (SELECT TO_CHAR(MT.VERIFY_DATE, 'DD-MM-YY HH24:MI:SS')
                                                              FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                                                            WHERE DT.BARCODE_NO = BM.BARCODE_NO
                                                              AND ROWNUM = 1) OUT_BOUND
                                                      FROM LZ_BARCODE_MT   BM,
                                                          LZ_ITEM_SEED    SD,
                                                          LZ_ITEM_COND_MT CON,
                                                          EBAY_LIST_MT    EM,
                                                          BIN_MT          BIN,
                                                          EMPLOYEE_MT     EMP,
                                                    WHERE BM.ITEM_ID = SD.ITEM_ID
                                                      AND SD.DEFAULT_COND = BM.CONDITION_ID
                                                      AND SD.LZ_MANIFEST_ID = BM.LZ_MANIFEST_ID
                                                      AND SD.DEFAULT_COND = CON.ID
                                                      AND EMP.EMPLOYEE_ID = EM.LISTER_ID
                                                      AND BM.BIN_ID = BIN.BIN_ID
                                                      AND BM.DISCARD = 1
                                                      $userQuery
                                                      AND BM.DISCARD_DATE BETWEEN
                                                          TO_DATE('$startDate 00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND
                                                          TO_DATE('$endDate 23:59:59', 'YYYY-MM-DD HH24:MI:SS')")->result_array();
        }
        
          if($itemHistoryContent){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array();
            $uri = $this->get_pictures_by_barcode($itemHistoryContent,$conditions);
            $images = $uri['uri'];
            return array("found" => true, "itemHistoryContent" => $itemHistoryContent, "queryFrom" => $method, "images"=>$images);
          }else{
            return array("found" => false, "message" => "No Data Found!");
          }
    }
    public function getPictureBinRecords(){
      $pictureBin = $this->db->query("SELECT BM.BARCODE_NO,
       BM.BIN_ID,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       BM.EBAY_ITEM_ID,
       DECODE (BM.BARCODE_NOTES,(SELECT DEK.DEKIT_REMARKS FROM LZ_DEKIT_US_DT DEK WHERE DEK.BARCODE_PRV_NO = BM.BARCODE_NO),
       (SELECT LOT.LOT_REMARKS FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = BM.BARCODE_NO))  ITEM_REMARKS,
       BM.DISCARD,
       BM.DISCARD_REMARKS,
       (CASE WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN 'LISTED' ELSE 'NOT' END) LISTED_YN_CONTENT
  FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT, LZ_BARCODE_MT BM, ITEMS_MT I, BIN_MT BIN
 WHERE MT.VERIFY_ID = DT.VERIFY_ID
   AND BIN.BIN_ID = MT.BIN_ID
   AND BM.BARCODE_NO = DT.BARCODE_NO
   AND BM.ITEM_ID = I.ITEM_ID
   AND BM.PULLING_ID IS NULL
   AND BM.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND BM.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND BM.LZ_POS_MT_ID IS NULL
   AND BM.LZ_PART_ISSUE_MT_ID IS NULL
   AND MT.BIN_ID IN
       (SELECT BIM.BIN_ID FROM BIN_MT BIM WHERE BIM.BIN_TYPE = 'PB')
")->result_array();
if( count($pictureBin) > 0 ){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($pictureBin,$conditions);
            $images = $uri['uri'];
            return array("found" => true, "pictureBin"=>$pictureBin, "images"=>$images );
     }else{
         return array("found" => false, "message"=>"Picture Bin is Empty");
     }
    }
    public function searchBinContents(){
        $bin_name = strtoupper(trim($this->input->post('bin_name')));
 // Get location of the bin   
     $bind_ids = $this->db->query("SELECT CURRENT_RACK_ROW_ID RACK_ROW_ID,
       BIN_ID,
       'W' || '' || WAREHOUSE_NO || '-' || RACK_NO || ' | ' ||
       DECODE(ROW_NO,
              NULL,
              NULL,
              0,
              'N' || '' || ROW_NO,
              'R' || '' || ROW_NO) || ' | ' || BIN_NAME RACK_NAME,
              VERIFY_DATE,
              DAYS_LEFT
  FROM (SELECT B.BIN_ID,
               B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME,
               B.CURRENT_RACK_ROW_ID,
               RA.RACK_NO,
               MT.WAREHOUSE_NO,
               R.ROW_NO,
               CASE WHEN TO_DATE(MV.VERIFY_DATE) + 15 >= TO_DATE(SYSDATE)  THEN
                    'Valid Till: ' || TO_CHAR(TO_DATE(MV.VERIFY_DATE) + 15)
                    WHEN TO_DATE(MV.VERIFY_DATE) + 15 < TO_DATE(SYSDATE) THEN
                      'Verified Date Expired! last verified: ' ||  TO_CHAR(TO_DATE(MV.VERIFY_DATE))
                      END VERIFY_DATE,
               CASE 
                  WHEN (TO_DATE(MV.VERIFY_DATE) + 15) > TO_DATE(SYSDATE) THEN
                     'Days Left: ' || TO_CHAR( 15 - ( TO_DATE(SYSDATE) - TO_DATE(MV.VERIFY_DATE) )  )
                  WHEN TO_DATE(SYSDATE) > (TO_DATE(MV.VERIFY_DATE) + 15) THEN
                     'Last Verified: ' || TO_CHAR(( TO_DATE(SYSDATE) - TO_DATE(MV.VERIFY_DATE))) || ' Days Before'
                  WHEN (TO_DATE(MV.VERIFY_DATE) + 15) = TO_DATE(SYSDATE) THEN
                    '15 Days Complete'
                 END DAYS_LEFT
          FROM BIN_MT B, LZ_RACK_ROWS R, RACK_MT RA, WAREHOUSE_MT MT, LJ_BIN_VERIFY_MT MV
         WHERE B.CURRENT_RACK_ROW_ID = R.RACK_ROW_ID
           AND B.BIN_ID = MV.BIN_ID(+)
           AND RA.WAREHOUSE_ID = MT.WAREHOUSE_ID
           AND R.RACK_ID = RA.RACK_ID)
 WHERE BIN_NAME = '$bin_name'")->result_array();
 // #END# Get location of the bin

 //Get bin contents
     if (count($bind_ids) >0) {
      $bin_id    = $bind_ids[0]['BIN_ID'];

      $verified = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT M WHERE BIN_ID = $bin_id")->result_array();
if($verified){
  $transfers = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       SD.ITEM_TITLE DESCR,
       SD.F_UPC      UPC,
       SD.F_MPN      MPN,
        MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
        TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       DECODE(B.BARCODE_NOTES,
              (SELECT DEK.DEKIT_REMARKS
                 FROM LZ_DEKIT_US_DT DEK
                WHERE DEK.BARCODE_PRV_NO = B.BARCODE_NO),
              (SELECT LOT.LOT_REMARKS
                 FROM LZ_SPECIAL_LOTS LOT
                WHERE LOT.BARCODE_PRV_NO = B.BARCODE_NO)) ITEM_REMARKS,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (CASE
         WHEN B.EBAY_ITEM_ID IS NOT NULL THEN
          'LISTED'
         ELSE
          'NOT'
       END) LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
       (SELECT TO_CHAR(MT.VERIFY_DATE, 'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B, LZ_ITEM_SEED SD, LJ_BIN_VERIFY_MT MT,
(SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
 FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
WHERE LL.LOC_TRANS_ID IN
      (SELECT MAX(L.LOC_TRANS_ID)
         FROM LZ_LOC_TRANS_LOG L
        GROUP BY L.BARCODE_NO)
  AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = SD.ITEM_ID(+)
   AND B.CONDITION_ID = SD.DEFAULT_COND(+)
   AND B.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.BIN_ID = MT.BIN_ID
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL
   AND B.ORDER_ID IS NULL
   AND B.EXTENDEDORDERID IS NULL
   AND B.BARCODE_NO NOT IN
       (SELECT BARCODE_NO
          FROM LJ_BARCODE_SHORTAGE_DT SR
         WHERE SR.BARCODE_NO = B.BARCODE_NO) 
   AND B.BIN_ID = $bin_id
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.LOT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_SPECIAL_LOTS LO,
  LJ_BIN_VERIFY_MT MT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
 AND LO.BIN_ID = MT.BIN_ID
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DEKIT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_DEKIT_US_DT LO,
  LJ_BIN_VERIFY_MT MT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
 AND LO.BIN_ID = MT.BIN_ID
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_NO BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       NULL ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_MERCHANT_BARCODE_DT LO,
  LJ_BIN_VERIFY_MT MT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
 AND LO.BIN_ID = MT.BIN_ID
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   AND LO.BIN_ID = $bin_id")->result_array();

}else{


      if (!empty($bin_id)) {
        $transfers = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       DECODE (B.BARCODE_NOTES,(SELECT DEK.DEKIT_REMARKS FROM LZ_DEKIT_US_DT DEK WHERE DEK.BARCODE_PRV_NO = B.BARCODE_NO),
       (SELECT LOT.LOT_REMARKS FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = B.BARCODE_NO))  ITEM_REMARKS,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (CASE WHEN B.EBAY_ITEM_ID IS NOT NULL THEN 'LISTED' ELSE 'NOT' END) LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND B.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   AND B.BIN_ID = $bin_id
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.LOT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_SPECIAL_LOTS LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DEKIT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_DEKIT_US_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_NO BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       NULL ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_MERCHANT_BARCODE_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   AND LO.BIN_ID = $bin_id")->result_array();
   if(!$transfers){
      $transfers = $this->db->query("SELECT B.BARCODE_NO,
                    B.BIN_ID,
                    I.ITEM_DESC DESCR,
                    I.ITEM_MT_UPC UPC,
                    I.ITEM_MT_MFG_PART_NO MPN,
                    MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
                      'PULLED' PULLED_STATUS,
                    TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
                    B.EBAY_ITEM_ID,
                    DECODE (B.BARCODE_NOTES,(SELECT DEK.DEKIT_REMARKS FROM LZ_DEKIT_US_DT DEK WHERE DEK.BARCODE_PRV_NO = B.BARCODE_NO),
                    (SELECT LOT.LOT_REMARKS FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = B.BARCODE_NO))  ITEM_REMARKS,
                    B.DISCARD,
                    B.DISCARD_REMARKS,
                    (CASE WHEN B.EBAY_ITEM_ID IS NOT NULL THEN 'LISTED' ELSE 'NOT' END) LISTED_YN_CONTENT,
                    (SELECT DT.BARCODE_NO
                        FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                      WHERE DT.BARCODE_NO = B.BARCODE_NO
                        AND ROWNUM = 1) VERIFIED_YN,
                        (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
                        FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
                      WHERE DT.BARCODE_NO = B.BARCODE_NO
                        AND ROWNUM = 1) OUT_BOUND
                FROM LZ_BARCODE_MT B,
                    ITEMS_MT I,
                    (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
                        FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
                      WHERE LL.LOC_TRANS_ID IN
                            (SELECT MAX(L.LOC_TRANS_ID)
                                FROM LZ_LOC_TRANS_LOG L
                              GROUP BY L.BARCODE_NO)
                        AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
              WHERE B.ITEM_ID = I.ITEM_ID(+)
                AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
                AND B.PULLING_ID IS NOT NULL
                AND B.BARCODE_NO NOT  IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
                AND B.BIN_ID = $bin_id")->result_array();
                }
      }else{
        $transfers = [];
      }
    }
     }else{
      $transfers = [];
     }

     //#END# Get bin contents
     if ( count($bind_ids) > 0 ){
       $bin_verified = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id ")->result_array();
       $binExist = false;
       if($bin_verified){
        $binExist = true;
       }else{
        $binExist = false;
       }
        if( count($transfers) > 0 ){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($transfers,$conditions);
            $images = $uri['uri'];
            return array("found" => true, "getImage" => true, "bind_ids"=>$bind_ids, "transfers"=>$transfers, "images"=>$images, "bin_verified" => $binExist );
        }
        return array("found" => true, "getImage" => false, "bind_ids"=>$bind_ids, "transfers"=>$transfers, "bin_verified" => $binExist );   
     }else{
         return array("found" => false, "message"=>"Bin Not Found");
     }
        

    }
    public function searchBinContentsWithoutShortage(){
        $bin_name = strtoupper(trim($this->input->post('bin_name')));
 // Get location of the bin   
     $bind_ids = $this->db->query("SELECT CURRENT_RACK_ROW_ID RACK_ROW_ID,
       BIN_ID,
       'W' || '' || WAREHOUSE_NO || '-' || RACK_NO || ' | ' ||
       DECODE(ROW_NO,
              NULL,
              NULL,
              0,
              'N' || '' || ROW_NO,
              'R' || '' || ROW_NO) || ' | ' || BIN_NAME RACK_NAME,
              VERIFY_DATE,
              DAYS_LEFT
  FROM (SELECT B.BIN_ID,
               B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME,
               B.CURRENT_RACK_ROW_ID,
               RA.RACK_NO,
               MT.WAREHOUSE_NO,
               R.ROW_NO,
               CASE WHEN TO_DATE(MV.VERIFY_DATE) + 15 >= TO_DATE(SYSDATE)  THEN
                    'Valid Till: ' || TO_CHAR(TO_DATE(MV.VERIFY_DATE) + 15)
                    WHEN TO_DATE(MV.VERIFY_DATE) + 15 < TO_DATE(SYSDATE) THEN
                      'Verified Date Expired! last verified: ' ||  TO_CHAR(TO_DATE(MV.VERIFY_DATE))
                      END VERIFY_DATE,
               CASE 
                  WHEN (TO_DATE(MV.VERIFY_DATE) + 15) > TO_DATE(SYSDATE) THEN
                     'Days Left: ' || TO_CHAR( 15 - ( TO_DATE(SYSDATE) - TO_DATE(MV.VERIFY_DATE) )  )
                  WHEN TO_DATE(SYSDATE) > (TO_DATE(MV.VERIFY_DATE) + 15) THEN
                     'Last Verified: ' || TO_CHAR(( TO_DATE(SYSDATE) - TO_DATE(MV.VERIFY_DATE))) || ' Days Before'
                  WHEN (TO_DATE(MV.VERIFY_DATE) + 15) = TO_DATE(SYSDATE) THEN
                    '15 Days Complete'
                 END DAYS_LEFT
          FROM BIN_MT B, LZ_RACK_ROWS R, RACK_MT RA, WAREHOUSE_MT MT, LJ_BIN_VERIFY_MT MV
         WHERE B.CURRENT_RACK_ROW_ID = R.RACK_ROW_ID
           AND B.BIN_ID = MV.BIN_ID(+)
           AND RA.WAREHOUSE_ID = MT.WAREHOUSE_ID
           AND R.RACK_ID = RA.RACK_ID)
 WHERE BIN_NAME = '$bin_name'")->result_array();
 // #END# Get location of the bin

 //Get bin contents
     if (count($bind_ids) >0) {
      $bin_id    = $bind_ids[0]['BIN_ID'];

      $verified = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT M WHERE BIN_ID = $bin_id")->result_array();
if($verified){
  $transfers = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       DECODE (B.BARCODE_NOTES,(SELECT DEK.DEKIT_REMARKS FROM LZ_DEKIT_US_DT DEK WHERE DEK.BARCODE_PRV_NO = B.BARCODE_NO),
       (SELECT LOT.LOT_REMARKS FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = B.BARCODE_NO))  ITEM_REMARKS,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (CASE WHEN B.EBAY_ITEM_ID IS NOT NULL THEN 'LISTED' ELSE 'NOT' END) LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       LJ_BIN_VERIFY_DT DT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.BARCODE_NO = DT.BARCODE_NO
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND B.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   AND B.BIN_ID = $bin_id
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.LOT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_SPECIAL_LOTS LO,
  LJ_BIN_VERIFY_DT DT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
 AND LO.BARCODE_PRV_NO = DT.BARCODE_NO
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DEKIT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_DEKIT_US_DT LO,
  LJ_BIN_VERIFY_DT DT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
 AND LO.BARCODE_PRV_NO = DT.BARCODE_NO
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_NO BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       NULL ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_MERCHANT_BARCODE_DT LO,
  LJ_BIN_VERIFY_DT DT,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
 AND LO.BARCODE_NO = DT.BARCODE_NO
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   AND LO.BIN_ID = $bin_id")->result_array();

}else{
  
      if (!empty($bin_id)) {
        $transfers = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       DECODE (B.BARCODE_NOTES,(SELECT DEK.DEKIT_REMARKS FROM LZ_DEKIT_US_DT DEK WHERE DEK.BARCODE_PRV_NO = B.BARCODE_NO),
       (SELECT LOT.LOT_REMARKS FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = B.BARCODE_NO))  ITEM_REMARKS,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (CASE WHEN B.EBAY_ITEM_ID IS NOT NULL THEN 'LISTED' ELSE 'NOT' END) LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND B.BARCODE_NO NOT  IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   AND B.BIN_ID = $bin_id
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.LOT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_SPECIAL_LOTS LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DEKIT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_DEKIT_US_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_NO BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       NULL ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       'NOT' LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_MERCHANT_BARCODE_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   AND LO.BIN_ID = $bin_id")->result_array();

   if(!$transfers){
      $transfers = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
        'PULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       DECODE (B.BARCODE_NOTES,(SELECT DEK.DEKIT_REMARKS FROM LZ_DEKIT_US_DT DEK WHERE DEK.BARCODE_PRV_NO = B.BARCODE_NO),
       (SELECT LOT.LOT_REMARKS FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = B.BARCODE_NO))  ITEM_REMARKS,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (CASE WHEN B.EBAY_ITEM_ID IS NOT NULL THEN 'LISTED' ELSE 'NOT' END) LISTED_YN_CONTENT,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NOT NULL
   AND B.BARCODE_NO NOT  IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   AND B.BIN_ID = $bin_id")->result_array();
   }
      }else{
        $transfers = [];
      }
    }
     }else{
      $transfers = [];
     }
     //#END# Get bin contents
     if ( count($bind_ids) > 0 ){
        $bin_verified = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id ")->result_array();
       $binExist = false;
       if($bin_verified){
        $binExist = true;
       }else{
        $binExist = false;
       }
        if( count($transfers) > 0 ){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($transfers,$conditions);
            $images = $uri['uri'];
            return array("found" => true, "getImage" => true, "bind_ids"=>$bind_ids, "transfers"=>$transfers, "images"=>$images, "bin_verified" => $binExist );
        }
        return array("found" => true, "getImage" => false, "bind_ids"=>$bind_ids, "transfers"=>$transfers, "bin_verified" => $binExist );   
     }else{
         return array("found" => false, "message"=>"Bin Not Found");
     }
        

    }
     /*=============================================
	=            By Tahir Amjad                    =
    ================================================*/
    //By danish on 3-3-2018 updated by Tahir Amjad on 5/9/2019
    function updateBin(){
    
    $current_location = $this->input->post('current_location');
    $current_bin_id = $this->input->post('current_bin_id');
    $bin_remarks = $this->input->post('bin_remarks');
    $current_row_id = $this->input->post('current_row_id');
    $new_rack = $this->input->post('new_rack');

    $new_rack= trim($this->input->post('new_rack'));
    $new_rack = str_replace("  ", " ", $new_rack);
    $new_rack = str_replace("'", "''", $new_rack);


    $bin_remarks= trim($this->input->post('bin_remarks'));
    $bin_remark = str_replace("  ", " ", $bin_remarks);
    $bin_remarks = str_replace("'", "''", $bin_remark);

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $transfer_by_id = $this->input->post('userId');

    $bindId = $this->db->query(" SELECT BIN_ID,BIN_NAME FROM (SELECT B.BIN_ID, DECODE(B.BIN_TYPE, 'TC', 'TC', 'PB', 'PB', 'WB', 'WB', 'AB', 'AB', 'DK', 'DK', 'NA', 'NA') || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_ID = $current_bin_id ")->result_array();

   
  if (count($bindId) > 0) {
      $new_bin_id = $bindId[0]['BIN_ID'];

       $rack_na = $this->db->query(" SELECT * FROM (SELECT RO.RACK_ROW_ID, 'W' || '' || WA.WAREHOUSE_NO || '-' || RA.RACK_NO || '-' || 'R' || RO.ROW_NO RACK_NAME FROM RACK_MT RA, WAREHOUSE_MT WA, LZ_RACK_ROWS RO WHERE RA.WAREHOUSE_ID = WA.WAREHOUSE_ID AND RA.RACK_ID = RO.RACK_ID AND RO.RACK_ROW_ID <> 0) WHERE RACK_NAME  = '$new_rack' ")->result_array();
         $rack_row_id = $rack_na[0]['RACK_ROW_ID'];

      $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BIN_TRANS_LOG','BIN_TRANS_LOG_ID') ID FROM DUAL");
          $rs = $qry->result_array();
          $bin_trans_id = $rs[0]['ID'];
      $updateBin = $this->db->query("INSERT INTO LZ_BIN_TRANS_LOG (BIN_TRANS_LOG_ID, BIN_ID,OLD_RACK_ROW_ID,NEW_RACK_ROW_ID,TRANSFER_DATE,TRANSFER_BY,REMARKS) VALUES($bin_trans_id, $current_bin_id,
      '$current_row_id',$rack_row_id,$transfer_date,$transfer_by_id,'$bin_remarks')");
      if ($updateBin) {
          $this->db->query(" UPDATE BIN_MT BK SET BK.CURRENT_RACK_ROW_ID = $rack_row_id WHERE BK.BIN_ID  = $new_bin_id  ");

          $binLocationRecord = $this->db->query("SELECT CURRENT_RACK_ROW_ID RACK_ROW_ID,
       BIN_ID,
       'W' || '' || WAREHOUSE_NO || '-' || RACK_NO || ' | ' ||
       DECODE(ROW_NO,
              NULL,
              NULL,
              0,
              'N' || '' || ROW_NO,
              'R' || '' || ROW_NO) || ' | ' || BIN_NAME RACK_NAME
  FROM (SELECT B.BIN_ID,
               B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME,
               B.CURRENT_RACK_ROW_ID,
               RA.RACK_NO,
               MT.WAREHOUSE_NO,
               R.ROW_NO
          FROM BIN_MT B, LZ_RACK_ROWS R, RACK_MT RA, WAREHOUSE_MT MT
         WHERE B.CURRENT_RACK_ROW_ID = R.RACK_ROW_ID
           AND RA.WAREHOUSE_ID = MT.WAREHOUSE_ID
           AND R.RACK_ID = RA.RACK_ID)
 WHERE BIN_ID = $current_bin_id ")->result_array();

       return array("update" => true, "message" => "Bin location Transfered!", "bind_ids" => $binLocationRecord);
      }else
       return array("update" => false, "message" => "Cannot Tranfer Bin Location");

    }else{
      return array("update" => false, "message" => "No Bin Found");
     }
    }
    public function transferBinSave(){
      $barcodesGridFound = $this->input->post('barcodesGridFound');
      $bin_name = strtoupper(trim($this->input->post('bin_name')));
      $old_bin_name = $this->input->post('old_bin_id');
      $userId = $this->input->post('userId');
      $method = $this->input->post('method');
      
      date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $verify_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


      $barcodesGridFound = "";
      if($method == "ANDROID"){
        $barcodesGridFound = json_decode($this->input->post('barcodesGridFound'),true);
      }else if($method == "WEB"){
        $barcodesGridFound = $this->input->post('barcodesGridFound');
      }else{
        return array("transfered" => false, "message"=>"Invalid Method Name!");
      }
      $binFound = $this->db->query("SELECT * FROM BIN_MT BIN WHERE BIN.BIN_TYPE || '-' || BIN.BIN_NO = '$bin_name' ")->result_array();
      if(!$binFound){
        return array("transfered" => false, "message"=>"Invalid Bin Scanned!");
      }
        $bin_id  = $binFound[0]['BIN_ID'];
        
        $oldBin = $this->db->query("SELECT * FROM BIN_MT BIN WHERE BIN.BIN_ID = $old_bin_name ")->result_array();
        $old_bin_Id  = $oldBin[0]['BIN_ID'];

        $varify_id = "";
        $varify_old_id = "";

        if(count($barcodesGridFound) > 0){

          $verifyMaster_old = $this->db->query("SELECT VERIFY_ID, BIN_ID FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $old_bin_Id")->result_array();
          
          if($verifyMaster_old){
            $varify_old_id = $verifyMaster_old[0]['VERIFY_ID'];
          }

            $verifyMaster = $this->db->query("SELECT VERIFY_ID, BIN_ID FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id")->result_array();
            if($verifyMaster){
              $varify_id = $verifyMaster[0]['VERIFY_ID'];
              $this->db->query("UPDATE LJ_BIN_VERIFY_MT SET VERIFY_DATE = $verify_date, VERIFY_BY = $userId WHERE VERIFY_ID = $varify_id");
              //$this->db->query("DELETE FROM LJ_BIN_VERIFY_DT WHERE VERIFY_ID = $varify_id ");

            }else{
          $master_key = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_MT','VERIFY_ID') VERIFY_ID FROM DUAL ")->result_array();
            $varify_id = $master_key[0]['VERIFY_ID'];
            $this->db->query("INSERT INTO LJ_BIN_VERIFY_MT (VERIFY_ID, BIN_ID, VERIFY_BY, VERIFY_DATE) VALUES ($varify_id, $bin_id, $userId, $verify_date)");
            }

      foreach($barcodesGridFound as $value){
          
          $barcode = $value['BARCODE_NO'];

          if($varify_old_id){
            $this->db->query("DELETE FROM LJ_BIN_VERIFY_DT WHERE VERIFY_ID = $varify_old_id AND BARCODE_NO = $barcode");
          }

          $checkShortage = $this->db->query("SELECT SHORTAGE_ID FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ")->result_array();
          if($checkShortage){

          $shortageId = $checkShortage[0]['SHORTAGE_ID']; 

          $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ");
          $checkIfShortageBinEmpty = $this->db->query("SELECT COUNT(SHORTAGE_ID) TOTAL_RECORDS FROM LJ_BARCODE_SHORTAGE_DT WHERE SHORTAGE_ID = $shortageId ")->result_array();
          $count = $checkIfShortageBinEmpty[0]['TOTAL_RECORDS'];
          if($count <= 0){
            $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_MT WHERE SHORTAGE_ID = $shortageId ");
          }
        }

        $this->db->query("INSERT INTO LJ_BIN_VERIFY_DT (VERIFY_DT_ID, VERIFY_ID, BARCODE_NO) VALUES (
            GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_DT','VERIFY_DT_ID'), $varify_id, $barcode)");

            $old_loc_id = $this->db->query("SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode")->result_array();

            if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT L.BIN_ID FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode")->result_array();

              if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT DT.BIN_ID FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode")->result_array();
                
                if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT D.BIN_ID FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode")->result_array();
                
                }
              }
            }
            if($old_loc_id){
              $old_bin_id_barcode = $old_loc_id[0]['BIN_ID'];
            }else{
              $old_bin_id_barcode = 0;
            }
            

            $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
            $rs = $log_id_qry->result_array();
            $loc_trans_id = @$rs[0]['ID'];	

            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = '$bin_id' WHERE BM.BARCODE_NO = $barcode");
            $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.BIN_ID = '$bin_id' WHERE LOT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_DEKIT_US_DT DEKIT SET DEKIT.BIN_ID = '$bin_id' WHERE DEKIT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT BDT SET BDT.BIN_ID = '$bin_id' WHERE BDT.BARCODE_NO = $barcode");


            $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $verify_date, $barcode, $userId, '$bin_id', '$old_bin_id_barcode', null,null,null)"); 
 
      }
      return array("transfered" => true, "message" => "Barcodes Successfully Saved and Verified");
    }else{
      return array("transfered" => false, "message" => "No Barcodes Scanned");
    }

    }
    public function deleteAuditBarcode(){
      $barcode = $this->input->post('barcode');
      // Barcode generation code here
$stid = oci_parse($this->db->conn_id, 'BEGIN PRO_DELETE_AUDIT_BARCODE(:PARM_BARCODE,:RESPONSE); end;');

oci_bind_by_name($stid, ':PARM_BARCODE',  $barcode,200);
oci_bind_by_name($stid, ':RESPONSE',  $OUT_MESSAGE ,200, SQLT_CHR);
$results = "";
if(oci_execute($stid)){
  $results = $OUT_MESSAGE;
}
oci_free_statement($stid);
oci_close($this->db->conn_id);

// #END# Barcode generation code here
      if($results != "not_audit_barcode"){
        return array("delete"=>true, "message" => $results);
      }else{
        return array("delete"=>false, "message" => "Barcode Does Not Generated By Audit App");
      }
    }
    public function searchTransferCount(){
      $bin_id = $this->input->post('bin_id');
      $scanBarcode = $this->input->post('scanBarcode');
      $transfer_by_id = $this->input->post('userId');
      $ebayQuantity = $this->input->post('ebayQuantity');
      // $barcodesGridFound = $this->input->post('barcodesGridFound');
      $method = $this->input->post('method');

      $barcodesGridFound = "";
      if($method == "ANDROID"){
        $barcodesGridFound    = json_decode($this->input->post('barcodesGridFound'),true);
      }else if($method == "WEB"){
        $barcodesGridFound    = $this->input->post('barcodesGridFound');
      }else{
        return array("verified" => false, "message"=>"Invalid Method Name!");
      }

        $barcode_array = "";
        $j = 1;
        $length2 = sizeof($barcodesGridFound);

      if($barcodesGridFound){
          foreach($barcodesGridFound as $value){
            if($j >= 1 && $j < $length2){
            $barcode_array .= $value['BARCODE_NO'] . ",";
            }
            if( $j == $length2 ){
            $barcode_array .= $value['BARCODE_NO'];
            }
            $j++;
          }
      }

        if(!$ebayQuantity){
          $ebayQuantity = 1;
        }
      date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $date = $this->db->query("SELECT TO_CHAR($transfer_date, 'MM-DD-YYYY HH24:MI:SS') AS CREATED_AT FROM DUAL")->result_array();
    $employee = $this->db->query("SELECT USER_NAME AS CREATED_BY FROM EMPLOYEE_MT WHERE EMPLOYEE_ID = $transfer_by_id")->result_array();

    $created_at = $date[0]['CREATED_AT'];
    $created_by = $employee[0]['CREATED_BY'];

      $scanBarcode = str_replace("*","",$scanBarcode);
    
      $str = strlen($scanBarcode);//if length = 12 its ebay id

      if($str == 12){
        $AndQuery = "";
        if($length2 > 0){
          $AndQuery = "AND B.BARCODE_NO NOT IN ($barcode_array)";
        }
        $scanEbayId = $scanBarcode;
        
        $ebayRecord = $this->db->query("SELECT B.BARCODE_NO, B.EBAY_ITEM_ID
                                        FROM LZ_BARCODE_MT B
                                        WHERE B.PULLING_ID IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
                                        AND B.LZ_POS_MT_ID IS NULL
                                        AND B.LZ_PART_ISSUE_MT_ID IS NULL
                                        AND B.BARCODE_NO NOT IN (SELECT ED.BARCODE_NO FROM LJ_LOG_EBAY_MT EM, LJ_LOG_EBAY_DT ED WHERE EM.LOG_ID = ED.LOG_ID AND EM.EBAY_ID = B.EBAY_ITEM_ID )
                                        ".$AndQuery."
                                        AND B.EBAY_ITEM_ID = $scanEbayId
                                        AND ROWNUM <= $ebayQuantity")->result_array();
      if(!$ebayRecord){
        
          // Barcode generation code here
$stid = oci_parse($this->db->conn_id, 'BEGIN GENERATE_AUDIT_BARCODE(:PARM_EBAY_ITEM_ID,:PARM_NEW_QUANTITY,:PARM_BIN_ID,:RESPONSE); end;');

oci_bind_by_name($stid, ':PARM_EBAY_ITEM_ID',  $scanEbayId,200);
oci_bind_by_name($stid, ':PARM_NEW_QUANTITY',  $ebayQuantity,200);
oci_bind_by_name($stid, ':PARM_BIN_ID',  $bin_id,200);
oci_bind_by_name($stid, ':RESPONSE',  $OUT_MESSAGE ,200, SQLT_CHR);
$results = "";
if(oci_execute($stid)){
  $results = $OUT_MESSAGE;
}
oci_free_statement($stid);
oci_close($this->db->conn_id);

// #END# Barcode generation code here
$ebayRecord = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN B.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
  AND B.BARCODE_NO NOT IN (SELECT ED.BARCODE_NO FROM LJ_LOG_EBAY_MT EM, LJ_LOG_EBAY_DT ED WHERE EM.LOG_ID = ED.LOG_ID AND EM.EBAY_ID = B.EBAY_ITEM_ID )
  ".$AndQuery."
  AND B.EBAY_ITEM_ID = $scanEbayId
  AND ROWNUM <= $ebayQuantity")->result_array();

        if($ebayRecord){
          $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($ebayRecord,$conditions);
            $images = $uri['uri'];
          return array("found" => true, "barcodesGrid" => $ebayRecord, "images" => $images, "message"=>"Barcode Scanned Successfully!" );
        }else{
          return array("found" => false, "message" => "Something went wrong!");
        }
          
        }else{
          $ebay_records_count = count($ebayRecord);

          $new_quantity = 0;
          if($ebay_records_count < $ebayQuantity){
            $new_quantity = $ebayQuantity - $ebay_records_count;
          }else {
          $new_quantity = $ebay_records_count;
          }
if($ebay_records_count < $ebayQuantity){
 // Barcode generation code here
          $stid = oci_parse($this->db->conn_id, 'BEGIN GENERATE_AUDIT_BARCODE(:PARM_EBAY_ITEM_ID,:PARM_NEW_QUANTITY,:PARM_BIN_ID,:RESPONSE); end;');

          oci_bind_by_name($stid, ':PARM_EBAY_ITEM_ID',  $scanEbayId,200);
          oci_bind_by_name($stid, ':PARM_NEW_QUANTITY',  $new_quantity,200);
          oci_bind_by_name($stid, ':PARM_BIN_ID',  $bin_id,200);
          oci_bind_by_name($stid, ':RESPONSE',  $OUT_MESSAGE ,200, SQLT_CHR);
          $results = "";
          if(oci_execute($stid)){
            $results = $OUT_MESSAGE;
          }
          oci_free_statement($stid);
          oci_close($this->db->conn_id);
          // #END# Barcode generation code here
}


$ebayRecord = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN B.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
  AND B.BARCODE_NO NOT IN (SELECT ED.BARCODE_NO FROM LJ_LOG_EBAY_MT EM, LJ_LOG_EBAY_DT ED WHERE EM.LOG_ID = ED.LOG_ID AND EM.EBAY_ID = B.EBAY_ITEM_ID )
  ".$AndQuery."
  AND B.EBAY_ITEM_ID = $scanEbayId
  AND ROWNUM <= $ebayQuantity")->result_array();

        if($ebayRecord){
          $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($ebayRecord,$conditions);
            $images = $uri['uri'];
          return array("found" => true, "barcodesGrid" => $ebayRecord, "images" => $images, "message"=>"Barcode Scanned Successfully!" );
        }else{
          return array("found" => false, "message" => "Something went wrong!");
        }
         
        }
      }else{
        $barcodes = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN B.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   and b.pulling_id is null
   and b.item_adj_det_id_for_out is null
   and b.item_adj_det_id_for_in is null
   and b.lz_pos_mt_id is null
   and b.lz_part_issue_mt_id is null
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND b.barcode_no = $scanBarcode")->result_array();

   if(count($barcodes) <= 0) {
        $barcodes = $this->db->query("SELECT lo.barcode_prv_no BARCODE_NO,
       lo.BIN_ID,
       lo.mpn_description DESCR,
       lo.card_upc UPC,
       lo.card_mpn MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       null EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN lo.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM lz_special_lots lo,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE lo.barcode_prv_no = MAX_BAR.BARCODE_NO(+)
   and lo.lz_manifest_det_id is null
   
   AND lo.barcode_prv_no = $scanBarcode")->result_array();
   }
   if( count($barcodes) <= 0 ){
      $barcodes = $this->db->query("SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN LO.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_DEKIT_US_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
 
   AND LO.BARCODE_PRV_NO = $scanBarcode")->result_array();
   }
    if( count($barcodes) <= 0 ){
      $barcodes = $this->db->query("SELECT LO.BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN LO.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_MERCHANT_BARCODE_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
 
   AND LO.BARCODE_NO = $scanBarcode")->result_array();
   }

  $pulledBarcode = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'PULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN B.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   and b.pulling_id is not null
   AND b.barcode_no = $scanBarcode")->result_array();

if( count($pulledBarcode) >=1 && count($barcodes) <= 0 ){
    $barcode = $pulledBarcode[0]['BARCODE_NO'];
    $bin = $pulledBarcode[0]['BIN_ID'];

    $alreadyExist = $this->db->query("SELECT * FROM LJ_LOG_BARCODE_MT WHERE BIN_ID = $bin")->result_array();
    if($alreadyExist){
      $log_barcode_id = $alreadyExist[0]['LOG_BARCODE_ID'];
        $this->db->query("UPDATE LJ_LOG_BARCODE_DT SET LOG_BARCODE_ID = $log_barcode_id WHERE BARCODE_NO = $barcode");
     $exist = $this->db->query("SELECT * FROM LJ_LOG_BARCODE_DT WHERE BARCODE_NO = $barcode")->result_array();
      if($exist){
        $this->db->query("UPDATE LJ_LOG_BARCODE_DT SET LOG_BARCODE_ID = $log_barcode_id WHERE BARCODE_NO = $barcode");
      }else{
        $this->db->query("INSERT INTO LJ_LOG_BARCODE_DT (LOG_BARCODE_DT_ID, LOG_BARCODE_ID, BARCODE_NO) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_LOG_BARCODE_DT','LOG_BARCODE_DT_ID'),$log_barcode_id,$barcode) ");
      }

    }else{
    $master_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_BARCODE_MT','LOG_BARCODE_ID') LOG_BARCODE_ID FROM DUAL")->result_array();
      $log_barcode_id = $master_id[0]['LOG_BARCODE_ID'];

    $this->db->query("INSERT INTO LJ_LOG_BARCODE_MT (LOG_BARCODE_ID, BIN_ID, CREATED_AT, CREATED_BY) VALUES ($log_barcode_id,$bin,$transfer_date,$transfer_by_id) ");
      $exist = $this->db->query("SELECT * FROM LJ_LOG_BARCODE_DT WHERE BARCODE_NO = $barcode")->result_array();
      if($exist){
        $this->db->query("UPDATE LJ_LOG_BARCODE_DT SET LOG_BARCODE_ID = $log_barcode_id WHERE BARCODE_NO = $barcode");
      }else{
        $this->db->query("INSERT INTO LJ_LOG_BARCODE_DT (LOG_BARCODE_DT_ID, LOG_BARCODE_ID, BARCODE_NO) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_LOG_BARCODE_DT','LOG_BARCODE_DT_ID'),$log_barcode_id,$barcode) ");
      }
    }
     $barcodes = $pulledBarcode;
}
      if($barcodes){
          $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($barcodes,$conditions);
            $images = $uri['uri'];
          return array("found" => true, "barcodesGrid" => $barcodes, "images" => $images, "message"=>"Barcode Scanned Successfully!" );
        }else{
          return array("found" => false, "message" => "Something went wrong!");
        }
      }

    }
    //end by danish on 3-3-2018 updated by Tahir Amjad on 5/9/2019
    public function searchBarcodeAudit(){
        $bin_id = $this->input->post('bin_id');
        $scanBarcode = $this->input->post('scanBarcode');
        $transfer_by_id = $this->input->post('userId');
        $ebayQuantity = $this->input->post('ebayQuantity');

        date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $date = $this->db->query("SELECT TO_CHAR($transfer_date, 'MM-DD-YYYY HH24:MI:SS') AS CREATED_AT FROM DUAL")->result_array();
    $employee = $this->db->query("SELECT USER_NAME AS CREATED_BY FROM EMPLOYEE_MT WHERE EMPLOYEE_ID = $transfer_by_id")->result_array();

    $created_at = $date[0]['CREATED_AT'];
    $created_by = $employee[0]['CREATED_BY'];
    
      $scanBarcode = str_replace("*","",$scanBarcode);
    
      $str = strlen($scanBarcode);//if length = 12 its ebay id

      if($str == 12){
        $scanEbayId = $scanBarcode;
        
        $ebayRecord = $this->db->query("SELECT B.BARCODE_NO, B.EBAY_ITEM_ID
                                        FROM LZ_BARCODE_MT B
                                        WHERE B.PULLING_ID IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
                                        AND B.LZ_POS_MT_ID IS NULL
                                        AND B.LZ_PART_ISSUE_MT_ID IS NULL
                                        AND B.BARCODE_NO NOT IN (SELECT ED.BARCODE_NO FROM LJ_LOG_EBAY_MT EM, LJ_LOG_EBAY_DT ED WHERE EM.LOG_ID = ED.LOG_ID AND EM.EBAY_ID = B.EBAY_ITEM_ID )
                                        AND B.EBAY_ITEM_ID = $scanEbayId
                                        AND ROWNUM <= $ebayQuantity")->result_array();
    if(!$ebayRecord){

          // Barcode generation code here
$stid = oci_parse($this->db->conn_id, 'BEGIN GENERATE_AUDIT_BARCODE(:PARM_EBAY_ITEM_ID,:PARM_NEW_QUANTITY,:PARM_BIN_ID,:RESPONSE); end;');

oci_bind_by_name($stid, ':PARM_EBAY_ITEM_ID',  $scanEbayId,200);
oci_bind_by_name($stid, ':PARM_NEW_QUANTITY',  $ebayQuantity,200);
oci_bind_by_name($stid, ':PARM_BIN_ID',  $bin_id,200);
oci_bind_by_name($stid, ':RESPONSE',  $OUT_MESSAGE ,200, SQLT_CHR);
$results = "";
if(oci_execute($stid)){
  $results = $OUT_MESSAGE;
}
oci_free_statement($stid);
oci_close($this->db->conn_id);

// #END# Barcode generation code here
$ebayRecord = $this->db->query("SELECT B.BARCODE_NO, B.EBAY_ITEM_ID
                                        FROM LZ_BARCODE_MT B
                                        WHERE B.PULLING_ID IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
                                        AND B.LZ_POS_MT_ID IS NULL
                                        AND B.LZ_PART_ISSUE_MT_ID IS NULL
                                        AND B.BARCODE_NO NOT IN (SELECT ED.BARCODE_NO FROM LJ_LOG_EBAY_MT EM, LJ_LOG_EBAY_DT ED WHERE EM.LOG_ID = ED.LOG_ID AND EM.EBAY_ID = B.EBAY_ITEM_ID )
                                        AND B.EBAY_ITEM_ID = $scanEbayId
                                        AND ROWNUM <= $ebayQuantity")->result_array();

$foundEbayId = $this->db->query("SELECT * FROM LJ_LOG_EBAY_MT EM WHERE EM.EBAY_ID = $scanEbayId")->result_array();
        if(!$foundEbayId){

          $records = array();
          $i = 0;

          $logs = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_MT', 'LOG_ID') LOG_ID FROM DUAL")->result_array();
          $log_id = $logs[0]['LOG_ID'];

          $this->db->query("INSERT INTO LJ_LOG_EBAY_MT (LOG_ID, EBAY_ID, CREATED_AT, CREATED_BY, STATUS) VALUES ( $log_id, $scanEbayId, $transfer_date, $transfer_by_id, 1 )");
          

          foreach($ebayRecord as $val){

          $ebay_id = $val['EBAY_ITEM_ID'];
          $barcode_no = $val['BARCODE_NO'];

          $log_dt_id = "";
            $detExist = $this->db->query("SELECT * FROM LJ_LOG_EBAY_DT WHERE BARCODE_NO = $barcode_no")->result_array();
          if(!$detExist){
            $logsDT = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_DT', 'LOG_DT_ID') LOG_DT_ID FROM DUAL")->result_array();
          $log_dt_id = $logsDT[0]['LOG_DT_ID'];
          $this->db->query("INSERT INTO LJ_LOG_EBAY_DT (LOG_DT_ID, LOG_ID, BARCODE_NO, PRINT_YN) VALUES ( $log_dt_id, $log_id, $barcode_no, 0)");
          }


          $records[$i] = array(
            "LOG_ID" => $log_id,
            "LOG_DT_ID" => $log_dt_id,
            "EBAY_ID" => $ebay_id,
            "BARCODE_NO" => $barcode_no,
            "CREATED_AT" => $created_at,
            "CREATED_BY" => $created_by,
            "STATUS" => 1
          );
          $i++;
        }

          return array("found" => true, "ebay_log" => $records );
        }else{
          $records = array();
          $i = 0;
          foreach($ebayRecord as $val){
          $barcode_no = $val['BARCODE_NO'];
          $log_id = $foundEbayId[0]['LOG_ID'];
          $status = $foundEbayId[0]['STATUS'];
          $ebay_id = $foundEbayId[0]['EBAY_ID'];

        //  $logsDT = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_DT', 'LOG_DT_ID') LOG_DT_ID FROM DUAL")->result_array();
        //   $log_dt_id = $logsDT[0]['LOG_DT_ID'];
          
        //   $this->db->query("INSERT INTO LJ_LOG_EBAY_DT (LOG_DT_ID, LOG_ID, BARCODE_NO) VALUES ( $log_dt_id, $log_id, $barcode_no)");
          
          $log_dt_id = "";
            $detExist = $this->db->query("SELECT * FROM LJ_LOG_EBAY_DT WHERE BARCODE_NO = $barcode_no")->result_array();
          if(!$detExist){
            $logsDT = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_DT', 'LOG_DT_ID') LOG_DT_ID FROM DUAL")->result_array();
          $log_dt_id = $logsDT[0]['LOG_DT_ID'];
          $this->db->query("INSERT INTO LJ_LOG_EBAY_DT (LOG_DT_ID, LOG_ID, BARCODE_NO, PRINT_YN) VALUES ( $log_dt_id, $log_id, $barcode_no, 0)");
          }

          $records[$i] = array(
            "LOG_ID" => $log_id,
            "LOG_DT_ID" => $log_dt_id,
            "EBAY_ID" => $ebay_id,
            "BARCODE_NO" => $barcode_no,
            "CREATED_AT" => $created_at,
            "CREATED_BY" => $created_by,
            "STATUS" => $status
          );
          $i++;
        }
          return array("found" => true, "ebay_log" => $records);
        }       

    }else{
   
$ebay_records_count = count($ebayRecord);

$new_quantity = 0;
if($ebay_records_count < $ebayQuantity){
  $new_quantity = $ebayQuantity - $ebay_records_count;
}else {
$new_quantity = $ebay_records_count;
}
if($ebay_records_count < $ebayQuantity){
 // Barcode generation code here
          $stid = oci_parse($this->db->conn_id, 'BEGIN GENERATE_AUDIT_BARCODE(:PARM_EBAY_ITEM_ID,:PARM_NEW_QUANTITY,:PARM_BIN_ID,:RESPONSE); end;');

          oci_bind_by_name($stid, ':PARM_EBAY_ITEM_ID',  $scanEbayId,200);
          oci_bind_by_name($stid, ':PARM_NEW_QUANTITY',  $new_quantity,200);
          oci_bind_by_name($stid, ':PARM_BIN_ID',  $bin_id,200);
          oci_bind_by_name($stid, ':RESPONSE',  $OUT_MESSAGE ,200, SQLT_CHR);
          $results = "";
          if(oci_execute($stid)){
            $results = $OUT_MESSAGE;
          }
          oci_free_statement($stid);
          oci_close($this->db->conn_id);
}

$ebayRecord = $this->db->query("SELECT B.BARCODE_NO, B.EBAY_ITEM_ID
                                        FROM LZ_BARCODE_MT B
                                        WHERE B.PULLING_ID IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
                                        AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
                                        AND B.LZ_POS_MT_ID IS NULL
                                        AND B.LZ_PART_ISSUE_MT_ID IS NULL
                                        AND B.BARCODE_NO NOT IN (SELECT ED.BARCODE_NO FROM LJ_LOG_EBAY_MT EM, LJ_LOG_EBAY_DT ED WHERE EM.LOG_ID = ED.LOG_ID AND EM.EBAY_ID = B.EBAY_ITEM_ID )
                                        AND B.EBAY_ITEM_ID = $scanEbayId
                                        AND ROWNUM <= $ebayQuantity")->result_array();

// #END# Barcode generation code here
      $foundEbayId = $this->db->query("SELECT * FROM LJ_LOG_EBAY_MT EM WHERE EM.EBAY_ID = $scanEbayId")->result_array();
        if(!$foundEbayId){

          $records = array();
          $i = 0;

          $logs = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_MT', 'LOG_ID') LOG_ID FROM DUAL")->result_array();
          $log_id = $logs[0]['LOG_ID'];

          $this->db->query("INSERT INTO LJ_LOG_EBAY_MT (LOG_ID, EBAY_ID, CREATED_AT, CREATED_BY, STATUS) VALUES ( $log_id, $scanEbayId, $transfer_date, $transfer_by_id, 1 )");

          foreach($ebayRecord as $val){

          $ebay_id = $val['EBAY_ITEM_ID'];
          $barcode_no = $val['BARCODE_NO'];

          $log_dt_id = "";
            $detExist = $this->db->query("SELECT * FROM LJ_LOG_EBAY_DT WHERE BARCODE_NO = $barcode_no")->result_array();
          if(!$detExist){
            $logsDT = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_DT', 'LOG_DT_ID') LOG_DT_ID FROM DUAL")->result_array();
          $log_dt_id = $logsDT[0]['LOG_DT_ID'];
          $this->db->query("INSERT INTO LJ_LOG_EBAY_DT (LOG_DT_ID, LOG_ID, BARCODE_NO, PRINT_YN) VALUES ( $log_dt_id, $log_id, $barcode_no, 0)");
          }


          $records[$i] = array(
            "LOG_ID" => $log_id,
            "LOG_DT_ID" => $log_dt_id,
            "EBAY_ID" => $ebay_id,
            "BARCODE_NO" => $barcode_no,
            "CREATED_AT" => $created_at,
            "CREATED_BY" => $created_by,
            "STATUS" => 1
          );
          $i++;
        }

          return array("found" => true, "ebay_log" => $records );
        }else{

          $records = array();
          $i = 0;
          foreach($ebayRecord as $val){
          $barcode_no = $val['BARCODE_NO'];
          $log_id = $foundEbayId[0]['LOG_ID'];
          $status = $foundEbayId[0]['STATUS'];
          $ebay_id = $foundEbayId[0]['EBAY_ID'];

          $log_dt_id = "";
            $detExist = $this->db->query("SELECT * FROM LJ_LOG_EBAY_DT WHERE BARCODE_NO = $barcode_no")->result_array();
          if(!$detExist){
            $logsDT = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_EBAY_DT', 'LOG_DT_ID') LOG_DT_ID FROM DUAL")->result_array();
          $log_dt_id = $logsDT[0]['LOG_DT_ID'];
          $this->db->query("INSERT INTO LJ_LOG_EBAY_DT (LOG_DT_ID, LOG_ID, BARCODE_NO, PRINT_YN) VALUES ( $log_dt_id, $log_id, $barcode_no, 0)");
          }

          $records[$i] = array(
            "LOG_ID" => $log_id,
            "LOG_DT_ID" => $log_dt_id,
            "EBAY_ID" => $ebay_id,
            "BARCODE_NO" => $barcode_no,
            "CREATED_AT" => $created_at,
            "CREATED_BY" => $created_by,
            "STATUS" => $status
          );
          $i++;
        }
          return array("found" => true, "ebay_log" => $records);
        }
    }
  }

        $barcodes = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN B.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   and b.pulling_id is null
   and b.item_adj_det_id_for_out is null
   and b.item_adj_det_id_for_in is null
   and b.lz_pos_mt_id is null
   and b.lz_part_issue_mt_id is null
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND b.barcode_no = $scanBarcode")->result_array();

   if(count($barcodes) <= 0) {
        $barcodes = $this->db->query("SELECT lo.barcode_prv_no BARCODE_NO,
       lo.BIN_ID,
       lo.mpn_description DESCR,
       lo.card_upc UPC,
       lo.card_mpn MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       null EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN lo.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM lz_special_lots lo,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE lo.barcode_prv_no = MAX_BAR.BARCODE_NO(+)
   and lo.lz_manifest_det_id is null
   
   AND lo.barcode_prv_no = $scanBarcode")->result_array();
   }
   if( count($barcodes) <= 0 ){
      $barcodes = $this->db->query("SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN LO.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_DEKIT_US_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
 
   AND LO.BARCODE_PRV_NO = $scanBarcode")->result_array();
   }
    if( count($barcodes) <= 0 ){
      $barcodes = $this->db->query("SELECT LO.BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'NOTPULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN LO.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_MERCHANT_BARCODE_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
 
   AND LO.BARCODE_NO = $scanBarcode")->result_array();
   }

  $pulledBarcode = $this->db->query("SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       'PULLED' PULLED_STATUS,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND,
           (CASE
         WHEN B.BIN_ID = $bin_id  THEN
          'BIN_BARCODE'
         ELSE
          'NOT_BIN_BARCODE'
       END) BIN_BARCODE_YN
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   and b.pulling_id is not null
   AND b.barcode_no = $scanBarcode")->result_array();

if( count($pulledBarcode) >=1 && count($barcodes) <= 0 ){
    $barcode = $pulledBarcode[0]['BARCODE_NO'];
    $bin = $pulledBarcode[0]['BIN_ID'];

    $alreadyExist = $this->db->query("SELECT * FROM LJ_LOG_BARCODE_MT WHERE BIN_ID = $bin")->result_array();
    if($alreadyExist){
      $log_barcode_id = $alreadyExist[0]['LOG_BARCODE_ID'];
       $exist = $this->db->query("SELECT * FROM LJ_LOG_BARCODE_DT WHERE BARCODE_NO = $barcode")->result_array();
      if($exist){
        $this->db->query("UPDATE LJ_LOG_BARCODE_DT SET LOG_BARCODE_ID = $log_barcode_id WHERE BARCODE_NO = $barcode");
      }else{
        $this->db->query("INSERT INTO LJ_LOG_BARCODE_DT (LOG_BARCODE_DT_ID, LOG_BARCODE_ID, BARCODE_NO) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_LOG_BARCODE_DT','LOG_BARCODE_DT_ID'),$log_barcode_id,$barcode) ");
      }

    }else{
    $master_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_LOG_BARCODE_MT','LOG_BARCODE_ID') LOG_BARCODE_ID FROM DUAL")->result_array();
      $log_barcode_id = $master_id[0]['LOG_BARCODE_ID'];

    $this->db->query("INSERT INTO LJ_LOG_BARCODE_MT (LOG_BARCODE_ID, BIN_ID, CREATED_AT, CREATED_BY) VALUES ($log_barcode_id,$bin,$transfer_date,$transfer_by_id) ");
      $exist = $this->db->query("SELECT * FROM LJ_LOG_BARCODE_DT WHERE BARCODE_NO = $barcode")->result_array();
      if($exist){
        $this->db->query("UPDATE LJ_LOG_BARCODE_DT SET LOG_BARCODE_ID = $log_barcode_id WHERE BARCODE_NO = $barcode");
      }else{
        $this->db->query("INSERT INTO LJ_LOG_BARCODE_DT (LOG_BARCODE_DT_ID, LOG_BARCODE_ID, BARCODE_NO) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_LOG_BARCODE_DT','LOG_BARCODE_DT_ID'),$log_barcode_id,$barcode) ");
      }
    }
     $barcodes = $pulledBarcode;
}
   if($barcodes){
       $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($barcodes,$conditions);
            $images = $uri['uri'];
    return array("found" => true, "barcodesGrid" => $barcodes, "images" => $images, "message"=>"Barcode Scanned Successfully!" );
   }else{
    return array("found" => false, "message" => "Barcode Does Not Exist" );
   }

    }
     public function printAllStickers($barcode){  	
	   
	    $print_qry = $this->db->query("SELECT MT.BARCODE_NO,'R#' || TO_DATE(I.ENTERED_DATE_TIME,'YYYY-MM-DD') REF_DATE,ROWNUM AS UNIT_NO,I.ITEM_DESC, (SELECT COUNT(B.EBAY_ITEM_ID) FROM LZ_BARCODE_MT B WHERE B.EBAY_ITEM_ID = (SELECT 
C.EBAY_ITEM_ID FROM LZ_BARCODE_MT C WHERE C.BARCODE_NO = $barcode) ) NO_OF_BARCODE,  I.ITEM_MT_UPC CARD_UPC  
FROM LZ_BARCODE_MT MT,
ITEMS_MT I 
WHERE MT.ITEM_ID = I.ITEM_ID
AND MT.BARCODE_NO = $barcode")->result_array(); 
 if($print_qry){
  $this->db->query("UPDATE LJ_LOG_EBAY_DT SET PRINT_YN = 1 WHERE BARCODE_NO = $barcode"); 
 } 
	    return $print_qry;
      }
	  public function searchAudit(){	  	
		
	    $location    = $this->input->post('location');
        $startDate   = $this->input->post('startDate');
        $endDate     = $this->input->post('endDate');
        $fromDate = date_create($startDate);
        $toDate   = date_create($endDate);

        $from = date_format($fromDate,'Y-m-d');
        $to = date_format($toDate, 'Y-m-d');

      
	   $listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC,BM.BIN_TYPE BI_TYP, I.ITEM_MT_MANUFACTURE MANUFACTURER,I.ITEM_MT_UPC UPC, I.ITEM_MT_MFG_PART_NO MPN, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, BIN_MT BM, LZ_BARCODE_MT BCD, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID  AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID and lm.manifest_type not in ( 3,4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID ";
 
	  if($location == "PK"){

		$date_qry = " AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'PK') AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
	    $listed_qry .= $date_qry;
	}elseif( $location == "US"){
    
	    $date_qry = " AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US') AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
		$listed_qry .= $date_qry;
	}else{
		$date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
	    $listed_qry .= $date_qry;
	}

     

	$listed_qry.= " ORDER BY LIST_DATE DESC";   
	$allAuditData = $this->db->query($listed_qry)->result_array();

    if($allAuditData){
         $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($allAuditData,$conditions);
            $images = $uri['uri'];
        return array("found" => true, "allAuditData" => $allAuditData, "images" => $images);
    }else{
        return array("found" => false, "message" => "No Data Found");
    }

  }
  public function saveVerified(){
      
      $method = $this->input->post('method');
      $bin_id = $this->input->post('bin_id');
      $userId = $this->input->post('userId');

      // var_dump($this->input->post('method'));
      // var_dump($this->input->post('bin_id'));
      // var_dump($this->input->post('userId'));

      if(!is_numeric($bin_id)){
        $bins = $this->db->query("SELECT BIN_ID FROM BIN_MT WHERE BIN_TYPE || '-' || BIN_NO = '$bin_id'")->result_array();
        if($bins){
          $bin_id = $bins[0]['BIN_ID'];
        }else{
          return array("verified" => false, "message" => "Bin Not Found! Please scan correct bin");
        }
      }
     
      $newBin = strtoupper(trim($this->input->post('newBin')));

        $barcodesGridFound = "";
        $barcodesGridNotFound = "";
        $ebayIDRecords = "";

      if($method == 'ANDROID'){
        $barcodesGridFound    = json_decode($this->input->post('barcodesGridFound'),true);
      $barcodesGridNotFound = json_decode($this->input->post('barcodesGridNotFound'),true);
      $ebayIDRecords = json_decode($this->input->post('ebayIDRecords'),true);
      }else if($method == 'WEB'){
        $barcodesGridFound    = $this->input->post('barcodesGridFound');
      $barcodesGridNotFound = $this->input->post('barcodesGridNotFound');
       $ebayIDRecords = $this->input->post('ebayIDRecords');
      }else{
        return array("verified" => false, "message"=>"API method not defined! ".$method." ");
      }

            // Get location of the bin   
     $bind_ids = $this->db->query("SELECT CURRENT_RACK_ROW_ID RACK_ROW_ID,
       BIN_ID,
       'W' || '' || WAREHOUSE_NO || '-' || RACK_NO || ' | ' ||
       DECODE(ROW_NO,
              NULL,
              NULL,
              0,
              'N' || '' || ROW_NO,
              'R' || '' || ROW_NO) || ' | ' || BIN_NAME RACK_NAME,
              VERIFY_DATE,
              DAYS_LEFT
  FROM (SELECT B.BIN_ID,
               B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME,
               B.CURRENT_RACK_ROW_ID,
               RA.RACK_NO,
               MT.WAREHOUSE_NO,
               R.ROW_NO,
               CASE WHEN TO_DATE(MV.VERIFY_DATE) + 15 >= TO_DATE(SYSDATE)  THEN
                    'Valid Till: ' || TO_CHAR(TO_DATE(MV.VERIFY_DATE) + 15)
                    WHEN TO_DATE(MV.VERIFY_DATE) + 15 < TO_DATE(SYSDATE) THEN
                      'Verified Date Expired! last verified: ' ||  TO_CHAR(TO_DATE(MV.VERIFY_DATE))
                      END VERIFY_DATE,
               CASE 
                  WHEN (TO_DATE(MV.VERIFY_DATE) + 15) > TO_DATE(SYSDATE) THEN
                     'Days Left: ' || TO_CHAR( 15 - ( TO_DATE(SYSDATE) - TO_DATE(MV.VERIFY_DATE) )  )
                  WHEN TO_DATE(SYSDATE) > (TO_DATE(MV.VERIFY_DATE) + 15) THEN
                     'Last Verified: ' || TO_CHAR(( TO_DATE(SYSDATE) - TO_DATE(MV.VERIFY_DATE))) || ' Days Before'
                  WHEN (TO_DATE(MV.VERIFY_DATE) + 15) = TO_DATE(SYSDATE) THEN
                    '15 Days Complete'
                 END DAYS_LEFT
          FROM BIN_MT B, LZ_RACK_ROWS R, RACK_MT RA, WAREHOUSE_MT MT, LJ_BIN_VERIFY_MT MV
         WHERE B.CURRENT_RACK_ROW_ID = R.RACK_ROW_ID
           AND B.BIN_ID = MV.BIN_ID(+)
           AND RA.WAREHOUSE_ID = MT.WAREHOUSE_ID
           AND R.RACK_ID = RA.RACK_ID)
 WHERE BIN_ID = '$bin_id' ")->result_array();
 // #END# Get location of the bin

       date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $verify_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    
    $query = "SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   and b.pulling_id is null
   and b.item_adj_det_id_for_out is null
   and b.item_adj_det_id_for_in is null
   and b.lz_pos_mt_id is null
   and b.lz_part_issue_mt_id is null
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND b.bin_id = $bin_id
   
 union all
 
 SELECT lo.barcode_prv_no BARCODE_NO,
       lo.BIN_ID,
       lo.mpn_description DESCR,
       lo.card_upc UPC,
       lo.card_mpn MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       null EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) OUT_BOUND
  FROM lz_special_lots lo,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE lo.barcode_prv_no = MAX_BAR.BARCODE_NO(+)
   and lo.lz_manifest_det_id is null
   
   AND lo.bin_id = $bin_id
   
   union all
   
   SELECT lo.barcode_prv_no BARCODE_NO,
       lo.BIN_ID,
       lo.mpn_description DESCR,
       null UPC,
       null MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       null EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_prv_no
           AND ROWNUM = 1) OUT_BOUND
  FROM lz_dekit_us_dt lo,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE lo.barcode_prv_no = MAX_BAR.BARCODE_NO(+)
   and lo.lz_manifest_det_id is null
   
   AND lo.bin_id = $bin_id
   
   union all
   
   SELECT lo.barcode_no BARCODE_NO,
       lo.BIN_ID,
       null DESCR,
       null UPC,
       null MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       null EBAY_ITEM_ID,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_no
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = lo.barcode_no
           AND ROWNUM = 1) OUT_BOUND
  FROM lz_merchant_barcode_dt lo,
       (SELECT LL.BARCODE_NO, M.User_Name TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   
   AND LO.BIN_ID = $bin_id";
$varify_id = "";
if(count($barcodesGridFound) > 0 || count($barcodesGridNotFound) > 0){

     $verifyMaster = $this->db->query("SELECT VERIFY_ID, BIN_ID FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id")->result_array();
     if($verifyMaster){
      $varify_id = $verifyMaster[0]['VERIFY_ID'];
      $this->db->query("UPDATE LJ_BIN_VERIFY_MT SET VERIFY_DATE = $verify_date, VERIFY_BY = $userId WHERE VERIFY_ID = $varify_id");
      $this->db->query("DELETE FROM LJ_BIN_VERIFY_DT WHERE VERIFY_ID = $varify_id ");

     }else{
  $master_key = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_MT','VERIFY_ID') VERIFY_ID FROM DUAL ")->result_array();
    $varify_id = $master_key[0]['VERIFY_ID'];
    $this->db->query("INSERT INTO LJ_BIN_VERIFY_MT (VERIFY_ID, BIN_ID, VERIFY_BY, VERIFY_DATE) VALUES ($varify_id, $bin_id, $userId, $verify_date)");
     }
}
if(count($ebayIDRecords) > 0){
  
  $newbin_id = "";
  if(!is_numeric($newBin)){
   $newbins = $this->db->query("SELECT * FROM BIN_MT BIN WHERE BIN.BIN_TYPE || '-' || BIN.BIN_NO = '$newBin' ")->result_array();
    $newbin_id = $newbins[0]['BIN_ID'];
  }else{
    $newbin_id = $bin_id;
  }

  $verified = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $newbin_id")->result_array();
$varify_id = "";
  if($verified){
    $varify_id = $verified[0]['VERIFY_ID'];
  }else{
    $master_key = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_MT','VERIFY_ID') VERIFY_ID FROM DUAL ")->result_array();
    $varify_id = $master_key[0]['VERIFY_ID'];
    $this->db->query("INSERT INTO LJ_BIN_VERIFY_MT (VERIFY_ID, BIN_ID, VERIFY_BY, VERIFY_DATE) VALUES ($varify_id, $bin_id, $userId, $verify_date)");
  }


  foreach($ebayIDRecords as $value){       
          $barcode = $value['BARCODE_NO'];
          
          $checkShortage = $this->db->query("SELECT SHORTAGE_ID FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ")->result_array();
          if($checkShortage){

          $shortageId = $checkShortage[0]['SHORTAGE_ID']; 

          $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ");
          $checkIfShortageBinEmpty = $this->db->query("SELECT COUNT(SHORTAGE_ID) TOTAL_RECORDS FROM LJ_BARCODE_SHORTAGE_DT WHERE SHORTAGE_ID = $shortageId ")->result_array();
          $count = $checkIfShortageBinEmpty[0]['TOTAL_RECORDS'];
          if($count <= 0){
            $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_MT WHERE SHORTAGE_ID = $shortageId ");
          }
        }

        $this->db->query("INSERT INTO LJ_BIN_VERIFY_DT (VERIFY_DT_ID, VERIFY_ID, BARCODE_NO) VALUES (
            GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_DT','VERIFY_DT_ID'), $varify_id, $barcode)");

            $old_loc_id = $this->db->query("SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode")->result_array();

            if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT L.BIN_ID FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode")->result_array();

              if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT DT.BIN_ID FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode")->result_array();
                
                if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT D.BIN_ID FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode")->result_array();
                
                }
              }
            }
            if($old_loc_id){
              $old_bin_id = $old_loc_id[0]['BIN_ID'];
            }else{
              $old_bin_id = 0;
            }
            

            $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
            $rs = $log_id_qry->result_array();
            $loc_trans_id = @$rs[0]['ID'];	

            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = '$newbin_id' WHERE BM.BARCODE_NO = $barcode");
            $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.BIN_ID = '$newbin_id' WHERE LOT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_DEKIT_US_DT DEKIT SET DEKIT.BIN_ID = '$newbin_id' WHERE DEKIT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT BDT SET BDT.BIN_ID = '$newbin_id' WHERE BDT.BARCODE_NO = $barcode");


            $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $verify_date, $barcode, $userId, '$newbin_id', '$old_bin_id', null,null,null)"); 

  }
  
}
    if(count($barcodesGridFound) > 0 ){

      foreach($barcodesGridFound as $value){
          
          $barcode = $value['BARCODE_NO'];
          
          $checkShortage = $this->db->query("SELECT SHORTAGE_ID FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ")->result_array();
          if($checkShortage){

          $shortageId = $checkShortage[0]['SHORTAGE_ID']; 

          $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ");
          $checkIfShortageBinEmpty = $this->db->query("SELECT COUNT(SHORTAGE_ID) TOTAL_RECORDS FROM LJ_BARCODE_SHORTAGE_DT WHERE SHORTAGE_ID = $shortageId ")->result_array();
          $count = $checkIfShortageBinEmpty[0]['TOTAL_RECORDS'];
          if($count <= 0){
            $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_MT WHERE SHORTAGE_ID = $shortageId ");
          }
        }

        $this->db->query("INSERT INTO LJ_BIN_VERIFY_DT (VERIFY_DT_ID, VERIFY_ID, BARCODE_NO) VALUES (
            GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_DT','VERIFY_DT_ID'), $varify_id, $barcode)");

            $old_loc_id = $this->db->query("SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode")->result_array();

            if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT L.BIN_ID FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode")->result_array();

              if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT DT.BIN_ID FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode")->result_array();
                
                if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT D.BIN_ID FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode")->result_array();
                
                }
              }
            }
            if($old_loc_id){
              $old_bin_id = $old_loc_id[0]['BIN_ID'];
            }else{
              $old_bin_id = 0;
            }
            

            $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
            $rs = $log_id_qry->result_array();
            $loc_trans_id = @$rs[0]['ID'];	

            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = '$bin_id' WHERE BM.BARCODE_NO = $barcode");
            $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.BIN_ID = '$bin_id' WHERE LOT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_DEKIT_US_DT DEKIT SET DEKIT.BIN_ID = '$bin_id' WHERE DEKIT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT BDT SET BDT.BIN_ID = '$bin_id' WHERE BDT.BARCODE_NO = $barcode");


            $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $verify_date, $barcode, $userId, '$bin_id', '$old_bin_id', null,null,null)"); 

      }
    }
    if(count($barcodesGridNotFound) > 0){

        foreach($barcodesGridNotFound as $value){
          $barcode = $value['BARCODE_NO'];

          $checkShortage = $this->db->query("SELECT SHORTAGE_ID FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ")->result_array();
          if($checkShortage){

          $shortageId = $checkShortage[0]['SHORTAGE_ID']; 

          $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode ");
          $checkIfShortageBinEmpty = $this->db->query("SELECT COUNT(SHORTAGE_ID) TOTAL_RECORDS FROM LJ_BARCODE_SHORTAGE_DT WHERE SHORTAGE_ID = $shortageId ")->result_array();
          $count = $checkIfShortageBinEmpty[0]['TOTAL_RECORDS'];
          if($count <= 0){
            $this->db->query("DELETE FROM LJ_BARCODE_SHORTAGE_MT WHERE SHORTAGE_ID = $shortageId ");
          }
        }

        $this->db->query("INSERT INTO LJ_BIN_VERIFY_DT (VERIFY_DT_ID, VERIFY_ID, BARCODE_NO) VALUES (
            GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_DT','VERIFY_DT_ID'), $varify_id, $barcode)");

              $old_loc_id = $this->db->query("SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode")->result_array();

            if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT L.BIN_ID FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode")->result_array();

              if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT DT.BIN_ID FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode")->result_array();
                
                if( count($old_loc_id) == 0 ){
                  $old_loc_id = $this->db->query("SELECT D.BIN_ID FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode")->result_array();
                
                }
              }
            }
            if($old_loc_id){
              $old_bin_id = $old_loc_id[0]['BIN_ID'];
            }else{
              $old_bin_id = 0;
            }
            

            $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
            $rs = $log_id_qry->result_array();
            $loc_trans_id = @$rs[0]['ID'];	

            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = '$bin_id' WHERE BM.BARCODE_NO = $barcode");
            $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.BIN_ID = '$bin_id' WHERE LOT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_DEKIT_US_DT DEKIT SET DEKIT.BIN_ID = '$bin_id' WHERE DEKIT.BARCODE_PRV_NO = $barcode");
            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT BDT SET BDT.BIN_ID = '$bin_id' WHERE BDT.BARCODE_NO = $barcode");


            $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $verify_date, $barcode, $userId, '$bin_id', '$old_bin_id', null,null,null)"); 

      }
    }
    if(count($barcodesGridNotFound) > 0 || count($barcodesGridFound) > 0){
      
         $transfers = $this->db->query($query)->result_array();

        foreach($transfers as $value){
            $verfiy  = $value['VERIFIED_YN'];
            $barcode = $value['BARCODE_NO'];
            $bin_id_shortage  = $value['BIN_ID'];
            if(!$verfiy){
                
                $alreadyExistBarcode = $this->db->query("SELECT * FROM LJ_BARCODE_SHORTAGE_DT WHERE BARCODE_NO = $barcode")->result_array();
                if(!$alreadyExistBarcode){
                
                    $dated = $verify_date;
                    $binAlreadyExist = $this->db->query("SELECT * FROM LJ_BARCODE_SHORTAGE_MT WHERE BIN_ID = $bin_id_shortage")->result_array();
                  if(!$binAlreadyExist){
                $short_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_BARCODE_SHORTAGE_MT','SHORTAGE_ID') SHORTAGE_ID FROM DUAL")->result_array();
                $shortage_id = $short_id[0]['SHORTAGE_ID'];

                $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
                $rs = $log_id_qry->result_array();
                $loc_trans_id = @$rs[0]['ID'];	

                $this->db->query("INSERT INTO LJ_BARCODE_SHORTAGE_MT(SHORTAGE_ID,BIN_ID,DATED,USER_ID) VALUES(
                    $shortage_id, $bin_id_shortage, $dated, $userId
                )");
                
                $this->db->query("INSERT INTO LJ_BARCODE_SHORTAGE_DT(DET_ID,SHORTAGE_ID,BARCODE_NO) VALUES(
                    GET_SINGLE_PRIMARY_KEY('LJ_BARCODE_SHORTAGE_DT','DET_ID'), $shortage_id, $barcode
                )");

                $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $verify_date, $barcode, $userId, '$bin_id_shortage', '$bin_id_shortage', null,null,null)"); 
                  }else{
                    
                $shortage_id = $binAlreadyExist[0]['SHORTAGE_ID'];

                $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
                $rs = $log_id_qry->result_array();
                $loc_trans_id = @$rs[0]['ID'];	
                
                $this->db->query("INSERT INTO LJ_BARCODE_SHORTAGE_DT(DET_ID,SHORTAGE_ID,BARCODE_NO) VALUES(
                    GET_SINGLE_PRIMARY_KEY('LJ_BARCODE_SHORTAGE_DT','DET_ID'), $shortage_id, $barcode
                )");

                $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $verify_date, $barcode, $userId, '$bin_id_shortage', '$bin_id_shortage', null,null,null)"); 
                  }
                
            }

            }
        }
        $query2 = "SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       B.BARCODE_NOTES ITEM_REMARKS,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.SALE_RECORD_NO IS NULL 
   AND B.ORDER_ID IS NULL 
   AND B.EXTENDEDORDERID IS NULL
   AND B.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   
   AND B.BIN_ID = $bin_id
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.LOT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_SPECIAL_LOTS LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DEKIT_REMARKS ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_DEKIT_US_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_NO BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       NULL ITEM_REMARKS,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_MERCHANT_BARCODE_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   
   AND LO.BIN_ID = $bin_id";

        $bin_query = "SELECT CASE WHEN TO_DATE(M.VERIFY_DATE) + 15 >= TO_DATE(SYSDATE)  THEN
                      'Valid Till: ' || TO_CHAR(TO_DATE(M.VERIFY_DATE) + 15)
                      ELSE
                        'Verified Date Expired! last verified: ' ||  TO_CHAR(TO_DATE(M.VERIFY_DATE))
                        END VERIFY_DATE,
                        CASE 
                          WHEN (TO_DATE(M.VERIFY_DATE) + 15) > TO_DATE(SYSDATE) THEN
                            'Days Left: ' || TO_CHAR( 15 - ( TO_DATE(SYSDATE) - TO_DATE(M.VERIFY_DATE) )  )
                          WHEN TO_DATE(SYSDATE) > (TO_DATE(M.VERIFY_DATE) + 15) THEN
                            'Last Verified: ' || TO_CHAR(( TO_DATE(SYSDATE) - TO_DATE(M.VERIFY_DATE))) || ' Days Before'
                          WHEN (TO_DATE(M.VERIFY_DATE) + 15) = TO_DATE(SYSDATE) THEN
                            '15 Days Complete'
                        END DAYS_LEFT
                        FROM LJ_BIN_VERIFY_MT M
                        WHERE M.BIN_ID = $bin_id";

          $transfers2 = $this->db->query($query2)->result_array();
          $bin_verification = $this->db->query($bin_query)->result_array();

          $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 

            $uri = $this->get_pictures_by_barcode($transfers2,$conditions);
            $images = $uri['uri'];
       
            $bin_verified = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id ")->result_array();
       $binExist = false;
       if($bin_verified){
        $binExist = true;
       }else{
        $binExist = false;
       }

        return array("verified" => true, "message"=>"Barcodes Verified Successfully!", "bind_ids" => $bind_ids, "images"=>$images, "bin_verified" => $binExist, "bin_verification" => $bin_verification,"transfers" => $transfers2);
    }else{
        return array("verified" => false, "message"=>"No Barcode Scanned!");
    }
    

  }
	/*================================================
	=            #END# By Tahir Amjad                =
    ================================================*/

    public function getLocationHistory(){
  $scanBarcode = $this->input->post('scanBarcode');

  $lz_barcode_mt = $this->db->query(" SELECT B.BARCODE_NO FROM LZ_BARCODE_MT  B WHERE B.BARCODE_NO ='$scanBarcode'");

   if ($lz_barcode_mt->num_rows() > 0) {

   $loc_his  = $this->db->query(" SELECT BB.BARCODE_NO,TO_CHAR(L.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRAN_DA, M.ITEM_DESC TITLE, M.FIRST_NAME TRANSFER_BY, L.NEW_LOC_ID, L.OLD_LOC_ID, DECODE(NEW_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-R' || RO.ROW_NO || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO) NEW_LOCATION, DECODE(OLD_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO, 'W' || '' || OL_WA.WAREHOUSE_NO || '-' || OLD_RAC.RACK_NO || '-R' || RO_OLD.ROW_NO || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO) OLD_LOCATION FROM LZ_LOC_TRANS_LOG L, LZ_BARCODE_MT    BB, EMPLOYEE_MT      M, BIN_MT           NEW_B, BIN_MT           OLD_B, LZ_RACK_ROWS     RO, LZ_RACK_ROWS     RO_OLD, RACK_MT          RAC, RACK_MT          OLD_RAC, WAREHOUSE_MT     WA, WAREHOUSE_MT     OL_WA, ITEMS_MT         M WHERE L.BARCODE_NO = '$scanBarcode'AND BB.ITEM_ID = M.ITEM_ID AND L.NEW_LOC_ID = NEW_B.BIN_ID AND NEW_B.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID AND RO.RACK_ID = RAC.RACK_ID AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND BB.BARCODE_NO = L.BARCODE_NO AND L.TRANS_BY_ID = M.EMPLOYEE_ID  AND L.OLD_LOC_ID = OLD_B.BIN_ID AND OLD_B.CURRENT_RACK_ROW_ID = RO_OLD.RACK_ROW_ID AND RO_OLD.RACK_ID = OLD_RAC.RACK_ID AND OLD_RAC.WAREHOUSE_ID = OL_WA.WAREHOUSE_ID  ORDER BY L.LOC_TRANS_ID DESC ")->result_array();
   if($loc_his){
        return array( "found"=>true, "message"=> "History Found!", "barcodeHistory" => $loc_his );
   }else{
      return array("found"=>false,"message" => "Barcode does not have any History !!!");
   }
   
  }else{
      $lz_special_lots = $this->db->query(" SELECT LT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS  LT WHERE LT.BARCODE_PRV_NO ='$scanBarcode'");

   if ($lz_special_lots->num_rows() > 0){
     $loc_his  = $this->db->query(" SELECT BB.BARCODE_NO,TO_CHAR(L.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRAN_DA, M.ITEM_DESC TITLE, M.FIRST_NAME TRANSFER_BY, L.NEW_LOC_ID, L.OLD_LOC_ID, DECODE(NEW_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-R' || RO.ROW_NO || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO) NEW_LOCATION, DECODE(OLD_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO, 'W' || '' || OL_WA.WAREHOUSE_NO || '-' || OLD_RAC.RACK_NO || '-R' || RO_OLD.ROW_NO || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO) OLD_LOCATION FROM LZ_LOC_TRANS_LOG L, LZ_BARCODE_MT    BB, EMPLOYEE_MT      M, BIN_MT           NEW_B, BIN_MT           OLD_B, LZ_RACK_ROWS     RO, LZ_RACK_ROWS     RO_OLD, RACK_MT          RAC, RACK_MT          OLD_RAC, WAREHOUSE_MT     WA, WAREHOUSE_MT     OL_WA, ITEMS_MT         M WHERE L.BARCODE_NO = '$scanBarcode'AND BB.ITEM_ID = M.ITEM_ID AND L.NEW_LOC_ID = NEW_B.BIN_ID AND NEW_B.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID AND RO.RACK_ID = RAC.RACK_ID AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND BB.BARCODE_NO = L.BARCODE_NO AND L.TRANS_BY_ID = M.EMPLOYEE_ID  AND L.OLD_LOC_ID = OLD_B.BIN_ID AND OLD_B.CURRENT_RACK_ROW_ID = RO_OLD.RACK_ROW_ID AND RO_OLD.RACK_ID = OLD_RAC.RACK_ID AND OLD_RAC.WAREHOUSE_ID = OL_WA.WAREHOUSE_ID  ORDER BY L.LOC_TRANS_ID DESC ")->result_array();
   if($loc_his){
        return array( "found"=>true, "message"=> "History Found!", "barcodeHistory" => $loc_his );
   }else{
      return array("found"=>false,"message" => "Barcode does not have any History !!!");
   }
   }else{
       return array("found"=>false,"message" => "Barcode does not Exist !!!");
   }
  }

}
public function getBarcodeShortage(){
  $shortageList = $this->db->query("SELECT DT.BARCODE_NO, 
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       MT.BIN_ID,
       BM.EBAY_ITEM_ID,
       (CASE WHEN BM.EBAY_ITEM_ID IS NULL THEN 'NOT' ELSE 'LISTED' END) LISTED_STATUS,
       NVL(NVL(LOT.MPN_DESCRIPTION, IT.ITEM_DESC), US.MPN_DESCRIPTION) TITLE,
       NVL(LOT.CARD_UPC, IT.ITEM_MT_UPC) UPC,
       NVL(LOT.CARD_MPN, IT.ITEM_MT_MFG_PART_NO) MPN,
       NVL(LOT.BRAND, IT.ITEM_MT_MANUFACTURE) MANUFACTURER,
       NVL(NVL(NVL(BM.BARCODE_NOTES,LOT.LOT_REMARKS),US.DEKIT_REMARKS),NULL) ITEM_REMARKS,
       TO_CHAR(MT.DATED, 'MM-DD-YYYY HH24:MI:SS') SHORTAGE_DATE,
       NVL(NVL(NVL(BM.DISCARD,LOT.DISCARD),US.DISCARD),BDT.DISCARD) DISCARD,
       NVL(NVL(NVL(BM.DISCARD_REMARKS,LOT.DISCARD_REMARKS),US.DISCARD_REMARKS),BDT.DISCARD_REMARKS) DISCARD_REMARKS,
       EM.FIRST_NAME SHORTAGE_BY
  FROM LJ_BARCODE_SHORTAGE_MT MT,
       LJ_BARCODE_SHORTAGE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_DEKIT_US_DT         US,
       LZ_MERCHANT_BARCODE_DT BDT,
       BIN_MT                 BIN,
       ITEMS_MT               IT,
       EMPLOYEE_MT            EM
 WHERE MT.SHORTAGE_ID = DT.SHORTAGE_ID
   AND BIN.BIN_ID = MT.BIN_ID
   AND EM.EMPLOYEE_ID = MT.USER_ID
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND BM.ITEM_ID = IT.ITEM_ID(+)
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO(+)
   AND DT.BARCODE_NO = US.BARCODE_PRV_NO(+)
   AND DT.BARCODE_NO = BDT.BARCODE_NO(+)
   AND NVL(NVL(NVL(BM.DISCARD,LOT.DISCARD),US.DISCARD),BDT.DISCARD ) = 0")->result_array();

if($shortageList){
      $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
      $uri = $this->get_pictures_by_barcode($shortageList,$conditions);
      $images = $uri['uri'];
  return array("found"=>true, "shortageList" => $shortageList, "images"=>$images);
}else{
  return array("found"=>false, "message" => "No Data Found");
}

}
public function getBarcodeShortageByBin(){
  $bin_id = $this->input->post('bin_id');
  $shortageList = $this->db->query("SELECT DT.BARCODE_NO, 
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       MT.BIN_ID,
       BM.EBAY_ITEM_ID,
       (CASE WHEN BM.EBAY_ITEM_ID IS NULL THEN 'NOT' ELSE 'LISTED' END) LISTED_STATUS,
       NVL(NVL(LOT.MPN_DESCRIPTION, IT.ITEM_DESC), US.MPN_DESCRIPTION) TITLE,
       NVL(LOT.CARD_UPC, IT.ITEM_MT_UPC) UPC,
       NVL(LOT.CARD_MPN, IT.ITEM_MT_MFG_PART_NO) MPN,
       NVL(LOT.BRAND, IT.ITEM_MT_MANUFACTURE) MANUFACTURER,
       NVL(NVL(NVL(BM.BARCODE_NOTES,LOT.LOT_REMARKS),US.DEKIT_REMARKS),NULL) ITEM_REMARKS,
       TO_CHAR(MT.DATED, 'MM-DD-YYYY HH24:MI:SS') SHORTAGE_DATE,
       EM.FIRST_NAME SHORTAGE_BY,
       NVL(NVL(NVL(BM.DISCARD,LOT.DISCARD),US.DISCARD),BDT.DISCARD) DISCARD,
       NVL(NVL(NVL(BM.DISCARD_REMARKS,LOT.DISCARD_REMARKS),US.DISCARD_REMARKS),BDT.DISCARD_REMARKS) DISCARD_REMARKS
  FROM LJ_BARCODE_SHORTAGE_MT MT,
       LJ_BARCODE_SHORTAGE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_DEKIT_US_DT         US,
       LZ_MERCHANT_BARCODE_DT BDT,
       BIN_MT                 BIN,
       ITEMS_MT               IT,
       EMPLOYEE_MT            EM
 WHERE MT.SHORTAGE_ID = DT.SHORTAGE_ID
   AND BIN.BIN_ID = MT.BIN_ID
   AND EM.EMPLOYEE_ID = MT.USER_ID
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND BM.ITEM_ID = IT.ITEM_ID(+)
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO(+)
   AND DT.BARCODE_NO = US.BARCODE_PRV_NO(+)
   AND DT.BARCODE_NO = BDT.BARCODE_NO(+)
   --AND NVL(NVL(NVL(BM.DISCARD,LOT.DISCARD),US.DISCARD),BDT.DISCARD ) = 0 
   AND MT.BIN_ID = $bin_id ")->result_array();

if($shortageList){
      $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
      $uri = $this->get_pictures_by_barcode($shortageList,$conditions);
      $images = $uri['uri'];
  return array("found"=>true, "shortageList" => $shortageList, "images"=>$images);
}else{
  return array("found"=>false, "message" => "No Data Found");
}

}
public function resetBin(){
  $bin_id = $this->input->post('bin_id');


  $this->db->query("DELETE FROM LJ_BIN_VERIFY_DT WHERE VERIFY_ID = ( SELECT VERIFY_ID FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id)");

  $delete = $this->db->query("DELETE FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id");

  $query2 = "SELECT B.BARCODE_NO,
       B.BIN_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       B.EBAY_ITEM_ID,
       B.DISCARD,
       B.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   
   AND B.BIN_ID = $bin_id
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_SPECIAL_LOTS LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       LO.BIN_ID,
       LO.MPN_DESCRIPTION DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_PRV_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_DEKIT_US_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_PRV_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   
   AND LO.BIN_ID = $bin_id
   
   UNION ALL
   
   SELECT LO.BARCODE_NO BARCODE_NO,
       LO.BIN_ID,
       NULL DESCR,
       NULL UPC,
       NULL MPN,
       MAX_BAR.TRANS_BY_ID TRANS_BY_ID,
       TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE,
       NULL EBAY_ITEM_ID,
       LO.DISCARD,
       LO.DISCARD_REMARKS,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN,
           (SELECT TO_CHAR(MT.VERIFY_DATE,'DD-MM-YY HH24:MI:SS')
          FROM LJ_BIN_VERIFY_MT MT, LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = LO.BARCODE_NO
           AND ROWNUM = 1) OUT_BOUND
  FROM LZ_MERCHANT_BARCODE_DT LO,
       (SELECT LL.BARCODE_NO, M.USER_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME
          FROM LZ_LOC_TRANS_LOG LL, EMPLOYEE_MT M
         WHERE LL.LOC_TRANS_ID IN
               (SELECT MAX(L.LOC_TRANS_ID)
                  FROM LZ_LOC_TRANS_LOG L
                 GROUP BY L.BARCODE_NO)
           AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR
 WHERE LO.BARCODE_NO = MAX_BAR.BARCODE_NO(+)
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.BIN_ID = $bin_id) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.BIN_ID = $bin_id)
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   
   AND LO.BIN_ID = $bin_id";

  if($delete){
    $transfers = $this->db->query($query2)->result_array();
    $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
      $uri = $this->get_pictures_by_barcode($transfers,$conditions);
      $images = $uri['uri'];

    return array("verified"=>true, "transfers" => $transfers, "images" => $images, "message" => "Bin Successfully Reset!");
  }else{
    return array("verified"=>false, "message" => "Something went wrong!");
  }

}
public function getDiscardedBarcodes(){
  $discardedList = $this->db->query("SELECT B.BARCODE_NO,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       B.BIN_ID,
       B.EBAY_ITEM_ID,
       (CASE
         WHEN B.EBAY_ITEM_ID IS NULL THEN
          'NOT'
         ELSE
          'LISTED'
       END) LISTED_STATUS,
       I.ITEM_DESC TITLE,
       I.ITEM_MT_UPC UPC,
       I.ITEM_MT_MFG_PART_NO MPN,
       I.ITEM_MT_MANUFACTURE MANUFACTURER,
       TO_CHAR(B.DISCARD_DATE, 'MM-DD-YYYY HH24:MI:SS') AS DISCARD_DATE,
       B.DISCARD_REMARKS,
       EM.USER_NAME DISCARD_BY,
       B.DISCARD

  FROM LZ_BARCODE_MT B,
       ITEMS_MT I,
       EMPLOYEE_MT EM,
       BIN_MT BIN
 WHERE B.ITEM_ID = I.ITEM_ID(+)
   AND B.DISCARD_BY = EM.EMPLOYEE_ID
   AND B.BIN_ID = BIN.BIN_ID
   AND B.DISCARD = 1
   AND ROWNUM <= 10
   
   
 UNION ALL
 
 SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       LO.BIN_ID,
       NULL EBAY_ITEM_ID,
       'NOT' LISTED_STATUS,
       LO.MPN_DESCRIPTION TITLE,
       LO.CARD_UPC UPC,
       LO.CARD_MPN MPN,
       LO.BRAND MANUFACTURER,
       TO_CHAR(LO.DISCARD_DATE, 'MM-DD-YYYY HH24:MI:SS') AS DISCARD_DATE,
       NVL(LO.DISCARD_REMARKS,LO.LOT_REMARKS) DISCARD_REMARKS,
       EM.USER_NAME DISCARD_BY,
       LO.DISCARD

  FROM LZ_SPECIAL_LOTS LO, BIN_MT BIN, EMPLOYEE_MT EM
 WHERE LO.BIN_ID = BIN.BIN_ID
   AND LO.DISCARD_BY = EM.EMPLOYEE_ID
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.DISCARD = 1
   AND ROWNUM <= 10
   
   UNION ALL
   
   SELECT LO.BARCODE_PRV_NO BARCODE_NO,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       LO.BIN_ID,
       NULL EBAY_ITEM_ID,
       'NOT' LISTED_STATUS,
       LO.MPN_DESCRIPTION TITLE,
       NULL UPC,
       NULL MPN,
       NULL MANUFACTURER,
       TO_CHAR(LO.DISCARD_DATE, 'MM-DD-YYYY HH24:MI:SS') AS DISCARD_DATE,
       NVL(LO.DISCARD_REMARKS,LO.DEKIT_REMARKS) DISCARD_REMARKS,
       EM.USER_NAME DISCARD_BY,
       LO.DISCARD
  FROM LZ_DEKIT_US_DT LO, BIN_MT BIN, EMPLOYEE_MT EM
 WHERE LO.BIN_ID = BIN.BIN_ID
   AND LO.DISCARD_BY = EM.EMPLOYEE_ID
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.DISCARD = 1
   AND ROWNUM <= 10
   
   
   UNION ALL
   
   SELECT LO.BARCODE_NO,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       LO.BIN_ID,
       NULL EBAY_ITEM_ID,
       'NOT' LISTED_STATUS,
       NULL TITLE,
       NULL UPC,
       NULL MPN,
       NULL MANUFACTURER,
       TO_CHAR(LO.DISCARD_DATE, 'MM-DD-YYYY HH24:MI:SS') AS DISCARD_DATE,
       LO.DISCARD_REMARKS,
       EM.USER_NAME DISCARD_BY,
       LO.DISCARD
  FROM LZ_MERCHANT_BARCODE_DT LO, BIN_MT BIN, EMPLOYEE_MT EM
 WHERE LO.BIN_ID = BIN.BIN_ID
   AND LO.DISCARD_BY = EM.EMPLOYEE_ID
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM WHERE BM.DISCARD = 1) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT WHERE LOT.DISCARD = 1)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT WHERE DEKIT.DISCARD = 1)
   AND LO.DISCARD = 1
   AND ROWNUM <= 10
")->result_array();

if($discardedList){
      $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
      $uri = $this->get_pictures_by_barcode($discardedList,$conditions);
      $images = $uri['uri'];
  return array("found"=>true, "discardedList" => $discardedList, "images"=>$images);
}else{
  return array("found"=>false, "message" => "No Data Found");
}

}
public function discardBarcode(){
  $barcode = $this->input->post('barcode');
  $discard_remarks = $this->input->post('discard_remarks');
  $userId  = $this->input->post('userId');

  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $discard_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $this->db->query("UPDATE LZ_BARCODE_MT B SET B.DISCARD = 1, B.DISCARD_BY = $userId, B.DISCARD_DATE = $discard_date, DISCARD_REMARKS = '$discard_remarks' WHERE B.BARCODE_NO = $barcode");
  $this->db->query("UPDATE LZ_SPECIAL_LOTS L SET L.DISCARD = 1, L.DISCARD_BY = $userId, L.DISCARD_DATE = $discard_date, DISCARD_REMARKS = '$discard_remarks' WHERE L.BARCODE_PRV_NO = $barcode");
  $this->db->query("UPDATE LZ_DEKIT_US_DT D SET D.DISCARD = 1, D.DISCARD_BY = $userId, D.DISCARD_DATE = $discard_date, DISCARD_REMARKS = '$discard_remarks' WHERE D.BARCODE_PRV_NO = $barcode");
  $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.DISCARD = 1, DT.DISCARD_BY = $userId, DT.DISCARD_DATE = $discard_date, DISCARD_REMARKS = '$discard_remarks' WHERE BARCODE_NO = $barcode");

  return array("discarded" => true, "message" => "Barcode Discarded!");

}
public function getBinStats(){
  $getBinStats = $this->db->query("SELECT BIN.BIN_ID,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       ( CASE
                 WHEN VM.VERIFY_ID IS NULL THEN
                  'NOT'
                 WHEN VM.VERIFY_ID IS NOT NULL THEN
                  'VERIFIED'
                 ELSE
                  ''
               END
         ) VERIFY_STATUS,
       DECODE(BIN.BIN_TYPE,
              'WB',
              'WHERE HOUSE',
              'PB',
              'PICTURE',
              'NA',
              'NO RACK',
              'TC',
              'TECHNICIAN',
              'AB',
              'AUDIT',
              'UB',
              'PULLAR',
              'NO') BIN_ZONE_FILTER,
       (SELECT COUNT(VD.BARCODE_NO)
          FROM LJ_BIN_VERIFY_DT VD
         WHERE VM.VERIFY_ID = VD.VERIFY_ID) TOTAL_VERIFIED_IN_BIN,
       
       (SELECT COUNT(SD.BARCODE_NO)
          FROM LJ_BARCODE_SHORTAGE_DT SD
         WHERE SD.SHORTAGE_ID = SM.SHORTAGE_ID) TOTAL_SHORTAGE_IN_BIN,
       
       TO_CHAR(VM.VERIFY_DATE, 'MM-DD-YYYY HH24:MI:SS') VERIFY_DATE,
       EM.USER_NAME VERIFY_BY,
       CASE WHEN TO_DATE(VM.VERIFY_DATE) + 15 >= TO_DATE(SYSDATE)  THEN
          'Valid Till: ' || TO_CHAR(TO_DATE(VM.VERIFY_DATE) + 15)
            WHEN TO_DATE(VM.VERIFY_DATE) + 15 < TO_DATE(SYSDATE) THEN
            'Verified Date Expired! last verified: ' ||  TO_CHAR(TO_DATE(VM.VERIFY_DATE))
            END VERIFY_DATE_STATUS,
       CASE 
            WHEN (TO_DATE(VM.VERIFY_DATE) + 15) > TO_DATE(SYSDATE) THEN
               'Days Left: ' || TO_CHAR( 15 - ( TO_DATE(SYSDATE) - TO_DATE(VM.VERIFY_DATE) )  )
            WHEN TO_DATE(SYSDATE) > (TO_DATE(VM.VERIFY_DATE) + 15) THEN
               'Last Verified: ' || TO_CHAR(( TO_DATE(SYSDATE) - TO_DATE(VM.VERIFY_DATE))) || ' Days Before'
            WHEN (TO_DATE(VM.VERIFY_DATE) + 15) = TO_DATE(SYSDATE) THEN
              '15 Days Complete'
           END DAYS_LEFT
           
  FROM BIN_MT BIN, LJ_BIN_VERIFY_MT VM, EMPLOYEE_MT EM, LJ_BARCODE_SHORTAGE_MT SM
  WHERE BIN.BIN_ID = VM.BIN_ID(+)
  AND VM.VERIFY_BY = EM.EMPLOYEE_ID(+)
  AND VM.BIN_ID = SM.BIN_ID(+)
 ORDER BY VERIFY_DATE
")->result_array();

$total_items = $this->db->query("SELECT BM.TOTAL_ITEMS + LOT.TOTAL_ITEMS + DT.TOTAL_ITEMS + BDT.TOTAL_ITEMS TOTAL_ITEMS FROM (SELECT COUNT(B.BARCODE_NO) TOTAL_ITEMS
  FROM LZ_BARCODE_MT B
 WHERE B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   ) BM,
 (
 SELECT COUNT(LO.BARCODE_PRV_NO) TOTAL_ITEMS
       
  FROM LZ_SPECIAL_LOTS LO
 WHERE LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   ) LOT,
   
  (SELECT COUNT(LO.BARCODE_PRV_NO) TOTAL_ITEMS
  FROM LZ_DEKIT_US_DT LO
 WHERE LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   ) DT,
   (
   SELECT COUNT(LO.BARCODE_NO) TOTAL_ITEMS
      
  FROM LZ_MERCHANT_BARCODE_DT LO
 WHERE LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM ) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT )
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   ) BDT")->result_array();
   $totalItems = 0;
   if($total_items){
      $totalItems = $total_items[0]['TOTAL_ITEMS'];
   }
   $verified_items =  $this->db->query("SELECT BM.TOTAL_ITEMS + LOT.TOTAL_ITEMS + DT.TOTAL_ITEMS + BDT.TOTAL_ITEMS TOTAL_ITEMS FROM (SELECT COUNT(B.BARCODE_NO) TOTAL_ITEMS
  FROM LZ_BARCODE_MT B,
       LJ_BIN_VERIFY_DT VD
 WHERE B.BARCODE_NO = VD.BARCODE_NO
   AND B.PULLING_ID IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
   AND B.ITEM_ADJ_DET_ID_FOR_IN IS NULL
   AND B.LZ_POS_MT_ID IS NULL
   AND B.LZ_PART_ISSUE_MT_ID IS NULL
   AND B.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = B.BARCODE_NO)
   ) BM,
 (
 SELECT COUNT(LO.BARCODE_PRV_NO) TOTAL_ITEMS
       
  FROM LZ_SPECIAL_LOTS LO,
  LJ_BIN_VERIFY_DT VD
 WHERE LO.BARCODE_PRV_NO = VD.BARCODE_NO
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   ) LOT,
   
  (SELECT COUNT(LO.BARCODE_PRV_NO) TOTAL_ITEMS
  FROM LZ_DEKIT_US_DT LO,
  LJ_BIN_VERIFY_DT VD
 WHERE LO.BARCODE_PRV_NO = VD.BARCODE_NO
   AND LO.LZ_MANIFEST_DET_ID IS NULL
   AND LO.BARCODE_PRV_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_PRV_NO)
   ) DT,
   (
   SELECT COUNT(LO.BARCODE_NO) TOTAL_ITEMS
      
  FROM LZ_MERCHANT_BARCODE_DT LO,
   LJ_BIN_VERIFY_DT VD
 WHERE LO.BARCODE_NO = VD.BARCODE_NO
   AND LO.BARCODE_NO NOT IN (SELECT BM.BARCODE_NO FROM LZ_BARCODE_MT BM ) 
   AND LO.BARCODE_NO NOT IN (SELECT LOT.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS LOT)
   AND LO.BARCODE_NO NOT IN (SELECT DEKIT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DEKIT )
   AND LO.BARCODE_NO NOT IN (SELECT BARCODE_NO FROM LJ_BARCODE_SHORTAGE_DT SR WHERE SR.BARCODE_NO = LO.BARCODE_NO)
   ) BDT")->result_array();

  $verifiedItems = 0;
   if($verified_items){
      $verifiedItems = $verified_items[0]['TOTAL_ITEMS'];
   }

 if($getBinStats){ 
    return array("found" => true, "getBinStats" => $getBinStats, "totalItems" => $totalItems, "verifiedItems" => $verifiedItems , "message" => "Statistics Loaded");
 }else{
    return array("found" => false, "message" => "No Data Found!"); 
 }
}
public function get_barcode(){
    $barcode = $this->input->post('barcode');
  // var_dump($barcode);
  $str = strlen($barcode);//if length = 12 its ebay id

      if($str == 12){
        $ebY_deta = $this->db->query(" SELECT B.BARCODE_NO, CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED' ELSE 'AVAILABLE' END STATUS,  B.EBAY_ITEM_ID, I.ITEM_DESC DESCR, I.ITEM_MT_MANUFACTURE MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_BARCODE_MT   B,LZ_SALESLOAD_DET DE, ITEMS_MT I, LZ_ITEM_COND_MT CO, BIN_MT BI, LZ_RACK_ROWS  RA, RACK_MT  RC, WAREHOUSE_MT    WA WHERE B.EBAY_ITEM_ID =$barcode AND B.ITEM_ID = I.ITEM_ID AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();
       return array( "found" => true, "message" => "Barcode Found", 'barcodeHistory' => $ebY_deta,'eby_qyery'=>true );
      }else{     

        $bar_query = $this->db->query(" SELECT B.BARCODE_NO FROM LZ_BARCODE_MT  B WHERE B.BARCODE_NO ='$barcode'");

  if ($bar_query->num_rows() > 0) {
    $bar_query = $bar_query->result_array();
    $bar_no = $bar_query[0]['BARCODE_NO'];
    
    $bar_deta = $this->db->query(" SELECT B.BARCODE_NO,CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE' END STATUS, B.EBAY_ITEM_ID, I.ITEM_DESC DESCR, I.ITEM_MT_MANUFACTURE MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_BARCODE_MT B, ITEMS_MT I, LZ_SALESLOAD_DET DE, LZ_ITEM_COND_MT CO, BIN_MT BI, LZ_RACK_ROWS RA, RACK_MT         RC, WAREHOUSE_MT  WA WHERE B.BARCODE_NO = $bar_no AND B.ITEM_ID = I.ITEM_ID AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();


     return array( "found" => true, "message" => "Barcode Found", 'barcodeHistory' =>$bar_deta,'bar_query'=>true); // if barcode valid
  }else{

      $bar_deta = $this->db->query(" SELECT B.BARCODE_PRV_NO BARCODE_NO, 'NULL' EBAY_ITEM_ID, 'NULL' DESCR, 'NULL' MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_DEKIT_US_DT   B, LZ_ITEM_COND_MT CO, BIN_MT          BI, LZ_RACK_ROWS    RA, RACK_MT         RC, WAREHOUSE_MT    WA WHERE B.BARCODE_PRV_NO =$barcode AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();

      if( count($bar_deta) > 0){
        return array( "found" => true, "message" => "Barcode Found", 'barcodeHistory' =>$bar_deta ,'det_bar'=>true); 
      }
     //} // if barcode not valid
  }
      $bar_deta = $this->db->query(" SELECT B.BARCODE_PRV_NO BARCODE_NO, 'NULL' EBAY_ITEM_ID, B.MPN_DESCRIPTION DESCR, B.BRAND MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_SPECIAL_LOTS   B, LZ_ITEM_COND_MT CO, BIN_MT          BI, LZ_RACK_ROWS    RA, RACK_MT         RC, WAREHOUSE_MT    WA WHERE B.BARCODE_PRV_NO = $barcode AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) AND LZ_MANIFEST_DET_ID IS NULL")->result_array();

      if( count($bar_deta) == 0 ){
        $bar_deta = $this->db->query(" SELECT B.BARCODE_NO, 'NULL' EBAY_ITEM_ID, 'NULL' DESCR, 'NULL' MANUF, 'NULL' CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_MERCHANT_BARCODE_DT   B, BIN_MT          BI, LZ_RACK_ROWS    RA, RACK_MT         RC, WAREHOUSE_MT    WA WHERE B.BARCODE_NO = $barcode AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID")->result_array();

        return array( "found" => true, "message" => "Barcode Found", 'barcodeHistory' =>$bar_deta ,'det_bar'=>true); 
      }

     return array( "found" => true, "message" => "Barcode Found", 'barcodeHistory' =>$bar_deta ,'det_bar'=>true); 

}// main if str length
}
    public function updateLocation(){
        
        $scan_bin       = $this->input->post('scan_bin');
        $userId         = $this->input->post('userId');
        $method         = $this->input->post('method');
        $barcodeHistory = "";
        $postedBarcodes = "";
        if($method == "ANDROID"){
        $barcodeHistory = json_decode($this->input->post('barcodeHistory'),true);
        $postedBarcodes = json_decode($this->input->post('postedBarcodes'),true);
      }else if($method == "WEB"){
        $barcodeHistory = $this->input->post('barcodeHistory');
        $postedBarcodes = $this->input->post('postedBarcodes');
      }else{
        return array("update" => false, "message"=>"No Barcode Scanned!");
      }

        $checkBin = $this->db->query("SELECT * FROM BIN_MT B WHERE B.BIN_TYPE || '-' || B.BIN_NO = '$scan_bin' ")->result_array();

        if(count($checkBin) == 0 ){
          return array("update" => false, "message" => "Scan Bin Invalid");
        }
        $bin_id = $checkBin[0]['BIN_ID'];

        $verified_mt = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_MT WHERE BIN_ID = $bin_id")->result_array();
        
        $verify_id = "";
        if($verified_mt){
          $verify_id = $verified_mt[0]['VERIFY_ID'];
        }

        if( count($barcodeHistory) > 0 ){
         
          foreach($barcodeHistory as $value){

            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

           $barcode = $value['BARCODE_NO'];

           if($verify_id){
              $barcode_exist = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_DT WHERE VERIFY_ID = $verify_id AND BARCODE_NO = $barcode")->result_array();
              if(!$barcode_exist){
                $this->db->query("INSERT INTO LJ_BIN_VERIFY_DT (VERIFY_DT_ID, VERIFY_ID, BARCODE_NO) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_DT','VERIFY_DT_ID'),$verify_id, $barcode) ");
              }
            }

            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = '$bin_id' WHERE BM.BARCODE_NO = (SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode)");

            $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.BIN_ID = '$bin_id' WHERE LOT.BARCODE_PRV_NO = (SELECT L.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode)");

            $this->db->query("UPDATE LZ_DEKIT_US_DT DEKIT SET DEKIT.BIN_ID = '$bin_id' WHERE DEKIT.BARCODE_PRV_NO = (SELECT DT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode)");

            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT BDT SET BDT.BIN_ID = '$bin_id' WHERE BDT.BARCODE_NO = (SELECT D.BARCODE_NO FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode)");

            $old_barcode_location = $this->db->query("SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode")->result_array();

            if( count($old_barcode_location) == 0 ){
                  $old_barcode_location = $this->db->query("SELECT L.BIN_ID FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode")->result_array();

              if( count($old_barcode_location) == 0 ){
                  $old_barcode_location = $this->db->query("SELECT DT.BIN_ID FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode")->result_array();
                
                if( count($old_barcode_location) == 0 ){
                  $old_barcode_location = $this->db->query("SELECT D.BIN_ID FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode")->result_array();
                
                }
              }
            }
            if($old_barcode_location){
            $old_bin_id = $old_barcode_location[0]['BIN_ID'];
            }else{
              $old_bin_id = 0;
            }

            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL");
            $rs = $qry->result_array();
            $loc_trans_id = $rs[0]['ID'];

            $updateBin = $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS) VALUES($loc_trans_id, $transfer_date, $barcode, $userId, $bin_id, $old_bin_id, 'null')");
         }
        }
        if( count($postedBarcodes) > 0 ){
         
          foreach($postedBarcodes as $value){
            
            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            $transfer_by_id = $this->session->userdata('user_id');

           $barcode = $value['BARCODE_NO'];

           if($verify_id){
              $barcode_exist = $this->db->query("SELECT * FROM LJ_BIN_VERIFY_DT WHERE VERIFY_ID = $verify_id AND BARCODE_NO = $barcode")->result_array();
              if(!$barcode_exist){
                $this->db->query("INSERT INTO LJ_BIN_VERIFY_DT (VERIFY_DT_ID, VERIFY_ID, BARCODE_NO) VALUES (GET_SINGLE_PRIMARY_KEY('LJ_BIN_VERIFY_DT','VERIFY_DT_ID'),$verify_id, $barcode) ");
              }
            }

            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = '$bin_id' WHERE BM.BARCODE_NO = (SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode)");

            $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.BIN_ID = '$bin_id' WHERE LOT.BARCODE_PRV_NO = (SELECT L.BARCODE_PRV_NO FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode)");

            $this->db->query("UPDATE LZ_DEKIT_US_DT DEKIT SET DEKIT.BIN_ID = '$bin_id' WHERE DEKIT.BARCODE_PRV_NO = (SELECT DT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode)");

            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT BDT SET BDT.BIN_ID = '$bin_id' WHERE BDT.BARCODE_NO = (SELECT D.BARCODE_NO FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode)");

            $old_barcode_location = $this->db->query("SELECT B.BIN_ID FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = $barcode")->result_array();

            if( count($old_barcode_location) == 0 ){
                  $old_barcode_location = $this->db->query("SELECT L.BIN_ID FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode")->result_array();

              if( count($old_barcode_location) == 0 ){
                  $old_barcode_location = $this->db->query("SELECT DT.BIN_ID FROM LZ_DEKIT_US_DT DT WHERE DT.BARCODE_PRV_NO = $barcode")->result_array();
                
                if( count($old_barcode_location) == 0 ){
                  $old_barcode_location = $this->db->query("SELECT D.BIN_ID FROM LZ_MERCHANT_BARCODE_DT D WHERE D.BARCODE_NO = $barcode")->result_array();
                
                }
              }
            }
            $old_bin_id = $old_barcode_location[0]['BIN_ID'];

            $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL");
            $rs = $qry->result_array();
            $loc_trans_id = $rs[0]['ID'];

            $updateBin = $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS) VALUES($loc_trans_id, $transfer_date, $barcode, $userId, $bin_id, $old_bin_id, 'null')");
         }
        }
           if( count($barcodeHistory) > 0 || count($postedBarcodes) > 0 ){
              return array("update" => true, "message" => "Location Successfully Updated");
           } 
    }
    public function searchDekitAudit(){
  		 $location    = $this->input->post('location');
        $startDate   = $this->input->post('startDate');
        $endDate     = $this->input->post('endDate');

        $fromDate = date_create($startDate);
        $toDate   = date_create($endDate);

        $from = date_format($fromDate,'Y-m-d');
        $to = date_format($toDate, 'Y-m-d');
        
        //var_dump($location, $rslt); 
	 if($location == "PK"){
         $listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID,DECODE((SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO), NULL, (SELECT LO.FOLDER_NAME FROM LZ_SPECIAL_LOTS LO WHERE LO.BARCODE_PRV_NO = BCD.BARCODE_NO),(SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO)) FOLDER_NAME, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER, BM.BIN_TYPE BI_TYP,I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_BARCODE_MT BCD, BIN_MT BM, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE IN (3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = '$location')"; }
         elseif($location == "US"){
	     $listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID,DECODE((SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO), NULL, (SELECT LO.FOLDER_NAME FROM LZ_SPECIAL_LOTS LO WHERE LO.BARCODE_PRV_NO = BCD.BARCODE_NO),(SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO)) FOLDER_NAME, LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,BM.BIN_TYPE BI_TYP, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_BARCODE_MT BCD, BIN_MT BM, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE IN (3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID AND E.LISTER_ID IN (SELECT EMPLOYEE_ID FROM EMPLOYEE_MT WHERE LOCATION = 'US')";
	 		}else{
	 	$listed_qry = "SELECT CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END SOLD_STAT,LS.SEED_ID, DECODE((SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO), NULL, (SELECT LO.FOLDER_NAME FROM LZ_SPECIAL_LOTS LO WHERE LO.BARCODE_PRV_NO = BCD.BARCODE_NO),(SELECT UI.FOLDER_NAME FROM LZ_DEKIT_US_DT UI WHERE UI.BARCODE_PRV_NO = BCD.BARCODE_NO)) FOLDER_NAME,LS.LZ_MANIFEST_ID, E.STATUS, E.LISTER_ID, E.LIST_ID, TO_CHAR(E.LIST_DATE, 'MM-DD-YYYY HH24:MI:SS') AS LIST_DATE, E.LZ_SELLER_ACCT_ID, LS.EBAY_PRICE, LM.LOADING_NO, LM.LOADING_DATE, LM.PURCH_REF_NO, I.ITEM_ID, I.ITEM_CODE LAPTOP_ITEM_CODE, LS.ITEM_TITLE ITEM_MT_DESC, I.ITEM_MT_MANUFACTURE MANUFACTURER,BM.BIN_TYPE BI_TYP, I.ITEM_MT_MFG_PART_NO MFG_PART_NO, BCD.CONDITION_ID ITEM_CONDITION, BCD.EBAY_ITEM_ID, 1 QUANTITY, BCD.BARCODE_NO, BCD.BIN_ID, BM.BIN_TYPE ||'-'|| BM.BIN_NO BIN_NAME, (SELECT P.BARCODE_NO FROM LZ_DEKIT_US_MT P, LZ_DEKIT_US_DT DT WHERE P.LZ_DEKIT_US_MT_ID = DT.LZ_DEKIT_US_MT_ID AND DT.BARCODE_PRV_NO = BCD.BARCODE_NO) MASTER_BARCODE FROM LZ_ITEM_SEED LS, LZ_MANIFEST_MT LM, ITEMS_MT I, EBAY_LIST_MT E, LZ_BARCODE_MT BCD, BIN_MT BM, LZ_SALESLOAD_DET DE WHERE LS.ITEM_ID = I.ITEM_ID AND E.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.ITEM_ID = I.ITEM_ID AND BCD.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND E.SEED_ID = LS.SEED_ID AND LS.LZ_MANIFEST_ID = BCD.LZ_MANIFEST_ID AND LS.ITEM_ID = BCD.ITEM_ID AND LS.DEFAULT_COND = BCD.CONDITION_ID AND LS.LZ_MANIFEST_ID = LM.LZ_MANIFEST_ID AND E.EBAY_ITEM_ID = BCD.EBAY_ITEM_ID AND LM.MANIFEST_TYPE IN (3, 4) AND BCD.EBAY_STICKER = 0 AND BCD.BIN_ID = BM.BIN_ID "; }

	  if($location == "PK"){
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

	    $listed_qry .= $date_qry;
	}elseif($location == "US"){
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";
		$listed_qry .= $date_qry;
	}else{
        
	    $date_qry = "AND E.LIST_DATE between TO_DATE('$from "."00:00:00', 'YYYY-MM-DD HH24:MI:SS') AND TO_DATE('$to ". "23:59:59', 'YYYY-MM-DD HH24:MI:SS')";

	    $listed_qry .= $date_qry;
	}
		$listed_qry.= " ORDER BY EBAY_ITEM_ID DESC";

	$allDekitData = $this->db->query($listed_qry)->result_array();

        if($allDekitData){
         $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($allDekitData,$conditions);

            $images = $uri['uri'];
        return array("found" => true, "allDekitData" => $allDekitData, "images" => $images);
    }else{
        return array("found" => false, "message" => "No Data Found");
    }
    /////////////////////////////////// 
  }
   public function get_pictures_by_barcode($barcodes,$conditions){

            $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
            $path = $path->result_array();  	

            $master_path = $path[0]["MASTER_PATH"];
            $uri = array();
            $base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';
                foreach($barcodes as $barcode){

                    $bar = $barcode['BARCODE_NO'];

                    $getFolder = $this->db->query("SELECT LOT.FOLDER_NAME FROM LZ_SPECIAL_LOTS LOT WHERE LOT.BARCODE_PRV_NO = '$bar' ")->result_array();
                    $folderName = "";
                    if($getFolder){
                      $folderName = $getFolder[0]['FOLDER_NAME'];
                    }else{
                      $folderName = $bar;
                    }

                     
                        $dir = "";
                        $barcodePictures = $master_path.$folderName."/";
                        $barcodePicturesThumb = $master_path.$folderName."/thumb"."/";

                        if (is_dir($barcodePictures)){
                            $dir = $barcodePictures;
                        }else if(is_dir($barcodePicturesThumb)){
                            $dir = $barcodePicturesThumb;
                        } 
                    
                  if(!is_dir($dir)){
                    $getBarcodeMt = $this->db->query("SELECT SD.F_UPC UPC, SD.F_MPN MPN
                                                      FROM LZ_BARCODE_MT BM, LZ_ITEM_SEED SD
                                                    WHERE BM.ITEM_ID = SD.ITEM_ID
                                                    AND BM.LZ_MANIFEST_ID = SD.LZ_MANIFEST_ID
                                                    AND BM.CONDITION_ID = SD.DEFAULT_COND
                                                    AND BM.BARCODE_NO = '$bar'
                                                    ")->result_array();
                    $upc = "";
                    $mpn = "";
                    if($getBarcodeMt){
                      $upc = $getBarcodeMt[0]['UPC'];
                      $mpn = $getBarcodeMt[0]['MPN'];
                    }

                    $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
                    $path = $path->result_array();  	

                    $upc_mpn_master_path = $path[0]["MASTER_PATH"];

                    $mpn = str_replace("/","_",$mpn);
                foreach($conditions as $cond){
                    $dir = $upc_mpn_master_path.$upc."~".$mpn."/".$cond['COND_NAME']."/";
                    $dirWithMpn = $upc_mpn_master_path."~".$mpn."/".$cond['COND_NAME']."/";
                    $dirWithUpc = $upc_mpn_master_path.$upc."~/".$cond['COND_NAME']."/";
                    if (is_dir($dir)){
                        $dir = $dir;
                        break;
                    }else if(is_dir($dirWithMpn)){
                        $dir = $dirWithMpn;
                        break;
                    }else if(is_dir($dirWithUpc)){
                        $dir = $dirWithUpc;
                        break;
                    }else {
                        $dir = $upc_mpn_master_path."/".$cond['COND_NAME']."/";
                    }
                    
                }
                if($dir == $upc_mpn_master_path."~/".$cond['COND_NAME']."/"){
                        $dir = $upc_mpn_master_path."/".$cond['COND_NAME']."/";
                    }
                    
                  }
            $dir = preg_replace("/[\r\n]*/","",$dir);
            
            if (is_dir($dir)){
                $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
            
                if($images){
                    $j=0;
                foreach($images as $image){
                    
                    $withoutMasterPartUri = str_replace("D:/wamp/www/","",$image);
                    $withoutMasterPartUri = preg_replace("/[\r\n]*/","",$withoutMasterPartUri);
                    $uri[$bar][$j] = $base_url. $withoutMasterPartUri;
                    
                    $j++;
                }    
                }else{
                        $uri[$bar][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$bar][1] = false;
                    }
            }else{
                $uri[$bar][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$bar][1] = false;
            }
        }
	return array('uri'=>$uri);
    }

    public function del_audit_barcode(){

    $bar = $this->input->post('barcode_no');
    $insert_by = $this->input->post('userId');

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $audi_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET EBAY_STICKER = 1, AUDIT_DATETIME = $audi_date, AUDIT_BY = $insert_by WHERE BARCODE_NO = $bar");

    if($query){
      return array("delete"=>true, "message" => "Deleted Successfully!");
    }else{
      return array("delete"=>false, "message" => "Deleted Successfully!");
    }
  } 

        public function get_pictures($Products,$conditions){

            $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
            $path = $path->result_array();  	

            $master_path = $path[0]["MASTER_PATH"];
            $uri = array();
            $base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';
                foreach($Products as $product){

                    $upc = $product['UPC'];
                    $mpn = $product['MPN'];
                    $mpn = str_replace("/","_",$mpn);
                foreach($conditions as $cond){
                    $dir = $master_path.$upc."~".$mpn."/".$cond['COND_NAME']."/";
                    $dirWithMpn = $master_path."~".$mpn."/".$cond['COND_NAME']."/";
                    $dirWithUpc = $master_path.$upc."~/".$cond['COND_NAME']."/";
                    if (is_dir($dir)){
                        $dir = $dir;
                        break;
                    }else if(is_dir($dirWithMpn)){
                        $dir = $dirWithMpn;
                        break;
                    }else if(is_dir($dirWithUpc)){
                        $dir = $dirWithUpc;
                        break;
                    }else {
                        $dir = $master_path."/".$cond['COND_NAME']."/";
                    }
                    
                }
                if($dir == $master_path."~/".$cond['COND_NAME']."/"){
                        $dir = $master_path."/".$cond['COND_NAME']."/";
                    }
            $dir = preg_replace("/[\r\n]*/","",$dir);
            
            if (is_dir($dir)){
                $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
            
                if($images){
                    $j=0;
                foreach($images as $image){
                    
                    $withoutMasterPartUri = str_replace("D:/wamp/www/","",$image);
                    $withoutMasterPartUri = preg_replace("/[\r\n]*/","",$withoutMasterPartUri);
                    $uri[$product['BARCODE_NO']][$j] = $base_url. $withoutMasterPartUri;
                    // if($uri[$product['LZ_PRODUCT_ID']]){
                    //     break;
                    // }
                    
                    $j++;
                }    
                }else{
                        $uri[$product['BARCODE_NO']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$product['BARCODE_NO']][1] = false;
                    }
            }else{
                $uri[$product['BARCODE_NO']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$product['BARCODE_NO']][1] = false;
            }
        }
	return array('uri'=>$uri);
    }
    
}
?>	 