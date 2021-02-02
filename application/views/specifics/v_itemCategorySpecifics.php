<?php $this->load->view('template/header'); ?>

<style>
  #specific_fields{display:none;}
  .specific_attribute{display: none;}
  #CatalogueGroup{display: none;}
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Custom Attribute &amp; Specifics
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Custom Attribute &amp; Specifics</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

                 

        <!-- Item Specific Start -->
            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Item Specifics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">
                  <div class="col-sm-12">
                    <div class="col-sm-6">
                    <label for="category_id">Category ID:</label>

                      <input type="text" class="form-control" id="category_id" name="category_id" value="<?php echo @$data['cat_query'][0]['CATEGORY_ID'];  ?>" readonly>
                    </div>
                    <div class="col-sm-6">
                    <label for="category_name">Category Name:</label>
                      <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo @$data['cat_query'][0]['CATEGORY_NAME'];  ?>" readonly>
                    </div>
                  </div>

                  
                    <?php 
                    if(!empty($data) && @$data['error_msg'] != true):?>

                      <input style="display: none;" type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_query'][0]['EBAY_CATEGORY_ID'];  ?>">
 
                  <div class="col-sm-12">
                  <input type="hidden" class="form-control" id="array_count" name="array_count" value="<?php echo count(@$data['mt_id']);  ?>">
                    <?php
                      //$array_count = count(@$data['mt_id']);

                      //var_dump($count);
                    //exit;
                      $i=1;
                      foreach(@$data['mt_query'] as $count):
                    ?>
                      <div class="col-sm-3">
                        <div class="form-group">

                          <label for=""><?php echo @$count['SPECIFIC_NAME'].":"; ?></label>
                          
                         <?php if(@$count['SELECTION_MODE'] == "FreeText"){ 
                          echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" readonly><option value="select">------------Select------------</option>';
                        }elseif(@$count['SELECTION_MODE'] == "SelectionOnly"){
                           echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" readonly><option value="select">------------Select------------</option>';
                        }elseif(@$count['SELECTION_MODE'] == "Custom"){
                           echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" readonly><option value="select">------------Select------------</option>';
                        }elseif(@$count['MAX_VALUE'] > 1){
                          echo '<input type="checkbox" name="'.@$count['SPECIFIC_NAME'].'" value="'.@$count['SPECIFIC_VALUE'].'">';
                        }
                          ?>
                          <?php foreach(@$data['det_query'] as $specifics): ?>
                                                     
                            <?php
                              if($specifics['MT_ID'] == @$count['MT_ID']): 
                                   //if(@$specifics['SELECTION_MODE'] == "FreeText"){
                                    echo '<option value="'.@$count['SPECIFIC_NAME'].'">'.@$specifics['SPECIFIC_VALUE'].'</option>';
                      
                                  //}
                                 endif;
                              ?>
                              <?php
                              endforeach;
                            ?>
                           </select>
                          
                          </div>                                     
                        </div>
                        

                      <?php $i++; endforeach; ?>
                      </div>

                                                                         
                      <?php endif; ?>


                    <!-- </form> -->
                </div>
            </div>
        <!-- Item Specific end --> 


        <!-- Item Specific Start -->
            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Custom Attribute &amp; Specifics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">
                  <?php 
                    if(!empty($data) && @$data['error_msg'] != true):?>

                      <div class="col-sm-12 catlogueBlock">

                        <div class="col-sm-3">
                          <button type="button" id="add_attribute" class="btn btn-default btn-block">Enter your own attribute</button><br>
                        </div>
                        <div class="specific_attribute">
                          <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/attribute_value'); ?>" method="post"> -->
                          <div class="col-sm-3">
                            <select class="form-control " name="spec_name" id="spec_name">
                              <!-- <option value="">Select</option> -->
                              <?php
                              foreach(@$data['mt_query'] as $count):
                                
                                 echo '<option value="'.@$count['MT_ID'].'">'.@$count['SPECIFIC_NAME'].'</option>';
                          
                              endforeach;
                            ?>
                            </select>                           
                          </div>
                          <div class="col-sm-3">
                            <input class='form-control' type='text' name='custom_attribute' id="custom_attribute" value='' placeholder="Enter your own" />
                          </div>
                          <div class="col-sm-3">
                            <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_query'][0]['EBAY_CATEGORY_ID'];  ?>">
                            
                            <input type="button" name="cat_custom_attr" id="cat_custom_attr" class="add-row btn btn-success" value="Save">
                          </div>
                        <!-- </form> -->
                      </div>
                      
                      </div>

                      <div class="col-sm-12 catlogueBlock" style="margin-top: 15px;">

                        <div class="col-sm-3">
                          <button type="button" id="add_specific" class="btn btn-primary btn-block" >Add your own item specific</button><br>
                          
                        </div>
                     
                        <div id="specific_fields">
                        <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/update_cat_id'); ?>" method="post"> -->
                          <div class='col-sm-2'>
                            <div class='form-group'>
                              <label for="Specific Name">Specific Name</label>
                              <input class='form-control' type='text' name='custom_name' id="custom_name" value='' placeholder='Enter item specific name'/>
                              <span>For example, Brand, Material, or Year</span>
                            </div>
                          </div>
                          <div class='col-sm-2'>
                            <div class='form-group'>
                              <label for="Specific Value">Specific Value</label>
                              <input class='form-control' type='text' name='custom_value' id="custom_value" value='' placeholder='Enter item specific value'/>
                              <span>For example, Ty, plastic, or 2007</span>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="Selection Mode">Selection Mode</label>
                              <select class="form-control" name="selectionMode" id="selectionMode">
                                <option value="FreeText">FreeText</option>
                                <option value="SelectionOnly">SelectionOnly</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="Max Value">Max Value</label>
                              <input type="number" class="form-control" name="maxValue" id="maxValue" value="1" placeholder="Max Value" required>
                            </div>
                          </div>                                                
<!--                           <div class="col-sm-2">
                            <div class="form-group">
                              
                              <label for="catalogue Only">Catalogue Only&nbsp;&nbsp;</label>
                              <input type="checkbox" name="catalogue_only" id="catalogue_only" value="1" checked disabled>
                              <input type="hidden" name="catalogue_only" id="catalogue_only" value="1">
                            </div>
                          </div> -->
                          <div class="col-sm-1">
                            <div class="form-group p-t-24">
                              <input type="button" class="btn btn-success btn-small" name="custom_specifics" id="custom_specifics" value="Save">
                            </div>
                          </div>
                          <!-- </form>  -->                             
                        </div>                        
                      </div>
                    <?php endif;?>
                      <div class="col-sm-12">
                        <div class="form-group pull-right">
                          <a href="<?php echo base_url();?>bigData/c_bd_recognize_data/recognizeWords" class="btn btn-primary btn-small" title="Title">Back</a>
                        </div>
                      </div>                      

                </div>
            </div>
        <!-- Item Specific end -->                    


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->



 <?php $this->load->view('template/footer'); ?>
<script type="text/javascript" charset="utf-8">
// Custom attribute and specifics
 $("#cat_custom_attr").click(function(){
    // var cat_id = $("#cat_id").val();
    var custom_attribute = $("#custom_attribute").val();
    var mt_id = $('#spec_name').val(); 
  if(custom_attribute == '' || custom_attribute == null){
    alert('Please insert custom attribute value');
    //$("#custom_attribute").focus();
    return false;
  }
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>specifics/c_item_specifics/saveCustomAttribute',
      data: { 'custom_attribute' : custom_attribute, 'mt_id': mt_id},
     success: function (data) {
        if(data == false){
          alert('Attribute value is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          
     }
      }); 
}); 

</script>