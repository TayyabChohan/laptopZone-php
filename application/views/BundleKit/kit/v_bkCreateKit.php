<?php $this->load->view('template/header');?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Create Kit 
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
          <h3 class="box-title">Item Search Form</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
    <?php if($this->session->flashdata('warning')){  ?>
          <div class="alert alert-warning">
              <a href="#" class="close" data-dismiss="alert">&times;</a>
              <strong>Warning:</strong> <?php echo $this->session->flashdata('warning'); ?>
          </div>
        <?php } ?>
      <div class="col-sm-12">
      <form action="<?php echo base_url();?>BundleKit/c_advanceCategories/showDataForKit" method="post">
        <div class="row">
          <div class="form-group col-sm-3">
            <label for="kit_name">Kit Name:</label>
            <input class="form-control" type="text" name="kit_name" value="<?php if(isset($_POST['kit_name'])){echo $_POST['kit_name'];}; ?>" required="required">
          </div>
        </div>
         <div class="row">
          <?php 
                if($components->num_rows() > 0)
                      {
                          $proarray=$components->result_array();
                          $item_name=$proarray[0]['LZ_BK_ITEM_DESC'];
                          $profile_id=$proarray[0]['LZ_BK_ITEM_ID'];
                        }
            ?>
          <div class="form-group col-sm-3">
            <label for="item_template">items:</label>
            <select name="bk_kit_item" class="form-control" required="required" id="bk_kit_item">
              <option value="<?php echo $profile_id; ?>" id="bk_kit_name"> <?php echo $item_name; ?> </option>
            </select>
          </div>
        </div>
        <div class="row form-group col-sm-12" style="display: none;">
          <input class="btn btn-primary" type="submit" name="craete_kit" id="craete_kit">
        </div>
          </form> 
            <?php 
                if($components->num_rows() > 0)
                      { 
                        ?>
                  <table id="notListed" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                     <th>ACTION</th>
                      <th>SR. NO</th>
                      <th>#</th>
                      <th>COMPONENT NAME</th>
                      <th>EBAY ID</th>
                      <th>ITEM DESC</th>
                      <th>MANUFACTURER</th>                                                             
                      <th>CATEGORY ID</th>
                      <th>CATEGORY NAME</th> 
                      <th>QTY</th>                     
                      <th>MPN</th>
                      <th>UPC</th>
                      <th>ACTIVE PRICE</th>
                      <th>MANUALE PRICE</th>
                      <th>TOTAL PRICE</th>
                  </thead>
                  <tbody>
                      <?php
                      $totalQty=0;
                      $priceSummary=0;
                      $totalPrice=0;
                      $i=1;
                      if($components->num_rows() > 0)
                      {
                       foreach ($components->result() as $profile) {
                        /*echo "<pre>";
                        print_r($templates->result());
                        exit;*/
                         ?>
                         <tr>
                          <td>
                            <div class="del_button">
                                <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_advanceCategories/deleteComponent/'.$profile->LZ_BK_ITEM_DET_ID.'/'.$profile->LZ_BK_ITEM_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </a>
                            </div> 
                         </td>
                          <?php $manualPrice=$profile->MANUAL_PRICE;
                                $activePrice=$profile->ACTIVE_PRICE; ?>
                         <td><?php echo $i; ?></td>
                         <td><input type="checkbox" name="save_component" value="<?php echo $i; ?>" id="<?php echo $i; ?>"></td>
                         <td><?php echo $profile->LZ_COMPONENT_DESC; ?></td> 
                         <td><?php echo $profile->EBAY_ITEM_ID; ?></td>
                         <td><?php echo $profile->ITEM_DESC; ?></td>
                         <td><?php echo $profile->ITEM_MANUFACTURER; ?></td> 
                                                
                         <td><?php echo $profile->CATEGORY_ID; ?></td>
                         <td><?php echo $profile->CATEGORY_NAME; ?></td>
                         <td><?php echo $profile->QUANTITY; ?></td> 
                         <td><input type="text" name="bk_kit_mpn" value="<?php echo $profile->ITEM_MPN; ?>"></td>
                         <td><?php echo $profile->ITEM_UPC; ?></td>                      
                         <td><?php
                         if(!empty($activePrice)){
                          echo '$ '.number_format((float)@$profile->ACTIVE_PRICE,2,'.',',');
                          } ?></td> 
                         <td><?php 
                         if(!empty($manualPrice)){
                          echo '$ '.number_format((float)@$profile->MANUAL_PRICE,2,'.',',');
                          }
                           ?></td> 
                            <?php
                                $qty=$profile->QUANTITY;
                                $totalQty+=$qty;
                                if (!empty($manualPrice)) {
                                  $totalPrice=$manualPrice*$qty;
                                }else{
                                  $totalPrice=$activePrice*$qty;
                                }

                                $priceSummary+=$totalPrice;
                             ?>
                         <td><?php 
                         if(!empty($totalPrice)){
                          echo '$ '.number_format((float)@$totalPrice,2,'.',',');
                          }   ?></td> 

                         <?php
                         $i++;
                        echo "</tr>"; 
                       } 
                      }
                       
                      ?>
                    </tbody>                   
                    </table>
                  <?php
                      }
                      ?>
      </div>    
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
