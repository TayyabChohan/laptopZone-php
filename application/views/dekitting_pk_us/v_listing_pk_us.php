<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"><!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    US-PK Listed Items
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">De-Kited Listed Items</li>
  </ol>
</section><!-- Main content -->
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
      <div class="row">
      <div class="col-sm-12">
      <!-- <form action="<?php ///echo base_url(); ?>dekitting_pk_us/c_listing_pk_us/load_non_listing" method="post"> -->
         <div class="col-sm-3">
          <div class="form-group">
          <label for="Search by Group">Search by Group:</label>&nbsp;&nbsp;&nbsp;
          <?php $searchedLocation =  $this->session->userdata('list_location'); ?>
            <input type="radio" name="listing_location" value="PK" <?php if($searchedLocation == 'PK' || $searchedLocation == ''){echo 'checked';} ?>>&nbsp;Pak Lister
            <input type="radio" name="listing_location" value="US" <?php if($searchedLocation == 'US'){echo 'checked';} ?>>&nbsp;US Lister
            <input type="radio" name="listing_location" value="ALL" <?php if($searchedLocation == 'ALL'){echo 'checked';} ?>>&nbsp;All
          </div> 
        </div>
        
       <?php $checked = $this->session->userdata('listing_type'); ?>
        <div class="col-sm-3">
          <input type="radio" name="listing_options" value="1" <?php if($checked == 1){ echo 'checked'; } ?>>&nbsp;Dekitted Items
          <input type="radio" name="listing_options" value="2" <?php if($checked == 2){ echo 'checked'; } ?>>&nbsp; Specilal Lots
          <input type="radio" name="listing_options" value="0" <?php if($checked == 0){ echo 'checked'; } ?>>&nbsp;All   
        </div>
        <!-- <div class="col-sm-1">
          <div class="form-group">
            <input type="button" class="btn btn-primary btn-sm" name="search_listings" id="search_listings" value="Search">
          </div>
        </div> -->
        <div class="col-sm-1">
          <div class="form-group">
            <input type="submit" class="btn btn-primary btn-sm" name="lister_search" id="lister_search" value="Search">
          </div>
        </div>

        <div class="col-sm-2 pull-right">
          <div class="form-group">
            <a target="_blank" href="<?php echo base_url().'dekitting_pk_us/c_listing_pk_us'?>">Non Listed Items</a>
          </div>
        </div>
       <!--  </form> -->
      </div>
      </div>   
      </div>
    </div>  
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Dekit -Listed Items</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>              
      </div>      
      <div class="box-body form-scroll">      
        <div class="col-sm-12">
         <table id="dekittedListedItems" class="table table-bordered table-striped " >
            <thead>
            <tr>
              <th>ACTION</th>
              <th>EBAY ID</th>
              <th>BARCODE</th>
              <th>CONDITION</th>
              <th>TITLE</th>
              <th>LIST QTY</th>
              <th>LIST PRICE</th>
              <!-- <th>PURCH REF NO</th>
              <th>UPC</th> -->
              <th>MPN</th>
              <th>MANUFACTURE</th>
              <!-- <th>SHIPPING SERVICE</th> -->
              <th>LISTER NAME</th>
              <th>LISTING TIME &amp; DATE</th>
              <th>BIN NAME</th>
              <th>ACCOUNT</th>
              <th>STATUS</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          </div>    
        </div> 
        </div>
      </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
</div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
  $(document).ready(function(){

   $("#dekittedListedItems").dataTable().fnDestroy();
   $("#dekittedListedItems").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    //"aaSorting": [[11,'desc'],[10,'desc']],
    //"order": [[ 10, "desc" ]],
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 25,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
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
      url :"<?php echo base_url().'dekitting_pk_us/c_listing_pk_us/loadListedData' ?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      //data: {},
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
 
   ////////////////////////////////////////
  });
    /////////////////////////////////////////
   $("#lister_search").on('click', function(){
    ///alert("zxcxzczxcc");
    var listing_location      = $("input[name='listing_location']:checked").val();
    var listing_type          = $("input[name='listing_options']:checked").val();
    //console.log(listing_location); return false;
     $("#dekittedListedItems").dataTable().fnDestroy();
     $("#dekittedListedItems").DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
      },
      //"aaSorting": [[11,'desc'],[10,'desc']],
      //"order": [[ 10, "desc" ]],
      "fixedHeader": true,
      "paging": true,
      "iDisplayLength": 25,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
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
        url :"<?php echo base_url().'dekitting_pk_us/c_listing_pk_us/loadListedData' ?>", // json datasource
        type: "post" , // method  , by default get
        dataType: 'json',
        data: {"listing_location":listing_location, "listing_type":listing_type },
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]      
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
 /* $('#dekittedListedItems thead th').eq(14).each(function () {
      var title = $(this).text();
        //if (g >2 && g!=4 && g!=6 && g!=7 && g!=8 && g!=9 && g!=14) {
         // if(i == 11 ){
              $(this).html('<input type="text" class="form-control" placeholder="'+title+'" style="width:130px;"/>');
          // }
      //}
      //g++;
  });*/

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
 </script>
