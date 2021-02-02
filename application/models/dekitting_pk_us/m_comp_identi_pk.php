<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
class m_comp_identi_pk extends CI_Model{

public function __construct(){
    parent::__construct();
    $this->load->database();
  }

/*======================================
=             IMRAN WORK            =
======================================*/
public function get_items(){
  return $this->db->query("SELECT D.*, M.BARCODE_NO, O.OBJECT_NAME, O.CATEGORY_ID, C.COND_NAME, M.BARCODE_NO MAS_BAR, /* M.MASTER_MPN_ID, K.CATALOGUE_MT_ID,*/ /*  K.MPN_DESCRIPTION,*/ I.ITEM_DESC MPN_DESCRIPTION FROM LZ_DEKIT_US_DT   D, LZ_DEKIT_US_MT   M, LZ_BD_OBJECTS_MT O, LZ_ITEM_COND_MT  C, LZ_CATALOGUE_MT  K,LZ_BARCODE_MT MB,ITEMS_MT I WHERE D.OBJECT_ID = O.OBJECT_ID(+) AND D.CONDITION_ID = C.ID(+) AND M.MASTER_MPN_ID = K.CATALOGUE_MT_ID(+) AND D.LZ_DEKIT_US_MT_ID = M.LZ_DEKIT_US_MT_ID AND D.PIC_DATE_TIME IS NOT NULL AND D.PIC_BY IS NOT NULL  AND D.CATALOG_MT_ID IS NULL AND M.LZ_MANIFEST_MT_ID IS NOT NULL AND M.BARCODE_NO = MB.BARCODE_NO AND MB.ITEM_ID = I.ITEM_ID ORDER BY M.BARCODE_NO, D.BARCODE_PRV_NO ASC "); 


}
public function get_history(){
  
  $mpn = $this->input->post('mpn');
  $mpn_nam = $this->input->post('mpn_nam');
  $category_id = $this->input->post('category_id');

  $mpn_nam = strtoupper(trim(str_replace("  ", ' ', $mpn_nam)));
  $mpn_nam = str_replace(array("`,′"), "", $mpn_nam);
  $mpn_nam = str_replace(array("'"), "''", $mpn_nam);

  $mpn = strtoupper(trim(str_replace("  ", ' ', $mpn)));
  $mpn = str_replace(array("`,′"), "", $mpn);
  $mpn = str_replace(array("'"), "''", $mpn);
 

  $str = explode(' ', $mpn);
  $category_id = $this->input->post('category_id');

 $get_his_query = " SELECT * FROM (SELECT S.ITEM_TITLE TITLE, DECODE(S.CATEGORY_ID, NULL, O.CATEGORY_ID, S.CATEGORY_ID) CATE, I.ITEM_MT_MFG_PART_NO MPN, I.ITEM_MT_MANUFACTURE BRAND, S.EBAY_PRICE SOLD_PRICE, I.ITEM_MT_UPC UPC, I.ITEM_CONDITION COND_NAME, O.OBJECT_NAME OBJECT_NAME FROM LZ_ITEM_SEED  S, ITEMS_MT         I, LZ_CATALOGUE_MT  C, LZ_BD_OBJECTS_MT O WHERE S.ITEM_ID = I.ITEM_ID AND UPPER(I.ITEM_MT_MFG_PART_NO) = UPPER(C.MPN(+)) AND S.CATEGORY_ID = C.CATEGORY_ID(+) AND C.OBJECT_ID = O.OBJECT_ID(+) ORDER BY S.SEED_ID DESC) WHERE ROWNUM <= 20 ";

  $get_his_query.= "AND (UPPER(MPN) LIKE '%$mpn%' OR";

 if(!empty($mpn) ) { 
      if (count($str)>1) {
        $i=1;
        foreach ($str as $key) {
          if($i === 1){
            $get_his_query.="  UPPER(TITLE) LIKE '%$key%' ";
          }else{
            $get_his_query.=" AND UPPER(TITLE) LIKE '%$key%' ";
          }
          $i++;
        }
        $get_his_query.=" )";
      }else{
        $get_his_query.="  UPPER(TITLE) LIKE '%$mpn%' )";
      }
     }
     

$get_his=$this->db->query($get_his_query)->result_array();


 if(count($get_his)>=1 ){
 return array('get_his' =>$get_his,'exist'=>true); 
}else{


  $get_his_query = " SELECT * FROM (SELECT DECODE(D.MPN_DESCRIPTION, NULL, C.MPN_DESCRIPTION,D.MPN_DESCRIPTION) TITLE, C.CATEGORY_ID CATE, C.MPN, C.BRAND , C.UPC, CO.COND_NAME, OB.OBJECT_NAME,D.SOLD_PRICE FROM LZ_CATALOGUE_MT C, LZ_BD_ESTIMATE_DET D,LZ_ITEM_COND_MT CO,LZ_BD_OBJECTS_MT OB WHERE D.PART_CATLG_MT_ID = C.CATALOGUE_MT_ID AND D.TECH_COND_ID = CO.ID(+) AND C.OBJECT_ID = OB.OBJECT_ID (+)  ) WHERE  MPN is not null  ";

  $get_his_query.= "AND (UPPER(MPN) LIKE '%$mpn%' OR";

 if(!empty($mpn) ) { 
      if (count($str)>1) {
        $i=1;
        foreach ($str as $key) {
          if($i === 1){
            $get_his_query.="  UPPER(TITLE) LIKE '%$key%' ";
          }else{
            $get_his_query.=" AND UPPER(TITLE) LIKE '%$key%' ";
          }
          $i++;
        }
        $get_his_query.=" )";
      }else{
        $get_his_query.="  UPPER(TITLE) LIKE '%$mpn%' )";
      }

      $get_his_query.="  AND ROWNUM <=20 ";
     }

     $get_his=$this->db->query($get_his_query)->result_array();

     if(count($get_his) >=1){
      return array('get_his' =>$get_his,'exist'=>true); 

     }else{
      return array('exist'=>false); 

     }
  
  }

}

public function get_mpns(){
  $dekit_pk_us           = $this->input->post("dekit_pk_us");
  $category_id           = $this->input->post("category_id");
  $object_id             = $this->input->post("object_id");
  $child_barcode_no        = $this->input->post("child_barcode_no");
  // var_dump($child_barcode_no);
  // exit;

  date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $identified_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

    $user_id = $this->session->userdata('user_id');

  $check_ident = $this->db->query("SELECT D.LZ_DEKIT_US_DT_ID, D.CATALOG_MT_ID, D.IDENT_DATE_TIME, D.IDENTIFIED_BY, D.LOCK_STATUS FROM LZ_DEKIT_US_DT D WHERE D.LZ_DEKIT_US_DT_ID = $dekit_pk_us")->result_array();
  $catalog_mt_id         = $check_ident[0]['CATALOG_MT_ID'];
  $ident_date_time       = $check_ident[0]['IDENT_DATE_TIME'];
  $identified_by         = $check_ident[0]['IDENTIFIED_BY'];
  $lock_status           = $check_ident[0]['LOCK_STATUS'];
  //var_dump($identified_by); exit;
  //if (!empty($catalog_mt_id) || $catalog_mt_id == null || $catalog_mt_id == 'null') {

    if (!empty($identified_by) AND $identified_by != $user_id) {
      
      $employee_names = $this->db->query("SELECT E.USER_NAME FROM EMPLOYEE_MT E WHERE E.EMPLOYEE_ID = $identified_by")->result_array();
      $emp_name         = $employee_names[0]['USER_NAME'];
      return array("emp_name"=>$emp_name, "res"=>0,'flag'=>true);
    }elseif(($identified_by == $user_id) || ($identified_by =='')){
      
        //var_dump($category_id, $object_id); exit;
        $mpns = $this->db->query("SELECT * FROM LZ_CATALOGUE_MT MT WHERE MT.CATEGORY_ID = '$category_id' AND MT.OBJECT_ID = '$object_id'")->result_array();
        ///////////////////////FOR SHOW PICTURE/////////////////////////////////////////
          $det = $this->db->query("SELECT D.BARCODE_PRV_NO, D.CONDITION_ID, D.DEKIT_REMARKS,D.FOLDER_NAME FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D,LZ_BD_OBJECTS_MT O,BIN_MT B WHERE  D.BARCODE_PRV_NO = $child_barcode_no AND M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.OBJECT_ID = O.OBJECT_ID(+) AND D.BIN_ID = B.BIN_ID(+) ORDER BY D.BARCODE_PRV_NO ASC");
          $det = $det->result_array();
          // echo "<pre>";
          // print_r($det);
          // exit;
          $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
          $path = $path->result_array();

          $flag = [];
          $i = 0;
          $master_path = $path[0]["MASTER_PATH"];
          $dir_path = [];
          foreach (@$det as $row){
              $it_condition  = @$row['CONDITION_ID'];
            if(is_numeric(@$it_condition)){
                  if(@$it_condition == 3000){
                    @$it_condition = 'Used';
                  }elseif(@$it_condition == 1000){
                    @$it_condition = 'New'; 
                  }elseif(@$it_condition == 1500){
                    @$it_condition = 'New other'; 
                  }elseif(@$it_condition == 2000){
                      @$it_condition = 'Manufacturer refurbished';
                  }elseif(@$it_condition == 2500){
                    @$it_condition = 'Seller refurbished'; 
                  }elseif(@$it_condition == 7000){
                    @$it_condition = 'For parts or not working'; 
                  }
                }
                  // if($det[$i]['DEKIT_REMARKS'] == null){
                  //  $det[$i]['DEKIT_REMARKS'] == '';
                  // }
                  $barcode_prv_no = $row["FOLDER_NAME"];
                  $m_dir =  $master_path.$barcode_prv_no."/thumb/";
                  
                  $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

                  if(is_dir(@$m_dir)){
                          $iterator = new \FilesystemIterator(@$m_dir);
                          if (@$iterator->valid()){    
                            $m_flag = true;
                            $flag[$i] = $m_flag;

                             $images = scandir($m_dir);
                          // Image selection and display:
                          //display first image
                          if (count($images) > 0) { // make sure at least one image exists
                              $url = $images[2]; // first image
                              $img = file_get_contents($m_dir.$url);
                              // var_dump($img);exit;
                              $img =base64_encode($img);
                              $dir_path[$i] = $img;
                              $m_flag = true;
                          }else{
                            $dir_path[$i] = $m_dir;
                            $m_flag = false;
                          }

                        }else{
                          $m_flag = false;
                          $flag[$i] = $m_flag;
                        }
                      }else{
                        $m_flag = false;
                        $flag[$i] = $m_flag;
                    }

                    $i++;
          } // end foreach

          $update_dekit = $this->db->query("UPDATE LZ_DEKIT_US_DT SET IDENTIFIED_BY = $user_id, IDENT_DATE_TIME = $identified_date, LOCK_STATUS = 1  WHERE LZ_DEKIT_US_DT_ID = $dekit_pk_us");

          return array('det'=>$det ,'res'=>1,'flag'=>$flag,'dir_path'=>$dir_path, "mpn"=>$mpns);
      
    }else{
      return array('flag'=>0);
    }     
  // }else {
  //   return array('flag'=>0);
  // }
}
public function update_mpn(){
  $dekit_us_id         = $this->input->post("dekit_us_id");
  $catalogue_mt_id     = $this->input->post("catalogue_mt_id");
  $remarks             = $this->input->post("remarks");
  $mpn_description     = $this->input->post("mpn_description");

  // code section added by adil asad 1-23-2018 start
  $mpn_description = str_replace("  ", ' ', $mpn_description);
  $mpn_description = str_replace(array("'"), "''", $mpn_description);
  
  $brand_desc     = $this->input->post("brand_desc");

  $brand_desc = str_replace("  ", ' ', $brand_desc);
  $brand_desc = str_replace(array("'"), "''", $brand_desc);

  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $identified_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $user_id = $this->session->userdata('user_id');
  //var_dump($dekit_us_id, $catalogue_mt_id, $remarks, $mpn_description, $brand_desc); exit;

  $j = 0;
  foreach ($dekit_us_id as $mpn_id) {
    $this->db->query("UPDATE LZ_CATALOGUE_MT SET brand = '$brand_desc[$j]' WHERE CATALOGUE_MT_ID = $catalogue_mt_id");

      $update_dekit = $this->db->query("UPDATE LZ_DEKIT_US_DT SET CATALOG_MT_ID = $catalogue_mt_id, IDENT_DATE_TIME = $identified_date, IDENTIFIED_BY = $user_id, DEKIT_REMARKS = '$remarks[$j]', MPN_DESCRIPTION = '$mpn_description[$j]'   WHERE LZ_DEKIT_US_DT_ID = $mpn_id");
    if ($update_dekit) {
     $this->db->query("call pro_dekiting_us_pk($mpn_id)");
    }
    $j++;
  }

  // code section added by adil asad 1-23-2018 end
  //var_dump($category_id, $object_id); exit;
  if ($update_dekit) {
    return 1;
  }else {
    return 0;
  }
 }
  public function get_mpn_data(){
  $barcode_no       = $this->input->post("barcode_no");
  $object_id        = $this->input->post("object_id");
  $category_id      = $this->input->post("category_id");

  $insert_by = $this->session->userdata('user_id');  
  date_default_timezone_set("America/Chicago");
  $date = date('Y-m-d H:i:s');
  $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";

  $item_ids = $this->db->query("SELECT K.ITEM_ID,k.LZ_MANIFEST_ID FROM LZ_BARCODE_MT K WHERE K.BARCODE_NO = $barcode_no")->result_array();
  $item_id        = $item_ids[0]['ITEM_ID'];
  $lz_manifest_id        = $item_ids[0]['LZ_MANIFEST_ID'];
  if (!empty($item_id)) {
    // $mpns = $this->db->query("SELECT T.ITEM_MT_MFG_PART_NO FROM ITEMS_MT T WHERE T.ITEM_ID = $item_id")->result_array();
    // $mpn        = $mpns[0]['ITEM_MT_MFG_PART_NO'];
    $mpns = $this->db->query("SELECT * FROM (SELECT D.ITEM_MT_MFG_PART_NO , D.E_BAY_CATA_ID_SEG6 FROM LZ_MANIFEST_DET D, ITEMS_MT I WHERE D.LAPTOP_ITEM_CODE = I.ITEM_CODE AND I.ITEM_ID = '$item_id' AND D.LZ_MANIFEST_ID = '$lz_manifest_id' AND D.E_BAY_CATA_ID_SEG6 NOT IN ('N/A','NA','111222333444') ORDER BY D.LAPTOP_ZONE_ID DESC) WHERE ROWNUM = 1 ")->result_array();
    $mpn        = @$mpns[0]['ITEM_MT_MFG_PART_NO'];
    if(empty($category_id)){
      $category_id        = @$mpns[0]['E_BAY_CATA_ID_SEG6']; 
    }
    $item_mpn = strtoupper($mpn);
    if (!empty($mpn) && !empty($object_id)) {
    
    $mpn_data = $this->db->query("SELECT MT.CATALOGUE_MT_ID, MT.MPN, MT.BRAND, MT.MPN_DESCRIPTION, D.AVG_SELL_PRICE FROM LZ_CATALOGUE_MT MT, LZ_DEKIT_US_DT D WHERE MT.CATALOGUE_MT_ID = D.CATALOG_MT_ID(+) AND UPPER(MT.MPN) = '$item_mpn' AND MT.CATEGORY_ID = $category_id"); 
     if($mpn_data->num_rows() == 0){
        $get_mt_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
        //$get_mt_pk = $this->db->query("SELECT MAX(CATALOGUE_MT_ID + 1) CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT");
        $get_pk = $get_mt_pk->result_array();
        $cat_mt_id = $get_pk[0]['ID'];

        $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION) VALUES($cat_mt_id, '$item_mpn', $category_id, $insert_date, $insert_by,$object_id,'')");
        if ($mt_qry) {
          return $this->db->query("SELECT MT.CATALOGUE_MT_ID, MT.MPN, MT.MPN_DESCRIPTION, MT.BRAND FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN) = '$item_mpn' AND MT.CATEGORY_ID = '$category_id'")->result_array();
        }
     }else {
       return $mpn_data->result_array();
     }
  }else{
    return $this->db->query("SELECT MT.CATALOGUE_MT_ID, MT.MPN, MT.MPN_DESCRIPTION, MT.BRAND FROM LZ_CATALOGUE_MT MT WHERE UPPER(MT.MPN) = '$item_mpn' AND MT.CATEGORY_ID = '$category_id'")->result_array();
  }
  }

  //var_dump($category_id, $object_id); exit;
 }
public function showMpnDesc(){
  $bd_mpn_id      = $this->input->post("bd_mpn");
  // var_dump($bd_mpn_id);
  // exit;

  if (!empty($bd_mpn_id)) {
    $mpn_data = $this->db->query("SELECT M.MPN_DESCRIPTION ,M.BRAND FROM LZ_CATALOGUE_MT M WHERE M.CATALOGUE_MT_ID = $bd_mpn_id")->result_array();

    return $mpn_data;
  }


  //var_dump($category_id, $object_id); exit;
 }
 public function showAllPictures(){
      $master_barcode_no     = $this->input->post("master_barcode_no");
      $child_barcode      = $this->input->post("child_barcode_no");
      $it_condition       = $this->input->post("condition_id");

      $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
      $master_qry = $query->result_array();
      $master_path = $master_qry[0]['MASTER_PATH'];

      if(is_numeric(@$it_condition)){
        if(@$it_condition == 3000){
          @$it_condition = 'Used';
        }elseif(@$it_condition == 1000){
          @$it_condition = 'New'; 
        }elseif(@$it_condition == 1500){
          @$it_condition = 'New Other'; 
        }elseif(@$it_condition == 2000){
            @$it_condition = 'Manufacturer refurbished';
        }elseif(@$it_condition == 2500){
          @$it_condition = 'Seller refurbished'; 
        }elseif(@$it_condition == 7000){
          @$it_condition = 'For parts or not working'; 
        }else{
            @$it_condition = 'Used'; 
        }
    }else{// end main if
      $it_condition  = ucfirst(@$it_condition);
    }
    // var_dump($it_condition);
  
    $dir = $master_path.$child_barcode.'/'.$it_condition;
    // var_dump($dir);
   
    $dir = preg_replace("/[\r\n]*/","",$dir);
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        $i=1;
       
        while (($file = readdir($dh)) !== false){

          $parts = explode(".", $file);

          if (is_array($parts) && count($parts) > 1){
              $extension = end($parts);
              if(!empty($extension)){

         // $master_path = $data['path_query'][0]['MASTER_PATH']; 
         $url = $master_path.$child_barcode.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
         // var_dump($url);
         $url = preg_replace("/[\r\n]*/","",$url); 

          $img = file_get_contents($url);
          $img =base64_encode($img);

        
            }
          }

        }?>

           <?php closedir($dh);

      }
    }
      

 }
  public function addCataMpn(){
    $mpn = strtoupper($this->input->post('mpn'));
    $mpn_brand = strtoupper($this->input->post('mpn_brand'));
    $mpn_brand = trim(str_replace("  ", ' ', $mpn_brand));
    // var_dump($mpn_brand);
    // exit;
    $mpn_brand = trim(str_replace(array("'"), "''", $mpn_brand));
    $cat_id = $this->input->post('cat_id');
    $insert_by = $this->session->userdata('user_id');  
    date_default_timezone_set("America/Chicago");
    $date = date('Y-m-d H:i:s');
    $insert_date= "TO_DATE('".$date."', 'YYYY-MM-DD HH24:MI:SS')";
    $mpn_desc = $this->input->post('mpn_desc');
    $mpn_desc = trim(str_replace("  ", ' ', $mpn_desc));
    $mpn_desc = trim(str_replace(array("'"), "''", $mpn_desc));

    $object_des = $this->input->post('object_id');// object description
    $mpn_prev_barcode = $this->input->post('mpn_prev_barcode');
    $remark_de = $this->input->post('dekitted_remark');
    $remark_de = trim(str_replace("  ", ' ', $remark_de));
    $remark_de = trim(str_replace(array("'"), "''", $remark_de));

    $dekit_us_id = $this->input->post('dekit_us_id');
    $avg_sal_pric = $this->input->post('avg_sal_pric');
    $avg_sal_pric = trim(str_replace("  ", ' ', $avg_sal_pric));
    $avg_sal_pric = trim(str_replace(array("'"), "''", $avg_sal_pric));

    $check_object_query = $this->db->query("SELECT O.OBJECT_ID FROM LZ_BD_OBJECTS_MT O WHERE UPPER(O.OBJECT_NAME) = UPPER('$object_des') 
      AND O.CATEGORY_ID =  $cat_id");

    if($check_object_query->num_rows() > 0){
    $get_pk = $check_object_query->result_array();
    $object_id = $get_pk[0]['OBJECT_ID'];
    }else{
    $get_object_pk = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
    $get_pk = $get_object_pk->result_array();
    $object_id = $get_pk[0]['OBJECT_ID'];

    $mt_qry = $this->db->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID, OBJECT_NAME, INSERT_DATE, INSERT_BY, CATEGORY_ID, ITEM_DESC) VALUES($object_id, '$object_des', $insert_date, $insert_by, $cat_id, '$object_des')");  
    }

     //var_dump($dekit_us_id);
     //exit;
      /*========================================
      =            Catalogue Detail            =
      ========================================*/

      /*=====  End of Catalogue Detail  ======*/

      $mpn_check = $this->db->query("SELECT CATALOGUE_MT_ID, OBJECT_ID,MPN FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = '$mpn' AND CATEGORY_ID = $cat_id");

      if($mpn_check->num_rows() == 0){

        $get_mt_pk = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') CATALOGUE_MT_ID FROM DUAL");
        //$get_mt_pk = $this->db->query("SELECT MAX(CATALOGUE_MT_ID + 1) CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT");
        $get_pk = $get_mt_pk->result_array();
        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];

        $mt_qry = $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,OBJECT_ID,MPN_DESCRIPTION,BRAND) VALUES($cat_mt_id, '$mpn', $cat_id, $insert_date, $insert_by,$object_id,'$mpn_desc','$mpn_brand')");
        //echo "yes";        
      }else{
        $get_pk = $mpn_check->result_array();
        $cat_mt_id = $get_pk[0]['CATALOGUE_MT_ID'];
        $mpn_description = $get_pk[0]['MPN'];
        $object_id = $get_pk[0]['OBJECT_ID'];
        //$get_brand = $get_pk[0]['BRAND'];
        $this->db->query("UPDATE LZ_CATALOGUE_MT SET BRAND = '$mpn_brand' WHERE CATALOGUE_MT_ID =$cat_mt_id ");
      }

      // code section added by adil asad on jan-19-2018 strat
      //*****************************************************
      foreach ($dekit_us_id as $child_brcd) {
          $update_dekit = $this->db->query("UPDATE LZ_DEKIT_US_DT SET CATALOG_MT_ID = $cat_mt_id, IDENT_DATE_TIME = $insert_date, IDENTIFIED_BY = $insert_by, IDENT_REMARKS = '$remark_de', OBJECT_ID = $object_id,MPN_DESCRIPTION = '$mpn_desc' ,AVG_SELL_PRICE = $avg_sal_pric  WHERE LZ_DEKIT_US_DT_ID = $child_brcd");
        if ($update_dekit) {
         $this->db->query("call pro_dekiting_us_pk($child_brcd)");
        }
      }
    
      // code section added by adil asad on jan-19-2018 end
      //*****************************************************

      $master_mpn = $this->input->post('master_mpn');

      //$i=0;
      if(!empty($master_mpn)){

          $kitquery = ("SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M, LZ_CATALOGUE_MT C, LZ_BD_OBJECTS_MT O WHERE M.CATALOGUE_MT_ID = $master_mpn AND C.CATALOGUE_MT_ID = M.PART_CATLG_MT_ID AND O.OBJECT_ID = C.OBJECT_ID AND C.OBJECT_ID = $object_id"); 
          $kitsmpn_check = $this->db->query($kitquery);
         
          if ($kitsmpn_check->num_rows() == 0){
            //echo "mpn_kit";
          $mpn_kit_pk = $this->db->query("SELECT get_single_primary_key('LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') ID FROM DUAL");
          //$mpn_kit_pk = $this->db->query("SELECT MAX(MPN_KIT_MT_ID + 1) MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT");
          $mpn_kit_pk = $mpn_kit_pk->result_array();
          $mpn_kit_mt_id = $mpn_kit_pk[0]['ID'];

          $insert_mpn_kit = $this->db->query("INSERT INTO LZ_BD_MPN_KIT_MT (MPN_KIT_MT_ID,CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID) VALUES($mpn_kit_mt_id,$master_mpn,1,$cat_mt_id )");
            if ($insert_mpn_kit) {
            return array("cat_mt_id"=>$cat_mt_id, "mpn"=>$mpn, "mpn_desc"=>$mpn_desc,"check"=>1); 
          }else {
            return array("check"=>0);
          }
          }else {
            $mpn_kit_mt_id = $kitsmpn_check->result_array()[0]['MPN_KIT_MT_ID'];
            /// INSERT IF NOT AVAILABLE IN ALT TABLE
            $kit_alt_mpn = $this->db->query("SELECT * FROM LZ_BD_MPN_KIT_ALT_MPN A WHERE A.MPN_KIT_MT_ID IN (SELECT M.MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT M WHERE M.CATALOGUE_MT_ID = $cat_mt_id)");
        if ($kit_alt_mpn->num_rows() == 0) {
          $mpn_kit_alt_pk = $this->db->query("SELECT get_single_primary_key('LZ_BD_MPN_KIT_ALT_MPN','MPN_KIT_ALT_MPN') ID FROM DUAL");
              $mpn_kit_pk = $mpn_kit_alt_pk->result_array();
              $mpn_kit_alt_mpn = $mpn_kit_pk[0]['ID'];

          $kitmpn_insert = $this->db->query("INSERT INTO  LZ_BD_MPN_KIT_ALT_MPN (MPN_KIT_ALT_MPN, MPN_KIT_MT_ID, CATALOGUE_MT_ID) VALUES($mpn_kit_alt_mpn, $mpn_kit_mt_id, $cat_mt_id)");
          if ($kitmpn_insert) {
            return array("cat_mt_id"=>$cat_mt_id, "mpn"=>$mpn, "mpn_desc"=>$mpn_desc, "check"=>1); 
          }else {
            return array("check"=>0);
          }
        }else {
          //echo "already";
          return array("check"=>2); 
        }
          }
      }else{
        return array("check"=>2);
      }//endif master mpn

  }
/*=====  END OF IMRAN WORK   ======*/
  
}