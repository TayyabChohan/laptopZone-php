<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Items
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lot Items</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="box"><br>  
               
          <div class="box-body form-scroll">  
               
            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                        <th style ="text-align:center;">Action</th>
                        <th style =" text-align:center; ">Barcode No</th>
                        <th style =" text-align:center; ">Item Desc</th>
                        <th style =" text-align:center; ">Condiotion</th>
                        <th style =" text-align:center; ">Cost Price</th>
                        
                         
                      </thead>
                      <tbody>
                      <tr>
                        <?php foreach($data['lot_items'] as $row) :?>
                      <td>
                        <a style=" margin-right: 3px;" href="<?php echo base_url(); ?>locations/c_create_lot/my_lot_sticker/<?php echo @$row['BARCODE_NO']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                         </a>
                         <a style=" margin-right: 3px;" href="<?php echo base_url(); ?>locations/c_create_lot/my_lot_items_dettail/<?php echo @$row['BARCODE_NO']; ?>" title="Details" class="btn btn-info btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                         </a>
                      </td>
                    
                      
                      <td style = ""><?php echo $row['BARCODE_NO'];?></td>
                      <td style = ""><?php echo $row['ITEM_DESC'];?></td>
                      <td style = ""><?php echo $row['CONDITIONS_SEG5'];?></td>
                      <td style = ""><?php echo $row['COST_PRICE'];?></td>
                      
                      
                     
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
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
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