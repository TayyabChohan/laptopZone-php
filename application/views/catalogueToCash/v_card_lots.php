<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); 
?>
<style type="text/css">
  .m-3{
    margin: 3px;
  } 
  .show-flag{
    border: 2px solid red;
    padding: 1px;
  }
 
 label.btn span {
  font-size: 1em ;
}

label input[type="radio"] ~ i.fa.fa-circle-o{
    color: #c8c8c8;    display: inline;
}
label input[type="radio"] ~ i.fa.fa-dot-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-circle-o{
    display: none;
}
label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
    color: red;    display: inline;
}
label:hover input[type="radio"] ~ i.fa {
color: red;
}

label input[type="checkbox"] ~ i.fa.fa-square-o{
    color: #c8c8c8;    display: inline;
}
label input[type="checkbox"] ~ i.fa.fa-check-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-square-o{
    display: none;
}
label input[type="checkbox"]:checked ~ i.fa.fa-check-square-o{
    color: #7AA3CC;    display: inline;
}
label:hover input[type="checkbox"] ~ i.fa {
color: red;
}

div[data-toggle="buttons"] label.active{
    color: red;

}

div[data-toggle="buttons"] label {
display: inline-block;
padding: 6px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: normal;
line-height: 2em;
text-align: left;
white-space: nowrap;
vertical-align: top;
cursor: pointer;
background-color: none;
border: 0px solid #c8c8c8;
border-radius: 3px;
color: black;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}

div[data-toggle="buttons"] label:hover {
color: red;
}

div[data-toggle="buttons"] label:active, div[data-toggle="buttons"] label.active {
-webkit-box-shadow: none;
box-shadow: none;
}
#contentSec{
  display: none;
}
#objectSection{
  display: none;
} 

</style> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Special Item Recognition
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Special Item Recognition</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">   
       <!-- //////////////////////////////////////////// -->
       <div class="box" id= "dyn_box3">
            <div class="box-header with-border">
              <h3 class="box-title">Add Special Lot</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button> 
            </div>
            </div>          
            <div class="box-body "> 
              <div class="col-md-12">
                <?php $special_lot_id = $this->session->userdata('special_lot_id'); ?>
                 <div class="btn-group pull-right" role="group" aria-label="Basic example">
  <a  id="special_lot_print" href="<?php echo base_url().'catalogueToCash/c_card_lots/print_single_lot/'.$special_lot_id; ?>" class="btn btn-primary" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a>
                    <input type="hidden" name="special_lot_id" id="special_lot_id" value="<?php echo $special_lot_id; ?>">
                    <a id="auto_print" href="<?php echo base_url().'catalogueToCash/c_card_lots/print_single_lot_withoutPDF/'.$special_lot_id; ?>" class="btn btn-info" target="_blank"> Auto Print </a>
                    <input type="hidden" name="auto_print" id="auto_print" value="<?php echo $special_lot_id; ?>">
                     <a target="_blank" class="btn btn-success" href="<?php echo base_url().'catalogueToCash/c_card_lots/special_lot_detail'?>">Lot Detail</a>
                     <a href="<?php echo base_url(); ?>catalogueToCash/c_card_lots/lot_special_object" class = "btn btn-danger" target="_blank">Add Object</a>

</div>             </div>
              <!-- <form method="post" action="<?php //echo base_url().'catalogueToCash/c_card_lots/add_special_lot'?>" enctype="multipart/form-data" > -->
               <?php $sessionData = $this->session->userdata("specialLot");

                //var_dump($sessionData['up_cond_item']); 
               ?>
              <form method="post" action="<?php echo base_url().'catalogueToCash/c_card_lots/syncDevice'?>">
              <div class="col-sm-12"><!-- Custom Tabs -->
                
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Special Lot UPC" class="control-label">UPC:</label>
                    <input type="text" name="card_upc" id="card_upc" placeholder="Enter UPC" class="form-control card_upc" value="<?php if(isset($_POST['card_upc'])){ echo $_POST['card_upc']; }?>">
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Special Lot MPN" class="control-label">MPN:</label>
                    <input type="text" name="card_mpn" id="card_mpn" placeholder="Enter MPN" class="form-control card_mpn" value="<?php if(isset($_POST['card_mpn'])){ echo $_POST['card_mpn']; }?>">
                  </div>
                </div>
              
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Special Lot Bin/Rack" class="control-label">BIN/RACK:</label>
                    <select class="selectpicker form-control up_bin_rack" data-live-search ="true" id="up_bin_rack"  name="up_bin_rack">
                      <option value = "0">Select Bin</option>
                      <?php 
                      if(isset($_POST['up_bin_rack'])){ $up_bin_rack =  $_POST['up_bin_rack']; }else{
                        $up_bin_rack = '';
                      }

                      foreach ($data['bin'] as $bins) {
                        if ($bins['BIN_ID'] == $sessionData['up_bin_rack']) {
                          $seledted = "selected";
                        }elseif ($bins['BIN_ID'] == $up_bin_rack) {
                          $seledted = "selected";
                        }else{
                          $seledted = "";
                        }
                      ?>
                          <option value="<?php echo $bins['BIN_ID']; ?>" <?php echo $seledted; ?>><?php echo $bins['BIN_NO']; ?></option>
                      <?php 
                        }
                      ?>
                    </select>
                  </div>
                </div>
                
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Special Lot Object" class="control-label">Object:</label>
                    <select class=" selectpicker form-control up_object_desc"  data-live-search ="true" id="up_object_desc" name="up_object_desc" >
                      
                      <option value="">Select Object</option>
                      <?php 
                      // var_dump($up_object_desc);
                      // exit;
                      if(isset($_POST['up_object_desc'])){ $up_object_desc =  $_POST['up_object_desc']; }else{
                        $up_object_desc = '';
                      }
                      foreach ($data['obj'] as $object) {
                        if ($object['OBJECT_ID'] == $up_object_desc) {
                          $seledted = "selected";
                        }elseif ($object['OBJECT_ID'] == $sessionData['up_object_desc']) {
                          $seledted = "selected";
                        }else{
                          $seledted = "";
                        }
                      ?>
                        <option value="<?php echo $object['OBJECT_ID']; ?>" <?php echo $seledted; ?>><?php echo $object['OBJECT_NAME']; ?></option>
                      <?php 
                        }
                      ?>
                    </select>
                  </div>
                </div>
                
                 <div class="col-sm-2">
                  <div class="form-group">
                    <label for="" class="control-label">Enter Qty:</label>
                    <input type="number" name="ent_qty" id="ent_qty" placeholder="Qty" class="form-control up_remarks" value="1">
                  </div>
                </div>
              </div>
               <div class="col-sm-12">

                <div class="form-group p-t-24">
                    <label for="Packing Type" class="cotrol-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Conditions:</label>
                   <div class="btn-group btn-group-horizontal" data-toggle="buttons">
                    <?php 
                    if(isset($_POST['up_cond_item'])){ $up_cond_item =  $_POST['up_cond_item']; }else{
                        $up_cond_item = '';
                      }
                      foreach ($data['conds'] as $cond) {
                        if ($cond['ID'] == 3000) {
                          $checked = 'checked="checked"';
                        }elseif($cond['ID'] == $up_cond_item){
                          $checked = 'checked="checked"';
                        }else{
                          $checked = "";
                        } 
                        ?>
                          <label class="btn ">
                          <input type="radio" name='up_cond_item' id='up_cond_item' value="<?php echo $cond['ID']; ?>" <?php echo $checked; ?> ><i class="fa fa-circle-o fa-2x" style="font-size: 1em;"></i><i class="fa fa-dot-circle-o fa-2x" style="font-size: 1em; "></i> <span>&nbsp;<?php echo $cond['COND_NAME']; ?></span>
                        </label>
                      <?php 
                        }
                      ?>
                  
                  </div>
                </div>
                
              </div>
             
              <div class="col-md-12"><!-- Custom Tabs -->
                <div class="col-sm-2 ">
                <div class="form-group">
                   
                   <label for="Search Webhook">Select Lot</label>
              <?php if(isset($_POST['merch_id']))
              { 
                $mer_set_id =  $_POST['merch_id']; 

              }else{
                    $mer_set_id = '';
                   }
              ?>

              <select class="form-control selectpicker " name="merch_id" id="merch_id" data-live-search="true" >
              <option value="">Select Lot</option>
              <?php
              foreach($data['merch_lot'] as  $merc_id) {
              ?>
              <option value="<?php echo $merc_id['LOT_ID']; ?>"

                <?php 
                if($mer_set_id == $merc_id['LOT_ID'])
                  {echo "selected";}
                elseif($merc_id['LOT_ID'] == $sessionData['merch_id'])
                  {echo "selected"; }?>
                ><?php echo $merc_id['LOT_DESC']; ?>
                  

                </option>
              <?php
              }
              ?>
              </select>           

                </div>
              </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Brand Name" class="control-label">Brand:</label>
                     <input type="text" name="brand_name" id="brand_name" placeholder="Enter Brand Name" class="form-control brand_name" value="<?php if(isset($_POST['brand_name'])){ echo $_POST['brand_name']; }?>">
                  </div>
                </div>
                <!--  <input type="submit" name="newsubmit" value="submit"> -->
               
                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="">MPN Description:</label><span>Maximum of 80 characters - 
                    <input class="c-count" type="text" id='titlelength' name="titlelength" size="3" maxlength="3" value="80" readonly style=""> characters left</span><br/>
                    <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onKeyDown="textCounter(this,80);" maxlength="80" onKeyUp="textCounter(this,'titlelength' ,80)"  value="<?php if(isset($_POST['mpn_description'])){ echo $_POST['mpn_description']; }?>">
                  </div>
                </div>
                            

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Special Lot Remarks" class="control-label">Remarks:</label>
                    <input type="text" name="up_remarks" id="up_remarks" placeholder="Enter Remarks" class="form-control up_remarks" value="<?php if(isset($_POST['up_remarks'])){ echo $_POST['up_remarks']; }?>">
                  </div>
                </div>


               
              </div>

             

              <!--- start image loading box -->

      </div> <!--body-->
     </div><!--box --> 
       <!--- start image loading box -->
      <div class="box" id ="addPicsBox">
        <div class="box-header">
          <h3 class="box-title">Add Pictures</h3>
        </div>
        <div class="box-body">
        <div class="row">
          <!-- // history picture code start
          ///////////////////////////// -->
          <div class="col-sm-12">
            <div class="col-sm-12 p-b">
                <label for="History Pictures From PhotoLab">History Pictures:</label>
                <div id="" class="col-sm-12 b-full">         
                  <div id="" class="col-sm-12 p-t docs-galley"> 
                   <ul id="history_live_pics" class="docs-pictures clearfix" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
                         
                                 
                    </ul>
                  </div>                    
                    <input   type="hidden" id="fol_name" name="fol_name" value="">    
                  <div class="col-sm-12">
                    <div class="col-sm-1">
                      <div class="form-group">
                        <input class="btn btn-sm btn-success save_hist_pic" title="Save" type="button" id="save_hist_pic" name="save_hist_pic" value="Save">
                      </div>
                    </div>
                    <div class="col-sm-7">     
                      <div id="pics_insertion_msg">
                        
                      </div>
                    </div>
                                        
                  </div>
                
              </div>
            </div>
          </div>


          <!-- // history picture code end
          ///////////////////////////// -->
          <div class="col-sm-12">
            <div class="col-sm-12">
              <label>Picture Notes:</label>
              <div class="form-group">
                <textarea name="pic_notes" id="pic_notes" value="" cols="30" rows="4" class="form-control"><?php echo htmlentities(@$data[0]['PIC_NOTES']); ?></textarea>
              </div>
            </div>      
           
          </div>
         <div class="col-sm-12">
            <div class="col-sm-12 p-b">
                <label for="Live Pictures From PhotoLab">Master Pictures:</label>
                <div id="" class="col-sm-12 b-full">         
                  <div id="" class="col-sm-12 p-t docs-galley"> 
                   <ul id="live_pics" class="docs-pictures clearfix" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;">                    
                  <?php
                  $session_path_id = 0;
                  $master_path = '';
                  $session_path_id = $this->session->userdata('syncDeviceLivePathId');
                  if (empty($live_path_id) AND empty($session_path_id)) {
                    $paths = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = 2");
                    $path = $paths->result_array();
                    $master_path = $path[0]['LIVE_PATH'];
                    
                  }
                  else
                  {
                     if (!empty($live_path_id)) {
                      $paths = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = $live_path_id");
                      $path = $paths->result_array();
                      $master_path = $path[0]['LIVE_PATH'];
                    }elseif($session_path_id !=''){
                      $paths = $this->db->query("SELECT LIVE_PATH FROM LZ_PICT_PATH_CONFIG  WHERE PATH_ID = $session_path_id");
                      $path = $paths->result_array();
                      $master_path = $path[0]['LIVE_PATH'];
                    }
                  }
                 
                  //var_dump($master_path); 
                  $dir = $master_path;
                  //var_dump($dir);
                   $dir = preg_replace("/[\r\n]*/","",$dir);
                  // Open a directory, and read its contents
                  if (is_dir($dir)){
                    if ($dh = opendir($dir)){

                      $i=1;
                      while (($file = readdir($dh)) !== false){
                        $parts = explode(".", $file);
                        if (is_array($parts) && count($parts) > 1){
                            $extension = strtoupper(end($parts));
                            if (!empty($extension)) {
                              if ($extension ==='JPG' || $extension ==='GIF' || $extension ==='PNG' || $extension ==='BMP' || $extension ==='JPEG') {
                                 //var_dump($extension, $master_path);
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
                                      
                                    </div>
                                    <input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="<?php echo $image_name; ?>" title="MPN Picture">
                                    <span class="d_live_spn">
                                      <i title="Delete Picture" style="" id="<?php echo $url; ?>" class="fa fa-trash delSpecificLivePictures"></i>
                                    </span>                    
                                  </span>                        
                                </li>

                              <?php
                              }
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
                    <div class="col-sm-7">     
                      <div id="pics_insertion_msg">
                        
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group pull-right">
                        <input class="btn btn-sm btn-primary syncPictures <?php if($session_path_id == 2){ echo 'btn-success'; }elseif(empty($session_path_id) AND empty($live_path_id)){ echo 'btn-success'; }else{ echo 'btn-primary'; }?>"  title="Sync PS1 Pictures" type="submit" id="syncPicturesps1" name="syncPictures" value="PS1" style="margin-right: 5px;">
                        <input class="btn btn-sm syncPictures <?php if($session_path_id == 5){ echo 'btn-success'; }else{ echo 'btn-primary'; } ?>"  title="Sync PS2 Pictures" type="submit" id="syncPicturesps2" name="syncPictures" value="PS2" style="margin-right: 5px;">
                        <input class="btn btn-sm btn-danger delLivePictures" title="Delete Live Pictures" type="button" id="delLivePictures" name="delLivePictures" value="Delete All">
                      </div>
                    </div>                    
                  </div>
                </form>
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
                        <input id="master_reorder_dekit" style="margin-right: 5px;" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                          <span><i id="" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all_dekit">Delete All</i></span>
                      </div>
                    </div> 
                  </div>
                </div>
                 
              </div> 

            </div>
          </div>
        </div> <!-- row -->
      </div> <!--body-->
     </div><!--box -->                      
      <!-- //////////////////////////////////////////// -->
      <!-- Dynamic table append input rows Barcode Detail Table Start  -->
    </section>
      <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
  </div>

         
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer'); ?>

<script text="javascript">
  var tableData = '';
    $(document).ready(function(){
      $("#save_hist_pic").prop("disabled", false);
      $("#save_pics_master").prop("disabled", false);

      $(document).on('click', '#special_lot_print', function(){
        var special_lot_id = $("#special_lot_id").val();
        if (special_lot_id == null || special_lot_id == '') {
          alert('For print enter the new entry');
          return false;
        } 
      });

      $('#dyn_box').hide();
      $('#dyn_box2').hide();
      //$('#dyn_box3').hide();
      /*$(document).on('click', '#syncPictures', function(){
        $("#contain_values").trigger('click');
        window.location.reload();
      });*/
    });
    /*=====  End of Reorder  ======*/


function loadFirstRow(){
  var l=0;
  $("#update_add").prop("disabled", true);
 
  var up_bin_id = $('#up_bin_rack'+l).val();

  var category = $('#it_cat').val();
  // var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];
        conditions = [];
       // alert(data.length);return false;
       /////////////////////////////////////
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
        }
        ////////////////////////////////////

        for(var k = 0;k<data.bin.length;k++){
        bin.push('<option value="'+data.bin[k].BIN_ID+'">'+data.bin[k].BIN_NO+'</option>')
        }
        /////////////////////////////////////

        /////////////////////////////////////
         for(var k = 0;k<data.bin.length;k++){
            if (data.bin[k].BIN_ID == up_bin_id) {
              var bin_selected = "selected";
            }else{
              var bin_selected = "";
            }
            bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
        }
        ////////////////////////////////////////
        /////////////////////////////////////
         for(var k = 0;k<data.conds.length;k++){
            if (data.conds[k].ID == 3000) {
              var bin_selected = "selected";
            }else{
              var bin_selected = "";
            }
            conditions.push('<option value="'+data.conds[k].ID+'" '+bin_selected+'>'+data.conds[k].COND_NAME+'</option>');
        }
        ////////////////////////////////////////
        //console.log(bin); 
        $('#tab_add_onupdate').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+l+'" name="sr_no" value=""  readonly></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_upc" id="card_upc_'+l+'" name="card_upc" value="" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_mpn" id="card_mpn_'+l+'" name="card_mpn" value="" style="width:140px;"></div></td><td style="width:200px;"><div style="width:200px;"> <select id="up_cond_item'+l+'" style="width:200px;" name="up_cond_item" class="form-control up_cond_item">'+conditions.join("")+'</select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control up_object_desc" style="width:270px;" data-live-search ="true" id="up_object_desc'+l+'" name="up_object_desc" >'+obj.join("")+'</select> </div></td> <td><button class="btn btn-primary btn-sm upload_card_img" id="upload_card_img">Uplaod Image</td> <td style="width:140px;"><div style="width:140px;"> <select class="form-control up_bin_rack" data-live-search ="true" id="up_bin_rack'+l+'"  name="up_bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td><div style="float:left;margin-right:8px;"><a href="" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a> </div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control up_remarks" id="up_remarks'+l+'"  name="up_remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+l+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>');
         //$('.up_cond_item').selectpicker();
         $('.up_object_desc').selectpicker();
         $('.up_bin_rack').selectpicker();
          $("#update_add").prop("disabled", false);

         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      });
  l++;

}
    /*=========================================================
  function on add button for append new field for input start on update add
  ===========================================================*/
 var l=0;
 $('#update_add').on('click',function(){
  $("#update_add").prop("disabled", true);
 
  var up_bin_id = $('#up_bin_rack'+l).val();

  var category = $('#it_cat').val();
  // var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];
        conditions = [];
       // alert(data.length);return false;
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
        }

        for(var k = 0;k<data.bin.length;k++){
        bin.push('<option value="'+data.bin[k].BIN_ID+'">'+data.bin[k].BIN_NO+'</option>')
        }
         for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == up_bin_id) {
            var bin_selected = "selected";
          }else{
            var bin_selected = "";
          }
        bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
      
        }

         ////////////////////////////////////////
        /////////////////////////////////////
         for(var k = 0;k<data.conds.length;k++){
            if (data.conds[k].ID == 3000) {
              var bin_selected = "selected";
            }else{
              var bin_selected = "";
            }
            conditions.push('<option value="'+data.conds[k].ID+'" '+bin_selected+'>'+data.conds[k].COND_NAME+'</option>');
        }
        ////////////////////////////////////////
        //console.log(bin); 
        $('#tab_add_onupdate').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+l+'" name="sr_no" value=""  readonly></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_upc" id="card_upc_'+l+'" name="card_upc" value="" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"><input type="text" class="form-control card_mpn" id="card_mpn_'+l+'" name="card_mpn" value="" style="width:140px;"></div></td><td style="width:200px;"><div style="width:200px;"> <select id="up_cond_item'+l+'" style="width:200px;" name="up_cond_item" class="form-control up_cond_item">'+conditions.join("")+'</select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control up_object_desc" style="width:270px;" data-live-search ="true" id="up_object_desc'+l+'" name="up_object_desc" >'+obj.join("")+'</select> </div></td> <td><button class="btn btn-primary btn-sm upload_card_img" id="upload_card_img">Uplaod Image</td> <td style="width:140px;"><div style="width:140px;"> <select class="form-control up_bin_rack" data-live-search ="true" id="up_bin_rack'+l+'"  name="up_bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td><div style="float:left;margin-right:8px;"><a href="" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a> </div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control up_remarks" id="up_remarks'+l+'"  name="up_remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+l+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>'); 

         //$('.up_cond_item').selectpicker();
         $('.up_object_desc').selectpicker();
         $('.up_bin_rack').selectpicker();
          $("#update_add").prop("disabled", false);

         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      });
        l++;
         
});// function on add button for append new field for input on update add end  

 /*=========================================================
  save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  start
  ===========================================================*/ 
 $('#add_onupdate_save').on('click', function(){ 
  //console.log("add on update ");
  //return false;
  var arr=[];
  var card_upc =[];
  var card_mpn =[];
  var up_cond_item =[];
  var up_object_desc =[];
  var up_bin_rack =[];
  var up_remarks =[];
  var up_weight_in =[];

  var count_table_rows= $("body #tab_add_onupdate tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "tab_add_onupdate";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);

  for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".up_cond_item").each(function() {
              if($(this).val() != ""){
              up_cond_item.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".card_upc").each(function() {
              if($(this).val() != ""){
              card_upc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".card_mpn").each(function() {
              if($(this).val() != ""){
              card_mpn.push($(this).val());
            }
            });

            $(tdbk.rows[i]).find(".up_object_desc").each(function() {
              if($(this).val() != ""){
              up_object_desc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".up_weight_in").each(function() {
              //if($(this).val() != ""){
              up_weight_in.push($(this).val());
            //}
            }); 
            $(tdbk.rows[i]).find(".up_bin_rack").each(function() {
              if($(this).val() != ""){
              up_bin_rack.push($(this).val());
            }
            }); 

            $(tdbk.rows[i]).find('.up_remarks').each(function() {
             // if($(this).val() != ""){
              up_remarks.push($(this).val());
            //}
            });                         
          } 
                

  var url='<?php echo base_url() ?>catalogueToCash/c_card_lots/add_special_lot';
  $(".loader").show();  
  $.ajax({  
          url:url,  
          type: 'POST',
           dataType: 'json',
          data: {
            'card_upc': card_upc,
            'card_mpn': card_mpn,
            'up_cond_item': up_cond_item,
            'up_object_desc': up_object_desc,
            'up_bin_rack': up_bin_rack,
            'up_weight_in': up_weight_in,
            'up_remarks': up_remarks,
            'master_barcode': master_barcode
          },
          success: function(data) {
            $('.loader').hide();
            var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";


        
            var obj = jQuery.parseJSON(data);
            if (obj.res == true) {
            var special_lot_id = obj.lot_id;
            $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully !!</div>');

            // $('#barcode_prv').val('');
            // $('#singleObj').val('');
            // $('#condition_segs').val('');
            // $('#search_weight').val('');
            // $('#search_bin').val('');
            // $('#search_Remarks').val(''); 

            var print_url='<?php echo base_url(); ?>catalogueToCash/c_card_lots/print_single_lot/'+special_lot_id;
            window.open(print_url, "_blank");
            setTimeout(function(){$('#upload_message').html("");},1000);
            //setTimeout(function(){$('#addPicsBox').hide();},2000);
            setTimeout(function(){$('#barcode_prv').focus();},1000);
            window.location.href=window.location.href; return false; 
            }  
          }
      });  
 });
 //save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end
    // get master barcode info on blur start
    //**************************************
 $(document).on('blur','#master_barcode', function(){
    var master_barcode = $(this).val();
    
    if(master_barcode == ''){ 
      //alert('Please Enter Barcode');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Warning: Please Enter Barcode No !</strong></p>');
        // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 1800); 
      $(".loader").hide();
      return false;
      

    }else{
    
    //$(".loader").show();
     $.ajax({
            type: 'POST',
            dataType: 'json',
            url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/master_barcode_det',
            data:{ 
                  'master_barcode' : master_barcode
                  },
           success: function (data) {
            $(".loader").hide();
            console.log(data);            
            
            
            if(data){
              var det =data.master_bar[0].ITEM_MT_DESC;
            var cond_seg =data.master_bar[0].CONDITIONS_SEG5;
            var mpn =data.master_bar[0].ITEM_MT_MFG_PART_NO;
            var it_cat =data.master_bar[0].CATEGORY_ID;
              $("#item_detail").val(det);             
              $("#it_cond").val(cond_seg);             
              $("#item_mpn").val(mpn);             
              $("#it_cat").val(it_cat);             
              
          }else{
            $("#item_detail").val(det);             
              $("#it_cond").val(cond_seg);             
              $("#item_mpn").val(mpn);             
              $("#it_cat").val(it_cat); 
          }
          
        }
                 
      //     }, //success
      //    complete: function(data){
      //   $(".loader").hide();
      // } 
    }); ///ajax call
   }
  });// get master barcode info on blur End
    //**************************************

//function to remove row on button class btn_remove start
       $(document).on('click','.btn_remove',function(){ 
          var row = $(this).closest('tr');
          var dynamicValue = $(row).find('.dynamic').val();
          dynamicValue = parseInt(dynamicValue);
          row.remove();
            // again call serial no function when row delete for keep serial no 
            $('.dynamic').each(function(idx, elem){
              $(elem).val(idx+1);
            });
        });
//function to remove row on button class btn_remove start


 /*=========================================================
  save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  start
  ===========================================================*/ 
 $('#dynamic-tab-save').on('click', function(){ 
  var arr=[];
  var cond_item =[];
  var object_desc =[];
  var bin_rack =[];
  var remarks =[];
  var weight_in =[];

  var count_table_rows= $("body #dynamic_tab_dekit tr").length;
  var count_rows = count_table_rows+1;
  var tableId= "dynamic_tab_dekit";
  // console.log(tableId-1);
  // return false;
  var tdbk = document.getElementById(tableId);

  for (var i = 0; i < count_rows; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[i]).find(".cond_item").each(function() {
              if($(this).val() != ""){
              cond_item.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".object_desc").each(function() {
              if($(this).val() != ""){
              object_desc.push($(this).val());
            }
            });
            $(tdbk.rows[i]).find(".weight_in").each(function() {
              //if($(this).val() != ""){
              weight_in.push($(this).val());
            //}
            }); 
            $(tdbk.rows[i]).find(".bin_rack").each(function() {
              if($(this).val() != ""){
              bin_rack.push($(this).val());
            }
            }); 

            $(tdbk.rows[i]).find('.remarks').each(function() {
             // if($(this).val() != ""){
              remarks.push($(this).val());
            //}
            });                         
          }          

  var master_barcode = $('#master_barcode').val();   

  var url='<?php echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
  $(".loader").show();  
  $.ajax({    
          type: 'POST',
          url:url,
          data: {
            'cond_item': cond_item,
            'object_desc': object_desc,
            'bin_rack': bin_rack,
            'weight_in': weight_in,
            'remarks': remarks,
            'master_barcode': master_barcode
          },
          dataType: 'json',
          success: function (data){            
              if(data == true){
                $(".loader").hide();
                  alert('Components added Successfully!');
                  $('#dyn_box').hide();
                   $('#dynamic_tab_body').html("");
                   $('#dyn_box2').show();
                  show_master_detail();                 
                 
                }else{
              alert('data not saved');
              
             }
            
           }
      });  
 });//save buton for insert dynamic_tab_dekit table values into table LZ_DEKIT_US_MT and LZ_DEKIT_US_DT  end

/*=========================================================================
=           Function for append detail in table of saved barcode Start    =
=========================================================================*/
 function show_master_detail(){

            $('#dyn_box3').show();

           var master_barcode = $('#master_barcode').val();
           console.log(master_barcode);
           
             $.ajax({
                url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/showMasterDetails', 
                type: 'post',
                dataType: 'json',
                data : {'master_barcode':master_barcode},
                success:function(data){
                  if(data.res == 2){
                  console.log('success:function');
                  var arr = [];
                  for(var i=0;i<data.det.length;i++){
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
                     var dekit = data.det[i].DEKIT_REMARKS;
                      if( typeof dekit == 'object'){
                        dekit = JSON.stringify(dekit);
                        dekit = '';
                        // alert(dekit);
                      }
                      if( dekit !== ''){
                        dekit = dekit.replace(/"/g, "'");

                      }
                      console.log(dekit);
                   

                    arr.push('<tr> <td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic_up" id="sr_no2'+i+'" name="sr_no2" value=""  readonly></div></td><td><div style="width:100px;" class="p-t-5"><button class="btn btn-xs btn-danger delete_spec" id="delete_'+data.det[i].LZ_DEKIT_US_DT_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-trash " aria-hidden="true"></span></button><button class="btn btn-xs btn-warning edit_spec" id="edit_'+data.det[i].LZ_DEKIT_US_DT_ID+'" style="margin-left: 2px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><a style="margin-left: 3px;" href="<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/print_single_us_pk/'+data.det[i].LZ_DEKIT_US_DT_ID+'" class="btn btn-primary btn-xs" target="_blank"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </a></div></td> <td><div style="width:200px;"><input type="text" id="barcode_no'+i+'" class="form-control barcode_no" value="'+data.det[i].BARCODE_PRV_NO+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="obj_name'+i+'" class="form-control obj_name" value="'+data.det[i].OBJECT_NAME+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="condition'+i+'" class="form-control condition" value="'+cond+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="weight'+i+'" class="form-control weight" value="'+data.det[i].WEIGHT+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="binRack_no'+i+'" class="form-control binRack_no" value="'+data.det[i].BIN_NO+'" readonly></div></td><td><div style="width:200px;"><input type="text" id="det_ramarks'+i+'" class="form-control det_ramarks" value="'+dekit+'" readonly></div></td> </tr>'); 

                  }


                  $('#table_body ').html("");
                  
                 $('#table_body ').append(arr.join("")); 
                 //function for adding serial no against class name dynamic start
         $('.dynamic_up').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
                  //arr = ''; 
                  $(".loader").hide();       

                  
                }
                  
                }
            });
          }
/*=======================================================================
=           Function for append detail in table of saved barcode End    =
=========================================================================*/
$(document).on('blur','#master_barcode', function(){
//$(document).on('click','#search_m_barcode',function(){
  $('#dynamic_tab_body').html('');
  var master_barcode = $('#master_barcode').val();
  //console.log(master_barcode);
  //tableData.destroy();

  $(".loader").show();

                $.ajax({
                url: '<?php echo base_url();?>dekitting_pk_us/c_pic_shoot_us/showMasterDetails', 
                type: 'post',
                dataType: 'json',
                data : {'master_barcode':master_barcode},
                success:function(data){
                  $(".loader").hide();
                  if(data == 1){
                  console.log('add barcode function');

                  $('#dyn_box').show();
                  $('#dyn_box2').hide();
                  $('#dyn_box3').hide();
  /*=========================================================
  function on add button for append new field for input start
  ===========================================================*/
 var i=0;
 $('#add').on('click',function(){
  $("#add").prop("disabled", true);
  var category = $('#it_cat').val();
  var binId = $('#bin_rack'+i).val();
  console.log(binId,'#bin_rack'+i);
  // var url='<?php //echo base_url() ?>dekitting_pk_us/c_dekitting_us/save_mast_barcode';
    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
          //console.log(data.rack_bin_id); return false;
        obj = [];
        bin = [];
        
        for(var j = 0;j<data.obj.length;j++){
        obj.push('<option value="'+data.obj[j].OBJECT_ID+'">'+data.obj[j].OBJECT_NAME+'</option>')
         
        }


        for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == binId) {
            var bin_selected = "selected";
          }else{
            var bin_selected = "";
          }
        bin.push('<option value="'+data.bin[k].BIN_ID+'" '+bin_selected+'>'+data.bin[k].BIN_NO+'</option>');
      
        }
        //console.log(bin);

        
        $('#dynamic_tab_dekit').append('<tr><td style="width:60px;"><div style="width:60px;"><input type="number" class="form-control dynamic" id="sr_no'+i+'" name="sr_no" value=""  readonly></div></td><td style="width:260px;"><div style="width:260px;"> <select id="cond_item'+i+'" style="width:260px;" name="cond_item" class="form-control cond_item" data-live-search ="true"><option value="3000">Used</option><option value="1500">New other</option><option value="2000">Manufacturer refurbished</option><option value="2500">Seller refurbished</option><option value="1000">New</option><option value="7000">For parts or not working</option></select> </div> </td><td style="width:270px;"><div style="width:270px;"><select class="form-control object_desc" style="width:270px;" data-live-search ="true" id="object_desc'+i+'" name="object_desc" >'+obj.join("")+'</select> </div></td> <td style="width:140px;"><div style="width:140px;"><input type="number" class="form-control weight_in" id="weight_in'+i+'" name="weight_in" value="0" style="width:140px;"></div></td><td style="width:140px;"><div style="width:140px;"> <select class="form-control bin_rack" id="bin_rack'+i+'"  data-live-search ="true" name="bin_rack" style="width:140px;">'+bin.join("")+'</select></div></td><td style="width:340px;"><div style="width:340px;"><input type="text" class="form-control remarks" id="remarks'+i+'"  name="remarks" style="width:340px;"></div></td><td style="width:30px;"><div style="width:30px;"><button type="button" name="remove"  style="width:30px;" id="button'+i+'" class="btn btn-sm btn-danger btn_remove fa fa-trash-o"></button></div></td></tr>'); 

         $('.cond_item').selectpicker();
         $('.object_desc').selectpicker();
         $('body .bin_rack').selectpicker();
         $("#add").prop("disabled", false);

//          var e = document.getElementById("#bin_rack");
// var strUser = e.options[e.selectedIndex].value;
//   console.log(strUser);

        //  var get = $('#bin_rack').val();
        // console.log(get);
         //function for adding serial no against class name dynamic start
         $('.dynamic').each(function(idx, elem){
          $(elem).val(idx+1);
          // console.log($(elem).val(idx+1));
         
        });//function for adding serial no against class name dynamic end
        $(".loader").hide();
      }
      }); 
      i++;        
});// function on add button for append new field for input end 
                  }else if(data == 3){
                      //alert('Please Enter Barcode');
                  $('#errorMessage').html("");
                    $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Warning: Invalid Barcode No! Try another Barcode</strong></p>')
                    // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
                     $('#errorMessage').show();
                    setTimeout(function() {
                      $('#errorMessage').fadeOut('slow');
                    }, 1800); 
                   $('#dyn_box').hide();
                    $('#dyn_box2').hide();
                    $('#dyn_box3').hide();
                    console.log('invalid barcode function');
                  return false;
                   


                  }else if(data.res == 2){
                    console.log('update barcoe function');
                    $('#errorMessage').html("");
                    $('#errorMessage').append('<p style="color:#c62828; font-size :18px;"><strong>Barcode No Already Dekited</strong></p>')
                    // $('#errorMessage').append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Warning: Please Enter Tracking # !</strong>');
                     $('#errorMessage').show();
                    setTimeout(function() {
                      $('#errorMessage').fadeOut('slow');
                    }, 1800); 
                    $('#dyn_box').hide();
                    //$('#table_body').html('');
                    $('#dyn_box2').show();

                    $(".loader").show();
                    show_master_detail();// call function which get's records against master barcode 
                  }
                }
            });
    });

  

// class = .delete_spec button for deleting records start
//*******************************************************  
$(document).on('click','.delete_spec',function(){
  var det_id = this.id.match(/\d+/);
  det_id = parseInt(det_id);
  var master_barcode = $('#master_barcode').val();
  $.ajax({
    url: '<?php echo base_url();?>dekitting_pk_us/c_dekitting_us/deleteDeKitDet', 
    type: 'post',
    dataType: 'json',
    data : {'det_id':det_id},
    success:function(data){
      if(data == 1){
        $('#danger-modal').modal('show');
        $(".loader").show();
        show_master_detail(); // call function which get's records against master barcode                 
      }
    }
  });
});// class = .delete_spec button for deleting records end
  //******************************************************


/*=============================================
=            Section comment block            =
=============================================*/
$(document).on('click','.edit_spec',function(){
  var det_id = this.id.match(/\d+/);
  det_id = parseInt(det_id);
 $('#edit-modal').modal('show');
 $("#appCat").html("");
 $('#master_barcode').val();
 var category = $('#it_cat').val();
  var master_barcode = $('#master_barcode').val();

    var obj = [];
      $.ajax({
        url:'<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/update_obj_dropdown',
        type:'post',
        dataType:'json',
        data:{'category':category},
        success:function(data){
        obj = [];
        bin = [];

        $.ajax({
          url: '<?php echo base_url();?>dekitting_pk_us/c_dekitting_us/getDetDetails', 
          type: 'post',
          dataType: 'json',
          data : {'det_id':det_id},
          success:function(result){
            console.log(result.selectable[0].OBJECT_ID);
            for(var j = 0;j<data.obj.length;j++){
          if (data.obj[j].OBJECT_ID == result.selectable[0].OBJECT_ID) {
            var objSlected = 'selected';
          }else{
            var objSlected = '';
          }
          
          obj.push('<option value="'+data.obj[j].OBJECT_ID+'" '+objSlected+'>'+data.obj[j].OBJECT_NAME+'</option>'); 
        }

        for(var k = 0;k<data.bin.length;k++){
          if (data.bin[k].BIN_ID == result.selectable[0].BIN_ID) {
            var binSlected = 'selected';
          }else{
            var binSlected = '';
          }
          bin.push('<option value="'+data.bin[k].BIN_ID+'" '+binSlected+'>'+data.bin[k].BIN_NO+'</option>');
        }
        ////////////////////////////////////////////////
        //////////////////////////////////////////
        var conditions = [];
        for(var i = 0; i<result.conds.length; i++){
          if (result.selectable[0].CONDITION_ID == result.conds[i].ID){
                var selected = "selected";
                }else{
                  var selected = "";
                } 
              conditions.push('<option value="'+result.conds[i].ID+'" '+selected+'>'+result.conds[i].COND_NAME+'</option>');
            }
        ///////////////////////////////////////////////
        var dekit_remarks = result.selectable[0].DEKIT_REMARKS;
        if (dekit_remarks == null || dekit_remarks == '') {
          dekit_remarks = '';
        }
        //////////////////////////////////////////////
              $('.bin_rackDet').html('');
              $('.object_descDet').html('');
              $('#cond_itemDet').html('');
        ///console.log(result.selectable[0].BIN_ID, result.selectable[0].OBJECT_ID);   
              $("#appCat").append('<table id="detailsOFdet" class="table table-responsive table-striped table-bordered table-hover"><thead><tr><th>Barcode</th> <th>Condition</th> <th>Object</th> <th>Weight</th> <th>BIN/Rack</th> <th>Dekitting Remarks</th></tr></thead><tbody><tr><td style="width:100px;"><div style="width:100%;"><input type="text" id="barcode_noDet" class="form-control barcode_no" value="'+result.selectable[0].BARCODE_PRV_NO+'" readonly></div></td> <td style="width:100px;"><div style="width:100%;"><select id="cond_itemDet" name="cond_item" class="selectpicker form-control cond_item" result-live-search ="true">'+conditions.join("")+'</select></div></td> <td style="width:100px;" ><div><select class="selectpicker form-control object_descDet" result-live-search ="true" id="object_descDet" name="object_desc" >'+obj.join("")+'</select> </div></td> <td style="width:100px;"><div style="width:100px;"><input type="number" class="form-control weight_in" id="weight_in_det" name="weight_in" value="'+result.selectable[0].WEIGHT+'"  ></div></td><td style="width:100px;"><div style="width:100%;"> <select class="selectpicker form-control bin_rackDet" result-live-search ="true" id="det_bin_rack"  name="bin_rack">'+bin.join("")+'</select></div></td> <td style="width:100px;"><div style="width:100%;"><input type="text" class="form-control remarks" id="detRemarkDekit"  name="remarks" value="'+dekit_remarks+'"><input id="DET_dt_id" type="hidden" value="'+result.selectable[0].LZ_DEKIT_US_DT_ID+'"></div></td></tr></tbody></table>');

              $('.bin_rackDet').selectpicker();
              $('.object_descDet').selectpicker();
              $('#cond_itemDet').selectpicker();
              }
            });
          }
        });  
});

$(document).on('click','#updateSpec',function(){
  var barcode = $('#barcode_noDet').val();
  var condition = $('#cond_itemDet').val();
  var object  = $('#object_descDet').val();
  var weight = $('#weight_in_det').val();
  var dekit_remark = $('#detRemarkDekit').val();
  var bin = $('#det_bin_rack').val();
  var det_id = $('#DET_dt_id').val();

  det_id = parseInt(det_id);
    // console.log(det_id);

  $('#master_barcode').val();
  var master_barcode = $('#master_barcode').val();

  $.ajax({
      url: '<?php echo base_url();?>dekitting_pk_us/c_dekitting_us/updateDetKit', 
      type: 'post',
      resultType: 'json',
      data : {'det_id':det_id,'bin':bin,'dekit_remark':dekit_remark,'weight':weight,'object':object,'condition':condition,'barcode':barcode},
      success:function(data){
        if(data == 1){
          $('#successMessage').text('successMessage');
          $('#successMessage').text('Updated Successfully !!!');
          $('#success-modal').modal('show');
        }else{
          alert('item not updated !');
        }
      }
  });
});

//print all button for all sticker printing start
//***********************************************
$(document).on('click','#print',function(){

  var master_barcode = $('#master_barcode').val();
  window.open("<?php echo base_url(); ?>dekitting_pk_us/c_dekitting_us/print_all_us_pk/"+master_barcode,"_blank");
});
//print all button for all sticker printing end
//*********************************************

/*$(document).on('change', ".bin_rack", function(e){
    //e.eventPreventDefault();
    var bins_id = $(this).val();
   var test =  $.session.set('bin_id', 'bins_id');
//$.session.set(‘some key’, ‘a value’);
      //var test = $.session.get("bin_id");
    //var sValue = '<%=HttpContext.Current.Session["bin_id"]%>';

    console.log(test);
  

  //   $.ajax({
  //   url: '<?php //echo base_url();?>dekitting_pk_us/c_dekitting_us/save_bin', 
  //   type: 'post',
  //   dataType: 'json',
  //   data : {'bin_id':bin_id}
  // });
  });*/
</script>
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
// var imgWidth = $(".up-img").width();

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
    uploadDragedData(formImage);
  }

  $("#btnupload_img").click(function(){

    $("#dekit_image").trigger("click");
  });

  $("#dekit_image").change(function(){
    var postData = new FormData($("#frmupload")[0]);
    var dekit_image = $("#dekit_image").val();
    //alert(dekit_image.length);
    if (dekit_image.length == 0 || dekit_image == null || dekit_image == '') {
      //alert('ll');
      return false;
    } 
    //return false;
    uploadDekitFormData(postData);
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
        // alert(master_all);
        // return false;
      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/delete_all_master',
        data: { 
                'child_barcode':child_barcode,
                'it_condition':it_condition              
      },
       success: function (data) {
        //alert(data);return false;
         var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
      
          if(data == true){
            //reload();
            $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
               window.location.href=window.location.href; return false;
              
              
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
              // setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Error -  Pictures not deleted.');
              window.location.href= window.location.href; 
              return false;
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
         var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
        
            if(data == true){
              //reload();
              $('.loader').hide();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
              // alert('Item Picture has been deleted.');//return false;
              window.location.href=window.location.href; return false;
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
               window.location.href=window.location.href; return false;
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
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/deleteAllLivePictures',
        data: {},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
          var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
        

          if(data == true){
            $('.loader').hide();
            //reload();
              $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#pics_insertion_msg').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);

              window.location.href=window.location.href; return false;
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
            $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#pics_insertion_msg').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);
            // alert('Error -  Pictures not deleted.');
           window.location.href=window.location.href; return false;
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
        url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/deleteSpecificLivePictures',
        data: {'pic_path':pic_path},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
          var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
       
          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //setTimeout(function(){$('#addPicsBox').hide();},2000);
              setTimeout(function(){$('#barcode_prv').focus();},1000);

             window.location.href=window.location.href; return false;
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
            window.location.href=window.location.href; return false;
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
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'child_barcode':child_barcode,
              'condition':condition             
    },
     success: function (data) {
        var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
       
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
             window.location.href=window.location.href; return false;



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
              window.location.href=window.location.href; return false;

        }

      }
      });  

});


/*=====  End of Reorder  ======*/


function uploadDekitFormData(formData) {

    var card_upc                = $('#card_upc').val();
    var card_mpn                = $('#card_mpn').val();
    var up_cond_item            = $("input[name='up_cond_item']:checked").val();
    var up_object_desc          = $('#up_object_desc').val();
    var up_bin_rack             = $('#up_bin_rack').val(); 
    var pic_notes               = $('#pic_notes').val(); 
    var up_remarks              = $('#up_remarks').val(); 
    var brand_name              = $('#brand_name').val(); 
    var mpn_description         = $('#mpn_description').val();  
    var merch_id         = $('#merch_id').val();  
    var ent_qty          = $('#ent_qty').val();

  formData.append('card_upc',card_upc);
  formData.append('card_mpn',card_mpn);
  formData.append('up_cond_item',up_cond_item);
  formData.append('up_object_desc',up_object_desc);
  formData.append('up_bin_rack',up_bin_rack);
  formData.append('pic_notes',pic_notes);
  formData.append('up_remarks',up_remarks);
  formData.append('brand_name',brand_name);
  formData.append('mpn_description',mpn_description);
  formData.append('merch_id',merch_id);
  formData.append('ent_qty',ent_qty);
  //console.log(formData); return false;

  $('.loader').show();
  $.ajax({
    url: '<?php echo base_url(); ?>catalogueToCash/c_card_lots/add_special_lot',
    type: 'POST',
    datatype : "json",
    processData: false,
    contentType: false,
    cache: false,
    data: formData,
    success: function(data) {
      //console.log(data); return false;
      $('.loader').hide();
      var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
       
      var obj = jQuery.parseJSON(data);
      if (obj.res == true) {
      var special_lot_id = obj.lot_id;
      $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully !!</div>');
      // $('#barcode_prv').val('');
      // $('#singleObj').val('');
      // $('#condition_segs').val('');
      // $('#search_weight').val('');
      // $('#search_bin').val('');
      // $('#search_Remarks').val(''); 
      var print_url='<?php echo base_url(); ?>catalogueToCash/c_card_lots/print_single_lot/'+special_lot_id;
      window.open(print_url, "_blank");
      setTimeout(function(){$('#upload_message').html("");},1000);
      //setTimeout(function(){$('#addPicsBox').hide();},2000);
      setTimeout(function(){$('#barcode_prv').focus();},1000);
      window.location.href=window.location.href; return false;
      }  
    }
  });
  
}
function uploadDragedData(formData) {
    var card_upc                = $('#card_upc').val();
    var card_mpn                = $('#card_mpn').val();
    var up_cond_item            = $("input[name='up_cond_item']:checked").val();
    var up_object_desc          = $('#up_object_desc').val();
    var up_bin_rack             = $('#up_bin_rack').val(); 
    var pic_notes               = $('#pic_notes').val(); 
    var up_remarks              = $('#up_remarks').val(); 
    var brand_name              = $('#brand_name').val(); 
    var mpn_description         = $('#mpn_description').val(); 
    var merch_id = $('#merch_id').val();
    var ent_qty = $('#ent_qty').val();


  formData.append('card_upc',card_upc);
  formData.append('card_mpn',card_mpn);
  formData.append('up_cond_item',up_cond_item);
  formData.append('up_object_desc',up_object_desc);
  formData.append('up_bin_rack',up_bin_rack);
  formData.append('pic_notes',pic_notes);
  formData.append('up_remarks',up_remarks);
  formData.append('brand_name',brand_name);
  formData.append('mpn_description',mpn_description);
  formData.append('merch_id',merch_id);   
  formData.append('ent_qty',ent_qty);

  $('.loader').show();
  $.ajax({
    url: '<?php echo base_url(); ?>catalogueToCash/c_card_lots/img_upload',
    type: 'POST',
    datatype : "json",
    processData: false,
    contentType: false,
    cache: false,
    data: formData,
    success: function(data) {
      //console.log(data); return false;
      var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
       

      $('.loader').hide();

      var obj = jQuery.parseJSON(data);
      if (obj.res == true) {
      var special_lot_id = obj.lot_id;
      $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully !!</div>');
      // $('#barcode_prv').val('');
      // $('#singleObj').val('');
      // $('#condition_segs').val('');
      // $('#search_weight').val('');
      // $('#search_bin').val('');
      // $('#search_Remarks').val(''); 
      var print_url='<?php echo base_url(); ?>catalogueToCash/c_card_lots/print_single_lot/'+special_lot_id;
      window.open(print_url, "_blank");
      setTimeout(function(){$('#upload_message').html("");},1000);
      //setTimeout(function(){$('#addPicsBox').hide();},2000);
      setTimeout(function(){$('#barcode_prv').focus();},1000);
      window.location.href=window.location.href; return false;
      }  
    }
  });
  
}

  /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_master").click(function(){
    $("#save_pics_master").prop("disabled", true);
    var radio_btn = $('input[name=mpn_picture]:checked').val();
    var merch_id = $('#merch_id').val();
    var ent_qty = $('#ent_qty').val();
  
    // if(merch_id == ''){

    //   alert('please SELECT LOT ');
    //   return false;
    // }
    var pic_name = $('input[name=mpn_picture]:checked').attr('pic_name');
    var card_upc          = $('#card_upc').val();
    var card_mpn          = $('#card_mpn').val();
    var up_cond_item      = $("input[name='up_cond_item']:checked").val();
    var up_object_desc    = $('#up_object_desc').val();
    var up_bin_rack       = $('#up_bin_rack').val();

    //////////////////////////////
    var pic_notes         = $('#pic_notes').val(); 
    var up_remarks        = $('#up_remarks').val(); 

    ////////////////////////////

    $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/save_pics_master',
      data: { 
              'radio_btn':radio_btn,
              'pic_name':pic_name,
              'card_upc':card_upc,
              'card_mpn':card_mpn,
              'up_cond_item':up_cond_item,
              'up_object_desc':up_object_desc,
              'pic_notes':pic_notes,
              'up_remarks':up_remarks,
              'up_bin_rack':up_bin_rack,         
              'merch_id':merch_id,         
              'ent_qty':ent_qty         
    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
      var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
        //var obj = jQuery.parseJSON(data);
       // alert(data.lot_id);
      if (data.res == true) {
      var special_lot_id = data.lot_id;
      var print_url='<?php echo base_url(); ?>catalogueToCash/c_card_lots/print_single_lot_withoutPDF/'+special_lot_id;
      window.open(print_url, "_blank");
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          // alert('Master Pictures has been added.');
            window.location.href=window.location.href; return false;
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });

            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          window.location.href=window.location.href; return false;
        }
        // $('#barcode_prv').val('');
        // $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });      
  });
  
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
      var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
        
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
           window.location.href=window.location.href; return false;
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
          window.location.href=window.location.href; return false;
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
          var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
      
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
             window.location.href=window.location.href; return false;
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
          }
        }

      });
});
  
  /*=====  End of textarea save  ======*/
  function textCounter(field,cnt, maxlimit) {         
      var cntfield = document.getElementById(cnt);

         if (field.value.length > maxlimit){ // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
        }else{
       cntfield.value = parseInt(parseInt(maxlimit) - parseInt(field.value.length));
     }
    }
      function countChar(val) {
    var len = val.value.length;
    //console.log(len);
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(parseInt(parseInt(80) - parseInt(len)));
    }
  }
  /*=========================================
  =            get history pic            =
  =========================================*/
  
//   $("#card_upc").blur(function(){

//     var upc = $('#card_upc').val();
//    // var condition = $('#condition_segs').val();
//     var condition_id = $('input[name=up_cond_item]:checked').val();
//     //var pic_name = $('input[name=mpn_picture_history]:checked').attr('pic_name');
// //console.log(upc,condition_id); return false;

//     $(".loader").show();

//     $.ajax({
//       dataType: 'json',
//       type: 'POST',        
//       url:'<?php //echo base_url(); ?>catalogueToCash/c_card_lots/getHistoryPics',
//       data: { 
//               'upc':upc,
//               'condition_id':condition_id
//     },
//      success: function (data) {
//       $(".loader").hide();

//         $("#fol_name").val(data.folder_name);
//         $("#mpn_description").val(data.mpn_description);
//         $("#card_mpn").val(data.card_mpn);
//         $("#brand_name").val(data.brand);
//        var livePics = [];
//         //console.log(data.dir_path.length);
//         //console.log(data.image_url);
//         for(var i=0;i<data.dir_path.length;i++){

//          var radio_btn = '<input type="radio" name="mpn_picture" id="mpn_picture" value="MPN_" pic_name="'+data.image_url[i]+'" title="MPN Picture">';
//          //console.log(check_box); return false;

//          var source = data.dir_path[i];
//          var img = '<img class="sort_img up-img zoom_01" id="" name="save_thumbnail'+i+'" src="data:image;base64,'+source+'"/>'
//           // img = '<img src="data:image;base64,'+source+'" id="thumbnail'+i+'"  class="sort_img up-img">';

//           livePics.push('<li id="list'+i+'" style="width: 105px; height: 125px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"><span class="tg-li"> <div class="thumb imgCl" style="display: block; border: 1px solid rgb(55, 152, 198);">'+img+'</div>'+radio_btn+'</span></li>');
//         }

//         $('#history_live_pics').html("");
//         $('#history_live_pics').append(livePics.join(""));

//       }
//       });      
//   });  

  $("#save_hist_pic").click(function(){

    

    var fol_name = $('#fol_name').val();
    var radio_btn = $('input[name=mpn_picture]:checked').val();
    var merch_id = $('#merch_id').val();
    var ent_qty = $('#ent_qty').val();

    var pic_name = $('input[name=mpn_picture]:checked').attr('pic_name');
    var card_upc          = $('#card_upc').val();
    var card_mpn          = $('#card_mpn').val();
    var up_cond_item      = $("input[name='up_cond_item']:checked").val();
    var up_object_desc    = $('#up_object_desc').val();
    if(up_object_desc == ''){
      alert('Please Select Object Id !');
      return false;
    }
    var up_bin_rack       = $('#up_bin_rack').val();

    //////////////////////////////
    var pic_notes         = $('#pic_notes').val(); 
    var up_remarks        = $('#up_remarks').val(); 
    var mpn_description        = $('#mpn_description').val(); 
    $("#save_hist_pic").prop("disabled", true);

    ////////////////////////////

    $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>catalogueToCash/c_card_lots/save_pics_master',
      data: { 
              'radio_btn':radio_btn,
              'pic_name':pic_name,
              'card_upc':card_upc,
              'card_mpn':card_mpn,
              'up_cond_item':up_cond_item,
              'up_object_desc':up_object_desc,
              'pic_notes':pic_notes,
              'up_remarks':up_remarks,
              'up_bin_rack':up_bin_rack,         
              'merch_id':merch_id,         
              'ent_qty':ent_qty,
              'fol_name':fol_name,
              'mpn_description':mpn_description


    },
     success: function (data) {
      //alert(data);return false;
      $(".loader").hide();
      var reload = function () {
            var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
            var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
            window.location.href =
                (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
                + "reload=" + new Date().getTime() + window.location.hash;
        };
        var href="javascript:reload();void 0;";
        //var obj = jQuery.parseJSON(data);
       // alert(data.lot_id);
      if (data.res == true) {
      var special_lot_id = data.lot_id;
      var print_url='<?php echo base_url(); ?>catalogueToCash/c_card_lots/print_single_lot_withoutPDF/'+special_lot_id;
      window.open(print_url, "_blank");
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          // alert('Master Pictures has been added.');
            window.location.href=window.location.href; return false;
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });

            setTimeout(function(){$('#barcode_prv').focus();},1000);          
          //alert('Error -  Pictures not added.');
          window.location.href=window.location.href; return false;
        }
        // $('#barcode_prv').val('');
        // $('#addPicsBox').hide();
        $('#barcode_prv').focus();
      }
      });         
  });

  /*=====  End of get history pic  ======*/  
</script>


