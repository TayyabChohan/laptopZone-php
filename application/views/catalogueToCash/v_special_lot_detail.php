<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Special Item Recognition  Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Special Item Recognition Detail</li>
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
              <div class="col-sm-6 col-sm-offset-3">
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
              </div>
              <div class="col-sm-12"><!-- 
              <div class="col-sm-2">
                <label>Search Filter:</label>
              </div> -->
             <!--  <form action="<?php //echo base_url(); ?>catalogueToCash/c_card_lots/search_lots" method="post"> -->
              <div class="col-sm-2 ">
                <div class="form-group" >
                   <label for="Search Webhook">Select Merchant</label>
              
              <select class="form-control selectpicker " name="merch_id" id="merch_id" data-live-search="true" required>
              <option value="">Select Merchant</option>
              <?php
              foreach($data['merch_nam'] as  $merc_id) {
              ?>
              <option value="<?php echo $merc_id['MERCHANT_ID']; ?>"  <?php //if($this->session->userdata('title_sort') == $key){echo "selected";}?>><?php echo $merc_id['CONTACT_PERSON']; ?></option>
              <?php
              }
              ?>
              </select>           

                </div>
              </div>
                <div class="col-sm-3 p-t-24">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php $searchedData = $this->session->userdata('searchLots'); ?>
                      <input type="text" class="btn btn-default" name="lot_date" id="lot_date" value="<?php echo $searchedData['lotDateRange']; ?>">
                    </div>
                  </div>
                </div>
                <?php $checked = $searchedData['session_posting']; ?>
                <div class="col-sm-3 p-t-24">
                  <input type="checkbox" name="lot_posting_chek" value="4" >&nbsp;Unique&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="lot_posting" value="1" <?php if($checked == 1){ echo 'checked'; } ?>>&nbsp;Posted
                  <input type="radio" name="lot_posting" value="2" <?php if($checked == 2){ echo 'checked'; } ?>>&nbsp;Un Posted
                  <input type="radio" name="lot_posting" value="3" <?php if($checked == 3){ echo 'checked'; } ?>>&nbsp;Ready Data
                  <input type="radio" name="lot_posting" value="0" <?php if($checked == 0){ echo 'checked'; } ?>>&nbsp;All   
                </div>

                <div class="col-sm-2 p-t-24">
                  <div class="form-group">
                    <input type="button" class="btn btn-primary btn-sm" name="search_lister" id="search_lister" value="Search">
                   
                    <a target="_blank" class="btn btn-success btn-sm" href="<?php echo base_url().'dekitting_pk_us/c_listing_pk_us'?>">Listing-pk-us</a>
                  </div>
                </div>
                <div><h1 id="testid"></h1></div>
                <div class="row">
                <div class="col-sm-12">
                   
                   <?php $emp_id =   $this->session->userdata('user_id');?>
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
                 <?php  if($emp_id == 21 || $emp_id == 22 || $emp_id == 23 || $emp_id == 26){?>
                <div class="col-sm-2 p-t-24  ">
                  <div class="form-group">
                    <input type="button" class="btn btn-success  asi_pk" name="asi_pk" id="asi_pk" value="Assign">
                  </div>
                </div>

                <?php }?>
                </div>
              </div>

                 <!-- <div class="col-sm-1">
                  <div class="form-group">
                    <a href="<?php //echo base_url().'catalogueToCash/c_card_lots/readyData'; ?>" class="btn btn-primary btn-sm">Ready Data</a>
                  </div>
                </div> -->
                <div class="col-sm-1 pull-left " id="post_btn" style="display: none;">
                  <div class="form-group">
                    <input type="button" class="btn btn-success btn-sm" name="post_special_items" id="post_special_items" value="Post Items">
                  </div>
                </div>
              <!-- </form> --> 
               <!--  <input type="hidden" name="search_postings" id="search_postings" value="<?php //echo $postings; ?>">    
                <input type="hidden" name="search_date" id="search_date" value="<?php //echo $rslt; ?>">   -->
                <?php //$this->session->unset_userdata('searchLots');?>                 
            </div>
          </div>
        </div>
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Special Lots</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>              
          </div>              
          <div class="box-body form-scroll">   
            <div class="col-md-12">
              <table id="special_lot_table" class="table table-bordered table-striped" >
                <thead>
                    <th>Select</th>
                    <th>ACTION</th>
                    <th>PICTURE</th>
                    <th>Assign To</th>
                    <th>BARCODE</th>
                    <th>LOT REMARKS</th>
                    <th>BARCODE NOTES</th>
                    <th>UPC</th>
                    <th>MPN</th>
                    <th>MPN DESCRIPTION</th>
                    <th>CONDITION</th>
                    <th>BRAND</th>
                    <th>BIN/RACK</th>
                    <th>BIN NAME</th>                    
                    <th>PIC NOTES</th>
                    <th>CREATED AT</th>
                    <th>CREATED BY</th>
                    <th>UPDATED AT</th>
                    <th>UPDATED BY</th>
                    <th>Lot Desc</th>
                    
                </thead>
                <tbody>             
              </tbody>
            </table>
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
  <!-- ///////////////MODAL SATART//////////////////// --> 
<!-- Modal -->
<!-- detail modal end -->
  <!-- ///////////////MODAL END//////////////////// -->   
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
/*================================================
=            Approval for Listing                =
==================================================*/
var lot_posting = '';
var lot_posting_chek = '';
var lot_date = '';
$(document).ready(function(){
   $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  $("#special_lot_table").dataTable().fnDestroy();

    lot_posting = $("input[name='lot_posting']:checked").val();
    lot_posting_chek = $("input[name='lot_posting_chek']:checked").val();
    if (lot_posting == 3) {
      $("#post_btn").show();
    }else{
      $("#post_btn").hide();
    }
    lot_date     = $("#lot_date").val();
     

    get_uniqu_items();
    $("#special_lot_table").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 300,
    "aLengthMenu": [[25, 50, 100, 200,300,500], [25, 50, 100, 200,300,500]],
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
      url :"<?php echo base_url().'catalogueToCash/c_card_lots/load_special_lots'?>", // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {
         "lot_posting":lot_posting,
         "lot_posting_chek":lot_posting_chek,
         "lot_date":lot_date
        },
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
/////////////////////////////
$(document).on('click', "#search_lister", function(){

  var get_emp = $('#get_emp').val();
  var search_postings = '';
  
   var search_date = '';
   var lots_url = '';
  $("#special_lot_table").dataTable().fnDestroy();
    search_postings = $("input[name='lot_posting']:checked").val();

    lot_posting_chek = $("input[name='lot_posting_chek']:checked").val();

    if ($("input[name='lot_posting_chek']").is(':checked')) {
       var lot_posting_chek = $("input[name='lot_posting_chek']:checked").val();


    }else{

      var  lot_posting_chek = '';

    }
    console.log(lot_posting_chek);

    if (search_postings == 3) {
      $("#post_btn").show();
    }else{
      $("#post_btn").hide();
    } 
    search_date     = $("#lot_date").val();
    merch_id     = $("#merch_id").val();
    lots_url= "<?php echo base_url().'catalogueToCash/c_card_lots/load_special_lots'?>";
    get_uniqu_items();
    ///console.log(search_postings, search_date); return false;
    $("#special_lot_table").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
    "fixedHeader": true,
    "paging": true,
    "iDisplayLength": 300,
    "aLengthMenu": [[25, 50, 100, 200,300,500], [25, 50, 100, 200,300,500]],
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
      url :lots_url, // json datasource
      type: "post" , // method  , by default get
      dataType: 'json',
      data: {
         "lot_posting":search_postings,
         "lot_date":search_date,
         "merch_id":merch_id,
         "lot_posting_chek":lot_posting_chek,
         "get_emp":get_emp
        },
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }
      ]      
  });
});
   

   function get_uniqu_items (){
   var search_postings = '';
   var search_date = '';
   var lots_url = '';

  $("#special_lot_table").dataTable().fnDestroy();
    search_postings = $("input[name='lot_posting']:checked").val();
    if (search_postings == 3) {
      $("#post_btn").show();
    }else{
      $("#post_btn").hide();
    }
    search_date     = $("#lot_date").val();
    merch_id     = $("#merch_id").val();
    //lots_url= "<?php //echo base_url().'catalogueToCash/c_card_lots/get_unique_count_lot'?>";
    $.ajax({
      url:'<?php echo base_url().'catalogueToCash/c_card_lots/get_unique_count_lot'?>',
      type:'post',
      dataType:'json',
       data: {
         "lot_posting":search_postings,
         "lot_date":search_date,
         "merch_id":merch_id
        },
      
      success: function(data){
        $('#testid').html('');

        $('#testid').append('Unique Items '+data.query_count[0]['UNIQ_ITEM'])

        //$('#uniq_item').val(data.query_count[0]['UNIQ_ITEM']);
        //console.log(data);
        // if (data == true) {
        //   alert('Data has been posted');
        //   return false;
        //   } 
         }
        });


}

$(document).on('click','.asi_pk',function(){

  console.log('asd');
  var mtable = $('#special_lot_table').DataTable();

  var assign_listing = [];
  $.each($("input[name='combin_pics[]']:checked"), function(){            
   assign_listing.push($(this).val());
  });

  var get_emp = $('#get_emp').val();

    console.log(assign_listing);
   // return false;
  if( assign_listing.length !=0  && get_emp != '' ){
    //return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/asign_dkit_list',
      data: { 'assign_listing':assign_listing,'get_emp':get_emp   },

     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Item is assigned .');
          //$.each($("input[name='combin_pics[]']:checked"), function(){  
            //mtable.row($(assign_listing).parents('tr') ).remove().draw();
          //mtable.row ('.checked') .remove() .draw(); 
     // mtable.row( $("#"+det_id).parents('tr') ).remove().draw();
          //});
          return false;
          //$.each($("input[name='combin_pics[]']:checked"), function(){  
         //  mtable.row ('.checked') .remove() .draw(); 
      //mtable.row( $("#"+det_id).parents('tr') ).remove().draw();
          //});

          //$("#search_lister").trigger("click");
          //window.location.reload();
        }else if(data == false){
          alert('Error - Item is not assigned .');
          $("#search_lister").trigger("click");
          return false;
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
////////////////////////////
/*=====================================================
=            update keyword modal function            =
=====================================================*/
  /////////////////////////////////
  $("#post_special_items").on('click', function(){
    ///alert('sadadad'); return false;
    $.ajax({
      url:'<?php echo base_url()."/catalogueToCash/c_card_lots/postSpecialLots"; ?>',
      type:'post',
      dataType:'json',
      data:{},
      success: function(data){
        if (data == true) {
          alert('Data has been posted');
          return false;
          } 
         }
        });
      });
    /////////////////////////////////
////////////////////////////
////////////////////////////
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
$(document).on('click','.flag-discard',function(){
  if(confirm('Are You Sure!')){
      $(".loader").show();
      var bar =$(this).attr('dBarcode');
      //console.log(bar);return false;

      $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/discardBarcode',
      data: {'bar':bar},
     success: function (data) {
      $(".loader").hide();
      //console.log(data);
          if(data == 1){
            $(".loader").hide();
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

            $(".loader").hide();
          alert('Some error occur. Try Again.');
            return false;
         }
      }
    });
  }else{
    return false;
  }

 

 });

/// combine all barcodes
$(document).on('click','.get_bar',function(){


  var combin_pics = [];
  $.each($("input[name='combin_pics[]']:checked"), function(){            
   combin_pics.push($(this).val());
  });

  if(combin_pics.length ==0){
    alert('Select Any Item');
    return false;

  }
  var get_barcode = $(this).attr('id');
      

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/combine_pics',
      data: { 'combin_pics':combin_pics,'get_barcode':get_barcode           
    },
     success: function (data) {
      
        if(data == true){
          alert('Pictures Are Copied!');
          $("#search_lister").trigger("click");
          return false;
          //window.location.reload();
          
        }else if(data == false){
          alert('Error - Pictures are not copied.');
          return false;
          //window.location.reload();
        }
      }
      });  

});

/*=====  End of Approval for Listing  ======*/   
 </script>