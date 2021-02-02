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
          <?php echo form_open('BundleKit/c_bkTemplate/addTemplate', 'id=""', 'role="form"'); ?>

              <div class="row">
                <div class="col-sm-12">
                  
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="Template Name" class=" control-label">Template Name:</label>
                      
                        <input type="text" class="form-control" id="template_name" name="template_name" placeholder="Enter Template Name" value="<?php echo $records[0]['ITEM_TYPE_DESC']; ?>" readonly>
                    </div>
                  </div>
                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkTemplate') ?>'" class="btn btn-primary" style="margin-top: 23px;">Back</button>
                  </div> <!-- col-sm-12 -->
                  </div> <!-- row class -->
                  </div> <!-- box body class -->
                  </div><!-- box class -->
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
                  <table id="templateDetail" class="table table-bordered table-striped " >
                  <thead>
                      <th>Sr. No</th>
                      <th>Component Name</th>
                      <th>Qty</th>
                  </thead>
                  <tbody>                   
                   <tr>               
                    <?php if(count($records) > 0):
                    $i = 1;
                     
                      foreach($records as $key):
                    ?>
                  <td><?php echo $i; ?> </td>
                    <td>
                         <input type="hidden" style="width: 150px!important;" class="form-control pull-left" name="test_name" id="test_name" value="<?php echo $key['LZ_COMPONENT_DESC']; ?>" readonly>
                        <?php echo $key['LZ_COMPONENT_DESC']; ?>
                       
                    </td>
                    <td><input type="text" style="width: 150px!important;" class="form-control pull-left" name="component_qty" id="component_qty" value="<?php echo $key['QUANTITY']; ?>" readonly>            
                    </td>
                    <?php $i++;
                    echo "</tr>";
                     endforeach; 
                      endif; 
                    ?>
                    </tbody>
                  </table> 
                </div>
                <!-- col-sm-12 end -->  
              <?php echo form_close(); ?>                 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          </div>
        <!-- /.col -->
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
     $('#templateDetail').DataTable({
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