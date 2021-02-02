<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_locations extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function add_warhouse(){

    
    $ware_no = $this->input->post('ware_no');
    
    $ware_desc = $this->input->post('ware_desc');
    $ware_desc = trim(str_replace("  ", ' ', $ware_desc));
    $ware_desc = trim(str_replace(array("'"), "''", $ware_desc));

    $ware_loc = $this->input->post('ware_loc');
    $ware_loc = trim(str_replace("  ", ' ', $ware_loc));
    $ware_loc = trim(str_replace(array("'"), "''", $ware_loc));

    $war_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('WAREHOUSE_MT', 'WAREHOUSE_ID')ID FROM DUAL")->result_array();
    $war_pk = $war_pk[0]['ID'];    
    $sav_war = $this->db->query ("INSERT INTO WAREHOUSE_MT(WAREHOUSE_ID,WAREHOUSE_NO,WAREHOUSE_DESC,LOCATION) VALUES($war_pk,$ware_no,'$ware_desc','$ware_loc')");
    
    
  }

  public function dropdowns(){
    $war_house = $this->db->query ("SELECT WAREHOUSE_ID,WAREHOUSE_DESC FROM WAREHOUSE_MT")->result_array();
    $reack_house = $this->db->query ("SELECT RACK_ID,RACK_NO FROM RACK_MT")->result_array();

    return array('war_house' => $war_house,'reack_house' => $reack_house);

  }
  public function load_ware_data(){
  
$bin_type_search = $this->session->userdata('bin_type_search');
$print_sta = $this->session->userdata('print_sta');

    $qry = $this->db->query("SELECT WAREHOUSE_NO,WAREHOUSE_DESC,LOCATION FROM WAREHOUSE_MT order by WAREHOUSE_ID asc ")->result_array();

    $rackqry = $this->db->query("SELECT RA.RACK_ID,RA.RACK_NO,WA.WAREHOUSE_DESC,RA.WIDTH,RA.HEIGHT,RA.NO_OF_ROWS,DECODE(RA.RACK_TYPE,1,'CAGE',2,'RACK') RACK_TYPE FROM RACK_MT RA ,WAREHOUSE_MT WA WHERE RA.WAREHOUSE_ID = WA.WAREHOUSE_ID and RA.RACK_ID <>0 ORDER BY RACK_ID ASC ")->result_array(); 
 
 $binqry ="  SELECT B.PRINT_STATUS, B.BIN_ID, B.BIN_NO || '-' || B.BIN_TYPE BIN_NAME, DECODE(BIN_TYPE, 'NA', 'W' || WA.WAREHOUSE_NO || '-' || M.RACK_NO || '-R' || ROW_NO || '-' || B.BIN_TYPE || '-' || B.BIN_NO, B.BIN_TYPE || '-' || B.BIN_NO) BIN_NO FROM BIN_MT B, LZ_RACK_ROWS RA, RACK_MT M, WAREHOUSE_MT WA WHERE BIN_TYPE NOT IN ('No Bin') AND B.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = M.RACK_ID AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID  ";

 if(!empty($bin_type_search) &&  $bin_type_search != 1 ){

  $binqry.=" AND  BIN_TYPE = '$bin_type_search' ";
  
} 
if(!empty($print_sta)){
$binqry.=" AND  PRINT_STATUS = $print_sta ";
}

$binqry.="  ORDER BY BIN_TYPE,BIN_NO  ";

 $binqry = $this->db->query($binqry)->result_array();

                                 

    return array('qry' => $qry,'rackqry' => $rackqry,'binqry' => $binqry);
  }

  public function add_rack(){
  $rack_no = $this->input->post('rack_no');
  $rack_no = trim(str_replace("  ", ' ', $rack_no));
  $rack_no = trim(str_replace(array("'"), "''", $rack_no));
  $ware_na = $this->input->post('ware_na'); //ID
  $rack_width = $this->input->post('rack_width'); //ID
  $rack_height = $this->input->post('rack_height'); //ID
  $no_of_rows = $this->input->post('no_of_rows'); //ID

  $rack_type = $this->input->post('rack_type'); //ID
  $no_of_rack = $this->input->post('no_of_rack'); //ID

  for ($p=0; $p < $no_of_rack; $p++ ):
  $rack_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('RACK_MT', 'RACK_ID')ID FROM DUAL")->result_array();
  $rack_pk = $rack_pk[0]['ID'];
  $get_val = $this->db->query("SELECT 'K' || '' || NVL(regexp_replace(MAX(RACK_NO), '[^[:digit:]]', '') + 1, 1) NEXT_VAL from RACK_MT r where r.rack_id = (select max(RACK_ID) from RACK_MT) ")->result_array(); 
  $get_val = $get_val[0]['NEXT_VAL'];  
  $sav_war = $this->db->query ("INSERT INTO RACK_MT(RACK_ID,RACK_NO,WAREHOUSE_ID,WIDTH,HEIGHT,NO_OF_ROWS,RACK_TYPE) VALUES($rack_pk,
      '$get_val',$ware_na,$rack_width,$rack_height,$no_of_rows,$rack_type)");
             
    // insertion for LZ_RACK_ROWS START
              for ($j = 1; $j<=$no_of_rows ; $j++){ // 2
                $row_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_RACK_ROWS', 'RACK_ROW_ID')ID FROM DUAL")->result_array();
                $row_pk = $row_pk[0]['ID'];              


                $this->db->query ("INSERT INTO LZ_RACK_ROWS(RACK_ROW_ID,RACK_ID,ROW_NO) values($row_pk,'$rack_pk',$j)");
            };//2
    // insertion for LZ_RACK_ROWS end
endfor;
  

  }

  public function add_bin(){
  $bin_type = $this->input->post('bin_type');
  $no_bin = $this->input->post('no_bin');


 if(!empty($bin_type) &&  $bin_type != 1 ){
  
for ($p=0; $p < $no_bin; $p++ ):
    $bin_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('BIN_MT', 'BIN_ID')ID FROM DUAL")->result_array();
    $bin_pk = $bin_pk[0]['ID']; 

    $bin_no = $this->db->query(" SELECT GET_BIN_NO('$bin_type') BIN_NO FROM DUAL ")->result_array();
    
    $bin_no = $bin_no[0]['BIN_NO']; 
    $sav_war = $this->db->query ("INSERT INTO BIN_MT(BIN_ID,BIN_NO,BIN_TYPE) VALUES($bin_pk,'$bin_no','$bin_type')");
  
endfor;
}
  }
  
  public function print_all_racks(){
    $rack_id = $this->uri->segment(4);

    $rack_stick = $this->db->query("SELECT 'W' || '' || WA.WAREHOUSE_NO || '-' || RA.RACK_NO RACK_NAME FROM RACK_MT RA, WAREHOUSE_MT WA WHERE RACK_ID = $rack_id AND RA.WAREHOUSE_ID = WA.WAREHOUSE_ID ")->result_array();
    return $rack_stick;

  }

// BY DANISH ON 3-3-2018
    function getbin(){
    $bin_name = strtoupper(trim($this->input->post('bin_name')));
    //var_dump($bin_name); exit;
     $bind_ids = $this->db->query("SELECT CURRENT_RACK_ROW_ID RACK_ROW_ID, BIN_ID, 'W' || '' || WAREHOUSE_NO || '-' || RACK_NO || ' | ' || DECODE(ROW_NO, NULL, NULL, 0, 'N' || '' || ROW_NO, 'R' || '' || ROW_NO) || ' | ' || BIN_NAME RACK_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME, B.CURRENT_RACK_ROW_ID, RA.RACK_NO, MT.WAREHOUSE_NO, R.ROW_NO FROM BIN_MT B, LZ_RACK_ROWS R, RACK_MT RA, WAREHOUSE_MT MT WHERE B.CURRENT_RACK_ROW_ID = R.RACK_ROW_ID AND RA.WAREHOUSE_ID = MT.WAREHOUSE_ID AND R.RACK_ID = RA.RACK_ID) WHERE BIN_NAME = '$bin_name'")->result_array();
     if (count($bind_ids) >0) {
      $bin_id    = $bind_ids[0]['BIN_ID'];
      if (!empty($bin_id)) {
        $transfers = $this->db->query("SELECT B.BARCODE_NO BARCOD, B.BIN_ID, I.ITEM_DESC DESCR, I.ITEM_MT_UPC  UPC, I.ITEM_MT_MFG_PART_NO MPN, MAX_BAR.TRANS_BY_ID TRANS_BY_ID,  TO_CHAR(MAX_BAR.TRANS_DATE_TIME, 'MM-DD-YYYY HH24:MI:SS') AS TRANSFER_DATE FROM LZ_BARCODE_MT B, BIN_MT M, ITEMS_MT I, (SELECT LL.BARCODE_NO, M.FIRST_NAME ||' '||M.LAST_NAME TRANS_BY_ID, LL.TRANS_DATE_TIME FROM LZ_LOC_TRANS_LOG LL,EMPLOYEE_MT M WHERE LL.LOC_TRANS_ID IN (SELECT MAX(L.LOC_TRANS_ID) FROM LZ_LOC_TRANS_LOG L GROUP BY L.BARCODE_NO) AND LL.TRANS_BY_ID = M.EMPLOYEE_ID) MAX_BAR WHERE B.BIN_ID = M.BIN_ID AND B.ITEM_ID = I.ITEM_ID AND B.BARCODE_NO = MAX_BAR.BARCODE_NO(+) AND B.BIN_ID = $bin_id")->result_array();
      }else{
        $transfers = [];
      }
      
     }else{
      $transfers = [];
     }
    return array('bind_ids'=>$bind_ids, 'transfers'=>$transfers);
     }

  function updatebin(){
    
    $current_location = $this->input->post('current_location');
    $new_location = $this->input->post('new_location');
    $current_bin_id = $this->input->post('current_bin_id');
    $bin_remarks = $this->input->post('bin_remarks');
    $current_row_id = $this->input->post('current_row_id');
    $new_rack = $this->input->post('new_rack');

    var_dump($current_location);
var_dump($new_location);
var_dump($bin_remarks);
var_dump($current_row_id);
var_dump($new_rack);
exit;


    $new_rack= trim($this->input->post('new_rack'));
    $new_rack = str_replace("  ", " ", $new_rack);
    $new_rack = str_replace("'", "''", $new_rack);


    $bin_remarks= trim($this->input->post('bin_remarks'));
    $bin_remark = str_replace("  ", " ", $bin_remarks);
    $bin_remarks = str_replace("'", "''", $bin_remark);
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $transfer_by_id = $this->session->userdata('user_id');

    $bindId = $this->db->query(" SELECT BIN_ID,BIN_NAME FROM (SELECT B.BIN_ID, DECODE(B.BIN_TYPE, 'TC', 'TC', 'PB', 'PB', 'WB', 'WB', 'AB', 'AB', 'DK', 'DK', 'NA', 'NA') || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_ID = $current_bin_id ")->result_array();

   
  if (count($bindId) > 0) {
      $new_bin_id = $bindId[0]['BIN_ID'];

       $rack_na = $this->db->query(" SELECT * FROM (SELECT RO.RACK_ROW_ID, 'W' || '' || WA.WAREHOUSE_NO || '-' || RA.RACK_NO || '-' || 'R' || RO.ROW_NO RACK_NAME FROM RACK_MT RA, WAREHOUSE_MT WA, LZ_RACK_ROWS RO WHERE /*RA.RACK_ID = 10000000013 AND */RA.WAREHOUSE_ID = WA.WAREHOUSE_ID AND RA.RACK_ID = RO.RACK_ID AND RO.RACK_ROW_ID <> 0) WHERE RACK_NAME  = '$new_rack' ")->result_array();
         $rack_row_id = $rack_na[0]['RACK_ROW_ID'];

      // var_dump($new_bin_id);
      // EXIT;
      //$bindId = $this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = '$new_bin_id' WHERE BARCODE_NO = $current_barcode");
      $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BIN_TRANS_LOG','BIN_TRANS_LOG_ID') ID FROM DUAL");
          $rs = $qry->result_array();
          $bin_trans_id = $rs[0]['ID'];
      $updateBin = $this->db->query("INSERT INTO LZ_BIN_TRANS_LOG (BIN_TRANS_LOG_ID, BIN_ID,OLD_RACK_ROW_ID,NEW_RACK_ROW_ID,TRANSFER_DATE,TRANSFER_BY,REMARKS) VALUES($bin_trans_id, $current_bin_id,
      '$current_row_id',$rack_row_id,$transfer_date,$transfer_by_id,'$bin_remarks')");
      if ($updateBin) {
          $this->db->query(" UPDATE BIN_MT BK SET BK.CURRENT_RACK_ROW_ID = $rack_row_id WHERE BK.BIN_ID  =$new_bin_id  ");

       return 1;
      }else
      return 0;

    }else{
      return 2;
     }
    }
    //end by danish on 3-3-2018 

// danish 2-3-2018
function save_pack(){
$pack_name = $this->input->post('packing_name');
$pack_length = $this->input->post('packing_length'); 
$pack_width = $this->input->post('packing_width'); 
$pack_heigth = $this->input->post('packing_heigth'); 
$pack_type = $this->input->post('packing_type'); 
$pack_weigth = $this->input->post('packing_weigth'); 
$pack_cost = $this->input->post('packing_cost'); 
$user_id        = $this->session->userdata('user_id');
    //var_dump($packing_id, $packing_barcode); exit;
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $packing_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";


$sql= $this->db->query("SELECT * FROM LZ_PACKING_TYPE_MT where PACKING_NAME = '$pack_name' and PACKING_LENGTH=$pack_length and PACKING_WIDTH=$pack_width and PACKING_HEIGTH=$pack_heigth and PACKING_TYPE='$pack_type'");
     if($sql->num_rows()>0){
      $this->session->set_flashdata('packing_info', ' Packing Details Already Exist');
      redirect('locations/c_locations/ViewPacking');
     }else{
      
$qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_Packing_Type_mt','PACKING_ID') ID FROM DUAL"); 
$rs = $qry->result_array();
$packing_id = @$rs[0]['ID'];

   $query=$this->db->query ("INSERT INTO LZ_Packing_Type_mt(PACKING_ID,PACKING_NAME,PACKING_LENGTH,PACKING_WIDTH,PACKING_HEIGTH,PACKING_TYPE,PACKING_WEIGTH,PACKING_DATE,PACKING_BY,PACKING_COST) VALUES($packing_id,'$pack_name',$pack_length,$pack_width,$pack_heigth,'$pack_type',$pack_weigth,$packing_date,$user_id,$pack_cost)");
    if($query){
      $this->session->set_flashdata('packing_success', ' Packing Details Inserted Succcessful');
      redirect('locations/c_locations/ViewPacking');
    }
    else{
      $this->session->set_flashdata('packing_error', 'Something is wrong.Please Try Again!!');
      redirect('locations/c_locations/ViewPacking');
    }
  } 

     }










/////// end of save_pack function
    public function load_pack_data(){
     $pckqry = $this->db->query("  SELECT * FROM  LZ_Packing_Type_mt order by PACKING_ID DESC")->result_array();

    return $pckqry;
  }
   public function deletePacking(){
    $packing_id = $this->input->post('packing_id');
    //var_dump($packing_id);
    //exit;
    $query= $this->db->query("DELETE FROM LZ_PACKING_TYPE_MT where PACKING_ID=$packing_id");
     if($query){
      return 1;
     }else{
      return 2;
     }
   }
  /// end of function
 //end of by danish on 2-3-2018
/*/////////////////////////////////////////////////////////////////////////
  ///       TRANSFER LOACTION CODE WRITTEN BY MUHAMMAD IMRAN 28-02-2018   ///
  /////////////////////////////////////////////////////////////////////////*/
  function getLocation(){
    $barcode = $this->input->post('barcode');
        
     return $bindId = $this->db->query("SELECT BAR.BARCODE_NO, RO.RACK_ROW_ID, B.BIN_ID, DECODE(B.BIN_ID,0,'NO BIN', DECODE(M.RACK_NO, NULL, NULL, 'W' || '' || WA.WAREHOUSE_NO || '-' || M.RACK_NO) || ' | ' || DECODE(RO.ROW_NO, NULL, NULL,0,'N' || '' || RO.ROW_NO, 'R' || '' || RO.ROW_NO) || ' | ' || DECODE(B.BIN_TYPE, 'TC', 'TC', 'PB', 'PB', 'WB', 'WB', 'AB', 'AB', 'NA', 'NA', 'NB', 'NO BIN') || '-' || B.BIN_NO )BIN_NAME FROM BIN_MT        B, LZ_RACK_ROWS  RO, RACK_MT       M, WAREHOUSE_MT  WA, LZ_BARCODE_MT BAR WHERE B.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID(+) AND RO.RACK_ID = M.RACK_ID(+) AND M.WAREHOUSE_ID = WA.WAREHOUSE_ID(+) AND B.BIN_ID = BAR.BIN_ID AND BAR.BARCODE_NO = $barcode ")->result_array();
     } 
     //CODE ADDED BY ADIL ASAD ON 3-3-2018 END
   

    
    function getPacking(){
    $barcode = $this->input->post('barcode');

    $barcodeInfo = $this->db->query("SELECT D.ITEM_MT_DESC, D.CONDITIONS_SEG5, D.ITEM_MT_UPC, D.ITEM_MT_MFG_PART_NO, B.PACKING_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET D WHERE B.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID AND D.LAPTOP_ITEM_CODE = (SELECT ITEM_CODE FROM LZ_BARCODE_MT B, ITEMS_MT I WHERE I.ITEM_ID = B.ITEM_ID AND BARCODE_NO = '$barcode') AND B.BARCODE_NO = '$barcode'")->result_array();
     
    $packings = $this->db->query("SELECT * FROM LZ_PACKING_TYPE_MT")->result_array();

   $pqry = $this->db->query("SELECT B.PACKING_ID,P.PACKING_NAME,P.PACKING_LENGTH,P.PACKING_WIDTH,P.PACKING_HEIGTH,P.PACKING_TYPE,COUNT(1)  cnt FROM LZ_BARCODE_MT B, LZ_PACKING_TYPE_MT P WHERE B.ITEM_ID = (SELECT ITEM_ID FROM LZ_BARCODE_MT WHERE BARCODE_NO = '$barcode') AND B.BARCODE_NO <> '$barcode' AND B.PACKING_ID IS NOT NULL AND B.PACKING_ID = P.PACKING_ID GROUP BY B.PACKING_ID,P.PACKING_NAME,P.PACKING_LENGTH,P.PACKING_WIDTH,P.PACKING_HEIGTH,P.PACKING_TYPE ORDER BY COUNT(1) DESC")->result_array();

    return array('barcodeInfo' =>$barcodeInfo, 'packings' =>$packings, 'pdata'=>$pqry);
    }


    function updatePacking(){
    $packing_id     = $this->input->post('select_packing');
    $packing_barcode     = $this->input->post('packing_barcode');
    $user_id        = $this->session->userdata('user_id');
    //var_dump($packing_id, $packing_barcode); exit;
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $packing_date = "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $updatePacking = $this->db->query("UPDATE LZ_BARCODE_MT SET PACKING_ID = $packing_id, PACKING_BY = $user_id, PACKING_DATE = $packing_date  WHERE BARCODE_NO = $packing_barcode");
     if ($updatePacking) {
      return 1;
    }else{
      return 0;
    }
    }
///////////////////////////////////////////////
public function printAllStickers(){  	
  $barcode = $this->input->post('barcode');
  $print_qry = $this->db->query("SELECT MT.EBAY_ITEM_ID, MT.BARCODE_NO,'R#' || TO_DATE(I.ENTERED_DATE_TIME,'YYYY-MM-DD') REF_DATE,ROWNUM AS UNIT_NO,I.ITEM_DESC, (SELECT COUNT(B.EBAY_ITEM_ID) FROM LZ_BARCODE_MT B WHERE B.EBAY_ITEM_ID = (SELECT 
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
///////////////////////////////////////////////
public function get_barcode_if_number($barcode){
  //$barcode = $this->input->post('barcode');
// var_dump($barcode);
$conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 
$str = strlen($barcode);//if length = 12 its ebay id

    if($str == 12){
      $ebY_deta = $this->db->query(" SELECT B.BARCODE_NO,
       CASE
         WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
              DE.TRACKING_NUMBER IS NOT NULL THEN
          'SOLD || SHIPPED'
         WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
              DE.TRACKING_NUMBER IS NULL THEN
          'SOLD || NOT SHIPPED'
         ELSE
          'AVAILABLE'
       END STATUS,
       B.EBAY_ITEM_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_MANUFACTURE MANUF,
       I.ITEM_MT_MFG_PART_NO MPN,
       I.ITEM_MT_UPC UPC,
       CO.COND_NAME CONDI,
       BI.BIN_ID,
       BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
       DECODE(ROW_NO,
              0,
              RC.RACK_NO,
              'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
              RA.ROW_NO) RACK_NAME,
              (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN
  FROM LZ_BARCODE_MT    B,
       LZ_SALESLOAD_DET DE,
       ITEMS_MT         I,
       LZ_ITEM_COND_MT  CO,
       BIN_MT           BI,
       LZ_RACK_ROWS     RA,
       RACK_MT          RC,
       WAREHOUSE_MT     WA
 WHERE B.EBAY_ITEM_ID = $barcode
   AND B.ITEM_ID = I.ITEM_ID
   AND B.BIN_ID = BI.BIN_ID(+)
   AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
   AND RA.RACK_ID = RC.RACK_ID
   AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+)
   AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
   AND B.CONDITION_ID = CO.ID(+) ")->result_array();

    $uri = $this->get_pictures_by_barcode($ebY_deta,$conditions);

            $images = $uri['uri'];

     return array( "found" => true, "message" => "Barcode Found", 'data' => $ebY_deta,'eby_qyery'=>true, "images" => $images );
    }else{     

      $bar_query = $this->db->query(" SELECT B.BARCODE_NO FROM LZ_BARCODE_MT  B WHERE B.BARCODE_NO ='$barcode'");

if ($bar_query->num_rows() > 0) {
  $bar_query = $bar_query->result_array();
  $bar_no = $bar_query[0]['BARCODE_NO'];
  
  $bar_deta = $this->db->query("SELECT B.BARCODE_NO,
       CASE
         WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
              DE.TRACKING_NUMBER IS NOT NULL THEN
          'SOLD || SHIPPED'
         WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
              DE.TRACKING_NUMBER IS NULL THEN
          'SOLD || NOT SHIPPED'
         ELSE
          'AVAILABLE'
       END STATUS,
       B.EBAY_ITEM_ID,
       I.ITEM_DESC DESCR,
       I.ITEM_MT_MANUFACTURE MANUF,
       I.ITEM_MT_MFG_PART_NO MPN,
       I.ITEM_MT_UPC UPC,
       CO.COND_NAME CONDI,
       BI.BIN_ID,
       BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
       DECODE(ROW_NO,
              0,
              RC.RACK_NO,
              'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
              RA.ROW_NO) RACK_NAME,
              (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN
  FROM LZ_BARCODE_MT    B,
       ITEMS_MT         I,
       LZ_SALESLOAD_DET DE,
       LZ_ITEM_COND_MT  CO,
       BIN_MT           BI,
       LZ_RACK_ROWS     RA,
       RACK_MT          RC,
       WAREHOUSE_MT     WA
 WHERE B.BARCODE_NO = $bar_no
   AND B.ITEM_ID = I.ITEM_ID
   AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+)
   AND B.BIN_ID = BI.BIN_ID(+)
   AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
   AND RA.RACK_ID = RC.RACK_ID
   AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
   AND B.CONDITION_ID = CO.ID(+)
")->result_array();
$uri = $this->get_pictures_by_barcode($bar_deta,$conditions);

            $images = $uri['uri'];

   return array( "found" => true, "message" => "Barcode Found", 'data' =>$bar_deta,'bar_query'=>true, "images" => $images); // if barcode valid
}else{

    $bar_deta = $this->db->query("SELECT B.BARCODE_PRV_NO BARCODE_NO,
       'NULL' EBAY_ITEM_ID,
       'NULL' DESCR,
       'NULL' MANUF,
       NULL UPC,
       NULL MPN,
       CO.COND_NAME CONDI,
       BI.BIN_ID,
       BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
       DECODE(ROW_NO,
              0,
              RC.RACK_NO,
              'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
              RA.ROW_NO) RACK_NAME,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN
  FROM LZ_DEKIT_US_DT  B,
       LZ_ITEM_COND_MT CO,
       BIN_MT          BI,
       LZ_RACK_ROWS    RA,
       RACK_MT         RC,
       WAREHOUSE_MT    WA
 WHERE B.BARCODE_PRV_NO = $barcode
   AND B.BIN_ID = BI.BIN_ID(+)
   AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
   AND RA.RACK_ID = RC.RACK_ID
   AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
   AND B.CONDITION_ID = CO.ID(+)
")->result_array();

    if( count($bar_deta) > 0){
      $uri = $this->get_pictures_by_barcode($bar_deta,$conditions);

            $images = $uri['uri'];
      return array( "found" => true, "message" => "Barcode Found", 'data' =>$bar_deta ,'det_bar'=>true,  "images" => $images); 
    }
   //} // if barcode not valid
}
    $bar_deta = $this->db->query("SELECT B.BARCODE_PRV_NO BARCODE_NO,
       'NULL' EBAY_ITEM_ID,
       B.MPN_DESCRIPTION DESCR,
       B.BRAND MANUF,
      B.CARD_UPC UPC,
      B.CARD_MPN MPN,
       CO.COND_NAME CONDI,
       BI.BIN_ID,
       BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
       DECODE(ROW_NO,
              0,
              RC.RACK_NO,
              'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
              RA.ROW_NO) RACK_NAME,
       (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN
  FROM LZ_SPECIAL_LOTS B,
       LZ_ITEM_COND_MT CO,
       BIN_MT          BI,
       LZ_RACK_ROWS    RA,
       RACK_MT         RC,
       WAREHOUSE_MT    WA
 WHERE B.BARCODE_PRV_NO = $barcode
   AND B.BIN_ID = BI.BIN_ID(+)
   AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
   AND RA.RACK_ID = RC.RACK_ID
   AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
   AND B.CONDITION_ID = CO.ID(+)
   AND LZ_MANIFEST_DET_ID IS NULL
")->result_array();

    if( count($bar_deta) == 0 ){
      $bar_deta = $this->db->query("SELECT B.BARCODE_NO,
       'NULL' EBAY_ITEM_ID,
       'NULL' DESCR,
       'NULL' MANUF,
       NULL UPC,
       NULL MPN,
       'NULL' CONDI,
       BI.BIN_ID,
       BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
       DECODE(ROW_NO,
              0,
              RC.RACK_NO,
              'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
              RA.ROW_NO) RACK_NAME,
      (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN
  FROM LZ_MERCHANT_BARCODE_DT B,
       BIN_MT                 BI,
       LZ_RACK_ROWS           RA,
       RACK_MT                RC,
       WAREHOUSE_MT           WA
 WHERE B.BARCODE_NO = $barcode
   AND B.BIN_ID = BI.BIN_ID(+)
   AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
   AND RA.RACK_ID = RC.RACK_ID
   AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
")->result_array();
 $uri = $this->get_pictures_by_barcode($bar_deta,$conditions);

            $images = $uri['uri'];
      return array( "found" => true, "message" => "Barcode Found", 'data' =>$bar_deta ,'det_bar'=>true, "images" => $images); 
    }
 $uri = $this->get_pictures_by_barcode($bar_deta,$conditions);

            $images = $uri['uri'];
   return array( "found" => true, "message" => "Barcode Found", 'data' =>$bar_deta ,'det_bar'=>true, "images" => $images); 

}
}
  public function get_barcode(){
    $input = $this->input->post('input');
    $qdata_ar = preg_split('/\s+/', $input,-1, PREG_SPLIT_NO_EMPTY);
    $indx="";
    $indxOR="";
    $conditions = $this->db->query("SELECT * FROM LZ_ITEM_COND_MT A where A.COND_DESCRIPTION is not null order by a.id")->result_array(); 

    foreach($qdata_ar as $key=>$indx1)
    {
        if($key>0)
        {
            $indxOR=" AND ";
        }
        $indx.=$indxOR." upper(s.item_title) LIKE upper('%$indx1%') ";
      
    }
  //echo $indx;
  $whereclause=$indx;
  $ebaybarcode="";
  if(is_numeric ($input))
  {
    $ebaybarcode="B.EBAY_ITEM_ID = $input OR b.barcode_no = $input  OR";
    $numberResult= $this->get_barcode_if_number($input);
    if (count($numberResult["data"])>0)
    {
      return $numberResult;
    }
  }
  
  // var_dump($barcode);
        $input_deta = $this->db->query("SELECT B.BARCODE_NO,
        CASE
          WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
               DE.TRACKING_NUMBER IS NOT NULL THEN
           'SOLD || SHIPPED'
          WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND
               DE.TRACKING_NUMBER IS NULL THEN
           'SOLD || NOT SHIPPED'
          ELSE
           'AVAILABLE'
        END STATUS,
        B.EBAY_ITEM_ID,
        s.item_title DESCR,
        s.f_manufacture MANUF,
        s.F_MPN MPN, 
        s.F_UPC UPC,
        CO.COND_NAME CONDI,
        BI.BIN_ID,
        BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
        DECODE(ROW_NO,
               0,
               RC.RACK_NO,
               'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
               RA.ROW_NO) RACK_NAME,
        (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = B.BARCODE_NO
           AND ROWNUM = 1) VERIFIED_YN
   FROM LZ_BARCODE_MT    B,
        LZ_SALESLOAD_DET DE,
        lz_item_seed     s,
        LZ_ITEM_COND_MT CO,
        BIN_MT          BI,
        LZ_RACK_ROWS    RA,
        RACK_MT         RC,
        WAREHOUSE_MT    WA
  WHERE (
    $ebaybarcode
     s.f_upc = '$input'
       OR s.f_mpn like '%$input%'
        OR  ($whereclause)
        )
    AND B.ITEM_ID = s.ITEM_ID
    and b.lz_manifest_id = s.lz_manifest_id
    and b.condition_id = s.default_cond
    AND B.BIN_ID = BI.BIN_ID(+)
    AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
    AND RA.RACK_ID = RC.RACK_ID
    AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+)
    AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
    AND B.CONDITION_ID = CO.ID(+)
 ");
 if ($input_deta->num_rows() > 0) {
     $input_deta = $input_deta->result_array();
     $uri = $this->get_pictures_by_barcode($input_deta,$conditions);

            $images = $uri['uri'];
       return array('data' => $input_deta, "images" => $images );
 }
 else
 {
  $input_deta = $this->db->query("SELECT sp.barcode_prv_no BARCODE_NO,
  'UNPOSTED' STATUS,
  null EBAY_ITEM_ID,
  SP.MPN_DESCRIPTION DESCR,
  SP.BRAND MANUF,
  sp.CARD_UPC UPC, 
  sp.CARD_MPN MPN,
  CO.COND_NAME CONDI,
  BI.BIN_ID,
  BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
  DECODE(ROW_NO,
  0,
  RC.RACK_NO,
  'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
  RA.ROW_NO) RACK_NAME,
  (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = sp.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN
  FROM lz_special_lots sp,
  LZ_ITEM_COND_MT CO,
  BIN_MT BI,
  LZ_RACK_ROWS RA,
  RACK_MT RC,
  WAREHOUSE_MT WA
  WHERE ( sp.barcode_prv_no = $input 
  OR
  sp.card_upc = '$input'
  OR sp.card_mpn like '%$input%'
  OR ( upper(sp.mpn_description) LIKE upper('%$input%') )
  )
  
  AND sp.BIN_ID = BI.BIN_ID(+)
  AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
  AND RA.RACK_ID = RC.RACK_ID
  AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
  AND sp.condition_id = CO.ID(+)");
  if ($input_deta->num_rows() > 0) {
    $input_deta = $input_deta->result_array();
    $uri = $this->get_pictures_by_barcode($input_deta,$conditions);

            $images = $uri['uri'];
      return array('data' => $input_deta, "images" => $images );
}
else
{
 $input_deta = $this->db->query("SELECT sp.barcode_prv_no BARCODE_NO,
 'UNPOSTED' STATUS,
 null EBAY_ITEM_ID,
 SP.MPN_DESCRIPTION DESCR,
 NULL MANUF,
 NULL UPC,
 NULL MPN,
 CO.COND_NAME CONDI,
 BI.BIN_ID,
 BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME,
 DECODE(ROW_NO,
 0,
 RC.RACK_NO,
 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' ||
 RA.ROW_NO) RACK_NAME,
 (SELECT DT.BARCODE_NO
          FROM LJ_BIN_VERIFY_DT DT
         WHERE DT.BARCODE_NO = sp.BARCODE_PRV_NO
           AND ROWNUM = 1) VERIFIED_YN
 FROM LZ_DEKIT_US_DT sp,
 LZ_ITEM_COND_MT CO,
 BIN_MT BI,
 LZ_RACK_ROWS RA,
 RACK_MT RC,
 WAREHOUSE_MT WA
 WHERE (sp.barcode_prv_no = $input 
 
 OR ( upper(sp.mpn_description) LIKE upper('%$input%') )
 
 )
 AND sp.BIN_ID = BI.BIN_ID(+)
 AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID
 AND RA.RACK_ID = RC.RACK_ID
 AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID
 AND sp.condition_id = CO.ID(+)");
 $input_deta = $input_deta->result_array();
   $uri = $this->get_pictures_by_barcode($input_deta,$conditions);

            $images = $uri['uri'];
      return array('data' => $input_deta, "images" => $images );
}
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
                    $uri[$bar][$j] = $base_url. $withoutMasterPartUri;
                    // if($uri[$barcode['LZ_barcode_ID']]){
                    //     break;
                    // }
                    
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
public function get_barcode_notes(){

  $barcode = $this->input->post('barcode');
  // var_dump($barcode);
  // $str = strlen($barcode);//if length = 12 its ebay id

  //     if($str == 12){
  //       $ebY_deta = $this->db->query(" SELECT B.BARCODE_NO, CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END STATUS,  B.EBAY_ITEM_ID, I.ITEM_DESC DESCR, I.ITEM_MT_MANUFACTURE MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_BARCODE_MT   B,LZ_SALESLOAD_DET DE, ITEMS_MT I, LZ_ITEM_COND_MT CO, BIN_MT BI, LZ_RACK_ROWS  RA, RACK_MT  RC, WAREHOUSE_MT    WA WHERE B.EBAY_ITEM_ID =$barcode AND B.ITEM_ID = I.ITEM_ID AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();
  //      return array('ebY_deta' => $ebY_deta,'eby_qyery'=>true );
  //     }else{     

  $bar_query = $this->db->query(" SELECT B.BARCODE_NO FROM LZ_BARCODE_MT  B WHERE B.BARCODE_NO ='$barcode'");

  if ($bar_query->num_rows() > 0) {
    $bar_query = $bar_query->result_array();
    $bar_no = $bar_query[0]['BARCODE_NO'];
    //barcode mt query
    $bar_deta = $this->db->query(" SELECT B.BARCODE_NO,B.BARCODE_NOTES,'POSTED' SOURC,CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END STATUS, B.EBAY_ITEM_ID, I.ITEM_DESC DESCR, I.ITEM_MT_MANUFACTURE MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_BARCODE_MT B, ITEMS_MT I, LZ_SALESLOAD_DET DE, LZ_ITEM_COND_MT CO, BIN_MT BI, LZ_RACK_ROWS RA, RACK_MT  RC, WAREHOUSE_MT  WA WHERE B.BARCODE_NO = $bar_no AND B.ITEM_ID = I.ITEM_ID AND B.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();


     return array('bar_deta' =>$bar_deta,'bar_query'=>true); // if barcode valid
  }else {
    // dekit barcode query
      $bar_deta = $this->db->query(" SELECT B.BARCODE_PRV_NO BARCODE_NO,'DEKIT' SOURC,B.BARCODE_NOTES, OB.EBAY_ITEM_ID EBAY_ITEM_ID, DECODE(B.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION, B.MPN_DESCRIPTION) DESCR, CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END STATUS, C.BRAND MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_DEKIT_US_DT  B, LZ_ITEM_COND_MT CO, BIN_MT BI, LZ_RACK_ROWS    RA, RACK_MT    RC, WAREHOUSE_MT    WA, LZ_BARCODE_MT   OB, LZ_CATALOGUE_MT C, LZ_SALESLOAD_DET DE WHERE B.BARCODE_PRV_NO = $barcode AND B.BARCODE_PRV_NO = OB.BARCODE_NO(+) AND B.CATALOG_MT_ID = C.CATALOGUE_MT_ID(+) AND OB.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();

      if(count($bar_deta) >=1){
      return array('bar_deta' =>$bar_deta ,'bar_query'=>true);   
      }else{
        //special lot query
        $bar_deta = $this->db->query(" SELECT B.BARCODE_PRV_NO BARCODE_NO,'SPECIAL' SOURC, B.BARCODE_NOTES,OB.EBAY_ITEM_ID EBAY_ITEM_ID, DECODE(B.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION, B.MPN_DESCRIPTION) DESCR, CASE WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NOT NULL THEN 'SOLD || SHIPPED'WHEN DE.SALES_RECORD_NUMBER IS NOT NULL AND DE.TRACKING_NUMBER IS NULL THEN 'SOLD || NOT SHIPPED'ELSE 'AVAILABLE'END STATUS, C.BRAND MANUF, CO.COND_NAME CONDI, BI.BIN_ID, BI.BIN_TYPE || '-' || BI.BIN_NO BIN_NAME, DECODE(ROW_NO, 0, RC.RACK_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RC.RACK_NO || '-R' || RA.ROW_NO) RACK_NAME FROM LZ_SPECIAL_LOTS  B, LZ_ITEM_COND_MT CO, BIN_MT          BI, LZ_RACK_ROWS    RA, RACK_MT         RC, WAREHOUSE_MT    WA, LZ_BARCODE_MT   OB, LZ_CATALOGUE_MT C, LZ_SALESLOAD_DET DE WHERE B.BARCODE_PRV_NO = $barcode AND B.BARCODE_PRV_NO = OB.BARCODE_NO(+) AND B.CATALOG_MT_ID = C.CATALOGUE_MT_ID(+) AND OB.SALE_RECORD_NO = DE.SALES_RECORD_NUMBER(+) AND B.BIN_ID = BI.BIN_ID(+) AND BI.CURRENT_RACK_ROW_ID = RA.RACK_ROW_ID AND RA.RACK_ID = RC.RACK_ID AND RC.WAREHOUSE_ID = WA.WAREHOUSE_ID AND B.CONDITION_ID = CO.ID(+) ")->result_array();

        if(count($bar_deta) >=1){
          return array('bar_deta' =>$bar_deta ,'bar_query'=>true);

        }else{
          return array('bar_query'=>false);
        }


         
      }

      
     //} // if barcode not valid
  }
  // else{
  //   return array('bar_query'=>false);

  // }

//}// main if str length

}



public function update_loc(){
    $bar_codes = $this->input->post('bar_codes');
    $current_bin_id = $this->input->post('current_bin_id');
    $bar_status = $this->input->post('bar_status');

    // var_dump($bar_status);
    // exit;
   
     $scan_bin= trim($this->input->post('scan_bin'));
     $scan_bin = str_replace("  ", " ", $scan_bin);
     $scan_bin = str_replace("'", "''", $scan_bin);
     $scan_bin = strtoupper($scan_bin);

     $this->session->set_userdata('ses_bin',$scan_bin);


    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $transfer_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $transfer_by_id = $this->session->userdata('user_id');

    $bindId = $this->db->query(" SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$scan_bin' ")->result_array();
   
   
    if(count($bindId) > 0) {
       $bin_id = $bindId[0]['BIN_ID'];
    $i=0;
    foreach ($bar_codes as $comp) {
      
      $bar = $bar_codes[$i];
      $old_bin_id = $current_bin_id[$i];
      $get_bar_stat = $bar_status[$i]; 
      //if($get_bar_stat == 'AVAILABLE'){


      //var_dump($bar , $new_bin_id);
      $this->db->query("UPDATE LZ_BARCODE_MT SET BIN_ID = '$bin_id' WHERE BARCODE_NO = $bar");

      $qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL");
      $rs = $qry->result_array();
      $loc_trans_id = $rs[0]['ID'];

      $updateBin = $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS) VALUES($loc_trans_id, $transfer_date, $bar, $transfer_by_id, $bin_id, $old_bin_id, 'null')");
    //}
                
                  $i++;
      }
      return 1; // added sucess
     } else{

      return 2; // bin is incorrect
     } 

}


public function updat_notes(){
    $bar_codes = $this->input->post('bar_codes');

    $ent_note= trim($this->input->post('ent_note'));
    $ent_note = str_replace("  ", " ", $ent_note);
    $ent_note = str_replace("'", "''", $ent_note);
    
    $bar_status = $this->input->post('bar_status');  
    
    $i=0;
    foreach ($bar_codes as $comp) {
      
      $bar = $bar_codes[$i];
      //$old_bin_id = $current_bin_id[$i];
      $get_bar_stat = $bar_status[$i]; 

      if($get_bar_stat == 'POSTED'){
        $updatenot = $this->db->query("UPDATE LZ_BARCODE_MT SET BARCODE_NOTES = '$ent_note' WHERE BARCODE_NO = $bar");

      }elseif($get_bar_stat == 'DEKIT'){
        $updatenot = $this->db->query("UPDATE LZ_DEKIT_US_DT SET BARCODE_NOTES = '$ent_note' WHERE BARCODE_PRV_NO = $bar");

      }elseif($get_bar_stat == 'SPECIAL'){
        $updatenot = $this->db->query("UPDATE LZ_SPECIAL_LOTS SET BARCODE_NOTES = '$ent_note' WHERE BARCODE_PRV_NO = $bar");

      } 
                
        $i++;
      }
      if($updatenot){
        return 1;
      }else{
        return 2;
      }
}


public function loc_history_search(){
  $ser_barcode = $this->input->post('ser_barcode');

  $bar_query = $this->db->query(" SELECT B.BARCODE_NO FROM LZ_BARCODE_MT  B WHERE B.BARCODE_NO ='$ser_barcode'");

   if ($bar_query->num_rows() > 0) {

   $loc_his  = $this->db->query(" SELECT BB.BARCODE_NO,L.TRANS_DATE_TIME TRAN_DA, M.ITEM_DESC TITLE, M.FIRST_NAME || ' ' || M.LAST_NAME TRANSFER_BY, L.NEW_LOC_ID, L.OLD_LOC_ID, DECODE(NEW_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-R' || RO.ROW_NO || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO) NEW_LOCATION, DECODE(OLD_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO, 'W' || '' || OL_WA.WAREHOUSE_NO || '-' || OLD_RAC.RACK_NO || '-R' || RO_OLD.ROW_NO || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO) OLD_LOCATION FROM LZ_LOC_TRANS_LOG L, LZ_BARCODE_MT    BB, EMPLOYEE_MT      M, BIN_MT           NEW_B, BIN_MT           OLD_B, LZ_RACK_ROWS     RO, LZ_RACK_ROWS     RO_OLD, RACK_MT          RAC, RACK_MT          OLD_RAC, WAREHOUSE_MT     WA, WAREHOUSE_MT     OL_WA, ITEMS_MT         M WHERE L.BARCODE_NO = '$ser_barcode'AND BB.ITEM_ID = M.ITEM_ID /* NEW NEW_LOC_ID JOIN */ AND L.NEW_LOC_ID = NEW_B.BIN_ID AND NEW_B.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID AND RO.RACK_ID = RAC.RACK_ID AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID /* NEW NEW_LOC_ID JOIN */ AND BB.BARCODE_NO = L.BARCODE_NO AND L.TRANS_BY_ID = M.EMPLOYEE_ID /* OLD OLD_LOC_ID JOIN */ AND L.OLD_LOC_ID = OLD_B.BIN_ID AND OLD_B.CURRENT_RACK_ROW_ID = RO_OLD.RACK_ROW_ID AND RO_OLD.RACK_ID = OLD_RAC.RACK_ID AND OLD_RAC.WAREHOUSE_ID = OL_WA.WAREHOUSE_ID /* OLD OLD_LOC_ID JOIN */ ORDER BY L.LOC_TRANS_ID DESC ")->result_array();
   if($loc_his){
                 return array('loc_his' => $loc_his);
   }else{
   $this->session->set_flashdata('bar_info', 'Barcode does not have any History !!!');
      redirect('locations/c_locations/loc_history'); 

   }
   
  }
  // else{
  //   $this->session->set_flashdata('bar_error', 'Barcode is not Valid !!!');
      
  // }

  // else{

  //    $loc_his  = $this->db->query(" SELECT BB.BARCODE_PRV_NO, ob.object_name TITLE, M.FIRST_NAME || ' ' || M.LAST_NAME TRANSFER_BY, L.NEW_LOC_ID, L.OLD_LOC_ID, DECODE(NEW_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO, 'W' || '' || WA.WAREHOUSE_NO || '-' || RAC.RACK_NO || '-R' || RO.ROW_NO || '-' || NEW_B.BIN_TYPE || '' || NEW_B.BIN_NO) NEW_LOCATION, DECODE(OLD_B.CURRENT_RACK_ROW_ID, 0, 'No Rack' || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO, 'W' || '' || OL_WA.WAREHOUSE_NO || '-' || OLD_RAC.RACK_NO || '-R' || RO_OLD.ROW_NO || '-' || OLD_B.BIN_TYPE || '' || OLD_B.BIN_NO) OLD_LOCATION FROM LZ_LOC_TRANS_LOG L, lz_dekit_us_dt    BB, EMPLOYEE_MT      M, BIN_MT           NEW_B, BIN_MT           OLD_B, LZ_RACK_ROWS     RO, LZ_RACK_ROWS     RO_OLD, RACK_MT          RAC, RACK_MT          OLD_RAC, WAREHOUSE_MT     WA, WAREHOUSE_MT     OL_WA, lz_bd_objects_mt ob WHERE bb.barcode_prv_no = '$ser_barcode'and bb.object_id = ob.object_id AND L.NEW_LOC_ID = NEW_B.BIN_ID AND NEW_B.CURRENT_RACK_ROW_ID = RO.RACK_ROW_ID AND RO.RACK_ID = RAC.RACK_ID AND RAC.WAREHOUSE_ID = WA.WAREHOUSE_ID /* NEW NEW_LOC_ID JOIN */ AND BB.BARCODE_PRV_NO = L.BARCODE_NO AND L.TRANS_BY_ID = M.EMPLOYEE_ID /* OLD OLD_LOC_ID JOIN */ AND L.OLD_LOC_ID = OLD_B.BIN_ID AND OLD_B.CURRENT_RACK_ROW_ID = RO_OLD.RACK_ROW_ID AND RO_OLD.RACK_ID = OLD_RAC.RACK_ID AND OLD_RAC.WAREHOUSE_ID = OL_WA.WAREHOUSE_ID /* OLD OLD_LOC_ID JOIN */ ORDER BY L.LOC_TRANS_ID ASC ")->result_array(); return array('loc_his' => $loc_his);


  // }

}


  
}