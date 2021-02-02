<?php 
ini_set('memory_limit', '-1');
$this->load->view('template/header');
 ?>

<style>
  #part_kits{display:none;}
  .part_kits{display:none;}
  #alter_mpn{display:none;}
/*    .example-modal .modal {
      position: absolute !important;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }*/
    #modal_form{display: none;}  
 
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Recognize Mpn
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Recognize Mpn</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
        <!-- Title filtering section start -->
          <div class="box collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Title Expression</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
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
                      <?php } ?>                     
                     <div class="col-sm-12">
                       <div class="col-sm-4">
                        <div class="form-group">
                          <label for="Conditions" class="control-label">Category:</label>
                          <select name="fltr_bd_category" id="fltr_bd_category" class="form-control selectpicker" data-live-search="true" required>
                            <option value="">-------Select----------</option>
                            <?php                                
                               if(!empty($getCategories)){
                                foreach ($getCategories as $cat){

                                    ?>
                                    <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_recog_category') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?></option>
                                    <?php
                                    } 
                                }
                                //$this->session->unset_userdata('bd_category'); 
                            ?>                      
                          </select>  
                        </div>
                       </div>
                       <div class="col-sm-4 kit_mpn">
                      <div class="from-group">
                        <label for="Item Specific Name">Expression:</label>
                        <div id="title_expression">   
                        </div>
                      </div>                           
                    </div>
                       <div class="col-sm-4">
                         <div class="form-group">
                          <label>Expresion Name:</label>
                          <input type="text" class="form-control" name="exp_name" id="exp_name" value="">
                           
                         </div>
                       </div> 
                   
                     </div>
                    
                    <!-- First form -->
                    <div class="col-sm-12">
                    <!-- <form action="<?php //echo base_url(); ?>bigData/c_recog_title_mpn_kits/showMainExpDetail" method="post" accept-charset="utf-8"> -->
                      <div class="col-sm-9">
                        <div class="form-group">
                          <label for="">Title Expresion:</label>
                          <input type="text" class="form-control" name="fltr_exp" id="fltr_exp" placeholder="TITLE LIKE '%PROBOOK%'" value="<?php if(isset($_POST['fltr_exp'])){ echo trim($_POST['fltr_exp']); } ?>" >
                        </div>
                    </div>
                    <div class="col-sm-1 p-t-24">
                      <input type="submit" id="fltr_exp_rslt" class="btn btn-primary btn-sm" value="Result">
                    </div>
                    <!-- </form> -->
                       
                    <div class="col-sm-1 p-t-24">
                      <div class="form-group">
                        <input type="submit" class="btn btn-success btn-sm pull-right" name="fltr_exp_save" id="fltr_exp_save" value="Save">
                      </div>
                    </div>
                 
                    </div>

                  <div class="col-sm-12" style="margin-top: 20px;">
                   <div id="display_auto_expresions">
                
                   </div> 
                  </div>
                </div>
            </div>
       <!-- Title filtering section End -->


        <!-- Add Title Expression Start  -->
          <div class="box collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Word Expression</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
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
                      <?php } ?>                     
                     <div class="col-sm-12">
                       <div class="col-sm-4">
                        <div class="form-group">
                          <label for="Conditions" class="control-label">Category:</label>
                          <select name="bd_category" id="bd_category" class="form-control selectpicker" data-live-search="true" required>
                            <option value="">-------Select----------</option>
                            <?php                                
                               if(!empty($getCategories)){
                                foreach ($getCategories as $cat){
                                    ?>
                                    <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('bd_recog_category') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?></option>
                                    <?php
                                    } 
                                }
                            ?>                      
                          </select>  
                        </div>
                       </div> 

                       <div class="col-sm-4">
                         <div class="form-group">
                          <label>Expresion Name:</label>
                          <input type="text" class="form-control" name="word_exp_name" id="word_exp_name" value="">
                           
                         </div>
                       </div>                     
                     </div>
                    <!-- First form -->
                    <div class="col-sm-12">
                    <!-- <form action="<?php //echo base_url(); ?>bigData/c_recog_title_mpn_kits/showMainExpDetail" method="post" accept-charset="utf-8"> -->
                      <div class="col-sm-9">
                        <div class="form-group">
                          <label for="">Word Expresion:</label>
                          <input type="text" class="form-control" name="word_exp" id="word_exp" placeholder="TITLE LIKE '%PROBOOK%'" value="<?php if(isset($_POST['word_exp'])){ echo trim($_POST['word_exp']); } ?>" >
                        </div>
                    </div>
                    <div class="col-sm-1 p-t-24">
                        <input type="submit" id="result_word_exp" class="btn btn-primary btn-sm" value="Result">
                      </div>
                    <!-- </form> -->
                       
                    <div class="col-sm-1 p-t-24">
                      <div class="form-group">
                        <input type="submit" class="btn btn-success btn-sm pull-right" name="save_word_exp" id="save_word_exp" value="Save">
                      </div>
                    </div>
                      <div class="col-sm-1 p-t-24">
                        <div class="form-group">
                          <input type="button" class="btn btn-warning btn-sm" name="expressionHint" title="How to add Expression?" id="expressionHint" value="Hint!">
                        </div>
                      </div>                     
                    </div>
                    <!--  <div class="col-sm-12">  
                      <div class="col-sm-1">
                        <button type="button" id="result_all" class="btn btn-primary btn-sm" >Result All</button>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" id="check_all" class="btn btn-primary btn-sm" >Check All</button>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" id="copy_form" class="btn btn-primary btn-sm" >Copy From</button>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" id="copy_to" class="btn btn-primary btn-sm" >Copy To(s)</button>
                      </div>
                    </div> -->
                    <!-- Catalogue Group Detail against MPN start -->
                    <div class="col-sm-12" style="margin-top: 20px;">
                      <div id="displayCatalogue">
                        
                      </div>
                    </div>
                    <!-- Catalogue Group Detail against MPN end -->
               
                </div>
            </div>
       <!-- Add Title Expression Start End -->

          <!-- Result Block start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Result</h3>

              <div class="box-tools pull-right">
                <?php if (!empty($results['exp_result'])) { ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <?php }else{ ?>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                <?php }?>
              </div>
            </div>          
            <div class="box-body form-scroll">
             <div class="col-sm-12">
               <div class="col-sm-4">
                <div class="form-group">
                  <label for="Conditions" class="control-label">Category:</label>
                  <select name="bd_rslt_category" id="bd_rslt_category" class="form-control selectpicker" data-live-search="true" required>
                    <option value="">-------Select----------</option>
                    <?php                                
                       if(!empty($getCategories)){
                        foreach ($getCategories as $cat){
                            ?>
                            <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('auto_mpn_save_cat') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?></option>
                            <?php
                            } 
                        }
                        //$this->session->unset_userdata('bd_rslt_category'); 
                    ?>                      
                  </select>  
                </div>
               </div> 
               <div class="col-sm-4">
                  <div class="form-group">
                    <label for="">Input Category:</label>
                    <input type="text" class="form-control" name="create_cat" id="create_cat" placeholder="Enter category ID" value="<?php if($this->session->userdata('auto_mpn_save_cat')){echo $this->session->userdata('auto_mpn_save_cat'); }?>" >
                  </div>
              </div>                   
             </div>
               <div class="col-sm-12">
                <div class="form-group col-sm-2 pull-left">
                  <button type="button" title="Add Mpn"  class="btn btn-primary add_mpn" id="add_mpn" style="margin-top: 24px;">Add Mpn</button>
                </div>
                <div class="col-sm-3 col-sm-offset-2">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Word Type:</label>
                    <select name="junk_word" id="junk_word" class="form-control" required>
                      <?php                                
                         if(!empty($words)){
                          foreach ($words as $word){
                              ?>
                              <option value="<?php echo $word['GEN_MT_ID']; ?>" <?php if ( $word['GEN_MT_ID'] == 4) { echo "selected"; } ?>> <?php echo $word['SET_DESCRIPTION']; ?></option>
                              <?php
                              } 
                          } 
                      ?>                      
                    </select>  
                  </div>
                </div>
                <div class="form-group col-sm-1 pull-left">
                  <button type="button" title="Add Junk"  class="btn btn-success add_junk" id="add_junk" style="margin-top: 24px;">Add Junk</button>
                </div>
                </div>
              <div class="col-sm-12">    
                <table id="result_table" class="table table-responsive table-striped table-bordered table-hover" > 
                  <thead>
                      <th>ACTION</th>
                      <th>SELECT</th>
                      <th>WORD/MPN</th> 
                      <th>ALTERNATE MPN</th> 
                      <th>COUNT</th> 
                      <th>%</th>  
                      <th>OBJECT</th> 
                      <th>MPN DESCRIPTION</th> 
                      <th>VIEW TITLE</th> 
                      <th>AUTO CATALOGUE </th>  
                  </thead>
                 <tbody>
                    <?php 
                      $i = 1; 
                       $total_rows = $results['count'];
                      if(!empty($results['rows'])){
                        foreach($results['rows'] as $result){
                         ?>

                          <tr id="<?php echo $i; ?>">
                            <td>
                              <button type="button"  class="mpn_delete btn btn-xs btn-danger" rd="<?php echo @$result['WORDS'];?>" id="<?php echo $i; ?>" title="Delete MPN" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                            </td>
                            <td ><div class="form-group" >
                                <input type="checkbox" name="select_mpn" id="select_mpn_<?php echo $i; ?>" class="select_mpn" value="<?php echo $i; ?>">
                              </div>
                            </td>
                            <input type="hidden" name="result_word" id="result_word_<?php echo $i; ?>" value="<?php echo @$result['WORDS']; ?>">
                            <td id="word_<?php echo $i;?>">
                                <?php echo @$result['WORDS']; ?>
                                
                            </td>
                            <td>
                              <div class="form-group">
                                <input type="text" name="alternate_mpn" class="form-control alternate_mpn" id="alternate_mpn_<?php echo $i; ?>" value="" style="width: 130px;">
                              </div>
                            </td>
                            <td><?php echo $word_count = $result['WORD_COUNT']; ?></td>  
                            <td>
                              <div style="width: 60px;">
                                 <?php if(!empty($total_rows) && !empty($word_count)){
                              $percent = ($word_count/$total_rows) * 100;
                               echo number_format((float)@$percent,2,'.',',')." %";
                            } ?>
                              </div>
                            </td>
                            <td>
                              <div class="col-sm-2">
                                 <div class="form-group" style="width: 200px;">
                                  <select name="bd_rslt_object" id="bd_rslt_object" class="form-control selectpicker rslt_object" data-live-search="true" required>
                                    <option value="" style="width: 180px;">----Select----</option>
                                    <?php                                
                                       if(!empty($objects)){
                                        foreach ($objects as $obj){
                                            ?>
                                            <option value="<?php echo $obj['OBJECT_ID']; ?>" style="width: 180px;"> <?php echo $obj['OBJECT_NAME']; ?></option>
                                            <?php
                                            } 
                                       }
                                        //$this->session->unset_userdata('bd_rslt_object'); 
                                    ?>                      
                                  </select>  
                                  </div>
                            </div>
                            </td>  
                            <td>
                              <div class="form-group">
                                <input type="text" name="mpn_desc" class="form-control mpn_desc" id="mpn_desc_<?php echo $i; ?>" style="width: 300px;">
                              </div>
                              <div class="apnd_table" id="apnd_table_<?php echo $i; ?>" style="margin-top: 10px!important;">
                                
                              </div>
                            </td>
                            <td>
                              <div class="form-group">
                                <button class="btn btn-primary btn-sm result_title" id="result_title_<?php echo $i; ?>" rowid="<?php echo $i; ?>">View Title</button>
                              </div>
                              <div class="auto_table" id="auto_table_<?php echo $i; ?>" style="margin-top: 10px!important;">
                            </td>
                            <td>
                              <div class="form-group">
                                <a class="btn btn-success btn-sm auto_catalogue"  id="auto_catalogue_<?php echo $i; ?>">Auto Catalogue</a>
                              </div>
                            </td> 
                            <?php
                              $i++;
                              echo "</tr>"; 
                              } 
                              ?>
                               </tbody>
                             </table>
                            <?php } else {
                              ?>
                              </tbody>
                             </table>
                              <?php
                            }
                            ?>
              </div>
                <div class="col-sm-12">
                <div class="form-group col-sm-2 pull-left">
                  <button type="button" title="Add Mpn"  class="btn btn-primary add_mpn" id="add_mpn" style="margin-top: 24px;">Add Mpn</button>
                </div>
                <div class="col-sm-3 col-sm-offset-2">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Word Type:</label>
                    <select name="junk_word" id="junk_word" class="form-control" required>
                      <?php                                
                         if(!empty($words)){
                          foreach ($words as $word){
                              ?>
                              <option value="<?php echo $word['GEN_MT_ID']; ?>" <?php if ( $word['GEN_MT_ID'] == 4) { echo "selected"; } ?>> <?php echo $word['SET_DESCRIPTION']; ?></option>
                              <?php
                              } 
                          } 
                      ?>                      
                    </select>  
                  </div>
                </div>
                <div class="form-group col-sm-1 pull-left">
                  <button type="button" title="Add Junk"  class="btn btn-success add_junk" id="add_junk" style="margin-top: 24px;">Add Junk</button>
                </div>
                </div>
                <div id="display_titles">
                
              </div> 
            </div>
          <!-- Result Block end -->    
            
       <!-- summary Block start -->
        </div>
    
       <!-- End Category Mpn Object Save -->
        
        <!-- /.col -->
         
      </div>
      <!-- /.row -->


      <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">How to add Expression?</h4>
              </div>
                
              <div class="modal-body">
                <ol>
                  <li>For Part No add <b>AND TITLE LIKE '%MD101LL/A%'</b></li>
                  <li>For Multiple condition add expression as <b>AND TITLE LIKE '%A1278%' AND TITLE LIKE '%2012%'</b></li>
                  <li>For OR Condition <b>AND TITLE LIKE '%A1278%' OR TITLE LIKE '%2012%'</b></li>
                  <li>For NOT LIKE Condition <b>AND TITLE LIKE '%A1278%' AND TITLE LIKE '%2012%' AND TITLE NOT LIKE '%MD101LL/A%'</b></li>
                </ol>
              </div>
               
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              <!-- <button type="button" class="btn btn-outline">Save changes</button> -->
              </div>
            </div>
        </div>     
      </div><!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>  
  <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
    <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
  </div>  
<!-- End Listing Form Data -->


 <?php $this->load->view('template/footer'); ?>


 <script>
 /*-- Hint Expression pop-up modal start--*/
 $("#expressionHint").click(function() {
   /* Act on the event */
   $('#modal_form').modal('show');

 });
/*-- Hint Expression pop-up modal end--*/
/*-- Delete Result Row start --*/
 $("#exp_table").on('click','.delResultRow', function() {
    //alert(this.id);//return false;
    var id = this.id;
    var bd_category = $("#bd_category").val();
    $.ajax({
        url: '<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/deleteResultRow/'+id, //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data : {'bd_category':bd_category},
        success: function(data){
            if(data == true){
              var row=$("#"+id);
              //debugger;     
              row.fadeOut(1000, function() {
              row.remove();
              });
             //$('#'+id).remove();
            }
        },
        error: function(data){
           alert('Not Deleted');
        }
    });    
 });
/*-- Delete Result Row end --*/

$(document).on("click",".alternateMpn", function(){
    var id = this.id.match(/\d+/);
    id = parseInt(id);
    // alert(id);return false;
    $("#part_kits_"+id+"").toggle();      

    var alternated_mpn = $("#alternated_mpn"+id+"").val();
    var bd_category = $("#bd_category").val();
          // alert(bd_category);return false;
    $.ajax({
      url: "<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/getAlternateMpn",
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
      }
    });
  });
$(document).on("click","#save_alt_mpn",function(){
    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/saveAlternateMpn';
    // var bd_alt_object = $("#bd_alt_object").val();
    var bd_alt_mpn = $("#bd_alt_mpn").val();
    var mpn_kit_mt_id = $(this).attr('name');
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'bd_alt_mpn': bd_alt_mpn,
      'mpn_kit_mt_id' : mpn_kit_mt_id
    },
    dataType: 'json',
    success: function (data){
      if(data == 1){
        alert("data is inserted");
      }
      else{
        alert("data is not inserted! Try Again");
      }    
    }
  });
});

//////////////////FOR SAVE KIT MPN///////////////////////
$(document).ready(function(){
 
  ////////////////////////////////////////
  $('#result_table').DataTable({
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
  //////////////////////////////////////
$('#MpnObjectsResult').DataTable({
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

$("#bd_rslt_category").on('change', function(event) {
  event.preventDefault();
  /* Act on the event */
  var cat_id = $(this).val();
  $("#create_cat").val(cat_id);
   $.ajax({
              type: 'POST',
              dataType: 'json',
              url:'<?php echo base_url(); ?>bigData/c_autoCatalog/saveCatInSession',
              data:{ 
                    'cat_id' : cat_id
                    },
             success: function (data) {
              //alert(data.length > 0); return false;
                   
        } //success 
      }); ///ajax call
});
////////////////////FOR DELETEING MPN ///////////////////////////////
$(".mpn_delete").on('click', function(event) {
  event.preventDefault();
  /* Act on the event */
  var  rowId = $(this).attr("id");
  var  mpn_word = $(this).attr("rd");
  //console.log(mpn_word, rowId); return false;
  $(".loader").show();
   $.ajax({
              type: 'POST',
              dataType: 'json',
              url:'<?php echo base_url(); ?>bigData/c_autoCatalog/delete_auto_mpn',
              data:{ 
                    'mpn_word' : mpn_word
                    },
             success: function (data) {
              if(data == true){
              var row=$("#"+rowId);
              //debugger;     
              row.closest('tr').fadeOut(1000, function() {
              row.closest('tr').remove();
              });
             //$('#'+id).remove();
            }else if(data == false){
              alert("Error: Failed to delete the row");
            }
                   
            }, //success
           complete: function(data){
          $(".loader").hide();
        } 
      }); ///ajax call
});
  /*-- Suggest Categories against title on single entry--*/
   $(document).on('click', ".result_title",  function(){
      var row_num = $(this).attr("rowid");
      var rowId = $(this).attr("id");
      //console.log(row_num, rowId); 
      var result_cat  = $("#create_cat").val();
      var result_word  = $("#result_word_"+row_num).val();
      $("body #select_mpn_"+row_num).prop('checked', true);
      //console.log($("body #select_mpn_"+row_num).attr('checked','checked')); 
      //alert(TITLE); return false;
      if (result_cat.length == 0) {
        alert("Warning: Category is required!");
        $("#create_cat").focus();
        return false;
      }else {
        $(".loader").show();
          $.ajax({
              type: 'POST',
              dataType: 'json',
              url:'<?php echo base_url(); ?>bigData/c_autoCatalog/getTitles',
              data:{ 
                    'result_cat' : result_cat,
                    'result_word' : result_word
                    },
             success: function (data) {
              $(".loader").hide();
              //console.log(data); return false;
              //alert(data.length > 0); return false;
                   if (data.length > 0) {
                      var row = [];  
                        for(var k = 0; k< data.length; k++){
                            row.push('<tr id="'+(k + 1)+'" style="width:100%;" ><td><div class="form-group"> <button type="button" id="'+(k + 1)+'" class="btn btn-primary btn-xs select_title">select</button></div></td><td><div  style="width:200px;">'+data[k].TITLE+'</div></td></tr>');
                             ////This adds each thing we want to append to the array in order. }
                           }
                            $('#table_main_id').html('').remove();
                            $('#result_table tr #apnd_table_'+row_num).append('<div id="table_main_id" ><input type="hidden" value="'+row_num+'" id="appended_title"><table id="titles_table" tabindex="-1" class="table table-responsive table-striped table-bordered table-hover" ><thead><th>SELECT</th><th>TITLE</th></thead><tbody>'+row.join("")+'</tbody></table></div>');

                              $("#titles_table").attr("tabindex",-1).focus();     
                 
            }else {
              alert("No data found");
              return false;
            }
           
            
        } 
      }); ///ajax call
    }////main esle
 }); ///function end
/*-- End Suggest Cotegories against title on single entry --*/
$(document).on('click', '.select_title', function() {
  //event.preventDefault();
  /* Act on the event */
  //var bd_title  = $(this).attr("id").replace( 'nnn', '"').replace( "mmm", "'");

  var row_id  = $(this).attr("id");
  console.log(row_id); 
  var tableId="titles_table";
  var tdbk = document.getElementById(tableId);
  var bd_title = $(tdbk.rows[row_id].cells[1]).text();
  var apnd_id  = $("#appended_title").val();
  //console.log(apnd_id); return false;
    $("#mpn_desc_"+apnd_id).val(bd_title);
    //$("body #select_mpn_"+apnd_id).attr("checked", true);
    $("#mpn_desc_"+apnd_id).focus();


});

/*----- Display MPN Catalogue start -----*/
$(document).on('change', '.displayCatalogueMPN', function(){
      var bd_kit_mpn = $("#bd_kit_mpn").find('option:selected').text();
      //alert(bd_kit_mpn);return false;
      var bd_category = $("#bd_category").val();
      //alert(bd_category); return false;
      // alert(bd_kit_mpn);
      var mpn_id = $("#bd_kit_mpn").val();
      // alert(mpn_id);
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/displayCatalogueMPN',
      data: {'bd_kit_mpn':bd_kit_mpn, 'bd_category':bd_category},
     success: function (data){
      //console.log(data);
      if(data){
          var result = [];  
          for(var i = 0; i< data.length; i++){

              result.push('<tr><td>'+data[i].SPECIFIC_NAME+'</td><td>'+data[i].SPECIFIC_VALUE+'</td></tr>'); //This adds each thing we want to append to the array in order.
           }


          $('#displayCatalogue').html('');
          $('#displayCatalogue').append('<div class="col-sm-10"><label>Item Specifics:</label></div><div class="col-sm-2 p-b-5"><div class="pull-right"><a id="show_'+mpn_id+'" class="btn btn-primary btn-sm showMpn" title="Show_Detail">Show All Specifics</a></div></div><table id="display_mpn_catalogue" class="table table-responsive table-striped table-bordered table-hover" ><thead><th>Specific Name</th><th>Specific Value</th></thead><tbody>'+result.join("")+'</tbody></table>');        
      }      

     }
    }); 
 });
/*----- Display MPN Catalogue end -----*/

//////////////// FOR SHOWING RESULT////////////
//$(document).on('click', '.results', function(){
      //alert('dfsdffdsffdsfdsf'); 
      //var tdbk = 'display_expresions';
      //var result_exp=$('#'+tdbk.rows[this].cells[1]).val();
      //alert(result_exp); return false;
    //$.ajax({
     // dataType: 'json',
      //type: 'POST',        
      //url:'<?php //echo base_url(); ?>bigData/c_recog_title_mpn_kits/getSpecificObject',
      //data: {'bd_kit_mpn_id':bd_kit_mpn_id},
     //success: function (data){
        //console.log(data);
        //Since we defined our variable as an array up there we join it here into a string
        //$("#spec_name").html(specificsValues);
        //$("#bd_kit_object").val(data[0].OBJECT_NAME);
    // }
    //}); 
 //});
////////////////END FOR SHOWING RESULT////////////
/////////////////////////////////////////////////
$("#fltr_bd_category").on('change', function(){
  var fltr_bd_category = $("#fltr_bd_category").val();
  //alert(fltr_bd_category); return false;
  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>bigData/c_autoCatalog/getSpecificExprs',
    data: {'fltr_bd_category':fltr_bd_category},
   success: function (data) {
    //console.log(data); return false;
      var specificsValues = [];
      var session_expr='<?php if($this->session->userdata("bd_sess_expr")){ echo $this->session->userdata("bd_sess_expr"); } ?>';
          if (session_expr !='') { var selected='selected'}else {
            var selected=''
          } 
      for (var i = 0; i < data.length; i++) {
          specificsValues.push('<option value="'+data[i].CAT_EXP_ID+'" '+selected+'>'+data[i].EXPR_NAME+'</option>'); //This adds each thing we want to append to the array in order.
      }
      //Since we defined our variable as an array up there we join it here into a string
      //$("#spec_name").html(specificsValues);
      
       specificsValues.join(" ");
      $("#title_expression").html("");
      $("#title_expression").append('<select style="width:160px;" class="form-control specifics selectDropdown selectpicker displayExprs" data-live-search="true"  name="bd_title_expr" id="bd_title_expr"><option value="">-----------Select----------</option>'+specificsValues.join(" ")+'</select>');
      $('.selectDropdown').selectpicker();
   }
  }); 
 });
///////////////////////////////////////////////
$(document).on('change', '#bd_title_expr', function(event) {
  event.preventDefault();
  /* Act on the event */
        var fltr_bd_category= $("#fltr_bd_category").val();
        var bd_title_expr = $("#bd_title_expr").val();
        
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '<?php echo base_url(); ?>bigData/c_autoCatalog/displayRelatedExps',
        data: {'fltr_bd_category':fltr_bd_category,'bd_title_expr':bd_title_expr},
        success: function (data) {
        //console.log(data); return false; 
        if (data) {
             var row = [];  
              var confirm_msg= "return confirm('Are you sure to delete?');";
              var verify_msg= "return confirm('Are you sure to verify?');";
          for(var k = 0; k< data.length; k++){

              var del_url= '<?php //echo base_url() ?>bigData/c_autoCatalog/deleteBdExpresion/'+data[k].CAT_EXP_ID;
              //var result_url= '<?php //echo base_url() ?>bigdata/c_recog_title_mpn_kits/showExpDetail/'+data[k].MPN_RECOG_MT_ID;
              var verify_url= '<?php //echo base_url() ?>bigdata/c_autoCatalog/verifyExpData/'+data[k].CAT_EXP_ID;

              row.push('<tr id="'+(k + 1)+'"><td>'+(k + 1)+'</td><td><div class="edit_btun" style=" width: 90px; height: auto;"><button title="Edit Template" id="'+data[k].CAT_EXP_ID+'" class="btn btn-warning btn-xs exp-update" style="margin-right:6px;"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span> </button><a title="Delete Expresion" href="'+del_url+'" onclick="'+confirm_msg+'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div></td><td style="width: 450px;"><div id="display_normal_'+data[k].CAT_EXP_ID+'">'+data[k].EXP_TEXT+'</div><div id="display_for_update_'+data[k].CAT_EXP_ID+'" style="display: none;"> <input style="width: 330px;" type="text" value="'+data[k].EXP_TEXT+'" class="form-control" id="kit_exp_'+data[k].CAT_EXP_ID+'" name="exp_'+data[k].CAT_EXP_ID+'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="exp_'+k+'" class="btn btn-success btn-sm update-btn" value="Save" id="'+data[k].CAT_EXP_ID+'"></div></td><td style="width: 300px;"><div class="col-sm-2"><div class="form-group"><button class="btn btn-primary btn-sm exp_results"  exp="'+data[k].CAT_EXP_ID+'" id="exp_res_'+data[k].CAT_EXP_ID+'">Result</button></div></div><div class="col-sm-2" style="margin-left: 25px;"><div class="form-group"><a title="Show result" onclick="'+verify_msg+'" href="'+verify_url+'" class="btn btn-success btn-sm pull-right">Verify</a></div></div></td><td><div class="col-sm-3"><div class="form-group"><input type="button" class="btn btn-success btn-sm" name="check_exp" id="check_exp_"'+k+'" value="Check Exp"></div></div></td></tr>'); //This adds each thing we want to append to the array in order.
           }

          $('#display_auto_expresions').html('');
          $('#display_auto_expresions').append('<table id="expresions_table" class="table table-responsive table-striped table-bordered table-hover" ><thead><th>Sr.#</th><th>Action</th><th>Expression</th><th>Result</th><th>Check Expression</th></thead><tbody>'+row.join("")+'</tbody></table>');


           $('#expresions_table').DataTable({
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
        }
     }
    });
  
});

///////////////////////////////////////

/*--- Onchange Mpn get its Objects start---*/
$("#bd_mpn" ).change(function() {

  var bd_mpn = $("#bd_mpn").val();

  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
   success: function (data) {
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);

    }

  });
});
/*--- Onchange Mpn get its Objects start ---*/
/*--- Datatable MpnObjectsResult start ---*/
    // $('#MpnObjectsResult').DataTable({
    //   "paging": true,
    //   "iDisplayLength": 500,
    //   "aLengthMenu": [[100, 200,500, 1000, -1], [100, 200,500, 1000, "All"]],
    //   "lengthChange": true,
    //   "searching": true,
    //   "ordering": true,
    //   //"order": [[ 3, "ASC" ]],
    //   "info": true,
    //   "autoWidth": true,
    //   "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    // }); 
/*--- Datatable MpnObjectsResult End ---*/

/*========================================
=            check expression            =
========================================*/
$("#check_exp").on("click", function(){
    //alert('ok'); 
    var bd_category = $("#bd_category").val();
    var kit_mpn = $('#kit_mpn').val(); 
    var kit_exp = $('#kit_exp').val();
  // if(custom_attribute == '' || custom_attribute == null){
  //   alert('Please insert custom attribute value');
  //   return false;
  // }
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/checkExp',
      data: { 'bd_category' : bd_category, 'kit_mpn': kit_mpn, 'kit_exp': kit_exp},
     success: function (data) {
        if(data == true){
            alert('Success! Valid Expression.');
           // return false;
          }else{
            alert('Error! Experssion not valid.');
            //return false;
          }          
     }
    });
  });
/*=====  End of check expression  ======*/
/*---- Result Expression Detials start ----*/
$("#result_exp").on("click", function(){
    var bd_category = $("#bd_category").val();
    //var kit_mpn = $('#kit_mpn').val(); 
    var kit_exp = $('#kit_exp').val(); 
    //alert(bd_category); return false;       
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/showCurExpDetail',
      data: { 'bd_category' : bd_category, 'kit_exp': kit_exp},

     success: function (data) {
      //console.log(data.results.exp_result.length); return false;

      if(data){
          
          var row = [];
          var alertMsg = "return confirm('Are you sure to delete?');";
          for(var k = 0; k< data.exp_result.length; k++){
              row.push('<tr id="'+data.exp_result[k].LZ_BD_CATA_ID+'"> <td> <div> <a title="Delete" id="'+data.exp_result[k].LZ_BD_CATA_ID+'"  onclick="'+alertMsg+'" class="btn btn-danger btn-xs delResultRow"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> </div> </td><td>'+data.exp_result[k].EBAY_ID+'</td><td>'+data.exp_result[k].TITLE+'</td><td>'+data.exp_result[k].CONDITION_NAME+'</td><td>'+data.exp_result[k].SELLER_ID+'</td><td>'+data.exp_result[k].LISTING_TYPE+'</td><td>'+data.exp_result[k].SALE_PRICE+'</td><td>'+data.exp_result[k].START_TIME+'</td><td>'+data.exp_result[k].SALE_TIME+'</td><td>'+data.exp_result[k].FEEDBACK_SCORE+'</td></tr>'); //This adds each thing we want to append to the array in order.
            //row.join(" ");
           }

          //var model = "";
          // row.push();
          $('#exp_table').html('');
          $('#exp_table').append('<table id="result_tab" class="table table-responsive table-striped table-bordered table-hover" > <thead><tr><th>ACTIONS</th><th>EBAY ID</th> <th>TITLE</th> <th>CONDITION</th> <th>SELLER</th> <th>BIN/AUCTION</th> <th>PRICE</th> <th>START DATE </th> <th>END DATE</th> <th>SELER FEEDBACK</th> </tr> </thead><tbody>'+row.join("")+'</tbody> </table>');
         
         // $("body").find(".table-responsive").DataTable();
         $('#total_record').html('');
         $('#total_record').html(data.total_record[0].TOTAL_RECORD);
         $('#total_verified').html('');
         $('#total_verified').html(data.total_verified[0].TOTAL_VERIFIED);
         $('#total_unverified').html('');
         $('#total_unverified').html(data.total_unverified[0].TOTAL_UNVERIFIED);
         $('#total_exp_record').html('');
         $('#total_exp_record').html(data.exp_result.length);
         
           $('#result_tab').DataTable({
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



        }

     }
  });
});
/*---- Result Expression Detials end ----*/

/*---- Result Expression Detials start ----*/
$(document).on("click", ".exp_results", function(){
    var kit_exp_id = $(this).attr("exp"); 
    //alert(kit_exp_id); return false;       
    $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/showExpDetail',
      data: {'kit_exp_id' : kit_exp_id},
     success: function (data) {
      if(data){
          var row = [];
          var alertMsg = "return confirm('Are you sure to delete?');";
          for(var k = 0; k< data.exp_result.length; k++){
              row.push('<tr id="'+data.exp_result[k].LZ_BD_CATA_ID+'"> <td> <div> <a title="Delete" id="'+data.exp_result[k].LZ_BD_CATA_ID+'"  onclick="'+alertMsg+'" class="btn btn-danger btn-xs delResultRow"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> </div> </td><td>'+data.exp_result[k].EBAY_ID+'</td><td>'+data.exp_result[k].TITLE+'</td><td>'+data.exp_result[k].CONDITION_NAME+'</td><td>'+data.exp_result[k].SELLER_ID+'</td><td>'+data.exp_result[k].LISTING_TYPE+'</td><td>'+data.exp_result[k].SALE_PRICE+'</td><td>'+data.exp_result[k].START_TIME+'</td><td>'+data.exp_result[k].SALE_TIME+'</td><td>'+data.exp_result[k].FEEDBACK_SCORE+'</td></tr>'); //This adds each thing we want to append to the array in order.
            //row.join(" ");
           }
          //var model = "";
          // row.push();
          $('#exp_table').html('');
          $('#exp_table').append('<table id="exp_result_table" class="table table-responsive table-striped table-bordered table-hover" > <thead><tr><th>ACTIONS</th><th>EBAY ID</th> <th>TITLE</th> <th>CONDITION</th> <th>SELLER</th> <th>BIN/AUCTION</th> <th>PRICE</th> <th>START DATE </th> <th>END DATE</th> <th>SELER FEEDBACK</th> </tr> </thead><tbody>'+row.join("")+'</tbody> </table>');

         
      
         $('#total_record').html('');
         $('#total_record').html(data.total_record[0].TOTAL_RECORD);
         $('#total_verified').html('');
         $('#total_verified').html(data.total_verified[0].TOTAL_VERIFIED);
         $('#total_unverified').html('');
         $('#total_unverified').html(data.total_unverified[0].TOTAL_UNVERIFIED);
         $('#total_exp_record').html('');
         $('#total_exp_record').html(data.exp_result.length);
    
           $('#exp_result_table').DataTable({
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

         
        }
     }
  }); /////
});  ////
/*---- Result Expression Detials end ----*/
/////////// FOR UPDATE EXPRESSION ////////////////////////
$(document).on("click", ".exp-update", function(){
    //alert('ok'); 
    var exp_id = $(this).attr("id"); 
    //alert(t); return false;
    $('#display_normal_'+exp_id+'').hide(); 
    $('#display_for_update_'+exp_id+'').show();
  });
/////////// END FOR UPDATE EXPRESSION ////////////////////////

/////////// FOR UPDATE EXPRESSION ////////////////////////
$(document).on("click", ".update-btn", function(){
    //and title like '%MD101LL/AA%'
    var exp_id = $(this).attr("id");
    var kit_exp = $("#kit_exp_"+exp_id+"").val();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/bdUpdateExpresion',
      data: { 'exp_id' : exp_id, 'kit_exp': kit_exp},
     success: function (data) {
        if(data == true){
            alert('Success! Data Updated');
            window.location.reload();
           // return false;
          }else{
            alert('Error! Data Updation Failed');
            window.location.reload();
            //return false;
          }          
     }
    });
  });
/////////// END FOR UPDATE EXPRESSION ////////////////////////
});

///////////////////////////////


/*===============================================
=            Edit BY YOusaf 9/6/2017            =
===============================================*/

$("#save_mpn_kit").on('click', function(){
    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/saveMpnKit';
    // var bd_alt_object = $("#bd_alt_object").val();
    var bd_mpn = $("#bd_mpn").val();
    var kit_qty = $("#kit_qty").val();
    // alert(bd_mpn);return false;
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'bd_mpn': bd_mpn,
      'kit_qty' : kit_qty
    },
    dataType: 'json',
    success: function (data){
      if(data == 1){
        alert("data is inserted");
      }
      else{
        alert("data is not inserted! Try Again");
      }    
      // var i =5;


      var j = 1;
      $.ajax({
        url:'<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/getMpnObjectsResult',
        type: 'POST',
        dataType: 'json',

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
         }
      });
    }
  });
});




$(document).on('click','.object_delete',function(){
    var mpn_kit_id = this.id.match(/\d+/);
    mpn_kit_id = parseInt(mpn_kit_id);
    // alert(mpn_kit_id);return false;
    var i = 1;
    if(confirm('Are you sure you want to delete?')){
    $.ajax({
      url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/deleteMpnObjectResults',
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
          url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/getMpnObjectsResult',
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
                      
                               
          }

          
        });
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

$(document).ready(function(){
  $('#updateBlock').hide();

});

$(document).on('click','.object_edit ',function(){
  var index = this.id.match(/\d+/);
  var bd_category = $('#bd_category').val();
  $('#hidden_obj').val(index);

  var selected = $('#hid_alternate_mpn'+index+'').val();
   
  $.ajax({
      url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/getMpnsEdit',
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
        url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
        data: {'bd_mpn' : bd_mpn},
       success: function (data) {
        //console.log(data);
        $("#update_bd_object").val(data[0].OBJECT_NAME);

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
      url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/updateMPN',
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
          url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/getMpnObjectsResult',
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
          }
        });
      }
  });

});


$('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $.ajax({
    url:'<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/loadBdMpn',
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
          
        }
      });
  });
/*=====  End of Edit BY YOusaf 9/6/2017  ======*/
$(".add_mpn").on('click', function(){
    var fields = $("input[name='select_mpn']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one'); 
        return false;
      }  
      var arr = [];
      var cat_id= $("#create_cat").val();
      //if (true) {}
      var word_mpn = [];
      var alt_mpn = [];
      var exp_object = [];
      var mpn_desc = [];
      var url='<?php echo base_url() ?>bigData/c_autoCatalog/addAutoMpn';

      var tableId="result_table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='select_mpn']:checked"), function()
      {            
        arr.push($(this).val());
      });
      //console.log(arr); return false;
      for (var i = 0; i < arr.length; i++)
          {
            word_mpn.push($(tdbk.rows[arr[i]].cells[2]).text());

             $(tdbk.rows[arr[i]]).find(".rslt_object").each(function() {
              if ($(this).val().length !=0) {
                exp_object.push($(this).val());
              }     
              }); 
              $(tdbk.rows[arr[i]]).find(".alternate_mpn").each(function() {
                    alt_mpn.push($(this).val());
                });

              $(tdbk.rows[arr[i]]).find('.mpn_desc').each(function() {
                if ($(this).val().length !=0) {
                mpn_desc.push($(this).val());
              }
              });          
          }
          //console.log(mpn_desc); return false;
          exp_object = exp_object.filter(v=>v!='');
      //console.log(exp_object, mpn_desc, arr, alt_mpn); return false;
      if (exp_object.length != arr.length || mpn_desc.length != arr.length) {
        alert('Warning: Object and mpn description are required');
        return false;
      }else {
      $(".loader").show();
      $.ajax({
        type: 'POST',
        url:url,
        data: {
          'cat_id': cat_id,
          'word_mpn': word_mpn,
          'alt_mpn': alt_mpn,
          'exp_object': exp_object,
          'mpn_desc': mpn_desc
        },
        dataType: 'json',
        success: function (data){
         if(data== 1){
          alert("data is inserted");
          //window.location.reload(); 
          $(".select_mpn").prop('checked', false);
          $(".alternate_mpn").val('');
          $('.rslt_object').selectpicker('val', '');
          $(".mpn_desc").val('');
          $('#table_main_id').html('').remove();
          return false;
         }else if(data== 0){
          alert('Error: Fail to insert data');
          return false;
         }else if(data == 2){
          alert('Data already exist');
          return false;
         }
       },
       complete: function(data){
        $(".loader").hide();
      }
  });
      }
      
});
  /*==============================================================
  =            FOR SAVING JUNK DATA                               =
  ================================================================*/ 
  
/*======================================
=            YOUSAF Methods            =
======================================*/

var clicked =0;
$(document).on('click','.auto_catalogue',function(){
      clicked++;
      var row_num = $(this).attr("rowid");
      // alert(row_num);return false;
      var ids = this.id.match(/\d+/);
      var rowId = $(this).attr("id");
      // alert(rowId);return false;
      //console.log(row_num, rowId); 
      var result_cat  = $("#create_cat").val();
      var result_word  = $("#result_word_"+ids).val();
      // alert(result_word);return false;      //var result_word  = $('#word_'+ids+'').text().replace(/ /g,'');
      // $("body #select_mpn_"+row_num).prop('checked', true);
      //console.log($("body #select_mpn_"+row_num).attr('checked','checked')); 
      //alert(TITLE); return false;
      // $('#autoCatalogueTable').toggle();
      if (result_cat.length == 0) {
        clicked = 0;
        alert("Warning: Category is required!");
        $("#create_cat").focus();
        return false;
      }else {
        $(".loader").show();
          $.ajax({
              type: 'POST',
              dataType: 'json',
              url:'<?php echo base_url(); ?>bigData/c_autoCatalog/addCatalogueDetail',
              data:{ 
                    'result_cat' : result_cat,
                    'result_word' : result_word
                    },
             success: function (data) {
                $(".loader").hide();
                // console.log(data); return false;
                //alert(data.length > 0); return false;
                if (data.length > 0) {
                    var row = [];  
                    for(var k = 0; k< data.length; k++){
                        row.push('<tr id="'+(k + 1)+'" style="width:100%;" ><td><div  style="width:200px;">'+data[k].SPECIFIC_NAME+'</div><input type="hidden" class="validValue" id="mtId_'+k+'" value="'+data[k].MT_ID+'_'+data[k].MAX_VALUE+'"></td><td><div  style="width:200px;">'+data[k].SPECIFIC_VALUE+'</div><input type="hidden" name="det_id"  value="'+data[k].DET_ID+'" id="det_id_'+k+'" class="DET"></td><td><div  style="width:200px;">'+data[k].C+'</div></td><td></td><td><div  style="width:200px;"><input type="checkbox" name="checkboxes" id="checkbox_'+k+'" class="checkboxes" class="Check"></div></td></tr>');
                         ////This adds each thing we want to append to the array in order. }
                       }
                        $('#autoCatalogueTable').html('').remove();
                        $('#result_table tr #auto_table_'+ids+'').append('<div id="autoCatalogueTable" ><input type="hidden" value="'+ids+'" id="appended_title"><table id="table_catlogue" tabindex="-1" class="table table-responsive table-striped table-bordered table-hover" ><thead><th>SPECIFIC</th><th>WORD</th><th>COUNT</th><th>%</th><th></th></thead><tbody>'+row.join("")+'</tbody></table><button type="button" class="btn btn-primary btn-sm makes" title="MakeCatalogue" id="make_'+ids+'" >Make Catalogue</button></div> ');

                          $("#autoCatalogueTable").attr("tabindex",-1).focus();
                          if(clicked%2==0){
                            $('#autoCatalogueTable').html('').remove();
                            $('#autoCatalogueTable').hide();
                          }else{
                            $('#autoCatalogueTable').show();

                            // $('#table_catlogue').DataTable({
                            //     "oLanguage": {
                            //     "sInfo": "Total Records: _TOTAL_"
                            //   },
                            //   "iDisplayLength": 500,
                            //   "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
                            //     "paging": true,
                            //     "lengthChange": true,
                            //     "searching": true,
                            //     // "ordering": true,
                            //     // "order": [[ 16, "ASC" ]],
                            //     "info": true,
                            //     "autoWidth": true,
                            //     "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
                            //   });
                          }

                   
              }else {
                alert("No data found");
                return false;
              }
           
            
        } 
      }); ///ajax call

    }



  // var id = this.id.match(/\d+/);
  //  var mpn = $('#word_'+id+'').text().replace(/ /g,'');
  //  // alert(mpn);return false;
  //  var cat_id = $('#create_cat').val();
  //  // alert(cat_id);return false;
  //  if(cat_id == ''){
  //   $( "#auto_catalogue_"+id+"" ).removeAttr('href');
  //   $( "#auto_catalogue_"+id+"" ).attr( 'target','');

  //   alert('Please Select a CATEGORY_ID!');
  //  }else{

  //     $( "#auto_catalogue_"+id+"" ).attr( 'href', '<?php //echo base_url(); ?>bigData/c_autoCatalog/addCatalogueDetail/'+cat_id+'/'+mpn );
  //     $( "#auto_catalogue_"+id+"" ).attr( 'target','_blank');

  //  }
   

});


$(document).on('change','.checkboxes',function(){
  var id = this.id.match(/\d+/);
  var checkbox = $('#checkbox_'+id+'').prop('checked');
  var spec_name = $('#mtId_'+id+'').val();

  var ret = spec_name.split("_");
  var str1 = ret[0];
  // alert(str1);
  var str2 = ret[1];
  // alert(str2);return false;

  var spec_name2 = '';
  var id2 = '';
  if(checkbox == true){
    $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id.match(/\d+/);
       spec_name2 = $('#mtId_'+id2+'').val();
       var ret = spec_name2.split("_");
       var str1 = ret[0];
       // alert(str1);
       var str2 = ret[1];
    
      if(spec_name == spec_name2 && str2 == 1){
        $('#checkbox_'+id2+'').prop('disabled',true);
      }
      $('#checkbox_'+id+'').prop('disabled',false);
    

    });
   }else{
       $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id.match(/\d+/);
       spec_name2 = $('#mtId_'+id2+'').val();
       var ret = spec_name2.split("_");
       var str1 = ret[0];
       // alert(str1);
       var str2 = ret[1];
    
      if(spec_name == spec_name2){
        $('#checkbox_'+id2+'').prop('disabled',false);
      }
      // $('#checkbox_'+id+'').prop('disabled',false);
    

    });
   }


});


$(document).on('click','.makes',function(){

 var id = this.id.match(/\d+/);
 // alert(id);return false;
 var $check = [];
 var det_ids = [];
 var num_checked = $(":checkbox:checked").length;
 
 var cat_id = $("#create_cat").val();
 var mpn = $("#result_word_"+id).val();;
 // alert(mpn);return false;
 var i =0;
 $('.checkboxes').each(function(){
    var checkbox = $('#checkbox_'+i+'').prop('checked');

    if(checkbox == true){
      det_ids.push($('#det_id_'+i+'').val());
        // alert(i);
        // alert($('#det_id_'+i+'').val());return false;
    }
    i++;
 });

 // alert(det_ids);return false;
// $(".loader").show();
  $.ajax({
     url: '<?php echo base_url() ?>bigData/c_autoCatalog/makeCatalogueDetail/', //maintains the (controller/function/argument) logic in the MVC pattern
        type: 'post',
        dataType: 'json',
        data : {'det_ids':det_ids,'mpn':mpn,'cat_id':cat_id},
        success: function(data){
            if(data == 1){
              alert('Data is inserted!');
            }else{
              alert('Master Catalogue Does Not Exist');
            }
        }
 //        error: function(data){
 //           alert('inserted');
 //        }
        // complete: function(data){
        //  $(".loader").hide();
        // } 
 });

});

/*=====  End of YOUSAF Methods  ======*/
  /*==============================================================
  =            FOR SAVING JUNK DATA                               =
  ================================================================*/
$(".add_junk").on('click', function(event) {
  event.preventDefault();
  /* Act on the event */
      var fields = $("input[name='select_mpn']").serializeArray(); 
          if (fields.length === 0) 
          { 
            alert('Please Select at least one'); 
            return false;
          }  
          var arr = [];
          var cat_id= $("#create_cat").val();
          var word_id= $("#junk_word").val();
          var junk_words = [];
          var url='<?php echo base_url() ?>bigData/c_autoCatalog/addAutoJunk';
          var tableId="result_table";
          var tdbk = document.getElementById(tableId);
            $.each($("#"+tableId+" input[name='select_mpn']:checked"), function()
            {            
              arr.push($(this).val());
            });

            for (var i = 0; i < arr.length; i++)
              {
                junk_words.push($(tdbk.rows[arr[i]].cells[2]).text());         
              }
               $(".loader").show();
                $.ajax({
                  type: 'POST',
                  url:url,
                  data: {
                    'cat_id': cat_id,
                    'word_id': word_id,
                    'junk_words': junk_words
                  },
                  dataType: 'json',
                  success: function (data){
                   if(data== 1){
                    alert("data is inserted"); 
                    return false;
                   }else if(data== 0){
                    alert('Error: Fail to insert data');
                    return false;
                   }else if(data == 2){
                    alert('Data already exist');
                    return false;
                   }
                 },
                 complete: function(data){
                $(".loader").hide();
              }
            });
});
  /*==============================================================
  =            FOR SAVING JUNK DATA                               =
  ================================================================*/

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/

/*=====  Title Filtering Expression saving start  ======*/  
$("#fltr_exp_save").on('click', function(){
    var fltr_exp = $("#fltr_exp").val();
    var exp_name = $("#exp_name").val();
    if($.trim(fltr_exp) == ''){
      alert('Please fill experssion field.');
      $("#fltr_exp").css({"background-color": "#ffcccc"});
      $("#fltr_exp").focus();
      return false;
    }else if($.trim(exp_name) == ''){
      alert('Please fill experssion field.');
      $("#exp_name").css({"background-color": "#ffcccc"});
      $("#exp_name").focus();
      return false;      
    }
    var url='<?php echo base_url() ?>bigData/c_autoCatalog/saveFilterExp';
    var fltr_bd_category = $("#fltr_bd_category").val();

    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'fltr_exp': fltr_exp,
      'exp_name': exp_name,
      'fltr_bd_category': fltr_bd_category   
    },
    dataType: 'json',
    success: function (data) {
      if(data == 1){
        alert('Expression is insertd.');
      }else if(data == 0){
        alert('Error! Expression is not insertd.');
      }else if(data == 2){
        alert('Name and Expression already exist.');
      }else if(data == 3){
        alert('Expression is already added.');
      }
    }
  });

  });
/*=====  Title Filtering Expression saving end  ======*/ 

/*=====  Word Expression saving start  ======*/ 
$("#save_word_exp").on('click', function(){
    var word_exp = $("#word_exp").val();
    var word_exp_name = $("#word_exp_name").val();
    if($.trim(word_exp) == '' || word_exp == null){
      alert('Please fill experssion field.');
      $("#word_exp").css({"background-color": "#ffcccc"});
      $("#word_exp").focus();
      return false;
    }else if($.trim(word_exp_name) == '' || word_exp_name == null){
      alert('Please fill experssion Name field.');
      $("#word_exp_name").css({"background-color": "#ffcccc"});
      $("#word_exp_name").focus();
      return false;      
    }
    var url='<?php echo base_url() ?>bigData/c_autoCatalog/saveWordExp';
    var bd_category = $("#bd_category").val();

    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'word_exp': word_exp,
      'word_exp_name': word_exp_name,
      'bd_category': bd_category   
    },
    dataType: 'json',
    success: function (data) {
      if(data == 1){
        alert('Expression is insertd.');
      }else if(data == 0){
        alert('Error! Expression is not insertd.');
      }else if(data == 2){
        alert('Expression is alreay exist.');
      }
    }
  });
}); 
/*=====  Word Expression saving start  ======*/ 
  </script>