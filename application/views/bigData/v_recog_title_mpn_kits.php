<?php $this->load->view('template/header'); ?>

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
        Recognize Mpn Kits
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Recognize Mpn Kits</li>
      </ol>
    </section>
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Start Category Mpn Object Save -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Recognize Mpn Kits</h3>

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
                              //$this->session->unset_userdata('bd_category'); 
                          ?>                      
                        </select>  
                      </div>
                    </div> 
                    <div class="col-sm-4 kit_mpn">
                      <div class="from-group">
                        <label for="Item Specific Name">MPN:</label>
                        <div id="kit_mpn">   
                        </div>
                      </div>                           
                    </div> 
                   
                     <div class="col-sm-4 kit_object">
                      <div class="from-group">
                        <label for="for object">Object:</label>
                        <input class="form-control" name="bd_kit_object" id="bd_kit_object" value="<?php if($this->session->userdata("bd_kit_object")){ echo $this->session->userdata("bd_kit_object"); } ?>" readonly></input>  
                      </div>                           
                    </div>
                     </div>
                    
                    <!-- First form -->
                    <div class="col-sm-12">
                    <!-- <form action="<?php //echo base_url(); ?>bigData/c_recog_title_mpn_kits/showMainExpDetail" method="post" accept-charset="utf-8"> -->
                      <div class="col-sm-9">
                        <div class="form-group">
                          <label for="">Expresion:</label>
                          <input type="text" class="form-control" name="kit_exp" id="kit_exp" placeholder=" title like <MPN>" value="<?php if(isset($_POST['kit_exp'])){ echo trim($_POST['kit_exp']); } ?>" >
                        </div>
                    </div>
                    <div class="col-sm-1 p-t-24">
                        <input type="submit" id="result_exp" class="btn btn-primary btn-sm" value="Result">
                      </div>
                    <!-- </form> -->
                       
                    <div class="col-sm-1 p-t-24">
                      <div class="form-group">
                        <input type="submit" class="btn btn-success btn-sm pull-right" name="save_recognized_mpn" id="save_recognized_mpn" value="Save">
                      </div>
                    </div>
                      <div class="col-sm-1 p-t-24">
                        <div class="form-group">
                          <input type="button" class="btn btn-warning btn-sm" name="expressionHint" title="How to add Expression?" id="expressionHint" value="Hint!">
                        </div>
                      </div>                     
                    </div>



                    <div class="col-sm-12">
                      
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
                    </div>
                    <!-- Catalogue Group Detail against MPN start -->
                    <div class="col-sm-12" style="margin-top: 20px;">
                      <div id="displayCatalogue">
                        
                      </div>
                    </div>
                    <!-- Catalogue Group Detail against MPN end -->
                <br>
                  <div class="col-sm-12" style="margin-top: 20px;">
                   <div id="display_expresions">
                     
                   </div> 
                  </div>
                </div>
            </div>
       <!-- End Category Mpn Object Save -->

       <!-- Start Category Mpn Object Save -->

          <div class="box collapsed-box">
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
                          <div class="form-group" id="brands">   
                          </div>
                        </div>
                        <div class='col-sm-3'>
                          <div class="form-group" id="bdMPN">    
                          </div>
                        </div>
                       
                        <div class='col-sm-1'>
                          <div class='form-group'>
                            <label>Quantity:</label>
                            <input class='form-control' type='text' name='kit_qty' id='kit_qty' value='1' placeholder='Enter Quantity'/>
                          </div>
                        </div>                                                
                        <div class="col-sm-1">
                          <div class="form-group p-t-24">
                            <input type="button" class="btn btn-success btn-sm" name="save_mpn_kit" id="save_mpn_kit" value="Save">
                          </div>
                        </div>
                        <div class="form-group col-sm-1 p-t-24">
                        <input type="button" class="btn btn-info btn-sm" name="go_to_catalogue" id="go_to_catalogue" value="Add PMN">
                        <!--  <a type="button" class="btn btn-info btn-sm" href="<?php //echo base_url().'catalogue/c_itemCatalogue/getCategorySpecifics/'.$cat_id.'/'.$mpn_id; ?>"  target="_blank" >Add PMN</a> -->
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
                    <div class="col-sm-12" style="margin-top: 20px;">
                    <?php if(!empty($getMpnObjectsResult)){ ?>
                      <table id="MpnObjectsResult" class="table table-responsive table-striped table-bordered table-hover" >
                      <div class="pull-right">
                      <a href="<?php echo base_url();?>bigData/c_recog_title_mpn_kits/get_altMpn" target="_blank" class="btn btn-primary">Alternate MPN List</a>
                    </div>
             
                      </div>
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
          <!-- summary Block start -->   
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Summary</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class="col-lg-2 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                  <div class="inner">
                    <p class="summarycardcss" id="total_record"><?php if (!empty($results['total_record'])) { echo $results['total_record'][0]['TOTAL_RECORD']; }else {
                      echo "0";
                    }
                    ?></p>
                    <p>Total Records</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-database fa-1x"  aria-hidden="true"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <p class="summarycardcss" id="total_verified">
                  <?php 
                    if (!empty($results['total_verified'])) { echo $results['total_verified'][0]['TOTAL_VERIFIED']; }else {
                      echo "0";
                    }
                  ?>
                  </p>

                  <p>Total Verified</p>
                </div>
                <div class="icon">
                  <i class="fa fa-check-circle-o fa-1x" aria-hidden="true"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">

                  <p class="summarycardcss" id="total_unverified"><?php if (!empty($results['total_unverified'])) { echo $results['total_unverified'][0]['TOTAL_UNVERIFIED']; }else {
                      echo "0";
                    } 
                    ?></p>

                  <p>Total Unverified</p>
                </div>
                <div class="icon">
                  <i class="fa fa-ban fa-1x" aria-hidden="true"></i>
                </div>
                <?php //$unverify_cat_id = $this->session->userdata('bd_recog_category'); ?>
                <!-- <a  href="<?php //echo base_url().'bigData/c_recog_title_mpn_kits/totalUnverified/'.$unverify_cat_id; ?>" class="small-box-footer" target="_blank" >More info <i class="fa fa-arrow-circle-right"></i></a> -->
                <div class="text text-center">
                  <button type="button" class="btn btn-warning btn-xs" id="unverified-info" align="center">More info <i class="fa fa-arrow-circle-right"></i></button>
                </div>
                
              </div>
            </div>
            <div class="col-lg-2 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <p class="summarycardcss" id="total_exp_record">
                  <?php 
                    if (!empty($results['exp_result'])) { echo count($results['exp_result']); }else {
                      echo "0";
                    }
                  ?></p>

                  <p>Total Exp Record</p>
                </div>
                <div class="icon">
                  <i class="fa fa-info-circle" aria-hidden="true"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            </div><!-- div box-body end -->
          </div>
          <!-- summary Block end -->   
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
            <div class="box-body">
              <div class="col-sm-12">
                  <?php if (!empty($results['exp_result'])) { 
                    ?>
                <div id="exp_table">    
                  <table id="result_table" class="table table-responsive table-striped table-bordered table-hover" > 
                    <thead>
                      <tr>
                        <th>ACTIONS</th> 
                        <th>EBAY ID</th> 
                        <th>TITLE</th> 
                        <th>CONDITION</th> 
                        <th>SELLER</th> 
                        <th>BIN/AUCTION</th> 
                        <th>PRICE</th> 
                        <th>START DATE </th> 
                        <th>END DATE</th> 
                        <th>SELER FEEDBACK</th> 
                       </tr> 
                    </thead>
                   <tbody>
                      <?php 
                        $i = 1;  
                           foreach ($results['exp_result'] as $result): ?>
                            <tr id="<?php echo $result['LZ_BD_CATA_ID']; ?>">
                              <td>
                                <div>
                                  <a title="Delete" id="<?php echo $result['LZ_BD_CATA_ID']; ?>"  onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs delResultRow"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                  </a>                                  
                                </div>
                              </td> 
                              <td><?php echo @$result['EBAY_ID']; ?></td>
                              <td><?php echo @$result['TITLE']; ?></td>  
                              <td><?php echo @$result['CONDITION_NAME']; ?></td>
                              <td><?php echo @$result['SELLER_ID']; ?></td>
                              <td><?php echo @$result['LISTING_TYPE']; ?></td>  
                              <td><?php //echo "$ ".@$result['SALE_PRICE']; ?>
                                  <?php 
                                    echo "$ ".number_format((float)@$result['SALE_PRICE'],2,'.',',');
                                    ?>
                              </td>
                              <td><?php echo @$result['START_TIME']; ?></td>
                              <td><?php echo @$result['SALE_TIME']; ?></td>
                              <td><?php echo @$result['FEEDBACK_SCORE']; ?></td>
                            </tr>   
                        <?php 
                        $i++;
                        endforeach;
                        
                      ?> 
                   </tbody>
                  </table>
                </div>  
                  <?php }else{ ?>
                    <div id="exp_table">
                    </div>
                  <?php  }  ?>
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
  /////////////////////////////////////
$("#save_recognized_mpn").on('click', function(){
    var kit_exp=$("#kit_exp").val();
    if($.trim(kit_exp)==''){
      alert('cannot insert empty experssion');
       $("#kit_exp").css({"background-color": "#ffcccc"});
      $("#kit_exp").focus();
      return false;
    }
    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/saveMpn';
    var bd_category=$("#bd_category").val();
    var bd_kit_mpn=$("#bd_kit_mpn").val();
    //var text=$("#bd_kit_mpn").text();
    var mpn_text = $("#bd_kit_mpn option:selected").text();
    //alert(text);return false;
    var bd_kit_object=$("#bd_kit_object").val();

    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'bd_category': bd_category,
      'bd_kit_mpn': bd_kit_mpn,
      'kit_exp': kit_exp,
      'bd_kit_object': bd_kit_object,
      'mpn_text': mpn_text,      
    },
    dataType: 'json',
    success: function (data) {
              alert("Record is inserted"); 
                displayRelatedExps();
       }
  });

  });

  /*////////////////////FOR SHOWING MPNS///////////////////////////////*/
$("#bd_category").on('change', function(){
  var bd_category = $("#bd_category").val();
  //alert(bd_category); return false;
  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getSpecificMpn',
    data: {'bd_category':bd_category},
   success: function (data) {
    //console.log(data);
      var specificsValues = [];
      var session_mpn='<?php if($this->session->userdata("bd_kit_mpn")){ echo $this->session->userdata("bd_kit_mpn"); } ?>';
          if (session_mpn !='') { var selected='selected'}else {
            var selected=''
          } 
      for (var i = 0; i < data.length; i++) {
          specificsValues.push('<option value="'+data[i].CATALOGUE_MT_ID+'" '+selected+'>'+data[i].MPN+'</option>'); //This adds each thing we want to append to the array in order.
      }
      //Since we defined our variable as an array up there we join it here into a string
      //$("#spec_name").html(specificsValues);
      
       specificsValues.join(" ");
      $("#kit_mpn").html("");
      $("#kit_mpn").append('<select style="width:160px;" class="form-control specifics selectDropdown selectpicker displayCatalogueMPN" data-live-search="true"  name="bd_kit_mpn" id="bd_kit_mpn"><option value="">-------Select----------</option>'+specificsValues.join(" ")+'</select>');
      $('.selectDropdown').selectpicker();
   }
  }); 
 });
/////////////////////////////////////////////////////
var bd_category ='<?php if($this->session->userdata("bd_recog_category")){ echo $this->session->userdata("bd_recog_category"); } ?>';
//alert(bd_category); return false;
if (bd_category != ''){
    $.ajax({
          dataType: 'json',
          type: 'POST',        
          url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getSpecificMpn',
          data: {'bd_category':bd_category},
         success: function (data) {
          //console.log(data);
          var specificsValues = []; 
          var session_mpn='<?php echo $this->session->userdata("bd_kit_mpn"); ?>';

          //alert(session_mpn); return false;
          for (var i = 0; i < data.length; i++) {
                      if (session_mpn !='') { 
                          if(data[i].CATALOGUE_MT_ID==session_mpn){
                              var selected='selected';
                            }else {
                                      var selected='';
                                    }
                      }
                      
              specificsValues.push('<option value="'+data[i].CATALOGUE_MT_ID+'" '+selected+'>'+data[i].MPN+'</option>');
              //This adds each thing we want to append to the array in order.
          }
          //Since we defined our variable as an array up there we join it here into a string
          //$("#spec_name").html(specificsValues);
          specificsValues.join(" ");
          $("#kit_mpn").html("");
          $("#kit_mpn").append('<select style="width:160px;" class="form-control specifics selectDropdown selectpicker displayCatalogueMPN" data-live-search="true"  name="bd_kit_mpn" id="bd_kit_mpn"><option value="">-------Select----------</option>'+specificsValues.join(" ")+'</select>');
          $('.selectDropdown').selectpicker();
    }
    });
}
////////////////END FOR SHOWING OBJECT////////////
$(document).on('change', '#bd_kit_mpn', function(){
      var bd_kit_mpn_id = $("#bd_kit_mpn").val();
      displayRelatedExps();
      //alert(bd_category); return false;
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getSpecificObject',
      data: {'bd_kit_mpn_id':bd_kit_mpn_id},
     success: function (data){
      //console.log(data);
        //Since we defined our variable as an array up there we join it here into a string
        //$("#spec_name").html(specificsValues);
        $("#bd_kit_object").val(data[0].OBJECT_NAME);
     }
    }); 
 });
////////////////END FOR SHOWING OBJECT////////////

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

if (bd_category != ''){
  //alert('dsffsff');
   displayRelatedExps();
}
/////////////////////////////////////////
  function displayRelatedExps(){
    //$(document).on('change', '#bd_kit_mpn', function(){
      // var bd_kit_session_mpn_id = '<?php //if($this->session->userdata("bd_kit_mpn")){ echo $this->session->userdata("bd_kit_mpn"); } ?>';
      // if (bd_kit_session_mpn_id == ''){
        var bd_kit_session_mpn_id= $("#bd_kit_mpn").val();
        //alert(bd_kit_session_mpn_id);
        //}else{
          //alert(bd_kit_session_mpn_id);
        //}
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/displayRelatedExps',
        data: {'bd_kit_mpn_id':bd_kit_session_mpn_id},
        success: function (data) {
        //console.log(data); return false; 
        if (data) {
              var row = [];  
              var confirm_msg= "return confirm('Are you sure to delete?');";
              var verify_msg= "return confirm('Are you sure to verify?');";
          for(var k = 0; k< data.length; k++){
              var del_url= '<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/deleteBdExpresion/'+data[k].MPN_RECOG_MT_ID;
              //var result_url= '<?php //echo base_url() ?>bigdata/c_recog_title_mpn_kits/showExpDetail/'+data[k].MPN_RECOG_MT_ID;
              var verify_url= '<?php echo base_url(); ?>bigdata/c_recog_title_mpn_kits/verifyExpData/'+data[k].MPN_RECOG_MT_ID;

              row.push('<tr id="'+(k + 1)+'"><td>'+(k + 1)+'</td><td><div class="edit_btun" style=" width: 90px; height: auto;"><button title="Edit Template" id="'+data[k].MPN_RECOG_MT_ID+'" class="btn btn-warning btn-xs exp-update" style="margin-right:6px;"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span> </button><a title="Delete Expresion" href="'+del_url+'" onclick="'+confirm_msg+'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div></td><td style="width: 450px;"><div id="display_normal_'+data[k].MPN_RECOG_MT_ID+'">'+data[k].EXPR_TEXT+'</div><div id="display_for_update_'+data[k].MPN_RECOG_MT_ID+'" style="display: none;"> <input style="width: 330px;" type="text" value="'+data[k].EXPR_TEXT+'" class="form-control" id="kit_exp_'+data[k].MPN_RECOG_MT_ID+'" name="exp_'+data[k].MPN_RECOG_MT_ID+'">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="exp_'+k+'" class="btn btn-success btn-sm update-btn" value="Save" id="'+data[k].MPN_RECOG_MT_ID+'"></div></td><td style="width: 300px;"><div class="col-sm-2"><div class="form-group"><button class="btn btn-primary btn-sm exp_results"  exp="'+data[k].MPN_RECOG_MT_ID+'" id="exp_res_'+data[k].MPN_RECOG_MT_ID+'">Result</button></div></div><div class="col-sm-2" style="margin-left: 25px;"><div class="form-group"><a title="Show result" onclick="'+verify_msg+'" href="'+verify_url+'" class="btn btn-success btn-sm pull-right">Verify</a></div></div></td><td><div class="col-sm-3"><div class="form-group"><input type="button" class="btn btn-success btn-sm" name="check_exp" id="check_exp_"'+k+'" value="Check Exp"></div></div></td></tr>'); //This adds each thing we want to append to the array in order.
           }
          //alert(row); return false;
          //$('#display_expresions tbody').html('');
          //$('#display_expresions tbody').append(row.join(""));

          $('#display_expresions').html('');
          $('#display_expresions').append('<table id="expresions_table" class="table table-responsive table-striped table-bordered table-hover" ><thead><th>Sr.#</th><th>Action</th><th>Expression</th><th>Result</th><th>Check Expression</th></thead><tbody>'+row.join("")+'</tbody></table>');


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

  //});
}
/*--- Onchange Mpn get its Objects start---*/
/*$("#bd_mpn" ).change(function() {

  var bd_mpn = $("#bd_mpn").val();

  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php //echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
   success: function (data) {
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);

    }

  });
});*/
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
//////////////// FOR SHOWING UNVERIFIED DATA ////////////  
  $('#unverified-info').on('click', function() {
      var bd_category = $("#bd_category").val();
      var url = "<?php echo base_url() ?>"+"bigData/c_recog_title_mpn_kits/totalUnverified/"+bd_category;
      window.open(url, '_blank');
  });  
////////////////END FOR SHOWING UNVERIFIED DATA////////////
});

///////////////////////////////
  /*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_brands',
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
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_mpns',
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
    }

  });
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue         =
  ================================================================*/
  $("#go_to_catalogue").on('click', function(event) {
    event.preventDefault();
    /* Act on the event */
    var bd_cat = $("#bd_category").val();
    var kit_mpn = $("#bd_kit_mpn").val();
    if (bd_cat == '' || typeof bd_cat == 'undefined' || typeof kit_mpn == 'undefined' || kit_mpn == '') {
      alert("Warning: First select Category ID and MPN from start!");
    }else {
      var url = '<?php echo base_url(); ?>catalogue/c_itemCatalogue/getCategorySpecifics/'+bd_cat+'/'+kit_mpn;
      window.open(url, '_blank');
    }

  });

/*===============================================
=            Edit BY YOusaf 9/6/2017            =
===============================================*/

$("#save_mpn_kit").on('click', function(){
    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/saveMpnKit';
    var bd_kit_mpn= $("#bd_kit_mpn").val();
    var bd_object = $("#bd_object").val();
    var bd_mpn = $("#bd_mpn").val();
    var kit_qty = $("#kit_qty").val();
    //console.log(bd_kit_mpn, bd_object); return false;
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
          alert("Success: Component is created!");
        }else if(data=0){
          alert("Error: Component creation is failed! Try Again");
        }else if(data= "exist"){
          alert("Warning: Component is already exist!");
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
    }
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


/*$('#bd_object').on('change',function(){

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
});*/


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

  </script>