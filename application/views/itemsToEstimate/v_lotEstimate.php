<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
<style type="text/css">
  .row-color{
    background-color:rgba(0, 166, 90, 0.67) !important;
  }
  div.imgSec {
    border: 2px solid #ccc !important;
    height: 220px !important;
    padding: 8px 0px 0px !important;
  }  
  #temp-data-table thead th{
    text-align: center;
  }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lot Estimate
      </h1>
      <ol class="breadcrumb">

        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Lot Estimate 
      <?php
          // $filename = '/../../../application/views/itemsToEstimate/v_lotEstimate.php';
          // if (file_exists($filename)) {
          // echo "Last modified: " . date ("F d Y H:i:s.", getlastmod($filename));
          //}
        ?>
          
        </li> </ol>
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
              $cat_id  = @$data['masterInfo'][0]['CATEGORY_ID'];
              $category_name  = @$data['masterInfo'][0]['CATEGORY_NAME'];
              //var_dump($cat_id);exit;
              $lz_bd_cata_id    = $this->uri->segment(4);
              $mpn_id           = $this->uri->segment(5);
              $cat_id           = $this->uri->segment(6);
            ?>  
            <div class="col-md-12">
            <input type="hidden" name="ct_category_id" value="<?php echo $cat_id; ?>" id="ct_category_id">
            <input type="hidden" name="ct_catlogue_mt_id" value="<?php echo $mpn_id; ?>" id="ct_catlogue_mt_id">
            <input type="hidden" name="ct_cata_id" value="<?php echo @$lz_bd_cata_id; ?>" id="ct_cata_id">
            <input type="hidden" name="cat_id" value="<?php echo @$cat_id; ?>" id="cat_id">
            <input type="hidden" name="tracking_id" value="" id="tracking_id">
            <div class="row">
              <div class="col-sm-3">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ebay id">Ebay ID:</label>
                    <input class="form-control" type="text" value="<?php echo @$data['masterInfo'][0]['EBAY_ID']; ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-3">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="ITEM DESCRIPTION">Item Description:</label>
                    <input class="form-control" type="text" value="<?php echo htmlentities(@$data['masterInfo'][0]['TITLE']); ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-3">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="CATEGORY ID">Category ID:</label>
                    <input class="form-control" type="text" name="category_id" id="category_id" value="<?php echo @$cat_id; ?>" readonly>
                    <input class="form-control" type="hidden" name="category_name" id="category_name" value="<?php echo @$category_name; ?>" readonly> 
                </div>
              </div>
               <div class="col-sm-3">
                  <div class="form-group" style="font-size: 15px;">
                    <label for="CONDITION">Condition:</label>
                    <input class="form-control" type="text" value="<?php echo @$data['masterInfo'][0]['CONDITION_NAME']; ?>" readonly> 
                    <?php $condition_name = @$data['masterInfo'][0]['CONDITION_NAME']; ?>
                    <?php $cond_id  = @$data['masterInfo'][0]['CONDITION_ID'];
                    if(empty($cond_id)){
                      if(strtoupper($condition_name) == 'USED - WORKING'){
                        $cond_id = 3000;
                      }elseif(strtoupper($condition_name) == 'RETURNS'){
                        $cond_id = 3000;
                      }elseif(strtoupper($condition_name) == 'NEW'){
                        $cond_id = 1000;
                      }elseif(strtoupper($condition_name) == 'OPEN BOX'){
                        $cond_id = 1500;
                      }elseif(strtoupper($condition_name) == 'SALVAGE'){
                        $cond_id = 7000;
                      }else{
                        $cond_id = 3000;
                      }
                    }

                    ?>
                </div>
              </div>              
            </div>
            <div class="row">
              <div class="col-sm-3">
                <div class="form-group" style="font-size: 15px;">
                  <label for="START TIME">Start Time:</label>
                  <input class="form-control" type="text" value="<?php echo @$data['masterInfo'][0]['START_TIME']; ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group" style="font-size: 15px;">
                  <label for="END TIME">End Time:</label>
                  <input class="form-control" type="text" value="<?php echo @$data['masterInfo'][0]['SALE_TIME']; ?>" readonly> 
                </div>
              </div> 
              <div class="col-sm-2">
                <div class="form-group" style="font-size: 15px;">
                  <label for="END TIME">Given Offer Amount:</label>
                  <input class="form-control" type="text" value="<?php echo @$data['masterInfo'][0]['OFFER_AMOUNT']; ?>" readonly> 
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group p-t-26" style="font-size: 15px;">
                  <label for="ITEM URL">Item URL:</label>
                  <a href="<?php echo @$data['masterInfo'][0]['ITEM_URL']; ?>" target='_blank'><?php echo @$data['masterInfo'][0]['EBAY_ID']; ?></a>
                </div>
              </div>
              <div class="col-sm-2">
                <div class="form-group p-t-26">
                 <input type="hidden" name="lz_cat_id" id="lz_cat_id" value="<?php echo $cat_id; ?>"> <input type="hidden" name="lz_bd_catag_id" id="lz_bd_catag_id" value="<?php echo $lz_bd_cata_id; ?>"> 

                 <button type="button" title="Place Bid/Offer" class="btn btn-primary btn-block btn-sm makeOffer" id="insert_bid_offer"  style="display: none;">Place Bid/Offer</button>
                 <button type="button" title="Place Bid/Offer" class="btn btn-success btn-block btn-sm updateOffer" id="update_bid_offer" style="display: none;">Update Bid/Offer</button>
                </div>
              </div>
            </div>
          </div>
          <?php if($cat_id == 111222333444){ 
            $alphabets  = [1=>'A', 2=>'B', 3=>'C', 4=>'D', 5=>'E', 6=>'F'];
            $columns    = [1=>'MPN', 2=>'MPN DESCRIPTION', 3=>'UPC', 4=>'OBJECT NAME', 5=>'MANUFACTURER', 6=>'QTY',7=>'LOT ID'];
            ?>
            <!-- <div class="col-md-12">
              <?php //foreach ($alphabets as $ke=>$alpha){ ?>
              <div class="col-sm-2">
                <div class="form-group">
                  <span>
                    <label for="CATEGORY ID">Column :</label>
                    <input class="" type="text" id="alphabet_<?php //echo $ke; ?>" name="alphabet_<?php //echo $ke; ?>" size="3" maxlength="3" value="" style="    font-size: 16px; padding-left: 10px;">
                </span>
                   <select name="column_<?php //echo $ke; ?>" id="column_<?php //echo $ke; ?>" class="form-control selectpicker" required="required" data-live-search="true">
                      <option value='0'>Select Column</option>
                      <?php      
                          //foreach ($columns as $key=>$col){
                              ?>
                              <option value="<?php //echo $col; ?>" > <?php //echo $col; ?> </option>
                              <?php
                            // } 
                    ?>                
                    </select>
                </div>
              </div>
              <?php // } ?>
            </div> -->

          <div class="col-sm-12" id="file_upload">
            <form enctype="multipart/form-data" id="frmupload"> 
              <input type="hidden" name="ct_catlogue_mt_id" value="<?php echo $mpn_id; ?>" id="ct_catlogue_mt_id">
              <input type="hidden" name="ct_catalogue_id" value="<?php echo @$lz_bd_cata_id; ?>" id="ct_catalogue_id">
              <input type="hidden" name="cat_id" value="<?php echo @$cat_id; ?>" id="cat_id">
              <div class="col-sm-4">
                <div class="form-group">
                  <label for="">Browse File</label>
                  <input type="file" class="form-control" name="file_name" id="file_name" required>
                </div>  
              </div>
              <div class="col-sm-2 p-t-24">
                <div class="form-group">
                  <button type="button" title="Upload Manifest" name="upload" id="upload_excel_file" class="btn btn-primary ">Upload</button>
                </div>  
              </div>
             </form>
          </div>
         <?php } ?>
          
       
          <div class="col-sm-12">
            <div class="form-group">
              <label for="Lot Remarks">Lot Remarks:</label>
              <textarea class="form-control" name="lot_remarks" id="lot_remarks" cols="6" rows="6"><?php echo @$data['lot_remarks'][0]['LOT_REMARKS']; ?></textarea>
            </div>
            <div class="col-sm-1">
              <div class="form-group pull-left">
                <button type="button" title="Save Remarks"  class="btn btn-success save_remarks" id="save_remarks">Save Remarks</button>
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
              <div>
              <div class='col-sm-12 hide-component'>
<!--                 <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="comp_category" id="comp_category" class="form-control selectpicker" data-live-search="true" required>
                      <option value="0"><!-select-></option>
                      <?php                                
                       //if(!empty($getCategories)){
                        //foreach ($getCategories as $cat){ 
                        ?>
                          <option value="<?php //echo $cat['CATEGORY_ID']; ?>"> <?php //echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?> </option>
                          <?php
                          //} 
                        //}  
                      ?>                       
                    </select>  
                  </div>
                </div> -->
                <?php //var_dump($data['getObjects']);exit; ?>
              <div class='col-sm-3 hide-component'>
                <div class="form-group">
                  <label>Object:</label>
                  <div id="comp_objects">
                    <select name="comp_object" id="comp_object" class="form-control comp_object selectpicker" data-live-search="true" required>
                      <option value="0">---select---</option>
                      <?php                                

                        foreach (@$data['getObjects'] as $object){ 
                        ?>
                          <option value="<?php echo $object['OBJECT_ID']; ?>"><?php echo $object['OBJECT_NAME']; ?></option>
                        <?php
                        } 
                         
                      ?>                     
                    </select>                    
                  </div> 
                </div>
              </div>

              <div class='col-sm-2 hide-component'>
                <label>Brands:</label>
                <div class="form-group" id="brands">   
                </div>
              </div> 
              <div class='col-sm-2 hide-component'>
                <label>MPN:</label>
                <div class="form-group" id="comp_mpns">   
                </div>
              </div> 
              <div class='col-sm-2 hide-component'>
                <div class="form-group" id="comp_upc">   
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
                      <label for="NEW OBJECT">OBJECT NAME:</label>
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
                        <label for="MPN">MPN:</label>
                        <input class="form-control" type="text" name="new_mpn" id="new_mpn" value="" required>
                      </div>
                    </div>                   
                  </div> 
                  <div class="col-sm-12" style="margin-top: 15px;"> 
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="UPC">UPC:</label>
                        <input type="text" class="form-control" name="lot_upc" id="lot_upc" value="">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <span>
                          <label for="MPN">MPN DESCRIPTION : </label>Maximum of 80 characters - 
                          <span id="charNum" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left
                        </span><br/>
                          <input type="text" name="cust_mpn_description" id="cust_mpn_description" class="form-control" onkeyup="countChar(this)"  value="">
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

              <!-- start Input Category to fetch Object list section -->
              <div class="col-sm-12" style="margin-top:15px;border: 2px solid #ccc;padding: 5px 0px;">
                 <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <input type="number" name="cat_id_obj" class="form-control" id="cat_id_obj" value="">

                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group" id="catwiseObj">
                  </div>                  
                </div>
                <div class="col-sm-2">
                  <div class="form-group" id="catObjWiseMPN">

                  </div>                  
                </div>
                <div class="col-sm-2">
                  <div class="form-group" id="catObjWiseUPC">
                  </div>                  
                </div>
                <div class="col-sm-1">
                  <div class="form-group p-t-24" id="catMPNbtn">
                    
                  </div>
                </div>                

              </div>
              <!-- end Input Category to fetch Object list section -->  

              <!-- start pictures show section -->
              <div class="col-sm-12">
                <div id="picSec" class="form-group">
                  <ul id="picsList" style="height: auto !important;">
                  </ul>                
                </div>
              </div>
              <!-- end pictures show section -->
            </div> <!-- end toggle component -->
           </div>
          </div>
         <!-- end of Catalogue Detail section --> 




      <!-- Start of Estimate section -->
        <div class="box"><br>  
          <div class="box-body form-scroll">  
            <div class="col-sm-12" style="margin-top: 20px;">
              <div class="col-sm-1">
              <div class="form-group pull-left">

                <button type="button" title="Save Components"  value="" class="btn btn-success save_components" id="save_components">Save</button>
              </div>
            </div>

            <div class="col-sm-2 ">
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
            <?php if($get_saved_status == 20){?>
            <div class="col-sm-2 hide_component1">
                      <div class="form-group pull-left">
                        <label style="color: red" for="UPC">Discard Remarks:</label>
                        <input type="text" class="form-control" name="remrk" id="remrk" value="<?php echo $data['get_status'][0]['EST_POST_REMARKS_ID']; ?>" readonly>
                      </div>
            </div>
            <?php }?>
            <div class='col-sm-2 hide_component'>
                <label style="color: red" >Select Discard Remarks:</label>
                <div class="form-group" id="dis_remarks">   
                </div>
              </div> 

            </div>
            <div class="col-sm-12" style="margin-left: 30%; margin-top: 20px;">
<!--               <div class="form-group pull-left" style="width: 80px;">
                  <label for="Checked Components">Checked:</label>
                  <input type="text" name="checked_components" value="0" class="form-control totalChecks" readonly> 
              </div> -->
              <div class="form-group pull-left p-t-24">
                <label for="Checked Components" style="font-size: 14px !important; font-weight: bold;">TOTAL:</label>
              </div>
              <div class="form-group pull-left" style="width: 60px; margin-left: 22px;">
                  <label for="Checked Components">QTY:</label>
                  <input type="text" name="total_component_qty"  id="total_component_qty" value="0" class=" form-control total_qty" readonly>
              </div> 
              <div class="form-group pull-left" style="width: 90px; margin-left: 20px;">
                  <label for="Checked Components">Sold Price:</label>
                  <input type="text" name="total_sold_price" id="total_sold_price" value="$0.00" class=" form-control total_sold" readonly>
              </div>  
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Estimate Sale:</label>
                  <input type="text" name="total_estimate_price" id="total_estimate_price" value="$0.00" class=" form-control total_estimate" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 15px;">
                  <label for="Checked Components">Total Amount:</label>
                  <input type="text" name="total_amount" id="total_amount" value="$0.00" class=" form-control amounts" readonly>
              </div>
              <div class="form-group pull-left" style="width: 90px; margin-left: 16px;">
                  <label for="Checked Components">Ebay Fee:</label>
                  <input type="text" name="total_ebay_fee" id="total_ebay_fee" value="$0.00" class=" form-control total_ebay" readonly>
              </div>
              <div class="form-group pull-left" style="width: 90px; margin-left: 16px;">
                  <label for="Checked Components">Paypal:</label>
                  <input type="text" name="total_paypal_fee" id="total_paypal_fee" value="$0.00" class=" form-control total_paypal" readonly>
              </div>
              <div class="form-group pull-left" style="width: 90px; margin-left: 16px;">
                  <label for="Checked Components">Shipping:</label>
                  <input type="text" name="total_ship_fee" id="total_ship_fee" value="$0.00" class=" form-control total_shipping" readonly>
              </div>
              <div class="form-group pull-left" style="width: 85px; margin-left: 6px;">
                  <label for="Checked Components">Net Sale:</label>
                  <input type="text" name="totalClass" id="totalClass" value="$0.00" class="form-control totalClass" readonly>
              </div>
              <div class="form-group pull-left" style="width: 80px; margin-left: 6px;">
                  <label for="Checked Components" style="color: #dd4b39 !important; font-weight: 600 !important;"> -30 %:</label>
                  <input style="" type="number" name="newPerc" id="newPerc" value="30.00" class="form-control newPerc">

              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 6px;">
                  <label for="Checked Components" style="color: #00a65a !important; font-weight: 600 !important;"> Estimate Profit:</label>
                  <input style="color: #00a65a !important; font-weight: 600 !important;" type="text" name="totalClass" id="percentageAmount" value="$0.00" class="form-control percentageAmount" readonly title="Estimate Profit">                
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 6px;">
                  <label for="Checked Components" style="color: #dd4b39 !important; font-weight: 600 !important;"> Offer Amount:</label>
                  <?php //var_dump(@$data['estimate_info'][0]['LOT_OFFER_AMOUNT']);exit; 
                    $offer_amount = @$data['estimate_info'][0]['LOT_OFFER_AMOUNT'];    
                  ?>
                  <input style="color: #dd4b39 !important; font-weight: 600 !important;" type="text" name="offerAmount" id="offerAmount" value="<?php if($offer_amount){ echo '$ '.number_format((float)@$offer_amount,2,'.',''); }else{ echo  '$0.00';}?>" class="form-control offerAmount" readonly title="Offer Amount">                
              </div>

            </div>

            <div class="col-sm-12">
                
              <!-- Custom Tabs -->
              <table  id="kit-components-table" class="table table-responsive table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ACTION</th>
                    <th>PICTURES</th>                    
                    <th>COMPONENTS</th>
                    <th>MPN</th>
                    <th>UPC</th>
                    <th>MPN DESCRIPTION</th>
                    <th>CONDITIONS</th>
                    <th>QTY</th>
                    <th style="color: green;">SOLD PRICE</th>
                    <th>ESTIMATED PRICE</th>
                    <th>AMOUNT</th>
                    <th>EBAY FEE</th>
                    <th>PAYPAL FEE</th>
                    <th>SHIP FEE</th>
                    <th>TOTAL</th>
                  </tr>
                </thead>
                <tbody id="reloa_id">

                <?php
                  // $total_avg_prices = 0;
                  // $totals = 0;
                  // $i=1;
               // var_dump(@$data['estimate_info']);exit;
                ?>
                  <?php
                  $total_avg_prices = 0;
                  $totals = 0;
                  $i=1;
                  // echo "<pre>";
                  // print_r($data['results']->result_array());
                  // echo "</pre>";
                  // exit;
                  if(@$data['estimate_info'] > 0)
                  {
                    //$all_mpn_id = '';
                    foreach (@$data['estimate_info'] as $result):
                      //$part_catlg_mt_id = $result['PART_CATLG_MT_ID'];
                       //$all_mpn_id .= @$result['PART_CATLG_MT_ID'].","; 
                  ?>
                    <tr>
                      <td>
                        <button title="Delete Component" id="<?php echo $result['LZ_ESTIMATE_DET_ID']; ?>" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                        <button style="margin-left: 5px;" title="Add Keyword" rd="<?php echo @$i; ?>" cat="<?php echo @$result['CATEGORY_ID']; ?>" mpn="<?php echo @$result['MPN']; ?>" class="btn btn-info btn-xs glyphicon glyphicon-pencil Keywords"  data-target="#addKeyword" cta_mpn_id="<?php echo @$result['PART_CATLG_MT_ID']; ?>" >
                        </button>
                        <button style="margin-left: 5px;" title="Pull Sold Price" rd="<?php echo @$i; ?>" cat="<?php echo @$result['CATEGORY_ID']; ?>" mpn="<?php echo @$result['MPN']; ?>" condition="<?php echo @$result['TECH_COND_ID']; ?>" id="get_sold_price" class="btn btn-success btn-xs glyphicon glyphicon-magnet get_sold_price"  data-target="#addKeyword">
                        </button>
                      </td>
                      <td>
                      <!-- Pictures section start  -->
                      <?php

                      $it_condition  = @$result['TECH_COND_ID'];
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
                        $mpn = str_replace('/', '_', @$result['MPN']);
                        $master_path = $data['path_query'][0]['MASTER_PATH'];
                        //$upc = "045496891701";
                        
                        $getUpc = $this->db2->query("SELECT I.ITEM_MT_UPC FROM ITEMS_MT@Oraserver I WHERE I.ITEM_MT_MFG_PART_NO = '$mpn'");
                        $getUpc = $getUpc->result_array();
                        $upc = @$getUpc[0]["ITEM_MT_UPC"];

                        $m_dir =  $master_path.@$upc."~".@$mpn."/".@$it_condition."/thumb/";
                        if(is_dir(@$m_dir)){
                            $iterator = new \FilesystemIterator(@$m_dir);
                                if (@$iterator->valid()){    
                                  $m_flag = true;
                              }else{
                                $m_flag = false;
                              }                              
                        }else{
                            $m_flag = false;
                        }

                        if($m_flag){?>
                          <?php
                          if (is_dir($m_dir)){
                            $images = scandir($m_dir);
                            // Image selection and display:
                            //display first image
                            if (count($images) > 0){ // make sure at least one image exists
                                $url = @$images[2]; // first image
                                $img = file_get_contents(@$m_dir.@$url);
                                $img =base64_encode($img); ?>
                                <div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);cursor: pointer!important;">
                                <?php

                                echo '<img class="sort_img up-img zoom_01" id="" name="" src="data:image;base64,'.$img.'"/>';
                                ?>
                                </div>
                                <?php
                            }
                          }
                        ?>
                        <?php
                          //       //echo "<img src='$img' height='150' width='150' /> ";
                          //   }
                          // } 
                        }else{//flag if else
                          echo "NOT FOUND"; 
                        }
                        ?>
  
                      <!-- Pictures section end  -->
                      </td>
                      <td>
                      <?php

                       $url1 = 'https://www.ebay.com/sch/';
                       $cat_name = str_replace(array(" ","&","/"), '-', @$category_name);
                       $cat_id = @$data['masterInfo'][0]['CATEGORY_ID'];
                       $url2 = $cat_name.'/'.$cat_id.'/';
                       //var_dump($url2);exit;
                       //$url3 = 'i.html?LH_BIN=1&_from=R40&_sop=10&LH_ItemCondition='.@$row['CONDITION_ID']; // sop=10 Newly listed
                       $url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='.@$cond_id; // sop=12 Best match
                       if(!empty(@$result['KEYWORD'])){
                         $url4 = '&_nkw='.@$result['KEYWORD'];
                       }else{
                         $url4 = '&_nkw='.@$result['MPN'];
                       }
                      
                       //$url5 = '&LH_Complete=1&LH_Sold=1'; // for sold data
                       $final_url = $url1.$url2.$url3.$url4;
                       //var_dump($final_url);exit;
                        //echo $final_url; 
                        ?>
                        <div  style="" title="Search  MPN on eBay">                         
                          <a style="" href="<?php echo @$final_url; ?>" target= "_blank" ><?php echo @$result['OBJECT_NAME']; ?> </a>
                          <input type="hidden" class="part_catlg_mt_id" name="part_catlg_mt_id" id="part_catlg_mt_id_<?php echo $i; ?>" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                        </div> 

                        
                        <input type="hidden" name="ct_kit_mpn_id_<?php echo $i; ?>" class="kit_componets" id="ct_kit_mpn_id_<?php echo $i; ?>" value="<?php echo @$result['LZ_ESTIMATE_DET_ID']; ?>">
                      </td>
                      <td>
                       <?php echo @$result['MPN']; ?>
                      
                      </td>
                       <td>
                      
                        
                        <?php echo @$result['UPC']; ?> 
                      
                      </td>
 

                      <td>

                      <?php 
                        $mpn_desc_check = htmlentities($result['MPN_DESCRIPTION']);
                        //var_dump($mpn_desc_check);exit; 
                        
                      ?>
                        <div id="textCount" style="width: 300px;" >
                         <!--  <span>
                            Maximum of 80 characters - 
                            <span id="charNumDesc_<?php //echo $i;?>" style="font-size:16px!important;color: red;width: 30px; font-weight: 600;"></span> characters left
                          </span><br/>  -->                         
                          <input style="width: 300px;" type="text" class="form-control mpn_description" name="mpn_description" id="mpn_description_<?php echo $i; ?>" maxlength="80" title="<?php echo $mpn_desc_check; ?>" value="<?php echo $mpn_desc_check; ?>" >
                          <input type="hidden" class="b_part_catlg_mt_id" name="b_part_catlg_mt_id" id="part_catlg_mt_id_<?php echo $i; ?>" value="<?php echo @$result['PART_CATLG_MT_ID']; ?>">
                        </div>
                      </td>


                      <td>
                        <input type="hidden" class="lz_estimate_det_id" name="lz_estimate_det_id" id="lz_estimate_det_id" value="<?php echo $result['LZ_ESTIMATE_DET_ID']; ?>">
                            <div class="form-group" style="width: 130px;">
                                <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_<?php echo $i;?>" ctmt_id="<?php echo $result['PART_CATLG_MT_ID']; ?>" rd = "<?php echo $i; ?>"  style="width: 130px;">
                                  <?php                                 
                                    foreach(@$conditions as $type) { 
                                    // if ($cond_id == $type['ID']){
                                    //       $selected = "selected";
                                    //     }else {
                                    //         $selected = "";
                                    //     }                
                                        ?>
                                         <option value="<?php echo $type['ID']; ?>" <?php if($result['TECH_COND_ID'] == $type['ID']){ echo "selected";} ?> ><?php echo $type['COND_NAME']; ?></option>
                                        <?php
                                         /*$this->session->unset_userdata('ctListing_condition');*/
                                        } 
                                     ?>                     
                                </select> 
                            </div>
                      </td>
<!--                       <td>
                        <div style="width: 70px;">
                           <input type="checkbox" name="cata_component" ckbx_name="<?php //echo @$result['OBJECT_NAME']; ?>" id="component_check_<?php //echo $i; ?>" value="<?php //echo $i; ?>" class="checkboxes validValue countings" style="width: 60px;">
                        </div>
                        
                      </td> -->
                      <td>
                        <?php 
                        $quantity = @$result['QTY']; ?>
                        
                        <div class="form-group" style="width:70px;">
                          <input type="hidden" name="lz_estimate_det_id" value="<?php echo $result['LZ_ESTIMATE_DET_ID']; ?>">
                          <input type="number" name="cata_component_qty_<?php echo $i; ?>" id="cata_component_qty_<?php echo $i; ?>" rowid="<?php echo $i; ?>" class="form-control input-sm component_qty" value="<?php if(!empty($result['QTY'])) {echo $result['QTY']; }else{ echo 1;}?>" style="width:60px;">
                        </div>
                      </td>
                      <td>
                      
                       <?php 

                      
                      // $avg_query = $this->db2->query("SELECT T.AVG_PRICE MPN_AVG FROM MPN_AVG_PRICE T WHERE T.CONDITION_ID=$cond_id AND T.CATALOGUE_MT_ID =$part_catlg_mt_id");


                      //      if($avg_query->num_rows() > 0){
                      //       $mpn_avg_price = $avg_query->result_array();
                      //       $mpn_avg_price = $mpn_avg_price[0]['MPN_AVG'];
                      //     }
                      //       else{

                      //         $mpn_avg_price = '0';
                      //         } 
                              ?>
                        <?php 
                        // $avg_price = @$result['AVG_PRIC'];
                        // if ($avg_price == 0.00 || $avg_price == 0 || $avg_price == 0. || $avg_price == 0.0 ) {
                        //   $avg_price = 1;
                        // }
                        // $total_avg_prices += $avg_price;
                         ?>
                        <div class="form-group">
                          <input type="text" name="cata_avg_price_<?php echo $i; ?>" id="cata_avg_price_<?php echo $i; ?>" class="form-control input-sm cata_avg_price" value="<?php if(!empty($result['QTY'])) {echo '$ '.number_format((float)@$result['SOLD_PRICE'],2,'.',''); }else{ echo "$ 0.00"; } //else{ echo '$ '.number_format((float)@$mpn_avg_price,2,'.',',');} ?>" style="width:80px;" readonly>
                        </div>
                      </td> 
                    <td>
                      <?php 
                      //var_dump($result['EST_SELL_PRICE']);//exit;
                      //$est_price_name="cata_est_price_".$i; 
                      ?>
                      <div class="form-group" style="width:80px;">
                        <input type="number" name="<?php echo @$result['PART_CATLG_MT_ID']; ?>" id="cata_est_price_<?php echo $i; ?>" class="form-control input-sm cata_est_price <?php echo @$result['PART_CATLG_MT_ID']; ?>" value="<?php if(isset($result['EST_SELL_PRICE'])){ echo number_format((float)@$result['EST_SELL_PRICE'],2,'.',''); }else{ echo "0.00"; } ?>" style="width:80px;">
                      </div>
                    </td>
                    <td>
                      <?php
                        $estPrice =  @$result['EST_SELL_PRICE'];
                        $Quantity = @$result['QTY'];
                        $shipping = @$result['SHIPPING_FEE'];
                        $Amounts = $estPrice * $Quantity;

                      ?>
                       <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_amount_<?php echo $i; ?>" id="cata_amount_<?php echo $i; ?>" class="form-control input-sm cata_amount" value="<?php echo '$ '.number_format((float)@$Amounts,2,'.','');?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php
                      // if (!empty($avg_price)) {
                      //       $ebay_fee= ($avg_price  * (8 / 100));
                      //     }else {
                      //       $ebay_fee= ($estimate_price  * (8 / 100));
                      //     }

                        ?>
                      <div class="form-group" style="width:80px;">
                       <input type="text" name="cata_ebay_fee_<?php echo $i; ?>" id="cata_ebay_fee_<?php echo $i; ?>" class="form-control input-sm cata_ebay_fee" value="<?php if(isset($result['EBAY_FEE'])){ echo '$ '.number_format(@$result['EBAY_FEE'],2,'.',''); }else {echo '$ '.number_format((float)@$ebay_fee,2,'.','');} ?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <?php 
                      // $paypal_fee= ($avg_price  * (2.5 / 100));
                      //   if (!empty($avg_price)) {
                      //     $paypal_fee= ($avg_price  * (2.5 / 100));
                      //     }else {
                      //       $paypal_fee= ($estimate_price  * (2.5 / 100));
                      //     }
                       ?>
                      <div class="form-group" style="width:80px;">
                        <input type="text" name="cata_paypal_fee_<?php echo $i; ?>" id="cata_paypal_fee_<?php echo $i; ?>" class="form-control input-sm cata_paypal_fee" value="<?php if(isset($result['PAYPAL_FEE'])){ echo '$ '.number_format((float)@$result['PAYPAL_FEE'],2,'.',''); }else {echo '$ '.number_format((float)@$paypal_fee,2,'.',''); }?>" style="width:80px;" readonly>
                      </div>
                    </td>
                    <td>
                      <div class="form-group">
                        <input type="text" name="cata_ship_fee_<?php echo $i; ?>" id="cata_ship_fee_<?php echo $i; ?>" attr_mpn="<?php echo @$result['PART_CATLG_MT_ID'].'_ship'; ?>" class="form-control input-sm cata_ship_fee <?php echo @$result['PART_CATLG_MT_ID'].'_ship'; ?>" value="<?php if(isset($shipping)){ echo '$ '.number_format((float)@$shipping,2,'.',''); }else {echo '$ 3.25'; }?>" style="width:80px;">
                      </div>
                    </td>
                    <td class="rowDataSd">
                    <?php 
                      $row_total = 0;
                      // $row_total  = $result['EBAY_FEE'] + $result['PAYPAL_FEE'] + $shipping + $Amounts;
                      $row_total  = $Amounts - $result['EBAY_FEE'] - $result['PAYPAL_FEE'] - $shipping;

                      // $total    = $avg_price + $cahrges;
                      // $row_total += $total;
                      ?>
                      <p id="cata_total_<?php echo $i; ?>" class="totalRow"><?php  echo '$ '.number_format((float)@$row_total,2,'.',''); ?></p>
                    </td>
                    <?php
                      $i++;
                      // echo "</tr>"; 
                      endforeach; 
                    ?>
                  
                  </tbody> 
                  <tfoot>
                  <tr>
                    <th>ACTION</th>
                    <th>PICTURES</th>                    
                    <th>COMPONENTS</th>
                    <th>MPN</th>
                    <th>UPC</th>
                    <th>MPN DESCRIPTION</th>
                    <th>CONDITIONS</th>
                    <th>QTY</th>
                    <th>SOLD PRICE</th>
                    <th>ESTIMATED PRICE</th>
                    <th>AMOUNT</th>
                    <th>EBAY FEE</th>
                    <th>PAYPAL FEE</th>
                    <th>SHIP FEE</th>
                    <th>TOTAL</th>
                  </tr>
                </tfoot>
                  </table>
                  <?php
                  }else { //end main if
                  ?>
                </tbody> 
                <tfoot>
                <tr>
                    <th>ACTION</th>
                    <th>PICTURES</th>                    
                    <th>COMPONENTS</th>
                    <th>MPN</th>
                    <th>UPC</th>
                    <th>MPN DESCRIPTION</th>
                    <th>CONDITIONS</th>
                    <th>QTY</th>
                    <th>SOLD PRICE</th>
                    <th>ESTIMATED PRICE</th>
                    <th>AMOUNT</th>
                    <th>EBAY FEE</th>
                    <th>PAYPAL FEE</th>
                    <th>SHIP FEE</th>
                    <th>TOTAL</th>
                  </tr>
                </tfoot>
              </table>              
              <?php
              } ?>
            <!-- nav-tabs-custom -->
            </div>
            <!-- /.col-sm-12--> 
            <div class="col-sm-12" style="margin-left: 30%; margin-top: 20px;">
          <!--   <div class="form-group pull-left" style="width: 80px;">
                  <label for="Checked Components">Checked:</label>
                  <input type="text" name="checked_components" value="0" class="form-control totalChecks" readonly> 
                </div> -->

         <!--        <input type="hidden" name="all_mpn_id" id="all_mpn_id" value="<?php //echo $all_mpn_id; ?>" class=" form-control "> -->
                
              <div class="form-group pull-left p-t-24">
                <label for="Checked Components" style="font-size: 14px !important; font-weight: bold;">TOTAL:</label>
              </div>
              <div class="form-group pull-left" style="width: 60px; margin-left: 22px;">
                  <label for="Checked Components">QTY:</label>
                  <input type="text" name="total_component_qty"  id="total_component_qty" value="0" class=" form-control total_qty" readonly>
              </div> 
              <div class="form-group pull-left" style="width: 90px; margin-left: 20px;">
                  <label for="Checked Components">Sold Price:</label>
                  <input type="text" name="total_sold_price" id="total_sold_price" value="$0.00" class=" form-control total_sold" readonly>
              </div>  
              <div class="form-group pull-left" style="width: 100px; margin-left: 20px;">
                  <label for="Checked Components">Estimate Sale:</label>
                  <input type="text" name="total_estimate_price" id="total_estimate_price" value="$0.00" class=" form-control total_estimate" readonly>
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 15px;">
                  <label for="Checked Components">Total Amount:</label>
                  <input type="text" name="total_amount" id="total_amount" value="$0.00" class=" form-control amounts" readonly>
              </div>
              <div class="form-group pull-left" style="width: 90px; margin-left: 16px;">
                  <label for="Checked Components">Ebay Fee:</label>
                  <input type="text" name="total_ebay_fee" id="total_ebay_fee" value="$0.00" class=" form-control total_ebay" readonly>
              </div>
              <div class="form-group pull-left" style="width: 90px; margin-left: 16px;">
                  <label for="Checked Components">Paypal:</label>
                  <input type="text" name="total_paypal_fee" id="total_paypal_fee" value="$0.00" class=" form-control total_paypal" readonly>
              </div>
              <div class="form-group pull-left" style="width: 90px; margin-left: 16px;">
                  <label for="Checked Components">Shipping:</label>
                  <input type="text" name="total_ship_fee" id="total_ship_fee" value="$0.00" class=" form-control total_shipping" readonly>
              </div>
              <div class="form-group pull-left" style="width: 85px; margin-left: 6px;">
                  <label for="Checked Components">Net Sale:</label>
                  <input type="text" name="totalClass" id="totalClass" value="$0.00" class="form-control totalClass" readonly>
              </div>
              <div class="form-group pull-left" style="width: 80px; margin-left: 6px;">
                  <label for="Checked Components" style="color: #dd4b39 !important; font-weight: 600 !important;"> -30 %:</label>
                  <input style="" type="number" name="newPerc" id="newPerc" value="30.00" class="form-control newPerc">

              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 6px;">
                  <label for="Checked Components" style="color: #00a65a !important; font-weight: 600 !important;"> Estimate Profit:</label>
                  <input style="color: #00a65a !important; font-weight: 600 !important;" type="text" name="totalClass" id="percentageAmount" value="$0.00" class="form-control percentageAmount" readonly title="Estimate Profit">                
              </div>
              <div class="form-group pull-left" style="width: 100px; margin-left: 6px;">
                  <label for="Checked Components" style="color: #dd4b39 !important; font-weight: 600 !important;"> Offer Amount:</label>
                  <input style="color: #dd4b39 !important; font-weight: 600 !important;" type="text" name="offerAmount" id="offerAmount" value="<?php if($offer_amount){ echo '$ '.number_format((float)@$offer_amount,2,'.',''); }else{ echo  '$0.00';}?>" class="form-control offerAmount" readonly title="Offer Amount">                
              </div>

            </div>

            <div class="col-sm-12" style="margin-top: 15px;">
               <!-- <input type="hidden" name="countrows" value="<?php //echo $i-1; ?>" id="countrows"> -->
              <div class="col-sm-1">
                <div class="form-group pull-left">
                  <button type="button" title="Save Components"  class="btn btn-success col-sm-offset-1 save_components" id="save_components">Save</button>
                </div>
              </div>
            </div>
          </div>
        </div> <!-- /.box-body -->
        <!-- /.box -->
           <!-- Start of Estimate section -->
           <?php
           if(count(@$shows) > 0){ 
            ?>
        <div class="box"><br>  
          <div class="box-body form-scroll">  
            <div class="col-sm-12" style="margin-top: 20px;">
              <div class="col-sm-1">
              <div class="form-group pull-left">
                <button type="button" title="Move Components"  value="" class="btn btn-success move_components" id="move_components">Move Data</button>
              </div>
            </div>
            </div>
            <div class="col-sm-12">   
              <!-- Custom Tabs -->
               <?php
                $alphabets    = [1=>'A', 2=>'B', 3=>'C', 4=>'D', 5=>'E', 6=>'F',7=>'G', 8=>'H', 9=>'I', 10=>'J', 11=>'K', 12=>'L',13=>'M', 14=>'N', 15=>'O', 16=>'P', 17=>'Q', 18=>'R',19=>'S', 20=>'T', 21=>'U', 22=>'V', 23=>'W', 24=>'X', 25=>'Y', 26=>'Z' ];
                $columns    = [1=>'MPN', 2=>'MPN DESCRIPTION', 3=>'UPC', 4=>'OBJECT NAME', 5=>'MANUFACTURER', 6=>'QTY',7=>'LOT ID',8=>'SKU'];
              ?>
              <table  id="temp-data-table" class="table table-responsive table-striped table-bordered table-hover">
                <thead> 
                <?php //} ?>
                    <th></th>
                    <th>A</th>
                    <th>B</th>                    
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                    <th>F</th>
                    <th>G</th>
                    <th>H</th>
                    <th>I</th>
                    <th>J</th>
                    <th>K</th>
                    <th>L</th>
                    <th>M</th>
                    <th>N</th>
                    <th>O</th>
                    <th>P</th>
                    <th>Q</th>
                    <th>R</th>
                    <th>S</th>
                    <th>T</th>
                    <th>U</th>
                    <th>V</th>
                    <th>W</th>
                    <th>X</th>
                    <th>Y</th>
                    <th>Z</th>
                </thead>
                <tbody id="reloa_id">
                  <tr>
                    <td><p class="col-sm-2">Category ID</p></td>
                    <td>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column a">A</label>  -->
                           <select name="column_a" id="column_1" albt="A" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                foreach ($columns as $key=>$col){
                              ?>
                              <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                              <?php
                              } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column b">B</label> -->
                           <select name="column_b" id="column_2" albt="B" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                foreach ($columns as $key=>$col)
                                {
                                ?>
                                <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                <?php
                              } 
                            ?>                
                          </select>
                        </div>
                      </div>
                    </td>                    
                    <td>  
                      
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column c">C</label> -->
                           <select name="column_c" id="column_3" albt="C" class="form-control columns" required="required" data-live-search="true"> <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                    
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column d">D</label> -->
                           <select name="column_d" id="column_4" albt="D" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column e">E</label> -->
                           <select name="column_e" id="column_5" albt="E" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column f">F</label> -->
                           <select name="column_f" id="column_6" albt="F" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                     
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column g">G</label> -->
                           <select name="column_g" id="column_7" albt="G" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                     
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column h">H</label> -->
                           <select name="column_h" id="column_8" albt="H" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                    
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column i">I</label> -->
                           <select name="column_i" id="column_9" albt="I" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column j">J</label> -->
                           <select name="column_j" id="column_10" albt="J" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column k">K</label> -->
                           <select name="column_K" id="column_11" albt="K" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column l">L</label> -->
                           <select name="column_l" id="column_12" albt="L" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column m">M</label> -->
                           <select name="column_m" id="column_13" albt="M" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column n">N</label> -->
                           <select name="column_n" id="column_14" albt="N" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column o">O</label> -->
                           <select name="column_o" id="column_15" albt="O" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column p">P</label> -->
                           <select name="column_p" id="column_16" albt="P" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column q">Q</label> -->
                           <select name="column_q" id="column_17" albt="Q" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column r">R</label> -->
                           <select name="column_r" id="column_18" albt="R" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column s">S</label> -->
                           <select name="column_s" id="column_19" albt="S" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                foreach ($columns as $key=>$col)
                                {
                                  ?>
                                  <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                  <?php
                                } 
                              ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column t">T</label> -->
                           <select name="column_t" id="column_20" albt="T" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col)
                                  {
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column u">U</label> -->
                           <select name="column_u" id="column_21" albt="U" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column v">V</label> -->
                           <select name="column_v" id="column_22" albt="V" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column w">W</label> -->
                           <select name="column_w" id="column_23" albt="W" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column x">X</label> -->
                           <select name="column_x" id="column_24" albt="X" class="form-control columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column y">Y</label> -->
                           <select name="column_y" id="column_25" albt="Y" class="form-control selectpicker columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>
                    <td>  
                      <div class="col-sm-2">
                        <div class="form-group">
                          <!-- <label for="column z">Z</label> -->
                           <select name="column_z" id="column_26" albt="Z" class="form-control selectpicker columns" required="required" data-live-search="true">
                              <option value='0'>Select Column</option>
                              <?php      
                                  foreach ($columns as $key=>$col){
                                      ?>
                                      <option value="<?php echo $col; ?>" > <?php echo $col; ?> </option>
                                      <?php
                                     } 
                            ?>                
                            </select>
                        </div>
                      </div>
                    </td>

                  </tr>
                  <?php
                  // echo "<pre>";
                  // print_r($shows); exit;
                  $i=1;
               
                  if(count(@$shows) > 0)
                  {
                    foreach (@$shows as $result):
                  ?>
                    <tr>
                      <td>
                      <div class="col-sm-2">
                        <div class="form-group">
                           <input type="text" name="user_defined_cat" class="form-control user_defined_cat" id="user_defined_cat" cpk="<?php echo $result['LZ_COL_MAP_PK']; ?>">
                        </div>
                      </div>
                    </td>
                      <td>
                        <?php echo $result['A']; ?>
                      </td>

                      <td>
                        <?php echo $result['B']; ?>
                      </td>

                      <td>
                        <?php echo $result['C']; ?>
                      </td>

                      <td> 
                        <?php echo $result['D']; ?>
                      </td>

                      <td>
                        <?php echo $result['E']; ?>
                      </td>

                      <td>
                        <?php echo $result['F']; ?>
                      </td>

                      <td>
                        <?php echo $result['G']; ?>
                      </td>

                      <td>
                        <?php echo $result['H']; ?>
                      </td>

                      <td>
                        <?php echo $result['I']; ?>
                      </td>

                      <td>
                        <?php echo $result['J']; ?>
                      </td>

                      <td>
                        <?php echo $result['K']; ?>
                      </td>

                      <td>
                        <?php echo $result['L']; ?>
                      </td>

                      <td>
                        <?php echo $result['M']; ?>
                      </td>

                      <td>
                        <?php echo $result['N']; ?>
                      </td>

                      <td>
                        <?php echo $result['O']; ?>
                      </td>
                      <td>
                        <?php echo $result['P']; ?>
                      </td>
                      <td>
                        <?php echo $result['Q']; ?>
                      </td>
                      <td>
                        <?php echo $result['R']; ?>
                      </td>
                      <td>
                        <?php echo $result['S']; ?>
                      </td>
                      <td>
                        <?php echo $result['T']; ?>
                      </td>
                      <td>
                        <?php echo $result['U']; ?>
                      </td>
                      <td>
                        <?php echo $result['V']; ?>
                      </td>
                      <td>
                        <?php echo $result['W']; ?>
                      </td>
                      <td>
                        <?php echo $result['X']; ?>
                      </td>
                      <td>
                        <?php echo $result['Y']; ?>
                      </td>
                      <td>
                        <?php echo $result['Z']; ?>
                      </td>


                    <?php
                      $i++;
                      endforeach; 
                    ?>
                  </tbody> 
                  </table>
                  <?php
                  }else {
                  //end main if
                  ?>
              </tbody> 
              </table>              
              <?php
              } 
             ?>
            <!-- nav-tabs-custom -->
            </div>
            <!-- /.col-sm-12--> 
            <div class="col-sm-12" style="margin-top: 15px;">
               <!-- <input type="hidden" name="countrows" value="<?php //echo $i-1; ?>" id="countrows"> -->
              <div class="col-sm-1">
                <div class="form-group pull-left">
                  <button type="button" title="Move Components"  class="btn btn-success col-sm-offset-1 move_components" id="move_components">Move Data</button>
                </div>
              </div>
              
            </div>

          </div>
          <!-- /.box-body -->
        </div>
          
        <!-- /.box -->
        <?php
      }
      ?>
        
        <!-- Picture Upload Section Start -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Upload Pictures</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>           
          <div class="box-body">
            <!-- For Image upload Info sec start -->
            <div class="col-sm-12">
              <div class="col-sm-3">
                <div class="form-group">
                  <label>MPN:</label>
                  <input type="text" class="form-control" name="pic_mpn" id="pic_mpn" value="" required>
                </div>
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label>UPC:</label>
                  <input type="text" class="form-control" name="pic_upc" id="pic_upc" value="">
                </div>                
              </div>
              <div class="col-sm-3">
                <div class="form-group">
                  <label for="Condition">Condition:</label>
                  <select name="pic_condition" id="pic_condition" class="form-control">
                    <?php                                 
                      foreach(@$conditions as $cond) { ?>
                        <option value="<?php echo $cond['ID']; ?>" ><?php echo $cond['COND_NAME']; ?></option>
                    <?php
                      } 
                    ?>   
                  </select>
                </div>
              </div>
            </div>
            <!-- For Image upload Info sec end -->
            <!-- Image Upload form section start -->
            <div class="col-sm-12">
              <div id="drop-img-area" class="col-sm-12 p-b">
                <label for="">Upload Pictures:</label>
                <div id="" class="col-sm-12 b-full">
                  <div class="col-sm-2">                   
                    <div  class="commoncss">
                      <h4>Drag / Upload image!</h4>
                      <div class="uploadimg">
                       <form id="picFormUpload" enctype="multipart/form-data">
                          <input type="file" multiple="multiple" name="upload_image[]" id="upload_image" style="display:none"/>
                          <span id="btnupload_img" style=" font-size: 2.5em; margin-top: 0.7em; cursor: pointer;" class="fa fa-cloud-upload"></span>

                          </form>
                      </div>
                    </div>
                  </div>
                
                  <div id="" class="col-sm-10 p-t"> 
                    <ul id="sortable" style="height: 140px !important;">
                         
                        
                    </ul>
                    <div id="" class="col-sm-10 p-t"> 

                    </div>
                      <div class="col-sm-12 " style="padding-left:0px !important;padding-right:0px !important;">

                        <div class="col-sm-8" id="">
                          <div id="upload_message">
                      
                          </div>
                          <div class="alert success pull-right" style="font-size:16px;color:green;font-weight:600;"></div>
                        </div>
                         
                          <div class="col-sm-4">
                            <div class="form-group pull-right">
<!--                               <input id="master_reorder_dekit" class="btn btn-sm btn-primary" title="Sort or Re-arrange Picture Order" type="button" name="update_order" value="Update Order">
                              <span><i id="<?php //if(@$del_master_all){echo $del_master_all;}?>" title="Delete All Pictures" class="btn btn-sm btn-danger del_master_all_dekit">Delete All</i></span> -->
                          </div>
                        </div>
                      </div>
                  </div>              
                </div>
              </div>
            </div>  
          <!-- Image Upload form section end -->
          </div> <!-- box-body end-->
        </div>  <!-- box end-->     
    <!-- Picture Upload Section End -->

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
        </div> 
        <!-- ////////////////////////////////// -->
         <!-- second block  Catalogue Detail start --> 
          <!-- COMPONENCT SERACH START --> 
          <div class="box" id="upc_search_aria">
            <div class="box-header with-border">
              <h3 class="box-title">Search Keyword | Posted Data</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>          
            <div class="box-body"> 
            <div class="col-sm-12">
              <div class="col-sm-3">
                <label for="search UPC">Search Object:</label>
                  <div class="form-group">
                    <input type="text" class="form-control" name="input_brand" id="input_brand" placeholder="Enter Object" >
                   
                  </div>
              </div>
              <div class="col-sm-3">
                <label for="search UPC">Search Keyword:</label>
                  <div class="form-group">
                   
                    <input type="text" class="form-control" name="input_upc" id="input_upc" placeholder="Enter Keyword" >
                  </div>
              </div>
                
              <div class="col-sm-1 p-t-24">
                <div class="form-group ">
                  <input type="button" class="btn btn-primary btn-sm" id="search_upc" value="Search">
                </div>
              </div>
            </div>
            <!-- start of catalogue detail part -->
            <div class="col-md-12">
              <form>
              <table id="search_component_upc" class="table table-responsive table-striped table-bordered table-hover">
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
        </div>
        <!-- ////////////////////////////////// -->
      </div> 
          <!-- /.row -->
          <!-- end second block start --> 
          <!-- COMPONENCT SERACH END --> 
    </section>
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 100px; height: 100px;">
    </div>

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
    <!-- /.content -->
  </div>  
  <!-- Modal -->
<div id="makeOffer" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Place Bid/Offer</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Estimate Offer">Estimate Offer</label>
                          <input type="text" name="estimate_offer" id="estimate_offer" class="form-control" value="" readonly>
                        </div>
                      </div>
                    </div>                    
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Offer Amount">Offer Amount:</label>
                          <input type="number" class="form-control" name="offer_amount" id="offer_amount" value="">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="Remarks">Remarks:</label>
                          <input type="text" class="form-control" name="remarks" id="remarks" value="">
                        </div>
                      </div>                      
                      <div class="col-sm-1">
                        <div class="form-group p-t-24">
                          <input type="hidden" name="lz_cat_id" id="lz_cat_id" value=""> 
                          <input type="hidden" name="lz_bd_catag_id" id="lz_bd_catag_id" value="">                          
                          <input type="button" class="btn btn-sm btn-success save_offer" name="save_offer" id="save_offer" value="Save">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group text-center emptyDiv">
                          <div id="printMessage">
                          </div>
                        </div>                        
                      </div>                      
                    </div>
                    <div class="col-sm-12" id="after_bidoffer">
                      <div class="col-sm-2">
                        <input type="hidden" name="offer_id_save" id="offer_id_save" value="">
                        <div class="form-group" id="statusDropdownSave">
                           
                        <!--   <label for="Bid/Offer Status">Bid/Offer Status</label>
                          <select name="bid_status" id="bid_status" class="form-control bid_status">
                            <option value="default">-SELECT-</option>
                            <option value="1">WON</option>
                            <option value="0">LOST</option>
                          </select> -->
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group" id="trackingNumberSave">
                          
                        </div>
                        
                      </div>                       

                      <div class="col-sm-2">
                        <div class="form-group" id="saleAmountSave">

                        </div>
                      </div>
                     
                      <div class="col-sm-2">
                        <div class="form-group p-t-26" id="saveStatusSave">

                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group" id="bidingStatusMessageSave">
                          
                        </div>
                      </div>

                    </div>                    
                  </div>
                </section>
            </div>
            <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end --> 
  <!-- Update Bid/Offer section start -->
<!-- Modal -->
<div id="updateOffer" class="modal modal-info fade" role="dialog" style="width: 100%;">
    <div class="modal-dialog" style="width: 70%;">
        <!-- Modal content-->
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Bid/Offer</h4>
            </div>
            <div class="modal-body">
                <section class="content"> 
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Estimate Offer">Estimate Offer</label>
                          <input type="text" name="update_estimate_offer" id="update_estimate_offer" class="form-control" value="" readonly>
                        </div>
                      </div>
                    </div>                    
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="Offer Amount">Offer Amount:</label>
                          <input type="hidden" name="update_offer_id" id="update_offer_id" value="">
                          <input type="hidden" name="update_lz_cat_id" id="update_lz_cat_id" value=""> 
                          <input type="hidden" name="update_lz_bd_catag_id" id="update_lz_bd_catag_id" value="">                           
                          <input type="number" class="form-control" name="update_offer_amount" id="update_offer_amount" value="">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="Remarks">Remarks:</label>
                          <input type="text" class="form-control" name="update_remarks" id="update_remarks" value="">
                        </div>
                      </div>                      
                      <div class="col-sm-1">
                        <div class="form-group p-t-24">
                          <input type="hidden" name="offer_id" id="offer_id" value="">                          
                          <input type="button" class="btn btn-sm btn-success update_offer" name="update_offer" id="update_offer" value="Update">
                        </div>
                      </div>
                      <div class="col-sm-3">
                        <div class="form-group text-center emptyDiv">
                          <div id="updatePrintMessage">
                          </div>
                        </div>                        
                      </div>                      
                    </div>
                    <div class="col-sm-12">
                      <div class="col-sm-2">
                        <div class="form-group" id="statusDropdown">
                          <label for="Bid/Offer Status">Bid/Offer Status</label>
                          <select name="bid_status" id="bid_status" class="form-control bid_status">
                            <option value="default">----SELECT----</option>
                            <option value="1">WON</option>
                            <option value="0">LOST</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-sm-2">
                        <div class="form-group" id="trackingNumber">
                          
                        </div>
                        
                      </div>                       

                      <div class="col-sm-2">
                        <div class="form-group" id="saleAmount">

                        </div>
                      </div>
                     
                      <div class="col-sm-2">
                        <div class="form-group p-t-26" id="saveStatus">

                        </div>
                      </div>

                      <div class="col-sm-3">
                        <div class="form-group" id="bidingStatusMessage">
                          
                        </div>
                      </div>

                    </div>
                  </div>
                </section>
            </div>
            <div class="modal-footer">
              <button type="button" id="closeModal" class="btn btn-outline pull-right" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- detail modal end --> 
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
<script>

  $('.zoom_01').elevateZoom({
    //zoomType: "inner",
    cursor: "crosshair",
    zoomWindowFadeIn: 600,
    zoomWindowFadeOut: 600,
    easing : true,
    scrollZoom : true
   });

$(document).ready(function(){

    $('.hide_component').hide();
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


     $('#kit-components-table').DataTable( { 
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
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',

        initComplete: function () {

            this.api().columns(3).every( function () {
                var column = this;
                //console.log(column);
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
          this.api().columns(4).every( function () {
              var column = this;
              //console.log(column);
              var select = $('<select><option value=""></option></select>')
                  .appendTo( $(column.footer()).empty() )
                  .on( 'change', function () {
                      var val = $.fn.dataTable.util.escapeRegex(
                          $(this).val()
                      );

                      column
                          .search( val ? '^'+val+'$' : '', true, false )
                          .draw();
                  } );

              column.data().unique().sort().each( function ( d, j ) {
                  select.append( '<option value="'+d+'">'+d+'</option>' )
              } );
          } );
        }
    } );
    ///////////////////////////
    //var table = 
    // $('#kit-components-table').DataTable({
    //   "oLanguage": {
    //   "sInfo": "Total Records: _TOTAL_"
    // },
    // "iDisplayLength": 500,
    //     "aLengthMenu": [[25, 50, 100, 200,500, -1], [25, 50, 100, 200,500, "All"]],
    //   "paging": true,
    //   "lengthChange": true,
    //   "searching": true,
    //   "ordering": false,
    //   // "order": [[ 16, "ASC" ]],
    //   "info": true,
    //   "autoWidth": true,
    //   "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    // });


   // $(document).ready(function() {
    // $('#kit-components-table').DataTable( {
       
    // } );
// } );



    var table = $('#temp-data-table').DataTable({
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

    // $('.myInput').on( 'click', function () {
    //     table.search( this.value ).draw();
    // } );
    // $('#showAll').on( 'click', function () {
    //     table.search( this.value ).draw();
    // } );    
    
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

/*==========================================
=            Onload calculation            =
==========================================*/
 //$(document).on('load','.countings',function(){
  $(window).load(function(){
      var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;
        $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#cata_est_price_"+id).val() != 0.00 ){
            // alert(id);return false;
            currQty = $("#cata_component_qty_"+id).val();
            sumQty += parseInt(currQty);
          }

        });
        var test = sumQty.toFixed(2);

        //console.log(test);

        $(".total_qty").val(sumQty);   
 


        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 
        $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);

          
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
            currAmount = $("#cata_amount_"+id).val();
             currAmount = currAmount.substring(1, currAmount.length);
            sumAmount += parseFloat(currAmount);
            //console.log(sumAmount);
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
            currLineTotal = $("#cata_total_"+id).text();
            currLineTotal = currLineTotal.substring(1, currLineTotal.length);
            sumLineTotal += parseFloat(currLineTotal);
          }
        });

        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);
        // var les_perc = sumLineTotal;
        // les_perc = (parseFloat(les_perc)/100) * 30;
        // var final_price = parseFloat(sumLineTotal) - parseFloat(les_perc);
        // $(".percentageAmount").val('$ '+final_price.toFixed(2));

      /*========Offer Amount start ======*/
      var net_sale = $("#totalClass").val();
      net_sale = net_sale.substring(1, net_sale.length);
      var offer_amount = $("#offerAmount").val();
      offer_amount = offer_amount.substring(1, offer_amount.length);

      var est_prof = parseFloat(net_sale) - parseFloat(offer_amount);
      //console.log(est_prof.toFixed(2));
      $(".percentageAmount").val(est_prof.toFixed(2));

      var percent_amount = $("#percentageAmount").val();
      var total_amount = $("#total_amount").val();
      total_amount = total_amount.substring(1, total_amount.length);

      var perc_val = parseFloat(percent_amount)/parseFloat(total_amount) * 100;
      //console.log(Math.round(perc_val));
      $(".newPerc").val(Math.round(perc_val).toFixed(2));      
      //console.log(percent_amount, total_amount);      


      // var percent_amount = $("#percentageAmount").val();
       percent_amount = percent_amount.substring(1, percent_amount.length);      

      var offer_amount = parseFloat(net_sale) - parseFloat(percent_amount);
      //$(".offerAmount").val('$ '+offer_amount.toFixed(2));
      //console.log(offer_amount);

      /*========Offer Amount end ======*/  

      /*========Estimate Profit start ======*/
      // var newPerc = parseFloat($("#newPerc").val());
      // if(isNaN(newPerc)){
      //   newPerc = 0.00;
      // }
      // var total_amount = $("#total_amount").val();
      // total_amount = total_amount.substring(1, total_amount.length);
      // total_amount = parseFloat(total_amount);
      // var perc_amnt = total_amount;
      // perc_amnt = (parseFloat(perc_amnt)/100) * parseFloat(newPerc);
      // esitmate_profit = perc_amnt.toFixed(2);
      // $(".percentageAmount").val('$ '+esitmate_profit); 
      /*========Estimate Profit end ======*/      

     });
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
            $('#addKeyword').modal('hide');
            //dataTable.destroy();
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
      //console.log(excludedWords, feedName, keyword, category_id, catalogue_mt_id, rss_feed_cond, rss_listing_type); return false;
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
                $('#excludedWords').val('');
                //$('#rss_listing_type').val('');
                //$('#rss_condition_id').val(''); 
                //$('#rss_mpn_id').val(''); 
                $('#rss_cat_id').val(''); 
                $('#keyWord').val(''); 
                $('#feedName').val('');


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

/*=====  End of Onload calculation  ======*/
$(document).on('click','#clearData',function(){ 
  $('#excludedWords').val('');
  //$('#rss_listing_type').val('');
  //$('#rss_condition_id').val(''); 
  //$('#rss_mpn_id').val(''); 
  $('#rss_cat_id').val(''); 
  $('#keyWord').val(''); 
  $('#feedName').val('');
});
$(document).on('click','.Keywords',function(){
  $(this).removeClass('btn-info').addClass('btn-success');
  var rss_condition = "";
  var row_id            = $(this).attr("rd");
  var rss_cat_id        = $(this).attr("cat");
  var rss_mpn           = $(this).attr("mpn");
  var rss_mpn_id        = $(this).attr("cta_mpn_id");
  //var rss_mpn_id        = $("body #part_catlg_mt_id_"+row_id).val(); 
  var condition_id      = $("body #estimate_condition_"+row_id).val(); 
  console.log(row_id, rss_cat_id, rss_mpn_id, condition_id);
  // return false;
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




/*==================================================
=            FOR Saving Remarks            =
===================================================*/


  $(document).on('click', "#save_remarks", function(){
      var lz_bd_cata_id = '<?php echo $lz_bd_cata_id; ?>';
      var lot_remarks = $("#lot_remarks").val();
      var url='<?php echo base_url() ?>itemsToEstimate/C_itemsToEstimate/saveLotRemarks'; 

       if (lot_remarks == '' || lot_remarks == null) {
          alert("Warning: Please Enter Lot Remarks First !!");
          return false;
        }else{       
            $(".loader").show();
              $.ajax({
                type: 'POST',
                url:url,
                data: {
                  'lz_bd_cata_id':lz_bd_cata_id,
                  'lot_remarks':lot_remarks
                },
                dataType: 'json',
                success: function (data){
                  $(".loader").hide();
                  if(data == 1){
                        alert("Success: Lot Remarks Saved Succesfully!"); 
                      }else{
                        alert("Erorr: Remarks Updation Failed!"); 
                        }   
                }
              });
            }
            });
  /*=======================================
=        Place Bid/Offer start          =
=======================================*/
/*=======================================
=        Place Bid/Offer start          =
=======================================*/
/*$("#upload_excel_file").click(function(){

    $("#file_name").trigger("click");
  });*/
$(document).on('change', '.columns', function(){
      var option_val  = $(this).val();
      var alphbet_name  = $(this).attr("albt");
      var tableId     = "temp-data-table";
      var tdbk        = document.getElementById(tableId);
      var flag = true;
      var j=1;
      $("#"+tableId+" tbody tr:eq(0) td .columns").each(function()
        {  
        var cloumn_name   = $(this).val();
        var alphbet  = $(this).attr("albt");
        if (cloumn_name === option_val && alphbet_name !== alphbet && option_val != '0')
        {
          flag = false;
          alert('The option '+option_val+' has already selected');
          return false;
        }
        j++;
      });
      if (flag === false) {
        $(this).append('<option value="0" selected="selected">Select Column</option>');
      }
      
});
  $(".move_components").click(function(){
      var ct_cata_id  = $("#ct_catalogue_id").val();
      var cats        = [];
      var cpks        = [];
      var columns     = [];
      var alphabets   = [];
      var tableId     ="temp-data-table";
      var tdbk = document.getElementById(tableId);
      var j = 1;
      // console.log(tdbk);
      // return;
      $("#"+tableId+" tbody tr:eq(0) td .columns").each(function()
      {  
        var cloumn_name   = $(this).val();
        var alphbet_name  = $(this).attr("albt");
        if (cloumn_name !=='0')
        {
          columns.push(cloumn_name);
          alphabets.push(alphbet_name);
        }
        j++;
      });
      //console.log(columns,alphabets); return false;
       $("#"+tableId+" tbody tr td .user_defined_cat").each(function()
        {  
        var cat   = $(this).val();
        var cpk   = $(this).attr("cpk");
        if (cat !=='0')
        {
          cats.push(cat);
          cpks.push(cpk);
        }
      });

      //console.log(cats, cpks); return false;
      columns = columns.filter(v=>v!='');
      alphabets = alphabets.filter(v=>v!== undefined);
      //console.log(columns, alphabets); return false;
      var newColumns = ['MPN','MPN DESCRIPTION', 'UPC', 'OBJECT NAME', 'MANUFACTURER','LOT ID','SKU'];
        if (columns.length==0)
        {
          alert('Please select columns first');
          return false;
        }else{
          for(var i=0; i<=6; i++)
          {
            if(jQuery.inArray( newColumns[i], columns) === -1)
            {
              alert('Please select '+newColumns[i]+' first');
              return false;
            }
          }
        }
        $('.loader').show();
        $.ajax({
          url: '<?php echo base_url() ?>itemsToEstimate/C_itemsToEstimate/uploadCSV',
          type: 'POST',
          datatype : "json",
          data: {'columns':columns, 'alphabets':alphabets, 'ct_cata_id':ct_cata_id, 'cats':cats, 'cpks':cpks},
          success: function (data)
          {
            var obj = JSON.parse(data);
              $(".loader").hide();
              if(obj === 1)
              {
                alert("Success: File uploaded Succesfully!");
                window.location.reload(); 
              }else if(obj === 0){
                    alert("Erorr: Failed to upload File!"); 
              }   
          }  
      });
  });

 $("#upload_excel_file").click(function(){
    var formData      = new FormData($("#frmupload")[0]);
    var file_name     = $("#file_name").val();
    if (file_name == '' || file_name == null)
    {
      alert("Warning: File is required");
      return false;
    }
    $('.loader').show();
    $.ajax({
      url: '<?php echo base_url() ?>itemsToEstimate/C_itemsToEstimate/import_xlsx_file',
      type: 'POST',
      datatype : "json",
      processData: false,
      contentType: false,
      cache: false,
      data: formData,
      success: function (data){
          $(".loader").hide();
          var obj = JSON.parse(data);
          if(obj === 1)
          {
            alert("Success: File uploaded Succesfully!");
            window.location.reload();
      
            //var new_url = '<?php //echo base_url() ?>itemsToEstimate/C_itemsToEstimate/showData'; 
            //window.open(new_url, '_blank');
          }
          else if(obj === 0)
          {
            alert("Erorr: Failed to upload File!"); 
          }   
        }  
      });
    });
/*=======================================
=        Place Bid/Offer start          =
=======================================*/
  $('#closeModal').on('click',function(){
  $('#makeOffer').modal('hide');
  $('#updateOffer').modal('hide');
  $('#discard_item').modal('hide');
}); 

/*================================================
=            Save Bidding Offer            =
================================================*/
/*================================================
=            Save Bidding Offer            =
================================================*/
$(document).on('click','.makeOffer',function(){
  $('#makeOffer').modal('show');
  var rowId = $(this).attr('value');
  var cat_id = $("#lz_cat_id").val();
  $("#lz_cat_id").val(cat_id);
  var lz_bd_catag_id = $("#lz_bd_catag_id").val();
  $("#lz_bd_catag_id").val(lz_bd_catag_id);  
  var lot_offer_amount = $("#offerAmount").val();
});

$(document).on('click','.save_offer',function(){
    var bidding_offer = $("#offer_amount").val();
    var lz_bd_catag_id = $("#lz_bd_catag_id").val(); 
    var cat_id = $("#lz_cat_id").val();
    var remarks = $("#remarks").val();
    
    if (bidding_offer.length === 0) 
    { 
      alert('Bidding Offer is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveBiddingOffer',
    data: {
      'bidding_offer': bidding_offer,
      'lz_bd_catag_id': lz_bd_catag_id,
      'cat_id': cat_id,
      'remarks': remarks
    },
    dataType: 'json',
    success: function (data) {
      $("#after_bidoffer").show();
      //console.log(data); return false;
      $(".loader").hide();

         if(data == "" || data != null){
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is saved.</div>");
            setTimeout(function(){ $("#printMessage").html('');}, 3000);

            /*====== Add tracking No and Cost option after saving Bidd offer start =======*/            
            $("#statusDropdownSave").html("");
            $("#offer_id_save").val(data);
            $("#statusDropdownSave").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status instant_change"> <option value="default">----SELECT----</option> <option value="1" selected>WON</option> <option value="0">LOST</option> </select>');

            $("#saleAmountSave").html("");
            $("#saveStatusSave").html("");
            $("#trackingNumberSave").html("");
            $("#trackingNumberSave").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="">');
            $("#saleAmountSave").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="" placeholder="$ Enter Amount in Number">');
            $("#saveStatusSave").append('<input type="button" class="btn btn-sm btn-success" name="instant_save" id="instant_save" value="Save Status">');
            /*====== Add tracking No and Cost option after saving Bidd offer end =======*/
           // alert("Success: Bidding Offer is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#printMessage").html("<div style='font-size: 16px; font-weight: bold; color: #dd4b39; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not saved.</div>");
            setTimeout(function(){ $("#printMessage").html('');}, 3000);           
           //alert('Error: Bidding Offer is not saved.');
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

/*=====  End of Save Bidding Offer  ======*/
$(document).on('click','#save_status',function(){

  var bid_status = $("#bid_status").val();
  var tracking_number = $("#tracking_number").val();
  var sale_amount = $("#sale_amount").val();
  var update_offer_id = $("#update_offer_id").val();
  var lz_cat_id = $("#update_lz_cat_id").val();
  var lz_bd_cata_id = $("#update_lz_bd_catag_id").val();  
  //console.log(bid_status, tracking_number, sale_amount, update_offer_id);return false;

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/saveBiddingStatus',
    data: {
      'bid_status': bid_status,
      'tracking_number':tracking_number,
      'sale_amount': sale_amount,
      'update_offer_id':update_offer_id,
      'lz_cat_id':lz_cat_id,
      'lz_bd_cata_id':lz_bd_cata_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Status is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000); 
           // alert("Success: Bidding Status is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Status is not Saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000);            
           // alert('Error: Bidding Status is not Saved.');

         }else if(data == "exist"){
            alert("Tracking Number is already exist");
         }else if(data == 3){
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding and Tracking data is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000);          
         }else if(data == 4){
            $("#bidingStatusMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding and Tracking data is not saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessage").html('');}, 3000);          
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
/*================================================
=  Get Bidding Offer and Update Bidding Offer Start  =
================================================*/

$(document).on('click','.updateOffer',function(){
  var offer_id = $("#offer_id").attr('value');
  var cat_id = $("#lz_cat_id").val();
  $("#update_lz_cat_id").val(cat_id);
  var lz_bd_catag_id = $("#lz_bd_catag_id").val();
  $("#update_lz_bd_catag_id").val(lz_bd_catag_id);
  var tracking_id = $("#tracking_id").val();
  var lot_offer_amount = $("#offerAmount").val();
  //alert(lot_offer_amount);
  $("#update_estimate_offer").val(lot_offer_amount);  

  //console.log(offer_id, cat_id, lz_bd_catag_id, tracking_id, lot_offer_amount);return false;
  //alert(offer_id);return false;
  
  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/getBiddingOffer',
    data: {
      'offer_id': offer_id,
      'tracking_id': tracking_id
    },
    dataType: 'json',
    success: function (data) {
      console.log(data); 
      //console.log(data.offer_data[0].OFFER_ID); return false;
      
      if(data.tracking_data != 0){
        var tracking_no = data.tracking_data[0].TRACKING_NO;
        if(tracking_no == "" || tracking_no == null || tracking_no == undefined){
          tracking_no = "";
        }
        var cost_price = data.tracking_data[0].COST_PRICE;
        if(cost_price == "" || cost_price == null){
          cost_price = "";
        }
      }
      
      if(data.offer_data != 0){
        var bid_status = data.offer_data[0].WIN_STATUS;
        var sold_amount = data.offer_data[0].SOLD_AMOUNT;
        if(sold_amount == "" || sold_amount == null){
          sold_amount = "";
        }
      }
      $(".loader").hide();
      if(data){
        $('#updateOffer').modal('show');
        $('#update_offer_id').val(data.offer_data[0].OFFER_ID);
        $('#update_offer_amount').val(data.offer_data[0].OFFER_AMOUNT);
        $('#update_remarks').val(data.offer_data[0].REMARKS);

        
        $("#statusDropdown").html("");
        var selected = "";
        if(bid_status == 0){
          selected = "selected";
          $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0" '+selected+'>LOST</option> </select>');          
        }else if(bid_status == 1){
          selected = "selected";
          $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" '+selected+' >WON</option> <option value="0">LOST</option> </select>');          
        }else{
          selected = "";
        }
              

        if(bid_status == 0){
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#saleAmount").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="'+sold_amount+'" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-success" name="save_status" id="save_status" value="Update Status">');
        }else if(bid_status == 1){
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#trackingNumber").append('<label for="Tracking Number">Tracking Number:</label> <input type="text" class="form-control" name="tracking_number" id="tracking_number" value="'+tracking_no+'">');
          $("#saleAmount").append('<label for="Cost">Cost:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount"  value="'+cost_price+'" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-success" name="save_status" id="save_status" value="Update Status">');
        }else if(bid_status == 2){
          $("#saleAmount").html("");
          $("#trackingNumber").html("");
        }else{
          $("#statusDropdown").html("");
          $("#saleAmount").html("");
          $("#saveStatus").html("");
          $("#trackingNumber").html("");
          $("#saleAmount").append('<label for="Sale Amount">Sale Amount:</label> <input type="number" class="form-control" name="sale_amount" id="sale_amount" value="" placeholder="$ Enter Amount in Number">');
          $("#saveStatus").append('<input type="button" class="btn btn-sm btn-primary" name="save_status" id="save_status" value="Save Status">');
          $("#statusDropdown").append('<label for="Bid/Offer Status">Bid/Offer Status</label> <select name="bid_status" id="bid_status" class="form-control bid_status"> <option value="default">----SELECT----</option> <option value="1" >WON</option> <option value="0">LOST</option> </select>');           
        }      

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
// Instant saving of Tracking Number and Cost with Status
$(document).on('click','.update_offer',function(){

    var update_offer_id = $('#update_offer_id').val();
    var update_offer_amount = $("#update_offer_amount").val();
    var update_remarks = $("#update_remarks").val(); 
    var bid_status = $("#bid_status").val(); 
    // console.log(update_offer_id+" - " + update_offer_amount +" - "+update_remarks); return false; 
    if (update_offer_amount.length === 0) { 
      alert('Bidding Offer is required'); 
      return false;
    }  

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/reviseBiddingOffer',
    data: {
      'update_offer_id': update_offer_id,
      'update_offer_amount': update_offer_amount,
      'update_remarks': update_remarks,
      'bid_status': bid_status
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
      $(".loader").hide();
         if(data == 1){
            $("#updatePrintMessage").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Offer is Updated.</div>");
            setTimeout(function(){ $("#updatePrintMessage").html('');}, 3000);

               // alert("Success: Bidding Offer is saved.");   
               // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#updatePrintMessage").html("<div style='font-size: 16px; font-weight: bold; color: #dd4b39; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Offer is not Updated.</div>");
            setTimeout(function(){ $("#updatePrintMessage").html('');}, 3000);           
           //alert('Error: Bidding Offer is not saved.');

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

$(document).on('click','#instant_save',function(){

  var bid_status = $("#bid_status").val();
  var tracking_number = $("#tracking_number").val();
  var sale_amount = $("#sale_amount").val();
  var offer_id_save = $("#offer_id_save").val();
  var lz_cat_id = $("#lz_cat_id").val();
  var lz_bd_cata_id = $("#lz_bd_catag_id").val(); 
  //console.log(lz_cat_id, lz_bd_cata_id); return false;
  //console.log(bid_status, tracking_number, sale_amount, offer_id_save);return false;

  $(".loader").show();
  $.ajax({

    type: 'POST',
    url: '<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/instantSaveBiddingStatus',
    data: {
      'bid_status': bid_status,
      'tracking_number':tracking_number,
      'sale_amount': sale_amount,
      'offer_id_save':offer_id_save,
      'lz_cat_id':lz_cat_id,
      'lz_bd_cata_id':lz_bd_cata_id
    },
    dataType: 'json',
    success: function (data) {
      //console.log(data); return false;
    
      $(".loader").hide();
         if(data == 1){
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding Status is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000); 
           // alert("Success: Bidding Status is saved.");   
           // window.location.reload(); 
         }else if(data == 2){
           $(".loader").hide();
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding Status is not Saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000);            
           // alert('Error: Bidding Status is not Saved.');

         }else if(data == "exist"){
            alert("Tracking Number is already exist");
         }else if(data == 3){
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Success: Bidding and Tracking data is saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000);          
         }else if(data == 4){
            $("#bidingStatusMessageSave").html("<div style='font-size: 16px; font-weight: bold; color: #ffffff; background-color: #00a65a; padding: 10px; border-radius: 5px;'>Error: Bidding and Tracking data is not saved.</div>");
            setTimeout(function(){ $("#bidingStatusMessageSave").html('');}, 3000);          
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
/*=====  End of Save WIN and LOSS Status  ======*/

/*================================================
=  Get Bidding Offer and Update Bidding Offer Start  =
================================================*/
/*=====  End of save Remarks function  ======*/
checkOffer();
function checkOffer(){
  var lot_cata_id = $("#ct_cata_id").val();
if (lot_cata_id !='') {
   //console.log(lot_cata_id); //return false;
  $.ajax({
      type:'post',
      dataType:'json',
      url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/checkOfferAmount',
      data:{'lot_cata_id':lot_cata_id},
      success:function(data){
       // console.log(data);
        if (data.length > 0) {
          $("#offer_id").val(data[0].OFFER_ID);
          $("#tracking_id").val(data[0].TRACKING_ID);
          //$("#offer_amount").val('');
          //$(".offerAmount").val('');
          //$("#offer_amount").val(parseFloat(data[0].OFFER_AMOUNT).toFixed(2));
          //$(".offerAmount").val(parseFloat(data[0].OFFER_AMOUNT).toFixed(2));
          var test =  parseFloat(data[0].OFFER_AMOUNT).toFixed(2);
          //console.log(data.length);
         
            $("#insert_bid_offer").hide();
            $("#update_bid_offer").show();
          
        }else{
            $("#insert_bid_offer").show();
            $("#update_bid_offer").hide();
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
 
}


$(document).on('change', '#es_status', function(){
  var es_status = $('#es_status').val();  

      if (es_status == 20) 
      { 
      $('.hide_component').show();
      $('.hide_component1').show();
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
      $('.hide_component1').hide();
    }//end if check for status 20 
});

/*==================================================
=            FOR Lot Estimate COMPONENTS             =
===================================================*/



  $(document).on('click', ".save_components", function(){
    //$('#showAll').click();
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

      //var cat_id = '<?php //echo $cat_id; ?>';
      var cat_id = $('#ct_category_id').val();
      var lz_bd_cata_id = '<?php echo $lz_bd_cata_id; ?>';
      var red_flag= '<?php echo $this->uri->segment(5); ?>';
      var url='<?php echo base_url() ?>itemsToEstimate/C_itemsToEstimate/saveLotComponents';
      // var lot_remarks = $("#all_mpn_id").val();
      // console.log(all_mpn_id) return false;

      var offer_amount = $("#offerAmount").val();
      offer_amount = offer_amount.substring(1, offer_amount.length);
      //console.log(offer_amount); return false;
      var lz_bd_estimate_det=[];
      var compQty=[];
      var compAvgPrice=[];
      var compAmount=[];
      var ebayFee=[];
      var payPalFee=[];
      var shipFee=[];
      var tech_condition=[];
      var mpn_description=[];
      //var part_catlg_mt_id=[];
      var flag = '';
      // var price = $('#kit-components-table tr').eq(1).find('td').eq(7).find('input').val();
      // console.log(price);return false;
      flag = true;
      $("#kit-components-table tr").each(function(){

        $(this).find(".lz_estimate_det_id").each(function() {
          lz_bd_estimate_det.push($(this).val());
        });
        $(this).find(".estimate_condition").each(function() {
          tech_condition.push($(this).val());
        });        
        $(this).find(".mpn_description").each(function() {
          mpn_description.push($(this).val());
        });
        // $(this).find(".b_part_catlg_mt_id").each(function() {
        //   part_catlg_mt_id.push($(this).val());
        // });
        $(this).find(".component_qty").each(function() {
          compQty.push($(this).val());
        }); 
        $(this).find('.cata_avg_price').each(function() {
          compAvgPrice.push($(this).val());
        });
        
        $(this).find('.cata_est_price').each(function(){

          if ($(this).val() <= 0 || $(this).val() == 00 || $(this).val() == 0. || $(this).val() == 0.0 || $(this).val() == 0.00 || $(this).val() == 0.000) {
            //alert("Please add estimate price.");
            flag = false;
          }else {
           compAmount.push($(this).val()); 
          }
          
        });
        $(this).find('.cata_ebay_fee').each(function(){
          ebayFee.push($(this).val());
        });
        $(this).find('.cata_paypal_fee').each(function(){
          payPalFee.push($(this).val());
        });
        $(this).find('.cata_ship_fee').each(function(){
          shipFee.push($(this).val());
        });           
      });

      tech_condition = tech_condition.filter(v=>v!='');

        //console.log(lz_bd_estimate_det, tech_condition, compQty, compAvgPrice, compAmount, ebayFee, payPalFee, shipFee); return false;
        //console.log(lz_bd_estimate_det); return false;
        //console.log(part_catlg_mt_id); return false;
        //compAmount.length < shipFee.length
          if (compAmount.length < shipFee.length) {
            alert("Warning: Please Insert Price of Components");
            return false;
          }
            $(".loader").show();
              $.ajax({
                type: 'POST',
                url:url,
                data: {
                  'cat_id':cat_id,
                  'lz_bd_cata_id': lz_bd_cata_id,
                  'lz_bd_estimate_det':lz_bd_estimate_det,
                  'compQty': compQty,
                  'compAvgPrice': compAvgPrice,
                  'compAmount': compAmount,
                  'ebayFee': ebayFee,
                  'payPalFee': payPalFee,
                  'shipFee': shipFee,
                  'tech_condition':tech_condition,
                  'offer_amount':offer_amount,
                  'mpn_description':mpn_description,
                  'es_status':es_status,
                  'discard_remarks':discard_remarks

                  //'lot_remarks':lot_remarks
                },
                dataType: 'json',
                success: function (data){
                    if(data == 1){
                      if(red_flag == 1111){
                        alert("Success: Estimate is created!"); 
                        window.location.href = '<?php echo base_url(); ?>biddingItems/c_biddingItems/purchasing_detail';

                      }else if(red_flag == 1){
                        alert("Success: Estimate is created!");
                        location.reload(); 
                        //window.location.href = '<?php //echo base_url(); ?>itemsToEstimate/c_itemsToEstimate';

                      }
                      else{
                        alert("Success: Estimate is created!"); 
                        window.location.href = '<?php echo base_url(); ?>catalogueToCash/c_lot_purchasing/lot_purchasing';
                        }  
                     }else if(data == 2){
                       alert('Error: Fail to create estimate!');
                     }
                   },
                complete: function(data){
                  $(".loader").hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  alert(jqXHR.status);
                  alert(textStatus);
                  alert(errorThrown);
              }
          });
  });

  /*=================END FOR Lot Estimate COMPONENTS ==============*/

  /*==============================================================
  =                 start add mpn button           =
  ================================================================*/

   $(document).on('click', '#add_mpn', function(event) {
     event.preventDefault();
     var category_id          = $("#category_id").val();
     var category_id          = $("#mpn_category").val(category_id);
     var object_id            = $("#comp_object").val();
     var object_name          = $("#comp_object option:selected").text();
     var master_mpn_id        = $("#ct_catlogue_mt_id").val();
     //console.log(category_id, object_id, object_name, master_mpn_id); return false;

       //$("#mpn_category").val(category_id).selectpicker('refresh'); 
       if (object_name != '---select---') {
          $("#mpn_object").val(object_name); 
       }
       $("#add_mpn_section").show();
       $(".hide-component").hide();
       //console.log(category_id, object_id, object_name, master_mpn_id); return false;
   });

/*========= End of add mpn button == */

  /*==============================================================
  =                 start add new mpn option       =
  ================================================================*/
  $(document).on('click', "#add_new_mpn", function(){
    //var row_id = 1;
    var lz_bd_cata_id       = "<?php echo $lz_bd_cata_id; ?>";
    var mpn_object          = $("#mpn_object").val();
    var mpn_brand           = $("#mpn_brand").val();
    var new_mpn             = $("#new_mpn").val();
    var mpn_desc            = $('#cust_mpn_description').val();
    var cat_id              = $("#mpn_category").val();
    var lot_upc             = $.trim($("#lot_upc").val());
    //alert(lot_upc); return false;
    //var master_mpn              = $("#ct_catlogue_mt_id").val();

   if( cat_id == 0 || cat_id == undefined){
    alert('Warning: Category is required!');
  }else if(mpn_object == '' || mpn_object == null){
    alert('Warning: Object is required!');
    //$("#mpn_object").focus();
    return false;
  }else if( mpn_brand == '' || mpn_brand == null){
    alert('Warning: Brand name is required!');
    //$("#mpn_brand").focus();
    return false;
  }else if( new_mpn == '' || new_mpn == null){
    alert('Warning: Please insert MPN!');
    //$("#new_mpn").focus();
    return false;
  }else if(mpn_desc == '' || mpn_desc == null){
    alert('Warning: MPN Description is required!');
    //$("#cust_mpn_description").focus();
    return false;
  }else{
    ////console.log(cat_id, master_mpn, mpn_object, mpn_brand, new_mpn, mpn_desc); return false;
    $(".loader").show();
     $.ajax({
        dataType: 'json',
        type: 'POST',        
        url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/addCataMpn',
        data: {'cat_id':cat_id,'mpn_object':mpn_object,  'mpn_brand':mpn_brand, 
               'new_mpn':new_mpn, 'mpn_desc':mpn_desc, 'lz_bd_cata_id':lz_bd_cata_id, 'lot_upc':lot_upc},
        success: function (data) {
          //console.log(data.result.estimate[0].EST_SELL_PRICE);
          $(".loader").hide();
         if(data == 2){
            alert('Error! Record is not inserted.');
            return false;
          }else if(data){
           // alert('Sucess! Record is successfully inserted.');

            //var row_id = $('#kit-components-table tr').length;

            //$("#mpn_category").val('');
            //$("#mpn_object").val('');
            //$("#mpn_brand").val('');
            $("#new_mpn").val('');
            $("#lot_upc").val('');
            $('#cust_mpn_description').val('');
            $("#add_mpn_section").hide();
            $(".hide-component").show();


          var mpns = [];
          var condition_id = "<?php echo $cond_id; ?>";

          for(var i = 0;i<data.conditions.length; i++){
            if (condition_id == data.conditions[i].ID){
              var selected = "selected";
            }else {
              var selected = "";
            }

            mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
          }

          
          var table = $('#kit-components-table').DataTable();

            /*============================================
            =            creating history URL            =
            ============================================*/
           var url1 = 'https://www.ebay.com/sch/';
           var cat_name = $("#category_name").val();
           cat_name = cat_name.replace(' ','-');
           cat_name = cat_name.replace('&','-');
           cat_name = cat_name.replace('/','-');
           var cat_id = $("#category_id").val();
           var url2 = cat_name+'/'+cat_id+'/';
           var url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='+condition_id;
           var url4 = '&_nkw='+data.result.detail[0].MPN;
           //var url5 = '&LH_Complete=1&LH_Sold=1';
           var final_url = url1+url2+url3+url4; //+url5;
            /*=====  End of creating history URL  ======*/
            
          // var estimate_price = data.result.estimate[0].EST_SELL_PRICE;
          var row_id = table.page.info().recordsTotal +1;
          var est_price_name = 'cata_est_price_'+row_id;

          var estimate_price = 0.00;

          var upc = data.result.detail[0].UPC;

          if(upc === null || upc === undefined){
            upc = '';              
          }

          var mpn_description = data.result.detail[0].MPN_DESCRIPTION;

          if(mpn_description === null || mpn_description === undefined){
            mpn_description = '';              
          }  
          var mpn_description = mpn_description.replace(/[<>'"]/g, function(m) {
                          return '&' + {
                            '\'': 'apos',
                            '"': 'quot',
                            '&': 'amp',
                            '<': 'lt',
                            '>': 'gt',
                          }[m] + ';';
                        });                   

          table.row.add( $('<tr> <td><button title="Delete Component" id="'+data.result.detail[0].LZ_ESTIMATE_DET_ID+'" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button style="margin-left: 5px;" title="Add Keyword" rd="'+row_id+'" cat="'+data.result.detail[0].CATEGORY_ID+'" mpn="'+data.result.detail[0].MPN+'" class="btn btn-info btn-xs glyphicon glyphicon-pencil Keywords"  data-target="#addKeyword" cta_mpn_id="'+data.result.detail[0].PART_CATLG_MT_ID+'"></button><button style="margin-left: 5px;" title="Pull Sold Price" rd="'+row_id+'" cat="'+data.result.detail[0].CATEGORY_ID+'" mpn="'+data.result.detail[0].MPN+'" condition="'+data.result.detail[0].TECH_COND_ID+'" id="get_sold_price" class="btn btn-success btn-xs glyphicon glyphicon-magnet get_sold_price"  data-target="#addKeyword"> </button></td><td>NOT FOUND</td> <td>'+data.result.detail[0].OBJECT_NAME+' </td> <td><div  style="" title="Search this MPN on eBay"><a style="" href="'+final_url+'" target= "_blank" >'+data.result.detail[0].MPN+'</a></div></td><td><div style="" title="UPC">'+upc+'</div></td><td><input style="width: 300px;" type="text" class="form-control mpn_description" name="mpn_description" id="mpn_description_'+row_id+'" maxlength="80" title="'+mpn_description+'" value="'+mpn_description+'"><input type="hidden" class="b_part_catlg_mt_id" name="b_part_catlg_mt_id" id="b_part_catlg_mt_id_'+row_id+'" value="'+data.result.detail[0].PART_CATLG_MT_ID+'"></td><td> <input type="hidden" class="lz_estimate_det_id" name="lz_estimate_det_id" id="lz_estimate_det_id" value="'+data.result.detail[0].LZ_ESTIMATE_DET_ID+'"> <div class="form-group" style="width: 130px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result.detail[0].PART_CATLG_MT_ID+'" rd = "'+row_id+'" style="width: 130px;">'+mpns.join("")+'</select> </div> </td> <td><div class="form-group" style="width:70px;"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="1" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$ 0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input  name="'+data.result.detail[0].PART_CATLG_MT_ID+'" type="number" id="'+est_price_name+'" class="form-control input-sm cata_est_price '+data.result.detail[0].PART_CATLG_MT_ID+'" value="'+parseFloat(estimate_price).toFixed(2)+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_'+row_id+'" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;"> </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$0.00</p></td></tr>')).draw();
          //row_id++;

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
/*========= End of add new mpn option == */

  /*==============================================================
  =               FOR SAVING KIT PARTS   go_to_catalogue          =
  ================================================================*/
  //var row_id = 1;
  // var row_id = $('#kit-components-table tr').length;
  // console.log(row_id);
$("#save_mpn_kit").on('click', function(){
  //console.log(row_id);
    var url='<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/addlotToEstimate';
    var comp_mpn = $("#comp_mpn").val();
    var comp_text = $("#comp_mpn option:selected").text();
    var comp_object = $("#comp_object option:selected").text();
    // console.log(comp_text); 
    // console.log(comp_mpn); return false;
    var comp_upc= $.trim($("#get_upc").val());
    var ct_cata_id = $("#ct_cata_id").val();
    var condition_id = "<?php echo $cond_id; ?>";
    //console.log(condition_id);return false;
    if(comp_mpn == 0 || comp_mpn == null){
      alert("Please select MPN.");
      return false;
    }

    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'ct_cata_id': ct_cata_id,
      'comp_mpn' : comp_mpn,
      'comp_upc' : comp_upc,
      'condition_id':condition_id,
      'comp_text':comp_text,
      'comp_object':comp_object
    },
    dataType: 'json',
    success: function (data){
      //console.log(data.result.estimate[0].EST_SELL_PRICE);
      if(data){
        
        //console.log(data.result.detail); return false;
          //var row_id = $('#kit-components-table tr').length;
          //var row_id = $('#kit-components-table tr').not('thead tr').length;
          //var row_id = $('#kit-components-table > tbody > tr').length;
          //var row_id = $('#reloa_id').children('tr').length;
          //var row_id = $('table#kit-components-table tr:last').index() + 1;

          //console.log(row_id);
        //console.log(data.result.detail[0], data.result.estimate[0]);
        $(".loader").hide();
        //$('#comp_mpn').find('option:first').attr('selected', 'selected');
        $('#comp_mpn').val(0);
        $("#comp_mpn").selectpicker("refresh");
        $('#get_upc').val('');

        // console.log(data.result);
        // console.log(data.conditions);
        //alert("Success: Component is created!");

          //var row_id = data.result[0].LZ_ESTIMATE_DET_ID;
          var mpns = [];
          var condition_id = "<?php echo $cond_id; ?>";

          for(var i = 0;i<data.conditions.length; i++){
            if (condition_id == data.conditions[i].ID){
              var selected = "selected";
            }else {
              var selected = "";
            }

            mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
          }
          var estimate_price = data.result.estimate;
          if(estimate_price == 0){
            estimate_price = 0.00;
          }

          
          var table = $('#kit-components-table').DataTable();
            /*============================================
            =            creating history URL            =
            ============================================*/
           var url1 = 'https://www.ebay.com/sch/';
           var cat_name = $("#category_name").val();
           cat_name = cat_name.replace(' ','-');
           cat_name = cat_name.replace('&','-');
           cat_name = cat_name.replace('/','-');
           var cat_id = $("#category_id").val();
           var url2 = cat_name+'/'+cat_id+'/';
           var url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='+condition_id;
           if(data.result.detail[0].KEYWORD != ''){
            var url4 = '&_nkw='+data.result.detail[0].KEYWORD;
           }else{
            var url4 = '&_nkw='+data.result.detail[0].MPN;
           }
           
           //var url5 = '&LH_Complete=1&LH_Sold=1';
           var final_url = url1+url2+url3+url4; //+url5;
            /*=====  End of creating history URL  ======*/

            var row_id = table.page.info().recordsTotal +1;

            var est_price_name = 'cata_est_price_'+row_id;
            //console.log(row_id);
            var upc = data.result.detail[0].UPC;
            

            if(upc === null || upc === undefined){
              upc = '';              
            }
            var mpn_description = data.result.detail[0].MPN_DESCRIPTION;
            //console.log(mpn_description); return false;
            if(mpn_description === null || mpn_description === undefined){
              mpn_description = '';              
            } 
            var mpn_description = mpn_description.replace(/[<>'"]/g, function(m) {
                          return '&' + {
                            '\'': 'apos',
                            '"': 'quot',
                            '&': 'amp',
                            '<': 'lt',
                            '>': 'gt',
                          }[m] + ';';
                        }); 

            // if( typeof upc == 'object'){
            // upc = JSON.stringify(upc);
            // upc = '';
            // // alert(dekit);
            // } 
          table.row.add( $('<tr> <td><button title="Delete Component" id="'+data.result.detail[0].LZ_ESTIMATE_DET_ID+'" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button style="margin-left: 5px;" title="Add Keyword" rd="'+row_id+'" cat="'+data.result.detail[0].CATEGORY_ID+'" mpn="'+data.result.detail[0].MPN+'" class="btn btn-info btn-xs glyphicon glyphicon-pencil Keywords"  data-target="#addKeyword" cta_mpn_id="'+data.result.detail[0].PART_CATLG_MT_ID+'"></button><button style="margin-left: 5px;" title="Pull Sold Price" rd="'+row_id+'" cat="'+data.result.detail[0].CATEGORY_ID+'" mpn="'+data.result.detail[0].MPN+'" condition="'+data.result.detail[0].TECH_COND_ID+'" id="get_sold_price" class="btn btn-success btn-xs glyphicon glyphicon-magnet get_sold_price"  data-target="#addKeyword"> </button></td><td><div id="singlePic_'+row_id+'"> </div></td> <td><div  style="" title="Search  MPN on eBay"><a style="" href="'+final_url+'" target= "_blank" >'+data.result.detail[0].OBJECT_NAME+' </a></div></td> <td>'+data.result.detail[0].MPN+'</td>    <td><div  style="" title="UPC">'+upc+'</div></td><td><input style="width: 300px;" type="text" class="form-control mpn_description" name="mpn_description" id="mpn_description_'+row_id+'" maxlength="80" title="'+mpn_description+'" value="'+mpn_description+'"><input type="hidden" class="b_part_catlg_mt_id" name="b_part_catlg_mt_id" id="b_part_catlg_mt_id_'+row_id+'" value="'+data.result.detail[0].PART_CATLG_MT_ID+'"</td><td> <input type="hidden" class="lz_estimate_det_id" name="lz_estimate_det_id" id="lz_estimate_det_id" value="'+data.result.detail[0].LZ_ESTIMATE_DET_ID+'"> <div class="form-group" style="width: 130px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result.detail[0].PART_CATLG_MT_ID+'" rd = "'+row_id+'" style="width: 130px;">'+mpns.join("")+'</select> </div> </td> <td><div class="form-group" style="width:70px;"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="1" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$ 0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" name="'+data.result.detail[0].PART_CATLG_MT_ID+'" id="'+est_price_name+'" class="form-control input-sm cata_est_price "'+data.result.detail[0].PART_CATLG_MT_ID+'" value="'+parseFloat(estimate_price).toFixed(2)+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_'+row_id+'" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" > </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$ 0.00</p></td></tr>')).draw();
            /*=============================================
            =            Picture Section start            =
            =============================================*/

                //console.log(one);//return false;
            if(data.result.master_pics != 0){
              var picture = data.result.master_pics[0]; 
              // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
              var img = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);"><img class="sort_img up-img zoom_01" id="" name="master_pics[]" src="data:image;base64,'+picture+'"/></div>';
                //dirPics.push(''+img+' </div>'); 
              // }

              //$('#picsList').html("");
              $("#singlePic_"+row_id).append(img);

              // $('.zoom_01').elevateZoom();
              $('.zoom_01').elevateZoom({
                //zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 600,
                zoomWindowFadeOut: 600,
                easing : true,
                scrollZoom : true
               });            
              $('.loader').hide();
            }else{
              $("#singlePic_"+row_id).html("NOT FOUND");
            }  

            /*=====  End of Picture Section  ======*/          
          //$('#comp_mpn').html(""); //empty mpn dropdown after append row
          //$("#comp_mpn").val(0);
          // $(document).on('ready', '#comp_mpns', function(){
          //   $('#comp_mpn').find('option:first').attr('selected', 'selected');
          // });
           //row_id++;
           //console.log(row_id);
          
       
      $(".loader").hide();
      }else if(data == 2){
        alert("Error: Fail to create component! Try Again");
      }else if(data.check == 0){
        alert("Warning: Estimate is already exist!");
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
  /*===============END OF SAVING KIT PARTS===================*/
/*==============================================================
  =                 Delete lot component from estimate            =
  ================================================================*/
$(document).on('click', '.del_comp', function(){
  var lz_estimate_det_id = $(this).attr("id");
  var this_tr = $(this).closest('tr');
  //alert(lz_estimate_det_id);return false;
  var x = confirm("Are you sure you want to delete?");
  if(x){
    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/deleteFromEstimate',
      type:'post',
      dataType:'json',
      data:{'lz_estimate_det_id':lz_estimate_det_id},
      success:function(data){

         if(data == 1){
          $(".loader").hide();
          // var row=$("#"+lz_estimate_det_id);
          // //debugger;     
          // row.closest('tr').fadeOut(1000, function() {
          // row.closest('tr').remove();
          // });
          var table = $('#kit-components-table').DataTable();          
          this_tr.fadeOut(1000, function () { table.row(this_tr).remove().draw() });
         }else if(data == 2){
          alert("Error! Component is not deleted");
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
  }else{
    return false;
  }

});


 /*===============END OF Delete lot component from estimate===================*/

/*==============================================================
  =                 GET RELATED OBJECTS ON CHANGE            =
  ================================================================*/
//   $('#comp_category').on('change',function(){
//   var comp_category = $(this).val();
//   // alert(comp_category);
//   $(".loader").show();
//   $.ajax({
//     url:'<?php //echo base_url(); ?>catalogueToCash/c_purchasing/get_objects',
//     type:'post',
//     dataType:'json',
//     data:{'comp_category':comp_category},
//     success:function(data){
//        $(".loader").hide();
//       var objects = [];
//        // alert(data.length);return false;
//       for(var i = 0;i<data.length;i++){
//         objects.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>');
//       }
//       $('#comp_objects').html("");
//       $('#comp_objects').append('<select name="comp_object" id="comp_object" class="form-control comp_object" data-live-search="true" required><option value="0">---select---</option>'+objects.join("")+'</select>');
//       $('.comp_object').selectpicker();
//     },
//      complete: function(data){
//       $(".loader").hide();
//     },
//       error: function(jqXHR, textStatus, errorThrown){
//          $(".loader").hide();
//         if (jqXHR.status){
//           alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
//         }
//     }
//   });
// });

/*==============END OF RELATED OBJECTS ===========================*/


  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
  $(document).on('change', '#comp_object', function(){

  var object_id = $(this).val();
  var category_id = $("#category_id").val();
  //var comp_object = $("#comp_object").text();
  var comp_object = $("#comp_object option:selected").text();
  //console.log(comp_object); return false;
  if(comp_object == "LAPTOP"){

    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/get_brands',
      type:'post',
      dataType:'json',
      data:{'object_id':object_id, 'category_id':category_id},
      success:function(data){
        var brands = [];
         // alert(data.length);return false;
        for(var i = 0;i<data.length;i++){
          brands.push('<option value="'+data[i].SPECIFIC_VALUE+'">'+data[i].SPECIFIC_VALUE+'</option>')
        }
        $('#brands').html("");
        $('#comp_upc').html("");
        $('#brands').append('<select name="get_brand" id="get_brand" class="form-control get_brand selectpicker" data-live-search="true" required><option value="0">---select---</option>'+brands.join("")+'</select>');
        $('#comp_upc').append('<label>UPC:</label><input class="form-control" type="text" name="get_upc" id="get_upc"/>');
        $('.get_brand').selectpicker();

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

    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/get_mpns',
      type:'post',
      dataType:'json',
      data:{'object_id':object_id, 'category_id':category_id},
      success:function(data){
        var mpns = [];
         // alert(data.length);return false;
        for(var i = 0;i<data.length;i++){
          var upc = data[i].UPC;
          if(upc === null || upc === undefined){
            upc = "";
          }else{
            upc = ' (UPC - '+upc+')';
          }
          //mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'`'+data[i].MPN+'">'+data[i].MPN+upc+' ~ '+data[i].MPN_DESCRIPTION+'</option>')
          mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+upc+' ~ '+data[i].MPN_DESCRIPTION+'</option>')
        }
        $('#get_brand').html("");
        $('#comp_mpns').html("");
         $('#comp_upc').html("");
        $('#comp_mpns').append('<select name="comp_mpn" id="comp_mpn" class="form-control comp_mpn selectpicker" data-live-search="true" required><option value="0">---select---</option>'+mpns.join("")+'</select>');
        $('#comp_upc').append('<label>UPC:</label><input class="form-control" type="text" name="get_upc" id="get_upc"/>');
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

  }

});

//Get Brands against Laptop
$(document).on('change', '#get_brand', function(){

  var object_id = $("#comp_object option:selected").val();  
  var category_id = $("#category_id").val();
  //var comp_object = $("#comp_object").text();
  var get_brand = $("#get_brand option:selected").text();
  //console.log(object_id, get_brand); return false;

    $(".loader").show();
    $.ajax({
      url:'<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/getBrandwiseMPN',
      type:'post',
      dataType:'json',
      data:{'object_id':object_id, 'category_id':category_id, 'get_brand':get_brand},
      success:function(data){
        var mpns = [];
         // alert(data.length);return false;
        for(var i = 0;i<data.length;i++){
          mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+' - '+data[i].MPN_DESCRIPTION+'</option>')
        }
        $('#comp_mpns').html("");
        $('#comp_mpns').append('<select name="comp_mpn" id="comp_mpn" class="form-control comp_mpn selectpicker" data-live-search="true" required><option value="0">---select---</option>'+mpns.join("")+'</select>');
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

/*==============END OF RELATED MPNS ===========================*/
   // $('input[class=cata_est_price]').change(function(){
  

   // //update same mpn estimate price price 
   
   //  // update same mpn estimate price price 


   //  });

  /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
   $(document).on('blur','.cata_ship_fee',function(){

    var get = $(this).val();
    // console.log(get);
    // return false;
 
    var get_mpn = $(this).attr('attr_mpn') ;

    $("#kit-components-table tr").each(function(){
       $(this).find('.'+get_mpn).each(function(){           
              $('.'+get_mpn).val(get);

      });
    });
  });

  $(document).on('blur','.cata_est_price',function(){

    var get = $(this).val() ;
    var get_mpn = $(this).attr('name') ;

    $("#kit-components-table tr").each(function(){
       $(this).find('.'+get_mpn).each(function(){           
              $('.'+get_mpn).val(get);
              
    var est_id = this.id.match(/\d+/);

    //var est_comp_check = $("#component_check_"+est_id).attr( "checked", true );
    var est_price = $(this).val().replace(/\$/g, '').replace(/\ /g, '');
    // console.log(est_id);
    // return false;
    var qty = $("#cata_component_qty_"+est_id).val();
    var amount = parseFloat(parseFloat(est_price) * parseFloat(qty)).toFixed(2);
   
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+est_id).val().replace(/\$/g, '').replace(/\ /g, '');
    // var ship_fee = ship_fee * qty;
    // $("#cata_ship_fee_"+est_id).val(ship_fee);
     //console.log(est_price, qty, ebay_price, paypal_price, ship_fee); return false;
    $("#cata_amount_"+est_id).val('$ '+amount);
    //console.log(ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+est_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+est_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(amount) - parseFloat(ebay_price) - parseFloat(paypal_price) - parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+est_id).html('$ '+total);


    var sumQty = 0;
        sumQty = parseInt(sumQty);
        var currQty = 0;
        $("input[class *= 'component_qty']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#cata_est_price_"+id).val() != 0.00 ){
            // alert(id);return false;
            currQty = $("#cata_component_qty_"+id).val();
            sumQty += parseInt(currQty);
          }

        });
        sumQty.toFixed(2);
        $(".total_qty").val(sumQty); 

        var sumSold = 0;
        sumSold = parseFloat(sumSold);
        var currSold = 0; 
        $("input[class *= 'cata_avg_price']").each(function(){
          var id = this.id.match(/\d+/);

          
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
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
          if($("#cata_est_price_"+id).val() != 0.00){
            currLineTotal = $("#cata_total_"+id).text();
            currLineTotal = currLineTotal.substring(1, currLineTotal.length);
            sumLineTotal += parseFloat(currLineTotal);
          }
        });
        sumLineTotal = sumLineTotal.toFixed(2);
        $(".totalClass").val('') ;
        $(".totalClass").val('$'+sumLineTotal);

        /*========Estimate Profit start ======*/
        var newPerc = parseFloat($("#newPerc").val());
        if(isNaN(newPerc)){
          newPerc = 0.00;
        }

        var total_amount = $("#total_amount").val();
        total_amount = total_amount.substring(1, total_amount.length);
        total_amount = parseFloat(total_amount);
        var perc_amnt = total_amount;
        perc_amnt = (parseFloat(perc_amnt)/100) * parseFloat(newPerc);
        //var final_price = parseFloat(total_amount) - parseFloat(perc_amnt);
        esitmate_profit = perc_amnt.toFixed(2);

        $(".percentageAmount").val('$ '+esitmate_profit); 
        /*========Estimate Profit end ======*/

        /*========Offer Amount start ======*/
        var net_sale = $("#totalClass").val();
        net_sale = net_sale.substring(1, net_sale.length);
        var percent_amount = $("#percentageAmount").val();
        percent_amount = percent_amount.substring(1, percent_amount.length);      

        var offer_amount = parseFloat(net_sale) - parseFloat(percent_amount);
        $(".offerAmount").val('$ '+offer_amount.toFixed(2));
        //console.log(offer_amount);

        /*========Offer Amount end ======*/  

            
          
        });  


    }); 


  });
  /*==============================================================
  =                 GET RELATED MPNS ON CHANGE OBJECTS           =
  ================================================================*/
    /*=========================================================
  =         CHARGES CALCULATION FROM ESTIMATE PRICE         =
  ===========================================================*/ 
   $(document).on('blur','.component_qty',function(){
    // $(".component_qty").on('blur', function(){
    var qty_id = $(this).attr("rowid");
    //var est_comp_check = $("#component_check_"+qty_id).attr( "checked", true );
    var qty = $("#cata_component_qty_"+qty_id).val();
    var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
    var amount = (est_price * qty).toFixed(2); 
    //console.log(qty, est_price, amount); return false;
    //alert(est_price); return false;
    // var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');    
    // var ship_fee = ship_fee * qty;
    // $("#cata_ship_fee_"+qty_id).val('$ '+ship_fee);    
    var ebay_price = (amount * (8 / 100)).toFixed(2); 
    var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
    var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');


    $("#cata_amount_"+qty_id).val('$ '+amount);
    //console.log(qty, est_price, ebay_price, paypal_price); return false;
    $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
    $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
    var total = parseFloat(parseFloat(amount) - parseFloat(ebay_price) - parseFloat(paypal_price) - parseFloat(ship_fee)).toFixed(2);
    $("#cata_total_"+qty_id).html('$ '+total);

        var sumShip = 0;
        sumShip = parseFloat(sumShip);
        var currShip = 0; 
        $("input[class *= 'cata_ship_fee']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#cata_est_price_"+id).val() != 0.00){
            currShip = $("#cata_ship_fee_"+id).val();
            currShip = currShip.substring(1, currShip.length);
            sumShip += parseFloat(currShip);
          }
        });
        sumShip = sumShip.toFixed(2);
        $(".total_shipping").val('') ;
        $(".total_shipping").val('$'+sumShip);


        var sumAmount = 0;
        sumAmount = parseFloat(sumAmount);
        var currAmount = 0; 
        $("input[class *= 'cata_amount']").each(function(){
          var id = this.id.match(/\d+/);
          if($("#cata_est_price_"+id).val() != 0.00){
            currAmount = $("#cata_amount_"+id).val();
            currAmount = currAmount.substring(1, currAmount.length);
            sumAmount += parseFloat(currAmount);
          }
        });
        sumAmount = sumAmount.toFixed(2);
        $(".amounts").val('') ;
        $(".amounts").val('$'+sumAmount);  

    /////////////////////////////////////
  });

/*=========================================
=            On input quantity            =
=========================================*/

//$(".component_qty").on('input', function(){
   $(document).on('input','.component_qty',function(){  

    var qty_id = $(this).attr("rowid");
    //console.log(qty_id);
    var qty = $("#cata_component_qty_"+qty_id).val();  
    var ship_fee = $("#cata_ship_fee_"+qty_id).val();
    ship_fee = ship_fee.substring(1, ship_fee.length);           
    ship_fee = parseFloat(3.25) * parseFloat(qty);
    //console.log(ship_fee); 
    $("#cata_ship_fee_"+qty_id).val('$ '+ship_fee);     
});  

/*=====  End of On input quantity  ======*/

/*=========================================
=            On input quantity            =
=========================================*/

$(".newPerc").on('input', function(){

/*========Estimate Profit start ======*/
    var newPerc = parseFloat($("#newPerc").val());
    if(isNaN(newPerc)){
      newPerc = 0.00;
    }

    var total_amount = $("#total_amount").val();
    total_amount = total_amount.substring(1, total_amount.length);
    total_amount = parseFloat(total_amount);
    var perc_amnt = total_amount;
    perc_amnt = (parseFloat(perc_amnt)/100) * parseFloat(newPerc);
    //var final_price = parseFloat(total_amount) - parseFloat(perc_amnt);
    esitmate_profit = perc_amnt.toFixed(2);

    $(".percentageAmount").val('$ '+esitmate_profit);
    var net_sale = $("#totalClass").val();
    net_sale = net_sale.substring(1, net_sale.length);
    var est_prof = $("#percentageAmount").val();
    est_prof = est_prof.substring(1, est_prof.length);
    //console.log(est_prof);
    var offer_amount = parseFloat(net_sale) - parseFloat(est_prof);
    $(".offerAmount").val('$ '+offer_amount.toFixed(2)); 
    //console.log(offer_amount);

    /*========Estimate Profit end ======*/
});  

/*=====  End of On input quantity  ======*/

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

/*==============================================================
=                ON CHANGE ESTIMATE CONDITION                  =
================================================================*/
//   $('body').on('change', '.estimate_condition', function(){
//     var est_id               = $(this).attr("id");
//     var condition_id         = $(this).val();
//     var qty_id               = $(this).attr("rd");
//     var kitmpn_id            = $(this).attr("ctmt_id");
//   //alert(qty_id); return false;
//   $(".loader").show();
//   $.ajax({
//     url:'<?php //echo base_url(); ?>catalogueToCash/c_purchasing/get_cond_base_price',
//     type:'post',
//     dataType:'json',
//     data:{'condition_id':condition_id, 'kitmpn_id':kitmpn_id},
//     success:function(data){
//        $(".loader").hide();
//       if(data.length == 1){
//         $("#cata_avg_price_"+ qty_id).val('$'+parseFloat(data[0].AVG_PRICE).toFixed(2));
//         $("#cata_est_price_"+ qty_id).val(parseFloat(data[0].AVG_PRICE).toFixed(2));
//         ///////////////////////////////////
//         var qty = $("#cata_component_qty_"+qty_id).val();
//         var est_price = $("#cata_est_price_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
//         var amount = (est_price * qty).toFixed(2); 
//         //console.log(qty, est_price, amount); return false;
//         //alert(est_price); return false;
//         var ebay_price = (amount * (8 / 100)).toFixed(2); 
//         var paypal_price = (amount  * (2.5 / 100)).toFixed(2);
//         var ship_fee = $("#cata_ship_fee_"+qty_id).val().replace(/\$/g, '').replace(/\ /g, '');
//         $("#cata_amount_"+qty_id).val('$ '+amount);
//         //console.log(qty, est_price, ebay_price, paypal_price); return false;
//         $("#cata_ebay_fee_"+qty_id).val('$ '+ebay_price);
//         $("#cata_paypal_fee_"+qty_id).val('$ '+paypal_price);
//         var total = parseFloat(parseFloat(est_price) + parseFloat(ebay_price) + parseFloat(paypal_price) + parseFloat(ship_fee)).toFixed(2);
//         $("#cata_total_"+qty_id).html('$ '+total);
//         /////////////////////////////////////      
//             }else if(data.length == 0){
//               $("#cata_avg_price_"+ qty_id).val('$0.00');
//               $("#cata_est_price_"+ qty_id).val('0.00');
//               ///////////////////////////////////
//               $("#cata_amount_"+qty_id).val('$0.00');
//               //console.log(qty, est_price, ebay_price, paypal_price); return false;
//               $("#cata_ebay_fee_"+qty_id).val('$0.00');
//               $("#cata_paypal_fee_"+qty_id).val('$0.00');
//               $("#cata_total_"+qty_id).html('$0.00');
//               /////////////////////////////////////
//             }
        
        
      
//     },
//      complete: function(data){
//       $(".loader").hide();
//     },
//       error: function(jqXHR, textStatus, errorThrown){
//          $(".loader").hide();
//         if (jqXHR.status){
//           alert(jqXHR.status+': '+errorThrown+", Please contact to your Administrator.");
//         }
//     }
//   });
// });

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

/*==============================================
=            search components call            =
==============================================*/
 var dataTable = '';
  $("#search_upc").on('click',function(){
    var input_upc = $("#input_upc").val();
    var input_brand = $("#input_brand").val();

    if(input_upc == ''){
        alert('Warning! upc is Required.');
        $("#input_upc").focus();
        return false;
    }
    //console.log(data_source,data_status);return false;
   
if(dataTable !=''){
      dataTable.destroy();
    }
  dataTable = $('#search_component_upc').DataTable({  
      "oLanguage": {
      "sInfo": "Total Records: _TOTAL_",
      //"sPaginationType": "full_numbers",
      
    },
    // For stop ordering on a specific column
    // "columnDefs": [ { "orderable": false, "targets": [0] }],
    // "pageLength": 5,
       "iDisplayLength": 25,
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
        data:{'input_upc':input_upc,'input_brand':input_brand},
        url :"<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/search_upc", // json datasource
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
  //var cata_id         = '<?php //$this->uri->segment(4); ?>';
  //var mpn_id          = '<?php //$this->uri->segment(5); ?>';
  //var cat_id          = '<?php //$this->uri->segment(6); ?>';

  var partCatalogueId = this.id;
  var index           = $(this).attr("name"); 
  var disableBtn      = $(this).attr("mid"); 
  var condition_id    = $(this).attr("cid"); 
  var comp_mpn_id     = $(this).attr("mpn_id"); 
  var cata_id         = $("#ct_cata_id").val(); 
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

  if(ddObjectId == undefined || ddObjectId == 0){ // unverfied data object dropdown
      // unverfied data object input
        alert('Warning! First fetch object.');
        return false;
    }
  //console.log(inputText); return false;
  //console.log(ddObjectName);return false;
  $(".loader").show();
  $.ajax({
        data:{
              'partCatalogueId':partCatalogueId,
              'catalogueId':catalogueId,
              'objectName':objectName,
              'objectInput':objectInput,
              'mpnDesc':mpnDesc,
              'categoryId':categoryId,
              'component_mpn':component_mpn,
              'input_upc':input_upc,
              'ddObjectId':ddObjectId,
              'cata_id':cata_id,
              'condition_id':condition_id,
              'comp_mpn_id':comp_mpn_id,
              'inputText':inputText
            },
        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/addtokit", // json datasource
        type: "post" ,
        dataType: 'json',

         success : function(data){
          ///console.log(data); return false;
          $(".loader").hide();
          if(data.flag == 1){
            alert('Success! Component addded to kit');
            if (data.result.length > 0 ) {
              //////////////////////////
           var url1 = 'https://www.ebay.com/sch/';
           var cat_name = $("#category_name").val();
           cat_name = cat_name.replace(' ','-');
           cat_name = cat_name.replace('&','-');
           cat_name = cat_name.replace('/','-');
           var cat_id = $("#category_id").val();
           var url2 = cat_name+'/'+cat_id+'/';
           var url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='+condition_id;
           if(data.result[0].KEYWORD != ''){
            var url4 = '&_nkw='+data.result[0].KEYWORD;
           }else{
            var url4 = '&_nkw='+data.result[0].MPN;
           }
           
           //var url5 = '&LH_Complete=1&LH_Sold=1';
           var final_url = url1+url2+url3+url4; //+url5;
            /*=====  End of creating history URL  ======*/
            ////////////////////////////////////
             var row_id           = data.totals;
             var upc = data.result[0].UPC;
              if(upc === null || upc === undefined){
                upc = '';              
              } 

              var mpn_description = data.result[0].MPN_DESCRIPTION;
              if(mpn_description === null || mpn_description === undefined){
                mpn_description = '';              
              }
               
               var alertMsg   = "return confirm('Are you sure to delete?');";
               //var delete_comp = '<?php //echo base_url(); ?>catalogueToCash/c_purchasing/cp_delete_component/'+cata_id+'/'+mpn_id+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
                 var mpns = [];
                   // alert(data.length);return false;
                  for(var i = 0;i<data.conditions.length; i++){
                    if (data.result[0].CONDITION_ID == data.conditions[i].ID){
                        var selected = "selected";
                      }else {
                          var selected = "";
                      }
                    mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>');
                  }

                 var quantity       = data.result[0].QTY;
                 //var est_price       = data.result[0].PRICE;
                 var est_price       = data.result[0].EST_SELL_PRICE;
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
                   var mpn_description = data.result[0].MPN_DESCRIPTION.replace(/[<>'"]/g, function(m) {
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
                        table.row.add( $('<tr> <td><button title="Delete Component" id="'+data.result[0].LZ_ESTIMATE_DET_ID+'" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button style="margin-left: 5px;" title="Add Keyword" rd="'+row_id+'" cat="'+data.result[0].CATEGORY_ID+'" mpn="'+data.result[0].MPN+'" class="btn btn-info btn-xs glyphicon glyphicon-pencil Keywords"  data-target="#addKeyword" cta_mpn_id="'+data.result[0].PART_CATLG_MT_ID+'"></button><button style="margin-left: 5px;" title="Pull Sold Price" rd="'+row_id+'" cat="'+data.result[0].CATEGORY_ID+'" mpn="'+data.result[0].MPN+'" condition="'+data.result[0].TECH_COND_ID+'" id="get_sold_price" class="btn btn-success btn-xs glyphicon glyphicon-magnet get_sold_price"  data-target="#addKeyword"> </button></td><td><div id="singlePic_'+row_id+'">NOT FOUND</div></td> <td>'+data.result[0].OBJECT_NAME+' </td> <td><div  style="" title="Search this MPN on eBay"><a style="" href="'+final_url+'" target= "_blank" >'+data.result[0].MPN+'</a></div></td><td><div  style="" title="UPC">'+upc+'</div></td><td><input style="width: 300px;" type="text" class="form-control mpn_description" name="mpn_description" id="mpn_description_'+row_id+'" maxlength="80" title="'+mpn_description+'" value="'+mpn_description+'"><input type="hidden" class="b_part_catlg_mt_id" name="b_part_catlg_mt_id" id="b_part_catlg_mt_id_'+row_id+'" value="'+data.result[0].PART_CATLG_MT_ID+'"</td><td> <input type="hidden" class="lz_estimate_det_id" name="lz_estimate_det_id" id="lz_estimate_det_id" value="'+data.result[0].LZ_ESTIMATE_DET_ID+'"> <div class="form-group" style="width: 130px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].PART_CATLG_MT_ID+'" rd = "'+row_id+'" style="width: 130px;">'+mpns.join("")+'</select> </div> </td> <td><div class="form-group" style="width:70px;"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="1" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$ 0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_'+row_id+'" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" > </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$ 0.00</p></td></tr>')).draw();
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
=            add to kit            =
==================================*/
$(document).on('click','.addUpcTokit', function(){
  //var cata_id         = '<?php //$this->uri->segment(4); ?>';
  //var mpn_id          = '<?php //$this->uri->segment(5); ?>';
  //var cat_id          = '<?php //$this->uri->segment(6); ?>';

  var partCatalogueId = this.id;
  var index           = $(this).attr("name"); 
  var disableBtn      = $(this).attr("mid"); 
  var condition_id    = $(this).attr("cid"); 
  //var comp_mpn_id     = $(this).attr("mpn_id"); 
  var cata_id         = $("#ct_cata_id").val(); 
  $("#"+disableBtn+"").prop('disabled',true);
  //var avg_price       = $(this).attr("avg");
  //console.log(index, avg_price);
  var objectName      = $('#object_name_'+index).val();
  var catalogueId     = $('#ct_catlogue_mt_id').val();
  var objectInput     = $('#object_name').val();
  //var inputText       = $('#search_component_table tr').eq(index).find('td').eq(4).find('input').val();
  var input_upc       = $(this).attr("upc"); 
  var component_mpn   = $('#search_component_table tr').eq(index).find('td').eq(4).text();
  var mpnDesc         = $('#search_component_upc tr').eq(index).find('td').eq(3).find('input').val();
  var ddObjectId      = $('#search_component_upc tr').eq(index).find('td').eq(1).find('.objectIs').val();
   var ddObjectName = $('#search_component_upc tr').eq(index).find('td').eq(1).text();
  var categoryId      = $('#search_component_upc tr').eq(index).find('td').eq(2).text();

  //console.log(input_upc, component_mpn, mpnDesc, ddObjectName, categoryId, ddObjectId); return false;
  //console.log(ddObjectName);return false;
  $(".loader").show();
  $.ajax({
        data:{
              'partCatalogueId':partCatalogueId,
              'catalogueId':catalogueId,
              'objectName':objectName,
              'objectInput':objectInput,
              'mpnDesc':mpnDesc,
              'categoryId':categoryId,
              'component_mpn':component_mpn,
              'input_upc':input_upc,
              'ddObjectId':ddObjectId,
              'cata_id':cata_id,
              'condition_id':condition_id,
            },
        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/addUpcTokit", // json datasource
        type: "post" ,
        dataType: 'json',

         success : function(data){
          ///console.log(data); return false;
          $(".loader").hide();
          if(data.flag == 1){
            alert('Success! Component addded to kit');
            if (data.result.length > 0 ) {
              //////////////////////////
           var url1 = 'https://www.ebay.com/sch/';
           var cat_name = $("#category_name").val();
           cat_name = cat_name.replace(' ','-');
           cat_name = cat_name.replace('&','-');
           cat_name = cat_name.replace('/','-');
           var cat_id = $("#category_id").val();
           var url2 = cat_name+'/'+cat_id+'/';
           var url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='+condition_id;
           if(data.result[0].KEYWORD != ''){
            var url4 = '&_nkw='+data.result[0].KEYWORD;
           }else{
            var url4 = '&_nkw='+data.result[0].MPN;
           }
           
           //var url5 = '&LH_Complete=1&LH_Sold=1';
           var final_url = url1+url2+url3+url4; //+url5;
            /*=====  End of creating history URL  ======*/
            ////////////////////////////////////
             var row_id           = data.totals;
             var upc = data.result[0].UPC;
              if(upc === null || upc === undefined){
                upc = '';              
              } 

              var mpn_description = data.result[0].MPN_DESCRIPTION;
              if(mpn_description === null || mpn_description === undefined){
                mpn_description = '';              
              }
               
               var alertMsg   = "return confirm('Are you sure to delete?');";
               //var delete_comp = '<?php //echo base_url(); ?>catalogueToCash/c_purchasing/cp_delete_component/'+cata_id+'/'+mpn_id+'/'+cata_id+'/'+data.result[0].MPN_KIT_MT_ID+'/'+data.result[0].PART_CATLG_MT_ID;
                 var mpns = [];
                   // alert(data.length);return false;
                  for(var i = 0;i<data.conditions.length; i++){
                    if (data.result[0].CONDITION_ID == data.conditions[i].ID){
                        var selected = "selected";
                      }else {
                          var selected = "";
                      }
                    mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>');
                  }

                 var quantity       = data.result[0].QTY;
                 //var est_price       = data.result[0].PRICE;
                 var est_price       = data.result[0].EST_SELL_PRICE;
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
                   var mpn_description = data.result[0].MPN_DESCRIPTION.replace(/[<>'"]/g, function(m) {
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
                        table.row.add( $('<tr> <td><button title="Delete Component" id="'+data.result[0].LZ_ESTIMATE_DET_ID+'" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button style="margin-left: 5px;" title="Add Keyword" rd="'+row_id+'" cat="'+data.result[0].CATEGORY_ID+'" mpn="'+data.result[0].MPN+'" class="btn btn-info btn-xs glyphicon glyphicon-pencil Keywords"  data-target="#addKeyword" cta_mpn_id="'+data.result[0].PART_CATLG_MT_ID+'"></button><button style="margin-left: 5px;" title="Pull Sold Price" rd="'+row_id+'" cat="'+data.result[0].CATEGORY_ID+'" mpn="'+data.result[0].MPN+'" condition="'+data.result[0].TECH_COND_ID+'" id="get_sold_price" class="btn btn-success btn-xs glyphicon glyphicon-magnet get_sold_price"  data-target="#addKeyword"> </button></td><td><div id="singlePic_'+row_id+'">NOT FOUND</div></td> <td>'+data.result[0].OBJECT_NAME+' </td> <td><div  style="" title="Search this MPN on eBay"><a style="" href="'+final_url+'" target= "_blank" >'+data.result[0].MPN+'</a></div></td><td><div  style="" title="UPC">'+upc+'</div></td><td><input style="width: 300px;" type="text" class="form-control mpn_description" name="mpn_description" id="mpn_description_'+row_id+'" maxlength="80" title="'+mpn_description+'" value="'+mpn_description+'"><input type="hidden" class="b_part_catlg_mt_id" name="b_part_catlg_mt_id" id="b_part_catlg_mt_id_'+row_id+'" value="'+data.result[0].b_part_catlg_mt_id+'"</td><td> <input type="hidden" class="lz_estimate_det_id" name="lz_estimate_det_id" id="lz_estimate_det_id" value="'+data.result[0].LZ_ESTIMATE_DET_ID+'"> <div class="form-group" style="width: 130px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result[0].b_part_catlg_mt_id+'" rd = "'+row_id+'" style="width: 130px;">'+mpns.join("")+'</select> </div> </td> <td><div class="form-group" style="width:70px;"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="1" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$ 0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+est_price+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_'+row_id+'" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" > </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$ 0.00</p></td></tr>')).draw();
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

});
/*=====  End of fetch object  ======*/

/*==========================================
=            Title text counter            =
==========================================*/
  function countChar(val) {
    var len = val.value.length;
    if (len >= 80) {
      val.value = val.value.substring(0, 80);
    } else {
      $('#charNum').text(80 - len);
    }
  }



  // function countCharDesc(val) {
  
  //   var row_id = val.abc;
  //   console.log(row_id, val);  
  //   //var rowindex = $(this).attr("rowIndex");
  //   //var rowindex = document.getElementById(val).getAttribute("rowIndex");
  //   //console.log(rowindex); return false;   
  //   var len = val.value.length;
  //   if (len >= 80) {
  //     val.value = val.value.substring(0, 80);
  //   } else {
  //     $('#'+row_id).text(80 - len);
  //   }
  // }
    
//   function textCounter(field,cnt, maxlimit) {         
//   var cntfield = document.getElementById(cnt) 
//      if (field.value.length > maxlimit) // if too long...trim it!
//     field.value = field.value.substring(0, maxlimit);
//     // otherwise, update 'characters left' counter
//     else
//     cntfield.value = maxlimit - field.value.length;
// }

/*=====  End of Title text counter  ======*/
/*============================================================================
=        On change of MPN Dropdown show mpn pictures section start       =
==============================================================================*/
$(document).on('change','#comp_mpn',function(){

  var condition = "<?php echo $condition_name;?>";
  var mpn = $("#comp_mpn option:selected").text();
  var mpn_value = $("#comp_mpn").val();
  //console.log(mpn_value); return false;
  //var mpn_upc=$("#get_upc").val();
  var res_mpn = mpn.split("~", 1);
  res_mpn = $.trim(res_mpn[0]);
  //console.log(mpn_value,res_mpn);
  //return false;
 
 $(".loader").show();
  $.ajax({
        
        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/fetchMpnImages", // json datasource
        type: "post" ,
        dataType: 'json',
        data:{'res_mpn':res_mpn, 'condition':condition, 'mpn_value':mpn_value},
        success : function(data){
          //console.log(data.master_pics);return false;
          // if(data){
            if(data.master_pics != 0){
              $('#picsList').html("");
              //$('#picSec').html("");              
            //console.log(data);
              var dirPics = [];
              // $('#sortable').html("");
              // console.log('length:'+data.master_pics.length+'');
              $("#picSec").addClass("imgSec");
              for(var i=0;i<data.master_pics.length;i++){
                values = data.uri[i].split("/");
             
                one = values[4].substring(1);

                //console.log(one);//return false;
                var picture = data.master_pics[i]; 
                // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
                var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="master_pics[]" src="data:image;base64,'+picture+'"/>';
                dirPics.push('<li id="'+values[4]+'" style="float: left; width: 200px; display: inline-block; margin-right: 15px;"> <span class="tg-li"> <div class="thumb imgCls" style="width:200px !important; height:200px !important; display: block; border: 1px solid rgb(55, 152, 198);">'+img+' </div> </span></li>'); 
              }

              //$('#picsList').html("");
              $('#picsList').append(dirPics.join(""));

              // $('.zoom_01').elevateZoom();
              $('.zoom_01').elevateZoom({
                //zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 600,
                zoomWindowFadeOut: 600,
                easing : true,
                scrollZoom : true
               });            
              $('.loader').hide();
            }else{
              $('.loader').hide();
              $('#picsList').html("");
              $('#picSec').html("");            
              $("#picSec").html('<div style="font-size:16px; font-weight:600;color:red; padding:10px;">Pictures Not Found.</div>');
              setTimeout(function(){ $("#picSec").text('');}, 3000);               
            }  
            if(data.getMpn[0].UPC!== null){
              // $('#comp_upc').val("");
              $('#get_upc').val(data.getMpn[0].UPC);
            }else{
               $('#get_upc').val("");
            }
          // }else{
          //   $('.loader').hide();
          //   $('#picsList').html("");
          //   $('#picSec').html("");            
          //   $("#picSec").html('<div style="font-size:16px; font-weight:600;color:red; padding:10px;">Pictures Not Found.</div>');
          //   setTimeout(function(){ $("#picSec").text('');}, 3000);
          // }
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

/*=====  End On change of MPN Dropdown show mpn pictures section start  ======*/
/*===== Upload Image section start =====*/
$(document).ready(function(){
$("#drop-img-area").on('dragenter', function (e){
    e.preventDefault();
  });

  $("#drop-img-area").on('dragover', function (e){
    e.preventDefault();
  });

  $("#drop-img-area").on('drop', function (e){
    e.preventDefault();
    var upload_image = e.originalEvent.dataTransfer.files;
    //console.log(upload_image);
    createFormData(upload_image);
  });

  $("#btnupload_img").click(function(){
    $("#upload_image").trigger("click");
  });

  $("#upload_image").change(function(){
    var postData = new FormData($("#picFormUpload")[0]);
    //console.log(postData);
    uploadImagesfromLotscreen(postData);
  });

  function createFormData(upload_image) {

    var len = upload_image.length;
    var formImage = new FormData();
    if(len === 1){
      formImage.append('upload_image[]', upload_image[0]);
    }else{
      for(var i=0; i<len; i++){
        formImage.append('upload_image[]', upload_image[i]);
      }
    }    
    uploadImagesfromLotscreen(formImage);

  }

 function uploadImagesfromLotscreen(formData) {
  var pic_mpn = $('#pic_mpn').val();
  var pic_upc = $('#pic_upc').val();
  var pic_condition = $('#pic_condition option:selected').text();
  if(pic_mpn == null || pic_mpn == ""){
    alert("Please fill the MPN field.");
    return false;
  }
  formData.append('pic_mpn',pic_mpn);
  formData.append('pic_upc',pic_upc);
  formData.append('pic_condition',pic_condition);
  //console.log(pic_mpn, pic_upc, pic_condition); return false;

    $('.loader').show();
    $.ajax({
      url: '<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/uploadImages',
      data: formData,
      type: 'POST',
      datatype : "json",
      processData: false,
      contentType: false,
      cache: false,
      success: function(data) {
        $('.loader').hide();
        if(data == 1){
          $('#pic_mpn').val('');
          $('#pic_upc').val('');
          $('#pic_condition').val('');          
          $('#upload_message').append('<div class="alert alert-success alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Success!</strong> Pictures Uploaded Successfully!</div>');
          setTimeout(function(){$('#upload_message').html("");},1000);
          $('#pic_mpn').val();
          $('#pic_upc').val();
          $('#pic_condition').val();
        }else{
          $('.loader').hide();
          $('#upload_message').append('<div class="alert alert-warning alert-dismissable"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <strong>Error!</strong> Pictures not uploaded!</div>');
          setTimeout(function(){$('#upload_message').html("");},1000);        
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

/*===== Upload Image section end =====*/
/*==============================================
=  fetch object on blur of category input     =
==============================================*/
$(document).on('blur','#cat_id_obj',function(){  

  var cat_id_obj = $("#cat_id_obj").val();
  if(cat_id_obj == null || cat_id_obj == ""){
    alert("Please input category id."); return false;
  }
  //console.log(cat_id_obj); return false;

 $(".loader").show();
  $.ajax({
        data:{'cat_id_obj':cat_id_obj},
        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/fetchObjectOnblurCategory", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          $(".loader").hide();
          //console.log(data); //return false;
          if(data != ''){
            var objects = [];
             // alert(data.length);return false;
            for(var i = 0;i<data.length;i++){
              objects.push('<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>')
            }
            $('#catwiseObj').html("");
            $('#catObjWiseMPN').html("");
            $('#catwiseObj').append('<label>Objects:</label><select name="cat_comp_obj" id="cat_comp_obj" class="form-control cat_comp_obj selectpicker" data-live-search="true" ><option value="0">---select---</option>'+objects.join("")+'</select>');
            $('.cat_comp_obj').selectpicker();
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

/*=====  End of fetch object on blur of category input  ======*/
/*==============================================
=  Start fetch MPN on Click of object dropdown     =
==============================================*/
$(document).on('change','#cat_comp_obj',function(){  

  var cat_comp_obj = $("#cat_comp_obj").val();
  var cat_id_obj = $("#cat_id_obj").val();
  if(cat_comp_obj == null || cat_comp_obj == "" || cat_comp_obj == 0){
    alert("Please select object."); return false;
  }else if(cat_id_obj == null || cat_id_obj == ""){
    alert("Please input category id."); return false;
  }
  //console.log(cat_id_obj); return false;

 $(".loader").show();
  $.ajax({
        data:{'cat_comp_obj':cat_comp_obj,'cat_id_obj':cat_id_obj},
        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/fetchMPNonClickObject", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
          $(".loader").hide();
          //console.log(data); //return false;
          if(data != ''){
            var mpns = [];
             // alert(data.length);return false;
            for(var i = 0;i<data.length;i++){

            var upc = data[i].UPC;
            if(upc === null || upc === undefined){
              upc = "";
            }else{
              upc = ' (UPC - '+upc+')';
            }

              mpns.push('<option value="'+data[i].CATALOGUE_MT_ID+'">'+data[i].MPN+upc+' ~ '+data[i].MPN_DESCRIPTION+'</option>')
            }
            $('#catMPNbtn').html("");
            $('#catObjWiseMPN').html("");
            $('#catObjWiseMPN').append('<label>MPN:</label><select name="cat_comp_mpn" id="cat_comp_mpn" class="form-control cat_comp_mpn selectpicker" data-live-search="true" required><option value="0">---select---</option>'+mpns.join("")+'</select>');
             $('#catObjWiseUPC').html("");
            $('#catObjWiseUPC').append('<label>UPC:</label><input class="form-control" type="text" name="get_catupc" id="get_catupc"/>');
            $('#catMPNbtn').append('<input type="button" id="save_catwise_MPN" name="save_catwise_MPN" value="Save" class="btn btn-success">');
            $('.cat_comp_mpn').selectpicker();
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

/*=====  End of fetch MPN on Click of object dropdown  ======*/
 
 /*==============================================
=  Start fetch UPC on Click of MPN dropdown     =
==============================================*/ 
$(document).on('change','#cat_comp_mpn',function(){  
  var cat_comp_mpn = $("#cat_comp_mpn").val();
  //console.log(cat_comp_mpn); return false;
 $(".loader").show();
  $.ajax({
        data:{'cat_comp_mpn':cat_comp_mpn},
        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/fetchMpnUPC", // json datasource
        type: "post" ,
        dataType: 'json',

        success : function(data){
       //console.log(data);

            if(data){
              $('#get_catupc').val(data.get_Mpn[0].UPC);
            }

            else{
               $('#get_catupc').val("");
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
/*=====  End of fetch UPC on Click of MPN dropdown  ======*/

  /*==============================================================
  =            Save MPN to catalogue and Lot Estimate          =
  ================================================================*/

$(document).on('click','#save_catwise_MPN',function(){  
  //console.log(row_id);
    var url='<?php echo base_url(); ?>itemsToEstimate/c_itemsToEstimate/addlotToEstimateCatWise';
    var comp_mpn = $("#cat_comp_mpn").val();
    var comp_text = $("#cat_comp_mpn option:selected").text();
    var comp_object = $("#cat_comp_obj option:selected").text();

    var get_catupc = $("#get_catupc").val();
    var ct_cata_id = $("#ct_cata_id").val();

    var condition_id = "<?php echo $cond_id; ?>";
    //console.log(condition_id);return false;

    if(comp_mpn == 0 || comp_mpn == null){
      alert("Please select MPN.");
      return false;
    }

    $(".loader").show();
    $.ajax({
    url:url,
    type: 'POST',
    data: {
      'ct_cata_id': ct_cata_id,
      'comp_mpn' : comp_mpn,
      'condition_id':condition_id,
      'get_catupc':get_catupc,
      'comp_text':comp_text,
      'comp_object':comp_object
    },
    dataType: 'json',
    success: function (data){
      //console.log(data.result.estimate[0].EST_SELL_PRICE);
      if(data){
        
        $(".loader").hide();
        //$('#comp_mpn').find('option:first').attr('selected', 'selected');
        $('#cat_comp_mpn').val(0);
        $("#cat_comp_mpn").selectpicker("refresh");
        $('#get_catupc').val('');

          var mpns = [];
          var condition_id = "<?php echo $cond_id; ?>";

          for(var i = 0;i<data.conditions.length; i++){
            if (condition_id == data.conditions[i].ID){
              var selected = "selected";
            }else {
              var selected = "";
            }

            mpns.push('<option value="'+data.conditions[i].ID+'" '+selected+'>'+data.conditions[i].COND_NAME+'</option>')
          }
          var estimate_price = data.result.estimate;
          if(estimate_price == 0){
            estimate_price = 0.00;
          }

          
          var table = $('#kit-components-table').DataTable();
            /*============================================
            =            creating history URL            =
            ============================================*/
           var url1 = 'https://www.ebay.com/sch/';
           var cat_name = $("#category_name").val();
           cat_name = cat_name.replace(' ','-');
           cat_name = cat_name.replace('&','-');
           cat_name = cat_name.replace('/','-');
           var cat_id = $("#category_id").val();
           var url2 = cat_name+'/'+cat_id+'/';
           var url3 = 'i.html?LH_BIN=1&_from=R40&_sop=12&LH_ItemCondition='+condition_id;
           if(data.result.detail[0].KEYWORD != ''){
            var url4 = '&_nkw='+data.result.detail[0].KEYWORD;
           }else{
            var url4 = '&_nkw='+data.result.detail[0].MPN;
           }
           
           //var url5 = '&LH_Complete=1&LH_Sold=1';
           var final_url = url1+url2+url3+url4; //+url5;
            /*=====  End of creating history URL  ======*/


          var upc = data.result.detail[0].UPC;
          if(upc === null || upc === undefined){
            upc = '';              
          } 

          var mpn_description = data.result.detail[0].MPN_DESCRIPTION;
          if(mpn_description === null || mpn_description === undefined){
            mpn_description = '';              
          } 

          var mpn_description = mpn_description.replace(/[<>'"]/g, function(m) {
                          return '&' + {
                            '\'': 'apos',
                            '"': 'quot',
                            '&': 'amp',
                            '<': 'lt',
                            '>': 'gt',
                          }[m] + ';';
                        });

          var row_id = table.page.info().recordsTotal +1;

          var est_price_name = 'cata_est_price_'+row_id;
          //console.log(row_id);
          table.row.add( $('<tr> <td><button title="Delete Component" id="'+data.result.detail[0].LZ_ESTIMATE_DET_ID+'" class="btn btn-danger btn-xs del_comp"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button><button style="margin-left: 5px;" title="Add Keyword" rd="'+row_id+'" cat="'+data.result.detail[0].CATEGORY_ID+'" mpn="'+data.result.detail[0].MPN+'" class="btn btn-info btn-xs glyphicon glyphicon-pencil Keywords"  data-target="#addKeyword" cta_mpn_id="'+data.result.detail[0].PART_CATLG_MT_ID+'"></button><button style="margin-left: 5px;" title="Pull Sold Price" rd="'+row_id+'" cat="'+data.result.detail[0].CATEGORY_ID+'" mpn="'+data.result.detail[0].MPN+'" condition="'+data.result.detail[0].TECH_COND_ID+'" id="get_sold_price" class="btn btn-success btn-xs glyphicon glyphicon-magnet get_sold_price"  data-target="#addKeyword"> </button></td><td><div id="singlePic_'+row_id+'"> </div></td> <td><div  style="" title="Search  MPN on eBay"><a style="" href="'+final_url+'" target= "_blank" >'+data.result.detail[0].OBJECT_NAME+'</a></div></td><td>'+data.result.detail[0].MPN+'</td><td><div  style="" title="UPC">'+upc+'</div></td><td><input style="width: 300px;" type="text" class="form-control mpn_description" name="mpn_description" id="mpn_description_'+row_id+'" maxlength="80" title="'+mpn_description+'" value="'+mpn_description+'"><input type="hidden" class="b_part_catlg_mt_id" name="b_part_catlg_mt_id" id="b_part_catlg_mt_id_'+row_id+'" value="'+data.result.detail[0].PART_CATLG_MT_ID+'"</td><td> <input type="hidden" class="lz_estimate_det_id" name="lz_estimate_det_id" id="lz_estimate_det_id" value="'+data.result.detail[0].LZ_ESTIMATE_DET_ID+'"> <div class="form-group" style="width: 130px;"> <select class="form-control estimate_condition" name="estimate_condition" id="estimate_condition_'+row_id+'" ctmt_id="'+data.result.detail[0].PART_CATLG_MT_ID+'" rd = "'+row_id+'" style="width: 130px;">'+mpns.join("")+'</select> </div> </td> <td><div class="form-group" style="width:70px;"> <input type="number" name="cata_component_qty_'+row_id+'" id="cata_component_qty_'+row_id+'" rowid="'+row_id+'" class="form-control input-sm component_qty" value="1" style="width:60px;"> </div> </td> <td><div class="form-group"> <input type="text" name="cata_avg_price_'+row_id+'" id="cata_avg_price_'+row_id+'" class="form-control input-sm cata_avg_price" value="$ 0.00" style="width:80px;" readonly> </div></td> <td><div class="form-group" style="width:80px;"> <input type="number" id="'+est_price_name+'" class="form-control input-sm cata_est_price" value="'+parseFloat(estimate_price).toFixed(2)+'" style="width:80px;"> </div></td> <td><div class="form-group" style="width:80px;"> <input type="text" name="cata_amount_'+row_id+'" id="cata_amount_'+row_id+'" class="form-control input-sm cata_amount" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_ebay_fee_'+row_id+'" id="cata_ebay_fee_'+row_id+'" class="form-control input-sm cata_ebay_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group" style="width:80px;"> <input type="text" name="cata_paypal_fee_'+row_id+'" id="cata_paypal_fee_'+row_id+'" class="form-control input-sm cata_paypal_fee" value="$ 0.00" style="width:80px;" readonly> </div></td><td><div class="form-group"> <input type="text" name="cata_ship_fee_'+row_id+'" id="cata_ship_fee_'+row_id+'" class="form-control input-sm cata_ship_fee" value="$ 3.25" style="width:80px;" > </div></td><td><p id="cata_total_'+row_id+'" class="totalRow">$ 0.00</p></td></tr>')).draw();
            /*=============================================
            =            Picture Section start            =
            =============================================*/

                //console.log(one);//return false;
            if(data.result.master_pics != 0){
              var picture = data.result.master_pics[0]; 
              // var img = '<img class="sort_img up-img zoom_01" id="'+data.uri[i]+'" name="" src="data:image;base64,'+data.cloudUrl[i]+'"/>';
              var img = '<div class="thumb imgCls" style="display: block; border: 1px solid rgb(55, 152, 198);"><img class="sort_img up-img zoom_01" id="" name="master_pics[]" src="data:image;base64,'+picture+'"/></div>';
                //dirPics.push(''+img+' </div>'); 
              // }

              //$('#picsList').html("");
              $("#singlePic_"+row_id).append(img);

              // $('.zoom_01').elevateZoom();
              $('.zoom_01').elevateZoom({
                //zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 600,
                zoomWindowFadeOut: 600,
                easing : true,
                scrollZoom : true
               });            
              $('.loader').hide();
            }else{
              $("#singlePic_"+row_id).html("NOT FOUND");
            }  

            /*=====  End of Picture Section  ======*/          
          
       
      $(".loader").hide();
      }else if(data == 2){
        alert("Error: Fail to create component! Try Again");
      }else if(data.check == 0){
        alert("Warning: Estimate is already exist!");
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
/*=============== END OF Save MPN to catalogue and Lot Estimate ===================*/
/*==============================================
=  Start getsold price function     =
==============================================*/ 
//var table = $('#kit-components-table').DataTable();
$(document).on('click','.get_sold_price',function(){ 
  $(this).removeClass("btn-success").addClass("btn-primary");
    var row_id            = $(this).attr("rd");
    var category_id        = $(this).attr("cat");
    var mpn           = $(this).attr("mpn");
    var catalogue_mt_id        = $("#part_catlg_mt_id_"+row_id).val(); 
    var condition_id      = $("#estimate_condition_"+row_id).val(); 

  console.log("category_id:"+category_id,"condition_id:"+condition_id); 
  //return false;
 $(".loader").show();
  $.ajax({

        url :"<?php echo base_url() ?>itemsToEstimate/c_itemsToEstimate/get_avg_sold_price", // json datasource
        type: "post" ,
        data: {
        'category_id': category_id,
        'mpn' : mpn,
        'condition_id':condition_id,
        'catalogue_mt_id':catalogue_mt_id
        },
        dataType: 'json',

        success : function(data){
       //console.log(data); 
       //return false;

    if(data.ack= 'Success' && data.resultCount > 0)
     {
        if(data.resultCount == 1)//if result is 1 than condition is changed so this check is neccessory
        {
          //$( "#sold_price_data" ).html("");
          
           var item = data['item'][0];
           var price = parseFloat(item['basicInfo']['convertedCurrentPrice']);
           //table.row(this_tr).find('cata_avg_price').val(price);
           $('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(price.toFixed(2));
           $('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(price.toFixed(2)).trigger('blur');//call blur function to calculate seling expense
       // }

        }
        if(data.resultCount > 1)
        {
          if(data.resultCount > 15){
            var loop = 15;
          }else{
            var loop = data.resultCount;
          }
          var sum_price = 0;
            for ( var i = 1; i <= loop; i++ ) 
            {
              //console.log(i-1);
             var item = data['item'][i-1];
              //var item = data['item'][0];
             var price = item['basicInfo']['convertedCurrentPrice'];
             sum_price = parseFloat(sum_price) + parseFloat(price) ;
            //console.log(i-1,price,sum_price);
            }
            var avg_price = parseFloat(sum_price) / parseFloat(loop) ;
            $('#kit-components-table tr').eq(row_id).find('td').eq(8).find('input').val(avg_price.toFixed(2));
           $('#kit-components-table tr').eq(row_id).find('td').eq(9).find('input').val(avg_price.toFixed(2)).trigger('blur');//call blur function to calculate seling expense



           // $("#someTextBox").focus();
           // $(".loader").trigger('blur');
        }
      $(".loader").hide();
    }else{
       $(".loader").hide();
        $("<div class='col-sm-12'><div class='box box-primary'><div class='box-header'><i class='fa fa-usd'></i><h3 class='box-title'>No Record Found.</h3><div class='box-tools pull-right'><button type='button' class='btn bg-teal btn-sm' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div>").appendTo("#sold_price_data");
        if(data == 'EXCEPTION'){
          alert("keyword not found");
        }else{
          alert("No result found on eBay");
        }
              
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
/*=====  End of getsold price function  ======*/
</script>