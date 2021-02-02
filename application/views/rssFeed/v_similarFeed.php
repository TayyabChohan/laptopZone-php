<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $pageTitle;?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageTitle;?></li>
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
              <h3 class="box-title"><?php echo $pageTitle;?></h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
           

            <div class="box-body">
              <form action="<?php echo base_url(); ?>rssFeed/c_rssFeed/CatFilterHotRssFeed" method="post" accept-charset="utf-8">

                <div class="col-sm-4">
                <label for="feed_url">Category:</label>
                    <div class="form-group">
                      <select class="form-control" name="assign_cat_id" id="assign_cat_id">
                      <?php foreach (@$data['cat_id_qry'] as $row): ?>
                        <option value="<?php echo @$row['CATEGORY_ID'];?>"><?php echo @$row['CATEGORY_NAME'];?></option>
                      <?php endforeach;?>
                      </select>
                    </div>                                     
                </div> 
                <div class="col-sm-2 p-t-24">
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                  </div>
                </div>                                 
              </form>
                <div class="col-sm-2 pull-right p-t-24">
                  <div class="form-group">
                      <input type="button" class="btn btn-primary" id="del_all_stream" name="del_all_stream" value="Delete All">
                  </div>
                </div>  
            </div>
        </div>  


        <div class="box">
           
        <div class="box-body form-scroll">      
        <div class="col-md-12">
			<input type="hidden" name="last_feed_id" id="last_feed_id" value="<?php echo @$data['feed_data'][0]['FEED_ID']?>">
            <table id="rssFeedTable" class="table table-bordered table-striped">

                <thead>
	                <tr>
	                    <th>ACTION</th>
	                    <th>DESCRIPTION</th>
	                    <th>EBAY ID</th>
	                    <th>CONDITION</th>
                      <th>SOLD AVG</th> 
	                    <th>ACTIVE AVG</th> 
                      <th>KIT PRICE</th>
                      <th>QTY SOLD</th>
	                    <th>QTY ACTIVE</th>
	                    <th>SELL TROUGH</th>
	                    <th>CATEGORY ID</th>
	                    <th>CATEGORY NAME</th>
	                    <th>SALE PRICE</th>
	                    <th>START TIME</th>
                      <th>KEYWORD</th>
                      <th>MAX PRICE</th>
                      <th>NEWLY LISTED</th>
                      <th>FEED ID</th>
	                </tr>
                </thead>

                <tbody>
               </tbody> 
               </table>
                
              </div>
              <!-- </form> -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        	<div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
                <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
            </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->

<!-- Modal -->
<div id="myModal" class="modal modal-info fade" role="dialog" style="width: 100%;">
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
                          <h1 class="box-title" style="color:white;">Qty Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body ">
                          <div class="col-md-12">

                            <table id="rssTable" class="table table-responsive table-striped table-bordered table-hover ">
                              <thead>
                              <th style="color:black;">SR NO</th>
                                <th style="color:black;">EBAY_ID</th> 

                                <th style="color:black;">TITLE</th>
 
                                <th style="color:black;">CONDITION NAME</th>

                                <th style="color:black;">SOLD PRICE</th>

                                <th style="color:black;">SHIPPING COST</th>

                                <th style="color:black;">START TIME</th>

                                <th style="color:black;">SALE TIME</th>
                                <th style="color:black;">SELLER ID</th>
                              </thead>
                              <tbody id="rss_tds">
                                <tr>
                                 <!--  <td id = "qty_ebay_id" style="color:black;width:100px"></td>
                                  <td id="qty_title" style="color:black;width:200px;"></td>
                                  <td id="qty_conditionName" style="color:black;width:100px;"></td>
                                  <td id="qty_soldPrice" style="color:black;width:70px;"></td>
                                  <td id="qty_shippingCost" style="color:black;width:70px;"></td>
                                  <td id="qty_startTime" style="color:black;width:100px;"></td>
                                  <td id="qty_saleTime" style="color:black;width:100px;"></td> -->

                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->
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
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Feed Name" style = "color: black!important;">Feed Name:</label>
                      <input name="feedName" type="text" id="feedName" class="feedName form-control " >
                      <input name="feedurlid" type="hidden" id="feedurlid" class="feedurlid form-control " >
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Key Word" style = "color: black!important;">Keyword :</label>
                      <input name="keyWord" type="text" id="keyWord" class="keyWord form-control " >
                    </div>
                  </div> 
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="Exclude Word" style = "color: black!important;">Exclude Words :</label>
                      <input name="excludeWord" type="text" id="excludeWord" class="excludeWord form-control " placeholder="Enter comma seprated words">
                    </div>
                  </div>  
                  <div class="col-sm-4">
                    <label for="Category ID" style = "color: black!important;">Category ID :</label>
                    <div class="form-group" >
                    <input name="category_id" type="text" id="category_id" class="category_id form-control " readonly>
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
                   <div class="col-sm-2">
                      <div class="form-group">
                        <label for="Condition" style = "color: black!important;">Condition:</label>
                          <!-- <select class="form-control  rss_feed_cond"   name="rss_feed_cond" id="rss_feed_cond"  style="width: 203px;">
                            <?php                                 
                              //foreach(@$conditions as $cond) { 
                              ?>
                                <option value="<?php //echo $cond['ID']; ?>"><?php //echo $cond['COND_NAME']; ?></option>
                              <?php
                                //  } 
                               ?>                     
                          </select> --> 
                          <input name="rss_feed_cond" type="text" id="rss_feed_cond" class="rss_feed_cond form-control " readonly>
                      </div>
                  </div>
                  <div class="col-sm-2">
                      <div class="form-group">
                        <label for="Listing Type" style = "color: black!important;">Listing Type:</label>
                          <!-- <select class="form-control  rss_listing_type"   name="rss_listing_type" id="rss_listing_type"  style="width: 203px;">
                               <option value="BIN" selected> BIN</option>
                               <option value="Auction"> Auction</option>
                               <option value="All"> All</option>                    
                          </select> --> 
                          <input name="rss_listing_type" type="text" id="rss_listing_type" class="rss_listing_type form-control " readonly>
                      </div>
                  </div>
<!--                   <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Price" style = "color: black!important;">Price :</label>
                      <input name="rss_price" type="text" id="rss_price" class="rss_price form-control " readonly>
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Price" style = "color: black!important;">Qty Sold :</label>
                      <input name="qty_sold" type="text" id="qty_sold" class="form-control " readonly>
                    </div>
                  </div> -->
                  <div class="col-sm-4">                  
                    <div class="form-group">
                    <label for="Feedback Score" style = "color: black!important;">Price Range:</label>
                    <div class="input-group" >
                    <input type="number" step="0.01" min="0" name ="min_price" id="min_price" class="form-control clear" value=""  />
                    <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                    <input type="number" step="0.01" min="0" name ="max_price" id="max_price" class="form-control clear" value="" />
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
                  </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->

 <?php $this->load->view('template/footer'); ?>
 <script>
   var dataTable = '';
 $(document).ready(function(){
 // $('#rssFeedTable').DataTable({
 //      "oLanguage": {
 //      "sInfo": "Total Orders: _TOTAL_"
 //    }

 //    });
 //$.fn.dataTable.moment( 'DD-MM-YYYY HH24:MI:SS' );
    //   $("#rssFeedTable").DataTable({
    //   "oLanguage": {
    //   "sInfo": "Total Items: _TOTAL_"
    // },
    //   "aaSorting": [[15,'desc']],
    //   //"order": [[ 10, "desc" ]],
    //   "paging": true,
    //   "iDisplayLength": 25,
    //   "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    //   "lengthChange": true,
    //   "searching": true,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": true,
    //   "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'      
    // });


var catalogue_mt_id = "<?php echo $this->uri->segment(4); ?>";
//console.log(catalogue_mt_id); return false;
if(dataTable != ''){
        dataTable = dataTable.destroy();
       }
     dataTable = $('#rssFeedTable').DataTable({
      "oLanguage": {
        "sInfo": "Total Records: _TOTAL_", 
      },
      "aaSorting": [[17,'desc']],
      //"order": [[ 10, "desc" ]],
      "aLengthMenu": [25, 50, 100, 200],
      "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      "info": true,
      // "autoWidth": true,
      "fixedHeader": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "bAutoWidth": false,
      "ajax":{
        url: '<?php echo base_url();?>rssfeed/c_rssfeed/loadSimilarFeed', 
        type: 'post',
        dataType: 'json',
        data:{'catalogue_mt_id':catalogue_mt_id}
      },
      "columnDefs":[{
          "target":[0],
          "orderable":false
        }],

        "rowCallback": function( row, data, dataIndex){
            if(data){
                $(row).find(".verified").closest( "tr" ).addClass('verifiedTr');
                }
              }

      });

     /*========================================
     =            to auto refresh page         =
     ========================================*/
     
		//  setTimeout(function(){
		//    window.location.reload(1);
		// }, 20000);//time in mili second i.e 1 sec = 1000 mili second     
     
   
     /*=====  End of to auto refresh page  ======*/

/*===========================================================
=            select for purchase button function            =
===========================================================*/
	$("body").on('click','.flag-usd', function() {
	  //alert('dfgdgfd'); return false;
	    var feed_id = $(this).attr("id");
	    var flag_id = $(this).attr("fid");
	    var cat_id = $(this).attr("ct_id");
	    // var mpn_id = $(this).attr("mpn_id");
	    //console.log(lz_bd_cata_id, flag_id, cat_id, mpn_id); return false;
	    $(".loader").show();
	    $.ajax({
	        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/get_item', 
	        type: 'post',
	        dataType: 'json',
	        data : {'feed_id':feed_id, 'flag_id':flag_id,'cat_id':cat_id},
	        success: function(data){
	          if(data == 1){
	              $(".loader").hide();
	              alert('Sucess! item Moved to Active Data');
	            }else if(data == 2){
	            	$(".loader").hide();
	              	alert('Warning! Some Error ocure during API call');
	            }
	        },
	        error: function(data){
	          $(".loader").hide();
	           alert('Waring! Some Error ocure during process');
	        }
	    });    
	 });


/*=====  End of select for purchase button function  ======*/

/*======================================================
=            Discard/Delete Button function            =
======================================================*/
	$("body").on('click','.flag-trash', function() {
	    var feed_id = $(this).attr("id");
	    var flag_id = $(this).attr("fid");
	    //var cat_id = $(this).attr("ct_id");
	    $(".loader").show();
	    $.ajax({
	        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/discard_item',
	        type: 'post',
	        dataType: 'json',
	         data : {'feed_id':feed_id, 'flag_id':flag_id/*, 'cat_id':cat_id*/},
	        success: function(data){
				if (data == 0){
	              $(".loader").hide();
	              alert('Warning: query executed but nothing updated in DB.');
	            }else if (data > 0){
	              $(".loader").hide();

                var table = $('#rssFeedTable').DataTable();
 
                    table
                        .row( $("#"+feed_id).parents('tr') )
                        .remove()
                        .draw();

	              // var row=$("#"+feed_id);
	              // row.closest('tr').fadeOut(1000, function() {
	              // row.closest('tr').remove();
	              // });
	            }
	        },
	        error: function(data){
	          $(".loader").hide();
	           alert('some error occured.');
	        }
	    });    
	 });


/*=====  End of Discard/Delete Button function  ======*/

/*=======================================================
=            Update RSS feed button function            =
=======================================================*/
	$("body").on('click','#update_rss_feed', function() {
	     var feed_url_id = $('#rss_feed_url').val();
	     //console.log(feed_url_id); return false;
	    // var flag_id = $(this).attr("fid");
	    // //var cat_id = $(this).attr("ct_id");
	    // $(".loader").show();
	    $.ajax({
	        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/fetch_rss_feed',
	        type: 'post',
	        dataType: 'json',
	       data : {'feed_url_id':feed_url_id/*, 'flag_id':flag_id, 'cat_id':cat_id*/},
	        success: function(data){
				if (data != 0){
	              alert('RSS Feed Updated');
	              console.log('RSS Feed Updated');
	              var tb = $("#rssFeedTable").DataTable();
	              for(var i = 0; i<data.length; i++){
	              	//console.log(data[i].FEED_ID+'-'+data[i].EBAY_ID);


	              	var td = '<td> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button" style="float: left;padding-right: 5px;" id="'+data[i].FEED_ID+'_20"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'+data[i].FEED_ID+'" fid="20" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div> <div class="usd_button" style="float: left; padding-right: 5px;" id="'+data[i].FEED_ID+'_23"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'+data[i].FEED_ID+'" fid="23" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> </button> </div> </div> </td> ';
	              	td += '<td><div class = "item_desc" id="link_other" style="width: 300px;">'+data[i].ITEM_DESC+'</div></td> '; 
	              	td += '<td> <a href="'+data[i].ITEM_URL+'" target= "_blank" >'+data[i].EBAY_ID+'</a></td>';
	              	td += '<td>'+data[i].TITLE+'</td>'; 
	              	td += '<td>'+data[i].CONDITION_ID+'</td>'; 
	              	td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].AVG_PRICE).toFixed(2)+'</td>';
	              	var qty_det_url ='<?php echo base_url("rssfeed/c_rssfeed/qty_detail/"); ?>'+data[i].CATEGORY_ID+'/'+data[i].CATALOGUE_MT_ID+'/'+data[i].CONDITION_ID;
	              	td += '<td><a href="'+qty_det_url+'" target= "_blank" >'+data[i].QTY_SOLD+'</a></td> ';
	              	// var url ='<?php //echo base_url("rssfeed/c_rssfeed/fesibility_index/"); ?>'+data[i].FEED_ID;
	              	// td += '<td><a href="'+url+'" target= "_blank" >'+parseFloat(data[i].FESIBILITY_INDEX).toFixed(2)+' %</a></td> ';
	              	td += '<td>'+data[i].CATEGORY_ID+'</td> ';
	              	td += '<td>'+data[i].CATEGORY_NAME+'</td> '; 
	              	td += '<td>'+data[i].SALE_PRICE+'</td>'; 
	              	td += '<td>'+data[i].START_TIME+'</td>';
	              	td += '<td>'+data[i].NEWLY_LISTED+'</td>';
	              	var myDataRow = '<tr>'+td+'</tr>';
	             	tb.row.add($(myDataRow)).draw(); 
	              }
	              
	            }else{
	            	alert('RSS Feed URL not found in local DB.');
	              //console.log('RSS Feed Updated');
	            }
	        },
	        error: function(data){
	           console.log('some error occured.');
	        }
	    });    
	 });


/*=====  End of Update RSS feed button function  ======*/
/*=======================================================
=            Auto Fetch RSS Feed            =
=======================================================*/
	function autoFeed() {
	     var feed_url_id = null;
	     //console.log(feed_url_id); return false;
	    // var flag_id = $(this).attr("fid");
	    // //var cat_id = $(this).attr("ct_id");
	    // $(".loader").show();
	    $.ajax({
	        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/fetch_rss_feed',
	        type: 'post',
	        dataType: 'json',
	       data : {'feed_url_id':feed_url_id/*, 'flag_id':flag_id, 'cat_id':cat_id*/},
	        success: function(data){
	        	if(data === 0){
	            	console.log('RSS Feed URL not found in local DB.');
	            	//alert('RSS Feed URL not found in local DB.');
	            	//autoFeed();
	              //console.log('RSS Feed Updated');
	            }else if(data === 3){
	            	console.log('RSS Feed Already Updated.');
	            	//alert('RSS Feed URL not found in local DB.');
	            	//autoFeed();
	            }else if ($.isArray(data)){
	            	$("#rssFeedTable tr").removeClass("newlyAdded");
	              //alert('RSS Feed Updated');
	              console.log('RSS Feed Updated');
	              var tb = $("#rssFeedTable").DataTable();
	              for(var i = 0; i<data.length; i++){
	              	//console.log(data[i].FEED_ID+'-'+data[i].EBAY_ID);


	              	var td = '<td> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button" style="float: left;padding-right: 5px;" id="'+data[i].FEED_ID+'_20"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'+data[i].FEED_ID+'" fid="20" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div> <div class="usd_button" style="float: left; padding-right: 5px;" id="'+data[i].FEED_ID+'_23"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'+data[i].FEED_ID+'" fid="23" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> </button> </div> </div> </td> ';
	              	 td += '<td><div class = "item_desc" id="link_other" style="width: 300px;">'+data[i].ITEM_DESC+'</div></td> '; 
	              	 td += '<td> <a href="'+data[i].ITEM_URL+'" target= "_blank" >'+data[i].EBAY_ID+'</a></td>';
	              	 td += '<td>'+data[i].TITLE+'</td>'; 
	              	 td += '<td>'+data[i].CONDITION_ID+'</td>'; 
	              	 td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].AVG_PRICE).toFixed(2)+'</td>';
	              	 var qty_det_url ='<?php echo base_url("rssfeed/c_rssfeed/qty_detail/"); ?>'+data[i].CATEGORY_ID+'/'+data[i].CATALOGUE_MT_ID+'/'+data[i].CONDITION_ID;
	              	td += '<td><a href="'+qty_det_url+'" target= "_blank" >'+data[i].QTY_SOLD+'</a></td> ';
	              	 var url ='<?php echo base_url("rssfeed/c_rssfeed/fesibility_index/"); ?>'+data[i].FEED_ID;
	              	 td += '<td><a href="'+url+'" target= "_blank" >'+parseFloat(data[i].FESIBILITY_INDEX).toFixed(2)+' %</a></td> ';
	              	 td += '<td>'+data[i].CATEGORY_ID+'</td> ';
	              	 td += '<td>'+data[i].CATEGORY_NAME+'</td> '; 
	              	
	              	 td += '<td>'+data[i].SALE_PRICE+'</td>';
	              	td += '<td>'+data[i].START_TIME+'</td>';
	              	td += '<td>'+data[i].NEWLY_LISTED+'</td>';

	              	var myDataRow = '<tr class="newlyAdded">'+td+'</tr>';
	             	tb.row.add($(myDataRow)).draw(); 
	              }
	              //autoFeed();
	            }else{
	            	console.log('Unknown Error Occur.');
	            	//alert('RSS Feed URL not found in local DB.');
	            	//autoFeed();
	              //console.log('RSS Feed Updated');
	            }
	        },
	        error: function(data){
	           console.log('some error occured.');
	        }
	    });    
	 }

 //autoFeed();
/*=====  End of Auto Fetch RSS Feed  ======*/


/*=======================================================
=            Auto Update RSS Feed            =
=======================================================*/
	function updateFeed() {
	     var last_feed_id = $("#last_feed_id").val();
	     //console.log(feed_url_id); return false;
	    // var flag_id = $(this).attr("fid");
	    // //var cat_id = $(this).attr("ct_id");
	    // $(".loader").show();
	    $.ajax({
	        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/update_lookup_feed',
	        type: 'post',
	        dataType: 'json',
	       data : {'last_feed_id':last_feed_id/*, 'flag_id':flag_id, 'cat_id':cat_id*/},
	        success: function(data){
	        	if(data === 3){
	            	console.log('RSS Feed Already Updated.');
	            	//alert('RSS Feed URL not found in local DB.');
	            	updateFeed();
	            }else if ($.isArray(data)){
	            	var tb = $("#rssFeedTable").DataTable();
	    //         	var numberOfRows = tb.data().length;
	    //         	    for (var i = 0; i < numberOfRows; i++) {
	    //     //get data from row
	    //     var data = tb.row(i).data();
	    //     console.log(data);
	    //     if (data[12] == 1) { //test cell for value
	    //     	tb.row(i).data(0);
	    //         data[12] = 0;
	    //         tb.row(i).data(data[12]);
	    //     }else{
	    //     		return false;	
	    //     }
	    // }
	            	tb.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
		   var data = this.data();
		   //console.log(data[12]);
		   if(data[16]){
		   	data[16] = 0;
		   }else{

		   }
		   //data[12] += ' >> updated in loop'
		   this.data(data);
		} );


      	$("#last_feed_id").val(data[0].FEED_ID);

        console.log('RSS Feed Updated');
	              
				$("#rssFeedTable tr").removeClass("newlyAdded");
	              for(var i = 0; i<data.length; i++){
	              	//console.log(data[i].FEED_ID+'-'+data[i].EBAY_ID);
						/*============================================
						=            creating history URL            =
						============================================*/
            	 var url1 = 'https://www.ebay.com/sch/';
            	 var cat_name = data[i].CATEGORY_NAME;
	    				 cat_name = cat_name.replace(' ','-');
	    				 cat_name = cat_name.replace('&','-');
	    				 cat_name = cat_name.replace('/','-');
            	 var cat_id = data[i].CATEGORY_ID;
            	 var url2 = cat_name+'/'+cat_id+'/';
            	 var url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='+data[i].CONDITION_ID;
            	 var url4 = '&_nkw='+data[i].KEYWORD;
            	 var url5 = '&LH_Complete=1&LH_Sold=1';
            	 var final_url = url1+url2+url3+url4+url5;
						/*=====  End of creating history URL  ======*/

						/*=============================================
            =            custom BIN URL block            =
            =============================================*/
            //var bin_url = 'https://pay.ebay.com/xo?action=create&rypsvc=true&pagename=ryp&TransactionId=-1&item='+ data[i].EBAY_ID+'&quantity=1';
            var bin_url = '<?php echo base_url()."rssfeed/c_rssfeed/checkout/"; ?>'+data[i].EBAY_ID;
            /*=====  End of custom BIN URL block  ======*/
            
	              	var td = '<td> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button" style="float: left;padding-right: 5px;" id="'+data[i].FEED_ID+'_20"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'+data[i].FEED_ID+'" fid="20" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div> <div class="usd_button" style="float: left; padding-right: 5px;" id="'+data[i].FEED_ID+'_23"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'+data[i].FEED_ID+'" fid="23" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> </button> </div> <div class="info_link btn btn-success btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "Sold History"> <a style="color:white!important; " href="'+final_url+'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> </div><div class="bin_link btn btn-success btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> <a style="color:white!important; " class="eBayCheckout" id="<?php echo @$row['EBAY_ID'];?>" href="'+bin_url+'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a></div></div> </td> '; 
	              	td += '<td><div class = "item_desc" id="link_other" style="width: 300px;">'+data[i].ITEM_DESC+'</div></td> ';
	              	 td += '<td> <a href="'+data[i].ITEM_URL+data[i].TITLE+'" target= "_blank" >'+data[i].EBAY_ID+'</a></td>';
	              	 td += '<td>'+data[i].COND_NAME+'</td>'; 
                   td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].SOLD_AVG).toFixed(2)+'</td>';
	              	 td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].ACTIVE_AVG).toFixed(2)+'</td>';
                   td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].KIT_PRICE).toFixed(2)+'</td>';
	              	 var qty_det_url ='<?php echo base_url("rssfeed/c_rssfeed/qty_detail/"); ?>'+data[i].CATEGORY_ID+'/'+data[i].CATALOGUE_MT_ID+'/'+data[i].CONDITION_ID;
	              	td += '<td><a href="'+qty_det_url+'" target= "_blank" >'+data[i].QTY_SOLD+'</a></td>';
                  td += '<td>'+data[i].QTY_ACTIVE+'</td>';
                  td += '<td>'+data[i].SELL_TROUGH+'</td>';
	              	 //var url ='<?php //echo base_url("rssfeed/c_rssfeed/fesibility_index/"); ?>'+data[i].FEED_ID;
	              	 // td += '<td><a href="'+url+'" target= "_blank" >'+parseFloat(data[i].FESIBILITY_INDEX).toFixed(2)+' %</a></td> ';
	              	 td += '<td>'+data[i].CATEGORY_ID+'</td> ';
	              	 td += '<td>'+data[i].CATEGORY_NAME+'</td> '; 
	              	
	              	 td += '<td>$ '+parseFloat(data[i].SALE_PRICE).toFixed(2)+'</td>';
	              	td += '<td>'+data[i].START_TIME+'</td>';
	              	
                  td += '<td style="color:black; font-weight: bold;"><button class="btn-link feedKeyword" id="'+data[i].FEED_URL_ID+'">'+data[i].KEYWORD+'</button></td>';

                  td += '<td>$ '+parseFloat(data[i].MAX_PRICE).toFixed(2)+'</td>';
                  td += '<td>'+data[i].NEWLY_LISTED+'</td>';
                  td += '<td>'+data[i].FEED_ID+'</td>';

	              	var myDataRow = '<tr class="newlyAdded">'+td+'</tr>';
	             	tb.row.add($(myDataRow)).draw(); 
	              }
	              updateFeed();
	            }else{
	            	console.log('Unknown Error Occur.');
	            	//alert('RSS Feed URL not found in local DB.');
	            	updateFeed();
	              //console.log('RSS Feed Updated');
	            }
	        },
	        error: function(data){
	           console.log('some error occured.');
	           updateFeed();
	        }
	    });    
	 }

 //updateFeed();
/*=====  End of Auto Update RSS Feed  ======*/
});//document.ready function close



/*=======================================
=            rss Table popup            =
=======================================*/

$(document).on('click','.qty_sold',function(){
	var id = this.id.match(/\d+/);
	var category_id = $('#category_id_'+id+'').val();
	var condition_id = $('#condition_id_'+id+'').val();
	var catalogue_mt_id = $('#catalogue_mt_id_'+id+'').val();

	$(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/qty_detail', 
        type: 'post',
        dataType: 'json',
        data : {'category_id':category_id, 'condition_id':condition_id,'catalogue_mt_id':catalogue_mt_id},
        success:function(data){
        	console.log(data);
        	$('#myModal').modal('show');
        	$(".loader").hide();



        	var qty_dets = [];

        	for(var i=0;i<data.length;i++){
        		var shipping_cost2 = data[i].SHIPPING_COST;
        		var sale_price2 = data[i].SALE_PRICE;

        		qty_dets.push('<tr> <td id = "qty_sr_no'+i+'" style="color:black;width:100px">'+parseFloat(parseFloat(i)+parseFloat(1))+'</td> <td id = "qty_ebay_id'+i+'" style="color:black;width:100px">'+data[i].EBAY_ID+'</td> <td id="qty_title'+i+'" style="color:black;width:200px;">'+data[i].TITLE+'</td> <td id="qty_conditionName'+i+'" style="color:black;width:100px;">'+data[i].CONDITION_NAME+'</td> <td id="qty_soldPrice'+i+'" style="color:black;width:70px;">'+parseFloat(sale_price2).toFixed(2)+'</td> <td id="qty_shippingCost'+i+'" style="color:black;width:70px;">'+parseFloat(shipping_cost2).toFixed(2)+'</td> <td id="qty_startTime'+i+'" style="color:black;width:100px;">'+data[i].START_TIME+'</td> <td id="qty_saleTime'+i+'" style="color:black;width:100px;">'+data[i].SALE_TIME+'</td> </td> <td id="qty_seller_id'+i+'" style="color:black;width:100px;">'+data[i].SELLER_ID+'</td></tr>') ;

        		 //    $('#qty_ebay_id'+i+'').text("");
		        	// $('#qty_ebay_id'+i+'').text(data[0].EBAY_ID);

		        	// $('#qty_title'+i+'').text("");
		        	// $('#qty_title'+i+'').text(data[0].TITLE);

		        	// $('#qty_conditionName'+i+'').text("");
		        	// $('#qty_conditionName'+i+'').text(data[0].CONDITION_NAME);

		        	// $('#qty_soldPrice'+i+'').text("");
		        	// var sale_price2 = data[0].SALE_PRICE;
		        	// sale_price2 = parseFloat(sale_price2).toFixed(2);
		        	// $('#qty_soldPrice'+i+'').text(sale_price2);

		        	// $('#qty_shippingCost'+i+'').text("");
		        	// var shipping_cost2 = data[0].SHIPPING_COST;
		        	// shipping_cost2 = parseFloat(shipping_cost2).toFixed(2);
		        	// $('#qty_shippingCost'+i+'').text(shipping_cost2);	

		        	// $('#qty_startTime'+i+'').text("");
		        	// $('#qty_startTime'+i+'').text(data[0].START_TIME);

		        	// $('#qty_saleTime'+i+'').text("");
		        	// $('#qty_saleTime'+i+'').text(data[0].SALE_TIME);
        	}

        	$('#rss_tds').text('');
        	$('#rss_tds').append(qty_dets.join(""));


        }
    });
	
	// alert(category_id);
});
/*=====  End of rss Table popup  ======*/
/*=============================================
=            ebaycheckout function            =
=============================================*/

$('.eBayCheckout').on('click', function(){ 
    var ebay_id = this.id;
      if(ebay_id){
        var table = $('#rssFeedTable').DataTable();
 
                    table
                        .row( $("#"+ebay_id).parents('tr') )
                        .remove()
                        .draw();

          // var row=$("#"+ebay_id);
          // row.closest('tr').fadeOut(1000, function() {
          // row.closest('tr').remove();
          // });

         }
   });

/*=====  End of ebaycheckout function  ======*/

/*=====================================================
=            update keyword modal function            =
=====================================================*/
$(document).on('click','.feedKeyword',function(){
  var feedUrlId = this.id;
  

  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/update_feed_url', 
        type: 'post',
        dataType: 'json',
        data : {'feedUrlId':feedUrlId},
        success:function(data){
         // console.log(data[0].FEED_NAME);
          $('#UpdateKeyword').modal('show');
          $(".loader").hide();



          //var qty_dets = [];

          //for(var i=0;i<data.length;i++){
            // var shipping_cost2 = data[i].SHIPPING_COST;
            // var sale_price2 = data[i].SALE_PRICE;

            // qty_dets.push('<tr> <td id = "qty_sr_no'+i+'" style="color:black;width:100px">'+parseFloat(parseFloat(i)+parseFloat(1))+'</td> <td id = "qty_ebay_id'+i+'" style="color:black;width:100px">'+data[i].EBAY_ID+'</td> <td id="qty_title'+i+'" style="color:black;width:200px;">'+data[i].TITLE+'</td> <td id="qty_conditionName'+i+'" style="color:black;width:100px;">'+data[i].CONDITION_NAME+'</td> <td id="qty_soldPrice'+i+'" style="color:black;width:70px;">'+parseFloat(sale_price2).toFixed(2)+'</td> <td id="qty_shippingCost'+i+'" style="color:black;width:70px;">'+parseFloat(shipping_cost2).toFixed(2)+'</td> <td id="qty_startTime'+i+'" style="color:black;width:100px;">'+data[i].START_TIME+'</td> <td id="qty_saleTime'+i+'" style="color:black;width:100px;">'+data[i].SALE_TIME+'</td> </td> <td id="qty_seller_id'+i+'" style="color:black;width:100px;">'+data[i].SELLER_ID+'</td></tr>') ;

                $('#feedName').val("");
              $('#feedName').val(data.results[0].FEED_NAME);

              $('#keyWord').val("");
              $('#keyWord').val(data.results[0].KEYWORD);

              $('#category_id').val("");
              $('#category_id').val(data.results[0].CATEGORY_ID);

              $('#feed_mpn').val("");
              $('#feed_mpn').val(data.results[0].MPN);

              $('#catalogue_mt_id').val("");
              $('#catalogue_mt_id').val(data.results[0].CATLALOGUE_MT_ID);

              $('#rss_feed_cond').val("");
              
              $('#rss_feed_cond').val(data.results[0].CONDITION_ID);  

              $('#rss_listing_type').val("");
              $('#rss_listing_type').val(data.results[0].LISTING_TYPE);

              $('#min_price').val("");
              $('#min_price').val(data.results[0].MIN_PRICE);

              $('#max_price').val("");
              $('#max_price').val(data.results[0].MAX_PRICE);
              $('#feedurlid').val("");
              $('#feedurlid').val(data.results[0].FEED_URL_ID);

              $('#excludeWord').val("");
// to avoid this error "Uncaught TypeError: Cannot read property 'trim' of null" use defualt value as null like data.results[0].EXCLUDE_WORDS || '';
              var excludeWord = data.results[0].EXCLUDE_WORDS|| ''.trim();
              var exclude_Word = '';
              if(excludeWord !=''){
                  excludeWord = excludeWord.split('-');
                if(excludeWord.length > 0){
                  for ( var i = 1 ; i < excludeWord.length; i++ ){
                    exclude_Word += excludeWord[i];
                    if(i+1 != excludeWord.length){
                      exclude_Word += ',';
                    }
                  }
                }else{
                   exclude_Word =excludeWord;
                }
                
              }
              
              $('#excludeWord').val(exclude_Word);
          //}// END FOR

          // $('#rss_tds').text('');
          // $('#rss_tds').append(qty_dets.join(""));


        },
        complete: function(data){
          $(".loader").hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR.status);
          alert(textStatus);
          alert(errorThrown);
      }
});
  
  // alert(category_id);
});


/*=====  End of update keyword modal function  ======*/
/*================================================
=            update feed url function            =
================================================*/
$(document).on('click','#updateUrl',function(){
var feedUrlId = $('#feedurlid').val();
var catalogue_mt_id = $('#catalogue_mt_id').val();
var feedName = $('#feedName').val();
var keyword = $('#keyWord').val();
var excludeWord = $('#excludeWord').val();
var category_id = $('#category_id').val();
var feed_mpn = $('#feed_mpn').val();
var rss_feed_cond = $('#rss_feed_cond').val();
var rss_listing_type = $('#rss_listing_type').val();
var minPrice = $('#min_price').val();
var maxPrice = $('#max_price').val();

  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/updateUrl', 
        type: 'post',
        dataType: 'json',
        data : {'feedUrlId':feedUrlId,
                'catalogue_mt_id':catalogue_mt_id,
                'feedName':feedName,
                'keyword':keyword,
                'excludeWord':excludeWord,
                'category_id':category_id,
                'feed_mpn':feed_mpn,
                'rss_feed_cond':rss_feed_cond,
                'rss_listing_type':rss_listing_type,
                'minPrice':minPrice,
                'maxPrice':maxPrice
              },
        success:function(data){
          if(data){
            $(".loader").hide();
            alert('Feed URL Updated Sucessfully');
            //console.log(data[0].FEED_NAME);
          //$('#UpdateKeyword').modal('show');
          $(".loader").hide();
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
/*==================================================
=            delete all stream function            =
==================================================*/
$(document).on('click','#del_all_stream',function(){
  if(confirm('Are you sure?')){
      var rss_feed_type = '30';
      //console.log(rss_feed_type); return false;

        $(".loader").show();
          $.ajax({
              url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/delAllStream', 
              type: 'post',
              dataType: 'json',
              data : {
                      'rss_feed_type':rss_feed_type
                    },
              success:function(data){
                if(data){
                  $(".loader").hide();
                  //alert('Feed URL Updated Sucessfully');
                  window.location.reload();
                  //console.log(data[0].FEED_NAME);
                //$('#UpdateKeyword').modal('show');
                $(".loader").hide();
                }else{
                  //console.log(data[0].FEED_NAME);
                //$('#UpdateKeyword').modal('show');
                $(".loader").hide();
                alert('Some Error occur');
                }
                

              }
          });
    }//confirm if close


  });


/*=====  End of delete all stream function  ======*/

 </script>
