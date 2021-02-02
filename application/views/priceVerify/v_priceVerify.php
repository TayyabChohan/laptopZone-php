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
              <form action="<?php //echo base_url(); ?>rssFeed/c_rssFeed/CatFilterHotRssFeed" method="post" accept-charset="utf-8">

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
              <div class="col-sm-2 p-t-24 pull-right">
                  <div class="form-group">
                     <a class="btn btn-primary" href="<?php echo base_url('rssfeed/c_rssfeed/addrssfeedurl'); ?>" target="_blank">Add Keyword</a>
                  </div>
                </div> 
            </div>
        </div>  


        <div class="box">
           
        <div class="box-body form-scroll">      
        <div class="col-md-12">
            <table id="priceverifyTable" class="table table-bordered table-striped table-responsive table-hover">

                <thead>
	                <tr>
	                    <th>ACTION</th>
                      <th>CATEGORY ID</th>
	                    <th>MPN</th>
                      <th>CONDITION</th>
	                    <th>DESCRIPTION</th>
	                    <th>AVG PRICE</th> 
                      <th>SELL TROUGH</th>
                      <!-- <th>MAX SOLD PRICE</th> -->
                      <th>QTY SOLD</th>
                      <th>TOTAL VALUE</th>
                      <th>KEYWORD</th>
                      <th>KEYWORD BY</th>
                      <th>KEYWORD DATE</th>
                      <th>VERIFIED BY</th>
                      <th>VERIFIED DATE</th>
                      
	                </tr>
                </thead>

                <tbody>
     
                  <?php 
           //        $i = 1;
           //        foreach (@$data as $row): 
           //        	$it_condition = @$row['CONDITION_ID'];
                  	
		        	// if(@$it_condition == 3000){
			        //   @$it_condition = 'Used';
			        // }elseif(@$it_condition == 1000){
			        //   @$it_condition = 'New'; 
			        // }elseif(@$it_condition == 1500){
			        //   @$it_condition = 'New other'; 
			        // }elseif(@$it_condition == 2000){
			        //     @$it_condition = 'Manufacturer refurbished';
			        // }elseif(@$it_condition == 2500){
			        //   @$it_condition = 'Seller refurbished'; 
			        // }elseif(@$it_condition == 7000){
			        //   @$it_condition = 'For parts or not working'; 
			        // }else{
			        // 	@$it_condition = '';
			        // }
				    // if(!empty(@$row['AVG_PRICE'])){
				    // 	$verified_tr = 'class = "verifiedTr"';
				    // }else{
				    // 	$verified_tr = 'class = ""';
				    // }
					?>

<!-- 					<tr>
                   <td><?php //echo @$row['CATEGORY_ID'];?></td>
                   <td><?php //echo @$row['MPN'];?></td> 
                   <td><?php //echo @$it_condition;?></td>
                   <td><div class = "item_desc" id="link_other" style="width: 300px;"><?php //echo @$row['MPN_DESCRIPTION'];?></div></td>                  
                   <td style="color:red; font-weight: bold;"><?php //echo '$ '. number_format((float)@$row['AVG_PRICE'],2,'.',',') ;?></td>
                   <td style="color:red; font-weight: bold;"><?php //echo '$ '. number_format((float)@$row['MIN_PRICE'],2,'.',',') ;?></td>
                   <td style="color:red; font-weight: bold;"><?php //echo '$ '. number_format((float)@$row['MAX_PRICE'],2,'.',',') ;?></td>
                      <?php
					//$qty_det_url = base_url('rssfeed/c_rssfeed/qty_detail/'.@$row["CATEGORY_ID"].'/'.@$row["CATALOGUE_MT_ID"].'/'.@$row["CONDITION_ID"]);
	              	 
?>
				<td><a href="<?php //echo $qty_det_url; ?>" target= "_blank" ><?php //echo @$row['QTY_SOLD'];?></a></td> 
        					<td>
        						<button class="btn btn-xs btn-link qty_sold" id="qty_sold<?php //echo $i;?>"><?php //echo @$row['QTY_SOLD'];?></button>
        						<input type="hidden" id="category_id_<?php //echo $i;?>" value="<?php //echo $row["CATEGORY_ID"];?>">
        						<input type="hidden" id="catalogue_mt_id_<?php //echo $i;?>" value="<?php //echo $row["CATALOGUE_MT_ID"];?>">
        						<input type="hidden" id="condition_id_<?php //echo $i;?>" value="<?php //echo $row["CONDITION_ID"];?>">
        					</td>
                  <td><?php //echo '$ '. number_format((float)@$row['QTY_SOLD']*@$row['AVG_PRICE'],2,'.',',');?></td>   
    
                          

                    </tr> -->
                    <?php
                    //$i++;
                   //endforeach;
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
                          <h1 class="box-title" style="color:white;">Qty Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body ">
                        <div class="col-md-12" style="color:black!important;">
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="categoryId">CATEGORY ID:</label>
                              <input name="categoryId" type="text" id="categoryId" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="mpn">MPN:</label>
                              <input name="mpn" type="text" id="mpn" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label for="mpn_desc">MPN DESCRIPTION:</label>
                              <input name="mpn_desc" type="text" id="mpn_desc" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="avg_price">AVG PRICE:</label>
                              <input name="avg_price" type="text" id="avg_price" class=" form-control " value="" readonly="readonly">
                            </div>
                          </div>
                          
                        </div>
                        <div class="col-sm-12" style="color:black!important;">
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="sold_qty">SOLD QTY:</label>
                              <input name="sold_qty" type="text" id="sold_qty" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="total_value">TOTAL VALUE:</label>
                              <input name="total_value" type="text" id="total_value" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-4">
                            <div class="form-group">
                              <label for="keyword">KEYWORD:</label>
                              <input name="keyword" type="text" id="keyword" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                          
                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="upc">UPC:</label>
                              <input name="upc" type="text" id="upc" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <div class="form-group">
                              <label for="catalogue_mt_id">MPN ID:</label>
                              <input name="catalogue_mt_id" type="text" id="catalogue_mt_id" class="form-control"  value="" readonly="readonly">
                            </div>
                          </div>
                        </div>
                          <div class="col-md-12 form-scroll">

                            <table id="qtyDetailTable" style="color: #000!important;" class="table table-responsive table-striped table-bordered table-hover ">
                              <thead>
                                <th style="color:black;">ACTION</th>
                                <!-- <th style="color:black;">SR NO</th> -->
                                <th style="color:black;">EBAY ID</th> 
                                <th style="color:black;">TITLE</th>
                                <th style="color:black;">CONDITION NAME</th>
                                <th style="color:black;">LISTING TYPE</th>
                                <th style="color:black;">ITEM LOCATION</th>
                                <th style="color:black;">SOLD PRICE</th>
                                <th style="color:black;">SHIPPING COST</th>
                                <th style="color:black;">TOTAL PRICE</th>
                                <th style="color:black;">START TIME</th>
                                <th style="color:black;">SALE TIME</th>
                                <th style="color:black;">SELLER ID</th>
                              </thead>
                              <tbody id="rss_tds">
                              </tbody>
                            </table>
                          </div>
                          <div class="col-sm-2">
                          <div class="form-group">
                          <input type="hidden" id="mpn_id" name="mpn_id"  value="">
                          <input type="hidden" id="condition_id" name="condition_id"  value="">
                              <input type="button" class="btn btn-success" id="verifyPrice" name="verifyPrice" value="Verify Price">
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
                <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
            </div>
</div>
<!-- detail modal end -->
<!-- Keyword edit modal -->
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
                              <input name="category_Id" type="text" id="category_Id" class="category_id form-control " readonly>
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
                            <div class="col-sm-3">                  
                              <div class="form-group">
                                <label for="Feedback Score" style = "color: black!important;">Price Range:</label>
                              <div class="input-group" >
                                <input type="number" step="0.01" min="0" name ="minPriceUpdate" id="minPriceUpdate" class="form-control clear" value=""  />
                              <span class="input-group-addon" style="border-left: 0; border-right: 0;">To</span>
                                <input type="number" step="0.01" min="0" name ="maxPriceUpdate" id="maxPriceUpdate" class="form-control clear" value="" />
                              </div>
                              </div>
                            </div>
                             <div class="col-sm-1 pull-left p-t-24">
                              <div class="form-group">
                                <input type="button" class="btn btn-primary btn-sm" id="updateUrl" name="updateUrl" value="UPDATE">
                              </div>
                            </div> 
                            <div class="col-sm-1 pull-right p-t-24">
                              <div class="form-group">
                                <input type="button" class="btn btn-success btn-sm verirfyKeyword" id="verirfyKeyword" name="verirfyKeyword" value="VERIFY">
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
<!-- keyword edit modal end -->



 <?php $this->load->view('template/footer'); ?>
 <script>

 $(document).ready(function(){

     $("#priceverifyTable").DataTable({
      "oLanguage": {
      "sInfo": "Total Items: _TOTAL_"
    },
      //"aaSorting": [[11,'desc'],[10,'desc']],
      "order": [[ 6, "desc" ]],
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
        url :"<?php echo base_url().'priceVerify/c_priceVerify/loadData' ?>", // json datasource
        type: "post" , // method  , by default get
        dataType: 'json'
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
        "createdRow": function( row, data, dataIndex){
            if(data){
                $(row).find(".verified").closest( "tr" ).addClass('rowBg');
                }
              }      
    });


/*============================================
=            togale lot qty input            =
============================================*/
  $(document).on('click','.flag-lot',function(){
    var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex;
        rowIndex = parseInt(rowIndex, 10)+parseInt(1, 10);
        $('.qty_wrap_'+rowIndex).toggle();
  });

/*=====  End of togale lot qty input  ======*/

});//document.ready function close



/*=======================================
=            rss Table popup            =
=======================================*/

// $(document).on('click','.qtTy_sold',function(){
// 	var id = this.id.match(/\d+/);
// 	var category_id = $('#category_id_'+id+'').val();
// 	var condition_id = $('#condition_id_'+id+'').val();
// 	var catalogue_mt_id = $('#catalogue_mt_id_'+id+'').val();

// 	$(".loader").show();
//     $.ajax({
//         url: '<?php //echo base_url(); ?>priceVerify/c_priceVerify/qty_detail', 
//         type: 'post',
//         dataType: 'json',
//         data : {'category_id':category_id, 'condition_id':condition_id,'catalogue_mt_id':catalogue_mt_id},
//         success:function(data){
//         	//console.log(data);
//         	$('#myModal').modal('show');
//         	$(".loader").hide();
//           /*====================================================
//           =            remove all rows in datatable            =
//           ====================================================*/
//           var table = $('#qtyDetailTable').DataTable();
//           table.clear().draw();
          
//           /*=====  End of remove all rows in datatable  ======*/
          
//           $('#categoryId').val(data[0].CATEGORY_ID);
//           $('#mpn').val(data[0].MPN);
//           $('#mpn_id').val(data[0].CATALOGUE_MT_ID);
//           $('#mpn_desc').val(data[0].MPN_DESCRIPTION);
//           $('#condition_id').val(data[0].CONDITION_ID);
//           $('#avg_price').val('$ '+data[0].AVG_PRICE);
//           $('#sold_qty').val(data[0].QTY_SOLD);
//           var total_value = parseFloat(data[0].QTY_SOLD) * parseFloat(data[0].AVG_PRICE);
//           $('#total_value').val('$ '+total_value.toFixed(2));

//         	for(var i=0;i<data.length;i++){
//            var total_price = parseFloat(data[i].SALE_PRICE) + parseFloat(data[i].SHIPPING_COST);
//            var qty_dets = '<tr><td><div class="remove_row" style="float: left;padding-right: 5px;" id=""> <button title="Discard" class="btn btn-danger btn-xs flag-trash" style="width: 25px;" fid="'+data[i].CATEGORY_ID+'" id="'+data[i].LZ_BD_CATA_ID+'"><i class="fa fa-trash-o text text-center" aria-hidden="true"> </i> </button> </div></td><td id = "qty_sr_no'+i+'" style="color:black;">'+parseFloat(parseFloat(i)+parseFloat(1))+'</td> <td id = "qty_ebay_id'+i+'" style="color:black;">'+data[i].EBAY_ID+'</td> <td id="qty_title'+i+'" style="color:black;">'+data[i].TITLE+'</td> <td id="qty_conditionName'+i+'" style="color:black;">'+data[i].CONDITION_NAME+'</td><td id="qty_listing_type'+i+'" style="color:black;">'+data[i].LISTING_TYPE+'</td> <td id="qty_soldPrice'+i+'" style="color:black;">$ '+parseFloat(data[i].SALE_PRICE).toFixed(2)+'</td> <td id="qty_shippingCost'+i+'" style="color:black;">$ '+parseFloat(data[i].SHIPPING_COST).toFixed(2)+'</td><td id="qty_totalPrice'+i+'" style="color:black;font-weight:bold;">$ '+parseFloat(total_price).toFixed(2)+'</td><td id="qty_startTime'+i+'" style="color:black;">'+data[i].START_TIME+'</td> <td id="qty_saleTime'+i+'" style="color:black;">'+data[i].SALE_TIME+'</td> </td> <td id="qty_seller_id'+i+'" style="color:black;">'+data[i].SELLER_ID+'</td><td></td></tr>';

//             table.row.add($(qty_dets)).draw(false);
//         	}//end for loop


//         }
//     });
	

// });
/*=====  End of rss Table popup  ======*/
/*======================================================
=            Discard/Delete Button function            =
======================================================*/
  $("body").on('click','.flag-trash', function() {
      //var lz_bd_cata_id = $(this).attr("id");
      //var category_id = $(this).attr("fid");
      var category_id = $('#categoryId').val();
      var mpn_id = $('#mpn_id').val();
      var condition_id = $('#condition_id').val();
      var lz_bd_cata_id=[];
      //var cat_id = $(this).attr("ct_id");
      //console.log(mpn_id,condition_id); return false;
      var oTable = $('#qtyDetailTable').dataTable();
      var rowcollection =  oTable.$(".del-checkbox:checked", {"page": "all"});
      rowcollection.each(function(index,elem){
          //var checkbox_value = $(elem).val();
          //Do something with 'checkbox_value'
          lz_bd_cata_id.push($(elem).val());
      });
      if(lz_bd_cata_id.length<1){
        lz_bd_cata_id.push($(this).attr("id"));
      }
//console.log(lz_bd_cata_id); return false;
      $(".loader").show();
      $.ajax({
          url: '<?php echo base_url(); ?>priceVerify/c_priceVerify/remove_row',
          type: 'post',
          dataType: 'json',
           data : {'lz_bd_cata_id':lz_bd_cata_id, 'category_id':category_id,'mpn_id':mpn_id, 'condition_id':condition_id},
          success: function(data){
        if (data == 0){
                $(".loader").hide();
                alert('Warning: some error occured.Please Retry');
              }else{
                $(".loader").hide();
                  //console.log(data);
                 var table = $('#qtyDetailTable').DataTable();
 
//                     table
//                         .row( $("#"+lz_bd_cata_id).parents('tr') )
//                         .remove()
//                         .draw();

                var tr = $("#"+lz_bd_cata_id).parents('tr');
                $("#"+lz_bd_cata_id).closest('tr').remove();
                // tr.fadeOut(400, function () {
                // table.row(tr).remove().draw();
                // }); commented bcos its refresh the page
                
                $('#sold_qty').val(data[0].QTY_SOLD);
                $('#avg_price').val(data[0].AVG_PRICE);
                $('#total_value').val(data[0].TOTAL_VALUE);
                

              }
          },
          error: function(data){
            $(".loader").hide();
             alert('some error occured.');
          }
      });    
   });
/*=====  End of Discard/Delete Button function  ======*/
/*======================================================
=            verirfy Price Button function            =
======================================================*/
  $("body").on('click','#verifyPrice', function() {
      var category_id = $('#categoryId').val();
      var condition_id = $('#condition_id').val();
      var mpn_id = $('#mpn_id').val();

      //var cat_id = $(this).attr("ct_id");
      //console.log(mpn_id,category_id,condition_id); return false;
      $(".loader").show();
      $.ajax({
          url: '<?php echo base_url(); ?>priceVerify/c_priceVerify/verify_price',
          type: 'post',
          dataType: 'json',
           data : {'mpn_id':mpn_id, 'category_id':category_id, 'condition_id':condition_id},
          success: function(data){
        if (data){
                
              $(".loader").hide();
             alert('MPN Avg Price is Marked As Verified');
              }
          },
          error: function(data){
            $(".loader").hide();
             alert('some error occured.');
          }
      });    
   });
/*=====  End of verirfy Price Button function  ======*/
/*=======================================
=            rss Table popup            =
=======================================*/

$(document).on('click','.qty_sold',function(){
  var id = this.id.match(/\d+/);
  var category_id = $('#category_id_'+id+'').val();
  var condition_id = $('#condition_id_'+id+'').val();
  var catalogue_mt_id = $('#catalogue_mt_id_'+id+'').val();
  var mpn_desc = $('#mpn_desc_'+id+'').val();
  var mpn = $('#mpn_'+id+'').val();
  var avg_price = $('#avg_price_'+id+'').val();
  var sold_qty = $('#sold_qty_'+id+'').val();
  var keyword = $('#keyword_'+id+'').val();
  var upc = $('#upc_'+id+'').val();

  $('#categoryId').val('');
  $('#mpn').val('');
  $('#mpn_id').val('');
  $('#mpn_desc').val('');
  $('#condition_id').val('');
  $('#avg_price').val('');
  $('#sold_qty').val('');
  $('#total_value').val('');
  $('#upc').val('');

  $('#categoryId').val(category_id);
  $('#mpn').val(mpn);
  $('#mpn_id').val(catalogue_mt_id);
  $('#catalogue_mt_id').val(catalogue_mt_id);
  $('#mpn_desc').val(mpn_desc);
  $('#condition_id').val(condition_id);
  $('#avg_price').val(avg_price);
  $('#sold_qty').val(sold_qty);
  $('#upc').val(upc);
   var total_value = parseFloat(avg_price * sold_qty);
   $('#total_value').val(total_value.toFixed(2));
   $('#keyword').val(keyword);

  $(".loader").show();
 $('#myModal').modal('show');
          $(".loader").hide();
  /*====================================================
          =            remove all rows in datatable            =
          ====================================================*/
           var tab= $('#qtyDetailTable').DataTable();
          tab.clear();
          tab.destroy();
          var table = $('#qtyDetailTable').DataTable({  
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
          "aaSorting": [[8,'desc']], // sort on sold Qty desc
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
            data : {'category_id':category_id, 'condition_id':condition_id,'catalogue_mt_id':catalogue_mt_id},
            url :"<?php echo base_url() ?>priceVerify/c_priceVerify/loadQtyData", // json datasource
            type: "post"  // method  , by default get
            // data: {},
            },
          "columnDefs":[{
                "target":[0],
                "orderable":false
              }
            ]

        });//end datatable
       $('#qtyDetailTable tbody').on( 'click', '.supplier_type', function () {

        var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex;

        rowIndex = parseInt(rowIndex, 10)+parseInt(1, 10);
        console.log(rowIndex);
        $('.seller_wrap_'+rowIndex).toggle();

        //var button_text       = $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(10).find('button').val();
        // $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(10).html('');
        // $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(10).append('<button class="btn btn-xs btn-link supplier_type" id="supplier_type" value="'+button_text+'">'+button_text+'</button><div class="col-sm-12"> <div class="btn-group btn-group-horizontal" data-toggle="buttons"> <input type="radio" name="seller_type" id="seller_type" value="1" checked> <span>Lot</span> <input type="radio" name="seller_type" id="seller_type" value="2"><span>Bargain</span> </div> </div><div class="col-sm-12"> <div class="form-group"> <input type="button" class="btn btn-success " id="addSupplier" name="addSupplier" value="Save"> </div> </div>');

    } );  



});
/*=====  End of rss Table popup  ======*/
/*=========================================
=            supplier_type modal            =
=========================================*/
// $(document).on('click','.supplier_type',function(){
//   var seller_id = $(this).text();
//   $(".loader").show();
//   $('#mySeller').modal('show');
//   $(".loader").hide();
//     $('#supplier_id').val(seller_id);

    

// });


/*=====  End of supplier_type modal  ======*/

/*=========================================
=            seller_type modal            =
=========================================*/
$(document).on('click','#addSupplier',function(){
  var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex;
  var seller_id       = $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(11).find('button').val();

  //var seller_id = $('#supplier_id').val();
 // var seller_type = $('#seller_type').val();
  var seller_type = $('input[name=seller_type]:checked').val();
  //console.log(seller_id,seller_type);return false;
  $(".loader").show();

  $.ajax({
    url: '<?php echo base_url(); ?>priceVerify/c_priceVerify/fav_supplier',
    type: 'post',
    dataType: 'json',
     data : {'seller_id':seller_id,'seller_type':seller_type},
    success: function(data){
  if (data==1){
          
        $(".loader").hide();
       alert('Seller Added to favorite List');
        }else if(data==0){
          $(".loader").hide();
       alert('Seller type updated');
        }
    },
    error: function(data){
      $(".loader").hide();
       alert('some error occured.');
    }
  }); 
  
});

/*=====  End of seller_type modal  ======*/

/*=========================================
=            mark as lot function            =
=========================================*/
// $(document).on('click','.flag-llot',function(){
//   var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex;
//   var html       = $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(0).html();

//   $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(0).html('');
//   $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(0).append(html+'<div class="col-sm-12"></div><div class="col-sm-1 p-t-24 tag"> <div class="form-group"> <input name="lot_qty" type="number" id="lot_qty" placeholder="quantity" class="form-control"  value=""> </div> </div> <div class="col-sm-12 tag"> <div class="form-group"> <input type="button" class="btn btn-success " id="save_qty" name="save_qty" value="Save"> </div> </div>');

  
// });


/*=====  End of mark as lot function  ======*/


/*=========================================
=            save lot qty function            =
=========================================*/
$(document).on('click','#save_qty',function(){
  var rowIndex = $(this).closest('td').parent()[0].sectionRowIndex;
  var lot_qty       = $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(0).find('#lot_qty').val();
  if(lot_qty<=1){
    alert('Input Quantity must be greater than 1');
    return false;
  }
  var category_id = $('#categoryId').val();
  var mpn_id = $('#mpn_id').val();
  var condition_id = $('#condition_id').val();
  var lz_bd_cata_id       = $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(0).find('.flag-trash').attr("id");
  var total_price       = $('#qtyDetailTable tr').eq(rowIndex+1).find('td').eq(7).text().replace(/\$/g, '').trim();//remove dolor sign and space

  //console.log(lz_bd_cata_id,category_id,total_price);return false;
  $(".loader").show();

  $.ajax({
    url: '<?php echo base_url(); ?>priceVerify/c_priceVerify/lot_qty',
    type: 'post',
    dataType: 'json',
     data : {'lot_qty':lot_qty,'category_id':category_id,'lz_bd_cata_id':lz_bd_cata_id,'total_price':total_price,'mpn_id':mpn_id,'condition_id':condition_id},
    success: function(data){
  if (data==0){
          
        $(".loader").hide();
       alert('some error occured');
        }else{
          $(".loader").hide();

       var table = $('#qtyDetailTable').DataTable();
 
//                     table
//                         .row( $("#"+lz_bd_cata_id).parents('tr') )
//                         .remove()
//                         .draw();

                var tr = $("#"+lz_bd_cata_id).parents('tr');

                tr.fadeOut(400, function () {
                table.row(tr).remove().draw();
                });
                
                $('#sold_qty').val(data[0].QTY_SOLD);
                $('#avg_price').val(data[0].AVG_PRICE);
                $('#total_value').val(data[0].TOTAL_VALUE);
        }
    },
    error: function(data){
      $(".loader").hide();
       alert('some error occured.');
    }
  }); 
  
});

/*=====  End of save lot qty function  ======*/
$(document).on('click','#verirfyKeyword',function(){
  var feedUrlId               = $('#feedurlid').val();
//alert(feedUrlId); return false;
  //alert(feedUrlId);
  $.ajax({
    url: '<?php echo base_url(); ?>priceVerify/c_priceVerify/verirfyKeyword',
    type:'post',
    dataType:'json',
    data:{'feedUrlId':feedUrlId},
    success: function(data){
      if (data == 1) {
        alert('Keyword is verirfied');
        $('#UpdateKeyword').modal('hide');
      }else{
        alert('Keyword is not verirfied');
        $('#UpdateKeyword').modal('hide');
      }
    }
  });
 });
/*=====================================================
=            update keyword modal function            =
=====================================================*/
$(document).on('click','.editKeyword',function(){ 
  var feedUrlId = this.id;
  
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>rssfeed/c_rssfeed/update_feed_url', 
        type: 'post',
        dataType: 'json',
        data : {'feedUrlId':feedUrlId},
        success:function(data){
          //console.log(data.results);
          $('#UpdateKeyword').modal('show');
          $(".loader").hide();
          if (data.results.length > 0) {
              $('#feed_Name').val("");
              $('#feed_Name').val(data.results[0].FEED_NAME);

              $('#key_Word').val("");
              $('#key_Word').val(data.results[0].KEYWORD);

              $('#category_Id').val("");
              $('#category_Id').val(data.results[0].CATEGORY_ID);

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

/*================================================
=            update feed url function            =
================================================*/
$(document).on('click','#updateUrl',function(){
var feedUrlId               = $('#feedurlid').val();
var catalogue_mt_id         = $('#catalogue_mt_id').val();
var feedName                = $('#feed_Name').val();
var keyword                 = $('#key_Word').val();
var excludeWord             = $('#exclude_Word').val();
var category_id             = $('#category_Id').val();
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
        url: '<?php echo base_url(); ?>priceVerify/c_priceVerify/updateUrl', 
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
            $('#UpdateKeyword').modal('hide');
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

/*==============================================================
  =                 Delete keyword function            =
  ================================================================*/
$(document).on('click', '.delFeedUrl', function(){
  var feed_url_id = $(this).attr("id");
  var this_tr = $(this).closest('tr');
  //alert(feed_url_id);return false;
  var x = confirm("Are you sure?");
  if(x){
    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>priceVerify/c_priceVerify/del_kw',
      type:'post',
      dataType:'json',
      data:{'feed_url_id':feed_url_id},
      success:function(data){
         if(data == 1){
          $(".loader").hide();
          var table = $('#priceverifyTable').DataTable();          
          this_tr.fadeOut(1000, function () { table.row(this_tr).remove().draw() });
         }else{
          alert("Error! keyword not deleted");
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

 /*===============END OF Delete keyword function===================*/

 </script>
<style>
 .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
 
 label.btn span {
  font-size: 1.5em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: #7AA3CC;
}

div[data-toggle="buttons"] label.active{
    color: #7AA3CC;
}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid 
#c8c8c8;
border-radius: 3px;
color: #c8c8c8;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: #7AA3CC;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
#contentSec{
  display: none;
}
#objectSection{
  display: none;
} 

</style> 