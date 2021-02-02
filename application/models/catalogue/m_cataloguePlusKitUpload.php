<?php

class m_cataloguePlusKitUpload extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }


    public function import_xls_record2()
    {

        $filename = $this->input->post('file_name');
        // var_dump($filename);exit;
        $this->load->library('PHPExcel');
        $ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION);
        // var_dump( $_FILES["file_name"]["name"]);exit;

        if ($ext !='xlsx')
        {
            echo "Only Excel files with .xlsx ext are allowed.";
            // $this->session->set_userdata('ERROR' , 'Only Excel files are allowed.');
            // redirect(base_url() . 'index.php/manifest_loading/csv');
        }
         else{

            $filename = $this->input->post('file_name').'.'.$ext;
            //var_dump($filename);exit;
            move_uploaded_file($_FILES["file_name"]["tmp_name"],$filename);
            // var_dump($_FILES["file_name"]["name"]);exit;

            if(strtolower($ext) == 'xlsx')
            {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setReadDataOnly(true);

            }
            $objPHPExcel = $objReader->load($filename);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $i=2;
            /*=============================================
            =            Select Excel sheet at Index           =
            =============================================*/
             // $objWorksheet = $objPHPExcel->setActiveSheetIndex(1);  
            
            //to select excel sheet give its index --setActivateIndex--
            /*=====  End of  Select Excel sheet at Index  ======*/
            
           

            // $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;
            foreach ($objWorksheet->getRowIterator() as $row)
            {
                $PARENT_MPN = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $PARENT_MPN = trim(str_replace("  ", ' ', $PARENT_MPN));
                $PARENT_MPN = trim(str_replace(array("'"), "''", $PARENT_MPN));

                // var_dump($PARENT_MPN);exit;

                $MPN = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $MPN = trim(str_replace("  ", ' ', $MPN));
                $MPN = trim(str_replace(array("'"), "''", $MPN));
                $MPN = strtoupper($MPN);
                $data['0'] = $MPN;
               
                $BRAND = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue(); 
                $BRAND = trim(str_replace("  ", ' ', $BRAND));
                $BRAND = trim(str_replace(array("'"), "''", $BRAND));
                $data['1'] = $BRAND;

                $MODEL = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $MODEL = trim(str_replace("  ", ' ', $MODEL));
                $MODEL = trim(str_replace(array("'"), "''", $MODEL));
                $data['2'] = $MODEL;

                $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
                $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
                $data['3'] = $PRODUCT_FAMILY;

                $CATEGORY_ID = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $CATEGORY_ID = trim(str_replace("  ", ' ', $CATEGORY_ID));
                $CATEGORY_ID = trim(str_replace(array("'"), "''", $CATEGORY_ID));
                 // var_dump(count($data));exit;
                $user_id = $this->session->userdata('user_id');
                date_default_timezone_set("America/Chicago");
                $current_date = date("Y-m-d H:i:s");
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

                if($CATEGORY_ID == NULL){
                    // echo 'executed';exit;
                   $this->import_xls_record();
                    echo 'executed';exit;
                }

                else
                {
                    $check = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT D WHERE UPPER(D.MPN) = UPPER('$PARENT_MPN')"); 
                    
                    if($check->num_rows() == 0){
                        $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $catalogue_mt_id = $rs[0]['ID'];
                        $CAT_pk[] = $catalogue_mt_id;
                        $catalogue_pk[] = $catalogue_mt_id;
                            
                        $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,CUSTOM_MPN,OBJECT_ID)  VALUES($catalogue_mt_id,'$PARENT_MPN','$CATEGORY_ID',$current_date,$user_id,0,1) ");//exit;

                    }
                }
                

                $i++;
            }

         }
    }
    public function import_xls_record()
    {
        $this->load->library('PHPExcel');
        $ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION);

        if ($ext !='xlsx')
        {
            echo "Only Excel files with .xlsx ext are allowed.";
            // $this->session->set_userdata('ERROR' , 'Only Excel files are allowed.');
            // redirect(base_url() . 'index.php/manifest_loading/csv');
        }

        else{

            $filename = $this->input->post('file_name').'.'.$ext;
            move_uploaded_file($_FILES["file_name"]["tmp_name"],$filename);

            if(strtolower($ext) == 'xlsx')
            {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setReadDataOnly(true);

            }
            $objPHPExcel = $objReader->load($filename);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $i=2;
            
            $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;
            // var_dump($total_rows);exit;
            // $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','LZ_CATALOGUE_MT_ID') ID FROM DUAL");
            $data = [];
            foreach ($objWorksheet->getRowIterator() as $row)
            {
                $PARENT_MPN = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $PARENT_MPN = trim(str_replace("  ", ' ', $PARENT_MPN));
                $PARENT_MPN = trim(str_replace(array("'"), "''", $PARENT_MPN));


                $MPN = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $MPN = trim(str_replace("  ", ' ', $MPN));
                $MPN = trim(str_replace(array("'"), "''", $MPN));
                $MPN = strtoupper($MPN);
                $data['0'] = $MPN;
               
                $BRAND = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue(); 
                $BRAND = trim(str_replace("  ", ' ', $BRAND));
                $BRAND = trim(str_replace(array("'"), "''", $BRAND));
                $data['1'] = $BRAND;

                $MODEL = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $MODEL = trim(str_replace("  ", ' ', $MODEL));
                $MODEL = trim(str_replace(array("'"), "''", $MODEL));
                $data['2'] = $MODEL;

                $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
                $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
                $data['3'] = $PRODUCT_FAMILY;

                $CATEGORY_ID = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $CATEGORY_ID = trim(str_replace("  ", ' ', $CATEGORY_ID));
                $CATEGORY_ID = trim(str_replace(array("'"), "''", $CATEGORY_ID));

                 if($CATEGORY_ID == NULL){
                   
                    echo 'executed';exit;
                }

                 // var_dump(count($data));exit;
                $user_id = $this->session->userdata('user_id');
                date_default_timezone_set("America/Chicago");
                $current_date = date("Y-m-d H:i:s");
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";


                // $checkParentMpn = 
                $mt_id = [];

                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = '$CATEGORY_ID'  AND UPPER(SPECIFIC_NAME) = 'MPN'");

               if($check->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $mt_id = $rs[0]['ID'];
                    $pk[] = $mt_id;
                    $this->db->query("INSERT INTO CATEGORY_SPECIFIC_MT(
                    MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY)  VALUES($mt_id,'$CATEGORY_ID','MPN',1,1,1,'FreeText',$current_date,1,1) ");//exit;
                }else{
                    $rs = $check->result_array();
                    $mt_id = $rs[0]['MT_ID'];
                    $pk[] = $mt_id;
                }

                 // $s = 0;
                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = '$CATEGORY_ID'  AND UPPER(SPECIFIC_NAME) = 'BRAND'");

               if($check->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $mt_id = $rs[0]['ID'];
                    $pk[] = $mt_id;
                    $this->db->query("INSERT INTO CATEGORY_SPECIFIC_MT(
                    MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY)  VALUES($mt_id,'$CATEGORY_ID','BRAND',1,1,1,'FreeText',$current_date,1,1) ");//exit;
                }else{
                    $rs = $check->result_array();
                    $mt_id = $rs[0]['MT_ID'];
                    $pk[] = $mt_id;
                }

                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = '$CATEGORY_ID'  AND UPPER(SPECIFIC_NAME) = 'FAMILY'");

               if($check->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $mt_id = $rs[0]['ID'];
                    $pk[] = $mt_id;
                    $this->db->query("INSERT INTO CATEGORY_SPECIFIC_MT(
                    MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY)  VALUES($mt_id,'$CATEGORY_ID','FAMILY',1,1,1,'FreeText',$current_date,1,1) ");//exit;
                }else{
                    $rs = $check->result_array();
                    $mt_id = $rs[0]['MT_ID'];
                    $pk[] = $mt_id;
                }

                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = '$CATEGORY_ID'  AND UPPER(SPECIFIC_NAME) = 'MODEL'");

               if($check->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $mt_id = $rs[0]['ID'];
                    $pk[] = $mt_id;
                    $this->db->query("INSERT INTO CATEGORY_SPECIFIC_MT(
                    MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY)  VALUES($mt_id,'$CATEGORY_ID','MODEL',1,1,1,'FreeText',$current_date,1,1) ");//exit;
                }else{
                    $rs = $check->result_array();
                    $mt_id = $rs[0]['MT_ID'];
                    $pk[] = $mt_id;
                }

         
                $OBJECT = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $OBJECT = trim(str_replace("  ", ' ', $OBJECT));
                $OBJECT = trim(str_replace(array("'"), "''", $OBJECT));
                // $objName[$i]=$OBJECT;

          

                // $cat_num = $objPHPExcel->setActiveSheetIndex(0)->rangeToArray('C2:C209');
                $DESCRIPTION = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $DESCRIPTION = trim(str_replace("  ", ' ', $DESCRIPTION));
                $DESCRIPTION = trim(str_replace(array("'"), "''", $DESCRIPTION));
                // $desc[$i] =  $DESCRIPTION;

               
                // $parentMpn[$i] =  $PARENT_MPN;
                // $OBJECT = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                // $OBJECT = trim(str_replace("  ", ' ', $OBJECT));
                // $OBJECT = trim(str_replace(array("'"), "''", $OBJECT));
                // $data['6']=$OBJECT;
                // var_dump($MPN, $MANUF, $BRAND, $MODEL, $PRODUCT_FAMILY, $Model_Id, $ProcessorType, $CPU_Code);exit;
                 // var_dump(count($data));exit;
                // $user_id = $this->session->userdata('user_id');
                // date_default_timezone_set("America/Chicago");
                // $current_date = date("Y-m-d H:i:s");
                // $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
                // $mt_id = [];


                

                // $object = strtoupper($objName[$i]);
                // var_dump($numOfCat);exit;
                 $checkObj = $this->db2->query("SELECT OBJECT_ID FROM  LZ_BD_OBJECTS_MT WHERE  UPPER(OBJECT_NAME) = UPPER('$OBJECT')");
                 // echo $checkObj->OBJECT_ID;exit;
                 // var_dump($checkObj);exit;
                 if($checkObj->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('LZ_BIGDATA.LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
                    $rs = $query->result_array();
                    $object_id = $rs[0]['OBJECT_ID'];
                    // $obj_pk[] = $object_id;

                    $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID,OBJECT_NAME,INSERT_DATE,INSERT_BY)  VALUES($object_id,'$OBJECT',$current_date,2) ");
                 }else{
                     $rs = $checkObj->result_array();
                     $object_id = $rs[0]['OBJECT_ID'];
                     // $obj_pk[] = $object_id;
                 }       
                 // var_dump($obj_pk);exit;
      

                $j=0;
                foreach($data as $row2){
                    $mt_id = $pk[$j];
                    $spec_name= strtoupper($row2);
                     //var_dump($spec_name);exit;
                    if(!empty($spec_name) || $spec_name = 'N/A'){
                        $check = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID =$mt_id AND UPPER(D.SPECIFIC_VALUE) = UPPER('$spec_name')"); 
                        if($check->num_rows() == 0){
                            $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET','DET_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $det_id = $rs[0]['ID'];
                        $det_pk[] = $det_id;
                        
                        $this->db->query("INSERT INTO CATEGORY_SPECIFIC_DET(DET_ID, MT_ID, SPECIFIC_VALUE)  VALUES($det_id,$mt_id,'$spec_name') ");//exit;
                        }else{
                            $rs = $check->result_array();
                            $det_id = $rs[0]['DET_ID'];
                            $det_pk[] = $det_id;
                            
                            $check = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT D WHERE UPPER(D.MPN) = UPPER('$MPN')"); 
                            if($check->num_rows() == 0){
                                $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
                            $rs = $query->result_array();
                            $catalogue_mt_id = $rs[0]['ID'];
                            $CAT_pk[] = $catalogue_mt_id;
                            $catalogue_pk[] = $catalogue_mt_id;
                            
                            $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,CUSTOM_MPN,OBJECT_ID,MPN_DESCRIPTION)  VALUES($catalogue_mt_id,'$MPN','$CATEGORY_ID',$current_date,$user_id,0,$object_id,'$DESCRIPTION') ");//exit;
                            }else{
                            $rs = $check->result_array();
                            $catalogue_mt_id = $rs[0]['CATALOGUE_MT_ID'];
                            $CAT_pk[] = $catalogue_mt_id;
                            $catalogue_pk[] = $catalogue_mt_id;

                            $query = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET WHERE UPPER(SPECIFIC_VALUE) = UPPER('$spec_name')");
                            $rs = $query->result_array();
                            $spec_det_id = $rs[0]['DET_ID'];
                            $catalogue_group_id = 11;
                          



                            $check = $this->db->query("SELECT CATALOGUE_DET_ID FROM LZ_CATALOGUE_DET D WHERE D.CATALOGUE_MT_ID = $catalogue_mt_id AND SPECIFIC_DET_ID = $spec_det_id"); 
                            if($check->num_rows() == 0){
                                $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','CATALOGUE_DET_ID') ID FROM DUAL");
                            $rs = $query->result_array();
                            $catalogue_det_id = $rs[0]['ID'];
                            $CAT_pk[] = $catalogue_det_id;
                            
                            $this->db->query("INSERT INTO LZ_CATALOGUE_DET(CATALOGUE_DET_ID, CATALOGUE_MT_ID, CATALOGUE_GROUP_ID, SPECIFIC_DET_ID)  VALUES($catalogue_det_id,$catalogue_mt_id,$catalogue_group_id,$spec_det_id) ");//exit;


                            $query = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT WHERE UPPER(MPN) = UPPER('$PARENT_MPN')");
                            $rs = $query->result_array();
                            // var_dump($rs);exit;
                            $PAR_CATALOGUE_MT_ID = $rs[0]['CATALOGUE_MT_ID'];
                            // $catalogue_group_id = 11;


                            $check_Kit = $this->db2->query("SELECT MPN_KIT_MT_ID FROM LZ_BD_MPN_KIT_MT WHERE CATALOGUE_MT_ID = $PAR_CATALOGUE_MT_ID AND PART_CATLG_MT_ID = $catalogue_mt_id");
                            if($check_Kit->num_rows() == 0){
                                $query = $this->db->query("SELECT get_single_primary_key('LZ_BIGDATA.LZ_BD_MPN_KIT_MT','MPN_KIT_MT_ID') MPN_KIT_MT_ID FROM DUAL");
                                $rs = $query->result_array();
                                $mpn_mt_kit_id = $rs[0]['MPN_KIT_MT_ID'];
                                $mpn_mt_pk[] = $mpn_mt_kit_id;

                                $this->db2->query("INSERT INTO LZ_BD_MPN_KIT_MT(MPN_KIT_MT_ID,CATALOGUE_MT_ID,QTY,PART_CATLG_MT_ID) VALUES($mpn_mt_kit_id,$PAR_CATALOGUE_MT_ID,1,$catalogue_mt_id)");
                            }

                            }//nested if close
                        }//nested ifelse close from else part
                    }//nested ifelse close 
                }//spec_name if close 
                    
                    $j++;
            }//nested foreach close
    //var_dump($det_pk);exit;
    //main else colse
                
        $i++;   
            
            
        }//main forech close
    }
}
}
?>