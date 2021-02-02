<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_android_order_pulling extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }
  public function getMerchants()
  {
        $get_mer = $this->db->query("SELECT MM.MERCHANT_ID,MM.CONTACT_PERSON FROM LZ_MERCHANT_MT MM ORDER BY MM.MERCHANT_ID DESC"); 
    
      if ($get_mer->num_rows() > 0) {
          $result = array("status" => true, "message" => "Reacord Found","merchantData" => $get_mer->result_array());
      } else {
            $result = array("status" => false, "message" => "No Reacord Found","merchantData" => $get_mer->result_array());
      }
      return $result;
  }
  public function getSignInResult(){
    if (isset($_POST['username']) && isset($_POST['password']))
    {

      $username = $_POST['username'];
      $password = $_POST['password'];
      $response= array();
      $main_query = "SELECT M.EMPLOYEE_ID,
      (M.FIRST_NAME || ' ' || M.LAST_NAME) NAME,
      M.USER_NAME,
      M.PASS_WORD,
      MR.ROLE_NAME,
      M.ROLE_ID,
      CASE
        WHEN (SELECT EMD.MERCHANT_ID
                FROM EMP_MERCHANT_DET EMD
               WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID) IS NULL THEN
         0
        ELSE
         (SELECT EMD.MERCHANT_ID
            FROM EMP_MERCHANT_DET EMD
           WHERE EMD.EMPLOYEE_ID = M.EMPLOYEE_ID)
      END MERCHANT_ID
 FROM EMPLOYEE_MT M, EMPLOYEE_ROLE MR
WHERE M.ROLE_ID = MR.ROLE_ID
AND M.USER_NAME ='$username' 
AND M.PASS_WORD ='$password' ";
      $row = $this->db->query($main_query)->result_array();
      if (count($row) > 0)
      {
         return array("error"=>false,"message"=>"Login Successfully!","login_data"=>$row[0]);
      }
      else
      {
         return array("error"=>true,"message"=>"Wrong Cradentials!");
      }
      
     }
    else 
   {
      return array("error"=>true,"message"=>"Empty Paraeters!");
    }
  }
  public function getAllDataCombined(){
    $data["error"]=false;
    $data["merchants"]=$this->getMerchants()["merchantData"];
    $data["awaitingOrders"]=$this->getAwaitingOrders()["data"];
  
    return $data;
  }
  public function getAwaitingOrders(){
    $main_query = "SELECT DECODE(L.FOLDER_NAME,
    NULL,
    DECODE(DD.FOLDER_NAME,
           NULL,
           'master_pictures/' || TRIM(I.ITEM_MT_UPC) || '~' ||
           TRIM(I.ITEM_MT_MFG_PART_NO) || '/' || TRIM(CC.COND_NAME),
           'dekitted_pictures/' || DD.FOLDER_NAME),
    'dekitted_pictures/' || L.FOLDER_NAME) IMAGE,
'master_pictures/' || TRIM(I.ITEM_MT_UPC) || '~' ||
TRIM(I.ITEM_MT_MFG_PART_NO) || '/' || TRIM(CC.COND_NAME) FOL_NAME1,
GET.*
FROM (SELECT SDD.MERCHANT_ID,
     SDD.BARCODE_NO BARCODEARRAY,
     SDD.BARCODE_NO DEF_BARCODE,
     SDD.WAREHOUSE_NO,
     TO_CHAR(SDD.SALE_DATE, 'MM/DD/YYYY HH24:MI:SS') SALE_DATE,
     SDD.USER_ID USER_ID,
     SDD.QUANTITY,
     SDD.ITEM_TITLE,
     SDD.ITM_ID,
     SDD.ORDER_NUM SALENO,
     SDD.ITEM_ID EBAYID,
     SDD.BIN_LOCATION,
     SDD.BIN_LOCATION_WAREHOUSE,
     SDD.LZ_SELLER_ACCT_ID SELLER_ACCT,
     0 PACK_WEIGHT,
     DECODE(WS.MACHINE_INPUT_YN, NULL, 0, WS.MACHINE_INPUT_YN) MACHINE_INPUT_YN,
     SDD.SHIPPING_SERVICE,
     SDD.PULLING_ID,
     SDD.CONDITION_ID,
     SDD.EBAY_STATUS,
     SDD.BUISNESS_NAME MERCHANT_NAME,
     SDD.ACCOUNT_NAME,
     SDD.ORDER_ID,
     SDD.SALES_RECORD_NO_GROUP GROUP_SALENO,
     SDD.EXTENDEDORDERID,
     SDD.PAID_ON_DATE
FROM (SELECT SD.ITEM_ID,
             B.BIN_ID,
             SD.SALES_RECORD_NUMBER ORDER_NUM,
             SD.ITEM_TITLE,
             SD.USER_ID,
             SD.TRANSACTION_ID,
             LD.MERCHANT_ID,
             SD.SALE_DATE,
             B.LZ_MANIFEST_ID,
             IM.ITEM_CODE,
             SP.PULLER_NAME,
             SP.PULLING_DATE,
             IM.ITEM_MT_MFG_PART_NO MPN,
             IM.ITEM_MT_UPC UPC,
             C.COND_NAME,
             SD.QUANTITY,
             SD.TOTAL_PRICE,
             SD.SHIPPING_SERVICE,
             SD.STAMPS_SHIPPING_RATE,
             SM.LZ_SELLER_ACCT_ID,
             NVL(SP.PULLING_QTY, 0) PULLING_QTY,
             NVL(SP.CANCEL_QTY, 0) CANCEL_QTY,
             B.BARCODE_NO,
             B.ITEM_ID ITM_ID,
             WA.WAREHOUSE_NO,
             B.CONDITION_ID,
             B.PULLING_ID,
             LM.BUISNESS_NAME,
             LD.ACCOUNT_NAME,
             SD.ORDERSTATUS EBAY_STATUS,
             SD.ORDER_ID,
             SD.SALES_RECORD_NO_GROUP,
             SD.EXTENDEDORDERID,
             SD.PAID_ON_DATE,
             DECODE(BI.BIN_ID,
                    0,
                    'NO BIN',
                    'W' || WA.WAREHOUSE_NO) BIN_LOCATION_WAREHOUSE,
             DECODE(BI.BIN_ID,
                    0,
                    'NO BIN',
                    'W' || WA.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-R' ||
                    RO.ROW_NO || '-' || BI.BIN_TYPE || '-' ||
                    BI.BIN_NO) BIN_LOCATION
        FROM LZ_SALESLOAD_DET SD,
             LZ_BARCODE_MT B,
             LJ_BIN_VERIFY_DT VF,
             LZ_AWAITING_SHIPMENT AW,
             BIN_MT BI,
             LZ_RACK_ROWS RO,
             RACK_MT RAC,
             LZ_ITEM_COND_MT C,
             WAREHOUSE_MT WA,
             ITEMS_MT IM,
             LZ_SALESLOAD_MT SM,
             LJ_MERHCANT_ACC_DT LD,
             LZ_MERCHANT_MT LM,
             (SELECT P.SALES_RECORD_NO,
                     P.EBAY_ITEM_ID,
                     MAX(PULLER_NAME) PULLER_NAME,
                     TO_CHAR(MAX(PULLING_DATE),
                             'YYYY-MM-DD HH24:MI:SS') PULLING_DATE,
                     SUM(NVL(PULLING_QTY, 0)) PULLING_QTY,
                     SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY
                FROM LZ_SALES_PULLING P
               GROUP BY P.SALES_RECORD_NO, P.EBAY_ITEM_ID) SP
       WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO(+)
         AND SD.ITEM_ID = SP.EBAY_ITEM_ID(+)
         AND SD.SALES_RECORD_NUMBER = B.SALE_RECORD_NO(+)
         AND SD.ITEM_ID = B.EBAY_ITEM_ID
         AND VF.BARCODE_NO(+) = B.BARCODE_NO
         AND SD.SALES_RECORD_NUMBER = TO_CHAR(AW.SALERECORDID)
         AND SD.LZ_SALELOAD_ID = SM.LZ_SALELOAD_ID
         AND SM.LZ_SELLER_ACCT_ID = LD.ACCT_ID
         AND LD.MERCHANT_ID = LM.MERCHANT_ID
         AND B.BIN_ID = BI.BIN_ID(+)
         AND BI.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+)
         AND RO.RACK_ID = RAC.RACK_ID(+)
         AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID(+)
         AND B.CONDITION_ID = C.ID(+)
         AND IM.ITEM_ID = B.ITEM_ID
         AND SD.ITEM_ID = B.EBAY_ITEM_ID
         AND B.PULLING_ID IS NULL
         AND SD.UK_FIREBASE_WAITING IS NULL
         AND B.ITEM_ADJ_DET_ID_FOR_OUT IS NULL
         AND B.LZ_PART_ISSUE_MT_ID IS NULL
         AND B.LZ_POS_MT_ID IS NULL
         AND SD.GNRTD_DC_ID IS NULL
         AND SD.TRACKING_NUMBER IS NULL) SDD,
     (SELECT DISTINCT W.ITEM_ID,
                      W.PACK_WEIGHT,
                      W.SHIPPING_SERVICE,
                      W.MACHINE_INPUT_YN
        FROM LZ_ITEM_PACK_WEIGHT W) WS
WHERE NVL(SDD.QUANTITY, 0) <>
     (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0))
 AND SDD.ITM_ID = WS.ITEM_ID(+)
 AND SDD.BARCODE_NO IS NOT NULL) GET,
LZ_SPECIAL_LOTS L,
ITEMS_MT I,
LZ_DEKIT_US_DT DD,
LZ_ITEM_COND_MT CC
WHERE DEF_BARCODE = L.BARCODE_PRV_NO(+)
AND DEF_BARCODE = DD.BARCODE_PRV_NO(+)
AND GET.CONDITION_ID = CC.ID(+)
AND ITM_ID = I.ITEM_ID
AND GET.EBAY_STATUS = 'Completed'
ORDER BY GET.PAID_ON_DATE ASC ";
                         $data = $this->db->query($main_query)->result_array();

                       /*=====  End of copy from m_notification  ======*/
                       if(count($data) > 0 ){
                           $pic_path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 7")->result_array();;
                           $master_path = $pic_path[0]['MASTER_PATH'];
                           for($i = 0; $i < count($data);$i++){  
                               $d_dir = $master_path;
                               $s_dir = $master_path;
                                $folder = $data[$i]["IMAGE"];
                               $folder1 = $data[$i]["FOL_NAME1"];
                               $d_dir = @$d_dir.@$folder.'/thumb/';
                               $s_dir = @$s_dir.@$folder1.'/thumb/';
                               
                                    


                                    if(is_dir(@$d_dir)){
                                       // var_dump($d_dir);
                                        $iterator = new \FilesystemIterator(@$d_dir);
                                          if(@$iterator->valid()){    
                                              $m_flag = true;
                                          }else{
                                            $m_flag = false;
                                          }
                                       }
                                       elseif(is_dir(@$s_dir)){
                                        $iterator = new \FilesystemIterator(@$s_dir);
                                            if (@$iterator->valid()){    
                                              $m_flag = true;
                                          }else{
                                            $m_flag = false;
                                          }
                                       }

                                   else{
                                        $m_flag = false;
                                    }

                                  if($m_flag){
                                     if (is_dir($d_dir)){
                                      $images = scandir($d_dir);
                                      // Image selection and display:
                                      //display first image
                                      if (count($images) > 0){ // make sure at least one image exists
                                          $url = @$images[2]; // first image

                                          $data[$i]["IMAGE"] = $folder.'/thumb/'.$url;
                                       
                                      }
                                      elseif(is_dir($s_dir)){
                                       $images = scandir($s_dir);
                                       // Image selection and display:
                                       //display first image
                                       if (count($images) > 0){ // make sure at least one image exists
                                           $url = @$images[2]; // first image
                        
                                           $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                        
                                            }
                                        }
                                  }

                                  elseif(is_dir($s_dir)){
                                       $images = scandir($s_dir);
                                       // Image selection and display:
                                       //display first image
                                       if (count($images) > 0){ // make sure at least one image exists
                                           $url = @$images[2]; // first image
                        
                                           $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                        
                                            }
                                        }

                                   }
                               //   $data[$i]["FOL_NAME"] = "aaaaaaa";
                                   $ebayid=$data[$i]["EBAYID"];
                                    //$data_location = $this->handler->get_multi_location($data[$i]["EBAYID"]);
                                   $main_query = "SELECT DISTINCT 'W' || W.WAREHOUSE_NO || '-' || R.RACK_NO || '-R' || RR.ROW_NO || '-' || B.BIN_TYPE || '-' || B.BIN_NO B_LOCATION, BB.BARCODE_NO LOCATION_BARCODE_NO, DECODE(VF.BARCODE_NO, NULL, '', VF.BARCODE_NO) LOCATION_VRF FROM BIN_MT        B, RACK_MT       R, WAREHOUSE_MT  W, LZ_RACK_ROWS  RR, LZ_BARCODE_MT BB, LJ_BIN_VERIFY_DT VF WHERE B.BIN_ID = BB.BIN_ID AND B.CURRENT_RACK_ROW_ID = RR.RACK_ROW_ID AND R.RACK_ID = RR.RACK_ID AND R.WAREHOUSE_ID = W.WAREHOUSE_ID AND VF.BARCODE_NO(+) = BB.BARCODE_NO AND BB.EBAY_ITEM_ID = '$ebayid' AND BB.PULLING_ID IS NULL AND BB.SALE_RECORD_NO IS NULL AND BB.ITEM_ADJ_DET_ID_FOR_OUT IS NULL AND BB.LZ_PART_ISSUE_MT_ID IS NULL ";
                                   $data_location = $this->db->query($main_query)->result_array();


                                    //$record_no =   $this->handler->get_shiping_services();
                                    $record_no = $this->db->query("SELECT * FROM LZ_SHIPING_NAME S WHERE S.STAMPS_SHIPING_CODE IS NOT NULL")->result_array();
                               // echo json_encode(array('location_data'=>($data_location)));
                               $data[$i]["BARCODEARRAY"] = $data_location;
                               for($j = 0; $j < count($record_no); $j++)
                               {
                                 if($record_no[$j]["SHIPING_NAME"] == $data[$i]["SHIPPING_SERVICE"])
                                 {
                                   $data[$i]["SHIPPING_SERVICE"] = $record_no[$j];
                                 }
                               }
                               $data[$i]["SHIPINGARRAY"] = $record_no;
                               

                               }// end main foreach
                               return array("error"=>false,"message"=>"Data Found!","data"=>$data);
                        
                           }
                           else{
                                return array("error"=>true,"message"=>"Data Not Found!","data"=>$data);
                           }

            }
public function pull(){
               $ebay_id = $_POST['PARM_EBAYID'];
               $puller_name = $_POST['PARM_PULLERNAME'];
               $weight = "NULL";
               $order_no = $_POST['PARM_SALENO'];
               $order_id = $_POST['PARM_ORDERID'];
               $action = "pull";
               $pulled_by = $_POST['PARM_PULLERID'];
               $old_barcode = $_POST['PARM_DEFBARCODE'];
               $old_barc = $old_barcode;
               $pull_barcode = $_POST['PARM_PULLBARCODE'];
      
               $query = $this->db->query("SELECT get_single_primary_key('LZ_SALES_PULLING','PULLING_ID') PULLING_ID FROM DUAL");
                     $rs = $query->result_array();
                     $pulling_id = $rs[0]['PULLING_ID'];
                     date_default_timezone_set("America/Chicago");
               $pulling_date = date("Y-m-d H:i:s");
                        $pulling_date= "TO_DATE('".$pulling_date."', 'YYYY-MM-DD HH24:MI:SS')";
            
                     $pulling_no = 1;
                     $ebay_item_id = $ebay_id;
                     $sales_record_no = $order_no;
                     
                     $puller_name = $puller_name;
                      $pulling_qty = 1;
                      $trans_status = "P";
                      $cancel_qty="NULL";
                      $weight = "NULL";
                     $unit = "NULL";
                    
                     $comma = ',';
            
                 $qry_pull = "INSERT INTO LZ_SALES_PULLING VALUES($pulling_id $comma $pulling_date $comma $pulling_no $comma '$ebay_item_id' $comma '$sales_record_no' $comma $pulling_qty $comma '$puller_name' $comma '$trans_status' $comma $cancel_qty $comma $weight $comma $unit $comma $pulled_by)";
                 $this->db->query($qry_pull);
                 $qry_pull = "SELECT PULLING_QTY,TO_CHAR(PULLING_DATE, 'MM/DD/YYYY HH24:MI:SS') PULLING_DATE, CANCEL_QTY FROM LZ_SALES_PULLING P WHERE P.PULLING_ID=(SELECT MAX(PULLING_ID) FROM LZ_SALES_PULLING)";
                 $qry_pull = $this->db->query($qry_pull);
            
              //  if($action == 'pull'){
                $this->db->query("CALL pro_signle_order_post('$sales_record_no','$ebay_id','$order_id')");
            
                  $qr = $this->db->query("UPDATE LZ_BARCODE_MT SET  PULLING_ID = $pulling_id,SALE_RECORD_NO='$sales_record_no' WHERE BARCODE_NO = '$pull_barcode' ");
            
            
                  if($qr){
            
                   if($old_barc != $pull_barcode){
                   $this->db->query("UPDATE LZ_BARCODE_MT SET SALE_RECORD_NO = null WHERE BARCODE_NO = '$old_barc' ");
                   }
               }
                    //  }else{
                      $this->db->query("UPDATE LZ_BARCODE_MT SET SALE_RECORD_NO='' WHERE BARCODE_NO = '$pull_barcode' ");
            
                    //  }// END ACTION IF ELSE
            
                     return array("pulled"=>$qry_pull->result_array());
                //  return $qry_pull->result_array();
            
              }
    
public function getPulledRecord(){
                $main_query = "SELECT MAX(SDD.SALES_RECORD_NUMBER) SALENO,
                DECODE(MAX(SDD.FOLDER_NAME),
                       NULL,
                       'master_pictures/' || TRIM(MAX(SDD.UPC)) || '~' ||
                       REPLACE(TRIM(MAX(SDD.MPN)), '/', '_') || '/' ||
                       TRIM(MAX(SDD.COND_NAME)),
                       'dekitted_pictures/' || MAX(SDD.FOLDER_NAME)) IMAGE,
                'master_pictures/' || TRIM(MAX(SDD.UPC)) || '~' ||
                REPLACE(TRIM(MAX(SDD.MPN)), '/', '_') || '/' ||
                TRIM(MAX(SDD.COND_NAME)) FOL_NAME1,
                MAX(SDD.USER_ID) USER_ID,
                MAX(SDD.BUYER_FULLNAME) FULLNAME,
                MAX(SDD.BUYER_ADDRESS1) ADDRESS1,
                MAX(SDD.BUYER_ADDRESS2) ADDRESS2,
                MAX(SDD.BUYER_CITY) BUYER_CITY,
                MAX(SDD.BUYER_STATE) BUYER_STATE,
                MAX(SDD.BUYER_ZIP) BUYER_ZIP,
                MAX(SDD.BUYER_COUNTRY) BUYER_COUNTRY,
                MAX(SDD.ITEM_ID) EBAYID,
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
                2 ORDER_STATUS,
                SDD.ORDER_ID,
                MAX(SDD.EXTENDEDORDERID) EXTENDEDORDERID,
                DECODE(MAX(SDD.STAMPS_SHIPPING_RATE),
                       NULL,
                       0,
                       MAX(SDD.STAMPS_SHIPPING_RATE)) STAMPS_SHIPPING_RATE,
                DECODE(DECODE(MAX(WS.PACK_WEIGHT),
                              NULL,
                              MAX(MD.WEIGHT),
                              MAX(WS.PACK_WEIGHT)),
                       NULL,
                       0,
                       DECODE(MAX(WS.PACK_WEIGHT),
                              NULL,
                              MAX(MD.WEIGHT),
                              MAX(WS.PACK_WEIGHT))) PACK_WEIGHT,
                DECODE(MAX(WS.MACHINE_INPUT_YN), NULL, 0, MAX(WS.MACHINE_INPUT_YN)) MACHINE_INPUT_YN,
                MAX(SDD.SHIPPING_SERVICE) SHIPPING_SERVICE
           FROM (SELECT SD.SALES_RECORD_NUMBER,
                        SD.USER_ID,
                        SD.BUYER_FULLNAME,
                        DECODE(SD.SHIP_TO_ADDRESS1,
                               NULL,
                               SD.BUYER_ADDRESS1,
                               SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1,
                        DECODE(SD.SHIP_TO_ADDRESS2,
                               NULL,
                               SD.BUYER_ADDRESS2,
                               SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2,
                        DECODE(SD.SHIP_TO_CITY, NULL, SD.BUYER_CITY, SD.SHIP_TO_CITY) BUYER_CITY,
                        DECODE(SD.SHIP_TO_STATE,
                               NULL,
                               SD.BUYER_STATE,
                               SD.SHIP_TO_STATE) BUYER_STATE,
                        DECODE(SD.SHIP_TO_ZIP, NULL, SD.BUYER_ZIP, SD.SHIP_TO_ZIP) BUYER_ZIP,
                        DECODE(SD.SHIP_TO_COUNTRY,
                               NULL,
                               SD.BUYER_COUNTRY,
                               SD.SHIP_TO_COUNTRY) BUYER_COUNTRY,
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
                        IM.ITEM_CODE,
                        IM.ITEM_ID ITM_ID,
                        SP.PULLER_NAME,
                        SP.PULLING_DATE,
                        IM.ITEM_MT_MFG_PART_NO MPN,
                        IM.ITEM_MT_UPC UPC,
                        C.COND_NAME,
                        SD.ORDER_ID,
                        SD.EXTENDEDORDERID,
                        DECODE(SL.FOLDER_NAME, NULL, DK.FOLDER_NAME, NULL) FOLDER_NAME
                   FROM LZ_SALESLOAD_DET SD,
                        LZ_SALESLOAD_MT  LM,
                        LZ_BARCODE_MT    B,
                        ITEMS_MT IM,
                        LZ_ITEM_COND_MT C,
                        LZ_SPECIAL_LOTS SL,
                        LZ_DEKIT_US_DT DK,
                        LZ_AWAITING_SHIPMENT AW,
                        (SELECT SALES_RECORD_NO,
                                EBAY_ITEM_ID,
                                MAX(PULLER_NAME) PULLER_NAME,
                                TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE,
                                SUM(NVL(PULLING_QTY, 0)) PULLING_QTY,
                                SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY
                           FROM LZ_SALES_PULLING
                          GROUP BY SALES_RECORD_NO, EBAY_ITEM_ID) SP
                  WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO
                    AND SD.ITEM_ID = SP.EBAY_ITEM_ID
                    AND LM.LZ_SALELOAD_ID = SD.LZ_SALELOAD_ID
                    AND SD.ORDER_ID = B.ORDER_ID
                    AND IM.ITEM_ID = B.ITEM_ID
                    AND C.ID = B.CONDITION_ID
                    AND B.BARCODE_NO = SL.BARCODE_PRV_NO(+)
                    AND B.BARCODE_NO = DK.BARCODE_PRV_NO(+)
                    AND SD.ORDER_ID = AW.ORDERLINEITEMID
                  ORDER BY SD.SALE_DATE DESC NULLS LAST) SDD,
                (SELECT DISTINCT E.EBAY_ITEM_ID, E.LZ_SELLER_ACCT_ID
                   FROM EBAY_LIST_MT E) EB,
                (SELECT DISTINCT W.ITEM_ID,
                                 W.PACK_WEIGHT,
                                 W.SHIPPING_SERVICE,
                                 W.MACHINE_INPUT_YN
                   FROM LZ_ITEM_PACK_WEIGHT W) WS,
                (SELECT D.WEIGHT, D.LZ_MANIFEST_ID, D.LAPTOP_ITEM_CODE
                   FROM LZ_MANIFEST_DET D) MD
          WHERE NVL(SDD.QUANTITY, 0) <
                (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0))
            AND SDD.PULLING_QTY > 0
            AND SDD.ITEM_ID = EB.EBAY_ITEM_ID
            AND SDD.ITM_ID = WS.ITEM_ID(+)
            AND SDD.ITEM_CODE = MD.LAPTOP_ITEM_CODE(+)
            AND SDD.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID(+)
         --AND TO_DATE(SDD.SALE_DATE, 'MM/DD/YYYY HH24:MI:SS') >= (SYSDATE - 7)
          GROUP BY SDD.ORDER_ID
         
         UNION
         SELECT MAX(SDD.SALES_RECORD_NUMBER) SALES_RECORD_NUMBER,
                DECODE(MAX(SDD.FOLDER_NAME),
                       NULL,
                       'master_pictures/' || TRIM(MAX(SDD.UPC)) || '~' ||
                       REPLACE(TRIM(MAX(SDD.MPN)), '/', '_') || '/' ||
                       TRIM(MAX(SDD.COND_NAME)),
                       'dekitted_pictures/' || MAX(SDD.FOLDER_NAME)) IMAGE,
                'master_pictures/' || TRIM(MAX(SDD.UPC)) || '~' ||
                REPLACE(TRIM(MAX(SDD.MPN)), '/', '_') || '/' ||
                TRIM(MAX(SDD.COND_NAME)) FOL_NAME1,
                MAX(SDD.USER_ID) USER_ID,
                MAX(SDD.BUYER_FULLNAME) FULLNAME,
                MAX(SDD.BUYER_ADDRESS1) ADDRESS1,
                MAX(SDD.BUYER_ADDRESS2) ADDRESS2,
                MAX(SDD.BUYER_CITY) BUYER_CITY,
                MAX(SDD.BUYER_STATE) BUYER_STATE,
                MAX(SDD.BUYER_ZIP) BUYER_ZIP,
                MAX(SDD.BUYER_COUNTRY) BUYER_COUNTRY,
                MAX(SDD.ITEM_ID) EBAYID,
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
                MAX(SDD.PULLING_PRINT_YN) ORDER_STATUS,
                SDD.ORDER_ID,
                MAX(SDD.EXTENDEDORDERID) EXTENDEDORDERID,
                DECODE(MAX(SDD.STAMPS_SHIPPING_RATE),
                       NULL,
                       0,
                       MAX(SDD.STAMPS_SHIPPING_RATE)) STAMPS_SHIPPING_RATE,
                DECODE(DECODE(MAX(WS.PACK_WEIGHT),
                              NULL,
                              MAX(MD.WEIGHT),
                              MAX(WS.PACK_WEIGHT)),
                       NULL,
                       0,
                       DECODE(MAX(WS.PACK_WEIGHT),
                              NULL,
                              MAX(MD.WEIGHT),
                              MAX(WS.PACK_WEIGHT))) PACK_WEIGHT,
                DECODE(MAX(WS.MACHINE_INPUT_YN), NULL, 0, MAX(WS.MACHINE_INPUT_YN)) MACHINE_INPUT_YN,
                MAX(SDD.SHIPPING_SERVICE) SHIPPING_SERVICE
           FROM (SELECT SD.SALES_RECORD_NUMBER,
                        SD.USER_ID,
                        SD.BUYER_FULLNAME,
                        DECODE(SD.SHIP_TO_ADDRESS1,
                               NULL,
                               SD.BUYER_ADDRESS1,
                               SD.SHIP_TO_ADDRESS1) BUYER_ADDRESS1,
                        DECODE(SD.SHIP_TO_ADDRESS2,
                               NULL,
                               SD.BUYER_ADDRESS2,
                               SD.SHIP_TO_ADDRESS2) BUYER_ADDRESS2,
                        DECODE(SD.SHIP_TO_CITY, NULL, SD.BUYER_CITY, SD.SHIP_TO_CITY) BUYER_CITY,
                        DECODE(SD.SHIP_TO_STATE,
                               NULL,
                               SD.BUYER_STATE,
                               SD.SHIP_TO_STATE) BUYER_STATE,
                        DECODE(SD.SHIP_TO_ZIP, NULL, SD.BUYER_ZIP, SD.SHIP_TO_ZIP) BUYER_ZIP,
                        DECODE(SD.SHIP_TO_COUNTRY,
                               NULL,
                               SD.BUYER_COUNTRY,
                               SD.SHIP_TO_COUNTRY) BUYER_COUNTRY,
                        SD.ITEM_ID,
                        SD.TOTAL_PRICE,
                        SD.SHIPPING_SERVICE,
                        SD.STAMPS_SHIPPING_RATE,
                        SD.ITEM_TITLE,
                        SD.QUANTITY,
                        NVL(SP.PULLING_QTY, 0) PULLING_QTY,
                        NVL(SP.CANCEL_QTY, 0) CANCEL_QTY,
                        B.BARCODE_NO,
                        B.PULLING_PRINT_YN,
                        B.LZ_MANIFEST_ID,
                        IM.ITEM_CODE,
                        IM.ITEM_ID ITM_ID,
                        SP.PULLER_NAME,
                        SP.PULLING_DATE,
                        IM.ITEM_MT_MFG_PART_NO MPN,
                        IM.ITEM_MT_UPC UPC,
                        C.COND_NAME,
                        SD.ORDER_ID,
                        SD.EXTENDEDORDERID,
                        DECODE(SL.FOLDER_NAME, NULL, DK.FOLDER_NAME, NULL) FOLDER_NAME
                   FROM LZ_SALESLOAD_DET SD,
                        LZ_SALESLOAD_MT  LM,
                        LZ_BARCODE_MT    B,
                        
                        ITEMS_MT IM,
                        LZ_ITEM_COND_MT C,
                        LZ_SPECIAL_LOTS SL,
                        LZ_DEKIT_US_DT DK,
                        LZ_AWAITING_SHIPMENT AW,
                        (SELECT SALES_RECORD_NO,
                                EBAY_ITEM_ID,
                                MAX(PULLER_NAME) PULLER_NAME,
                                TO_CHAR(MAX(PULLING_DATE), 'YYYY-MM-DD HH24:MI:SS') PULLING_DATE,
                                SUM(NVL(PULLING_QTY, 0)) PULLING_QTY,
                                SUM(NVL(CANCEL_QTY, 0)) CANCEL_QTY
                           FROM LZ_SALES_PULLING
                          GROUP BY SALES_RECORD_NO, EBAY_ITEM_ID) SP
                  WHERE SD.SALES_RECORD_NUMBER = SP.SALES_RECORD_NO
                    AND SD.ITEM_ID = SP.EBAY_ITEM_ID
                    AND LM.LZ_SALELOAD_ID = SD.LZ_SALELOAD_ID
                    AND SD.ORDER_ID = B.ORDER_ID
                    AND IM.ITEM_ID = B.ITEM_ID
                    AND C.ID = B.CONDITION_ID
                    AND B.BARCODE_NO = SL.BARCODE_PRV_NO(+)
                    AND B.BARCODE_NO = DK.BARCODE_PRV_NO(+)
                    AND SD.ORDER_ID = AW.ORDERLINEITEMID
                  ORDER BY SD.SALE_DATE DESC NULLS LAST) SDD,
                (SELECT DISTINCT E.EBAY_ITEM_ID, E.LZ_SELLER_ACCT_ID
                   FROM EBAY_LIST_MT E) EB,
                (SELECT DISTINCT W.ITEM_ID,
                                 W.PACK_WEIGHT,
                                 W.SHIPPING_SERVICE,
                                 W.MACHINE_INPUT_YN
                   FROM LZ_ITEM_PACK_WEIGHT W) WS,
                (SELECT D.WEIGHT, D.LZ_MANIFEST_ID, D.LAPTOP_ITEM_CODE
                   FROM LZ_MANIFEST_DET D) MD
          WHERE NVL(SDD.QUANTITY, 0) =
                (NVL(SDD.PULLING_QTY, 0) + NVL(SDD.CANCEL_QTY, 0))
            AND SDD.PULLING_QTY > 0
            AND SDD.ITEM_ID = EB.EBAY_ITEM_ID
            AND SDD.ITM_ID = WS.ITEM_ID(+)
            AND SDD.ITEM_CODE = MD.LAPTOP_ITEM_CODE(+)
            AND SDD.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID(+)
         --AND TO_DATE(SDD.SALE_DATE, 'MM/DD/YYYY HH24:MI:SS') >= (SYSDATE - 7)
          GROUP BY SDD.ORDER_ID
          ";
                                     $data = $this->db->query($main_query)->result_array();
            
                                   /*=====  End of copy from m_notification  ======*/
                                   if(count($data) > 0 ){
                                       $pic_path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 7")->result_array();;
                                       $master_path = $pic_path[0]['MASTER_PATH'];
                                       for($i = 0; $i < count($data);$i++){  
                                           $d_dir = $master_path;
                                           $s_dir = $master_path;
                                            $folder = $data[$i]["IMAGE"];
                                           $folder1 = $data[$i]["FOL_NAME1"];
                                           $d_dir = @$d_dir.@$folder.'/thumb/';
                                           $s_dir = @$s_dir.@$folder1.'/thumb/';
                                           
                                                
            
            
                                                if(is_dir(@$d_dir)){
                                                   // var_dump($d_dir);
                                                    $iterator = new \FilesystemIterator(@$d_dir);
                                                      if(@$iterator->valid()){    
                                                          $m_flag = true;
                                                      }else{
                                                        $m_flag = false;
                                                      }
                                                   }
                                                   elseif(is_dir(@$s_dir)){
                                                    $iterator = new \FilesystemIterator(@$s_dir);
                                                        if (@$iterator->valid()){    
                                                          $m_flag = true;
                                                      }else{
                                                        $m_flag = false;
                                                      }
                                                   }
            
                                               else{
                                                    $m_flag = false;
                                                }
            
                                              if($m_flag){
                                                 if (is_dir($d_dir)){
                                                  $images = scandir($d_dir);
                                                  // Image selection and display:
                                                  //display first image
                                                  if (count($images) > 0){ // make sure at least one image exists
                                                      $url = @$images[2]; // first image
            
                                                      $data[$i]["IMAGE"] = $folder.'/thumb/'.$url;
                                                   
                                                  }
                                                  elseif(is_dir($s_dir)){
                                                   $images = scandir($s_dir);
                                                   // Image selection and display:
                                                   //display first image
                                                   if (count($images) > 0){ // make sure at least one image exists
                                                       $url = @$images[2]; // first image
                                    
                                                       $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                                    
                                                        }
                                                    }
                                              }
            
                                              elseif(is_dir($s_dir)){
                                                   $images = scandir($s_dir);
                                                   // Image selection and display:
                                                   //display first image
                                                   if (count($images) > 0){ // make sure at least one image exists
                                                       $url = @$images[2]; // first image
                                    
                                                       $data[$i]["IMAGE"] = $folder1.'/thumb/'.$url;
                                                    
                                                        }
                                                    }
            
                                               }
                                          
                                           }// end main foreach
                                           return array("error"=>false,"message"=>"Data Found!","data"=>$data);
                                    
                                       }
                                       else{
                                            return array("error"=>true,"message"=>"Data Not Found!","data"=>$data);
                                       }
            
                        }
}