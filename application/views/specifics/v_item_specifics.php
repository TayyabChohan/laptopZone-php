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
        Item Specifics
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Specifics</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
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
                    <form action="<?php echo base_url(); ?>specifics/c_item_specifics/search_item" method="post" accept-charset="utf-8">
                        <div class="col-sm-6">
                            <div class="form-group">
                            <label for="">Search Item:</label>
                                <input class="form-control" type="text" id="specific_barcode" name="specific_barcode" value="<?php if(@$this->session->userdata('search_barcode')){echo $this->session->userdata('search_barcode');}else{echo @$this->uri->segment(4);}?>" placeholder="Search Item">
                            </div>                                     
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group p-t-24">
                                <input type="submit" class="btn btn-primary" name="submit" value="Search">
                            </div>
                        </div> 
                               
                    </form>

                        <div class="col-sm-2">
                            <div class="form-group p-t-24">
                              <a class="btn btn-primary" href="<?php echo base_url('specifics/c_item_specifics/view_item_specifics');?>" target="_blank">View Item Specifics</a>
                            </div>
                        </div>                     
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
                    <div class="col-sm-2">
                    <label for="">Category Name:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="spec_cat_name" id="spec_cat_name" value="<?php echo @$data['cat_id'][0]['BRAND_SEG3']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Category ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="spec_cat_id" id="spec_cat_id" value="<?php echo @$data['cat_id'][0]['E_BAY_CATA_ID_SEG6']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="form-group pull-right">
                        <a class="btn btn-primary" href="<?php echo base_url('specifics/c_item_specifics/specific_barcode');?>/<?php echo @$data['item_det'][0]['IT_BARCODE'];?>" target="_blank">Update Category Name &amp; ID</a>
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
                        // echo "<pre>";
                        // print_r($data['mt_id']); 
                    ?>
                      <div class="col-sm-3">

                          <input type="hidden" name="spec_<?php echo $i; ?>" id="<?php echo 'specific'.$count['MT_ID']; ?>" value="<?php echo  'specific_'.$i; ?>">
                          
                        <div class="form-group">

                          <label for="" id="<?php echo 'specific_name_'.@$i;?>"><?php echo @$count['SPECIFIC_NAME']; ?></label>
                          
                         <?php if(@$count['MAX_VALUE'] > 1){ 
                         
                          echo '<br><select name="specific_'.@$i.'" id="specific_'.@$i.'" class="selectpicker" multiple><option value="select">------------Select------------</option>';
                        }else{
                           echo '<select class="form-control" name="specific_'.@$i.'" id="specific_'.@$i.'" ><option value="select">------------Select------------</option>';
                        }
                          ?>
                          <?php foreach(@$data['specs_qry'] as $specifics): ?>
                                                     
                            <?php
                              if($specifics['MT_ID'] == @$count['MT_ID']): 
                                   //if(@$specifics['SELECTION_MODE'] == "FreeText"){
                                    echo '<option value="'.htmlentities(@$specifics['SPECIFIC_VALUE']).'">'.@$specifics['SPECIFIC_VALUE'].'</option>';
                      
                                  //}
                                 endif;
                              ?>
                              <?php
                              endforeach;
                            ?>
                           </select>
                          
                          </div>                                     
                        </div>
                        

                      <?php 
                      $i++; 
                      endforeach;
                       ?>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group pull-right">
                          <input type="submit" class="btn btn-success btn-small" name="add_specifics" id="add_specifics" value="Save">
                          <!-- <a href="<?php //echo base_url();?>specifics/c_item_specifics/custom_attribute" target="_blank" class="btn btn-primary btn-small" name="custom_attribute" id="custom_attribute">Add Custom Specifics</a> -->

                          <a href="<?php echo base_url();?>specifics/c_item_specifics/custom_search_item/<?php echo @$data['item_det'][0]['IT_BARCODE'];?>" target="_blank" class="btn btn-primary btn-small" name="custom_attribute" id="custom_attribute">Add Custom Specifics</a>
                        </div>
                      </div> 
                      <div class="col-sm-12">
                   <?php 
                    
                   $i=1; foreach(@$data['specs_value'] as $specs_value): ?>
                      <div class="col-sm-3">
                        <div class="form-group">
                          <label for="" id="<?php echo 'specific_name_'.@$i;?>"><?php echo @$specs_value['SPECIFICS_NAME']; ?></label>
                          <input type="text" class="form-control" id="<?php echo 'specific_name_'.@$i;?>" name="cat_id" value="<?php echo @$specs_value['SPECIFICS_VALUE'];  ?>" readonly>
                        </div>
                      </div>
                    
                    <?php $i++; endforeach; ?>
                    </div>                                                                        
                      <?php endif;

                      //echo "<pre>";
                      //print_r($data['specs_value']);
                      ///exit;

                       ?>


                    <!-- </form> -->
            
                </div>

            </div>

                  
        <!-- Item Specific end --> 

          <!--Item Specifics datatable Start -->
          <!-- <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Item Specifics Detail</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
           
            <?php 
                    //if(!empty($data) && @$data['error_msg'] != true):?>
            <div class="box-body">
              <table id="TestingCheckName" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Action</th>
                    <th>Specific Name</th>
                    <th>Selection Mode</th>
                    <th>Show Detail</th>
                  </tr>
                </thead>
                <tbody>
                <?php //var_dump($data['specs_qry']);exit;?>
                <?php //foreach(@$data['specs_qry'] as $row): ?>
                  <tr>
                    <td>
                      <div class="edit_btun">
                        <a title="Edit Test Check Name" href="<?php //echo base_url();?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                      </a>
                        <a title="Delete Test Name" href="<?php //echo base_url();?>checklist/c_checklist/testing_check_delete/<?php //echo @$row['MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                      </a>
                      </div>                      
                    </td>
                    <td><?php //echo @$row['SPECIFIC_NAME'];?></td>
                    <td><?php// echo @$row['SELECTION_MODE'];?></td>
                    <td> 
                                            
                      <a id="<?php //echo @$row['MT_ID']; ?>" class="show_detail" title="Show Detail">
                      
                        <i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                <?php //endforeach;?>
                </tbody>
              </table>

            </div>
           
          </div> -->
        <?php //endif;?>
          <!-- Item Specifics datatable End -->                           


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->


 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
   $(document).ready(function(){
    var specific_barcode = $("#specific_barcode").val();
    if (specific_barcode !='' || specific_barcode != undefined || specific_barcode != null) {
      $.ajax({
        type:'post',
        url:'<?php echo base_url(); ?>specifics/c_Item_Specifics/selectedValues',
        datatype:'json',
        data:{'specific_barcode':specific_barcode},
        success:function(data){
          var obj = JSON.parse(data);
          
          if (obj.flag==1) {
            for (var i = 0; i < obj.result.length; i++) {
              var spec_name = obj.result[i].SPECIFICS_NAME;
              var spec_val = obj.result[i].SPECIFICS_VALUE;
               var spec_id = $("#specific"+obj.result[i].MT_ID).val();
               $("#"+spec_id).val(spec_val);
            }
          }
          

        },
        error:function(jqXHR, textStatus, errorThrown){
          if (jqXHR.status) {
            alert(jqXHR.status+": "+errorThrown+", Please contact to your Administrator!");
            return false;
          }
        }
      });
    }
   });
 </script>