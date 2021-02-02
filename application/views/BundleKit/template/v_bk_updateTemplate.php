<?php $this->load->view("template/header.php"); ?>
<style>
  #ListValues{display: none;}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Template
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Update Template</li>
      </ol>
    </section>
      <!-- Small boxes (Stat box) -->
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Update Template</h3>
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
                      
                        <input type="text" class="form-control" id="template_name" name="template_name" placeholder="Enter Template Name" value="<?php echo $details[0]['ITEM_TYPE_DESC']; ?>" readonly>
                    </div>

                  </div>
                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkTemplate') ?>'" class="btn btn-primary" style="margin-top: 23px;">Go to Templates</button>
                  </div> <!-- col-sm-12 -->
                  </div> <!-- row class -->
                  </div> <!-- box body class -->
                  </div><!-- box class -->
                <?php echo form_open('BundleKit/c_bkTemplate/addMoreComponentsToTemplate/'.$details[0]['LZ_BK_ITEM_TYPE_ID'], 'id=""', 'role="form"'); ?>

                   <div class="box">
                  <div class="box-body">
                  <div class="row">                 
                  <div class="col-sm-6">
                    <div class="form-group pull-left">
                      <label for="">Select Component Name:</label><br>
                    </div>
                  </div>
                  <!-- col-sm-12 start -->
                  <div class="col-sm-12">
                  <table id="AddMoreComponents" class="table table-bordered table-striped ">
                  <thead>
                      <th>Component Names</th>
                      <th>Component Names</th>
                      <th>Component Names</th>
                      <th>Component Names</th>
                  </thead>
                  <tbody>
                    
                   <tr>               
                    <?php if($components->num_rows() > 0):
                    $i = 1; 
                      foreach($components->result_array() as $key):
                        foreach ($details as $value) {
                          //var_dump($value['LZ_COMPONENT_ID']);exit;
                          if($key['LZ_COMPONENT_ID'] === $value['LZ_COMPONENT_ID']){
                            $selected = true;
                            break;
                          }else{
                            $selected = false;
                          }
                        }
                    ?>     
                    <td>
                        <input style="margin-right: 8px;" class="pull-left" type="checkbox" name="check_list[]" value="<?php echo $key['LZ_COMPONENT_ID'];?>" <?php if($selected){echo "checked";} ?> >           
                        <?php echo $key['LZ_COMPONENT_DESC']; ?> 
                    </td>
                    <?php 

                    if($i%4==0){
                      echo "</tr>";
                    }
                    ?>
          
                    <?php $i++; endforeach; endif; 

                    ?>
                  </tbody>
                </table> 
              </div>
             <!-- col-sm-12 end -->  
            </div>
              <input type="submit" name="update_template" title="Save Template" class="btn btn-success" value="Save"> <!-- </div> -->
               <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkTemplate/editTemplateDetail/'.$details[0]['LZ_BK_ITEM_TYPE_ID']) ?>'" class="btn btn-primary" >Back</button>
             <!-- </div> -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
        <?php echo form_close(); ?>
      </div>
      <!-- /.row -->
      </div>
    <!-- /.content -->
    </section>
    <!-- /.content -->
  </div>  

<?php $this->load->view("template/footer.php"); ?>
<script>
$(document).ready(function()
  {
     $('#AddMoreComponents').DataTable({
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