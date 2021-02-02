<?php $this->load->view('template/header'); 
ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
     Total Unverified Data
        <small>Control panel</small>
    <ol class="breadcrumb">
      <li>
        <a href="<?php echo base_url();?>dashboard/dashboard">
          <i class="fa fa-dashboard">
          </i> Home
        </a>
      </li>
      <li class="active">Unverified Data
      </li>
    </ol>
  </section>  
  <!-- Main content -->
  <section class="content">
    <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Data</h3>
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
                <form action="<?php echo base_url().'catalogueToCash/c_purchasing/searchUnverifyData/'.$cat_id; ?>" method="post" accept-charset="utf-8">
                <div class="col-sm-3">
                  <div class="form-group" id ="listDropDown">
                    <label for="Search Webhook">Listing Type:</label>
                    <?php ///$this->session->unset_userdata('unverify_List_type'); ?>
                      <?php $ctListingType = $this->session->userdata('unverify_List_type'); ?>
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
                    <?php 
                      $listCondition = $this->session->userdata('unverify_condition'); ?>
                      <select  name="condition[]" id="condition" class="selectpicker form-control" multiple data-live-search="true">
                        <option value="all">All</option>
                        <?php
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
                  <div class="form-group">
                    <label for="Search Webhook">Seller Id:</label>
                    <input type="text" name="seller" class="form-control clear" placeholder="Search Seller" value="<?php echo htmlentities($this->session->userdata('unverify_seller')); ?>" >    
                  </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group" id="sortDropdown">
                        <label for="Search Webhook">Title Sort:</label>
                        <?php
                        $arrstate = array ('1' => 'Shortest To Longest','2' => 'Longest To Shortest'); ?>
                        <select class="form-control selectpicker sortDropdown" name="title_sort" id="title_sort" data-live-search="true">
                        <option value="">All ....</option>
                        <?php
                        foreach($arrstate as $key => $value) {
                        ?>
                        <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('unverify_title_sort') == $key){echo "selected";}?>><?php echo $value; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                </div>
                </div> 
                <div class="col-sm-12">  
                  <div class="col-sm-2">
                    <div class="form-group" id="timeDropdown">
                      <label for="Search Webhook" >From Time:</label>
                      <?php
                      $time = array ('1' => 'Last 24 Hours','2' => 'Last 48 Hours','3' => 'Last 72 Hours'); ?>
                      <select class="form-control selectpicker" name="time_sort" id="time_sort" data-live-search="true">
                        <option value="">All ....</option>
                          <?php
                          foreach($time as $key => $value) {
                          ?>
                          <option value="<?php echo $key; ?>"  <?php if($this->session->userdata('unverify_time_sort') == $key){echo "selected";}?>><?php echo $value; ?></option>
                          <?php
                          }
                          ?>
                      </select>
                  </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <label for="Feedback Score">Feedback Score:</label>
                    <div class="input-group" >
                      <input type="text" name ="fed_one" class="form-control clear" value="<?php echo  $this->session->userdata('unverify_fed_one');?>"  />
                      <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                      <input type="text" name ="fed_two" class="form-control clear" value="<?php echo  $this->session->userdata('unverify_fed_two');?>" />
                    </div>
                </div>
              </div>
              <div class="col-sm-4 ">
                <div class="form-group">
                  <label for="Search Webhook">Search Title:</label>
                  <input type="text" name="search_title" class="form-control clear" placeholder="Search Title" value="<?php echo htmlentities($this->session->userdata('unverify_serchkeyword')); ?>" >    
                </div>
              </div>
              <div class="col-sm-4 p-t-24">
                  <div class="form-group col-sm-2 ">
                    <input type="submit" class="btn btn-primary btn-sm pull-left" name="search_webhook" id="search_webhook" value="Search">
                   </div>
                  <div class="form-group col-sm-2">
                    <button type ="button" class="btn btn-sm btn-warning  " id="reset">Reset Filters</button>
                  </div>
              </div>         
            </div>
        </form>                                                                 
      </div> 
    </div>
    <!-- Title filtering section End -->
    
<!-- Verified title option start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Verify Title</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-sm-12">

                <div class="col-sm-3">
                  <div class="form-group">
                    <label>Select Brand:</label>
                    <select name="brand" id="brand" class="form-control selectpicker" data-live-search="true">
                      <option value="0">Select......</option>
                      <?php foreach($brands as $b_name): ?>
                        <option value="<?php echo $b_name['DET_ID'] ?>"><?php echo $b_name['SPECIFIC_VALUE'] ?></option>
                      <?php endforeach; ?>  
                    </select>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group" id="appendMpnlist">
                    <!-- <label>Select MPN:</label>
                    <select name="verifiedmpn" id="verifiedmpn" class="form-control selectpicker" data-live-search="true"> -->
                      <?php //foreach($master_mpn as $row): ?>
                        <!-- <option value="<?php //echo $row['CATALOGUE_MT_ID'] ?>"><?php //echo $row['MPN'] ?></option> -->
                      <?php //endforeach; ?>  
                    <!-- </select> -->
                  </div>
                </div>
<!--                 <div class="col-sm-3">
                  <div class="form-group" id="cataObject">
                    <label>Select Object:</label>
                    <select name="object" id="object" class="form-control selectpicker" data-live-search="true">
                      <?php //foreach($objects as $obj): ?>
                        <option value="<?php //echo $obj['OBJECT_ID'] ?>"><?php //echo $obj['OBJECT_NAME'] ?></option>}
                      <?php //endforeach; ?>  
                    </select>
                  </div>
                </div> -->
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="button" class="btn btn-success btn-md btn-block" name="verifyTitle" id="verifyTitle" value="Verify">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24">                
                    <a type="button" class="btn btn-primary btn-md btn-block" href="<?php echo base_url().'catalogue/c_itemCatalogue/'; ?>"  target="_blank" >Add MPN</a>
                  </div>
                </div>                
                <!-- Create Object seciton start -->
<!--                 <div class="col-sm-2">
                  <div class="form-group p-t-26">
                    <input type="button" id="add_object" name="add_object" value="New Object" class="btn btn-md btn-primary btn-block">
                  </div>
                </div>
        
                <div class="col-sm-12" id="objectDiv">
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="New Object">New Object Name:</label>
                      <input class="form-control" type="text" name="new_object" id="new_object" value="" required>
                    </div>
                  </div> 
                  <div class="col-sm-2 p-t-26">
                    <div class="form-group">
                      <input type="button" id="create_object" name="create_object" value="Create Object" class="btn btn-md btn-block btn-primary">
                    </div>
                  </div>
                  
                </div> -->
                <!-- Create Object seciton end -->

              </div>
            </div>
          </div>   

<!-- Verified title option end -->

    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <br>     
          <div class="box-body form-scroll"> 
              <div class="col-sm-12">
                <div class="col-sm-6">
                  <h4>Category Name: <?php 
                  echo $cat_descr['cate_name'][0]['CATEGORY_NAME'];
                $cat_id= $this->uri->segment(4);
                  ?></h4>
                </div>          
            </div>    
            <div class="col-md-12">
              <input type="hidden" name="ct_category" value="<?php echo $cat_id; ?>" id="ct_category">
              <!-- Custom Tabs -->
              <table id="unverified-list" class="table table-responsive table-striped table-bordered table-hover">
               <thead>
               
                  <tr>
                    <th>ACTION</th>
                    <th>EBAY ID</th>
                    <th>ITEM DESCRIPTION</th>
                    <th>SELLER ID</th>
                    <th>FEEDBACK SCORE</th>
                    <th>LISTING TYPE</th>
                    
                    <th>CONDITION</th>
                    <th>ACTIVE PRICE</th>
                    
                </tr>
              </thead>
            </table>
          </div><!-- /.col --> 
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div> <!-- /.row -->
 </section><!-- /.content -->
</div><!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
/*=======================================
=            Object creation            =
=======================================*/

//   $("#add_object").on('click',function(){
//     $('#objectDiv').toggle();
//   });
//   $('#objectDiv').hide();

// $("#create_object").on('click',function(){
//   var new_object = $('#new_object').val();
//   var bd_category = $("#ct_category").val();
//   //console.log(bd_category, new_object); return false;
//   if(new_object == ''){
//     alert('please enter a name for object!');
//   }else{
//     $.ajax({
//       url: '<?php //echo base_url(); ?>catalogue/c_itemCatalogue/createObject',
//       dataType:'json',
//       type: 'post',
//       data:{'new_object':new_object, 'bd_category':bd_category},
//       success: function(data){
//         if(data == 1){
//           alert('Success: Object is created!');
//         }else{
//           alert('warning: Object already exists!');
//         }

//         $.ajax({
//           url: '<?php //echo base_url(); ?>catalogue/c_itemCatalogue/getSpecificObjects',
//           dataType:'json',
//           type: 'post',
//           data:{'bd_category':bd_category},
//           success: function(result){
//             var obj = [];
//             for(var i = 0;i<result.length;i++){
//               obj.push('<option value="'+result[i].OBJECT_ID+'">'+result[i].OBJECT_NAME+'</option>');
//             }
//             $("#cataObject").html("");
//             $("#cataObject").append('<label>Select Object:</label> <select name="object" id="object" class="form-control selectpicker" data-live-search="true"> '+obj.join("")+'</select>');
//             $('.selectpicker').selectpicker();
//           }
//         });
//       }
//     });
//   }
// });

/*=====  End of Object creation  ======*/

/*=======================================================================
=            On change of Brand show MPN            =
=======================================================================*/
$("#brand").on('change',function(){
  var ct_category = $("#ct_category").val();
  var det_id = $("#brand").val();

      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_unverified/get_mastermpn',
      data: { 'ct_category' : ct_category, 'det_id':det_id},
     success: function (data) {
        if(data){
            var mpn = [];
            for(var i = 0;i<data.length;i++){
              mpn.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');
            }
            $("#appendMpnlist").html("");
            $("#appendMpnlist").append('<label>Select MPN:</label> <select name="verifiedmpn" id="verifiedmpn" class="form-control selectpicker" data-live-search="true">' + mpn.join("") + '</select>'); 
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

/*=====  End of On change of Brand show MPN  ======*/

/*=======================================================================
=            Onload show mpn cateogires wise            =
=======================================================================*/
$("#verifyTitle").on('click',function(){
  var ct_category = $("#ct_category").val();
  var verifiedmpn = $("#verifiedmpn").val();

  var fields = $("input[name='selectforVerify']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one.'); 
        return false;
      }  

      var selectedCheckbox=[];
      var cata_id_val =[];

      var tableId="unverified-list";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='selectforVerify']:checked"), function()
      {            
        selectedCheckbox.push($(this).val());
        cata_id_val.push($(this).attr("id"));
      });
      //console.log(cata_id_val); return false;
      $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_unverified/verifyMPN',
      data: { 'ct_category' : ct_category, 'verifiedmpn':verifiedmpn, 'selectedCheckbox':selectedCheckbox, 'cata_id_val': cata_id_val              
    },
     success: function (data) {
        if(data){
          alert('Sucess! Selected Title is verified.');
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


    /*///////////////////////////////*/
    var dataTable = $('#unverified-list').DataTable( {  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "aLengthMenu": [25, 50, 100, 200],
       "paging": true,
      // "lengthChange": true,
      "searching": true,
       "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadSearchData/'.$cat_id ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });


    /*=====================================
=            reset filters            =
=====================================*/


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
        // var catData = [];
       // console.log(data);
        // catData.push('<option value="all">All</option>');
        // for (var i = 0; i < data.cattegory.length; i++) {
        //   catData.push('<option value="'+data.cattegory[i].CATEGORY_ID+'">'+data.cattegory[i].CATEGORY_NAME+'</option>');
        // }

        // $("#appCat").html("");
        // $("#appCat").append('<label for="Category">Category Id:</label><select  name="category[]" id="category" class="selectpicker form-control" multiple data-live-search="true">'+catData.join("")+'</select>');
        
        // $('.selectpicker').selectpicker();
        //---Category dropdown ends----//


           //---Flag dropdown starts----//
        // var flag = [];
       // console.log(data);
        // flag.push('<option value="all">All</option>');
        // for (var i = 0; i < data.flag_id.length; i++) {
        //   flag.push('<option value="'+data.flag_id[i].FLAG_ID+'">'+data.flag_id[i].FLAG_NAME+'</option>');
        // }

        // $("#flag_dropdown").html("");
        // $("#flag_dropdown").append('<label for="Flag">Flag Name:</label><select  name="flag[]" id="flag" class="selectpicker form-control" multiple data-live-search="true">'+flag.join("")+'</select>');
        
        // $('.selectpicker').selectpicker();
        //---flag dropdown ends----//

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
        // var seller = [];
        // seller.push('<option value="all">All</option>');
        // for (var i = 0; i < data.seller.length; i++) {
        //   seller.push('<option value="'+data.seller[i].SELLER_ID+'">'+data.seller[i].SELLER_NAME+'</option>');
        // }

        // $("#sellerDropdown").html("");
        // $("#sellerDropdown").append('<label for="Seller Id">Sellr Id:</label><select name="seller[]" id="seller" class="selectpicker form-control" multiple data-live-search="true">'+seller.join("")+'</select>');
        // $('.selectpicker').selectpicker();
        //---Seller_id dropdown ends----//


        //---Mpn dropdown starts----//
        // var mpn = [];
        // mpn.push('<option value="all">All</option>');
        // for (var i = 0; i < data.mpn.length; i++) {
        //   mpn.push('<option value="'+data.mpn[i].MPN+'">'+data.mpn[i].MPN_NAME+'</option>');
        // }

        // $("#mpnDropdown").html("");
        // $("#mpnDropdown").append('<label for="MPN">MPN:</label><select class="form-control selectpicker " name="mpn" id="mpn" data-live-search="true">'+mpn.join("")+'</select>');
        // $('.selectpicker').selectpicker();
        //---Mpn dropdown ends----//

        //---Mpn dropdown starts----//
        // var location = [];
        // location.push('<option value="all">All</option>');
        // for (var i = 0; i < data.locations.length; i++) {
        //   location.push('<option value="'+data.locations[i].LOCATION_VALUE+'">'+data.locations[i].LOCATION_AME+'</option>');
        // }

        // $("#locationDropdown").html("");
        // $("#locationDropdown").append('<label for="Location">Location:<select class="form-control selectpicker " name="mpn" id="mpn" data-live-search="true">'+location.join("")+'</select>');
        // $('.selectpicker').selectpicker();
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

/*=====  End of reset filters  ======*/
    /*///////////////////////////////*/
    /*-- Delete Result Row start --*/
 $("#unverified-list").on('click','.delResultRow', function() {
    //alert(this.id);//return false;
    var id = this.id;
    var ct_category = $("#ct_category").val();
    $.ajax({
        url: '<?php echo base_url() ?>catalogueToCash/c_purchasing/deleteResultRow/'+id, //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data : {'ct_category':ct_category},
        success: function(data){
            if(data == true){
              var row=$("#"+id);
              //var whichtr = $(this).closest("tr");
              //debugger;     
              row.fadeOut(1000, function() {
              row.closest("tr").remove();
              });
             //$('#'+id).remove();
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
/*-- Delete Result Row end --*/
  });
  /*===== Success message auto hide ====*/
  setTimeout(function(){
    $('#successMsg').fadeOut('slow');
  }
             , 5000);
  // <-- time in milliseconds
  setTimeout(function(){
    $('#errorMsg').fadeOut('slow');
  }
             , 5000);
  // <-- time in milliseconds        
  /*===== Success message auto hide ====*/    
</script>