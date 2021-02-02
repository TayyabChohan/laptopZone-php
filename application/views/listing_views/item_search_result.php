<?php $this->load->view('template/header'); ?>
<style >
  
  #opn_cust{

    display: none;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Item
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Item</li>
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
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
            </div>
            <!-- /.box-header -->
                <div class="box-body">
                    <form action="<?php echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8">
                        <div class="col-sm-8">
                            <!-- <h4><strong>Search Item</strong></h4> -->
                            <div class="form-group">
                                <input class="form-control" type="text" name="search" id ="ser_itm" value="<?php echo htmlentities($barcode); ?>" placeholder="Search Item">
                            </div>                                     
                        </div>

                        <div class="col-sm-2" >
                        <div class="form-group">
                            <input type="checkbox" title="Search Customer Profile"  id ="chk_val" name="chk_val" value="Search"><label for="scales">&nbsp;&nbsp;Search Customer Profile</label>
                        </div>
                        </div> 

                        <div class="col-sm-2" id ="opn_cust">
                            <div class="form-group">
                                <input type="button" class="btn btn-success" id = "cut_prof" name="Submit" value="Search Customer Prfile">
                            </div>
                        </div> 
                        <div class="col-sm-2" id ="ser">
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                            </div>
                        </div>  

                                                   
                      </form>
                  </div>
                    </div>  
                        <!-- <table id="searchResults" class="table table-bordered table-striped"> -->
                    <div class="box">  
                      <?php if($data['hold_qry'][0]['HOLD_STATUS']){?>
                        <div class="alert alert-warning alert-dismissable">
                          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          <strong>Warning !</strong> Item barcode is on Hold.
                        </div>                          
                      <?php    }
                      ?>
                    <div class="box-body form-scroll">
                        <form id="upload_item" action="<?php echo base_url(); ?>listing/listing/upload_item" onsubmit="return checkboxVal();" method="post" target="_blank">

                        <?php foreach ($data['query'] as $row): ?>
                                <input type="hidden" style="display:none;" name="<?php echo $row['ITEM_ID'];?>" value="<?php echo @$row['LZ_MANIFEST_ID']; ?>">
                        <?php endforeach;?>         

                        <table id="ItemSearchResult" class="table table-bordered table-striped " >
                            <thead>
                            <tr>


                                
                        <th>ACTION</th>
                        <th>PICTURE</th>
                        <th>BARCODE</th>
                        <th>MASTER BARCODE</th>
                        <th>EBAY ID</th>
                        <!-- <th>IITEM ID</th>
                        <th>MANIFEST ID</th> -->
                        
                        <th>CONDITION</th>
                        <!-- <th>BARCODE</th> -->
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        <th>MERCHANT</th>
                        <?php 
                        $login_id = $this->session->userdata('user_id'); 
                        if($login_id == 2 || $login_id == 17 || $login_id == 21 || $login_id == 5 || $login_id == 49){?>
                        <th>COST</th>
                        <?php }?>
                        <th>LIST PRICE</th>
                        <th>LIST DATE</th>
                        <th>STATUS</th>
                        <th>LISTED BY</th>
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>SKU</th>
                        <th>MANUFACTURE</th>
                        <th>DAYS ON SHELF</th>
                        

                            </tr>
                            </thead>

                            <tbody>
                            <?php 
                           $i = 0;
                            foreach ($data['query'] as $row): ?>


                      <tr>                   
                        <td>
                          <div style="width:275px;">
                        <?php
                        $seed_link_flag = "";
                        // var_dump($data['barcode_qry']);
                        // exit;
                        $barocde_link = false;

                        if(!empty(@$data['barcode_qry'])){
                          //foreach (@$data['barcode_qry'] as $barcode) {
                            if(@$data['barcode_qry'][0]['ITEM_ID'] == @$row['ITEM_ID'] && @$data['barcode_qry'][0]['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$data['barcode_qry'][0]['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              $it_barcode = @$data['barcode_qry'][0]['BARCODE_NO'];

                              $getmaster = $this->db->query("SELECT M.BARCODE_NO FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D WHERE M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.BARCODE_PRV_NO =  $it_barcode");

                              $master_barcode = $getmaster->result_array();
                              $m_barcode = @$master_barcode[0]['BARCODE_NO'];
                              if($getmaster->num_rows() > 0){ 
                                $barocde_link = true;
                                ?>
                                <?php if(!empty(@$row['EBAY_ITEM_ID'])){ ?>
                                <!-- <div style="float:left; margin-right:8px;">
                                  <span endItem="<?php //echo @$row['EBAY_ITEM_ID']; ?>" title="End Item" class="glyphicon glyphicon-ban-circle btn btn-danger btn-sm endItem" aria-hidden="true"></span>
                                  
                                </div> -->
                                <!-- <div style="float:left; margin-right:8px;">
                                    <a href="<?php //echo base_url(); ?>dekitting_pk_us/c_to_list_pk/seed_view/<?php //echo $row['SEED_ID'].'/'.@$it_barcode."/".@$row['EBAY_ITEM_ID']; ?>" title="Revise Item" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                                    </a>
                                  </div> -->
                                <?php }?>
                                <!-- <div style="float:left; margin-right:8px;">
                                  <a href="<?php //echo base_url(); ?>dekitting_pk_us/c_to_list_pk/seed_view/<?php //echo $row['SEED_ID'].'/'.@$it_barcode; ?>" title="Create/Edit Seed" class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                                  </a>
                                </div>  -->
                          <?php }else{ 

                                  $getmaster = $this->db->query("SELECT BARCODE_PRV_NO BARCODE_NO FROM LZ_SPECIAL_LOTS WHERE BARCODE_PRV_NO =  $it_barcode");

                                  $master_barcode = $getmaster->result_array();
                                  $m_barcode = @$master_barcode[0]['BARCODE_NO'];
                                  if($getmaster->num_rows() > 0){
                                    $barocde_link = true; ?>
                                    <?php if(!empty(@$row['EBAY_ITEM_ID'])){ ?>
                                    <!-- <div style="float:left; margin-right:8px;">
                                        <a href="<?php //echo base_url(); ?>dekitting_pk_us/c_to_list_pk/seed_view/<?php //echo $row['SEED_ID'].'/'.@$it_barcode."/".@$row['EBAY_ITEM_ID']; ?>" title="Revise Item" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                                        </a>
                                      </div> -->
                                    <?php }?>
                                    <!-- <div style="float:left; margin-right:8px;">
                                      <a href="<?php //echo base_url(); ?>dekitting_pk_us/c_to_list_pk/seed_view/<?php //echo $row['SEED_ID'].'/'.@$it_barcode; ?>" title="Create/Edit Seed" class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                                      </a>
                                    </div>  -->
                              <?php }else{ 

                                      $seed_link_flag = true;
                                    
                                   }
                                
                               }

                            }// end check if
                          //} // end foreach

                        }// end main if
                      ?>   

                      <?php 
                      //if($seed_link_flag == true){
                      if($barocde_link){
                        $barocde_link = "/".@$it_barcode;;

                      }else{
                        $barocde_link = "";
                      }
                        if(!empty($row['SEED_ID'])){ ?>
                            <?php if(!empty(@$row['EBAY_ITEM_ID'])){ ?>
                            <div style="float:left; margin-right:8px;">
                              <span endItem="<?php echo @$row['EBAY_ITEM_ID']; ?>" title="End Item" class="glyphicon glyphicon-ban-circle btn btn-danger btn-sm endItem" aria-hidden="true"></span>
                                  
                            </div>
                            <div style="float:left; margin-right:8px;">
                              <span endItem="<?php echo @$row['EBAY_ITEM_ID']; ?>" title="Adjust Qty" class="glyphicon glyphicon-edit btn btn-warning btn-sm adjustQty" aria-hidden="true"></span>
                                  
                            </div>
                            <div style="float:left; margin-right:8px;">
                              <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view_merg/<?php echo $row['SEED_ID']."/".@$row['EBAY_ITEM_ID']; ?>" title="Revise Item" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                              </a>
                            </div>
                             
                          <?php }?>
                            <!-- <div style="float:left; margin-right:8px;">
                              <a href="<?php //echo base_url(); ?>tolist/c_tolist/seed_view/<?php //echo $row['SEED_ID'].'/'.@$it_barcode;?>" title="Create/Edit Seed" class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                              </a>
                            </div>  -->  

                            <div style="float:left; margin-right:8px;">
                              <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view_merg/<?php echo $row['SEED_ID'].@$barocde_link; ?>" title="Create/Edit Seed" class="btn btn-warning btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span>
                              </a>
                            </div>                                                    
                        <?php }else{
                                echo 'Not Tested';
                              } 
                      //}
                      ?>

                          <?php if(!empty($row['SINGLE_ENTRY_ID'])){ ?>
                              <div style="float:left;margin-right:8px;">
                                <a style="margin-right: 3px;" href="<?php echo base_url(); ?>single_entry/c_single_entry/updateRecordView/<?php echo $row['SINGLE_ENTRY_ID'] ?>" title="Update Single Entry" class="btn btn-info btn-sm" target="_blank"><span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                              </div>                           
                          <?php } ?>
                          <div style="float:left;margin-right:8px;">
                           <a style="margin-right: 3px;" href="<?php echo base_url(); ?>manifest_loading/c_manf_load/manf_detail/<?php echo $row['LZ_MANIFEST_ID']; ?>" title="Manifest Details" class="btn btn-danger btn-sm" target="_blank"><i class="fa fa-money "></i>
                           </a>
                         </div>
                            <?php 
//var_dump(@$data['barcode_qry']);exit;
                        if(!empty(@$data['barcode_qry']) AND empty(@$row['BARCODE_NO'])){
                          foreach (@$data['barcode_qry'] as $barcode) {
                            if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              $it_barcode = @$barcode['BARCODE_NO'];
                              if(!empty(@$it_barcode)){
  ?>
                               <div style="float:left;margin-right:8px;">
                                 <a style="margin-right: 3px;" href="<?php echo base_url(); ?>listing/c_itemHistory/search_history/<?php echo $it_barcode; ?>" title="Item History" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-history"></i>
                                 </a>
                               </div> 
                              <?php
                              break;
                              }
                            }// end check if
                          } // end foreach
                        }else{// end main if
                          ?>
                          <div style="float:left;margin-right:8px;">
                                 <a style="margin-right: 3px;" href="<?php echo base_url(); ?>listing/c_itemHistory/search_history/<?php echo @$row['BARCODE_NO']; ?>" title="Item History" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-history"></i>
                                 </a>
                               </div> 
                      <?php
                        }
                        $sticker_barcode =  $data['query'][0]['BARCODE_NO'];
                          ?>
                            <div style="float:left;margin-right:8px;">
                              <a style="margin-right: 3px;" href="<?php echo base_url(); ?>catalogueToCash/c_dekit_sticker/dekitPrintSingle/<?php echo @$row['LAPTOP_ITEM_CODE'].'/'.@$row['LZ_MANIFEST_ID'].'/'. @$sticker_barcode; ?>" title="Barcode Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>
                            </div>
                            <div style="float:left;margin-right:8px;">
                              <a style="margin-right: 3px;" href="<?php echo base_url(); ?>single_entry/c_single_entry/printAllStickers/<?php echo @$row['LZ_MANIFEST_ID']; ?>" title="Print All Sticker" class="btn btn-warning btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>
                              <a style="margin-right: 3px;" href="<?php echo react_url(); ?><?= @$row['LZ_MANIFEST_ID']; ?>" title="React Print All Sticker" class="btn btn-success btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>
                            </div>
                            <div style="float:left;margin-right:8px;">
                                <a style=" margin-right: 3px;" href="<?= react_url(); ?>barcode/<?= @$row['LAPTOP_ITEM_CODE'].'/'.@$row['LZ_MANIFEST_ID'] .'/'.$sticker_barcode; ?>" title="React Print Sticker" class="btn btn-success btn-sm" target="_blank">
                                  <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                </a>
                            </div>


                        <?php if(!empty($row['LIST_ID'])){ ?>    
                            <div style="float:left;margin-right:8px;">
                              <a style="margin-right: 3px;" href="<?php echo base_url(); ?>listing/listing/print_label/<?php echo @$row['LIST_ID']; ?>" title="eBay Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>
                            </div>
                        <?php } ?>                                                              
                          </div>
                          
                        <?php if($data['hold_qry'][0]['HOLD_STATUS']){ 
                          
                          ?>    
                            <div style="float:left;margin-right:8px;">
                              <span title= "Un-Hold Barcode" class="glyphicon glyphicon-ban-circle btn btn-success btn-sm unHoldBarcode" id="<?php echo $data['hold_qry'][0]['BARCODE_NO']; ?>" aria-hidden="true"></span>
                            </div>
                        <?php }else{ ?>
                            <div style="float:left;margin-right:8px;">
                              <span title= "Hold Barcode" class="glyphicon glyphicon-ok btn btn-danger btn-sm holdBarcode" id="<?php echo $data['hold_qry'][0]['BARCODE_NO']; ?>" aria-hidden="true"></span>
                            </div>
                        <?php }?>
                        </td>
                        <td>
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
                            //     }
                            //   }
                            $mpn = str_replace('/', '_', trim(@$row['MFG_PART_NO']));
                            //var_dump($mpn);
                            $master_path = $data['path_query'][0]['MASTER_PATH'];

                            $m_dir =  $master_path.trim(@$row['UPC'])."~".@$mpn."/".@$it_condition."/";

                            $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                            $s_dir = $specific_path.trim(@$row['UPC'])."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/";

                            $d_dir = @$data['path_2'][0]['MASTER_PATH'] ;

                            //var_dump($data['barcode_qry']);

                        if(!empty(@$data['barcode_qry'])){
                          foreach (@$data['barcode_qry'] as $barcode) {
                            if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              $barcodes = @$barcode['BARCODE_NO'];
                              // if(!empty(@$barcode['LZ_BARCODE_ID'])){
                              //   $barcode = @$it_barcode;
                              // }//end if else
                            }// end check if
                          } // end foreach
                        }// end main if
                        //var_dump($barcode);
                            // var_dump($child_barcode);exit;
                        //var_dump($barcode);
                        // $barcode = @$barcode['BARCODE_NO'];
                        
                            $d_dir = @$d_dir.@$barcodes.'/thumb/';
                       //var_dump($d_dir);
                            


                            if(is_dir(@$d_dir)){
                                $iterator = new \FilesystemIterator(@$d_dir);
                                  if(@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                            }elseif(is_dir(@$s_dir)){
                                $iterator = new \FilesystemIterator(@$s_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }
                            }elseif(is_dir(@$m_dir)){
                                $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = false;
                                  }                              
                            }else{
                                $m_flag = false;
                            }

                          if($m_flag){
                             if (is_dir($d_dir)){
                              $images = scandir($d_dir);
                              // Image selection and display:
                              //display first image
                              if (count($images) > 0){ // make sure at least one image exists
                                  $url = @$images[2]; // first image
                                  $img = file_get_contents(@$d_dir.@$url);
                                  $img =base64_encode($img); ?>
                                  <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                                  <?php

                                  echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                                  ?>
                                  </div>
                                  <?php
                              }
                            }elseif (is_dir($m_dir)){
                              $images = scandir($m_dir);
                              // Image selection and display:
                              //display first image
                              if (count($images) > 0){ // make sure at least one image exists
                                  $url = @$images[2]; // first image
                                  $img = file_get_contents(@$m_dir.@$url);
                                  $img =base64_encode($img); ?>
                                  <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                                  <?php

                                  echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                                  ?>
                                  </div>
                                  <?php
                              }
                            }else{
                               //$images = glob("$s_dir*.jpg");
                              //sort($images);
                              $images = scandir($s_dir);
                              // Image selection and display:
                              //display first image
                              if (count($images) > 0) { // make sure at least one image exists
                                  $url = @$images[2]; // first image
                                  $img = file_get_contents(@$s_dir.@$url);
                                  $img =base64_encode($img); ?>
                                  <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                                  <?php

                                  echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                                  ?>
                                  </div>
                                  <?php
                                  //echo "<img src='$img' height='150' width='150' /> ";
                              }
                            } 
                          }else{//flag if else
                            echo "NOT FOUND"; 
                          }
                          ?>                        
                        </td>
                        <td>
                        <div style="width:150px;">
                        <?php 
//var_dump(@$data['barcode_qry']);exit;

                        if(!empty(@$data['barcode_qry']) AND empty(@$row['BARCODE_NO'])){
                          foreach (@$data['barcode_qry'] as $barcode) {
                            if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              $it_barcode = @$barcode['BARCODE_NO'];
                              if(!empty(@$barcode['LZ_BARCODE_ID'])){
  ?>
                                <a title="View Item Test" href="<?php echo base_url();?>tester/c_tester_screen/view_test/<?php echo $it_barcode ;?>/test-view" class="btn btn-success btn-xs" target="_blank"><i style="font-size: 13px;margin-top: 4px; cursor: pointer;"><?php echo $it_barcode." - "; ?></i>
                                  </a>
                              <?php
                              }else{ ?>
                                <a title="Add Item Test" href="<?php echo base_url();?>tester/c_tester_screen/search_item/<?php echo $it_barcode ;?>" class="btn btn-primary btn-xs" target="_blank"><i style="font-size: 13px;margin-top: 4px; cursor: pointer;"><?php echo $it_barcode." - "; ?></i>
                                  </a>
                                  <?php
                                //echo $it_barcode." - ";
                              }//end if else
                            }// end check if
                          } // end foreach
                        }else{// end main if
                          echo @$row['BARCODE_NO'];
                        }
                          ?>
                      </div>
                      </td>

                      <td>
                        <?php
                        if(!empty(@$data['barcode_qry'])){
                          //foreach (@$data['barcode_qry'] as $barcode) {
                            if(@$data['barcode_qry'][0]['ITEM_ID'] == @$row['ITEM_ID'] && @$data['barcode_qry'][0]['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$data['barcode_qry'][0]['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                              $it_barcode = @$data['barcode_qry'][0]['BARCODE_NO'];

                              $getmaster = $this->db->query("SELECT M.BARCODE_NO FROM LZ_DEKIT_US_MT M, LZ_DEKIT_US_DT D WHERE M.LZ_DEKIT_US_MT_ID = D.LZ_DEKIT_US_MT_ID AND D.BARCODE_PRV_NO =  $it_barcode");

                              $master_barcode = $getmaster->result_array();
                              $m_barcode = @$master_barcode[0]['BARCODE_NO'];
                              if($getmaster->num_rows() > 0){ ?>
                                <div style="color:red;"> <?php echo @$m_barcode; ?></div>
                          <?php }else{
                                    echo "";
                                }

                            }// end check if
                          //} // end foreach
                        }// end main if
                      ?>                        
                      </td>
                      <td><?php echo @$row['EBAY_ITEM_ID'];?></td>                
                      <td>
                      <?php  echo @$row['COND_NAME']; ?></td>
                      <!-- <td><?php //echo @$row['IT_BARCODE'];?></td>  -->               
                      <td>
                      <div style="width:200px;">
                      <?php echo @$row['ITEM_MT_DESC'];?>
                      </div></td>
                      <td><?php echo @$row['QUANTITY']; ?></td>
                      <td><?php echo @$row['BUISNESS_NAME']; ?></td>
                      <?php 
                      $login_id = $this->session->userdata('user_id'); 
                      if($login_id == 2 || $login_id == 17 || $login_id == 21 || $login_id == 5 || $login_id == 49){?>


                      <td>
                      <?php 
                      $cost_us = @$row['COST_PRICE'];
                      echo '$ '.number_format((float)@$cost_us,2,'.',','); 
                      ?>
                        
                      </td>
                      <?php }?>
                      
                      <td>
                      <?php if(!empty(@$row['EBAY_ITEM_ID'])){
                        
                        $list_price = @$row['LIST_PRICE'];
                        echo '$ '.number_format((float)@$list_price,2,'.',',');
                      }                          
                      ?>  
                      </td>
                     <td>
                      <?php
                       echo @$row['LIST_DATE'];
                      ?>
                        
                      </td>
                      <td>
                      <?php
                      if(!empty(@$row['EBAY_ITEM_ID'])){
                        echo @$row['STATUS']; 
                      }  
                      ?>
                          
                      </td>
                      <td>
                      <?php
                      if(!empty(@$row['EBAY_ITEM_ID'])){ 
                      //var_dump(@$data['user_list']);
                        foreach(@$data['user_list'] as $user){
                          $u_name = ucfirst(@$user['USER_NAME']);
                          $employee_id = @$user['EMPLOYEE_ID'];
                          if($employee_id == @$row['LISTER_ID']){
                           echo @$u_name;
                          }
                        }
                      }
                      ?>
                      </td>
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php echo trim(@$row['UPC']);?></td>
                      <td><?php echo trim(@$row['MFG_PART_NO']);?></td>
                      <td><?php echo @$row['SKU_NO'];?></td>                  
                      <td><?php echo @$row['MANUFACTURER'];?></td>                  
    <!--                   <td>
                        <?php 
                            // $cost_us = @$row['COST_US'];
                            // echo '$ '.number_format((float)@$cost_us,2,'.',',');
                        ?>
                      </td> -->
    <!--                   <td>
                      <?php 
                        // $line_total = @$cost_us * @$row['NOT_LIST_QTY'];
                        // echo '$ '.number_format((float)@$line_total,2,'.',',');
                      ?>    
                      </td> -->
                      <!-- <td><?php //echo @$row['LOADING_DATE'];?></td> -->
                      <td>
                      <?php 
                           
                        $current_timestamp = date('m/d/Y');
                        $purchase_date = @$row['LOADING_DATE'];
                        
                        $date1=date_create($current_timestamp);
                        $date2=date_create($purchase_date);
                        $diff=date_diff($date1,$date2);
                        $date_rslt = $diff->format("%R%a days");
                        echo abs($date_rslt)." Days"; 

                      ?>
                      </td>
                        
                    </tr>
                    <?php
                     $i++;

                   // endif; 
                             
                            endforeach;
                            ?>
                                     
                            </tbody>
                        </table><br>


                        <!--<div class="col-sm-12">

                          <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                        <div id="errorMsg" class="text-danger">
                        <?php 
                            // To disable invalid argument supplied for foreach()
                            // if (is_array(@$errorMsg) || is_object(@$errorMsg))
                            // {
                            //     foreach (@$errorMsg as $msg) {
                            //         # code...
                            //         echo @$msg;
                            //     } 
                            // } ?>
                        </div>
                        <div id="successMsg" class="text-success">
                        <?php 
                            // To disable invalid argument supplied for foreach()
                            // if (is_array(@$successMsg) || is_object(@$successMsg))
                            // {
                            //     foreach (@$successMsg as $msg) {
                            //         # code...
                            //         echo @$msg;
                            //     } 
                            // } ?>
                        </div>
                        </div>                        
                
                    </form>-->
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
<div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>


<!--/*=============================================
=            Section comment block            =
=============================================*/-->
<!-- Modal -->
<div id="UpdateKeyword" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">End Item Remarks</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
              <div class="box-body ">
                <div class="col-sm-12 ">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Feed Name" style = "color: black!important;">eBay Id:</label>
                      <input name="mod_ebay_id" type="text" id="mod_ebay_id" class="mod_ebay_id form-control " readonly>
                     
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-group">
                      <label for="remarks" style = "color: black!important;">Remarks :</label>
                      <input name="mod_remarks" type="text" id="mod_remarks" class="mod_remarks form-control ">
                    </div>
                  </div> 
                  <div class="col-sm-1 pull-right p-t-24">
                    <div class="form-group">
                      <input type="button" class="btn btn-primary btn-sm" id="ModCancel" name="ModCancel" value="Cancel">                      
                    </div>

                  </div> 
                   <div class="col-sm-1 pull-right p-t-24">
                    <div class="form-group">
                      <input type="button" class="btn btn-danger btn-sm" id="ModendItem" name="ModendItem" value="End">                      
                    </div>

                  </div>
                  
              </div> <!-- box body div close-->

            </div> 
          </div><!--box body close -->
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->


<!-- /*=====  End of Section comment block  ======*/ -->

<!--/*=============================================
=            adjust qty modal            =
=============================================*/-->
<!-- Modal -->
<div id="modAdjQty" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">Adjust Qty</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
              <div class="box-body ">
                <div class="col-sm-12 ">
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Feed Name" style = "color: black!important;">eBay Id:</label>
                      <input name="adj_ebay_id" type="text" id="adj_ebay_id" class="adj_ebay_id form-control " readonly>
                     
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <label for="Feed Name" style = "color: black!important;">Qty:</label>
                      <input name="adj_qty" type="number" min="1" id="adj_qty" class="adj_qty form-control">
                      <input name="adj_cur_qty" type="hidden" min="1" id="adj_cur_qty" class="adj_cur_qty form-control">
                     
                    </div>
                  </div>

                 
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="remarks" style = "color: black!important;">Remarks :</label>
                      <input name="adj_remarks" type="text" id="adj_remarks" class="adj_remarks form-control ">
                    </div>
                  </div>
                  <div class="col-sm-3 p-t-24">
                      <label for="remarks" style = "color: black!important;">Barcode :</label>
                      <input name="adj_barcode" type="radio" id="adj_barcode" value="release" checked="checked">&nbsp;&nbsp;<span style = "color: black!important;">Relaese &nbsp;&nbsp;&nbsp;&nbsp;</span>
                      <input name="adj_barcode" type="radio" id="adj_barcode" value="discard">&nbsp;&nbsp;<span style = "color: black!important;">Discard </span>
                      
                  </div> 
                  <div class="col-sm-1 pull-right p-t-24">
                    <div class="form-group">
                      <input type="button" class="btn btn-primary btn-sm" id="adj_ModCancel" name="adj_ModCancel" value="Cancel">                      
                    </div>

                  </div> 
                   <div class="col-sm-1 pull-right p-t-24">
                    <div class="form-group">
                      <input type="button" class="btn btn-success btn-sm" id="updateQty" name="updateQty" value="Update">                      
                    </div>

                  </div>
                  
              </div> <!-- box body div close-->

            </div> 
          </div><!--box body close -->
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end -->


<!-- /*=====  End of adjust qty modal  ======*/ -->
 <?php $this->load->view('template/footer'); ?>
 <script>

  $(document).ready(function(){
    /*======================================================
    =            HOLD BARCODE function            =
    ======================================================*/
      $("body").on('click','.holdBarcode', function() {
          var barcode_no = this.id;
          //console.log(barcode_no);
          //return false;
          
          $(".loader").show();
          $.ajax({
              url: '<?php echo base_url(); ?>listing/listing_search/holdBarcode',
              type: 'post',
              dataType: 'json',
               data : {'barcode_no':barcode_no},
              success: function(data){
            if (data == 1){
                    
                  $(".loader").hide();
                 alert('Barcode is Marked As Hold.');
              }else if (data == 2) {
                $(".loader").hide();
                alert('Error!. This Barcode is Not Available.');
              }else{
                $(".loader").hide();
                 alert('some error occured.');
              }
              },
              error: function(data){
                $(".loader").hide();
                 alert('some error occured.');
              }
          });    
       });
    /*=====  End of HOLD BARCODE function  ======*/

    /*======================================================
    =            HOLD BARCODE function            =
    ======================================================*/
      $("body").on('click','.unHoldBarcode', function() {
          var barcode_no = this.id;
          //console.log(barcode_no);
          //return false;
          
          $(".loader").show();
          $.ajax({
              url: '<?php echo base_url(); ?>listing/listing_search/unHoldBarcode',
              type: 'post',
              dataType: 'json',
               data : {'barcode_no':barcode_no},
              success: function(data){
            if (data == 0){
                    
                  $(".loader").hide();
                 alert('Barcode is Marked As Un-Hold.');
                  }
              },
              error: function(data){
                $(".loader").hide();
                 alert('some error occured.');
              }
          });    
       });
    /*=====  End of HOLD BARCODE function  ======*/
    /*=====================================================
    =            update keyword modal function            =
    =====================================================*/
    $(document).on('click','.endItem',function(){
      var ebay_id = $(this).attr('endItem');
      $('#UpdateKeyword').modal('show');
      $('#mod_ebay_id').val("");
      $('#mod_remarks').val("");
      $('#mod_ebay_id').val(ebay_id);
    });

    /*=====  End of update keyword modal function  ======*/
    $(document).on('click','.adjustQty',function(){
      var ebay_id = $(this).attr('endItem');
      console.log(ebay_id);
      $('#modAdjQty').modal('show');
      $('#adj_ebay_id').val("");
      $('#adj_qty').val("");
      $('#adj_remarks').val("");
      //$('#adj_barcode').val("");
      $('#adj_cur_qty').val("");
      $('#adj_ebay_id').val(ebay_id);

      $(".loader").show();
        $.ajax({
            url: '<?php echo base_url(); ?>tolist/c_tolist/getItemQty',
            type: 'post',
            dataType: 'json',
             data : {'ebay_id':ebay_id},
            success: function(data){
              if ($.isNumeric(data)){
                      
                $(".loader").hide();
                if(data === 0){
                  alert("Warning! Item Qty is 0 on ebay");
                  $('#modAdjQty').modal('hide');
                  return false;
                }
                if(data === 1){
                  alert("Warning! Can't process Single Qty items");
                  $('#modAdjQty').modal('hide');
                  return false;
                }
                $('#adj_qty').val(data);
                $('#adj_cur_qty').val(data);

              }else{
                $(".loader").hide();
                alert('Error!'+data);
              }
            },
            error: function(data){
              console.log(data);
              $(".loader").hide();
               alert('some error occured.');
            }
        });
    });
    /*=====================================================
    =            cancel button function            =
    =====================================================*/
    $(document).on('click','#adj_ModCancel',function(){
      $('#adj_cur_qty').val("");
      $('#adj_ebay_id').val("");
      $('#adj_qty').val("");
      $('#adj_remarks').val("");
      $('#adj_barcode').val("");
      $('#modAdjQty').modal('hide');
    });

    /*=====  End of cancel button function  ======*/
    /*=====================================================
    =            cancel button function            =
    =====================================================*/
    $(document).on('click','#ModCancel',function(){
      $('#mod_ebay_id').val("");
      $('#mod_remarks').val("");
      $('#UpdateKeyword').modal('hide');
    });

    /*=====  End of cancel button function  ======*/
    /*======================================================
    =            updateQty function            =
    ======================================================*/
      $("body").on('click','#updateQty', function() {
        if(confirm('Are you sure?')){
          var ebay_id = $('#adj_ebay_id').val();
          var adj_qty = $('#adj_qty').val();
          var adj_cur_qty = $('#adj_cur_qty').val();
          var adj_remarks = $('#adj_remarks').val();
          var adj_barcode = $('input[name=adj_barcode]:checked').val();
          //console.log(adj_remarks,adj_barcode);
          //return false;
          if(adj_qty.trim().length === 0){
            alert("Please enter Qty");
            $('#adj_qty').focus();
            return false;
          }

          if(adj_qty > adj_cur_qty){
            alert("Qty Connot be Greater than "+adj_cur_qty);
            $('#adj_qty').focus();
            return false;
          }

          if(adj_qty === adj_cur_qty){
            alert("Qty is Unchanged. Please Less the Qty First");
            $('#adj_qty').focus();
            return false;
          }
          $(".loader").show();
           console.log(ebay_id);
           //return false;
          
          $(".loader").show();
          $.ajax({
              url: '<?php echo base_url(); ?>tolist/c_tolist/updateItemQty',
              type: 'post',
              dataType: 'json',
               data : {'ebay_id':ebay_id,'remarks':adj_remarks,'adj_barcode':adj_barcode,'adj_qty':adj_qty},
              success: function(data){
                if (data == -1){
                 $(".loader").hide();
                 alert('Qty Updated Successfully');
                 $('#modAdjQty').modal('hide');
                }else{
                    $(".loader").hide();
                    alert(data);
                }
              },
              error: function(data){
                $(".loader").hide();
                 alert('Erorr! '+data);
              }
          });  
          }else{// are you sure if else
              return false;
          }  
       });
    /*=====  End of updateQty function  ======*/

    /*======================================================
    =            end item function            =
    ======================================================*/
      $("body").on('click','#ModendItem', function() {
        if(confirm('Are you sure?')){
          var ebay_id = $('#mod_ebay_id').val();
          var remarks = $('#mod_remarks').val();
          if(remarks.trim().length === 0){
            
            alert("Please enter Remarks");
            $('#mod_remarks').focus();
            return false;
          }
          $(".loader").show();
           console.log(ebay_id);
           //return false;
          
          $(".loader").show();
          $.ajax({
              url: '<?php echo base_url(); ?>tolist/c_tolist/endItem',
              type: 'post',
              dataType: 'json',
               data : {'ebay_id':ebay_id,'remarks':remarks},
              success: function(data){
            if (data == 1){
                    
                  $(".loader").hide();
                 alert('Item Ended Successfully');
                 $('#UpdateKeyword').modal('hide');
                  }else{
                    $(".loader").hide();
                    alert('some error occured.');
                  }
              },
              error: function(data){
                $(".loader").hide();
                 alert('some error occured.');
              }
          });  
          }else{// are you sure if else
              return false;
          }  
       });
    /*=====  End of end item function  ======*/

  });// ready function close
$('#chk_val').change(function() {

  if ($("input[name='chk_val']").is(':checked')) {
  $('#opn_cust').show();
  $('#ser').hide();
    }else{
    $('#opn_cust').hide();
    $('#ser').show();     

    }

    });

$(document).on('click','#cut_prof',function(){ 

  var ser = $('#ser_itm').val();

  sticker_url = "<?php echo base_url(); ?>CustomerProfile/c_CustomerProfile/CustomerProfile/"+ser;

      var sticker_url = window.open(sticker_url, '_blank');
      sticker_url.location;

  // window.location.href = '<?php //echo base_url(); ?>CustomerProfile/c_CustomerProfile/CustomerProfile';

  // //CustomerProfile/c_CustomerProfile/CustomerProfile
  // var ser = $('#ser_itm').val();
  // console.log(ser);

    });


 // opn_cust
 </script>