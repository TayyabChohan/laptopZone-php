<?php $this->load->view("template/header.php"); ?>
<style>
  #ListValues{display: none;}
  div#ListValues {
    border: 2px solid #ccc !important;
    padding: 8px !important;
}  

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Test Check
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Test Check</li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

          <!-- Test Check Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Test Check</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

          <?php //echo form_open('checklist/c_checklist/test_save', 'role="form"'); ?>

                  <div class="col-sm-12">                  
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="Checklist Attribute" class=" control-label">Testing Check Names:</label>
                        
                          <input type="text" class="form-control" id="test_checklist_name" name="checklist_name" value="" placeholder="Enter Testing Check Name">
                      </div>
                    </div>
                    <div class="col-sm-4" style="margin-top: 26px;">
                      <div class="form-group">
                        <label class="radio-inline"><input type="radio" name="optradio_1" value="Logical" checked>Logical</label>
                        
                        <label class="radio-inline"><input type="radio" name="optradio_1" value="FreeText">FreeText</label>
                        <label class="radio-inline"><input type="radio" name="optradio_1" id="optradio_1" value="List">List</label>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group p-t-24">
                        <a style="text-decoration: underline;font-weight: 600;" title="Go to Check List form" href="<?php echo site_url('checklist/c_checklist/screen2') ?>">Check List</a>
                      </div>
                    </div>                    
                  </div>

                  <div id="ListValues" class="col-sm-6 pull-right">

                    <div class="col-sm-12">
                        <div class="form-group">
                          <label for="List Options">Max Value:</label>
                          <input style="width: 25%!important;" class="form-control" type="number" name="max_val" id="max_val" value="" placeholder="Enter a number value">
                        </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="List Options">List Options</label>
                        <input class="form-control" type="text" name="list_name" id="list_name" value="" placeholder="Enter list value">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group p-t-24">
                        <button type="button" id="add_row" name="add_row" class="add_row btn btn-primary" title="Add Row">Add Row</button>
                      </div>    
                    </div>
                                      
                    <table id="ListTable" class="table table-responsive table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th><input class="text-center" name="record" type="checkbox" onclick="toggle(this)"></th>
                          <th>List Options</th>
                          <th>Default</th>
                          
                        </tr>
                      </thead>
                      <tbody>  

                                           
                      </tbody>  
                    </table>

                    <button type="button" class="del_row btn btn-danger" name="del_row" id="del_row" title="Delete Row">Delete Row</button>
                    
                  </div>

                   <div class="col-sm-12" id="success-msg">
                     
                   </div>
                                                
               
                <div class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <button type="button" name="checklist" id="checklist" title="Save Checklist" class="btn btn-success">Save</button>
                  </div>
                </div>

          <!-- </form> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- Test Check End -->

          <!-- Test Check datatable Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Test Check</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="TestingCheckName" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Action</th>
                    <th>Test Check Name</th>
                    <th>Selection Mode</th>
                    <th>Show Detail</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($data as $row): ?>
                  <tr>
                    <td>
                      <div class="edit_btun">
                        <a title="Edit Test Check Name" href="<?php echo base_url();?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                      </a>
                        <a title="Delete Test Name" href="<?php echo base_url();?>checklist/c_checklist/testing_check_delete/<?php echo @$row['LZ_TEST_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                      </a>
                      </div>                      
                    </td>
                    <td><?php echo @$row['CHECK_NAME'];?></td>
                    <td><?php echo @$row['SELECTION_MODE'];?></td>
                    <td> 
                                            
                      <a id="<?php echo @$row['LZ_TEST_MT_ID']; ?>" class="show_detail" title="Show Detail">
                      
                        <i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach;?>
                </tbody>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- Test Check datatable End -->


          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>  


<?php $this->load->view("template/footer.php"); ?>