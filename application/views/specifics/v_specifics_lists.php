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
        Item Specifics List View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Specifics List View</li>
      </ol>
    </section>        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
              <!-- Tester datatable Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Specifics View</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                        <form action="<?php echo base_url(); ?>specifics/c_item_specifics/view_item_specifics" method="post" accept-charset="utf-8">
                            <div class="col-sm-8">
                                <div class="form-group">
                                <label for="">Search Manifest:</label>
                                    <input class="form-control" type="text" id="specifics_manifest" name="specifics_manifest" value="" placeholder="Enter Manifest No" >


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
                        <li class="active"><a href="#tab_1" data-toggle="tab">Not Inserted Specifics</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Inserted Specifics</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                        <?php //var_dump(@$tested_data);exit;?>
                          <?php if (@$data): ?> 
                          <div class="box-body form-scroll">
                            <table id="notInsertedData" class="table table-bordered table-striped">
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
    <!--                               <th>ITEM ID</th>
                                  <th>MANIFEST ID</th>  -->                                
                                  <th>REF NO</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                  <?php foreach(@$data['not_inserted_qry'] as $not_inserted_qry): ?>
                                  <tr>
                                    <td>
                                    <div class="edit_btun">
                                      <a title="Add Item Specifics" href="<?php echo base_url();?>specifics/c_item_specifics/search_item/<?php echo @$not_inserted_qry['IT_BARCODE'] ;?>" class="btn btn-primary btn-xs" target="_blank"><i class="p-b-5 fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>

                                    </div>                                        
                                    </td>
                                    <td><?php echo @$not_inserted_qry['UNIT_NO'] ;?></td>
                                    <td><?php echo @$not_inserted_qry['IT_BARCODE'] ;?></td>
                                    <td><div style="width: 220px !important;"><?php echo @$not_inserted_qry['ITEM_MT_DESC'] ;?></div></td>
                                    <td class="text-center"><?php echo @$not_inserted_qry['UPC'] ;?></td>
                                    <td><?php echo @$not_inserted_qry['MFG_PART_NO'] ;?></td>                      
                                    <td><?php echo @$not_inserted_qry['MANUFACTURER'] ;?></td>
                                    <td class="text-center"><?php echo @$not_inserted_qry['AVAIL_QTY'] ;?></td>
                                    <td>
                                    <?php 
                                      if(@$not_inserted_qry['ITEM_CONDITION'] == 3000 || @$not_inserted_qry['ITEM_CONDITION'] == "Used"){
                                        echo "Used";
                                      }elseif(@$not_inserted_qry['ITEM_CONDITION'] == 1000 || @$not_inserted_qry['ITEM_CONDITION'] == "New"){
                                        echo "New";
                                      }elseif(@$not_inserted_qry['ITEM_CONDITION'] == 1500 || @$not_inserted_qry['ITEM_CONDITION'] == "New other"){
                                        echo "New other";
                                      }elseif(@$not_inserted_qry['ITEM_CONDITION'] == 2000 || @$not_inserted_qry['ITEM_CONDITION'] == "Manufacturer Refurbished"){
                                        echo "Manufacturer Refurbished";
                                      }elseif(@$not_inserted_qry['ITEM_CONDITION'] == 2500 || @$not_inserted_qry['ITEM_CONDITION'] == "Seller Refurbished"){
                                        echo "Seller Refurbished";
                                      }elseif(@$not_inserted_qry['ITEM_CONDITION'] == 7000 || @$not_inserted_qry['ITEM_CONDITION'] == "For Parts or Not Working"){
                                        echo "For Parts or Not Working";
                                      }
                                    ?>
                                      
                                    </td>
                                     <!-- <td class="text-center"><?php //echo @$not_inserted_qry['ITEM_ID'] ;?></td>
                                     <td class="text-center"><?php //echo @$not_inserted_qry['LZ_MANIFEST_ID'] ;?></td> -->                                
                                    <td><?php echo @$not_inserted_qry['PURCH_REF_NO'];?></td>
                                    
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table><br>
                  
                          </div>
           
                        <?php endif; ?>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                          <?php if (@$data): ?> 
                          <div class="box-body form-scroll">
                            <table id="insertedData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <!-- <th><div style="width: 80px !important;">ACTION</div></th> -->                          
                                  <th>UNIT NO</th>
                                  <th>BARCODE</th>                      
                                  <th>DESC</th>
                                  <th>UPC</th>
                                  <th>MPN</th>
                                  <th>MANUFACTURE</th>
                                  <th>QTY</th>
                                  <th>CONDITION</th>
    <!--                               <th>ITEM ID</th>
                                  <th>MANIFEST ID</th>  -->                                
                                  <th>REF NO</th>
                                   
                                </tr>
                                </thead>
                                <tbody>
                                  <?php foreach(@$data['inserted_qry'] as $inserted_qry): ?>
                                  <tr>
<!--                                     <td>
                                     <div class="edit_btun" style="width: 100px !important;">
                                     <a title="Edit Item Test" href="<?php //echo base_url();?>specifics/c_item_specifics/specific_edit/<?php //echo @$inserted_qry['IT_BARCODE'] ;?>/edit-view" class="btn btn-primary btn-xs" target="_blank"><i style="font-size: 13px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                                     </a>

                                      <a title="Edit Item Test" href="<?php //echo base_url();?>specifics/c_item_specifics/specific_edit/<?php //echo @$inserted_qry['IT_BARCODE'] ;?>" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                    </a>
                                      
                                    </div>  
                                    </td> -->
                                    <td><?php echo @$inserted_qry['UNIT_NO'] ;?></td>
                                    <td><?php echo @$inserted_qry['IT_BARCODE'] ;?></td>
                                    <td><div style="width: 220px !important;"><?php echo @$inserted_qry['ITEM_MT_DESC'] ;?></div></td>
                                    <td class="text-center"><?php echo @$inserted_qry['UPC'] ;?></td>
                                    <td><?php echo @$inserted_qry['MFG_PART_NO'] ;?></td>                      
                                    <td><?php echo @$inserted_qry['MANUFACTURER'] ;?></td>
                                    <td class="text-center"><?php echo @$inserted_qry['AVAIL_QTY'] ;?></td>
                                    <td>
                                    <?php 
                                      //echo @$inserted_qry['ITEM_CONDITION'];
                                      if(@$inserted_qry['ITEM_CONDITION'] == 3000 || @$inserted_qry['ITEM_CONDITION'] == "Used"){
                                        echo "Used";
                                      }elseif(@$inserted_qry['ITEM_CONDITION'] == 1000 || @$inserted_qry['ITEM_CONDITION'] == "New"){
                                        echo "New";
                                      }elseif(@$inserted_qry['ITEM_CONDITION'] == 1500 || @$inserted_qry['ITEM_CONDITION'] == "New other"){
                                        echo "New other";
                                      }elseif(@$inserted_qry['ITEM_CONDITION'] == 2000 || @$inserted_qry['ITEM_CONDITION'] == "Manufacturer Refurbished"){
                                        echo "Manufacturer Refurbished";
                                      }elseif(@$inserted_qry['ITEM_CONDITION'] == 2500 || @$inserted_qry['ITEM_CONDITION'] == "Seller Refurbished"){
                                        echo "Seller Refurbished";
                                      }elseif(@$inserted_qry['ITEM_CONDITION'] == 7000 || @$inserted_qry['ITEM_CONDITION'] == "For Parts or Not Working"){
                                        echo "For Parts or Not Working";
                                      }
                                    ?>
                                      
                                    </td>
                                    <!-- <td class="text-center"><?php //echo @$inserted_qry['ITEM_ID'] ;?></td>
                                    <td class="text-center"><?php //echo @$inserted_qry['LZ_MANIFEST_ID'] ;?></td> -->                                
                                    <td><?php echo @$inserted_qry['PURCH_REF_NO'];?></td>
                                    
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