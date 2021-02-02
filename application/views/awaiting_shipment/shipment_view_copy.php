<?php $this->load->view('template/header');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Awaiting Shipment
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- <form action=""> -->
            <!--<div class="col-sm-2">
              <label>Search Filter:</label>
            </div>-->
            <form action="<?php echo base_url(); ?>shipment/awaiting_shipment/awt_search" method="post">
            <div class="col-sm-4">
              <?php $awt_radio = $this->session->userdata('awt');
                if($awt_radio == 2){
                  echo "<input type='radio' name='awt' value='2' checked>&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both'>&nbsp;Both";
                    $this->session->unset_userdata('awt');
                }elseif($awt_radio == 1){
                  echo "<input type='radio' name='awt' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1' checked>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both' >&nbsp;Both";
                    $this->session->unset_userdata('awt');

                }elseif($awt_radio == 'Both'){
                  echo "<input type='radio' name='awt' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both' checked>&nbsp;Both";
                    $this->session->unset_userdata('awt');

                }else{
                  echo "<input type='radio' name='awt' value='2' >&nbsp;Dfwonline&nbsp;
                    <input type='radio' name='awt' value='1'>&nbsp;Techbargain&nbsp;
                    <input type='radio' name='awt' value='Both' checked>&nbsp;Both";
                }?>
                <!-- <input type='radio' name='awt' value='Dfwonline' checked>&nbsp;Dfwonline&nbsp;
                <input type='radio' name='awt' value='Techbargain'>&nbsp;Techbargain&nbsp;
                <input type='radio' name='awt' value='Both'>&nbsp;Both -->
             
            </div>
            <div class="col-sm-2">
              <input class="btn btn-primary" type="submit" name="Submit" value="Search">
            </div>
             </form>
      <!--  <div class="col-sm-4">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="button" class="btn btn-default" name="daterange-btn" id="daterange-btn">

                </div>
              </div>
            </div> -->

            <div class="col-sm-3">
              <label for="">Get Orders:</label>
              <input type="button" id="GetOrders" class="btn btn-default" name="GetOrders" value="Pull Orders">
            </div>
            <!-- <div class="col-sm-3">
              <label for="">Update Orders:</label>
              <input type="button" id="UpdateOrders" class="btn btn-default" name="UpdateOrders" value="Update">
            </div> -->
                           
            <!-- </form> -->

            </div>
          </div>        

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Awaiting Shipment</h3>
              <?php 
              $login_id = $this->session->userdata('user_id');  
              if($login_id == 2 || $login_id == 17 ){?>
              <br><br>
              <label>
                Total Price: 
                <?php 
                foreach ($total_price_quantity as $t) 
                  { $total_price = $t['TOTAL_PRICE'];
                  echo '$ '.number_format((float)@$total_price,2,'.','');

                  } 
                ?> 
              </label><br>
              <label>
                Total Quantity: 
                <?php 
                foreach ($total_price_quantity as $tk) 
                  { $total_quantity = $tk['TOTAL_QUANTITY']; 
                    echo $total_quantity;
                  }
                ?> 
              </label><br>
              <label>
                Total Sale Amount: 
                <?php 
                foreach ($total_sale_price as $tsa) 
                  { $total_sale = $tsa['TOTAL_SALE_PRICE']; 
                    echo '$ '.number_format((float)@$total_sale,2,'.','');
                  }
                ?> 
              </label>               
              <?php } ?>              
            </div>
            <!-- /.box-header -->
            <div class="box-body form-scroll">

             <table id="awaitingShipment" class="table table-bordered table-striped">
    
                <thead>
                  <tr>
                    <th>Record No#</th>
                    <!-- <th>Photo</th> -->
                    <th>Item Title</th>
                    <th>Ebay Item ID</th>                    
                    <th>Buyer Username / Email</th>
                    <th>Qty</th>
                    <th>Sold For</th>
                    <th>Total</th>
                    <th>Date Sold</th>
                    <th>Date Paid</th>
                    <th>Buyer Msg</th>


                  </tr>
                </thead>
                <tbody>

            <?php

            if(!empty($data)){
             
             if ($data == NULL) {
             ?>
             <div class="alert alert-info" role="alert">There is no record found.</div>
             <?php
            } else {
            foreach ($data as $row) {
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
                   echo '$ '.number_format((float)@$sale_price,2,'.','');
                    //echo '$ '. round(@$sale_price, 2); 
                  ?>
                  </td>
                  <td>
                  <?php
                    $total_price = $row['TOTAL_PRICE'];
                    echo '$ '.number_format((float)@$total_price,2,'.','');
                    //echo '$ '.round(@$total_price, 2); 
                  ?>
                  </td>
                  <td><?php echo @$row['SALE_DATE']; ?></td>
                  <td><?php echo @$row['PAID_ON_DATE']; ?></td>
                  <td><?php echo @$row['BUYER_CHECKOUT_MSG']; ?></td>
    

                <?php
                }
            }
                
        }else{

             if ($shipment == NULL) {
             ?>
             <div class="alert alert-info" role="alert">There is no record found.</div>
             <?php
            } else {
            foreach ($shipment as $row) {
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
                    echo '$ '.number_format((float)@$sale_price,2,'.','');
                    //echo '$ '. round(@$sale_price, 2); 
                  ?>
                  </td>
                  <td>
                  <?php
                    $total_price = $row['TOTAL_PRICE'];
                    echo '$ '.number_format((float)@$total_price,2,'.','');
                    //echo '$ '.round(@$total_price, 2); 
                  ?>
                  </td>
                  <td><?php echo @$row['SALE_DATE']; ?></td>
                  <td><?php echo @$row['PAID_ON_DATE']; ?></td>
                  <td><?php echo @$row['BUYER_CHECKOUT_MSG']; ?></td>
    

                <?php
                }
            }
}
                ?>
                  </tr>
                </tbody>
             </table>
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