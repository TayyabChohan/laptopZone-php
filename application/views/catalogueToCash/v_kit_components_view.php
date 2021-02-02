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
              
              <div class="col-sm-6">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ESTIMATE DESCRIPTION">ESTIMATE DESCRIPTION:</label>
                    <input class="form-control" type="text" id="estimate_desc" name="estimate_desc" value="<?php echo htmlentities(@$data['detail'][0]['TITLE']); ?>"> 
                </div>
              </div>
              <div class="col-sm-4">
                  <div class="form-group p-t-24" style="font-size: 15px;">
                    <label for="ITEM URL">ITEM URL:</label>
                    <a target="_blank" href="<?php echo @$data['detail'][0]['ITEM_URL']; ?>"><?php echo @$data['detail'][0]['EBAY_ID']; ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php 
        if($data['copies']->num_rows() > 0)
                  {
      ?>
       <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Copy Estimate</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
          </div>
        </div>          
        <div class="box-body">
        <div class="col-sm-12"> <!-- Custom Tabs -->
          <table  id="copy-estimate-table" class="table table-responsive table-striped table-bordered table-hover">
            <thead>
              <th>ACTION</th>
              <th>COPY ESTIMATE</th>
              <th>EBAY ID</th>
              <th>CREATED AT</th>
              <th>CREATED BY</th>
              <th>ESTIMATE ID</th>
              <th>COMPONENTS</th>
            </thead>
            <tbody>
              <?php
             /* echo "<pre>";
              print_r($data['copies']->result_array());
              exit;*/
          ?>
            <?php 
            $u=1;
              foreach ($data['copies']->result_array() as $copy) {
                ?>
              <tr>
                <td>
                  <div class="form-group">
                     <button type="button" id="<?php echo $copy['LZ_BD_CATAG_ID']; ?>" ct_id="<?php echo $copy['CATEGORY_ID']; ?>" ct_id="<?php echo $copy['CATEGORY_ID']; ?>" title="Show Detail"  class="btn btn-sm btn-primary show_estimate" >Show Detail</button>
                  </div>
                </td>
                <td><?php if(!empty($copy['ESTIMATE_DESC'])){ echo $copy['ESTIMATE_DESC']; }else{ echo $u; }?>
                </td>
                <td><?php echo $copy['EBAY_ID']; ?></td>
                <td><?php echo $copy['EST_DATE_TIME']; ?></td>
                <td><?php echo ucfirst($copy['USER_NAME']); ?></td>
                <td><?php echo $copy['LZ_BD_ESTIMATE_ID']; ?></td>
                <td><?php echo $copy['COM_COUNT']; ?></td>
              </tr>
              <?php  
               $u++;
                  } ///end foreach 
                    ?>
                  
            </tbody> 
            </table> 
        </div>
    </div>
  </div>
  <?php
    } 
   ?>
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
                 $btn_color            = trim(strtolower(@$value['COLOR']));
                 $button_id = trim(str_replace(" ","_", $value['OBJECT_NAME']));
              ?>
                 <div class="col-sm-2" style="margin-bottom: 15px;">
                    <button type="button" id="<?php echo $button_id ?>" title="<?php echo @$value['OBJECT_NAME']; ?>" value="<?php echo @$value['OBJECT_NAME']; ?>" cls="<?php echo @$btn_color?>" class="btn btn-sm btn-block myInput <?php echo @$btn_color?>" style=""><?php echo @$value['OBJECT_NAME']; ?><?php  //echo " (".@$value['OBJECT_COUNT'].")"; ?></button>
                </div>
              <?php 
              endforeach; 
            ?>
            </div>
          </div>
        </div>
        <!-- end of ojbect button list -->
        <?php 
            $part_ids = [];
            $comp_name            = $this->session->userdata('comp_name');

            $part_ids             = $this->session->userdata('part_ids');
            $comp_name            = $this->session->userdata('comp_name');
            $comp_qty             = $this->session->userdata('comp_qty');
            
            $comp_avg_price       = $this->session->userdata('comp_avg_price');
            $comp_amount          = $this->session->userdata('comp_amount');
            $estAmount            = $this->session->userdata('estAmount');

            $ebay_fees            = $this->session->userdata('ebay_fees');
            $paypal_fees          = $this->session->userdata('paypal_fees');
            $ship_fees            = $this->session->userdata('ship_fees');
            $sub_totals           = $this->session->userdata('sub_totals');

               $t = 0;
                $total_checks         = '';
                $total_qtys           = '';
                $total_sold           = '';
                $total_estimate       = '';
                $total_amounts        = '';
                $total_ebays          = '';
                $total_paypals        = '';
                $total_shippings      = '';
                $total_count          = '';
             if (count($part_ids) > 0) {
              foreach (@$part_ids as $part_id) {
                
                $total_checks           += 1;
                $total_qtys             += trim($comp_qty[$t]);
                $total_sold             += trim($comp_avg_price[$t]);
                $total_amounts          += trim($comp_amount[$t]);
                $total_estimate         += trim($estAmount[$t]);
            

                $total_ebays            += trim($ebay_fees[$t]);
                $total_paypals          += trim($paypal_fees[$t]);
                $total_shippings        += trim($ship_fees[$t]);
                $total_count            += trim($sub_totals[$t]);
               
              $t++;
            }
          }
        ?>  
        <div class="box"><br>  
          <div class="box-body form-scroll"> 
            <div class="col-sm-12" style="margin-top: 20px;">
              <div class="col-sm-1 ">
              <div class="form-group pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 save_components" id="save_components">Save</button>
              </div>
            </div>
            <!-- estimate status -->  
            <div class="col-sm-3 ">
              <div class="form-group pull-left"> 
              <label for="stat" class="control-label" style="color: red">Select Status:</label>              
                 <select name="es_status" id = "es_status" class="form-control selectpicker" required="required" data-live-search="true">
                    <option value=''>Select Status </option>
                      <?php      
                        foreach ($data['estimate_status'] as $stat){
                            ?>
                            <option value="<?php echo $stat['FLAG_ID']; ?>" <?php //if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $stat['FLAG_NAME']; ?> </option>
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
            <!-- estimate status --> 
           

            </div>
            <div class="col-sm-12" style="margin-left: 42%; margin-top: 20px;">
              <div class="form-group pull-left" style="width: 80px;">
                  <label for="Checked Components">Checked:</label>
                  <input type="text" name="checked_components" value="<?php if(!empty($total_checks)){ echo $total_checks; }else{echo 0; }?>" class="form-control totalChecks" readonly> 
              </div>
              <div class="form-group pull-left" style="width: 80px; margin-left: 22px;">
                  <label for="Checked Components">Total QTY:</label>
                  <input type="text" name="total_component_qty"  id="total_component_qty" value="<?php if(!empty($total_qtys)){ echo $total_qtys; }else{echo 0; }?>" class=" form-control total_qty" readonly>
              </div> 
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Total Sold Price:</label>
                  <input type="text" name="total_sold_price" id="total_sold_price" value="<?php if(!empty($total_sold)){ echo '$ '.number_format((float)@$total_sold,2,'.',',');}else{echo '$0.00'; }?>" class=" form-control total_sold" readonly>
              </div>  
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Total Estimate:</label>
                  <input type="text" name="total_estimate_price" id="total_estimate_price" value="<?php if(!empty($total_estimate)){ echo '$ '.number_format((float)@$total_estimate,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control totals_estimate" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 15px;">
                  <label for="Checked Components">Total Amount:</label>
                  <input type="text" name="total_amount" id="total_amount" value="<?php if(!empty($total_amounts)){ echo '$ '.number_format((float)@$total_amounts,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control amounts" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Ebay Fee:</label>
                  <input type="text" name="total_ebay_fee" id="total_ebay_fee" value="<?php if(!empty($total_ebays)){ echo '$ '.number_format((float)@$total_ebays,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control total_ebay" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Paypal:</label>
                  <input type="text" name="total_paypal_fee" id="total_paypal_fee" value="<?php if(!empty($total_paypals)){ echo '$ '.number_format((float)@$total_paypals,2,'.',','); }else{ echo '$0.00'; }?>" class=" form-control total_paypal" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Shipping:</label>
                  <input type="text" name="total_ship_fee" id="total_ship_fee" value="<?php if(!empty($total_shippings)){ echo '$ '.number_format((float)@$total_shippings,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control total_shipping" readonly>
              </div>
              <div class="form-group pull-left" style="width: 85px; margin-left: 6px;">
                  <label for="Checked Components">Sub Total:</label>
                  <input type="text" name="totalClass" id="totalClass" value="<?php if(!empty($total_count)){ echo '$ '.number_format((float)@$total_count,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control totalClass" readonly>
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
                  <th></th>
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
                      $part_catlg_mt_id     = $result['PART_CATLG_MT_ID'];
                      $part_ids = [];
                      $categri_id           = $this->session->userdata('categri_id');
                      $catalog_mt_id        = $this->session->userdata('catalog_mt_id');
                      $catag_id             = $this->session->userdata('catag_id');
                      $mpn_desc             = $this->session->userdata('mpn_desc');
               
                      $part_ids             = $this->session->userdata('part_ids');
                      $comp_qty             = $this->session->userdata('comp_qty');
                      $comp_avg_price       = $this->session->userdata('comp_avg_price');
                      $comp_amount          = $this->session->userdata('comp_amount');
                      $estAmount            = $this->session->userdata('estAmount');
                      $condition_id         = $this->session->userdata('condition_id');

                      $ebay_fees            = $this->session->userdata('ebay_fees');
                      $paypal_fees          = $this->session->userdata('paypal_fees');
                      $ship_fees            = $this->session->userdata('ship_fees');
                      $sub_totals           = $this->session->userdata('sub_totals');
                      $kit_mt_ids           = $this->session->userdata('kit_mt_ids');
                         //var_dump($part_ids); exit;
                      if ($categri_id == $cat_id && $catalog_mt_id == $mpn_id && $catag_id == $cata_id) {
                        //var_dump($mpn_desc); 
                        //exit;
                          $mpn_descrip            = '';
                          $component_name         = '';
                          $component_qty          = '';
                          $component_avg_price    = '';
                          $component_amount       = '';
                          $component_est          = '';
                          $component_cond_id      = '';
                          $component_part_id      = '';
                          $row_ebay_fee           = '';
                          $row_paypal_fee         = '';
                          $row_ship_fee           = '';
                          $row_sub_total          = '';
                          $kit_mt_id          = '';
                      
                        if (count($part_ids) > 0) {
                          $s = 0;
                          foreach (@$part_ids as $part_id) {
                          if ($part_id == $part_catlg_mt_id) {
                            $mpn_descrip            = $mpn_desc[$s];
                            $component_name         = trim($comp_name[$s]);
                            $component_qty          = trim($comp_qty[$s]);
                            $component_avg_price    = trim($comp_avg_price[$s]);
                            $component_amount       = trim($comp_amount[$s]);
                            $component_est          = trim($estAmount[$s]);
                            $component_cond_id      = trim($condition_id[$s]);

                            $row_ebay_fee           = trim($ebay_fees[$s]);
                            $row_paypal_fee         = trim($paypal_fees[$s]);
                            $row_ship_fee           = trim($ship_fees[$s]);
                            $row_sub_total          = trim($sub_totals[$s]);
                            $kit_mt_id              = trim($kit_mt_ids[$s]);

                            $component_part_id      = trim($part_id);
                            
                            break;
                          }
                          $s++;
                        }
                      }

                  }
                      
                      ///var_dump(count(@$part_ids), @$part_catlg_mt_id, @$kit_mt_id, @$component_part_id); 
                      //var_dump($component_name, $component_qty, $component_avg_price, $component_amount, $component_cond_id, $component_part_id, $row_ebay_fee, $row_paypal_fee, $row_ship_fee, $row_sub_total, $mpn_descrip);
                  ?>
                    <tr <?php if(!empty($component_part_id)){ echo "class='row-color'"; } ?> >
                      <td>
                        <button title="Add Keyword" rd="<?php echo @$i; ?>" cat="<?php echo @$result['CATEGORY_ID']; ?>" mpn="<?php echo @$result['MPN']; ?>" class="btn btn-info btn-sm glyphicon glyphicon-save Keywords"  data-target="#addKeyword">
                        </button>
                      </td>
                      <td>
                        <?php echo @$result['OBJECT_NAME']; ?>
                        <input type="hidden" name="ct_kit_mpn_id_<?php echo $i; ?>" class="kit_componets" id="ct_kit_mpn_id_<?php echo $i; ?>" value="<?php echo @$result['MPN_KIT_MT_ID']; ?>">
                      </td>
                      <td>
                        <?php echo @$result['MPN']; ?>
                      </td>
                      <td>

                        <div style="width: 300px;">
                          <?php  
                       //var_dump(@$mpn_descrip);
                       //echo @$mpn_description; ?>
                          <div class="form-group">
                             <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc<?php echo $i; ?>" value=" <?php if(!empty(@$mpn_descrip)){ echo @$mpn_descrip;  }else{ echo htmlentities(@$result['MPN_DESCRIPTION']); } ?>" class="form-control kit_mpn_desc" style="width: 300px;">
                          </div>
                        </div>
                      </td>
                      <td>
                        <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id_<?php echo $i; ?>" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">

                        <input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="<?php echo @$result['MPN_KIT_MT_ID']; ?>">
                            <div class="form-group" style="width: 210px;">
                                <select class="form-control  estimate_condition"   name="estimate_condition" id="estimate_condition_<?php echo $i;?>" ctmt_id="<?php echo @$result['MPN_KIT_MT_ID']; ?>" rd = "<?php echo $i; ?>"  style="width: 203px;">
                                  <?php                                 
                                    foreach(@$data['conditions'] as $type) { 
                                    if ($type['ID'] == 3000 || $type['ID'] == @$component_cond_id){
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
                           <input type="checkbox" name="cata_component" ckbx_name="<?php echo @$result['OBJECT_NAME']; ?>" id="component_check_<?php echo $i; ?>" value="<?php echo $i; ?>" class="checkboxes validValue countings" style="width: 60px;" <?php if(!empty($component_part_id)){ echo "checked"; } ?>>
                           
                        </div>
                        
                      </td>
                      <td>
                        <?php 
                        $quantity = @$result['QTY']; ?>
                        <div class="form-group" style="width:70px;">
                          <input type="hidden" name="part_catalogue_mt_id" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                          <input type="number" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($component_qty)) {echo $component_qty; }elseif(!empty($quantity)){ echo $quantity;}else{ echo 1;}?>" style="width:60px;">
                        </div>
                      </td>
                      <td>
                      
                       <?php 
                      
                        // $mpn_id =$part_catlg_mt_id;
                        // $con = $cond_id;
                        // if(!empty($mpn_id))
                       if (empty($cond_id)) {

                         $cond_id = 3000;
                       }
                        $avg_query = $this->db2->query("SELECT T.AVG_PRICE MPN_AVG FROM MPN_AVG_PRICE T WHERE T.CONDITION_ID=$cond_id AND T.CATALOGUE_MT_ID =$part_catlg_mt_id");
                          // $barcode_no = $single_barcodeNo->result_array();
                          // $bar_code = $barcode_no[0]['BCD'];
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
                          <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php if(empty($component_avg_price)){ echo '$ '.number_format((float)@$mpn_avg_price,2,'.',','); }else{ echo $component_avg_price; } ?>" style="width:80px;" readonly>
                        </div>
                      </td> 
                    <td>
                      <?php $est_price_name="cata_est_price_".$i; 
                      ?>
                      <div class="form-group" style="width:80px;">
                        <input type="number" name="<?php echo $est_price_name; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price" value="<?php if(empty($component_est)){ echo $estimate_price= number_format((float)@$avg_price,2,'.',','); }else{ echo $component_est; } ?>" style="width:80px;">
                      </div>
                    </td>
                    <td>
                       <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="<?php if(!empty($component_amount)){ echo $component_amount; }else{ echo '$1.00'; } ?>" style="width:80px;" readonly>
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
                       <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php if(!empty($row_ebay_fee)){ echo $row_ebay_fee; }else{ echo '$ '.number_format((float)@$ebay_fee,2,'.',','); } ?>" style="width:80px;" readonly>
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
                        <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php if(!empty($row_paypal_fee)){ echo $row_paypal_fee; }else{ echo '$ '.number_format((float)@$paypal_fee,2,'.',','); } ?>" style="width:80px;" readonly>
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
                      <p id="cata_total_<?php echo $i; ?>" class="totalRow"><?php  if(!empty($row_sub_total)){ echo $row_sub_total; }else{ echo '$ '.number_format((float)@$total,2,'.',','); } ?></p>
                    </td>
                    <td><?php if(!empty($component_part_id)){ echo "sss"; }?></td>
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
              <div class="col-sm-12" style="margin-left: 42%; margin-top: 20px;">
              <div class="form-group pull-left" style="width: 80px;">
                  <label for="Checked Components">Checked:</label>
                  <input type="text" name="checked_components" value="<?php if(!empty($total_checks)){ echo $total_checks; }else{echo 0; }?>" class="form-control totalChecks" readonly> 
              </div>
              <div class="form-group pull-left" style="width: 80px; margin-left: 22px;">
                  <label for="Checked Components">Total QTY:</label>
                  <input type="text" name="total_component_qty"  id="total_component_qty" value="<?php if(!empty($total_qtys)){ echo $total_qtys; }else{echo 0; }?>" class=" form-control total_qty" readonly>
              </div> 
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Total Sold Price:</label>
                  <input type="text" name="total_sold_price" id="total_sold_price" value="<?php if(!empty($total_sold)){ echo '$ '.number_format((float)@$total_sold,2,'.',',');}else{echo '$0.00'; }?>" class=" form-control total_sold" readonly>
              </div>  
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Total Estimate:</label>
                  <input type="text" name="total_estimate_price" id="total_estimate_price" value="<?php if(!empty($total_estimate)){ echo '$ '.number_format((float)@$total_estimate,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control totals_estimate" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 15px;">
                  <label for="Checked Components">Total Amount:</label>
                  <input type="text" name="total_amount" id="total_amount" value="<?php if(!empty($total_amounts)){ echo '$ '.number_format((float)@$total_amounts,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control amounts" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Ebay Fee:</label>
                  <input type="text" name="total_ebay_fee" id="total_ebay_fee" value="<?php if(!empty($total_ebays)){ echo '$ '.number_format((float)@$total_ebays,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control total_ebay" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Paypal:</label>
                  <input type="text" name="total_paypal_fee" id="total_paypal_fee" value="<?php if(!empty($total_paypals)){ echo '$ '.number_format((float)@$total_paypals,2,'.',','); }else{ echo '$0.00'; }?>" class=" form-control total_paypal" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 16px;">
                  <label for="Checked Components">Total Shipping:</label>
                  <input type="text" name="total_ship_fee" id="total_ship_fee" value="<?php if(!empty($total_shippings)){ echo '$ '.number_format((float)@$total_shippings,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control total_shipping" readonly>
              </div>
              <div class="form-group pull-left" style="width: 85px; margin-left: 6px;">
                  <label for="Checked Components">Sub Total:</label>
                  <input type="text" name="totalClass" id="totalClass" value="<?php if(!empty($total_count)){ echo '$ '.number_format((float)@$total_count,2,'.',','); }else{echo '$0.00'; }?>" class=" form-control totalClass" readonly>
              </div>
            </div>

            <div class="col-sm-12" style="margin-top: 15px;">
               <input type="hidden" name="countrows" value="<?php echo $i-1; ?>" id="countrows">
              <div class="form-group col-sm-2 pull-left p-t-24">
                <button type="button" title="Add Component"  class="btn btn-primary" id="add_kit_component">Add Component</button>
              </div>
            
            <div class="col-sm-1 p-t-24">
              <div class="form-group pull-left">
                <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 save_components" id="save_components">Save</button>
              </div>
            </div>
           <!--  <div class="col-sm-1">
             <div class="form-group pull-left">
               <button type="button" title="Store Data"  class="btn btn-warning col-sm-offset-1 store_components" id="store_components">Store</button>
             </div>
           </div> -->
             <div class="col-sm-4">
              <label for="Cat Groups">Cat Groups :</label>
              <div class="form-group">
                <select class="form-control cats_group" data-live-search="true" name="cats_group" id="group_names">
                  <?php
                  foreach (@$data['cat_groups'] as $group) {
                    ?>
                    <option value="<?php echo $group['LZ_BD_GROUP_ID']; ?>"><?php echo $group['GROUP_NAME']; ?></option>
                  <?php }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-sm-2 p-t-24">
              <div class="form-group pull-right">
                <input class="form-control" type="text" name="kitmpnauto" id="kitmpnauto" value="<?php echo @$data['detail'][0]['MPN']; ?>">
              </div>
            </div>             
 
            <div class="col-sm-1 p-t-24">
              <div class="form-group pull-right">
                <button type="button" title="Create Auto Kit"  class="btn btn-primary" name="createAutoKit" id="createAutoKit">Create Auto Kit</button>
              </div>
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
                <div class="col-sm-4">
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

                          <input type="text" name="mpn_description" id="mpn_description" class="form-control mpn_description" onkeyup="countChar(this)" value="">
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
                    <th>UPC</th>
                    <th>ACTIVE PRICE</th>
                  </tr>
                </thead>
              </table>
            </form>
            </div><!-- /.col --> 
          </div>
          <!-- end second block start --> 
          <!-- COMPONENCT SERACH END -->  
      <!-- /.row -->
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>
    <!-- Modal -->
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
</div> <!-- end modal -->
<div id="addKeyword" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Keyword</h4>
      </div>
      <div class="modal-body">
        <section class="" style="height: 70px !important;"> 
          <div class="col-sm-12" >
            <div class="col-sm-3"></div>
            <div class="col-sm-5" id="errorMessage"></div>
          </div>
        </section>
       <div class="col-sm-12">
        <div class="col-sm-3">
          <div class="form-group">
            <label for="Feed Name">Feed Name:</label>
            <input name="feedName" type="text" id="feedName" class="feedName form-control " >
            <input name="feed_url_id" type="hidden" id="feed_url_id" class="feed_url_id form-control " >
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="Key Word">Keyword :</label>
            <input name="keyWord" type="text" id="keyWord" class="keyWord form-control " >
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label for="Key Word">Exculde Words :</label>
            <input name="excludedWords" type="text" id="excludedWords" class="excludedWords form-control" placeholder="Enter Comma Seprated Words" >
          </div>
        </div>   
        <div class="col-sm-3">
          <label for="Category ID">Category ID :</label>
          <div class="form-group" >
            <input name="rss_cat_id" type="text" id="rss_cat_id" class="rss_cat_id form-control" readonly="readonly">
          </div>
        </div>                                      
      </div> <!-- nested col-sm-12 div close-->
      <div class="col-sm-12">
       <div class="col-sm-3" >
        <label for="Mpn">Mpn :</label>
        <div class="form-group" id="mpnData">
          <input name="rss_mpn" type="text" id="rss_mpn" class="rss_mpn form-control" readonly="readonly">
          <input name="rss_mpn_id" type="hidden" id="rss_mpn_id" class="rss_mpn_id form-control">
        </div>
      </div>
       <div class="col-sm-4">
          <div class="form-group">
            <label for="Condition">Condition:</label>
              <input name="rss_condition" type="text" id="rss_condition" class="rss_condition form-control " readonly="readonly"> 
              <input name="rss_condition_id" type="hidden" id="rss_condition_id" class="rss_condition_id form-control "> 
          </div>
      </div>
      <div class="col-sm-2">
        <div class="form-group">
          <label for="Listing Type">Listing Type:</label>
            <select class="form-control  rss_listing_type"   name="rss_listing_type" id="rss_listing_type">
               <option value="BIN"> BIN</option>
               <option value="Auction"> Auction</option>
               <option value="All"> All</option>                    
            </select> 
        </div>
      </div> 
      <div class="col-sm-2 p-t-24">
        <div class="form-group">
          <input type="button" class="btn btn-success pull-right" id="addUrl" name="addUrl" value="ADD URL" style="display: none;">
          <input type="button" class="btn btn-warning pull-right" id="updateUrl" name="updateUrl" value="UPDATE URL" style="display: none;">
        </div>
      </div>
      </div> <!-- box body div close-->
      </div>
      <div class="modal-footer">
        <button type="button" id="clearData" class="btn btn-info btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> <!-- end modal -->
  <!-- Modal -->
<!-- Modal -->
<div id="show_estimate" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Details</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="box" style="border-color: blue !important;">
                        <div class="box-header " style="background-color: #ADD8E6 !important;">
                          <h1 class="box-title" style="color:white;">Qty Detail</h1>
                          <div class="box-tools pull-right">
                            
                          </div>
                        </div> 
                        <div class="box-body form-scroll">
                          <div class="col-sm-12" style="margin-top: 20px;">
                            <div class="col-sm-1 col-sm-offset-5">
                              <div class="form-group pull-left">
                                <button type="button" title="Copy Catalogue"  class="btn btn-success col-sm-offset-1 copy_catalogue" id="copy_catalogue">Copy</button>
                                <input type="hidden" name="copy_cat_id" id="copy_cat_id">
                                <input type="hidden" name="copy_catag_id" id="copy_catag_id">
                              </div>
                            </div>
                          </div>
                          <div class="col-md-12">

                            <table id="estimate_detail_table" class="table table-responsive table-striped table-bordered table-hover ">

                              <thead>
                                  <th style="color: black;">COMPONENTS</th>
                                  <th style="color: black;">MPN</th>
                                  <th style="color: black;">MPN DESCRIPTION</th>
                                  <th style="color: black;">CONDITIONS</th>
                                  <th style="color: black;">QTY</th>
                                  <th style="color: green;">SOLD PRICE</th>
                                  <th style="color: black;">ESTIMATED PRICE</th>
                                  <th style="color: black;">AMOUNT</th>
                                  <th style="color: black;">EBAY FEE</th>
                                  <th style="color: black;">PAYPAL FEE</th>
                                  <th style="color: black;">SHIP FEE</th>
                                  <th style="color: black;">TOTAL</th>
                              </thead>
                              <tbody>
                              </tbody>
                            </table>
                          </div>
                          <div class="col-sm-12" style="margin-top: 20px;">
                            <div class="col-sm-1 col-sm-offset-5">
                              <div class="form-group pull-left">
                                <button type="button" title="Copy Catalogue"  class="btn btn-success col-sm-offset-1 copy_catalogue" id="copy_catalogue">Copy</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
            </div>
        </div>
    </div>
</div>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>
$(document).ready(function()
  {
    $('.hide_component').hide();
     //Setup - add a text input to each footer cell
    /* var g= 0;
      $('#kit-components-table tfoot th').each(function () {
          var title = $(this).text();

          if (title != "" && g < 4 ) {
            if (g!=0) {
              $(this).html('<input type="text" class="form-control col-search-'+g+'" placeholder="Search '+title+'" />');
            }
          }
          g++;
      });*/
    //////////////////////////////
    setTimeout(function() {
          $('#success_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    setTimeout(function() {
          $('#error_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    setTimeout(function() {
          $('#warning_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
    setTimeout(function() {
          $('#compo_msg').fadeOut(1000);
        }, 1000);
    /////////////////////////////
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
      { className: "textColor", "targets": [ 14 ] },
      { "targets": 0, "orderable": false, "searching": false }
      ],
      //"stateSave": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });

     var est_table = $('#estimate_detail_table').DataTable({
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
      "columnDefs": [
      { "targets": 0, "orderable": false, "searching": false }
      ],
      //"stateSave": true,
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
     //Apply thesearch
         // DataTable
     /* var table = $('#kit-components-table').DataTable();
        table.columns().every(function () {
            var that = this;
 
            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });*/
       ///////////////////INDIVIDUAL ECOLUMN SEARCH END////////////////////////////
 
       /* $(document).on( 'click', '.myInput', function () {
            table
                .columns([1])
                .search( this.value )
                .draw();
        } );*/
 
    // Apply the search
 
    ///////////////////INDIVIDUAL ECOLUMN SEARCH END////////////////////////////

    $('.myInput').on( 'click', function () {
        table.search( this.value ).draw();
    } );
    $('#showAll').on( 'click', function () {
        table.search( this.value ).draw();
    } );

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
        url :"<?php //echo base_url().'catalogueToCash/c_purchasing/loadCatalogues/'.$cat_id.'/'.$mpn_id.'/'.$cata_id; ?>", // json datasource
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

  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  //post remarks drop down //
  //Get Brands against Laptop
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

  //post remarks drop down //
  
  $(document).on('click', ".save_components", function(event){
     event.preventDefault();
    $('#showAll').click();

    var es_status = $('#es_status').val();  
    var discard_remarks = $('#discard_remarks').val();  

    // alert(discard_remarks);
    // return false;

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
      var red_flag= '<?php echo $this->uri->segment(7); ?>';
      var estimate_desc = $("#estimate_desc").val();
      var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/savekitComponents';
      var partsCatalgid = [];
      var compName=[];
      var compQty=[];
      var compAvgPrice=[];
      var compAmount=[];
      var ebayFee=[];
      var payPalFee=[];
      var shipFee=[];
      var tech_condition=[];
      var mpn_description=[];
      var kit_mt_ids=[];


      var tableId="kit-components-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[type='checkbox']:checked"), function()
      {            
        arr.push($(this).val());
      });
    //alert(arr);
    console.log(arr, arr.length); 
    //category_id.push($(tdbk.rows[1].cells[2]).text());
       for (var i = 0; i < arr.length; i++)
          {
            //compName.push($(tdbk.rows[arr[i]].("#ct_kit_mpn_id_"+(i+1))).val());
            $(tdbk.rows[arr[i]]).find(".part_catlg_mt_id").each(function() {
              partsCatalgid.push($(this).val());
            });

            $(tdbk.rows[arr[i]]).find(".kit_mt_ids").each(function() {
              kit_mt_ids.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".estimate_condition").each(function() {
              tech_condition.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".kit_componets").each(function() {
                    compName.push($(this).val());
                  });
            $(tdbk.rows[arr[i]]).find(".kit_mpn_desc").each(function() {
                    mpn_description.push($(this).val());
                  }); 

             $(tdbk.rows[arr[i]]).find(".component_qty").each(function() {
                    compQty.push($(this).val());
                  }); 

              $(tdbk.rows[arr[i]]).find('.cata_avg_price').each(function() {
                compAvgPrice.push($(this).val());
              }); 
              //console.log(partsCatalgid, compName);
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
          mpn_description = mpn_description.filter(v=>v!='');
        //console.log(i, partsCatalgid, compName, mpn_description); 
        //return false;
          //console.log(partsCatalgid); 
       if (compAmount.length < shipFee.length) {
            alert("Warning: Please Insert Estimate Price of Selected Components");
            return false;
          }else if(estimate_desc ==""){
            alert("Warning: Please Insert Estimate Description");
            $("#estimate_desc").focus();
            return false;
          }else if (mpn_description.length < shipFee.length) {
            alert("Warning: MPN Description is required for all selected components.");
            return false;
          }else{
              $(".loader").show();
                $.ajax({
                  type: 'POST',
                  url:url,
                  data: {
                    'cat_id': cat_id,
                    'dynamic_cata_id': dynamic_cata_id,
                    'mpn_id': mpn_id,
                    'compName': compName,
                    'mpn_description': mpn_description,
                    'compQty': compQty,
                    'compAvgPrice': compAvgPrice,
                    'compAmount': compAmount,
                    'ebayFee': ebayFee,
                    'payPalFee': payPalFee,
                    'shipFee': shipFee,
                    'partsCatalgid':partsCatalgid,
                    'kit_mt_ids':kit_mt_ids,
                    'estimate_desc':estimate_desc,
                    'tech_condition':tech_condition,
                    'es_status':es_status,
                    'discard_remarks':discard_remarks
                  },
                  dataType: 'json',
                  success: function (data){
                       if(data == 0){
                          alert('Warning: Data is already inserted against this catalogue!');
                           window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/updateEstimate/'+cat_id+'/'+mpn_id+'/'+dynamic_cata_id;

                       }else if(data == 1){
                        if(red_flag == 1111){
                          alert("Success: Estimate is created!"); 
                          window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/updateEstimate/'+cat_id+'/'+mpn_id+'/'+dynamic_cata_id;

                        }else{
                          alert("Success: Estimate is created!"); 
                          window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/updateEstimate/'+cat_id+'/'+mpn_id+'/'+dynamic_cata_id;
                          }  
                       }else if(data == 2){
                         alert('Error: Fail to create estimate!');
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
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  /*==================================================
  =            FOR ADDING KIT COMPONENTS             =
  ===================================================*/
  $(document).on('change', ".validValue ", function(event){  
      event.preventDefault();
      var arr=[];
      var cat_id= '<?php echo $this->uri->segment(4); ?>';
      var mpn_id= '<?php echo $this->uri->segment(5); ?>';
      var dynamic_cata_id= '<?php echo $this->uri->segment(6); ?>';
      var red_flag= '<?php echo $this->uri->segment(7); ?>';
      var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/components_session';
      var partsCatalgid = [];
      var compQty=[];
      var compAvgPrice=[];
      var compAmount=[];
      var estAmount=[];
      var tech_condition=[];
      var compName=[];
      var ebayFee=[];
      var payPalFee=[];
      var shipFee=[];
      var sub_total=[];
      var mpn_description=[];
      var kit_mt_ids=[];

      var tableId="kit-components-table";
      var tdbk = document.getElementById(tableId);
      $.each($("#"+tableId+" input[type='checkbox']:checked"), function()
      {            
        arr.push($(this).val());
      });
      //alert(arr);
      //console.log(arr); 
      //category_id.push($(tdbk.rows[1].cells[2]).text());
       for (var i = 0; i < arr.length; i++)
          {
             $(tdbk.rows[arr[i]]).find("td").eq(1).each(function() {
              compName.push($(this).text());
            });

            $(tdbk.rows[arr[i]]).find(".part_catlg_mt_id").each(function() {
              partsCatalgid.push($(this).val());
            });
             $(tdbk.rows[arr[i]]).find(".kit_mt_ids").each(function() {
              kit_mt_ids.push($(this).val());
            });
            $(tdbk.rows[arr[i]]).find(".kit_mpn_desc").each(function() {
                    mpn_description.push($(this).val());
                  });
            $(tdbk.rows[arr[i]]).find(".estimate_condition").each(function() {
              tech_condition.push($(this).val());
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
                 estAmount.push($(this).val()); 
                }
                
              });  
              $(tdbk.rows[arr[i]]).find('.cata_ebay_fee').each(function(){
                ebayFee.push($(this).val());
              });
              $(tdbk.rows[arr[i]]).find('.cata_amount').each(function(){
                compAmount.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_paypal_fee').each(function(){
                payPalFee.push($(this).val());
              });

              $(tdbk.rows[arr[i]]).find('.cata_ship_fee').each(function(){
                shipFee.push($(this).val());
              });
              $(tdbk.rows[arr[i]]).find('.totalRow').each(function(){
                sub_total.push($(this).text());
              });           
          }

          tech_condition = tech_condition.filter(v=>v!='');
          //console.log(estAmount, mpn_description); return false;
          //console.log(partsCatalgid);
          ///$(".loader").show();
                $.ajax({
                  type: 'POST',
                  url:url,
                  data: {
                    'cat_id': cat_id,
                    'dynamic_cata_id': dynamic_cata_id,
                    'mpn_id': mpn_id,
                    'compQty': compQty,
                    'mpn_description': mpn_description,
                    'compAvgPrice': compAvgPrice,
                    'compAmount': compAmount,
                    'estAmount': estAmount,
                    'partsCatalgid':partsCatalgid,
                    'kit_mt_ids':kit_mt_ids,
                    'compName':compName,
                    'ebayFee': ebayFee,
                    'payPalFee': payPalFee,
                    'shipFee': shipFee,
                    'sub_total': sub_total,
                    'tech_condition':tech_condition
                  },
                  dataType: 'json',
                  success: function (data){ 
                     }
            });
  });
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('click','.countings', function(){
    var table = $('body #kit-components-table').DataTable();
    var bg_class            = this.id; 
    var est_id              = $(this).val();
    /*var total_check         = $(".totalChecks").val();
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
    var row_total           = $("#cata_total_"+est_id).text().replace(/\$/g, '').replace(/\ /g, '');*/

    var current_check       = $(this).prop("checked");
    //console.log(total_check, total_qty, total_solds, qty, sold_price); //return false;
    if (current_check) {
      $("#"+bg_class).closest('tr').addClass('row-color');
      table.cell( $(this).closest('tr'), 14 ).data('sss');
      $("#cata_component_qty_"+est_id).prop('readonly', true);
      $("#cata_est_price_"+est_id).prop('readonly', true);
      $("#estimate_condition_"+est_id).attr("disabled", true); 

     /* total_check           = parseFloat(total_check) + 1;
      total_qty             = parseFloat(parseFloat(total_qty) + parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) + parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) + parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) + parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) + parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) + parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) + parseFloat(ship_fee)).toFixed(2);
      sub_total             = parseFloat(parseFloat(current_totals) + parseFloat(row_total)).toFixed(2);*/
       
    }else{
      $("#"+bg_class).closest('tr').removeClass('row-color');
      table.cell( $(this).closest('tr'), 14 ).data('');
      $("#"+bg_class).closest('tr').css('backgroundColor', '');
      $("#cata_component_qty_"+est_id).prop('readonly', false);
      $("#cata_est_price_"+est_id).prop('readonly', false);
      $("#estimate_condition_"+est_id).attr("disabled", false); 
     /* total_check           = parseFloat(total_check) - 1;
      total_qty             = parseFloat(parseFloat(total_qty) - parseFloat(qty));
      solds                 = parseFloat(parseFloat(total_solds) - parseFloat(sold_price)).toFixed(2);
      estimates             = parseFloat(parseFloat(total_estimates) - parseFloat(est_price)).toFixed(2);
      amounts               = parseFloat(parseFloat(amounts) - parseFloat(cata_amount)).toFixed(2);
      total_ebays           = parseFloat(parseFloat(total_ebay) - parseFloat(ebay_fee)).toFixed(2);
      paypal_fee            = parseFloat(parseFloat(total_paypal) - parseFloat(paypal_fee)).toFixed(2);
      total_shipping        = parseFloat(parseFloat(total_shipping) - parseFloat(ship_fee)).toFixed(2);
      sub_total             =  parseFloat(parseFloat(current_totals) - parseFloat(row_total)).toFixed(2);*/  
    }

     /*$(".totalChecks").val(total_check);
     $(".total_qty").val(total_qty);
     $(".total_sold").val('$'+solds);
     $(".total_estimate").val('$'+estimates);
     $(".amounts").val('$'+amounts);
     $(".total_ebay").val('$'+total_ebays);
     $(".total_paypal").val('$'+paypal_fee);
     $(".total_shipping").val('$'+total_shipping);
     $(".totalClass").val('$'+sub_total);*/
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
      var total_estimates     = $(".totals_estimate").val().replace(/\$/g, '').replace(/\ /g, '');
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
      }
      
    });
    }else{
    $('.validValue').each(function(){  
     //.prop('disabled',false);
       id2 = this.id;
       var componenet_name2 =  $('#'+id2).attr("ckbx_name");

       var dubplicat_checkbox = $('#'+id2).prop('checked');

      if(componenet_name2 == componenet_name && dubplicat_checkbox == true){
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
        sub_total             =  parseFloat(parseFloat(current_totals) - parseFloat(row_total)).toFixed(2);

      //////////////////////////////////////////////////////////////
   }
     $(".totalChecks").val(total_check);
     $(".total_qty").val(total_qty);
     $(".total_sold").val('$'+solds);
     $(".totals_estimate").val('$'+estimates);
     $(".amounts").val('$'+amounts);
     $(".total_ebay").val('$'+total_ebays);
     $(".total_paypal").val('$'+paypal_fee);
     $(".total_shipping").val('$'+total_shipping);
     $(".totalClass").val('$'+sub_total);

});
  
   /*==============================================================
  =               FOR SAVING KIT PARTS                           =
  ================================================================*/
$(".copy_catalogue").on('click', function(){
      var from_cata_id        = $("#copy_catag_id").val();   
      var estimate_desc       = $("#estimate_desc").val();   
      var cat_id              = $("#copy_cat_id").val(); 
      var mpn_id              = '<?php echo $this->uri->segment(5); ?>';
      var to_cata_id          = '<?php echo $this->uri->segment(6); ?>';
      //console.log(from_cata_id, cat_id, mpn_id, to_cata_id); return false;
      var url                 = '<?php echo base_url(); ?>catalogueToCash/c_purchasing_copy/assignCatalogueToKit';
      $(".loader").show();
      $.ajax({
        type: 'POST',
        url:url,
        data: {
          'cat_id': cat_id,
          'mpn_id': mpn_id,
          'from_cata_id': from_cata_id,
          'to_cata_id': to_cata_id,
          'estimate_desc': estimate_desc

        },
        dataType: 'json',
        success: function (data){
         if(data== 1){
          alert("Success: Catalogue is assigned successfully!"); 
           $(".loader").hide();
          window.location.href = '<?php echo base_url(); ?>/catalogueToCash/c_purchasing/updateEstimate/'+cat_id+'/'+mpn_id+'/'+to_cata_id;
           return false;
         
         }else if(data== 0){
          alert('Error: Failed to assign catalogues!');
           $(".loader").hide();
           return false;
         }
       },
       complete: function(data){
        $(".loader").hide();
        return false;
        },
       error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
          return false;
        }
      }
  });
});
  // $(document).on('click', '.show_estimate', function(){
  //   $('#show_estimate').modal('show');
  // });

  /*=======================================
=            rss Table popup            =
=======================================*/
  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
  $(document).on('blur', ".cata_est_price", function(){
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
               var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/cp_delete_component/'+category_id+'/'+master_mpn+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
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
                        table.row.add( $('<tr> <td></td> <td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td><div style="width: 300px;"> <div class="form-group"> <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc'+row_id+'" value="'+part_mpn_description+'" class="form-control kit_mpn_desc" style="width: 300px;"> </div> </div></td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"><input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="'+data.result[0].MPN_KIT_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].MPN_KIT_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+quantity+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$'+ship_price+'" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+sub_total+'</p></td><td></td></tr>')).draw();
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
  /*==============================================================
  =   END FUNCTION FOR CHARGES CALCULATION FROM ESTIMATE PRICE   =
  ================================================================*/
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
    $(document).on('blur', ".component_qty", function(){
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
    var total = parseFloat(parseFloat(amount) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+qty_id).html('$ '+total);
    /////////////////////////////////////
  });

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
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
/*==============================================================
  =                 GET RELATED BRANDS ON CHANGE OBJECTS           =
  ================================================================*/
  /*$(document).on('change','#comp_object', function(){
  var comp_object     = $(this).val(); 
   //alert(comp_object); return false;
  $(".loader").show();
  $.ajax({
    url:'<?php //echo base_url(); ?>catalogueToCash/c_purchasing/get_brands',
    type:'post',
    dataType:'json',
    data:{'object_id':comp_object},
    success:function(data){
      var brands = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.length;i++){
        brands.push('<option value="'+data[i].SPECIFIC_VALUE+'">'+data[i].SPECIFIC_VALUE+'</option>')
      }
      $('#comp_brands').html("");
      $('#comp_brands').append('<select name="comp_brand" id="comp_brand" class="form-control comp_brand" data-live-search="true" required><option value="0">---select---</option>'+brands.join("")+'</select>');
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
});*/

  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '#comp_object', function(){

  var object_id            = $(this).val();
  var object_name          = $("#comp_object option:selected").text();
  var category_id          = $("#comp_category").val();
  $(".loader").show();
  $.ajax({
    url:'<?php echo base_url(); ?>catalogueToCash/c_purchasing/get_mpns',
    type:'post',
    dataType:'json',
    data:{'object_id':object_id, 'category_id':category_id, 'object_name':object_name},
    success:function(data){
       if (data.allow == 1) {
        $("#search_components").hide();
        $("button #add_mpn").prop('disabled',true);
      }
      var mpns = [];
       // alert(data.length);return false;
      for(var i = 0;i<data.mpn.length;i++){
        mpns.push('<option value="'+data.mpn[i].CATALOGUE_MT_ID+'">'+data.mpn[i].MPN+'</option>');
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

    ////console.log(new_upc, comp_mpn, comp_object.length, comp_mpn.length); 
    //return false;
     if( comp_category == 0 || comp_category == undefined){
    alert('Warning: Category is required!');
  }else if(comp_object == '' || comp_object == null || comp_object == undefined || comp_object == '---select---'){
    alert('Warning: Object is required!');
    return false;
  }else if( comp_mpn == '' || comp_mpn == null || comp_mpn == undefined || comp_mpn == '---select---'){
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

  $("#add_object").click(function(){
    $("#objectDiv").toggle();
    });
  $("#go_back").click(function(){
      $("#add_mpn_section").hide();
      $(".hide-component").show();
        $("#mpn_category").val('');
        $("#mpn_object").val('');
        $("#mpn_brand").val('');
        $("#new_mpn").val('');
    });

  /*==============================================================
  =            FOR TOGGLING ADD COMPONENT FIELDS                 =
  ================================================================*/
  $("#createAutoKit").click(function(){
    var ct_catlogue_mt_id = $("#ct_catlogue_mt_id").val();
    var kitmpnauto = $("#kitmpnauto").val();
    var group_id = $("#group_names").val();

    var url='<?php echo base_url() ?>catalogueToCash/c_purchasing/createAutoKit';
    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {'kitmpnauto': kitmpnauto, 'ct_catlogue_mt_id': ct_catlogue_mt_id, 'group_id': group_id},
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
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }
  });    
    //alert(mpn);return false;
  });


});

/*==============================================================
=                ON CHANGE ESTIMATE CONDITION                  =
================================================================*/
  $('body').on('change', '.estimate_condition', function(){
    var est_id               = $(this).attr("id");
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
  //console.log(input_upc, inputText);
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
              'input_upc':input_upc,
              'ddObjectId':ddObjectId,
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
               var delete_comp = '<?php echo base_url(); ?>catalogueToCash/c_purchasing/cp_delete_component/'+cat_id+'/'+mpn_id+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
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
                  
                        var est_price_name = 'cata_est_price_'+row_id;
                        var table = $('body #kit-components-table').DataTable();
                        table.row.add( $('<tr> <td></td> <td>'+data.result[0].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+row_id+'" class="kit_componets" id="ct_kit_mpn_id_'+row_id+'" value="'+data.result[0].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[0].MPN+'</td><td><div style="width: 300px;"> <div class="form-group"> <input type="text" name="kit_mpn_desc"  id="kit_mpn_desc'+row_id+'" value="'+part_mpn_description+'" class="form-control kit_mpn_desc" style="width: 300px;"> </div> </div></td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"><input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="'+data.result[0].MPN_KIT_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].MPN_KIT_MT_ID+'" rd = "'+row_id+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td> <div style="width: 70px;"> <input type="checkbox" name="cata_component" ckbx_name="'+data.result[0].OBJECT_NAME+'" id="component_check_'+row_id+'" value="'+row_id+'" class="checkboxes validValue countings" style="width: 60px;"> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[0].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="'+quantity+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$'+amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$'+ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$'+ship_price+'" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$'+sub_total+'</p></td><td></td></tr>')).draw();
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
        url :"<?php echo base_url() ?>catalogueToCash/c_purchasing/fetch_object", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          $(".loader").hide();
          if(data != ''){
            //alert('if');
            var ddStart = '<div><select name="kit_object" id="kit_object" class="form-control selectpicker objectIs" data-live-search="true">';
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
    },
      error: function(jqXHR, textStatus, errorThrown){
         $(".loader").hide();
        if (jqXHR.status){
          alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
        }
    }

  });
});

function countChar(val) {
    var len = val.value.length;
    //console.log(len);
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(80 - len);
    }
  }
/*=====  End of fetch object  ======*/
 /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 


$(document).on('click','.show_estimate',function(){
  var lz_bd_cata_id = $(this).attr("id");
  var cat_id = $(this).attr("ct_id");
  //console.log(lz_bd_cata_id); 
  //return false;
  $(".loader").show();
    $.ajax({
        url: '<?php echo base_url(); ?>/catalogueToCash/c_purchasing/estimate_detail', 
        type: 'post',
        dataType: 'json',
        data : {'lz_bd_cata_id':lz_bd_cata_id},
        success:function(data){
          console.log(data); 
          //return false;
          $('#show_estimate').modal('show');
          $(".loader").hide();
          $("#copy_cat_id").val(cat_id);
          $("#copy_catag_id").val(lz_bd_cata_id);

          for(var i=0;i<data.result.length;i++){
            //alert(data.result.length); return false;
            var j = i+1;
             var mpns = [];
                 // alert(data.length);return false;
                for(var h = 0;h<data.conditions.length; h++){
                  if (data.result[i].TECH_COND_ID == data.conditions[h].ID){
                                  var selected = "selected";
                                }else {
                                    var selected = "";
                                }

                  mpns.push('<option value="'+data.conditions[h].ID+'" '+selected+'>'+data.conditions[h].COND_NAME+'</option>')
                }
               var quantity       = data.result[i].QTY;
               var est_price       = data.result[i].EST_SELL_PRICE;
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
                //console.log(); return false;

             var est_price_name = 'cata_est_price_'+j;

             var table = $('#estimate_detail_table').DataTable();
              table.row.add( $('<tr style="color:black;"> <td>'+data.result[i].OBJECT_NAME+' <input type="hidden" name="ct_kit_mpn_id_'+j+'" class="kit_componets" id="ct_kit_mpn_id_'+j+'" value="'+data.result[i].MPN_KIT_MT_ID+'"> </td> <td>'+data.result[i].MPN+'</td><td><div style="width: 300px;">'+data.result[i].MPN_DESCRIPTION+'</div></td><td> <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id" value="'+data.result[i].PART_CATLG_MT_ID+'"><input type="hidden" class="kit_mt_ids" name="kit_mt_ids" id="kit_mt_ids" value="'+data.result[i].MPN_KIT_MT_ID+'"> <div class="form-group" style="width: 210px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+j+'" ctmt_id="'+data.result[i].MPN_KIT_MT_ID+'" rd = "'+j+'" style="width: 203px;">'+mpns.join("")+'</select> </div> </td><td><div class="form-group" style="width:70px;"> <input type="hidden" name="part_catalogue_mt_id" value="'+data.result[i].PART_CATLG_MT_ID+'"> <input type="number" name="cata_component_qty_'+j+'" id="cata_component_qty_'+j+'" rowid="'+j+'" class="form-control input-sm component_qty" value="'+quantity+'" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+j+'" id="cata_avg_price_'+j+'" class="form-control input-sm cata_avg_price" value="$0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+est_price_name+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+j+'" id="cata_amount_'+j+'" class="form-control input-sm cata_amount" value="$'+amount+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+j+'" id="cata_ebay_fee_'+j+'" class="form-control input-sm cata_ebay_fee" value="$'+ebay_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+j+'" id="cata_paypal_fee_'+j+'" class="form-control input-sm cata_paypal_fee" value="$'+paypal_price+'" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_1" id="cata_ship_fee_'+j+'" class="form-control input-sm cata_ship_fee" value="$'+ship_price+'" style="width:80px;" readonly> </div></td><td><p id="cata_total_'+j+'" class="totalRow">$'+sub_total+'</p></td></tr>')).draw();
          }

        }
    });
  
  // alert(category_id);
});
/*=====  End of rss Table popup  ======*/

/*=====  End of Onload calculation  ======*/

$(document).on('click','.Keywords',function(){
  $(this).removeClass('btn-info').addClass('btn-success');
  var rss_condition = "";
  var row_id            = $(this).attr("rd");
  var rss_cat_id        = $(this).attr("cat");
  var rss_mpn           = $(this).attr("mpn");
  var rss_mpn_id        = $("#part_catlg_mt_id_"+row_id).val(); 
  var condition_id      = $("#estimate_condition_"+row_id).val(); 
  //console.log(rss_cat_id, rss_mpn_id, condition_id);
  $.ajax({
    url:'<?php echo base_url();?>/catalogueToCash/c_purchasing/getRssUrlData',
    type:'post',
    dataType:'json',
    data:{
      'condition_id':condition_id,
      'rss_mpn_id':rss_mpn_id,
      'rss_cat_id':rss_cat_id,
    },
    success:function(data){
      if(data.res == 1){
        $('#addKeyword').modal('show');
        $("#updateUrl").show();
        $("#addUrl").hide();
        var rss_feed_name = data.urls[0].FEED_NAME;
        var rss_keyword = data.urls[0].KEYWORD;
        var rss_exclude_words = data.urls[0].EXCLUDE_WORDS;
        var feed_url_id = data.urls[0].FEED_URL_ID;
        console.log(rss_exclude_words);
        if(rss_exclude_words == '' || rss_exclude_words == null || rss_exclude_words.length == 0){
           var arr =[];
        }else{
          var arr = rss_exclude_words.split('-');
        }
        
           
        //console.log(arr.length, arr); 
        //return false;
          if (condition_id == 1000) {
                rss_condition = "New";
            }else if (condition_id == 1500) {
                rss_condition = "New other";
            }else if (condition_id == 2000) {
                rss_condition = "Manufacturer refurbished";
            }else if (condition_id == 2500) {
                rss_condition = "Seller refurbished";
            }else if (condition_id == 7000) {
                rss_condition = "For parts or not working";
            }else{
              rss_condition = "Used";
            }
            //console.log(rss_cat_id, rss_mpn, condition_id, rss_condition); return false;
            $('#feedName').val(rss_feed_name); 
            $('#feed_url_id').val(feed_url_id); 
            $('#keyWord').val(rss_keyword); 
            var exclude_val = '';
           arr = arr.filter(v=>v!='');
           console.log(arr.length, (parseInt(arr.length) - parseInt(1)), arr);
            for(var p=0; p<= arr.length; p++){
              if(p == 0){

              }else if(p == arr.length){
                
              }else if(p == (parseInt(arr.length) - parseInt(1))){
                exclude= arr[p];
                 console.log(p, arr.length, 'j', exclude);
                 if (exclude == "" || exclude == undefined) {
                  
                 }else{
                  exclude_val+= arr[p];
                 }
              }else{
                
                exclude= arr[p];
                console.log(p, arr.length, 'h', exclude);
                 if (exclude == "" || exclude == undefined) {
                  
                 }else{
                  exclude_val+= arr[p]+", ";
                 }
                 
              }
            }
            $('#excludedWords').val(exclude_val);

            $("#rss_cat_id").val(rss_cat_id);
            $("#rss_mpn").val(rss_mpn);
            $("#rss_mpn_id").val(rss_mpn_id);
            //$('#addKeyword').modal('show');
            $("#rss_condition").val(rss_condition);
            $("#rss_condition_id").val(condition_id);
            // alert(category_id);
      }else if(data.res == 0){
          $('#addKeyword').modal('show');
          $("#updateUrl").hide();
          $("#addUrl").show();
        if (condition_id == 1000) {
                rss_condition = "New";
            }else if (condition_id == 1500) {
                rss_condition = "New other";
            }else if (condition_id == 2000) {
                rss_condition = "Manufacturer refurbished";
            }else if (condition_id == 2500) {
                rss_condition = "Seller refurbished";
            }else if (condition_id == 7000) {
                rss_condition = "For parts or not working";
            }else{
              rss_condition = "Used";
            }
            //console.log(rss_cat_id, rss_mpn, condition_id, rss_condition); return false;
            $("#rss_cat_id").val(rss_cat_id);
            $("#rss_mpn").val(rss_mpn);
            $("#rss_mpn_id").val(rss_mpn_id);
            //$('#addKeyword').modal('show');
            $("#rss_condition").val(rss_condition);
            $("#rss_condition_id").val(condition_id);
            // alert(category_id);
      }
    },
  });
});
/*=====  End of save mpn function  ======*/
/*=====  End of save mpn function  ======*/

  $(document).on('click','#addUrl', function(){
    var feedName = $('#feedName').val();
   
    if(feedName.trim() == ''){
      $('#addKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Please Insert Feed Name !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#feedName').focus();
      return false;
    }
     //alert(feedName); return false;
    var keyword = $('#keyWord').val();
    if(keyword.trim() == ''){
      $('#addKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Please Insert Keyword !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#keyWord').focus();
      return false;
    }
    var category_id = $('#rss_cat_id').val();
    if(category_id.trim() == ''){
      $('#addKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Category is required !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_cat_id').focus();
      return false;
    }
    var catalogue_mt_id = $('#rss_mpn_id').val();
    if(catalogue_mt_id.trim() == ''){
        $('#addKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Mpn is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_mpn_id').focus();
      return false;
    }
    var rss_feed_cond = $('#rss_condition_id').val();
    if(rss_feed_cond.trim() == ''){
       $('#addKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Condition is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_condition_id').focus();
      return false;
    }
    var rss_listing_type = $('#rss_listing_type').val();
    if(rss_listing_type.trim() == ''){
       $('#addKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Listing Type is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_listing_type').focus();
      return false;
    }
    var excludedWords = $('#excludedWords').val();
      //$(".loader").show();
      //console.log(feedName, keyword, category_id, catalogue_mt_id, rss_feed_cond, rss_listing_type); return false;
        $.ajax({
          url: '<?php echo base_url(); ?>/catalogueToCash/c_purchasing/addRssUrls', 
          type: 'post',
          dataType: 'json',
          data : {
          'feedName':feedName, 
          'keyword':keyword,
          'excludedWords': excludedWords,
          'category_id':category_id,
          'catalogue_mt_id':catalogue_mt_id,
          'rss_feed_cond':rss_feed_cond,
          'rss_listing_type':rss_listing_type
        },
          success: function(data){
            //dataTable.destroy();
             $('#addKeyword').modal('hide');
            if (data == true) {
                $('#errorMessage').html("");
                $('#errorMessage').append('<p style="color:white; background-color:green; padding:10px; border-radius:2px;"><strong>Success: URL Added successfully!</strong></p>');
                $('#errorMessage').show();
                setTimeout(function() {
                $('#errorMessage').fadeOut('slow');
                }, 3000);
            }else if(data == false){
                $('#errorMessage').html("");
                $('#errorMessage').append('<p style="color:red; background-color:#eee; padding:10px; border-radius:2px;"><strong>Error: URL Addition Failed!</strong></p>');
                $('#errorMessage').show();
                setTimeout(function() {
                $('#errorMessage').fadeOut('slow');
                }, 3000);
            }
          }
      });
    //}//else close;

  });
/*===============================================
=            80 chrecter limit check            =
===============================================*/
/*=====  End of save mpn function  ======*/

  $(document).on('click','#updateUrl', function(){
    var feed_url_id = $('#feed_url_id').val();
    var feedName = $('#feedName').val();
   
    if(feedName.trim() == ''){
      $('#addKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Please Insert Feed Name !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#feedName').focus();
      return false;
    }
     //alert(feedName); return false;
    var keyword = $('#keyWord').val();
    if(keyword.trim() == ''){
      $('#addKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Please Insert Keyword !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#keyWord').focus();
      return false;
    }
    var category_id = $('#rss_cat_id').val();
    if(category_id.trim() == ''){
      $('#addKeyword').modal('show');
      $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Category is required !</strong></p>');
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_cat_id').focus();
      return false;
    }
    var catalogue_mt_id = $('#rss_mpn_id').val();
    if(catalogue_mt_id.trim() == ''){
        $('#addKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Mpn is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_mpn_id').focus();
      return false;
    }
    var rss_feed_cond = $('#rss_condition_id').val();
    if(rss_feed_cond.trim() == ''){
       $('#addKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Condition is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_condition_id').focus();
      return false;
    }
    var rss_listing_type = $('#rss_listing_type').val();
    if(rss_listing_type.trim() == ''){
       $('#addKeyword').modal('show');
        $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:orange; background-color:#eee; padding:10px; border-radius:2px;"><strong>Warning: Listing Type is required !</strong></p>');
        $('#errorMessage').show();
        setTimeout(function() {
        $('#errorMessage').fadeOut('slow');
        }, 3000);
      $('#rss_listing_type').focus();
      return false;
    }
    var excludedWords = $('#excludedWords').val();
      //$(".loader").show();
      //console.log(feedName, keyword, category_id, catalogue_mt_id, rss_feed_cond, rss_listing_type); return false;
        $.ajax({
          url: '<?php echo base_url(); ?>/catalogueToCash/c_purchasing/updateRssUrl', 
          type: 'post',
          dataType: 'json',
          data : {
          'feed_url_id':feed_url_id, 
          'feedName':feedName, 
          'keyword':keyword,
          'excludedWords': excludedWords,
          'category_id':category_id,
          'catalogue_mt_id':catalogue_mt_id,
          'rss_feed_cond':rss_feed_cond,
          'rss_listing_type':rss_listing_type
        },
          success: function(data){
            //dataTable.destroy();
             $('#addKeyword').modal('hide');
            if (data == true) {
                    $('#feed_url_id').val('');
                    $('#feedName').val('');
                    $('#keyWord').val('');
                    $('#excludedWords').val('');
                    //$('#updateUrl').hide();


                $('#errorMessage').html("");
                $('#errorMessage').append('<p style="color:white; background-color:green; padding:10px; border-radius:2px;"><strong>Success: URL Updated successfully!</strong></p>');
                $('#errorMessage').show();
                setTimeout(function() {
                $('#errorMessage').fadeOut('slow');
                }, 3000);
            }else if(data == false){
                $('#errorMessage').html("");
                $('#errorMessage').append('<p style="color:red; background-color:#eee; padding:10px; border-radius:2px;"><strong>Error: URL Updation Failed!</strong></p>');
                $('#errorMessage').show();
                setTimeout(function() {
                $('#errorMessage').fadeOut('slow');
                }, 3000);
            }
          }
      });

  });
$(document).on('click', '#clearData', function(){
  $('#feed_url_id').val('');
  $('#feedName').val('');
  $('#keyWord').val('');
  $('#excludedWords').val('');
});
/*===============================================
=            80 chrecter limit check            =
===============================================*/
</script>