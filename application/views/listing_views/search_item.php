<?php $this->load->view('template/header'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search Item
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search Item</li>
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

                            <form action="<?php echo base_url(); ?>listing/listing_search" method="post" accept-charset="utf-8">
                                <div class="col-sm-8">
                                    <h4><strong>Search Item</strong></h4>
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="search" value="" placeholder="Search Item">
                                    </div>                                     
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group p-t-40">
                                        <input type="submit" class="btn btn-primary" name="Submit" value="Search">
                                    </div>
                                </div>                                 
                            </form>
                        </div>
                        </div>  

                        <!-- <table id="searchResults" class="table table-bordered table-striped"> -->
                    <div class="box">    
                    <div class="box-body form-scroll">
                        <form id="upload_item" action="<?php echo base_url(); ?>listing/listing/upload_item" onsubmit="return checkboxVal();" method="post" target="_blank">

                        <?php 
                        if(empty($data)){
                            break;
                        }

                        foreach ($data as $row): ?>
                                <input type="hidden" style="display:none;" name="<?php echo $row['ITEM_ID'];?>" value="<?php echo @$row['LZ_MANIFEST_ID']; ?>">
                        <?php endforeach;?>         

                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>

                                <th class="bs-checkbox " style="width: 36px;">
                                    <div class="th-inner ">
                                        <input name="btSelectAll" type="checkbox" onClick="toggle(this)" />
                                    </div>
                                </th>
                                <th>ACTION</th>
                                <th>PICTURE</th>
                                <th>INPUT QTY</th>
                                <th>LIST QTY</th>
                                <th>AVAIL QTY</th>
                                <th>TITLE</th>
                                <th>MANU- FACTURE</th>
                                <th>MPN</th>
                                <th>SKU</th>
                                <th>UPC</th>
                                <th>CONDITION</th>
                                <th>NOT LISTED QTY</th>
                                <th>SALV QTY</th>
                                <th>COST</th>
                                <th>LIST PRICE</th>
                                <th>SALV VALUE</th>
                                <th>ITEM CODE</th>
                                <th>PURCH REF NO</th>
                                <th>MANIFEST ID</th>
                                <th>BARCODE</th>

                            </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($data as $row): ?>
                                         
                                <tr>
                                
                                <td>
                                    <div class="th-inner ">
                                        <input name="selected_item[]" id="selected_item" type="checkbox" value="<?php echo $row['ITEM_ID'];?>" <?php if(@$row['AVAIL_QTY'] - (@$row['LIST_QTY'] + @$row['SALVALUE'])==0){echo 'disabled';}?> >
                                    </div>
                                    <div class="fht-cell"></div>
                                </td>
                                <td>

                                 <a title="Create/Edit Seed" href="<?php echo base_url(); ?>seed/c_seed/view/<?php echo $row['ITEM_ID'] ?>/<?php echo $row['LZ_MANIFEST_ID'] ?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-leaf" aria-hidden="true"></span></a>
                             </td>
                            
                            <?php $img = @$row['ITEM_PIC'];?>
                                <?php if(!empty($img)):?>
                                                                    
                                <?php $img = @$row['ITEM_PIC']->load();?>
                                <?php $pic=base64_encode(@$img);?>
                                <td><?php echo "<img width='50px' height='50px' src='data:image/jpeg;base64,".@$pic."'/>";?></td>
                                <?php else:?>
                                    <td><?php echo "Not found.";?></td>
                                <?php endif; ?>
                               <td><input class="lst-qty" type="number" id="list_quantity" min="1" max="<?php echo @$row['NOT_LIST_QTY'];?>" name="<?php echo @$row['LZ_MANIFEST_ID'].@$row['ITEM_ID'];?>" value="<?php echo @$row['NOT_LIST_QTY'];?>" <?php if(@$row['NOT_LIST_QTY']==0){echo "readonly";} ?>></td>
                                <td><?php echo @$row['LIST_QTY'];?></td>
                                <td><?php echo @$row['AVAIL_QTY'];?></td>
                                <td><?php echo @$row['ITEM_TITLE'];?></td>
                                <td><?php echo @$row['MANUFACTURER'];?></td>
                                <td><?php echo @$row['MFG_PART_NO'];?></td>
                                <td><?php echo @$row['SKU_NO'];?></td>
                                <td><?php echo @$row['UPC'];?></td>
                                <td><?php 
                                if(@$row['ITEM_CONDITION'] == 3000){
                                    echo "Used";
                                }elseif(@$row['ITEM_CONDITION'] == 1000){
                                    echo "New";
                                }elseif(@$row['ITEM_CONDITION'] == 1500){
                                    echo "New other";
                                }elseif(@$row['ITEM_CONDITION'] == 2000){
                                    echo "Manufacturer refurbished";
                                }elseif(@$row['ITEM_CONDITION'] == 2500){
                                    echo "Seller refurbished";
                                }elseif(@$row['ITEM_CONDITION'] == 4000){
                                    echo "Very Good";
                                }elseif(@$row['ITEM_CONDITION'] == 5000){
                                    echo "Good";
                                }elseif(@$row['ITEM_CONDITION'] == 6000){
                                    echo "Acceptable";
                                }else{
                                    echo @$row['ITEM_CONDITION'];
                                }?></td>
                                <td><?php echo @$row['NOT_LIST_QTY'];?></td>
                                <td><?php echo @$row['SALV_QTY'];?></td>
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
                                <td>
                                    <?php 
                                    $salvalue = @$row['SALVALUE'];
                                    echo '$ '.number_format((float)@$salvalue,2,'.',',');
                                    ?>
                                    
                                </td>
                                <td><?php echo @$row['LAPTOP_ITEM_CODE'];?></td>
                                <td><?php echo @$row['PURCH_REF_NO'];?></td>
                                <td><?php echo @$row['LZ_MANIFEST_ID'];?></td>
                                <td><?php echo $row['IT_BARCODE'];?></td>
                                    

                                </tr>
                            <?php  
                            endforeach;
                            ?>
                                     
                            </tbody>
                        </table><br>


                        <!--<div class="col-sm-12">
                          <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                        <div id="errorMsg" class="text-danger">
                        <?php 
                            // To disable invalid argument supplied for foreach()
                            //if (is_array(@$errorMsg) || is_object(@$errorMsg))
                            //{
                             //   foreach (@$errorMsg as $msg) {
                                    # code...
                              //      echo @$msg;
                                //} 
                            //} ?>
                        </div>
                        <div id="successMsg" class="text-success">
                        <?php 
                            // To disable invalid argument supplied for foreach()
                           // if (is_array(@$successMsg) || is_object(@$successMsg))
                            //{
                              //  foreach (@$successMsg as $msg) {
                                    # code...
                                //    echo @$msg;
                               // } 
                            //} ?>
                        </div>
                        </div>-->                        
                
                    </form>
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
 <?php $this->load->view('template/footer'); ?>