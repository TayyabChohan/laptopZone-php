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
        //$conn =  oci_connect('lz_bigData', 's', 'wizmen-pc/ORCL');
        // $con =  oci_connect('laptop_zone', 's', 'wizmen-pc/ORCL');
        $conn =  oci_connect('lz_bigData', 's', '192.168.0.78/LZBIGDATA');
        //$con =  oci_connect('laptop_zone', 's', '192.168.0.78/LZBIGDATA');
        //echo $cat_id=$_POST['cat_id'].PHP_EOL;

        //$cat_query = "SELECT DISTINCT CATEGORY_ID FROM LZ_BD_CATEGORY";
        $cat_query = "SELECT DISTINCT C.CATEGORY_ID FROM LZ_BD_CATEGORY C WHERE C.CATEGORY_ID IN(162)";
        $get_cat = oci_parse($conn, $cat_query);
        oci_execute($get_cat,OCI_DEFAULT);
        //$data = oci_fetch_array($tab_query, OCI_ASSOC);
        while (($row = oci_fetch_array($get_cat, OCI_BOTH)) != false) {
            $cat_id = $row['CATEGORY_ID'];
            include 'auto_run_script_active.php';
        }//end category while
?>