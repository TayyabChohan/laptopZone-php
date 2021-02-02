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
              <!-- Tester datatable Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Tests View</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form action="<?php echo base_url(); ?>tester/c_tester_screen/search_manifest" method="post" accept-charset="utf-8">
                      <div class="col-sm-8">
                          <div class="form-group">
                          <label for="">Search Manifest by ID:</label>
                            <input class="form-control" type="text" id="test_manifest_id" name="test_manifest_id" value="" placeholder="Enter Manifest ID" >
                          </div>                                     
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group p-t-24">

                            <input type="submit" class="btn btn-primary" id="search_manifest" name="search_manifest" value="Search">

                          </div>
                      </div>
                    </form>                      
                  <div class="col-md-12">
                    
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Un-Tested</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Tested</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                        <?php //var_dump(@$tested_data);exit;?>
                          <?php if (@$tested_data): ?> 
                          <div class="box-body form-scroll">
                            <table id="unTestedData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>ACTION</th>                         
                                  <th>UNIT NO</th>
                                  <th>BARCODE</th>                      
                                  <th>DESC</th>
                                  <th>UPC</th>
                                  <th>MPN</th>
                                  <th>MANUFACTURE</th>
                                  <th>QTY</th>
                                  <th>CONDITION</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                  <?php foreach(@$tested_data['un_tested_qry'] as $un_tested_qry): ?>
                                  <tr>
                                    <td>
                                    <div class="edit_btun">
                                      <a title="Add Test" href="<?php echo base_url();?>tester/c_tester_screen/search_item/<?php echo @$un_tested_qry['IT_BARCODE'] ;?>" class="btn btn-primary btn-xs"><i class="p-b-5 fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>

                                    </div>                                        
                                    </td>
                                    <td><?php echo @$un_tested_qry['UNIT_NO'] ;?></td>
                                    <td><?php echo @$un_tested_qry['IT_BARCODE'] ;?></td>
                                    <td><div style="width: 220px !important;"><?php echo @$un_tested_qry['ITEM_MT_DESC'] ;?></div></td>
                                    <td class="text-center"><?php echo @$un_tested_qry['UPC'] ;?></td>
                                    <td><?php echo @$un_tested_qry['MFG_PART_NO'] ;?></td>                      
                                    <td><?php echo @$un_tested_qry['MANUFACTURER'] ;?></td>
                                    <td class="text-center"><?php echo @$un_tested_qry['AVAIL_QTY'] ;?></td>
                                    <td>
                                    <?php 
                                      if(@$un_tested_qry['ITEM_CONDITION'] == 3000){
                                        echo "Used";
                                      }elseif(@$un_tested_qry['ITEM_CONDITION'] == 1000){
                                        echo "New";
                                      }elseif(@$un_tested_qry['ITEM_CONDITION'] == 1500){
                                        echo "New other";
                                      }elseif(@$un_tested_qry['ITEM_CONDITION'] == 2000){
                                        echo "Manufacturer Refurbished";
                                      }elseif(@$un_tested_qry['ITEM_CONDITION'] == 2500){
                                        echo "Seller Refurbished";
                                      }elseif(@$un_tested_qry['ITEM_CONDITION'] == 7000){
                                        echo "For Parts or Not Working";
                                      }
                                    ?>
                                      
                                    </td>
                                    
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table><br>
                  
                          </div>
           
                        <?php endif; ?>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                          <?php if (@$tested_data): ?> 
                          <div class="box-body form-scroll">
                            <table id="TestedData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th><div style="width: 80px !important;">ACTION</div></th>                          
                                  <th>UNIT NO</th>
                                  <th>BARCODE</th>                      
                                  <th>DESC</th>
                                  <th>UPC</th>
                                  <th>MPN</th>
                                  <th>MANUFACTURE</th>
                                  <th>QTY</th>
                                  <th>CONDITION</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                  <?php foreach(@$tested_data['tested_qry'] as $tested_qry): ?>
                                  <tr>
                                    <td>
                                     <div class="edit_btun" style="width: 100px !important;">
                                     <a title="Edit Item Test" href="<?php echo base_url();?>tester/c_tester_screen/search_item/<?php echo @$tested_qry['IT_BARCODE'] ;?>/test-view" class="btn btn-primary btn-xs" target="_blank"><i style="font-size: 13px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                                     </a>

                                      <a title="Edit Item Test" href="<?php echo base_url();?>tester/c_tester_screen/search_item/<?php echo @$tested_qry['IT_BARCODE'] ;?>" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                    </a>
                                      <a title="Delete Item Test" href="<?php echo base_url();?>tester/c_tester_screen/delete_item_test/<?php echo @$tested_qry['IT_BARCODE'] ;?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                    </a>
                                    </div>  
                                    </td>
                                    <td><?php echo @$tested_qry['UNIT_NO'] ;?></td>
                                    <td><?php echo @$tested_qry['IT_BARCODE'] ;?></td>
                                    <td><div style="width: 220px !important;"><?php echo @$tested_qry['ITEM_MT_DESC'] ;?></div></td>
                                    <td class="text-center"><?php echo @$tested_qry['UPC'] ;?></td>
                                    <td><?php echo @$tested_qry['MFG_PART_NO'] ;?></td>                      
                                    <td><?php echo @$tested_qry['MANUFACTURER'] ;?></td>
                                    <td class="text-center"><?php echo @$tested_qry['AVAIL_QTY'] ;?></td>
                                    <td>
                                    <?php 
                                      if(@$tested_qry['CONDITION_ID'] == 3000){
                                        echo "Used";
                                      }elseif(@$tested_qry['CONDITION_ID'] == 1000){
                                        echo "New";
                                      }elseif(@$tested_qry['CONDITION_ID'] == 1500){
                                        echo "New other";
                                      }elseif(@$tested_qry['CONDITION_ID'] == 2000){
                                        echo "Manufacturer Refurbished";
                                      }elseif(@$tested_qry['CONDITION_ID'] == 2500){
                                        echo "Seller Refurbished";
                                      }elseif(@$tested_qry['CONDITION_ID'] == 7000){
                                        echo "For Parts or Not Working";
                                      }
                                    ?>
                                      
                                    </td>
                                    
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table><br>
                  
                          </div>
           
                        <?php endif; ?>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                  </div>
                  <!-- /.col -->

                </div>
                <!-- /.box-body -->
              </div>
              <!-- Tester datatable End -->            
            </div>
                
                   

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->

 <?php $this->load->view('template/footer'); ?>