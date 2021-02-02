<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lister View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lister View</li>
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
<!--             <div class="box-header">
              <h3 class="box-title">Listing Form</h3>
            </div> -->
            <!-- /.box-header -->

                        <div class="box box-body">

                            <form action="<?php echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8">
                                <div class="col-sm-8">
                                    <h4><strong>Search Item</strong></h4>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="search" value="" placeholder="Search Item">
                                    </div>                                     
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group p-t-40">
                                        <input type="submit" title="Search Listers" class="btn btn-primary" name="Submit" value="Search">
                                    </div>
                                </div>                                 
                            </form>
                        </div>
                        </div>  


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>