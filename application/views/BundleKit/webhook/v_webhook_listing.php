<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Webhooks Listing
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Webhook</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box"><br>
            <div class="col-sm-12">
               <div class="col-sm-2">
                <div class="form-group pull-left">
                  <button type="button" title="Add Webhook" onclick="location.href='<?php echo base_url('BundleKit/c_bk_webhook/showWebhookForm') ?>'" class="btn btn-success ">Add Webhook</button>
                </div>
              </div>
              <div class="col-sm-2 col-sm-offset-8">
                <div class="form-group pull-right">      
                 <button type="button" title="Webhook Detail" onclick="location.href='<?php echo base_url('BundleKit/c_bk_webhook/getAllWebhooks') ?>'" class="btn btn-success ">Webhook Detail</button>
                </div>
            </div>
          </div>
                 
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
              <!-- Custom Tabs -->
                <table id="webhookListingTable" class="table table-responsive table-striped table-bordered table-hover">
                  <thead>
                      <th>ACTIONS</th>
                      <th>TOTAL ITEMS</th>
                      <th>KIT ID</th>
                      <th>WEBHOOK NAME</th>
                      <th>KEYWORD</th>
                      <th>CATEGORY ID</th>
                    <!--   <th>MAIN CATEGORY</th>
                    <th>SUB CATEGORY</th> -->
                      <th>CATEGORY NAME</th>
                      <th>CONDITION</th>
                      <th>CREATE DATE</th>
                      <th>EDIT BY</th>
                  </thead>
                  <tbody>
                      <?php
                      //
                        //echo "<pre>";
                        //print_r($webhooks['kit_query']->result_array());
                        //exit;

                      if ($webhooks['kit_query']->num_rows() > 0 || $webhooks['webhook_query']->num_rows() > 0) {
                         if($webhooks['kit_query']->num_rows() > 0)
                      {
                        //echo "<pre>";
                        //print_r($webhooks['kit_query']->result_array());
                        //exit;
                        $i=0;
                       foreach ($webhooks['kit_query']->result_array() as $profile) {
                        // echo "<pre>";
                        // print_r($profile);
                        // exit;
                         ?>
                         <tr>
                         <td>
                            <div class="edit_btun" style="width: 90px; height: auto;">
                             <!-- <a title="Edit Template" href="<?php //echo base_url().'BundleKit/c_CreateComponent/editTemplateDetail/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                </a> -->
                              <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bk_webhook/deleteWebhook/'.$profile['WEBHOOK_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </a>
                              <a href="<?php echo base_url().'BundleKit/c_bk_webhook/webhookDetail/'.$profile['WEBHOOK_ID']; ?>" id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="" title="Show Detail">
                             <i style="font-size: 28px; cursor: pointer; padding: 0;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                              </a>
                              <a title="Pull Data" href="<?php echo base_url().'BundleKit/c_bk_webhook/pullWebhookData/'.$profile['WEBHOOK_ID']; ?>" class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i>
                              </a>
                            </div> 
                         </td>
                          <td class="text text-center"><?php
                           $total_items=$webhooks['webhooks_data'][$i];
                            if(!empty($total_items))
                              {
                                echo $total_items;
                              }else{
                                echo 0;
                                } ?>                               
                            </td>
                           <td><?php echo $profile['KIT_ID']; ?></td>
                           <td><?php echo $profile['LZ_BK_KIT_DESC']; ?></td>
                           <td><?php echo $profile['KIT_KEYWORD']; ?></td>
                           <td><?php echo $profile['CATEGORY_ID']; ?></td>
                           <!-- <td><?php //echo $profile->MAIN_CATEGORY; ?></td>
                           <td><?php //echo $profile->SUB_CATEGORY; ?></td> -->
                           <td><?php echo $profile['CATEGORY_NAME']; ?></td>
                           <td>
                           <?php echo "All"; ?></td>
                           <td><?php //echo $profile->CREATE_DATE; ?></td>                                            
                           <td><?php //echo $profile->CREATE_DATE; ?></td>                                            
                           <?php
                           $i++;
                          echo "</tr>"; 
                         } 
                       
                      }
                      if($webhooks['webhook_query']->num_rows() > 0){
                        $j=0;
                        foreach ($webhooks['webhook_query']->result_array() as $profile) {
                        // echo "<pre>";
                        // print_r($profile);
                        // exit;
                         ?>
                         <tr>
                         <td>
                            <div class="edit_btun" style=" width: 90px; height: auto;">
                             <!--  <a title="Edit Template" href="<?php //echo base_url().'BundleKit/c_CreateComponent/editTemplateDetail/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span>
                                </a> -->
                              <a title="Delete Template" href="<?php echo base_url().'BundleKit/c_bk_webhook/deleteWebhook/'.$profile['WEBHOOK_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                              </a>
                              <a href="<?php echo base_url().'BundleKit/c_bk_webhook/webhookDetail/'.$profile['WEBHOOK_ID']; ?>" id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="" title="Show Detail">
                               <i style="font-size: 28px; cursor: pointer; padding: 0;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                              </a>
                              <a title="Pull Data" href="<?php echo base_url().'BundleKit/c_bk_webhook/pullWebhookData/'.$profile['WEBHOOK_ID']; ?>" class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i>
                              </a>
                            </div> 
                         </td>
                           <td class="text text-center"><?php
                           $total_items=$webhooks['webhooks_data'][$j];
                            if(!empty($total_items))
                              {
                                echo $total_items;
                              }else{
                                echo 0;
                                } ?>                               
                            </td>
                           <td><?php echo $profile['KIT_ID']; ?></td>
                           <td><?php echo $profile['WEBHOOK_NAME']; ?></td>
                           <td><?php echo $profile['WEBHOOK_KEYWORDS']; ?></td>
                           <td><?php echo $profile['CATEGORY_ID']; ?></td>
                           <!-- <td><?php //echo $profile->MAIN_CATEGORY; ?></td>
                           <td><?php //echo $profile->SUB_CATEGORY; ?></td> -->
                           <td><?php echo $profile['CATEGORY_NAME']; ?></td>
                           <td>
                            <?php $condition=$profile['CONDITION_ID'];
                              if ($condition==3000){
                                echo "Used";
                              }elseif ($condition==1000) {
                                echo "New";
                              }elseif ($condition==1500) {
                                echo "New Other";
                              }elseif ($condition==2000) {
                                echo "Manufacturer Refurbished";
                              }elseif ($condition==2500) {
                                echo "Seller Refurbished";
                              }elseif ($condition==7000) {
                                echo "For Parts or Not Working";
                              }elseif ($condition==0) {
                                echo "All";
                              }
                            ?>                              
                            </td>
                           <td><?php //echo $profile->CREATE_DATE; ?></td>                                            
                           <td><?php //echo $profile->CREATE_DATE; ?></td>                                            
                           <?php
                           $j++;
                          echo "</tr>"; 
                         } 
                       
                      } ?> 
                       </tbody> 
                  </table>
                      <?php }else{ ?>
                         </tbody> 
                  </table>
                      <?php } ?>
              </div>
                <!-- /.col --> 
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
      $('#webhookListingTable').DataTable({
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