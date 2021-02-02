<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_returnInventory extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
        }
    public function saveReturn(){
        $postData   = $this->input->post("postData");
        $userId     = $this->input->post("userId");
        
        foreach($postData as $value){

            $dt_id  = $value['DT_ID'];
            $barcode_status = $value['BARCODE_STATUS'];

            $date = date("m/d/Y");
            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

             $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.BARCODE_STATUS = $barcode_status, DT.STATUS_DATE = $insert_date, DT.STATUS_BY = $userId, NOTIFICATION = 1 WHERE DT.DT_iD = $dt_id ");
        }
        return array("update" => true,"message"=>"Request Created Successfully!");
    }
    public function getState(){
        $merId         = $this->input->post("merId");
        $userId        = $this->input->post("userId");
        $componentName = $this->input->post("componentName");

        $date = date("m/d/Y");
            date_default_timezone_set("America/Chicago");
            $date = date('Y-m-d H:i:s');
            $insert_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
            
        $previousState = $this->db->query("SELECT TO_CHAR(MERCHANT_STATES) MERCHANT_STATES
                                           FROM REACT_STATES 
                                           WHERE MERCHANT_ID  = $merId 
                                           AND COMPONENT_NAME = '$componentName'
                                           AND TO_DATE(INSERT_AT, 'YYYY-MM-DD') = TO_DATE(SYSDATE, 'YYYY-MM-DD') 
                                           AND TO_CHAR(MERCHANT_STATES) != 'null'")->result_array();

        $forPictures = json_decode($previousState[0]['MERCHANT_STATES'],true);               
        if($previousState){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures($forPictures,$conditions);
            $images = $uri['uri'];
            return array("found" => true, "merchant_state" => $previousState, 'images' => $images);
        }else{
            return array("found" => false, "message" => "No Data Found");
        }
    }
    public function deleteState(){
        $merId         = $this->input->post("merId");
        $userId        = $this->input->post("userId");
        $componentName = $this->input->post("componentName");

        $previousState = $this->db->query("DELETE FROM REACT_STATES WHERE MERCHANT_ID = $merId AND COMPONENT_NAME = '$componentName' ");

        if($previousState){
            return array("delete" => true, "message" => "Request canceled successfully!");
        }else{
            return array("delete" => false, "message" => "No Data Found");
        }
    }
    public function saveState(){
        $merId         = $this->input->post("merId");
        $userId        = $this->input->post("userId");
        $state_data    = json_encode($this->input->post("postData"));
        $componentName = $this->input->post("componentName");

        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $previousState = $this->db->query("SELECT * FROM REACT_STATES WHERE MERCHANT_ID = $merId AND COMPONENT_NAME = '$componentName' ")->result_array();
        if($previousState){
            $react_id   = $previousState[0]['REACT_ID'];
            $stateSaved = $this->db->query("UPDATE REACT_STATES SET MERCHANT_STATES = '$state_data', COMPONENT_NAME = '$componentName', INSERT_AT = $insert_date, INSERT_BY = $userId, UPDATE_AT = $insert_date, UPDATE_BY = $userId WHERE REACT_ID = $react_id");
            if($stateSaved){
                return array("stateSaved" => true, "message" => "State Updated");
            }else{
                return array("stateSaved" => false, "message" => "State cannot be updated");
            }

        }else{
            $stateSaved = $this->db->query("INSERT INTO REACT_STATES (REACT_ID,MERCHANT_ID,MERCHANT_STATES,COMPONENT_NAME,INSERT_AT,INSERT_BY) values( GET_SINGLE_PRIMARY_KEY('REACT_STATES','REACT_ID'),$merId,'$state_data','$componentName',$insert_date,$userId)");
            if($stateSaved){
                return array("stateSaved" => true, "message" => "State created");
            }else{
                return array("stateSaved" => false, "message" => "State cannot be created");
            }
        }

    }
    public function createReturn(){
        $merId   = $this->input->post("merId");
        $barcode = $this->input->post("barcode");

       $createReturn =  $this->db->query("SELECT DT.DT_ID,
       DT.DT_ID IMAGE,
       DT.BARCODE_NO,
       DT.BARCODE_STATUS,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.STATUS_BY,
       DT.REMARKS,
       dt.NOTIFICATION,
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
   AND DT.BARCODE_STATUS = 0
   AND DT.ADMIN_STATUS = 0
   AND MT.MERCHANT_ID = $merId
   AND DT.BARCODE_NO = $barcode
   ORDER BY DT.BARCODE_NO DESC")->result_array();

        if($createReturn){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures($createReturn,$conditions);
            $images = $uri['uri'];
            return array( "found" => true,"message" => "Barcode Added To List", "createReturn" => $createReturn, 'images' => $images);
        }else{
            return array( "found" => false, "message" => "No Data Found!");
        }
    }
    public function cancelReturn(){
        $dt_id  = $this->input->post("dt_id");
        $userId = $this->input->post("userId");
        $cancel = $this->input->post("cancel");
        
        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
        
        $status_date = $this->db->query("SELECT TO_CHAR(TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS'),'DD-MM-YY HH24:MI:SS') STATUS_DATE FROM DUAL")->result_array();
        $status_date = $status_date[0]['STATUS_DATE'];

        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.BARCODE_STATUS = 0, DT.STATUS_DATE = $insert_date, DT.STATUS_BY = $userId, NOTIFICATION = 0 WHERE DT.DT_iD = $dt_id ");

        $message = "";
        if($cancel == 1){
            $message = "Return Request Canceled!";
        }else if($cancel == 2){
            $message = "Junk Request Canceled!";
        }
        if($update){
            return array( "update" => true, "message" => $message, "status_date" => $status_date, "statusOption" => $cancel);
        }else{
            return array( "update" => true, "message" => "Something Went Wrong!");
        }
    }
    public function changeStatus(){
        $dt_id          = $this->input->post("dt_id");
        $userId         = $this->input->post("userId");
        $remarks        = $this->input->post("remarks");
        $selectedOption = $this->input->post("selectedOption");

        $date = date("m/d/Y");
        date_default_timezone_set("America/Chicago");
        $date = date('Y-m-d H:i:s');
        $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

        $status_date = $this->db->query("SELECT TO_CHAR(TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS'),'DD-MM-YY HH24:MI:SS') STATUS_DATE FROM DUAL")->result_array();
        $status_date = $status_date[0]['STATUS_DATE'];

        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT DT SET DT.BARCODE_STATUS = $selectedOption, DT.STATUS_DATE = $insert_date, REMARKS = '$remarks', DT.STATUS_BY = $userId, NOTIFICATION = 1 WHERE DT.DT_iD = $dt_id ");

        $message = "";
        if($selectedOption == 1){
            $message = "Return Request Sended!";
        }else if($selectedOption == 2){
            $message = "Junk Request Sended!";
        }
        if($update){
            return array( "update" => true, "message" => $message, "status_date" => $status_date, "statusOption" => $selectedOption );
        }else{
            return array( "update" => true, "message" => "Something Went Wrong!");
        }
    }
    public function getAllInventory(){
        $merch_id = $this->input->post("merch_id");

        $allInventory = $this->db->query("SELECT DT.DT_ID,
       DT.DT_ID IMAGE,
       DT.BARCODE_NO,
       DT.BARCODE_STATUS,
       TO_CHAR(DT.STATUS_DATE,'DD-MM-YY HH24:MI:SS') STATUS_DATE,
       DT.ADMIN_STATUS,
       DT.STATUS_BY,
       DT.REMARKS,
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
   AND MT.MERCHANT_ID = $merch_id
   ORDER BY DT.BARCODE_NO DESC")->result_array();

   if($allInventory){
        $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures($allInventory,$conditions);
            $images = $uri['uri'];
    return array("found" => true, "allInventory" => $allInventory, 'images' => $images);
   }else{
    return array("found" => false, "message", "Empty Inventory");
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