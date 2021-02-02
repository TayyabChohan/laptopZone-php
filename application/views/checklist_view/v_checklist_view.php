<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Checklist View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Checklist View</li>
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
              <h3 class="box-title">Checklist View</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

             <table id="checklistView" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    
                    <th>Action</th>
                    <th>Checklist Name</th>
                  </tr>
                </thead>
                <tbody>
                <?php
            if ($data == NULL) {
            ?>
            <div class="alert alert-info" role="alert">There is no record found.</div>
            <?php
            } else {
            foreach ($data as $row) {
            ?>
                <tr>
                  <td>
                  <div class="edit_btun" style="width: 120px!important;">
                   <!-- <a title="View Item Checklist" href="<?php //echo base_url();?>checklist/c_checklist/edit_checklist/<?php //echo @$row['CHECKLIST_MT_ID'];?>/edit-view" class="btn btn-primary btn-xs" target="_blank"><i style="font-size: 12px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                   </a>   -->                
                   <a title="Edit Item Checklist" style="margin-right: 4px;" href="<?php echo base_url();?>checklist/c_checklist/edit_checklist/<?php echo @$row['CHECKLIST_MT_ID'];?>" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5"  aria-hidden="true"></span></a>
                   <!-- <a title="Delete Checklist" href="<?php //echo base_url();?>checklist/c_checklist/edit_checklist/<?php //echo @$row['CHECKLIST_MT_ID'];?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> -->
                   </div>
                  </td>
                  <td><?php echo @$row['CHECKLIST_NAME'] ?></td>
                </tr>
                <?php
               } // end foreach
            }//end if else
                ?>
                 
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