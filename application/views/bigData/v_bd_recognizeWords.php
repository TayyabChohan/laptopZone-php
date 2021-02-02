
<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?> 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo (isset($pageTitle)) ? $pageTitle : 'Dashboard'; ?> </li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">      
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
              <form action="<?php echo base_url(); ?>bigData/c_bd_recognize_data/recognizeWordSearch" method="post" accept-charset="utf-8">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_search" id="bd_search" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>" required>                      
                  </div>
                </div>  
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" id="bd_category" class="form-control selectpicker" data-live-search="true" required>
                      <option value="0">---</option>
                      <?php                                
                         if(!empty($getCategories)){

                          foreach ($getCategories as $cat){

                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                              <?php
                              } 
                          }
                          
                      ?>  
                                          
                    </select>  
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="No of Records" class="control-label">No of Records:</label>
                    <select name="bd_records" id="bd_records" class="form-control">
                      <option value="1000" <?php if($this->session->userdata('no_of_record') == 1000){echo "selected";}?>>1000</option>
                      <option value="2000" <?php if($this->session->userdata('no_of_record') == 2000){echo "selected";}?>>2000</option>
                      <option value="3000" <?php if($this->session->userdata('no_of_record') == 3000){echo "selected";}?>>3000</option>
                      <option value="4000" <?php if($this->session->userdata('no_of_record') == 4000){echo "selected";}?>>4000</option>
                      <option value="5000" <?php if($this->session->userdata('no_of_record') == 5000){echo "selected";}?>>5000</option>

                      ?>  
                                          
                    </select>  
                  </div>
                </div>
                <div class="col-sm-1">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="bd_submit" id="bd_submit" value="Search">
                  </div>
                </div>

              </form>                                            
            </div>


          </div>
            <!-- /.box-body -->       
        </div>
          <!-- /.box -->
        <?php //var_dump($data['title_data']);exit; ?>
        <?php if(!empty(@$data)):  ?>
        <div class="box">
          <div class="box-body form-scroll">

            <div class="col-sm-12">
              <div class="col-sm-10"></div>
              <div class="col-sm-2">
                <div class="form-group">
                  <a class="btn btn-sm btn-primary" target="_blank" href="<?php echo base_url('specifics/c_item_specifics/itemCategorySpecifics')."/".$this->session->userdata('category_id');?>">Add Custom Specifics</a>
                </div>
              </div><br><br>

              <table id="recognizeTitle" class="table table-responsive table-striped table-bordered table-hover recognizeData" >

                <thead>
                  <tr>
                    <th>TITLE ID</th>
                    <th>ORIGNAL TITLE</th>
                    <th>MATCH TITLE</th>
                    <th>LEFTOVER TITLE</th>
                    <th>SPECIFICS</th>
                    <th>ALT VALUE</th>

                  </tr>  
                </thead>
                <tbody>
                  <?php 
                  $k = 1;
                  foreach (@$data['title_data'] as $row) {
                    
                  ?>
                  <tr>
                    <td><?php //echo $row['TITLE_ID']; ?>
                    <a href="<?php echo $row['ITEM_URL']; ?>"><?php echo $row['TITLE_ID']; ?></a>
                      <input type="hidden" name="title_id" id="title_id_<?php echo $k; ?>" class="form-control" value="<?php echo $row['TITLE_ID']; ?>">
                    </td>
                    <td>
                      <div style="width: 150px!important;">
                       
                        <?php echo $row['ORIGINAL_TITLE']; ?>
                      </div>                          
                    </td>
                    <td>
                      <div style="width: 150px!important;">
                       
                        <?php echo $row['MATCHED_TITLE']; ?>
                      </div>                           
                    </td>
                    <td>
                      <div style="width: 150px!important;">

                        <?php 
                          $left_title  = $row['LEFTOVER_TITLE'];
                          $pieces = explode(" ", $left_title);
                          $i = 1;
                          foreach ($pieces as $value) {
                            echo "<a class='leftOver' name='alt_word_".$k."' id='leftOver_".$i."' style='text-decoration:underline;padding-right:6px;cursor:pointer;' value='".$value."'> ".$value." </a>";
                            $i++;
                          }

                        ?>
                       
                      </div>                           
                    </td>                        
                    <td>
                      <div style="width:160px;" class="">
                        <select style="width:160px;" class="form-control specifics" name="<?php echo $k; ?>" id="specifics_<?php echo $k; ?>">
                          <?php
                            foreach(@$data['spec_name'] as $name):
                          ?>
                          <option value="<?php echo $name['MT_ID']; ?>"><?php echo $name['SPECIFIC_NAME']; ?></option>
                        
                          <?php
                            endforeach;
                          ?>
                          <option value="LZ_MPN">LZ MPN</option>
                          <option value="OBJECT">Object</option>
                          <option value="GW">General Word</option>
                          <option value="OTH">Other</option>
                        </select><br><br>

                        <div style="width:160px;" id="val_specifics_<?php echo $k; ?>" class="form-group specsValue">
                          
                        </div>
                      
                      </div>                             

                    </td>
                    <td>
                      <div class="col-sm-4">
                        <div id="input_specifics_<?php echo $k; ?>" class="alt_mpn_inputs form-group">
                          <input type="text" name="alt_word" id="alt_word_<?php echo $k; ?>" class="form-control" value="">

                        </div>
                      </div>

                      <div class="col-sm-6">
                        <div class="col-sm-6">
                          <div class="form-group">
                           <input type="button" class="btn btn-primary recognizeWords" name="<?php echo $k; ?>" id="recognizeWords" value="Recognize" >
                            
                          </div>                          
                        </div>
                        <div class="col-sm-6 ">
                          <div id="msgWrap_<?php echo $k; ?>" class="msgWrap_<?php echo $k; ?>">
                            <div id="saveMessage_<?php echo $k; ?>" class=""></div>
                            <div id="errorMessage_<?php echo $k; ?>" class=""></div>                            
                          </div>

                        </div>



                      </div>

                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="button" class="btn btn-success verifyData" name="<?php echo $k; ?>" id="<?php echo $row['TITLE_ID']; ?>" value="Verify" >                          
                        </div>
                      </div>
                        <div class="col-sm-6" style="margin-top: 10px !important;margin-left: 30px !important;">
                          <div id="suggestedMpn_<?php echo $k; ?>" class="suggestedMpn">
                            
                          </div>
                        </div>                      


                    </td>
                  </tr>

                  <?php 
                  $k++;
                } //end main foreach ?>
                

                </tbody>
                     
              </table>          
              <!-- alt_word_input index -->
              <input type="hidden" name="index" id="index" class="form-control" value="<?php echo $k; ?>">
                    
            </div><!-- /.col -->
                    
          </div>
        </div>
      <?php endif; //main if for empty value check ?>


      </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
  </section>

    <!-- /.content -->
</div>

<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script type="text/javascript">
//$(document).ready(function () {
  
//});
  // function checkSel() {
  //   var cat_id = $("#bd_category").val();

  // if (cat_id == '' || cat_id == null) { alert('Please select the value.'); return false;}
  // }
  $('.selectDropdown').selectpicker();
 
    $('#recognizeTitle').DataTable({
      "paging": true,
      "iDisplayLength": 500,
      "aLengthMenu": [[100, 200,500, 1000, -1], [100, 200,500, 1000, "All"]],
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      //"order": [[ 3, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    }); 

  $(".leftOver").click(function(){
    
    var leftOver = $(this).attr('value');
    var leftOver_name = $(this).attr('name');
    var current_val = $("#"+leftOver_name).val();
    var str = current_val + " " +leftOver;
    alt_word = $("#"+leftOver_name).val(str.trim());
    //alert(leftOver);
    //alert($(this).attr('value'));
    //alert(leftOver);return false;

  });

  // on click MPN add inputs 
  $(".specifics").change(function(){

    var index = $(this).attr('name');
    var titleId = $(index).id;
    var alt_word_val = $("#alt_word_"+index).val();
    var count_index = $("#index").val();
    //alert(count_index);
    var count_plus = parseInt(count_index) + 1; 
    //alert(count_plus);
    var specific_id = this.id;
    var specific = $("#"+specific_id).val();

    if(alt_word_val == null || alt_word_val == "" || specific == "Test_MPN"){


        
        if(specific == "LZ_MPN"){

            var alt_word_val = $("#alt_word_"+index).val();

            //onchange Remove msgWrap's childs (previous message)
            $("#saveMessage_"+index).remove();
            $("#errorMessage_"+index).remove();
            $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');

            $("#input_"+specific_id).html("");
            $("#val_"+specific_id).html("");

            var category_id = $("#bd_category").val();
            var title_id = $("#title_id_"+index).val();

            //alert(titleId);return false;

              $.ajax({
                dataType: 'json',
                type: 'POST',
                url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/getCategorySpecifics',
                data: {'category_id' : category_id, 'title_id':title_id},
               success: function (data) {
                //console.log(data.get_specifics); return false;//data.already_qry[0].ALREADY_PULL_QTY
                //return false;
                
                /*=====  Start For Specifics name and value  ======*/
                var brandText = "";

                  var brandText = []; 
                  for (var b = 0; b < data.get_specifics.length; b++){

                    if(data.get_specifics[b].SPECIFIC_NAME == "Brand"){
                      brandText.push('<option value="'+data.get_specifics[b].SPECIFIC_VALUE+'">'+data.get_specifics[b].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
                    }

                  //Since we defined our variable as an array up there we join it here into a string
                  brandText.join(" ");
                  //$("#val_"+specific_id).html("");
                  } 
                var product_family = "";
                var product_family = [];   
                for(var p = 0; p < data.get_specifics.length; p++){

                  if(data.get_specifics[p].SPECIFIC_NAME == "Product Family"){
                    product_family.push('<option value="'+data.get_specifics[p].SPECIFIC_VALUE+'">'+data.get_specifics[p].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
                  }
                  product_family.join(" ");
                 }
                 /*=====  End For Specifics name and value  ======*/

                /*=====  Start For MPN name and value  ======*/
                var mpn = "";
                for(var i=0; i< data.mpn_qry.length; i++){

                  if(data.mpn_qry[i].MPN){
                    mpn = data.mpn_qry[i].MPN;
                  }                

                 }
                 /*=====  End For MPN name and value  ======*/
                /*=====  Start For Model name and value  ======*/
                var model = "";
                var model = [];
                for(var k=0; k< data.get_specifics.length; k++){

                  if(data.get_specifics[k].SPECIFIC_NAME == "Model"){
                    model.push('<option value="'+data.get_specifics[k].SPECIFIC_VALUE+'">'+data.get_specifics[k].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
                  }                
                  model.join(" ");
                 }
                 /*=====  End For Model name and value  ======*/
                /*=====  Start For Object name and value  ======*/
                var object = "";
                var object = [];
                for(var j=0; j< data.get_objects.length; j++){

                  if(data.get_objects[j].OBJECT_NAME){
                    object.push('<option value="'+data.get_objects[j].OBJECT_NAME+'">'+data.get_objects[j].OBJECT_NAME+'</option>'); //This adds each thing we want to append to the array in order.
                  }                
                  object.join(" ");
                 }
                 /*=====  End For Object name and value  ======*/                                 

                $("#input_"+specific_id).append('<label>MPN:</label><input type="text" class="form-control" id="mpn_'+index+'" name="mpn" value="'+mpn+'"> <label>Manufacturer:</label><select style="width:160px;" class="form-control brandSelection" data-live-search="true" id="manufacturer_'+index+'" name="manufacturer_'+index+'">'+brandText+'</select> <label>Brand:</label><select style="width:160px;" class="form-control brandSelection" data-live-search="true" name="brand_'+index+'" id="brand_'+index+'">'+brandText+'</select> <label>Model:</label> <select style="width:160px;" type="text" class="form-control brandSelection" data-live-search="true" id="model_'+index+'" name="model_'+index+'">'+model+'</select> <label>Product Family:</label><select style="width:160px;" type="text" class="form-control brandSelection" data-live-search="true" id="product_family_'+index+'" name="product_family_'+index+'">'+product_family+'</select> <label>Object:</label><select style="width:160px;" type="text" class="form-control brandSelection" data-live-search="true" id="object_'+index+'" name="object_'+index+'" >'+object+'</select>'); $("#val_specifics_"+index).append('<input type="button" class="btn btn-link suggest_mpn" name="suggest_mpn_'+index+'" id="'+title_id+'" value="Suggest MPN">');
                $('.brandSelection').selectpicker();

                // Suggest MPN against Title
                  $(".suggest_mpn").click(function(){
                    
                    var title_id = this.id;
                    var category_id = $("#bd_category").val();
                    //alert(title_id);
                              $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/getSuggestedMPN',
                                data: {'category_id' : category_id, 'title_id':title_id},
                               success: function (data) {
                                //console.log(data);return false;
                                $("#suggestedMpn_"+index).html("");

                                if(data != 0){

                                var suggestMPN = [];
                                for(var m = 0; m < 5; m++){

                                  
                                    suggestMPN.push('<tr><td>'+data[m].MPN+'</td><td>'+data[m].CNT+'</td><td><input type="button" class="btn btn-link selectMPN" id="'+data[m].MPN_MT_ID+'" value="Select"></td></tr>'); //This adds each thing we want to append to the array in order.
                                                 
                                  //suggestMPN.join(" ");
                                 }                                  

                                  $("#suggestedMpn_"+index).append('<table class="table table-bordered table-striped table-responsive"><thead><tr><th>MPN</th><th>SPECIFICS COUNT</th><th>SELECT</th></tr></thead><tbody>'+suggestMPN.join("")+'</tbody></table>');

                                }


                               }
                               });    


                  });

                //Select Suggested MPN fields against Title
                 $(".suggestedMpn").on('click','.selectMPN',function(){
                    
                     var mpn_mt_id = this.id;
                     //alert(mpn_mt_id); return false;
                    // var category_id = $("#bd_category").val();
                    //alert(title_id);
                    
                              $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/selectSugestedMPN',
                                data: {'mpn_mt_id':mpn_mt_id},
                               success: function (data) {

                                if(data){
                                  $("#mpn_"+index).val(data[0].MPN);
                                  $('select[id=manufacturer_'+index+']').val(data[0].MANUFACTURER);
                                  $('select[id=brand_'+index+']').val(data[0].BRAND);
                                  $('select[id=model_'+index+']').val(data[0].MODEL);
                                  $('select[id=product_family_'+index+']').val(data[0].PRODUCT_FAMILY);
                                  $('select[id=object_'+index+']').val(data[0].OBJECT_NAME);
                                  $('.brandSelection').selectpicker('refresh')
                                  //$("#manufacturer_"+index).val(data[0].MANUFACTURER);
                                  //console.log($("#manufacturer_"+index).val(data[0].MANUFACTURER));
                                  // $("#brand_"+index).val(data[0].BRAND);
                                  // $("#model_"+index).val(data[0].MODEL);
                                  // $("#product_family_"+index).val(data[0].PRODUCT_FAMILY);
                                  // $("#object_"+index).val(data[0].OBJECT_NAME);
                                }


                               }
                               });    


                  }); 



                //$("#mpn_"+index).val(alt_word_val);
                }
              });


            //alert(specific);return false;
          }else if(specific == "GW"){

            //onchange Remove msgWrap's childs (previous message)
            $("#saveMessage_"+index).remove();
            $("#errorMessage_"+index).remove();
            $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');
            $("#suggestedMpn_"+index).html("");
            $("#input_"+specific_id).html("");
            $("#input_"+specific_id).append('<input type="text" name="alt_word" id="alt_word_'+index+'" class="form-control" value="">');
              //var mt_id = $("#"+specific_id).val();
              //alert(specific);return false;
              $.ajax({
                dataType: 'json',
                type: 'POST',
                url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/getGenWords',
                //data: {'mt_id' : mt_id},
               success: function (data) {
                //alert(data.length);

                var appendText = []; 
                for (var i = 0; i < data.length; i++) {
                    appendText.push('<option value="'+data[i].GEN_MT_ID+'">'+data[i].SET_DESCRIPTION+'</option>'); //This adds each thing we want to append to the array in order.
                }

                //Since we defined our variable as an array up there we join it here into a string
                appendText.join(" ");
                $("#val_"+specific_id).html("");
                $("#val_"+specific_id).append('<select style="width:160px;" class="form-control specifics selectDropdown" data-live-search="true" name="spec_val_'+index+'" id="spec_val_'+index+'">'+appendText+'</select>');
                $('.selectDropdown').selectpicker();

               }
              });            


          }else if(specific == "OTH"){

            //onchange Remove msgWrap's childs (previous message)
            $("#saveMessage_"+index).remove();
            $("#errorMessage_"+index).remove();
            $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');
            $("#suggestedMpn_"+index).html("");
            $("#input_"+specific_id).html("");
            $("#input_"+specific_id).append('<input type="text" name="alt_word" id="alt_word_'+index+'" class="form-control" value="">');
              //var mt_id = $("#"+specific_id).val();
              //alert(specific);return false;
              $.ajax({
                dataType: 'json',
                type: 'POST',
                url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/getGenWords',
                //data: {'mt_id' : mt_id},
               success: function (data) {
                //alert(data.length);

                var appendText = [];
                var selected = ''; 
                for (var i = 0; i < data.length; i++) {
                  if(data[i].GEN_MT_ID == 4){
                    selected='selected';
                    }else{
                      selected='';
                    }
                    appendText.push('<option value="'+data[i].GEN_MT_ID+'" '+selected+'>'+data[i].SET_DESCRIPTION+'</option>'); //This adds each thing we want to append to the array in order.
                  
                }

                //Since we defined our variable as an array up there we join it here into a string
                appendText.join(" ");
                $("#val_"+specific_id).html("");
                $("#val_"+specific_id).append('<select style="width:160px;" class="form-control specifics selectDropdown" data-live-search="true" name="spec_val_'+index+'" id="spec_val_'+index+'">'+appendText+'</select>');
                $('.selectDropdown').selectpicker();


               }
              });              

          }else if(specific == "OBJECT"){
            // $("#input_"+specific_id).remove();
            //$("#alt_word_" + i).remove();
            
            //onchange Remove msgWrap's childs (previous message)
            $("#saveMessage_"+index).remove();
            $("#errorMessage_"+index).remove();
            $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');

            $("#input_"+specific_id).html("");
            $("#val_specifics_"+index).html("");
            $("#suggestedMpn_"+index).html("");
            $("#input_"+specific_id).append('<input type="text" name="alt_word" id="alt_word_'+index+'" class="form-control" value="">');
              var object = $("#alt_word_"+index).val();
              //alert(object);return false;

          }else{
            // $("#input_"+specific_id).remove();
            //$("#alt_word_" + i).remove();
            
            //onchange Remove msgWrap's childs (previous message)
            $("#saveMessage_"+index).remove();
            $("#errorMessage_"+index).remove();
            $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');

            $("#input_"+specific_id).html("");
            $("#suggestedMpn_"+index).html("");
            $("#input_"+specific_id).append('<input type="text" name="alt_word" id="alt_word_'+index+'" class="form-control" value="">');
              var mt_id = $("#"+specific_id).val();
              //alert(specific);return false;
              $.ajax({
                dataType: 'json',
                type: 'POST',
                url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/getSpecificsValues',
                data: {'mt_id' : mt_id},
               success: function (data) {
                //alert(data.length);

                var appendText = []; 
                for (var i = 0; i < data.length; i++) {
                    appendText.push('<option value="'+data[i].DET_ID+'">'+data[i].SPECIFIC_VALUE+'</option>'); //This adds each thing we want to append to the array in order.
                }

                //Since we defined our variable as an array up there we join it here into a string
                appendText.join(" ");
                $("#val_"+specific_id).html("");
                $("#val_"+specific_id).append('<select style="width:160px;" class="form-control specifics selectDropdown" name="spec_val_'+index+'" data-live-search="true" id="spec_val_'+index+'">'+appendText+'</select>');
                $('.selectDropdown').selectpicker();

               }
              });
          }
    }

  });





  $(".recognizeWords").click(function(){

    // var specific_id = this.id;
    // //alert(specific_id);return false;
    // var specific = $("#"+specific_id).val();

    var index = $(this).attr('name');
    var spec_alt_value = $("#alt_word_"+index).val();
    var det_id = $("#spec_val_"+index).val();

    var specifics = $("#specifics_"+index).val();
    var bd_category = $("#bd_category").val();
    //debugger;
    //alert(spec_alt_value.trim());return false;
    // if(spec_alt_value == null || spec_alt_value == ""){
    //   alert('Please Select a value.');return false;
    // }else{
      //alert('Call');return false;

      if(specifics == "LZ_MPN"){

          var mpn = $("#mpn_"+index).val();
          var manufacturer = $("#manufacturer_"+index).val();
          var brand = $("#brand_"+index).val();
          var model = $("#model_"+index).val();
          var product_family = $("#product_family_"+index).val();
          var object = $("#object_"+index).val();
          
          //alert(bd_category);return false;

          $.ajax({
            dataType: 'json',
            type: 'POST',
            url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/addMpnData',
            data: {'mpn' : mpn, 'manufacturer': manufacturer, 'brand' : brand, 'model': model,
                    'product_family':product_family, 'object':object, 'bd_category':bd_category

            },
           success: function (data) {

              // $("#val_"+specific_id).html("");
              if(data == "MPN"){
                $("#saveMessage_"+index).append('<i style="color:#00a65a !important; font-size:30px;" class="fa fa-check" aria-hidden="true"></i>');
                setTimeout(function() {
                  $('#saveMessage_'+index).fadeOut('slow');
                }, 3000); // <-- time in milliseconds

            //onchange Remove msgWrap's childs (previous message)
                setTimeout(function() {
                  $("#saveMessage_"+index).remove();
                  $("#errorMessage_"+index).remove();
                  $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>'); 
                }, 5000); // <-- time in milliseconds                   
                //$("#saveMessage").html("");

              }else{
                $("#errorMessage_"+index).append('<i style="color:#dd4b39 !important; font-size:30px;" class="fa fa-times" aria-hidden="true"></i>');
                setTimeout(function() {
                  $('#errorMessage_'+index).fadeOut('slow');
                }, 3000); // <-- time in milliseconds             
                //$("#errorMessage").html(""); 
              }
            }
          }); 


      }else{

        if(spec_alt_value.trim() == null || spec_alt_value.trim() == ""){
          alert('Please Select a value.');return false;
        }else{  

          $.ajax({
            dataType: 'json',
            type: 'POST',
            url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/addSpecificsAltVal',
            data: {'spec_alt_value' : spec_alt_value, 'det_id': det_id, 'bd_category':bd_category, 'specifics':specifics},
           success: function (data) {
            //console.log(data);return false;

              // $("#val_"+specific_id).html("");
              if(data == 1){

                //debugger;
                $("#saveMessage_"+index).append('<i style="color:#00a65a !important; font-size:30px;" class="fa fa-check" aria-hidden="true"></i>');
                setTimeout(function() {
                  $('#saveMessage_'+index).fadeOut('slow');
                }, 3000); // <-- time in milliseconds
                $("#alt_word_"+index).val("");

            //onchange Remove msgWrap's childs (previous message)
                setTimeout(function() {
                  $("#saveMessage_"+index).remove();
                  $("#errorMessage_"+index).remove();
                  $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>'); 
                }, 5000); // <-- time in milliseconds            
               

              }else if(data == 2){
                $("#errorMessage_"+index).append('<i style="color:#dd4b39 !important; font-size:30px;" class="fa fa-times" aria-hidden="true"></i>');
                setTimeout(function() {
                  $('#errorMessage_'+index).fadeOut('slow');
                }, 3000); // <-- time in milliseconds
                //$("#errorMessage").remove();              
              }else if(data == 3){
                alert("Already Inserted.");
               
             }
            }
            });
          }      

      }
    //}// main else close


  });

$(".verifyData").click(function(){
  var title_id = this.id;
  var index = $(this).attr('name');
    $.ajax({
          dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>bigData/c_bd_recognize_data/verifySingleTitle',
      data: {'title_id' : title_id},
     success: function (data) {

        // $("#val_"+specific_id).html("");
        if(data == 1){

          //onchange Remove msgWrap's childs (previous message)
          $("#saveMessage_"+index).remove();
          $("#errorMessage_"+index).remove();
          $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');

          $("#saveMessage_"+index).append('<i style="color:#00a65a !important; font-size:30px;" class="fa fa-check" aria-hidden="true"></i>');
          setTimeout(function() {
            $('#saveMessage_'+index).fadeOut('slow');
          }, 3000); // <-- time in milliseconds
          //$("#saveMessage").html("");

        }else if(data == 2){
          //onchange Remove msgWrap's childs (previous message)
          $("#saveMessage_"+index).remove();
          $("#errorMessage_"+index).remove();
          $("#msgWrap_"+index).append('<div id="saveMessage_'+index+'" class=""></div><div id="errorMessage_'+index+'" class=""></div>');

          $("#errorMessage_"+index).append('<i style="color:#dd4b39 !important; font-size:30px;" class="fa fa-times" aria-hidden="true"></i>');
          setTimeout(function() {
            $('#errorMessage_'+index).fadeOut('slow');
          }, 3000); // <-- time in milliseconds
          //$("#errorMessage").html("");              
        }else if(data == 3){
          alert("Already Varified.");
         
       }else if(data == 4){
          alert("MPN Not found. Please Assign MPN first.");
         
       }
      }
    });
  });

    /*===== Insertion Success message auto hide end ====*/    

   // $(document).ready(function(){

    /*========================================================
    =            server side script for datatable            =
    ========================================================*/
    // var bd_category = $('#bd_category').val();
    // var bd_search = $('#bd_search').val();
    // var dataTable = $('#recognizeData').DataTable( {
    //   "oLanguage": {
    //   "sInfo": "Total Records: _TOTAL_"
    // },
    // For stop ordering on a specific column
    // columnDefs: [ { orderable: false, targets: [0] }],
    // "iDisplayLength": 100,
    // "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    //   "paging": true,
    //   "lengthChange": true,
    //   "searching": true,
    //   "ordering": true,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      // "info": true,
      // "autoWidth": true,
      // "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      // "processing": true,
      // "serverSide": true,
      
      // "ajax":{
      //   url :"<?php //echo base_url() ?>bigData/c_bd_recognize_data/loadData", // json datasource
      //   type: "post",  // method  , by default get
      //   data: {'bd_search' : bd_search,'bd_category' : bd_category},
      //   error: function(){  // error handling
      //     $(".categoryData-error").html("");
      //     $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
      //     $("#categoryData_processing").css("display","none");
          
      //   }
      // }
      //dataTable.destory();
    // } );
    
    //dataTable.destory();
    /*=====  End of server side script for datatable  ======*/
    
    /*=====================================
=            recognize all            =
=====================================*/
 // $("#recognize_all").click(function(){

    

 //      var bd_category = $('#bd_category').val();
 //      var bd_search = $('#bd_search').val();
 //      var object_bd = $('#object_bd').val();
 //      var mpn_bd = $('#mpn_bd').val(); 
 //      var array_count = $('#array_count').val();
 //      var model_bd = $('#model_bd').val();
 //      var manufacturer_bd = $('#manufacturer_bd').val();
 //      var spec_name=[];
 //      var spec_value=[];
 //      for (var i = 1; i <= array_count; i++) { 
 //        if($('#specific_'+i).val() != 'select_select' ){
 //              spec_name.push($('.specific_name_'+i).val()); 
 //              spec_value.push($('#specific_'+i).val());
 //        }
 //      }
    //console.log(spec_name,spec_value);return false;    
              
// $.ajax({
      //dataType: 'json',
      // type: 'POST',
      // url:'<?php //echo base_url(); ?>bigData/c_bd_recognize_data/recognizeAll',
      // data: {
      //         'bd_search' : bd_search,
      //         'bd_category' : bd_category,
      //         'object_bd' : object_bd,
      //         'mpn_bd' : mpn_bd,
      //         //'array_count' : array_count,
      //         'model_bd' : model_bd,
      //         'manufacturer_bd' : manufacturer_bd,
      //         'spec_name' : spec_name,
      //         'spec_value' : spec_value
      //       },
      // error: function(){  // error handling
      //     $(".categoryData-error").html("");
      //     $("#categoryData").append('<tbody class="categoryData-error"><tr><th colspan="12">No data found in the server</th></tr></tbody>');
      //     $("#categoryData_processing").css("display","none");
          
      //   }
//      success: function () {
//       window.location.href = '<?php //echo base_url(); ?>bigData/c_bd_recognize_data/queryObject';

//      }
//   });

// });


/*=====  End of recognize all  ======*/
     
   // });
// function toggleRecord(source) {
//     checkboxes = document.getElementsByName('select_recognize[]');
//     for(var i=0, n=checkboxes.length;i<n;i++) {
//       checkboxes[i].checked = source.checked;
//     }
//   }
  /*-- Start auto fill specs --*/
// function autoFill(clicked_id) {
//     $.ajax({
//       dataType: 'json',
//       type: 'POST',
//       url:'<?php //echo base_url(); ?>bigData/c_bd_recognize_data/autoFill',
//       data: {
//               'lz_bd_cata_id' : clicked_id
//             },
//      success: function (response) {
//       $("#myform")[0].reset();
      
//       //$('select option:selected').removeAttr('selected');
//       for(var i = 0; i<response.spec_qry.length; i++){
//         var t = response.spec_qry[i].MT_ID;
//         var label_name = $('#'+t).attr("name");
//         var dropdown_id = label_name.replace("_name", "");
//         $('#'+dropdown_id).val(response.spec_qry[i].SPECIFIC_VALUE);
//       }

//       for(var i = 0; i<response.mpn_qry.length; i++){
//         if(response.mpn_qry[i].DATA_TYPE == 'MPN'){
//           $('#mpn_bd').val(response.mpn_qry[i].DATA_DESC);
//         }
//       }

      
//      }
//   });
// }
/*-- End auto fill specs --*/
 </script>