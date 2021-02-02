<?php $this->load->view('template/header');?>
<p>
<a href="<?php echo site_url('ccrud/add') ?>" class="btn btn-primary">Add New</a>
</p>
<div class="table-responsive">
   <table class="table table-bordered table-hover table-striped">
      <caption>Template Form Data</caption>
      <thead>
        <tr>
          <th width="80px">Template Id</th>
          <th>Template Name</th>
          <th>Ship From Country</th>
          <th>Currency</th>
          <th>Listing Type</th>
          <th>Category ID</th>
          <th>Handling Time (Days)</th>
          <th>Ship From (Zip Code)</th>
          <th>Ship From Loaction</th>
          <th>Bid Length</th>
          <th>Deafult Condition</th>
          <th>Default Condition Description</th>
          <th>Payment Method</th>
          <th>Paypal Email Address</th>
          <th>Dispatch Time Max</th>
          <th>Shipping Service</th>
          <th>Shpping Service Cost</th>
          <th>Shpping Service Additional Cost</th>
          <th>Return Accepted Option</th>
          <th>Returns Within Option</th>
          <th>Shipping Cost Paid By</th>

          <!-- <th>TEMPLATE ID</th> -->
          <th width="80px">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
  if ($data_get == NULL) {
  ?>
  <div class="alert alert-info" role="alert">There is no record found.</div>
  <?php
  } else {
  foreach ($data_get as $row) {
  ?>
        <tr>
        <td><?php echo $row->TEMPLATE_ID; ?></td>
          <td><?php echo $row->TEMPLATE_NAME; ?></td>
          <td><?php echo $row->EBAY_LOCAL; ?></td>
          <td><?php echo $row->CURRENCY; ?></td>
          <td><?php echo $row->LIST_TYPE; ?></td>
         <td><?php echo $row->CATEGORY_ID; ?></td>
         <td><?php echo $row->HANDLING_TIME; ?></td>
         <td><?php echo $row->SHIP_FROM_ZIP_CODE; ?></td>
         <td><?php echo $row->SHIP_FROM_LOC; ?></td>
         <td><?php echo $row->BID_LENGTH; ?></td>
         <td><?php echo $row->DEFAULT_COND; ?></td>
         <td><?php echo $row->DETAIL_COND; ?></td>
         <td><?php echo $row->PAYMENT_METHOD; ?></td>
         <td><?php echo $row->PAYPAL_EMAIL; ?></td>
         <td><?php echo $row->DISPATCH_TIME_MAX; ?></td>
         <td><?php echo $row->SHIPPING_SERVICE; ?></td>
         <td><?php echo $row->SHIPPING_COST; ?></td>
         <td><?php echo $row->ADDITIONAL_COST; ?></td>
         <td><?php echo $row->RETURN_OPTION; ?></td>
         <td><?php echo $row->RETURN_DAYS; ?></td>
         <td><?php echo $row->SHIPPING_PAID_BY; ?></td>      
          <!--<td>--><?php //echo $row->TEMPLATE_ID; ?><!--</td>-->
          <td>
           <a href="<?php echo site_url('ccrud/edit/' . $row->TEMPLATE_ID); ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a><br>
           <a href="<?php echo site_url('ccrud/delete/' . $row->TEMPLATE_ID); ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
          </td>
      <?php
      }
  }
      ?>
        </tr>
      </tbody>
   </table>
</div>

<?php $this->load->view('template/footer');?>