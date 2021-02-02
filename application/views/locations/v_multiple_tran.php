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
                    <div class="col-sm-4">
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">
                            <label for="scan_bar" class="control-label">Scan Barcode Or Ebay Id:</label>
                            <input class="form-control" type="number" name="scan_bar" id="scan_bar" value="" placeholder="Scan Barcode or Scan Ebay Id">
                        </div>                                     
                    </div>

                    <div class="col-sm-3">
                      <?php $get_bin = $this->session->userdata('ses_bin');?>
                        <!-- <h4><strong>Search Item</strong></h4> -->
                        <div class="form-group">
                            <label for="scan_bin" class="control-label">Scan Bin No:</label>
                            <input class="form-control" type="text" name="scan_bin" id="scan_bin" value="<?php echo $get_bin;?>" placeholder="Scan Bin">
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

                    <!-- <div class="col-sm-3">
                        
                        <div class="form-group">
                            <label for="scan_ebay_id" class="control-label">Search Ebay Id:</label>
                            <input class="form-control" type="text" name="scan_ebay_id" id="scan_ebay_id" value="" placeholder="Search Ebay Id">
                        </div>                                     
                    </div>
                     <div class="col-sm-2">
                        
                        <div class="form-group">
                            <label for="btn_ebay_id" class="control-label"></label>
                            <input class="form-control btn btn-primary" type="button" name="btn_ebay_id" id="btn_ebay_id" value="Search Ebay ">
                        </div>                                     
                    </div> -->
                    <!-- <div class="col-sm-2">
                        <div class="form-group">
                            <input type="submit" title="Search Item" class="btn btn-primary" name="transfer_location" value="Search" id="transfer_location">
                        </div>
                    </div> -->
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
                          <label for="LineType" class="control-label">Status:</label>
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
                          <button  type="button" class="btn btn-success" id="update_bin" name="update_bin">Update Location</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>                        
                      </div>  
                  </div>                  
                <!-- /.col --> 

                </div>
              
            </div>
          <!-- Dynamic table append input rows Barcode Detail Table end  -->

          <div class="box" id= "dyn_box" >
            <div class="box-header with-border">
              <h3 class="box-title">Un-Posted Barcodes</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body" style="height:250px;">
             
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="dekit_tab_barc" class="table table-responsive table-striped table-bordered table-hover">
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
                          <label for="LineType" class="control-label">Bin Name:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Rack Name:</label>
                        </th>
                        
                    
                      </tr>
                  </thead>
                  <tbody id="dekit_tab_body">
                    
                  </tbody>
                  
                </table> 
                

                    <!-- nav-tabs-custom -->
                  </div>

                 
                                   
                <!-- /.col --> 

                </div>
              
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
 i++;
        var barcode    = $("#scan_bar").val();
        //console.log(current_location);
        $(".loader").show();
        $.ajax({
            
        url:'<?php echo base_url(); ?>locations/c_locations/get_barcode',
        type:'post',
        dataType:'json',
        data:{'barcode':barcode},
        success:function(data){
        var total_rows = 0;
        if(data.eby_qyery == true){
          console.log('Ebay ID  query');
          $("#update_bin").prop("disabled", false);
        
         $("#scan_bar").val('');
         
        
         for(var k=0;k<data.ebY_deta.length;k++){
          if(data.ebY_deta[k].STATUS == 'AVAILABLE'){

            var get_col = 'style="background-color:#26c6da; color:black;"';
          }else{

             var get_col = 'style="background-color:#ef5350; color:white;"';

          }
        
        var ebay_id = JSON.parse(JSON.stringify(data.ebY_deta[k].EBAY_ITEM_ID).replace(/null/g, '""'));

        if(jQuery.inArray(data.ebY_deta[k].BARCODE_NO, options) !== -1){                
                console.log("is in array");               
                }else{

        $('#dynamic_tab_barc').prepend('<tr><td style="width:60px;"><div style="width:60px;"><input '+get_col+' type="number" class="form-control dynamic"  name="sr_no" value=""  readonly></div></td> <td style="width:100px;" ><div style="width:100px;"><input '+get_col+' type="number" class="form-control bar_code"  name="bar_code" value = "'+data.ebY_deta[k].BARCODE_NO+'" readonly><input '+get_col+' type="hidden" class="form-control bar_bin"  name="bar_bin" value = "'+data.ebY_deta[k].BIN_ID+'" ></div></td><td ><div ><input '+get_col+' type="text" class="form-control ebay_id"  name="ebay_id"  value = "'+ebay_id+'" readonly></div></td><td style="width:400px;" ><div style="width:400px;" ><input '+get_col+' type="text" class="form-control bar_desc"  name="bar_desc"  value = "'+data.ebY_deta[k].DESCR+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.ebY_deta[k].CONDI+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.ebY_deta[k].BIN_NAME+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.ebY_deta[k].RACK_NAME+'" readonly></div></td><td ><div ><input '+get_col+'type="text" class="form-control bar_status"  name="bar_status"  value = "'+data.ebY_deta[k].STATUS+'" readonly></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
        options.push(data.ebY_deta[k].BARCODE_NO);
        }

        }
        
         //function for adding serial no against class name dynamic start
        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);               
        });//function for adding serial no against class name dynamic end  
        $(".loader").hide();

    }else if(data.bar_query == true){
          console.log('barcode MT query');
          $("#update_bin").prop("disabled", false);
        
         $("#scan_bar").val('');
         
        for(var k=0;k<data.bar_deta.length;k++){
          console.log(data.bar_deta[k].EBAY_ITEM_ID);
          if(data.bar_deta[k].STATUS == 'AVAILABLE' && data.bar_deta[k].EBAY_ITEM_ID == null ){

            var get_col = 'style="background-color:#ffea00; color:black;"';

          }else if(data.bar_deta[k].STATUS == 'AVAILABLE'){
             var get_col = 'style="background-color:#26c6da; color:black;"';            

          }else{
            var get_col = 'style="background-color:#ef5350; color:white;"';

          }

        
        var ebay_id = JSON.parse(JSON.stringify(data.bar_deta[k].EBAY_ITEM_ID).replace(/null/g, '""'));
        if(jQuery.inArray(data.bar_deta[k].BARCODE_NO, options) !== -1){                
                console.log("is in array");               
                }else{

        $('#dynamic_tab_barc').prepend('<tr><td style="width:60px;"><div style="width:60px;"><input '+get_col+' type="number" class="form-control dynamic"  name="sr_no" value=""  readonly></div></td> <td style="width:100px;" ><div style="width:100px;"><input '+get_col+' type="number" class="form-control bar_code"  name="bar_code" value = "'+data.bar_deta[k].BARCODE_NO+'" readonly><input '+get_col+' type="hidden" class="form-control bar_bin"  name="bar_bin" value = "'+data.bar_deta[k].BIN_ID+'" ></div></td><td ><div ><input '+get_col+' type="text" class="form-control ebay_id"  name="ebay_id"  value = "'+ebay_id+'" readonly></div></td><td style="width:400px;" ><div style="width:400px;" ><input '+get_col+' type="text" class="form-control bar_desc"  name="bar_desc"  value = "'+data.bar_deta[k].DESCR+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].CONDI+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].BIN_NAME+'" readonly></div></td><td ><div ><input '+get_col+' type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].RACK_NAME+'" readonly></div></td><td ><div ><input  '+get_col+' type="text" class="form-control bar_status get_color"  name="bar_status"  value = "'+data.bar_deta[k].STATUS+'" readonly></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
        options.push(data.bar_deta[k].BARCODE_NO);
        }


        }
        
         //function for adding serial no against class name dynamic start
        $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);

          // var test = $(elem).val(idx+1);   
          // console.log(test);               
        });//function for adding serial no against class name dynamic end 




        $(".loader").hide();

    }else if(data.det_bar){

      console.log('dekited barcode QUERY');

          $("#update_bin").prop("disabled", false);
        
         $("#scan_bar").val('');
       
        for(var k=0;k<data.bar_deta.length;k++){
        
        var ebay_id = JSON.parse(JSON.stringify(data.bar_deta[k].EBAY_ITEM_ID).replace(/null/g, '""'));
        if(jQuery.inArray(data.bar_deta[k].BARCODE_NO, options) !== -1){                
                console.log("is in array");               
                }else{


        $('#dekit_tab_barc').prepend('<tr><td style="width:60px;"><div style="width:60px;"><input style="background-color:white;" type="number" class="form-control det_dynamic"  name="sr_no" value=""  readonly></div></td> <td style="width:100px;" ><div style="width:100px;"><input style="background-color:white;" type="number" class="form-control bar_code"  name="bar_code" value = "'+data.bar_deta[k].BARCODE_NO+'" readonly><input style="background-color:white;" type="hidden" class="form-control bar_bin"  name="bar_bin" value = "'+data.bar_deta[k].BIN_ID+'" ></div></td><td ><div ><input style="background-color:white;" type="text" class="form-control ebay_id"  name="ebay_id"  value = "'+ebay_id+'" readonly></div></td><td style="width:400px;" ><div style="width:400px;" ><input style="background-color:white;" type="text" class="form-control bar_desc"  name="bar_desc"  value = "'+data.bar_deta[k].DESCR+'" readonly></div></td><td ><div ><input style="background-color:white;" type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].CONDI+'" readonly></div></td><td ><div ><input style="background-color:white;" type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].BIN_NAME+'" readonly></div></td><td ><div ><input style="background-color:white;" type="text" class="form-control bar_con"  name="bar_con"  value = "'+data.bar_deta[k].RACK_NAME+'" readonly></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
        options.push(data.bar_deta[k].BARCODE_NO);
        }


        }
     
         //function for adding serial no against class name dynamic start
        $('.det_dynamic').each(function(idx, elem){
          $(elem).val(idx+1);   

        });//function for adding serial no against class name dynamic end  
        $(".loader").hide();
       // $("#scan_bar").val('');
       
      }
     // var get_total =  $('#total_count').val();
     // console.log(get_total);

     // total_rows  = parseInt(parseInt(get_total) + parseInt(total_rows));
     //     console.log(total_rows);
        // $('#total_count').val('');
        // $('#total_count').val(get_total);
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
 $('#update_bin').on('click', function(){ 
  
  var bar_codes =[];
  var current_bin_id =[];
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
            $(tdbk.rows[i]).find(".bar_bin").each(function() {
              if($(this).val() != ""){
              current_bin_id.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".bar_status").each(function() {
              if($(this).val() != ""){
              bar_status.push($(this).val());
            }
            });
                                                          
          }          

  var scan_bin = $('#scan_bin').val();  
  console.log('ee');
  if( scan_bin == ''){

    alert('Scan Bin is Empty!');
    return false;

  }else{
 

  var url='<?php echo base_url() ?>locations/c_locations/update_loc';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'bar_codes': bar_codes,
            'current_bin_id': current_bin_id,
            'scan_bin': scan_bin,
            'bar_status': bar_status
          },

          dataType: 'json',
          success: function (data){    
          $(".loader").hide();  
          if(data == 1){
             $('#dynamic_tab_body').html('');
            $("#update_bin").prop("disabled", true);
            window.location.reload();
            alert(" Bin Updated SuccessFully");
            return false;
           

          }   else if(data == 2){

            alert(" Bin Name is Invalid");
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


 