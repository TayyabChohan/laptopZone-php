<?php $this->load->view('template/header'); ?>


 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Catalogue
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kit Expr Upload</li>
      </ol>
    </section>

    <section class="content">

        <!-- Item Specific Start -->
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Kit Expr Upload</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">


              <form action="<?php echo base_url();?>catalogue/c_kitExprUpload/importFile" method="post" name="catalogueUpload" id="catalogueUpload" enctype="multipart/form-data">
                
              	 <div class="col-sm-12">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="">Browse File</label>
                        <input type="file" class="form-control" name="file_name" id="file_name" required>
                      </div>  
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group p-t-24">
                       <button type="submit" title="Upload Catalogue" name="upload" class="btn btn-primary ">Upload</button>
                      </div>  
                  </div>
                </form>

                 
            	</div>
          
            </div>
        </div>
    </section>


</div>

<?php $this->load->view('template/footer'); ?>