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
        Hold Item List
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Hold Item List</li>
      </ol>
    </section>        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
              <!-- Tester datatable Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Hold Item List</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <form action="<?php echo base_url(); ?>tester/c_tester_screen/hold_item_detail" method="post" accept-charset="utf-8">
                      <div class="col-sm-8">
                          <div class="form-group">
                          <label for="">Search Manifest:</label>
                              <input class="form-control" type="text" id="hold_manifest_id" name="hold_manifest_id" value="<?php echo @$data[0]['LZ_MANIFEST_ID'];?>" placeholder="Enter Manifest ID" >


                          </div>                                     
                      </div>
                      <div class="col-sm-2">
                          <div class="form-group p-t-24">

                            <input type="submit" class="btn btn-primary" id="search_manifest" name="search_manifest" value="Search">

                          </div>
                      </div>
                    </form>
                      <div class="col-sm-2">
                        <div class="form-group p-t-24">
                          <a style="text-decoration: underline;" href="<?php echo base_url();?>tester/c_tester_screen/holdedUnholdedLog" target="_blank">Holded &amp; Un-Holded Log</a>
                        </div>
                      </div>                    
                    <div class="col-sm-12">
                      <?php 
                        if(empty(@$data)){
                            echo '<div class="alert alert-warning alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>No Record found against this Manifest.</strong>
                          </div>';
                          //exit;
                        }
                      ?>                      
                    </div> 
                  <div class="col-md-12">
          
                    <?php if (@$data): ?> 
                    <div class="box-body form-scroll">
                      <table id="holdItemData" class="table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>
                              <div style="margin-left: 17px;" class="text-center">
                                <input class="text-center" name="btSelectAll" type="checkbox" onClick="toggle_hold(this)">
                              </div>                              
                            </th>
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
                            <?php foreach(@$data as $row): ?>
                            <tr>
                              <td>
                                <input type="checkbox" class="crsr-pntr btn btn-sm btn-success" style="margin-left:5px; margin-top: 10px; width: 40px!important;float: left;" name="selected_item_hold[]" value="<?php echo @$row['IT_BARCODE'] ;?>">                                
                              </td>
                              <td>
                                <button class="btn btn-primary btn-xs unhold_item" id="<?php echo @$row['IT_BARCODE'] ;?>" name="unhold_item" value="<?php echo @$row['IT_BARCODE'] ;?>">Un-Hold</button>                                       
                              </td>
                              <td><?php echo @$row['UNIT_NO'] ;?></td>
                              <td><?php echo @$row['IT_BARCODE'] ;?></td>
                              <td>
                                <div style="width: 220px !important;"><?php echo @$row['ITEM_MT_DESC'] ;?></div>
                              </td>
                              <td class="text-center"><?php echo @$row['UPC'] ;?></td>
                              <td><?php echo @$row['MFG_PART_NO'] ;?></td>                      
                              <td><?php echo @$row['MANUFACTURER'] ;?></td>
                              <td class="text-center"><?php echo @$row['AVAIL_QTY'] ;?></td>
                              <td>
                              <?php 
                                if(@$row['ITEM_CONDITION'] == 3000){
                                  echo "Used";
                                }elseif(@$row['ITEM_CONDITION'] == "Used"){
                                  echo "Used";
                                }elseif(@$row['ITEM_CONDITION'] == 1000){
                                  echo "New";
                                }elseif(@$row['ITEM_CONDITION'] == "New"){
                                  echo "New";
                                }elseif(@$row['ITEM_CONDITION'] == 1500){
                                  echo "New other";
                                }elseif(@$row['ITEM_CONDITION'] == "New other"){
                                  echo "New other";
                                }elseif(@$row['ITEM_CONDITION'] == 2000){
                                  echo "Manufacturer Refurbished";
                                }elseif(@$row['ITEM_CONDITION'] == "Manufacturer Refurbished"){
                                  echo "Manufacturer Refurbished";
                                }elseif(@$row['ITEM_CONDITION'] == 2500){
                                  echo "Seller Refurbished";
                                }elseif(@$row['ITEM_CONDITION'] == "Seller Refurbished"){
                                  echo "Seller Refurbished";
                                }elseif(@$row['ITEM_CONDITION'] == 7000){
                                  echo "For Parts or Not Working";
                                }elseif(@$row['ITEM_CONDITION'] == "For Parts or Not Working"){
                                  echo "For Parts or Not Working";
                                }
                              ?>
                                
                              </td>
                               <!-- <td class="text-center"><?php //echo @$row['ITEM_ID'] ;?></td>
                               <td class="text-center"><?php //echo @$row['LZ_MANIFEST_ID'] ;?></td> -->                                
                              <td><?php echo @$row['PURCH_REF_NO'];?></td>
                              
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                      </table><br>
                      <div class="col-sm-12">
                        <div class="form-group">
                          <button class="btn btn-primary" id="unhold_all" name="unhold_all">Un-Hold</button>
                        </div>
                      </div>
            
                    </div>
     
                  <?php endif; ?>
                  </div>
                       

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
 <script>
     function toggle_hold(source) {
      checkboxes = document.getElementsByName('selected_item_hold[]');
      for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
  }
 </script>