<?php $this->load->view('template/header');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Manifest P/L Report
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manifest P/L Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search by Date</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <div class="col-sm-2">
              <label>Search Filter:</label>
            </div>
            <form action="<?php echo base_url(); ?>reports/reports/search_manifest_pl" method="post">

              <div class="col-sm-3">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <?php $rslt = $this->session->userdata('date_range'); ?>
                    <input type="text" class="btn btn-default" name="date_range" id="date_range" value="<?php echo $rslt; ?>">

                  </div>
                </div>
              </div>
                   
              <div class="col-sm-3">
            <?php 
              $manif_radio = $this->session->userdata('manif');
              if($manif_radio == 'active'){
                echo "<input type='radio' name='manif' value='active' checked>&nbsp;Active&nbsp;
                  <input type='radio' name='manif' value='sold'>&nbsp;Sold&nbsp;
                  <input type='radio' name='manif' value='Both'>&nbsp;Both";
                  $this->session->unset_userdata('manif');
              }elseif($manif_radio == 'sold'){
                echo "<input type='radio' name='manif' value='active' >&nbsp;Active&nbsp;
                  <input type='radio' name='manif' value='sold' checked>&nbsp;Sold&nbsp;
                  <input type='radio' name='manif' value='Both' >&nbsp;Both";
                  $this->session->unset_userdata('manif');

              }elseif($manif_radio == 'Both'){
                echo "<input type='radio' name='manif' value='active' >&nbsp;Active&nbsp;
                  <input type='radio' name='manif' value='sold'>&nbsp;Sold&nbsp;
                  <input type='radio' name='manif' value='Both' checked>&nbsp;Both";
                  $this->session->unset_userdata('manif');

              }else{
                echo "<input type='radio' name='manif' value='active' >&nbsp;Active&nbsp;
                  <input type='radio' name='manif' value='sold'>&nbsp;Sold&nbsp;
                  <input type='radio' name='manif' value='Both' checked>&nbsp;Both";
              }?>
              <!-- <input type='radio' name='awt' value='Dfwonline' checked>&nbsp;Dfwonline&nbsp;
              <input type='radio' name='awt' value='Techbargain'>&nbsp;Techbargain&nbsp;
              <input type='radio' name='awt' value='Both'>&nbsp;Both -->
   
              </div>
              <div class="col-sm-2">
                  <div class="form-group">
                      <input class="form-control" type="text" name="purchase_no" value="" placeholder="Purchase Ref No">
                  </div>                                     
              </div>

              <div class="col-sm-2">
                  <div class="form-group">
                      <input type="submit" title="Search Manifest Report" class="btn btn-primary" name="Submit" value="Search">
                  </div>
              </div>  
             </form>

            </div>
          </div>
<!-- =================== Total box Start ========================= -->
                    <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title">Manifest P/L Summary</h3>
                      </div>
                      <div class="box-body">  
                        <?php 
                        $login_id = $this->session->userdata('user_id');  
                        if($login_id == 2 || $login_id == 17 ){?>
                        
                        <table class="table table-bordered table-striped">
              
                          <thead>
                            <tr>
                              <th>Total Sale Amount</th>
                              <th>Total Cost Amount</th>
                              <th>Total Shipping Charges</th>
                              <th>Total eBay Charges</th>
                              <th>Total Paypal Charges</th>
                              <th>Total List Amount</th>
                              <th>Total List Quantity</th>
                              <th>Total Sale Quantity</th>
                            </tr>  
                          </thead>
                          <tbody>
                          <tr>
                          
                          <?php 
                          foreach ($sum_data as $sum): ?>
                        <td>
                          <?php
                             $total_sale_amount = $sum['TOTAL_SALE_PRICE']; 
                              echo '$ '.number_format((float)@$total_sale_amount,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php
                            $total_cost_amount = $sum['TOTAL_COST'];
                            echo '$ '.number_format((float)@$total_cost_amount,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php
                             $total_ship_fee = $sum['TOTAL_SHIP_FEE']; 
                              echo '$ '.number_format((float)@$total_ship_fee,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php
                             $total_ebay_fee = $sum['TOTAL_EBAY_FEE']; 
                              echo '$ '.number_format((float)@$total_ebay_fee,2,'.',',');
                          ?> 
                        </td> 
                        
                        <td>
                          <?php
                             $total_paypal_fee = $sum['TOTAL_PAYPAL_FEE']; 
                              echo '$ '.number_format((float)@$total_paypal_fee,2,'.',',');
                          ?> 
                        </td>                       
                        <td>
                          <?php 
                            $total_list_amount = $sum['TOTAL_LIST']; 
                            echo '$ '.number_format((float)@$total_list_amount,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php 
                            $total_list_qty = $sum['TOTAL_LIST_QTY']; 
                            echo number_format((float)@$total_list_qty,0,'.',',');
                          ?> 
                        </td> 
                        <td>
                          <?php
                             $total_sale_qty = $sum['TOTAL_SALE_QTY']; 
                              echo number_format((float)@$total_sale_qty,0,'.',',');
                          ?> 
                        </td> 
                     <?php endforeach ?> 
                        <?php } ?>
                        </tr>
                        </tbody>
                        </table>                            
                      </div>
                    </div>  



<!-- ==================== Total Box End ============================ -->




          <div class="box">

            <div class="box-body form-scroll">

             <table id="manifestTable" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>Purch Ref No</th>
                    <!-- <th>Loading Date</th>  -->                   
                    <th>Item Desc </th>
                    <th>eBay No</th>
                    <!-- <th>Purch Value</th>-->
                    <th>Cost Price</th>
                     <th>List Price</th>
                     <th>List Qty</th>
                    <th>Sold Price</th>                     
                    <th>Sold Qty</th>
                    <!-- <th>CoGs</th>
                    <th>P/L</th> -->
                    <!-- <th>Salvage Qty</th>
                    <th>Salvage Value</th> -->
                    <th>Total Sale</th>
                    <th>Total eBay Fee</th>
                    <th>Total PayPal Fee</th>
                    <th>Shipping Charges</th>
                    <th>P/L</th>
                    <th>Gross P/L %</th>

                  </tr>
                </thead>
                <tbody>

            <?php

            if(!empty($manifest_data)){
             
             if ($manifest_data == NULL) {
             ?>
             <div class="alert alert-info" role="alert">There is no record found.</div>
             <?php
            } else {
                foreach ($manifest_data as $row) {
            ?>
                  <?php  if(@$row['SALE_QTY'] > 0){$COGS = @$row['COST_RATE'] + (@$row['EBAY_FEE'] + @$row['PAYPAL_FEE'] + @$row['SHIP_FEE'])/@$row['SALE_QTY'];}else{$COGS =@$row['COST_RATE'];} 
                 if(@$row['LIST_QTY'] > 0){$PL = ((@$row['LIST_VALUE'] / @$row['LIST_QTY']) - $COGS)*@$row['SALE_QTY'];}else{$PL = null;}
                 if(@$row['SALE_QTY'] > 0) { $GP = $PL/@$row['SALE_QTY'];}else{$GP =null;};
                 ?>
                  <tr>

                  <td><?php echo @$row['PURCH_REF_NO']; ?></td>
                  <td><?php echo @$row['ITEM_DESC']; ?></td>
                  <td><?php echo @$row['EBAY_ITEM_ID']; ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['COST_RATE'],2,'.',',');

                  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['LIST_VALUE'],2,'.',',');

                  ?></td>
                  <td><?php echo @$row['LIST_QTY']; ?></td>
                  <td><?php  if(@$row['LIST_QTY'] > 0){echo '$ '.number_format((float)(@$row['LIST_VALUE'] / @$row['LIST_QTY']),2,'.',',');}?></td>
                  <td><?php echo @$row['SALE_QTY']; ?></td>
                  <td><?php if(@$row['LIST_QTY'] > 0){ echo '$ '.number_format((float)((@$row['LIST_VALUE'] / @$row['LIST_QTY'])*@$row['SALE_QTY']),2,'.',',');} ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['EBAY_FEE'],2,'.',',');
                  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['PAYPAL_FEE'],2,'.',',');
                  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['SHIP_FEE'],2,'.',',');
                  ?></td>
                  <td><?php //echo '$ '.number_format((float)@$row['PL'],2,'.',',');
                  echo '$ '.number_format((float)@$PL,2,'.',',');
                  ?></td>
                  <td><?php if($row['LIST_QTY'] > 0) {echo number_format((float)(@$GP/(@$row['LIST_VALUE'] / @$row['LIST_QTY']))*100,2,'.',',') . " %";}else{echo null;}
                   ; 
                  ?></td>
                  <!-- <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td> -->
                  <?php
                }
            }
                
        }?>
                  </tr>
                </tbody>
             </table>
            </div>
            </div>
          </div>                    

      </div>
              

      </div>
    </section>
    <!-- /.content -->
  


<?php $this->load->view('template/footer');?>