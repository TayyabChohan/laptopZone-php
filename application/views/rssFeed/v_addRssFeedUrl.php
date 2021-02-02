<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">RSS Feed Url's</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->      
    <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-sm-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title col-sm-3 pull-left">RSS Feed Url's</h3>
                <div class="col-sm-5 col-sm-offset-1 pull-left" id="successMessage"></div>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>              
              </div>
              <div class="box-body">
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Feed Name">Feed Name:</label>
                      <input name="feedName" type="text" id="feedName" class="feedName form-control " >
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Key Word">Keyword :</label>
                      <input name="keyWord" type="text" id="keyWord" class="keyWord form-control " >
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Key Word">Exculde Words :</label>
                      <input name="excludedWords" type="text" id="excludedWords" class="excludedWords form-control" placeholder="Enter Comma Seprated Words" >
                    </div>
                  </div>   
                 <!--  <div class="col-sm-3">
                    <label for="Category ID">Category ID :</label>
                    <div class="form-group" >
                      <select name="category_id" id="category_id" class="selectpicker form-control" data-live-search="true">
                        <option value=""></option>
                        <?php //foreach (@$data as $row): ?>
                          <option value="<?php //echo @$row['CATEGORY_ID'];?>"><?php //echo @$row['CATEGORY_ID'].'-'.@$row['CATEGORY_NAME'];?></option>
                        <?php //endforeach;?>

                      </select>
                    </div>
                  </div>  -->
                  <div class="col-sm-3">
                    <label for="Category ID">Category ID :</label>
                    <div class="form-group">
                      <div id="combobox">

                      </div> 
                    </div>
                  </div>
                  <div class="col-sm-2" >
                    <label for="Mpn">Mpn :</label>
                    <div class="form-group" id="mpnData">
                      
                      <select name="mpn" id="mpn" class="selectpicker form-control" data-live-search="true">
                        <option value=""></option>

                      </select>
                    </div>
                  </div> 
                <div class="col-sm-1 p-t-24">
                    <div class="form-group">
                      <input type="button" class="btn btn-primary btn-sm" id="addMpn" name="addMpn" value="ADD MPN">                      
                    </div>

                  </div>                                    
                </div> <!-- nested col-sm-12 div close-->
                <div class="col-sm-12">
                  
                <div class="col-sm-3">
                      <div class="form-group">
                        <label for="Condition">Condition:</label>
                          <select class="selectpicker form-control rss_feed_cond" multiple data-actions-box="true" data-live-search="true"   name="rss_feed_cond[]" id="rss_feed_cond" multiple>

                            <?php                                 
                              foreach(@$conditions as $cond) {
                              if ($cond['ID'] == 3000) {
                                  $selected = "selected";
                               }else{
                                $selected = "";
                               } 
                              ?>
                                <option value="<?php echo $cond['ID']; ?>" <?php echo $selected; ?>><?php echo $cond['COND_NAME']; ?></option>
                              <?php
                                  } 
                               ?> 
                               <option value="0">All</option>                    
                          </select> 
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                        <label for="Listing Type">Listing Type:</label>
                          <select class="form-control  rss_listing_type"   name="rss_listing_type" id="rss_listing_type">
                               <option value="BIN" selected> BIN</option>
                               <option value="Auction"> Auction</option>
                               <option value="All"> All</option>                    
                          </select> 
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                        <label for="Within">Within:</label>
                          <select name="withIn" id="withIn" class="form-control">
                            <option value="0">Select</option>
                            <option value="2">2 miles</option>
                            <option value="5">5 miles</option>
                            <option value="10">10 miles</option>
                            <option value="15">15 miles</option>
                            <option value="25">25 miles</option>
                            <option value="50">50 miles</option>
                            <option value="75">75 miles</option>
                            <option value="100">100 miles</option>
                            <option value="150">150 miles</option>
                            <option value="200">200 miles</option>
                            <option value="500">500 miles</option>
                            <option value="750">750 miles</option>
                            <option value="1000">1000 miles</option>
                            <option value="1500">1500 miles</option>
                            <option value="2000">2000 miles</option>
                          </select>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                    <label for="zipCode">Zip Code:</label>
                      <input class="form-control" size="6" maxlength="13" name="zipCode" id="zipCode" data-placeholder="Zip code" value="" type="text">
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Price">Price :</label>
                      <input name="rss_price" type="text" id="rss_price" class="rss_price form-control " readonly>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Price">Qty Sold :</label>
                      <input name="qty_sold" type="text" id="qty_sold" class="form-control " readonly>
                    </div>
                  </div>
                  <div class="col-sm-3">                  
                    <div class="form-group">
                    <label for="Feedback Score">Price Range:</label>
                    <div class="input-group" >
                    <input type="number" step="0.01" min="0" name ="min_price" id="min_price" class="form-control clear" value=""  />
                    <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                    <input type="number" step="0.01" min="0" name ="max_price" id="max_price" class="form-control clear" value="" />
                    </div>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="seller_filter">Seller Filter:</label>
                        <select name="seller_filter" id="seller_filter" class="form-control">
                          <option value="0">Select</option>
                          <option value="1">Include</option>
                          <option value="2">Exclude</option>
                          
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="seller_name">Seller Name :</label>
                      <input name="seller_name" type="text" id="seller_name" class="form-control " placeholder="Enter Comma Seprated seller's" >
                    </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                        <label for="feed Type">Feed Type:</label>
                          <select class="form-control  rss_feed_type"   name="rss_feed_type" id="rss_feed_type">
                               <option value="0"> Select</option>
                               <option value="30">Lookup</option>
                               <option value="32">Local | Dallas </option> 
                               <option value="33">Category Feed</option>                    
                          </select> 
                      </div>
                  </div>
                   <div class="col-sm-1 p-t-24">
                    <div class="form-group">
                      <input type="button" class="btn btn-primary btn-sm pull-left" id="addUrl" name="addUrl" value="ADD URL">                      
                    </div>

                  </div> 
              </div> <!-- box body div close-->
              <div class="col-sm-12">
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="button" class="btn btn-success btn-sm" id="runAllFeed" name="runAllFeed" value="Run All Feed">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="button" class="btn btn-warning btn-sm" id="stopAllFeed" name="stopAllFeed" value="Stop All Feed">
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <input type="button" class="btn btn-primary btn-sm" id="hotSellingItem" name="hotSellingItem" value="Hot Selling Item">
                  </div>
                </div>
                  
              </div>
            </div>
          </div> <!-- col-sm-12 div close-->
          <!-- add mpn block start -->
          <div class="box" id="add_mpn_section" style="display: none;">
            <div class="box-header with-border">
              <h3 class="box-title">Add MPN</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-sm-12">
              <!-- <form action="<?php //echo base_url(); ?>catalogue/c_itemCatalogue/getCategorySpecifics" method="post" accept-charset="utf-8"> -->
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Category" class="control-label">CATEGORY:</label>
                    <input class="form-control" type="text" name="mpn_category" id="mpn_category" value="" readonly required> 
                  </div>
                </div>
                 <div class="col-sm-4">
                     <div class="form-group" id="cataObject">
                        <label for="Conditions" class="control-label">OBJECT:</label>
                       <input class="form-control" type="text" name="mpn_object" id="mpn_object" value="" required>  
                        
                      </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="MPN BRAND">BRAND:</label>
                      <input class="form-control" type="text" name="mpn_brand" id="mpn_brand" value="" required>
                    </div>
                  </div>
                </div>                
                  <!--   </form> -->
                <div class="col-sm-12" style="margin-top: 15px;">

                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="MPN">MPN:</label>
                      <input class="form-control" type="text" name="mpn_input" id="mpn_input" value="" required>
                    </div>
                  </div>
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="UPC">UPC:</label>
                        <input type="text" class="form-control" name="lot_upc" id="lot_upc" value="">
                      </div>
                    </div>                  
                  <div class="col-sm-6">
                    <div class="form-group">
                      
                      <!-- <input class="form-control" type="text" name="mpn_description" id="mpn_description" value="" required> -->
                      <span>
                        <label for="MPN">MPN DESCRIPTION : </label>Maximum of 80 characters - 
                          <span id="charNum" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left</span><br/>
                          <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onkeyup="countChar(this)" value="" style="width: 540px;">
                    </div>
                  </div> 
                  
                  <div class="col-sm-1">
                    <div class="form-group p-t-26">
                      <input type="button" id="save_mpn" name="save_mpn" value="Save" class="btn btn-success">
                    </div>
                  </div>
                </div> 
              
            </div>
          </div>
          <!-- add mpn block end -->
          <!-- hot selling item block start -->
          <div class="box" id="hot_selling_section" style="display: none;">
            <div class="box-header with-border">
              <h3 class="box-title">Hot Selling Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-sm-12">
                <table id="hot_selling_table" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                      <th>ACTION</th>
                      <th>CATEGORY ID</th>
                      <th>MPN</th>
                      <th>MPN DESCRIPTION</th>
                      <th>CONDITION</th>
                      <th>ACTIVE AVG</th>
                      <th>ACTIVE QTY</th>
                      <th>SOLD AVG</th>
                      <th>SOLD QTY</th>
                    </tr>
                  </thead>
                </table>
              
              </div>
            </div>
          <!-- hot selling item block end -->
          </div><!-- row div close-->
          
        <div class="row">
          <div class="col-sm-12">
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">RSS Feed Url Details</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>              
              </div>
              <div class="box-body form-scroll">
                <div class="col-sm-12" id>
                  <table id="rssFeedTable" class="table table-bordered table-striped  table-hover">
                    <thead>
                          <th>ACTION</th>
                          <th>FEED NAME</th>
                          <th>KEYWORD</th>
                          <th>CATEGORY ID</th>
                          <th>CATEGORY NAME</th>
                          <th>CONDITION</th>
                          <th>MIN PRICE</th>
                          <th>MAX PRICE</th>
                          <th>LISTING TYPE</th>
                    </thead>
                    <tbody>
                      
                    </tbody> 
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
          <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
      </div>
    </section>
  </div>

<div id="warning-modal" class="modal modal-warning fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p id="warning_info"> </p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
        <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>         

      </div>
            
    </div>
  </div>

</div> 
<!-- err msg modal -->
<div id="danger-modal" class="modal modal-danger fade" role="dialog" >
  <div class="modal-dialog" >
    <!-- Modal content-->
    <div class="modal-content"  >
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Info</h4>
      </div>
      <div class="modal-body" style="height: 80px !important;">
        <section class="" style="height: 70px !important;"> 
          <p id="danger_info"> </p>         
          <input type="hidden" id="del_value" value="">
        </section>                  
      </div>
      <div class="modal-footer">
        <button type="button" id="closeWarning" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      </div>
            
    </div>
  </div>

</div> 
<!-- end error msg modal -->

<!-- Modal -->
<div id="UpdateKeyword" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Details</h4>
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
                          <h1 class="box-title" style="color:white;">Feed URL Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body ">
                          <div class="col-sm-12 ">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Feed Name" style = "color: black!important;">Feed Name:</label>
                                <input name="feed_Name" type="text" id="feed_Name" class="feed_Name form-control " >
                                <input name="feedurlid" type="hidden" id="feedurlid" class="feedurlid form-control " >
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="Key Word" style = "color: black!important;">Keyword :</label>
                                <input name="key_Word" type="text" id="key_Word" class="key_Word form-control " >
                              </div>
                            </div> 
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label for="Exclude Word" style = "color: black!important;">Exclude Words :</label>
                                <input name="exclude_Word" type="text" id="exclude_Word" class="exclude_Word form-control" placeholder="Enter comma seprated words" >
                              </div>
                            </div>  
                            <div class="col-sm-2">
                              <label for="Category ID" style = "color: black!important;">Category ID :</label>
                              <div class="form-group" >
                              <input name="categoryId" type="text" id="categoryId" class="category_id form-control " readonly>
                              </div>
                            </div> 
                             
                                              
                          </div> <!-- nested col-sm-12 div close-->
                          <div class="col-sm-12">
                            <div class="col-sm-3" >
                              <label for="Mpn" style = "color: black!important;">Mpn :</label>
                              <div class="form-group" id="mpnData">
                                <input name="feed_mpn" type="text" id="feed_mpn" class="feed_mpn form-control " readonly>
                                <input name="catalogue_mt_id" type="hidden" id="catalogue_mt_id" class="catalogue_mt_id form-control " readonly>

                              </div>
                            </div>
                            <div class="col-sm-3">
                            <div class="form-group">
                              <label for="Condition" style = "color: black!important;">Condition:</label>
                                <select class="form-control  feed_cond_update"   name="feed_cond_update" id="feed_cond_update">
                                                      
                                </select> 
                                <!-- <input name="condition_id" type="text" id="condition_id" class="condition_id form-control " readonly> -->
                            </div>
                          </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                  <label for="Listing Type" style = "color: black!important;">Listing Type:</label>
                                    <select class="form-control  rss_listing_type_update"   name="rss_listing_type_update" id="rss_listing_type_update">
                                         <option value="BIN" selected> BIN</option>
                                         <option value="Auction"> Auction</option>
                                         <option value="All"> All</option>                    
                                    </select> 
                                    <!-- <input name="listing_type" type="text" id="listing_type" class="listing_type form-control " readonly> -->
                                </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                                <label for="Within Update" style = "color: black!important;">Within:</label>
                                <div id="withinappend"></div>
                                
                              </div>
                            </div>
                            <div class="col-sm-2">
                              <div class="form-group">
                              <label for="zipCode Update" style = "color: black!important;">Zip Code:</label>
                                <input class="form-control" size="6" maxlength="13" name="zipCodeUpdate" id="zipCodeUpdate" data-placeholder="Zip code" value="" type="text" readonly="">
                              </div>
                            </div>      
                        </div> <!-- box body div close-->
                        <div class="col-sm-12">
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="Seller Filter Update" style = "color: black!important;">Seller Filter:</label>
                                <select name="seller_filter_update" id="seller_filter_update" class="form-control">
                                  
                                </select>
                            </div>
                          </div>
                          
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="Seller Name Update" style = "color: black!important;">Seller Name :</label>
                              <input name="seller_name_update" type="text" id="seller_name_update" class="form-control " placeholder="Enter Comma Seprated seller's" readonly="">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="feed Type" style = "color: black!important;">Feed Type:</label>
                                <select class="form-control  rss_feed_type_update" name="rss_feed_type_update" id="rss_feed_type_update">                    
                                </select> 
                            </div>
                        </div>
                            <div class="col-sm-4">                  
                              <div class="form-group">
                                <label for="Feedback Score" style = "color: black!important;">Price Range:</label>
                              <div class="input-group" >
                                <input type="number" step="0.01" min="0" name ="minPriceUpdate" id="minPriceUpdate" class="form-control clear" value=""  />
                              <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                                <input type="number" step="0.01" min="0" name ="maxPriceUpdate" id="maxPriceUpdate" class="form-control clear" value="" />
                              </div>
                              </div>
                            </div>
                             <div class="col-sm-1 pull-right p-t-24">
                              <div class="form-group">
                                <input type="button" class="btn btn-primary btn-sm" id="updateUrl" name="updateUrl" value="UPDATE">
                              </div>
                            </div> 
                        </div> <!-- box body div close-->
                      </div> 
                    </div><!--box body close -->
                      </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->
<?php $this->load->view('template/footer'); ?>
<script>
/*====================================
=      Text counter start           =
====================================*/
  function countChar(val) {
    var len = val.value.length;
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(80 - len);
    }
  }
/*=====  End of Text counter  ======*/
  $(document).ready(function(){

    $("#rssFeedTable").dataTable().fnDestroy();
    $("#rssFeedTable").DataTable({
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
      url :"<?php echo base_url().'rssFeed/c_rssfeed/loadAddRssFeedUrl'?>", // json datasource
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
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
 
/*--- Onchange Mpn get its Objects start---*/
/*$("#pic_val").on('click',  function(){
         var check_val = $(".jqx-combobox-input").val();
         alert(check_val);
       });*/
/*--- Onchange Mpn get its Objects start---*/
  $(document).on('change', "#mpn", function(){
    
    var mpn = $("#mpn").val();

    var rss_feed_cond = $("#rss_feed_cond").val();
    //alert(mpn+'-'+rss_feed_cond); return false;
    if(rss_feed_cond == 0 || mpn ==''){
      return false;
    }else{
          $(".loader").show();
          $.ajax({
            dataType: 'json',
            type: 'POST',
            url:'<?php echo base_url(); ?>rssFeed/c_rssfeed/getMpnPrice',
            data: {'mpn' : mpn, 'rss_feed_cond' : rss_feed_cond},
            success: function (data) {
              $(".loader").hide();
              if (data.length > 0) {
                //console.log(data); return false;
                //console.log(data);
                $("#rss_price").val('');
                $("#qty_sold").val('');
                var average_price =  data[0].AVG_PRICE;
                var sold_qty      =  data[0].QTY_SOLD;
                if (average_price !=null || average_price != "") {
                  $("#rss_price").val(average_price);
                }else{
                  $("#rss_price").val('');
                }

                if (sold_qty !=null || sold_qty != "") {
                  $("#qty_sold").val(sold_qty);
                }else{
                  $("#qty_sold").val('');
                }
              }
            },
            complete: function(data){
              $(".loader").hide();
            },
            error: function(jqXHR, textStatus, errorThrown){
              $(".loader").hide();
              if (jqXHR.status){
                  alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
                }
            }

          });
    }//end condition check if else


  });
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue         =
  ================================================================*/

  /*============================================================
  =            on condition change update AVG price            =
  ============================================================*/
  $(document).on('change', "#rss_feed_cond", function(){
    
    var mpn = $("#mpn").val();

    var rss_feed_cond = $("#rss_feed_cond").val();
    //alert(mpn+'-'+rss_feed_cond); return false;
    if(rss_feed_cond == 0 || mpn ==''){
      return false;
    }else{
        $(".loader").show();
        $.ajax({
          dataType: 'json',
          type: 'POST',
          url:'<?php echo base_url(); ?>rssFeed/c_rssfeed/getMpnPrice',
          data: {'mpn' : mpn, 'rss_feed_cond' : rss_feed_cond},
          success: function (data) {
            $(".loader").hide();
            //console.log(data); return false;
          //console.log(data);
          $("#rss_price").val('');
          $("#qty_sold").val('');
          $("#rss_price").val(data[0].AVG_PRICE);
          $("#qty_sold").val(data[0].QTY_SOLD);
          },
          complete: function(data){
            $(".loader").hide();
          },
          error: function(jqXHR, textStatus, errorThrown){
            $(".loader").hide();
            if (jqXHR.status){
                alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
              }
          }

        });
      }//end condition check if else

  });
  
  
  /*=====  End of on condition change update AVG price  ======*/
  
  });// ready function close

  $(document).on('focusout',".jqx-combobox-input", function(){
    //alert('sdasdf'); return false;
    var category_id = $(".jqx-combobox-input").val();
    //alert(category_id); return false;
    $("#mpn_category").val(category_id);
    $(".loader").show();
    $.ajax({
      url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/getMpns', 
      type: 'post',
      dataType: 'json',
      data : {'category_id':category_id},
      success:function(data){
        $(".loader").hide();
        var mpns = [];

        for(var i=0;i<data.length;i++){
          mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');

        }
        
        $('#mpnData').html("");
        $('#mpnData').append('<select name="mpn" id="mpn" class="selectDropdown form-control" data-live-search="true"><option value="">-----</option> '+mpns.join("")+' </select>'); 
        $('.selectDropdown').selectpicker();
      },
      complete: function(data){
        $(".loader").hide();
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
         
        if (jqXHR.status){
          $('#danger-modal').modal('show');
          // alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          $('#danger_info').text(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
      }
    });
  });
/*==============================================
=            add mpn click function            =
==============================================*/
   $(document).on('click', '#addMpn', function(event) {
     event.preventDefault();
     
     $("#add_mpn_section").show();
     var category_id = $("#category_id").val();
      $("#mpn_category").val(category_id);
     
              $("#mpn_object").focus();
              return false;
   });


/*=====  End of add mpn click function  ======*/
/*=========================================
=            save mpn function            =
=========================================*/
$(document).on('click', '#save_mpn', function(event) {
     event.preventDefault();
      var category_id =   $("#mpn_category").val();
      var mpn_object = $("#mpn_object").val();
      var mpn_brand = $("#mpn_brand").val();
      var mpn_input = $("#mpn_input").val();
      var lot_upc = $("#lot_upc").val();
      var mpn_description = $("#mpn_description").val();
      
      if(category_id.trim() == '' || mpn_object.trim() == '' || mpn_brand.trim() == '' || mpn_input.trim() == '' || mpn_description.trim() == ''){
        alert('ALL Field Are Required');
        return false;
      }
     var url = '<?php echo base_url();?>rssFeed/c_rssFeed/saveMpn';
     $(".loader").show();
     $.ajax({
       url: url,
       type: 'POST',
       dataType: 'json',
       data: {'category_id': category_id ,  'mpn_object': mpn_object, 'mpn_brand':mpn_brand, 'mpn_input':mpn_input, 'mpn_description':mpn_description, 'lot_upc':lot_upc},
        success:function(data){
            if (data !='') {
              $(".loader").hide();
              // $("#mpn_category").val(category_id);
              // $("#master_mpn").val(data[0].MPN);
              // $("#master_mpn_id").val(data[0].CATALOGUE_MT_ID);
              // $("#mpn_brand").val(data[0].BRAND);
              // $("#mpn_object").val(object_name);
              // $("#mpn_object_id").val(object_id);
              $("#add_mpn_section").hide();
              $("#mpn").focus();
            }
             
          },
          complete: function(data){
              $(".loader").hide();
            },
            error: function(jqXHR, textStatus, errorThrown){
               $(".loader").hide();
              if (jqXHR.status){
                alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
              }
            }
     })
   });


/*=====  End of save mpn function  ======*/

  $('#addUrl').on('click',function(){
    var feedName = $('#feedName').val();
    if(feedName.trim() == ''){
      $('#warning-modal').modal('show');
      $('#warning_info').text('Please Insert Feed Name');
      $('#feedName').focus();
      return false;
    }
    var keyword = $('#keyWord').val();
    // if(keyword.trim() == ''){
    //   $('#warning-modal').modal('show');
    //   $('#warning_info').text('Please Insert Keyword');
    //   $('#keyWord').focus();
    //   return false;
    // }
    var category_id = $(".jqx-combobox-input").val();
        
    //console.log(category_id); return false;
    if(category_id.trim() == ''){
      $('#warning-modal').modal('show');
      $('#warning_info').text('Please select Category ID First');
      $('#category_id').focus();
      return false;
    }else if (isNaN(parseInt(category_id, 10))) {
        $('#warning-modal').modal('show');
        $('#warning_info').text('Warning: Please Insert Numeric Value');
        $('#category_id').focus();
        return false;
      }
    var catalogue_mt_id = $('#mpn').val();
    // if(catalogue_mt_id.trim() == ''){
    //   $('#warning-modal').modal('show');
    //   $('#warning_info').text('Please select MPN First');
    //   $('#mpn').focus();
    //   return false;
    // }
    var rss_feed_cond = $('#rss_feed_cond').val();
    //console.log(rss_feed_cond); 
    //return false;
    if(rss_feed_cond == null){
      $('#warning-modal').modal('show');
      $('#warning_info').text('Please select Condition First');
      $('#rss_feed_cond').focus();
      return false;
    }
    var rss_listing_type = $('#rss_listing_type').val();
    if(rss_listing_type.trim() == ''){
      $('#warning-modal').modal('show');
      $('#warning_info').text('Please select Listing Type First');
      $('#rss_listing_type').focus();
      return false;
    } 
    var feed_type = $('#rss_feed_type').val();
    if(feed_type.trim() == '0'){
      $('#warning-modal').modal('show');
      $('#warning_info').text('Please select Feed Type First');
      $('#rss_feed_type').focus();
      return false;
    }
    var min_price = $('#min_price').val();
    // if(min_price.trim() == ''){
    //   $('#warning-modal').modal('show');
    //   $('#warning_info').text('Please insert Min Price First');
    //   $('#min_price').focus();
    //   return false;
    // }
    var max_price = $('#max_price').val();
    // if(max_price.trim() == ''){
    //   $('#warning-modal').modal('show');
    //   $('#warning_info').text('Please insert Max Price First');
    //   $('#max_price').focus();
    //   return false;
    // }
    var excludedWords = $('#excludedWords').val();
    var zipCode = $('#zipCode').val();
    var withIn = $('#withIn').val();
    var seller_filter = $('#seller_filter').val();
    var seller_name = $('#seller_name').val();
    //console.log(seller_filter,seller_name);return false;
    //alert(catalogue_mt_id);

    // if(catalogue_mt_id=='' && category_id=='' && keyword == ''){
    //   // alert(keyword);
    //   $('#warning-modal').modal('show');
    //   $('#warning_info').text('Please Insert any of Three Fields : KeyWord OR Category_ID OR MPN');
    //   return false;
    // }else{
      $(".loader").show();
        $.ajax({
          url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/addRssUrls', 
          type: 'post',
          dataType: 'json',
          data : {
          'feedName':feedName, 
          'keyword':keyword,
          'excludedWords': excludedWords, 
          'category_id':category_id,
          'catalogue_mt_id':catalogue_mt_id,
          'rss_feed_cond':rss_feed_cond,
          'rss_listing_type':rss_listing_type,
          'min_price':min_price,
          'max_price':max_price,
          'zipCode':zipCode,
          'withIn':withIn,
          'seller_filter':seller_filter,
          'seller_name':seller_name,
          'feed_type':feed_type

        },
        success: function(data){
            //dataTable.destroy();
            if (data == 1) {
              $('#successMessage').html("");
              $('#successMessage').append('<p style="color:green; background-color:#eee; padding:10px; border-radius:2px;"><strong>Success: Url added Successfully!</strong></p>');
              $('#successMessage').show();
              setTimeout(function() {
              $('#successMessage').fadeOut('slow');
              }, 3000);
            }
            $.ajax({
              url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/updateRssUrls', 
              type: 'post',
              dataType: 'json',
              success: function(result){
                $(".loader").hide();
                var t = $('#rssFeedTable').DataTable();
                //var counter = 1;

                //$('#addRow').on( 'click', function () {
                    t.row.add( [
                        '<button title="Delete" class="btn btn-danger btn-xs " style="" id="'+result[0].FEED_URL_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button><button title="Run Feed" class="btn btn-primary btn-xs runFeed" style="" id="'+result[0].FEED_URL_ID+'"><i class="fa fa-download" aria-hidden="true"></i></button>',
                        result[0].FEED_NAME ,
                        result[0].KEYWORD ,
                        result[0].CATEGORY_ID ,
                        result[0].CATEGORY_NAME ,
                        result[0].COND_NAME ,
                        result[0].MIN_PRICE ,
                        result[0].MAX_PRICE ,
                        result[0].LISTING_TYPE 
                    ] ).draw( false );
                    $(".loader").hide();

                   // counter++;
               // } );

                // var rssUrls = [];

                // for(var i = 0;i<result.length;i++){
                //   rssUrls.push('<tr><td > <button title="Delete" class="btn btn-danger btn-xs " style="" id="'+result[i].FEED_URL_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button>  </td> <td>'+result[i].FEED_NAME+'</td> <td>'+result[i].CATEGORY_ID+'</td> <td>'+result[i].CATEGORY_NAME+'</td> <td>'+result[i].COND_NAME+'</td><td>'+result[i].MIN_PRICE+'</td><td>'+result[i].MAX_PRICE+'</td><td>'+result[i].LISTING_TYPE+'</td></tr>') ;
                // }
                // $("#rssFeedTable").html("");
                // $("#rssFeedTable ").append('<thead> <tr> <th>ACTION</th> <th>CATEGORY_NAME</th> <th>CATEGORY_ID</th> <th>CONDITION</th> <th>RSS FEED URL</th> </tr> </thead> <tbody>'+rssUrls.join("")+'</tbody>');

                // dataTable = $("#rssFeedTable").DataTable({
                //   "oLanguage": {
                //   "sInfo": "Total Items: _TOTAL_"
                // },
                //   // "aaSorting": [[12,'desc'],[11,'desc']],
                //   //"order": [[ 10, "desc" ]],
                //   "paging": true,
                //   "iDisplayLength": 200,
                //   "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
                //   "lengthChange": true,
                //   "searching": true,
                //   "ordering": true,
                //   "info": true,
                //   "autoWidth": true,
                //   "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
                // });
              }//success function close

            });
  

          }
      });
    //}//else close;

  });
/*===============================================
=            80 chrecter limit check            =
===============================================*/
function textCounter(field,cnt, maxlimit) {         
      var cntfield = document.getElementById(cnt);

         if (field.value.length > maxlimit){ // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
        }else{
       cntfield.value = parseInt(parseInt(maxlimit) - parseInt(field.value.length));
     }
    }


/*=====  End of 80 chrecter limit check  ======*/

/*===============================================
=   Run batch file on click            =
===============================================*/
 $('.runFeed').on('click', function(){ 
    var feedId = this.id;
    var loc = "<?php echo __DIR__; ?>";
    var wamp_check = loc.search("wamp64");
    if(wamp_check > 0){
      wamp_name = 'wamp64';
    }else{
       wamp_name = 'wamp';
    }
    WshShell = new ActiveXObject("WScript.Shell");
    var path = loc[0]+':/'+wamp_name+'/www/laptopzone/liveRssFeed/lookupFeed/'+feedId+'.bat';
    WshShell.run(path);

});


/*=====End Run batch file on click  ======*/
/*===============================================
=   Run all feed on click            =
===============================================*/
 $('#runAllFeed').on('click', function(){ 
   // var feedId = this.id;
    var loc = "<?php echo __DIR__; ?>";
    var wamp_check = loc.search("wamp64");
    if(wamp_check > 0){
      wamp_name = 'wamp64';
    }else{
       wamp_name = 'wamp';
    }
    WshShell = new ActiveXObject("WScript.Shell");
    var path = loc[0]+':/'+wamp_name+'/www/laptopzone/runAllLookupFeed.bat';
    WshShell.run(path);

});

/*=====End Run all feed on click  ======*/  
/*===============================================
=   stop all feed on click            =
===============================================*/
 $('#stopAllFeed').on('click', function(){ 
   // var feedId = this.id;
    var loc = "<?php echo __DIR__; ?>";
    var wamp_check = loc.search("wamp64");
    if(wamp_check > 0){
      wamp_name = 'wamp64';
    }else{
       wamp_name = 'wamp';
    }
    WshShell = new ActiveXObject("WScript.Shell");
    var path = loc[0]+':/'+wamp_name+'/www/laptopzone/stopAllLookupFeed.bat';
    WshShell.run(path);

});

/*=====End stop all feed on click  ======*/

/*==============================================
=            hot selling call            =
==============================================*/
 var hot_selling_table = '';
  $("#hotSellingItem").on('click',function(){
    var categoryId = $("#category_id").val();
    $("#hot_selling_section").show();
   //console.log(data_source,data_status);return false;
   
if(hot_selling_table !=''){
      hot_selling_table.destroy();
    }
  hot_selling_table = $('#hot_selling_table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200,500, 5000, -1], [25, 50, 100, 200,500, 5000, "All"]],
       "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      "aaSorting": [[8,'desc']], // sort on sold Qty desc
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
      "ajax":{
        data:{'categoryId':categoryId},
        url :"<?php echo base_url() ?>rssFeed/c_rssFeed/hotSellingItem", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
      "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

  });

  });
/*=====  End of hot selling call  ======*/  

/*=========================================
=            create rss url function            =
=========================================*/
$(document).on('click', '.create_rss', function(event) {
     event.preventDefault();
     var index = $(this).attr("name");
     var table = $('#hot_selling_table').DataTable();
     var row = table.row(index-1).data();
      
      var catalogue_mt_id = $(this).attr("id");
      var category_id =   row[1];
      var mpn = row[2];
      var condition_id = row[4];
      var active_avg = row[5];
      var active_qty = row[6];
      var sold_avg = row[7].replace(/\$/g, '').replace(/\ /g, '');
      var sold_qty = row[8];
      var min_price = 1;
      var max_price = ((parseFloat(sold_avg) / 100) * 60).toFixed(2);
      //max_price = max_price.toFixed(2)
      //console.log (max_price,sold_avg,parseFloat(sold_avg));return false;
      
      
      // if(category_id.trim() == '' || mpn_object.trim() == '' || mpn_brand.trim() == '' || mpn_input.trim() == '' || mpn_description.trim() == ''){
      //   alert('');
      //   return false;
      // }
     var url = '<?php echo base_url();?>rssFeed/c_rssFeed/checkFeed';
     $(".loader").show();
     $.ajax({
       url: url,
       type: 'POST',
       dataType: 'json',
       data: {'catalogue_mt_id': catalogue_mt_id },
        success:function(data){
            if (data !='') {
              $(".loader").hide();
               $("#feedName").val(data[0].FEED_NAME);
               $("#keyWord").val(data[0].KEYWORD);
              $("#category_id").val(category_id);
              $('#mpnData').html("");
              $('#mpnData').append('<select name="mpn" id="mpn" class="selectDropdown form-control" data-live-search="true"><option value="'+catalogue_mt_id+'">'+mpn+'</option></select>'); 
              //$("#mpn").val(mpn);
              $("#rss_feed_cond").val(condition_id);
              //$("#rss_listing_type").val(object_id);
              $("#rss_price").val(sold_avg);
              $("#qty_sold").val(sold_qty);
              $("#min_price").val(min_price);
              $("#max_price").val(max_price);
              //$("#add_mpn_section").hide();
              $('.selectpicker').selectpicker('refresh')
              $("#min_price").focus();

            }else{
              $(".loader").hide();
               //$("#feedName").val(data[0].FEED_NAME);
               //$("#keyWord").val(data[0].KEYWORD);
              $("#category_id").val(category_id);
              $('#mpnData').html("");
              $('#mpnData').append('<select name="mpn" id="mpn" class="selectDropdown form-control" data-live-search="true"><option value="'+catalogue_mt_id+'">'+mpn+'</option></select>');
              //$("#mpn").val(mpn);
              $("#rss_feed_cond").val(condition_id);
              //$("#rss_listing_type").val(object_id);
              $("#rss_price").val(sold_avg);
              $("#qty_sold").val(sold_qty);
              $("#min_price").val(min_price);
              $("#max_price").val(max_price);
              //$("#rss_listing_type").val(object_id);
              //$("#add_mpn_section").hide();
              $('.selectpicker').selectpicker('refresh')
              $("#feedName").focus();
            }
             
          },
          complete: function(data){
              $(".loader").hide();
            },
            error: function(jqXHR, textStatus, errorThrown){
               $(".loader").hide();
              if (jqXHR.status){
                alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
              }
            }
     })
   });


/*=====  End of create rss url function  ======*/
/*===========================================
=            delete rss feed url            =
===========================================*/

$('.delFeedUrl').on('click', function(){ 
    var feedUrlId = this.id;
    var x = confirm("Are you sure you want to delete?");
  if(x){
    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>rssFeed/c_rssFeed/delRssURL',
      type:'post',
      dataType:'json',
      data:{'feedUrlId':feedUrlId},
      success:function(data){

         if(data == 1){
          $(".loader").hide();
          var row=$("#"+feedUrlId);
          //debugger;     
          row.closest('tr').fadeOut(1000, function() {
          row.closest('tr').remove();
          });

         }else if(data == 2){
          alert("Error! Component is not deleted");
         }
      },
       complete: function(data){
        $(".loader").hide();
      },
        error: function(jqXHR, textStatus, errorThrown){
           $(".loader").hide();
          if (jqXHR.status){
            alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          }
      }
    });
  }else{
    return false;
  }

   });

/*=====  End of delete rss feed url  ======*/

/*=====================================================
=            update keyword modal function            =
=====================================================*/
$(document).on('click','.editFeed',function(){
  var feedUrlId = this.id;
  
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/update_feed_url', 
        type: 'post',
        dataType: 'json',
        data : {'feedUrlId':feedUrlId},
        success:function(data){
          //console.log(data[0].FEED_NAME,data[0].KEYWORD,data[0].CATEGORY_ID);
          $('#UpdateKeyword').modal('show');
          $(".loader").hide();
          if (data.results.length > 0) {
              $('#feed_Name').val("");
              $('#feed_Name').val(data.results[0].FEED_NAME);

              $('#key_Word').val("");
              $('#key_Word').val(data.results[0].KEYWORD);

              $('#categoryId').val("");
              $('#categoryId').val(data.results[0].CATEGORY_ID);

              $('#feed_mpn').val("");
              $('#feed_mpn').val(data.results[0].MPN);

              $('#catalogue_mt_id').val("");
              $('#catalogue_mt_id').val(data.results[0].CATLALOGUE_MT_ID);

              var condition_id = data.results[0].CONDITION_ID;
              var condition_val = '';

              if (condition_id == 3000) {
                condition_val = 'Used';
              }else if(condition_id == 1000){
                condition_val = 'New';
              }else if(condition_id == 1500){
                condition_val = 'New other';
              }else if(condition_id == 2000){
                condition_val = 'Manufacturer refurbished';
              }else if(condition_id == 2500){
                condition_val = 'Seller refurbished';
              }else if(condition_id == 7000){
                condition_val = 'For parts or not working';
              }else if(condition_id == 0){
                condition_val = 'All';
              }  

              var conditions = [];
              for(var i = 0; i<data.conds.length; i++){
                if (data.results[0].CONDITION_ID == data.conds[i].ID){
                      var selected = "selected";
                      }else{
                        var selected = "";
                      } 
                      if(data.results[0].CONDITION_ID == 0) {
                          var select = "selected";
                      }else{
                        var select = "";
                      }
                    conditions.push('<option value="'+data.conds[i].ID+'" '+selected+'>'+data.conds[i].COND_NAME+'</option>');
                  }

              $('#feed_cond_update').html("");
              $('#feed_cond_update').html(conditions+'<option value="0" '+select+'>All</option>');

              var liting_type = [];
              var ltypes = ['BIN','Auction','All'];
              for(var i = 0; i<ltypes.length; i++){
                if (data.results[0].LISTING_TYPE == ltypes[i]){
                      var selected = "selected";
                      }else {
                          var selected = "";
                      }
                    liting_type.push('<option value="'+ltypes[i]+'" '+selected+'>'+ltypes[i]+'</option>');
                  }
              $('#rss_listing_type_update').html("");
              $('#rss_listing_type_update').html(liting_type);

            
             var show_val = [0,2,5,10,15,25,50,75,100,150,200,500,1000,1500,2000];
             var withins = [];
             var selected = "";
              for(var i = 0; i<show_val.length; i++){
                if (data.results[0].WITHIN == show_val[i]){
                      var selected = "selected";
                      }else {
                          var selected = "";
                      }
                    withins.push('<option value="'+show_val[i]+'" '+selected+'>'+show_val[i]+ ' miles</option>')
                  }
             
              $('#withinappend').html("");

              $('#withinappend').html('<select name="withInUpdate" id="withInUpdate" class="form-control"><option value="00">select</option>'+withins.join("")+'</select>');

          
            var filter_ids = [0,1,2];
            var filter_names = ['Select','Include','Exclude']; 
             var filters = [];
             var selected = "";
              for(var i = 0; i<filter_ids.length; i++){
                if (data.results[0].SELLER_FILTER == filter_ids[i]){
                      var selected = "selected";
                      }else {
                          var selected = "";
                      }
                    filters.push('<option value="'+filter_ids[i]+'" '+selected+'>'+filter_names[i]+ '</option>');
                  }
                  
            
              
              $('#seller_filter_update').html("");

              $('#seller_filter_update').html(filters);

              $("#zipCodeUpdate").val(data.results[0].ZIPCODE);
              /////////////////////////////////
                  var feed_ids = [0,30,32,33];
                  var feed_types = ['Select','Lookup','Local | Dallas', 'Category Feed']; 
                  var feeds = [];
                  var selected = "";
                    for(var i = 0; i<feed_ids.length; i++){
                      if (data.results[0].FEED_TYPE == feed_ids[i]){
                            var selected = "selected";
                            }else {
                                var selected = "";
                            }
                          feeds.push('<option value="'+feed_ids[i]+'" '+selected+'>'+feed_types[i]+ '</option>');
                        }
                    $('#rss_feed_type_update').html("");
                    $('#rss_feed_type_update').html(feeds);
                  ////////////////////////////////

              var sellerName = data.results[0].SELLER_NAME;
              $('#seller_name_update').val("");

              $('#seller_name_update').val(sellerName);

              $('#minPriceUpdate').val("");
              $('#minPriceUpdate').val(data.results[0].MIN_PRICE);

              $('#maxPriceUpdate').val("");
              $('#maxPriceUpdate').val(data.results[0].MAX_PRICE);

              $('#feedurlid').val("");
              $('#feedurlid').val(data.results[0].FEED_URL_ID);


                var rss_exclude_words = data.results[0].EXCLUDE_WORDS;
                //console.log(rss_exclude_words);
                if(rss_exclude_words == '' || rss_exclude_words == null || rss_exclude_words.length == 0){
                   var arr =[];
                }else{
                  var arr = rss_exclude_words.split('-');
                }
              //console.log(arr, arr.length, rss_exclude_words);
              var exclude_val = '';
              arr = arr.filter(v=>v!='');
               //console.log(arr.length, (parseInt(arr.length) - parseInt(1)), arr);
               //if (arr.length > 0) {
                for(var p=0; p<= arr.length; p++){
                  if(p == 0){

                  }else if(p == arr.length){
                    
                  }else if(p == (parseInt(arr.length) - parseInt(1))){
                    exclude= arr[p];
                     //console.log(p, arr.length, 'j', exclude);
                     if (exclude == "" || exclude == undefined) {
                      
                     }else{
                      exclude_val+= arr[p];
                     }
                  }else{
                    
                    exclude= arr[p];
                    //console.log(p, arr.length, 'h', exclude);
                     if (exclude == "" || exclude == undefined) { 
                     }else{
                      exclude_val+= arr[p]+", ";
                     }
                     
                  }
                }
              // }else{
              //   exclude_val = '';
              // }
                
                
              $('#exclude_Word').val("");
              $('#exclude_Word').val(exclude_val);
          }
          //}// END FOR

          // $('#rss_tds').text('');
          // $('#rss_tds').append(qty_dets.join(""));


        }
    });
  
  // alert(category_id);
});


/*=====  End of update keyword modal function  ======*/
$(document).on('change', '#seller_filter_update', function(){
  //console.log(this.value);
  if (this.value == 0) {
    $('#seller_name_update').attr("readonly", true);
  }else{
    $('#seller_name_update').attr("readonly", false);
  }
  
});
/*///////////////////////////////////////*/
$(document).on('change', '#withInUpdate', function(){
  //console.log(this.value);
  if (this.value == 00) {
    $('#zipCodeUpdate').attr("readonly", true);
  }else{
    $('#zipCodeUpdate').attr("readonly", false);
  }
  
});
/*///////////////////////////////////////*/

/*================================================
=            update feed url function            =
================================================*/
$(document).on('click','#updateUrl',function(){
var feedUrlId               = $('#feedurlid').val();
var catalogue_mt_id         = $('#catalogue_mt_id').val();
var feedName                = $('#feed_Name').val();
var keyword                 = $('#key_Word').val();
var excludeWord             = $('#exclude_Word').val();
var category_id             = $('#categoryId').val();
var feed_mpn                = $('#feed_mpn').val();
var rss_feed_cond           = $('#feed_cond_update').val();
var rss_listing_type        = $('#rss_listing_type_update').val();
////////////////////////////////////
var withInUpdate            = $('#withInUpdate').val();
var zipCodeUpdate           = $('#zipCodeUpdate').val();
var seller_filter_update    = $('#seller_filter_update').val();
var seller_name_update      = $('#seller_name_update').val();
var rss_feed_type           = $('#rss_feed_type_update').val();
////////////////////////////////////
var minPrice                = $('#minPriceUpdate').val();
var maxPrice                = $('#maxPriceUpdate').val();
//console.log(feedUrlId, catalogue_mt_id, feedName, keyword, excludeWord, category_id, feed_mpn, rss_feed_cond, rss_listing_type, withInUpdate, zipCodeUpdate, seller_filter_update, seller_name_update, minPrice, maxPrice); return false;
//console.log(rss_feed_type);   return false;
    if(feedName.trim() == ''){
      $('#UpdateKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Please Insert Feed Name !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#feed_Name').focus();
      return false;
    }
     //alert(feedName); return false;

    if(rss_feed_cond.trim() == ''){
       $('#UpdateKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Condition is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#feed_cond_update').focus();
      return false;
    }

    if(rss_listing_type.trim() == ''){
       $('#UpdateKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Listing Type is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_listing_type_update').focus();
      return false;
    }
    if(withInUpdate.trim() ==00){
      zipCodeUpdate ='';
     }
    if(withInUpdate.trim() !=00){
 if(zipCodeUpdate.trim() == ''){
    $('#UpdateKeyword').modal('show');
    $('#errorMessage').html("");
    $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Zipcode is required !</strong></p>');
    $('#errorMessage').show();
    setTimeout(function() {
    $('#errorMessage').fadeOut('slow');
    }, 3000);
    $('#zipCodeUpdate').focus();
    return false;
  }
}
     if(seller_filter_update.trim() ==0){
      seller_name_update ='';
     }
if(seller_filter_update.trim() !=0){
 if(seller_name_update.trim() == ''){
    $('#UpdateKeyword').modal('show');
    $('#errorMessage').html("");
    $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Seller Name is required !</strong></p>');
    $('#errorMessage').show();
    setTimeout(function() {
    $('#errorMessage').fadeOut('slow');
    }, 3000);
    $('#seller_name_update').focus();
    return false;
  }
}
if(rss_feed_type.trim() == 0){
 $('#UpdateKeyword').modal('show');
  $('#errorMessage').html("");
  $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Feed Type is required !</strong></p>');
  $('#errorMessage').show();
  setTimeout(function() {
  $('#errorMessage').fadeOut('slow');
  }, 3000);
  $('#rss_feed_type_update').focus();
return false;
}
    
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/updateUrl', 
        type: 'post',
        dataType: 'json',
        data : {
                'feedUrlId':feedUrlId,
                'catalogue_mt_id':catalogue_mt_id,
                'feedName':feedName,
                'keyword':keyword,
                'excludeWord':excludeWord,
                'category_id':category_id,
                'feed_mpn':feed_mpn,
                'rss_feed_cond':rss_feed_cond,
                'rss_listing_type':rss_listing_type,
                'withInUpdate':withInUpdate,
                'zipCodeUpdate':zipCodeUpdate,
                'seller_filter_update':seller_filter_update,
                'seller_name_update':seller_name_update,
                'rss_feed_type':rss_feed_type,
                'minPrice':minPrice,
                'maxPrice':maxPrice
              },
        success:function(data){
          if(data){
            $(".loader").hide();
            alert('Feed URL Updated Sucessfully');
            $('#UpdateKeyword').modal('show');
            //console.log(data[0].FEED_NAME);
          //$('#UpdateKeyword').modal('show');
          }else{
            //console.log(data[0].FEED_NAME);
          //$('#UpdateKeyword').modal('show');
          $(".loader").hide();
          alert('Some Error occur');
          }
          

        }
    });



  });
/*=====  End of update feed url function  ======*/
$(document).ready(function(){
  loadCategories();
});
function loadCategories(){
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/getCats', 
        type: 'post',
        dataType: 'json',
        data : {},
        success:function(data){
          console.log(data); 
          //return false;
          if(data){
            $(".loader").hide();
             var catdata = new Array();    
            var k = 0;
            for (var i = 0; i < data.length; i++) {
                var row = {};
                row["cat_id"] = data[k].CATEGORY_ID;
                row["cat_name"] = data[k].CATEGORY_NAME;
                catdata[i] = row;
                k++;
            }
            var source =
            {
                localdata: catdata,
                datatype: "array"
            };
            var dataAdapter = new $.jqx.dataAdapter(source);
            $('#combobox').jqxComboBox({ selectedIndex: 0,  source: dataAdapter, displayMember: "cat_id", valueMember: "cat_id", itemHeight: 30, height: 31, width: 240,
                renderer: function (index, label, value) {
                    var datarecord = catdata[index];
                    var table = '<table style="min-width: 150px;"><tr><td style="width: 55px;" rowspan="2"></td><td>' + datarecord.cat_id+'-'+datarecord.cat_name+'</td></tr></table>';
                    return table;
                }
            });
          }
          

        }
    });
  }
</script>
