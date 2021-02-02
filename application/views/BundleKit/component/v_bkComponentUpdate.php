<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Component
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Component</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Update Component</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
           

            <div class="box-body">
               <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
              </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
            <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
            <?php } ?>
              <form action="<?php echo base_url().'BundleKit/c_bkComponents/bkUpdateComponent/'.$component[0]['LZ_COMPONENT_ID'] ?>" method="post" accept-charset="utf-8">

                <div class="col-sm-6" style="margin-left: 15px;">
                  <label for="component_name">Update Component</label>
                    <div class="form-group">
                  
                        <input class="form-control" type="text" name="component_name" id="component_name" value="<?php echo $component[0]['LZ_COMPONENT_DESC']?>"  required>
                    </div>                                     
                </div> 
                  <div class="col-sm-2" style="margin-top: 23px;">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="update_item" value="Update">
                    </div>
                  </div> 
                   <div class="col-sm-2" style="margin-top: 23px;">
                    <div class="form-group">
                        <a href="<?php echo base_url().'BundleKit/c_bkComponents' ?>" class="btn btn-primary" name="create_template">Back</a>
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