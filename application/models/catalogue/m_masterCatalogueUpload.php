<?php

class m_masterCatalogueUpload extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

    }


    public function import_xls_record(){
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

            $i = 2;

            foreach ($objWorksheet->getRowIterator() as $row)
            {
            	$MPN = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $MPN = trim(str_replace("  ", ' ', $MPN));
                $MPN = trim(str_replace(array("'"), "''", $MPN));
                $MPN = strtoupper($MPN);
                $data['0'] = $MPN;

                $MPN_Desc = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $MPN_Desc = trim(str_replace("  ", ' ', $MPN_Desc));
                $MPN_Desc = trim(str_replace(array("'"), "''", $MPN_Desc));
                $MPN_Desc = strtoupper($MPN_Desc);
                $data['1'] = $MPN_Desc;

                $OBJECT = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $OBJECT = trim(str_replace("  ", ' ', $OBJECT));
                $OBJECT = trim(str_replace(array("'"), "''", $OBJECT));
                $OBJECT = strtoupper($OBJECT);
            //     $data['2'] = $Object;

                $Category_ID = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $Category_ID = trim(str_replace("  ", ' ', $Category_ID));
                $Category_ID = trim(str_replace(array("'"), "''", $Category_ID));
                $Category_ID = strtoupper($Category_ID);
                $data['2'] = $Category_ID;

                $Brand = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $Brand = trim(str_replace("  ", ' ', $Brand));
                $Brand = trim(str_replace(array("'"), "''", $Brand));
                $Brand = strtoupper($Brand);



                $user_id = $this->session->userdata('user_id');
                date_default_timezone_set("America/Chicago");
                $current_date = date("Y-m-d H:i:s");
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

                if(!empty($MPN) || $MPN == 'N/A'){

	                $checkObj = $this->db2->query("SELECT OBJECT_ID FROM  LZ_BD_OBJECTS_MT OB WHERE  UPPER(OB.OBJECT_NAME) LIKE '%$OBJECT%' AND OB.CATEGORY_ID = $Category_ID" );
	                 // echo $checkObj->OBJECT_ID;exit;
	                 // var_dump($checkObj);exit;
		            if($checkObj->num_rows() == 0){

		                $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_OBJECTS_MT','OBJECT_ID') ID FROM DUAL");
		                $rs = $query->result_array();
		                $object_id = $rs[0]['ID'];
		                // $obj_pk[] = $object_id;

		                $this->db2->query("INSERT INTO LZ_BD_OBJECTS_MT(OBJECT_ID,OBJECT_NAME,INSERT_DATE,INSERT_BY,CATEGORY_ID)  VALUES($object_id,LTRIM('$OBJECT'),$current_date,2,$Category_ID) ");
		            }else{
		                 $rs = $checkObj->result_array();
		                 $object_id = $rs[0]['OBJECT_ID'];
		                 // $obj_pk[] = $object_id;
		            } 


		            $check = $this->db2->query("SELECT CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT D WHERE UPPER(D.MPN) = '$MPN' AND D.CATEGORY_ID = $Category_ID"); 
	                if($check->num_rows() == 0){
                        
	                    $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_MT','CATALOGUE_MT_ID') ID FROM DUAL");
		                $rs = $query->result_array();
		                $catalogue_mt_id = $rs[0]['ID'];
		                $CAT_pk[] = $catalogue_mt_id;
		                
		                $this->db2->query("INSERT INTO LZ_CATALOGUE_MT(CATALOGUE_MT_ID, MPN, CATEGORY_ID, INSERTED_DATE, INSERTED_BY,CUSTOM_MPN,OBJECT_ID,MPN_DESCRIPTION,BRAND)  VALUES($catalogue_mt_id,'$MPN',$Category_ID,$current_date,$user_id,0,$object_id,'$MPN_Desc','$Brand') ");//exit;
	                }else{
	                    $rs = $check->result_array();
		                $catalogue_mt_id = $rs[0]['CATALOGUE_MT_ID'];
		                $CAT_pk[] = $catalogue_mt_id;
		            }

	                $i++;
	            }
            }//endforeach

            
        }
    }
}