<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class m_adilApi extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function save_image_api_data()
    {
        $barcodes         = @$_POST['barcode'];
        $images           = @$_FILES['image'];
        $bin              = @$_POST['bin_name'];
        $cond_id          = @$_POST['condition'];
        $conditionRemarks = @$_POST['cond_remarks'];
        $condition        = @$_POST['cond_id'];
        $folderBarcode    = @$_POST['folderBarcode'];
        $folderName       = @$_POST['folderName'];
        $lot_id           = @$_POST['lot_id'];
        $mpn              = @$_POST['mpn'];
        $enteredDate      = @$_POST['pic_DateTime'];
        $enteredBy        = @$_POST['pic_taker_id'];
        $remarks          = @$_POST['remarks'];
        $sync_status      = @$_POST['sync_status'];
        if(isset($_POST['upc'])){
        $upc              = @$_POST['upc'];
        }else{
            $upc              = "";
        }
        if(isset($_POST['mpn'])){
        $mpn              = @$_POST['mpn'];
        }else{
            $mpn              = "";
        }
        if(isset($_POST['remarks'])){
        $remarks              = @$_POST['remarks'];
        }else{
            $remarks              = "";
        }
        if(isset($_POST['lot_id'])){
        $lot_id              = @$_POST['lot_id'];
        }else{
            $lot_id              = "";
        }
        if(isset($_POST['sync_status'])){
        $sync_status
                      = @$_POST['sync_status'];
        }else{
            $sync_status
                          = "";
        }
        if(isset($_POST['cond_remarks'])){
        $conditionRemarks
                      = @$_POST['cond_remarks'];
        }else{
            $conditionRemarks
                          = "";
        }
        $enteredDate      = "TO_DATE('" . $enteredDate . "', 'DD/MM/YYYY HH:MI:SS am')";
        $barcodes         = explode(',', $barcodes);
        // print_r($barcodes);
        // foreach (@$_FILES['image']['name'] as $key => $image) {
        //     $img_name = $_FILES['image']['name'][$key];
        //      print_r($img_name);
        // }
        
        // exit();
        $mt_ids_array = array();
        $this->load->library('image_lib');
        // $json_order_data = $_POST['image_data_array'];
        $myFile = "data.json";
        // $json_order_data = file_get_contents($myFile);
        file_put_contents($myFile, json_encode($_FILES['image']));
        
        $azRange = range('A', 'Z');
        $z       = 0;
        
        // Start of Folder loop
        $this->load->library('image_lib');
        
        $dir_path_id    = 2; // dekit path
        $condition_name = '';
        $posted_barcode = false;
        
        $query = $this->db->query("SELECT B.BIN_ID FROM BIN_MT B WHERE B.BIN_TYPE || '-' || B.BIN_NO = UPPER('$bin')");
        if ($query->num_rows() == 0) {
            $bin_id = 0;
        } else {
            $query  = $query->result_array();
            $bin_id = $query[0]['BIN_ID'];
        }
        // echo("Barcodes Count: ".count($barcodes)."<br>");
        // exit;
        for ($i = 0; $i < count($barcodes); $i++) {
            // echo($barcodes[$i]);
            $barcode = trim($barcodes[$i]);
            //  print_r($barcode);
            // exit();
            $message = "";
            
            /*=========================================
            = check Barcode Posted =
            =========================================*/
            $qry = $this->db->query("SELECT B.BARCODE_NO FROM LZ_BARCODE_MT B WHERE B.BARCODE_NO = '$barcode'");
            if ($qry->num_rows() > 0) {
                $posted_barcode = true;
                /*==========================================
                = check barcode type =
                ==========================================*/
                $query          = $this->db->query("SELECT S.F_UPC || '~' || S.F_MPN FOLDER_NAME, C.COND_NAME FROM LZ_BARCODE_MT B, LZ_MANIFEST_MT M, LZ_ITEM_SEED S, LZ_ITEM_COND_MT C WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND S.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND S.ITEM_ID = B.ITEM_ID AND S.DEFAULT_COND = B.CONDITION_ID AND C.ID = B.CONDITION_ID AND M.MANIFEST_TYPE NOT IN (3, 4) AND B.BARCODE_NO = '$barcode'");
                if ($query->num_rows() > 0) {
                    $query          = $query->result_array();
                    $folderName     = $query[0]['FOLDER_NAME'];
                    $folderName     = str_replace("/", "_", $folderName);
                    $condition_name = $query[0]['COND_NAME'];
                    $dir_path_id    = 1; // master path
                }
                
                /*===== End of check barcode type ======*/
                
            }
            // var_dump($posted_barcode);
            // exit;
            /*===== End of check Barcode Posted ======*/
            if ($posted_barcode) {
                $message = "Single Entry Barcode:" . $barcode;
                if ($bin_id > 0) {
                    $qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.BIN_ID = '$bin_id', B.CONDITION_ID = '$condition' WHERE B.BARCODE_NO = '$barcode'");
                } else {
                    $qry = $this->db->query("UPDATE LZ_BARCODE_MT B SET B.CONDITION_ID = '$condition' WHERE B.BARCODE_NO = '$barcode'");
                }
                
            } else { // if($posted_barcode){ CLOSE
                /*===========================================
                = check dekit barcode =
                ===========================================*/
                $qry = $this->db->query("SELECT LZ_DEKIT_US_DT_ID FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = '$barcode'");
                // echo "Dekit: ". $qry->num_rows();
                if ($qry->num_rows() > 0) {
                    // echo "Dekit Barcode:" . $barcode;
                    $message = "Dekit Barcode:" . $barcode;
                    
                    $this->db->query("UPDATE LZ_DEKIT_US_DT SET BIN_ID = '$bin_id', PIC_DATE_TIME = $enteredDate , PIC_BY = '$enteredBy' , DEKIT_REMARKS = '$remarks', CONDITION_ID = '$condition', PIC_NOTES = '$conditionRemarks', PIC_STATUS = 1 , FOLDER_NAME = '$folderName' WHERE BARCODE_PRV_NO = '$barcode'");
                    
                    /*===== End of check dekit barcode ======*/
                    
                } else {
                    /*===========================================
                    = special lot barcode =
                    ===========================================*/
                    $message = "Special Lot Barcode:" . $barcode;
                    $qry     = $this->db->query("SELECT SPECIAL_LOT_ID FROM LZ_SPECIAL_LOTS WHERE BARCODE_PRV_NO = '$barcode'");
                    if ($qry->num_rows() == 0) {
                        // echo("INSERT INTO LZ_SPECIAL_LOTS (SPECIAL_LOT_ID, BARCODE_PRV_NO, BIN_ID, PIC_DATE_TIME, PIC_BY, CONDITION_ID, CARD_UPC, INSERTED_AT, INSERTED_BY, FOLDER_NAME,EAN) VALUES( get_single_primary_key('LZ_SPECIAL_LOTS','SPECIAL_LOT_ID'),'$barcode','$bin_id','$enteredDate','$enteredBy','$condition','$upc',SYSDATE,'$enteredBy','$folderName','$ean')");
                        // exit;
                        $this->db->query("INSERT INTO   (SPECIAL_LOT_ID, BARCODE_PRV_NO, BIN_ID, PIC_DATE_TIME, PIC_BY, LOT_REMARKS, CONDITION_ID, CARD_UPC, INSERTED_AT, INSERTED_BY, FOLDER_NAME,CONDITION_REMRAKS,CARD_MPN) VALUES( get_single_primary_key('LZ_SPECIAL_LOTS','SPECIAL_LOT_ID'),'$barcode','$bin_id',$enteredDate,'$enteredBy','$remarks','$condition','$upc',SYSDATE,'$enteredBy','$folderName','$conditionRemarks','$mpn')");
                        
                    } else {
                        // echo "Already inserted" . "<br>";
                        $this->db->query("UPDATE LZ_SPECIAL_LOTS SET BIN_ID = '$bin_id', PIC_DATE_TIME = $enteredDate , PIC_BY = '$enteredBy', LOT_REMARKS = '$remarks' , CONDITION_ID = '$condition', CONDITION_REMRAKS = '$conditionRemarks', CARD_UPC = '$upc' , FOLDER_NAME = '$folderName' , CARD_MPN = '$mpn' WHERE BARCODE_PRV_NO = '$barcode'");
                    }
                    
                    /*===== End of special lot barcode ======*/
                    
                    
                }
                
                
            } // else($posted_barcode){ CLOSE
            $this->db->query("INSERT INTO LZ_PIC_LOG (LOG_ID, FOLDER_NAME, NO_OF_PIC, BARCODE_NO, PIC_DATE, PIC_BY, INSERT_DATE) VALUES( get_single_primary_key('LZ_PIC_LOG','LOG_ID'),'$folderName','$i',$barcode,$enteredDate,'$enteredBy',SYSDATE)");
            // $this->db->query("INSERT INTO LZ_PIC_LOG (LOG_ID, FOLDER_NAME, NO_OF_PIC, BARCODE_NO, PIC_DATE, PIC_BY, INSERT_DATE) VALUES( get_single_primary_key('LZ_PIC_LOG','LOG_ID'),'$folderName','$i',$barcode,$enteredDate,'$enteredBy',SYSDATE)");
            // echo $barcode;
            $mt_id_index['barcode'] = $barcode;
            $mt_id_index['message'] = $message;
            $mt_id_index['status']  = 1;
            $mt_ids_array[$z]       = $mt_id_index;
            $z++;
        }
        
        
        
        
        
        
        
        
        
        /*=======================================
        = save pic to dir =
        =======================================*/
        $query   = $this->db->query("SELECT C.MASTER_PATH FROM LZ_PICT_PATH_CONFIG C WHERE C.PATH_ID = '$dir_path_id'")->result_array();
        $pic_dir = $query[0]['MASTER_PATH'];
         $pic_dir = 'E:/wamp/www/item_pictures/dekitted_pictures/';
        
        $folder_dir = $pic_dir . $folderName;
        $thumb_dir  = $pic_dir . $folderName . '\thumb';
        if (!is_dir($folder_dir)) {
            mkdir($folder_dir);
            if ($dir_path_id == 1) {
                $folder_dir = $pic_dir . $folderName . '/' . $condition_name;
                $thumb_dir  = $pic_dir . $folderName . '/' . $condition_name . '\thumb';
                if (!is_dir($folder_dir)) {
                    mkdir($folder_dir);
                }
            }
            
            if (!is_dir($thumb_dir)) {
                mkdir($thumb_dir);
            }
            $i       = 0;
            $azRange = range('A', 'Z');
            $imgs    = @$images;
            foreach (@$_FILES['image']['name'] as $key => $image) {
                
                $img        = @$image;
                // $thumbUrl = @$url->thumbUrl;
                //$imageTime = $url->imageTime;
                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $max        = strlen($characters) - 1;
                $img_name   = $_FILES['image']['name'][$key];
                
                $decodedImage = @$_FILES['image']['name'][$key];
                $config = array(
                    'upload_path'   => $folder_dir . '/',
                    'allowed_types' => 'jpg|gif|png'            
                );
            
                $this->load->library('upload', $config);

                $_FILES['image[]']['name']= $_FILES['image']['name'][$key];
                $_FILES['image[]']['type']= $_FILES['image']['type'][$key];
                $_FILES['image[]']['tmp_name']= $_FILES['image']['tmp_name'][$key];
                $_FILES['image[]']['error']= $_FILES['image']['error'][$key];
                $_FILES['image[]']['size']= $_FILES['image']['size'][$key];

                $fileName = $azRange[$i] . "_" . $image;

                $image = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                $this->upload->do_upload('image[]');
                    $this->upload->data();

                // $return                  = file_put_contents($folder_dir . "/" . $azRange[$i] . "_" . $img_name . ".jpg",$decodedImage);
                $config1['image_library'] = 'GD2';
                // $config['source_image'] = $sub_dir2."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                $config1['source_image']  = $folder_dir . "/" . $azRange[$i] . "_" . $img_name . ".jpg";
                if (!is_dir($folder_dir . "/thumb")) {
                    mkdir($folder_dir . "/thumb");
                }
                $config1['new_image']      = $folder_dir . "/thumb/" . $azRange[$i] . "_" . $img_name . ".jpg";
                $config1['maintain_ratio'] = true;
                $config1['width']          = 100;
                $config1['height']         = 100;
                
                
                
                //$config['quality'] = 50; this filter doesnt work
                $in     = $this->image_lib->initialize($config1);
                $result = $this->image_lib->resize($in);
                $this->image_lib->clear();
                
                
                $i++;
                
            }
            
            /*====================================
            = save pic log =
            ====================================*/
            
            // $this->db->query("INSERT INTO LZ_PIC_LOG (LOG_ID, FOLDER_NAME, NO_OF_PIC, BARCODE_NO, PIC_DATE, PIC_BY, INSERT_DATE) VALUES( get_single_primary_key('LZ_PIC_LOG','LOG_ID'),'$folderName','$i',$barcode,$enteredDate,'$enteredBy',SYSDATE)");
            
            /*===== End of save pic log ======*/
            
        } else {
            
            // echo $dir_path_id . " already exist"; //exit;
            if ($dir_path_id == 1) {
                $dir       = $folder_dir . '/' . $condition_name;
                $thumb_dir = $pic_dir . $folderName . '/' . $condition_name . '\thumb';
                if (!is_dir($folder_dir . '/' . $condition_name)) {
                    mkdir($folder_dir . '/' . $condition_name);
                }
                if (!is_dir($thumb_dir)) {
                    mkdir($thumb_dir);
                }
            } else {
                $dir = $folder_dir;
            }
            
            
            /*==========================================
            = delete current pic =
            ==========================================*/
            
            //var_dump($dir); exit;
            // Open a directory, and read its contents
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    //$i=1;
                    while (($file = readdir($dh)) !== false) {
                        $parts = explode(".", $file);
                        if (is_array($parts) && count($parts) > 1) {
                            $extension = end($parts);
                            if (!empty($extension)) {
                                
                                //$img_name = explode('_', $master_reorder[$i-1]);
                                //rename($dir."/".$parts['0'].".".$extension, $new_dir."/".$barcode."_".$i.".".$extension);
                                @$img_order = unlink($dir . "/" . $parts['0'] . "." . $extension);
                                @$thumb_order = unlink($dir . "/thumb/" . $parts['0'] . "." . $extension);
                                
                                //$i++;
                            }
                        }
                        
                    } //end while
                    
                    closedir($dh);
                    //exit;
                } // sub if
            } else { //main if
                mkdir($dir);
            }
            /*===== End of delete current pic ======*/
            /*========================================
            = save updated pic =
            ========================================*/
            $i       = 0;
            $azRange = range('A', 'Z');
            $imgs    = @$images;
            // echo ($dir);
            // exit;
            foreach (@$_FILES['image']['name'] as $key => $image) {
                
                $img        = @$image;
                // $thumbUrl = @$url->thumbUrl;
                //$imageTime = $url->imageTime;
                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $max        = strlen($characters) - 1;
                $img_name   = $_FILES['image']['name'][$key];
                $decodedImage = @$_FILES['image']['name'][$key];
                
                $config = array(
                    'upload_path'   => $folder_dir . '/',
                    'allowed_types' => 'gif|jpg|png|jpeg',
                    'max_size'      => 100000    
                );
            
                $this->load->library('upload', $config);

                $_FILES['image[]']['name']= $_FILES['image']['name'][$key];
                $_FILES['image[]']['type']= $_FILES['image']['type'][$key];
                $_FILES['image[]']['tmp_name']= $_FILES['image']['tmp_name'][$key];
                $_FILES['image[]']['error']= $_FILES['image']['error'][$key];
                $_FILES['image[]']['size']= $_FILES['image']['size'][$key];

                $fileName = $azRange[$i] . "_" . $image;

                $image = $fileName;

                $config['file_name'] = $fileName;

                $this->upload->initialize($config);

                $this->upload->do_upload('image[]');
                    $this->upload->data();
                
                
                // $return = file_put_contents($dir . "/" . $azRange[$i] . "_" . $img_name . ".jpg", $decodedImage);
                
                $config1['image_library'] = 'GD2';
                // $config1['source_image'] = $sub_dir2."/".$azRange[$i].'_'.$img_name.'.'.$extension;
                $config1['source_image']  = $dir . "/" . $azRange[$i] . "_" . $img_name . ".jpg";
                if (!is_dir($dir . "/thumb")) {
                    mkdir($dir . "/thumb");
                }
                $config1['new_image']      = $dir . "/thumb/" . $azRange[$i] . "_" . $img_name . ".jpg";
                $config1['maintain_ratio'] = true;
                $config1['max_width']          = 100;
                $config1['max_height']         = 100;
                
                
                
                //$config1['quality'] = 50; this filter doesnt work
                $in     = $this->image_lib->initialize($config1);
                $result = $this->image_lib->resize($in);
                $this->image_lib->clear();
                
                
                $i++;
            }
            
            
            /*===== End of save updated pic ======*/
            /*====================================
            = save pic log =
            ====================================*/
            
            // $this->db->query("INSERT INTO LZ_PIC_LOG (LOG_ID, FOLDER_NAME, NO_OF_PIC, BARCODE_NO, PIC_DATE, PIC_BY, INSERT_DATE) VALUES( get_single_primary_key('LZ_PIC_LOG','LOG_ID'),'$folderName','$i',$barcode,$enteredDate,'$enteredBy',SYSDATE)");
            
            /*===== End of save pic log ======*/
        } // close if dir else
        
        /*===== End of save pic to dir ======*/
        
        
        /*===== End of Folder loop ======*/
        return $mt_ids_array;
        
        
        
    }
}