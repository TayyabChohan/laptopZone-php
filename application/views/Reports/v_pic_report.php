<?php $this->load->view('template/header'); 
      
?>
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Picture Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Picture Report</li>
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
              <h3 class="box-title">Picture Report</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body">
            <form action="<?php echo base_url().'reports/c_offer_report/pic_report'; ?>" method="post" accept-charset="utf-8">   
                             
                <div class="col-sm-2">
                        <label >Select Date</label>
                        <div class='input-group' >
                        	<div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                        <?php $set_val = $this->session->userdata('filt_data') ;?>
                          <input type="text" class="btn btn-default filt_date" name="filt_date" value = "<?php echo $set_val ;?>" >
                          
                      </div>
                       
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label  class="control-label">Employee Name:</label>
                    <select name="emp_id" class="form-control selectpicker"  data-live-search="true">
                      <option value="">Select Employee  ...</option>
                      <?php                                
                         

                          foreach ($data['get_emp'] as $emp){
                           
                              ?>
                              <option value="<?php echo $emp['EMPLOYEE_ID']; ?>" <?php if($this->session->userdata('get_emp_id') ==  $emp['EMPLOYEE_ID']){echo "selected";}?>><?php echo $emp['USER_NAME']; ?> </option>
                              <?php
                              }                           
                      ?>  
                                          
                    </select>  
                  </div>
                </div>

                 <div class="col-sm-2">
                        <label for="merch_act_from">Select Date</label>
                        <div class='input-group' >
                        
                          <input type='submit' class="form-control btn btn-success" name="submi_dat"  value = "Search" id= "submi_dat" >
                          
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

                <table id="pic_report" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>  <th></th>
                          <th>Employee Name</th>
                          <th>Items Processed</th>
                          <th>No Of Pic</th>
                          <th>No Of Barcode</th>              
                      
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <?php foreach($data['get_res'] as $pic) :?>            
                      
                      <td>
                        <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>reports/c_offer_report/pic_report_detail/<?php echo $pic['PIC_BY']; ?>" title="View Detail" class="btn btn-success btn-sm" target="_blank">View Detail
                              </a>                             
                            </div>                                
                      </td>
                      <td><?php echo @$pic['USER_NAME'];?></td>
                      <td><?php echo @$pic['F_NAME'];?></td>                      
                      <td><?php echo @$pic['NO_PIC'];?></td>
                      <td><?php echo @$pic['NO_OF_BAR'];?></td>
                      
                     
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

 
<script >
	  $(function() {
      //Date range as a button
      $('.filt_date').daterangepicker(
          {

            ranges: {
              'Today': [moment(), moment()],
              'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            //   'Last 3 Days': [moment().subtract(3, 'days'), moment()],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
             },

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          },
          function (start, end) {
            $('.filt_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });
	  
$(document).ready(function()
  {
     $('#pic_report').DataTable({
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

 </script>