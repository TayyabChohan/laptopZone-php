<?php $this->load->view('template/header'); ?>
<style >
  
  #opn_cust{

    display: none;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Item
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Item</li>
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
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                 <?php if($this->session->flashdata('warning')){  ?>
                  <div class="alert alert-warning">
                      <a href="#" class="close" data-dismiss="alert">&times;</a>
                      <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                  </div>
                  <?php } ?>
                <form action="<?php echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8">
                    <div class="col-sm-8">
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">
                            <input class="form-control" type="text" name="search" id ="ser_itm"  value="" placeholder="Search Item">
                        </div>                                     
                    </div>
                  

                    <div class="col-sm-2" >
                        <div class="form-group">
                            <input type="checkbox" title="Search Customer Profile"  id ="chk_val" name="chk_val" value="Search"><label for="scales">&nbsp;&nbsp;Search Customer Profile</label>
                        </div>
                        </div> 

                        <div class="col-sm-2" id ="opn_cust">
                            <div class="form-group">
                                <input type="button" class="btn btn-success" id = "cut_prof" name="Submit" value="Search Customer Prfile">
                            </div>
                        </div> 
                        <div class="col-sm-2" id ="ser">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                            </div>
                        </div>                                 
                </form>
                <!-- <div class="col-sm-2">
                     <div class="form-group">
                          <a class="btn btn-primary btn-sm" title="Go Back" href="<?php //echo base_url(); ?>listing/c_itemHistory/">Item History</a>
                     </div>
                    </div> -->   
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
 <script >
   $('#chk_val').change(function() {

  if ($("input[name='chk_val']").is(':checked')) {
  $('#opn_cust').show();
  $('#ser').hide();
    }else{
    $('#opn_cust').hide();
    $('#ser').show();     

    }

    });

$(document).on('click','#cut_prof',function(){ 

  var ser = $('#ser_itm').val();

  sticker_url = "<?php echo base_url(); ?>CustomerProfile/c_CustomerProfile/CustomerProfile/"+ser;

      var sticker_url = window.open(sticker_url, '_blank');
      sticker_url.location;

  // window.location.href = '<?php //echo base_url(); ?>CustomerProfile/c_CustomerProfile/CustomerProfile';

  // //CustomerProfile/c_CustomerProfile/CustomerProfile
  // var ser = $('#ser_itm').val();
  // console.log(ser);

    });
 </script>