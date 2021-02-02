<?php $this->load->view('template/header'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ledger Report
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Ledger Report</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Ledger Report</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <form action="<?php echo base_url(); ?>reports/c_ledgerReport/newReport" method="post" accept-charset="utf-8">
            <!-- //////////////////////////////////////////////
            // HARD CODED VALUES                             //
            ////////////////////////////////////////////////-->
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="inventory_org">Inventory Organization:</label>
                  <input type="text" class="form-control" name="inventory_org" value="<?php if(isset($_POST['inventory_org'])){ echo $_POST['inventory_org']; } ?>">
                </div>
              </div>
              <div class="col-sm-4 ">
                <div class="form-group">
                  <label for="sub_inventory">Sub Inventory:</label>
                  <input type="text" class="form-control" name="sub_inventory" value="<?php if(isset($_POST['sub_inventory'])){ echo $_POST['sub_inventory']; } ?>">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="locator">Locator:</label>
                  <input type="text" class="form-control" name="locator" value="<?php if(isset($_POST['locator'])){ echo $_POST['locator']; } ?>">
                </div>
              </div>
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="locator_desc">Locator Description:</label>
                  <!-- <textarea class="form-control" name="locator_desc" id="locator_desc" cols="15" rows="3" value="<?php //if(isset($_POST['locator_desc'])){ echo $_POST['locator_desc']; } ?>">
                  </textarea> -->
                  <input type="text" class="form-control" name="locator_desc" value="<?php if(isset($_POST['locator_desc'])){ echo $_POST['locator_desc']; } ?>">
                </div>
              </div>
              <div class="col-sm-6">
                <legend class="col-sm-9">Item</legend>
                <div class="col-sm-9">
                  <div class="form-group">
                    <label for="item_type">Type:</label> <!-- //HARD CODED VALUE -->
                    <input type="text" class="form-control" name="item_type" value="<?php if(isset($_POST['item_type'])){ echo $_POST['item_type']; } ?>">
                  </div>
                </div>
                <div class="col-sm-9">
                  <div class="form-group">
                    <label for="item_code_from">From:</label> <!-- ///ITEM CODE FROM-->
                    <input type="text" class="form-control" name="item_code_from" value="<?php if(isset($_POST['inventory_org'])){ echo $_POST['item_code_from']; } ?>">
                  </div>
                </div>
                <div class="col-sm-9">
                  <div class="form-group">
                    <label for="item_code_to">To:</label> <!-- ///ITEM CODE TO -->
                    <input type="text" class="form-control" name="item_code_to" value="<?php if(isset($_POST['item_code_to'])){ echo $_POST['item_code_to']; } ?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <legend class="col-sm-9">Date</legend>
                <div class="col-sm-9">
                  <div class="form-group">
                   <label for="date_from_to">From:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="btn btn-default" name="date_from_to" id="date_from_to" value="<?php if(isset($_POST['date_from_to'])){ echo $_POST['date_from_to']; } ?>">
                    </div>
                  </div>
                </div>
                <div class="col-sm-9">
                  <div class="form-group">
                    <input  class="pull-left" type="checkbox" name="exclude" id=""  value="<?php if(isset($_POST['exclude'])){ echo $_POST['exclude']; } ?>">
                    <label for="">&nbsp;&nbsp;&nbsp;Exclude Zero Balance</label>
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
                <legend class="col-sm-12">Version:</legend>
                <div class="col-sm-3">
                  <div class="form-group">
                    <input  class="pull-left" type="checkbox" name="quantitaive" id="quantitaive"  value="<?php if(isset($_POST['quantitaive'])){ echo $_POST['quantitaive']; } ?>">
                    <label for="">&nbsp;&nbsp;&nbsp;Quantitative</label>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <input  class="pull-left" type="checkbox" name="primary_qty" id="primary_qty"  value="<?php if(isset($_POST['primary_qty'])){ echo $_POST['primary_qty']; } ?>" checked="checked">
                    <label for="">&nbsp;&nbsp;&nbsp;Primary QTY</label>
                  </div>
                </div>
                </div>
                <div class="col-sm-1">
                  <div class="form-group">
                    <input  class="btn btn-primary pull-left" type="submit" name="report_submit" id="report_submit"  value="Preview">
                  </div>
                </div>
                <div class="col-sm-1">
                  <div class="form-group">
                    <input  class="btn btn-primary pull-left" type="submit" name="" id=""  value="Reset">
                  </div>
                </div>
            </form>
          </div>
        </div>  
      </div>
    </div> 
  </section> <!-- /.content -->
</div>    
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
  $(document).ready(function() {
      $(function() {
      //Date range as a button
      $('#date_from_to').daterangepicker(
          {

            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             },

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          },
          function (start, end) {
            $('#date_from_to').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });
    
  });
</script>