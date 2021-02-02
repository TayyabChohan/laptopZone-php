<?php $this->load->view("template/header.php"); ?>

<style type="text/css">
	
	input.form-control.part_mpn_desc {
    width: 430px;
    display: block;
}
input.form-control.part_mpn {
    width: 100px;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Receiving
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Receiving</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
	        <?php if($this->session->flashdata('success')){ ?>
	          <div id="successMessage" class="alert alert-success alert-dismissable">
	            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
	          </div>
	        <?php }elseif($this->session->flashdata('error')){  ?>

	        <div id="errorMessage" class="alert alert-danger alert-dismissable">
	            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
	        </div>

	   		<?php } ?>

	    	<div class="box">
	            <div class="box-header">
	              <h3 class="box-title">Waiting Shipments</h3>
	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div> 
	            </div>
	            <div class="box-body">
              		<div class="row">
              			<div class="col-sm-12" >
              				<div class="col-sm-3"></div>
              				<div class="col-sm-5" id="errorMessage"></div>
              			</div>
              		<!-- <form action="<?php //echo base_url(); ?>catalogueToCash/c_receiving/reciv_add" method="post" accept-charset="utf-8"> -->
              			<div class="col-sm-12">
			                <div class="col-sm-3">
			                	<label for="Tracking Number" class="control-label">Tracking No:</label>
			                	<div class="form-group">
			                		<input type="text" name="tracking_no" id="tracking_no" class="form-control" required>
			                	</div>
			                </div>

			                		<input type="hidden" name="tracking_id" id="tracking_id" class="form-control" required>
			                	
			                <!-- <div class="col-sm-3">
			                	
			                	<div class="form-group"> -->
			                		<input type="hidden" name="lz_bd_cata_id" id="lz_bd_cata_id" class="form-control">
			                <!-- 	</div>
			                </div> -->

			                <div class="col-sm-2">
			                	<label for="Ebay ID" class="control-label">Ebay ID:</label>
			                	<div class="form-group">	
			                		<input style = "color:blue;" type="number" name="ebay_id" id="ebay_id" class="form-control" ebay_link = "url" readonly >
			                		<input type="hidden" name="url" id="url" class="form-control" readonly >
			                		<input type="hidden"  name="get_category" id="get_category" class="form-control" readonly >
			                	</div>
			                </div>
              				<div class="col-sm-6">
              					<label for="Item Desc" class="control-label">Item Description :</label>
			                	<div class="form-group">	
			                		<input type="text" name="item_desc" id="item_description" class="form-control" readonly>
			                	</div>
			                </div>
			               
              			</div>

              			<div class="col-sm-12">
              				<div class="col-sm-2">
              					<label for="MPN" class="control-label">MPN :</label>
			                	<div class="form-group">	
			                		<input type="text" name="waiting_mpn" id="waiting_mpn" class="form-control" >
			                	</div>
			                </div>
			              
			                <!-- <div class="col-sm-3">
              					<label for="UPC" class="control-label">UPC :</label>
			                	<div class="form-group">	
			                		<input type="text" name="upc" id="upc" class="form-control">
			                	</div>
			                </div> -->
			                <div class="col-sm-2">
              					<label for="UPC" class="control-label">Conditon :</label>
			                	<div class="form-group">	
			                		<input type="text" name="condition" id="condition" class="form-control" readonly>
			                		<input type="hidden" name="default_condition" id="default_condition" class="form-control">
			                	</div>
			                </div>
			                <div class="col-sm-2">
              					<label for="Cost Price" class="control-label">Cost Price :</label>
			                	<div class="form-group">	
			                		<input type="number" name="cost_price" id="cost_price"  step="0.01" class="form-control" required="" readonly>
			                	</div>
			                </div>
			                <div class="col-sm-2">
              					<label for="Quantity On" class="control-label">Quantity :</label>
			                	<div class="form-group">

			                		<input type="text" name="Quantity" id="Quantity" class="form-control" value="1" required="">
			                	</div>
			                </div>
			                 <div class="col-sm-2">
              					<label for="Manufacturer" class="control-label">Manufacturer :</label>
			                	<div class="form-group">
			                		<input type="text" name="manufacturer" id="manufacturer" class="form-control" required>
			                	</div>
			                </div>

			                <div class="col-sm-2">
              					
			                	<div class="form-group">
			                		<input type="hidden" name="lot_only" id="lot_only" class="form-control" >
			                	</div>
			                </div>

			               <div class="col-sm-2">
	                  	  <div class="form-group">
 
                          <?php $system_date = $this->session->userdata('system_date'); ?>
                        <!--  <input type="text" class="btn btn-default" name="date_ranges" id="r_date_range" value="<?php //echo $rslt; ?>" />-->
	                    <label for="Received on" class="control-label">Received on:</label>
	                    <div class="input-group">
	                      <div class="input-group-addon">
	                        <i class="fa fa-calendar"></i>
	                      </div>
	                        <input type="text" class="form-control"  value="" id="received_on" name="received_on"  required >
	                    </div>
	                    
	                  </div>              
	                </div>

	                <div class="col-sm-2">
	                  <div class="form-group">
	                    <label for="Received on" class="control-label">Shipping Carrier:</label>
	                  
	                        <select name="shipping" id="shipping" class="form-control">
	                        	<option value="USPS">USPS</option>
	                        	<option value="FEDEX">FedEx</option>
	                        	<option value="UPS">UPS</option>
	                        	<option value="DHL">DHL</option>
	                        	<option value="CHINAPOST">CHINA POST</option>
	                        </select>
	                  </div>              
	                </div>
			                
              			</div>

              			<div class="col-sm-12">
		                	<div class="form-group col-sm-6 p-t-24 " >	
	                		<input type="button" name="post_kit" id="post_kit" value="Post" class="btn btn-primary float-left">	
			                <div class="col-sm-4 ">
			                <div class="form-group ">
			                <label for="Available Qty" class="control-label" style="color: red;">Skip Test:</label>
			                  <input type="radio" class="skip_test" name="skip_test" value="Yes" checked>&nbsp;Yes&nbsp;&nbsp;
			                  <input type="radio" class="skip_test" name="skip_test" value="No" >&nbsp;No
			                </div>
			              </div>
			              </div>
			              <div class="col-sm-6 p-t-24  pull-right ">
			                <div class="form-group ">
			                <input type="button" name="redircect_est" id="redircect_est" value="View Estimate" class="btn btn-primary float-left">	
			                
			                </div>
			              </div>

							<div class="cssload-thecube">
							<div class="cssload-cube cssload-c1"></div>
							<div class="cssload-cube cssload-c2"></div>
							<div class="cssload-cube cssload-c4"></div>
							<div class="cssload-cube cssload-c3"></div>
							</div>
              			</div>
              			<!-- </form> -->
              		</div>

	        	</div>
	        </div>
    	</div>
      </div>
      
   		<div id="single_entry_table">
   			
   		</div>

   		<div id="lot_item_table">
   			
   		</div>

   		<div id="lot_estimate_table">

   		<div class="box box-success form-scroll">
			<div class="box-header with-border"> 
			<h3 class="box-title">Estimate Details</h3>
			<button type="button" class="btn btn-success pull-right" id ="update_lot" style="margin-right:50px;">UPDATE MPN</button>
			<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> </button> </div> 
			</div> 
			<div class="box-body">

			<table id = "update_lot_tab" class="table table-responsive table-striped table-bordered table-hover" > 
				<thead> 
					<th></th>
					<th>COMPONENTS</th>
					<th>MPN</th> 
					<th>MPN DESC</th>
					<th>UPC</th>
					<th>Manufacture</th>
					<th>CONDITION</th> 
					<th>QTY</th>
					<!-- <th>SOLD PRICE</th>  -->
					<th>ESTIMATED PRICE</th>
					<th>EBAY</th>
					<th>PAYPAL</th>
					<th>SHIP</th>
					<th>MPN</th>
					<th>UPC</th>
					<th>LOT ID</th>
					<th>Mpn Desc</th>
				</thead>
				<tbody id ="tbodyid" >
				

				</tbody>
			</table>

			</div>

		</div>
   			
   		</div>

   		<div id="append_estim_data">

   		<div class="box box-success form-scroll">
			<div class="box-header with-border"> 
			<h3 class="box-title">Append Rows</h3>
			<!-- <button type="button" class="btn btn-success pull-right" id ="update_lot" style="margin-right:50px;">UPDATE MPN</button>
			<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> </button> </div> 
			</div>  -->
			<div class="box-body">

			<table id = "append_tab" class="table table-responsive table-striped table-bordered table-hover" > 
				<thead> 
					
					<th>COMPONENTS</th>
					<th>MPN</th> 
					<th>MPN DESC</th>
					<th>UPC</th>
					<th>CONDITION</th> 
					<th>QTY</th>
					<th>SOLD PRICE</th> 
					<th>ESTIMATED PRICE</th>
					<th>EBAY</th>
					<th>PAYPAL</th>
					<th>SHIP</th>
					
				</thead>
				<tbody id ="append_tab_id" >
				

				</tbody>
			</table>

			</div>

		</div>
   			
   		</div> 

        <div class="box">
           <div class="box-header with-border">
             <h3 class="box-title">Last Inserted Tracking Numbers</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>          
             <div class="box-body">
               <div class="col-sm-12">    
				<table id="tracking_nos_table" class="table table-responsive table-striped table-bordered table-hover" > 
				    <thead>
			          <th>Ebay Id</th>
			          <th>TRACKING NO</th>
			          <th>Title</th> 
			          <th>Category</th> 
			          <th>Cost Price</th>   
				    </thead>
				     <tbody>
				     	<?php 
				     	if(count($trackings) > 0){
				     	$i = 1;
				     	foreach($trackings as $tracking){ ?>
				      	<tr>
				      		<td><a href="<?php echo $tracking['ITEM_URL']; ?>" target="_blank" > <?php echo $tracking['EBAY_ID']; ?></a></td>
					        
					        <td><?php echo $tracking['TRACKING_NO']; ?></td>
					        <td><?php echo $tracking['TITLE']; ?></td>
					        <td><?php echo $tracking['CATEGORY_ID']; ?></td>
					        <td><?php echo $tracking['COST_PRICE']; ?></td>
					        <?php
					          $i++;
					          echo "</tr>"; 
					          } 
					          ?>
				           </tbody>
				         </table>
				        <?php } else { ?>
				          </tbody>
				         </table>
				        <?php
				        }
				        ?>
			    	</div>
            	</div>
        	</div>

    </section>
     <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
</div>
 <?php $this->load->view("template/footer.php"); ?>
 <script>
 $(document).ready(function(){

 	$("#lot_estimate_table").hide();
 	$('#errorMessage').hide();

 	$("#post_kit").prop("disabled", true);

 	$('#tracking_nos_table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
    //"iDisplayLength": 15,
  //"aLengthMenu": [[15, 50, 100, 200,500, -1], [15, 50, 100, 200,500, "All"]],
    "paging": false,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "order": [[ 0, "DESC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });


 	$('#tracking_no').on('blur', function(){
      var tracking_no = $(this).val();

      if(tracking_no == ''){
      	$('#errorMessage').html("");
      	$('#errorMessage').append('<p style="color:orange;"><strong>Warning: Please Enter Tracking # !</strong></p>')
      	// $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
      	 $('#errorMessage').show();
      	setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);      	
      	// alert("Warning: Please Enter Tracking #");
      	return false;
      }else{
      	$(".loader").show();   
      //alert(tracking_no); return false;
    $.ajax({
      dataType: 'json',
      type: 'POST',
       
      url:'<?php echo base_url(); ?>catalogueToCash/c_receiving/reciv_data',
      data: {'tracking_no':tracking_no},
     success: function (data){
     	
     	if(data.exist == true){
     		alert("Warning: This Tracking No already posted!");
     		console.log('check_function for single entry');
     		//$('#lot_estimate_table').html('');

     		$("#single_entry_table").show();

     		$("#tbodyid").empty();
     		$("#lot_estimate_table").hide();

     		$('#lot_item_table').html('');
     		$("#lot_item_table").hide();

     		$(".loader").hide();  
     		$("#post_kit").prop("disabled", true);

     		var deleteComplete = '<?php echo base_url(); ?>single_entry/c_single_entry/deleteComplete/'+data.single_entry[0].LZ_MANIFEST_ID;
     		var updateRecordView = '<?php echo base_url(); ?>single_entry/c_single_entry/updateRecordView/'+data.single_entry[0].ID;
     		var single_entry_print = '<?php echo base_url(); ?>single_entry/c_single_entry/single_entry_print/'+data.single_entry[0].LZ_MANIFEST_ID;
     		///////////////////////////////////////////////////
     		if(data.single_entry[0].OLD_BARCODE == null){ 
     			var old_barcode = '';
     		}else{
     			var old_barcode = data.single_entry[0].OLD_BARCODE; 
     		}
     		///////////////////////////////////////////////////
     		if(data.single_entry[0].EBAY_ITEM_ID == null){ 
     			var ebay_item_id = '';
     		}else{
     			var ebay_item_id = data.single_entry[0].EBAY_ITEM_ID; 
     		}
     		///////////////////////////////////////////////////
     		if(data.single_entry[0].LIST_QTY == undefined || data.single_entry[0].LIST_QTY == null){ 
     			var list_qty = '';
     		}else{
     			var list_qty = data.single_entry[0].LIST_QTY; 
     		}
     		////////////////////////////////////////////////////
     		if(data.single_entry[0].ITEM_MT_UPC == null){ 
     			var item_mt_upc = '';
     		}else{
     			var item_mt_upc = data.single_entry[0].ITEM_MT_UPC; 
     		}
     		/////////////////////////////////////////////////////
     		if(data.single_entry[0].ITEM_MT_BBY_SKU == null){ 
     			var item_mt_bby_sku = '';
     		}else{
     			var item_mt_bby_sku = data.single_entry[0].ITEM_MT_BBY_SKU; 
     		}
     		
     		var row = [];
          var alertMsg = "return confirm('Are you sure?');";
          for(var k = 0; k< data.single_entry.length; k++){
              row.push('<tr><td><div class="edit_btun" style="width: 220px !important;"> <a onclick="'+alertMsg+'" style="font-size: 17px !important; margin-right: 3px;" title="Delete Record" href="'+deleteComplete+'" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o p-b-5" aria-hidden="true"></i> </a> <a style="font-size: 17px !important; margin-right: 3px;" id="'+data.single_entry[k].ID+'" title="Delete &amp; Create New" href="#" class="btn btn-warning btn-xs create_delete"> <span class="glyphicon glyphicon-pencil p-b-5 " aria-hidden="true"></span> </a> <a style="font-size: 17px !important; margin-right: 3px;" title="Update Single Entry" href="'+updateRecordView+'" class="btn btn-info btn-xs"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </a> <a style=" margin-right: 3px;" href="'+single_entry_print+'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a></div></td> <td>'+data.single_entry[k].BARCODE_NO+'</td> <td>'+data.single_entry[k].ITEM_MT_MFG_PART_NO+'</td> <td> <div style="width:200px !important;"> '+data.single_entry[k].ITEM_MT_DESC+'</div> </td> <td>'+data.single_entry[k].PO_DETAIL_RETIAL_PRICE+'</td> <td>'+data.single_entry[k].PURCHASE_REF_NO+'</td><td>'+data.single_entry[k].PURCHASE_DATE+'</td><td>'+data.single_entry[k].ITEM_MT_MANUFACTURE+'</td><td>'+list_qty+'</td> <td>'+data.single_entry[k].AVAILABLE_QTY+'</td> <td>'+item_mt_upc+'</td> <td>'+data.single_entry[k].BRAND_SEG3+'</td><td></td></tr>');
               //This adds each thing we want to append to the array in order. //row.join(" ");
           }

          //var model = "";
          // row.push();
          $('#single_entry_table').html('');
          $('#single_entry_table').append('<div class="box"><div class="box-header with-border"> <h3 class="box-title">Tracking No. Single Entry</h3><div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> </button> </div> </div> <div class="box-body form-scroll"><table class="table table-responsive table-striped table-bordered table-hover" > <thead> <tr> <th>ACTION</th> <th>BARCODE</th>  <th>MPN</th><th>DESC</th> <th>PRICE</th><th>REF NO</th> <th>PURCHASE DATE</th> <th>MANUFACTURE</th> <th>LIST QTY</th> <th>AVAILABLE QTY</th> <th>UPC</th><th>CATEGORY</th> <th>CONDITION</th> <th>USER</th></tr> </thead><tbody>'+row.join("")+'</tbody> </table></div></div>');          	
	        
          	//added by adil asad on 1-feb-2018
	        
	        $("#ebay_id").val(data.old_ebay_id[0].EBAY_ID);
	        var test = $("#ebay_id").val(data.old_ebay_id[0].EBAY_ID);
	        console.log(test);
	        $("#item_description").val(data.old_ebay_id[0].TITLE);
	        $("#url").val(data.old_ebay_id[0].ITEM_URL);
	        $("#ebay_id").attr('ebay_link',data.old_ebay_id[0].ITEM_URL);

	        $("#item_description").val(data.old_ebay_id[0].TITLE);
	        $("#waiting_mpn").val(data.single_entry[0].ITEM_MT_MFG_PART_NO);
	        $("#condition").val(data.old_ebay_id[0].CONDITION_NAME);
	        $("#tracking_id").val(data.old_ebay_id[0].TRACKING_NO);
	        $("#default_condition").val(data.old_ebay_id[0].CONDITION_ID);

	       	$("#received_on").val(data.old_ebay_id[0].RECEIVED_ON);
	        $("#Quantity").val(data.single_entry[0].AVAILABLE_QTY);
	        $("#manufacturer").val(data.single_entry[0].ITEM_MT_MANUFACTURE);
	        $("#cost_price").val(data.single_entry[0].PO_DETAIL_RETIAL_PRICE);


	        //added by adil asad on 1-feb-2018
          return false; 
      }
      else if (data.exist == false){
      	alert("Warning: This Tracking No already posted!");

      		$("#lot_item_table").show();      		

      		$('#single_entry_table').html('');
      		$("#single_entry_table").hide();

     		$("#tbodyid").empty();
     		$("#lot_estimate_table").hide();


     		console.log('check_function for lot item'); /// check function for lot items

     		$(".loader").hide();  
     		$("#post_kit").prop("disabled", true);

     		// append barcode of lot items start
     		var lotrow = [];
     		//manifest = data.lot_barcodes[0].LZ_MANIFEST_ID;
     		//console.log(manifest);

     		var print_all = '<?php echo base_url(); ?>catalogueToCash/c_receiving/lotitemsPrintForAll/'+data.lot_barcodes[0].LZ_MANIFEST_ID;

     		for(var k = 0; k< data.lot_barcodes.length; k++){

     		var single_print = '<?php echo base_url(); ?>catalogueToCash/c_receiving/manifest_print/'+data.lot_barcodes[k].LAPTOP_ITEM_CODE+'/'+data.lot_barcodes[k].LZ_MANIFEST_ID+'/'+data.lot_barcodes[k].IT_BARCODE;

     		// href="<?php //echo base_url(); ?>catalogueToCash/c_receiving/manifest_print/<?php //echo @$print_qry['LAPTOP_ITEM_CODE'].'/'.@$print_qry['LZ_MANIFEST_ID'].'/'.@$print_qry['IT_BARCODE']; ?>"

     		//var single_print = '<?php //echo base_url(); ?>single_entry/c_single_entry/single_entry_print/'+data.lot_barcodes[k].LZ_MANIFEST_ID;

     		if(data.lot_barcodes[k].UPC == null){ 
     			var upc = '';
     		}else{
     			var upc = data.lot_barcodes[k].UPC; 
     		}
			if(data.lot_barcodes[k].MANUFACTURER == null){ 
     			var MANUFACTURER = '';
     		}else{
     			var MANUFACTURER = data.lot_barcodes[k].MANUFACTURER; 
     		}

     		 lotrow.push('<tr><td><a style=" " href="'+single_print+'" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a></td><td>'+data.lot_barcodes[k].UNIT_NO+'</td><td>'+data.lot_barcodes[k].IT_BARCODE+'</td><td><div style="width: 220px !important;">'+data.lot_barcodes[k].ITEM_MT_DESC+'</div></td><td>'+upc+'</td><td>'+data.lot_barcodes[k].MFG_PART_NO+'</td><td>'+MANUFACTURER+'</td><td>'+data.lot_barcodes[k].AVAIL_QTY+'</td><td>'+data.lot_barcodes[k].ITEM_CONDITION+'</td></tr>');
//
     		}

     		$('#lot_item_table').html('');
     		$('#lot_item_table').append('<div class="box"><div class="box-header with-border"> <h3 class="box-title">Lot Items Barcode</h3><a href="'+print_all+'" title="Print Sticker for all barcodes" class="btn btn-success btn-sm pull-right" style="margin-right:50px;" target="_blank">Print All</a><div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i> </button> </div> </div> <div class="box-body form-scroll"><table class="table table-responsive table-striped table-bordered table-hover" ><thead><tr><th>Action</th><th>Unit NO</th><th>Barcode NO</th><th style="width: 220px !important;">Desc</th><th>Upc</th><th>Mpn</th><th>Manufacturer</th><th>Qty</th><th>CONDITION</th></tr> </thead><tbody>'+lotrow.join("")+'</tbody> </table></div></div>');

     		// <th>Desc</th>  <th>Upc</th><th>Mpn</th> <th>Manufacturer</th><th>Qty</th><th>CONDITION</th>
     		// append barcode of lot items end 


     		$("#ebay_id").val(data.old_ebay_id[0].EBAY_ID);
	        var test = $("#ebay_id").val(data.old_ebay_id[0].EBAY_ID);
	        console.log(test);
	        $("#item_description").val(data.old_ebay_id[0].TITLE);
	        $("#url").val(data.old_ebay_id[0].ITEM_URL);
	        $("#ebay_id").attr('ebay_link',data.old_ebay_id[0].ITEM_URL);
	        $("#item_description").val(data.old_ebay_id[0].TITLE);
	        $("#condition").val(data.old_ebay_id[0].CONDITION_ID);
	        $("#Quantity").val(data.old_ebay_id[0].AVAILABLE_QTY);
	        $("#received_on").val(data.old_ebay_id[0].RECEIVED_ON);
	        $("#cost_price").val(data.COST_PRICE);


     		return false; 
      }
      else if (data){
       $(".loader").hide();
	     
     
      	$("#lot_estimate_table").show();
      	      		

      		$('#single_entry_table').html(''); 		
      		
      		$("#single_entry_table").hide();
      		$('#lot_item_table').html('');
      		$("#lot_item_table").hide();
      		

		$('#append_tab').DataTable().destroy();
      	var table = $('#append_tab').DataTable();
      	table.clear();

      	$('#update_lot_tab').DataTable().destroy();
      	var table = $('#update_lot_tab').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
      	table.clear();   

      		$("#post_kit").prop("disabled", true);

      		$('#single_entry_table').html('');
      		$('#lot_item_table').html('');
      		console.log('data func for posting data');

     		$("#lz_bd_cata_id").val(data['bd_cata_id'][0].LZ_BD_CATA_ID);
     		$("#get_category").val(data['bd_cata_id'][0].CATEGORY_ID);
	        $("#ebay_id").val(data['bd_cata_id'][0].EBAY_ID);
	        $("#url").val(data['bd_cata_id'][0].ITEM_URL);
	        $("#ebay_id").attr('ebay_link',data['bd_cata_id'][0].ITEM_URL);
	        $("#item_description").val(data['bd_cata_id'][0].TITLE);
	        $("#waiting_mpn").val(data['bd_cata_id'][0].MPN);
	        $("#condition").val(data['bd_cata_id'][0].CONDITION_NAME);
	        $("#tracking_id").val(data['bd_cata_id'][0].TRACKING_NO);
	        $("#default_condition").val(data['bd_cata_id'][0].CONDITION_ID);

	        var spec_val = data.SPECIFIC_VALUE;
	        var lot_val = data['bd_cata_id'][0].KIT_LOT;
	        if (lot_val === 'L') {
	        	$("#manufacturer").val('Lot');
	        }else {
	        	$("#manufacturer").val(spec_val);
	        }        
	        
	        $("#received_on").val(data['bd_cata_id'][0].RECEIVED_ON);
	        $("#lot_only").val(data['bd_cata_id'][0].KIT_LOT);
	        $("#cost_price").val(data.COST_PRICE);

	        // 14-feb-2018 added by adil asad for lot items estimate update start
	        var est_row = [];
          
          	for(var k = 0; k< data.get_lot_estimate.length; k++){
          	var EST_SELL_PRICE = data.get_lot_estimate[k].EST_SELL_PRICE;
                      if( typeof EST_SELL_PRICE == 'object'){
                        EST_SELL_PRICE = JSON.stringify(EST_SELL_PRICE);
                        EST_SELL_PRICE = '';
                      }
                      var MPN_DESCRIPTION = data.get_lot_estimate[k].MPN_DESCRIPTION;
                      if( typeof MPN_DESCRIPTION == 'object'){
                        MPN_DESCRIPTION = JSON.stringify(MPN_DESCRIPTION);
                        MPN_DESCRIPTION = '';                        
                      }
                      var get_upc = data.get_lot_estimate[k].UPC;
                      if( typeof get_upc == 'object'){
                        get_upc = JSON.stringify(get_upc);
                        get_upc = '';                        
                      }
                       var COND_NAME = data.get_lot_estimate[k].COND_NAME;
                      if( typeof COND_NAME == 'object'){
                        COND_NAME = JSON.stringify(COND_NAME);
                        COND_NAME = '';                        
                      }  
                      var manufac = data.get_lot_estimate[k].MANUFAC;
                      if( typeof manufac == 'object'){
                        manufac = JSON.stringify(manufac);
                        manufac = '';                        
                      } 
                      var QTY = data.get_lot_estimate[k].QTY;
                      if( typeof QTY == 'object'){
                        QTY = JSON.stringify(QTY);
                        QTY = '';                        
                      }
                      var get_lot_id = data.get_lot_estimate[k].LOT_ID;
                      if( typeof get_lot_id == 'object'){
                        get_lot_id = JSON.stringify(get_lot_id);
                        get_lot_id = '';
                      }
                      var condition = [];
                      for(var i = 0;i<data.get_conditions.length; i++){
			            if (data.get_conditions[i].ID == data.get_lot_estimate[k].TECH_COND_ID){
			              var selected = "selected";
			            }else {
			              var selected = "";
			            }
			            condition.push('<option value="'+data.get_conditions[i].ID+'" '+selected+'>'+data.get_conditions[i].COND_NAME+'</option>')
			          }
              var tds='<tr><td><button class="btn btn-xs btn-primary  apend_data" id="'+data.get_lot_estimate[k].LZ_ESTIMATE_DET_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-plus " aria-hidden="true"></span></button></td><td><div><input type = "hidden" class="form-control est_det_id" value = "'+data.get_lot_estimate[k].LZ_ESTIMATE_DET_ID+'"></div>'+data.get_lot_estimate[k].OBJECT_NAME+'</td><td ><input type ="hidden" class="form-control part_mpn_id" value = "'+data.get_lot_estimate[k].PART_CATLG_MT_ID+'"><input type ="text" class="form-control part_mpn" value = "'+data.get_lot_estimate[k].MPN+'"></td><td><div><input type ="text" class="form-control part_mpn_desc" value = "'+escapeHtml(MPN_DESCRIPTION)+'"></div></td><td><div><input type ="text" class="form-control item_upc" value = "'+get_upc+'"></div></td><td><div><input type ="text" class="form-control item_manu" value = "'+escapeHtml(manufac)+'"></div></td><td><select class="form-control est_cond_id" name="est_cond_id" style="width: 130px;">'+condition.join("")+'</select></td><td>'+QTY+'</td> <td>'+EST_SELL_PRICE+'</td><td>'+data.get_lot_estimate[k].EBAY_FEE+'</td><td>'+data.get_lot_estimate[k].PAYPAL_FEE+'</td> <td>'+data.get_lot_estimate[k].SHIPPING_FEE+'</td><td>'+data.get_lot_estimate[k].MPN+'</td><td>'+get_upc+'</td><td>'+get_lot_id+'</td><divs style="width:60px;"><td style="width:60px;">'+data.get_lot_estimate[k].MPN_DESCRIPTION+'</td></div></tr>';
               
               table.row.add($(tds)).draw(); 
           }       


	       
 	}else{

     		$('#errorMessage').html("");
	      	$('#errorMessage').append('<p style="color:orange;"><strong>Warning: This Tracking No already posted OR Wrong Tracking #!</strong></p>');
	      	// $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
	      	 $('#errorMessage').show();
	      	setTimeout(function() {
	          $('#errorMessage').fadeOut('slow');
	        }, 3000);
     		// alert("Error: Wrong Tracking No.");
     		$(".loader").hide();
	    }
      //console.log(data);
     },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
    }); 
  }
 });



// CODE ADDED BY ADIL FOR LOT ITEMS MPN UPDATE START
//$('#update_lot').on('click', function(){ 
$(document).on('click','#update_lot',function(){ 

  //var arr=[];
  $(".loader").show();  
  var est_det_id =[];
  var part_mpn =[];
  var part_mpn_desc =[];
  var part_mpn_id =[];
  var item_upc =[];
  var item_manu =[];
  var est_cond_id =[];

  


 var count_table_rows= $("body #update_lot_tab tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "update_lot_tab";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);
  
	//return false;

  for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".est_det_id").each(function() {
              if($(this).val() != ""){
              est_det_id.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".part_mpn").each(function() {
              if($(this).val() != ""){
              part_mpn.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".part_mpn_desc").each(function() {
              if($(this).val() != ""){
              part_mpn_desc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".item_upc").each(function() {
             item_upc.push($(this).val());
            });
            $(tdbk.rows[i]).find(".item_manu").each(function() {
             item_manu.push($(this).val());
            });

            $(tdbk.rows[i]).find(".est_cond_id").each(function() {
              if($(this).val() != ""){
              est_cond_id.push($(this).val());
            }
            }); 
            $(tdbk.rows[i]).find(".part_mpn_id").each(function() {
              if($(this).val() != ""){
              part_mpn_id.push($(this).val());
            }
            }); 
            // $(tdbk.rows[i]).find(".bin_rack").each(function() {
            //   if($(this).val() != ""){
            //   bin_rack.push($(this).val());
            // }
            // }); 

            // $(tdbk.rows[i]).find('.remarks').each(function() {
            //  // if($(this).val() != ""){
            //   remarks.push($(this).val());
            // //}
            // });                         
          }          
           // console.log(part_mpn_desc,item_upc, part_mpn_id, est_cond_id, part_mpn, est_det_id );
           //  return false;
			 

			var url='<?php echo base_url() ?>catalogueToCash/c_receiving/update_lot_mpn';
			//$(".loader").show();  
			$.ajax({    
			      type: 'POST',
			      url:url,
			      data: {
			        'est_det_id': est_det_id,
			        'part_mpn': part_mpn,
			        'part_mpn_id': part_mpn_id,
			        'part_mpn_desc': part_mpn_desc,
			        'item_upc': item_upc,
			        'item_manu': item_manu,
			        'est_cond_id': est_cond_id
			      },
			      dataType: 'json',
			      success: function (data){    
			      $(".loader").hide();        
			          //if(data == true){
			            // $(".loader").hide();
			            //   alert('Components added Successfully!');
			            //   $('#dyn_box').hide();
			            //    $('#dynamic_tab_body').html("");
			            //    $('#dyn_box2').show();
			            //   show_master_detail();                 
			             
			         //    }else{
			         //  alert('data not saved');
			          
			         // }
			        
			       }
			  });  
			});
// CODE ADDED BY ADIL FOR LOT ITEMS MPN UPDATE END 







$("#ebay_id").on('click', function(){
var link = $("#ebay_id").attr("ebay_link");

window.open(link);

});
$("#redircect_est").on('click', function(){
var get_category = $("#get_category").val();
var lz_bd_cata_id = $("#lz_bd_cata_id").val();

var user_id  = "<?php echo $this->session->userdata('user_id'); ?>";


var link = 'http://71.78.236.21:8081/laptopzone/itemsToEstimate/c_itemsToEstimate/lotEstimate/'+lz_bd_cata_id+'/1/'+get_category+'/'+user_id;

// <?php $lz_bd_cata_id  
// 			                $category_id = 16191; ?>
// 							<a target="_blank" class="btn btn-success btn-sm" href='<?php //echo base_url().'itemsToEstimate/c_itemsToEstimate/lotEstimate/'.$lz_bd_cata_id.'/1'.'/'.$category_id ; ?>' id="" title="VIEW LOT">View Estimate</a>
window.open(link);
//window.location.href = '<?php //echo base_url(); ?>catalogueToCash/c_purchasing/updateEstimate/'+cat_id+'/'+mpn_id+'/'+dynamic_cata_id;


});



////////////////////POST TRACKING NUMBER//////////////////////////////////
$("#post_kit").on('click', function(event){
	event.preventDefault();
	/* Act on the event */
	var trackigNo 				=  $("#tracking_no").val();
	var tracking_id 			=  $("#tracking_id").val();
	var shipping  				=  $("#shipping").val();
	var waiting_mpn  			=  $("#waiting_mpn").val();
	var Quantity  				=  $("#Quantity").val();
	var cost_price  			=  $("#cost_price").val();
	var received_on  			=  $("#received_on").val();
	var lot_only  				=  $("#lot_only").val();
	var skip_test  				=  $("input[name='skip_test']:checked").val();
	var manufacturer  		    =  $("input[name='manufacturer']").val();

	if(lot_only == 'L'){
	var url='<?php echo base_url() ?>catalogueToCash/c_receiving/reciev_lot';

	
	}else{
		
	var url='<?php echo base_url() ?>catalogueToCash/c_receiving/reciv_add';
	}

	if (trackigNo =='' ||  Quantity =='' || manufacturer =='') {
		alert("Warning: Input fields are required");
		return false;
	}else {
	 $(".loader").show();
	 $.ajax({
	 	url:url,
      dataType: 'json',
      type: 'POST',
      
	
     // url:'<?php echo base_url(); ?>catalogueToCash/c_receiving/reciv_add',
      data: {'tracking_no':trackigNo,'tracking_id':tracking_id, 'shipping':shipping, 'waiting_mpn':waiting_mpn, 'Quantity':Quantity, 'received_on':received_on, 'cost_price':cost_price, 'skip_test':skip_test, 'manufacturer':manufacturer},
     success: function (data){
     	$(".loader").hide();
     	if (data != false) {
     		$(".loader").hide();
     		if(lot_only == 'L'){
     		//window.location.href = '<?php //echo base_url(); ?>catalogueToCash/c_receiving/lot_items';
     		sticker_url = "<?php echo base_url(); ?>catalogueToCash/c_receiving/lot_items";

     		//var new_url = '<?php //echo base_url() ?>itemsToEstimate/C_itemsToEstimate/showData'; 
     		//var sticker_url = "<?php //echo base_url();?>manifest_loading/c_manf_load/manifest_print/"+ItemCode+'/'+ManifestId+'/'+Barcode;
			var sticker_url = window.open(sticker_url, '_blank');
			sticker_url.location;
			
            //window.open(new_url, '_blank');

     		}else{
     		window.location.href = '<?php echo base_url(); ?>single_entry/c_single_entry/filter_data';
     		}
			
     		}else {
     			alert('Warning: Check posted data');
     			return false;
     		}
     	
		//1145666
  		},
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
	  });
	}
});
/////////////////////////////////////////////////////////////////////////
 });


//var i=0;

$(document).on('click','.apend_data', function(){
$(".loader").show();
	var det_id = this.id.match(/\d+/);
  	det_id = parseInt(det_id);

  	var mtable = $('#update_lot_tab').DataTable();
 
    mtable.row( $("#"+det_id).parents('tr') ).remove().draw();
	
 
    
    var obj = [];
      $.ajax({
       	url:'<?php echo base_url(); ?>catalogueToCash/c_receiving/get_append_data',
        
        type:'post',
        dataType:'json',
        data:{'det_id':det_id},
        success:function(data){

        if(data){
        $(".loader").hide();
        $("#post_kit").prop("disabled", false);

        $('#append_tab').DataTable().destroy();
      	var table = $('#append_tab').DataTable();
      	//table.clear();
         
    	
        

        
       for(var k = 0; k< data.get_lot_estimate.length; k++){
          	var EST_SELL_PRICE = data.get_lot_estimate[k].EST_SELL_PRICE;
                      if( typeof EST_SELL_PRICE == 'object'){
                        EST_SELL_PRICE = JSON.stringify(EST_SELL_PRICE);
                        EST_SELL_PRICE = '';
                        // alert(dekit);
                      }
                      var get_upc = data.get_lot_estimate[k].UPC;
                      if( typeof get_upc == 'object'){
                        get_upc = JSON.stringify(get_upc);
                        get_upc = '';
                        // alert(dekit);
                      }
                       var COND_NAME = data.get_lot_estimate[k].COND_NAME;
                      if( typeof COND_NAME == 'object'){
                        COND_NAME = JSON.stringify(COND_NAME);
                        COND_NAME = '';
                        // alert(dekit);
                      } 
                      var QTY = data.get_lot_estimate[k].QTY;
                      if( typeof QTY == 'object'){
                        QTY = JSON.stringify(QTY);
                        QTY = '';
                        // alert(dekit);
                      } 

              var tds='<tr><td>'+data.get_lot_estimate[k].OBJECT_NAME+'</td><td>'+data.get_lot_estimate[k].MPN+'</td><td>'+data.get_lot_estimate[k].MPN_DESCRIPTION+'</td><td>'+get_upc+'</td><td>'+COND_NAME+'</td> <td>'+QTY+'</td> <td>'+data.get_lot_estimate[k].SOLD_PRICE+'</td><td>'+EST_SELL_PRICE+'</td><td>'+data.get_lot_estimate[k].EBAY_FEE+'</td><td>'+data.get_lot_estimate[k].PAYPAL_FEE+'</td> <td>'+data.get_lot_estimate[k].SHIPPING_FEE+'</td></tr>';
               
                
           }
           table.row.add($(tds)).draw();
           }else{
           	$(".loader").hide();
           }
      }
      }); 
      //i++;        
});// function on add button for append new field for input end 
/*=====================================================================
=            htmlentites alternate for javasciprt function            =
=====================================================================*/
function escapeHtml(text) {
  return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}


/*=====  End of htmlentites alternate for javasciprt function  ======*/

 </script>

	

  


