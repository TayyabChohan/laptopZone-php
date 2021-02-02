<?php $this->load->view('template/header');ini_set('memory_limit', '-1');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item Pictures
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Pictures</li>
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
            <div class="box-header">
              <h3 class="box-title">Item Pictures</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
              <div class="col-sm-12">

                <form action ="<?php echo base_url('item_pictures/c_item_pictures/item_search'); ?>"  method="post">

                  <div class="col-sm-4">
                    <div class="form-group">
                    <label>Barcode:</label>
                      <input type="text" class="form-control" name="pic_bar_code" id="pic_bar_code" value="<?php echo @$data['search_query'][0]['IT_BARCODE']; ?>" required>
                    </div>
                  </div>
                      
                        <!-- <input type="hidden" class="form-control" name="bar_code" id="bar_code"> -->

                    <div class="col-sm-2">
                      <div class="form-group" style="padding-top:24px;">
                       <input class="btn btn-primary" type="submit" name="barcode_search" id="barcode_search" value="Search">
                      </div>
                    </div>
                  </form>
                                 <div class="col-sm-12">
                  <?php
                  if(!empty(@$data['search_query'][0]['HOLD_STATUS'] == 1)){
                    echo '<div class="alert alert-warning alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Warning! Item Barcode is on Hold</strong>
                  </div>';
                  //exit;
                  }
                  if(!empty(@$data['search_query'][0]['EBAY_ITEM_ID'])){
                    echo '<div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Item is already Listed against eBay No: '.@$data['search_query'][0]['EBAY_ITEM_ID'].'</strong>
                  </div>';
                  //exit;
                  }                   
                  //var_dump($error_msg);exit;
                  if(!empty(@$error_msg)){
                    echo '<div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>'.@$error_msg.'</strong>
                  </div>';
                  //exit;
                  }?>
                  <?php 
                  // var_dump($barcode_error);exit;
                  $barcode_error_msg = $this->session->userdata('barcode_error');
                  if(@$barcode_error_msg === TRUE){
                    $this->session->unset_userdata('barcode_error');
                    echo '<div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>'.@$barcode_error.'</strong>
                  </div>';
                  //exit;
                  }
                  ?>                                    
               </div>
                  <?php if(empty(@$data)): ?>
                    <div class="col-sm-2">
                      <div class="form-group" style="padding-top:24px;">
                       <a class="btn btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/master_view');?>" target="_blank">Add Master Images</a>
                      </div>
                    </div>
                  <?php endif; ?>
                  <?php if(!empty(@$data)){?>
                    <div class="col-sm-4">
                      <div class="form-group pull-right">
                        <a style="text-decoration: underline;" href="<?php echo base_url();?>tester/c_tester_screen/search_manifest/<?php echo @$data['search_query'][0]['LZ_MANIFEST_ID']; ?>" target="_blank">View Tests List</a>
                      </div>
                    </div>
                  <?php }?>

               </div>
               <div class="col-sm-12">
                  <?php
                  if(!empty(@$data['search_query'][0]['EBAY_ITEM_ID'])){
                    echo '<div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Item is already Listed against eBay No: '.@$data['search_query'][0]['EBAY_ITEM_ID'].'</strong>
                  </div>';
                  //exit;
                  }                    
                  //var_dump($error_msg);exit;
                  if(!empty(@$error_msg)){
                    echo '<div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>'.@$error_msg.'</strong>
                  </div>';
                  //exit;
                  }?>
                  <?php 
                  // var_dump($barcode_error);exit;
                  $barcode_error_msg = $this->session->userdata('barcode_error');
                  if(@$barcode_error_msg === TRUE){
                    $this->session->unset_userdata('barcode_error');
                    echo '<div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>'.@$barcode_error.'</strong>
                  </div>';
                  //exit;
                  }
                  ?>                                    
               </div>
               <?php 
              //var_dump(@$data);exit;
               if(!empty(@$data) && empty(@$error_msg) && $barcode_error_msg != TRUE){
                foreach(@$data['search_query'] as $row):
               ?> 
              <div class="col-sm-12">
                <div class="col-sm-2">
                  <div class="form-group">
                      <label>ERP Code:</label>
                      <input type='text' class="form-control" name="erp_code" id="erp_code" value="<?php echo @$row['LAPTOP_ITEM_CODE']; ?>" readonly >      
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                      <label>Manifest ID:</label>
                      <input type='number' class="form-control" name="manifest_id" id="manifest_id" value="<?php echo @$row['LZ_MANIFEST_ID']; ?>" readonly >      
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                      <label>Quantity:</label>
                      <input type='number' class="form-control" name="quantity" id="quantity" value="<?php echo @$row['AVAIL_QTY']; ?>" readonly >      
                  </div>
                </div>
                <div class="col-sm-2">    
                  <div class="form-group">      
                      <label for="">UPC:</label>
                      <input type="text" class="form-control" id="upc" name="upc" value="<?php echo @$row['UPC']; ?>" readonly/>
                    </div>
                </div>
                <div class="col-sm-2">        
                  <div class="form-group">      
                    <label for="">Part No:</label>
                    <input type='text' class="form-control" id="part_no" name="part_no" value="<?php echo @$row['MFG_PART_NO']; ?>" readonly>
                  </div>
                </div>

<!--                 <div class="col-sm-2">  
                  <div class="form-group">      
                    <label for="">SKU:</label>
                    <input type='text' class="form-control" id="sku" name="sku" value="<?php //echo @$row['MFG_PART_NO']; ?>" readonly>
                  </div>
                </div> -->
                <div class="col-sm-4">
                  <div class="form-group">      
                    <label for="">Manufacturer:</label>
                    <input type='text' class="form-control" name="manufacturer" id="manufacturer" value="<?php echo @$row['MANUFACTURER']; ?>" readonly>
                  </div>
                </div>                                  
                <div class="col-sm-8 m-erp" >
                    <div class="form-group">
                      <label for="">ERP Inventory Description:</label>
                      <input type='text' class="form-control" name="inven_desc" id="inven_desc" value="<?php echo @$row['ITEM_MT_DESC']; ?>" readonly>
                    </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">      
                    <label for="">Condition:</label>
                    
                      <select class="form-control" id="default_condition" name="default_condition" value="<?php echo @$row['ITEM_CONDITION']; ?>" readonly>
                        
                        <option value="<?php echo @$row['ITEM_CONDITION']; ?>" selected = "selected"><?php echo @$row['COND_NAME']; ?></option>
                        

                      </select> 
                    
                  </div>
                </div>  
                
                <div class="col-sm-12">
                  <div class="form-group">
                      <label for="">Picture Notes:</label>
                      <textarea class="form-control" name="picture_note" id="picture_note" cols="30" rows="4"><?php echo @$row['PIC_NOTE'];?></textarea>
                  </div>
                </div> 

                <div class="col-sm-12">
                  <div class="form-group">
                      <label for="">Special Remarks:</label>
                      <textarea class="form-control" name="special_remarks" id="special_remarks" cols="30" rows="4"><?php echo @$row['SPECIAL_REMARKS'];?></textarea>
                  </div>
                </div>

              <!-- Master Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Master Pictures:</label>

              <div id="" class="col-sm-12 b-full">
<!--                 <div class="col-sm-2">                   
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                      <div class="uploadimg">
                       <form id="frmupload" enctype="multipart/form-data">
                          <input type="file" multiple="multiple" name="image[]" id="image" style="display:none"/>
                          <input type="hidden" style="display:none;" class="form-control" id="pic_item_id" name="pic_item_id" value="<?php //echo @$data_get[0]->ITEM_ID; ?>">
                          <input type="hidden" style="display:none;" class="form-control" id="pic_manifest_id" name="pic_manifest_id" value="<?php //if (@$manifest_id){echo $manifest_id;}else{echo @$data_get[0]->LZ_MANIFEST_ID;} ?>">
                          <span id="spec_img_upload" class="fa fa-cloud-upload"></span>

                        </form>
                      </div>
                  </div>
              </div> -->
                               
                <div id="" class="col-sm-12 p-t"> 
                 <ul id="" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
<?php 
                  $it_condition  = @$row['COND_NAME'];
                  // if(is_numeric(@$it_condition)){
                  //     if(@$it_condition == 3000){
                  //       @$it_condition = 'Used';
                  //     }elseif(@$it_condition == 1000){
                  //       @$it_condition = 'New'; 
                  //     }elseif(@$it_condition == 1500){
                  //       @$it_condition = 'New other'; 
                  //     }elseif(@$it_condition == 2000){
                  //         @$it_condition = 'Manufacturer refurbished';
                  //     }elseif(@$it_condition == 2500){
                  //       @$it_condition = 'Seller refurbished'; 
                  //     }elseif(@$it_condition == 7000){
                  //       @$it_condition = 'For parts or not working'; 
                  //     }else{
                  //         @$it_condition = 'Used'; 
                  //     }
                  // }else{// end main if
                  //   $it_condition  = ucfirst(@$it_condition);
                  // }
                  $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                  //$dir = "D:/item_pictures/master_pictures/".@$row['UPC']."~".@$mpn."/".@$it_condition;
                  //var_dump($data['path_query'][0]['MASTER_PATH']);exit;
                   $master_path = $data['path_query'][0]['MASTER_PATH'];
                   $dir = $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition;
                   $dir = preg_replace("/[\r\n]*/","",$dir);
                  // Open a directory, and read its contents
                  if (is_dir($dir)){

                    if ($dh = opendir($dir)){

                      $i=1;
                      while (($file = readdir($dh)) !== false){
                        $parts = explode(".", $file);
                        if (is_array($parts) && count($parts) > 1){

                            $extension = end($parts);
                            //var_dump($extension);exit;
                            if(!empty($extension)){

                              ?>


                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style="width: 105px; height: 105px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">

                                        <?php
                                          //$url = 'D:/item_pictures/master_pictures/'.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        $master_path = $data['path_query'][0]['MASTER_PATH'];
                                        $url = $master_path.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        $url = preg_replace("/[\r\n]*/","",$url);
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img zoom_01" id="" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                  
                                                          
                                        <?php //echo '<img class="sort_img up-img" id="" name="" src="'.base_url('assets/item_pic').'/'.$parts['0'].'.'.$extension.'"/>';?>

<!--                                          <div class="img_overlay">
                                          <span><i class="fa fa-trash"></i></span> 
                                        </div> -->
                                      
                                    </div>                    
                                  </span>                        
                                </li>

                              <?php
                              //echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

                          }
                        }

                      }
                      closedir($dh);

                    }
                  }


                ?>

                </ul>
                </div>
                                  


                <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                  <div class="col-sm-8">
                    <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group pull-right">
                      <a title="Update Master Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/item_search')?>/<?php echo @$data['search_query'][0]['IT_BARCODE']; ?>" target="_blank">Update Master Pictures</a>
                      <!-- <input id="update_order" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order"> -->
                      <!-- <span><i id="del_all" onclick="return confirm('are you sure?')" title="Delete All Pictures" class="btn btn-sm btn-danger">Delete All</i></span> -->
                    </div>
                    
                  <!--</form>-->
                </div>
                </div> 

              </div>
            </div>
            <!-- Master Picture section end--> 

              <!-- Specific Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Specific Pictures:</label>

              <div id="drop-specific-img" class="col-sm-12 b-full">
                <div class="col-sm-2">                   
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                      <div class="uploadimg">
                       <form id="frmupload" enctype="multipart/form-data">
                          <input type="file" multiple="multiple" name="image[]" id="spec_image" style="display:none"/>
                           <input type="hidden" style="display:none;" class="form-control" id="upc~mpn" name="upc~mpn" value="<?php echo @$row['UPC'].'~'.@$row['MFG_PART_NO']; ?>">
                          <input type="hidden" style="display:none;" class="form-control" id="it_condition" name="it_condition" value="<?php echo @$row['ITEM_CONDITION']; ?>">
                          <span id="spec_img_upload" class="fa fa-cloud-upload"></span>
                        </form>
                      </div>
                  </div>
              </div>
                               
                <div id="" class="col-sm-10 p-t"> 
                 <ul id="sortable" style="height: 140px !important;">
                  <?php 
                  $it_condition  = @$row['COND_NAME'];
                  // if(is_numeric(@$it_condition)){
                  //     if(@$it_condition == 3000){
                  //       @$it_condition = 'Used';
                  //     }elseif(@$it_condition == 1000){
                  //       @$it_condition = 'New'; 
                  //     }elseif(@$it_condition == 1500){
                  //       @$it_condition = 'New other'; 
                  //     }elseif(@$it_condition == 2000){
                  //         @$it_condition = 'Manufacturer refurbished';
                  //     }elseif(@$it_condition == 2500){
                  //       @$it_condition = 'Seller refurbished'; 
                  //     }elseif(@$it_condition == 7000){
                  //       @$it_condition = 'For parts or not working'; 
                  //     }else{
                  //         @$it_condition = 'Used'; 
                  //     }
                  // }else{// end main if
                  //   $it_condition  = ucfirst(@$it_condition);
                  // }
                  $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                  // $dir = "D:/item_pictures/specific_pictures/".@$row['IT_BARCODE']."/".@$it_condition;
                  $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];
                  $dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".$row['LZ_MANIFEST_ID'];
                  $dir = preg_replace("/[\r\n]*/","",$dir);
                  //var_dump($dir);exit;
                  //$dir = "D:\wamp\www\laptopzone\assets\item_pic";
                  // Open a directory, and read its contents
                  if (is_dir($dir)){
                    if ($dh = opendir($dir)){
                      $i=1;
                      while (($file = readdir($dh)) !== false){
                        $parts = explode(".", $file);
                        if (is_array($parts) && count($parts) > 1){
                            $extension = end($parts);
                            if(!empty($extension)){
                              ?>


                                <li id="<?php echo $parts['0'].'.'.$extension;?>">
                                  <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">
                                                          
                                        <?php
                                          //$url = 'D:/item_pictures/specific_pictures/'.@$row['IT_BARCODE'].'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];
                                          $url = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".$row['LZ_MANIFEST_ID'].'/'.$parts['0'].'.'.$extension;
                                          $url = preg_replace("/[\r\n]*/","",$url);
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img zoom_01" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">

                                      <div class="text-center" style="width: 100px;">
                                        <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span>
                                        <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash delete_specific"></i></span> 
                                      </div>                                      
                                    </div>
                                    
                                    <!-- <span><i class="fa fa-trash delete_specific"></i></span> -->                      
                                  </span>                        
                                </li>

                              <?php
                          }
                        }

                      }
                      closedir($dh);

                    }
                  }


                ?>

                </ul>
                </div>
                                  


                <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                    <div class="form-group pull-right">
                      <input id="specific_order" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                      <span><i id="specific_del_all" title="Delete All Pictures" class="btn btn-sm btn-danger">Delete All</i></span>
                    </div>
                    
                  <!--</form>-->

                </div> 

              </div>
            </div>
            <!-- Specific Picture section end--> 
            <!-- <div class="col-sm-12">
              <div class="form-group">
                <input class="btn btn-sm btn-primary" title="Save" type="submit" id="save_pics_specifics" name="save_pics_specifics" value="Save">
              </div>
            </div>   -->
            <!--</form>-->
         
                <?php
                break;
                endforeach;
                } //endif

                ?>
              </div>
            </div>  
							

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>	
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer');?>
<script>
/*==================================
=            Image zoom            =
Doc Url: http://www.elevateweb.co.uk/image-zoom/examples
==================================*/
  $('.zoom_01').elevateZoom({
    //zoomType: "inner",
    cursor: "crosshair",
    zoomWindowFadeIn: 600,
    zoomWindowFadeOut: 600,
    easing : true,
    scrollZoom : true
   });

/*=====  End of Image zoom  ======*/

   $(document).ready(function(){


  $("#drop-specific-img").on('dragenter', function (e){
    e.preventDefault();
  });

  $("#drop-specific-img").on('dragover', function (e){
    e.preventDefault();
  });

  $("#drop-specific-img").on('drop', function (e){
    e.preventDefault();
    var image = e.originalEvent.dataTransfer.files;
    createImgData(image);
  });

  $("#spec_img_upload").click(function(){
    $("#spec_image").trigger("click");
  });

  $("#spec_image").change(function(){
    var postData = new FormData($("#frmupload")[0]);
    uploadSpecImgData(postData);
  });
  function createImgData(image) {
    var len = image.length;
    var formImage = new FormData();
    if(len === 1){
      formImage.append('image[]', image[0]);
    }else{
      for(var i=0; i<len; i++){
        formImage.append('image[]', image[i]);
      }
    }
    uploadSpecImgData(formImage);
  }
  function uploadSpecImgData(formData) {
        var upc = document.getElementById("upc").value;
        var part_no = document.getElementById("part_no").value;
        var it_condition = document.getElementById("it_condition").value;
        var condition_name = document.getElementById("default_condition").text;
        var manifest_id = document.getElementById("manifest_id").value;
        //alert(it_condition);return false; 
        formData.append('upc',upc);
        formData.append('part_no',part_no);
        formData.append('it_condition',it_condition);
        formData.append('manifest_id',manifest_id);
        formData.append('condition_name',condition_name);
        $.ajax({
          url: '<?php echo base_url(); ?>item_pictures/c_item_pictures/upload_spec_img',
          data: formData,
          type: 'POST',
          datatype : "json",
          processData: false,
          contentType: false,
          cache: false,
          success: function(data) {
              alert('Success: Item Pictures inserted');
              var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
         
          if(data == true){
             window.location.href=window.location.href; return false;
          }
        });
      }
  });
 /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_specifics").click(function(){
    var upc = $('#upc').val();
    var part_no = $('#part_no').val();
    var it_condition = $('#it_condition').val();
    var condition_name = $('#default_condition').text();
    var manifest_id = $('#manifest_id').val();
   // var n = $("#sortable li").length;
    //var pic_name = $('#sortable li').attr('id');
    // alert(n);
    // alert(pic);return false;
    // var pic_name = [];

    // var i = 1;
    // for(var i=1; i<=n; i++){
    //   pic_name.push($('#sortable li').attr('id'));
      
    // }    
    
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/save_pics_specifics',
      data: { 'manifest_id':manifest_id,
              'upc':upc,
              'part_no':part_no,
              'it_condition':it_condition,             
              'condition_name':condition_name             
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Specific Pictures has been added.');
          //window.location.reload();
        }else if(data == false){
          alert('Error -  Pictures not added.');
          //window.location.reload();
        }
      }
      });      
  });
  
  
  /*=====  End of save and move images on click save button  ======*/
</script>