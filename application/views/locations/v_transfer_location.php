<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transfer Item Into Bin
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transfer Location</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->  
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title pull-left">Transfer Location</h3>
              <div class="col-sm-5 col-sm-offset-1 pull-left" id="processMessage"></div>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="col-sm-12">
                 <?php if($this->session->flashdata('warning')){  ?>
                  <div class="alert alert-warning">
                      <a href="#" class="close" data-dismiss="alert">&times;</a>
                      <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                  </div>
                  <?php } ?>
                <!-- <form action="<?php //echo base_url(); ?>c_locations/transfer_location" method="post" accept-charset="utf-8"> -->
                    <div class="col-sm-8">
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">

                            <input class="form-control" type="text" name="search_location" id="search_location" value="" placeholder="Search Barcode">
                        </div>                                     
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="submit" title="Search Item" class="btn btn-primary" name="transfer_location" value="Search" id="transfer_location">
                        </div>
                    </div>
                    </div> 
                  <!-- </form> -->
                  <div id="append_location" style="display: none;">
                    
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                        <label for="current_location">Location | Row No | Bin Name</label>
                        <div class="form-group">
                        <input type="text" name="current_location" id="current_location" class="form-control" readonly="">
                        <input type="hidden" name="current_bin_id" id="current_bin_id" value="">
                        <input type="hidden" name="current_barcode" id="current_barcode" value="">
                       <!--  <input type="hidden" name="current_row_id" id="current_row_id" value=""> -->
                        </div>
                      </div> 
                     <!--  <div class="col-sm-1">
                        <label for="current_location">Row</label>
                        <div class="form-group">
                        <input type="text" name="current_row" id="current_row" class="form-control" readonly="">
                        
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="bin_name">Bin Name</label>
                        <div class="form-group">
                        <input type="text" name="bin_name" id="bin_name" class="form-control" readonly="">
                       
                        </div>
                      </div> -->
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <label for="new_location">Bin Name</label>
                        <div class="form-group">
                        <input type="text" name="new_location" id="new_location" class="form-control">
                      </div>
                    </div>

                   <!--  <div class="col-sm-2">
                        <label for="new_rack">Rack Row</label>
                        <div class="form-group">
                        <input type="text" name="new_rack" id="new_rack" class="form-control">
                      </div>
                    </div> -->
                    <div class="col-sm-5 pull-left" id="locationMessage" style="color:red; margin-top: 28px;"></div>
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-8">
                        <label for="bin_remarks">Remarks</label>
                        <div class="form-group">
                          <input type="text" name="bin_remarks" id="bin_remarks" class="form-control">
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                        <button   id="update_location" class="btn btn-primary btn-sm">Update Location</button>
                        </div>
                      </div>
                    </div>
                    
                
              </div>
              </div>  
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
   //$(document).ready(function(){
    $(document).on('click', "#transfer_location", function(){
      var barcode = $("#search_location").val();
      if (barcode == '' || barcode == null || barcode == undefined) {
              $('#processMessage').html("");
              $('#processMessage').append('<p style="color:orange; background-color:#eee; padding:7px; border-radius:2px;"><strong>Warning: Please enter barcode!</strong></p>');
              $('#processMessage').show();
              setTimeout(function() {
              $('#processMessage').fadeOut('slow');
              }, 2000);
              $("#search_location").focus();
              return false;
      }
      $(".loader").show();
      $.ajax({
        url:'<?php echo base_url(); ?>locations/c_locations/getLocation',
        type:'post',
        dataType:'json',
        data:{'barcode':barcode},
        success:function(data){
          $(".loader").hide();
          console.log(data);
          if (data.length > 0) {
            $("#append_location").show();
            var current_loc = data[0].BIN_NAME;
            var current_bin_id = data[0].BIN_ID;            
            //var current_row_id = data[0].RACK_ROW_ID;            
            // var current_row = data[0].ROW_NO;
            // var bin_name = data[0].BIN_NAME;

            if (current_loc!= null || current_loc!= '') {
              $("#current_location").val(current_loc);
            }
            if (current_bin_id!= null || current_bin_id!= '') {
              $("#current_bin_id").val(current_bin_id);
            }
            // if (current_row_id!= null || current_row_id!= '') {
            //   $("#current_row_id").val(current_row_id);
            // }
           
            if (barcode!= null || barcode!= '') {
              $("#current_barcode").val(barcode);
            }
          }
        },
       complete: function(data){
        $(".loader").hide();
      },
      error: function(jqXHR, textStatus, errorThrown){
           $(".loader").hide();
          if (jqXHR.status){
            alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          }
      }
      });
    });

    $(document).on('click', "#update_location", function(){
      var current_location    = $("#current_location").val();
      var new_location        = $("#new_location").val();
      var current_bin_id      = $("#current_bin_id").val();
      var current_barcode     = $("#current_barcode").val();
      var bin_remarks         = $("#bin_remarks").val();
      //var new_rack            = $("#new_rack").val();
      //var current_row_id            = $("#current_row_id").val();
      
      if (new_location == '' || new_location == null || new_location == undefined) {
              $('#locationMessage').html("");
              $('#locationMessage').append('<strong><span style="padding:5px;">Warning: Please Enter New location!</span></strong>');
              $('#locationMessage').show();
              setTimeout(function() {
              $('#locationMessage').fadeOut('slow');
              }, 2000);
              $("#new_location").focus();
              return false;
      }
       $(".loader").show();
        $.ajax({
          url:'<?php echo base_url(); ?>locations/c_locations/updateLocation',
          type:'post',
          dataType:'json',
          data:{
            'current_barcode':current_barcode,
            'current_location':current_location,
            'new_location':new_location,
            'current_bin_id':current_bin_id,
            'bin_remarks':bin_remarks
            //'new_rack':new_rack,
           // 'current_row_id':current_row_id

           },
          success:function(data){
            $(".loader").hide();
            if (data ==1) {
              $('#processMessage').html("");
              $('#processMessage').append('<p style="color:green; background-color:#eee; padding:7px; border-radius:2px;"><strong>Success: Location updated!</strong></p>');
              $('#processMessage').show();
              setTimeout(function() {
              $('#processMessage').fadeOut('slow');
              }, 2000);
              $("#search_location").focus();
              return false;
            }else{
              $('#processMessage').html("");
              $('#processMessage').append('<p style="color:red; background-color:#eee; padding:7px; border-radius:2px;"><strong>Error: Location updation Failed!</strong></p>');
              $('#processMessage').show();
              setTimeout(function() {
              $('#processMessage').fadeOut('slow');
              }, 2000);
              $("#search_location").focus();
              return false;
            }
          },
         complete: function(data){
          $(".loader").hide();
        },
        error: function(jqXHR, textStatus, errorThrown){
             $(".loader").hide();
            if (jqXHR.status){
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
        }
        });

    });
   //});
 </script>