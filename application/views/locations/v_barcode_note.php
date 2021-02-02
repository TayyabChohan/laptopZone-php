<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Barcode Notes
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Barcode Notes</li>
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
              <h3 class="box-title pull-left">Add Barcode Notes</h3>
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
                    <div class="col-sm-4">
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">
                            <label for="scan_bar" class="control-label">Scan Barcode:</label>
                            <input class="form-control" type="number" name="scan_bar" id="scan_bar" value="" placeholder="Scan Barcode">
                        </div>                                     
                    </div>

                    <div class="col-sm-3">
                      <?php //$get_bin = $this->session->userdata('ses_bin');?>
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">
                            <label for="ent_note" class="control-label">Enter Notes:</label>
                            <input class="form-control" type="text" name="ent_note" id="ent_note" value="" placeholder="Enter Notes">
                        </div>                                     
                    </div>

                    <div class="col-sm-2">
                        <!-- <h4><strong>Search Item</strong></h4> -->

                        <div class="form-group pull-right">
                            <label style ="font-size: 22px; color:red;" for="scan_bin" class="control-label">Total Records :</label>
                            <b style ="font-size: 24px; "  id ='total_row'> </b>
                           <!--  <h3 style ="font-size: 20px; color:red;" id = 'total_row'></h3> -->                           
                        </div>                                                              
                    </div>

                    
                    </div> 
                  <!-- </form> -->
                  
              </div>  
            <!-- /.col -->
          </div>

          <!-- Dynamic table append input rows Barcode Detail Table Start  -->
        
          <div class="box" id= "dyn_box" >
            <div class="box-header with-border">
              <h3 class="box-title">Add Barcodes</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body" >
              
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="dynamic_tab_barc" style = "background-color: #e3f2fd;" class="table table-responsive  table-bordered table-hover">
                  <thead>
                      <tr>
                        <th>
                          <label for="LineType" class="control-label">Sr.#:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Barcode No:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Ebay Id:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Item Desciption:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Item Condition:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Current Bin:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Current Rack :</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Barcode Notes:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Status:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Barcode Source:</label>
                        </th>
                        
                    
                      </tr>
                  </thead>
                  <tbody id="dynamic_tab_body">
                    
                  </tbody>
                  
                </table> 
                

                    <!-- nav-tabs-custom -->
                  </div>

                  <div class="col-sm-12">    
                 
                      <div class="col-sm-1 pull-right">
                        <div class="form-group">
                          <button  type="button" class="btn btn-success" id="upda_notes" name="upda_notes">Update Remarks</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>                        
                      </div>  
                  </div>                  
                <!-- /.col --> 

                </div>
              
            </div>
          <!-- Dynamic table append input rows Barcode Detail Table end  -->

          

          <!-- /.row -->
        </section>
        <!-- /.content -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>


  <script type="text/javascript" src="<?php echo base_url('assets/dist/js/jquery.scannerdetection.js'); ?>"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $("#update_bin").prop("disabled", true);

    });

    $(document).keypress(function(event){
      $(".loader").hide();
      var barcode    = $("#scan_bar").val();

  var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    $(".loader").hide();

    if(barcode != ''){
       apend_table();
    }
   
  }

}); 
 
    var i=0;
    $(document).scannerDetection({
    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    startChar: [120], // Prefix character for the cabled scanner (OPL6845R)
    //endChar: [8], // be sure the scan is complete if key 13 (enter) is detected
    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 40ms
    preventDefault:false,

    
    onComplete: function(barcode, qty){ 
      var barcode    = $("#scan_bar").val();
      $(".loader").hide();
      if(barcode != ''){
      apend_table();  
       }     

 } // main callback function 
});

var options = [];

function apend_table(){
  $(".loader").hide();
 i++;
        var barcode    = $("#scan_bar").val();
        //console.log(current_location);
        $(".loader").show();
        $.ajax({
            
        url:'<?php echo base_url(); ?>locations/c_locations/get_barcode_notes',
        type:'post',
        dataType:'json',
        data:{'barcode':barcode},
        success:function(data){
          $(".loader").hide();
        var total_rows = 0;

    if(data.bar_query == true){
          console.log('barcode MT query');
          $("#update_bin").prop("disabled", false);
        
         $("#scan_bar").val('');
         
        for(var k=0;k<data.bar_deta.length;k++){

          if(data.bar_deta[k].STATUS == 'AVAILABLE'){

            var get_col = 'style="background-color:#26c6da; color:black;"';
          }else{

             var get_col = 'style="background-color:#ef5350; color:white;"';

          }

        
        var ebay_id = JSON.parse(JSON.stringify(data.bar_deta[k].EBAY_ITEM_ID).replace(/null/g, '""'));
        var barco_notes = JSON.parse(JSON.stringify(data.bar_deta[k].BARCODE_NOTES).replace(/null/g, '""'));
        if(jQuery.inArray(data.bar_deta[k].BARCODE_NO, options) !== -1){                
                console.log("is in array");               
                }else{

        $('#dynamic_tab_barc').prepend('<tr><td><div style="width:50px;"><input '+get_col+' type="number" class="form-control dynamic"  name="sr_no" value=""  readonly></div></td> <td style="width:100px;" ><div style="width:100px;"><input '+get_col+' type="number" class="form-control bar_code"  name="bar_code" value = "'+data.bar_deta[k].BARCODE_NO+'" readonly><input '+get_col+' type="hidden" class="form-control bar_bin"  name="bar_bin" value = "'+data.bar_deta[k].BIN_ID+'" ></div></td><td ><div ><input '+get_col+' type="text" class="form-control ebay_id"  name="ebay_id"  value = "'+ebay_id+'" readonly></div></td><td><div style="width:200px;" ><textarea '+get_col+'  rows="3" class="form-control bar_desc"  name="bar_desc" >'+data.bar_deta[k].DESCR+'</textarea></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].CONDI+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].BIN_NAME+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].RACK_NAME+'" readonly></div></td><td ><div style="width:200px;" ><textarea  '+get_col+' class="form-control bar_not "  rows="3" name="bar_not" >'+barco_notes+'</textarea></div></td><td ><div ><input  '+get_col+' type="text" class="form-control bar_status get_color"  name="bar_status"  value = "'+data.bar_deta[k].STATUS+'" readonly></div></td><td ><div ><input  '+get_col+' type="text" class="form-control bar_sorc "  name="bar_sorc"  value = "'+data.bar_deta[k].SOURC+'" readonly></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
        options.push(data.bar_deta[k].BARCODE_NO);
        }


        }
        
         //function for adding serial no against class name dynamic start
        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);            
        });//function for adding serial no against class name dynamic end 




        $(".loader").hide();

    }else if(data.bar_query == false){
      $(".loader").hide();
      alert('Barcode Not Found Or Invalid !');
      return false;

    }
var count_table_rows= $("body #dynamic_tab_barc tr").length;
var count_rows = parseInt(count_table_rows)- 1;
        $('#total_row').html('');
        $('#total_row').append(count_rows);
    }

 
      });
  }
 /*=========================================================
  save buton for insert lz_loc_trans_log table   start
  ===========================================================*/ 
 $('#upda_notes').on('click', function(){ 
  
  var bar_codes =[];
  
  var bar_status =[];
 

  var count_table_rows= $("body #dynamic_tab_barc tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "dynamic_tab_barc";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);
  for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".bar_code").each(function() {
              if($(this).val() != ""){
              bar_codes.push($(this).val());
            }
            });
            
            $(tdbk.rows[i]).find(".bar_sorc").each(function() {
              if($(this).val() != ""){
              bar_status.push($(this).val());
            }
            });
                                                          
          }          

  var ent_note = $('#ent_note').val();  
  
  if( ent_note == ''){

    alert('Enter Notes!');
    return false;

  }else{

  var url='<?php echo base_url() ?>locations/c_locations/updat_notes';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'bar_codes': bar_codes,
            'ent_note': ent_note,
            'bar_status': bar_status
          },

          dataType: 'json',
          success: function (data){    
          $(".loader").hide();  
          if(data == 1){
             $('#dynamic_tab_body').html('');
            $("#update_bin").prop("disabled", true);
            window.location.reload();
            alert(" Notes Updated SuccessFully");
            return false;
           

          } else if(data == 2){


            alert("Error");
            return false;
          }   
             
            
           }
      });  
  }
 });
 //save buton for insert lz_loc_trans_log table   end

    $(document).on('click','.btn_remove',function(){ 
          var row = $(this).closest('tr');
          var dynamicValue = $(row).find('.dynamic').val();
          dynamicValue = parseInt(dynamicValue);
          row.remove();
            // again call serial no function when row delete for keep serial no 
            $('.dynamic').each(function(idx, elem){
              $(elem).val(idx+1);
            });
            var count_table_rows= $("body #dynamic_tab_barc tr").length;
        var count_rows = parseInt(count_table_rows)- 1;
        $('#total_row').html('');
        $('#total_row').append(count_rows);
        });



    

</script>


 