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
th, td { white-space: nowrap; }



</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post Recipt Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Post Recipt Report</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
       <!-- Title filtering section start -->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Criteria</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
                <div class="box-body"> 

                  <div class="col-sm-12">

              <div class="col-sm-12">
                  <div class="row">

                <!-- <form action="<?php //echo base_url().'catalogueToCash/c_purchasing/searchByListType/'.$cat_id.'/'.$catalogue_mt_id; ?>" method="post" accept-charset="utf-8"> -->
                <form action="<?php echo base_url().'reports/c_offer_report/crit_post_receipt'; ?>" method="post" accept-charset="utf-8">
           
                <div class="col-sm-3">
                  <div class="form-group" >
                    <label for="Condition">Category Id:</label>
                    <?php //var_dump($this->session->userdata('Search_category'));
                     ///$this->session->unset_userdata('Search_category'); 
                     $pos_cata = $this->session->userdata('pos_cata'); ?> 
                      <select  name="pos_cata[]" id="pos_cata" class="selectpicker form-control" multiple data-actions-box="true" data-live-search="true">
                       <!--  <option value="all">All</option> -->
                        <?php
                        /////$this->session->unset_userdata('unverify_condition'); 
                          foreach(@$dataa['cattegory'] as $type):                    
                            $selected = "";
                            foreach(@$pos_cata as $selectedcat){ 

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

                <div class="col-sm-2">
                <?php ///$this->session->unset_userdata('purch_mpn'); ?>  
                  <div class="form-group">
                    <label for="Search Webhook">Search Barcode:</label>
                      <input type="text" name="pos_barc" class="form-control clear" placeholder="Search Barcode" value="<?php echo htmlentities($this->session->userdata('pos_barc')); ?>" >
                  </div>              
                </div>

                <div class="col-sm-2">
                  <div class="form-group" >
                    <?php //var_dump($this->session->userdata('title_sort'));?>
                    <label for="Search Item">Search Item:</label>
                    <?php ///$this->session->unset_userdata('title_sort'); ?>
                    <?php
                    $arrstate = array ('1' => 'DEKITTED ITEM','2' => 'ASSEMBLED ITEM'); ?>
                    <select class="form-control selectpicker item_drop" name="item_drop" id="item_drop" data-live-search="true">
                    <option value="">BOTH</option>
                    <?php
                    foreach($arrstate as $key => $value) {
                    ?>
                    <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('item_drop') == $key){echo "selected";}?>><?php echo $value; ?></option>
                    <?php
                    }
                    ?>
                    </select>

             

                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group" >
                    <?php //var_dump($this->session->userdata('title_sort'));?>
                    <label for="Lot/Assembled">Lot/Assembled:</label>
                    <?php ///$this->session->unset_userdata('title_sort'); ?>
                    <?php
                    $arrstate = array ('2' => 'LOT ITEM','1' => 'REGULAR ITEM'); ?>
                    <select class="form-control selectpicker lot_drop" name="lot_drop" id="lot_drop" data-live-search="true">
                    <option value="">BOTH</option>
                    <?php
                    foreach($arrstate as $key => $value) {
                    ?>
                    <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('lot_drop') == $key){echo "selected";}?>><?php echo $value; ?></option>
                    <?php
                    }
                    ?>
                    </select>

             

                  </div>
                </div>

                <div class="col-sm-3">
                   <?php ///$this->session->unset_userdata('fed_one'); ?>
                  <div class="form-group">
                    <label for="Feedback Score">Profit Assembled:</label>
                    <div class="input-group" >
                      <?php /////$this->session->unset_userdata('fed_one'); ?>
                      <?php ///$this->session->unset_userdata('fed_two'); ?>
                      <input type="text" name ="fed_one" class="form-control clear" VALUE="<?php echo  $this->session->userdata('fed_one');?>"  />
                      <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>

                      <?php /////$this->session->unset_userdata('fed_two'); ?>
                      <input type="text" name ="fed_two" class="form-control clear" VALUE="<?php echo  $this->session->userdata('fed_two');?>" />
                    </div>
                  </div>
                            
                </div>


                
            </div>               
            
          </div>

          <div class="col-sm-12">
            <div class="row">
              <div class='col-sm-3'>
                  <div class="form-group">
                  <label for="Dekit Date">Dekit Date:</label>
                      <div class='input-group' >
                        
                          <input type='text' class="form-control" name="dek_date"  id="dek_date" value="<?php //echo $def_dek_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <div class="checkbox" style="color:black;font-size: 13px;">
                            <label>
                              <input type="checkbox" value = "1" name="Skip_dek_dat" <?php if(isset($_POST['Skip_dek_dat'])) echo "checked='checked'"; ?>  >
                                <span >Skip Dekit Date</span>
                            </label>
                      </div>
                  </div>
              </div>
              <div class='col-sm-3'>
                  <div class="form-group">
                  <label for="List Date">List Date:</label>
                      <div class='input-group' >

                          <input type='text' class="form-control" name="list_date"  id="list_date" value="<?php //echo $def_end_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <div class="checkbox" style="color:black;font-size: 13px;">
                            <label>
                                <input type="checkbox" value = "2" name="Skip_list_d" <?php if(isset($_POST['Skip_list_d'])) echo "checked='checked'"; ?>  >
                                <span >Skip List Date</span>
                            </label>
                      </div>
                  </div>
              </div>
              <div class='col-sm-3'>
                  <div class="form-group">
                  <label for="Sold Date">Sold Date:</label>
                      <div class='input-group' >

                          <input type='text' class="form-control" name="sold_date"  id="sold_date" value="<?php //echo $def_end_date; ?>" >
                          <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                      </div>
                      <div class="checkbox" style="color:black;font-size: 13px;">
                            <label>
                                <input type="checkbox" value = "3" name="Skip_sold_d" <?php if(isset($_POST['Skip_sold_d'])) echo "checked='checked'"; ?>  >
                                <span >Skip Sold Date</span>
                            </label>
                      </div>
                  </div>
              </div>
              <div class="col-sm-3">
                   <?php ///$this->session->unset_userdata('fed_one'); ?>
                  <div class="form-group">
                    <label for="Profit Dekited">Profit Dekited:</label>
                    <div class="input-group" >
                      
                      <input type="text" name ="p_dek_one" class="form-control clear" VALUE="<?php echo  $this->session->userdata('p_dek_one');?>"  />
                      <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                      
                      <input type="text" name ="p_dek_two" class="form-control clear" VALUE="<?php echo  $this->session->userdata('p_dek_two');?>" />
                    </div>
                  </div>
                            
                </div>

            </div>               
            
          </div>
                

              <div class="col-sm-12">
                  <div class="row">
                      
                    
                      <div class="form-group ">
                      <input type="submit" class="btn btn-primary btn-sm pull-right" name="search_webhook" id="search_webhook" value="Search">
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
              
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
            
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="offer_rep_table" class="table  table-responsive table-striped table-bordered table-hover" width="100%">
                  <thead>

                   <tr>
                    <tr>

                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="5" class="text text-center" style="background: #F48FB1;text-decoration: underline; color: black;">Assembled</th>
                    <th colspan="2" class="text text-center" style="background: #F48FB1;text-decoration: underline; color: black;">Kit P/L</th>
                    <th colspan="8" class="text text-center" style="background: #F48FB1;text-decoration: underline; color: black;">Assemble Item Math US-$</th>
                    <th colspan="3" class="text text-center" style="background: #e6ee9c;text-decoration: underline; color: black;">Dates</th>
                    <th colspan="8" class="text text-center" style="background: #F48FB1;text-decoration: underline; color: black;">Component Math US-$</th>
                    <th></th>
                    
                    
                   </tr>
                      <th >EBAY ID</th>
                      <th >Barcode</th>
                      <th >Title</th>
                      <th style="background: #F48FB1;  color: black;">offer</th>
                      <th style="background: #F48FB1;  color: black;">COST PRICE</th>
                      <th style="background: #F48FB1;  color: black;">AVG</th>
                      <th style="background: #F48FB1;  color: black;">P/L</th>
                      <th style="background: #F48FB1;  color: black;">PL %</th>
                      <!-- KIT AVG -->
                      <th style="background: #CE93D8;  color: black;">AVG</th>
                      <th style="background: #CE93D8;  color: black;">P/L</th>
                      <th style="background: #F48FB1;  color: black;">COST</th>
                      <th style="background: #F48FB1;  color: black;">LIST</th>
                      <th style="background: #F48FB1;  color: black;">SOLD</th>
                      <th style="background: #F48FB1;  color: black;">EBAY</th>
                      <th style="background: #F48FB1;  color: black;">PAYPAL</th>
                      <th style="background: #F48FB1;  color: black;">SHIP</th>
                      <th style="background: #F48FB1;  color: black;">TOTAL EXPENSE</th>
                      <th style="background: #F48FB1;  color: black;">P/L</th>
                      <th style ="">DEKIT DATE</th>
                      <th style ="">LIST DATE</th>
                      <th style ="">SOLD DATE</th>
                      <th style ="">COST</th>
                      <th style ="">LIST</th>
                      <th style ="">SOLD</th>
                      <th style ="">EBAY</th>
                      <th style ="">PAYPAL</th>
                      <th style ="">SHIP</th>
                      <th style ="">PL</th>
                      <th style ="">TOTAL EXPEN</th>
                      
                      <th style ="">DETAILS</th>
                                          
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
    $('#dek_date').daterangepicker(
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
            $('#dek_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );

      //Date range as a button
    $('#list_date').daterangepicker(
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
            $('#list_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );
      //Date range as a button
    $('#sold_date').daterangepicker(
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
            $('#sold_date').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
          }
      );


$(document).ready(function(){
var data_table = $('#offer_rep_table').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
          
    },
      "iDisplayLength": 25,
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
      "sScrollY": "600px",
      "sScrollX": true,
      "fixedHeader": true,
      "bScrollCollapse": true,
      "bPaginate": true,
      "fixedColumns": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "ajax":{
        url :"<?php echo base_url().'reports/c_offer_report/load_post_receipt' ?>", // json datasource
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

});
//
//$('#offer_rep_table tbody').on('click', 'td.details-control', function () {
    $(document).on('click','.details-control',function(){
      var table = $('#offer_rep_table').DataTable();
        var tr = $(this).closest('tr');
        var tdi = tr.find("i.fa");
        
        //var  data_table = $('#offer_rep_table');
        var row = table.row(tr);
        
        //tr.addClass("shown");


         if (row.child.isShown()) {
                 row.child.hide();
                 tr.removeClass('shown');
                 tdi.first().removeClass('fa-minus-square');
                 tdi.first().addClass('fa-plus-square');
             } else {
          var det_id = $(this).attr('det_id');
             
                 format(row.child,det_id);
                 //row.child('hello').show();
                 tr.addClass('shown');
                 tdi.first().removeClass('fa-plus-square');
                 tdi.first().addClass('fa-minus-square');
          //   }
          // });
      }
         
    });
 // =================

      function format(callback,det_id) {
        $.ajax({
           url: '<?php echo base_url();?>reports/c_offer_report/dekt_barcode_details', 
          type: 'POST',
        
        dataType: "json",
         data: {'det_id':det_id},
        complete: function (response) {
            var data = JSON.parse(response.responseText);
            console.log(data);
                var thead = '',  tbody = '';
                for (var key in data[0]) {
                    thead += '<th>' + key + '</th>';
                }
                $.each(data, function (i, d) {
                    tbody += '<tr><td>' + d.EBAY_ID + '</td><td>' + d.BARCODE + '</td><td>' + d.MPN + '</td><td>' + d.OBJ_NAME + '</td><td>' + d.COST + '</td><td>' + d.AVERAGE + '</td><td>' + d.LIST + '</td><td>' + d.SOLD_PRICE + '</td><td>' + d.EBAY_FEE + '</td><td>' + d.PAYPAL_FEE + '</td><td>' + d.SHIP_FEE + '</td><td>' + d.PL  + '</td><td>' + d.TOTAL_EXPENS + '</td></tr>';
                });
            //console.log('<table>' + thead + tbody + '</table>');
            callback($('<div  style = "margin-right:10px;" class=" pull-right"><table  style ="background-color:#b3e5fc "class="table table-sm table-bordered">' + thead + tbody + '</table></div>')).show();
        },
        error: function () {
            $('#output').html('Bummer: there was an error!');
        }
    });
    }

    // =================
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
      ); //Date range as a button
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
      ); //Date range as a button
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
   


 
//det_id 
</script>
