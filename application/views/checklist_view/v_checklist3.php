   <?php $this->load->view("template/header.php"); ?>
<style>
  #ListValues{display: none;}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category & Check List Binding
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Category & Check List Binding</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">


        <!-- Search Start -->
<!--           <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Checklist</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body">
              <form action="<?php //echo base_url(); ?>tester/c_tester_screen/search_item" method="post" accept-charset="utf-8">
                  <div class="col-sm-4">
                      <div class="form-group">
                      <label for="">Search Checklist:</label>
                          <input type="radio" id="binding" name="binding" value="">&nbsp;&nbsp;Binded
                          <input type="radio" id="binding" name="binding" value="">&nbsp;&nbsp;Un-Binded
                      </div>                                     
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                          <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                      </div>
                  </div>
                </form>   
            </div>
          </div> -->
        <!-- Search Start -->  

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Category Checklist</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <div class="row">
              <div class="col-sm-12">
                <form action="<?php echo base_url(); ?>checklist/c_checklist/search_item_barcode" method="post" accept-charset="utf-8">
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label for="">Search Barcode:</label>
                        <input type="text" class="form-control" name="search_barcode" id="search_barcode" value="<?php echo @$search['item_data'][0]['BARCODE_NO']; ?>">
                        </div>                                     
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group p-t-24">
                            <input type="submit" class="btn btn-primary" name="search_submit" value="Search">
                        </div>
                    </div>
                  </form>

                     <?php if(!empty($search['item_det'])): ?>
                    <div class="col-sm-12">
                      <div class="col-sm-8">
                          <div class="form-group">
                          <label for="">Description:</label>
                              <input type="text" class="form-control" name="item_mt_desc" value="<?php echo @$search['item_det'][0]['ITEM_MT_DESC']; ?>" readonly>
                          </div>
                      </div> 
                      <div class="col-sm-4">
                          <div class="form-group">
                          <label for="">Manufacture:</label>
                              <input type="text" class="form-control" name="manufacturer" value="<?php echo @$search['item_det'][0]['MANUFACTURER']; ?>" readonly>
                          </div>
                      </div> 
                     
                      <div class="col-sm-2">
                        <label for="">MPN:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" id="MPN" name="MPN" value="<?php echo @$search['item_det'][0]['MFG_PART_NO']; ?>" readonly>
                          </div>
                      </div> 
                      <div class="col-sm-2">
                        <label for="">UPC:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" id="item_upc" name="item_upc" value="<?php echo @$search['item_det'][0]['UPC']; ?>" readonly>
                          </div>
                      </div> 
                      <div class="col-sm-2">
                        <label for="">Quantity:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="Quantity" value="<?php echo @$search['item_det'][0]['AVAIL_QTY']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="">Item ID:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="item_id" id="item_id" value="<?php echo @$search['item_det'][0]['ITEM_ID']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="">Manifest ID:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="manifest_id" id="manifest_id" value="<?php echo @$search['item_det'][0]['LZ_MANIFEST_ID']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="">Purchase Ref No:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="purch_ref_no" value="<?php echo @$search['item_det'][0]['PURCH_REF_NO']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="">Category ID:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="purch_ref_no" value="<?php echo @$search['cat_id'][0]['E_BAY_CATA_ID_SEG6']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <label for="">Category Name:</label>
                          <div class="form-group">
                              <input type="text" class="form-control" name="purch_ref_no" value="<?php echo @$search['cat_id'][0]['BRAND_SEG3']; ?>" readonly>
                          </div>
                      </div>
                    </div> <!--Col-sm-12 end-->
                    <div class="col-sm-12">
                      <div class="form-group pull-right">
                        <a class="btn btn-primary" href="<?php echo base_url('specifics/c_item_specifics/specific_barcode');?>/<?php echo @$search['item_data'][0]['BARCODE_NO'];?>" target="_blank">Update Category Name &amp; ID</a>
                      </div>
                    </div>                    
                    <?php endif; ?>

              </div>
            </div>

          <?php echo form_open('checklist/c_checklist/cat_bind_save', 'role="form"'); ?>

              <div class="row">

              <div class="col-sm-12">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="">Checklist Category</label>
                        <select class="form-control" name="category_dd" id="category_dd" required>
                          <option value=""><---Select---></option>
                          <?php 
                          foreach(@$data['cat_qry'] as $category):
                          //$selected = "selected";
                          
                          if(@$category['E_BAY_CATA_ID_SEG6'] == @$search['cat_id'][0]['E_BAY_CATA_ID_SEG6']){
                             echo '<option value="'.@$category['E_BAY_CATA_ID_SEG6'].'" '. 'selected'.'>'.@$category['BRAND_SEG3'].' - '.@$category['E_BAY_CATA_ID_SEG6'].'</option>';
                          }else{
                             echo '<option value="'.@$category['E_BAY_CATA_ID_SEG6'].'">'.@$category['BRAND_SEG3'].' - '.@$category['E_BAY_CATA_ID_SEG6'].'</option>';
                          }   

                          endforeach; 
                          ?>
                        </select>                      
                    </div>                    
                  </div>                
              </div>
                <div class="col-sm-12">

                  <table id="checknameList" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Checklist Name Options</th>
                      <th>Checklist Name Options</th>
                      <th>Checklist Name Options</th>
                      <th>Checklist Name Options</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                   <tr>               
              <?php if(!empty($data)):
              $i = 1; 
                     foreach(@$data['checklist_qry'] as $checklist):
              ?>
                  
                  <td>

                        <input style="margin-right: 8px;" class="pull-left" type="checkbox" name="check_list[]" value="<?php echo @$checklist['CHECKLIST_MT_ID']; ?>">
                        <!-- <input type="hidden" style="width: 150px!important;" class="form-control pull-left" name="test_name" id="test_name" value="<?php //echo @$checklist['CHECKLIST_MT_ID']; ?>" readonly> -->
                        <?php echo @$checklist['CHECKLIST_NAME']; ?>
                        <!-- <a id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="show_detail" title="Show Detail">
                          <i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                        </a> -->
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
                 
              
                <div class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <input type="submit" name="checklist_bind" id="checklist_bind" title="Save Checklist" class="btn btn-success" value="Save">
                    <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('checklist/c_checklist/screen2') ?>'" class="btn btn-primary">Back</button>
                  </div>
                </div>
          <!-- </form> -->
          <?php echo form_close(); ?>
                </div><!-- /.col-sm-12 -->
                </div><!-- /.row -->
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->

<!-- Category Binding datatable Start -->
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Category & CheckList Binding</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                        <form action="<?php echo base_url(); ?>checklist/c_checklist/search_manifest" method="post" accept-charset="utf-8">
                            <div class="col-sm-8">
                                <div class="form-group">
                                <label for="">Search Manifest:</label>
                                    <input class="form-control" type="text" id="test_manifest_id" name="test_manifest_id" value="" placeholder="Enter Manifest ID" >


                                </div>                                     
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group p-t-24">

                                  <input type="submit" class="btn btn-primary" id="search_manifest" name="search_manifest" value="Search">

                                </div>
                            </div>
                          </form> 
                  <div class="col-md-12">
                    
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                      <ul class="nav nav-tabs">
                        <li ><a href="#tab_1" data-toggle="tab">Un-Binded</a></li>
                        <li class="active"><a href="#tab_2" data-toggle="tab">Binded</a></li>
                      </ul>
                      <div class="tab-content">
                        <div class="tab-pane " id="tab_1">
                        <?php //var_dump(@$binded_data);exit;?>
                          <?php if (@$binded_data): ?> 
                          <div class="box-body form-scroll">
                            <table id="unTestedData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>CATEGORY ID</th>                        
                                  <th>CATEGORY NAME</th>
                                  
                                                     

                                   
                                </tr>
                                </thead>
                                <tbody>
                                  <?php foreach(@$binded_data['un_binded_qry'] as $un_binded_qry): ?>
                                  <tr>
                                    <td><?php echo @$un_binded_qry['E_BAY_CATA_ID_SEG6'] ;?></td>
                                    <td><?php echo @$un_binded_qry['BRAND_SEG3'] ;?></td>
                                    
                                    

                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table><br>
                  
                          </div>
           
                        <?php endif; ?>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane active" id="tab_2">
                          <?php if (@$binded_data): ?> 
                          <div class="box-body form-scroll">
                            <table id="TestedData" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                  <th>ACTION</th> 
                                  <th>CATEGORY ID</th>                         
                                  <th>CATEGORY NAME</th>
                                  
                                  <th>CHECKLIST NAME</th>  
                                   
                                </tr>
                                </thead>
                                <tbody>
                                  <?php foreach(@$binded_data['binded_qry'] as $binded_qry): ?>
                                  <tr>
                                    <td>
                                      <div class="edit_btun">
                                        <a title="Edit Test Check Name" href="<?php echo base_url();?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                      </a>
                                        <a title="Delete Test Name" href="<?php echo base_url();?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                      </a>
                                      </div> 
                                    </td>
                                    <td><?php echo @$binded_qry['E_BAY_CATA_ID_SEG6'] ;?></td>
                                    <td><?php echo @$binded_qry['BRAND_SEG3'] ;?></td>
                                    
                                    <td><div style="width: 220px !important;"><?php echo @$binded_qry['CHECKLIST_NAME'] ;?></div></td>
                                    
                                    </tr>
                                  <?php endforeach; ?>
                                </tbody>
                            </table><br>
                  
                          </div>
           
                        <?php endif; ?>
                        </div>
                        <!-- /.tab-pane -->
                      </div>
                      <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                  </div>
                  <!-- /.col -->

                </div>
                <!-- /.box-body -->
              </div>
              <!-- Category Binding datatable End --> 

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>  


<?php $this->load->view("template/footer.php"); ?>