<?php $this->load->view('template/header');?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Template Form
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Template Form</li>
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
            <h3 class="box-title">Template Form</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
        <?php echo form_open('template/c_temp/update', 'role="form"'); ?>
        <div class="col-sm-6">
            <div class="form-group">
              <label for="inputTempName" class="control-label">Template Name:</label>
              
                <input type="text" class="form-control" id="temp_name" name="temp_name" value="<?php echo htmlentities($temp_name); ?>" placeholder="Template Name">
              </div>
            </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label for="inputTempName" class="control-label">Site ID:</label>
              
                <input type="number" class="form-control" id="site_id" name="site_id" value="<?php echo $site_id; ?>" readonly>
              </div>
            </div>
          
          <div class="col-sm-6">
            <div class="form-group">
              <label for="inputShipCountry" class="control-label">Ship From Country:</label>
              
                <input type="text" class="form-control" id="ship_country" name="ship_country" value="US">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputCurrancy" class="control-label">Currency:</label>
              
                <input type="text" class="form-control" id="currency" name="currency" value="<?php echo $currency; ?>">
              </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
              <label for="inputListType" class="control-label">Listing Type:</label>
              <select class="form-control" id="listing_type" name="listing_type" value="<?php echo $listing_type; ?>">
                    <option value="FixedPriceItem" <?php if($listing_type == 'FixedPriceItem' ){echo "selected='selected'";} ?>>Fixed Price</option>
                  <option value="Auction" <?php if($listing_type == 'Auction' ){echo "selected='selected'";} ?>>Auction</option>
                  </select>
                <!-- <input type="text" class="form-control" id="listing_type" name="listing_type" value="<?php //echo $listing_type; ?>" placeholder="Fixed Price"> -->
              </div>
            </div>
           <!--  <div class="col-sm-6">
            <div class="form-group">
              <label for="inputCat" class="control-label">Category ID:</label>
              
                <input type="number" class="form-control" id="cat_id" name="cat_id" value="<?php //echo $cat_id; ?>" placeholder="Category ID">
              </div>
            </div> -->
            <!-- <div class="col-sm-6">
            <div class="form-group">
              <label for="inputHtime" class="control-label">Handling Time (Days):</label>
              
                <input type="number" class="form-control" id="handling_time" name="handling_time" value="<?php //echo $handling_time; ?>" placeholder="Handling Time (Days)">
              </div>
            </div> -->
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputZip" class="control-label">Ship From (Zip Code):</label>
              
                <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php if(!empty (@$zip_code)) {echo $zip_code;} else{echo "75229";}; ?>" placeholder="Zip Code">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputShipLocation" class="control-label">Ship From Loaction:</label>
              
                <input type="text" class="form-control" id="ship_from" name="ship_from" value="<?php echo $ship_from; ?>" placeholder="Shipment Location">
              </div>
            </div>
        <!--     <div class="form-group">
              <label for="inputShiptoLocation" class="control-label">Ship to Location:</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="ship_to" name="ship_to" placeholder="Ship to Location">
              </div>
            </div> -->
<!--             <div class="col-sm-6">
            <div class="form-group">
              <label for="inputBidLength" class="control-label">Bid Length:</label>
              
                <input type="text" class="form-control" id="bid_length" name="bid_length" value="<?php //echo $bid_length; ?>" placeholder="Bid Length">
              </div>
            </div> -->
<!--             <div class="col-sm-6">
            <div class="form-group">
              <label for="inputCondition" class="control-label">Deafult Condition:</label>
               <select class="form-control" id="default_condition" name="default_condition" value="<?php //echo $default_condition; ?>">
                    
                  <option value="3000" <?php //if($default_condition == 3000 ){echo "selected='selected'";} ?>>Used</option>
                  <option value="1000" <?php //if($default_condition == 1000 ){echo "selected='selected'";} ?>>New</option>
                  <option value="1500" <?php //if($default_condition == 1500 ){echo "selected='selected'";} ?>>New other</option>
                  <option value="2000" <?php //if($default_condition == 2000 ){echo "selected='selected'";} ?>>Manufacturer refurbished</option>
                  <option value="2500" <?php //if($default_condition == 2500 ){echo "selected='selected'";} ?>>Seller refurbished</option>
                  <option value="4000" <?php //if($default_condition == 4000 ){echo "selected='selected'";} ?>>Very Good</option>
                  <option value="5000" <?php //if($default_condition == 5000 ){echo "selected='selected'";} ?>>Good</option>
                  <option value="6000" <?php //if($default_condition == 6000 ){echo "selected='selected'";} ?>>Acceptable</option>
                </select>
              </div>
            </div> -->
<!--             <div class="col-sm-6">
                <div class="form-group">
              <label for="inputCondDesc" class="control-label">Default Condition Description:</label>
              
                <input type="text" class="form-control" id="default_description" name="default_description" value="<?php //echo $default_description; ?>" placeholder="Default Condition Description">
              </div>
            </div> -->
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputPayMethod" class="control-label">Payment Method:</label>
              
                <input type="text" class="form-control" id="payment_method" name="payment_method" value="<?php echo $payment_method; ?>" placeholder="Paypal">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputEmail" class="control-label">Paypal Email Address:</label>
              
                <input type="text" class="form-control" id="paypal_email" name="paypal_email" value="<?php echo $paypal_email; ?>" placeholder="Paypal Email Address">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputDispatch" class="control-label">Dispatch Time Max:</label>
              
                <input type="number" class="form-control" id="dispatch_time" name="dispatch_time" value="<?php echo $dispatch_time; ?>" placeholder="Dispatch Time Max">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputShipService" class="control-label">Shipping Service:</label>
              
                  <select class="form-control" id="shipping_service" name="shipping_service" value="<?php echo @$row->SHIPPING_SERVICE; ?>">
                    <option value="USPSParcel" <?php if($shipping_service == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option>
                    <option value="USPSFirstClass" <?php if($shipping_service == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php if($shipping_service == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php if($shipping_service == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php if($shipping_service == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox <?php if($shipping_service == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php if($shipping_service == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox <?php if($shipping_service == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope <?php if($shipping_service == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>">USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope <?php if($shipping_service == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>">USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select>                 
               <!--  <input type="text" class="form-control" id="shipping_service" name="shipping_service" value="<?php //echo $shipping_service; ?>" placeholder="Shipping Service"> -->
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputShppingCost" class="control-label">Shpping Service Cost:</label>
              
                <input type="number" class="form-control" id="service_cost" name="service_cost" value="<?php echo $service_cost; ?>" placeholder="Shpping Service Cost">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputOtherCost" class="control-label">Shpping Service Additional Cost:</label>
              
                <input type="number" class="form-control" id="add_cost" name="add_cost" value="<?php echo $add_cost; ?>" placeholder="Shpping Service Additional Cost">
              </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
              <label for="inputReturn" class="control-label">Return Accepted Option:</label>
               <select class="form-control" id="return_accepted" name="return_accepted" value="<?php echo $accepted_option; ?>">
                     <option value="ReturnsAccepted" <?php if($accepted_option == 'ReturnsAccepted' ){echo "selected='selected'";} ?>>Yes</option>
                    <option value="ReturnsNotAccepted" <?php if($accepted_option == 'ReturnsNotAccepted' ){echo "selected='selected'";} ?>>No</option>
                  </select>
                <!-- <input type="text" class="form-control" id="accepted_option" name="accepted_option" value="<?php //echo $accepted_option; ?>" placeholder="Return Accepted Option"> -->
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputReturnWithin" class="control-label">Returns Within Option:</label>
              
                <input type="number" min="14" class="form-control" id="within_option" name="within_option" value="<?php echo $within_option; ?>" placeholder="Returns Within Option">
              </div>
            </div>
            <div class="col-sm-6">
            <div class="form-group">
              <label for="inputPaidBy" class="control-label">Shipping Cost Paid By:</label>
              <select class="form-control" id="cost_paidby" name="cost_paidby" value="<?php echo @$row->SHIPPING_PAID_BY; ?>">
                     <option value="Buyer" <?php if($cost_paidby == 'Buyer' ){echo "selected='selected'";} ?>>Buyer</option>
                    <option value="Seller" <?php if($cost_paidby == 'Seller' ){echo "selected='selected'";} ?>>Seller</option>
                  </select>
                <!-- <input type="text" class="form-control" id="cost_paidby" name="cost_paidby" value="<?php //echo $cost_paidby; ?>" placeholder="Shipping Cost Paid By"> -->
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-12 buttn_submit">
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <input type="submit" name="mit" title="Update Template" class="btn btn-success" value="Update">
                <button type="button" title="Go Back" onclick="location.href='<?php echo site_url('template/c_temp') ?>'" class="btn btn-primary">Back</button>
              </div>  
          </div>
        </form>
        <?php echo form_close(); ?>
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


<?php $this->load->view('template/footer');?>


