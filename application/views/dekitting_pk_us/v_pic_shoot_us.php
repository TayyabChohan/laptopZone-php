<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 

?>
<html>
<head>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Picture Shooting - De-Kitting - U.S.
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Picture Shooting - De-Kitting - U.S.</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
    <!-- Master Barcode Search Box section Start -->
      <div class="row">
      <div class="col-sm-12">
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
              
        <div class="col-sm-12">
              
              <form action="<?php echo base_url().'dekitting_pk_us/c_pic_shoot_us/showChildDetails'; ?>" method="post" accept-charset="utf-8">
                <div class="col-sm-2 ">             
                  <div class="form-group">
                    <label for="Master Barcode">Barcode :</label>
                    <?php  $barcode_prv = $this->session->userdata("barcode_prv");?>
                    <input type="text" name="barcode_prv" id ="barcode_prv" class="form-control " placeholder="Search Barcode" value="<?php if($barcode_prv){echo $barcode_prv;} ?>">    
                  </div>              
                </div>
                <div class="col-sm-1">
                  <div class="form-group" style="padding-top:24px;">
                    <input class="btn btn-primary" type="submit" name="barcode_search" id="barcode_search" value="Search">
                  </div>
                </div>                 
              </form>
              <?php //var_dump(@$data); //exit; 
              if(!empty(@$data)){
              ?>
              <?php  @$bin_id = $this->session->userdata("bin_id");?>
              <div class="col-sm-2 ">             
                <div class="form-group">
                  <label for="Assign Bin">Assign Bin:</label>
                  <input type="text" name="bin_id" id="bin_id" class="form-control" value="<?php if($bin_id){echo $bin_id;} ?>" required>    
                </div>              
              </div>

              <div class="col-sm-12">

                <div class="col-sm-3 ">             
                  <div class="form-group">
                    <label for="object">Object:</label>
                    <input type="text" name="singleObj" id="singleObj" class="form-control clear" value="<?php echo @$data[0]['OBJECT_NAME']; ?>" readonly>    
                  </div>              
                </div>

                <div class="col-sm-3 ">             
                  <div class="form-group">
                    <label for="Condition">Condition:</label>
                    <input type="text" name="condition_segs" id="condition_segs" class="form-control clear" value="<?php echo @$data[0]['COND_NAME']; ?>" readonly>    
                  </div>              
                </div>

                <div class="col-sm-2 ">             
                  <div class="form-group">
                    <label for="Weight">Weight:</label>
                    <input type="text" name="search_weight" id="search_weight" class="form-control clear" value="<?php echo @$data[0]['WEIGHT']; ?>" readonly>    
                  </div>              
                </div>                                
                <div class="col-sm-2 ">             
                  <div class="form-group">
                    <label for="Bin Name">Bin Name:</label>
                    <input type="text" name="search_bin" id="search_bin" class="form-control clear" value="<?php echo @$data[0]['BIN_NAME']; ?>" readonly>    
                  </div>              
                </div>                

              </div>

              <div class="col-sm-12" >
                <div class="col-sm-6 ">             
                  <div class="form-group">
                    <label for="Dekit">Dekitting Remarks:</label>
                    <input type="text" name="search_Remarks" id="search_Remarks" class="form-control clear" value="<?php echo htmlentities(@$data[0]['DEKIT_REMARKS']); ?>" readonly>    
                  </div>              
                </div>  

                <div class="col-sm-2 p-t-24 pull-right">             
                  <div class="form-group">
                    
                    <!-- <input type="button" name="addbarcodePic" id ="addbarcodePic" class="btn btn-sm btn-primary"  value="Add Picture">  -->   
                  </div>              
                </div>                                  
              </div>
              <?php } ?>
             
          
          <div class="col-sm-12">
            <div class="col-sm-10"></div>
            <div class="col-sm-2">
            <div class="form-group pull-right">
              <a style="font-weight: 600;font-size: 16px !important;text-decoration: underline;" href="<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/pictureShootingDetails" target="_blank" title="Without And With Pictures Barcodes">Picture Shooting Details</a>
            </div>
            </div>   
          </div>
                                                       
        </div>  
      </div>
      </div>
       <!-- Master Barcode Search Box section End --> 


      <!--- start image loading box -->
    <?php //var_dump(@$data); //exit; 
    if(!empty(@$data)){
    ?>     
      <div class="box" id ="addPicsBox">
        <div class="box-header">
          <h3 class="box-title">Add Pictures</h3>
        </div>
        <div class="box-body">
        <div class="row">

          <div class="col-sm-12">
            <div class="col-sm-12 p-b">
                <label for="Live Pictures From PhotoLab">Master Pictures:</label>
                <div id="" class="col-sm-12 b-full">      
                   
                  <div id="" class="col-sm-12 p-t"> 
                   <ul id="live_pics" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;">                    
                  <?php

                  $path = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 1");
                  $path = $path->result_array();
                  $master_path = $path[0]['LIVE_PATH'];
                  $dir = $master_path;



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


                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> 
                                  <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">

                                        <?php
                                          //$url = 'D:/item_pictures/master_pictures/'.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        //$master_path = $data['path_query'][0]['MASTER_PATH'];
                                        $url = $master_path.'/'.$parts['0'].'.'.$extension;
                                        $image_name = $parts['0'].'.'.$extension;
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
                                    <input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="<?php echo $image_name; ?>" title="MPN Picture">
                                    <span class="d_live_spn">
                                      <i title="Delete Picture" style="" id="<?php echo $url; ?>" class="fa fa-trash delSpecificLivePictures"></i>
                                    </span>                    
                                  </span>                        
                                </li>

                              <?php
                              //echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

                          }
                        }

                      } //while closing
                      closedir($dh);

                    }
                  }


                ?>

                  
                    </ul>
                  </div>                    
                    
                  <div class="col-sm-12">
                    <div class="col-sm-1">
                      <div class="form-group">
                        <input class="btn btn-sm btn-success save_pics" title="Save" type="button" id="save_pics_master" name="save_pics_master" value="Save">
                      </div>
                    </div>
                    <div class="col-sm-9">     
                      <div id="pics_insertion_msg">
                        
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group pull-right">
                        <input class="btn btn-sm btn-primary syncPictures" onclick="window.location.reload();" title="Sync Pictures" type="button" id="syncPictures" name="syncPictures" value="Sync Pictures" style="margin-right: 5px;">
                        <input class="btn btn-sm btn-danger delLivePictures" title="Delete Live Pictures" type="button" id="delLivePictures" name="delLivePictures" value="Delete All">
                      </div>
                    </div>                    
                  </div>

                </div>
            </div>
          </div> 

          <div class="col-sm-12">
            <div class="col-sm-12 p-b">
                <label for="">History Pictures:</label>
                <div id="" class="col-sm-12 b-full">         
                  <div id="" class="col-sm-12 p-t"> 
                   <ul id="history_pics" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;">                    
                  
                  <?php

                  $getMpn = $this->db->query("SELECT I.ITEM_MT_MFG_PART_NO, DT.OBJECT_ID FROM LZ_DEKIT_US_DT DT, LZ_DEKIT_US_MT MT,LZ_BARCODE_MT B, ITEMS_MT I WHERE DT.LZ_DEKIT_US_MT_ID = MT.LZ_DEKIT_US_MT_ID AND B.BARCODE_NO = MT.BARCODE_NO AND B.ITEM_ID = I.ITEM_ID AND DT.BARCODE_PRV_NO = $barcode_prv");

                    $getMpn = $getMpn->result_array();
                    $mpn = $getMpn[0]["ITEM_MT_MFG_PART_NO"];
                    $OBJECT_ID = $getMpn[0]["OBJECT_ID"];

                    $getMasterBarcodeId = $this->db->query("SELECT D.LZ_DEKIT_US_MT_ID FROM LZ_DEKIT_US_MT D, LZ_BARCODE_MT B , ITEMS_MT I WHERE I.ITEM_ID = B.ITEM_ID AND B.BARCODE_NO = D.BARCODE_NO AND I.ITEM_MT_MFG_PART_NO = '$mpn' ORDER BY D.LZ_DEKIT_US_MT_ID DESC");

                 
                    $getMasterBarcodeId = $getMasterBarcodeId->result_array();
                    $master_id = $getMasterBarcodeId[0]["LZ_DEKIT_US_MT_ID"];


                   $getBarcodePrv_no =  $this->db->query("SELECT DT.BARCODE_PRV_NO FROM LZ_DEKIT_US_DT DT WHERE DT.LZ_DEKIT_US_MT_ID = $master_id AND DT.OBJECT_ID = '$OBJECT_ID' AND DT.PIC_DATE_TIME IS NOT NULL AND DT.PIC_STATUS = 1 AND DT.BARCODE_PRV_NO <> $barcode_prv ORDER BY DT.LZ_DEKIT_US_DT_ID DESC");

                   $getBarcodePrv_no = $getBarcodePrv_no->result_array();
                   // var_dump($getBarcodePrv_no);exit;

                  if(count($getBarcodePrv_no) > 0){



                    $getBarcodePrv_no = $getBarcodePrv_no[0]["BARCODE_PRV_NO"];

                    $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
                    $path = $path->result_array();    

                    $master_path = $path[0]["MASTER_PATH"];
                    // var_dump($master_path);exit;
                    // $dir = $master_path.$barcode."/thumb/";//getBarcodePrv_no
                    // $dir = $master_path.$getBarcodePrv_no."/thumb/";
                    // var_dump($dir);exit;
                    // $dir = preg_replace("/[\r\n]*/","",$dir);

                    $dir = $master_path.$getBarcodePrv_no.'/';



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

                              $url = $dir.$parts['0'].'.'.$extension;
                              $image_name = $parts['0'].'.'.$extension;
                              // Find MPN from Image Name
                              $mystring = $image_name;
                              $findme   = 'MPN';
                              $pos = strpos($mystring, $findme);                              

                              ?>


                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> 
                                  <span class="tg-li">
                                    <div class="thumb imgCls" style="<?php if(@$pos !== false){ echo 'border: 5px solid #00a65a !important;'; }else{ echo 'border: 2px solid rgb(55, 152, 198) !important;';} ?> display: block; cursor: pointer!important;">

                                        <?php
                                          //$url = 'D:/item_pictures/master_pictures/'.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                          //$master_path = $data['path_query'][0]['MASTER_PATH'];

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
                                    <input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="<?php echo $image_name; ?>" title="MPN Picture" <?php if(@$pos !== false){ echo 'checked'; }?>>
                                    <!-- <span class="d_live_spn">
                                      <i title="Delete Picture" style="" id="<?php //echo $url; ?>" class="fa fa-trash delSpecificLivePictures"></i>
                                    </span>   -->                  
                                  </span>                        
                                </li>

                              <?php
                              //echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

                          }
                        }

                      } //while closing
                      closedir($dh);

                    }
                  }
                } //$getBarcodePrv_no if closing

                ?>


                    </ul>
                  </div>                    
                    
                  <div class="col-sm-12">
                    <div class="form-group">
                      <input class="btn btn-sm btn-primary save_pics" title="Save" type="button" id="save_history_master" name="save_history_master" value="Save">
                    </div>
                    <div id="pics_history_msg">
                      
                    </div>
                  </div>

                </div>
            </div>
          </div>           

          <div class="col-sm-12 "> 
            <div id="drop-img-area" class="col-sm-12 p-b">
              <label for="">Upload Pictures:</label>
              <div id="" class="col-sm-12 b-full">
                <div class="col-sm-2">                   
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                    <div class="uploadimg">
                     <form id="frmupload" enctype="multipart/form-data">
                        <input type="file" multiple="multiple" name="dekit_image[]" id="dekit_image" style="display:none"/>
                        <span id="btnupload_img" style=" font-size: 2.5em; margin-top: 0.7em; cursor: pointer;" class="fa fa-cloud-upload"></span>

                        </form>
                    </div>
                  </div>
                </div>
              
                <div id="" class="col-sm-12 p-t"> 
                  <ul id="sortable" style="height: auto !important; width: 100%;">
                     
                  <?php

                  $path = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
                  $path = $path->result_array();
                  $master_path = $path[0]['MASTER_PATH'];
                  $dir = $master_path.$barcode_prv;
                  //var_dump($dir);exit;


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

                              $url = $master_path.$barcode_prv.'/'.$parts['0'].'.'.$extension;
                              $image_name = $parts['0'].'.'.$extension;
                              // Find MPN from Image Name
                              $mystring = $image_name;
                              $findme   = 'MPN';
                              $pos = strpos($mystring, $findme);
                              //var_dump($pos);                                  

                               ?>

                                <li id="<?php echo $image_name; ?>" style="width: 230px; height: 220px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;"> 
                                  <span class="tg-li">
                                    <div class="thumb imgCls" style="<?php if(@$pos !== false){ echo 'border: 5px solid #00a65a !important;'; }else{ echo 'border: 2px solid rgb(55, 152, 198) !important;';} ?> display: block; width:96%; height:80%; background: #eee!important; margin:5px;">

                                        <?php
                                          //$url = 'D:/item_pictures/master_pictures/'.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                          //$master_path = $data['path_query'][0]['MASTER_PATH'];

                                          $url = preg_replace("/[\r\n]*/","",$url);
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                          echo '<img class="sort_img up-img zoom_01" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                  
                                                          
                                        <?php //echo '<img class="sort_img up-img" id="" name="" src="'.base_url('assets/item_pic').'/'.$parts['0'].'.'.$extension.'"/>';?>

<!--                                          <div class="img_overlay">
                                          <span><i class="fa fa-trash"></i></span> 
                                        </div> -->
                                      
                                    </div>
                                      <div class="text-center" style="width: 100px;"> 
                                        <span class="thumb_delete" style="float: left;">
                                          <i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i>
                                        </span> 
                                        <span class="d_spn" style="float: left;margin-left: 20px;"><i title="Delete Picture" style="padding: 3px;" id="<?php echo $url; ?>" class="fa fa-trash specific_delete"></i></span>
                                        <input style="float: right; margin-top: 10px;" type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="<?php echo $image_name; ?>" title="MPN Picture" <?php if(@$pos !== false){ echo 'checked'; }?>>
                                      </div>                                     

                                  </span>                        
                                </li>


                              <?php
                              //echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

                          }
                        }

                      } //while closing
                      closedir($dh);

                    }
                  }


                ?>
                    
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

                        <input class="btn btn-sm btn-success" style="margin-right: 5px;" type="button" name="mark_mpn" id="mark_mpn" title="Mark as MPN" value="Mark MPN">                        
                        <input id="master_reorder_dekit" style="margin-right: 5px;" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                          <span><i id="" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all_dekit">Delete All</i></span>
                      </div>
                    </div>
                        
                      <!--</form>-->
                  </div>
                </div>
                   
              </div> 

            </div>
          </div>

          <div class="col-sm-12">
            <!-- <div class="col-sm-12"> -->
              <div class="col-sm-12">
                <label>Picture Notes:</label>
                <div class="form-group">
                
                  <textarea name="pic_notes" id="pic_notes" value="" cols="30" rows="4" class="form-control"><?php echo htmlentities(@$data[0]['PIC_NOTES']); ?></textarea>
                </div>
              </div>        
              <div class="col-sm-2">
                <input type="button" name="saveTextArea" id="saveTextArea" class="btn btn-sm btn-primary" value="Save Notes" />
              </div>
              <div class="col-sm-6" id="saveNoteMessage">
                
              </div>
                
            <!-- </div> -->
          </div>          

        </div> <!-- row -->
      </div> <!--body-->
     </div><!--box -->
      <?php } ?>
        <!-- /.col -->
         <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    </div>
    </div>
  </section>
</div>

   
          
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Base64/1.0.1/base64.js"></script> -->
<!-- <script  src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script  src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script> -->

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
  $('#barcode_prv').focus();
  //$('#addPicsBox').hide();
  //$('#addbarcodePic').prop('disabled',true);
  // $('#tab_1').hide();
  // $('#tab_2').show();
  //reload();

});
$("#drop-img-area").on('dragenter', function (e){
    e.preventDefault();
  });

  $("#drop-img-area").on('dragover', function (e){
    e.preventDefault();
  });

  $("#drop-img-area").on('drop', function (e){
    e.preventDefault();
    var dekit_image = e.originalEvent.dataTransfer.files;
    createFormData(dekit_image);
  });
 function createFormData(image) {
    var len = image.length;

    var formImage = new FormData();
    if(len === 1){
      formImage.append('image[]', image[0]);
    }else{
      for(var i=0; i<len; i++){
        formImage.append('image[]', image[i]);
      }
    }
    uploadDekitFormData(formImage);
  }
  $("#btnupload_img").click(function(){

    var bin_name = $("#bin_id").val();
    if (bin_name == null || bin_name == ""){
      alert("Please Assign a Bin."); return false;
    } 

    $("#dekit_image").trigger("click");
  });

  $("#dekit_image").change(function(){
    var postData = new FormData($("#frmupload")[0]);
    uploadDekitFormData(postData);
  });



// $('#firstTab').on('click',function(){
//   $('#tab_1').show();
//   $('#tab_2').hide();
// });

// $('#secondTab').on('click',function(){
//   $('#tab_1').hide();
//   $('#tab_2').show();
// });


// $('#barcode_prv').on('blur',function(){
//   $('#addPicsBox').hide();
//   var barcode = $('#barcode_prv').val();
//   $('#addbarcodePic').prop('disabled',false);
//   if(barcode != ''){
//     $('.loader').show();
//     $.ajax({
//         url: '<?php //echo base_url();?>dekitting_pk_us/c_pic_shoot_us/showChildDetails', 
//         type: 'post',
//         dataType: 'json',
//         data : {'barcode':barcode},
//         success:function(data){
//           $('.loader').hide();

     
//         $('#search_Remarks').val(data.child_bar[0].DEKIT_REMARKS);
//         $('#condition_segs').val(data.child_bar[0].COND_NAME);
//         $('#singleObj').val(data.child_bar[0].OBJECT_NAME);
//         $('#search_weight').val(data.child_bar[0].WEIGHT);
//         $('#search_bin').val(data.child_bar[0].BIN_ID);

//           var barcode = $('#barcode_prv').val();
//       var condition = $('#condition_segs').val();
//       if(barcode != ''){


//         $('#addPicsBox').show();
//          $.ajax({
//             url: '<?php //echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getLivePictures', 
//             type: 'post',
//             dataType: 'json',
//             success:function(data){
//               var livePics = [];
//               //console.log(data.dir_path.length);
//               //console.log(data.image_url);
//               for(var i=0;i<data.dir_path.length;i++){

//                var radio_btn = '<input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="'+data.image_url[i]+'" title="MPN Picture">';
//                //console.log(check_box); return false;

//                var source = data.dir_path[i];
//                //console.log(source);
//                var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="save_thumbnail'+i+'" src="data:image;base64,'+source+'"/>'
//                 // img = '<img src="data:image;base64,'+source+'" id="thumbnail'+i+'"  class="sort_img up-img">';

//                 livePics.push('<li id="list'+i+'" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"><span class="tg-li"> <div class="thumb imgCl" style="display: block; border: 1px solid rgb(55, 152, 198);">'+img+'</div>'+radio_btn+'<span class="d_live_spn"><i title="Delete Picture" style="" id="'+data.uri[i]+'" class="fa fa-trash delSpecificLivePictures"></i></span></span></li>');
//               }

//               $('#live_pics').html("");
//               $('#live_pics').append(livePics.join(""));
              
//             }
//           });

        
//           $.ajax({
//             url: '<?php //echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getHistoryPics', 
//             type: 'post',
//             dataType: 'json',
//             data:{'barcode':barcode,'condition':condition},
//             success:function(data){
//               if(data != 0){

              
//                 var historyPics = [];
//                 // $('#sortable').html("");
//                 // console.log('length:'+data.dekitted_pics.length+'');
//                 //console.log(data);
//                 for(var i=0;i<data.dekitted_pics.length;i++){
//                   values = data.uri[i].split("/");
//                   //console.log(values);
//                   //console.log(values[4]);return false;
//                   one = values[4].substring(1);

//                   //console.log(one);//return false;
//                   var picture = data.dekitted_pics[i];
//                   var radio_btn = '<input type="radio" name="mpn_picture_history" id="mpn_picture_history" value="MPN_" pic_name="'+data.image_url[i]+'" title="MPN Picture">';                  
//                   //console.log(picture);
//                   // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
//                   var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+picture+'"/>';
//                   historyPics.push('<li id="list_'+i+'" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"><span class="tg-li"> <div class="thumb imgCl" style="display: block; border: 1px solid rgb(55, 152, 198);">'+img+'</div>'+radio_btn+'</span></li> ');
                   
//                 }

//                 $('#history_pics').html("");
//                 $('#history_pics').append(historyPics.join(""));
//               }else{

//               }
//             }
//           });

//           $.ajax({
//             url: '<?php //echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getBarcodePics', 
//             type: 'post',
//             dataType: 'json',
//             data:{'barcode':barcode,'condition':condition},
//             success:function(data){
//               var dirPics = [];
//               // $('#sortable').html("");
//               // console.log('length:'+data.dekitted_pics.length+'');
//               //console.log(data);
//               for(var i=0;i<data.dekitted_pics.length;i++){
//                 values = data.uri[i].split("/");
             
//                 one = values[4].substring(1);

//                 //console.log(one);//return false;
//                 var picture = data.dekitted_pics[i]; 
//                 // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
//                 var img = '<img style="width: 225px; height: 180px;" class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="dekit_image[]" src="data:image;base64,'+picture+'"/>';
//                 dirPics.push('<li style="width: 230px; height: 220px; background: #eee!important; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px; margin:5px;" id="'+values[4]+'"> <span class="tg-li"> <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);  width:100%; height:100%; background: #eee!important; margin:5px;">'+img+' <input type="hidden" name="" value=""> <div class="text-center" style="width: 100px;"> <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span> <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash specific_delete"></i></span> </div> </div> </span> </li> ');
//               }

//               $('#sortable').html("");
//               $('#sortable').append(dirPics.join(""));
//               // $('.zoom_01').elevateZoom();
//               $('.zoom_01').elevateZoom({
//                 //zoomType: "inner",
//                 cursor: "crosshair",
//                 zoomWindowFadeIn: 600,
//                 zoomWindowFadeOut: 600,
//                 easing : true,
//                 scrollZoom : true
//                });            
//               $('.loader').hide();

               
//     }
//           });
//         }else{
//           $('#addPicsBox').hide();
//           $('#barcode_prv').focus();
//         }

//         },
//         error: function(jqXHR, textStatus, errorThrown){
//            $(".loader").hide();
//            // alert('Please Enter a Valid barcode number');
//          }

//       });

//       var child_barcode = $('#barcode_prv').val();
//       $.ajax({
//         url: '<?php //echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getPicNote', 
//         type: 'post',
//         dataType: 'json',
//         data : {'child_barcode':child_barcode},
//         success:function(data){
//           $('#pic_notes').val(data[0].PIC_NOTES);
//         }
//       });  
//     }
// });

/*======== Sync Picture for Live Pictures start =========*/
$(".syncPictures").click(function(){
  $('#addPicsBox').show();
   $.ajax({
      url: '<?php //echo base_url();?>dekitting_pk_us/c_pic_shoot_us/getLivePictures', 
      type: 'post',
      dataType: 'json',
      success:function(data){
        var livePics = [];
        //console.log(data.dir_path.length);
        //console.log(data.image_url);
        for(var i=0;i<data.dir_path.length;i++){

         var radio_btn = '<input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="'+data.image_url[i]+'" title="MPN Picture">';
         //console.log(check_box); return false;

         var source = data.dir_path[i];
         var img = '<img class="sort_img up-img zoom_01" id="" name="save_thumbnail'+i+'" src="data:image;base64,'+source+'"/>'
          // img = '<img src="data:image;base64,'+source+'" id="thumbnail'+i+'"  class="sort_img up-img">';

          livePics.push('<li id="list'+i+'" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"><span class="tg-li"> <div class="thumb imgCl" style="display: block; border: 1px solid rgb(55, 152, 198);">'+img+'</div>'+radio_btn+'</span></li>');
        }

        $('#live_pics').html("");
        $('#live_pics').append(livePics.join(""));
        
      }
  });
});
/*======== Sync Picture for Live Pictures end =========*/

/*===================================
=            dele master            =
===================================*/

  $(".del_master_all_dekit").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){
    var child_barcode = $('#barcode_prv').val();
    var it_condition = $('#condition_segs').val();
      // var it_condition = $('#it_condition').val();
        //alert(master_all);
        //return false;
        $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/delete_all_master',
        data: { 
                'child_barcode':child_barcode,
                'it_condition':it_condition              
      },
       success: function (data) {
        //alert(data);return false;
        // var reload = function () {
        //     var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
        //     var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
        //     window.location.href =
        //         (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
        //         + "reload=" + new Date().getTime() + window.location.hash;
        // };
        // var href="javascript:reload();void 0;";
        
          if(data == true){
            //reload();
            $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
             // window.location.href=window.location.href; return false;
              window.location.reload();
              
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
 
          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            window.location.reload();
          }
        }
        });  
    }else{
      //$('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }
   

  });

/*=====  End of dele master  ======*/

/*============================================
=            Delete Specific images            =
============================================*/

  $(document).on('click','.specific_delete',function(){
    // alert('clicked');
     var specific_url = $(this).attr('id');
     var child_barcode = $('#barcode_prv').val();
     //alert(specific_url);return false;
     // alert(id);
    //return false;
    if(confirm('Are you sure?')){
      $('.loader').show();
        $.ajax({
          dataType: 'json',
          type: 'POST',        
          // url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/specific_img_delete',
          url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/specific_img_delete',
          data: { 'specific_url' : specific_url, 'child_barcode':child_barcode              
        },
         success: function (data) {
          // alert(data);return false;
          //  var reload = function () {
          //     var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
          //     var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
          //     window.location.href =
          //         (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
          //         + "reload=" + new Date().getTime() + window.location.hash;
          // };
          // var href="javascript:reload();void 0;";
          
            if(data == true){
              //reload();
              $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Item Picture has been deleted.');//return false;
              //window.location.href=window.location.href; return false;
              window.location.reload();
              // loadRecords();
              // $('#barcode_prv').val('');

              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
               
            }else if(data == false){
              $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Error - Item Picture has been not deleted.');
              window.location.reload();
            }
            // $('#barcode_prv').focus();
          }
          });    
      } 

  });

/*=====  End of Delete Specific images  ======*/

/*=====================================================
=  Delete All Live pictures from Master tab start     =
=====================================================*/

  $(".delLivePictures").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){

      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/deleteAllLivePictures',
        data: {},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              window.location.reload();
              
              // $('.loader').hide();
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              // $('#addPicsBox').hide();
 
          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            window.location.reload();
          }
        }
        });  
    }else{
      $('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }
   

  });

/*=====  End of Delete All Live pictures from Master tab  ======*/

/*=====================================================
=  Delete Specific selected Live picture from Master tab start     =
=====================================================*/


  $(document).on('click','.delSpecificLivePictures',function(){  
    //var master_reorder = $('#sortable').sortable('toArray');
    var pic_path = $(this).attr('id');
    //console.log(pic_path);return false;
    if(confirm('Are you sure?')){

      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/deleteSpecificLivePictures',
        data: {'pic_path':pic_path},
       success: function (data) {
        //alert(data);return false;
         // var reload = function () {
         //      var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
         //      var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
         //      window.location.href =
         //          (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
         //          + "reload=" + new Date().getTime() + window.location.hash;
         //  };
         //  var href="javascript:reload();void 0;";
          
          $('.loader').hide();
          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);

              //window.location.href=window.location.href; return false;
              window.location.reload();
              // $('.loader').hide();
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              // $('#addPicsBox').hide();
 
          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
            window.location.reload();
          }
        }
        });  
    }else{
      $('#addPicsBox').hide();
      $('#barcode_prv').focus();
    }
   

  });

/*=====  End of Specific selected Live picture from Master tab  ======*/

/*================================================
=            Update Order of pictures            =
================================================*/
$(document).on('click','#master_reorder_dekit',function () {
    var master_reorder = $('#sortable').sortable('toArray');

    // var master_barcode = '<?php //echo $this->uri->segment(4); ?>';
    var child_barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    //alert(upc+"_"+part_no+"_"+it_condition);return false;
    //alert(sortID);return false;
    $('.loader').show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'child_barcode':child_barcode,
              'condition':condition             
    },
     success: function (data) {
        // var reload = function () {
        //       var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
        //       var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
        //       window.location.href =
        //           (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
        //           + "reload=" + new Date().getTime() + window.location.hash;
        //   };
        //   var href="javascript:reload();void 0;";
          
        if(data == true){
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Order Updated Successfully !!</div>');
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
             //window.location.href=window.location.href; return false;
             window.location.reload();



        }else if(data == false){
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Order Not Updated !!</div>');
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              window.location.reload();

        }

      }
      });  

});


/*=====  End of Reorder  ======*/


function uploadDekitFormData(formData) {

  var barcode = $('#barcode_prv').val();
  var condition = $('#condition_segs').val();

  var current_bin = $("#current_bin").val();
  var remarks = $("#remarks").val();
  var bin_id = $('#bin_id').val();    
  var pic_notes = $('#pic_notes').val();    

  formData.append('barcode',barcode);
  formData.append('condition',condition);
  formData.append('current_bin',current_bin);
  formData.append('bin_id',bin_id);
  formData.append('remarks',remarks);
  formData.append('pic_notes',pic_notes);

  $('.loader').show();
  $.ajax({
    url: '<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/img_upload',
    data: formData,
    type: 'POST',
    datatype : "json",
    processData: false,
    contentType: false,
    cache: false,
    success: function(data) {
      //reload();
      // var reload = function () {
      //         var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
      //         var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
      //         window.location.href =
      //             (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
      //             + "reload=" + new Date().getTime() + window.location.hash;
      //     };
      //     var href="javascript:reload();void 0;";
          

      $('.loader').hide();
      $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully !!</div>');
      // $('#barcode_prv').val('');
      // $('#singleObj').val('');
      // $('#condition_segs').val('');
      // $('#search_weight').val('');
      // $('#search_bin').val('');
      // $('#search_Remarks').val('');
      setTimeout(function(){$('#upload_message').html("");},1000);
      //setTimeout(function(){$('#addPicsBox').hide();},2000);
      setTimeout(function(){$('#barcode_prv').focus();},1000);
      //window.location.href=window.location.href; //return false;
      window.location.reload();
        
    }
  });
  
}

  /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_master").click(function(){

    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    var radio_btn = $('input[name=mpn_picture]:checked').val();
    var pic_name = $('input[name=mpn_picture]:checked').attr('pic_name');
    var bin_id = $('#bin_id').val();
    if(bin_id == '' || bin_id == null){
      alert('Please Assign a Bin. Its Mandatory.'); 
      $('#bin_id').focus();
      return false;

    }
    //console.log(bin_id); return false;
    // console.log(pic_name);return false;
    $(".loader").show();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/save_pics_master',
      data: { 
              'barcode':barcode,
              'condition':condition,
              'radio_btn':radio_btn,
              'pic_name':pic_name,
              'bin_id':bin_id         
    },
     success: function (data) {
      //alert(data);return false;
      // var reload = function () {
      //         var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
      //         var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
      //         window.location.href =
      //             (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
      //             + "reload=" + new Date().getTime() + window.location.hash;
      //     };
      //     var href="javascript:reload();void 0;";
         
      $(".loader").hide();
        if(data == true){
          $(".loader").hide();
          //reload();
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          // alert('Master Pictures has been added.');
            //window.location.href=window.location.href; return false;
            window.location.reload();
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          window.location.reload();
        }
        // $('#barcode_prv').val('');
        // $('#addPicsBox').hide();
        $('#barcode_prv').focus();

      }
      });      
  });
  
  
  /*=====  End of save and move images on click save button  ======*/  
  /*=================================================================
  =            Save and Marks as MPN Start                         =
  =================================================================*/
   $("#mark_mpn").click(function(){
    // var upc = $('#upc').val();
    // var part_no = $('#part_no').val();
    // var it_condition = $('#it_cond').val();
    // var item_id = $("#item_id").val();
    // var manifest_id = $("#manifest_id").val();

    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    var radio_btn = $('input[name=mpn_picture]:checked').val();
    var pic_name = $('input[name=mpn_picture]:checked').attr('pic_name');
    // console.log(radio_btn);
    // console.log(pic_name);return false;
    $(".loader").show();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/saveAndMarkasMPN',
      data: { 
              'barcode':barcode,
              'condition':condition,
              'radio_btn':radio_btn,
              'pic_name':pic_name         
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
      // var reload = function () {
      //         var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
      //         var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
      //         window.location.href =
      //             (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
      //             + "reload=" + new Date().getTime() + window.location.hash;
      //     };
      //     var href="javascript:reload();void 0;";
          
        if(data == true){
          $(".loader").hide();
          //reload();
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is marked as MPN.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          // alert('Master Pictures has been added.');
           //window.location.href=window.location.href; return false;
           window.location.reload();
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Picture is not marked as MPN.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          window.location.reload();
        }
        // $('#barcode_prv').val('');
        // $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });      
  });
  
  
  /*=====  End of Save and Marks as MPN   ======*/  

  /*=========================================
  =            save history pics            =
  =========================================*/
  
  $("#save_history_master").click(function(){

    var barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
    var radio_btn = $('input[name=mpn_picture_history]:checked').val();
    var pic_name = $('input[name=mpn_picture_history]:checked').attr('pic_name');

    var bin_id = $('#bin_id').val();
    if(bin_id == '' || bin_id == null){
      alert('Please Assign a Bin. Its Mandatory.'); 
      $('#bin_id').focus();
      return false;

    }

    $(".loader").show();

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/save_history_master',
      data: { 
              'barcode':barcode,
              'condition':condition,
              'radio_btn':radio_btn,
              'pic_name':pic_name,
              'bin_id':bin_id         
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
      // var reload = function () {
      //         var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
      //         var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
      //         window.location.href =
      //             (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
      //             + "reload=" + new Date().getTime() + window.location.hash;
      //     };
      //     var href="javascript:reload();void 0;";
          
          
        if(data == true){
          //reload();
          $('#pics_history_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> History Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},2000);
            setTimeout(function(){$('#barcode_prv').focus();},2000);          
          // alert('Master Pictures has been added.');
            //window.location.href=window.location.href; return false;
            window.location.reload();
        }else if(data == false){
          $('#pics_history_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');        // $('#barcode_prv').focus();
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          window.location.reload();
        }
        //$('#barcode_prv').val('');
        //$('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });      
  });

  /*=====  End of save history pics  ======*/
  

  /*=====================================
  =            textarea save            =
  =====================================*/
  
  $('#saveTextArea').on('click',function(){
  $('.loader').show();
    var notes = $('#pic_notes').val();
    var child_barcode = $('#barcode_prv').val();
    var condition = $('#condition_segs').val();
//console.log(notes, child_barcode, condition); return false;
    $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/saveNotes',
        data: { 
                'notes':notes,
                'child_barcode':child_barcode,
                'condition':condition
              },
        success: function (data) {
          $('.loader').hide();
          // console.log(data);
          
          if(data == true){
            // $('#saveNoteMessage').append();
            $('#saveNoteMessage').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture Notes Updated Successfully !!</div>').delay(2000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Picture note saved !!');
            // $('#barcode_prv').focus();
              window.location.reload();
          }else{
            $('#saveNoteMessage').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Picture Notes Not Updated !!</div>').delay(2000).queue(function() { $(this).remove(); });
              // $('#barcode_prv').val('');
              // $('#singleObj').val('');
              // $('#condition_segs').val('');
              // $('#search_weight').val('');
              // $('#search_bin').val('');
              // $('#search_Remarks').val('');
            //setTimeout(function(){$('#addPicsBox').hide();},1000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
            // $('#barcode_prv').focus();
            window.location.reload();
          }
        }

      });
});
  
  /*=====  End of textarea save  ======*/
/*================================================
=        SET Bin ID in session call start           =
================================================*/
$(document).on('blur','#bin_id',function(){
  var bin_id = $('#bin_id').val().trim(); 
  //console.log(listId, barCode, bin_id); return false;
  if(bin_id === ''){
    alert('Please Assign a Bin to Item.');
    //$('#bin_id').focus();
    return false;
  }

  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/setBinIdtoSession',
    data: { 'bin_id':bin_id           
  },
   success: function (data) {
    //alert(data);return false;
      if(data == true){
        console.log("Success! Bin ID is added to session.");
        
      }else if(data == false){

        alert("Bin Name is Wrong.");
        $('#bin_id').val("");
        return false;
        //window.location.reload();
      }
    }
    });  

});

/*=====  End of SET Bin ID in session call  ======*/  

</script>

