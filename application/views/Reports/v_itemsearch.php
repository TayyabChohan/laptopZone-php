<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Item Detail
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Item Detail</li>
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
            <div class="box-header with-border">
              <h3 class="box-title">Listing Detail</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
<?php //if($data['view'] == true): ?>
            <!-- Table data for ACTIVE ITEMS Start -->
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>LISTER NAME</th>
                    <th>TIMESTAMP</th>
                    <!-- <th>ACTUAL COST</th>
                    <th>LIST PRICE</th>
                    <th>LISTED QTY</th> -->
                    <th>MANIFEST QTY</th>
                    <th>BARCODE</th>
                    <th>ACCOUNT NAME</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php

          if(!empty($data['item_detail'])){
             
             if ($data['item_detail'] == NULL) {
             ?>
             <div class="alert alert-info" role="alert">There is no record found.</div>
             <?php
            } else {
                foreach ($data['item_detail']['detail'] as $row) {
            ?>
                  <tr>
                    <td><?php 
                    foreach ($data['item_detail']['user'] as $user) {
                      if($user['EMPLOYEE_ID'] == @$row['LISTER_ID']){
                        echo @$user['USER_NAME'];
                      }
                    }
                     //echo @$row['LISTER_ID']; ?></td>
                    <td><?php echo @$row['LIST_DATE']; ?></td>
                    <!-- <td><?php //echo @$row['COST_US']; ?></td>
                    <td><?php //echo @$row['LIST_PRICE']; ?></td>
                    <td><?php //echo @$row['LIST_QTY']; ?></td> -->
                    <td><?php echo @$row['AVAIL_QTY']; ?></td>
                    <td><?php echo @$row['IT_BARCODE']; ?></td>
                    <td><?php $account_name = $row['LZ_SELLER_ACCT_ID'];
                          if($account_name == 2){
                            echo "Dfwonline";
                          }elseif($account_name == 1){
                            echo "Techbargain";
                          }else{
                            echo $account_name;
                          } ?>
                    </td>
                  <?php
                }//endforeach
            }//end else
                
        }// end main if?>                  
                  </tr>
                </tbody>
              </table>
      <?php //endif; ?>
              <!-- Table data for ACTIVE ITEMS End -->  


                       

            </div>
          </div>  

<?php if($data['item_detail']['sale_data'] != NULL): ?>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Paid & Shipped Detail</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">

              <!-- Table data for SOLD ITEMS Start -->  
             <table class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>RECORD NO#</th>
                    <th>ITEM TITLE</th>
                    <th>EBAY ITEM ID</th>                    
                    <th>BUYER USERNAME / EMAIL</th>
                    <th>QTY</th>
                    <th>SOLD FOR</th>
                    <th>TOTAL</th>
                    <th>EBAY FEE</th>
                    <th>PAYPAL FEE</th>
                    <th>DATE SOLD</th>
                    <th>DATE PAID</th>
                    <!-- <th>BUYER MSG</th> -->
                    
                  </tr>
                </thead>
                <tbody>

            <?php

            if(!empty($data['item_detail']['sale_data'])){
             
             if ($data['item_detail']['sale_data'] == NULL) {
             ?>
             <div class="alert alert-info" role="alert">There is no record found.</div>
             <?php
            } else {
            foreach ($data['item_detail']['sale_data'] as $row) {
            ?>
                  <tr>
                  <td <?php if(!empty(@$row['BUYER_CHECKOUT_MSG'])){echo "class='buyer-txt'";} ?>><?php echo @$row['SALES_RECORD_NUMBER']; ?></td>
                  <!--<td></td>-->
                  <td><?php echo @$row['ITEM_TITLE']; ?></td>
                  <td><?php echo @$row['ITEM_ID']; ?></td>
                  <td><?php echo @$row['USER_ID']; ?> / <?php echo @$row['BUYER_EMAIL']; ?></td>
                  <td><?php echo @$row['QUANTITY']; ?></td>
                  <td>
                  <?php 
                    $sale_price = $row['SALE_PRICE'];
                   echo '$ '.number_format((float)@$sale_price,2,'.',',');
                    //echo '$ '. round(@$sale_price, 2); 
                  ?>
                  </td>
                  <td>
                  <?php
                    $total_price = $row['TOTAL_PRICE'];
                    echo '$ '.number_format((float)@$total_price,2,'.',',');
                    ////echo '$ '.round(@$total_price, 2); 
                  ?>
                  </td>
                  <td>
                  <?php 
                    $ebay_fee = $row['EBAY_FEE_PERC'];
                    echo '$ '.number_format((float)@$ebay_fee,2,'.',','); 
                  ?>
                  </td>
                  <td>
                  <?php 
                    $paypal_fee =$row['PAYPAL_PER_TRANS_FEE'];
                    echo '$ '.number_format((float)@$paypal_fee,2,'.',','); 
                  ?>
                  </td>
                  <td><?php echo @$row['SALE_DATE']; ?></td>
                  <td><?php echo @$row['PAID_ON_DATE']; ?></td>
                  <!-- <td><?php //echo @$row['BUYER_CHECKOUT_MSG']; ?></td> -->

                <?php
               }
           }
                
        }?>
                  </tr>
                </tbody>
             </table>
             <?php endif; ?>
             <!-- Table data for SOLD ITEMS End -->                 

                       

            </div>
          </div> 
       
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>    
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>