<?php $this->load->view("template/header.php"); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <style type="text/css">
    	.lotbtn{
    		display:none;
    	}
    </style>
    <section class="content-header">
      <h1>
        Technician
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Technician</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
	       <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success" id="success_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-danger" id="error_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
            <div class="alert alert-warning" id="warning_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
            <div class="alert alert-danger" id="compo_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
            </div>
            <?php } ?>

	    	<div class="box">
	            <div class="box-header with-border">
	              <h3 class="box-title">Technician</h3>
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
              		<form action="<?php echo base_url(); ?>catalogueToCash/c_technician/estim_data" method="post" accept-charset="utf-8">
              			<div class="col-sm-12">
			                <div class="col-sm-3">
			                	<label for="LZ BarCode" class="control-label">LZ BarCode :</label>
			                	<div class="form-group">
			                		<input type="number" name="lz_bar_code" id="lz_bar_code" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_barcode')){ echo $barcodeNo = @$this->session->userdata('ctc_kit_barcode');} ?>">
			                		
			                	</div>
			                </div>
			                
              				<div class="col-sm-6">
              					<label for="Item Desc" class="control-label">Item Description :</label>
			                	<div class="form-group">	
			                		<input type="text" name="bar_code_desc" id="bar_code_description" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_desc'))  { echo htmlentities(@$this->session->userdata('ctc_kit_desc')); } ?>" readonly >
			                		
			                	</div>
			                </div>

			                <div class="col-sm-3">
              					<label for="LZ_MPN" class="control-label">MPN :</label>
			                	<div class="form-group">	
			                		<input type="text" name="lz_mpn" id="lz_mpn" class="form-control" value = "<?php if (@$this->session->userdata('ctc_kit_mpn')) { echo @$this->session->userdata('ctc_kit_mpn'); }?>" readonly >
			                	</div>
			                </div>
			               
              			</div>
              			<div class="col-sm-12">
			                <div class="col-sm-3">
			                	<?php //var_dump($this->session->userdata('ctc_kit_cond')); ?>	
              					<label for="UPC" class="control-label">UPC :</label>
			                	<div class="form-group">

			                		<input type="text" name="lz_upc" id="lz_upc" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_upc')) { echo @$this->session->userdata('ctc_kit_upc');} ?>" readonly  >
			                	</div>
			                </div>

			                 <div class="col-sm-3">
              					<label for="UPC" class="control-label">Conditon :</label>
			                	<div class="form-group">	
			                		<input type="text" name="lz_condition" id="lz_condition" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_cond')) { echo @$this->session->userdata('ctc_kit_cond');} ?>" readonly >
			                	</div>
			                </div>
			                <div class="col-sm-3">
              					<label for="Cost Price" class="control-label">Cost Price :</label>
			                	<div class="form-group">	
			                		<input type="text" name="cost_price" id="cost_price" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_cost_price')) { echo @$this->session->userdata('ctc_kit_cost_price');} ?>" readonly >
			                	</div>
			                </div>
			                <div class="col-sm-3">
              					<label for="QTY" class="control-label">Qty :</label>
			                	<div class="form-group">	
			                		<input type="text" name="qty" id="qty" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_qty')) {  echo @$this->session->userdata('ctc_kit_qty');} ?>" readonly >
			                	</div>
			                </div>
			               
			                <div class="col-sm-3">
              					<label for="Received On" class="control-label">Received On :</label>
			                	<div class="form-group">	
			                		<input type="text" name="lz_received_on" id="lz_received_on" class="form-control" value="<?php if (@$this->session->userdata('ctc_kit_purchase_date')) {  echo @$this->session->userdata('ctc_kit_purchase_date');} ?>" readonly >
			                	</div>
			                </div>
			                <div class="col-sm-3">
              					<label for="Tracking No" class="control-label">Tracking No :</label>
			                	<div class="form-group">	
			                		<input type="text" name="lz_track_no" id="lz_track_no" class="form-control" value="<?php if (@$this->session->userdata('lz_track_no')) {  echo @$this->session->userdata('lz_track_no');} ?>" readonly >
			                	</div>
			                </div>				                
			                <input type="hidden" name="lz_single_entry_id" id="lz_single_entry_id" value="<?php if (@$this->session->userdata('lz_single_entry_id')) {  echo @$this->session->userdata('lz_single_entry_id');} ?>" class="form-control">

			                <input type="hidden" name="tech_item_id" id="tech_item_id" class="form-control" value="<?php if (@$this->session->userdata('item_id')) { echo @$this->session->userdata('item_id');} ?>"   >
			                <input type="hidden" name="manifist_id" id="manifist_id" class="form-control" value="<?php if (@$this->session->userdata('lz_manifest_id')) { echo @$this->session->userdata('lz_manifest_id');} ?>"   >


			                <input type="hidden" name="catalog_id" id="catalog_id" class="form-control" value="<?php if (@$this->session->userdata('catalog_id')) { echo $catalog_id = @$this->session->userdata('catalog_id');} ?>"   >

			                
			                <input type="hidden" name="category_id" id="category_id" class="form-control" value="<?php if (@$this->session->userdata('category_id')) { echo $cat_id = @$this->session->userdata('category_id');} ?>"   >

			                <input type="hidden" name="lz_bd_cata_id" id="lz_bd_cata_id" class="form-control" value="<?php if (@$this->session->userdata('lz_bd_cata_id')) { echo @$this->session->userdata('lz_bd_cata_id');} ?>"   >
			              
			                <div class="col-sm-1">
              				
			                	<div class="form-group p-t-24">	
			                		<input type="submit" name="det_kit" id="det_kit" value="De Kit" class="btn btn-primary btn-sm">
			                	</div>
			                </div>
			                <!-- <div class="col-sm-2">
			                	<div class="form-group p-t-24">	
			                	<input id ="add_component" type="button" name="add_component" class="btn btn-success btn-sm" value ="Add Compnents">
			                	</div>
			                </div> -->

			                <!-- <div class="col-sm-2" id="lot_view">
				              <div class="form-group  p-t-24">
				              <button type="button" title="Create Kit"  class="btn btn-primary btn-sm" name="lotViewLoad" id="lotViewLoad">Lot View</button>
				               <a target="_blank" class="btn btn-primary btn-sm" href="<?php //echo base_url().'catalogueToCash/c_technician/kitComponents/'.@$cat_id.'/'.@$catalog_id.'/'.@$barcodeNo; ?>" id="" class="" title="Show Mpn">Lot View</a>
				              </div>
			            	</div> -->
			                
              			</div>
              			<div class="col-sm-12">
              				<div id="dekit_table">
              					
              				</div>
              			</div>
					</form>
              		</div>
	        	</div>
	        </div>                                     
    	</div>
      </div>
      <!-- ///////////////////////////////////////////////////////////////// -->
      
<!-- ////////////////////////////search component end//////////////////////////////// -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
</div>



 <?php $this->load->view("template/footer.php"); ?>

<script>
$(document).ready(function(){
	$('#errorMessage').hide();
     $('#dekit-components-table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });


$(".comp_delete").on('click', function(event) {
  event.preventDefault();
  /* Act on the event */
  var  row_id = $(this).attr("rd");
  var  est_det_id = $(this).attr("id");
  //console.log(est_det_id, row_id); return false;
  $(".loader").show();
   $.ajax({
          type: 'POST',
          dataType: 'json',
          url:'<?php echo base_url(); ?>catalogueToCash/c_technician/delete_kit_comp',
          data:{ 
                'est_det_id' : est_det_id
                },
         success: function (data) {
         	$(".loader").hide();
          if(data == true){
          	alert("Component is deleted");
          	var row=$("#"+est_det_id);     
          	row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });
          return false;
         //$('#'+id).remove();
        }else if(data == false){
          alert("Error: Failed to delete the component!");
        }
               
        }, //success
       complete: function(data){
      $(".loader").hide();
    } 
  }); ///ajax call
});

 }); ///end main ready() function



</script>
 <script>
 $(document).ready(function(){


 	 $('#lz_bar_code').on('blur', function(){
     var lz_bar_code = $(this).val();
    if (lz_bar_code.length === 0) 
    { 
    	$('#errorMessage').html("");
      	$('#errorMessage').append('<p style="color:orange;"><strong>Warning: Please insert barcode !</strong></p>')
      	// $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
      	 $('#errorMessage').show();
      	setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
        // alert('Please insert barcode'); 
        return false;
    }else {
    	$(".lotbtn").show(); 
    	//$(".lotbtn").remove();  
    	$(".loader").show();   
    $.ajax({
      dataType: 'json',
      type: 'POST',
       
      
      url:'<?php echo base_url(); ?>catalogueToCash/c_technician/tech_data',
      data: {'lz_bar_code':lz_bar_code},
     success: function (data){
     	$(".loader").hide();
     	$("#det_kit").show();
     	$("#add_component").show();
     	$("#dekit_data_section").show();
       //console.log(data); return false;
     if (data.res == true) {
     	   $('#dekit_table').hide();
     	   $("#bar_code_description").val(data.barcode_detail[0].ITEM_MT_DESC);
	       $("#lz_condition").val(data.barcode_detail[0].CONDITIONS_SEG5);
	       //$(".dekit_condition").val(data.barcode_detail[0].CONDITIONS_SEG5);
	       $("#lz_mpn").val(data.barcode_detail[0].ITEM_MT_MFG_PART_NO);
	       $("#lz_received_on").val(data.barcode_detail[0].PURCHASE_DATE);
	       $("#received_on").val(data.barcode_detail[0].PURCHASE_DATE);
	       $("#lz_upc").val(data.barcode_detail[0].ITEM_MT_UPC);
	       $("#tech_item_id").val(data.barcode_detail[0].ITEM_ID);

	       $("#manifist_id").val(data.barcode_detail[0].LZ_MANIFEST_ID);
	       
	       $("#mpn").val(data.barcode_detail[0].ITEM_MT_MFG_PART_NO);
	       //$("#mpn2").val(data.barcode_detail[0].ITEM_MT_MFG_PART_NO);

	       $("#qty").val(data.barcode_detail[0].AVAILABLE_QTY);
	       $("#qty2").val(data.barcode_detail[0].AVAILABLE_QTY);
	       $("#cost_price").val(data.barcode_detail[0].PO_DETAIL_RETIAL_PRICE);
	       $("#lz_single_entry_id").val(data.barcode_detail[0].ID);
	       $("#category_id").val(data.barcode_detail[0].CATEGORY_ID);
	       $("#catalog_id").val(data.barcode_detail[0].CATALOGUE_MT_ID);
	       $("#lz_bd_cata_id").val(data.barcode_detail[0].LZ_BD_CATA_ID);
	       $("#lz_track_no").val(data.barcode_detail[0].TRACKING_NO);
	       window.location.reload();	       
	       	
	       /* $(".cssload-thecube").hide();*/
     }else if(data.res == false){
     	//console.log(data.estimate_detail); return false;
     	$("#det_kit").hide();
     	$("#add_component").hide();
     	$("#dekit_data_section").hide();
     		alert('warning: This item is de kit already!');
     		$(".loader").hide();
     		$("#item_components").hide();
     		$('#dekit_table').hide();
     		$("#bar_code_description").val(data.barcode_detail[0].ITEM_MT_DESC);
	       $("#lz_condition").val(data.barcode_detail[0].CONDITIONS_SEG5);
	       //$(".dekit_condition").val(data.barcode_detail[0].CONDITIONS_SEG5);
	       $("#lz_mpn").val(data.barcode_detail[0].ITEM_MT_MFG_PART_NO);
	       $("#lz_received_on").val(data.barcode_detail[0].PURCHASE_DATE);
	       $("#received_on").val(data.barcode_detail[0].PURCHASE_DATE);
	       $("#lz_upc").val(data.barcode_detail[0].ITEM_MT_UPC);
	       $("#tech_item_id").val(data.barcode_detail[0].ITEM_ID);
	       $("#manifist_id").val(data.barcode_detail[0].LZ_MANIFEST_ID);
	       $("#mpn").val(data.barcode_detail[0].ITEM_MT_MFG_PART_NO);
	       //$("#mpn2").val(data.barcode_detail[0].ITEM_MT_MFG_PART_NO);

	       $("#qty").val(data.barcode_detail[0].AVAILABLE_QTY);
	       $("#qty2").val(data.barcode_detail[0].AVAILABLE_QTY);
	       $("#cost_price").val(data.barcode_detail[0].PO_DETAIL_RETIAL_PRICE);
	       $("#lz_single_entry_id").val(data.barcode_detail[0].ID);
	       $("#category_id").val(data.barcode_detail[0].CATEGORY_ID);
	       $("#catalog_id").val(data.barcode_detail[0].CATALOGUE_MT_ID);
	       $("#lz_bd_cata_id").val(data.barcode_detail[0].LZ_BD_CATA_ID);
	       $("#lz_track_no").val(data.barcode_detail[0].TRACKING_NO);	       


	       
     		var row = [];
          for(var k = 0; k< data.estimate_detail.length; k++){
              row.push('<tr><td>'+data.estimate_detail[k].OBJECT_NAME+'</td><td>'+data.estimate_detail[k].MPN+'</td><td>'+data.estimate_detail[k].QTY+'</td><td> $'+parseFloat(parseFloat(data.estimate_detail[k].EST_SELL_PRICE)).toFixed(2)+'</td><td> $'+parseFloat(parseFloat(data.estimate_detail[k].EBAY_FEE)).toFixed(2)+'</td><td> $'+parseFloat(parseFloat(data.estimate_detail[k].PAYPAL_FEE)).toFixed(2)+'</td><td> $'+parseFloat(parseFloat(data.estimate_detail[k].SHIPPING_FEE)).toFixed(2)+'</td></tr>'); //This adds each thing we want to append to the array in order.
           }
          $('#dekit_table').html('');
          var tt =$('#dekit_table').append('<table class="table table-responsive table-striped table-bordered table-hover" > <thead><tr><th>OBJECT NAME</th><th>MPN</th> <th>QTY</th><th>ESTIMATE PRICE</th> <th>EBAY FEE</th> <th>PAYPAL FEE</th> <th>SHIPPING FEE</th></tr> </thead><tbody>'+row.join("")+'</tbody> </table>');
     	 //window.location.href = '<?php //echo base_url(); ?>catalogueToCash/c_technician';
     	 //console.log(tt); return false;
     	return false;
     }
     

     }
    }); 
    }
 });
  /*==============================================================
  =                 ONCHANGE MPN GET ITS OBJECTS START         =
  ================================================================*/ 
  $("#det_kit").on('click', function() {
  	/* Act on the event */
  	 $("#add_component").hide();
  });
 
   /*==============================================================
  =                 ONCHANGE MPN GET ITS OBJECTS START         =
  ================================================================*/  
    function lotViewLoad(){
    var cat_id= $("#category_id").val();
    var mpn_id = $("#catalog_id").val();
    var lz_bar_code = $("#lz_bar_code").val();
    if (cat_id =='' || mpn_id =='' || lz_bar_code =='') {

    }else {
    	//console.log(category_id, catalog_id, lz_bar_code); return false;
    // alert(bd_mpn);return false;
      $.ajax({
          url:'<?php echo base_url() ?>catalogueToCash/c_technician/lotViewLoad',
          type: 'POST',
          dataType: 'json',
          data:{'category_id':cat_id, 'catalog_id':mpn_id, 'lz_bar_code':lz_bar_code},

          success: function(data){
          	//console.log(data); return false;
			
			
			var avg_price = 0;
			var table = $('#kit-components-table').DataTable();
 			// alert(data.length);return false;
          for(var i = 0;i<data.results.length;i++){
          		var row_id = parseFloat(parseFloat(i) + parseFloat(1));
          		var mpns = [];
          		for(var j = 0; j<data.conditions.length; j++){
	              if (data.results[i].CONDITION_ID == data.conditions[j].ID){
	                              var selected = "selected";
	                            }else {
	                                var selected = "";
	                            }

              	mpns.push('<option value="'+data.conditions[j].ID+'" '+selected+'>'+data.conditions[j].COND_NAME+'</option>');
            } 
            		//var row_id         = parseFloat(parseFloat(data.totals) + parseFloat(1));
                    var quantity       = data.results[i].QTY;
                     var alertMsg = "return confirm('Are you sure to delete?');";
                      /*var delete_comp = '<?php //echo base_url(); ?>catalogueToCash/c_technician/cp_delete_component/'+cat_id+'/'+mpn_id+'/'+lz_bar_code+'/'+data.results[i].MPN_KIT_MT_ID;*/
                       
                        if(quantity == '' || quantity == null) {var qty = 1 }else{ var qty = data.results[i].QTY;  }
                        if(avg_price == '' || avg_price == null) { var est_price = parseFloat(1.00).toFixed(2) }else{ var est_price = avg_price;  }

                        var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);

                        if(amount == '' || amount == null) {var row_amount = parseFloat(0.00).toFixed(2)}else{ var row_amount = amount;  }
                        //////////////////////////////

                        var ebay_price = (row_amount * (8 / 100)).toFixed(2); 
                        if(ebay_price == '' || ebay_price == null) {var row_ebay_price = parseFloat(0.00).toFixed(2) }else{ var row_ebay_price = parseFloat(ebay_price).toFixed(2);  }
                        var paypal_price = parseFloat((parseFloat(row_amount)  * (2.5 / 100))).toFixed(2);
                       
                        var total = parseFloat(parseFloat(row_amount) + parseFloat(row_ebay_price) + parseFloat(paypal_price) + parseFloat(3.25)).toFixed(2);
                  
                        var est_price_name = 'cata_est_price_'+row_id;
                        /*var table = $('#kit-components-table').DataTable();
                        table.row.add(  ).draw();*/
                        var tds='<td><button title="Delete Component" id="'+data.results[i].MPN_KIT_MT_ID+'" onclick="'+alertMsg+'" class="btn btn-danger btn-xs del-components"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </button> </td> <td>'+data.results[i].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.results[i].MPN_KIT_MT_ID+'"> </td> <td>'+data.results[i].MPN+'</td><td>'+data.results[i].MPN_DESCRIPTION+'</td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.results[i].PART_CATLG_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.results[i].PART_CATLG_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.results[i].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.results[i].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+qty+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$'+est_price+'" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+row_amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+row_ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+total+'</p></td>';

                        var myDataRow = '<tr">'+tds+'</tr>';
	             	table.row.add($(myDataRow)).draw(); 
		            
		          }
		          //console.log(table_rows);
		          /* var table = $('#kit-components-table').DataTable();
                  table.rows.add($(table_rows)).draw();*/   

              $('.dynamic').each(function(idx, elem){

                  $(elem).text(idx+1);
                
              });
           }
        });	
    } /// end if else main
    
}
lotViewLoad();
  /*==============================================================
  =                 ONCHANGE MPN GET ITS OBJECTS START         =
  ================================================================*/
  $("body").on('click','.del-components', function() {
   var lz_bd_cata_id = $(this).attr("id");
    $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>catalogueToCash/c_technician/cp_del_component', 
        //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
         data : {'lz_bd_cata_id':lz_bd_cata_id},
        success: function(data){
          $(".loader").hide();
            if(data == true){
              $(".loader").hide();
              /*var row=$("#"+lz_bd_cata_id);
              //debugger;     
              row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });*/
              window.location.reload();
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
  /*==============================================================
  =                 ONCHANGE MPN GET ITS OBJECTS START         	=
  ================================================================*/

$("#bd_mpn" ).change(function(){
  var bd_mpn = $("#bd_mpn").val();
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
    success: function (data) {
    	$(".loader").hide();
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});
///////////////////////////////

  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $.ajax({
    url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/loadBdMpn',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id},
    success:function(data){
    	$(".loader").hide();
      var mpns = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>')
      }
      $('#bdMPN').html("");
      $('#bdMPN').append('<label>Component MPN:</label><select name="bd_mpn" id="bd_mpn" class="form-control bdMPNS" data-live-search="true" required>'+mpns.join("")+'</select>');
      $('.bdMPNS').selectpicker();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
  $("#add_kit_component").click(function(){
$("#component-toggle").toggle();
});
  /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$("#save_mpn_kit").on('click', function(){

    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/addKitComponent';
    // var bd_alt_object = $("#bd_alt_object").val();
    var ct_category_id              = $("#ct_category_id").val();
    var catalogue_mpn_id            = $("#ct_catlogue_mt_id").val();
    var ct_cata_id                  = $("#ct_cata_id").val();

    var bd_mpn                      = $("#bd_mpn").val();
    var kit_qty                     = $("#kit_qty").val();

    //console.log(catalogue_mpn_id, bd_mpn, kit_qty, ct_category_id); return false;
    // alert(bd_mpn);return false;
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'catalogue_mpn_id': catalogue_mpn_id,
      'bd_mpn': bd_mpn,
      'kit_qty' : kit_qty
    },
    dataType: 'json',
    success: function (data){
    	$(".loader").hide();
      if(data == 1){
        alert("Success: Estimate is created!");
        window.location.reload();
      }else{
        alert("Error: Fail to create Estimate! Try Again");
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

  /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
   /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $("#dekit_post").click(function(){
    //this.disabled = true;
	 var barcode_no = $("#lz_bar_code").val();
	 var lz_single_entry_id = $("#lz_single_entry_id").val();
	 var check_mpn_desc = $(".mpn_desc").val();
	 var check_manfac = $(".kit_brand").val();
	 var item_id = $("#tech_item_id").val();
	 var cost2 = $("#cost_price").val();
	 var manifist_id = $("#manifist_id").val();
	 var qty = $("#qty").val();
	 if(check_mpn_desc == "" || check_mpn_desc == null){
	 	alert('Warning: Please fill MPN Description field.');
	 	return false;
	 }else if(check_manfac == "" || check_manfac == null){
	 	alert('Warning: Please fill MANUFACTURER field.');
	 	return false;
	 }
	 var est_det_id =[];
	  //var arr=[];
	  var url='<?php echo base_url() ?>catalogueToCash/c_technician/dekitManifestPosting';
	  var objName=[];
	  
	  var kitMpn=[];

	  var kitQty=[];
	  var part_mt_id=[];
	  var kitCondition=[];
	  var condDesc=[];
	  var specificPic = [];
	  var locationBin=[];
	  var kitBrand=[];
	  var mpn_desc = [];
	  var weight  = [];
      var tableId="dekit-components-table";
      var tdbk = document.getElementById(tableId);
   	 
      var arr = $('#'+tableId+' tr').length-1;
	  //console.log(arr); return false;
       for (var i = 0; i < arr; i++)
          {

          	//console.log(i);
          	est_det_id.push($("#est_det_id_"+(i+1)).val());

          	specificPic.push($("#specific_picture_"+(i+1)).prop('checked'));

            objName.push($(tdbk.rows[i+1].cells[1]).text().trim());
            kitMpn.push($(tdbk.rows[i+1].cells[2]).text());

              $(tdbk.rows[i+1]).find('.dekit_qty').each(function() {
                kitQty.push($(this).val());
              }); 

              $(tdbk.rows[i+1]).find('.part_mt_id').each(function() {
                part_mt_id.push($(this).val());
              }); 

              $(tdbk.rows[i+1]).find('.dekit_condition').each(function() {
                kitCondition.push($(this).val());
              });

              $(tdbk.rows[i+1]).find('.tech_remark').each(function(){
                condDesc.push($(this).val());
              });

              $(tdbk.rows[i+1]).find('.mpn_desc').each(function(){
                mpn_desc.push($(this).val());
              });


              $(tdbk.rows[i+1]).find('.location_bin').each(function(){
                locationBin.push($(this).val());
              });

              $(tdbk.rows[i+1]).find('.kitBrand').each(function(){
                kitBrand.push($(this).val());
              }); 
               $(tdbk.rows[i+1]).find('.objWeight').each(function(){
                weight.push($(this).val());
              });          
          }
          
kitCondition = kitCondition.filter(v=>v!="");
//console.log(barcode_no, objName, est_det_id, kitMpn, kitQty, kitCondition, condDesc, specificPic, locationBin); return false;
//console.log(specificPic); return false;
$(".loader").show();
  $.ajax({
    type: 'POST',
    url:url,
    data: {
      'lz_single_entry_id': lz_single_entry_id,
      'barcode_no': barcode_no,
      'item_id': item_id,
      'cost2': cost2,
      'manifist_id': manifist_id,
      'qty': qty,
      'objName': objName,
      'kitMpn': kitMpn,
      'kitQty': kitQty,
      'part_mt_id': part_mt_id,
      'kitCondition': kitCondition,
      'condDesc': condDesc,
      'specificPic': specificPic,
      'locationBin': locationBin,
      'kitBrand': kitBrand,
      'est_det_id': est_det_id,
      'mpn_desc':mpn_desc,
      'weight':weight
    },
    dataType: 'json',
    success: function (data){
    	$(".loader").hide();
         if(data){
         	$(".loader").hide();
               alert("Success: Item de kit is saved!"); 
               window.location.href = '<?php echo base_url(); ?>catalogueToCash/C_dekit_sticker/lister_view';   
         }else{
         	$(".loader").hide();
           	alert('Error: Item de kit saving failed!');
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
  //-- for disabling save button--//
   //$("#dekit_post").prop('disabled',true);
   //-for disabling save button-//
  });
//////////////////////////////
 });
 </script>
 <script type="text/javascript">
 	var i = 1;
 	$(document).ready(function(){

 		$('#kits_Table ').append('<tr><td style="width:75px;"><div style="width:100%;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no[]" value="1"  readonly></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="object'+i+'" name="object[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="mpn'+i+'" name="mpn[]" ></div></td></td><td style="width:120px;"><div style="width:100%;"><input type="number" class="form-control" id="qty'+i+'" name="qty[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="condition'+i+'" name="condition[]" ></div></td><td style="width:250px;"><div style="width:100%;"><input type="text" class="form-control" id="remarks'+i+'" name="remarks[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="specific'+i+'" name="specific[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="location'+i+'" name="location[]" ></div></td><td style="width:30pxl"><div style="width:100%;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
 	});

 	$(document).on('click','#add',function(){
 		i++;
 		$('#kits_Table ').append('<tr><td style="width:75px;"><div style="width:100%;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no[]" value="1"  readonly></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="object'+i+'" name="object[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="mpn'+i+'" name="mpn[]" ></div></td></td><td style="width:120px;"><div style="width:100%;"><input type="number" class="form-control" id="qty'+i+'" name="qty[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="condition'+i+'" name="condition[]" ></div></td><td style="width:250px;"><div style="width:100%;"><input type="text" class="form-control" id="remarks'+i+'" name="remarks[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="specific'+i+'" name="specific[]" ></div></td><td style="width:120px;"><div style="width:100%;"><input type="text" class="form-control" id="location'+i+'" name="location[]" ></div></td><td style="width:30pxl"><div style="width:100%;"><button type="button" name="remove" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');

 			$('.dynamic').each(function(idx, elem){
	            $(elem).val(idx+1);
	        });
 	});

 	$(document).on('click','.btn_remove',function(){
 		var row = $(this).closest('tr');
        var dynamicValue = $(row).find('.dynamic').val();
        dynamicValue = parseInt(dynamicValue);
        row.remove();

        $('.dynamic').each(function(idx, elem){
	            $(elem).val(idx+1);    
	    });
 	});



 	/*======================================
 	=            edit by Yousaf            =
 	======================================*/
 	
 		function textCounter(field,cnt, maxlimit) {         
		  var cntfield = document.getElementById(cnt) 
		     if (field.value.length > maxlimit) // if too long...trim it!
		    field.value = field.value.substring(0, maxlimit);
		    // otherwise, update 'characters left' counter
		    else
		    cntfield.value = maxlimit - field.value.length;
		}
 	
 	   
/*$("#add_component").click(function(){

   var cat_id = $('#category_id').val();

   var catalog_id = $('#catalog_id').val();
   // alert(catalog_id);
   // return false;
   var lz_bd_cata_id = $('#lz_bd_cata_id').val();
   // alert(lz_bd_cata_id);
   // return false;
    // var struc_id = $('#struc_id').val();
    // var segment_no = $('#segment_no').val();
    // var dependent_on = $('#dependent_on').val();
    // var qualifier_id = $('#qualifier_id').val();
    // dependend key value when select tree from lov 
    var dependent_key = $('#dependent_key').val();
     //alert(dependent_key); return false;
///'+cat_id+'/'+catalog_id+'/'+lz_bd_cata_id
    window.open('http://192.168.0.78:8081/laptopzone/catalogueToCash/c_add_comp/kitComponents/'+cat_id+'/'+catalog_id+'/'+lz_bd_cata_id);
  });*/
  /*=====  End of edit by Yousaf  ======*/
    
  
</script>

<script>
$(document).ready(function()
  {
    //////////////////////////////
    setTimeout(function() {
          $('#success_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    setTimeout(function() {
          $('#error_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    setTimeout(function() {
          $('#warning_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    setTimeout(function() {
          $('#compo_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    var table = $('#kit-components-table').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });

    /*$('.myInput').on( 'click', function () {
        table.search( this.value ).draw();
    } );
    $('#showAll').on( 'click', function () {
        table.search( this.value ).draw();
    } ); */   
    
  // $('#kit-components-table tr').each(function(){
  //   $(this).closest('tr').find('input.component_qty, input.cata_avg_price,input.cata_est_price,input.cata_ebay_fee,input.cata_paypal_fee,input.cata_ship_fee,.totalRow').prop('disabled', true);
  // });
// function disableRow(){
//   $(this).closest('tr').find('input.component_qty, input.cata_avg_price,input.cata_est_price,input.cata_ebay_fee,input.cata_paypal_fee,input.cata_ship_fee,.totalRow').prop('disabled', true);
// }
  /*==================================================
  =            FOR SHOWING CATALOGUE DETAIL          =
  ===================================================*/
/*  $("#copy_catalogues").on('click', function(event) {
    event.preventDefault();
     var dataTable = $('#catalogue-detail-table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
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
        url :"<?php //echo base_url().'catalogueToCash/c_technician/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
  });*/
 
/* $('#kit-components-table').append('<tr> <td></td> <td ></td> <td ></td><td></td><td></td><td><label>Checked: </label><p class="totalChecks"></p></td> <td> <label>Total Qty : </label> <div class="form-group"> <input type="text" name="total_component_qty" id="total_component_qty_1" class="form-control input-sm total_qty" value="0.00" style="width:80px;" readonly> </div> </td> <td><label>Total Sold Price:</label><div class="form-group"> <input type="text" name="total_sold_price" id="total_sold_price" class="form-control input-sm total_sold" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Estimate: </label><div class="form-group"> <input type="text" name="total_estimate_price" id="total_estimate_price" class="form-control input-sm total_estimate" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Amount: </label><div class="form-group"> <input type="text" name="total_amount" id="total_amount" class="form-control input-sm amounts" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Ebay Fee: </label><div class="form-group"> <input type="text" name="total_ebay_fee" id="total_ebay_fee" class="form-control input-sm total_ebay" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Paypal:</label><div class="form-group"> <input type="text" name="total_paypal_fee" id="total_paypal_fee" class="form-control input-sm total_paypal" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Shipping:</label><div class="form-group"> <input type="text" name="total_ship_fee" id="total_ship_fee" class="form-control input-sm total_shipping" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Sub Total:</label><p class="totalClass"/></p></td> </tr>');*/

  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $(document).on('click', ".save_components", function(){
    $('#showAll').click();

    var fields = $("input[type='checkbox']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one Component'); 
        return false;
      }  
      var arr=[];
      /*var cat_id= '<?php //echo $this->uri->segment(4); ?>';
      var mpn_id= '<?php //echo $this->uri->segment(5); ?>';
      var dynamic_cata_id= '<?php //echo $this->uri->segment(6); ?>';*/

  		var cat_id 				= $("#category_id").val();
		var mpn_id 				= $("#catalog_id").val();
		var dynamic_cata_id 	= $("#lz_bar_code").val();

      var red_flag= '<?php echo $this->uri->segment(7); ?>';
      var url='<?php echo base_url() ?>catalogueToCash/c_technician/savekitComponents';
      var partsCatalgid = [];
      var compName=[];
      var compQty=[];
      var compAvgPrice=[];
      var compAmount=[];
      var ebayFee=[];
      var payPalFee=[];
      var shipFee=[];
      var tech_condition=[];


      var tableId="kit-components-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[type='checkbox']:checked"), function()
      {            
        arr.push($(this).val());
      });
    //alert(arr);
    console.log(arr); 
    //category_id.push($(tdbk.rows[1].cells[2]).text());
       for (var i = 0; i < arr.length; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[arr[i]]).find(".part_catlg_mt_id").each(function() {
              partsCatalgid.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".estimate_condition").each(function() {
              tech_condition.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".kit_componets").each(function() {
                    compName.push($(this).val());
                  }); 

             $(tdbk.rows[arr[i]]).find(".component_qty").each(function() {
                    compQty.push($(this).val());
                  }); 

              $(tdbk.rows[arr[i]]).find('.cata_avg_price').each(function() {
                compAvgPrice.push($(this).val());
              }); 

              $(tdbk.rows[arr[i]]).find('.cata_est_price').each(function(){
               // console.log($(this).val()); return false;
                if ($(this).val() == 0 || $(this).val() == 00 || $(this).val() == 0. || $(this).val() == 0.0 || $(this).val() == 0.00 || $(this).val() == 0.000) {
                  
                }else {
                 compAmount.push($(this).val()); 
                }
                
              });

              $(tdbk.rows[arr[i]]).find('.cata_ebay_fee').each(function(){
                ebayFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_paypal_fee').each(function(){
                payPalFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_ship_fee').each(function(){
                shipFee.push($(this).val());
              });           
          }

          tech_condition = tech_condition.filter(v=>v!='');
      	  //console.log(partsCatalgid);
          //console.log(partsCatalgid); 
       if (compAmount.length < shipFee.length) {
            alert("Warning: Please Insert Estimate Price of Selected Components");
            return false;
          }else {
              $(".loader").show();
                $.ajax({
                  type: 'POST',
                  url:url,
                  data: {
                    'cat_id': cat_id,
                    'dynamic_cata_id': dynamic_cata_id,
                    'mpn_id': mpn_id,
                    'compName': compName,
                    'compQty': compQty,
                    'compAvgPrice': compAvgPrice,
                    'compAmount': compAmount,
                    'ebayFee': ebayFee,
                    'payPalFee': payPalFee,
                    'shipFee': shipFee,
                    'partsCatalgid':partsCatalgid,
                    'tech_condition':tech_condition
                  },
                  dataType: 'json',
                  success: function (data){
                       if(data == 0){
                        
                          alert('Warning: Data is already inserted against this lot!');
                          $("#item_components").hide();
                          //window.location.href = '<?php //echo base_url(); ?>catalogueToCash/c_technician/searchPurchaseDetail';

                       }else if(data == 1){
                        if(red_flag == 1111){
                          alert("Success: Estimate is created!"); 
                          //window.location.href = '<?php //echo base_url(); ?>biddingItems/c_biddingItems/purchasing_detail';

                        }else{
                          alert("Success: Estimate is created!");
                          $("#item_components").hide(); 
                          //window.location.href = '<?php //echo base_url(); ?>catalogueToCash/c_technician/searchPurchaseDetail';
                          }  
                       }else if(data == 2){
                         alert('Error: Fail to create estimate!');
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
          }
  });
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('change','.checkboxes', function(){
  //var id = this.id.match(/\d+/);
  var id = this.id;
  var checkbox = $(this).prop('checked');
  var componenet_name =  $(this).attr("ckbx_name");
  //console.log(id, checkbox, componenet_name); 

  if(checkbox == true){
    $('.validValue').each(function(){   //.prop('disabled',false);
      //console.log('jjj');
       var id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");
       //console.log(id2, componenet_name2);
      if(componenet_name2 == componenet_name && id == id2){
        $('#'+id).prop('disabled',false);
        $('#'+componenet_name2).addClass('btn-success').removeClass('btn-primary');  

      }else if(componenet_name2 == componenet_name && id != id2){
        $('#'+id2).prop('disabled',true);
        $('#'+id2).prop('checked',false);
        $('#'+id2).closest('tr').removeClass('row-color');

      }
      
    });
    }else{
    $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");

      if(componenet_name2 == componenet_name){
        //console.log("hello");
        $('#'+id2).prop('disabled',false);    
      }
      
    });
   }
});
   /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('click','.countings', function(){
    var bg_class            = this.id; 
    var est_id              = $(this).val();
    var total_check         = $(".totalChecks").val();
    var total_qty           = $(".total_qty").val();
    var total_solds         = $(".total_sold").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_estimates     = $(".total_estimate").val().replace(/\$/g, '').replace(/\ /g, '');
    var amounts             = $(".amounts").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_ebay          = $(".total_ebay").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_paypal        = $(".total_paypal").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_shipping      = $(".total_shipping").val().replace(/\$/g, '').replace(/\ /g, '');
    var sub_total           = $(".totalClass").val().replace(/\$/g, '').replace(/\ /g, '');

    var qty                 = $("#cata_component_qty_"+est_id).val();
    var est_price           = $("#cata_est_price_"+est_id).val();
    var sold_price          = $("#cata_avg_price_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var cata_amount         = $("#cata_amount_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var ebay_fee            = $("#cata_ebay_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var paypal_fee          = $("#cata_paypal_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var ship_fee            = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var rowtotal            = $("#cata_total_"+est_id).text();

    var current_check       = $(this).prop("checked");
    var componenet_name     =  $(this).attr("ckbx_name").replace(/\//g, 'ZZZ').replace(/\&/g, 'AAA');
    
    //console.log(total_check, total_qty, total_solds, qty, sold_price); //return false;
    if (current_check) {
      $('body .validValue').each(function(){   //.prop('disabled',false);
       var id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name").replace(/\//g, 'ZZZ').replace(/\&/g, 'AAA');
       var each_check       = $(this).prop("checked");
       if(each_check == true && componenet_name2 == componenet_name  && bg_class == id2){
        $("#"+bg_class).closest('tr').addClass('row-color');
        $("#cata_component_qty_"+est_id).prop('readonly', true);
        $("#cata_est_price_"+est_id).prop('readonly', true);
        $("#estimate_condition_"+est_id).attr("disabled", true); 
        total_check           = parseFloat(total_check) + 1;
        total_qty             = parseFloat(parseFloat(total_qty) + parseFloat(qty));
        solds                 = parseFloat(parseFloat(total_solds) + parseFloat(sold_price)).toFixed(2);
        estimates             = parseFloat(parseFloat(total_estimates) + parseFloat(est_price)).toFixed(2);
        amounts               = parseFloat(parseFloat(amounts) + parseFloat(cata_amount)).toFixed(2);
        total_ebays           = parseFloat(parseFloat(total_ebay) + parseFloat(ebay_fee)).toFixed(2);
        paypal_fee            = parseFloat(parseFloat(total_paypal) + parseFloat(paypal_fee)).toFixed(2);
        total_shipping        = parseFloat(parseFloat(total_shipping) + parseFloat(ship_fee)).toFixed(2);
        sub_total             = parseFloat(parseFloat(sub_total) + parseFloat(rowtotal)).toFixed(2); 
    }else if(each_check == true && componenet_name2 == componenet_name && bg_class != id2){
      $(this).prop("checked", false);
          $("#"+bg_class).closest('tr').removeClass('row-color');

          $("#cata_component_qty_"+est_id).prop('readonly', false);
          $("#cata_est_price_"+est_id).prop('readonly', false);
          $("#estimate_condition_"+est_id).attr("disabled", false);
      total_check           = parseFloat(total_check) - 1;
      total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
      sub_total             = parseFloat(parseFloat(sub_total) - parseFloat(rowtotal)).toFixed(2);

    }

      
       });
    }else{
      $("#"+bg_class).closest('tr').removeClass('row-color');
      $("#cata_component_qty_"+est_id).prop('readonly', false);
      $("#cata_est_price_"+est_id).prop('readonly', false);
      $("#estimate_condition_"+est_id).attr("disabled", false); 
      total_check           = parseFloat(total_check) - 1;
      total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
      sub_total             = parseFloat(parseFloat(sub_total) - parseFloat(rowtotal)).toFixed(2);
    }

     $(".totalChecks").val(total_check);
     $(".total_qty").val(total_qty);
     $(".total_sold").val('$'+solds);
     $(".total_estimate").val('$'+estimates);
     $(".amounts").val('$'+amounts);
     $(".total_ebay").val('$'+total_ebays);
     $(".total_paypal").val('$'+paypal_fee);
     $(".total_shipping").val('$'+total_shipping);
     $(".totalClass").val('$'+sub_total);
  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(".cata_est_price").on('blur', function(){
    var est_id = this.id.match(/\d+/);
      /////////////////////////////////////////////////////////////////

    //var est_comp_check = $("#component_check_"+est_id).attr( "checked", true );
    var est_price = $(this).val().replace(/\$/g, '').replace(/\ /g, '');
    var qty = $("#cata_component_qty_"+est_id).val();
    var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);
   
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
     //console.log(est_price, qty, ebay_price, paypal_price, ship_fee); return false;
    $("#cata_amount_"+est_id).val('$ '+amount);
    //console.log(ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+est_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+est_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+est_id).html('$ '+total);

  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
    $(".component_qty").on('blur', function(){
    var qty_id = $(this).attr("rowid");
    //var est_comp_check = $("#component_check_"+qty_id).attr( "checked", true );
    var qty = $("#cata_component_qty_"+qty_id).val();
    var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var amount = (est_price * qty).toFixed(2); 
    //console.log(qty, est_price, amount); return false;
    //alert(est_price); return false;
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    $("#cata_amount_"+qty_id).val('$ '+amount);
    //console.log(qty, est_price, ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+qty_id).html('$ '+total);
    /////////////////////////////////////
  });
/*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_technician/get_brands',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id},
    success:function(data){
      var brands = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        brands.push('<option value="'+data[i].SPECIFIC_VALUE+'">'+data[i].SPECIFIC_VALUE+'</option>')
      }
      $('#brands').html("");
      $('#brands').append('<label>Brands:</label><select name="bd_brands" id="bd_brands" class="form-control bd_brands" data-live-search="true" required>'+brands.join("")+'</select>');
      $('.brands').selectpicker();
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
});

    /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '.bd_brands', function(){

  var brand_name = $(this).val();
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_technician/get_mpns',
    type:'post',
    dataType:'json',
    data:{'brand_name':brand_name},
    success:function(data){
      var mpns = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>')
      }
      $('#bdMPN').html("");
      $('#bdMPN').append('<label>Component MPN:</label><select name="bd_mpn" id="bd_mpn" class="form-control bdMPNS" data-live-search="true" required>'+mpns.join("")+'</select>');
      $('.bdMPNS').selectpicker();
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
});
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
/*--- Onchange Mpn get its Objects start---*/
$("#bd_mpn" ).change(function(){
  var bd_mpn = $("#bd_mpn").val();
  $(".loader").show();
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
    success: function (data) {
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);
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
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue                        =
  ================================================================*/
$("#save_mpn_kit").on('click', function(){

    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/addKitComponent';
    // var bd_alt_object = $("#bd_alt_object").val();
    var ct_category_id              = $("#ct_category_id").val();
    var catalogue_mpn_id            = $("#ct_catlogue_mt_id").val();
    var ct_cata_id                  = $("#ct_cata_id").val();

    var bd_mpn                      = $("#bd_mpn").val();
    var kit_qty                     = $("#kit_qty").val();

    //console.log(catalogue_mpn_id, bd_mpn, kit_qty, ct_category_id); return false;
    // alert(bd_mpn);return false;
    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'catalogue_mpn_id': catalogue_mpn_id,
      'bd_mpn': bd_mpn,
      'kit_qty' : kit_qty
    },
    dataType: 'json',
    success: function (data){
      if(data == 1){
        alert("Success: Component is created!");
        window.location.reload();
      }else{
        alert("Error: Fail to create component! Try Again");
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
});
/*==============================================================
  =               FOR GOING CATALOGUE PAGE                           =
  ================================================================*/

/*$(document).on('change','.checkboxes',function(){
  
  
   var checker = 0;
   checker = $('input.checkboxes:checked').length;
   $(".totalChecks").val(checker);

   var sum = 0;
      $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum += +$(this).val();
          }
          
      });
      $(".total_qty").val(sum);
      ///////////////////////////////////
      var total_amounts = 0;
      $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
            total_amounts += +yourAmount;
          }      
      });

      $(".amounts").val('$'+total_amounts.toFixed(2));
      ////////////////////////////////////

      var sum_sold = 0;
      $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_sold += +yourString;
          }
          
      });
      $(".total_sold").val('$'+sum_sold.toFixed(2));

      ///////////////////////////////////
        var sum_est = 0;
      $("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            your_est = $(this).val().replace ( /[^\d.]/g, '' );
            sum_est += +your_est;
          }      
      });

      $(".total_estimate").val('$'+sum_est.toFixed(2));
      /////////////////////////////////////

      var sum_ebay = 0;
      $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ebay += +yourString;
          }
          
      });
      $(".total_ebay").val('$'+sum_ebay.toFixed(2));

      var sum_paypal = 0;
      $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_paypal += +yourString;
          }
          
      });
      $(".total_paypal").val('$'+sum_paypal.toFixed(2));


      var sum_ship = 0;
      $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ship += +yourString;
          }
          
      });
      $(".total_shipping").val('$'+sum_ship.toFixed(2));

      var sum_row = 0;
      $('.totalRow').each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
          }
            // Or this.innerHTML, this.innerText
      });
      $(".totalClass").val('$'+sum_row.toFixed(2));

});*/
// $('.checkboxes').on('click',function(){
   
// });

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#add_kit_component").click(function(){
  $("#component-toggle").toggle();
});

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#createAutoKit").click(function(){
    var ct_catlogue_mt_id = $("#catalog_id").val();
    //var ct_catlogue_mt_id = 105252;
    var kitmpnauto = $("#lz_mpn").val();
    //var kitmpnauto = 'M4700-I7';
    if (ct_catlogue_mt_id =='' || kitmpnauto == '') {
    	alert("PMN is required"); 
    	return false;
    }else {
    	$("#item_components").show();
    	var url='<?php echo base_url() ?>catalogueToCash/c_technician/createAutoKit';
	    $(".loader").show();
	    $.ajax({
	    url:url,
	    type: 'POST',
	    data: {'kitmpnauto': kitmpnauto, 'ct_catlogue_mt_id': ct_catlogue_mt_id},
	    dataType: 'json',
	    success: function (data){
	    	
	      if(data == 1){
	        alert("Success: Kit Created successfully.");
	        window.location.reload();
	      }else if(data == 0){
	        alert("Error: Kit not created.");
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
    }
       
    //alert(mpn);return false;
  });


});

/*==============================================================
=                ON CHANGE ESTIMATE CONDITION                  =
================================================================*/
  $('body').on('change', '.estimate_condition', function(){
    var est_id               = $(this).attr("id");
    var condition_id         = $(this).val();
    var qty_id               = $(this).attr("rd");
    var kitmpn_id            = $(this).attr("ctmt_id");
  //alert(qty_id); return false;
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_technician/get_cond_base_price',
    type:'post',
    dataType:'json',
    data:{'condition_id':condition_id, 'kitmpn_id':kitmpn_id},
    success:function(data){
       $(".loader").hide();
      if(data.length == 1){
        $("#cata_avg_price_"+ qty_id).val('$'+parseFloat(data[0].AVG_PRICE).toFixed(2));
        $("#cata_est_price_"+ qty_id).val(parseFloat(data[0].AVG_PRICE).toFixed(2));
        ///////////////////////////////////
        var qty = $("#cata_component_qty_"+qty_id).val();
        var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        var amount = (est_price * qty).toFixed(2); 
        //console.log(qty, est_price, amount); return false;
        //alert(est_price); return false;
        var ebay_price = (amount * (8 / 100)).toFixed(2); 
        var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
        var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        $("#cata_amount_"+qty_id).val('$ '+amount);
        //console.log(qty, est_price, ebay_price, paypal_price); return false;
        $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
        $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
        var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
        $("#cata_total_"+qty_id).html('$ '+total);
        /////////////////////////////////////      
            }else if(data.length == 0){
              $("#cata_avg_price_"+ qty_id).val('$0.00');
              $("#cata_est_price_"+ qty_id).val('0.00');
              ///////////////////////////////////
              $("#cata_amount_"+qty_id).val('$0.00');
              //console.log(qty, est_price, ebay_price, paypal_price); return false;
              $("#cata_ebay_fee_"+qty_id).val('$0.00');
              $("#cata_paypal_fee_"+qty_id).val('$0.00');
              $("#cata_total_"+qty_id).html('$0.00');
              /////////////////////////////////////
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
});

/*==============================================================
  =                ON CHANGE ESTIMATE CONDITION               =
================================================================*/
/*==============================================
=            search components call            =
==============================================*/
 var dataTable = '';
  $("#search_component").on('click',function(){
    var input_text = $("#input_text").val();
    var data_source = $("input[name='data_source']:checked").attr('id');
    var data_status = $("input[name='data_status']:checked").attr('id');

    if(input_text == ''){
        alert('Warning! Keyword is Required.');
        $("#input_text").focus();
        return false;
    }
    //console.log(data_source,data_status);return false;
   
if(dataTable !=''){
      dataTable.destroy();
    }
  dataTable = $('#search_component_table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "iDisplayLength": 500,
      "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
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
      "ajax":{
        data:{'input_text':input_text,'data_source':data_source,'data_status':data_status},
        url :"<?php echo base_url() ?>catalogueToCash/c_technician/search_component", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
      "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ],
	      error: function(jqXHR, textStatus, errorThrown){
	         $(".loader").hide();
	        if (jqXHR.status){
	          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
	        }
	    }

  });

  });
/*=====  End of search components call  ======*/
/*==================================
=            add to kit            =
==================================*/
$("body").on('click','.addtokit', function(){
//$('.addtokit').on('click',function(){
   var cat_id 				= $("#category_id").val();
   var mpn_id 				= $("#catalog_id").val();
   var cata_id 				= $("#lz_bar_code").val();

  var partCatalogueId = this.id;
  var index           = $(this).attr("name");   
  var avg_price       = $(this).attr("avg");
  //console.log(index, avg_price);
  var objectName      = $('#object_name_'+index).val();
  var catalogueId     = $('#catalog_id').val();
  //var catalogueId     = 105252;
  var objectInput     = $('#object_name').val();
  var inputText       = $('#search_component_table tr').eq(index).find('td').eq(4).find('input').val();
  var component_mpn   = $('#search_component_table tr').eq(index).find('td').eq(4).text();
  var mpnDesc         = $('#search_component_table tr').eq(index).find('td').eq(3).find('input').val();
  var ddObjectId      = $('#search_component_table tr').eq(index).find('td').eq(1).find('select').val();
  // var ddObjectName = $('#search_component_table tr').eq(index).find('td').eq(1).find('select').text();
  var categoryId      = $('#search_component_table tr').eq(index).find('td').eq(2).text();

  if(inputText == '' && objectName == ''){
    alert('Warning! MPN is Required.');
            $('#search_component_table tr').eq(index).find('td').eq(4).find('input').focus();
            return false;
  }
  if(objectName == ''){ //verfied data object
    if(ddObjectId == '' || ddObjectId == 0){ // unverfied data object dropdown
      if(objectInput == ''){ // unverfied data object input
        alert('Warning! Object Name is Required.');
              $("#object_name").focus();
              return false;
      }
    }
  }
 // console.log(partCatalogueId, catalogueId, objectName, objectInput, categoryId, component_mpn); return false;


  //console.log(ddObjectName);return false;
  $(".loader").show();
  $.ajax({

        data:{'partCatalogueId':partCatalogueId,
              'catalogueId':catalogueId,
              'objectName':objectName,
              'objectInput':objectInput,
              'mpnDesc':mpnDesc,
              'categoryId':categoryId,
              'component_mpn':component_mpn,
              'ddObjectId':ddObjectId,
              'inputText':inputText},
        url :"<?php echo base_url() ?>catalogueToCash/c_technician/addtokit", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          ///console.log(data); return false;
          $(".loader").hide();
          if(data.flag == 1){
            alert('Success! Component addded to kit');
            if (data.result.length > 0 ) {
             		var row_id         = data.totals;
            		//var row_id         = parseFloat(parseFloat(data.totals) + parseFloat(1));
                    var quantity       = data.result[0].QTY;
                     var alertMsg = "return confirm('Are you sure to delete?');";
                      var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_technician/cp_delete_component/'+cat_id+'/'+mpn_id+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID;

                      //console.log(data); return false;
                       var mpns = [];
                         // alert(data.length);return false;
                        for(var i = 0;i<data.conditions.length; i++){
                          if (data.result[0].CONDITION_ID == data.conditions[i].ID){
                                          var selected = "selected";
                                        }else {
                                            var selected = "";
                                        }

                          mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
                        }
                        if(quantity == '' || quantity == null) {var qty = 1 }else{ var qty = data.result[0].QTY;  }
                        if(avg_price == '' || avg_price == null) { var est_price = parseFloat(1.00).toFixed(2) }else{ var est_price = avg_price;  }

                        var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);

                        if(amount == '' || amount == null) {var row_amount = parseFloat(0.00).toFixed(2)}else{ var row_amount = amount;  }
                        //////////////////////////////

                        var ebay_price = (row_amount * (8 / 100)).toFixed(2); 
                        if(ebay_price == '' || ebay_price == null) {var row_ebay_price = parseFloat(0.00).toFixed(2) }else{ var row_ebay_price = parseFloat(ebay_price).toFixed(2);  }
                        var paypal_price = parseFloat((parseFloat(row_amount)  * (2.5 / 100))).toFixed(2);
                       
                        var total = parseFloat(parseFloat(row_amount) + parseFloat(row_ebay_price) + parseFloat(paypal_price) + parseFloat(3.25)).toFixed(2);
                  
                        var est_price_name = 'cata_est_price_'+row_id;
                        var table = $('#kit-components-table').DataTable();
                        table.row.add( $('<tr> <td><a title="Delete Component" href="" onclick="'+alertMsg+'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> </td> <td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td>'+data.result[0].MPN_DESCRIPTION+'</td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].PART_CATLG_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+qty+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$'+est_price+'" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+row_amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+row_ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+total+'</p></td></tr>') ).draw();
                    }
            

          }else if (data.flag == 0){
            alert('Error! Component Not addded to kit');
          }else if(data.flag == 2){
            alert('Warning! Component Already Exist in Kit');
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
});


/*=====  End of add to kit  ======*/
/*==================================
=            fetch object            =
==================================*/
$("body").on('click','.fetchobject', function(){

  var index =  $(this).attr("name");
  var categoryId = $('#search_component_table tr').eq(index).find('td').eq(2).text();
  if(categoryId == ''){
    alert('Error! Category Id Is Required');
    return false;

  }
 // console.log(mpnDesc);return false;
 $(".loader").show();
  $.ajax({
        data:{'categoryId':categoryId},
        url :"<?php echo base_url() ?>catalogueToCash/c_technician/fetch_object", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          $(".loader").hide();
          if(data != ''){
            //alert('if');
            var ddStart = '<div><select name="kit_object" id="kit_object" class="form-control selectpicker" data-live-search="true">';
            var option = '<option value="0">--- Select ---</option>';
            for(var i = 0; i< data.length; i++){
              option +='<option value="'+data[i].OBJECT_ID+'">'+ data[i].OBJECT_NAME +'</option>';
            }
            
            var ddEnd = '</select></div>';
            $('#search_component_table tr').eq(index).find('td').eq(1).html(ddStart+option+ddEnd);
            $('.selectpicker').selectpicker();
            $('#search_component_table tr').eq(index).find('td').eq(4).html('<input type="text" class="form-control" name="input_mpn" id="input_mpn" placeholder="Enter Part MPN" style="width:126px;">');
          }else{
            $('#search_component_table tr').eq(index).find('td').eq(1).text('No data Found');
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
});

/*=====  End of fetch object  ======*/
</script>

