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
      <!-- Order pulling Data Section start -->
    <div class="col-sm-12">
      <div class="box">

        <div class="box-header with-border">
          <h3 class="box-title">Partially Pulled Summary</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
          <div class="box-body">
            <form action="">
              <div class="col-sm-4" style="margin-top: 15px;">
                <input type='radio' name='awaiting' value='2' >&nbsp;Dfwonline&nbsp;
                <input type='radio' name='awaiting' value='1'>&nbsp;Techbargain&nbsp;
                <input type='radio' name='awaiting' value='All' checked>&nbsp;All
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
        </div>
      </div>

          <!-- /.box -->
    </div> <!-- col-sm-12 close -->
    <div class="col-sm-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Partially Pulled Detail</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        
        <div class="box-body">
          <div class="form-scroll">
            <table id="PartiallyPulled" class="table table-bordered table-hover">
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
                          <th>PULLER NAME</th>
                          <th>PULLING DATE</th>
                          <!-- <th>WIZ ERP CODE</th> -->


                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($partially_pulled as $partial_order): ?>
                        <tr>
                          <td>
                            <div class="weight_print">
                              <form action="<?php echo base_url();?>order_pulling/c_order_pulling/save_print" method="post" target="_blank">
                                <input style="width: 71px;margin-right: 2px;font-size: 12px!important;padding: 4px 8px!important;" class="form-control" type="number" step="0.01" min="0" name="weight" id="weight" placeholder="Weight" required>
                                <select class="form-control" style="width: 58px;margin-right: 2px;padding: 2px 6px!important;" name="unit" id="unit">
                                  <option value="134">lbs</option>
                                  <option value="148">oz</option>
                                  
                                </select>
                                <input type="hidden" name="order_no" id="order_no" value="<?php echo @$orders['SALES_RECORD_NUMBER'];?>">
                                <button type="submit" title="Print Sticker" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
                              </form>
                            </div>
                            
                          </td>
                          <td><?php echo @$partial_order['BARCODE_NO'];?></td>
                          <td><?php echo @$partial_order['SALES_RECORD_NUMBER'];?></td>
                          <td><?php echo @$partial_order['ITEM_ID'];?></td>
                          <td><?php echo @$partial_order['ITEM_TITLE'];?></td>
                          <td><?php echo @$partial_order['QUANTITY'];?></td>
                          <td><?php echo @$partial_order['PULLING_QTY'];?></td>
                          <td><?php echo @$partial_order['CANCEL_QTY'];?></td>
                          <td><?php echo @$partial_order['SALE_DATE'];?></td>
                          <td><?php echo '$ '.number_format((float)@$partial_order['SALE_PRICE'],2,'.',','); ?></td>
                          <td><?php echo '$ '.number_format((float)@$partial_order['TOTAL_PRICE'],2,'.',',');?></td>
                          <td><?php echo @$partial_order['USER_ID'];?></td>
                          <td><?php echo @$partial_order['BIN_NAME'];?></td>
                          <td><?php echo @$pull_order['PULLER_NAME'];?></td>
                          <td><?php echo @$pull_order['PULLING_DATE'];?></td>
                          <!-- <td><?php //echo @$partial_order['WIZ_ERP_CODE'];?></td> -->

                        </tr>
                      <?php endforeach; ?>
                      </tbody>
            </table>
          </div>
        </div><!-- box body End -->
      </div><!-- box End -->
      <!-- pulled data Section End -->            
    </div> <!-- col-sm-12 close -->
      <!-- /.row -->
    </section>
    </div> <!-- /.content -->
  </div> <!-- /.row -->  

<?php $this->load->view("template/footer.php"); ?>
<script>
    $('#PartiallyPulled').DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 100,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "fixedHeader": true,
      //"order": [[ 6, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });

</script>