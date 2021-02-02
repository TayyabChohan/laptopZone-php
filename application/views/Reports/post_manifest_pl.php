<?php $this->load->view('template/header');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post Manifest P/L Report
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Post Manifest P/L Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Search Criteria</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <form action="<?php echo base_url(); ?>reports/reports/search_post_manifest" method="post">


                <div class="col-sm-3">
                    <div class="form-group">
                      <input class="form-control" type="text" title="Search item by UPC, MPN or Desc" name="keyword_search" value="" placeholder="Search Item">
                    </div>                                     
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                     <?php $purchase_no = $this->session->userdata('purchase_no'); ?>
                        <input class="form-control" type="text" name="purchase_no" value="<?php if(isset($purchase_no)){echo $purchase_no; $this->session->unset_userdata('purchase_no');}  ?>" placeholder="Purchase Ref No">
                    </div>                                     
                </div>                
                     
                <div class="col-sm-2">
                  <div class="form-group">
                    <select name="post_manifest_pl" class="form-control" id="post_manifest_pl">
                    <?php $post_dropdown = $this->session->userdata('manif'); ?>
                      <option value="Active" <?php if(@$post_dropdown == "Active"){echo "selected";}  ?>>Active</option>
                      <option value="Sold" <?php if(@$post_dropdown == "Sold"){echo "selected";}  ?>>Sold</option>
                      <option value="Not Listed" <?php if(@$post_dropdown == "Not Listed"){echo "selected";}  ?>>Not Listed</option>
                      <option value="All" <?php if(@$post_dropdown == "All"){echo "selected";}  ?>>All</option>
                    </select>
                  </div>
                </div>
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


                <div class="col-sm-2">
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" title="Search Post Manifest Report" name="Submit" value="Search">
                    </div>
                </div>  
               </form>
             </div>

            </div>
          </div>
<!-- =================== Post Manifest P/L Summary Start ========================= -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Post Manifest P/L Summary</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>                
            </div>
            <div class="box-body">  
              <?php 
              $login_id = $this->session->userdata('user_id');  
              if($login_id == 2 || $login_id == 17 ){?>
              
              <table class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>Total # Unique</th>
                    <th>Total Listed Qty</th>
                    <th>Listed Value</th>
                    <th>Sold Qty</th>
                    <th>Sold Amount</th>
                    <th>Not Listed Qty</th>
                    <th>Not Listed Value (Cost)</th>
                    <th>Salvage Qty</th>
                    <th>Salvage Cost</th>
                  </tr>  
                </thead>
                <tbody>
                <tr>
                
              <?php 
              // echo "<pre>";
              // print_r($sum_data);

              // echo "</pre>";exit;
                foreach ($sum_data['summary_data'] as $sum): ?>


              <td>
                <?php
                   $total_unq = $sum['TOTAL_UNQ']; 
                   if(!empty(@$total_unq)){
                    echo @$total_unq;
                  }else{
                    echo 0;
                  }
                ?> 
              </td>
              <td>
                <?php
                  $total_list_qty = $sum['TOTAL_LIST_QTY'];
                   if(!empty(@$total_list_qty)){
                    echo @$total_list_qty;
                  }else{
                    echo 0;
                  }                  

                ?> 
              </td>
              <td>
                <?php
                   $total_list_val = $sum['TOTAL_LIST_VAL']; 
                    echo '$ '.number_format((float)@$total_list_val,2,'.',',');
                ?> 
              </td>
              <td>
                <?php
                   $total_sold_qty = $sum['TOTAL_SOLD_QTY']; 
                   if(!empty(@$total_sold_qty)){
                    echo @$total_sold_qty;
                  }else{
                    echo 0;
                  }                    

                ?> 
              </td> 
              
              <td>
                <?php
                   $total_sale_amt = $sum['TOTAL_SALE_AMT']; 
                    echo '$ '.number_format((float)@$total_sale_amt,2,'.',',');
                ?> 
              </td>                       
              <td>
                <?php 
                  $not_listed_qty = $sum['NOT_LISTED_QTY']; 
                   if(!empty(@$not_listed_qty)){
                    echo @$not_listed_qty;
                  }else{
                    echo 0;
                  }                    
                ?> 
              </td>
              <td>
                <?php 
                  $not_listed_value = $sum['NOT_LISTED_VALUE']; 
                  echo '$ '.number_format((float)@$not_listed_value,2,'.',',');
                ?> 
              </td> 
              <td>
                <?php
                   $total_salvage_qty = $sum['TOTAL_SALVAGE_QTY'];
                   if(!empty(@$total_salvage_qty)){
                    echo @$total_salvage_qty;
                  }else{
                    echo 0;
                  }                     

                ?> 
              </td>
              <td>
                <?php
                   $total_salvage_value = $sum['TOTAL_SALVAGE_VALUE']; 
                    echo '$ '.number_format((float)@$total_salvage_value,2,'.',',');
                ?> 
              </td>                          
           <?php endforeach ?> 
              <?php } ?>
              </tr>
              </tbody>
              </table>                            
            </div>
          </div>  
<!-- ==================== Post Manifest P/L Summary End ============================ -->
<!-- =================== Cost Leftover Summary Start ========================= -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Cost Leftover Summary</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>                
            </div>
            <div class="box-body">  
              <?php 
              $login_id = $this->session->userdata('user_id');  
              if($login_id == 2 || $login_id == 17 ){?>
              
              <table class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>Manifest Cost</th>
                    <th>Sold Item Amt</th>
                    <th>Active Item Cost </th>
                    <!-- <th>Active Amount</th>
                    <th>Sale Price</th>
                    <th>Listing Amount</th> -->
                    <th>Cost Leftover</th>

                  </tr>  
                </thead>
                <tbody>
                <tr>
                
              <?php 
                //foreach ($sum_data as $sum): ?>


              <td>
                <?php
                   $total_purch_value = $sum_data['total_cost_amt'][0]['TOTAL_PURCH_AMT']; 
                   if(!empty(@$total_purch_value)){
                     echo '$ '.number_format((float)@$total_purch_value,2,'.',',');
                    }else{
                    echo 0;
                  }
                ?> 
              </td>
              <td>
                <?php
                  $total_sale_amt = $sum_data['total_cost_amt'][0]['TOTAL_SALE_AMT']; 
                  echo '$ '.number_format((float)@$total_sale_amt,2,'.',',');                

                ?> 
              </td>
              <td>
                <?php
                   $total_list_cost = $sum_data['total_list_cost'][0]['TOTAL_LISTING_COST']; 
                    echo '$ '.number_format((float)@$total_list_cost,2,'.',',');
                ?> 
              </td>
             <!--  <td></td> -->
              <!-- <td>
                <?php
                  //  $total_sold_qty = $sum['TOTAL_SOLD_QTY']; 
                  //  if(!empty(@$total_sold_qty)){
                  //   echo @$total_sold_qty;
                  // }else{
                  //   echo 0;
                  // }                    

                ?> 
              </td>  -->
              
              <!-- <td>
                <?php
                   // $total_sale_amt = $sum['TOTAL_SALE_AMT']; 
                   //  echo '$ '.number_format((float)@$total_sale_amt,2,'.',',');
                ?> 
              </td> -->                       
              <td>
                <?php 
                $cost_leftover=$total_purch_value-$total_sale_amt-$total_list_cost;
                //echo $cost_leftover;
                echo '$ '.number_format((float)@$cost_leftover,2,'.',',');
                  // $not_listed_qty = $sum['NOT_LISTED_QTY']; 
                  //  if(!empty(@$not_listed_qty)){
                  //   echo @$not_listed_qty;
                  // }else{
                  //   echo 0;
                  // }                    
                ?> 
              </td>
                        
           <?php //endforeach ?> 
              <?php } ?>
              </tr>
              </tbody>
              </table>                            
            </div>
          </div>  
<!-- ==================== Cost Leftover Summary End ============================ -->



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
                    <th>Bar Code</th>

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

                   
                  <td><?php //echo @$row['EBAY_ITEM_ID']; ?>
                    <?php if(!empty(@$row['EBAY_ITEM_ID'])): 
                    if(@$row['SALE_QTY']>0)
                      {
                       $url= base_url()."reports/reports/item_detail/".@$row['ITEM_ID'].'/'.@$row['LZ_MANIFEST_ID'].'/'.@$row['EBAY_ITEM_ID'];
                      }else{
                        $url = base_url()."reports/reports/item_detail/".@$row['ITEM_ID'].'/'.@$row['LZ_MANIFEST_ID'];

                      }
                    ?>
                    <a href="<?php echo $url; ?>" title="Item Detail" class="btn btn-primary btn-sm" target="_blank"> <?php echo @$row['EBAY_ITEM_ID']; ?></a>
                                    <!-- <a href="<?php //echo base_url(); ?>reports/reports/item_detail/<?php //echo @$row['ITEM_ID'].'/'.@$row['LZ_MANIFEST_ID'] ?>" title="Item Detail" class="btn btn-primary btn-sm" target="_blank"> <?php //echo @$row['EBAY_ITEM_ID']; ?></a> -->
                    <?php endif ?>
                  </td>
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
                  <td><?php if(@$row['LIST_QTY'] > 0 && @$row['LIST_VALUE'] > 0 ) {echo number_format((float)(@$GP/(@$row['LIST_VALUE'] / @$row['LIST_QTY']))*100,2,'.',',') . " %";}else{echo null;}
                   ; 
                  ?></td>
                  <td><?php if(!empty(@$row['ITEM_BAR_CODE'])){echo @$row['ITEM_BAR_CODE'];}
                  ?></td>

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