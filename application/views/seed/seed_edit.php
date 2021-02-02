<?php $this->load->view('template/header');?>

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

         <?php //var_dump($data_get['result'][0]->ITEM_ID);exit;
          if ($data_get == NULL) {
          ?>
          <div class="alert alert-info" role="alert">There is no record found.</div>
          <?php
          } else {
          // foreach ($data_get['result'] as $data_get['result'][0]) {
          ?>

            <div class="col-sm-4">
              <div class="form-group">
                  <label>ERP Code:</label>
                  <?php //var_dump(@$data_get['result']['result'][0]->LAPTOP_ITEM_CODE);exit; ?>
                  <input type='text' class="form-control" name="erp_code" value="<?php echo @$data_get['result'][0]->LAPTOP_ITEM_CODE; ?>" readonly >      
              </div>
            </div>
            <div class="col-sm-4 m-erp" >
                <div class="form-group">
                  <label for="">ERP Inventory Description:</label>
                  <input type='text' class="form-control" name="inven_desc" value="<?php echo htmlentities(@$data_get['result'][0]->ITEM_MT_DESC); ?>" readonly>
                </div>
            </div>

            <div class="col-sm-4">    
              <div class="form-group">      
                  <label for="">UPC:</label>
                  <input type="text" class="form-control" id="upc" name="upc" value="<?php echo @$data_get['result'][0]->UPC; ?>" readonly/>
                </div>
              </div>

            <div class="col-sm-4">  
                <div class="form-group">      
                  <label for="">SKU:</label>
                  <input type='text' class="form-control" id="sku" name="sku" value='<?php echo @$data_get['result'][0]->SKU_NO; ?>' readonly>
                </div>
              </div>  

            <div class="col-sm-4">
                <div class="form-group">      
                  <label for="">Manufacturer:</label>
                  <input type='text' class="form-control" name="manufacturer" value='<?php echo htmlentities(@$data_get['result'][0]->MANUFACTURER); ?>' readonly>
                </div>
              </div>

            <div class="col-sm-4">        
                <div class="form-group">      
                  <label for="">Part No:</label>
                  <input type='text' class="form-control" id="part_no" name="part_no" value='<?php echo htmlentities(@$data_get['result'][0]->MFG_PART_NO); ?>' readonly>
                </div>
            </div>
<?php 
    $it_condition  = @$data_get['condition_qry'][0]->ITEM_CONDITION;
    if(is_numeric(@$it_condition)){
        if(@$it_condition == 3000){
          @$it_condition = 'Used';
        }elseif(@$it_condition == 1000){
          @$it_condition = 'New'; 
        }elseif(@$it_condition == 1500){
          @$it_condition = 'New other'; 
        }elseif(@$it_condition == 2000){
            @$it_condition = 'Manufacturer refurbished';
        }elseif(@$it_condition == 2500){
          @$it_condition = 'Seller refurbished'; 
        }elseif(@$it_condition == 7000){
          @$it_condition = 'For parts or not working'; 
        }else{
            @$it_condition = 'Used'; 
        }
    }else{// end main if
      $it_condition  = ucfirst(@$it_condition);
    }
    $mpn = str_replace('/', '_', @$data_get['result'][0]->MFG_PART_NO);
    $master_path = $data_get['path_query'][0]['MASTER_PATH'];
    $dir =  $master_path.@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition."/";
     //var_dump($dir);exit;
   //$dir = "/WIZMEN-PC/item_pictures/master_pictures/".@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition;
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
    if ($m_flag){
      //var_dump($dir);exit;

    
?>
              <!-- Master Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Master Pictures:</label>
              <div id="" class="col-sm-12 b-full">
                <div id="" class="col-sm-12 p-t"> 
                 <ul id="" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
              <?php 
                  $it_condition  = @$data_get['condition_qry'][0]->ITEM_CONDITION;
                  if(is_numeric(@$it_condition)){
                      if(@$it_condition == 3000){
                        @$it_condition = 'Used';
                      }elseif(@$it_condition == 1000){
                        @$it_condition = 'New'; 
                      }elseif(@$it_condition == 1500){
                        @$it_condition = 'New other'; 
                      }elseif(@$it_condition == 2000){
                          @$it_condition = 'Manufacturer refurbished';
                      }elseif(@$it_condition == 2500){
                        @$it_condition = 'Seller refurbished'; 
                      }elseif(@$it_condition == 7000){
                        @$it_condition = 'For parts or not working'; 
                      }else{
                          @$it_condition = 'Used'; 
                      }
                  }else{// end main if
                    $it_condition  = ucfirst(@$it_condition);
                  }
                  $mpn = str_replace('/', '_', @$data_get['result'][0]->MFG_PART_NO);
                  $master_path = $data_get['path_query'][0]['MASTER_PATH'];
                  $dir = $master_path.@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition;
                 //$dir = "/WIZMEN-PC/item_pictures/master_pictures/".@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition;
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


                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style="width: 105px; height: 105px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">

                                        <?php
                                        $master_path = $data_get['path_query'][0]['MASTER_PATH'];
                                          $url = $master_path.@$data_get['result'][0]->UPC.'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        //$url = '/WIZMEN-PC/item_pictures/master_pictures/'.@$data_get['result'][0]->UPC.'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';?>
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
                      <a title="Update Master Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/master_view')?>" target="_blank">Update Master Pictures</a>
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
              <div id="" class="col-sm-12 b-full">
                <div id="" class="col-sm-12 p-t"> 
                 <ul id="" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
              <?php 
                  $it_condition  = @$data_get['condition_qry'][0]->ITEM_CONDITION;
                  if(is_numeric(@$it_condition)){
                      if(@$it_condition == 3000){
                        @$it_condition = 'Used';
                      }elseif(@$it_condition == 1000){
                        @$it_condition = 'New'; 
                      }elseif(@$it_condition == 1500){
                        @$it_condition = 'New other'; 
                      }elseif(@$it_condition == 2000){
                          @$it_condition = 'Manufacturer refurbished';
                      }elseif(@$it_condition == 2500){
                        @$it_condition = 'Seller refurbished'; 
                      }elseif(@$it_condition == 7000){
                        @$it_condition = 'For parts or not working'; 
                      }else{
                          @$it_condition = 'Used'; 
                      }
                  }else{// end main if
                    $it_condition  = ucfirst(@$it_condition);
                  }
                  $mpn = str_replace('/', '_', @$data_get['result'][0]->MFG_PART_NO);
                  $specific_path = $data_get['path_query'][0]['SPECIFIC_PATH'];

                  $dir = $specific_path.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID;
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
                              ?>


                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style="width: 105px; height: 105px; background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">

                                        <?php
                                          $specific_path = $data_get['path_query'][0]['SPECIFIC_PATH'];

                                          $url = $specific_path.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID.'/'.$parts['0'].'.'.$extension;
                                        //$url = '/WIZMEN-PC/item_pictures/specific_pictures/'.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID.'/'.$parts['0'].'.'.$extension;
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';?>
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
                      <a title="Update Master Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures')?>" target="_blank">Update Specific Pictures</a>
                      <!-- <input id="update_order" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order"> -->
                      <!-- <span><i id="del_all" onclick="return confirm('are you sure?')" title="Delete All Pictures" class="btn btn-sm btn-danger">Delete All</i></span> -->
                    </div>
                    
                  <!--</form>-->
                </div>
                </div> 

              </div>
            </div>
            <!-- Specific Picture section end-->


<?php //}
 }else{//directory count elseif ?>

          <!-- Picture section start-->     
            <div class="col-sm-12 p-b">
              <div class="form-group">      
                  <label for="">Picture:</label>

                  <span class="text-danger">
                   <?php 
                      $error_msg = $this->session->userdata('size_error');
                      if(!empty($error_msg)){echo @$error_msg." size is too large.";}
                      //var_dump($error_msg);
                      //echo $error_msg;
                      $this->session->unset_userdata('size_error');
                   ?> 
                  </span>  

              </div>               
              <div id="drop-area" class="col-sm-12 b-full"> 
                <div class="col-sm-2">                   
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                      <div class="uploadimg">
      <?php
            $seed_history = $this->session->userdata('seed_history');
      if($seed_history){
        $manifest_id=$this->session->userdata('manifest_id');
        $this->session->unset_userdata('manifest_id');
      }
            ?>
                       <form id="frmupload" enctype="multipart/form-data">
                          <input type="file" multiple="multiple" name="image[]" id="image" style="display:none"/>
                          <input type="hidden" style="display:none;" class="form-control" id="pic_item_id" name="pic_item_id" value="<?php echo @$data_get['result'][0]->ITEM_ID; ?>">
                          <input type="hidden" style="display:none;" class="form-control" id="pic_manifest_id" name="pic_manifest_id" value="<?php if (@$manifest_id){echo $manifest_id;}else{echo @$data_get['result'][0]->LZ_MANIFEST_ID;} ?>">
                          <span id="btnupload" class="fa fa-cloud-upload"></span>

                        </form>
                      </div>
                  </div>
              </div>



              <div class="col-sm-10 p-t" style="padding-left:0px !important;padding-right:0px !important;"> 

                  <?php if(empty($img_data)):?>
                    <div class="col-sm-2 imgCls">                          
                        <?php echo 'No Image to Display';?>
                    </div>
                  <?php endif; ?>

              <ul id="sortable" class="">

                  <?php if(!empty($img_data)):?>
                    <?php foreach($img_data as $im):?>
                  <?php $img = $im->ITEM_PIC->load();?>
                  <?php $pic= base64_encode($img);?>

                <li id="<?php echo $im->ITEM_PICTURE_ID;?>">
                  <span class="tg-li">
                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">
                    <!--<div class="col-sm-2 imgCls">-->                          
                      <?php echo '<img class="sort_img up-img" id="'.$im->ITEM_PICTURE_ID.'" name="'.$im->ITEM_PICT_DESC.'" src="data:image;base64,'.$pic.' "/>';?>

                      <div class="img_overlay">
                        <span><i class="fa fa-trash"></i></span>
                      </div>

                    </div>                    
                  </span>                        
                </li>



                <?php endforeach;
                      endif;?>
              </ul>
                                
            </div>

              <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                    <div class="col-sm-8">
                      <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group pull-right">
                        <input id="update_order" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                        <span><i id="del_all" onclick="return confirm('are you sure?')" title="Delete All Pictures" class="btn btn-sm btn-danger">Delete All</i></span>
                      </div>
                      
                    <!--</form>-->
                  </div>
              </div> 

            </div>
          </div>
          <!-- Picture section end--> 
<?php }//directory count elseif end ?>

              <?php 
              if (@$seed_history){
               echo form_open('seed/c_seed/save', 'name="save_form"','id="save_form"','role="form"');
               }elseif(@$data_get['result'][0]->ITEM_TITLE){
              echo form_open('seed/c_seed/update','name="update_form"','id="update_form"','role="form"');
              }else{
                echo form_open('seed/c_seed/save', 'name="save_form"','id="save_form"','role="form"');
              }
               ?>                 
<?php

// function title_short($string){
//    $string = substr($string,0,80);
//    $string = substr($string,0,strrpos($string," "));
//    return $string;
// }
//   $title_long = @$data_get['result'][0]->ITEM_TITLE;
//   $desc_long = @$data_get['result'][0]->ITEM_MT_DESC;
//   $title_short = title_short(@$title_long);
//   $desc_short = title_short(@$desc_long);
//echo $title_short;

$title = @$data_get['result'][0]->ITEM_TITLE;
$desc = @$data_get['result'][0]->ITEM_MT_DESC;
$item_title = substr($title,0,80);
$item_desc = substr($desc,0,80);
//echo substr($title,0,80);

?>
            <div class="col-lg-12">
                <div class="form-group">      
                  <label for="">Title:</label>
                  <span>Maximum of 80 characters - 
                  <input class="c-count" type="text" id='titlelength' name="titlelength" size="3" maxlength="3" value="80" readonly> characters left</span><br/>
                  <input type='text' class="form-control" name="title" id="title" onKeyDown="textCounter(this,80);" maxlength="80" onKeyUp="textCounter(this,'titlelength' ,80)" value="<?php if(empty(@$item_title)){echo htmlentities(@$item_desc);}else{echo htmlentities(@$item_title);}?>"/>
                </div>
              </div>

            <div class="col-sm-2">
              <div class="form-group">
                  <label for="">Category ID:</label>
                  <input type="number" class="form-control" id="category_id" name="category_id" value="<?php echo @$data_get['result'][0]->CATEGORY_ID; ?>" required>
              </div>
            </div>

            <div class="col-sm-8">
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

            <div class="col-sm-2">
              <div class="form-group">      
                  <label for="">Default Condition:</label>
                  <select class="form-control" id="default_condition" name="default_condition" value="<?php echo @$data_get['result'][0]->DEFAULT_COND; ?>">
                  <option value="3000" <?php if(@$data_get['condition_qry'][0]->ITEM_CONDITION == 3000 ){echo "selected='selected'";}elseif(@$data_get['result'][0]->DEFAULT_COND == "Used" || @$data_get['result'][0]->DEFAULT_COND == "used" ){echo "selected='selected'";} ?>>Used</option>
                  <option value="1000" <?php if(@$data_get['condition_qry'][0]->ITEM_CONDITION == 1000){echo "selected='selected'";}elseif(@$data_get['result'][0]->DEFAULT_COND == "New" || @$data_get['result'][0]->DEFAULT_COND == "new" ){echo "selected='selected'";} ?>>New</option>
                  <option value="1500" <?php if(@$data_get['condition_qry'][0]->ITEM_CONDITION == 1500 ){echo "selected='selected'";}elseif(@$data_get['result'][0]->DEFAULT_COND == "New Other" || @$data_get['result'][0]->DEFAULT_COND == "New other" || @$data_get['result'][0]->DEFAULT_COND == "new other" || @$data_get['result'][0]->DEFAULT_COND == "New other(see details)" || @$data_get['result'][0]->DEFAULT_COND == "New without tags" ){echo "selected='selected'";} ?>>New other</option>
                  <option value="2000" <?php if(@$data_get['condition_qry'][0]->ITEM_CONDITION == 2000 ){echo "selected='selected'";}elseif(@$data_get['result'][0]->DEFAULT_COND == "Manufacturer Refurbished" || @$data_get['result'][0]->DEFAULT_COND == "manufacturer refurbished" ){echo "selected='selected'";} ?>>Manufacturer Refurbished</option>
                  <option value="2500" <?php if(@$data_get['condition_qry'][0]->ITEM_CONDITION == 2500 ){echo "selected='selected'";}elseif(@$data_get['result'][0]->DEFAULT_COND == "Seller Refurbished" || @$data_get['result'][0]->DEFAULT_COND == "seller refurbished" ){echo "selected='selected'";} ?>>Seller Refurbished</option>
                  <option value="7000" <?php if(@$data_get['condition_qry'][0]->ITEM_CONDITION == 7000 ){echo "selected='selected'";}elseif(@$data_get['result'][0]->DEFAULT_COND == "For Parts or Not Working" || @$data_get['result'][0]->DEFAULT_COND == "For parts" ){echo "selected='selected'";} ?>>For Parts or Not Working</option>

                </select>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="form-group">      
                  <label for="">Default Condition Description:</label>

                  <textarea class="form-control default_desc" rows="5" id="default_description" name="default_description" value=""><?php if(!empty(@$data_get['result'][0]->DETAIL_COND)){echo htmlentities(@$data_get['result'][0]->DETAIL_COND);} ?></textarea>

                </div>
              </div>                                                   
                
            <div class="col-lg-12">
              <div class="form-group">      
                  <label for="">Item Description:</label>
                  

                  <textarea id="item_desc" style="height:200px !important;" class="form-control" rows="10" cols="80" name="item_desc" value=""><?php if(empty(@$data_get['result'][0]->ITEM_DESC)){echo "<p style='text-align: center;'><span style='font-size:32px;color:#002060'><span style='text-decoration:underline;'><strong>".@$data_get['result'][0]->ITEM_MT_DESC."</strong></span></span></p><p style='text-align: center;'><span style='font-size:32px;color:#002060'><span style='text-decoration:underline;'><strong><br/></strong></span></span></p><p style='text-align: center;'><span style='font-size:24px;color:#000000'>This listing is for ".@$data_get['result'][0]->ITEM_MT_DESC;}else{echo @$data_get['result'][0]->ITEM_DESC;} ?></textarea>
                  
                </div>
              </div>


              <div class="col-sm-8"> 
                  <label for="">Price:</label>
                <div class="input-group">
                  <span class="input-group-addon">US $</span>
                  <input type="number" step="0.01" min="0" class="form-control" name="price" value="<?php echo @$data_get['result'][0]->EBAY_PRICE; ?>" required/>
                  <!--<input id="price" type="text" class="money form-control" data-mask="000,000,000,000,000.00" data-mask-clearifnotmatch="true" name="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>"/>-->
                </div>
                  <a class="crsr-pntr" title="Click here for Price suggestion" id="suggest_price">Suggest Price</a> &nbsp;&nbsp; 
                  <!-- <a class="crsr-pntr" title="Click here for Advance Price Search" href="http://localhost/advance_search/advancedItemSearch.html" target="_blank">Advance Price Search</a><br> -->



              </div>


            <div class="col-sm-4">
              <div class="form-group p-b-25"> 
                  <label for="">Template Name:</label>
                  <select class="form-control" id="temp_name" name="template_name" value="<?php echo @$data_get['result'][0]->TEMPLATE_ID; ?>">

                  <?php //foreach($temp_data as $data_get['result'][0]): 
                  //$data_get['result'][0] is already used in above foreach loop so have to use diffrent varibale for this loop
                  foreach($temp_data as $res):
                  ?>
                  <option value="<?php echo @$res['TEMPLATE_ID']; ?>" <?php if(@$res['TEMPLATE_ID'] == @$data_get['result'][0]->TEMPLATE_ID ){echo "selected='selected'";} ?>><?php echo htmlentities(@$res['TEMPLATE_NAME']);?></option>
              <?php endforeach;?>
                </select>
              </div>
            </div><br>

              <div class="col-sm-9">

                <!--Price Result-->
                <div id="price-result">

                </div>              
                
              </div>            
            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Shipping Service:</label>
                  <select class="form-control" id="shipping_service_disabled" name="shipping_service" disabled="disabled" value="<?php echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>" required>
                    <option value="USPSParcel" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option>
                    <option value="USPSFirstClass" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select>

                  <!-- Hidden Field -->
              
                  <select style="display:none !important;" class="form-control" id="shipping_service" name="shipping_service"  value="<?php echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>">
                    <option value="USPSParcel" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option>
                    <option value="USPSFirstClass" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select> 
                 

              </div>
            </div>  
           
            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Shipping Service Cost:</label>
                  <input class="form-control" type="number" id="shipping_cost" name="shipping_cost" readonly value="<?php echo @$data_get['result'][0]->SHIPPING_COST; ?>"/>
                </div>
            </div>      

            <div class="col-sm-4">        
              <div class="form-group">      
                  <label for="">Additional Cost:</label>
                  <input class="form-control" type="number" id="additional_cost" name="additional_cost" readonly value="<?php echo @$data_get['result'][0]->ADDITIONAL_COST; ?>"/>
                </div>
            </div>      

            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Site ID:</label>
                  <input class="form-control" id="site_id" name="site_id" readonly type="number" value="<?php echo @$data_get['result'][0]->EBAY_LOCAL; ?>"/>
                </div>
            </div>    

            <div class="col-sm-4">        
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
            
            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Currency:</label>
                  <input class="form-control" id="currency" name="currency" type="text" readonly value="<?php echo @$data_get['result'][0]->CURRENCY; ?>"/>
                </div>
            </div>    

            <div class="col-sm-4">      
              <div class="form-group">      
                  <label for="">Ship From Country:</label>
                  <input class="form-control" id="ship_from" name="ship_from" type="text" value="US" readonly/>
                </div>
            </div>      

<!--            <div class="col-sm-4">   
              <div class="form-group">      
                  <label for="">Handling Time (Days)</label>
                  <input type="number" class="form-control" id="handling_time" name="handling_time" value="<?php //echo @$data_get['result'][0]->HANDLING_TIME; ?>"/>
                </div>
            </div>-->    

            <div class="col-sm-4">
                <div class="form-group">      
                  <label for="">Zip Code</label>
                  <input type="text" class="form-control" id="zip_code" name="zip_code" readonly value="<?php echo @$data_get['result'][0]->SHIP_FROM_ZIP_CODE; ?>"/>
                </div>
            </div>      

            <div class="col-sm-4">
                <div class="form-group">      
                  <label for="">Shipping Source:</label>
                  <input type="text" class="form-control" id="shipping_source" name="shipping_source" readonly value="US"/>
                </div>
            </div>    

            <div class="col-sm-4">        
              <div class="form-group">      
                  <label for="">Shipping From Location:</label>
                  <input type="text" class="form-control" id="ship_from_loc" readonly name="ship_from_loc"  value="<?php echo htmlentities(@$data_get['result'][0]->SHIP_FROM_LOC); ?>"/>
                </div>
            </div>     

            <!--<div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Bid Length:</label>
                  <input class="form-control" id="bid_length" name="bid_length" type="text" value="<?php //echo @$data_get['result'][0]->BID_LENGTH; ?>"/>
                </div>
            </div>-->      

            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Payment Method:</label>
                  <input class="form-control" id="payment_method" name="payment_method" type="text" readonly value="<?php echo @$data_get['result'][0]->PAYMENT_METHOD; ?>" required/>
                </div>
            </div>      

            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Paypal Email Address:</label>
                  <input type="text" class="form-control" id="paypal" name="paypal" readonly value="<?php echo @$data_get['result'][0]->PAYPAL_EMAIL; ?>"/>
                </div>
            </div>      

            <div class="col-sm-4">
              <div class="form-group">      
                  <label for="">Dispatch Time Max (Days):</label>
                  <input type="number" class="form-control" id="dispatch_time" name="dispatch_time" readonly value="<?php echo @$data_get['result'][0]->DISPATCH_TIME_MAX; ?>"/>     
                </div>
            </div>      

            <div class="col-sm-4">
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

            <div class="col-sm-4">    
              <div class="form-group">      
                  <label for="">Return Within (Days):</label>
                  <input type="number" min="14" class="form-control" id="return_within" name="return_within" readonly value="<?php if(empty(@$data_get['result'][0]->RETURN_DAYS)){echo "14";}else{echo @$data_get['result'][0]->RETURN_DAYS;} ?>"/>
              </div>
            </div>  

            <div class="col-sm-4">
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

              
            
          <div class="col-lg-12">
              <input type="hidden" name="barcode" value='<?php echo @$data_get['result'][0]->IT_BARCODE; ?>'/>

               <input type="submit" name="submit" title="Update Seed" onclick="return validateMPN()" class="btn btn-primary" value="Update">

                 <?php
              // foreach and else close
             // }
          

        }
           ?>

            <!-- values to save seed form -->
        
              <input type="hidden" style="display:none;" class="form-control" id="pic_item_id" name="pic_item_id" value="<?php echo @$data_get['result'][0]->ITEM_ID; ?>">
              <input type="hidden" style="display:none;" class="form-control" id="pic_manifest_id" name="pic_manifest_id" value="<?php if (@$manifest_id){echo $manifest_id;}else{echo @$data_get['result'][0]->LZ_MANIFEST_ID;} ?>">
            <!-- values to save seed form -->

              <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('listing/listing') ?>'" class="btn btn-success">Back</button>
          </div>
          <!-- </form> -->
          <?php echo form_close(); ?>
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

<!-- <script type="text/javascript" src="<?php //echo base_url('assets/dist/js/custom.js');?>"></script> -->
<script>
  function textCounter(field,cnt, maxlimit) {         
  var cntfield = document.getElementById(cnt) 
     if (field.value.length > maxlimit) // if too long...trim it!
    field.value = field.value.substring(0, maxlimit);
    // otherwise, update 'characters left' counter
    else
    cntfield.value = maxlimit - field.value.length;
}

// Check for Images
// function validateImage() {
//     var x  = $(".up-img").val();
//     //alert(x);
//     if (x == null) {
//         alert("Please Select Images.");
//         return false;
//     }
// }

// Check for MPN Number
function validateMPN() {
    var x  = $("#part_no").val();
    //alert(x);
    if (x == null || x == "") {
        alert("MPN Number is required for listing.");
        //return false;
    }
}

/*-- Template load data --*/
   $("#temp_name").ready(function(){
      var TempID  = $("#temp_name").val();
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
      //document.getElementById("default_condition").innerHTML=$('#default_condition').val(data.DEFAULT_COND);
       //$('#default_condition').val(data.DEFAULT_COND);
       // $('#default_description').val(data.DETAIL_COND);
       $('#shipping_service').val(data.SHIPPING_SERVICE);
       $('#shipping_service_disabled').val(data.SHIPPING_SERVICE);
       
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


     }else{
       document.write('No Result found');
       
      }
     }
     }); 
 });
/*-- End Template load data --*/
/*-- Default Condition values --*/
   $("#default_condition").ready(function(){
      var CondID  = $("#default_condition").val();
      $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>index.php/seed/c_seed/get_conditions',
      data: { 'CondID' : CondID},
     success: function (data) {
       if(data.DEFAULT_COND!=''){ 
         $('#default_description').val(data.COND_DESCRIPTION);
       }else{
         document.write('No Result found');
        }
      }
    });
 });
/*-- Default Condition values end --*/
</script>
<?php $this->load->view('template/footer');?>


