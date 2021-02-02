<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Merchant Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Merchant</li>
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
              <h3 class="box-title">Add Merchant</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'merchant/c_merchant/save_merchant'; ?>" method="post" accept-charset="utf-8">   
            

                <div class="col-sm-3">
                        <label for="murch_name">Merchant Name</label>
                        <div class="form-group">
                        <input type="text" name="murch_name" id="murch_name" class="form-control"  placeholder="Enter Merchant Name" required>
                      </div>
                </div>
                <div class="col-sm-3">
                        <label for="buis_name">Buisness Name</label>
                        <div class="form-group">
                        <input type="text" name="buis_name" id="buis_name" class="form-control"  placeholder="Enter Buisness Name" required>
                      </div>
                </div>
                <div class="col-sm-3">
                        <label for="merch_add">Merchant Address</label>
                        <div class="form-group">
                        <input type="text" name="merch_add" id="merch_add" class="form-control"  placeholder="Enter Merchant Address" required>
                      </div>
                </div>
                <div class="col-sm-3">
                        <label for="merch_phon">Merchant Phone</label>
                        <div class="form-group">
                        <input type="number" name="merch_phon" id="merch_phon" class="form-control"  placeholder="Enter Merchant Phone" required>
                      </div>
                </div> 
                <div class="col-sm-2">
                        <label for="merch_act_from">Active From</label>
                        <div class='input-group' >
                        
                          <input type='text' class="form-control" name="merch_act_from"  plcaeholder ="Select Active From Date" id="merch_act_from" value="<?php //echo $def_dek_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                       
                </div> 
                <div class="col-sm-2">
                        <label for="merch_act_to">Active To</label>
                        <div class='input-group' >
                        
                          <input type='text' class="form-control" name="merch_act_to"  plcaeholder ="Select Active To Date" id="merch_act_to" value="<?php //echo $def_dek_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                       
                </div>

              <div class="col-sm-2">
                <div class="form-group" >
                   <label for="Search Webhook">Service Type</label>
              
              <?php
              $arrstate = array ('1' => 'Listing','2' => 'Picture','3' => 'warehouse'); ?>
              <select class="form-control selectpicker " name="merch_servic_id" id="merch_servic_id" data-live-search="true" required>
              <option value="">Select Service Type</option>
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

              <div class="col-sm-3">
                <div class="form-group" >
                   <label for="Search Webhook">City</label>
              
              <select class="form-control selectpicker " name="stat_id" id="stat_id" data-live-search="true" required>
              <option value="">Select State Id</option>
              <?php
              foreach($get_stat['stat_query'] as  $stat_id) {
              ?>
              <option value="<?php echo $stat_id['CITY_ID']; ?>"  <?php //if($this->session->userdata('title_sort') == $key){echo "selected";}?>><?php echo $stat_id['CITY_DESC']; ?></option>
              <?php
              }
              ?>
              </select>           

                </div>
              </div>
              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="save_merchant" class="control-label"></label>                  
                       <input type="submit" title="Save Merchant" id="save" name = "save" class="btn btn-primary form-control" value ="Save">     
                     
                    </div>
              </div>



                                                       
                                    
          
            </form>                                              
             
          </div>
         </div>




         <!-- load report start -->
         <div class ="row">
      <div class ="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>

            </div>

            <div class="box-body form-scroll">
              <div class="col-sm-12">

                <table id="merch_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                          <th>Action</th>
                          <th>Merch Name</th>
                          <th>Merch Code</th>
                          <th>Merch Buiss</th>
                          <th>Service Type</th>
                          <th>City</th>
                          <th>State</th>
                          <th>Contact #</th>
                          <th>Address</th>
                          <th>Active From</th>
                          <th>Active To</th>                     
                      
                    </tr>
                  </thead>
                  <tbody>
                        <?php //echo "<pre>" ;
                        //print_r($get_stat['get_merchants']);?>
                      <tr>
                        <?php foreach($get_stat['get_merchants'] as $merch) :?>
                     
                      
                      <td>
                        <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>merchant/c_merchant/del_merchant/<?php echo $merch['MERCHANT_ID']; ?>" title="delete merchantr" class="btn btn-danger btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>merchant/c_merchant/update_merchant_view/<?php echo $merch['MERCHANT_ID']; ?>" title="edit merchant" class="btn btn-primary btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                              </a>                              
                            </div>                                
                      </td>
                      <td><?php echo @$merch['CONTACT_PERSON'];?></td>
                      <td><?php echo @$merch['MERCHANT_CODE'];?></td>                      
                      <td><?php echo @$merch['BUISNESS_NAME'];?></td>
                      <td><?php echo @$merch['SERVICE_TYPE'];?></td>
                      <td><?php echo @$merch['CITY_DESC'];?></td>
                      <td><?php echo @$merch['STATE_DESC'];?></td>
                      <td><?php echo @$merch['CONTACT_NO'];?></td>
                      <td><?php echo @$merch['ADDRESS'];?></td>
                      <td><?php echo @$merch['ACTIVE_FROM'];?></td>
                      <td><?php echo @$merch['ACTIVE_TO'];?></td>
                      
                     
                      </tr>
                        <?php endforeach; ?>
                       
                        
                        
                      </tbody>
                </table>              
                            
              </div>
              
            </div>
        </div>
        
      </div>
      
    </div>



        </div>
      </div>


    </section>
 
    <!-- /.content -->
  </div>  


 <?php $this->load->view('template/footer'); ?>

 
  <script>

$(document).ready(function()
  {
     $('#merch_table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
     //"order": [[ 0, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});

 	$('#merch_act_from').datepicker();
 	$('#merch_act_to').datepicker();
 	
 	  // $('#merch_act_from').datepicker()(
    //     {
    //         ranges: {
    //           'Today': [moment(), moment()],
    //           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //         //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
    //            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //            'This Month': [moment().startOf('month'), moment().endOf('month')],
    //            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //          },

    //         // startDate: moment().subtract(29, 'days'),
    //         // endDate: moment()
    //       },
    //       // function (start, end) {
    //       //   $('#merch_act_from').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    //       // }
    //   );

 </script>