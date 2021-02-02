<?php $this->load->view("template/header.php"); ?>
<style>
 .alt{background-color: #DEDFDE;}
 
</style>
<form action="<?php echo base_url(); ?>pos/c_point_of_sale/posUpdate" method="post" name="posUpdate" onsubmit="setTimeout(function(){ location.reload(); }, 1000);" accept-charset="utf-8" target="_blank">
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Catalogue Edit Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Catalogue Edit Form</li>
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
	              <h3 class="box-title">Catalogue Data</h3>
	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div> 
	            </div>
	            <div class="box-body">
              		<div class="row">
                    <div class="col-sm-12" id="tableData">
                      
                    </div>
              			<div class="col-sm-12" >
                     
              				<table class="table table-bordered table-striped table-responsive table-hover" id="catalogue_data">
                        

                      </table>
              			</div>
              		</div>
              	</div>
        	</div>

        	 <div class="box" id="updateRow">
	            <div class="box-header with-border">
	              <h3 class="box-title">Update Custom Attribute &amp; Specifics</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div>
	            </div>
	            <div class="box-body" >
	            	 <?php 
                     if(!empty($data) && @$data['error_msg'] != true):?>


 
                      <div class="col-sm-12 ">

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="Catalogue Group Name">Catalogue Group Name:</label>
        
                                <select class="form-control " name="edit_catalogue_name" id="edit_catalogue_name" readonly>
                                  <!-- <option value="0">Select</option> -->
                                  <?php
                                  foreach(@$data['group_qry'] as $row):
                                    
                                     echo '<option value="'.@$row['CATALOGUE_GROUP_ID'].'">'.@$row['CATALOGUE_GROUP_VALUE'].'</option>';
                              
                                  endforeach;
                                ?>
                                </select>
                              </div>                           
                          </div>

                          <div class="col-sm-3">
                            <div class="from-group">
                              <label for="Item Specific Name">Specific Name:</label>
                            
                                <select class="form-control " name="edit_spec_name" id="edit_spec_name" readonly>
                                  <!-- <option value="">Select</option> -->
                                  <?php
                                  foreach(@$data['mt_query'] as $count):
                                    
                                     echo '<option value="'.@$count['MT_ID'].'">'.@$count['SPECIFIC_NAME'].'</option>';
                              
                                  endforeach;
                                ?>
                                </select>
                            </div>                           
                          </div>


                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="Specific Value">Specific Value:</label>
                              	   <div id="edit_specificValue">
                                
                              		</div>
                            
                              <!-- <input class='form-control' type='text' name='custom_attribute' id="custom_attribute" value='' placeholder="Enter your own" /> -->
                            </div>
                          </div>
                           <div class="col-sm-3">
                            <div class="form-group p-t-24">
                              <input type="hidden" id="cat_detail_id" name="cat_detail_id">
                              <input type="button" name="update_catalogue" id="update_catalogue" class=" btn btn-success" value="Update">
                            </div>
                          </div>
                          <?php endif;?>
	            	</div>
	            </div>
	         </div>
        	  <!-- Item Specific Start -->
            <div class="box" >
	            <div class="box-header with-border">
	              <h3 class="box-title">Add Custom Attribute &amp; Specifics</h3>

	              <div class="box-tools pull-right">
	                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
	                </button>
	              </div>

	            </div>

                <div class="box-body" >
                   <?php 
                     if(!empty($data) && @$data['error_msg'] != true):?>

                     <div class="col-sm-12 ">
                        <div class="col-sm-3">
                          <div class="form-group" id="obj_edit">
                            <label for="OBJECTS">OBJECTS : </label>
                            <!-- <select class="form-control selectpicker" name="edit_object" id="edit_object" readonly>
                              <option value="0">---</option> -->
                               <?php

                                          // foreach(@$record as $count):
                                            
                                          //    echo '<option value="'.@$count['OBJECT_ID'].'">'.@$count['OBJECT_NAME'].'</option>';
                                      
                                          // endforeach;
                                ?> 
                            <!-- </select> -->
                          </div>
                        </div >
                        <div class="col-sm-1 p-t-26">
                          <input type="button" name="update_obj" id="update_obj" value="Update Object" class="btn btn-sm btn-success "> 
                        </div>
                      </div>
 
                      <div class="col-sm-12 catlogueBlock">

                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="Catalogue Group Name">Catalogue Group Name:</label>
        
                                <select class="form-control " name="catalogue_name" id="catalogue_name">
                                  <!-- <option value="0">Select</option> -->
                                  <?php
                                  foreach(@$data['group_qry'] as $row):
                                    
                                     echo '<option value="'.@$row['CATALOGUE_GROUP_ID'].'">'.@$row['CATALOGUE_GROUP_VALUE'].'</option>';
                              
                                  endforeach;
                                ?>
                                </select>
                              </div>                           
                          </div>

                          <div class="col-sm-3">
                            <div class="from-group">
                              <label for="Item Specific Name">Specific Name:</label>
                            
                                <select class="form-control " name="spec_name" id="spec_name" >
                                  <!-- <option value="">Select</option> -->
                                  <?php
                                  foreach(@$data['mt_query'] as $count):
                                    
                                     echo '<option value="'.@$count['MT_ID'].'">'.@$count['SPECIFIC_NAME'].'</option>';
                              
                                  endforeach;
                                ?>
                                </select>
                            </div>                           
                          </div>


                          <div class="col-sm-3">
                            <div class="form-group">
                              <label for="Specific Value">Specific Value:</label>
                              <div id="specificValue">
                                
                              </div>
                            
                              <!-- <input class='form-control' type='text' name='custom_attribute' id="custom_attribute" value='' placeholder="Enter your own" /> -->
                            </div>
                          </div>



                          <div class="col-sm-3">
                            <div class="form-group p-t-24">
                              <input type="hidden" class="form-control" id="category_id" name="cat_id" value="<?php echo @$data['mt_query'][0]['EBAY_CATEGORY_ID'];  ?>">

                              
                              <input type="hidden" class="form-control" id="mpn" name="mpn" value="<?php echo @$data['catalogue_qry'][0]['MPN'];  ?>">
                              <input type="button" name="save_catalogue" id="save_catalogue" class=" btn btn-success" value="Save">
                            </div>
                          </div>

                          <?php endif;?>
                        <!-- </form> -->
                      </div>
                    </div>
                 </div>



      </div>
    </section>
  </div>
</form>

<?php $this->load->view("template/footer.php"); ?>
<script type="text/javascript">
	$(document).ready(function(){
		// alert($("#category_id").val());
			$('#updateRow').hide();
			var url = window.location.pathname;
			var $id = url.substring(url.lastIndexOf('/') + 1);
			// alert(id);
			$.ajax({
	        dataType: 'json',
	        type: 'POST',
	        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/showCatalogueDetail',
	        data: { '$id' : $id},
	        success: function(data){
            $('#tableData').html("");
            $('#tableData').append('<div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+data.catalogue_data[0].MPN+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE : '+data.catalogue_data[0].INSERT_DATE+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">OBJECT NAME :  '+data.catalogue_data[0].OBJECT_NAME+'</h4></div>');
	        	var catalogue_data = []; // to save Specific_Name and Specific_Value
		        var groupedCatalogue = [];// to add rowspan according to group value
		        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
		        
		        for(var j= 0;j<data.groupCount.length; j++){
              
                groupedCatalogue.push('<tr><td rowspan="'+data.groupCount[j].ROW_SPAN+'">'+data.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
              
              
		          
		            for (var i = 0; i < data.catalogue_data.length; i++) {
		                if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
		                  // if group_id is same then all value in same row
		                  catalogue_data.push('<td>'+data.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+data.catalogue_data[i].SPECIFIC_VALUE+'</td><td><button type="button" class="catalogues_edit_detail btn btn-sm btn-primary" id="select'+data.catalogue_data[i].DET_ID+'" title="Edit" >Edit</button> <button type="button"  class="catalogues_delete_detail btn btn-sm btn-danger" id="delete'+data.catalogue_data[i].DET_ID+'" title="Delete" >Delete</button></td></tr>'); 
		                  //This adds each thing we want to append to the array in order.
		                  if(i<data.catalogue_data.length-1){
		                    //to check if next index value is same as previous
		                    if(data.catalogue_data[i+1].CATALOGUE_GROUP_ID != data.groupCount[j].CATALOGUE_GROUP_ID){
		                      //if the next group_id is not same then the row is completed
		                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
		                      groupedCatalogue = [];

		                      catalogue_data = [];
		                    }

		                  }else{
		                    //if loop is reached to last index then their value must be same so its a complete row
		                    if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
		                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
		                      groupedCatalogue = [];

		                      catalogue_data = [];
		                    }
		                  }
		                  
		                }
		            }
		            
		        }
		        //console.log()
		        //Since we defined our variable as an array up there we join it here into a string
		         // $("#catalogue_data").html("");
		        $("#catalogue_data").append('<thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th><th>Edit Value</th> </thead><tbody>'+catalogueJoin.join("")+'</tbody>');
            
            $("#catalogue_data tr:even").css("background-color", "#D3D3D3");
            $("#catalogue_data tr:odd").css("background-color", "#8FBC8F");

            // $('#catalogue_data').css("border","2px solid #000");
            $('#catalogue_data tr:even td').filter(function() {
              return this.rowSpan > 1;
                }).css('background-color', '#778899').css('font-weight', 'bold').css('font-size','16px')
             $('#catalogue_data tr:odd td').filter(function() {
              return this.rowSpan > 1;
                }).css('background-color', '#2E8B57').css('font-weight', 'bold').css('font-size','16px')
            
            
               $.ajax({
                type:"post",
                dataType:"json",
                url: "<?php echo base_url(); ?>catalogue/c_itemCatalogue/getObjectsForEdit",
                success : function(result){
                    var object_name = [];
                    for(var i = 0; i<result.length;i++){
                      object_name.push('<option value="'+result[i].OBJECT_ID+'">'+result[i].OBJECT_NAME+'</option>');
                    }

                    $('#obj_edit').append('<select class="form-control object" data-live-search="true" name="edit_object" id="edit_object" readonly>'+object_name.join("")+'</select>');
                    $('select[id=edit_object]').val(data.catalogue_data[0].OBJECT_ID);
                     $('.object').selectpicker();
                }
              });

          	}


           
    	});

   
});



/*=====================================
=            update object            =
=====================================*/

$('#update_obj').on('click',function(){

    var obj_id = $('#edit_object').val();
      var url = window.location.pathname;
      var $id = url.substring(url.lastIndexOf('/') + 1);
      // alert(id);
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/showCatalogueDetail',
          data: { '$id' : $id},
          success: function(data){
            var mpn = data.catalogue_data[0].MPN;
            var cat_id = data.catalogue_data[0].CATEGORY_ID;
            
             $.ajax({
                type:'post',
                dataType:'json',
                url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/updateObjectEdit',
                data:{'mpn':mpn,'cat_id':cat_id,'obj_id':obj_id},
                success : function(result){
                  if(result == 1){
                    alert('updated! successfully');

                  }else{
                    alert('not updated! try again');
                  }
                  location.reload();
                }
            });
          }
      });



 
});

/*=====  End of update object  ======*/


/*=====================================================================
=            For Specific Value in Specific Value Dropdown            =
=====================================================================*/
	

$("#spec_name").change(function(){
    var spec_mt_id = $("#spec_name").val();
    var bd_category = $("#category_id").val();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/getItemSpecificsValues',
      data: { 'spec_mt_id' : spec_mt_id, 'bd_category':bd_category},
     success: function (data) {
      //console.log(data);

        var specificsValues = []; 
        for (var i = 0; i < data.length; i++) {
            specificsValues.push('<option value="'+data[i].DET_ID+'">'+data[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
        }

        //Since we defined our variable as an array up there we join it here into a string
        specificsValues.join(" ");
        $("#specificValue").html("");
        $("#specificValue").append('<select style="width:160px;" class="form-control specifics selectDropdown" data-live-search="true" name="spec_val" id="spec_val">'+specificsValues+'</select>');
        $('.selectDropdown').selectpicker();

     }
    }); 
 });

/*=====  End of For Specific Value in Specific Value Dropdown  ======*/


/*=======================================================================
=            On Click of Save button to save catalogue Entry            =
=======================================================================*/


$("#save_catalogue").click(function(){
    var mpn = $("#mpn").val();
    var catalogue_name = $("#catalogue_name").val();
    var cat_id = $("#category_id").val();
    var spec_val = $("#spec_val").val();

  if(mpn == '' || mpn == null ){
    alert('Please insert mpn.');
    $("#mpn").focus();
    return false;
  }else if(spec_val == '' || spec_val == null){
    alert('Please select a value from dorpdown list.');
    $("#spec_val").focus();
    return false;
  }

   $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/addCatalogue',
      data: { 'mpn' : mpn,'catalogue_name':catalogue_name,'cat_id':cat_id,'spec_val':spec_val},
     success: function (data) {
      console.log(data);
        if(data.check == 0){
          alert('Error! Record is not inserted.');
          return false;
        }else if(data.check == 1){
            alert('Sucess! Record is successfully inserted.');
        }else if(data.check == 2){
          alert('Warning! Record is already exist.');
        }
         $('#tableData').html("");
         $('#tableData').append('<div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+data.arr[0]+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE: '+data.arr[1][0].CAT_DATE+'</h4></div>');
        var catalogue_data = []; // to save Specific_Name and Specific_Value
        var groupedCatalogue = [];// to add rowspan according to group value
        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
        
        for(var j= 0;j<data.groupCount.length; j++){

          groupedCatalogue.push('<tr><td rowspan="'+data.groupCount[j].ROW_SPAN+'">'+data.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
            for (var i = 0; i < data.catalogue_data.length; i++) {
                if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                  // if group_id is same then all value in same row
                  catalogue_data.push('<td>'+data.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+data.catalogue_data[i].SPECIFIC_VALUE+'</td><td><button type="button"  class="catalogues_edit_detail btn btn-sm btn-primary" id="select'+data.catalogue_data[i].DET_ID+'" title="Edit" >Edit</button> <button type="button"  class="catalogues_delete_detail btn btn-sm btn-danger" id="delete'+data.catalogue_data[i].DET_ID+'" title="Edit" >Delete</button></td></tr>'); //This adds each thing we want to append to the array in order.
                  if(i<data.catalogue_data.length-1){
                    //to check if next index value is same as previous
                    if(data.catalogue_data[i+1].CATALOGUE_GROUP_ID != data.groupCount[j].CATALOGUE_GROUP_ID){
                      //if the next group_id is not same then the row is completed
                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
                      groupedCatalogue = [];

                      catalogue_data = [];
                    }

                  }else{
                    //if loop is reached to last index then their value must be same so its a complete row
                    if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
                      groupedCatalogue = [];

                      catalogue_data = [];
                    }
                  }
                  
                }
            }
            
        }
        //console.log()
        //Since we defined our variable as an array up there we join it here into a string
        
        $("#catalogue_data").html("");
        $("#catalogue_data").append('<thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th><th>Alternate Value</th> </thead><tbody>'+catalogueJoin.join("")+'</tbody>'); 
        
        // console.log($('#catalogue_data tr').length);         

        $("#catalogue_data tr:even").css("background-color", "#D3D3D3");
            $("#catalogue_data tr:odd").css("background-color", "#8FBC8F");

            // $('#catalogue_data').css("border","2px solid #000");
            $('#catalogue_data tr:even td').filter(function() {
              return this.rowSpan > 1;
                }).css('background-color', '#778899').css('font-weight', 'bold').css('font-size','16px')
             $('#catalogue_data tr:odd td').filter(function() {
              return this.rowSpan > 1;
                }).css('background-color', '#2E8B57').css('font-weight', 'bold').css('font-size','16px')
     }
      }); 
 });

/*=====  End of On Click of Save button to save catalogue Entry  ======*/

/*=============================================
=            Section comment block            =
=============================================*/



/*=====  End of Section comment block  ======*/

/*===========================================================
=            On Click of Edit button to Edit Row            =
===========================================================*/


$(document).on('click','.catalogues_edit_detail ',function(){
	// var spec_mt_id;
	$('#updateRow').show();
	var btnID = this.id.match(/\d+/);
	// alert(btnID);
	btnID = parseInt(btnID);
	var url = window.location.pathname;
	var $id = url.substring(url.lastIndexOf('/') + 1);
	$.ajax({
		dataType: 'json',
		type:"post",
		data:{'btnID':btnID,'$id':$id},
		url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/editData',
		success: function(data){
			
			$('select[id=edit_catalogue_name]').val(data[0].CATALOGUE_GROUP_ID);
			$('select[id=edit_spec_name]').val(data[0].MT_ID);
			$('#cat_detail_id').val(data[0].CATALOGUE_DET_ID);
			$('#edit_catalogue_name').attr('readonly',true);
			$('#edit_catalogue_name').attr('readonly',true);
			// spec_mt_id = $('select[id=edit_spec_name]').val(data[0].MT_ID);
			var spec_mt_id= $('#edit_spec_name').val();
		    var bd_category = $("#category_id").val();

		    $.ajax({
		      dataType: 'json',
		      type: 'POST',        
		      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/getItemSpecificsValues',
		      data: { 'spec_mt_id' : spec_mt_id, 'bd_category':bd_category},
		     success: function (result) {
		      //console.log(data);

		        var specificsValues = []; 
		        for (var i = 0; i < result.length; i++) {
		            specificsValues.push('<option value="'+result[i].DET_ID+'">'+result[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
		        }

		        //Since we defined our variable as an array up there we join it here into a string
		        specificsValues.join(" ");
		        $("#edit_specificValue").html("");
		        $("#edit_specificValue").append('<select style="width:160px;" class="form-control specifics selectDropdown" data-live-search="true" name="edit_specific_Value" id="edit_specific_Value">'+specificsValues+'</select>');
		        $('select[id=edit_specific_Value]').val(data[0].DET_ID);
		        $('.selectDropdown').selectpicker();
		        
		     }
		    });

		}

	});

});

/*=====  End of On Click of Edit button to Edit Row  ======*/


/*============================================================
=            On Click Delete Button to Delete Row            =
============================================================*/

$(document).on('click','.catalogues_delete_detail ',function(){
	var btnID = this.id.match(/\d+/);
	btnID = parseInt(btnID);
	var url = window.location.pathname;
	var $id = url.substring(url.lastIndexOf('/') + 1);
	// alert($id);
	$.ajax({
		dataType: 'json',
		type:"post",
		data:{'btnID':btnID,'$id':$id},
		url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/deleteCatalogueDetail',
		success:function(data){
			if(data == 1){
				alert("Deleted Successfully!");
			}else if(data == 0){
				alert("Record not Deleted! Try again");
			}

			// alert(id);
			$.ajax({
	        dataType: 'json',
	        type: 'POST',
	        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/showCatalogueDetail',
	        data: { '$id' : $id},
	        success: function(result){
            $('#tableData').html("");
            $('#tableData').append('<div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+result.catalogue_data[0].MPN+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE: '+result.catalogue_data[0].INSERT_DATE+'</h4></div>');
	        	var catalogue_data = []; // to save Specific_Name and Specific_Value
		        var groupedCatalogue = [];// to add rowspan according to group value
		        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
		        
		        for(var j= 0;j<result.groupCount.length; j++){

		          groupedCatalogue.push('<tr><td rowspan="'+result.groupCount[j].ROW_SPAN+'">'+result.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
		            for (var i = 0; i < result.catalogue_data.length; i++) {
		                if(result.catalogue_data[i].CATALOGUE_GROUP_ID == result.groupCount[j].CATALOGUE_GROUP_ID){
		                  // if group_id is same then all value in same row
		                  catalogue_data.push('<td>'+result.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+result.catalogue_data[i].SPECIFIC_VALUE+'</td><td><button type="button" class="catalogues_edit_detail btn btn-sm btn-primary" id="select'+result.catalogue_data[i].DET_ID+'" title="Edit" >Edit</button> <button type="button"  class="catalogues_delete_detail btn btn-sm btn-danger" id="delete'+result.catalogue_data[i].DET_ID+'" title="Delete" >Delete</button></td></tr>'); 
		                  //This adds each thing we want to append to the array in order.
		                  if(i<result.catalogue_data.length-1){
		                    //to check if next index value is same as previous
		                    if(result.catalogue_data[i+1].CATALOGUE_GROUP_ID != result.groupCount[j].CATALOGUE_GROUP_ID){
		                      //if the next group_id is not same then the row is completed
		                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
		                      groupedCatalogue = [];

		                      catalogue_data = [];
		                    }

		                  }else{
		                    //if loop is reached to last index then their value must be same so its a complete row
		                    if(result.catalogue_data[i].CATALOGUE_GROUP_ID == result.groupCount[j].CATALOGUE_GROUP_ID){
		                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
		                      groupedCatalogue = [];

		                      catalogue_data = [];
		                    }
		                  }
		                  
		                }
		            }
		            
		        }
		        //console.log()
		        //Since we defined our variable as an array up there we join it here into a string
		        $("#catalogue_data").html("");
		        $("#catalogue_data").append('<thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th><th>Edit Value</th> </thead><tbody>'+catalogueJoin.join("")+'</tbody>');
            $("#catalogue_data tr:even").css("background-color", "#D3D3D3");
            $("#catalogue_data tr:odd").css("background-color", "#8FBC8F");

            // $('#catalogue_data').css("border","2px solid #000");
            $('#catalogue_data tr:even td').filter(function() {
              return this.rowSpan > 1;
                }).css('background-color', '#778899').css('font-weight', 'bold').css('font-size','16px')
             $('#catalogue_data tr:odd td').filter(function() {
              return this.rowSpan > 1;
                }).css('background-color', '#2E8B57').css('font-weight', 'bold').css('font-size','16px')
			    }
    	});

		}
	});
});
/*=====  End of On Click Delete Button to Delete Row  ======*/



/*================================================================
=            Update catlogue by updating selected row            =
================================================================*/


$('#update_catalogue').click(function(){
	var specVal = $('#edit_specific_Value').val();
	var det_id = $('#cat_detail_id').val();

	$.ajax({
		type: 'post',
		dataType:'json',
		data:{'specVal':specVal,'det_id':det_id},
		url: '<?php echo base_url(); ?>catalogue/c_itemCatalogue/updateCatalogueDetail',
		success: function (data) {
			if(data == 1){
				alert("Updated Successfully!");
			}else if(data == 0){
				alert("Record not updated! Try again");
			}

			var url = window.location.pathname;
			var $id = url.substring(url.lastIndexOf('/') + 1);
			// alert(id);
			$.ajax({
	        dataType: 'json',
	        type: 'POST',
	        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/showCatalogueDetail',
	        data: { '$id' : $id},
	        success: function(result){
	        	var catalogue_data = []; // to save Specific_Name and Specific_Value
		        var groupedCatalogue = [];// to add rowspan according to group value
		        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
		        
		        for(var j= 0;j<result.groupCount.length; j++){

		          groupedCatalogue.push('<tr><td rowspan="'+result.groupCount[j].ROW_SPAN+'">'+result.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
		            for (var i = 0; i < result.catalogue_data.length; i++) {
		                if(result.catalogue_data[i].CATALOGUE_GROUP_ID == result.groupCount[j].CATALOGUE_GROUP_ID){
		                  // if group_id is same then all value in same row
		                  catalogue_data.push('<td>'+result.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+result.catalogue_data[i].SPECIFIC_VALUE+'</td><td><button type="button" class="catalogues_edit_detail btn btn-sm btn-primary" id="select'+result.catalogue_data[i].DET_ID+'" title="Edit" >Edit</button> <button type="button"  class="catalogues_delete_detail btn btn-sm btn-danger" id="delete'+result.catalogue_data[i].DET_ID+'" title="Delete" >Delete</button></td></tr>'); 
		                  //This adds each thing we want to append to the array in order.
		                  if(i<result.catalogue_data.length-1){
		                    //to check if next index value is same as previous
		                    if(result.catalogue_data[i+1].CATALOGUE_GROUP_ID != result.groupCount[j].CATALOGUE_GROUP_ID){
		                      //if the next group_id is not same then the row is completed
		                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
		                      groupedCatalogue = [];

		                      catalogue_data = [];
		                    }

		                  }else{
		                    //if loop is reached to last index then their value must be same so its a complete row
		                    if(result.catalogue_data[i].CATALOGUE_GROUP_ID == result.groupCount[j].CATALOGUE_GROUP_ID){
		                      catalogueJoin.push(groupedCatalogue.join("")+catalogue_data.join(""));
		                      groupedCatalogue = [];

		                      catalogue_data = [];
		                    }
		                  }
		                  
		                }
		            }
		            
		        }
		        //console.log()
		        //Since we defined our variable as an array up there we join it here into a string
		         $("#catalogue_data").html("");
		        $("#catalogue_data").append('<thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th><th>Edit Value</th> </thead><tbody>'+catalogueJoin.join("")+'</tbody>');
			        }
    	});
		}
	});
	// alert(specVal);
	$('#updateRow').hide();
		
});

/*=====  End of Update catlogue by updating selected row  ======*/

/*=============================================
=           Select specific value          =
=============================================*/

$("#edit_spec_name").change(function(){
    var spec_mt_id = $("#edit_spec_name").val();
    var bd_category = $("#category_id").val();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/getItemSpecificsValues',
      data: { 'spec_mt_id' : spec_mt_id, 'bd_category':bd_category},
     success: function (data) {
      //console.log(data);

        var specificsValues = []; 
        for (var i = 0; i < data.length; i++) {
            specificsValues.push('<option value="'+data[i].DET_ID+'">'+data[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
        }

        //Since we defined our variable as an array up there we join it here into a string
        specificsValues.join(" ");
        $("#edit_specificValue").html("");
        $("#edit_specificValue").append('<select style="width:160px;" class="form-control specifics selectDropdown" data-live-search="true" name="edit_specific_Value" id="edit_specific_Value">'+specificsValues+'</select>');
        $('.selectDropdown').selectpicker();

     }
    }); 
 });
/*=====  End of Select specific value ======*/


</script>