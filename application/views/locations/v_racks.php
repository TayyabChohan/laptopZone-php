<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Rack
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Rack</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12"> 
<!-- 
  warehouse mt form insertion  start-->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Rack</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'locations/c_locations/add_rack'; ?>" method="post" accept-charset="utf-8"> 
            <div class="col-sm-3">
                    <div class="form-group">
                      <label for="warehouse desc" class="control-label">Warehouse Description:</label>
                      <select name="ware_na" class="form-control selectpicker" required="required" data-live-search="true" required>
                      <option value="">SELECT WAREHOUSE ...</option>
                      <?php
                          foreach ($data['war_house'] as $war){

                              ?>
                              <option value="<?php echo $war['WAREHOUSE_ID']; ?>" <?php //if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $war['WAREHOUSE_DESC']; ?> </option>
                              <?php
                              }                           
                      ?>  
                                          
                    </select>
                        
                    </div>
              </div> 

              <!-- <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Rack No" class="control-label">Rack No:</label>
                        <input type="TEXT" class="form-control" id="rack_no" name="rack_no" placeholder="Enter Rack No"  required>
                    </div>
              </div> -->
               <div class="col-sm-2">
                    <div class="form-group">
                      <label for="width" class="control-label">Rack width:</label>
                        <input type="number" class="form-control" id="rack_width" name="rack_width" placeholder="Enter Rack width"  required>
                    </div>
              </div>
              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="height" class="control-label">Rack height:</label>
                        <input type="number" class="form-control" id="rack_height" name="rack_height" placeholder="Enter Rack height"  required>
                    </div>
              </div>
              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="no_of_rows" class="control-label">No Of Rows:</label>
                        <input type="number" class="form-control" id="no_of_rows" name="no_of_rows" placeholder="Enter No of Rows"  required>
                    </div>
              </div>
             <!--  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="no_of_bins" class="control-label">Bins Per Row:</label>
                        <input type="number" class="form-control" id="no_of_bins" name="no_of_bins" placeholder="Enter No of bins"  required>
                    </div>
              </div> -->

              <div class="col-sm-2">
                  <div class="form-group" >
                      
                      <?php //var_dump($this->session->userdata('title_sort'));?>
                      <label for="Search Webhook">Rack TYPE:</label>
                  <?php $this->session->unset_userdata('title_sort'); ?>
                  <?php
                  $arrstate = array ('1' => 'CAGE','2' => 'RACK'); ?>
                  <select class="form-control selectpicker sortDropdown" name="rack_type" id="rack_type" data-live-search="true" REQUIRED>
                  <option value="">Select Rack Type</option>
                  <?php
                  foreach($arrstate as $key => $value) {
                  ?>
                  <option value="<?php echo $key; ?>"  <?php //if($this->session->userdata('title_sort') == $key){echo "selected";}?>><?php echo $value; ?></option>
                  <?php
                  }
                  ?>
                  </select>               

                  </div>
              </div>
              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="no_of_rack" class="control-label">No Of Racks:</label>
                        <input type="number" class="form-control" id="no_of_rack" name="no_of_rack" placeholder="Enter No RACKS"  required>
                    </div>
              </div>
              

              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="warehouse desc" class="control-label"></label>                       
                      <input type="submit" title="Save Warehouse" id="save_rack" name = "save_rack" class="btn btn-primary form-control" value ="save">
                    </div>
              </div>                                          
                                    
          
            </form>                                              
             
          </div>
         </div>

         <!-- 
  warehouse mt form insertion  end-->
       
        </div>
      </div>

<!--       warehouse mt table data start
 -->
    <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
              <h3 class="box-title">Racks data</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="ware_house_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>STICKER</th>
                      <th>RACK NO</th>
                      <th>WAREHOUSE ID </th>
                      <th>RACK TYPE</th>
                      <th>ROW STICKER</th>
                      <th>NO OF ROWS</th>
                      <!-- <th>BIN STICKER</th> -->
                      
                      <th>WIDTH</th>
                      <th>HEIGHT</th>
                      
                    </tr>
                  </thead>
                  <tbody >
                    <tr>
                      <?php  
                    if(!empty($war_data['rackqry'] )){


                    foreach($war_data['rackqry'] as $row) :?>
     
                     <!--  <td style = " font-size:17px; font-weight:500;"><?php //echo $row['EBAY_ID'];?></td> -->
                     <td>
                      <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>locations/c_locations/print_all_racks/<?php echo $row['RACK_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>                              
                            </div>
                      </td>
                      <td><?php echo @$row['RACK_NO'];?></td>
                      <td><?php echo @$row['WAREHOUSE_DESC'];?></td>          
                      <td><?php echo @$row['RACK_TYPE'];?></td>
                      <td>
                      <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>locations/c_locations/print_all_rows/<?php echo $row['RACK_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>                              
                            </div>
                      </td>          
                      <td><?php echo @$row['NO_OF_ROWS'];?></td>
                      <!-- <td>
                      <div style="float:left;margin-right:8px;">
                              <a href="<?php //echo base_url(); ?>locations/c_locations/print_all_bins/<?php //echo $row['RACK_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>                              
                            </div>
                      </td> -->           
                                
                      <td><?php echo @$row['WIDTH'];?></td>          
                      <td><?php echo @$row['HEIGHT'];?></td>          
                      
                     
                      </tr>
                        <?php endforeach; }?>
                         
                  <!-- APPEND TABLE AJAX -->
                  </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>
     <!--  warehouse mt data end  -->
    </section>
 
    <!-- /.content -->
  </div>  


 <?php $this->load->view('template/footer'); ?>
<script>
  $(document).ready(function()
  {
     $('#ware_house_table').DataTable({
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
