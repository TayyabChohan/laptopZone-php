<?php $this->load->view('template/header'); 
ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
     Total Verified Data
        <small>Control panel</small>
    <ol class="breadcrumb">
      <li>
        <a href="<?php echo base_url();?>dashboard/dashboard">
          <i class="fa fa-dashboard">
          </i> Home
        </a>
      </li>
      <li class="active">Verified Data
      </li>
    </ol>
  </section>  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box">
          <br>     
          <div class="box-body form-scroll">  
            <?php if($this->session->flashdata('success')){ ?>
            <div id="successMsg" class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;
              </a>
              <strong>Success!
              </strong> 
              <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div id="errorMsg" class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert">&times;
              </a>
              <strong>Error!
              </strong> 
              <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php }
             ?>  
               <div class="row">
              <div class="col-sm-12">
              <?php 
                // $cat_id= $this->uri->segment(4);
                // $unverify_List_type = $data['unverify_List_type'];
                // $unverify_condition = $data['unverify_condition'];
                // $seller = $data['seller'];
               ?>
              <form action="<?php echo base_url().'catalogueToCash/c_purchasing/searchverifyData/'.$cat_id ?>" method="post" accept-charset="utf-8">
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Search Webhook">Listing Type:</label>
                      <select class="form-control selectpicker" name="listingType" id="listingType" data-live-search="true">
                        <option value="">All</option>
                        <?php  
                        $ctListingType = $this->session->userdata("unverify_List_type");                              
                          foreach(@$dataa['list_types'] as $type) { 
                            if ($ctListingType == strtoupper($type['LISTING_TYPE'])){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                 
                              ?>
                              <option value="<?php echo $type['LISTING_TYPE']; ?>"<?php echo $selected; ?>><?php echo $type['LISTING_TYPE']; ?></option>
                              <?php
                              //$this->session->unset_userdata('ctListingType');
                              } 
                           ?>                     
                      </select>                       
                  </div>
                </div>  
                 <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Search Webhook">Condition:</label>
                      <select class="form-control selectpicker" name="condition" id="condition" data-live-search="true">
                        <option value="">All</option>
                        <?php 
                        $listCondition = $this->session->userdata("unverify_condition");                                
                          foreach(@$dataa['conditions'] as $type){ 
                          if ($listCondition == $type['ID']){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                
                              ?>
                               <option value="<?php echo $type['ID']; ?>"<?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                              <?php
                               //$this->session->unset_userdata('ctListing_condition');
                              } 
                           ?>                     
                      </select> 

                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Search Webhook">Seller Id:</label>
                      <select class="form-control selectpicker" name="seller" id="seller" data-live-search="true">
                        <option value="">All</option>
                        <?php 
                        $seller = $this->session->userdata("seller");                                
                          foreach(@$dataa['seller'] as $type){ 
                          if ($seller == strtoupper($type['SELLER_ID'])){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                 
                              ?>
                              <option value="<?php echo $type['SELLER_ID']; ?>"<?php echo $selected; ?>><?php echo $type['SELLER_NAME']; ?></option>
                              <?php
                              } 
                           ?>                     
                      </select> 

                  </div>
                </div> 

                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Search Webhook">MPN:</label>
                      <select class="form-control selectpicker" name="mpn" id="mpn" data-live-search="true">
                        <option value="">All</option>
                        <?php 
                        $mpn= $this->session->userdata("mpn");                                
                          foreach(@$dataa['mpn'] as $type){ 
                          if ($mpn == strtoupper($type['MPN'])){
                                $selected = "selected";
                              }else {
                                  $selected = "";
                              }                 
                              ?>
                              <option value="<?php echo $type['MPN']; ?>"<?php echo $selected; ?>><?php echo $type['MPN_NAME']; ?></option>
                              <?php
                              } 
                           ?>                     
                      </select> 
    </div>
                </div>                
                <div class="col-sm-3">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_webhook" id="search_webhook" value="Search">
                  </div>
                </div>
 </div>
   
      
      <div class="col-sm-12">
            <div class="col-sm-2">
                                    
              <div class="form-group">
              <label for="Feedback Score">Feedback Score:</label>
              <div class="input-group" >

              <input type="text" name ="fed_one" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('fed_one');?>"  />
              <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
              <input type="text" name ="fed_two" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('fed_two');?>" />
              </div>
              </div>
                        
            </div>
<div class="col-sm-2">
                                    
              <div class="form-group">
              <label for="Feedback Score">Price Percent  %:</label>
              <div class="input-group" >

              <input type="text" name ="perc_one" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('perc_one');?>"  />
              <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
              <input type="text" name ="perc_two" class="form-control input-lg" VALUE="<?php echo  $this->session->userdata('perc_two');?>" />
              </div>
              </div>

            </div>


            
      </div>   
          
              </form>                                            
             
           
            <div class="col-md-12">
              <input type="hidden" name="ct_category" value="<?php echo $cat_id; ?>" id="ct_category">
              <!-- Custom Tabs -->
              <table id="unverified-list" class="table table-responsive table-striped table-bordered table-hover">
               <thead>
               <tr>
              <th>ACTION</th>
              <th>EBAY ID</th>
              <th>MPN</th>
              <th>TIME DIFF</th>
              <th><p style="width: 200px;">TITLE</p></th>
              <th>SELLER ID</th>
              <th>FEEDBACK SCORE</th>
              <th>LISTING TYPE</th> 
              <th>CONDITION NAME</th>
              <th>TRACKING ID</th>
              <th>SOLD AVERAGE</th>
              <th>LIST SOLD</th>
              <th>ACTIVE PRICE</th>
              <th>COST PRICE</th>
              <th>price %</th>
              <th>KIT</th>
              <th>EST EBAY FEE</th>
              <th>EST PAYPAL FEE</th>
              <th>EST SHIP FEE</th>
              <th>TOTAL</th>
               <th>AMOUNT</th>
              <th>PROFIT %</th>
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
   /* var dataTable = $('#unverified-list').DataTable({
      "oLanguage":{
        "sInfo": "Total Records: _TOTAL_"
      }
      ,
      // For stop ordering on a specific column
      columnDefs: [{
        orderable: false, targets: [0] }
                  ],
      "iDisplayLength": 100,
      "aLengthMenu": [[5, 10, 25, 50, 100, 200], [5, 10, 25, 50, 100, 200]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      //"order": [[ 8, "desc" ]],
      //"order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "processing": true,
      "serverSide": true,     
      "ajax":{
        url :"<?php //echo base_url() ?>bigData/c_bigData_1/loadData", // json datasource
        type: "post",  // method  , by default get
        error: function()
        {
          // error handling
          $(".categoryData-error").html("");
          $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
          $("#categoryData_processing").css("display","none");
        }
      }
      //dataTable.destory();
    });*/
    /*///////////////////////////////*/
    var dataTable = $('#unverified-list').DataTable( {  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "aLengthMenu": [15,25, 50, 100, 200],
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
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadverifySearchData/'.$cat_id; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
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