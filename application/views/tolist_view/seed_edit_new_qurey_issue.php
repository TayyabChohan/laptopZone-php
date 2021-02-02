<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>

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

echo form_open('tolist/c_tolist/update','name="update_form"','id="update_form"','role="form"');
              
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
              <div class="form-group">      
                  <label for="">UPC:</label>
                  <input type="text" class="form-control" id="upc_seed" name="upc_seed" value="<?php echo @$data_get['result'][0]->UPC; ?>" readonly/>
                </div>
              </div>
            <div class="col-sm-3">  
                <div class="form-group">      
                  <label for="">SKU:</label>
                  <input type='text' class="form-control" id="sku" name="sku" value='<?php echo @$data_get['result'][0]->SKU_NO; ?>' readonly>
                </div>
              </div>  

            <div class="col-sm-3">
                <div class="form-group">      
                  <label for="">Manufacturer:</label>
                  <input type='text' class="form-control" name="manufacturer" value='<?php echo htmlentities(@$data_get['result'][0]->MANUFACTURER); ?>' readonly>
                </div>
              </div>

            <div class="col-sm-3">        
                <div class="form-group">      
                  <label for="">Part No:</label>
                  <input type='text' class="form-control" id="part_no_seed" name="part_no_seed" value='<?php echo htmlentities(@$data_get['result'][0]->MFG_PART_NO); ?>' readonly>
                </div>
            </div>
            <div class="col-sm-3">        
                <div class="form-group">      
                  <label for="">Ounce:</label>
                  <input type="number" step="0.01" min="0" class="form-control" id="weight" name="weight" value='<?php if(@$data_get['result'][0]->WEIGHT){echo htmlentities(@@$data_get['result'][0]->WEIGHT);} ?>' >

                  <!-- <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>" required/> -->
                </div>
            </div>            
<?php 
    $it_condition  = @$data_get['result'][0]->DEFAULT_COND;
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
    $dir = preg_replace("/[\r\n]*/","",$dir);
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
                  $it_condition  = @$data_get['result'][0]->DEFAULT_COND;
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
                  }//else{// end main if
                  //   $it_condition  = ucfirst(@$it_condition);
                  // }
                  $mpn = str_replace('/', '_', @$data_get['result'][0]->MFG_PART_NO);
                  $master_path = $data_get['path_query'][0]['MASTER_PATH'];
                  $dir = $master_path.@$data_get['result'][0]->UPC."~".@$mpn."/".@$it_condition;
                  $dir = preg_replace("/[\r\n]*/","",$dir);
                  //var_dump($dir);exit;
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

                              <?php
                              $master_path = $data_get['path_query'][0]['MASTER_PATH'];
                              $url = $master_path.@$data_get['result'][0]->UPC.'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                              ?>
                                <li id="<?php echo $parts['0'].'.'.$extension;?>" > 
                                  <span class="tg-li">

                                    <div class="imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">


                                        <?php
                                        // $master_path = $data_get['path_query'][0]['MASTER_PATH'];
                                        //   $url = $master_path.@$data_get['result'][0]->UPC.'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        //$url = '/WIZMEN-PC/item_pictures/master_pictures/'.@$data_get['result'][0]->UPC.'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
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
                                     <span class="thumb"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span>                   
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
              <!-- Specific Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Specific Pictures:</label>
              <div id="" class="col-sm-12 b-full">
                <div id="" class="col-sm-12 p-t">
<!-- style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"-->                                 
                 <ul id="" style="height: 140px !important; list-style: none; white-space: nowrap; position: relative; padding: 0; margin: 0; vertical-align: top; left: 0; width: 100%;"> 
              <?php 
                  $it_condition  = @$data_get['result'][0]->DEFAULT_COND; 
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
                                          // $specific_path = $data_get['path_query'][0]['SPECIFIC_PATH'];

                                          // $url = $specific_path.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID.'/'.$parts['0'].'.'.$extension;
                                        //$url = '/WIZMEN-PC/item_pictures/specific_pictures/'.@$data_get['result'][0]->UPC."~".$mpn."/".@$it_condition."/".@$data_get['result'][0]->LZ_MANIFEST_ID.'/'.$parts['0'].'.'.$extension;
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
                                    <span class="thumb"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span>                      
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
            <?php //var_dump($data_get['pic_note']);exit; ?>
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
           
                  }
                  ?>
                </ol>

              </div>
            </div>  

<?php //}
 //}//else{//directory count elseif ?>


              

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
            $cond_desc  = @$data_get['result'][0]->DEFAULT_COND;
                if(is_numeric(@$cond_desc)){
                    if(@$cond_desc == 3000){
                      @$cond_desc = 'Used';
                    }elseif(@$cond_desc == 1000){
                      @$cond_desc = 'New'; 
                    }elseif(@$cond_desc == 1500){
                      @$cond_desc = 'New other'; 
                    }elseif(@$cond_desc == 2000){
                        @$cond_desc = 'Manufacturer refurbished';
                    }elseif(@$cond_desc == 2500){
                      @$cond_desc = 'Seller refurbished'; 
                    }elseif(@$cond_desc == 7000){
                      @$cond_desc = 'For parts or not working'; 
                    }else{
                        @$cond_desc = 'Used'; 
                    }
                }else{// end main if
                  $cond_desc  = ucfirst(@$cond_desc);
                }
          ?>
            <div class="col-sm-2">
              <div class="form-group">      
                  <label for="">Default Condition:</label>
                  <input class="form-control" id="default_condition" name="default_condition" value="<?php echo $cond_desc;?>" readonly>
                  <input type="hidden" class="form-control" id="it_condition" name="it_condition" value="<?php echo @$data_get['result'][0]->DEFAULT_COND;?>" readonly>
                  <!-- <select class="form-control" id="default_condition" name="default_condition" value="<?php //echo @$data_get['result'][0]->DEFAULT_COND; ?>" readonly>
                  <option value="3000" <?php //if(@$data_get['result'][0]->DEFAULT_COND == 3000 ){//echo "selected='selected'";} ?>>Used</option>
                  <option value="1000" <?php //if(@$data_get['result'][0]->DEFAULT_COND == 1000){//echo "selected='selected'";} ?>>New</option>
                  <option value="1500" <?php //if(@$data_get['result'][0]->DEFAULT_COND == 1500 ){//echo "selected='selected'";} ?>>New other</option>
                  <option value="2000" <?php //if(@$data_get['result'][0]->DEFAULT_COND == 2000 ){//echo "selected='selected'";} ?>>Manufacturer Refurbished</option>
                  <option value="2500" <?php //if(@$data_get['result'][0]->DEFAULT_COND == 2500 ){//echo "selected='selected'";} ?>>Seller Refurbished</option>
                  <option value="7000" <?php //if(@$data_get['result'][0]->DEFAULT_COND == 7000 ){//echo "selected='selected'";} ?>>For Parts or Not Working</option> -->

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

                </div>
              </div> 
<!-- Item Specific Start -->
            <div class="col-lg-12">

            <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add/Update Item Specifics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

                <div class="box-body">
                  
                    <?php 
                    if(!empty($spec_data)):?>

                      <input style="display: none;" type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$spec_data['mt_id'][0]['EBAY_CATEGORY_ID'];  ?>">
 
                  <div class="col-sm-12">
                  <input type="hidden" class="form-control" id="array_count" name="array_count" value="<?php echo count(@$spec_data['mt_id']);  ?>">
                    <?php
                      //$array_count = count(@$spec_data['mt_id']);

                      //var_dump($count);
                    //exit;
                      $i=1;
                      foreach(@$spec_data['mt_id'] as $count):
                    ?>
                      <div class="col-sm-3">
                        <div class="form-group">

                          <label for="" id="<?php echo 'specific_name_'.@$i;?>"><?php echo @$count['SPECIFIC_NAME']; ?></label>
                          
                         <?php if(@$count['MAX_VALUE'] > 1){ 
                          echo '<br><select name="specific_'.@$i.'" id="specific_'.@$i.'" class="selectpicker" multiple><option value="select">------------Select------------</option>';
                        }else{
                           echo '<select class="form-control selectpicker" name="specific_'.@$i.'" id="specific_'.@$i.'" data-live-search="true"><option value="select">------------Select------------</option>';
                        }
                          ?>
                          <?php foreach(@$spec_data['specs_qry'] as $specifics): ?>
                                                     
                            <?php
                              if($specifics['MT_ID'] == @$count['MT_ID']): 
                                   //if(@$specifics['SELECTION_MODE'] == "FreeText"){
                                if(!empty($specifics['SELECTED_VAL'])){
                                  $selected = 'selected';
                                }else{
                                  $selected = '';
                                }
                                    echo '<option value="'.htmlentities(@$specifics['SPECIFIC_VALUE']).'" '.$selected.'>'.@$specifics['SPECIFIC_VALUE'].'</option>';
                      
                                  //}
                                 endif;
                              ?>
                              <?php
                              endforeach;
                            ?>
                           </select>
                          
                          </div>                                     
                        </div>
                        

                      <?php $i++; endforeach; ?>
                      </div>

                      <div class="col-sm-12">
                        <div class="form-group pull-right">
                          <input type="button" class="btn btn-success btn-small" name="save_specifics" id="save_specifics" value="Save">
                          <!-- <a href="<?php //echo base_url();?>specifics/c_item_specifics/custom_attribute" target="_blank" class="btn btn-primary btn-small" name="custom_attribute" id="custom_attribute">Add Custom Specifics</a> -->
                        
                          <a href="<?php echo base_url();?>specifics/c_item_specifics/custom_search_item/<?php echo @$data_get['result'][0]->IT_BARCODE;?>" target="_blank" class="btn btn-primary btn-small" name="custom_attribute" id="custom_attribute">Add Custom Specifics</a>
                          <!-- <a class="btn btn-primary" href="<?php //echo base_url()."specifics/c_item_specifics/update_seed_spec/".@$data_get['result'][0]->IT_BARCODE; ?>" target="_blank">Update Item Specifics</a> -->
                        </div>

                      </div> 
                                                                       
                      <?php endif; ?>


                    <!-- </form> -->
            
                </div>

            </div>

                  
         
            </div>
            <!-- Item Specific end -->      
            <div class="col-lg-12">
              <div class="form-group">      
                  <label for="">Item Description:</label>
                  

                  <textarea id="item_desc" style="height:200px !important;" class="form-control" rows="10" cols="80" name="item_desc" value=""><?php if(empty(@$data_get['result'][0]->ITEM_DESC)){echo "<p style='text-align: center;'><span style='font-size:32px;color:#002060'><span style='text-decoration:underline;'><strong>".@$data_get['result'][0]->ITEM_MT_DESC."</strong></span></span></p><p style='text-align: center;'><span style='font-size:32px;color:#002060'><span style='text-decoration:underline;'><strong><br/></strong></span></span></p><p style='text-align: center;'><span style='font-size:24px;color:#000000'>This listing is for ".@$data_get['result'][0]->ITEM_MT_DESC;}else{echo @$data_get['result'][0]->ITEM_DESC;} ?></textarea>
                  
                </div>
              </div>

              <?php //if(!empty(@$data_get['ship_fee_qry'][0]['SHIP_FEE'])){ ?>
              <div class="col-sm-6"> 
                  <label for="">Price:</label>
                <div class="input-group">
                  <span class="input-group-addon">US $</span>
                  <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?php echo @$data_get['result'][0]->EBAY_PRICE; ?>" required/>
                  <!--<input id="price" type="text" class="money form-control" data-mask="000,000,000,000,000.00" data-mask-clearifnotmatch="true" name="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>"/>-->
                </div>
                <span id="price_error"></span>
                  <a class="crsr-pntr" title="Click here for Price suggestion" id="suggest_price">Suggest Price</a> &nbsp;&nbsp; 
                  <!-- <a class="crsr-pntr" title="Click here for Advance Price Search" href="http://localhost/advance_search/advancedItemSearch.html" target="_blank">Advance Price Search</a><br> -->
  <?php if(@$data_get['ship_fee_qry'][0]['SHIP_FEE'] == 3.25){
            if (strpos(@$data_get['result'][0]->SHIPPING_SERVICE, 'FedEx') !== false) {?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='13.50'/>
        <?php }elseif(strpos(@$data_get['result'][0]->SHIPPING_SERVICE, 'First') !== false){ ?>
                <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='3.25'/>
        <?php }elseif(strpos(@$data_get['result'][0]->SHIPPING_SERVICE, 'Priority') !== false){ ?>
              <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='6.50'/>
           <?php   }else{ ?>
              <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='<?php echo @$data_get['ship_fee_qry'][0]['SHIP_FEE']; ?>'/>
           <?php   }
                  
        }else{ ?>
                
          <input type="hidden" style="display:none;" name="ship_fee" id="ship_fee" value='<?php echo @$data_get['ship_fee_qry'][0]['SHIP_FEE']; ?>'/>
  <?php } ?>
              </div>
              <?php //}else{?>
              <!-- <div class="col-sm-6"> 
                  <label for="">Price:</label>
                <div class="input-group">
                  <span class="input-group-addon">US $</span>
                  <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" value="<?php //echo @$data_get['result'][0]->EBAY_PRICE; ?>" required/>
                </div>
                <span id="price_error"></span>
                  <a class="crsr-pntr" title="Click here for Price suggestion" id="suggest_price">Suggest Price</a> &nbsp;&nbsp; 
              </div>
              <div class="col-sm-2"> 
                  
                <div class="form-group">
                <label for="">Shipping Cost:</label>
                  <input type="number" class="form-control" name="ship_fee" id="ship_fee"/>
                </div>
                
              </div> -->
              <?php// }//end if else for price?>

            <div class="col-sm-4">
              <div class="form-group p-b-25"> 
                  <label for="">Template Name:</label>
                  <select class="form-control" id="temp_name" name="template_name" value="<?php echo @$data_get['result'][0]->TEMPLATE_ID; ?>" required>

                  <?php //foreach($temp_data as $data_get['result'][0]): 
                  //$data_get['result'][0] is already used in above foreach loop so have to use diffrent varibale for this loop
                  foreach($temp_data as $res):
                  ?>
                  <option value="<?php echo @$res['TEMPLATE_ID']; ?>" <?php if(@$res['TEMPLATE_ID'] == @$data_get['result'][0]->TEMPLATE_ID ){echo "selected='selected'";} ?>><?php echo htmlentities(@$res['TEMPLATE_NAME']);?></option>
              <?php endforeach;?>
                </select>
              </div>
            </div>
            <div class="col-sm-2">
              <div class="form-group p-b-25 p-t-24">
                <a href = "" name="edit_temp" title="Edit Template" id = "edit_temp" class="btn btn-primary" target = "_blank" > Edit Template</a>
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
            <div class="col-sm-4">
              <div class="form-group">      
                   <label for="">Shipping Service:</label>
                  <!--<select class="form-control" id="shipping_service_disabled" name="shipping_service" disabled="disabled" value="<?php //echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>" required>
                    <option value="USPSParcel" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option>
                    <option value="USPSFirstClass" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select> -->

                  <!-- Hidden Field -->
              
                  <select  class="form-control" id="shipping_service" name="shipping_service"  value="<?php echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>">
                    
                    <option value="USPSFirstClass" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option>
                    <option value="USPSParcel" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select> 
                 

              </div>
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

            <div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Site ID:</label>
                  <input class="form-control" id="site_id" name="site_id" readonly type="number" value="<?php echo @$data_get['result'][0]->EBAY_LOCAL; ?>" required/>
                </div>
            </div>    

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

<!--            <div class="col-sm-4" style="display:none !important;">   
              <div class="form-group">      
                  <label for="">Handling Time (Days)</label>
                  <input type="number" class="form-control" id="handling_time" name="handling_time" value="<?php //echo @$data_get['result'][0]->HANDLING_TIME; ?>"/>
                </div>
            </div>-->    

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

            <!--<div class="col-sm-4" style="display:none !important;">
              <div class="form-group">      
                  <label for="">Bid Length:</label>
                  <input class="form-control" id="bid_length" name="bid_length" type="text" value="<?php //echo @$data_get['result'][0]->BID_LENGTH; ?>"/>
                </div>
            </div>-->      

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

            <div class="col-sm-4" style="display:none !important;">    
              <div class="form-group">      
                  <label for="">Return Within (Days):</label>
                  <input type="number" min="14" class="form-control" id="return_within" name="return_within" readonly value="<?php if(empty(@$data_get['result'][0]->RETURN_DAYS)){echo "14";}else{echo @$data_get['result'][0]->RETURN_DAYS;} ?>"/>
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
                
            
          <div class="col-lg-12">
          <div class="col-lg-4">
          <div class="form-group">
                      <!-- values to update seed form -->
             <input type="hidden" style="display:none;" name="seed_id" id="seed_id" value='<?php echo @$data_get['result'][0]->SEED_ID; ?>'/>
              <input type="hidden" style="display:none;" name="pic_item_id" id="pic_item_id" value='<?php echo @$data_get['result'][0]->ITEM_ID; ?>'/>
              <input type="hidden" style="display:none;" name="pic_manifest_id" id="pic_manifest_id" value='<?php echo @$data_get['result'][0]->LZ_MANIFEST_ID; ?>'/>
              <input type="hidden" style="display:none;" name="pic_condition_id" id="pic_condition_id" value='<?php echo @$data_get['result'][0]->DEFAULT_COND; ?>'/>

              <input type="hidden" style="display:none;" name="ebay_fee" id="ebay_fee" value='<?php echo @$data_get['ebay_paypal_qry'][0]['EBAY_FEE']; ?>'/>
              <input type="hidden" style="display:none;" name="paypal_fee" id="paypal_fee" value='<?php echo @$data_get['ebay_paypal_qry'][0]['PAYPAL_FEE']; ?>'/>
              <input type="hidden" style="display:none;" name="cost_price" id="cost_price" value='<?php echo @$data_get['cost_qry'][0]['COST_PRICE']; ?>'/>
              <!-- values to update seed form -->
               <input type="submit" name="submit" title="Update Seed" onclick="return validateMPN()" class="btn btn-primary" value="Update">

                 <?php
              // foreach and else close
             // }
          }
           ?>            
             <!--  <input type="hidden" style="display:none;" class="form-control" id="pic_item_id" name="pic_item_id" value="<?php //echo @$data_get['result'][0]->ITEM_ID; ?>">
              <input type="hidden" style="display:none;" class="form-control" id="pic_manifest_id" name="pic_manifest_id" value="<?php //if (@$manifest_id){echo $manifest_id;}else{echo @$data_get['result'][0]->LZ_MANIFEST_ID;} ?>"> -->
            
 <?php echo form_close(); ?>
              <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('tolist/c_tolist/lister_view') ?>'" class="btn btn-success">Back</button>
          </div>
            
          </div>
          <div class="col-lg-4">
            <div class="form-group">
              
            </div>

          </div>
          <div class="col-lg-4 ">
            <div class="form-group">
           <form action="<?php echo base_url(); ?>tolist/c_tolist/list_item" method="post" accept-charset="utf-8">

                      <input type="hidden" name="seed_id" class="seed_id" id="seed_id" value='<?php echo @$data_get['result'][0]->SEED_ID; ?>'/>
                      <input type="submit" name="item_list" title="List to eBay" onclick="return confirm('Are you sure?');" class="btn btn-success btn-sm pull-right" value="List">

                      </form>              
            </div>

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
    var x  = $("#part_no_seed").val();
    //alert(x);
    if (x == null || x == "") {
        alert("MPN Number is required for listing.");
        //return false;
    }
}

/*-- Suggest Price --*/
   $("#suggest_price").click(function(){
      var UPC  = $("#upc_seed").val();
      var TITLE  = $("#title").val();
      var MPN  = $("#part_no_seed").val();
      var CONDITION = $("#default_condition").val();
// ============ The block bellow is used in Single entry =================
      if(isNaN(CONDITION))//same as is_numeric
      {
        String.prototype.capitalizeFirstLetter = function() {
         return this.charAt(0).toUpperCase() + this.slice(1);
        }
        CONDITION=CONDITION.capitalizeFirstLetter();
        if(CONDITION == 'Used'){CONDITION = 3000;}
        else if(CONDITION == 'New'){CONDITION = 1000;}
        else if(CONDITION == 'New other'){CONDITION = 1500;}
        else if(CONDITION == 'Manufacturer Refurbished'){CONDITION = 2000;}
        else if(CONDITION == 'Seller Refurbished'){CONDITION = 2500;}
        else if(CONDITION == 'For Parts or Not Working'){CONDITION = 7000;}
        else{CONDITION = 3000;}
      }
// ============ The block Above is used in Single entry =================      
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
           var item_url = item['basicInfo']['viewItemURL'];
           var condition = item['basicInfo']['conditionDisplayName'];
            $('<tr>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td></tr></table></div></div>").appendTo('#sold_price_data_table');
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
             var item_url = item['basicInfo']['viewItemURL'];
             var condition = item['basicInfo']['conditionDisplayName'];
            $('<tr>').html("<td>" + i + "</td><td><a href='"+ item_url +"' target = '_blank'>" + username + "</a></td><td>" + price + "</td><td>" + condition + "</td></tr>").appendTo('#sold_price_data_table');
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
/*-- End Suggest Price --*/

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
      //document.getElementById("default_condition").innerHTML=$('#default_condition').val(data.DEFAULT_COND);
       //$('#default_condition').val(data.DEFAULT_COND);
       // $('#default_description').val(data.DETAIL_COND);
       //$('#shipping_service').val(data.SHIPPING_SERVICE);
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
      //var CondID  = $("#it_condition").val();
      var seed_id  = $("#seed_id").val();

      $.ajax({
      dataType: 'json',
      type: 'POST',
      url:'<?php echo base_url(); ?>index.php/seed/c_seed/get_conditions',
      data: { 
        //'CondID' : CondID,
              'seed_id':seed_id
    },
     success: function (data) {
     //console.log(data[0].DETAIL_COND);return false;
       if(data.DETAIL_COND == ''){ 
         $('#default_description').val(data.COND_DESCRIPTION);
       }
      }
    });
 });
/*-- Default Condition values end --*/
/*================================================
=            Master Pictures Re-Order            =
================================================*/

$("#master_reorder_seed").click(function () {
    var master_reorder = $('#sortable').sortable('toArray');
    var upc = $('#upc_seed').val();
    var part_no = $('#part_no_seed').val();
    var it_condition = $('#it_condition').val();
    //alert(upc+"_"+part_no+"_"+it_condition);return false;
    //alert(sortID);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/master_sorting_order',
      data: { 'master_reorder' : master_reorder,
              'upc':upc,
              'part_no':part_no,
              'it_condition':it_condition              
    },
     success: function (data) {
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
      if(login_id == 2 || login_id == 5){
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
    var sys_sug_price = selling_cost + (selling_cost * 40 /100);
    
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
             document.write('No Result found');
             
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
             document.write('No Result found');
             
            }
           }
           });// ajax call end
          
          
          /*=====  End of price analysis sold  ======*/
          /*==============================================
          =            system suggested price            =
          ==============================================*/
          $( "#sys_sug_price" ).html("");
          $( "#sys_sug_price" ).html( "<div> <div class='small-box bg-red'> <div class='inner'> <p class='summarycardcss' id='total_exp_record' style='font-size: 34px!important;'> "+sys_sug_price.toFixed(2)+"</p> <p><b>System Suggested Price</b> </p> </div> <div class='icon'> <i class='fa fa-usd' aria-hidden='true'></i> </div>  </div> </div>");
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
      if(login_id == 2 || login_id == 5){
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
      if(login_id == 2 || login_id == 5){
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
      if(login_id == 2 || login_id == 5){
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
      //document.getElementById("default_condition").innerHTML=$('#default_condition').val(data.DEFAULT_COND);
       //$('#default_condition').val(data.DEFAULT_COND);
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

</script>