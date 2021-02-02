<?php
ini_set('memory_limit', '-1');
/*=============================================================
=   FOR RUNNING PHP FILE USING CLI (COMMAND LINE INTERFACE)   =
===============================================================*/

//https://stackoverflow.com/questions/8012682/php-exe-in-cmd-throws-call-to-undefined-function-oci-connect
//There are two php.ini files in WAMP
//1. One is in Apache folder and other one is in php folder
//To Run php file using web browser you have to update php.ini file in Apache Folder
//To Run php file using CLI you have to update php.ini file in PHP folder 

/*=====  End of FOR RUNNING PHP FILE USING CLI (COMMAND LINE INTERFACE)  ======*/

    //require('db_connection_bigdata.php');
    /*=======================================
    =            Get category id            =
    =======================================*/
    //$cat_id = $this->uri->segment(4);

    // ===================== Start Checking if record already exist ==============================
        // $conn =  oci_connect('lz_bigData', 's', 'wizmen-pc/ORCL');
        // $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL');
        // $conn =  oci_connect('lz_bigData', 's', 'localhost/LZBIGDATA');
        // $con =  oci_connect('laptop_zone', 's', 'localhost/LZBIGDATA');
        // //echo $cat_id=$_POST['cat_id'].PHP_EOL;
        // $cat_id = 179;
        $DBlink = '@ORASERVER';
        //$DBlink = '';
        $table_name = 'LZ_BD_ACTIVE_DATA_'.$cat_id.'_TMP';
        $main_table = 'LZ_BD_ACTIVE_DATA_'.$cat_id;
        $tab_query = "SELECT T.TNAME FROM TAB T WHERE T.tname = '$table_name'";
        $tab_query = oci_parse($conn, $tab_query);
        oci_execute($tab_query,OCI_DEFAULT);
        $data = oci_fetch_array($tab_query, OCI_ASSOC);
        if($data == false){
            /*===========================================
            =            create active table            =
            ===========================================*/
            $tab_query = "call PRO_DYNAMIC_ACTIVE_TABLES($cat_id)";
            $tab_query = oci_parse($conn, $tab_query);
            oci_execute($tab_query,OCI_DEFAULT);

            // $tab_query_synonym = "call PRO_ACTIVE_CATEGORY_SYNONYM($cat_id)";
            // $tab_query_synonym = oci_parse($conn, $tab_query_synonym);
            // oci_execute($tab_query_synonym,OCI_DEFAULT);
            /*=====  End of create active table  ======*/
        }
        /*--Start Insertion PROCEDURE Script for LZ_BD_CATEGORY--*/
            $tab_category_query = "call PRO_LZ_BD_CATEGORY($cat_id)";
            $tab_category_query = oci_parse($conn, $tab_category_query);
            oci_execute($tab_category_query,OCI_DEFAULT);
            // exit;
        /*--End Insertion PROCEDURE Script for LZ_BD_CATEGORY--*/



        $select_query = "SELECT * FROM LZ_BD_CATEGORY C  WHERE C.CATEGORY_ID = $cat_id";
        $select = oci_parse($conn, $select_query);
        oci_execute($select,OCI_DEFAULT);
        $value = oci_fetch_array($select, OCI_ASSOC);
        echo "Downloaded Category ID: ".$value['CATEGORY_ID'].PHP_EOL;
        //var_dump($value['CATEGORY_ID']);exit;
        
        //$cat_id = $value['CATEGORY_ID'];
        $comma = ",";
        date_default_timezone_set("America/Chicago");
              
    // ===================== End Checking if record already exist ===============================    
    /*==================================================================
    =            Download latest Specifics For given Cat_id            =
    ==================================================================*/
        include 'getSpecifics.php';
        //exit;
    /*=====  End of Download latest Specifics For given Cat_id  ======*/
// below code needed for the first time of category call
    // $select_brand = "SELECT UPPER(D.SPECIFIC_VALUE) SPECIFIC_VALUE FROM CATEGORY_SPECIFIC_MT$DBlink M, CATEGORY_SPECIFIC_DET$DBlink D WHERE M.EBAY_CATEGORY_ID = $cat_id AND M.CUSTOM = 0 AND UPPER(M.SPECIFIC_NAME) = 'BRAND' AND UPPER(M.SPECIFIC_NAME) <> 'N/A' AND UPPER(M.SPECIFIC_NAME) <> 'UNBRANDED/GENERIC'AND D.MT_ID = M.MT_ID"; 
    // $brand_name = oci_parse($con, $select_brand);
    // oci_execute($brand_name,OCI_DEFAULT);
// above code needed for the first time of category call

    //while (($row = oci_fetch_array($brand_name, OCI_BOTH)) != false) {
        /*=====  Active Call log Insertion start  ======*/
            // $select_query = "SELECT LAPTOP_ZONE.GET_SINGLE_PRIMARY_KEY('LZ_BD_ACTIVE_CALL_LOG','CALL_LOG_ID') CALL_LOG_ID FROM DUAL";
            // $select = oci_parse($conn, $select_query);
            // oci_execute($select,OCI_DEFAULT);
            // $rs = oci_fetch_array($select, OCI_ASSOC);

            // $call_log_id = $rs['CALL_LOG_ID'];    
           // $null = "null";
            // $listing_filter = 'ACTIVE';
            // $inserted_date = date("Y-m-d H:i:s");
            // $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";
            // //$user_id = $this->session->userdata('user_id'); 
            // $user_id = 2;
            // $log_qry = "INSERT INTO LZ_BD_ACTIVE_CALL_LOG (CALL_LOG_ID, CATEGORY_ID, LISTING_FILTER, MIN_TIME, MAX_TIME, EXECUTION_TIME, RECORDS_PER_MIN, TOTAL_RECORDS, PER_DAY_AVG, INSERTED_DATE, CALL_STATUS, KEYWORD, TOTAL_COUNT, INSERTED_BY,CONDITION_ID) VALUES($call_log_id $comma $cat_id $comma '$listing_filter' $comma $null $comma $null $comma $null $comma $null $comma $null $comma $null $comma $inserted_date $comma 0 $comma '$seller_id' $comma $null $comma $user_id)"; 
            //     $select_log = oci_parse($conn, $log_qry);
            //     $qry = oci_execute($select_log, OCI_DEFAULT);
            //     oci_commit($conn);

        /*=====  Active Call log Insertion end  ======*/
        //$keyword_brand = $row['SPECIFIC_VALUE'];

       // $select_cond = "SELECT ID CONDITION FROM LZ_ITEM_COND_MT$DBlink MT ORDER BY MT.ID"; 
       // $cond_id = oci_parse($con, $select_cond);
       // oci_execute($cond_id,OCI_DEFAULT);
        //while (($result = oci_fetch_array($cond_id, OCI_BOTH)) != false) {
         //   $condition_id = @$result['CONDITION'];
            //include 'activeitemswithdatefilter_07_09_2017.php';
            /* --Call log insertion start 19-08-2017-- */
    

    $select_ebay_id = "SELECT TO_CHAR(LAST_TIMESTAMP,'YYYY-MM-DD HH24:MI:SS') LAST_TIMESTAMP FROM LZ_BD_LAST_TIMESTAMP C  WHERE C.CATEGORY_ID = $cat_id"; 
        $ebay_id = oci_parse($conn, $select_ebay_id);
        oci_execute($ebay_id,OCI_DEFAULT);
        $result = oci_fetch_array($ebay_id, OCI_BOTH);
        $last_time_stamp = $result['LAST_TIMESTAMP'];
        //$last_time_stamp = '2017-09-16 15:02:33';
             include 'activeitemswithmoddatefilter.php';
             include 'activeitemswithlotfilter.php';
    /*===============================================
    =            update latest_timestamp            =
    ===============================================*/
    $last_time_stamp = "SELECT TO_CHAR(MAX(START_TIME),'YYYY-MM-DD HH24:MI:SS') LAST_TIMSTAMP FROM $table_name";
    $last_time_stamp = oci_parse($conn, $last_time_stamp);
    oci_execute($last_time_stamp,OCI_DEFAULT);
    $result = oci_fetch_array($last_time_stamp, OCI_BOTH);
    $last_timestamp = $result['LAST_TIMSTAMP'];
    $last_timestamp = "TO_DATE('".$last_timestamp."', 'YYYY-MM-DD HH24:MI:SS')";
    $select_ebay_id = "UPDATE LZ_BD_LAST_TIMESTAMP SET LAST_TIMESTAMP = $last_timestamp WHERE CATEGORY_ID = $cat_id"; 
    $ebay_id = oci_parse($conn, $select_ebay_id);
    oci_execute($ebay_id,OCI_DEFAULT);
    oci_commit($conn);
    
    /*=====  End of update latest_timestamp  ======*/


            //Call log insertion query

            //$min_max_query = "SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM $table_name D WHERE D.CONDITION_ID = $condition_id";
            $min_max_query = "SELECT DATE_TO_UNIX_TS(MIN(INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(INSERTED_DATE)) MAX_TIME FROM $table_name";
            $time_query = oci_parse($conn, $min_max_query);
            oci_execute($time_query,OCI_DEFAULT);
            $data = oci_fetch_array($time_query, OCI_ASSOC);
            $max_time = $data['MAX_TIME'];
            $min_time = $data['MIN_TIME'];
            $min_time = gmdate('Y-m-d\TH:i:s', $min_time);
            $min_time = new DateTime($min_time);
             
            $max_time = gmdate('Y-m-d\TH:i:s', $max_time);
            $max_time = new DateTime($max_time);
            
            //var_dump($min_time,$max_time);exit;         

            // $dteStart = new DateTime($min_time); 
            // $dteEnd   = new DateTime($max_time); 
            $dteDiff  = $min_time->diff($max_time); 
            $min_time = $min_time->format('Y-m-d\TH:i:s');
            $max_time = $max_time->format('Y-m-d\TH:i:s');
            $execution_time = $dteDiff->format("%d days %H:%I:%S");
            $min_time = str_replace(array("T"), "", $min_time); 
            $max_time = str_replace(array("T"), "", $max_time);
            $time_in_min = $dteDiff->format("%I");
            $min_time = "TO_DATE('".$min_time."', 'YYYY-MM-DD HH24:MI:SS')";
            $max_time = "TO_DATE('".$max_time."', 'YYYY-MM-DD HH24:MI:SS')";    
            //var_dump($min_time,$max_time);exit;
            $total_query = "SELECT COUNT(1) TOTAL_RECORDS FROM $table_name D";
            $total_records = oci_parse($conn, $total_query);
            oci_execute($total_records,OCI_DEFAULT);
            $total = oci_fetch_array($total_records, OCI_ASSOC);
            if($time_in_min != 0){
                $per_mint_records = $total['TOTAL_RECORDS']/$time_in_min;
            }else{
                $per_mint_records = 0;
            }
            $total_records = $total['TOTAL_RECORDS'];
            
            //$per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $table_name CD WHERE CD.CONDITION_ID = $condition_id AND CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
            $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $table_name CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
            $avg_records = oci_parse($conn, $per_day_avg_qry);
            oci_execute($avg_records,OCI_DEFAULT);
            $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
            //var_dump($avg_records_data['AVERAGE']);exit;
            $avg_records_data = @$avg_records_data['AVERAGE'];
            if(empty($avg_records_data)){
                $avg_records_data = null;
            }else{
                $avg_records_data = @$avg_records_data['AVERAGE'];
            } 
            
            $inserted_date = date("Y-m-d H:i:s");
            $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";        
            $select_query = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_ACTIVE_CALL_LOG','CALL_LOG_ID') CALL_LOG_ID FROM DUAL";
            $select = oci_parse($conn, $select_query);
            oci_execute($select,OCI_DEFAULT);
            $rs = oci_fetch_array($select, OCI_ASSOC);

            $call_log_id = $rs['CALL_LOG_ID']; 
            $listing_filter = 'ACTIVE';
            $user_id = 2;
            $condition_id = null;
            $keyword_brand = null;

            $insert_qry = "INSERT INTO LZ_BD_ACTIVE_CALL_LOG (CALL_LOG_ID, CATEGORY_ID, LISTING_FILTER, MIN_TIME, MAX_TIME, EXECUTION_TIME, RECORDS_PER_MIN, TOTAL_RECORDS, PER_DAY_AVG, INSERTED_DATE, CALL_STATUS,KEYWORD,TOTAL_COUNT,INSERTED_BY,CONDITION_ID) VALUES('$call_log_id' $comma '$cat_id' $comma '$listing_filter' $comma $min_time $comma $max_time $comma '$execution_time' $comma '$per_mint_records' $comma '$total_records' $comma '$avg_records_data' $comma $inserted_date $comma 1 $comma '$keyword_brand' $comma '$total_records' $comma '$user_id' $comma '$condition_id')"; 
            $select = oci_parse($conn, $insert_qry);
            $qry = oci_execute($select,OCI_DEFAULT);
            oci_commit($conn);
            /* --Call log insertion end-- */
//exit;
  //      }//end codition while
            
      //  $i++;
            //exit;
  //  }//end main while loop
    // exit;

echo "Data Downloaded Successfully";



    /* --Data insertion in Main table start-- */
    $move_data_qry = "INSERT INTO $main_table SELECT * FROM $table_name";
    $move_data_qry = oci_parse($conn, $move_data_qry);
    $move_data_qry = oci_execute($move_data_qry, OCI_DEFAULT);
    oci_commit($conn);
    /* --Data insertion in Main table end-- */

    /* --Truncate Temp table start-- */
    if(oci_commit($conn)){
        $truncate_data_qry = "TRUNCATE TABLE $table_name";
        $truncate_data_qry = oci_parse($conn, $truncate_data_qry);
        $truncate_data_qry = oci_execute($truncate_data_qry, OCI_DEFAULT);
        oci_commit($conn);         
    }
    /* --Truncate Temp table end-- */

    /*==================================================
    =            verify data procedure call            =
    ==================================================*/
    
    $verify_pro = "CALL PRO_RECOGNIZE_ACTIVE_CURRENT($cat_id)";
    $verify_pro = oci_parse($conn, $verify_pro);
    oci_execute($verify_pro, OCI_DEFAULT);
    
    /*=====  End of verify data procedure call  ======*/
    
    /*=============================================
    =            sold minus active procedure call            =
    =============================================*/
    // $sold_active = "CALL PRO_SOLD_MINUS_ACTIVE($cat_id)"; // this procedure is called from auto_run_sold_script
    // $sold_active = oci_parse($conn, $sold_active);
    // oci_execute($sold_active, OCI_DEFAULT);    
        
    /*=====  End of sold minus active procedure call  ======*/
    
            

    /*==========================================
    =            Verified Procedure for parts  with 111422 exp         =
    ==========================================*/
    // $verify_part = "call PRO_recog_active_data($cat_id)";
    // $verify_part = oci_parse($conn, $verify_part);
    // oci_execute($verify_part, OCI_DEFAULT);    
    /*=====  End of Verified Procedure for parts ======*/
    

?>