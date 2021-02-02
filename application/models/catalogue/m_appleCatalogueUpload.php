<?php

class m_appleCatalogueUpload extends CI_Model
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

            $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
 
            $data['0']=$PRODUCT_FAMILY;

            $MODEL = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $MODEL = trim(str_replace("  ", ' ', $MODEL));
            $MODEL = trim(str_replace(array("'"), "''", $MODEL));

            $data['1']=$MODEL;

            $MPN = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $MPN = trim(str_replace("  ", ' ', $MPN));
            $MPN = trim(str_replace(array("'"), "''", $MPN));
            $MPN = strtoupper($MPN);
            $data['2']=$MPN;

            $Category_ID = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $Category_ID = trim(str_replace("  ", ' ', $Category_ID));
            $Category_ID = trim(str_replace(array("'"), "''", $Category_ID));
            $Category_ID = strtoupper($Category_ID);
            // $data['3'] = $Category_ID;
            
             // var_dump(count($data));exit;
            $user_id = $this->session->userdata('user_id');
            date_default_timezone_set("America/Chicago");
            $current_date = date("Y-m-d H:i:s");
            $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";
            $mt_id = [];
            
            foreach($data as $row2){
                
                $spec_name= $row2;
                 //var_dump($spec_name);exit;
                $check = $this->db->query("SELECT MT_ID FROM CATEGORY_SPECIFIC_MT WHERE EBAY_CATEGORY_ID = 111422 AND UPPER(SPECIFIC_NAME) = UPPER('$spec_name')");
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

            $PRODUCT_FAMILY = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $PRODUCT_FAMILY = trim(str_replace("  ", ' ', $PRODUCT_FAMILY));
            $PRODUCT_FAMILY = trim(str_replace(array("'"), "''", $PRODUCT_FAMILY));
          
            $spec_data['0']=$PRODUCT_FAMILY;

            $MODEL = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
            $MODEL = trim(str_replace("  ", ' ', $MODEL));
            $MODEL = trim(str_replace(array("'"), "''", $MODEL));
 
            $spec_data['1']=$MODEL;

            $MPN = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $MPN = trim(str_replace("  ", ' ', $MPN));
            $MPN = trim(str_replace(array("'"), "''", $MPN));
            $MPN = strtoupper($MPN);
            $spec_data['2']=$MPN;
            $data['0'] = $MPN;

            $OBJECT = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $OBJECT = trim(str_replace("  ", ' ', $OBJECT));
            $OBJECT = trim(str_replace(array("'"), "''", $OBJECT));
            $OBJECT = strtoupper($OBJECT);

            $MPN_Desc = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $MPN_Desc = trim(str_replace("  ", ' ', $MPN_Desc));
            $MPN_Desc = trim(str_replace(array("'"), "''", $MPN_Desc));
            $MPN_Desc = strtoupper($MPN_Desc);
            $data['1'] = $MPN_Desc;



            $j=0;
            foreach($spec_data as $row2){
                $spec_name= $row2;
                $mt_id = $pk[$j];
                 //var_dump($spec_name);exit;
                if(!empty($spec_name) || $spec_name = 'N/A'){
                    $check = $this->db->query("SELECT DET_ID FROM CATEGORY_SPECIFIC_DET D WHERE D.MT_ID =$mt_id AND UPPER(D.SPECIFIC_VALUE) = UPPER('$spec_name') AND MT_ID = $mt_id"); 
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
                    }
                 }
                 $j++;
            }

           

            if(!empty($MPN) || $MPN == 'N/A'){

                $checkObj = $this->db2->query("SELECT OBJECT_ID FROM  LZ_BD_OBJECTS_MT OB WHERE  UPPER(OB.OBJECT_NAME) LIKE '%$OBJECT%' AND OB.CATEGORY_ID = 111422" );
                 // echo $checkObj->OBJECT_ID;exit;
                 // var_dump($checkObj);exit;
                if($checkObj->num_rows() == 0){
                    $query = $this->db2->query("SELECT LAPTOP_ZONE.get_single_primary_key('LZ_BD_OBJECTS_MT','OBJECT_ID') OBJECT_ID FROM DUAL");
                    $rs = $query->result_array();
                    $object_id = $rs[0]['OBJECT_ID'];
                    // $obj_pk[] = $object_id;

                    $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID,OBJECT_NAME,INSERT_DATE,INSERT_BY,CATEGORY_ID)  VALUES($object_id,LTRIM('$OBJECT'),$current_date,2,111422) ");
                }else{

                     $rs = $checkObj->result_array();
                     $object_id = $rs[0]['OBJECT_ID'];
                     // $obj_pk[] = $object_id;
                }
            


                $check = $this->db->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT D WHERE UPPER(D.MPN) = '$MPN' AND D.CATEGORY_ID = 111422"); 
                    
                    if($check->num_rows() == 0){
                        $query = $this->db->query("SELECT get_single_primary_key('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $catalogue_mt_id = $rs[0]['ID'];
                        $CAT_pk[] = $catalogue_mt_id;
                        
                        $this->db->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,CUSTOM_MPN,OBJECT_ID,MPN_DESCRIPTION)  VALUES($catalogue_mt_id,'$MPN',111422,$current_date,$user_id,0,$object_id,'$MPN_Desc') ");//exit;
                    }else{
                        $rs = $check->result_array();
                        // var_dump($rs);exit;
                        $catalogue_mt_id = $rs[0]['CATALOGUE_MT_ID'];
                        $sqlQry = $this->db->query("UPDATE LZ_CATALOGUE_MT MT SET MT.MPN = '$MPN',MT.CATEGORY_ID = 111422,MT.INSERTED_DATE= $current_date,MT.INSERTED_BY = $user_id,MT.CUSTOM_MPN = 0,MT.OBJECT_ID = $object_id,MT.MPN_DESCRIPTION = '$MPN_Desc' WHERE MT.CATALOGUE_MT_ID = $catalogue_mt_id");
                        
                        $CAT_pk[] = $catalogue_mt_id;
                    }

            }
//var_dump($det_pk);exit;
}//main else colse
            
    $i++;   
            
            
        }//main forech close
    }
}
}
?>