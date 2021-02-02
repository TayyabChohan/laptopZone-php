<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Item Detail 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lot Item Detail</li>
      </ol>
    </section>  
    <!-- Main content -->

    <section class="content"> 
      <div class="row">
        <div class="box"><br>  
               
          <div class="box-body form-scroll">  
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <h3>Master Manifest</h3>
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
                        <?php foreach($data['master_query'] as $row) :?>
                      
                      <td><a href="<?php echo $row['ITEM_URL']; ?>" target="_blank" > <?php echo $row['EBAY_ID']; ?></a></td>

                      <td><a href="<?php echo base_url();?>catalogueToCash/c_receiving/lot_items_detail/<?php echo $row['LZ_MANIFEST_ID']; ?>" target="_blank" > <?php echo $row['LZ_MANIFEST_ID']; ?></a></td>
                      
                      <td style = ""><?php echo $row['TRACKING_NO'];?></td>
                      <td style = ""><?php echo $row['TITLE'];?></td>
                      <td style = ""><div class="pull-right" ><?php echo $row['COST_PRICE'];?></div></td>
                      
                     
                      </tr>
                        <?php endforeach; ?>
                        
                        
                      </tbody> 
                     
                    </table>
                    <!-- nav-tabs-custom -->
                  </div>  
            <div class="col-md-12">

              <!-- Custom Tabs -->
                 
                    <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                         
                        <th style =" text-align:center; ">Barcode</th>
                        <th style =" text-align:center; ">Mpn</th>
                        <th style =" text-align:center; ">Mpn Description</th>
                        <th style =" text-align:center; ">Qty</th>
                        <th style =" text-align:center; ">Value</th>
                        
                         
                      </thead>
                      <tbody>

                      <tr>

                        <?php 
//                         echo '<pre>';
// print_r($data['master_query']);
// echo '</pre>';
// exit;
foreach($data['query'] as $row) :?>
                      <td style = ""><?php echo $row['BARCODE_NO'];?></td>
                      <td style = ""><?php echo $row['MPN'];?></td>
                      <td style = ""><?php echo $row['MPN_DESCRIPTION'];?></td>
                      <td style = ""><div class="pull-right" ><?php echo $row['AVAILABLE_QTY'];?></div></td>
                      <td style = ""><div class="pull-right" ><?php echo $row['PO_DETAIL_RETIAL_PRICE'];?></div></td>
                      
                     
                      </tr>
                        <?php endforeach; ?>
                        
                        
                      </tbody> 
                     
                    </table>
                    <!-- nav-tabs-custom -->
                  </div>
                <!-- /.col --> 
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
     $('#purchasing-table').DataTable({
  //   "oLanguage": {
  //   "sInfo": "Total Records: _TOTAL_"
  // },
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