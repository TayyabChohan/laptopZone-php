<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kit Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bundle &amp; Kit  Listing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">     
        <div class="box">
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
                   
                        <?php 
                            $itemId=$kits['kit_detail']->result_array()[0]['LZ_BK_ITEM_ID'];
                            $kitId=$kits['kit_detail']->result_array()[0]['LZ_BK_KIT_ID'];
                            $kitName=$kits['kit_detail']->result_array()[0]['LZ_BK_KIT_DESC'];
                            $itemName=$kits['kit_detail']->result_array()[0]['LZ_BK_ITEM_DESC'];
                            $kit_keyword=$kits['kit_detail']->result_array()[0]['KIT_KEYWORD'];
                            $template_id=$kits['kit_detail']->result_array()[0]['LZ_BK_ITEM_TYPE_ID'];
                         ?>
                         <input type="hidden" class="form-control" id="kit_id" name="kit_id" value="<?php echo $kitId; ?>">
                         <input type="hidden" class="form-control" id="template_id" name="template_id" value="<?php echo $template_id; ?>">
                      <div class="col-sm-3">
                        <div class="form-group" style="font-size: 15px;">
                          <b>Kit Name: </b><?php echo $kitName; ?>
                        </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="form-group" style="font-size: 15px;">
                            <b>Item Name: </b><?php echo $itemName; ?>
                          </div>
                      </div>
                      <div class="col-sm-3">
                          <div class="form-group" style="font-size: 15px;">
                            <b>Kit Keyword: </b><?php echo $kit_keyword; ?>
                          </div>
                      </div>

                           
              <div class="panel-body col-md-12  form-scroll">
                <table id="kitDetailTable" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                      <th>ACTION</th>
                      <th>SR. NO</th>
                      <th>COMPONENT NAME</th>
                      <th>EBAY ID</th>
                      <th>ITEM DESC</th>
                      <th>MANUFACTURER</th>                                                             
                      <th>CATEGORY ID</th>
                      <th>CATEGORY NAME</th> 
                      <th>QTY</th>                     
                      <th>MPN</th>
                      <th>UPC</th>
                      <th>ACTIVE PRICE</th>
                      <th>MANUALE PRICE</th>
                      <th>TOTAL PRICE</th>
                  </thead>
                  <tbody>
                      <?php
                      $totalQty=0;
                      $TotalManuapPrice=0;
                      $totalActivePrice=0;
                      $i=1;
                      if($kits['kit_detail']->num_rows() > 0)
                      {
                       foreach ($kits['kit_detail']->result() as $kit) {
                        $kit_detail_id=$kit->LZ_BK_KIT_DET_ID;
                        $component_id=$kit->LZ_COMPONENT_ID;
                        $component_desc=$kit->LZ_COMPONENT_DESC;

                        ?>
                         <tr>
                          <td>
                            <div class="del_button">
	                              <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bk_kit/deleteKitComponent/'.$kit->LZ_BK_KIT_DET_ID.'/'.$kit->LZ_BK_KIT_ID; ?>" onclick="return confirm('Are you sure to delete ?');" class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	                              </a>
                            </div> 
                         </td>
                          <?php 
                          $manualPrice=$kit->MANUAL_PRICE;
                          $activePrice=$kit->ACTIVE_PRICE; 
                          ?>
                         <td><?php echo $i; ?><input type="hidden" class="form-control" id="kit_det_id_<?php echo $i; ?>" name="kit_det_id" value="<?php echo $kit->LZ_BK_KIT_DET_ID; ?>"></td>
                         <td>
                          <select name="item_component" class="form-control selectpicker other_component" required="required" id="component_id_<?php echo $i; ?>" data-live-search="true">
                            <?php                                
                                foreach ($kits['kit_components']->result_array() as $kit_comp){
                                    if($kit_comp['LZ_COMPONENT_ID']==$component_id)
                                      {
                                        $selected="selected";
                                      }else
                                      {
                                        $selected="";
                                      }   
                                    ?>
                                  <option value="<?php echo $kit_comp['LZ_COMPONENT_ID']; ?>"<?php echo $selected; ?> ><?php echo $kit_comp['LZ_COMPONENT_DESC']; ?>                           
                                  </option>
                                  <?php
                                  }
                                  ?>  
                                  <option value="other">Other</option>                                
                            </select>
                              <br>
                              <div id="o_component_id_<?php echo $i; ?>" >
                                
                              </div>         
                         </td> 
                         <td><?php echo $kit->EBAY_ITEM_ID; ?></td>
                         <td><?php echo $kit->ITEM_DESC; ?></td>
                         <td><?php echo $kit->ITEM_MANUFACTURER; ?></td>                                         
                         <td><?php echo $kit->CATEGORY_ID; ?></td>
                         <td><?php echo $kit->CATEGORY_NAME; ?></td>
                         <td><?php echo $kit->QUANTITY; ?></td> 
                         <td><?php echo $kit->ITEM_MPN; ?></td>
                         <td><?php echo $kit->ITEM_UPC; ?></td>                      
                         <td><?php
                         if(!empty($activePrice)){
                          echo '$ '.number_format((float)@$kit->ACTIVE_PRICE,2,'.',',');
                          } ?>
                        </td> 
                         <td><?php 
                         if(!empty($manualPrice))
                         {
                          ?>
                          <input type="text" name="kitManualPrice" class="kitManualPrice" id="component_qty_<?php echo $i; ?>" value="<?php echo '$ '.number_format((float)@$kit->MANUAL_PRICE,2,'.',','); ?>">
                          <?php                           
                          }else
                          { ?>
                            <input type="text" name="kitManualPrice" class="kitManualPrice" id="component_qty_<?php echo $i; ?>" value="<?php echo '$ '.number_format((float)@0,2,'.',','); ?>">
                          <?php }
                           ?>                            
                        </td> 
              							<?php
              								  $qty=$kit->QUANTITY;
              								  $totalQty+=$qty;
              								  if (!empty($manualPrice)){
              								  	$TotalManuapPrice+=$manualPrice;
              								  }
                                if(!empty($activePrice)){
              								  	$totalActivePrice+=$activePrice;
              								  }
              								
              							 ?>
                         <td><?php 
                         /*
                         if(!empty($totalPrice))
                          {
                            echo '$ '.number_format((float)@$totalPrice,2,'.',',');
                          }
                          */
                          ?>
                          </td> 

                         <?php
                         $i++;
                        echo "</tr>"; 
                       } ?>
                       </tbody>                   
                    </table><br>
                    <?php  } else { ?>
                       </tbody>                   
                    </table><br> 
                     <?php }
                      ?>                 
                      <input type="hidden" name="" id="qty_count" value="<?php echo $i-1; ?>">
              				  <div class="form-group col-sm-7">
                          <form action="<?php echo base_url();?>BundleKit/c_bk_kit/addMoreForKit" method="post" class="col-sm-2">
                            <input class="form-control" type="hidden" name="kit_name" id="kit_name" value="<?php echo $kitName; ?>" required="required">
                            <input class="form-control" type="hidden" name="bk_kit_item" id="bk_kit_item" value="<?php echo $itemName; ?>" required="required">
                            <input class="form-control" type="hidden" name="itemId" id="itemId" value="<?php echo $itemId; ?>" required="required">
                            <input class="form-control" type="hidden" name="kitId" id="kitId" value="<?php echo $kitId; ?>" required="required">
                                <div class="form-group  pull-right">
                                  <input class="btn btn-primary" type="submit" name="edit_rofile" id="edit_rofile" value="Add Cmponents"> 
                                </div>                 
                            </form> 
                             <div class="col-sm-2">
                                <div class="form-group">
                                  <button title="Edit Price" id="edit_kit_qty" class="btn btn-primary edit_kit_qty">Update Price
                                </button>
                              </div>                              
                              </div>
                              <div class="col-sm-3">
                                <div class="form-group">
                                  <button title="Edit Kit Components" id="edit_kit_component" class="btn btn-primary edit_kit_component">Update Components
                                  </button>
                                </div>                              
                              </div>
                              <div class="col-sm-1">
                                <div class="form-group">
                                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bk_kit') ?>'" class="btn btn-success">Back
                                  </button>
                                </div>                             
                            </div>                              
                          </div>                        
                          <div class="col-sm-2">
                            <div class="form-group" style="font-size: 18px;">
                                <b>Total Qty = </b><?php echo $totalQty; ?>
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group" style="font-size: 18px; color: red;">      
                              <?php if(!empty($totalActivePrice))
                              { ?>
                                <b>Active Price = </b><?php echo  "&nbsp;$ ".number_format((float)@$totalActivePrice,2,'.',',');
                              } ?>
                            </div>
                            <div class="form-group" style="font-size: 18px; color: green;">      
                              <?php if(!empty($totalActivePrice))
                              { ?>
                                <b>Manual Price = </b><?php echo "&nbsp;";
                                echo  '$ '.number_format((float)@$TotalManuapPrice,2,'.',',');
                              } ?>
                            </div>
                          </div>
                          <div class="col-sm-12">
                              <div class="form-group" style="font-size: 14px;">
                                <label >Note: </label>
                                <i>Manual price is prefferd over active price in Price Summary</i>
                              </div>
                          </div>                         
                        </div>               
                  </div>
                <!-- /.box-body -->
                </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
      </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
   $(document).ready(function()
    {

$("#edit_kit_qty").click(function(){
  var url='<?php echo base_url() ?>BundleKit/c_bk_kit/updateKitPrice';
  var count = $('#qty_count').val(); 
  var component_qty=[];
  var component_id=[];
  var kit_id=$("#kit_id").val();
  var template_id=$("#template_id").val();
  for (var i = 1; i <= count; i++)
  {  
     component_qty.push($('#component_qty_'+i).val());
     component_id.push($('#component_id_'+i).val());
  }
  //alert(component_id); return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:url,
        data: { 
          'component_qty' : component_qty,
          'kit_id' : kit_id,
          'component_id' : component_id
      },
       success: function (data) {
         if(data != ''){
          window.location.href = '<?php echo base_url(); ?>BundleKit/c_bk_kit/showKitDetail/'+kit_id+'/'+template_id;
                   
         }else{
           //$("#success_msg").text('error').css('color', 'red');
           alert('Error: Fail to update data');
         }
       }
      }); 
 });
/**********************************
* FOR UPDATING KIT COMPONENTS
***********************************/
$("#edit_kit_component").click(function(){
  var url='<?php echo base_url() ?>BundleKit/c_bk_kit/updateKitComponents';
  var count = $('#qty_count').val(); 
  var component_id=[];
  var kit_det_id=[];
  var kit_id=$("#kit_id").val();
  var template_id=$("#template_id").val();
  for (var i = 1; i <= count; i++) {  
     component_id.push($('#component_id_'+i).val());
     kit_det_id.push($('#kit_det_id_'+i).val());

  }
  //console.log(kit_det_id); return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:url,
        data: { 
              'kit_id' : kit_id,
              'kit_det_id' : kit_det_id,
              'component_id' : component_id
              },
       success: function (data) {
         if(data != ''){
          window.location.href = '<?php echo base_url(); ?>BundleKit/c_bk_kit/showKitDetail/'+kit_id+'/'+template_id;
                   
         }else{
           //$("#success_msg").text('error').css('color', 'red');
           alert('Error: Fail to update data');
         }
       }
      }); 
 });
 /**********************************
 * FOR OTHER COMPONENTS
 ***********************************/

 $(".other_component").change(function(){ 
    var option_id=$(this).attr("id");
    var option_value=$(this).val();
    //o stands for other and d for dynamic input id
    if (option_value==='other'){
      $('#o_'+option_id).append('<br><input id="d_'+option_id+'" type="text" placeholder="Component Name" /></br><br><button type="button" id="b_'+option_id+'" class="btn btn-primary pull-right">Insert</button>');
        $("#b_"+option_id).click(function(){ 
            //var count = $('#qty_count').val();
            //var new_component=[];
            var new_component=$("#d_"+option_id).val();
             //for (var i = 1; i <= count; i++)
             //{  
                //new_component.push($("#d_"+option_id).val());
             //}
            var kit_id=$("#kit_id").val();
            var template_id=$("#template_id").val();
            var url='<?php echo base_url() ?>BundleKit/c_bk_kit/addNewComponents';
            //console.log(new_component); return false;
            $.ajax({
              dataType: 'json',
              type: 'POST',        
              url:url,
              data: { 
                'kit_id' : kit_id,
                'template_id' : template_id,
                'new_component' : new_component
                    },
            success: function (data){
              if(data != ''){
                window.location.href = '<?php echo base_url(); ?>BundleKit/c_bk_kit/showKitDetail/'+kit_id+'/'+template_id;               
                            }else{
                            alert('Error: Fail to update data');
                                }
                              }
            });
         });
    }else{
      $('#o_'+option_id).remove();
    }
 });
  /********************************************
 * FOR SAVING NEW COMPONENTS INTO FOR TEMPLATES 
 **********************************************/


/**********************************
 * FOR DATA TABLES
 ***********************************/
$('#kitDetailTable').DataTable({
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
 </script>