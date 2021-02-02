<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle; ?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $pageTitle; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <!--<div class="col-sm-2">
              <label>Search Filter:</label>
            </div>-->
            <!-- <form action="<?php //echo base_url(); ?>shipment/awaiting_shipment/awt_search" method="post"> -->
            <div class="col-sm-4 tt">
                   <?php
                   foreach ($sellers as $acct) {
                    $url = base_url()."cron_job/c_cron_job/downloadOrders/".$acct['LZ_SELLER_ACCT_ID'];
                    ?>
                    <a href="<?php echo $url; ?>" class="btn btn-default getSellerOrders" target="_blank"><?php echo  $acct['SELL_ACCT_DESC'];?></a>

                    <!-- <input type="button" id="downloadOrders" account_id ="<?php //echo  $acct['LZ_SELLER_ACCT_ID'];?>" title="Download Orders" class="btn btn-default downloadOrders" name="downloadOrders" value="<?php //echo  $acct['SELL_ACCT_DESC'];?>"> -->
<?php
//break;
                   }// end foreach
                   ?>      
                    <input type="button" id="downloadOrders" title="Download Orders" class="btn btn-default" name="downloadOrders" value="ALL">
            </div>

            <!-- <div class="col-sm-3">
              <label for="">Get Orders:</label>
              <input type="button" id="downloadOrders" title="Get Awaiting Shipment Orders" class="btn btn-default" name="downloadOrders" value="Pull Orders">
            </div> -->
            <!-- <div class="col-sm-3">
              <label for="">Update Orders:</label>
              <input type="button" id="UpdateOrders" class="btn btn-default" name="UpdateOrders" value="Update">
            </div> -->             
            <!-- </form> -->
            </div>
          </div>        

          <!-- <div class="box"> -->
            <!-- <div class="box-header">
              <h3 class="box-title">Awaiting Shipment</h3>

            </div> -->
            <!-- /.box-header -->
            <!-- <div class="box-body form-scroll">
            </div> -->
            <!-- /.box-body -->
          <!-- </div> -->
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-sm-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Single Order Download | Update</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <!--<div class="col-sm-2">
              <label>Search Filter:</label>
            </div>-->
            <!-- <form action="<?php //echo base_url(); ?>shipment/awaiting_shipment/awt_search" method="post"> -->
            <div class="col-sm-3">
              
                <select class="selectpicker" name="seller_id" id="seller_id" data-live-search="true">
                   <?php
                   foreach ($sellers as $acct) {
                    $url = $acct['LZ_SELLER_ACCT_ID'];
                    ?>
                    
                      <option value="<?php echo $url;?>"><?php echo  $acct['SELL_ACCT_DESC'];?></option>
                    
<?php
//break;
                   }// end foreach

                   ?>      
                   </select>
            </div>
            <div class="col-sm-4">
              <!-- <label for="for input" class="control-label">Order Id:</label> -->
                    <input type="text" id="input_order" placeholder="Enter Order ID format xx-xxxxx-xxxxx" title="Enter Order ID" class="form-control" name="input_order" value="">
            </div>
            <div class="col-sm-1">
                    <input type="button" id="searchOrder" title="Search Order" class="btn btn-default" name="searchOrder" value="Search">
            </div>

            </div>
          </div>        

        </div>
        <!-- /.col -->
        <div class="col-sm-12 responce-div">
        </div>


      </div>
      <!-- /.row -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <!-- /.content -->
  </div>  

<?php $this->load->view('template/footer');?>
<script type="text/javascript">
  $("#downloadOrders").click(function(){
    //$('.getSellerOrders').click();
    $(".tt a").each(function() {
    //Do your work   
    window.open(this.href, '_blank');
    //var hrefl=$(this).attr('href');
    console.log(this.href);
});
//    return false;

    //$(".loader").show();
    // $.ajax({

    //   url: '<?php //echo base_url(); ?>cron_job/c_cron_job/downloadOrders',
    //   type: 'POST',
    //   datatype : "json",
    //   data: {'accountId':accountId},
     
    //    success: function (data) {
    //     $(".loader").hide();
    //     return false;

    //     window.location.reload();     
    //    }

    //    }); 

  });

  $("#searchOrder").click(function(){
   var sellerId =  $('#seller_id').val();
   var input_order =  $('#input_order').val().trim();
   if(input_order.length <14){
    alert("In-valid Input. Order id must be Atleast 14 in or more length.");
    $('#input_order').focus();
    return false;

   }
// console.log(input_order.length);
//     return false;

    $(".loader").show();
    $.ajax({

      url: '<?php echo base_url(); ?>cron_job/c_cron_job/getSingleOrderById',
      type: 'POST',
      datatype : "json",
      data: {'seller_id':sellerId,'order_id':input_order},
     
       success: function (data) {
        $(".loader").hide();

           $('.responce-div').html(data);
           //alert(data);
       }

       }); 

  });
</script>