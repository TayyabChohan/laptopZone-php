<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
      // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listed Dekit Items Audit
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listed Dekit Items Audit</li>
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
              <div class="col-sm-12">
              <div class="col-sm-2">
                <label>Search Filter:</label>
              </div>
              <form action="<?php echo base_url(); ?>tolist/c_tolist/listedItemsAudit" method="post">
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php $searchedData = $this->session->userdata('dekit_searchdata'); ?>
                      <input type="text" class="btn btn-default" name="date_range" id="date_range" value="<?php echo $searchedData['dekit_dateRange']; ?>">
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <input type="radio" name="location" value="PK" 
                  <?php 
                  if(!empty(@$searchedData['dekit_location'])){
                    if($searchedData['dekit_location'] == 'PK'){
                      echo 'checked';
                    }
                  }else{
                    echo 'checked';
                  }

                   ?>>&nbsp;Pak Lister
                  <input type="radio" name="location" value="US" 
                  <?php 
                  if(!empty(@$searchedData['dekit_location'])){
                    if($searchedData['dekit_location'] == 'US'){
                      echo 'checked';
                    }
                  }
                   ?>>&nbsp;US Lister
                  <input type="radio" name="location" value="ALL" 
                  <?php 
                  if(!empty(@$searchedData['dekit_location'])){
                    if($searchedData['dekit_location'] == 'ALL'){
                      echo 'checked';
                    }
                  }
                   ?>>&nbsp;All   
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_lister" id="search_lister" value="Search">
                  </div>
                </div>
              </form>
              <div class="col-sm-2">
                <div class="form-group">
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/listedItemsAudit">Listed Items Audit</a>
                </div>
              </div>                      
            </div>
          </div>
        </div>  
        <div class="box">  
        <div class="box-body form-scroll"> 
        <input type="hidden" name="search_location" id="search_location" value="<?php echo $location; ?>">    
        <input type="hidden" name="search_date" id="search_date" value="<?php echo $rslt; ?>">

        <div class="col-sm-12">
          <div class="col-sm-2">
            <div class="form-group">
              <label>Assign Bin:</label>
              <?php  @$dekit_audit_bin_id = $this->session->userdata("dekit_audit_bin_id");?>
              <input type="text" name="audit_bin_id" id="audit_bin_id" class="form-control" value="<?php if($dekit_audit_bin_id){echo $dekit_audit_bin_id;} ?>">
            </div>
          </div>
        </div> 

        <div class="col-md-12">
          <table id="listedItems" class="table table-bordered table-striped listedItems" >
            <thead>
              <tr>
                <th>ACTION</th>
                <th>PICTURE</th>
                <th>EBAY ID</th>
                <th>LISTED BARCODE</th>
                <!-- <th>ALL BARCODE</th> -->
                <th>CONDITION</th>
                <th>TITLE</th>
                <th>LIST QTY</th>
                <th>LIST PRICE</th>
                <th>LISTER NAME</th>
                <th>LISTING TIME &amp; DATE</th>
                <!-- <th>UPC</th> -->
                <th>MPN</th>
                <th>MANUFACTURE</th>
                <!-- <th>SHIPPING SERVICE</th>
                <th>PURCH REF NO</th> -->
                <th>BIN NAME</th>
                <th>ACCOUNT</th>
                <th>STATUS</th>
                <th>SOLD STATUS</th>
              </tr>
            </thead>
              <tbody>  
              </tbody>
              </table>
          </div>     
        </div><!-- /.col -->
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
  $(document).ready(function(){
    var search_location = '';
    var search_date = '';
    $(document).on('click', "#search_lister", function(e){
      e.preventDefault();
      search_location = $("input[name='location']:checked").val();
      search_date     = $("#date_range").val();
      //console.log(search_lister, search_location, search_date); return false;

      $("#listedItems").dataTable().fnDestroy();
      $("#listedItems").DataTable({
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
        url :"<?php echo base_url().'dekitting_pk_us/c_dekit_audit/loadListedItemsAudit' ?>", // json datasource
        type: "post" , // method  , by default get
        dataType: 'json',
        data: {
         "search_location":search_location,
         "search_date":search_date
          },
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "rowCallback": function( row, data, dataIndex){
            if(data){
                
                $(row).find(".verified").closest( "tr" ).addClass('verifiedTr');
                $(row).find(".verifiedt").closest( "tr" ).addClass('myclass');
                }
              }      
    });

    });

  
      search_location = $("#search_location").val();
      search_date     = $("#date_range").val();
      //console.log(search_lister, search_location, search_date); return false;
      $("#listedItems").dataTable().fnDestroy();

     $("#listedItems").DataTable({
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
      "dom":'<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
        "bProcessing": true,
        "bRetrieve":true,
        "bDestroy":true,
        "bServerSide": true,
        "bAutoWidth": true,
        "ajax":{
        url :"<?php echo base_url().'dekitting_pk_us/c_dekit_audit/loadListedItemsAudit' ?>", 
        // json datasource
        type: "post" , // method by default get
        dataType: 'json',
        data: {
    
         "search_location":search_location,
         "search_date":search_date
          },
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],

        "rowCallback": function( row, data, dataIndex){
            if(data){
                
                $(row).find(".verified").closest( "tr" ).addClass('verifiedTr');
                $(row).find(".verifiedt").closest( "tr" ).addClass('myclass');
                }
              }      
    });
   });

/*================================================
=        SET Bin ID in session call start           =
================================================*/

$(document).on('click','#brc_del', function(){
  
var result = confirm("Want to delete?");
if (result) {
  $(".loader").show();
  $(this).closest('tr').fadeOut(1000, function() {
            $(this).closest('tr').remove();
            });
 var bar_no = $(this).attr('cid');

 $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/del_audit_barcode',
        
        type:'post',
        dataType:'json',
        data:{'bar_no':bar_no},
        success:function(data){
         $(".loader").hide();      
      }
  });
}else{
  return false;
}
  
}); 


$(document).on('blur','#audit_bin_id',function(){
  var audit_bin_id = $('#audit_bin_id').val().trim(); 
  //console.log(listId, barCode, audit_bin_id); return false;
  if(audit_bin_id === ''){
    alert('Please Assign a Bin to Item.');
    //$('#audit_bin_id').focus();
    return false;
  }

  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekit_audit/setBinIdtoSession',
    data: { 'audit_bin_id':audit_bin_id           
  },
   success: function (data) {
    //alert(data);return false;
      if(data == true){
        console.log("Success! Bin ID is added to session.");
        
      }else if(data == false){

        alert("Bin Name is Wrong.");
        $('#audit_bin_id').val("");
        return false;
        //window.location.reload();
      }
    }
    });  

});

/*=====  End of SET Bin ID in session call  ======*/   

/*================================================
=       Print Sticker and Assign Bin start           =
================================================*/
$(document).on('click','#dekit_print_bttn',function(){
    //$(selector).attr(attribute)
  //var this_tr = $(this).closest('tr'); // remove row dynamically from table
  var listId = $(this).attr("listId"); 
  var barCode = $(this).attr("barCode"); 
  var audit_bin_id = $('#audit_bin_id').val().trim(); 
  //console.log(listId, barCode, audit_bin_id); return false;
  if(audit_bin_id === ''){
    alert('Please Assign a Bin to Item.');
    //$('#audit_bin_id').focus();
    return false;
  }else{
    var sticker_url = "<?php echo base_url();?>listing/listing/print_audit_label/"+listId+'/'+barCode+'/'+audit_bin_id;
    var sticker_url = window.open(sticker_url, '_blank');
    sticker_url.location;

    //var row = $(this).attr("listId");
    //debugger;     
    $(this).closest('tr').fadeOut(1000, function() {
    $(this).closest('tr').remove();
    });

    // var table = $('#listedItems').DataTable();          
    // this_tr.fadeOut(1000, function () { table.row(this_tr).remove().draw() }); // remove row dynamically from table
    //location.reload();
  }


});

/*=====  End of Print Sticker and Assign Bin  ======*/   

/*================================================
=       Auto Print Sticker and Assign Bin start           =
================================================*/
$(document).on('click','#dekit_print_auto',function(){
    //$(selector).attr(attribute)
  //var this_tr = $(this).closest('tr'); // remove row dynamically from table
  var listId = $(this).attr("listIdAuto"); 
  var barCode = $(this).attr("barCodeAuto"); 
  var audit_bin_id = $('#audit_bin_id').val().trim(); 
  //console.log(listId, barCode, audit_bin_id); return false;
  if(audit_bin_id === ''){
    alert('Please Assign a Bin to Item.');
    //$('#audit_bin_id').focus();
    return false;
  }else{
    var sticker_url = "<?php echo base_url();?>listing/listing/print_test/"+listId+'/'+barCode+'/'+audit_bin_id;
    var sticker_url = window.open(sticker_url, '_blank');
    sticker_url.location;

    //var row = $(this).attr("listIdAuto");
    //debugger;     
    $(this).closest('tr').fadeOut(1000, function() {
    $(this).closest('tr').remove();
    });
    
    // var table = $('#listedItems').DataTable();          
    // this_tr.fadeOut(1000, function () { table.row(this_tr).remove().draw() }); // remove row dynamically from table    
    //location.reload();
  }


});

/*=====  End of Auto Print Sticker and Assign Bin  ======*/  

</script>