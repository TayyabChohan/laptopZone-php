<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        My Lot Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">My Lot Details</li>
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
                        
                        <th style =" text-align:center; ">Barcode No</th>
                        <th style =" text-align:center; ">Item Desc</th>
                        <th style =" text-align:center; ">Condiotion</th>
                        <th style =" text-align:center; ">Cost Price</th>
                        
                         
                      </thead>
                      <tbody>
                      <tr>
                        <?php foreach($data['get_detail'] as $row) :?>
                      
                    
                      
                      <td style = ""><?php echo $row['BARCODE_NO'];?></td>
                      <td style = ""><?php echo $row['TITLE'];?></td>
                      <td style = ""><?php echo $row['CONDIOTION'];?></td>
                      
            <td style = " font-size:17px; color : red; font-weight:700;"> <div class="pull-right" ><?php echo number_format((float)@($row['COST_PRICE']),2,'.',',').' $';?></div></td>
                      
                      
                     
                      </tr>
                        <?php endforeach; ?>
                        <thead>
                          
                          <th></th>
                          <th ></th>
                          <th ></th>                     
                        </thead>
                         <tr class="info">
                          <td></td>
                          <td></td>
                          
                          
                         
                          <td  style = " font-size:17px; color : red; font-weight:700;"><div class="pull-right" >Total Price $</div></td>
                       
                       <?php 
                       $sum = 0;
                       foreach($data['get_detail'] as $row) :
                     
                      $sum = $sum + $row['COST_PRICE']; 
                       endforeach; ?>

                          <td style = " font-size:17px; color : red; font-weight:700;"> <div class="pull-right" ><?php echo number_format((float)@($sum),2,'.',',').' $';?></div></td>
                        </tr>
                        
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