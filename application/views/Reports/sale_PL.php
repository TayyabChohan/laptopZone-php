<?php $this->load->view('template/header');?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sale P/L Report
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sale P/L Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search by Date</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <div class="col-sm-2">
              <label>Search Filter:</label>
            </div>
            <form action="<?php echo base_url(); ?>reports/reports/search_sale_pl" method="post">

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
              <?php $sale_pl_radio = $this->session->userdata('sale_pl');
                if($sale_pl_radio == 2){
                  echo "<input type='radio' name='sale_pl' value='2' checked>&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='sale_pl' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='sale_pl' value='Both'>&nbsp;Both";
                    $this->session->unset_userdata('sale_pl');
                }elseif($sale_pl_radio == 1){
                  echo "<input type='radio' name='sale_pl' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='sale_pl' value='1' checked>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='sale_pl' value='Both' >&nbsp;Both";
                    $this->session->unset_userdata('sale_pl');

                }elseif($sale_pl_radio == 'Both'){
                  echo "<input type='radio' name='sale_pl' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='sale_pl' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='sale_pl' value='Both' checked>&nbsp;Both";
                    $this->session->unset_userdata('sale_pl');

                }else{
                  echo "<input type='radio' name='sale_pl' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='sale_pl' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='sale_pl' value='Both' checked>&nbsp;Both";
                }?>
                <!-- <input type='radio' name='awt' value='Dfwonline' checked>&nbsp;Dfwonline&nbsp;
                <input type='radio' name='awt' value='Techbargain'>&nbsp;Techbargain&nbsp;
                <input type='radio' name='awt' value='Both'>&nbsp;Both -->
             
            </div>
                        <!-- <div class="col-sm-2">
                            <div class="form-group">
                                <input class="form-control" type="text" name="purchase_no" value="" placeholder="Purchase Ref No">
                            </div>                                     
                        </div> -->
                        <?php $get_em_id = $this->session->userdata('get_emplo'); ?>
              <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Special Lot" class="control-label">Select Employee:</label>
                     <div class="form-group" id ="apnd_obj">                   
                    <select class=" selectpicker form-control get_emp"  data-live-search ="true" id="get_emp" name="get_emp" >

                      <option value = "">Select Employee</option>

                      <?php                     

                      foreach ($result['qyer'] as $data_qyer) {
                      if($data_qyer['EMPLOYEE_ID'] == $get_em_id){
                        $selected = "selected";
                      }else{
                        $selected = "";
                      }                        
                      ?>
                          <option value="<?php echo $data_qyer['EMPLOYEE_ID']; ?>" <?php echo $selected; ?>><?php echo $data_qyer['USER_NAME']; ?></option>
                      <?php 
                        }
                      ?>
                    </select>
                    </div> 
                  </div>
                </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="submit" title="Search Sale P/L Report" class="btn btn-primary" name="Submit" value="Search">
                            </div>
                        </div>  
             </form>

            </div>
          </div>
<!-- =================== Total box Start ========================= -->
                    <div class="box">
                      <div class="box-header">
                        <h3 class="box-title">Sale P/L Summary</h3>
                      </div>
                      <div class="box-body">
                        <?php 
                        $login_id = $this->session->userdata('user_id');  
                        if($login_id == 2 || $login_id == 17 ){?>
                        <br><br>
                        <table class="table table-bordered table-striped">
              
                          <thead>
                            <tr>
                              <th> Sale Amount</th>
                              <th> Material Cost</th>
                              <th> Shipping Charges</th>
                              <th> eBay Charges</th>
                              <th> Paypal Charges</th>
                              <th> Sale(s) Tax</th>
                              <th> Cost of Sale(s)</th>
                                <th> PL</th>
                                <th>PL %</th>
                              <!--<th>Total Sale Quantity</th> -->
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
                            $total_tax = $sum['SUM_TAX']; 
                            echo '$ '.number_format((float)@$total_tax,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php 
                            $SUM_COST = $sum['SUM_COST']; 
                            echo '$ '.number_format((float)@$SUM_COST,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php 
                            $TOTAL_PL = $sum['TOTAL_PL']; 
                            echo '$ '.number_format((float)@$TOTAL_PL,2,'.',',');
                          ?> 
                        </td>
                        <td>
                          <?php 
                          if(@$total_sale_amount != 0){
                            $PL_PERC = ($TOTAL_PL/@$total_sale_amount) * 100 ; 
                          }else{
                            $PL_PERC = 0 ; 
                          }
                           
                            echo number_format((float)@$PL_PERC,2,'.',',')." %";
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
            <div class="box-header">
            </div>

            <div class="box-body form-scroll">

             <table id="saleTable" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>ORDER ID</th>
                    <th>SALE DATE</th>                    
                    <th>TITLE </th>
                    <th>EBAY ID</th>
                    <th>List By</th>
                     
                    <th>QUANTITY</th>
                     <th>TOTAL PRICE</th>
                     
                    <!-- <th>CoGs</th>
                    <th>P/L</th> -->
                    <!-- <th>Salvage Qty</th>
                    <th>Salvage Value</th> -->
                    
                    <th>TOTAL EBAY FEE</th>
                    <th>SHIPPING CHARGES</th>
                    <th>PAYPAL FEE</th>
                    
                    <th>COST</th>
                    <th>COS</th>
                    <th>TOTAL P/L</th>
                    <th> PL % </th>
                    <th>ERP CODE</th>
                  </tr>
                </thead>
                <tbody>

            <?php 

            if(!empty($sale_data)){
             
             if ($sale_data == NULL) {
             ?>
             <div class="alert alert-info" role="alert">There is no record found.</div>
             <?php
            } else {
                foreach ($sale_data as $row) {
            ?>
                 
                  <tr>

                  <td><?php echo @$row['SALES_RECORD_NUMBER']; ?></td>
                  <td><?php echo @$row['SALE_DATE']; ?></td>
                  <td><?php echo @$row['ITEM_TITLE']; ?></td>
                  <td><?php echo @$row['ITEM_ID']; ?></td>
                  <td><?php echo @$row['LIST_BY']; ?></td>
                  
                  <td><?php echo @$row['QUANTITY'];  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['TOTAL_PRICE'],2,'.',',');

                  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['EBAY_FEE_PERC'],2,'.',','); ?></td>
                  <td><?php  echo '$ '.number_format((float)@$row['SHIPPING_CHARGES'],2,'.',',');?></td>
                  <td><?php echo '$ '.number_format((float)@$row['PAYPAL_PER_TRANS_FEE'],2,'.',','); ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['MAT_COST'],2,'.',',');
                  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['COST_OF_SALE'],2,'.',',');
                  ?></td>
                  <td><?php echo '$ '.number_format((float)@$row['TOTAL_PL'],2,'.',',');
                  ?></td>
                  
                  <td> <?php if(@$row['TOTAL_PRICE'] >0){$PL_PERC = (@$row['TOTAL_PL']/@$row['TOTAL_PRICE']) * 100 ;}else{$PL_PERC =0;} 
                  echo number_format((float)@$PL_PERC,2,'.',',')." %";
                  ?>
                    
                  </td>
                  <td><?php echo @$row['ITEM_CODE']; ?></td>
                  <!--<td></td>
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