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
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <form action="<?php //echo base_url().'catalogueToCash/c_purchasing/search_mpn_wise_purchasing/'.$cat_id.'/'.$catalogue_mt_id; ?>" method="post" accept-charset="utf-8"> -->
    <section class="content-header">
      <h1>
        Purchasings
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Purchasing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
     <div class="row">
        <div class="box collapsed-box"><br>  
           <div class="box-header with-border">
            <h3 class="box-title">Search Part</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
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
           <!--  <div class="col-sm-12">
               <div class="col-sm-6">
                 <h4>MPN : <?php 
                 //if(!empty($data['mpn'])){
                  // echo @$data['mpn'][0]['MPN'];
                 //}?></h4>
               </div>
               
                     
           </div> -->
             <div class="col-sm-12">
              <?php 
                $cat_id= $this->uri->segment(4);
                $catalogue_mt_id= $this->uri->segment(5);
                  

               ?>
                <!-- <form action="<?php //echo base_url().'catalogueToCash/c_purchasing/searchByListType/'.$cat_id.'/'.$catalogue_mt_id; ?>" method="post" accept-charset="utf-8"> -->
              <form action="<?php echo base_url().'catalogueToCash/c_purchasing/search_mpn_wise_purchasing/'.$cat_id.'/'.$catalogue_mt_id; ?>" method="post" accept-charset="utf-8"> 
                <div class="col-sm-3">
                  <div class="form-group" id ="listDropDown">
                    <label for="Search Webhook">Listing Type:</label>
                    <?php $this->session->unset_userdata('Search_List_type'); ?>
                      <?php $ctListingType = $this->session->userdata('Search_List_type'); ?>
                      <select  name="serc_listing_Type[]" id="listingType" class="selectpicker form-control" multiple data-live-search="true">
                        <option value="all">All</option>
                        <?php  
                           
                          foreach(@$dataa['list_types'] as $type):                    
                            $selected = "";
                            foreach(@$ctListingType as $selectedVal){ 

                              if ($selectedVal == $type['LISTING_TYPE']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                              <option value="<?php echo $type['LISTING_TYPE']; ?>"<?php echo $selected; ?>><?php echo $type['LISTING_TYPE']; ?></option>
                              <?php
                            endforeach;
                            
                               
                           ?>                     
                      </select>                       
                  </div>
                </div>  
                 <div class="col-sm-3">
                  <div class="form-group" id="conditionDropdown">
                    <label for="Condition">Condition:</label>
                    <?php $this->session->unset_userdata('Search_condition'); ?>
                    <?php //var_dump($this->session->userdata('Search_condition'));
                      $listCondition = $this->session->userdata('Search_condition'); ?>
                      <select  name="condition[]" id="condition" class="selectpicker form-control" multiple data-live-search="true">
                        <option value="all">All</option>
                        <?php
                        //$this->session->unset_userdata('unverify_condition'); 
                          foreach(@$dataa['conditions'] as $type):                    
                            $selected = "";
                            foreach(@$listCondition as $selectedcon){ 

                              if ($selectedcon == $type['ID']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                             <option value="<?php echo $type['ID']; ?>"<?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                              <?php
                            endforeach;
                         
                           ?>                     
                      </select> 

                  </div>
                </div> 

                <div class="col-sm-3">
                  <div class="form-group" id="sellerDropdown">
                    <label for="Search Webhook">Seller Id:</label>
                      <?php $this->session->unset_userdata('Search_seller'); ?>
                    <?php //var_dump($this->session->userdata('Search_seller'));
                      $Search_seller = $this->session->userdata('Search_seller'); ?>
                       <select name="seller[]" id="seller" class="selectpicker form-control" multiple data-live-search="true">
                        <option value="all">All</option>
                        <?php 

                        foreach(@$dataa['seller'] as $type):                    
                            $selected = "";
                            foreach(@$Search_seller as $selectedseller){ 

                              if ($selectedseller == $type['SELLER_ID']){
                                  $selected = "selected";

                                } 
                              } //end foreach
                                            
                              ?>
                              <option value="<?php echo $type['SELLER_ID']; ?>"<?php echo $selected; ?>><?php echo $type['SELLER_NAME']; ?></option>
                              <?php
                            endforeach;

                           ?>                     
                      </select> 


                  </div>
                </div> 
     

                <div class="col-sm-3">
                  <div class="form-group" id="mpnDropdown">
                    <label for="Search Webhook">MPN:</label>
                    <?php $this->session->unset_userdata('mpn'); ?>
                      <select class="form-control selectpicker" name="mpn" id="mpn" data-live-search="true">
                        <option value="">All</option>
                        <?php 
                        //$this->session->unset_userdata('mpn');
                        $mpn= $this->session->userdata("mpn");                                
                          foreach(@$dataa['mpn'] as $type){ 
                          if ($mpn == strtoupper($type['MPN'])){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                 
                              ?>
                              <option value="<?php echo $type['MPN']; ?>"<?php echo $selected; ?>><?php echo $type['MPN_NAME']; ?></option>
                              <?php
                              } 
                           ?>                     
                      </select> 

                  </div>
                </div>  

              <div class="col-sm-3">
                <div class="form-group" id="sortDropdown">
                  <?php //var_dump($this->session->userdata('title_sort'));?>
                  <label for="Search Webhook">Title Sort:</label>
              <?php $this->session->unset_userdata('title_sort'); ?>
              <?php
              $arrstate = array ('1' => 'Shortest To Longest','2' => 'Longest To Shortest'); ?>
              <select class="form-control selectpicker sortDropdown" name="title_sort" id="title_sort" data-live-search="true">
              <option value="">All ....</option>
              <?php
              foreach($arrstate as $key => $value) {
              ?>


  
            <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('title_sort') == $key){echo "selected";}?>><?php echo $value; ?></option>
              <?php
              }
              ?>
              </select>

           

                </div>
              </div>
               <div class="col-sm-2">
                <div class="form-group" id="timeDropdown">
                  <label for="Search Webhook" >From Time:</label>
              <?php $this->session->unset_userdata('time_sort'); ?>
              <?php
              $time = array ('1' => 'Last 24 Hours','2' => 'Last 48 Hours','3' => 'Last 72 Hours'); ?>
              <select class="form-control selectpicker" name="time_sort" id="time_sort" data-live-search="true">
              <option value="">All ....</option>
              <?php
              foreach($time as $key => $value) {
              ?>
 
            <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('time_sort') == $key){echo "selected";}?>><?php echo $value; ?></option>
              <?php
              }
              ?>
              </select>

           

                </div>
              </div>

              <div class="col-sm-2">
               <?php $this->session->unset_userdata('fed_one'); ?>
              <div class="form-group">
              <label for="Feedback Score">Feedback Score:</label>
              <div class="input-group" >
              <?php //$this->session->unset_userdata('fed_one'); ?>
              <?php $this->session->unset_userdata('fed_two'); ?>
              <input type="text" name ="fed_one" class="form-control clear" VALUE="<?php echo  $this->session->userdata('fed_one');?>"  />
              <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>

              <?php //$this->session->unset_userdata('fed_two'); ?>
              <input type="text" name ="fed_two" class="form-control clear" VALUE="<?php echo  $this->session->userdata('fed_two');?>" />
              </div>
              </div>
                        
            </div>

            <div class="col-sm-2">
                 <?php $this->session->unset_userdata('perc_one'); ?>                      
              <div class="form-group">
              <label for="Feedback Score">Price Percent  %:</label>
              <div class="input-group" >
              
              <?php //$this->session->unset_userdata('perc_one'); ?>
              <input type="text" name ="perc_one" class="form-control clear" VALUE="<?php echo  $this->session->userdata('perc_one');?>"  />
              <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
              <?php $this->session->unset_userdata('perc_two'); ?>  
              <?php //$this->session->unset_userdata('perc_two'); ?>
              <input type="text" name ="perc_two" class="form-control clear" VALUE="<?php echo  $this->session->userdata('perc_two');?>" />
              </div>
              </div>

            </div>
          
            


                  <div class="col-sm-4">
                <?php $this->session->unset_userdata('serchkeyword'); ?>  
                  <div class="form-group">
                    <label for="Search Webhook">Search Title:</label>
                      <input type="text" name="search_title" class="form-control clear" placeholder="Search Title" value="<?php echo htmlentities($this->session->userdata('serchkeyword')); ?>" >    

                  </div>
              
                </div> 

                 <div class="col-sm-3">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_webhook" id="search_webhook" value="Search">
                  </div>
                </div> 
                <div class="col-sm-2">
                                    
              <div class="form-group p-t-24">
                <button type ="button" class="btn btn-sm btn-primary " id="reset">Reset Filters</button>
            
              </div>
              </div>
              </form>                                              
            </div> 
            </div> 
            </div> 
            </div>  
              
              <div class="row">
              <div class="box"><br>    
                <div class="box-header with-border">
                <h3 class="box-title">Data</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                  </div>
                </div>     
                <div class="box-body"> 
                 <div class="col-md-12"><!-- Custom Tabs -->
                  <table id="search-purchasing-table" class="table table-responsive table-striped table-bordered table-hover">
                    <thead>
                     <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th colspan="4" class="text text-center" style="background: #1BC8C8; color: white;">ASSEMBLY ITEMS</th>
                      <th colspan="3" class="text text-center" style="background: #708090; color: white;">COMPONENT ITEMS</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th colspan="4" class="text text-center" style="background: #1BC8C8; color: white;">ASSEMBLY SELLING CHARGES</th>
                      <th colspan="4" class="text text-center" style="background: #708090; color: white;">COMPONENT SELLING CHARGES</th>
                    </tr>
                    <tr>
                      <th>EBAY ID</th>
                      <th>ITEM DESCRIPTION</th>
                      <th>FLAGS</th>
                      <th>SELLER ID</th>
                      <th>FEEDBACK SCORE</th>
                      <th>LISTING TYPE</th>
                      <th>REMAINING TIME</th>
                      <th>MPN</th>
                      <th>CONDITION</th>

                      <th>ACTIVE PRICE</th>
                      <th>SOLD AVG</th>
                      <th>LIST SOLD</th>
                      <th>KIT</th>
                      <th>SELLING</th>
                      <th>AMOUNT</th>
                      <th> %1</th>

                      <!-- <th>ACTIVE PRICE</th> -->
                      <th>SELLING</th>
                      <th>AMOUNT</th>
                      <th> %2</th>

                      <th>STATUS</th>
                      <th>BID STATUS</th>
                      <th>BID/OFFER</th>
                      <th>KIT VIEW</th>
                      <th style="width:200px;">TRACKING</th>
                      <th>COST PRICE</th>

                      <th>EBAY</th>
                      <th>PAYPAL</th>
                      <th>SHIP</th>
                      <th>TOTAL</th>

                      <th>EBAY</th>
                      <th>PAYPAL</th>
                      <th>SHIP</th>
                      <th>TOTAL</th>
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
            </div>
            </section>

            <!-- /.box -->
          
        <!-- /.col -->
        </div>
      <!-- /.row -->
  <!-- Trigger the modal with a button -->
  <!-- Modal --> 
    <!-- /.content -->
    <?php 
      /* $multi_data = array(
            'Search_List_type' => '',
            'Search_condition'=>'',
            'Search_seller' => '',
            'serchkeyword' => '',
            'Search_category' => '',
            // "mpn" => $mpn,
             'fed_one' => '',
             'fed_two' => '',
             'perc_one' => '',
             'perc_two' => '',
           
             'title_sort' => '',
             'time_sort' => ''

      );
    $this->session->set_userdata($multi_data);*/
     ?>
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
  <script>
$(document).ready(function(){
var data_table = $('#search-purchasing-table').DataTable( { 
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
        url :"<?php echo base_url().'catalogueToCash/c_purchasing/load_search_mpn_wise_purchsing/'.$this->uri->segment(4).'/'.$this->uri->segment(5); ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
   new $.fn.dataTable.FixedHeader(data_table);

  //////////////////////////////////////
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $(document).on('click', '.save_mpn_data', function(){
    //this.disabled = true;
    var rowId=$(this).attr('id');
    //alert(totalIds); return false;

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
         if(data ==true){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("Success: Tracking No is updated!");   
               //window.location.reload(); 
         }else{
               alert('Error: Failed to update Tracking No!');
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
  /*==================================================
  =           FOR UPDATING KIT COMPONENTS             =
  ===================================================*/
  $(".update_mpn_data").on('click', function(){
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
    url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/updateTrackingNo',
    data: {
      'trackingId': trackingId,
      'ct_tracking_no': ct_tracking_no,
      'ct_cost_price': ct_cost_price,
      'lz_bd_catag_id': lz_bd_catag_id,
      'lz_cat_id': lz_cat_id
    },
    dataType: 'json',
    success: function (data) {
         if(data ==true){
           //window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bkProfiles';
               alert("Success: Tracking No is updated!");   
               //window.location.reload(); 
         }else{
               alert('Error: Failed to update Tracking No!');
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
});
/*==============================================================
=    FOR CHARGES FLAGS UPDATION                                =
================================================================*/
$('body').on('change', '.kit_flag', function(){
  var flag_id = $(this).val();
  var lz_bd_cata_id = $(this).attr("id");
  //var ctc_kit_flag_id = $(this).attr("cid");
  var cat_id = $(this).attr("catid");
  //console.log(lz_bd_cata_id); return false;
  if (flag_id !=20) {
    $(".loader").show();
       $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/updateFlag',
        data: {'flag_id' : flag_id, 'cat_id' : cat_id, 'lz_bd_cata_id' : lz_bd_cata_id},
        success: function (data) {
        //console.log(data);
        if (data == true) {
          jQuery("#ctc_kit_flag_id").fadeOut( 100 , function() {
              $("#ctc_kit_flag_id").append('<div class="flags"><i class="fa fa-thumbs-up" aria-hidden="true"></i></div>');
            }).fadeIn( 1000 );
          
        }else {
           jQuery(".kit_flag").fadeOut( 100 , function() {
              $(".kit_flag").append('<div class="flags" style="color:red"><p>error</p></div>');
          }).fadeIn( 1000 );
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
  }else {
    $(".loader").show();
     $.ajax({
        url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/trashResultRow', 
        //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data: {'flag_id' : flag_id, 'cat_id' : cat_id, 'lz_bd_cata_id' : lz_bd_cata_id},
        success: function(data){
           $(".loader").hide();
            if(data == true){

              var row=$("#"+lz_bd_cata_id);
              //debugger;     
              row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });
             //$('#'+id).remove();
            }
        },
          error: function(jqXHR, textStatus, errorThrown){
             $(".loader").hide();
            if (jqXHR.status){
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
        },
        complete: function(data){
          $(".loader").hide();
        }
    });
  }
 
});
  /*==============================================================
  =               FOR CHARGES FLAGS UPDATION                     =
  ================================================================*/

  $("#reset").on('click',function() {
    
   $(".clear").val("");
   $('#sortDropdown').html("");
   $('#sortDropdown').append('<label for="Search Webhook">Title Sort:</label><select class="form-control selectpicker" name="title_sort" id="title_sort" data-live-search="true"><option value="0">All ....</option><option value="1">Shortest To Longest</option><option value="2">Longest To Shortest</option></select>');

   $('#timeDropdown').html("");
   $('#timeDropdown').append('<label for="Search Webhook">Title Sort:</label><select class="form-control selectpicker" name="time_sort" id="time_sort" data-live-search="true"><option value="0">All ....</option><option value="1">Last 24 Hours</option><option value="2">Last 48 Hours</option><option value="3">Last 72 Hours</option></select>');

   var cat_id = '<?php echo $this->uri->segment(4);?>';
   // alert(cat_id);return false;
   var catalogue_id = '<?php echo $this->uri->segment(5);?>';
   $.ajax({
      type: 'POST',
      url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/resetUnVerifyDropdown',
      data:{'cat_id':cat_id,'catalogue_id':catalogue_id},
      dataType: 'json',
      success: function (data) {
        //---Category dropdown starts----//
        //var catData = [];
        //console.log(data);
        //catData.push('<option value="all">All</option>');
       /* for (var i = 0; i < data.cattegory.length; i++) {
          catData.push('<option value="'+data.cattegory[i].CATEGORY_ID+'">'+data.cattegory[i].CATEGORY_NAME+'</option>');
        }*/

        /*$("#appCat").html("");
        $("#appCat").append('<label for="Category">Category Id:</label><select  name="category[]" id="category" class="selectpicker form-control" multiple data-live-search="true">'+catData.join("")+'</select>');
        
        $('.selectpicker').selectpicker();*/
        //---Category dropdown ends----//

        //---LISTING_TYPE dropdown starts----//
        var listData = [];
        listData.push('<option value="all">All</option>');
        for (var i = 0; i < data.list_types.length; i++) {
          listData.push('<option value="'+data.list_types[i].LISTING_TYPE+'">'+data.list_types[i].LISTING_TYPE+'</option>');
        }

        $("#listDropDown").html("");
        $("#listDropDown").append('<label for="Search Webhook">Listing Type:</label><select  name="serc_listing_Type[]" id="listingType" class="selectpicker form-control" multiple data-live-search="true">'+listData.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---LISTING_TYPE dropdown ends----//


        //---conditon dropdown starts----//
        var conditon = [];
        conditon.push('<option value="all">All</option>');
        for (var i = 0; i < data.conditions.length; i++) {
          conditon.push('<option value="'+data.conditions[i].ID+'">'+data.conditions[i].COND_NAME+'</option>');
        }

        $("#conditionDropdown").html("");
        $("#conditionDropdown").append('<label for="Condition">Condition:</label><select  name="condition[]" id="condition" class="selectpicker form-control" multiple data-live-search="true">'+conditon.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---conditon dropdown ends----//

        //---Seller_id dropdown starts----//
        var seller = [];
        seller.push('<option value="all">All</option>');
        for (var i = 0; i < data.seller.length; i++) {
          seller.push('<option value="'+data.seller[i].SELLER_ID+'">'+data.seller[i].SELLER_NAME+'</option>');
        }

        $("#sellerDropdown").html("");
        $("#sellerDropdown").append('<label for="Seller Id">Sellr Id:</label><select name="seller[]" id="seller" class="selectpicker form-control" multiple data-live-search="true">'+seller.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---Seller_id dropdown ends----//


        //---Mpn dropdown starts----//
        var mpn = [];
        mpn.push('<option value="all">All</option>');
        for (var i = 0; i < data.mpn.length; i++) {
          mpn.push('<option value="'+data.mpn[i].MPN+'">'+data.mpn[i].MPN_NAME+'</option>');
        }

        $("#mpnDropdown").html("");
        $("#mpnDropdown").append('<label for="MPN">MPN:</label><select class="form-control selectpicker " name="mpn" id="mpn" data-live-search="true">'+mpn.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---Mpn dropdown ends----//

        //---Mpn dropdown starts----//
        var location = [];
        location.push('<option value="all">All</option>');
        for (var i = 0; i < data.locations.length; i++) {
          location.push('<option value="'+data.locations[i].LOCATION_VALUE+'">'+data.locations[i].LOCATION_AME+'</option>');
        }

        $("#locationDropdown").html("");
        $("#locationDropdown").append('<label for="Location">Location:<select class="form-control selectpicker " name="mpn" id="mpn" data-live-search="true">'+location.join("")+'</select>');
        $('.selectpicker').selectpicker();
        //---Mpn dropdown ends----//
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

   });

   // $('#appCat').append(slect);
   // '<?php //$this->session->unset_userdata('Search_category'); ?>'
});

</script>
