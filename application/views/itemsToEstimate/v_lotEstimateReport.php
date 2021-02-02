<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue

       /*=============================================
        =  Section lz_bigData db connection block  =
        =============================================*/
        $CI = &get_instance();
        //setting the second parameter to TRUE (Boolean) the function will return the database object.
        $this->db2 = $CI->load->database('bigData', TRUE);
        // $qry = $this->db2->query("SELECT * FROM lz_bd_category");
        // print_r($qry->result());exit;

        /*=====  End of Section lz_bigData db connection block  ======*/  
?>
<style>
 .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
 
 label.btn span {
  font-size: 1.5em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: #7AA3CC;
}

label input[type="checkbox"] ~ i.fa.fa-square-o{
    color: #c8c8c8;    display: inline;
}
label input[type="checkbox"] ~ i.fa.fa-check-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="checkbox"] ~ i.fa {
color: #7AA3CC;
}

div[data-toggle="buttons"] label.active{
    color: #7AA3CC;
}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid 
#c8c8c8;
border-radius: 3px;
color: #c8c8c8;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #7AA3CC;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
#contentSec{
  display: none;
}
#objectSection{
  display: none;
} 

</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Items Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Lot Items Report</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
      <!-- LOT Item Estimates Report  --> 
      <div class="box">    
            <div class="box-body form-scroll">
              <div class="col-sm-12">
                <table id="estimateReport" class="table table-bordered table-hover table-responsive table-striped">
                  <thead>
                    <tr>
                      <th>EBAY ID</th>
                      <th>ITEM TITLE</th>
                      <th>ASIGN BY</th>
                      <th>ASIGN DATE</th>
                      <th>ASSIGN TO</th>
                      <th>START DATE</th>
                      <th>ELAPSED TIME</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($estimateReport as $report):
                       foreach($users as $user){
                          if($user['EMPLOYEE_ID'] == $report['CREATED_BY']){ 
                            $assigned_by = ucfirst($user['USER_NAME']);
                          } 

                          if($user['EMPLOYEE_ID'] == $report['ASSIGN_TO']){ 
                            $assigned_to = ucfirst($user['USER_NAME']);
                          }
                        }

                     ?>
                    <tr>
                      <td><?php echo $report['EBAY_ID']; ?></td>
                      <td><?php echo $report['TITLE']; ?></td>
                      <td><?php echo $assigned_by; ?></td>
                      <td><?php echo $report['START_TIME']; ?></td>
                      <td><?php echo $assigned_to; ?></td>
                      <td><?php echo $report['START_TIME']; ?></td>
                      <td><?php echo $report['TIME_ELAPSED']; ?></td>                 
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>  
            </div> 
        <!-- LOT Item Estimates Report end -->
      </section>
  <!-- Trigger the modal with a button -->
  </div>    
 <?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function(){

  var  reportTable =  $('#estimateReport').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
    "iDisplayLength": 25,
    "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    "createdRow": function( row, data, dataIndex){
            if(data){
                $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
                }
              }
  });
                          
});

/*=====  Instant Change status on dropdown change end  ======*/
</script>
