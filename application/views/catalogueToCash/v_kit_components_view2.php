<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
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
            <div class="alert alert-success">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
            </div>
            <?php }else if($this->session->flashdata('error')){  ?>
            <div class="alert alert-danger">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
            </div>
            <?php }else if($this->session->flashdata('warning')){  ?>
            <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
            </div>
            <?php }else if($this->session->flashdata('compo')){  ?>
            <div class="alert alert-danger">
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
                    <label for="ebay id">EBAY ID:</label>
                    <input class="form-control" type="text" value="<?php echo @$data['detail'][0]['EBAY_ID']; ?>" readonly> 
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

              <!-- Object Button list -->
              <div class="row">
                <div class="col-sm-12" style="margin-top: 30px!important;border: 1px solid #337ab7; padding: 10px 0px 0px;"> 
                  <div class="col-sm-2" style="margin-bottom: 15px;">
                    <button type="button" id="showAll" title="Show All" value="" class="btn btn-md btn-primary" style="width: 180px;margin-left: 15px;">Show All</button>
                  </div>                  
                  <?php foreach ($data['object_list'] as $value): ?>
                  <div class="col-sm-2" style="margin-bottom: 15px;">
                    <button type="button" id="<?php echo trim($value['OBJECT_NAME']); ?>" title="<?php echo trim($value['OBJECT_NAME']); ?>" value="<?php echo trim($value['OBJECT_NAME']); ?>" class="btn btn-md btn-primary btn-block myInput" style="width: 180px;margin-left: 15px;"><?php echo trim($value['OBJECT_NAME']); ?><?php  echo " (".$value['OBJECT_COUNT'].")"; ?></button>
                  </div>
                <?php endforeach; ?>

                </div>
              </div>
            <!-- end of ojbect button list -->
            </div>

            <div class="col-sm-12" style="margin-top: 20px;">
              <div class="col-sm-1 col-sm-offset-7">
              <div class="form-group pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 save_components" id="save_components">Save</button>
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
              <table  id="kit-components-table" class="table table-responsive table-striped table-bordered table-hover">
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
                  // echo "<pre>";
                  // print_r($data['results']->result_array());
                  // echo "</pre>";
                  // exit;
                  if($data['results']->num_rows() > 0)
                  {
                    foreach ($data['results']->result_array() as $result) {
                      $part_catlg_mt_id = $result['PART_CATLG_MT_ID'];
                  ?>
                    <tr>
                      <td>
                        <a title="Delete Component" href="<?php echo base_url().'catalogueToCash/c_add_comp/cp_delete_component/'.$cat_id.'/'.$mpn_id.'/'.$cata_id.'/'.@$result['MPN_KIT_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                      </td>
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
                            <div class="form-group" style="width: 200px;">
                                <select class="form-control selectpicker estimate_condition" name="estimate_condition" id="estimate_condition_<?php echo $i;?>" ctmt_id="<?php echo @$result['PART_CATLG_MT_ID']; ?>" rd = "<?php echo $i; ?>" data-live-search="true" style="width: 150px;">
                                  <?php                                 
                                    foreach(@$data['conditions'] as $type) { 
                                    if ($cond_id == $type['ID']){
                                          $selected = "selected";
                                        }else {
                                            $selected = "";
                                        }                
                                        ?>
                                         <option value="<?php echo $type['ID']; ?>"<?php echo $selected; ?>><?php echo $type['COND_NAME']; ?></option>
                                        <?php
                                         /*$this->session->unset_userdata('ctListing_condition');*/
                                        } 
                                     ?>                     
                                </select> 
                            </div>
                      </td>
                      <td>
                        <div style="width: 70px;">
                           <input type="checkbox" name="cata_component" ckbx_name="<?php echo @$result['OBJECT_NAME']; ?>" id="component_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes validValue countings" style="width: 60px;">
                        </div>
                        
                      </td>
                      <td>
                        <?php 
                        $quantity = @$result['QTY']; ?>
                        
                        <div class="form-group" style="width:70px;">
                          <input type="hidden" name="part_catalogue_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                          <input type="number" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($quantity)) {echo $quantity; }else{ echo 1;}?>" style="width:60px;">
                        </div>
                      </td>
                      <td>
                      
                       <?php 
                  // $mpn_id =$part_catlg_mt_id;
                  // $con = $cond_id;
                  // if(!empty$mpn_id )
                      
                      $avg_query = $this->db2->query("SELECT T.AVG_PRICE MPN_AVG FROM MPN_AVG_PRICE T WHERE T.CONDITION_ID=$cond_id AND T.CATALOGUE_MT_ID =$part_catlg_mt_id  ");

// $barcode_no = $single_barcodeNo->result_array();
//                             $bar_code = $barcode_no[0]['BCD'];


                           if($avg_query->num_rows() > 0){
                            $mpn_avg_price = $avg_query->result_array();
                            $mpn_avg_price = $mpn_avg_price[0]['MPN_AVG'];}
                            else{

                              $mpn_avg_price = '0';
                              } ?>
                        <?php 
                        $avg_price = @$result['AVG_PRIC'];
                        if ($avg_price == 0.00 || $avg_price == 0 || $avg_price == 0. || $avg_price == 0.0 ) {
                          $avg_price = 1;
                        }
                        $total_avg_prices += $avg_price;
                         ?>
                        <div class="form-group">
                          <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php echo '$ '.number_format((float)@$mpn_avg_price,2,'.',','); ?>" style="width:80px;" readonly>
                        </div>
                      </td> 
                    <td>
                      <?php $est_price_name="cata_est_price_".$i; 
                      ?>
                      <div class="form-group" style="width:80px;">
                        <input type="number" name="<?php echo $est_price_name; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php if(isset($_POST['$est_price_name'])){ echo $estimate_price= $_POST['$est_price_name']; }else { echo $estimate_price= number_format((float)@$avg_price,2,'.',','); } ?>" style="width:80px;">
                      </div>
                    </td>
                    <td>
                       <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php
                      if (!empty($avg_price)) {
                            $ebay_fee= ($avg_price  * (8 / 100));
                          }else {
                            $ebay_fee= ($estimate_price  * (8 / 100));
                          }

                        ?>
                      <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php echo '$ '.number_format((float)@$ebay_fee,2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php 
                      $paypal_fee= ($avg_price  * (2.5 / 100));
                        if (!empty($avg_price)) {
                          $paypal_fee= ($avg_price  * (2.5 / 100));
                          }else {
                            $paypal_fee= ($estimate_price  * (2.5 / 100));
                          }
                       ?>
                      <div class="form-group" style="width:80px;">
                        <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php echo '$ '.number_format((float)@$paypal_fee,2,'.',','); ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_<?php echo $i; ?>" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td class="rowDataSd">
                    <?php 
                      $cahrges  = $ebay_fee + $paypal_fee + 3.25;
                      $total    = $avg_price + $cahrges;
                      $totals += $total;
                      ?>
                      <p id="cata_total_<?php echo $i; ?>" class="totalRow"><?php  echo '$ '.number_format((float)@$total,2,'.',','); ?></p>
                    </td>
                    <?php
                      $i++;
                      // echo "</tr>"; 
                      } ///end foreach 
                    ?>
                    </tr>
                  
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

            <div class="col-sm-12" style="margin-top: 15px;">
               <input type="hidden" name="countrows" value="<?php echo $i-1; ?>" id="countrows">
              <div class="form-group col-sm-2 pull-left">
                <button type="button" title="Add Component"  class="btn btn-primary" id="add_kit_component">Add Component</button>
              </div>
              <div class="col-sm-3">
              <div class="form-group" style="font-size: 18px;">
               <!--  <b class="col-sm-offset-4 pull-left">Sold Price = 
                <?php
                  //echo '$ '.number_format((float)@$total_avg_prices,2,'.',',');
               ?>
               </b> -->
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group" style="font-size: 18px;">
                <!-- <b class="col-sm-offset-2 pull-left" id="grand_total">Grand Total = 
                <?php
                  //echo '$ '.number_format((float)@$totals,2,'.',',');
               ?>
               </b> -->
              </div>
            </div>
            <div class="col-sm-1">
              <div class="form-group pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 save_components" id="save_components">Save</button>
              </div>
            </div>

            <div class="col-sm-2">
              <div class="form-group pull-right">
                <input class="form-control" type="text" name="kitmpnauto" id="kitmpnauto" value="<?php echo @$data['detail'][0]['MPN']; ?>">
              </div>
            </div>             
 
            <div class="col-sm-1">
              <div class="form-group pull-right">
                <button type="button" title="Create Auto Kit"  class="btn btn-primary" name="createAutoKit" id="createAutoKit">Create Auto Kit</button>
              </div>
            </div>                  
            </div>
          </div>
          <!-- /.box-body -->
        </div>
          
        <!-- /.box -->
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
                 <a type="button" class="btn btn-info btn-sm" href="<?php echo base_url().'catalogue/c_itemCatalogue/getCategorySpecifics/'.$cat_id.'/'.$mpn_id; ?>"  target="_blank" >Add MPN</a>
              </div>
              <!-- MPN Block end -->
            </div>
           </div>
          </div>
         <!-- second block  Catalogue Detail start --> 
                 <!-- COMPONENCT SERACH START --> 
          <div class="box">
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
            </div><!-- /.col --> 
          </div>
          <!-- end second block start --> 
          <!-- COMPONENCT SERACH END -->  
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
$(document).ready(function()
  {
    var table = $('#kit-components-table').DataTable({
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_"
    },
    "iDisplayLength": 500,
        "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
    $('.myInput').on( 'click', function () {
        table.search( this.value ).draw();
    } );
    $('#showAll').on( 'click', function () {
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
/*  $("#copy_catalogues").on('click', function(event) {
    event.preventDefault();
     var dataTable = $('#catalogue-detail-table').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
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
        url :"<?php //echo base_url().'catalogueToCash/c_add_comp/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
        type: "post"  // method  , by default get
        // data: {},
        
        },
        "columnDefs":[{
            "target":[0],
            "orderable":false
          }
        ]

      });
  });*/
 
/* $('#kit-components-table').append('<tr> <td></td> <td ></td> <td ></td><td></td><td></td><td><label>Checked: </label><p class="totalChecks"></p></td> <td> <label>Total Qty : </label> <div class="form-group"> <input type="text" name="total_component_qty" id="total_component_qty_1" class="form-control input-sm total_qty" value="0.00" style="width:80px;" readonly> </div> </td> <td><label>Total Sold Price:</label><div class="form-group"> <input type="text" name="total_sold_price" id="total_sold_price" class="form-control input-sm total_sold" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Estimate: </label><div class="form-group"> <input type="text" name="total_estimate_price" id="total_estimate_price" class="form-control input-sm total_estimate" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Amount: </label><div class="form-group"> <input type="text" name="total_amount" id="total_amount" class="form-control input-sm amounts" value="$0.00" style="width:100px;" readonly> </div></td><td><label>Total Ebay Fee: </label><div class="form-group"> <input type="text" name="total_ebay_fee" id="total_ebay_fee" class="form-control input-sm total_ebay" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Paypal:</label><div class="form-group"> <input type="text" name="total_paypal_fee" id="total_paypal_fee" class="form-control input-sm total_paypal" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Total Shipping:</label><div class="form-group"> <input type="text" name="total_ship_fee" id="total_ship_fee" class="form-control input-sm total_shipping" value="0.00" style="width:100px;" readonly> </div></td> <td><label>Sub Total:</label><p class="totalClass"/></p></td> </tr>');*/

$(document).on('change','.checkboxes',function(){
  //var id = this.id.match(/\d+/);
  var id = this.id;
  var checkbox = $(this).prop('checked');
  var componenet_name =  $(this).attr("ckbx_name");

  if(checkbox == true){
    $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");
       //console.log(componenet_name2);
      if(componenet_name2 == componenet_name && id == id2){
        $('#'+id).prop('disabled',false);
        $('#'+componenet_name2).addClass('btn-success').removeClass('btn-primary');    
      }else if(componenet_name2 == componenet_name && id != id2){
        $('#'+id2).prop('disabled',true);  
      }
      
    });
    }
   else{
    $('.validValue').each(function(){   //.prop('disabled',false);
       id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");

      if(componenet_name2 == componenet_name){
        //console.log("hello");
        $('#'+id2).prop('disabled',false);    
      }
      
    });
   }


});

  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $(".save_components").click(function(){
    $('#showAll').click();

    var fields = $("input[type='checkbox']").serializeArray(); 
      if (fields.length === 0) 
      { 
        alert('Please Select at least one Component'); 
        return false;
      }  
      var arr=[];
      var cat_id= '<?php echo $this->uri->segment(4); ?>';
      var mpn_id= '<?php echo $this->uri->segment(5); ?>';
      var dynamic_cata_id= '<?php echo $this->uri->segment(6); ?>';
      var url='<?php echo base_url() ?>catalogueToCash/c_add_comp/savekitComponents';
      var partsCatalgid = [];
      var compName=[];
      var compQty=[];
      var compAvgPrice=[];
      var compAmount=[];
      var ebayFee=[];
      var payPalFee=[];
      var shipFee=[];
      var tech_condition=[];


      var tableId="kit-components-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[type='checkbox']:checked"), function()
      {            
        arr.push($(this).val());
      });
    //alert(arr);
    //console.log(arr); return false;
    //category_id.push($(tdbk.rows[1].cells[2]).text());
       for (var i = 0; i < arr.length; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[arr[i]]).find(".part_catlg_mt_id").each(function() {
              partsCatalgid.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".estimate_condition").each(function() {
              tech_condition.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".kit_componets").each(function() {
                    compName.push($(this).val());
                  }); 

             $(tdbk.rows[arr[i]]).find(".component_qty").each(function() {
                    compQty.push($(this).val());
                  }); 

              $(tdbk.rows[arr[i]]).find('.cata_avg_price').each(function() {
                compAvgPrice.push($(this).val());
              }); 

              $(tdbk.rows[arr[i]]).find('.cata_est_price').each(function(){
               // console.log($(this).val()); return false;
                if ($(this).val() == 0 || $(this).val() == 00 || $(this).val() == 0. || $(this).val() == 0.0 || $(this).val() == 0.00 || $(this).val() == 0.000) {
                  
                }else {
                 compAmount.push($(this).val()); 
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
      //console.log(compAmount); return false;
      //console.log(compName); return false;
       if (compAmount.length < shipFee.length) {
            alert("Warning: Please Insert Estimate Price of Selected Components");
            return false;
          }else {
              $(".loader").show();
                $.ajax({
                  type: 'POST',
                  url:url,
                  data: {
                    'cat_id': cat_id,
                    'dynamic_cata_id': dynamic_cata_id,
                    'mpn_id': mpn_id,
                    'compName': compName,
                    'compQty': compQty,
                    'compAvgPrice': compAvgPrice,
                    'compAmount': compAmount,
                    'ebayFee': ebayFee,
                    'payPalFee': payPalFee,
                    'shipFee': shipFee,
                    'partsCatalgid':partsCatalgid,
                    'tech_condition':tech_condition
                  },
                  dataType: 'json',
                  success: function (data){
                       if(data == 0){
                          alert('Warning: Data is already inserted against this catalogue!');
                          window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_add_comp/searchPurchaseDetail';
                       }else if(data == 1){
                          alert("Success: Estimate is created!"); 
                          window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_add_comp/searchPurchaseDetail';  
                       }else if(data == 2){
                         alert('Error: Fail to create estimate!');
                       }
                     },
                  complete: function(data){
                    $(".loader").hide();
                  }
            });
          }
  });
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
   /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('click','.countings', function(){
    var est_id              = $(this).val();
    var total_check         = $(".totalChecks").val();
    var total_qty           = $(".total_qty").val();
    var total_solds         = $(".total_sold").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_estimates     = $(".total_estimate").val().replace(/\$/g, '').replace(/\ /g, '');
    var amounts             = $(".amounts").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_ebay          = $(".total_ebay").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_paypal        = $(".total_paypal").val().replace(/\$/g, '').replace(/\ /g, '');
    var total_shipping      = $(".total_shipping").val().replace(/\$/g, '').replace(/\ /g, '');

    var qty                 = $("#cata_component_qty_"+est_id).val();
    var est_price           = $("#cata_est_price_"+est_id).val();
    var sold_price          = $("#cata_avg_price_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var cata_amount         = $("#cata_amount_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var ebay_fee            = $("#cata_ebay_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var paypal_fee          = $("#cata_paypal_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var ship_fee            = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var current_check       = $(this).prop("checked");
    //console.log(total_check, total_qty, total_solds, qty, sold_price); //return false;
    if (current_check) {
      $("#cata_component_qty_"+est_id).prop('readonly', true);
      $("#cata_est_price_"+est_id).prop('readonly', true);
      $("#estimate_condition_"+est_id).attr("disabled", true); 
      total_check           = parseFloat(total_check) + 1;
      total_qty             = parseFloat(parseFloat(total_qty) + parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) + parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) + parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) + parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) + parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) + parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) + parseFloat(ship_fee)).toFixed(2);
      sub_total             = parseFloat(parseFloat(amounts) + parseFloat(ebay_fee) + parseFloat(paypal_fee) + parseFloat(total_shipping)).toFixed(2);
    }else{
      $("#cata_component_qty_"+est_id).prop('readonly', false);
      $("#cata_est_price_"+est_id).prop('readonly', false);
      $("#estimate_condition_"+est_id).attr("disabled", false); 
      total_check           = parseFloat(total_check) - 1;
      total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
      sub_total             = parseFloat(parseFloat(amounts) - parseFloat(ebay_fee) - parseFloat(paypal_fee) - parseFloat(total_shipping)).toFixed(2);
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
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(".cata_est_price").on('blur', function(){
    var est_id = this.id.match(/\d+/);
      /////////////////////////////////////////////////////////////////

    //var est_comp_check = $("#component_check_"+est_id).attr( "checked", true );
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

  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
    $(".component_qty").on('blur', function(){
    var qty_id = $(this).attr("rowid");
    //var est_comp_check = $("#component_check_"+qty_id).attr( "checked", true );
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
  });
/*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  $('#bd_object').on('change',function(){

  var object_id = $('#bd_object').val();
  // alert(object_id);
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_add_comp/get_brands',
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
    url:'<?php echo base_url(); ?>catalogueToCash/c_add_comp/get_mpns',
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
    }

  });
});
  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue                        =
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
        alert("Success: Component is created!");
        window.location.reload();
      }else{
        alert("Error: Fail to create component! Try Again");
      }    
    },
    complete: function(data){
      $(".loader").hide();
    }
  });
});
/*==============================================================
  =               FOR GOING CATALOGUE PAGE                           =
  ================================================================*/

/*$(document).on('change','.checkboxes',function(){
  
  
   var checker = 0;
   checker = $('input.checkboxes:checked').length;
   $(".totalChecks").val(checker);

   var sum = 0;
      $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum += +$(this).val();
          }
          
      });
      $(".total_qty").val(sum);
      ///////////////////////////////////
      var total_amounts = 0;
      $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourAmount = $(this).val().replace ( /[^\d.]/g, '' );
            total_amounts += +yourAmount;
          }      
      });

      $(".amounts").val('$'+total_amounts.toFixed(2));
      ////////////////////////////////////

      var sum_sold = 0;
      $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_sold += +yourString;
          }
          
      });
      $(".total_sold").val('$'+sum_sold.toFixed(2));

      ///////////////////////////////////
        var sum_est = 0;
      $("input[class *= 'cata_est_price']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            your_est = $(this).val().replace ( /[^\d.]/g, '' );
            sum_est += +your_est;
          }      
      });

      $(".total_estimate").val('$'+sum_est.toFixed(2));
      /////////////////////////////////////

      var sum_ebay = 0;
      $("input[class *= 'cata_ebay_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ebay += +yourString;
          }
          
      });
      $(".total_ebay").val('$'+sum_ebay.toFixed(2));

      var sum_paypal = 0;
      $("input[class *= 'cata_paypal_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_paypal += +yourString;
          }
          
      });
      $(".total_paypal").val('$'+sum_paypal.toFixed(2));


      var sum_ship = 0;
      $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            yourString = $(this).val().replace ( /[^\d.]/g, '' );
            sum_ship += +yourString;
          }
          
      });
      $(".total_shipping").val('$'+sum_ship.toFixed(2));

      var sum_row = 0;
      $('.totalRow').each(function(){
          var id = this.id.match(/\d+/);
          if($('#component_check_'+id).is(":checked")){
            sum_row += parseFloat($(this).text().replace ( /[^\d.]/g, '' ));
          }
            // Or this.innerHTML, this.innerText
      });
      $(".totalClass").val('$'+sum_row.toFixed(2));

});*/
// $('.checkboxes').on('click',function(){
   
// });

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#add_kit_component").click(function(){
  $("#component-toggle").toggle();
});

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#createAutoKit").click(function(){
    var ct_catlogue_mt_id = $("#ct_catlogue_mt_id").val();
    var kitmpnauto = $("#kitmpnauto").val();
    var url='<?php echo base_url() ?>catalogueToCash/c_add_comp/createAutoKit';
    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {'kitmpnauto': kitmpnauto, 'ct_catlogue_mt_id': ct_catlogue_mt_id},
    dataType: 'json',
    success: function (data){
      if(data == 1){
        alert("Success: Kit Created successfully.");
        window.location.reload();
      }else if(data == 0){
        alert("Error: Kit not created.");
      }    
    },
    complete: function(data){
      $(".loader").hide();
    }
  });    
    //alert(mpn);return false;
  });


});

/*==============================================================
=                ON CHANGE ESTIMATE CONDITION                  =
================================================================*/
  $(document).on('change','.estimate_condition', function(){
    var est_id               = this.id
    var condition_id         = this.value;
    var qty_id               = $(this).attr("rd");
    var kitmpn_id            = $(this).attr("ctmt_id");
  //alert(qty_id); return false;
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_add_comp/get_cond_base_price',
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
    }
  });
});

/*==============================================================
  =                ON CHANGE ESTIMATE CONDITION               =
================================================================*/
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
      "ajax":{
        data:{'input_text':input_text,'data_source':data_source,'data_status':data_status},
        url :"<?php echo base_url() ?>catalogueToCash/c_add_comp/search_component", // json datasource
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
/*==================================
=            add to kit            =
==================================*/
$("body").on('click','.addtokit', function(){
//$('.addtokit').on('click',function(){
  var cat_id          = '<?php $this->uri->segment(4); ?>';
  var mpn_id          = '<?php $this->uri->segment(5); ?>';
  var cata_id         = '<?php $this->uri->segment(6); ?>';

  var partCatalogueId = this.id;
  var index           =  $(this).attr("name");
  var avg_price       =  parseFloat($(this).attr("avg")).toFixed(2);
  var objectName      = $('#object_name_'+index).val();
  var catalogueId     = $('#ct_catlogue_mt_id').val();
  var objectInput     = $('#object_name').val();
  var inputText       = $('#search_component_table tr').eq(index).find('td').eq(4).find('input').val();;
  var component_mpn   = $('#search_component_table tr').eq(index).find('td').eq(4).text();
  var mpnDesc         = $('#search_component_table tr').eq(index).find('td').eq(3).find('input').val();
  var ddObjectId      = $('#search_component_table tr').eq(index).find('td').eq(1).find('select').val();
  // var ddObjectName = $('#search_component_table tr').eq(index).find('td').eq(1).find('select').text();
  var categoryId      = $('#search_component_table tr').eq(index).find('td').eq(2).text();

  if(inputText == '' && objectName == ''){
    alert('Warning! MPN is Required.');
            $('#search_component_table tr').eq(index).find('td').eq(4).find('input').focus();
            return false;
  }
  if(objectName == ''){ //verfied data object
    if(ddObjectId == '' || ddObjectId == 0){ // unverfied data object dropdown
      if(objectInput == ''){ // unverfied data object input
        alert('Warning! Object Name is Required.');
              $("#object_name").focus();
              return false;
      }
    }
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
              'ddObjectId':ddObjectId},
        url :"<?php echo base_url() ?>catalogueToCash/c_add_comp/addtokit", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          $(".loader").hide();
          if(data == 1){
            alert('Success! Component addded to kit');
                 $.ajax({
                  data:{'partCatalogueId':partCatalogueId,
                        'catalogueId':catalogueId,
                        'categoryId':categoryId,
                        'component_mpn':component_mpn
                      },
                  url :"<?php echo base_url() ?>catalogueToCash/c_add_comp/appendKitComponent", // json datasource
                  type: "post" ,
                  dataType: 'json',

                  success : function(data){
                    if(data){
                    var row_id         = data.totals;
                    var quantity       = data.result[0].QTY;
                     var alertMsg = "return confirm('Are you sure to delete?');";
                      var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_add_comp/cp_delete_component/'+cat_id+'/'+mpn_id+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID;

                      //console.log(data); return false;
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
                        if(quantity == '' || quantity == null) {var qty = 1 }else{ var qty = data.result[0].QTY;  }
                        if(avg_price == '' || avg_price == null) { var est_price = parseFloat(1.00) }else{ var est_price = avg_price;  }

                        var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);

                        if(amount == '' || amount == null) {var row_amount = parseFloat(0.00)}else{ var row_amount = amount;  }
                        //////////////////////////////

                        var ebay_price = (row_amount * (8 / 100)).toFixed(2); 
                        if(ebay_price == '' || ebay_price == null) {var row_ebay_price = parseFloat(0.00) }else{ var row_ebay_price = parseFloat(ebay_price).toFixed(2);  }
                        var paypal_price = parseFloat((parseFloat(row_amount)  * (2.5 / 100))).toFixed(2);
                       
                        var total = parseFloat(parseFloat(row_amount) + parseFloat(row_ebay_price) + parseFloat(paypal_price) + parseFloat(3.25)).toFixed(2);
                        


                        
                        var est_price_name = 'cata_est_price_'+row_id;

                       $('#kit-components-table').append('<tr> <td><a title="Delete Component" href="" onclick="'+alertMsg+'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> </a> </td> <td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td>'+data.result[0].MPN_DESCRIPTION+'</td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <div class="form-group" style="width: 200px;"> <select class="form-control selectpicker estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].PART_CATLG_MT_ID+'" rd = "'+row_id+'" data-live-search="true" style="width: 150px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+qty+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$'+avg_price+'" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+row_amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+row_ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+total+'</p></td></tr>');
                       
                         $("#estimate_condition_"+row_id).selectpicker();
                        }

                     
                  },
                complete: function(data){
                $(".loader").hide();
              }

            });

          }else if (data == 0){
            alert('Error! Component Not addded to kit');
          }else if(data == 2){
            alert('Warning! Component Already Exist in Kit');
          }
        },
      complete: function(data){
      $(".loader").hide();
    }

  });
});


/*=====  End of add to kit  ======*/
/*==================================
=            fetch object            =
==================================*/
$("body").on('click','.fetchobject', function(){

  var index =  $(this).attr("name");
  var categoryId = $('#search_component_table tr').eq(index).find('td').eq(2).text();
  if(categoryId == ''){
    alert('Error! Category Id Is Required');
    return false;

  }
 // console.log(mpnDesc);return false;
 $(".loader").show();
  $.ajax({
        data:{'categoryId':categoryId},
        url :"<?php echo base_url() ?>catalogueToCash/c_add_comp/fetch_object", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          $(".loader").hide();
          if(data != ''){
            //alert('if');
            var ddStart = '<div><select name="kit_object" id="kit_object" class="form-control selectpicker" data-live-search="true">';
            var option = '<option value="0">--- Select ---</option>';
            for(var i = 0; i< data.length; i++){
              option +='<option value="'+data[i].OBJECT_ID+'">'+ data[i].OBJECT_NAME +'</option>';
            }
            
            var ddEnd = '</select></div>';
            $('#search_component_table tr').eq(index).find('td').eq(1).html(ddStart+option+ddEnd);
            $('.selectpicker').selectpicker();
            $('#search_component_table tr').eq(index).find('td').eq(4).html('<input type="text" class="form-control" name="input_mpn" id="input_mpn" placeholder="Enter Part MPN" style="width:126px;">');
          }else{
            $('#search_component_table tr').eq(index).find('td').eq(1).text('No data Found');
          }
        },
         complete: function(data){
          $(".loader").hide();
    }

  });
});


/*=====  End of fetch object  ======*/
</script>