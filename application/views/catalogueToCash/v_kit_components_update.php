<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<style type="text/css">
  .row-color{
    background-color:rgba(0, 166, 90, 0.67) !important;
  }
  .textColor{
    color:rgba(0, 166, 90, 0.67) !important;
  }
  .grey-color{
    background-color:rgb(128,128,128) !important;
  }
  .light-grey{
    background-color: rgb(211,211,211) !important;
  }
  .light-green{
    background-color: rgb(144,238,144) !important;
  }
  .row-yellow{
    background-color:#f39c12ad !important;
  }
  .color-red{
    background-color: #F1948A !important;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        kit Components
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">kit Components</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content"> 
        <div class="box"><br>  
          <div class="box-body form-scroll">  
          <?php if($this->session->flashdata('success')){ ?>
            <div class="alert alert-success" id="success_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-danger" id="error_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
            <div class="alert alert-warning" id="warning_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
            <div class="alert alert-danger" id="compo_msg">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
            </div>
            <?php }
               $cat_id  = $this->uri->segment(4);
               $mpn_id  = $this->uri->segment(5);
               $cata_id = $this->uri->segment(6);
            ?>  
            <div class="col-md-12">
            <input type="hidden" name="ct_category_id" value="<?php echo $cat_id; ?>" id="ct_category_id">
            <input type="hidden" name="ct_catlogue_mt_id" value="<?php echo $mpn_id; ?>" id="ct_catlogue_mt_id">
            <input type="hidden" name="ct_cata_id" value="<?php echo $cata_id; ?>" id="ct_cata_id">
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="EBAY ID">EBAY ID:</label>
                    <input class="form-control" type="text" value="<?php echo htmlentities(@$data['detail'][0]['EBAY_ID']); ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ITEM DESCRIPTION">ITEM DESCRIPTION:</label>
                    <input class="form-control" type="text" value="<?php echo htmlentities(@$data['detail'][0]['TITLE']); ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="MPN">MPN:</label>
                    <input class="form-control" type="text" name="kitmpn" id="kitmpn" value="<?php echo @$data['detail'][0]['MPN']; ?>" readonly> 
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">CONDITION:</label>
                    <input class="form-control" type="text" value="<?php echo @$data['detail'][0]['CONDITION_NAME']; ?>" readonly> 
                    <?php $cond_id  = @$data['detail'][0]['CONDITION_ID'];?>
                </div>
              </div>
                <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">LIST PRICE:</label>
                    <input class="form-control" type="text" value="<?php  echo '$ '.number_format((float)@$data['detail'][0]['SALE_PRICE'],2,'.',','); ?>" readonly> 
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">SOLD AVG:</label>
                    <input class="form-control" type="text" value="<?php echo '$ '.number_format((float)@$data['detail'][0]['AVERAGE_PRICE'],2,'.',','); ?>" readonly> 
                  </div>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ITEM URL">ITEM URL:</label>
                    <a target="_blank" href="<?php echo @$data['detail'][0]['ITEM_URL']; ?>"><?php echo @$data['detail'][0]['EBAY_ID']; ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Objects List</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>          
        <div class="box-body">
      <!-- Object Button list -->
        <div class="col-sm-12">
          <div class="col-sm-2 col-sm-offset-4" style="margin-bottom: 15px;">
            <button type="button" id="showAll" title="Show All" value="" class="btn btn-sm btn-primary" style="">SHOW ALL</button>
          </div> 
          <div class="col-sm-2" style="margin-bottom: 15px;">
            <button type="button" id="showSelected" title="Show Selected" value="sss" class="btn btn-sm btn-warning" style="">SHOW SELECTED</button>
          </div> 
          <div class="col-sm-offset-3 col-sm-1" style="margin-bottom: 15px;">
            <button type="button" class="btn btn-default" aria-label="Button Info" data-toggle="modal" data-target="#myModal">
              <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            </button>
          </div> 
        </div>
       <div class="col-sm-12" id="button_section" style="margin-top: 30px!important;">                 
          <?php 
          /*echo "<pre>";
          print_r($data['object_list']);
          echo "<br>";
          print_r($data['standard_kit']);

          exit;*/
          foreach ($data['object_list'] as $value):
              $flages = 0;
                 $auto_kit_object_name = trim(@$value['OBJECT_NAME']);
                 $btn_color           = trim(strtolower(@$value['COLOR']));

                 $button_id = trim(str_replace(" ","_", $value['OBJECT_NAME']));
                  
        
              ?>
                 <div class="col-sm-2" style="margin-bottom: 15px;">
                      <button type="button" id="<?php echo $button_id ?>" title="<?php echo @$value['OBJECT_NAME']; ?>" value="<?php echo @$value['OBJECT_NAME']; ?>" cls="<?php echo @$btn_color?>" class="btn btn-sm btn-block myInput <?php echo @$btn_color?>" style=""><?php echo @$value['OBJECT_NAME']; ?><?php  //echo " (".@$value['OBJECT_COUNT'].")"; ?></button>
                </div>

        <?php endforeach; 
        ?>
        </div>
    </div>
  </div>
  <div class="box">
 <div class="box-body form-scroll">
            <!-- end of ojbect button list -->
             <div class="row">
               <div class="col-sm-1">
                  <div class="form-group" style="font-size: 15px;">
                   <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 update_components pull-left" id="update_components" style="margin-top: 25px;">Update</button>
                </div>
              </div>
              <div class="col-sm-3 ">
              <div class="form-group pull-left"> 
              <label for="stat" class="control-label" style="color: red">Select Status:</label>   
              <?php $get_saved_status= @$data['get_status'][0]['EST_STATUS'];
                     //var_dump($get_saved_status);
                       ?>          
                 <select name="es_status" id = "es_status" class="form-control selectpicker" required="required" data-live-search="true">
                      <option value=''>Select Status </option>

                      <?php      
                          foreach ($data['estimate_status'] as $stat){
                              ?>
                              <option value="<?php echo $stat['FLAG_ID']; ?>" <?php if($get_saved_status == $stat['FLAG_ID']){echo "selected";}?>> <?php echo $stat['FLAG_NAME']; ?> </option>
                              <?php
                             } 
                      
                    ?>  
                                    
                    </select> 

              </div>
            </div>  

            <div class='col-sm-2 hide_component'>
                <label>Discard Remarks:</label>
                <div class="form-group" id="dis_remarks">   
                </div>
              </div> 

            </div>
            <div class="col-sm-12" style="margin-left: 42%; margin-top: 20px;">
              <div class="form-group pull-left" style="width: 80px;">
                  <label for="Checked Components">Checked:</label>
                  <input type="text" name="checked_components" value="0" class="form-control totalChecks" readonly> 
              </div>
              <div class="form-group pull-left" style="width: 80px; margin-left: 22px;">
                  <label for="Checked Components">Total QTY:</label>
                  <input type="text" name="total_component_qty"  id="total_component_qty" value="0" class=" form-control total_qty" readonly>
              </div> 
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Total Sold Price:</label>
                  <input type="text" name="total_sold_price" id="total_sold_price" value="$0.00" class=" form-control total_sold" readonly>
              </div>  
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Total Estimate:</label>
                  <input type="text" name="total_estimate_price" id="total_estimate_price" value="$0.00" class=" form-control total_estimate" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 15px;">
                  <label for="Checked Components">Total Amount:</label>
                  <input type="text" name="total_amount" id="total_amount" value="$0.00" class=" form-control amounts" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Ebay Fee:</label>
                  <input type="text" name="total_ebay_fee" id="total_ebay_fee" value="$0.00" class=" form-control total_ebay" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Paypal:</label>
                  <input type="text" name="total_paypal_fee" id="total_paypal_fee" value="$0.00" class=" form-control total_paypal" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Shipping:</label>
                  <input type="text" name="total_ship_fee" id="total_ship_fee" value="$0.00" class=" form-control total_shipping" readonly>
              </div>
              <div class="form-group pull-left" style="width: 85px; margin-left: 6px;">
                  <label for="Checked Components">Sub Total:</label>
                  <input type="text" name="totalClass" id="totalClass" value="$0.00" class=" form-control totalClass" readonly>
              </div>
            </div>
            <div class="col-sm-12">
              <!-- Custom Tabs -->
              <table id="kit-components-table" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                  <th></th>
                  <th>COMPONENTS</th>
                  <th>MPN</th>
                  <th>MPN DESCRIPTION</th>
                  <th>CONDITIONS</th>
                  <th>SELECT</th>
                  <th>QTY</th>
                  <th style="color: green;">SOLD PRICE</th>
                  <th>ESTIMATED PRICE</th>
                  <th>AMOUNT</th>
                  <th>EBAY FEE</th>
                  <th>PAYPAL FEE</th>
                  <th>SHIP FEE</th>
                  <th>TOTAL</th>
                  <th></th>
                </thead>
                <tbody id="reloa_id">
                  <?php
                  // $comps = $data['components']->result_array();
                  //   echo "<pre>";
                  //   print_r ($comps);
                  //   echo "</pre>";
                  //   exit;
                  $total_avg_prices = 0;
                  $totals = 0;
                  $i=1;
                  if($data['results']->num_rows() > 0)
                  {
                    $comps = $data['components']->result_array();
                   /* echo "<pre>";
                    print_r ($comps);
                    echo "</pre>";
                    exit;*/
                    foreach ($data['results']->result_array() as $result):
                       $component_id = @$result['PART_CATLG_MT_ID'];
                          if(@$data['components']->num_rows() > 0): ?>
                            <tr>
                              <td></td>
                              <?php 
                                $flag= false;
                                $k = 0;
                                foreach ($comps as $comp):
                                  $component_check_id = $comp['PART_CATLG_MT_ID'];
                                  $lz_estimate_id     = $comp['LZ_BD_ESTIMATE_ID'];
                                  
                                    if ($component_id == $component_check_id) {
                                    $cond_name        = $comp['COND_NAME'];
                                    $tech_cond_id     = $comp['TECH_COND_ID'];
                                      $flag= true; 
                                      $index= $k;
                                      $mpn_descript = $comp['MPN_DESCRIPTION'];
                                       break;
                                    }
                                    
                                     $k++;
                                  endforeach; ?> 
                              <td>
                                <?php echo @$result['OBJECT_NAME']; ?>
                                <input type="hidden" name="ct_kit_mpn_id_<?php echo $i; ?>" class="kit_componets" id="ct_kit_mpn_id_<?php echo $i; ?>" value="<?php echo @$result['MPN_KIT_MT_ID']; ?>">
                              </td>
                              <td>
                                <?php echo @$result['MPN']; ?>
                              </td>
                               <td>
                                 <div style="width: 300px;">
                                  <div class="form-group">
                                    <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc<?php echo $i; ?>" value=" <?php if($flag){ echo htmlentities(@$mpn_descript);  }else{echo htmlentities(@$result['MPN_DESCRIPTION']); } ?>" class="form-control kit_mpn_desc" style="width: 300px;">
                                    </div>
                                  </div>
                                </td>
                                <td>
                                  <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                                      <div class="form-group" style="width: 210px;">
                                          <select class="form-control selectpicker estimate_condition"  data-live-search="true" name="estimate_condition" id="estimate_condition_<?php echo $i; ?>" ctmt_id="<?php echo @$result['MPN_KIT_MT_ID']; ?>" rd = "<?php echo $i; ?>"  style="width: 203px;">
                                          <!-- <option value="<?php ///echo @$tech_cond_id ; ?>"><?php ////echo @$cond_name; ?></option> -->
                                            <?php
                                                $condition_ids = $tech_cond_id;                             
                                              foreach(@$data['conditions'] as $type) {
                                              if ($type['ID'] == $condition_ids) {
                                                 $selected = 'selected';
                                               }else {
                                                 $selected = '';
                                               } 
                                                             
                                                  ?>
                                                   <option value="<?php echo $type['ID']; ?>" <?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                                                  <?php
                                                   
                                                  } 

                                               ?> 
                                                                   
                                          </select> 
                                      </div>
                                </td>
                                <?php
                              
                                  if($flag){ ?>
                                    <td>
                                       <div style="width: 70px;">
                                         <input type="checkbox" name="cata_component" ckbx_name="<?php echo @$result['OBJECT_NAME']; ?>" id="component_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes validValue countings" style="width: 60px;" checked>
                                         
                                      </div>
                                    </td>
                                    <td>
                                      <?php 

                                      $quantity = $comps[$index]['QTY']; ?>
                                      
                                      <div class="form-group" style="width:70px;">
                                        <input type="hidden" name="part_catalogue_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                                        <input type="number" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($quantity)){ echo $quantity; }else{ echo 1; } ?>" style="width:60px;">
                                      </div>
                                    </td>
                                    <td>
                                      <?php 
                                      $avg_price = @$result['AVG_PRICE'];
                                      $total_avg_prices += $avg_price;
                                       ?>
                                      <div class="form-group">
                                        <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php echo '$ '.number_format((float)@$avg_price,2,'.',','); ?>" style="width:100px;" readonly>
                                      </div>
                                    </td> 
                                  <td>
                                    <?php 
                                    $est_price_name="cata_est_price_".$i; 
                                    $estimate_price = $comps[$index]['EST_SELL_PRICE'];
                                    ?>
                                    <div class="form-group" style="width:100px;">
                                      <input type="number" name="<?php echo $est_price_name; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php if(!empty($estimate_price)){echo number_format((float)@$estimate_price,2,'.',','); }else{ echo '1.00'; }  ?>" style="width:100px;">
                                    </div>
                                  </td>
                                  <td>
                                    <?php 
                                    $estimate_amount = 0;
                                    $estimate_amount = ($quantity * $comps[$index]['EST_SELL_PRICE']);
                                     ?>
                                     <div class="form-group" style="width:100px;">
                                     <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="<?php echo '$'.number_format((float)@$estimate_amount,2,'.',',');  ?>" style="width:100px;" readonly>
                                    </div>
                                  </td>
                                  <td>
                                    <?php
                                    if (!empty($avg_price)) {
                                          $ebay_fee= ($avg_price  * (8 / 100));
                                        }else {
                                          $ebay_fee= ($estimate_amount  * (8 / 100));
                                        }

                                      ?>
                                    <div class="form-group" style="width:100px;">
                                     <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php echo '$ '.number_format((float)@$ebay_fee,2,'.',','); ?>" style="width:100px;" readonly>
                                    </div>
                                  </td>
                                  <td>
                                    <?php 
                                    $paypal_fee= ($avg_price  * (2.5 / 100));
                                      if (!empty($avg_price)) {
                                        $paypal_fee= ($avg_price  * (2.5 / 100));
                                        }else {
                                          $paypal_fee= ($estimate_amount  * (2.5 / 100));
                                        }
                                     ?>
                                    <div class="form-group" style="width:100px;">
                                      <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php echo '$ '.number_format((float)@$paypal_fee,2,'.',','); ?>" style="width:100px;" readonly>
                                    </div>
                                  </td>
                                  <td>
                                    <div class="form-group">
                                      <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_<?php echo $i; ?>" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:100px;" readonly>
                                    </div>
                                  </td>
                                  <td class="rowDataSd">
                                  <?php
                                    $cahrges = $ebay_fee + $paypal_fee + 3.25;
                                    $total = $estimate_amount + $cahrges;
                                    $totals += $total;
                                    ?>
                                    <p id="cata_total_<?php echo $i; ?>" class="totalRow"><?php if($cahrges!=3.25){ echo '$ '.number_format((float)@$total,2,'.',','); }else {
                                      echo "$0.00";
                                    } ?></p>
                                  </td>
                                  <td>sss</td>

                                <?php  }else{ ?>
                                <td>
                                  <div style="width: 70px;">
                                     <input type="checkbox" name="cata_component" ckbx_name="<?php echo @$result['OBJECT_NAME']; ?>" id="component_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes validValue countings" style="width: 60px;">
                                  </div>
                                </td>
                                <td>
                                  <?php 
                                  $qty = @$result['QTY']; ?>
                                  
                                  <div class="form-group" style="width:70px;">
                                    <input type="hidden" name="part_catalogue_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                                    <input type="number" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($qty)){ echo $qty; }else{ echo 1; } ?>" style="width:60px;">
                                  </div>
                                </td>
                                <td>
                                  <?php 
                                  $avg_price = @$result['AVG_PRICE'];
                                  $total_avg_prices += $avg_price;
                                   ?>
                                  <div class="form-group">
                                    <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php echo '$ '.number_format((float)@$avg_price,2,'.',','); ?>" style="width:100px;" readonly>
                                  </div>
                                </td> 
                                <td>
                                  <?php $est_price_name="cata_est_price_".$i; 
                                  ?>
                                  <div class="form-group" style="width:100px;">
                                    <input type="number" name="<?php echo $est_price_name; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php if(empty($avg_price)){ echo '1.00'; }else { echo  number_format((float)@$avg_price,2,'.',','); } ?>" style="width:100px;">
                                  </div>
                                </td>
                                <td>
                                   <div class="form-group" style="width:100px;">
                                   <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="$1.00" style="width:100px;" readonly>
                                  </div>
                                </td>
                                <td>
                                  <?php
                                  if (!empty($avg_price)) {
                                        $ebay_fee= ($avg_price  * (8 / 100));
                                      }else {
                                        $ebay_fee= ($avg_price  * (8 / 100));
                                      }

                                    ?>
                                  <div class="form-group" style="width:100px;">
                                   <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php echo '$ '.number_format((float)@$ebay_fee,2,'.',','); ?>" style="width:100px;" readonly>
                                  </div>
                                </td>
                                <td>
                                  <?php 
                                  $paypal_fee= ($avg_price  * (2.5 / 100));
                                    if (!empty($avg_price)) {
                                      $paypal_fee= ($avg_price  * (2.5 / 100));
                                      }else {
                                        $paypal_fee= ($avg_price  * (2.5 / 100));
                                      }
                                   ?>
                                  <div class="form-group" style="width:100px;">
                                    <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php echo '$ '.number_format((float)@$paypal_fee,2,'.',','); ?>" style="width:100px;" readonly>
                                  </div>
                                </td>
                                <td>
                                  <div class="form-group">
                                    <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_<?php echo $i; ?>" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:100px;" readonly>
                                  </div>
                                </td>
                                <td class="rowDataSd">
                                  <?php
                                    $cahrges = $ebay_fee + $paypal_fee + 3.25;
                                    $total = $avg_price + $cahrges;
                                    $totals += $total;
                                    ?>
                                    <p id="cata_total_<?php echo $i; ?>" class="totalRow"><?php if($cahrges!=3.25){echo "$ ".$total; }else {
                                      echo "$0.00";
                                    } ?></p>
                                  </td>
                                  <td></td>
                                  <?php   }
                                  ?>
                                  </tr>
                                  <?php

                            $i++;
                          endif;
                    endforeach; 
                    ?>

                  </tbody> 
                  </table>
                  <?php
                  }else { //end main if
                  ?>
                </tbody> 
              </table>              
              <?php
              } ?>
            <!-- nav-tabs-custom -->
            </div>
            <!-- /.col-sm-12--> 
             <div class="col-sm-12" style="margin-left: 42%;">
              <div class="form-group pull-left" style="width: 80px;">
                  <label for="Checked Components">Checked:</label>
                  <input type="text" name="checked_components" value="0" class="form-control totalChecks" readonly> 
              </div>
              <div class="form-group pull-left" style="width: 80px; margin-left: 22px;">
                  <label for="Total QTY">Total QTY:</label>
                  <input type="text" name="total_component_qty"  id="total_component_qty" value="0" class=" form-control total_qty" readonly>
              </div> 
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Total Sold Price">Total Sold Price:</label>
                  <input type="text" name="total_sold_price" id="total_sold_price" value="$0.00" class=" form-control total_sold" readonly>
              </div>  
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Total Estimate">Total Estimate:</label>
                  <input type="text" name="total_estimate_price" id="total_estimate_price" value="$0.00" class=" form-control total_estimate" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 15px;">
                  <label for="Total AmountChecked Components">Total Amount:</label>
                  <input type="text" name="total_amount" id="total_amount" value="$1.00" class=" form-control amounts" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Total Ebay Fee">Total Ebay Fee:</label>
                  <input type="text" name="total_ebay_fee" id="total_ebay_fee" value="$0.00" class=" form-control total_ebay" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Total Paypal">Total Paypal:</label>
                  <input type="text" name="total_paypal_fee" id="total_paypal_fee" value="$0.00" class=" form-control total_paypal" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Total Shipping">Total Shipping:</label>
                  <input type="text" name="total_ship_fee" id="total_ship_fee" value="$0.00" class=" form-control total_shipping" readonly>
              </div>
              <div class="form-group pull-left" style="width: 85px; margin-left: 6px;">
                  <label for="Sub Total">Sub Total:</label>
                  <input type="text" name="totalClass" id="totalClass" value="$0.00" class=" form-control totalClass" readonly>
              </div>
            </div>
            <div class="col-sm-12 ">
              <div class="form-group col-sm-2 pull-left">
                <button type="button" title="Add Component"  class="btn btn-primary" id="add_kit_component">Add Component</button>
              </div>
              <input type="hidden" name="countrows" value="<?php echo $i-1; ?>" id="countrows">
              <div class="form-group col-sm-3  pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 update_components" id="update_components">Update</button>
              </div>  
            </div>
          </div>
          <!-- /.box-body -->
        </div>
         <!-- /.box -->
         <div class="box" id="component-toggle" style="display: none;">
            <div class="box-header with-border">
              <h3 class="box-title">Catalogue Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div>
              <div class='col-sm-12 hide-component'>
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="comp_category" id="comp_category" class="form-control selectpicker" data-live-search="true" required>
                      <option value="0">---select---</option>
                      <?php                                
                       if(!empty($getCategories)){
                        foreach ($getCategories as $cat){ 
                        ?>
                          <option value="<?php echo $cat['CATEGORY_ID']; ?>"> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                          <?php
                          } 
                        }  
                      ?>                       
                    </select>  
                  </div>
                </div>
              <div class='col-sm-2 hide-component'>
                <div class="form-group">
                  <label>Object:</label>
                  <div id="comp_objects">
                    
                  </div> 
                </div>
              </div>
              <!-- <div class='col-sm-2 hide-component'>
                <label>Brand:</label>
                <div class="form-group" id="comp_brands">   
                </div>
              </div> -->
              <div class='col-sm-2 hide-component'>
                <label>MPN:</label>
                <div class="form-group" id="comp_mpns">   
                </div>
              </div>
               <div class='col-sm-2 hide-component component_upc'>
                <label>UPC:</label>
                <div class="form-group" id="component_upc">   
                </div>
              </div>                                                
              <div class="col-sm-1 hide-component">
                <div class="form-group p-t-24">
                  <input type="button" class="btn btn-success" name="save_mpn_kit" id="save_mpn_kit" value="Save">
                </div>
              </div>
              <div class="form-group col-sm-1 p-t-24 hide-component">
                 <button type="button" title="Add MPN"  class="btn btn-warning add_mpn" id="add_mpn">Add MPN</button>
              </div>
              <!-- MPN Block end -->
            </div>
            <div id="add_mpn_section" style="display: none;">
              <div class="col-sm-12">
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="Conditions" class="control-label">Category:</label> 
                        <input class="form-control" type="text" name="mpn_category" id="mpn_category" value="" required>  
                      </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="NEW OBJECT">OBJECT NAME :</label>
                      <input class="form-control" type="text" name="mpn_object" id="mpn_object" value="" required>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="form-group">
                      <label for="MPN BRAND">BRAND:</label>
                      <input class="form-control" type="text" name="mpn_brand" id="mpn_brand" value="" required>
                    </div>
                  </div> 
                   <div class="col-sm-3">
                    <div class="form-group">
                      <label for="UPC">UPC:</label>
                      <input class="form-control" type="text" name="comp_upc" id="comp_upc" value="" required>
                    </div>
                  </div>
                  </div> 
                  <div class="col-sm-12" style="margin-top: 15px;"> 
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="MPN">MPN:</label>
                        <input class="form-control" type="text" name="new_mpn" id="new_mpn" value="" required>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="">Title:</label>Maximum of 80 characters - 
                        <span id="charNum" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left</span><br/>

                          <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onkeyup="countChar(this)"  value="">
                      </div>
                    </div> 
                    <div class="col-sm-1">
                      <div class="form-group p-t-26">
                        <input type="button" id="add_new_mpn" name="add_new_mpn" value="Save" class="btn btn-success">
                      </div>
                    </div>
                    <div class="col-sm-1">
                      <div class="form-group p-t-26">
                        <input type="button" id="go_back" name="go_back" value="Go Back" class="btn btn-primary">
                      </div>
                    </div>
                  </div> 
              </div>
            </div> <!-- end toggle component -->
           </div>
          </div>
         <!-- second block  Catalogue Detail start --> 
        <!-- COMPONENCT SERACH START --> 
          <div class="box" id="search_components">
            <div class="box-header with-border">
              <h3 class="box-title">Search Component</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">             
              <div class="col-sm-12">
                <div class="col-sm-3">
                <label for="search_component">Search Component:</label>
                  <div class="form-group">
                    <input type="text" class="form-control" name="input_text" id="input_text" placeholder="Enter Keyword" >
                  </div>
                </div>
                <!-- <div class="col-sm-2">
                <label for="search_component">MPN:</label>
                  <div class="form-group">
                    <input type="text" class="form-control" name="input_mpn" id="input_mpn" placeholder="Enter Part MPN">
                  </div>
                </div> -->
                <div class="col-sm-2">
                <label for="search_component">Object Name:</label>
                  <div class="form-group">
                    <input type="text" class="form-control" name="object_name" id="object_name" placeholder="Enter Object Name">
                  </div>
                </div>
                <div class="col-sm-2">
                <label for="data_source">Data Source:</label>
                  <div class="form-group ">
                    <label for="sold_radio">Sold:</label> 
                    <input type="radio" class="" name="data_source" id="CATAG" value="Sold" checked>
                    <label for="active_radio">Active:</label>
                    <input type="radio" class="" name="data_source" id="ACTIVE" value="Active">
                  </div>
                </div>
                <div class="col-sm-2">
                <label for="data_source">Data Status:</label>
                  <div class="form-group ">
                    <label for="verified_radio">Verified:</label> 
                    <input type="radio" class="" name="data_status" id="1" value="Sold" checked>
                    <label for="unverified_radio">Un-Verified:</label>
                    <input type="radio" class="" name="data_status" id="0" value="Active">
                  </div>
                </div>  
                <div class="col-sm-1 p-t-24">
                    <div class="form-group ">
                      <input type="button" class="btn btn-primary btn-sm" name="search_component" id="search_component" value="Search">
                    </div>
                </div>
              </div>
              
                
             
            <!-- start of catalogue detail part -->
            <div class="col-md-12">
              <form>
              <table id="search_component_table" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                   <tr>
                    <th>ACTION</th>
                    <th>OBJECT NAME</th>
                    <th>CATEGORY ID</th>
                    <th>ITEM DESCRIPTION</th>
                    <th>MPN</th>
                    <th>ACTIVE PRICE</th>
                    
                  </tr>
                </thead>
              </table>
            </form>
            </div><!-- /.col --> 
          </div>
        </div>
        <!-- /.box -->
        <!-- second block start -->   
      <!-- /.row -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Button's Guidline</h4>
      </div>
       <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr class="table-warning">
              <th>Standard Kit</th>
              <th>Autokit</th>
              <th>Selected</th>
              <th>Button</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: red; font-size: 18px; font-weight: 600;"><b><i class="fa fa-times" aria-hidden="true"></i></b></p></td>
              <td><p style="font-size: 18px; font-weight: 600;"><b>N/A</b></p></td>
              <td><p style="color: red; font-size: 18px; font-weight: 600;"><b>Red</b></p></td>
            </tr>
            <tr>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: red; font-size: 18px; font-weight: 600;"><b><i class="fa fa-times" aria-hidden="true"></i></b></p></td>
              <td><p style="color: grey; font-size: 18px; font-weight: 600;"><b>Grey</b></p></td>
            </tr>
            <tr>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b>Green</i></b></p></td>
            </tr>
            <tr>
              <td><p style="color: red; font-size: 18px; font-weight: 600;"><b><i class="fa fa-times" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: #696969; font-size: 18px; font-weight: 600;"><b>Light Grey</b></p></td>
            </tr>
             <tr>
              <td><p style="color: red; font-size: 18px; font-weight: 600;"><b><i class="fa fa-times" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: green; font-size: 18px; font-weight: 600;"><b><i class="fa fa-check" aria-hidden="true"></i></b></p></td>
              <td><p style="color: #5cb85c; font-size: 18px; font-weight: 600;"><b>Light Green</b></p></td>
            </tr>

          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
   function countChar(val) {
    var len = val.value.length;
    //console.log(len);
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(80 - len);
    }
  }
  
$(document).ready(function(){
  $('.hide_component').hide();
     var table = $('#kit-components-table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "fixedHeader": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    // "order": [[ 16, "ASC" ]],
    "columnDefs": [
        { className: "textColor", "targets": [ 14 ] }
      ],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });

    // Setup - add a text input to each footer cell
      ///////////////////INDIVIDUAL ECOLUMN SEARCH END////////////////////////////
    $('#kit-components-table tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
  /*  var table = $('#kit-components-table').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );*/
    ///////////////////INDIVIDUAL ECOLUMN SEARCH END////////////////////////////

   $('.myInput').on( 'click', function () {
        table.search( this.value ).draw();
    } );
    $('#showAll').on( 'click', function (){
        table.search( this.value ).draw();
    });   
     $('#showSelected').on( 'click', function () {
        table.search( this.value ).draw();
    } ); 

  // $('#kit-components-table tr').each(function(){
  //   $(this).closest('tr').find('input.component_qty, input.cata_avg_price,input.cata_est_price,input.cata_ebay_fee,input.cata_paypal_fee,input.cata_ship_fee,.totalRow').prop('disabled', true);
  // });
// function disableRow(){
//   $(this).closest('tr').find('input.component_qty, input.cata_avg_price,input.cata_est_price,input.cata_ebay_fee,input.cata_paypal_fee,input.cata_ship_fee,.totalRow').prop('disabled', true);
// }
  /*==================================================
  =            FOR SHOWING CATALOGUE DETAIL          =
  ===================================================*/
  $("#copy_catalogues").on('click', function(event) {
    event.preventDefault();
     var dataTable = $('#catalogue-detail-table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
      // For stop ordering on a specific column
      // "columnDefs": [ { "orderable": false, "targets": [0] }],
      "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
       "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      // "bAutoWidth": false,
      "ajax":{
        url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
  });
 
 /*  $('#kit-components-table').append('<tr> <td></td> <td ></td> <td ></td><td></td><td></td><td><label>Checked: </label><p class="totalChecks"></p></td> <td> <label>Total Qty : </label> <div class="form-group"> <input type="text" name="total_component_qty" id="total_component_qty_1" class="form-control input-sm total_qty" value="0.00" style="width:80px;" readonly> </div> </td> <td><label>Total Sold Price:</label><div class="form-group"> <input type="text" name="total_sold_price" id="total_sold_price" class="form-control input-sm total_sold" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Estimate: </label><div class="form-group"> <input type="text" name="total_estimate_price" id="total_estimate_price" class="form-control input-sm total_estimate" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Amount: </label><div class="form-group"> <input type="text" name="total_amount" id="total_amount" class="form-control input-sm amounts" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Ebay Fee: </label><div class="form-group"> <input type="text" name="total_ebay_fee" id="total_ebay_fee" class="form-control input-sm total_ebay" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Paypal:</label><div class="form-group"> <input type="text" name="total_paypal_fee" id="total_paypal_fee" class="form-control input-sm total_paypal" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Shipping:</label><div class="form-group"> <input type="text" name="total_ship_fee" id="total_ship_fee" class="form-control input-sm total_shipping" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Sub Total:</label><p class="totalClass"/></p></td> </tr>');*/

  $(document).on('change', '#es_status', function(){
  var es_status = $('#es_status').val();  

      if (es_status == 20) 
      { 
      $('.hide_component').show();
      $.ajax({
      url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_status_remarks',
      type:'post',
      dataType:'json',
      
      success:function(data){
        console.log(data);
       // return false;
        var flag = [];
         // alert(data.length);return false;
        for(var i = 0;i<data.get_flag.length;i++){
          flag.push('<option value="'+data.get_flag[i].FLAG_ID+'">'+data.get_flag[i].FLAG_NAME+'</option>')
        }
        $('#dis_remarks').html("");
        $('#dis_remarks').append('<select name="discard_remarks" id="discard_remarks" class="form-control discard_remarks selectpicker" data-live-search="true" required><option value="">---select---</option>'+flag.join("")+'</select>');
        $('.discard_remarks').selectpicker();
      },
       complete: function(data){
        $(".loader").hide();
      },
        error: function(jqXHR, textStatus, errorThrown){
           $(".loader").hide();
          if (jqXHR.status){
            alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          }
      }
    }); 
    }else{
      $('#dis_remarks').html("");
      $('.hide_component').hide();
    }//end if check for status 20 
});

  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
 $(".update_components").click(function(){
  $('#showAll').click();
    //this.disabled = true;
    var es_status = $('#es_status').val();  
    var discard_remarks = $('#discard_remarks').val();  

      if (es_status == '') 
      { 
        alert('Please Select Estimate Status'); 
        return false;
      }

      if (discard_remarks == '') 
      { 
        alert('Please Select Discard Remarks'); 
        return false;
      }

    var fields = $("input[name='cata_component']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }  
      var arr=[];
      var estimate_id               = '<?php echo $lz_estimate_id; ?>';
      var catalogue_mt_id                  = '<?php echo $this->uri->segment(5); ?>';
      var catag_id                  = '<?php echo $this->uri->segment(6); ?>';
      var url                       ='<?php echo base_url() ?>catalogueToCash/c_purchasing/updateKitComponents';
      var compName                  = [];
      var compQty                   = [];
      var compAvgPrice              = [];
      var estimate_price            = [];
      var ebayFee                   = [];
      var payPalFee                 = [];
      var shipFee                   = [];
      var part_catalogue_mt_id      = [];
      var tech_condition            = [];
      var kit_mpn_desc               = [];
      var flag                      = [];


      var tableId="kit-components-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='cata_component']:checked"), function()
      {            
        arr.push($(this).val());
      });
       for (var i = 0; i < arr.length; i++)
          {
            $(tdbk.rows[arr[i]]).find(".kit_componets").each(function() {
                    compName.push($(this).val());
                  });
            $(tdbk.rows[arr[i]]).find(".part_catlg_mt_id").each(function() {
                    part_catalogue_mt_id.push($(this).val());
                  }); 

             $(tdbk.rows[arr[i]]).find(".estimate_condition").each(function() {
            
              if ($(this).val() == '') {

                flag.push($(this).val());
              }else {
                tech_condition.push($(this).val());
              }
            });

             $(tdbk.rows[arr[i]]).find(".component_qty").each(function() {
                    compQty.push($(this).val());
                  }); 

              $(tdbk.rows[arr[i]]).find('.cata_avg_price').each(function() {
                compAvgPrice.push($(this).val());
              }); 

              $(tdbk.rows[arr[i]]).find('.cata_est_price').each(function(){
                if ($(this).val() == 0 || $(this).val() == 00 || $(this).val() == 0. || $(this).val() == 0.0 || $(this).val() == 0.00 || $(this).val() == 0.000) {
                  
                }else {
                 estimate_price.push($(this).val()); 
                }
              });

              $(tdbk.rows[arr[i]]).find('.cata_ebay_fee').each(function(){
                ebayFee.push($(this).val());
              });
              $(tdbk.rows[arr[i]]).find('.kit_mpn_desc').each(function(){
                kit_mpn_desc.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_paypal_fee').each(function(){
                payPalFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_ship_fee').each(function(){
                shipFee.push($(this).val());
              });           
          }
           tech_condition = tech_condition.filter(v=>v!='');
           kit_mpn_desc = kit_mpn_desc.filter(v=>v!='');
          //console.log(tech_condition, kit_mpn_desc); return false;
          ///console.log(estimate_id); return false;
        if (tech_condition.length < payPalFee.length) {
            alert("Warning: Please select condition for each component");
            return false;
         }else if (estimate_price.length < shipFee.length) {
            alert("Warning: Please Insert Estimate Price of Selected Components");
            return false;
          }else if (kit_mpn_desc.length < shipFee.length) {
            alert("Warning: MPN Description is required for all selected components.");
            return false;
          }else {
            $(".loader").show();
            $.ajax({
              type: 'POST',
              url:url,
              data: {
                'estimate_id': estimate_id,
                'catag_id': catag_id,
                'catalogue_mt_id': catalogue_mt_id,
                'compName': compName,
                'compQty': compQty,
                'kit_mpn_desc': kit_mpn_desc,
                'compAvgPrice': compAvgPrice,
                'estimate_price': estimate_price,
                'ebayFee': ebayFee,
                'payPalFee': payPalFee,
                'shipFee': shipFee,
                'part_catalogue_mt_id': part_catalogue_mt_id,
                'tech_condition':tech_condition,
                'es_status':es_status,
                'discard_remarks':discard_remarks
              },
              dataType: 'json',
              success: function (data){
                   if(data == 0){
                      alert('Warning: Kit updation failed!');
                   }else if(data == 1){
                         alert("Success: Kit is updated!");
                         window.location.reload();   
                   }else if(data == 2){
                      alert("Warning: This kit has posted");
                   }
                 },
              complete: function(data){
                $(".loader").hide();
              },
            error: function(jqXHR, textStatus, errorThrown){
            $(".loader").hide();
            if (jqXHR.status){
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
    }
          });
         } 
  });
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/

   function displayEstimate(){
        var cat_id                    = '<?php echo $this->uri->segment(4); ?>';
        var mpn_id                    = '<?php echo $this->uri->segment(5); ?>';
        var dynamic_cata_id           = '<?php echo $this->uri->segment(6); ?>';
        //console.log(cat_id, mpn_id, dynamic_cata_id); return false;
      $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '<?php echo base_url(); ?>catalogueToCash/c_purchasing/getEstimateData',
        data: {
            'cat_id': cat_id,
            'lz_bd_cata_id': dynamic_cata_id,
            'mpn_id': mpn_id  
              },
        success: function (data){
          //console.log(data); return false;
        var total_check       = data.TOTAL_CHECK;
        var total_qty         = data.TOTAL_QTY;
        var est_price         = data.EST_PRICE;
        var est_amount        = data.ESTIMATE_AMOUNT;
        var paypal_fee        = data.PAYPAL_FEE;
        var shiping_fee       = data.SHIPING_FEE;
        var ebay_fee          = data.EBAY_FEE;
        var sold_price        = data.SOLD_PRICE;
        var sub_total = parseFloat(parseFloat(est_amount) + parseFloat(ebay_fee) + parseFloat(paypal_fee) + parseFloat(shiping_fee)).toFixed(2);
        $(".totalChecks").val(total_check);
        $(".total_qty").val(total_qty);
        $(".total_sold").val('$'+parseFloat(sold_price).toFixed(2));
        $(".total_estimate").val('$'+parseFloat(est_price).toFixed(2));
        $(".amounts").val('$'+parseFloat(est_amount).toFixed(2));
        $(".total_ebay").val('$'+parseFloat(ebay_fee).toFixed(2));
        $(".total_ebay").val('$'+parseFloat(ebay_fee).toFixed(2));
        $(".total_paypal").val('$'+parseFloat(paypal_fee).toFixed(2));
        $(".total_shipping").val('$'+parseFloat(shiping_fee).toFixed(2));
        $(".totalClass").val('$'+parseFloat(sub_total).toFixed(2));
        },
        error: function(jqXHR, textStatus, errorThrown){
          $(".loader").hide();
          if (jqXHR.status){
            alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          }
    }
      });
    }
    displayEstimate();
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
//   $(document).on('change','.checkboxes', function(){
//   //var id = this.id.match(/\d+/);
//   var id = this.id;
//   var checkbox = $(this).prop('checked');
//   var componenet_name =  $(this).attr("ckbx_name");
//   //console.log(id, checkbox, componenet_name); 

//   if(checkbox == true){
//     $('.validValue').each(function(){   //.prop('disabled',false);
//       //console.log('jjj');
//        var id2 = this.id;
//        var componenet_name2 =  $('#'+id2).attr("ckbx_name");
//        //console.log(id2, componenet_name2);
//       if(componenet_name2 == componenet_name && id == id2){
//         $('#'+id).prop('disabled',false);
//         $('#'+componenet_name2).addClass('btn-success').removeClass('btn-primary');  

//       }else if(componenet_name2 == componenet_name && id != id2){
//         $('#'+id2).prop('disabled',true);
//         $('#'+id2).prop('checked',false);
//         $('#'+id2).closest('tr').removeClass('row-green');

//       }
      
//     });
//     }else{
//     $('.validValue').each(function(){   //.prop('disabled',false);
//        id2 = this.id;
//        var componenet_name2 =  $('#'+id2).attr("ckbx_name");

//       if(componenet_name2 == componenet_name){
//         //console.log("hello");
//         $('#'+id2).prop('disabled',false);    
//       }
      
//     });
//    }
// });

  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE  AND   FOR ADDING KIT COMPONENTS     =
  ===========================================================*/ 
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('click','.countings', function(){
    var table = $('body #kit-components-table').DataTable();
    var bg_class            = this.id; 
    var est_id              = $(this).val();

    var componenet_btn =  $(this).attr("ckbx_name").replace(/\ /g, '_');
    var button_class = $("#"+componenet_btn).attr('cls'); 
    var current_check       = $(this).prop("checked");
    //console.log(total_check, total_qty, total_solds, qty, sold_price); //return false;
    if (current_check) {
      $("#"+bg_class).closest('tr').addClass('row-color');
       if (button_class === 'grey-color'  || button_class === 'color-red') {
           $('#'+componenet_btn).addClass('btn-success').removeClass('grey-color');
        }else if(button_class === 'light-grey'){
          $('#'+componenet_btn).addClass('light-green').removeClass('light-grey');
        }

      table.cell( $(this).closest('tr'), 14 ).data('sss');
      $("#cata_component_qty_"+est_id).prop('readonly', true);
      $("#cata_est_price_"+est_id).prop('readonly', true);
      $("#estimate_condition_"+est_id).attr("disabled", true); 
    }else{
      $("#"+bg_class).closest('tr').removeClass('row-color');
      table.cell( $(this).closest('tr'), 14 ).data('');

       if (button_class == 'grey-color'  || button_class == 'color-red') {
           $('#'+componenet_btn).addClass('grey-color').removeClass('btn-success');
        }else if(button_class == 'light-grey'){
          $('#'+componenet_btn).addClass('light-grey').removeClass('light-green');
        }
        
      $("#"+bg_class).closest('tr').css('backgroundColor', '');
      $("#cata_component_qty_"+est_id).prop('readonly', false);
      $("#cata_est_price_"+est_id).prop('readonly', false);
      $("#estimate_condition_"+est_id).attr("disabled", false);  
    }
  });
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('change','.checkboxes', function(){
    var table = $('body #kit-components-table').DataTable();
  //var id = this.id.match(/\d+/);
  var id = this.id;
  var checkbox = $(this).prop('checked');
  var componenet_name =  $(this).attr("ckbx_name");
  var componenet_btn =  $(this).attr("ckbx_name").replace(/\ /g, '_');
  var button_class = $("#"+componenet_btn).attr('cls'); 
  //console.log(button_class, componenet_name, componenet_btn); return false;
  //////////////////////////////////////////////////
      var est_id              = $(this).val();
      var total_check         = $(".totalChecks").val();
      var total_qty           = $(".total_qty").val();
      var total_solds         = $(".total_sold").val().replace(/\$/g, '').replace(/\ /g, '');
      var total_estimates     = $(".total_estimate").val().replace(/\$/g, '').replace(/\ /g, '');
      var amounts             = $(".amounts").val().replace(/\$/g, '').replace(/\ /g, '');
      var total_ebay          = $(".total_ebay").val().replace(/\$/g, '').replace(/\ /g, '');
      var total_paypal        = $(".total_paypal").val().replace(/\$/g, '').replace(/\ /g, '');
      var total_shipping      = $(".total_shipping").val().replace(/\$/g, '').replace(/\ /g, '');
      var current_totals      = $(".totalClass").val().replace(/\$/g, '').replace(/\ /g, '');


      var qty                 = $("#cata_component_qty_"+est_id).val();
      var est_price           = $("#cata_est_price_"+est_id).val();
      var sold_price          = $("#cata_avg_price_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
      var cata_amount         = $("#cata_amount_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
      var ebay_fee            = $("#cata_ebay_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
      var paypal_fee          = $("#cata_paypal_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
      var ship_fee            = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
      var row_total           = $("#cata_total_"+est_id).text().replace(/\$/g, '').replace(/\ /g, '');
  /////////////////////////////////////////////////

  if(checkbox == true){
    $('.validValue').each(function(){   //.prop('disabled',false);
      //console.log('jjj');
       var id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");
       var componenet_btn2 =  $('#'+id2).attr("ckbx_name").replace(/\ /g, '_');
       //console.log(id2, componenet_name2);
      if(componenet_name2 == componenet_name && id == id2){
        $('#'+id2).prop('disabled',false);
        if (button_class == 'grey-color' || button_class == 'color-red') {
           $('#'+componenet_btn2).addClass('btn-success').removeClass('grey-color');
        }else if(button_class == 'light-grey'){
          $('#'+componenet_btn2).addClass('light-green').removeClass('light-grey');
        }
       
        /////////////////////////////////////////////
        total_check           = parseFloat(total_check) + 1;
        total_qty             = parseFloat(parseFloat(total_qty) + parseFloat(qty));
        solds                 = parseFloat(parseFloat(total_solds) + parseFloat(sold_price)).toFixed(2);
        estimates             = parseFloat(parseFloat(total_estimates) + parseFloat(est_price)).toFixed(2);
        amounts               = parseFloat(parseFloat(amounts) + parseFloat(cata_amount)).toFixed(2);
        total_ebays           = parseFloat(parseFloat(total_ebay) + parseFloat(ebay_fee)).toFixed(2);
        paypal_fee            = parseFloat(parseFloat(total_paypal) + parseFloat(paypal_fee)).toFixed(2);
        total_shipping        = parseFloat(parseFloat(total_shipping) + parseFloat(ship_fee)).toFixed(2);
        sub_total             = parseFloat(parseFloat(current_totals) + parseFloat(row_total)).toFixed(2);
        ///////////////////////////////////////////// 

      }else if(componenet_name2 == componenet_name && id != id2){
        var dubplicat_checkbox = $('#'+id2).prop('checked');
        if (dubplicat_checkbox == true) {
          /////////////////////////////////////////////
          total_check           = parseFloat(total_check) - 1;
          total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
          solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
          estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
          amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
          total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
          paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
          total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
          sub_total             =  parseFloat(parseFloat(current_totals) - parseFloat(row_total)).toFixed(2);


          /////////////////////////////////////////////////////////////////////////////////////////////
        $('#'+id2).prop('disabled',true);
        $('#'+id2).prop('checked',false);

        $('#'+id2).closest('tr').removeClass('row-color');
        table.cell( $(this).closest('tr'), 14 ).data('');
         
        }
        
         $('#'+id2).prop('disabled',true);
        $('#'+id2).prop('checked',false);

        $('#'+id2).closest('tr').removeClass('row-color');
        table.cell( $(this).closest('tr'), 14 ).data('');
        var dubplicat_checkbox = $('#'+id2).prop('checked');
      }
      
    });
    }else{
    $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");

       var dubplicat_checkbox = $('#'+id2).prop('checked');

      if(componenet_name2 == componenet_name && dubplicat_checkbox == true){
        $('#'+id2).closest('tr').removeClass('row-color');
        $('#'+id2).prop('disabled',false);
        $('#'+id2).prop('checked',false);
         total_check           = parseFloat(total_check) - 1;
          total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
          solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
          estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
          amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
          total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
          paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
          total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
          sub_total             =  parseFloat(parseFloat(current_totals) - parseFloat(row_total)).toFixed(2);
            //console.log("hello");  
             if (button_class == 'grey-color'  || button_class == 'color-red') {
               $('#'+componenet_btn).addClass('grey-color').removeClass('btn-success');
            }else if(button_class == 'light-green'){
              $('#'+componenet_btn).addClass('light-grey').removeClass('light-green');
            }  

      }else if(componenet_name2 == componenet_name) {
        $('#'+id2).prop('disabled',false);
        $('#'+id2).prop('checked',false);
           if (button_class == 'grey-color'  || button_class == 'color-red') {
             $('#'+componenet_btn).addClass('grey-color').removeClass('btn-success');
          }else if(button_class == 'light-green'){
            $('#'+componenet_btn).addClass('light-grey').removeClass('light-green');
          }
      }
      
    });
    ////////////////////////////////////////////////////////////
      total_check           = parseFloat(total_check) - 1;
      total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
      sub_total             = parseFloat(parseFloat(current_totals) - parseFloat(row_total)).toFixed(2);

      //////////////////////////////////////////////////////////////
   }
     $(".totalChecks").val(total_check);
     $(".total_qty").val(total_qty);
     $(".total_sold").val('$'+solds);
     $(".total_estimate").val('$'+estimates);
     $(".amounts").val('$'+amounts);
     $(".total_ebay").val('$'+total_ebays);
     $(".total_paypal").val('$'+paypal_fee);
     $(".total_shipping").val('$'+total_shipping);
     $(".totalClass").val('$'+sub_total);

});
   /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/
/*var indexesToCalculate = [];
 $(document).on('change','.countings',function(){
    var bg_id               = this.id;
    var est_id              = $(this).val();
    var current_check       = $(this).prop("checked");
    var componenet_name     =  $(this).attr("ckbx_name").replace(/\//g, 'ZZZ').replace(/\&/g, 'AAA');   
    var tableData = $('#kit-components-table').DataTable(); 
    var id = this.id;
    var checkbox = tableData.$(this).prop('checked');
    // var componenet_name =  $(this).attr("ckbx_name");
    //console.log(id, checkbox, componenet_name); 

    if(checkbox == true){
      tableData.$('.validValue').each(function(){   //.prop('disabled',false);
        //console.log('jjj');
         var id2 = this.id;
         var componenet_name2 =  tableData.$('#'+id2).attr("ckbx_name");
         //console.log(id2, componenet_name2);
        if(componenet_name2 == componenet_name && id == id2){
          tableData.$('#'+id).prop('disabled',false);
          tableData.$('#'+componenet_name2).addClass('btn-success').removeClass('btn-primary');  

        }else if(componenet_name2 == componenet_name && id != id2){
          tableData.$('#'+id2).prop('disabled',true);
          tableData.$('#'+id2).prop('checked',false);
          tableData.$('#'+id2).closest('tr').removeClass('row-green');

        }
        
      });
      }else{
        tableData.$('.validValue').each(function(){   //.prop('disabled',false);
           id2 = this.id;
           var componenet_name2 =  tableData.$('#'+id2).attr("ckbx_name");

          if(componenet_name2 == componenet_name){
            //console.log("hello");
            tableData.$('#'+id2).prop('disabled',false);    
          }
          
        });
       }     


    if(current_check == true){
        tableData.$("#"+bg_id).closest('tr').addClass('row-yellow');
        tableData.$("#cata_component_qty_"+est_id).prop('readonly', true);
        tableData.$("#cata_est_price_"+est_id).prop('readonly', true);
        tableData.$("#estimate_condition_"+est_id).attr("readonly", true);


        var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;

        var sumChecks = 0;
        sumChecks = parseInt(sumChecks);
        var currChecks = 0; 

        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 

        var sumEst = 0;
        sumEst = parseFloat(sumEst);
        var currEst = 0; 

        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 


        var sumEbay = 0;
        sumEbay = parseFloat(sumEbay);
        var currEbay = 0;        

        var sumPaypal = 0;
        sumPaypal = parseFloat(sumPaypal);
        var currPaypal = 0;     

        var sumShip = 0;
        sumShip = parseFloat(sumShip);
        var currShip = 0;    

        var sumLineTotal = 0;
        sumLineTotal = parseFloat(sumLineTotal);
        var currLineTotal = '';               

        for(var i=0;i<indexesToCalculate.length;i++){
          //total   quantitty
          currQty = $('#cata_component_qty_'+indexesToCalculate[i]).val();
          sumQty += parseInt(currQty);
          //---end --- total quantity.

           //total   checks
          if( $("#component_check_"+indexesToCalculate[i]).prop("checked") == true){
            currChecks = 1;
          }
          sumChecks += parseInt(currChecks);

          //--total   checks

          //--Sum Sold---//
          currSold = $("#cata_avg_price_"+indexesToCalculate[i]).val();
          currSold = currSold.substring(1, currSold.length);
          sumSold += parseFloat(currSold);     

          //--End Sum Sold---//

          //--- sum estimate --//

          currEst = $("#cata_est_price_"+indexesToCalculate[i]).val();
          sumEst += parseFloat(currEst);
          

          //-- end estimate --//

          //--Sum Amount --//

          currAmount = $("#cata_amount_"+indexesToCalculate[i]).val();
          currAmount = currAmount.substring(1, currAmount.length);
          sumAmount += parseFloat(currAmount);


          //--End sum Amount --//

          //--Sum Ebay -- //

          currEbay = tableData.$("#cata_ebay_fee_"+indexesToCalculate[i]).val();
          currEbay = currEbay.substring(1, currEbay.length);
          sumEbay += parseFloat(currEbay);          
          //--end Sum Ebay --//

          //-- sum paypal--//
          currPaypal = tableData.$("#cata_paypal_fee_"+indexesToCalculate[i]).val();
          currPaypal = currPaypal.substring(1, currPaypal.length);
          sumPaypal += parseFloat(currPaypal);          

          //-- end sum paypal--//

          //-- sum ship--//

          currShip = tableData.$("#cata_ship_fee_"+indexesToCalculate[i]).val();
          currShip = currShip.substring(1, currShip.length);
          sumShip += parseFloat(currShip);          

          //--end sum ship--//

          //--Sum line Total --//
          currLineTotal = tableData.$("#cata_total_"+indexesToCalculate[i]).text();
          currLineTotal = currLineTotal.substring(1, currLineTotal.length);
          sumLineTotal += parseFloat(currLineTotal);          
          //-- -- //

         
        } 

        sumQty.toFixed(2);
        $(".total_qty").val(sumQty);

        sumChecks.toFixed(2);
        $(".totalChecks").val(sumChecks);        

        sumSold = sumSold.toFixed(2);
        $(".total_sold").val('');
        $(".total_sold").val('$'+sumSold);

        sumEst = sumEst.toFixed(2);
        $(".total_estimate").val('') ;
        $(".total_estimate").val('$'+sumEst);

        sumAmount = sumAmount.toFixed(2);
        $(".amounts").val('') ;
        $(".amounts").val('$'+sumAmount);

        sumEbay = sumEbay.toFixed(2);
        $(".total_ebay").val('') ;
        $(".total_ebay").val('$'+sumEbay); 

        sumPaypal = sumPaypal.toFixed(2);
        $(".total_paypal").val('') ;
        $(".total_paypal").val('$'+sumPaypal);  

        sumShip = sumShip.toFixed(2);
        $(".total_shipping").val('') ;
        $(".total_shipping").val('$'+sumShip); 

        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);                

                              
    }else{

        tableData.$("#"+bg_id).closest('tr').removeClass('row-yellow');
        tableData.$("#"+bg_id).closest('tr').removeClass('row-green');
        tableData.$("#cata_component_qty_"+est_id).prop('readonly', false);
        tableData.$("#cata_est_price_"+est_id).prop('readonly', false);
        tableData.$("#estimate_condition_"+est_id).attr("readonly", false);

        indexesToCalculate = jQuery.grep(indexesToCalculate, function(value) {
      
        return value != est_id;
      });
        // indexesToCalculate.pop(est_id);

        var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;

        var sumChecks = 0;
        sumChecks = parseInt(sumChecks);
        var currChecks = 0; 

        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 

        var sumEst = 0;
        sumEst = parseFloat(sumEst);
        var currEst = 0; 

        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 


        var sumEbay = 0;
        sumEbay = parseFloat(sumEbay);
        var currEbay = 0;        

        var sumPaypal = 0;
        sumPaypal = parseFloat(sumPaypal);
        var currPaypal = 0;     

        var sumShip = 0;
        sumShip = parseFloat(sumShip);
        var currShip = 0;    

        var sumLineTotal = 0;
        sumLineTotal = parseFloat(sumLineTotal);
        var currLineTotal = '';               

        for(var i=0;i<indexesToCalculate.length;i++){
          //total   quantitty
          currQty = $('#cata_component_qty_'+indexesToCalculate[i]).val();
          sumQty += parseInt(currQty);
          //---end --- total quantity.

           //total   checks
          if( $("#component_check_"+indexesToCalculate[i]).prop("checked") == true){
            currChecks = 1;
          }
          sumChecks += parseInt(currChecks);

          //--total   checks

          //--Sum Sold---//
          currSold = $("#cata_avg_price_"+indexesToCalculate[i]).val();
          currSold = currSold.substring(1, currSold.length);
          sumSold += parseFloat(currSold);     

          //--End Sum Sold---//

          //--- sum estimate --//

          currEst = $("#cata_est_price_"+indexesToCalculate[i]).val();
          sumEst += parseFloat(currEst);
          

          //-- end estimate --//

          //--Sum Amount --//

          currAmount = $("#cata_amount_"+indexesToCalculate[i]).val();
          currAmount = currAmount.substring(1, currAmount.length);
          sumAmount += parseFloat(currAmount);


          //--End sum Amount --//

          //--Sum Ebay -- //

          currEbay = tableData.$("#cata_ebay_fee_"+indexesToCalculate[i]).val();
          currEbay = currEbay.substring(1, currEbay.length);
          sumEbay += parseFloat(currEbay);          
          //--end Sum Ebay --//

          //-- sum paypal--//
          currPaypal = tableData.$("#cata_paypal_fee_"+indexesToCalculate[i]).val();
          currPaypal = currPaypal.substring(1, currPaypal.length);
          sumPaypal += parseFloat(currPaypal);          

          //-- end sum paypal--//

          //-- sum ship--//

          currShip = tableData.$("#cata_ship_fee_"+indexesToCalculate[i]).val();
          currShip = currShip.substring(1, currShip.length);
          sumShip += parseFloat(currShip);          

          //--end sum ship--//

          //--Sum line Total --//
          currLineTotal = tableData.$("#cata_total_"+indexesToCalculate[i]).text();
          currLineTotal = currLineTotal.substring(1, currLineTotal.length);
          sumLineTotal += parseFloat(currLineTotal);          
          //-- -- //

         
        } 

        sumQty.toFixed(2);
        $(".total_qty").val(sumQty);

        sumChecks.toFixed(2);
        $(".totalChecks").val(sumChecks);        

        sumSold = sumSold.toFixed(2);
        $(".total_sold").val('');
        $(".total_sold").val('$'+sumSold);

        sumEst = sumEst.toFixed(2);
        $(".total_estimate").val('') ;
        $(".total_estimate").val('$'+sumEst);

        sumAmount = sumAmount.toFixed(2);
        $(".amounts").val('') ;
        $(".amounts").val('$'+sumAmount);

        sumEbay = sumEbay.toFixed(2);
        $(".total_ebay").val('') ;
        $(".total_ebay").val('$'+sumEbay); 

        sumPaypal = sumPaypal.toFixed(2);
        $(".total_paypal").val('') ;
        $(".total_paypal").val('$'+sumPaypal);  

        sumShip = sumShip.toFixed(2);
        $(".total_shipping").val('') ;
        $(".total_shipping").val('$'+sumShip); 

        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);                            

      console.log(indexesToCalculate);     

    }
    // if (current_check) {
    //    $('body .validValue').each(function(){   //.prop('disabled',false);
    //    var id2 = this.id;
    //    var componenet_name2 =  $('#'+id2).attr("ckbx_name").replace(/\//g, 'ZZZ').replace(/\&/g, 'AAA');
    //    var each_check       = $(this).prop("checked");
    //    // console.log(id2, componenet_name2);
    //    $("#"+bg_id).closest('tr').addClass('row-yellow');
    //   if(each_check == true && componenet_name2 == componenet_name  && bg_id == id2){
        
    //     $("#cata_component_qty_"+est_id).prop('readonly', true);
    //     $("#cata_est_price_"+est_id).prop('readonly', true);
    //     $("#estimate_condition_"+est_id).attr("disabled", true); 

    //       total_check           = parseFloat(total_check) + 1;
    //       total_qty             = parseFloat(parseFloat(total_qty) + parseFloat(qty));
    //       solds                 = parseFloat(parseFloat(total_solds) + parseFloat(sold_price)).toFixed(2);
    //       estimates             = parseFloat(parseFloat(total_estimates) + parseFloat(est_price)).toFixed(2);
    //       amounts               = parseFloat(parseFloat(amounts) + parseFloat(cata_amount)).toFixed(2);
    //       total_ebays           = parseFloat(parseFloat(total_ebay) + parseFloat(ebay_fee)).toFixed(2);
    //       paypal_fee            = parseFloat(parseFloat(total_paypal) + parseFloat(paypal_fee)).toFixed(2);
    //       total_shipping        = parseFloat(parseFloat(total_shipping) + parseFloat(ship_fee)).toFixed(2);
    //       sub_total             = parseFloat(parseFloat(sub_total) + parseFloat(rowtotal)).toFixed(2); 

    //   }else if(each_check == true && componenet_name2 == componenet_name && bg_id != id2){
    //       $(this).prop("checked", false);
    //       $("#"+bg_id).closest('tr').removeClass('row-yellow');
    //       $("#"+bg_id).closest('tr').removeClass('row-green');

    //       $("#cata_component_qty_"+est_id).prop('readonly', false);
    //       $("#cata_est_price_"+est_id).prop('readonly', false);
    //       $("#estimate_condition_"+est_id).attr("disabled", false); 

    //       total_check           = parseFloat(total_check) - 1;
    //       total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
    //       solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
    //       estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
    //       amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
    //       total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
    //       paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
    //       total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
    //       sub_total             = parseFloat(parseFloat(sub_total) - parseFloat(rowtotal)).toFixed(2); 
    //   }
    //   // else if(each_check == false && componenet_name2 == componenet_name && bg_id != id2){
    //   //   $("#"+bg_id).closest('tr').addClass('row-yellow');
    //   //   $("#cata_component_qty_"+est_id).prop('readonly', true);
    //   //   $("#cata_est_price_"+est_id).prop('readonly', true);
    //   //   $("#estimate_condition_"+est_id).attr("disabled", true);

    //   //     total_check           = parseFloat(total_check) + 1;
    //   //     total_qty             = parseFloat(parseFloat(total_qty) + parseFloat(qty));
    //   //     solds                 = parseFloat(parseFloat(total_solds) + parseFloat(sold_price)).toFixed(2);
    //   //     estimates             = parseFloat(parseFloat(total_estimates) + parseFloat(est_price)).toFixed(2);
    //   //     amounts               = parseFloat(parseFloat(amounts) + parseFloat(cata_amount)).toFixed(2);
    //   //     total_ebays           = parseFloat(parseFloat(total_ebay) + parseFloat(ebay_fee)).toFixed(2);
    //   //     paypal_fee            = parseFloat(parseFloat(total_paypal) + parseFloat(paypal_fee)).toFixed(2);
    //   //     total_shipping        = parseFloat(parseFloat(total_shipping) + parseFloat(ship_fee)).toFixed(2);
    //   //     sub_total             = parseFloat(parseFloat(sub_total) + parseFloat(rowtotal)).toFixed(2);        
    //   // }
      
    // });
      
      
    // }else{
    //   $("#"+bg_id).closest('tr').removeClass('row-yellow');
    //   $("#"+bg_id).closest('tr').removeClass('row-green');

    //   $("#cata_component_qty_"+est_id).prop('readonly', false);
    //   $("#cata_est_price_"+est_id).prop('readonly', false);
    //   $("#estimate_condition_"+est_id).attr("disabled", false); 

    //   total_check           = parseFloat(total_check) - 1;
    //   total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
    //   solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
    //   estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
    //   amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
    //   total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
    //   paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
    //   total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
    //   sub_total             = parseFloat(parseFloat(sub_total) - parseFloat(rowtotal)).toFixed(2); 
    // }

     // $(".totalChecks").val(total_check);
     // $(".total_qty").val(total_qty);
     // $(".total_sold").val('$'+solds);
     // $(".total_estimate").val('$'+estimates);
     // $(".amounts").val('$'+amounts);
     // $(".total_ebay").val('$'+total_ebays);
     // $(".total_paypal").val('$'+paypal_fee);
     // $(".total_shipping").val('$'+total_shipping);
     // $(".totalClass").val('$'+sub_total);
  });*/
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
   var button_color = [];
    function row_bgcolor(){
     
      $("input[name *= 'cata_component']:checked").each(function(){
              var id = this.id.match(/\d+/);
              if($('#component_check_'+id).is(":checked")){
                 $('#component_check_'+id).closest('tr').addClass('row-color');
                  var btn_obj_name = $.trim($(this).closest("tr").find("td").eq(1).text()).replace(/\ /g, '_').replace(/\  /g, '_').replace(/\   /g, '_').replace(/\(/g, '').replace(/\)/g, '').replace(/\//g, 'OR').replace(/\&/g, 'AND');
                  //button_color.push(btn_obj_name);
                  ///console.log(btn_obj_name);
                  var button_class = $("#"+btn_obj_name).attr('cls');
                  if (button_class == 'grey-color') {
                    $('#'+btn_obj_name).addClass('btn-success').removeClass('grey-color');
                      }else if(button_class == 'light-grey'){
                        $('#'+btn_obj_name).addClass('light-green').removeClass('light-grey');
                      }
              }      
          });
    }
    row_bgcolor();
    //console.log(button_color); 
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('blur', ".cata_est_price", function(){
    var est_id = this.id.match(/\d+/);

    // var est_comp_check = $("#component_check_"+est_id).attr( "checked", true );
    var est_price = $(this).val().replace(/\$/g, '').replace(/\ /g, '');
    var qty = $("#cata_component_qty_"+est_id).val();
    var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);
   
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
     //console.log(est_price, qty, ebay_price, paypal_price, ship_fee); return false;
    $("#cata_amount_"+est_id).val('$ '+amount);
    //console.log(ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+est_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+est_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+est_id).html('$ '+total);

    var checkedBox = $("#component_check_"+est_id).prop('checked');
    if(checkedBox == true){
        var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;
        $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currQty = $("#cata_component_qty_"+id).val();
            sumQty += parseInt(currQty);
          }

        });
        // sumQty.toFixed(2);
        $(".total_qty").val(sumQty);   

        var sumChecks = 0;
        sumChecks = parseInt(sumChecks);
        var currChecks = 0; 
        $("input[class *= 'checkboxes']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currChecks = 1;
            sumChecks += parseInt(currChecks);
          }

        });
        // sumChecks.toFixed(2);
        $(".totalChecks").val(sumChecks); 


        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 
        $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);

          
          if($("#component_check_"+id).prop("checked") == true){
            currSold = $("#cata_avg_price_"+id).val();
            currSold = currSold.substring(1, currSold.length);
            sumSold += parseFloat(currSold);
          }

        });
        sumSold = sumSold.toFixed(2);
        $(".total_sold").val('$'+sumSold);        

        
        var sumEst = 0;
        sumEst = parseFloat(sumEst);
        var currEst = 0; 
        $("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currEst = $("#cata_est_price_"+id).val();
            sumEst += parseFloat(currEst);
          }
        });
        sumEst = sumEst.toFixed(2);
        $(".total_estimate").val('') ;
        $(".total_estimate").val('$'+sumEst); 

        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 
        $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currAmount = $("#cata_amount_"+id).val();
            currAmount = currAmount.substring(1, currAmount.length);
            sumAmount += parseFloat(currAmount);
          }
        });
        sumAmount = sumAmount.toFixed(2);
        $(".amounts").val('') ;
        $(".amounts").val('$'+sumAmount);        

        var sumEbay = 0;
        sumEbay = parseFloat(sumEbay);
        var currEbay = 0; 
        $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currEbay = $("#cata_ebay_fee_"+id).val();
            currEbay = currEbay.substring(1, currEbay.length);
            sumEbay += parseFloat(currEbay);
          }
        });
        sumEbay = sumEbay.toFixed(2);
        $(".total_ebay").val('') ;
        $(".total_ebay").val('$'+sumEbay); 

        var sumPaypal = 0;
        sumPaypal = parseFloat(sumPaypal);
        var currPaypal = 0; 
        $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currPaypal = $("#cata_paypal_fee_"+id).val();
            currPaypal = currPaypal.substring(1, currPaypal.length);
            sumPaypal += parseFloat(currPaypal);
          }
        });
        sumPaypal = sumPaypal.toFixed(2);
        $(".total_paypal").val('') ;
        $(".total_paypal").val('$'+sumPaypal);    

        var sumShip = 0;
        sumShip = parseFloat(sumShip);
        var currShip = 0; 
        $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currShip = $("#cata_ship_fee_"+id).val();
            currShip = currShip.substring(1, currShip.length);
            sumShip += parseFloat(currShip);
          }
        });
        sumShip = sumShip.toFixed(2);
        $(".total_shipping").val('') ;
        $(".total_shipping").val('$'+sumShip);  

        var sumLineTotal = 0;
        sumLineTotal = parseFloat(sumLineTotal);
        var currLineTotal = ''; 
        $("p[class *= 'totalRow']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currLineTotal = $("#cata_total_"+id).text();
            currLineTotal = currLineTotal.substring(1, currLineTotal.length);
            sumLineTotal += parseFloat(currLineTotal);
          }
        });
        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);       

    }
    /////////////////////////////////////
  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
    $(document).on('blur', ".component_qty", function(){
    var qty_id = $(this).attr("rowid");
    var est_id = this.id.match(/\d+/);
    // var est_comp_check = $("#component_check_"+qty_id).attr( "checked", true );
    var qty = $("#cata_component_qty_"+qty_id).val();
    var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var amount = (est_price * qty).toFixed(2); 

    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    $("#cata_amount_"+qty_id).val('$ '+amount);
    //console.log(qty, est_price, ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+est_id).html('$ '+total);

    var checkedBox = $("#component_check_"+est_id).prop('checked');
    if(checkedBox == true){
        var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;
        $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currQty = $("#cata_component_qty_"+id).val();
            sumQty += parseInt(currQty);
          }

        });
        // sumQty.toFixed(2);
        $(".total_qty").val(sumQty);   

        var sumChecks = 0;
        sumChecks = parseInt(sumChecks);
        var currChecks = 0; 
        $("input[class *= 'checkboxes']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currChecks = 1;
            sumChecks += parseInt(currChecks);
          }

        });
        // sumChecks.toFixed(2);
        $(".totalChecks").val(sumChecks); 


        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 
        $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);

          
          if($("#component_check_"+id).prop("checked") == true){
            currSold = $("#cata_avg_price_"+id).val();
            currSold = currSold.substring(1, currSold.length);
            sumSold += parseFloat(currSold);
          }

        });
        sumSold = sumSold.toFixed(2);
        $(".total_sold").val('$'+sumSold);        

        
        var sumEst = 0;
        sumEst = parseFloat(sumEst);
        var currEst = 0; 
        $("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currEst = $("#cata_est_price_"+id).val();
            sumEst += parseFloat(currEst);
          }
        });
        sumEst = sumEst.toFixed(2);
        $(".total_estimate").val('') ;
        $(".total_estimate").val('$'+sumEst); 

        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 
        $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currAmount = $("#cata_amount_"+id).val();
            currAmount = currAmount.substring(1, currAmount.length);
            sumAmount += parseFloat(currAmount);
          }
        });
        sumAmount = sumAmount.toFixed(2);
        $(".amounts").val('') ;
        $(".amounts").val('$'+sumAmount);        

        var sumEbay = 0;
        sumEbay = parseFloat(sumEbay);
        var currEbay = 0; 
        $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currEbay = $("#cata_ebay_fee_"+id).val();
            currEbay = currEbay.substring(1, currEbay.length);
            sumEbay += parseFloat(currEbay);
          }
        });
        sumEbay = sumEbay.toFixed(2);
        $(".total_ebay").val('') ;
        $(".total_ebay").val('$'+sumEbay); 

        var sumPaypal = 0;
        sumPaypal = parseFloat(sumPaypal);
        var currPaypal = 0; 
        $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currPaypal = $("#cata_paypal_fee_"+id).val();
            currPaypal = currPaypal.substring(1, currPaypal.length);
            sumPaypal += parseFloat(currPaypal);
          }
        });
        sumPaypal = sumPaypal.toFixed(2);
        $(".total_paypal").val('') ;
        $(".total_paypal").val('$'+sumPaypal);    

        var sumShip = 0;
        sumShip = parseFloat(sumShip);
        var currShip = 0; 
        $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currShip = $("#cata_ship_fee_"+id).val();
            currShip = currShip.substring(1, currShip.length);
            sumShip += parseFloat(currShip);
          }
        });
        sumShip = sumShip.toFixed(2);
        $(".total_shipping").val('') ;
        $(".total_shipping").val('$'+sumShip);  

        var sumLineTotal = 0;
        sumLineTotal = parseFloat(sumLineTotal);
        var currLineTotal = ''; 
        $("p[class *= 'totalRow']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#component_check_"+id).prop("checked") == true){
            currLineTotal = $("#cata_total_"+id).text();
            currLineTotal = currLineTotal.substring(1, currLineTotal.length);
            sumLineTotal += parseFloat(currLineTotal);
          }
        });
        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);       

    }
    /////////////////////////////////////
  });
/*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_brands',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id},
    success:function(data){
      var brands = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        brands.push('<option value="'+data[i].SPECIFIC_VALUE+'">'+data[i].SPECIFIC_VALUE+'</option>')
      }
      $('#brands').html("");
      $('#brands').append('<label>Brands:</label><select name="bd_brands" id="bd_brands" class="form-control bd_brands" data-live-search="true" required>'+brands.join("")+'</select>');
      $('.brands').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
 /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '#comp_mpn', function(){

  var mpn_id            = $(this).val();
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_upc',
    type:'post',
    dataType:'json',
    data:{'mpn_id':mpn_id},
    success:function(data){
       if (data.allow == 1) {
        $("#search_components").hide();
        $("button #add_mpn").prop('disabled',true);
      }
      var upc = data[0].UPC;
      if (upc == null) {
        upc = '';
      }
       // alert(data.length);return false;
      $('#component_upc').html("");
      $('#component_upc').html("<input type='text' name='new_upc' class='new_upc form-control' id='new_upc' value='"+upc+"'>");
    },
     complete: function(data){
      $(".loader").hide();
    },
    error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
    /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '.bd_brands', function(){

  var brand_name = $(this).val();
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_mpns',
    type:'post',
    dataType:'json',
    data:{'brand_name':brand_name},
    success:function(data){
      var mpns = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+'</option>')
      }
      $('#bdMPN').html("");
      $('#bdMPN').append('<label>Component MPN:</label><select name="bd_mpn" id="bd_mpn" class="form-control bdMPNS" data-live-search="true" required>'+mpns.join("")+'</select>');
      $('.bdMPNS').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
/*--- Onchange Mpn get its Objects start---*/
$("#bd_mpn" ).change(function(){
  var bd_mpn = $("#bd_mpn").val();
  $(".loader").show();
  $.ajax({
    dataType: 'json',
    type: 'POST',
    url:'<?php echo base_url(); ?>bigData/c_recog_title_mpn_kits/getMpnObjects',
    data: {'bd_mpn' : bd_mpn},
    success: function (data) {
    //console.log(data);
    $("#bd_object").val(data[0].OBJECT_NAME);
    },
    complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue          =
  ================================================================*/

/*==============================================================
  =               FOR GOING CATALOGUE PAGE                      =
  ===============================================================*/
$("#copy_specific_catalogue").on('click', function(){
    var fields = $("input[name='ctc_catalogue']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one Catalogue'); 
        // cancel submit
        return false;
      }  

      var to_cata_id=[];
      var cat_id              = '<?php echo $this->uri->segment(4); ?>';
      var mpn_id= '<?php echo $this->uri->segment(5); ?>';
      var from_cata_id =  '<?php echo $this->uri->segment(6); ?>';
      var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/assignCataloguesToKit';

      var tableId="catalogue-detail-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[name='ctc_catalogue']:checked"), function()
      {            
        to_cata_id.push($(this).val());
      });
      //console.log(to_cata_id); return false;
      $(".loader").show();
      $.ajax({
        type: 'POST',
        url:url,
        data: {
          'cat_id': cat_id,
          'mpn_id': mpn_id,
          'from_cata_id': from_cata_id,
          'to_cata_id': to_cata_id
        },
        dataType: 'json',
        success: function (data){
         if(data== true){
          alert("Success: Catalogues are assigned!"); 
          window.location.reload(); 
           var dataTable = $('#catalogue-detail-table').DataTable({  
                "oLanguage": {
                "sInfo": "Total Records: _TOTAL_",
                //"sPaginationType": "full_numbers",
                
              },
              // For stop ordering on a specific column
              // "columnDefs": [ { "orderable": false, "targets": [0] }],
              // "pageLength": 5,
                 "aLengthMenu": [25, 50, 100, 200],
                 "paging": true,
                // "lengthChange": true,
                "searching": true,
                // "ordering": true,
                "Filter":true,
                // "iTotalDisplayRecords":10,
                //"order": [[ 8, "desc" ]],
                // "order": [[ 16, "ASC" ]],
                "info": true,
                // "autoWidth": true,
                "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                "bProcessing": true,
                "bRetrieve":true,
                "bDestroy":true,
                "bServerSide": true,
                // "bAutoWidth": false,
                "ajax":{
                  url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
                  type: "post"  // method  , by default get
                  // data: {},
                  
                  },
                  "columnDefs":[{
                      "target":[0],
                      "orderable":false
                    }
                  ]
                }); // end data tables
         }else if(data== false){
          alert('Error: Failed to assign catalogues!');
         }
       },
       complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
/*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$("#copy_all_catalogues").on('click', function(){
      var list_type             = $("#catalogue_List_type").val();
      var cata_condition        = $("#catalogue_condition").val();

      var cat_id                = '<?php echo $this->uri->segment(4); ?>';
      var mpn_id                = '<?php echo $this->uri->segment(5); ?>';
      var from_cata_id          =  '<?php echo $this->uri->segment(6); ?>';
      var url                   ='<?php echo base_url() ?>catalogueToCash/c_purchasing/assignAllCataloguesToKit';
      //console.log(to_cata_id); return false;
      $(".loader").show();
      $.ajax({
        type: 'POST',
        url:url,
        data: {
          'list_type': list_type,
          'cata_condition': cata_condition,
          'cat_id': cat_id,
          'mpn_id': mpn_id,
          'from_cata_id': from_cata_id
        },
        dataType: 'json',
        success: function (data){
         if(data== true){
          alert("Success: Catalogues are assigned!"); 
          window.location.reload(); 
           var dataTable = $('#catalogue-detail-table').DataTable({  
                "oLanguage": {
                "sInfo": "Total Records: _TOTAL_",
                //"sPaginationType": "full_numbers",
              },
              // For stop ordering on a specific column
              // "columnDefs": [ { "orderable": false, "targets": [0] }],
              // "pageLength": 5,
                 "aLengthMenu": [25, 50, 100, 200],
                 "paging": true,
                // "lengthChange": true,
                "searching": true,
                // "ordering": true,
                "Filter":true,
                // "iTotalDisplayRecords":10,
                //"order": [[ 8, "desc" ]],
                // "order": [[ 16, "ASC" ]],
                "info": true,
                // "autoWidth": true,
                "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
                "bProcessing": true,
                "bRetrieve":true,
                "bDestroy":true,
                "bServerSide": true,
                // "bAutoWidth": false,
                "ajax":{
                  url :"<?php echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
                  type: "post"  // method  , by default get
                  // data: {},
                  
                  },
                  "columnDefs":[{
                      "target":[0],
                      "orderable":false
                    }
                  ]
                }); // end data tables
         }else if(data== false){
          alert('Error: Failed to assign catalogues!');
         }
       },
       complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
/*==============================================================
=            FOR TOGGLING ADD COMPONENT FIELDS                 =
================================================================*/
  $("#add_kit_component").click(function(){
  $("#component-toggle").toggle();
});

   $("#go_back").click(function(){
      $("#add_mpn_section").hide();
      $(".hide-component").show();
        $("#mpn_category").val('');
        $("#mpn_object").val('');
        $("#mpn_brand").val('');
        $("#new_mpn").val('');
    });
/*==================================
=            add to kit            =
==================================*/

/*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#comp_category').on('change',function(){
  var comp_category = $(this).val();
  // alert(comp_category);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_objects',
    type:'post',
    dataType:'json',
    data:{'comp_category':comp_category},
    success:function(data){
       $(".loader").hide();
      var objects = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        objects.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>');
      }
      $('#comp_objects').html("");
      $('#comp_objects').append('<select name="comp_object" id="comp_object" class="form-control comp_object" data-live-search="true" required><option value="0">---select---</option>'+objects.join("")+'</select>');
      $('.comp_object').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
/*==============================================================
  =               FOR GOING CATALOGUE PAGE                           =
  ================================================================*/
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '#comp_object', function(){

  var object_id = $(this).val();
  var object_name          = $("#comp_object option:selected").text();
  var category_id = $("#comp_category").val();
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_mpns',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id, 'category_id':category_id, 'object_name':object_name},
    success:function(data){
       if (data.allow == 1) {
            $("#search_components").hide();
          }
      var mpns = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.mpn.length;i++){
        mpns.push('<option value="'+data.mpn[i].CATALOGUE_MT_ID+'">'+data.mpn[i].MPN+'</option>')
      }
      $('#comp_mpns').html("");
      $('#comp_mpns').append('<select name="comp_mpn" id="comp_mpn" class="form-control comp_mpn" data-live-search="true" required><option value="0">---select---</option>'+mpns.join("")+'</select>');
      $('.comp_mpn').selectpicker();
    },
     complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue          =
  ================================================================*/
$("#save_mpn_kit").on('click', function(){
    var table = $('body #kit-components-table').DataTable();
    var search_val = '';
    table.search(search_val).draw();

    var url='<?php echo base_url(); ?>catalogueToCash/c_purchasing/addKitComponent';
    var comp_category                 = $("#comp_category").val();
    var comp_object                   = $("#comp_object").val();
    var object_name                   = $("#comp_object option:selected").text();
    var new_upc                       = $("#new_upc").val();
    var comp_mpn                      = $("#comp_mpn").val();

    var category_id                   = $("#ct_category_id").val();
    var catalogue_mpn_id              = $("#ct_catlogue_mt_id").val();
    var ct_cata_id                    = $("#ct_cata_id").val();

    //console.log(new_upc, catalogue_mpn_id, ct_cata_id, comp_category, comp_object, comp_mpn, object_name); 
    //return false;
     if( comp_category == 0 || comp_category == undefined){
    alert('Warning: Category is required!');
  }else if(comp_object == '' || comp_object == null){
    alert('Warning: Object is required!');
    return false;
  }else if( comp_mpn == '' || comp_mpn == null){
    alert('Warning: Please insert MPN!');
    $("#new_mpn").focus();
    return false;
  }else{
       $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'catalogue_mpn_id': catalogue_mpn_id,
      'comp_category': comp_category,
      'comp_object' : comp_object,
      'object_name' : object_name,
      'new_upc' : new_upc,
      'ct_cata_id': ct_cata_id,
      'comp_mpn' : comp_mpn
    },
    dataType: 'json',
    success: function (data){
      if(data.check == 1){
        alert("Success: Component is created!");
         $("#comp_mpn").selectpicker('val', '---select---');
        if (data.result.length > 0) {
               var row_id           = data.totals;
               
               var alertMsg   = "return confirm('Are you sure to delete?');";
               var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/cp_delete_component/'+category_id+'/'+catalogue_mpn_id+'/'+ct_cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
                 var mpns = [];
                   // alert(data.length);return false;
                  for(var i = 0;i<data.conditions.length; i++){
                    if (data.result[0].CONDITION_ID == data.conditions[i].ID){
                                    var selected = "selected";
                                  }else {
                                      var selected = "";
                                  }

                    mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
                  }

                 var quantity       = data.result[0].QTY;
                 var est_price       = data.result[0].PRICE;
                 ///////////////////////////////////////////
                  if (est_price =="" || est_price == 0.00 || est_price === null) {
                    est_price = parseFloat(1).toFixed(2);
                      if (quantity === null) {
                        var quantity         = 1;
                      }
                       var est_price        = parseFloat(1).toFixed(2);
                       var amount = parseFloat(parseFloat(est_price) * parseFloat(quantity)).toFixed(2);

                      var ebay_price = parseFloat((parseFloat(amount) * (8 / 100))).toFixed(2);
                      var paypal_price =  parseFloat((parseFloat(amount)  * (2.5 / 100))).toFixed(2);
                      var ship_price       = parseFloat(3.25).toFixed(2);
                      var sub_total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_price)).toFixed(2);
                    }else{ /////end main if
                      if (quantity === null) {
                        var quantity         = 1;
                      }
                       var amount = parseFloat(parseFloat(est_price) * parseFloat(quantity)).toFixed(2);

                      var ebay_price = parseFloat((parseFloat(amount) * (8 / 100))).toFixed(2);
                      var paypal_price =  parseFloat((parseFloat(amount)  * (2.5 / 100))).toFixed(2);
                      var ship_price       = parseFloat(3.25).toFixed(2);
                      var sub_total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_price)).toFixed(2);
                    }
                  ///console.log(est_price, quantity, amount, ebay_price); 
                  ///////////////////////////////////////////
                        var button_id = data.result[0].OBJECT_NAME.replace(/\ /g, '_');
                        var button_class = $("#"+button_id).attr('cls');
                        if (button_class == 'color-red') {
                          $('#'+button_id).addClass('grey-color').removeClass('color-red');
                        }
                  //console.log(button_id, button_class); return false;
                  /////<a title="Delete Component" href="'+delete_comp+'" onclick="'+alertMsg+'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a>
                   var part_mpn_description = data.result[0].MPN_DESCRIPTION.replace(/[<>'"]/g, function(m) {
                          return '&' + {
                            '\'': 'apos',
                            '"': 'quot',
                            '&': 'amp',
                            '<': 'lt',
                            '>': 'gt',
                          }[m] + ';';
                        });
                  
                        var est_price_name = 'cata_est_price_'+row_id;
                        var table = $('body #kit-components-table').DataTable();
                        table.row.add( $('<tr> <td></td> <td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td><div style="width: 300px;"> <div class="form-group"> <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc'+row_id+'" value="'+part_mpn_description+'" class="form-control kit_mpn_desc" style="width: 300px;"> </div> </div></td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"><input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="'+data.result[0].MPN_KIT_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].MPN_KIT_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+quantity+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$'+ship_price+'" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+sub_total+'</p></td><td></td></tr>')).draw();
                    }
        $(".loader").hide();
      }else if(data.check == 0){
        alert("Error: Fail to create component! Try Again");
      }else if(data.check == 2){
        alert("Warning: Component is already exist!");
      }     
    },
    complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });
  } ///else end
 
});
/*==============================================================
  =               FOR GOING CATALOGUE PAGE                           =
  ================================================================*/
 /*==================================
=            add to kit            =
==================================*/
$(document).on('click','.addtokit', function(){
  var cat_id          = '<?php $this->uri->segment(4); ?>';
  var mpn_id          = '<?php $this->uri->segment(5); ?>';
  var cata_id         = '<?php $this->uri->segment(6); ?>';

  var partCatalogueId = this.id;
  var index           = $(this).attr("name"); 
  var disableBtn           = $(this).attr("mid"); 
  $("#"+disableBtn+"").prop('disabled',true);
  var avg_price       = $(this).attr("avg");
  //console.log(index, avg_price);

  var objectName      = $('#object_name_'+index).val();
  var catalogueId     = $('#ct_catlogue_mt_id').val();
  var objectInput     = $('#object_name').val();
  var inputText       = $('#search_component_table tr').eq(index).find('td').eq(4).find('input').val();
  var input_upc       = $('#search_component_table tr').eq(index).find('td').eq(5).find('input').val();
  var component_mpn   = $('#search_component_table tr').eq(index).find('td').eq(4).text();
  var mpnDesc         = $('#search_component_table tr').eq(index).find('td').eq(3).find('input').val();
  var ddObjectId      = $('#search_component_table tr').eq(index).find('td').eq(1).find('select').val();
  if (ddObjectId == undefined || ddObjectId == 0 || ddObjectId == '') {
    var ddObjectId      = $('#search_component_table tr').eq(index).find('td').eq(1).find('.objectIs').val();
  }
  // var ddObjectName = $('#search_component_table tr').eq(index).find('td').eq(1).find('select').text();
  var categoryId      = $('#search_component_table tr').eq(index).find('td').eq(2).text();

  if(inputText == '' && objectName == ''){
    alert('Warning! MPN is Required.');
            $('#search_component_table tr').eq(index).find('td').eq(4).find('input').focus();
            return false;
  }
  /*if(objectName == ''){ //verfied data object
    $("#"+disableBtn+"").prop('disabled',false);
    if(ddObjectId == '' || ddObjectId == 0){ // unverfied data object dropdown
      if(objectInput == ''){ // unverfied data object input

        alert('Warning! Object Name is Required.');
              $("#object_name").focus();
              return false;
      }
    }
  }*/
  if(ddObjectId == undefined || ddObjectId == 0){ // unverfied data object dropdown
      // unverfied data object input

        alert('Warning! First fetch object.');
              return false;

    }
  //console.log(inputText); return false;


  //console.log(ddObjectName);return false;
  $(".loader").show();
  $.ajax({

        data:{'partCatalogueId':partCatalogueId,
              'catalogueId':catalogueId,
              'objectName':objectName,
              'objectInput':objectInput,
              'mpnDesc':mpnDesc,
              'categoryId':categoryId,
              'component_mpn':component_mpn,
              'ddObjectId':ddObjectId,
              'input_upc':input_upc,
              'inputText':inputText},
        url :"<?php echo base_url() ?>catalogueToCash/c_purchasing/addtokit", // json datasource
        type: "post" ,
        dataType: 'json',

         success : function(data){
          ///console.log(data); return false;
          $(".loader").hide();
          if(data.flag == 1){
            alert('Success! Component addded to kit');
            if (data.result.length > 0 ) {
             var row_id           = data.totals;
               
               var alertMsg   = "return confirm('Are you sure to delete?');";
               var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/up_delete_component/'+cat_id+'/'+mpn_id+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
                 var mpns = [];
                   // alert(data.length);return false;
                  for(var i = 0;i<data.conditions.length; i++){
                    if (data.result[0].CONDITION_ID == data.conditions[i].ID){
                        var selected = "selected";
                      }else {
                          var selected = "";
                      }
                    mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
                  }

                 var quantity       = data.result[0].QTY;
                 var est_price       = data.result[0].PRICE;
                 ///////////////////////////////////////////
                  if (est_price =="" || est_price == 0.00 || est_price === null) {
                    var est_price = parseFloat(1).toFixed(2);
                       if (quantity === null) {
                        var quantity         = 1;
                      }
                       var est_price        = parseFloat(1).toFixed(2);
                       var amount = parseFloat(parseFloat(est_price) * parseFloat(quantity)).toFixed(2);

                      var ebay_price = parseFloat((parseFloat(amount) * (8 / 100))).toFixed(2);
                      var paypal_price =  parseFloat((parseFloat(amount)  * (2.5 / 100))).toFixed(2);
                      var ship_price       = parseFloat(3.25).toFixed(2);
                      var sub_total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_price)).toFixed(2);
                    }else{ /////end main if
                      if (quantity === null) {
                        var quantity         = 1;
                      }
                       var amount = parseFloat(parseFloat(est_price) * parseFloat(quantity)).toFixed(2);

                      var ebay_price = parseFloat((parseFloat(amount) * (8 / 100))).toFixed(2);
                      var paypal_price =  parseFloat((parseFloat(amount)  * (2.5 / 100))).toFixed(2);
                      var ship_price       = parseFloat(3.25).toFixed(2);
                      var sub_total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_price)).toFixed(2);
                    }
                  //console.log(); 
                  ///////////////////////////////////////////
                        var button_id = data.result[0].OBJECT_NAME.replace(/\ /g, '_');
                        var button_class = $("#"+button_id).attr('cls');
                        if (button_class == 'color-red') {
                          $('#'+button_id).addClass('grey-color').removeClass('color-red');
                        }
                  //console.log(button_id, button_class); return false;
      var part_mpn_description = data.result[0].MPN_DESCRIPTION.replace(/[<>'"]/g, function(m) {
                          return '&' + {
                            '\'': 'apos',
                            '"': 'quot',
                            '&': 'amp',
                            '<': 'lt',
                            '>': 'gt',
                          }[m] + ';';
                        });
                  //console.log(part_mpn_description); return false;
                  //.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                        var est_price_name = 'cata_est_price_'+row_id;
                        var table = $('body #kit-components-table').DataTable();
                        table.row.add( $('<tr><td></td><td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td><div style="width: 300px;"> <div class="form-group"> <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc'+row_id+'" value="'+part_mpn_description+'" class="form-control kit_mpn_desc" style="width: 300px;"> </div> </div></td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"><input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="'+data.result[0].MPN_KIT_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].MPN_KIT_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+quantity+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$'+ship_price+'" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+sub_total+'</p></td><td></td></tr>')).draw();
                    }
            

          }else if (data.flag == 0){
            alert('Error! Component Not addded to kit');
          }else if(data.flag == 2){
            alert('Warning! Component Already Exist in Kit');
          }
        },
      complete: function(data){
      $(".loader").hide();
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});


/*=====  End of add to kit  ======*/
/*==============================================
=            search components call            =
==============================================*/
 var dataTable = '';
  $("#search_component").on('click',function(){
    var input_text = $("#input_text").val();
    var data_source = $("input[name='data_source']:checked").attr('id');
    var data_status = $("input[name='data_status']:checked").attr('id');

    if(input_text == ''){
        alert('Warning! Keyword is Required.');
        $("#input_text").focus();
        return false;
    }
    //console.log(data_source,data_status);return false;
   
if(dataTable !=''){
      dataTable.destroy();
    }
  dataTable = $('#search_component_table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "iDisplayLength": 200,
      "aLengthMenu": [[25, 50, 100, 200,500, 5000, -1], [25, 50, 100, 200,500, 5000, "All"]],
       "paging": true,
      // "lengthChange": true,
      "searching": true,
      // "ordering": true,
      "Filter":true,
      // "iTotalDisplayRecords":10,
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      // "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      "bProcessing": true,
      "bRetrieve":true,
      "bDestroy":true,
      "bServerSide": true,
      "ajax":{
        data:{'input_text':input_text,'data_source':data_source,'data_status':data_status},
        url :"<?php echo base_url() ?>catalogueToCash/c_purchasing/search_component", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
      "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]
  });

  });
/*=====  End of search components call  ======*/
 /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
   $(document).on('click', '#add_mpn', function(event) {
     event.preventDefault();
     var category_id          = $("#comp_category").val();
     var object_id            = $("#comp_object").val();
     var object_name          = $("#comp_object option:selected").text();
     var master_mpn_id        = $("#ct_catlogue_mt_id").val();
     //console.log(category_id, object_id, object_name, master_mpn_id); return false;
     if (category_id == 0 || category_id == undefined) {
      alert('Warning: Category is required');
      return false;
     }else {
       $("#mpn_category").val(category_id).selectpicker('refresh'); 
       if (object_name != '---select---') {
          $("#mpn_object").val(object_name); 
       }
       $("#add_mpn_section").show();
       $(".hide-component").hide();
       //console.log(category_id, object_id, object_name, master_mpn_id); return false;
     }
   });
  
 $("#add_new_mpn").click(function(){
   var table = $('body #kit-components-table').DataTable();
      var search_val = '';
      table.search(search_val).draw();

    var cat_id                  = $("#mpn_category").val();
  
    var mpn_object              = $("#mpn_object").val();
    var mpn_brand               = $("#mpn_brand").val();
    var new_mpn                 = $("#new_mpn").val();
    var comp_upc                = $("#comp_upc").val();
    var mpn_desc                = $('#mpn_description').val();

    var category_id             = $("#ct_category_id").val();
    var master_mpn              = $("#ct_catlogue_mt_id").val();
    var cata_id                 = $("#ct_cata_id").val();

   if( mpn_category == 0 || mpn_category == undefined){
    alert('Warning: Category is required!');
  }else if(mpn_object == '' || mpn_object == null){
    alert('Warning: Object is required!');
    $("#mpn_object").focus();
    return false;
  }else if( mpn_brand == '' || mpn_brand == null){
    alert('Warning: Brand name is required!');
    $("#mpn_brand").focus();
    return false;
  }else if( new_mpn == '' || new_mpn == null){
    alert('Warning: Please insert MPN!');
    $("#new_mpn").focus();
    return false;
  }else if(mpn_desc == '' || mpn_desc == null){
    alert('Warning: MPN Description is required!');
    $("#mpn_description").focus();
    return false;
  }else{
    //console.log(cat_id, master_mpn, mpn_object, mpn_brand, new_mpn, mpn_desc); return false;
    $(".loader").show();
     $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/addCataMpn',
        data: {'cat_id':cat_id,'master_mpn':master_mpn, 'mpn_object':mpn_object,  'mpn_brand':mpn_brand, 'new_mpn' : new_mpn,'comp_upc' : comp_upc, 'mpn_desc':mpn_desc},
        success: function (data) {
          $(".loader").hide();
         if(data.check == 0){
            alert('Error! Record is not inserted.');
            return false;
          }else if(data.check == 1){
            alert('Success! Record is successfully inserted.');
          //console.log(data, 'imran'); return false;
            $("#mpn_category").val('');
            $("#mpn_object").val('');
            $("#mpn_brand").val('');
            $("#new_mpn").val('');
            $('#mpn_description').val('');
            $("#add_mpn_section").hide();
            $(".hide-component").show();
            if (data.result.length > 0) {
               var row_id           = data.totals;
               
               var alertMsg   = "return confirm('Are you sure to delete?');";
               var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/up_delete_component/'+category_id+'/'+master_mpn+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
                 var mpns = [];
                   // alert(data.length);return false;
                  for(var i = 0;i<data.conditions.length; i++){
                    if (data.result[0].CONDITION_ID == data.conditions[i].ID){
                                    var selected = "selected";
                                  }else {
                                      var selected = "";
                                  }

                    mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
                  }
                 var quantity       = data.result[0].QTY;
                 var est_price       = data.result[0].PRICE;
                 ///////////////////////////////////////////
                  if (est_price =="" || est_price == 0.00 || est_price === null) {
                    est_price = parseFloat(1).toFixed(2);
                       if (quantity === null) {
                        var quantity         = 1;
                      }

                       var est_price        = parseFloat(1).toFixed(2);
                       var amount = parseFloat(parseFloat(est_price) * parseFloat(quantity)).toFixed(2);

                       var ebay_price = parseFloat((parseFloat(amount) * (8 / 100))).toFixed(2);
                       var paypal_price =  parseFloat((parseFloat(amount)  * (2.5 / 100))).toFixed(2);
                       var ship_price       = parseFloat(3.25).toFixed(2);
                       var sub_total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_price)).toFixed(2);
                    }else{ /////end main if
                      if (quantity === null) {
                        var quantity         = 1;
                      }
                       var amount = parseFloat(parseFloat(est_price) * parseFloat(quantity)).toFixed(2);

                      var ebay_price = parseFloat((parseFloat(amount) * (8 / 100))).toFixed(2);
                      var paypal_price =  parseFloat((parseFloat(amount)  * (2.5 / 100))).toFixed(2);
                      var ship_price       = parseFloat(3.25).toFixed(2);
                      var sub_total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_price)).toFixed(2);
                    }
                  //console.log(); 
                  ///////////////////////////////////////////
                        var button_id = data.result[0].OBJECT_NAME.replace(/\ /g, '_');
                        var button_class = $("#"+button_id).attr('cls');
                        if (button_class == 'color-red') {
                          $('#'+button_id).addClass('grey-color').removeClass('color-red');
                        }
                  //console.log(); return false;
                   var part_mpn_description = data.result[0].MPN_DESCRIPTION.replace(/[<>'"]/g, function(m) {
                          return '&' + {
                            '\'': 'apos',
                            '"': 'quot',
                            '&': 'amp',
                            '<': 'lt',
                            '>': 'gt',
                          }[m] + ';';
                        });

                       var est_price_name = 'cata_est_price_'+row_id;
                        var table = $('body #kit-components-table').DataTable();
                        table.row.add( $('<tr><td></td><td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td><div style="width: 300px;"> <div class="form-group"> <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc'+row_id+'" value="'+part_mpn_description+'" class="form-control kit_mpn_desc" style="width: 300px;"> </div> </div></td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"><input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="'+data.result[0].MPN_KIT_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].MPN_KIT_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+quantity+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$'+ship_price+'" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+sub_total+'</p></td><td></td></tr>')).draw();
                    }
            return false;
          }else if(data.check == 2){
            alert('Warning! Record is already exist.');
            return false;
          }          
       },
        complete: function(data){
            $(".loader").hide();
          },
          error: function(jqXHR, textStatus, errorThrown){
             $(".loader").hide();
            if (jqXHR.status){
              alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
            }
          }
      });
  }
 
 });


////////////////////
 }); ///// end of document.ready
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
</script>