<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        De-Kited Item Listing
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">De-Kited Item Listing</li>
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
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
            <?php //var_dump(@$data['listed_barcode']);exit;?>
            <div class="box-body">
              <form action="<?php echo base_url(); ?>catalogueToCash/c_listing/lister_view" method="post" accept-charset="utf-8">
                <div class="col-sm-7">
                    <div class="form-group">
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="purchase_no" id="purchase_no" value="<?php //if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>" placeholder="Enter Purchase Ref No / Manifest Id">
                    </div>                                     
                </div> 
                  <div class="col-sm-2">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/pic_view" target="_blank">Pic Approval</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;   |&nbsp;&nbsp;&nbsp;&nbsp;  
                    <a style="text-decoration: underline;" href="<?php echo base_url();?>tolist/c_tolist/listedItemsAudit" target="_blank">Listed Items Audit</a>    
                    </div>
                  </div>                                                    
              </form>
            </div>
        </div>  
        <div class="box">      
        <div class="box-body form-scroll">      
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
            <?php if(@$activeTab == 'Listed'){ ?>
              <li><a href="#tab_1" data-toggle="tab">Not Listed</a></li>
              <li class="active"><a href="#tab_2" data-toggle="tab">Listed</a></li>
              <!-- <li ><a href="#tab_3" data-toggle="tab">Pic Approval</a></li>
              <li><a href="#tab_4" data-toggle="tab">Without Pictures</a></li> -->
              <?php
              }elseif(@$activeTab == 'Not Listed'){?>
              <li class="active"><a href="#tab_1" data-toggle="tab">Not Listed</a></li>
              <li ><a href="#tab_2" data-toggle="tab">Listed</a></li>
              <!-- <li ><a href="#tab_3" data-toggle="tab">Pic Approval</a></li>
              <li><a href="#tab_4" data-toggle="tab">Without Pictures</a></li> -->
              <?php 
            }else{?>

              <li class="active"><a href="#tab_1" data-toggle="tab">Not Listed</a></li>
              <li ><a href="#tab_2" data-toggle="tab">Listed</a></li>
              <!-- <li ><a href="#tab_3" data-toggle="tab">Pic Approval</a></li>
              <li><a href="#tab_4" data-toggle="tab">Without Pictures</a></li> -->            
          <?php }

                ?>
              


            </ul>
            <div class="tab-content">
              <div class="tab-pane <?php if(@$activeTab == 'Not Listed'){echo 'active';}?>" id="tab_1">

               <table id="catToCash_notListed" class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                        <th>ACTION</th>
                        <th>OTHER NOTES</th>
                        <th>PICTURE</th>
                        <th style="width: 120px;">BARCODE</th>
                        <th>CONDITION</th>
                        <!-- <th>BARCODE</th> -->
                        <th style="width: 170px;">TITLE</th>
                      
                        <th>QTY</th>

                        
                        <!-- <th>HOLD QTY</th> -->
                        
                        
                        <th>MPN</th>
                        <th>MANUFACTURE</th>
                        <!-- <th>COST</th>
                        <th>LINE TOTAL</th>   -->                         
                        <!-- <th>PURCHASE DATE</th> -->
                        <th>SHIPPING SERVICE</th>
                        <th>DAYS</th>
                        
                        <!-- <th>List Price</th>  -->
                    </tr>
                    </thead>

                    <tbody>
                      
                    <?php 
                    $i =1;
                    foreach (@$data['listing_qry'] as $row):

                    $it_condition  = @$row['ITEM_CONDITION'];
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
                        }
                      }
                        $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        $master_path = $data['path_query'][0]['MASTER_PATH'];
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/thumb/";
                        $m_dir = preg_replace("/[\r\n]*/","",$m_dir);

                        $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/thumb/";
                        $s_dir = preg_replace("/[\r\n]*/","",$s_dir);
                            //var_dump($m_dir);exit;
                        if(is_dir(@$m_dir)){
                                    $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    $m_flag = true;
                                    //$m_flag = false;
                                  }
                              }elseif(is_dir(@$s_dir)){
                                $iterator = new \FilesystemIterator(@$s_dir);
                                    if (@$iterator->valid()){    
                                      $m_flag = true;
                                  }else{
                                    //$m_flag = false;
                                    $m_flag = true;
                                  }
                              }else{
                                //$m_flag = false;
                                $m_flag = true;
                              }
                          if($m_flag):
                        ?>                    
                  
                    <tr>
                      <td>
                          <div style="width:140px;">
                            <div style="float:left;margin-right:8px;">
                            <form action="<?php echo base_url(); ?>tolist/c_tolist/list_item" method="post" accept-charset="utf-8">
                              
                              <input type="hidden" name="seed_id" class="seed_id" id="seed_id_<?php echo $i; ?>" value='<?php echo @$row['SEED_ID']; ?>'/>
                            <input type="submit" name="item_list" title="List to eBay" onclick="return confirm('Are you sure?');" class="btn btn-success btn-sm" value="List">

                             </form>
                             </div>
                            <div style="float:left;margin-right:8px;">
                             <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>
                             <?php                           
                             $single_barcodeNo = $this->db->query("SELECT MT.BARCODE_NO BCD, MT.ITEM_ID, MT.LZ_MANIFEST_ID, MT.CONDITION_ID, MT.ITEM_ADJ_DET_ID_FOR_OUT FROM LZ_BARCODE_MT MT,LZ_MANIFEST_MT M WHERE M.LZ_MANIFEST_ID = MT.LZ_MANIFEST_ID AND M.MANIFEST_TYPE = 1 AND MT.CONDITION_ID IS NOT NULL AND MT.ITEM_ID = ".$row['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$row['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$row['ITEM_CONDITION']." AND MT.HOLD_STATUS = 0 AND MT.EBAY_ITEM_ID IS NULL order by MT.BARCODE_NO desc ");

                            $barcode_no = $single_barcodeNo->result_array();
                            $bar_code = $barcode_no[0]['BCD'];
                            //var_dump($bar_code);exit;
                             ?>
                            <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>catalogueToCash/c_dekit_sticker/dekitPrintSingle/<?php echo $row['ITEM_CODE']; ?>/<?php echo $row['LZ_MANIFEST_ID']; ?>/<?php echo $bar_code; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank">
                                <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                              </a>                              
                            </div>                         
                          </div>
                          <?php //echo @$row['SEED_ID'];?>
                      </td>
                      <td>
                         <div style="width:130px;">
                            <?php 
                            $user_id=@$row['ENTERED_BY'];
                              foreach (@$lister as $user)
                                {
                                  if($user['EMPLOYEE_ID']==@$user_id)
                                  { 
                                    if ($user['EMPLOYEE_ID']==5) {
                                       echo "<b style='color:red;'>".@$user['USER_NAME'].": </b>";
                                    }else {
                                      echo "<b>".@$user['USER_NAME'].": </b>";
                                    }
                                   
                                  }
                                } echo @$row['OTHER_NOTES']; 
                            ?>
                        </div>                        
                      </td>
                      <td> 
                    <?php
                      if (is_dir($m_dir)){
                    // $images = glob("$m_dir*.jpg");
                    // sort($images);
                    $images = scandir($m_dir);
                    // Image selection and display:
                    //display first image
                    if (count($images) > 0) { // make sure at least one image exists
                        $url = $images[2]; // first image
                        $img = file_get_contents($m_dir.$url);
                        $img =base64_encode($img); ?>
                        <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                        <?php

                        echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                        ?>
                        </div>
                        <?php
                        //echo "<img src='$img' height='150' width='150' /> ";
                    }else{
                      echo 'Not Found';
                    }
                  }else{
                     //$images = glob("$s_dir*.jpg");
                    //sort($images);
                    if(is_dir($s_dir)){
                    $images = scandir($s_dir);
                    // Image selection and display:
                    //display first image
                      if (count($images) > 0) { // make sure at least one image exists
                          $url = $images[2]; // first image
                          $img = file_get_contents($s_dir.$url);
                          $img =base64_encode($img); ?>
                          <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                          <?php

                          echo '<img class="sort_img up-img" id="" name="" src="data:image;base64,'.$img.'"/>';
                          ?>
                          </div>
                          <?php
                          //echo "<img src='$img' height='150' width='150' /> ";
                      }else{
                        echo 'Not Found';
                      }
                    }else{
                       echo 'Not Found';
                    }//is_dir($s_dir) close
                  }//else close


                    ?>               

                      </td>
                      <td>
                        <div style="width:150px;">
                        <?php

                          $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID, MT.CONDITION_ID, MT.ITEM_ADJ_DET_ID_FOR_OUT FROM LZ_BARCODE_MT MT,LZ_MANIFEST_MT M WHERE M.LZ_MANIFEST_ID = MT.LZ_MANIFEST_ID AND M.MANIFEST_TYPE = 1 AND MT.CONDITION_ID IS NOT NULL AND MT.ITEM_ID = ".$row['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$row['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$row['ITEM_CONDITION']." AND MT.HOLD_STATUS = 0 AND MT.EBAY_ITEM_ID IS NULL order by MT.BARCODE_NO desc ");

                            $barcode_qry = $barcode_qry->result_array();
                            $BARCODE_NO = $barcode_qry[0]['BARCODE_NO'];
                            // var_dump($BARCODE_NO);
                            // exit;
                            $master_barcode = $this->db->query("SELECT  DD.ITEM_ADJUSTMENT_ID FROM LZ_BARCODE_MT B, LZ_MANIFEST_DET M, LZ_BD_ESTIMATE_DET EST_MT , LZ_BD_ESTIMATE_MT MT, ITEM_ADJUSTMENT_DET DD WHERE B.LZ_MANIFEST_ID = M.LZ_MANIFEST_ID AND   M.EST_DET_ID =EST_MT.LZ_ESTIMATE_DET_ID AND   MT.LZ_BD_ESTIMATE_ID = EST_MT.LZ_BD_ESTIMATE_ID AND   MT.ITEM_ADJ_MT_ID = DD.ITEM_ADJUSTMENT_ID AND   DD.PRIMARY_QTY < 0 AND B.BARCODE_NO=$BARCODE_NO ")->result_array();
                              $adjustment_id = @$master_barcode[0]['ITEM_ADJUSTMENT_ID'];
                            //   var_dump($adjustment_id);
                            // exit;
                            if(!empty($adjustment_id)){

                      $get_barcode = $this->db->query("SELECT t.BARCODE_NO FROM LZ_BARCODE_MT T WHERE T.ITEM_ADJ_DET_ID_FOR_OUT =$adjustment_id")->result_array();
                      $m_barcode = $get_barcode[0]['BARCODE_NO'];
                            ?>
                            <div> <p  style="color:red;"> Master Barcode -- <?php echo $m_barcode; ?></p></div>
                           <!--  $dash = " Master Barcode - ";
                            echo $dash;
                            echo $m_barcode; 
                            echo '-';
                            // var_dump($m_barcode);
                            // exit;  -->
                          <?php }

                             
                            $t_barcodes = count($barcode_qry);
                            $j = $t_barcodes - 1;

                            foreach($barcode_qry as $barcode){

                              //$adjustment_id = $barcode_qry[0]['ITEM_ADJ_DET_ID_FOR_OUT'];
                              if (!empty($barcode['BARCODE_NO'])) {
                                $dashh = " - ";
                                //echo $barcode['ITEM_ADJ_DET_ID_FOR_OUT'];
                                echo $barcode['BARCODE_NO'];
                                if ($j > 0 ) {
                                  echo $dashh;
                                }
                              }
                              
                            $j--;
                            }
                        ?>
                        </div>                        
                      </td>
                      
                      <td>
                        <?php 
                        if(@$row['ITEM_CONDITION'] == 3000 ){echo "USED";}
                        elseif(@$row['ITEM_CONDITION'] == 1000 ){echo "NEW";}
                        elseif(@$row['ITEM_CONDITION'] == 1500 ){echo "NEW OTHER";}
                        elseif(@$row['ITEM_CONDITION'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 2500 ){echo "SELLER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                        elseif(@$row['ITEM_CONDITION'] == 4000 ){echo "VERY GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 5000 ){echo "GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 6000 ){echo "ACCEPTABLE";}
                        else{echo @$row['ITEM_CONDITION'];}
                      ?>
                        
                      </td>
                      <td><?php echo @$row['ITEM_MT_DESC'];?></td>   
                      <td><?php echo @$row['QUANTITY'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
                      <td><?php echo @$row['MANUFACTURER'];?></td>
                      <td>
                        <select class="selectpicker shipping_service" name="shipping_service" rd="shipping_service_<?php echo $i; ?>" id="<?php echo @$row['SEED_ID']; ?>" data-live-search="true">
                     
                          <?php
                          $options = array("USPSParcel", "USPSFirstClass", "USPSPriority","FedExHomeDelivery","USPSPriorityFlatRateEnvelope","USPSPriorityMailSmallFlatRateBox","USPSPriorityFlatRateBox","USPSPriorityMailLargeFlatRateBox","USPSPriorityMailPaddedFlatRateEnvelope","USPSPriorityMailLegalFlatRateEnvelope");
                            foreach($options as $option){
                            if(@$row['SHIPPING_SERVICE'] == $option){
                            echo '<option value="'.$option.'" selected="selected">' .$option. '</option>';
                            }else{
                            echo '<option value="'.$option.'" >' .$option. '</option>';
                          }
                        }
                    ?>
                </select>
                      </td>                         
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
                     endif; 

                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>

              </div>

              <!-- /.tab-pane -->
              <div class="tab-pane <?php if(@$activeTab == 'Listed'){echo 'active';}?>" id="tab_2">
                <div class="row">
                  <div class="col-sm-12">
                  <form action="<?php echo base_url(); ?>tolist/c_tolist/lister_view" method="post">
                  <!--   <div class="col-sm-6">
                      
                      <div class="form-group">
                      <label for="Search by Group">Search by Group:</label>
                        <input type="radio" name="location" value="PK" <?php //if($location == 'PK'){echo 'checked';} ?>>&nbsp;Pak Lister
                        <input type="radio" name="location" value="US" <?php //if($location == 'US'){echo 'checked';} ?>>&nbsp;US Lister
                        <input type="radio" name="location" value="ALL" <?php //if($location == 'ALL'){echo 'checked';} ?>>&nbsp;All
                      </div> 
                    </div>
                    <div class="col-sm-2">
                      <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-sm" name="search_lister" name="search_lister" value="Search">
                      </div>
                    </div>-->
                    </form>
                  </div>
                  </div>
                <br>

                  <table id="listedItems" class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                        <th>ACTION</th>
                        <th>EBAY ID</th>
                        <th>BARCODE</th>
                        <th>CONDITION</th>
                        <th>TITLE</th>
                        <th>LIST QTY</th>
                        <th>LIST PRICE</th>
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>MANUFACTURE</th>
                        <th>SHIPPING SERVICE</th>
                        <th>LISTER NAME</th>
                        <th>LISTING TIME &amp; DATE</th>
                        <th>ACCOUNT</th>
                        <th>STATUS</th>
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      $i = 0;
                      $k = 0;
                      foreach (@$data['listed_qry'] as $row): ?>
                      <tr>
                        <td>
                          <div style="width:100px;">

                            <div style="float:left;margin-right:8px;">
                             <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         
                             <a style=" margin-right: 3px;" href="<?php echo base_url(); ?>listing/listing/print_label/<?php echo @$row['LIST_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a>
                          </div>
                        </td>                   
                        <td>
                        <a style="text-decoration: underline;" href="<?php echo @$row['EBAY_URL'];?>" title="eBay Link" target="_blank"><?php echo @$row['EBAY_ITEM_ID'];?></a>
                          
                        </td>
                        <td>                      
                           <div style="width:150px;">
                            <?php 

                          $barcode_qry = $this->db->query("SELECT MT.BARCODE_NO, MT.ITEM_ID, MT.LZ_MANIFEST_ID, MT.CONDITION_ID FROM LZ_BARCODE_MT MT WHERE MT.ITEM_ID = ".$row['ITEM_ID']." AND MT.LZ_MANIFEST_ID = ".$row['LZ_MANIFEST_ID']." AND CONDITION_ID = ".$row['ITEM_CONDITION']." AND MT.HOLD_STATUS = 0 AND MT.EBAY_ITEM_ID IS NOT NULL");

                            $barcode_qry = $barcode_qry->result_array();
                            foreach($barcode_qry as $barcode){
                              echo $barcode['BARCODE_NO']." - ";
  
                            }
                              
                             

                            ?>
                          </div>
                        </td>                   

                      <td>
                      <?php 
                        if(@$row['ITEM_CONDITION'] == 3000 ){echo "USED";}
                        elseif(@$row['ITEM_CONDITION'] == 1000 ){echo "NEW";}
                        elseif(@$row['ITEM_CONDITION'] == 1500 ){echo "NEW OTHER";}
                        elseif(@$row['ITEM_CONDITION'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 2500 ){echo "SELLER REFURBISHED";}
                        elseif(@$row['ITEM_CONDITION'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                        elseif(@$row['ITEM_CONDITION'] == 4000 ){echo "VERY GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 5000 ){echo "GOOD";}
                        elseif(@$row['ITEM_CONDITION'] == 6000 ){echo "ACCEPTABLE";}
                        else{echo @$row['ITEM_CONDITION'];}
                      ?>
                        
                      </td>
                      <td><?php echo @$row['ITEM_MT_DESC'];?></td>
                      <td><?php echo @$row['QUANTITY']; ?></td>
                      <td><?php echo @$row['EBAY_PRICE']; ?></td>
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
                      <td><?php echo @$row['MANUFACTURER'];?></td>                  
                      <td><?php echo @$row['SHIPPING_SERVICE'];?></td>
                      <td><?php
                          foreach(@$lister as $user):
                            if(@$row['LISTER_ID'] === $user['EMPLOYEE_ID']){
                              $u_name = ucfirst($user['USER_NAME']);
                              echo $u_name;
                            break;
                            }
                          endforeach;                    
 
                      ?></td>
                      <td><?php echo @$row['LIST_DATE'];?></td>
                      <td>
                        <?php 
                          if(@$row['LZ_SELLER_ACCT_ID'] == 1){
                            echo "Techbargains2015";
                          }elseif(@$row['LZ_SELLER_ACCT_ID'] == 2){
                            echo "Dfwonline";
                          }
                          
                        ?>
                          
                      </td>
                      <td><?php echo @$row['STATUS'];?></td>
                        
                    </tr>
                    <?php
                    $i++;  
                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
              </div>
              <!-- /.tab-pane -->

                     
            </div>



            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->

        </div>
        <!-- /.col --> 


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
 <?php $this->load->view('template/footer'); ?>
 <script>


  $('#catToCash_notListed').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 50,
      "paging": true,
      "lengthChange": true,
      "searching": true,
      //"ordering": true,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });



// $('#CatToCash_listedItems').DataTable({
//     "oLanguage": {
//     "sInfo": "Total Records: _TOTAL_"
//   },
//   "iDisplayLength": 50,
//     "paging": true,
//     "lengthChange": true,
//     "searching": true,
//     "ordering": true,
//      // "order": [[ 14, "DESC" ]],
//     "info": true,
//     "autoWidth": true,
//     "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
//   });




/*================================================
    =            Approval for Listing            =
================================================*/

$("#approval_btn").click(function () {
    
  var approval = [];
  $.each($("input[name='approval[]']:checked"), function(){            
   approval.push($(this).val());
  });    
    
  if(approval.length == 0){
    alert('Please select atleast one.');return false;
  }

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tolist/c_tolist/approvalForListing',
      data: { 'approval':approval           
    },
     success: function (data) {
      //alert(data);return false;
        if(data == true){
          alert('Selected items Approved for Listing.');
          window.location.reload();
          
        }else if(data == false){
          alert('Error - Selected items Approved for Listing.');
          //window.location.reload();
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
      });  

});

/*=====  End of Approval for Listing  ======*/   
  $(".shipping_service").on('change', function(){
      //alert("fdsdsfg"); 
  var ship_service = $(this).val();
  var seed_id = $(this).attr("id");
  //console.log(ship_service, seed_id); return false;
  $.ajax({
    dataType: 'json',
    type: 'POST',        
    url:'<?php echo base_url(); ?>catalogueToCash/c_listing/updateShip',
    data: {'ship_service':ship_service,'seed_id':seed_id},
   success: function (data) {
    //console.log(data);
    if(data == 1){
      alert('Success: Shipping service is updated!');
      return false;
      
   }else{
    alert('Error: Shipping service updation Failed');
      return false;
   }
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  }); 
 });
 </script>
