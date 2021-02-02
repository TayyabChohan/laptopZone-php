<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>
<style>
   #auth_password + .glyphicon {
   cursor: pointer;
   pointer-events: all;
 }

 
  
.north {
transform:rotate(0deg);
-ms-transform:rotate(0deg); /* IE 9 */
-webkit-transform:rotate(0deg); /* Safari and Chrome */
}
.west {
transform:rotate(90deg);
-ms-transform:rotate(90deg); /* IE 9 */
-webkit-transform:rotate(90deg); /* Safari and Chrome */
}
.south {
transform:rotate(180deg);
-ms-transform:rotate(180deg); /* IE 9 */
-webkit-transform:rotate(180deg); /* Safari and Chrome */
    
}
.east {
transform:rotate(270deg);
-ms-transform:rotate(270deg); /* IE 9 */
-webkit-transform:rotate(270deg); /* Safari and Chrome */
}


</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Seed Form
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Seed Form</li>
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
          <h3 class="box-title">Seed Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

         <?php //var_dump($data_get['result']);exit;
          if ($data_get == NULL) {
          ?>
          <div class="alert alert-info" role="alert">There is no record found.</div>
          <?php
          } else {
          // foreach ($data_get['result'] as $data_get['result'][0]) {
           
          ?>
<?php 
// $barcode =  $this->uri->segment(5);
// if(!empty(@$barcode)){
//   echo form_open('dekitting_pk_us/c_to_list_pk/update/'.$barcode,'name="update_form"','id="update_form"','role="form"');
// }else{
  echo form_open('tolist/c_tolist/update_merg','name="update_form"','id="update_form"','role="form"');
//}

?>

            <div class="col-sm-3">
              <div class="form-group">
                  <label>Item Code:</label>
                  <?php //var_dump(@$data_get['result']['result'][0]->LAPTOP_ITEM_CODE);exit; ?>
                  <input type='text' class="form-control" name="erp_code" value="<?php echo @$data_get['result'][0]->LAPTOP_ITEM_CODE; ?>" readonly >      
              </div>
            </div>
            <div class="col-sm-3 m-erp" >
                <div class="form-group">
                  <label for="">Inventory Description:</label>
                  <input type='text' class="form-control" name="inven_desc" value="<?php echo htmlentities(@$data_get['result'][0]->ITEM_MT_DESC); ?>" readonly>
                </div>
            </div>

            <!-- <div class="col-sm-3">    
              <div class="form-group">      
                  <label for="">Barcode:</label>
                  <input type="text" class="form-control" id="item_barcode" name="item_barcode" value="<?php //echo @$data_get['result'][0]->IT_BARCODE; ?>" readonly/>
                </div>
              </div> -->
                <div class="col-sm-3">
                  <label for="UPC" class="control-label">UPC:</label>
                  <div class="input-group input-group-md">
                    
                    <input type="text" class="form-control" id="upc_seed" name="upc_seed" value="<?php echo @$data_get['result'][0]->UPC; ?>" />
                    <input type="hidden" class="form-control" id="old_upc" name="old_upc" value="<?php echo @$data_get['result'][0]->UPC; ?>" />
                    <input type="hidden" class="form-control" id="old_mpn" name="old_mpn" value="<?php echo @$data_get['result'][0]->MFG_PART_NO; ?>" />
                    <div class="input-group-btn">
                        <button title="Suggest Price Against UPC" class="btn btn-info seed_suggest_price" name="price_upc" value="<?php echo @$data_get['result'][0]->UPC; ?>" type="button"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                  </div>
                </div>
            <!-- <div class="col-sm-3">    
              <div class="form-group">      
                  <label for="">UPC:</label>
                  <input type="text" class="form-control" id="upc_seed" name="upc_seed" value="<?php //echo @$data_get['result'][0]->UPC; ?>" readonly/>
                </div>
              </div> -->
            <div class="col-sm-3">  
                <div class="form-group">      
                  <label for="">SKU:</label>
                  <input type='text' class="form-control" id="sku" name="sku" value='<?php echo @$data_get['result'][0]->SKU_NO; ?>' readonly>
                </div>
              </div>  

            <div class="col-sm-2">
                <div class="form-group">      
                  <label for="">Manufacturer:</label>
                  <input type='text' class="form-control" name="manufacturer" value="<?php echo htmlentities(@$data_get['result'][0]->MANUFACTURER); ?>"  required>
                </div>
              </div>

            <!-- <div class="col-sm-3">        
                <div class="form-group">      
                  <label for="">Part No:</label>
                  <input type='text' class="form-control" id="part_no_seed" name="part_no_seed" value='<?php //echo htmlentities(@$data_get['result'][0]->MFG_PART_NO); ?>' readonly>
                </div>
            </div> -->
            <div class="col-sm-3">
              <label for="mpn" class="control-label">Part No:</label>
              <div class="input-group input-group-md">
                
                <input type='text' class="form-control" id="part_no_seed" name="part_no_seed" value='<?php echo htmlentities(@$data_get['result'][0]->MFG_PART_NO); ?>' required>
                <div class="input-group-btn">
                    <button title="Suggest Price Against MPN" class="btn btn-info seed_suggest_price" name="price_mpn" type="button" value="<?php echo htmlentities(@$data_get['result'][0]->MFG_PART_NO); ?>"><i class="glyphicon glyphicon-search"></i></button>
                </div>
              </div>
            </div>
            <div class="col-sm-3">        
                <div class="form-group"> 
                <?php
                  if(!empty(@$data_get['result'][0]->WEIGHT)){
                    $weight =  @$data_get['result'][0]->WEIGHT;
                  }else{
                    $weight = @$data_get['ship_fee_qry'][0]->WEIGHT;
                  }
                ?>     
                  <label for="">Ounce:</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="weight" name="weight" value='<?php echo $weight; ?>' >

                  <!-- <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>" required/> -->
                </div>
            </div> 
            <div class="col-sm-3">
              <div class="form-group">      
                  <label for="">eBay Site:</label>
                  <select class="form-control" id="site_id" name="site_id" required>

                    <?php
                      foreach ($site_ids as $site_id) {
                        if((int)@$data_get['result'][0]->EBAY_LOCAL === (int)$site_id['SITE_ID']){  $selected = "selected='selected'";
                          }else{
                            $selected ="";
                          }
                        echo "<option value=".$site_id['SITE_ID']." $selected>".$site_id['SITE_CODE']."</option>";
                      }
                    ?>
                    
                </select>
              </div>
            </div>
            <div class="col-sm-1">        
                <div class="form-group p-t-24"> 
                  <input id="copy_seed" class=" btn btn-sm btn-success" title="Copy Recently Updated Seed" type="button" name="copy_seed" value="Copy Seed">
                </div>
            </div>    
    
<?php 
/*==============================================
=            check pic in dekit dir            =
==============================================*/
    $querys = $this->db->query("SELECT MASTER_PATH FROM LZ_PICT_PATH_CONFIG WHERE PATH_ID = 2");
    $master_qrys = $querys->result_array();
    $master_path2 = $master_qrys[0]['MASTER_PATH'];
    // $barcode = $this->uri->segment(5);
    // $folder_name = $this->uri->segment(5);
    $dekit_pic = false;
    $last = $this->uri->total_segments();
    $record_num = $this->uri->segment($last);//ebay_id
    $ebay_id = "";
    $barcode = "";
    $folder_name = "";
    if($last === 4 ){ //if true than pic is in master_picture dir

    }else{
        if(strlen($record_num) == 12){
          $ebay_id = $record_num;
        }else{
          $barcode = $record_num;
          $folder_name = $record_num;
        }
        //var_dump($barcode);
        if(!empty($barcode)){
            $get_folder = $this->db->query("SELECT L.FOLDER_NAME FROM LZ_SPECIAL_LOTS L WHERE L.BARCODE_PRV_NO = $barcode");
            if($get_folder->num_rows() > 0){
               $get_folder = $get_folder->result_array();
               $folder_name = $get_folder[0]['FOLDER_NAME'];
               $dekit_pic = true;
            }
           $get_folder = $this->db->query("SELECT L.FOLDER_NAME FROM LZ_DEKIT_US_DT L WHERE L.BARCODE_PRV_NO = $barcode");
            if($get_folder->num_rows() > 0){
               $get_folder = $get_folder->result_array();
               $folder_name = $get_folder[0]['FOLDER_NAME'];
               $dekit_pic = true;
            }
        }
    
    }


/*=====  End of check pic in dekit dir  ======*/
$it_condition  = @$data_get['result'][0]->COND_NAME;
/*================================================================
=            check pic in master pic path i,e UPC/MPN            =
================================================================*/
    if($dekit_pic === false){
        
        $mpn = str_replace('/', '_', @$data_get['result'][0]->MFG_PART_NO);
        $master_path = $data_get['path_query'][0]['MASTER_PATH'];

        $dir =  $master_path.@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition."/";
        $dir = preg_replace("/[\r\n]*/","",$dir);
    }else{
      $dir = $master_path2.$folder_name.'/';
    }
/*=====  End of check pic in master pic path i,e UPC/MPN  ======*/

    // Open a directory, and read its contents

      if(is_dir(@$dir)){
            $iterator = new \FilesystemIterator(@$dir);
            if (@$iterator->valid()){    
              $m_flag = true;
          }else{
            $m_flag = false;
          }
      }else{
        $m_flag = false;
      }

    //if(is_dir(@$dir)){
  // $iterator = new \FilesystemIterator(@$dir);
  
  //$isDirEmpty = $iterator->valid();
//var_dump($isDirEmpty);exit();
   // if ($m_flag){
      //var_dump($dir);exit;

    
?>
              <!-- Master Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Master Pictures:</label>
              <div id="" class="col-sm-12 b-full">
                <div id="" class="col-sm-12 p-t"> 
                 <ul id="sortable" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
              <?php 
                  // Open a directory, and read its contents
                  if ($m_flag){
                    if ($dh = opendir($dir)){
                      $i=1;
                      while (($file = readdir($dh)) !== false){
                        $parts = explode(".", $file);
                        if (is_array($parts) && count($parts) > 1){
                            $extension = end($parts);
                            if(!empty($extension)){
                              ?>

                              <?php
                              $master_path = $data_get['path_query'][0]['MASTER_PATH'];
                              $url = $dir.$parts['0'].'.'.$extension;
                              ?>
                                <li id="<?php echo $parts['0'].'.'.$extension;?>" > 
                                  <span class="tg-li">

                                    <div class="thumb imgCls"  style="display: block; border: 1px solid rgb(55, 152, 198);">

                                        <?php
                                          $url = preg_replace("/[\r\n]*/","",$url);
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img zoom_01 north" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                    
                                      <div  style="width: auto;">
                                      
                                      <span class="d_spn"><i title="Save Image"  class="fa fa-check save_img_seed"></i></span>
                                      <span class="d_spn" ><i title="Rotate Pic"   class="fa fa-repeat rot_my_pic_seed"></i></span>  
                                      <span class="thumb" ><i title="Move Picture Order"  class="fa fa-arrows" aria-hidden="true"></i></span> 
                                      </div>                 
                                      </div>                 
                                  </span>                        
                                </li>

                              <?php

                          }//if(!empty($extension)){ end
                        }//if (is_array($parts) && count($parts) > 1){

                      }//while end
                      closedir($dh);
 
                    }//if ($dh = opendir($dir)){
                  }//m_flag if end


                ?>

                </ul>
                <?php $pic_dir = $master_path; 
                $condition_name = $it_condition;?>
                <input type="hidden" name="pic_dir" value="<?php echo htmlentities($pic_dir); ?>">
                <input type="hidden" name="condition_name" value="<?php echo htmlentities($condition_name); ?>">
                </div>
                                  


                <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                  <div class="col-sm-8">
                    <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                  </div>
                  <div class="col-sm-4">  
                    <div class="form-group pull-right">
                      <a title="Update Master Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/item_search/'.@$data_get['result'][0]->IT_BARCODE);?>" target="_blank">Update Master Pictures</a>
                      <input id="master_reorder_seed" class="btn btn-sm btn-success" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                      <!-- <span><i id="del_all" onclick="return confirm('are you sure?')" title="Delete All Pictures" class="btn btn-sm btn-danger">Delete All</i></span> -->
                    </div>
                    
                  <!--</form>-->
                </div>
                </div> 

              </div>
            </div>
            <!-- Master Picture section end-->
<?php if($dekit_pic === false){ ?>
              <!-- Specific Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Specific Pictures:</label>
              <div id="" class="col-sm-12 b-full">
                <div id="" class="col-sm-12 p-t">
<!-- style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"-->                                 
                 <ul id="" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
              <?php 
                  $it_condition  = @$data_get['result'][0]->COND_NAME; 
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
                  $mpn = str_replace('/', '_', @$data_get['result'][0]->MFG_PART_NO);
                  $specific_path = $data_get['path_query'][0]['SPECIFIC_PATH'];

                  $dir = $specific_path.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID;
                  $dir = preg_replace("/[\r\n]*/","",$dir);
                // $dir = "/WIZMEN-PC/item_pictures/specific_pictures/".@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID;
                  // Open a directory, and read its contents
                  // var_dump($dir);exit;
                  if (is_dir($dir)){
                    // var_dump($specific_path);exit;
                    if ($dh = opendir($dir)){
                      $i=1;
                      while (($file = readdir($dh)) !== false){
                        $parts = explode(".", $file);
                        if (is_array($parts) && count($parts) > 1){
                            $extension = end($parts);
                            if(!empty($extension)){

                            $specific_path = $data_get['path_query'][0]['SPECIFIC_PATH'];

                            $url = $specific_path.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID.'/'.$parts['0'].'.'.$extension;                              
                              ?>


                                <li id="<?php echo $parts['0'].'.'.$extension;?>" style="width: 105px; height: 105px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> <span class="tg-li">

                                    <div class="imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer !important;">


                                        <?php
                                          
                                        $url = preg_replace("/[\r\n]*/","",$url);
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img zoom_01 north" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                  
                                                          
                                      
                                      
                                    
                                    <div  style="width: auto;">
                                    <span class="thumb"><i title="Move Picture Order"  class="fa fa-arrows" aria-hidden="true"></i></span>
                                    <span class="d_spn" style="float: left;"><i title="Save Image"  class="fa fa-check save_img_seed"></i></span>
                                    <span class="d_spn" style="float: left;"><i title="Rotate Picture"   class="fa fa-repeat rot_my_pic_seed"></i></span> 

                                      
                                    </div>                     
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
                      <a title="Update Master Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/item_pic_spec/'.@$data_get['result'][0]->IT_BARCODE);?>" target="_blank">Update Specific Pictures</a>
                      <!--<input id="specific_order" class="btn btn-sm btn-success" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">-->
                      <!-- <span><i id="del_all" onclick="return confirm('are you sure?')" title="Delete All Pictures" class="btn btn-sm btn-danger">Delete All</i></span> -->
                    </div>
                    
                  <!--</form>-->
                </div>
                </div> 

              </div>
            </div>
            <!-- Specific Picture section end-->
          
            <div class="col-sm-12">
              <div class="form-group" > <label for="">Picture Notes:</label>
                
                <ol style=" font-size:15px!important;border: 1px solid #d2d6de; background-color: #eee; opacity: 1;">

                  <?php

                  foreach ( @$data_get['pic_note'] as $pic_note) {
                    if(!empty(trim($pic_note[0]['PIC_NOTE']))){
                      ?>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo trim($pic_note[0]['PIC_NOTE'])." - (<strong>".$pic_note[0]['LZ_BARCODE_ID']."</STRONG>)\n";
                      ?>
                      </li>
                      <?php
                    }
                    if(!empty($pic_note[0]['BARCODE_NOTES'])){
                      ?>
                      <P><b>Barcode Notes: </b></P>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo @$pic_note['BARCODE_NOTES'];
                      
                      ?>
                      </li>
                      <?php
                    }
           
                  }

                 foreach ( @$end_rem['end'] as $remrk){?>
                    <li style="padding: 5px 0px!important;">
                      <P><b>End Item Remarks: </b></P>
                      <?php

                      echo @$remrk['REMARKS'];
                      ?>
                      </li>
                      <?php
                    }


                  ?>
                </ol>
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group">
              <label for="">Special Remarks:</label>
                <ol style=" font-size:15px!important;border: 1px solid #d2d6de; background-color: #eee; opacity: 1;">

                  <?php
                  foreach ( @$data_get['pic_note'] as $pic_note) {
                    if(!empty(trim($pic_note[0]['SPECIAL_REMARKS']))){
                      ?>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo trim($pic_note[0]['SPECIAL_REMARKS'])." - (<strong>".$pic_note[0]['LZ_BARCODE_ID']."</STRONG>)\n";
                      ?>
                      </li>
                      <?php
                    }
                    if(!empty($pic_note[0]['BARCODE_NOTES'])){
                      ?>
                      <P><b>Barcode Notes: </b></P>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo @$pic_note['BARCODE_NOTES'];
                      
                      ?>
                      </li>
                      <?php
                    }

           
                  }
                  ?>
                </ol>

              </div>
            </div>  
<?php }else{//if($dekit_pic === false) else if?>

            <div class="col-sm-12">
               <?php
                   // var_dump($data_get['get_remark']);
                   // exit;
                ?>

              <div class="form-group">
              <label for="">Remarks:</label>
                <ol style=" font-size:15px!important;border: 1px solid #d2d6de; background-color: #eee; opacity: 1;">
                  <?php
                  foreach ( @$data_get['get_remark'] as $row) {
                    if(!empty($row['DEKIT_REMARKS'])){
                      ?>
                      <P><b>Dekit Remarks: </b></P>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo @$row['DEKIT_REMARKS'];
                      
                      ?>
                      </li>
                      <?php
                    }
                    if(!empty($row['IDENT_REMARKS'])){
                      ?>
                      <P><b>Identified Remarks: </b></P>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo @$row['IDENT_REMARKS'];
                      
                      ?>
                      </li>
                      <?php
                    }
                    if(!empty($row['BARCODE_NOTES'])){
                      ?>
                      <P><b>Barcode Notes: </b></P>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo @$row['BARCODE_NOTES'];
                      
                      ?>
                      </li>
                      <?php
                    }
                  }
                  ?>
                </ol>

              </div>
            </div> 
            <div class="col-sm-12">
              <div class="form-group" > <label for="">Picture Notes:</label>
                
                <ol style=" font-size:15px!important;border: 1px solid #d2d6de; background-color: #eee; opacity: 1;">

                  <?php
                  // var_dump(@$data_get['pic_note']);
                  // exit;
                  $i=0;
                  foreach ( @$data_get['pic_note'] as $pic_note) {
                     //var_dump($pic_note[0]['BARCODE_NOTES']);
                 // exit;

                  // foreach ($pic_note as  $note) {
                  //   var_dump($note);
                  // exit;
                  //   # code...
                  // }
                    if(!empty(trim($pic_note[0]['PIC_NOTE']))){
                      ?>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo trim($pic_note[0]['PIC_NOTE'])." - (<strong>".$pic_note[0]['LZ_BARCODE_ID']."</STRONG>)\n";
                      ?>
                      </li>
                      <?php
                    }
                    if(!empty(@$pic_note[0]['BARCODE_NOTES'])){
                       if($i==0){?>
                      <P><b>Barcode Notes: </b></P><?php }?>
                      <li style="padding: 5px 0px!important;">
                      <?php

                      echo @$pic_note[0]['BARCODE_NOTES']." - (<strong>".$pic_note[0]['LZ_BARCODE_ID']."</STRONG>)\n";
                      
                      ?>
                      </li>
                      <?php
                      $i++;
                    }
           
            
                  }
                  foreach ( @$end_rem['end'] as $remrk){?>
                    <li style="padding: 5px 0px!important;">
                      <P><b>End Item Remarks: </b></P>
                      <?php

                      echo @$remrk['REMARKS'];
                      ?>
                      </li>
                      <?php
                    }
                   
                  ?>
                </ol>
              </div>
            </div>
<?php
}// end if else ($dekit_pic === false) 
$title = @$data_get['result'][0]->ITEM_TITLE;
$desc = @$data_get['result'][0]->ITEM_MT_DESC;
$item_title = substr($title,0,80);
$item_desc = substr($desc,0,80);
//echo substr($title,0,80);

?>

              <div class="col-sm-12">
                <label for="title" class="control-label">Title:</label>Maximum of 80 characters - 
                  <span id="charNum" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left
                <div class="input-group input-group-md">
                  <input type='text' class="form-control" name="title" id="title" onkeyup="countChar(this)" value="<?php if(empty(@$item_title)){echo htmlentities(@$item_desc);}else{echo htmlentities(@$item_title);}?>"/>
                  <div class="input-group-btn">
                    <button title="Suggest Price Against Title" class="btn btn-info seed_suggest_price" name="price_title" type="button"><i class="glyphicon glyphicon-search"></i></button>
                  </div>
                </div>
                <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_for_title">Suggest Category Against Title</a>
              </div>

              <?php if(count(@$data_get['history_title'])>0){?>
              <div class="col-sm-12">
              <label for="">Recent Title From History:</label>
                <table id ="title_table" class="table table-bordered table-striped table-responsive table-hover" >
                  <!-- <caption>Recent Title</caption> -->
                  <thead>
                    <tr>
                      <th>Select</th>
                      <th>Title</th>
                      <th>List Price</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php $k = 1;
                     foreach (@$data_get['history_title'] as $value) { ?>
                      <tr>
                        <td><a class="crsr-pntr" id="select_title" onclick="selectTitle(<?php echo $k; ?>);"> Select </a></td>
                        <td><?php echo $value['ITEM_TITLE']; ?></td>
                        <td><?php echo $value['EBAY_PRICE']; ?></td>
                        <td><?php echo $value['DATE_TIME']; ?></td>
                      </tr>
                      <?php
                      $k++;
                    }//end foreach ?>
                      
                  </tbody>
                </table>
              </div>
              <?php }// end if count(@$data_get['history_title'])>0 ?>

            <div class="col-sm-2">
              <div class="form-group">
                  <label for="">Category ID:</label>
                  <input type="number" class="form-control" id="category_id" name="category_id" value="<?php echo @$data_get['result'][0]->CATEGORY_ID; ?>" required>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                  <label for="">Category Name:</label>
                  <input class="form-control" id="category_name" name="category_name" value="<?php echo htmlentities(@$data_get['result'][0]->CATEGORY_NAME); ?>">

                <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories">Suggest Category</a> &nbsp;&nbsp; <a href="<?php echo base_url();?>dashboard/dashboard/advance_categories" title="Click here for Advance Category Search" target="_blank">Advance Category Search</a><br><br>
              </div>  

            <!-- Category Result -->
            <div id="Categories_result">
            </div>            
            <!-- Category Result -->     
            </div>
            <?php
            $cond_desc  = @$data_get['result'][0]->COND_NAME;

          ?>
            <div class="col-sm-2">
              <div class="form-group">      
                  <label for="">Default Condition:</label>
               <select class="form-control" id="it_condition" name="it_condition" value="<?php echo @$data_get['result'][0]->DEFAULT_COND; ?>" >
                  <?php 
                  //var_dump($get_cond);exit;
                    foreach ($data_get['get_cond'] as $condition) {
                      if(@$data_get['result'][0]->DEFAULT_COND == $condition['ID']){  $selected = "selected='selected'";
                        }else{
                          $selected ="";
                        }
                      echo "<option value=".$condition['ID']." $selected>".$condition['COND_NAME']."</option>";
                    }
                  ?>

                </select>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group">      
                  <label for="">Return Accepted:</label>
                  <select class="form-control" id="return_option" name="return_option" value="<?php echo @$data_get['result'][0]->RETURN_OPTION; ?>" required>
                    <option value="ReturnsAccepted" <?php if(@$data_get['result'][0]->RETURN_OPTION == 'ReturnsAccepted'){echo "selected";}?>>Yes</option>
                    <option value="ReturnsNotAccepted" <?php if(@$data_get['result'][0]->RETURN_OPTION == 'ReturnsNotAccepted'){echo "selected";}?>>No</option>
                </select>
              </div>
            </div>    

            <div class="col-lg-12">
              <div class="form-group">      
                  <label for="">Default Condition Description:</label>

                  <textarea class="form-control default_desc" rows="5" id="default_description" name="default_description" value=""><?php if(!empty(@$data_get['result'][0]->DETAIL_COND)){echo htmlentities(@$data_get['result'][0]->DETAIL_COND);} ?></textarea> 

                <!--    <input class="form-control default_desc" type="text" name="default_description" id="default_description" value="<?php //if(!empty(@$data_get['result'][0]->DETAIL_COND)){echo htmlentities(@$data_get['result'][0]->DETAIL_COND);} ?>" >  -->

                </div>
              </div> 
            <div class="col-lg-12">
              <div class="form-group">      
                <label for="">Item Discription:</label><br>
                <?php
                foreach (@$data_get['macro_type'] as $type) { ?>
                  <input type="button" class="btn btn-outline-secondary btn-sm m-r-5 type_btn" value="<?php echo $type['TYPE_DESCRIPTION'];?>" id="<?php echo $type['TYPE_ID'];?>">
                <?php 
                }
                ?>
                
              </div>
            </div>
            <div id="macro_container" class="col-lg-12">
              
            </div>  
            <div id="selected_macro" class="col-lg-12">
              
            </div> 

            <div class="col-lg-12">
              <div class="form-group">      
                  <label for="">Item Discription:</label>
                  <input type="button" class="btn btn-primary pull-right m-r-5" value="Create Description" id="create_desc">
                  <input type="button" class="btn btn-primary pull-right" value="Macro Desc" id="macro_desc">
              </div>
              <a class="btn btn-primary" href="<?php echo base_url()."specifics/c_item_specifics/update_seed_spec/".@$data_get['result'][0]->IT_BARCODE; ?>" target="_blank">Update Item Specifics</a>
            </div>
              <div class="col-lg-12">
                <div class="form-group">      
                  
                  <textarea id="item_desc" style="height:200px !important;" class="form-control" rows="10" cols="80" name="item_desc" value="">
                  <?php if(empty(@$data_get['result'][0]->ITEM_DESC)){
                     if (strpos(@$data_get['result'][0]->ITEM_DESC, 'desc_div') !== false) {
                        echo "<p style='text-align: center;'><span style='font-size:32px;color:#002060'><span  style='text-decoration:underline;'><strong>".@$data_get['result'][0]->ITEM_MT_DESC."</strong></span></span></p><p style='text-align: center;'><span style='font-size:32px;color:#002060'><span style='text-decoration:underline;'><strong><br/></strong></span></span></p><p style='text-align: center;'><span style='font-size:24px;color:#000000'>This listing is for ".@$data_get['result'][0]->ITEM_MT_DESC;
                      }else{
                        echo "<div id='desc_div'><p style='text-align: center;'><span style='font-size:32px;color:#002060'><span  style='text-decoration:underline;'><strong>".@$data_get['result'][0]->ITEM_MT_DESC."</strong></span></span></p><p style='text-align: center;'><span style='font-size:32px;color:#002060'><span style='text-decoration:underline;'><strong><br/></strong></span></span></p><p style='text-align: center;'><span style='font-size:24px;color:#000000'>This listing is for ".@$data_get['result'][0]->ITEM_MT_DESC."</div>";
                        } 
                    }else{
                      if (strpos(@$data_get['result'][0]->ITEM_DESC, 'desc_div') !== false) {
                        echo @$data_get['result'][0]->ITEM_DESC;
                      }else{
                        echo "<div id='desc_div'>".@$data_get['result'][0]->ITEM_DESC."</div>";
                        } 
                    } ?>
                    </textarea>
                  
                </div>
              </div>
              
              <div class="col-lg-12">
                <div class="form-group">      
                  <label for="">Listing Rule:</label>
                  <div id="list_rule" style="height:auto !important;" class="form-control" name="list_rule" readonly="readonly">
                    <?php echo @$data_get['result'][0]->GENERAL_RULE.@$data_get['result'][0]->SPECIFIC_RULE;?>
                  </div>
                </div>
              </div>
              <?php //if(!empty(@$data_get['ship_fee_qry'][0]['SHIP_FEE'])){ ?>
              <div class="col-sm-4"> 
                  <label for="">Price:</label>
                <div class="input-group">
                  <span class="input-group-addon">US $</span>
                  <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?php echo @$data_get['result'][0]->EBAY_PRICE; ?>" required/>
                  <!--<input id="price" type="text" class="money form-control" data-mask="000,000,000,000,000.00" data-mask-clearifnotmatch="true" name="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>"/>-->
                </div>
                <span id="price_error"></span>
                  <a class="crsr-pntr seed_suggest_price" title="Click here for Price suggestion">Suggest Price</a> &nbsp;&nbsp; 
                  <a class="crsr-pntr searchActiveListing" title="Click here for Check Active Listing">Check Active Listing</a>
                  <!-- <a class="crsr-pntr" title="Click here for Advance Price Search" href="http://localhost/advance_search/advancedItemSearch.html" target="_blank">Advance Price Search</a><br> -->
  <?php if(empty(@$data_get['ship_fee_qry'][0]['SHIP_FEE'])){
            if (strpos(@$data_get['result'][0]->SHIPPING_SERVICE, 'FedEx') !== false) {?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='13.50'/>
        <?php }elseif(strpos(@$data_get['result'][0]->SHIPPING_SERVICE, 'First') !== false){ ?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='3.25'/>
        <?php }elseif(strpos(@$data_get['result'][0]->SHIPPING_SERVICE, 'Priority') !== false){ ?>
              <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='6.50'/>
           <?php   }else{ ?>
              <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='3.25'/>
           <?php   }
                  
        }else{ 
          if(is_numeric(@$data_get['ship_fee_qry'][0]['SHIP_FEE'])){?>
                
          <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='<?php echo @$data_get['ship_fee_qry'][0]['SHIP_FEE']; ?>'/>
    <?php }else{ 
                if (strpos(@$data_get['ship_fee_qry'][0]['SHIP_FEE'], 'FedEx') !== false) {?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='13.50'/>
          <?php }elseif(strpos(@$data_get['ship_fee_qry'][0]['SHIP_FEE'], 'First') !== false){ ?>
                  <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='3.25'/>
          <?php }elseif(strpos(@$data_get['ship_fee_qry'][0]['SHIP_FEE'], 'Priority') !== false){ ?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='6.50'/>
             <?php   }else{ ?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='3.25'/>
             <?php   }?>
    <?php } 
        }?>
              </div>
              <div class="col-sm-2"> 
                <div class="form-group">
                <label for="">Quantity:</label>
                  <input title= 'Available Qty to List' type="number" class="form-control" name="list_qty" id="list_qty" value='<?php echo @$data_get['list_qty'][0]['QTY']; ?>' readonly/>
                </div>
              </div>
              <div class="col-sm-1 p-t-24">
                  <div class="form-group">
                  
                    <input type="button"  title="Hold Barcode" name="holdBarcode" id="<?php echo $data_get['result'][0]->SEED_ID ?>" class="btn btn-primary holdBarcode" value="Hold Barcode"/>
                </div>
              </div>
            <div class="col-sm-4">
              <div class="form-group">      
                   <label for="">Shipping Service:</label>
                  <select  class="form-control" id="shipping_service" name="shipping_service"  value="<?php echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>">
                    <?php 
                  //var_dump($get_cond);exit;
                    foreach ($data_get['ship_serv'] as $ship_service) {
                      if(@$data_get['result'][0]->SHIPPING_SERVICE == $ship_service['SHIPING_NAME']){  $selected = "selected='selected'";
                        }else{
                          $selected ="";
                        }
                      echo "<option value=".$ship_service['SHIPING_NAME']." $selected>".$ship_service['SHIPING_NAME']."</option>";
                    }
                  ?>
                    <!-- <option value="USPSFirstClass" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option>
                    <option value="USPSParcel" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                      -->
                  </select> 
              </div>
            </div>

            <br>

              <div class="col-sm-4">

                <!--Price Result-->
                <div id="price-result">

                </div>              
                
              </div> 
              <div class="col-sm-4">

                <!--Price Result-->
                <div id="sold_price_data">

                </div>              
                
              </div>
              <div class="col-sm-4">

                <!--Price Result-->
                <div id="price_analysis">

                </div>              
                
              </div>
              <div class="col-sm-4">

                <!--Price Result-->
                <div id="price_analysis_active">

                </div>              
                
              </div>
              <div class="col-sm-4">

                <!--Price Result-->
                <div id="price_analysis_sold">

                </div>              
                
              </div>
              <div class="col-sm-4">

                <!--Price Result-->
                <div id="sys_sug_price">

                </div>              
                
              </div>
              <div class="col-sm-12">

              </div>            
 
           
            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Shipping Service Cost:</label>
                  <input class="form-control" type="number" id="shipping_cost" name="shipping_cost" readonly value="<?php echo @$data_get['result'][0]->SHIPPING_COST; ?>"/>
                </div>
            </div>      

            <div class="col-sm-4" style="display:none !important;">        
              <div class="form-group">      
                  <label for="">Additional Cost:</label>
                  <input class="form-control" type="number" id="additional_cost" name="additional_cost" readonly value="<?php echo @$data_get['result'][0]->ADDITIONAL_COST; ?>"/>
                </div>
            </div>      

            <!-- <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Site ID:</label>
                  <input class="form-control" id="site_id" name="site_id" readonly type="number" value="<?php //echo @$data_get['result'][0]->EBAY_LOCAL; ?>" required/>
                </div>
            </div>   -->  

            <div class="col-sm-4" style="display:none !important;">        
                <div class="form-group">      
                  <label for="">Listing Type:</label>
                  <select disabled="disabled" class="form-control" id="listing_type_disabled" name="listing_type" value="<?php echo @$data_get['result'][0]->LIST_TYPE; ?>" required>
                  <option value="FixedPriceItem">Fixed Price</option>
                  <option value="Auction">Auction</option>
                </select>
                <!-- Listing Type Hidden Field -->
                  <select style="display:none !important;" class="form-control" id="listing_type" name="listing_type" value="<?php echo @$data_get['result'][0]->LIST_TYPE; ?>">
                  <option value="FixedPriceItem">Fixed Price</option>
                  <option value="Auction">Auction</option>
                </select>                

              </div>
            </div>    
            
            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Currency:</label>
                  <input class="form-control" id="currency" name="currency" type="text" readonly value="<?php echo @$data_get['result'][0]->CURRENCY; ?>"/>
                </div>
            </div>    

            <div class="col-sm-4" style="display:none !important;">      
              <div class="form-group">      
                  <label for="">Ship From Country:</label>
                  <input class="form-control" id="ship_from" name="ship_from" type="text" value="US" readonly/>
                </div>
            </div>      

            <div class="col-sm-4" style="display:none !important;">
                <div class="form-group">      
                  <label for="">Zip Code</label>
                  <input type="text" class="form-control" id="zip_code" name="zip_code" readonly value="<?php echo @$data_get['result'][0]->SHIP_FROM_ZIP_CODE; ?>" required/>
                </div>
            </div>      

            <div class="col-sm-4" style="display:none !important;">
                <div class="form-group">      
                  <label for="">Shipping Source:</label>
                  <input type="text" class="form-control" id="shipping_source" name="shipping_source" readonly value="US"/>
                </div>
            </div>    

            <div class="col-sm-4" style="display:none !important;">        
              <div class="form-group">      
                  <label for="">Shipping From Location:</label>
                  <input type="text" class="form-control" id="ship_from_loc" readonly name="ship_from_loc"  value="<?php echo htmlentities(@$data_get['result'][0]->SHIP_FROM_LOC); ?>" required/>
                </div>
            </div>     

            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Payment Method:</label>
                  <input class="form-control" id="payment_method" name="payment_method" type="text" readonly value="<?php echo @$data_get['result'][0]->PAYMENT_METHOD; ?>" required/>
                </div>
            </div>      

            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Paypal Email Address:</label>
                  <input type="text" class="form-control" id="paypal" name="paypal" readonly value="<?php echo @$data_get['result'][0]->PAYPAL_EMAIL; ?>" required/>
                </div>
            </div>      

            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Dispatch Time Max (Days):</label>
                  <input type="number" class="form-control" id="dispatch_time" name="dispatch_time" readonly value="<?php echo @$data_get['result'][0]->DISPATCH_TIME_MAX; ?>"/>     
                </div>
            </div>      

            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Return Accepted:</label>
                  <select disabled="disabled" class="form-control" id="return_accepted_disabled" name="return_accepted" value="<?php echo @$data_get['result'][0]->RETURN_OPTION; ?>" required>
                    <option value="ReturnsAccepted">Yes</option>
                    <option value="ReturnsNotAccepted">No</option>
                </select>
                <!-- Return accepted hidden field -->
                  <select style="display:none !important;" class="form-control" id="return_accepted" name="return_accepted" value="<?php echo @$data_get['result'][0]->RETURN_OPTION; ?>">
                    <option value="ReturnsAccepted">Yes</option>
                    <option value="ReturnsNotAccepted">No</option>
                </select>

              </div>
            </div>    

            <div class="col-sm-4" >    
              <div class="form-group">      
                  <label for="">Return Within (Days):</label>
                  <select name="return_within" id="return_within" class="form-control">
                    <option value="14">14 Days</option>
                    <option value="30" >30 Days</option>
                    <option value="60">60 Days</option>
                  </select>
                  <input style="display:none !important;" type="number" min="14" class="form-control" id="return_within_id" name="return_within_id" readonly value="<?php if(empty(@$data_get['result'][0]->RETURN_DAYS)){echo "30";}else{echo "30";}//@$data_get['result'][0]->RETURN_DAYS;} ?>"/>
              </div>
            </div>  
            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="Bin Name">Bin:</label>
                  <input type="text" name="bin_name" class="form-control" placeholder="Scan Bin" value="<?php echo @$data_get['result'][0]->BIN_NAME; ?>" >
            </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group"> 
                  <label for="">Template Name:</label>
                  <select class="form-control" id="temp_name" name="template_name" value="<?php echo @$data_get['result'][0]->TEMPLATE_ID; ?>" required>

                  <?php 
                  foreach($temp_data as $res):
                  ?>
                  <option value="<?php echo @$res['TEMPLATE_ID']; ?>" <?php if(@$res['TEMPLATE_ID'] == @$data_get['result'][0]->TEMPLATE_ID ){echo "selected='selected'";} ?>><?php echo htmlentities(@$res['TEMPLATE_NAME']);?></option>
              <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group p-t-24">
                <a href = "" name="edit_temp" title="Edit Template" id = "edit_temp" class="btn btn-primary" target = "_blank" > Edit Template</a>
              </div>
            </div>
            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Shipping Cost Paid By:</label>
                  <select disabled="disabled" class="form-control" id="cost_paidby_disabled" name="cost_paidby" value="<?php echo @$data_get['result'][0]->SHIPPING_PAID_BY; ?>">
                    <option value="Buyer">Buyer</option>
                    <option value="Seller">Seller</option>
                </select>
                <!-- paid by hidden field -->
                <select style="display:none !important;" class="form-control" id="cost_paidby" name="cost_paidby" value="<?php echo @$data_get['result'][0]->SHIPPING_PAID_BY; ?>">
                    <option value="Buyer">Buyer</option>
                    <option value="Seller">Seller</option>
                </select>                

              </div>
            </div>
             <div class="col-sm-8">
              <div class="form-group">      
                  <label for="Other Notes">Other Notes:</label>
                  <input type="text" name="other_notes" class="form-control" value="<?php echo @$data_get['result'][0]->OTHER_NOTES; ?>">
                <!-- paid by hidden field -->
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="epid">ePID:</label>
                  <input type="number" name="item_epid" id="item_epid" class="form-control" value="<?php echo @$data_get['result'][0]->EPID; ?>">
              </div>
            </div>
            <?php
            if(!empty(@$data_get['result'][0]->UPC)){
              $epid_key = @$data_get['result'][0]->UPC;
            }else{
              $epid_key = @$data_get['result'][0]->MANUFACTURER .' '.@$data_get['result'][0]->MFG_PART_NO;
            }

            ?>
            <div class="col-sm-4">
              <label for="epid Keyword" class="control-label">Keyword For ePID:</label>
              <div class="input-group input-group-md">
                <input type="text" class="form-control" id="keyword_epid" name="keyword_epid" placeholder ="Enter Keyword to Search ePID" value="<?php echo htmlentities(@$epid_key); ?> ">
                <div class="input-group-btn">
                    <button title="Suggest ePID Against Keyword" class="btn btn-info suggest_epid" name="suggest_epid" id="suggest_epid" type="button" value=""><i class="glyphicon glyphicon-search"></i></button>
                </div>
              </div>
            </div>
            <div class='col-sm-2'>
              <div class="form-group">
              <label for="epid Keyword" class="control-label">Expiry date:</label>
                  <div class='input-group' >
                      
                      <input type='text' class="form-control" name="expiryDate"  id="expiryDate" value="<?php echo @$data_get['result'][0]->EXPIRE_DATE; ?>" >
                      <span class="input-group-addon">
                          <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                  </div>

              </div>
            </div>
            <?php if(count(@$data_get['get_epid'])>0){?>
              <div class="col-sm-12">
              <label for="">Available ePID against this Item:</label>
                <table id ="epid_table" class="table table-bordered table-striped table-responsive table-hover" >
                  <!-- <caption>Recent Title</caption> -->
                  <thead>
                    <tr>
                      <th>Select</th>
                      <th>Image</th>
                      <th>ePID</th>
                      <th>Title</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <?php $k = 1;
                     foreach (@$data_get['get_epid'] as $value) { ?>
                      <tr>
                        <td><a class="crsr-pntr" id="select_title" onclick="selectEpid(<?php echo $k; ?>);"> Select </a></td>
                        <?php if(!empty($value['IMAGEURL'])){ ?>
                        <td><div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;"><img class="sort_img up-img" id="" name="" src="<?php echo $value['IMAGEURL']; ?>"></div></td>
                        <?php }else{ ?>
                        <td></td>
                        <?php } ?>
                        <td><a target="_blank" href="https://www.ebay.com/p/<?php echo $value['EPID'];?>" ><?php echo $value['EPID']; ?></a></td>
                        <td><?php echo $value['TITLE']; ?></td>
                      </tr>
                      <?php
                      $k++;
                    }//end foreach ?>
                      
                  </tbody>
                </table>
              </div>
            <?php }else{// end if count(@$data_get['history_title'])>0 ?>  
            <div class="col-sm-12">
              <label for="">Available ePID against this Item:</label>
                <table id ="epid_table" class="table table-bordered table-striped table-responsive table-hover" >
                  <!-- <caption>Recent Title</caption> -->
                  <thead>
                    <tr>
                      <th>Select</th>
                      <th>Image</th>
                      <th>ePID</th>
                      <th>Title</th>
                    </tr>
                  </thead>

                  <tbody>
                  </tbody>
                </table>
              </div>
            <?php }
            $last = $this->uri->total_segments();
            $record_num = $this->uri->segment($last);//ebay_id
            $ebay_id = "";
            $barcode = "";
            if(strlen($record_num) == 12){
              $ebay_id = $record_num;
            }else{
              if(!empty($this->uri->segment(5))){
                $barcode = $record_num;
                $this->session->set_userdata("list_barcode",$barcode);//use in add item call
              }
              
            }

            ?>   
          <div class="col-lg-12">
          <div class="col-lg-6">
          <div class="form-group">
                      <!-- values to update seed form -->
             <input type="hidden" style="display:none;" name="seed_id" id="seed_id" value='<?php echo @$data_get['result'][0]->SEED_ID; ?>'/>
              <input type="hidden" style="display:none;" name="pic_item_id" id="pic_item_id" value='<?php echo @$data_get['result'][0]->ITEM_ID; ?>'/>
              <input type="hidden" style="display:none;" name="pic_manifest_id" id="pic_manifest_id" value='<?php echo @$data_get['result'][0]->LZ_MANIFEST_ID; ?>'/>
              <input type="hidden" style="display:none;" name="pic_condition_id" id="pic_condition_id" value='<?php echo @$data_get['result'][0]->DEFAULT_COND; ?>'/>

              <input type="hidden" style="display:none;" name="ebay_fee" id="ebay_fee" value='<?php echo @$data_get['ebay_paypal_qry'][0]['EBAY_FEE']; ?>'/>
              <input type="hidden" style="display:none;" name="paypal_fee" id="paypal_fee" value='<?php echo @$data_get['ebay_paypal_qry'][0]['PAYPAL_FEE']; ?>'/>
              <input type="hidden" style="display:none;" name="cost_price" id="cost_price" value='<?php echo @$data_get['cost_qry'][0]['COST_PRICE']; ?>'/>
              <input type="hidden" style="display:none;" name="ebay_id" id="ebay_id" value='<?php echo $ebay_id; ?>'/>
              <input type="hidden" style="display:none;" name="object_id" id="object_id" value='<?php echo @$data_get['obj_qry'][0]['OBJECT_ID']; ?>'/>
              <input type="hidden" name="list_barcode" class="list_barcode" id="list_barcode" value='<?php echo @$barcode; ?>'/>
              <!-- values to update seed form -->
               <input type="submit" name="submit" title="Update Seed" onclick="return validateMPN()" class="btn btn-primary" value="Update">

                 <?php
          }
           ?>            
            <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('tolist/c_tolist/lister_view') ?>'" class="btn btn-success">Back</button>
          </div>
            
          </div>
              <?php 
              if(!empty(@$data_get['list_qty'][0]['QTY'])){

              ?>
              <div class="col-sm-2">
                <div class="form-group">      
                    <!-- <label for="epid">ePID:</label> -->
                    <input placeholder = "Enter eBay ID to Force Revise" type="number" name="revise_ebay_id" id="revise_ebay_id" class="form-control" value="">
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="flat-red" id="bestOffer" checked="checked">
                      <label class="custom-control-label" for="defaultUnchecked">Best Offer Enable</label>
                  </div>                  
                  <!-- <input type="button" name="listOnShopify" id="listOnShopify" title="List on Shopify" style="background-color: #1c2260eb !important;" class="btn btn-success btn-md btn-block pull-right" value="List on Shopify"/> -->
                </div>
              </div> 

              <div class="col-sm-2">
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="flat-red" id="listOnShopify">
                      <label class="custom-control-label" for="defaultUnchecked">List on Shopify</label>
                  </div>                  
                  <!-- <input type="button" name="listOnShopify" id="listOnShopify" title="List on Shopify" style="background-color: #1c2260eb !important;" class="btn btn-success btn-md btn-block pull-right" value="List on Shopify"/> -->
                </div>
              </div> 
              <div class="col-sm-2">
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="flat-red" id="addQtyOnly">
                      <label class="custom-control-label" for="defaultUnchecked">Add Qty</label>
                  </div>                  
                  <!-- <input type="button" name="listOnShopify" id="listOnShopify" title="List on Shopify" style="background-color: #1c2260eb !important;" class="btn btn-success btn-md btn-block pull-right" value="List on Shopify"/> -->
                </div>
              </div> 

              <div class="col-lg-2 ">
                <div class="form-group">
                  <input type="button" name="item_list" id="item_list" call="list" title="List to eBay" class="btn btn-success btn-md btn-block pull-right" value="List"/>
                </div>
              </div>
              <?php
              }else{
                $last = $this->uri->total_segments();
                $record_num = $this->uri->segment($last);//ebay_id
                if(strlen($record_num) == 12){
                ?>

                <div class="col-sm-2">
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="flat-red" id="bestOffer" checked="checked">
                      <label class="custom-control-label" for="defaultUnchecked">Best Offer Enable</label>
                  </div>                  
                  <!-- <input type="button" name="listOnShopify" id="listOnShopify" title="List on Shopify" style="background-color: #1c2260eb !important;" class="btn btn-success btn-md btn-block pull-right" value="List on Shopify"/> -->
                </div>
              </div>
              
                <div class="col-lg-2 ">
                  <div class="form-group">
                    <input type="button" name="item_list" id="item_list" call="revise" title="Revise Item on eBay" class="btn btn-success btn-md btn-block pull-right" value="Revise"/>
                  </div>
              </div>
              <?php
                }
              }
              ?>
              <!-- </form> -->
                                 
        </div>
 <?php echo form_close(); ?>
        <div class="col-sm-12" id="target">
          <div class="form-group" id="authenticate_pass">
            
          </div>
        </div>
          
           <!-- Hidden fileds for category suggition in footer to remove error in console -->
            <div class="col-sm-4" style="display:none !important;" >
              <div class="form-group">
                <label for="Main Category" class="control-label">Main Category:</label>
                
                  <input type="text" class="form-control" id="main_category" name="main_category" required>
                </div>
              </div>

              <div class="col-sm-4" style="display:none !important;" >
              <div class="form-group">
                <label for="Sub Category" class="control-label">Sub Category:</label>
                
                  <input type="text" class="form-control" id="sub_cat" name="sub_cat" required>
 
                </div>
              </div>
              <!-- Hidden fileds for category suggition in footer to remove error in console -->
              <div class="col-sm-12 listing-msg">
              
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
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
  <!-- /.content -->
</div>  

<!-- hold barcode modal -->
<div id="holdBarcodeModal" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body">
                <section class="" style="height: 40px !important;"> 
                  <div class="col-sm-12" >
                    <div class="col-sm-6 col-sm-offset-3" id="errorMessage"></div>
                  </div>
                </section>
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #60a05b !important;">
                          <h1 class="box-title" style="color:white;">Un-Holded Barcode Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div  style="height: 500px;" class="box-body form-scroll">
                          <div class="col-sm-12 ">
                            
                            <table id="unholded_barcode_detail" class="table table-bordered table-striped ">
      
                              <thead>
                                <tr>
                                  <th style="color: black;">
                                    <div>
                                      <input class="" name="btSelectAll" type="checkbox" onclick="toggleUnholdAll(this)">&nbsp;Select All
                                    </div>
                                  </th>                   
                                  <th style="color: black;">Barcode</th>                   
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                         
                            <div class="col-sm-1 pull-left p-t-24 holdBarcodeDiv">
                              <div class="form-group">
                                <input type="button" class="btn btn-success btn-sm holdSelectedBarcode" id="1" name="holdSelectedBarcode" value="Hold" title="Hold Selected Barcode">
                              </div>
                            </div>
                          </div> <!-- nested col-sm-12 div close-->
                      </div> <!--box body close -->
                    </div><!--box  close -->
                      </div> <!--col-sm-6 close -->
                                              <!--Holded barcode box start -->

                    <div class="col-sm-6">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #a72525 !important;">
                          <h1 class="box-title" style="color:white;">Holded Barcode Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div style="height: 500px;" class="box-body form-scroll">
                          <div class="col-sm-12 ">
                            
                            <table id="holded_barcode_detail" class="table table-bordered table-striped form-scroll">
      
                              <thead>
                                <tr>
                                  <th style="color: black;">
                                    <div>
                                      <input class="" name="btSelectAll" type="checkbox" onclick="toggleHoldAll(this)">&nbsp;Select All
                                    </div>
                                  </th>                   
                                  <th style="color: black;">Barcode</th>                   
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                           </table>
                            <div class="col-sm-1 pull-left p-t-24 UnholdBarcodeDiv">
                              <div class="form-group">
                                <input type="button" class="btn btn-success btn-sm holdSelectedBarcode" id="0" name="UnholdBarcode" value="Un-Hold" title="Un-Hold Selected Barcode">
                              </div>
                            </div>               
                          </div> <!-- nested col-sm-12 div close-->
                      </div> <!--box body close -->
                    </div><!--box  close -->
                      </div> <!--col-sm-6 close -->

                    <!--Holded barcode box end -->

                    </div> <!--row close -->
                </section>
            </div> <!--modal body close -->
        </div> <!--box content close -->
    </div> <!--modal dilog close -->
</div> <!--modal close -->
<!-- hold barcode modal end -->
<?php $this->load->view('template/footer');?>


<script>



$("#return_within").val($("#return_within_id").val());
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
  var rem_char = $('#title').val().length;
  var charLeft = (80 - rem_char);
  $('#charNum').text(charLeft);
  //console.log(charLeft);

  function countChar(val) {
    var len = val.value.length;
    //console.log(len);
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(80 - len);
    }
  }

// Check for MPN Number
function validateMPN() {
    var x  = $("#part_no_seed").val();
    //alert(x);
    if (x == null || x == "") {
        alert("MPN Number is required for listing.");
        //return false;
    }
}

/*-- Suggest sold Price --*/
   $(".seed_suggest_price").click(function(){
      var button_name = $(this).attr('name');
      if(button_name == 'price_upc'){
        var UPC  = $(this).val();
        if( $(this).val().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null UPC'); return false;
        }
        var TITLE  = null;
        var MPN  = null;
      }else if(button_name == 'price_mpn'){
        if( $(this).val().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null MPN'); return false;
        }
        var UPC  = null;
        var TITLE  = null;
        var MPN  = $(this).val();
      }else if(button_name == 'price_title'){
        var TITLE  = $("#title").val();
        if( TITLE.trim().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null Title'); return false;
        }
        var UPC  = null;
        var MPN  = null;
      }else{
        var UPC  = $("#upc_seed").val();
        var TITLE  = $("#title").val();
        var MPN  = $("#part_no_seed").val();
      }
      
      //console.log(button_name,UPC,MPN,TITLE); return false;
      
      var CONDITION = $("#it_condition").val();
      var CATEGORY = $("#category_id").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
        url:'<?php echo base_url(); ?>index.php/listing/listing/get_item_sold_price',
      data:{ 
            'UPC' : UPC,
            'TITLE' : TITLE,
            'MPN' : MPN,
            'CONDITION' : CONDITION,
            'CATEGORY' : CATEGORY
            },
     success: function (data) {
     
     if(data.ack= 'Success' && data.itemCount > 0)
     {
        if(data.itemCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          $( "#sold_price_data" ).html("");
           var tr='';
           $( "#sold_price_data" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Sold Listing-End Time Soonest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='sold_price_data_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th>" );
        //  for ( var i = 1; i < data.itemCount+1; i++ ) {

           var item = data['item'];
           var price = item['basicInfo']['convertedCurrentPrice'];
           var username=item['sellerInfo']['sellerUserName'];
           if(username == 'dfwonline' || username == 'techbargains2015'){
              var tr_clr = 'style ="background-color: #7dff7d;"';
             }else{
              var tr_clr = '';
             }
           var item_url = item['basicInfo']['viewItemURL'];
           var condition = item['basicInfo']['conditionDisplayName'];
            $('<tr '+tr_clr+'>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td></tr></table></div></div>").appendTo('#sold_price_data_table');
       // }

        }
        if(data.itemCount > 1)
        {
          $( "#sold_price_data" ).html("");
           var tr='';
           $( "#sold_price_data" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Sold Listing-End Time Soonest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='sold_price_data_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th>" );
            for ( var i = 1; i < data.itemCount+1; i++ ) 
            {

             var item = data['item'][i-1];
             var price = item['basicInfo']['convertedCurrentPrice'];
             var username=item['sellerInfo']['sellerUserName'];
             if(username == 'dfwonline' || username == 'techbargains2015'){
              var tr_clr = 'style ="background-color: #7dff7d;"';
             }else{
              var tr_clr = '';
             }
             var item_url = item['basicInfo']['viewItemURL'];
             var condition = item['basicInfo']['conditionDisplayName'];
            $('<tr '+tr_clr+'>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td></tr>").appendTo('#sold_price_data_table');
            }
            $("#sold_price_data").html("</table></div></div>");
        }
      
    }else{
       //$( "#sold_price_data" ).html("No Reecord found");
        $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
              
      }
     }
     }); 
 });
/*-- End Suggest sold Price --*/
/*-- Suggest active Price --*/
   $(".seed_suggest_price").click(function(){
      var button_name = $(this).attr('name');
      if(button_name == 'price_upc'){
        var UPC  = $(this).val();
        if( $(this).val().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null UPC'); return false;
        }
        var TITLE  = null;
        var MPN  = null;
      }else if(button_name == 'price_mpn'){
        if( $(this).val().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null MPN'); return false;
        }
        var UPC  = null;
        var TITLE  = null;
        var MPN  = $(this).val();
      }else if(button_name == 'price_title'){
        var TITLE  = $("#title").val();
        if( TITLE.trim().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null Title'); return false;
        }
        var UPC  = null;
        var MPN  = null;
      }else{
        var UPC  = $("#upc_seed").val();
        var TITLE  = $("#title").val();
        var MPN  = $("#part_no_seed").val();
      }
      
      //console.log(button_name,UPC,MPN,TITLE); return false;
      var CONDITION = $("#it_condition").val();
      var CATEGORY = $("#category_id").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
        url:'<?php echo base_url(); ?>index.php/listing/listing/suggest_price',
      data:{ 
            'UPC' : UPC,
            'TITLE' : TITLE,
            'MPN' : MPN,
            'CONDITION' : CONDITION,
            'CATEGORY' : CATEGORY
            },
     success: function (data) {
     
     if(data.ack= 'Success' && data.itemCount > 0)
     {
        if(data.itemCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Active Listing- Price Plus Shipping Lowest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='25%' class='table table-bordered table-striped' border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th><th>Shipping Type</th>" );
        //  for ( var i = 1; i < data.itemCount+1; i++ ) {

           var item = data['item'];
           var price = item['basicInfo']['convertedCurrentPrice'];
           var username=item['sellerInfo']['sellerUserName'];
           if(username == 'dfwonline' || username == 'techbargains2015'){
              var tr_clr = 'style ="background-color: #7dff7d;"';
             }else{
              var tr_clr = '';
             }
           var item_url = item['basicInfo']['viewItemURL'];
           var condition = item['basicInfo']['conditionDisplayName'];
           var ship_type = item['shippingInfo']['shippingType'];
           var trunc = ship_type.substr(0, 12);
            $('<tr '+tr_clr+'>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td><td>" + trunc + "</td></tr></table></div></div>").appendTo('#price_table');
       // }

        }
        if(data.itemCount > 1)
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Active Listing- Price Plus Shipping Lowest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='25%' class='table table-bordered table-striped' border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th><th>Shipping Type</th>" );
            for ( var i = 1; i < data.itemCount+1; i++ ) 
            {

             var item = data['item'][i-1];
             var price = item['basicInfo']['convertedCurrentPrice'];
             var username=item['sellerInfo']['sellerUserName'];
             if(username == 'dfwonline' || username == 'techbargains2015'){
              var tr_clr = 'style ="background-color: #7dff7d;"';
             }else{
              var tr_clr = '';
             }
             var item_url = item['basicInfo']['viewItemURL'];
             var condition = item['basicInfo']['conditionDisplayName'];
             var ship_type = item['shippingInfo']['shippingType'];
             var trunc = ship_type.substr(0, 12);
            $('<tr '+tr_clr+'>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td><td>" + trunc + "</td></tr></table></div></div>").appendTo('#price_table');
            }
            $("#price-result").html("</table></div></div>");
        }
      
    }else{
       //$( "#price-result" ).html("No Reecord found");
        $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#price-result");
              
      }
     }
     }); 
 });
/*-- End Suggest active Price --*/

/*-- Suggest active Price --*/
   $(".searchActiveListing").click(function(){
      var button_name = $(this).attr('name');
      if(button_name == 'price_upc'){
        var UPC  = $(this).val();
        if( $(this).val().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null UPC'); return false;
        }
        var TITLE  = null;
        var MPN  = null;
      }else if(button_name == 'price_mpn'){
        if( $(this).val().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null MPN'); return false;
        }
        var UPC  = null;
        var TITLE  = null;
        var MPN  = $(this).val();
      }else if(button_name == 'price_title'){
        var TITLE  = $("#title").val();
        if( TITLE.trim().length === 0 ) {
        alert('Warning! Connot Suggest Price Against Null Title'); return false;
        }
        var UPC  = null;
        var MPN  = null;
      }else{
        var UPC  = $("#upc_seed").val();
        var TITLE  = $("#title").val();
        var MPN  = $("#part_no_seed").val();
      }
      
      //console.log(button_name,UPC,MPN,TITLE); return false;
      var CONDITION = $("#it_condition").val();
      var CATEGORY = $("#category_id").val();
      $.ajax({
      type: 'POST',
      dataType: 'json',
        url:'<?php echo base_url(); ?>index.php/listing/listing/searchActiveListing',
      data:{ 
            'UPC' : UPC,
            'TITLE' : TITLE,
            'MPN' : MPN,
            'CONDITION' : CONDITION,
            'CATEGORY' : CATEGORY
            },
     success: function (data) {
     
     if(data.ack= 'Success' && data.itemCount > 0)
     {
        if(data.itemCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Active Listing- Price Plus Shipping Lowest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='25%' class='table table-bordered table-striped' border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th><th>Shipping Type</th>" );
        //  for ( var i = 1; i < data.itemCount+1; i++ ) {

           var item = data['item'];
           var price = item['basicInfo']['convertedCurrentPrice'];
           var username=item['sellerInfo']['sellerUserName'];
           if(username == 'dfwonline' || username == 'techbargains2015'){
              var tr_clr = 'style ="background-color: #7dff7d;"';
             }else{
              var tr_clr = '';
             }
           var item_url = item['basicInfo']['viewItemURL'];
           var condition = item['basicInfo']['conditionDisplayName'];
           var ship_type = item['shippingInfo']['shippingType'];
           var trunc = ship_type.substr(0, 12);
            $('<tr '+tr_clr+'>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td><td>" + trunc + "</td></tr></table></div></div>").appendTo('#price_table');
       // }

        }
        if(data.itemCount > 1)
        {
          $( "#price-result" ).html("");
           var tr='';
           $( "#price-result" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Active Listing- Price Plus Shipping Lowest</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='25%' class='table table-bordered table-striped' border='1' id='price_table'> <th>Sr. No</th><th>Seller ID</th><th>Price</th><th>Condition</th><th>Shipping Type</th>" );
            for ( var i = 1; i < data.itemCount+1; i++ ) 
            {
             var item = data['item'][i-1];
             var price = item['basicInfo']['convertedCurrentPrice'];
             var username=item['sellerInfo']['sellerUserName'];
             if(username == 'dfwonline' || username == 'techbargains2015'){
              var tr_clr = 'style ="background-color: #7dff7d;"';
             }else{
              var tr_clr = '';
             }
             var item_url = item['basicInfo']['viewItemURL'];
             var condition = item['basicInfo']['conditionDisplayName'];
             var ship_type = item['shippingInfo']['shippingType'];
             var trunc = ship_type.substr(0, 12);
            $('<tr '+tr_clr+'>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td><td>" + trunc + "</td></tr></table></div></div>").appendTo('#price_table');
            }
            $("#price-result").html("</table></div></div>");
        }
      
    }else{
       //$( "#price-result" ).html("No Reecord found");
        $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#price-result");
              
      }
     }
     }); 
 });
/*-- End Suggest active Price --*/

/*-- Template load data --*/
   $("#temp_name").ready(function(){
      var TempID  = $("#temp_name").val();
      var href = "<?php echo base_url().'template/c_temp/edit/';?>"+TempID;
      $("#edit_temp").attr("href", href);
      //alert(TempID);return false;
      //document.write(ProdId);
      $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>index.php/seed/c_seed/get_template',
      data: { 'TempID' : TempID},
     success: function (data) {
      //alert(data);
     if(data.TEMPLATE_ID!=''){ 
       // $('#category_id').val(data.CATEGORY_ID);
       //$('#category_name').val(data.TEMPLATE_NAME);
      //document.getElementById("it_condition").innerHTML=$('#it_condition').val(data.DEFAULT_COND);
       //$('#it_condition').val(data.DEFAULT_COND);
       // $('#default_description').val(data.DETAIL_COND);
       //$('#shipping_service').val(data.SHIPPING_SERVICE);
       $('#shipping_service_disabled').val(data.SHIPPING_SERVICE);
       
       $('#shipping_cost').val(data.SHIPPING_COST);
       $('#additional_cost').val(data.ADDITIONAL_COST);
       //$('#site_id').val(data.EBAY_LOCAL);
       $('#listing_type').val(data.LIST_TYPE);
       $('#listing_type_disabled').val(data.LIST_TYPE);
       
       $('#currency').val(data.CURRENCY);
       // $('#ship_from').val(data.SHIP);
       $('#handling_time').val(data.HANDLING_TIME);
       $('#zip_code').val(data.SHIP_FROM_ZIP_CODE);
       // $('#shipping_source').val(data.SHIPPING_S);
       $('#ship_from_loc').val(data.SHIP_FROM_LOC);
       // $('#bid_length').val(data.BID_LENGTH);
       $('#payment_method').val(data.PAYMENT_METHOD);
       $('#paypal').val(data.PAYPAL_EMAIL);
       $('#dispatch_time').val(data.DISPATCH_TIME_MAX);
       $('#return_accepted').val(data.RETURN_OPTION);
       $('#return_accepted_disabled').val(data.RETURN_OPTION);
       //$('#return_within').val(data.RETURN_DAYS);
       $('#cost_paidby').val(data.SHIPPING_PAID_BY);
       $('#cost_paidby_disabled').val(data.SHIPPING_PAID_BY);


     }else{
       document.write('No Result found');
       
      }
     }
     }); 
 });
/*-- End Template load data --*/
/*-- Default Condition values --*/
 //   $("#it_condition").ready(function(){
 //      var CondID  = $("#it_condition").val();
 //      //var seed_id  = $("#seed_id").val();
 //      var default_description  = $("#default_description").val();
 //      //console.log(default_description.length);
 //      if(default_description.length > 0){
 //        return false;

 //      }
 //      $.ajax({
 //      dataType: 'json',
 //      type: 'POST',
 //      url:'<?php //echo base_url(); ?>tolist/c_tolist/get_conditions',
 //      data: { 
 //        'CondID' : CondID//,
 //             // 'seed_id':seed_id
 //    },
 //     success: function (data) {
 //     //console.log(data[0].DETAIL_COND);return false;
 //       //if(data.DETAIL_COND == ''){ 
 //         $('#default_description').val(data.COND_DESCRIPTION);
 //      // }
 //      }
 //    });
 // });
/*-- Default Condition values end --*/
/*-- Default Condition values --*/
$(document).on('change', "#it_condition", function(){
      var CondID  = $("#it_condition").val();
      
     // console.log(CondID);return false;
      //var seed_id  = $("#seed_id").val();

      $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>tolist/c_tolist/get_conditions',
      data: { 
         'CondID' : CondID//,
        //       'seed_id':seed_id
    },
     success: function (data) {
    //console.log(data);return false;
       //if(data.DETAIL_COND == ''){ 
         $('#default_description').val(data.COND_DESCRIPTION);
       //}
      }
    });
 });
/*-- Default Condition values end --*/

$(document).on('change', "#shipping_service", function(){
  var get_ship_val = this.value;
  var shipping_charges = 0;
  if (get_ship_val == 'USPSFirstClass') {
     shipping_charges = 3.25;
  }else if (get_ship_val == 'USPSPriority'){
    shipping_charges = 6.50;
  }else if(get_ship_val=='FedExHomeDelivery'){
    shipping_charges = 13.50;
  }else{
    shipping_charges = 3.25;
  }
  if (shipping_charges !=0) {
    $("#ship_change").val(shipping_charges);


    ////////////////////////////////
      var price = $("#price_change").val();
      var ebay_fee = $("#ebay_fee").val();
      var paypal_fee = $("#paypal_fee").val();
      var ship_fee = shipping_charges;
      var cost_price = $("#cost_price").val();
      if(!price){
        
        $( "#price_error" ).html("<b>Please Enter Item Price<b><br>");
        return false;
      }
     
      if(!ebay_fee){
      ebay_fee = parseFloat(price) / 100 * 8;
    }else{
      ebay_fee = parseFloat(ebay_fee) * parseFloat(price) / 100;
    }
    if(!paypal_fee){
      paypal_fee =  parseFloat(price) / 100 * 2.25;
    }else{
      paypal_fee = parseFloat(paypal_fee) * parseFloat(price) / 100;
    }
      if(!ship_fee){
        ship_fee = 0;
      }
      if(!cost_price){
      cost_price = 0;
      var div = "style='background-color: rgba(195, 3, 3, 0.85);'";
      var flag = null;
    }else{
      <?php $login_id = $this->session->userdata('user_id');?>
      var login_id = <?php echo $login_id; ?>;
      if(login_id == 2 || login_id == 5 || login_id == 49){
        var div = "style='background-color: rgba(15, 156, 15, 0.68);color: white;'";
        var flag = cost_price;
      }else{
        var div = "style='background-color: rgba(15, 156, 15, 0.68);'";
        var flag = null;
      }
    }
       
      var actual_price = parseFloat(price) - parseFloat(ship_fee) - parseFloat(ebay_fee) - parseFloat(paypal_fee) - parseFloat(cost_price);
      var perc = parseFloat(actual_price) / parseFloat(price) * 100 ;
      if(perc < 5){
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(195, 3, 3, 0.85);'";
    }else{
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(15, 156, 15, 0.68);'";
    }
          $( "#price_analysis" ).html("");
             var tr='';
             $( "#price_analysis" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_analysis_table'> <th>Price Entered&nbsp;&nbsp;&nbsp;</th><th>eBay Charges</th><th>Paypal Charges</th><th>Shipping Charges</th><th>Item Cost</th><th>&nbsp;&nbsp;&nbsp;&nbsp;CV&nbsp;&nbsp;&nbsp;&nbsp;</th>" );

              $('<tr>').html("<td><input style='width:100%; border:none!important;'  type='number' name='price_change' id='price_change' value='"+ price + "'/></td><td>"+ parseFloat(ebay_fee).toFixed(2) +"</td><td>"+ parseFloat(paypal_fee).toFixed(2) + "</td><td><input style='width:100%; border:none!important;'  type='number' name='ship_change' id='ship_change' value='"+ parseFloat(ship_fee).toFixed(2) + "'/></td><td "+div+">"+flag+"</td><td "+bg+"><input style='width:100%; border:none!important;'  type='number' name='perc_change' id='perc_change' value='"+ Math.round(perc) +"'/></td></tr></table></div></div>").appendTo('#price_analysis_table');
  }
  ///////////////////////////

});
/*================================================
=            Master Pictures Re-Order            =
================================================*/
$("#master_reorder_seed").click(function () {
    var master_reorder = $('#sortable').sortable('toArray');
    var barcode = $('#list_barcode').val();
    //alert(barcode);return false;

    // var upc = $('#upc_seed').val();
    // var part_no = $('#part_no_seed').val();
    // var it_condition = $('#it_condition').val();
    //alert(upc+"_"+part_no+"_"+it_condition);return false;
    //alert(sortID);return false;
     $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>dekitting_pk_us/c_pic_shoot_us/sorting_order_seed_pk',
      data: { 'master_reorder' : master_reorder,
              'barcode':barcode            
    },
     success: function (data) {
       $(".loader").hide();
      //alert(data);return false;
        if(data == true){
          alert('Pictures Order is updated.');
          window.location.reload();
        }else if(data == false){
          alert('Error - Pictures Order is not updated.');
          //window.location.reload();
        }
      }
      });  

});

// $("#master_reorder_seed").click(function () {
//     var master_reorder = $('#sortable').sortable('toArray');
//     var upc = $('#upc_seed').val();
//     var part_no = $('#part_no_seed').val();
//     var it_condition = $('#it_condition').val();
//     var condition_name = $("#it_condition option:selected").text();

//     //alert(upc+"_"+part_no+"_"+it_condition);return false;
//     //alert(sortID);return false;
// //console.log(it_condition,condition_name);return false;
//     $.ajax({
//       dataType: 'json',
//       type: 'POST',        
//       url:'<?php //echo base_url(); ?>item_pictures/c_item_pictures/master_sorting_order',
//       data: { 'master_reorder' : master_reorder,
//               'upc':upc,
//               'part_no':part_no,
//               'it_condition':it_condition,              
//               'condition_name':condition_name              
//     },
//      success: function (data) {
//       //alert(data);return false;
//         if(data == true){
//           alert('Pictures Order is updated.');
//           window.location.reload();
//         }else if(data == false){
//           alert('Error - Pictures Order is not updated.');
//           //window.location.reload();
//         }
//       }
//       });  

// });

/*=====  End of Master Pictures Re-Order  ======*/
/*====================================================
=            price analysis start           =
====================================================*/
$("#price").blur(function(){

    var price = $("#price").val();
    var ebay_fee = $("#ebay_fee").val();
    var paypal_fee = $("#paypal_fee").val();
    var ship_fee = $("#ship_fee").val();
    var ship_change = $("#ship_change").val();
    var cost_price = $("#cost_price").val();
    var condition_id = $("#pic_condition_id").val();
    var mpn = $("#part_no_seed").val();
    var category_id = $("#category_id").val();


  
    if(!ship_change){
      if(!ship_fee){
        final_ship_fee = 0;
      }else{
        final_ship_fee = ship_fee;
      }
    }else{
      final_ship_fee = ship_change;
    }


    if(!price){
      
      $( "#price_error" ).html("<b>Please Enter Item Price<b><br>");
      return false;
    }
   var e_fee = 0;
   var p_fee = 0;
    if(!ebay_fee){
      if(!cost_price){
       e_fee = parseFloat(cost_price) / 100 * 8;
      }
      ebay_fee = parseFloat(price) / 100 * 8;
     
    }else{
      ebay_fee = parseFloat(ebay_fee) * parseFloat(price) / 100;
      if(!cost_price){
        e_fee = parseFloat(ebay_fee) * parseFloat(cost_price) / 100;;
      }
    }
    if(!paypal_fee){
      if(!cost_price){
        p_fee =  parseFloat(cost_price) / 100 * 2.25;
      }
      paypal_fee =  parseFloat(price) / 100 * 2.25;
    }else{
      paypal_fee = parseFloat(paypal_fee) * parseFloat(price) / 100;
      if(!cost_price){
        p_fee = parseFloat(paypal_fee) * parseFloat(cost_price) / 100;
      }
    }
    // if(!ship_fee){
    //   ship_fee = 0;
    // }

    if(!cost_price){
      cost_price = 0;
      var div = "style='background-color: rgba(195, 3, 3, 0.85);'";
      var flag = null;
    }else{
      <?php $login_id = $this->session->userdata('user_id');?>
      var login_id = <?php echo $login_id; ?>;
      if(login_id == 2 || login_id == 5 || login_id == 49){
        var div = "style='background-color: rgba(15, 156, 15, 0.68);color: white; font-weight: bolder;'";
        var flag = cost_price;
      }else{
        var div = "style='background-color: rgba(15, 156, 15, 0.68); font-weight: bolder;'";
        var flag = null;
      }
    }
     
    var actual_price = parseFloat(price) - parseFloat(final_ship_fee) - parseFloat(ebay_fee) - parseFloat(paypal_fee) - parseFloat(cost_price);
    var perc = parseFloat(actual_price) / parseFloat(price) * 100 ;
    if(perc < 5){
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(195, 3, 3, 0.85);'";
    }else{
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(15, 156, 15, 0.68);'";
    }
    var active_css = "style='background-color: rgb(0, 0, 0); color: white; font-weight: bolder; width: 85px;'";
    var sold_css = "style='background-color: rgb(0, 78, 255); color: white; font-weight: bolder; width: 85px;'";
    
    /*========================================================
    =            calculate system suggested price            =
    ========================================================*/
    var selling_cost = parseFloat(cost_price) + parseFloat(final_ship_fee) + parseFloat(e_fee) + parseFloat(p_fee);
    var sys_sug_price = (selling_cost + (selling_cost * 40 /100)).toFixed(2);
    
    /*=====  End of calculate system suggested price  ======*/
    
    /*============================================
    =            price analysis table            =
    ============================================*/
           $( "#price_analysis" ).html("");
              var tr='';
           $( "#price_analysis" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_analysis_table'> <th>Price Entered&nbsp;&nbsp;&nbsp;</th><th>eBay Charges</th><th>Paypal Charges</th><th>Shipping Charges</th><th>Item Cost</th><th>&nbsp;&nbsp;&nbsp;&nbsp;CV&nbsp;&nbsp;&nbsp;&nbsp;</th>" );
           $('<tr>').html("<td><input style='width:100%; border:none!important;'  type='number' name='price_change' id='price_change' value='"+ price + "'/></td><td>"+ parseFloat(ebay_fee).toFixed(2) +"</td><td>"+ parseFloat(paypal_fee).toFixed(2) + "</td><td><input style='width:100%; border:none!important;'  type='number' name='ship_change' id='ship_change' value='"+ parseFloat(final_ship_fee).toFixed(2) + "'/></td><td "+div+">"+flag+"</td><td "+bg+"><input style='width:100%; border:none!important;'  type='number' name='perc_change' id='perc_change' value='"+ Math.round(perc) +"'/></td></tr></table></div></div>").appendTo('#price_analysis_table');
    
    
    /*=====  End of price analysis table  ======*/
    
          /*===================================================
            =            price analysis active table            =
            ===================================================*/
            $.ajax({
            dataType: 'json',
            type: 'POST',
            url:'<?php echo base_url(); ?>tolist/c_tolist/price_analysis_active',
            data: { 'mpn' : mpn,'condition_id':condition_id,'category_id':category_id},
           success: function (data) {
            //alert(data);
           if(data!=''){ 
           $( "#price_analysis_active" ).html("");
           var tr='';

           $( "#price_analysis_active" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis | Active</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_active_tab'> <th>Avg Price&nbsp;&nbsp;&nbsp;</th><th>Active Qty</th><th>Active Date|Min</th><th>Active Date|Max</th><th>Active Within|Days</th>" );

            $('<tr>').html("<td "+active_css+">$ "+ data[0].AVG_PRICE + "</td><td>"+ data[0].ACTIVE_QTY +"</td><td>"+ data[0].SOLD_FROM + "</td><td>"+ data[0].SOLD_TO + "</td><td >"+data[0].TURNOVER_DAYS+"</td></tr></table></div></div>").appendTo('#price_active_tab');

           }else{
             console.log('No Result found');
             
            }
           }
           });// ajax call end
            
            
            /*=====  End of price analysis active table  ======*/

          /*===========================================
          =            price analysis sold            =
          ===========================================*/
          $.ajax({
            dataType: 'json',
            type: 'POST',
            url:'<?php echo base_url(); ?>tolist/c_tolist/price_analysis_sold',
            data: { 'mpn' : mpn,'condition_id':condition_id,'category_id':category_id},
           success: function (data) {
            //alert(data);
           if(data!=''){ 
            $( "#price_analysis_sold" ).html("");
           var tr='';

           $( "#price_analysis_sold" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis | Sold</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_sold_tab'> <th>Avg Price&nbsp;&nbsp;&nbsp;</th><th>Sold Qty</th><th>Sold Date|Min</th><th>Sold Date|Max</th><th>Sold Within|Days</th>" );

            $('<tr>').html("<td "+sold_css+">$ "+ data[0].AVG_PRICE + "</td><td>"+ data[0].QTY_SOLD +"</td><td>"+ data[0].SOLD_FROM + "</td><td>"+ data[0].SOLD_TO + "</td><td >"+data[0].TURNOVER_DAYS+"</td></tr></table></div></div>").appendTo('#price_sold_tab');

           }else{
             console.log('No Result found');
             
            }
           }
           });// ajax call end
          
          
          /*=====  End of price analysis sold  ======*/
          /*==============================================
          =            system suggested price            =
          ==============================================*/
          if(isNaN(sys_sug_price)){
            sys_sug_price = "N/A";
          }
          $( "#sys_sug_price" ).html("");
          $( "#sys_sug_price" ).html( "<div> <div class='small-box bg-red'> <div class='inner'> <p class='summarycardcss' id='total_exp_record' style='font-size: 34px!important;'> "+sys_sug_price+"</p> <p><b>System Suggested Price</b> </p> </div> <div class='icon'> <i class='fa fa-usd' aria-hidden='true'></i> </div>  </div> </div>");
          //<a href='' class='small-box-footer'>More info <i class='fa fa-arrow-circle-right'></i></a>
          /*=====  End of system suggested price  ======*/
              
           
  
});
  $("#price_analysis").on('blur','#price_change',function(){//USE THIS METHOD WHENEVER YOU CALL AN EVENT ON DYNAMICALLY CREATED ELEMENT

      var price = $("#price_change").val();
      var ebay_fee = $("#ebay_fee").val();
      var paypal_fee = $("#paypal_fee").val();
      var ship_fee = $("#ship_change").val();
      var cost_price = $("#cost_price").val();
      if(!price){
        
        $( "#price_error" ).html("<b>Please Enter Item Price<b><br>");
        return false;
      }
     
      if(!ebay_fee){
      ebay_fee = parseFloat(price) / 100 * 8;
    }else{
      ebay_fee = parseFloat(ebay_fee) * parseFloat(price) / 100;
    }
    if(!paypal_fee){
      paypal_fee =  parseFloat(price) / 100 * 2.25;
    }else{
      paypal_fee = parseFloat(paypal_fee) * parseFloat(price) / 100;
    }
      if(!ship_fee){
        ship_fee = 0;
      }
      if(!cost_price){
      cost_price = 0;
      var div = "style='background-color: rgba(195, 3, 3, 0.85);'";
      var flag = null;
    }else{
      <?php $login_id = $this->session->userdata('user_id');?>
      var login_id = <?php echo $login_id; ?>;
      if(login_id == 2 || login_id == 5 || login_id == 49){
        var div = "style='background-color: rgba(15, 156, 15, 0.68);color: white;'";
        var flag = cost_price;
      }else{
        var div = "style='background-color: rgba(15, 156, 15, 0.68);'";
        var flag = null;
      }
    }
       
      var actual_price = parseFloat(price) - parseFloat(ship_fee) - parseFloat(ebay_fee) - parseFloat(paypal_fee) - parseFloat(cost_price);
      var perc = parseFloat(actual_price) / parseFloat(price) * 100 ;
      if(perc < 5){
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(195, 3, 3, 0.85);'";
    }else{
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(15, 156, 15, 0.68);'";
    }
          $( "#price_analysis" ).html("");
             var tr='';
             $( "#price_analysis" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_analysis_table'> <th>Price Entered&nbsp;&nbsp;&nbsp;</th><th>eBay Charges</th><th>Paypal Charges</th><th>Shipping Charges</th><th>Item Cost</th><th>&nbsp;&nbsp;&nbsp;&nbsp;CV&nbsp;&nbsp;&nbsp;&nbsp;</th>" );

              $('<tr>').html("<td><input style='width:100%; border:none!important;'  type='number' name='price_change' id='price_change' value='"+ price + "'/></td><td>"+ parseFloat(ebay_fee).toFixed(2) +"</td><td>"+ parseFloat(paypal_fee).toFixed(2) + "</td><td><input style='width:100%; border:none!important;'  type='number' name='ship_change' id='ship_change' value='"+ parseFloat(ship_fee).toFixed(2) + "'/></td><td "+div+">"+flag+"</td><td "+bg+"><input style='width:100%; border:none!important;'  type='number' name='perc_change' id='perc_change' value='"+ Math.round(perc) +"'/></td></tr></table></div></div>").appendTo('#price_analysis_table');

  });
    $("#price_analysis").on('blur','#perc_change',function(){//USE THIS METHOD WHENEVER YOU CALL AN EVENT ON DYNAMICALLY CREATED ELEMENT
      var perc_change = $("#perc_change").val();
      var ebay_fee = $("#ebay_fee").val();
      var paypal_fee = $("#paypal_fee").val();
      var ship_fee = $("#ship_change").val();
      var cost_price = $("#cost_price").val();
      if(cost_price == null && ship_fee == null){
        alert('Error - Cost & Shipping Charges is Null');return false;
        }

        /*=======================================================
        =            formula to calculate list price            =
        =======================================================*/

              // var cost_perc = (parseFloat(cost_price) + parseFloat(ship_fee))*100;
              // var ebay_pay_perc = 100 - (parseFloat(ebay_fee)+parseFloat(paypal_fee)) - parseFloat(perc_change);
              // var list_price = cost_perc / ebay_pay_perc;

        /*=====  End of formula to calculate list price  ======*/
     
    if(!ebay_fee){
      //var cost_perc = 10.25*100;
      var ebay_pay_perc = 100 - 10.25 - parseFloat(perc_change);
    }else{
      var ebay_pay_perc = 100 - (parseFloat(ebay_fee)+parseFloat(paypal_fee)) - parseFloat(perc_change);
    }
    if(!ship_fee){
      ship_fee = 0;
    }
    if(!cost_price){
      cost_price = 0;
      var cost_perc = parseFloat(ship_fee)*100;
      var div = "style='background-color: rgba(195, 3, 3, 0.85);'";
      var flag = null;
    }else{
      var cost_perc = (parseFloat(cost_price) + parseFloat(ship_fee))*100;
      <?php $login_id = $this->session->userdata('user_id');?>
      var login_id = <?php echo $login_id; ?>;
      if(login_id == 2 || login_id == 5 || login_id == 49){
        var div = "style='background-color: rgba(15, 156, 15, 0.68);color: white;'";
        var flag = cost_price;
      }else{
        var div = "style='background-color: rgba(15, 156, 15, 0.68);'";
        var flag = null;
      }

    }

    var list_price = cost_perc / ebay_pay_perc;
  //alert(list_price); return false;
if(!ebay_fee){
      ebay_fee = parseFloat(list_price) / 100 * 8;
    }else{
      ebay_fee = parseFloat(ebay_fee) * parseFloat(list_price) / 100;
    }
    if(!paypal_fee){
      paypal_fee =  parseFloat(list_price) / 100 * 2.25;
    }else{
      paypal_fee = parseFloat(paypal_fee) * parseFloat(list_price) / 100;
    }
    if(perc_change < 5){
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(195, 3, 3, 0.85);'";
    }else{
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(15, 156, 15, 0.68);'";
    }

      // var actual_price = parseFloat(price) - parseFloat(ship_fee) - parseFloat(ebay_fee) - parseFloat(paypal_fee) - parseFloat(cost_price);
      // var perc = parseFloat(actual_price) / parseFloat(price) * 100 ;
          $( "#price_analysis" ).html("");
             var tr='';
             $( "#price_analysis" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_analysis_table'> <th>Price Entered&nbsp;&nbsp;&nbsp;</th><th>eBay Charges</th><th>Paypal Charges</th><th>Shipping Charges</th><th>Item Cost</th><th>&nbsp;&nbsp;&nbsp;&nbsp;CV&nbsp;&nbsp;&nbsp;&nbsp;</th>" );

              $('<tr>').html("<td><input style='width:100%; border:none!important;'  type='number' name='price_change' id='price_change' value='"+parseFloat(list_price).toFixed(2)  + "'/></td><td>"+ parseFloat(ebay_fee).toFixed(2) +"</td><td>"+ parseFloat(paypal_fee).toFixed(2) + "</td><td><input style='width:100%; border:none!important;'  type='number' name='ship_change' id='ship_change' value='"+ parseFloat(ship_fee).toFixed(2) + "'/></td><td "+div+">"+flag+"</td><td "+bg+"><input style='width:100%; border:none!important;'  type='number' name='perc_change' id='perc_change' value='"+ Math.round(perc_change) +"'/></td></tr></table></div></div>").appendTo('#price_analysis_table');
              $("#price").val(list_price.toFixed(2));

   });
 
  $("#price_analysis").on('blur','#ship_change',function(){//USE THIS METHOD WHENEVER YOU CALL AN EVENT ON DYNAMICALLY CREATED ELEMENT

      var price = $("#price_change").val();
      var ebay_fee = $("#ebay_fee").val();
      var paypal_fee = $("#paypal_fee").val();
      var ship_fee = $("#ship_change").val();
      var cost_price = $("#cost_price").val();
      if(!price){
        
        $( "#price_error" ).html("<b>Please Enter Item Price<b><br>");
        return false;
      }
     
      if(!ebay_fee){
      ebay_fee = parseFloat(price) / 100 * 8;
    }else{
      ebay_fee = parseFloat(ebay_fee) * parseFloat(price) / 100;
    }
    if(!paypal_fee){
      paypal_fee =  parseFloat(price) / 100 * 2.25;
    }else{
      paypal_fee = parseFloat(paypal_fee) * parseFloat(price) / 100;
    }
      if(!ship_fee){
        ship_fee = 0;
      }
      if(!cost_price){
      cost_price = 0;
      var div = "style='background-color: rgba(195, 3, 3, 0.85);'";
      var flag = null;
    }else{
      <?php $login_id = $this->session->userdata('user_id');?>
      var login_id = <?php echo $login_id; ?>;
      if(login_id == 2 || login_id == 5 || login_id == 49){
        var div = "style='background-color: rgba(15, 156, 15, 0.68);color: white;'";
        var flag = cost_price;
      }else{
        var div = "style='background-color: rgba(15, 156, 15, 0.68);'";
        var flag = null;
      }
    }
       
      var actual_price = parseFloat(price) - parseFloat(ship_fee) - parseFloat(ebay_fee) - parseFloat(paypal_fee) - parseFloat(cost_price);
      var perc = parseFloat(actual_price) / parseFloat(price) * 100 ;
      if(perc < 5){
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(195, 3, 3, 0.85);'";
    }else{
      var bg = "style='font-weight: bold;font-size: 21px;color: rgba(15, 156, 15, 0.68);'";
    }
          $( "#price_analysis" ).html("");
             var tr='';
             $( "#price_analysis" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>Price Analysis</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='price_analysis_table'> <th>Price Entered&nbsp;&nbsp;&nbsp;</th><th>eBay Charges</th><th>Paypal Charges</th><th>Shipping Charges</th><th>Item Cost</th><th>&nbsp;&nbsp;&nbsp;&nbsp;CV&nbsp;&nbsp;&nbsp;&nbsp;</th>" );

              $('<tr>').html("<td><input style='width:100%; border:none!important;'  type='number' name='price_change' id='price_change' value='"+ price + "'/></td><td>"+ parseFloat(ebay_fee).toFixed(2) +"</td><td>"+ parseFloat(paypal_fee).toFixed(2) + "</td><td><input style='width:100%; border:none!important;'  type='number' name='ship_change' id='ship_change' value='"+ parseFloat(ship_fee).toFixed(2) + "'/></td><td "+div+">"+flag+"</td><td "+bg+"><input style='width:100%; border:none!important;'  type='number' name='perc_change' id='perc_change' value='"+ Math.round(perc) +"'/></td></tr></table></div></div>").appendTo('#price_analysis_table');

  });
  

/*-- Template load data --*/
   $("#temp_name").change(function(){
      var TempID  = $("#temp_name").val();
      var href = "<?php echo base_url().'template/c_temp/edit/';?>"+TempID;
      $("#edit_temp").attr("href", href);;
      $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>index.php/seed/c_seed/get_template',
      data: { 'TempID' : TempID},
     success: function (data) {
      //alert(data);
     if(data.TEMPLATE_ID!=''){ 
       // $('#category_id').val(data.CATEGORY_ID);
       //$('#category_name').val(data.TEMPLATE_NAME);
      //document.getElementById("it_condition").innerHTML=$('#it_condition').val(data.DEFAULT_COND);
       //$('#it_condition').val(data.DEFAULT_COND);
       // $('#default_description').val(data.DETAIL_COND);
       //$('#shipping_service').val(data.SHIPPING_SERVICE);
       //$('#shipping_service_disabled').val(data.SHIPPING_SERVICE);
       
       $('#shipping_cost').val(data.SHIPPING_COST);
       $('#additional_cost').val(data.ADDITIONAL_COST);
       $('#site_id').val(data.EBAY_LOCAL);
       $('#listing_type').val(data.LIST_TYPE);
       $('#listing_type_disabled').val(data.LIST_TYPE);
       
       $('#currency').val(data.CURRENCY);
       // $('#ship_from').val(data.SHIP);
       $('#handling_time').val(data.HANDLING_TIME);
       $('#zip_code').val(data.SHIP_FROM_ZIP_CODE);
       // $('#shipping_source').val(data.SHIPPING_S);
       $('#ship_from_loc').val(data.SHIP_FROM_LOC);
       // $('#bid_length').val(data.BID_LENGTH);
       $('#payment_method').val(data.PAYMENT_METHOD);
       $('#paypal').val(data.PAYPAL_EMAIL);
       $('#dispatch_time').val(data.DISPATCH_TIME_MAX);
       $('#return_accepted').val(data.RETURN_OPTION);
       $('#return_accepted_disabled').val(data.RETURN_OPTION);
       //$('#return_within').val(data.RETURN_DAYS);
       $('#cost_paidby').val(data.SHIPPING_PAID_BY);
       $('#cost_paidby_disabled').val(data.SHIPPING_PAID_BY);
       //var ship_fee  = $("#ship_fee").val();
       var str = data.SHIPPING_SERVICE;

       if(str.search("First") !== -1){
        
         $("#ship_fee").val(3.25);
       }else if(str.search("Priority") !== -1){
        $("#ship_fee").val(6.50);
       }else if(str.search("FedEx") !== -1){
        $("#ship_fee").val(13.50);
       }
       console.log(str);

     }else{
       document.write('No Result found');
       
      }
     }
     }); 
 });
/*-- End Template load data --*/
/*==========================================
=            add item specifics            =
==========================================*/
$("#save_specifics").click(function(){
  var count = $('#array_count').val(); 
  var item_id = $('#pic_item_id').val(); 
  var item_mpn = $('#part_no_seed').val();
  var item_upc = $('#upc_seed').val();

  // var values = $('.selectpicker').val();
  // alert(values);return false;
  //alert(item_upc);return false;
  var cat_id = $('#category_id').val();
  var spec_name=[];
  var spec_value=[];
  for (var i = 1; i <= count; i++) { 
 // var values = $('#specific_'+i).val();
 // alert(values);    
     spec_name.push($('#specific_name_'+i).text()); 
     spec_value.push($('#specific_'+i).val());

  }//return false;

      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>specifics/c_item_specifics/add_specifics',
        data: { 
          'item_id' : item_id,
          'cat_id' : cat_id,
          'spec_name' : spec_name,
          'spec_value' : spec_value,
          'item_upc' : item_upc,
          'item_mpn' : item_mpn
      },
       success: function (data) {
         if(data != ''){
          alert('Item Specific Updated');
          //window.location.href = '<?php //echo base_url(); ?>specifics/c_item_specifics';
                   
         }else{
           alert('Error:UPC & MPN not found');
           //window.location.href = '<?php //echo base_url(); ?>specifics/c_item_specifics';
         }
       }
      }); 
 });


/*=====  End of add item specifics  ======*/


/*-- list item button function --*/
   $("#item_list").click(function(){

      //var shopifyCheckbox = $('#listOnShopify:checked').val();
      var shopifyCheckbox = $("#listOnShopify").is(":checked");
      if(shopifyCheckbox === true){
        shopifyCheckbox = 1;
        //alert(shopifyCheckbox);
      }else{
        shopifyCheckbox = 0;
        //alert(shopifyCheckbox);
      }
      var bestOfferCheckbox = $("#bestOffer").is(":checked");
      if(bestOfferCheckbox === true){
        bestOfferCheckbox = 1;
        //alert(bestOfferCheckbox);
      }else{
        bestOfferCheckbox = 0;
        //alert(bestOfferCheckbox);
      }
      var addQtyOnly = $("#addQtyOnly").is(":checked");
      if(addQtyOnly === true){
        addQtyOnly = 1;
        //alert(addQtyOnly);
      }else{
        addQtyOnly = 0;
        //alert(bestOfferCheckbox);
      }

      //var list_qty  = $("#list_qty").val();
      if(confirm('Are you sure?')){
        var seed_id  = $("#seed_id").val();
        var account_type  = $("#account_type").val();
        var list_barcode  = $("#list_barcode").val();
        $(this).prop("disabled", true);
      var clicked_btn = $(this).attr("call");
      var forceRevise = 0;
      var ebay_id = $("#ebay_id").val();
      if(clicked_btn != 'revise'){
        var revise_ebay_id = $("#revise_ebay_id").val();
        if(revise_ebay_id.length > 0){
          if(revise_ebay_id.length == 12){
            //clicked_btn = 'revise';
            forceRevise = 1;
            ebay_id = revise_ebay_id;
          }else if(revise_ebay_id.length < 12){
            alert("Warning! eBay id Connot be less than 12 digit.");
            $("#revise_ebay_id").focus();
            return false;
          }else{
            alert("Warning! eBay id Connot be greater than 12 digit.");
            $("#revise_ebay_id").focus();
            return false;
          }
        }
      }

      //console.log(ebay_id); return false;
/*============================================
=            copy from blur price            =
============================================*/
    var price = $("#price").val();
    var ebay_fee = $("#ebay_fee").val();
    var paypal_fee = $("#paypal_fee").val();
    var ship_fee = $("#ship_fee").val();
    var ship_change = $("#ship_change").val();
    var cost_price = $("#cost_price").val();
    var condition_id = $("#pic_condition_id").val();
    var mpn = $("#part_no_seed").val();
    var category_id = $("#category_id").val();


  
    if(!ship_change){
      if(!ship_fee){
        final_ship_fee = 0;
      }else{
        final_ship_fee = ship_fee;
      }
    }else{
      final_ship_fee = ship_change;
    }
    if(!cost_price){
      cost_price = 0;
      
    }

    if(!price){
      
      $( "#price_error" ).html("<b>Please Enter Item Price<b><br>");
      return false;
    }
   var e_fee = 0;
   var p_fee = 0;
    if(!ebay_fee){
      if(!cost_price){
       e_fee = parseFloat(cost_price) / 100 * 8;
      }
      ebay_fee = parseFloat(price) / 100 * 8;
     
    }else{
      ebay_fee = parseFloat(ebay_fee) * parseFloat(price) / 100;
      if(!cost_price){
        e_fee = parseFloat(ebay_fee) * parseFloat(cost_price) / 100;;
      }
    }
    if(!paypal_fee){
      if(!cost_price){
        p_fee =  parseFloat(cost_price) / 100 * 2.25;
      }
      paypal_fee =  parseFloat(price) / 100 * 2.25;
    }else{
      paypal_fee = parseFloat(paypal_fee) * parseFloat(price) / 100;
      if(!cost_price){
        p_fee = parseFloat(paypal_fee) * parseFloat(cost_price) / 100;
      }
    }
    // if(!ship_fee){
    //   ship_fee = 0;
    // }



    
    /*========================================================
    =            check item price            =
    ========================================================*/
    var selling_cost = parseFloat(cost_price) + parseFloat(final_ship_fee) + parseFloat(ebay_fee) + parseFloat(paypal_fee);
    var price_check = (selling_cost - price).toFixed(2);
     /*=====  End of check item price  ======*/
//console.log('cost:'+cost_price+' ship:'+final_ship_fee+ ' Ebay:'+ebay_fee+ 'Paypal:'+paypal_fee+'selling_cost: '+selling_cost);
    /*=======================================================
    =            if price check > 0 than list it            =
    =======================================================*/
    if(price_check < 0){
      //alert('price check pass'); return false;
     // price = price.toFixed(2);
     $(".loader").show();
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url:'<?php echo base_url(); ?>tolist/c_tolist/update_seed_price',
          data: { 
                  'price' : price,
                  'seed_id':seed_id,
                  'shopifyCheckbox':shopifyCheckbox
        },
         success: function (data) {
          $(".loader").hide();
          if(list_barcode == '' || list_barcode == null){
              list_barcode ='barcode';
            }
          if(ebay_id == '' || ebay_id == null){
              ebay_id ='ebay_id';
            }
             if(clicked_btn == 'revise'){

               var sticker_url = "<?php echo base_url();?>tolist/c_tolist/list_item_merg/"+seed_id+"/"+clicked_btn+"/"+list_barcode+"/"+shopifyCheckbox+"/"+bestOfferCheckbox+"/"+account_type+"/"+addQtyOnly+"/"+ebay_id;   
              
             }else{
              if(forceRevise === 1){
                var sticker_url = "<?php echo base_url();?>tolist/c_tolist/forceRevise/"+seed_id+"/"+clicked_btn+"/"+bestOfferCheckbox+"/"+addQtyOnly+"/"+ebay_id;
              }else{
                var sticker_url = "<?php echo base_url();?>tolist/c_tolist/list_item_merg/"+seed_id+"/"+clicked_btn+"/"+list_barcode+"/"+shopifyCheckbox+"/"+bestOfferCheckbox+"/"+account_type+"/"+addQtyOnly+"/"+ebay_id; 
              }
             }
             
             //var sticker_url = 
             window.open(sticker_url, '_self');
             //sticker_url.location;
           }//sucess if close

        });

    }else{
      alert('Error! Item Cannot be listed | List Price < (Cost + Selling Expenses)');
      //$('body').scrollTo('#target');//.css({'border':'3px solid #ac2925', 'padding':'5px'})
      $('html,body').animate({
        scrollTop: $("#target").offset().top},
        'slow');
      $("#target").css({'border':'3px solid #ac292585', 'padding':'12px 5px 0px 5px'});
      //<i class="glyphicon glyphicon-eye-close form-control-feedback"></i>
      $("#authenticate_pass").append('<div class="col-sm-4"><div id="wrapper"> <div class="form-group has-feedback"> <input type="password" class="form-control" id="auth_password" placeholder="Password"> </div> </div></div> <div class="col-sm-2"><div class="form-group"> <button class="btn btn-danger btn-block" id="forceList" call="list">Force to List</button> </div></div>'); 

      return false;

    }
    
    
    /*=====  End of if price check > 0 than list it  ======*/
    
/*=====  End of copy from blur price  ======*/

          
      }else{//ARE YOU SURE IF ELSE
        return false;
      }
      
 });
/*-- list item button function end --*/

/*-- Force to list item button start --*/
$(document).on('click','#forceList',function(){ 
  //$("#forceList").click(function(){
     var get_ebay_id  = $("#ebay_id").val();
    if(get_ebay_id == null || get_ebay_id == ""){
      var clicked_btn = $(this).attr("call");
    }else{
      var clicked_btn = 'revise';

    }
    
    var auth_password = $("#auth_password").val();
    if(auth_password == null || auth_password == ""){
      alert("Please enter Authentication Code");
      return false;
    }else{
      //alert(auth_password); return false;
      $.ajax({
          dataType: 'json',
          type: 'POST',
          url:'<?php echo base_url(); ?>tolist/c_tolist/authPasswordCheck',
          data: {'auth_password' : auth_password},
         success: function (data) {
            //console.log(data); return false;

            if(data === 1){
              if(confirm('Are you sure?')){
                var seed_id  = $("#seed_id").val();

                var price = $("#price").val();
                var ebay_fee = $("#ebay_fee").val();
                var paypal_fee = $("#paypal_fee").val();
                var ship_fee = $("#ship_fee").val();
                var ship_change = $("#ship_change").val();
                var cost_price = $("#cost_price").val();
                var condition_id = $("#pic_condition_id").val();
                var mpn = $("#part_no_seed").val();
                var category_id = $("#category_id").val();

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url:'<?php echo base_url(); ?>tolist/c_tolist/update_seed_price',
                    data: { 
                            'price' : price,
                            'seed_id':seed_id
                  },
                   success: function (data) {
                      var sticker_url = "<?php echo base_url();?>tolist/c_tolist/list_item/"+seed_id+"/"+clicked_btn;
                      window.open(sticker_url, '_blank');
                       //sticker_url.location;
                    }
                  });

                    
              }else{//ARE YOU SURE IF ELSE
                return false;
              }              

            }else{
              alert("Authentication Code is wrong or doesn't match.");
              return false;
            }
          }
        });      

    }
    //return false;


      
 });
/*-- Force to list item button end --*/


//$("#auth_password").password('toggle');
// toggle password visibility
// $(document).on('click','#auth_password + .glyphicon',function(){  
//   $(this).toggleClass('glyphicon-eye-close').toggleClass('glyphicon-eye-open'); // toggle our classes for the eye icon
//   $('#auth_password').password(); // activate the hideShowPassword plugin
// });

    // ClassicEditor
    //     .create( document.querySelector( '#item_desc' ) )
    //     .catch( error => {
    //         console.error( error );
    //     } );
/*==================================================
=            holdbarcode modal function            =
==================================================*/
$(document).on('click','.holdBarcode',function(){
  var seedId               = this.id;
  //console.log(seedId); return false;
  //alert(feedUrlId);
  $(".loader").show();
  $.ajax({
    url: '<?php echo base_url(); ?>tolist/c_tolist/showAllBarcode',
    type:'post',
    dataType:'json',
    data:{'seedId':seedId},
    success: function(data){
      //console.log(data);
      if (data.unhold.length > 0 || data.hold.length > 0) {
        
        $('#holdBarcodeModal').modal('show');
        //          $('#myModal').modal('show');
        $(".loader").hide();
        // $(".holdBarcodeDiv").show(); // holdSelectedBarcode button
        // $(".UnholdBarcodeDiv").hide(); // Un-Hold Selected Barcode button
        // $(".holdedBarcodeDiv").show(); // show holded barcode button
        // $(".availBarcodeDiv").hide(); // show barcode available to hold
        // $(".UnholdBarcodeDiv").hide(); // Un-Hold Selected Barcode button
          /*====================================================
          =            remove all rows in datatable            =
          ====================================================*/
          $('#unholded_barcode_detail').DataTable().destroy();
          var table = $('#unholded_barcode_detail').DataTable({
                        "oLanguage": {
                        "sInfo": "Total Records: _TOTAL_"
                      },
                      "iDisplayLength": 100,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "order": [[ 1, "ASC" ]],
                        "info": true,
                        "autoWidth": true,
                        "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
                      });
          table.clear().draw();
          
          /*=====  End of remove all rows in datatable  ======*/


         for(var i=0;i<data.unhold.length;i++){
           var barcode = data.unhold[i].BARCODE_NO;
           var barcode_dets = '<tr><td id = "qty_sr_no'+i+'" style="color:black;"><input type="checkbox" name="select_barcode_unhold" value="'+barcode+'"></td> <td id = "qty_ebay_id'+i+'" style="color:black;">'+barcode+'</td> </tr>';

            table.row.add($(barcode_dets)).draw(false);
         }//end for loop

         /*====================================================
          =            remove all rows in datatable            =
          ====================================================*/
          $('#holded_barcode_detail').DataTable().destroy();
          var table = $('#holded_barcode_detail').DataTable({
                        "oLanguage": {
                        "sInfo": "Total Records: _TOTAL_"
                      },
                      "iDisplayLength": 100,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "order": [[ 1, "ASC" ]],
                        "info": true,
                        "autoWidth": true,
                        "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
                      });
          table.clear().draw();
          
          /*=====  End of remove all rows in datatable  ======*/


         for(var i=0;i<data.hold.length;i++){
           var barcode = data.hold[i].BARCODE_NO;
           var barcode_dets = '<tr><td id = "qty_sr_no'+i+'" style="color:black;"><input type="checkbox" name="select_barcode_hold" value="'+barcode+'"></td> <td id = "qty_ebay_id'+i+'" style="color:black;">'+barcode+'</td> </tr>';

            table.row.add($(barcode_dets)).draw(false);
         }//end for loop

      }else{
        alert('No More Barcode Avialable to Hold');
        $(".loader").hide();
        $('#holdBarcodeModal').modal('hide');
      }
    }
  });
 });


/*=====  End of holdbarcode modal function  ======*/
/*==================================================
=            hole/unhold barcode function            =
==================================================*/
$(document).on('click','.holdSelectedBarcode',function(){
  var barcodeStatus               = this.id;
  current_qty = $('#list_qty').val();
  //var seacrhRadio = $('input[name=select_barcode]:checked').val();
  var checkboxValues = [];
  if(barcodeStatus == 1){
    console.log("hold");
    $('input[name=select_barcode_unhold]:checked').map(function() {
            checkboxValues.push($(this).val());
    });
  }else{
    console.log("unhold");
    $('input[name=select_barcode_hold]:checked').map(function() {
            checkboxValues.push($(this).val());
    });
  }

  //console.log(checkboxValues.length); return false;
  //alert(feedUrlId);
  $(".loader").show();
  $.ajax({
    url: '<?php echo base_url(); ?>tolist/c_tolist/holdSelectedBarcode',
    type:'post',
    dataType:'json',
    data:{'checkboxValues':checkboxValues,'barcodeStatus':barcodeStatus},
    success: function(data){
      $(".loader").hide();
      $('#holdBarcodeModal').modal('hide');
      if (data == 1) {
          alert('Barcode Added to Hold list');
          $('#list_qty').val(current_qty - checkboxValues.length);
      }else if (data == 0) {
        alert('Barcode un-holded Successfuly');
        if(current_qty>0){
          $('#list_qty').val(parseInt(current_qty) + parseInt(checkboxValues.length));
        }else{
          $('#list_qty').val(parseInt(checkboxValues.length));
        }
        
      }else{
        $(".loader").hide();
        alert('Some Error Occure.');

      }
    }
  });
 });

function toggleHoldAll(source) {
    checkboxes = document.getElementsByName('select_barcode_hold');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
function toggleUnholdAll(source) {
    checkboxes = document.getElementsByName('select_barcode_unhold');
    for(var i=0, n=checkboxes.length;i<n;i++) {
      checkboxes[i].checked = source.checked;
    }
  }
  /*-- Start select title --*/
function selectTitle(i) {
    var index = i;
    var t = document.getElementById('title_table');
    var cat_id = $(t.rows[index].cells[1]).text();
    document.getElementById("title").value=cat_id;
}
/*-- End select title --*/
  /*-- Start select epid --*/
function selectEpid(i) {
    var index = i;
    var t = document.getElementById('epid_table');
    var epid = $(t.rows[index].cells[2]).text();
    console.log(epid);
    document.getElementById("item_epid").value=epid;
}
/*-- End select epid --*/
/*===================================================
=            append title in description            =
===================================================*/
// $(document).on('blur','#title',function(){
//   var title = $(this).val();
//   var default_description = $('#default_description').val();
//   //console.log(default_description,title);
//   var pre_desc = '<div id="desc_div"><meta name="viewport" content="width=device-width, initial-scale=1.0"><p style="text-align: center;"> <span style="font-size:24px;color:#002060;font-family:arial, helvetica, sans-serif;"><span style="text-decoration:underline;"><strong>'+title+'</strong></span></span> </p> <p style="text-align: center;"> <span style="color: #000!important; font-size: 18px;font-family:arial, helvetica, sans-serif;">This listing is for a '+title+'. '+default_description+' </span><br/> </p>';
// $('#desc_div').html('');  
// $('#desc_div').append(pre_desc);
//  });
/*=====  End of append title in description  ======*/
/*===================================================
=            append default_description in description            =
===================================================*/
// $(document).on('blur','#default_description',function(){
//   var default_description = $(this).val();
//   var title = $('#title').val();
//   console.log(default_description,title);
//   var pre_desc = '<div id="desc_div"><meta name="viewport" content="width=device-width, initial-scale=1.0"><p style="text-align: center;"> <span style="font-size:24px;color:#002060;font-family:arial, helvetica, sans-serif;"><span style="text-decoration:underline;"><strong>'+title+'</strong></span></span> </p> <p style="text-align: center;"> <span style="color: #000!important; font-size: 18px;font-family:arial, helvetica, sans-serif;">This listing is for a '+title+'. '+default_description+' </span><br/> </p>';
// $('#desc_div').html('');  
// $('#desc_div').append(pre_desc);
//  });
/*=====  End of append default_description in description  ======*/

/*===================================================
=            create discription function            =
===================================================*/
$(document).on('click','#create_desc',function(){
  var default_description = $('#default_description').val();
  var title = $('#title').val();
  var return_option = $('#return_option').val();
  return_html = '';
  if(return_option == 'ReturnsNotAccepted'){
    return_html = '<p style="text-align: center;"> <span style="font-size: 18px; font-family: arial, helvetica, sans-serif;color:#ff0000"><span style="text-decoration:underline;"><strong>NO RETURNS ARE ACCEPTED ON THIS ITEM</strong></span></span> </p>'; 
  }
  //console.log(default_description,title);
  var pre_desc = '<div id="desc_div"><meta name="viewport" content="width=device-width, initial-scale=1.0"><p style="text-align: center;"> <span style="font-size:24px;color:#002060;font-family:arial, helvetica, sans-serif;"><span style="text-decoration:underline;"><strong>'+title+'</strong></span></span> </p> <p style="text-align: center;"> <span style="color: #000!important; font-size: 18px;font-family:arial, helvetica, sans-serif;">This listing is for a '+title+'. '+default_description+' </span><br/>'+return_html+' </p>';
  $('#desc_div').html('');  
  $('#desc_div').append(pre_desc);
  UM.getEditor('item_desc').focus();//this will set the value of textarea and form will get the updated value
  um.blur();
});
/*=====  End of create discription function  ======*/
/*===================================================
=            suggest epid            =
===================================================*/
$(document).on('click','#suggest_epid',function(){
  var keyword_epid = $('#keyword_epid').val();
  var category_id = $('#category_id').val();
  if(keyword_epid.trim() == ''){
    alert('Please insert Keyword first.');
    $('#keyword_epid').focus();
    return false;
  }
  
$(".loader").show();
  $.ajax({
    url: '<?php echo base_url(); ?>tolist/c_tolist/suggestEpid',
    type:'post',
    dataType:'json',
    data:{'keyword_epid':keyword_epid,'category_id':category_id},
    success: function(data){
      console.log(data);
      $(".loader").hide();
      if (data.epid.length > 0) {
          $("#epid_table > tbody").html("");
          var tr='';
          for ( var i = 1; i < data.epid.length+1; i++ ) 
          {

           var epid = data['epid'][i-1];
           var title = data['title'][i-1];
           var imageUrl= data['imageUrl'][i-1];

          $('<tr>').html("<td><a class='crsr-pntr' id='select_title' onclick='selectEpid(" + i + ")'> Select </a>" + "</td><td><div class='thumb imgCls' style='display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;'><img class='sort_img up-img' id='' name='' src='"+imageUrl+"'></div></td><td><a target='_blank' href='https://www.ebay.com/p/"+epid+"' >"+epid+"</a></td><td>" + title + "</td></tr>").appendTo('#epid_table');
          }
      }else{
        $(".loader").hide();
        alert('No ePID Found Against this Keyword');
        $('#keyword_epid').focus();
        return false;

      }
    }
  });
  //console.log(default_description,title);

});

/*=====  End of suggest epid  ======*/
/*===================================================
=            get type macro            =
===================================================*/
$(document).on('click','.type_btn',function(){
  var type_id =this.id;
    $(".loader").show();
  $.ajax({
      url: '<?php echo base_url(); ?>tolist/c_tolist/getMacro',
      type:'post',
      dataType:'json',
      data:{'type_id':type_id},
      success: function(data){
        $(".loader").hide();
        if (data) {
              $( "#macro_container" ).html("");
              var tr='';
               //var CategoryCount = data['CategoryCount']; 
               $( "#macro_container" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><h3 class='box-title'>Macro Details</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='macro_table'><th>Select</th><th>Macro Description</th>" );
              for ( var i = 1; i <= data.length; i++ ) 
              {
                var macroDesc = data[i-1]['MACRO_DESCRIPTION'];
                var macroId = data[i-1]['MACRO_ID'];
                $('<tr>').html("<td><a class='crsr-pntr select_macro' macroId='"+macroId+"' idx='"+i+"'' id='macro_"+macroId+"' macro_type='"+type_id+"' onclick='selectMacro("+i+");'> Select </a></td><td>" + macroDesc + "</td></tr></table></div></div>").appendTo('#macro_table');
              }

              $( "</table></div></div>" ).appendTo( "#macro_container");
            
        }else{
            //$('#list_qty').val(parseInt(checkboxValues.length));

        }
          
        
      }
    });
  });

/*=====  End of get type macro  ======*/
  /*-- Start select macro --*/
function selectMacro(i) {
    // var index = i;
    // var t = document.getElementById('macro_table');
    // var macroDescription = $(t.rows[index].cells[1]).text();
    // var macroID = this.id;
    // var check = $( "#"+macroID ).val();
    // console.log( check,macroID);
    // if(check==''){
    //   var btn = '<input type="button" class="btn btn-block btn-outline-secondary btn-sm m-r-5 type_btn" value="'+macroDescription+'" id="'+macroID+'">';
    //    $( btn ).appendTo( "#selected_macro");

    // }
}
/*-- End select macro --*/
$(document).on('click','.select_macro',function(){
  var index = $(this).attr('idx');
  var macroId = $(this).attr('macroId');
  var macroType = $(this).attr('macro_type');
  var t = document.getElementById('macro_table');
  var macroDescription = $(t.rows[index].cells[1]).text();

  var check = $( "#select_"+macroId ).val();
  //console.log( check,macroId);
  if(check == null){
    var trimText = macroDescription.substring(0, 220);
    var btn = '<div class="m-b-5 input-group input-group-md remove_slected_macro_div"><input type="button" class="btn btn-block btn-outline-secondary select_macro_button" macroDescription="'+escapeHtml(macroDescription)+'" value="'+escapeHtml(trimText)+'" macroId="'+macroId+'" id="select_'+macroId+'" macro_type="'+macroType+'"><div class="input-group-btn"> <button title="Remove Macro" class="btn btn-info remove_macro" name="remove_macro" ><i class="glyphicon glyphicon-remove"></i></button> </div> </div>'; 
    // var btn = '<div class="input-group input-group-md"><input type="button" class="btn btn-block btn-outline-secondary" value="'+macroDescription+'" id="select_'+macroId+'"><button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button></div>'; 
    $(btn).appendTo( "#selected_macro");
  }
});

$(document).on('click','.remove_macro',function(){
  $(this).closest('.remove_slected_macro_div').remove();
});

/*===================================================
=            create discription function            =
===================================================*/
$(document).on('click','#create_desc',function(){
  var default_description = $('#default_description').val();
 //alert(default_description);
  //return false;
  var title = $('#title').val();
  var return_option = $('#return_option').val();
  return_html = '';
  if(return_option == 'ReturnsNotAccepted'){
    return_html = '<p style="text-align: center;"> <span style="font-size: 18px; font-family: arial, helvetica, sans-serif;color:#ff0000"><span style="text-decoration:underline;"><strong>NO RETURNS ARE ACCEPTED ON THIS ITEM</strong></span></span> </p>'; 
  }
  //console.log(default_description,title);
  var pre_desc = '<div id="desc_div"><meta name="viewport" content="width=device-width, initial-scale=1.0"><p style="text-align: center;"> <span style="font-size:24px;color:#002060;font-family:arial, helvetica, sans-serif;"><span style="text-decoration:underline;"><strong>'+title+'</strong></span></span> </p> <p style="text-align: center;"> <span style="color: #000!important; font-size: 18px;font-family:arial, helvetica, sans-serif;">This listing is for a '+title+'. '+default_description+' </span><br/>'+return_html+' </p>';
  $('#desc_div').html('');  
  $('#desc_div').append(pre_desc);
  UM.getEditor('item_desc').focus();//this will set the value of textarea and form will get the updated value
  um.blur();
});
/*=====  End of create discription function  ======*/
/*===================================================
=            create discription function            =
===================================================*/
$(document).on('click','#macro_desc',function(){
  var selectedMacro= '';
  var shipTerm= '';
  var partTerm='';
  $('.select_macro_button').each(function (index, value){
    if($(this).attr('macro_type') != 3){

     selectedMacro += $(this).attr('macroDescription')+" ";
    }else{
      if($(this).attr('macroid') == 4){
        partTerm+= $(this).attr('macroDescription')+" ";
      }else{
      shipTerm += $(this).attr('macroDescription')+" ";
      }
    }
  });
  // $(".loader").show();
  // $.ajax({
  //     url: '<?php //echo base_url(); ?>tolist/c_tolist/saveMacro',
  //     type:'post',
  //     dataType:'json',
  //     data:{'selectedMacro':selectedMacro},
  //     success: function(data){
  //       $(".loader").hide();
  //       if (data) {
  //             $( "#macro_container" ).html("");
  //             var tr='';
  //              //var CategoryCount = data['CategoryCount']; 
  //              $( "#macro_container" ).html( "<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><h3 class='box-title'>Macro Details</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div><table width='100%' class='table table-bordered table-striped' border='1' id='macro_table'><th>Select</th><th>Macro Description</th>" );
  //             for ( var i = 1; i <= data.length; i++ ) 
  //             {
  //               var macroDesc = data[i-1]['MACRO_DESCRIPTION'];
  //               var macroId = data[i-1]['MACRO_ID'];
  //               $('<tr>').html("<td><a class='crsr-pntr select_macro' macroId='"+macroId+"' idx='"+i+"'' id='macro_"+macroId+"' onclick='selectMacro("+i+");'> Select </a></td><td>" + macroDesc + "</td></tr></table></div></div>").appendTo('#macro_table');
  //             }

  //             $( "</table></div></div>" ).appendTo( "#macro_container");
            
  //       }else{
  //           //$('#list_qty').val(parseInt(checkboxValues.length));

  //       }
          
        
  //     }
  //   });
  //console.log(shipTerm);
  //return false;
  // var default_description = $('#selected_macro').val();
  // var default_description = $('#default_description').val();
  var title = $('#title').val();
  var return_option = $('#return_option').val();
  return_html = '';
  if(return_option == 'ReturnsNotAccepted'){
    return_html = '<p style="text-align: center;"> <span style="font-size: 18px; font-family: arial, helvetica, sans-serif;color:#ff0000"><span style="text-decoration:underline;"><strong>NO RETURNS ARE ACCEPTED ON THIS ITEM</strong></span></span> </p>'; 
  }
  //console.log(default_description,title);
  var pre_desc = '<p style="text-align: center;"> <span style="font-size:24px;color:#002060;font-family:arial, helvetica, sans-serif;"><span style="text-decoration:underline;"><strong>'+escapeHtml(title)+'</strong></span></span> </p> <p style="text-align: center;"> <span style="color: #000!important; font-size: 18px;font-family:arial, helvetica, sans-serif;">This listing is for a '+escapeHtml(title)+'. '+escapeHtml(selectedMacro)+' </span><br/>'+return_html+' </p>';
  if(partTerm.length > 0){
    pre_desc +='<p style="text-align: center;"> <span style="color: #000!important; font-size: 18px;"><strong>'+escapeHtml(partTerm)+'</strong></span></p>';
  }
  if(shipTerm.length > 0){
    pre_desc +='<p style="text-align: center;"> <strong><span style="font-size:12px"><span style="color:#ff0000">Shipping: </span><span style="color:#000000">'+escapeHtml(shipTerm)+'</span></span></strong></p>'; 
  }
  $('#desc_div').html('');  
  $('#desc_div').append(pre_desc);
  UM.getEditor('item_desc').focus();//this will set the value of textarea and form will get the updated value
  um.blur();

    /*===========================================================
  =            update defualt condition decription            =
  ===========================================================*/
  $('#default_description').val(escapeHtml(selectedMacro));
  
  
  /*=====  End of update defualt condition decription  ======*/
});
/*=====  End of create discription function  ======*/

/*=====================================================
=            on update save selected macro            =
=====================================================*/
$(document).on('click','#macro_desc',function(){
  var selectedMacro= [];
  var itemId = $('#pic_item_id').val();
  var conditionId = $('#it_condition').val();
  $('.select_macro_button').each(function (index, value){
    selectedMacro.push($(this).attr('macroid'));
  });
  //$(".loader").show();
  $.ajax({
      url: '<?php echo base_url(); ?>tolist/c_tolist/bindItemMacro',
      type:'post',
      dataType:'json',
      data:{'selectedMacro':selectedMacro,'itemId':itemId,'conditionId':conditionId},
      success: function(data){
        //$(".loader").hide();
        if (data) {

            
        }else{
            //$('#list_qty').val(parseInt(checkboxValues.length));

        }
          
        
      }
    });
});
/*=====  End of on update save selected macro  ======*/
/*=====================================================
=            copy seed function            =
=====================================================*/
$(document).on('click','#copy_seed',function(){
  var itemId = $('#pic_item_id').val();
  var conditionId = $('#pic_condition_id').val();
  var seed_id = $('#seed_id').val();
  
  $.ajax({
      url: '<?php echo base_url(); ?>tolist/c_tolist/copySeed',
      type:'post',
      dataType:'json',
      data:{'seed_id':seed_id,'itemId':itemId,'conditionId':conditionId},
      success: function(data){

        if (data) {
          window.location.reload();
            
        }else{
            //$('#list_qty').val(parseInt(checkboxValues.length));

        }
          
        
      }

    });
});

//image rotation functions strt
$(document).on('click','.rot_my_pic_seed',function(){

//return false;
 //$(".rot_my_pic_seed_seed").click(function(){

 var img = $(this).parents('.imgCls').find('img');
 

    if(img.hasClass('north')){
        img.attr('class','west');
        img.attr('stat_rot','270');
        
    }else if(img.hasClass('west')){
        img.attr('class','south');
        img.attr('stat_rot','180');
    }else if(img.hasClass('south')){
        img.attr('class','east');
        img.attr('stat_rot','90');
    }else if(img.hasClass('east')){
        img.attr('class','north');
        img.attr('stat_rot','0');
    }

  });

  $(".save_img_seed").click(function(){
    $(".loader").show();
    var get_pic = $(this).parents('.imgCls').find('img').attr('src');
    var get_url = $(this).parents('.imgCls').find('img').attr('id');
    var stat_rot = $(this).parents('.imgCls').find('img').attr('stat_rot');
    //var child_barcode = $('#child_barcode').val();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/sav_my_pic',
      data: { 'get_pic' : get_pic,'get_url' : get_url ,'stat_rot' : stat_rot 
    },
     success: function (data) {
      $(".loader").hide();
      console.log(data);
      if(data == 'true'){
        alert("Picture Saved");
        return false;
      }else{
        alert("error");
        return false;
      }   
      }
      });  
});

//image rotation functions end
/*=====  End of copy seed function  ======*/
  //Flat red color scheme for iCheck
  $('input[type="checkbox"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
  });

        //Date range as a button
    $('#expiryDate').datepicker(
        {
            format: 'dd/mm/yyyy'

            // startDate: moment().subtract(29, 'days'),
            // endDate: moment()
          }
      );
</script>