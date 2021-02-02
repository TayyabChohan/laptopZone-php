<?php
//include("custom.css");
$con =  oci_connect('laptop_zone', 's', 'wizmen-pc/WIZDB') or die ('Error connecting to oracle');
$list_id = $this->session->userdata('list_id');
$qry = "SELECT DISTINCT MD.ITEM_MT_BBY_SKU,MM.PURCH_REF_NO,MD.ITEM_MT_MANUFACTURE BRAND,MD.ITEM_MT_MFG_PART_NO MPN,T.EBAY_ITEM_DESC ITEM_DESC,T.EBAY_ITEM_ID,'*' || T.EBAY_ITEM_ID || '*' BAR_CODE FROM EBAY_LIST_MT T, ITEMS_MT IM, LZ_MANIFEST_DET MD, LZ_MANIFEST_MT MM WHERE T.ITEM_ID = IM.ITEM_ID AND IM.ITEM_CODE = MD.LAPTOP_ITEM_CODE AND MM.LZ_MANIFEST_ID = MD.LZ_MANIFEST_ID AND T.LIST_ID =".$list_id;
$result = oci_parse($con,$qry);
		  //var_dump($result);exit;
		  $rsl = oci_execute($result, OCI_DEFAULT);
		  //die(oci_execute($result, OCI_DEFAULT));
		  $row = oci_fetch_array($result,OCI_ASSOC);
echo "<html><body style='margin: 0;
        padding: 0;
        border: 0;
        outline: 0;
        font-size: 100%;
        vertical-align: baseline;
        background: transparent;'><div style='margin: 0;width:216px;padding: 0;'>";
        $text = "?text=*";
?>
<img style='margin-bottom:3px;' alt='testing' src='<?php echo base_url("/listing/listing/barcode");?><?php echo $text.$row["EBAY_ITEM_ID"];?>' />
<?php

        echo "<br><Span style='margin: 0;width:216px;padding: 0;font-size:13px;font-family:arial;'>".
$row['BRAND']."<br>".
$row['MPN']."<br>".
$row['ITEM_DESC']."</span><br><strong style='margin: 0;padding: 0;font-size:18px'>".
$row['EBAY_ITEM_ID']."</strong><br></div></body></html>";
//<script>window.print()</script>";
//echo "<input type='button' value='Print This Page' onClick='window.print()' />";


?>
