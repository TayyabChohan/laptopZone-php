<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <style type="text/css">
  .row-green{
    background-color:rgba(0, 166, 90, 0.67) !important;
  }
  .row-yellow{
    background-color:#f39c12ad !important;
  }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Estimate Update
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lot Estimate Update</li>
      </ol>
      
    </section>  
    <!-- Main content -->
    <section class="content"> 

    <!-- Start of Master information section --> 
        <div class="box"> 
          <div class="box-body">  
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
                $cat_id  = @$data[0]['CATEGORY_ID'];
               // $mpn_id  = $this->uri->segment(5);
               $lz_bd_cata_id = $this->uri->segment(4);
            ?>  
            <div class="col-md-12">
            <!-- <input type="hidden" name="ct_category_id" value="<?php //echo $cat_id; ?>" id="ct_category_id">
            <input type="hidden" name="ct_catlogue_mt_id" value="<?php //echo $mpn_id; ?>" id="ct_catlogue_mt_id"> -->
            <input type="hidden" name="ct_cata_id" value="<?php echo @$lz_bd_cata_id ; ?>" id="ct_cata_id">
            <div class="row">
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">EBAY ID:</label>
                    <input class="form-control" type="text" value="<?php echo @$data[0]['EBAY_ID']; ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ITEM DESCRIPTION">ITEM DESCRIPTION:</label>
                    <input class="form-control" type="text" value="<?php echo htmlentities(@$data[0]['TITLE']); ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="MPN">CATEGORY ID:</label>
                    <input class="form-control" type="text" name="kitmpn" id="kitmpn" value="<?php echo @$data[0]['CATEGORY_ID']; ?>" readonly> 
                </div>
              </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">CONDITION:</label>
                    <input class="form-control" type="text" value="<?php echo @$data[0]['CONDITION_NAME']; ?>" readonly> 
                    <?php $cond_id  = @$data[0]['CONDITION_ID'];?>
                </div>
              </div>
                <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">START TIME:</label>
                    <input class="form-control" type="text" value="<?php echo @$data[0]['START_TIME']; ?>" readonly> 
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">END TIME:</label>
                    <input class="form-control" type="text" value="<?php echo @$data[0]['SALE_TIME']; ?>" readonly> 
                  </div>
                </div>
            </div>

            </div>
        </div>
      </div>
      <!-- End of Master information section -->

      <!-- Start of Catalogue Detail section -->
         <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Catalogue Detail</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body">
              <div class='col-sm-12' id="component-toggle">
              <div class='col-sm-3'>
                <div class="form-group" id="bdObject">
                  <label>Object:</label>
                  <select name="bd_object" id="bd_object" class="form-control selectpicker" data-live-search="true" required> 
                      <option value="0">---</option>
                    <?php                                
                       if(!empty($getAllObjects)){
                        foreach ($getAllObjects as $object){
                          ?>
                          <option value="<?php echo $object['OBJECT_ID']; ?>" <?php if($this->input->post('bd_object') == $object['OBJECT_ID']){echo "selected";}?>> <?php echo $object['OBJECT_NAME']; ?>
                          </option>
                          <?php
                          } 
                        }   
                    ?>                      
                  </select> 
                </div>
              </div>
              <div class='col-sm-3'>
                <div class="form-group" id="brands">   
                </div>
              </div>
              <div class='col-sm-3'>
                <div class="form-group" id="bdMPN">   
                </div>
              </div>
              <div class='col-sm-1'>
                <div class='form-group'>
                  <label>Quantity:</label>
                  <input class='form-control' type='text' name='kit_qty' id='kit_qty' value='1' placeholder='Enter Quantity'/>
                </div>
              </div>                                                
              <div class="col-sm-1">
                <div class="form-group p-t-24">
                  <input type="button" class="btn btn-success btn-sm" name="save_mpn_kit" id="save_mpn_kit" value="Save">
                </div>
              </div>
              <div class="form-group col-sm-1 p-t-24">
                 <!-- <input type="button" class="btn btn-info btn-sm" name="go_to_catalogue" id="go_to_catalogue" value="Add PMN"> -->
                 <a type="button" class="btn btn-info btn-sm" href="<?php echo base_url().'catalogue/c_itemCatalogue/getCategorySpecifics/'.$cat_id; ?>"  target="_blank" >Add MPN</a>
              </div>
              <!-- MPN Block end -->
            </div>
           </div>
          </div>
         <!-- end of Catalogue Detail section --> 

        <!-- Start of Estimate section -->
             <div class="row">
               <div class="col-sm-4">
                  <div class="form-group" style="font-size: 15px;">
                   <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 update_components pull-left" id="update_components" style="margin-top: 25px;">Update</button>
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
                  <th>ACTION</th>
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
                </thead>
                <tbody id="reloa_id">
                  <?php
                  $total_avg_prices = 0;
                  $totals = 0;
                  $i=1;
                  if($data['results']->num_rows() > 0)
                  {
                    $comps = $data['components']->result_array();
                    // echo "<pre>";
                    // print_r ($comps);
                    // echo "</pre>";
                    // exit;
                    foreach ($data['results']->result_array() as $result):
                       $component_id = @$result['MPN_KIT_MT_ID'];
                          if(@$data['components']->num_rows() > 0): ?>
                            <tr>
                              <td>
                                <a title="Delete Component" href="<?php //echo base_url().'catalogueToCash/c_purchasing/cp_delete_component/'.$cat_id.'/'.$mpn_id.'/'.$cata_id.'/'.@$result['MPN_KIT_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a>
                              </td>
                              <?php 
                                $flag= false;
                                $k = 0;
                                foreach ($comps as $comp):
                                  $component_check_id = $comp['MPN_KIT_MT_ID'];
                                  $lz_estimate_id     = $comp['LZ_BD_ESTIMATE_ID'];
                                  
                                    if ($component_id == $component_check_id) {
                                    $cond_name     = $comp['COND_NAME'];
                                    $tech_cond_id     = $comp['TECH_COND_ID'];
                                      $flag= true; 
                                      $index= $k;
                                       
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
                                  <?php echo @$result['MPN_DESCRIPTION']; ?>
                                </td>
                                <td>
                                  <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                                      <div class="form-group" style="width: 210px;">


                                          <select class="form-control selectpicker estimate_condition"  data-live-search="true" name="estimate_condition" id="estimate_condition_<?php echo $i; ?>" ctmt_id="<?php echo @$result['PART_CATLG_MT_ID']; ?>" rd = "<?php echo $i; ?>"  style="width: 203px;">
                                          <option value="<?php echo @$tech_cond_id ; ?>"><?php echo @$cond_name; ?></option>
                                            <?php                                 
                                              foreach(@$data['conditions'] as $type) { 
                                                             
                                                  ?>
                                                   <option value="<?php echo $type['ID']; ?>"><?php echo $type['COND_NAME']; ?></option>
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
                                    <?php $est_price_name="cata_est_price_".$i; 
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
              <input type="hidden" name="countrows" value="<?php echo $i-1; ?>" id="countrows">
              <div class="form-group col-sm-3  pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 update_components" id="update_components">Update</button>
              </div>  
            </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <!-- second block start -->   
      <!-- /.row -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function(){
     var table = $('#kit-components-table').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });

   $('.myInput').on( 'click', function () {
        table.search( this.value ).draw();
    } );
    $('#showAll').on( 'click', function (){
        table.search( this.value ).draw();
    });   

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

 
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
 $(".update_components").click(function(){
  $('#showAll').click();
    //this.disabled = true;
  var fields = $("input[name='cata_component']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }  
      var arr=[];
      var estimate_id               = '<?php echo $lz_estimate_id; ?>';
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

              $(tdbk.rows[arr[i]]).find('.cata_paypal_fee').each(function(){
                payPalFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_ship_fee').each(function(){
                shipFee.push($(this).val());
              });           
          }
           tech_condition = tech_condition.filter(v=>v!='');
          //console.log(tech_condition, );
          //console.log(estimate_id, compName, compQty, compAvgPrice, estimate_price, ebayFee, payPalFee, shipFee); return false;
        if (tech_condition.length < payPalFee.length) {
            alert("Warning: Please select condition for each component");
            return false;
         }else if (estimate_price.length < shipFee.length) {
            alert("Warning: Please Insert Estimate Price of Selected Components");
            return false;
          }else {
            $(".loader").show();
            $.ajax({
              type: 'POST',
              url:url,
              data: {
                'estimate_id': estimate_id,
                'catag_id': catag_id,
                'compName': compName,
                'compQty': compQty,
                'compAvgPrice': compAvgPrice,
                'estimate_price': estimate_price,
                'ebayFee': ebayFee,
                'payPalFee': payPalFee,
                'shipFee': shipFee,
                'part_catalogue_mt_id': part_catalogue_mt_id,
                'tech_condition':tech_condition
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
    // var total_check         = $(".totalChecks").val();
    // var total_qty           = $(".total_qty").val();
    // var total_solds         = $(".total_sold").val().replace(/\$/g, '').replace(/\ /g, '');
    // var total_estimates     = $(".total_estimate").val().replace(/\$/g, '').replace(/\ /g, '');
    // var amounts             = $(".amounts").val().replace(/\$/g, '').replace(/\ /g, '');
    // var total_ebay          = $(".total_ebay").val().replace(/\$/g, '').replace(/\ /g, '');
    // var total_paypal        = $(".total_paypal").val().replace(/\$/g, '').replace(/\ /g, '');
    // var total_shipping      = $(".total_shipping").val().replace(/\$/g, '').replace(/\ /g, '');
    // var sub_total           = $(".totalClass").val().replace(/\$/g, '').replace(/\ /g, '');

    // var qty                 = $("#cata_component_qty_"+est_id).val();
    // var est_price           = $("#cata_est_price_"+est_id).val();
    // var sold_price          = $("#cata_avg_price_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    // var cata_amount         = $("#cata_amount_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    // var ebay_fee            = $("#cata_ebay_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    // var paypal_fee          = $("#cata_paypal_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    // var ship_fee            = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    // var rowtotal            = $("#cata_total_"+est_id).text();




    if(current_check == true){
        tableData.$("#"+bg_id).closest('tr').addClass('row-yellow');
        tableData.$("#cata_component_qty_"+est_id).prop('readonly', true);
        tableData.$("#cata_est_price_"+est_id).prop('readonly', true);
        tableData.$("#estimate_condition_"+est_id).attr("readonly", true);

        var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;
        tableData.$("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if( tableData.$("#component_check_"+id).prop("checked") == true){
            currQty = tableData.$("#cata_component_qty_"+id).val();
            sumQty += parseInt(currQty);
          }

        });
        // sumQty.toFixed(2);
        $(".total_qty").val(sumQty);   

        var sumChecks = 0;
        sumChecks = parseInt(sumChecks);
        var currChecks = 0; 
        tableData.$("input[class *= 'checkboxes']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currChecks = 1;
            sumChecks += parseInt(currChecks);
          }

        });
        // sumChecks.toFixed(2);
        $(".totalChecks").val(sumChecks); 


        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 
        tableData.$("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);

          
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currSold = tableData.$("#cata_avg_price_"+id).val();
            currSold = currSold.substring(1, currSold.length);
            sumSold += parseFloat(currSold);
          }

        });
        sumSold = sumSold.toFixed(2);
        $(".total_sold").val('$'+sumSold);        

        
        var sumEst = 0;
        sumEst = parseFloat(sumEst);
        var currEst = 0; 
        tableData.$("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currEst = tableData.$("#cata_est_price_"+id).val();
            sumEst += parseFloat(currEst);
          }
        });
        sumEst = sumEst.toFixed(2);
        $(".total_estimate").val('') ;
        $(".total_estimate").val('$'+sumEst); 

        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 
        tableData.$("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currAmount = tableData.$("#cata_amount_"+id).val();
            currAmount = currAmount.substring(1, currAmount.length);
            sumAmount += parseFloat(currAmount);
          }
        });
        sumAmount = sumAmount.toFixed(2);
        $(".amounts").val('');
        $(".amounts").val('$'+sumAmount);        

        var sumEbay = 0;
        sumEbay = parseFloat(sumEbay);
        var currEbay = 0; 
        tableData.$("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currEbay = tableData.$("#cata_ebay_fee_"+id).val();
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
        tableData.$("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currPaypal = tableData.$("#cata_paypal_fee_"+id).val();
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
        tableData.$("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currShip = tableData.$("#cata_ship_fee_"+id).val();
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
        tableData.$("p[class *= 'totalRow']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currLineTotal = tableData.$("#cata_total_"+id).text();
            currLineTotal = currLineTotal.substring(1, currLineTotal.length);
            sumLineTotal += parseFloat(currLineTotal);
          }
        });
        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);                         
    }else{

        tableData.$("#"+bg_id).closest('tr').removeClass('row-yellow');
        tableData.$("#"+bg_id).closest('tr').removeClass('row-green');
        tableData.$("#cata_component_qty_"+est_id).prop('readonly', false);
        tableData.$("#cata_est_price_"+est_id).prop('readonly', false);
        tableData.$("#estimate_condition_"+est_id).attr("readonly", false);

        var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;
        tableData.$("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currQty = tableData.$("#cata_component_qty_"+id).val();
            sumQty += parseInt(currQty);
          }

        });
        // sumQty.toFixed(2);
        $(".total_qty").val(sumQty);   

        var sumChecks = 0;
        sumChecks = parseInt(sumChecks);
        var currChecks = 0; 
        tableData.$("input[class *= 'checkboxes']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currChecks = 1;
            sumChecks += parseInt(currChecks);
          }

        });
        // sumChecks.toFixed(2);
        $(".totalChecks").val(sumChecks); 


        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 
        tableData.$("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);

          
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currSold = tableData.$("#cata_avg_price_"+id).val();
            currSold = currSold.substring(1, currSold.length);
            sumSold += parseFloat(currSold);
          }

        });
        sumSold = sumSold.toFixed(2);
        $(".total_sold").val('$'+sumSold);        

        
        var sumEst = 0;
        sumEst = parseFloat(sumEst);
        var currEst = 0; 
        tableData.$("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currEst = tableData.$("#cata_est_price_"+id).val();
            sumEst += parseFloat(currEst);
          }
        });
        sumEst = sumEst.toFixed(2);
        $(".total_estimate").val('') ;
        $(".total_estimate").val('$'+sumEst); 

        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 
        tableData.$("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currAmount = tableData.$("#cata_amount_"+id).val();
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
        tableData.$("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currEbay = tableData.$("#cata_ebay_fee_"+id).val();
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
        tableData.$("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currPaypal = tableData.$("#cata_paypal_fee_"+id).val();
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
        tableData.$("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currShip = tableData.$("#cata_ship_fee_"+id).val();
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
        tableData.$("p[class *= 'totalRow']").each(function(){
          var id = this.id.match(/\d+/);
          if(tableData.$("#component_check_"+id).prop("checked") == true){
            currLineTotal = tableData.$("#cata_total_"+id).text();
            currLineTotal = currLineTotal.substring(1, currLineTotal.length);
            sumLineTotal += parseFloat(currLineTotal);
          }
        });
        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);      

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
  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
    function row_bgcolor(){
      $("input[name *= 'cata_component']:checked").each(function(){
              var id = this.id.match(/\d+/);
              if($('#component_check_'+id).is(":checked")){
                 $('#component_check_'+id).closest('tr').addClass('row-green');
              }      
          });
    }
    row_bgcolor();
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(".cata_est_price").on('blur', function(){
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
    $(".component_qty").on('blur', function(){
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
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$("#save_mpn_kit").on('click', function(){

    var url='<?php echo base_url() ?>bigData/c_recog_title_mpn_kits/addKitComponent';
    // var bd_alt_object = $("#bd_alt_object").val();
    var ct_category_id              = $("#ct_category_id").val();
    var catalogue_mpn_id            = $("#ct_catlogue_mt_id").val();
    var ct_cata_id                  = $("#ct_cata_id").val();

    var bd_mpn                      = $("#bd_mpn").val();
    var kit_qty                     = $("#kit_qty").val();

    //console.log(catalogue_mpn_id, bd_mpn, kit_qty, ct_category_id); return false;
    // alert(bd_mpn);return false;
    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'catalogue_mpn_id': catalogue_mpn_id,
      'bd_mpn': bd_mpn,
      'kit_qty' : kit_qty
    },
    dataType: 'json',
    success: function (data){
      if(data == 1){
         alert("Success: Estimate is created!");
        window.location.reload();
      }else{
        alert("Error: Fail to create Estimate! Try Again");
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
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
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


});
  /*==============================================================
  =                ON CHANGE ESTIMATE CONDITION                 =
  ================================================================*/
  $('.estimate_condition').on('change',function(){
  var condition_id         = $(this).val();
  var qty_id               = $(this).attr("rd");
  var kitmpn_id            = $(this).attr("ctmt_id");
  //alert(qty_id); return false;
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_cond_base_price',
    type:'post',
    dataType:'json',
    data:{'condition_id':condition_id, 'kitmpn_id':kitmpn_id},
    success:function(data){
       $(".loader").hide();
      if(data.length == 1){
        $("#cata_avg_price_"+ qty_id).val('$'+parseFloat(data[0].AVG_PRICE).toFixed(2));
        $("#cata_est_price_"+ qty_id).val(parseFloat(data[0].AVG_PRICE).toFixed(2));
        ///////////////////////////////////
        var qty = $("#cata_component_qty_"+qty_id).val();
        var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        var amount = (est_price * qty).toFixed(2); 
        //console.log(qty, est_price, amount); return false;
        //alert(est_price); return false;
        var ebay_price = (amount * (8 / 100)).toFixed(2); 
        var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
        var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
        $("#cata_amount_"+qty_id).val('$ '+amount);
        //console.log(qty, est_price, ebay_price, paypal_price); return false;
        $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
        $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
        var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
        $("#cata_total_"+qty_id).html('$ '+total);
        /////////////////////////////////////
            }else if(data.length == 0){
              $("#cata_avg_price_"+ qty_id).val('$0.00');
              $("#cata_est_price_"+ qty_id).val('0.00');
              ///////////////////////////////////
              $("#cata_amount_"+qty_id).val('$0.00');
              //console.log(qty, est_price, ebay_price, paypal_price); return false;
              $("#cata_ebay_fee_"+qty_id).val('$0.00');
              $("#cata_paypal_fee_"+qty_id).val('$0.00');
              $("#cata_total_"+qty_id).html('$0.00');
              /////////////////////////////////////
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
  =                ON CHANGE ESTIMATE CONDITION               =
================================================================*/
</script>