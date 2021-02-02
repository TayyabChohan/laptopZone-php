<?php $this->load->view('template/header');?>

<?php echo form_open('ccrud/update', 'role="form"'); ?>
    <div class="form-group">
      <label for="inputTempName" class="col-lg-2 control-label">Template Name:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="temp_name" name="temp_name" value="<?php echo $temp_name; ?>" placeholder="Template Name">
      </div>
    </div>

    <div class="form-group">
      <label for="inputShipCountry" class="col-lg-2 control-label">Ship From Country:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="ship_country" name="ship_country" value="<?php echo $ship_country; ?>" placeholder="US">
      </div>
    </div>
    <div class="form-group">
      <label for="inputCurrancy" class="col-lg-2 control-label">Currency:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="currency" name="currency" value="<?php echo $currency; ?>" placeholder="US $">
      </div>
    </div>
        <div class="form-group">
      <label for="inputListType" class="col-lg-2 control-label">Listing Type:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="listing_type" name="listing_type" value="<?php echo $listing_type; ?>" placeholder="Fixed Price">
      </div>
    </div>
    <div class="form-group">
      <label for="inputCat" class="col-lg-2 control-label">Category ID:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="cat_id" name="cat_id" value="<?php echo $cat_id; ?>" placeholder="Category ID">
      </div>
    </div>
    <div class="form-group">
      <label for="inputHtime" class="col-lg-2 control-label">Handling Time (Days):</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="handling_time" name="handling_time" value="<?php echo $handling_time; ?>" placeholder="Handling Time (Days)">
      </div>
    </div>
    <div class="form-group">
      <label for="inputZip" class="col-lg-2 control-label">Ship From (Zip Code):</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="zip_code" name="zip_code" value="<?php echo $zip_code; ?>" placeholder="Zip Code">
      </div>
    </div>
    <div class="form-group">
      <label for="inputShipLocation" class="col-lg-2 control-label">Ship From Loaction:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="ship_from" name="ship_from" value="<?php echo $ship_from; ?>" placeholder="Shipment Location">
      </div>
    </div>
<!--     <div class="form-group">
      <label for="inputShiptoLocation" class="col-lg-2 control-label">Ship to Location:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="ship_to" name="ship_to" placeholder="Ship to Location">
      </div>
    </div> -->
    <div class="form-group">
      <label for="inputBidLength" class="col-lg-2 control-label">Bid Length:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="bid_length" name="bid_length" value="<?php echo $bid_length; ?>" placeholder="Bid Length">
      </div>
    </div>
    <div class="form-group">
      <label for="inputCondition" class="col-lg-2 control-label">Deafult Condition:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="default_condition" name="default_condition" value="<?php echo $default_condition; ?>" placeholder="Deafult Condition">
      </div>
    </div>
        <div class="form-group">
      <label for="inputCondDesc" class="col-lg-2 control-label">Default Condition Description:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="default_description" name="default_description" value="<?php echo $default_description; ?>" placeholder="Default Condition Description">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPayMethod" class="col-lg-2 control-label">Payment Method:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="payment_method" name="payment_method" value="<?php echo $payment_method; ?>" placeholder="Paypal">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Paypal Email Address:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="paypal_email" name="paypal_email" value="<?php echo $paypal_email; ?>" placeholder="Paypal Email Address">
      </div>
    </div>
    <div class="form-group">
      <label for="inputDispatch" class="col-lg-2 control-label">Dispatch Time Max:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="dispatch_time" name="dispatch_time" value="<?php echo $dispatch_time; ?>" placeholder="Dispatch Time Max">
      </div>
    </div>
    <div class="form-group">
      <label for="inputShipService" class="col-lg-2 control-label">Shipping Service:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="shipping_service" name="shipping_service" value="<?php echo $shipping_service; ?>" placeholder="Shipping Service">
      </div>
    </div>
    <div class="form-group">
      <label for="inputShppingCost" class="col-lg-2 control-label">Shpping Service Cost:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="service_cost" name="service_cost" value="<?php echo $service_cost; ?>" placeholder="Shpping Service Cost">
      </div>
    </div>
    <div class="form-group">
      <label for="inputOtherCost" class="col-lg-2 control-label">Shpping Service Additional Cost:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="add_cost" name="add_cost" value="<?php echo $add_cost; ?>" placeholder="Shpping Service Additional Cost">
      </div>
    </div>
        <div class="form-group">
      <label for="inputReturn" class="col-lg-2 control-label">Return Accepted Option:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="accepted_option" name="accepted_option" value="<?php echo $accepted_option; ?>" placeholder="Return Accepted Option">
      </div>
    </div>
    <div class="form-group">
      <label for="inputReturnWithin" class="col-lg-2 control-label">Returns Within Option:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="within_option" name="within_option" value="<?php echo $within_option; ?>" placeholder="Returns Within Option">
      </div>
    </div>
    <div class="form-group">
      <label for="inputPaidBy" class="col-lg-2 control-label">Shipping Cost Paid By:</label>
      <div class="col-lg-12">
        <input type="text" class="form-control" id="cost_paidby" name="cost_paidby" value="<?php echo $cost_paidby; ?>" placeholder="Shipping Cost Paid By">
      </div><br><br>
    </div>

    <div class="form-group">
      <div class="col-lg-12">
        <input type="hidden" name="id" value="<?php echo $id ?>" />
        <input type="submit" name="mit" class="btn btn-primary" value="Update">
        <button type="button" onclick="location.href='<?php echo site_url('ccrud') ?>'" class="btn btn-success">Back</button>
      </div>  
  </div>
</form>
<?php echo form_close(); ?>


<?php $this->load->view('template/footer');?>


