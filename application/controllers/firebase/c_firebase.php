<?php
class c_firebase extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->load->database();
    //$this->load->model('rssFeed/m_rssfeed');
   // $this->load->model('firebase/m_firebase');
    $this->load->helper('security');
    /*=============================================
    =  Section lz_bigData db connection block  =
    =============================================*/
    //$CI = &get_instance();
    //setting the second parameter to TRUE (Boolean) the function will return the database object.
   // $this->db2 = $CI->load->database('bigData', TRUE);
    /*======= End Section lz_bigData db connection block=====*/

    /*==============================================================
    =            get distinct category for rss feed url            =
    ==============================================================*/
    // $get_cat = $this->db2->query("SELECT DISTINCT CATEGORY_ID from LZ_BD_RSS_FEED_URL")->result_array();
    // foreach ($get_cat as $cat) {
    //   $this->cat_rss_feed($cat['CATEGORY_ID']);
    // }

    /*=====  End of get distinct category for rss feed url  ======*/
      
  }
public function loadview()
  {
      //$verify_pro = "CALL PRO_RECOG_DATA_JOB()";
    $this->load->view('firebase/downloadData');
  }
public function getFbData()
  {
    $fb_data = json_decode($_GET['parm_order']);
    $barcode = $_GET['barcode'];
    //var_dump($barcode);exit;
    $upc = @$fb_data->UPC;
    $ean = @$fb_data->EAN;
    $enteredBy = @$fb_data->enteredBy;
    $enteredDate = @$fb_data->enteredDate;
    $object = @$fb_data->object;
    $remarks = @$fb_data->Remarks;
    $bin = @$fb_data->bin;
    $condition = @$fb_data->condition;
    $conditionRemarks = @$fb_data->conditionRemarks;
    $folderName = @$fb_data->folderName;
    //var_dump($upc , $ean , $enteredBy , $enteredDate , $object , $remarks , $bin , $condition , $conditionRemarks , $folderName);
    $enteredDate = "TO_DATE('".$enteredDate."', 'DD/MM/YYYY HH24:MI:SS')";  
    $dir_path_id = 2;// dekit path
    $condition_name ='';
    $posted_barcode = false;

    $query = $this->db->query("SELECT B.BIN_ID FROM BIN_MT B WHERE B.BIN_TYPE || '-' || B.BIN_NO = UPPER('$bin')");
    if($query->num_rows() == 0){
      $bin_id = 0;
    }else{
      $query = $query->result_array();
      $bin_id = $query[0]['BIN_ID'];
    }

/*=========================================
=            check Barcode Posted         =
=========================================*/
 $qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = '$barcode'");
    if($qry->num_rows() > 0){
      $posted_barcode = true;
      /*==========================================
      =            check barcode type            =
      ==========================================*/
        $query = $this->db->query("SELECT S.F_UPC || '~' || S.F_MPN FOLDER_NAME, C.COND_NAME FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, LZ_ITEM_SEED S, LZ_ITEM_COND_MT C WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.ITEM_ID = B.ITEM_ID AND S.DEFAULT_COND = B.CONDITION_ID AND C.ID = B.CONDITION_ID AND M.MANIFEST_TYPE NOT IN (3, 4) AND B.BARCODE_NO = '$barcode'");
        if($query->num_rows() > 0){
          $query = $query->result_array();
          $folderName = $query[0]['FOLDER_NAME'];
          $condition_name = $query[0]['COND_NAME'];
          $dir_path_id = 1;// master path
          echo "Single Entry Barcode:" . $barcode;
        }
      
      /*=====  End of check barcode type  ======*/

    }

 /*=====  End of check Barcode Posted  ======*/
if($posted_barcode){

  if($bin_id > 0){
    $qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.BIN_ID = '$bin_id', B.CONDITION_ID = '$condition' WHERE B.BARCODE_NO = '$barcode'");
  }else{
    $qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = '$condition' WHERE B.BARCODE_NO = '$barcode'");
  }

}else{// if($posted_barcode){ CLOSE
  /*===========================================
  =            check dekit barcode            =
  ===========================================*/
  $qry = $this->db->query("SELECT LZ_DEKIT_US_DT_ID FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = '$barcode'");
  if($qry->num_rows() > 0){
    echo "Dekit Barcode:" . $barcode;

    $this->db->query("UPDATE LZ_DEKIT_US_DT SET BIN_ID = '$bin_id', PIC_DATE_TIME = $enteredDate , PIC_BY = '$enteredBy' , DEKIT_REMARKS = '$remarks', CONDITION_ID = '$condition', PIC_NOTES = '$conditionRemarks', PIC_STATUS = 1 , FOLDER_NAME = '$folderName' ,FB_OBJECT_NAME = '$object' WHERE BARCODE_PRV_NO = '$barcode'");

  /*=====  End of check dekit barcode  ======*/

  }else{
    /*===========================================
    =            special lot barcode            =
    ===========================================*/
    echo "Special Lot Barcode:" . $barcode;
    $qry = $this->db->query("SELECT SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS WHERE BARCODE_PRV_NO = '$barcode'");
    if($qry->num_rows() == 0){

      $this->db->query("INSERT INTO LZ_SPECIAL_LOTS (SPECIAL_LOT_ID, BARCODE_PRV_NO, BIN_ID, PIC_DATE_TIME, PIC_BY, LOT_REMARKS, CONDITION_ID, CARD_UPC, INSERTED_AT, INSERTED_BY, FOLDER_NAME, CONDITION_REMRAKS,EAN,FB_OBJECT_NAME) VALUES( get_single_primary_key('LZ_SPECIAL_LOTS','SPECIAL_LOT_ID'),'$barcode','$bin_id',$enteredDate,'$enteredBy','$remarks','$condition','$upc',SYSDATE,'$enteredBy','$folderName','$conditionRemarks','$ean','$object')");
    }else{
      echo "Already inserted" . "<br>";
      $this->db->query("UPDATE LZ_SPECIAL_LOTS SET BIN_ID = '$bin_id', PIC_DATE_TIME = $enteredDate , PIC_BY = '$enteredBy' , LOT_REMARKS = '$remarks', CONDITION_ID = '$condition', CONDITION_REMRAKS = '$conditionRemarks', CARD_UPC = '$upc' , FOLDER_NAME = '$folderName' ,FB_OBJECT_NAME = '$object', EAN = '$ean' WHERE BARCODE_PRV_NO = '$barcode'");
    }

    /*=====  End of special lot barcode  ======*/
    
    
  }
  

}// else($posted_barcode){ CLOSE

    
    /*=======================================
    =            save pic to dir            =
    =======================================*/
    $query = $this->db->query("SELECT C.MASTER_PATH FROM LZ_PICT_PATH_CONFIG C WHERE C.PATH_ID = '$dir_path_id'")->result_array();
    $pic_dir = $query[0]['MASTER_PATH'];
    
    $folder_dir = $pic_dir.$folderName;
    $thumb_dir = $pic_dir.$folderName.'\thumb';

    if(!is_dir($folder_dir)){
      mkdir($folder_dir);
      if($dir_path_id == 1){
        $thumb_dir = $pic_dir.$folderName.'/'.$condition_name.'\thumb';
        if(!is_dir($folder_dir.'/'.$condition_name)){
          mkdir($folder_dir.'/'.$condition_name);
        }
      }

      if(!is_dir($thumb_dir)){
        mkdir($thumb_dir);
      }
      $i=0;
      $azRange = range('A', 'Z');
      $imgUrls = @$fb_data->imgUrl;
      foreach (@$imgUrls as $key => $url) {
        //var_dump($url->url);//exit;
        $imageUrl = @$url->url;
        $thumbUrl = @$url->thumbUrl;
        //$imageTime = $url->imageTime;
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
        $img_name = '';
        $max = strlen($characters) - 1;
        for ($k = 0; $k < 10; $k++) {
            $img_name .= $characters[mt_rand(0, $max)];
        }

        copy(@$imageUrl, $folder_dir.'/'.$azRange[$i]."_fb_".$img_name.'.jpg');
        copy(@$thumbUrl, $thumb_dir.'/'.$azRange[$i]."_fb_".$img_name.'.jpg');

        $i++;
      }

      /*====================================
      =            save pic log            =
      ====================================*/

      $this->db->query("INSERT INTO LZ_PIC_LOG (LOG_ID, FOLDER_NAME, NO_OF_PIC, BARCODE_NO, PIC_DATE, PIC_BY, INSERT_DATE) VALUES( get_single_primary_key('LZ_PIC_LOG','LOG_ID'),'$folderName','$i',$barcode,$enteredDate,'$enteredBy',SYSDATE)");
      
      /*=====  End of save pic log  ======*/
      
    }else{
      echo $dir_path_id . " already exist"; //exit;
      if($dir_path_id == 1){
        $dir = $folder_dir.'/'.$condition_name;
        $thumb_dir = $pic_dir.$folderName.'/'.$condition_name.'\thumb';
        if(!is_dir($folder_dir.'/'.$condition_name)){
          mkdir($folder_dir.'/'.$condition_name);
        }
        if(!is_dir($thumb_dir)){
          mkdir($thumb_dir);
        }
      }else{
        $dir = $folder_dir;
      }

      
      /*==========================================
      =            delete current pic            =
      ==========================================*/
      
      //var_dump($dir); exit;
      // Open a directory, and read its contents
      if (is_dir($dir)){
        if ($dh = opendir($dir)){
          //$i=1;
          while (($file = readdir($dh)) !== false){
          $parts = explode(".", $file);
          if (is_array($parts) && count($parts) > 1){
              $extension = end($parts);
              if(!empty($extension)){
                
                //$img_name = explode('_', $master_reorder[$i-1]);
                //rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
                 @$img_order = unlink($dir."/".$parts['0'].".".$extension);
                 @$thumb_order = unlink($dir."/thumb/".$parts['0'].".".$extension);

                //$i++;
            }
          }

          }//end while

          closedir($dh);
          //exit;
        }// sub if
      }else{//main if
        mkdir($dir);
      }
      /*=====  End of delete current pic  ======*/
      /*========================================
      =            save updated pic            =
      ========================================*/
      $i=0;
      $azRange = range('A', 'Z');
      $imgUrls = @$fb_data->imgUrl;
      foreach (@$imgUrls as $key => $url) {
        //var_dump($url->url);//exit;
        $imageUrl = @$url->url;
        $thumbUrl = @$url->thumbUrl;
        //$imageTime = $url->imageTime;
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
        $img_name = '';
        $max = strlen($characters) - 1;
        for ($k = 0; $k < 10; $k++) {
            $img_name .= $characters[mt_rand(0, $max)];
        }

        copy(@$imageUrl, $dir.'/'.$azRange[$i]."_fb_".$img_name.'.jpg');
        copy(@$thumbUrl, $dir."/thumb/".$azRange[$i]."_fb_".$img_name.'.jpg');

        $i++;
      }
    
    
    /*=====  End of save updated pic  ======*/
    /*====================================
    =            save pic log            =
    ====================================*/

    $this->db->query("INSERT INTO LZ_PIC_LOG (LOG_ID, FOLDER_NAME, NO_OF_PIC, BARCODE_NO, PIC_DATE, PIC_BY, INSERT_DATE) VALUES( get_single_primary_key('LZ_PIC_LOG','LOG_ID'),'$folderName','$i',$barcode,$enteredDate,'$enteredBy',SYSDATE)");
    
    /*=====  End of save pic log  ======*/
    }// close if dir else
    
    /*=====  End of save pic to dir  ======*/

  }// end function

  public function getFirebaseData()
  {
    $data = $this->input->post('data');
    //var_dump($data);//exit;
    foreach ($data as $barcode => $value) {
      //echo $barcode."<br>";
//var_dump($value['imgUrl'],@$value['UPC']);exit;
//var_dump($value);exit;
      $upc = @$value['UPC'];
      $ean = @$value['EAN'];
      $enteredBy = @$value['enteredBy'];
      $enteredDate = @$value['enteredDate'];
      $object = @$value['object'];
      $remarks = @$value['Remarks'];
      $bin = @$value['bin'];
      $condition = @$value['condition'];
      $conditionRemarks = @$value['conditionRemarks'];
      $folderName = @$value['folderName'];
  //var_dump($upc,$ean,$enteredBy,$enteredDate,$object,$remarks,$bin,$condition,$conditionRemarks);exit;    
      //var_dump(expression)
      // foreach ($value['imgUrl'] as $key => $url) {
      //   var_dump($key,$url);
      // }
      
      $enteredDate = "TO_DATE('".$enteredDate."', 'DD/MM/YYYY HH24:MI:SS')";  

      $qry = $this->db->query("SELECT SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS WHERE BARCODE_PRV_NO = '$barcode'");
      if($qry->num_rows() == 0){

        $query = $this->db->query("SELECT B.BIN_ID FROM BIN_MT B WHERE B.BIN_TYPE || '-' || B.BIN_NO = UPPER('$bin')");
        if($query->num_rows() == 0){
          $bin_id = 0;
        }else{
          $query = $query->result_array();
          $bin_id = $query[0]['BIN_ID'];
        }

        $this->db->query("INSERT INTO LZ_SPECIAL_LOTS (SPECIAL_LOT_ID, BARCODE_PRV_NO, BIN_ID, PIC_DATE_TIME, PIC_BY, LOT_REMARKS, CONDITION_ID, CARD_UPC, INSERTED_AT, INSERTED_BY, FOLDER_NAME, CONDITION_REMRAKS,EAN,FB_OBJECT_NAME) VALUES( get_single_primary_key('LZ_SPECIAL_LOTS','SPECIAL_LOT_ID'),'$barcode','$bin_id',$enteredDate,'$enteredBy','$remarks','$condition','$upc',SYSDATE,'$enteredBy','$folderName','$conditionRemarks','$ean','$object')");
      }else{
        echo "Already inserted" . "<br>";
      }
          
    }

  }
}
