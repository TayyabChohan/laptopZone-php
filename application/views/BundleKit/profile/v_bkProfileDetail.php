<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profile Deatil
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bundle &amp; Kit  Listing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
        
        <div class="box">
          <div class="box-body form-scroll">
            
                  <?php if($this->session->flashdata('success')){ ?>
                      <div class="alert alert-success">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                      </div>
                  <?php }else if($this->session->flashdata('error')){  ?>
                      <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                      </div>
                  <?php }else if($this->session->flashdata('warning')){  ?>
                      <div class="alert alert-warning">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('warning'); ?>
                      </div>
                  <?php }else if($this->session->flashdata('compo')){  ?>
                      <div class="alert alert-danger">
                          <a href="#" class="close" data-dismiss="alert">&times;</a>
                          <strong>Error!</strong> <?php echo $this->session->flashdata('compo'); ?>
                      </div>
                  <?php } ?>     
            <div class="col-md-12">

              <?php 
                if($components->num_rows() > 0)
                      {
                       $proarray=$components->result_array();
                         $item_name=$proarray[0]['LZ_BK_ITEM_DESC'];
                         $item_name= str_replace("_", '/', $item_name);
                          $item_name = str_replace("'", '', $item_name);
                          $template_name=$proarray[0]['ITEM_TYPE_DESC'];
                          $mpn=$proarray[0]['MPN'];
                          $upc=$proarray[0]['UPC'];
                          $profile_id=$proarray[0]['LZ_BK_ITEM_ID'];
                          $template_id=$proarray[0]['LZ_BK_ITEM_TYPE_ID'];

                          $categoryId=$proarray[0]['CATEGORY_ID'];
                          $main_category=$proarray[0]['MAIN_CATEGORY'];
                          $sub_category=$proarray[0]['SUB_CATEGORY'];
                          $category_name=$proarray[0]['CATEGORY_NAME'];

                          //var_dump($template_id); exit;
                        ?>
                      <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>Item Name: </b><?php echo @$item_name; ?>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>Template Name: </b><?php echo @$template_name; ?>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>MPN: </b><?php echo @$mpn;  ?>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>UPC: </b><?php echo @$upc; ?>
                          </div>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>Category Id: </b><?php echo @$categoryId; ?>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>Main Category: </b><?php echo @$main_category; ?>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>Sub Category: </b><?php echo @$sub_category;  ?>
                          </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group" style="font-size: 15px;">
                            <b>Category Name: </b><?php echo @$category_name; ?>
                          </div>
                        </div>
                      </div>
                   <?php
                      }
                           
                   ?>
                  </div>
                <div class="col-md-12">
                <div class="col-sm-2">
                  <div class="form-group pull right">
                    <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkProfiles') ?>'" class="btn btn-primary ">Back</button> 
                  </div>
              </div>
              </div>   
                <div class="col-md-12">   
                <table id="profileDetailTable" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                      <th>ACTION</th>
                      <th>SR. NO</th>
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
	                              <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bkProfiles/deleteProfileComponent/'.$profile->LZ_BK_ITEM_DET_ID.'/'.$profile->LZ_BK_ITEM_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	                            </a>
                            </div> 
                         </td>
                          <?php 
                            $manualPrice=$profile->MANUAL_PRICE;
                            $activePrice=$profile->ACTIVE_PRICE;
                          ?>
                         <td><?php echo $i; ?></td>
                         <td><?php echo $profile->LZ_COMPONENT_DESC; ?></td> 
                         <td><?php echo $profile->EBAY_ITEM_ID; ?></td>
                         <td><?php echo $profile->ITEM_DESC; ?></td>
                         <td><?php echo $profile->ITEM_MANUFACTURER; ?></td>                                          <td><?php echo $profile->CATEGORY_ID; ?></td>
                         <td><?php echo $profile->CATEGORY_NAME; ?></td>
                         <td><?php echo $profile->QUANTITY; ?></td> 
                         <td><?php echo $profile->ITEM_MPN; ?></td>
                         <td><?php echo $profile->ITEM_UPC; ?></td>                      
                         <td><?php
                           if(!empty($activePrice)){
                            echo '$ '.number_format((float)@$profile->ACTIVE_PRICE,2,'.',',');
                            } ?>                      
                        </td> 
                         <td>
                         <?php 
                         if(!empty($manualPrice)){
                          echo '$ '.number_format((float)@$profile->MANUAL_PRICE,2,'.',',');
                          }
                           ?></td> 
              							<?php
              								  $qty=$profile->QUANTITY;
              								  $totalQty+=$qty;
              								  if (!empty($manualPrice)){
              								  	$totalPrice=$manualPrice*$qty;
              								  }else{
              								  	$totalPrice=$activePrice*$qty;
              								  }
              								  $priceSummary+=$totalPrice;
              						?>
                         <td><?php 
                         if(!empty($totalPrice)){
                          echo '$ '.number_format((float)@$totalPrice,2,'.',',');
                          }   ?>                            
                          </td> 

                         <?php
                         $i++;
                        echo "</tr>"; 
                       } ?>
                      </tbody>                   
                    </table><br>
                      <?php }else { ?>
                      </tbody>                   
                    </table><br> 
                      <?php } ?>
               

                     <div class="form-group col-sm-2">
                          <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bkProfiles/bkTemplateUpdation/'.@$template_id) ?>'" class="btn btn-primary ">Edit Template</button>
                      </div>
                          <form action="<?php echo base_url().'BundleKit/c_bkProfiles/bk_addMoreComponents/'.@$profile_id; ?>" method="post">
                            <div class="col-sm-5">
                              <div class="col-sm-1">
                                <div class="form-group">
                                <input class="form-control" type="hidden" name="profile_name" value="<?php echo @$item_name; ?>" required="required">
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="item_upc" name="profile_upc" value="<?php echo @$upc; ?>" >
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="item_mpn" name="profile_mpn" value="<?php echo @$mpn; ?>">
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="template_name" name="profile_template" value="<?php echo @$template_name; ?>" >
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="categoryId" name="categoryId" value="<?php echo @$categoryId; ?>" >
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="main_category" name="main_category" value="<?php echo @$main_category; ?>" >
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="sub_category" name="sub_category" value="<?php echo @$sub_category; ?>" >
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="hidden" id="category_name" name="category_name" value="<?php echo @$category_name; ?>" >
                              </div>
                              <div class="form-group ">
                                <input class="form-control" type="hidden" id="template_id" name="template_id" value="<?php echo @$template_id; ?>" >
                              </div>
                            </div>               
                            <div class="form-group">
                              <div class="col-sm-2  pull-left">
                                <input class="btn btn-primary" type="submit" name="edit_rofile" id="submit_query" value="Add Cmponents">
                              </div> 
                            </div>
                          </div>
                        </form>                 
              				<div class="col-sm-2">
              					<div class="form-group" style="font-size: 18px; margin-left: 40px;">
		                    		<b>Total Qty = </b><?php echo @$totalQty; ?>
		                    	</div>
              				</div>
	                    	<div class="col-sm-3">
		                    		<div class="form-group" style="font-size: 18px;">
                              
                            
		                    			<b>Price Summary = </b><?php if(!empty(@$priceSummary))
                              {
                                echo '$ '.number_format((float)@$priceSummary,2,'.',',');
                              } ?>
		                    		</div>
	                    	</div>
                        <div class="col-sm-12">
                        <div class="form-group" style="font-size: 14px;">
                           <label >Note: </label>
                           <i>Manual price is prefferd over active price in Price Summary</i>
                          </div>
                      </div>
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
<!-- End Listing Form Data -->
 <?php $this->load->view('template/footer'); ?>
 <script>
$(document).ready(function()
  {
     $('#profileDetailTable').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
          
});
</script>