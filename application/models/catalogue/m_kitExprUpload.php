<?php

class m_kitExprUpload extends CI_Model
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
            	$CATALOGUE_MT_ID = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $CATALOGUE_MT_ID = trim(str_replace("  ", ' ', $CATALOGUE_MT_ID));
                $CATALOGUE_MT_ID = trim(str_replace(array("'"), "''", $CATALOGUE_MT_ID));
                $CATALOGUE_MT_ID = strtoupper($CATALOGUE_MT_ID);
                // $data['0'] = $CATALOGUE_MT_ID;

                $BRAND = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $BRAND = trim(str_replace("  ", ' ', $BRAND));
                $BRAND = trim(str_replace(array("'"), "''", $BRAND));
                $BRAND = strtoupper($BRAND);
                // $data['1'] = $BRAND;

                $MODEL = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $MODEL = trim(str_replace("  ", ' ', $MODEL));
                $MODEL = trim(str_replace(array("'"), "''", $MODEL));
                $MODEL = strtoupper($MODEL);
            //     $data['2'] = $Object;



                $user_id = $this->session->userdata('user_id');
                date_default_timezone_set("America/Chicago");
                $current_date = date("Y-m-d H:i:s");
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

                if(!empty($CATALOGUE_MT_ID) || $CATALOGUE_MT_ID != 'N/A'){


                $EXPR = "AND UPPER(TITLE) LIKE ''%".$BRAND."%'' AND UPPER(TITLE) LIKE ''%".$MODEL."%''";


                // var_dump($EXPR);exit;

                $checkExpr = $this->db2->query("SELECT R.MPN_RECOG_MT_ID FROM LZ_BD_MPN_RECOG_MT R WHERE R.CATALOGUE_MT_ID = $CATALOGUE_MT_ID AND R.EXPR_TEXT = '$EXPR'");
                // var_dump($checkExpr);
                if($checkExpr->num_rows() == 0){

                    $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_RECOG_MT','MPN_RECOG_MT_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $recog_mt_id = $rs[0]['ID'];

                    $this->db2->query("INSERT INTO LZ_BD_MPN_RECOG_MT(MPN_RECOG_MT_ID, CATALOGUE_MT_ID, EXPR_TEXT,INSERTED_DATE,INSERTED_BY,MASTER_EXPR,KIT_EXPR)  VALUES($recog_mt_id,$CATALOGUE_MT_ID,'$EXPR',$current_date,$user_id,0,1) ");
                        
                }
                $i++;
             }//endif
            }//endforeach
        }
    }
}