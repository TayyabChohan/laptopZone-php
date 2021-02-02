<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category Detail</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <div class="box">      
          <div class="box-body form-scroll">      
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table id="bd_categoryDetail" class="table table-bordered table-striped " >
                    <thead>
                        <th>CATEGORY ID</th>
                        <th>CATEGORY NAME</th>
                         <th>TOTAL COUNT</th>
                        <th>START DATE</th>
                        <th>LAST RUN</th>
                    </thead>
                     <tbody>
                      <?php
                      $i=1;
                      // echo "<pre>";
                      // print_r($data['count']);
                      // exit;
                      if($data['details']->num_rows() > 0)
                      {
                       foreach ($data['details']->result_array() as $row){
                         ?>
                         <tr>
                            <td><?php echo $row['MAIN_CATEGORY_ID']; ?></td>
                            <td><?php echo $row['CATEGORY_NAME']; ?></td> 
                            <td><?php echo $data['count'][0]['TOTAL']; ?></td>                     
                            <td><?php echo $row['START_TIME']; ?></td>                      
                            <td><?php echo $row['INSERTED_DATE']; ?></td>                      
                              <?php
                                $i++;
                                echo "</tr>"; 
                                } 
                                ?>
                                 </tbody>
                               </table>
                              <?php } else {
                                ?>
                                </tbody>
                               </table>
                                <?php
                              }
                              ?>
                         
                      </div><!-- /.tab-content -->       
                    </div><!-- nav-tabs-custom -->       
                  </div><!-- /.col --> 
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
  <script type="text/javascript">
   $(document).ready(function(){
      $('#bd_categoryDetail').DataTable({
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