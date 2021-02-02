<?php $this->load->view("template/header.php"); ?>

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

          <?php echo form_open('template/c_temp/save', 'role="form"'); ?>

              <div class="row">
                <div class="col-sm-12">
                  
            <div class="col-sm-6">
              <div class="form-group">
                <label for="inputTempName" class=" control-label">Template Name:</label>
                
                  <input type="text" class="form-control" id="temp_name" name="temp_name" placeholder="Enter Template Name" required>
                </div>
              </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="inputTempName" class=" control-label">Site ID:</label>
                
                  <input type="number" class="form-control" id="site_id" name="site_id" value="0" readonly>
                </div>
              </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="inputShipCountry" class=" control-label">Ship From Country:</label>
                
                  <input type="text" class="form-control" id="ship_country" name="ship_country" value="US">
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputCurrancy" class=" control-label">Currency:</label>
                
                  <input type="text" class="form-control" id="currency" name="currency" value ="USD">
                </div>
              </div>
              <div class="col-sm-6">
                  <div class="form-group">
                <label for="inputListType" class=" control-label">Listing Type:</label>
                
                 <!--  <input type="text" class="form-control" id="listing_type" name="listing_type" placeholder="Fixed Price"> -->
                  <select class="form-control" id="listing_type" name="listing_type" value="<?php echo @$row->LIST_TYPE; ?>">
                    <option value="FixedPriceItem">Fixed Price</option>
                  <option value="Auction">Auction</option>
                  </select>
                </div>
              </div>
             <!--  <div class="col-sm-6">
              <div class="form-group">
                <label for="inputCat" class=" control-label">Category ID:</label>
                
                  <input type="number" class="form-control" id="cat_id" name="cat_id" placeholder="Category ID">
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group"> 
                  <label for="">Category Name:</label>
                  <input class="form-control" id="category_name" name="category_name" value="<?php //echo @$row->CATEGORY_NAME; ?>">

                 <a style="cursor: pointer;" id="Suggest_Categories">Suggest Category</a><br><br> 

              </div> -->
              <!-- <div class="col-sm-6">
              <div class="form-group">
                <label for="inputHtime" class=" control-label">Handling Time (Days):</label>
                
                  <input type="number" class="form-control" id="handling_time" name="handling_time" placeholder="">
                </div>
              </div> -->
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputZip" class=" control-label">Ship From (Zip Code):</label>
                
                  <input type="text" class="form-control" id="zip_code" name="zip_code" value="75229" placeholder="Zip Code">
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputShipLocation" class=" control-label">Ship From Loaction:</label>
                
                  <input type="text" class="form-control" id="ship_from" name="ship_from" value = "Texas, United States" >
                </div>
              </div>
          <!--     <div class="form-group">
                <label for="inputShiptoLocation" class=" control-label">Ship to Location:</label>
                <div class="col-lg-12">
                  <input type="text" class="form-control" id="ship_to" name="ship_to" placeholder="Ship to Location">
                </div>
              </div> -->
<!--               <div class="col-sm-6">
              <div class="form-group">
                <label for="inputBidLength" class=" control-label">Bid Length:</label>
                
                  <input type="text" class="form-control" id="bid_length" value="90" name="bid_length" placeholder="Bid Length">
                </div>
              </div> -->
<!--               <div class="col-sm-6">
              <div class="form-group">
                <label for="inputCondition" class=" control-label">Deafult Condition:</label>
                  <select class="form-control" id="default_condition" name="default_condition" value="<?php //echo @$row->DEFAULT_COND; ?>">
                    <option value="3000">Used</option>
                    <option value="1000">New</option>

                  </select>
                </div>
              </div> -->
<!--               <div class="col-sm-6">
                  <div class="form-group">
                <label for="inputCondDesc" class=" control-label">Default Condition Description:</label>
                
                  <input type="text" class="form-control" id="default_description" name="default_description" value="Default Description" placeholder="">
                </div>
              </div> -->

               <div class="col-sm-6">
              <div class="form-group">
                <label for="inputPayMethod" class=" control-label">Payment Method:</label>
                
                  <input type="text" class="form-control" id="payment_method" name="payment_method" value="PayPal" placeholder="PayPal">
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputEmail" class=" control-label">Paypal Email Address:</label>
                
                  <input type="text" class="form-control" id="paypal_email" name="paypal_email" placeholder="" required>
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputDispatch" class=" control-label">Dispatch Time Max:</label>
                
                  <input type="number" min="0" class="form-control" id="dispatch_time" name="dispatch_time" value="0" placeholder="Days">
                </div>
              </div>

              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputShipService" class=" control-label">Shipping Service:</label>
                
                  <select class="form-control" id="shipping_service" name="shipping_service" value="<?php echo @$row->SHIPPING_SERVICE; ?>">
                    <option value="USPSParcel">USPSParcel</option>
                    <option value="USPSFirstClass">USPS First Class</option>
                    <option value="USPSPriority">USPS Priority Mail</option>
                    <option value="FedExHomeDelivery">FedEx Ground or FedEx Home Delivery</option>
                    <option value="USPSPriorityFlatRateEnvelope">USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox">USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox">USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope">USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope">USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select>  
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputShppingCost" class=" control-label">Shpping Service Cost:</label>
                
                  <input type="number" min="0" class="form-control" id="service_cost" name="service_cost" value="0" placeholder="">
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputOtherCost" class=" control-label">Shpping Service Additional Cost:</label>
                
                  <input type="number" min="0" class="form-control" id="add_cost" name="add_cost" value="0" placeholder="">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                <label for="inputReturn" class=" control-label">Return Accepted Option:</label>
                
                  <!-- <input type="text" class="form-control" id="accepted_option" name="accepted_option" placeholder=""> -->
                  <select class="form-control" id="return_accepted" name="return_accepted" value="<?php echo @$row->RETURN_OPTION; ?>">
                     <option value="ReturnsAccepted">Yes</option>
                    <option value="ReturnsNotAccepted">No</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputReturnWithin" class=" control-label">Returns Within Option:</label>
                
                  <input type="number" min="14" class="form-control" id="within_option" name="within_option" placeholder="Minimum 14" required>
                  
                </div>
              </div>

              <div class="col-sm-6">
              <div class="form-group">
                <label for="inputPaidBy" class=" control-label">Shipping Cost Paid By:</label>
                
                  <!-- <input type="text" class="form-control" id="cost_paidby" name="cost_paidby" placeholder="Buyer"> -->
                  <select class="form-control" id="cost_paidby" name="cost_paidby" value="<?php echo @$row->SHIPPING_PAID_BY; ?>">
                     <option value="Buyer">Buyer</option>
                    <option value="Seller">Seller</option>
                  </select>
                </div>
              </div>
                      
               <div class="form-group">
                <div class="col-sm-12 buttn_submit">
                  <input type="submit" name="mit" title="Save Template" class="btn btn-success" value="Save">
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

<?php $this->load->view("template/footer.php"); ?>