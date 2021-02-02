<?php $this->load->view('template/header');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle ; ?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle ; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">  
          <div class="box box-success" >
          <div class="box" >
                    <div class="box-header">
                      <h3 class="box-title">Search Criteria</h3>
                    </div>
                    <!-- /.box-header -->
                    <?php $get_keywod = $this->session->userdata('get_keywoerd'); ?>
                    <div class="box-body table-responsive no-padding" >
                      <div class="col-sm-3"><!-- total qty -->
                          <label for="Search Keywordr" class="control-label">Search Keyword:</label>
                          <div class="form-group ">
                            <input type="text"  name ="ser_in_mani" id = "ser_in_mani" value="<?php echo $get_keywod ;?>" class="form-control"  >
                          </div>
                      </div> 
                      <div class="col-sm-3">
                      <label for="Search Keywordr" class="control-label">Search in:</label>
                      <?php $serachFilter = $this->session->userdata('serachFilter'); 
                      if(!empty($serachFilter)){
                        if($serachFilter == "Brand"){
                          $brandFilter = "checked=\"checked\"";
                          $bothFilter = "";
                          $descFilter = "";
                        }else if($serachFilter == "Desc"){
                          $descFilter = "checked=\"checked\"";
                          $bothFilter = "";
                          $brandFilter = "";
                        }else{
                          $bothFilter = "checked=\"checked\"";
                          $brandFilter = "";
                          $descFilter = "";
                        }
                      }else{
                        $bothFilter = "checked=\"checked\"";
                        $brandFilter = "";
                        $descFilter = "";
                      }
                      ?>
                        <div class="form-group">
                          <input type="radio" name="serachFilter" id="serachFilter" value="Brand" <?php echo $brandFilter; ?>> Brand Only
                          <input type="radio" name="serachFilter" id="serachFilter" value="Desc" <?php echo $descFilter; ?>> Description Only
                          <input type="radio" name="serachFilter" id="serachFilter" value="Both" <?php echo $bothFilter; ?>> Both
                        </div>
                      </div> 
                      <div class="col-sm-2 p-t-24">
                        <input type="checkbox" name="endToday" id="endToday" title="Search in Ending Today Auctions" value="1"> Ending Today
                      </div> 
                      <div class="col-sm-2 p-t-24">
                        <input type="checkbox" name="endedAuction" id="endedAuction" title="Search in All Ended Auction" value="1"> Ended Auction
                      </div> 
                      <div class="col-sm-1 p-t-24 ">
                        <div class="form-group ">
                        <input type="button" name="serc_key" id="serc_key" value="Search" class="btn btn-primary form-control ">                 
                        </div>
                      </div>

                    </div>
                    <!-- /.box-body -->
                  </div>
            </div> 
        </div>
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $pageTitle ; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <!-- auction table start -->

            <table id="auction_details" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th >Action</th>                   
                    <th >Vendor Auction Id</th>                   
                    <th>Acution Description</th>
                    <th>Conition</th>
                    <th>Time Left</th>
                    <th style =" text-align:center; ">Current Bid</th>
                    <th style =" text-align:center; ">No Of Items</th>
                    <th style =" text-align:center; ">Est Sale</th>
                    <th style =" text-align:center; ">Ebay Fee</th>
                    <th style =" text-align:center; ">Paypal Fee</th>
                    <th style =" text-align:center; ">Ship Fee</th>
                    <th style =" text-align:center; ">Net Amount</th>
                    <th style =" text-align:center; ">Offer On Net Amount</th>
                    <th style =" text-align:center; ">Qty Sold</th>
                    <th style =" text-align:center; ">Sell Through</th>
                    <th style =" text-align:center; ">Watch Count Avg</th>
                    <th style =" text-align:center; ">No of Qty</th>
                    <th style =" text-align:center; ">Insert Date</th>


                  </tr>
                </thead>
                <tbody>
                  <tr>
                    

                  </tr>
                </tbody>
             </table>

            <!-- auction table end -->

            </div>
          </div>
     </div>                    

    </div>
              

</div>
    </section>
    <!-- /.content -->
  


<?php $this->load->view('template/footer');?>

<script >
 
$(document).ready(function(){

var data_table = $('#auction_details').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
     "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
       
       "paging": true,
      "lengthChange": true,
      "searching": true,

      "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      "order": [[ 1, "ASC" ]],
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
        url :"<?php echo base_url().'catalogueToCash/c_tl_auction/load_auction_data' ?>", // json datasource
        type: "post"  
        // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          // Bold the grade for all 'A' grade browsers
          var current_date = $.datepicker.formatDate('dd-M-y', new Date());
          //var current_date = $.datepicker.formatDate('13-AUG-18', new Date());
          //console.log(current_date.toUpperCase(),aData[17]);
            //$('td:eq(4)', nRow).addClass('m-light-green');
            if(aData[17] == current_date.toUpperCase()){
              $(nRow).addClass('m-light-green');
            }
        
      
        }

      });

   
});



$("#serc_key").on('click', function(){
 //$(document).on('click','#serc_key', function(){
  var get_keywoerd = $('#ser_in_mani').val();
  var endToday = $('#endToday').is(":checked");
  var endedAuction = $('#endedAuction').is(":checked");
  var seacrhRadio = $('input[name=serachFilter]:checked').val();
 // var endedAuction = $('input[name=endedAuction]:checked').val();
  
 // console.log(endToday,endedAuction); return false;

  $('#auction_details').DataTable().destroy();
  
 var data_table = $('#auction_details').DataTable( { 
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      
    },
     "iDisplayLength": 500,
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
        url :"<?php echo base_url().'catalogueToCash/c_tl_auction/load_auction_data' ?>", // json datasource
        type: "post",  
        // method  , by default get
         data: {'get_keywoerd':get_keywoerd,'endToday':endToday,'seacrhRadio':seacrhRadio,'endedAuction':endedAuction},
         dataType: 'json'
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
          // Bold the grade for all 'A' grade browsers
          var current_date = $.datepicker.formatDate('dd-M-y', new Date());
          //var current_date = $.datepicker.formatDate('13-AUG-18', new Date());
          //console.log(current_date.toUpperCase(),aData[17]);
            //$('td:eq(4)', nRow).addClass('m-light-green');
            if(aData[17] == current_date.toUpperCase()){
              $(nRow).addClass('m-light-green');
            }
        
      
        }

      });

 });
// $(document).on('click','.view_auc_det', function(){

//   var get_auc_id  = this.id.match(/\d+/);
//       get_auc_id  = parseInt(get_auc_id );
//       alert(get_auc_id);
//       return false;

//     var mtable = $('#update_lot_tab').DataTable();
 
//     mtable.row( $("#"+det_id).parents('tr') ).remove().draw();
  
 
    
//     var obj = [];
//       $.ajax({
//         url:'<?php// echo base_url(); ?>catalogueToCash/c_receiving/get_append_data',
        
//         type:'post',
//         dataType:'json',
//         data:{'det_id':det_id},
//         success:function(data){

//         if(data){
//         $(".loader").hide();
//         $("#post_kit").prop("disabled", false);

//         $('#append_tab').DataTable().destroy();
//         var table = $('#append_tab').DataTable();
//         //table.clear();
         
      
        

        
//        for(var k = 0; k< data.get_lot_estimate.length; k++){
//             var EST_SELL_PRICE = data.get_lot_estimate[k].EST_SELL_PRICE;
//                       if( typeof EST_SELL_PRICE == 'object'){
//                         EST_SELL_PRICE = JSON.stringify(EST_SELL_PRICE);
//                         EST_SELL_PRICE = '';
//                         // alert(dekit);
//                       }
//                       var get_upc = data.get_lot_estimate[k].UPC;
//                       if( typeof get_upc == 'object'){
//                         get_upc = JSON.stringify(get_upc);
//                         get_upc = '';
//                         // alert(dekit);
//                       }
//                        var COND_NAME = data.get_lot_estimate[k].COND_NAME;
//                       if( typeof COND_NAME == 'object'){
//                         COND_NAME = JSON.stringify(COND_NAME);
//                         COND_NAME = '';
//                         // alert(dekit);
//                       } 
//                       var QTY = data.get_lot_estimate[k].QTY;
//                       if( typeof QTY == 'object'){
//                         QTY = JSON.stringify(QTY);
//                         QTY = '';
//                         // alert(dekit);
//                       } 

//               var tds='<tr><td>'+data.get_lot_estimate[k].OBJECT_NAME+'</td><td>'+data.get_lot_estimate[k].MPN+'</td><td>'+data.get_lot_estimate[k].MPN_DESCRIPTION+'</td><td>'+get_upc+'</td><td>'+COND_NAME+'</td> <td>'+QTY+'</td> <td>'+data.get_lot_estimate[k].SOLD_PRICE+'</td><td>'+EST_SELL_PRICE+'</td><td>'+data.get_lot_estimate[k].EBAY_FEE+'</td><td>'+data.get_lot_estimate[k].PAYPAL_FEE+'</td> <td>'+data.get_lot_estimate[k].SHIPPING_FEE+'</td></tr>';
               
                
//            }
//            table.row.add($(tds)).draw();
//            }else{
//             $(".loader").hide();
//            }
//       }
//       }); 
//       //i++;        
// });// function on add button for append new field for input end 


</script>