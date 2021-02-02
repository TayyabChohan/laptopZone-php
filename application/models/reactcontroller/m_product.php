<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_product extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
    }
public function getBins(){
    $bins = $this->db->query("SELECT B.BIN_ID BIN_ID, B.BIN_TYPE || '-' ||B.BIN_NO BIN_NO FROM BIN_MT B")->result_array();
    if($bins){
        return array( "found" => true, "bins" => $bins);
    }else{
        return array( "found" => false, "bins" => "");
    }
}
public function checkInventory(){
    $merch_id = $this->input->post('merch_id');
    $userId = $this->input->post('userId');
    $upc = $this->input->post('upc');
    $mpn = $this->input->post('mpn');

    $inventoryExist = $this->db->query("SELECT IT.LZ_PRODUCT_ID, COND.COND_NAME, COND.ID, IT.LZ_ITEMS_MT_ID
                                        FROM LZ_MERCHANT_PRO MP, LZ_PRODUCT_MT PM, LZ_ITEMS_MT IT, LZ_ITEM_COND_MT COND
                                        WHERE PM.LZ_PRODUCT_ID = MP.PRODUCT_ID
                                        AND IT.LZ_PRODUCT_ID = PM.LZ_PRODUCT_ID
                                        AND COND.ID = IT.CONDITION_ID
                                        AND MP.MERCHANT_ID   = $merch_id
                                        AND MP.CREATED_BY    = $userId
                                        AND (PM.UPC = '$upc'
                                        OR PM.MPN = '$mpn')
                                        ")->result_array();
    if($inventoryExist){
        $condition = $inventoryExist[0]['COND_NAME'];
        $lz_product_id = $inventoryExist[0]['LZ_PRODUCT_ID'];
        return array("found" => true,"message"=>"Product already exist in your inventory with '$condition' condition!", "records" => $inventoryExist, "lz_product_id" => $lz_product_id);
    }else{
        return array("found" => false,"message"=>"Something went wrong!", "lz_product_id" => "");
    }
}

    public function add_product(){

      $upc = $this->input->post('upc');
  	  $upc = trim(str_replace("  ", ' ', $upc));
      $upc = trim(str_replace(array("'"), "''", $upc));
      
      $mpn = $this->input->post('mpn');
  	  $mpn = trim(str_replace("  ", ' ', $mpn));
      $mpn = trim(str_replace(array("'"), "''", $mpn));
      
      $userId = $this->input->post('userId');
  	  $userId = trim(str_replace("  ", ' ', $userId));
      $userId = trim(str_replace(array("'"), "''", $userId));

      $manufacturer = $this->input->post('manufacturer');
  	  $manufacturer = trim(str_replace("  ", ' ', $manufacturer));
      $manufacturer = trim(str_replace(array("'"), "''", $manufacturer));

      $mpnDescription = $this->input->post('mpnDescription');
  	  $mpnDescription = trim(str_replace("  ", ' ', $mpnDescription));
      $mpnDescription = trim(str_replace(array("'"), "''", $mpnDescription));

      
      if(!$upc && !$mpn){
        return array('insert' => false, 'message' => "Please enter UPC or MPN");
      }
      if(!$manufacturer){
        return array('insert' => false, 'message' => "Manufacturer is empty!");
      }
      $mpnDescription = str_replace("'",'"',$mpnDescription);

      $date = date("m/d/Y");
      date_default_timezone_set("America/Chicago");
      $date = date('Y-m-d H:i:s');
      $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        try{
            if($upc){
                $already_exist = $this->db->query("SELECT count(*) as UPC from LZ_PRODUCT_MT where upc =  '$upc'")->result_array();
                if( $already_exist[0]['UPC'] > 0 ){
                    return array('insert' => false, 'message' => "Item already exist with the same UPC");
                }
            }
            if($mpn){
                $already_exist = $this->db->query("SELECT count(*) as MPN from LZ_PRODUCT_MT where MPN =  '$mpn'")->result_array();
                if( $already_exist[0]['MPN'] > 0 ){
                    return array('insert' => false, 'message' => "Item already exist with the same MPN");
                }
            }
            if( !$upc && $mpn  ){
                $query = "INSERT INTO LZ_PRODUCT_MT VALUES(get_single_primary_key('LZ_PRODUCT_MT','LZ_PRODUCT_ID'),null,'$mpn','$mpnDescription','$manufacturer',$userId,$insert_date)";
            }else if( $upc && !$mpn  ){
                $query = "INSERT INTO LZ_PRODUCT_MT VALUES(get_single_primary_key('LZ_PRODUCT_MT','LZ_PRODUCT_ID'),'$upc',null,'$mpnDescription','$manufacturer',$userId,$insert_date)";
            }else if( $upc && $mpn ){
                $query = "INSERT INTO LZ_PRODUCT_MT VALUES(get_single_primary_key('LZ_PRODUCT_MT','LZ_PRODUCT_ID'),'$upc','$mpn','$mpnDescription','$manufacturer',$userId,$insert_date)";
            }

        $insert = $this->db->query($query);
            if ( $insert )
            {
                return array('insert' => true, 'message' => "Item posted successfully");
            }else{
            return array('insert' => false, 'message' => "Something went wrong! Report to admin");
            }

        }catch(Exception $e){
            return array('insert' => false, 'message' => "Something went wrong! Report to admin");
        }
    }
    public function addSeedProduct(){
        $seed_id     = $this->input->post("seed_id");
        $userId      = $this->input->post("userId");
        $upc         = $this->input->post("upc");
        $mpn         = $this->input->post("mpn");
        $description = $this->input->post("description");
        $description = str_replace("'",'"',$description);

        $seed_data = $this->db->query("   SELECT A.F_UPC,A.F_MPN,A.F_MANUFACTURE,A.ITEM_TITLE FROM LZ_ITEM_SEED A WHERE (A.F_UPC = '$upc' OR A.F_MPN = '$mpn') AND A.ITEM_TITLE = '$description' AND ROWNUM = 1 ")->result_array();
        $upc = $seed_data[0]['F_UPC'];
        $mpn = $seed_data[0]['F_MPN'];
        $mpnDescription  = $seed_data[0]['ITEM_TITLE'];
        $manufacturer     = $seed_data[0]['F_MANUFACTURE'];

        $date = date("m/d/Y");
      date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
    	$insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

            $already_exist = $this->db->query("SELECT LZ_PRODUCT_ID from LZ_PRODUCT_MT where (UPC =  '$upc' OR MPN =  '$mpn') ")->result_array();
            if( sizeof($already_exist) > 0 ){
                $product_id = $already_exist[0]['LZ_PRODUCT_ID'];
                return array('insert' => false, 'message' => "Item already exist with the same UPC", "lz_product_id" => $product_id);
            }
            $mpnDescription = str_replace("'",'"',$mpnDescription);
            $query = "";
            if( !$upc && $mpn  ){
                $query = "INSERT INTO LZ_PRODUCT_MT VALUES(get_single_primary_key('LZ_PRODUCT_MT','LZ_PRODUCT_ID'),null,'$mpn','$mpnDescription','$manufacturer',$userId,$insert_date)";
            }else if( $upc && !$mpn  ){
                $query = "INSERT INTO LZ_PRODUCT_MT VALUES(get_single_primary_key('LZ_PRODUCT_MT','LZ_PRODUCT_ID'),'$upc',null,'$mpnDescription','$manufacturer',$userId,$insert_date)";
            }else if( $upc && $mpn ){
                $query = "INSERT INTO LZ_PRODUCT_MT VALUES(get_single_primary_key('LZ_PRODUCT_MT','LZ_PRODUCT_ID'),'$upc','$mpn','$mpnDescription','$manufacturer',$userId,$insert_date)";
            }
            $insert = $this->db->query($query);
            if ( $insert )
            {
                $products = $this->db->query("SELECT MAX(LZ_PRODUCT_ID) AS LZ_PRODUCT_ID FROM LZ_PRODUCT_MT")->result_array();
                $product_id = $products[0]['LZ_PRODUCT_ID'];
                return array('insert' => true, 'message' => "Item Added", "lz_product_id" => $product_id);
            }else{
            return array('insert' => false, 'message' => "Something went wrong! Report to admin", "lz_product_id" => "");
            }

    }
    public function updateCost(){
        $dt_id = $this->input->post("dt_id");
        $cost = $this->input->post("cost");

        $updateCost = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT A SET A.COST = $cost WHERE A.DT_ID = $dt_id");
        if( $updateCost ){
            return array("updated"=>true, "message"=>"Successfull updated cost");
        }else{
            return array("updated"=>false, "message"=>"Something went wrong!");
        }
         
    }
    public function updateAccount(){
        $dt_id = $this->input->post("dt_id");
        $account = $this->input->post("account");
        $updateCost = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT A SET A.ACCOUNT_ID = $account WHERE A.DT_ID = $dt_id");
        if( $updateCost ){
            return array("updated"=>true, "message"=>"Account Changed Successfully!");
        }else{
            return array("updated"=>false, "message"=>"Something went wrong!");
        }
    }
    public function updateAllAccounts(){
        $lz_product_inv_id = $this->input->post("lz_product_inv_id");
        $account = $this->input->post("account_id");


        $updateCost = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT A SET A.ACCOUNT_ID = $account WHERE A.MT_ID = 
        (SELECT MT.MT_ID FROM LZ_MERCHANT_BARCODE_MT MT WHERE MT.LZ_PRODUCT_INV_ID =  $lz_product_inv_id )");
        if( $updateCost ){
            return array("updated"=>true, "message"=>"Account changed successfully of all barcodes");
        }else{
            return array("updated"=>false, "message"=>"Something went wrong!");
        }
    }
    public function updateAllCosts(){
        $lz_product_inv_id = $this->input->post("lz_product_inv_id");
        $costList = $this->input->post("costList");


        $updateCost = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT A SET A.COST = $costList WHERE A.MT_ID = 
        (SELECT MT.MT_ID FROM LZ_MERCHANT_BARCODE_MT MT WHERE MT.LZ_PRODUCT_INV_ID =  $lz_product_inv_id )");
        if( $updateCost ){
            return array("updated"=>true, "message"=>"Cost changed successfully of all barcodes");
        }else{
            return array("updated"=>false, "message"=>"Something went wrong!");
        }
    }
    public function listToJeannie(){
        $lz_produc_inv_id = $this->input->post("lz_product_inv_id");
        $merchant_barcode_mt = $this->db->query("SELECT MT.MT_ID FROM LZ_MERCHANT_BARCODE_MT MT WHERE MT.LZ_PRODUCT_INV_ID = $lz_produc_inv_id")->result_array();
        $string_array = "";
        $i = 1;
        $length = sizeof($merchant_barcode_mt);
        foreach ($merchant_barcode_mt as $MT_ID){
            if($i >= 1 && $i < $length){
            $string_array .= $MT_ID['MT_ID'] . ",";
            }
            if( $i == $length ){
            $string_array .= $MT_ID['MT_ID'];
            }
            $i++;
        }
        $merchant_barcode_dt = $this->db->query("SELECT DT.BARCODE_NO FROM LZ_MERCHANT_BARCODE_DT DT WHERE DT.MT_ID IN ($string_array) ")->result_array();
        $string_array2 = "";
        $j = 1;
        $length2 = sizeof($merchant_barcode_dt);
        foreach ($merchant_barcode_dt as $DT_ID){
            if($j >= 1 && $j < $length2){
            $string_array2 .= $DT_ID['BARCODE_NO'] . ",";
            }
            if( $j == $length2 ){
            $string_array2 .= $DT_ID['BARCODE_NO'];
            }
            $j++;
        }
        $update = $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.LISTED_YN = 1 WHERE LOT.BARCODE_PRV_NO IN ($string_array2)");
        if($update){
            return array( "update" => true, "message" => "Send To Jeannie Successfull!");
        }else{
            return array( "update" => false, "message" => "Something went wrong!");
        }
        
    }
    public function updateBarcodeStatus(){
        $dt_id = $this->input->post("dt_id");
        $merchant_barcode_dt = $this->db->query("SELECT DT.BARCODE_NO FROM LZ_MERCHANT_BARCODE_DT DT WHERE DT.DT_ID = $dt_id ")->result_array();
        $barcode = $merchant_barcode_dt[0]['BARCODE_NO'];
        $update = $this->db->query("UPDATE LZ_SPECIAL_LOTS LOT SET LOT.LISTED_YN = 1 WHERE LOT.BARCODE_PRV_NO = $barcode");
        if($update){
            return array( "update" => true, "message" => "Send To Jeannie Successfull!");
        }else{
            return array( "update" => false, "message" => "Something went wrong!");
        }
        
    }
    public function deleteAll(){
        $lz_produc_inv_id = $this->input->post("lz_produc_inv_id");
        $delete_lz_produc_inv_mt = "UPDATE LZ_PRODUCT_INV_MT SET DISCARD_COND = -1 WHERE LZ_PRODUCT_INV_ID = $lz_produc_inv_id";
        $this->db->query($delete_lz_produc_inv_mt);
        $masters_records = $this->db->query("SELECT * FROM LZ_MERCHANT_BARCODE_MT WHERE LZ_PRODUCT_INV_ID = $lz_produc_inv_id")->result_array();
        foreach($masters_records as $master){
            $mt_id = $master['MT_ID'];
            $delete_lz_merchant_barcode_dt = "UPDATE LZ_MERCHANT_BARCODE_DT SET DISCARD_COND = -1 WHERE MT_ID = $mt_id ";
            $this->db->query($delete_lz_merchant_barcode_dt);

            $detail_records = $this->db->query("SELECT * FROM LZ_MERCHANT_BARCODE_DT WHERE MT_ID = $mt_id")->result_array();
        foreach($detail_records as $detail){
            $barcode = $detail['BARCODE_NO'];
            $lots = "UPDATE LZ_SPECIAL_LOTS SET CONDITION_ID = -1 WHERE BARCODE_PRV_NO = $barcode ";
            $this->db->query($lots);
        }

        }
        return array( "delete" => true, "message"=> "Successfully Discarded Barcodes" );
    }
    public function selectiveDelete(){
        $ids = $this->input->post("dt_id");
        $length = sizeof($ids);
        $string_array = "";
        $i = 1;
        foreach ($ids as $dt_id){
            if($i >= 1 && $i < $length){
            $string_array .= $dt_id . ",";
            }
            if( $i == $length ){
            $string_array .= $dt_id;
            }

            $i++;
        }
        $barcodes = $this->db->query("SELECT * FROM LZ_MERCHANT_BARCODE_DT WHERE DT_ID IN ($string_array) ")->result_array();
        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT SET DISCARD_COND = -1  WHERE DT_ID IN ($string_array)");
        $string_array2 = "";
        $j = 1;
        $mt_id = $barcodes[0]['MT_ID'];
        foreach ($barcodes as $barcode){
            if($j >= 1 && $j < $length){
            $string_array2 .= $barcode['BARCODE_NO'] . ",";
            }
            if( $j == $length ){
            $string_array2 .= $barcode['BARCODE_NO'];
            }
            $j++;
        }
        $mt_records = $this->db->query("SELECT * FROM LZ_MERCHANT_BARCODE_MT WHERE MT_ID = $mt_id")->result_array();
        $string_array3 = "";
        $k = 1;
        foreach ($mt_records as $mt_record){
            if($k >= 1 && $k < $length){
            $string_array3 .= $mt_record['LZ_PRODUCT_INV_ID'] . ",";
            }
            if( $k == $length ){
            $string_array3 .= $mt_record['LZ_PRODUCT_INV_ID'];
            }
            $k++;
        }
        $update  = $this->db->query("UPDATE LZ_PRODUCT_INV_MT SET DISCARD_COND = -1 WHERE LZ_PRODUCT_INV_ID IN ($string_array2)");
        $update2 = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET CONDITION_ID = -1  WHERE BARCODE_PRV_NO IN ($string_array2)");
        if( $update2 ){
            return array("updated" => true, "message" => "Barcodes Deleted!");
        }else{
            return array("updated" => false, "message" => "Something Wen Wrong!");
        }
    }
    public function getBarcodes(){
        $lz_produc_inv_id = $this->input->post("lz_produc_inv_id");
        $barcodes = $this->db->query("SELECT C.DT_ID,
       CASE
         WHEN BMT.EBAY_ITEM_ID IS NOT NULL THEN
          'Listed'
         WHEN LOT.LZ_MANIFEST_DET_ID IS NULL THEN
          'Not Listed'
         WHEN LOT.PIC_DATE_TIME IS NOT NULL AND LOT.PIC_BY IS NOT NULL THEN
          'Process Completed'
       END STATUS,
       CASE
         WHEN LOT.LISTED_YN IS NULL OR LOT.LISTED_YN = 0  THEN
          'Send To Jeannie'
         WHEN LOT.LISTED_YN = 1 THEN
          'Already Sended To Jeannie'
       END LISTTOJEANNIE,
       C.BARCODE_NO,
       CON.COND_NAME,
       C.COST,
       TO_CHAR(A.CREATED_AT, 'DD-MON-YYYY') ISSUED_DATE,
       MAD.ACCOUNT_NAME,
       MAD.ACCT_ID
  FROM LZ_PRODUCT_INV_MT      A,
       LZ_MERCHANT_BARCODE_MT B,
       LZ_MERCHANT_BARCODE_DT C,
       LZ_MERCHANT_MT         D,
       LZ_SPECIAL_LOTS        LOT,
       LZ_ITEM_COND_MT        CON,
       EMPLOYEE_MT            EMP,
       LZ_BARCODE_MT          BMT,
       LJ_MERHCANT_ACC_DT     MAD
 WHERE A.LZ_PRODUCT_INV_ID = B.LZ_PRODUCT_INV_ID
   AND B.MT_ID = C.MT_ID
   AND C.ACCOUNT_ID = MAD.ACCT_ID
   AND LOT.BARCODE_PRV_NO = C.BARCODE_NO
   AND BMT.BARCODE_NO(+) = LOT.BARCODE_PRV_NO
   AND B.MERCHANT_ID = D.MERCHANT_ID
   AND CON.ID = LOT.CONDITION_ID
   AND EMP.EMPLOYEE_ID = A.CREATED_BY
   AND A.LZ_PRODUCT_INV_ID = $lz_produc_inv_id
   AND (A.DISCARD_COND IS NULL OR LOT.CONDITION_ID != -1)
   ORDER BY C.DT_ID DESC")->result_array();

   $master_record = $this->db->query("SELECT MBM.MT_ID,
       MM.BUISNESS_NAME,
       TO_CHAR(PIM.CREATED_AT,'DD-MM-YY HH24:MI:SS') ISSUED_DATE,
       EM.FIRST_NAME,
       (SELECT COUNT(L.BARCODE_PRV_NO)
          FROM LZ_MERCHANT_BARCODE_MT M,
               LZ_MERCHANT_BARCODE_DT D,
               LZ_SPECIAL_LOTS        L
         WHERE M.MT_ID = D.MT_ID
           AND D.BARCODE_NO = L.BARCODE_PRV_NO
           AND M.LZ_PRODUCT_INV_ID = PIM.LZ_PRODUCT_INV_ID
           AND (D.DISCARD_COND IS NULL OR L.CONDITION_ID != -1)) ITEM_QTY
  FROM LZ_PRODUCT_INV_MT      PIM,
       LZ_MERCHANT_BARCODE_MT MBM,
       LZ_ITEMS_MT            ITM,
       LZ_PRODUCT_MT          PM,
       LZ_MERCHANT_PRO        MP,
       LZ_MERCHANT_MT         MM,
       EMPLOYEE_MT            EM
 WHERE ITM.LZ_ITEMS_MT_ID = PIM.LZ_ITEMS_MT_ID
   AND PIM.LZ_PRODUCT_INV_ID = MBM.LZ_PRODUCT_INV_ID
   AND PM.LZ_PRODUCT_ID = ITM.LZ_PRODUCT_ID
   AND MP.PRODUCT_ID = PM.LZ_PRODUCT_ID
   AND MM.MERCHANT_ID = MP.MERCHANT_ID
   AND EM.EMPLOYEE_ID = PIM.CREATED_BY
   AND PIM.LZ_PRODUCT_INV_ID = $lz_produc_inv_id")->result_array();
    if( $barcodes ){
        return array( "found" => true , "barcodes" => $barcodes, "master_records" => $master_record );
    }else {
        return array( "found" => false , "barcodes" => "", "master_records" => "" );
    }
    }
    public function getLzProductInvMt(){
        $merch_id = $this->input->post("merch_id");
        $userId   = $this->input->post("userId");

        $accounts = $this->db->query("SELECT MAD.ACCT_ID,MAD.ACCOUNT_NAME 
                                      FROM LJ_MERHCANT_ACC_DT MAD 
                                      WHERE MAD.MERCHANT_ID = $merch_id 
                                      AND MAD.INSERTED_BY = $userId")->result_array();

        $allRecords  = $this->db->query("SELECT (SELECT CASE
                 WHEN COUNT(BARMT.EBAY_ITEM_ID) = COUNT(BDT.BARCODE_NO) THEN
                  'Listed'
                 WHEN COUNT(BARMT.EBAY_ITEM_ID) > 0 AND
                      COUNT(BARMT.EBAY_ITEM_ID) < COUNT(BDT.BARCODE_NO) THEN
                  'Partially Listed'
                 WHEN COUNT(LOT.LZ_MANIFEST_DET_ID) = 0 THEN
                  'Not Listed'
                 WHEN COUNT(LOT.PIC_DATE_TIME) != 0 AND
                      COUNT(LOT.PIC_BY) != 0 THEN
                  'Process Completed'
               END STATUS
          FROM LZ_PRODUCT_INV_MT      PMT,
               LZ_MERCHANT_BARCODE_MT BMT,
               LZ_MERCHANT_BARCODE_DT BDT,
               LZ_BARCODE_MT          BARMT,
               LZ_SPECIAL_LOTS        LOT
         WHERE PMT.LZ_PRODUCT_INV_ID = BMT.LZ_PRODUCT_INV_ID
           AND BMT.MT_ID = BDT.MT_ID
           AND BARMT.BARCODE_NO(+) = BDT.BARCODE_NO
           AND BDT.BARCODE_NO = LOT.BARCODE_PRV_NO(+)
           AND B.LZ_ITEMS_MT_ID = PMT.LZ_ITEMS_MT_ID) STATUS,
          TO_CHAR((SELECT REPLACE(REPLACE(XMLAGG(XMLELEMENT(A, BDT.BARCODE_NO) ORDER BY BDT.DT_ID DESC NULLS LAST)
                               .GETCLOBVAL(),
                               '<A>',
                               ''),
                       '</A>',
                       ', ') AS BARCODE_NO FROM LZ_MERCHANT_BARCODE_MT BMT, LZ_MERCHANT_BARCODE_DT BDT 
                   WHERE BMT.MT_ID = BDT.MT_ID
                   AND BMT.LZ_PRODUCT_INV_ID = A.LZ_PRODUCT_INV_ID
                   AND (BDT.DISCARD_COND IS NULL OR BDT.DISCARD_COND != -1) )) BARCODES,
            PROMT.UPC,
           PROMT.MPN,
           PROMT.LZ_PRODUCT_ID,
           PROMT.MPN_DESCRIPTION,
           PROMT.MANUFACTURER,
       A.LZ_PRODUCT_INV_ID,
       A.DISCARD_COND,
       CONMT.COND_NAME,
       (SELECT COUNT(L.BARCODE_PRV_NO)
          FROM LZ_MERCHANT_BARCODE_MT M,
               LZ_MERCHANT_BARCODE_DT D,
               LZ_SPECIAL_LOTS        L
         WHERE M.MT_ID = D.MT_ID
           AND D.BARCODE_NO = L.BARCODE_PRV_NO
           AND M.LZ_PRODUCT_INV_ID = A.LZ_PRODUCT_INV_ID
           AND (D.DISCARD_COND IS NULL OR L.CONDITION_ID != -1)) ITEM_QTY,
       (SELECT SUM(D.COST)
          FROM LZ_MERCHANT_BARCODE_MT M,
               LZ_MERCHANT_BARCODE_DT D,
               LZ_SPECIAL_LOTS        L
         WHERE M.MT_ID = D.MT_ID
           AND D.BARCODE_NO = L.BARCODE_PRV_NO
           AND M.LZ_PRODUCT_INV_ID = A.LZ_PRODUCT_INV_ID
           AND (D.DISCARD_COND IS NULL OR L.CONDITION_ID != -1)) ITEM_COST,
           MM.BUISNESS_NAME,
       EMP.FIRST_NAME,
       TO_CHAR(A.CREATED_AT,'DD-MM-YY HH24:MI:SS') ISSUED_DATE,
        (SELECT CASE
                         WHEN COUNT(LOT.LISTED_YN) = 0  THEN
                          'Send To Jeannie'
                         WHEN COUNT(LOT.LISTED_YN) > 0 AND
                              COUNT(LOT.LISTED_YN) <
                              COUNT(BDT.BARCODE_NO) THEN
                          'Partially Sended To Jeannie'
                         WHEN COUNT(LOT.LISTED_YN) = COUNT(BDT.BARCODE_NO) THEN
                          'Already Sended To Jeannie'
                       END STATUS
                  FROM LZ_MERCHANT_BARCODE_MT BMT,
                       LZ_MERCHANT_BARCODE_DT BDT,
                       LZ_SPECIAL_LOTS        LOT
                 WHERE BMT.MT_ID = BDT.MT_ID
                   AND BDT.BARCODE_NO = LOT.BARCODE_PRV_NO(+)
                   AND BMT.LZ_PRODUCT_INV_ID = A.LZ_PRODUCT_INV_ID
                   AND (BDT.DISCARD_COND IS NULL OR LOT.CONDITION_ID != -1)) LIST_JEANNIE

  FROM LZ_PRODUCT_INV_MT A,
       LZ_PRODUCT_MT     PROMT,
       LZ_ITEMS_MT       B,
       LZ_ITEM_COND_MT   CONMT,
       LZ_MERCHANT_PRO   MP,
       LZ_MERCHANT_MT    MM,
       EMPLOYEE_MT       EMP
 WHERE B.LZ_ITEMS_MT_ID = A.LZ_ITEMS_MT_ID
   AND PROMT.LZ_PRODUCT_ID = B.LZ_PRODUCT_ID
   AND PROMT.LZ_PRODUCT_ID = MP.PRODUCT_ID
   AND MM.MERCHANT_ID = MP.MERCHANT_ID
   AND B.CONDITION_ID = CONMT.ID
   AND A.CREATED_BY = EMP.EMPLOYEE_ID
   AND B.LZ_PRODUCT_ID = MP.PRODUCT_ID
   AND MP.MERCHANT_ID = $merch_id
   AND MP.CREATED_BY = $userId
   AND (A.DISCARD_COND IS NULL OR A.DISCARD_COND != -1) 
   ORDER BY A.LZ_PRODUCT_INV_ID DESC")->result_array();

        if($allRecords){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures($allRecords,$conditions);
            $images = $uri['uri'];

            return array( "show" => true, "message"=>"Records Found", "allRecords" => $allRecords, "accounts" => $accounts, "images" => $images );
        }else{
            return array( "show" => false, "message"=>"No records in inventory", "allRecords" => "",  "accounts" => "" );
        }
    }
    public function get_products(){
        $getAll = $this->db->query("SELECT * FROM LZ_PRODUCT_MT")->result_array();

        return $getAll;
    }
    public function saveNewInventory(){
        $product_id   = $this->input->post("product_id");
        $merchant_id   = $this->input->post("merchant_id");
        $accountId   = $this->input->post("AccountId");
        $condition_id   = $this->input->post("condition_id");
        $lz_items_id   = $this->input->post("lz_items_id");
        $qty   = $this->input->post("qty");
        $cost   = $this->input->post("cost");
        $userId   = $this->input->post("userId");
        $BinNo   = $this->input->post("BinNo");
        
        if(!$qty || $qty == 0){
            return array( "insert" => false, "message" => "Please enter quantity!" );
        }
        if(!$cost || $cost == 0){
            $cost = 0;
        }
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $LZ_ITEM_MT_ID = $lz_items_id;
        $lz_product_inv_mt_insert = "INSERT INTO LZ_PRODUCT_INV_MT VALUES(get_single_primary_key('LZ_PRODUCT_INV_MT','LZ_PRODUCT_INV_ID'),$LZ_ITEM_MT_ID,$cost,$qty,$userId,$insert_date,$condition_id)";
        $insert = $this->db->query($lz_product_inv_mt_insert);
        
        $insert_id =$this->db->query("SELECT MAX(LZ_PRODUCT_INV_ID) as inserted_id FROM LZ_PRODUCT_INV_MT")->result_array();
        $lz_product_inv_id = $insert_id[0]['INSERTED_ID'];

        $barcodeGenerated = $this->generateBarcode($product_id,$condition_id,$merchant_id,$insert_date,$userId,$qty,$cost,$lz_product_inv_id,$accountId,$cost,$BinNo);
        $MT_ID = "";
        $allBarcodes = "";
        if(@$barcodeGenerated['generated']){
                $MT_ID = $barcodeGenerated['MT_ID'];
                $allBarcodes = $barcodeGenerated['allBarcodes'];
            }
        return array('insert' => true, 'message' => "Inventory added successfully", 'MT_ID' => $MT_ID, "allBarcodes" => $allBarcodes );

    }
    public function getAllProducts(){
        $merch_id = $this->input->post("merch_id");
        $userId   = $this->input->post("userId");

        $allinventory  = $this->db->query("SELECT *
  FROM (SELECT A.LZ_PRODUCT_ID,
               B.LZ_ITEMS_MT_ID,
               E.MERCHANT_ID,
               E.SELLER_SKU,
               C.ID,
               C.COND_NAME,
               A.UPC,
               A.MANUFACTURER,
               A.MPN_DESCRIPTION,
               A.MPN,
               TO_CHAR(B.CREATED_AT,'DD-MM-YY HH24:MI:SS') CREATED_AT,
               
               (SELECT CASE
                         WHEN Count(barmt.ebay_item_id) =
                              count(bdt.barcode_no) and Count(barmt.ebay_item_id) != 0 THEN
                          'Listed'
                         WHEN Count(barmt.ebay_item_id) > 0 and
                              Count(barmt.ebay_item_id) <
                              count(bdt.barcode_no) THEN
                          'Partially Listed'
                         WHEN Count(lot.lz_manifest_det_id) = 0 THEN
                          'Not Listed'
                         WHEN count(lot.pic_date_time) != 0 and count(lot.pic_by) != 0 THEN
                          'Process Completed'
                       END status
                  FROM lz_product_inv_mt      pmt,
                       lz_merchant_barcode_mt bmt,
                       lz_merchant_barcode_dt bdt,
                       lz_barcode_mt          barmt,
                       lz_special_lots        lot
                 WHERE pmt.lz_product_inv_id = bmt.lz_product_inv_id
                   and bmt.mt_id = bdt.mt_id
                   and barmt.barcode_no(+) = bdt.barcode_no
                   and bdt.barcode_no = lot.barcode_prv_no(+)
                   and B.LZ_ITEMS_MT_ID = pmt.lz_items_mt_id) status,
               
               (SELECT Count(bdt.barcode_no)
                  FROM lz_product_inv_mt      pmt,
                       lz_merchant_barcode_mt bmt,
                       lz_merchant_barcode_dt bdt,
                       lz_special_lots        l
                 WHERE pmt.lz_product_inv_id = bmt.lz_product_inv_id
                   and bmt.mt_id = bdt.mt_id
                   and bdt.barcode_no = l.barcode_prv_no
                   and B.LZ_ITEMS_MT_ID = pmt.lz_items_mt_id
                   and (bdt.discard_cond is null or l.condition_id != -1)) QTY,
               (SELECT sum(bdt.cost)
                  FROM lz_product_inv_mt      pmt,
                       lz_merchant_barcode_mt bmt,
                       lz_merchant_barcode_dt bdt,
                       lz_special_lots        l
                 WHERE pmt.lz_product_inv_id = bmt.lz_product_inv_id
                   and bmt.mt_id = bdt.mt_id
                   and bdt.barcode_no = l.barcode_prv_no
                   and B.LZ_ITEMS_MT_ID = pmt.lz_items_mt_id
                   and (bdt.discard_cond is null or l.condition_id != -1)) COST
          FROM LZ_PRODUCT_MT   A,
               LZ_ITEMS_MT     B,
               LZ_ITEM_COND_MT C,
               LZ_MERCHANT_PRO E
         WHERE A.LZ_PRODUCT_ID = B.LZ_PRODUCT_ID
           AND C.ID = B.CONDITION_ID
           AND B.LZ_PRODUCT_ID = E.PRODUCT_ID
           AND E.MERCHANT_ID = $merch_id
           AND E.CREATED_BY = $userId 
           ORDER BY A.LZ_PRODUCT_ID DESC)
           ")->result_array();
        
        $accounts = $this->db->query("SELECT * FROM LJ_MERHCANT_ACC_DT B WHERE B.MERCHANT_ID = $merch_id")->result_array(); 
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 

        $uri = $this->get_pictures($allinventory,$conditions);
        $images = $uri['uri'];

        if($allinventory){
            return array( 'found' => true, 'allinventory' => $allinventory, 'message' => "", 'images' => $images,'accounts'=>$accounts );
        }else{
            return array( 'found' => false, 'allinventory' => "", 'message' => "Inventory is empty", 'images' => "",'accounts'=>"" );
        }
    }
    public function search_product(){
        $searchValue = $this->input->post("searchValue");
        if(!$searchValue){
        return array('search' => false, 'message' => "Search is empty!", 'products' => "", 'conditions' => "", 'merchant' => "");
      }
      $str  = explode(' ',$searchValue);
      $description = "";
      $title = "";
      $i=1;
        foreach ($str as $key) {
          if($i === 1){
            $description.="  UPPER(A.MPN_DESCRIPTION) LIKE UPPER('%$key%')";
            $title.=" UPPER(SE.ITEM_TITLE) LIKE UPPER('%$key%') ";
          }else{
            $description.=" AND  UPPER(A.MPN_DESCRIPTION) LIKE '%$key%' ";
            $title.=" AND UPPER(SE.ITEM_TITLE) LIKE UPPER('%$key%') ";
          }
          $i++;
        }

      $search_query = "SELECT distinct MAX(LZ_PRODUCT_ID) LZ_PRODUCT_ID,
       MAX(UPC) UPC,
       MAX(MPN) MPN,
       MAX(MPN_DESCRIPTION) MPN_DESCRIPTION,
       MAX(STATUS) STATUS,
       MAX(MANUFACTURER) MANUFACTURER
  FROM ((SELECT A.LZ_PRODUCT_ID LZ_PRODUCT_ID,
                A.UPC,
                A.MPN,
                A.MPN_DESCRIPTION,
                       'react_product' STATUS,
                       A.MANUFACTURER
                  FROM LZ_PRODUCT_MT   A,
                       LZ_MERCHANT_PRO C,
                       LZ_ITEMS_MT     D
                 WHERE A.LZ_PRODUCT_ID = C.PRODUCT_ID(+)
                   AND A.LZ_PRODUCT_ID = D.LZ_PRODUCT_ID(+)
                   AND (A.UPC LIKE '$searchValue%' OR
                       UPPER(A.MPN) LIKE UPPER('%$searchValue%') OR
                       ($description) )
                   AND (a.upc is not null or a.mpn is not null))
        
        UNION ALL
        
        SELECT *
          FROM (SELECT   --DISTINCT SE.SEED_ID,
          1,
                         SE.F_UPC,
                         SE.F_MPN,
                         SE.ITEM_TITLE,
                       'php_seed' STATUS,
                       SE.F_MANUFACTURE
                  FROM LZ_ITEM_SEED SE
                 WHERE (SE.F_UPC LIKE '$searchValue%' OR
                       UPPER(SE.F_MPN) LIKE UPPER('%$searchValue%') OR
                       ($title) )
                   AND (se.f_upc is not null or se.f_mpn is not null)
                 ORDER BY SE.SEED_ID DESC))
 WHERE ROWNUM <= 20
 GROUP BY LZ_PRODUCT_ID
";

    $filterProducts = $this->db->query($search_query)->result_array();

        $conditions = "";
        if($filterProducts){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures($filterProducts,$conditions);
            $images = $uri['uri'];
            return array('search' => true, 'message' => "Record found!", 'products' => $filterProducts, 'conditions' => $conditions, 'images' => $images );
        }else{
            return array('search' => false, 'message' => "Not found! Click on 'Add New Product' button to create new product ", 'products' => $filterProducts, 'conditions' => "", 'merchant' => "", 'images' => "" );
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
        $j=0;
        if($images){
		foreach($images as $image){
            
            $withoutMasterPartUri = str_replace("D:/wamp/www/","",$image);
            $withoutMasterPartUri = preg_replace("/[\r\n]*/","",$withoutMasterPartUri);
            $uri[$product['LZ_PRODUCT_ID']][$j] = $base_url. $withoutMasterPartUri;
            
            $j++;
        }  
        }else{
                $uri[$product['LZ_PRODUCT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['LZ_PRODUCT_ID']][1] = false;
            }  
    }else{
        $uri[$product['LZ_PRODUCT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['LZ_PRODUCT_ID']][1] = false;
    }
}


	return array('uri'=>$uri);
    }
    public function getCondition(){
        $conditionId = $this->input->post("condition");
        $productId   = $this->input->post("productId");
        $userId    = $this->input->post("userId");
        $merch_id    = $this->input->post("merch_id");
        $accounts = $this->db->query("SELECT * FROM LJ_MERHCANT_ACC_DT B WHERE B.MERCHANT_ID = $merch_id")->result_array();

        $conditionOfProduct = $this->db->query("SELECT * FROM LZ_ITEMS_MT WHERE LZ_PRODUCT_ID = $productId AND CREATED_BY = $userId AND CONDITION_ID = $conditionId ")->result_array();
        $merchant_pro = $this->db->query("SELECT A.SELLER_SKU, A.VENDOR_SKU FROM LZ_MERCHANT_PRO A WHERE A.PRODUCT_ID = $productId AND A.MERCHANT_ID = $merch_id AND A.CREATED_BY = $userId")->result_array();
        return array( "conditionOfProduct" => $conditionOfProduct, "accounts" => $accounts, "sku" => $merchant_pro );

    }
    public function add_invventory(){
        $cost       = $this->input->post("cost");
        $qty        = $this->input->post("qty");
        $accountId  = $this->input->post("accountId");
        $condition  = $this->input->post("condition");
        $product_id = $this->input->post("product_id");
        $userId     = $this->input->post("userId");
        $merchant   = $this->input->post("merchant");
        $seller_sku = $this->input->post("seller_sku");
        $vendor_sku = $this->input->post("vendor_sku");
        $BinNo      = $this->input->post("BinNo");

        if( !$qty ){
            $qty = 0;
        }
        if( !$cost ){
            $cost = 0;
        }

        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $alreadExistMerchant = $this->db->query("SELECT * FROM LZ_MERCHANT_PRO WHERE PRODUCT_ID = $product_id AND MERCHANT_ID = $merchant ")->result_array();

        if(!$alreadExistMerchant){
            $lz_merchant_pro_insert = "INSERT INTO LZ_MERCHANT_PRO VALUES(get_single_primary_key('LZ_MERCHANT_PRO','LZ_MERCHANT_PRO_ID'),$product_id,$merchant,$userId,$insert_date,'$seller_sku','$vendor_sku')";
        $insert = $this->db->query($lz_merchant_pro_insert);

        }else{
            
            $where_id = $alreadExistMerchant[0]['LZ_MERCHANT_PRO_ID'];
            $s_sku = "";
            $v_sku = "";
            if( $seller_sku ){
                $s_sku = $seller_sku;
            }else{
                $s_sku = $alreadExistMerchant[0]['SELLER_SKU'];
            }
            if( $vendor_sku ){
                $v_sku = $vendor_sku;
            }else{
                $v_SKU = $alreadExistMerchant[0]['VENDOR_SKU'];
            }
            $lz_merchant_pro_update = "UPDATE LZ_MERCHANT_PRO SET SELLER_SKU = '$s_sku', VENDOR_SKU = '$v_sku' WHERE LZ_MERCHANT_PRO_ID = $where_id";
            $updateMerchant = $this->db->query($lz_merchant_pro_update);
            
        }
        
        $alreadExistItem = $this->db->query("SELECT * FROM LZ_ITEMS_MT WHERE LZ_PRODUCT_ID = $product_id AND CONDITION_ID = $condition AND CREATED_BY = $userId ")->result_array();
        if($alreadExistItem){
             $barcodeGenerated = "";
            $MT_ID = "";
            $allBarcodes = "";
            if( $qty > 0 ){
            $LZ_ITEM_MT_ID = $alreadExistItem[0]['LZ_ITEMS_MT_ID'];
        $lz_product_inv_mt_insert = "INSERT INTO LZ_PRODUCT_INV_MT VALUES(get_single_primary_key('LZ_PRODUCT_INV_MT','LZ_PRODUCT_INV_ID'),$LZ_ITEM_MT_ID,$cost,$qty,$userId,$insert_date,$condition)";
        $insert = $this->db->query($lz_product_inv_mt_insert);

       $insert_id =$this->db->query("SELECT MAX(LZ_PRODUCT_INV_ID) as inserted_id FROM LZ_PRODUCT_INV_MT")->result_array();
        $lz_product_inv_id = $insert_id[0]['INSERTED_ID'];
        
        $barcodeGenerated = $this->generateBarcode($product_id,$condition,$merchant,$insert_date,$userId,$qty,$cost,$lz_product_inv_id,$accountId,$cost,$BinNo);
        if(@$barcodeGenerated['generated']){
                $MT_ID = $barcodeGenerated['MT_ID'];
                $allBarcodes = $barcodeGenerated['allBarcodes'];
            }
            
        return array('insert' => true, 'message' => "Inventory added successfully", 'MT_ID' => $MT_ID, "allBarcodes" => $allBarcodes );
        }else{
            return array('insert' => false, 'message' => "Product already exist!", 'MT_ID' => "" );
        }

        }else{
            $query = "INSERT INTO LZ_ITEMS_MT VALUES(get_single_primary_key('LZ_ITEMS_MT','LZ_ITEMS_MT_ID'),$product_id,'$condition',$userId,$insert_date)";
            $insert = $this->db->query($query);
            if ( $insert )
            {
                $barcodeGenerated = "";
                $MT_ID = "";
                $allBarcodes = "";
                $insert_id =$this->db->query("SELECT MAX(LZ_ITEMS_MT_ID) as inserted_id FROM LZ_ITEMS_MT")->result_array();
                $LZ_ITEMS_MT_ID = $insert_id[0]['INSERTED_ID'];
                if( $qty > 0 ){
                $lz_product_inv_mt_insert = "INSERT INTO LZ_PRODUCT_INV_MT VALUES(get_single_primary_key('LZ_PRODUCT_INV_MT','LZ_PRODUCT_INV_ID'),$LZ_ITEMS_MT_ID,$cost,$qty,$userId,$insert_date,$condition)";
                $insert = $this->db->query($lz_product_inv_mt_insert);
                
                $insert_inv_id =$this->db->query("SELECT MAX(LZ_PRODUCT_INV_ID) as inserted_id FROM LZ_PRODUCT_INV_MT")->result_array();
                 $lz_product_inv_id = $insert_inv_id[0]['INSERTED_ID'];
                
                $barcodeGenerated = $this->generateBarcode($product_id,$condition,$merchant,$insert_date,$userId,$qty,$cost,$lz_product_inv_id,$accountId,$cost,$BinNo);
                if(@$barcodeGenerated['generated']){
                        $MT_ID = $barcodeGenerated['MT_ID'];
                        $allBarcodes = $barcodeGenerated['allBarcodes'];
                    }
                return array('insert' => true, 'message' => "Item created and Inventory added successfully!", 'MT_ID' => $MT_ID, "allBarcodes" => $allBarcodes );
                }else{
                    
                    return array('insert' => true, 'message' => "Item created", 'MT_ID' => "");
                }
            }else{
            return array('insert' => false, 'message' => "Something went wrong! Report to admin");
            }
        }
    }

    public function generateBarcode($productId,$conditionId,$merchantId,$issuedDate,$issuedBy,$noOfBarcode,$cost,$lz_product_inv_id,$accountId,$cost,$BinNo){
        $lz_merchant_barcode_mt = "INSERT INTO LZ_MERCHANT_BARCODE_MT(MT_ID,MERCHANT_ID,ISSUED_DATE,ISSUED_BY,NO_OF_BARCODE,LZ_PRODUCT_INV_ID) VALUES(get_single_primary_key('LZ_MERCHANT_BARCODE_MT','MT_ID'),$merchantId,$issuedDate,$issuedBy,$noOfBarcode,$lz_product_inv_id)";
        $inserted = $this->db->query($lz_merchant_barcode_mt);
        if($inserted){
            $insert_id =$this->db->query("SELECT MAX(MT_ID) as inserted_id FROM LZ_MERCHANT_BARCODE_MT")->result_array();
            $MT_ID = $insert_id[0]['INSERTED_ID'];

            $lz_product_mt = "select * from LZ_PRODUCT_MT where lz_product_id = $productId";
            $product = $this->db->query($lz_product_mt)->result_array();
            $card_upc = $product[0]['UPC'];
            $card_mpn = $product[0]['MPN'];
            $brand    = $product[0]['MANUFACTURER'];
            $mpn_description = $product[0]['MPN_DESCRIPTION'];

            $barcodes_array = '';
            for($i = 1; $i <= $noOfBarcode; $i++){
                $barcodeQuery = "SELECT SEQ_BARCODE_NO.NEXTVAL AS BARCODE FROM DUAL";
                $barcodeValue = $this->db->query($barcodeQuery)->result_array();
                $barcode = $barcodeValue[0]['BARCODE'];
                if($i == $noOfBarcode){
                    $barcodes_array .= $barcode;
                }else{
                    $barcodes_array .= $barcode .',';
                }
            $lz_merchant_barcode_dt = "INSERT INTO LZ_MERCHANT_BARCODE_DT(DT_ID,MT_ID,BARCODE_NO,COST,ACCOUNT_ID) VALUES(get_single_primary_key('LZ_MERCHANT_BARCODE_DT','DT_ID'),$MT_ID,$barcode,$cost,$accountId)";
            $this->db->query($lz_merchant_barcode_dt);
            $special_lot = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_SPECIAL_LOTS','SPECIAL_LOT_ID') SPECIAL_LOT_ID FROM DUAL")->result_array();
            $special_lot_id = $special_lot[0]['SPECIAL_LOT_ID'];

            $lz_special_lots = "INSERT INTO LZ_SPECIAL_LOTS(SPECIAL_LOT_ID,BARCODE_PRV_NO,CONDITION_ID,MPN_DESCRIPTION,CARD_UPC,CARD_MPN,INSERTED_AT,INSERTED_BY,BRAND,ITEM_COST) 
            VALUES($special_lot_id,$barcode,$conditionId,'$mpn_description','$card_upc','$card_mpn',$issuedDate,$issuedBy,'$brand',$cost)";
            $this->db->query($lz_special_lots);
            
                if($merchantId == 1){
                    $result = $this->post_item($card_upc,$card_mpn,$barcode,$special_lot_id,$cost,$issuedBy,$brand,$BinNo);
                }
            
            }
            $allGeneratedBarcodes = $this->db->query("SELECT D.BARCODE_NO, M.RANGE_ID, M.MERCHANT_ID
                                                        FROM LZ_MERCHANT_BARCODE_MT M, LZ_MERCHANT_BARCODE_DT D
                                                        WHERE M.MT_ID = D.MT_ID
                                                        AND M.MT_ID = $MT_ID")->result_array();

            return array( "generated" => true, 'MT_ID' => $MT_ID, "allBarcodes" => $allGeneratedBarcodes );
        }else{
            return false;
        }
    }
    public function printBarcode(){
    $dt_id = $this->uri->segment(4);
    return $this->db->query("SELECT B.ISSUED_DATE, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT         MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+)AND D.DT_ID = $dt_id")->result_array();
  }
  public function printAllBarcode(){

    $mt_id = $this->input->post('barcode_mt_id');

    return $this->db->query("SELECT B.ISSUED_DATE,B.NO_OF_BARCODE,B.RANGE_ID, D.BARCODE_NO, MM.BUISNESS_NAME,L.LOT_ID,L.LOT_DESC,L.REF_NO FROM LZ_MERCHANT_BARCODE_MT B, LZ_MERCHANT_BARCODE_DT D, LZ_MERCHANT_MT   MM, LOT_DEFINATION_MT L WHERE B.MERCHANT_ID = MM.MERCHANT_ID AND B.MT_ID = D.MT_ID AND B.LOT_ID = L.LOT_ID(+)AND D.MT_ID = $mt_id ORDER BY BARCODE_NO ASC")->result_array();
  }
    public function printAllStickers($MT_ID){  	
	   
	    $print_qry = $this->db->query("SELECT SP.BARCODE_PRV_NO,'R#' || TO_DATE(SP.Inserted_At,'YYYY-MM-DD') REF_DATE,ROWNUM as UNIT_NO,SP.MPN_DESCRIPTION,mt.no_of_barcode, sp.card_upc  
FROM LZ_MERCHANT_BARCODE_MT mt,
     LZ_MERCHANT_BARCODE_DT dt,
     LZ_SPECIAL_LOTS sp
where mt.mt_id = dt.mt_id
and dt.barcode_no = sp.barcode_prv_no
and mt.mt_id = $MT_ID")->result_array();  
	    // var_dump($print_qry); exit;
	    return $print_qry;
      }
    
/*======================================
=            ADIL METHODS            =
======================================*/

public function serch_mpn_sys($mpn){
	$card_mpn = strtoupper($mpn);	
 
 $desc_mpn = "SELECT * FROM (SELECT S.SEED_ID, S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME, O.OBJECT_ID, S.DEFAULT_COND FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) and UPPER(I.ITEM_MT_MFG_PART_NO) LIKE '%$card_mpn%' order by s.seed_id desc ) WHERE ROWNUM <=1";	 

	  $desc_mpn_quer = $this->db->query($desc_mpn)->result_array();

	   return $desc_mpn_quer;

}


public function serch_upc_sys($upc){
	 $card_upc = strtoupper($upc);	
 
 $desc_upc = "SELECT * FROM (SELECT S.SEED_ID, S.ITEM_TITLE  TITLE, DECODE(S.CATEGORY_ID,NULL,O.CATEGORY_ID,S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, I.ITEM_MT_UPC  UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME, O.OBJECT_ID, S.DEFAULT_COND  FROM LZ_ITEM_SEED S, ITEMS_MT I, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) and UPPER(ITEM_MT_UPC) LIKE '%$card_upc%' order by s.seed_id desc ) WHERE  ROWNUM <=1 ";	 
	 
	   $desc_upc_quer = $this->db->query($desc_upc)->result_array();

	   return $desc_upc_quer;
}

public function post_item($upc,$mpn,$barcode,$special_lot_id,$get_cost,$user_id,$brand,$BinNo){
    $product = "";
    if($mpn){
        $product = $this->serch_mpn_sys($mpn);
    }else if($upc)
    {
        $product = $this->serch_upc_sys($upc);
    }

    if($product){
        $seed_id = $product[0]['SEED_ID'];

        $allSeedData = $this->db->query("SELECT OB.OBJECT_ID,
                                                S.CATEGORY_ID,
                                                NULL REMARKS,
                                                OB.WEIGHT,
                                                S.DEFAULT_COND,
                                                C.CATALOGUE_MT_ID,
                                                S.F_UPC UPC,
                                                S.F_MPN MPN,
                                                S.F_MANUFACTURE,
                                                S.ITEM_TITLE
                                            FROM LZ_ITEM_SEED S, ITEMS_MT IT, LZ_BD_OBJECTS_MT OB, LZ_CATALOGUE_MT C
                                            WHERE S.ITEM_ID = IT.ITEM_ID
                                            AND UPPER(TRIM(IT.ITEM_MT_MFG_PART_NO)) = UPPER(TRIM(C.MPN))
                                            AND OB.OBJECT_ID = C.OBJECT_ID
                                            AND S.CATEGORY_ID = OB.CATEGORY_ID
                                            AND S.SEED_ID = $seed_id
                                            ")->result_array();

    if(!$allSeedData){
        return array("message" => "No data found");
    }

	$card_upc = strtoupper($allSeedData[0]['UPC']);
	$upc = trim(str_replace("  ", ' ', $card_upc));
    $card_upc = str_replace("'", "''", $upc);

    $get_card_category = strtoupper($allSeedData[0]['CATEGORY_ID']);
	$get_card_category = trim(str_replace("  ", ' ', $get_card_category));
    $get_card_category = str_replace("'", "''", $get_card_category);

	$card_mpn = strtoupper($allSeedData[0]['MPN']);
	$mpn = trim(str_replace("  ", ' ', $card_mpn));
    $card_mpn = str_replace("'", "''", $mpn);

    $cond_id = $allSeedData[0]['DEFAULT_COND']; 

    $object_desc = $allSeedData[0]['OBJECT_ID'];
    
    $bin_rack = "";
    if($BinNo){
        $bin_rack = $BinNo;
    }else{
        $bin_rack = 0;
    }

    $item_cost   = $get_cost;
    $item_weight = $allSeedData[0]['WEIGHT'];

    if(!$object_desc){
        return array("message" => "No object found");
    }

	$dek_remarks = '';
	$dek_remark = trim(str_replace("  ", ' ', $dek_remarks));
    $dek = str_replace("'", "''", $dek_remark);

        $brand_name = strtoupper($allSeedData[0]['F_MANUFACTURE']);
	$brand2 = trim(str_replace("  ", ' ', $brand_name));
    $brand_name =str_replace("'", "''", $brand2);

    $mpn_description = $allSeedData[0]['ITEM_TITLE'];
	$mpn_desc = trim(str_replace("  ", ' ', $mpn_description));
    $mpn_description =str_replace("'", "''", $mpn_desc);

    $pic_notes = '';
	$pic_note = trim(str_replace("  ", ' ', $pic_notes));
    $pic_not =str_replace("'", "''", $pic_note);
    
	date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $dekit_date  = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $catalogue_mt_id = $allSeedData[0]['CATALOGUE_MT_ID'];

    $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 1");
               $master_qry = $query->result_array();
               $master_path = $master_qry[0]['MASTER_PATH'];

                $card_mpn = str_replace("/","_",$card_mpn);

                $pictureCondition  = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT WHERE ID = '$cond_id' ")->result_array();
                $cond_name  = $pictureCondition[0]['COND_NAME'];

            $dir = $master_path.$card_upc."~".$card_mpn."/".$cond_name."/";

           if($dir == $master_path."~/".$cond_name."/"){
                $dir = $master_path."/".$cond_name."/";
            }

    $dir = preg_replace("/[\r\n]*/","",$dir);

	if (is_dir($dir)){
        
		$images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
        $j=0;

        if($images){
            $barcodePath = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2")->result_array();
            $barcode_path = $barcodePath[0]['MASTER_PATH'];
            $new_dir   = $barcode_path.$barcode;
            $thumb_dir = $barcode_path.$barcode.'/thumb';

            if(!is_dir($new_dir)){
                mkdir($new_dir);
                mkdir($thumb_dir);
            }
		foreach($images as $image){
            
            $withoutMasterPartUri = preg_replace("/[\r\n]*/","",$image);
            $str = explode('.', $withoutMasterPartUri);
            $extension = end($str);
            copy($withoutMasterPartUri,$new_dir.'/'.$barcode.'_'.$j.'.'.$extension);
            copy($withoutMasterPartUri,$new_dir.'/thumb'.'/'.$barcode.'_'.$j.'.'.$extension);
            $j++;
        }
       
        }
     
    }else{
        
        return array("message" => "Picture not found");
    }
    
    	$insert_est_det = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET OBJECT_ID = $object_desc,CARD_CATEGORY_ID = '$get_card_category', LOT_REMARKS = '$dek' , WEIGHT = '$item_weight',CONDITION_ID = $cond_id, BIN_ID = $bin_rack, PIC_DATE_TIME = $dekit_date, PIC_BY = $user_id, FOLDER_NAME = $barcode, CARD_UPC = '$card_upc', CARD_MPN = '$card_mpn', CATALOG_MT_ID = '$catalogue_mt_id', MPN_DESCRIPTION = '$mpn_description', BRAND = '$brand_name', UPDATED_AT = $dekit_date, UPDATED_BY = $user_id, ITEM_COST = '$get_cost' , PIC_NOTES = '$pic_not',AVG_SOLD = '$get_cost', LISTED_YN = 1  WHERE SPECIAL_LOT_ID = $special_lot_id AND LZ_MANIFEST_DET_ID IS NULL");

    /*=====  End of update all barcode with same folder name  ======*/
         $procedureQuery = '';
	if(!empty($card_upc) AND !empty($card_mpn)){

		$procedureQuery = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' ,  '=''$card_mpn''', $user_id) ");


	}elseif (!empty($card_upc) AND empty($card_mpn)) {

		$procedureQuery = $this->db->query("call PRO_SINGLE_INSERT_LOTS('=''$card_upc''' , ' IS NULL', $user_id) ");


	}elseif (empty($card_upc) AND !empty($card_mpn)) {

		$procedureQuery = $this->db->query("call PRO_SINGLE_INSERT_LOTS(' IS NULL' , '=''$card_mpn''', $user_id) ");


	}elseif (empty($card_upc) AND empty($card_mpn)) {

        return array("message" => "UPC and Mpn is required");
	}

    if($procedureQuery){
        $checks = $this->db->query("SELECT IT.ITEM_ID, A.CONDITIONS_SEG5, A.LZ_MANIFEST_ID
                       FROM LZ_MANIFEST_DET A, ITEMS_MT IT
                      WHERE A.LAPTOP_ITEM_CODE = IT.ITEM_CODE
                        AND A.LAPTOP_ZONE_ID =
                            (SELECT L.LZ_MANIFEST_DET_ID
                               FROM LZ_SPECIAL_LOTS L
                              WHERE L.SPECIAL_LOT_ID = $special_lot_id
                                 OR L.BARCODE_PRV_NO = $barcode)")->result_array();
        $item_id         = $checks[0]['ITEM_ID']; 
        $conditions_seg5 = $checks[0]['CONDITIONS_SEG5']; 
        $lz_manifest_id  = $checks[0]['LZ_MANIFEST_ID']; 

       $seed_status = $this->db->query("UPDATE LZ_ITEM_SEED S SET S.SEED_STATUS = 1
                                        WHERE S.ITEM_ID = $item_id
                                        AND S.DEFAULT_COND = $conditions_seg5
                                        AND S.LZ_MANIFEST_ID = $lz_manifest_id ");

    	return array("message" => "item Posted");
    }else{
    	return array("message" => "We could not post your item because of some issue");
    }

   } 

}

    }
?>	