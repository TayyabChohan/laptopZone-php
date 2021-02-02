<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Item History
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Item History</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">      
            <div class="box-body">
              <div class="col-sm-12">
                <form action="<?php echo base_url(); ?>bigData/c_itemHistory/search_item" method="post" accept-charset="utf-8">
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label for="Search Webhook">Search:</label>
                        <input type="number" name="bd_item_search" class="form-control" value="">                      
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group p-t-24">
                      <input type="submit" class="btn btn-primary btn-sm" name="bd_submit" id="bd_submit" value="Search">
                    </div>
                  </div>
                </form>                                            
            </div>
          </div><!-- /.box-body -->       
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div>
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
   $(document).ready(function(){
   });
 </script>