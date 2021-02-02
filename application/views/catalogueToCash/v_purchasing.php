<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category Wise Summary
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category Wise Summary</li>
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
            <div class="col-md-12">
              <!-- Custom Tabs -->
              
                    <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                          <th>CATEGORY ID</th>
                          <th>CATEGORY NAME</th>
                          <th style =" text-align:center; ">LISTED</th>
                          <th style =" text-align:center; ">VERIFIED</th>
                          <th style =" text-align:center; ">UN-VERIFIED</th>
                          <th style =" text-align:center; ">LAST RUN DATE</th>
                         
                      </thead>
                      <tbody>
                        <?php foreach($data['qry'] as $row) :?>
                           <tr>
                             <td><?php echo $row['CATEGORY_ID'];?></td>
                             <td>
                                <a href="<?php echo base_url();?>catalogueToCash/c_purchasing/mpnSummary/<?php echo $row['CATEGORY_ID']; ?>" id="category<?php echo $row['CATEGORY_ID']; ?>" target="_blank" > <?php echo $row['CATEGORY_NAME']; ?>
                                </a>
                             </td>
                             <td><div class="pull-right" ><?php echo number_format(@$row['LISTED']);?></div></td>
                             <td><div class="pull-right" ><?php echo number_format(@$row['VERIFIED']); ?></div></td>
                             <td><div class="pull-right" ><?php  echo number_format(@$row['UN_VERIFIED']);?></div></td>
                             <td style =" text-align:center; "><?php  echo $row['LAST_DATE'] ;?></td>
                                                                       
                            </tr> 
                        <?php endforeach; ?>
                        <thead>
                          <th></th>
                          <th></th>
                          <th ></th>
                          <th ></th>
                          <th ></th>
                          
                         
                      </thead>
                      <?php foreach($data['count'] as $row): ?>
                      <tr>
                        <td></td>
                        <td style ="color:red; text-align:center; font-size:17px; font-weight:700; ">TOTAL</td>
                <td style = "color:red; font-size:17px; font-weight:700;"><div class="pull-right" ><?php echo number_format((float)@$row['TOTAL_LISTED']);?></div></td>
                <td style = "color:red; font-size:17px; font-weight:700;"><div class="pull-right" ><?php echo number_format((float)@$row['TOTALVERIFIED']);?></div></td>
                <td style = "color:red; font-size:17px; font-weight:700;"><div class="pull-right" ><?php echo number_format((float)@$row['TOTAL_UN_VERIFIED']);?></div></td>
                        <td ></td>
                      </tr>

                    <?php endforeach ; ?>
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