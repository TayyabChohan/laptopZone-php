<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Object Template Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Object Template Form</li>
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
              <h3 class="box-title">Object Templates</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

             <table id="templateTable" class="table table-bordered table-striped">
                <!-- <h2>Templates</h2><br> -->
                <p>
                  <a href="<?php echo site_url('template/c_temp/object_add') ?>" target = "_blank" title="Add New Template" class="btn btn-primary">Add New</a>
                </p>      
                <thead>
                  <tr>
                    <!-- <th>Template Id</th> -->
                    <th>Action</th>
                    <th>OBJECT_NAME</th>
                    <th>CATEGORY</th>
                    <th>Item Description</th>
                    <th>Shipping Service</th>
                    <th>Weight</th>

                  </tr>
                </thead>
                <tbody>
                <?php
            if ($data == NULL) {
            ?>
            <div class="alert alert-info" role="alert">There is no record found.</div>
            <?php
            } else {
            foreach ($data['query'] as $row) {
            ?>
                  <tr>
                  <!--<td><?php //echo $row->TEMPLATE_ID; ?></td>-->
                  <td>
                  <div class="edit_btun">
                   <a title="Edit Template"  href="<?php echo site_url('template/c_temp/new_object_edit_view/' . $row['OBJECT_ID']); ?>" target ="blank" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></a>
                  <!--  <a title="Delete Template" href="<?php //echo site_url('template/c_temp/delete/' . $row['OBJECT_ID']); ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> -->
                   </div>
                  </td>
                  <td><?php echo $row['OBJECT_NAME']; ?></td>
                  <td><?php echo $row['CATEGORY_ID']; ?></td>
                  <td><?php echo $row['ITEM_DESC']; ?></td>
                  <td><?php echo $row['SHIP_SERV']; ?></td>
                  <td><?php echo $row['WEIGHT']; ?></td>
                        

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