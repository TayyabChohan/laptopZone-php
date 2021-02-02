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
        $cat_query = "SELECT KEYWORD,CATEGORY_ID,CATLALOGUE_MT_ID,FEED_URL_ID FROM LZ_BD_RSS_FEED_URL WHERE KEYWORD IS NOT NULL AND CATLALOGUE_MT_ID IS NOT NULL AND FEED_TYPE = 30 AND FEED_URL_ID  IN (SELECT DISTINCT U.FEED_URL_ID FROM LZ_MANIFEST_DET@ORASERVER MD, ITEMS_MT@ORASERVER I, LZ_BARCODE_MT@ORASERVER B, LZ_BD_RSS_FEED_URL U, (SELECT D.LZ_ESTIMATE_DET_ID, D.TECH_COND_ID,D.PART_CATLG_MT_ID FROM LZ_BD_PURCHASE_OFFER T, LZ_BD_ESTIMATE_MT    E, LZ_BD_ESTIMATE_DET   D WHERE T.LZ_BD_CATA_ID = E.LZ_BD_CATAG_ID AND T.WIN_STATUS = 1 AND D.LZ_BD_ESTIMATE_ID = E.LZ_BD_ESTIMATE_ID) T WHERE MD.EST_DET_ID = T.LZ_ESTIMATE_DET_ID AND MD.LAPTOP_ITEM_CODE = I.ITEM_CODE AND B.ITEM_ID = I.ITEM_ID AND B.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND B.CONDITION_ID = T.TECH_COND_ID AND B.EBAY_ITEM_ID IS NULL AND U.CATLALOGUE_MT_ID = T.PART_CATLG_MT_ID AND U.CONDITION_ID = T.TECH_COND_ID) ORDER BY FEED_URL_ID ASC";
        $get_cat = oci_parse($conn, $cat_query);
        oci_execute($get_cat,OCI_DEFAULT);
        //$data = oci_fetch_array($tab_query, OCI_ASSOC);
        while (($row = oci_fetch_array($get_cat, OCI_BOTH)) != false) {
            $cat_id = $row['CATEGORY_ID'];
            include 'auto_run_script_sold_kw.php';
        }//end category while
?>