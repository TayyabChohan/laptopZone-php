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
        Tests View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tests View</li>
      </ol>
    </section>        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
              <!-- Select Manifest Section Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Search Tests by Manifest</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>

                <!-- /.box-header -->
                <div class="box-body">                   

                    <div class="row">
                      <div class="col-sm-12">
                        <form action="<?php echo base_url(); ?>tester/c_tester_screen/manifestFilters" method="post" accept-charset="utf-8">
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="Search Manifest">Select Manifest:</label>
                                <select class="form-control selectpicker" name="manifest_list" id="manifest_list" data-live-search="true">
                                <?php //var_dump(@$tested_data['manifest_list_qry']);exit; 

                                ?>
                                <?php foreach(@$tested_data['manifest_list_qry'] as $manifest):?>
                                  <option data-tokens="<?php echo $manifest['LZ_MANIFEST_ID']; ?>" value="<?php echo $manifest['LZ_MANIFEST_ID']; ?>" <?php if($this->session->userdata('manifest_id') === $manifest['LZ_MANIFEST_ID'] ){echo "selected";} ?>><?php echo $manifest['MANIFEST_NAME'] ?></option>

                                <?php endforeach;
                                $this->session->unset_userdata('manifest_id');
                                ?>
                                </select>                        
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group p-t-24">
                            <?php if($this->session->userdata('tested')){
                              echo '
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="tested" checked>&nbsp;Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="un_tested">&nbsp;Un-Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="all">&nbsp;All';
                              $this->session->unset_userdata('tested');
                              }elseif($this->session->userdata('un_tested')){
                              echo '
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="tested" >&nbsp;Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="un_tested" checked>&nbsp;Un-Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="all">&nbsp;All';
                              $this->session->unset_userdata('un_tested');                                
                              }elseif($this->session->userdata('all')) {
                              echo '
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="tested" >&nbsp;Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="un_tested" >&nbsp;Un-Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="all" checked>&nbsp;All';
                              $this->session->unset_userdata('all');                                
                              }else{
                              echo '
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="tested" >&nbsp;Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="un_tested" >&nbsp;Un-Tested&nbsp;
                              <input type="radio" name="manifest_filter" id="manifest_filter" value="all">&nbsp;All';                                
                              }
                              ?>                             
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group p-t-24">
                              <input type="submit" class="btn btn-primary btn-sm" name="tested_untested" id="tested_untested" value="Search">
                            </div>
                          </div>
                        </form>
                      <div class="col-sm-2">
                        <div class="form-group p-t-24">
                          <a title="Item Tests List" style="text-decoration: underline!important;" href="<?php echo base_url();?>tester/c_tester_screen/search_manifest" target="_blank">Item Tests List</a>
                        </div>
                      </div>                         
                      </div>
                    <div class="col-sm-12">
                      <?php
                      if(@$tested_data['deleted'] == "deleted"){
                        echo '<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Item Test Deleted Successfully.</strong></div>';
                      }elseif(@$tested_data['not_deleted'] == "not_deleted"){
                        echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error - Item Test not Deleted.</strong></div>';
                      }

                      ?>

                    </div>

                    </div>
                </div>
              </div>
            <!-- Select Manifest Section End -->
            <?php if (!empty($tested_data['filter_qry'])): ?> 
              <!-- Select Category Assign and Un-Assign Section Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Category Assigned Summary</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">                   

                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-hover table-responsive table-striped">
                          <thead>
                            <tr>
                              <th>Total Item</th>
                              <th>Unique Item</th>
                              <th>Unique Categories</th>
                              <th>Assigned Category</th>
                              <th>Un-Assigned Category</th>
                              <th>Tested Items</th>
                              <th>Un-Tested Items</th>
                              <th>Total Checklist</th>
                              <th>Total Specifics</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><?php echo @$tested_data['total_entries'][0]['TOTAL_EXCEL_ROWS']; ?></td>
                              <td><?php echo @$tested_data['unique_item'][0]['UNQ_COUNT']; ?></td>
                              <td><?php echo @$tested_data['uniq_cat_qry'][0]['UNQ_CAT']; ?></td>
                              <td>
                              <?php
                                 $uniq_cat = @$tested_data['uniq_cat_qry'][0]['UNQ_CAT'];
                                 $un_assing_cat = @$tested_data['un_assigned_count_qry'][0]['UN_ASIGN_CAT'];
                                 $assigned_cat = $uniq_cat - $un_assing_cat;
                                 echo $assigned_cat; 
                              ?>
                                
                              </td>
                              <td><?php echo @$tested_data['un_assigned_count_qry'][0]['UN_ASIGN_CAT']; ?></td>
                              <td>
                              <?php
                                $total_entries = @$tested_data['total_entries'][0]['TOTAL_EXCEL_ROWS'];
                                $un_tested = @$tested_data['untested_count_qry'][0]['UN_TESTED_QTY'];
                                $tested = $total_entries - $un_tested;
                                echo $tested; 

                              ?>
                                
                              </td>
                              <td><?php echo @$tested_data['untested_count_qry'][0]['UN_TESTED_QTY']; ?></td>
                              <td>
                                <strong>Assigned:</strong> <?php echo count(@$tested_data['checklist']); ?><br>
                                <strong>Not-Assigned:</strong> 
                                <?php 
                                  $total_checklist = @$tested_data['unique_item'][0]['UNQ_COUNT'];
                                  $assign_checklist = count(@$tested_data['checklist']);
                                  $not_assigned = $total_checklist - $assign_checklist;
                                  echo  $not_assigned;  
                                ?>
                                
                              </td>
                              <td>
                                <strong>Assigned:</strong> <?php echo count(@$tested_data['specific_qry']); ?><br>
                                <strong>Not-Assigned:</strong> 
                                <?php
                                //var_dump(count(@$tested_data['filter_qry']));exit; 
                                  $total_specific = @$tested_data['unique_item'][0]['UNQ_COUNT'];
                                  $assign_specific = count(@$tested_data['specific_qry']);
                                  $not_assigned = $total_specific - $assign_specific;
                                  echo  $not_assigned; 
                                ?>                              
                                
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      
                      </div>  
                    </div>
                </div>
              </div>
            <!-- Select Category Assign and Un-Assign Section End -->                             
              
              <div class="box">

                
                <div class="box-body form-scroll">
                  <table id="unTestedData" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>ACTION</th>
                        <th>LOT ID</th>                         
                        <th>UNIT NO</th>
                        <th>BARCODE</th>                      
                        <th>DESC</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>MANUFACTURE</th>
                        <th>QTY</th>
                        <th>CONDITION</th>
                        <th>CATEGORY</th>
                        <th>CHECKLIST</th>
                        <th>SPECIFICS</th>
                         
                      </tr>
                      </thead>
                      <tbody>
                        <?php foreach(@$tested_data['filter_qry'] as $filter_qry): ?>
                        <tr>
                          <td>
                          <div class="edit_btun" style="width: 120px !important;">
                            <a title="Add Test" href="<?php echo base_url();?>tester/c_tester_screen/search_item/<?php echo @$filter_qry['IT_BARCODE'] ;?>" class="btn btn-primary btn-xs" target="_blank"><i class="p-b-5 fa fa-plus-circle" aria-hidden="true"></i>
                          </a>
                    <?php if(!empty(@$filter_qry['ITEM_CONDITION'])){ ?>
                          <a title="View Item Test" href="<?php echo base_url();?>tester/c_tester_screen/view_test/<?php echo @$filter_qry['IT_BARCODE'] ;?>/test-view" class="btn btn-primary btn-xs" target="_blank"><i style="font-size: 13px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                         </a>

                          <a title="Edit Item Test" href="<?php echo base_url();?>tester/c_tester_screen/search_item/<?php echo @$filter_qry['IT_BARCODE'] ;?>" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                          </a>
                          <a title="Delete Item Test" href="<?php echo base_url();?>tester/c_tester_screen/delete_item_test/<?php echo @$filter_qry['IT_BARCODE'] ;?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                          </a>
                    <?php } ?>      
                        </div>                                                                  
                          </td>
                          <td><?php echo @$filter_qry['PO_DETAIL_LOT_REF'] ;?></td>
                          <td><?php echo @$filter_qry['UNIT_NO'] ;?></td>
                          <td><?php echo @$filter_qry['IT_BARCODE'] ;?></td>
                          <td><div style="width: 220px !important;"><?php echo @$filter_qry['ITEM_MT_DESC'] ;?></div></td>
                          <td class="text-center"><?php echo @$filter_qry['UPC'] ;?></td>
                          <td><?php echo @$filter_qry['MFG_PART_NO'] ;?></td>                      
                          <td><?php echo @$filter_qry['MANUFACTURER'] ;?></td>
                          <td class="text-center"><?php echo @$filter_qry['AVAIL_QTY'] ;?></td>
                          <td>
                          <?php 
                            if(@$filter_qry['ITEM_CONDITION'] == 3000){
                              echo "Used";
                            }elseif(@$filter_qry['ITEM_CONDITION'] == 1000){
                              echo "New";
                            }elseif(@$filter_qry['ITEM_CONDITION'] == 1500){
                              echo "New other";
                            }elseif(@$filter_qry['ITEM_CONDITION'] == 2000){
                              echo "Manufacturer Refurbished";
                            }elseif(@$filter_qry['ITEM_CONDITION'] == 2500){
                              echo "Seller Refurbished";
                            }elseif(@$filter_qry['ITEM_CONDITION'] == 7000){
                              echo "For Parts or Not Working";
                            }
                          ?>
                            
                          </td>
                          <td>
                          <?php
                          @$category = @$filter_qry['BRAND_SEG3'];
                          $allow_ext = array('N/A', 'Other', 'OTHER', 'other', null, ''); 

                          if(!in_array($category, $allow_ext)){?>
                          <a style="text-decoration: underline!important;" href="<?php echo base_url('specifics/c_item_specifics/specific_barcode');?>/<?php echo @$filter_qry['IT_BARCODE'];?>" target="_blank"><?php echo @$filter_qry['BRAND_SEG3'] ;?>
                          </a>
                        <?php }else{ ?>  
                          <a style="text-decoration: underline!important;" href="<?php echo base_url('specifics/c_item_specifics/specific_barcode');?>/<?php echo @$filter_qry['IT_BARCODE'];?>" target="_blank">Update Category Name &amp; ID</a>
                      <?php } ?>    
                          </td>
                          <td>
                            <div style="width: 100px !important;">
                            <?php
                            @$category_id = @$filter_qry['E_BAY_CATA_ID_SEG6'];

                            if(!empty(@$tested_data['checklist'])){
                              foreach(@$tested_data['checklist'] as $cat_id ){
                                if($cat_id['CATEGORY_ID'] == @$category_id){?>
                                  <a id="<?php echo @$cat_id['CATEGORY_ID']; ?>" class="checklist_detail" title="Show Checklist Detail">
                                    <i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                                  </a>                                  
                          <?php   $flag = false;
                                  break;
                                }else{
                                  $flag = true;
                                }
                             } //endforeach

                             if($flag){ ?>
                                <a title="Assign Checklist" class="btn btn-primary btn-xs" href="<?php echo base_url('checklist/c_checklist/search_item_barcode');?>/<?php echo @$filter_qry['IT_BARCODE'];?>" target="_blank">Assign Checklist</a>
                          <?php                              
                             }

                            }else{ ?>

                                <a title="Assign Checklist" class="btn btn-primary btn-xs" href="<?php echo base_url('checklist/c_checklist/search_item_barcode');?>/<?php echo @$filter_qry['IT_BARCODE'];?>" target="_blank">Assign Checklist</a>

                          <?php
                            } //main elseif end

                            ?>
                             
                                 
                            </div>
                          </td>
                          <td>
                          <div style="width: 100px !important;">
                            <?php
                            @$item_id = @$filter_qry['ITEM_ID'];

                            if(!empty(@$tested_data['specific_qry'])){
                              foreach(@$tested_data['specific_qry'] as $specfic ){
                                if($specfic['ITEM_ID'] == @$item_id){?>
                              <button title="Assign Checklist" class="btn btn-success btn-xs" >Specific Found</button>
                            <?php  $flag = false;
                                  break;
                                }else{
                                  $flag = true;
                                }
                             } //endforeach

                             if($flag){ ?>
                                <a title="Assign Specifics" class="btn btn-primary btn-xs" href="<?php echo base_url('specifics/c_item_specifics/search_item');?>/<?php echo @$filter_qry['IT_BARCODE'];?>" target="_blank">Assign Specifics</a>
                          <?php                              
                             }

                            }else{ ?>
                               <a title="Assign Specifics" class="btn btn-primary btn-xs" href="<?php echo base_url('specifics/c_item_specifics/search_item');?>/<?php echo @$filter_qry['IT_BARCODE'];?>" target="_blank">Assign Specifics</a>
                          <?php
                            } //main elseif end
                            ?>                                
                            </div>                            
                          </td>
                          
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table><br>
                </div>
              <?php endif; 
                if(empty(@$tested_data['filter_qry'])){
                  echo '<div class="alert alert-warning alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Record not found.</strong></div>';
                }
              ?>       
          </div><!-- /.col -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>