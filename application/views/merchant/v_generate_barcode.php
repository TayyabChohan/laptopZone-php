<?php $this->load->view('template/header');

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       <?php echo $pageTitle; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
<!--
  warehouse mt form insertion  start-->
       <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $pageTitle; ?></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
          <div class="box-body">
            <form action="<?php echo base_url() . 'merchant/c_merchant/print_barcode'; ?>" method="post" target="_blank" accept-charset="utf-8">


                <div class="col-sm-2">
                  <label for="murch_name">Issue Date</label>
                  <div class="form-group">
                    <input type="text" name="issue_date" id="issue_date" class="form-control" value="<?php echo date("Y/m/d"); ?>" readonly>
                  </div>
                </div>

                <div class="col-sm-2">
                  <label for="avail_lot">Merchant Name:</label>
                  <div class="form-group">
                    <select type="text" name="mer_name" id="mer_name" class="form-control selectpicker" value="" data-live-search="true" required>
                    <option value="">Select Merchant</option>
                    <?php foreach ($get_mer_name as $value) {?>
                      <option 
                     
    value="<?php echo $value['MERCHANT_ID']; ?>"><?php echo $value['CONTACT_PERSON']; ?></option>
                  <?php }?>

                    </select>

                  </div>
                </div>
                <!-- <div class="col-sm-2" id="seller_default_div">
                  <label for="seller_account">Seller Account Name:</label>
                  <div class="form-group">
                    <select type="text" name="seller_account" id="apend_seller_account1" class="form-control selectpicker" value="" data-live-search="true" required>
                    <option value="">Select Seller Account</option>
                    <?php //foreach ($seller_account as $value) {?>
                      <option <?php //if($value['DEFAULT_MERCHANT'] == 1) echo 'selected="selected"'; ?> value="<?php //echo $value['ACCT_ID']; ?>"><?php //echo $value['ACCOUNT_NAME']; ?></option>
                  <?php //}?>

                    </select>

                  </div>
                </div> -->
                  <input type="hidden" value="<?php echo @$this->session->userdata('user_id'); ?>" id="user_id_hidden" />
                  <input type="hidden" value="<?php echo @$this->session->userdata('merchant_id'); ?>" id="merchant_id_hidden" />
                      <div id="apend_seller_account"></div>
                    <div id = "apend_lots"></div>



                <div class="col-sm-2">
                  <label for="no_of_barcode">No. of Barcode</label>
                  <div class='form-group' >

                    <input type='number' class="form-control" name="no_of_barcode"  plcaeholder ="Select Active From Date" id="no_of_barcode" value="" required>
                    <label  class="control-label" style="color: red;">Range y/n:</label>&nbsp;&nbsp;
                        <input type="radio" class="bar_range" name="bar_range" value="1" >&nbsp;Yes&nbsp;&nbsp;
                        <input type="radio" class="bar_range" name="bar_range" value="0" checked>&nbsp;No
                  </div>
                </div>



                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="print_barcode" class="control-label"></label>
                     <input type="submit" title="Print Barcode" id="print_barcode" name = "print_barcode" class="btn btn-primary form-control" value ="Print">

                  </div>
                </div>
                <div class="col-sm-12 ">

                <div class="col-sm-1">Total Barcode:<P style="color: red; " id="to_bar" ></P></div>
                <div class="col-sm-1">Cost $:<P style="color: red; " id="to_cost" ></P></div>
                <div class="col-sm-1">Weight / lbs:<P style="color: red; " id="to_weihgt" ></P></div>
                <div class="col-sm-1">$ / LBS:<P style="color: red; " id="to_lbs" ></P></div>
                <div class="col-sm-1">Avg Cost:<P style="color: red; " id="to_avg" ></P></div>
              </div>



            </form>

          </div>
         </div>
 <div class="box">

          <div class="box-body form-scroll">
            <?php if ($this->session->flashdata('success')) {?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } else if ($this->session->flashdata('error')) {?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } else if ($this->session->flashdata('warning')) {?>
                <div class="alert alert-warning">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                </div>
            <?php } else if ($this->session->flashdata('compo')) {?>
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                </div>
            <?php }?>
            <div class="col-md-12">
              <!-- Custom Tabs -->

                    <table id="merchantTable" class="table table-responsive table-striped table-bordered table-hover">
                      <thead>
                          <th>ACTIONS</th>
                          <th>MERCHANT NAME</th>
                          <th>ISSUE DATE</th>
                          <th>ISSUE BY</th>
                          <th>NO OF BARCODE</th>
                          <th>MIN | MAX</th>
                          <th>Ref No</th>
                          <th>LOT DESCRITPION</th>
                          <th>Range</th>
                          <th>Lot Id</th>
                      </thead>
                      <tbody>
                        <?php
$i = 1;
if ($list->num_rows() > 0) {
    // echo "<pre>";
    // print_r($users->result_array());
    // exit;
    foreach ($list->result() as $user) {
        ?>
                           <tr>
                             <td>
                              <button title="Detail" id="<?php echo $user->MT_ID; ?>"  class="btn btn-primary btn-xs detail_btn"><span class="glyphicon glyphicon-list p-b-5" aria-hidden="true"></span>
                              </button>

                             </td>
                             <td><?php echo $user->BUISNESS_NAME; ?></td>
                             <td><?php echo $user->ISSUED_DATE; ?></td>
                             <td><?php echo $user->USER_NAME; ?></td>
                             <td><?php echo $user->NO_OF_BARCODE; ?></td>
                             <td><?php echo $user->RANGE_BARCODE; ?></td>
                             <td><?php echo $user->REF_NO; ?></td>
                             <td><?php echo $user->LOT_DESC; ?></td>
                             <td><?php echo $user->RANGE; ?></td>
                             <td><?php echo $user->LOT_ID; ?></td>

                           <?php
$i++;?>
                          </tr>
                         <?php }
    ?>
                          </tbody>
                        </table>
                       <?php
} else {
    ?>
                        </tbody>
                      </table>
                      <?php
}?>

                  </div>
                <!-- /.col -->
                </div>
              <!-- /.box-body -->
            </div>
         <!--
  warehouse mt form insertion  end-->

        </div>
      </div>


    </section>

    <!-- /.content -->
  </div>
<div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url() . 'assets/images/ajax-loader.gif' ?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>

<!-- Modal -->
<div id="myModal" class="modal modal-info fade" role="dialog" tabindex="-1" data-focus-on="input:first" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body">
                <section class="content">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">Barcode Detail</h1>
                          <div class="box-tools pull-right">

                          </div>
                        </div>
                        <div class="box-body ">
                        <div class="col-md-12" style="color:black!important;">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="merchant_name">Merchant Name:</label>
                              <input name="merchant_name" type="text" id="merchant_name" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="issued_date">Issue Date:</label>
                              <input name="issued_date" type="text" id="issued_date" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="issued_by">Issued By:</label>
                              <input name="issued_by" type="text" id="issued_by" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="barcode_count">No. of Barcode:</label>
                              <input name="barcode_count" type="text" id="barcode_count" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="barcode_count">Range y/n:</label>
                              <input name="range" type="text" id="range" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>



                        </div>

                        <div class="col-sm-12 " id = "apnd_radi">



                        </div>

                          <div class="col-md-12 form-scroll">

                            <table id="barcodeDetailTable" style="color: #000!important;" class="table table-responsive table-striped table-bordered table-hover ">
                              <thead>
                                <th style="color:black;">ACTION</th>
                                <th style="color:black;">PICTURE</th>
                                <!-- <th style="color:black;">SR NO</th> -->
                                <th style="color:black;">BARCODE</th>
                                <th style="color:black;">Cost</th>

                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-sm-2">
                          <div class="form-group">
                          <form action="<?php echo base_url() . 'merchant/c_merchant/printAllBarcode'; ?>" method="post" target="_blank" accept-charset="utf-8">
                            <input type="hidden" id="barcode_mt_id" name="barcode_mt_id"  value="">

                            <input type="submit" class="btn btn-success" id="printAll" name="printAll" value="Print All">
                            </form>
                          </div>
                        </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
                <img align="center" src="<?php echo base_url() . 'assets/images/ajax-loader.gif' ?>" alt="ajax loader" style="width: 100px; height: 100px;">
            </div>
</div>
<!-- detail modal end -->

 <?php $this->load->view('template/footer');?>

 <script >
 	  $('#closeModal').on('click',function(){
      $('#myModal').modal('hide');

    });
     $('#merchantTable').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
/*=======================================
=            rss Table popup            =
=======================================*/

$(document).on('click','.detail_btn',function(){
  var mt_id = this.id;
  var table = $('#merchantTable').DataTable();
  var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex;
  var row = table.row( rowIndex ).data();

  var marchant_name = row[1];
  var issued_date = row[2];
  var issued_by = row[3];
  var barcode_count = row[4];
  var range = row[7];
//console.log(barcode_count); return false;
  $(".loader").show();
 $('#myModal').modal('show');
  $(".loader").hide();
  $('#merchant_name').val('');
  $('#issued_date').val('');
  $('#issued_by').val('');
  $('#barcode_count').val('');
  $('#barcode_mt_id').val('');
  $('#range').val('');


  $('#merchant_name').val(marchant_name);
  $('#issued_date').val(issued_date);
  $('#issued_by').val(issued_by);
  $('#barcode_count').val(barcode_count);
  $('#range').val(range);

  $('#barcode_mt_id').val(mt_id);

  if(range == 'Yes'){
    $('#apnd_radi').html('');
    console.log('asd');

    $('#apnd_radi').append('<div class="col-sm-3 "><div class="form-group"><h4 style ="color:red;">Enter Cost:</h4><input type="number"  id="get_rang_cost_val" name = "get_rang_cost_val"  class=" form-control get_rang_cost_val" value ="0.00"></div></div><div class="col-sm-2"> <div class="form-group p-t-24 "> <input type="button"  id="get_rang_cost" name = "get_rang_cost" class=" btn btn-success get_rang_cost" value ="Save"> </div> </div>');
  }else{
        $('#apnd_radi').html('');
      }


  /*====================================================
          =            remove all rows in datatable            =
          ====================================================*/
           var tab= $('#barcodeDetailTable').DataTable();
          tab.clear();
          tab.destroy();
          var table = $('#barcodeDetailTable').DataTable({
          "oLanguage": {
          "sInfo": "Total Records: _TOTAL_",
          //"sPaginationType": "full_numbers",

          },
        // For stop ordering on a specific column
        // "columnDefs": [ { "orderable": false, "targets": [0] }],
        // "pageLength": 5,
           "iDisplayLength": 25,
          "aLengthMenu": [[25, 50, 100, 200,500, 5000, -1], [25, 50, 100, 200,500, 5000, "All"]],
           "paging": true,
          // "lengthChange": true,
          "searching": true,
          // "ordering": true,
          "fixedHeader": true,
          "Filter":true,
          "aaSorting": [[1,'asc']], // sort on sold Qty desc
          // "iTotalDisplayRecords":10,
          //"order": [[ 8, "desc" ]],
          // "order": [[ 16, "ASC" ]],
          "info": true,
          // "autoWidth": true,
          "fixedHeader": true,
          "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
          "bProcessing": true,
          "bRetrieve":true,
          "bDestroy":true,
          "bServerSide": true,
          "ajax":{
            data : {'mt_id':mt_id},
            url :"<?php echo base_url() ?>merchant/c_merchant/barcodeDetail", // json datasource
            type: "post"  // method  , by default get
            // data: {},
            },
          "columnDefs":[{
                "target":[0],
                "orderable":false
              }
            ]

        });//end datatable

});



$(document).on('click','.get_bar_cost',function(){
  $(".loader").hide();
  var get_barc =$(this).attr('id');
  var get_cost = $("#get_cost_"+get_barc).val();
   $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/save_bar_cost',
        type:'post',
        dataType:'json',
        data:{'get_barc':get_barc,'get_cost':get_cost},

         success:function(data){
          $(".loader").hide();

      }
    });
});

$(document).on('change','#avail_lot',function(){
   $(".loader").show();
  var avail_lot_id = $('#avail_lot').val();

  if(avail_lot_id !=''){


   $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/get_total_bar',
        type:'post',
        dataType:'json',
        data:{'avail_lot_id':avail_lot_id},

         success:function(data){
          $(".loader").hide();




          $('#to_bar').html('');
          $('#to_cost').html('');
          $('#to_weihgt').html('');
          $('#to_lbs').html('');
          $('#to_avg').html('');

        $('#to_bar').append(data['tot_quer'][0].TOTAL_BAR)
        $('#to_cost').append(data['tot_quer'][0].COST_LOT)
        $('#to_weihgt').append(data['tot_quer'][0].WEIGH)
        $('#to_lbs').append(data['tot_quer'][0].COST_PER_LBS)
        $('#to_avg').append(data['tot_quer'][0].AVG_AMOUNT)

          //$("#apend_total").val(data['tot_quer'][0].TOTAL_BAR);
          //console.log(data['tot_quer'][0].TOTAL_BAR);

      }
    });
}else{
  $(".loader").hide();

}
});

$(document).on('click','#get_rang_cost',function(){



  var mt_id = $("#barcode_mt_id").val();

  var get_rang_cost_val = $("#get_rang_cost_val").val();
   $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/save_rang_bar_cost',
        type:'post',
        dataType:'json',
        data:{'get_rang_cost_val':get_rang_cost_val,'mt_id':mt_id},
        success:function(data){


      }
    });
});

// SELLERE ACCOUNT NAME
// var merchant_id_for_lot_seller = ''
$(document).on('change', '#mer_name', function(){
  $(".loader").show();
  $("#seller_default_div").hide();
  $("#apend_seller_account1").empty();

  var mer_name = $('#mer_name').val();
  $("#apend_lots").empty();
  // $("#apend_lots").hide();
  if(mer_name == ''){
    $(".loader").hide();
    return false;
  }
  // document.getElementById("user_id_hidden").value;
  // var user_id = document.getElementById("user_id_hidden").value;
  var user_id = $("#user_id_hidden").val();
  // var merchant_id = $("#merchant_id_hidden").val();
  var merchant_id = $('#mer_name').val();
  console.log(user_id);
  console.log(merchant_id);
  $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/get_merchant_acount_name',
        type:'post',
        dataType:'json',
        data:{'user_id': user_id, 'merchant_id': merchant_id},

         success:function(data){
          $(".loader").hide();
          $('#apend_seller_account').html("");
          // console.log(data.data);
          seller_account = [];
          for(var j = 0;j<data.data.length;j++){
          seller_account.push('<option  value="'+data.data[j].ACCT_ID+'">'+data.data[j].ACCOUNT_NAME+'</option>')
          }

          $('#apend_seller_account').append('<div class="col-sm-2" ><label for="seller_account">Seller Account:</label><div class="form-group"><select class="form-control seller_account" data-live-search ="true" id="seller_account"  name="seller_account" required ><option value="">Select Seller Account</option>'+seller_account.join("")+'</select></div></div> ');
          //  $('#apend_seller_account').append('<div class="col-sm-3" ><label for="seller_account">Seller:</label><div class="form-group"><select class="form-control avail_lot" data-live-search ="true" id="avail_lot"  name="avail_lot" ><option value="">Select Lot</option>hshdas</select></div></div> ');

          // $('.avail_lot').selectpicker();

      }
    });


})

// SELLER ACCOUNT NAME END

$(document).on('change','#apend_seller_account',function(){
   $(".loader").show();
  var mer_name = $('#mer_name').val();
console.log('Seller Account '+$('#mer_name').val());
  if(mer_name ==''){
    $(".loader").hide();
    //alert('Please Select Merchant');
    return false;
  }

console.log(mer_name)
   $.ajax({
        url:'<?php echo base_url(); ?>merchant/c_merchant/get_mech_lots',
        type:'post',
        dataType:'json',
        data:{'mer_name':mer_name},

         success:function(data){
          $(".loader").hide();
           $('#apend_lots').html("");

          lot = [];
          for(var j = 0;j<data.get_lot.length;j++){
          lot.push('<option value="'+data.get_lot[j].LOT_ID+'">'+data.get_lot[j].LOT_DESC+'</option>')
          }

          $('#apend_lots').append('<div class="col-sm-2" ><label for="avail_lot">Lot:</label><div class="form-group"><select class="form-control avail_lot" data-live-search ="true" id="avail_lot"  name="avail_lot" ><option value="">Select Lot</option>'+lot.join("")+'</select></div></div> ');

          $('.avail_lot').selectpicker();

      }
    });

});

 </script>