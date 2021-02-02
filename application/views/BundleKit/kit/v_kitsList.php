<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Kit List
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kit</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="box"><br>  
          <div class="col-sm-12">
             <div class="col-sm-2">
              <div class="form-group pull-left">      
                <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bk_kit/addKitForm') ?>'" class="btn btn-success ">Add Kit</button> 
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
                    <table id="kitListTable" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                          <th>ACTIONS</th>
                          <th>SR. NO</th>
                          <th>KIT NAME</th>
                          <th>ITEM NAME</th>
                          <th>ITEM KEYWORD</th>
                          <th>CREATE DATE</th>
                          <th>EDIT BY</th>
                      </thead>
                      <tbody>
                          <?php
                          $i=1;
                          if($kits->num_rows() > 0)
                          {
                           foreach ($kits->result() as $kit) {
                            //echo "<pre>";
                            //print_r($kit);
                            //exit;
                             ?>
                             <tr>
                             <td>
                                <div class="edit_btun" style=" width: 90px; height: auto;">
                                    <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bk_kit/deleteKit/'.$kit->LZ_BK_KIT_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                  </a>
                                  <a href="<?php echo base_url().'BundleKit/c_bk_kit/showKitDetail/'.$kit->LZ_BK_KIT_ID.'/'.$kit->LZ_BK_ITEM_TYPE_ID; ?>" id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="" title="Show Detail">
                                    <i style="font-size: 28px; cursor: pointer; padding: 0;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                                </a>
                                </div> 
                             </td>
                             <td><?php echo $i; ?></td>
                             <td><?php echo $kit->LZ_BK_KIT_DESC; ?></td>
                             <td><?php echo $kit->LZ_BK_ITEM_DESC; ?></td>
                             <td><?php echo $kit->KIT_KEYWORD; ?></td>
                             <td><?php echo $kit->CREATE_DATE; ?></td>                                            
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
                  <?php } ?>
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
     $('#kitListTable').DataTable({
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