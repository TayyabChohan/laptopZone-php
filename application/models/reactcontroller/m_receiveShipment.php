<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_receiveShipment extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
        }
        public function allReceiveBoxes(){
         $receiveBoxes = $this->db->query("SELECT MT.RECEIVE_MT_ID,
       MT.SHIP_BOX_ID,
       BOX.BOX_NO,
       (SELECT COUNT(BDT.BARCODE_NO)
          FROM LJ_SHIPMENT_BOX_DT BDT
         WHERE BDT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) SHIPED_BARCODES,
       (SELECT COUNT(DT.BARCODE_NO)
          FROM LJ_SHIP_RECEIVE_DT DT
         WHERE DT.RECEIVE_MT_ID = MT.RECEIVE_MT_ID) RECEIVE_BARCODES,
       BOX.TRACKING_NO,
       BOX.CARRIER,
       MT.RECEIVE_DATE
  FROM LJ_SHIP_RECEIVE_MT MT, LJ_SHIPMENT_BOX BOX
 WHERE BOX.SHIP_BOX_ID = MT.SHIP_BOX_ID")->result_array();
 if($receiveBoxes){
    return array("found" => true, "receiveBoxes" => $receiveBoxes);
 }else{
     return array("found" => false);
 }
        }
    public function getTrackingNo(){
        $trackingNo = $this->input->post("trackingNo");
        $userId     = $this->input->post("userId");

        $boxTrackingNo = $this->db->query("SELECT BOX.SHIP_BOX_ID,
                                                BOX.SHIPMENT_ID,
                                                BOX.BOX_NO,
                                                BOX.TRACKING_NO,
                                                (SELECT COUNT(BARCODE_NO) FROM LJ_SHIPMENT_BOX_DT DT WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
                                                BOX.CARRIER,
                                                BOX.CREATED_BY,
                                                BOX.CREATED_AT FROM LJ_SHIPMENT_BOX BOX
                                                WHERE BOX.TRACKING_NO = '$trackingNo' ")->result_array();
        if($boxTrackingNo){

        $ship_box_id  = $boxTrackingNo[0]['SHIP_BOX_ID'];
        $alreadyExist = $this->db->query("SELECT * FROM LJ_SHIP_RECEIVE_MT WHERE SHIP_BOX_ID = $ship_box_id")->result_array();

            if($alreadyExist){
                return array( "insert" => false, "message" => "Tracking No. Already Exist", "receiveShipments" => "" );
            }else{
                 $date         = date("m/d/Y");
                date_default_timezone_set("America/Chicago");
                $date          = date('Y-m-d H:i:s');
                $insert_date   = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
                $receive_mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_SHIP_RECEIVE_MT','RECEIVE_MT_ID') RECEIVE_MT_ID FROM DUAL")->result_array();
                $receive_mt_id = $receive_mt_id[0]['RECEIVE_MT_ID'];
                $shipment_id   = $boxTrackingNo[0]['SHIPMENT_ID'];

                $insert = $this->db->query("INSERT INTO LJ_SHIP_RECEIVE_MT A (A.RECEIVE_MT_ID, A.SHIP_BOX_ID, A.RECEIVE_DATE, A.RECEIVE_BY, A.SHIPMENT_ID) 
                VALUES ($receive_mt_id, $ship_box_id, $insert_date, $userId, $shipment_id )");
                $receiveShipments = $this->db->query("SELECT A.RECEIVE_MT_ID,
                                                            A.SHIP_BOX_ID,
                                                            A.RECEIVE_DATE,
                                                            A.RECEIVE_BY,
                                                            A.SHIPMENT_ID,
                                                            BOX.BOX_NO,
                                                            BOX.TRACKING_NO,
                                                            (SELECT COUNT(BARCODE_NO)
                                                                FROM LJ_SHIPMENT_BOX_DT DT
                                                                WHERE DT.SHIP_BOX_ID = BOX.SHIP_BOX_ID) BARCODE_NO,
                                                            BOX.CARRIER
                                                        FROM LJ_SHIP_RECEIVE_MT A, LJ_SHIPMENT_BOX BOX
                                                        WHERE A.SHIP_BOX_ID = BOX.SHIP_BOX_ID
                                                        AND A.SHIPMENT_ID =
                                                        $shipment_id")->result_array();

                return array( "insert" => true, "message" => "Box Received" ,"receiveShipments" => $receiveShipments );
            }

        }else{
           return array( "insert" => false, "message" => "Tracing No. not found" ,"receiveShipments" => "" );
       }
    }
    public function deleteReceiveBox(){
        $receive_mt_id = $this->input->post("receive_mt_id");

        $delete = $this->db->query("DELETE FROM LJ_SHIP_RECEIVE_DT WHERE RECEIVE_MT_ID = $receive_mt_id");
        $delete = $this->db->query("DELETE FROM LJ_SHIP_RECEIVE_MT WHERE RECEIVE_MT_ID = $receive_mt_id");

        if($delete){
            return array("delete" => true, "message" => "Box removed successfully!");
        }else{
            return array("delete" => true, "message" => "Box removed successfully!");
        }
    }
    public function deleteReceiveBarcode(){
        $receive_dt_id = $this->input->post("receive_dt_id");

        $delete = $this->db->query("DELETE FROM LJ_SHIP_RECEIVE_DT WHERE RECEIVE_DT_ID = $receive_dt_id");

        if($delete){
            return array("delete" => true, "message" => "Barcode removed successfully!");
        }else{
            return array("delete" => true, "message" => "Barcode removed successfully!");
        }
    }
    public function getShipmentBarcodes(){
        $barcode      = $this->input->post("searchBarcode");
        $userId       = $this->input->post("userId");
        $ship_box_id  = $this->input->post("ship_box_id");

        $alreadyExist = $this->db->query("SELECT DT.BARCODE_NO FROM LJ_SHIP_RECEIVE_DT DT WHERE DT.BARCODE_NO = $barcode ")->result_array();
        if($alreadyExist){
            $bar = $alreadyExist[0]['BARCODE_NO'];
            return array("insert" => false, "message" => "Barcode: $bar already exist!");
        }
        $checkBarcode = $this->db->query("SELECT BOX.SHIPMENT_ID, BOX.SHIP_BOX_ID, DT.BARCODE_NO FROM LJ_SHIPMENT_BOX_DT DT, LJ_SHIPMENT_BOX BOX 
                                        WHERE BOX.SHIP_BOX_ID = DT.SHIP_BOX_ID
                                        AND DT.BARCODE_NO = $barcode")->result_array();
        if($checkBarcode){
            $box_exist = $this->db->query("SELECT RECEIVE_MT_ID FROM LJ_SHIP_RECEIVE_MT WHERE SHIP_BOX_ID = $ship_box_id")->result_array();

                $date          = date("m/d/Y");
                date_default_timezone_set("America/Chicago");
                $date          = date('Y-m-d H:i:s');
                $insert_date   = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            $insert = "";
            if($box_exist){
                $receive_mt_id = $box_exist[0]['RECEIVE_MT_ID'];

                $insert = $this->db->query("INSERT INTO LJ_SHIP_RECEIVE_DT DT (DT.RECEIVE_DT_ID, 
                                                                                DT.RECEIVE_MT_ID, 
                                                                                DT.BARCODE_NO, 
                                                                                DT.BARCODE_STATUS, 
                                                                                DT.REMARKS, 
                                                                                DT.INSERTED_DATE, 
                                                                                DT.INSERTED_BY)
                                                                        VALUES (
                                                                            GET_SINGLE_PRIMARY_KEY('LJ_SHIP_RECEIVE_DT','RECEIVE_DT_ID'),
                                                                            $receive_mt_id,
                                                                            $barcode,
                                                                            'Fine',
                                                                            '',
                                                                            $insert_date,
                                                                            $userId
                                                                        )");
            }else{
                $receive_mt_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LJ_SHIP_RECEIVE_MT','RECEIVE_MT_ID') RECEIVE_MT_ID FROM DUAL")->result_array();
                $receive_mt_id = $receive_mt_id[0]['RECEIVE_MT_ID'];
                $shipment_id   = $checkBarcode[0]['SHIPMENT_ID'];
                $ship_box_id   = $checkBarcode[0]['SHIP_BOX_ID'];
                
                $this->db->query("INSERT INTO LJ_SHIP_RECEIVE_MT A (A.RECEIVE_MT_ID, A.SHIP_BOX_ID, A.RECEIVE_DATE, A.RECEIVE_BY, A.SHIPMENT_ID) 
                VALUES ($receive_mt_id, $ship_box_id, $insert_date, $userId, $shipment_id )");
                
                $insert = $this->db->query("INSERT INTO LJ_SHIP_RECEIVE_DT DT (DT.RECEIVE_DT_ID, 
                                                                                DT.RECEIVE_MT_ID, 
                                                                                DT.BARCODE_NO, 
                                                                                DT.BARCODE_STATUS, 
                                                                                DT.REMARKS, 
                                                                                DT.INSERTED_DATE, 
                                                                                DT.INSERTED_BY)
                                                                        VALUES (
                                                                            GET_SINGLE_PRIMARY_KEY('LJ_SHIP_RECEIVE_DT','RECEIVE_DT_ID'),
                                                                            $receive_mt_id,
                                                                            $barcode,
                                                                            'Fine',
                                                                            '',
                                                                            $insert_date,
                                                                            $userId
                                                                        )");
            }
        

        $box_details = $this->db->query("SELECT DT.RECEIVE_DT_ID,
                                                DT.RECEIVE_MT_ID,
                                                DT.BARCODE_NO,
                                                CN.COND_NAME,
                                                LT.CARD_UPC UPC,
                                                LT.CARD_MPN MPN,
                                                LT.MPN_DESCRIPTION,
                                                LT.BRAND
                                            FROM LJ_SHIP_RECEIVE_MT    MT,
                                                LJ_SHIP_RECEIVE_DT     DT,
                                                LZ_SPECIAL_LOTS        LT,
                                                LZ_ITEM_COND_MT        CN
                                            WHERE DT.BARCODE_NO    = LT.BARCODE_PRV_NO
                                            AND   LT.CONDITION_ID  = CN.ID
                                            AND   MT.RECEIVE_MT_ID = DT.RECEIVE_MT_ID
                                            AND   MT.SHIP_BOX_ID   = $ship_box_id
                                            ORDER BY DT.RECEIVE_DT_ID DESC")->result_array();

        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($box_details,$conditions);
        $images = $uri['uri'];

            if($insert){
                return array("insert" => true, "message" => "Barcode Received!", "box_details" => $box_details, "images" => $images);
            }else{
                return array("insert" => false, "message" => "Something went wrong!");
            }
        }else{
            return array("insert" => false, "message" => "Barcode Not Exist!");
        }
    }
    public function getReceiveBarcodes(){
        $receive_mt_id = $this->input->post("receive_mt_id");
        
       $receiveBarcodes = $this->db->query("SELECT DT.RECEIVE_DT_ID,
                DT.RECEIVE_MT_ID,
                DT.BARCODE_NO,
                DT.BARCODE_STATUS,
                DT.REMARKS,
                CN.COND_NAME,
                LT.CARD_UPC        UPC,
                LT.CARD_MPN        MPN,
                LT.MPN_DESCRIPTION,
                LT.BRAND
            FROM LJ_SHIP_RECEIVE_MT MT,
                LJ_SHIP_RECEIVE_DT DT,
                LZ_SPECIAL_LOTS    LT,
                LZ_ITEM_COND_MT    CN
            WHERE DT.BARCODE_NO    = LT.BARCODE_PRV_NO
            AND LT.CONDITION_ID  = CN.ID
            AND MT.RECEIVE_MT_ID = DT.RECEIVE_MT_ID
            AND DT.RECEIVE_MT_ID = $receive_mt_id
            ORDER BY DT.RECEIVE_DT_ID DESC")->result_array();

            if($receiveBarcodes){
                $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
                $uri = $this->get_pictures($receiveBarcodes,$conditions);
                $images = $uri['uri'];
                
                return array("found"=> true, "receiveBarcodes" => $receiveBarcodes, "images" => $images);
            }else{
                return array("found"=> true, "message" => "No Barcodes received in this box!");
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
            $uri[$product['RECEIVE_DT_ID']][$j] = $base_url. $withoutMasterPartUri;

            $j++;
        }  
        }else{
                $uri[$product['RECEIVE_DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['RECEIVE_DT_ID']][1] = false;
            }  
    }else{
        $uri[$product['RECEIVE_DT_ID']][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
        $uri[$product['RECEIVE_DT_ID']][1] = false;
    }
}


	return array('uri'=>$uri);
    }
    
    
}
?>	