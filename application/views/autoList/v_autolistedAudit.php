<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
      // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Auto Listed Items Audit
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Auto Listed Items Audit</li>
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
             <!--  <form action="<?php //echo base_url(); ?>tolist/c_tolist/listedItemsAudit" method="post"> -->
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <?php $searchedData = $this->session->userdata('searchdata');
                      //var_dump($searchedData);

                       ?>

                      <input type="text" class="btn btn-default" name="date_range" id="date_range" value="<?php echo $searchedData['dateRange']; ?>">
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <input type="radio" name="location" value="PK" 
                  <?php 
                  if(!empty(@$searchedData['location'])){
                    if($searchedData['location'] == 'PK'){
                      echo 'checked';
                    }
                  }else{
                    echo 'checked';
                  }

                   ?>>&nbsp;Pak Lister
                  <input type="radio" name="location" value="US" 
                  <?php 
                  if(!empty(@$searchedData['location'])){
                    if($searchedData['location'] == 'US'){
                      echo 'checked';
                    }
                  }
                   ?>>&nbsp;US Lister
                  <input type="radio" name="location" value="ALL" 
                  <?php 
                  if(!empty(@$searchedData['location'])){
                    if($searchedData['location'] == 'ALL'){
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
             <!--  </form> -->
              <div class="col-sm-2">
                <div class="form-group">
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>dekitting_pk_us/c_dekit_audit/dekitAudit">Dekit Audit</a>

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
              <?php  @$audit_bin_id = $this->session->userdata("audit_bin_id");?>
              <input type="text" name="audit_bin_id" id="audit_bin_id" class="form-control" value="<?php if($audit_bin_id){echo $audit_bin_id;} ?>">
            </div>
          </div>
        </div> 

        <div class="col-md-12">
          <table id="autolistedItems" class="table table-bordered table-striped listedItems" >
            <thead>
              <tr>
                <th>ACTION</th>
                <th>PICTURE</th>
                <th>EBAY ID</th>
                <th>LISTED BARCODE</th>
                <th>CONDITION</th>
                <th>TITLE</th>
                <th>LIST QTY</th>
                <th>LIST PRICE</th>
                <th>SHIP SERVICE</th>
                <th>WEIGHT</th>
                <th>LISTER NAME</th>
                <th>LISTING TIME &amp; DATE</th>
                <th>MPN</th>
                <th>MANUFACTURE</th>
                <th>BIN NAME</th>
                <th>ACCOUNT</th>
                <th>STATUS</th>
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

<!-- price modal -->
<div id="price-modal" class="modal modal-info fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sale Price Calculation</h4>
      </div>
      <div class="modal-body">
        <section class="" style="height: 40px !important;"> 
          <div class="col-sm-12" >
            <div class="col-sm-6 col-sm-offset-3" id="errorMessage"></div>
          </div>
        </section>

                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">Sale Price Calculation</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body ">
                          <div class="col-sm-12 ">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="item cost" style = "color: black!important;">Item Cost:</label>
                                <input name="item_cost" type="text" id="item_cost" class="item_cost form-control " readonly>
                            </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="ebay fee" style = "color: black!important;">eBay Fee %:</label>
                                <input name="ebay_fee" type="text" id="ebay_fee" class="ebay_fee form-control " readonly>
                              </div>
                            </div> 
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="paypal fee" style = "color: black!important;">Paypal Fee %:</label>
                                <input name="paypal_fee" type="text" id="paypal_fee" class="paypal_fee form-control" readonly >
                              </div>
                            </div>  
                            <div class="col-sm-3">
                              <label for="ship fee" style = "color: black!important;">Shipping Fee :</label>
                              <div class="form-group" >
                              <input name="ship_fee" type="text" id="ship_fee" class="ship_fee form-control " readonly>
                              </div>
                            </div> 
                          </div> <!-- nested col-sm-12 div close--> 
                          <div class="col-sm-12 "> 
                            <div class="col-sm-3">
                              <label for="profit" style = "color: black!important;">Profit % :</label>
                              <div class="form-group" >
                              <input name="profit_perc" type="text" id="profit_perc" class="profit_perc form-control " readonly>
                              </div>
                            </div> 
                            <div class="col-sm-3">
                              <label for="profit" style = "color: black!important;">Sale Price:</label>
                              <div class="form-group" >
                              <input name="sale_price" type="text" id="sale_price" class="sale_price form-control " readonly>
                              </div>
                            </div> 
                             
                                              
                          </div> <!-- nested col-sm-12 div close-->
                          <div class="col-sm-12">
                            <div class="col-sm-12" style = "color: black!important;">
                              <label for="profit" >Formula:</label>
                              <div class="form-group" >
                              Selling Expense = 1 - (eBay Fee / 100) + (Paypal Fee / 100) + (Profit / 100)
                              <br><br>
                               Sale Price  = (Item Cost + Ship Fee) / Selling Expense;

                              </div>
                            </div> 
                          </div>

                        </div> <!-- box body div close-->
                      </div> 
                    </div><!--box body close -->
                      </div>
                    </div>
                </section>
      </div><!-- modal body close -->
      <div class="modal-footer">
        <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      </div>
            
    </div><!-- modal contant close -->
  </div><!-- modal dilog close -->

</div> <!-- modal  close -->
<!-- end price modal -->

 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
$(document).ready(function(){
  var search_location = '';
  var search_date     = '';
   $("#autolistedItems").dataTable().fnDestroy();
      search_location = $("input[name='location']:checked").val();
      search_date     = $("#date_range").val();
    $("#autolistedItems").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
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
      url :"<?php echo base_url().'autoList/c_autolist/loadautoListedAudit'?>", // json datasource
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
      ]      
    });

    var search_location = '';
    var search_date     = '';
    /////////////////////////////////
    $(document).on('click', "#search_lister", function(e){
      e.preventDefault();
      $("#autolistedItems").dataTable().fnDestroy();
      search_location = $("input[name='location']:checked").val();
      search_date     = $("#date_range").val();
    $("#autolistedItems").DataTable({
    "oLanguage": {
    "sInfo": "Total Items: _TOTAL_"
    },
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
      url :"<?php echo base_url().'autoList/c_autolist/loadautoListedAudit'?>", // json datasource
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
      ]      
    });
  });
});
/*=====================================================
=            update keyword modal function            =
=====================================================*/


$(document).on('click','.getPriceDetail',function(){
  var row = $(this).closest("tr");
  var tds = row.find("td");
  var weight = tds[9].innerText;
  var shipService = tds[8].innerText;
  var salePrice = tds[7].innerText.replace(/\$/g, '').replace(/\ /g, '');
  var itemId = this.id;
  var manifestId =  $(this).attr("manifestId");
  
//console.log(salePrice);return false;
  
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>autolist/c_autolist/getPriceDetail', 
        type: 'post',
        dataType: 'json',
        data : {'itemId':itemId,'manifestId':manifestId,'shipService':shipService,'weight':weight,'salePrice':salePrice},
        success:function(data){
          //console.log(data.ebayFee);return false;
          $('#price-modal').modal('show');
          $(".loader").hide();
         
              $('#item_cost').val("");
              $('#item_cost').val('$'+data.itemCost);

              $('#ebay_fee').val("");
              $('#ebay_fee').val(data.ebayFee+'%');

              $('#paypal_fee').val("");
              $('#paypal_fee').val(data.paypalFee+'%');

              $('#ship_fee').val("");
              $('#ship_fee').val('$'+data.shipFee);

              $('#profit_perc').val("");
              $('#profit_perc').val(data.profit);
               // var sell_exp = (data.ebayFee / 100 ) + (data.paypalFee / 100 ) + (data.profit / 100 );

              $('#sale_price').val("");
              $('#sale_price').val('$'+salePrice);
          
        }
    });
  
  // alert(category_id);
});


/*=====  End of update keyword modal function  ======*/
</script>