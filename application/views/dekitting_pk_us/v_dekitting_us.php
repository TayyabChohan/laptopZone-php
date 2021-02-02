<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
?>
<style>

</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          DE-Kitting - U.S.
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">DE-Kitting - U.S.</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
    <!-- Master Barcode Search Box section Start -->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
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
            <?php }else if($this->session->flashdata('compo')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                </div>
            <?php } ?>    
              
        <div class="col-sm-12">
    
              
          <form action="<?php //echo base_url().'biddingItems/c_biddingItems/searchPurchDetail'; ?>" method="post" accept-charset="utf-8">
              <div class="col-sm-12">
                <div class="col-sm-12" >
                      <div class="col-sm-3"></div>
                      <div class="col-sm-5" id="errorMessage"></div>
                     
                    </div>
                <div class="col-sm-2 ">             
                  <div class="form-group">
                    <label for="Master Barcode">Master Barcode :</label>
                    <input type="text" name="master_barcode" id ="master_barcode" class="form-control clear" placeholder="Search Barcode" value="<?php //echo htmlentities($this->session->userdata('serchkeyword')); ?>" >    
                  </div>              
                </div>

                <div class="col-sm-4 ">        
                  <div class="form-group">
                    <label for="Master Barcode">Item :</label>
                    <input type="text" name="item_detail" id ="item_detail" class="form-control clear" placeholder="" value="<?php //echo htmlentities($this->session->userdata('serchkeyword')); ?>" readonly>    
                  </div>              
                </div>

                <div class="col-sm-2 ">             
                  <div class="form-group">
                    <label for="Master Barcode">Condition :</label>
                    <input type="text" name="it_cond" id ="it_cond" class="form-control clear" placeholder="" value=""  readonly>    
                  </div>              
                </div>

                <div class="col-sm-2 ">             
                  <div class="form-group">
                    <label for="Master Barcode">MPN :</label>
                    <input type="text" name="item_mpn" id ="item_mpn" class="form-control clear" placeholder="" value="" readonly>    
                  </div>              
                </div>
                <div class="col-sm-1 ">             
                  <div class="form-group">
                    <label for="Master Barcode">Qty :</label>
                    <input type="number" name="bar_qty" id ="bar_qty" class="form-control clear" placeholder="" value="1" >    
                  </div>              
                </div>
                <div class="col-sm-1 ">             
                  <div class="form-group p-t-24">
                    <input type="button" name="save_bar_qty" id ="save_bar_qty" value ="Save" class="btn btn-success" placeholder="" value="" >    
                  </div>              
                </div>
                <!-- <div class="col-sm-3">
                  <div class="form-group">
                    <button type="button" class="btn btn-primary" name="search_m_barcode" id="search_m_barcode">Search</button>
                  </div>
                </div> -->
                <div class="col-sm-3 ">             
                  <div class="form-group">
                    
                    <input type="hidden" name="it_cat" id ="it_cat" class="form-control clear" placeholder="" value="" >    
                  </div>              
                </div>
                

                

              </div>


             <!-- <div class="col-sm-12"> 
                                    empty div
            </div> -->
          </form>                     
                                                       
        </div> 
      </div>
      </div>
       <!-- Master Barcode Search Box section End -->    

        <!-- Dynamic table append input rows Barcode Detail Table Start  -->
        
          <div class="box" id= "dyn_box" >
            <div class="box-header with-border">
              <h3 class="box-title">Add Components</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="box-body"> 
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="dynamic_tab_dekit" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                        <th>
                          <label for="LineType" class="control-label">Sr.#:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Condition:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Object:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Weight:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">BIN/RACK:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Remarks:</label>
                        </th>
                      </tr>
                  </thead>
                  <tbody id="dynamic_tab_body">
                    
                  </tbody>
                  
                </table> 
                

                    <!-- nav-tabs-custom -->
                  </div>

                  </div>
                  <div class="col-sm-12">    
                  <div class="col-sm-1 pull-left">
                        <div class="form-group">
                          <button  type="button" class="btn btn-primary" id="add" name="add">+Add Row</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>
                      </div> 
                      <div class="col-sm-1 pull-right">
                        <div class="form-group">
                          <button  type="button" class="btn btn-success" id="dynamic-tab-save" name="dynamic-tab-save">Save</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>                        
                      </div>  
                  </div>                  
                <!-- /.col --> 

                </div>
              
            </div>
          <!-- Dynamic table append input rows Barcode Detail Table end  -->

          <!-- Barcode Detail Table Start  -->
          <div class="box" id="dyn_box2">
            <div class="box-header with-border">
              <h3 class="box-title">Components Detail</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <!-- Print Message -->
              <!-- <div class="col-sm-12">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                  <div class="form-group text-center emptyDiv">
                    <div id="printMessage">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                </div>                
              </div> -->
              <!-- End Print Message -->
              <div class="box-body form-scroll">
              <div class="col-md-11">

          <div class="pull-right">
                <button type="button" id= "print" class="btn btn-primary" >Print All
                </button>

                <button type="button" id= "Save_rema" class="btn btn-success" >Save Remarks
                </button>
          </div>

              </div> 
              <div class="col-md-12"><!-- Custom Tabs -->
          



                <table id="dekit_pk_us" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Sr.#:</th>
                      <th>Action</th>
                      <th style="width:40px;">Barcode</th>
                      <th >Object</th>
                      <th>Condition</th>
                      <th>Weight</th>
                      <th style="width:80px;">BIN/Rack</th>
                      <th>Dekitting Remarks</th>
                      <th>Print Status</th>
                      <!-- <th>Print Sticker</th> -->

                      </tr>
                  </thead>
                  <tbody id="table_body">
                  
                  </tbody>
                </table>              
                    <!-- nav-tabs-custom -->


        
                  </div>
                  </div>
                  
                <!-- /.col --> 

                </div>
              
            </div>
          <!-- Barcode Detail Table Start  -->
           <!-- Dynamic table append input rows Barcode and add row option in case of update Detail Table Start  -->
        
          <div class="box" id= "dyn_box3" >
            <!-- <div class="box-header with-border">
              <h3 class="box-title">Add More Components</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div> -->          
            <div class="box-body">
              <div class="box-body"> 
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="tab_add_onupdate" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                        <th>
                          <label for="LineType" class="control-label">Sr.#:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Condition:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Object:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Weight:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">BIN/RACK:</label>
                        </th>
                        <th>
                          <label for="LineType" class="control-label">Remarks:</label>
                        </th>
                      </tr>
                  </thead>
                  <tbody id="tab_add_onupdate_body">
                    
                  </tbody>
                  
                </table>                 

                    <!-- nav-tabs-custom -->
                  </div>

                  </div>
                  <div class="col-sm-12">    
                  <div class="col-sm-1 pull-left">
                        <div class="form-group">
                          <button  type="button" class="btn btn-primary" id="update_add" name="update_add">+Add Row</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>
                      </div> 
                      <div class="col-sm-1 pull-right">
                        <div class="form-group">
                          <button  type="button" class="btn btn-success" id="add_onupdate_save" name="add_onupdate_save">Update</button>
                          <!-- <button type="submit" class="btn btn-primary" id="submit">Submit</button> -->
                        </div>                        
                      </div>  
                  </div>                  
                <!-- /.col --> 

                </div>
              
            </div>
          <!-- Dynamic table append input rows Barcode and add row option in case of update Detail Table end  -->

        <!-- /.col -->
        <!-- last ten barcodes start -->

  <div class="box" >
            <div class="box-header with-border">
              <h3 class="box-title">Last Ten Barcodes</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-md-12"><!-- Custom Tabs -->
                 <table id="dekit_ten_barc" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Barcode</th>
                      <th>Description</th>
                      <th>Condition</th>
                      <th>Mpn</th>
                      <th>Brand</th>
                      <th>Upc</th>

                      </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <?php foreach($data['last_ten'] as $last_ten) : ?>
                       <td><?php echo $last_ten['BARCODE_NO'];?></td>
                       <td><?php echo $last_ten['ITEM_DESC'];?></td>
                       <td><?php echo $last_ten['COND_NAME'];?></td>
                       <td><?php echo $last_ten['ITEM_MT_MFG_PART_NO'];?></td>
                       <td><?php echo $last_ten['ITEM_MT_MANUFACTURE'];?></td>
                       <td><?php echo $last_ten['ITEM_MT_UPC'];?></td>
                    </tr>
                     <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
                  
                <!-- /.col --> 

                </div>
              
            </div>

  
            
              
          

  <!-- last ten barcodes end -->
      </section>
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
      <!-- /.row -->

    <!-- /.content -->
  </div>
  

  <div id="danger-modal" class="modal modal-danger fade" role="dialog" style="width: 100%;">
  <div class="modal-dialog" style="width: 50%;height:100px !important;">
    <!-- Modal content-->
    <div class="modal-content" style="width: 100%; ">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" > 
          <p> Det Barcode Deleted Successfully !</p>         

        </section>                  
      </div>
      <div class="modal-footer">

          <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 

<div id="warning-modal" class="modal modal-warning fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Seller Notes</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p> Are you sure you want to delete?</p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
          <button type="button" id="delSpecific" class="btn btn-outline pull-right" data-dismiss="modal">Delete</button> 
          <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div>

<div id="success-modal" class="modal modal-success fade" role="dialog" ">
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" > 
          <p id="successMessage"> </p>         

        </section>                  
      </div>
      <div class="modal-footer">
          <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 

<div id="edit-modal" class="modal modal-info fade" role="dialog" style="width: 100%;">
  <div class="modal-dialog" style="width: 70%;height:100px !important;">
    <!-- Modal content-->
    <div class="modal-content" style="width: 100%; ">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit</h4>
      </div>
      <div class="modal-body" >
        <section class="content" id="appCat"> 

        </section>                  
      </div>
      <div class="modal-footer">
          <button type="button" id="updateSpec" class="btn btn-outline pull-right" data-dismiss="modal">Update</button> 
          <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 
          
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>

<script text="javascript">

  $(document).ready(function()
  {
     $('#dekit_ten_barc').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});
  var tableData = '';
    $(document).ready(function(){
      $('#dyn_box').hide();
      $('#dyn_box2').hide();
      $('#dyn_box3').hide();

      
    });

    /*=========================================================
  function on add button for append new field for input start on update add
  ===========================================================*/
 var l=0;
 $('#update_add').on('click',function(){
  $("#update_add").prop("disabled", true);
 
  var up_bin_id = $('#up_bin_rack'+l).val();

  var category = $('#it_cat').val();
  // var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];
       // alert(data.length);return false;
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
        }

        for(var k = 0;k<data.bin.length;k++){
        bin.push('<option value="'+data.bin[k].BIN_ID+'">'+data.bin[k].BIN_NO+'</option>')
        }
         for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == up_bin_id) {
            var bin_selected = "selected";
          }else{
            var bin_selected = "";
          }
        bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
      
        }

        //console.log(bin);
        
        $('#tab_add_onupdate').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+l+'" name="sr_no" value=""  readonly></div></td><td style="width:260px;"><div style="width:260px;"> <select id="up_cond_item'+l+'" style="width:260px;" name="up_cond_item" class="form-control up_cond_item" data-live-search ="true"><option value="">Select Condition</option><option value="3000">Used</option><option value="1500">New other</option><option value="2000">Manufacturer refurbished</option><option value="2500">Seller refurbished</option><option value="1000">New</option><option value="7000">For parts or not working</option></select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control up_object_desc" style="width:270px;" data-live-search ="true" id="up_object_desc'+l+'" name="up_object_desc" ><option value="">Select Object</option>'+obj.join("")+'</select> </div></td> <td style="width:140px;"><div style="width:140px;"><input type="number" class="form-control up_weight_in" id="up_weight_in'+l+'" name="up_weight_in" value="0" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"> <select class="form-control up_bin_rack" data-live-search ="true" id="up_bin_rack'+l+'"  name="up_bin_rack" style="width:140px;"><option value="">Select Bin</option>'+bin.join("")+'</select></div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control up_remarks" id="up_remarks'+l+'"  name="up_remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+l+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>'); 

         $('.up_cond_item').selectpicker();
         $('.up_object_desc').selectpicker();
         $('.up_bin_rack').selectpicker();
          $("#update_add").prop("disabled", false);

         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      });
        l++;
         
});// function on add button for append new field for input on update add end  

 /*=========================================================
  save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  start
  ===========================================================*/ 
 $('#add_onupdate_save').on('click', function(){ 
  console.log("add on update ");
  //return false;
  var arr=[];
  var up_cond_item =[];
  var up_object_desc =[];
  var up_bin_rack =[];
  var up_remarks =[];
  var up_weight_in =[];

  var count_table_rows= $("body #tab_add_onupdate tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "tab_add_onupdate";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);

  for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".up_cond_item").each(function() {
              if($(this).val() != ""){
              up_cond_item.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".up_object_desc").each(function() {
              if($(this).val() != ""){
              up_object_desc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".up_weight_in").each(function() {
              //if($(this).val() != ""){
              up_weight_in.push($(this).val());
            //}
            }); 
            $(tdbk.rows[i]).find(".up_bin_rack").each(function() {
              if($(this).val() != ""){
              up_bin_rack.push($(this).val());
            }
            }); 

            $(tdbk.rows[i]).find('.up_remarks').each(function() {
             // if($(this).val() != ""){
              up_remarks.push($(this).val());
            //}
            });                         
          } 
                

  var master_barcode = $('#master_barcode').val();  
  console.log(master_barcode,up_cond_item,up_object_desc,up_weight_in,up_bin_rack,up_remarks) ;
        //return false;

  var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/add_onupdate';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'up_cond_item': up_cond_item,
            'up_object_desc': up_object_desc,
            'up_bin_rack': up_bin_rack,
            'up_weight_in': up_weight_in,
            'up_remarks': up_remarks,
            'master_barcode': master_barcode
          },
          dataType: 'json',
          success: function (data){
            $(".loader").hide();
              if(data == true){
                $('#dyn_box2').show();
                show_master_detail();
                $('#dynamic_tab_body').html("");
                $('#tab_add_onupdate_body').html("");
                 
                }else{
              alert('Data not saved');
              
             }
            
           }
      });  
 });//save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end

    // get master barcode info on blur start
    //**************************************
 $(document).on('blur','#master_barcode', function(){
    var master_barcode = $(this).val();
    
    if(master_barcode == ''){ 
      //alert('Please Enter Barcode');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Warning: Please Enter Barcode No !</strong></p>');
        // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 1800); 
      
      return false;
      

    }else{
    
    //$(".loader").show();
     $.ajax({
            type: 'POST',
            dataType: 'json',
            url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/master_barcode_det',
            data:{ 
                  'master_barcode' : master_barcode
                  },
           success: function (data) {
            $(".loader").hide();
            console.log(data);            
            
            
            if(data){
              var det =data.master_bar[0].ITEM_MT_DESC;
            var cond_seg =data.master_bar[0].CONDITIONS_SEG5;
            var mpn =data.master_bar[0].ITEM_MT_MFG_PART_NO;
            var it_cat =data.master_bar[0].CATEGORY_ID;
              $("#item_detail").val(det);             
              $("#it_cond").val(cond_seg);             
              $("#item_mpn").val(mpn);             
              $("#it_cat").val(it_cat);             
              
          }else{
            $("#item_detail").val(det);             
              $("#it_cond").val(cond_seg);             
              $("#item_mpn").val(mpn);             
              $("#it_cat").val(it_cat); 
          }
          
        }
                 
      //     }, //success
      //    complete: function(data){
      //   $(".loader").hide();
      // } 
    }); ///ajax call
   }
  });// get master barcode info on blur End
    //**************************************

//function to remove row on button class btn_remove start
       $(document).on('click','.btn_remove',function(){ 
          var row = $(this).closest('tr');
          var dynamicValue = $(row).find('.dynamic').val();
          dynamicValue = parseInt(dynamicValue);
          row.remove();
            // again call serial no function when row delete for keep serial no 
            $('.dynamic').each(function(idx, elem){
              $(elem).val(idx+1);
            });
        });
//function to remove row on button class btn_remove start


 /*=========================================================
  save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  start
  ===========================================================*/ 
 $('#dynamic-tab-save').on('click', function(){ 
  var arr=[];
  var cond_item =[];
  var object_desc =[];
  var bin_rack =[];
  var remarks =[];
  var weight_in =[];

  var count_table_rows= $("body #dynamic_tab_dekit tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "dynamic_tab_dekit";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);

  for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".cond_item").each(function() {
              if($(this).val() != ""){
              cond_item.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".object_desc").each(function() {
              if($(this).val() != ""){
              object_desc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".weight_in").each(function() {
              //if($(this).val() != ""){
              weight_in.push($(this).val());
            //}
            }); 
            $(tdbk.rows[i]).find(".bin_rack").each(function() {
              if($(this).val() != ""){
              bin_rack.push($(this).val());
            }
            }); 

            $(tdbk.rows[i]).find('.remarks').each(function() {
             // if($(this).val() != ""){
              remarks.push($(this).val());
            //}
            });                         
          }          

  var master_barcode = $('#master_barcode').val();   

  var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'cond_item': cond_item,
            'object_desc': object_desc,
            'bin_rack': bin_rack,
            'weight_in': weight_in,
            'remarks': remarks,
            'master_barcode': master_barcode
          },
          dataType: 'json',
          success: function (data){            
              if(data == true){
                $(".loader").hide();
                  alert('Components added Successfully!');
                  $('#dyn_box').hide();
                   $('#dynamic_tab_body').html("");
                   $('#dyn_box2').show();
                  show_master_detail();                 
                 
                }else{
              alert('data not saved');
              
             }
            
           }
      });  
 });//save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end


 // generate barcode start

   $('#save_bar_qty').on('click', function(){ 
  
  var master_barcode = $('#master_barcode').val();   
  var bar_qty = $('#bar_qty').val();   

  var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode_qty';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'master_barcode': master_barcode,
            'bar_qty': bar_qty
          },
          dataType: 'json',
          success: function (data){            
              if(data == true){
                $(".loader").hide();
                  alert('Components added Successfully!');
                  $('#dyn_box').hide();
                   $('#dynamic_tab_body').html("");
                   $('#dyn_box2').show();
                  show_master_detail();                 
                 
                }else{
              alert('data not saved');
              
             }
            
           }
      });  
 });//save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end

 // generate barcode end

/*=========================================================================
=           Function for append detail in table of saved barcode Start    =
=========================================================================*/
 function show_master_detail(){

            $('#dyn_box3').show();

           var master_barcode = $('#master_barcode').val();
           console.log(master_barcode);
           
             $.ajax({
                url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/showMasterDetails', 
                type: 'post',
                dataType: 'json',
                data : {'master_barcode':master_barcode},
                success:function(data){
                  if(data.res == 2){
                  console.log('success:function');
                  var arr = [];
                  var k = data.det.length;
                  for(var i=0;i<data.det.length;i++){

                    //var j = i + 1;
                    // var cond = '';
                    // if(data.det[i].CONDITION_ID == 1000){
                    //   cond = 'New';
                    // }
                    // if(data.det[i].CONDITION_ID == 3000){
                    //   cond = 'Used';
                    // }
                    // if(data.det[i].CONDITION_ID == 1500){
                    //   cond = 'New Other';
                    // }
                    // if(data.det[i].CONDITION_ID == 2000){
                    //   cond = 'Manufacturer refurbished';
                    // }
                    // if(data.det[i].CONDITION_ID == 2500){
                    //   cond = 'Seller refurbished';
                    // }
                    // if(data.det[i].CONDITION_ID == 7000){
                    //   cond = 'For parts or not working';
                    // }
                     var dekit = data.det[i].DEKIT_REMARKS;
                      if( typeof dekit == 'object'){
                        dekit = JSON.stringify(dekit);
                        dekit = '';
                        // alert(dekit);
                      }
                      if( dekit !== ''){
                        dekit = dekit.replace(/"/g, "'");

                      }
                      console.log(dekit);
                      if(data.det[i].PRINT_STATUS == 'True' ){
                        var html = '<div ><span class="fa fa-check" aria-hidden="true" style="color:green; font-size:30px;"></span></div>';

                      }else if(data.det[i].PRINT_STATUS == 'False'){
                        var html = '<div><span  class="fa fa-close" aria-hidden="true" style="color:red; font-size:30px;"></div>';
                      }else{

                        var html = '<div><input type="text"  class="form-control barcode_no" value="'+data.det[i].PRINT_STATUS+'" readonly></div>';

                      }
                      



                    arr.push('<tr> <td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control " id="sr_no2'+k+'" name="sr_no2" value="'+k+'"  readonly></div></td><td><div style="width:100px;" class="p-t-5"><button class="btn btn-xs btn-danger delete_spec" id="delete_'+data.det[i].LZ_DEKIT_US_DT_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-trash " aria-hidden="true"></span></button><button class="btn btn-xs btn-warning edit_spec" id="edit_'+data.det[i].LZ_DEKIT_US_DT_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><a style="margin-left: 3px;" href="<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/print_single_us_pk/'+data.det[i].LZ_DEKIT_US_DT_ID+'" class="btn btn-primary btn-xs" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a></div></td> <td><div style="width:200px;"><input type="text" id="barcode_no'+i+'" class="form-control barcode_no" value="'+data.det[i].BARCODE_PRV_NO+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="obj_name'+i+'" class="form-control obj_name" value="'+data.det[i].OBJECT_NAME+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="condition'+i+'" class="form-control condition" value="'+data.det[i].COND_NAME+'" readonly></div></td><td><div style="width:100px;"><input type="text" id="weight'+i+'" class="form-control weight" value="'+data.det[i].WEIGHT+'" readonly></div></td><td><div style="width:100px;"><input type="text" id="binRack_no'+i+'" class="form-control binRack_no" value="'+data.det[i].BIN_NO+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="det_ramarks'+i+'" class="form-control get_det_ramarks" value="'+dekit+'" ><input type="hidden" id="get_det_id'+i+'" class="form-control get_det_id" value="'+data.det[i].LZ_DEKIT_US_DT_ID+'" ></div></td><td>'+html+'</td> </tr>'); 

                    k--;

                  }


                  $('#table_body ').html("");


                  
                 $('#table_body ').append(arr.join("")); 
                 //function for adding serial no against class name dynamic start
         $('.dynamic_up').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
                  //arr = ''; 
                  $(".loader").hide();       

                  
                }
                  
                }
            });
          }


// function to save remarks start

$('#Save_rema').on('click', function(){ 
  var get_remarks =[];
  var get_det_id =[]; 

  var count_table_rows= $("body #dekit_pk_us tr").length;
  var count_rows = count_table_rows;
  var tableId= "dekit_pk_us";
  
  var tdbk = document.getElementById(tableId);
   
  for (var i = 1; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".get_det_ramarks").each(function() {
            //  if($(this).val() != ""){
              get_remarks.push($(this).val());
            
            });
            $(tdbk.rows[i]).find(".get_det_id").each(function() {
            //  if($(this).val() != ""){
              get_det_id.push($(this).val());
            
            });                         
          }

  var master_barcode = $('#master_barcode').val();   
  var bar_qty = $('#bar_qty').val();   

  var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/Save_deki_remarks';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'get_remarks': get_remarks,
            'get_det_id': get_det_id
          },
          dataType: 'json',
          success: function (data){ 
            $(".loader").hide(); 
          if (data ==true){


            alert('Remarks Saved');
            return false;
          }else{
            

            alert('Error');
            return false;

          }

          }      
             
      });  
 });


// function to save remarks end

/*=======================================================================
=           Function for append detail in table of saved barcode End    =
=========================================================================*/
$(document).on('blur','#master_barcode', function(){
//$(document).on('click','#search_m_barcode',function(){
  $('#dynamic_tab_body').html('');
  var master_barcode = $('#master_barcode').val();
  //console.log(master_barcode);
  //tableData.destroy();

  //$(".loader").show();

                $.ajax({
                url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/showMasterDetails', 
                type: 'post',
                dataType: 'json',
                data : {'master_barcode':master_barcode},
                success:function(data){
                  $(".loader").hide();
                  if(data == 1){
                  console.log('add barcode function');

                  $('#dyn_box').show();
                  $('#dyn_box2').hide();
                  $('#dyn_box3').hide();
  /*=========================================================
  function on add button for append new field for input start
  ===========================================================*/
 var i=0;
 $('#add').on('click',function(){
  $("#add").prop("disabled", true);
  var category = $('#it_cat').val();
  var binId = $('#bin_rack'+i).val();
  console.log(binId,'#bin_rack'+i);
  // var url='<?php //echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
          //console.log(data.rack_bin_id); return false;
        obj = [];
        bin = [];
        
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
         
        }


        for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == binId) {
            var bin_selected = "selected";
          }else{
            var bin_selected = "";
          }
        bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
      
        }
        //console.log(bin);

        
        $('#dynamic_tab_dekit').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no" value=""  readonly></div></td><td style="width:260px;"><div style="width:260px;"> <select id="cond_item'+i+'" style="width:260px;" name="cond_item" class="form-control cond_item" data-live-search ="true"><option value="3000">Used</option><option value="1500">New other</option><option value="2000">Manufacturer refurbished</option><option value="2500">Seller refurbished</option><option value="1000">New</option><option value="7000">For parts or not working</option></select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control object_desc" style="width:270px;" data-live-search ="true" id="object_desc'+i+'" name="object_desc" >'+obj.join("")+'</select> </div></td> <td style="width:140px;"><div style="width:140px;"><input type="number" class="form-control weight_in" id="weight_in'+i+'" name="weight_in" value="0" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"> <select class="form-control bin_rack" id="bin_rack'+i+'"  data-live-search ="true" name="bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control remarks" id="remarks'+i+'"  name="remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>'); 

         $('.cond_item').selectpicker();
         $('.object_desc').selectpicker();
         $('body .bin_rack').selectpicker();
         $("#add").prop("disabled", false);

//          var e = document.getElementById("#bin_rack");
// var strUser = e.options[e.selectedIndex].value;
//   console.log(strUser);

        //  var get = $('#bin_rack').val();
        // console.log(get);
         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      }); 
      i++;        
});// function on add button for append new field for input end 
                  }else if(data == 3){
                      //alert('Please Enter Barcode');
                  $('#errorMessage').html("");
                    $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Warning: Invalid Barcode No! Try another Barcode</strong></p>')
                    // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
                     $('#errorMessage').show();
                    setTimeout(function() {
                      $('#errorMessage').fadeOut('slow');
                    }, 1800); 
                   $('#dyn_box').hide();
                    $('#dyn_box2').hide();
                    $('#dyn_box3').hide();
                    console.log('invalid barcode function');
                  return false;
                   


                  }else if(data.res == 2){
                    console.log('update barcoe function');
                    $('#errorMessage').html("");
                    $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Barcode No Already Dekited</strong></p>')
                    // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
                     $('#errorMessage').show();
                    setTimeout(function() {
                      $('#errorMessage').fadeOut('slow');
                    }, 1800); 
                    $('#dyn_box').hide();
                    //$('#table_body').html('');
                    $('#dyn_box2').show();

                    $(".loader").show();
                    show_master_detail();// call function which get's records against master barcode 
                  }
                }
            });
    });

  

// class = .delete_spec button for deleting records start
//*******************************************************  
$(document).on('click','.delete_spec',function(){
  var det_id = this.id.match(/\d+/);
  det_id = parseInt(det_id);
  var master_barcode = $('#master_barcode').val();
  $.ajax({
    url: '<?php echo base_url();?>dekitting_pk_us/c_dekitting_us/deleteDeKitDet', 
    type: 'post',
    dataType: 'json',
    data : {'det_id':det_id},
    success:function(data){
      if(data == 1){
        $('#danger-modal').modal('show');
        $(".loader").show();
        show_master_detail(); // call function which get's records against master barcode                 
      }
    }
  });
});// class = .delete_spec button for deleting records end
  //******************************************************


/*=============================================
=            Section comment block            =
=============================================*/
$(document).on('click','.edit_spec',function(){
  var det_id = this.id.match(/\d+/);
  det_id = parseInt(det_id);
 $('#edit-modal').modal('show');
 $("#appCat").html("");
 $('#master_barcode').val();
 var category = $('#it_cat').val();
  var master_barcode = $('#master_barcode').val();

    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/update_obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];

        $.ajax({
          url: '<?php echo base_url();?>dekitting_pk_us/c_dekitting_us/getDetDetails', 
          type: 'post',
          dataType: 'json',
          data : {'det_id':det_id},
          success:function(result){
            console.log(result.selectable[0].OBJECT_ID);
            for(var j = 0;j<data.obj.length;j++){
          if (data.obj[j].OBJECT_ID == result.selectable[0].OBJECT_ID) {
            var objSlected = 'selected';
          }else{
            var objSlected = '';
          }
          
          obj.push('<option value="'+data.obj[j].OBJECT_ID+'" '+objSlected+'>'+data.obj[j].OBJECT_NAME+'</option>'); 
        }

        for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == result.selectable[0].BIN_ID) {
            var binSlected = 'selected';
          }else{
            var binSlected = '';
          }
          bin.push('<option value="'+data.bin[k].BIN_ID+'" '+binSlected+'>'+data.bin[k].BIN_NO+'</option>');
        }
        ////////////////////////////////////////////////
        //////////////////////////////////////////
        var conditions = [];
        for(var i = 0; i<result.conds.length; i++){
          if (result.selectable[0].CONDITION_ID == result.conds[i].ID){
                var selected = "selected";
                }else{
                  var selected = "";
                } 
              conditions.push('<option value="'+result.conds[i].ID+'" '+selected+'>'+result.conds[i].COND_NAME+'</option>');
            }
        ///////////////////////////////////////////////
        var dekit_remarks = result.selectable[0].DEKIT_REMARKS;
        if (dekit_remarks == null || dekit_remarks == '') {
          dekit_remarks = '';
        }
        //////////////////////////////////////////////
              $('.bin_rackDet').html('');
              $('.object_descDet').html('');
              $('#cond_itemDet').html('');
        ///console.log(result.selectable[0].BIN_ID, result.selectable[0].OBJECT_ID);   
              $("#appCat").append('<table id="detailsOFdet" class="table table-responsive table-striped table-bordered table-hover"><thead><tr><th>Barcode</th> <th>Condition</th> <th>Object</th> <th>Weight</th> <th>BIN/Rack</th> <th>Dekitting Remarks</th></tr></thead><tbody><tr><td style="width:100px;"><div style="width:100%;"><input type="text" id="barcode_noDet" class="form-control barcode_no" value="'+result.selectable[0].BARCODE_PRV_NO+'" readonly></div></td> <td style="width:100px;"><div style="width:100%;"><select id="cond_itemDet" name="cond_item" class="selectpicker form-control cond_item" result-live-search ="true"><option value ="">Select Condtion</option>'+conditions.join("")+'</select></div></td> <td style="width:100px;" ><div><select class="selectpicker form-control object_descDet" result-live-search ="true" id="object_descDet" name="object_desc" ><option value ="">Select Object</option>'+obj.join("")+'</select> </div></td> <td style="width:100px;"><div style="width:100px;"><input type="number" class="form-control weight_in" id="weight_in_det" name="weight_in" value="'+result.selectable[0].WEIGHT+'"  ></div></td><td style="width:100px;"><div style="width:100%;"> <select class="selectpicker form-control bin_rackDet" result-live-search ="true" id="det_bin_rack"  name="bin_rack"><option value ="">Select Bin</option>'+bin.join("")+'</select></div></td> <td style="width:100px;"><div style="width:100%;"><input type="text" class="form-control remarks" id="detRemarkDekit"  name="remarks" value="'+dekit_remarks+'"><input id="DET_dt_id" type="hidden" value="'+result.selectable[0].LZ_DEKIT_US_DT_ID+'"></div></td></tr></tbody></table>');

              $('.bin_rackDet').selectpicker();
              $('.object_descDet').selectpicker();
              $('#cond_itemDet').selectpicker();
              }
            });
          }
        });  
});

$(document).on('click','#updateSpec',function(){
  var barcode = $('#barcode_noDet').val();
  var condition = $('#cond_itemDet').val();
  var object  = $('#object_descDet').val();
  var weight = $('#weight_in_det').val();
  var dekit_remark = $('#detRemarkDekit').val();
  var bin = $('#det_bin_rack').val();
  var det_id = $('#DET_dt_id').val();

  det_id = parseInt(det_id);
    // console.log(det_id);

  $('#master_barcode').val();
  var master_barcode = $('#master_barcode').val();

  $.ajax({
      url: '<?php echo base_url();?>dekitting_pk_us/c_dekitting_us/updateDetKit', 
      type: 'post',
      resultType: 'json',
      data : {'det_id':det_id,'bin':bin,'dekit_remark':dekit_remark,'weight':weight,'object':object,'condition':condition,'barcode':barcode},
      success:function(data){
        if(data == 1){
          $('#successMessage').text('successMessage');
          $('#successMessage').text('Updated Successfully !!!');
          $('#success-modal').modal('show');
        }else{
          alert('item not updated !');
        }
      }
  });
});

//print all button for all sticker printing start
//***********************************************
$(document).on('click','#print',function(){

  var master_barcode = $('#master_barcode').val();
  window.open("<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/print_all_us_pk/"+master_barcode,"_blank");
});
//print all button for all sticker printing end
//*********************************************

/*$(document).on('change', ".bin_rack", function(e){
    //e.eventPreventDefault();
    var bins_id = $(this).val();
   var test =  $.session.set('bin_id', 'bins_id');
//$.session.set(‘some key’, ‘a value’);
      //var test = $.session.get("bin_id");
    //var sValue = '<%=HttpContext.Current.Session["bin_id"]%>';

    console.log(test);
  

  //   $.ajax({
  //   url: '<?php //echo base_url();?>dekitting_pk_us/c_dekitting_us/save_bin', 
  //   type: 'post',
  //   dataType: 'json',
  //   data : {'bin_id':bin_id}
  // });
  });*/
</script>
