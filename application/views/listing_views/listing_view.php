<?php $this->load->view('template/header');
ini_set('memory_limit', '-1');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Listing Form
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Listing Form</li>
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
<!--             <div class="box-header">
              <h3 class="box-title">Listing Form</h3>
            </div> -->
            <!-- /.box-header -->

                        <div class="box box-body">
                            <form action="<?php echo base_url(); ?>listing/listing_search" method="post">
                                <div class="col-sm-4">
                                    <h4><strong>Listing</strong></h4>
                                    <div class="form-group">
                                        <input type="radio" name="List" value="Completely Listed"> Listed&nbsp;
                                        <input type="radio" name="List" value="Partially Listed"> Partially Listed&nbsp;

                                        <?php //var_dump($this->session->userdata('flag'));exit; 
                                        if($this->session->userdata('flag')){echo "<input type='radio' name='List' value='Not Listed' checked> Not Listed&nbsp;";}elseif(empty($this->session->userdata('flag'))){echo "<input type='radio' name='List' value='Not Listed' checked> Not Listed&nbsp;";}else{echo "<input type='radio' name='List' value='Not Listed'> Not Listed&nbsp;";} ?>
                                        <input type='radio' name='List' value='All'> All&nbsp;
                            			
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <h4><strong>Seed</strong></h4>
                                    <div class="form-group">
                                    <?php if($this->session->userdata('flag')){echo "<input type='radio' name='seed' value='Available' checked> Available&nbsp;"; $this->session->unset_userdata('flag');}else{echo "<input type='radio' name='seed' value='Available'> Available&nbsp;";} ?>

                                        
                                        <?php  
                            			if(empty($this->session->userdata('flag'))){echo "<input type='radio' name='seed' value='Not Available' checked> Not Available&nbsp;";}else{echo "<input type='radio' name='seed' value='Not Available'> Not Available&nbsp;";} ?>

                                        <?php  
                            			echo "<input type='radio' name='seed' value='Both'> All&nbsp;"; ?>

                                    </div>                                
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group p-t-40">
                                        <input type="submit" title="Search Seed Item" class="btn btn-primary" name="Submit" value="Search">
                                    </div>
                                </div>                              
                            </form>
<!--                             <form action="" method="get" accept-charset="utf-8">
                                <div class="col-sm-3">
                                    <h4><strong>Barcode Search</strong></h4>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="barcode" value="" placeholder="Barcode">
                                    </div>                                     
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group p-t-40">
                                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                                    </div>
                                </div>                                 
                            </form> -->
                        </div>
                    </div>

            	<div class="box">	
            		<div class="box-body form-scroll">						
						<table id="listingTable" class="table table-bordered table-striped">
						    <thead>
						    <tr>

						        <th>
							        <div >
							        	<input name="btSelectAll" type="checkbox">
							        </div>
							        <div ></div>
						        </th>
						        <th>ACTION</th>
						        <th>PICTURE</th>
						        <th>TITLE</th>
						        <th>MENUFACTURE</th>
						        <th>MFG PART NUMBER</th>
						        <th>SKU</th>
						        <th>UPC</th>
						        <th>CONDITION</th>
						        <th>NOT LISTED QUANTITY</th>
						        <th>SALV QTY</th>
						        <th>COST</th>
						        <th>LIST PRICE</th>
						        <!-- <th>SALV VALUE</th> -->
						        <th>ITEM CODE</th>
						        <th>PURCH REF NO</th>
						        <th>AVAIL QTY</th>
						        <th>LIST QTY</th>
						        <th>BARCODE</th>
						        <!-- <th>LZ MANIFEST ID</th> -->

						    </tr>
						    </thead>
						    <tbody>
								<?php foreach ($listing as $row): ?>			
								<tr>
								
								<td>
									<div >
							        	<input name="btSelectAll" type="checkbox">
							        </div>
							        <div></div>
							    </td>
							    <td>

							<!-- <form action="<?php //echo base_url(); ?>process/c_processSeed\add\<?php //echo $row['LAPTOP_ITEM_CODE'] ?>" method="POST">
							    <button class="btn btn-primary" type="submit" name="submit" value="<?php// echo $row['LZ_MANIFEST_ID'];?>"></button>
							 </form> -->
							     <a href="<?php echo base_url(); ?>seed/c_seed/view/<?php echo $row['ITEM_ID'] ?>/<?php echo $row['LZ_MANIFEST_ID'] ?>" title="Create/Edit Seed" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
							 </td>
							
							<?php $img = $row['ITEM_PIC'];?>
								<?php if(!empty($img)):?>
																   	
								<?php $img = $row['ITEM_PIC']->load();?>
							 	<?php $pic=base64_encode($img);?>
							    <td><?php echo "<img width='50px' height='50px' src='data:image/jpeg;base64,".$pic."'/>";?></td>
								<?php else:?>
									<td><?php echo "Not found.";?></td>
								<?php endif; ?>
								<?php //var_dump($row['ITEM_MT_DESC']); ?>
							    
							    <td><?php echo $row['ITEM_TITLE'];?></td>
							    <td><?php echo $row['MANUFACTURER'];?></td>
							    <td><?php echo $row['MFG_PART_NO'];?></td>
							    <td><?php echo $row['SKU_NO'];?></td>
							    <td><?php echo $row['UPC'];?></td>
							    <td><?php echo $row['ITEM_CONDITION'];?></td>
							    <td><?php echo $row['NOT_LIST_QTY'];?></td>
							    <td><?php echo $row['SALV_QTY'];?></td>
                                <td>
                                    <?php 
                                        $cost_us = @$row['COST_US'];
                                        echo '$ '.number_format((float)@$cost_us,2,'.',',');
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $list_price = @$row['LIST_PRICE'];
                                        echo '$ '.number_format((float)@$list_price,2,'.',',');
                                    ?>
                                </td>
							    <!-- <td><?php //echo $row['SALVALUE'];?></td> -->
							    <td><?php echo $row['LAPTOP_ITEM_CODE'];?></td>
							    <td><?php echo $row['PURCH_REF_NO'];?></td>
							    <td><?php echo $row['AVAIL_QTY'];?></td>
							    <td><?php echo $row['LIST_QTY'];?></td>
							    <td><?php echo $row['IT_BARCODE'];?></td>
							    <!-- <td><?php //echo $row['LZ_MANIFEST_ID'];?></td> -->
							        

								</tr>
							<?php  
							endforeach;
							?>			
							</tbody>
						</table><br>

<!-- 						<div class="col-sm-12">
							<a href="<?php// echo base_url(); ?>listing/listing/upload_item" class="btn btn-primary">Upload List</a>

						</div>	 -->

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
<!-- End Listing Form Data -->
<?php $this->load->view('template/footer');?>