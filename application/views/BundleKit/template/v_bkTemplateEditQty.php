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
                  <input type="hidden" class="form-control" id="template_id" name="template_id" value="<?php echo $records[0]['LZ_BK_ITEM_TYPE_ID']; ?>">  
                   
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
                  <div class="col-sm-12">
                  <table id="editTemplateQty" class="table table-bordered table-striped ">
                    <thead>
                        <th>Action</th>
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
                    <td>
                    <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bkTemplate/bk_deleteTempComponent/'.$key['LZ_BK_ITEM_TYPE_DET_ID'].'/'.$key['LZ_BK_ITEM_TYPE_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                    </td>
                    <td><?php echo $i; ?></td>
                    <td>
                       <input type="hidden" style="width: 150px!important;" class="form-control pull-left" name="test_name" id="test_name" value="<?php echo $key['LZ_COMPONENT_DESC']; ?>" readonly>
                      <?php echo $key['LZ_COMPONENT_DESC']; ?>
                      <input type="hidden" class="form-control" id="component_id_<?php echo $i; ?>" name="component_id" value="<?php echo $key['LZ_COMPONENT_ID']; ?>">    
                    </td>
                    <td>
                    <input type="text" style="width: 150px!important;" class="form-control pull-left component_qty" name="component_qty" id="component_qty_<?php echo $i; ?>" value="<?php echo $key['QUANTITY']; ?>">
                    <div id="success_msg" style="color: green;"></div>

                    </td>
                      
                      <?php 
                      $i++;
                      echo "</tr>";
                      endforeach;
                      endif; 
                      ?>
                      </tbody>
                    </table> 
                    <input type="hidden" name="" id="qty_count" value="<?php echo $i-1; ?>">
                    </div>
                    <!-- col-sm-12 end -->  
      			          <?php echo form_close();
      			            $t_id=$records[0]['LZ_BK_ITEM_TYPE_ID'];
      			           ?>     
                  </div>        
                  <a title="Edit Template" href="<?php echo base_url().'BundleKit/c_bkTemplate/addMoreComponents/'.$records[0]['LZ_BK_ITEM_TYPE_ID']; ?>" class="btn btn-info">Add Components
                  </a>            
                  <button title="Edit Quantity" id="edit_qty" class="btn btn-success edit_qty">Apply Changes
                  </button>
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

</script>

<?php $this->load->view("template/footer.php"); ?>
<script>
$(document).ready(function()
  {    
/**************************************
*     UPDATE COMPONENT QUANTITIES     *
***************************************/
  $("#edit_qty").click(function(){
    var url='<?php echo base_url() ?>BundleKit/c_bkTemplate/bk_edit_quantity';
    var count = $('#qty_count').val(); 
    var component_qty=[];
    var component_id=[];
    var template_id=$("#template_id").val();
    for (var i = 1; i <= count; i++) {  
       component_qty.push($('#component_qty_'+i).val());
       component_id.push($('#component_id_'+i).val());

    }
        $.ajax({
          dataType: 'json',
          type: 'POST',        
          url:url,
          data: { 
            'component_qty' : component_qty,
            'template_id' : template_id,
            'component_id' : component_id
        },
         success: function (data) {
           if(data != ''){
            //$("#success_msg").text('success').css('color', 'green');
            alert('Data updated');
                     
           }else{
             //$("#success_msg").text('error').css('color', 'red');
             alert('Error: Fail to update data');
           }
         }
        }); 
   });

  /*********************************
  * DATA TABLE FUNCTION
  **********************************/
  $('#editTemplateQty').DataTable({
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