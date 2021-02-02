<?php $this->load->view('template/header'); ?>

<style>
  #specific_fields{display:none;}
  .specific_attribute{display: none;}
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Custom Attribute & Specifics
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Custom Attribute & Specifics</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <!-- Search Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
                <div class="box-body">
                    <form action="<?php echo base_url(); ?>specifics/c_item_specifics/custom_search_item" method="post" accept-charset="utf-8">
                        <div class="col-sm-8">
                            <div class="form-group">
                            <label for="">Search Item:</label>
                                <input class="form-control" type="text" id="bar_code" name="bar_code" value="<?php echo @$data['item_det'][0]['IT_BARCODE'];?>" placeholder="Search Item">
                            </div>                                     
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group p-t-24">
                                <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                            </div>
                        </div> 
                        <div class="col-sm-2">
                            <div class="form-group">
                                
                            </div>
                        </div>                                
                    </form>
                     <?php if(!empty($data)): ?>
                    <div class="col-sm-8">
                        <div class="form-group">
                        <label for="">Description:</label>
                            <input type="text" class="form-control" name="item_mt_desc" value="<?php echo @$data['item_det'][0]['ITEM_MT_DESC']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label for="">Manufacture:</label>
                            <input type="text" class="form-control" name="manufacturer" value="<?php echo @$data['item_det'][0]['MANUFACTURER']; ?>" readonly>
                        </div>
                    </div> 
                   
                    <div class="col-sm-2">
                    <label for="">MPN:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="item_mpn" name="item_mpn" value="<?php echo @$data['item_det'][0]['MFG_PART_NO']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                    <label for="">UPC:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="item_upc" name="item_upc" value="<?php echo @$data['item_det'][0]['UPC']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                    <label for="">Quantity:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Quantity" value="<?php echo @$data['item_det'][0]['AVAIL_QTY']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Item ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="item_id" id="item_id" value="<?php echo @$data['item_det'][0]['ITEM_ID']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Manifest ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="manifest_id" value="<?php echo @$data['item_det'][0]['LZ_MANIFEST_ID']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Purchase Ref No:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="purch_ref_no" value="<?php echo @$data['item_det'][0]['PURCH_REF_NO']; ?>" readonly>
                        </div>
                    </div>
                    <?php endif; ?> 
                </div>
            </div>
        <!-- Search Start -->                    

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
                   <!--  <form action="<?php //echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8"> -->
                  <?php if(@$data['error_msg'] == true ):?>
                    <div class="col-sm-12">
                      <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Item Category</strong> not found.
                      </div>                   
                    </div>

                    <div class="col-sm-12">
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label for="bar_code">Barcode:</label>
                        <form action="<?php echo base_url('specifics/c_item_specifics/update_cat_id'); ?>" method="post">
                        <input class="form-control" type="text" name="it_barcode" placeholder="Scan Item Barcode" value="<?php echo @$data['item_det'][0]['IT_BARCODE'];  ?>" required>
                       </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Query:</label>
                              <input class="form-control" id="title" name="title" placeholder="Enter UPC/MPN/Description">
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group p-t-24">
                          <a class="crsr-pntr btn btn-primary btn-small" title="Click here for category suggestion" id="Suggest_Categories">Suggest Category</a>
                        </div>
                      </div>
                    </div> 
                     
                      <div class="col-sm-12">  
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="">Category ID:</label>
                              <input type="number" class="form-control" id="category_id" name="category_id" value="<?php //echo @$row->CATEGORY_ID; ?>" required>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="Main Category" class="control-label">Main Category:</label>
                          
                            <input type="text" class="form-control" id="main_category" name="main_category" >
                            
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="Sub Category" class="control-label">Sub Category:</label>
                          
                            <input type="text" class="form-control" id="sub_cat" name="sub_cat" >

                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="Category" class="control-label">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" >
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12"> 
                        <div class="col-sm-2">
                          <div class="form-group">
                            <input type="submit" class="btn btn-success" id="submit" name="submit" value="Save">
                          </div>
                        </div>
                      </div>  
                     </form>
                    <!-- Category Result -->
                    <div id="Categories_result">
                    </div>            
                    <!-- Category Result -->     

                   </div>
               
                  <?php endif; ?>
                  
                    <?php 
                    if(!empty($data) && @$data['error_msg'] != true):?>

                      <input style="display: none;" type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_id'][0]['EBAY_CATEGORY_ID'];  ?>">
 
                  <div class="col-sm-12">
                  <input type="hidden" class="form-control" id="array_count" name="array_count" value="<?php echo count(@$data['mt_id']);  ?>">
                    <?php
                      //$array_count = count(@$data['mt_id']);

                      //var_dump($count);
                    //exit;
                      $i=1;
                      foreach(@$data['mt_id'] as $count):
                    ?>
                      <div class="col-sm-3">
                        <div class="form-group">

                          <label for=""><?php echo @$count['SPECIFIC_NAME'].":"; ?></label>
                          
                         <?php if(@$count['SELECTION_MODE'] == "FreeText"){ 
                          echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" readonly><option value="select">------------Select------------</option>';
                        }elseif(@$count['SELECTION_MODE'] == "SelectionOnly"){
                           echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" readonly><option value="select">------------Select------------</option>';
                        }elseif(@$count['MAX_VALUE'] > 1){
                          echo '<input type="checkbox" name="'.@$count['SPECIFIC_NAME'].'" value="'.@$count['SPECIFIC_VALUE'].'">';
                        }
                          ?>
                          <?php foreach(@$data['specs_qry'] as $specifics): ?>
                                                     
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
              <h3 class="box-title">Add Custom Attribute & Specifics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">
                  <?php 
                    if(!empty($data) && @$data['error_msg'] != true):?>
                      <div class="col-sm-12">

                        <div class="col-sm-3">
                          <button type="button" id="add_attribute" class="btn btn-default btn-block">Enter your own attribute</button><br>
                        </div>
                        <div class="specific_attribute">
                          <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/attribute_value'); ?>" method="post"> -->
                          <div class="col-sm-3">
                            <select class="form-control " name="spec_name" id="spec_name">
                              <!-- <option value="">Select</option> -->
                              <?php
                              foreach(@$data['mt_id'] as $count):
                                
                                 echo '<option>'.@$count['SPECIFIC_NAME'].'</option>';
                          
                              endforeach;
                            ?>
                            </select>                           
                          </div>
                          <div class="col-sm-3">
                            <input class='form-control' type='text' name='custom_attribute' id="custom_attribute" value='' placeholder="Enter your own" />
                          </div>
                          <div class="col-sm-3">
                            <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_id'][0]['EBAY_CATEGORY_ID'];  ?>">
                            <input class="form-control" type="hidden" id="bar_code" name="bar_code" value="<?php echo @$data['item_det'][0]['IT_BARCODE'];?>">
                            <input type="hidden" class="form-control" id="item_mpn" name="item_mpn" value="<?php echo @$data['item_det'][0]['MFG_PART_NO']; ?>">
                            <input type="hidden" class="form-control" id="item_upc" name="item_upc" value="<?php echo @$data['item_det'][0]['UPC']; ?>">
                            <input type="submit" name="save_attr" id="save_attr" class="add-row btn btn-success" value="Save">
                          </div>
                        <!-- </form> -->
                      </div>
                      
                      </div>

                      <div class="col-sm-12" style="margin-top: 15px;">

                        <div class="col-sm-3">
                          <button type="button" id="add_specific" class="btn btn-primary btn-block" >Add your own item specific</button><br>
                          
                        </div>
                     
                        <div id="specific_fields">
                        <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/update_cat_id'); ?>" method="post"> -->
                          <div class='col-sm-3'>
                            <div class='form-group'>
                              <input class='form-control' type='text' name='custom_name' id="custom_name" value='' placeholder='Enter item specific name'/>
                              <span>For example, Brand, Material, or Year</span>
                            </div>
                          </div>
                          <div class='col-sm-3'>
                            <div class='form-group'>
                              <input class='form-control' type='text' name='custom_value' id="custom_value" value='' placeholder='Enter item specific value'/>
                              <span>For example, Ty, plastic, or 2007</span>
                            </div>
                          </div>                                                

                          <div class="col-sm-3">
                            <div class="form-group">
                              <input type="submit" class="btn btn-success btn-small" name="custom_specifics" id="custom_specifics" value="Save">
                            </div>
                          </div>
                          <!-- </form>  -->                             
                        </div>                        
                      </div>
                    <?php endif;?>
                      <div class="col-sm-12">
                        <div class="form-group pull-right">
                          <a href="<?php echo base_url();?>specifics/c_item_specifics" class="btn btn-primary btn-small" title="Title">Back</a>
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
<script type="text/javascript" charset="utf-8">

</script>
 <?php $this->load->view('template/footer'); ?>