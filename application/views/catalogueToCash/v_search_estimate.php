<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Estimate
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Estimate</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Estimate</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                 <?php if($this->session->flashdata('error')){  ?>
                  <div class="alert alert-error">
                      <a href="#" class="close" data-dismiss="alert">&times;</a>
                      <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php } ?>
                <form action="<?php echo base_url(); ?>itemsToEstimate/c_search_estimate/searchEstimate" method="post" accept-charset="utf-8">
                <div class="col-sm-8">
                  <div class="form-group">
                      <input class="form-control" type="text" name="search_estimate" value="<?php echo set_value('search_estimate'); ?>" placeholder="Search Estimate" required>
                  </div>                                     
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="submit" title="Search Estimate" class="btn btn-primary" name="Submit" value="Search">
                  </div>
                </div>                                 
              </form> 
            </div>
          </dvi>  
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>