<?php $this->load->view('template/header'); 
      
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
border: 0px solid ;
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
        Offer Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Offer Report</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Criteria</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
                <div class="box-body"> 
            <?php if($this->session->flashdata('success')){ ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }else if($this->session->flashdata('error')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                </div>
            <?php } ?>    
                  <div class="col-sm-12">
                <!-- <form action="<?php //echo base_url().'catalogueToCash/c_purchasing/searchByListType/'.$cat_id.'/'.$catalogue_mt_id; ?>" method="post" accept-charset="utf-8"> -->
                <form action="<?php echo base_url().'reports/c_offer_report/off_report_query'; ?>" method="post" accept-charset="utf-8">
           
                <div class="col-sm-3">
                  <div class="form-group" >
                    <label for="Condition">Category Id:</label>
                    <?php //var_dump($this->session->userdata('Search_category'));
                     ///$this->session->unset_userdata('Search_category'); 
                     $offer_category = $this->session->userdata('offer_category'); ?> 
                      <select  name="offer_category[]" id="offer_category" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php
                        /////$this->session->unset_userdata('unverify_condition'); 
                          foreach(@$dataa['cattegory'] as $type):                    
                            $selected = "";
                            foreach(@$offer_category as $selectedcat){ 

                              if ($selectedcat == $type['CATEGORY_ID']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                             <option value="<?php echo $type['CATEGORY_ID']; ?>"<?php echo $selected; ?>><?php echo $type['CATEGORY_NAME']; ?></option>
                              <?php
                            endforeach;
                         
                           ?>                     
                      </select> 

                  </div>
                </div> 

                <div class='col-sm-2'>
                  <div class="form-group">
                  <label for="Search Webhook">Offer Date:</label>
                      <div class='input-group' >
                          <?php $def_end_date = $this->session->userdata('def_end_date'); ?>
                          <input type='text' class="form-control" name="off_date"  id="off_date" value="<?php echo $def_end_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <div class="checkbox" style="color:black;font-size: 13px;">
                            <label>
                                <input type="checkbox" value = "1" name="Skip_offer" <?php if(isset($_POST['Skip_offer'])) echo "checked='checked'"; ?>  >
                                <span >Skip Offer Date</span>
                                
                            </label>
                      </div>
                  </div>
              </div>

              <div class='col-sm-2'>
                  <div class="form-group">
                  <label for="Search Webhook">End Date:</label>
                      <div class='input-group' >
                        
                          <input type='text' class="form-control" name="end_date"  id="end_date" value="<?php //echo $def_end_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <div class="checkbox" style="color:black;font-size: 13px;">
                            <label>
                                <input type="checkbox" value = "2" name="Skip_end" <?php if(isset($_POST['Skip_end'])) echo "checked='checked'"; ?>  >
                                <span >Skip End Date</span>
                            </label>
                      </div>
                  </div>
              </div>

               
                <div class="col-sm-2">
                <div class="form-group" >
                  <?php //var_dump($this->session->userdata('title_sort'));?>
                  <label for="Search Webhook">Result:</label>
                  <?php ///$this->session->unset_userdata('title_sort'); ?>
                  <?php
                  $arrstate = array ('1' => 'WIN','2' => 'LOST'); ?>
                  <select class="form-control selectpicker resdropdown" name="resdropdown" id="resdropdown" data-live-search="true">
                  <option value="">All ....</option>
                  <?php
                  foreach($arrstate as $key => $value) {
                  ?>
                  <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('resdropdown') == $key){echo "selected";}?>><?php echo $value; ?></option>
                  <?php
                  }
                  ?>
                  </select>

           

                </div>
              </div>

               <div class="col-sm-3">
                  <div class="form-group" >
                    <label for="Condition">Offer By:</label>
                    <?php //var_dump($this->session->userdata('Search_category'));
                     ///$this->session->unset_userdata('Search_category'); 
                     $search_emp_id = $this->session->userdata('emp_id'); ?> 
                      <select  name="emp_id[]" id="emp_id" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php
                        /////$this->session->unset_userdata('unverify_condition'); 
                          foreach(@$dataa['emp_id'] as $type):                    
                            $selected = "";
                            foreach(@$search_emp_id as $selectedcat){ 

                              if ($selectedcat == $type['EMP_ID']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                             <option value="<?php echo $type['EMP_ID']; ?>"<?php echo $selected; ?>><?php echo $type['NAME']; ?></option>
                              <?php
                            endforeach;
                         
                           ?>                     
                      </select> 

                  </div>
                </div> 

                

                <div class="col-sm-12">
                <div class="row">
                  <div class="col-sm-2">
                    <h3>Awaiting Shipment:</h3>
                  </div>
                <div class="col-sm-8 ">
                  
                  <div class="btn-group btn-group-horizontal " data-toggle="buttons">
                   <label class="btn active">                                         

                      <input type="radio" name='await_ship' id='await_ship1' value="1" <?php if($this->session->userdata('radiobutton') == 1) { echo 'checked="checked"';} ?> ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span> YES</span>
                    </label>
                    <label class="btn ">
                      <input type="radio" name='await_ship' id='await_ship1' value="2" <?php if($this->session->userdata('radiobutton') == 2) { echo 'checked="checked"';} ?> ><i class="fa fa-circle-o fa-2x"></i><i class="fa fa-dot-circle-o fa-2x"></i> <span> NO</span>
                    </label>
                  </div>                  
                </div>
                <div class="col-sm-2">
                  <div class="form-group ">
                  <input type="submit" class="btn btn-primary btn-sm pull-right" name="search_webhook" id="search_webhook" value="Search">
                  </div>
               </div>
</div>
                
                
                </div>

                
                                    
          
              </form>                                              
            </div> 
          </div>
         </div>
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
                    <th colspan="4" class="text text-center" style="background: #F48FB1;text-decoration: underline; color: black;">PRICE US-$</th>
                    <th colspan="2" class="text text-center" style="background: #CE93D8;text-decoration: underline; color: black;">KIT</th>
                    <th colspan="3" class="text text-center" style="background: #EF9A9A;text-decoration: underline; color: black;">DATES</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    
                  </tr>
                   <tr>
                      <th>EBAY ID</th>
                      <th style="width:250px;">TITLE</th>
                      <th>LIST TYPE</th>
                      <th style="background: #F48FB1; color: black;">LIST</th>
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
$(document).ready(function(){
var data_table = $('#offer_rep_table').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
     "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
       
       "paging": true,
      "lengthChange": true,
      "searching": true,

      "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      //"dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      ///////////////////////////
      "autoWidth": true,
      "sScrollY": "600px",
      "sScrollX": "100%",
      "sScrollXInner": "150%",
      "bScrollCollapse": true,
      "bPaginate": true, 
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    ///////////////////////////////
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'reports/c_offer_report/load_offer_query' ?>", // json datasource
        type: "post"  
        // method  , by default get
        // data: {},
        
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




  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $('body').on('click', '.save_tracking_no', function(){
    //this.disabled = true;
    var rowId=$(this).attr('id');
    //alert(rowId); return false;

    var ct_tracking_no = $("#ct_tracking_no_"+rowId).val(); 
    var ct_cost_price = $("#ct_cost_price_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var lz_cat_id = $("#lz_cat_id_"+rowId).val(); 
    if (ct_tracking_no.length === 0 || ct_cost_price.length === 0) 
    { 
        alert('Tracking no and cost price are required'); 
        // cancel submit
        return false;
    }  

  //console.log(ct_tracking_no, ct_cost_price, lz_bd_catag_id, lz_cat_id); return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/saveTrackingNo',
    data: {
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
      $(".loader").hide();
         if(data ==true){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("Success: Tracking no. is inserted!");   
               //window.location.reload(); 
         }else if(data == false){
           alert('Error: Fail to insert Tracking No!');
           //window.location.reload();
         }else if(data == "exist"){
            alert("Warning: Tracking No already exist.");   
               //window.location.reload();
         }
       },
       complete: function(data){
        $(".loader").hide();
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
  
  });  




  
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

// on;lick method for model dialoge
  //   $(document).on('click','.url',function(){
        
  //        var det_id = $(this).attr('det_id');
  //        console.log(det_id);
  //        //return false;
  // det_id = parseInt(det_id);
  // $('#view-modal').modal('show');
  // $("#appCat").html("");

  //     });
 

</script>
