<?php $this->load->view('template/header'); ?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
 <!-- danish v_transfer_Bin File -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Transfer Bin Location
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transfer Bin Location</li>
      </ol>
    </section>
    <!-- Main content -->
    <?php 
    //echo @$bind_ids[0]['RACK_NAME']; exit;
   //  echo "<pre>";
   // echo count(@$data['bind_ids']) ; 
   //  exit;
     ?>
    <section class="content">
      <div class="row">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title pull-left">Transfer Bin Location</h3>
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
                            <input class="form-control" type="text" name="search_location" id="search_location" value="<?php if(!empty(@$bin_name)){ echo @$bin_name; } ?>" placeholder="Search Bin">
                        </div>                                     
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="submit" title="Search Item" class="btn btn-primary" name="transfer_location" value="Search" id="transfer_location">
                        </div>
                    </div>
                    </div> 
                  <!-- </form> -->
                  <div id="append_location">
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                        <label for="current_location">Location | Row No | Bin No </label>
                        <div class="form-group">
                        <input type="text" name="current_location" id="current_location" class="form-control" value="<?php if(!empty(@$data['bind_ids'][0]['RACK_NAME'])){ echo @$data['bind_ids'][0]['RACK_NAME']; } ?>" readonly="">
                        <input type="hidden" name="current_bin_id" id="current_bin_id" value="<?php if(!empty(@$data['bind_ids'][0]['BIN_ID'])){ echo @$data['bind_ids'][0]['BIN_ID']; } ?>">
                        <input type="hidden" name="current_barcode" id="current_barcode" value="<?php if(!empty(@$bin_name)){ echo @$bin_name; } ?>">
                        <input type="hidden" name="current_row_id" id="current_row_id" value="<?php if(!empty(@$data['bind_ids'][0]['RACK_ROW_ID'])){ echo @$data['bind_ids'][0]['RACK_ROW_ID']; } ?>">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-12">

                    <div class="col-sm-2">
                        <label for="new_rack">New Rack Row</label>
                        <div class="form-group">
                        <input type="text" name="new_rack" id="new_rack" class="form-control">
                      </div>
                    </div>
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
                        <button   id="update_location" class="btn btn-primary btn-sm">Update Bin</button>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
        </section>
        <section>
          <div class="row" id="bin_detail">
            <div class="col-sm-12"> 
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Transfer Detail</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>              
              </div>              
              <div class="box-body form-scroll">     
                <div class="col-md-12">
                  <table id="transfer_detail" class="table table-bordered table-striped" >
                     <thead>
                        <th>BARCODE</th>
                        <th>TITLE</th>
                        <th>MPN</th>
                        <th>UPC</th>
                        <th>TRANSFER BY</th>
                        <th>TRANSFER DATE</th>
                    </thead>
                    <tbody>   
                    <?php
                    if (count(@$data['transfers']) > 0) {
                      $i=0;
                      foreach (@$data['transfers'] as $value) { ?>
                        <tr>
                          <td><?php echo $value['BARCOD']?></td>
                          <td><?php echo $value['DESCR']?></td>
                          <td><?php echo $value['MPN']?></td>
                          <td><?php echo $value['UPC']?></td>
                          <td><?php echo $value['TRANS_BY_ID']?></td>
                          <td><?php echo $value['TRANSFER_DATE']?></td>
                        </tr>
                     <?php $i++;
                   }
                    }
                    ?>          
                  </tbody>
                </table><br>

              </div>
              <!-- /.col --> 

              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
    <!-- /.col -->
        </div>

        </section>
        <!-- /.content -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
          <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
        </div>
    </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <?php
        if (count(@$data['bind_ids']) > 0) {
          ?>
          <script type="text/javascript">
            $(document).ready(function(){
            $("#transfer_detail").dataTable().fnDestroy();
             $("body #transfer_detail").DataTable({
              "oLanguage": {
              "sInfo": "Total Items: _TOTAL_"
            },
              //"aaSorting": [[11,'desc'],[10,'desc']],
              //"order": [[ 10, "desc" ]],
              "fixedHeader": true,
              "paging": true,
              "iDisplayLength": 25,
              "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              //"autoWidth": true,
              "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                "columnDefs":[{
                    "target":[5],
                    "orderable":false
                  }
                ]      
            });
            });
          </script>
        <?php }
        ?>
 <script type="text/javascript">
   //$(document).ready(function(){
     //$("#transfer_detail").dataTable().fnDestroy();
    
  //});
    $(document).on('click', "#transfer_location", function(){
      var bin_name = $("#search_location").val();
      //console.log(bin_name); return false;
      if (bin_name == '' || bin_name == null || bin_name == undefined) {
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
        url:'<?php echo base_url(); ?>locations/c_locations/getbin',
        type:'post',
        dataType:'json',
        data:{'bin_name':bin_name},
        success:function(data){
          $(".loader").hide();
          //console.log(data);
          if (data.bind_ids.length > 0) {
            $("#append_location").show();
            var current_loc = data.bind_ids[0].RACK_NAME;
            var current_bin_id = data.bind_ids[0].BIN_ID;            
            var current_row_id = data.bind_ids[0].RACK_ROW_ID;            
            // var current_row = data[0].ROW_NO;
            // var bin_name = data[0].BIN_NAME;

            if (current_loc!= null || current_loc!= '') {
              $("#current_location").val(current_loc);
            }
            if (current_bin_id!= null || current_bin_id!= '') {
              $("#current_bin_id").val(current_bin_id);
            }
            if (current_row_id!= null || current_row_id!= '') {
              $("#current_row_id").val(current_row_id);
            }
           
            if (bin_name!= null || bin_name!= '') {
              $("#current_barcode").val(bin_name);
            }

          }
          $("#transfer_detail").dataTable().fnDestroy();
            $("#transfer_detail tbody").html("");
            var table = $('body #transfer_detail').DataTable();

          if (data.transfers.length > 0) {
            $("#bin_detail").show();
            for(var j=0; j<data.transfers.length; j++){
              var barcode_no = data.transfers[j].BARCOD;

              var upc = data.transfers[j].UPC;
              var mpn = data.transfers[j].MPN;
              var descr = data.transfers[j].DESCR;
              var trans_by_id = data.transfers[j].TRANS_BY_ID;
              var transfer_date = data.transfers[j].TRANSFER_DATE;

              if (barcode_no == null) {
                barcode_no = '';
              }
              if (upc == null) {
                upc = '';
              }
              if (mpn == null) {
                mpn = '';
              }
              if (descr == null) {
                descr = '';
              }
              if (trans_by_id == null) {
                trans_by_id = '';
              }
              if (transfer_date == null) {
                transfer_date = '';
              }
              //console.log(barcode_no); 
                
                table.row.add( $('<tr> <td>'+barcode_no+'</td><td>'+descr+'</td><td>'+mpn+'</td><td>'+upc+'</td><td>'+trans_by_id+'</td><td>'+transfer_date+'</td></tr>')).draw();

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
      var new_rack            = $("#new_rack").val();
      var current_row_id            = $("#current_row_id").val();
      // if (new_location == '' || new_location == null || new_location == undefined) {
      //         $('#locationMessage').html("");
      //         $('#locationMessage').append('<strong><span style="padding:5px;">Warning: Please Enter New location!</span></strong>');
      //         $('#locationMessage').show();
      //         setTimeout(function() {
      //         $('#locationMessage').fadeOut('slow');
      //         }, 2000);
      //         $("#new_location").focus();
      //         return false;
      // }
       $(".loader").show();
        $.ajax({
          url:'<?php echo base_url(); ?>locations/c_locations/updatebin',
          type:'post',
          dataType:'json',
          data:{
            'current_barcode':current_barcode,
            'current_location':current_location,
            'new_location':new_location,
            'current_bin_id':current_bin_id,
            'bin_remarks':bin_remarks,
            'new_rack':new_rack,
            'current_row_id':current_row_id

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