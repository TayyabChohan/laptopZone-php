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
        // $conn =  oci_connect('lz_bigData', 's', 'wizmen-pc/ORCL');
        // $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL');
        $conn =  oci_connect('lz_bigData', 's', '192.168.0.78/LZBIGDATA');
        // $conn =  oci_connect('lz_bigData', 's', 'dbserver/LZBIGDATA');
        //$con =  oci_connect('laptop_zone', 's', 'localhost/LZBIGDATA');
        //echo $cat_id=$_POST['cat_id'].PHP_EOL;

        //$cat_query = "SELECT DISTINCT CATEGORY_ID FROM LZ_BD_CATEGORY";
//To Run php file using web browser you have to update php.ini file in Apache Folder
        
        $source_file = basename(__FILE__, '.php');
        $cat_qry = "SELECT CATEGORY_ID,CALL_STATUS FROM (SELECT L.CATEGORY_ID,L.CALL_STATUS FROM LZ_BD_CATEGORY_CALL_LOG L WHERE SOURCE_FILE = '".$source_file."' ORDER BY L.CALL_LOG_ID DESC) WHERE ROWNUM = 1 ";
        //echo $cat_qry; exit;
        $c_query = oci_parse($conn, $cat_qry);
        //var_dump(oci_execute($t_query,OCI_DEFAULT));exit;
        oci_execute($c_query,OCI_DEFAULT);
        $data = oci_fetch_array($c_query, OCI_ASSOC);

        $category_id = @$data['CATEGORY_ID'];
        $call_status = @$data['CALL_STATUS'];

        $max_cat = "SELECT MAX(CATEGORY_ID) CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID IS NOT NULL AND T.UPDATED IS NOT NULL AND T.CATEGORY_ID >= 40004 AND T.CATEGORY_ID <= 152553 ORDER BY T.CATEGORY_ID ASC";
        //echo $cat_qry; exit;
        $max_qry = oci_parse($conn, $max_cat);
        //var_dump(oci_execute($t_query,OCI_DEFAULT));exit;
        oci_execute($max_qry,OCI_DEFAULT);
        $max_category = oci_fetch_array($max_qry, OCI_ASSOC);
        $max_cat_id = @$max_category['CATEGORY_ID'];

/*=============================================================================
=            if current cat id = max cat id restart loop condition            =
=============================================================================*/
        if($category_id == $max_cat_id && $call_status == 1){
            $restart_loop = true;
        }else{
            $restart_loop = false;
        }
/*=====  End of if current cat id = max cat id restart loop condition  ======*/
        if($data != false && $restart_loop == false){
            if($call_status == 0){
                $category_id = '>='.$category_id;
            }else{
                $category_id = '>'.$category_id;
            }
            $cat_query = "SELECT T.CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID IS NOT NULL AND T.UPDATED IS NOT NULL AND T.CATEGORY_ID ".$category_id." AND T.CATEGORY_ID <= 152553 ORDER BY T.CATEGORY_ID ASC"; 
        }else{
            $cat_query = "SELECT T.CATEGORY_ID FROM LZ_BD_CATEGORY_TREE T WHERE T.PARENT_CAT_ID IS NOT NULL AND T.UPDATED IS NOT NULL AND T.CATEGORY_ID >= 40004 AND T.CATEGORY_ID <= 152553 ORDER BY T.CATEGORY_ID ASC"; 
        }
        
        $get_cat = oci_parse($conn, $cat_query);
        // call started at: 23-04-2018  05:35 AM seq id at: 203232961 
        // call started at: 14-05-2018  02:35 AM seq id at: 304662041
        oci_execute($get_cat,OCI_DEFAULT);
        //$data = oci_fetch_array($tab_query, OCI_ASSOC);
        while (($row = oci_fetch_array($get_cat, OCI_BOTH)) != false) {
            $cat_id = $row['CATEGORY_ID'];
            include 'auto_run_script_sold.php';
        }//end category while
?>