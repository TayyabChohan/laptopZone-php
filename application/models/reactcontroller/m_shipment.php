<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_shipment extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function getAllShipment(){
        $userId   = $this->input->post("userId");
        $merch_id = $this->input->post("merch_id");

        $allShipments = $this->db->query("SELECT SM.SHIPMENT_ID,
                                                SM.MERCHANT_ID,
                                                (SELECT COUNT(B.TRACKING_NO) FROM LJ_SHIPMENT_BOX B WHERE B.SHIPMENT_ID = SM.SHIPMENT_ID AND B.TRACKING_NO IS NOT NULL) TOTAL_TRACKING_NO,
                                                SM.SHIPMENT_DESC,
                                                SM.REMARKS,
                                                SM.CREATED_AT,
                                                EMP.FIRST_NAME,
                                                MMT.BUISNESS_NAME,
                                                (SELECT COUNT(SBOX.BOX_NO) FROM LJ_SHIPMENT_BOX SBOX WHERE SBOX.SHIPMENT_ID = SM.SHIPMENT_ID) BOXES
                                                    FROM LJ_SHIPMENT_MT SM, EMPLOYEE_MT EMP, LZ_MERCHANT_MT MMT
                                                WHERE EMP.EMPLOYEE_ID = SM.CREATED_BY
                                                AND MMT.MERCHANT_ID = SM.MERCHANT_ID
                                                AND SM.CREATED_BY = $userId
                                                AND SM.MERCHANT_ID = $merch_id")->result_array();
       if($allShipments){
           return array( "found" => true, "allShipments"=>$allShipments );
       }else{
           return array( "found" => false, "message"=>"No records found!", "allShipments"=>"" );
       }
    }
    public function getAllBoxes(){
         $shipment_id = $this->input->post("shipment_id");

        $allBoxes = $this->db->query("SELECT BOX.SHIP_BOX_ID,
       BOX.SHIPMENT_ID,
       BOX.BOX_NO,
       BOX.TRACKING_NO,
       (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
       BOX.CARRIER,
       BOX.CREATED_BY,
       BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
       WHERE BOX.SHIPMENT_ID = $shipment_id 
       ORDER BY BOX.BOX_NO")->result_array();
       if($allBoxes){
           return array( "found" => true, "allBoxes"=>$allBoxes );
       }else{
           return array( "found" => false, "message"=>"No records found!", "allBoxes"=>"");
       }
    }
    public function deleteShipment(){
        $shipment_id = $this->input->post("shipment_id");

         $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT WHERE SHIP_BOX_ID IN (SELECT SHIP_BOX_ID FROM LJ_SHIPMENT_BOX WHERE SHIPMENT_ID = $shipment_id )");
         $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP WHERE SHIPMENT_ID = $shipment_id");
         $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX WHERE SHIPMENT_ID = $shipment_id");
         $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_MT WHERE SHIPMENT_ID = $shipment_id");
          
       if($delete){
           return array( "delete" => true, "message" => "Shipment successfully deleted!" );
       }else{
           return array( "delete" => false, "message"=>"Something went wrong!");
       }
    }
    public function handleBoxDelete(){
         $ship_box_id = $this->input->post("ship_box_id");

         $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT WHERE SHIP_BOX_ID = $ship_box_id ");
         $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX WHERE SHIP_BOX_ID = $ship_box_id");
          
       if($delete){
           return array( "delete" => true, "message" => "Box successfully deleted!" );
       }else{
           return array( "delete" => false, "message"=>"Something went wrong!");
       }
    }
    public function getAllBoxesBarcodes(){
         $ship_box_id = $this->input->post("ship_box_id");
        
         $shipment = $this->db->query("SELECT SHIPMENT_ID FROM LJ_SHIPMENT_BOX WHERE SHIP_BOX_ID = $ship_box_id")->result_array();

         $shipment_id = "";
        if($shipment){
            $shipment_id = $shipment[0]['SHIPMENT_ID'];
        }

        $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP WHERE SHIPMENT_ID =  $shipment_id");

        $allBoxBarcodes = $this->db->query("SELECT BOXDT.SHIP_DT_ID,
       BOXDT.BARCODE_NO,
       LOT.CARD_UPC UPC,
       LOT.CARD_MPN MPN,
       LOT.MPN_DESCRIPTION,
       LOT.BRAND FROM LJ_SHIPMENT_BOX_DT BOXDT, LZ_SPECIAL_LOTS LOT
        WHERE  LOT.BARCODE_PRV_NO = BOXDT.BARCODE_NO
        AND BOXDT.SHIP_BOX_ID = $ship_box_id 
       ORDER BY BOXDT.SHIP_DT_ID")->result_array();
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($allBoxBarcodes,$conditions);
        $images = $uri['uri'];
       if($allBoxBarcodes){
           return array( "found" => true, "getAllBoxesBarcodes"=>$allBoxBarcodes,'images' => $images );
       }else{
           return array( "found" => false, "message"=>"No records found!", "getAllBoxesBarcodes"=>"", 'images' => "");
       }
    }
    public function addShipment(){
        $shipment_desc = $this->input->post("description");
        $shipment_desc = trim(str_replace("  ", ' ', $shipment_desc));
        $shipment_desc = str_replace("'",'"',$shipment_desc);

        $remarks       = $this->input->post("remarks");
        $remarks       = trim(str_replace("  ", ' ', $remarks));
        $remarks       = str_replace("'",'"',$remarks);

        $merch_id      = $this->input->post("merch_id");
        $userId        = $this->input->post("userId");

        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
    	$created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $insert = $this->db->query("INSERT INTO LJ_SHIPMENT_MT SM (SM.SHIPMENT_ID,
       SM.MERCHANT_ID,
       SM.SHIPMENT_DESC,
       SM.REMARKS,
       SM.CREATED_AT,
       SM.CREATED_BY) VALUES(
           GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_MT','SHIPMENT_ID'),
           $merch_id,
           '$shipment_desc',
           '$remarks',
           $created_at,
           $userId
       ) ");
       $lj_shipment_id = $this->db->query("SELECT MAX(SM.SHIPMENT_ID) SHIPMENT_ID FROM LJ_SHIPMENT_MT SM")->result_array();
       $shipment_id = $lj_shipment_id[0]['SHIPMENT_ID'];
       if($insert){
           return array("status" => $insert,"message" => "Shipment Details Added", "lj_shipment_id" => $shipment_id);
       }else{
           return array("status" => false, "message" => "Something went wrong!" , "lj_shipment_id" => "");
       }
    }
    public function updateShipment(){
        $shipment_desc = $this->input->post("description");
        $shipment_desc = trim(str_replace("  ", ' ', $shipment_desc));
        $shipment_desc = str_replace("'",'"',$shipment_desc);

        $remarks       = $this->input->post("remarks");
        $remarks       = trim(str_replace("  ", ' ', $remarks));
        $remarks       = str_replace("'",'"',$remarks);
        
        $merch_id      = $this->input->post("merch_id");
        $userId        = $this->input->post("userId");
        $shipment_id   = $this->input->post("shipment_id");
        
        $update = $this->db->query("UPDATE LJ_SHIPMENT_MT SM SET SM.SHIPMENT_DESC = '$shipment_desc', SM.REMARKS = '$remarks' WHERE SM.SHIPMENT_ID = $shipment_id");

        if($update){
           return array("status" => $update,  "message" => "Shipment Details Updated", "lj_shipment_id" => $shipment_id);
       }else{
           return array("status" => false, "message" => "Something went wrong!", "lj_shipment_id" => $shipment_id);
       }
    }
    public function addShipmentDtTmp(){
        $barcode     = $this->input->post("searchBarcode");
        $barcode     = trim(str_replace("  ", ' ', $barcode));
        $shipment_id = $this->input->post("shipment_id");
        $userId      = $this->input->post("userId");
        $merch_id    = $this->input->post("merch_id");

        
        $productAdded = $this->db->query("SELECT LOT.BARCODE_PRV_NO, CON.COND_NAME, LOT.CARD_UPC, LOT.CARD_MPN,LOT.MPN_DESCRIPTION,LOT.BRAND
                                            FROM LZ_SPECIAL_LOTS LOT, LZ_ITEM_COND_MT CON
                                            WHERE CON.ID = LOT.CONDITION_ID
                                            AND LOT.BARCODE_PRV_NO = $barcode
                                            AND LOT.CONDITION_ID != -1")->result_array();
        if($productAdded){
            $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            
        $alreadyExist = $this->db->query("SELECT TMP.BARCODE_NO
            FROM LJ_SHIPMENT_BOX_DT_TMP TMP
            WHERE TMP.INSERTED_BY = $userId
            AND TMP.SHIPMENT_ID = $shipment_id
            AND TMP.BARCODE_NO = $barcode
            UNION ALL
            SELECT DT.BARCODE_NO
            FROM LJ_SHIPMENT_BOX MT, LJ_SHIPMENT_BOX_DT DT
            WHERE MT.SHIP_BOX_ID = DT.SHIP_BOX_ID
            AND MT.SHIPMENT_ID = $shipment_id
            AND DT.BARCODE_NO = $barcode
            ")->result_array();

        $cehckHistory = $this->db->query(" SELECT BOX.SHIPMENT_ID, BOX.SHIP_BOX_ID, DT.BARCODE_NO 
        FROM LJ_SHIPMENT_BOX_DT DT, LJ_SHIPMENT_BOX BOX, LJ_SHIPMENT_MT MT 
        WHERE BOX.SHIP_BOX_ID = DT.SHIP_BOX_ID
        AND MT.SHIPMENT_ID = BOX.SHIPMENT_ID
        AND DT.BARCODE_NO = $barcode
        AND MT.MERCHANT_ID = $merch_id")->result_array();

        if($alreadyExist || $cehckHistory){
            $bar = "";
            if($alreadyExist){
                $bar = $alreadyExist[0]['BARCODE_NO'];
            }else{
                $bar = $cehckHistory[0]['BARCODE_NO'];
            }
            return array("status" => false, "message" => "Barcode No: $bar already Exist!");
        }else{
            $insert = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT_TMP TMP( TMP.SHIP_DT_TMP_ID,
                                TMP.BARCODE_NO,
                                TMP.INSERTED_AT,
                                TMP.INSERTED_BY,
                                TMP.SHIPMENT_ID) VALUES(
                                GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT_TMP','SHIP_DT_TMP_ID'),
                                $barcode,
                                $created_at,
                                $userId,
                                $shipment_id
                                )
                                ");
            $scanRecords = $this->db->query("SELECT TMP.SHIP_DT_TMP_ID, LOT.BARCODE_PRV_NO, CON.COND_NAME, LOT.CARD_UPC, LOT.CARD_MPN,LOT.MPN_DESCRIPTION,LOT.BRAND
                                            FROM LZ_SPECIAL_LOTS LOT, LZ_ITEM_COND_MT CON, LJ_SHIPMENT_BOX_DT_TMP TMP
                                            WHERE CON.ID = LOT.CONDITION_ID
                                            AND TMP.BARCODE_NO = LOT.BARCODE_PRV_NO
                                            AND TMP.INSERTED_BY = $userId
                                            AND TMP.SHIPMENT_ID = $shipment_id
                                            AND LOT.CONDITION_ID != -1
                                            ORDER BY TMP.SHIP_DT_TMP_ID DESC")->result_array();

            return array("status" => true, "message" => "Barcode added", "scanRecords" => $scanRecords);
            }
        }else{
            return array("status" => false, "message" => "No barcode found");
        }


    }
    public function editShipmentDtTmp(){
        $barcode     = $this->input->post("editBarcode");
        $barcode     = trim(str_replace("  ", ' ', $barcode));
        $shipment_id = $this->input->post("shipment_id");
        $ship_box_id = $this->input->post("ship_box_id");
        $userId      = $this->input->post("userId");
        $merch_id    = $this->input->post("merch_id");

        
        $productAdded = $this->db->query("SELECT LOT.BARCODE_PRV_NO, CON.COND_NAME, LOT.CARD_UPC, LOT.CARD_MPN,LOT.MPN_DESCRIPTION,LOT.BRAND
                                            FROM LZ_SPECIAL_LOTS LOT, LZ_ITEM_COND_MT CON
                                            WHERE CON.ID = LOT.CONDITION_ID
                                            AND LOT.BARCODE_PRV_NO = $barcode
                                            AND LOT.CONDITION_ID != -1")->result_array();
        if($productAdded){
            $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            
        $alreadyExist = $this->db->query("SELECT TMP.BARCODE_NO
            FROM LJ_SHIPMENT_BOX_DT_TMP TMP
            WHERE TMP.INSERTED_BY = $userId
            AND TMP.SHIPMENT_ID = $shipment_id
            AND TMP.BARCODE_NO = $barcode
            UNION ALL
            SELECT DT.BARCODE_NO
            FROM LJ_SHIPMENT_BOX MT, LJ_SHIPMENT_BOX_DT DT
            WHERE MT.SHIP_BOX_ID = DT.SHIP_BOX_ID
            AND MT.SHIPMENT_ID = $shipment_id
            AND DT.BARCODE_NO = $barcode
            ")->result_array();

        $cehckHistory = $this->db->query(" SELECT BOX.SHIPMENT_ID, BOX.SHIP_BOX_ID, DT.BARCODE_NO 
        FROM LJ_SHIPMENT_BOX_DT DT, LJ_SHIPMENT_BOX BOX, LJ_SHIPMENT_MT MT 
        WHERE BOX.SHIP_BOX_ID = DT.SHIP_BOX_ID
        AND MT.SHIPMENT_ID = BOX.SHIPMENT_ID
        AND DT.BARCODE_NO = $barcode
        AND MT.MERCHANT_ID = $merch_id")->result_array();

        if($alreadyExist || $cehckHistory){
            $bar = "";
            if($alreadyExist){
                $bar = $alreadyExist[0]['BARCODE_NO'];
            }else{
                $bar = $cehckHistory[0]['BARCODE_NO'];
            }
            return array("status" => false, "message" => "Barcode No: $bar already Exist!");
        }else{
            $insert = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT_TMP TMP( TMP.SHIP_DT_TMP_ID,
                                TMP.BARCODE_NO,
                                TMP.INSERTED_AT,
                                TMP.INSERTED_BY,
                                TMP.SHIPMENT_ID) VALUES(
                                GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT_TMP','SHIP_DT_TMP_ID'),
                                $barcode,
                                $created_at,
                                $userId,
                                $shipment_id
                                )
                                ");
            $box_details = $this->db->query("SELECT *
                                            FROM (SELECT TMP.SHIPMENT_ID,
                                                        TMP.SHIP_DT_TMP_ID SHIP_DT_ID,
                                                        TMP.BARCODE_NO,
                                                        CN.COND_NAME,
                                                        LT.CARD_UPC        UPC,
                                                        LT.CARD_MPN        MPN,
                                                        LT.MPN_DESCRIPTION,
                                                        LT.BRAND
                                                    FROM LJ_SHIPMENT_MT         SM,
                                                        LJ_SHIPMENT_BOX_DT_TMP TMP,
                                                        LZ_SPECIAL_LOTS        LT,
                                                        LZ_ITEM_COND_MT        CN
                                                    WHERE SM.SHIPMENT_ID = TMP.SHIPMENT_ID
                                                    AND TMP.BARCODE_NO = LT.BARCODE_PRV_NO
                                                    AND LT.CONDITION_ID = CN.ID
                                                    AND TMP.SHIPMENT_ID = $shipment_id
                                                    ORDER BY TMP.SHIP_DT_TMP_ID DESC)
                                            UNION ALL
                                            SELECT *
                                            FROM (SELECT SM.SHIPMENT_ID,
                                                        DT.SHIP_DT_ID,
                                                        DT.BARCODE_NO,
                                                        CN.COND_NAME,
                                                        LT.CARD_UPC        UPC,
                                                        LT.CARD_MPN        MPN,
                                                        LT.MPN_DESCRIPTION,
                                                        LT.BRAND
                                                    FROM LJ_SHIPMENT_MT     SM,
                                                        LJ_SHIPMENT_BOX    BX,
                                                        LJ_SHIPMENT_BOX_DT DT,
                                                        LZ_SPECIAL_LOTS    LT,
                                                        LZ_ITEM_COND_MT    CN
                                                    WHERE BX.SHIP_BOX_ID = DT.SHIP_BOX_ID
                                                    AND SM.SHIPMENT_ID = BX.SHIPMENT_ID
                                                    AND LT.BARCODE_PRV_NO = DT.BARCODE_NO
                                                    AND CN.ID = LT.CONDITION_ID
                                                    AND BX.SHIP_BOX_ID = $ship_box_id
                                                    ORDER BY DT.SHIP_DT_ID DESC)")->result_array();
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures2($box_details,$conditions);
        $images = $uri['uri'];
            return array("status" => true, "message" => "Barcode added", "box_details" => $box_details, "images"=>$images);
            }
        }else{
            return array("status" => false, "message" => "No barcode found");
        }


    }
    public function handleEditSearchOldBox(){
        $searchBarcode = $this->input->post("searchBarcode");
        $barcode       = trim(str_replace("  ", ' ', $searchBarcode));
        $shipment_id   = $this->input->post("shipment_id");
        $userId        = $this->input->post("userId");
        $merch_id      = $this->input->post("merch_id");
        $ship_box_id   = $this->input->post("edit_ship_box_id");

        
        $productAdded = $this->db->query("SELECT LOT.BARCODE_PRV_NO, CON.COND_NAME, LOT.CARD_UPC, LOT.CARD_MPN,LOT.MPN_DESCRIPTION,LOT.BRAND
                                            FROM LZ_SPECIAL_LOTS LOT, LZ_ITEM_COND_MT CON
                                            WHERE CON.ID = LOT.CONDITION_ID
                                            AND LOT.BARCODE_PRV_NO = $barcode
                                            AND LOT.CONDITION_ID != -1")->result_array();
       $allBoxQuery = "SELECT BOX.SHIP_BOX_ID,
       BOX.SHIPMENT_ID,
       BOX.BOX_NO,
       BOX.TRACKING_NO,
       (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
       BOX.CARRIER,
       BOX.CREATED_BY,
       BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
       WHERE BOX.SHIPMENT_ID = $shipment_id 
       ORDER BY BOX.BOX_NO";

        if($productAdded){
            $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            
        $alreadyExist = $this->db->query("SELECT TMP.BARCODE_NO
            FROM LJ_SHIPMENT_BOX_DT_TMP TMP
            WHERE TMP.INSERTED_BY = $userId
            AND TMP.SHIPMENT_ID = $shipment_id
            AND TMP.BARCODE_NO = $barcode
            UNION ALL
            SELECT DT.BARCODE_NO
            FROM LJ_SHIPMENT_BOX MT, LJ_SHIPMENT_BOX_DT DT
            WHERE MT.SHIP_BOX_ID = DT.SHIP_BOX_ID
            AND MT.SHIPMENT_ID = $shipment_id
            AND DT.BARCODE_NO = $barcode
            ")->result_array();

        $cehckHistory = $this->db->query(" SELECT BOX.SHIPMENT_ID, BOX.SHIP_BOX_ID, DT.BARCODE_NO 
        FROM LJ_SHIPMENT_BOX_DT DT, LJ_SHIPMENT_BOX BOX, LJ_SHIPMENT_MT MT 
        WHERE BOX.SHIP_BOX_ID = DT.SHIP_BOX_ID
        AND MT.SHIPMENT_ID = BOX.SHIPMENT_ID
        AND DT.BARCODE_NO = $barcode
        AND MT.MERCHANT_ID = $merch_id")->result_array();

        if($alreadyExist || $cehckHistory){
            $bar = "";
            if($alreadyExist){
                $bar = $alreadyExist[0]['BARCODE_NO'];
            }else{
                $bar = $cehckHistory[0]['BARCODE_NO'];
            }
            return array("status" => false, "message" => "Barcode No: $bar already Exist!");
        }else{
            $insert = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT TMP( TMP.SHIP_DT_ID,
                                TMP.SHIP_BOX_ID,
                                TMP.BARCODE_NO,
                                TMP.CREATED_BY,
                                TMP.CREATED_AT) VALUES(
                                GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT','SHIP_DT_ID'),
                                $ship_box_id,
                                $barcode,
                                $userId,
                                $created_at
                                )
                                ");
            $box_details = $this->db->query("SELECT *
                                            FROM (SELECT TMP.SHIPMENT_ID,
                                                        TMP.SHIP_DT_TMP_ID SHIP_DT_ID,
                                                        TMP.BARCODE_NO,
                                                        CN.COND_NAME,
                                                        LT.CARD_UPC        UPC,
                                                        LT.CARD_MPN        MPN,
                                                        LT.MPN_DESCRIPTION,
                                                        LT.BRAND
                                                    FROM LJ_SHIPMENT_MT         SM,
                                                        LJ_SHIPMENT_BOX_DT_TMP TMP,
                                                        LZ_SPECIAL_LOTS        LT,
                                                        LZ_ITEM_COND_MT        CN
                                                    WHERE SM.SHIPMENT_ID = TMP.SHIPMENT_ID
                                                    AND TMP.BARCODE_NO = LT.BARCODE_PRV_NO
                                                    AND LT.CONDITION_ID = CN.ID
                                                    AND TMP.SHIPMENT_ID = $shipment_id
                                                    ORDER BY TMP.SHIP_DT_TMP_ID DESC)
                                            UNION ALL
                                            SELECT *
                                            FROM (SELECT SM.SHIPMENT_ID,
                                                        DT.SHIP_DT_ID,
                                                        DT.BARCODE_NO,
                                                        CN.COND_NAME,
                                                        LT.CARD_UPC        UPC,
                                                        LT.CARD_MPN        MPN,
                                                        LT.MPN_DESCRIPTION,
                                                        LT.BRAND
                                                    FROM LJ_SHIPMENT_MT     SM,
                                                        LJ_SHIPMENT_BOX    BX,
                                                        LJ_SHIPMENT_BOX_DT DT,
                                                        LZ_SPECIAL_LOTS    LT,
                                                        LZ_ITEM_COND_MT    CN
                                                    WHERE BX.SHIP_BOX_ID = DT.SHIP_BOX_ID
                                                    AND SM.SHIPMENT_ID = BX.SHIPMENT_ID
                                                    AND LT.BARCODE_PRV_NO = DT.BARCODE_NO
                                                    AND CN.ID = LT.CONDITION_ID
                                                    AND BX.SHIP_BOX_ID = $ship_box_id
                                                    ORDER BY DT.SHIP_DT_ID DESC)")->result_array();

        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures2($box_details,$conditions);
        $images = $uri['uri'];
        $allBoxes = $this->db->query($allBoxQuery)->result_array();
            return array("status" => true, "message" => "Barcode added", "box_details" => $box_details, "images"=>$images,"allBoxes"=>$allBoxes);
            }
        }else{
            $allBoxes = $this->db->query($allBoxQuery)->result_array();
            return array("status" => false, "message" => "No barcode found","box_details" => "", "images"=>"", "allBoxes"=>$allBoxes);
        }


    }
    public function editCreateShipmentDtTmp(){
        $searchBarcode = $this->input->post("searchBarcode");
        $barcode       = trim(str_replace("  ", ' ', $searchBarcode));
        $shipment_id   = $this->input->post("shipment_id");
        $userId        = $this->input->post("userId");
        $merch_id    = $this->input->post("merch_id");

        
        $productAdded = $this->db->query("SELECT LOT.BARCODE_PRV_NO, CON.COND_NAME, LOT.CARD_UPC, LOT.CARD_MPN,LOT.MPN_DESCRIPTION,LOT.BRAND
                                            FROM LZ_SPECIAL_LOTS LOT, LZ_ITEM_COND_MT CON
                                            WHERE CON.ID = LOT.CONDITION_ID
                                            AND LOT.BARCODE_PRV_NO = $barcode
                                            AND LOT.CONDITION_ID != -1")->result_array();
        if($productAdded){
            $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            
        $alreadyExist = $this->db->query("SELECT TMP.BARCODE_NO
            FROM LJ_SHIPMENT_BOX_DT_TMP TMP
            WHERE TMP.INSERTED_BY = $userId
            AND TMP.SHIPMENT_ID = $shipment_id
            AND TMP.BARCODE_NO = $barcode
            UNION ALL
            SELECT DT.BARCODE_NO
            FROM LJ_SHIPMENT_BOX MT, LJ_SHIPMENT_BOX_DT DT
            WHERE MT.SHIP_BOX_ID = DT.SHIP_BOX_ID
            AND MT.SHIPMENT_ID = $shipment_id
            AND DT.BARCODE_NO = $barcode
            ")->result_array();

        $cehckHistory = $this->db->query(" SELECT BOX.SHIPMENT_ID, BOX.SHIP_BOX_ID, DT.BARCODE_NO 
        FROM LJ_SHIPMENT_BOX_DT DT, LJ_SHIPMENT_BOX BOX, LJ_SHIPMENT_MT MT 
        WHERE BOX.SHIP_BOX_ID = DT.SHIP_BOX_ID
        AND MT.SHIPMENT_ID = BOX.SHIPMENT_ID
        AND DT.BARCODE_NO = $barcode
        AND MT.MERCHANT_ID = $merch_id")->result_array();

        if($alreadyExist || $cehckHistory){
            $bar = "";
            if($alreadyExist){
                $bar = $alreadyExist[0]['BARCODE_NO'];
            }else{
                $bar = $cehckHistory[0]['BARCODE_NO'];
            }
            return array("status" => false, "message" => "Barcode No: $bar already Exist!");
        }else{
            $insert = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT_TMP TMP( TMP.SHIP_DT_TMP_ID,
                                TMP.BARCODE_NO,
                                TMP.INSERTED_AT,
                                TMP.INSERTED_BY,
                                TMP.SHIPMENT_ID) VALUES(
                                GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT_TMP','SHIP_DT_TMP_ID'),
                                $barcode,
                                $created_at,
                                $userId,
                                $shipment_id
                                )
                                ");
            $box_details = $this->db->query("SELECT *
                                            FROM (SELECT TMP.SHIPMENT_ID,
                                                        TMP.SHIP_DT_TMP_ID SHIP_DT_ID,
                                                        TMP.BARCODE_NO,
                                                        CN.COND_NAME,
                                                        LT.CARD_UPC        UPC,
                                                        LT.CARD_MPN        MPN,
                                                        LT.MPN_DESCRIPTION,
                                                        LT.BRAND
                                                    FROM LJ_SHIPMENT_MT         SM,
                                                        LJ_SHIPMENT_BOX_DT_TMP TMP,
                                                        LZ_SPECIAL_LOTS        LT,
                                                        LZ_ITEM_COND_MT        CN
                                                    WHERE SM.SHIPMENT_ID = TMP.SHIPMENT_ID
                                                    AND TMP.BARCODE_NO = LT.BARCODE_PRV_NO
                                                    AND LT.CONDITION_ID = CN.ID
                                                    AND TMP.SHIPMENT_ID = $shipment_id
                                                    ORDER BY TMP.SHIP_DT_TMP_ID DESC)")->result_array();
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures2($box_details,$conditions);
        $images = $uri['uri'];
            return array("status" => true, "message" => "Barcode added", "box_details" => $box_details, "images"=>$images);
            }
        }else{
            return array("status" => false, "message" => "No barcode found");
        }


    }
    public function saveEditBarcodes(){
        $shipment_id = $this->input->post("shipment_id");
        $ship_box_id = $this->input->post("ship_box_id");
        $userId      = $this->input->post("userId");
        $trackingNo  = $this->input->post("trackingNo");
        $carrier     = $this->input->post("carrier");

        if(!$trackingNo){
            $trackingNo = "";
        }
        if(!$carrier){
            $carrier = "";
        }
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $shipmentBoxTmp = $this->db->query("SELECT * FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIPMENT_ID = $shipment_id")->result_array();
$getTotalBoxesQuery = "SELECT SMT.SHIPMENT_ID, SBOX.SHIP_BOX_ID,
       SBOX.BOX_NO,
       SBOX.TRACKING_NO,
       SBOX.CARRIER
  FROM LJ_SHIPMENT_MT SMT, LJ_SHIPMENT_BOX SBOX
 WHERE SMT.SHIPMENT_ID = SBOX.SHIPMENT_ID
 AND SMT.SHIPMENT_ID = $shipment_id";

        if($shipmentBoxTmp){

                foreach ($shipmentBoxTmp as $value) {
                    // var_dump($value['BARCODE_NO']);
                    $barcode = $value['BARCODE_NO'];
                    $insertDetail = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT BOX_DT (
                        BOX_DT.SHIP_DT_ID,
                        BOX_DT.SHIP_BOX_ID,
                        BOX_DT.BARCODE_NO,
                        BOX_DT.CREATED_BY,
                        BOX_DT.CREATED_AT
                    )
                    VALUES (
                        GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT','SHIP_DT_ID'),
                        $ship_box_id,
                        $barcode,
                        $userId,
                        $created_at
                    )
                    ");
                }
                $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIPMENT_ID = $shipment_id ");

               $totalBoxes = $this->db->query($getTotalBoxesQuery)->result_array();

                return array("create" => true, "message" => "Box Successfully Updated", "totalBoxes" => $totalBoxes);
    }else{
        $totalBoxes = $this->db->query($getTotalBoxesQuery)->result_array();
        return array("create" => false, "message" => "No barcodes added yet!", "totalBoxes" => $totalBoxes);
    }
    }
    public function deleteBoxBarcodeEdit(){
        $ship_dt_id  = $this->input->post("ship_dt_id");
        $shipment_id = $this->input->post("shipment_id");

$getTotalBoxesQuery = "SELECT SMT.SHIPMENT_ID, SBOX.SHIP_BOX_ID,
       SBOX.BOX_NO,
       SBOX.TRACKING_NO,
       SBOX.CARRIER
  FROM LJ_SHIPMENT_MT SMT, LJ_SHIPMENT_BOX SBOX
 WHERE SMT.SHIPMENT_ID = SBOX.SHIPMENT_ID
 AND SMT.SHIPMENT_ID = $shipment_id";
        $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT WHERE SHIP_DT_ID = $ship_dt_id");
        $totalBoxes = $this->db->query($getTotalBoxesQuery)->result_array();

        if($delete){
            return array("delete" => true, "message" => "Barcode Successfully removed from box!", "totalBoxes"=> $totalBoxes);
        }else{
            return array("delete" => false, "message" => "Something went wrong!", "totalBoxes"=> $totalBoxes);
        }
    }
    public function ActionDeleteBarcode(){
        $ship_dt_id  = $this->input->post("ship_dt_id");
        
        $result = $this->db->query("SELECT MT.SHIPMENT_ID FROM LJ_SHIPMENT_MT MT, LJ_SHIPMENT_BOX BOX,LJ_SHIPMENT_BOX_DT DT
                                    WHERE MT.SHIPMENT_ID = BOX.SHIPMENT_ID
                                    AND BOX.SHIP_BOX_ID = DT.SHIP_BOX_ID
                                    AND DT.SHIP_DT_ID = $ship_dt_id")->result_array();
        $shipment_id = "";
        if($result){
         $shipment_id = $result[0]['SHIPMENT_ID'];   
        }else{
            $getTempData = $this->db->query("SELECT SHIPMENT_ID FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIP_DT_TMP_ID = $ship_dt_id")->result_array();
            $shipment_id = $getTempData[0]['SHIPMENT_ID'];
        }


 $allBoxQuery = "SELECT BOX.SHIP_BOX_ID,
       BOX.SHIPMENT_ID,
       BOX.BOX_NO,
       BOX.TRACKING_NO,
       (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
       BOX.CARRIER,
       BOX.CREATED_BY,
       BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
       WHERE BOX.SHIPMENT_ID = $shipment_id 
       ORDER BY BOX.BOX_NO";

$allBoxes = $this->db->query($allBoxQuery)->result_array();
$delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP WHERE SHIP_DT_TMP_ID = $ship_dt_id");
$delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT WHERE SHIP_DT_ID = $ship_dt_id");
        if($delete){
            return array("delete" => true, "message" => "Barcode Successfully removed from box!", "allBoxes"=> $allBoxes);
        }else{
            return array("delete" => false, "message" => "Something went wrong!", "allBoxes"=> $allBoxes);
        }
    }
    public function updateTrackingNo(){
        $TrackingNo  = $this->input->post("TrackingNo");
        $ship_box_id = $this->input->post("ship_box_id");

        $update = $this->db->query("UPDATE LJ_SHIPMENT_BOX SET TRACKING_NO = '$TrackingNo' WHERE SHIP_BOX_ID = $ship_box_id");

        if($update){
            return array("update"=>true, "message"=>"Tracking No Updated Successfully");
        }else{
            return array("update"=>true, "message"=>"Something went wrong!");
        }
    }
    public function updateCarrier(){
        $Carrier     = $this->input->post("Carrier");
        $ship_box_id = $this->input->post("ship_box_id");

        $update = $this->db->query("UPDATE LJ_SHIPMENT_BOX SET CARRIER = '$Carrier' WHERE SHIP_BOX_ID = $ship_box_id");

        if($update){
            return array("update"=>true, "message"=>"Carrier Updated Successfully");
        }else{
            return array("update"=>true, "message"=>"Something went wrong!");
        }
    }
    public function updateTrackingNoOldShipment(){
        $TrackingNo  = $this->input->post("TrackingNo");
        $ship_box_id = $this->input->post("ship_box_id");

        $update = $this->db->query("UPDATE LJ_SHIPMENT_BOX SET TRACKING_NO = '$TrackingNo' WHERE SHIP_BOX_ID = $ship_box_id");
        $shipment = $this->db->query("SELECT SHIPMENT_ID FROM LJ_SHIPMENT_BOX WHERE SHIP_BOX_ID = $ship_box_id")->result_array();
        $shipment_id = $shipment[0]['SHIPMENT_ID'];
 $allBoxQuery = "SELECT BOX.SHIP_BOX_ID,
       BOX.SHIPMENT_ID,
       BOX.BOX_NO,
       BOX.TRACKING_NO,
       (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
       BOX.CARRIER,
       BOX.CREATED_BY,
       BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
       WHERE BOX.SHIPMENT_ID = $shipment_id 
       ORDER BY BOX.BOX_NO";

$allBoxes = $this->db->query($allBoxQuery)->result_array();

        if($update){
            return array("update"=>true, "message"=>"Tracking No Updated Successfully", "allBoxes" => $allBoxes);
        }else{
            return array("update"=>true, "message"=>"Something went wrong!", "allBoxes" => "");
        }
    }
    public function updateCarrierOldShipment(){
        $Carrier     = $this->input->post("Carrier");
        $ship_box_id = $this->input->post("ship_box_id");

        $update = $this->db->query("UPDATE LJ_SHIPMENT_BOX SET CARRIER = '$Carrier' WHERE SHIP_BOX_ID = $ship_box_id");
$shipment = $this->db->query("SELECT SHIPMENT_ID FROM LJ_SHIPMENT_BOX WHERE SHIP_BOX_ID = $ship_box_id")->result_array();
        $shipment_id = $shipment[0]['SHIPMENT_ID'];
 $allBoxQuery = "SELECT BOX.SHIP_BOX_ID,
       BOX.SHIPMENT_ID,
       BOX.BOX_NO,
       BOX.TRACKING_NO,
       (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
       BOX.CARRIER,
       BOX.CREATED_BY,
       BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
       WHERE BOX.SHIPMENT_ID = $shipment_id 
       ORDER BY BOX.BOX_NO";

$allBoxes = $this->db->query($allBoxQuery)->result_array();
        if($update){
            return array("update"=>true, "message"=>"Carrier Updated Successfully", "allBoxes" => $allBoxes);
        }else{
            return array("update"=>true, "message"=>"Something went wrong!", "allBoxes" => "");
        }
    }
    public function deleteShipmentDtTmp(){
        $ship_dt_tmp_id = $this->input->post("ship_dt_tmp_id");

        $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP  TMP WHERE TMP.SHIP_DT_TMP_ID = $ship_dt_tmp_id");
        
        if($delete){
            return array("delete" => true, "message"=>"Successfully deleted barcode");
        }else {
            return array("delete" => false, "message" => "Something went wrong!");
        }
    }
    public function deleteTempBarcode(){
        $ship_dt_tmp_id = $this->input->post("ship_dt_tmp_id");

        $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP  TMP WHERE TMP.SHIP_DT_TMP_ID = $ship_dt_tmp_id");
        
        if($delete){
            return array("delete" => true, "message"=>"Successfully deleted barcode");
        }else {
            return array("delete" => false, "message" => "Something went wrong!");
        }
    }
    public function getBoxDetails(){
        $ship_box_id = $this->input->post("ship_box_id");
        $box_details = $this->db->query("SELECT SM.SHIPMENT_ID,
                                                    DT.SHIP_DT_ID,
                                                    NVL(DT.BARCODE_NO, TMP.BARCODE_NO) BARCODE_NO,
                                                    CN.COND_NAME,
                                                    LT.CARD_UPC UPC,
                                                    LT.CARD_MPN MPN,
                                                    LT.MPN_DESCRIPTION,
                                                    LT.BRAND
                                                FROM LJ_SHIPMENT_MT         SM,
                                                    LJ_SHIPMENT_BOX        BX,
                                                    LJ_SHIPMENT_BOX_DT     DT,
                                                    LZ_SPECIAL_LOTS        LT,
                                                    LZ_ITEM_COND_MT        CN,
                                                    LJ_SHIPMENT_BOX_DT_TMP TMP
                                                WHERE BX.SHIP_BOX_ID = DT.SHIP_BOX_ID
                                                AND SM.SHIPMENT_ID = BX.SHIPMENT_ID
                                                AND SM.SHIPMENT_ID = TMP.SHIPMENT_ID(+)
                                                AND LT.BARCODE_PRV_NO = NVL(DT.BARCODE_NO, TMP.BARCODE_NO)
                                                AND CN.ID = LT.CONDITION_ID
                                                AND BX.SHIP_BOX_ID = $ship_box_id
                                                ORDER BY DT.SHIP_DT_ID DESC")->result_array();

        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures2($box_details,$conditions);
        $images = $uri['uri'];

        if($box_details){
            return array("found"=>true, "box_details" => $box_details, "images" => $images);
        }else{
            return array("found"=>false, "box_details" => $box_details, "images" => $images);
        }
    }

    public function get_pictures2($Products,$conditions){

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
            $uri[$product['SHIP_DT_ID']][$j] = $base_url. $withoutMasterPartUri;
            // if($uri[$product['SHIP_DT_ID']]){
            //     break;
            // }
             
            $j++;
        }  
        }else{
                $uri[$product['SHIP_DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['SHIP_DT_ID']][1] = false;
            }  
    }else{
        $uri[$product['SHIP_DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['SHIP_DT_ID']][1] = false;
    }
}


	return array('uri'=>$uri);
    }

    public function createBox(){
        $userId      = $this->input->post("userId");
        $shipment_id = $this->input->post("shipment_id");
        $trackingNo  = $this->input->post("trackingNo");
        $carrier     = $this->input->post("carrier");

        if(!$trackingNo){
            $trackingNo = "";
        }
        if(!$carrier){
            $carrier = "";
        }
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $shipmentBoxTmp = $this->db->query("SELECT * FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIPMENT_ID = $shipment_id")->result_array();
$getTotalBoxesQuery = "SELECT SMT.SHIPMENT_ID, SBOX.SHIP_BOX_ID,
       SBOX.BOX_NO,
       SBOX.TRACKING_NO,
       SBOX.CARRIER
  FROM LJ_SHIPMENT_MT SMT, LJ_SHIPMENT_BOX SBOX
 WHERE SMT.SHIPMENT_ID = SBOX.SHIPMENT_ID
 AND SMT.SHIPMENT_ID = $shipment_id";

        if($shipmentBoxTmp){
            $box = $this->db->query("SELECT MAX(BOX_NO) BOX_NO FROM LJ_SHIPMENT_BOX WHERE SHIPMENT_ID = $shipment_id")->result_array();
            $box_no = $box[0]['BOX_NO'];

            if($box_no > 0){
                $box_no = $box_no + 1;
            }else{
                $box_no = 1;
            }

            $master_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX','SHIP_BOX_ID') MASTER_PK FROM DUAL")->result_array();
            $master_pk = $master_pk[0]['MASTER_PK'];

            $insertMaster =  $this->db->query("INSERT INTO LJ_SHIPMENT_BOX SBOX (SBOX.SHIP_BOX_ID,
       SBOX.SHIPMENT_ID,
       SBOX.BOX_NO,
       SBOX.TRACKING_NO,
       SBOX.CARRIER,
       SBOX.CREATED_BY,
       SBOX.CREATED_AT)
       VALUES(
        $master_pk,
        $shipment_id,
        $box_no,
        '$trackingNo',
        '$carrier',
        $userId,
        $created_at
       ) ");
        if($insertMaster){
            $i = 1;
                foreach ($shipmentBoxTmp as $value) {
                    // var_dump($value['BARCODE_NO']);
                    $barcode = $value['BARCODE_NO'];
                    $insertDetail = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT BOX_DT (
                        BOX_DT.SHIP_DT_ID,
                        BOX_DT.SHIP_BOX_ID,
                        BOX_DT.BARCODE_NO,
                        BOX_DT.CREATED_BY,
                        BOX_DT.CREATED_AT
                    )
                    VALUES (
                        GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT','SHIP_DT_ID'),
                        $master_pk,
                        $barcode,
                        $userId,
                        $created_at
                    )
                    ");
                        $i++;
                }
                $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIPMENT_ID = $shipment_id ");

               $totalBoxes = $this->db->query($getTotalBoxesQuery)->result_array();

                return array("create" => true, "message" => "Box Created", "totalBoxes" => $totalBoxes);
            }else{
                $totalBoxes = $this->db->query($getTotalBoxesQuery)->result_array();
return array("create" => false, "message" => "Something went wrong!", "totalBoxes" => $totalBoxes);
            }
    }else{
        $totalBoxes = $this->db->query($getTotalBoxesQuery)->result_array();
        return array("create" => false, "message" => "No barcodes added yet!", "totalBoxes" => $totalBoxes);
    }

    }
   
    public function createNewBoxOldShipment(){
        $userId      = $this->input->post("userId");
        $shipment_id = $this->input->post("shipment_id");
        $trackingNo  = $this->input->post("trackingNo");
        $carrier     = $this->input->post("carrier");

        if(!$trackingNo){
            $trackingNo = "";
        }
        if(!$carrier){
            $carrier = "";
        }
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
    	$date = date('Y-m-d H:i:s');
        $created_at= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $shipmentBoxTmp = $this->db->query("SELECT * FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIPMENT_ID = $shipment_id")->result_array();

        $allBoxQuery = "SELECT BOX.SHIP_BOX_ID,
       BOX.SHIPMENT_ID,
       BOX.BOX_NO,
       BOX.TRACKING_NO,
       (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
       BOX.CARRIER,
       BOX.CREATED_BY,
       BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
       WHERE BOX.SHIPMENT_ID = $shipment_id 
       ORDER BY BOX.BOX_NO";


        if($shipmentBoxTmp){
            $box = $this->db->query("SELECT MAX(BOX_NO) BOX_NO FROM LJ_SHIPMENT_BOX WHERE SHIPMENT_ID = $shipment_id")->result_array();
            $box_no = $box[0]['BOX_NO'];

            if($box_no > 0){
                $box_no = $box_no + 1;
            }else{
                $box_no = 1;
            }

            $master_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX','SHIP_BOX_ID') MASTER_PK FROM DUAL")->result_array();
            $master_pk = $master_pk[0]['MASTER_PK'];

            $insertMaster =  $this->db->query("INSERT INTO LJ_SHIPMENT_BOX SBOX (SBOX.SHIP_BOX_ID,
       SBOX.SHIPMENT_ID,
       SBOX.BOX_NO,
       SBOX.TRACKING_NO,
       SBOX.CARRIER,
       SBOX.CREATED_BY,
       SBOX.CREATED_AT)
       VALUES(
        $master_pk,
        $shipment_id,
        $box_no,
        '$trackingNo',
        '$carrier',
        $userId,
        $created_at
       ) ");
        if($insertMaster){
            $i = 1;
                foreach ($shipmentBoxTmp as $value) {
                    // var_dump($value['BARCODE_NO']);
                    $barcode = $value['BARCODE_NO'];
                    $insertDetail = $this->db->query("INSERT INTO LJ_SHIPMENT_BOX_DT BOX_DT (
                        BOX_DT.SHIP_DT_ID,
                        BOX_DT.SHIP_BOX_ID,
                        BOX_DT.BARCODE_NO,
                        BOX_DT.CREATED_BY,
                        BOX_DT.CREATED_AT
                    )
                    VALUES (
                        GET_SINGLE_PRIMARY_KEY('LJ_SHIPMENT_BOX_DT','SHIP_DT_ID'),
                        $master_pk,
                        $barcode,
                        $userId,
                        $created_at
                    )
                    ");
                        $i++;
                }
                $delete = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT_TMP TMP WHERE TMP.SHIPMENT_ID = $shipment_id ");

                $allBoxes = $this->db->query($allBoxQuery)->result_array();
                return array("create" => true, "message" => "Box Created","allBoxes"=>$allBoxes);
            }else{
                $allBoxes = $this->db->query($allBoxQuery)->result_array();
                return array("create" => false, "message" => "Something went wrong!","allBoxes"=>$allBoxes);
            }
    }else{
        $allBoxes = $this->db->query($allBoxQuery)->result_query();
        return array("create" => false, "message" => "No barcodes added yet!","allBoxes"=>$allBoxes);
    }

    }
    public function deleteBox(){
        $ship_box_id = $this->input->post("ship_box_id");

        $detail = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX_DT WHERE SHIP_BOX_ID = $ship_box_id");
        if($detail){
            $master = $this->db->query("DELETE FROM LJ_SHIPMENT_BOX WHERE SHIP_BOX_ID = $ship_box_id");
            return array("delete"=>true,"message"=>"Successfully Deleted");
        }else{
            return array("delete"=>false,"message"=>"Something went wrong!");
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
            $uri[$product['SHIP_DT_ID']][$j] = $base_url. $withoutMasterPartUri;
            // if($uri[$product['LZ_PRODUCT_ID']]){
            //     break;
            // }
            
            $j++;
        }    
        }else{
                $uri[$product['SHIP_DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['SHIP_DT_ID']][1] = false;
            }
    }else{
        $uri[$product['SHIP_DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['SHIP_DT_ID']][1] = false;
    }
}

//  var_dump($uri);
//         exit;
	return array('uri'=>$uri);
    }
    
}
?>	