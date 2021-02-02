<?php $this->load->view("template/header.php"); ?>
<style>
  #ListValues{display: none;}

</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Check List
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Check List</li>
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
              <h3 class="box-title">Check List</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body">

          <?php echo form_open('checklist/c_checklist/update_checklist', 'id="checklist_form"', 'role="form"'); ?>

              <div class="row">
                <div class="col-sm-12">
                  
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="Checklist Name" class=" control-label">Checklist Name:</label>
                      
                        <input type="text" class="form-control" id="check_list_name" name="checklist_name" placeholder="Enter Checklist Name" value="<?php if(!empty(@$data['selected_data'][0]['CHECKLIST_NAME'])){echo @$data['selected_data'][0]['CHECKLIST_NAME'];} ?>" required readonly>
                        <input type="hidden" name="checklist_mt_id" value="<?php if(!empty(@$data['selected_data'][0]['CHECKLIST_MT_ID'])){echo @$data['selected_data'][0]['CHECKLIST_MT_ID'];} ?>" required>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group p-t-24">
                      <a style="text-decoration: underline;font-weight: 600;" title="Go to Category & Check List Binding" href="<?php echo base_url('checklist/c_checklist/screen3') ?>">Category Checklist</a>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group p-t-24">
                      <a  title="View Checklist" class="btn btn-primary" href="<?php echo base_url('checklist/c_checklist/view_checklist') ?>" target="_blank">View Checklist</a>
                    </div>
                  </div>                     
                  <div class="col-sm-6">
                    <div class="form-group pull-left">
                      <label for="">Select Check Name's:</label><br>
                    </div>
                  </div>

                  <!-- col-sm-12 start -->
                  <div class="col-sm-12">
                  <table id="checknameList" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Check Name Options</th>
                      <th>Check Name Options</th>
                      <th>Check Name Options</th>
                      <th>Check Name Options</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                   <tr>               
              <?php if(!empty($data['all_data'])):
              $i = 1; 
                      foreach(@$data['all_data'] as $key):
              ?>
                  
                  <td>
                        
                        <input style="margin-right: 8px;" class="pull-left" type="checkbox" name="check_list[]" value="<?php echo $key['LZ_TEST_MT_ID'];?>" <?php foreach (@$data['selected_data'] as $selected_data) {
                          if($selected_data['LZ_TEST_MT_ID'] == $key['LZ_TEST_MT_ID']){echo " checked";}                          
                        } ?>>
                        <input type="hidden" style="width: 150px!important;" class="form-control pull-left" name="test_name" id="test_name" value="<?php echo $key['CHECK_NAME']; ?>" readonly>
                        <?php echo $key['CHECK_NAME']; ?>
                        <a id="<?php echo $key['LZ_TEST_MT_ID']; ?>" class="show_detail" title="Show Detail">
                          <i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                        </a>
                    </td>
                    <?php 

                    if($i%4==0){
                      echo "</tr><tr>";
                    }?>
                   
                    
              <?php $i++; endforeach; endif; 

              ?>
              </tr> 
                  </tbody>
                  </table> 
                  </div>
                  <!-- col-sm-12 end -->  
                                                
               
                <div style="margin-top: 10px;" class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <input type="submit" name="update_checklist" title="Update Checklist" class="btn btn-success" value="Update">
                    <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('checklist/c_checklist/add') ?>'" class="btn btn-primary">Back</button>
                  </div>
                </div>
          </form>
          <?php echo form_close(); ?>
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

<script>

function addRow (argument) {
    var myTable = document.getElementById("ListTable");
    var currentIndex = myTable.rows.length;
    var currentRow = myTable.insertRow(-1);

    var list = document.createElement("input");
    list.setAttribute("type", "text");
    list.setAttribute("name", "list" + currentIndex);
    //list.setAttribute("id", "list" + currentIndex);
    list.setAttribute("value", "");
    list.setAttribute("class", "form-control");
    list.setAttribute("placeholder", "Enter list value");

    // var keywordsBox = document.createElement("input");
    // keywordsBox.setAttribute("name", "keywords" + currentIndex);

    var defaultRadio = document.createElement("input");
    defaultRadio.setAttribute("type", "radio" );
    defaultRadio.setAttribute("name", "listRadio");
    // defaultRadio.setAttribute("id", "listRadio");
    //defaultRadio.setAttribute("class", "btn btn-primary");

    var addRowBox = document.createElement("input");
    addRowBox.setAttribute("type", "button");
    defaultRadio.setAttribute("name", "add_row");
    addRowBox.setAttribute("value", "Add Row");
    addRowBox.setAttribute("onclick", "addRow();");
    addRowBox.setAttribute("class", "btn btn-primary");

    var dellRow = document.createElement("input");
    dellRow.setAttribute("type", "button");
    defaultRadio.setAttribute("name", "del_row");
    dellRow.setAttribute("value", "Delete Row");
    dellRow.setAttribute("onclick", "deleteRow(this);");
    dellRow.setAttribute("class", "btn btn-danger");            

    var currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(list);

    // currentCell = currentRow.insertCell(-1);
    // currentCell.appendChild(keywordsBox);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(defaultRadio);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(addRowBox);

    currentCell = currentRow.insertCell(-1);
    currentCell.appendChild(dellRow);            
}
function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("ListTable").deleteRow(i);
}
</script>

<?php $this->load->view("template/footer.php"); ?>