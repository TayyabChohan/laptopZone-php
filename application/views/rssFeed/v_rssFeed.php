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
              <div class="col-sm-12">
	            <form action="<?php echo base_url(); ?>rssFeed/c_rssFeed/CatFilter" method="post" accept-charset="utf-8">

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
	            <div class="col-sm-4">
	              	<label for="feed_url">Feed URL:</label>
	                <div class="form-group">
	                  <select name="rss_feed_url[]" id="rss_feed_url" class="selectpicker form-control" multiple="" data-actions-box="true" data-live-search="true">
	                  <?php foreach (@$data['feed_url'] as $row): ?>
	                    <option value="<?php echo @$row['FEED_URL_ID'];?>"><?php echo @$row['CATEGORY_ID'].'/'.@$row['CONDITION_ID'].'/'.@$row['MPN'];?></option>
	                  <?php endforeach;?>
	                  </select>
	                </div>                                     
	            </div>
	            <div class="col-sm-2 pull-right p-t-24">
	                <div class="form-group">
	                  <input type="button" class="btn btn-primary" id="update_rss_feed" name="update_rss" value="Update RSS Feed">
	                </div>
	            </div>               	

              </div>

			  <div class="col-sm-12">
               <div class="col-sm-2 p-t-24">
               <div class="form-group">
                   <a class="btn  btn-primary" href="<?php echo base_url(); ?>rssFeed/c_rssFeed/addRssFeedUrl" target="_blank">Add RSS Feed Url</a>
                 </div>
               </div>

                <div class="col-sm-8 p-t-24">
                  <div class="form-group">
                  </div>
                </div>

                <div class="col-sm-2 p-t-24">
                  <div class="form-group">
                    <a style="text-decoration: underline !important;" href="<?php echo base_url(); ?>rssFeed/c_rssFeed/hotRssFeed" target="_blank">Hot RSS Feed</a>
                  </div>
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
	                    <th>TITLE</th>
	                    <th>CONDITION</th>
	                    <th>AVG PRICE</th> 
	                    <th>QTY SOLD</th>
	                    <th>FESIBILITY INDEX</th>
	                    <th>CATEGORY ID</th>
	                    <th>CATEGORY NAME</th>
	                    <th>SALE PRICE</th>
	                    <th>START TIME</th>
	                    <th>NEWLY LISTED</th> 
	                     
	                </tr>
                </thead>

                <tbody>
     
                  <?php 
                  $i = 1;
                  foreach (@$data['feed_data'] as $row): 
                  	$it_condition = @$row['CONDITION_ID'];
                  	
		        	if(@$it_condition == 3000){
			          @$it_condition = 'Used';
			        }elseif(@$it_condition == 1000){
			          @$it_condition = 'New'; 
			        }elseif(@$it_condition == 1500){
			          @$it_condition = 'New other'; 
			        }elseif(@$it_condition == 2000){
			            @$it_condition = 'Manufacturer refurbished';
			        }elseif(@$it_condition == 2500){
			          @$it_condition = 'Seller refurbished'; 
			        }elseif(@$it_condition == 7000){
			          @$it_condition = 'For parts or not working'; 
			        }else{
			        	@$it_condition = '';
			        }
				    if(!empty(@$row['AVG_PRICE'])){
				    	$verified_tr = 'class = "verifiedTr"';
				    }else{
				    	$verified_tr = 'class = ""';
				    }
					?>

					<tr <?php echo $verified_tr; ?>>
                	 <td>
                	 	<div style="display: inline-block; position: relative; width: 100px; padding: 4px;">
	                	 <div class="trash_button" style="float: left;padding-right: 5px;" id="<?php echo @$row['FEED_ID'];?>_20"> 
	                	 	<button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="<?php echo @$row['FEED_ID'];?>" fid="20" ct_id="<?php echo @$row['CATEGORY_ID'];?>"><i class="fa fa-trash-o text text-center" aria-hidden="true">
	                	 		</i> 
	                	 	</button> 
	                	 </div>
	                	 <div class="usd_button" style="float: left; padding-right: 5px;" id="<?php echo @$row['FEED_ID'];?>_23"> 
	                	 	<button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="<?php echo @$row['FEED_ID'];?>" fid="23" ct_id="<?php echo @$row['CATEGORY_ID'];?>"><i class="fa fa-usd text text-center" aria-hidden="true"></i> 
	                	 	</button> 
	                	 </div>
	                	<?php
	                	 $url1 = 'https://www.ebay.com/sch/';
	                	 $cat_name = str_replace(array(" ","&","/"), '-', @$row['CATEGORY_NAME']);
	                	 $cat_id = @$row['CATEGORY_ID'];
	                	 $url2 = $cat_name.'/'.$cat_id.'/';
	                	 $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID'];
	                	 $url4 = '&_nkw='.@$row['TITLE'];
	                	 $url5 = '&LH_Complete=1&LH_Sold=1';
	                	 $final_url = $url1.$url2.$url3.$url4.$url5;
	                	 //var_dump($final_url);exit;
	                	?>
	                	 <div class="info_link btn btn-success btn-xs" style="float: left; padding-right: 5px;width: 25px;color:white!important;" id="" title = "Sold History"> 

	                	 	<a style="color:white!important; " href="<?php echo @$final_url; ?>" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> 
	                	 </div>
                     <div class="bin_link btn btn-primary btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> 

                      <a style="color:white!important; " href="<?php echo base_url().'ebayCheckout.php/?ebay_id='.@$row['EBAY_ID'];?>" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a> 
                     </div>
	                	</div>
                	 </td> 
                      <td><div class = "item_desc" id="link_other" style="width: 300px;"><?php echo @$row['ITEM_DESC'];?></div></td>                  
                      <td>

                      <a href="<?php echo @$row['ITEM_URL']; ?>" target= "_blank" ><?php echo @$row['EBAY_ID'];?></a></td>                  
                      <td><?php echo @$row['TITLE'];?></td>
                      <td><?php echo @$it_condition;?></td>
                      <td style="color:red; font-weight: bold;"><?php echo '$ '. number_format((float)@$row['AVG_PRICE'],2,'.',',') ;?></td>
                      <?php
					$qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.$row["CATEGORY_ID"].'/'.$row["CATALOGUE_MT_ID"].'/'.$row["CONDITION_ID"]);
	              	 
?>
					<!-- <td><a href="<?php //echo $qty_det_url; ?>" target= "_blank" ><?php //echo @$row['QTY_SOLD'];?></a></td> -->
                <?php if(!empty(@$row['AVG_PRICE'])){?>
            					<td>
            						<button class="btn btn-xs btn-link qty_sold" id="qty_sold<?php echo $i;?>" style="color:white !important;"><?php echo @$row['QTY_SOLD'];?></button>
            						<input type="hidden" id="category_id_<?php echo $i;?>" value="<?php echo $row["CATEGORY_ID"];?>"> 
                        <input type="hidden" id="catalogue_mt_id_<?php echo $i;?>" value="<?php echo $row["CATALOGUE_MT_ID"];?>"> 
                        <input type="hidden" id="condition_id_<?php echo $i;?>" value="<?php echo $row["CONDITION_ID"];?>"> 
                      </td>
                <?php }else{ ?>

                      <td>
                        <button class="btn btn-xs btn-link qty_sold" id="qty_sold<?php echo $i;?>"><?php echo @$row['QTY_SOLD'];?></button>
                        <input type="hidden" id="category_id_<?php echo $i;?>" value="<?php echo $row["CATEGORY_ID"];?>"> 
                        <input type="hidden" id="catalogue_mt_id_<?php echo $i;?>" value="<?php echo $row["CATALOGUE_MT_ID"];?>"> 
                        <input type="hidden" id="condition_id_<?php echo $i;?>" value="<?php echo $row["CONDITION_ID"];?>"> 
                      </td>
                <?php } ?>
<!--                       <td><?php //echo @$row['QTY_SOLD'];?></td>  -->
                      <td>
                      <?php $feed_id = @$row['FEED_ID']; ?>
                      <a href="<?php echo base_url('rssfeed/c_rssfeed/fesibility_index/'.$feed_id); ?>" target= "_blank" ><?php echo number_format((float)@$row['FESIBILITY_INDEX'],2,'.',',').' %';?></a>

                      <?php //echo @$row['FESIBILITY_INDEX'];?>
                      	
                      </td>                 
                      <td><?php echo @$row['CATEGORY_ID'];?></td>                  
                      <td><?php echo @$row['CATEGORY_NAME'];?></td>
                      <td><?php echo '$ '. number_format((float)@$row['SALE_PRICE'],2,'.',',') ;?></td>
                      <td><?php echo @$row['START_TIME'];?></td> 
                      <td><?php echo @$row['NEWLY_LISTED'];?></td>   
    
                          

                    </tr>
                    <?php
                    $i++;
                   endforeach;
                ?>
                         
                </tbody>
            </table><br>
                
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
                              	<th style="color:black;">SR.NO</th>
                                <th style="color:black;">EBAY_ID</th> 

                                <th style="color:black;">TITLE</th>
 
                                <th style="color:black;">CONDITION NAME</th>

                                <th style="color:black;">SOLD PRICE</th>

                                <th style="color:black;">SHIPPING COST</th>

                                <th style="color:black;">START TIME</th>

                                <th style="color:black;">SALE TIME</th>
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

 <?php $this->load->view('template/footer'); ?>
 <script>
 $(document).ready(function(){
 // $('#rssFeedTable').DataTable({
 //      "oLanguage": {
 //      "sInfo": "Total Orders: _TOTAL_"
 //    }

 //    });
     $("#rssFeedTable").DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      "aaSorting": [[12,'desc'],[11,'desc']],
      //"order": [[ 10, "desc" ]],
      "paging": true,
      "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'      
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
	              var row=$("#"+feed_id);
	              row.closest('tr').fadeOut(1000, function() {
	              row.closest('tr').remove();
	              });
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
      var maxID = 0;
      // var arr =[];
        $('.qty_sold').each(function(){
          
          var current_id = this.id.match(/\d+/);
          current_id = parseInt(current_id);
          // arr.push(current_id);
          if(current_id > maxID){
              maxID = current_id;
            }
        });
        // var max = Math.max.apply(Math,arr);      
      // alert(maxID);return false;
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
                  maxID++;

	              	var td = '<td> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button" style="float: left;padding-right: 5px;" id="'+data[i].FEED_ID+'_20"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'+data[i].FEED_ID+'" fid="20" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div> <div class="usd_button" style="float: left; padding-right: 5px;" id="'+data[i].FEED_ID+'_23"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'+data[i].FEED_ID+'" fid="23" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> </button> </div> </div> </td> ';
	              	td += '<td><div class = "item_desc" id="link_other" style="width: 300px;">'+data[i].ITEM_DESC+'</div></td> '; 
	              	td += '<td> <a href="'+data[i].ITEM_URL+'" target= "_blank" >'+data[i].EBAY_ID+'</a></td>';
	              	td += '<td>'+data[i].TITLE+'</td>'; 
	              	td += '<td>'+data[i].CONDITION_ID+'</td>'; 
	              	td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].AVG_PRICE).toFixed(2)+'</td>';
	              	var qty_det_url ='<?php echo base_url("rssfeed/c_rssfeed/qty_detail/"); ?>'+data[i].CATEGORY_ID+'/'+data[i].CATALOGUE_MT_ID+'/'+data[i].CONDITION_ID;
	              	td += '<td><button class="btn btn-xs btn-link qty_sold" id="qty_sold'+maxID+'">'+data[i].QTY_SOLD+'</button> <input type="hidden" id="category_id_'+maxID+'" value="'+data[i].CATEGORY_ID+'"> <input type="hidden" id="catalogue_mt_id_'+maxID+'" value="'+data[i].CATALOGUE_MT_ID+'"> <input type="hidden" id="condition_id_'+maxID+'" value="'+data[i].CONDITION_ID+'"></td>  ';
	              	var url ='<?php echo base_url("rssfeed/c_rssfeed/fesibility_index/"); ?>'+data[i].FEED_ID;
	              	td += '<td><a href="'+url+'" target= "_blank" >'+parseFloat(data[i].FESIBILITY_INDEX).toFixed(2)+' %</a></td> ';
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

      var maxID = 0;
      // var arr =[];
      $('.qty_sold').each(function(){
        
        var current_id = this.id.match(/\d+/);
        current_id = parseInt(current_id);
        // arr.push(current_id);
        if(current_id > maxID){
            maxID = current_id;
          }
      });
      // var max = Math.max.apply(Math,arr);      
      // alert(maxID);return false;
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

                  maxID++;
	              	var td = '<td> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button" style="float: left;padding-right: 5px;" id="'+data[i].FEED_ID+'_20"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'+data[i].FEED_ID+'" fid="20" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div> <div class="usd_button" style="float: left; padding-right: 5px;" id="'+data[i].FEED_ID+'_23"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'+data[i].FEED_ID+'" fid="23" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> </button> </div> </div> </td> ';
	              	 td += '<td><div class = "item_desc" id="link_other" style="width: 300px;">'+data[i].ITEM_DESC+'</div></td> '; 
	              	 td += '<td> <a href="'+data[i].ITEM_URL+'" target= "_blank" >'+data[i].EBAY_ID+'</a></td>';
	              	 td += '<td>'+data[i].TITLE+'</td>'; 
	              	 td += '<td>'+data[i].CONDITION_ID+'</td>'; 
	              	 td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].AVG_PRICE).toFixed(2)+'</td>';
	              	 var qty_det_url ='<?php echo base_url("rssfeed/c_rssfeed/qty_detail/"); ?>'+data[i].CATEGORY_ID+'/'+data[i].CATALOGUE_MT_ID+'/'+data[i].CONDITION_ID;
	              	td += '<td><button class="btn btn-xs btn-link qty_sold" id="qty_sold'+maxID+'">'+data[i].QTY_SOLD+'</button> <input type="hidden" id="category_id_'+maxID+'" value="'+data[i].CATEGORY_ID+'"> <input type="hidden" id="catalogue_mt_id_'+maxID+'" value="'+data[i].CATALOGUE_MT_ID+'"> <input type="hidden" id="condition_id_'+maxID+'" value="'+data[i].CONDITION_ID+'"></td> ';
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


      var maxID = 0;
      // var arr =[];
      $('.qty_sold').each(function(){
        
        var current_id = this.id.match(/\d+/);
        current_id = parseInt(current_id);
        // arr.push(current_id);
        if(current_id > maxID){
            maxID = current_id;
          }
      });
      // var max = Math.max.apply(Math,arr);      
      // alert(maxID);return false;      
	    $.ajax({
	        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/update_rss_feed',
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
		   if(data[12]){
		   	data[12] = 0;
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
                  maxID++;
	              	var it_condition = data[i].CONDITION_ID;
                  	
		        	if(it_condition == 3000){
			          it_condition = 'Used';
			        }else if(it_condition == 1000){
			          it_condition = 'New'; 
			        }else if(it_condition == 1500){
			          it_condition = 'New other'; 
			        }else if(it_condition == 2000){
			            it_condition = 'Manufacturer refurbished';
			        }else if(it_condition == 2500){
			          it_condition = 'Seller refurbished'; 
			        }else if(it_condition == 7000){
			          it_condition = 'For parts or not working'; 
			        }

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
	                	 var url4 = '&_nkw='+data[i].TITLE;
	                	 var url5 = '&LH_Complete=1&LH_Sold=1';
	                	 var final_url = url1+url2+url3+url4+url5;
						/*=====  End of creating history URL  ======*/
						/*=============================================
            =            custom BIN URL block            =
            =============================================*/
            //var bin_url = 'https://pay.ebay.com/xo?action=create&rypsvc=true&pagename=ryp&TransactionId=-1&item='+ data[i].EBAY_ID+'&quantity=1';
           var bin_url = "<?php echo base_url().'ebayCheckout.php/?ebay_id=';?>"+ data[i].EBAY_ID;
            /*=====  End of custom BIN URL block  ======*/
	              	var td = '<td> <div style="display: inline-block; position: relative; width: 200px; padding: 4px;"> <div class="trash_button" style="float: left;padding-right: 5px;" id="'+data[i].FEED_ID+'_20"> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" id="'+data[i].FEED_ID+'" fid="20" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div> <div class="usd_button" style="float: left; padding-right: 5px;" id="'+data[i].FEED_ID+'_23"> <button title="Select for Purchase" class="btn btn-warning btn-xs flag-usd" style="width: 25px; " id="'+data[i].FEED_ID+'" fid="23" ct_id="'+data[i].CATEGORY_ID+'"><i class="fa fa-usd text text-center" aria-hidden="true"></i> </button> </div> <div class="info_link btn btn-success btn-xs" style="float: left; padding-right: 5px;width: 25px;color:white!important;" id="" title = "Sold History"> <a style="color:white!important; " href="'+final_url+'" target= "_blank" ><i class="fa fa-info" aria-hidden="true"></i></a> </div><div class="bin_link btn btn-success btn-xs" style="float: left; margin-right: 5px;width: 25px;color:white!important;" id="" title = "BIN"> <a style="color:white!important; " href="'+bin_url+'" target= "_blank" ><i class="fa fa-paypal" aria-hidden="true"></i></a></div></div> </td> '; 
	              	td += '<td><div class = "item_desc" id="link_other" style="width: 300px;">'+data[i].ITEM_DESC+'</div></td> ';
	              	 td += '<td> <a href="'+data[i].ITEM_URL+'" target= "_blank" >'+data[i].EBAY_ID+'</a></td>';
	              	 td += '<td>'+data[i].TITLE+'</td>'; 
	              	 td += '<td>'+it_condition+'</td>'; 
	              	 td += '<td style="color:red; font-weight: bold;">$ '+parseFloat(data[i].AVG_PRICE).toFixed(2)+'</td>';
	              	 var qty_det_url ='<?php echo base_url("rssfeed/c_rssfeed/qty_detail/"); ?>'+data[i].CATEGORY_ID+'/'+data[i].CATALOGUE_MT_ID+'/'+data[i].CONDITION_ID;
	              	td += '<td><button class="btn btn-xs btn-link qty_sold" id="qty_sold'+maxID+'">'+data[i].QTY_SOLD+'</button> <input type="hidden" id="category_id_'+maxID+'" value="'+data[i].CATEGORY_ID+'"> <input type="hidden" id="catalogue_mt_id_'+maxID+'" value="'+data[i].CATALOGUE_MT_ID+'"> <input type="hidden" id="condition_id_'+maxID+'" value="'+data[i].CONDITION_ID+'"></td>';
	              	 var url ='<?php echo base_url("rssfeed/c_rssfeed/fesibility_index/"); ?>'+data[i].FEED_ID;
	              	 td += '<td><a href="'+url+'" target= "_blank" >'+parseFloat(data[i].FESIBILITY_INDEX).toFixed(2)+' %</a></td> ';
	              	 td += '<td>'+data[i].CATEGORY_ID+'</td> ';
	              	 td += '<td>'+data[i].CATEGORY_NAME+'</td> '; 
	              	
	              	 td += '<td>$ '+parseFloat(data[i].SALE_PRICE).toFixed(2)+'</td>';
	              	td += '<td>'+data[i].START_TIME+'</td>';
	              	td += '<td>'+data[i].NEWLY_LISTED+'</td>';

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

 updateFeed();
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
            var j = i+1;
        		var shipping_cost2 = data[i].SHIPPING_COST;
        		var sale_price2 = data[i].SALE_PRICE;

        		qty_dets.push('<tr><td id = "srno'+i+'" style="color:black;width:60px">'+j+'</td> <td id = "qty_ebay_id'+i+'" style="color:black;width:100px">'+data[i].EBAY_ID+'</td> <td id="qty_title'+i+'" style="color:black;width:200px;">'+data[i].TITLE+'</td> <td id="qty_conditionName'+i+'" style="color:black;width:100px;">'+data[i].CONDITION_NAME+'</td> <td id="qty_soldPrice'+i+'" style="color:black;width:70px;">'+parseFloat(sale_price2).toFixed(2)+'</td> <td id="qty_shippingCost'+i+'" style="color:black;width:70px;">'+parseFloat(shipping_cost2).toFixed(2)+'</td> <td id="qty_startTime'+i+'" style="color:black;width:100px;">'+data[i].START_TIME+'</td> <td id="qty_saleTime'+i+'" style="color:black;width:100px;">'+data[i].SALE_TIME+'</td> </tr>') ;

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

        	$('#rss_tds').html("");
        	$('#rss_tds').append(qty_dets.join(""));


        }
    });
	
	// alert(category_id);
});
/*=====  End of rss Table popup  ======*/

 </script>