<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Listing
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bundle &amp; Kit  Listing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
    
      <div class="row">
        <div class="box"><br>  
           <div class="col-sm-12">
            <div class="col-sm-2">
              <div class="form-group pull-left">
                <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkProfiles/addProfile') ?>'" class="btn btn-success ">Add Profile</button> 
              </div>
            </div>
            <div class="col-sm-2  col-sm-offset-8">
               <div class="form-group pull-right">
                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkProfiles/viewSavedData') ?>'" class="btn btn-success ">View Data</button> 
              </div>
            </div>
        </div>    
          <div class="box-body form-scroll">  
            <?php if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }else if($this->session->flashdata('error')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                </div>
            <?php } ?>    
            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table id="profileTable" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                          <th>ACTIONS</th>
                          <th>SR. NO</th>
                          <th>ITEM NAME</th>
                          <th>TEMPLATE NAME</th>
                          <th>UPC</th>
                          <th>MPN</th>
                          <th>CATEGORY ID</th>
                          <th>CATEGORY NAME</th>
                          <th>CREATE DATE</th>
                          <th>EDIT BY</th>
                      </thead>
                      <tbody>
                        <?php
                        $i=1;
                        if($profiles->num_rows() > 0)
                        {
                         foreach ($profiles->result() as $profile) {
                           ?>
                           <tr>
                           <td>
                              <div class="edit_btun" style=" width: 90px; height: auto;">
                               <!--  <a title="Edit Template" href="<?php //echo base_url().'BundleKit/c_CreateComponent/editTemplateDetail/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span> </a> -->
                                <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bkProfiles/deleteProfile/'.$profile->LZ_BK_ITEM_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                                <a href="<?php echo base_url().'BundleKit/c_bkProfiles/ProfileDetail/'.$profile->LZ_BK_ITEM_ID; ?>" id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="" title="Show Detail">
                                <i style="font-size: 28px; cursor: pointer; padding: 0;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                                </a>
                              </div> 
                           </td>
                           <?php 
                              $item_name=$profile->LZ_BK_ITEM_DESC;
                           $item_name= str_replace("_", '/', $item_name);
                            $item_name = str_replace("'", '', $item_name); ?>
                           <td><?php echo $i; ?></td>
                           <td><?php echo $item_name; ?></td>
                           <td><?php echo $profile->ITEM_TYPE_DESC; ?></td>
                           <td><?php echo $profile->UPC; ?></td>
                           <td><?php echo $profile->MPN; ?></td>
                           <td><?php echo $profile->CATEGORY_ID; ?></td>
                           <td><?php echo $profile->CATEGORY_NAME; ?></td>
                           <td><?php echo $profile->CREATE_DATE; ?></td>                                            
                           <td><?php //echo $profile->CREATE_DATE; ?></td>                                            
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
                      <!-- <div class="col-sm-8">
                         <div class="form-group pull-left">
                           <button type="button" title="Go Back" onclick="location.href='<?php //echo base_url('BundleKit/c_bkProfiles') ?>'" class="btn btn-primary ">Back</button> 
                         </div>
                       </div> --> 
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
     $('#profileTable').DataTable({
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