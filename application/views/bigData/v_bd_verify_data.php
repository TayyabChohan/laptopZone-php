<?php $this->load->view('template/header'); 
      ini_set('memory_limit', '-1'); // add for picture loading issue
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Search &amp; Recognize Data
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Search &amp; Recognize Data</li>
      </ol>
    </section>  
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">      
            <div class="box-body"> 
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
            <!-- </div> --> 
             <?php 
                /*echo "<pre>";
                print_r($getCategories);
                exit;*/
              ?> 
            <div class="col-sm-12">
              <form action="<?php echo base_url(); ?>bigData/c_bd_recognize_data/search_verified_data" method="post" accept-charset="utf-8">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="Search Webhook">Search:</label>
                      <input type="text" name="bd_search" class="form-control" value="<?php echo $this->session->userdata('search_key'); ?>">                      
                  </div>
                </div> 
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Conditions" class="control-label">Category:</label>
                    <select name="bd_category" class="form-control selectpicker" required="required" data-live-search="true">
                      <option value="">---</option>
                      <?php                                
                         if(!empty($getCategories)){
                          foreach ($getCategories as $cat){
                              ?>
                              <option value="<?php echo $cat['CATEGORY_ID']; ?>" <?php if($this->session->userdata('category_id') == $cat['CATEGORY_ID']){echo "selected";}?>> <?php echo $cat['CATEGORY_NAME'].'-'.$cat['CATEGORY_ID']; ?>
                              </option>
                              <?php
                              } 
                          }
                      ?>  
                                          
                    </select>  
                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group p-t-24">
                    <input type="submit" class="btn btn-primary btn-sm" name="bd_submit" id="bd_submit" value="Search">
                  </div>
                </div>

              </form>                                            
            </div>


          </div>
            <!-- /.box-body -->       
        </div>
          <!-- /.box -->
          <?php if(!empty(@$data)):?> 
        <div class="box">
          <div class="box-body form-scroll">
             
            <div class="col-sm-12">

                    <table id="recognizeData" class="table table-responsive table-striped table-bordered table-hover" >
                    <thead>
                        <th>
                          <div style="width: 80px!important;">
                            <input class="" name="btSelectAll" type="checkbox" onclick="toggle(this)">&nbsp;Select All
                          </div>
                        </th>
                        <th>ACTION</th>
                        <th>CATEGORY NAME</th>
                        <th>CATEGORY ID</th>
                        <th>EBAY ID</th>
                        <th>TITLE</th>
                        <th>CONDITION</th>
                        <th>SELLER</th>
                        <th>BIN/AUCTION</th>
                        <th>PRICE</th>
                        <th>START DATE </th>
                        <th>END DATE</th>
                        <th>SELER FEEDBACK</th>
                        
                    </thead>
                     <tbody>
                <?php foreach ($data as $value):?>
              
                        <tr>
                        <td>
                           <div class="edit_btun" style=" width: 90px; height: auto;">
                               <!--  <a title="Edit Template" href="<?php //echo base_url().'BundleKit/c_CreateComponent/editTemplateDetail/'.$row->LZ_BK_ITEM_TYPE_ID; ?>" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil p-b-5" aria-hidden="true"></span> </a> -->
                                <!-- <a title="Delete Template" href="<?php //echo base_url().'BundleKit/c_bkProfiles/deleteProfile/'.$profile->LZ_BK_ITEM_ID; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                </a> -->
                                <a href="<?php echo base_url().'bigData/c_bd_recognize_data/verifyData/'.$value['CATEGORY_NAME'] ?>" id="<?php //echo $key['LZ_TEST_MT_ID']; ?>" class="" title="Show Detail">
                                <i style="font-size: 28px; cursor: pointer; padding: 0;" class="fa fa-external-link pull-right" aria-hidden="true"></i>
                                </a>
                              </div> 
                        </td>
                           <td>
                            <div style="width: 80px!important;">

                              <div style="float:left;margin-right:8px;">
                                <input title="Select atleast one" type="checkbox" name="select_recognize[]" id="select_recognize" value="<?php //echo $row['SEED_ID']; ?>">
                              </div>                      

                            </div>                             
                           </td>
                           <td><?php echo $value['CATEGORY_NAME']; ?></td>
                           <td><?php echo $value['CATEGORY_ID']; ?></td>
                           <td><?php echo $value['EBAY_ID']; ?></td>
                           <td><?php echo $value['TITLE']; ?></td>
                           <td><?php echo $value['CONDITION_NAME']; ?></td>
                           <td><?php echo $value['SELLER_ID']; ?></td>
                           <td><?php echo $value['LISTING_TYPE']; ?></td>
                           <td><?php echo '$ '.number_format((float)@$value['SALE_PRICE'],2,'.',','); ?>
                           </td> 
                           <td><?php echo $value['START_TIME']; ?></td>
                           <td><?php echo $value['SALE_TIME']; ?></td>
                           <td class="text text-center"><?php echo $value['FEEDBACK_SCORE']; ?></td>
                           
                        </tr>
                <?php endforeach;?>        
                   </tbody> 
                  </table>          

              <!-- <input type="hidden" name="countRows" id="countRows" value="<?php //echo $i; ?>"> -->
              <div class="col-sm-1">
                <div class="form-group">
                  <button class="btn btn-success saveWebhookData">Recognize All</button> 
                </div>
              </div>                    
            </div><!-- /.col -->
                     
          </div>
        </div>
        <?php endif; ?> 

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
    $('#recognizeData').DataTable({
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
// /*******************************
// * FOR SAVING UPC AND MPN
// ********************************/
// $(".saveWebhookData").click(function(){
//     //this.disabled = true;  
//   var fields = $("input[name='wehookComponents']").serializeArray(); 
//     if (fields.length === 0) 
//     { 
//         alert('Please Select at least one Component'); 
//         // cancel submit
//         return false;
//     }  
//   var arr=[];
//   var url='<?php //echo base_url() ?>BundleKit/c_bk_webhook/save_upc_mpn';
//   var count=$("#countRows").val();
//   //console.log(count); return false;
//   var webhook_id=$("#webhook_id").val();
//   var ebay_id=[];
//   var mpn=[];
//   var upc=[];
//   var manufacturer=[];
//   var item_qty=[];
//   var tableId="recognizeData";
//   var tdbk = document.getElementById(tableId);
//   $.each($("#"+tableId+" input[name='wehookComponents']:checked"), function()
//   {            
//     arr.push($(this).val());
//   }
//   );
//   //console.log(arr[0]); return false;
//    for (var i =0; i < arr.length; i++)
//       {
//         ebay_id.push($("#ebayId_"+arr[i]).text());
//         //upc.push($("#webhook_upc_"+arr[i]).val());
//         if ($("#webhook_upc_"+arr[i]).val()=='') {
//           upc.push(null); 
//         }else {
//           upc.push($("#webhook_upc_"+arr[i]).val());
//         }
//         //mpn.push($("#webhook_mpn_"+arr[i]).val());
//         if ($("#webhook_mpn_"+arr[i]).val()=='') {
//           mpn.push(null); 
//         }else {
//           mpn.push($("#webhook_mpn_"+arr[i]).val());
//         }      
        
//         if ($("#wh_manufacturer_"+arr[i]).val()=='') {
//           manufacturer.push(null); 
//         }else {
//           manufacturer.push($("#wh_manufacturer_"+arr[i]).val());
//         }                                   
                                          
//         //item_qty.push($("#wh_item_qty_"+arr[i]).val());  
//         if ($("#wh_item_qty_"+arr[i]).val()=='') {
//           item_qty.push(null); 
//         }else {
//           item_qty.push($("#wh_item_qty_"+arr[i]).val());
//         }                                 
//       } 
// //console.log(upc); return false;
//   $.ajax({
//     url:url,
//     type: 'POST',
//     data:{
//       'webhook_id': webhook_id,
//       'ebay_id': ebay_id,
//       'mpn': mpn,
//       'manufacturer': manufacturer,
//       'item_qty': item_qty,
//       'upc': upc
//     },
//     dataType: 'json',
//     success: function (data) {
//          if(data != ''){
//            window.location.href = '<?php //echo base_url(); ?>BundleKit/c_bk_webhook/getAllWebhooks';
//                //alert("data is inserted");    
//          }else{
//            alert('Error: Fail to insert data');
//          }
//        }
//   });
// });
   });
 </script>