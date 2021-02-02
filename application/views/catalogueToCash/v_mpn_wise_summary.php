<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?><!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"><!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        MPN Wise Summary(Verified Data)
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">MPN Wise Summary</li>
      </ol>
    </section><!-- Main content -->
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
                <div class="col-sm-3">
                  <h4>Category Name : <?php echo $data['category_name'][0]['CATEGORY_NAME']; ?></h4>
                </div>
                <div class="col-sm-3">
                  <h4>Total Count : <?php echo $data['category_name'][0]['CAT_COUNT']; ?></h4>
                </div>
                <div class="col-sm-6">
                  <?php $cat_id = $this->uri->segment(4); ?>
                  <div class="form-group col-sm-3">
                      <a href="<?php echo base_url().'catalogueToCash/c_purchasing/showUnverifiedData/'.$cat_id ?>" class="btn btn-sm btn-primary" name="create_template"  target="_blank" >Unverified Data</a>
                  </div>
                  <div class="form-group col-sm-3">
                      <a href="<?php echo base_url().'catalogueToCash/c_purchasing/showverifiedData/'.$cat_id ?>" class="btn btn-sm btn-success" name="create_template"  target="_blank" >Verified Data</a>
                  </div>
                </div>      
              </div>
            <div class="col-sm-12"><!-- Custom Tabs -->  
              <table id="purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                      <th>MPN</th>
                      <th>LISTED</th>
                      <th>VERIFIED</th>
                      <th>ESTIMATED</th>
                      <th>QUOTED</th>
                      <th>PURHASE</th>
                  </thead>
                  <tbody>
                  <?php foreach($data['mpn'] as $row) :?>
                   <tr>
                     <td>
                       <a href="<?php echo base_url();?>catalogueToCash/c_purchasing/mpn_wise_purchasing/<?php echo $this->uri->segment(4)?>/<?php echo $row['CATALOGUE_MT_ID']; ?>" id="mpn<?php echo $row['CATALOGUE_MT_ID']; ?>" target="_blank"><?php echo $row['MPN'] ;?> 
                       </a>
                     </td>
                     <td><?php echo $row['CAT_COUNT'] ;?></td>
                     <td><?php echo $data['verified'][0]['VERIFY_COUNT'] ?></td>
                     <td><?php  ?></td>
                     <td><?php  ?></td>  
                     <td><?php ?></td>                                         
                    </tr> 
                    <?php endforeach;?>
                  </tbody> 
                </table><!-- nav-tabs-custom -->
              </div><!-- /.col --> 
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </section><!-- /.content -->
  </div><!-- End Listing Form Data -->
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