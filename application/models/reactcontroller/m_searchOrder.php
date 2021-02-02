<?php 
if (!defined('BASEPATH'))
 exit('No direct script access allowed');
	/**
	* Single Entry Model
	*/
	class m_searchOrder extends CI_Model
	{
        public function __construct(){
        parent::__construct();
        $this->load->database(); 
    }
    public function getMerchantAccounts(){
        $accounts = $this->db->query("SELECT A.LZ_SELLER_ACCT_ID, A.SELL_ACCT_DESC FROM LZ_SELLER_ACCTS A")->result_array();
        if($accounts){
            return array("found"=>true, "accounts" => $accounts);
        }else{
            return array("found"=>false, "message" => "Something went wrong!");
        }
    }
     public function getCancellationsFromEbay(){
         $accountId = $this->input->post("accountId");

         $ebayCancellations = $this->db->query("SELECT CM.CANCELLATION_ID,
       CM.EBAY_CANCEL_ID,
       BM.BARCODE_NO,
       BM.EBAY_ITEM_ID,
       TM.ITEM_MT_MFG_PART_NO MPN,
       TM.ITEM_MT_UPC UPC,
       TM.ITEM_DESC TITLE,
       TM.ITEM_MT_MANUFACTURE BRAND,
       REPLACE(CM.MARKETPLACE_ID, '_', ' ') MARKETPLACE_ID,
       REPLACE(CM.REQUESTOR_TYPE, '_', ' ') REQUESTOR_TYPE,
       REPLACE(CM.CANCEL_STATE, '_', ' ') CANCEL_STATE,
       REPLACE(CM.CANCEL_STATUS, '_', ' ') CANCEL_STATUS,
       REPLACE(CM.CANCEL_CLOSE_REASON, '_', ' ') CANCEL_CLOSE_REASON,
       REPLACE(CM.PAYMENT_STATUS, '_', ' ') PAYMENT_STATUS,
       REPLACE(CM.CANCEL_REASON, '_', ' ') CANCEL_REASON,
       CM.LEGACY_ORDER_ID,
       CM.CREATED_AT,
       CM.CREATED_BY,
       CM.ACCOUNT_ID,
       ACC.SELL_ACCT_DESC ACCOUNT_NAME,
       DET.SALES_RECORD_NUMBER,
       CASE WHEN DET.SALES_RECORD_NUMBER IS NOT NULL THEN 'APPROVED' ELSE 'PENDING' END STATUS
  FROM LJ_CANCELLATION_MT CM,
       LZ_BARCODE_MT      BM,
       ITEMS_MT           TM,
       LZ_SELLER_ACCTS    ACC,
       LZ_SALESLOAD_DET   DET
 WHERE CM.LEGACY_ORDER_ID = DET.EXTENDEDORDERID
   AND BM.ITEM_ID = TM.ITEM_ID
   AND DET.ORDER_ID = BM.ORDER_ID
   AND ACC.LZ_SELLER_ACCT_ID = CM.ACCOUNT_ID
   AND CM.ACCOUNT_ID = $accountId
 ORDER BY CM.CANCELLATION_ID DESC
")->result_array(); 

        if($ebayCancellations){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($ebayCancellations,$conditions);
            $images = $uri['uri'];

            return array("found"=>true, "cancellations" => $ebayCancellations, "images" => $images);
        }else{
            return array("found"=>false, "message" => "No Cancellations Found");
        }
     }
public function processCancel()
    {
        $accountId      = $this->input->post("accountId");
		$cancel_id      = $this->input->post("cancel_id");
		$ebay_cancel_id = $this->input->post("ebay_cancel_id");
		$cancel_status  = $this->input->post("radioModel");
		$remarks        = $this->input->post("Remarks");
		$cancel_by      = $this->input->post("userId");

        $qyer = $this->db->query("Call pro_processCancel('$cancel_id',
                                                  '$cancel_status' ,
                                                  '$cancel_by'   ,
                                                  '$remarks'   ,
                                                  '0' )");

        $qyer = $this->db->query("SELECT  CANCEL_ID from LZ_SALESLOAD_DET s where s.CANCEL_ID ='$cancel_id'")->result_array();
        if ($qyer) {
            return array("status" => true, "data" => $qyer);
        } else {
            return array("status" => false);
        }
    }

    public function getOrderByID(){
    $saleRecordNo = $this->input->post('searchOrder');
    
        $searchResults = $this->db->query("SELECT LZ_BARCODE_MT_ID,
       BM.BARCODE_NO,
       BM.EBAY_ITEM_ID,
       BM.SALE_RECORD_NO,
       BIN.BIN_TYPE || '-' || BIN.BIN_NO BIN_NAME,
       IT.ITEM_DESC TITLE,
       IT.ITEM_MT_UPC UPC,
       IT.ITEM_MT_MFG_PART_NO MPN,
       IT.ITEM_MT_MANUFACTURE BRAND,
       SD.LZ_SALESLOAD_DET_ID,
       SD.BUYER_FULLNAME,
       SD.BUYER_PHONE_NUMBER,
       SD.BUYER_EMAIL,
       SD.BUYER_ADDRESS1,
       SD.BUYER_ADDRESS2,
       SD.BUYER_CITY,
       SD.BUYER_STATE,
       SD.BUYER_ZIP,
       SD.BUYER_COUNTRY,
       SD.SHIP_TO_ADDRESS1,
       SD.SHIP_TO_ADDRESS2,
       SD.SHIP_TO_CITY,
       SD.SHIP_TO_STATE,
       SD.SHIP_TO_ZIP,
       SD.SHIP_TO_COUNTRY,
       MA.SHIPPING_ADDRESS1,
       MA.SHIPPING_ADDRESS2,
       MA.SHIPPING_CITY,
       MA.SHIPPING_STATE,
       MA.SHIPPING_ZIP,
       MA.SHIPPING_COUNTRY,
       SD.QUANTITY,
       SD.MANUAL_BUYER_ADDRESS,
       VD.BARCODE_NO VERIFIED_YN,
       WG.PACK_WEIGHT,
       ACC.ACCOUNT_NAME
  FROM LZ_BARCODE_MT       BM,
       ITEMS_MT            IT,
       BIN_MT              BIN,
       LZ_SALESLOAD_DET    SD,
       LZ_SALESLOAD_MT     SM,
       LJ_MERHCANT_ACC_DT  ACC,
       LJ_BIN_VERIFY_DT    VD,
       LZ_ITEM_PACK_WEIGHT WG,
       MANUAL_ADDRESS_MT   MA
 WHERE IT.ITEM_ID = BM.ITEM_ID
   AND BM.BIN_ID = BIN.BIN_ID(+)
   AND SM.LZ_SELLER_ACCT_ID = ACC.ACCT_ID(+)
   AND SM.LZ_SALELOAD_ID = SD.LZ_SALELOAD_ID
   AND SD.MANUAL_BUYER_ADDRESS = MA.MANUAL_ADDRESS_ID(+)
   AND IT.ITEM_ID = WG.ITEM_ID(+)
   AND BM.BARCODE_NO = VD.BARCODE_NO(+)
   AND BM.SALE_RECORD_NO = SD.SALES_RECORD_NUMBER
   AND BM.SALE_RECORD_NO = '$saleRecordNo'")->result_array();

        if($searchResults){
            $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
            $uri = $this->get_pictures_by_barcode($searchResults,$conditions);

            $images = $uri['uri'];
            return array("found" => true, "searchResults" => $searchResults, "images" => $images);
        }else{
            return array("found" => false, "message" => "NO DATA FOUND!");
        }

    }
public function changeAddress(){

    $sale_record_no = $this->input->post('sale_record_no');
    $lz_salesload_det_id = $this->input->post('lz_salesload_det_id');

    $address1 = $this->input->post('address1');
    $address1 = trim(str_replace("  ", ' ', $address1));
    $address1 = trim(str_replace(array("'"), "''", $address1));

    $address2 = $this->input->post('address2');
    $address2 = trim(str_replace("  ", ' ', $address2));
    $address2 = trim(str_replace(array("'"), "''", $address2));

    $buyerCity = $this->input->post('buyerCity');
    $buyerCity = trim(str_replace("  ", ' ', $buyerCity));
    $buyerCity = trim(str_replace(array("'"), "''", $buyerCity));

    $buyerState = $this->input->post('buyerState');
    $buyerState = trim(str_replace("  ", ' ', $buyerState));
    $buyerState = trim(str_replace(array("'"), "''", $buyerState));

    $buyerZip = $this->input->post('buyerZip');
    $buyerZip = trim(str_replace("  ", ' ', $buyerZip));
    $buyerZip = trim(str_replace(array("'"), "''", $buyerZip));

    $buyerCountry = $this->input->post('buyerCountry');
    $buyerCountry = trim(str_replace("  ", ' ', $buyerCountry));
    $buyerCountry = trim(str_replace(array("'"), "''", $buyerCountry));

    $detail_id = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('MANUAL_ADDRESS_MT','LZ_SALELOAD_DET_ID') DET_ID FROM DUAL")->result_array();

    $det_id = $detail_id[0]['DET_ID'];

    $this->db->query("INSERT INTO MANUAL_ADDRESS_MT A (A.MANUAL_ADDRESS_ID,
       A.LZ_SALELOAD_DET_ID,
       A.ORDER_ID,
       A.SHIPPING_ADDRESS1,
       A.SHIPPING_ADDRESS2,
       A.SHIPPING_CITY,
       A.SHIPPING_STATE,
       A.SHIPPING_ZIP,
       A.SHIPPING_COUNTRY) VALUES (
        $det_id,
        $lz_salesload_det_id,
        $sale_record_no,
        '$address1',
        '$address2',
        '$buyerCity',
        '$buyerState',
        '$buyerZip',
        '$buyerCountry'
    )");

    $update = $this->db->query("UPDATE LZ_SALESLOAD_DET SET MANUAL_BUYER_ADDRESS = $det_id WHERE SALES_RECORD_NUMBER = '$sale_record_no' AND LZ_SALESLOAD_DET_ID = $lz_salesload_det_id ");

    if($update){
        return array("update" => true, "message" => "Address Changed!");
    }else{
        return array("update" => false, "message" => "Something Went Wrong!");
    }

}
    public function get_pictures_by_barcode($barcodes,$conditions){

            $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
            $path = $path->result_array();  	

            $master_path = $path[0]["MASTER_PATH"];
            $uri = array();
            $base_url = 'http://'.$_SERVER['HTTP_HOST'].'/';
                foreach($barcodes as $barcode){

                    $bar = $barcode['BARCODE_NO'];

                    $cancellation_id = @$barcode['CANCELLATION_ID'];

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
                    $getBarcodeMt = $this->db->query("SELECT IT.ITEM_MT_UPC UPC, IT.ITEM_MT_MFG_PART_NO MPN FROM LZ_BARCODE_MT MT, ITEMS_MT IT WHERE MT.ITEM_ID = IT.ITEM_ID AND MT.BARCODE_NO = '$bar' ")->result_array();
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
                    if($cancellation_id){
                        $uri[$cancellation_id][$j] = $base_url. $withoutMasterPartUri;
                    }else{
                        $uri[$bar][$j] = $base_url. $withoutMasterPartUri;
                    }
                    // if($uri[$barcode['LZ_barcode_ID']]){
                    //     break;
                    // }
                    
                    $j++;
                }    
                }else{
                        if($cancellation_id){
                            $uri[$cancellation_id][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                            $uri[$cancellation_id][1] = false;
                        }else{
                            $uri[$bar][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                            $uri[$bar][1] = false;
                        }
                    }
            }else{
                    if($cancellation_id){
                            $uri[$cancellation_id][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                            $uri[$cancellation_id][1] = false;
                        }else{
                            $uri[$bar][0] = $base_url. "item_pictures/master_pictures/image_not_available.jpg";
                            $uri[$bar][1] = false;
                        }
            }
        }

	return array('uri'=>$uri);
    }
    
    
}
?>	