<?php

class m_catalogueUploading extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
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
            $i=1;
            
            $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;
            // var_dump($total_rows);exit;
            // $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','LZ_CATALOGUE_MT_ID') ID FROM DUAL");
            $data = [];
            foreach ($objWorksheet->getRowIterator() as $row)
            {
if($i==1){
    
                      // var_dump($total_rows);exit;
            // $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','LAPTOP_ZONE_ID') ID FROM DUAL");
            // $rs = $query->result_array();
            // $LAPTOP_ZONE_ID = $rs[0]['ID'];
            
            // $PO_MT_AUCTION_NO = $objPHPExcel->getActiveSheet()->getCell(''.$i)->getCalculatedValue();
            // $MPN = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $MPN = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $MPN = trim(str_replace("  ", ' ', $MPN));
            $MPN = trim(str_replace(array("'"), "''", $MPN));
            $MPN = strtoupper($MPN);
            $data['0']=$MPN;
            // $MANUF = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            // $MANUF = trim(str_replace("  ", ' ', $MANUF));
            // $MANUF = trim(str_replace(array("'"), "''", $MANUF));
            // $data['MANUF']=$MANUF;
            $BRAND = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 
            $BRAND = trim(str_replace("  ", ' ', $BRAND));
            $BRAND = trim(str_replace(array("'"), "''", $BRAND));
            $BRAND = strtoupper($BRAND);
            $data['1']=$BRAND;
            $MODEL = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $MODEL = trim(str_replace("  ", ' ', $MODEL));
            $MODEL = trim(str_replace(array("'"), "''", $MODEL));
            $MODEL = strtoupper($MODEL);
            $data['2']=$MODEL;
            $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = strtoupper($PRODUCT_FAMILY);
            $data['3']=$PRODUCT_FAMILY;
            $Model_Id = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $Model_Id = trim(str_replace("  ", ' ', $Model_Id));
            $Model_Id = trim(str_replace(array("'"), "", $Model_Id));
            $Model_Id = strtoupper($Model_Id);
            $data['4']=$Model_Id;
            $ProcessorType = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
            $ProcessorType = trim(str_replace("  ", ' ', $ProcessorType));
            $ProcessorType = trim(str_replace(array("'"), "", $ProcessorType));
            $ProcessorType = strtoupper($ProcessorType);
            $data['5']=$ProcessorType;

            $CPU_Code= $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
            $CPU_Code = trim(str_replace("  ", ' ', $CPU_Code));
            $CPU_Code = trim(str_replace(array("'"), "", $CPU_Code));
            $CPU_Code = strtoupper($CPU_Code);
            $data['6']=$CPU_Code;

            $ProcessorSpeed = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
            $ProcessorSpeed = trim(str_replace("  ", ' ', $ProcessorSpeed));
            $ProcessorSpeed = trim(str_replace(array("'"), "", $ProcessorSpeed));
            $ProcessorSpeed = strtoupper($ProcessorSpeed);
            $data['7']=$ProcessorSpeed;

            $Number_of_Cores = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
            $Number_of_Cores = trim(str_replace("  ", ' ', $Number_of_Cores));
            $Number_of_Cores = trim(str_replace(array("'"), "", $Number_of_Cores));
            $Number_of_Cores = strtoupper($Number_of_Cores);
            $data['8']=$Number_of_Cores;

            $ScreenSize = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
            $ScreenSize = trim(str_replace("  ", ' ', $ScreenSize));
            $ScreenSize = trim(str_replace(array("'"), "", $ScreenSize));
            $ScreenSize = strtoupper($ScreenSize);
            $data['9']=$ScreenSize;

            $DisplayResolution = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
            $DisplayResolution = trim(str_replace("  ", ' ', $DisplayResolution));
            $DisplayResolution = trim(str_replace(array("'"), "", $DisplayResolution));
            $DisplayResolution = strtoupper($DisplayResolution);
            $data['10']=$DisplayResolution;

            $StorageType = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
            $StorageType = trim(str_replace("  ", ' ', $StorageType));
            $StorageType = trim(str_replace(array("'"), "", $StorageType));
            $StorageType = strtoupper($StorageType);
            $data['11']=$StorageType;

            $HDDCapacity = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
            $HDDCapacity = trim(str_replace("  ", ' ', $HDDCapacity));
            $HDDCapacity = trim(str_replace(array("'"), "", $HDDCapacity));
            $HDDCapacity = strtoupper($HDDCapacity);
            $data['12']=$HDDCapacity;

            $Memory = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
            $Memory = trim(str_replace("  ", ' ', $Memory));
            $Memory = trim(str_replace(array("'"), "", $Memory));
            $Memory = strtoupper($Memory);
            $data['13']=$Memory;

            $GraphicProcessor = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
            $GraphicProcessor = trim(str_replace("  ", ' ', $GraphicProcessor));
            $GraphicProcessor = trim(str_replace(array("'"), "", $GraphicProcessor));
            $GraphicProcessor = strtoupper($GraphicProcessor);
            $data['14']=$GraphicProcessor;

            $Year = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
            $Year = trim(str_replace("  ", ' ', $Year));
            $Year = trim(str_replace(array("'"), "", $Year));
            $Year = strtoupper($Year);
            $data['15']=$Year;

            $EMC = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
            $EMC = trim(str_replace("  ", ' ', $EMC));
            $EMC = trim(str_replace(array("'"), "", $EMC));
            $EMC = strtoupper($EMC);
            $data['16']=$EMC;

            $CustomSpeed = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
            $CustomSpeed = trim(str_replace("  ", ' ', $CustomSpeed));
            $CustomSpeed = trim(str_replace(array("'"), "", $CustomSpeed));
            $CustomSpeed = strtoupper($CustomSpeed);
            $data['17']=$CustomSpeed;
            // var_dump($MPN, $MANUF, $BRAND, $MODEL, $PRODUCT_FAMILY, $Model_Id, $ProcessorType, $CPU_Code);exit;
             // var_dump(count($data));exit;
            $user_id = $this->session->userdata('user_id');
            date_default_timezone_set("America/Chicago");
            $current_date = date("Y-m-d H:i:s");
            $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
            $mt_id = [];
            
            foreach($data as $row2){
                
                $spec_name= strtoupper($row2);
                 //var_dump($spec_name);exit;
                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = 111422 AND UPPER(SPECIFIC_NAME) = '$spec_name'");
                if($check->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT','MT_ID') ID FROM DUAL");
                $rs = $query->result_array();
                $mt_id = $rs[0]['ID'];
                $pk[] = $mt_id;
                $this->db->query("INSERT INTO CATEGORY_SPECIFIC_MT(
                    MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY)  VALUES($mt_id,111422,'$spec_name',1,1,1,'FreeText',$current_date,1,1) ");//exit;
                }else{
                    $rs = $check->result_array();
                    $mt_id = $rs[0]['MT_ID'];
                    $pk[] = $mt_id;
                }
                
            }
// var_dump($pk);exit;
}else{

                      // var_dump($total_rows);exit;
            // $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','LAPTOP_ZONE_ID') ID FROM DUAL");
            // $rs = $query->result_array();
            // $LAPTOP_ZONE_ID = $rs[0]['ID'];
            
            // $PO_MT_AUCTION_NO = $objPHPExcel->getActiveSheet()->getCell(''.$i)->getCalculatedValue();
            // $MPN = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $MPN = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $MPN = trim(str_replace("  ", ' ', $MPN));
            $MPN = trim(str_replace(array("'"), "''", $MPN));
            $MPN = strtoupper($MPN);
            $data['0']=$MPN;
            // $MANUF = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            // $MANUF = trim(str_replace("  ", ' ', $MANUF));
            // $MANUF = trim(str_replace(array("'"), "''", $MANUF));
            // $data['MANUF']=$MANUF;
            $BRAND = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 
            $BRAND = trim(str_replace("  ", ' ', $BRAND));
            $BRAND = trim(str_replace(array("'"), "''", $BRAND));
            $data['1']=$BRAND;
            $MODEL = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $MODEL = trim(str_replace("  ", ' ', $MODEL));
            $MODEL = trim(str_replace(array("'"), "''", $MODEL));
             $data['2']=$MODEL;
            $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
            $data['3']=$PRODUCT_FAMILY;
            $Model_Id = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $Model_Id = trim(str_replace("  ", ' ', $Model_Id));
            $Model_Id = trim(str_replace(array("'"), "", $Model_Id));
            $data['4']=$Model_Id;
            $ProcessorType = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
            $ProcessorType = trim(str_replace("  ", ' ', $ProcessorType));
            $ProcessorType = trim(str_replace(array("'"), "", $ProcessorType));
            $data['5']=$ProcessorType;
            $CPU_Code= $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
            $CPU_Code = trim(str_replace("  ", ' ', $CPU_Code));
            $CPU_Code = trim(str_replace(array("'"), "", $CPU_Code));
            $data['6']=$CPU_Code;
            $ProcessorSpeed = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
            $ProcessorSpeed = trim(str_replace("  ", ' ', $ProcessorSpeed));
            $ProcessorSpeed = trim(str_replace(array("'"), "", $ProcessorSpeed));
            $data['7']=$ProcessorSpeed;
            $Number_of_Cores = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
            $Number_of_Cores = trim(str_replace("  ", ' ', $Number_of_Cores));
            $Number_of_Cores = trim(str_replace(array("'"), "", $Number_of_Cores));
            $data['8']=$Number_of_Cores;
            $ScreenSize = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
            $ScreenSize = trim(str_replace("  ", ' ', $ScreenSize));
            $ScreenSize = trim(str_replace(array("'"), "", $ScreenSize));
            $data['9']=$ScreenSize;
            $DisplayResolution = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
            $DisplayResolution = trim(str_replace("  ", ' ', $DisplayResolution));
            $DisplayResolution = trim(str_replace(array("'"), "", $DisplayResolution));
            $data['10']=$DisplayResolution;
            $StorageType = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
            $StorageType = trim(str_replace("  ", ' ', $StorageType));
            $StorageType = trim(str_replace(array("'"), "", $StorageType));
            $data['11']=$StorageType;
            $HDDCapacity = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
            $HDDCapacity = trim(str_replace("  ", ' ', $HDDCapacity));
            $HDDCapacity = trim(str_replace(array("'"), "", $HDDCapacity));
            $data['12']=$HDDCapacity;
            $Memory = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
            $Memory = trim(str_replace("  ", ' ', $Memory));
            $Memory = trim(str_replace(array("'"), "", $Memory));
            $data['13']=$Memory;
            $GraphicProcessor = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
            $GraphicProcessor = trim(str_replace("  ", ' ', $GraphicProcessor));
            $GraphicProcessor = trim(str_replace(array("'"), "", $GraphicProcessor));
            $data['14']=$GraphicProcessor;
            $Year = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
            $Year = trim(str_replace("  ", ' ', $Year));
            $Year = trim(str_replace(array("'"), "", $Year));
            $data['15']=$Year;
            $EMC = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
            $EMC = trim(str_replace("  ", ' ', $EMC));
            $EMC = trim(str_replace(array("'"), "", $EMC));

            $data['16']=$EMC;
            $CustomSpeed = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
            $CustomSpeed = trim(str_replace("  ", ' ', $CustomSpeed));
            $CustomSpeed = trim(str_replace(array("'"), "", $CustomSpeed));
            $data['17']=$CustomSpeed;
            // var_dump($MPN, $MANUF, $BRAND, $MODEL, $PRODUCT_FAMILY, $Model_Id, $ProcessorType, $CPU_Code);exit;
             // var_dump(count($data));exit;
            $user_id = $this->session->userdata('user_id');
            date_default_timezone_set("America/Chicago");
            $current_date = date("Y-m-d H:i:s");
            $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
            // $mt_id = [];
             $j=0;
            foreach($data as $row2){
                $mt_id = $pk[$j];
                $spec_name= strtoupper($row2);
                 //var_dump($spec_name);exit;
                if(!empty($spec_name) || $spec_name = 'N/A'){
                    $check = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID =$mt_id AND UPPER(D.SPECIFIC_VALUE) = '$spec_name' AND MT_ID = $mt_id"); 
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
                        
                        $check = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT D WHERE UPPER(D.MPN) = '$MPN' AND D.CATEGORY_ID = $cat_id"); 
                        if($check->num_rows() == 0){
                            $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $catalogue_mt_id = $rs[0]['ID'];
                        $CAT_pk[] = $catalogue_mt_id;
                        
                        $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY)  VALUES($catalogue_mt_id,'$MPN',111422,$current_date,$user_id) ");//exit;
                        }else{
                            $rs = $check->result_array();
                        $catalogue_mt_id = $rs[0]['CATALOGUE_MT_ID'];
                        $CAT_pk[] = $catalogue_mt_id;

                        $query = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET WHERE UPPER(SPECIFIC_VALUE) = '$spec_name' AND MT_ID = $mt_id");
                        $rs = $query->result_array();
                        $spec_det_id = $rs[0]['DET_ID'];
                        if($j==2 || $j == 3 || $j == 4){
                            $catalogue_group_id = 11;
                        }elseif($j==5 || $j == 6 || $j == 7 || $j == 8){
                            $catalogue_group_id ==2;
                        }elseif($j==9 || $j == 10 || $j == 14){
                            $catalogue_group_id = 3;
                        }elseif($j==11 || $j == 12){
                            $catalogue_group_id = 10;
                        }elseif($j==13){
                            $catalogue_group_id = 5;
                        }else{
                            $catalogue_group_id = 9;
                        }



                        $check = $this->db->query("SELECT CATALOGUE_DET_ID FROM LZ_CATALOGUE_DET D WHERE D.CATALOGUE_MT_ID = $catalogue_mt_id AND SPECIFIC_DET_ID = $spec_det_id"); 
                        if($check->num_rows() == 0){
                            $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','CATALOGUE_DET_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $catalogue_det_id = $rs[0]['ID'];
                        $CAT_pk[] = $catalogue_det_id;
                        
                        $this->db->query("INSERT INTO LZ_CATALOGUE_DET(CATALOGUE_DET_ID, CATALOGUE_MT_ID, CATALOGUE_GROUP_ID, SPECIFIC_DET_ID)  VALUES($catalogue_det_id,$catalogue_mt_id,$catalogue_group_id,$spec_det_id) ");//exit;
                        }//nested if close
                    }//nested ifelse close from else part
                }//nested ifelse close 
            }//spec_name if close 
                
                $j++;
            }//nested foreach close
//var_dump($det_pk);exit;
}//main else colse
            
    $i++;   
            
            
        }//main forech close
    }
}
}
?>