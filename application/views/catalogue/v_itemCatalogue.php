<?php $this->load->view('template/header'); ?>

<style>
  #specific_fields{display:none;}
  .specific_attribute{display: none;}
  #CatalogueGroup{display: none;}
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Catalogue
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Catalogue</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-sm-12">                 

        <!-- Item Specific Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <div class="box-body">

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
            <!-- </div> --> 

            <div class="col-sm-12">
              <form action="<?php echo base_url(); ?>catalogue/c_itemCatalogue/getCategorySpecifics" method="post" accept-charset="utf-8">

                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" id="bd_category" class="form-control selectpicker" data-live-search="true" required>
                      <option value="0">---</option>
                      <?php                                
                         if(!empty($getCategories)){
                          

                          foreach ($getCategories as $cat){ 
                            if($this->session->userdata('bd_category') == $cat['CATEGORY_ID'] || @$catId == $cat['CATEGORY_ID']){
                              $selected = "selected";
                          }else {
                                $selected = "";
                              }

                            ?>

                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php echo $selected; ?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                          $this->session->unset_userdata('bd_category');
                          
                      ?>  
                                          
                    </select>  
                  </div>
                </div>
               

                <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="bd_submit" id="bd_submit" value="Search">
                  </div>
                </div>
                 <div class="col-sm-5">
                  <div class="form-group">
                    <label for="Mpn" class="control-label">Master Mpn:</label>
                    <select name="master_mpn" id="master_mpn" class="selectpicker form-control" multiple data-live-search="true" >
                      <option value="">---</option>
                      <?php                                
                         if(!empty(@$master_mpn)){

                          foreach (@$master_mpn as $mp){
                             if(@$this->session->userdata('master_mpn') == $mp['CATALOGUE_MT_ID'] || @$bd_mpn_id == $mp['CATALOGUE_MT_ID']){
                              $selected = "selected";
                              }else {
                                $selected = "";
                              }

                              ?>
                              <option value="<?php echo $mp['CATALOGUE_MT_ID']; ?>" <?php echo $selected; ?>> <?php echo $mp['MPN']; ?> </option>
                              <?php
                              } 
                          }
                        //  $this->session->unset_userdata('bd_category');
                          
                      ?>  
                                          
                    </select>  
                  </div>
                 </div>

                  <div class="col-sm-1 ">
                      <div class="form-group p-t-26 pull-right">
                        <a href="<?php echo base_url();?>catalogue/c_itemCatalogue/catalogueListView" class="btn btn-primary btn-sm" target="_blank">Catalogue List</a>
                      </div>
                  </div>                 

              </form>

                <?php if(!empty($data) && @$data['error_msg'] != true):?>


                <div class="col-sm-12" style="margin-top: 15px;">

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="MPN">MPN:</label>
                      <input class="form-control" type="text" name="mpn" id="mpn" value="" required>
                    </div>
                  </div> 

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="MPN">MPN DESCRIPTION :</label>
                      <input class="form-control" type="text" name="mpn_desc" id="mpn_desc" value="" required>
                    </div>
                  </div> 

                  <div class="col-sm-3">
                     <div class="form-group" id="cataObject">
                        <label for="Conditions" class="control-label">OBJECT:</label>
                        <select name="catalogue_object" id="catalogue_object" class="form-control selectpicker" data-live-search="true" required>
                          <option value="0">---</option>
                           <?php

                                      foreach(@$record as $count):
                                        
                                         echo '<option value="'.@$count['OBJECT_ID'].'">'.@$count['OBJECT_NAME'].'</option>';
                                  
                                      endforeach;
                            ?>  
                                              
                        </select>  
                      </div>
                  </div>
                  <div class="col-sm-1">
                    <div class="form-group p-t-26">
                      <input type="button" id="add_object" name="add_object" value="New Object" class="btn btn-sm btn-success">
                    </div>
                  </div>
          
                </div>

                <div class="col-sm-12" id="objectDiv">

                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="NEW OBJECT">NEW OBJECT NAME :</label>
                      <input class="form-control" type="text" name="new_object" id="new_object" value="" required>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <label for="Cat Groups">Cat Groups :</label>
                    <div class="form-group">
                      <select class="form-control cats_group" data-live-search="true" name="cats_group" id="group_names"></select>
                    </div>
                  </div> 
                  <div class="col-sm-1 p-t-26">
                    <div class="form-group">
                      <input type="button" id="create_object" name="create_object" value="Create Object" class="btn btn-sm btn-success">
                    </div>
                  </div>
                  
                </div>
                  
            <?php endif;?>

                    <!-- </form> -->
                </div>
            </div>
          </div>
        <!-- Item Specific end --> 


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
                  <div class="col-sm-12">
                  <?php 
                    if(!empty($data) && @$data['error_msg'] != true):?>

                      <div class="col-sm-12 catlogueBlock">

                          <div class="col-sm-3">
                            <div class="form-group" id="catalogueDrop">
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

                          <div class="col-sm-3" id="spex_names">
                            <div class="from-group" id="spex_names">
                              <label for="Item Specific Name">Specific Name:</label>
                            
                                <select class="form-control selectpicker" data-live-search="true" name="spec_name" id="spec_name">
                                  <!-- <option value="">Select</option> -->
                                  <option value = "0">---</option>
                                  <!-- <option value="object">Object</option> -->
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
                              <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_query'][0]['EBAY_CATEGORY_ID'];  ?>">
                              
                              <input type="button" name="save_catalogue" id="save_catalogue" class=" btn btn-success" value="Save">
                            </div>
                          </div>
                        <!-- </form> -->
                      </div>
                

                      <div class="col-sm-12 catlogueBlock" style="margin-top: 15px;">

                        <div class="col-sm-3">
                          <button type="button" id="add_specific" class="btn btn-primary btn-block" >Add your own item specific</button><br>
                          
                        </div>
                     
                        <div id="specific_fields">
                        <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/update_cat_id'); ?>" method="post"> -->
                          <div class='col-sm-2'>
                            <div class='form-group'>
                              <label for="Specific Name">Specific Name</label>
                              <input class='form-control' type='text' name='custom_name' id="custom_name" value='' placeholder='Enter item specific name'/>
                              <span>For example, Brand, Material, or Year</span>
                            </div>
                          </div>
                          <div class='col-sm-2'>
                            <div class='form-group'>
                              <label for="Specific Value">Specific Value</label>
                              <input class='form-control' type='text' name='custom_value' id="custom_value" value='' placeholder='Enter item specific value'/>
                              <span>For example, Ty, plastic, or 2007</span>
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="form-group">
                              <label for="Selection Mode">Selection Mode</label>
                              <select class="form-control" name="selectionMode" id="selectionMode">
                                <option value="FreeText">FreeText</option>
                                <option value="SelectionOnly">SelectionOnly</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm-1">
                            <div class="form-group">
                              <label for="Max Value">Max Value</label>
                              <input type="number" class="form-control" name="maxValue" id="maxValue" value="1" placeholder="Max Value" required>
                            </div>
                          </div>                                                
                          <div class="col-sm-2">
                            <div class="form-group">
                              
                              <label for="catalogue Only">Catalogue Only&nbsp;&nbsp;</label>
                              <input type="checkbox" name="catalogue_only" id="catalogue_only" value="1" checked disabled>
                              <input type="hidden" name="catalogue_only" id="catalogue_only" value="1">
                            </div>
                          </div>

                          <div class="col-sm-12">
                            <div class="form-group">
                              <input type="button" class="btn btn-success btn-small" name="cat_cust_specs" id="cat_cust_specs" value="Save">
                            </div>
                          </div>

                        </div>                        
                      </div>

                      <div class="col-sm-12 catlogueBlock">

                        <div class="col-sm-3">
                          <button type="button" id="add_attribute" class="btn btn-default btn-block">Enter your own attribute</button><br>
                        </div>
                        <div class="specific_attribute">
                          <!-- <form action="<?php //echo base_url('specifics/c_item_specifics/attribute_value'); ?>" method="post"> -->
                          <div class="col-sm-3">
                            <select class="form-control " name="new_spec_name" id="new_spec_name">
                              <!-- <option value="">Select</option> -->
                              <?php
                              foreach(@$spec_name['mt_query'] as $count):
                                
                                 echo '<option value="'.@$count['MT_ID'].'">'.@$count['SPECIFIC_NAME'].'</option>';
                          
                              endforeach;
                            ?>
                            </select>                           
                          </div>
                          <div class="col-sm-3">
                            <input class='form-control' type='text' name='custom_attribute' id="custom_attribute" value='' placeholder="Enter your own" />
                          </div>
                          <div class="col-sm-3">
                            <input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_query'][0]['EBAY_CATEGORY_ID'];  ?>">
                            
                            <input type="button" name="save_custom_attr" id="save_custom_attr" class="add-row btn btn-success" value="Save">
                          </div>
                        <!-- </form> -->
                        </div>
                      
                      </div>                      
                     

                    <div class="col-sm-12 catlogueBlock">
                        <div class="col-sm-3">
                          <button type="button" id="addCatalogueGroup" class="btn btn-default btn-block">Enter your Catalogue Group Name</button><br>
                        </div>
                        <div id="CatalogueGroup">
                          <div class="col-sm-3">
                            <div class="form-group">
                              <!-- <label for="Catalogue Group Name">Catalogue Group Name</label> -->
                              <input type="text" class="form-control" name="catalogueGroupName" id="catalogueGroupName" value="" placeholder="Catalogue Group Name">
                            </div>
                          </div>
                          <div class="col-sm-2">
                            <div class="from-group">
                              <input type="submit" class="btn btn-success btn-small" name="groupName" id="groupName" value="Save">
                            </div>
                          </div>
                        </div>                      
                    </div>   

                    <?php endif;?>
                      <div class="col-sm-12">
                        <div class="form-group pull-right">
                          <a href="<?php echo base_url();?>bigData/c_bd_recognize_data/recognizeWords" class="btn btn-primary btn-small" title="Title">Back</a>
                        </div>
                      </div>                      
                  </div>
                </div>
            </div>
        <!-- Item Specific end -->                    

        <!-- Catalogue Detail start --> 
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Catalogue Detail</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="box-body">
                <div class="col-sm-12">
                  <table class="table table-bordered table-striped table-responsive table-hover" id="catalogue_data">
                    

                  </table>
                  
                </div>
                
              </div>
            </div>
            <!-- Catalogue Detail end --> 

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->



 <?php $this->load->view('template/footer'); ?>
<script type="text/javascript" charset="utf-8">
 // Add Item Specifics and Attributes
  $("#addCatalogueGroup").on("click", function(){
    $("#CatalogueGroup").toggle();                 // .fadeToggle() // .slideToggle()
  });

$("#groupName").click(function(){
    var catalogueGroupName = $("#catalogueGroupName").val();

  if(catalogueGroupName == '' || catalogueGroupName == null){
    alert('Please insert specific name');
    $("#catalogueGroupName").focus();
    return false;
  } 

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/addCatalogueGroupName',
      data: { 'catalogueGroupName' : catalogueGroupName},
     success: function (data) {
        if(data == false){
          alert('Catalogue Group name is already exist.');
          return false;
          }else{
            alert('Catalogue Group name ssuccessfully added.');
          } 

          $.ajax({dataType: 'json', 
            type: 'POST', 
            url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/getGroupName', 
            success: function(data){

              var names = [];
              for(var i=0;i<data.length;i++){
                names.push('<option value="'+data[i].CATALOGUE_GROUP_ID+'">'+data[i].CATALOGUE_GROUP_VALUE+'</option>');
              }
              $('#catalogueDrop').html("");
              $('#catalogueDrop').append('<label>Catalogue Group Name:</label><select class="form-control " name="catalogue_name" id="catalogue_name">'+names.join("")+'</select>');

              // $('#catalogue_name').empty(); 
              // $.each(data,function(i,item){$('#catalogue_name').append('<option value="'+data[i].CATALOGUE_GROUP_ID+'">'+data[i].CATALOGUE_GROUP_VALUE+'</option>'); 
              // }); 
            } 
          });         
        }
      }); 

   
 });


$(document).on('change','#spec_name',function(){

    var spec_mt_id = $("#spec_name").val();
    var bd_category = $("#bd_category").val();
   
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




$(document).ready(function(){
  $("#add_object").on('click',function(){
     $('#objectDiv').toggle();
     $.ajax({
          dataType: 'json', 
          type: 'POST', 
          url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/getCatGroups',
          data:{}, 
          success: function(result){
           
            var groups = [];
            for(var i=0;i<result.length;i++){
              groups.push('<option value="'+result[i].LZ_BD_GROUP_ID+'">'+result[i].GROUP_NAME+'</option>');
            }

            $('#group_names').html(""); 
            $('#group_names').append('<option value="">---select---</option>'+groups);
              $('body .cats_group').selectpicker();
          } 
        }); 
  });

  ///////////////////////////
  $('#objectDiv').hide();
  var mpn = $("#mpn").val();
  // console.log(mpn);
  var cat_id = $("#cat_id").val();
  // console.log(cat_id);


   $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/catalogueDetail',
      data: { 'mpn' : mpn,'cat_id':cat_id},
     success: function (data) {

        
        var catalogue_data = []; // to save Specific_Name and Specific_Value
        var groupedCatalogue = [];// to add rowspan according to group value
        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
        
        for(var j= 0;j<data.groupCount.length; j++){

          groupedCatalogue.push('<tr><td rowspan="'+data.groupCount[j].ROW_SPAN+'">'+data.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
            for (var i = 0; i < data.catalogue_data.length; i++) {
                if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                  // if group_id is same then all value in same row
                  catalogue_data.push('<td>'+data.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+data.catalogue_data[i].SPECIFIC_VALUE+'</td><td><a class="catalogues_detail" id="'+data.catalogue_data[i].DET_ID+'" title="Show_Detail"><i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i></a></td></tr>'); 
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
        $("#catalogue_data").append('<thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th><th>Alternate Value</th> </thead><tbody>'+catalogueJoin.join("")+'</tbody>');          
     }
    }); 

  // var list = '  <?php //foreach(@$data['group_qry'] as $row): echo '<option value="'.@$row['CATALOGUE_GROUP_ID'].'">'.@$row['CATALOGUE_GROUP_VALUE'].'</option>'; endforeach; ?>';

    //$('#catalogue_name').append(list);

    // $(".catalogues_detail").click(function(){
    //   var det_id = this.id;
    //   alert('clicked');
 
    //   // $.ajax({
    //   //   dataType: 'json',
    //   //   type: 'POST',
    //   //   url:'<?php //echo base_url(); ?>catalogue/c_itemCatalogue/alternateValue',
    //   //   data: { 'det_id' : det_id},
    //   //   success: function(data){
    //   //     if(data != ''){

    //   //       var myWindow = window.open("", "MsgWindow", "width=800,height=600");

    //   //        myWindow.document.write('<html><head><title>Laptopzone | Check List Details</title><link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/bootstrap/css/bootstrap.min.css');?>"><link rel="stylesheet" href="<?php //echo base_url('assets/dist/css/AdminLTE.min.css');?>"><link rel="stylesheet" href="<?php //echo base_url('assets/dist/css/skins/_all-skins.min.css');?>"></head><body>');
      
    //   //     var i;
    //   //     }
    //   //   }
    //   // });

    // });
});




$("#create_object").on('click',function(){
  var new_object    = $('#new_object').val();
  var bd_category   = $("#bd_category").val();
  var group_id      = $("body .cats_group select").val();
  //console.log(bd_category, new_object, group_id); return false;
  if(new_object == ''){
    alert('please enter a name for object!');
  }else{
    $.ajax({
      url: '<?php echo base_url(); ?>catalogue/c_itemCatalogue/createObject',
      dataType:'json',
      type: 'post',
      data:{'new_object':new_object, 'bd_category':bd_category, 'group_id':group_id},
      success: function(data){
        if(data == 1){
          alert('Success: Object is created!');
        }else{
          alert('warning: Object already exists!');
        }

        $.ajax({
          url: '<?php echo base_url(); ?>catalogue/c_itemCatalogue/getSpecificObjects',
          dataType:'json',
          type: 'post',
          data:{'bd_category':bd_category},
          success: function(result){
            var obj = [];
            for(var i = 0;i<result.length;i++){
              obj.push('<option value="'+result[i].OBJECT_ID+'">'+result[i].OBJECT_NAME+'</option>');
            }
            $("#cataObject").html("");
            $("#cataObject").append('<label for="Conditions" class="control-label ">OBJECT:</label> <select name="catalogue_object" id="catalogue_object" class="form-control cat_dropDown" data-live-search="true" required> <option value="0">---</option> '+obj.join("")+'</select>');
            $('.cat_dropDown').selectpicker();
          }
        });
      }
    });
  }
});
// $("#save_object").click(function(){
//     var mpn = $("#mpn").val();
    
//     var cat_id = $("#cat_id").val();
//     var obj_val = $("#catalogue_object").val();
    

//      $.ajax({
//       dataType: 'json',
//       type: 'POST',
//       url:'<?php //echo base_url(); ?>catalogue/c_itemCatalogue/updateObjectID',
//       data:{'obj_val':obj_val,'cat_id':cat_id,'mpn':mpn},
//       success: function(result){
//         if(result == 1){
//           alert('Object Added');
//         }else{
//           alert('Warning ! Object for catalogue already exist');
//         }
//       }
//     });
// });

// catalogue saving

$("#save_catalogue").click(function(){
    var cat_id            = $("#bd_category").val();
    var  master_mpn       = $('#master_mpn').val();
    var mpn               = $("#mpn").val();
    var mpn_desc          = $('#mpn_desc').val();
    var object_id         = $('#catalogue_object').val();
    var catalogue_name    = $("#catalogue_name").val();
    var spec_name         = $("#spec_name").val();
    var spec_val          = $("#spec_val").val();
   
    
    
    

    // master mpn id 
   
    
     //console.log(object_id); return false;
    // return false;
    
    // alert(master_mpn);
    // return false;

  if(cat_id == '' || cat_id == null ){
    alert('Warning: Please select category First!');
    $("#bd_category").focus();
    return false;
  }else if( mpn == '' || mpn == null){
    alert('Warning: Please select MPN!');
    $("#mpn").focus();
    return false;
  }else if(mpn_desc == '' || mpn_desc == null){
    alert('Warning: MPN Description is required!');
    $("#mpn_desc").focus();
    return false;
  }else if(object_id == '' || object_id == null || object_id == 0){
    alert('Warning: Please select Object!');
    $("#catalogue_object").focus();
    return false;
  }else {
    //console.log(cat_id, mpn, mpn_desc, object_id);
    //return false;
     $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/addCatalogue',
        data: { 'mpn_desc':mpn_desc,'mpn' : mpn,'catalogue_name':catalogue_name,'cat_id':cat_id,'spec_val':spec_val,'object_id':object_id,'master_mpn':master_mpn},
        success: function (data) {

         if(data.check == 0){
            alert('Error! Record is not inserted.');
            return false;
          }else if(data.check == 1){
              alert('Sucess! Record is successfully inserted.');
          }else if(data.check == 2){
            alert('Warning! Record is already exist.');
          }
          
          var catalogue_data = []; // to save Specific_Name and Specific_Value
          var groupedCatalogue = [];// to add rowspan according to group value
          var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
          
          for(var j= 0;j<data.groupCount.length; j++){

            groupedCatalogue.push('<tr><td rowspan="'+data.groupCount[j].ROW_SPAN+'">'+data.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
              for (var i = 0; i < data.catalogue_data.length; i++) {
                  if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                    // if group_id is same then all value in same row
                    catalogue_data.push('<td>'+data.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+data.catalogue_data[i].SPECIFIC_VALUE+'</td><td><a class="catalogues_detail" id="'+data.catalogue_data[i].DET_ID+'"><i style="font-size: 28px;margin-top: 4px; cursor: pointer;" class="fa fa-external-link" aria-hidden="true"></i></a></td></tr>'); //This adds each thing we want to append to the array in order.
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
       }
      });
  }
 
 });

$("#cat_cust_specs").click(function(){
    var cat_id = $("#cat_id").val();
    var custom_name = $("#custom_name").val();
    var custom_value = $("#custom_value").val();
    var maxValue = $("#maxValue").val();
    var selectionMode = $("#selectionMode").val();
    var catalogue_only = $("#catalogue_only").val();

    //alert(catalogue_only);return false;

  if(custom_name == '' || custom_name == null){
    alert('Please insert specific name');
    $("#custom_name").focus();
    return false;
  }else if(custom_value == '' || custom_value == null){
    alert('Please insert specific value');
    $("#custom_value").focus();
    return false;
  }
  if(selectionMode == 'FreeText' && maxValue > 1){
    alert('You can only insert 1 against FreeText.');
    return false;
  }  

  $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/addCustomSpecsforCatalog',
      data: { 'cat_id' : cat_id,
              'custom_name' : custom_name,
              'custom_value' : custom_value,
              'maxValue': maxValue,
              'selectionMode': selectionMode,
              'catalogue_only': catalogue_only
    },
     success: function (data) {
        if(data == false){
          alert('Specific name is already exist.');
          return false;
        }else{
          alert('Record successfully added.');
        }     

        var bd_category = $("#bd_category").val();
        $.ajax({
          dataType: 'json', 
          type: 'POST', 
          url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/re_getCategorySpecifics',
          data:{'bd_category':bd_category}, 
          success: function(result){
            // alert(result.mt_query[0].SPECIFIC_NAME); return false;
            // alert(data.mt_query.length);return false;
            // alert(data.mt_query[0].SPECIFIC_NAME);
            var specifics = [];

            for(var i=0;i<result.mt_query.length;i++){
              specifics.push('<option value="'+result.mt_query[i].MT_ID+'">'+result.mt_query[i].SPECIFIC_NAME+'</option>');
            }

            $('#spex_names').html(""); 
            $('#spex_names').append('<label class="">Specific Name :</label><select class="form-control spexDropdown" data-live-search="true" name="spec_name" id="spec_name"> <!-- <option value="">Select</option> --> <option value = "0">---</option>'+specifics+'</select>');
              $('.spexDropdown').selectpicker();
              // $.each(data.mt_query,function(i,item){
              // $('#spec_name').append('<option value="'+data.mt_query[i].MT_ID+'">'+data.mt_query[i].SPECIFIC_NAME+'</option>'); 
            // }); 

          } 
        });     
     }
  });



    
 });


$("#save_custom_attr").click(function(){
    // var cat_id = $("#cat_id").val();
    var custom_attribute = $("#custom_attribute").val();
    var mt_id = $('#new_spec_name').val(); 
  if(custom_attribute == '' || custom_attribute == null){
    alert('Please insert custom attribute value');
    //$("#custom_attribute").focus();
    return false;
  }
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/saveCustomAttribute',
      data: { 'custom_attribute' : custom_attribute, 'mt_id': mt_id},
     success: function (data) {
        if(data == false){
          alert('Attribute value is already exist.');
          return false;
          }else{
            alert('Record successfully added.');
          }          


          var spec_mt_id = $("#new_spec_name").val();
          var bd_category = $("#bd_category").val();

          var spex = $("#spec_name").val();
          $.ajax({
            dataType: 'json',
            type: 'POST',        
            url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/getItemSpecificsValues',
            data: { 'spec_mt_id' : spec_mt_id, 'bd_category':bd_category},
           success: function (data) {
            

              var specificsValues = []; 
              for (var i = 0; i < data.length; i++) {
                  specificsValues.push('<option value="'+data[i].DET_ID+'">'+data[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
              }

              //Since we defined our variable as an array up there we join it here into a string
              if(spex == spec_mt_id){


                specificsValues.join(" ");
                $("#specificValue").html("");
                $("#specificValue").append('<select style="width:160px;" class="form-control specifics selectDropdown" data-live-search="true" name="spec_val" id="spec_val">'+specificsValues+'</select>');
                $('.selectDropdown').selectpicker();
              }

          }
    });
     }
    }); 

  
});

/*==============================================
=            catalogue detail popup            =
==============================================*/
$(document).on('click', "a.catalogues_detail", function() {
   var det_id = this.id;
  // alert('clicked');
  // console.log('clicked');
 
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/alternateValue',
        data: { 'det_id' : det_id},
        success: function(data){
          if(data != ''){

            var myWindow = window.open("", "MsgWindow", "width=800,height=600");

            myWindow.document.write('<html><head><title>Laptopzone | Catalogue Details</title><link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>"><link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>"><link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css');?>"></head><body>');
      
            var i;

            var label = '<div class="box"><div class="box-header w-border" style="background-color: #3c8dbc !important;color:#fff !important;"><h4 class="box-title">Catalogue Details</h4></div></div><div class="col-xs-6"><div class="form-group"><label for="">Specific Value:</label><span class="text"> &nbsp;&nbsp;'+data.original[0].SPECIFIC_VALUE+'</span></div></div></div><div class="col-xs-6"><div class="form-group"><label for=""></label><span class="text"> &nbsp;&nbsp;</span></div></div><br><div class="row"><div class="col-sm-12" ><div class="form-group" style="border: 1px solid #ccc !important; padding: 3px 10 !important;"><label for="">Alternate Specific Value:</label>'; myWindow.document.write(label);

            for(i = 0;i<data.alt.length;i++){
          
              myWindow.document.write('<li class="text"> &nbsp;&nbsp;'+data.alt[i].SPEC_ALT_VALUE+'</li>');           

            }

            myWindow.document.write('</div></div></div><div class="row"><div class="col-sm-12"><div class="box"><div class="box-header with-border" style="background-color: #3c8dbc !important;color:#fff !important;"><strong style="margin-left:12px;">Copyright &copy; <?php echo date('Y'); ?> <a href="#" style="color:#fff !important;">Laptop Zone</a>.</strong> All rights reserved.</div></div></div></div></body></html>');
          }
        }
      });

});


/*=====  End of catalogue detail popup  ======*/





</script>


