 <?php //$this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="content-wrapper"> -->
    <!-- Content Header (Page header) -->
<!--     <section class="content-header">
      <h1>
        Manifest Uploading

        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php //echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manifest Uploading</li>
      </ol>
    </section> -->
        
    <!-- Main content -->
<!--     <section class="content">
      <div class="row">
        <div class="col-sm-12"> -->
<style>
  svg#barcode {
    width: 220px;
    height: 50px;
    margin-left: -8px;
}
</style>
<script src="<?php echo base_url('assets/dist/js/JsBarcode.all.min.js');?>"></script> 
<svg id="barcode"></svg>        

  <body onload="window.print()">

 <?php

  $audit_bin_id = trim(strtoupper($this->uri->segment(6)));
  $remarks = "";
  $master_barcod = @$data['bar_result'][0]["BARCODE_NO"];

      //var_dump($data);exit;

      if(!empty($master_barcod)){

        $text = @$data['row'][0]["ITEM_DESC"];
        $newtext =implode("<br/>", str_split($text, 40));
        //$newtext = wordwrap($text, 40, "<br>", true);?>



      <!-- onload="window.print()" -->
    
      <div style = "margin-left: -8px!important;margin-top: 0px !important;">
          <Span style="margin:0;width:230px;padding:0;font-size:9px;font-family:arial;font-weight: 600;"><?php echo 
            @$row[0]["BRAND"].'MB:'.@$master_barcod.'<br>'.@$data['row'][0]["MPN"].'<br>'.$newtext.'</span><br><strong style="margin: 0;padding: 0;font-size:16px">'.@$data['row'][0]["EBAY_ITEM_ID"].'</strong><br></div>';


      }else{

        $text = @$data['row'][0]["ITEM_DESC"];
            //var_dump($text); exit;
        $newtext =implode("<br/>", str_split($text, 40));
      //$newtext = wordwrap($text, 40, "<br>", true);?>
      <div style="margin-left: -8px!important;margin-top: 0px !important;">
          <Span style="margin:0;width:230px;padding:0;font-size:9px;font-family:arial;font-weight: 600;"><?php echo 
            @$data['row'][0]["BRAND"].'<br>'.
            @$data['row'][0]["MPN"].'<br>'.
            $newtext.
          '</span><br>
          <strong style="margin: 0;padding: 0;font-size:16px">'.
            @$data['row'][0]["EBAY_ITEM_ID"].
          '</strong><br>
        </div>';
            

      }//else closing

    date_default_timezone_set("America/Chicago");
    $audit_datetime = date("Y-m-d H:i:s");
    $audit_datetime = "TO_DATE('".$audit_datetime."', 'YYYY-MM-DD HH24:MI:SS')";
    $audit_by = $this->session->userdata('user_id');

    if(!empty($this->uri->segment(5))){
      $barcode = $this->uri->segment(5); 

        // for New entered Bin
      $bin_id_qry = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, B.BIN_TYPE || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_NAME = '$audit_bin_id'");
      $result = $bin_id_qry->result_array();
      $new_bin_id = @$result[0]['BIN_ID'];

      /*==== Bin Assignment to item barcode start ====*/
      $current_bin_qry = $this->db->query("SELECT MT.BIN_ID FROM LZ_BARCODE_MT MT WHERE MT.BARCODE_NO = $barcode");
      $bin_result = $current_bin_qry->result_array();
      $old_loc_id = @$bin_result[0]['BIN_ID'];


      $this->db->query("UPDATE LZ_BARCODE_MT SET EBAY_STICKER = 1, AUDIT_DATETIME = $audit_datetime, AUDIT_BY = $audit_by, BIN_ID = '$new_bin_id' WHERE BARCODE_NO = $barcode");


        if(!(empty($new_bin_id))){

                $log_id_qry = $this->db->query("SELECT GET_SINGLE_PRIMARY_KEY('LZ_LOC_TRANS_LOG','LOC_TRANS_ID') ID FROM DUAL"); 
                $rs = $log_id_qry->result_array();
                $loc_trans_id = @$rs[0]['ID'];              

            $this->db->query("INSERT INTO LZ_LOC_TRANS_LOG (LOC_TRANS_ID, TRANS_DATE_TIME, BARCODE_NO, TRANS_BY_ID, NEW_LOC_ID, OLD_LOC_ID, REMARKS, OLD_ROW_ID, NEW_ROW_ID) VALUES($loc_trans_id, $audit_datetime, $barcode, $audit_by, '$new_bin_id', '$old_loc_id', '$remarks',null,null)"); 

        }
        
    }

?>

</body>
        <!-- </div> -->
        <!-- /.col -->
      <!-- </div> -->
      <!-- /.row -->
    <!-- </section> -->
    <!-- /.content -->
  <!-- </div>     -->
<!-- End Listing Form Data -->     
<?php //$this->load->view('template/footer'); ?>
<script>
  JsBarcode("#barcode", "<?php echo @$data['row'][0]["EBAY_ITEM_ID"];?>", {
    format: "CODE128",
     // lineColor: "#0aa",
    width: 5,
     // height: 60,
    displayValue: false
  });
</script> 
