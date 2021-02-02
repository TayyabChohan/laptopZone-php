<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bundle &amp; Kit  Listing
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bundle &amp; Kit  Listing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
           

            <div class="box-body">
              <form action="<?php echo base_url(); ?>BundleKit/c_MasterScreen/search_category" method="post" accept-charset="utf-8">

                <div class="col-sm-8">
                  <label for="cat_name">Master Item</label>
                    <div class="form-group">
                  
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="cat_name" id="purchase_no" placeholder="Enter item category" required>
                    </div>                                     
                </div> 
                  <div class="col-sm-2" style="margin-top: 23px;">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="search_item" value="Search">
                    </div>
                  </div>
                  <div class="col-sm-2" style="margin-top: 23px;">
                    <div class="form-group">
                        <a href="<?php echo base_url().'BundleKit/c_Template'?>" class="btn btn-primary" name="search_item">Add Template</a>
                    </div>
                  </div> 
                  <div class="col-sm-8">
                 
                    <div class="form-group col-sm-4">
                    <label for="cat_name" >Item Template</label>
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <select name="item_template" class="form-control">
                          <option value="1">Template1</option>
                          <option value="1">Template1</option>
                          <option value="1">Template1</option>
                        </select>
                    </div>  
                                                      
                </div>                                
              </form>
            </div>
        </div>  


        <div class="box">
           
        <div class="box-body form-scroll">      
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <div class="tab-content">
                <table id="notListed" class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                        <th>CATEGORY ID</th>
                        <th>DESCRIPTION</th>
                        <th>MPN</th>
                        <th>UPC</th>
                        <th>PRICE</th>
                        <th>QTY</th>        
                    </tr>
                    </thead>
                     <tbody>
                    
                    </tbody>
                    </table>
                  </div>
                  <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
              </div>
              <!-- /.col --> 
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
 <?php $this->load->view('template/footer'); ?>