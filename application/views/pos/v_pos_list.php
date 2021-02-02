<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Seed &amp; Posting
        
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Seed &amp; Posting</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">

    <!-- Insertion Message start-->
        <?php if($this->session->flashdata('success')){ ?>
          <div id="successMessage" class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php }elseif($this->session->flashdata('error')){  ?>

        <div id="errorMessage" class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
        </div>

    <?php } ?>
    <!-- Insertion Message end-->

    <!-- Deletion Message start-->
        <?php if($this->session->flashdata('deleted')){ ?>
          <div id="delSuccess" class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('deleted'); ?>
          </div>
        <?php }elseif($this->session->flashdata('del_error')){  ?>

        <div id="delError" class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Error!</strong> <?php echo $this->session->flashdata('del_error'); ?>
        </div>

    <?php } ?>
    <!-- Deletion Message end--> 

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>              
            </div>
           

            <div class="box-body">
              <form action="<?php //echo base_url(); ?>tolist/c_tolist/lister_view" method="post" accept-charset="utf-8">

                <div class="col-sm-8">
                    <div class="form-group">
                     <?php //$purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="purchase_no" id="purchase_no" value="<?php //if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>">
                    </div>                                     
                </div> 
                  <div class="col-sm-3">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
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
              <li class="active"><a href="#tab_1" data-toggle="tab">Not Posted</a></li>
              <li><a href="#tab_2" data-toggle="tab">Posted</a></li>
              <!-- <li><a href="#tab_3" data-toggle="tab">Without Pictures</a></li> -->

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <table id="posNotPosted" class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                        <th>ACTION</th>

                        <th>PICTURE</th>
                        <th>BARCODE</th>
                        <!-- <th>IITEM ID</th>
                        <th>MANIFEST ID</th> -->
                        
                        <th>CONDITION</th>
                        <!-- <th>BARCODE</th> -->
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        
                        <!-- <th>HOLD QTY</th> -->
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>SKU</th>
                        <th>MANUFACTURE</th>
    <!--                     <th>COST</th>
                        <th>LINE TOTAL</th>   -->                         
                        <!-- <th>PURCHASE DATE</th> -->
                        <th>DAYS ON SHELF</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      //$i = 0;
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
                        $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/";
                        $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                        $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID']."/";
                            //var_dump($m_dir);exit;
                        if(is_dir(@$m_dir)){
                                    $iterator = new \FilesystemIterator(@$m_dir);
                                    if (@$iterator->valid()){    
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
                              }else{
                                $m_flag = false;
                              }
                          if($m_flag):
                        ?>


                      <tr>                   
                        <td>
                          <div style="width:100px;">
                            <div style="float:left;margin-right:8px;">
                              <a href="<?php echo base_url(); ?>pos/c_pos_list/posPostDetail/<?php echo $row['SEED_ID'] ?>" title="Post on Craiglist" class="btn btn-success btn-sm" target="_blank">Post</a>
                             </div>
                            <div style="float:left;margin-right:8px;">
                             <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         

                          </div>
                        </td>
                        <td><?php
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
                    }
                  }else{
                     //$images = glob("$s_dir*.jpg");
                    //sort($images);
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
                    }
                  }


                ?>                                

                        </td>
<!--                         <td><?php 
                        //var_dump(@$data['barcode_qry']);exit;
                        // if(!empty(@$data['barcode_qry'])){
                        //   $it_barcode = @$data['barcode_qry'][$i];
                        //   echo $it_barcode; 
                        // }

                          ?></td> -->
                      <?php //$img = @$row['ITEM_PIC'];?>
                      <?php //if(!empty($img)):?>
                                                              
                      <?php //$img = @$row['ITEM_PIC']->load();?>
                      <?php //$pic=base64_encode(@$img);?>
                      <!-- <td><?php //echo "<img width='50px' height='50px' src='data:image/jpeg;base64,".@$pic."'/>";?></td> -->
                      <?php //else:?>
                     <!--  <td><?php// echo "Not found.";?></td> -->
                      <?php //endif;?> 
                      <td>
                      <div style="width:150px;">
                       <?php 
                      foreach (@$data['not_listed_barcode'] as $barcode) {
                        if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['ITEM_CONDITION'] ){
                          echo @$barcode['BARCODE_NO']." - ";

                        }
                      }
                        ?>
                        </div>
                      </td>                   
                        <!-- <td>
                          <?php //echo @$row['ITEM_ID'];?>
                        </td>
                        <td>
                          <?php //echo @$row['LZ_MANIFEST_ID'];?>
                        </td>    -->                 
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
                      <!-- <td><?php //echo @$row['IT_BARCODE'];?></td>  -->               
                      <td><?php echo @$row['ITEM_MT_DESC'];?></td>
                      <td><?php echo @$row['QUANTITY']; ?></td>
                      <!-- <td></td> -->
                      <td><?php echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MFG_PART_NO'];?></td>
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
                    // $i++;
                    endif; 

                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
            <table id="posPosted" class="table table-bordered table-striped " >
                    <thead>
                    <tr>
                      <th>ACTION</th>
                        <th>CRAIG AD ID</th>
                        <th>BARCODE</th>
                        <th>CONDITION</th>
                        <th>TITLE</th>
                        <th>POSTED QTY</th>
                        <th>OFFER RATE</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>MANUFACTURE</th>
                        <th>POSTED DATE</th>
                        <th>VALID TILL</th>
                        <th>LISTER NAME</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      $i = 0;
                      foreach (@$data['listed_qry'] as $row): ?>
                      <tr>
                        <td>
                          <div style="width:100px;">

                            <div style="float:left;margin-right:8px;">
                             <a href="<?php echo base_url(); ?>tolist/c_tolist/seed_view/<?php echo $row['LZ_SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>

                              <a style="margin-left:4px;" title="Delete Record" href="<?php echo base_url(); ?>pos/c_pos_list/deleteRecord/<?php echo $row['LZ_CRAIG_POST_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>                             
                             </div>                         
                             <!-- <a style=" margin-right: 3px;" href="<?php //echo base_url(); ?>listing/listing/print_label/<?php //echo @$row['LIST_ID']; ?>" title="Print Sticker" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></a> -->
                          </div>
                        </td>                   
                        <td>
                          <?php echo @$row['CRAIG_AD_ID'];?>
                        </td>
                         <td>                      
                           <div style="width:150px;">
                            <?php 
                              foreach (@$data['listed_barcode'] as $barcode) {
                                if(@$barcode['ITEM_ID'] == @$row['ITEM_ID'] && @$barcode['LZ_MANIFEST_ID'] == @$row['LZ_MANIFEST_ID'] && @$barcode['CONDITION_ID'] == @$row['DEFAULT_COND'] ){
                                echo @$barcode['BARCODE_NO']." - ";

                                }
                              }
                            ?>
                          </div>
                        </td>                    
                 
                      <td>
                      <?php 
                        if(@$row['DEFAULT_COND'] == 3000 ){echo "USED";}
                        elseif(@$row['DEFAULT_COND'] == 1000 ){echo "NEW";}
                        elseif(@$row['DEFAULT_COND'] == 1500 ){echo "NEW OTHER";}
                        elseif(@$row['DEFAULT_COND'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                        elseif(@$row['DEFAULT_COND'] == 2500 ){echo "SELLER REFURBISHED";}
                        elseif(@$row['DEFAULT_COND'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                        elseif(@$row['DEFAULT_COND'] == 4000 ){echo "VERY GOOD";}
                        elseif(@$row['DEFAULT_COND'] == 5000 ){echo "GOOD";}
                        elseif(@$row['DEFAULT_COND'] == 6000 ){echo "ACCEPTABLE";}
                        else{echo @$row['DEFAULT_COND'];}
                      ?>
                        
                      </td>              
                      <td><?php echo @$row['ITEM_TITLE'];?></td>
                      <td><?php echo @$row['POST_QTY']; ?></td>
                      <td><?php echo @$row['OFFER_RATE']; ?></td>
                      <td><?php echo @$row['UPC'];?></td>
                      <td><?php echo @$row['MPN'];?></td>              
                      <td><?php echo @$row['MANUFACTURE'];?></td>
                      <td> <?php echo @$row['POST_DATE_TIME']; ?> </td>
                      <td> <?php echo @$row['VALID_TILL']; ?> </td>                  
                      <td><?php
                          foreach(@$lister as $user):
                            if(@$row['POSTED_BY'] === $user['EMPLOYEE_ID']){
                              $u_name = ucfirst($user['USER_NAME']);
                              echo $u_name;
                            break;
                            }
                          endforeach;                    

                      ?></td>
                        
                    </tr>
                    <?php
                    $i++;  
                    endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
              </div>
              <!-- /.tab-pane -->
<!-- Without Pictures start-->
<!--               <div class="tab-pane" id="tab_3">
                <table id="poswithoutPictures" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ACTION</th>
                        <th>IITEM ID</th>
                        <th>MANIFEST ID</th>
                        <th>CONDITION</th>
                        <th>TITLE</th>
                        <th>AVAILABLE QTY</th>
                        <th>PURCH REF NO</th>
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>SKU</th>
                        <th>MANUFACTURE</th>                      
                        <th>PURCHASE DATE</th>
                        <th>DAYS ON SHELF</th>
                        
                    </tr>
                    </thead>

                    <tbody>
                      <?php 
                      // var_dump($data);exit;
                      //foreach (@$data['listing_without_pic_qry'] as $row): 
                      //$it_condition  = @$row['ITEM_CONDITION'];
                    //if(is_numeric(@$it_condition)){
                       // if(@$it_condition == 3000){
                      //     @$it_condition = 'Used';
                      //   }elseif(@$it_condition == 1000){
                      //     @$it_condition = 'New'; 
                      //   }elseif(@$it_condition == 1500){
                      //     @$it_condition = 'New other'; 
                      //   }elseif(@$it_condition == 2000){
                      //       @$it_condition = 'Manufacturer refurbished';
                      //   }elseif(@$it_condition == 2500){
                      //     @$it_condition = 'Seller refurbished'; 
                      //   }elseif(@$it_condition == 7000){
                      //     @$it_condition = 'For parts or not working'; 
                      //   }
                      // }
                        // $mpn = str_replace('/', '_', @$row['MFG_PART_NO']);
                        // $master_path = $data['path_query'][0]['MASTER_PATH'];
                        // $m_dir =  $master_path.@$row['UPC']."~".@$mpn."/".@$it_condition."/";
                        // $specific_path = $data['path_query'][0]['SPECIFIC_PATH'];

                        // $s_dir = $specific_path.@$row['UPC']."~".$mpn."/".@$it_condition."/".@$row['LZ_MANIFEST_ID'];
                        //     //var_dump($m_dir,$s_dir);
                        // if(is_dir(@$m_dir)){
                        //             $iterator = new \FilesystemIterator(@$m_dir);
                        //             if (@$iterator->valid()){    
                        //               $m_flag = false;
                        //           }else{
                        //             $m_flag = true;
                        //           }
                        //       }elseif(is_dir(@$s_dir)){
                        //         $iterator = new \FilesystemIterator(@$s_dir);
                        //             if (@$iterator->valid()){    
                        //               $m_flag = false;
                        //           }else{
                        //             $m_flag = true;
                        //           }
                        //       }else{
                        //         $m_flag = true;
                        //       }
                        //   if($m_flag):
                        ?>


                      <tr>                   
                        <td>
                          <div style="width:100px;">

                            <div style="float:left;margin-right:8px;">
                             <a href="<?php //echo base_url(); ?>tolist/c_tolist/seed_view/<?php //echo $row['SEED_ID'] ?>" title="Create/Edit Seed" class="btn btn-primary btn-sm" target="_blank"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </div>                         

                          </div>
                        </td>
                                          
                        <td>
                          <?php //echo @$row['ITEM_ID'];?>
                        </td>
                        <td>
                          <?php //echo @$row['LZ_MANIFEST_ID'];?>
                        </td>                    
                      <td>
                      <?php 
                        // if(@$row['ITEM_CONDITION'] == 3000 ){echo "USED";}
                        // elseif(@$row['ITEM_CONDITION'] == 1000 ){echo "NEW";}
                        // elseif(@$row['ITEM_CONDITION'] == 1500 ){echo "NEW OTHER";}
                        // elseif(@$row['ITEM_CONDITION'] == 2000 ){echo "MANUFACTURER REFURBISHED";}
                        // elseif(@$row['ITEM_CONDITION'] == 2500 ){echo "SELLER REFURBISHED";}
                        // elseif(@$row['ITEM_CONDITION'] == 7000 ){echo "FOR PARTS OR NOT WORKING";}
                        // elseif(@$row['ITEM_CONDITION'] == 4000 ){echo "VERY GOOD";}
                        // elseif(@$row['ITEM_CONDITION'] == 5000 ){echo "GOOD";}
                        // elseif(@$row['ITEM_CONDITION'] == 6000 ){echo "ACCEPTABLE";}
                        // else{echo @$row['ITEM_CONDITION'];}
                      ?>
                        
                      </td>
              
                      <td><?php //echo @$row['ITEM_MT_DESC'];?></td>
                      <td><?php //echo @$row['QUANTITY']; ?></td>

                      <td><?php //echo @$row['PURCH_REF_NO'];?></td>
                      <td><?php //echo @$row['UPC'];?></td>
                      <td><?php //echo @$row['MFG_PART_NO'];?></td>
                      <td><?php //echo @$row['SKU_NO'];?></td>                  
                      <td><?php //echo @$row['MANUFACTURER'];?></td>                  

                      <td><?php //echo @$row['LOADING_DATE'];?></td>
                      <td>
                      <?php 
                           
                        // $current_timestamp = date('m/d/Y');
                        // $purchase_date = @$row['LOADING_DATE'];
                        
                        // $date1=date_create($current_timestamp);
                        // $date2=date_create($purchase_date);
                        // $diff=date_diff($date1,$date2);
                        // $date_rslt = $diff->format("%R%a days");
                        //echo abs($date_rslt)." Days"; 

                      ?>
                      </td>
                        
                    </tr>
                    <?php
                    // endif;  
                    // endforeach;
                    ?>
                             
                    </tbody>
                </table><br>
              </div> -->
              <!-- /.tab-pane -->
<!-- Without pictures end-->              
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
      /*===== Insertion Success message auto hide ====*/
        setTimeout(function() {
          $('#successMessage').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000); // <-- time in milliseconds        

    /*===== Insertion Success message auto hide end ====*/  

    /*===== Deletion message auto hide start ====*/
        setTimeout(function() {
          $('#delSuccess').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        setTimeout(function() {
          $('#delError').fadeOut('slow');
        },3000); // <-- time in milliseconds        

    /*===== Deletion message auto hide end ====*/    
</script>