 <?php $this->load->view('template/header'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Items Sticker

        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lot Items Sticker</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Tab Section with Table View start-->
            
            <div class="box">
              <div id="msg" class="supdated" style="font-size:16px;color:green;font-weight:600;"></div>
              
                <div class="box-body form-scroll">
                  <div class="col-sm-12">
                    <h3>Master Manifest</h3>
                  </div>              
                  <div class="col-sm-12">                  
                  <table  class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                       
                        <th style =" text-align:center; ">Ebay Id</th>
                        <th style =" text-align:center; ">Manifest No</th>
                        <th style =" text-align:center; ">Tracking No</th>
                        <th style =" text-align:center; ">Title</th>
                        <th style =" text-align:center; ">Cost</th>
                        
                         
                      </thead>
                      <tbody>
                      <tr>
                        <?php foreach($master['master_query'] as $row) :?>
                      
                      <td><a href="<?php echo $row['ITEM_URL']; ?>" target="_blank" > <?php echo $row['EBAY_ID']; ?></a></td>

                      <td><a href="<?php echo base_url();?>catalogueToCash/c_receiving/lot_items_detail/<?php echo $row['LZ_MANIFEST_ID']; ?>" target="_blank" > <?php echo $row['LZ_MANIFEST_ID']; ?></a></td>
                      
                      <td style = ""><?php echo $row['TRACKING_NO'];?></td>
                      <td style = ""><?php echo $row['TITLE'];?></td>
                      <td style = ""><div class="pull-right" ><?php echo $row['COST_PRICE'];?></div></td>
                      
                     
                      </tr>
                        <?php endforeach; ?>
                         
                        
                      </tbody> 
                     
                    </table>
                  </div>
                </div>
               
            <!-- /.box-body -->
            </div>
      
        </div>
        <div class="col-sm-12">
        <!-- Tab Section with Table View start-->
            
            <div class="box">
              <div id="msg" class="supdated" style="font-size:16px;color:green;font-weight:600;"></div>
              <?php if ($data): ?> 
                <div class="box-body form-scroll">
                  <div class="col-sm-12">
                    <div class="form-group pull-right">
                      <?php $lz_manifest_id = @$this->uri->segment(4); //var_dump($lz_manifest_id);exit;?>
                      <a href="<?php echo base_url(); ?>catalogueToCash/c_receiving/lotitemsPrintForAll/<?php echo @$lz_manifest_id; ?>" title="Print Sticker for all barcodes" class="btn btn-primary btn-sm" target="_blank">Print All</a>            
                      
                    </div>
                  </div>              
                  <div class="col-sm-12">                  
                  <table id="lotItemsSticker" class="table table-bordered table-striped table-responsive">
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
                        <th>PRICE</th>
                       
                         
                      </tr>
                      </thead>
                      <tbody>
                        <?php 
                        //var_dump(@$data);exit;
                        foreach(@$data as $print_qry): ?>
                        <tr>
                          <td>
                            <a href="<?php echo base_url(); ?>catalogueToCash/c_receiving/manifest_print/<?php echo @$print_qry['LAPTOP_ITEM_CODE'].'/'.@$print_qry['LZ_MANIFEST_ID'].'/'.@$print_qry['IT_BARCODE']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                          </td>
                          <td><div style="width: 80px !important;"><?php echo @$print_qry['UNIT_NO'] ;?></div></td>
                          <td><?php echo @$print_qry['IT_BARCODE']; ?></td>
                          <td><div style="width: 220px !important;"><?php echo @$print_qry['ITEM_MT_DESC'] ;?></div></td>
                          <td class="text-center"><?php echo @$print_qry['UPC'] ;?></td>
                          <td><?php echo @$print_qry['MFG_PART_NO']; ?></td>                      
                          <td><?php echo @$print_qry['MANUFACTURER']; ?></td>
                          <td class="text-center"><?php echo @$print_qry['AVAIL_QTY'] ;?></td>
                          <td><?php echo @$print_qry['ITEM_CONDITION']; ?></td>
                          <td><?php echo '$ '.number_format((float)@$print_qry['PO_DETAIL_RETIAL_PRICE'],2,'.',''); ?></td>
                         
                          
                          </tr>
                        <?php endforeach; ?>
                        
                      </tbody>
                  </table><br>
                  </div>
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
    $('#lotItemsSticker').DataTable({

      "columnDefs": [
          { "width": "8%", "targets": 0 }
        ], 

      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
    "iDisplayLength": 100,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
 function reloadWind(){

  location.reload();
 }
</script>