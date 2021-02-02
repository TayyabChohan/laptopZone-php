<?php $this->load->view('template/header'); 
  ini_set('memory_limit', '-1'); 
?>
<html>
<style type="text/css">
  a:hover{cursor: pointer;}
</style>
<head>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Kit Analysis
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Kit Analysis</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
    <!-- Master Barcode Search Box section Start -->
      <div class="row">
      <div class="col-sm-12">
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
          <div class="box-body"> 
          	<div class="col-sm-12">
          		<div class="col-sm-2">
          			<div class="form-group">
          				<label class="">All Kits: </label>
          				<input type="radio" name="allKits" id="allKits"  value="10" style="margin-left: 10px;">
          			</div>
          			
          		</div>
          		<div class="col-sm-2">
          			<div class="form-group">
          				<label class="">Verified Kits: </label>
          				<input type="radio" name="allKits" id="verifiedKits" value="20" style="margin-left: 10px;">
          			</div>
          			
          		</div>
          		<div class="col-sm-2">
          			<div class="form-group">
          				<label class="">Unverified Kits: </label>
          				<input type="radio" name="allKits" id="unVerifiedKits" value="30" style="margin-left: 10px;">
          			</div>
          			
          		</div>
          		<div class="col-sm-2">
          			<div class="form-group">
          			<button class="btn btn-primary btn-sm" id="searchKits">Search</button>
          			</div>	
          		</div>
          	</div>
      </div>
      </div>
       <!-- Master Barcode Search Box section End --> 
        <!-- Barcode Detail Table Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Kit Analysis</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <!-- Print Message -->
             <!--  <div class="col-sm-12">
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
              </div> -->
              <!-- End Print Message -->
              <div class="box-body form-scroll"> 
              <div class="col-md-12"><!-- Custom Tabs --> 
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_2" data-toggle="tab" id="secondTab">All Kits</a></li>
                  <li><a href="#tab_1" id="firstTab" data-toggle="tab">Non Kits</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane <?php //if(@$activeTab == 'Not Listed'){echo 'active';}?>" id="tab_1">
                    <table id="dekit_pk_us" class="table table-responsive table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>Master MPN</th>
                        <th>MPN Description</th>
                        <th>Category ID</th>
                      </tr>
                    </thead>
                  <tbody id="table_body">
                  </tbody>
                </table>              
              </div>
              </div>
                
               <div class="tab-content">
                  <div class="tab-pane <?php //if(@$activeTab == 'Not Listed'){echo 'active';}?>" id="tab_2">
                    <table id="non_picture" class="table table-responsive table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Master MPN</th>
                        <th>MPN Descrition</th>
                        <th>Components</th>
                        <th>Kit Price</th>
                        <th style="width:80px !important;">Kit Date</th>
                      </tr>
                    </thead>
                    <tbody id="table_body1">
                    
                    </tbody>
                </table>              
              </div>
              </div><!-- nav-tabs-custom -->
              </div>
              </div><!-- /.col --> 
                </div>
              
            </div>
          <!-- Barcode Detail Table End  -->
        <!-- /.col -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    </div>
    </div>
  </section>
  <!-- Modal -->
<div id="show_detail" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Components</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">Components Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body form-scroll">
                          <div class="col-sm-12">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label style="color: black;">Master MPN</label>
                                <input type="text" name="kit_master_mpn" id="kit_master_mpn" class="form-control" readonly="readonly">
                              </div>
                            </div>
                            <div class="col-sm-7">
                              <div class="form-group">
                                <label style="color: black;">MPN Description</label>
                                <input type="text" name="kit_master_mpn_desc" id="kit_master_mpn_desc" class="form-control" readonly="readonly">
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <label style="color: black;">Kit Avg Price</label>
                                <input type="text" name="kit_avg_price" id="kit_avg_price" class="form-control" readonly="readonly">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <form>
                            <table id="estimate_detail_table" class="table table-responsive table-striped table-bordered table-hover ">
                              <thead>
                                <th style="color: black;">COMPONENT</th>
                                <th style="color: black;">MPN</th>
                                <th style="color: black;">MPN DESCRIPTION</th>
                                <th style="color: black;">CATEGORY</th>
                                <th style="color: black;">AVG PRICE</th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
  </div><!-- /.content -->
</div>       
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<script>
var dataTable = '';
var tableData = '';

function reload(){

    if(tableData != ''){
      tableData = tableData.destroy();
    }

      tableData = $('#dekit_pk_us').DataTable({
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
        // "ordering": true,
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
        "bAutoWidth": false,

        "ajax":{
          url: '<?php echo base_url();?>catalogueToCash/c_kit_analysis/loadNonKits', 
          type: 'post',
          dataType: 'json',
          // success:function(data){}
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });

  if(dataTable != ''){
        dataTable = dataTable.destroy();
       }
    dataTable = $('#non_picture').DataTable({
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
        // "ordering": true,
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
        "bAutoWidth": false,

        "ajax":{
          url: '<?php echo base_url();?>catalogueToCash/c_kit_analysis/loadkits', 
          type: 'post',
          dataType: 'json',
          data:{'search_val':10}
          // success:function(data){}
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });

}

$(document).ready(function(){
  //$('#barcode_prv').focus();
  //$('#addPicsBox').hide();
  $('#addbarcodePic').prop('disabled',true);
  $('#tab_1').hide();
  $('#tab_2').show();
  reload();

});


$('#firstTab').on('click',function(){
  $('#tab_1').show();
  $('#tab_2').hide();
});

$('#secondTab').on('click',function(){
  $('#tab_1').hide();
  $('#tab_2').show();
});
/*===================================
=            dele master            =
===================================*/
$(document).on('click', "#searchKits", function(){
	$('#secondTab').trigger('click');
	var search_val = $("input[name = 'allKits']:checked").val();
    if(tableData != ''){
      tableData = tableData.destroy();
    }

      tableData = $('#dekit_pk_us').DataTable({
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
        // "ordering": true,
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
        "bAutoWidth": false,

        "ajax":{
          url: '<?php echo base_url();?>catalogueToCash/c_kit_analysis/loadNonKits', 
          type: 'post',
          dataType: 'json',
          // success:function(data){}
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });

      if(dataTable != ''){
        dataTable = dataTable.destroy();
        // $('#non_picture').DataTable().fnDestroy();
        // $('#non_picture').ajax.reload();
       }

    dataTable = $('#non_picture').DataTable({
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
        // "ordering": true,
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
        "bAutoWidth": false,

        "ajax":{
          url: '<?php echo base_url();?>catalogueToCash/c_kit_analysis/loadkits', 
          type: 'post',
          dataType: 'json',
          data:{'search_val':search_val}
          // success:function(data){}
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
});
/*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
$(document).on('click','.show_comps',function(){
  var row_id                = $(this).attr("rd");
  var count_id              = $(this).attr("id");
  var catalogue_mt_id       = $(this).attr("mpn");
  var master_mpns           = $('#'+count_id).closest('tr').find('td').eq(0).text();
  var mpn_descs             = $('#'+count_id).closest('tr').find('td').eq(1).text();
  var kit_avg_prices        = $('#'+count_id).closest('tr').find('td').eq(3).text();
  //console.log(row_id, master_mpns, mpn_descs, mpn_descs); return false; 
  //return false;
  $(".loader").show();
  var tab= $('#estimate_detail_table').DataTable();
  tab.clear();
  tab.destroy();
    $.ajax({
        url: '<?php echo base_url(); ?>catalogueToCash/c_kit_analysis/show_components', 
        type: 'post',
        dataType: 'json',
        data : {'catalogue_mt_id':catalogue_mt_id},
        success:function(data){
          console.log(data); 
          //return false;
          $('#show_detail').modal('show');
              
             $("#kit_master_mpn").val(master_mpns);
             $("#kit_master_mpn_desc").val(mpn_descs);
             $("#kit_avg_price").val(kit_avg_prices);
          $(".loader").hide();
          var table = $('#estimate_detail_table').DataTable();
          table.clear().draw();
          for(var i=0; i<data.length; i++){
            var avg_price = data[i].AVG_PRICE;
            if (avg_price == null) {
              avg_price = parseFloat(0).toFixed(2);
            }else{
              avg_price = parseFloat(avg_price).toFixed(2);
            }
            //alert(data.length); return false;
              table.row.add($('<tr style="color:black;"> <td>'+data[i].OBJECT_NAME+'</td> <td>'+data[i].MPN+'</td><td><div style="width: 300px;">'+data[i].MPN_DESCRIPTION+'</div></td><td>'+data[i].CATEGORY_ID+'</td><td> $'+avg_price+'</td></tr>')).draw();
          }

        }
    });
  // alert(category_id);
});
/*=====  End of rss Table popup  ======*/
/*=====  End of Image zoom  ======*/

</script>
