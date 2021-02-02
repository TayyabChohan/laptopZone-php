<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
?>
<style>
.zoomContainer{ z-index: 9999;}
  .zoomWindow{ z-index: 9999;}
.locked{
  color: green;
}
.unlocked{
  color: red;
}
.me_unlocked{
  color: yellow;
}
</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Component Identification - De-Kitting - PK
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Component Identification - De-Kitting - PK</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
    
    <!-- Master Barcode Search Box section Start -->
       

<!-- 
          model dialogue show  --> 
  <div id="success-modal" class="modal" role="dialog" ">
      <div class="modal-dialog" style="height: 100%; width: 90%;" >
        <!-- Modal content-->
        <div class="modal-content" >
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add MPN</h4>
          </div>
              <div class="modal-body" >
                <section class="" > 







                  <!-- //dekit image start -->

                  <div class="row">
                    <div class="col-sm-12">
                        <div id="" class="col-sm-12 b-full">
                         <div id="" class="col-sm-12 docs-galley" style="padding-top: 12px;"> 
                        
                          
                           <ul id="getsortable" style="color:black; height: auto !important; width: 100%;">  
                          </ul>
                          
                        
                          </div>
                        </div>
                    </div>
                  </div>
                  <!-- //dekit image end -->
















                    <div class="col-sm-12">
                      <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Master MPN" class="control-label">MASTER MPN:</label>
                    <input class="form-control" type="text" name="master_mpn" id="master_mpn" value="" readonly required> 
                    <input class="form-control" type="hidden" name="master_mpn_id" id="master_mpn_id" value=""> 
                  </div>
                 </div>
                 <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Master MPN Description" class="control-label">Master MPN DESCRIPTION:</label>
                    <input class="form-control" type="text" name="master_mpn_desc" id="master_mpn_desc" value="" readonly> 
                  </div>
                 </div>
                 <div class="col-sm-2 ">
                    <div class="form-group">
                      <label for="MPN">Technician Remarks:</label>
                      <input class="form-control" type="text" name="technician_remark" id="technician_remark" value="" readonly>
                    </div>
                  </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Category" class="control-label">CATEGORY :</label>
                   

                    <input class="form-control" type="text" name="mpn_category" id="mpn_category" value="" required> 
                    
                    <input class="form-control" type="hidden" name="mpn_row" id="mpn_row" value=""> 
                  </div>
                </div>
                <div class="col-sm-3 ">
                    <div class="form-group">
                      <label for="MPN">Enter Any Keyword:</label>
                      <input class="form-control" type="text" name="get_keyword" id="get_keyword" placeholder="Enter Any Keyword" value="" >
                      <button style="margin-top:5px;" type="button" id="get_sold_price" title="Pull Sold Price" class="btn btn-warning btn-xs pull-left">Pull Average Sold</button>
                    </div>
                  </div>
                  
                 
                 
                </div>
                  <div class="col-sm-12" style="margin-top: 15px;">
                  
                  <div class="col-sm-2">
                    <div class="input-group input-group-md">
                      <label for="MPN">MPN:</label> 
                      <input class="form-control" type="text" name="mpn" id="mpn" value="" required>
                      
<!-- 
                      <button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-success btn-xs get_mpn_desc_api"   style="height: 28px; margin-bottom: auto;">Get Description</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-danger btn-xs get_mpn_history"   style="height: 28px; margin-bottom: auto;">Get History</button> -->

                    </div>
                  </div>



                  <div class="col-sm-4">
                     <label for="">Mpn Description:</label>  Maximum of 80 characters - 
                        <span id="charNum" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left</span><br/>
                    <div class="input-group input-group-md">
                       

                        <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onKeyUp="countChar(this)"  value="" >
                        <div class="input-group-btn">
                        <button class="btn btn-info get_mpn_desc_api" title="Search on Ebay " id="get_mpn_desc_api" type="button"><i class="glyphicon glyphicon-search"></i><button class="btn btn-danger get_mpn_history" title="Search in System " id="get_mpn_history" type="button"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                  </div>

                  <div class="col-sm-1">
                    <div class="form-group">
                      <label for="MPN BRAND">BRAND:</label>
                      <input class="form-control" type="text" name="mpn_brand" id="mpn_brand" value="" required>
                    </div>
                  </div>
                   
                  <div class="col-sm-1 ">
                    <div class="form-group">
                      <label for="MPN">Avg Sold:</label>
                      <input class="form-control" type="text" name="avg_sal_pric" id="avg_sal_pric" value="" >
                    </div>
                  </div>
                  <div class="col-sm-2 ">
                    <div class="form-group">
                      <label for="MPN">Remarks:</label>
                      <input class="form-control" type="text" name="dekitted_remark" id="dekitted_remark" value="" >
                    </div>
                  </div>
                  <div class="col-sm-2">
                   <div class="form-group" id="cataObject">
                      <label for="Conditions" class="control-label">OBJECT:</label>
                     <input class="form-control" type="text" name="mpn_object" id="mpn_object" value="" required ="">  
                     <input class="form-control" type="hidden" name="mpn_object_id" id="mpn_object_id" value="" >  
                     <input class="form-control" type="hidden" name="mpn_prev_barcode" id="mpn_prev_barcode" value="" > 
                     <input class="form-control" type="hidden" name="deki_get_det_id" id="deki_get_det_id" value="" > 
                      <button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-success btn-xs get_new_object">Get Object</button>
                     <div id="object_dd" style="margin-top:5px; width: 190px;"></div> 
                    </div>
                </div>
                
                  
                  
                 
                </div>  
                <!-- <div class="col-sm-12">
                  <div class="col-sm-3 ">
                    <div class="form-group">
                      <label for="MPN">Remarks:</label>
                      <input class="form-control" type="text" name="dekitted_remark" id="dekitted_remark" value="" >
                    </div>
                  </div>
                </div> -->
                <div class="col-sm-12">

                <div class="col-sm-12 ">
                    <input type="button" style="margin-bottom: 10px; width:200px; " id="add_new_mpn" name="add_new_mpn" value="Save" table_row ="" class="btn btn-success  pull-right ">
                  </div>
                  <div id="my_history">
                  </div>            
                  
                </div>
                <div class="col-sm-12">
                
                  <div id="my_Categories_result">
                  </div>            
                  
                </div>  
              <!-- search mpn api result -->
              <div class="loaders text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>

                </section>                  
              </div>
          <div class="modal-footer">
            
              
                       
                    

          </div>
                
        </div>
      </div>

</div> 
<!-- 
          model dialogue show end -->      
       <!-- Master Barcode Search Box section End -->    
       <!-- Barcode Detail Table Start  -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Component-Identification PK Details</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
                <div class="col-sm-12">
                  <a target="_blank" href="<?php echo base_url();?>dekitting_pk_us/c_listing_pk_us" class="btn btn-primary pull-right">Listing-pk-us</a>

                </div>
              <!-- Print Message -->
              <div class="col-sm-12">

                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                  <div class="form-group text-center emptyDiv">
                    <div id="printMessage">
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                </div>                
              </div>
              <!-- End Print Message -->
              <div class="box-body form-scroll"> 
                <!-- <div class="col-sm-12">
                  <div class="col-sm-1 col-sm-offset-5">
                    <div class="form-group pull-left">
                      <button type="button" title="Asign MPN"  class="btn btn-success col-sm-offset-1 asign_mpn" id="asign_mpn">Asign MPN</button>
                    </div>
                  </div>
                </div> -->
              <div class="col-md-12"><!-- Custom Tabs -->
              <form>
               <table id="dekit_pk_us" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th colspan="2" class="text text-center" style="background: #E8E8E8; color: black;">Component
                      </th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th colspan="2" class="text text-center" style="background: #E8E8E8; color: black;">Main Item
                      </th>
                      <th></th>
                    </tr>
                    <tr> 
                      <th>Sr.#</th>
                      <th>Item Picture</th>
                      <th>Lock</th>
                      <th>Barcode</th>
                      <th>BARCODE NOTES</th>
                      <th>Select</th>
                      <th>Object</th>
                      <th>Mpn</th>
                      <th>Mpn Description</th>
                      <th>Brand</th>
                      <th>Picture Notes</th>
                      <th>Pic Text</th>
                      <th>BIN/Rack</th>
                      <th>Master Barcode</th>
                      <th>MPN Description</th>
                      <th>Remarks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 

                    if ($items->num_rows() > 0) {
                      $query = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
                      $master_qry = $query->result_array();
                      $master_path = $master_qry[0]['MASTER_PATH'];                      
                      $i = 1;
                      $img = '';
                      foreach ($items->result_array() as $item) {

                        $barcode = $item['BARCODE_PRV_NO'];
                        $query = $this->db->query("SELECT FOLDER_NAME FROM LZ_DEKIT_US_DT WHERE BARCODE_PRV_NO = $barcode");
                        $master_qry = $query->result_array();
                        $folder_name = $master_qry[0]['FOLDER_NAME'];

                        $dir = $master_path.$folder_name;
                        $m_dir = $master_path.$folder_name.'/thumb/';

                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

                      ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                        <div id="item_picture_<?php echo $i; ?>">
                          <?php
                            if(is_dir(@$m_dir)){
                              $iterator = new \FilesystemIterator(@$m_dir);
                              if (@$iterator->valid()){ 
                                $images = scandir($m_dir);
                                if (count($images) > 0) { // make sure at least one image exists
                                    $url = $images[2]; // first image
                                    $img = file_get_contents($m_dir.$url);
                                    // var_dump($img);exit;
                                    $img =base64_encode($img);
                                    // $dir_path[$i] = $img;
                                }
                              }else{
                                $img ='';
                              }
                            }else{
                              $img ='';
                            }
                          ?>
                          <?php 
                          $master_barcode = $item['BARCODE_NO'];
                          $child_barcode = $item['BARCODE_PRV_NO'];
                          $comp_condition = $item['CONDITION_ID'];
                          if($img !=''){ ?>
                            <img src="data:image;base64,<?php echo $img;?>" id="thumbnail<?php echo $i;?>"  class="sort_img up-img"/>
                            <div style="margin-left: 20px; font-size: 12px;">
                           <a title="Add Pics" class="btn btn-link btn-xs addPic " id="addPic<?php echo $i; ?>" style=" font-size: 13px;" href="<?php echo base_url().'dekitting_pk_us/c_comp_identi_pk/showAllPictures/'.$master_barcode.'/'.$child_barcode.'/'.$comp_condition; ?>" target="_blank">show all</a>
                          </div>
                          <?php } ?>
                          
                        </div>
                      </td>
                        <td>
                          <div class="locks" id="<?php echo $item['LZ_DEKIT_US_DT_ID']; ?>" val="<?php echo $i; ?>" ob="<?php echo $item['OBJECT_ID']; ?>" cat="<?php echo $item['CATEGORY_ID']; ?>" brcd="<?php echo $item['BARCODE_NO']; ?>" brch="<?php echo $item['BARCODE_PRV_NO']; ?>">
                            <?php
                            $user_id = $this->session->userdata('user_id');
                             if($item['LOCK_STATUS'] == 0){?>
                            <div class="red_lock">
                              <i class="fa fa-lock btn btn-success btn-sm" aria-hidden="true"></i>
                            </div>
                            <?php }elseif($item['LOCK_STATUS'] == 1 && $item['IDENTIFIED_BY'] != $user_id){ ?>
                            <div class="green_lock">
                              <i class="fa fa-lock btn btn-danger btn-sm" aria-hidden="true"></i>
                            </div> 
                            <?php }elseif($item['LOCK_STATUS'] == 1 && $item['IDENTIFIED_BY'] === $user_id){ ?>
                            <div class="yellow_lock">
                              <i class="fa fa-lock btn btn-warning btn-sm" aria-hidden="true"></i>
                            </div> 
                            <?php } ?>
                          </div> 
                        </td>
                        
                        <td><?php echo $item['BARCODE_PRV_NO']; ?></td>
                        <td><?php echo $item['BARCODE_NOTES']; ?></td>
                        <td>
                        <div style="width: 70px;">
                          <?php  if (@$item['LOCK_STATUS'] == 1 && @$user_id == @$item['IDENTIFIED_BY']) { ?>
                                <input type="checkbox" name="component" ckbx_name="<?php echo @$item['OBJECT_NAME']; ?>" id="<?php echo $item['LZ_DEKIT_US_DT_ID']; ?>" chid="comp_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes" style="width: 60px;" > 
                          <?php  }else if(@$item['LOCK_STATUS'] == 0){ ?>
                                <input type="checkbox" name="component" ckbx_name="<?php echo @$item['OBJECT_NAME']; ?>" id="<?php echo $item['LZ_DEKIT_US_DT_ID']; ?>" chid="comp_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes" style="width: 60px;" > 
                        <?php  }else{ ?>
                          <input type="checkbox" name="component" ckbx_name="<?php echo @$item['OBJECT_NAME']; ?>" id="<?php echo $item['LZ_DEKIT_US_DT_ID']; ?>" chid="comp_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes" style="width: 60px;" disabled>
                        <?php
                      }  
                          ?>
                          
                           
                        </div>
                      </td>
                        <td><?php echo $item['OBJECT_NAME']; ?></td>
                        <td style="width: 344px;">
                          <div class="mpn_dropdown" id="mpn_dropdown_<?php echo $i; ?>" style="width: 344px;">
                          </div>
                        </td>
                         <td>
                            <?php
                              $desc = @$item['MPN_DESCRIPTION'];
                              $item_desc = substr($desc,0,80);
                              //echo substr($title,0,80);
                            ?>
                            <span>Maximum of 80 characters - 
                            <input class="c-count" type="text" id='titlelength<?php echo $i;?>' name="titlelength" size="3" maxlength="3" value="80" readonly style=""> characters left</span><br/>
                            <input type="text" name="mpn_desc" id="mpn_desc<?php echo $i;?>" class="form-control mpn_desc" onKeyDown="textCounter(this,80);" maxlength="80" onKeyUp="textCounter(this,'titlelength<?php echo $i;?>' ,80)"  value="<?php echo htmlentities(@$item_desc); ?>" style="width: 340px;">
                        </td>
                        <td>
                            <?php
                              // $desc = @$item['MPN_DESCRIPTION'];
                              // $item_desc = substr($desc,0,80);
                              //echo substr($title,0,80);
                            ?>
                            <span>Max of 50 characters - 
                            <input class="c-count" type="text" id='brand_title<?php echo $i;?>' name="brand_title" size="3" maxlength="3" value="50" readonly style=""><br/>
                            <input type="text" name="brand_desc" id="brand_desc<?php echo $i;?>" class="form-control brand_desc" onKeyDown="textCounter(this,50);" maxlength="50" onKeyUp="textCounter(this,'brand_title<?php echo $i;?>' ,50)" value="" placeholder = "Enter Brand" style="width: 200px;">
                        </td>
                        <td>
                        <div style="width: 250px;">
                          <?php echo $item['PIC_NOTES']; ?>
                        </div>
                      </td>
                        <td><?php echo $item['PIC_TEXT']; ?></td>
                        <td><?php echo $item['BIN_ID']; ?></td>
                        <td><?php echo $item['BARCODE_NO']; ?></td>
                        <td><?php echo $item['MPN_DESCRIPTION']; ?></td>
                        <td><input type="text" name="dekitting_remarks" id="dekitting_remarks" class="form-control" value="<?php echo $item['DEKIT_REMARKS'];?>"></td>
                      </tr>
                      <?php
                      $i++;
                      } 
                    }
                   ?>
                  </tbody>
                </table> <!-- nav-tabs-custom -->
              </form>
            </div>
            <!-- <div class="col-sm-12">
                  <div class="col-sm-1 col-sm-offset-5">
                    <div class="form-group pull-left">
                      <button type="button" title="Asign MPN"  class="btn btn-success col-sm-offset-1 asign_mpn" id="asign_mpn">Save</button>
                    </div>
                  </div>
                </div> -->
          </div><!-- /.col --> 
        </div>
      </div>
    <!-- Barcode Detail Table End  -->
    <!-- Item Specific Start -->
      <input class="form-control" type="text" name="mpn_category" id="mpn_category" value="" required> 
        <!-- Item Specific end --> 
        <!-- /.col -->
      </section>
      <!-- /.row --> 
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>

    <!-- /.content -->
    <!-- Modal -->
<div id="show_all_pics" class="modal modal-info fade show_all_pics" role="dialog" style="width: 100%;">
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
                        <div class="box-body form-scroll">
                          <div id="" class="col-sm-12 p-t"> 
                           <ul id="sortable" style="color:black; height: auto !important; width: 100%;">  
                          </ul>
                            <div id="" class="col-sm-10 p-t"> 

                            </div>

                            <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                              <div class="col-sm-8" id="">
                                 <div id="upload_message">
                            
                                </div>
                                  <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                              </div>
                               
                                <div class="col-sm-4">
                                  <div class="form-group pull-right">
                                    <input id="master_reorder_dekit" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                                    <span><i id="<?php if(@$del_master_all){echo $del_master_all;}?>" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all_dekit">Delete All</i></span>
                                </div>
                              </div>
                                  
                                <!--</form>-->
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
</div>
  </div>
          
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>

<script>
  function countChar(val) {
    var len = val.value.length;
    //console.log(len);
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(parseInt(parseInt(80) - parseInt(len)));
    }
  }
$(document).ready(function(){
  /////////////////////////
   var g= 0;
      $('#dekit_pk_us thead tr').eq(1).find("th").each(function () {
          var title = $(this).text();
            if (g >2 && g!=4 && g!=6 && g!=7 && g!=8 && g!=9 && g!=14) {
             if(g==11 || g==5){
                  $(this).html('<input type="text" class="form-control col-search-'+g+'" placeholder="'+title+'" style="width:130px;"/>');
              }else if(g==13){
                $(this).html('<input type="text" class="form-control col-search-'+g+'" placeholder="'+title+'" />');
              }else{
                $(this).html('<input type="text" class="form-control col-search-'+g+'" placeholder="'+title+'" style="width:100px;" />');
              }
          }
          g++;
      });
  ////////////////////////////////
 
 $('#dekit_pk_us').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 500,
    "aLengthMenu": [[25, 50, 100, 200,500], [25, 50, 100, 200,500]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    "createdRow": function( row, data, dataIndex){
      if(data){
          $(row).find(".updateEst").closest( "tr" ).addClass('rowBg');
          }
        }
  });

    /////////////////////////////////
     var table = $('#dekit_pk_us').DataTable();
        table.columns().every(function () {
            var that = this;
            $('input', this.header()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    /////////////////////////////////
   $(document).on('click', '.locks', function(event) {
    // $('#success-modal').modal('show');
    
    var id  = $(this).attr("id");
    $('#deki_get_det_id').val(id);
    
    //return false;
     event.preventDefault();
     var url = '<?php echo base_url();?>dekitting_pk_us/c_comp_identi_pk/get_mpns';
     var row_id                 = $(this).attr("val");
     //var id                     = $(this).attr("id");
     var object_id              = $(this).attr("ob");
     var category_id            = $(this).attr("cat");
     var barcode_no             = $(this).attr("brcd");
     var child_barcode_no       = $(this).attr("brch");
     //console.log(row_id, id, object_id, category_id); return false;
     //alert(url); return false;
     $(".loader").show();
     $.ajax({
       url: url,
       type: 'POST',
       dataType: 'json',
       data: {'object_id': object_id ,  'category_id': category_id, 'dekit_pk_us':id, 'child_barcode_no':child_barcode_no, },
        success:function(data){
          console.log(data);
          if (data.flag[0] == 0 || data.flag[0]== null) {
                alert('Warning: Item is already unlocked by '+data.emp_name+'!'); return false;
          }else if(data.flag[0] == 1){
            //console.log(data);
                var k = 1;
                 $('#dekit_pk_us tr').find("td i").each(function() {
                  //alert(row_id+'::'+k);
                  if (row_id == k) {
                    $('#dekit_pk_us tr').eq(parseInt(parseInt(row_id)+parseInt(1))).find('td i').removeClass('fa-lock').addClass('fa-unlock-alt');
                  }else{
                    $('#dekit_pk_us tr').eq(parseInt(parseInt(k)+parseInt(1))).find('td i').removeClass('fa-unlock-alt').addClass('fa-lock');
                    $('#dekit_pk_us tr').eq(parseInt(parseInt(k)+parseInt(1))).find('td .mpn_dropdown').html('');
                  }
                  k++;
                });
                if (data.mpn.length == 0) {
                    alert("No mpn is found"); 
                  }
                  var mpns = [];
                    for(var i = 0;i<data.mpn.length;i++){

                    mpns.push('<option value="'+data.mpn[i].CATALOGUE_MT_ID+'">'+data.mpn[i].MPN+'</option>');
                }
                //////////////////FOR SHOW PICTURE/////////////////////////
                for(var i=0;i<data.det.length;i++){
                  // console.log(data.flag[i]);return false;
                  var j = i + 1;
                  var cond = '';
                  if(data.det[i].CONDITION_ID == 1000){
                    cond = 'New';
                  }
                  if(data.det[i].CONDITION_ID == 3000){
                    cond = 'Used';
                  }
                  if(data.det[i].CONDITION_ID == 1500){
                    cond = 'New Other';
                  }
                  if(data.det[i].CONDITION_ID == 2000){
                    cond = 'Manufacturer refurbished';
                  }
                  if(data.det[i].CONDITION_ID == 2500){
                    cond = 'Seller refurbished';
                  }
                  if(data.det[i].CONDITION_ID == 7000){
                    cond = 'For parts or not working';
                  }
                  var img = '<p style="font-weight:bold;width:140px;color:red;" class="sort_img up-img">Picture Not Found !</p>';
                  if(data.flag[i] == true){
                  
                    var source = data.dir_path[i];
                    
                    img = '<img src="data:image;base64,'+source+'" id="thumbnail'+i+'"  class="sort_img up-img">';

                  }
                  var dekit = data.det[i].DEKIT_REMARKS;
                  if( typeof dekit == 'object'){
                    dekit = JSON.stringify(dekit);
                    dekit = '';
                    // alert(dekit);
                  }

                }
                $('#item_picture_'+row_id).html("");
                $('#item_picture_'+row_id).html(img);
                //////////////////END FOR SHOW PICTURE/////////////////////////
                  $('#mpn_dropdown_'+row_id).html("");
                  $('#mpn_dropdown_'+row_id).append('<div style="width:180px; float:left;"><select name="dekit_mpn" id="'+row_id+'" class="form-control dekit_mpn" data-live-search="true" required ><option value="0">---select---</option>'+mpns.join("")+'</select></div><div style="width:150px; float: left; margin-left: 10px;"><button type="button" title="Save MPN"  class="btn btn-success save_mpn" id="'+row_id+'">Save</button><button type="button" title="Add MPN"  class="btn btn-warning add_mpn" id="'+id+'" obj="'+object_id+'" cat_id="'+category_id+'" bar="'+barcode_no+'" chbar="'+child_barcode_no+'" style="margin-left:12px;">Add MPN</button></div>');
                  $('.dekit_mpn').selectpicker();

              
            
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
     })
   }); 
  
   ////////////////////////////////////


 

    var row_id = 0;
   $(document).on('click', '.add_mpn', function(event) {
     event.preventDefault();
     $(".loaders").show();
     $("#mpn_brand").val("");
      $("#mpn").val("");
      $("#mpn_description").val("");
      $("#get_keyword").val("");
      $("#dekitted_remark").val("");
      $("#obj_dd").val("");
      $("#avg_sal_pric").val("");
      $("#object_dd").html('');


     $('#charNum').text(80);
      var table = $('body #dekit_pk_us').DataTable();
      row_id = $(this).attr("id");
      $("#add_new_mpn").attr("table_row",row_id);

    //var row_id = 0;
    //console.log(row_id);
      var search_val = '';
      table.search(search_val).draw();
      
     var url = '<?php echo base_url();?>dekitting_pk_us/c_comp_identi_pk/get_mpn_data';
     var row_id             = $(this).attr("id");
     var object_id          = $(this).attr("obj");
     var category_id        = $(this).attr("cat_id");
     var barcode_no         = $(this).attr("bar");
     var ch_barcode_no         = $(this).attr("chbar");
     var object_name        = $(this).closest('tr').find('td').eq(5).text();
     var remarks        = $(this).closest('tr').find('td').eq(14).find("input").val();
     $(".loader").show();
     $.ajax({
       url: url,
       type: 'POST',
       dataType: 'json',
       data: {'object_id': object_id ,  'category_id': category_id, 'barcode_no':barcode_no},
        success:function(data){
            if (data !='') {
              
              $("#mpn_category").val(category_id);
              $("#master_mpn").val(data[0].MPN);
              $("#master_mpn_desc").val(data[0].MPN_DESCRIPTION);
              $("#master_mpn_id").val(data[0].CATALOGUE_MT_ID);
              //$("#mpn_brand").val(data[0].BRAND);
              
              $("#avg_sal_pric").val(data[0].AVG_SELL_PRICE);
              $("#mpn_object").val(object_name);
              $("#mpn_row").val(row_id);
              $("#mpn_object_id").val(object_id);
              $("#mpn_prev_barcode").val(ch_barcode_no);

              $("#technician_remark").val(remarks);
            }
              $('#success-modal').modal('show');
              

              //get dek_images

            $.ajax({
            url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/get_my_dekited_pic', 
            type: 'post',
            dataType: 'json',
            data:{'barcode':ch_barcode_no},
            success:function(data){
              $(".loaders").hide();
              
              var dirPics = [];
              // $('#sortable').html("");
              // console.log('length:'+data.dekitted_pics.length+'');
              //console.log(data);
              for(var i=0;i<data.dekitted_pics.length;i++){
                values = data.uri[i].split("/");
             
                one = values[4].substring(1);

                //console.log(one);//return false;
                var picture = data.dekitted_pics[i]; 
                
                var img = '<img style="width: 220px; height: 180px;" class="sort_img up-img popup_zoom_01" id="'+data.uri[i]+'" name="dekit_image[]" src="data:image;base64,'+picture+'"/>';

                dirPics.push('<li style="width: 230px; height: 220px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;" id="'+values[4]+'"> <span class="tg-li"> <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);  width:99%; height:99%; background: #eee!important; margin:5px;">'+img+' <input type="hidden" name="" value=""> <div class="text-center" style="width: 100px;"> <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span> <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash specific_delete"></i></span> </div> </div> </span> </li> ');
              }

              $('#getsortable').html("");
              $('#getsortable').append(dirPics.join(""));
              //$('.popup_zoom_01').elevateZoom();
              
              $('.popup_zoom_01').elevateZoom({
                //zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 600,
                zoomWindowFadeOut: 600,
                easing : true,
                scrollZoom : true
               }); 

              
              }
            });

              //get dek_images

            //}
             
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
     })
   });
   ////////////////////////////////
    $(document).on('click', '.save_mpn', function(event) {

     event.preventDefault();
     var arr                =[];
     var dekit_us_id        =[];
     var remarks            =[];
     var mpn_description    =[];
     var brand_desc         =[];
    
     var fields = $("input[type='checkbox']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one Component'); 
        return false;
      }

      var tableId="dekit_pk_us";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[type='checkbox']:checked"), function()
      {            
        arr.push($(this).val());
      });

    //console.log(arr.length); return false;
     
     var url = '<?php echo base_url();?>dekitting_pk_us/c_comp_identi_pk/update_mpn';
     var row_id = $(this).attr("id");

     var catalogue_mt_id    = $('#dekit_pk_us tr').eq(parseInt(parseInt(row_id)+parseInt(1))).find('td').find('select').val(); 
     
     for(var j = 0; j< arr.length; j++){
         //alert(row_id); return false;
         var dekit_id = '';
         var remark = '';
         var mpn_desc = '';
         var brand_description = '';

         dekit_id = $('#dekit_pk_us tr').eq(parseInt(parseInt(arr[j])+parseInt(1))).find('td').find(".locks").attr("id");
          dekit_us_id.push(dekit_id);

        remark            = $('#dekit_pk_us tr').eq(parseInt(parseInt(arr[j])+parseInt(1))).find('td').find('input[name="dekitting_remarks"]').val(); 
        remarks.push(remark);

        mpn_desc    = $('#dekit_pk_us tr').eq(parseInt(parseInt(arr[j])+parseInt(1))).find('td').find('input[name="mpn_desc"]').val(); 
        mpn_description.push(mpn_desc);

        brand_description         = $('#dekit_pk_us tr').eq(parseInt(parseInt(arr[j])+parseInt(1))).find('td').find('input[name="brand_desc"]').val();
        brand_desc.push(brand_description);
     }
     //console.log(dekit_us_id, catalogue_mt_id, remarks, mpn_description, brand_desc);
     //return false;
     if (catalogue_mt_id == 0 || catalogue_mt_id == '') {
      alert('Warning: MPN  is required');
      return false;
        }else if( mpn_description.length == '' || mpn_description.length == 0 ){
          alert('Warning: MPN description is required');
      return false;
        }
        // code section added by adil asad 1-23-2018 start
        else if(brand_desc.length == '' || brand_desc.length == 0){
          alert('Warning: Brand Name is required');
          return false;
        }else{ // code section added by adil asad 1-23-2018 end
             $(".loader").show();
              //console.log(row_id, dekit_us_id, catalogue_mt_id, remarks); return false;
              //alert(url); return false;
             $.ajax({
               url: url,
               type: 'POST',
               dataType: 'json',
               data: {'dekit_us_id': dekit_us_id, 'catalogue_mt_id': catalogue_mt_id, 'remarks': remarks, 'mpn_description': mpn_description,'brand_desc':brand_desc},
                success:function(data){
               alert('Success: Item is identified!');

                      //debugger; 
                      for(var j = 0; j< arr.length; j++){    
                      $("#"+dekit_us_id[j]).closest('tr').fadeOut(1000, function() {
                      $("#"+dekit_us_id[j]).closest('tr').remove();
                      });
                    }
                  window.location.reload();
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
     } ////end of mpn check
    
   });
   ////////////////////////////////

 $("#add_new_mpn").click(function(){
  var dekit_us_det_id = $('#deki_get_det_id').val();
    var arr                     = [];
    var dekit_us_id             = [];
    

    //var row_id                  = $(this).attr('table_row');
    var mpn_row                 = $("#mpn_row").val();
    var cat_id                  = $("#mpn_category").val();
    var master_mpn              = $('#master_mpn_id').val();
    //var object_id               = $("#mpn_object_id").val();
    var object_id               = $("#mpn_object").val();
    var mpn_prev_barcode        = $("#mpn_prev_barcode").val();
    var dekitted_remark         = $("#dekitted_remark").val();
    var mpn_brand               = $("#mpn_brand").val();
    var mpn                     = $("#mpn").val();
    var mpn_desc                = $('#mpn_description').val();
    var avg_sal_pric            = $('#avg_sal_pric').val();
    /////////////////////////////
    var dekit_us_id=[];
    var dekit_index=[];
      //var cat_id = $(this).attr("ct_id");
      //console.log(dekit_us_id,category_id); return false;
      var oTable = $('#dekit_pk_us').dataTable();
      var rowcollection =  oTable.$(".checkboxes:checked", {"page": "all"});
      rowcollection.each(function(index,elem){
          dekit_us_id.push($(elem).attr('id'));
          dekit_index.push($(index));
      });
      if(dekit_us_id.length == 0){
        dekit_us_id.push(dekit_us_det_id); 
      }
   
  if( mpn_brand == '' || mpn_brand == null){
    alert('Warning: Brand name is required!');
    $("#mpn_brand").focus();
      return false;    
  }else if( mpn == '' || mpn == null){
    alert('Warning: Please insert MPN!');
    $("#mpn").focus();
    return false;
  }else if( mpn_category == '' || mpn_category == null){
    alert('Warning: Please insert Category!');
    $("#mpn_category").focus();
    return false;
  }else if(mpn_desc == '' || mpn_desc == null){
    alert('Warning: MPN Description is required!');
    $("#mpn_desc").focus();
    return false;
  }
  else if(avg_sal_pric == '' || avg_sal_pric == null){
    alert('Warning: Average Sold Price is required!');
    $("#avg_sal_pric").focus();
    return false;
  }
    //console.log(mpn_category, mpn, mpn_desc, object_id);
   // return false;
   
    $(".loader").show();
     $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_comp_identi_pk/addCataMpn',
        data: { 'mpn_desc':mpn_desc,'mpn' : mpn,'master_mpn':master_mpn,'cat_id':cat_id,'object_id':object_id,'mpn_prev_barcode':mpn_prev_barcode, 'mpn_brand':mpn_brand,'dekitted_remark':dekitted_remark,'dekit_us_id':dekit_us_id,'avg_sal_pric':avg_sal_pric},
        success: function (data) {
          $(".loader").hide();
         if(data.check == 0){
            alert('Error! Record is not inserted.');
            return false;
          }else if(data.check == 1){
                  $('#success-modal').modal('hide');
                  var table = $('#dekit_pk_us').dataTable();
                  $("#dekit_pk_us tbody tr td input:checkbox:checked").each( function () {
                    table.fnDeleteRow( $(this).parents('tr')[0], false );
                    } );
                    table.fnDraw();
                    
              }else{//} if(data.check == 2){
            alert('Record Saved.');

            $('#success-modal').modal('hide');
            var table = $('#dekit_pk_us').dataTable();
                  $("#dekit_pk_us tbody tr td input:checkbox:checked").each( function () {
                    table.fnDeleteRow( $(this).parents('tr')[0], false );
                    } );
                    table.fnDraw();
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
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
/*--- Onchange Mpn get its Objects start---*/
$(document).on('change', '.dekit_mpn', function(){
  var bd_mpn = $(this).val();
  var row_id = $(this).attr("id");
  if (bd_mpn =='' && bd_mpn == 0) {
    return false;
  }else{
      $(".loader").show();
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_comp_identi_pk/showMpnDesc',
        data: {'bd_mpn' : bd_mpn},
        success: function (data) {
        $('#dekit_pk_us tr').eq(parseInt(parseInt(row_id)+parseInt(1))).find('td').eq(6).find('.mpn_desc').val(data[0].MPN_DESCRIPTION);
        // code section added by adil asad 1-23-2018 start
        $('#dekit_pk_us tr').eq(parseInt(parseInt(row_id)+parseInt(1))).find('td').eq(7).find('.brand_desc').val(data[0].BRAND);
        // code section added by adil asad 1-23-2018 end
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
            var shipping_cost2 = data[i].SHIPPING_COST;
            var sale_price2 = data[i].SALE_PRICE;

            qty_dets.push('<tr> <td id = "qty_sr_no'+i+'" style="color:black;width:100px">'+parseFloat(parseFloat(i)+parseFloat(1))+'</td> <td id = "qty_ebay_id'+i+'" style="color:black;width:100px">'+data[i].EBAY_ID+'</td> <td id="qty_title'+i+'" style="color:black;width:200px;">'+data[i].TITLE+'</td> <td id="qty_conditionName'+i+'" style="color:black;width:100px;">'+data[i].CONDITION_NAME+'</td> <td id="qty_soldPrice'+i+'" style="color:black;width:70px;">'+parseFloat(sale_price2).toFixed(2)+'</td> <td id="qty_shippingCost'+i+'" style="color:black;width:70px;">'+parseFloat(shipping_cost2).toFixed(2)+'</td> <td id="qty_startTime'+i+'" style="color:black;width:100px;">'+data[i].START_TIME+'</td> <td id="qty_saleTime'+i+'" style="color:black;width:100px;">'+data[i].SALE_TIME+'</td> </td> <td id="qty_seller_id'+i+'" style="color:black;width:100px;">'+data[i].SELLER_ID+'</td></tr>') ;
          }

          $('#rss_tds').text('');
          $('#rss_tds').append(qty_dets.join(""));


        }
    });
  
  // alert(category_id);
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue                        =
  ================================================================*/


});


$(document).on('click','#get_sold_price',function(){ 

    var category_id        = $("#mpn_category").val(); 
    var get_keyword        = $("#get_keyword").val(); 

    if(get_keyword == '' || get_keyword == null){ 
      $('#get_keyword').focus();
      alert('keyword Is Null');
      return false;

    } 
    if(category_id == '' || category_id == null){ 
      $('#mpn_category').focus();
      alert('Category Is Null');
      return false;

    }    
    
    // console.log(get_keyword);
    // return false;

  //console.log("category_id:"+category_id,"condition_id:"+condition_id); 
  //return false;
 $(".loader").show();
  $.ajax({

        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/get_avg_sold", // json datasource
        type: "post" ,
        data: {
        'category_id': category_id,
        // 'mpn' : mpn,
        // 'condition_id':condition_id,
        'get_keyword':get_keyword
        },
        dataType: 'json',

        success : function(data){


          if(data.ack= 'Success' && data.resultCount > 0)
     {
        if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          //$( "#sold_price_data" ).html("");
          
           var item = data['item'][0];
           var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
           $("#avg_sal_pric").val(price);
           //table.row(this_tr).find('cata_avg_price').val(price);
          // $('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
           //$('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2));
       // }

        }
        if(data.resultCount > 1)
        {
          if(data.resultCount > 15){
            var loop = 15;
          }else{
            var loop = data.resultCount;
          }
          var sum_price = 0;
            for ( var i = 1; i <= loop; i++ ) 
            {
              //console.log(i-1);
             var item = data['item'][i-1];
              //var item = data['item'][0];
             var price = item['basicInfo']['convertedCurrentPrice'];
             sum_price = parseFloat(sum_price) + parseFloat(price) ;
            //console.log(i-1,price,sum_price);
            }
            var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
           //  $('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(avg_price.toFixed(2));
           // $('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(avg_price.toFixed(2));
           $("#avg_sal_pric").val(price);
        }
      //$(".loader").hide();
    }else{
       // $(".loader").hide();
       //  $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
       //  if(data == 'EXCEPTION'){
       //    alert("keyword not found");
       //  }else{
          alert("No result found on eBay");

        //}
              
      }


       //console.log(data); 
       //return false;

    // if(data.ack= 'Success' && data.resultCount > 0)
    //  {
    //     if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
    //     {
    //       //$( "#sold_price_data" ).html("");
          
    //        var item = data['item'][0];
    //        var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
    //        //table.row(this_tr).find('cata_avg_price').val(price);
    //        $('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
    //        $('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2));
    //    // }

    //     }
    //     if(data.resultCount > 1)
    //     {
    //       if(data.resultCount > 15){
    //         var loop = 15;
    //       }else{
    //         var loop = data.resultCount;
    //       }
    //       var sum_price = 0;
    //         for ( var i = 1; i <= loop; i++ ) 
    //         {
    //           //console.log(i-1);
    //          var item = data['item'][i-1];
    //           //var item = data['item'][0];
    //          var price = item['basicInfo']['convertedCurrentPrice'];
    //          sum_price = parseFloat(sum_price) + parseFloat(price) ;
    //         //console.log(i-1,price,sum_price);
    //         }
    //         var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
    //         $('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(avg_price.toFixed(2));
    //        $('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(avg_price.toFixed(2));
    //     }
    //   $(".loader").hide();
    // }else{
    //    $(".loader").hide();
    //     $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
    //     if(data == 'EXCEPTION'){
    //       alert("keyword not found");
    //     }else{
    //       alert("No result found on eBay");
    //     }
              
      //}
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
/*=====  End of getsold price function  ======*/

 $(document).on('click','.get_new_object', function(){
  // var rowIndex = $(this).attr('rowIndex');
  // //var auction_id=$('#get_auc_uri_id').val();
  // var cat_id = $('#auction_det_details tr').eq(rowIndex).find('td').eq(7).find('input').val();
  var cat_id = $('#mpn_category').val();
  if(cat_id == ''){
    alert('Enter Category ');
    return false;
  }
 // console.log(rowIndex,auction_id,cat_id); return false;
  $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/getCatObj',
        
        type:'post',
        dataType:'json',
        data:{'cat_id':cat_id},

        success:function(data){
//console.log(data[0].OBJECT_ID); //return false;
        if(data.length > 0){
          var html = '<select class="selectpicker form-control obj_dd " data-live-search="true" name="obj_dd" id = "obj_dd"  ><option value="0">select Object</option>';

            for(var i=0; i <data.length; i++) {
              html += '<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>';

                // $('<option />', {value: data[0].OBJECT_ID, text:  data[0].OBJECT_NAME}).appendTo(dd);

            }
            html += "</select>";
            //console.log(html);
            $('#object_dd').html("");
            $('#object_dd').append(html);
            $('#obj_dd').selectpicker();
            //html.appendTo('object_dd');
        }else{
          alert('No Object Found !');
          return false;

        }
      }
    }); 
});
 $(document).on('change','.obj_dd', function(){ 
    var get_name = $("#obj_dd option:selected").text();
    $('#mpn_object').val(get_name);

  });

//////////////////////////////////////
function textCounter(field,cnt, maxlimit) {         
      var cntfield = document.getElementById(cnt);

         if (field.value.length > maxlimit){ // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
        }else{
       cntfield.value = parseInt(parseInt(maxlimit) - parseInt(field.value.length));
     }
    }

  $(document).on('click','.get_mpn_desc_api',function(){
    var category_id        = $('#mpn_category').val();   
    var mpn            = $('#mpn_description').val();
    var mpn_nam            = $('#mpn').val();

  if(mpn == ''){
      $('#mpn_description').focus();
      alert('Enter Mpn description');
      return false;
    }

    $('#get_keyword').val(mpn_nam);

    var condition_id     =3000;// $('input[name=up_cond_item]:checked').val();
    var catalogue_mt_id  = $("#br_catalog_id").val(); 

  // console.log(category_id,mpn,condition_id,catalogue_mt_id); 
  // // return false;
  $(".loader").show();
  $.ajax({
        url :"<?php echo base_url() ?>dekitting_pk_us/c_comp_identi_pk/get_avg_sold_price", // json datasource
        type: "post" ,
        data: {
        'category_id': category_id,
        'mpn' : mpn,
        'condition_id':condition_id,
        'catalogue_mt_id':catalogue_mt_id
        },
        dataType: 'json',

        success : function(data){
       // console.log(data); 
       // return false;

    if(data.ack= 'Success' && data.resultCount > 0)
     {
        if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {         
          var item = data['item'][0];
          var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
          var title = item['basicInfo']['title'];
          var categoryId = item['basicInfo']['categoryId'];
          var categoryName = item['basicInfo']['categoryName'];
          var it_url = item['basicInfo']['viewItemURL'];
          var url_html = '<a  href="'+it_url+'" title="Print Sticker"  target="_blank">'+ categoryId +'</a>';
         
          $('#get_cost').val(price.toFixed(2));
          $("#my_Categories_result").html("");

          var tr='';
          $("#my_Categories_result").html( "<div class='col-sm-12'><div class='box box-success'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Ebay Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Category Id</th><th>Category Name</th><th>Title</th><th>Select</th>" );

          $('<tr>').html("<td>"+1+"</td><td>"+ url_html +"</td><td>"+ categoryName +"</td><td>"+ title +"</td><td><a class='crsr-pntr' id='cat_"+1+"' onclick='selct_funct("+1+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');

           //$('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
           //$('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2)).trigger('blur');//call blur function to calculate seling expense
       // }

        }
        if(data.resultCount > 1)
        {
          var title_arr = [];
          if(data.resultCount > 15){
            var loop = 15;
          }else{
            var loop = data.resultCount;
          }
          var sum_price = 0;
          /////////////////////////////////////
          $( "#my_Categories_result" ).html("");
          var tr='';

         $( "#my_Categories_result" ).html( "<div class='col-sm-12'><div class='box box-success'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Ebay Suggested Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_table'> <th>Sr. No</th><th>Category Id</th><th>Category Name</th><th>Title</th><th>Select</th>" );
          //////////////////////////////////////////////////

            for ( var i = 1; i <= loop; i++ ) 
            {
              //console.log(i-1);
             var item = data['item'][i-1];
              //var item = data['item'][0];
             var price = item['basicInfo']['convertedCurrentPrice'];
             sum_price = parseFloat(sum_price) + parseFloat(price) ;
             var title = item['basicInfo']['title'];
             var categoryId = item['basicInfo']['categoryId'];
             var categoryName = item['basicInfo']['categoryName'];
             var it_url = item['basicInfo']['viewItemURL'];
             console.log(it_url);
             var url_html = '<a  href="'+it_url+'" title="Print Sticker"  target="_blank">'+ categoryId +'</a>';

            $('<tr>').html("<td>" + i + "</td><td>"+ url_html +"</td><td>"+ categoryName +"</td><td>"+ title +"</td><td><a class='crsr-pntr' id='cat_"+i+"' onclick='selct_funct("+i+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_table');            
            }
            //console.log(title_arr);

            var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
            $('#get_cost').val(avg_price.toFixed(2));

        }
      $(".loader").hide();
    }else{ 
       $(".loader").hide();
        // $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
        if(data == 'EXCEPTION'){
          $("#my_Categories_result").html("");
          alert("keyword not found");
        }else{
          $("#my_Categories_result").html("");
          alert("No result found on eBay");
        }
              
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

$(document).on('click','.get_mpn_history',function(){ 

  var getcategory_id    = $('#mpn_category').val();
  var mpn            = $('#mpn_description').val();
  var mpn_nam            = $('#mpn').val();

  if(mpn == ''){
      $('#mpn_description').focus();
      alert('Enter Mpn description');
      return false;
    }

    $('#get_keyword').val(mpn_nam);
    var url='<?php echo base_url() ?>dekitting_pk_us/c_comp_identi_pk/get_history';
   $.ajax({
      url: url,
      dataType: 'json',
      type: 'POST',
      data : {'category_id':getcategory_id,'mpn':mpn,'mpn_nam':mpn_nam},
      success:function(data){

        if(data.exist == true){

          $("#my_history" ).html("");
          var tr='';
          $( "#my_history" ).html( "<div class='col-sm-12'><div class='box box-danger'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>History Titles</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='mycategory_histry_table'> <th>Sr. No</th><th>Category Id</th><th>Title</th><th>Mpn</th><th>Object Name</th><th>Brand Name</th><th>Condition</th><th>Avg Sold Price</th><th>Select</th>" );
          console.log(data.get_his.length);
          for(var k = 0; k< data.get_his.length; k++){



              if(data.get_his[k].CATE !== null){
                        CATE = data.get_his[k].CATE;
                        
              }else{
                CATE = '';
              }
              if(data.get_his[k].OBJECT_NAME !== null){
                        object_name = data.get_his[k].OBJECT_NAME;
                        
              }else{
                object_name = '';
              }
              if(data.get_his[k].MPN !== null){
                        mpn = data.get_his[k].MPN;
                        
              }else{
                mpn = '';
              }
              if(data.get_his[k].BRAND !== null){
                        brand = data.get_his[k].BRAND;
                        
              }else{
                brand = '';
              }
              if(data.get_his[k].COND_NAME !== null){
                        get_cond_name = data.get_his[k].COND_NAME;
                        
              }else{
                get_cond_name = '';
              }


            $('<tr>').html("<td>"+ parseInt(k+1) +"</td><td>"+ CATE +"</td><td>"+ data.get_his[k].TITLE +"</td><td>"+ mpn +"</td><td>"+ object_name +"</td><td>"+ brand +"</td><td>"+ get_cond_name +"</td><td>"+ data.get_his[k].SOLD_PRICE +"</td><td><a class='crsr-pntr'  onclick='select_his_funct("+k+");'> Select </a></td></tr></table></div></div>").appendTo('#mycategory_histry_table');

          
        }
     }else if(data.exist == false){
      alert('No History Found');
      $("#my_history" ).html("");
      
      return false;
     }
     }
        });  
      });


function selct_funct(i) {
    var index = i;
    var t = document.getElementById('mycategory_table');

    var get_cat = $(t.rows[index].cells[1]).text();
    var get_tile = $(t.rows[index].cells[3]).text();
    document.getElementById("mpn_category").value=get_cat;
    document.getElementById("mpn_description").value=get_tile;
    
    // i++;

    //});
}

function select_his_funct(i) {
    var index = i+1;
    var t = document.getElementById('mycategory_histry_table');

    var get_cat = $(t.rows[index].cells[1]).text();
    var get_tile = $(t.rows[index].cells[2]).text();
    var get_mpn = $(t.rows[index].cells[3]).text();
    var get_obj_name = $(t.rows[index].cells[4]).text();
    var get_brand_name = $(t.rows[index].cells[5]).text();
    var avg_sold = $(t.rows[index].cells[7]).text();
    document.getElementById("mpn_category").value=get_cat;
    document.getElementById("mpn_description").value=get_tile;
    document.getElementById("mpn").value=get_mpn;
    document.getElementById("mpn_object").value=get_obj_name;
    document.getElementById("mpn_brand").value=get_brand_name;
    document.getElementById("avg_sal_pric").value=avg_sold;
    
    // i++;

    //});
}

</script>


