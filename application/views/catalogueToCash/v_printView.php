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
      foreach($data as $row){
        $barcode_no = @$row["BARCODE_PRV_NO"];
     ?>    

        <div style = "margin-left: -8px!important;margin-top: 0px !important;">
          <!-- <div style="width:222px !important;" class="barcodecell"><img src="<?php //echo base_url('assets/barcode/barcode.php');?>?text=<?php //echo @$row["BARCODE_PRV_NO"]; ?>" alt="Barcode No" width="200" height="38"></div> -->
            <div style="margin-top:6px !important;width:222px;padding:0;font-size:10px;font-family:arial;">
              <span><b><?php echo 
                @$row["BARCODE_PRV_NO"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>'.
                @$row["OBJECT_NAME"].'</u></b><br><span style="margin-top:3px!important; font-size:9px!important;font-family:arial;">'.
                @$row["COND_NAME"].'</span><br><strong>UPC:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                .@$row["CARD_UPC"].'</strong><br><strong>MPN:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
                @$row["CARD_MPN"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.@$row["SKU"].'</strong>'.'</span></div></div>';

      }?>

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
    JsBarcode("#barcode", "<?php echo @$barcode_no; ?>", {
      format: "CODE128",
       // lineColor: "#0aa",
      width: 5,
       // height: 60,
      displayValue: false
    });
  </script> 
