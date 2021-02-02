<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Template Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Template Form</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Templates</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

             <table id="templateTable" class="table table-bordered table-striped">
                <!-- <h2>Templates</h2><br> -->
                <p>
                  <a href="<?php echo site_url('template/c_temp/add') ?>" title="Add New Template" class="btn btn-primary">Add New</a>
                </p>      
                <thead>
                  <tr>
                    <!-- <th>Template Id</th> -->
                    <th>Action</th>
                    <th>Template Name</th>
                    <th>Site ID</th>
                    <th>Ship From Country</th>
                    <th>Currency</th>
                    <th>Listing Type</th>
                   <!--  <th>Category ID</th>
                    <th>Handling Time (Days)</th> -->
                    <th>Ship From (Zip Code)</th>
                    <th>Ship From Loaction</th>
                    <!-- <th>Bid Length</th> -->
                    <!-- <th>Deafult Condition</th> -->
                    <!-- <th>Default Condition Description</th> -->
                    <th>Payment Method</th>
                    <th>Paypal Email Address</th>
                    <th>Dispatch Time Max</th>
                    <th>Shipping Service</th>
                    <th>Shpping Service Cost</th>
                    <th>Shpping Service Additional Cost</th>
                    <th>Return Accepted Option</th>
                    <th>Returns Within Option</th>
                    <th>Shipping Cost Paid By</th>

                  </tr>
                </thead>
                <tbody>
                <?php
            if ($data_get == NULL) {
            ?>
            <div class="alert alert-info" role="alert">There is no record found.</div>
            <?php
            } else {
            foreach ($data_get as $row) {
            ?>
                  <tr>
                  <!--<td><?php //echo $row->TEMPLATE_ID; ?></td>-->
                  <td>
                  <div class="edit_btun">
                   <a title="Edit Template" href="<?php echo site_url('template/c_temp/edit/' . $row->TEMPLATE_ID); ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></a>
                   <a title="Delete Template" href="<?php echo site_url('template/c_temp/delete/' . $row->TEMPLATE_ID); ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                   </div>
                  </td>
                  <td><?php echo $row->TEMPLATE_NAME; ?></td>
                  <td><?php echo $row->EBAY_LOCAL; ?></td>
                  <td>US</td>
                  <td><?php echo $row->CURRENCY; ?></td>
                  <td><?php echo $row->LIST_TYPE; ?></td>

                  <td><?php echo $row->SHIP_FROM_ZIP_CODE; ?></td>
                  <td><?php echo $row->SHIP_FROM_LOC; ?></td>
                  <!--<td><?php //echo $row->BID_LENGTH; ?></td>
                  <td><?php //echo $row->DEFAULT_COND; ?></td>
                  <td><?php //echo $row->DETAIL_COND; ?></td>-->
                  <td><?php echo $row->PAYMENT_METHOD; ?></td>
                  <td><?php echo $row->PAYPAL_EMAIL; ?></td>
                  <td><?php echo $row->DISPATCH_TIME_MAX; ?></td>
                  <td><?php echo $row->SHIPPING_SERVICE; ?></td>
                  <td><?php echo $row->SHIPPING_COST; ?></td>
                  <td><?php echo $row->ADDITIONAL_COST; ?></td>
                  <td><?php echo $row->RETURN_OPTION; ?></td>
                  <td><?php echo $row->RETURN_DAYS; ?></td>
                  <td><?php echo $row->SHIPPING_PAID_BY; ?></td>      

                <?php
                }
            }
                ?>
                  </tr>
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
    <!-- /.content -->
  </div>  

<?php $this->load->view('template/footer');?>