<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        All Webhooks
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
                    <button class="btn btn-success saveWebhookData" >Save</button> 
                  </div>
              </div>

              <div class="col-sm-2  pull-left">
                  <div class="form-group">
                    <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bk_webhook') ?>'" class="btn btn-primary">Back</button> 
                  </div>
              </div> 
              <?php 
                $j=0;
                $sumprice=0;
                  if(@$webhooks['web_data']->num_rows() > 0)
                  {
                    //echo "<pre>";
                    //print_r($webhooks['web_data']->result_array()); exit;
                   foreach ($webhooks['web_data']->result() as $profile)
                   {

                    $price=$profile->PRICE;
                      $sumprice=$sumprice+$price;                                 
                    $j++; 
                            
                   }
                   $avgPrice=$sumprice/$j;
                 }
                 //echo $j; exit;
                  $condition_id= $this->session->userdata('webhook_condition');
                  $status= $this->session->userdata('webhook_status'); 
                  $webhook_id=$this->session->userdata('webhook_id'); 
                //if(!empty($condition_id) && !empty($status) && !empty($webhook_id))
                //{ 
                  ?>
                  <!-- <div class="col-sm-3" class="avgPrice">
                    <div class="form-group " style="font-size: 18px;">
                      <b>Average Price: </b> <?php //echo '$ '.number_format((float)@$avgPrice,2,'.',','); ?>
                    </div>
                  </div> -->  
                  <?php       
              //}               
              ?>                  
            </div> 
            <div class="col-sm-12">
              <form action="<?php echo base_url(); ?>BundleKit/c_bk_webhook/webhookFilters" method="post" accept-charset="utf-8">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="Search Webhook">Webhook Name:</label>
                      <select class="form-control selectpicker" name="webhook_list" id="webhook_list" data-live-search="true">
                      <?php //var_dump(@$tested_data['wh_names_list_qry']);exit; 

                      ?>
                      <?php 
                      foreach(@$webhooks['searchs']->result_array() as $wh_names):                  
                        
                        ?>
                        <option data-tokens="<?php echo $wh_names['WEBHOOK_NAME']; ?>" value="<?php echo $wh_names['WEBHOOK_ID']; ?>" <?php if( $webhook_id=== $wh_names['WEBHOOK_ID'] ){
                          echo "selected";
                          } ?>>
                          <?php echo $wh_names['WEBHOOK_NAME'] ?></option>

                      <?php endforeach;
                      
                      ?>
                      </select>                        
                  </div>
                </div>                
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Conditions:</label>
                    <select class="form-control" id="webhook_condition" name="webhook_condition" required>
                    <?php if($condition_id==0){ ?>
                        <option value="0" selected="selected">All</option>
                        <option value="3000">Used</option>
                        <option value="1000">New</option>
                        <option value="1500">New Other</option>
                        <option value="2000">Manufacturer Refurbished</option>
                        <option value="2500">Seller Refurbished</option>
                        <option value="7000">For Parts or Not Working</option>
                        <?php }elseif($condition_id==3000) { ?>
                        <option value="0">All</option>
                        <option value="3000" selected="selected">Used</option>
                        <option value="1000">New</option>
                        <option value="1500">New Other</option>
                        <option value="2000">Manufacturer Refurbished</option>
                        <option value="2500">Seller Refurbished</option>
                        <option value="7000">For Parts or Not Working</option>
                        <?php }elseif($condition_id==1000) { ?>
                        <option value="0">All</option>
                        <option value="3000">Used</option>
                        <option value="1000" selected="selected">New</option>
                        <option value="1500">New Other</option>
                        <option value="2000">Manufacturer Refurbished</option>
                        <option value="2500">Seller Refurbished</option>
                        <option value="7000">For Parts or Not Working</option>
                        <?php }elseif($condition_id==1500) { ?>
                        <option value="0">All</option>
                        <option value="3000">Used</option>
                        <option value="1000">New</option>
                        <option value="1500" selected="selected">New Other</option>
                        <option value="2000">Manufacturer Refurbished</option>
                        <option value="2500">Seller Refurbished</option>
                        <option value="7000">For Parts or Not Working</option>
                        <?php }elseif($condition_id==2000) { ?>
                        <option value="0">All</option>
                        <option value="3000">Used</option>
                        <option value="1000">New</option>
                        <option value="1500">New Other</option>
                        <option value="2000" selected="selected">Manufacturer Refurbished</option>
                        <option value="2500">Seller Refurbished</option>
                        <option value="7000">For Parts or Not Working</option>
                        <?php }elseif($condition_id==2500) { ?>
                        <option value="0">All</option>
                        <option value="3000">Used</option>
                        <option value="1000">New</option>
                        <option value="1500">New Other</option>
                        <option value="2000">Manufacturer Refurbished</option>
                        <option value="2500" selected="selected">Seller Refurbished</option>
                        <option value="7000">For Parts or Not Working</option>
                        <?php }elseif($condition_id==7000) { ?>
                        <option value="0">All</option>
                        <option value="3000">Used</option>
                        <option value="1000">New</option>
                        <option value="1500">New Other</option>
                        <option value="2000">Manufacturer Refurbished</option>
                        <option value="2500">Seller Refurbished</option>
                        <option value="7000" selected="selected">For Parts or Not Working</option>
                        <?php } ?>
                    </select>  
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Status:</label>
                    <select class="form-control" id="webhook_status" name="webhook_status" required>
                    <?php if($status=="All"){ ?>
                      <option value="All" selected="selected">All</option>
                      <option value="Active">Active</option>
                      <option value="Sold">Sold</option>
                      <?php }elseif($status=='Active') { ?>
                      <option value="All">All</option>
                      <option value="Active" selected="selected">Active</option>
                      <option value="Sold">Sold</option>
                      <?php }elseif($status=='Sold') { ?>
                      <option value="All">All</option>
                      <option value="Active">Active</option>
                      <option value="Sold" selected="selected">Sold</option>
                      <?php }else { ?>
                      <option value="All" selected="selected">All</option>
                      <option value="Active">Active</option>
                      <option value="Sold">Sold</option>
                   <?php } ?>
                    </select>  
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="search_webhook" id="search_webhook" value="Search">
                  </div>
                </div>
              </form>                                            
            </div> 
            <?php
            if(!empty($condition_id) && !empty($status) && !empty($webhook_id))
                { ?>
                  <div class="col-sm-2 pull-right" class="avgPrice">
                    <div class="form-group " style="font-size: 18px;">
                      <b>Average Price: </b> <?php echo '$ '.number_format((float)@$avgPrice,2,'.',','); ?>
                    </div>
                  </div>           
              <?php  
                }?>  
              <div class="col-md-12">
              <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                  <div class="tab-content">
                    <table id="webhookTable" class="table table-bordered table-striped " >
                    <thead>
                        <th></th>
                        <th>ACTION</th>
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
                        <th>UPC</th>
                        <th>MPN</th>
                        <th>MANUFACTURER</th>
                        <th>QUANTITY</th>
                    </thead>
                     <tbody>
                    <?php
                      $i=1;
                      if(@$webhooks['web_data']->num_rows() > 0)
                      {
                        //echo "<pre>";
                        //print_r($webhooks['web_data']->result_array());
                        //exit;
                       foreach (@$webhooks['web_data']->result() as $profile) {
                         ?>
                         <tr>
                         <td><input type="checkbox" name="wehookComponents" value="<?php echo $i; ?>" id="<?php echo $i; ?>">
                         </td>
                         <td>
                            <a title="Delete Webhook" href="<?php echo base_url().'BundleKit/c_bk_webhook/deleteWebhookDetail/'.$profile->EBAY_ID.'/'.$profile->WEBHOOK_ID.'/'.$condition_id.'/'.$status; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            </a>
                           </td>
                           <td id="ebayId_<?php echo $i; ?>"><a target="_blank" href="<?php echo $profile->ITEM_URL; ?>"><?php echo $profile->EBAY_ID; ?></a></td>
                           <td><?php echo $profile->TITLE; ?></td>
                           <td><?php echo $profile->CONDITION_NAME; ?></td>
                           <td><?php echo $profile->SELLER_ID; ?></td>
                           <td>
                           <?php 
                              $listing_type=$profile->LISTING_TYPE;
                              if ($listing_type=='FixedPrice') {
                                  echo "BIN";
                              }elseif ($listing_type=='StoreInventory') {
                                  echo "BIN/Best Offer";
                              }else{
                                echo $listing_type;
                              }
                            ?>                                 
                           </td>
                           <td><?php echo '$ '.number_format((float)@$profile->PRICE,2,'.',','); ?>
                           </td> 
                           <td><?php echo $profile->START_TIME; ?></td>
                           <td><?php echo $profile->END_TIME; ?></td>
                           <td class="text text-center"><?php echo $profile->FEEDBACK_SCORE; ?></td>
                           <td><?php echo $profile->STATUS; ?></td>
                           <td>
                              <input type="number" name="webhook_upc" id="webhook_upc_<?php echo $i; ?>" value="<?php echo $profile->UPC; ?>">
                           </td>
                           <td>
                              <input type="text" name="webhook_mpn" id="webhook_mpn_<?php echo $i; ?>" value="<?php echo $profile->MPN; ?>">
                           </td>
                           <td>
                            <input type="text" name="wh_manufacturer" id="wh_manufacturer_<?php echo $i; ?>" value="<?php echo $profile->MANUFACTURER; ?>">
                           </td>
                           <td>
                              <input type="number" name="wh_item_qty" id="wh_item_qty_<?php echo $i; ?>" value="<?php echo $profile->QUANTITY; ?>">
                           </td>

                            <?php if(!empty($profile->WEBHOOK_ID)){ ?>
                            <input type="hidden" name="webhook_id" id="webhook_id" value="<?php echo $profile->WEBHOOK_ID; ?>">
                            <?php 
                            }
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
              <input type="hidden" name="countRows" id="countRows" value="<?php echo $i; ?>">
               <div class="col-sm-1">
                  <div class="form-group">
                    <button class="btn btn-success saveWebhookData">Save</button> 
                  </div>
              </div>
              <div class="col-sm-2 pull-left">
                <div class="form-group ">
                  <button type="button" title="Go Back" onclick="location.href='<?php echo base_url('BundleKit/c_bk_webhook') ?>'" class="btn btn-primary ">Back</button> 
                </div>
              </div>                     
            </div><!-- /.col -->

               <?php
            if(!empty(@$condition_id) && !empty(@$status) && !empty(@$webhook_id))
                { ?>
                  <div class="col-sm-2 pull-right" class="avgPrice">
                    <div class="form-group " style="font-size: 18px;">
                      <b>Average Price: </b> <?php echo '$ '.number_format((float)@$avgPrice,2,'.',','); ?>
                    </div>
                  </div>           
              <?php  
                }?> 
          </div>
            <!-- /.box-body -->       
        </div>
          <!-- /.box -->
      </div>
        <!-- /.col -->
    </div>
      <!-- /.row -->
  </section>
  <?php 
      $this->session->unset_userdata('webhook_condition');
      $this->session->unset_userdata('webhook_status');
      $this->session->unset_userdata('webhook_id');
   ?>
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
      //"order": [[ 8, "desc" ]],
      // "order": [[ 16, "ASC" ]],
      "info": true,
      "autoWidth": true,
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>'
    });
/*******************************
* FOR SAVING UPC AND MPN
********************************/
$(".saveWebhookData").click(function(){
    //this.disabled = true;  
  var fields = $("input[name='wehookComponents']").serializeArray(); 
    if (fields.length === 0) 
    { 
        alert('Please Select at least one Component'); 
        // cancel submit
        return false;
    }  
  var arr=[];
  var url='<?php echo base_url() ?>BundleKit/c_bk_webhook/save_upc_mpn';
  var count=$("#countRows").val();
  //console.log(count); return false;
  var webhook_id=$("#webhook_id").val();
  var ebay_id=[];
  var mpn=[];
  var upc=[];
  var manufacturer=[];
  var item_qty=[];
  var tableId="webhookTable";
  var tdbk = document.getElementById(tableId);
  $.each($("#"+tableId+" input[name='wehookComponents']:checked"), function()
  {            
    arr.push($(this).val());
  }
  );
  //console.log(arr[0]); return false;
   for (var i =0; i < arr.length; i++)
      {
        ebay_id.push($("#ebayId_"+arr[i]).text());
        //upc.push($("#webhook_upc_"+arr[i]).val());
        if ($("#webhook_upc_"+arr[i]).val()=='') {
          upc.push(null); 
        }else {
          upc.push($("#webhook_upc_"+arr[i]).val());
        }
        //mpn.push($("#webhook_mpn_"+arr[i]).val());
        if ($("#webhook_mpn_"+arr[i]).val()=='') {
          mpn.push(null); 
        }else {
          mpn.push($("#webhook_mpn_"+arr[i]).val());
        }      
        
        if ($("#wh_manufacturer_"+arr[i]).val()=='') {
          manufacturer.push(null); 
        }else {
          manufacturer.push($("#wh_manufacturer_"+arr[i]).val());
        }                                   
                                          
        //item_qty.push($("#wh_item_qty_"+arr[i]).val());  
        if ($("#wh_item_qty_"+arr[i]).val()=='') {
          item_qty.push(null); 
        }else {
          item_qty.push($("#wh_item_qty_"+arr[i]).val());
        }                                 
      } 
//console.log(upc); return false;
  $.ajax({
    url:url,
    type: 'POST',
    data:{
      'webhook_id': webhook_id,
      'ebay_id': ebay_id,
      'mpn': mpn,
      'manufacturer': manufacturer,
      'item_qty': item_qty,
      'upc': upc
    },
    dataType: 'json',
    success: function (data) {
         if(data != ''){
           window.location.href = '<?php echo base_url(); ?>BundleKit/c_bk_webhook/getAllWebhooks';
               //alert("data is inserted");    
         }else{
           alert('Error: Fail to insert data');
         }
       }
  });
});
   });
 </script>