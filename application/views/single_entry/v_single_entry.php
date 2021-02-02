<?php $this->load->view("template/header_copy.php"); 
//  $lz_manifest_id = @$this->session->get_userdata("lz_manifest_id");
// @$this->session->unset_userdata("lz_manifest_id"); 
?>

<style type="text/css">
  
  .custom {
    width: 160px !important;
}
</style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Single Entry Form
        <small>Control panel</small>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url();?>dashboard/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Single Entry Form</li>
      </ol>
    </section> 
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Single Entry Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="col-sm-10">
              
            </div>
            <div class="col-sm-2">
              <div class="form-group pull-right">
                <a style="text-decoration: underline;" href="<?php echo base_url('tolist/c_tolist/lister_view'); ?>" title="Go to Item Listing" target="_blank">Item Listing</a>
              </div>
            </div>

              <form action="<?php echo base_url().'single_entry/c_single_entry/add'; ?>" method="post" id = "myForm" target="_blank" accept-charset="utf-8"> 

          <?php //echo form_open('single_entry/c_single_entry/add', 'role="form"'); ?>

          <div class="row">
          <div class="col-sm-12">
                  <?php ?>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="Loading No" class="control-label">Loading No:</label>
                

                  <!-- <input type="number" class="form-control" id="loading_no" name="loading_no" value="<?php //echo @ $auto_num[0]['LOADING_NO']+1; ?>" readonly> -->
                  <input type="number" class="form-control" id="loading_no" name="loading_no" value="<?php echo @$auto_num['load_num']; ?>" readonly>
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label for="User" class="control-label">User:</label>
                <?php $emp_name = $this->session->userdata('employee_name');?>
                  <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo $emp_name;?>" readonly>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="form-group">
                <label for="">Purchase Ref:</label>
                <?php
                      // $purch_ref = $auto_num[0]['PURCHASE_REF_NO'];
                      // $str = explode('-', $purch_ref);
                      // if(count($str) > 1){
                      //   $last_num = end($str);
                      //   $date = date('d-M-y');
                      //   $current_date = strtoupper($date);
                      //   $last_date = $str[0].'-'.$str[1].'-'.@$str[2];
                      //   if($last_date == $current_date){
                      //    $count = $last_num + 1;
                      //    $purch_ref = strtoupper($date.'-'. $count);
                      //   }else{
                      //    $purch_ref = strtoupper($date.'-'. 1);
                      //   }
                      // }else{
                      //   $date = date('d-M-y');
                      //   //$current_date = strtoupper($date);
                      //   $purch_ref = strtoupper($date.'-'. 1);
                      // }
                ?>
                <!-- <input type="text" class="form-control" maxlength="15" name="purch_ref" id="purch_ref" value="<?php //echo $purch_ref; ?>" required readonly> -->
                <input type="text" class="form-control" maxlength="15" name="purch_ref" id="purch_ref" value="<?php echo @$auto_num['purch_ref']; ?>" required readonly>

              </div>  
            </div>
            <!-- <div class="col-sm-3">
              <div class="form-group">
                <label for="Purch Ref No" class="control-label">Purch Ref No:</label>
                  <input type="text" class="form-control" id="purch_ref" name="purch_ref" required>
              </div>
            </div> -->

            <div class="col-sm-3">
              <div class="form-group">
                <label for="">Supplier:</label>
                <select name="suplier_desc" class="form-control selectpicker" data-live-search="true" id="suplier_desc">
                <?php foreach($supplier_id as $row): ?>
                  <?php 
                    if ($row['SUPPLIER_ID'] == 7) {
                      $selected = 'selected';
                    }else{
                      $selected = '';
                    }
                  ?>
                  <option value="<?php echo @$row['SUPPLIER_ID'];?>" <?php echo $selected; ?>><?php echo @$row['COMPANY_NAME'];?></option>
                <?php endforeach;?>  
                </select>
              </div>  
            </div>
            </div>
              
              <div class="col-sm-12">
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Job No" class="control-label">Job No:</label>
                      <input type="number" class="form-control" id="job_no" name="job_no" >
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="Serial No" class="control-label">Serial No:</label>
                  
                    <input type="text" class="form-control" id="serial_no" name="serial_no" >
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="Lot Ref" class="control-label">Lot Ref:</label>
                  
                    <input type="text" class="form-control" id="lot_ref" name="lot_ref" >
                  </div>
                </div>
              
                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Purchase Date" class="control-label">Purchase Date:</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                        <input type="text" class="form-control" id="purchase_date" name="purchase_date" value="<?php echo date('m/d/Y');?>" data-date-format="mm/dd/yyyy"required>
                    </div>
                  </div>              
                </div>
              </div>
              <div class="col-sm-12">

               
                <div class="col-sm-3">
                  <div class="form-group">


                    <label for="UPC" class="control-label">UPC:</label>
                    <div class="col-sm-12" id="errorMessage_upcc" ></div>
                      <input type="number" class="form-control" id="upc" name="upc" >
                      <input type="hidden" class="form-control" id="histo_data" name="histo_data"  value ="" >


                  </div>
                <div class="historyUPC">
                  
                </div>                  
                </div>


                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Manufacture" class="control-label">Manufacture:</label>
                    
                      <input type="text" class="form-control" id="manufacturer" name="manufacturer" required>
                  </div>
                </div>                
              
                <div class="col-sm-3">
                  <div class="form-group">
                    
                    <label for="MPN" class="control-label">MPN:</label>
                    <div class="col-sm-12" id="errorMessage_mpn" ></div>
                    
                      <input type="text" class="form-control" id="part_no" name="part_no" >
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="SKU" class="control-label">SKU:</label>
                  
                    <input type="text" class="form-control" id="sku" name="sku">
                  </div>
                </div>
              </div>
              <div class="col-sm-12">
              

                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Ounces" class="control-label">Ounces:</label>
                      <input type="text" class="form-control" id="ounces" name="ounces" required>
                  </div>
                </div>

                <!-- <div class="col-sm-2">
                <div class="col-sm-10" id="errorMessage_upc"></div>
                <div class="form-group">      
                    <label for="Conditions" class="control-label">Available Conditions:</label>
                    <div id ="apnd_radi">
                    
                  </div> 
                  
                </div>
              </div> -->

              <div class="col-sm-2">
                <div class="col-sm-10" id="errorMessage_upc"></div>
                <label for="Conditions" class="control-label">Conditions:</label>
                      
                   <div class="form-group" id ="apnd_radi">
                    
                    <select class="form-control" id="default_condition" name="default_condition" value="<?php echo @$row['CONDITIONS_SEG5']; ?>" required>
                    <option value="">-Select-</option>

                    <?php
                    foreach ($cond as $val) { ?>
                      <option value="<?php echo $val['COND_NAME']; ?>"><?php echo $val['COND_NAME']; ?></option>
                    <?php } ?>
                    </div> 
                  </select>
                </div>
              </div>
              
               <!--  <div class="form-group " >
                  <label for="Packing Type" class="cotrol-label">Available Conditions:</label>
                  <div id ="apnd_radi">
                    
                  </div>                   
                </div> -->


              



              <div class="col-sm-8">
              <div class="form-group">
                <label for="Item Description" class="control-label">Title:</label>
                  <span>Maximum of 80 characters - 
                  <input class="c-count" type="text" id='titlelength' name="titlelength" size="3" maxlength="3" value="80" readonly> characters left</span><br/>                
                  <input type="text" class="form-control" id="title" name="title" onKeyDown="textCounter(this,80);" maxlength="80" onKeyUp="textCounter(this,'titlelength' ,80)" required>
                   <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_for_title">Suggest Category Against Title</a>
                </div>
              </div>
            </div>  

              <div class="col-sm-12">
                
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="object" class="control-label">Object:</label>
                      <input type="text" class="form-control" id="Object" name="Object" required>
                      <div id="object_dd" style="margin-top:5px; width: 190px;"></div>
                      <div class="col-sm-10" id="errorMessage"></div>
                  </div>
                </div>

                <div class="col-sm-2">
                   <label for="">Category ID:</label>
                  <div class="input-group input-group-md">                   
                      <input type="text" class="form-control" id="category_id" name="category_id" value="" required>
                      <div class="input-group-btn">
                        <button class="btn btn-info Serch_cond" title="Search Categories wise Conditions " id="Serch_cond" type="button"><i class="glyphicon glyphicon-search"></i></button>

                        </div>                      
                      
                  </div>
                  <button style="margin-top:5px;" type="button" title="Get Category Object" class="btn btn-success btn-xs get_new_object"   style="height: 28px; margin-bottom: auto;">Get Object</button>
                </div>


                <div class="col-sm-3">
                  <div class="form-group">
                  <label for="Main Category" class="control-label">Main Category:</label>
                  
                    <input type="text" class="form-control" id="main_category" name="main_category" >
                    <a class="crsr-pntr" title="Click here for category suggestion" id="Suggest_Categories_se">Suggest Category</a> &nbsp;&nbsp; <a href="<?php echo base_url();?>dashboard/dashboard/advance_categories" title="Click here for Advance Category Search" target="_blank">Advance Category Search</a>
                  </div>
                </div>

                <div class="col-sm-3">
                  <div class="form-group">
                    <label for="Sub Category" class="control-label">Sub Category:</label>
                  
                    <input type="text" class="form-control" id="sub_cat" name="sub_cat" >

                  </div>
                </div>

                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="Category" class="control-label">Category Name:</label>
                       <input type="text" class="form-control" id="category_name" name="category_name" required>
                  </div>
                   
                </div>
              </div>  

              <div class="col-sm-12">
                <!-- Category Result -->
                  <div id="Categories_result">
                  </div>            
                  <!-- Category Result -->  
              </div>
              <div class="col-sm-12">
                <div class="col-sm-2">
                  <div class="form-group">
                  <label for="Origin" class="control-label">Origin:</label>
                  
                    <input type="text" class="form-control" id="origin" name="origin" value="U.S" >

                  </div>
                </div> 

                <div class="col-sm-5">
                  <div class="form-group">
                    <label for="Active Price" class="control-label">Active Price $:</label>
                      <input type="number" step="0.01" min="0" class="form-control" id="active_price" name="active_price">
                  </div>
                  <a class="crsr-pntr" title="Click here for Price suggestion" id="suggest_price">Suggest Price</a> &nbsp;&nbsp; 
                    <!-- <a class="crsr-pntr" title="Click here for Advance Price Search" href="http://localhost/advance_search/advancedItemSearch.html" target="_blank">Advance Price Search</a><br> -->
                </div> 

              <!-- <div class="col-sm-3">
                <div class="form-group">
                  <label for="Sold Price" class="control-label">Sold Price:</label>
                    <input type="number" class="form-control" id="sold_price" name="sold_price" >
                </div>
              </div> -->
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="Cost Price" class="control-label">Cost $:</label>         
                    <input type="number" step="0.01" min="0" class="form-control" id="cost_price" name="cost_price" required>
                </div>
              </div>
              </div>   
              <div class="col-sm-12">

                <!--Price Result-->
                <div id="price-result">

                </div>              
                
              </div> 
              <div class="col-sm-2">
                <div class="form-group">
                <label for="Available Qty" class="control-label" style="color: red;">QUANTITY:</label>
                  <input type="number" class="form-control" id="avail_qty" name="avail_qty" required>
                </div>
              </div>
              
              <div class="col-sm-5">
                <div class="form-group">
                  <label for="Remarks" class="control-label">Remarks:</label>
                    <input type="text" class="form-control" id="remarks" name="remarks">
                </div>
              </div>
              <div class="col-sm-3">
              <div class="form-group">      
                   <label for="">Shipping Service:</label>
                  <select  class="form-control" id="shipping_service" name="shipping_service"  value="<?php //echo @$data_get['result'][0]->SHIPPING_SERVICE; ?>">
                    
                    <option value="USPSFirstClass" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSFirstClass' ){echo "selected='selected'";} ?>>USPS First Class</option>
                    <option value="USPSPriority" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriority' ){echo "selected='selected'";} ?>>USPS Priority Mail</option>
                    <option value="FedExHomeDelivery" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'FedExHomeDelivery' ){echo "selected='selected'";} ?>>FedEx Ground or FedEx Home Delivery</option>
                    <option value="USPSParcel" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSParcel' ){echo "selected='selected'";} ?>>USPSParcel</option> 
                    <option value="USPSPriorityFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Flat Rate Envelope</option>
                    <option value="USPSPriorityMailSmallFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailSmallFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Small Flat Rate Box</option> 
                    <option value="USPSPriorityFlatRateBox <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityFlatRateBox' ){echo "selected='selected'";} ?>">USPS Priority Mail Medium Flat Rate Box</option>
                    <option value="USPSPriorityMailLargeFlatRateBox" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLargeFlatRateBox' ){echo "selected='selected'";} ?>>USPS Priority Mail Large Flat Rate Box</option> 
                    <option value="USPSPriorityMailPaddedFlatRateEnvelope"<?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailPaddedFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Padded Flat Rate Envelope</option>
                    <option value="USPSPriorityMailLegalFlatRateEnvelope" <?php //if(@$data_get['result'][0]->SHIPPING_SERVICE == 'USPSPriorityMailLegalFlatRateEnvelope' ){echo "selected='selected'";} ?>>USPS Priority Mail Legal Flat Rate Envelope</option>
                     
                  </select> 
                 

              </div>
            </div> 
              <div class="col-sm-2">
                <div class="form-group">
                <label for="item_bin" class="control-label" style="color: red;">BIN:</label>
                <?php $get_bin= $this->session->userdata('item_bin'); 
                ?>
                  <input type="text" class="form-control" id="item_bin" name="item_bin" value = "<?php echo $get_bin ?>">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group p-t-24">
                <label for="Available Qty" class="control-label" style="color: red;">Skip Test:</label>
                  <input type="radio" id="skip_test" name="skip_test" value="Yes" checked>&nbsp;Yes&nbsp;&nbsp;
                  <input type="radio" id="skip_test" name="skip_test" value="No" >&nbsp;No
                </div>
              </div>&nbsp;&nbsp;&nbsp;&nbsp;


              <div class="col-sm-2">
                <div class="form-group p-t-24">
                <label for="Available Qty" class="control-label" style="color: red;">Pic Approval:</label>
                  <input type="radio" id="pic_aprov" name="pic_aprov" value="1" checked>&nbsp;Yes&nbsp;&nbsp;
                  <input type="radio" id="pic_aprov" name="pic_aprov" value="0" >&nbsp;No
                </div>
              </div>

                      
               
                <div class="col-sm-12 buttn_submit">
                  <div class="form-group">
                    <input type="submit" title="Save and Post Record" name="save" id="save" class="btn btn-success clor_chaneg" value="Save & Post">
                    <button type="button" title="Back" onclick="location.href='<?php echo base_url('single_entry/c_single_entry/filter_data') ?>'" class="btn btn-primary">Back</button>
                    <button type="button" title="Back" id = "custom"  class="btn btn-danger pull-right  custom">Reset</button>
                </div>
              </div>
          </form>
          <?php //echo form_close(); ?>
          <!-- //dekit image start -->

                  <div class="row">
                    <div class="col-sm-12">
                      <div class="col-sm-12" id="errorMessage_pic" ></div>

                        <div id="" class="col-sm-12 b-full">
                         <div id="" class="col-sm-12 docs-galley" style="padding-top: 12px;"> 
                        
                          
                           <ul id="getsortable" style="color:black; height: auto !important; width: 100%;">  
                          </ul>
                          
                        
                          </div>
                        </div>
                    </div>
                  </div>
                  <!-- //dekit image end -->
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    <div class="loader text text-center" style="display: none; position: fixed; top: 50%; left: 50%;">
      <img align="center" src="<?php echo base_url().'assets/images/ajax-loader.gif'?>" alt="ajax loader" style="width: 170px; height: 170px;">
    </div>
  </div>  


<?php $this->load->view("template/footer2.php"); ?>

<script >

  function textCounter(field,cnt, maxlimit) {         
    var cntfield = document.getElementById(cnt) 
     if (field.value.length > maxlimit) // if too long...trim it!
        field.value = field.value.substring(0, maxlimit);
        // otherwise, update 'characters left' counter
    else
    cntfield.value = maxlimit - field.value.length;
}




// $(document).on('click', '.pic_approval', function(){
//       var seed_id = $(this).attr("id");
//       $.ajax({
//       dataType: 'json',
//       type: 'POST',
//       url:'<?php //echo base_url(); ?>single_entry/c_single_entry/pic_approval',
//       data: {'seed_id' : seed_id},
//      success: function (data) {
//       //alert(data);return false;
//       if(data == true){
//         alert("Picture Has been approved"); 
//         //$("button #"+seed_id).hide();
//         return false;
//       }else if(data == false){
//         alert("Picture Has not been approved"); 
//         return false;
//       }
      
//      }
//   });
//     });

$(document).on('click','.clor_chaneg', function(){

  $('#save').removeClass('btn-success');
  $('#save').addClass('btn-default');
  });



  $(document).on('click','.get_new_object', function(){
  $(".loader").show(); 
   var cat_id = $('#category_id').val();
    if(cat_id == ''){
      $(".loader").hide(); 
      alert('Enter Category ');
      return false;
    }
   $.ajax({
        url:'<?php echo base_url(); ?>catalogueToCash/c_tl_auction/getCatObj',
        
        type:'post',
        dataType:'json',
        data:{'cat_id':cat_id},

        success:function(data){
          $(".loader").hide(); 
        if(data.length > 0){
          var html = '<select class="selectpicker form-control obj_dd " data-live-search="true" name="obj_dd" id = "obj_dd"  ><option value="0">select Object</option>';

            for(var i=0; i <data.length; i++) {
              html += '<option value="'+data[i].OBJECT_ID+'">'+data[i].OBJECT_NAME+'</option>';
            }
            html += "</select>";
            $('#object_dd').html("");
            $('#object_dd').append(html);
            $('#obj_dd').selectpicker();
            
        }else{
          $('#object_dd').html("");
           $('#errorMessage').html("");
        $('#errorMessage').append('<p style="color:#c62828; font-size :14px;"><strong>Object Not Found</strong></p>');        
         $('#errorMessage').show();
        setTimeout(function() {
          $('#errorMessage').fadeOut('slow');
        }, 1800);

        }
      }
    }); 
});

  $(document).on('change','.obj_dd', function(){ 
    var get_name = $("#obj_dd option:selected").text();
    $('#Object').val(get_name);

  });



$("#custom").click(function(){
  $(".loader").show(); 
  $('#getsortable').html("");
  $('#object_dd').html("");
  $('#Categories_result').html("");
  
$("#myForm")[0].reset();

$.ajax({
        url:'<?php echo base_url(); ?>single_entry/c_single_entry/get_loading_no',        
        type:'post',
        dataType:'json',
        data:{},

        success:function(data){ 

          $('#save').addClass('btn-success');
          $(".loader").hide();

           $("#purch_ref").val(data.purch_ref);
           $("#loading_no").val(data.load_num);            
        
      }
    });

});



</script>