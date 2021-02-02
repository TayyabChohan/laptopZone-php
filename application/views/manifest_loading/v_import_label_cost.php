<?php $this->load->view('template/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Shipping Label Upload

        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Shipping Label Upload</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
          

            <div class="box-header with-border">
              <h3 class="box-title">Shipping Label Upload</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          

            <div class="box-body">

              <form action="<?php echo base_url();?>manifest_loading/c_manf_load/import_label_cost" method="post" enctype="multipart/form-data" name="import_label" id="import_label"> 
                    
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Browse File</label>
                          <input type="file" class="form-control" name="file_name" id="file_name" required>
                        </div>  
                      </div>
                    </div>
                      <div class="col-sm-12">
                        <div class="form-group">
                        <button type="submit" title="Upload Manifest" name="upload" class="btn btn-primary ">Upload</button>
                        <input type="reset" title="Clear All" class="btn btn-warning m-l-5" name="reset" value="Reset">
                        <a href="<?php echo base_url();?>manifest_loading/c_manf_load" title="Go Back" class="btn btn-success m-l-5">Back</a>

                        </div>
                      </div>

                      
                    

                </form>                

            </div>
              
          </div>
      
          </div>
          <!-- nav-tabs-custom -->
        <!-- Tab Section with Table View start-->
               
            <!-- /.box-body -->
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

<script type="text/javascript">
//Manifest sticker validation 
 // function QtyVal(){
 //  var manifest = $("#manifest").val();
 //  var lotQty  = $("#lot_qty").val();
 //  var MannQty = $("#mann_qty").val();
 //  //alert(x);
 //  if(manifest == null || manifest == "") {
 //    alert("Please enter Manifest Name.");
 //    return false;
 //  }    
 //  else if(lotQty == null || lotQty == "") {
 //    alert("Please select Lot Quantity.");
 //    return false;
 //  }else if(lotQty == null || MannQty == ""){
 //    alert("Please insert Mannual Quantity.");
 //    return false;
 //  }
 // }
 function reloadWind(){

  location.reload();
 }
</script>