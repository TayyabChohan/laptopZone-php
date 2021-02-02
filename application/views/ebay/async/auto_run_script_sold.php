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
        //$conn =  oci_connect('lz_bigData', 's', 'localhost/LZBIGDATA');
        //$con =  oci_connect('laptop_zone', 's', 'localhost/LZBIGDATA');
        //echo $cat_id=$_POST['cat_id'].PHP_EOL;
        //$cat_id = 111422;
        $DBlink = '@ORASERVER';
        $table_name = 'LZ_BD_CATAG_DATA_'.$cat_id.'_TMP';
        $main_table = 'LZ_BD_CATAG_DATA_'.$cat_id;
        
        $tab_query = "SELECT T.TNAME FROM TAB T WHERE T.tname = '$table_name'";
        $tab_query = oci_parse($conn, $tab_query);
        oci_execute($tab_query,OCI_DEFAULT);
        $data = oci_fetch_array($tab_query, OCI_ASSOC);
        if($data == false){
            $tab_query = "call PRO_DYNAMIC_CATEGORY_CREATION($cat_id)";
            $tab_query = oci_parse($conn, $tab_query);
            oci_execute($tab_query,OCI_DEFAULT);

            //$tab_query_synonym = "call PRO_DYNAMIC_CATEGORY_SYNONYM($cat_id)";
            //$tab_query_synonym = oci_parse($con, $tab_query_synonym);
            //oci_execute($tab_query_synonym,OCI_DEFAULT);
          
        }else{
            /* --Data insertion in Main table start-- */
            $move_data_qry = "INSERT INTO $main_table SELECT * FROM $table_name";
            $move_data_qry = oci_parse($conn, $move_data_qry);
            /* --Data insertion in Main table end-- */

            /* --Truncate Temp table start-- */
            if(oci_execute($move_data_qry, OCI_DEFAULT)){
                $truncate_data_qry = "TRUNCATE TABLE $table_name";
                $truncate_data_qry = oci_parse($conn, $truncate_data_qry);
                $truncate_data_qry = oci_execute($truncate_data_qry, OCI_DEFAULT);
                oci_commit($conn);         
            }
        /* --Truncate Temp table end-- */
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
        //include 'getSpecifics.php';// this call count in our daily call limit thats why commented at 09-05-2018
        //exit;
    /*=====  End of Download latest Specifics For given Cat_id  ======*/

    //$select_query = $this->db->query("SELECT * FROM LZ_BD_CATEGORY C  WHERE C.CATEGORY_ID = $cat_id");
    // $select_query = $this->db->query("SELECT * FROM LZ_BD_CATEGORY C  WHERE C.CATEGORY_ID IN(3680, 112529, 175673, 183062, 11848, 29585, 112661, 94879, 182089, 182088, 117042, 3323, 31388, 43304, 19006, 71470, 48636, 178893, 33963, 176981, 176975, 80053, 168068, 75708, 162045, 176972, 75390, 104046)");
    // $data = $select_query->result_array();
    //$cat_id = $data[0]['CATEGORY_ID'];
    /*=====  End of Get category id  ======*/

    /*=====  Active Call log Insertion start  ======*/
    $select_query = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CATEGORY_CALL_LOG','CALL_LOG_ID') CALL_LOG_ID FROM DUAL";
    $select = oci_parse($conn, $select_query);
    oci_execute($select,OCI_DEFAULT);
    $rs = oci_fetch_array($select, OCI_ASSOC);

    $call_log_id = $rs['CALL_LOG_ID'];    
    $null = "null";
    $listing_filter = 'SOLD';
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')"; 

    $log_qry = "INSERT INTO LZ_BD_CATEGORY_CALL_LOG (CALL_LOG_ID, CATEGORY_ID, LISTING_FILTER, MIN_TIME, MAX_TIME, EXECUTION_TIME, RECORDS_PER_MIN, TOTAL_RECORDS, PER_DAY_AVG, INSERTED_DATE, CALL_STATUS,SOURCE_FILE) VALUES($call_log_id $comma $cat_id $comma '$listing_filter' $comma $null $comma $null $comma $null $comma $null $comma $null $comma $null $comma $inserted_date $comma 0 $comma '$source_file')"; 
    $select_log = oci_parse($conn, $log_qry);
    $qry = oci_execute($select_log, OCI_DEFAULT);
    oci_commit($conn);
    /*=====  Active Call log Insertion end  ======*/

    $flag = false;
//foreach($data as $value){
    //var_dump($value);exit;
    $i=1;
    do{
        /*=============================================
    =            get max date inserted            =
    =============================================*/    
        if(!$flag){
            // $time_query = $this->db->query("SELECT DATE_TO_UNIX_TS(MAX(D.SALE_TIME)) AS UTIME FROM LZ_BD_CATAG_DATA D WHERE D.MAIN_CATEGORY_ID =".$value['CATEGORY_ID']);
            // $time_query = $time_query->result_array();
            // $time = $time_query[0]['UTIME'];
            //$con =  oci_connect('laptop_zone', 'S', 'wizmen-pc/ORCL');
            if($i == 1){
                $time_query = "SELECT laptop_zone.DATE_TO_UNIX_TS(MAX(D.SALE_TIME)) AS UTIME FROM $main_table D WHERE D.SALE_TIME >= SYSDATE- 90 AND D.MAIN_CATEGORY_ID =".$value['CATEGORY_ID'];// LAST DATE NOT BE 90 DAYS OLD
            //echo $time_query; exit;
            $t_query = oci_parse($conn, $time_query);
            //var_dump(oci_execute($t_query,OCI_DEFAULT));exit;
            oci_execute($t_query,OCI_DEFAULT);
            $data = oci_fetch_array($t_query, OCI_ASSOC);
            $time = @$data['UTIME'];
            }else{
                $time_query = "SELECT laptop_zone.DATE_TO_UNIX_TS(MAX(D.SALE_TIME)) AS UTIME FROM $table_name D WHERE D.MAIN_CATEGORY_ID =".$value['CATEGORY_ID'];
            //echo $time_query; exit;
            $t_query = oci_parse($conn, $time_query);
            //var_dump(oci_execute($t_query,OCI_DEFAULT));exit;
            oci_execute($t_query,OCI_DEFAULT);
            $data = oci_fetch_array($t_query, OCI_ASSOC);
            $time = @$data['UTIME'];
            }
            
            
             /*=====  End of get max date inserted  ======*/

            /*===========================================================
            =            convert microtime to require format            =
            ===========================================================*/
            //$time = microtime(true);
            // EndTimeFrom = Limits the results to items ending on or after the specified time. Specify a time in the future.  
            // EndTimeTo =  Limits the results to items ending on or before the specified time. Specify a time in the future.           
            if(!empty($time)){
                //$tMicro = sprintf("%03d",($time - floor($time)) * 1000);
                //$EndTimeFrom = gmdate('Y-m-d\TH:i:s.', $time).$tMicro.'Z';
                $EndTimeFrom = gmdate('Y-m-d', $time);
                $EndTimeFrom = new DateTime($EndTimeFrom);
                $EndTimeFrom->modify('+1 day');
                $EndTimeFrom = $EndTimeFrom->format('Y-m-d');
            }else{
                $time = strtotime('-90 days');
                //$tMicro = sprintf("%03d",($time - floor($time)) * 1000);
                $EndTimeTo = gmdate('Y-m-d', $time);
                $EndTimeFrom = null;
            }
            if(!empty($EndTimeFrom)){
                $EndTimeTo = new DateTime($EndTimeFrom);
                $EndTimeTo->modify('+1 day');
                $EndTimeTo = $EndTimeTo->format('Y-m-d');
            }else{
                $EndTimeFrom = null;
            }
            
            /*=====  End of convert microtime to require format  ======*/
        }else{
            $EndTimeFrom = new DateTime($EndTimeTo);
            $EndTimeFrom->modify('+1 day');
            $EndTimeFrom = $EndTimeFrom->format('Y-m-d');
            $EndTimeTo = new DateTime($EndTimeFrom);
            $EndTimeTo->modify('+1 day');
            $EndTimeTo = $EndTimeTo->format('Y-m-d');
        }
            date_default_timezone_set("America/Chicago");
            $currentDate = date('Y-m-d\TH:i:s');
            $currentDate = $currentDate.'.000Z';

        if(!empty($EndTimeFrom)){
            $EndTimeFrom = $EndTimeFrom . 'T00:00:00.000Z';
            if($currentDate < $EndTimeFrom){
            $EndTimeFrom = $currentDate;
            }
        }
        
        $EndTimeTo = $EndTimeTo . 'T23:59:59.000Z' ;
        //var_dump($EndTimeFrom,$EndTimeTo);exit;
        $endTimeLoop = $EndTimeTo;
        /*==================================================================
        =            check if enddate greater than current date            =
        ==================================================================*/
            
        if($currentDate < $EndTimeTo){
            $EndTimeTo = $currentDate;
        }
        echo "loop count: ".$i. " ,EndTimeFrom:".$EndTimeFrom." ,EndTimeTo:".$EndTimeTo .", endTimeLoop: ".$endTimeLoop. PHP_EOL;
        /*=====  End of check if enddate greater than current date  ======*/
        include 'solditemswithdatefilter_19_08_2017.php';
        //echo $request->paginationInput->pageNumber.'-'.$response->searchResult->count.'<br>';
        //var_dump('EndTimeFrom:'.$EndTimeFrom,'EndTimeTo:'.$EndTimeTo);
        
        $flag = false;
        if($response->searchResult->count == 0){
            $flag = true;
        }
        if($i > 46){//1 CALL PULL 2 DAYS DATA SO LOOP WILL BE RUN MAX 45 TIMES = 90 DAYS
            break;
        }
        $i++;
    }while($currentDate >= $endTimeLoop); //($response->searchResult->count > 0 && $flag);
//}//end main foreach
echo "Data Downloaded Successfully". PHP_EOL;

/* --Call log insertion start 19-08-2017-- */
    

    //Call log insertion query

    $min_max_query = "SELECT DATE_TO_UNIX_TS(MIN(D.INSERTED_DATE)) MIN_TIME, DATE_TO_UNIX_TS(MAX(D.INSERTED_DATE)) MAX_TIME FROM $table_name D WHERE D.MAIN_CATEGORY_ID = ".$value['CATEGORY_ID'];
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
    $total_query = "SELECT COUNT(1) TOTAL_RECORDS FROM $table_name D WHERE D.MAIN_CATEGORY_ID = ".$value['CATEGORY_ID'];
    $total_records = oci_parse($conn, $total_query);
    oci_execute($total_records,OCI_DEFAULT);
    $total = oci_fetch_array($total_records, OCI_ASSOC);
    if($time_in_min != 0){
        $per_mint_records = $total['TOTAL_RECORDS']/$time_in_min;
    }else{
        $per_mint_records = 0;
    }
    $total_records = $total['TOTAL_RECORDS'];
    
    $per_day_avg_qry = "SELECT AVG(CNT) AVERAGE FROM (SELECT TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY') SALE_TIME, COUNT(1) CNT FROM $table_name CD WHERE CD.SALE_TIME BETWEEN $min_time AND $max_time GROUP BY TO_CHAR(CD.SALE_TIME, 'MM/DD/YYYY'))"; 
    $avg_records = oci_parse($conn, $per_day_avg_qry);
    oci_execute($avg_records,OCI_DEFAULT);
    $avg_records_data = oci_fetch_array($avg_records, OCI_ASSOC);
    //var_dump($avg_records_data['AVERAGE']);exit;
    $avg_records_data = @$avg_records_data['AVERAGE'];
    if(empty($avg_records_data)){
        $avg_records_data = 'null';
    }else{
        $avg_records_data = @$avg_records_data['AVERAGE'];
    } 
    
    $inserted_date = date("Y-m-d H:i:s");
    $inserted_date = "TO_DATE('".$inserted_date."', 'YYYY-MM-DD HH24:MI:SS')";        
    $select_query = "SELECT GET_SINGLE_PRIMARY_KEY('LZ_BD_CATEGORY_CALL_LOG','CALL_LOG_ID') CALL_LOG_ID FROM DUAL";
    $select = oci_parse($conn, $select_query);
    oci_execute($select,OCI_DEFAULT);
    $rs = oci_fetch_array($select, OCI_ASSOC);

    $call_log_id = $rs['CALL_LOG_ID']; 

    $insert_qry = "INSERT INTO LZ_BD_CATEGORY_CALL_LOG (CALL_LOG_ID, CATEGORY_ID, LISTING_FILTER, MIN_TIME, MAX_TIME, EXECUTION_TIME, RECORDS_PER_MIN, TOTAL_RECORDS, PER_DAY_AVG, INSERTED_DATE, CALL_STATUS,SOURCE_FILE) VALUES($call_log_id $comma $cat_id $comma '$listing_filter' $comma $min_time $comma $max_time $comma '$execution_time' $comma $per_mint_records $comma $total_records $comma $avg_records_data $comma $inserted_date $comma 1 $comma '$source_file')"; 
    $select = oci_parse($conn, $insert_qry);
    $qry = oci_execute($select,OCI_DEFAULT);
    oci_commit($conn);
    /* --Call log insertion end-- */

    /* --Data insertion in Main table start-- */
    $move_data_qry = "INSERT INTO $main_table SELECT * FROM $table_name";
    $move_data_qry = oci_parse($conn, $move_data_qry);
    //$move_data_qry = oci_execute($move_data_qry, OCI_DEFAULT);
    // oci_commit($conn);
    /* --Data insertion in Main table end-- */

    /* --Truncate Temp table start-- */
    if(oci_execute($move_data_qry, OCI_DEFAULT)){
        $truncate_data_qry = "TRUNCATE TABLE $table_name";
        $truncate_data_qry = oci_parse($conn, $truncate_data_qry);
        $truncate_data_qry = oci_execute($truncate_data_qry, OCI_DEFAULT);
        oci_commit($conn);         
    }
    /* --Truncate Temp table end-- */
    /*==================================================
    =            verify data procedure call            =
    ==================================================*/
    
    // $verify_pro = "CALL PRO_RECOGNIZE_SOLD_CURRENT($cat_id)";
    // $verify_pro = oci_parse($conn, $verify_pro);
    // oci_execute($verify_pro, OCI_DEFAULT);
    
    /*=====  End of verify data procedure call  ======*/
    /*=============================================
    =            sold minus active procedure call            =
    =============================================*/
    // $sold_active = "CALL PRO_SOLD_MINUS_ACTIVE($cat_id)";
    // $sold_active = oci_parse($conn, $sold_active);
    // oci_execute($sold_active, OCI_DEFAULT);    
        
    /*=====  End of sold minus active procedure call  ======*/

?>