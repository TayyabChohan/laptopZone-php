<?php

class m_newMasterCatalogueUpload extends CI_Model
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
                $MPN = strtoupper($MPN);
                $MPN = trim(str_replace(array("'S"), "", $MPN));                
                $MPN = trim(str_replace(array("'"), "''", $MPN));
                
                $data['0'] = $MPN;

                $Brand = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
                $Brand = trim(str_replace("  ", ' ', $Brand));
                $Brand = trim(str_replace(array("'"), "''", $Brand));
                $Brand = strtoupper($Brand);                

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

                $uniqueBrand = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $uniqueBrand = trim(str_replace("  ", ' ', $uniqueBrand));
                $uniqueBrand = strtoupper($uniqueBrand);
                $uniqueBrand = trim(str_replace(array("'S"), "", $uniqueBrand));                 
                $uniqueBrand = trim(str_replace(array("'"), "''", $uniqueBrand));
                
                $uniqueMpn = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $uniqueMpn = trim(str_replace("  ", ' ', $uniqueMpn));
                $uniqueMpn = strtoupper($uniqueMpn);
                $uniqueMpn = trim(str_replace(array("'S"), "", $uniqueMpn));                 
                $uniqueMpn = trim(str_replace(array("'"), "''", $uniqueMpn));


                $uniqueCore = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $uniqueCore = trim(str_replace("  ", ' ', $uniqueCore));
                $uniqueCore = strtoupper($uniqueCore);
                $uniqueCore = trim(str_replace(array("'S"), "", $uniqueCore));                 
                $uniqueCore = trim(str_replace(array("'"), "''", $uniqueCore));


                $uniqueProcessor = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                $uniqueProcessor = trim(str_replace("  ", ' ', $uniqueProcessor));
                $uniqueProcessor = strtoupper($uniqueProcessor);
                $uniqueProcessor = trim(str_replace(array("'S"), "", $uniqueProcessor));                 
                $uniqueProcessor = trim(str_replace(array("'"), "''", $uniqueProcessor));


                $uniqueExt = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                $uniqueExt = trim(str_replace("  ", ' ', $uniqueExt));
                $uniqueExt = strtoupper($uniqueExt);
                $uniqueExt = trim(str_replace(array("'S"), "", $uniqueExt));                 
                $uniqueExt = trim(str_replace(array("'"), "''", $uniqueExt));


                $uniqueL = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
                $uniqueL = trim(str_replace("  ", ' ', $uniqueL));
                $uniqueL = strtoupper($uniqueL);
                $uniqueL = trim(str_replace(array("'S"), "", $uniqueL));                 
                $uniqueL = trim(str_replace(array("'"), "''", $uniqueL));


                $uniqueM = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
                $uniqueM = trim(str_replace("  ", ' ', $uniqueM));
                $uniqueM = strtoupper($uniqueM);
                $uniqueM = trim(str_replace(array("'S"), "", $uniqueM));                 
                $uniqueM = trim(str_replace(array("'"), "''", $uniqueM));


                $uniqueN = $objPHPExcel->getActiveSheet()->getCell('N'.$i)->getCalculatedValue();
                $uniqueN = trim(str_replace("  ", ' ', $uniqueN));
                $uniqueN = strtoupper($uniqueN);
                $uniqueN = trim(str_replace(array("'S"), "", $uniqueN));                
                $uniqueN = trim(str_replace(array("'"), "''", $uniqueN));


                $uniqueO = $objPHPExcel->getActiveSheet()->getCell('O'.$i)->getCalculatedValue();
                $uniqueO = trim(str_replace("  ", ' ', $uniqueO));
                $uniqueO = strtoupper($uniqueO);
                $uniqueO = trim(str_replace(array("'S"), "", $uniqueO));                
                $uniqueO = trim(str_replace(array("'"), "''", $uniqueO));
 

                $uniqueP = $objPHPExcel->getActiveSheet()->getCell('P'.$i)->getCalculatedValue();
                $uniqueP = trim(str_replace("  ", ' ', $uniqueP));
                $uniqueP = strtoupper($uniqueP);
                $uniqueP = trim(str_replace(array("'S"), "", $uniqueP));                
                $uniqueP = trim(str_replace(array("'"), "''", $uniqueP));


                $uniqueQ = $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->getCalculatedValue();
                $uniqueQ = trim(str_replace("  ", ' ', $uniqueQ));
                $uniqueQ = strtoupper($uniqueQ);
                $uniqueQ = trim(str_replace(array("'S"), "", $uniqueQ));                 
                $uniqueQ = trim(str_replace(array("'"), "''", $uniqueQ));
 

                $uniqueR = $objPHPExcel->getActiveSheet()->getCell('R'.$i)->getCalculatedValue();
                $uniqueR = trim(str_replace("  ", ' ', $uniqueR));
                $uniqueR = strtoupper($uniqueR);
                $uniqueR = trim(str_replace(array("'S"), "", $uniqueR));                
                $uniqueR = trim(str_replace(array("'"), "''", $uniqueR));
 

                $uniqueS = $objPHPExcel->getActiveSheet()->getCell('S'.$i)->getCalculatedValue();
                $uniqueS = trim(str_replace("  ", ' ', $uniqueS));
                $uniqueS = strtoupper($uniqueS);
                $uniqueS = trim(str_replace(array("'S"), "", $uniqueS));                
                $uniqueS = trim(str_replace(array("'"), "''", $uniqueS));
 
                $uniqueT = $objPHPExcel->getActiveSheet()->getCell('T'.$i)->getCalculatedValue();
                $uniqueT = trim(str_replace("  ", ' ', $uniqueT));
                $uniqueT = strtoupper($uniqueT);
                $uniqueT = trim(str_replace(array("'S"), "", $uniqueT));                
                $uniqueT = trim(str_replace(array("'"), "''", $uniqueT));


                $uniqueU = $objPHPExcel->getActiveSheet()->getCell('U'.$i)->getCalculatedValue();
                $uniqueU = trim(str_replace("  ", ' ', $uniqueU));
                $uniqueU = strtoupper($uniqueU);
                $uniqueU = trim(str_replace(array("'S"), "", $uniqueU));                 
                $uniqueU = trim(str_replace(array("'"), "''", $uniqueU));


                $uniqueV = $objPHPExcel->getActiveSheet()->getCell('V'.$i)->getCalculatedValue();
                $uniqueV = trim(str_replace("  ", ' ', $uniqueV));
                $uniqueV = strtoupper($uniqueV);
                $uniqueV = trim(str_replace(array("'S"), "", $uniqueV));                 
                $uniqueV = trim(str_replace(array("'"), "''", $uniqueV));


                $uniqueW = $objPHPExcel->getActiveSheet()->getCell('W'.$i)->getCalculatedValue();
                $uniqueW = trim(str_replace("  ", ' ', $uniqueW));
                $uniqueW = strtoupper($uniqueW);
                $uniqueW = trim(str_replace(array("'S"), "", $uniqueW));                
                $uniqueW = trim(str_replace(array("'"), "''", $uniqueW));
              

                $uniqueX = $objPHPExcel->getActiveSheet()->getCell('X'.$i)->getCalculatedValue();
                $uniqueX = trim(str_replace("  ", ' ', $uniqueX));
                $uniqueX = strtoupper($uniqueX);
                $uniqueX = trim(str_replace(array("'S"), "", $uniqueX));                 
                $uniqueX = trim(str_replace(array("'"), "''", $uniqueX));
   

                $uniqueY = $objPHPExcel->getActiveSheet()->getCell('Y'.$i)->getCalculatedValue();
                $uniqueY = trim(str_replace("  ", ' ', $uniqueY));
                $uniqueY = strtoupper($uniqueY);
                $uniqueY = trim(str_replace(array("'S"), "", $uniqueY));                
                $uniqueY = trim(str_replace(array("'"), "''", $uniqueY));
       

                $uniqueZ = $objPHPExcel->getActiveSheet()->getCell('Z'.$i)->getCalculatedValue();
                $uniqueZ = trim(str_replace("  ", ' ', $uniqueZ));
                $uniqueZ = strtoupper($uniqueZ);
                $uniqueZ = trim(str_replace(array("'S"), "", $uniqueZ));                
                $uniqueZ = trim(str_replace(array("'"), "''", $uniqueZ));
                                     

                $user_id = $this->session->userdata('user_id');
                date_default_timezone_set("America/Chicago");
                $current_date = date("Y-m-d H:i:s");
                $current_date= "TO_DATE('".$current_date."', 'YYYY-MM-DD HH24:MI:SS')";

                if(!empty($MPN) || $MPN != 'N/A'){

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

	                
	            

                // var_dump($catalogue_mt_id);exit;
                // $EXPR = "AND (UPPER(TITLE) LIKE '%".$MPN."%' OR UPPER(TITLE)LIKE '%."$uniqueBrand".%' OR UPPER(TITLE)LIKE '%."$uniqueMpn".%' OR UPPER(TITLE)LIKE '%."$uniqueCore".%' OR UPPER(TITLE)LIKE '%."$uniqueProcessor".%' OR UPPER(TITLE)LIKE '%."$uniqueExt".%')";

                $EXPR = "AND UPPER(TITLE) LIKE ''%".$MPN."%'";

                if($uniqueBrand != '' && $uniqueBrand != $MPN){
                    
                    if($uniqueMpn !=''){
                        $EXPR = $EXPR."' OR (UPPER(TITLE) LIKE ''%".$uniqueBrand."%'";
                    }
                    else{
                        $EXPR = $EXPR."' OR (UPPER(TITLE) LIKE ''%".$uniqueBrand."%'')";
                    }
                }else{
                    $EXPR = "AND UPPER(TITLE) LIKE ''%".$MPN."%''";
                }

                if($uniqueMpn !='' && $uniqueMpn != $MPN){
                    if($uniqueCore !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueMpn."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueMpn."%'')";
                    }
                    
                }

                if($uniqueCore !='' && $uniqueCore != $MPN){
                    if($uniqueProcessor !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueCore."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueCore."%'')";
                    }
                    
                }

                if($uniqueProcessor !='' && $uniqueProcessor != $MPN){
                    if($uniqueExt !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueProcessor."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueProcessor."%'')";
                    }
                    
                }

                if($uniqueExt !=''){
                    if($uniqueL !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueExt."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueExt."%'')";
                    }    
                }

                if($uniqueL !=''){
                    if($uniqueM !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueL."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueL."%'')";
                    }
                    
                }

                if($uniqueM !=''){
                   
                    if($uniqueN !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueM."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueM."%'')";
                    }                   
                }

                if($uniqueN !=''){
                   
                    if($uniqueO !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueN."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueN."%'')";
                    }                   
                }     

                if($uniqueO !=''){
                   
                    if($uniqueP !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueO."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueO."%'')";
                    }                   
                }    

                if($uniqueP !=''){
                   
                    if($uniqueQ !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueP."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueP."%'')";
                    }                   
                }  

                if($uniqueQ !=''){
                   
                    if($uniqueR !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueQ."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueQ."%'')";
                    }                   
                }

                if($uniqueR !=''){
                   
                    if($uniqueS !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueR."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueR."%'')";
                    }                   
                }                                                                      


                if($uniqueS !=''){
                   
                    if($uniqueT !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueS."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueS."%'')";
                    }                   
                }

                if($uniqueT !=''){
                   
                    if($uniqueU !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueT."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueT."%'')";
                    }                   
                }

                if($uniqueU !=''){
                   
                    if($uniqueV !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueU."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueU."%'')";
                    }                   
                }        

                if($uniqueV !=''){
                   
                    if($uniqueW !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueV."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueV."%'')";
                    }                   
                }    

                if($uniqueW !=''){
                   
                    if($uniqueX !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueW."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueW."%'')";
                    }                   
                } 

                if($uniqueX !=''){
                   
                    if($uniqueY !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueX."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueX."%'')";
                    }                   
                }          

                if($uniqueY !=''){
                   
                    if($uniqueZ !=''){
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueY."%'";
                    }else{
                        $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueY."%'')";
                    }                   
                }                                                          

                if($uniqueZ !=''){   
                    $EXPR = $EXPR."' AND UPPER(TITLE) LIKE ''%".$uniqueZ."%'')";  
                }

                // var_dump($EXPR);exit;

                $checkExpr = $this->db2->query("SELECT R.CATALOGUE_MT_ID,R.EXPR_TEXT FROM LZ_BD_MPN_RECOG_MT R WHERE R.CATALOGUE_MT_ID = $catalogue_mt_id AND R.EXPR_TEXT = '$EXPR'");
                // var_dump($checkExpr);
                if($checkExpr->num_rows() == 0){
                    
                    $query = $this->db2->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_MPN_RECOG_MT','MPN_RECOG_MT_ID') ID FROM DUAL");
                        $rs = $query->result_array();
                        $recog_mt_id = $rs[0]['ID'];

                    $this->db2->query("INSERT INTO LZ_BD_MPN_RECOG_MT(MPN_RECOG_MT_ID, CATALOGUE_MT_ID, EXPR_TEXT,INSERTED_DATE,INSERTED_BY,MASTER_EXPR,KIT_EXPR)  VALUES($recog_mt_id,$catalogue_mt_id,'$EXPR',$current_date,$user_id,1,0) ");
                        
                }
                $i++;
             }//endif
            }//endforeach
        }
    }
}