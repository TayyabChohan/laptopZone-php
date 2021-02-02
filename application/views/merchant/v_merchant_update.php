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
            <?php $merch_id = $this->uri->segment(4);?>

            <form action="<?php echo base_url()?>merchant/c_merchant/update_merchant/<?php echo $merch_id ?> " method="post" accept-charset="utf-8">   
            

                <div class="col-sm-3">
                        <label for="murch_name">Merchant Name</label>
                        <div class="form-group">
                        <input type="text" name="murch_name" id="murch_name" class="form-control" value ="<?php echo $merch_deta['get_merchants'][0]['CONTACT_PERSON']?>" placeholder="Enter Merchant Name" required>
                      </div>
                </div>
                <div class="col-sm-3">
                        <label for="buis_name">Buisness Name</label>
                        <div class="form-group">
                        <input type="text" name="buis_name" id="buis_name" class="form-control" value ="<?php echo $merch_deta['get_merchants'][0]['BUISNESS_NAME']?>" placeholder="Enter Buisness Name" required>
                      </div>
                </div>
                <div class="col-sm-3">
                        <label for="merch_add">Merchant Address</label>
                        <div class="form-group">
                        <input type="text" name="merch_add" id="merch_add" class="form-control"  value ="<?php echo $merch_deta['get_merchants'][0]['ADDRESS']?>" placeholder="Enter Merchant Address" required>
                      </div>
                </div>
                <div class="col-sm-3">
                        <label for="merch_phon">Merchant Phone</label>
                        <div class="form-group">
                        <input type="number" name="merch_phon" id="merch_phon" class="form-control"  value ="<?php echo $merch_deta['get_merchants'][0]['CONTACT_NO']?>" placeholder="Enter Merchant Phone" required>
                      </div>
                </div> 
                <div class="col-sm-2">
                        <label for="merch_act_from">Active From</label>
                        <div class='input-group' >
                        
                          <input type='text' class="form-control" name="merch_act_from" value ="<?php echo $merch_deta['get_merchants'][0]['ACTIVE_FROM']?>"  plcaeholder ="Select Active From Date" id="merch_act_from" value="<?php //echo $def_dek_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                       
                </div> 
                <div class="col-sm-2">
                        <label for="merch_act_to">Active To</label>
                        <div class='input-group' >
                        
                          <input type='text' class="form-control" name="merch_act_to"  value ="<?php echo $merch_deta['get_merchants'][0]['ACTIVE_TO']?>"  plcaeholder ="Select Active To Date" id="merch_act_to" value="<?php //echo $def_dek_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                       
                </div>

              <div class="col-sm-2">
                <div class="form-group" >
                   <label for="Search Webhook">Service Type</label>
              
              <?php 
              $list_id = $merch_deta['get_merchants'][0]['SERVICE_TYPE'];
              // var_dump($list_id);
              // exit;

              $arrstate = array ('1' => 'LISTING','2' => 'PICTURE','3' => 'WAREHOUSE'); ?>
              <select class="form-control selectpicker " name="merch_servic_id" id="merch_servic_id" data-live-search="true" required>
              <option value="">Select Service Type</option>
              <?php
              foreach($arrstate as $key => $value) {
              ?>
              <option value="<?php echo $key; ?>"  <?php if($list_id == $value){echo "selected";}?>><?php echo $value; ?></option>
              <?php
              }
              ?>
              </select>

           

                </div>
              </div>

              <div class="col-sm-3">
                <?php $get_city_id =$merch_deta['get_merchants'][0]['CITY_ID'];
                // var_dump($get_city_id);
                // exit; ?>
                <div class="form-group" >
                   <label for="Search Webhook">City</label>
              
              <select class="form-control selectpicker " name="stat_id" id="stat_id" data-live-search="true" required>
              <option value="">Select State Id</option>
              <?php
              foreach($get_stat['stat_query'] as  $stat_id) {
              ?>
              <option value="<?php echo $stat_id['CITY_ID']; ?>"  <?php if($get_city_id == $stat_id['CITY_ID']){echo "selected";}?>><?php echo $stat_id['CITY_DESC']; ?></option>
              <?php
              }
              ?>
              </select>           

                </div>
              </div>
              <div class="col-sm-2">
                    <div class="form-group">
                      <label for="save_merchant" class="control-label"></label>                  
                       <input type="submit" title="Update Merchant" id="update" name = "update" class="btn btn-success form-control" value ="UPDATE">     
                     
                    </div>
              </div>                                                       
                                    
          
            </form>                                              
             
          </div>
         </div>


        </div>
      </div>


    </section>
 
    <!-- /.content -->
  </div>  


 <?php $this->load->view('template/footer'); ?>

 
  <script>



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