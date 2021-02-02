<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Webhook Detail
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Bundle &amp; Kit  Listing</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
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
            <div class="col-sm-12">
              <div class="col-sm-1">
                  <div class="form-group">
                    <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bk_webhook') ?>'" class="btn btn-primary ">Back</button> 
                  </div>
              </div> 
              <?php 
                $j=1;
                $sumprice=0;
                  if($webhooks->num_rows() > 0)
                  {
                   foreach ($webhooks->result() as $profile)
                   {
                    $price=$profile->PRICE;
                      $sumprice=$sumprice+$price;                                 
                    $totalno=$j++;                         
                   }
                   $avgPrice=$sumprice/$totalno; 
                 }                                  
              ?>  
              <div class="col-sm-11">
                <div class="col-sm-2 pull-right">
                 <div class="form-group">
                    <div style="font-size: 18px;">
                      <b>Average Price: </b> <?php echo '$ '.number_format((float)@$avgPrice,2,'.',','); ?>
                    </div>
                  </div>
                </div>
              </div>       
            </div>    
              <div class="col-md-12">
              <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <div class="tab-content">
                    <table id="webhookTable" class="table table-bordered table-striped " >
                    <thead>
                        <th>ACTION</th>
                        <th>WEBHOOK NAME</th>
                        <th>KIT NAME</th>
                        <th>EBAY ID</th>
                        <th>TITLE</th>
                        <th>CONDITION</th>
                        <th>SELLER</th>
                        <th>BIN/AUCTION</th>
                        <th>PRICE</th>
                        <th>START DATE </th>
                        <th>END DATE</th>
                        <th>SELER FEEDBACK</th>
                        <th>STATUS</th>
                    </thead>
                     <tbody>
                    <?php
                      $i=1;
                      if($webhooks->num_rows() > 0)
                      {
                       foreach ($webhooks->result() as $profile) {
                        /*echo "<pre>";
                        print_r($profile);
                        exit;*/
                         ?>
                         <tr>
                           <td>
                            <a title="Delete Webhook" href="<?php echo base_url().'BundleKit/c_bk_webhook/deleteWebhookDetail/'.$profile->EBAY_ID.'/'.$profile->WEBHOOK_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                            </td>
                           <td><?php echo $profile->WEBHOOK_NAME; ?></td>
                           <td><?php //echo $profile->WEBHOOK_NAME; ?></td>
                           <td><a href="<?php echo $profile->ITEM_URL; ?>"><?php echo $profile->EBAY_ID; ?></a></td>
                           <td><?php echo $profile->TITLE; ?></td>
                           <td><?php echo $profile->CONDITION_NAME; ?></td>
                           <td><?php echo $profile->SELLER_ID; ?></td>
                           <td><?php 
                                  $listing_type=$profile->LISTING_TYPE;
                                  if ($listing_type=='FixedPrice') {
                                      echo "BIN";
                                  }
                                  if ($listing_type=='StoreInventory') {
                                    echo "BIN/BEST OFFER";
                                  }
                                ?></td>
                           <td><?php echo '$ '.number_format((float)@$profile->PRICE,2,'.',','); ?></td> 
                           <td><?php echo $profile->START_TIME; ?></td>
                           <td><?php echo $profile->END_TIME; ?></td>
                           <td><?php echo $profile->FEEDBACK_SCORE; ?></td>
                           <td><?php echo $profile->STATUS; ?></td>
                                                                     
                           <?php
                           $i++;
                          echo "</tr>"; 
                         } 
                       ?>
                        </tbody> 
                      </table>
                       <?php
                      }else {
                        ?>
                   </tbody> 
                  </table>          
                  <?php
                    } 
                    ?>
                </div><!-- /.tab-content -->       
              </div><!-- nav-tabs-custom -->
              <div class="col-sm-2">
                <div class="form-group pull right">
                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bk_webhook') ?>'" class="btn btn-primary ">Back</button> 
                </div>
              </div>                     
            </div><!-- /.col -->
            <div class="col-sm-12">
              <div class="col-sm-2 pull-right">
                 <div class="form-group">
                    <div style="font-size: 18px;">
                      <b>Average Price: </b> <?php echo '$ '.number_format((float)@$avgPrice,2,'.',','); ?>
                    </div>
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
 <script type="text/javascript">
   $(document).ready(function(){
      $('#webhookTable').DataTable({
    "oLanguage": {
    "sInfo": "Total Records: _TOTAL_"
  },
  "iDisplayLength": 50,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "order": [[ 8, "desc" ]],
    // "order": [[ 16, "ASC" ]],
    "info": true,
    "autoWidth": true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
  });
   });
 </script>