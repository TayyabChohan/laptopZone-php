<?php 

  class after_print_sticker extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }
 
   public function index()
  {

    // $username = "ali";
    // $password = "ali";
    if (
        isset($_POST['listid']) 
        && isset($_POST['binid'])
        && isset($_POST['barcode'])
        && isset($_POST['userid'])
        )
    {
      $list_id = $_POST['listid'];
      $audit_bin_id = $_POST['binid'];
	  	$remarks = "";
      $qry = $this->db->query("SELECT DISTINCT MD.ITEM_MT_BBY_SKU,MM.PURCH_REF_NO,MD.ITEM_MT_MANUFACTURE BRAND,MD.ITEM_MT_MFG_PART_NO MPN,T.EBAY_ITEM_DESC ITEM_DESC,T.EBAY_ITEM_ID,'*' || T.EBAY_ITEM_ID || '*' BAR_CODE FROM EBAY_LIST_MT T, ITEMS_MT IM, LZ_MANIFEST_DET MD, LZ_MANIFEST_MT MM WHERE T.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = MD.LAPTOP_ITEM_CODE AND MM.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND T.LIST_ID = $list_id");
	  	$row = $qry->result_array();
	    $prev_barcode = $_POST['barcode'];
	    $bar_qry = $this->db->query("SELECT MA.BARCODE_NO FROM LZ_DEKIT_US_DT DET, LZ_DEKIT_US_MT MA WHERE DET.BARCODE_PRV_NO = $prev_barcode AND DET.LZ_DEKIT_US_MT_ID = MA.LZ_DEKIT_US_MT_ID "); 
      $bar_result = $bar_qry->result_array();

	    $master_barcod = @$bar_result[0]["BARCODE_NO"];
      date_default_timezone_set("America/Chicago");
      $audit_datetime = date("Y-m-d H:i:s");
      $audit_datetime = "TO_DATE('".$audit_datetime."', 'YYYY-MM-DD HH24:MI:SS')";
      $audit_by = $_POST['userid'];
  
      if(!empty($_POST['barcode'])){
        $barcode = $_POST['barcode']; 
  
          // for New entered Bin
        $bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$audit_bin_id'");
        $result = $bin_id_qry->result_array();
        $new_bin_id = @$result[0]['BIN_ID'];
  
        /*==== Bin Assignment to item barcode start ====*/
        $current_bin_qry = $this->db->query("SELECT MT.BIN_ID FROM LZ_BARCODE_MT MT WHERE MT.BARCODE_NO = $barcode");
        $bin_result = $current_bin_qry->result_array();
        $old_loc_id = @$bin_result[0]['BIN_ID'];
  
         // echo $new_bin_id;
          if(!(empty($new_bin_id))){
  
                  $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
                  $rs = $log_id_qry->result_array();
                  $loc_trans_id = @$rs[0]['ID'];							
                  $qryLogRes=$this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $audit_datetime, $barcode, $audit_by, '$new_bin_id', '$old_loc_id', '$remarks',null,null)"); 
                  //echo $qryLogRes;
                  if($qryLogRes=='1')
                  {
                     $qryLogBool=true;
                  }
  
          }


          if(empty($new_bin_id)){
            $new_bin_id = $old_loc_id;
          }
                $qqry2update="UPDATE LZ_BARCODE_MT SET EBAY_STICKER = 1, AUDIT_DATETIME = $audit_datetime, AUDIT_BY = $audit_by, BIN_ID = '$new_bin_id' WHERE BARCODE_NO = $barcode";
                $qryRes =$this->db->query($qqry2update);
                // echo $qryRes;
                $qryUpdateBool=false;
                $qryLogBool=false;
                if($qryRes=='1')
                {
                  $qryUpdateBool=true;
                }
  
                
          echo(json_encode(array(
            "error"=>false,
            "update_query_execution"=>$qryUpdateBool,
            "log_query_execution"=>$qryLogBool
           )));
  
          /*==== Bin Assignment to item barcode end ====*/					
      }		
  
      
     }
      else 
     {
         echo(json_encode(array(
           "error"=>true,
           "api_message"=>"Empty Paraeters!"
           )));
      }
    
  }

}