<?php $this->load->view('template/header'); 
?>

<style>
  #specific_fields{display:none;}
  .specific_attribute{display: none;}
</style>   
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tester Screen
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tester Screen</li>
      </ol>
    </section>        
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        <!-- Search Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Item</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>  
            <div class="box-body">
              <div class="col-sm-12">
                <div class="col-sm-8">
                  <div class="form-group">
                    <!--Empty -->
                  </div>
                </div>
                <div class="col-sm-4">
                    <a class="crsr-pntr" style="text-decoration: underline!important;font-weight:600 !important;" href="#" id="htest">
                      Test Color Hint?
                    </a><br>                
                  <div id="hintTest" class="form-group">
                    <button class="btn btn-default btn-sm m-b-5 fnt-13">Gray means Item is not selected for Test.</button><br>
                    <button class="btn btn-warning btn-sm m-b-5 fnt-13">Yellow means Item is Selected for Testing.</button><br>
                    <button class="btn btn-success btn-sm m-b-5 fnt-13">Green means Item is Tested.</button><br>
                    <button class="btn btn-danger btn-sm m-b-5 fnt-13">Red means Item is not Tested.</button><br>
                    <span class="fnt-13">
                      <strong>Note:</strong>
                      <ul>
                        <li>Holded item's checkbox checked and disabled.</li>
                        <li>Un-Holed item's checkbox unchecked.</li>
                      </ul>
                      </span>
                  </div>
                </div>
              </div>
                <form action="<?php echo base_url(); ?>tester/c_tester_screen/search_item" method="post" accept-charset="utf-8">
                    <div class="col-sm-8">
                        <div class="form-group">

                        <label for=""><?php if(@$data['test_data'] ==false){echo "Search Item:";}else{echo "Barcode:";}?></label>
                            <input class="form-control" type="text" id="bar_code" name="bar_code" value="<?php echo $this->session->userdata('scanned_barcode');?>" placeholder="Enter Item Barcode" <?php if(@$data['test_data'] !=false){echo "readonly";}?> >

                           <!--  onkeydown="return false" -->
                        </div>                                     
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group p-t-24">
                        <?php //var_dump($this->uri->segment(3));//exit;
                        //var_dump(@$data['barcode_color']);exit; 
                            if(!empty($this->uri->segment(3))){
                              // $url = base_url('tester/c_tester_screen/search_item');
                            }else{
                              ?>
                              <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                           <?php }

                            ?>
                            <!-- <input type="submit" class="btn btn-primary" name="Submit" value="Search"> -->
                        </div>
                    </div>
                    </form>
                    <div class="col-sm-2">
                      <div class="form-group p-t-24">
                        <a class="btn btn-primary" href="<?php echo base_url();?>tester/c_tester_screen/search_manifest" target="_blank">View Tests List</a>
                      </div>
                    </div>
                    <div class="col-sm-12">
                    <?php 
                      if(!empty(@$data['item_det'][0]['EBAY_ITEM_ID'])){
                        echo '<div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Item is already Listed against eBay No: '.@$data['item_det'][0]['EBAY_ITEM_ID'].'</strong>
                      </div>';
                      //exit;
                      } 
                    ?>                          
                    </div>                             
                  <?php if(@$data['test_data'] ==false):?>
                    <div class="col-sm-9">
                    <?php  
                    $qty = @$data['item_det'][0]['AVAIL_QTY'];
                    for($i=0; $i< $qty; $i++):
                   // foreach(@$data['item_det'] as $item):
                      //$barcode= explode('+', @$data['item_det'][0]['IT_BARCODE']);
                    //var_dump($barcode[1]);exit;  @$data['item_det'][$i]['UNIT_NO']
                    ?>
                        <div class="col-sm-2 pull-left" style="width:150px!important;margin: 10px 0px;">
                          <div class="form-group">
                            <input style="margin-right: 8px; display: none;" class="pull-left" type="checkbox" name="check_info[]" id="<?php echo @$data['item_det'][$i]['IT_BARCODE']; ?>"  value="<?php echo @$data['item_det'][$i]['IT_BARCODE'];?>">
                            <input type="button" class="<?php echo @$data['item_det'][$i]['IT_BARCODE']; ?> btn pull-left btn-default<?php //if(@$data['barcode_color'] == true){echo "btn-danger";}elseif(@$data['barcode_color'] == false){echo "btn-success";} ?>" name="info_name" id="<?php echo @$data['item_det'][$i]['IT_BARCODE'] ?>" value="<?php echo @$data['item_det'][$i]['UNIT_NO'];?>" readonly>
                            <input style="margin-left: 10px;margin-top: 10px;" class="hold_item <?php echo @$data['item_det'][$i]['IT_BARCODE']; ?>" title="<?php echo @$data['item_det'][$i]['IT_BARCODE']; ?> - Hold Item (Save for later use)" type="checkbox" name="hold_item[]" id="<?php echo @$data['item_det'][$i]['IT_BARCODE']; ?>"  value="<?php echo @$data['item_det'][$i]['IT_BARCODE'];?>">Hold
                          </div>
                        </div>
                    <?php endfor;?>
                      </div>
                      <?php if(!empty($data)): ?>                      
                        <div class="col-sm-1">
                          <div class="form-group p-t-20" >
                            <button class="btn btn-primary" title="Hold Item (Save for later use)" id="hold_item" name="hold_item">Hold Item</button>
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group p-t-20">
                            <a class="btn btn-primary" href="<?php echo base_url();?>tester/c_tester_screen/hold_item_detail" title="Hold Item detail view" id="hold_item" name="hold_item" target="_blank">View Hold Item</a>                        
                          </div>
                        </div> 
                    <?php endif;?>                                              
                  <?php endif; ?>
                </div>
            </div>
        <!-- Search Start -->
      <?php if(!empty($data)): ?>
        <!-- Item Information start --> 
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Item Information</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>                  
                <div class="box-body">  
                    <div class="col-sm-8">
                        <div class="form-group">
                        <label for="">Description:</label>
                            <input type="text" class="form-control" name="item_mt_desc" value="<?php echo @$data['item_det'][0]['ITEM_MT_DESC']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-4">
                        <div class="form-group">
                        <label for="">Manufacture:</label>
                            <input type="text" class="form-control" name="manufacturer" value="<?php echo @$data['item_det'][0]['MANUFACTURER']; ?>" readonly>
                        </div>
                    </div> 
                   
                    <div class="col-sm-2">
                    <label for="">MPN:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="MPN" name="MPN" value="<?php echo @$data['item_det'][0]['MFG_PART_NO']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                    <label for="">UPC:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="item_upc" name="item_upc" value="<?php echo @$data['item_det'][0]['UPC']; ?>" readonly>
                        </div>
                    </div> 
                    <div class="col-sm-2">
                    <label for="">Quantity:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="Quantity" value="<?php echo @$data['item_det'][0]['AVAIL_QTY']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                    <label for="">Item ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="item_id" id="item_id" value="<?php echo @$data['item_det'][0]['ITEM_ID']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="">Manifest ID:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="manifest_id" id="manifest_id" value="<?php echo @$data['item_det'][0]['LZ_MANIFEST_ID']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label for="">Purchase Ref No:</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="purch_ref_no" value="<?php echo @$data['item_det'][0]['PURCH_REF_NO']; ?>" readonly>
                        </div>
                    </div>   
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- Item Information end -->
<?php endif; ?> 
<?php if(!empty($data) && @$data['error_msg'] != true):?>
        <!-- Item Specific Start -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Add Item Specifics</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
                   <!--  <form action="<?php //echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8"> -->
                  <?php if(@$data['error_msg'] == true ):?>
                    <div class="col-sm-12">
                      <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Item Category</strong> not found.
                      </div>                   
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-4">
                        <div class="form-group">
                        <label for="bar_code">Barcode:</label>
                        <form action="<?php echo base_url('tester/c_tester_screen/update_cat_id'); ?>" method="post">
                        <input class="form-control" type="text" name="it_barcode" placeholder="Scan Item Barcode" value="<?php echo @$data['item_det'][0]['IT_BARCODE'];  ?>" required>
                       </div>
                      </div>
                      <div class="col-sm-6">
                          <div class="form-group">
                              <label for="">Query:</label>
                              <input class="form-control" id="title" name="title" placeholder="Enter UPC/MPN/Description">
                          </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group p-t-24">
                          <a class="crsr-pntr btn btn-primary btn-small" title="Click here for category suggestion" id="Suggest_Categories">Suggest Category</a>
                        </div>
                      </div>
                    </div> 
                      <div class="col-sm-12">  
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="">Category ID:</label>
                              <input type="number" class="form-control" id="category_id" name="category_id" value="<?php //echo @$row->CATEGORY_ID; ?>" required>
                          </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <label for="Main Category" class="control-label">Main Category:</label>
                            <input type="text" class="form-control" id="main_category" name="main_category" >
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="Sub Category" class="control-label">Sub Category:</label>
                            <input type="text" class="form-control" id="sub_cat" name="sub_cat" >
                          </div>
                        </div>

                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="Category" class="control-label">Category Name:</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" >
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12"> 
                        <div class="col-sm-2">
                          <div class="form-group">
                            <input type="submit" class="btn btn-primary" id="submit" name="submit" value="Save">
                          </div>
                        </div>
                      </div>  
                     </form>
                    <!-- Category Result -->
                    <div id="Categories_result">
                    </div>            
                    <!-- Category Result -->     
                   </div>
                  <?php endif; ?>
                      <input style="display: none;" type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$data['mt_id'][0]['EBAY_CATEGORY_ID'];  ?>">
                        <div class="col-sm-12">
                         <?php $i=1; foreach(@$data['specs_value'] as $specs_value): ?>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label for="" id="<?php echo 'specific_name_'.@$i;?>"><?php echo @$specs_value['SPECIFICS_NAME']; ?></label>
                                <input type="text" class="form-control" id="<?php echo 'specific_name_'.@$i;?>" name="cat_id" value="<?php echo @$specs_value['SPECIFICS_VALUE'];  ?>" readonly>
                              </div>
                            </div>
                          <?php $i++; endforeach; ?>
                          <div class="col-sm-12">
                            <div class="form-group pull-right">
                              <a class="btn btn-primary" href="<?php echo base_url();?>specifics/c_item_specifics/search_item/<?php echo $this->session->userdata('scanned_barcode'); $this->session->unset_userdata('scanned_barcode');?>" target="_blank">Update Item Specifics</a>
                            </div>
                         </div>
                        </div>                                                   
                </div>
            </div>
        <!-- Item Specific end -->     
<?php endif; ?>

<?php if(!empty($data['test_id'])): ?>
        <!-- Item Test start --> 
            <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Item Test</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>                  
                <div class="box-body">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Checklist Name:</label>
                          <!-- <select class="form-control" name="test_checklist_name" id="test_checklist_name" value="">
                        <?php //foreach(@$data['checklist_name'] as $checklist_name): ?>
                            <option value="<?php //echo $checklist_name['CHECKLIST_MT_ID']; ?>"><?php //echo $checklist_name['CHECKLIST_NAME']; ?></option>
                        <?php //endforeach; ?>    
                          </select> -->
                            <input type="text" class="form-control" name="test_checklist_name" id="test_checklist_name" value="<?php echo @$data['checklist_name'][0]['CHECKLIST_NAME']; ?>" readonly>
                          </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Category Name:</label>
                            <input type="text" class="form-control" name="test_category_name" id="test_category_name" value="<?php echo @$data['cat_id'][0]['BRAND_SEG3']; ?>" readonly>                          
                        </div>

                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="">Category ID:</label>
                            <input type="text" class="form-control" name="test_category_id" id="test_category_id" value="<?php echo @$data['cat_id'][0]['E_BAY_CATA_ID_SEG6']; ?>" readonly>                          
                        </div>
                      </div>
                    <?php if($data['test_data'] !=false){
                        $i=0;
                        $j=1;
                          foreach($data['test_id'] as $test_id):
                            //var_dump($data['test_data'][$i]['LZ_TEST_DET_ID']);exit;
                            if($i==0){?>
                          <div class="col-sm-3">
                              <div class="form-group">
                              <?php //if(@$test_id['SELECTION_MODE'] != 'FreeText'){?>
                                <label for="" style="font-size: 16px !important;"><?php echo @$test_id['CHECK_NAME'].':'; ?></label>
                              <?php// }?>
                          <?php  }elseif(@$test_id['LZ_TEST_MT_ID'] == @$data['match_qry'][$i-1]['LZ_TEST_MT_ID']){?>
                        <?php }else{ $j++;?>
                        </div>
                        </div>

                          <div class="col-sm-3">
                              <div class="form-group">
                              <?php// if(@$test_id['SELECTION_MODE'] != 'FreeText'){?>
                                <label for="" style="font-size: 16px !important;"><?php echo @$test_id['CHECK_NAME'].':'; ?></label>
                                <?php //}?>
                    
                      <?php } ?>
                            
                        <?php 
                          $space = " ";
                        if(@$test_id['SELECTION_MODE'] == 'FreeText'){
                            foreach(@$data['test_data'] as $test_data){
                              if($test_id['LZ_TEST_MT_ID'] == $test_data['LZ_TEST_MT_ID'] && $test_id['LZ_TEST_DET_ID'] == $test_data['LZ_TEST_DET_ID']){
                                echo '<input type="text" class="form-control" name="free_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'_'.$test_id['LZ_TEST_DET_ID'].'" value="'.$test_data['FREETEXT'].'" placeholder="'.$test_id['CHECK_NAME'].'">';
                                $flag = false;
                                break;
                              }else{
                                $flag = true;
                              }
                            }
                            if($flag){
                               echo '<input type="text" class="form-control" name="free_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'_'.$test_id['LZ_TEST_DET_ID'].'" value="" placeholder="'.$test_id['CHECK_NAME'].'">';
                            }
                          }elseif(@$test_id['SELECTION_MODE'] == 'Logical'){
                            foreach(@$data['test_data'] as $test_data){
                              if($test_id['LZ_TEST_MT_ID'] == $test_data['LZ_TEST_MT_ID'] && $test_id['LZ_TEST_DET_ID'] == $test_data['LZ_TEST_DET_ID']){
                                 echo '<input type="radio" name="logical_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'" value="'.$test_id['LZ_TEST_DET_ID'].'" checked>'.$space.$test_id['CHECK_VALUE'];
                                 $flag = false;
                                 break;
                              }else{
                                 $flag = true;
                              }
                            }
                            if($flag){
                              echo '<input type="radio" name="logical_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'" value="'.$test_id['LZ_TEST_DET_ID'].'">'.$space.$test_id['CHECK_VALUE'];
                            } 
                            // if($test_id['LZ_TEST_DET_ID'] == $data['test_data'][$i]['LZ_TEST_DET_ID']){

                            // echo '<input type="radio" name="logical_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'" value="'.$test_id['LZ_TEST_DET_ID'].'" checked>'.$space.$test_id['CHECK_VALUE'];
                            // }else{
                            //   echo '<input type="radio" name="logical_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'" value="'.$test_id['LZ_TEST_DET_ID'].'">'.$space.$test_id['CHECK_VALUE'];
                            // }

                          }elseif(@$test_id['SELECTION_MODE'] == 'List'){
                            if(@$data['test_id'][$i-1]['SELECTION_MODE'] != 'List'){
                              echo '<br><select name="'.$test_id['LZ_TEST_MT_ID'].'" id="list_'.@$j.'" class="selectpicker" multiple>';
                              foreach(@$data['test_data'] as $test_data){
                                if($test_id['LZ_TEST_MT_ID'] == $test_data['LZ_TEST_MT_ID'] && $test_id['LZ_TEST_DET_ID'] == $test_data['LZ_TEST_DET_ID']){
                                   echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'" selected>'.@$test_id['CHECK_VALUE'].'</option>';
                                   $flag = false;
                                   break;
                                  }else{
                                  $flag = true;
                                }

                              }
                              if($flag){
                                 echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'">'.@$test_id['CHECK_VALUE'].'</option>';
                              }
                              // if($test_id['LZ_TEST_DET_ID'] == $data['test_data'][$i]['LZ_TEST_DET_ID']){
                              //   echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'" selected>'.@$test_id['CHECK_VALUE'].'</option>';
                              // }else{
                              //   var_dump($test_id['LZ_TEST_DET_ID'],"-",$data['test_data'][$i]['LZ_TEST_DET_ID']);
                              //   echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'">'.@$test_id['CHECK_VALUE'].'</option>';
                              // }
                              if(@$data['test_id'][$i+1]['SELECTION_MODE'] != 'List'){
                                echo "</select>";
                              }
                            }else{
                              foreach(@$data['test_data'] as $test_data){
                                if($test_id['LZ_TEST_MT_ID'] == $test_data['LZ_TEST_MT_ID'] && $test_id['LZ_TEST_DET_ID'] == $test_data['LZ_TEST_DET_ID']){
                                   echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'" selected>'.@$test_id['CHECK_VALUE'].'</option>';
                                   $flag = false;
                                   break;
                                  }else{
                                  $flag = true;
                                }
                              }
                              if($flag){
                                 echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'">'.@$test_id['CHECK_VALUE'].'</option>';
                              }
                              // if($test_id['LZ_TEST_DET_ID'] == $data['test_data'][$i]['LZ_TEST_DET_ID']){
                              //   echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'" selected>'.@$test_id['CHECK_VALUE'].'</option>';
                              // }else{
                              //    var_dump($test_id['LZ_TEST_DET_ID'],"-",$data['test_data'][$i]['LZ_TEST_DET_ID']);
                              //   echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'" >'.@$test_id['CHECK_VALUE'].'</option>';
                              //}
                              if(@$data['test_id'][$i+1]['SELECTION_MODE'] != 'List'){
                                echo "</select>";
                              }
                            }
                            // echo '<input type="radio" name="test_'.$j.'" value="'.$test_id['CHECK_VALUE'].'">'.$test_id['CHECK_VALUE'];
                            //echo '<option value="'.htmlentities(@$test_id['CHECK_VALUE']).'">'.@$test_id['CHECK_VALUE'].'</option>';

                          } 
                        ?>
                        
                          
                         
                    <?php 
                    //if($i==2){break; exit;}
                    $i++;
                    endforeach;
                  }else{//handle if else
                    $i=0;
                        $j=1;
                          foreach($data['test_id'] as $test_id):
                            if($i==0){?>
                          <div class="col-sm-3">
                            <div class="form-group">
                              <?php //if(@$test_id['SELECTION_MODE'] != 'FreeText'){?>
                                <label for="" style="font-size: 16px !important;"><?php echo @$test_id['CHECK_NAME'].':'; ?></label>
                              <?php// }?>
                          <?php  }elseif(@$test_id['LZ_TEST_MT_ID'] == @$data['match_qry'][$i-1]['LZ_TEST_MT_ID']){?>
                        <?php }else{ $j++;?>
                            </div>
                          </div>

                          <div class="col-sm-3">
                              <div class="form-group">
                              <?php// if(@$test_id['SELECTION_MODE'] != 'FreeText'){?>
                                <label for="" style="font-size: 16px !important;"><?php echo @$test_id['CHECK_NAME'].':'; ?></label>
                                <?php //}?>
                    
                      <?php } ?>
                            
                        <?php 
                          $space = " ";
                        if(@$test_id['SELECTION_MODE'] == 'FreeText'){
                            echo '<input type="text" class="form-control" name="free_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'_'.$test_id['LZ_TEST_DET_ID'].'" value="'.$test_id['CHECK_VALUE'].'" placeholder="'.$test_id['CHECK_NAME'].'">';
                          }elseif(@$test_id['SELECTION_MODE'] == 'Logical'){
                            echo '<input type="radio" name="logical_'.$j.'" id="'.$test_id['LZ_TEST_MT_ID'].'" value="'.$test_id['LZ_TEST_DET_ID'].'">'.$space.$test_id['CHECK_VALUE'];

                          }elseif(@$test_id['SELECTION_MODE'] == 'List'){
                            if(@$data['test_id'][$i-1]['SELECTION_MODE'] != 'List'){
                              echo '<br><select name="'.$test_id['LZ_TEST_MT_ID'].'" id="list_'.@$j.'" class="selectpicker" multiple>';//<option value="select">------------Select------------</option>';
                              echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'">'.@$test_id['CHECK_VALUE'].'</option>';
                              if(@$data['test_id'][$i+1]['SELECTION_MODE'] != 'List'){
                                echo "</select>";
                              }
                            }else{
                              echo '<option id="'.$test_id['LZ_TEST_DET_ID'].'" value="'.htmlentities(@$test_id['LZ_TEST_DET_ID']).'">'.@$test_id['CHECK_VALUE'].'</option>';
                              if(@$data['test_id'][$i+1]['SELECTION_MODE'] != 'List'){
                                echo "</select>";
                              }
                            }
                            // echo '<input type="radio" name="test_'.$j.'" value="'.$test_id['CHECK_VALUE'].'">'.$test_id['CHECK_VALUE'];
                            //echo '<option value="'.htmlentities(@$test_id['CHECK_VALUE']).'">'.@$test_id['CHECK_VALUE'].'</option>';

                          } 
                        ?>
                        
                          
                         
                    <?php 
                    //if($i==2){break; exit;}
                    $i++;
                    endforeach;
                  }//end handle ifelse
                    ?> 
                      
              
                                           
                      </div>
                    </div>
                  <input type="hidden" class="form-control" name="test_count" id="test_count" value="<?php echo @$j;?>">
                      
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- Item Test end -->  

        <!-- Tester Screen start --> 
            <div class="box">    
                <div class="box-body">
                    <!-- <form name="" action="" method=""> -->
                        <div class="col-sm-4">
                          <label for="">Default Condition:</label>
                          <!-- <form action="" method=""> -->
                            <div class="form-group">
                              <select class="form-control" id="default_condition" name="default_condition" value="<?php echo @$data['item_det'][0]['ITEM_CONDITION']; ?>" readonly>
                              <option value="3000" <?php if(@$data['item_con']){ if(@$data['item_con'][0]['ITEM_CONDITION'] == 3000 ){echo "selected='selected'";}}else{ if(@$data['item_det'][0]['ITEM_CONDITION'] == 3000 ){echo "selected='selected'";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "Used" || @$data['item_det'][0]['ITEM_CONDITION'] == "used" ){echo "selected='selected'";}} ?>>Used</option>
                              <option value="1000" <?php if(@$data['item_con']){ if(@$data['item_con'][0]['ITEM_CONDITION'] == 1000){echo "selected='selected'";}}else{if(@$data['item_det'][0]['ITEM_CONDITION'] == 1000){echo "selected='selected'";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "New" || @$data['item_det'][0]['ITEM_CONDITION'] == "new" ){echo "selected='selected'";}} ?>>New</option>
                              <option value="1500" <?php if(@$data['item_con']){ if(@$data['item_con'][0]['ITEM_CONDITION'] == 1500 ){echo "selected='selected'";}}else{if(@$data['item_det'][0]['ITEM_CONDITION'] == 1500 ){echo "selected='selected'";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "New Other" || @$data['item_det'][0]['ITEM_CONDITION'] == "New other" || @$data['item_det'][0]['ITEM_CONDITION'] == "new other" || @$data['item_det'][0]['ITEM_CONDITION'] == "New other(see details)" || @$data['item_det'][0]['ITEM_CONDITION'] == "New without tags" ){echo "selected='selected'";}} ?>>New other</option>
                              <option value="2000" <?php if(@$data['item_con']){if(@$data['item_con'][0]['ITEM_CONDITION'] == 2000 ){echo "selected='selected'";}}else{ if(@$data['item_det'][0]['ITEM_CONDITION'] == 2000 ){echo "selected='selected'";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "Manufacturer Refurbished" || @$data['item_det'][0]['ITEM_CONDITION'] == "manufacturer refurbished" ){echo "selected='selected'";}} ?>>Manufacturer Refurbished</option>
                              <option value="2500" <?php if(@$data['item_con']){if(@$data['item_con'][0]['ITEM_CONDITION'] == 2500 ){echo "selected='selected'";}}else{if(@$data['item_det'][0]['ITEM_CONDITION'] == 2500 ){echo "selected='selected'";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "Seller Refurbished" || @$data['item_det'][0]['ITEM_CONDITION'] == "seller refurbished" ){echo "selected='selected'";}} ?>>Seller Refurbished</option>
                              <option value="7000" <?php if(@$data['item_con']){ if(@$data['item_con'][0]['ITEM_CONDITION'] == 7000 ){echo "selected='selected'";}}else{if(@$data['item_det'][0]['ITEM_CONDITION'] == 7000 ){echo "selected='selected'";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "For Parts or Not Working" || @$data['item_det'][0]['ITEM_CONDITION'] == "For parts" ){echo "selected='selected'";}} ?>>For Parts or Not Working</option>

                            </select> 
                            </div>
                          <!-- </form> -->


<?php /*===================================================================
=            format of all ifelse given above and bellow            =
===================================================================*/

// if(@$data['item_con']){ 
//   if(@$data['item_con'][0]['ITEM_CONDITION'] == 3000 ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";
//   }elseif(@$data['item_con'][0]['ITEM_CONDITION'] == "Used" || @$data['item_con'][0]['ITEM_CONDITION'] == "used" ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";
//   }elseif(@$data['item_con'][0]['ITEM_CONDITION'] == 1000 || @$data['item_con'][0]['ITEM_CONDITION'] == "New" || @$data['item_con'][0]['ITEM_CONDITION'] == "new" ){echo "Item is new and unused. Item comes in sealed original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_con'][0]['ITEM_CONDITION'] == 1500 || @$data['item_con'][0]['ITEM_CONDITION'] == "New Other" || @$data['item_con'][0]['ITEM_CONDITION'] == "new other" ){echo "Open box item. Item is new and unused. Comes in original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.";
//   }elseif(@$data['item_con'][0]['ITEM_CONDITION'] == 7000 || @$data['item_con'][0]['ITEM_CONDITION'] == "For Parts or Not Working" || @$data['item_con'][0]['ITEM_CONDITION'] == "For parts" ){echo "Item is being sold for parts not working. Item has scuffs, scratches and signs of wear. Look at pictures for details. Item is ''AS IS'' and No returns will be accepted on this item.";}
// }else{
//   if(@$data['item_det'][0]['ITEM_CONDITION'] == 3000 ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";
//     }elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "Used" || @$data['item_det'][0]['ITEM_CONDITION'] == "used" ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";
//     }elseif(@$data['item_det'][0]['ITEM_CONDITION'] == 1000 || @$data['item_det'][0]['ITEM_CONDITION'] == "New" || @$data['item_det'][0]['ITEM_CONDITION'] == "new" ){echo "Item is new and unused. Item comes in sealed original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == 1500 || @$data['item_det'][0]['ITEM_CONDITION'] == "New Other" || @$data['item_det'][0]['ITEM_CONDITION'] == "new other" ){echo "Open box item. Item is new and unused. Comes in original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.";
//      }elseif(@$data['item_det'][0]['ITEM_CONDITION'] == 7000 || @$data['item_det'][0]['ITEM_CONDITION'] == "For Parts or Not Working" || @$data['item_det'][0]['ITEM_CONDITION'] == "For parts" ){echo "Item is being sold for parts not working. Item has scuffs, scratches and signs of wear. Look at pictures for details. Item is ''AS IS'' and No returns will be accepted on this item.";}
//    }//end main if lse 

/*=====  End of format of all ifelse given above and bellow  ======*/
 ?>



                        </div>
                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="">Default Condition Description:</label>
                              <textarea class="form-control" name="default_description" id="default_description" cols="30" rows="4" readonly><?php if(@$data['item_con']){ if(@$data['item_con'][0]['ITEM_CONDITION'] == 3000 ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_con'][0]['ITEM_CONDITION'] == "Used" || @$data['item_con'][0]['ITEM_CONDITION'] == "used" ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_con'][0]['ITEM_CONDITION'] == 1000 || @$data['item_con'][0]['ITEM_CONDITION'] == "New" || @$data['item_con'][0]['ITEM_CONDITION'] == "new" ){echo "Item is new and unused. Item comes in sealed original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_con'][0]['ITEM_CONDITION'] == 1500 || @$data['item_con'][0]['ITEM_CONDITION'] == "New Other" || @$data['item_con'][0]['ITEM_CONDITION'] == "new other" ){echo "Open box item. Item is new and unused. Comes in original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.";}elseif(@$data['item_con'][0]['ITEM_CONDITION'] == 7000 || @$data['item_con'][0]['ITEM_CONDITION'] == "For Parts or Not Working" || @$data['item_con'][0]['ITEM_CONDITION'] == "For parts" ){echo "Item is being sold for parts not working. Item has scuffs, scratches and signs of wear. Look at pictures for details. Item is ''AS IS'' and No returns will be accepted on this item.";}}else{if(@$data['item_det'][0]['ITEM_CONDITION'] == 3000 ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == "Used" || @$data['item_det'][0]['ITEM_CONDITION'] == "used" ){echo "Item is used and may have scuffs, scratches or signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == 1000 || @$data['item_det'][0]['ITEM_CONDITION'] == "New" || @$data['item_det'][0]['ITEM_CONDITION'] == "new" ){echo "Item is new and unused. Item comes in sealed original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture. ";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == 1500 || @$data['item_det'][0]['ITEM_CONDITION'] == "New Other" || @$data['item_det'][0]['ITEM_CONDITION'] == "new other" ){echo "Open box item. Item is new and unused. Comes in original packaging. Packaging may show signs of wear. Look at pictures for details. The pictures are original, unless its multiple listings and then your item may slightly vary from picture.";}elseif(@$data['item_det'][0]['ITEM_CONDITION'] == 7000 || @$data['item_det'][0]['ITEM_CONDITION'] == "For Parts or Not Working" || @$data['item_det'][0]['ITEM_CONDITION'] == "For parts" ){echo "Item is being sold for parts not working. Item has scuffs, scratches and signs of wear. Look at pictures for details. Item is ''AS IS'' and No returns will be accepted on this item.";}} ?></textarea>
                          </div>
                        </div>

                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="">Picture Notes:</label>
                              <textarea class="form-control" name="picture_note" id="picture_note" cols="30" rows="4" readonly> <?php if($data['test_data'] !=false){echo $data['test_data'][0]['PIC_NOTE'];}?></textarea>
                          </div>
                        </div> 

                        <div class="col-sm-12">
                          <div class="form-group">
                              <label for="">Special Remarks:</label>
                              <textarea class="form-control" name="special_remarks" id="special_remarks" cols="30" rows="4" readonly><?php if($data['test_data'] !=false){echo $data['test_data'][0]['SPECIAL_REMARKS'];}?></textarea>
                          </div>
                        </div>
                      <?php if($data['test_data'] !=false){
                        if($this->uri->segment(5) == "test-view"){
                        ?>
                        <div class="col-sm-12" style="<?php echo 'display: none!important;';?>>
                          <div class="form-group">
                              <input type="button" class="btn btn-success" name="update_test" id="update_test" value="Update">
                          </div>
                        </div>                                                 
                      <?php }else{?>
                        <div class="col-sm-12">
                          <div class="form-group">
                              <input type="button" class="btn btn-primary" name="update_test" id="update_test" value="Update">
                          </div>
                        </div> 
                      <?php }
                      }else{?>
                        <div class="col-sm-12">
                          <div class="form-group">
                              <input type="button" class="btn btn-primary" name="tester_submit" id="tester_submit" value="Save">
                          </div>
                        </div>
                        
                      <?php } ?>
                    <!-- </form> -->
                        
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- Tester Screen end -->
<?php endif;  ?>


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
/*=================================
=            Hint Test            =
=================================*/
$("#hintTest").hide();
$("#htest").click(function(){
    $("#hintTest").toggle();
});

/*=====  End of Hint Test  ======*/
$(document).ready(function(){

/*=======================================================
=            get item test onclick checklist            =
=======================================================*/
$("#test_checklist_name").change(function(){
    var cat_id = $("#test_category_id").val();
    //alert(cat_id);return false;

    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tester/c_tester_screen/get_single_checklist_test',
      data: { 'cat_id' : cat_id        
    },
     success: function (data) {
        if(data == true){

          alert(data);return false;
                   
                         
          }          
     }
    }); 
  });   

/*=====  End of get item test onclick checklist  ======*/

/*===================================================
=            barcode validation on ready            =
===================================================*/

  var bar_code = $("#bar_code").val();
    var item_id = $("#item_id").val();
    var manifest_id = $("#manifest_id").val();



    $.ajax({
      dataType: 'json',
      type: 'POST',        
      url:'<?php echo base_url(); ?>tester/c_tester_screen/load_tested_data',
      data: { 'item_id' : item_id,
              'manifest_id': manifest_id,
              'bar_code' : bar_code           
    },
     success: function (data) {
        if(data == true){


          $('.btn-default').removeClass('btn-default').addClass('btn-danger');
          $('#'+bar_code).prop('checked', true);
          $('.'+bar_code).removeClass('btn-default').addClass('btn-warning');
          return false;
          }else{
            
            
            for(j=0; j< data.tested_barcode.length; j++){
              $('.'+data.tested_barcode[j].LZ_BARCODE_ID).removeClass('btn-default').addClass('btn-success');
              // $('.btn-success').attr("disabled", true); //this field disabeld all checkbox with hold label

            }
            for(i=0; i< data.not_tested_barcode.length; i++){
              if(data.not_tested_barcode[i].BARCODE_NO == bar_code){
                  $('#'+bar_code).prop('checked', true);
                  $('.'+bar_code).removeClass('btn-default').addClass('btn-warning');
              }else{
                $('.'+data.not_tested_barcode[i].BARCODE_NO).removeClass('btn-default').addClass('btn-danger');
              }
              }

            if(data.alert_tested){
              alert("Item is already tested.");
            }else if(data.alert_tested == null || data.alert_tested == ''){
              //alert(bar_code);
              // var bar_code = data.alert_tested[0].LZ_BARCODE_ID;
              $('#'+bar_code).prop('checked', true);
              $('.'+bar_code).removeClass('btn-danger').addClass('btn-warning');
            }
            for(k=0; k< data.holded_item_qry.length; k++){
              
              $('.'+data.holded_item_qry[k].BARCODE_NO).prop('checked', true);
              $('.'+data.holded_item_qry[k].BARCODE_NO).attr("disabled", true);
              //$('.hold_item').attr("disabled", true);
              
             }          
                         
          }          
     }
    }); 

/*=====  End of barcode validation on ready  ======*/


});
// $(document).ready(function(){
//   var bar_code = $("#bar_code").val();
//   $('#'+bar_code).prop('checked', true);
//   $('.'+bar_code).removeClass('btn-danger').addClass('btn-warning');
//   return false;

// });
</script>