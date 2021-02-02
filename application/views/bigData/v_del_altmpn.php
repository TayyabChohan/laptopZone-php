<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Alternate Mpn List
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Alternate Mpn List</li>
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
            <div class="box-header">
              <h3 class="box-title">Alternate MPNs</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

             <table id="templateTable" class="table table-bordered table-striped">
                <!-- <h2>Templates</h2><br> -->
                     
                <thead>
                  <tr>
                    <!-- <th>Template Id</th> -->
                    <th>Action</th>
                    <th>Parent MPN</th>
                    <th>Child MPN</th>
                    

                  </tr>
                </thead>
                <tbody>
                <?php
            if ($get_alt_mpn == NULL) {
            ?>
            <div class="alert alert-info" role="alert">There is no record found.</div>
            <?php
            } else {
            foreach ($get_alt_mpn as $row) {
            ?>
                  <tr>
                  <!--<td><?php //echo $row->TEMPLATE_ID; ?></td>-->
                  <td>
                  <div class="edit_btun">
                 <!--   <a title="Edit Template" href="<?php //echo site_url('template/c_temp/edit/' . $row->MPN_KIT_ALT_MPN); ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></a> -->
            <a title="Delete Template" href="<?php echo base_url();?>bigData/c_recog_title_mpn_kits/del_altMpn/<?php echo $row['MPN_KIT_ALT_MPN'];?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                   </div>
                  </td>
                  <td><?php echo $row['PARENT_MPN']; ?></td>
                  <td><?php echo $row['CHILD_MPN']; ?></td>
                       

                <?php
                }
            }
                ?>
                  </tr>
                </tbody>
             </table>
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

<?php $this->load->view('template/footer');?>