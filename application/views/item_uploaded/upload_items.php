<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listing Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listing Form</li>
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
              <h3 class="box-title">Listing Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

	            <div id="errorMsg" class="text-danger">
	            <?php 
	                // To disable invalid argument supplied for foreach()
	                if (is_array(@$ack))
	                {
	                    foreach (@$ack as $msg) {
	                        # code...
	                        echo @$msg;
	                    } 
	                } ?>
	            </div>
	            <div id="successMsg" class="text-success">
	            <?php 
	                // To disable invalid argument supplied for foreach()
	                if (is_array(@$ack))
	                {
	                    foreach (@$ack as $msg) {
	                        # code...
	                        echo @$msg;
	                    } 
	                } ?>
	            </div>   							

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
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer');?>