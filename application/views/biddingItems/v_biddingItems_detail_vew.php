<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
?>
<style>
 .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
  #contentSec{
    display: none;
  }
  #objectSection{
    display: none;
  }  
/*div#printMessage {
    font-size: 16px;
    font-weight: bold;
    color: #ffffff;
    background-color: #00a65a;
    padding: 10px;
    border-radius: 5px;
} */
</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bidding &amp; Select for Purchase Items
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bidding &amp; Select for Purchase Items</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 

       <!-- Title filtering section End -->

        <!-- Verified title option start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Find Item and Verify</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-sm-12">

<!--                 <div class="col-sm-3">
                  <div class="form-group" id="appCat">
                    <label for="Condition">Category Id:</label>

                      <select  name="category[]" id="category_id" class="selectpicker form-control" data-live-search="true">
                        <?php
                          //$category_id = $this->session->userdata('category_id');
                          //foreach(@$dataa['cattegory'] as $type):                    
                        ?>
                            <option value="<?php //echo $type['CATEGORY_ID']; ?>" <?php //if($type['CATEGORY_ID'] == $category_id){echo "selected";} ?> ><?php //echo $type['CATEGORY_NAME']; ?></option>
                        <?php
                          //endforeach;
                        ?>                     
                      </select> 

                  </div>
                </div>  -->                
                <div class="col-sm-3">
                  <div class="form-group">
                    <label>eBay ID:</label>
                    <input type="number" class="form-control" name="ebay_id" id="ebay_id" value="">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-sm btn-primary" name="find_item" id="find_item"  value="Search">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group p-t-24" id="findItemMessage">
                    
                  </div>
                </div>

              </div>

              <div class="col-sm-12">
                 <div class="col-sm-2">
                  <div class="form-group" id="get_brands">

                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group" id="appendMpnlist">

                  </div>
                </div>
                 <div class="col-sm-2">
                  <div class="form-group" id="appendMpnUPC">

                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24" id="verifyButton">
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24" id="fetchObjects">
                    
                  </div>
                </div>                
                <div class="col-sm-2">
                  <div class="form-group p-t-24" id="addMpnbutton">
                    
                  </div>
                </div>                

                 
              </div>

              <!-- Objects block start -->
                <div class="col-sm-12" id="objectSection">
                  <div class="col-sm-2">
                    <div class="form-group" id="objDropdown">  
                        
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="inpBrand">

                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group" id="inpKeyword">

                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group p-t-24" id="findMpn">

                    </div>
                  </div>                                     
                  <div class="col-sm-2">
                    <div class="form-group" id="objMpns">

                    </div>
                  </div>

                  <div class="col-sm-12">
                    <div class="form-group p-t-26">
                      <input type="button" id="saveMPN" name="saveMPN" value="Verify" class="btn btn-success">
                    </div>
                  </div>

                </div>                


          <!-- Objects block end -->  

              <!-- add mpn block start -->
                <div class="col-sm-12" id="contentSec">
                  <div class="col-sm-3">
                    <div class="form-group" id="cataObject">
                      <label for="Conditions" class="control-label">OBJECT:</label>
                      <input class="form-control" type="text" name="mpn_object" id="mpn_object" value="" required>  
                        
                    </div>
                  </div>

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="MPN BRAND">BRAND:</label>
                      <input class="form-control" type="text" name="mpn_brand" id="mpn_brand" value="" required>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="MPN">MPN:</label>
                      <input class="form-control" type="text" name="mpn_input" id="mpn_input" value="" required>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="UPC">UPC:</label>
                      <input type="text" class="form-control" name="lot_upc" id="lot_upc" value="">
                    </div>
                  </div>                  


                  <div class="col-sm-12">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <span>
                          <label for="MPN">MPN DESCRIPTION : </label>Maximum of 80 characters - 
                          <span id="charNum" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left
                        </span><br/>
                          <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onkeyup="countChar(this)" >
                      </div>
                    </div>
                    <div class="col-sm-2">               
                      <div class="form-group p-t-26">
                        <input type="button" id="save_mpn" name="save_mpn" value="Save" class="btn btn-success">
                      </div>
                    </div>  
                  </div>

                </div>                


          <!-- add mpn block end -->  

              <div class="col-sm-12">
                <div id="resultTable">
                  
                </div>
              </div>
            </div>
          </div>   

<!-- Verified title option end -->


          <!-- summary Block start -->   
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Bidding and Purchase Item Summary</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <!-- <p class="summarycardcss" id="total_record"><?php //echo @$bidding_counts[0]['TOTAL_BIDS']; ?></p> -->
                    <p class="summarycardcss" style="font-size: 16px!important;">Total Biddings &nbsp;(<?php echo @$bidding_counts[0]['TOTAL_BIDS']; ?>)</p>
                    <p class="summarycardcss" id="total_record" style="font-size: 16px!important;">Active Biddings &nbsp;(<?php echo @$bidding_counts[0]['TOTAL_OFFER_COUNT']; ?>)</p>
                    <!-- <p>ACTIVE BIDDINGS</p> -->                    
                  </div>
                  <div class="icon">
                    <i class="fa fa-gavel fa-bidding fa-1x"  aria-hidden="true"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

              <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-teal-gradient">
                  <div class="inner">
                     <p class="summarycardcss" id="total_record" style="font-size: 16px!important;">Total Offers &nbsp;
                    <?php 
                      echo '$ '.number_format((float)@$bidding_counts[0]['TOTAL_OFFER'],2,'.',','); 
                    ?>
                      </p>
                    <!-- <p>TOTAL OFFERS</p> -->

                     <p class="summarycardcss" id="total_record" style="font-size: 16px!important;">Active Offers &nbsp; 
                    <?php 
                      echo '$ '.number_format((float)@$bidding_counts[0]['TOTAL_PEND_OFFER'],2,'.',','); 
                    ?>
                      </p>
                    <!-- <p>ACTIVE OFFERS</p> -->                    
                  </div>
                  <div class="icon">
                    <i class="fa fa-usd fa-1x"  aria-hidden="true"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>

            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <p class="summarycardcss" id="total_verified"><?php echo @$bidding_counts[0]['WON']; ?></p>

                  <p>Total WON </p>
                </div>
                <div class="icon">
                  <i class="fa fa-check-circle-o fa-1x" aria-hidden="true"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">

                  <p class="summarycardcss" id="total_unverified"><?php echo @$bidding_counts[0]['LOST']; ?></p>

                  <p>Total LOST </p>
                </div>
                <div class="icon">
                  <i class="fa fa-ban fa-1x" aria-hidden="true"></i>
                </div>
                <div class="text text-center">
                  <button type="button" class="btn btn-warning btn-xs" id="unverified-info" align="center">More info <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <p class="summarycardcss" id="total_exp_record">
                    <?php 
                      echo '$ '.number_format((float)@$bidding_counts[0]['TOTAL_PURCHASE'],2,'.',','); 
                    ?>
                  </p>

                  <p>Total Sold Amount </p>
                </div>
                <div class="icon">
                  <i class="fa fa-usd" aria-hidden="true"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            </div><!-- div box-body end -->
          </div>
          <!-- summary Block end --> 

        <!-- Add Title Expression Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Items Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <!-- Print Message -->
              <div class="col-sm-12">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                  <div class="form-group text-center emptyDiv">
                    <div id="printMessage">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                </div>                
              </div>
              <!-- End Print Message -->
              <div class="box-body form-scroll"> 
              <div class="col-md-12"><!-- Custom Tabs -->
                <table id="biddingTable" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>ACTION</th>
                      <th>EBAY ID</th>
                      <th>TITLE</th>
                      <th>MPN</th>
                      <th>SELLER ID</th>
                      <th>CATEGORY ID</th>
                      <th>LISTING TYPE</th>
                      <th>REMAINING TIME</th>
                      <th>CONDITION</th>                    
                      <th>STATUS</th>
                      <th>BID STATUS</th>
                      <th><div style="width:170px;">BID/OFFER</div></th>
                      <th>SOLD AMOUNT</th>
                      <th>KIT VIEW</th>
                      <th style="width:200px;">TRACKING</th>
                      <th>COST PRICE</th>
                      </tr>
                  </thead>

                </table>              
                    <!-- nav-tabs-custom -->
                  </div>
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

  <!-- Trigger the modal with a button -->
    <div id="myModal" class="modal modal-info fade" role="dialog" style="width: 100%;">
      <div class="modal-dialog" style="width: 50%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Seller Notes</h4>
          </div>
          <div class="modal-body">
            <section class="content"> 
              <label for="seller_desc">Seller Desc :</label>
              <span>Maximum of 3800 characters - 
                <span id="charNumPopup" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left
              </span><br/>
              <textarea rows="4" cols="50" name="seller_description" class="form-control" id="textarea" value="<?php echo htmlentities(''); ?>" onkeyup="countCharPopup(this)"></textarea>         

            </section>                  
          </div>
          <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         
              <button type="button" id="saveModal" class="btn btn-outline" data-dismiss="modal">Save</button>
          </div>
                
        </div>
      </div>
    
    </div>


    <div id="success-modal" class="modal modal-success fade" role="dialog" style="width: 100%;">
      <div class="modal-dialog" style="width: 50%;height: 50%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%; ">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Seller Notes</h4>
          </div>
          <div class="modal-body" style="height: 80px !important;">
            <section class="" > 
              <p> Seller description updated successfully</p>         

            </section>                  
          </div>
          <div class="modal-footer">
              <button type="button" id="closeSuccess" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

          </div>
                
        </div>
      </div>
    
    </div> 

<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
  var data_table = '';
  $(document).ready(function(){

    data_table = $('#biddingTable').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
     "iDisplayLength": 25,
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
      "fixedHeader": true,
    ///////////////////////////////
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'biddingItems/c_biddingItems/biddingData' ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "createdRow": function( row, data, dataIndex){
            if(data){
                $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
                }
              }

      });
   //new $.fn.dataTable.FixedHeader(data_table);
});

    // dataTable =  $('#biddingTable').DataTable({
    // "oLanguage": {
    // "sInfo": "Total Records: _TOTAL_"
    // },
    // "iDisplayLength": 50,
    // "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    // "paging": true,
    // "lengthChange": true,
    // "searching": true,
    // "ordering": true,
    // // "order": [[ 16, "ASC" ]],
    // "info": true,
    // "autoWidth": true,
    // "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    // "createdRow": function( row, data, dataIndex){
    //   if(data){
    //       $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
    //       }
    //     }
    // });
          
  // });

 /*==================================================
  =            FOR SAVING TRACKING NO          =
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
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/saveTrackingNo',
    data: {
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
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
        data_table.destroy();
        data_table = $('#biddingTable').DataTable({
            "oLanguage": {
            "sInfo": "Total Records: _TOTAL_"
          },
          "iDisplayLength": 25,
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
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
  
  }); 

    /*==================================================
  =           FOR UPDATING TRACKING NUMBER            =
  ===================================================*/
    $("body").on('click', '.update_mpn_data', function(){
    //this.disabled = true;
    var rowId=$(this).attr('id');
    var trackingId=$(this).attr('tId');
    //alert(trackingId); return false;
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
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/updateTrackingNo',
    data: {
      'trackingId': trackingId,
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
      $(".loader").hide();
         if(data == 1){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("Success: Tracking number is updated!");  
               //window.location.reload(); 
         }else if(data == 0){
            alert('Error: Failed to update Tracking number!');
           //window.location.reload();
         }else if(data == 2){
            alert('Warning: Sorry! This tracking no has been posted.');
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

/*================================================
=            Save Bidding Offer            =
================================================*/

  $('body').on('click', '.save_offer', function(){
    //this.disabled = true;
    var rowId = $(this).attr('id');
    //alert(rowId); return false;

    var bidding_offer = $("#bidding_offer_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var cat_id = $("#lz_cat_id_"+rowId).val();
    // console.log(bidding_offer+" - " + lz_bd_catag_id +" - "+cat_id);
    // return false; 
    if (bidding_offer.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/saveBiddingOffer',
    data: {
      'bidding_offer': bidding_offer,
      'lz_bd_catag_id': lz_bd_catag_id,
      'cat_id': cat_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);

               // alert("Success: Bidding Offer is saved.");   
               // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);           
           //alert('Error: Bidding Offer is not saved.');

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

/*=====  End of Save Bidding Offer  ======*/

/*================================================
=            Revise Bidding Offer            =
================================================*/

  $('body').on('click', '.revise_offer', function(){
    var offer_id = $(this).attr('id');
    var bidding_offer = $("#bid_offer_"+offer_id).val(); 
    
    if (bidding_offer.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  
    //console.log(offer_id +" - "+bidding_offer);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/reviseBiddingOffer',
    data: {
      'offer_id': offer_id,
      'bidding_offer': bidding_offer
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is Revised.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);

               // alert("Success: Bidding Offer is Revised.");   
               // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not Revised.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);           
           // alert('Error: Bidding Offer is not Revised.');

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

/*=====  End of Revise Bidding Offer  ======*/

/*================================================
=            Save WIN and LOSS Status            =
================================================*/

$("body").on('change', '.winLoss', function(){

  var lz_bd_cata_id = this.id;
  var cat_id = $("#cat_id").val();
  var status = $("#"+lz_bd_cata_id).val();
  lz_bd_cata_id = lz_bd_cata_id.substr(7);
  //console.log(status);return false;
  //console.log(lz_bd_cata_id +" - "+cat_id+" - "+status);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/changeBiddingStatus',
    data: {
      'lz_bd_cata_id': lz_bd_cata_id,
      'cat_id': cat_id,
      'status':status
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Status is saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000); 
           // alert("Success: Bidding Status is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Status is not Saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);            
           // alert('Error: Bidding Status is not Saved.');

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

/*=====  End of Save WIN and LOSS Status  ======*/

/*================================================
=            Save Sold Amount            =
================================================*/

  $('body').on('click', '.sold_amount', function(){
    //this.disabled = true;
    var rowId = $(this).attr('id');
    //alert(rowId); return false;

    var sold_amount = $("#sold_amount_"+rowId).val(); 
    var lz_bd_catag_id = $("#lz_bd_catag_id_"+rowId).val(); 
    var cat_id = $("#lz_cat_id_"+rowId).val();
    //console.log(sold_amount+" - " + lz_bd_catag_id +" - "+cat_id);
    // return false; 
    if (sold_amount.length === 0) 
    { 
      alert('Sold Amount is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/saveSoldAmount',
    data: {
      'sold_amount': sold_amount,
      'lz_bd_catag_id': lz_bd_catag_id,
      'cat_id': cat_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Sold Amount is saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);                     
           // alert("Success: Sold Amount is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Sold Amount is not saved.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);             
           // alert('Error: Sold Amount is not saved.');

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

/*=====  End of Save Sold Amount  ======*/

/*================================================
=            Update Sold Amount            =
================================================*/

  $('body').on('click', '.update_sold_amount', function(){
    var offer_id = $(this).attr('id');
    var sold_amount = $("#amount_sold_"+offer_id).val(); 
    
    if (sold_amount.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  
    //console.log(offer_id +" - "+bidding_offer);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/updateSoldAmount',
    data: {
      'offer_id': offer_id,
      'sold_amount': sold_amount
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
          //$("#printMessage").html("");
          $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Sold Amount is updated.</div>"); 
            setTimeout(function(){ $("#printMessage").text('');}, 2000);
          // alert("Success: Sold Amount is updated.");   
          // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
          $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Sold Amount is not updated.</div>");
            setTimeout(function(){ $("#printMessage").text('');}, 2000);           
           // alert('Error: Sold Amount is not updated.');

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

/*=====  End of Update Sold Amount  ======*/

/*==================================================
=            Delete record is_deleted 1            =
==================================================*/
$("body").on('click','.flag-trash', function() {
   var lz_bd_cata_id = $(this).attr("id");
   var cat_id = $("#cat_id").val();
   //console.log(lz_bd_cata_id+" - "+ cat_id); return false;
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>biddingItems/c_biddingItems/trashResultRow', //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
         data : {'lz_bd_cata_id':lz_bd_cata_id, 'cat_id':cat_id},
        success: function(data){
          $(".loader").hide();
            if(data == 1){
              $(".loader").hide();
              var row=$("#"+lz_bd_cata_id);
              //debugger;     
              row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });
              //window.location.reload();
             //$('#'+id).remove();
            }else if(data == 2){
              alert("Not Deleted.");
            }
        },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
    });    
 });

/*=====  End of Delete record is_deleted 1  ======*/

/*============================================
=            Find item for Verify            =
============================================*/

  $('body').on('click', '#find_item', function(){
    //var category_id = $("#category_id").val();
    var ebay_id = $("#ebay_id").val(); 
    //console.log(category_id +" - "+ebay_id);return false;
    //console.log(ebay_id.length);return false;
    
    if(ebay_id.length === 0){
      alert('Please Input eBay Id.'); 
      return false;      
    }else if(ebay_id.length != 12){
      alert('Please Input correct eBay Id.');
      return false;
    }  
    //console.log(offer_id +" - "+bidding_offer);return false;
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>biddingItems/c_biddingItems/findItem',
    data: {
      // 'category_id': category_id,
      'ebay_id': ebay_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         // if(data == 1){
         //  $("#findItemMessage").html("");
         //  $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Title is moved to Active Data.</div>");
         //    setTimeout(function(){ $("#findItemMessage").text('');}, 3000);            
         //  //console.log("Title is moved.");
         // }else 
         if(data == 2){
           $(".loader").hide();

          $("#findItemMessage").html("");
          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Title is verified and datetime is updated.</div>");
            setTimeout(function(){ $("#findItemMessage").text('');}, 3000);            
           //console.log("Title is not moved.");


         }else if(data.get_brands != ""){
          //console.log("Unverify");
          $("#get_brands").html("");
            var appendText = []; 
            for (var i = 0; i < data.get_brands.length; i++) {
                appendText.push('<option value="'+data.get_brands[i].DET_ID+'">'+data.get_brands[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
            }

            //Since we defined our variable as an array up there we join it here into a string
            appendText.join(" ");
            $("#get_brands").html("");
            $("#get_brands").append('<label>Select Brand:</label><select name="brand" id="brand" class="form-control selectpicker" data-live-search="true"><option value="0">Select......</option>'+appendText+'</select>');
            $('.selectpicker').selectpicker();
                   

          $("#resultTable" ).html("");
           //var tr='';
           $( "#resultTable" ).html("<table class='table table-bordered table-striped' border='1' id='findItemResult'><thead><th>EBAY ID</th> <th>ITEM DESCRIPTION</th> <th>SELLER ID</th> <th>FEEDBACK SCORE</th> <th>LISTING TYPE</th> <th>CONDITION</th> <th>ACTIVE PRICE</th><th>START TIME</th><th>SALE TIME</th></thead>"); //  for ( var i = 1; i < data.itemCount+1; i++ ) {

          var ebay_id = data.active_result[0].EBAY_ID;
          var category_id = data.active_result[0].CATEGORY_ID;
          var lz_bd_cata_id = data.active_result[0].LZ_BD_CATA_ID;
          var title = data.active_result[0].TITLE;
          var item_url = data.active_result[0].ITEM_URL;
          var condition_name = data.active_result[0].CONDITION_NAME; 
          var seller_id = data.active_result[0].SELLER_ID;
          var listing_type = data.active_result[0].LISTING_TYPE;
          var sale_price = data.active_result[0].SALE_PRICE;
          var start_time = data.active_result[0].START_TIME;
          var sale_time = data.active_result[0].SALE_TIME;
          var feedback_score = data.active_result[0].FEEDBACK_SCORE;
          var verified = data.active_result[0].VERIFIED;
          
          $('<tr>').html("<td><input type='hidden' name='lz_bd_cata_id' id='lz_bd_cata_id' value='"+ lz_bd_cata_id +"'> <input type='hidden' name='category_id' id='category_id' value='"+ category_id +"'> <input type='hidden' name='verify_ebay_id' id='verify_ebay_id' value='"+ ebay_id +"'><a href='"+ item_url +"' target = '_blank'>" + ebay_id + "</a></td><td>" + title + "</td><td>" + seller_id + "</td><td>" + feedback_score + "</td><td>" + listing_type + "</td><td>" + condition_name + "</td><td>" + sale_price + "</td><td>" + start_time + "</td><td>" + sale_time + "</td></tr></table>").appendTo('#findItemResult');
        }else if(data.get_brands == ""){
          //$("#objectSection").html("");

          $("#findItemMessage").html("");
          $("#resultTable" ).html("");
          $("#get_brands").html("");
          $("#fetchObjects").html("");
          $("#addMpnbutton").html("");
                    

          $("#findItemMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Item is not verified. Please add MPN manually.</div>");
            setTimeout(function(){ $("#findItemMessage").text('');}, 3000);

            $("#fetchObjects").append('<input type="button" class="btn btn-warning btn-md btn-block" name="objects" id="objects" value="Fetch Objects">');  
            $("#addMpnbutton").append('<input type="button" class="btn btn-primary btn-md btn-block" id="mpnContent" value="Add MPN">');

          $("#resultTable" ).html("");
           //var tr='';
           $( "#resultTable" ).html("<table class='table table-bordered table-striped' border='1' id='findItemResult'><thead><th>EBAY ID</th> <th>ITEM DESCRIPTION</th> <th>SELLER ID</th> <th>FEEDBACK SCORE</th> <th>LISTING TYPE</th> <th>CONDITION</th> <th>ACTIVE PRICE</th><th>START TIME</th><th>SALE TIME</th></thead>"); //  for ( var i = 1; i < data.itemCount+1; i++ ) {

          var ebay_id = data.active_result[0].EBAY_ID;
          var category_id = data.active_result[0].CATEGORY_ID;
          var lz_bd_cata_id = data.active_result[0].LZ_BD_CATA_ID;
          var title = data.active_result[0].TITLE;
          var item_url = data.active_result[0].ITEM_URL;
          var condition_name = data.active_result[0].CONDITION_NAME; 
          var seller_id = data.active_result[0].SELLER_ID;
          var listing_type = data.active_result[0].LISTING_TYPE;
          var sale_price = data.active_result[0].SALE_PRICE;
          var start_time = data.active_result[0].START_TIME;
          var sale_time = data.active_result[0].SALE_TIME;
          var feedback_score = data.active_result[0].FEEDBACK_SCORE;
          var verified = data.active_result[0].VERIFIED;
          
          $('<tr>').html("<td><input type='hidden' name='lz_bd_cata_id' id='lz_bd_cata_id' value='"+ lz_bd_cata_id +"'> <input type='hidden' name='category_id' id='category_id' value='"+ category_id +"'> <input type='hidden' name='verify_ebay_id' id='verify_ebay_id' value='"+ ebay_id +"'><a href='"+ item_url +"' target = '_blank'>" + ebay_id + "</a></td><td>" + title + "</td><td>" + seller_id + "</td><td>" + feedback_score + "</td><td>" + listing_type + "</td><td>" + condition_name + "</td><td>" + sale_price + "</td><td>" + start_time + "</td><td>" + sale_time + "</td></tr></table>").appendTo('#findItemResult');            
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

/*=====  End of Find item for Verify  ======*/

/*=======================================================================
=            On change of Brand show MPN            =
=======================================================================*/
$('body').on('change', '#brand', function(){
  var category_id = $("#category_id").val();
  var brand_name = $("#brand option:selected").text();
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_mastermpn',
      data: { 'category_id' : category_id, 'brand_name':brand_name},
     success: function (data) {
      $(".loader").hide();
        if(data){
            var mpn = [];
            for(var i = 0;i<data.length;i++){
              mpn.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');
            }
            $("#appendMpnlist").html("");
            $("#verifyButton").html("");
            $("#fetchObjects").html("");
            $("#addMpnbutton").html("");
            $("#appendMpnUPC").html("");

            $("#appendMpnlist").append('<label>Select MPN:</label> <select name="verifiedmpn" id="verifiedmpn" class="form-control selectpicker" data-live-search="true">' + mpn.join("") + '</select>'); 
            $('.selectpicker').selectpicker();
            $('#appendMpnUPC').append('<label>UPC:</label><input class="form-control" type="text" name="get_MpnUpc" id="get_MpnUpc"/>');
            $("#verifyButton").append('<input type="button" class="btn btn-success btn-md btn-block" name="verifyTitle" id="verifyTitle" value="Verify">');
            $("#fetchObjects").append('<input type="button" class="btn btn-warning btn-md btn-block" name="objects" id="objects" value="Fetch Objects">');
            $("#addMpnbutton").append('<input type="button" class="btn btn-primary btn-md btn-block" id="mpnContent" value="Add MPN">');

        }else{
          console.log('Error! No Data Found.');
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

/*=======================================================================
=            On change of MPN show UPC            =
=======================================================================*/
$(document).on('change', '#verifiedmpn', function(){
  var category_id = $("#category_id").val();   
  var brand_name = $("#brand option:selected").text();  
  var mpn_val = $("#verifiedmpn").val();
   // console.log(mpn_val);
   // return false;
      $(".loader").show();  get_MpnUpc
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_MpnUPC',
      data: { 'category_id' : category_id, 'brand_name':brand_name, 'mpn_val':mpn_val},
     success: function (data) {
      $(".loader").hide();
         if(data){
              $('#get_MpnUpc').val(data.get_Mpn[0].UPC);
            }
            else{
               $('#get_MpnUpc').val("");
            }         
     },
       complete: function(data){
      $(".loader").hide();
    }
    }); 
});
/*=====  End of On change of MPN show UPC  ======*/  
//toggle MPN Section
$('body').on('click', '#mpnContent', function(){  
  $('#contentSec').toggle();
  $('#objectSection').hide();  
});
/*=====  End of On change of Brand show MPN  ======*/

// $('body').on('click', '#objects', function(){  
//   $('#objectSection').toggle();
// }); 
/*=======================================================================
=            On click on fetch object button fetch object list            =
=======================================================================*/
$('body').on('click', '#objects', function(){
  $('#get_brands').hide();
  $('#appendMpnlist').hide();
  $('#verifyButton').hide();
  $('#objectSection').show();
  
  var category_id = $("#category_id").val();
  //alert(category_id); return false;

      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_Objects',
      data: { 'category_id' : category_id},
     success: function (data) {
      $(".loader").hide();
        if(data){
            var objects = [];
            for(var i = 0;i<data.length;i++){
              objects.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>');
            }
            $("#objDropdown").html("");
            $("#objlist").html("");
            $("#inpBrand").html("");
            $("#inpKeyword").html("");
            $("#findMpn").html("");            
            $("#objDropdown").append('<label>Select Object:</label> <select name="objlist" id="objlist" class="form-control selectpicker" data-live-search="true">' + objects.join("") + '</select>'); 
            $('.selectpicker').selectpicker();
            // add inputs and button for search mpn
            $("#inpBrand").append('<label>Type Brand:</label> <input type="text" name="type_brand" id="type_brand" class="form-control" >'); 
            $("#inpKeyword").append('<label>Type Keyword:</label> <input type="text" name="type_keyword" id="type_keyword" class="form-control" >'); 
            $("#findMpn").append('<input type="button" name="search_mpn" id="search_mpn" class="btn btn-block btn-sm btn-primary" value="Find MPN">');

        }else{
          console.log('Error! No Data Found.');
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
 
/*=====  End of On click on fetch object button fetch object list  ======*/

/*=======================================================================
=             on change object dropdown fetch MPN list            =
=======================================================================*/
$('body').on('click', '#search_mpn', function(){
  
  var category_id = $("#category_id").val();
  var type_brand = $("#type_brand").val();
  var type_keyword = $("#type_keyword").val();
  var object_id = $("#objlist option:selected").val();

  $(".loader").show();
  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/get_objectWiseMpn',
    data: { 'category_id' : category_id, 'object_id':object_id, 'type_brand':type_brand, 'type_keyword':type_keyword},
   success: function (data) {
    $(".loader").hide();
      if(data){
          var mpn = [];
          for(var i = 0;i<data.length;i++){
            mpn.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');
          }

          $("#objMpns").html("");

          $("#objMpns").append('<label>Select MPN:</label> <select name="mpnlist" id="mpnlist" class="form-control selectpicker" data-live-search="true">' + mpn.join("") + '</select>'); 
          $('.selectpicker').selectpicker();

      }else{
        console.log('Error! No Data Found.');
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
 
/*=====  End of  on change object dropdown fetch MPN list  ======*/
/*=======================================================================
=            onclick save mpn            =
=======================================================================*/

$('body').on('click', '#saveMPN', function(){
  var category_id = $("#category_id").val();
  var mpn = $("#mpnlist option:selected").val();
  var ebay_id = $("#verify_ebay_id").val();
    if(ebay_id.trim() == ''){
    alert('Please add ebay id');
    return false;
  }
  //var lz_bd_cata_id = $("#lz_bd_cata_id").val();
  //console.log(category_id +" - "+verifiedmpn+" - "+verify_ebay_id); return false;
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/saveAndVerifyMpn',
      data: { 'category_id' : category_id, 'mpn':mpn, 'ebay_id': ebay_id              
    },
     success: function (data) {
      $(".loader").hide();
        if(data){
          alert('Sucess! Title is verified.');
          location.reload();
        }else{
          alert('Error! Title is not verified.');
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

/*=====  End of Onload show mpn cateogires wise  ======*/

/*=======================================================================
=            Onload show mpn cateogires wise            =
=======================================================================*/

$('body').on('click', '#verifyTitle', function(){
  var category_id = $("#category_id").val();
  var verifiedmpn = $("#verifiedmpn").val();
  var verifiedMpnUpc=$("#get_MpnUpc").val();
  // console.log(verifiedMpnUpc);
  // return false;
  var verify_ebay_id = $("#verify_ebay_id").val();
    if(verify_ebay_id.trim() == ''){
    alert('Please add ebay id');
    return false;
  }
  //var lz_bd_cata_id = $("#lz_bd_cata_id").val();
  //console.log(category_id +" - "+verifiedmpn+" - "+verify_ebay_id); return false;
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/verifyMPN',
      data: { 'category_id' : category_id, 'verifiedmpn':verifiedmpn, 'verify_ebay_id': verify_ebay_id,'verifiedMpnUpc':verifiedMpnUpc              
    },
     success: function (data) {
      $(".loader").hide();
        if(data){
          alert('Sucess! Title is verified.');
          location.reload();
        }else{
          alert('Error! Title is not verified.');
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

/*=====  End of Onload show mpn cateogires wise  ======*/
/*=====================================================
=            pop-up for seller description            =
=====================================================*/
 var ebayLink = '';
 var track_no = '';
 $(document).on('click','.seller',function(){
  var num_id = this.id.match(/\d+/);
  $('#textarea').val('');
  ebayLink = $('#link'+num_id+'').attr('href');
  track_no = $('#ct_tracking_no_'+num_id+'').val();
  $('#titlelength').val(3800);
  $('#myModal').modal('show');
  // $('#success-modal').modal('show');

   $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/getSellerDescription',  
      data:{'track_no':track_no},
      success : function(data){
        // console.log(data);
        var abc = data[0].SELLER_DESCRIPTION;
        //console.log(abc);
        var num = abc.indexOf('\n')-8;
        //console.log(num);
        var string = abc.substr(8, num); 
        //console.log(string);
        $('#textarea').val(string);
      }
    });
 });

$('#saveModal').on('click',function(){
  var value = $('#textarea').val();
  // alert(track_no);return false;
  // alert(ebayLink);
  var part2 = ebayLink.split('/');
  var lastSegment = part2.pop() || part2.pop();
  // alert(lastSegment);
  var seller_notes = 'Notes : '+value+'  \n Click : <a href='+ebayLink+'>here</a> to open original Listing';
  // alert(seller_notes);return false;

  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>biddingItems/c_biddingItems/updateSellerDescription',  
    data:{'seller_notes':seller_notes,'track_no':track_no},
    success : function(data){
      $(".loader").hide();
      if(data == 1){
        $('#myModal').modal('hide');
        $('#success-modal').modal('show');
      }
      // alert('seller description updated');
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }  
  });

  
});

$('#closeModal').on('click',function(){
  $('#myModal').modal('hide');
});   

$('#closeSuccess').on('click',function(){
   $('#success-modal').modal('hide');
});


  function countChar(val) {
    var len = val.value.length;
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(80 - len);
    }
  }
  function countCharPopup(val) {
    var len = val.value.length;
    if (len >= 3800) {
      val.value = val.value.substring(0, 3800);
    } else {
      $('#charNumPopup').text(3800 - len);
    }
  }
// function textCounter(field,cnt, maxlimit) {         
//   var cntfield = document.getElementById(cnt) 
//      if (field.value.length > maxlimit) // if too long...trim it!
//     field.value = field.value.substring(0, maxlimit);
//     // otherwise, update 'characters left' counter
//     else
//     cntfield.value = maxlimit - field.value.length;
// }
/*=====  End of pop-up for seller description  ======*/  

/*=========================================
=            save mpn function            =
=========================================*/
$(document).on('click', '#save_mpn', function(event) {
  event.preventDefault();
  var category_id =   $("#category_id").val();
  var mpn_object = $("#mpn_object").val();
  var mpn_brand = $("#mpn_brand").val();
  var mpn_input = $("#mpn_input").val();
  var mpn_description = $("#mpn_description").val();
  var verify_ebay_id = $("#verify_ebay_id").val();
  var lot_upc = $("#lot_upc").val();
      
  if(category_id.trim() == ''){
    alert('Please select category id');
    return false;
  }else if(mpn_object.trim() == ''){
    alert('Please add object');
    $("#mpn_object").focus();
    return false;
  }else if(mpn_brand.trim() == ''){
    alert('Please add brand');
    $("#mpn_brand").focus();
    return false;
  }else if(mpn_input.trim() == ''){
    alert('Please add MPN');
    $("#mpn_input").focus();
    return false;
  }else if(mpn_description.trim() == ''){
    alert('Please add MPN Description');
    $("#mpn_description").focus();
    return false;
  }
 var url = '<?php echo base_url();?>biddingItems/c_biddingItems/saveMpn';
 $(".loader").show();
 $.ajax({
   url: url,
   type: 'POST',
   dataType: 'json',
   data: {'category_id': category_id ,  'mpn_object': mpn_object, 'mpn_brand':mpn_brand, 
          'mpn_input':mpn_input, 'mpn_description':mpn_description, 'verify_ebay_id':verify_ebay_id, 'lot_upc':lot_upc},
    success:function(data){
        if (data == 2) {
          $(".loader").hide();
          alert("MPN is already exist");
          //location.reload();
        }else if(data == 1){
          $(".loader").hide();
          alert("MPN is added and verified");
          location.reload();          
        }else if(data == 0){
          $(".loader").hide();
          alert("Error! MPN is not verified");          
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
 })
});


/*=====  End of save mpn function  ======*/

</script>
