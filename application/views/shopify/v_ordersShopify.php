<?php $this->load->view('template/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Shopify Orders Details
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Shopify Orders Details</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Shopify Orders Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-sm-12">
                <div class="col-sm-10"></div>
                <div class="col-sm-2">
                  <div class="form-group pull-right">
                    <input type="button" id="getAllOrders" name="getAllOrders" class="btn btn-md btn-success" value="Get All Orders">
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                  <div id="successMsg" class="alert alert-success" style="display:none"></div>
                  <div id="errorMsg" class="alert alert-error" style="display:none"></div>
                  <!-- <div id="duplicateMsg" class="alert alert-warning" style="display:none"></div> -->
              </div>              
              <div class="col-sm-12">
                <table id="shopifyOrders" class="table table-bordered table-striped table-responsive">
                  <thead>
                    <tr>
                      <th>Order Number</th>
                      <th>Date</th>
                      <th>Customer</th>
                      <th>Payment Status</th>
                      <th>Fulfillment Status</th>
                      <th>SKU</th>
                      <th>Order Quantity</th>
                      <th>Total</th>
                      <th>Check Availability</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $i = 1;
                  foreach ($orders as $value) {?>
                    <tr>
                      <td><?php echo @$value["ORDER_ORDER_NUMBER"]; ?></td>
                      <td><?php echo @$value["ORDER_CREATED_AT"]; ?></td>
                      <td><?php echo @$value["BILLING_ADDRESS_NAME"]; ?></td>
                      <td><?php echo @$value["ORDER_FINANCIAL_STATUS"]; ?></td>
                      <td>
                        <?php
                          $fulfillment_status = $value["ORDER_FULFILLMENT_STATUS"];
                          if(empty($fulfillment_status)){
                            echo "Unfulfilled";
                          }
                        ?>
                      </td>
                      <td><div id="line_items_sku_<?php echo $i; ?>"><?php echo @$value["LINE_ITEMS_SKU"]; ?></div></td>
                      <td><div id="line_items_quantity_<?php echo $i; ?>"><?php echo @$value["LINE_ITEMS_QUANTITY"]; ?></div></td>
                      <td><?php echo '$ '.number_format((float)@$value["ORDER_TOTAL_PRICE"],2,'.','');?></td>
                      <td>
                        <input type="button" id="<?php echo $i; ?>" name="checkAvailability" class="btn btn-md btn-primary checkAvailabilityBtn" value="Check on eBay">
                        <div id="sMsg_<?php echo $i; ?>" class="alert alert-success" style="width: 200px;display:none;margin-top: 5px;"></div>
                        <div id="eMsg_<?php echo $i; ?>" class="alert alert-error" style="width: 200px;display:none;margin-top: 5px;"></div>
                        <div id="wMsg_<?php echo $i; ?>" class="alert alert-warning" style="width: 200px;display:none;margin-top: 5px;"></div>
                      </td>
                    </tr>
                  <?php  
                  $i++;
                  } 
                  ?>

                  </tbody>
                  
                </table>

                                
              </div>
            </div>  
          </div>
          <!-- /.col -->
          <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
              <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="Please Wait" style="width: 100px; height: 100px;">
          </div>        
        </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
    $('#shopifyOrders').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });

    $('#getAllOrders').click(function() {
        $(".loader").show();

        $.ajax({
            url: '<?php echo base_url('shopify/c_ordersShopify/getAllShopifyOrders'); ?>',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                //console.log(data);
                console.log(data+" success");

            },
            complete: function(data){
              console.log(data+" Complete");
                $(".loader").hide();
                if(data){
                    $("#successMsg").html("Orders are successfully imported.").fadeIn(800);
                    $('#successMsg').delay(5000).fadeOut('slow');
                    //location.reload();
                }else{
                    $("#errorMsg").html("Error! There is something missing, Contact your Administrator.").fadeIn(800);
                    $('#errorMsg').delay(5000).fadeOut('slow');
                } 
            }
        });
    });

    $('.checkAvailabilityBtn').click(function() {
        var rowId = $(this).attr('id');
        //alert(rowId); return false;

        var line_items_sku = $("#line_items_sku_"+rowId).text();
        var line_items_quantity = $("#line_items_quantity_"+rowId).text();
        //console.log(line_items_sku, line_items_quantity);
        //return false;
        $(".loader").show();
        $.ajax({
            url: '<?php echo base_url('shopify/c_ordersShopify/checItemoneBay'); ?>',
            type: 'POST',
            data: {
                line_items_sku: line_items_sku, line_items_quantity: line_items_quantity
            },
            dataType: 'json',
            success: function(data) {
                $(".loader").hide();
                console.log(data+" success");
                if(data === 0){
                    $("#wMsg_"+rowId).html("Item was sold or ended from eBay.").fadeIn(800);
                    $("#wMsg_"+rowId).delay(5000).fadeOut('slow');
                }else if(data === 1){
                    $("#wMsg_"+rowId).html("Item is ended on eBay.").fadeIn(800);
                    $("#wMsg_"+rowId).delay(5000).fadeOut('slow');
                }else if(data === 2){
                    //alert("Item is successfully revised on eBay.");
                    $("#sMsg_"+rowId).html("Item is successfully revised on eBay.").fadeIn(800);
                    $("#sMsg_"+rowId).delay(5000).fadeOut('slow');                    
                }else if(data === 3){
                    $("#eMsg_"+rowId).html("Unable to Revise an item. Contact your Administrator.").fadeIn(800);
                    $("#eMsg_"+rowId).delay(5000).fadeOut('slow');                  
                } 
            },
            complete: function(data){
                //$(".loader").hide();
                console.log(data+" complete");


            }
        });
    });
</script>