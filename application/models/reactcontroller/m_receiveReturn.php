<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_receiveReturn extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function getMerchants(){
        $merchants = $this->db->query("SELECT M.MERCHANT_ID, M.BUISNESS_NAME FROM LZ_MERCHANT_MT M")->result_array();   
        if($merchants){
            return array("found"=>true, "merchants" => $merchants);
        }else{
            return array("found"=>false, "message" => "No Data Found");
        }
    }
    public function scanBin(){
        $scanBin = $this->input->post("scanBin");

        $bins = $this->db->query("SELECT *
                                FROM (SELECT BM.BIN_ID, BM.BIN_TYPE || '-' || BM.BIN_NO BIN_NO FROM BIN_MT BM)
                                WHERE BIN_NO = '$scanBin'
                                ")->result_array();   
        if($bins){
            return array("found"=>true,"message" => "Bin Found", "bins" => $bins);
        }else{
            return array("found"=>false, "message" => "No Data Found");
        }
    }
    public function scanBarcodeShipment(){
        $scanBar   = $this->input->post("scanBar");
        $merchant  = $this->input->post("merchant");
        $userId    = $this->input->post("userId");
        $return_id = $this->input->post("inventry_return_mt_id");

        $barcodes = $this->db->query("SELECT DT.DT_ID, DT.BARCODE_NO, DT.ADMIN_STATUS, DT.BIN_ID
                                    FROM LZ_MERCHANT_BARCODE_MT MT,
                                        LZ_MERCHANT_BARCODE_DT DT
                                    WHERE MT.MT_ID = DT.MT_ID
                                    AND  DT.DISCARD_COND IS NULL
                                    AND MT.MERCHANT_ID = $merchant
                                    AND DT.BARCODE_NO = $scanBar
                                    AND DT.ADMIN_STATUS = 3
                                    ORDER BY DT.BARCODE_NO DESC")->result_array();
        $query = "SELECT DT.DT_ID,
       ('W' || WM.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-' || 'R' || RA.ROW_NO || '-' || BIN.BIN_TYPE || '-' || BIN.BIN_NO) LOCATION,
       DT.BARCODE_NO,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.NOTIFICATION,
       DT.ADMIN_STATUS,
       EM.FIRST_NAME STATUS_BY,
       LOT.CARD_UPC UPC,
       LOT.CARD_MPN MPN,
       LOT.MPN_DESCRIPTION,
       LOT.BRAND,
       CN.COND_NAME CONDITION,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          'eBAY ID:' || BM.EBAY_ITEM_ID
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          'NOT LISTED'
       END) LISTED_YN,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          1
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          0
       END) LISTED_STATUS
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_ITEM_COND_MT        CN,
       EMPLOYEE_MT            EM,
       BIN_MT                 BIN,
       LZ_RACK_ROWS           RA,
       RACK_MT                RAC,
       WAREHOUSE_MT           WM,
       LJ_INVENTRY_RETURN_DT_TMP TMP
 WHERE MT.MT_ID = DT.MT_ID 
   AND DT.BARCODE_NO = TMP.BARCODE_NO
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO
   AND EM.EMPLOYEE_ID(+) = DT.STATUS_BY
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND CN.ID = LOT.CONDITION_ID
   AND BM.SALE_RECORD_NO IS NULL
   AND (LOT.CONDITION_ID != -1 OR DT.DISCARD_COND IS NULL)
   AND MT.MERCHANT_ID = $merchant
   AND DT.ADMIN_STATUS = 3
   AND NVL(LOT.BIN_ID,0) =  BIN.BIN_ID
   AND RA.RACK_ROW_ID = BIN.CURRENT_RACK_ROW_ID
   AND RAC.RACK_ID = RA.RACK_ID
   AND WM.WAREHOUSE_ID = RAC.WAREHOUSE_ID
   ORDER BY DT.BARCODE_NO DESC";

        if($barcodes){
            $alreadyExist = $this->db->query("SELECT * FROM LJ_INVENTRY_RETURN_DT_TMP WHERE BARCODE_NO = $scanBar")->result_array();
            if($alreadyExist){
                return array("found"=>false, "message" => "Barcode Already Exist!");
            }
            $previousExist = $this->db->query("SELECT * FROM LJ_INVENTRY_RETURN_DT WHERE BARCODE_NO = $scanBar")->result_array();
            if($previousExist){
                return array("found"=>false, "message" => "Barcode Already Exist!");
            }

            $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

            $barcode = $barcodes[0]['BARCODE_NO'];
            $return_pk = "";
            if($return_id){
            $this->db->query("INSERT INTO LJ_INVENTRY_RETURN_DT_TMP (RETURN_TMP_ID, BARCODE_NO, INSERTED_DATE, INSERTED_BY, INVENTRY_RETURN_MT_ID) 
            VALUES (GET_SINGLE_PRIMARY_KEY('LJ_INVENTRY_RETURN_DT_TMP','RETURN_TMP_ID'), $barcode, $insert_date, $userId, $return_id)");
            $return_pk = $return_id;
            }else{
            $return_id_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_INVENTRY_RETURN_MT','INVENTRY_RETURN_MT_ID') ID FROM DUAL")->result_array();
            $return_id_pk =  $return_id_pk[0]['ID'];
            $return_pk = $return_id_pk;

            $this->db->query("INSERT INTO LJ_INVENTRY_RETURN_MT (INVENTRY_RETURN_MT_ID, MERCHANT_ID, CREATED_DATE, CREATED_BY ) 
            VALUES ($return_id_pk, $merchant, $insert_date, $userId)");
            
            $this->db->query("INSERT INTO LJ_INVENTRY_RETURN_DT_TMP (RETURN_TMP_ID, BARCODE_NO, INSERTED_DATE, INSERTED_BY, INVENTRY_RETURN_MT_ID ) 
            VALUES (GET_SINGLE_PRIMARY_KEY('LJ_INVENTRY_RETURN_DT_TMP','RETURN_TMP_ID'), $barcode, $insert_date, $userId, $return_id_pk)");
            }
            $barcodes = $this->db->query($query)->result_array();

            return array("found"=>true, "message" => "Barcode Added", "return_pk" => $return_pk, "barcodes" => $barcodes);
        }else{
            return array("found"=>false, "message" => "No Data Found");
        }
    }
    public function createBoxBtn(){
        $merchant   = $this->input->post("merchant");
        $carrier    = $this->input->post("carrier");
        $trackingNo = $this->input->post("trackingNo");
        $inventry_return_mt_id = $this->input->post("inventry_return_mt_id");

        $records = $this->db->query("SELECT * FROM LJ_INVENTRY_RETURN_DT_TMP WHERE INVENTRY_RETURN_MT_ID = $inventry_return_mt_id");

        // foreach($records as $values){

            

        // }

    }
    public function scanBarcode(){
        $scanBar  = $this->input->post("scanBar");
        $bin_id   = $this->input->post("bin_id");
        $merchant = $this->input->post("merchant");
        $userId   = $this->input->post("userId");

        $barcodes = $this->db->query("SELECT DT.DT_ID, DT.BARCODE_NO, DT.ADMIN_STATUS, DT.BIN_ID
                                    FROM LZ_MERCHANT_BARCODE_MT MT,
                                        LZ_MERCHANT_BARCODE_DT DT
                                    WHERE MT.MT_ID = DT.MT_ID
                                    AND  DT.DISCARD_COND IS NULL
                                    AND MT.MERCHANT_ID = $merchant
                                    AND DT.BARCODE_NO = $scanBar
                                    AND (DT.ADMIN_STATUS = 2 OR DT.ADMIN_STATUS = 3)
                                    ORDER BY DT.BARCODE_NO DESC")->result_array();   

        $special_lot = $this->db->query("SELECT LOT.SPECIAL_LOT_ID, LOT.BARCODE_PRV_NO
                                        FROM LZ_MERCHANT_BARCODE_MT MT,
                                            LZ_MERCHANT_BARCODE_DT DT,
                                            LZ_SPECIAL_LOTS        LOT
                                        WHERE MT.MT_ID = DT.MT_ID
                                        AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO
                                        AND (LOT.CONDITION_ID != -1 OR DT.DISCARD_COND IS NULL)
                                        AND MT.MERCHANT_ID = $merchant
                                        AND LOT.BARCODE_PRV_NO = $scanBar
                                        AND (DT.ADMIN_STATUS = 2 OR DT.ADMIN_STATUS = 3)
                                        ORDER BY DT.BARCODE_NO DESC")->result_array();   
        
        if($barcodes){
            $bar_codes = $barcodes[0]['BARCODE_NO'];
            $current_bin_id = $barcodes[0]['BIN_ID'];
            $scan_bin = $bin_id;

            $this->update_loc($bar_codes,$current_bin_id,$scan_bin,$userId);

            $dt_id  = $barcodes[0]['DT_ID'];
            $lot_id = $special_lot[0]['SPECIAL_LOT_ID'];
            $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET ADMIN_STATUS = 3, BIN_ID = $bin_id WHERE DT_ID = $dt_id");
            $this->db->query("UPDATE LZ_SPECIAL_LOTS LT SET BIN_ID = $bin_id WHERE SPECIAL_LOT_ID = $lot_id");
            $this->db->query("UPDATE LZ_BARCODE_MT BM SET BM.BIN_ID = $bin_id WHERE BARCODE_NO = $scanBar");

            return array("update"=>true, "message" => "Process Complete", "barcodes" => $barcodes);
        }else{
            return array("update"=>false, "message" => "No Data Found");
        }
    }
    public function update_loc($bar_codes,$current_bin_id,$scan_bin,$userId){
    
     $scan_bin= trim($scan_bin);
     $scan_bin = str_replace("  ", " ", $scan_bin);
     $scan_bin = str_replace("'", "''", $scan_bin);
     $scan_bin = strtoupper($scan_bin);

    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $transfer_by_id = $userId;

    $bindId = $this->db->query(" SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$scan_bin' ")->result_array();
   
   
    if(count($bindId) > 0) {
       $bin_id = $bindId[0]['BIN_ID'];
      
      $bar = $bar_codes;
      $old_bin_id = $current_bin_id;

      $this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = '$bin_id' WHERE BARCODE_NO = $bar");

      $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL");
      $rs = $qry->result_array();
      $loc_trans_id = $rs[0]['ID'];

      $updateBin = $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS) VALUES($loc_trans_id, $transfer_date, $bar, $transfer_by_id, $bin_id, $old_bin_id, 'null')");
      
      return 1; // added sucess
     } else{

      return 2; // bin is incorrect
     } 

}
    public function getReturnRequests(){
        $merch_id = $this->input->post("merchantId");

        $requests = $this->db->query("SELECT DT.DT_ID,
       ('W' || WM.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-' || 'R' || RA.ROW_NO || '-' || BIN.BIN_TYPE || '-' || BIN.BIN_NO) LOCATION,
       DT.BARCODE_NO,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.NOTIFICATION,
       DT.ADMIN_STATUS,
       EM.FIRST_NAME STATUS_BY,
       LOT.CARD_UPC UPC,
       LOT.CARD_MPN MPN,
       LOT.MPN_DESCRIPTION,
       LOT.BRAND,
       CN.COND_NAME CONDITION,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          'eBAY ID:' || BM.EBAY_ITEM_ID
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          'NOT LISTED'
       END) LISTED_YN,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          1
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          0
       END) LISTED_STATUS
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_ITEM_COND_MT        CN,
       EMPLOYEE_MT            EM,
       BIN_MT                 BIN,
       LZ_RACK_ROWS           RA,
       RACK_MT                RAC,
       WAREHOUSE_MT           WM
 WHERE MT.MT_ID = DT.MT_ID
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO
   AND EM.EMPLOYEE_ID(+) = DT.STATUS_BY
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND CN.ID = LOT.CONDITION_ID
   AND BM.SALE_RECORD_NO IS NULL
   AND (LOT.CONDITION_ID != -1 OR DT.DISCARD_COND IS NULL)
   AND MT.MERCHANT_ID = $merch_id
   AND (DT.ADMIN_STATUS = 2 OR DT.ADMIN_STATUS = 3)
   AND NVL(LOT.BIN_ID,0) =  BIN.BIN_ID
   AND RA.RACK_ROW_ID = BIN.CURRENT_RACK_ROW_ID
   AND RAC.RACK_ID = RA.RACK_ID
   AND WM.WAREHOUSE_ID = RAC.WAREHOUSE_ID
   ORDER BY DT.BARCODE_NO DESC
")->result_array();   
        if($requests){
            return array("found"=>true, "requests" => $requests);
        }else{
            return array("found"=>false, "message" => "No Data Found");
        }
    }
    public function processComplete(){
        $merch_id = $this->input->post("merchantId");

        $requests = $this->db->query("SELECT DT.DT_ID,
       ('W' || WM.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-' || 'R' || RA.ROW_NO || '-' || BIN.BIN_TYPE || '-' || BIN.BIN_NO) LOCATION,
       DT.BARCODE_NO,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.NOTIFICATION,
       DT.ADMIN_STATUS,
       EM.FIRST_NAME STATUS_BY,
       LOT.CARD_UPC UPC,
       LOT.CARD_MPN MPN,
       LOT.MPN_DESCRIPTION,
       LOT.BRAND,
       CN.COND_NAME CONDITION,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          'eBAY ID:' || BM.EBAY_ITEM_ID
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          'NOT LISTED'
       END) LISTED_YN,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          1
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          0
       END) LISTED_STATUS
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_ITEM_COND_MT        CN,
       EMPLOYEE_MT            EM,
       BIN_MT                 BIN,
       LZ_RACK_ROWS           RA,
       RACK_MT                RAC,
       WAREHOUSE_MT           WM
 WHERE MT.MT_ID = DT.MT_ID
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO
   AND EM.EMPLOYEE_ID(+) = DT.STATUS_BY
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND CN.ID = LOT.CONDITION_ID
   AND BM.SALE_RECORD_NO IS NULL
   AND (LOT.CONDITION_ID != -1 OR DT.DISCARD_COND IS NULL)
   AND MT.MERCHANT_ID = $merch_id
   AND DT.ADMIN_STATUS = 3
   AND NVL(LOT.BIN_ID,0) =  BIN.BIN_ID
   AND RA.RACK_ROW_ID = BIN.CURRENT_RACK_ROW_ID
   AND RAC.RACK_ID = RA.RACK_ID
   AND WM.WAREHOUSE_ID = RAC.WAREHOUSE_ID
   ORDER BY DT.BARCODE_NO DESC
")->result_array();   
        if($requests){
            return array("found"=>true, "requests" => $requests);
        }else{
            return array("found"=>false, "message" => "No Data Found");
        }
    }
    public function getReceiveRequests(){
        $merch_id = $this->input->post("merch_id");

        $receiveRequests = $this->db->query("SELECT *
  FROM (SELECT ME.MERCHANT_ID,
               ME.BUISNESS_NAME,
               (SELECT COUNT(DT.BARCODE_STATUS)
                  FROM LZ_MERCHANT_BARCODE_MT MT, LZ_MERCHANT_BARCODE_DT DT
                 WHERE MT.MT_ID = DT.MT_ID
                   AND MT.MERCHANT_ID = ME.MERCHANT_ID
                   AND DT.BARCODE_STATUS = 1
                   AND DT.ADMIN_STATUS = 0) RETURN_REQUEST,
               (SELECT COUNT(DT.BARCODE_STATUS)
                  FROM LZ_MERCHANT_BARCODE_MT MT, LZ_MERCHANT_BARCODE_DT DT
                 WHERE MT.MT_ID = DT.MT_ID
                   AND MT.MERCHANT_ID = ME.MERCHANT_ID
                   AND DT.BARCODE_STATUS = 2
                   AND DT.ADMIN_STATUS = 0) JUNK_REQUEST,
                                      (SELECT COUNT(DT.BARCODE_STATUS)
                  FROM LZ_MERCHANT_BARCODE_MT MT, LZ_MERCHANT_BARCODE_DT DT
                 WHERE MT.MT_ID = DT.MT_ID
                   AND MT.MERCHANT_ID = ME.MERCHANT_ID
                   AND DT.BARCODE_STATUS = 1
                   AND DT.ADMIN_STATUS = 1) TOTAL_RETURN,
                    (SELECT COUNT(DT.BARCODE_STATUS)
                  FROM LZ_MERCHANT_BARCODE_MT MT, LZ_MERCHANT_BARCODE_DT DT
                 WHERE MT.MT_ID = DT.MT_ID
                   AND MT.MERCHANT_ID = ME.MERCHANT_ID
                   AND DT.BARCODE_STATUS = 2
                   AND DT.ADMIN_STATUS = 0) TOTAL_JUNK
          FROM LZ_MERCHANT_MT ME
         ORDER BY RETURN_REQUEST DESC)
 WHERE (RETURN_REQUEST > 0 OR JUNK_REQUEST > 0)")->result_array();

   if($receiveRequests){
    return array("found" => true, "allRequests" => $receiveRequests);
   }else{
    return array("found" => false, "message", "No Requests Received");
   }
    }
    public function approveAdmin(){
        $dt_id  = $this->input->post("dt_id");
        $userId = $this->input->post("userId");
        
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.ADMIN_STATUS = 1, DT.STATUS_DATE = $insert_date, DT.STATUS_BY = $userId, NOTIFICATION = 0 WHERE DT.DT_iD = $dt_id ");

        $message = "Request Approved";
        if($update){
            return array( "update" => true, "message" => $message);
        }else{
            return array( "update" => true, "message" => "Something Went Wrong!");
        }
    }
    public function cancelRequest(){
        $dt_id  = $this->input->post("dt_id");
        $userId = $this->input->post("userId");
        
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.ADMIN_STATUS = 0, DT.STATUS_DATE = $insert_date, DT.STATUS_BY = $userId, NOTIFICATION = 0 WHERE DT.DT_iD = $dt_id ");

        $message = "Request Canceled";
        if($update){
            return array( "update" => true, "message" => $message);
        }else{
            return array( "update" => true, "message" => "Something Went Wrong!");
        }
    }
    public function processRequest(){
        $dt_id  = $this->input->post("dt_id");
        $userId = $this->input->post("userId");
        
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.ADMIN_STATUS = 2, DT.STATUS_DATE = $insert_date, DT.STATUS_BY = $userId, NOTIFICATION = 0 WHERE DT.DT_iD = $dt_id ");

        $message = "Request Proccessed";
        if($update){
            return array( "update" => true, "message" => $message);
        }else{
            return array( "update" => true, "message" => "Something Went Wrong!");
        }
    }
    public function getReturns(){
        $getReturns = $this->db->query("SELECT DT.DT_ID,
       DT.DT_ID IMAGE,
       DT.BARCODE_NO,
       DT.BARCODE_STATUS,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.STATUS_BY,
       DT.ADMIN_STATUS,
       DT.REMARKS,
       (SELECT COUNT(DT.BARCODE_STATUS)
        FROM LZ_MERCHANT_BARCODE_MT ME, LZ_MERCHANT_BARCODE_DT DT
        WHERE ME.MT_ID = DT.MT_ID
        AND ME.MERCHANT_ID = MT.MERCHANT_ID
        AND DT.BARCODE_STATUS = 1) RETURN_REQUEST,
        (SELECT COUNT(DT.BARCODE_STATUS)
        FROM LZ_MERCHANT_BARCODE_MT ME, LZ_MERCHANT_BARCODE_DT DT
        WHERE ME.MT_ID = DT.MT_ID
        AND ME.MERCHANT_ID = MT.MERCHANT_ID
        AND DT.BARCODE_STATUS = 2) JUNK_REQUEST,
       EM.FIRST_NAME STATUS_BY,
       LOT.CARD_UPC UPC,
       LOT.CARD_MPN MPN,
       LOT.MPN_DESCRIPTION,
       LOT.BRAND,
       CN.COND_NAME CONDITION,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          'eBAY ID:' || BM.EBAY_ITEM_ID
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          'NOT LISTED'
       END) LISTED_YN,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          1
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          0
       END) LISTED_STATUS
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_ITEM_COND_MT        CN,
       EMPLOYEE_MT            EM
 WHERE MT.MT_ID = DT.MT_ID
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO
   AND EM.EMPLOYEE_ID(+) = DT.STATUS_BY
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND CN.ID = LOT.CONDITION_ID
   AND BM.SALE_RECORD_NO IS NULL
   AND (LOT.CONDITION_ID != -1 OR DT.DISCARD_COND IS NULL)
   AND DT.BARCODE_STATUS = 1
   AND DT.ADMIN_STATUS = 1
   ORDER BY DT.BARCODE_NO DESC
")->result_array();

    if($getReturns){
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($getReturns,$conditions);
        $images = $uri['uri'];
        
        return array("found"=> true, "getReturns" => $getReturns, "images" => $images);
   }else{
    return array("found" => false, "message", "No Returns Found");
   }
    }
    public function getJunks(){
        $getReturns = $this->db->query("SELECT DT.DT_ID,
       DT.DT_ID IMAGE,
       DT.BARCODE_NO,
       DT.BARCODE_STATUS,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.STATUS_BY,
       DT.ADMIN_STATUS,
       DT.REMARKS,
       (SELECT COUNT(DT.BARCODE_STATUS)
        FROM LZ_MERCHANT_BARCODE_MT ME, LZ_MERCHANT_BARCODE_DT DT
        WHERE ME.MT_ID = DT.MT_ID
        AND ME.MERCHANT_ID = MT.MERCHANT_ID
        AND DT.BARCODE_STATUS = 1) RETURN_REQUEST,
        (SELECT COUNT(DT.BARCODE_STATUS)
        FROM LZ_MERCHANT_BARCODE_MT ME, LZ_MERCHANT_BARCODE_DT DT
        WHERE ME.MT_ID = DT.MT_ID
        AND ME.MERCHANT_ID = MT.MERCHANT_ID
        AND DT.BARCODE_STATUS = 2) JUNK_REQUEST,
       EM.FIRST_NAME STATUS_BY,
       LOT.CARD_UPC UPC,
       LOT.CARD_MPN MPN,
       LOT.MPN_DESCRIPTION,
       LOT.BRAND,
       CN.COND_NAME CONDITION,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          'eBAY ID:' || BM.EBAY_ITEM_ID
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          'NOT LISTED'
       END) LISTED_YN,
       (CASE
         WHEN BM.EBAY_ITEM_ID IS NOT NULL THEN
          1
         WHEN BM.EBAY_ITEM_ID IS NULL THEN
          0
       END) LISTED_STATUS
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_BARCODE_MT          BM,
       LZ_SPECIAL_LOTS        LOT,
       LZ_ITEM_COND_MT        CN,
       EMPLOYEE_MT            EM
 WHERE MT.MT_ID = DT.MT_ID
   AND DT.BARCODE_NO = LOT.BARCODE_PRV_NO
   AND EM.EMPLOYEE_ID(+) = DT.STATUS_BY
   AND DT.BARCODE_NO = BM.BARCODE_NO(+)
   AND CN.ID = LOT.CONDITION_ID
   AND BM.SALE_RECORD_NO IS NULL
   AND (LOT.CONDITION_ID != -1 OR DT.DISCARD_COND IS NULL)
   AND DT.BARCODE_STATUS = 2
   AND DT.ADMIN_STATUS = 1
   ORDER BY DT.BARCODE_NO DESC
")->result_array();

    if($getReturns){
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($getReturns,$conditions);
        $images = $uri['uri'];
        
        return array("found"=> true, "getReturns" => $getReturns, "images" => $images);
   }else{
    return array("found" => false, "message", "No Returns Found");
   }
    }
    public function getNotListedItems(){
        $merch_id = $this->input->post("merch_id");
        
        $notlisted = $this->db->query("SELECT DT.DT_ID,
        DT.DT_ID IMAGE,
DT.BARCODE_NO,
DT.BARCODE_STATUS,
DT.ADMIN_STATUS,
DT.REMARKS,
DT.STATUS_DATE,
DT.STATUS_BY,
LT.CARD_UPC UPC,
LT.CARD_MPN MPN,
LT.BRAND,
LT.MPN_DESCRIPTION,
CN.COND_NAME
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_SPECIAL_LOTS        LT,
       LZ_BARCODE_MT          BM,
       LZ_ITEM_COND_MT        CN
 WHERE MT.MT_ID = DT.MT_ID
   AND CN.ID = LT.CONDITION_ID
   AND DT.BARCODE_NO = LT.BARCODE_PRV_NO(+)
   AND BM.BARCODE_NO(+) = DT.BARCODE_NO
   AND MT.MERCHANT_ID = $merch_id
   AND BM.EBAY_ITEM_ID IS NULL
   AND DT.ADMIN_STATUS != 1
   AND (DT.BARCODE_STATUS = 1 OR DT.BARCODE_STATUS = 2)")->result_array();

    if($notlisted){
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($notlisted,$conditions);
        $images2 = $uri['uri'];
        
        return array("found"=> true,"notlisted" => $notlisted, "images2" => $images2);
   }else{
    return array("found" => false, "message", "No Requests Received");
   }
    }
    public function getBarcodesByEbayId(){
        $merch_id = $this->input->post("merch_id");
        $ebay_id  = $this->input->post("ebay_id");
        
        $ebayBarcodes = $this->db->query("SELECT BM.EBAY_ITEM_ID DT_ID,
BM.ITEM_ID,
BM.BARCODE_NO,
LT.CARD_UPC UPC,
LT.CARD_MPN MPN,
LT.BRAND,
LT.MPN_DESCRIPTION,
CN.COND_NAME
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_SPECIAL_LOTS        LT,
       LZ_BARCODE_MT          BM,
       LZ_ITEM_COND_MT        CN
 WHERE MT.MT_ID = DT.MT_ID
   AND CN.ID = LT.CONDITION_ID
   AND DT.BARCODE_NO = LT.BARCODE_PRV_NO
   AND BM.BARCODE_NO = DT.BARCODE_NO
   AND MT.MERCHANT_ID = $merch_id
   AND BM.EBAY_ITEM_ID = $ebay_id
   AND (DT.BARCODE_STATUS = 1 OR DT.BARCODE_STATUS = 2)
   AND DT.ADMIN_STATUS != 1
   AND BM.SALE_RECORD_NO IS NULL")->result_array();


        if($ebayBarcodes){
        return array("found"=> true,"ebayBarcodes" => $ebayBarcodes);
   }else{
    return array("found" => false, "message", "No Requests Received");
   }
    }
    public function getListedItems(){
        $merch_id = $this->input->post("merch_id");

        $listed = $this->db->query("SELECT BM.EBAY_ITEM_ID DT_ID,
max(BM.ITEM_ID) ITEM_ID,
MAX(LT.CARD_UPC) UPC,
MAX(LT.CARD_MPN) MPN,
MAX(LT.BRAND) BRAND,
MAX(CN.COND_NAME) CONDITION,
MAX(LT.MPN_DESCRIPTION) MPN_DESCRIPTION
  FROM LZ_MERCHANT_BARCODE_MT MT,
       LZ_MERCHANT_BARCODE_DT DT,
       LZ_SPECIAL_LOTS        LT,
       LZ_BARCODE_MT          BM,
       LZ_ITEM_COND_MT        CN
 WHERE MT.MT_ID = DT.MT_ID
   AND CN.ID = LT.CONDITION_ID
   AND DT.BARCODE_NO = LT.BARCODE_PRV_NO
   AND BM.BARCODE_NO = DT.BARCODE_NO
   AND MT.MERCHANT_ID = $merch_id
   AND BM.EBAY_ITEM_ID IS NOT NULL
   AND (DT.BARCODE_STATUS = 1 OR DT.BARCODE_STATUS = 2)
   GROUP BY BM.EBAY_ITEM_ID
   ORDER BY BM.EBAY_ITEM_ID")->result_array();

   if($listed){
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($listed,$conditions);
        $images = $uri['uri'];
        
        return array("found"=> true, "listed" => $listed, "images" => $images);
   }else{
    return array("found" => false, "message", "No Requests Received");
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
                    $uri[$product['DT_ID']][$j] = $base_url. $withoutMasterPartUri;
                    
                    $j++;
                }    
                }else{
                        $uri[$product['DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$product['DT_ID']][1] = false;
                    }
            }else{
                $uri[$product['DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                $uri[$product['DT_ID']][1] = false;
            }
        }
	return array('uri'=>$uri);
    }
    
}
?>	