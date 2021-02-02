<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_shipQueue extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    public function getAllQueues(){
        $merch_id = $this->input->post("merch_id");

        $allQueues = $this->db->query("SELECT (CASE
         WHEN B.BARCODE_NO IS NULL THEN
          'UNPOST'
         WHEN B.EBAY_ITEM_ID IS NULL AND B.HOLD_STATUS = 0 AND
              S.SEED_STATUS = 0 THEN
          'NOT READY'
         WHEN B.EBAY_ITEM_ID IS NULL AND B.HOLD_STATUS = 0 AND
              S.SEED_STATUS = 1 THEN
          'READY TO LIST'
         WHEN B.EBAY_ITEM_ID IS NOT NULL AND B.HOLD_STATUS = 0 AND
              S.SEED_STATUS = 1 THEN
          'LISTED'
         WHEN B.EBAY_ITEM_ID IS NULL AND B.HOLD_STATUS = 1 THEN
          'HOLD'
       END) STATUS,
        D.DT_ID SEED_ID,
       NVL(S.EBAY_PRICE, D.COST) EBAY_PRICE,
       NVL(S.ITEM_TITLE, LOT.MPN_DESCRIPTION) ITEM_TITLE,
       EMP.FIRST_NAME CREATED_BY,
       LOT.INSERTED_AT CREATED_AT,
       NVL(B.BARCODE_NO, LOT.BARCODE_PRV_NO) BARCODE_NO,
       NVL(B.LZ_BARCODE_MT_ID, D.DT_ID) LZ_BARCODE_MT_ID,
       NVL(S.F_UPC, LOT.CARD_UPC) UPC,
       NVL(S.F_MPN, LOT.CARD_MPN) MPN,
       NVL(S.F_MANUFACTURE, LOT.BRAND) F_MANUFACTURE
  FROM LZ_ITEM_SEED           S,
       LZ_BARCODE_MT          B,
       LZ_MERCHANT_BARCODE_DT D,
       LZ_MERCHANT_BARCODE_MT M,
       LZ_SPECIAL_LOTS        LOT,
       EMPLOYEE_MT            EMP
 WHERE S.ITEM_ID(+) = B.ITEM_ID
   AND D.MT_ID = M.MT_ID
   AND LOT.BARCODE_PRV_NO = B.BARCODE_NO(+)
   AND LOT.BARCODE_PRV_NO = D.BARCODE_NO
   AND EMP.EMPLOYEE_ID = LOT.INSERTED_BY
   AND LOT.LISTED_YN = 1
   AND M.MERCHANT_ID = $merch_id
   AND (LOT.CONDITION_ID != -1 OR D.DISCARD_COND IS NULL)
 ORDER BY B.BARCODE_NO DESC
")->result_array();

       if($allQueues){
           $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
        $uri = $this->get_pictures($allQueues,$conditions);
        $images = $uri['uri'];
           return array( "found" => true, "allQueues"=>$allQueues, "images" => $images );
       }else{
           return array( "found" => false, "message"=>"No records found!", "allQueues"=>"", "images" => "" );
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
    public function holdBarcode(){
        $lz_barcode_mt_id = $this->input->post("lz_barcode_mt_id");

        $update = $this->db->query("UPDATE LZ_BARCODE_MT SET HOLD_STATUS = 1 WHERE LZ_BARCODE_MT_ID = $lz_barcode_mt_id");
        if($update){
            return array("update"=>true, "message"=>"Item Successfully Hold");
        }else{
            return array("update"=>false, "message"=>"Something went wrong!");
        }
    }
    public function unholdBarcode(){
        $lz_barcode_mt_id = $this->input->post("lz_barcode_mt_id");

        $update = $this->db->query("UPDATE LZ_BARCODE_MT SET HOLD_STATUS = 0 WHERE LZ_BARCODE_MT_ID = $lz_barcode_mt_id");
        if($update){
            return array("update"=>true, "message"=>"Item Successfully Unhold");
        }else{
            return array("update"=>false, "message"=>"Something went wrong!");
        }
    }
    public function editPrice(){
        $seed_id = $this->input->post("seed_id");
        $price = $this->input->post("price");

        $update = $this->db->query("UPDATE LZ_ITEM_SEED SET EBAY_PRICE = $price WHERE seed_id = $seed_id");
        if($update){
            return array("update"=>true, "message"=>"Price Successfully Updated");
        }else{
            return array("update"=>false, "message"=>"Something went wrong!");
        }
    }
    public function editCost(){
        $barcode_no = $this->input->post("barcode_no");
        $cost = $this->input->post("cost");

        $update = $this->db->query("UPDATE LZ_MERCHANT_BARCODE_DT D SET D.COST = $cost WHERE D.BARCODE_NO = $barcode_no");
        if($update){
            return array("update"=>true, "message"=>"Cost Successfully Updated");
        }else{
            return array("update"=>false, "message"=>"Something went wrong!");
        }
    }

}
?>	