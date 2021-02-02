<?php $this->load->view("template/header.php"); ?>
<style>
  #ListValues{display: none;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Template
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Template</li>
      </ol>
    </section>
      <!-- Small boxes (Stat box) --> 
      <!-- Main content -->
    <section class="content">
        <?php echo form_open('BundleKit/c_bkTemplate/addTemplate', 'id="template_form"', 'role="form"'); ?>
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Create Template</h3>
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
                          <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
                      </div>
                  <?php }else if($this->session->flashdata('compo')){  ?>
                      <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                      </div>
                  <?php } ?>
              <div class="row">
                <div class="col-sm-12">                 
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="Template Name" class=" control-label">Template Name:</label>                 
                        <input type="text" class="form-control" id="template_name" name="template_name" placeholder="Enter Template Name" required>
                    </div>
                  </div>
                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkComponents') ?>'" class="btn btn-primary" style="margin-top: 23px;">Back</button>
                </div> <!-- col-sm-12 -->
              </div> <!-- row class -->
            </div> <!-- box body class -->
          </div><!-- box class -->
          <div class="box">
           <div class="box-header with-border">
             <h3 class="box-title">Template Components</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <div class="box-body">
              <div class="row">                 
                <div class="col-sm-6">
                  <div class="form-group pull-left">
                    <label for="">Select Component Name:</label><br>
                  </div>
                </div>
                  <!-- col-sm-12 start -->
                <div class="col-sm-12">
                  <table id="templateComponentTable" class="table table-responsive table-striped table-bordered table-hover">
                    <thead>
                        <th>Component Names</th>
                        <th>Component Names</th>
                        <th>Component Names</th>
                        <th>Component Names</th>
                    </thead>
                    <tbody>        
                     <tr>               
                      <?php if($components ->num_rows() > 0):
                        $i = 1; 
                        foreach($components->result_array() as $key):
                      ?>         
                      <td>
                          <input style="margin-right: 8px;" class="pull-left" type="checkbox" name="component_list[]" value="<?php echo $key['LZ_COMPONENT_ID']; ?>">                     
                         <?php echo $key['LZ_COMPONENT_DESC']; ?>                    
                      </td>
                      <?php 
                      if($i%4==0){
                        echo "</tr>"
                        ;
                      } ?>
            
                      <?php $i++; endforeach; endif; 
                      ?>
                    </tbody>
                  </table> 
                </div><!-- col-sm-12 end -->                          
                  <div style="margin-top: 10px;" class="col-sm-12 buttn_submit">
                    <div class="form-group">
                      <input type="submit" name="submit_template" id="submit_template" title="Save Template" class="btn btn-success" value="Save">                      
                  </div>
                </div>
              </div> <!-- /.row --> 
            </div><!-- /.box-body -->     
          </div><!-- /.box -->   
        </div> <!-- /.col-sm-12 --> 
        <?php echo form_close(); ?>
        <!-- /.content -->
          <div class="row">
            <div class="col-sm-12">
             <div class="box">
                <div class="box-header with-border">
                   <h3 class="box-title">Templates</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div> 
                  </div>
                  <div class="box-body">
                  <div class="row">                 
                  <div class="col-sm-12">
                  <table id="templateList" class="table table-responsive table-striped table-bordered table-hover">
                    <thead>
                      <th>ACTIONS</th>
                      <th>Sr. No</th>
                      <th>Template Name</th>
                    </thead>
                    <tbody>
                      <?php
                      $i=1;
                      if($templates->num_rows() > 0)
                      {
                       foreach ($templates->result() as $row) {
                         ?>
                         <tr>
                         <td>
                            <div class="edit_btun" style=" width: 90px; height: auto;">
                                <a title="Edit Template" href="<?php echo base_url().'BundleKit/c_bkTemplate/editTemplateDetail/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                </a>
                                <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bkTemplate/templateDelete/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </a>
                              <a href="<?php echo base_url().'BundleKit/c_bkTemplate/showTemplateDetail/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="" title="Show Detail">
                                <i style="font-size: 28px; cursor: pointer; padding: 0;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                              </a>
                          </div> 
                       </td>
                       <td><?php echo $i; ?></td>
                       <td><?php echo $row->ITEM_TYPE_DESC; ?></td> 
                      </tr>                    
                         <?php
                         $i++;
                            } 
                          }                   
                          ?>
                    </tbody> 
                  </table> 
                </div><!-- col-sm-12 end -->          
              </div> <!-- /.row -->
            </div><!-- /.box-body -->  
          </div><!-- /.box --> 
        </div> <!-- /.col-sm-12 -->      
      </div> <!-- /.row -->  
    </section><!-- /.content -->
  </div>  
<?php $this->load->view("template/footer.php"); ?>
<script>
$(document).ready(function()
  {
     $('#templateList').DataTable({
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

    $('#templateComponentTable').DataTable({
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

$("#submit_template").click(function(){
  var fields = $("input[name='component_list[]']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }else
    {
      return true;
    } 
});
          
});
  

</script>