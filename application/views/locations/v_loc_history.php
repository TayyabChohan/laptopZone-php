<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Location History
       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Location History</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Barcode</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">


                <?php if($this->session->flashdata('bar_info')){ ?>
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Info!</strong> <?php echo $this->session->flashdata('bar_info'); ?>
                </div>
                <?php } else if($this->session->flashdata('bar_error')){ ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('bar_error'); ?>
                </div>
                <?php } ?>
                <form action="<?php echo base_url(); ?>locations/c_locations/loc_history_search" method="post" accept-charset="utf-8">
                    <div class="col-sm-8">

                        <div class="form-group">
                            <input class="form-control" type="text" name="ser_barcode" value="<?php echo  $this->session->userdata('ser_barcode');?>"" placeholder="Search Barcode" required>
                        </div>                                     
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input type="submit" title="Search Item" class="btn btn-primary" name="Submit" value="Search">
                        </div>
                    </div>                                 
                </form>
                  
                </div>
              </div>  


        </div>
        <!-- /.col -->
      </div> 

      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Barcode History</h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <table id="loc_table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                        <th >Barcode</th>
                        <th >Item Desc</th>
                        <th >Old Location</th>
                        <th >New Location</th>
                        <th >Transfer Date</th>
                        <th >Transfer By</th>
                        
                         
                      </thead>
                      <tbody>
                      <tr>

                      <?php if (!empty($data['loc_his'])){

                      foreach($data['loc_his'] as $row) :?>

                      <td ><?php echo @$row['BARCODE_NO'];?></td>
                      <td ><?php echo @$row['TITLE'];?></td>
                      <td ><?php echo @$row['OLD_LOCATION'];?></td>
                      <td ><?php echo @$row['NEW_LOCATION'];?></td>
                      <td ><?php echo @$row['TRAN_DA'];?></td>
                      <td ><?php echo @$row['TRANSFER_BY'];?></td>
                     

                       
                      </tr>
                      <?php endforeach; }?>
                        
                        
                        
                        
                      </tbody> 
                     
                    </table>
                 
                
                  
              </div>
          </div>  


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    

 <?php $this->load->view('template/footer'); ?>


<script>
$(document).ready(function()
  {
     $('#loc_table').DataTable({
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


$(".alert-info").fadeTo(4000, 500).slideUp(500, function(){
    $(".alert-info").slideUp(500);
});
$(".alert-danger").fadeTo(4000, 500).slideUp(500, function(){
    $(".alert-danger").slideUp(500);
});
</script>