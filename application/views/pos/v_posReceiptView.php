<?php $this->load->view("template/header.php"); ?>
	
	   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        POS Receipt View
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">POS Receipt View</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <!-- Deletion Message start-->
          <?php if($this->session->flashdata('deleted')){ ?>
            <div id="delSuccess" class="alert alert-success alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> <?php echo $this->session->flashdata('deleted'); ?>
            </div>
          <?php }elseif($this->session->flashdata('del_error')){  ?>

          <div id="delError" class="alert alert-danger alert-dismissable">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> <?php echo $this->session->flashdata('del_error'); ?>
          </div>

          <?php } ?>
          <!-- Deletion Message end-->           
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search By</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <!-- box header-->
            <div class="box-body">
              	<div class="row">
                	<div class="col-sm-12">


                    <form action="<?php echo base_url(); ?>pos/c_pos_list/receiptSearch" method="post" accept-charset="utf-8">

                      <div class="col-sm-8">
                          <div class="form-group">
                           
                              <input class="form-control" type="text" name="receipt_search" id="receipt_search" value="<?php echo @$perameter;  ?>" placeholder="Search">
                          </div>                                     
                      </div> 
                        <div class="col-sm-3">
                          <div class="form-group">
                              <input type="submit" class="btn btn-primary" name="search_btn" value="Search">
                          </div>
                        </div>                                 
                    </form>                		

<!--                 		<div class="col-sm-2">
		                    <div class="form-group">
		                    	<label>Amount Range:</label>
		                    	<div class="input-group">
			                      
		                          <input class="form-control" type="text" name="amnt_range" value="" placeholder="To">
		                        </div>
		                    </div>                                     
		                </div> 
		                <div class="col-sm-2">
		                    <div class="form-group">
		                    	<label>Amount Range:</label>
		                    	
		                    	<div class="input-group">
			                      
		                          <input class="form-control" type="text" name="amnt_range_to" value="" placeholder="From">
		                        </div>
		                    </div>                                     
		                </div>
		                <div class="col-sm-3">
		                  <div class="form-group">
		                  <label>Date:</label>
		                    <div class="input-group">
		                      <div class="input-group-addon">
		                        <i class="fa fa-calendar"></i>
		                      </div>


		                      <input type="text" class="btn btn-default" name="date_range" id="date_range" value="">

		                    </div>
		                  </div>
		                </div>
		                <div class="col-sm-2">
		                    <div class="form-group">
		                    	<label>Pos No:</label>
		                    	<div class="input-group">
			                      
		                          <input class="form-control" type="text" name="pos_no" value="" placeholder="To">
		                        </div>
		                    </div>                                     
		                </div> 
		                <div class="col-sm-2">
		                    <div class="form-group">
		                    	<label>Pos No:</label>
		                    	<div class="input-group">
			                      
		                          <input class="form-control" type="text" name="pos_no _to" value="" placeholder="From">
		                        </div>
		                    </div>                                     
		                </div>  -->
		                   
                	</div>

                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">POS Receipt View</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div> 
            </div>
            <div class="box-body form-scroll">
            	 <table id="posReceiptView" class="table table-bordered table-striped">
            	 	<thead>
            	 		<th>ACTION</th>
            	 		<th>RECEIPT NO</th>
            	 		<th>RECEIPT DATE</th>
            	 		<th>PHONE</th>
                  <th>NAME</th>
            	 		<th>EMAIL</th>
            	 		<th>ADDRESS</th>
            	 		<th>PRICE</th>
                  <!-- <th>DISC PERC %</th> -->
                  <th>DISC AMOUNT</th>
                  <th>SALES TAX</th>
                  <th>GRAND TOTAL</th>
            	 		<th>ENTERED BY</th>
            	 		

            	 	</thead>
            	 	<tbody>
            	 	<!-- foreach -->
            	 	<?php foreach(@$data as $row): ?>
            	 		<tr>
            	 			<td>
            	 				<div style="width:100px;">
			                        <div style="float:left;margin-right:8px;">
			                         	
			                         	<a title="Edit Record" href="<?php echo base_url(); ?>pos/c_point_of_sale/editInvoice/<?php echo $row['LZ_POS_MT_ID']; ?>" class="btn btn-warning btn-xs" target="_blank"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                      					</a>
                      					<a title="Delete Record" href="<?php echo base_url(); ?>pos/c_point_of_sale/deleteInvoice/<?php echo $row['LZ_POS_MT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                      					</a>
			                         </div>
			                        <div style="float:left; margin-right:8px;">
			                         	<a title="Print Invoice" href="<?php echo base_url(); ?>pos/c_pos_list/printInvoice/<?php echo $row['LZ_POS_MT_ID']; ?>" class="btn btn-info btn-xs" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true" ></span>
                      					</a>
			                        </div>

			                    </div>
            	 			</td>
            	 			<td><?php echo $row['DOC_NO']; ?></td>
            	 			<td><?php echo $row['DOC_DATE']; ?></td>
            	 			<td><?php echo $row['BUYER_PHONE_ID']; ?></td>
                    <td><?php echo $row['BUYER_NAME']; ?></td>
            	 			<td><?php echo $row['BUYER_EMAIL']; ?></td>
            	 			<td><?php echo $row['BUYER_ADDRESS']; ?></td>
            	 			
            	 			<td><?php echo '$ '.number_format((float)@$row['PRICE'],2,'.',',');?></td>
                    <!-- <td><?php //echo '$ '.number_format((float)@$row['DISC_PERC'],2,'.',','); ?></td> -->
                    <td><?php echo '$ '.number_format((float)@$row['DISC_AMT'],2,'.',','); ?></td>
                    <td>
                      <?php 
                      $price = @$row['PRICE'];
                      $price = $price - @$row['DISC_AMT'];
                        $tax_amt = (@$price/100)*@$row['SALES_TAX_PERC'];
                        //echo $tax_amt;

                        echo '$ '.number_format((float)@ $tax_amt,2,'.',','); 
                      ?>
                        
                    </td>
                    <td>
                      <?php 

                        $price = @$row['PRICE'];
                        $price = $price - @$row['DISC_AMT'];
                        $grand_total = $price + $tax_amt;
                        echo '$ '.number_format((float)@ $grand_total,2,'.',',');

                       ?>
                    </td>

            	 			<td>
                    <?php 
                      foreach($users as $user){
                        $u_name = ucfirst($user['USER_NAME']);
                        $employee_id = $user['EMPLOYEE_ID']; 
                        if($employee_id ==  $row['ENTERED_BY']){
                          echo $u_name;
                        }
                     
                      } 
                    ?>                        
                    </td>
            	 		</tr>
            	 	<?php endforeach;?>
            	 		
            	 	</tbody>
            	 </table><br />

            </div>
        </div>
      </div>  

    </section>

  </div>

<?php $this->load->view("template/footer.php"); ?>
<script>
    /*===== Success message auto hide ====*/
        setTimeout(function() {
          $('#delSuccess').fadeOut('slow');
        }, 3000); // <-- time in milliseconds

        setTimeout(function() {
          $('#delError').fadeOut('slow');
        },3000); // <-- time in milliseconds        

    /*===== Success message auto hide ====*/    
</script>