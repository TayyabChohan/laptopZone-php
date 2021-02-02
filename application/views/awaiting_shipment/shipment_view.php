<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Awaiting Shipment
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Awaiting Shipment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <!--<div class="col-sm-2">
              <label>Search Filter:</label>
            </div>-->
            <!-- <form action="<?php //echo base_url(); ?>shipment/awaiting_shipment/awt_search" method="post"> -->
            <div class="col-sm-4">
              <?php 
              $awt_radio = $this->session->userdata('awt');
                if($awt_radio == 2){
                  echo "<input type='radio' name='awt' value='2' checked>&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both'>&nbsp;Both";
                    //$this->session->unset_userdata('awt');
                }elseif($awt_radio == 1){
                  echo "<input type='radio' name='awt' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1' checked>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both' >&nbsp;Both";
                    //$this->session->unset_userdata('awt');

                }elseif($awt_radio == 'Both'){
                  echo "<input type='radio' name='awt' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both' checked>&nbsp;Both";
                    //$this->session->unset_userdata('awt');

                }else{
                  echo "<input type='radio' name='awt' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both' checked>&nbsp;Both";
                }
                ?>
                <!-- <input type='radio' name='awt' value='Dfwonline' checked>&nbsp;Dfwonline&nbsp;
                <input type='radio' name='awt' value='Techbargain'>&nbsp;Techbargain&nbsp;
                <input type='radio' name='awt' value='Both'>&nbsp;Both -->
             
            </div>

            <div class="col-sm-2">
              <input class="btn btn-primary" title="Search Awaiting Shipment Orders" id="search_shipment" type="submit" name="Submit" value="Search">
               <input type="hidden" name="searchShipmentData" id="searchShipmentData" value="<?php if(!empty(@$search_shipment)){echo @$search_shipment; }elseif(!empty($this->session->userdata('awt'))){ echo $this->session->userdata('awt'); }else{ echo ""; } ?>">
            </div>
       
             <!-- </form> -->
            <!--  <div class="col-sm-4">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="button" class="btn btn-default" name="daterange-btn" id="daterange-btn">
                    </div>
                  </div>
                </div> -->

            <div class="col-sm-3">
              <label for="">Get Orders:</label>
              <input type="button" id="GetOrders" title="Get Awaiting Shipment Orders" class="btn btn-default" name="GetOrders" value="Pull Orders">
            </div>
            <!-- <div class="col-sm-3">
              <label for="">Update Orders:</label>
              <input type="button" id="UpdateOrders" class="btn btn-default" name="UpdateOrders" value="Update">
            </div> -->             
            <!-- </form> -->
            </div>
          </div>        

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Awaiting Shipment</h3>
              <?php 
              $login_id = $this->session->userdata('user_id');  
              if($login_id == 2 || $login_id == 17 ){?>
              <br><br>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Total Price</th>
                    <th>Total Sale Amount</th>
                    <th>Total Shipping Charges</th>
                    <th>Total Quantity</th>
                  </tr>  
                </thead>
                <tbody>
                <tr>
                <?php 
                foreach ($total_price_quantity as $t): ?>
                  <td>
                    <?php
                     $total_price = $t['TOTAL_PRICE'];
                    echo '$ '.number_format((float)@$total_price,2,'.',',');
                    ?> 
                  </td>
              <td>
                
                <?php 
                   $total_sale = $t['TOTAL_SALE_PRICE']; 
                    echo '$ '.number_format((float)@$total_sale,2,'.',',');
                ?> 
              </td>
              <td>  
                <?php 
                   $total_ship = $t['TOTAL_SHIPPING_FEE']; 
                    echo '$ '.number_format((float)@$total_ship,2,'.',',');
                ?> 
              </td> 
              <td>
                 
                <?php 
                   $total_quantity = $t['TOTAL_QUANTITY']; 
                    echo number_format((float)@$total_quantity,0,'.',',');
                ?> 
              </td>               
              <?php endforeach ?> 
              <?php } ?>
              </tr>
              </tbody>
              </table>                            
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">
             <table id="awaitingShipmentTable" class="table table-bordered table-striped">
                <thead>
                  <th>Barcode No</th>
                  <th>Record No#</th>
                  <th>Item Title</th>
                  <th>Ebay Item ID</th>                    
                  <th>Buyer Username / Email</th>
                  <th>Qty</th>
                  <th>Sold For</th>
                  <th>Total</th>
                  <th>Date Sold</th>
                  <th>Date Paid</th>
                  <th>Bin Name</th>
                  <th>Buyer Msg</th>
                  <th>BIN ID</th>
                </thead>
                <tbody>
                </tbody>
             </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
   var dataTable = '';
   var dataTable1 = '';
  $(document).ready(function(){

      if(dataTable != ''){
        dataTable = dataTable.destroy();
       }
     dataTable = $('#awaitingShipmentTable').DataTable({
      "oLanguage": {
        "sInfo": "Total Records: _TOTAL_", 
      },
      "aLengthMenu": [25, 50, 100, 200],
      "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      "info": true,
      // "autoWidth": true,
      "fixedHeader": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": false,
      "ajax":{
        url: '<?php echo base_url();?>shipment/awaiting_shipment/loadShipment', 
        type: 'post',
        dataType: 'json',
        data:{}
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }]
      });
  });
   //////////////////////////
     /////////////////////////
     $("body #search_shipment").click(function(){
      var shipment_radio = $("input[name='awt']:checked").val();
      //console.log(shipment_radio); return false;
      if(dataTable1 != ''){
        dataTable1 = dataTable1.destroy();
       }
      dataTable1 = $('#awaitingShipmentTable').DataTable({
      "oLanguage": {
        "sInfo": "Total Records: _TOTAL_", 
      },
      "aLengthMenu": [25, 50, 100, 200],
      "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      "info": true,
      // "autoWidth": true,
      "fixedHeader": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": false,
      "ajax":{
        url: '<?php echo base_url();?>shipment/awaiting_shipment/loadShipment', 
        type: 'post',
        dataType: 'json',
        data:{'post':1, 'shipment_radio':shipment_radio}
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }]
      });

     });
     /////////////////////////
     /////////////////////////
</script>