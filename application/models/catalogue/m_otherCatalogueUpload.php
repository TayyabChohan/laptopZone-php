<?php

class m_otherCatalogueUpload extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function import_xls_record()
    {

        $cat_id = $this->input->post('category_id');
        // var_dump($cat_id);exit;
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
            
            $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            // var_dump($total_rows);exit;
            // $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','LZ_CATALOGUE_MT_ID') ID FROM DUAL");
            $data = [];
            $pk = [];
            foreach ($objWorksheet->getRowIterator() as $row)
            {
if($i==1){
            

                      // var_dump($total_rows);exit;
            // $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET','LAPTOP_ZONE_ID') ID FROM DUAL");
            // $rs = $query->result_array();
            // $LAPTOP_ZONE_ID = $rs[0]['ID'];
            
            // $PO_MT_AUCTION_NO = $objPHPExcel->getActiveSheet()->getCell(''.$i)->getCalculatedValue();
            // $MPN = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();


            $MPN_DESC = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $MPN_DESC = trim(str_replace("  ", ' ', $MPN_DESC));
            $MPN_DESC = trim(str_replace(array("'"), "''", $MPN_DESC));
            $MPN_DESC = strtoupper($MPN_DESC);


            $UPC = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $UPC = trim(str_replace("  ", ' ', $UPC));
            $UPC = trim(str_replace(array("'"), "''", $UPC));
            $UPC = strtoupper($UPC);
            $data['0'] = $UPC;

            $MPN = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $MPN = trim(str_replace("  ", ' ', $MPN));
            $MPN = trim(str_replace(array("'"), "''", $MPN));
            $MPN = strtoupper($MPN);
            $data['1'] = $MPN;
            // $MANUF = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            // $MANUF = trim(str_replace("  ", ' ', $MANUF));
            // $MANUF = trim(str_replace(array("'"), "''", $MANUF));
            // $data['MANUF']=$MANUF;
            $BRAND = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 
            $BRAND = trim(str_replace("  ", ' ', $BRAND));
            $BRAND = trim(str_replace(array("'"), "''", $BRAND));
            $BRAND = strtoupper($BRAND);
            $data['2']=$BRAND;

            $MODEL_NAME = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $MODEL_NAME = trim(str_replace("  ", ' ', $MODEL_NAME));
            $MODEL_NAME = trim(str_replace(array("'"), "''", $MODEL_NAME));
            $MODEL_NAME = strtoupper($MODEL_NAME);
            $data['3']=$MODEL_NAME;

            $MODEL_NUMBER = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $MODEL_NUMBER = trim(str_replace("  ", ' ', $MODEL_NUMBER));
            $MODEL_NUMBER = trim(str_replace(array("'"), "''", $MODEL_NUMBER));
            $MODEL_NUMBER = strtoupper($MODEL_NUMBER);
            $data['4']=$MODEL_NUMBER;

            $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = strtoupper($PRODUCT_FAMILY);
            $data['5']=$PRODUCT_FAMILY;

            $PC_TYPE = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
            $PC_TYPE = trim(str_replace("  ", ' ', $PC_TYPE));
            $PC_TYPE = trim(str_replace(array("'"), "''", $PC_TYPE));
            $PC_TYPE = strtoupper($PC_TYPE);
            $data['6']=$PC_TYPE;

            $ProcessorType = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
            $ProcessorType = trim(str_replace("  ", ' ', $ProcessorType));
            $ProcessorType = trim(str_replace(array("'"), "", $ProcessorType));
            $ProcessorType = strtoupper($ProcessorType);
            $data['7']=$ProcessorType;

            $CPU_Code= $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
            $CPU_Code = trim(str_replace("  ", ' ', $CPU_Code));
            $CPU_Code = trim(str_replace(array("'"), "", $CPU_Code));
            $CPU_Code = strtoupper($CPU_Code);
            $data['8']=$CPU_Code;

            $ProcessorSpeed = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
            $ProcessorSpeed = trim(str_replace("  ", ' ', $ProcessorSpeed));
            $ProcessorSpeed = trim(str_replace(array("'"), "", $ProcessorSpeed));
            $ProcessorSpeed = strtoupper($ProcessorSpeed);
            $data['9']=$ProcessorSpeed;

            $CPU_GEN = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
            $CPU_GEN = trim(str_replace("  ", ' ', $CPU_GEN));
            $CPU_GEN = trim(str_replace(array("'"), "", $CPU_GEN));
            $CPU_GEN = strtoupper($CPU_GEN);
            $data['10']=$CPU_GEN;

            $Number_of_Cores = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
            $Number_of_Cores = trim(str_replace("  ", ' ', $Number_of_Cores));
            $Number_of_Cores = trim(str_replace(array("'"), "", $Number_of_Cores));
            $Number_of_Cores = strtoupper($Number_of_Cores);
            $data['11']=$Number_of_Cores;

            $ScreenSize = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
            $ScreenSize = trim(str_replace("  ", ' ', $ScreenSize));
            $ScreenSize = trim(str_replace(array("'"), "", $ScreenSize));
            $ScreenSize = strtoupper($ScreenSize);
            $data['12']=$ScreenSize;

            $DisplayResolution = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
            $DisplayResolution = trim(str_replace("  ", ' ', $DisplayResolution));
            $DisplayResolution = trim(str_replace(array("'"), "", $DisplayResolution));
            $DisplayResolution = strtoupper($DisplayResolution);
            $data['13']=$DisplayResolution;

            $HDDCapacity= $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
            $HDDCapacity = trim(str_replace("  ", ' ', $HDDCapacity));
            $HDDCapacity = trim(str_replace(array("'"), "", $HDDCapacity));
            $HDDCapacity = strtoupper($HDDCapacity);
            $data['14']=$HDDCapacity;

            $SSDCapacity = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
            $SSDCapacity = trim(str_replace("  ", ' ', $SSDCapacity));
            $SSDCapacity = trim(str_replace(array("'"), "", $SSDCapacity));
            $SSDCapacity = strtoupper($SSDCapacity);
            $data['15']=$SSDCapacity;

            $Memory = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
            $Memory = trim(str_replace("  ", ' ', $Memory));
            $Memory = trim(str_replace(array("'"), "", $Memory));
            $Memory = strtoupper($Memory);
            $data['16']=$Memory;

            $BusSpeed = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
            $BusSpeed = trim(str_replace("  ", ' ', $BusSpeed));
            $BusSpeed = trim(str_replace(array("'"), "", $BusSpeed));
            $BusSpeed = strtoupper($BusSpeed);
            $data['17']=$BusSpeed;

            $RAMType = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
            $RAMType = trim(str_replace("  ", ' ', $RAMType));
            $RAMType = trim(str_replace(array("'"), "", $RAMType));
            $RAMType = strtoupper($RAMType);
            $data['18']=$RAMType;

            $GraphicProcessor = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
            $GraphicProcessor = trim(str_replace("  ", ' ', $GraphicProcessor));
            $GraphicProcessor = trim(str_replace(array("'"), "", $GraphicProcessor));
            $GraphicProcessor = strtoupper($GraphicProcessor);
            $data['19']=$GraphicProcessor;

            $GPUBrand = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
            $GPUBrand = trim(str_replace("  ", ' ', $GPUBrand));
            $GPUBrand = trim(str_replace(array("'"), "", $GPUBrand));
            $GPUBrand = strtoupper($GPUBrand);
            $data['20']=$GPUBrand;

            $Year = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
            $Year = trim(str_replace("  ", ' ', $Year));
            $Year = trim(str_replace(array("'"), "", $Year));
            $Year = strtoupper($Year);
            $data['21']=$Year;

            $COLOR = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
            $COLOR = trim(str_replace("  ", ' ', $COLOR));
            $COLOR = trim(str_replace(array("'"), "", $COLOR));
            $COLOR = strtoupper($COLOR);
            $data['22']=$COLOR;
 
            $StorageSpeed = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
            $StorageSpeed = trim(str_replace("  ", ' ', $StorageSpeed));
            $StorageSpeed = trim(str_replace(array("'"), "", $StorageSpeed));
            $StorageSpeed = strtoupper($StorageSpeed);
            $data['23'] = $StorageSpeed;

           
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
                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT_TEST WHERE EBAY_CATEGORY_ID = $cat_id AND UPPER(SPECIFIC_NAME) = '$spec_name'");
                if($check->num_rows() == 0){
                    $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_MT_TEST','MT_ID') ID FROM DUAL");
                $rs = $query->result_array();
                $mt_id = $rs[0]['ID'];
                $pk[] = $mt_id;
                $this->db->query("INSERT INTO CATEGORY_SPECIFIC_MT_TEST(
                    MT_ID, EBAY_CATEGORY_ID, SPECIFIC_NAME, MARKETPLACE_ID, MAX_VALUE, MIN_VALUE, SELECTION_MODE, UPDATE_DATE, CUSTOM, CATALOGUE_ONLY)  VALUES($mt_id,$cat_id,'$spec_name',1,1,1,'FreeText',$current_date,1,1) ");//exit;
                }else{
                    $rs = $check->result_array();
                    $mt_id = $rs[0]['MT_ID'];
                    $pk[] = $mt_id;
                }
                
            }
// var_dump($pk);exit;
}else{

    // print_r($pk);exit;
            $MPN_DESC = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $MPN_DESC = trim(str_replace("  ", ' ', $MPN_DESC));
            $MPN_DESC = trim(str_replace(array("'"), "''", $MPN_DESC));
            $MPN_DESC = strtoupper($MPN_DESC);

            // var_dump($MPN_DESC);exit;    

            $OBJECT = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
            $OBJECT = trim(str_replace("  ", ' ', $OBJECT));
            $OBJECT = trim(str_replace(array("'"), "''", $OBJECT));
            $OBJECT = strtoupper($OBJECT);

            $UPC = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $UPC = trim(str_replace("  ", ' ', $UPC));
            $UPC = trim(str_replace(array("'"), "''", $UPC));
            $UPC = strtoupper($UPC);
            $data['0'] = strtoupper($UPC);

            $MPN = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $MPN = trim(str_replace("  ", ' ', $MPN));
            $MPN = trim(str_replace(array("'"), "''", $MPN));
            $MPN = strtoupper($MPN);
            $data['1'] = strtoupper($MPN);
            // $MANUF = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            // $MANUF = trim(str_replace("  ", ' ', $MANUF));
            // $MANUF = trim(str_replace(array("'"), "''", $MANUF));
            // $data['MANUF']=$MANUF;
            $BRAND = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 
            $BRAND = trim(str_replace("  ", ' ', $BRAND));
            $BRAND = trim(str_replace(array("'"), "''", $BRAND));
            $data['2']= strtoupper($BRAND);

            $MODEL_NAME = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $MODEL_NAME = trim(str_replace("  ", ' ', $MODEL_NAME));
            $MODEL_NAME = trim(str_replace(array("'"), "''", $MODEL_NAME));
            $data['3']=strtoupper($MODEL_NAME);

            $MODEL_NUMBER = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $MODEL_NUMBER = trim(str_replace("  ", ' ', $MODEL_NUMBER));
            $MODEL_NUMBER = trim(str_replace(array("'"), "''", $MODEL_NUMBER));
            $data['4']=strtoupper($MODEL_NUMBER);

            $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
            $data['5']=strtoupper($PRODUCT_FAMILY);

            $PC_TYPE = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
            $PC_TYPE = trim(str_replace("  ", ' ', $PC_TYPE));
            $PC_TYPE = trim(str_replace(array("'"), "''", $PC_TYPE));
            $data['6'] = strtoupper($PC_TYPE);

            $ProcessorType = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
            $ProcessorType = trim(str_replace("  ", ' ', $ProcessorType));
            $ProcessorType = trim(str_replace(array("'"), "", $ProcessorType));
            $data['7'] = strtoupper($ProcessorType);

            $CPU_Code= $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
            $CPU_Code = trim(str_replace("  ", ' ', $CPU_Code));
            $CPU_Code = trim(str_replace(array("'"), "", $CPU_Code));
            $data['8']=strtoupper($CPU_Code);

            $ProcessorSpeed = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
            $ProcessorSpeed = trim(str_replace("  ", ' ', $ProcessorSpeed));
            $ProcessorSpeed = trim(str_replace(array("'"), "", $ProcessorSpeed));
            $data['9']=strtoupper($ProcessorSpeed);

            $CPU_GEN = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
            $CPU_GEN = trim(str_replace("  ", ' ', $CPU_GEN));
            $CPU_GEN = trim(str_replace(array("'"), "", $CPU_GEN));
            $data['10']=strtoupper($CPU_GEN);

            $Number_of_Cores = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
            $Number_of_Cores = trim(str_replace("  ", ' ', $Number_of_Cores));
            $Number_of_Cores = trim(str_replace(array("'"), "", $Number_of_Cores));
            $data['11']=strtoupper($Number_of_Cores);

            $ScreenSize = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
            $ScreenSize = trim(str_replace("  ", ' ', $ScreenSize));
            $ScreenSize = trim(str_replace(array("'"), "", $ScreenSize));
            $data['12']=strtoupper($ScreenSize);

            $DisplayResolution = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
            $DisplayResolution = trim(str_replace("  ", ' ', $DisplayResolution));
            $DisplayResolution = trim(str_replace(array("'"), "", $DisplayResolution));
            $data['13']=strtoupper($DisplayResolution);

            $HDDCapacity= $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
            $HDDCapacity = trim(str_replace("  ", ' ', $HDDCapacity));
            $HDDCapacity = trim(str_replace(array("'"), "", $HDDCapacity));
            $data['14']=strtoupper($HDDCapacity);

            $SSDCapacity = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
            $SSDCapacity = trim(str_replace("  ", ' ', $SSDCapacity));
            $SSDCapacity = trim(str_replace(array("'"), "", $SSDCapacity));
            $data['15']=strtoupper($SSDCapacity);

            $Memory = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
            $Memory = trim(str_replace("  ", ' ', $Memory));
            $Memory = trim(str_replace(array("'"), "", $Memory));
            $data['16']=strtoupper($Memory);

            $BusSpeed = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
            $BusSpeed = trim(str_replace("  ", ' ', $BusSpeed));
            $BusSpeed = trim(str_replace(array("'"), "", $BusSpeed));
            $data['17']=strtoupper($BusSpeed);

            $RAMType = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
            $RAMType = trim(str_replace("  ", ' ', $RAMType));
            $RAMType = trim(str_replace(array("'"), "", $RAMType));
            $data['18']=strtoupper($RAMType);

            $GraphicProcessor = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
            $GraphicProcessor = trim(str_replace("  ", ' ', $GraphicProcessor));
            $GraphicProcessor = trim(str_replace(array("'"), "", $GraphicProcessor));
            $data['19']=strtoupper($GraphicProcessor);

            $GPUBrand = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
            $GPUBrand = trim(str_replace("  ", ' ', $GPUBrand));
            $GPUBrand = trim(str_replace(array("'"), "", $GPUBrand));
            $data['20'] = strtoupper($GPUBrand);

            // var_dump($GPUBrand);exit;

            $Year = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
            $Year = trim(str_replace("  ", ' ', $Year));
            $Year = trim(str_replace(array("'"), "", $Year));
            $data['21']=strtoupper($Year);

            $COLOR = $objPHPExcel->getActiveSheet()->getCell('AA'.$i)->getCalculatedValue();
            $COLOR = trim(str_replace("  ", ' ', $COLOR));
            $COLOR = trim(str_replace(array("'"), "", $COLOR));
            $data['22']=strtoupper($COLOR);
 
            $StorageSpeed = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
            $StorageSpeed = trim(str_replace("  ", ' ', $StorageSpeed));
            $StorageSpeed = trim(str_replace(array("'"), "", $StorageSpeed));
            $data['23'] = strtoupper($StorageSpeed);
             // var_dump(count($data));exit;
            $user_id = $this->session->userdata('user_id');
            date_default_timezone_set("America/Chicago");
            $current_date = date("Y-m-d H:i:s");
            $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
            // $mt_id = [];
             
            $checkObj = $this->db2->query("SELECT OBJECT_ID FROM  LZ_BD_OBJECTS_MT_TEST OB WHERE  UPPER(OB.OBJECT_NAME) LIKE '%$OBJECT%' AND OB.CATEGORY_ID = $cat_id" );
                 // echo $checkObj->OBJECT_ID;exit;
                 // var_dump($checkObj);exit;
            if($checkObj->num_rows() == 0){
                $query = $this->db2->query("SELECT LAPTOP_ZONE.get_single_primary_key('LZ_BD_OBJECTS_MT_TEST','OBJECT_ID') OBJECT_ID FROM DUAL");
                $rs = $query->result_array();
                $object_id = $rs[0]['OBJECT_ID'];
                // $obj_pk[] = $object_id;

                $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT_TEST(OBJECT_ID,OBJECT_NAME,INSERT_DATE,INSERT_BY,CATEGORY_ID)  VALUES($object_id,LTRIM('$OBJECT'),$current_date,2,$cat_id) ");
            }else{
                 $rs = $checkObj->result_array();
                 $object_id = $rs[0]['OBJECT_ID'];
                 // $obj_pk[] = $object_id;
            } 
          


            $j=0;
            foreach($data as $row2){
                // print_r($pk);exit;
                $mt_id = $pk[$j];
                // var_dump($mt_id);exit;
                $spec_name= strtoupper($row2);
                 //var_dump($spec_name);exit;
                if(!empty($spec_name) || $spec_name == 'N/A'){
                    $check = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET_TEST D WHERE D.MT_ID =$mt_id AND UPPER(D.SPECIFIC_VALUE)  = '$spec_name' "); 
                    if($check->num_rows() == 0){
                        $query = $this->db->query("SELECT get_single_primary_key('CATEGORY_SPECIFIC_DET_TEST','DET_ID') ID FROM DUAL");
                    $rs = $query->result_array();
                    $det_id = $rs[0]['ID'];
                    $det_pk[] = $det_id;
                    $spec_det_id = $det_id;
                    
                    $this->db->query("INSERT INTO CATEGORY_SPECIFIC_DET_TEST(DET_ID, MT_ID, SPECIFIC_VALUE)  VALUES($det_id,$mt_id,'$spec_name') ");//exit;
                    }else{
                        $rs = $check->result_array();
                        $det_id = $rs[0]['DET_ID'];
                        $det_pk[] = $det_id;
                        $spec_det_id = $det_id;
                        
                        $check = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT_TEST D WHERE UPPER(D.MPN) = '$MPN' AND D.CATEGORY_ID = $cat_id"); 
                        if($check->num_rows() == 0){
                            $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT_TEST','CATALOGUE_MT_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $catalogue_mt_id = $rs[0]['ID'];
                        $CAT_pk[] = $catalogue_mt_id;
                        
                        $this->db->query("INSERT INTO LZ_CATALOGUE_MT_TEST(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,CUSTOM_MPN,OBJECT_ID,MPN_DESCRIPTION)  VALUES($catalogue_mt_id,'$MPN',$cat_id,$current_date,$user_id,0,$object_id,'$MPN_DESC') ");//exit;
                        }else{
                            $rs = $check->result_array();
                        $catalogue_mt_id = $rs[0]['CATALOGUE_MT_ID'];
                        $CAT_pk[] = $catalogue_mt_id;

                        // $query = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET WHERE UPPER(SPECIFIC_VALUE)  = '$spec_name' AND MT_ID = $mt_id");
                        // $rs = $query->result_array();
                        // $spec_det_id = $rs[0]['DET_ID'];
                        if($j==0 || $j == 1 || $j == 2 || $j == 3 || $j == 4 || $j == 5 || $j == 6){
                            $catalogue_group_id = 11;
                        }
                        elseif($j==7 || $j == 8 || $j == 9 || $j == 10 || $j == 11){
                            $catalogue_group_id = 2;
                        }
                        elseif($j==12 || $j == 13 ){
                            $catalogue_group_id = 3;
                        }
                        elseif($j==14 || $j == 15 || $j == 23){
                            $catalogue_group_id = 10;
                        }
                        elseif($j == 16 || $j == 17 || $j == 18){
                            $catalogue_group_id = 5;
                        }
                        elseif($j == 21 || $j == 22){
                            $catalogue_group_id = 9;
                        }
                        else{
                            $catalogue_group_id = 12;
                        }



                        $check = $this->db->query("SELECT CATALOGUE_DET_ID FROM LZ_CATALOGUE_DET_TEST D WHERE D.CATALOGUE_MT_ID = $catalogue_mt_id AND SPECIFIC_DET_ID = $spec_det_id"); 
                        if($check->num_rows() == 0){
                            $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_DET_TEST','CATALOGUE_DET_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $catalogue_det_id = $rs[0]['ID'];
                        $CAT_pk[] = $catalogue_det_id;
                        
                        $this->db->query("INSERT INTO LZ_CATALOGUE_DET_TEST(CATALOGUE_DET_ID, CATALOGUE_MT_ID, CATALOGUE_GROUP_ID, SPECIFIC_DET_ID)  VALUES($catalogue_det_id,$catalogue_mt_id,$catalogue_group_id,$spec_det_id) ");//exit;
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