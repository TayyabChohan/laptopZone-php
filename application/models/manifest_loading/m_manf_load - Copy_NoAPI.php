<?php

class m_manf_load extends CI_Model
{
     public function __construct(){
        parent::__construct();
        $this->load->database();
    }
     function uploadCSV()
    {

        // $loading_batch = $this->input->post('loading_batch');
        // $purch_ref = $this->input->post('purch_ref');
        // $loading_date = $this->input->post('loading_date');
        // $purchase_date = $this->input->post('purchase_date');    
        // $supplier = $this->input->post('supplier');
        // $remarks = $this->input->post('remarks');

        $csv_mimetypes = array(
        'text/csv',
        'text/plain',
        'application/csv',
        'text/comma-separated-values',
        'application/excel',
        'application/vnd.ms-excel',
        'application/vnd.msexcel',
        'text/anytext',
        'application/octet-stream',
        'application/txt',
        );

        if (in_array($_FILES['file_name']['type'], $csv_mimetypes)) 
        {
            // possible CSV file
            // could also check for file content at this point

                $count=0;
                $fp = fopen($_FILES['file_name']['tmp_name'],'r') or die("can't open file");
                
                while($csv_line = fgetcsv($fp))
                {
                    $count++;
                    if($count == 1)
                    {
                        continue;
                    }//keep this if condition if you want to remove the first row
                    for($i = 0, $j = count($csv_line); $i < $j; $i++)
                    {
                        $insert_csv = array();

                    }
                    $i++;
            $query = $this->db->query("SELECT MAX(LAPTOP_ZONE_ID) as LAPTOP_ZONE_ID FROM LZ_MANIFEST_DET_TEST");
            $rs = $query->result_array();
            $e = $rs[0]['LAPTOP_ZONE_ID'];
            if(@$e == 0){$LAPTOP_ZONE_ID = 1;}else{$LAPTOP_ZONE_ID = $e+1;}

            $PO_MT_AUCTION_NO = $csv_line[0];
            $PO_DETAIL_LOT_REF= $csv_line[1];
            $PO_MT_REF_NO= $csv_line[2];
            $ITEM_MT_MANUFACTURE= $csv_line[3];
            $ITEM_MT_MFG_PART_NO= $csv_line[4];
            $ITEM_MT_DESC= $csv_line[5];
            $ITEM_MT_BBY_SKU= $csv_line[6];
            $ITEM_MT_UPC= $csv_line[7];
            $PO_DETAIL_RETIAL_PRICE= $csv_line[8];
            $MAIN_CATAGORY_SEG1= '';
            $SUB_CATAGORY_SEG2= '';
            $BRAND_SEG3= $csv_line[3];
            $ORIGIN_SEG4= "";
            $CONDITIONS_SEG5= '';
            $E_BAY_CATA_ID_SEG6= '';
            //$LAPTOP_ZONE_ID= "";
            $LAPTOP_ITEM_CODE= '';
            $AVAILABLE_QTY= 1;

            $PRICE= "''";
            $comma = ',';
            
            //var_dump($PRICE);exit;
            //$LZ_MANIFEST_ID= "";
            $CATAGORY_NAME_SEG7= '';
            $qry_det = "INSERT INTO LZ_MANIFEST_DET_TEST VALUES('$PO_MT_AUCTION_NO' $comma '$PO_DETAIL_LOT_REF' $comma '$PO_MT_REF_NO' $comma '$ITEM_MT_MANUFACTURE' $comma '$ITEM_MT_MFG_PART_NO' $comma '$ITEM_MT_DESC' $comma '$ITEM_MT_BBY_SKU' $comma '$ITEM_MT_UPC' $comma $PO_DETAIL_RETIAL_PRICE $comma NULL $comma NULL $comma NULL $comma NULL $comma NULL $comma 1 $comma '$LAPTOP_ZONE_ID' $comma '$LAPTOP_ITEM_CODE' $comma $AVAILABLE_QTY $comma $PRICE $comma NULL $comma NULL )";
            $this->db->query($qry_det);

            //$insert_query = $this->db->query("INSERT INTO tableName VALUES (".$csv_line[0].",'".$csv_line[1]."','".$csv_line[2]."')");

                }
        }else {
          die("Sorry, only csv file type allowed");
        }
                fclose($fp) or die("can't close file");
                $data['success'] = "success";
                return $data;
    }

}

    ?>