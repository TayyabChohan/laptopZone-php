<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
         Barcode Deletion
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barcode Deletion</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
    
      <div class="row">
        <div class="box"><br>      
          <div class="box-body form-scroll">     
            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table id="barcodeDeletionTable" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                          <th>CONDITION</th>
                          <th>DELETED BY</th>
                          <th>DELETE DATE</th>
                          <th>ITEM TITLE</th>
                          <th>REMARKS</th>
                      </thead>
                      <tbody>
                        <?php
                        $i=1;
                        if($items['deletions']->num_rows() > 0)
                        {
                         foreach ($items['deletions']->result_array() as $barcode) {
                           ?>
                           <tr>
                             <td><?php 
                             $condition_id=$items['condition'];
                             if($condition_id==3000) {
                                echo "Used";
                              }elseif ($condition_id==0) {
                                echo "All";
                              }elseif ($condition_id==1000) {
                                echo "New";
                              }elseif ($condition_id==1500) {
                                echo "New Other";
                              }elseif ($condition_id==2000) {
                                echo "Manufacturer Refurbished";
                              }elseif ($condition_id==2500) {
                                echo "Seller Refurbished";
                              }elseif ($condition_id==7000) {
                                echo "For Parts or Not Working";
                              }  ?></td>
                             <td><?php echo $barcode['USER_NAME']; ?></td>
                             <td><?php echo $items['deleted_date']; ?></td>
                             <td><?php echo $items['item_title']; ?></td>
                             <td><?php echo $items['remarks']; ?></td>                                            
                           <?php
                           $i++;
                          echo "</tr>"; 
                         } 
                         ?>
                          </tbody> 
                        </table>
                       <?php
                      }else {
                        ?>
                        </tbody> 
                         </table>            
                      <?php
                      } ?>
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
     $('#barcodeDeletionTable').DataTable({
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