<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item Components
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Components</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Create Component</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
            <div class="box-body">
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
              <?php } ?>
              <form action="<?php echo base_url(); ?>BundleKit/c_bkComponents/addComponent" method="post" accept-charset="utf-8">
                <div class="col-sm-6" style="margin-left: 15px;">
                  <label for="component_name">Create Component</label>
                    <div class="form-group">
                        <input class="form-control" type="text" name="component_name" id="component_name" placeholder="Enter Component Name" required>
                    </div>                                     
                </div> 
                <div class="col-sm-2" style="margin-top: 23px;">
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="submit_item" value="Save">
                  </div>
                </div> 
                <div class="col-sm-2" style="margin-top: 23px;">
                  <div class="form-group">
                      <a href="<?php echo base_url().'BundleKit/c_bkTemplate' ?>" class="btn btn-primary" name="create_template">Create Template</a>
                  </div>
                </div>                                
              </form>
            </div>
        </div>
        <div class="box">      
          <div class="box-body form-scroll">      
            <div class="col-md-12">
              <!-- Custom Tabs -->
              <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table id="bk_componentsTable" class="table table-bordered table-striped " >
                    <thead>
                        <th>ACTIONS</th>
                        <th>SR. NO</th>
                        <th>COMPONENT NAME</th>
                    </thead>
                     <tbody>
                      <?php
                      
                      $i=1;
                      if($components->num_rows() > 0)
                      {
                       foreach ($components->result() as $row) {
                         ?>
                         <tr>
                            <td>
                              <div class="edit_btun" style=" width: 90px; height: auto;">
                                <a title="Edit Template" href="<?php echo base_url().'BundleKit/c_bkComponents/showComponent/'.$row->LZ_COMPONENT_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                </a>
                                <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bkComponents/componentDelete/'.$row->LZ_COMPONENT_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                              </div> 
                            </td>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->LZ_COMPONENT_DESC; ?></td>                      
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
      $('#bk_componentsTable').DataTable({
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