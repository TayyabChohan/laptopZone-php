<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Items
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lot Items</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <div class="row">
        <div class="box"><br>  
               
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
            <div class="col-sm-12">
              <div class="form-group pull-right">
                <a href="<?php echo base_url(); ?>catalogueToCash/c_receiving" title="Back to Receiving Screen" class="btn btn-primary btn-sm" >Back to Receiving</a>                
              </div>
            </div>    
            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                        <th style ="text-align:center;">Action</th>
                        <th style =" text-align:center; ">Manifest No</th>
                        <th style =" text-align:center; ">Tracking No</th>
                        <th style =" text-align:center; ">Title</th>
                        <th style =" text-align:center; ">Cost</th>
                        
                         
                      </thead>
                      <tbody>
                      <tr>
                        <?php foreach($data['query'] as $row) :?>
                      <td>
                        <a style=" margin-right: 3px;" href="<?php echo base_url(); ?>catalogueToCash/c_receiving/lotItems_print/<?php echo @$row['LZ_MANIFEST_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                          <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                         </a>
                      </td>
                    
                      
                      <td style = ""><?php echo $row['LZ_MANIFEST_ID'];?></td>
                      <td style = ""><?php echo $row['TRACKING_NO'];?></td>
                      <td style = ""><?php echo $row['TITLE'];?></td>
                      <td style = ""><div class="pull-right" ><?php echo $row['COST_PRICE'];?></div></td>
                      
                     
                      </tr>
                        <?php endforeach; ?>
                        
                        
                      </tbody> 
                     
                    </table>
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
     $('#purchasing-table').DataTable({
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