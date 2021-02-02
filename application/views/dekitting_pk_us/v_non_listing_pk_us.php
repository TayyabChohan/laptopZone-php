<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        US-PK Non Listed Items
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">De-Kited Non Listed Items</li>
      </ol>
    </section> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
            <div class="box-body">
              <div class="col-sm-12">
                <div class="col-sm-3">
                <div class="form-group">
                <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/pic_view" target="_blank">Pic Approval</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;   |&nbsp;&nbsp;&nbsp;&nbsp;  
                <a style="text-decoration: underline;" href="<?php echo base_url();?>dekitting_pk_us/c_dekit_audit/dekitAudit" target="_blank">Dekit Audit</a>    
                </div>
              </div>
              <?php $checked = $this->session->userdata('listing_options'); ?>
                <div class="col-sm-3">
                  <input type="radio" name="listing_options" value="1" <?php if($checked == 1){ echo 'checked'; } ?>>&nbsp;Dekitted Items
                  <input type="radio" name="listing_options" value="2" <?php if($checked == 2){ echo 'checked'; } ?>>&nbsp; Specilal Lots
                  <input type="radio" name="listing_options" value="3" <?php if($checked == 3){ echo 'checked'; } ?>>&nbsp; Ended Items
                 
                  <input type="radio" name="listing_options" value="0" <?php if($checked == 0){ echo 'checked'; } ?>>&nbsp;All   
                </div>

               
                
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="button" class="btn btn-primary btn-sm" name="search_listings" id="search_listings" value="Search">
                  </div>
                </div>
               
                  
                <div class="col-sm-2 pull-right">
                  <div class="form-group">
                    <a target="_blank" href="<?php echo base_url().'dekitting_pk_us/c_listing_pk_us/listedData'?>">Listed Items</a>
                  </div>
                </div>

                <?php $emp_id =   $this->session->userdata('user_id');?>

              
                <div class="col-sm-12">
                   

                 <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Special Lot" class="control-label">Select Employee:</label>
                     <div class="form-group" id ="apnd_obj">                   
                    <select class=" selectpicker form-control get_emp"  data-live-search ="true" id="get_emp" name="get_emp" >

                      <option value = "">Select Employee</option>

                      <?php                     

                      foreach ($data['qyer'] as $data_qyer) {                        
                      ?>
                          <option value="<?php echo $data_qyer['EMPLOYEE_ID']; ?>" ><?php echo $data_qyer['USER_NAME']; ?></option>
                      <?php 
                        }
                      ?>
                    </select>
                    </div> 
                  </div>
                </div>
                 <?php  if($emp_id == 21 || $emp_id == 22){?>
                <div class="col-sm-2 p-t-24  ">
                  <div class="form-group">
                    <input type="button" class="btn btn-success  asi_pk" name="asi_pk" id="asi_pk" value="Assign">
                  </div>
                </div>

                <?php }?>
                </div>


              </div>
              
            </div>
        </div>  
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Dekit - Not Listed Items</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>              
          </div>      
        <div class="box-body form-scroll">      
        <div class="col-md-12">
          <!-- Custom Tabs -->
               <table id="catToCash_notListed" class="table table-bordered table-striped " >
                  <thead>
                    <tr>
                      <th>SELECT</th>
                      <th>ACTION</th>
                      <th>SELLER NAME</th>
                      <th>VERIFY BY</th>
                      <th>OTHER NOTES</th>
                      <th>PICTURE</th>
                      <th style="width: 80px;">BARCODE</th>
                      <th>Object Name</th>
                      <th>CONDITION</th>
                      <th style="width: 170px;">TITLE</th>                      
                      <th>QTY</th>                                       
                      <th>MPN</th>
                      <th>MANUFACTURE</th>
                      <!-- <th>SHIPPING SERVICE</th> -->
                      <th>BIN NAME</th>
                      <th>DAYS</th>
                      <th>ASSIGN TO</th>
                     
                    </tr>
                  </thead>
                  <tbody>      
                  </tbody>
                </table><br>
              </div>
              </div><!-- /.col --> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 170px; height: 170px;">
    </div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>

   $(document).on('click','.del_itm',function(){
    $(".loader").hide();
    var bar =$(this).attr('id');

    $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>dekitting_pk_us/c_listing_pk_us/del_dekit_item',
    data: {'bar':bar},
   success: function (data) {
    $(".loader").hide();
    //console.log(data);
    if(data == 1){

      var mtable = $('#catToCash_notListed').DataTable(); 

      mtable.row( $("#"+bar).parents('tr') ).remove().draw();

      alert('Barcode Moved To Component idenitfication screen');
      return false;
      
   }else if(data == 2){

    var mtable = $('#catToCash_notListed').DataTable(); 

      mtable.row( $("#"+bar).parents('tr') ).remove().draw();
      
    alert('Barcode Moved To special lot unpost item');
      return false;
   }else if(data == 3){

    alert('barcode is listed;');
      return false;
   }
    }
  });
 

 });
$(document).on('click','.flag-discard',function(){
    $(".loader").show();
    var bar =$(this).attr('dBarcode');
    //console.log(bar);return false;

    $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>dekitting_pk_us/c_listing_pk_us/discardBarcode',
    data: {'bar':bar},
   success: function (data) {
    $(".loader").hide();
    //console.log(data);
        if(data == 1){

          //var mtable = $('#catToCash_notListed').DataTable(); 

         // mtable.row( $("#"+bar).parents('tr') ).remove().draw();

          var row=$("#"+bar);
                row.closest('tr').fadeOut(1000, function() {
                row.closest('tr').remove();
                //$('#catToCash_notListed').DataTable().draw();
                });

          //alert('Barcode Moved To Component idenitfication screen');
          return false;
          
       }else{

          
        alert('Some error occur. Try Again.');
          return false;
       }
    }
  });
 

 });

  $(document).ready(function(){
  var listing_options = ''; 
   listing_options = $("input[name='listing_options']:checked").val();
   $("#catToCash_notListed").dataTable().fnDestroy();
   $("#catToCash_notListed").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    //"aaSorting": [[11,'desc'],[10,'desc']],
    //"order": [[ 10, "desc" ]],
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 200,
    "aLengthMenu": [[25, 50, 100, 200,300,1000], [25, 50, 100, 200,300,1000]],
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    //"autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": true,
      "ajax":{
      url :"<?php echo base_url().'dekitting_pk_us/c_listing_pk_us/loadNonListData'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {'listing_options':listing_options},
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
//////////////////////////////

var listing_options = '';
$(document).on('click', '#search_listings', function(){
  listing_options = $("input[name='listing_options']:checked").val();
  var get_emp = $("#get_emp").val();
  $("#catToCash_notListed").dataTable().fnDestroy();
   $("#catToCash_notListed").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    //"aaSorting": [[11,'desc'],[10,'desc']],
    //"order": [[ 10, "desc" ]],
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 200,
    "aLengthMenu": [[25, 50, 100, 200,300,1000], [25, 50, 100, 200,300,1000]],
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    //"autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": true,
      "ajax":{
      url :"<?php echo base_url().'dekitting_pk_us/c_listing_pk_us/loadNonListData'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {'listing_options':listing_options,'get_emp':get_emp},
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
/////////////////////////////
});




  });
/*=======Not Listed Items Datatable start===========*/
  /*  $('#catToCash_notListed thead th').eq(11).each(function () {
        var title = $(this).text();
          //if (g >2 && g!=4 && g!=6 && g!=7 && g!=8 && g!=9 && g!=14) {
           // if(i == 11 ){
                $(this).html('<input type="text" class="form-control" placeholder="'+title+'" style="width:130px;"/>');
            // }
        //}
        //g++;
    });*/

  $('#catToCash_notListed').DataTable({
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
  


 var table = $('#catToCash_notListed').DataTable();
    table.columns().every(function () {
        var that = this;
        $('input', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });
/*=======Not Listed Datatable End===========*/

/*=======Listed Items Datatable start===========*/
  /*$('#dekittedListedItems thead th').eq(14).each(function () {
      var title = $(this).text();
        //if (g >2 && g!=4 && g!=6 && g!=7 && g!=8 && g!=9 && g!=14) {
         // if(i == 11 ){
              $(this).html('<input type="text" class="form-control" placeholder="'+title+'" style="width:130px;"/>');
          // }
      //}
      //g++;
  });*/

  $('#dekittedListedItems').DataTable({
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

 var table = $('#dekittedListedItems').DataTable();
    table.columns().every(function () {
        var that = this;
        $('input', this.header()).on('keyup change', function () {
            if (that.search() !== this.value) {
                that.search(this.value).draw();
            }
        });
    });

/*=======Listed Items Datatable start===========*/

/*================================================
    =            Approval for Listing            =
================================================*/



    $("#approval_btn").click(function () {
    
  var approval = [];
  $.each($("input[name='approval[]']:checked"), function(){            
   approval.push($(this).val());
  });    
    
  if(approval.length == 0){
    alert('Please select atleast one.');return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tolist/c_tolist/approvalForListing',
      data: { 'approval':approval           
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Selected items Approved for Listing.');
          window.location.reload();
          
        }else if(data == false){
          alert('Error - Selected items Approved for Listing.');
          //window.location.reload();
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

/*=====  End of Approval for Listing  ======*/   
  $(".shipping_service").on('change', function(){
      //alert("fdsdsfg"); 
  var ship_service = $(this).val();
  var seed_id = $(this).attr("id");
  //console.log(ship_service, seed_id); return false;
  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>catalogueToCash/c_listing/updateShip',
    data: {'ship_service':ship_service,'seed_id':seed_id},
   success: function (data) {
    //console.log(data);
    if(data == 1){
      alert('Success: Shipping service is updated!');
      return false;
      
   }else{
    alert('Error: Shipping service updation Failed');
      return false;
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


  $(document).on('click','.asi_pk',function(){

  var assign_listing = [];
  $.each($("input[name='assign_listing_pk[]']:checked"), function(){            
   assign_listing.push($(this).val());
  });

  var get_emp = $('#get_emp').val();


  if( assign_listing.length !=0  && get_emp != '' ){
    //return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>ListingAllocation/c_ListingAllocation/asign_dkit_list',
      data: { 'assign_listing':assign_listing,'get_emp':get_emp   },

     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Listing is assigned .');
          window.location.reload();
        }else if(data == false){
          alert('Error - Listing is not assigned .');
          //window.location.reload();
        }
      }
      }); 
 // alert(assign_listing);return false;  
  } else{

    alert('select any item and assign person!');
    return false;

   }  
});
 </script>
