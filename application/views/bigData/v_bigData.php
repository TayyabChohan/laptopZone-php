<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        eBay Category Data
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">eBay Category Data</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="box">      
            <div class="box-body form-scroll"> 
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
<!--             <div class="col-sm-12">
              <div class="col-sm-2">
                <div class="form-group">
                  <a title="Add Category Data" class="btn btn-primary btn-sm" href="<?php //echo base_url(); ?>bigData/c_bigData/addCategoryData" target="_blank">Add Category Data</a>
                </div>
              </div>

             
            </div>  -->
 
              <div class="col-md-12">
              <input type="hidden" name="cat_id" value="<?php echo $this->uri->segment(4) ?>" id="cat_id">
              <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <div class="tab-content">
                    <table id="categoryData" class="table table-bordered table-striped " >
                      <thead>
                        <th>ACTION</th>
                        <th>CATEGORY NAME</th>
                        <th>CATEGORY ID</th>
                        <th>EBAY ID</th>
                        <th>TITLE</th>
                        <th>CONDITION</th>
                        <th>SELLER</th>
                        <th>BIN/AUCTION</th>
                        <th>PRICE</th>
                        <th>START DATE </th>
                        <th>END DATE</th>
                        <th>SELER FEEDBACK</th>
                      </thead>
                     
                    </table>

                </div><!-- /.tab-content -->       
              </div><!-- nav-tabs-custom -->

              <div class="col-sm-2 pull-left">
                <div class="form-group ">
                  <button type="button" title="Delete Records" id="delete_records" onclick="return confirm('Are you sure?');" class="btn btn-primary btn-sm">Delete</button>

                  <a title="Go Back" href="<?php echo base_url();?>bigData/c_bigData/"  class="btn btn-primary btn-sm">Back</a>  
                </div>
              </div>                     
            </div><!-- /.col -->

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
 <script type="text/javascript">

   $(document).ready(function(){
    // $('#categoryData').DataTable({
    //   "oLanguage": {
    //   "sInfo": "Total Records: _TOTAL_"
    // },
    // "iDisplayLength": 50,
    //   "paging": true,
    //   "lengthChange": true,
    //   "searching": true,
    //   "ordering": true,
    //   //"order": [[ 8, "desc" ]],
    //   // "order": [[ 16, "ASC" ]],
    //   "info": true,
    //   "autoWidth": true,
    //   "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    // });

 /*============================================
=            dataTable test start            =
============================================*/
 var category_id = $('#cat_id').val();
//alert(category_id);//return false;
    var dataTable = $('#categoryData').DataTable( {
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 100,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "processing": true,
      "serverSide": true,
      "ajax":{
        url :"<?php echo base_url() ?>bigData/c_bigData/load_data", // json datasource
        type: "post",  // method  , by default get
        data: {'category_id' : category_id},
        error: function(){  // error handling
          $(".categoryData-error").html("");
          $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
          $("#categoryData_processing").css("display","none");
          
        }
      }
    } );

// $('#categoryData').DataTable( {
//         serverSide: true,
//         ordering: false,
//         searching: false,
//         ajax: function ( data, callback, settings ) {
//             var out = [];
 
//             for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
//                 out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5',i+'-6', i+'-7', i+'-8', i+'-9', i+'-10', i+'-11', i+'-12',, i+'-13' ] );
//             }
 
//             setTimeout( function () {
//                 callback( {
//                     draw: data.draw,
//                     data: out,
//                     recordsTotal: 160421,
//                     recordsFiltered: 160421
//                 } );
//             }, 50 );
//         },
//         scrollY: 600,
//         scroller: {
//             loadingIndicator: true
//         }
//     } );


/*=====  End of dataTable test start  ======*/




/*******************************
* FOR SAVING UPC AND MPN
********************************/
// $(".saveWebhookData").click(function(){
//     //this.disabled = true;  
//   var fields = $("input[name='wehookComponents']").serializeArray(); 
//     if (fields.length === 0) 
//     { 
//         alert('Please Select at least one Component'); 
//         // cancel submit
//         return false;
//     }  
//   var arr=[];
//   var url='<?php //echo base_url() ?>BundleKit/c_bk_webhook/save_upc_mpn';
//   var count=$("#countRows").val();
//   //console.log(count); return false;
//   var webhook_id=$("#webhook_id").val();
//   var ebay_id=[];
//   var mpn=[];
//   var upc=[];
//   var manufacturer=[];
//   var item_qty=[];
//   var tableId="webhookTable";
//   var tdbk = document.getElementById(tableId);
//   $.each($("#"+tableId+" input[name='wehookComponents']:checked"), function()
//   {            
//     arr.push($(this).val());
//   }
//   );
//   //console.log(arr[0]); return false;
//    for (var i =0; i < arr.length; i++)
//       {
//         ebay_id.push($("#ebayId_"+arr[i]).text());
//         //upc.push($("#webhook_upc_"+arr[i]).val());
//         if ($("#webhook_upc_"+arr[i]).val()=='') {
//           upc.push(null); 
//         }else {
//           upc.push($("#webhook_upc_"+arr[i]).val());
//         }
//         //mpn.push($("#webhook_mpn_"+arr[i]).val());
//         if ($("#webhook_mpn_"+arr[i]).val()=='') {
//           mpn.push(null); 
//         }else {
//           mpn.push($("#webhook_mpn_"+arr[i]).val());
//         }      
        
//         if ($("#wh_manufacturer_"+arr[i]).val()=='') {
//           manufacturer.push(null); 
//         }else {
//           manufacturer.push($("#wh_manufacturer_"+arr[i]).val());
//         }                                   
                                          
//         //item_qty.push($("#wh_item_qty_"+arr[i]).val());  
//         if ($("#wh_item_qty_"+arr[i]).val()=='') {
//           item_qty.push(null); 
//         }else {
//           item_qty.push($("#wh_item_qty_"+arr[i]).val());
//         }                                 
//       } 
// //console.log(upc); return false;
//   $.ajax({
//     url:url,
//     type: 'POST',
//     data:{
//       'webhook_id': webhook_id,
//       'ebay_id': ebay_id,
//       'mpn': mpn,
//       'manufacturer': manufacturer,
//       'item_qty': item_qty,
//       'upc': upc
//     },
//     dataType: 'json',
//     success: function (data) {
//          if(data != ''){
//            window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bk_webhook/getAllWebhooks';
//                //alert("data is inserted");    
//          }else{
//            alert('Error: Fail to insert data');
//          }
//        }
//   });
// });
   });
 </script>