 <?php $this->load->view('template/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Single Entry Manifest Sticker

        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Single Entry Manifest Sticker</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Tab Section with Table View start--> 
            <div class="box"> 
              <div id="msg" class="supdated" style="font-size:16px;color:green;font-weight:600;"></div>
              <?php if ($data):
              $manifest_id = $this->uri->segment(4);
               ?> 
                <div class="box-body form-scroll">
                  <div class="col-sm-4 pull-right">
                <a onclick="return reloadWind();" href="<?php echo base_url(); ?>single_entry/c_single_entry/printAllStickers/<?php echo $manifest_id; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">Print All</a>
              </div>
                  <table id="manfDetailSticker" class="table table-bordered table-striped">
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
                        <th>ITEM ID</th>
                        <th>MANIFEST ID</th>                                 
                        <th>REF NO</th>
                         
                      </tr>
                      </thead>
                      <tbody>
                        <?php 
                        //var_dump(@$data);exit;
                        foreach(@$data as $print_qry): ?>
                        <tr>
                          <td>
                            <a onclick="return reloadWind();" href="<?php echo base_url(); ?>single_entry/c_single_entry/manifest_print/<?php echo @$print_qry['LAPTOP_ITEM_CODE'].'/'.@$print_qry['LZ_MANIFEST_ID'].'/'.@$print_qry['IT_BARCODE']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                          </td>
                          <td><?php echo @$print_qry['UNIT_NO'] ;?></td>
                          <td><?php echo @$print_qry['IT_BARCODE'] ;?></td>
                          <td><div style="width: 220px !important;"><?php echo @$print_qry['ITEM_MT_DESC'] ;?></div></td>
                          <td class="text-center"><?php echo @$print_qry['UPC'] ;?></td>
                          <td><?php echo @$print_qry['MFG_PART_NO'] ;?></td>                      
                          <td><?php echo @$print_qry['MANUFACTURER'] ;?></td>
                          <td class="text-center"><?php echo @$print_qry['AVAIL_QTY'] ;?></td>
                          <td>
                          <?php 
                            if(@$print_qry['ITEM_CONDITION'] == 3000){
                              echo "Used";
                            }elseif(@$print_qry['ITEM_CONDITION'] == 1000){
                              echo "New";
                            }elseif(@$print_qry['ITEM_CONDITION'] == 1500){
                              echo "New other";
                            }elseif(@$print_qry['ITEM_CONDITION'] == 2000){
                              echo "Manufacturer Refurbished";
                            }elseif(@$print_qry['ITEM_CONDITION'] == 2500){
                              echo "Seller Refurbished";
                            }elseif(@$print_qry['ITEM_CONDITION'] == 7000){
                              echo "For Parts or Not Working";
                            }
                          ?>
                            
                          </td>
                          <td class="text-center"><?php echo @$print_qry['ITEM_ID'] ;?></td>
                          <td class="text-center"><?php echo @$print_qry['LZ_MANIFEST_ID'] ;?></td>                                
                          <td><?php echo @$print_qry['PURCH_REF_NO'];?></td>
                          
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                  </table><br>
        
                </div>
               <?php endif; ?>
            <!-- /.box-body -->
            </div>
      
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
 <?php $this->load->view('template/footer'); ?>

<script type="text/javascript">

 function reloadWind(){

  location.reload();
 }
</script>