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
        Hold Item &amp; Un-hold Item Logs
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Hold Item &amp; Un-hold Item Logs</li>
      </ol>
    </section>        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
              <!-- Tester datatable Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Hold &amp; Un-hold Item Logs</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
<!--                   <form action="<?php //echo base_url(); ?>tester/c_tester_screen/hold_item_detail" method="post" accept-charset="utf-8">
                      <div class="col-sm-8">
                          <div class="form-group">
                          <label for="">Search Manifest:</label>
                              <input class="form-control" type="text" id="hold_manifest_id" name="hold_manifest_id" value="<?php //echo @$data[0]['LZ_MANIFEST_ID'];?>" placeholder="Enter Manifest ID" >


                          </div>                                     
                      </div>
                      <div class="col-sm-4">
                          <div class="form-group p-t-24">

                            <input type="submit" class="btn btn-primary" id="search_manifest" name="search_manifest" value="Search">

                          </div>
                      </div>
                    </form> -->
<!--                     <div class="col-sm-12">
                      <?php 
                        // if(empty(@$data)){
                        //     echo '<div class="alert alert-warning alert-dismissable">
                        //     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        //     <strong>No Record found against this Manifest.</strong>
                        //   </div>';
                        //   //exit;
                        // }
                      ?>                      
                    </div>  -->
                  <div class="col-md-12">
          
                    <?php if (@$data): ?> 
                    <div class="box-body form-scroll">
                      <table id="holdItemData" class="table table-bordered table-striped">
                          <thead>
                          <tr>

                            <th>BARCODE</th>                      
                            <th>TIME STAMP</th>
                            <th>STATUS</th>
                            <th>USER NAME</th>
                             
                          </tr>
                          </thead>
                          <tbody>
                            <?php foreach(@$data as $row): ?>
                            <tr>

                              <td><?php echo @$row['BARCODE_NO'] ;?></td>
                              <td><?php echo @$row['TIME_STAMP'] ;?></td>
                              <td>
                              <?php 
                              if(@$row['ACTION'] == 1){
                                echo "Hold";
                              }elseif(@$row['ACTION'] == 0){
                                echo "Un-Hold";
                              }
                              
                              ?>
                                
                              </td>                      
                              <td>
                              <?php 
                              
                                foreach($users as $user){
                                    if($user['EMPLOYEE_ID'] == @$row['USER_ID']){
                                      echo $user['USER_NAME'];
                                    } 

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
     function toggle_hold(source)
     {
      checkboxes = document.getElementsByName('selected_item_hold[]');
      for(var i=0, n=checkboxes.length;i<n;i++)
      {
        checkboxes[i].checked = source.checked;
      }
    }
 </script>