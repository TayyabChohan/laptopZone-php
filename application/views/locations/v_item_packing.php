<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item Packing
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Packing</li>
      </ol>
    </section>
    <!-- Main content -->  
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title pull-left">Item Packing</h3>
              <div class="col-sm-5 col-sm-offset-1 pull-left" id="PackingMessage"></div>
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
                    <div class="col-sm-8"> <!-- <h4><strong>Search Item</strong></h4> -->
                      <div class="form-group">
                        <input class="form-control" type="number" name="search_packing" id="search_packing" value="" placeholder="Search Packing">
                      </div>                                     
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="submit" title="Search Item" class="btn btn-primary" name="item_packing" value="Search" id="item_packing">
                      </div>
                    </div>
                  </div> 
                  <!-- </form> -->
                  <div id="append_location" style="display: none;" > 
                    <div class="col-sm-12">
                      <div class="col-sm-7">
                        <label for="Item Description">Item Description</label>
                        <div class="form-group">
                          <input type="text" name="item_description" id="item_description" class="form-control" readonly="raedonly">
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="item_cond">Condition</label>
                        <div class="form-group">
                          <input type="text" name="item_cond" id="item_cond" class="form-control"  readonly="raedonly">
                        </div>
                      </div> 
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-3">
                          <label for="item_upc">UPC</label>
                          <div class="form-group">
                          <input type="text" name="item_upc" id="item_upc" class="form-control"  readonly="raedonly">
                        </div>
                      </div>
                      <div class="col-sm-3">
                          <label for="item_mpn">MPN</label>
                          <div class="form-group">
                            <input type="text" name="item_mpn" id="item_mpn" class="form-control"  readonly="raedonly">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <label for="Packing">Packing</label>
                        <div id="packings">
                        </div>
                      </div>
                      <div class="col-sm-3 pull-left" id="PackingMessage" style="color:red; margin-top: 28px;"></div>
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                        <button id="update_packing" class="btn btn-primary btn-sm">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>  
            <!-- /.col -->
          </div>
          <!-- /.row -->
      
              <!-- tABLE  --> 

         <div id="append_table" style="display: none;">

            <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="packing_info" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Actions</th>
                      <th>Packing Name</th>
                      <th>Length</th>
                      <th>Width</th>
                      <th>Height</th>
                      <th>Packing Type</th>
                      <th>Count</th>
                    </tr>
                  </thead>
                  <tbody> 
                  </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>
  </div>
<!-- /tABLE -->

        </section>
        <!-- /.content -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
          <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
   $(document).ready(function(){


 $('#packing_info').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength":25,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    //
    "aaSorting": [ [6, "desc"] ],
    //"order": [[ 1, "desc" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });




    $(document).on('click', "#item_packing", function(){
      //alert('hhh'); return false;
      var barcode = $("#search_packing").val();
      if (barcode == '' || barcode == null || barcode == undefined) {
              $('#PackingMessage').html("");
              $('#PackingMessage').append('<p style="color:orange; background-color:#eee; padding:7px; border-radius:2px;"><strong>Warning: Please enter barcode!</strong></p>');
              $('#PackingMessage').show();
              setTimeout(function() {
              $('#PackingMessage').fadeOut('slow');
              }, 2000);
              $("#search_packing").focus();
              return false;
          }
          $(".loader").show();
          $.ajax({
            url:'<?php echo base_url(); ?>locations/c_locations/getPacking',
            type:'post',
            dataType:'json',
            data:{'barcode':barcode},
            success:function(data){
              $(".loader").hide();
              //console.log(data); return false;
              if (data.barcodeInfo.length == 0) {
                  $('#PackingMessage').html("");
                  $('#PackingMessage').append('<p style="color:orange; background-color:#eee; padding:7px; border-radius:2px;"><strong>Warning: Please enter valid barcode!</strong></p>');
                  $('#PackingMessage').show();
                  setTimeout(function() {
                  $('#PackingMessage').fadeOut('slow');
                  }, 2000);
                  $("#search_packing").focus();
                  return false;
              }else if(data.barcodeInfo.length > 0) {
                $("#append_location").show();
                var large_desc            = data.barcodeInfo[0].ITEM_MT_DESC;
                var item_condition        = data.barcodeInfo[0].CONDITIONS_SEG5;            
                var item_mt_upc           = data.barcodeInfo[0].ITEM_MT_UPC;            
                var item_part_no          = data.barcodeInfo[0].ITEM_MT_MFG_PART_NO; 
                var packing_id            = data.barcodeInfo[0].PACKING_ID; 

                if (large_desc!= null || large_desc!= '') {
                  $("#item_description").val(large_desc);
                }

                if (item_condition!= null || item_condition!= '') {
                  $("#item_cond").val(item_condition);
                }

                if (item_mt_upc!= null || item_mt_upc!= '') {
                  $("#item_upc").val(item_mt_upc);
                }
               
                if (item_part_no!= null || item_part_no!= '') {
                  $("#item_mpn").val(item_part_no);
                }
                /////////////////////////////
                  var mpns = [];
                  for(var i = 0; i<data.packings.length; i++){
                    if (data.packings[0].PACKING_ID == packing_id){
                                    var selected = "selected";
                                  }else {
                                      var selected = "";
                                  }
                    mpns.push('<option value="'+data.packings[i].PACKING_ID+'" '+selected+'>'+data.packings[i].PACKING_NAME+'</option>');
                  }
                  //////////////////////////
                  $("#packings").html("");
                  $('#packings').append('<select name="select_packing" id="select_packing" class="form-control select_packing" data-live-search="true" required><option value="0">---select---</option>'+mpns.join("")+'</select>');
                  $('#select_packing').selectpicker();
                ////////////////////////////
              }
              if(data.pdata.length > 0) {
                  
                  $("#append_table").show();

                  var pid = data.pdata[0].PACKING_ID;
                    $('#select_packing').val(pid); 
                    $('body #select_packing ').selectpicker('refresh');

                var tb = $("#packing_info").DataTable();
                tb.rows().remove().draw();
            for(var i = 0; i<data.pdata.length; i++){
                var packing_name            = data.pdata[i].PACKING_NAME;
                 var packing_length        = data.pdata[i].PACKING_LENGTH;            
                 var packing_width           = data.pdata[i].PACKING_WIDTH;            
                 var packing_heigth          = data.pdata[i].PACKING_HEIGTH; 
                 var  packing_type            = data.pdata[i].PACKING_TYPE;
                 var  packing_id             = data.pdata[i].PACKING_ID;
                 var  count                  = data.pdata[i].CNT;

                var td = '<td><input type="button" name="s_packing"  id="s_packing_'+i+'" pid="'+packing_id+'" pnm="'+packing_name+'" class="btn btn-primary btn-xs s_packing" value="Select"></td>';

                td += '<td>'+packing_name+'</td>';         
                td += '<td>'+packing_length+'</td>';         
                td += '<td>'+packing_width+'</td>';         
                td += '<td>'+packing_heigth+'</td>';         
                td += '<td>'+packing_type+'</td>';
                td += '<td>'+count+'</td>';
                var myDataRow = '<tr>'+td+'</tr>';
                tb.row.add($(myDataRow)).draw();          

              }
               }else 
               $("#append_table").hide();

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

    $(document).on('click', "#update_packing", function(){
      var select_packing    = $("#select_packing").val();
      var packing_barcode    = $("#search_packing").val();
      if (select_packing == 0 || select_packing == null || select_packing == undefined) {
              $('#PackingMessage').html("");
              $('#PackingMessage').append('<strong><span style="padding:5px;">Warning:Packing is required!</span></strong>');
              $('#PackingMessage').show();
              setTimeout(function() {
              $('#PackingMessage').fadeOut('slow');
              }, 2000);
              $("#PackingMessage").focus();
              return false;
      } 
            if (packing_barcode == 0 || packing_barcode == null || packing_barcode == undefined) {
              $('#PackingMessage').html("");
              $('#PackingMessage').append('<strong><span style="padding:5px;">Warning:Packing is required!</span></strong>');
              $('#PackingMessage').show();
              setTimeout(function() {
              $('#PackingMessage').fadeOut('slow');
              }, 2000);
              $("#search_packing").focus();
              return false;
            }
             $(".loader").show();
              $.ajax({
                url:'<?php echo base_url(); ?>locations/c_locations/updatePacking',
                type:'post',
                dataType:'json',
                data:{
                  'select_packing':select_packing,
                  'packing_barcode':packing_barcode
                 },
                success:function(data){
                  $(".loader").hide();
                  if (data ==1) {
                    $('#PackingMessage').html("");
                    $('#PackingMessage').append('<p style="color:green; background-color:#eee; padding:7px; border-radius:2px;"><strong>Success: Packing is updated!</strong></p>');
                    $('#PackingMessage').show();
                    setTimeout(function() {
                    $('#PackingMessage').fadeOut('slow');
                    }, 2000);
                    $("#search_location").focus();
                    return false;
                  }else{
                    $('#PackingMessage').html("");
                    $('#PackingMessage').append('<p style="color:red; background-color:#eee; padding:7px; border-radius:2px;"><strong>Error: Packing updation Failed!</strong></p>');
                    $('#PackingMessage').show();
                    setTimeout(function(){
                    $('#PackingMessage').fadeOut('slow');
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

    $(document).on('click','.s_packing',function(){

    var pid=$(this).attr('pid');
    var pnm=$(this).attr('pnm');
    console.log(pid, pnm);


    $('#select_packing').val(pid); 
    $('body #select_packing ').selectpicker('refresh');
    });




   });
//
 </script>