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
            <form action="<?php //echo base_url().'merchant/c_merchant/save_merchant'; ?>" method="post" accept-charset="utf-8">   
                             
                                                                    
                                    
          
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

                <table id="pic_report_det" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    
                          <th>User Name</th>
                          <th>Folder Name</th>
                          <th>No Of Pic</th>
                          <th>No Of Barcode</th>
                          <th>Picture Date</th>              
                          <th>Time Diffrence</th>              
                      
                    </tr>
                  </thead>
                  <tbody>
                      <tr>
                        <?php foreach($data['get_pic_sumar_det'] as $pic) :?>            
                      
                     
                      <td><?php echo @$pic['USER_NAME'];?></td>
                      <td><?php echo @$pic['FOLDER_NAME'];?></td>
                      <td><?php echo @$pic['NO_OF_PIC'];?></td>                      
                      <td><?php echo @$pic['NO_OF_BAR'];?></td>
                      <td><?php echo @$pic['PICTUR_DATE'];?></td>
                      <td><?php echo @$pic['TIM_DIFF'];?></td>
                      
                     
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
$(document).ready(function()
  {
     $('#pic_report_det').DataTable({
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

  $(function() {
      //Date range as a button
      $('#filt_date').daterangepicker(
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
            $('#filt_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

  });


</script>

 </script>