<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seed &amp; Listing
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Seed &amp; Listing</li>
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
            <?php //var_dump(@$data['listed_barcode']);exit;?>
            <div class="box-body">
              <form action="<?php echo base_url(); ?>tolist/c_tolist/lister_view" method="post" accept-charset="utf-8">
                <div class="col-sm-7">
                    <div class="form-group">
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="purchase_no" id="purchase_no" value="<?php //if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>" placeholder="Enter Purchase Ref No / Manifest Id">
                    </div>                                     
                </div> 
                  <div class="col-sm-2">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/pic_view" target="_blank">Pic Approval</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;   |&nbsp;&nbsp;&nbsp;&nbsp;  
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/listedItemsAudit" target="_blank">Listed Items Audit</a>    
                    </div>
                  </div>                                                    
              </form>
            </div>
        </div>  
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Not Listed Items</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>              
          </div>              
          <div class="box-body form-scroll">
            <div class="col-sm-12">
              <div class="form-group">
                
                <a class="pull-right btn btn-primary btn-md" href="<?php echo base_url();?>listing/listing_search/search_item" title="Click to Search Listed Items Barcode" target="_blank">     Search Listed Item Barcode</a>
                <a class="pull-left btn btn-success btn-md asi_pk"  title="Assign to pk listers" target="_blank">Assign to Pk Listers </a> 
                <a class="pull-left btn btn-danger btn-md unasi_pk"  title="Assign to pk listers" target="_blank">  UnAssign Items </a> 
              </div>
            </div>      
            <div class="col-md-12">
              <table id="notListed" class="table table-bordered table-striped" >
                <thead>
                    <th>SELECT</th>
                    <th>ACTION</th>
                    <th>ASSIGNED TO</th>
                    <th>OTHER NOTES</th>
                    <th>PICTURE</th>
                    <th>BARCODE</th>
                    <th>CONDITION</th>
                    <th>TITLE</th>
                    <th>AVAILABLE QTY</th>
                    <th>PURCH REF NO</th>
                    <th>UPC</th>
                    <th>MPN</th>
                    <th>MANUFACTURE</th>
                    <th>BIN NAME</th>
                    <th>BIN ID</th>
                    <th>DAYS ON SHELF</th>
                </thead>
                <tbody>             
              </tbody>
            </table><br>

          </div>
          <!-- /.col --> 

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
/*================================================
    =            Approval for Listing            =
================================================*/
$(document).ready(function(){
  $("#notListed").dataTable().fnDestroy();

    // var i = 0;
    // $('#notListed thead th').eq(11).each(function () {
    //     var title = $(this).text();
    //       //if (g >2 && g!=4 && g!=6 && g!=7 && g!=8 && g!=9 && g!=14) {
    //        // if(i == 11 ){
    //             $(this).html('<input type="text" class="form-control" placeholder="'+title+'" style="width:130px;"/>');
    //         // }
    //     //}
    //     //g++;
    // });
    // $('#notListed thead th').eq(12).each(function () {
    //     var title = $(this).text();
    //       //if (g >2 && g!=4 && g!=6 && g!=7 && g!=8 && g!=9 && g!=14) {
    //        // if(i == 11 ){
    //             $(this).html('<input type="text" class="form-control" placeholder="'+title+'" style="width:130px;"/>');
    //         // }
    //     //}
    //     //g++;
    // });    
  ////////////////////////////////
    //var table = $("#notListed").DataTable({});
    $("#notListed").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    //"aaSorting": [[11,'desc'],[10,'desc']],
    //"order": [[ 10, "desc" ]],
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 200,
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
      url :"<?php echo base_url().'tolist/c_tolist/load_lister_view'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      //data: {},
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]  ,
      "rowCallback": function( row, data, dataIndex){
            if(data){
                $(row).find(".verifi").closest( "tr" ).addClass('verifiedTr');
                
                }
              }    
  });


    /////////////////////////////////
     //var table = $('#notListed').DataTable();
        // table.columns().every(function () {
        //     var that = this;
        //     $('input', this.header()).on('keyup change', function () {
        //         if (that.search() !== this.value) {
        //             that.search(this.value).draw();
        //         }
        //     });
        // });
    /////////////////////////////////

});






$(document).on('click','.asi_pk',function(){

  var assign_listing = [];
  $.each($("input[name='assign_listing_pk[]']:checked"), function(){            
   assign_listing.push($(this).val());
  });

  if(assign_listing.length ==0){
    alert('Select Any Item');
    return false;

  }else{
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>ListingAllocation/c_ListingAllocation/AssignListing_pk',
      data: { 'assign_listing':assign_listing

    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Listing is assigned to PK user.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Listing is not assigned to PK user.');
          //window.location.reload();
        }
      }
      }); 
 // alert(assign_listing);return false;  
  }     

});

$(document).on('click','.unasi_pk',function(){

  var assign_listing = [];
  $.each($("input[name='assign_listing_pk[]']:checked"), function(){            
   assign_listing.push($(this).val());
  });

  if(assign_listing.length ==0){
    alert('Select Any Item');
    return false;

  }else{
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>ListingAllocation/c_ListingAllocation/unAssignListing_pk',
      data: { 'assign_listing':assign_listing

    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Listing is Unassigned .');
          window.location.reload();
        }else if(data == false){
          alert('Error - Listing is not unassigned to PK user.');
          //window.location.reload();
        }
      }
      }); 
 // alert(assign_listing);return false;  
  }     

});














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
      }
      });  

});

/*=====  End of Approval for Listing  ======*/   
 </script>