<?php $this->load->view('template/header'); ?>          
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Kits Count
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Kits Count</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <!-- <div class="col-sm-12"> -->
        <!-- Start Category Mpn Object Save -->
      <!--   <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Recognize Mpn Kits</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>          
          <div class="box-body">
            <?php //if($this->session->flashdata('success')){ ?>
              <div class="alert alert-success">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Success!</strong> <?php //echo $this->session->flashdata('success'); ?>
                </div>
              <?php //}else if($this->session->flashdata('error')){  ?>
              <div class="alert alert-danger">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Error!</strong> <?php //echo $this->session->flashdata('error'); ?>
              </div>
              <?php //}else if($this->session->flashdata('warning')){  ?>
              <div class="alert alert-warning">
                  <a href="#" class="close" data-dismiss="alert">&times;</a>
                  <strong>Error!</strong> <?php //echo $this->session->flashdata('warning'); ?>
              </div>
              <?php //} ?>                     
             <div class="col-sm-12">
               <div class="col-sm-4">
              <div class="form-group">
                <label for="Conditions" class="control-label">Category:</label>
                <select name="bd_category" id="bd_category" class="form-control selectpicker" data-live-search="true" required>
                  <option value="">-------Select----------</option> -->
                  <?php                                
                     // if(!empty($getCategories)){
                     //  foreach ($getCategories as $cat){

                          ?>
                          <!-- <option value="<?php //echo $cat['CATEGORY_ID']; ?>"<?php //if($this->session->userdata('bd_recog_category') == $cat['CATEGORY_ID']){echo "selected";}?> > <?php //echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?></option> -->
                          <?php
                          //} 
                      //}
                      //$this->session->unset_userdata('bd_category'); 
                  ?>                      
               <!--  </select>  
              </div>
            </div> 
          <div class="col-sm-4 kit_mpn">
            <div class="from-group">
              <label for="Item Specific Name">MPN:</label>
              <div id="kit_mpn">   
              </div>
            </div>                           
          </div> --> 
             
          <!-- <div class="col-sm-4 kit_object">
            <div class="from-group">
              <label for="for object">Object:</label>
              <input class="form-control" name="bd_kit_object" id="bd_kit_object" value="<?php //if($this->session->userdata("bd_kit_object")){ //echo $this->session->userdata("bd_kit_object"); } ?>" readonly></input>  
            </div>                           
          </div> -->
      <!--   </div>
      </div>
    </div>
  </div> -->

      <div class="col-sm-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Parts/Kits</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
              </button>
            </div>
          </div>          
              <div class="box-body">                    
                <!-- <div class='col-sm-12'> 
                  <div class="col-sm-3">
                    <button type="button" id="add_Parts_Kits" class="btn btn-primary btn-block" >Parts/Kits</button><br> 
                    </div>
                </div> -->
                <!-- MPN Block start -->
                  <div class='col-sm-12'>
                      <div class='col-sm-3'>
                        <div class="form-group" id="bdObject">
                          <label>Object:</label>
                          <select name="bd_object" id="bd_object" class="form-control selectpicker" data-live-search="true" required> 
                              <option value="0">---</option>
                            <?php                                
                               if(!empty($getAllObjects)){
                                foreach ($getAllObjects as $object){
                                    ?>
                                    <option value="<?php echo $object['OBJECT_ID']; ?>" <?php if($this->input->post('bd_object') == $object['OBJECT_ID']){echo "selected";}?>> <?php echo $object['OBJECT_NAME']; ?>
                                    </option>
                                    <?php
                                    } 
                                }   
                            ?>                      
                          </select> 
                        </div>
                      </div>
                      <div class='col-sm-3'>
                        <div class="form-group" id="bdMPN">
                          
                            
                        </div>
                      </div>
                     
                      <div class='col-sm-3'>
                        <div class='form-group'>
                          <label>Quantity:</label>
                          <input class='form-control' type='text' name='kit_qty' id='kit_qty' value='1' placeholder='Enter Quantity'/>
                        </div>
                      </div>                                                
                      <div class="col-sm-3">
                        <div class="form-group p-t-24">
                          <input type="button" class="btn btn-success btn-sm" name="save_mpn_kit" id="save_mpn_kit" value="Save">
                        </div>
                      </div>
                      <!-- MPN Block end -->
                  </div>   

                  <!---Update MPN block -->

                <div class='col-sm-12' id="updateBlock">
                  <h3>Update Row:</h3>
                      <div class='col-sm-3'>
                        <div class="form-group">
                          <label>Component MPN:</label>
                          <input type="hidden" name="hidCatagID" id="hidCatagID">
                          <div class="col-sm-12" id="update_bd_mpn_div">
                            
                          </div>
                           
                        </div>
                      </div>
                      <div class='col-sm-3'>
                        <div class="form-group" >
                          <label>Object:</label>
                          <input type="text" class="form-control" name="update_bd_object" id="update_bd_object" value="" readonly> 
                        </div>
                      </div>
                      <div class='col-sm-3'>
                        <div class='form-group'>
                          <label>Quantity:</label>
                          <input class='form-control' type='text' name='update_qty' id='update_qty' value='1' placeholder='Enter Quantity'/>
                        </div>
                      </div>                                                
                      <div class="col-sm-3">
                        <div class="form-group p-t-24">
                          <input type="button" class="btn btn-success btn-sm" name="update_mpn_kit" id="update_mpn_kit" value="Update">
                           <input type="hidden" class="form-control" name="hidden_obj" id="hidden_obj" value="" readonly>
                        </div>
                      </div>
                      <!-- End Update MPN Block end -->
                  </div>
                <!-- END MPN Block-->
               <!-- Table Start -->
                  <div class="col-sm-12" style="margin-top: 20px;" id="kitTable">
                  
                    <?php if(!empty($getMpnObjectsResult)){ ?>
                    <div class="pull-right">
                      <a href="<?php echo base_url();?>catalogueToCash/c_kitsCount/get_altMpn" target="_blank" class="btn btn-primary">Alternate MPN List</a>
                    </div>
                  

                   
                    <table id="MpnObjectsResult" class="table table-responsive table-striped table-bordered table-hover" >
                      
                      <thead>
                        <th>Sr.#</th>
                        <th>ACTION</th>
                        <th>OBJECT</th>
                        <th>MPN</th>
                        <th>QUANTITY</th>
                        <th>ALT MPN</th> 

                      </thead>
                      <tbody>
                    <?php 
                      $i = 1;
                      foreach ($getMpnObjectsResult as $value): ?>
                      <tr> 
                        <td class="dynamic" id="dynamic<?php echo $i;?>"></td>
                        <td>
                          
                            <button type="button"  class="object_edit btn btn-xs btn-warning" id="edit<?php echo $value['MPN_KIT_MT_ID'];?>" title="Edit" ><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></button> 
                            <button type="button"  class="object_delete btn btn-xs btn-danger" id="delete<?php echo $value['MPN_KIT_MT_ID'];?>" title="Delete" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

                            <input type="hidden" name="hid_alternate_mpn" id="hid_alternate_mpn<?php echo $value['MPN_KIT_MT_ID'];?>" value="<?php echo $value['PART_CATLG_MT_ID']; ?>">
                          <div class="action  form-group" id="action<?php echo $value['MPN_KIT_MT_ID'] ;?>" style="width:100px;">
                          </div>
                        </td>
                        <td><?php echo $value['OBJECT_NAME']; ?></td>
                        <td><?php echo $value['MPN']; ?></td>  
                        <td><?php echo $value['QTY']; ?></td>
                        <td style="width: 325px;">
                          <div class="" id="" >

                            <input type="hidden" name="alternated_mpn" id="alternated_mpn<?php echo $i;?>" value="<?php echo $value['PART_CATLG_MT_ID']; ?>">
                            <input type="button" class="btn btn-primary btn-block  alternateMpn" name="alternateMPN" id="alternateMpn_<?php echo $i;?>" value="Alternate MPN">
                              <div id="part_kits_<?php echo $i;?>" class="part_kits">
                                <div class='col-sm-4' style="width: 200px;">
                                  <div class="form-group" id="appendix<?php echo $i;?>">
                                 <!--  <label>MPN:</label> -->
                                 <!--  <select name="bd_alt_mpn" style="width: 300px;" id="bd_alt_mpn" class="form-control selectpicker" data-live-search="true" required> -->
                                 <!--    <?php                                
                                      // if(!empty($getMpns)){
                                       // foreach ($getMpns as $mpn){
                                            ?>
                                            <option value="<?php //echo $mpn['CATALOGUE_MT_ID']; ?>" <?php //if($this->input->post('bd_mpn') == $mpn['CATALOGUE_MT_ID']){//echo "selected";}?>> <?php //echo $mpn['MPN'].'-'.$mpn['CATALOGUE_MT_ID']; ?></option> -->
                                            <?php
                                            //} 
                                        //}  
                                    ?>                      
                                  <!-- </select>   -->
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="from-group p-t-24">
                                  <input type="button" class="btn btn-success btn-sm" name="<?php echo $value['MPN_KIT_MT_ID']; ?>" id="save_alt_mpn" value="Save">

                                </div>
                              </div>
                            </div>                              
                          </div>
                        </td>
                      </tr>   
                    <?php 
                      $i++;
                      endforeach;
                    ?>        
                    </tbody> 
                  </table> 
                
                  <?php } ?> 
                
                </div>
              </div>
            <!-- Table End --> 
          </div>
        </div>
      </div>
    </section>
  </div>


<?php $this->load->view('template/footer'); ?>


<script>


  /*////////////////////FOR SHOWING MPNS///////////////////////////////*/
// $("#bd_category").on('change', function(){
//   var bd_category = '<?php //echo $this->uri->segment(3)?>';

//   $.ajax({
//     dataType: 'json',
//     type: 'POST',        
//     url:'<?php// echo base_url(); ?>catalogueToCash/c_kitsCount/getSpecificMpn',
//     data: {'bd_category':bd_category},
//    success: function (data) {
//     //console.log(data);
//       var specificsValues = [];
//       var session_mpn='<?php //if($this->session->userdata("bd_kit_mpn")){ echo $this->session->userdata("bd_kit_mpn"); } ?>';

//           if (session_mpn !='') { var selected='selected';
//           '<?php //echo $this->session->userdata("bd_kit_mpn");?>';}else {
//             var selected=''
//           } 
//       for (var i = 0; i < data.length; i++) {
//           specificsValues.push('<option value="'+data[i].CATALOGUE_MT_ID+'" '+selected+'>'+data[i].MPN+'</option>'); //This adds each thing we want to append to the array in order.
//       }
//       //Since we defined our variable as an array up there we join it here into a string
//       //$("#spec_name").html(specificsValues);
      
//        specificsValues.join(" ");
//       $("#kit_mpn").html("");
//       $("#kit_mpn").append('<select style="width:160px;" class="form-control specifics selectDropdown selectpicker displayCatalogueMPN" data-live-search="true"  name="bd_kit_mpn" id="bd_kit_mpn"><option value="">-------Select----------</option>'+specificsValues.join(" ")+'</select>');
//       $('.selectDropdown').selectpicker();
//    }
//   }); 
//  });
/////////////////////////////////////////////////////
var bd_category = '<?php echo $this->uri->segment(4)?>';

var bd_kit_mpn = '<?php echo $this->uri->segment(5)?>';
$(document).ready(function(){
  $('.part_kits').hide();
  $('#updateBlock').hide();
  // var bd_category = $("#bd_category").val();

  if(bd_category != ''){
        $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/getSpecificMpn',
        data: {'bd_category':bd_category},
       success: function (data) {
        //console.log(data);
          var specificsValues = [];
          // var session_mpn ='<?php //if($this->session->userdata("bd_kit_mpn")){ echo $this->session->userdata("bd_kit_mpn"); } ?>';
          // alert(session_mpn);
              // if (session_mpn !='') { var selected='selected'}else {
              //   var selected=''
              // } 
          for (var i = 0; i < data.length; i++) {
              specificsValues.push('<option value="'+data[i].CATALOGUE_MT_ID+'" '+selected+'>'+data[i].MPN+'</option>'); //This adds each thing we want to append to the array in order.
          }
          //Since we defined our variable as an array up there we join it here into a string
          //$("#spec_name").html(specificsValues);
          
           specificsValues.join(" ");
          $("#kit_mpn").html("");
          $("#kit_mpn").append('<select style="width:160px;" class="form-control specifics selectDropdown selectpicker displayCatalogueMPN" data-live-search="true"  name="bd_kit_mpn" id="bd_kit_mpn"><option value="">-------Select----------</option>'+specificsValues.join(" ")+'</select>');
          $('.selectDropdown').selectpicker();
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


/*===============================================
=            Edit BY YOusaf 9/6/2017            =
===============================================*/

$("#save_mpn_kit").on('click', function(){
    var url='<?php echo base_url() ?>catalogueToCash/c_kitsCount/saveMpnKit';
    // var bd_kit_mpn= $("#bd_kit_mpn").val();
    var bd_object = $("#bd_object").val();
    var bd_mpn = $("#bd_mpn").val();
    var kit_qty = $("#kit_qty").val();

    // '<?php //echo $this->session->set_userdata("bd_kit_mpn");?>';
    // alert(bd_object); return false;
    if (bd_kit_mpn.length==0) {
      alert("First select recognize mpn");
      return false;
    }else if(bd_object == 0 ){
      alert("First select object");
      return false;
    }else{
      // alert(bd_mpn);return false;
      $.ajax({
      url:url,
      type: 'POST',
      data: {
        'bd_object': bd_object,
        'bd_kit_mpn': bd_kit_mpn,
        'bd_mpn': bd_mpn,
        'kit_qty' : kit_qty
      },
      dataType: 'json',
      success: function (data){
        if(data == 1){
          alert("data is inserted");
        }else if(data=0){
          alert("data is not inserted! Try Again");
        }else if(data= "exist"){
          alert("Data already exist");
        }    
        // var i =5;


        var j = 1;
        $.ajax({
          url:'<?php echo base_url() ?>catalogueToCash/c_kitsCount/getMpnObjectsResult',
          type: 'POST',
          dataType: 'json',
          data: {'bd_kit_mpn':bd_kit_mpn},
          success: function(result){
          
            // alert(result);return false;
              console.log(result);
              var mpnResult = [];

              for(var i = 0;i<result.length;i++){
                mpnResult.push('<tr> <td class="dynamic" id="dynamic'+i+'"></td><td><button type="button"  class="object_edit btn btn-xs btn-warning" id="edit'+result[i].MPN_KIT_MT_ID+'" title="Edit" ><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></button> <button type="button"  class="object_delete btn btn-xs btn-danger" id="delete'+result[i].MPN_KIT_MT_ID+'" title="Delete" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><input type="hidden" name="hid_alternate_mpn" id="hid_alternate_mpn'+result[i].MPN_KIT_MT_ID+'" value="'+result[i].PART_CATLG_MT_ID+'"><div class="action" id="action'+result[i].MPN_KIT_MT_ID+'"> </div></td><td>'+result[i].OBJECT_NAME+'<div class="objName" id="objName'+result[i].MPN_KIT_MT_ID+'"></div></td> <td>'+result[i].MPN+'</td> <td>'+result[i].QTY+'<div class="quantities" id="quantities'+result[i].MPN_KIT_MT_ID+'"></div></td><td style="width: 325px;"> <div class="" id=""> <input type="hidden" name="alternated_mpn" id="alternated_mpn'+j+'" value="'+result[i].PART_CATLG_MT_ID+'"> <input type="button" class="btn btn-primary btn-block btn-sm alternateMpn" name="alternateMPN" id="alternateMpn_'+j+'" value="Alternate MPN"> <div id="part_kits_'+j+'" class="part_kits"> <div class="col-sm-4" style="width: 200px;"> <div class="form-group" id="appendix'+j+'"></div> </div> <div class="col-sm-4"> <div class="from-group p-t-24"> <input type="button" class="btn btn-success btn-sm" name="'+result[i].MPN_KIT_MT_ID+'" id="save_alt_mpn" value="Save"> </div> </div> </div> </div> </td></tr>'); 
                  j++;
              }
              
              $('#kitTable').html("");
              $('#kitTable').append('<div class="col-sm-12 "><div class="col-sm-2 pull-right"><a href="<?php echo base_url();?>catalogueToCash/c_kitsCount/get_altMpn" target="_blank" class="btn btn-primary">Alternate MPN List</a></div></div><div class="col-sm-12" ><table id="MpnObjectsResult" class="table table-responsive table-striped table-bordered table-hover" > <thead> <th>Sr.#</th> <th>ACTION</th> <th>OBJECT</th> <th>MPN</th> <th>QUANTITY</th> <th>ALT MPN</th> </thead> <tbody>'+mpnResult.join("")+'</tbody></table></div>'); 

              $('.dynamic').each(function(idx, elem){

                  $(elem).text(idx+1);
                
              });
              $('.part_kits').hide();
           },
            error: function(jqXHR, textStatus, errorThrown){
               $(".loader").hide();
              if (jqXHR.status){
                alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
              }
          }
        });
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




$(document).on('click','.object_delete',function(){
    var mpn_kit_id = this.id.match(/\d+/);
    mpn_kit_id = parseInt(mpn_kit_id);
    // alert(mpn_kit_id);return false;
    var i = 1;
    if(confirm('Are you sure you want to delete?')){
    $.ajax({
      url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/deleteMpnObjectResults',
      dataType : 'json',
      type : 'post',
      data:{'mpn_kit_id':mpn_kit_id},
      success : function(data){
        if(data == 1){
          alert("deleted Successfully!");
        }else{
          alert("Not deleted! Try again");
        }

        var j = 1;
        $.ajax({
          url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/getMpnObjectsResult',
          dataType : 'json',
          type : 'post',
          success: function(result){
             $('#MpnObjectsResult tbody').html("");

            // console.log(result);

            for(var i = 0;i<result.length;i++){
              $('#MpnObjectsResult tbody').append('<tr> <td class="dynamic" id="dynamic'+i+'"></td><td><button type="button"  class="object_edit btn btn-xs btn-warning" id="edit'+result[i].MPN_KIT_MT_ID+'" title="Edit" ><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></button> <button type="button"  class="object_delete btn btn-xs btn-danger" id="delete'+result[i].MPN_KIT_MT_ID+'" title="Delete" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><input type="hidden" name="hid_alternate_mpn" id="hid_alternate_mpn'+result[i].MPN_KIT_MT_ID+'" value="'+result[i].PART_CATLG_MT_ID+'"><div class="action" id="action'+result[i].MPN_KIT_MT_ID+'"> </div></td><td>'+result[i].OBJECT_NAME+'<div class="objName" id="objName'+result[i].MPN_KIT_MT_ID+'"></div></td> <td>'+result[i].MPN+'</td> <td>'+result[i].QTY+'<div class="quantities" id="quantities'+result[i].MPN_KIT_MT_ID+'"></div></td><td style="width: 325px;"> <div class="" id=""> <input type="hidden" name="alternated_mpn" id="alternated_mpn'+j+'" value="'+result[i].PART_CATLG_MT_ID+'"> <input type="button" class="btn btn-primary btn-block btn-sm alternateMpn" name="alternateMPN" id="alternateMpn_'+j+'" value="Alternate MPN"> <div id="part_kits_'+j+'" class="part_kits"> <div class="col-sm-4" style="width: 200px;"> <div class="form-group" id="appendix'+j+'"></div> </div> <div class="col-sm-4"> <div class="from-group p-t-24"> <input type="button" class="btn btn-success btn-sm" name="'+result[i].MPN_KIT_MT_ID+'" id="save_alt_mpn" value="Save"> </div> </div> </div> </div> </td></tr>'); 
                j++;
            }
                          
            $('.dynamic').each(function(idx, elem){

                $(elem).text(idx+1);
              
            });
                      
                               
          },
          error: function(jqXHR, textStatus, errorThrown){
             $(".loader").hide();
            if (jqXHR.status){
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
        }

          
        });
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
     
     });
    }
    // alert($id);

    // $('.dynamic').each(function(idx, elem){
    //       $(elem).val(idx+1);
    //       // console.log($(elem).val(idx+1));
    //     });
  });

$('.dynamic').each(function(idx, elem){

    $(elem).text(idx+1);
  
});



$(document).on('click','.object_edit ',function(){
  var index = this.id.match(/\d+/);
  var bd_category = $('#bd_category').val();
  $('#hidden_obj').val(index);

  var selected = $('#hid_alternate_mpn'+index+'').val();
   
  $.ajax({
      url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/getMpnsEdit',
      dataType : 'json',
      type : 'post',
      success : function(data){
       // console.log(data[0].CATALOGUE_MT_ID);
       var catalogue_id = [];
      $('#updateBlock').show();
       for(var i=0;i<data.length;i++){
     
        catalogue_id.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>');
       }
       $("#update_bd_mpn_div").html("");
       $('#update_bd_mpn_div').append('<select name="update_bd_mpn" id="update_bd_mpn" class="form-control DropDown" data-live-search="true">'+catalogue_id+'</select>');
       $('select[id=update_bd_mpn]').val(selected);
       $('.DropDown').selectpicker();

     }
  });

  

});

$(document).on('change','#update_bd_mpn',function(){

      var bd_mpn = $("#update_bd_mpn").val();
      // alert(bd_mpn);return false;

      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/getMpnObjects',
        data: {'bd_mpn' : bd_mpn},
       success: function (data) {
        //console.log(data);
        $("#update_bd_object").val(data[0].OBJECT_NAME);

        },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

      });
});

$("#update_mpn_kit").click(function(){
  var part_cata_id = $('#update_bd_mpn').val();
  // alert(catalogue_id);
  var mpn_kit_id = $('#hidden_obj').val();
  var mpn_qty = $('#update_qty').val();

  $.ajax({
     dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/updateMPN',
      data: {'part_cata_id' : part_cata_id,'mpn_kit_id':mpn_kit_id,'mpn_qty':mpn_qty},
      success: function (data) {
            //console.log(data);
        if(data == 1){
          alert('updated Successfully!');
        }else{
          alert('not updated, Try again');
        }

        var j = 1;
         $.ajax({
          url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/getMpnObjectsResult',
          dataType : 'json',
          type : 'post',
          success: function(result){
             $('#MpnObjectsResult tbody').html("");

            for(var i = 0;i<result.length;i++){
              $('#MpnObjectsResult tbody').append('<tr> <td class="dynamic" id="dynamic'+i+'"></td><td><button type="button"  class="object_edit btn btn-xs btn-warning" id="edit'+result[i].MPN_KIT_MT_ID+'" title="Edit" ><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span></button> <button type="button"  class="object_delete btn btn-xs btn-danger" id="delete'+result[i].MPN_KIT_MT_ID+'" title="Delete" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><input type="hidden" name="hid_alternate_mpn" id="hid_alternate_mpn'+result[i].MPN_KIT_MT_ID+'" value="'+result[i].PART_CATLG_MT_ID+'"><div class="action" id="action'+result[i].MPN_KIT_MT_ID+'"> </div></td><td>'+result[i].OBJECT_NAME+'<div class="objName" id="objName'+result[i].MPN_KIT_MT_ID+'"></div></td> <td>'+result[i].MPN+'</td> <td>'+result[i].QTY+'<div class="quantities" id="quantities'+result[i].MPN_KIT_MT_ID+'"></div></td><td style="width: 325px;"> <div class="" id=""> <input type="hidden" name="alternated_mpn" id="alternated_mpn'+j+'" value="'+result[i].PART_CATLG_MT_ID+'"> <input type="button" class="btn btn-primary btn-block btn-sm alternateMpn" name="alternateMPN" id="alternateMpn_'+j+'" value="Alternate MPN"> <div id="part_kits_'+j+'" class="part_kits"> <div class="col-sm-4" style="width: 200px;"> <div class="form-group" id="appendix'+j+'"></div> </div> <div class="col-sm-4"> <div class="from-group p-t-24"> <input type="button" class="btn btn-success btn-sm" name="'+result[i].MPN_KIT_MT_ID+'" id="save_alt_mpn" value="Save"> </div> </div> </div> </div> </td></tr>'); 
                j++;
            }                
            $('.dynamic').each(function(idx, elem){
                $(elem).text(idx+1); 
            });         

            $('#updateBlock').hide();              
          },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
        });
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });

});


$('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_kitsCount/loadBdMpn',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id},
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
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});


  $(document).on('click', "a.showMpn", function(){
       
    var $id = this.id.match(/\d+/);
    $id = parseInt($id);
     // alert($id);return false;
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>catalogue/c_itemCatalogue/showCatalogueDetail',
        data: { '$id' : $id},
        success: function(data){
          

            var myWindow = window.open("", "MsgWindow", "width=800,height=600");

            myWindow.document.write('<html><head><title>Laptopzone | Catalogue Details</title><link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>"><link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>"><link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css');?>"></head><body> <div class="col-sm-12" id="tableData"></div>');
      
        // var data = $('#tableData').append('<div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+data.catalogue_data[0].MPN+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE: '+data.catalogue_data[0].INSERT_DATE+'</h4></div>');
        var catalogue_data = []; // to save Specific_Name and Specific_Value
        var groupedCatalogue = [];// to add rowspan according to group value
        var catalogueJoin = [];// for combined value of catalogue_data and groupedCatalogue
        
        for(var j= 0;j<data.groupCount.length; j++){

          groupedCatalogue.push('<tr><td rowspan="'+data.groupCount[j].ROW_SPAN+'">'+data.groupCount[j].CATALOGUE_GROUP_VALUE+'</td>');
            for (var i = 0; i < data.catalogue_data.length; i++) {
                if(data.catalogue_data[i].CATALOGUE_GROUP_ID == data.groupCount[j].CATALOGUE_GROUP_ID){
                  // if group_id is same then all value in same row
                  catalogue_data.push('<td>'+data.catalogue_data[i].SPECIFIC_NAME+'</td><td>'+data.catalogue_data[i].SPECIFIC_VALUE+'</td></tr>'); 
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
       

       myWindow.document.write('<div class="col-sm-12" id="tableData"><div class="col-sm-4"><h4 style="font-weight: bold;">MPN: '+data.catalogue_data[0].MPN+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">INSERTED DATE: '+data.catalogue_data[0].INSERT_DATE+'</h4></div><div class="col-sm-4"><h4 style="font-weight: bold;">OBJECT NAME :  '+data.catalogue_data[0].OBJECT_NAME+'</h4></div></div><table class="table table-bordered table-striped table-responsive table-hover" id="catalogue_data"><thead> <th> Group Value</th> <th>Specific Name</th> <th>Specific Value</th></thead><tbody>'+catalogueJoin.join("")+'</tbody></table>'); 

       
        myWindow.document.write('</div></div></div><div class="row"><div class="col-sm-12"><div class="box"><div class="box-header with-border" style="background-color: #3c8dbc !important;color:#fff !important;"><strong style="margin-left:12px;">Copyright &copy; <?php //echo date('Y'); ?> <a href="#" style="color:#fff !important;">Laptop Zone</a>.</strong> All rights reserved.</div></div></div></div></body></html>');
          
        },
        error: function(jqXHR, textStatus, errorThrown){
           $(".loader").hide();
          if (jqXHR.status){
            alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          }
      }
      });
  });


$(document).on("click",".alternateMpn", function(){
    var id = this.id.match(/\d+/);
    id = parseInt(id);
    // alert(id);return false;
    // $('.part_kits').hide();
    $("#part_kits_"+id+"").toggle();      

    var alternated_mpn = $("#alternated_mpn"+id+"").val();
    var bd_category = $("#bd_category").val();
          // alert(bd_category);return false;
    $.ajax({
      url: "<?php echo base_url() ?>catalogueToCash/c_kitsCount/getAlternateMpn",
      type: "post",
      dataType: "json",
      data : {'bd_category':bd_category,'alternated_mpn':alternated_mpn},
      success : function(data){
        if(data){
          //console.log(data[0].CATALOGUE_MT_ID);
          var object = "";
          var object = [];
          for(var j=0; j< data.length; j++){
          // if(data.get_objects[j].OBJECT_NAME){
          //   object.push('<option value="'+data.get_objects[j].OBJECT_NAME+'">'+data.get_objects[j].OBJECT_NAME+'</option>'); //This adds each thing we want to append to the array in order.
          // }                
          // object.join(" ");
          object.push('<option value="'+data[j].CATALOGUE_MT_ID+'">'+data[j].MPN+'</option>');
          }
          /*=====  End For Object name and value  ======*/   
          for(var i = 1;i<data.length;i++){
          $("#appendix"+i+"").html("");
          $("#appendix"+i+"").append('<label>ALTERNATE MPN:</label><select style="width:160px;" class="form-control brandSelection" data-live-search="true" id="bd_alt_mpn" name="bd_alt_mpn">'+object.join("")+'</select> ');
          $('.brandSelection').selectpicker();
          }  
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
/*=====  End of Edit BY YOusaf 9/6/2017  ======*/

</script>