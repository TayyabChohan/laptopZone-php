<?php

class m_alternateMpnUpload extends CI_Model
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

        if (strtolower($ext)!='xlsx')
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
                $master_MPN = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
                $master_MPN = trim(str_replace("  ", ' ', $master_MPN));
                $master_MPN = trim(str_replace(array("'"), "''", $master_MPN));
                $master_MPN = strtoupper($master_MPN);
                // $data['0'] = $master_MPN;

                $alt_MPN = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $alt_MPN = trim(str_replace("  ", ' ', $alt_MPN));
                $alt_MPN = trim(str_replace(array("'"), "''", $alt_MPN));
                $alt_MPN = strtoupper($alt_MPN);
                // $data['1'] = $alt_MPN;

                $category_id = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $category_id = trim(str_replace("  ", ' ', $category_id));
                $category_id = trim(str_replace(array("'"), "''", $category_id));
                $category_id = strtoupper($category_id);
                // $data['1'] = $category_id;



                $user_id = $this->session->userdata('user_id');
                date_default_timezone_set("America/Chicago");
                $current_date = date("Y-m-d H:i:s");
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

                if(!empty($master_MPN) || $master_MPN == 'N/A'){

                    $CHECK_CATALOGUE_ID = $this->db2->query("SELECT C.CATALOGUE_MT_ID FROM LZ_CATALOGUE_MT C WHERE UPPER(C.MPN) LIKE '%$master_MPN%' AND C.CATEGORY_ID = $category_id" );
                 // echo $checkObj->OBJECT_ID;exit;
                 // var_dump($checkObj);exit;
                    $CATALOGUE_ID = $CHECK_CATALOGUE_ID->result_array();
                    // var_dump($CATALOGUE_ID);exit;
                    $CATALOGUE_MT_ID = @$CATALOGUE_ID[0]['CATALOGUE_MT_ID']; 
                        // var_dump($CATALOGUE_MT_ID);exit;                
                    if($CATALOGUE_MT_ID != ''){
                    $checkObj = $this->db2->query("SELECT LZ_CATALOGUE_ALT_ID FROM LZ_CATALOGUE_ALT_MT WHERE CATALOGUE_MT_ID = $CATALOGUE_MT_ID AND  UPPER(ALT_MPN) LIKE '%$alt_MPN%'");
                        if($checkObj->num_rows() == 0){
                            $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_CATALOGUE_ALT_MT','LZ_CATALOGUE_ALT_ID') ID FROM DUAL");
                            
                            $rs = $query->result_array();
                            $ALT_MPN_ID = $rs[0]['ID'];
                            if(empty($ALT_MPN_ID)){
                                $ALT_MPN_ID = 1;
                            }
                            // $obj_pk[] = $object_id;

                            $this->db2->query("INSERT INTO LZ_CATALOGUE_ALT_MT(LZ_CATALOGUE_ALT_ID,CATALOGUE_MT_ID,ALT_MPN)  VALUES($ALT_MPN_ID,$CATALOGUE_MT_ID,TRIM('$alt_MPN')) ");
                        }//else{
                            //      $rs = $checkObj->result_array();
                            //      $object_id = $rs[0]['OBJECT_ID'];
                            //      $obj_pk[] = $object_id;
                            // }                        
                    }
 

                    $i++;
                }
            }//endforeach

            
        }
    }
}