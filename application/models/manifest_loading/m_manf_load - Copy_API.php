<?php

class m_manf_load extends CI_Model
{
     public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    function uploadData()
    {
        $count=0;
        $fp = fopen($_FILES['file_name']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
                $insert_csv['id'] = $csv_line[0];//remove if you want to have primary key,
                $insert_csv['empName'] = $csv_line[1];
                $insert_csv['empAddress'] = $csv_line[2];

            }
            $i++;
            // $data = array(
            //     'ID' => $insert_csv['id'] ,
            //     'EMPNAME' => $insert_csv['empName'],
            //     'EMPADDRESS' => $insert_csv['empAddress']);

            //  $this->db->insert('tableName', $data);


$insert_query = $this->db->query("INSERT INTO tableName VALUES (".$csv_line[0].",'".$csv_line[1]."','".$csv_line[2]."')");

        }
        fclose($fp) or die("can't close file");
        $data['success'] = "success";
        return $data;
    }
    function uploadCSV($purch_ref,$loading_date,$purchase_date,$supplier,$remarks,$file_name,$item_condition)
    {
        
    $csv_mimetypes = array(
    'text/csv',
    'text/plain',
    'application/csv',
    'text/comma-separated-values',
     'application/excel',
     'application/vnd.ms-excel',
    // 'application/vnd.msexcel',
    'text/anytext',
    // 'application/octet-stream',
    'application/txt'
    );

if (in_array($_FILES['file_name']['type'], $csv_mimetypes)) 
{
        require('get-common/Productionkeys.php'); 
            require('get-common/eBaySession.php');
        //  ============== Mt table insert Start ====================
            SELECT GET_SINGLE_PRIMARY_KEY('LZ_MANIFEST_MT_TEST','LZ_MANIFEST_ID') emp_id FROM DUAL
        $query = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_MANIFEST_MT_TEST','LZ_MANIFEST_ID') MANIFEST_ID FROM DUAL");
        $rs = $query->result_array();
        $e = $rs[0]['MANIFEST_ID'];
        if(@$e == 0){$LZ_MANIFEST_ID = 1;}else{$LZ_MANIFEST_ID = $e+1;}
        $max_query = $this->db->query("SELECT MAX(LOADING_NO) as LOADING_NO FROM LZ_MANIFEST_MT_TEST");
        $rs = $max_query->result_array();
        $e = $rs[0]['LOADING_NO'];
        if(@$e == 0){$LOADING_NO = 1;}else{$LOADING_NO = $e+1;}
        $loading_date= "TO_DATE('".$loading_date."', 'MM-DD-YYYY')";
        $purchase_date= "TO_DATE('".$purchase_date."', 'MM-DD-YYYY')";
        //$loading_date=$this->input->post('Lodaing_Date');
        $DOC_SEQ_ID=18;
        $POSTED="Post In ERP";
        $GRN_ID='';
        $PURCHASE_INVOICE_ID='';
        $SINGLE_ENTRY_ID='';
        $comma = ',';
        $qry_mt = "INSERT INTO LZ_MANIFEST_MT_TEST VALUES($LZ_MANIFEST_ID $comma $LOADING_NO $comma $loading_date $comma '$purch_ref' $comma '$supplier' $comma '$remarks' $comma $DOC_SEQ_ID $comma $purchase_date $comma '$POSTED' $comma '$file_name' $comma '$GRN_ID' $comma '$PURCHASE_INVOICE_ID' $comma '$SINGLE_ENTRY_ID')";
        $this->db->query($qry_mt);
        $loading_date= "";
        $purchase_date= "";

        //  ==============Mt Table insert End =====================
        $count=0;
        ini_set('auto_detect_line_endings',TRUE);
        $fp = fopen($_FILES['file_name']['tmp_name'],'r') or die("can't open file");

        while(($csv_line = fgetcsv($fp) ) !== FALSE)
        {
            //$csv_line = fgetcsv($fp,1024);
            $count++;
            if($count == 1)
            {
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
                // $insert_csv['id'] = $csv_line[0];//remove if you want to have primary key,
                // $insert_csv['empName'] = $csv_line[1];
                // $insert_csv['empAddress'] = $csv_line[2];

            }
            $i++;
            //var_dump($csv_line[0]."<br>".$csv_line[1]."<br>".$csv_line[2]."<br>".$csv_line[3]."<br>".$csv_line[4]."<br>".$csv_line[5]."<br>".$csv_line[6]."<br>".$csv_line[7]."<br>".$csv_line[8]);exit;
            // ====== get Category Script Start ====================
            //redirect(base_url() . 'index.php/admin/welcome/import_clients/', 'refresh');
            
            //Get the query inputted
            $UPC =$csv_line[7];
            $MPN =$csv_line[4];
            
            if(!empty($MPN)){$query = $MPN;}elseif(!empty($UPC)){$query = $UPC;}else{$query = NULL;}
            //var_dump($query);exit;
            if($query !== NULL)
            {

                $siteID = 0;
                //the call being made:
                $verb = 'GetSuggestedCategories';
                ///Build the request Xml string
                $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                $requestXmlBody .= "<Query>$query</Query>";
                $requestXmlBody .= '</GetSuggestedCategoriesRequest>';
                //Create a new eBay session with all details pulled in from included keys.php
                $session = new eBaySession($userToken, $devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                //send the request and get response
                $responseXml = $session->sendHttpRequest($requestXmlBody);
                $responseDoc = new DomDocument();
                $responseDoc->loadXML($responseXml);
                $response = simplexml_import_dom($responseDoc);
                 //var_dump($response);exit;
                if ($response->Ack !== 'Failure' && $response->CategoryCount > 0) {
                    $cat = $response->SuggestedCategoryArray->SuggestedCategory->Category;
                    $categoryParentName1 = $cat->CategoryParentName[0];
                    $categoryParentName2 = $cat->CategoryParentName[1];
                    $categoryName = $cat->CategoryName;
                    $categoryID = $cat->CategoryID;
                }else{
                    $categoryParentName1 = NULL;
                    $categoryParentName2 = NULL;
                    $categoryName = NULL;
                    $categoryID = NULL;
                }
            }else{
                $categoryParentName1 = NULL;
                $categoryParentName2 = NULL;
                $categoryName = NULL;
                $categoryID = NULL;
            }
            
// ====================== get catergory script End ======================

// =================== Get Price Script Start ==========================
                                    
            if(!empty($MPN)){$KeyWord = $MPN;}elseif(!empty($UPC)){$KeyWord = $UPC;}else{$KeyWord = NULL;}
            
            if($KeyWord !== NULL)
            {
                $cond = $item_condition;
                $category = $categoryID;                
                $NumPerPage = 10;       
                $sortOrder = "&sortOrder=PricePlusShippingLowest";
                $condition = "&itemFilter(0).name=Condition";
                $condition.="&itemFilter(0).value(0)=".$cond;
                $buyingFormat = "&itemFilter(1).name=ListingType";
                $buyingFormat.="&itemFilter(1).value(0)=FixedPrice";
                $FreeShippingOnly = "&itemFilter(2).name=FreeShippingOnly";
                $FreeShippingOnly.="&itemFilter(2).value(0)=true";

                if(!empty($category)){
                    $categoryId="&categoryId=".$category;//.$categoryId;
                }else{$categoryId="";}
                $SellerInfo = "&outputSelector(0)=SellerInfo";
                $PictureURLSuperSize = "&outputSelector(1)=PictureURLSuperSize";
                $StoreInfo = "&outputSelector(2)=StoreInfo";
                $HideDuplicateItems="&HideDuplicateItems=true";
                $MinQuantity="&MinQuantity=1";
                $pageNumber = 1;

                $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
                $URL = $URL.$KeyWord."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber."&sortOrder=".$sortOrder.$MinQuantity.$HideDuplicateItems.$condition.$buyingFormat.$FreeShippingOnly.$categoryId.$SellerInfo.$PictureURLSuperSize.$StoreInfo;

                $XML = new SimpleXMLElement(file_get_contents($URL));
                $count = $XML->paginationOutput->totalEntries;
                 //echo $count;
         //           echo "<pre>";
         //  print_r($XML);
         // //    //var_dump($response);
         //   echo "</pre>";
         //   echo "Sajid <br>";
         //   echo $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
         //   exit;
                // print_r($XML);exit;
                if ($XML->ack !== 'Failure' && $count > 0) {
                    //foreach($XML->searchResult->item as $item)
                    //{
                      //$sellingStatus = $item->sellingStatus;
                      $price= $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
                      //var_dump($price);exit;
                      //break;
                    //}
                }else{
                    $price='';
                }
            }else{
                $price='';
            }

// ======================== Get Price Script End =============================
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
            $MAIN_CATAGORY_SEG1= $categoryParentName1;
            $SUB_CATAGORY_SEG2= $categoryParentName2;
            $BRAND_SEG3= $csv_line[3];
            $ORIGIN_SEG4= "";
            $CONDITIONS_SEG5= $item_condition;
            $E_BAY_CATA_ID_SEG6= $categoryID;
            //$LAPTOP_ZONE_ID= "";
            $LAPTOP_ITEM_CODE= '';
            $AVAILABLE_QTY= 1;
            if(!empty(@$price)){
                $PRICE= @$price;
            }else{
            $PRICE= "''";
            }
            //var_dump($PRICE);exit;
            //$LZ_MANIFEST_ID= "";
            $CATAGORY_NAME_SEG7= $categoryName;
            

            $qry_det = "INSERT INTO LZ_MANIFEST_DET_TEST VALUES('$PO_MT_AUCTION_NO' $comma '$PO_DETAIL_LOT_REF' $comma '$PO_MT_REF_NO' $comma '$ITEM_MT_MANUFACTURE' $comma '$ITEM_MT_MFG_PART_NO' $comma '$ITEM_MT_DESC' $comma '$ITEM_MT_BBY_SKU' $comma '$ITEM_MT_UPC' $comma $PO_DETAIL_RETIAL_PRICE $comma '$MAIN_CATAGORY_SEG1' $comma '$SUB_CATAGORY_SEG2' $comma '$BRAND_SEG3' $comma '$ORIGIN_SEG4' $comma '$CONDITIONS_SEG5' $comma '$E_BAY_CATA_ID_SEG6' $comma '$LAPTOP_ZONE_ID' $comma '$LAPTOP_ITEM_CODE' $comma $AVAILABLE_QTY $comma $PRICE $comma $LZ_MANIFEST_ID $comma '$CATAGORY_NAME_SEG7' )";
            $this->db->query($qry_det);

        }// End While
        ini_set('auto_detect_line_endings',FALSE);
}else {
  die("Sorry, only csv file type allowed");
}
        fclose($fp) or die("can't close file");
        echo "file uploaded";
    }//End Upload CSV function
}

    ?>