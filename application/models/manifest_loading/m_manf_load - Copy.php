<?php

class m_manf_load extends CI_Model
    {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function import_xls_record()
    {
        $this->load->library('PHPExcel');
        $ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION);
        //var_dump($ext);exit;

    if ($ext !='xlsx')
    {
        echo "Only Excel files with .xlsx ext are allowed.";
        // $this->session->set_userdata('ERROR' , 'Only Excel files are allowed.');
        // redirect(base_url() . 'index.php/manifest_loading/csv');
    }
    else{
        // $ip = $_SERVER['REMOTE_ADDR'];
        $filename = $this->input->post('file_name').'.'.$ext;
        move_uploaded_file($_FILES["file_name"]["tmp_name"],$filename);
        // move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
        if(strtolower($ext) == 'xlsx')
        {
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $objReader->setReadDataOnly(true);

        }
        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $i=1;
        $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;
        // $n=0;
        // $m=0;
        $loading_batch = $this->input->post('loading_batch');
        $manifest_name = $this->input->post('manifest_name');
        $manifest_name = trim(str_replace("  ", ' ', $manifest_name));
        $purch_ref = $this->input->post('purch_ref');
        $purch_ref = trim(str_replace("  ", ' ', $purch_ref));
        $purch_ref = trim(str_replace(array("'"), "''", $purch_ref)); 
        $loading_date = $this->input->post('loading_date');
        //$purchase_date = $this->input->post('purchase_date');    
        $supplier = $this->input->post('supplier');
        $supplier = trim(str_replace("  ", ' ', $supplier));
        $supplier = trim(str_replace(array("'"), "''", $supplier));
        $remarks = $this->input->post('remarks');
        $remarks = trim(str_replace("  ", ' ', $remarks));
        $remarks = trim(str_replace(array("'"), "''", $remarks));
        $file_name = $_FILES['file_name']['name'];
        $file_name = trim(str_replace("  ", ' ', $file_name));
        $file_name = trim(str_replace(array("'"), "''", $file_name));
        $item_condition = $this->input->post('item_condition');
        $manifest_status = $this->input->post('manifest_status');

            require('get-common/Productionkeys.php'); 
            require('get-common/eBaySession.php');
        //  ============== Mt table insert Start ====================
        $query = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LZ_MANIFEST_ID') ID FROM DUAL");
        $rs = $query->result_array();
        $LZ_MANIFEST_ID = $rs[0]['ID'];
        $max_query = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_MT','LOADING_NO') ID FROM DUAL");
        $rs = $max_query->result_array();
        $LOADING_NO = $rs[0]['ID'];
        $loading_date= "TO_DATE('".$loading_date."', 'MM-DD-YYYY')";
        $purchase_date= "NULL";
        //$loading_date=$this->input->post('Lodaing_Date');
        $DOC_SEQ_ID=18;
        $POSTED="Post In ERP";
        $GRN_ID='';
        $PURCHASE_INVOICE_ID='';
        $SINGLE_ENTRY_ID='';
        $TOTAL_EXCEL_ROWS = $total_rows;
        $MANIFEST_STATUS= $manifest_status;
        $comma = ',';
        $qry_mt = "INSERT INTO LZ_MANIFEST_MT VALUES($LZ_MANIFEST_ID $comma $LOADING_NO $comma $loading_date $comma '$purch_ref' $comma '$supplier' $comma '$remarks' $comma $DOC_SEQ_ID $comma $purchase_date $comma '$POSTED' $comma '$file_name' $comma '$GRN_ID' $comma '$PURCHASE_INVOICE_ID' $comma '$SINGLE_ENTRY_ID' $comma $TOTAL_EXCEL_ROWS $comma '$manifest_name'  $comma '$MANIFEST_STATUS' $comma NULL $comma NULL $comma NULL)";
        $result =$this->db->query($qry_mt);
        $loading_date= "";
        $purchase_date= "";

        //  ==============Mt Table insert End =====================
        foreach ($objWorksheet->getRowIterator() as $row)
        {

            if($i != 1)
            {  

            $query = $this->db->query("SELECT get_single_primary_key('LZ_MANIFEST_DET','LAPTOP_ZONE_ID') ID FROM DUAL");
            $rs = $query->result_array();
            $LAPTOP_ZONE_ID = $rs[0]['ID'];
            
            $PO_MT_AUCTION_NO = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
            $PO_DETAIL_LOT_REF = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
            $PO_MT_REF_NO = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
            $ITEM_MT_MANUFACTURE = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $ITEM_MT_MANUFACTURE = trim(str_replace("  ", ' ', $ITEM_MT_MANUFACTURE));
            $ITEM_MT_MANUFACTURE = trim(str_replace(array("'"), "''", $ITEM_MT_MANUFACTURE));
            $ITEM_MT_MFG_PART_NO = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue(); 
            $ITEM_MT_MFG_PART_NO = trim(str_replace(" ", '', $ITEM_MT_MFG_PART_NO));
            $ITEM_MT_MFG_PART_NO = trim(str_replace(array("'"), "''", $ITEM_MT_MFG_PART_NO));
            $ITEM_MT_DESC = $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
            $ITEM_MT_DESC = trim(str_replace("  ", ' ', $ITEM_MT_DESC));
            $ITEM_MT_DESC = trim(str_replace(array("'"), "''", $ITEM_MT_DESC));
            $ITEM_MT_BBY_SKU = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
            $ITEM_MT_UPC = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
            $ITEM_MT_UPC = trim(str_replace(" ", '', $ITEM_MT_UPC));
            $ITEM_MT_UPC = trim(str_replace(array("'"), "", $ITEM_MT_UPC));
            $PO_DETAIL_RETIAL_PRICE = "''";
            $MAIN_CATAGORY_SEG1 = '';
            $SUB_CATAGORY_SEG2 = '';
            $BRAND_SEG3 = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
            $BRAND_SEG3 = trim(str_replace("  ", ' ', $BRAND_SEG3));
            $BRAND_SEG3 = trim(str_replace(array("'"), "''", $BRAND_SEG3));
            $ORIGIN_SEG4 = "U.S";
            $CONDITIONS_SEG5 = $item_condition;
            $E_BAY_CATA_ID_SEG6 = '';
            //$LAPTOP_ZONE_ID = "";
            $LAPTOP_ITEM_CODE = '';
            $AVAILABLE_QTY = 1;
            $STICKER_PRINT = 0;

            $query = $this->db->query("SELECT SHIP_FEE from LZ_MANIFEST_DET WHERE ITEM_MT_UPC = '$ITEM_MT_UPC' ORDER BY LZ_MANIFEST_ID DESC");
            $rs = $query->result_array();
            if(!empty($rs))
                {
                    $SHIP_FEE = $rs[0]['SHIP_FEE'];
                }else{
                    $query = $this->db->query("SELECT SHIP_FEE from LZ_MANIFEST_DET WHERE ITEM_MT_MFG_PART_NO = '$ITEM_MT_MFG_PART_NO' ORDER BY LZ_MANIFEST_ID DESC");
                    $rs = $query->result_array();
                    if(!empty($rs)){$SHIP_FEE = $rs[0]['SHIP_FEE'];}else{$SHIP_FEE = 3.25;}
                    
                }
  
            $A_PRICE = "''";
            $S_PRICE = "''";
            $V_PRICE = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();;
            $CATAGORY_NAME_SEG7= '';
            $comma = ',';            
            $qry_det = "INSERT INTO LZ_MANIFEST_DET VALUES('$PO_MT_AUCTION_NO' $comma '$PO_DETAIL_LOT_REF' $comma '$PO_MT_REF_NO' $comma '$ITEM_MT_MANUFACTURE' $comma '$ITEM_MT_MFG_PART_NO' $comma '$ITEM_MT_DESC' $comma '$ITEM_MT_BBY_SKU' $comma '$ITEM_MT_UPC' $comma $PO_DETAIL_RETIAL_PRICE $comma NULL $comma NULL $comma NULL $comma '$ORIGIN_SEG4' $comma '$CONDITIONS_SEG5' $comma '$E_BAY_CATA_ID_SEG6' $comma $LAPTOP_ZONE_ID $comma '$LAPTOP_ITEM_CODE' $comma $AVAILABLE_QTY $comma $A_PRICE $comma $LZ_MANIFEST_ID $comma '$BRAND_SEG3' $comma $S_PRICE $comma $V_PRICE $comma $SHIP_FEE $comma $STICKER_PRINT $comma '1')";
            $result = $this->db->query($qry_det);
            //var_dump($result);exit;

            }

        $i++; 
        }
//======================= Get Categories Starts ==========================
        //$query = $this->db->query("SELECT t.item_mt_mfg_part_no MPN, t.item_mt_upc UPC FROM LZ_MANIFEST_DET t where t.LZ_MANIFEST_ID = $LZ_MANIFEST_ID group by  t.item_mt_mfg_part_no,t.item_mt_upc");item_mt_mfg_part_no item_mt_upc

        $query = $this->db->query("SELECT nvl(t.item_mt_upc,t.item_mt_mfg_part_no) UPC_MPN,t.item_mt_upc UPC,t.item_mt_mfg_part_no MPN,t.item_mt_manufacture MANUFACTURE FROM LZ_MANIFEST_DET t where t.LZ_MANIFEST_ID =$LZ_MANIFEST_ID group by nvl(t.item_mt_upc,t.item_mt_mfg_part_no), t.item_mt_manufacture,t.item_mt_upc,t.item_mt_mfg_part_no");
        
        $rs = $query->result_array();
       
        foreach ($rs as $row)
        {
            //echo "No-".$i;
            //var_dump($row['UPC_MPN']);
            if(is_numeric($row['UPC_MPN']))
            {
                $UPC_MPN = $row['UPC_MPN'];

            }else{
                $MPN_UPC = $row['UPC_MPN'];
                $MPN_UPC = str_replace("&", "and", $MPN_UPC);
            }
            //$MANUFACTURE = $row['MANUFACTURE'];
            $UPC = $row['UPC'];
            $MPN = $row['MPN'];
            $MPN = str_replace("&", "and", $MPN);
            if(!empty($UPC_MPN)){$query = $UPC_MPN;}elseif(!empty($MPN_UPC)){//$query = $MPN_UPC;
                
                $query = $MPN_UPC;
                //$query = $MANUFACTURE." ".$MPN_UPC;
                }else{$query = NULL;}

               //var_dump($query);

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
                    // echo "<pre>";
                    // print_r($response);
                    // echo "</pre>";
                     //var_dump($response);exit;
                    if ($response->Ack !== 'Failure' && $response->CategoryCount > 0) {
                        //var_dump($response->CategoryCount);
                       // echo "if responce called";
                        $cat = $response->SuggestedCategoryArray->SuggestedCategory->Category;
                        $categoryParentName1 = $cat->CategoryParentName[0];
                        $categoryParentName2 = $cat->CategoryParentName[1];
                        $categoryName = $cat->CategoryName;
                        $categoryID = $cat->CategoryID;
                        //var_dump($categoryParentName1,$categoryParentName2,$categoryName,$categoryID);
                        //exit;
                    }elseif($query == $UPC){
                        // var_dump($query);
                        // echo "elseif called";
                        // exit;
                        // $MPN = $row['MPN'];
                        // $MPN = trim(str_replace(" ", '+', $MPN));
                        // $MANUFACTURE = $row['MANUFACTURE'];
                        // $MANUFACTURE = trim(str_replace(" ", '+', $MANUFACTURE));
                        $query1 = $MPN;
                        //$query1 = $UPC;
                        $siteID = 0;
                        //the call being made:
                        $verb = 'GetSuggestedCategories';
                        ///Build the request Xml string
                        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                        $requestXmlBody .= '<GetSuggestedCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>$userToken</eBayAuthToken></RequesterCredentials>";
                        $requestXmlBody .= "<Query>$query1</Query>";
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


    // ======================= Get Categories End ==========================

    // =================== Get Price Script Start ==========================
             
                if($query !== NULL)
                {
                    //$keywords=urlencode($query);
                    $keywords=$query;
                    //  ============== Active Listing Price Start  =================
                    $cond = $item_condition;
                    $category = $categoryID;                
                    $NumPerPage = 10;       
                    $sortOrder = "&sortOrder=BestMatch"; //PricePlusShippingLowest
                    $condition = "&itemFilter(0).name=Condition";
                    $condition.="&itemFilter(0).value(0)=".$cond;
                    $buyingFormat = "&itemFilter(1).name=ListingType";
                    $buyingFormat.="&itemFilter(1).value(0)=FixedPrice";
                    // $FreeShippingOnly = "&itemFilter(2).name=FreeShippingOnly";
                    // $FreeShippingOnly.="&itemFilter(2).value(0)=true";

                    if(!empty($category)){
                        $categoryId="&categoryId=".$category;//.$categoryId;
                    }else{$categoryId="";}
                    // $SellerInfo = "&outputSelector(0)=SellerInfo";
                    // $PictureURLSuperSize = "&outputSelector(1)=PictureURLSuperSize";
                    // $StoreInfo = "&outputSelector(2)=StoreInfo";
                    $HideDuplicateItems="&HideDuplicateItems=true";
                    $MinQuantity="&MinQuantity=1";
                    $pageNumber = 1;

                    $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
                    $URL = $URL.$keywords."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber."&sortOrder=".$sortOrder.$MinQuantity.$HideDuplicateItems.$condition.$buyingFormat.$categoryId;

                    $XML = new SimpleXMLElement(file_get_contents($URL));
                    $count = $XML->paginationOutput->totalEntries;
                    if ($XML->ack !== 'Failure' && $count > 0) {
                          $a_price= $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
                    }elseif($query == $UPC){
                        // $MPN = $row['MPN'];
                        // $MPN = str_replace("&", "and", $MPN);
                        // $MANUFACTURE = $row['MANUFACTURE'];
                        // $MANUFACTURE = str_replace("&", "and", $MANUFACTURE);
                        $keywords = $MPN;
                        //$keywords = $UPC;
                        //$keywords=urlencode($keywords);
                            //  ============== Active Listing Price Start  =================
                        $cond = $item_condition;
                        $category = $categoryID;                
                        $NumPerPage = 10;       
                        $sortOrder = "&sortOrder=BestMatch";
                        $condition = "&itemFilter(0).name=Condition";
                        $condition.="&itemFilter(0).value(0)=".$cond;
                        $buyingFormat = "&itemFilter(1).name=ListingType";
                        $buyingFormat.="&itemFilter(1).value(0)=FixedPrice";
                        // $FreeShippingOnly = "&itemFilter(2).name=FreeShippingOnly";
                        // $FreeShippingOnly.="&itemFilter(2).value(0)=true";

                        if(!empty($category)){
                            $categoryId="&categoryId=".$category;//.$categoryId;
                        }else{$categoryId="";}
                        // $SellerInfo = "&outputSelector(0)=SellerInfo";
                        // $PictureURLSuperSize = "&outputSelector(1)=PictureURLSuperSize";
                        // $StoreInfo = "&outputSelector(2)=StoreInfo";
                        $HideDuplicateItems="&HideDuplicateItems=true";
                        $MinQuantity="&MinQuantity=1";
                        $pageNumber = 1;

                        $URL ="http://svcs.ebay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&OPERATION-NAME=findItemsAdvanced&GLOBAL-ID=EBAY-US&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&keywords=";
                        $URL = $URL.$keywords."&paginationInput.entriesPerPage=".$NumPerPage."&paginationInput.pageNumber=".$pageNumber."&sortOrder=".$sortOrder.$MinQuantity.$HideDuplicateItems.$condition.$buyingFormat.$categoryId;

                        $XML = new SimpleXMLElement(file_get_contents($URL));
                        $count = $XML->paginationOutput->totalEntries;
                        if ($XML->ack !== 'Failure' && $count > 0) {
                              $a_price= $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
                        
                        }else{
                            $a_price='';
                        }
                    }else{//nasted ifelse
                        $a_price='';
                    }

                }else{// main ifelse
                        $a_price='';
                    }
                //  ============== Active Listing Price End  =================

                //  ============== Sold Listing Price Start  =================
                    //$keywords=urlencode($query);
                    $keywords=$query;
                    $URL ="http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findCompletedItems&SERVICE-NAME=FindingService&SERVICE-VERSION=1.13.0&GLOBAL-ID=EBAY-US&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&RESPONSE-DATA-FORMAT=XML&keywords=$keywords&categoryId=$category&itemFilter(0).name=SoldItemsOnly&itemFilter(0).value=true&itemFilter(1).name=Condition&itemFilter(1).value=$cond&itemFilter(2).name=ListingType&itemFilter(2).value(0)=FixedPrice&sortOrder=EndTimeSoonest&paginationInput.entriesPerPage=1&paginationInput.pageNumber=1";

                    $XML = new SimpleXMLElement(file_get_contents($URL));
                    $count = $XML->paginationOutput->totalEntries;
                    if ($XML->Ack !== 'Failure' && $count > 0) {
                        $s_price= $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
                        //echo $price;
                    }elseif($query == $UPC){
                        // $MPN = $row['MPN'];
                        // $MPN = str_replace("&", "and", $MPN);
                        // $MANUFACTURE = $row['MANUFACTURE'];
                        // $MANUFACTURE = str_replace("&", "and", $MANUFACTURE);
                        $query1 = $MPN;
                       // $keywords=urlencode($query1);
                        // $query1 = $UPC;
                         $keywords=$query1;
                        $URL ="http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findCompletedItems&SERVICE-NAME=FindingService&SERVICE-VERSION=1.13.0&GLOBAL-ID=EBAY-US&SECURITY-APPNAME=yuliu2b3b-3e0b-4ee3-add6-9c96e89e823&RESPONSE-DATA-FORMAT=XML&keywords=$keywords&categoryId=$category&itemFilter(0).name=SoldItemsOnly&itemFilter(0).value=true&itemFilter(1).name=Condition&itemFilter(1).value=$cond&itemFilter(2).name=ListingType&itemFilter(2).value(0)=FixedPrice&sortOrder=EndTimeSoonest&paginationInput.entriesPerPage=1&paginationInput.pageNumber=1";

                        $XML = new SimpleXMLElement(file_get_contents($URL));
                        $count = $XML->paginationOutput->totalEntries;
                        if ($XML->Ack !== 'Failure' && $count > 0) {
                            $s_price= $XML->searchResult->item->sellingStatus->convertedCurrentPrice;
                            //echo $price;
                        }else{
                        $s_price='';
                        }
                    }else{//nasted elseif
                        $s_price='';
                    }

                //  ============== Sold Listing Price End  =================

                }else{// main ifelse
                    $a_price='';
                    $s_price='';
                }
               

    //======================== Get Price Script End ==========================


    // ============= Insertion of Categories and Price Start ================
                $MAIN_CATAGORY_SEG1= $categoryParentName1;
                $MAIN_CATAGORY_SEG1 = trim(str_replace("  ", ' ', $MAIN_CATAGORY_SEG1));
                $MAIN_CATAGORY_SEG1 = trim(str_replace(array("'"), "''", $MAIN_CATAGORY_SEG1));
                $SUB_CATAGORY_SEG2= $categoryParentName2;
                $SUB_CATAGORY_SEG2 = trim(str_replace("  ", ' ', $SUB_CATAGORY_SEG2));
                $SUB_CATAGORY_SEG2 = trim(str_replace(array("'"), "''", $SUB_CATAGORY_SEG2));
                $E_BAY_CATA_ID_SEG6= $categoryID;
                $BRAND_SEG3= $categoryName;
                $BRAND_SEG3 = trim(str_replace("  ", ' ', $BRAND_SEG3));
                $BRAND_SEG3 = trim(str_replace(array("'"), "''", $BRAND_SEG3));
                if(!empty(@$a_price)){
                    $A_PRICE= @$a_price;
                }else{
                $A_PRICE= 'NULL';
                }
                if(!empty(@$s_price)){
                    $S_PRICE= @$s_price;
                }else{
                $S_PRICE= 'NULL';
                }
                if(empty($UPC)){
                    $qry_det = "UPDATE LZ_MANIFEST_DET SET MAIN_CATAGORY_SEG1='$MAIN_CATAGORY_SEG1', SUB_CATAGORY_SEG2='$SUB_CATAGORY_SEG2', E_BAY_CATA_ID_SEG6='$E_BAY_CATA_ID_SEG6', PRICE=$A_PRICE,BRAND_SEG3 ='$BRAND_SEG3',S_PRICE=$S_PRICE, PO_DETAIL_RETIAL_PRICE=$A_PRICE WHERE LZ_MANIFEST_ID = $LZ_MANIFEST_ID AND ITEM_MT_UPC is null AND ITEM_MT_MFG_PART_NO = '$MPN'";
                }elseif(empty($MPN)){
                    $qry_det = "UPDATE LZ_MANIFEST_DET SET MAIN_CATAGORY_SEG1='$MAIN_CATAGORY_SEG1', SUB_CATAGORY_SEG2='$SUB_CATAGORY_SEG2', E_BAY_CATA_ID_SEG6='$E_BAY_CATA_ID_SEG6', PRICE=$A_PRICE,BRAND_SEG3 ='$BRAND_SEG3',S_PRICE=$S_PRICE, PO_DETAIL_RETIAL_PRICE=$A_PRICE WHERE LZ_MANIFEST_ID = $LZ_MANIFEST_ID AND ITEM_MT_UPC = '$UPC' AND ITEM_MT_MFG_PART_NO is null";
                }else{
                    $qry_det = "UPDATE LZ_MANIFEST_DET SET MAIN_CATAGORY_SEG1='$MAIN_CATAGORY_SEG1', SUB_CATAGORY_SEG2='$SUB_CATAGORY_SEG2', E_BAY_CATA_ID_SEG6='$E_BAY_CATA_ID_SEG6', PRICE=$A_PRICE,BRAND_SEG3 ='$BRAND_SEG3',S_PRICE=$S_PRICE, PO_DETAIL_RETIAL_PRICE=$A_PRICE WHERE LZ_MANIFEST_ID = $LZ_MANIFEST_ID AND ITEM_MT_UPC = '$UPC' AND ITEM_MT_MFG_PART_NO = '$MPN'";
                }
                // exit;
                 $result=$this->db->query($qry_det);
                 //print_r($qry_det);
            }//end foreach for price & category
            //exit;
            // ============= Insertion of Categories and Price END ================
        }//end main else
        return $LZ_MANIFEST_ID;

    }//end function
 
        function manf_detail($lz_manifest_id)
    {
        //======================== Seed Found in Manifest Start =============================//
        $seed_qty = "select count( distinct s.item_id) seed_qty from lz_item_seed s where s.item_id in (select distinct i.item_id from lz_manifest_det d, items_mt i where (d.item_mt_upc = i.item_mt_upc or (d.item_mt_mfg_part_no = i.item_mt_mfg_part_no and d.item_mt_manufacture = i.item_mt_manufacture) ) and d.lz_manifest_id = $lz_manifest_id)"; 
        $seed_qty =$this->db->query($seed_qty);
        $seed_qty = $seed_qty->result_array();
         
        //======================== Seed Found in Manifest Start =============================//
        //======================== Unique Item in Manifest Start =============================//
        $unique_entries = "SELECT count(LAPTOP_ZONE_ID) UNQ_COUNT from (SELECT * FROM LZ_MANIFEST_DET d WHERE d.LAPTOP_ZONE_ID IN (SELECT MAX(LAPTOP_ZONE_ID) FROM LZ_MANIFEST_DET det where lz_manifest_id = $lz_manifest_id GROUP BY det.item_mt_mfg_part_no, det.item_mt_upc) and d.lz_manifest_id = $lz_manifest_id)"; 
        $unique_entries =$this->db->query($unique_entries);
        $unique_entries = $unique_entries->result_array();
         
        //======================== Unique Item in Manifest Start =============================//

        //======================== Unique Item in Manifest Start =============================//
        $unique_item = "SELECT * FROM LZ_MANIFEST_DET d WHERE d.LAPTOP_ZONE_ID IN (SELECT MAX(LAPTOP_ZONE_ID) FROM LZ_MANIFEST_DET det where lz_manifest_id = $lz_manifest_id GROUP BY det.item_mt_mfg_part_no, det.item_mt_upc) and d.lz_manifest_id = $lz_manifest_id  order by d.item_mt_mfg_part_no,d.item_mt_upc"; 
        $unique_item =$this->db->query($unique_item);
        $unique_item = $unique_item->result_array();
         
        //======================== Unique Item in Manifest Start =============================//
        
        //======================== Unique Item in Manifest Start =============================//
        $sum_qty = "SELECT d.item_mt_mfg_part_no MPN,d.item_mt_upc UPC, sum(d.available_qty) sum_qty FROM LZ_MANIFEST_DET d WHERE d.lz_manifest_id = $lz_manifest_id group by d.item_mt_mfg_part_no,d.item_mt_upc order by d.item_mt_mfg_part_no,d.item_mt_upc"; 
        $sum_qty =$this->db->query($sum_qty);
        $sum_qty = $sum_qty->result_array();
         
        //======================== Unique Item in Manifest Start =============================//
        
        //  ====================== Total Entries Inserted  Start =============================//
        $total_entries = "select t.total_excel_rows , t.manifest_name, t.loading_no from LZ_MANIFEST_MT t where t.lz_manifest_id=$lz_manifest_id";
        $total_entries =$this->db->query($total_entries);
        $total_entries = $total_entries->result_array();
        //  ====================== Total Entries Inserted End =============================//
         //  ========================== Entries Inserted Start =================================//
        $entries_qry = "select count(*) inserted_rows from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id";
        $entries_qry =$this->db->query($entries_qry);
        $entries_qry = $entries_qry->result_array();
        //  ========================== Entries Inserted END =================================//
         //  ========================== categories inserted Start =================================//
        // $cat_inserted = "select count(*) ins_cat from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.e_bay_cata_id_seg6 is not null";
        // $cat_inserted =$this->db->query($cat_inserted);
        // $cat_inserted = $cat_inserted->result_array();
        //  ========================== categories Inserted END ==============================//  
         //  ========================== categories not inserted Start =================================//
        // $cat_not_ins= "select count(*) cat_not_ins from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.e_bay_cata_id_seg6 is null";
        // $cat_not_ins =$this->db->query($cat_not_ins);
        // $cat_not_ins = $cat_not_ins->result_array();
        //  ========================== categories not Inserted END ===========================// 
            
        //  ========================== Active price inserted Start =================================//
        $a_ins_price= "select count(*) a_ins_price from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.price is not null";
        $a_ins_price =$this->db->query($a_ins_price);
        $a_ins_price = $a_ins_price->result_array();
        //  ========================== Active price inserted  END ===========================//  
        //  ========================= Active price not inserted Start =======================//
        $a_not_ins_price= "select count(*) a_not_ins_price from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.price is null";
        $a_not_ins_price =$this->db->query($a_not_ins_price);
        $a_not_ins_price = $a_not_ins_price->result_array();
        //  ========================== Active price not inserted  END ===========================//  

        //  ========================== Sold price inserted Start =================================//
        $s_ins_price= "select count(*) s_ins_price from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.s_price is not null";
        $s_ins_price =$this->db->query($s_ins_price);
        $s_ins_price = $s_ins_price->result_array();
        //  ========================== Sold price inserted  END ===========================//  
        //  ========================= Sold price not inserted Start =======================//
        $s_not_ins_price= "select count(*) s_not_ins_price from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.s_price is null";
        $s_not_ins_price =$this->db->query($s_not_ins_price);
        $s_not_ins_price = $s_not_ins_price->result_array();
        //  ========================== Sold price not inserted  END ===========================//  
        //  ========================== Manifest Value query Start ===================================//
        $manf_value = "select sum(t.v_price) Manf_cost, sum(t.price) Active_val,sum(t.s_price) Sold_Val, sum(t.PO_DETAIL_RETIAL_PRICE) MAN_Val, sum(t.SHIP_FEE) ship_fee from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id";
        $manf_value =$this->db->query($manf_value);
        $manf_value = $manf_value->result_array();
        //  ========================== Manifest Value query END ===================================//
        //  ========================== Manifest Data query END ===================================//
        $detail = "select t.* from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id";
        $detail =$this->db->query($detail);
        $detail = $detail->result_array();
        //  ========================== Manifest Data query END ===================================//

        //======================== Manifest Auction fields Start =============================//

        $auction_qry = "select m.loading_no, TO_CHAR(m.loading_date, 'MM/DD/YYYY') as loading_date, m.purch_ref_no, m.supplier_id, m.remarks, m.doc_seq_id, TO_CHAR(m.purchase_date, 'MM/DD/YYYY') as purchase_date, m.posted, m.excel_file_name, m.grn_id, m.purchase_invoice_id, m.single_entry_id, m.total_excel_rows, m.manifest_name, m.manifest_status, m.sold_price, TO_CHAR(m.end_date, 'MM/DD/YYYY HH24:MI:SS') as end_date, m.lz_offer from lz_manifest_mt m where m.lz_manifest_id = $lz_manifest_id"; 
        $auction_qry =$this->db->query($auction_qry);
        $auction_qry = $auction_qry->result_array();
         
        //======================== Manifest Auction fields End =============================//

        //======================== Print Sticker tab Start =============================//

        //$print_qry = "select t.* from LZ_MANIFEST_DET t where t.lz_manifest_id=$lz_manifest_id and t.STICKER_PRINT = 0";
        $print_qry = "select b.PO_DETAIL_LOT_REF, b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and b.lz_manifest_id = $lz_manifest_id and b.print_status = 0 order by b.item_id, b.unit_no"; 
        $print_qry =$this->db->query($print_qry);
        $print_qry = $print_qry->result_array();
         
        //======================== Print Sticker tab End =============================//

        //======================== Re-Print sticker tab Start =============================//

        $re_print_qry = "select b.PO_DETAIL_LOT_REF, b.unit_no, b.barcode_no it_barcode, b.print_status, v.ITEM_CONDITION, v.ITEM_MT_DESC, v.MANUFACTURER, v.MFG_PART_NO, v.UPC, v.AVAIL_QTY, v.ITEM_ID, v.LZ_MANIFEST_ID, v.PURCH_REF_NO, v.laptop_item_code from lz_barcode_mt b, (SELECT im.item_desc ITEM_MT_DESC, im.item_mt_manufacture MANUFACTURER, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC UPC, im.ITEM_MT_MFG_PART_NO MFG_PART_NO, im.item_condition, ld.laptop_item_code, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lm.purchase_date, IM.ITEM_ID, LM.LOADING_NO, LM.LOADING_DATE, sum(LD.PO_DETAIL_RETIAL_PRICE * NVL(LD.AVAILABLE_QTY, 0)) PO_DETAIL_RETIAL_PRICE, SUM(NVL(LD.AVAILABLE_QTY, 0)) AVAIL_QTY, IM.Item_Code FROM LZ_MANIFEST_MT LM, LZ_MANIFEST_DET LD, ITEMS_MT IM WHERE LM.LZ_MANIFEST_ID = LD.LZ_MANIFEST_ID AND IM.ITEM_CODE = LD.LAPTOP_ITEM_CODE GROUP BY im.item_desc, im.item_mt_manufacture, ld.laptop_item_code, IM.ITEM_ID, LM.LZ_MANIFEST_ID, LM.PURCH_REF_NO, lM.purchase_date, LM.LOADING_NO, LM.LOADING_DATE, im.ITEM_MT_BBY_SKU, im.ITEM_MT_UPC, im.ITEM_MT_MFG_PART_NO, im.item_condition, IM.Item_Code ) v where b.item_id = v.item_id and b.lz_manifest_id = v.LZ_MANIFEST_ID and b.lz_manifest_id = $lz_manifest_id and b.print_status = 1 order by b.item_id, b.unit_no"; 
        $re_print_qry =$this->db->query($re_print_qry);
        $re_print_qry = $re_print_qry->result_array();
         
        //================ Re-Print sticker tab End =======================//                    

        return array('sum_qty'=>$sum_qty,'seed_qty'=>$seed_qty,'unique_item'=>$unique_item,'unique_entries'=>$unique_entries,'total_entries'=>$total_entries,'entries_qry'=>$entries_qry,'a_ins_price' => $a_ins_price,'a_not_ins_price' => $a_not_ins_price,'s_ins_price' => $s_ins_price,'s_not_ins_price' => $s_not_ins_price,'manf_value' => $manf_value, 'detail' => $detail, 'auction_qry' => $auction_qry, 'print_qry' => $print_qry, 're_print_qry'=>$re_print_qry);

    }
    function list_manf()
    {
        $login_id = $this->session->userdata('user_id'); 
        if($login_id == 2 || $login_id == 17){
        $qry_mt = "select t.* from LZ_MANIFEST_MT t where t.loading_date > TO_DATE('10/30/2016', 'mm/dd/yyyy') and t.excel_file_name<>'FORM ENTRY' ORDER BY t.lz_manifest_id DESC";
        }else{
        $qry_mt = "select t.* from LZ_MANIFEST_MT t where t.loading_date > TO_DATE('10/30/2016', 'mm/dd/yyyy') and t.excel_file_name <> 'FORM ENTRY'and t.grn_id is not null ORDER BY t.lz_manifest_id DESC";
        }

        $qry_mt = $this->db->query($qry_mt);
        $list =$qry_mt->result_array();
        $man_price = array();
        $auc_det = array();
        foreach($list as $lz){
        $qry_mt = "select sum(PO_DETAIL_RETIAL_PRICE) man_price from lz_manifest_det d where d.lz_manifest_id =".$lz['LZ_MANIFEST_ID']." ORDER BY d.lz_manifest_id DESC";
        
        $qry_mt = $this->db->query($qry_mt);
        $r1 =$qry_mt->result_array();
        $man_price = array_merge($man_price,$r1);
        //======================== Manifest Auction fields Start =============================//
        $auc_data = "select LZ_MANIFEST_ID,MANIFEST_STATUS,SOLD_PRICE,LZ_OFFER,TO_CHAR(END_DATE, 'DD-MM-YYYY HH24:MI AM') as END_DATE  from lz_manifest_mt where lz_manifest_id =".$lz['LZ_MANIFEST_ID']." ORDER BY lz_manifest_id DESC";
        
        $auc_data = $this->db->query($auc_data);
        $r2 =$auc_data->result_array();
        $auc_det = array_merge($auc_det,$r2);
        //======================== Manifest Auction fields End =============================//
            
        }
        return array('list'=>$list,'man_price'=>$man_price,'auc_det'=>$auc_det);
        
    }
    function manf_post($lz_manifest_id,$action)
    {
        if($action=='unpost'){
            $unpost = "call Pro_Unpost_Manifest($lz_manifest_id)";
            $unpost = $this->db->query($unpost);
            echo "Manifest Unpost Succsessfully";
            $del_seed = "delete from lz_item_seed s where s.lz_manifest_id = $lz_manifest_id ";
            $this->db->query($del_seed);

        }elseif($action=='post'){
                $post = "call Pro_Laptop_Zone($lz_manifest_id)";
                $qry_mt = $this->db->query($post);

                if(!empty($qry_mt)){
                    $qry_mt = "UPDATE LZ_MANIFEST_MT SET POSTED = 'Posted' WHERE LZ_MANIFEST_ID =  $lz_manifest_id ";
                    $qry_mt = $this->db->query($qry_mt);
                }
            }
           //          if($qry_mt)
           //          {
           //              $seed = "select distinct t.item_id, t.item_mt_mfg_part_no, t.item_mt_upc, dt.item_mt_desc, dt.conditions_seg5, dt.e_bay_cata_id_seg6, dt.BRAND_SEG3, dt.sum_qty, dt.price, dt.lz_manifest_id from items_mt t, (SELECT d.item_mt_mfg_part_no, d.item_mt_upc, d.item_mt_desc, d.conditions_seg5, d.e_bay_cata_id_seg6, d.BRAND_SEG3, d.available_qty, d.price, d.lz_manifest_id, d.laptop_item_code, sum(d.available_qty) sum_qty FROM LZ_MANIFEST_DET d WHERE d.lz_manifest_id = $lz_manifest_id group by  d.item_mt_mfg_part_no, d.item_mt_upc, d.item_mt_desc, d.conditions_seg5, d.e_bay_cata_id_seg6, d.BRAND_SEG3, d.available_qty, d.price, d.lz_manifest_id, d.laptop_item_code order by d.item_mt_mfg_part_no, d.item_mt_upc) dt where t.item_code = dt.laptop_item_code and dt.lz_manifest_id = $lz_manifest_id";
           //              $qry_seed = $this->db->query($seed);
           //              foreach($qry_seed->result_array() as $data)
           //              {
           //                  $ITEM_ID = $data['ITEM_ID'];
           //                  $ITEM_TITLE = $data['ITEM_MT_DESC'];
           //                  $ITEM_TITLE = trim(str_replace("  ", ' ', $ITEM_TITLE));
           //                  $ITEM_TITLE = trim(str_replace(array("'"), "''", $ITEM_TITLE));
           //                  //$ITEM_DESC = $ITEM_TITLE;
           //                  $ITEM_MT_MFG_PART_NO = $data['ITEM_MT_MFG_PART_NO'];
           //                  $ITEM_MT_MFG_PART_NO = trim(str_replace(" ", '', $ITEM_MT_MFG_PART_NO));
           //                  $ITEM_MT_MFG_PART_NO = trim(str_replace(array("'"), "''", $ITEM_MT_MFG_PART_NO));
           //                  $ITEM_MT_UPC = $data['ITEM_MT_UPC'];
           //                  $ITEM_MT_UPC = trim(str_replace(" ", '', $ITEM_MT_UPC));
           //                  $ITEM_MT_UPC = trim(str_replace(array("'"), "", $ITEM_MT_UPC));
           //                  if(!empty($data['PRICE'])){
           //                      $EBAY_PRICE = $data['PRICE'];
           //                  }else{
           //                      $EBAY_PRICE = 'NULL';
           //                  }
           //                  if($data['E_BAY_CATA_ID_SEG6'] == 'N/A'){
           //                      $CATEGORY_ID = 'NULL';
           //                  }else{
           //                      $CATEGORY_ID = $data['E_BAY_CATA_ID_SEG6'];
           //                  }
           //                  if(!empty($data['CONDITIONS_SEG5'])){
           //                      if(!is_numeric($data['CONDITIONS_SEG5'])){
           //                          $qry_cond = "select c.cond_description from LZ_ITEM_COND_MT c where c.cond_name ='".ucfirst($data['CONDITIONS_SEG5'])."'";
           //                          $qry_cond = $this->db->query($qry_cond);
           //                          $result=$qry_cond->result_array();
           //                          $DEFAULT_COND = $data['CONDITIONS_SEG5'];
           //                          $DETAIL_COND = @$result[0]['COND_DESCRIPTION'];
           //                          // echo "numeric";
           //                          // var_dump($DEFAULT_COND,$DETAIL_COND);
           //                      }else{
           //                          $DEFAULT_COND = 'Used'; // $data['CONDITIONS_SEG5'];
           //                          $DETAIL_COND = 'Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                          //echo "text";
           //                          //var_dump($DEFAULT_COND,$DETAIL_COND);
           //                      }
           //                  }else{
           //                          $DEFAULT_COND = 'Used'; // $data['CONDITIONS_SEG5'];
           //                          $DETAIL_COND = 'Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                  }
           //                   //exit;
           //                      // if(ucfirst($data['CONDITIONS_SEG5']) == 'Used'){
           //                      //  $DEFAULT_COND = 3000; // $data['CONDITIONS_SEG5'];
           //                      //  $DETAIL_COND = 'Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                      // }elseif(ucfirst($data['CONDITIONS_SEG5']) == 'New'){
                                    
           //                      //  $DEFAULT_COND = 1000; // $data['CONDITIONS_SEG5'];
           //                      //  $DETAIL_COND = 'Item is new and unused. Item comes in sealed original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                      // }elseif(ucfirst($data['CONDITIONS_SEG5']) == 'New other'){
           //                      //  $DEFAULT_COND = 1500; // $data['CONDITIONS_SEG5'];
           //                      //  $DETAIL_COND = 'Open box item. Item is new and unused. Comes in original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                      // }elseif(ucfirst($data['CONDITIONS_SEG5']) == 'Manufacturer refurbished'){
           //                      //  $DEFAULT_COND = 2000; // $data['CONDITIONS_SEG5'];
           //                      //  $DETAIL_COND = '';
           //                      // }elseif(ucfirst($data['CONDITIONS_SEG5']) == 'Seller refurbished'){
           //                      //  $DEFAULT_COND = 2500; // $data['CONDITIONS_SEG5'];
           //                      //  $DETAIL_COND = 'Item is new and unused. Item comes in sealed original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                      // }elseif(ucfirst($data['CONDITIONS_SEG5']) == 'For parts or not working'){
           //                      //  $DEFAULT_COND = 7000; // $data['CONDITIONS_SEG5'];
           //                      //  $DETAIL_COND = "Item is being sold for parts not working. Item has scuffs, scratches and signs of wear. Look at pictures for details. Item is ''AS IS'' and No returns will be accepted on this item.";
           //                      // }else{
           //                      //     $DEFAULT_COND = 3000; // $data['CONDITIONS_SEG5'];
           //                      //     $DETAIL_COND = 'Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                      // }
                            
           //                  $ITEM_DESC = '<p style="text-align: center;"> <span style="font-size:32px;color:#002060"><span style="text-decoration:underline;"><strong>'.$ITEM_TITLE.'</strong></span></span> </p> <p style="text-align: center;"> <span style="color: rgb(0, 0, 0); font-size: 24px;">This listing is for a '.$ITEM_TITLE . '&nbsp;'.$DETAIL_COND.'&nbsp;</span><br/> </p>';

           //                  $QUANTITY = $data['SUM_QTY'];
           //                  $LZ_MANIFEST_ID = $data['LZ_MANIFEST_ID'];
           //                  $CATEGORY_NAME = $data['BRAND_SEG3'];
           //                  $CATEGORY_NAME = trim(str_replace("  ", ' ', $CATEGORY_NAME));
           //                  $CATEGORY_NAME = trim(str_replace(array("'"), "''", $CATEGORY_NAME));
           //                  $ENTERED_BY = 'NULL';

           //                  // =========== Inserted By Template  ===========
           //                  $TEMPLATE_ID = 'NULL';
           //                  $EBAY_LOCAL = 'NULL';
           //                  $CURRENCY = 'NULL';
           //                  $LIST_TYPE = 'NULL';                    
           //                  $SHIP_FROM_ZIP_CODE = 'NULL';
           //                  $SHIP_FROM_LOC = 'NULL';
           //                  $BID_LENGTH = 'NULL';                    
           //                  $PAYMENT_METHOD = 'NULL';
           //                  $PAYPAL_EMAIL = 'NULL';
           //                  $DISPATCH_TIME_MAX = 'NULL';
           //                  $SHIPPING_COST = 'NULL';
           //                  $ADDITIONAL_COST = 'NULL';
           //                  $RETURN_OPTION = 'NULL';
           //                  $RETURN_DAYS = 'NULL';
           //                  $SHIPPING_PAID_BY = 'NULL';
           //                  $SHIPPING_SERVICE = 'NULL';                    
           //                  // =========== Inserted By Template  ===========

           //                  $item_seed_desc = "SELECT s.* FROM LZ_ITEM_SEED S,items_mt t WHERE t.item_mt_upc = '$ITEM_MT_UPC'AND t.item_id = s.item_id ORDER BY S.LZ_MANIFEST_ID DESC"; 
           //                  $qry_desc = $this->db->query($item_seed_desc);
           //                  $result=$qry_desc->result_array();
           //                  if(!empty($result)){
           //                      if(!empty(@$result[0]['ITEM_TITLE'])){
           //                          $ITEM_TITLE = @$result[0]['ITEM_TITLE'];
           //                          $ITEM_TITLE = trim(str_replace("  ", ' ', $ITEM_TITLE));
           //                          $ITEM_TITLE = trim(str_replace(array("'"), "''", $ITEM_TITLE));
           //                      }
           //                      // if(!empty(@$result[0]['ITEM_DESC'])){
           //                      //     $ITEM_DESC = @$result[0]['ITEM_DESC'];
           //                      //     $ITEM_DESC = trim(str_replace("  ", ' ', $ITEM_DESC));
           //                      //     $ITEM_DESC = trim(str_replace(array("'"), "''", $ITEM_DESC));
           //                      // }
           //                      // if(!empty(@$result[0]['CATEGORY_ID'])){
           //                      //     $CATEGORY_ID = @$result[0]['CATEGORY_ID'];
           //                      // }
           //                      // if(!empty(@$result[0]['CATEGORY_NAME'])){
           //                      //     $CATEGORY_NAME = @$result[0]['CATEGORY_NAME'];
           //                      //     $CATEGORY_NAME = trim(str_replace("  ", ' ', $CATEGORY_NAME));
           //                      //     $CATEGORY_NAME = trim(str_replace(array("'"), "''", $CATEGORY_NAME));
           //                      // }
           //                      if(!empty(@$result[0]['TEMPLATE_ID'])){
           //                          $TEMPLATE_ID = @$result[0]['TEMPLATE_ID'];
           //                      }
           //                      if(!empty(@$result[0]['EBAY_LOCAL'])){
           //                          $EBAY_LOCAL = @$result[0]['EBAY_LOCAL'];
           //                      }
           //                      if(!empty(@$result[0]['CURRENCY'])){
           //                          $CURRENCY ="'".@$result[0]['CURRENCY']."'";
           //                      }
           //                      if(!empty(@$result[0]['LIST_TYPE'])){
           //                          $LIST_TYPE = "'".@$result[0]['LIST_TYPE']."'";
           //                      }    
           //                      if(!empty(@$result[0]['SHIP_FROM_ZIP_CODE'])){                
           //                          $SHIP_FROM_ZIP_CODE = @$result[0]['SHIP_FROM_ZIP_CODE'];
           //                      }
           //                      if(!empty(@$result[0]['SHIP_FROM_LOC'])){
           //                          $SHIP_FROM_LOC = "'".@$result[0]['SHIP_FROM_LOC']."'";
           //                      }
           //                      if(!empty(@$result[0]['BID_LENGTH'])){
           //                          $BID_LENGTH = "'".@$result[0]['BID_LENGTH']."'";
           //                      }  
           //                      if(!empty(@$result[0]['PAYMENT_METHOD'])){                  
           //                          $PAYMENT_METHOD = "'".@$result[0]['PAYMENT_METHOD']."'";
           //                      }
           //                      if(!empty(@$result[0]['PAYPAL_EMAIL'])){ 
           //                          $PAYPAL_EMAIL = "'".@$result[0]['PAYPAL_EMAIL']."'";
           //                      }
           //                      if(!empty(@$result[0]['DISPATCH_TIME_MAX'])){
           //                          $DISPATCH_TIME_MAX = @$result[0]['DISPATCH_TIME_MAX'];
           //                      }
           //                      if(!empty(@$result[0]['SHIPPING_COST'])){
           //                          $SHIPPING_COST = @$result[0]['SHIPPING_COST'];
           //                      }
           //                      if(!empty(@$result[0]['ADDITIONAL_COST'])){
           //                          $ADDITIONAL_COST = @$result[0]['ADDITIONAL_COST'];
           //                      }
           //                      if(!empty(@$result[0]['RETURN_OPTION'])){
           //                          $RETURN_OPTION = "'".@$result[0]['RETURN_OPTION']."'";
           //                      }
           //                      if(!empty(@$result[0]['RETURN_DAYS'])){
           //                          $RETURN_DAYS = "'".@$result[0]['RETURN_DAYS']."'";
           //                      }
           //                      if(!empty(@$result[0]['SHIPPING_PAID_BY'])){
           //                          $SHIPPING_PAID_BY = "'".@$result[0]['SHIPPING_PAID_BY']."'";
           //                      }
           //                      if(!empty(@$result[0]['SHIPPING_SERVICE'])){
           //                          $SHIPPING_SERVICE = "'".@$result[0]['SHIPPING_SERVICE']."'"; 
           //                          $SHIPPING_SERVICE = trim(str_replace("  ", ' ', $SHIPPING_SERVICE));
           //                      }
           //                  }else{
           //                          $item_seed_desc = "SELECT s.* FROM LZ_ITEM_SEED S,items_mt t WHERE t.ITEM_MT_MFG_PART_NO = '$ITEM_MT_MFG_PART_NO'AND t.item_id = s.item_id ORDER BY S.LZ_MANIFEST_ID DESC"; 
           //                          $qry_desc = $this->db->query($item_seed_desc);
           //                          $rslt=$qry_desc->result_array();
           //                          if(!empty($rslt)){
           //                                  if(!empty(@$result[0]['ITEM_TITLE'])){
           //                                  $ITEM_TITLE = @$result[0]['ITEM_TITLE'];
           //                                  $ITEM_TITLE = trim(str_replace("  ", ' ', $ITEM_TITLE));
           //                                  $ITEM_TITLE = trim(str_replace(array("'"), "''", $ITEM_TITLE));
           //                                  }
           //                                  // if(!empty(@$result[0]['ITEM_DESC'])){
           //                                  //     $ITEM_DESC = @$result[0]['ITEM_DESC'];
           //                                  //     $ITEM_DESC = trim(str_replace("  ", ' ', $ITEM_DESC));
           //                                  //     $ITEM_DESC = trim(str_replace(array("'"), "''", $ITEM_DESC));
           //                                  // }
           //                                  // if(!empty(@$result[0]['CATEGORY_ID'])){
           //                                  //     $CATEGORY_ID = @$result[0]['CATEGORY_ID'];
           //                                  // }
           //                                  // if(!empty(@$result[0]['CATEGORY_NAME'])){
           //                                  //     $CATEGORY_NAME = @$result[0]['CATEGORY_NAME'];
           //                                  //     $CATEGORY_NAME = trim(str_replace("  ", ' ', $CATEGORY_NAME));
           //                                  //     $CATEGORY_NAME = trim(str_replace(array("'"), "''", $CATEGORY_NAME));
           //                                  // }
           //                                  if(!empty(@$result[0]['TEMPLATE_ID'])){
           //                                      $TEMPLATE_ID = @$result[0]['TEMPLATE_ID'];
           //                                  }
           //                                  if(!empty(@$result[0]['EBAY_LOCAL'])){
           //                                      $EBAY_LOCAL = @$result[0]['EBAY_LOCAL'];
           //                                  }
           //                                  if(!empty(@$result[0]['CURRENCY'])){
           //                                      $CURRENCY ="'".@$result[0]['CURRENCY']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['LIST_TYPE'])){
           //                                      $LIST_TYPE = "'".@$result[0]['LIST_TYPE']."'";
           //                                  }    
           //                                  if(!empty(@$result[0]['SHIP_FROM_ZIP_CODE'])){                
           //                                      $SHIP_FROM_ZIP_CODE = @$result[0]['SHIP_FROM_ZIP_CODE'];
           //                                  }
           //                                  if(!empty(@$result[0]['SHIP_FROM_LOC'])){
           //                                      $SHIP_FROM_LOC = "'".@$result[0]['SHIP_FROM_LOC']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['BID_LENGTH'])){
           //                                      $BID_LENGTH = "'".@$result[0]['BID_LENGTH']."'";
           //                                  }  
           //                                  if(!empty(@$result[0]['PAYMENT_METHOD'])){                  
           //                                      $PAYMENT_METHOD = "'".@$result[0]['PAYMENT_METHOD']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['PAYPAL_EMAIL'])){ 
           //                                      $PAYPAL_EMAIL = "'".@$result[0]['PAYPAL_EMAIL']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['DISPATCH_TIME_MAX'])){
           //                                      $DISPATCH_TIME_MAX = @$result[0]['DISPATCH_TIME_MAX'];
           //                                  }
           //                                  if(!empty(@$result[0]['SHIPPING_COST'])){
           //                                      $SHIPPING_COST = @$result[0]['SHIPPING_COST'];
           //                                  }
           //                                  if(!empty(@$result[0]['ADDITIONAL_COST'])){
           //                                      $ADDITIONAL_COST = @$result[0]['ADDITIONAL_COST'];
           //                                  }
           //                                  if(!empty(@$result[0]['RETURN_OPTION'])){
           //                                      $RETURN_OPTION = "'".@$result[0]['RETURN_OPTION']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['RETURN_DAYS'])){
           //                                      $RETURN_DAYS = "'".@$result[0]['RETURN_DAYS']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['SHIPPING_PAID_BY'])){
           //                                      $SHIPPING_PAID_BY = "'".@$result[0]['SHIPPING_PAID_BY']."'";
           //                                  }
           //                                  if(!empty(@$result[0]['SHIPPING_SERVICE'])){
           //                                      $SHIPPING_SERVICE = "'".@$result[0]['SHIPPING_SERVICE']."'"; 
           //                                      $SHIPPING_SERVICE = trim(str_replace("  ", ' ', $SHIPPING_SERVICE));
           //                                  }
           //                          }//main if ended inside else
           //                      }//else ended
                          
           //                  $comma = ',';  

           //                  $check = "select s.item_id from lz_item_seed s where s.item_id = $ITEM_ID and s.LZ_MANIFEST_ID=$lz_manifest_id";
           //                  $qry_check = $this->db->query($check);
           //                  $result=$qry_check->result_array();
           //                  if(empty($result)){
           //                      if(ucfirst($DEFAULT_COND) == 'Used'){
           //                       $DEFAULT_COND = 3000; // $data['CONDITIONS_SEG5'];
                                 
           //                      }elseif(ucfirst($DEFAULT_COND) == 'New'){
                                    
           //                       $DEFAULT_COND = 1000; // $data['CONDITIONS_SEG5'];
                                 
           //                      }elseif(ucfirst($DEFAULT_COND) == 'New other'){
           //                       $DEFAULT_COND = 1500; // $data['CONDITIONS_SEG5'];
                                
           //                      }elseif(ucfirst($DEFAULT_COND) == 'Manufacturer refurbished'){
           //                       $DEFAULT_COND = 2000; // $data['CONDITIONS_SEG5'];
           //                       $DETAIL_COND = '';
           //                      }elseif(ucfirst($DEFAULT_COND) == 'Seller refurbished'){
           //                       $DEFAULT_COND = 2500; // $data['CONDITIONS_SEG5'];
                                 
           //                      }elseif(ucfirst($DEFAULT_COND) == 'For parts or not working'){
           //                       $DEFAULT_COND = 7000; // $data['CONDITIONS_SEG5'];
                                 
           //                      }else{
           //                          $DEFAULT_COND = 3000; // $data['CONDITIONS_SEG5'];
           //                          $DETAIL_COND = 'Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.';
           //                      }
           //                  $seed = "INSERT INTO LZ_ITEM_SEED VALUES($ITEM_ID $comma '$ITEM_TITLE' $comma $EBAY_PRICE $comma $TEMPLATE_ID $comma $EBAY_LOCAL $comma $CURRENCY $comma $LIST_TYPE $comma $CATEGORY_ID $comma $SHIP_FROM_ZIP_CODE $comma $SHIP_FROM_LOC $comma $BID_LENGTH $comma $DEFAULT_COND $comma '$DETAIL_COND' $comma $PAYMENT_METHOD $comma $PAYPAL_EMAIL $comma $DISPATCH_TIME_MAX $comma $SHIPPING_COST $comma $ADDITIONAL_COST $comma $RETURN_OPTION $comma $RETURN_DAYS $comma $SHIPPING_PAID_BY $comma $SHIPPING_SERVICE $comma $QUANTITY $comma $LZ_MANIFEST_ID $comma '$CATEGORY_NAME' $comma '$ITEM_DESC' $comma $ENTERED_BY)";
           //                  $qry_seed = $this->db->query($seed);
           //                  }
                  
           //              }// main foreach end
                        
           //              if($qry_seed){
           //                      echo "Manifest Posted & seed created Succsessfully.";
           //                  }else{
           //                      echo "Manifest Posted But seed not created.";
           //                  }
           //          }else{
           //              echo "Manifest Posted But Post button status not updated";
           //          }//sub main else if 
           //      }else{
           //               echo "Manifest Not Posted";
           //          }//main else if end   
           // }else{
           //      echo "Error-While processing your Request";
           // }// Action if else end
           
            
    }
    function r_price($lz_id,$manifest_id,$r_price,$MPN,$UPC,$ship_fee)
    {
        if(empty($r_price)){$r_price=0;}
        if(empty($ship_fee)){$ship_fee=3.25;}
        if($UPC == "NULL" && $MPN == "NULL")//only one record updated in this case
        {
            $qry_mt = "UPDATE LZ_MANIFEST_DET SET PO_DETAIL_RETIAL_PRICE = $r_price, SHIP_FEE = $ship_fee, MANUAL_UPDATE = '1' WHERE LAPTOP_ZONE_ID = $lz_id";
        }elseif($UPC == "NULL" && $MPN != "NULL" ){
            $qry_mt = "UPDATE LZ_MANIFEST_DET SET PO_DETAIL_RETIAL_PRICE = $r_price, SHIP_FEE = $ship_fee, MANUAL_UPDATE = '1' WHERE ITEM_MT_MFG_PART_NO = '$MPN' AND ITEM_MT_UPC is NULL AND LZ_MANIFEST_ID =$manifest_id";
        }elseif($UPC != "NULL" && $MPN == "NULL" ){
            $qry_mt = "UPDATE LZ_MANIFEST_DET SET PO_DETAIL_RETIAL_PRICE = $r_price, SHIP_FEE = $ship_fee, MANUAL_UPDATE = '1' WHERE ITEM_MT_MFG_PART_NO is NULL AND ITEM_MT_UPC = '$UPC' AND LZ_MANIFEST_ID =$manifest_id";
        }else{
        $qry_mt = "UPDATE LZ_MANIFEST_DET SET PO_DETAIL_RETIAL_PRICE = $r_price, SHIP_FEE = $ship_fee, MANUAL_UPDATE = '1' WHERE ITEM_MT_MFG_PART_NO = '$MPN' AND ITEM_MT_UPC = '$UPC' AND LZ_MANIFEST_ID =$manifest_id";
        }
//print_r($qry_mt);exit;
        $qry_mt = $this->db->query($qry_mt);
        // if($qry_mt)
        // {
        //     echo "Price Updated";

        // }else{
        //      echo "Error - Price Not Updated";
        // }
        //echo $qry_mt;
        //return true;
    }
  public function purchase_ref_no($purch_ref){
    $query = $this->db->query("SELECT * FROM LZ_MANIFEST_MT WHERE PURCH_REF_NO = '$purch_ref'");
    //var_dump($query->num_rows());exit;
    if($query->num_rows() == 0){
        echo false;
    }else{
        echo true;
    }

  }
  public function auc_detail($lz_manifest_id,$manifest_status,$sold_price,$manifestendate,$purchase_date,$lz_offer){
    if(empty($sold_price))
    {
        $sold_price="''";
    }
    if(empty($manifestendate))
    {
        $manifestendate="''";
    }
    if(empty($purchase_date))
    {
        $purchase_date="''";
    }else{
        $manifest_status = 'sold';
    }
    if(empty($lz_offer))
    {
        $lz_offer="''";
    }
    $query = $this->db->query("UPDATE LZ_MANIFEST_MT SET MANIFEST_STATUS = '$manifest_status', SOLD_PRICE = $sold_price,END_DATE = $manifestendate, PURCHASE_DATE = $purchase_date, LZ_OFFER = $lz_offer WHERE LZ_MANIFEST_ID =  $lz_manifest_id");
    //var_dump($query->num_rows());exit;
    // if($query->num_rows() == 0){
    //     echo false;
    // }else{
    //     echo true;
    // }

  }
  public function manifest_sticker_print($item_code,$manifest_id,$barcode){
    //$print_qry = $this->db->query("SELECT D.LAPTOP_ITEM_CODE || '+' || LPAD(T.LOADING_NO, 4, 0) ITEM_CODE, 'R#' || T.PURCH_REF_NO LOT_NO, '~'  || substr(D.ITEM_MT_DESC,1,80) ITEM_DESC, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.ITEM_MT_DESC = D.ITEM_MT_DESC AND S.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:'  || D.ITEM_MT_BBY_SKU SKU, '*+' || REPLACE(D.LAPTOP_ITEM_CODE, '-', '') || LPAD(T.LOADING_NO, 4, 0) || '*' BAR_CODE,D.PO_DETAIL_LOT_REF LOT_ID FROM LZ_MANIFEST_MT T, LZ_MANIFEST_DET D WHERE T.LZ_MANIFEST_ID = D.LZ_MANIFEST_ID and D.LAPTOP_ZONE_ID = $laptop_zone_id");
    $print_qry = $this->db->query("SELECT B.PO_DETAIL_LOT_REF, B.BARCODE_NO BAR_CODE , '~' || SUBSTR(I.ITEM_DESC, 1, 80) ITEM_DESC, 'R#' || T.PURCH_REF_NO LOT_NO, B.UNIT_NO, (SELECT SUM(S.AVAILABLE_QTY) FROM LZ_MANIFEST_DET S WHERE S.LAPTOP_ITEM_CODE=I.ITEM_CODE AND S.LZ_MANIFEST_ID = T.LZ_MANIFEST_ID AND ROWNUM =1 GROUP BY S.ITEM_MT_DESC) LOT_QTY, 'SKU:' || I.ITEM_MT_BBY_SKU SKU FROM LZ_MANIFEST_MT T, LZ_BARCODE_MT B, ITEMS_MT I WHERE T.LZ_MANIFEST_ID = B.LZ_MANIFEST_ID AND B.ITEM_ID = I.ITEM_ID AND I.ITEM_CODE='$item_code' AND B.LZ_MANIFEST_ID = $manifest_id AND B.BARCODE_NO = $barcode");
    $query = $this->db->query("UPDATE LZ_BARCODE_MT SET PRINT_STATUS = 1 WHERE BARCODE_NO = $barcode");     
    //var_dump($print_qry);exit;
    return $print_qry->result_array();
  }

  function import_label_cost()
    {
        date_default_timezone_set("America/Chicago");
        $list_date = date("Y-m-d H:i:s");
        $inserted_date = "TO_DATE('".$list_date."', 'YYYY-MM-DD HH24:MI:SS')";
        $inserted_by = $this->session->userdata('user_id');     
        $this->load->library('PHPExcel');
        $ext = pathinfo($_FILES["file_name"]["name"], PATHINFO_EXTENSION);
        //$allow_ext = array('xlsx','csv');
        $allow_ext = array('xlsx');

        if (!in_array($ext, $allow_ext))
        {
            echo "Only files with .xlsx & .csv ext are allowed.";
        }else{
             /*========================================
            =            xlsx import start            =
            ========================================*/
            $filename = $this->input->post('file_name').'.'.$ext;
            move_uploaded_file($_FILES["file_name"]["tmp_name"],$filename);
            // move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
            if(strtolower($ext) == 'xlsx')
            {
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                $objReader->setReadDataOnly(true);

            }
            $objPHPExcel = $objReader->load($filename);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $i=1;
            $total_rows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow()-1;


            foreach ($objWorksheet->getRowIterator() as $row)
            {

                if($i >= 2)
                {
                    $label_cost = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();  
                    $label_cost = abs(trim($label_cost));
                    $paypal_id = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                    $ship_tracking = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                    $ship_tracking = trim(str_replace("  ", ' ', $ship_tracking));
                    $ship_tracking = trim(str_replace(array("'"), "''", $ship_tracking));
                    $str = explode(', ', $ship_tracking);
                    $ShipSvc = explode('ShipSvc:', @$str[0]);
                    $shipping_service = end($ShipSvc);
                    if(!empty(@$str[1])){
                        $Trkno = explode('Trk#:', @$str[1]);
                        $tracking_no = end($Trkno);
                    }
                    
                    $comma = ',';
                    if(is_numeric($tracking_no)){
                            $qry_det = "SELECT * FROM LZ_SHIPPING_LEBEL_COST WHERE TRACKING_NO = '$tracking_no'";
                            $check = $this->db->query($qry_det);
                            if($check->num_rows() == 0){            
                                $qry_det = "INSERT INTO LZ_SHIPPING_LEBEL_COST VALUES('$tracking_no' $comma $label_cost $comma '$shipping_service' $comma $inserted_by $comma $inserted_date $comma '$paypal_id')";
                                $this->db->query($qry_det);
                            }else{
                                    $qry_det = "UPDATE LZ_SHIPPING_LEBEL_COST SET ENTERED_BY = $inserted_by $comma INSERTED_DATE = $inserted_date WHERE TRACKING_NO = '$tracking_no' AND PAYPAL_ID = '$paypal_id'";
                                    $this->db->query($qry_det);
                                }
                    }

                }

                $i++; 
            }
            if($this->db->query($qry_det)){
                echo "<script>alert('File imported Succsessfully');</script>";
                //return true;
            }else{
                echo "<script>alert('Error occure while Importing File');</script>";
                //echo "Error occure while Importing File";
                 //return false;
            }
             /*========================================
            =            xlsx import end            =
            ========================================*/
         }
        /*==============================================
        =            csv file reader script            =
        ==============================================*/
        //elseif(strtolower($ext) == 'csv'){
                //     /*========================================
                //     =            csv import start            =
                //     ========================================*/
                   
                //         $csv_mimetypes = array(
                //         'text/csv',
                //         'text/plain',
                //         'application/csv',
                //         'text/comma-separated-values',
                //         'application/excel',
                //         'application/vnd.ms-excel',
                //         'application/vnd.msexcel',
                //         'text/anytext',
                //         'application/octet-stream',
                //         'application/txt',
                //         );

                //         if (in_array($_FILES['file_name']['type'], $csv_mimetypes)) {
                //         // possible CSV file
                //         // could also check for file content at this point

                //             $count=0;
                //             $fp = fopen($_FILES['file_name']['tmp_name'],'r') or die("can't open file");
                //             while($csv_line = fgetcsv($fp))
                //             {
                               
                //                 $count++;
                //                 if($count == 1)
                //                 {
                //                     continue;
                //                 }//keep this if condition if you want to remove the first row
                //                 for($i = 0, $j = count($csv_line); $i < $j; $i++)

                //                 $i++;
                //                 $label_cost = $csv_line[3];
                //                 $label_cost = trim($label_cost);
                //                 $str = explode('$', $label_cost);
                //                 $label_cost= end($str);

                //                 $shipping_service = $csv_line[5];
                //                 $shipping_service = trim(str_replace("  ", ' ', $shipping_service));
                //                 $shipping_service = trim(str_replace(array("'"), "''", $shipping_service));
                //                 $tracking_no = $csv_line[6];
                                
                //                 $str = explode(' ', $tracking_no);
                //                 $tracking_no= end($str);
                //                 $tracking_no = str_replace('Created', '', $tracking_no);
                //                 $comma = ',';
                //                     if(is_numeric($tracking_no)){
                //                         $qry_det = "SELECT * FROM LZ_SHIPPING_LEBEL_COST WHERE TRACKING_NO = '$tracking_no'";
                //                         $check = $this->db->query($qry_det);
                //                         if($check->num_rows() == 0){            
                //                             $qry_det = "INSERT INTO LZ_SHIPPING_LEBEL_COST VALUES('$tracking_no' $comma $label_cost $comma '$shipping_service' $comma $seller_account_id $comma $inserted_by $comma $inserted_date)";
                //                             $this->db->query($qry_det);
                //                         }else{
                //                             $qry_det = "UPDATE LZ_SHIPPING_LEBEL_COST SET SELLER_ACOUNT_ID = $seller_account_id $comma ENTERED_BY = $inserted_by $comma INSERTED_DATE = $inserted_date WHERE TRACKING_NO = '$tracking_no'";
                //                             $this->db->query($qry_det);
                //                         }
                //                     }

                //             }
                //         }else {
                //         die("Sorry, only csv file type allowed");
                //         }
                //             fclose($fp) or die("can't close file");
                //            if($this->db->query($qry_det)){
                //                 echo "File imported Succsessfully";
                //             }else{
                //                  echo "Error occure while Importing File";
                //             }


                //     /*=====  End of csv import start  ======*/
                // }//main if else if end


        /*=====  End of csv file reader script  ======*/

         
    }
}

?>