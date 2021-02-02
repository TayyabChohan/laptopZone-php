<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Merchant Lot Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Merchant Lot Detail</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12"> 
<!-- 
  warehouse mt form insertion  start-->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Merchant Lot Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'merchant/c_merchant/save_merch_lot'; ?>" method="post" accept-charset="utf-8">   
            

                <div class="col-sm-3">
                        <label >Lot Description</label>
                        <div class="form-group">
                        <input type="text" name="lot_desc" id="lot_desc" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Lot Ref #</label>
                        <div class="form-group">
                        <input type="text" name="lot_ref" id="lot_ref" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Purchase Date</label>
                        <div class='input-group' >
                          <input type='text' class="form-control" name="purch_date"  id="purch_date"  required>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                          </span>                        
                        </div>
                </div>
                <div class="col-sm-2">
                        <label >Minimum Profit %</label>
                        <div class="form-group">
                        <input type="number" name="lot_mini_prof" id="lot_mini_prof" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-1">
                        <label >Cost</label>
                        <div class="form-group">
                        <input type="number" name="lot_cost" id="lot_cost" class="form-control"  required>
                      </div>
                </div>
                <div class="col-sm-2">
                        <label >Source</label>
                        <div class="form-group">
                        <input type="text" name="lot_sourc" id="lot_sourc" class="form-control"  required>
                      </div>
                </div>

                <div class="col-sm-2" style="margin-top:10px;">
                  <label for="avail_lot">Merchant Name:</label>
                  <div class="form-group">
                    <select type="text" name="mer_name" id="mer_name" class="form-control selectpicker" value="" data-live-search="true" required>
                    <option value="">Select Merchant</option>
                    <?php foreach ($merchant as $value) {?>
                      <option <?php if($value['MERCHANT_ID'] == @$this->session->userdata('merchant_id')) echo 'selected="selected"'; ?>  value="<?php echo $value['MERCHANT_ID']; ?>"><?php echo $value['CONTACT_PERSON']; ?></option>
                  <?php }?>

                    </select>

                  </div>
                </div>
                <div class="col-sm-2 p-t-24">                        
                      <div class='input-group' >                        
                      
                      <label  class="control-label" style="color: red;font-size:18px;">Estimate Request:</label>&nbsp;&nbsp;
                        <input type="radio" class="est_reques" name="est_reques" value="1" >&nbsp;Yes&nbsp;&nbsp;
                        <input type="radio" class="est_reques" name="est_reques" value="0" checked>&nbsp;No                      
                      </div>                       
                </div>
                <div class="col-sm-2 p-t-24">                        
                      <div class='input-group' >                        
                      
                      <label  class="control-label" style="color: red; font-size:18px;">Partial Listing :</label>&nbsp;&nbsp;
                        <input type="radio" class="part_lis" name="part_lis" value="1" >&nbsp;Yes&nbsp;&nbsp;
                        <input type="radio" class="part_lis" name="part_lis" value="0" checked>&nbsp;No                      
                      </div>                       
                </div>
                <div class="col-sm-2 p-t-24">                        
                      <div class='input-group' >                        
                      
                      <label  class="control-label" style="color: red; font-size:18px;">Line Item Cost:</label>&nbsp;&nbsp;
                        <input type="radio" class="lis_Cost" name="lis_Cost" value="1" >&nbsp;Yes&nbsp;&nbsp;
                        <input type="radio" class="lis_Cost" name="lis_Cost" value="0" checked>&nbsp;No                      
                      </div>                       
                </div>
                <div class="col-sm-2 p-t-24">                        
                      <div class='input-group' >                        
                      
                      <label  class="control-label" style="color: red; font-size:18px;">Approval Required:</label>&nbsp;&nbsp;
                        <input type="radio" class="appr_list" name="appr_list" value="1" >&nbsp;Yes&nbsp;&nbsp;
                        <input type="radio" class="appr_list" name="appr_list" value="0" checked>&nbsp;No                      
                      </div>                       
                </div> 

              <div class="col-sm-2 ">
                    <div class="form-group">
                      <label  class="control-label"></label>                  
                       <input type="submit" title="Save Merchant Lot" id="save_merch_lot" name = "save_merch_lot" class="btn btn-success form-control" value ="Save Lot">     
                     
                    </div>
              </div>                                                      
                                    
          
            </form>                                              
             
          </div>
         </div>

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

                <table id="merch_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                          <th>Action</th>
                          <th>Lot Id</th>
                          <th>Ref No</th>
                          <th>Lot Description</th>
                          <th>Purchase Date</th>
                          <th>Assign Date</th>
                          <th>Source</th>
                          <th>Cost</th>
                          <th>Profit Required</th>
                          <th>Estimate Request</th>
                          <th>Partial List</th>
                          <th>Item Cost</th>
                          <th>Approve Require</th>                     
                          <th>Lot Status</th>                     
                          <th>Weight / lbs</th>                     
                      
                    </tr>
                  </thead>
                  <tbody>
                        <?php //echo "<pre>" ;
                        //print_r($get_stat['get_merchants']);?>
                      <tr>
                        <?php foreach($lot_deta['merch'] as $merch_det) :?>
                     
                      
                      <td><div><input type="button" class ="btn btn-primary edit_lot" id = "<?php echo @$merch_det['LOT_ID'];?>" name="edit_lot" value="Edit"></div></td>
                      <td><?php echo @$merch_det['LOT_ID'];?></td>
                      <td><?php echo @$merch_det['REF_NO'];?></td>                      
                      <td><?php echo @$merch_det['LOT_DESC'];?></td>                      
                      <td><?php echo @$merch_det['PURCHASE_DATE'];?></td>
                      <td><?php echo @$merch_det['ASSIGN_DATE'];?></td>
                      <td><?php echo @$merch_det['SOURCE'];?></td>
                      <td><?php echo @$merch_det['COST'];?></td>
                      <td><?php echo @$merch_det['PROFIT_REQUIRE'];?></td>
                      <td><?php echo @$merch_det['ESTIMATE_REQUEST'];?></td>
                      <td><?php echo @$merch_det['PARTIAL_LIST'];?></td>
                      <td><?php echo @$merch_det['LINE_ITEM_COST_AVAIL'];?></td>
                      <td><?php echo @$merch_det['APPROVAL_REQUIRE'];?></td>
                      <td><?php echo @$merch_det['LOT_STATUS'];?></td>
                       <td style = " font-size:17px; font-weight:500;"><div class="pull-right" ><?php echo number_format((float)@$merch_det['WEIGHT'],2,'.',',');?></div></td>
                      
                     
                      </tr>
                        <?php endforeach; ?>
                       
                        
                        
                      </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>

        </div>
      </div>


    </section>
 
    <!-- /.content -->
  </div>  
  <div id="edit-modal" class="modal modal-default fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content" >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Lot</h4>
      </div>
      <div class="modal-body" >
        
            <!-- <div class="box-header with-border">
              <h3 class="box-title">Merchant Lot Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>  -->         
          <div class="box-body">

            <div class="col-sm-6">
                <label >Lot Description</label>
                <div class="form-group">
                <input type="text" name="lot_desc_Edit" id="lot_desc_Edit" class="form-control"  required>
                <input type="hidden" name="lot_id_get" id="lot_id_get" class="form-control" value="" required>
                </div>
            </div>
            <div class="col-sm-4">
                <label >Weight / lbs</label>
                <div class="form-group">
                <input type="number" name="lot_wight" id="lot_wight" class="form-control"  required>
                </div>
            </div>                                          
             
          </div>
                                   
      </div>
      <div class="modal-footer">
          <button type="button" id="update_lot" class="btn btn-success pull-right" data-dismiss="modal">Update</button> 
          <button type="button" id="closeSuccess" class="btn btn-dnager pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

  <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>

</div> 


 <?php $this->load->view('template/footer'); ?>

 
  <script>
$(document).ready(function()
  {
     $('#merch_table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
     //"order": [[ 0, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});

 	$('#purch_date').datepicker();
 	$('#merch_act_to').datepicker();
 	

$(document).on('click','.edit_lot',function(){ 

$('#edit-modal').modal('show');  

  var lot_id = $(this).attr('id');
  
  var get_rang_cost_val = $("#get_rang_cost_val").val();  
   $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/get_lot_det',
        type:'post',
        dataType:'json',
        data:{'lot_id':lot_id},
        success:function(data){
          $("#lot_desc_Edit").html('');
          $("#lot_id_get").html('');
          $("#lot_wight").html('');

          $("#lot_desc_Edit").val(data['qur'][0].LOT_DESC);
          $("#lot_id_get").val(data['qur'][0].LOT_ID);
          $("#lot_wight").val(data['qur'][0].WEIGHT);
          

      }
    }); 
});

$(document).on('click','#update_lot',function(){ 

  $(".loader").show();

  var lot_wight = $('#lot_wight').val();
  var lot_id_get = $('#lot_id_get').val();

  var get_rang_cost_val = $("#get_rang_cost_val").val();  
   $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/update_lot',
        type:'post',
        dataType:'json',
        data:{'lot_wight':lot_wight,'lot_id_get':lot_id_get},
        success:function(data){
          $(".loader").hide();

          if(data == true){
            $(".loader").hide();

            $('#edit-modal').modal('hide'); 
            window.location.reload();
            //  alert('Updated!');
            // return false;

          }else{
            $(".loader").hide();

            $('#edit-modal').modal('hide'); 
            window.location.reload();
            alert('Error!');
            return false;
          }
          

      }
    }); 
});
 </script>