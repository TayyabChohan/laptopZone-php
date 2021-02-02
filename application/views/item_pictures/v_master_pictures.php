<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Pictures
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Master Pictures</li>
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
              <h3 class="box-title">Master Pictures</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
              <div class="col-sm-12">

                <form action ="<?php echo base_url('item_pictures/c_item_pictures/item_search') ?>"  method="post">
               
                  <div class="col-sm-3">
                    <div class="form-group">
                    <label>Barcode:</label>
                    <?php //var_dump(@$data['search_query'][0]['IT_BARCODE']);?>
                      <input type="text" class="form-control" name="pic_bar_code" id="pic_bar_code" value="<?php if(@$data[0]['search_query'] != 'not_found'){echo @$data['search_query'][0]['IT_BARCODE'];}  ?>" required>
                    </div>
                  </div>
                      
                        <input type="hidden" class="form-control" name="pic_item_id" id="pic_item_id" value="~">
                        <input type="hidden" class="form-control" name="pic_manifest_id" id="pic_manifest_id" value="~">

                    <div class="col-sm-1">
                      <div class="form-group" style="padding-top:24px;">
                       <input class="btn btn-primary" type="submit" name="master_search" id="master_search" value="Search">
                      </div>
                    </div>

                  </form>
                  <?php if(!empty(@$data)){ ?>
                  
                  <?php  @$master_bin_id = $this->session->userdata("master_bin_id");?>
                  <div class="col-sm-2 ">             
                    <div class="form-group">
                      <label for="Assign Bin">Assign Bin:</label>
                      <input type="text" name="bin_id" id="bin_id" class="form-control" value="<?php if($master_bin_id){echo $master_bin_id;} ?>" required>    
                    </div>              
                  </div>                  
                  <div class="col-sm-6 ">             
                    <div class="form-group">
                      <label for="Remarks">Remarks About Bin Assign:</label>
                      <input type="text" name="remarks" id="remarks" class="form-control" value="" title="Remarks about Bin Assign">    
                    </div>              
                  </div>                  
                <?php } ?>                 
                 </div>
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

               <div class="col-sm-12">
               
                  
                   <?php //var_dump(@$data['uniq_cond']);exit;
                   // $barcode_error = $this->session->userdata('barcode_error');
                   if(!empty(@$data) && $barcode_error_msg != TRUE):
                     // $this->session->unset_userdata('barcode_error');
                   foreach(@$data['uniq_cond'] as $cond):?>
                  <div class="col-sm-4 <?php if(@$data['search_query'][0]['ITEM_CONDITION'] == @$cond['CONDITION_ID']){echo "b_selected ";} if(@$cond['CONDITION_ID'] == 1000){echo "m-green";}elseif(@$cond['CONDITION_ID'] == 3000){echo "m-blue";}elseif(@$cond['CONDITION_ID'] == 1500){echo "m-orange";}elseif(@$cond['CONDITION_ID'] == 2000){echo "m-red";}elseif(@$cond['CONDITION_ID'] == 2500){echo "m-purple";}elseif(@$cond['CONDITION_ID'] == 7000){echo "m-light-pink";}else{echo "b_selected ";} ?>">
                    <div class="form-group">
                    <?php if(@$data['search_query'][0]['ITEM_CONDITION'] == @$cond['CONDITION_ID'])
                            {
                              // if($cond['CONDITION_ID'] == 3000){
                              //   $condition = 'Used';
                              // }elseif($cond['CONDITION_ID'] == 1000){
                              //   $condition = 'New'; 
                              // }elseif($cond['CONDITION_ID'] == 1500){
                              //   $condition = 'New other'; 
                              // }elseif($cond['CONDITION_ID'] == 2000){
                              //     $condition = 'Manufacturer refurbished';
                              // }elseif($cond['CONDITION_ID'] == 2500){
                              //   $condition = 'Seller refurbished'; 
                              // }elseif($cond['CONDITION_ID'] == 7000){
                              //   $condition = 'For parts or not working'; 
                              // }                               
                              echo "<p class='gray_bg'>Selected Group is ".'"'.$cond['COND_NAME'].'"</p>';}
                          if(@$data['search_query'][0]['ITEM_CONDITION'] === @$cond['CONDITION_ID']){ 
                            echo "<p class='gray_bg'>Assigning Group Barcode # ";
                            foreach(@$data['barcode_query'] as $barcode): 
                              if(@$barcode['CONDITION_ID'] ===  $cond['CONDITION_ID']){
                                echo $barcode['BARCODE_NO'].', ';
                              }
                              
                            endforeach; 
                            echo "</p>";
                          }  

                              ?>
                              
                    <label for="">Quantity:</label>
                    <?php echo $cond['QTY']; ?>
                      <br>
                      <label for=""> Condition:                        

                      </label>
                      <?php 

                    // if($cond['CONDITION_ID'] == 3000){
                    //           $condition = 'Used';
                    //         }elseif($cond['CONDITION_ID'] == 1000){
                    //           $condition = 'New'; 
                    //         }elseif($cond['CONDITION_ID'] == 1500){
                    //           $condition = 'New other'; 
                    //         }elseif($cond['CONDITION_ID'] == 2000){
                    //             $condition = 'Manufacturer refurbished';
                    //         }elseif($cond['CONDITION_ID'] == 2500){
                    //           $condition = 'Seller refurbished'; 
                    //         }elseif($cond['CONDITION_ID'] == 7000){
                    //           $condition = 'For parts or not working'; 
                    //         } echo $condition;
                      echo $cond['COND_NAME'];
                        ?>
                      <br>

                      
                   <?php foreach(@$data['barcode_query'] as $barcode): 
                    //var_dump(@$cond);exit;
                      if(@$barcode['CONDITION_ID'] ===  $cond['CONDITION_ID']){?>
                      <a style="color:#000 !important;" class="btn btn-default btn-xs" href="<?php echo base_url('item_pictures/c_item_pictures/item_search')?>/<?php echo $barcode['BARCODE_NO'];?>"><?php echo $barcode['BARCODE_NO'];?></a>
<!--                       <button class="btn btn-xs" style="color:#000 !important;">
                        <?php //echo $barcode['BARCODE_NO'];?>
                      </button> -->
                        
                    <?php  }
                      

                   endforeach;
                   ?>
                    </div>                   
                  </div>
                  <?php endforeach; ?>
                    
              <?php endif;?> 
               </div>
              <?php
              // var_dump(@$data);exit;
              if(@$data === 'not_found'):?>

              <div class="col-sm-12">
                  <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h4><strong>Error-</strong>  Item testing Data not found. Please test item first.</h4>
                  </div>
                  </div>
              <?php

             endif;
              //var_dump(@$data);exit;
               if(!empty(@$data) && @$data != 'not_found' && empty(@$error_msg)):
               foreach(@$data['search_query'] as $row):?> 
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
                      <label>Item ID:</label>
                      <input type='number' class="form-control" name="item_id" id="item_id" value="<?php echo @$row['ITEM_ID']; ?>" readonly >      
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
                <div class="col-sm-2">
                  <div class="form-group">      
                    <label for="">Condition:</label>
                    
                      <select class="form-control" id="it_cond" name="it_cond" value="<?php echo @$data['search_query'][0]['ITEM_CONDITION'];?>" readonly>

                      <?php //foreach(@$data['search_query'] as $cond):
                        // if(@$cond['CONDITION_ID'] == 3000){
                        //       $condition = 'Used';
                        //     }elseif(@$cond['CONDITION_ID'] == 1000){
                        //       $condition = 'New'; 
                        //     }elseif(@$cond['CONDITION_ID'] == 1500){
                        //       $condition = 'New other'; 
                        //     }elseif(@$cond['CONDITION_ID'] == 2000){
                        //         $condition = 'Manufacturer refurbished';
                        //     }elseif(@$cond['CONDITION_ID'] == 2500){
                        //       $condition = 'Seller refurbished'; 
                        //     }elseif(@$cond['CONDITION_ID'] == 7000){
                        //       $condition = 'For parts or not working'; 
                        //     } 
                        //   if(@$row['ITEM_CONDITION'] == 3000){
                        //       $it_condition = 'Used';
                        //     }elseif(@$row['ITEM_CONDITION'] == 1000){
                        //       $it_condition = 'New'; 
                        //     }elseif(@$row['ITEM_CONDITION'] == 1500){
                        //       $it_condition = 'New other'; 
                        //     }elseif(@$row['ITEM_CONDITION'] == 2000){
                        //         $it_condition = 'Manufacturer refurbished';
                        //     }elseif(@$row['ITEM_CONDITION'] == 2500){
                        //       $it_condition = 'Seller refurbished'; 
                        //     }elseif(@$row['ITEM_CONDITION'] == 7000){
                        //       $it_condition = 'For parts or not working'; 
                        //     }                             
                            ?>
                        <!-- <option value="<?php //if(@$row['ITEM_CONDITION'] == @$cond['CONDITION_ID']){ echo $condition;}else{echo $it_condition;} ?>" <?php //if(@$row['ITEM_CONDITION'] == @$cond['CONDITION_ID']){echo "selected='selected'";}?> ><?php //if(@$row['ITEM_CONDITION'] == @$cond['CONDITION_ID']){ echo $condition;}else{echo $it_condition;}?></option> -->

                        <option value="<?php echo @$data['search_query'][0]['ITEM_CONDITION'];?>" selected='selected'><?php echo @$data['search_query'][0]['COND_NAME'];?></option>

                      <?php //endforeach;?>  

                        <!-- <option value="3000" <?php //if(@$row['ITEM_CONDITION']){ if(@$row['ITEM_CONDITION'] == 3000 ){echo "selected='selected'";}elseif(@$row['ITEM_CONDITION'] == "Used" || @$row['ITEM_CONDITION'] == "used" ){echo "selected='selected'";} }else{ if(@$data['ITEM_CONDITION'] == 3000 ){echo "selected='selected'";}elseif(@$data['ITEM_CONDITION'] == "Used" || @$data['ITEM_CONDITION'] == "used" ){echo "selected='selected'";}} ?>>Used</option>
                        <option value="1000" <?php //if(@$row['ITEM_CONDITION']){ if(@$row['ITEM_CONDITION'] == 1000){echo "selected='selected'";}elseif(@$row['ITEM_CONDITION'] == "New" || @$row['ITEM_CONDITION'] == "new" ){echo "selected='selected'";} }else{if(@$data['ITEM_CONDITION'] == 1000){echo "selected='selected'";}elseif(@$data['ITEM_CONDITION'] == "New" || @$data['ITEM_CONDITION'] == "new" ){echo "selected='selected'";}} ?>>New</option>
                        <option value="1500" <?php //if(@$row['ITEM_CONDITION']){ if(@$row['ITEM_CONDITION'] == 1500 ){echo "selected='selected'";}elseif(@$row['ITEM_CONDITION'] == "New Other" || @$row['ITEM_CONDITION'] == "New other" || @$row['ITEM_CONDITION'] == "new other" || @$row['ITEM_CONDITION'] == "New other(see details)" || @$row['ITEM_CONDITION'] == "New without tags" ){echo "selected='selected'";}}else{if(@$data['ITEM_CONDITION'] == 1500 ){echo "selected='selected'";}elseif(@$data['ITEM_CONDITION'] == "New Other" || @$data['ITEM_CONDITION'] == "New other" || @$data['ITEM_CONDITION'] == "new other" || @$data['ITEM_CONDITION'] == "New other(see details)" || @$data['ITEM_CONDITION'] == "New without tags" ){echo "selected='selected'";}} ?>>New other</option>
                        <option value="2000" <?php //if(@$row['ITEM_CONDITION']){if(@$row['ITEM_CONDITION'] == 2000 ){echo "selected='selected'";}elseif(@$row['ITEM_CONDITION'] == "Manufacturer Refurbished" || @$row['ITEM_CONDITION'] == "manufacturer refurbished" ){echo "selected='selected'";}}else{ if(@$data['ITEM_CONDITION'] == 2000 ){echo "selected='selected'";}elseif(@$data['ITEM_CONDITION'] == "Manufacturer Refurbished" || @$data['ITEM_CONDITION'] == "manufacturer refurbished" ){echo "selected='selected'";}} ?>>Manufacturer Refurbished</option>
                        <option value="2500" <?php //if(@$row['ITEM_CONDITION']){if(@$row['ITEM_CONDITION'] == 2500 ){echo "selected='selected'";}elseif(@$row['ITEM_CONDITION'] == "Seller Refurbished" || @$row['ITEM_CONDITION'] == "seller refurbished" ){echo "selected='selected'";}}else{if(@$data['ITEM_CONDITION'] == 2500 ){echo "selected='selected'";}elseif(@$data['ITEM_CONDITION'] == "Seller Refurbished" || @$data['ITEM_CONDITION'] == "seller refurbished" ){echo "selected='selected'";}} ?>>Seller Refurbished</option>
                        <option value="7000" <?php //if(@$row['ITEM_CONDITION']){ if(@$row['ITEM_CONDITION'] == 7000 ){echo "selected='selected'";}elseif(@$row['ITEM_CONDITION'] == "For Parts or Not Working" || @$row['ITEM_CONDITION'] == "For parts" ){echo "selected='selected'";}}else{if(@$data['ITEM_CONDITION'] == 7000 ){echo "selected='selected'";}elseif(@$data['ITEM_CONDITION'] == "For Parts or Not Working" || @$data['ITEM_CONDITION'] == "For parts" ){echo "selected='selected'";}} ?>>For Parts or Not Working</option> -->

                      </select> 
                    
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label>Current Bin:</label>
                    <?php //var_dump(@$row['BIN_ID']); 

                      // $bar_bin_id = @$row['BIN_NAME'];
                      // $query = $this->db->query("SELECT BIN_ID, BIN_NAME FROM (SELECT B.BIN_ID, DECODE(B.BIN_TYPE, 'TC', 'TC', 'PB', 'PB', 'WB', 'WB', 'AB', 'AB', 'DK', 'DK', 'NA', 'NA') || '-' || B.BIN_NO BIN_NAME FROM BIN_MT B) WHERE BIN_ID = '$bar_bin_id'");
                      // $result = $query->result_array();
                      // $current_bin_id = @$result[0]['BIN_NAME'];

                    ?>
                    <input type="text" name="current_bin" id="current_bin" class="form-control" value="<?php echo @$row['BIN_NAME']; ?>" readonly>
                  </div>
                </div>  
                              
                <div class="col-sm-12">
                  <div class="form-group">
                      <label for="">Picture Notes:</label>
                      <textarea class="form-control" name="picture_note" id="picture_note" cols="30" rows="4" readonly><?php echo @$row['PIC_NOTE'];?></textarea>
                  </div>
                </div> 

                <div class="col-sm-12">
                  <div class="form-group">
                      <label for="">Special Remarks:</label>
                      <textarea class="form-control" name="special_remarks" id="special_remarks" cols="30" rows="4" readonly><?php echo @$row['SPECIAL_REMARKS'];?></textarea>
                  </div>
                </div>

              <!-- Master Picture section Live_folder start-->     
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
                   $live_path = $data['path_query'][0]['LIVE_PATH'];
                   //$live_path = 'D:/wamp/www/item_pictures/dekitted_pictures/';
                   $dir = $live_path;
                   $dir = preg_replace("/[\r\n]*/","",$dir);

                  // Open a directory, and read its contents
                  
                  if (is_dir($dir)){

                    //if ($dh = opendir($dir)){
                    //$images = glob($dir . "*.jpg");
                    $images = glob($dir."\*.{JPG,jpg,GIF,gif,PNG,png,BMP,bmp,JPEG,jpeg}",GLOB_BRACE);
                    //if ($dh = glob($dir . "*.jpg")){
                      $i=1;

                      foreach($images as $image){
                      //while (($file = readdir($dh)) !== false){
                        //$parts = explode(".", $file);

                        $parts = explode(".", $image);
                        if (is_array($parts) && count($parts) > 1){
                            $extension = end($parts);
                            if(!empty($extension)){

                              ?>


                                <li id="<?php //echo $im->ITEM_PICTURE_ID;?>" style=" background: #eee; float: left; overflow: hidden; text-align: center; position: relative; padding: 3px;"> <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">

                                        <?php
                                          //$url = 'D:/item_pictures/master_pictures/'.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                                        $live_path = $data['path_query'][0]['LIVE_PATH'];
                                        $url = $parts['0'].'.'.$extension;
                                        $url = preg_replace("/[\r\n]*/","",$url);
                                        //var_dump($url);exit;
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img zoom_01" id="" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
                                  
                                                          
                                        <?php //echo '<img class="sort_img up-img" id="" name="" src="'.base_url('assets/item_pic').'/'.$parts['0'].'.'.$extension.'"/>';?>

<!--                                          <div class="img_overlay">
                                          <span><i class="fa fa-trash"></i></span> 
                                        </div> -->
                                      <div class="text-center" style="width: 100px;">
                                        <span class="d_spn"><i title="Delete Picture" id="<?php echo $url; ?>" style="padding: 3px;" class="fa fa-trash delsingleLive"></i></span> 
                                      </div>                                       
                                    </div>                    
                                  </span>                        
                                </li>

                              <?php
                              //echo '<img style ="width:250px;" src="./images/'.$parts['0'].'.'.$extension.'" /><br />';

                          }
                        }

                      }
                      //closedir($dh);

                   // }//end opendir if
                  }


                ?>

                </ul>


                </div>
                                  


            <div class="col-sm-12">
              <div class="col-sm-1">
                <div class="form-group pull-left">
                  <input class="btn btn-sm btn-primary save_pics" title="Save" type="button" id="save_pics_master" name="save_pics_master" value="Save">
                </div>
              </div>
              <div class="col-sm-8" id="">
                 <div id="upload_message">
            
                </div>
                <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
              </div>                
              <div class="col-sm-2">
                <div class="form-group">             
                  <div id="pics_insertion_msg">
                    
                  </div>
                </div>
              </div>    
              <div class="col-sm-1">
                <div class="form-group pull-right">
                  <span><i id="" title="Delete All Pictures" class="btn btn-sm btn-danger delAllLiveMasterPictures">Delete All</i></span>
                </div>  
              </div>               
            <!--</form>-->
          </div>

              </div>
            </div>
            <!-- Master Picture section Live_folder end--> 

              <!-- Master Picture section start-->     
              <div class="col-sm-12 p-b">
                  <label for="">Master Pictures:</label>

              <div id="drop-area" class="col-sm-12 b-full">
                <div class="col-sm-2">                   
                  <div  class="commoncss">
                    <h4>Drag / Upload image!</h4>
                      <div class="uploadimg">
                       <form id="frmupload" enctype="multipart/form-data">
                          <input type="file" multiple="multiple" name="image[]" id="image" style="display:none"/>
                          <input type="hidden" style="display:none;" class="form-control" id="upc~mpn" name="upc~mpn" value="<?php echo @$row['UPC'].'~'.@$row['MFG_PART_NO']; ?>">
                          <input type="hidden" style="display:none;" class="form-control" id="it_condition" name="it_condition" value="<?php echo @$row['ITEM_CONDITION']; ?>">
                          <span id="btnupload" class="fa fa-cloud-upload"></span>

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
                  // $dir = "D:/item_pictures/master_pictures/".@$row['UPC']."~".@$mpn."/".@$it_condition;
                  $master_path = $data['path_query'][0]['MASTER_PATH'];
                  $dir = $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition;
                  //var_dump(is_dir($dir));exit;
                  //$dir = "D:\wamp\www\laptopzone\assets\item_pic";
                  // Open a directory, and read its contents
                  $dir = preg_replace("/[\r\n]*/","",$dir);
                  if (is_dir($dir)){
                    if ($dh = opendir($dir)){
                      $i=1;
                      // $url_arr = [];
                      while (($file = readdir($dh)) !== false){

                        $parts = explode(".", $file);

                        if (is_array($parts) && count($parts) > 1){
                            $extension = end($parts);
                            if(!empty($extension)){
                              ?>
                                
                              <?php
                               $master_path = $data['path_query'][0]['MASTER_PATH']; 
                               $url = $master_path.@$row['UPC'].'~'.$mpn.'/'.@$it_condition.'/'.$parts['0'].'.'.$extension;
                               $url = preg_replace("/[\r\n]*/","",$url); ?>
                                <li id="<?php echo $parts['0'].'.'.$extension;?>">
                                  <span class="tg-li">
                                    <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);">
                                                          
                                        <?php
                                         // $url = '\\\\WIZMEN-PC\\item_pictures\\master_pictures\\'.@$row['UPC'].'~'.$mpn.'\\'.@$it_condition.'\\'.$parts['0'].'.'.$extension;
                                          // array_push($url_arr, $url);
                                          $master_path = $data['path_query'][0]['MASTER_PATH']; 
                                          $del_master_all =  $master_path.@$row['UPC'].'~'.$mpn;
                                          $img = file_get_contents($url);
                                          $img =base64_encode($img);

                                         echo '<img class="sort_img up-img zoom_01" id="'.$url.'" name="" src="data:image;base64,'.$img.'"/>';?>
                                          <input type="hidden" name="img_<?php echo $i ?>" value="<?php echo $url; ?>">
<!--                                          <div class="img_overlay">
                                          <span><i class="fa fa-trash delete_master"></i></span> 
                                        </div> -->
                                      <div class="text-center" style="width: 100px;">
                                        <span class="thumb_delete" style="float: left;"><i title="Move Picture Order" style="padding: 3px;" class="fa fa-arrows" aria-hidden="true"></i></span>
                                        <span class="d_spn"><i title="Delete Picture" style="padding: 3px;" class="fa fa-trash delete_specific"></i></span> 
                                      </div>                                          
                                      
                                    </div>                    
                                  </span>                        
                                </li>

                              <?php
                          }
                        }

                      }?>
                     <!--  <input type="hidden" id="master_all_url" name="master_all" value="<?php //echo $url_arr; ?>"> -->

                     <?php closedir($dh);

                    }
                  }//else{
                  //   var_dump('from else');
                  //}


                ?>

                </ul>
                </div>
                                  


                <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                  <div class="col-sm-8">
                    <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group pull-right">
                      <input id="master_reorder" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                      <span><i id="<?php if(@$del_master_all){echo $del_master_all;}?>" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all">Delete All</i></span>
                    </div>
                    
                  <!--</form>-->
                </div>
                </div>


              </div>
            </div>


 <?php break; endforeach;//end foreach?>
                 <div class="col-sm-12">
                  <div class="form-group">
                    <a title="Update Specific Pictures" class="btn btn-sm btn-primary" href="<?php echo base_url('item_pictures/c_item_pictures/item_pic_spec/'.@$data['search_query'][0]['IT_BARCODE']);?>" target="_blank">Update Specific Pictures</a>
                  </div>
                </div> 
        <?php endif;// end if?> 


              </div>
            </div>  
							

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
          <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
        </div>        
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
  /*=================================================================
  =            save and move images on click save button            =
  =================================================================*/
   $("#save_pics_master").click(function(){
    var upc = $('#upc').val();
    var part_no = $('#part_no').val();
    var it_condition = $('#it_cond').val();
    var condition_name = $('#it_cond').text();
    //alert(condition_name);return false;
    var item_id = $("#item_id").val();
    var manifest_id = $("#manifest_id").val();
    var pic_bar_code = $("#pic_bar_code").val();
    var current_bin = $("#current_bin").val();
    var remarks = $("#remarks").val();
    //alert(pic_bar_code); return false;

    var bin_id = $('#bin_id').val();
    //alert(bin_id); return false;
    if(bin_id == '' || bin_id == null){
      alert('Please Assign a Bin. Its Mandatory.'); 
      //$('#bin_id').focus();
      return false;

    }    
   // var n = $("#sortable li").length;
    //var pic_name = $('#sortable li').attr('id');
    // alert(n);
    // alert(pic);return false;
    // var pic_name = [];

    // var i = 1;
    // for(var i=1; i<=n; i++){
    //   pic_name.push($('#sortable li').attr('id'));
      
    // }    
    $(".loader").show();
    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/save_pics_master',
      data: { 
              'upc':upc,
              'part_no':part_no,
              'it_condition':it_condition,
              'condition_name':condition_name,
              'item_id': item_id,
              'manifest_id' : manifest_id,
              'bin_id':bin_id,
              'pic_bar_code':pic_bar_code,
              'current_bin':current_bin,
              'remarks':remarks         
    },
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
         
      $(".loader").hide();
        if(data == true){
          $('#pics_insertion_msg').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Master Pictures has been added.</div>').delay(3000).queue(function() { $(this).remove(); });
            setTimeout(function(){location.reload();},3000);  

            //window.location.href=window.location.href; return false;        
          // alert('Master Pictures has been added.');
      
        }else if(data == false){
          $('#pics_insertion_msg').append('<div class="alert alert-danger alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not added.</div>').delay(3000).queue(function() { $(this).remove(); });
            setTimeout(function(){location.reload();},3000);    

            //window.location.href=window.location.href; return false;      
          //alert('Error -  Pictures not added.');
         
        }
      }
      });      
  });
  
  /*=====  End of save and move images on click save button  ======*/  

/*=====================================================
=  Delete Specific Live picture from Master Pictures start     =
=====================================================*/


  $(document).on('click','.delsingleLive',function(){  
    //var master_reorder = $('#sortable').sortable('toArray');
    var pic_path = $(this).attr('id');
    //console.log(pic_path);return false;
    if(confirm('Are you sure?')){

      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/delsingleLiveMasterPicture',
        data: {'pic_path':pic_path},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
        //   var reload = function () {
        //     var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
        //     var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
        //     window.location.href =
        //         (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
        //         + "reload=" + new Date().getTime() + window.location.hash;
        // };
        // var href="javascript:reload();void 0;";
        
          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              window.location.reload();
               //window.location.href=window.location.href; return false;

 
          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Picture is Not deleted  !!</div>');
              $('#barcode_prv').val('');
              window.location.reload();
              // window.location.href=window.location.href; return false;

          }
        }
        });  
    }
   

  });

/*=====  End of Specific Live picture from Master Picture  ======*/

/*=====================================================
=  Delete All Live Master pictures from Photolab start     =
=====================================================*/

  $(".delAllLiveMasterPictures").click(function(){
    //var master_reorder = $('#sortable').sortable('toArray');
    if(confirm('Are you sure?')){

      $('.loader').show();
      $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/delAllLiveMasterPictures',
        data: {},
       success: function (data) {
        //alert(data);return false;
          $('.loader').hide();
        //   var reload = function () {
        //     var regex = new RegExp("([?;&])reload[^&;]*[;&]?");
        //     var query = window.location.href.split('#')[0].replace(regex, "$1").replace(/&$/, '');
        //     window.location.href =
        //         (window.location.href.indexOf('?') < 0 ? "?" : query + (query.slice(-1) != "?" ? "&" : ""))
        //         + "reload=" + new Date().getTime() + window.location.hash;
        // };
        // var href="javascript:reload();void 0;";
         

          if(data == true){
            $('.loader').hide();
            //reload();
              $('#upload_message').append('<div class="alert alert-success alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> All Pictures deleted Successfully !!</div>');
              
              setTimeout(function(){$('#upload_message').html("");},1000);
              //window.location.href=window.location.href; return false;
              window.location.reload();

 
          }else if(data == false){
            $('.loader').hide();
            $('#upload_message').append('<div class="alert alert-danger alert-dismissable" id="message"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong>  Pictures Not deleted  !!</div>');
              $('#barcode_prv').val('');
              setTimeout(function(){$('#upload_message').html("");},1000);
              window.location.reload();


          }
        }
        });  
    }
   

  });

/*=====  End of Delete All Live Master pictures from Photolab  ======*/
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
    url:'<?php echo base_url(); ?>item_pictures/c_item_pictures/setBinIdtoSession',
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