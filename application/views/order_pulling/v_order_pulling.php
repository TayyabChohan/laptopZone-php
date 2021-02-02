<?php $this->load->view("template/header.php"); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <div class="row">
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
      <!-- Order pulling Section start -->
      <div class="col-sm-12">
        <div class="box">

          <div class="box-header with-border">
            <h3 class="box-title">Order Pulling</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Barcode" class="control-label">Barcode | eBay ID:</label>
                        <input type="number" class="form-control" id="pull_barcode" name="pull_barcode">
                    </div>
                  </div>                  
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Puller Name" class="control-label">Puller Name:</label>
                      <?php $emp_name = $this->session->userdata('employee_name');?>
                        <input type="text" class="form-control" id="puller_name" name="puller_name" value="<?php echo $emp_name;?>" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label for="Order Qty" class="control-label">Order Qty:</label>
                      <input type="number" class="form-control" id="order_qty" name="order_qty" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label for="Pull Qty" class="control-label">Pull Qty:</label>
                      <input type="number" class="form-control" id="pull_qty" name="pull_qty" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Pull Qty" class="control-label">Cancel Qty:</label>
                        <input type="number" class="form-control" id="cancel_qty" name="cancel_qty" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label for="So No" class="control-label">Order No:</label>
                      <input type="text" class="form-control order_no" id="order_no" name="order_no" value="" readonly> 
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Purchase Date" class="control-label">Pulling/Cancel DateTime:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                          <input type="text" class="form-control" id="date_time" name="date_time" value="" readonly>
                      </div>
                    </div>              
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Sale Date" class="control-label">Sale Date:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                          <input type="text" class="form-control" id="sale_date" name="sale_date" value="" readonly>
                      </div>
                    </div>
                  </div>                 
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Bin Location" class="control-label">Bin Location:</label>
                        <input type="text" class="form-control" id="bin_location" name="bin_location" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label for="Already Pull Qty" class="control-label">Already Pull Qty:</label>
                      <input type="text" class="form-control" id="alrdy_pull_qty" name="alrdy_pull_qty" value="" readonly>

                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label for="Already Cancel Qty" class="control-label">Already Cancel Qty:</label>
                      <input type="text" class="form-control" id="alrdy_cancel_qty" name="alrdy_cancel_qty" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="eBay ID" class="control-label">eBay ID:</label>
                      <input type="text" class="form-control" id="ebay_id" name="ebay_id" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="Item Desc" class="control-label">Item Desc:</label>
                      <input type="text" class="form-control" id="Item_desc" name="Item_desc" value="" readonly>
                    </div>
                  </div> 
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="scanned_barcode" class="control-label">Barcode No:</label>
                      <input type="text" class="form-control" id="scanned_barcode" name="scanned_barcode" value="" readonly>
                    </div>
                  </div>
                  <div class="col-sm-1 p-t-24">
                    <div class="form-group">
                      <input type="button" id="GetOrders" title="Pull Selected Account Orders" class="btn btn-primary" name="GetOrders" value="Pull Orders">
                    </div>
                  </div>
                  <div class="col-sm-1 p-t-24">
                    <div class="form-group ">
                      <input type="button" id="GetOrdersAll" title="Pull All Latest Orders from eBay" class="btn btn-danger" name="GetOrdersAll" value="Pull All Orders">
                    </div>
                  </div>
                </div><!-- col-sm-12 close -->
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="puller_bin" class="control-label">Puller Bin:</label>
                      <input type="text" class="form-control" id="puller_bin" name="puller_bin" value="" placeholder="Scan Bin Barcode">
                    </div>
                  </div>
                </div>            
                                            
                <div class="col-sm-12 buttn_submit">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <button type="button" id="pull" name="pull" class="btn btn-success pull_cancel">Pull</button>
                      <button type="button" id="cancel" name="cancel" class="btn btn-primary pull_cancel m-l-5">Cancel Order</button>
                      <input type="button" id="reset" onclick="return clearForm()" title="Clear All" class="btn btn-warning m-l-5" name="reset" value="Reset">
                    </div>
                  </div>
                  <div class="col-sm-9 ">
                    <div class="form-group pull-right">
                      <a style="text-decoration: underline;" href="<?php echo base_url('order_pulling/c_order_pulling/pulled_data'); ?>" target="_blank">Pulled Data</a>
                      &nbsp;&nbsp; | &nbsp;&nbsp;
                      <a style="text-decoration: underline;" href="<?php echo base_url('order_pulling/c_order_pulling/partial_data'); ?>" target="_blank">Partially Pulled Data</a>
                    </div>
                  </div>
                </div>
              </div><!-- row close -->
        </div> <!-- box body close -->
   
       </div> <!-- /.box -->
      </div><!-- col-sm-12 close -->
      <!-- Order pulling Section end -->

      <!-- Order pulling summary start -->
      <div class="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Order Summary</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <?php
          $checked = $this->session->userdata('awaiting');
          $this->session->unset_userdata('awaiting');

          ?>
          <div class="box-body">
              <form action="<?php echo base_url('order_pulling/c_order_pulling'); ?>" method="post">
                <div class="col-sm-4" style="margin-top: 15px;">
                  <input type='radio' name='awaiting' value='2' <?php if($checked == 2){echo 'checked';} ?>>&nbsp;Dfwonline&nbsp;
                  <input type='radio' name='awaiting' value='1' <?php if($checked == 1){echo 'checked';} ?>>&nbsp;Techbargain&nbsp;
                  <input type='radio' name='awaiting' value='All' <?php if($checked == 'All' || empty($checked)){echo 'checked';} ?>>&nbsp;All
                </div>
                <div class="col-sm-2" style="margin:15px 0px;">
                  <input class="btn btn-primary" title="Search Orders" type="submit" name="Submit" value="Search">
                </div>
              </form>

            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Total Orders</th>
                  <th>Dfwonline</th>
                  <th>Techbargain</th>
                </tr>  
              </thead>
              <tbody>
              <?php $summary['total_dfw'][0]['TOTAL_DFW'] ?>
                <tr>
                  <td><?php echo (@$summary['total_dfw'][0]['TOTAL_DFW'] + @$summary['total_tech'][0]['TOTAL_TECH']);?></td>
                  <td><?php echo @$summary['total_dfw'][0]['TOTAL_DFW'];?></td>
                  <td><?php echo @$summary['total_tech'][0]['TOTAL_TECH'];?></td>
                </tr>
              </tbody>
            </table> 
          </div><!-- box body close -->
        </div> <!-- /.box -->
      </div> <!-- col-sm-12 close -->
      <!-- Order pulling summary end -->

      <!-- Order pulling Detail start -->
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Order Detail</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        
        <div class="box-body">
          <div class="form-scroll">
            <table id="OrderPulling" class="table table-bordered table-hover">
                    <thead>

                      <tr>
                        <th>ACTION</th>
                        <th>BARCODE</th>
                        <th>SALES RECORD</th>
                        <th>EBAY ITEM ID</th>
                        <th>ITEM DESC</th>
                        <th>ORDER QTY</th>
                        <th>PULL QTY</th>
                        <th>CANCEL QTY</th>
                        <th>SALE DATE</th>
                        <th>SALE PRICE</th>
                        <th>TOTAL PRICE</th>
                        <th>USER NAME</th>
                        <th>ITEM LOCATION</th>
                        <th>ITEM PACKING</th>
                        <!-- <th>WIZ ERP CODE</th>
 -->
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($awaiting_pull as $awaiting_order):
                      if(!empty(@$awaiting_order['PACKING_NAME'])){
                          $tr_class = 'class="packing-txt"';
                        }else{
                          $tr_class      = ''; 
                        } 
                        if(!empty(@$awaiting_order['BARCODE_NO'])){
                          $pull_id = @$awaiting_order['BARCODE_NO'];
                        }else{
                          $pull_id = @$awaiting_order['ITEM_ID'];
                        }
                        ?>
                      <tr <?php echo $tr_class; ?>>
                        <td>
                        <!-- <div style="width: 80px;"> -->
                          
                            <button title="Cancel Order" class="btn btn-danger btn-xs pull_cancel_t" style="" name="cancel" id="<?php echo $pull_id; ?>"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button>
                          
                          <div style="margin-right:7px;float: left;">
                            <button title="Pull Order" class="btn btn-primary btn-xs pull_cancel_t" style="" name="pull" id="<?php echo $pull_id; ?>"><i class="fa fa-download" aria-hidden="true"></i></button>
                          </div>
                        <!-- </div> -->
                        </td>
                        <td style="color: red!important;"><?php echo @$awaiting_order['BARCODE_NO'];?></td>
                        <td><?php echo @$awaiting_order['SALES_RECORD_NUMBER'];?></td>
                        <td><?php echo @$awaiting_order['ITEM_ID'];?></td>
                        <td><?php echo @$awaiting_order['ITEM_TITLE'];?></td>
                        <td><?php echo @$awaiting_order['QUANTITY'];?></td>
                        <td><?php echo @$awaiting_order['PULLING_QTY'];?></td>
                        <td><?php echo @$awaiting_order['CANCEL_QTY'];?></td>
                        <td><?php echo @$awaiting_order['SALE_DATE'];?></td>
                        <td><?php echo '$ '.number_format((float)@$awaiting_order['SALE_PRICE'],2,'.',','); ?></td>
                        <td><?php echo '$ '.number_format((float)@$awaiting_order['TOTAL_PRICE'],2,'.',',');?></td>
                        <td><?php echo @$awaiting_order['USER_ID'];?></td>
                        <td style="color: white!important; background-color: #468ebc;"><?php echo @$awaiting_order['BIN_NAME'];?></td>
                        <td><?php echo @$awaiting_order['PACKING_NAME'];?></td>
                        <!-- <td><?php //echo @$awaiting_order['BUYER_ZIP'];?></td> -->

                      </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
          </div>
        </div><!-- box body End -->
      </div><!-- box End -->
      <!-- pulled data Section End -->            
    </div> <!-- col-sm-12 close -->
      <!-- Order pulling Detail end -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
  </div> <!-- /.content -->
  </div> <!-- /.row -->

<?php $this->load->view("template/footer.php"); ?>
<script>
    $('#OrderPulling').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 500,
    "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    //"iDisplayLength": 100,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "fixedHeader": true,
      "order": [[ 2, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });  

// fetch data against eBay ID on Order pulling screen
// onblur eBay id request
//$("#pull_barcode").keydown(function(){
$("#pull_barcode").blur(function(){
  /*=============================================
  =            reset all value first            =
  =============================================*/
  $("#ebay_id").val(null);
  $('#order_qty').val(null);
  $('#pull_qty').val(null);
  $('#cancel_qty').val(null);
  $("#weight").val(null); 
  $("#order_no").val(null);
  $('#date_time').val(null);
  $('#sale_date').val(null);
  $('#alrdy_pull_qty').val(null);
  $("#alrdy_cancel_qty").val(null); 
  $("#Item_desc").val(null);
  
  /*=====  End of reset all value first  ======*/
  

  var pull_barcode = $("#pull_barcode").val();
  if (pull_barcode.trim() == null || pull_barcode.trim() == ""){
    alert("Please insert a valid eBay ID | Barcode");return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>order_pulling/c_order_pulling/get_data',
      data: { 'pull_barcode' : pull_barcode},
     success: function (data) {
       if(data != '' ){
        //var OrderNo = data.sale_data[0].SALES_RECORD_NUMBER;
// alert(data);return false;
        if(data == 'Not_Found'){
          alert('Barcode of this item is Already Consumed');return false;
        }else if(data == 'Not_Listed'){
          alert('Item is not listed.');return false;
        }else if (data == 'Already_Pulled'){
          alert('Item is already pulled.');return false;
        }else{

          if(data.sale_data == ""){
            alert("No Item order found against eBay ID: " + pull_barcode);return false;
          }else{

            //console.log(data.scanned_barcode);return false;
            $('#alrdy_pull_qty').val(data.already_qry[0].ALREADY_PULL_QTY);
            $('#alrdy_cancel_qty').val(data.already_qry[0].ALREADY_CANCEL_QTY);
            $('#order_qty').val(data.sale_data[0].QUANTITY);
            $('#Item_desc').val(data.sale_data[0].ITEM_TITLE);
            $('#sale_date').val(data.sale_data[0].SALE_DATE);
            $('.order_no').val(data.sale_data[0].SALES_RECORD_NUMBER);
            $('#weight').val(data.weight_qry);   
            $('#ebay_id').val(data.sale_data[0].EBAY_ITEM_ID);  
            $('#scanned_barcode').val(data.scanned_barcode[0]);
            var bin_location = data.bin_location_qry[0].BIN_LOCATION;            
            if( bin_location != null || bin_location != undefined){
              $('#bin_location').val(data.bin_location_qry[0].BIN_LOCATION);  
            }
                        
          }

       }
     }
     }
    }); 
 });
// fetch data against eBay ID on Order pulling screen
// pull or canlce order request
$(".pull_cancel").click(function(){
  var action = this.id;
  var ebay_id = $("#ebay_id").val();
  var pull_barcode = $("#pull_barcode").val();
  var puller_name = $("#puller_name").val();
  var weight = $("#weight").val();
  var order_no = $("#order_no").val();
  var scanned_barcode = $("#scanned_barcode").val();
  var puller_bin = $("#puller_bin").val().trim();
  // if(puller_bin === '' && action == 'pull'){
  //   alert('Please Enter Puller Bin.');
  //   $("#puller_bin").focus();
  //   return false;
  // }

      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>order_pulling/c_order_pulling/pull_cancel',
        data: { 
          'ebay_id' : ebay_id,
          'pull_barcode' : pull_barcode,
          'puller_name' : puller_name,
          'weight' : weight,
          'order_no' : order_no,
          'action' : action,
          'puller_bin' : puller_bin,
          'scanned_barcode' : scanned_barcode
          

      },
       success: function (data) {
         if(data != ''){

          //alert(data[0].PULLING_QTY);return false;
          $('#pull_qty').val(data[0].PULLING_QTY);
          $('#date_time').val(data[0].PULLING_DATE);
          $('#cancel_qty').val(data[0].CANCEL_QTY);
          

         }
       }
      }); 
 });

function clearForm() {
    var x  = $("#ebay_id").val();
    // var x  = $("#pull_qty").val();
    // var x  = $("#pull_qty").val();
    //alert(x);
    if (x != null) {
        $("#ebay_id").val(null);
        $('#order_qty').val(null);
        $('#pull_qty').val(null);
        $('#cancel_qty').val(null);
        $("#weight").val(null); 
        $("#order_no").val(null);
        $('#date_time').val(null);
        $('#sale_date').val(null);
        $('#alrdy_pull_qty').val(null);
        $("#alrdy_cancel_qty").val(null); 
        $("#Item_desc").val(null);
        $("#bin_location").val(null);
        $("#scanned_barcode").val(null);
      
    }
} 

var table = $('#OrderPulling').DataTable();
 
$('#OrderPulling tbody tr').on( 'click', '.pull_cancel_t', function () {
      var data = table.row( $(this).parents('tr') ).data();
      var action           = $(this).attr("name");
      var this_tr = $(this).closest('tr');
      var pull_barcode = this.id;
      var scanned_barcode = data[1];
      var order_no = data[2];
      var ebay_id = data[3];
      var item_desc = data[4];
      //var pull_barcode = $("#pull_barcode").val();
      var puller_name = $("#puller_name").val();
      var weight = '';
      //var order_no = $("#order_no").val();
      //var scanned_barcode = $("#scanned_barcode").val();
      var puller_bin = $("#puller_bin").val().trim();

      //console.log(action,pull_barcode,barcode,order_no,ebay_id,item_desc,puller_name);

      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>order_pulling/c_order_pulling/pull_cancel',
        data: { 
          'ebay_id' : ebay_id,
          'pull_barcode' : pull_barcode,
          'puller_name' : puller_name,
          'weight' : weight,
          'order_no' : order_no,
          'action' : action,
          'puller_bin' : puller_bin,
          'scanned_barcode' : scanned_barcode
          

      },
       success: function (data) {
         if(data != ''){

          //alert(data[0].PULLING_QTY);return false;
          $('#pull_qty').val(data[0].PULLING_QTY);
          $('#date_time').val(data[0].PULLING_DATE);
          $('#cancel_qty').val(data[0].CANCEL_QTY);

          this_tr.fadeOut(1000, function () {
          table.row(this_tr).remove().draw()

          });


         }
       }
      }); 
} ); 
/*=====================================================================
=            pull cancle order from datatable button click            =
=====================================================================*/
$(".pull_cancel_tt").click(function(){
  var action           = $(this).attr("name");
  var pull_barcode = this.id; //  barcode or ebay id
  var ebay_id = $("#ebay_id").val();
  var pull_barcode = $("#pull_barcode").val();
  var puller_name = $("#puller_name").val();
  var weight = $("#weight").val();
  var order_no = $("#order_no").val();
  var scanned_barcode = $("#scanned_barcode").val();
  var puller_bin = $("#puller_bin").val().trim();
  // if(puller_bin === '' && action == 'pull'){
  //   alert('Please Enter Puller Bin.');
  //   $("#puller_bin").focus();
  //   return false;
  // }

      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>order_pulling/c_order_pulling/pull_cancel',
        data: { 
          'ebay_id' : ebay_id,
          'pull_barcode' : pull_barcode,
          'puller_name' : puller_name,
          'weight' : weight,
          'order_no' : order_no,
          'action' : action,
          'puller_bin' : puller_bin,
          'scanned_barcode' : scanned_barcode
          

      },
       success: function (data) {
         if(data != ''){

          //alert(data[0].PULLING_QTY);return false;
          $('#pull_qty').val(data[0].PULLING_QTY);
          $('#date_time').val(data[0].PULLING_DATE);
          $('#cancel_qty').val(data[0].CANCEL_QTY);
          

         }
       }
      }); 
 });
  // Get Awaiting Order Refresh
  $("#GetOrdersAll").click(function(){
    $(".loader").show();
    $.ajax({

      url: '<?php echo base_url(); ?>listing/listing/getAllOrders',
      type: 'POST',
      datatype : "json",
     
       success: function (data) {
        $(".loader").hide();

        window.location.reload();     
       }

       }); 

  });

/*=====  End of pull cancle order from datatable button click  ======*/

</script>