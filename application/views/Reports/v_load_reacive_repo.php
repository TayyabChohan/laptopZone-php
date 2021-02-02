<?php $this->load->view('template/header'); 
      
?>
<style>


.details-control {
            text-align:center;
            color:forestgreen;
    cursor: pointer;
}
tr.shown .details-control{
    text-align:center; 
    color:red;
}



</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reacive Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reacive Report</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
       <!-- Title filtering section start -->

       <!-- Title filtering section End -->


        <!-- Add Title Expression Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View Data</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
            
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="offer_rep_table" class="table  table-responsive table-striped table-bordered table-hover">
                  <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="5" class="text text-center" style="background: #F48FB1;text-decoration: underline; color: black;">PRICE US-$</th>
                    <th colspan="2" class="text text-center" style="background: #CE93D8;text-decoration: underline; color: black;">KIT</th>
                    <th colspan="3" class="text text-center" style="background: #EF9A9A;text-decoration: underline; color: black;">DATES</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    
                  </tr>
                   <tr>
                      <th>EBAY ID</th>
                      <th style="width:250px;">TITLE</th>
                      <th>LIST TYPE</th>
                      <th style="background: #F48FB1; color: black;">LIST</th>
                      <th style="background: #F48FB1; color: black;">COST PRICE</th>
                      <th style="background: #F48FB1; color: black;">AVG</th>
                      <th style="background: #F48FB1; color: black;">OFFER</th>
                      
                      <th style="background: #F48FB1; color: black;">P/L</th>
                      <th style="background: #CE93D8; color: black;">AVG</th>
                      <th style="background: #CE93D8; color: black;">P/L</th>
                      <th style="background: #EF9A9A; color: black;">LIST</th>
                      <th style="background: #EF9A9A; color: black;">END</th>
                      <th style="background: #EF9A9A; color: black;">OFFER</th>
                      <th>RESULT</th>
                      <th>CATEGORY</th>                      
                      <th>OFFER BY</th>
                      <th>REACIVE DATE</th>
                      <th>TRACKING NO</th>                    
                                          
                    </tr>
                  </thead>
                </table>              
                    <!-- nav-tabs-custom -->
                  </div>
                   <input type="hidden" name="countData" id="countData" value="<?php //echo $i-1; ?>">
                <!-- /.col --> 

                </div>
              <!-- /.box-body -->
              <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
                <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
            </div>
            </div>
        <!-- /.col -->
      </section>

      <!-- /.row -->
  <!-- Trigger the modal with a button -->
  <!-- Modal --> 
    <!-- /.content -->
  </div>  


  <div id="view-modal" class="modal  fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 50%;height:100px !important;">
      <!-- Modal content-->
      <div class="modal-content" style="width: 100%; ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit</h4>
        </div>
        <div class="modal-body" >
          <section class="content" id="appCat"> 

          </section>                  
        </div>
        <div class="modal-footer">
          <!--   <button type="button" id="updateSpec" class="btn btn-outline pull-right" data-dismiss="modal">Update</button> --> 
            <button type="button" id="closeSuccess" class="btn btn-sucess pull-left" data-dismiss="modal">Close</button>         

        </div>
              
      </div>
    </div>

  </div>
    <!-- /.row -->
  <!-- Trigger the modal with a button -->
    
<!-- End Listing Form Data -->
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>

    //Date range as a button
    $('#off_date').daterangepicker(
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
            $('#off_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

      //Date range as a button
    $('#end_date').daterangepicker(
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
            $('#end_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );


$(document).ready(function(){
var data_table = $('#offer_rep_table').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
          
    },
       "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],       
       "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "Filter":true,
      "info": true,
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "autoWidth": true,
      "sScrollY": "600px",
      "sScrollX": "100%",
      "sScrollXInner": "150%",
      "bScrollCollapse": true,
      "bPaginate": true, 
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "ajax":{
        url :"<?php echo base_url().'reports/c_offer_report/load_reacvice' ?>", // json datasource
        type: "post"  
      },

        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        
        // "createdRow": function( row, data, dataIndex){
        //     if(data){
        //         $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
        //         var row_val = $(row).find(".fetch-data").text().replace(/\$/g, '').replace(/\ /g, '').replace(/\-/g, '');
        //         //console.log(row_val); return false;
        //         if (row_val == 1) {
        //           $(row).find(".fetch-data").text('0');
        //         }else {
        //           return false;
        //         }
        //         }
        //       }

      });

   new $.fn.dataTable.FixedHeader(data_table);

});
//
//$('#offer_rep_table tbody').on('click', 'td.details-control', function () {
    $(document).on('click','.details-control',function(){
      var table = $('#offer_rep_table').DataTable();
        var tr = $(this).closest('tr');
        var tdi = tr.find("i.fa");
        
        //var  data_table = $('#offer_rep_table');
        var row = table.row(tr);
        var det_id = $(this).attr('det_id');
        console.log(det_id);
        //tr.addClass("shown");


         if (row.child.isShown()) {
                 // This row is already open - close it
                 row.child.hide();
                 tr.removeClass('shown');
                 tdi.first().removeClass('fa-minus-square');
                 tdi.first().addClass('fa-plus-square');
             } else {
                 // Open this row
                 row.child(format(row.table())).show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
             }
         
         
         //return false;
  //det_id = parseInt(det_id);
  //$('#view-modal').modal('show');
  //$("#appCat").html("");

      });

    function format(d){
      // <thead>
     //        <tr>
     //            <th></th>
     //            <th>Name</th>
     //            <th>Position</th>
     //            <th>Office</th>
     //            <th>Salary</th>
     //            <th>start</th>
     //        </tr>
     //    </thead>
        
         // `d` is the original data object for the row
         return '<table cellpadding="1" cellspacing="4" border="0" style="padding-left:50px;">' +
             '<tr>' +
                 '<th>Full name1:</th>' + '<th>Full name2:</th>' + '<th>Full name3:</th>' +'<th>Full name3:</th>' +'<th>Full name3:</th>' +
                 
             '</tr>' +
             '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' + '<tr>' +
                 '<td>' + 1 + '</td>' +
                 '<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +'<td>' + d.extn + '</td>' +
             '</tr>' +
         '</table>';  
    }


 
//det_id 
</script>
